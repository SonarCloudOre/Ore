<?php
$action = $_REQUEST['action'];
switch($action) {
	case 'index':
	{
		include("vues/v_entete.php");
		$villesFrance = $pdo->VillesFrance();
				$lesMatieres 	= $pdo->getParametre(6);
			$anneeEnCours 	= $pdo->getAnneeEnCours();
			$lesBanques = $pdo->getLesBanques();
		include("vues/v_inscriptionIntervenant.php");
		break;
	}

	case 'valideInscription':
	{
		include("vues/v_entete.php");

		$annee= $_REQUEST['annee'];
		$nom= htmlentities(strtoupper($_REQUEST['nom']), ENT_QUOTES);
		$prenom= htmlentities(ucfirst($_REQUEST['prenom']), ENT_QUOTES);
		$actif= $_REQUEST['actif'];
		$date_naissance=$_REQUEST['date_naissance'];
		$lieu_naissance= htmlentities($_REQUEST['lieu_naissance'], ENT_QUOTES);
		$tel= $_REQUEST['tel'];
		$adresse= htmlentities($_REQUEST['adresse'], ENT_QUOTES);
		$statut= $_REQUEST['statut'];
		$cp= $_REQUEST['cp'];
		$ville= htmlentities($_REQUEST['ville'], ENT_QUOTES);
    	$email= $_REQUEST['email'];
		$commentaires= htmlentities($_REQUEST['commentaires'], ENT_QUOTES);
		$diplome= htmlentities($_REQUEST['diplome'], ENT_QUOTES);
		$numsecu= $_REQUEST['numsecu'];
		$nationalite= htmlentities($_REQUEST['nationalite'], ENT_QUOTES);
		$password= hash_password($_REQUEST['password']);
		$specialite= $_REQUEST['specialites'];

		$iban= $_REQUEST['iban'];
		$bic= $_REQUEST['bic'];
		$compte= $_REQUEST['compte'];
		$banque= htmlentities($_REQUEST['banque'], ENT_QUOTES);

		$ajout= $pdo->ajoutIntervenant($annee, $nom, $prenom, $actif, $date_naissance, $lieu_naissance,$tel, $adresse,$statut, $cp, $ville,$email,$commentaires,$diplome,$numsecu,$nationalite,$password,$iban,$bic,$compte,$banque);

		$maxNumIntervenants= $pdo->maxNumIntervenants();
		$maximumNum=$maxNumIntervenants['Maximum'];

		if(	$specialite != '') {
			foreach($specialite as $valeur) {
				$pdo->ajoutSpecialite($maximumNum,$valeur);
			}
		}

if ($ajout) {
	include("vues/v_validationInscription.php");
}else {
	echo 'problem lors l\'insertion en base';
}
		break;
	}
	default:
	{
		echo 'erreur d\'aiguillage !'.$action;
		break;
	}
}
?>
