<?php

// ----------------------------- FONCTIONS -------------------------------

// Fonction de redirection
function redirect($url, $time=3) {
  echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="'.$url.'";</SCRIPT>';
}

// Retourne les coordonnées GPS d'une adresse donnée
function getGps($adresse,$cp,$ville) {
  $lat = 0;
  $lon = 0;

  $address = addslashes($adresse) . ' ' . addslashes($cp) . ' ' . addslashes($ville) . ', France';

  $request_url = "https://maps.googleapis.com/maps/api/geocode/xml?key=AIzaSyA_C2zsDEHSud_LkZbu4KuoTwyx6hIpDQU&address=".$address."&sensor=true";

  $xml = simplexml_load_file($request_url) or die("url not loading");

  $status = $xml->status;

  if ($status=="OK") {
    $lat = $xml->result->geometry->location->lat;
    $lon = $xml->result->geometry->location->lng;
  }

  // Retourne les coordonnées dans un tableau
  return array('lat' => $lat, 'lon' => $lon);
}

// Génére un formulaire de date (jour mois année)
function formulaireDate($jourEnCours,$moisEnCours,$anneeEnCours, $idformulaire) {
  // Si aucun jour n'est fourni, on affiche le jour actuel
  if($jourEnCours == 0) { $jourEnCours = date('j',time()); }

  // Si aucun mois n'est fourni, on affiche le mois actuel
  if($moisEnCours == 0) { $moisEnCours = date('n',time()); }

  // Si aucun année n'est fourni, on affiche le année actuel
  if($anneeEnCours == 0) { $anneeEnCours = date('Y',time()); }

  echo '<input type="date" class="form-control" id="'.$idformulaire.'" name="'.$idformulaire.'" value="'.$anneeEnCours.'-'.$moisEnCours.'-'.$jourEnCours.'">';
}

$intervenant=$_SESSION['intervenant'];

// ----------------------------- METHODES -------------------------------

