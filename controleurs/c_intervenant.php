<?php
$lesnotifs = $pdo->getfilnotifCible("intervenant");
function redirect($url, $time=3) {
   //On vérifie si aucun en-tête n'a déjà été envoyé
   /*if (!headers_sent()) {
     header("refresh: $time;url=$url");
     exit;
   }
   else {
     //echo '<meta https-equiv="refresh" content="'.$time.';url='.$url.'">';
   }*/
   echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="'.$url.'";
</SCRIPT>
';
}

$action = $_REQUEST['action'];
switch($action) {
case 'index':
	{

		include("vues/v_entete.php");
    $lesnotifs = $pdo->getfilnotifCible("intervenant");
		$intervenant=$_SESSION['intervenant'];
    $tableau=$pdo->recup7PresenceEleve('INTERVENANT', $intervenant['ID_INTERVENANT']);
		include("vues/intervenant/v_index.php");
		break;
	}

  case 'macarte':
  {

    $intervenant=$_SESSION['intervenant'];
    //$identEleve = $pdo->getidentifianteleves($ideleve);

    include("vues/v_entete.php");

    include("vues/intervenant/v_macarte_intervenant.php");

    break;
  }

	case 'Planning':
	{
		include("vues/v_entete.php");

		$intervenant=$_SESSION['intervenant'];
		$numIntervenant=$intervenant['ID_INTERVENANT'];
		$planning=$pdo->getPlanning($numIntervenant);
		$lesVacances 	= $pdo->getParametre(9);
		include("vues/intervenant/v_Planning.php");
		break;
	}


	case 'supprimerDispo':
	{
		include("vues/v_entete.php");

		$intervenant=$_SESSION['intervenant'];
		$num=$intervenant['ID_INTERVENANT'];
		$date = addslashes($_REQUEST['date']);
		$m = $_REQUEST['m'];
		$a = $_REQUEST['a'];
		$pdo->supprimerDispo($num,$date);

		echo "<center><h3>Votre disponibilité a bien été supprimé.</h3></center>";
		//Utilisation
redirect('index.php?choixTraitement=intervenant&action=Planning&m='.$m.'&a='.$a,"1");
		break;

	}

case 'Polycopies':
  {
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


        include("vues/v_entete.php");

    include("vues/eleve/v_polycopies_eleve.php");


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
      try {
        if($_FILES['Photo']['name'] != '' && $_FILES['Fichier']['name'] != '') {

          $photo= basename($_FILES['Photo']['name']);
          $fichier= basename($_FILES['Fichier']['name']);
          move_uploaded_file($_FILES['Photo']['tmp_name'], './images/imagespolycopies/'.$photo);
          move_uploaded_file($_FILES['Fichier']['tmp_name'], './documentseleve/'.$fichier);
          $ajouterPlateforme = $pdo->ajoutdocseleves($nom, $commentaires, $fichier, $date, $classe, $photo, $type, $categorie);
        }
        else {
          $ajouterPlateforme = $pdo->ajoutdocseleves($nom, $commentaires, NULL, $date, $classe, NULL, $type, $categorie);
        }
      } catch (\Exception $e) {
        echo "erreur lors de l'ajout de l'image".$e;
      }

    }

    include("vues/v_entete.php");
    if ($ajouterPlateforme = TRUE) {
      echo'
      <p>La polycopiés à été ajouté avec succès</p> ';
      header('Location: vues/eleve/v_polycopies_eleve.php', 2);
    }
    break;
  }

  case 'vueModifierPolycopies' :{
    $polycopie = $_GET["polycopie"];
    $unePolycopie = $pdo->executerRequete2('SELECT * FROM docsEleves WHERE id = '.$polycopie.'');
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

    // si une image est envoyée

      if($_FILES['Fichier']['name'] != '' && $_FILES['Photo']['name'] != '') {
        $fichier= basename($_FILES['Fichier']['name']);
        $photo= basename($_FILES['Photo']['name']);
        move_uploaded_file($_FILES['Fichier']['tmp_name'], './images/imageplateforme/'.$fichier);
        move_uploaded_file($_FILES['Photo']['tmp_name'], './images/imageplateforme/'.$photo);
      $pdo->executerRequete2('UPDATE docsEleves SET `urlfichier` = "'.$fichier.'" WHERE id = '.$id.'');
      $pdo->executerRequete2('UPDATE docsEleves SET `urlphoto` = "'.$photo.'" WHERE id = '.$id.'');
    }

    if(isset($_POST["modifier"]))
    {
      $modifPolycopie = $pdo->modifierdocseleves($id, $nom, $commentaires, $date, $classe, $type, $categorie);
    }
    include("vues/v_entete.php");
    //include("vues/eleve/v_polycopies_eleve.php");
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

    case 'plateformes':
    {
      $lesPlateformes = $pdo->recupPlateformeeleves();
      if (isset($_SESSION['intervenant'])) {
        $intervenant=$_SESSION['intervenant'];
        $numIntervenant=$intervenant['ID_INTERVENANT'];
        $admin=$intervenant['ADMINISTRATEUR'];
      }

        include("vues/v_entete.php");

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

            $logo= basename($_FILES['Logo']['name']);
      			move_uploaded_file($_FILES['Logo']['tmp_name'], './images/imageplateforme/'.$logo);
            $ajouterPlateforme = $pdo->ajoutPlateformeeleves($nom, $logo, $url, $login,$mdp, $commentaires);
          }
          else {
            $ajouterPlateforme = $pdo->ajoutPlateformeeleves($nom, NULL, $url, $login,$mdp, $commentaires);
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

  case 'Notifications':
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

	case 'modifInfos':
	{
		include("vues/v_entete.php");

		$intervenant=$_SESSION['intervenant'];
		$numIntervenant=$intervenant['ID_INTERVENANT'];
		$inter=$pdo->recupUnIntervenant($numIntervenant);

    //include("./vues/inscriptionStage/intervenant/v_modifInfos.php");
    include("./vues/intervenant/v_modifInfos.php");
		break;
	}

case 'contact':
include("vues/v_entete.php");

include("vues/eleve/v_contacteleve.php");
  break;

	case 'valideModifInfos':
	{

		$num = $_REQUEST['unIntervenant'];
		$nom = $_REQUEST['nom'];
		$prenom = $_REQUEST['prenom'];
		$date_naissance = $_REQUEST['date_naissance'];
		$lieu_naissance = $_REQUEST['lieu_naissance'];
		$email = $_REQUEST['email'];
		$tel = $_REQUEST['tel'];
		$adresse = $_REQUEST['adresse'];
		$cp = $_REQUEST['cp'];
		$ville = $_REQUEST['ville'];
		$diplome = addslashes($_REQUEST['diplome']);
		$numsecu = $_REQUEST['numsecu'];
		$nationalite = $_REQUEST['nationalite'];
		$password = $_REQUEST['password'];

		if($password!="") {
				$password = hash_password($password);
				$pdo->modifIntervenantPublicAvecCode($num, $nom, $prenom, $date_naissance, $lieu_naissance,$tel, $adresse, $cp, $ville,$email,$diplome,$numsecu,$nationalite,$password);
			}
			else
			{
				$pdo->modifIntervenantPublicSansCode($num, $nom, $prenom, $date_naissance, $lieu_naissance,$tel, $adresse, $cp, $ville,$email,$diplome,$numsecu,$nationalite);
			}

		include("vues/v_entete.php");
		echo "<center><h3>Vos modifications ont bien été prises en compte.</h3></center>";
		//Utilisation
redirect('index.php?choixTraitement=intervenant&action=modifInfos',"5");
		break;

	}


case 'valideModif':
	{

		include("vues/v_entete.php");


		$date= $_REQUEST['date'];
		$intervenant=$_SESSION['intervenant'];
		$numIntervenant=$intervenant['ID_INTERVENANT'];


		foreach($date as $valeur) {
					$valeur1= date("Y-m-d", strtotime($valeur));
					$listeDate = $pdo->getPresenceDunIntervenant($numIntervenant);
					$validation=0;
					foreach($listeDate as $uneDate)
					{
							if($uneDate['DATE_PRESENCE']==$valeur1)
							{$validation=1;}
					}
					if($validation==0)
					{$pdo->ajoutPlanning($numIntervenant,$valeur1);}
		}

		echo "<center><h3>Votre(Vos) date(s) de présence a(ont) bien été prise(s) en compte.</h3></center>";
		break;
	}
	case 'recapPlanning':
	{
		include("vues/v_entete.php");

		$intervenant=$_SESSION['intervenant'];
		$numIntervenant=$intervenant['ID_INTERVENANT'];
		$heures = $pdo->getHeures($numIntervenant);

		include("vues/intervenant/v_recap.php");
		break;
	}

	case 'Documents':
	{
		include("vues/v_entete.php");

		$intervenant=$_SESSION['intervenant'];
		$numIntervenant=$intervenant['ID_INTERVENANT'];
		$IntervenantSelectionner=$pdo->recupUnIntervenant($numIntervenant);
		include("vues/intervenant/v_Documents.php");
		break;
	}

	case 'ServiceCivique':
	{
		include("vues/v_entete.php");

		$intervenant=$_SESSION['intervenant'];
		$numIntervenant=$intervenant['ID_INTERVENANT'];
		$inter=$pdo->recupUnIntervenant($numIntervenant);
		$serviceCivique=$inter['SERVICECIVIQUE'];
		include("vues/intervenant/v_ServiceCivique.php");
		break;
	}
	case 'ServiceCiviqueModif':
	{
		include("vues/v_entete.php");
        $service= $_REQUEST['service'];
		$numIntervenant=$intervenant['ID_INTERVENANT'];
		$pdo->modifServiceCivique($numIntervenant,$service);
		echo '<div id="contenu">';
		echo ' <h3> Votre commentaire a bien été modifié ! </h3>';
		echo '</div>';
		break;
	}


	case 'attestation':
	{


		$association = $pdo->getParametreSeul(10);
		$adresse = $pdo->getParametreSeul(11);
		$cp = $pdo->getParametreSeul(12);
		$ville = $pdo->getParametreSeul(13);

		$intervenant=$_SESSION['intervenant'];
		$numIntervenant=$intervenant['ID_INTERVENANT'];
		$IntervenantSelectionner=$pdo->recupUnIntervenant($numIntervenant);


		$presences = $pdo->getHeures($numIntervenant);

		list($annee, $mois, $jour) = explode('-', $presences[0]['SEANCE']);
		$premierePresence = $jour."/".$mois."/".$annee;
		list($annee, $mois, $jour) = explode('-', $presences[count($presences)-1]['SEANCE']);
		$dernierePresence = $jour."/".$mois."/".$annee;

		$hauteurLignes = 8;
		$tailleTexte = 12;

		/* on créé le PDF */
		require('fpdf/fpdf.php');
		$pdf = new FPDF();
		//$pdf->SetFillColor(255,255,255);

		$pdf->AddPage();
		$pdf->SetCreator($association['NOM'],true);
		$pdf->SetTitle('Attestation d\'activité à l\'association',true);
		$pdf->SetFont('Arial', 'B', $tailleTexte);

		// Bloc association
		$pdf->Cell(0, $hauteurLignes, utf8_decode($association['NOM']),0,1,'L');
		$pdf->SetFont('Arial', '', $tailleTexte);
		$pdf->Cell(0, $hauteurLignes, utf8_decode($adresse['NOM']),0,1,'L');
		$pdf->Cell(0, $hauteurLignes, utf8_decode($cp['NOM'] . ' ' . $ville['NOM']),0,1,'L');

		// Bloc intervenant
		$pdf->SetFont('Arial', 'B', $tailleTexte);
		$pdf->Cell(100, $hauteurLignes, '',0,0,'L');
		$pdf->Cell(0, $hauteurLignes, utf8_decode($IntervenantSelectionner['PRENOM'] . ' ' . $IntervenantSelectionner['NOM']),0,1,'L');
		$pdf->SetFont('Arial', '', $tailleTexte);
		$pdf->Cell(100, $hauteurLignes, '',0,0,'L');
		$pdf->Cell(0, $hauteurLignes, utf8_decode($IntervenantSelectionner['ADRESSE_POSTALE']),0,1,'L');
		$pdf->Cell(100, $hauteurLignes, '',0,0,'L');
		$pdf->Cell(0, $hauteurLignes, utf8_decode($IntervenantSelectionner['CODE_POSTAL'] . ' ' . $IntervenantSelectionner['VILLE']),0,1,'L');

		// Date et objet
		$pdf->Ln();
		$pdf->Cell(100, $hauteurLignes, '',0,0,'L');
		$pdf->Cell(0, $hauteurLignes, utf8_decode('Fait le '.date('d/m/Y', time()).' à '.$ville['NOM']),0,1,'L');
		$pdf->Ln();
		$pdf->SetFont('Arial', 'U', $tailleTexte);
		$pdf->Cell(0, $hauteurLignes, utf8_decode('Objet : attestation d\'activité à l\'association'),0,1,'L');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', $tailleTexte);

		// Contenu
		$pdf->Write($hauteurLignes, utf8_decode('Madame, Monsieur,'));
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Write($hauteurLignes,utf8_decode('Par la présente, je soussigné, Amine FARSI, agissant en qualité de Secrétaire Adjoint de l\'association '.$association['NOM'].', certifie que '.$IntervenantSelectionner['PRENOM'] . ' ' . $IntervenantSelectionner['NOM'].', demeurant au '.$IntervenantSelectionner['ADRESSE_POSTALE'].' '.$IntervenantSelectionner['CODE_POSTAL'] . ' ' . $IntervenantSelectionner['VILLE'] . ', a occupé le poste d\'intervenant(e) au soutien scolaire de l\'association, durant '.count($presences).' séance(s) du '.$premierePresence.' au '.$dernierePresence.'.'));
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(0, $hauteurLignes, utf8_decode('Veuillez croire, Madame, Monsieur, en l\'expression de mes sincères salutations.'),0,1,'L');
		$pdf->Ln();
		$pdf->Cell(100, $hauteurLignes, '',0,0,'L');
		$pdf->Cell(0, $hauteurLignes, utf8_decode('Amine FARSI'),0,1,'L');
		$pdf->Cell(100, $hauteurLignes, '',0,0,'L');
		$pdf->Cell(0, $hauteurLignes, utf8_decode('Secrétaire Adjoint'),0,1,'L');

		$pdf->Output();
		break;
	}


default :
	{
		echo 'erreur d\'aiguillage !'.$action;
		break;
	}
}
?>
