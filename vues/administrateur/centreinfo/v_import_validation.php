<div id="contenu">
    <h2>Données importées</h2>
    <style type="text/css">
        .inscrit_false {
            color: green !important;
        }
    </style>
    <?php

    // Si un fichier a été envoyé et au bon format
    if (isset($_FILES['fichier'])) {

        // On ouvre le fichier CSV
        $csv = fopen($_FILES['fichier']['tmp_name'], "r");

        // On intialise les variables
        $l = 0;
        $nbTotal = 0;
        $nbDejaInscrit = 0;
        $nbNouveaux = 0;
        $req = '';
        $code = '<table class="table">';

        // On parcours les lignes
        while (($ligne = fgets($csv)) !== false) {

            $dejaPresent = false;

            // Nouvelle ligne du tableau
            $code = $code . '<tr>';

            // Quel type de ligne afficher
            if ($l == 0) {
                $balise = 'th';
            } else {
                $balise = 'td';
            }

            // On récupère les valeurs de cette ligne séparées par des ;
            $valeurs = explode(';', $ligne);

            // On ignore la première ligne
            if ($l > 0) {

                // Initialisation des valeurs

                // Si c'est les inscriptions
                if ($type == 'inscrits') {
                    $codeClient = '';
                    $nomComplet = '';
                    $adresse = '';
                    $ville = '';
                    $cp = '';
                    $tel1 = '';
                    $tel2 = '';
                    $email = '';
                    $ddn = '';
                }

                // Si c'est les visites
                if ($type == 'visites') {
                    $codeClient = '';
                    $date = '';
                    $heure = '';
                    $dateHeure = '';
                    $pc = '';
                    $exe = '';
                    $url = '';
                }

            }

            $i = 0;

            // On parcours les valeurs
            foreach ($valeurs as $valeur) {

                //On supprime les guillemets
                $valeur = str_replace('"', '', $valeur);

                // Si ce n'est pas la ligne d'entête
                if ($l > 0) {

                    // Si c'est les inscriptions
                    if ($type == 'inscrits') {

                        // On enregistre la valeur
                        if ($i == 0) {
                            $codeClient = $valeur;
                        }
                        if ($i == 1) {
                            $nomComplet = $valeur;
                        }
                        if ($i == 2) {
                            $adresse = $valeur;
                        }
                        if ($i == 3) {
                            $ville = $valeur;
                        }
                        if ($i == 4) {
                            $cp = $valeur;
                        }
                        if ($i == 7) {
                            // On nettoie le téléphone
                            $valeur = str_replace('.', '', $valeur);
                            $valeur = str_replace('/', '', $valeur);
                            $valeur = str_replace('\\', '', $valeur);
                            $valeur = str_replace(' ', '', $valeur);
                            $valeur = str_replace('-', '', $valeur);
                            $valeur = str_replace('_', '', $valeur);
                            $tel1 = $valeur;
                        }
                        if ($i == 8) {
                            // On nettoie le téléphone
                            $valeur = str_replace('.', '', $valeur);
                            $valeur = str_replace('/', '', $valeur);
                            $valeur = str_replace('\\', '', $valeur);
                            $valeur = str_replace(' ', '', $valeur);
                            $valeur = str_replace('-', '', $valeur);
                            $valeur = str_replace('_', '', $valeur);
                            $tel2 = $valeur;
                        }
                        if ($i == 11) {
                            $email = $valeur;
                        }
                        if ($i == 15) {
                            // Si la date de naissance est renseignée
                            if (date('Y-m-d', strtotime($valeur)) != date('Y-m-d', time()) and strtotime($valeur) > 0) {
                                // On la convertit au bon format
                                $ddn = date('Y-m-d', strtotime($valeur));
                            }
                        }
                    }


                    // Si c'est les visites
                    if ($type == 'visites') {
                        if ($i == 0) {
                            $date = $valeur;
                        }
                        if ($i == 1) {
                            $heure = $valeur;

                            // Conversion de la date au bon format
                            $dateTemp = explode('/', $date);
                            $dateComplet = $dateTemp[2] . '-' . $dateTemp[1] . '-' . $dateTemp[0];
                        }
                        if ($i == 2) {
                            $pc = $valeur;
                        }
                        if ($i == 3) {
                            $exe = $valeur;
                        }
                        if ($i == 4) {
                            $url = $valeur;
                        }
                        if ($i == 5) {
                            $codeClient = rtrim($valeur);
                        }
                    }

                }

                // Si c'est les inscriptions
                if ($type == 'inscrits') {

                    // On vérifie si cette inscription est déjà enregistré
                    foreach ($lesInscriptions as $uneInscription) {

                        // Si l'inscription est déjà enregistrée
                        if ($uneInscription['code_cyberlux_inscription'] == $codeClient) {
                            $dejaPresent = true;
                        }
                    }
                }


                // Si c'est les visites
                if ($type == 'visites') {

                    // On vérifie si cette visites est déjà enregistré
                    foreach ($lesVisites as $uneVisite) {

                        // Si la visite est déjà enregistrée
                        if ($uneVisite['code_cyberlux'] == $codeClient
                            and $uneVisite['date_visite'] == $dateComplet . ' ' . $heure
                            and $uneVisite['pc_visite'] == $pc
                            and $uneVisite['logiciel_visite'] == $logiciel
                            and $uneVisite['url_visite'] == $url
                        ) {
                            $dejaPresent = true;
                        }
                    }
                }


                // On affiche la valeur
                if ($dejaPresent) {
                    $style = 'color:red';
                } else {
                    $style = 'color:green';
                }
                if ($l == 0) {
                    $style = 'color:black';
                }
                $code = $code . '<' . $balise . ' style="' . $style . '">' . strtoupper($valeur) . '</' . $balise . '>';

                // Comptabilisation du numero de valeur
                $i++;

            }


            // On ignore la ligne d'entete
            if ($l > 0) {


                // Si nouvelle inscription
                if ($dejaPresent == false) {

                    // Si c'est les inscriptions
                    if ($type == 'inscrits') {

                        // On sépare le nom et le prénom
                        $nomCompletTemp = explode(' ', $nomComplet);
                        $nom = $nomCompletTemp[0];
                        $prenom = '';
                        // Le prénom représente le reste de la chaine
                        foreach ($nomCompletTemp as $unePartie) {
                            if ($unePartie != $nom) {
                                $prenom = $prenom . ' ' . $unePartie;
                            }
                        }

                        // Ajout de l'inscription dans la requete
                        $req = $req . "INSERT INTO `info_inscriptions`(`nom_inscription`, `prenom_inscription`, `nom_cyberlux_inscription`, `code_cyberlux_inscription`, `adresse_inscription`, `cp_inscription`, `ville_inscription`, `ddn_inscription`, `date_inscription`, `tel1_inscription`, `tel2_inscription`, `email_inscription`) 
VALUES (UPPER('" . addslashes($nom) . "'),'" . addslashes($prenom) . "','" . addslashes($nomComplet) . "','" . $codeClient . "',UPPER('" . addslashes($adresse) . "'),'" . addslashes($cp) . "',UPPER('" . addslashes($ville) . "'),'" . $ddn . "',NOW(),'" . addslashes($tel1) . "','" . addslashes($tel2) . "','" . addslashes($email) . "');
INSERT INTO `info_annees` VALUES($anneeEnCours,(SELECT MAX(`id_inscription`) FROM `info_inscriptions`));
INSERT INTO `info_participe`(`id_inscription`, `id_activite`, `annee_inscription`) VALUES ((SELECT MAX(`id_inscription`) FROM `info_inscriptions`),$idAccesLibre,$anneeEnCours);
            ";
                    }


                    // Si c'est les visites
                    if ($type == 'visites') {

                        // Ajout de la visite dans la requete
                        $req = $req . "INSERT INTO `info_visites`(`code_cyberlux`, `date_visite`, `pc_visite`, `logiciel_visite`, `url_visite`) 
VALUES ('$codeClient','$dateComplet $heure','" . addslashes($pc) . "','" . addslashes($exe) . "','" . addslashes($url) . "');
";

                    }

                    // Comptabilisation
                    $nbNouveaux++;

                } else {
                    $nbDejaInscrit++;
                }

                $nbTotal++;
            }

            // Fin de la ligne du tableau
            $code = $code . '</tr>';

            // Comptabilisation du numero de ligne
            $l++;

        }

        // Fin du tableau
        $code = $code . '</table>';

        // On ferme le fichier
        fclose($csv);

        // On insère les inscriptions dans la BDD si la requete n'est pas vide
        if ($nbNouveaux > 0) {
            $pdo->executerRequete3($req);
        }

        // On affiche les chiffres
        echo "<hr><h3>Fichier importé</h3>
    <p>Nombre d'entrées dans le fichier : " . $nbTotal . "<br>
<div style=\"color:red\">Entrées déjà présentes : " . $nbDejaInscrit . "</div>
<div style=\"color:green\">Nouvelles entrées ajoutées : " . $nbNouveaux . "</div></p>
<textarea style=\"width:1000px;height:500px\">" . $req . "</textarea>";

        // On affiche le tableau
        echo $code;
    }
    ?>
</div>