$action = $_REQUEST['action'];
switch($action) {
  case 'index':
  {
    $lesDocs = $pdo->getdocseleves();

    $eleve = $intervenant["ID_ELEVE"];

    $lesnotifs = $pdo->getfilnotifCible("Eleve");

    $tableau=$pdo->recup7PresenceEleve('ELEVE', $eleve);

    include("vues/eleve/v_entete_eleve.php");

    include("vues/eleve/v_accueil_eleve.php");

    break;
  }
  case 'macarte':
  {
    $ideleve = $intervenant["ID_ELEVE"];
    $identEleve = $pdo->getidentifianteleves($ideleve);

    include("vues/eleve/v_entete_eleve.php");

    include("vues/eleve/v_macarte_eleve.php");

    break;
  }
  case 'infospersos':
  {
    $ideleve = $intervenant["ID_ELEVE"];
    $infospersosEleve = $pdo->getinfospersoseleves($ideleve);

    include("vues/eleve/v_entete_eleve.php");

    include("vues/eleve/v_infosperso_eleves.php");

    break;
  }
  case 'presence':
  {
    $eleves = $intervenant["ID_ELEVE"];

    $tableau=$pdo->recupPresenceEleveSansDate($eleves);
    $nb=$pdo->CountrecupPresenceEleveSansDate($eleves);

    include("vues/eleve/v_entete_eleve.php");

    include("vues/eleve/v_presence_eleve.php");

    break;
  }
  case 'rdv':
  {
    $eleves = $intervenant["ID_ELEVE"];
    $anneeEnCours = $pdo->getAnneeEnCours();

    $lesRendezvous = $pdo->recupRdvParents($anneeEnCours);
    $lesRendezvousBsb = $pdo->recupRdvBsb($anneeEnCours);

    include("vues/eleve/v_entete_eleve.php");

    include("vues/eleve/v_rdv_eleve.php");

    break;
  }
  case 'reglements':
  {
    $num = $intervenant["ID_ELEVE"];
    $lesReglementsEleve = $pdo->recupReglementsUnEleve($num);

    include("vues/eleve/v_entete_eleve.php");

    include("vues/eleve/v_reglements_eleve.php");

    break;
  }
  case 'stagehisto':
  {
    $num = $intervenant["ID_ELEVE"];
    $lesStages = $pdo->getStages();

    include("vues/eleve/v_entete_eleve.php");

    include("vues/eleve/v_stage_histo_eleve.php");

    break;
  }
  case 'activitehisto':
  {
    $num = $intervenant["ID_ELEVE"];
    $lesEvenements =$pdo->recupEvenement();
    $lesEvenementsEleve =$pdo->recupEvenementEleve($num);

    include("vues/eleve/v_entete_eleve.php");

    include("vues/eleve/v_activite_histo_eleve.php");

    break;
  }
  case 'plateformes':
    {
      $lesPlateformes = $pdo->recupPlateformeeleves();
      if (isset($_SESSION['intervenant'])) {
        $intervenant=$_SESSION['intervenant'];
        $numIntervenant=$intervenant['ID_INTERVENANT'];
        $admin=$intervenant['ADMINISTRATEUR'];
      }

      if ((isset($numIntervenant))&&($admin>=0)) {
        include("vues/v_entete.php");
      }
      else {
        include("vues/eleve/v_entete_eleve.php");
      }
      include("vues/eleve/v_plateforme_eleve.php");
      break;
    }
    case 'ajoutplateformes':
      {
        $nom = $_POST["Nom"];
        $url = $_POST["Url"];
        $login = $_POST["Login"];
        $mdp = $_POST["Mdp"];
        $commentaires = $_POST["Commentaires"];

        if (isset($_POST["soumettre"])) {
          if($_FILES['Logo']['name'] != '') {

            $logo = basename($_FILES['Logo']['name']);
            move_uploaded_file($_FILES['Logo']['tmp_name'], './images/imageplateforme/'.$logo);

            $ajouterPlateforme = $pdo->ajoutPlateformeeleves($nom, $logo, $url, $login,$mdp, $commentaires);
          }
        }

        include("vues/v_entete.php");
        if ($ajouterPlateforme = TRUE) {
          echo'
          <p>La plateforme à été ajouté avec succès</p> ';
          header('Location: vues/eleve/v_plateforme_eleve.php', 2);
        }
        break;
      }
      case 'modifplateformes':
        {
          $nom = $_POST["Nom"];
          $url = $_POST["Url"];
          $login = $_POST["Login"];
          $mdp = $_POST["Mdp"];
          $commentaires = $_POST["Commentaires"];
          $id = $_GET["id"];


          // si une image est envoyée

          if($_FILES['Logo']['name'] != '') {
            $logo= basename($_FILES['Logo']['name']);
            move_uploaded_file($_FILES['Logo']['tmp_name'], './images/imageplateforme/'.$logo);
            $pdo->executerRequete2('UPDATE plateformes SET `logo` = "'.$logo.'" WHERE id = '.$id.'');
          }

          if (isset($_POST["modifier"])) {
            try {

              $modifPlateforme = $pdo->modifPlateformeeleves($id, $nom, $url, $login,$mdp, $commentaires);
            }
            catch (\Exception $e) {
              echo "erreur lors de l'ajout de l'image".$e;
            }
          }

          include("vues/v_entete.php");

          //include("vues/eleve/v_plateforme_eleve.php");

          break;
        }
        case 'supprimerplateformeeleves':
          {
            $id = $_GET["id"];
            if(isset($_POST['supprimer']))
            {
              $supprimer = $pdo->supprimerplateformeeleves($id);
            }
            if($supprimer = TRUE)
            {
              include("vues/v_entete.php");
              echo '<p>La plateforme à été supprimer avec succès</p>';
            }
            //include("vues/eleve/v_plateforme_eleve.php");

            break;
          }
          case 'notifications':
            {
              $lesnotifs = $pdo->getfilnotif();
              $lesUtilisateurs = $pdo->getParametre(22);
              $intervenant = $_SESSION["intervenant"]["ID_INTERVENANT"];
              $intervenantPrenom = $_SESSION["intervenant"]["PRENOM"];
              $intervenantNom = $_SESSION["intervenant"]["NOM"];
              include("vues/v_entete.php");
              include("vues/eleve/v_notifications_eleve.php");
              break;
            }
              case 'ajouterNotification':
                {
                  $libelle = $_POST["Libelle"];
                  $date_publie = $_POST["Date_publie"];
                  $date_evenement = $_POST["Date_evenement"];
                  $cible = $_POST["Cible"];
                  $i=0;
                  $cibledb = "";
                  foreach ($cible as $unecible) {
                    $cibledb .= $cible[$i].'/';
                    $i++;
                  }
                  $auteur = $_POST["Auteur"];

                  if (isset($_POST["ajouter"])) {
                    $ajouterNotification = $pdo -> ajouterNotification($id, $libelle, $date_publie, $date_evenement, rtrim($cibledb,"/"), $auteur);

                  }
                  if ($ajouterNotification = true) {
                    include("vues/v_entete.php");
                    echo 'la ligne à été ajouté';
                  }
                  break;
                }
                case 'modifierNotification':
                  {
                    $notif = $_REQUEST["notif"];
                    $uneNotif = $pdo->getUneNotif($notif);
                    $lesUtilisateurs = $pdo->getParametre(22);
                    include("vues/v_entete.php");
                    include("vues/eleve/v_modifiernotification_eleve.php");
                    break;
                  }
                  case 'valideModifierNotification':
                    {
                      $notif = $_GET['id'];
                      $libelle = $_POST['Libelle'];
                      $date_evenement = $_POST['date_evenement'];
                      $cible = $_POST ['Cible'];
                      $modifier = $pdo->modifierNotification($notif, $libelle, $date_evenement, $cible);
                      include("vues/v_entete.php");
                      break;
                    }
                case 'supprimerNotification':
                  {
                    $notif = $_REQUEST["notif"];

                    $supprimerUneNotif = $pdo->supprimerNotification($notif);
                    header('Location: index.php?choixTraitement=eleve&action=notifications');
                    break;
                  }
                  case 'inscriptionstages':
                  {
                    $lesStage = $pdo->recupStageActifs();

                    include("vues/eleve/v_entete_eleve.php");

                    include("vues/eleve/v_inscriptions_stage_eleve.php");

                    break;
                  }
                  case 'Polycopies' :{
                    $lesDocs = $pdo->getdocseleves();
                    $lesCategoriesDocs = $pdo->getcategoriesdocseleves();
                    $lesClasses = $pdo->getParametre(4);
                    $lesTypes = array(
                      array("Type" => "Cours" ),
                      array("Type" => "Exercices" ),
                      array("Type" => "Autres"),
                    );

                    if (isset($_SESSION['intervenant'])) {
                      $intervenant=$_SESSION['intervenant'];
                      $numIntervenant=$intervenant['ID_INTERVENANT'];
                      $admin=$intervenant['ADMINISTRATEUR'];
                    }

                    if ((isset($numIntervenant))&&($admin>=0)) {
                      include("vues/v_entete.php");
                    }
                    else {
                      include("vues/eleve/v_entete_eleve.php");
                    }

                    include("vues/eleve/v_polycopies_eleve.php");
                    break;
                  }
                  case 'vueModifierPolycopies' :{
                    $polycopie = $_GET["polycopie"];
                    $unePolycopie = $pdo->executerRequete2('SELECT * FROM docseleves WHERE id = '.$polycopie.'');
                    $lesCategoriesDocs = $pdo->getcategoriesdocseleves();
                    $lesClasses = $pdo->getParametre(4);
                    $lesTypes = array(
                      array("Type" => "Cours" ),
                      array("Type" => "Exercices" ),
                      array("Type" => "Autres"),
                    );
                    $selectionner="selected='selected'";
                    include("vues/v_entete.php");
                    include("vues/eleve/v_modifierpolycopie_eleve.php");
                    break;
                  }
                  case 'modifierPocycopie' :{
                    $id = $_GET["id"];
                    $nom = $_POST["Nom"];
                    $commentaires = $_POST["Commentaires"];
                    $date = $_POST["Date"];
                    $classe = $_POST["Classe"];
                    $type = $_POST["Type"];
                    $categorie = $_POST["Categorie"];
                    if (isset($_POST["Valide"])) {
                      $valide = $_POST["Valide"];
                    }
                    else {
                      $valide = 0;
                    }

                    // si une image est envoyée
                    if($_FILES['Fichier']['name'] != '' && $_FILES['Photo']['name'] != '' && $_FILES['Corrige']['name'] != '') {
                      $fichier= basename($_FILES['Fichier']['name']);
                      $photo= basename($_FILES['Photo']['name']);
                      $corrige= basename($_FILES['Corrige']['name']);
                      move_uploaded_file($_FILES['Fichier']['tmp_name'], './documentseleve/'.$fichier);
                      move_uploaded_file($_FILES['Corrige']['tmp_name'], './documentseleve/'.$corrige);
                      move_uploaded_file($_FILES['Photo']['tmp_name'], './images/imageplateforme/'.$photo);
                      $pdo->executerRequete2('UPDATE docsEleves SET `urlfichier` = "'.$fichier.'" WHERE id = '.$id.'');
                      $pdo->executerRequete2('UPDATE docsEleves SET `urlphoto` = "'.$photo.'" WHERE id = '.$id.'');
                      $pdo->executerRequete2('UPDATE docsEleves SET `urlfichier` = "'.$corrige.'" WHERE id = '.$id.'');
                    }

                    if(isset($_POST["modifier"]))
                    {
                      $modifPolycopie = $pdo->modifierdocseleves($id, $nom, $commentaires, $date, $classe, $type, $categorie, $valide);
                    }
                    include("vues/v_entete.php");
                    //include("vues/eleve/v_polycopies_eleve.php");
                    break;
                  }
                  case 'ajoutPolycopies' :{
                    $nom = $_POST["Nom"];
                    $commentaires = $_POST["Commentaires"];
                    $date = $_POST["Date"];
                    $classe = $_POST["Classe"];
                    $type = $_POST["Type"];
                    $categorie = $_POST["Categorie"];

                    if (isset($_POST["soumettre"])) {
                        if($_FILES['Photo']['name'] != '' && $_FILES['Fichier']['name'] != '' && $_FILES['Corrige']['name'] != '') {

                          $photo= basename($_FILES['Photo']['name']);
                          $fichier= basename($_FILES['Fichier']['name']);
                          $corrige= basename($_FILES['Corrige']['name']);
                          move_uploaded_file($_FILES['Photo']['tmp_name'], './images/imagespolycopies/'.$photo);
                          move_uploaded_file($_FILES['Fichier']['tmp_name'], './documentseleve/'.$fichier);
                          move_uploaded_file($_FILES['Corrige']['tmp_name'], './documentseleve/'.$corrige);
                          $ajouterPlateforme = $pdo->ajoutdocseleves($nom, $commentaires, $fichier, $corrige, $date, $classe, $photo, $type, $categorie, 0);
                        }
                        else {
                          $ajouterPlateforme = $pdo->ajoutdocseleves($nom, $commentaires, NULL, NULL, $date, $classe, NULL, $type, $categorie, 0);
                        }
                      }

                    include("vues/v_entete.php");
                    if ($ajouterPlateforme = TRUE) {
                      echo'
                      <p>Le polycopié à été ajouter avec succès</p> ';
                      header('Location: vues/eleve/v_polycopies_eleve.php', 2);
                    }
                    break;
                  }
                  case 'supprimerpolycopie' :{
                    $id = $_GET["polycopie"];
                    $supprimerPolycopie = $pdo->supprimerdocseleves($id);
                    include("vues/v_entete.php");
                    if ($supprimerPolycopie = TRUE) {
                      echo 'la ligne a été supprimer';
                    }
                    break;
                  }
                  case 'osticket' :{
                    include("vues/eleve/v_entete_eleve.php");

                    break;
                  }
                  case 'contact' :{
                    include("vues/eleve/v_entete_eleve.php");

                    include("vues/eleve/v_contacteleve.php");

                    break;
                  }
                }
                ?>
