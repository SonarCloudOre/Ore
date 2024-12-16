<div id="contenu">
    <h2>Publipostage</h2>
    <?php if ($_POST['maj'] == 'oui') {
// Mise à jour des contacts
// On vide les anciens
        $pdo->executerRequete('DELETE FROM `roundcube_contactgroupmembers` WHERE 1');
        $pdo->executerRequete('DELETE FROM `roundcube_contacts` WHERE 1');

        $pdo->connexionBDD();

        function ajouterContact($nom, $prenom, $email, $groupes, $dupliquer)
        {

            if ($dupliquer) {
                $nomComplet = $nom . ' ' . $prenom;
            } else {
                $nomComplet = $nom;
            }

            // On insère dans la table
            mysql_query('INSERT INTO `roundcube_contacts`(`contact_id`, `changed`, `del`, `name`, `email`, `firstname`, `surname`, `vcard`, `words`, `user_id`) VALUES ("", "2017-04-14 13:28:03", "0", "' . $nomComplet . '", "' . $email . '", "' . $prenom . '", "' . $nom . '","BEGIN:VCARD\nVERSION:3.0\nN:' . $nom . ';' . $prenom . ';;;\nFN:' . $prenom . ' ' . $nom . '\nEMAIL;TYPE=INTERNET;TYPE=HOME:' . $email . '\nEND:VCARD","' . $prenom . ' ' . $nom . ' ' . $email . '","1")') or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());

            // On récupère l'ID de ce contact
            $resultat = mysql_query('SELECT * FROM `roundcube_contacts` ORDER BY `contact_id` DESC LIMIT 0,1') or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());
            while ($donnees = mysql_fetch_array($resultat)) {
                $id = $donnees['contact_id'];
            }

            // On insère dans les groupes
            foreach ($groupes as $groupe) {
                mysql_query('INSERT INTO `roundcube_contactgroupmembers`(`contactgroup_id`, `contact_id`, `created`) VALUES ("' . $groupe . '","' . $id . '","2017-04-14 13:57:16")') or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());
            }
        }


        $nbElevesTotal = 0;
        $nbElevesAnnee = 0;
        $nbParentsTotal = 0;
        $nbParentsAnnee = 0;
        $nbIntervenantsTotal = 0;
        $nbIntervenantsAnnee = 0;


// Eleves et parents
        $resultat = mysql_query('SELECT eleves.NOM, eleves.PRENOM, eleves.RESPONSABLE_LEGAL, eleves.EMAIL_DE_L_ENFANT, inscrit.ANNEE, eleves.EMAIL_DES_PARENTS, inscrit.ID_CLASSE, eleves.ID_ELEVE FROM eleves INNER JOIN inscrit ON eleves.ID_ELEVE = inscrit.ID_ELEVE') or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());
        while ($donnees = mysql_fetch_array($resultat)) {

            // Si c'est un élève de l'année en cours
            if ($anneeEnCours == $donnees['ANNEE']) {

                // On met l'eleves
                if ($donnees['EMAIL_DE_L_ENFANT'] != '' && $donnees['EMAIL_DE_L_ENFANT'] != 'a@a' && $donnees['EMAIL_DE_L_ENFANT'] != 'a@a.fr') {
                    ajouterContact(addslashes($donnees['NOM']), addslashes($donnees['PRENOM']), $donnees['EMAIL_DE_L_ENFANT'], array('2', $donnees['ID_CLASSE']), true);
                    $nbElevesAnnee++;
                }

                // On met le parents
                if ($donnees['EMAIL_DES_PARENTS'] != '' && $donnees['EMAIL_DES_PARENTS'] != 'a@a' && $donnees['EMAIL_DES_PARENTS'] != 'a@a.fr') {
                    ajouterContact(addslashes($donnees['RESPONSABLE_LEGAL']), addslashes($donnees['RESPONSABLE_LEGAL']), $donnees['EMAIL_DES_PARENTS'], array('1', ($donnees['ID_CLASSE'] + 100)), false);
                    $nbParentsAnnee++;
                }
            }


            // Dans tous les cas, on les ajoute dans "listing complet"
            // Eleve
            if ($donnees['EMAIL_DE_L_ENFANT'] != '' && $donnees['EMAIL_DE_L_ENFANT'] != 'a@a' && $donnees['EMAIL_DE_L_ENFANT'] != 'a@a.fr') {
                ajouterContact(addslashes($donnees['NOM']), addslashes($donnees['PRENOM']), $donnees['EMAIL_DE_L_ENFANT'], array('160'), true);
                $nbElevesTotal++;
            }
            // Parent
            if ($donnees['EMAIL_DES_PARENTS'] != '' && $donnees['EMAIL_DES_PARENTS'] != 'a@a' && $donnees['EMAIL_DES_PARENTS'] != 'a@a.fr') {
                ajouterContact(addslashes($donnees['RESPONSABLE_LEGAL']), addslashes($donnees['RESPONSABLE_LEGAL']), $donnees['EMAIL_DES_PARENTS'], array('160'), false);
                $nbParentsTotal++;
            }
        }


