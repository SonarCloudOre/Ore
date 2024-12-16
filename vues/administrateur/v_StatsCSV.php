<?php
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$fichier_csv = fopen('php://output', 'w');

function encode($texte)
{
    return iconv("UTF-8", "windows-1252", utf8_utf8_encode($texte));
}


$footerANePasAfficher = 1;

// Paramétrage de l'écriture du futur fichier CSV
//$chemin = 'creationDoc/'.$code_aleatoire.'.csv';
$delimiteur = ';'; // Pour une tabulation, utiliser $delimiteur = "t";

// Création du fichier csv (le fichier est vide pour le moment)
// w+ : consulter http://php.net/manual/fr/function.fopen.php
//$fichier_csv = fopen($chemin, 'w+');

// Si votre fichier a vocation a être importé dans Excel,
// vous devez impérativement utiliser la ligne ci-dessous pour corriger
// les problèmes d'affichage des caractères internationaux (les accents par exemple)
//fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
function getNomParametre($id)
{
    include_once('include/class.pdo.php');
    $base = mysql_connect(PdoBD::$stats, PdoBD::$user, PdoBD::$mdp);
    mysql_select_db(PdoBD::$bdd, $base);
    $resultat = mysql_query('SELECT ID,NOM FROM parametre WHERE ID = "' . $id . '" LIMIT 0,1') or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());
    while ($donnees = mysql_fetch_array($resultat)) {
        return $donnees['NOM'];
    }
}

//$Laligne[] = array('NOM', 'PRENOM','DATE_DE_NAISSANCE','TÉLÉPHONE_DES_PARENTS','ADRESSE_POSTALE','CODE_POSTAL','VILLE');
// chaque ligne en cours de lecture est insérée dans le fichier
// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
fputcsv($fichier_csv, array('Nom', 'Prenom', 'Classe', 'Filiere', 'Etablissement', 'Présences', 'LV1', 'LV2', 'Sexe', 'Date de naissance', 'Tel parents', 'Mail parents', 'Tel enfant', 'Mail enfant', 'Adresse', 'Code_Postal', 'Ville'), $delimiteur);

// Connexion
include_once('include/class.pdo.php');
$base = mysql_connect(PdoBD::$stats, PdoBD::$user, PdoBD::$mdp);
mysql_select_db('associatryagain', $base);

$resultat = mysql_query(utf8_decode(stripslashes($req))) or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());
while ($donnees = mysql_fetch_array($resultat)) {

    $donnees['TELEPHONE'] = '=("' . $donnees['TELEPHONE'] . '")';
    $nb_presences = $pdo->executerRequete('SELECT COUNT(`SEANCE`) FROM `appel` WHERE `ID_ELEVE` = ' . $donnees['ID_ELEVE'] . ' AND `SEANCE` > "' . $anneeChoisie . '-09-01" AND `SEANCE` < "' . ($anneeChoisie + 1) . '-07-30"');
    if ($_POST['critere_presences'] == '') {
        $_POST['critere_presences'] = '0';
    }
    $garder = true;

    // Critère des présences
    if ($critere_presences_operateur == 'moins') {
        if ($nb_presences[0] >= $critere_presences) {
            $garder = false;
        }
    }
    if ($critere_presences_operateur == 'plus') {
        if ($nb_presences[0] <= $critere_presences) {
            $garder = false;
        }
    }

    if ($critere_presences == '' || $critere_presences == '0') {
        $garder = true;
    }

    if ($garder) {

        // chaque ligne en cours de lecture est insérée dans le fichier
        // les valeurs présentes dans chaque ligne seront séparées par $delimiteur
        fputcsv($fichier_csv, array(
            utf8_encode($donnees['NOM_ELEVE']),
            utf8_encode($donnees['PRENOM']),
            utf8_encode(getNomParametre($donnees['ID_CLASSE'])),
            utf8_encode(getNomParametre($donnees['ID_FILIERES'])),
            utf8_encode(getNomParametre($donnees['ID_ETABLISSEMENT'])),
            utf8_encode($nb_presences[0]),
            utf8_encode(getNomParametre($donnees['ID_LV1'])),
            utf8_encode(getNomParametre($donnees['ID_LV2'])),
            utf8_encode($donnees['SEXE']),
            utf8_encode($donnees['DATE_DE_NAISSANCE']),
            utf8_encode('=("' . $donnees['telparents'] . '")'),
            utf8_encode($donnees['EMAIL_DES_PARENTS']),
            utf8_encode('=("' . $donnees['telenfant'] . '")'),
            utf8_encode($donnees['EMAIL_DE_L_ENFANT']),
            utf8_encode($donnees['ADRESSE_POSTALE']),
            utf8_encode($donnees['CODE_POSTAL']),
            utf8_encode($donnees['VILLE'])
        ),
            $delimiteur);

    }
}

// fermeture du fichier csv
//fclose($fichier_csv);

//header('Location: '.$chemin.'');      

?>