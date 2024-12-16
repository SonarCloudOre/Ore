<?php

// Fonction de redirection
function redirect($url, $time=3) {
    echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="'.$url.'";</SCRIPT>';
}

//if (!isset($_SESSION['intervenant']))
{
    if (empty($_COOKIE['ore_tablets']) || !ctype_digit($_COOKIE['ore_tablets'])) {
        ajouterErreur("Vous devez être connecté pour accéder à cette page");
        include("vues/v_erreurs.php");
        include("vues/v_connexion.php");
        return;
    }

    $intervenant = $pdo->recupUnIntervenant($_COOKIE['ore_tablets']);
    if ($intervenant !== false) $_SESSION['intervenant'] = $intervenant;
    else {
        ajouterErreur("Connexion impossible");
        include("vues/v_erreurs.php");
        include("vues/v_connexion.php");
        return;
    }
    unset($intervenant);
}

$action = $_REQUEST['action'];
switch ($action) {
    case 'index':
        header('Location: index.php?choixTraitement=tablette&action=appelIntervenant');
        die();
    case 'appelStages':
        $date = date('Y-m-d');
        $moment = getMomentJournee();
        $lesStages = $pdo->getStages();
        $intervenants = $pdo->recupIntervenantsPresentDate($date, $moment);
        if (!empty($_REQUEST['stage'])) {
            --$moment;
            $idStage = (int)htmlspecialchars($_REQUEST['stage']);
            $leStage = $pdo->recupUnStage($idStage);
            $lesInscrits = $pdo->recupLesInscriptions($idStage);
            $eleves = $pdo->recupLesPresences($idStage);
            $eleves = array_filter($eleves, static function ($eleve) use ($date, $moment) {
                return $eleve['DATE_PRESENCE'] === $date && (int)$eleve['MATINOUAP'] === $moment;
            });
            $eleves = array_map(static function ($eleve) {return $eleve['ID_INSCRIPTIONS'];}, $eleves);
        }
        include("vues/tablette/v_entete_tablette.php");
        include("vues/tablette/v_appelStagesTablettes.php");
        break;
    case 'ValidAppelStages':
        $date = date('Y-m-d');
        $moment = getMomentJournee();
        $intervenants = $pdo->recupIntervenantsPresentDate($date, $moment);
        if (!empty($_REQUEST['stage']) && !empty($_REQUEST['inscription'])) {
            --$moment;
            $stage = (int)htmlspecialchars($_REQUEST['stage']);
            $inscription = (int)htmlspecialchars($_REQUEST['inscription']);
            $pdo->ajouterPresencesStage(0, date('Y-m-d'), $moment, [$inscription]);

            $leStage = $pdo->recupUnStage($stage);
            $lesInscrits = $pdo->recupLesInscriptions($stage);
            $eleves = $pdo->recupLesPresences($stage);
            $eleves = array_filter($eleves, static function ($eleve) use ($date, $moment) {
                return $eleve['DATE_PRESENCE'] === $date && (int)$eleve['MATINOUAP'] === $moment;
            });
            $eleves = array_map(function ($eleve) {return $eleve['ID_INSCRIPTIONS'];}, $eleves);
            include("vues/tablette/v_entete_tablette.php");
            echo '<h2 class="text-center">L\'appel a bien été effectué avec succès !</h2>';
            redirect("index.php?choixTraitement=tablette&action=appelStages&stage=$stage", 1);
            break;
        }
        include("vues/tablette/v_entete_tablette.php");
        echo '<h2 class="text-center text-danger">Erreur: aucun élève selectionné</h2>';
        break;
    case 'appelEleves':
        $today = getdate();
        $lesEleves = $pdo->recupTousEleves222();

        $date = date('Y-m-d');
        $moment = getMomentJournee();
        $intervenants = $pdo->recupIntervenantsPresentDate($date, $moment);
        $presents = $pdo->recupElevesPresentDate($date, $moment);
        $presents = array_map(static function ($present) {
            return $present['ID_ELEVE'];
        }, $presents);
        $eleves = $presents;

        include("vues/tablette/v_entete_tablette.php");
        include("vues/tablette/v_appelElevesTablettes.php");
        break;
    case 'ValidAppelEleves':
        include("vues/tablette/v_entete_tablette.php");

        $dateAppel = date('Y-m-d');
        $moment = getMomentJournee();

        if (!empty($_REQUEST['unEleve'])) {
            $idEleve = $_REQUEST['unEleve'];
        } else {
            echo '<h2 class="text-center text-danger">Erreur: aucun élève selectionné</h2>';
            echo '<script src="./vues/tablette/tablette.js"></script>';
            break;
        }

        // Changer la ville pour la BDD
        $pdo->setVilleExtranet('quetigny');
        $pdo->ajoutAppelEleveCase($idEleve, $dateAppel, $moment);

        echo '<h2 class="text-center text-success">Appel effectué sans erreur</h2>';
        echo '<script src="./vues/tablette/tablette.js"></script>';
        redirect('index.php?choixTraitement=tablette&action=appelEleves', "1");
        break;
    case 'prendrePhotoEleve':
        include("vues/tablette/v_entete_tablette.php");

        if (!isset($_GET['id'])) break;
        if (!isset($_GET['type'])) break;

        $idEleve = (int)$_GET['id'];
        $eleve = $pdo->getinfospersoseleves($idEleve);

        $type = htmlspecialchars($_GET['type']);
        $type = $type === 'add' ? 'Ajout' : 'Modification';

        include("vues/tablette/v_prendrePhotoEleveTablettes.php");
        break;
    case 'ChangerPhotoEleve':
        if (!isset($_POST['idEleve'], $_POST['photo'])) {
            http_response_code(400);
            echo '{"error":"Paramètre idEleve ou photo manquant"}';
            break;
        }

        $idEleve = (int)$_POST['idEleve'];
        $eleve = $pdo->getinfospersoseleves($idEleve);
        if ($eleve === false) {
            http_response_code(404);
            echo '{"error":"Elève inconnu"}';
            break;
        }

        $nomPhoto = $idEleve . '_photo_' . date('Y_m_d') . '.jpg';
        $photo = $_POST['photo'];
        $photo = preg_replace('#^data:#', 'data://', $photo, 1);

        $img = imagecreatefromjpeg($photo);
        imagejpeg($img, __DIR__ . '/../photosEleves/' . $nomPhoto);
        imagedestroy($img);

        $pdo->modifierPhotoEleve($nomPhoto, $idEleve);
        break;
    case 'appelIntervenant':
        $today = getdate();
        $anneeEnCours = $today['year'];
        if ($today['mon'] < 9) {
            $anneeEnCours--;
        }
        $lesIntervenants = $pdo->recupTousIntervenantsAnneeEnCours($anneeEnCours);

        $date = date('Y-m-d');
        $moment = getMomentJournee();
        $eleves = $pdo->recupElevesPresentDate($date, $moment);
        $presents = $pdo->recupIntervenantsPresentDate($date, $moment);
        $presents = array_map(static function ($present) {
            return $present['ID_INTERVENANT'];
        }, $presents);
        $intervenants = $presents;

        include("vues/tablette/v_entete_tablette.php");
        include("vues/tablette/v_appelIntervenantTablettes.php");
        break;
    case 'ValidAppelIntervenant':
        include("vues/tablette/v_entete_tablette.php");

        $dateAppel = date('Y-m-d');
        $heures = (int)($_REQUEST['hours'] ?? 3);
        $moment = getMomentJournee();

        if (!empty($_REQUEST['unIntervenant'])) {
            $numero = $_REQUEST['unIntervenant'];
        } else {
            echo '<h2 class="text-center text-danger">Erreur: aucun intervenant selectionné</h2>';
            echo '<script src="./vues/tablette/tablette.js"></script>';
            break;
        }

        // Changer la ville pour la BDD
        $pdo->setVilleExtranet('quetigny');
        $pdo->ajoutAppelIntervenant($numero, $dateAppel, $heures, $moment);

        echo '<h2 class="text-center text-success">Appel effectué sans erreur</h2>';
        echo '<script src="./vues/tablette/tablette.js"></script>';
        redirect('index.php?choixTraitement=tablette&action=appelIntervenant', "1");
        
        break;
    case 'appelQRCode':
        $date = date('Y-m-d');
        $moment = getMomentJournee();

        $eleves = $pdo->recupElevesPresentDate($date, $moment);
        $intervenants = $pdo->recupIntervenantsPresentDate($date, $moment);

        include("vues/tablette/v_entete_tablette.php");
        include("vues/tablette/v_appelQRCodeTablettes.php");
        break;
    case 'ValidAppelQRCode':
        $footerANePasAfficher = 1;
        $footerNePasAfficher = 1;

        $dateAppel = date('Y-m-d');
        $moment = getMomentJournee();

        $qrCode = $_POST['qrcode'];
        if (!preg_match('#^[ei]_\d+$#', $qrCode)) {
            http_response_code(400);
            echo '{"erreur":"Format de QR-Code invalide"}';
            break;
        }

        $respondNull = static function ($qrCode, $type) {
            http_response_code(404);
            echo '{"erreur":"Aucun ' . $type . ' avec ce QR-Code", "qrcode": "' . $qrCode . '"}';
        };

        if ($qrCode[0] === 'e') {
            $id = $pdo->getIdEleveQRCode($qrCode);

            if ($id === null) {
                $respondNull($qrCode, 'élève');
                break;
            }

            $pdo->ajoutAppelEleveCase($id, $dateAppel, $moment);
        } else if ($qrCode[0] === 'i') {
            $id = $pdo->getIdIntervenantQRCode($qrCode);

            if ($id === null) {
                $respondNull($qrCode, 'intervenant');
                break;
            }

            $pdo->ajoutAppelIntervenant($id, $dateAppel, 3, $moment);
        }

        echo '{"ok":1}';
        break;
    default:
        echo 'erreur d\'aiguillage !' . $action;
        break;

    
    // Case de la tablette du centre informatique
    case 'indexInfo':
        header('Location: index.php?choixTraitement=tablette&action=fichePresence');
        die();
    
    case 'fichePresence':
        // Partie "GET"
        $lesUtilisateurs = $pdo->getUtilisateurCentreInfo();
        $lesActivites = $pdo->getActivitesActives();
        // Partie "POST"    
        if (isset($_POST) && !empty($_POST)) {
            // Si on a ajouté un utilisateur
            if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telMobile'], $_POST['dateNaissance'], $_POST['lieuNaissance'], $_POST['adresse'], $_POST['codePostal'], $_POST['ville']))
            {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $telMobile = $_POST['telMobile'];
                $dateNaissance = $_POST['dateNaissance'];
                $lieuNaissance = $_POST['lieuNaissance'];
                $adresse = $_POST['adresse'];
                $codePostal = $_POST['codePostal'];
                $ville = $_POST['ville'];
                $sexe = $_POST['sexe'];

                $telFixe = $_POST['telFixe'];
                if ($telFixe == "") $telFixe = null;

                // Vérifier si le fichier a été correctement uploadé
			    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
				// Récupérer les informations sur le fichier uploadé
				$photo_tmp = $_FILES['photo']['tmp_name'];
				$photo_nom = $_FILES['photo']['name'];
				
				// Déplacer le fichier uploadé vers l'emplacement souhaité sur le serveur
				$chemin_destination = "images/utilisateurCentreInfo/" . $photo_nom;
				move_uploaded_file($photo_tmp, $chemin_destination);
				
                } else {
                    // Gérer les erreurs d'upload
                    $photo_nom = null;
                    echo "Erreur lors de l'upload du fichier.";
                }

                $pdo->ajouterUtilisateurCentreInfo($nom, $prenom, $email, $telFixe, $telMobile, $adresse, $codePostal, $ville, $dateNaissance, $lieuNaissance, $sexe, $photo_nom);
                $idUtilisateur = $pdo->getIdUtilisateurCentreInfo($email);
                $pdo->ajouterInscriptionCentreInfo($idUtilisateur);
                $idInscription = $pdo->getIdInscription($idUtilisateur);
            }

            // Si on a utilisé la recherche d'un utilisateur
            if (isset($_POST['unUtilisateur']))
            {
                $idUtilisateur = $_POST['unUtilisateur'];
                $idInscription = $pdo->getIdInscription($idUtilisateur);
            }
            
            $dateArrive = $_POST['arrive'];
            $dateSortie = $_POST['sortie'];
            $idActivite = $_POST['uneActivitee'];
            $pdo->ajouterFichePresence($idUtilisateur, $dateArrive, $dateSortie, $idActivite, $idInscription);
        }
        
        include("vues/tablette/v_entete_tabletteInfo.php");
        include("vues/tablette/v_fichePresence.php");
        break;
}
