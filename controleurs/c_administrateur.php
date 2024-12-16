<?php

// ----------------------------- FONCTIONS -------------------------------

if ($admin == "1") {
	$lesnotifs = $pdo->getfilnotif();
}
if ($admin == "2") {
	$lesnotifs = $pdo->getfilnotif();
}


// Fonction de redirection
function redirect($url, $time = 3)
{
	echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="' . $url . '";</SCRIPT>';
}

// Retourne les coordonnées GPS d'une adresse donnée
function getGps($adresse, $cp, $ville)
{

	$lat = 0;
	$lon = 0;

	$address = addslashes($adresse) . ' ' . addslashes($cp) . ' ' . addslashes($ville) . ', France';

	$request_url = "https://maps.googleapis.com/maps/api/geocode/xml?key=AIzaSyA_C2zsDEHSud_LkZbu4KuoTwyx6hIpDQU&address=" . $address . "&sensor=true";

	$xml = simplexml_load_file($request_url) or die("url not loading");

	$status = $xml->status;

	if ($status == "OK") {
		$lat = $xml->result->geometry->location->lat;
		$lon = $xml->result->geometry->location->lng;
	}

	// Retourne les coordonnées dans un tableau
	return array('lat' => $lat, 'lon' => $lon);
}


// Génére un formulaire de date (jour mois année)
function formulaireDate($jourEnCours, $moisEnCours, $anneeEnCours, $idformulaire)
{

	// Si aucun jour n'est fourni, on affiche le jour actuel
	if ($jourEnCours == 0) {
		$jourEnCours = date('j', time());
	}

	// Si aucun mois n'est fourni, on affiche le mois actuel
	if ($moisEnCours == 0) {
		$moisEnCours = date('n', time());
	}

	// Si aucun année n'est fourni, on affiche le année actuel
	if ($anneeEnCours == 0) {
		$anneeEnCours = date('Y', time());
	}

	echo '<input type="date" class="form-control" id="' . $idformulaire . '" name="' . $idformulaire . '" value="' . $anneeEnCours . '-' . $moisEnCours . '-' . $jourEnCours . '">';
}



function presencesFilter($presents)
{
}


// ----------------------------- METHODES -------------------------------


