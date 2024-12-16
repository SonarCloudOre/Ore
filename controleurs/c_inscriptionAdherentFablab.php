<?php
$action = $_REQUEST['action'];
switch($action) {
  case 'valideInscription':
	// Entete de la page
	include("vues/v_entete.php");
	
	// Partie "GET"
	$lesUtilisateurs = $pdo->getUtilisateurCentreInfo();
	$lesActivites = $pdo->getActivites();
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

			$telFixe = $_POST['telFixe'];
			if ($telFixe == "") $telFixe = null;
			$photo = $_POST['photo'];
			if ($photo == "") $photo = null;

			$pdo->ajouterUtilisateurCentreInfo($nom, $prenom, $email, $telMobile, $dateNaissance, $lieuNaissance, $adresse, $codePostal, $ville, $telFixe, $photo);
			$idUtilisateur = $pdo->getIdUtilisateurCentreInfo($email);
			$pdo->ajouterInscriptionCentreInfo($idUtilisateur);
			$idInscription = $pdo->getIdInscription($idUtilisateur);
		}
	}

	// Contenu de la page
	include("vues/administrateur/centreinfo/v_inscriptionAdherentsFabLab.php");
	break;
  case 'validePaiement':
    include(("vues/v_entete.php"));
}
?>