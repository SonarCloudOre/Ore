<?php

function redirect($url, $time=3) {
   echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="'.$url.'";</SCRIPT>';
}

$action = $_REQUEST['action'];

/*
function envoyerMail($mail,$nom,$prenom,$nom_stage,$id_stage) {
	$nom_stage = str_replace('\\','',$nom_stage);
	$nom = str_replace('\\','',$nom);
	$prenom = str_replace('\\','',$prenom);
	//envoi d'un mail au parent
			  $headers  = "From: \"Association ORE\n";
			  $headers .= "Reply-To: association.ore@gmail.com\n";
			  $headers .= "X-Priority: 5\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

			  $subject  = 'Inscription de '.$nom.' '.$prenom . ' à ' . $nom_stage;

			  $message  = '<p><center><img src="https://association-ore.fr/extranet/images/logo.png"></center></p>
			  <h2>Inscription de '.$nom.' '.$prenom . ' à ' . $nom_stage.'</h2>
			  <p>Bonjour,<br><br>
			  <b>Nous vous confirmons par ce mail l\'inscription de '.$nom.' '.$prenom . ' à notre stage ' . $nom_stage.'.</b></p>
			  <p>Pour toute demande d\'informations complémentaires, vous pouvez nous contacter :</p>
			  <ul>
				<li>Par mail à <a href="mailto:association.ore@gmail.com">association.ore@gmail.com</a>
				<li>Par téléphone au <a href="tel:0380482396">0380482396</a></li>
				<li>Ou nous rencontrer au Centre Informatique Municipal, situé au 3 rue des Prairies 21800 Quetigny, ouvert du lundi au vendredi de 10H à 12H et de 14H à 17H.</li>
			  </ul>
			  <p>Si vous souhaitez effectuer une nouvelle inscription, vous pouvez cliquer sur le lien ci-dessous :</p>
			  <p><center><a style="font-size:24px;font-weight:bold" href="https://association-ore.fr/extranet/index.php?choixTraitement=inscriptionstage&action=inscription&num='.$id_stage.'">Nouvelle Inscription</a></center></p>
			  <p>Bonne journée.<br>
			  Cordialement.</p>
			  <p>_____________________________________________________<br>
			 <b> Association ORE</b><br>
Adresse : 2A Bd Olivier de Serres - 21800 Quetigny (Maison des associations)<br>
Tél : 03 80 48 23 96<br>
Mail : association.ore@gmail.com<br>
Web : <a href="http://www.association-ore.fr">www.association-ore.fr</a><br>
Facebook : <a href="https://www.facebook.com/AssociationORE/">https://www.facebook.com/AssociationORE/ </a>
</p>';

			  $result = mail($mail, $subject, $message, $headers);






	// envoi d'un mail à ore
	$mail = 'association.ore@gmail.com';
	 $headers  = "From: \"Association ORE\n";
			  $headers .= "Reply-To: association.ore@gmail.com\n";
			  $headers .= "X-Priority: 5\n";
				$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

			  $subject  = 'Inscription de '.$nom.' '.$prenom . ' à ' . $nom_stage;

			  $message  = '<p><center><img src="https://association-ore.fr/extranet/images/logo.png"></center></p>
			  <h2>Inscription de '.$nom.' '.$prenom . ' à ' . $nom_stage.'</h2>
			  <p>Bonjour,<br><br>
			  <b>Nouvelle inscription de '.$nom.' '.$prenom . ' au stage ' . $nom_stage.'.</b></p>
				<p>Pour gérer les inscriptions à ce stage, <a href="https://association-ore.fr/extranet/index.php?choixTraitement=administrateur&action=Stages&unStage='.$id_stage.'">cliquez ici</a>.</p>
			  <p>_____________________________________________________<br>
			 <b> Association ORE</b><br>
Adresse : 2A Bd Olivier de Serres - 21800 Quetigny (Maison des associations)<br>
Tél : 03 80 48 23 96<br>
Mail : association.ore@gmail.com<br>
Web : <a href="http://www.association-ore.fr">www.association-ore.fr</a><br>
Facebook : <a href="https://www.facebook.com/AssociationORE/">https://www.facebook.com/AssociationORE/ </a>
</p>';

			  $result = mail($mail, $subject, $message, $headers);
}
*/

function erreur() {
	echo '<br><br><br><center><img src="./images/danger.jpg" style="width:200px"><br><br><br>
	<p style="color:red;font-weight:bold;font-size:24px">Erreur de lien !<br><br>Pour toute information, vous pouvez nous contacter :<br><br>
	- par téléphone au <a href="tel:0380482396">0380482396</a><br>
	- par email à <a href="mailto:association.ore@gmail.com">association.ore@gmail.com</a><br>
	</p></center>';

}

