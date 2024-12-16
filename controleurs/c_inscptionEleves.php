<?php

function formulaireDate($jourEnCours,$moisEnCours,$anneeEnCours, $idformulaire) {

    // Si aucun jour n'est fourni, on affiche le jour actuel
    if($jourEnCours == 0) { $jourEnCours = date('j',time()); }

    // Si aucun mois n'est fourni, on affiche le mois actuel
    if($moisEnCours == 0) { $moisEnCours = date('n',time()); }

    // Si aucun année n'est fourni, on affiche le année actuel
    if($anneeEnCours == 0) { $anneeEnCours = date('Y',time()); }

    echo '<input type="date" class="form-control" id="'.$idformulaire.'" name="'.$idformulaire.'" value="'.$anneeEnCours.'-'.$moisEnCours.'-'.$jourEnCours.'">';
}

$action = $_REQUEST['action'];
switch($action) {
case 'index':
	{
		include("vues/v_entete.php");
		$lesEtablissements 	= $pdo->getParametre(1);
		$lesLangues 	= $pdo->getParametre(2);
		$lesfilieres 	= $pdo->getParametre(3);
		$lesClasses 	= $pdo->getParametre(4);
		$lesMatieres 	= $pdo->getParametre(6);
		$lesSpecialites 	= $pdo->getParametre(21);
    $villesFrance = $pdo->VillesFrance();
		$anneeEnCours 	= $pdo->getAnneeEnCours();
      if ((isset($numIntervenant))&&($admin>0)) {
      	$lesEleves=$pdo->recupTousEleves222();
      }
		include("vues/v_inscriptionEleves.php");
		//$footerNePasAfficher = false;
		break;
	}

  case 'recupImportEleve':
  {
    if(isset($_POST["eleve"]))
    {
        $eleveChoisi = $pdo->recupInfosImportEleve($_POST["eleve"]);
        echo $eleveChoisi["NOM"]."~";
        echo $eleveChoisi["RESPONSABLE_LEGAL"]."~";
        echo $eleveChoisi["PROFESSION_DU_PÈRE"]."~";
        echo $eleveChoisi["PROFESSION_DE_LA_MÈRE"]."~";
        echo $eleveChoisi["ADRESSE_POSTALE"]."~";
        echo $eleveChoisi["CODE_POSTAL"]."~";
        echo $eleveChoisi["VILLE"]."~";
        echo $eleveChoisi["TÉLÉPHONE_DES_PARENTS"]."~";
        echo $eleveChoisi["TÉLÉPHONE_DES_PARENTS2"]."~";
        echo $eleveChoisi["TÉLÉPHONE_DES_PARENTS3"]."~";
		echo $_POST["eleve"]."~";
    }
    break;
  }

	case 'InscriptionScolarite':
	{
		include("vues/v_entete.php");
		if(isset($_REQUEST['numCarte']))
		{
			$num=$_REQUEST['numCarte'];
			$unEleve=$pdo->getIdEleve($num);
			$numeroEleve=$unEleve['ID_ELEVE'];
			$maxAnnee=$unEleve['MAXANNEE'];

		}

		$lesEtablissements   = $pdo->getParametre(1);
		$lesLangues 	     = $pdo->getParametre(2);
		$lesfilieres         = $pdo->getParametre(3);
		$lesClasses 	     = $pdo->getParametre(4);
		$lesMatieres 	     = $pdo->getParametre(6);
		$lesSpecialites 	= $pdo->getParametre(20);

		include("vues/v_inscriptionElevesScolarite.php");
		break;
	}
	case 'InscriptionScolariteValidation':
	{
		include("vues/v_entete.php");

			$num=$_REQUEST['num'];
			$unEleve=$pdo->getMaxAnneeInscription($num);
			$maxAnnee=$unEleve['ANNEEMAX'];

			$difficultes= $_REQUEST['difficultes'];
			$etab= $_REQUEST['etab'];
			$classe= $_REQUEST['classe'];
			$prof_principal=$_REQUEST['prof_principal'];
			$filiere= $_REQUEST['filiere'];
			$lv1= $_REQUEST['lv1'];
			$lv2= $_REQUEST['lv2'];
			$specialites= $_REQUEST['specialites'];
			$pdo->ajoutInscriptionELEVE($num, $maxAnnee ,$etab, $filiere, $lv1,$lv2,$classe,$prof_principal);

			$fratrie= $_REQUEST['fratries'];

			$pdo->AjouterFratries($num,$fratrie);

			foreach($difficultes as $valeur) {
				$pdo->ajoutDifficulte($num,$valeur,$maxAnnee);
			}

			foreach($specialites as $valeur) {
				$pdo->ajoutSpecialites($num,$valeur,$maxAnnee);
			}

			echo '<div id="contenu">';
		echo ' <h3> L\'inscription pour cette nouvelle année a bien été faites! </h3>';
		echo '</div>';
		break;
	}

	case 'evenementInscriptionEleve':
	{
		include("vues/v_entete.php");
		if(isset($_REQUEST['numCarte']))
		{
			$num=$_REQUEST['numCarte'];
			$lesEvenements =$pdo->recupEvenementApresDateNow();
			$unEleve=$pdo->getIdEleve($num);
			$numeroEleve=$unEleve['ID_ELEVE'];

		}
		include("vues/v_inscriptionElevesEvenement.php");
		break;
	}

	case 'valideInscription':
	{
		include("vues/v_entete.php");

		$nom= $_REQUEST['nom'];
		$prenom= htmlentities($_REQUEST['prenom'], ENT_QUOTES);
		$sexe= htmlentities($_REQUEST['sexe'], ENT_QUOTES);
    	$date_naissance = $_REQUEST['date_naissance'];
		$tel_enfant= $_REQUEST['tel_enfant'];
		$email_enfant= htmlentities($_REQUEST['email_enfant'], ENT_QUOTES);
		$etab= htmlentities($_REQUEST['etab'], ENT_QUOTES);
		$classe= htmlentities($_REQUEST['classe'], ENT_QUOTES);
		$prof_principal = htmlentities($_REQUEST['prof_principal'], ENT_QUOTES);
		$filiere = htmlentities($_REQUEST['filiere'], ENT_QUOTES);
		$lv1 = htmlentities($_REQUEST['lv1'], ENT_QUOTES);
		$lv2 = htmlentities($_REQUEST['lv2'], ENT_QUOTES);
		$responsable_legal = htmlentities($_REQUEST['responsable_legal'], ENT_QUOTES);
		$tel_parent = $_REQUEST['tel_parent'];
		$tel_parent2= $_REQUEST['tel_parent2'];
		$tel_parent3= $_REQUEST['tel_parent3'];
		$profession_pere = htmlentities($_REQUEST['profession_pere'], ENT_QUOTES);
		$adresse = htmlentities($_REQUEST['adresse'], ENT_QUOTES);
		$profession_mere = htmlentities($_REQUEST['profession_mere'], ENT_QUOTES);
		$cp = $_REQUEST['cp'];
		$ville = htmlentities($_REQUEST['ville'], ENT_QUOTES);
    	$email_parent = htmlentities($_REQUEST['email_parent'], ENT_QUOTES);
		$prevenir_parent = $_REQUEST['prevenir_parent'];
		$commentaires = htmlentities($_REQUEST['commentaires'], ENT_QUOTES);
		$responsabilite = $_REQUEST['responsabilite'];
		$assurance = $_REQUEST['assurance'];
		$specialites = $_REQUEST['specialitesA'];
    	$difficultes = $_REQUEST['difficultes'];
		$annee= $_REQUEST['annee'];

		$fratrie= $_REQUEST['fratries'];

		// CALCUL DU CODE BARRE
        /*
			$maxNumEleves1= $pdo->maxNumEleves();
			$maximumNum1=$maxNumEleves1['Maximum']+1;

			$dateOjd = date('d-m-Y', strtotime('+0 day'));
			// extraction des jour, mois, an de la date
			list($jour, $mois, $annee) = explode('-', $dateOjd);
			if(strlen($maximumNum1)==2)
			{ $codebarre=$annee."0000000".$maximumNum1;}
			if(strlen($maximumNum1)==3)
			{ $codebarre=$annee."000000".$maximumNum1;}
			if(strlen($maximumNum1)==4)
			{ $codebarre=$annee."00000".$maximumNum1;}
			if(strlen($maximumNum1)==5)
			{ $codebarre=$annee."00000".$maximumNum1;}
		*/

		//FIN CALCUL CODE BARRE

		$ajout= $pdo->ajoutEleve($nom, $prenom, $sexe, $date_naissance, $tel_enfant, $email_enfant,$responsable_legal,$tel_parent,$tel_parent2,$tel_parent3, $profession_pere,$adresse,$profession_mere,$ville, $email_parent,$prevenir_parent,$commentaires,$cp,$codebarre);

		$maxNumEleves= $pdo->maxNumEleves();
		$maximumNum=$maxNumEleves['Maximum'];

try {
  $pdo->ajoutInscriptionELEVE($maximumNum, $annee ,$etab, $filiere, $lv1,$lv2,$classe,$prof_principal);

} catch (\Exception $e) {
  echo $e->getMessage();
}

		$pdo->AjouterFratries($maximumNum,$fratrie);


    $idEleve = $pdo->executerRequete("SELECT MAX(ID_ELEVE) as ID_ELEVE FROM `quetigny_eleves`;");

    foreach($specialites as $valeur) {
        $pdo->ajoutSpecialites($idEleve["ID_ELEVE"],$valeur,$annee);
    }

			foreach($difficultes as $valeur) {
					$pdo->ajoutDifficulte($idEleve["ID_ELEVE"],$valeur,$annee);
			}
			$url = 'index.php?choixTraitement=inscriptionEleves&action=index#step-4';
		echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="'.$url.'";</SCRIPT>';
		break;
	}
	default:
	{
		echo 'erreur d\'aiguillage !'.$action;
		break;
	}
}
?>
