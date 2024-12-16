<?php
$base = mysql_connect ('mysql51-52.perso', 'associatryagain', 'Associa0r3');
mysql_select_db ('associatryagain', $base);

$i = 0;

$req = mysql_query('SELECT * FROM eleves') or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
while ($data = mysql_fetch_array($req)) {

	// Si l'email n'est pas vide
	if($data['EMAIL_DE_L_ENFANT'] != 'a@a') {

		// On vérifie que le contact n'existe pas déjà
		$req2 = mysql_query('SELECT * FROM roundcube_contacts WHERE email = "' . $data['EMAIL_DE_L_ENFANT'] . '"') or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		if(mysql_num_rows($req2) == 0) {
			$i++;
			
			// Création du contact
			mysql_query('INSERT INTO `roundcube_contacts`(`contact_id`, `changed`, `del`, `name`, `email`, `firstname`, `surname`, `vcard`, `words`, `user_id`) VALUES ("","2017-03-25 00:00:00","0","' . addslashes($data['NOM']) . ' ' . addslashes($data['PRENOM']) . '","' . addslashes($data['EMAIL_DE_L_ENFANT']) . '","' . addslashes($data['PRENOM']) . '","' . addslashes($data['NOM']) . '","","","1")') or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

			// On récupère l'ID du dernier enregistrement
			$idreq = mysql_query('SELECT * FROM roundcube_contacts ORDER BY contact_id DESC LIMIT 1');
			$iddata = mysql_fetch_array($idreq);
			
			// Ajout du contact dans le groupe des parents
			mysql_query('INSERT INTO `roundcube_contactgroupmembers`(`contactgroup_id`, `contact_id`, `created`)  VALUES ("2","' . $iddata['contact_id'] . '","2017-03-25 00:00:00")') or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

		}
	}
}

echo '<p>' . $i . ' contacts ajoutés</p>';
?>