// Intervenants
        $resultat = mysql_query('SELECT * FROM `intervenants` INNER JOIN `inscrit_intervenants` ON `intervenants`.`ID_INTERVENANT`=`inscrit_intervenants`.`ID_INTERVENANT`') or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());
        while ($donnees = mysql_fetch_array($resultat)) {
            // On met les intervenants de cette année
            if ($donnees['EMAIL'] != '' && $donnees['EMAIL'] != 'a@a' && $donnees['EMAIL'] != 'a@a.fr') {

                // Si il est de cette année on l'ajoute dans "Intervenants Tout"
                if ($donnees['ANNEE'] == $anneeEnCours) {
                    ajouterContact(addslashes($donnees['NOM']), addslashes($donnees['PRENOM']), $donnees['EMAIL'], array('3'), true);
                    $nbIntervenantsAnnee++;
                }

                // Dans tous les cas, on l'ajoute dans "listing complet"
                ajouterContact(addslashes($donnees['NOM']), addslashes($donnees['PRENOM']), $donnees['EMAIL'], array('160'), true);
                $nbIntervenantsTotal++;
            }
        }

// Message de confirmation
        echo '<p style="font-weight:bold;color:green;text-align:center">Les contacts ont bien été mis à jour !<br><br>
<u>Pour l\'année ' . $anneeEnCours . '-' . ($anneeEnCours + 1) . ' :</u><br>
Eleves : ' . $nbElevesAnnee . ' adresse(s)<br>
Parents : ' . $nbParentsAnnee . ' adresse(s)<br>
Intervenants : ' . $nbIntervenantsAnnee . ' adresse(s)<br><br><br>

<u>Dans le listing complet :</u><br>
Eleves : ' . $nbElevesTotal . ' adresse(s)<br>
Parents : ' . $nbParentsTotal . ' adresse(s)<br>
Intervenants : ' . $nbIntervenantsTotal . ' adresse(s)
</p>';
    }
    ?>

    <center>
        <img src="./images/e-mail.png" style="width:100px">
        <img src="./images/roundcube.png" style="width:150px">
        <br><br>
        <form method="POST" action="index.php?choixTraitement=administrateur&action=Publipostage" name="form">
            <input type="hidden" name="maj" value="oui">
            <input type="submit" class="btn btn-warning" value="Mettre à jour les contacts" style="font-size:20px">
        </form>
        <?php if ($_POST['maj'] == 'oui') { ?>
            <br><br>
            <form method="POST" action="http://association-ore.fr/mail/?_task=login" name="form" target="_blank">
                <input type="hidden" name="_token" value="">
                <input type="hidden" name="_task" value="login"><input type="hidden" name="_action" value="login">
                <input type="hidden" name="_timezone" id="rcmlogintz" value="_default_">
                <input type="hidden" name="_url" id="rcmloginurl" value="_task=login">

                <input type="text" style="display:none" name="_user" value="association.ore@gmail.com">
                <input type="password" style="display:none" name="_pass" value="@ssORE1994">
                <input type="text" style="display:none" name="_host" value="smtp.gmail.com">
                <input type="submit" class="btn btn-success" value="Accéder à l'interface Mail" style="font-size:20px">
            </form>
        <?php } ?>
    </center>
</div>