switch($action) {

	/* Page d'inscription*/
	case 'inscription':
	{
			$num = $_GET['num'];
			

         include("vues/v_entete.php");


      $villesFrance = $pdo->VillesFrance();
			if(($num!= '') && (is_numeric($num))) {
				

                // Ateliers
				$lesAteliers = $pdo->recupAteliers($num);
                $lesParticipes = $pdo->nbInscritsAtelier();

				$leStage = $pdo->recupStage($num);
				$lesLieux = $pdo->getLieux();
				$lesPartenairesStage = $pdo->recupPartenairesStage($num);
				$lesClasses 	= $pdo->getParametre(4);
				$lesfilieres 	= $pdo->getParametre(3);
				$lesEtablissements 	= $pdo->getParametre(1);
        $telephone 	= $pdo->getParametre(14);
        $email	= $pdo->getParametre(15);
        $lesGroupesAtelier = $pdo->getParametre(16);
        $lesAssociations = $pdo->getParametre(23);

				include("vues/inscriptionStage/v_InscriptionStage.php");

			// Erreur de lien
			} else {
				erreur();
			}

		break;
	}
	 /*Redirection vers un formulaire*/
	case 'redirection':
	{
        $stage = $_REQUEST['stage'];
        $id_stage = 0;

        // On récupère les redirections
        $lesRedirections = $pdo->getParametre(17);

        // On les parcours
        foreach($lesRedirections as $laRedirection) {

            echo $laRedirection['VALEUR'];

            // Si c'est cette redirection
            if($laRedirection['NOM'] == $stage) {

                // On récupère l'ID du stage
                $id_stage = $laRedirection['VALEUR'];
            }
        }
        // On redirige
        redirect('https://association-ore.fr/extranet/index.php?choixTraitement=inscriptionstage&action=inscription&num='.$id_stage,"1");
        break;
    }
	/* Inscription d'un élève de ORE */
	case 'valideInscriptionOre':
	{
			include("vues/v_entete.php");

            // Si une inscription est envoyée
			if(isset($_POST['nom'])) {
				$num = $_POST['num'];
				$nom = $_POST['nom'];
				$prenom = $_POST['prenom'];
				$classe = $_POST['classe'];
			  $datedenaissance = $_POST['ddnaissance'];
				$date = $_POST['date'];
				$ip = $_POST['ip'];
				$user_agent = $_POST['user_agent'];
				$origine = $_POST['origine'];
				$nom_stage = $_POST['nom_stage'];
				$id_atelier = $_POST['atelier'] ?? 0;
        $id_groupeAtelier = $_POST['groupeAtelier'];
				$mail = $_POST['email_parent'];
				$tel_parent = $_POST['tel_parent'];
				$tel_enfant = $_POST['tel_eleve'];


				$pdo->inscriptionStageOre($num,$nom,$prenom,$datedenaissance,$date,$ip,$user_agent,$origine,$id_atelier,$classe,$tel_parent,$tel_enfant);

				$message = "Bonjour.\n\nNous vous informons que l'inscription de ".$nom." ".$prenom." a bien été prise en compte.\n\nCordialement,\nAssociation ORE";
                // On récupère l'ID de cette inscription
                $id_inscription = $pdo->recupIdInscription($num);

                $lesGroupesAtelier = $pdo->getParametre(16);
                $lesAteliersChoisis = array();
              //  if($lesGroupesAtelier== NULL){
					// On parcours les ateliers
					//foreach($lesGroupesAtelier as $unGroupeAtelier) {

						// On inscrit à cet atelier
						//$pdo->inscrireAtelier($id_inscription['max'], $_POST['atelier_' . $unGroupeAtelier['ID']] );

            // On inscrit à cet atelier
            if ($_POST['atelier_' . $id_groupeAtelier] && $id_atelier) {

            $pdo->inscrireAtelier($id_inscription['max'], $_POST['atelier_' . $id_groupeAtelier]);
          }
					//}

              //  }
				$_GET['num'] = $num;
				include("vues/inscriptionStage/v_ValidationInscription.php");

			// Erreur de lien
			} else {
				erreur();
			}

		break;
	}

	/* Nouvelle Inscription d'un élève */
	case 'valideInscriptionNouvelle':
	{
			include("vues/v_entete.php");

			if(isset($_POST['nom'])) {
				$num = $_POST['num'];
        		$nom =strtoupper($_POST['nom']);
        		$prenom= ucfirst($_POST['prenom']);
				$datedenaissance = $_POST['ddnaissance'];
				$date = $_POST['date'];
				$ip = $_POST['ip'];
				$user_agent = $_POST['user_agent'];
				$origine = $_POST['origine'];
				$nom_stage = $_POST['nom_stage'];
				$id_atelier = $_POST['atelier'] ?? 0;
				$id_groupeAtelier = $_POST['groupeAtelier'];
				$sexe = $_POST['sexe'];
				$etab = $_POST['etab'];
				$classe = $_POST['classe'];
				$filiere = $_POST['filiere'];
				$tel_enfant = $_POST['tel_enfant'];
				$email_enfant = $_POST['email_enfant'];
				$tel_parent = $_POST['tel_parent'];
				$mail = $_POST['email_parent'];
				$adresse = $_POST['adresse'];
				$cp = $_POST['cp'];
				$ville = $_POST['ville'];
				$association = $_POST['association'];

				$pdo->inscriptionStageNouvelle($num,$nom,$prenom,$datedenaissance,$date,$ip,$user_agent,$origine,$id_atelier,$sexe,$etab,$classe,$filiere,$tel_enfant,$email_enfant,$tel_parent,$email_parent,$adresse,$cp,$ville,$association);

                // On récupère l'ID de cette inscription
                $id_inscription = $pdo->recupIdInscription($num);

                $lesGroupesAtelier = $pdo->getParametre(16);
                $lesAteliersChoisis = array();

                // On parcours les ateliers
                /*foreach($lesGroupesAtelier as $unGroupeAtelier) {

                    // On inscrit à cet atelier
                    $pdo->inscrireAtelier($id_inscription['max'], $_POST['atelier_' . $id_groupeAtelier]);
                }*/

                // On inscrit à cet atelier
                if ($_POST['atelier_' . $id_groupeAtelier] && $id_atelier) {
                  $pdo->inscrireAtelier($id_inscription['max'], $_POST['atelier_' . $id_groupeAtelier]);
                }

				include("vues/inscriptionStage/v_ValidationInscription.php");
			// Erreur de lien
			} else {
				erreur();
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