$action = $_REQUEST['action'];
switch ($action) {


	case 'ajoutIntervenantHoraireStage': {
			include('vues/v_entete.php');

			$heures = $_REQUEST["heures"];
			$stage = $_REQUEST["numStage"];
			$intervenant = $_REQUEST["idIntervenant"];
			include("v_entete.php");

			$ct = 0;
			foreach ($intervenant as $unInterv) {
				$heure =  $heures[$ct];
				if ($heure == "") {
					$heure = 0;
				}
				// echo $heure;
				$pdo->modifHeuresEffectuesStageIntervenant($stage, $unInterv, $heure);
				$ct = $ct + 1;
			}

			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $stage . '&onglet=intervenants', "1");

			break;
		}

		//Afficher les statistiques
		/*case 'StatsScolaires': {

		include("vues/v_entete.php");
		 // On récupère l'année en cours
        $anneeEnCours = $pdo->getAnneeEnCours();

        // On récupère le nom des classes
        $lesClasses = $pdo->getParametre(4);

        // On récupère les élèves de cette année et l'année dernière
        $lesEleves=$pdo->recupTousEleves222();
        $nbEleves = $pdo->nbEleves($anneeEnCours);
        $nbElevesMemeDateAnneeDerniere = $pdo->nbElevesMemeDateAnneeDerniere($anneeEnCours-1, (date('Y',time())-1).'-'.date('m-d', time()));
        if($nbEleves['COUNT(*)'] > 0) {
            $differenceEleves = round(($nbEleves['COUNT(*)'] - $nbElevesMemeDateAnneeDerniere['COUNT(*)'])  / $nbEleves['COUNT(*)'] * 100);
        } else {
            $differenceEleves = 0;
        }
        // Infos manquantes
        $photosManquantes = $pdo->photosManquantes($anneeEnCours);
        $emailsManquantes = $pdo->emailsManquantes($anneeEnCours);
        $telsManquantes = $pdo->telsManquantes($anneeEnCours);
        $adressesManquantes = $pdo->adressesManquantes($anneeEnCours);
        $lesRendezvous 	= $pdo->recupRdvParents($anneeEnCours);
        $rdvParentsManquants = $nbEleves['COUNT(*)'] - count($lesRendezvous);

        // Stats du scolaire
        $nbFamilles = $pdo->nbFamilles($anneeEnCours);
        $nbFamillesAvecRdv = $pdo->nbFamillesAvecRdv('FALSE',$anneeEnCours);
        $nbFamillesAvecRdvBsb = $pdo->nbFamillesAvecRdv('TRUE',$anneeEnCours);
        $nbFamillesMemeDateAnneeDerniere = $pdo->nbFamillesMemeDateAnneeDerniere($anneeEnCours-1, (date('Y',time())-1).'-'.date('m-d', time()));
        if($nbFamilles > 0) {
            $differenceFamilles = round(($nbFamilles - $nbFamillesMemeDateAnneeDerniere['COUNT(DISTINCT `ADRESSE_POSTALE`)'])  / $nbFamilles * 100);
        } else {
            $differenceFamilles = 0;
        }


        // Présences et inscriptions cette année
        $nbPresencesEleves = $pdo->nbPresencesEleves($anneeEnCours);
        $nbPresencesIntervenants = $pdo->nbPresencesIntervenants($anneeEnCours);
        $nbInscriptionsEleves = $pdo->nbInscriptionsEleves($anneeEnCours);

        // Moyenne des présences des élèves
        $moyennePresencesEleves = 0;
        $totalPresences = 0;
        foreach($nbPresencesEleves as $unePresence) { $totalPresences = $totalPresences + $unePresence['COUNT(*)']; }
        if($totalPresences > 0) { $moyennePresencesEleves = round($totalPresences / count($nbPresencesEleves)); }

        // Moyenne des présences des intervenants
        $moyennePresencesIntervenants = 0;
        $totalPresences = 0;
        foreach($nbPresencesIntervenants as $unePresence) { $totalPresences = $totalPresences + $unePresence['COUNT(*)']; }
        if($totalPresences > 0) { $moyennePresencesIntervenants = round($totalPresences / count($nbPresencesIntervenants)); }

        if($moyennePresencesEleves > 0 AND $moyennePresencesIntervenants > 0) {
            $nbElevesParIntervenant = round($moyennePresencesEleves / $moyennePresencesIntervenants);
        } else {
            $nbElevesParIntervenant + 0;
        }

        // Présences et inscriptions l'année d'avant
        $nbPresencesElevesAvant = $pdo->nbPresencesEleves($anneeEnCours-1);
        $nbPresencesIntervenantsAvant = $pdo->nbPresencesIntervenants($anneeEnCours-1);
        $nbInscriptionsElevesAvant = $pdo->nbInscriptionsEleves($anneeEnCours-1);

        // Compteur d'heures de présences
        /*$nbHeuresPresencesScolaireEleves = array();
        foreach($listeVilleExtranet as $laVille) {
            $nbHeuresPresencesScolaireEleves[$laVille] = $pdo->nbHeuresPresencesScolaireEleves($anneeEnCours,$laVille,1.5);
        }*/
		/*  $nbHeuresPresencesRdvBsb = $pdo->nbHeuresPresencesRdvBsb($anneeEnCours);
        //$nbHeuresPresencesScolaireIntervenants = $pdo->nbHeuresPresencesScolaireIntervenants($anneeEnCours);
        $lesStages 	= $pdo->getStages();

        // Stats sur les élèves
        $nbElevesParClasse = $pdo->nbElevesParClasse($anneeEnCours);
		$nbElevesParSexe = $pdo->nbElevesParSexe($anneeEnCours);
        $nbElevesParVille = $pdo->nbElevesParVille($anneeEnCours);
        $nbElevesParFiliere = $pdo->nbElevesParFiliere($anneeEnCours);
        $nbElevesPayes = $pdo->nbElevesPayes($anneeEnCours);

        // Rendez-vous
        $rdvParentsMercredi = $pdo->recupRdvParentsDate(date('Y-m-d', strtotime('next Wednesday')));
        $rdvParentsSamedi = $pdo->recupRdvParentsDate(date('Y-m-d', strtotime('next Saturday')));

        $rdvBsb = $pdo->recupRdvBsbSemaine();

        // On récupère la liste des activités
        $lesActivites = $pdo->info_getActivites($anneeEnCours);


		include("vues/administrateur/v_StatsScolaires.php");
		break;
	}*/

		// Changement de la ville de l'extranet
	case 'changerVilleExtranet': {

			// Le changement de ville est effectué par index.php

			// Redirection
			redirect('index.php?choixTraitement=administrateur&action=index', "1");

			// Arrêt de la boucle
			break;
		}

		// Changement de l'année de l'extranet
	case 'changerAnneeExtranet': {

			// Le changement d'année est effectué par index.php
			$_SESSION['anneeExtranet'] = $_GET['anneeExtranet'];
			// Redirection
			redirect('index.php?choixTraitement=administrateur&action=index', "1");

			// Arrêt de la boucle
			break;
		}

	case 'IntervenantCSV': {
			$anneeEnCours = $pdo->getAnneeEnCours();
			$TousIntervenant = $pdo->recupTousIntervenantsAnneeEnCours($anneeEnCours);
			include("vues/administrateur/v_IntervenantCSV.php");
			break;
		}


	case 'envoyerMail': {
			if (isset($_POST['enoyermail']) and $_POST['enoyermail'] == "enoyermail") {

				$to      = 'umutdmir07@gmail.com';
				$subject = $_POST['sujet'];
				$message = $_POST['content'] . $_POST['prenom'] . ' ' . $_POST['nom'];
				$headers = array(
					'From' => $_POST['email'],
					'Content-Type' => 'text/html',
				);

				mb_send_mail($to, $subject, $message, $headers);
				redirect('index.php?choixTraitement=administrateur&action=index');
			}
			break;
		}


	case 'IntervenantCSV': {
			$TousIntervenant = $pdo->recupTousIntervenantsAnneeEnCours($anneeEnCours);
			include("vues/administrateur/v_ContactsCSV.php");
			break;
		}


	case 'FichePresenceIntervenants': {
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$TousIntervenant = $pdo->recupTousIntervenantsAnneeEnCoursParStatut($anneeEnCours);
			$pdo->FichePresenceIntervenants($TousIntervenant);
			break;
		}

	case 'GmailCSV': {
			$adresses = $_REQUEST['adresses'];
			include("vues/administrateur/v_GmailCSV.php");
			break;
		}

	case 'Sauvegardes': {
			include("vues/v_entete.php");
			include("vues/administrateur/v_Sauvegardes.php");
			break;
		}




	case 'FaireSauvegarde': {

			$pdo->FaireSauvegarde();
			include("vues/v_entete.php");
			echo '<div id="contenu"><h3> La sauvegarde a bien été effectuée ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Sauvegardes', "1");
			break;
		}

	case 'supprimerUneSauvegarde': {
			$num = $_REQUEST['num'];
			unlink('./sauvegardes/' . $num);
			include("vues/v_entete.php");
			echo '<div id="contenu"><h3> La sauvegarde a bien été supprimée ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Sauvegardes', "1");
			break;
		}



	case 'InfosManquantes': {
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$TousIntervenant = $pdo->recupTousIntervenants();
			$lesEleves = $pdo->recupTousEleves222();
			$lesRendezvous 	= $pdo->recupRdvParents($anneeEnCours);

			$type = $_REQUEST['type'];
			$infos = $_REQUEST['infos'];

			include("vues/v_entete.php");
			include("vues/administrateur/v_InfosManquantes.php");
			break;
		}


	case 'voirAbsencesStage': {
			$footerANePasAfficher = 1;
			$footerNePasAfficher = 1;
			$lesInscriptions = $pdo->recupLesInscriptions($num);
			$lesPresences = $pdo->recupLesPresences($num);

			$num = $_REQUEST['num'];

			include("vues/v_entete.php");
			include("vues/administrateur/v_voirAbsencesStage.php");
			break;
		}


	case 'changerAtelierEleve': {
			$num = $_REQUEST['num'];
			$id_inscription = $_REQUEST['id_inscription'];
			$id_atelier = $_REQUEST['id_atelier'];
			$id_ancien_atelier = $_REQUEST['id_ancien_atelier'];

			// Si l'élève n'est pas inscrit à un atelier
			if ($id_ancien_atelier == 0) {
				$pdo->ajouterAtelierEleve($id_inscription, $id_atelier);

				// Sinon on le met à jour
			} else {
				$pdo->changerAtelierEleve($id_inscription, $id_atelier, $id_ancien_atelier);
			}

			include("vues/v_entete.php");
			echo '<div id="contenu"><h3> La modification a bien été effectuée ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $num . '&onglet=inscriptions', "1");

			break;
		}

	case 'changerValiderEleve': {
			$num = $_REQUEST['num'];
			$id_inscription = $_REQUEST['id_inscription'];
			$valide = $_REQUEST['valide'];
			if ($valide == 'on') {
				$valide = 1;
			} else {
				$valide = 0;
			}


			$pdo->changerValiderEleve($id_inscription, $valide);

			include("vues/v_entete.php");
			echo '<div id="contenu"><h3> La validation a bien été effectuée ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $num . '&onglet=inscriptions', "1");

			break;
		}


	case 'ParametresStages': {
			include("vues/v_entete.php");
			$lesStages 	= $pdo->getStages();
			$lesPartenaires = $pdo->recupPartenairesTout();
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$lesLieux = $pdo->getLieux();
			// On récupère la liste des villes
			$villesFrance = $pdo->VillesFrance();
			$lesIntervenants = $pdo->recupTousIntervenants();
			$lesIntervenantsStageTout = $pdo->recupIntervenantsStageTout();

			include("vues/administrateur/v_ParametresStages.php");
			break;
		}

	case 'Lier': {
			include("vues/v_entete.php");

			$lesStages 	= $pdo->getStages();
			$lesElevesDesStages = $pdo->recuplesElevesDesStagesTout();

			include("vues/administrateur/v_Lier.php");
			break;
		}


	case 'lierEleve': {
			include("vues/v_entete.php");

			$eleve = $_REQUEST['eleves'];
			$stage = $_REQUEST['stage'];

			$pdo->lierEleve($eleve, $stage);

			echo '<div id="contenu"><h3> La modification a bien été effectuée ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Lier', "1");


			break;
		}

	case 'ModifInscriptionStage': {
			if (isset($_REQUEST['lInscription'])) {
				$lInscription = $_REQUEST['lInscription'];
				$leStage = $_REQUEST['leStage'];

				$lesStages = $pdo->getStages();

				$lInscription = $pdo->recupUneInscription($lInscription);

				$lesAteliers = $pdo->recupAteliersStage($leStage);

				$lesGroupes = $pdo->getGroupes($leStage);
				$lesEleves = $pdo->recupTousEleves222();

				$lesEtablissements 	= $pdo->getParametre(1);
				$lesFilieres 	= $pdo->getParametre(3);
				$lesClasses 	= $pdo->getParametre(4);
				$anneeEnCours 	= $pdo->getAnneeEnCours();
			}
			include("vues/v_entete.php");
			include("vues/administrateur/v_ModifInscriptionStage.php");
			break;
		}

	case 'bordereauStage': {

			if (isset($_REQUEST['unStage'])) {
				$num = $_REQUEST['unStage'];
				$lesReglements = $pdo->getReglementsStageTrie($num);

				$pdo->bordereauStage($num, $lesReglements);
			}
			break;
		}

	case 'modifierReglementStage': {
			include("vues/v_entete.php");
			if (isset($_REQUEST['unStage']) && isset($_REQUEST['uneInscription'])) {
				$num = $_REQUEST['uneInscription'];
				$lesBanques = $pdo->getLesBanques();
				$numStage = $_REQUEST['unStage'];
				$leReglement = $pdo->getUnReglementStage($num);
				$leStage = $pdo->recupUnStage($numStage);
				$leReglementInfos = $pdo->getInfosReglementStage($leReglement['ID_INSCRIPTIONS']);
				$lesTypesReglements 	= $pdo->getParametre(5);
				$uneInscription = $pdo->recupUneInscription($num);
				$lesFratries = $pdo->recupereFratriesStage($leReglement["ID_ELEVE_STAGE"], $numStage);
				$lesFratriesReglement = [];
				$lesTarifs = $pdo->getTarifs();
				foreach ($pdo->getReglementFratrieStage($num) as $uneFratrie) {
					$lesFratriesReglement[] = $pdo->recupUneInscription($uneFratrie['ID_INSCRIPTIONS2']);
				}

				include("vues/administrateur/v_modifierReglementStage.php");
			}
			break;
		}

	case 'modifierPhotoEleve': {
			if (isset($_POST["image_webcam"])) {
				$photo = $_POST["image_webcam"];

				$num = $_POST["num"];

				$image_array_1 = explode(";", $photo);

				$image_array_2 = explode(",", $image_array_1[1]);

				$photo = base64_decode($image_array_2[1]);

				$nom_photo = $num . '_photo.png';

				file_put_contents('./photosEleves/' . $nom_photo, $photo);

				$pdo->modifierPhotoEleve($nom_photo, $num);

				//redirect("index.php?choixTraitement=administrateur&action=LesEleves");

				$eleveSelectionner = $pdo->recupUnEleves($num);

				$selectionner = "selected='selected'";
			}
			if (isset($_POST["image"])) {
				$photo = $_POST["image"];

				$num = $_POST["num"];

				$image_array_1 = explode(";", $photo);

				$image_array_2 = explode(",", $image_array_1[1]);

				$photo = base64_decode($image_array_2[1]);

				$nom_photo = $num . '_photo.png';

				file_put_contents('./photosEleves/' . $nom_photo, $photo);

				$pdo->modifierPhotoEleve($nom_photo, $num);

				//redirect("index.php?choixTraitement=administrateur&action=LesEleves");

				$eleveSelectionner = $pdo->recupUnEleves($num);

				$selectionner = "selected='selected'";
			}
			break;
		}


	case 'modifierPhotoIntervenant': {
			if (isset($_POST["image_webcam"])) {
				$photo = $_POST["image_webcam"];

				$num = $_POST["num"];

				$image_array_1 = explode(";", $photo);

				$image_array_2 = explode(",", $image_array_1[1]);

				$photo = base64_decode($image_array_2[1]);

				$nom_photo = $num . '_photo.png';

				file_put_contents('./photosIntervenants/' . $nom_photo, $photo);

				$pdo->modifierPhotoIntervenant($nom_photo, $num);

				//redirect("index.php?choixTraitement=administrateur&action=LesEleves");

				$eleveSelectionner = $pdo->recupUnIntervenant($num);

				$selectionner = "selected='selected'";
			}
			if (isset($_POST["image"])) {
				$photo = $_POST["image"];

				$num = $_POST["num"];

				$image_array_1 = explode(";", $photo);

				$image_array_2 = explode(",", $image_array_1[1]);

				$photo = base64_decode($image_array_2[1]);

				$nom_photo = $num . '_photo.png';

				file_put_contents('./photosIntervenants/' . $nom_photo, $photo);

				$pdo->modifierPhotoIntervenant($nom_photo, $num);

				//redirect("index.php?choixTraitement=administrateur&action=LesEleves");

				$IntervenantSelectionner = $pdo->recupUnIntervenant($num);

				$selectionner = "selected='selected'";
			}
			break;
		}

	case 'modifierReglementStageValidation': {
			include("vues/v_entete.php");
			if (isset($_REQUEST['id_inscription'])) {
				$num = $_REQUEST['id_inscription'];
				$numStage = $_REQUEST['id_stage'];
				$type = $_REQUEST['type'];
				$num_transaction = $_REQUEST['num_transaction'];
				$banque = htmlentities(addslashes($_REQUEST['banque']), ENT_QUOTES);
				$montant = $_REQUEST['montant'];
				$eleves = [];
				if (isset($_REQUEST['selectedEleves'])) {
					$eleves2 = explode(",", $_REQUEST['selectedEleves']);
					if (count($eleves2) > 0 and $eleves2[0] != "") {
						$eleves = $eleves2;
						unset($eleves[0]);
					}
				}
				$stage = 0;
				$stageSortie = 0;
				if (isset($_REQUEST['stage']) and $_REQUEST['stage'] == 'on') {
					$stage = 1;
				}
				if (isset($_REQUEST['stage_sortie']) and $_REQUEST['stage_sortie'] == 'on') {
					$stageSortie = 1;
				}

				$pdo->modifierReglementStage($num, $type, $num_transaction, $banque, $montant, $eleves, $stage, $stageSortie);

				echo '<div id="contenu">';
				echo ' <h3> Le réglement a bien été modifié ! </h3>';
				echo '</div>';

				redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=reglements', "1");
			}
			break;
		}

	case 'Stages': {
			$footerANePasAfficher = 1;
			$footerNePasAfficher = 1;
			$repartitionelevestageterminaleS = $pdo->repartitionelevestageterminaleS();
			$lesStages 	= $pdo->getStages();
			if (isset($_REQUEST['unStage'])) {
				$num = $_REQUEST['unStage'];
				$lesBanques = $pdo->getLesBanques();
				$stageSelectionner = $pdo->recupUnStage($num);
				$lesPartenaires = $pdo->recupPartenaires($num);
				$lesIntervenantsTout = $pdo->recupTousIntervenants();
				$lesIntervenants = $pdo->recupIntervenantsStage($num);
				$lesPartenairesTout = $pdo->recupPartenairesTout();
				$existURL = $pdo->recupUnStageURL($num);

				// Ateliers
				$lesAteliers = $pdo->recupAteliersStage($num);
				$lesGroupesAtelier = $pdo->getParametre(16);
				$inscritsAtelier = array();
				foreach ($lesAteliers as $unAtelier) {
					$inscritsAtelier[$unAtelier['ID_ATELIERS']] = $pdo->elevesInscritsAtelier($unAtelier['ID_ATELIERS']);
				}

				$lesInscriptions = $pdo->recupLesInscriptions($num);
				$nombreInscriptions = count($lesInscriptions);
				$lesInscriptionsNonPayees = [];
				$nombreInscriptionsNonPayees = 0;
				$lesInscriptionsPayees = [];
				$nombreInscriptionsPayees = 0;
				foreach ($lesInscriptions as $uneInscription) {
					if ($uneInscription['PAIEMENT_INSCRIPTIONS'] != '') {
						$uneInscription['PAIEMENTS_FRATRIES'] = [];
						$fratrie = $pdo->getReglementFratrieStage($uneInscription['ID_INSCRIPTIONS']);
						if ($fratrie !== []) {
							foreach ($fratrie as $unFratrie) {
								$nombreInscriptionsPayees++;
								$uneInscription['PAIEMENTS_FRATRIES'][] = $pdo->recupUneInscription($unFratrie['ID_INSCRIPTIONS2']);
							}
						}
						$nombreInscriptionsPayees++;
						$lesInscriptionsPayees[] = $uneInscription;
					} else {
						if (!$pdo->hasReglementFratrieStage($uneInscription['ID_INSCRIPTIONS'])) {
							$nombreInscriptionsNonPayees++;
							$lesInscriptionsNonPayees[] = $uneInscription;
						}
					}
				}

				$lesPresences = $pdo->recupLesPresences($num);
				$lesEtablissements 	= $pdo->getParametre(1);
				$lesfilieres 	= $pdo->getParametre(3);
				$lesClasses 	= $pdo->getParametre(4);
				$lesTypesReglements = $pdo->getParametre(5);
				$anneeEnCours 	= $pdo->getAnneeEnCours();
				$lesEleves = $pdo->recupTousEleves222();
				$lesLieux = $pdo->getLieux();
				$lesGroupes = $pdo->getGroupes($num);
				$participationsofImpaye = $pdo->recupParticipationsofImpaye($num);

				$types = ["annee" => $pdo->getParametre(24), "inscrit" => $pdo->getParametre(25)];
				$types = json_encode($types);
				$types = nl2br($types);

				$emailsAnnee = $pdo->recupEmailEnfantAnneeNotNull($anneeEnCours);
				$emailsAnnee[] = $pdo->recupEmailParentsAnneeNotNull($anneeEnCours);
				$emailsAnneeFinal = '';
				foreach ($emailsAnnee as $emails) {
					if (isset($emails['email_de_l_enfant'])) {
						if (!strstr($emailsAnneeFinal, $emails['email_de_l_enfant'] . ',')) {
							$emailsAnneeFinal .= $emails["email_de_l_enfant"] . ",";
						}
					} else if (isset($emails['email_des_parents'])) {
						if (!strstr($emailsAnneeFinal, $emails['email_des_parents'] . ',')) {
							$emailsAnneeFinal .= $emails["email_des_parents"] . ",";
						}
					}
				}


				$numParent = $pdo->getTelephonesParentsEleves();
				$numEleves = $pdo->getTelephonesEleves();
				$numsAnnee = [];

				foreach ($numParent as $numP) {
					$numsAnnee[] = $numP["TÉLÉPHONE_DES_PARENTS"];
				}
				foreach ($numEleves as $numE) {
					$numsAnnee[] = $numE["TÉLÉPHONE_DE_L_ENFANT"];
				}

				$numsAnnee = implode(',', $numsAnnee);


				// Recup numéro inscrits stage

				$emailsInscrit = [];

				$emailsParentsInscrit = $pdo->recupLesEmailsParentsInscritsNotNull($_REQUEST['unStage']);
				$emailsEnfantsInscrit = $pdo->recupLesEmailsEnfantsInscritsNotNull($_REQUEST['unStage']);


				foreach ($emailsParentsInscrit as $emailP) {
					if ($emailP != "" || $emailP != NULL) {
						$emailsInscrit[] = $emailP["EMAIL_PARENTS_ELEVE_STAGE"];
					}
				}
				foreach ($emailsEnfantsInscrit as $emailE) {
					if ($emailE != "" || $emailE != NULL) {
						$emailsInscrit[] = $emailE["EMAIL_ENFANT_ELEVE_STAGE"];
					}
				}

				$emailsInscrit = implode(',', $emailsInscrit);

				$numsParents = $pdo->recupLesInscriptions($_REQUEST['unStage']);
				$numEleves = $pdo->recupLesInscriptions($_REQUEST['unStage']);


				$numsInscrits = [];
				foreach ($numsParents as $numP) {
					$numsInscrits[] = $numP["TELEPHONE_PARENTS_ELEVE_STAGE"];
				}
				foreach ($numEleves as $numE) {
					$numsInscrits[] = $numE["TELEPHONE_PARENTS_ELEVE_STAGE"];
				}

				$numsInscrit = implode(',', $numsInscrits);


				$onglet = $_GET['onglet'];
				if (isset($_REQUEST["date"])) {
					echo json_encode($lesPresences);
					return;
				}
			}
			include("vues/v_entete.php");
			include("vues/administrateur/v_Stages.php");
			break;
		}

	case 'genererBordereauStage': {

			if (isset($_REQUEST['stage'])) {
				$num = $_REQUEST['stage'];
				if (isset($_REQUEST['dateDebut'])) {
					$dateDebut = $_REQUEST['dateDebut'];
				}

				if (isset($_REQUEST['dateFin'])) {
					$dateFin = $_REQUEST['dateFin'];
				}

				if (isset($_REQUEST['type'])) {
					$type = $_REQUEST['type'];
					$leTypeReglement = $pdo->getParametreId($type);
					if (isset($leTypeReglement['NOM'])) {
						$typeName = $leTypeReglement['NOM'];
					} else {
						$typeName = "Tous";
					}
				}

				//$lesInscriptions=$pdo->recupLesInscriptions($num);
				$lesReglements 	= $pdo->getLesReglementsStage($num, $dateDebut, $dateFin, $type);
				$totalReglement = count($lesReglements);
				$totalMontant = 0;
				foreach ($lesReglements as $reglement) {
					if ($reglement['MONTANT_INSCRIPTION'] != null) {
						$totalMontant += $reglement['MONTANT_INSCRIPTION'];
					}
				}

				$hasBanque = false;

				if ($typeName == "Tous" or $typeName == "Chèque") {
					$hasBanque = true;
				}

				include("vues/v_entete.php");
				include("vues/administrateur/v_BorderauxStage.php");
			} else {
				redirect("index.php?choixTraitement=administrateur&action=Stages&unStage=" . $num . "&onglet=reglements");
			}
			break;
		}

	case 'EnvoyerMailStage': {
			$footerANePasAfficher = 1;
			$footerNePasAfficher = 1;
			include(dirname(__DIR__, 1) . "/include/mail.php");
			if (isset($_POST)) {
				$r = "";
				if (isset($_POST["attachment"])) {
					$r = sendMail($_POST["recipient"], $_POST["subject"], $_POST["message"], $_POST["attachment"]);
				} else {
					$emails = explode(',', $_POST['recipient']);
					foreach ($emails as $recipient) {
						$r = sendMail($recipient, $_POST["subject"], $_POST["message"], null);
					}
				}
				echo json_encode($r);
			}
			break;
		}

	case 'saisirPresencesStage': {

			$lesStages 	= $pdo->getStages();

			if (isset($_REQUEST['num'])) {
				$num = $_REQUEST['num'];
				$stageSelectionner = $pdo->recupUnStage($num);
				$lesInscriptions = $pdo->recupLesInscriptions($num);
				$lesElevesDuStage = $pdo->recuplesElevesDesStages($num);
				$lesClasses 	= $pdo->getParametre(4);
				$anneeEnCours 	= $pdo->getAnneeEnCours();
			}
			include("vues/v_entete.php");
			include("vues/administrateur/v_saisirPresencesStage.php");
			break;
		}

	case 'saisirAbsencesStage': {
			$footerANePasAfficher = 1;
			$footerNePasAfficher = 1;
			$lesStages 	= $pdo->getStages();
			if (isset($_REQUEST['num'])) {

				$num = $_REQUEST['num'];
				$stageSelectionner = $pdo->recupUnStage($num);
				$lesInscriptions = $pdo->recupLesInscriptions($num);
				$lesElevesDuStage = $pdo->recuplesElevesDesStages($num);
				$lesClasses 	= $pdo->getParametre(4);
				$anneeEnCours 	= $pdo->getAnneeEnCours();
				$lesPresences2 = $pdo->recupLesPresences($num);
				$matinouap = array('matin', 'apres-midi');
				$lesDates = array();
				$datePrec = "";
				$matinouapPrec = "";

				foreach ($lesPresences2 as $value) {
					if ($value["DATE_PRESENCE"] != $datePrec || $value["MATINOUAP"] != $matinouapPrec) {
						$dateValue = $value["DATE_PRESENCE"] . "," . $value["MATINOUAP"];
						$date = date('d/m/Y', strtotime($value['DATE_PRESENCE'])) . ' ' . $matinouap[$value['MATINOUAP']];
						$lesDates[] =  ["display" => $date, "value" => $dateValue];
					}
					$matinouapPrec = $value["MATINOUAP"];
					$datePrec = $value["DATE_PRESENCE"];
				}
				$dateValue = "0000-00-00";
				if (isset($_REQUEST["date"])) {
					$dateValue = $_REQUEST["date"];
				}
				$date = explode(",", $dateValue);
				$matinouapDisplay = $matinouap[$date[1]];
				$matinouap = (int)$date[1];
				$date = $date[0];
				$lesPresences = $pdo->recupLesPresencesParDate($num, $date, $matinouap);

				$lesAbsents = [];
				$nomsAbsents = "";
				foreach ($lesInscriptions as $uneInscription) {
					$absent = true;
					foreach ($lesPresences as $unePresence) {
						if ($uneInscription['ID_INSCRIPTIONS'] == $unePresence['ID_INSCRIPTIONS']) {
							$absent = false;
							break;
						}
					}
					if ($absent) {
						$lesAbsents[] = $uneInscription;
						$nomsAbsents .= $uneInscription["NOM_ELEVE_STAGE"] . ";" . $uneInscription["PRENOM_ELEVE_STAGE"] . ",";
					}
				}
				$absents = '';
				$nums = '';
				foreach ($lesAbsents as $absent) {
					if (isset($absent['EMAIL_ENFANT_ELEVE_STAGE'])) {
						if (!strstr($absents, $absent['EMAIL_ENFANT_ELEVE_STAGE'])) {
							$absents .= $absent['EMAIL_ENFANT_ELEVE_STAGE'] . ',';
						}
					} else if (isset($absent['EMAIL_PARENTS_ELEVE_STAGE'])) {
						if (!strstr($absents, $absent['EMAIL_PARENTS_ELEVE_STAGE'])) {
							$absents .= $absent['EMAIL_PARENTS_ELEVE_STAGE'] . ',';
						}
					}

					if (isset($absent['TELEPHONE_ELEVE_ELEVE_STAGE'])) {
						if (!strstr($nums, $absent['TELEPHONE_ELEVE_ELEVE_STAGE'])) {
							$nums .= $absent['TELEPHONE_ELEVE_ELEVE_STAGE'] . ',';
						}
					} else if (isset($absent['TELEPHONE_PARENTS_ELEVE_STAGE'])) {
						if (!strstr($nums, $absent['TELEPHONE_PARENTS_ELEVE_STAGE'])) {
							$nums .= $absent['TELEPHONE_PARENTS_ELEVE_STAGE'] . ',';
						}
					}
				}
			}
			/*
			EMAIL_PARENTS_ELEVE_STAGE
			EMAIL_ENFANT_ELEVE_STAGE
			TELEPHONE_ELEVE_ELEVE_STAGE
			TELEPHONE_PARENTS_ELEVE_STAGE
			*/

			include("vues/v_entete.php");
			include("vues/administrateur/v_saisirAbsencesStage.php");
			break;
		}


		// Importer un élève de l'extranet
	case 'importerEleveStage': {

			include("vues/v_entete.php");

			$id_ancien = $_REQUEST['id_ancien'];
			$id_inscription = $_REQUEST['id_inscription'];
			$num = $_REQUEST['num'];
			$anneeEnCours 	= $pdo->getAnneeEnCours();

			$pdo->importerEleveStage($id_ancien, $id_inscription, $anneeEnCours);

			echo '<div id="contenu"><h3> L\'élève a bien été importé ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $num . '&onglet=inscriptions', "1");
			break;
		}

		// Importer un élève nouveau de l'extranet
	case 'importerEleveStageNouveauVue': {
			$idStage = $_REQUEST['id_stage'];
			$lesEleves = $pdo->recupTousEleves222();
			$lesInscriptions = $pdo->recupLesInscriptions($idStage);
			include("vues/v_entete.php");
			include("vues/administrateur/v_importerEleveStageNouveauVue.php");
			break;
		}

		// Importer un élève nouveau de l'extranet
	case 'importerEleveStageNouveau': {

			include("vues/v_entete.php");

			$id_ancien = $_REQUEST['id_ancien'];
			$idStage = $_REQUEST['id_stage'];
			$anneeEnCours 	= $pdo->getAnneeEnCours();

			$pdo->importerEleveStageNouveau($id_ancien, $idStage, $anneeEnCours);

			echo '<div id="contenu"><h3> L\'élève a bien été importé ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $idStage . '&onglet=inscriptions', "1");
			break;
		}



		// Importer un intervenant de l'extranet
	case 'importerIntervenantStage': {

			include("vues/v_entete.php");

			$num = $_REQUEST['intervenant'];

			$pdo->importerIntervenantStage($num);

			echo '<div id="contenu"><h3> L\'intervenant a bien été importé ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages&onglet=intervenants', "1");
			break;
		}


		// Associer un partenaire
	case 'LesPartenairesAssocier': {

			include("vues/v_entete.php");

			$partenaire = $_REQUEST['partenaire'];
			$numStage = $_REQUEST['numStage'];

			$pdo->LesPartenairesAssocier($partenaire, $numStage);

			echo '<div id="contenu"><h3> Le partenaire a bien été associé ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=partenaires', "1");
			break;
		}


		// Associer un intervenant
	case 'associerIntervenantStage': {

			include("vues/v_entete.php");

			$intervenant = $_REQUEST['intervenant'];
			$numStage = $_REQUEST['numStage'];

			$pdo->LesIntervenantsAssocier($intervenant, $numStage);

			echo '<div id="contenu"><h3> L\'intervenat a bien été associé ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=intervenants', "1");
			break;
		}



		// Dissocier un partenaire
	case 'dissocierUnPartenaire': {

			include("vues/v_entete.php");

			$partenaire = $_REQUEST['partenaire'];
			$numStage = $_REQUEST['numStage'];

			$pdo->LesPartenairesDissocier($partenaire, $numStage);

			echo '<div id="contenu"><h3> Le partenaire a bien été dissocié ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=partenaires', "1");
			break;
		}

		// Déinscrire pour un atelier
	case 'desinscrireAtelier': {

			include("vues/v_entete.php");

			$numEleve = $_REQUEST['numEleve'];
			$numAtelier = $_REQUEST['numAtelier'];
			$numStage = $_REQUEST['numStage'];

			$pdo->desinscrireAtelier($numEleve, $numAtelier);

			echo '<div id="contenu"><h3> La description a bien été supprimé ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&onglet=ateliers&unStage=' . $numStage, "1");
			break;
		}


		// Supprimerr un partenaire
	case 'supprimerPartenaire': {

			include("vues/v_entete.php");

			$partenaire = $_REQUEST['num'];

			$pdo->LesPartenairesSupprimer($partenaire);

			echo '<div id="contenu"><h3> Le partenaire a bien été supprimé ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages&onglet=partenaires', "1");
			break;
		}


		// Supprimer un intervenant des stage
	case 'supprimerIntervenantStage': {

			include("vues/v_entete.php");

			$num = $_REQUEST['num'];

			$pdo->supprimerIntervenantStage($num);

			echo '<div id="contenu"><h3> L\'intervenant a bien été supprimé des stages ! </h3></div>';
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages&onglet=intervenants', "1");
			break;
		}


		// Dissocier un partenaire
	case 'dissocierIntervenant': {

			include("vues/v_entete.php");

			$intervenant = $_REQUEST['num'];
			$numStage = $_REQUEST['numStage'];
			$pdo->LesIntervenantsDissocier($intervenant, $numStage);

			echo '<div id="contenu"><h3> L\'intervenant a bien été dissocié ! </h3></div>';
			//redirect('index.php?choixTraitement=administrateur&action=Stages&unStage='.$numStage.'&onglet=intervenants',"1");
			break;
		}


		// Modifier les infos d'un stage
	case 'LesStagesModifier': {

			include("vues/v_entete.php");

			$num = $_REQUEST['num'];
			$nom = htmlentities($_REQUEST['nom'], ENT_QUOTES);
			$annee = $_REQUEST['annee'];
			$datedeb = $_REQUEST['datedeb'];
			$datefin = $_REQUEST['datefin'];
			$datefininscrit = $_REQUEST['datefininscrit'];
			$duree_seances = $_REQUEST['duree_seances'];
			$prix = $_REQUEST['prix'];
			$prix_sortie = $_REQUEST['prix_sortie'];
			$couleur = $_REQUEST['couleur'];
			$description = htmlentities(addslashes($_REQUEST['content']), ENT_QUOTES);
			$lieu = $_REQUEST['lieu'];

			// si une image est envoyée
			if ($_FILES['image']['name'] != '') {
				$photo = $num . '_' . basename($_FILES['image']['name']);
				move_uploaded_file($_FILES['image']['tmp_name'], 'images/imageStage/' . $photo);
				$pdo->executerRequete2('UPDATE `STAGE_REVISION` SET `IMAGE_STAGE` = "' . $photo . '" WHERE `ID_STAGE` = ' . $num);
			}

			// si une affiche est envoyée
			if ($_FILES['affiche']['name'] != '') {
				$photo = $num . '_' . basename($_FILES['affiche']['name']);
				move_uploaded_file($_FILES['affiche']['tmp_name'], 'images/afficheStage/' . $photo);
				$pdo->executerRequete2('UPDATE `STAGE_REVISION` SET `AFFICHE_STAGE` = "' . $photo . '" WHERE `ID_STAGE` = ' . $num);
			}

			// si une planning est envoyée
			if ($_FILES['planning']['name'] != '') {
				$photo = $num . '_' . basename($_FILES['planning']['name']);
				move_uploaded_file($_FILES['planning']['tmp_name'], 'images/planningStage/' . $photo);
				$pdo->executerRequete2('UPDATE `STAGE_REVISION` SET `PLANNING_STAGE` = "' . $photo . '" WHERE `ID_STAGE` = ' . $num);
			}


			$evenement = $pdo->modifUnStage($num, $nom, $annee, $datedeb, $datefin, $prix, $couleur, $description, $lieu, $datefininscrit, $duree_seances, $prix_sortie);

			if ((isset($_POST["stageURL"])) && ($_POST["stageURL"] != NULL)) {
				$existURL = $pdo->recupUnStageURL($num);
				$url = $_POST["stageURL"];
				if ($existURL["STAGE"] != $num) {
					$ajoutURLStage = $pdo->ajoutUnStageURL($num, $url);
				} else {
					$modifURLStage = $pdo->modifUnStageURL($num, $url,);
				}
			}

			echo '<div id="contenu">';
			echo ' <h3> Les informations du stage ont bien été modifiés ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $num . '', "1");

			echo '</div>';
			break;
		}



		// Modifier les infos d'un atelier
	case 'LesAteliersModifier': {

			include("vues/v_entete.php");

			$num = $_REQUEST['num'];
			$numStage = $_REQUEST['numStage'];
			$groupe = $_REQUEST['groupe'];
			$nom = htmlentities(addslashes($_REQUEST['nom']), ENT_QUOTES);
			$nbmax = $_REQUEST['nbmax'];
			$niveau = $_REQUEST['niveau'];
			$description = htmlentities($_REQUEST['description'], ENT_QUOTES);

			// si une image est envoyée
			if ($_FILES['image']['name'] != '') {
				$photo = $num . '_' . basename($_FILES['image']['name']);
				move_uploaded_file($_FILES['image']['tmp_name'], 'images/ateliers/' . $photo);
				$pdo->executerRequete2('UPDATE `ATELIERS_LUDIQUES` SET `IMAGE_ATELIERS` = "' . $photo . '" WHERE `ID_ATELIERS` = ' . $num);
			}


			$evenement = $pdo->modifUnAtelier($num, $nom, $nbmax, $niveau, $description, $groupe);

			echo '<div id="contenu">';
			echo ' <h3> Les informations de l\'atelier ont bien été modifiés ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=ateliers', "1");

			echo '</div>';
			break;
		}


		// Ajouter un lieu
	case 'AjouterLieu': {
			include("vues/v_entete.php");
			$nom = htmlentities($_REQUEST['nom'], ENT_QUOTES);
			$adresse = htmlentities(addslashes($_REQUEST['adresse']), ENT_QUOTES);
			$cp = addslashes($_REQUEST['cp']);
			$ville = htmlentities(addslashes($_REQUEST['ville']), ENT_QUOTES);

			$pdo->ajouterLieu($nom, $adresse, $cp, $ville);

			echo '<div id="contenu">';
			echo ' <h3>Le lieu a bien été ajouté ! </h3>';
			echo '</div>';
			//Utilisation
			//redirect('https://association-ore.fr/extranet/index.php?choixTraitement=administrateur&action=ParametresStages&onglet=lieux',"1");
			break;
		}



		// Ajouter un partenaire
	case 'AjouterPartenaire': {
			include("vues/v_entete.php");
			$nom =  htmlentities($_REQUEST['nom'], ENT_QUOTES);
			$image = '';
			// si une image est envoyée
			if ($_FILES['image']['name'] != '') {
				$photo = time() . '_' . basename($_FILES['image']['name']);
				move_uploaded_file($_FILES['image']['tmp_name'], 'images/imagePartenaire/' . $photo);
				$image = $photo;
			}

			$pdo->ajouterPartenaire($nom, $image);

			echo '<div id="contenu">';
			echo ' <h3>Le partenaire a bien été ajouté ! </h3>';
			echo '</div>';
			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages&onglet=partenaire', "1");
			break;
		}



		// Ajouter les infos d'un atelier
	case 'LesAteliersAjouter': {

			include("vues/v_entete.php");


			$numStage = $_REQUEST['numStage'];
			$nom = htmlentities(addslashes($_REQUEST['nom']), ENT_QUOTES);
			$groupe = addslashes($_REQUEST['groupe']);
			$nbmax = $_REQUEST['nbmax'];
			$niveau = $_REQUEST['niveau'];
			$description = htmlentities(addslashes($_REQUEST['description']), ENT_QUOTES);
			$photo = '';

			// si une image est envoyée
			if ($_FILES['image']['name'] != '') {
				$photo = time() . '_' . basename($_FILES['image']['name']);
				move_uploaded_file($_FILES['image']['tmp_name'], 'images/ateliers/' . $photo);
			}

			$evenement = $pdo->ajouterUnAtelier($numStage, $nom, $nbmax, $niveau, $description, $photo, $groupe);


			echo '<div id="contenu">';
			echo ' <h3> Les informations de l\'atelier ont bien été ajoutés ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=ateliers', "1");

			echo '</div>';
			break;
		}

		// Générer une fiche de groupes pour une sortie
	case 'imprimerFicheGroupesSortie': {
			$idStage = $_REQUEST['idStage'];
			$idAtelier = $_REQUEST['idAtelier'];
			$nb = $_REQUEST['nb'];
			$lesClasses 	= $pdo->getParametre(4);

			$lesInscriptions = $pdo->elevesInscritsAtelier($idAtelier);

			//print_r($lesInscriptions);

			$pdo->imprimerFicheGroupesSortie($idStage, $idAtelier, $nb, $lesInscriptions, $lesClasses);
			break;
		}

		// Ajouter un règlement
	case 'AjouterReglementStage': {
			include("vues/v_entete.php");
			$num = $_REQUEST['eleve'];
			$numStage = $_REQUEST['numStage'];
			$unEleveStage = $pdo->recupEleveStage($num);
			$lesTypesReglements = $pdo->getParametre(5);
			$lesBanques = $pdo->getLesBanques();
			$stageSelectionner = $pdo->recupUnStage($numStage);
			$lesFratries = [];
			foreach ($pdo->recupereFratriesStage($unEleveStage['ID_ELEVE_STAGE'], $numStage) as $uneFratrie) {
				if (!$pdo->hasReglementFratrieStage($uneFratrie['ID_INSCRIPTIONS'])) {
					$lesFratries[] = $uneFratrie;
				}
			}
			include("vues/administrateur/stage/v_ajoutReglementStage.php");
			break;
		}

	case 'ValideReglementStage': {

			include("vues/v_entete.php");

			$num = $_REQUEST['eleve'];
			$numStage = $_REQUEST['numStage'];
			$type = $_REQUEST['type'];
			$num_transaction = $_REQUEST['num_transaction'];
			$banque = '';
			if (isset($_REQUEST['banque'])) {
				$banque = htmlentities(addslashes($_REQUEST['banque']), ENT_QUOTES);
			}
			$montant = $_REQUEST['montant'];
			$stage = 0;
			$stageSortie = 0;
			if (isset($_REQUEST['stage']) and $_REQUEST['stage'] == 'on') {
				$stage = 1;
			}
			if (isset($_REQUEST['stage_sortie']) and $_REQUEST['stage_sortie'] == 'on') {
				$stageSortie = 1;
			}

			$eleves = [];
			if (isset($_REQUEST['selectedEleves'])) {
				$eleves2 = explode(",", $_REQUEST['selectedEleves']);
				if (count($eleves2) > 0 and $eleves2[0] != "") {
					$eleves = array_merge($eleves, $eleves2);
				}
			}

			$pdo->AjouterReglementStage($num, $type, $num_transaction, $banque, $montant, $stage, $stageSortie, $eleves);

			echo '<div id="contenu">';
			echo ' <h3> Les informations du réglement ont bien été ajoutés ! </h3>';
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=reglements', "1");
			echo '</div>';
			break;
		}

		// Ajouter les présences d'un stage
	case 'ajouterPresencesStage': {

			include("vues/v_entete.php");

			$numStage = $_REQUEST['num'];
			$date = $_REQUEST['date'];
			$matinouap = $_REQUEST['matinouap'];
			$presences = $_REQUEST['presences'];

			$pdo->ajouterPresencesStage($numStage, $date, $matinouap, $presences);


			echo '<div id="contenu">';
			echo ' <h3> Les présences du stage ont bien été ajoutés ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=presences', "1");

			echo '</div>';
			break;
		}


		// Ajouter un groupe
	case 'creerGroupe': {

			include("vues/v_entete.php");

			$numStage = $_REQUEST['num'];
			$nom = addslashes($_REQUEST['nom']);
			$nbmax = $_REQUEST['nbmax'];
			$salles = addslashes($_REQUEST['salles']);


			$pdo->ajouterGroupe($numStage, $nbmax, $salles, $nom);


			echo '<div id="contenu">';
			echo ' <h3> Le groupe a bien été créé! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=groupes', "1");

			echo '</div>';
			break;
		}



		// Ajouter un stage
	case 'ajouterStage': {

			include("vues/v_entete.php");

			$nom = htmlentities(addslashes($_REQUEST['nom']), ENT_QUOTES);
			$annee = addslashes($_REQUEST['annee']);
			$dateDeb = addslashes($_REQUEST['datedeb']);
			$dateFin = addslashes($_REQUEST['datefin']);
			$datefininscrit = addslashes($_REQUEST['datefininscrit']);
			$duree_seances = addslashes($_REQUEST['duree_seances']);
			$prix = addslashes($_REQUEST['prix']);
			$prix_sortie = addslashes($_REQUEST['prix_sortie']);
			$lieu = addslashes($_REQUEST['lieu']);
			$couleur = addslashes($_REQUEST['couleur']);
			$description = htmlentities(addslashes($_REQUEST['content']), ENT_QUOTES);

			// si une image est envoyée
			if ($_FILES['image']['name'] != '') {
				$photo = $num . '_' . basename($_FILES['image']['name']);
				move_uploaded_file($_FILES['image']['tmp_name'], 'images/imageStage/' . $photo);
				$image = $photo;
			}

			// si une affiche est envoyée
			if ($_FILES['affiche']['name'] != '') {
				$photo = $num . '_' . basename($_FILES['affiche']['name']);
				move_uploaded_file($_FILES['affiche']['tmp_name'], 'images/afficheStage/' . $photo);
				$affiche = $photo;
			}

			// si une planning est envoyée
			if ($_FILES['planning']['name'] != '') {
				$photo = $num . '_' . basename($_FILES['planning']['name']);
				move_uploaded_file($_FILES['planning']['tmp_name'], 'images/planningStage/' . $photo);
				$planning = $photo;
			}

			$evenement = $pdo->ajouterStage($nom, $annee, $dateDeb, $dateFin, $prix, $couleur, $description, $lieu, $image, $affiche, $planning, $datefininscrit, $duree_seances, $prix_sortie);


			echo '<div id="contenu">';
			echo ' <h3> Le stage a bien été créé! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages', "1");

			echo '</div>';
			break;
		}


	case 'ajouterGroupe': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$stageSelectionner = $pdo->recupUnStage($num);
			include("vues/administrateur/v_ajouterGroupe.php");
			break;
		}


	case 'Publipostage': {
			include("vues/v_entete.php");
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			include("vues/administrateur/v_Publipostage.php");
			break;
		}


	case 'Calendrier': {
			include("vues/v_entete.php");
			//include("test.php");
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$lesRendezvous 	= $pdo->recupRdvParents($anneeEnCours);

			$lesEleves = $pdo->recupTousEleves222();
			$lesIntervenants = $pdo->recupTousIntervenantsAnneeEnCours($anneeEnCours);
			include("vues/administrateur/v_Calendrier.php");
			break;
		}

	case 'planningBSB': {
			include("vues/v_entete.php");
			//include("test.php");
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$lesRendezvous 	= $pdo->recupRdvBsb($anneeEnCours);
			$lesEleves = $pdo->recupTousEleves222();
			$lesIntervenants = $pdo->recupTousIntervenantsAnneeEnCours($anneeEnCours);
			$lesMatieres 	= $pdo->getParametre(6);
			include("vues/administrateur/v_planningBSB.php");
			break;
		}


	case 'supprimerUnFichierIntervenant': {
			include("vues/v_entete.php");
			$num = $_GET['num'];
			$fichier = $_GET['fichier'];

			$pdo->supprimerFichierIntervenant($num, $fichier);

			echo '<div id="contenu">';
			echo ' <h3> La suppression du fichier a bien été faite ! </h3>';
			echo '</div>';



			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $num . '', "1");
			break;
		}



	case 'supprimerUnStage': {
			include("vues/v_entete.php");
			$num = $_GET['num'];

			$pdo->supprimerUnStage($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression du stage a bien été faite ! </h3>';
			echo '</div>';



			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages', "1");
			break;
		}


	case 'supprimerUnReglementStage': {
			include("vues/v_entete.php");
			$num = $_GET['num'];
			$numStage = $_GET['numStage'];

			$pdo->supprimerUnReglementStage($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression du réglement a bien été faite ! </h3>';
			echo '</div>';



			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=reglements', "1");
			break;
		}


	case 'supprimerUnGroupe': {
			include("vues/v_entete.php");
			$num = $_GET['num'];
			$numStage = $_GET['numStage'];

			$pdo->supprimerGroupe($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression du groupe a bien été faite ! </h3>';
			echo '</div>';



			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=groupes', "1");
			break;
		}

	case 'ajouterEleveGroupe': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$id_inscription = $_REQUEST['id_inscription'];
			$id_groupe = $_REQUEST['id_groupe'];

			$pdo->ajouterEleveGroupe($id_inscription, $id_groupe);

			echo '<div id="contenu">';
			echo ' <h3> L\'élève a bien été ajouté au groupe ! </h3>';
			echo '</div>';



			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $num . '&onglet=inscriptions', "1");
			break;
		}


		/* Impressions */
	case 'imprimerListeEleves': {
			$num = $_REQUEST['num'];
			$lesInscriptions = $pdo->recupLesInscriptionsParGroupe($num);
			$stageSelectionner = $pdo->recupUnStage($num);
			$lesGroupes = $pdo->getGroupes($num);
			$pdo->imprimerListeEleves($num, $lesInscriptions, $stageSelectionner, $lesGroupes);

			break;
		}


		/* Impressions */
	case 'imprimerListeGroupes': {
			$num = $_REQUEST['num'];
			$stageSelectionner = $pdo->recupUnStage($num);
			$lesGroupes = $pdo->getGroupes($num);
			$pdo->imprimerListeGroupes($lesGroupes);

			break;
		}



		/* Impressions */
	case 'imprimerFichePresences': {
			$num = $_REQUEST['num'];
			$periode = $_REQUEST['periode'];
			$stageSelectionner = $pdo->recupUnStage($num);
			$lesInscriptions = $pdo->recupLesInscriptions($num);
			$lesGroupes = $pdo->getGroupes($num);
			$stageSelectionner = $pdo->recupUnStage($num);
			$pdo->imprimerFichesPresences($lesGroupes, $lesInscriptions, $stageSelectionner, $periode);

			break;
		}



		/* Impressions fiche présence scolaire */
	case 'imprimerFichePresencesScolaire': {
			$num = $_REQUEST['num'];
			$lesEleves = $pdo->recupTousEleves222();
			$lesClasses 	= $pdo->getParametre(4);
			$pdo->imprimerFichesPresencesScolaire($lesClasses, $lesEleves, $num);

			break;
		}



		/* Fiches indemnités */

	case 'FichesIndemnites': {
			include("vues/v_entete.php");

			$mois = $_REQUEST['mois'];
			$annee = $_REQUEST['annee'];
			$tarifHeure = $pdo->getParametreId(0)['NOM'];

			// On récupère tous les intervenants pour le tableau
			$Intervenants = $pdo->recupTousIntervenants();
			include("vues/administrateur/v_IndemnitesInter.php");

			break;
		}


		/*Affichage PDF*/
	case 'PrepareIndemn': {
			$mois = $_GET['mois'];
			$annee = $_GET['annee'];
			$tarif = $_REQUEST['tarif'];
			$reglement = $_REQUEST['reglement'];
			$dateReglement = $_REQUEST['dateReglement'];

			$selectionner = $_REQUEST['selectionner'];

			$lesintervenantsFiches = [];

			$i = 0;
			foreach ($selectionner as $unIntervenant) {
				$heure = $_REQUEST['heure' . $unIntervenant];
				$lintervenant = $pdo->recupUnIntervenant($unIntervenant);
				$lesintervenantsFiches[$i]['NOM'] = $lintervenant['NOM'];
				$lesintervenantsFiches[$i]['PRENOM'] = $lintervenant['PRENOM'];
				$lesintervenantsFiches[$i]['SUMH'] = $heure;
				$lesintervenantsFiches[$i]['PRELEVEMENT'] = 0;
				if (!empty($_REQUEST['pre' . $unIntervenant]))
					$lesintervenantsFiches[$i]['PRELEVEMENT'] = (float)$_REQUEST['pre' . $unIntervenant];
				$i++;
			}

			$pdo->FichesIndemnites($lesintervenantsFiches, $tarif, $mois, $annee, $reglement, $dateReglement);
			break;
		}

		/* Fiches indemnités */
	case 'PreparerFichesIndemnites': {
			include("vues/v_entete.php");
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			include("vues/administrateur/v_PreparerFichesIndemnites.php");

			break;
		}


		/* Bilan */
	case 'bilan': {
			$num = $_REQUEST['num'];

			$stageSelectionner = $pdo->recupUnStage($num);
			$lesAteliers = $pdo->recupAteliersTout();
			$lesInscriptions = $pdo->recupLesInscriptions($num);
			$lesPresences = $pdo->recupLesPresences($num);
			$lesPartenaires = $pdo->recupPartenaires($num);
			$lesElevesDuStage = $pdo->recuplesElevesDesStages($num);
			$lesEtablissements 	= $pdo->getParametre(1);
			$lesLangues 	= $pdo->getParametre(2);
			$lesfilieres 	= $pdo->getParametre(3);
			$lesClasses 	= $pdo->getParametre(4);
			$lesMatieres 	= $pdo->getParametre(6);
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$lesEvenements = $pdo->recupEvenement();
			$lesEleves = $pdo->recupTousEleves222();
			$lesLieux = $pdo->getLieux();
			$lesGroupes = $pdo->getGroupes($num);
			$lesReglements = $pdo->getReglementsStage($num);
			$lesIntervenants = $pdo->recupIntervenantsStage($num);

			include("vues/administrateur/v_Bilan.php");

			break;
		}


	case 'supprimerElevesDuGroupe': {
			include("vues/v_entete.php");
			$num = $_POST['num'];
			$numStage = $_POST['numStage'];
			$eleves = $_POST['eleves'];

			$pdo->supprimerElevesDuGroupe($num, $eleves);

			echo '<div id="contenu">';
			echo ' <h3> La suppression du/des élève(s) du groupe a bien été faite ! </h3>';
			echo '</div>';



			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=groupes', "1");
			break;
		}

	case 'Statistiques': {
			include("vues/v_entete.php");
			//v_StatsScolaires

			$moisNoms = array(
				'01' => 'Janvier',
				'02' => 'Février',
				'03' => 'Mars',
				'04' => 'Avril',
				'05' => 'Mai',
				'06' => 'Juin',
				'07' => 'Juillet',
				'08' => 'Août',
				'09' => 'Septembre',
				'10' => 'Octobre',
				'11' => 'Novembre',
				'12' => 'Décembre'
			);
			$joursNoms = array(
				'1' => 'Lundi',
				'2' => 'Mardi',
				'3' => 'Mercredi',
				'4' => 'Jeudi',
				'5' => 'Vendredi',
				'6' => 'Samedi',
				'7' => 'Dimanche'
			);


			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// On récupère le nom des classes
			$lesClasses = $pdo->getParametre(4);

			// On récupère les élèves de cette année et l'année dernière
			$lesEleves = $pdo->recupTousEleves222();
			$nbEleves = $pdo->nbEleves($anneeEnCours);
			$nbElevesMemeDateAnneeDerniere = $pdo->nbElevesMemeDateAnneeDerniere($anneeEnCours - 1, (date('Y', time()) - 1) . '-' . date('m-d', time()));
			if ($nbEleves['COUNT(*)'] > 0) {
				$differenceEleves = round(($nbEleves['COUNT(*)'] - $nbElevesMemeDateAnneeDerniere['COUNT(*)'])  / $nbEleves['COUNT(*)'] * 100);
			} else {
				$differenceEleves = 0;
			}
			// Infos manquantes
			$photosManquantes = $pdo->photosManquantes($anneeEnCours);
			$emailsManquantes = $pdo->emailsManquantes($anneeEnCours);
			$telsManquantes = $pdo->telsManquantes($anneeEnCours);
			$adressesManquantes = $pdo->adressesManquantes($anneeEnCours);
			$lesRendezvous 	= $pdo->recupRdvParents($anneeEnCours);
			$rdvParentsManquants = $nbEleves['COUNT(*)'] - count($lesRendezvous);

			// Stats du scolaire
			$nbFamilles = $pdo->nbFamilles($anneeEnCours);
			$nbFamillesAvecRdv = $pdo->nbFamillesAvecRdv('FALSE', $anneeEnCours);
			$nbFamillesAvecRdvBsb = $pdo->nbFamillesAvecRdv('TRUE', $anneeEnCours);
			$nbFamillesMemeDateAnneeDerniere = $pdo->nbFamillesMemeDateAnneeDerniere($anneeEnCours - 1, (date('Y', time()) - 1) . '-' . date('m-d', time()));
			if ($nbFamilles > 0) {
				$differenceFamilles = round(($nbFamilles - $nbFamillesMemeDateAnneeDerniere['COUNT(DISTINCT `ADRESSE_POSTALE`)'])  / $nbFamilles * 100);
			} else {
				$differenceFamilles = 0;
			}


			// Présences et inscriptions cette année
			$nbPresencesEleves = $pdo->nbPresencesEleves($anneeEnCours);
			$nbPresencesIntervenants = $pdo->nbPresencesIntervenants($anneeEnCours);
			$nbInscriptionsEleves = $pdo->nbInscriptionsEleves($anneeEnCours);

			// Moyenne des présences des élèves
			$moyennePresencesEleves = 0;
			$totalPresences = 0;
			foreach ($nbPresencesEleves as $unePresence) {
				$totalPresences = $totalPresences + $unePresence['COUNT(*)'];
			}
			if ($totalPresences > 0) {
				$moyennePresencesEleves = round($totalPresences / count($nbPresencesEleves));
			}

			// Moyenne des présences des intervenants
			$moyennePresencesIntervenants = 0;
			$totalPresences = 0;
			foreach ($nbPresencesIntervenants as $unePresence) {
				$totalPresences = $totalPresences + $unePresence['COUNT(*)'];
			}
			if ($totalPresences > 0) {
				$moyennePresencesIntervenants = round($totalPresences / count($nbPresencesIntervenants));
			}

			if ($moyennePresencesEleves > 0 and $moyennePresencesIntervenants > 0) {
				$nbElevesParIntervenant = round($moyennePresencesEleves / $moyennePresencesIntervenants);
			} else {
				$nbElevesParIntervenant + 0;
			}

			// Présences et inscriptions l'année d'avant
			$nbPresencesElevesAvant = $pdo->nbPresencesEleves($anneeEnCours - 1);
			$nbPresencesIntervenantsAvant = $pdo->nbPresencesIntervenants($anneeEnCours - 1);
			$nbInscriptionsElevesAvant = $pdo->nbInscriptionsEleves($anneeEnCours - 1);

			// Compteur d'heures de présences
			/*$nbHeuresPresencesScolaireEleves = array();
       foreach($listeVilleExtranet as $laVille) {
           $nbHeuresPresencesScolaireEleves[$laVille] = $pdo->nbHeuresPresencesScolaireEleves($anneeEnCours,$laVille,1.5);
       }*/
			$nbHeuresPresencesRdvBsb = $pdo->nbHeuresPresencesRdvBsb($anneeEnCours);
			//$nbHeuresPresencesScolaireIntervenants = $pdo->nbHeuresPresencesScolaireIntervenants($anneeEnCours);
			$lesStages 	= $pdo->getStages();

			// Stats sur les élèves
			$nbElevesParClasse = $pdo->nbElevesParClasse($anneeEnCours);
			$nbElevesParSexe = $pdo->nbElevesParSexe($anneeEnCours);
			$nbElevesParVille = $pdo->nbElevesParVille($anneeEnCours);
			$nbElevesParFiliere = $pdo->nbElevesParFiliere($anneeEnCours);
			$nbElevesParEtablissement = $pdo->nbElevesParEtablissement($anneeEnCours);
			$nbElevesPayes = $pdo->nbElevesPayes($anneeEnCours);
			$nbSexeParClasse = $pdo->nbSexeParClasse($anneeEnCours);

			// Rendez-vous
			$rdvParentsMercredi = $pdo->recupRdvParentsDate(date('Y-m-d', strtotime('next Wednesday')));
			$rdvParentsSamedi = $pdo->recupRdvParentsDate(date('Y-m-d', strtotime('next Saturday')));

			$rdvBsb = $pdo->recupRdvBsbSemaine();

			// On récupère la liste des activités
			$lesActivites = $pdo->info_getActivites($anneeEnCours);

			//v_Stats
			$lesEtablissements 	= $pdo->getParametre(1);
			$lesLangues 	= $pdo->getParametre(2);
			$lesfilieres 	= $pdo->getParametre(3);
			$lesClasses 	= $pdo->getParametre(4);
			$lesMatieres 	= $pdo->getParametre(6);
			$lesEvenements = $pdo->recupEvenement();
			$lesStages = $pdo->getStages();
			$lesAnnees = $pdo->getAnneesScolaires();
			$lesVilles = $pdo->getVilles();
			$lesStages 	= $pdo->getStages();
			include("vues/administrateur/v_Stats.php");
			break;
		}

	case 'Supprimer': {
			$type = $_GET['type'];
			$id = $_GET['id'];
			include("vues/administrateur/v_Supprimer.php?type=Avril&id=27");
			break;
		}

	case 'Avril': {
			include("vues/v_entete.php");
			include("vues/administrateur/v_Fevrier.php");
			break;
		}
	case 'ExportExcel': {
			include("vues/v_entete.php");
			include("vues/administrateur/v_ExportExcel.php");
			break;
		}
	case 'indexEnvoiMailEleves': {
			include("vues/v_entete.php");
			$lesEleves = $pdo->recupTousEleves();
			include("vues/administrateur/v_indexEmailEleves.php");
			break;
		}
	case 'validationEnvoiMailEleves': {
			include("vues/v_entete.php");

			$lesEleves = $pdo->recupTousEleves();
			$tous = $_REQUEST['tous'];
			$niveau = $_REQUEST['niveau'];
			$option = $_REQUEST['option'];
			$sujet = $_REQUEST['sujet'];

			if (get_magic_quotes_gpc()) {
				$contenu = stripslashes($_REQUEST['contenu']);
			} else {
				$contenu = $_REQUEST['contenu'];
			}

			echo $contenu;
			//copie vers ladresse
			$email = "association.ore@gmail.com";
			$headers  = "From: \"Message Envoyé à partir de votre site aux élèves\"<votresite@association-ore.fr>\n";
			$headers .= "Reply-To: association.ore@gmail.com\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
			$subject  = $sujet;
			$message  = $contenu;
			$result = mail($email, $subject, $message, $headers);


			if ($tous == 1) {
				foreach ($lesEleves as $unEleve) {
					if ($option == 1) {
						$email = $unEleve['EMAIL_DES_PARENTS'];
					}
					if ($option == 0) {
						$email = $unEleve['EMAIL_DE_L_ENFANT'];
					}
					if ($option == 2) {
						$email = $unEleve['EMAIL_DE_L_ENFANT'];
						$email2 = $unEleve['EMAIL_DES_PARENTS'];
					}

					$headers  = "From: \"ORE ASSOCIATION\"<association.ore@gmail.com>\n";
					$headers .= "Reply-To: association.ore@gmail.com\n";
					$headers .= "X-Priority: 5\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

					$subject  = $sujet;

					$message  = $contenu;

					$result = mail($email, $subject, $message, $headers);
					if ($option == 2) {
						mail($email2, $subject, $message, $headers);
					}
				}

				if ($result == true) {
					echo 'l\'email a bien été envoyé';
				} else {
					echo 'l\'email n\'a pas pu être envoyé !';
				}
			} else {
				$lesEleves = $pdo->recupTousEleves();
				foreach ($LesEleves as $unEleve) {
					$annee = date("Y");
					$mois = date("m");
					if ($mois < 7) {
						$annee = $annee - 1;
					}
					$eleve = $unEleve['ID_ELEVE'];

					$headers  = "From: \"ORE ASSOCIATION\"<association.ore@gmail.com>\n";
					$headers .= "Reply-To: association.ore@gmail.com\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
					$subject  = $sujet;
					$message  = $contenu;


					if ($option == 1) {
						$email = $unEleve['EMAIL_DES_PARENTS'];
					}
					if ($option == 0) {
						$email = $unEleve['EMAIL_DE_L_ENFANT'];
					}
					if ($option == 2) {
						$email = $unEleve['EMAIL_DE_L_ENFANT'];
						$email2 = $unEleve['EMAIL_DES_PARENTS'];
					}

					$classe = $pdo->recupClasseUnEleve($annee, $eleve);
					if ($niveau == 1) //collegiens
					{
						if ($classe['ID_CLASSE'] <= 53) {
							$result = mail($email, $subject, $message, $headers);
							if ($option == 2) {
								mail($email2, $subject, $message, $headers);
							}
						}
					} else //lyceens
					{
						if ($classe['ID_CLASSE'] >= 53) {
							$result = mail($email, $subject, $message, $headers);
							if ($option == 2) {
								mail($email2, $subject, $message, $headers);
							}
						}
					}



					if ($result == true) {
						echo 'l\'email a bien été envoyé';
					} else {
						echo 'l\'email n\'a pas pu être envoyé !';
					}
				}
			}


			break;
		}


	case 'indexEnvoiMailIntervenant': {
			include("vues/v_entete.php");
			$lesIntervenants = $pdo->recupTousIntervenants();
			include("vues/administrateur/v_indexEmailIntervenant.php");
			break;
		}
	case 'validationEnvoiMailIntervenant': {
			include("vues/v_entete.php");

			$lesIntervenants = $pdo->recupTousIntervenants();
			$tous = $_REQUEST['tous'];
			$sujet = $_REQUEST['sujet'];

			if (get_magic_quotes_gpc()) {
				$contenu = stripslashes($_REQUEST['contenu']);
			} else {
				$contenu = $_REQUEST['contenu'];
			}

			$unIntervenantSelect = $_REQUEST['unIntervenant'];
			$email = $unIntervenant['EMAIL'];
			echo $contenu;

			//copie vers ladresse
			$email = "association.ore@gmail.com";
			$headers  = "From: \"Message Envoyé à partir de votre site aux intervenants\"<votresite@association-ore.fr>\n";
			$headers .= "Reply-To: association.ore@gmail.com\n";
			$headers .= "X-Priority: 5\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

			$subject  = $sujet;

			$message  = $contenu;

			$result = mail($email, $subject, $message, $headers);

			if ($tous == 1) {
				foreach ($lesIntervenants as $unIntervenant) {
					$email = $unIntervenant['EMAIL'];
					$headers  = "From: \"ORE ASSOCIATION\"<association.ore@gmail.com>\n";
					$headers .= "Reply-To: association.ore@gmail.com\n";
					$headers .= "X-Priority: 5\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

					$subject  = $sujet;

					$message  = $contenu;

					$result = mail($email, $subject, $message, $headers);
					if ($result == true) {
						echo 'l\'email a bien été envoyé';
					} else {
						echo 'l\'email n\'a pas pu être envoyé !';
					}
				}
			} else {
				foreach ($unIntervenantSelect as $email) {
					$headers  = "From: \"ORE ASSOCIATION\"<association.ore@gmail.com>\n";
					$headers .= "Reply-To: association.ore@gmail.com\n";
					$headers .= "X-Priority: 5\n";
					$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

					$subject  = $sujet;

					$message  = $contenu;

					$result = mail($email, $subject, $message, $headers);


					if ($result == true) {
						echo 'l\'email a bien été envoyé';
					} else {
						echo 'l\'email n\'a pas pu être envoyé !';
					}
				}
			}

			break;
		}
	case 'index': {
			include("vues/v_entete.php");

			//StatsActivitésInfo

			// On récupère le numéro de l'activité
			$num = 3; //3 est le cours d'informatique

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// On récupère la liste des activités
			$lesActivites = $pdo->info_getActivites($anneeEnCours);

			// On récupère la liste des inscriptions à cette activité
			$lesInscriptions = $pdo->info_getInscriptionsPourUneActivite($num, $anneeEnCours);

			// On récupère la liste des inscriptions totales
			$lesInscriptionsTotales = $pdo->info_getInscriptions($anneeEnCours);

			$nbInscrits = 0;
			foreach ($lesInscriptions as $uneInscription) {
				$nbInscrits++;
			}

			// On récupère les données de l'activité donnée
			$activiteSelectionner = $pdo->info_getActivite(10);

			// Savoir si c'est l'accès libre
			$idAccesLibre = $pdo->info_getIdAccesLibre();

			if ($idAccesLibre['VALEUR'] == $activiteSelectionner['id_activite']) {
				$estAccesLibre = true;
			} else {
				$estAccesLibre = false;
			}

			// On récupère la liste des années de l'activité
			$lesAnnees = $pdo->info_getActiviteAnnees($num);

			// On récupère la liste des présences à cette activité
			$lesPresences = $pdo->info_getPresencesPourUneActivite($num);

			// On récupère la liste des réglements à cette activité
			$lesReglements = $pdo->info_getReglements($num);

			// On récupère les types de réglement
			$lesTypesReglements = $pdo->getParametre(5);

			// ---- Statistiques ----

			// Liste des présences
			$stats_totalPresences = $pdo->info_getTotalPresences($num, $anneeEnCours);

			// Répartition par sexe
			$stats_repartitionSexe = $pdo->info_getRepartitionSexe($num, $anneeEnCours);

			// Répartition par ville
			$stats_repartitionVille = $pdo->info_getRepartitionVille($num, $anneeEnCours);

			// Répartition par age
			$stats_repartitionAge = $pdo->info_getRepartitionAge($num, $anneeEnCours);

			// Si accès libre
			if ($estAccesLibre) {

				// Répartition des visites par PC
				$stats_repartitionPC = $pdo->info_getStatsPC($anneeEnCours);
			}

			// Calcul des présences
			$totalPresences = 0;
			$nbDates = 0;
			foreach ($stats_totalPresences as $unePresence) {
				$totalPresences = ($totalPresences + $unePresence['COUNT(*)']);
				$nbDates++;
			}

			// Calcul de la moyenne des présences
			if ($nbDates == 0) {
				$stats_moyennePresences = 0;
			} else {
				$stats_moyennePresences = round($totalPresences / $nbDates);
			}

			//FIN StatsActivitésInfo

			//v_StatsScolaires

			$moisNoms = array(
				'01' => 'Janvier',
				'02' => 'Février',
				'03' => 'Mars',
				'04' => 'Avril',
				'05' => 'Mai',
				'06' => 'Juin',
				'07' => 'Juillet',
				'08' => 'Août',
				'09' => 'Septembre',
				'10' => 'Octobre',
				'11' => 'Novembre',
				'12' => 'Décembre'
			);
			$joursNoms = array(
				'1' => 'Lundi',
				'2' => 'Mardi',
				'3' => 'Mercredi',
				'4' => 'Jeudi',
				'5' => 'Vendredi',
				'6' => 'Samedi',
				'7' => 'Dimanche'
			);


			// On récupère le nom des classes
			$lesClasses = $pdo->getParametre(4);

			// On récupère les élèves de cette année et l'année dernière
			$lesEleves = $pdo->recupTousEleves222();
			$nbEleves = $pdo->nbEleves($anneeEnCours);
			$nbElevesMemeDateAnneeDerniere = $pdo->nbElevesMemeDateAnneeDerniere($anneeEnCours - 1, (date('Y', time()) - 1) . '-' . date('m-d', time()));
			if ($nbEleves['COUNT(*)'] > 0) {
				$differenceEleves = round(($nbEleves['COUNT(*)'] - $nbElevesMemeDateAnneeDerniere['COUNT(*)'])  / $nbEleves['COUNT(*)'] * 100);
			} else {
				$differenceEleves = 0;
			}
			// Infos manquantes
			$photosManquantes = $pdo->photosManquantes($anneeEnCours);
			$emailsManquantes = $pdo->emailsManquantes($anneeEnCours);
			$telsManquantes = $pdo->telsManquantes($anneeEnCours);
			$adressesManquantes = $pdo->adressesManquantes($anneeEnCours);
			$lesRendezvous 	= $pdo->recupRdvParents($anneeEnCours);
			$rdvParentsManquants = $nbEleves['COUNT(*)'] - count($lesRendezvous);

			// Stats du scolaire
			$nbFamilles = $pdo->nbFamilles($anneeEnCours);
			$nbFamillesAvecRdv = $pdo->nbFamillesAvecRdv('FALSE', $anneeEnCours);
			$nbFamillesAvecRdvBsb = $pdo->nbFamillesAvecRdv('TRUE', $anneeEnCours);
			$nbFamillesMemeDateAnneeDerniere = $pdo->nbFamillesMemeDateAnneeDerniere($anneeEnCours - 1, (date('Y', time()) - 1) . '-' . date('m-d', time()));
			if ($nbFamilles > 0) {
				$differenceFamilles = round(($nbFamilles - $nbFamillesMemeDateAnneeDerniere['COUNT(DISTINCT `ADRESSE_POSTALE`)'])  / $nbFamilles * 100);
			} else {
				$differenceFamilles = 0;
			}


			// Présences et inscriptions cette année
			$nbPresencesEleves = $pdo->nbPresencesEleves($anneeEnCours);
			$nbPresencesIntervenants = $pdo->nbPresencesIntervenants($anneeEnCours);
			$nbInscriptionsEleves = $pdo->nbInscriptionsEleves($anneeEnCours);

			// Moyenne des présences des élèves
			$moyennePresencesEleves = 0;
			$totalPresences = 0;
			foreach ($nbPresencesEleves as $unePresence) {
				$totalPresences = $totalPresences + $unePresence['COUNT(*)'];
			}
			if ($totalPresences > 0) {
				$moyennePresencesEleves = round($totalPresences / count($nbPresencesEleves));
			}

			// Moyenne des présences des intervenants
			$moyennePresencesIntervenants = 0;
			$totalPresences = 0;
			foreach ($nbPresencesIntervenants as $unePresence) {
				$totalPresences = $totalPresences + $unePresence['COUNT(*)'];
			}
			if ($totalPresences > 0) {
				$moyennePresencesIntervenants = round($totalPresences / count($nbPresencesIntervenants));
			}

			if ($moyennePresencesEleves > 0 and $moyennePresencesIntervenants > 0) {
				$nbElevesParIntervenant = round($moyennePresencesEleves / $moyennePresencesIntervenants);
			} else {
				$nbElevesParIntervenant + 0;
			}

			// Présences et inscriptions l'année d'avant
			$nbPresencesElevesAvant = $pdo->nbPresencesEleves($anneeEnCours - 1);
			$nbPresencesIntervenantsAvant = $pdo->nbPresencesIntervenants($anneeEnCours - 1);
			$nbInscriptionsElevesAvant = $pdo->nbInscriptionsEleves($anneeEnCours - 1);

			// Compteur d'heures de présences
			/*$nbHeuresPresencesScolaireEleves = array();
       foreach($listeVilleExtranet as $laVille) {
           $nbHeuresPresencesScolaireEleves[$laVille] = $pdo->nbHeuresPresencesScolaireEleves($anneeEnCours,$laVille,1.5);
       }*/
			$nbHeuresPresencesRdvBsb = $pdo->nbHeuresPresencesRdvBsb($anneeEnCours);
			//$nbHeuresPresencesScolaireIntervenants = $pdo->nbHeuresPresencesScolaireIntervenants($anneeEnCours);
			$lesStages 	= $pdo->getStages();

			// Stats sur les élèves
			$nbElevesParClasse = $pdo->nbElevesParClasse($anneeEnCours);
			$nbElevesParSexe = $pdo->nbElevesParSexe($anneeEnCours);
			$nbElevesParVille = $pdo->nbElevesParVille($anneeEnCours);
			$nbElevesParFiliere = $pdo->nbElevesParFiliere($anneeEnCours);
			$nbElevesParEtablissement = $pdo->nbElevesParEtablissement($anneeEnCours);
			$nbElevesPayes = $pdo->nbElevesPayes($anneeEnCours);
			$nbSexeParClasse = $pdo->nbSexeParClasse($anneeEnCours);

			// Rendez-vous
			$rdvParentsMercredi = $pdo->recupRdvParentsDate(date('Y-m-d', strtotime('next Wednesday')));
			$rdvParentsSamedi = $pdo->recupRdvParentsDate(date('Y-m-d', strtotime('next Saturday')));

			$rdvBsb = $pdo->recupRdvBsbSemaine();

			// On récupère la liste des activités
			$lesActivites = $pdo->info_getActivites($anneeEnCours);

			//v_Stats
			$lesEtablissements 	= $pdo->getParametre(1);
			$lesLangues 	= $pdo->getParametre(2);
			$lesfilieres 	= $pdo->getParametre(3);
			$lesClasses 	= $pdo->getParametre(4);
			$lesMatieres 	= $pdo->getParametre(6);
			$lesEvenements = $pdo->recupEvenement();
			$lesStages = $pdo->getStages();
			$lesAnnees = $pdo->getAnneesScolaires();
			$lesVilles = $pdo->getVilles();
			$lesStages 	= $pdo->getStages();
			//FIN v_StatsScolaires

			// On récupère le nom des classes
			$lesClasses = $pdo->getParametre(4);

			// On récupère les élèves de cette année et l'année dernière
			$lesEleves = $pdo->recupTousEleves222();
			$nbEleves = $pdo->nbEleves($anneeEnCours);
			$nbElevesMemeDateAnneeDerniere = $pdo->nbElevesMemeDateAnneeDerniere($anneeEnCours - 1, (date('Y', time()) - 1) . '-' . date('m-d', time()));
			if ($nbEleves['COUNT(*)'] > 0) {
				$differenceEleves = round(($nbEleves['COUNT(*)'] - $nbElevesMemeDateAnneeDerniere['COUNT(*)'])  / $nbEleves['COUNT(*)'] * 100);
			} else {
				$differenceEleves = 0;
			}
			// Infos manquantes
			$photosManquantes = $pdo->photosManquantes($anneeEnCours);
			$emailsManquantes = $pdo->emailsManquantes($anneeEnCours);
			$telsManquantes = $pdo->telsManquantes($anneeEnCours);
			$adressesManquantes = $pdo->adressesManquantes($anneeEnCours);
			$lesRendezvous 	= $pdo->recupRdvParents($anneeEnCours);
			$rdvParentsManquants = $nbEleves['COUNT(*)'] - count($lesRendezvous);

			// Stats du scolaire
			$nbFamilles = $pdo->nbFamilles($anneeEnCours);
			$nbFamillesAvecRdv = $pdo->nbFamillesAvecRdv('FALSE', $anneeEnCours);
			$nbFamillesAvecRdvBsb = $pdo->nbFamillesAvecRdv('TRUE', $anneeEnCours);
			$nbFamillesMemeDateAnneeDerniere = $pdo->nbFamillesMemeDateAnneeDerniere($anneeEnCours - 1, (date('Y', time()) - 1) . '-' . date('m-d', time()));
			if ($nbFamilles > 0) {
				$differenceFamilles = round(($nbFamilles - $nbFamillesMemeDateAnneeDerniere['COUNT(DISTINCT `ADRESSE_POSTALE`)'])  / $nbFamilles * 100);
			} else {
				$differenceFamilles = 0;
			}


			// Présences et inscriptions cette année
			$nbPresencesEleves = $pdo->nbPresencesEleves($anneeEnCours);
			$nbPresencesIntervenants = $pdo->nbPresencesIntervenants($anneeEnCours);
			$nbInscriptionsEleves = $pdo->nbInscriptionsEleves($anneeEnCours);

			// Moyenne des présences des élèves
			$moyennePresencesEleves = 0;
			$totalPresences = 0;
			foreach ($nbPresencesEleves as $unePresence) {
				$totalPresences = $totalPresences + $unePresence['COUNT(*)'];
			}
			if ($totalPresences > 0) {
				$moyennePresencesEleves = round($totalPresences / count($nbPresencesEleves));
			}

			// Moyenne des présences des intervenants
			$moyennePresencesIntervenants = 0;
			$totalPresences = 0;
			foreach ($nbPresencesIntervenants as $unePresence) {
				$totalPresences = $totalPresences + $unePresence['COUNT(*)'];
			}
			if ($totalPresences > 0) {
				$moyennePresencesIntervenants = round($totalPresences / count($nbPresencesIntervenants));
			}

			if ($moyennePresencesEleves > 0 and $moyennePresencesIntervenants > 0) {
				$nbElevesParIntervenant = round($moyennePresencesEleves / $moyennePresencesIntervenants);
			} else {
				$nbElevesParIntervenant + 0;
			}

			// Présences et inscriptions l'année d'avant
			$nbPresencesElevesAvant = $pdo->nbPresencesEleves($anneeEnCours - 1);
			$nbPresencesIntervenantsAvant = $pdo->nbPresencesIntervenants($anneeEnCours - 1);
			$nbInscriptionsElevesAvant = $pdo->nbInscriptionsEleves($anneeEnCours - 1);

			// Compteur d'heures de présences
			/*$nbHeuresPresencesScolaireEleves = array();
        foreach($listeVilleExtranet as $laVille) {
            $nbHeuresPresencesScolaireEleves[$laVille] = $pdo->nbHeuresPresencesScolaireEleves($anneeEnCours,$laVille,1.5);
        }*/
			$nbHeuresPresencesRdvBsb = $pdo->nbHeuresPresencesRdvBsb($anneeEnCours);
			//$nbHeuresPresencesScolaireIntervenants = $pdo->nbHeuresPresencesScolaireIntervenants($anneeEnCours);
			$lesStages 	= $pdo->getStages();

			// Stats sur les élèves
			$nbElevesParClasse = $pdo->nbElevesParClasse($anneeEnCours);
			$nbElevesParSexe = $pdo->nbElevesParSexe($anneeEnCours);
			$nbElevesParVille = $pdo->nbElevesParVille($anneeEnCours);
			$nbElevesParFiliere = $pdo->nbElevesParFiliere($anneeEnCours);
			$nbElevesParEtablissement = $pdo->nbElevesParEtablissement($anneeEnCours);
			$nbElevesPayes = $pdo->nbElevesPayes($anneeEnCours);
			$nbSexeParClasse = $pdo->nbSexeParClasse($anneeEnCours);

			// Rendez-vous
			$rdvParentsMercredi = $pdo->recupRdvParentsDate(date('Y-m-d', strtotime('next Wednesday')));
			$rdvParentsSamedi = $pdo->recupRdvParentsDate(date('Y-m-d', strtotime('next Saturday')));

			$rdvBsb = $pdo->recupRdvBsbSemaine();

			// On récupère la liste des activités
			$lesActivites = $pdo->info_getActivites($anneeEnCours);
			$nbEleveSoutien = 0;
			$nbAdherents = 0;
			$nbAdherentsCaf = 0;
			$nbFamillesTotal = (int)$nbEleves["COUNT(*)"];
			$pdo->nbElevesAdherents($anneeEnCours, $nbAdherents, $nbAdherentsCaf, $nbFamillesTotal, $nbEleveSoutien);
			include("vues/administrateur/v_accueil.php");
			break;
		}
	case 'presencesIntervenantsA': {
			include("vues/v_entete.php");


			echo "<h4>Planning des Intervenants confirmant leurs présences pour les séances des 30 jours à venir...</h4>";
			echo '<table> <tr>';
			for ($i = 0; $i < 30; $i++) {
				$dateCircuit = date('d-m-Y', strtotime('+' . $i . ' day'));

				// extraction des jour, mois, an de la date
				list($jour, $mois, $annee) = explode('-', $dateCircuit);
				// calcul du timestamp
				$timestamp = mktime(0, 0, 0, $mois, $jour, $annee);
				$dateEnglish = $annee . "-" . $mois . "-" . $jour;

				// affichage du jour de la semaine
				$jour = date("w", $timestamp);


				if ($jour == 3) //si mercredi
				{
					echo '<table cellspacing="0" cellpadding="3px" rules="rows"
   style="border:solid 1px #777777; border-collapse:collapse; font-family:verdana; font-size:11px;">';
					echo "<tr style='background-color:lightgrey;'><th style='width:100px;'> Mercredi " . $dateCircuit . "</th></tr>";
					$recupIntervenants = $pdo->recupIntervenants($dateEnglish);
					if ($recupIntervenants != array()) {
						foreach ($recupIntervenants as $ligne) {
							echo "<tr><td>" . $ligne['NOM'] . " " . $ligne['PRENOM'] . "</td></tr>";
						}
					} else {
						echo "<tr><td>Personne à cette date</td></tr>";
					}

					echo "</table>";
				}

				if ($jour == 6) // si samedi
				{
					echo '<table cellspacing="0" cellpadding="3px" rules="rows"
   style="border:solid 1px #777777; border-collapse:collapse; font-family:verdana; font-size:11px;">';
					echo "<tr style='background-color:lightgrey;'><th style='width:100px;'> Samedi " . $dateCircuit . "</th></tr>";
					$recupIntervenants = $pdo->recupIntervenants($dateEnglish);
					if ($recupIntervenants != array()) {
						foreach ($recupIntervenants as $ligne) {
							echo "<tr><td>" . $ligne['NOM'] . " " . $ligne['PRENOM'] . "</td></tr>";
						}
					} else {
						echo "<tr><td>Personne à cette date</td></tr>";
					}

					echo "</table>";
				}
			}
			echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
			break;
		}

	case 'ValidationPresenceIntervenant': {

			include("vues/v_entete.php");


			$date = $_REQUEST['date'];
			$numIntervenant = $_REQUEST['intervenant'];

			foreach ($numIntervenant as $valeur) {
				$date = date("Y-m-d", strtotime($date));
				$pdo->modifPlanning($valeur, $date);
			}

			echo "<center><h3>Validation des présences pris en compte.</h3></center>";
			break;
		}

	case 'ValidationPresence': {
			include("vues/v_entete.php");
			$jour = $_REQUEST['jour'];
			$mois = $_REQUEST['mois'];
			$annee = $_REQUEST['annee'];
			$seance = $_REQUEST['seance'];

			if ($seance != '--') {
				$heures = $pdo->getHeuresSeance($seance);
			}

			include("vues/administrateur/v_ValidationPresence.php");

			/*
		echo "<h4>Planning des Intervenants confirmant leurs présences pour les séances des 30 jours à venir...</h4>";
		echo '<table> <tr>';
           for($i=0;$i<30;$i++)
	  {
		    $dateCircuit = date('d-m-Y', strtotime('+'.$i.' day'));

			// extraction des jour, mois, an de la date
			list($jour, $mois, $annee) = explode('-', $dateCircuit);
			// calcul du timestamp
			$timestamp = mktime (0, 0, 0, $mois, $jour, $annee);
			$dateEnglish = $annee."-".$mois."-".$jour;
			// affichage du jour de la semaine
			$jour=date("w",$timestamp);


		  if($jour==3) //si mercredi
		  {
			  echo '<table cellspacing="0" cellpadding="3px" rules="rows"
   style="border:solid 1px #777777; border-collapse:collapse; font-family:verdana; font-size:11px;">';
  			  echo'    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=ValidationPresenceIntervenant"> ';

			  echo "<tr style='background-color:lightgrey;'><th style='width:20px;'></th><th style='width:100px;'> Mercredi ".$dateCircuit."</th></tr>";

			  echo "<input name='date' type='text' hidden='hidden' value='".$dateCircuit."'  />";

			  $recupIntervenants=$pdo->recupIntervenantsSansValider($dateEnglish);
			  if ($recupIntervenants!=array()){
				  foreach($recupIntervenants as $ligne)
				  {
					  echo "<tr><td><input name='intervenant[]' type='checkbox' value='".$ligne['ID_INTERVENANT']."'  /></td><td>".$ligne['NOM']." ".$ligne['PRENOM']."</td></tr>";
				  }
			  }
			  else
			  {
				  	  echo "<tr><td>Personne à cette date</td></tr>";
			  }
			  echo"<tr><td></td><td><input type='submit' value='Envoyer' /></td>";
			  echo "</table></form>";
		  }

		   if($jour==6) // si samedi
		  {
			   echo '<table cellspacing="0" cellpadding="3px" rules="rows"
   style="border:solid 1px #777777; border-collapse:collapse; font-family:verdana; font-size:11px;">';
      echo'    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=ValidationPresenceIntervenant"> ';

			  echo "<tr style='background-color:lightgrey;'><th style='width:20px;'></th><th style='width:100px;'> Samedi ".$dateCircuit."</th></tr>";
			  echo "<input name='date' type='text' hidden='hidden' value='".$dateCircuit."'  />";

			  $recupIntervenants=$pdo->recupIntervenantsSansValider($dateEnglish);
			  if ($recupIntervenants!=array()){
				  foreach($recupIntervenants as $ligne)
				  {
					  echo "<tr><td><input name='intervenant[]' type='checkbox' value='".$ligne['ID_INTERVENANT']."'  /></td><td>".$ligne['NOM']." ".$ligne['PRENOM']."</td></tr>";
				  }
			  }
			  else
			  {
				  	  echo "<tr><td>Personne à cette date</td></tr>";
			  }
			  			  echo"<tr><td></td><td><input type='submit' value='Envoyer' /></td>";

			  echo "</table></form>";
		  }

	  }
     echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	 */
			break;
		}

	case 'appelIntervenant': {
			include("vues/v_entete.php");

			$anneeEnCours = $pdo->getAnneeEnCours();

			$rd = false;
			$laDate = date('Y-m-d');
			if (isset($_POST['dateAppel'])) {
				$laDate = $_POST['dateAppel'];
				$rd = true;
			} elseif (isset($_GET['date'])) {
				$laDate = htmlspecialchars($_GET['date']);
			}

			$moment = getMomentJournee();
			if (isset($_POST['moment']) && in_array($_POST['moment'], ['1', '2'], true)) {
				$moment = (int)$_POST['moment'];
				$rd = true;
			} elseif (isset($_GET['moment']) && in_array($_GET['moment'], ['1', '2'], true)) {
				$moment = (int)$_GET['moment'];
			}

			if ($rd) {
				redirect('index.php?choixTraitement=administrateur&action=appelIntervenant&date=' . $laDate . '&moment=' . $moment, 1);
				break;
			}

			$lesIntervenants = $pdo->recupTousIntervenantsAnneeEnCours($anneeEnCours);
			$presents = $pdo->recupIntervenantsPresentDate($laDate, $moment);
			// Compatibilité pour les présences ayant un ID_MOMENT à NULL
			$presents2 = $pdo->recupIntervenantsPresentDate($laDate, null);
			$presents = array_merge($presents, $presents2);
			$presents = array_combine(
				array_map(static function ($present) {
					return $present['ID_INTERVENANT'];
				}, $presents),
				array_map(static function ($present) {
					return (int)$present['HEURES'];
				}, $presents)
			);

			include("vues/administrateur/v_appelIntervenant.php");
			break;
		}

	case 'valideAppelIntervenants': {
			include("vues/v_entete.php");
			$dateAppel = $_REQUEST['laDate'];
			//$dateAppel = dateFrancaisVersAnglais($dateAppel);
			$appel = $_REQUEST['appel'] ?? [];
			$moment = getMomentJournee();

			foreach ($appel as $unIntervenant) {
				$numero = $unIntervenant;
				$heure = $_REQUEST['heure' . $unIntervenant];
				$pdo->ajoutAppelIntervenant($numero, $dateAppel, $heure, $moment);
			}

			echo "<h2 class='text-center' color='green'>L'appel pour les intervenants a bien été fait et sans erreurs.</h2>";
			break;
		}

	case 'appelElevesCase': {

			include("vues/v_entete.php");
			$lesEleves = $pdo->recupTousEleves222();
			$lesClasses 	= $pdo->getParametre(4);
			include("vues/administrateur/v_appelElevesCase.php");

			break;
		}


	case 'importerEleve': {

			include("vues/v_entete.php");
			$lesEleves = $pdo->recupTousEleves222();

			// Si une exportation est demandée
			if (isset($_REQUEST['unEleve'])) {


				$unEleve = $_REQUEST['unEleve'];
				$uneVille = $_REQUEST['uneVille'];
				$uneVilleOrigine = $_REQUEST['uneVilleOrigine'];
				$anneeEnCours = $_REQUEST['anneeEnCours'];

				// Si pas d'erreur de ville
				if ($uneVilleOrigine != $uneVille) {

					//on test au cas ou il existe avant

					$pdo->importerEleveBIS($unEleve, $uneVille, $uneVilleOrigine, $anneeEnCours);
					// On exporte l'élève vers la ville choisie
					$pdo->importerEleve($unEleve, $uneVille, $uneVilleOrigine, $anneeEnCours);

					// Message de confirmation
					echo '<div class="alert alert-success">L\'élève a bien été exporté de ' . ucfirst($uneVilleOrigine) . ' vers ' . ucfirst($uneVille) . '.</div>';
				} else {
					echo '<div class="alert alert-danger"<strong>Erreur</strong> Impossible d\'exporter un élève vers une ville identique.</div>';
				}
			}
			include("vues/administrateur/v_importerEleve.php");

			break;
		}

	case 'valideAppelElevesCase': {
			include("vues/v_entete.php");

			$dateAppel = $_REQUEST['dateAppel'];
			$moment = $_REQUEST['moment'];
			$appel = $_REQUEST['appel'] ?? [];

			foreach ($appel as $unEleve) {
				$pdo->ajoutAppelEleveCase($unEleve, $dateAppel, $moment);
			}

			echo "<h2 class='text-center'>L'appel pour les élèves a bien été fait et sans erreurs.</h2>";
			break;
		}

	case 'appelElevesCodeBarre': {
			include("vues/v_entete.php");
			include("vues/administrateur/v_appelElevesCodeBarre.php");
			break;
		}
	case 'ValidAppelElevesCodeBarre': {
			include("vues/v_entete.php");

			$date = $_REQUEST['dateAppel'];
			$moment = (int)$_REQUEST['moment'];

			$appel = $_REQUEST['appel'];
			$qrCodesEleves = explode("\n", $appel);
			$qrCodesEleves = array_map(static function ($qrCode) {
				return trim($qrCode);
			}, $qrCodesEleves);

			foreach ($qrCodesEleves as $qrCode) {
				$idEleve = $pdo->getIdEleveQRCode($qrCode);
				if ($idEleve !== null) {
					$pdo->ajoutAppelEleveCase($idEleve, $date, $moment);
				}
			}

			echo '<div id="contenu">';
			echo '    <h3>Votre appel a bien été fait !</h3>';
			echo '</div>';
			break;
		}

	case 'ajoutRdv': {
			//require('./quickstart.php'); //fichier piur appeler l'api google calendar
			require('./test.php');
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$intervenant = $_REQUEST['intervenant'];
			$date = $_REQUEST["date_inscription"] . ' ' . $_REQUEST['heure'];
			$commentaire = htmlentities($_REQUEST['commentaire'], ENT_QUOTES);



			//Récuperation des prénoms et des noms de l'élève et de l'intervenant
			$eleve = $pdo->recupUnEleves($num);
			$Intervenant = $pdo->recupUnIntervenant($intervenant);
			$eleve = $eleve["PRENOM"] . ' ' . $eleve["NOM"];
			$Intervenant = $Intervenant["PRENOM"] . ' ' . $Intervenant["NOM"];

			//conversion de l'heure pour ajouter heure+1
			$a =  substr_replace($_REQUEST['heure'], "", 2);
			$b = intval($a);
			$b = $b + 1;
			$c = substr($_REQUEST['heure'], 2);
			$heureformate = $b . $c;

			/*
    //DEBUT ajout évènement dans google calendar
    $Evenement = new Google_Service_Calendar_Event(array(
      'summary' => $eleve.' avec '.$Intervenant.' ',
      'location' => '3 Allée des Jardins, 21800 Quetigny',
      'description' => $commentaire,
      'start' => array(
        'dateTime' => ''.$_REQUEST["date_inscription"].'T'.$_REQUEST['heure'].':00+02:00',
        'timeZone' => 'Europe/Paris',
      ),
      'end' => array(
        'dateTime' => ''.$_REQUEST["date_inscription"].'T'.$heureformate.':00+02:00',
        'timeZone' => 'Europe/Paris',
      ),
    ));



    $RDVParentsCalendrier = 'abssce0v033p6av125vb6qrivo@group.calendar.google.com'; // identifiant du calendrier Rendez-Vous parents
    $addEvent = $service->events->insert($RDVParentsCalendrier, $Evenement); // ajout d'un évènemebt eb fonction du calendrier et de l'évènement
    $idgoogle = $addEvent->id; //identifiant de l'évènement ajouté
    // FIN ajout évènement dans google calendar
*/

			// DEBUT ajout evenement rdv google
			$capi = new GoogleCalendarApi();

			$user_timezone = $capi->GetUserCalendarTimezone($_SESSION['access_token']);

			$event_time = ['start_time' => '' . $_REQUEST["date_inscription"] . 'T' . $_REQUEST['heure'] . ':00', 'end_time' => '' . $_REQUEST["date_inscription"] . 'T' . $heureformate . ':00'];

			// Create event on primary calendar
			$event_id = $capi->CreateCalendarEvent('abssce0v033p6av125vb6qrivo@group.calendar.google.com', '' . $eleve . ' avec ' . $Intervenant . '', '3 Allée des Jardins, 21800 Quetigny', $commentaire, '0', $event_time, $user_timezone, $_SESSION['access_token']);
			//FIN ajout evenement rdv google

			$idgoogle = $event_id;

			$pdo->ajoutRdv($num, $intervenant, $date, $commentaire, 0, 'NULL', 'FALSE', '"' . $idgoogle . '"');

			echo '<div id="contenu">';
			echo ' <h3> L\'ajout du rendez-vous a bien été faite ! </h3>';
			echo '</div>';

			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Calendrier', "1");
			break;
		}

	case 'ajoutRdvBsb': {
			include('./test.php');
			//require('./quickstart.php'); //fichier piur appeler l'api google calendar
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$intervenant = $_REQUEST['intervenant'];
			$matiere = $_REQUEST['matiere'];
			$date = $_REQUEST["date_inscription"] . ' ' . $_REQUEST['heure'];
			$commentaire = htmlentities($_REQUEST['commentaire'], ENT_QUOTES);
			$duree = $_REQUEST['duree'];


			echo '<div id="contenu">';
			echo ' <h3> L\'ajout du rendez-vous a bien été faite ! </h3>';
			echo '</div>';

			$uneMatiere = $pdo->returnUnParametre($matiere);


			//Récuperation des prénoms et des noms de l'élève et de l'intervenant
			$eleve = $pdo->recupUnEleves($num);
			$Intervenant = $pdo->recupUnIntervenant($intervenant);
			$eleve = $eleve["PRENOM"] . ' ' . $eleve["NOM"];
			$Intervenant = $Intervenant["PRENOM"] . ' ' . $Intervenant["NOM"];

			//conversion de l'heure pour ajouter heure+1
			$a =  substr_replace($_REQUEST['heure'], "", 2);
			$b = intval($a);
			$b = $b + intval($duree);
			$c = substr($_REQUEST['heure'], 2);
			$heureformate = $b . $c;


			/*
      //DEBUT ajout évènement dans google calendar
      $Evenement = new Google_Service_Calendar_Event(array(
        'summary' => $eleve.' avec '.$Intervenant.'. Matière : '.$uneMatiere["NOM"].'',
        'location' => '3 Allée des Jardins, 21800 Quetigny',
        'description' => $commentaire,
        'start' => array(
          'dateTime' => ''.$_REQUEST["date_inscription"].'T'.$_REQUEST['heure'].':00+02:00',
          'timeZone' => 'Europe/Paris',
        ),
        'end' => array(
          'dateTime' => ''.$_REQUEST["date_inscription"].'T'.$heureformate.':00+02:00',
          'timeZone' => 'Europe/Paris',
        ),
      ));



      $RDVBSBCalendrier = 'a4bv3s31gpkhtg74lf32csj4t8@group.calendar.google.com'; // identifiant du calendrier Rendez-Vous BSB
      $addEvent = $service->events->insert($RDVBSBCalendrier, $Evenement); // ajout d'un évènemebt eb fonction du calendrier et de l'évènement
      $idgoogle = $addEvent->id; //identifiant de l'évènement ajouté
      // FIN ajout évènement dans google calendar
      */


			// DEBUT ajout evenement rdv google
			$capi = new GoogleCalendarApi();

			$user_timezone = $capi->GetUserCalendarTimezone($_SESSION['access_token']);

			$event_time = ['start_time' => '' . $_REQUEST["date_inscription"] . 'T' . $_REQUEST['heure'] . ':00', 'end_time' => '' . $_REQUEST["date_inscription"] . 'T' . $heureformate . ':00'];

			// Create event on primary calendar
			$event_id = $capi->CreateCalendarEvent('a4bv3s31gpkhtg74lf32csj4t8@group.calendar.google.com', '' . $eleve . ' avec ' . $Intervenant . '', '3 Allée des Jardins, 21800 Quetigny', $commentaire, '0', $event_time, $user_timezone, $_SESSION['access_token']);
			//FIN ajout evenement rdv google

			$idgoogle = $event_id;


			$pdo->ajoutRdv($num, $intervenant, $date, $commentaire, $matiere, $duree, 'TRUE', '"' . $idgoogle . '"');



			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=planningBSB', "1");
			break;
		}


	case 'intervenantsHoraires': {

			include("vues/v_entete.php");

			$lesIntervenants = $pdo->recupTousIntervenants();
			include("vues/administrateur/v_IntervenantsStatut.php");
			break;
		}

	case 'localisationEleves': {

			include("vues/v_entete.php");

			$lesEleves = $pdo->recupTousEleves222();
			$lesLocalisations = $pdo->recupLocalisations($anneeEnCours);

			if ($_REQUEST['afficherCantons'] == true) {
				$afficherCantons = true;
			} else {
				$afficherCantons = false;
			}

			include("vues/administrateur/v_localisationEleves.php");
			break;
		}

	case 'evenementsPDF': {
			$evenements = $_REQUEST['evenements'];
			$valeur = $_REQUEST['valeur'];
			$lesClasses = $pdo->getParametre(4);

			if ($valeur == 1) {
				require('fpdf/fpdf.php');
				$pdf = new FPDF();
				include("vues/administrateur/v_EvenementsPDF.php");
				$pdf->Output();
			} else {
				$elevesInscritaEvenement = $pdo->recupElevesInscritEvenement($evenements);
				include("vues/administrateur/v_EvenementsCSV.php");
			}
			break;
		}
	case 'ElevesCSV': {
			//$lesClasses = $pdo->getParametre(4);

			$TousEleves = $pdo->recupTousEleves222();
			$lesfilieres 	= $pdo->getParametre(3);
			$lesClasses 	= $pdo->getParametre(4);
			$lesEtablissements 	= $pdo->getParametre(1);
			$lesSpecialites 	= $pdo->getParametre(20);
			$lesSpecialites2 	= $pdo->getParametre(21);


			include("vues/administrateur/v_ElevesCSV.php");
			break;
		}

	case 'listeCompleteEleves': {
			$TousEleves = $pdo->recupTousEleves222();
			$lesfilieres 	= $pdo->getParametre(3);
			$lesClasses 	= $pdo->getParametre(4);
			$lesEtablissements 	= $pdo->getParametre(1);
			$lesSpecialites 	= $pdo->getParametre(20);
			$lesSpecialites2 	= $pdo->getParametre(21);
			$allstages = $pdo->getStages();
			$ElevesToutStage = $pdo->getElevesAllStage();


			include("vues/administrateur/v_listeCompleteEleves.php");
			break;
		}

	case 'StatsCSV': {
			$lesEtablissements 	= $pdo->getParametre(1);
			$lesLangues 	= $pdo->getParametre(2);
			$lesfilieres 	= $pdo->getParametre(3);
			$lesClasses 	= $pdo->getParametre(4);
			$lesMatieres 	= $pdo->getParametre(6);
			$lesEvenements = $pdo->recupEvenement();
			$lesStages = $pdo->getStages();
			$lesAnnees = $pdo->getAnneesScolaires();
			$lesVilles = $pdo->getVilles();
			$req = $_REQUEST['req'];
			$anneeChoisie = $_REQUEST['annee'];
			$critere_presences = $_REQUEST['critere_presences'];
			include("vues/administrateur/v_StatsCSV.php");
			break;
		}


	case 'ElevesStageCSV': {
			$num = $_GET['num'];
			$lesEtablissements 	= $pdo->getParametre(1);
			$lesfilieres 	= $pdo->getParametre(3);
			$lesClasses 	= $pdo->getParametre(4);
			$lesInscriptions = $pdo->recupLesInscriptions($num);
			include("vues/administrateur/v_ElevesStageCSV.php");
			break;
		}


	case 'ElevesExcel': {
			$lesClasses = $pdo->getParametre(4);

			$TousEleves = $pdo->recupTousEleves();
			include("vues/administrateur/v_ElevesExcel.php");
			break;
		}
	case 'TrombinoscopePDF': {
			$classeSelectionner = $_REQUEST['classe'];
			$lesClasses = $pdo->getParametre(4);
			require('fpdf/fpdf.php');
			$pdf = new FPDF();
			include("vues/administrateur/v_TrombiPDF.php");
			$pdf->Output();
			break;
		}
	case 'AppelsPDF': {
			$classeSelectionner = $_REQUEST['classe'];
			$lesClasses = $pdo->getParametre(4);
			require('fpdf/fpdf.php');
			$pdf = new FPDF();
			include("vues/administrateur/v_AppelsPDF.php");
			$pdf->Output();
			break;
		}

	case 'ImpayesPayesPDF': {
			$reglement = $_REQUEST['reglement'];
			$evenementON = $_REQUEST['evenementON'];
			$valeur = $_REQUEST['valeur'];
			$evenement = $_REQUEST['evenements'];

			if ($valeur == 0) {
				if ($evenementON == 0) {
					$tableau = $pdo->recupImpayesReglement($reglement);
				} else {
					$tableau = $pdo->recupImpayesReglementAvecEvenement($reglement, $evenement);
				}
			} else {
				if ($evenementON == 0) {
					$tableau = $pdo->recupPayesReglement($reglement);
				} else {
					$tableau = $pdo->recupPayesReglementAvecEvenement($reglement, $evenement);
				}
			}
			include("vues/v_entete.php");

			include("vues/administrateur/v_PayesImpayes.php");
			break;
		}


	case 'PayesImpayes': {
			$lesEleves = $pdo->recupTousEleves222();
			$lesAnneesScolaires = $pdo->getAnneesScolaires2();

			if (isset($_REQUEST['nom'])) {
				$nom = $_REQUEST['nom'];
			} else {
				$annee = $pdo->getAnneeEnCours();
				$nom = "Soutien scolaire " . $annee . '-' . ($annee + 1);
			}

			if (isset($_REQUEST['type'])) {
				$type = $_REQUEST['type'];
			} else {
				$type = "tout";
			}

			$lesReglements = $pdo->recupTousReglements($nom, $type);

			$cheque = $pdo->recupTousReglements($nom, 1);
			$especes = $pdo->recupTousReglements($nom, 2);
			$boncaf = $pdo->recupTousReglements($nom, 3);
			$autre = $pdo->recupTousReglements($nom, 80);
			$exonere = $pdo->recupTousReglements($nom, 83);
			$cb = $pdo->recupTousReglements($nom, 151);

			$lesChequesCB = array_merge($cheque, $cb);

			$camembert = [count($cheque), count($cb), count($especes), count($boncaf), count($autre), count($exonere)];


			include("vues/v_entete.php");
			include("vues/administrateur/v_PayesImpayes2.php");
			break;
		}

	case 'lesLogs': {
			$utilisateurs = array(
				array("id" => "0", "text" => "Eleves"),
				array("id" => "1", "text" => "Intervenants"),
				array("id" => "0 || 1", "text" => "Tous")
			);
			$estintervenant = $_POST["estintervenant"];
			$Selectionner = $estintervenant;
			if (isset($estintervenant)) {
				$lesLogs = $pdo->lesLogs($estintervenant);
			}

			include("vues/v_entete.php");
			include("vues/administrateur/v_logs.php");
			break;
		}


	case 'ImpayesPayesCSV': {
			$reglement = $_REQUEST['reglement'];
			$evenementON = $_REQUEST['evenementON'];
			$valeur = $_REQUEST['valeur'];
			$evenement = $_REQUEST['evenements'];
			$tableau1 = $_REQUEST['tableau1'];
			$footerANePasAfficher = 1;
			if ($valeur == 0) {
				if ($evenementON == 0) {
					$tableau = $pdo->recupImpayesReglement($reglement);
				} else {
					$tableau = $pdo->recupImpayesReglementAvecEvenement($reglement, $evenement);
				}
			} else {
				if ($evenementON == 0) {
					$tableau = $pdo->recupPayesReglement($reglement);
				} else {
					$tableau = $pdo->recupPayesReglementAvecEvenement($reglement, $evenement);
				}
			}
			//include("vues/v_entete.php");
			include("vues/administrateur/v_PayesImpayesCSV.php");
			break;
		}
	case 'PresenceIntervenantIndividuel': {
			include("vues/v_entete.php");

			$intervenants = $_REQUEST['intervenants'];
			$debut = $_REQUEST['debut'];
			$fin = $_REQUEST['fin'];
			$UnIntervenant = $pdo->recupUnIntervenant($intervenants);
			$tableau = $pdo->recupHoraireIntervenant($debut, $fin, $intervenants);
			include("vues/administrateur/v_PresenceIntervenant.php");
			break;
		}
	case 'PresenceEleveIndividuel': {
			include("vues/v_entete.php");

			$eleves = $_REQUEST['eleve'];
			$debut = $_REQUEST['debut'];
			$fin = $_REQUEST['fin'];
			$UnEleve = $pdo->recupUnEleves($eleves);

			$tableau = $pdo->recupPresenceEleve($debut, $fin, $eleves);
			include("vues/administrateur/v_PresenceEleve.php");
			break;
		}

	case 'LesPresencesAUneDate': {
			// La partie "GET"
			$moment = getMomentJournee();
			$jourSemaine = 4;	// Mercredi
			$anneeExtranet = $pdo->getAnneeEnCours();

			if (!empty($_REQUEST['laDate'])) {
				$laDate = $_REQUEST['laDate'];
			} else {
				$laDate = '';
				$jour = 0;
				$mois = 0;
				$annee = 0;
			}
			$lesStages = $pdo->getStages();
			include("vues/v_entete.php");

			// La partie "POST"
			if (isset($_POST['presences'])) {
				if ($_POST['presences'] == "datePrecise")		// La valeur du bouton radio est "datePrecise"
				{
					$tableauIntervenant = $pdo->recupIntervenantsPresentDate($laDate, $_POST['moment']);
					$tableauEleves = $pdo->recupElevesPresentDate($laDate, $_POST['moment']);
				} elseif ($_POST['presences'] == "plusieursJoursMois")		// La valeur du bouton radio est "plusieursJoursMois"
				{
					// 4 = mercredi, 7 = samedi
					$tableauIntervenant = $pdo->recupIntervenantsParJour($_POST['jourSemaine'], $_POST['mois']);
					$tableauEleves = $pdo->recupElevesParJour($_POST['jourSemaine'], $_POST['mois']);
				} elseif ($_POST['presences'] == "stages")		// La valeur du bouton radio est "stages"
				{
					// Récupérer le stage sélectionné et les dates de début et de fin
					$idStage = $_POST['unStage'];
					$stage = $pdo->recupUnStage($idStage);

					// Récupérer les présences des intervenants et des élèves pour ces dates
					$tableauIntervenant = $pdo->recupIntervenantsEntreDates($stage['DATEDEB_STAGE'], $stage['DATEFIN_STAGE']);
					$tableauEleves = $pdo->recupElevesEntreDates($stage['DATEDEB_STAGE'], $stage['DATEFIN_STAGE']);
				}
			}

			include("vues/administrateur/v_LesPresencesDuneDate.php");
			break;
		}

	case 'ValidationIntervenantsHoraires': {
			include("vues/v_entete.php");
			$tableau = $_REQUEST['tableau'];


			$debut = $_REQUEST['debut'];
			$fin = $_REQUEST['fin'];
			$stages = $pdo->recupAllStages();
			$horaireStage = [];
			$scolaire = [];

			if ($tableau == 1) // alors tableau individuel
			{
				$intervenants = $_REQUEST['intervenants'];
				$UnIntervenant = $pdo->recupUnIntervenant($intervenants);
				$tableau = $pdo->recupHoraireIntervenant($debut, $fin, $intervenants);
				foreach ($tableau as $unHoraire) {
					foreach ($stages as $unStage) {
						if (strtotime($unHoraire["SEANCE"]) >= strtotime($unStage["DATEDEB_STAGE"]) && strtotime($unHoraire["SEANCE"]) <= strtotime($unStage["DATEFIN_STAGE"])) {
							$isStage = true;
							$unHoraire["NOM_STAGE"] = $unStage["NOM_STAGE"];
							break;
						} else {
							$isStage = false;
						}
					}



					if ($isStage) {
						$horaireStage[] = $unHoraire;
					} else {
						$scolaire[] = $unHoraire;
					}
				}
				$prixTableau = $pdo->getPrixHoraireIntervenant();

				$prixHoraire = $prixTableau['prixHoraire'];
				include("vues/administrateur/v_HoraireIntervenant.php");
				break;
			} else // si par statut
			{
				$statut = $_REQUEST['statut'];
				$lesIntervenants = $pdo->recupUnIntervenantsParStatut($statut);

				foreach ($lesIntervenants as $unIntervenant) {
					$horaires = $pdo->recupHoraireIntervenant($debut, $fin, $unIntervenant['ID_INTERVENANT']);
					//$scolaire[$unIntervenant['ID_INTERVENANT']] = $horaires;
					foreach ($horaires as $unHoraire) {
						foreach ($stages as $unStage) {
							if (strtotime($unHoraire["SEANCE"]) >= strtotime($unStage["DATEDEB_STAGE"]) && strtotime($unHoraire["SEANCE"]) <= strtotime($unStage["DATEFIN_STAGE"])) {
								$isStage = true;
								$unHoraire["NOM_STAGE"] = $unStage["NOM_STAGE"];
								break;
							} else {
								$isStage = false;
							}
						}

						if ($isStage) {
							$stage[$unIntervenant['ID_INTERVENANT']][] = $unHoraire;
						} else {
							$scolaire[$unIntervenant['ID_INTERVENANT']][] = $unHoraire;
						}
					}
					// On récupère ses horaires

					$rdv[$unIntervenant['ID_INTERVENANT']] = $pdo->recupRdvIntervenant($debut, $fin, $unIntervenant['ID_INTERVENANT']);
				}
				//$tableau=$pdo->recupHoraireIntervenantStatut($debut,$fin,$statut);


				$prixTableau = $pdo->getPrixHoraireIntervenant();
				$prixHoraire = $prixTableau['prixHoraire'];
				include("vues/administrateur/v_HoraireStatut.php");
				break;
			}


			break;
		}
	case 'evenements': {

			include("vues/v_entete.php");

			$tableau = $pdo->recupEvenement();
			include("vues/administrateur/v_evenements.php");
			break;
		}

	case 'suppEvenements': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$pdo->suppEvenement($num);
			include("vues/administrateur/v_evenementsSUPP.php");

			break;
		}

	case 'impayes': {

			include("vues/v_entete.php");
			//impayés
			$lesAnneesScolaires = $pdo->getAnneesScolaires2();
			//evenments
			$lesEvenements = $pdo->recupEvenement();
			//trombi
			$lesClasses 	= $pdo->getParametre(4);
			include("vues/administrateur/v_Impayes.php");

			break;
		}

	case 'LesEvenements': {

			include("vues/v_entete.php");
			//evenments
			$lesEvenements = $pdo->recupEvenement();
			//trombi
			$lesClasses 	= $pdo->getParametre(4);
			include("vues/administrateur/v_LesEvenements.php");

			break;
		}

	case 'suppPresencesUneSeance': {
			include("vues/v_entete.php");

			$redirectUrl = '';

			switch ($_REQUEST['type']) {
				case 'eleves':
					$date = $_REQUEST['date'];
					$moment = $_REQUEST['moment'];
					$redirectUrl = '&laDate=' . $date . '&moment=' . $moment;
					$pdo->suppElevesPresences($date, $moment);
					break;
				case 'intervenants':
					$date = $_REQUEST['date'];
					$moment = $_REQUEST['moment'];
					$redirectUrl = '&laDate=' . $date . '&moment=' . $moment;
					$pdo->suppIntervenantsPresences($date, $moment);
					break;
				case 'UnePresence':
					$num = $_REQUEST['num'];
					$pdo->suppUnePresence($num);
					break;
			}

			include("vues/administrateur/v_presenceSUPP.php");

			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesPresencesAUneDate' . $redirectUrl, 1);
			echo '</div>';

			break;
		}


	case 'modifEvenements': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$evenement = $pdo->recupUnEvenement($num);
			include("vues/administrateur/v_ModifEvenement.php");
			break;
		}


	case 'modifLieu': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$lesLieux = $pdo->getLieux();
			$villesFrance = $pdo->VillesFrance();
			include("vues/administrateur/v_ModifierLieu.php");
			break;
		}



	case 'modifPartenaire': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$lesPartenaires = $pdo->recupPartenairesTout();
			include("vues/administrateur/v_ModifierPartenaire.php");
			break;
		}

	case 'ModifierPartenaireConfirmation': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$nom = htmlentities(stripslashes($_REQUEST['nom']), ENT_QUOTES);
			$image = stripslashes($_REQUEST['imageAvant']);
			// si une image est envoyée
			if ($_FILES['image']['name'] != '') {
				$photo = time() . '_' . basename($_FILES['image']['name']);
				move_uploaded_file($_FILES['image']['tmp_name'], 'images/imagePartenaire/' . $photo);
				$image = $photo;
			}

			$pdo->modifierPartenaireConfirmation($num, $nom, $image);

			echo '<div id="contenu">';
			echo ' <h3>Le partenaire a bien été modifié ! </h3>';
			echo '</div>';
			$onglet = 'lieux';
			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages&onglet=partenaires', "1");
			break;
		}


	case 'ModifierLieuConfirmation': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$nom = htmlentities(stripslashes($_REQUEST['nom']), ENT_QUOTES);
			$adresse = htmlentities(stripslashes($_REQUEST['adresse']), ENT_QUOTES);
			$cp = stripslashes($_REQUEST['cp']);
			$ville = htmlentities(stripslashes($_REQUEST['ville']), ENT_QUOTES);

			$pdo->modifierLieuConfirmation($num, $nom, $adresse, $cp, $ville);

			echo '<div id="contenu">';
			echo ' <h3>Le lieu a bien été modifié ! </h3>';
			echo '</div>';
			$onglet = 'lieux';
			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages', "1");
			break;
		}

	case 'ModifEvenementValidation': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$nom = $_REQUEST['nom'];
			$datedebut = $_REQUEST['dateDebut'];
			list($jour, $mois, $annee) = explode('-', $datedebut);
			$dateAnglaisDebut = $annee . "-" . $mois . "-" . $jour;


			$dateFin = $_REQUEST['dateFin'];
			list($jour, $mois, $annee) = explode('-', $dateFin);
			$dateAnglaisFin = $annee . "-" . $mois . "-" . $jour;

			$nb = $_REQUEST['nb'];
			$cout = $_REQUEST['cout'];
			$annuler = $_REQUEST['annuler'];
			$pdo->majEvenement($num, $nom, $dateAnglaisDebut, $dateAnglaisFin, $nb, $cout, $annuler);
			echo '<div id="contenu">';
			echo ' <h3> Votre évènement a bien été modifié ! </h3>';
			echo '</div>';



			break;
		}
	case 'AjoutEvenementIndex': {

			include("vues/v_entete.php");
			include("vues/administrateur/v_ajoutEvenement.php");
			break;
		}

	case 'AjoutEvenementValidation': {

			include("vues/v_entete.php");
			$nom = $_REQUEST['nom'];
			$cout = $_REQUEST['cout'];
			$nb = $_REQUEST['nb'];

			$dateDebut = $_REQUEST['dateDebut'];
			// extraction des jour, mois, an de la date
			list($jour, $mois, $annee) = explode('-', $dateDebut);
			$dateDebut = $annee . "-" . $mois . "-" . $jour;


			$dateFin = $_REQUEST['dateFin'];
			// extraction des jour, mois, an de la date
			list($jour, $mois, $annee) = explode('-', $dateFin);
			$dateFin = $annee . "-" . $mois . "-" . $jour;

			$pdo->ajoutEvenement($nom, $cout, $nb, $dateDebut, $dateFin);
			echo '<div id="contenu">';
			echo ' <h3> Votre évènement a bien été ajouté ! </h3>';
			echo '</div>';

			break;
		}

	case 'suppParametre': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];

			$tableau = $pdo->suppParametre($num);
			echo '<div id="contenu">';
			echo ' <h3> Votre paramètre a bien été supprimé ! </h3>';
			echo '</div>';
			break;
		}
	case 'parametres': {
			include("vues/v_entete.php");
			$lesTypes = $pdo->returnLesTypes();

			if (isset($_REQUEST['unType'])) {
				$typeNum = $_REQUEST['unType'];
				$tableau = $pdo->returnParametre($typeNum);
			}
			include("vues/administrateur/v_gestion.php");
			break;
		}


	case 'ajoutParametreIndex': {
			include("vues/v_entete.php");
			$type = $pdo->returnLesTypes();
			include("vues/administrateur/v_ajoutParametre.php");
			break;
		}

	case 'ValidationAjoutParametre': {
			include("vues/v_entete.php");
			$nom = htmlentities($_REQUEST['nom'], ENT_QUOTES);
			$niveau = $_REQUEST['niveau'];
			$type = $_REQUEST['type'];
			$valeur = $_REQUEST['valeur'];
			$maximum = $pdo->getMaxParametre();

			if ($type == 1) {
				$niveau = NULL;
			}
			$id = $maximum['maximumNum'] + 1;

			$pdo->InsertParametre($id, $nom, $niveau, $type, $valeur);
			echo '<div id="contenu">';
			echo ' <h3> Votre paramètre a bien été ajouté ! </h3>';
			echo '</div>';
			break;
		}


	case 'ModifParametreIndex': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$parametre = $pdo->returnUnParametre($num);
			$type = $pdo->returnLesTypes();

			include("vues/administrateur/v_modifParametre.php");
			break;
		}

	case 'ModifParametreValidation': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$nom = $_REQUEST['nom'];
			$niveau = $_REQUEST['niveau'];
			$type = $_REQUEST['type'];


			$pdo->modifParametre($num, $nom, $niveau, $type);
			echo '<div id="contenu">';
			echo ' <h3> Votre paramètre a bien été modifié ! </h3>';
			echo '</div>';

			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=index', "1");

			break;
		}
	case 'LesIntervenants': {
			include("vues/v_entete.php");
			$lesIntervenants = $pdo->recupTousIntervenants();
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$lesAnneesInscrites = $pdo->getAnneesIntervenants($_REQUEST['unIntervenant']);
			$lesRendezvousBsb 	= $pdo->recupRdvBsb($anneeEnCours);
			$lesStatuts = array('Bénévole', 'Service Civique', 'Salarié', 'BSB', 'Stagiaire', 'Bénévole nbH');
			$lesBanques = $pdo->getLesBanques();
			if (isset($_REQUEST['unIntervenant'])) {
				$num = $_REQUEST['unIntervenant'];
				$IntervenantSelectionner = $pdo->recupUnIntervenant($num);
				$lesMatieres 	= $pdo->getParametre(6);
				$lesMatieresIntervenant = $pdo->getSpecialisationIntervenant($num);
			} else {
			}
			include("vues/administrateur/v_LesIntervenants.php");
			break;
		}
	case 'LesIntervenantsModifier': {
			include("vues/v_entete.php");
			$nom = htmlentities($_REQUEST['nom'], ENT_QUOTES);
			$num = $_REQUEST['num'];
			$prenom = htmlentities($_REQUEST['prenom'], ENT_QUOTES);
			$actif = $_REQUEST['actif'];
			$date_naissance = $_REQUEST['date_naissance'];
			$lieu_naissance = htmlentities($_REQUEST['lieu_naissance'], ENT_QUOTES);
			$tel = $_REQUEST['tel'];
			$adresse = htmlentities($_REQUEST['adresse'], ENT_QUOTES);
			$statut = $_REQUEST['statut'];
			$cp = $_REQUEST['cp'];
			$ville = htmlentities($_REQUEST['ville'], ENT_QUOTES);
			$email = $_REQUEST['email'];
			$commentaires = htmlentities($_REQUEST['commentaires'], ENT_QUOTES);
			$diplome = htmlentities($_REQUEST['diplome'], ENT_QUOTES);
			$numsecu = $_REQUEST['numsecu'];
			$nationalite = htmlentities($_REQUEST['nationalite'], ENT_QUOTES);
			$password = htmlspecialchars($_REQUEST['password']);
			$specialite = $_REQUEST['specialite'];
			$fichier = $_FILES['fichier'];
			$date_naissance = $_REQUEST["date_naissance"];

			//on stock le fichier
			move_uploaded_file($_FILES['fichier']['tmp_name'], 'photosIntervenants/' . basename($_FILES['fichier']['name']));
			$photo = $_FILES['fichier']['name'];

			//$message = "le fichier à été stocker à cette adresse: photosIntervenants/".$_FILES['fichier']['name'].".";

			$IntervenantSelectionner = $pdo->recupUnIntervenant($num);

			if ($IntervenantSelectionner['STATUT'] == "Service Civique") {
				$serviceCivique = $_REQUEST['service'];
			} else {
				$serviceCivique = " ";
			}


			if ($photo == "") {
				$IntervenantSelectionner = $pdo->recupUnIntervenant($num);
				$photoDeIntervenant = $IntervenantSelectionner['PHOTO'];
				$photo = $photoDeIntervenant;
			}

			if ($password != "") {
				$password = hash_password($password);
				$pdo->modifIntervenantAvecCode($num, $nom, $prenom, $actif, $date_naissance, $lieu_naissance, $tel, $adresse, $statut, $cp, $ville, $email, $commentaires, $diplome, $numsecu, $nationalite, $password, $photo, $iban, $bic, $compte, $banque, $serviceCivique);
			} else {
				$pdo->modifIntervenantSansCode($num, $nom, $prenom, $actif, $date_naissance, $lieu_naissance, $tel, $adresse, $statut, $cp, $ville, $email, $commentaires, $diplome, $numsecu, $nationalite, $photo, $iban, $bic, $compte, $banque, $serviceCivique);
			}

			$pdo->suppSpecialiter($num);
			//rajoutons les spécialités sélectionnner
			foreach ($specialite as $valeur) {
				$pdo->ajoutSpecialite($num, $valeur);
			}
			echo '<div id="contenu">';
			echo $_REQUEST . ' <h3> Les informations de l\'intervenants ont bien été modifiés ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $num . '', "1");
			echo '</div>';



			break;
		}

	case 'LesIntervenantsModifierReglement': {
			include("vues/v_entete.php");

			$num = $_REQUEST['num'];
			$iban = $_REQUEST['iban'];
			$bic = $_REQUEST['bic'];
			$compte = $_REQUEST['compte'];
			$banque = htmlentities($_REQUEST['banque'], ENT_QUOTES);

			$pdo->modifIntervenantReglement($num, $iban, $bic, $compte, $banque);

			echo '<div id="contenu">';
			echo ' <h3> Les informations de l\'intervenants ont bien été modifiés ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $num . '', "1");
			echo '</div>';
		}







	case 'AjoutEvenementAEleve': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$evenement = $_REQUEST['evenement'];
			$rq = $pdo->ajoutInscription($num, $evenement);

			echo '<div id="contenu">';
			if ($rq === false) {
				echo ' <h3>Vous êtes déjà inscrit sur cet évènement ! </h3>';
			} else {
				echo ' <h3>L\'inscription à l\'évènement a bien été pris en compte ! </h3>';
			}


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $num . '', "1");

			echo '</div>';
			break;
		}

	case 'Trombi': {
			include("vues/v_entete.php");
			$lesEleves = $pdo->recupTousEleves222();
			$lesClasses 	= $pdo->getParametre(4);
			include("vues/administrateur/v_Trombi.php");
			break;
		}

	case 'TrombiIntervenants': {
			include("vues/v_entete.php");
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$lesIntervenants = $pdo->recupTousIntervenantsAnneeEnCours($anneeEnCours);
			include("vues/administrateur/v_TrombiIntervenants.php");
			break;
		}

	case 'TrombiIntervenantsDiapo': {
			$anneeEnCours = $pdo->getAnneeEnCours();
			$lesIntervenants = $pdo->recupTousIntervenantsAnneeEnCours($anneeEnCours);
			include("vues/administrateur/v_TrombiIntervenantsDiapo.php");
			break;
		}


	case 'supprimerUnDocumentIntervenant': {
			$num = $_REQUEST['num'];
			$fichier = $_REQUEST['fichier'];

			unlink('./documentsIntervenants/' . $num . '/' . $fichier);

			include("vues/v_entete.php");
			echo ' <h3>Le document a bien été supprimé ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $num . '', "1");

			echo '</div>';

			break;
		}

	case 'ajax_reglement': {
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idActivite'])) {
				// Démarrer le tampon de sortie
				ob_start();
				
				// Récupérer l'ID de l'activité
				$idActivite = $_POST['idActivite'];
				// Récupérer les informations sur les consommables du centre pour l'activité
				$consommablesCentreInfo = $pdo->getConsommablesCentreInfo($idActivite);

				// Nettoyer le tampon de sortie pour éviter que tout contenu précédent ne contamine la réponse JSON
				ob_clean();

				// Envoi de la réponse au format JSON
				header('Content-Type: application/json'); // Réponse au format JSON

				// Envoie du résultat sous format json vers afficheReglement.js
				echo json_encode($consommablesCentreInfo);
				exit;
			}
			break;
		}

	case 'ajax_unEleve': {
			$footerANePasAfficher = 1;
			$footerNePasAfficher = 1;

			if (isset($_REQUEST['id'])) {
				$num = $_REQUEST['id'];
				$eleveSelectionner = $pdo->recupUnEleves($num);

				$eleve = array_filter($eleveSelectionner, static function ($value, $key) {
					return !(is_int($key) || ctype_digit($key)) && $key !== 'N°_ALLOCATAIRE';
				}, ARRAY_FILTER_USE_BOTH);

				foreach ($eleve as $key => $value) {
					$eleve[$key] = str_replace([
						'&agrave;', '&eacute;', '&egrave;', '&euml;', '&iuml;',
						'&Agrave;', '&Eacute;', '&Egrave;', '&Euml;', '&Iuml;'
					], [
						'à', 'é', 'è', 'ë', 'ï',
						'À', 'É', 'È', 'Ë', 'Ï'
					], $value);
				}

				header('Content-Type: application/xml');
				echo '<eleve>';
				// Parcours des éléments
				foreach ($eleve as $cle => $valeur) {
					echo '<' . $cle . '>' . $valeur . '</' . $cle . '>';
				}
				echo '</eleve>';
			}
			break;
		}

	case 'ajax_unEleveStage': {
			$footerANePasAfficher = 1;
			$footerNePasAfficher = 1;

			if (isset($_REQUEST['id'])) {
				$num = $_REQUEST['id'];
				$eleveSelectionner = $pdo->recupUneInscription($num);

				$eleve = array_filter($eleveSelectionner, static function ($value, $key) {
					return !(is_int($key) || ctype_digit($key)) && !in_array($key, [
						'ORIGINE_INSCRIPTIONS', 'USER_AGENT_INSCRIPTIONS'
					], true);
				}, ARRAY_FILTER_USE_BOTH);

				foreach ($eleve as $key => $value) {
					$eleve[$key] = str_replace([
						'&agrave;', '&eacute;', '&egrave;', '&euml;', '&iuml;',
						'&Agrave;', '&Eacute;', '&Egrave;', '&Euml;', '&Iuml;'
					], [
						'à', 'é', 'è', 'ë', 'ï',
						'À', 'É', 'È', 'Ë', 'Ï'
					], $value);
				}

				header('Content-Type: application/xml');
				echo '<inscription>';
				// Parcours des éléments
				foreach ($eleve as $cle => $valeur) {
					echo '<' . $cle . '>' . $valeur . '</' . $cle . '>';
				}
				echo '</inscription>';
			}
			break;
		}

		// case 'ajax_reglement':
		// 	{
		// 		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 			if (isset($_POST['nomEleve'])) {
		// 				header('Content-Type: application/json'); // Réponse au format JSON

		// 				$nomEleve = $_POST['nomEleve'];
		// 				$prenomEleves = $pdo->getPrenomElevesSelonNom($nomEleve);
		// 				$result = array();

		// 				foreach ($prenomEleves as $prenomEleve) {
		// 					$prenom = ucwords(strtolower(html_entity_decode($prenomEleve['PRENOM'], ENT_QUOTES, "UTF-8")), " -");
		// 					$tab = ['PRENOM' => $prenom, 'PRENOM_ENCODE' => $prenomEleve['PRENOM']]; // On met le prénom dans un tableau associatif pour pouvoir le récupérer en JS
		// 					array_push($result, $tab);
		// 				}
		// 				// Envoie du résultat sous format json vers afficheReglement.js
		// 				echo json_encode($result);
		// 				exit();
		// 			}
		// 		}
		// 		break;
		// 	}

		// case 'ajax_afficheReglement':
		// 	{
		// 		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 			if (isset($_POST['nomEleve']) && isset($_POST['prenomEleve'])) {
		// 				header('Content-Type: application/json'); // Réponse au format JSON

		// 				$nomEleve = $_POST['nomEleve'];
		// 				$prenomEleve = $_POST['prenomEleve'];
		// 				$reglements = $pdo->getReglements($nomEleve, $prenomEleve);

		// 				$result = array();

		// 				foreach ($reglements as $reglement) {
		// 					$tab = [
		// 						'ADHERENT' => ['NOM' => $reglement['NOM'], 'PRENOM' => $reglement['PRENOM']],
		// 						'ACTIVITE' => $reglement['ACTIVITE'],
		// 						'MONTANT' => $reglement['MONTANT'],
		// 						'DATE' => $reglement['DATE_REGLEMENT'],
		// 					];
		// 					array_push($result, $tab);
		// 				}

		// 				// Envoie du résultat sous format json vers afficheReglement.js
		// 				echo json_encode($result);
		// 				exit();
		// 			}
		// 		}
		// 		break;
		// 	}

	case 'LesEleves': {
			include("vues/v_entete.php");
			$lesEleves = $pdo->recupTousEleves222();
			if (isset($_REQUEST['unEleve'])) {
				$num = $_REQUEST['unEleve'];
				$eleveSelectionner = $pdo->recupUnEleves($num);
				$lesEtablissements 	= $pdo->getParametre(1);
				$lesLangues 	= $pdo->getParametre(2);
				$lesfilieres 	= $pdo->getParametre(3);
				$lesClasses 	= $pdo->getParametre(4);
				$lesMatieres 	= $pdo->getParametre(6);
				$lesSpecialites = $pdo->getParametre(21);
				$anneeEnCours 	= $pdo->getAnneeEnCours();
				$lesEvenements = $pdo->recupEvenement();
				$lesEvenementsEleve = $pdo->recupEvenementEleve($num);
				$lesReglementsEleve = $pdo->recupReglementsUnEleve($num);
				$LesInscriptions = $pdo->recupInscriptionAnnuelEleve($num);
				$lesRendezvous 	= $pdo->recupRdvParents($anneeEnCours);
				$lesRendezvousBsb 	= $pdo->recupRdvBsb($anneeEnCours);
				$lesStages 	= $pdo->getStages();
				$lesIntervenants = $pdo->recupTousIntervenants();
				$lesFratries = $pdo->recupererFratries($num);
			}
			include("vues/administrateur/v_LesEleves.php");
			break;
		}

	case 'eleveevenement': {
			if (isset($_POST['evenement'])) {
				$evenement = $_POST['evenement'];
			}
			echo $evenement;
			//evenments
			$lesEvenements = $pdo->recupEvenement();
			include("vues/v_entete.php");
			if (isset($_POST['evenement'])) {
				$elevesEvenement = $pdo->recupElevesEvenements($evenement);
			}
			include("vues/administrateur/v_elevesEvenement.php");
			break;
		}


	case 'pivoterPhoto': {
			$angle = $_REQUEST['angle'];
			$photo = $_REQUEST['photo'];

			header('Content-type: image/jpeg');

			$source = imagecreatefromjpeg('photosEleves/' . $photo);
		}

	case 'FicheNavette': {
			include("vues/v_entete.php");
			$lesEleves = $pdo->recupTousEleves();
			if (isset($_REQUEST['unEleve'])) {
				$num = $_REQUEST['unEleve'];
				$eleveSelectionner = $pdo->recupUnEleves($num);
				$lesEtablissements 	= $pdo->getParametre(1);
				$lesLangues 	= $pdo->getParametre(2);
				$lesfilieres 	= $pdo->getParametre(3);
				$lesClasses 	= $pdo->getParametre(4);
				$lesMatieres 	= $pdo->getParametre(6);
				$lesSpecialites = $pdo->getParametre(20);
				$anneeEnCours 	= $pdo->getAnneeEnCours();
				//$lesEvenements =$pdo->recupEvenement();
				//$lesEvenementsEleve =$pdo->recupEvenementEleve($num);
				$lesReglementsEleve = $pdo->recupReglementsUnEleve($num);
				$LesInscriptions = $pdo->recupInscriptionAnnuelEleve($num);
				$lesStages 	= $pdo->getStages();
				$lesRendezvous 	= $pdo->recupRdvParents($anneeEnCours);
				//$lesRendezvousBsb 	= $pdo->recupRdvBsb($anneeEnCours);
				if ($eleveSelectionner['PHOTO'] == "") {
					$photo = "AUCUNE.jpg";
				} else {
					$photo = $eleveSelectionner['PHOTO'];
				}
			}
			include("vues/administrateur/v_FicheNavette.php");
			break;
		}


	case 'suppInscriptionEvenements': {
			include("vues/v_entete.php");

			$num = $_REQUEST['num'];
			$eleve = $_REQUEST['eleve'];
			$pdo->suppInscriptionEvenement($num, $eleve);
			echo '<div id="contenu">';
			echo ' <h3> L\'élève a bien été désinscris de cet évènement ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $eleve . '', "1");

			echo '</div>';


			break;
		}


	case 'ModificationAnnuelValidation': {
			include("vues/v_entete.php");

			$num = $_REQUEST['num'];
			$annee = $_REQUEST['annee'];
			$etab = $_REQUEST['etab'];
			$classe = $_REQUEST['classe'];
			$prof_principal = $_REQUEST['prof_principal'];
			$filiere = $_REQUEST['filiere'];
			$lv1 = $_REQUEST['lv1'];
			$lv2 = $_REQUEST['lv2'];
			$date_inscription = $_REQUEST['date_inscription'];
			$commentaires = $_REQUEST['commentaires'];
			$difficultes = $_REQUEST['difficultes'];
			$specialites = $_REQUEST['specialites'];

			$pdo->modifInscriptionEleve2($num, $annee, $etab, $classe, $prof_principal, $filiere, $lv1, $lv2, $date_inscription, $commentaires);


			//supprimons toutes les difficulté de l'élève
			$pdo->suppDifficultes($num, $annee);
			//rajoutons les difficultés désormais sélectionnner
			if ($difficultes != '') {
				foreach ($difficultes as $valeur) {
					$pdo->ajoutDifficulte($num, $valeur, $annee);
				}
			}
			//supprimons toutes les spécialités de l'élève
			$pdo->suppSpecialites($num, $annee);
			//rajoutons les spécialités désormais sélectionnner
			if ($specialites != '') {
				foreach ($specialites as $valeur) {
					$pdo->ajoutSpecialites($num, $valeur, $annee);
				}
			}



			echo '<div id="contenu">';
			echo ' <h3> La scolarité de l\'élève a bien été modifié ! </h3>';

			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $num . '', "1");

			echo '</div>';


			break;
		}


	case 'AjoutAnnuelValidation': {
			include("vues/v_entete.php");

			$num = $_REQUEST['num'];
			$annee = $_REQUEST['annee'];
			$etab = $_REQUEST['etab'];
			$classe = $_REQUEST['classeA'];
			$prof_principal = $_REQUEST['prof_principal'];
			$filiere = $_REQUEST['filiere'];
			$lv1 = $_REQUEST['lv1'];
			$lv2 = $_REQUEST['lv2'];
			$date_inscription = $_REQUEST['date_inscription'];
			$commentaires = $_REQUEST['commentaires'];
			$specialites = $_REQUEST['specialitesA'];
			$difficultes = $_REQUEST['difficultes'];

			$pdo->ajoutInscriptionEleve2($num, $annee, $etab, $classe, $prof_principal, $filiere, $lv1, $lv2, $date_inscription, $commentaires, 0);


			//rajoutons les difficultés désormais sélectionnner
			if ($specialites != '') {
				foreach ($specialites as $valeur) {
					$pdo->ajoutSpecialites($num, $valeur, $annee);
				}
			}

			//rajoutons les difficultés désormais sélectionnner
			if ($difficultes != '') {
				foreach ($difficultes as $valeur) {
					$pdo->ajoutDifficulte($num, $valeur, $annee);
				}
			}


			echo '<div id="contenu">';
			echo ' <h3> La scolarité de l\'élève a bien été ajouté ! </h3>';

			//Utilisation
			//redirect('index.php?choixTraitement=administrateur&action=LesEleves&unEleve='.$num.'',"1");

			echo '</div>';


			break;
		}

	case 'suppReglement': {
			include("vues/v_entete.php");

			$num = $_REQUEST['num'];
			$eleve = $_REQUEST['eleve'];
			$pdo->suppReglement($num);
			echo '<div id="contenu">';
			echo ' <h3> Le réglement a bien été supprimé ! </h3>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $eleve . '', "1");

			echo '</div>';


			break;
		}

	case 'detailsReglement': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$reglement = $pdo->recupReglement($num);
			include("vues/administrateur/v_detailsReglement.php");
			break;
		}

	case 'listingIndex': {
			include("vues/v_entete.php");
			//impayés
			$lesAnneesScolaires = $pdo->getAnneesScolaires2();
			//evenments
			$lesEvenements = $pdo->recupEvenement();
			//trombi
			$lesClasses 	= $pdo->getParametre(4);


			include("vues/administrateur/v_Listing.php");
			break;
		}

	case 'ajoutReglement': {
			include("vues/v_entete.php");
			$anneeEnCours = $pdo->getAnneeEnCours();
			$lesTypesReglements 	= $pdo->getParametre(5);
			$lesBanques = $pdo->getLesBanques();
			$num = $_REQUEST['num'];
			$UnEleve = $pdo->recupUnEleves($num);
			$lesFratries = $pdo->recupererFratries($num);
			$lesAnneesScolaires = $pdo->getAnneesScolaires2();
			$lesTarifs = $pdo->getTarifs();
			$adhesion = false;
			foreach ($lesFratries as $fratrie) {
				$infos = $pdo->getInfosReglementsWithEleve($fratrie['ID_ELEVE']);
				foreach ($infos as $info) {
					if ($info['ADESION_CAF'] == 1 || $info['ADESION_TARIF_PLEIN'] == 1) {
						$reglement = $pdo->recupeReglementWithInfosReglement($info['ID_INFO_REGLEMENT']);
						if (isset($reglement["NOMREGLEMENT"])) {
							$annee = $pdo->getAnneeEnCours();
							$nom = "Soutien scolaire " . $annee . '-' . ($annee + 1);
							if ($reglement["NOMREGLEMENT"] == $nom) {
								$adhesion = true;
								break 2;
							}
						}
						$adhesion = false;
						break 2;
					}
				}
			}
			include("vues/administrateur/v_ajoutReglement.php");
			break;
		}
	case 'modifReglement': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$lesTypesReglements = $pdo->getParametre(5);
			$lesBanques = $pdo->getLesBanques();
			$reglement = $pdo->recupReglement($num);
			$lesAnneesScolaires = $pdo->getAnneesScolaires2();
			$lesElevesDuReglement = $pdo->recupeElevesWithReglement($num);
			$lesFratries = $pdo->recupeFratriesByElevesWithReglement($num);
			$lesInfosReglements = $pdo->getInfosReglementsWithReglement($num);
			$lesTarifs = $pdo->getTarifs();

			include("vues/administrateur/v_modifReglement.php");
			break;
		}

	case 'modifReglementValidation': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$nom = $_REQUEST['nom'];
			$date = $_REQUEST['date'];
			$type = $_REQUEST['type'];
			$transaction = $_REQUEST['num_transaction'];
			if (isset($_REQUEST['banque'])) {
				$banque = $_REQUEST['banque'];
			} else {
				$banque = "";
			}
			$montant = $_REQUEST['montant'];
			$commentaire = $_REQUEST['commentaires'];

			list($jour, $mois, $annee) = explode('-', $date);
			$date = $annee . "-" . $mois . "-" . $jour;

			$eleves = [];
			if (isset($_REQUEST['selectedEleves'])) {
				$eleves2 = explode(",", $_REQUEST['selectedEleves']);
				if (count($eleves2) > 0 and $eleves2[0] != "") {
					$eleves = array_merge($eleves, $eleves2);
				}
			}

			if (isset($_REQUEST['dons']) and $_REQUEST['dons'] == "on") {
				$dons = 1;
			} else {
				$dons = 0;
			}

			if (isset($_REQUEST['adhesion_caf']) and $_REQUEST['adhesion_caf'] == "on") {
				$adhesion_caf = 1;
				$adhesion_tarif_plein = 0;
			} else if (isset($_REQUEST['adhesion_tarif']) and $_REQUEST['adhesion_tarif'] == "on") {
				$adhesion_tarif_plein = 1;
				$adhesion_caf = 0;
			} else {
				$adhesion_tarif_plein = 0;
				$adhesion_caf = 0;
			}

			if (isset($_REQUEST['soutien']) and $_REQUEST['soutien'] == "on") {
				$soutien = 1;
			} else {
				$soutien = 0;
			}

			$pdo->modifReglement($num, $nom, $date, $type, $transaction, $banque, $montant, $commentaire, $eleves, $dons, $adhesion_caf, $adhesion_tarif_plein, $soutien);

			echo '<div id="contenu">';
			echo ' <h3> Le réglement a bien été modifié ! </h3>';
			echo '</div>';

			//redirect('index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $num,"1");


			break;
		}

		// Validation d'une modif d'une inscription du stage
	case 'ValidationModifInscriptionStage': {
			include("vues/v_entete.php");
			$numInscription = $_REQUEST['numInscription'];
			$numEleve = $_REQUEST['numInscription'];
			$numStage = $_REQUEST['numInscription'];

			$pdo->modifInscriptionStage($numInscription);

			echo '<div id="contenu">';
			echo ' <h3> L inscription a bien été modifié ! </h3>';
			echo '</div>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesStages&unStage=' . $numStage, "1");
		}



	case 'ajoutAnneeIntervenant': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$annee = $_POST['annee'];

			$pdo->ajoutAnneeIntervenant($num, $annee);

			echo '<div id="contenu">';
			echo ' <h3> L\'inscription à l\'année a bien été faite ! </h3>';
			echo '</div>';



			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $num . '', "1");

			break;
		}


	case 'supprimerAnneeIntervenant': {
			include("vues/v_entete.php");
			$num = $_GET['num'];
			$annee = $_GET['annee'];

			$pdo->supprimerAnneeIntervenant($num, $annee);

			echo '<div id="contenu">';
			echo ' <h3> La suppression de l\'inscription à l\'année a bien été faite ! </h3>';
			echo '</div>';




			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $num . '', "1");

			break;
		}

	case 'suprInscriptionStage': {
			include("vues/v_entete.php");
			$num = $_GET['num'];
			$numStage = $_GET['numStage'];
			$numInscription = $_GET['numInscription'];

			$pdo->suprInscriptionStage($num, $numInscription);

			echo '<div id="contenu">';
			echo ' <h3> La suppression de l\'inscription a bien été faite ! </h3>';
			echo '</div>';

			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=inscriptions', "1");

			break;
		}


	case 'supprimerUnLieu': {
			include("vues/v_entete.php");
			$num = $_GET['num'];

			$pdo->supprimerUnLieu($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression du lieu a bien été faite ! </h3>';
			echo '</div>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages&onglet=lieux', "1");
      break;
    }



		case 'supprimerUnPartenaire':
	  {
			include("vues/v_entete.php");
			$num=$_GET['num'];

			$pdo->supprimerUnPartenaire($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression du partenaire a bien été faite ! </h3>';
			echo '</div>';

      //Utilisation
      redirect('index.php?choixTraitement=administrateur&action=ParametresStages&onglet=partenaires',"1");

      break;
    }



	case 'supprimerRdv':
	{
      include('./test.php');
      //require('./quickstart.php');
			include("vues/v_entete.php");


      $capi = new GoogleCalendarApi();
      $access_token = $_SESSION['access_token'];


			$num=$_GET['num'];
      //on a un rdv bsb
      if ($_GET["typeRDV"] == "BSB") {
        $Calendrier = "a4bv3s31gpkhtg74lf32csj4t8@group.calendar.google.com";
      }
      //on a un rdv parent
      elseif ($_GET["typeRDV"] == "PARENTS") {
        $Calendrier = "abssce0v033p6av125vb6qrivo@group.calendar.google.com";
      }
      $id_google = $pdo->recupRdvIdGoogle($num);
      $id_google = $id_google[0]["idgoogle"];

      //la ligne contient un identifiant google calendar
      if (!empty($id_google)) {
        //$eraseEvent = $service->events->delete($Calendrier, $idgoogle);
        $supprimerEvenement = $capi->DeleteCalendarEvent($id_google, $Calendrier, $access_token);
      }
      //la ligne contient un identifiant google calendar et l'évènement à été supprimer de google calendar
      if (!empty($id_google) && $supprimerEvenement == true) {
        $pdo->supprimerRdv($num);
        echo '<div id="contenu">';
  			echo ' <h3> La suppression du rendez-vous a bien été faite ! </h3>';
  			echo '</div>';
      }
     //on supprime la ligne de la table ville_rdvparents même si on à pas trouver l'évènement qui est associé dans google calendar
      else{
        $pdo->supprimerRdv($num);
        echo '<div id="contenu">';
  			echo ' <h3> La suppression du rendez-vous a bien été faite ! </h3>';
  			echo '</div>';
      }

//Utilisation
//redirect('index.php?choixTraitement=administrateur&action=LesEleves');

		break;
	}



	case 'ajoutReglementValidation':
	{
		include("vues/v_entete.php");

		if (
			!isset(
				$_REQUEST['num'],
				$_REQUEST['nom'],
				$_REQUEST['date'],
				$_REQUEST['type'],
				$_REQUEST['montant']
			)
		) {
			echo '<div id="contenu">';
			echo ' <h3 class="text-warning"> Un des champs n\'a pas été rempli ! </h3>';
			echo '</div>';
			return;
		}

		$nom = $_REQUEST['nom'];
		$date = $_REQUEST['date'];
		$type = $_REQUEST['type'];
		if (isset($_REQUEST['num_transaction'])) {
			$transaction = $_REQUEST['num_transaction'];
		} else {
			$transaction = "";
		}
		if (isset($_REQUEST['banque'])) {
			$banque = $_REQUEST['banque'];
		} else {
			$banque = "";
		}
		if ($type != 1 and $type != 151) {
			$cheque = " ";
			$banque = " ";
		}
		$montant = $_REQUEST['montant'];
		if (isset($_REQUEST['commentaires'])) {
			$commentaire = $_REQUEST['commentaires'];
		} else {
			$commentaire = "";
		}

		$eleves = [];
		if (isset($_REQUEST['selectedEleves'])) {
			$eleves2 = explode(",", $_REQUEST['selectedEleves']);
			if (count($eleves2) > 0 and $eleves2[0] != "") {
				$eleves = array_merge($eleves, $eleves2);
			}
		}

		if (isset($_REQUEST['dons']) and $_REQUEST['dons'] == "on") {
			$dons = 1;
		} else {
			$dons = 0;
		}

			break;
		}



	case 'supprimerUnPartenaire': {
			include("vues/v_entete.php");
			$num = $_GET['num'];

			$pdo->supprimerUnPartenaire($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression du partenaire a bien été faite ! </h3>';
			echo '</div>';

			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=ParametresStages&onglet=partenaires', "1");

			break;
		}



	case 'supprimerRdv': {
			include('./test.php');
			//require('./quickstart.php');
			include("vues/v_entete.php");


			$capi = new GoogleCalendarApi();
			$access_token = $_SESSION['access_token'];


			$num = $_GET['num'];
			//on a un rdv bsb
			if ($_GET["typeRDV"] == "BSB") {
				$Calendrier = "a4bv3s31gpkhtg74lf32csj4t8@group.calendar.google.com";
			}
			//on a un rdv parent
			elseif ($_GET["typeRDV"] == "PARENTS") {
				$Calendrier = "abssce0v033p6av125vb6qrivo@group.calendar.google.com";
			}
			$id_google = $pdo->recupRdvIdGoogle($num);
			$id_google = $id_google[0]["idgoogle"];

			//la ligne contient un identifiant google calendar
			if (!empty($id_google)) {
				//$eraseEvent = $service->events->delete($Calendrier, $idgoogle);
				$supprimerEvenement = $capi->DeleteCalendarEvent($id_google, $Calendrier, $access_token);
			}
			//la ligne contient un identifiant google calendar et l'évènement à été supprimer de google calendar
			if (!empty($id_google) && $supprimerEvenement == true) {
				$pdo->supprimerRdv($num);
				echo '<div id="contenu">';
				echo ' <h3> La suppression du rendez-vous a bien été faite ! </h3>';
				echo '</div>';
			}
			//on supprime la ligne de la table ville_rdvparents même si on à pas trouver l'évènement qui est associé dans google calendar
			else {
				$pdo->supprimerRdv($num);
				echo '<div id="contenu">';
				echo ' <h3> La suppression du rendez-vous a bien été faite ! </h3>';
				echo '</div>';
			}

			//Utilisation
			//redirect('index.php?choixTraitement=administrateur&action=LesEleves');

			break;
		}










	case 'ajoutReglementValidation': {
			include("vues/v_entete.php");

			if (
				!isset(
					$_REQUEST['num'],
					$_REQUEST['nom'],
					$_REQUEST['date'],
					$_REQUEST['type'],
					$_REQUEST['montant']
				)
			) {
				echo '<div id="contenu">';
				echo ' <h3 class="text-warning"> Un des champs n\'a pas été rempli ! </h3>';
				echo '</div>';
				return;
			}

			$nom = $_REQUEST['nom'];
			$date = $_REQUEST['date'];
			$type = $_REQUEST['type'];
			if (isset($_REQUEST['num_transaction'])) {
				$transaction = $_REQUEST['num_transaction'];
			} else {
				$transaction = "";
			}
			if (isset($_REQUEST['banque'])) {
				$banque = $_REQUEST['banque'];
			} else {
				$banque = "";
			}
			if ($type != 1 and $type != 151) {
				$cheque = " ";
				$banque = " ";
			}
			$montant = $_REQUEST['montant'];
			if (isset($_REQUEST['commentaire'])) {
				$commentaire = $_REQUEST['commentaire'];
			} else {
				$commentaire = "";
			}

			$eleves = [];
			if (isset($_REQUEST['selectedEleves'])) {
				$eleves2 = explode(",", $_REQUEST['selectedEleves']);
				if (count($eleves2) > 0 and $eleves2[0] != "") {
					$eleves = array_merge($eleves, $eleves2);
				}
			}

			if (isset($_REQUEST['dons']) and $_REQUEST['dons'] == "on") {
				$dons = 1;
			} else {
				$dons = 0;
			}

			if (isset($_REQUEST['adhesion_caf']) and $_REQUEST['adhesion_caf'] == "on") {
				$adhesion_caf = 1;
				$adhesion_tarif_plein = 0;
			} else if (isset($_REQUEST['adhesion_tarif']) and $_REQUEST['adhesion_tarif'] == "on") {
				$adhesion_tarif_plein = 1;
				$adhesion_caf = 0;
			} else {
				$adhesion_tarif_plein = 0;
				$adhesion_caf = 0;
			}

			if (isset($_REQUEST['soutien']) and $_REQUEST['soutien'] == "on") {
				$soutien = 1;
			} else {
				$soutien = 0;
			}

			$pdo->ajoutReglement($nom, $date, $type, $transaction, $banque, $montant, $commentaire, $eleves, $dons, $adhesion_caf, $adhesion_tarif_plein, $soutien);

			echo '<div id="contenu">';
			echo ' <h3> Le réglement a bien été ajouté aux élèves ! </h3>';
			echo '</div>';
			break;
		}

	case 'AjouterDocumentIntervenant': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			//On crée le dossier
			mkdir('documentsIntervenants/' . $num);
			//on stock le fichier
			move_uploaded_file($_FILES['fichier1']['tmp_name'], 'documentsIntervenants/' . $num . '/' . basename($_FILES['fichier1']['name']));

			echo '<div id="contenu">';
			echo ' <h3> Le document a bien été ajouté à l\'intervenant ! </h3>';

			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $num . '', "1");

			echo '</div>';
			break;
		}


	case 'LesElevesModifier': {
			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$nom = $_REQUEST['nom'];
			$password = hash_password(htmlspecialchars($_REQUEST['password']));
			$prenom = $_REQUEST['prenom'];
			$sexe = $_REQUEST['sexe'];
			$date_naissance = $_POST['date_naissance'];
			$tel_enfant = $_REQUEST['tel_enfant'];
			$email_enfant = $_REQUEST['email_enfant'];
			$responsable_legal = $_REQUEST['responsable_legal'];
			$tel_parent = $_REQUEST['tel_parent'];
			$tel_parent2 = $_REQUEST['tel_parent2'];
			$tel_parent3 = $_REQUEST['tel_parent3'];
			$profession_pere = $_REQUEST['profession_pere'];
			$adresse = $_REQUEST['adresse'];
			$profession_mere = $_REQUEST['profession_mere'];
			$cp = $_REQUEST['cp'];
			$ville = $_REQUEST['ville'];
			$email_parent = $_REQUEST['email_parent'];
			$prevenir_parent = $_REQUEST['prevenir_parent'];
			$commentaires = $_REQUEST['commentaires'];
			$assurance = $_REQUEST['CAF'];

			$password = $_REQUEST['password'];

			$numAllocataire = $_REQUEST['numAllocataire'];
			$nbTempsLibres = $_REQUEST['nombreTempsLibres'];
			$contactParents = $_REQUEST['contactParents'];

			$annees = $_REQUEST['annee_scolaire'];





			//on stock le fichier
			move_uploaded_file($_FILES['fichier']['tmp_name'], 'photosEleves/' . basename($_FILES['fichier']['name']));
			$photo = $_FILES['fichier']['name'];

			//$message = "le fichier à été stocker à cette adresse: photosIntervenants/".$_FILES['fichier']['name'].".";



			if ($photo == "") {
				$EleveSelectionner = $pdo->recupUnEleves($num);
				$photoEleve = $EleveSelectionner['PHOTO'];
				$photo = $photoEleve;
			}

			if ($password != "") {
				$password = hash_password($password);
				$pdo->modifElevesAvecCode($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant, $responsable_legal, $tel_parent, $tel_parent2, $tel_parent3, $profession_pere, $adresse, $profession_mere, $ville, $email_parent, $prevenir_parent, $commentaires, $cp, $assurance, $codebarre, $password, $_REQUEST['num'], $numAllocataire, $nbTempsLibres, $contactParents, $photo);
			} else {
				$pdo->modifElevesSansCode($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant, $responsable_legal, $tel_parent, $tel_parent2, $tel_parent3, $profession_pere, $adresse, $profession_mere, $ville, $email_parent, $prevenir_parent, $commentaires, $cp, $assurance, $codebarre, $_REQUEST['num'], $numAllocataire, $nbTempsLibres, $contactParents, $photo);
			}
			// Années scolaires

			/*foreach($annees as $val) {

			$pdo->executerRequete('INSERT INTO `inscrit_annees` VALUES (' . $val . ', ' . $num . '); ');

		}*/

			echo '<div id="contenu">';
			echo ' <h3> Les informations de l\'elève ont bien été modifiés ! </h3>';


			//Utilisation
			//redirect('index.php?choixTraitement=administrateur&action=LesEleves&unEleve='.$num.'',"1");

			echo '</div>';



			break;
		}
	case 'caf': {
			$journal = $_REQUEST['journal'];
			$LesEleves 	= $pdo->recupTousEleves();
			$Caf 	= $pdo->getLesJournauxCAF();
			include("vues/v_entete.php");
			include("vues/administrateur/v_Caf.php");
			break;
		}

	case 'genererBordereauEleve': {
			if (isset($_REQUEST['dateDebut'])) {
				$dateDebut = $_REQUEST['dateDebut'];
			}

			if (isset($_REQUEST['dateFin'])) {
				$dateFin = $_REQUEST['dateFin'];
			}

			$hasBanque = false;

			if (isset($_REQUEST['type'])) {
				$type = $_REQUEST['type'];

				if ($type == 1 || $type == 0) {
					$hasBanque = true;
				}
			}

			$lesReglements 	= $pdo->getLesReglements($dateDebut, $dateFin, $type);
			$totalReglement = count($lesReglements);
			$totalMontant = 0;
			foreach ($lesReglements as $reglement) {
				$totalMontant += $reglement['MONTANT'];
			}
			include("vues/v_entete.php");
			include("vues/administrateur/v_BorderauxEleve.php");
			break;
		}

	case 'carteElevesPDF': {
			$LesEleves 	= $pdo->recupTousEleves();
			require('fpdf/fpdf.php');
			$pdf = new FPDF();
			include("vues/administrateur/v_carteEleve.php");
			$pdf->Output();
			break;
		}

	case 'supprimerUnEleve': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];

			$pdo->suppEleve($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression de l\'élève a bien été faite ! </h3>';
			echo '</div>';
			redirect('index.php?choixTraitement=administrateur&action=LesEleves', "1");
			break;


			break;
		}



	case 'supprimerUnAtelier': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];
			$numStage = $_REQUEST['numStage'];

			$pdo->suppUnAtelier($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression de l\'atelier a bien été faite ! </h3>';
			echo '</div>';


			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=Stages&unStage=' . $numStage . '&onglet=ateliers', "1");

			break;


			break;
		}

	case 'supprimerUneScolarite': {

			include("vues/v_entete.php");
			$num = $_GET['num'];
			$annee = $_GET['annee'];

			$pdo->suppSpecialites($num, $annee);
			$pdo->suppDifficultes($num, $annee);
			$pdo->suppScolarite($num, $annee);

			echo '<div id="contenu">';
			echo ' <h3> La suppression de l\'annee a bien été faite ! </h3>';
			echo '</div>';
			//Utilisation
			redirect('index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $num . '', "1");
			break;
		}


	case 'supprimerUnIntervenant': {

			include("vues/v_entete.php");
			$num = $_REQUEST['num'];

			$pdo->suppIntervenant($num);

			echo '<div id="contenu">';
			echo ' <h3> La suppression de l\'intervenant a bien été faite ! </h3>';
			echo '</div>';
			break;


			break;
		}


		// Absents au scolaire
	case 'absents': {
			// Entete de la page
			include("vues/v_entete.php");
      if (isset($_REQUEST['num'])) {

          $num = $_REQUEST['num'];

          // On récupère les élèves absents
          $lesAbsents = $pdo->lesAbsents($num);
        }

        // Page d'accueil
        include("vues/administrateur/v_absents.php");

        // Arrêt de la boucle
        break;
      }






	// gestion des appels et présences centre info


	case 'LesPresencesCentreInfo':
		// La partie "GET"
		$dateCircuit = date('Y-m-d'); 
		$lesActivites = $pdo->getActivites();
		include("vues/v_entete.php");
	
		// Initialiser le tableau des présences
		$tableauUtilisateur = [];
	
		// La partie "POST"
		if (isset($_POST['jourSemaine']) && isset($_POST['mois'])) {
			$jourSemaine = intval($_POST['jourSemaine']);
			$mois = intval($_POST['mois']);
		
			// Appel de la fonction pour obtenir les données
			$tableauUtilisateur = $pdo->afficherPresencesCentreInfo($jourSemaine, $mois);
		
			// Vérification du retour de la fonction
			if ($tableauUtilisateur === false || empty($tableauUtilisateur)) {
				echo "Erreur lors de la récupération des données.<br>";
			} else {
				echo "Données récupérées avec succès.<br>";
			}
		}
		
	
		// Afficher les résultats
		include("vues/administrateur/centreinfo/v_LesPresencesCentreInfo.php");
		break;

	case 'appelCentreInfoTest':
		{
			include("vues/v_entete.php");
		
			// La partie "GET"
			$anneeEnCours = $pdo->getAnneeEnCours();
		
			$rd = false;
			$laDate = date('Y-m-d');
			if (isset($_POST['dateAppel'])) {
				$laDate = $_POST['dateAppel'];
				$rd = true;
			} elseif (isset($_GET['date'])) {
				$laDate = htmlspecialchars($_GET['date']);
			}
		
			$moment = getMomentJournee();
			if (isset($_POST['moment']) && in_array($_POST['moment'], ['1', '2'], true)) {
				$moment = (int)$_POST['moment'];
				$rd = true;
			} elseif (isset($_GET['moment']) && in_array($_GET['moment'], ['1', '2'], true)) {
				$moment = (int)$_GET['moment'];
			}
		
			if ($rd) {
				redirect('index.php?choixTraitement=administrateur&action=appelCentreInfo&date=' . $laDate . '&moment=' . $moment, 1);
				break;
			}
		
			$lesUtilisateursCentreInfo = $pdo->getUtilisateursCentreInfo();
			$presents = $pdo->recupUtilisateursCentreInfoPresentDate($laDate);
		
			$presents = array_combine(
				array_map(static function ($present) { return $present['ID_UTILISATEUR']; }, $presents),
				array_map(static function ($present) { return (int)$present['PRESENT']; }, $presents)
			);
		
			include("vues/administrateur/centreinfo/v_appelCentreInfoTest.php");
		
			break;
		}


		case 'valideAppelUtilisateursCentreInfo':
			{
				include("vues/v_entete.php");
				$dateAppel = $_POST['date'] ?? '';
				$appel = $_POST['appel'] ?? [];
				foreach ($appel as $idUtilisateur) {
					$heure = $_REQUEST['heure' . $idUtilisateur] ?? null;
					$heure_arrivee = $_REQUEST['heure_arrivee' . $idUtilisateur] ?? null; 
					$activite = $_REQUEST['activite' . $idUtilisateur] ?? 'fablab';
					$pdo->ajoutAppelCentreInfo($idUtilisateur, $dateAppel, $heure, $heure_arrivee, $activite);

				}
				echo "<h2 class='text-center' style='color:green;'>L'appel pour les adhérents du centre info a bien été fait et sans erreurs.</h2>";
				break;
			}

    // Générer un recu pour un réglement pour une activité centre info
    case 'recuInfo': {

			if (isset($_REQUEST['num'])) {

				$num = $_REQUEST['num'];

				// On récupère les élèves absents
				$lesAbsents = $pdo->lesAbsents($num);
			}

			// Page d'accueil
			include("vues/administrateur/v_absents.php");

			// Arrêt de la boucle
			break;
		}

		// Générer un recu pour un réglement au scolaire
	case 'recuScolaire': {

			// Si une reglement est envoyée
			if (isset($_REQUEST['num'])) {

				$numReglement = $_REQUEST['num'];
				$numEleve = $_REQUEST['eleve'];

				// On récupère l'inscription de l'élève
				$lEleve = $pdo->recupUnEleves($numEleve);

				// Coordonnées de ORE
				$nom = $pdo->getParametre(10);
				$adresse = $pdo->getParametre(11);
				$cp = $pdo->getParametre(12);
				$ville = $pdo->getParametre(13);
				$tel = $pdo->getParametre(14);
				$email = $pdo->getParametre(15);

				// On récupère le règlement de l'élève
				$unReglement = $pdo->recupUnReglementUnEleve($numReglement);

				// Infos de l'élève
				$eleves = $pdo->recupeElevesWithReglement($numReglement);
				$infos = $pdo->getInfosReglement($unReglement['ID_INFO_REGLEMENT']);

				// Génération PDF
				include("vues/administrateur/v_recuScolaire.php");
			}

			// Arrêt de la boucle
			break;
		}

		// Générer un recu pour un réglement dans un stage
	case 'recuStage': {

			// Si une reglement est envoyée
			if (isset($_REQUEST['num'])) {

				$num = $_REQUEST['num'];
				$numStage = $_REQUEST['numStage'];

				// Coordonnées de ORE
				$nom = $pdo->getParametre(10);
				$adresse = $pdo->getParametre(11);
				$cp = $pdo->getParametre(12);
				$ville = $pdo->getParametre(13);
				$tel = $pdo->getParametre(14);
				$email = $pdo->getParametre(15);

				// On récupère le règlement de l'éève
				$uneInscription = $pdo->recupUneInscription($num);

				// Infos du stage
				$stageSelectionner = $pdo->recupUnStage($numStage);

				// Infos de l'élève
				$LesInscriptionsFratries = [];
				$fratrie = $pdo->getReglementFratrieStage($uneInscription['ID_INSCRIPTIONS']);
				if ($fratrie !== []) {
					foreach ($fratrie as $unFratrie) {
						$LesInscriptionsFratries[] = $pdo->recupUneInscription($unFratrie['ID_INSCRIPTIONS2']);
					}
				}

				$infos = $pdo->getInfosReglement($uneInscription['ID_INSCRIPTIONS']);

				// Génération PDF
				include("vues/administrateur/v_recuStage.php");
			}

			// Arrêt de la boucle
			break;
		}


		/* -------------- CENTRE INFO ---------------------- */

		// Générer un recu pour un réglement pour une activité centre info
	case 'recuInfo': {

			// Si une reglement est envoyée
			if (isset($_REQUEST['num'])) {

				$reglement = $_REQUEST['num'];
				$inscription = $_REQUEST['inscription'];
				$activite = $_REQUEST['activite'];

				// Coordonnées de ORE
				$nom = $pdo->getParametre(10);
				$adresse = $pdo->getParametre(11);
				$cp = $pdo->getParametre(12);
				$ville = $pdo->getParametre(13);
				$tel = $pdo->getParametre(14);
				$email = $pdo->getParametre(15);

				// On récupère l'inscription de la personne
				$uneInscription = $pdo->info_getUneInscription($inscription);

				// On récupère les règlements
				$unReglement = $pdo->info_getUnReglement($reglement);

				// On récupère les types de réglement
				$lesTypesReglements = $pdo->getParametre(5);

				// Infos de l'activité
				$uneActivite = $pdo->info_getActivite($activite);

				// Génération PDF
				include("vues/administrateur/centreinfo/v_recuInfo.php");
			}

			// Arrêt de la boucle
			break;
		}

		// Page d'accueil
	case 'info_accueil': {
			// Entete de la page
			include("vues/v_entete.php");

			// Page d'accueil
			include("vues/administrateur/centreinfo/v_accueil.php");

			// Arrêt de la boucle
			break;
		}

		// Page des documents
	case 'info_documents': {
			// On récupère les documents
			$lesDocuments = $pdo->info_getDocumentsTout();

			// Entete de la page
			include("vues/v_entete.php");

			// Page des documents
			include("vues/administrateur/centreinfo/v_documents.php");

			// Arrêt de la boucle
			break;
		}

		// Page des visites
	case 'info_visites': {
			if (isset($_REQUEST['periode'])) {

				if ($_REQUEST['periode'] == 'tout') {

					// Si toutes les visites sont demandées
					$lesVisites = $pdo->info_getVisitesTout();
				} else {

					$lesVisites = $pdo->info_getVisitesMois($_REQUEST['periode']);
				}
			}

			$lesMois = $pdo->info_getMoisVisites();

			// Entete de la page
			include("vues/v_entete.php");

			// Page des visites
			include("vues/administrateur/centreinfo/v_visites.php");

			// Arrêt de la boucle
			break;
		}

		// Télécharger un document
	case 'info_telechargerDocument': {
			// Si un ID est indiqué et numérique
			if (isset($_REQUEST['id_document']) and is_numeric($_REQUEST['id_document'])) {

				// On récupère le document
				$num = $_REQUEST['id_document'];

				$leDocument = $pdo->info_getDocument($num);

				$taille = $leDocument['taille_document'];
				$type = $leDocument['type_document'];
				$nom = $leDocument['nom_document'];
				$fichier = $leDocument['contenu_document'];

				// Téléchargement
				include("vues/administrateur/v_telechargerFichier.php");
			}

			// Arrêt de la boucle
			break;
		}

		// Page des inscriptions
	case 'info_inscriptions': {

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// On récupère l'onglet à afficher
			$onglet = $_REQUEST['onglet'];

			// On récupère la liste des inscriptions
			$lesInscriptions = $pdo->info_getInscriptions($anneeEnCours);
			//$lesInscriptions = $pdo->getUtilisateurCentreInfo($anneeEnCours);

			// Si une inscription est sélectionnée
			if (isset($_REQUEST['uneInscription'])) {

				// On récupère le numéro de l'inscription
				$num = $_REQUEST['uneInscription'];

				// On récupère les données de l'inscription donnée
				$inscriptionSelectionner = $pdo->info_getUneInscription($num);

				// On récupère les activités auxquelles est inscrite la personne
				$temp = $pdo->info_getActivitesPourUneInscription($num);

				// On stocke les informations de chaque activité dans un tableau
				$lesActivitesInscrites = array();

				$i = 0;

				foreach ($temp as $uneActivite) {
					$lesActivitesInscrites[$i] = $pdo->info_getActivite($uneActivite['id_activite']);
					$i++;
				}

				// On récupère les documents de la personne
				$lesDocuments = $pdo->info_getDocuments($num);

				// On récupère les visites de la personne
				$lesVisites = $pdo->info_getVisites(addslashes($inscriptionSelectionner['nom_cyberlux_inscription']));
			}

			// Entete de la page
			include("vues/v_entete.php");

			// Page de gestion des inscriptions
			include("vues/administrateur/centreinfo/v_inscriptions.php");

			// Arrêt de la boucle
			break;
		}

		// Voir la carte d'un élève ou d'un intervenant
	case 'macarte': {
			if (isset($_GET["eleve"])) {
				$numeleve = (int)$_GET["eleve"];
				$eleve = $pdo->recupUnEleves($numeleve);
				$identEleve = $pdo->getidentifianteleves($numeleve);
				$emplacementPhoto = "photosEleves";
				$utilisateur = $eleve;
				$id_utilisateur = $numeleve;
				$typeUtilisateur = "Élève";
				$acronymeUtilisateur = "e";
			} elseif (isset($_GET["intervenant"])) {
				$numintervenant = (int)$_GET["intervenant"];
				$intervenant = $pdo->recupUnIntervenant($numintervenant);
				$emplacementPhoto = "photosIntervenants";
				$utilisateur = $intervenant;
				$id_utilisateur = $numintervenant;
				$typeUtilisateur = "Intervenant";
				$acronymeUtilisateur = "i";

				$specialites = $pdo->getSpecialisationIntervenant($numintervenant);
				if (count($specialites) > 0) {
					$utilisateur['SPECIALITE'] = [];
					foreach ($specialites as $specialiteId) {
						$specialite = $pdo->getParametreId($specialiteId['ID']);
						if ($specialite !== null) {
							$utilisateur['SPECIALITE'][] = $specialite['NOM'];
						}
					}
				}
			}

			// Entete de la page
			include("vues/v_entete.php");

			// Page de la carte de l'élève ou de l'intervenant
			include("vues/administrateur/v_macarte.php");

			break;
		}

		// Ajouter une inscription
	case 'info_ajouterUneInscription': {
			// Entete de la page
			include("vues/v_entete.php");

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// Page de nouvelle inscription
			include("vues/administrateur/centreinfo/v_ajouterUneInscription.php");

			// Arrêt de la boucle
			break;
		}

		// Validation d'une inscription
	case 'info_ajouterUneInscriptionValidation': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['nom'])) {

				// On récupère ses coordonnées GPS
				$coordonnees = getGps($_REQUEST['adresse'], $_REQUEST['cp'], $_REQUEST['ville']);

				// On ajoute l'inscription
				$pdo->info_ajouterUneInscription(
					htmlentities(addslashes($_REQUEST['nom']), ENT_QUOTES),
					htmlentities(addslashes($_REQUEST['prenom']), ENT_QUOTES),
					htmlentities(addslashes($_REQUEST['adresse']), ENT_QUOTES),
					$_REQUEST['cp'],
					htmlentities(addslashes($_REQUEST['ville']), ENT_QUOTES),
					$coordonnees['lat'],
					$coordonnees['lon'],
					$_REQUEST['sexe'],
					$_REQUEST['ddn'],
					$_REQUEST['date'],
					$_REQUEST['tel1'],
					$_REQUEST['tel2'],
					addslashes($_REQUEST['email']),
					$_REQUEST['annee']
				);

				// On redirige l'utilisateur vers les inscriptions
				redirect('index.php?choixTraitement=administrateur&action=info_inscriptions', "1");
			}

			// Arrêt de la boucle
			break;
		}

		// Modifier une inscription
	case 'info_modifierUneInscription': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['num'])) {

				// On récupère ses coordonnées GPS
				$coordonnees = getGps($_REQUEST['adresse'], $_REQUEST['cp'], $_REQUEST['ville']);

				// On modifie l'inscription
				$pdo->info_modifierUneInscription(
					$_REQUEST['num'],
					htmlentities(addslashes($_REQUEST['nom']), ENT_QUOTES),
					htmlentities(addslashes($_REQUEST['prenom']), ENT_QUOTES),
					htmlentities(addslashes($_REQUEST['adresse']), ENT_QUOTES),
					$_REQUEST['cp'],
					htmlentities(addslashes($_REQUEST['ville']), ENT_QUOTES),
					$coordonnees['lat'],
					$coordonnees['lon'],
					$_REQUEST['sexe'],
					$_REQUEST['ddn'],
					$_REQUEST['date'],
					$_REQUEST['tel1'],
					$_REQUEST['tel2'],
					addslashes($_REQUEST['email'])
				);

				// On redirige l'utilisateur vers la fiche d'inscription
				redirect('index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $_REQUEST['num'], "1");
			}

			// Arrêt de la boucle
			break;
		}

		// Supprimer une inscription
	case 'info_supprimerUneInscription': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['num'])) {

				$pdo->info_supprimerUneInscription($_REQUEST['num']);
			}

			// On redirige l'utilisateur vers les inscriptions
			redirect('index.php?choixTraitement=administrateur&action=info_inscriptions', "1");

			break;
		}

		// Supprimer des visites
	case 'info_supprimerVisites': {

			// Si une période est envoyée
			if (isset($_REQUEST['periode'])) {

				$pdo->info_supprimerVisites($_REQUEST['periode']);
			}

			// On redirige l'utilisateur vers les visites
			redirect('index.php?choixTraitement=administrateur&action=info_visites', "1");

			break;
		}

		// Envoi d'un document
	case 'info_envoyerDocument': {

			// Si un document est envoyé
			if (isset($_FILES['fichier'])) {

				$fichier = $_FILES['fichier']['tmp_name'];

				// Infos sur le fichier
				$num = $_REQUEST['num'];
				$nomFichier = addslashes(basename($_FILES['fichier']['name']));
				$tailleFichier = filesize($fichier);
				$typeFichier = mime_content_type($fichier);
				$contenuFichier = addslashes(file_get_contents($fichier));
				$dateFichier = date('Y-m-d H:i:s', time());
				$commentaireFichier = htmlentities(addslashes($_REQUEST['commentaire']), ENT_QUOTES);

				// On enregistre ce document dans la base de données
				$pdo->info_envoyerDocument($num, $nomFichier, $contenuFichier, $tailleFichier, $typeFichier, $dateFichier, $commentaireFichier);

				// On redirige l'utilisateur vers les inscriptions
				redirect('index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $num . '&onglet=documents', "1");
			}

			break;
		}

		// Suppression d'un document
	case 'info_supprimerDocument': {

			// Si un document est indiqué
			if (isset($_REQUEST['num'])) {

				// On le supprime de la BDD
				$pdo->info_supprimerDocument($_REQUEST['id']);

				// On redirige l'utilisateur vers les inscriptions
				redirect('index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $_REQUEST['num'] . '&onglet=documents', "1");
			}

			break;
		}

		// Page des activités
	case 'info_activites': {

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// On récupère l'onglet à afficher
			$onglet = $_REQUEST['onglet'];

			// On récupère la liste des activités
			$lesActivites = $pdo->info_getActivites($anneeEnCours);

			// Si une activité est sélectionnée
			if (isset($_REQUEST['uneActivite'])) {

				// On récupère le numéro de l'activité
				$num = $_REQUEST['uneActivite'];

				// On récupère les données de l'activité donnée
				$activiteSelectionner = $pdo->info_getActivite($num);

				// Savoir si c'est l'accès libre
				$idAccesLibre = $pdo->info_getIdAccesLibre();

				if ($idAccesLibre['VALEUR'] == $activiteSelectionner['id_activite']) {
					$estAccesLibre = true;
				} else {
					$estAccesLibre = false;
				}

				// On récupère la liste des années de l'activité
				$lesAnnees = $pdo->info_getActiviteAnnees($num);

				// On récupère la liste des inscriptions à cette activité
				$lesInscriptions = $pdo->info_getInscriptionsPourUneActivite($num, $anneeEnCours);

				// On récupère la liste des inscriptions totales
				$lesInscriptionsTotales = $pdo->info_getInscriptions($anneeEnCours);

				// On récupère la liste des présences à cette activité
				$lesPresences = $pdo->info_getPresencesPourUneActivite($num);

				// On récupère la liste des réglements à cette activité
				$lesReglements = $pdo->info_getReglements($num);

				// On récupère les types de réglement
				$lesTypesReglements = $pdo->getParametre(5);

				// ---- Statistiques ----

				// Liste des présences 
				$stats_totalPresences = $pdo->info_getTotalPresences($num, $anneeEnCours);

				// Répartition par sexe
				$stats_repartitionSexe = $pdo->info_getRepartitionSexe($num, $anneeEnCours);

				// Répartition par ville
				$stats_repartitionVille = $pdo->info_getRepartitionVille($num, $anneeEnCours);

				// Répartition par age
				$stats_repartitionAge = $pdo->info_getRepartitionAge($num, $anneeEnCours);

				// Si accès libre
				if ($estAccesLibre) {

					// Répartition des visites par PC
					$stats_repartitionPC = $pdo->info_getStatsPC($anneeEnCours);
				}

				// Calcul des présences
				$totalPresences = 0;
				$nbDates = 0;
				foreach ($stats_totalPresences as $unePresence) {
					$totalPresences = ($totalPresences + $unePresence['COUNT(*)']);
					$nbDates++;
				}

				// Calcul de la moyenne des présences
				if ($nbDates == 0) {
					$stats_moyennePresences = 0;
				} else {
					$stats_moyennePresences = round($totalPresences / $nbDates);
				}
			}

			// Entete de la page
			include("vues/v_entete.php");

			// Page de gestion des inscriptions
			include("vues/administrateur/centreinfo/v_activites.php");

			// Arrêt de la boucle
			break;
		}

		// Ajouter une activité
	case 'info_ajouterUneActivite': {
			// Entete de la page
			include("vues/v_entete.php");

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// Page de nouvelle activite
			include("vues/administrateur/centreinfo/v_ajouterUneActivite.php");

			// Arrêt de la boucle
			break;
		}

		// Validation d'une activite
	case 'info_ajouterUneActiviteValidation': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['nom'])) {

				// On ajoute l'inscription
				$pdo->info_ajouterUneActivite(
					addslashes($_REQUEST['nom']),
					$_REQUEST['annee']
				);

				// On redirige l'utilisateur vers les activités
				redirect('index.php?choixTraitement=administrateur&action=info_activites', "1");
			}

			// Arrêt de la boucle
			break;
		}

		// Ajout d'une année pour une activite
	case 'info_ajouterUneAnneeActivite': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['num'])) {

				// On ajoute l'inscription
				$pdo->info_ajouterUneAnneeActivite(
					$_REQUEST['num'],
					$_REQUEST['annee']
				);

				// On redirige l'utilisateur vers les activités
				redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['num'], "1");
			}

			// Arrêt de la boucle
			break;
		}

		// Suppression d'une année pour une activite
	case 'info_supprimerUneAnneeActivite': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['num'])) {

				// On ajoute l'inscription
				$pdo->info_supprimerUneAnneeActivite(
					$_REQUEST['num'],
					$_REQUEST['annee']
				);

				// On redirige l'utilisateur vers les activités
				redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['num'], "1");
			}

			// Arrêt de la boucle
			break;
		}

		// Modification d'une activite
	case 'info_modifierUneActivite': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['num'])) {

				// On modifie l'inscription
				$pdo->info_modifierUneActivite(
					$_REQUEST['num'],
					htmlentities(addslashes($_REQUEST['nom']), ENT_QUOTES)
				);

				// On redirige l'utilisateur vers les activités
				redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['num'], "1");
			}

			// Arrêt de la boucle
			break;
		}

		// Supprimer une activité
	case 'info_supprimerUneActivite': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['num'])) {

				$pdo->info_supprimerUneActivite($_REQUEST['num']);
			}

			// On redirige l'utilisateur vers les activites
			redirect('index.php?choixTraitement=administrateur&action=info_activites', "1");
		}

		// Saisir les présences
	case 'info_saisirPresences': {

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// On récupère la liste des inscriptions
			$lesActivites = $pdo->info_getActivites($anneeEnCours);

			// Si une activité est sélectionnée
			if (isset($_REQUEST['num'])) {

				// On récupère le numéro de l'activité
				$num = $_REQUEST['num'];

				// On récupère les données de l'inscription donnée
				$activiteSelectionner = $pdo->info_getActivite($num);

				// On récupère la liste des inscriptions à cette activité
				$lesInscriptions = $pdo->info_getInscriptionsPourUneActivite($num, $anneeEnCours);
			}

			// Entete de la page
			include("vues/v_entete.php");

			// Page de gestion des inscriptions
			include("vues/administrateur/centreinfo/v_saisirPresences.php");

			// Arrêt de la boucle
			break;
		}

		// Enregistrer les présences
	case 'info_saisirPresencesValidation': {



			// Si les présences est envoyée
			if (isset($_REQUEST['num'])) {

				$date = date('Y-m-d', strtotime($_REQUEST["date"]));

				// On parcours les présences saisies
				foreach ($_REQUEST['presences'] as $laPresence) {

					// On enregistre la présence
					$pdo->info_saisirPresences(
						$_REQUEST['num'],
						$laPresence,
						$date,
						$_REQUEST['periode']
					);
				}

				// On redirige l'utilisateur vers l'activité
				redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['num'], "1");
			}



			// Arrêt de la boucle
			break;
		}


		// Supprimer une présence
	case 'info_supprimerUnePresence': {

			// Si une présence est envoyée
			if (isset($_REQUEST['num'])) {

				$pdo->info_supprimerUnePresence($_REQUEST['num']);
			}

			// On redirige l'utilisateur vers les activites
			redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['uneActivite'] . '&onglet=presences', "1");
		}

		// inscrire quelqu'un à une activité
	case 'info_inscrire': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['uneInscription'])) {

				// On récupère l'année en cours
				$anneeEnCours = $pdo->getAnneeEnCours();

				$pdo->info_inscrire($_REQUEST['uneInscription'], $_REQUEST['uneActivite'], $anneeEnCours);
			}

			// On redirige l'utilisateur vers les activites
			redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['uneActivite'] . '&onglet=inscriptions', "1");


			break;
		}

		// Désinscrire quelqu'un à une activité
	case 'info_desinscrire': {

			// Si une inscription est envoyée
			if (isset($_REQUEST['uneInscription'])) {

				// On récupère l'année en cours
				$anneeEnCours = $pdo->getAnneeEnCours();

				$pdo->info_desinscrire($_REQUEST['uneInscription'], $_REQUEST['uneActivite'], $anneeEnCours);
			}

			// On redirige l'utilisateur vers les activites
			redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['uneActivite'] . '&onglet=inscriptions', "1");

			break;
		}

		// Ajouter un réglement
	case 'info_ajouterUnReglement': {
			// Entete de la page
			include("vues/v_entete.php");

			// On récupère les types de réglement
			$lesTypesReglements = $pdo->getParametre(5);

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// On récupère les banques
			$lesBanques = $pdo->getLesBanques();

			// Numéro de l'inscription
			$uneActivite = $_REQUEST['uneActivite'];

			// On récupère la liste des activités
			$lesActivites = $pdo->info_getActivites($anneeEnCours);

			// On récupère les données de l'activité donnée
			$activiteSelectionner = $pdo->info_getActivite($uneActivite);

			// On récupère la liste des inscriptions à cette activité
			$lesInscriptions = $pdo->info_getInscriptionsPourUneActivite($uneActivite, $anneeEnCours);

			// Si une inscription est indiquée
			if (isset($_REQUEST['uneInscription'])) {

				// Numéro de l'inscription
				$uneInscription = $_REQUEST['uneInscription'];

				// On récupère les données de l'inscription donnée
				$inscriptionSelectionner = $pdo->info_getUneInscription($uneInscription);
			}

			// Page d'ajout de reglement
			include("vues/administrateur/centreinfo/v_ajouterUnReglement.php");

			// Arrêt de la boucle
			break;
		}

		// Enregistrer un réglement
	case 'info_ajouterUnReglementValidation': {

			// Si un reglement est envoyée
			if (isset($_REQUEST['uneActivite'])) {

				$date = $_REQUEST['date'];

				$pdo->info_ajouterUnReglement($_REQUEST['uneActivite'], $_REQUEST['uneInscription'], $_REQUEST['type'], $date, $_REQUEST['num_transaction'], htmlentities($_REQUEST['banque'], ENT_QUOTES), $_REQUEST['montant']);

				// On redirige l'utilisateur vers l'activité
				redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['uneActivite'] . '&onglet=reglements', "1");
			}

			// Arrêt de la boucle
			break;
		}

		// Récupérer les réglements effectuées pour une année du cours info
	case 'info_recupPayesImpayes': {
			include("vues/v_entete.php");

			if (isset($_POST["annee"])) {
				$Annee = $_REQUEST["annee"];
				$type = $_REQUEST["type"];
				$inscritsInfoAnnee = $pdo->info_getInscriptions($Annee);
				$payesInfoAnnee = $pdo->info_getReglementsAnnee($Annee, $type);
				$lesReglementsNonEffectues = $pdo->info_getImpayesReglement($Annee);
				$ctInscritsInfoAnnee = count($inscritsInfoAnnee);
				$ctpayesInscritsInfoAnnee = count($payesInfoAnnee);
				$cheque = $pdo->info_getReglementsAnnee($Annee, 1);
				$especes = $pdo->info_getReglementsAnnee($Annee, 2);
				$boncaf = $pdo->info_getReglementsAnnee($Annee, 3);
				$autre = $pdo->info_getReglementsAnnee($Annee, 80);
				$exonere = $pdo->info_getReglementsAnnee($Annee, 83);


				$camambert = array(
					array('Type' => 'Chèques', 'COUNT(*)' => count($cheque)),
					array('Type' => 'Especes', 'COUNT(*)' => count($especes)),
					array('Type' => 'Boncaf', 'COUNT(*)' => count($boncaf)),
					array('Type' => 'Autre', 'COUNT(*)' => count($autre)),
					array('Type' => 'Exonere', 'COUNT(*)' => count($exonere)),
				);
			}
			$type = $_REQUEST['type'];
			$lesAnneesInscription = $pdo->getLesAnneesInscriptions();
			$lesInscription = $pdo->info_getInscriptionsTout();

			include("vues/administrateur/centreinfo/v_payesImpayesInfo.php");
			break;
		}


		// Modifier un réglement
	case 'info_modifierUnReglement': {

			if (isset($_REQUEST['unReglement'])) {

				// Entete de la page
				include("vues/v_entete.php");

				// On récupère le réglement
				$leReglement = $pdo->info_getUnReglement($_REQUEST['unReglement']);

				// On récupère les banques
				$lesBanques = $pdo->getLesBanques();

				// On récupère l'année en cours
				$anneeEnCours = $pdo->getAnneeEnCours();

				// On récupère les types de réglement
				$lesTypesReglements = $pdo->getParametre(5);

				// Numéro de l'activité
				$uneActivite = $_REQUEST['activite'];

				// On récupère la liste des inscriptions à cette activité
				$lesInscriptions = $pdo->info_getInscriptionsPourUneActivite($uneActivite, $anneeEnCours);

				// une inscription
				$inscriptionSelectionner = $_GET['inscription'];

				// Numéro de l'inscription
				$uneInscription = $leReglement['id_inscription'];

				// Page de modification de reglement
				include("vues/administrateur/centreinfo/v_modifierUnReglement.php");
			}

			// Arrêt de la boucle
			break;
		}

	case 'info_modifierUnReglementValidation': {

			$unReglement = $_POST["unReglement"];
			$type = $_POST["type"];
			$date = $_POST["date"];
			$num_transaction = $_POST["num_transaction"];
			$banque = $_POST["banque"];
			$montant = $_POST["montant"];

			$modifierUnReglement = $pdo->info_modifierUnReglement($unReglement, $type, $date, $num_transaction, $banque, $montant);
			include("vues/v_entete.php");
			if ($modifierUnReglement) {
				//include("vues/v_entete.php");
				echo 'La modification à été réalisé avec succès';
			}

			break;
		}

		// Importation de données
	case 'info_import': {

			// Entete de la page
			include("vues/v_entete.php");

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// Page
			include("vues/administrateur/centreinfo/v_import.php");

			// Arrêt de la boucle
			break;
		}

		// Importation de données
	case 'info_import_validation': {



			// Entete de la page
			include("vues/v_entete.php");

			$type = $_REQUEST['type'];

			// On récupère toutes les inscriptions
			$lesInscriptions = $pdo->info_getInscriptionsTout();

			// On récupère les visites
			$lesVisites = $pdo->info_getVisitesTout();

			// On récupère l'année en cours
			$anneeEnCours = $pdo->getAnneeEnCours();

			// ID de l'activité Accès libre
			$idAccesLibre = $pdo->getParametre(107);

			// Page
			include("vues/administrateur/centreinfo/v_import_validation.php");

			// Arrêt de la boucle
			break;
		}

		// Exportation de données
	case 'info_export': {



			// Si une demande est envoyée
			if (isset($_REQUEST['export'])) {

				$export = $_REQUEST['export'];
				$anneeEnCours = $_REQUEST['anneeEnCours'];

				// Récupération des données demandées
				if ($export == 'inscriptions') {
					$donnees = $pdo->info_getInscriptions($anneeEnCours);
				}
				if ($export == 'activites') {
					$donnees = $pdo->info_getActivites($anneeEnCours);
				}
				if ($export == 'visites') {
					$donnees = $pdo->info_getVisitesTout();
				}
				if ($export == 'documents') {
					$donnees = $pdo->info_getDocumentsAnnee($anneeEnCours);
				}
				if ($export == 'reglements') {
					$donnees = $pdo->info_getReglementsAnnee($anneeEnCours);
				}

				// Création du fichier CSV
				//creerCsv($donnees);
				include("vues/administrateur/v_exportcsv.php");

				// Erreur
			} else {
				// Entete de la page
				include("vues/v_entete.php");

				echo '<h2>Erreur</h2><p>Aucune donnée envoyée.</p>';
			}

			// Page
			//include("vues/administrateur/centreinfo/v_import.php");

			// Arrêt de la boucle
			break;
		}


		// Supprimer un réglement
	case 'info_supprimerUnReglement': {

			// Si un réglement est envoyé
			if (isset($_REQUEST['unReglement'])) {

				$pdo->info_supprimerUnReglement($_REQUEST['unReglement']);
			}

			// On redirige l'utilisateur vers l'activite
			redirect('index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $_REQUEST['uneActivite'] . '&onglet=reglements', "1");

			break;
		}

		// Envoi d'un publipostage
	case 'info_envoyerPublipostage': {

			$num = $_REQUEST['num'];
			$emails = $_REQUEST['emails'];
			$objet = $_REQUEST['objet'];
			$message = nl2br($_REQUEST['message']);

			// Ajout de la signature
			$message .= '<p>_____________________________________________________<br><br>
			 <img src="https://association-ore.fr/extranet/images/logo.png" style="width:150px"><br>
             <b> Association ORE</b><br>
Adresse : 2A Bd Olivier de Serres - 21800 Quetigny (Maison des associations)<br>
Tél : 03 80 48 23 96<br>
Mail : association.ore@gmail.com<br>
Web : <a href="http://www.association-ore.fr">www.association-ore.fr</a><br>
Facebook : <a href="https://www.facebook.com/AssociationORE/">https://www.facebook.com/AssociationORE/ </a>
</p>';

			// Entete de la page
			include("vues/v_entete.php");

			echo '<h2>Publipostage</h2>
        <p><b>Envoi de ' . count($emails) . ' emails.</b></p>';

			$succes = 0;
			$echecs = 0;

			// On parcours les emails
			foreach ($emails as $unEmail) {

				$headers  = 'From: "ORE Ouverture Rencontre Evolution"' . "\r\n";
				$headers .= "Reply-To: association.ore@gmail.com" . "\r\n";
				//$headers .= "X-Priority: 5" . "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Envoi du mail
				$result = mail($unEmail, $objet, $message, $headers);

				$etats = array('échec', 'succès');
				$couleurs = array('red', 'green');

				if ($result) {
					$succes++;
				} else {
					$echecs++;
				}

				// Affichage du résultat
				echo '<div style="color:' . $couleurs[$result] . '">Envoi du message à ' . $unEmail . ' : ' . $etats[$result] . '</div>';
			}

			echo '</p>
        <p><b>' . $succes . '</b> envois avec succès et <b>' . $echecs . '</b> échecs.</p>
        <p>
            <a href="index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $num . '&onglet=publipostage" class="btn btn-info"><span class="glyphicon glyphicon-triangle-left"></span> Retour à l\'activité</a>
        </p>';

			// Arrêt de la boucle
			break;
		}
	case 'AjouterFratries':
		if (isset($_REQUEST['unEleve'], $_REQUEST['uneFratrie'])) {
			$pdo->AjouterFratries($_REQUEST['unEleve'], $_REQUEST['uneFratrie']);
		}
		redirect("index.php?choixTraitement=administrateur&action=LesEleves&unEleve=" . $_REQUEST['unEleve'], "1");
		break;
	case 'SuprimmerFratries':
		if (isset($_REQUEST['unEleve'])) {
			$pdo->SupprimerFratries($_REQUEST['unEleve']);
			redirect("index.php?choixTraitement=administrateur&action=LesEleves&unEleve=" . $_REQUEST['unEleve'], "1");
		}
		break;
	case 'contratBenevole':
		require_once 'vendor/autoload.php';

		if (isset($_GET['intervenant'])) {
			$id = (int)$_GET['intervenant'];
			$intervenant = $pdo->recupUnIntervenant($id);
			$annee = $pdo->getAnneeEnCours();

			if ($intervenant === null) {
				echo 'Impossible de trouver l\'intervenant';
				break;
			}

			$prenom = str_replace(['&eacute;', '&egrave;', '&euml;'], ['é', 'è', 'ë'], $intervenant['PRENOM']);

			$fileName = 'contrat-' . $id . '-' . str_replace(' ', '_', $intervenant['NOM'])
				. '-' . str_replace(' ', '_', $prenom) . '-' . $annee . '.docx';
			$filePath = __DIR__ . '/../documentsbenevole/' . $fileName;
			$template = __DIR__ . '/../documentsbenevole/modele-contrat-benevole.docx';

			//if (!file_exists($filePath)) {
			$values = [
				'nom' => $intervenant['NOM'],
				'prenom' => $prenom,
				'adresse' => $intervenant['ADRESSE_POSTALE'] ?? '',
				'cp' => $intervenant['CODE_POSTAL'] ?? '',
				'ville' => $intervenant['VILLE'] ?? '',
				'email' => $intervenant['EMAIL'] ?? '',
				'tel' => $intervenant['TELEPHONE'] ?? '',
				'annee' => $annee,
				'annee2' => $annee + 1,
				'date' => date('d/m/Y')
			];

			function xmlEntities($str)
			{
				$xml = array('&#34;', '&#38;', '&#38;', '&#60;', '&#62;', '&#160;', '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', '&#167;', '&#168;', '&#169;', '&#170;', '&#171;', '&#172;', '&#173;', '&#174;', '&#175;', '&#176;', '&#177;', '&#178;', '&#179;', '&#180;', '&#181;', '&#182;', '&#183;', '&#184;', '&#185;', '&#186;', '&#187;', '&#188;', '&#189;', '&#190;', '&#191;', '&#192;', '&#193;', '&#194;', '&#195;', '&#196;', '&#197;', '&#198;', '&#199;', '&#200;', '&#201;', '&#202;', '&#203;', '&#204;', '&#205;', '&#206;', '&#207;', '&#208;', '&#209;', '&#210;', '&#211;', '&#212;', '&#213;', '&#214;', '&#215;', '&#216;', '&#217;', '&#218;', '&#219;', '&#220;', '&#221;', '&#222;', '&#223;', '&#224;', '&#225;', '&#226;', '&#227;', '&#228;', '&#229;', '&#230;', '&#231;', '&#232;', '&#233;', '&#234;', '&#235;', '&#236;', '&#237;', '&#238;', '&#239;', '&#240;', '&#241;', '&#242;', '&#243;', '&#244;', '&#245;', '&#246;', '&#247;', '&#248;', '&#249;', '&#250;', '&#251;', '&#252;', '&#253;', '&#254;', '&#255;');
				$html = array('&quot;', '&amp;', '&amp;', '&lt;', '&gt;', '&nbsp;', '&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&not;', '&shy;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;');
				$str = str_replace($html, $xml, $str);
				$str = str_ireplace($html, $xml, $str);
				return $str;
			}



			foreach ($values as $key => $value) {
				$values[$key] = str_replace([
					'&agrave;', '&eacute;', '&egrave;', '&euml;', '&ium;', '<', '&', '>', '\'', '"'
				], [
					'à', 'é', 'è', 'ë', 'ï', '&#60;', '&#38;', '&#62;', '&#39;', '&#34;'
				], $value);
			}

			\PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
			$processor = new \PhpOffice\PhpWord\TemplateProcessor($template);

			$processor->setValues($values);
			// TEMP FIX FOR https://github.com/PHPOffice/PHPWord/issues/2083#issuecomment-1053444631
			//$processor->saveAs($filePath);
			$tempFile = $processor->save();
			if (file_exists($filePath)) unlink($filePath);
			rename($tempFile, $filePath);
			//unlink($tempFile);
			//			}
			chmod($filePath, 0777);

			header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
			header('Content-Disposition: attachment; filename="' . $fileName . '"');
			//header("Content-Transfer-Encoding: binary");
			readfile($filePath);
			die();
		}
		break;

	case 'info_inscriptionAdherentsFabLab':
		// Partie "GET"
		$lesUtilisateurs = $pdo->getUtilisateurCentreInfo();
		// Partie "POST"  
		if (isset($_POST) && !empty($_POST)) {
			// Si on a ajouté un utilisateur
			if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telMobile'], $_POST['dateNaissance'], $_POST['lieuNaissance'], $_POST['adresse'], $_POST['codePostal'], $_POST['ville'], $_POST['sexe'], $_POST['dateInscription'])) {
				// Vérifier si le fichier a été correctement uploadé
				if (isset($_FILES['PHOTO']) && $_FILES['PHOTO']['error'] === UPLOAD_ERR_OK) {
					// Récupérer les informations sur le fichier uploadé
					$photo_tmp = $_FILES['PHOTO']['tmp_name'];
					$photo = $_FILES['PHOTO']['name'];
					// Déplacer le fichier uploadé vers l'emplacement souhaité sur le serveur
					$chemin_destination = "images/adherentsFablab/" . $photo;
					move_uploaded_file($photo_tmp, $chemin_destination);
				} else {
					// Gérer les erreurs d'upload
					echo "Erreur lors de l'upload du fichier.";
				}
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
				$dateInscription = $_POST['dateInscription'];
				$telFixe = $_POST['telFixe'];
				if ($telFixe == "") $telFixe = null;
				$photo = $_POST['photo'];
				if ($photo == "") $photo = null;
				//$photo_nom
				$pdo->ajouterUtilisateurCentreInfo($nom, $prenom, $email, $telFixe, $telMobile, $adresse, $codePostal, $ville, $dateNaissance, $lieuNaissance, $sexe, $photo);
				$idUtilisateur = $pdo->getIdUtilisateurCentreInfo($email);
				$pdo->ajouterInscripCentreInfo($idUtilisateur, $dateInscription);
				$idInscription = $pdo->getIdInscription($idUtilisateur);
			}
		}
		// Entete de la page
		include("vues/v_entete.php");
		// Contenu de la page
		include("vues/administrateur/centreinfo/v_inscriptionAdherentsFabLab.php");
		break;

	default: {
			echo 'erreur d\'aiguillage !' . $action;
			break;
		}

		// Permet d'associer un règlement à un participant d'une activité'
	case 'info_ajouterUnReglement':
		// Entete de la page
		include("vues/v_entete.php");

		// On récupère les types de réglement
		$lesTypesReglements = $pdo->getParametre(5);

		// On récupère l'année en cours
		$anneeEnCours = $pdo->getAnneeEnCours();

		// On récupère les banques
		$lesBanques = $pdo->getLesBanques();

		// Numéro de l'inscription
		$uneActivite = $_REQUEST['uneActivite'];

		// On récupère la liste des activités
		$lesActivites = $pdo->info_getActivites($anneeEnCours);

		// On récupère les données de l'activité donnée
		$activiteSelectionner = $pdo->info_getActivite($uneActivite);

		// On récupère la liste des inscriptions à cette activité
		$lesInscriptions = $pdo->info_getInscriptionsPourUneActivite($uneActivite, $anneeEnCours);

		// Si une inscription est indiquée
		if (isset($_REQUEST['uneInscription'])) {

			// Numéro de l'inscription
			$uneInscription = $_REQUEST['uneInscription'];

			// On récupère les données de l'inscription donnée
			$inscriptionSelectionner = $pdo->info_getUneInscription($uneInscription);
		}

		// Page d'ajout de reglement
		include("vues/administrateur/centreinfo/v_ajouterUnReglement.php");

		// Arrêt de la boucle
		break;


	case 'LesPresencesCentreInfo':
		// La partie "GET"
		$dateCircuit = date('Y-m-d');
		$lesActivites = $pdo->getActivites();
		include("vues/v_entete.php");

		// La partie "POST"
		if (isset($_POST['laDate']) and isset($_POST['uneActivite'])) {
			$activiteSelectionner =  $_POST['uneActivite'];
			$dateCircuit = $_POST['laDate'];
			// Get les presences du jour pour l'.es activitee.s sélectionnee.s
			$tableauUtilisateur = $pdo->getPresencesActivite($_POST['laDate'], $_POST['uneActivite']);
		}


		include("vues/administrateur/centreinfo/v_LesPresencesCentreInfo.php");
		break;


	case 'info_rechercheInscriptions':
		// On récupère la liste des inscriptions
		$lesUtilisateurs = $pdo->getUtilisateurCentreInfo();
		$idUtilisateurSelectionne = $_REQUEST['unUtilisateur'];
		if (isset($idUtilisateurSelectionne))  //Si un utilisateur est selectionné on affiche ses informations
		{
			$inscriptionSelectionnerDate = $pdo->getDateInscription($idUtilisateurSelectionne);
			$inscriptionSelectionner = $pdo->getInfosUserByID($idUtilisateurSelectionne);
		}
		// Entete de la page de l'inscription donnée
		include("vues/v_entete.php");
		// Page de recherche + modification et suppression des inscriptions
		include("vues/administrateur/centreinfo/v_rechercheInscriptionsFabLab.php");
		break;

	case 'info_ModifierInscripFabLab':
		// Entete de la page de l'inscription donnée
		include("vues/v_entete.php");
		// Si une inscription est envoyée
		$idUtilisateurSelectionne = $_REQUEST['unUtilisateur'];
		$inscriptionSelectionner = $pdo->getInfosUserByID($idUtilisateurSelectionne);
		if (isset($_POST['ModifierInscrip'])) {
			// On modifie l'inscription au fablab
			if (isset($_FILES['PHOTO']) and $_FILES['PHOTO']['name'] != null) {
				// Récupérer les informations sur le fichier uploadé
				$photo_tmp = $_FILES['PHOTO']['tmp_name'];
				$photo_nom = $_FILES['PHOTO']['name'];
				// Déplacer le fichier uploadé vers l'emplacement souhaité sur le serveur
				$chemin_destination = "images/adherentsFablab/" . $photo_nom;
				move_uploaded_file($photo_tmp, $chemin_destination);
				// Supprimer l'ancienne photo
				$anciennePhoto = $pdo->getPhotoAdherent($idUtilisateurSelectionne);
				if ($anciennePhoto != null) {
					unlink("images/adherentsFablab/" . $anciennePhoto);
				}
			} else {
				$photo_nom = $pdo->getPhotoAdherent($idUtilisateurSelectionne);
			}
			$telFixe = $_POST['telFixe'];
			if ($telFixe == "") $telFixe = null;
			$pdo->info_modifierInscripFabLab(
				$idUtilisateurSelectionne,
				htmlentities(addslashes($_POST['NOM']), ENT_QUOTES),
				htmlentities(addslashes($_POST['prenom']), ENT_QUOTES),
				addslashes($_POST['email']),
				//$_POST['telFixe'],
				$telFixe,
				$_POST['telMobile'],
				htmlentities(addslashes($_POST['adresse']), ENT_QUOTES),
				$_POST['codePostal'],
				htmlentities(addslashes($_POST['ville']), ENT_QUOTES),
				$_POST['dateNaissance'],
				$_POST['lieuNaissance'],
				$_POST['sexe'],
				$photo_nom
			);
		}
		// On redirige l'utilisateur vers la fiche d'inscription
		redirect('index.php?choixTraitement=administrateur&action=info_rechercheInscriptions&unUtilisateur=' . $idUtilisateurSelectionne, "1");
		// Page de recherche + modification et suppression des inscriptions
		include("vues/administrateur/centreinfo/v_rechercheInscriptionsFabLab.php");
		break;


		// Supprimer une inscription
	case 'info_supprimerInscriptionFabLab':
		//include("vues/v_entete.php");
		$idUtilisateurSelectionne = $_REQUEST['unUtilisateur'];
		// Si une inscription est envoyée
		if (isset($_REQUEST['unUtilisateur'])) {
			$idUtilisateur = $pdo->getIdUtilisateurCentreInfo($idUtilisateurSelectionne);
			$idInscription = $pdo->getIdInscription($idUtilisateurSelectionne);
			$pdo->supprimerInfoInscription($idUtilisateurSelectionne);
			$pdo->supprimerInfoUtilisateur($idUtilisateurSelectionne);
		}
		// On redirige l'utilisateur vers les inscriptions
		redirect('index.php?choixTraitement=administrateur&action=info_inscriptionAdherentsFabLab');
		break;

	case 'validePaiementFabLab':
		// Entete de la page
		include("vues/v_entete.php");
		// Affichage du formulaire
		include("vues/administrateur/centreinfo/v_inscriptionAdherentsFabLab.php");
		break;

	case 'info_gererDesActivitesConso':
		// Entete de la page
		include("vues/v_entete.php");

		// La partie "POST"
		// Ajouter une activité
		if (isset($_POST['AjouterActivite'])) {
			// Vérifier si le fichier a été correctement uploadé
			if (isset($_FILES['PHOTO']) && $_FILES['PHOTO']['error'] === UPLOAD_ERR_OK) {
				// Récupérer les informations sur le fichier uploadé
				$photo_tmp = $_FILES['PHOTO']['tmp_name'];
				$photo_nom = $_FILES['PHOTO']['name'];

				// Déplacer le fichier uploadé vers l'emplacement souhaité sur le serveur
				$chemin_destination = "images/activites/" . $photo_nom;
				move_uploaded_file($photo_tmp, $chemin_destination);
			} else {
				// Gérer les erreurs d'upload
				echo "Erreur lors de l'upload du fichier.";
			}

			$pdo->ajouterActivite($_POST['NOM'], $_POST['PRIX'], $photo_nom, $_POST['DESCRIPTION'], $_POST['ADHERENT']);
		}
		// Ajouter un consommable
		if (isset($_POST['AjouterConsommable'])) {
			// Vérifier si le fichier a été correctement uploadé
			if (isset($_FILES['PHOTO']) && $_FILES['PHOTO']['error'] === UPLOAD_ERR_OK) {
				// Récupérer les informations sur le fichier uploadé
				$photo_tmp = $_FILES['PHOTO']['tmp_name'];
				$photo_nom = $_FILES['PHOTO']['name'];

				// Déplacer le fichier uploadé vers l'emplacement souhaité sur le serveur
				$chemin_destination = "images/consommables/" . $photo_nom;
				move_uploaded_file($photo_tmp, $chemin_destination);

				// Vous pouvez ensuite enregistrer le chemin de l'image dans votre base de données
				// ...
			} else {
				// Gérer les erreurs d'upload
				echo "Erreur lors de l'upload du fichier.";
			}

			$pdo->ajouterConsommable($_POST['NOM'], $_POST['PRIX'], $photo_nom, $_POST['DESCRIPTION']);
		}

		// La partie "GET"
		$lesActivites = $pdo->getActivites();
		$lesConsommables = $pdo->getConsommables();


		// Page de nouvelle inscription
		include("vues/administrateur/centreinfo/v_gererDesActivitesConso.php");

		// Arrêt de la boucle
		break;

	case 'info_modifActivite':
		// Entete de la page
		include("vues/v_entete.php");
		$ID = $_REQUEST['ID'];

		// La partie "POST"
		if (isset($_POST['ModifierActivite'])) {
			if (isset($_FILES['PHOTO']) and $_FILES['PHOTO']['name'] != null) {
				// Récupérer les informations sur le fichier uploadé
				$photo_tmp = $_FILES['PHOTO']['tmp_name'];
				$photo = $_FILES['PHOTO']['name'];

				// Déplacer le fichier uploadé vers l'emplacement souhaité sur le serveur
				$chemin_destination = "images/activites/" . $photo;
				move_uploaded_file($photo_tmp, $chemin_destination);

				// Supprimer l'ancienne photo
				$anciennePhoto = $pdo->getPhotoActivite($ID);
				if ($anciennePhoto != null) {
					unlink("images/activites/" . $anciennePhoto);
				}
			} else {
				$photo = $pdo->getPhotoActivite($ID);
			}
			$pdo->modifierActivite($ID, $_POST['NOM'], $_POST['PRIX'], $photo, $_POST['DESCRIPTION'], $_POST['ADHERENT'], $_POST['DESACTIVER']);
			// On redirige l'utilisateur vers les activites
			redirect('index.php?choixTraitement=administrateur&action=info_gererDesActivitesConso');
		}

		// La partie "GET"
		$activiteSelectionner = $pdo->getActivite($ID);

		// Page de modification d'activité
		include("vues/administrateur/centreinfo/v_modifActivite.php");
		break;



	case 'info_modifConsommable':
		// Entete de la page
		include("vues/v_entete.php");
		$ID = $_REQUEST['ID'];

		// La partie "POST"
		if (isset($_POST['ModifierConsommable'])) {
			if (isset($_FILES['PHOTO']) and $_FILES['PHOTO']['name'] != null) {
				// Récupérer les informations sur le fichier uploadé
				$photo_tmp = $_FILES['PHOTO']['tmp_name'];
				$photo = $_FILES['PHOTO']['name'];

				// Déplacer le fichier uploadé vers l'emplacement souhaité sur le serveur
				$chemin_destination = "images/consommables/" . $photo;
				move_uploaded_file($photo_tmp, $chemin_destination);

				// Supprimer l'ancienne photo
				$anciennePhoto = $pdo->getPhotoConsommable($ID);
				if ($anciennePhoto != null) {
					unlink("images/consommables/" . $anciennePhoto);
				}
			} else {
				$photo = $pdo->getPhotoConsommable($ID);
			}
			$pdo->modifierConsommable($ID, $_POST['NOM'], $_POST['PRIX'], $photo, $_POST['DESCRIPTION'], $_POST['DESACTIVER']);

			// On redirige l'utilisateur vers les activites
			redirect('index.php?choixTraitement=administrateur&action=info_gererDesActivitesConso');
		}

		// La partie "GET"
		$consommableSelectionner = $pdo->getConsommable($ID);

		// Page de modification de consommable
		include("vues/administrateur/centreinfo/v_modifConsommable.php");
		break;

	case 'reglementCentreInfo': {
		// Entete de la page
		include("vues/v_entete.php");
		// Récupérer les données de la base de données

		// Utilisateurs du centre info avec inscriptions si elles existent
		$utilisateursCentreInfo = $pdo->getUtilisateurCentreInfo();

		$activitesCentreInfo = $pdo->getActivitesCentreInfo();

		$typesReglement = $pdo->getTypesReglement();

		$banques = $pdo->getBanques();
		// Page de gestion des reglements
		include("vues/administrateur/centreinfo/v_gererReglements.php");

		// Arrêt de la boucle
		break;
  }

	case 'gererReglements': {
		// Constantes
		$listeIdGrammes = [3, 4];

		// Traitement des données du formulaire
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Récupérer les données du formulaire

			// Adhérence de l'utilisateur
			$adherence = $_POST['adherence'] ?? null;

			if (isset($adherence) && $adherence == "oui") {
				// Récupérer l'identifiant de l'utilisateur
				$idUser = $_POST['userCI_id2'] ?? null;
			} else if (isset($adherence) && $adherence == "non") {
				// Mail de l'utilisateur
				$emailUser = $_POST['emailUser'] ?? null;
				$idUser = $pdo->getIdUtilisateur($emailUser);
				$listeIdUtilisateurs = $pdo->getIdUtilisateursCentreInfo();

				// Vérifier si l'utilisateur existe déjà
				if (in_array($idUser, $listeIdUtilisateurs) || $idUser != null) {
					// Rediriger l'utilisateur vers la page de gestion des règlements avec un message d'erreur
					$_SESSION['erreur'] = 'L\'utilisateur exite déjà.';
					redirect('index.php?choixTraitement=administrateur&action=reglementCentreInfo');
				}

				// Récupérer les données de base
				$nomUser = $_POST['nomUser'] ?? null;
				$prenomUser = $_POST['prenomUser'] ?? null;
				$telFixe = null;
				$telUser = $_POST['telUser'] ?? null;
				$adresseUser = $_POST['adresseUser'] ?? null;
				$codePostalUser = $_POST['codePostalUser'] ?? null;
				$villeUser = $_POST['villeUser'] ?? null;
				$dateNaissanceUser = $_POST['dateNaissanceUser'] ?? null;
				$lieuNaissanceUser = $_POST['lieuNaissanceUser'] ?? null;
				$sexe = null;
				$photo = null;

				// Récupère le dernier identifiant utilisateur (ajouter 1 pour le nouvel utilisateur) sinon 0 si aucun utilisateur
				$idUser = $pdo->getDernierIdUtilisateurCentreInfo() + 1 ?? 0;

				// Ajouter l'utilisateur
				$pdo->ajouterUtilisateurCentreInfo($idUser, $nomUser, $prenomUser, $emailUser, $telFixe, $telUser, $adresseUser, $codePostalUser, $villeUser, $dateNaissanceUser, $lieuNaissanceUser, $sexe, $photo);
				// Récupérer l'identifiant de l'utilisateur créé
				$idUser = $pdo->getDernierIdUtilisateurCentreInfo();
				// Inscrire l'utilisateur
				$pdo->ajouterInscriptionCentreInfo($idUser);
			} else {
				// Gérer l'erreur si aucune des deux conditions n'est remplie
				$_SESSION['erreur'] = 'Ni un utilisateur existant ni un nouvel utilisateur n\'a été spécifié.';
				redirect('index.php?choixTraitement=administrateur&action=reglementCentreInfo');
			}

			// Récupérer les données du règlement
			$idTypeReglement = $_POST['typeReglement'] ?? null;
			$typeReglement = $pdo->getTypeReglementById($idTypeReglement);

			$whiteList = array('Chèque', 'CB');
			if (in_array($typeReglement, $whiteList)) {
				// Récupérer les données du règlement
				$idBanque = $_POST['banque'] ?? null;
				$banque = $pdo->getNomBanqueById($idBanque);
				$numTransaction = $_POST['numTransaction'] ?? null;
			} else {
				$banque = null;
				$numTransaction = null;
			}

			$dateReglement = $_POST['dateReglement'] ?? null;
			$commentaire = $_POST['commentaire'] ?? null;

			// Règlement Adhésion
			$reglementAdhesion = isset($_POST['adhesion']) ? true : false;

			if ($reglementAdhesion) {
				// Pas d'activité pour l'adhésion
				$idActivite = null;
				$consommablesActivite = null;
			} else {
				// Récupérer l'identifiant de l'activité
				$idActivite = intval($_POST['activite']) ?? null;
				$activiteSelectionne = $pdo->getActiviteById($idActivite);
				$nomActivite = $activiteSelectionne['NOM'] ?? null;
				$descriptionActivite = $activiteSelectionne['DESCRIPTION'] ?? null;

				// Si l'id correspond à toutes les activités
				if ($idActivite == 0) {
					// Récupérer toutes les activités sauf celle-ci (tableau)
					$activites = $pdo->getActivitesExceptAll();

					// Liste des activités
					$listeActivites = [];

					// Pour chaque activité
					foreach ($activites as $activite) {
						// Récupérer les consommables de l'activité
						$listeConsommablesActivite = $pdo->getConsommablesActivite($activite['ID_ACTIVITE']);

						$idActiviteListe = $activite['ID_ACTIVITE'] ?? null;
						$nomActiviteListe = $activite['NOM'] ?? null;
						$descriptionActiviteListe = $activite['DESCRIPTION'] ?? null;

						// Liste des consommables
						$listeConsommables = [];

						// Pour chaque consommable
						foreach ($listeConsommablesActivite as $consommable) {
							// Récupérer les données du consommable
							$idConsommable = $consommable['ID_CONSOMMABLE'] ?? null;
							$nomConsommable = $consommable['NOM'] ?? null;
							$descriptionConsommable = $consommable['DESCRIPTION'] ?? null;
							$photoConsommable = $consommable['PHOTO'] ?? null;
							$prixUnitaire = $consommable['PRIX'] ?? null;


							if (isset($_POST['quantite_' . $idConsommable])) {
								// Récupérer la quantité
								$quantite = intval($_POST['quantite_' . $idConsommable]) ?? null;

								// Calcul du montant
								if (in_array($idConsommable, $listeIdGrammes)) {
									$montant = ($prixUnitaire * $quantite) / 1000;
								} else {
									$montant = $prixUnitaire * $quantite;
								}

								// Si la quantité est spécifiée
								if ($quantite != null) {
									// Création de l'association consommable-quantité-prix
									$associationCQP = [
										'id' => $idConsommable,
										'nom' => $nomConsommable,
										'description' => $descriptionConsommable,
										'photo' => $photoConsommable,
										'prixUnitaire' => $prixUnitaire,
										'quantite' => $quantite,
										'montant' => $montant
									];
									// Ajout de l'association à la liste des consommables
									array_push($listeConsommables, $associationCQP);
								}
							}
						}

						// Création de l'objet
						$associationAC = [
							'idActivite' => $idActiviteListe,
							'nomActivite' => $nomActiviteListe,
							'descriptionActivite' => $descriptionActiviteListe,
							'consommables' => $listeConsommables
						];

						// Ajout de l'objet à la liste des activités
						array_push($listeActivites, $associationAC);
					}

					// Création de l'objet
					$objet = [
						'idActivite' => $idActivite,
						'nomActivite' => $nomActivite,
						'descriptionActivite' => $descriptionActivite,
						'activites' => $listeActivites
					];

					// Conversion de l'objet en json
					$consommablesActivite = json_encode($objet);

					// Si l'id ne correspond pas à toutes les activités
				} else {

					// Récupère la photo de l'activité
					$photoActivite = $activiteSelectionne['PHOTO'] ?? null;

					// Récupérer les consommables
					$nombreConsommables = $pdo->compteConsommables();
					$listeConsommables = [];

					for ($i = 1; $i < $nombreConsommables + 1; $i++) {

						if (isset($_POST['consommable_' . $i])) {
							// Récupérer les données du consommable
							$idConsommable = intval($_POST['consommable_' . $i]) ?? null;
							$consommable = $pdo->getConsommableById($idConsommable);

							$nomConsommable = $consommable['NOM'] ?? null;
							$descriptionConsommable = $consommable['DESCRIPTION'] ?? null;
							$photoConsommable = $consommable['PHOTO'] ?? null;
							$quantite = intval($_POST['quantite_' . $i]) ?? null;
							$prixUnitaire = $consommable['PRIX'] ?? null;

							// Si le consommable existe et que la quantité est spécifiée
							if ($consommable != null && $quantite != null) {

								// Calcul du montant
								if (in_array($idConsommable, $listeIdGrammes)) {
									$montant = ($prixUnitaire * $quantite) / 1000;
								} else {
									$montant = $prixUnitaire * $quantite;
								}

								// Création de l'association consommable-quantité-prix
								$associationCQP = [
									'id' => $idConsommable,
									'nom' => $nomConsommable,
									'description' => $descriptionConsommable,
									'photo' => $photoConsommable,
									'prixUnitaire' => $prixUnitaire,
									'quantite' => $quantite,
									'montant' => $montant
								];
								// Ajout de l'association à la liste des consommables
								array_push($listeConsommables, $associationCQP);
							}
						}
					}


					// Création de l'objet
					$objet = [
						'idActivite' => $idActivite,
						'nomActivite' => $nomActivite,
						'descriptionActivite' => $descriptionActivite,
						'photoActivite' => $photoActivite,
						'consommables' => $listeConsommables
					];

					// Conversion de l'objet en json
					$consommablesActivite = json_encode($objet);
				}
			}

			// Récupération du montant
			$montant = $_POST['prixTotal'] ?? null;

			// Récupère le dernier identifiant règlement (ajouter 1 pour le nouveau règlement) sinon 0 si aucun règlement
			$idReglement = $pdo->getDernierIdentifiantReglement() + 1 ?? 0;

			// Ajouter le règlement
			$pdo->ajouterReglementCentreInfo($idReglement, $typeReglement, $montant, $banque, $numTransaction, $dateReglement, $commentaire);

			// Récupérer l'identifiant du règlement
			$idReglement = $pdo->getDernierIdentifiantReglement();

			// Lier le règlement à l'utilisateur
			$pdo->reglementUtilisateurCentreInfo($idReglement, $idUser);

			// Lier le consommable à l'utilisateur
			$pdo->utilisateurConsommable($idUser, $consommablesActivite);

			// Rediriger l'utilisateur vers la page de gestion des règlements
			$_SESSION['succes'] = 'Le règlement a été ajouté avec succès.';
			redirect('index.php?choixTraitement=administrateur&action=reglementCentreInfo');
		}

		break;
  }

	case 'getReglements': {
		// Récupérer l'identifiant de l'utilisateur
		$userId = $_GET['userId'];
		$reglements = $pdo->getReglementsByUserId($userId);
		$utilisateur = $pdo->getUtilisateurCentreInfoById($userId);
		$nomUser = $utilisateur['NOM'] ?? null;
		$prenomUser = $utilisateur['PRENOM'] ?? null;
		$listeReglements = [];

		foreach ($reglements as $reglement) {

			$idReglement = $reglement['ID'] ?? null;
			$typeReglement = $reglement['TYPE_REGLEMENT'] ?? null;
			$montant = $reglement['MONTANT'] ?? null;
			$banque = $reglement['BANQUE'] ?? null;
			$numTransaction = $reglement['NUM_TRANSACTION'] ?? null;
			$dateReglement = $reglement['DATE'] ?? null;
			$commentaire = $reglement['COMMENTAIRE'] ?? null;

			$reglement = [
				'id' => $idReglement,
				'type' => $typeReglement,
				'montant' => $montant,
				'banque' => $banque,
				'numTransaction' => $numTransaction,
				'date' => $dateReglement,
				'commentaire' => $commentaire,
				'nom' => $nomUser,
				'prenom' => $prenomUser
			];

			array_push($listeReglements, $reglement);
		}

		$objet = [
			'id' => $userId,
			'nom' => $nomUser,
			'prenom' => $prenomUser,
			'reglements' => $listeReglements
		];

		// Debug: voir le contenu avant l'encodage JSON
		// var_dump($listeReglements);

		// Suppression des espaces ou nouvelles lignes avant et après
		ob_clean(); // Nettoie le buffer de sortie pour éviter les caractères inattendus
		header('Content-Type: application/json');
		echo json_encode($objet, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
		exit; // Assurez-vous que le script s'arrête ici
  }

	case 'editReglement': {
		// Récupérer les données du formulaire
		$idReglement = intval($_POST['idReglementP']);
		$idTypeReglement = intval($_POST['typeReglementP']);
		$dateReglement = $_POST['dateReglementP'];
		$montant = floatval($_POST['montantP']);
		$commentaire = $_POST['commentaireP'] ?? null;


		$typeReglement = $pdo->getTypeReglementById($idTypeReglement);

		$whiteList = array('Chèque', 'CB');
		if (in_array($typeReglement, $whiteList)) {
			// Récupérer les données du règlement
			$idBanque = intval($_POST['banqueP']);
			$banque = $pdo->getNomBanqueById($idBanque);
			$numTransaction = $_POST['numTransactionP'];
		} else {
			$banque = null;
			$numTransaction = null;
		}

		// Modifier le règlement
		$pdo->modifierReglement($idReglement, $typeReglement, $montant, $banque, $numTransaction, $dateReglement, $commentaire);

		// Rediriger l'utilisateur vers la page de gestion des règlements
		$_SESSION['succes'] = 'Le règlement a été modifié avec succès.';
		redirect('index.php?choixTraitement=administrateur&action=reglementCentreInfo');
		break;
  }

	case 'deleteReglement': {

		// Récupérer l'identifiant du règlement
		$idReglement = intval($_POST['idReglementD']);

		// Supprimer le règlement
		$pdo->supprimerReglement($idReglement);

		// Afficher un message de succès
		$_SESSION['succes'] = 'Le règlement a été supprimé avec succès.';

		// Rediriger l'utilisateur vers la page de gestion des règlements
		redirect('index.php?choixTraitement=administrateur&action=reglementCentreInfo');
		break;
  }

	case 'deleteAllReglements': {

		// Récupérer l'identifiant de l'utilisateur
		$idUser = intval($_POST['idUserD']);

		// Supprimer tous les règlements de l'utilisateur
		$pdo->supprimerTousReglements($idUser);

		// Afficher un message de succès
		$_SESSION['succes'] = 'Tous les règlements de l\'utilisateur ont été supprimés avec succès.';

		// Rediriger l'utilisateur vers la page de gestion des règlements
		redirect('index.php?choixTraitement=administrateur&action=reglementCentreInfo');
    break;
  }

	case 'setNotesStageRevision':
		// Entete de la page
		include("vues/v_entete.php");
	
		// Vérifiez si 'unStage' et 'notes' sont définis dans $_POST
		if (isset($_GET['unStage']) && isset($_POST['notes'])) {
			// Récupère le numéro de stage
			$num = $_GET['unStage'];
			// Récupère les notes
			$notes = $_POST['notes'];
			$notes=htmlentities(addslashes($notes), ENT_QUOTES); 
			// Met à jour les notes
			$pdo->setNotesStageRevision($num, $notes);
			// Redirige vers la page de gestion des stages
			redirect('index.php?choixTraitement=administrateur&action=LesStages&unStage='.$num);
		} else {
			// Gérer l'erreur si 'unStage' ou 'notes' n'est pas défini
			echo "Erreur: unStage ou notes non défini.";
		}

		break;
}
