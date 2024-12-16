<?php
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$fichier_csv = fopen('php://output', 'w');


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

//$Laligne[] = array('NOM', 'PRENOM','DATE_DE_NAISSANCE','TÉLÉPHONE_DES_PARENTS','ADRESSE_POSTALE','CODE_POSTAL','VILLE');
// chaque ligne en cours de lecture est insérée dans le fichier
// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
fputcsv($fichier_csv, array('NOM', 'PRENOM', 'DATE DE NAISSANCE', utf8_decode('TÉLÉPHONE DES PARENTS'), 'ADRESSE_POSTALE', 'CODE_POSTAL', 'VILLE', 'CLASSE'), $delimiteur);


// Boucle foreach sur chaque ligne du tableau
foreach ($elevesInscritaEvenement as $uneLigne) {
    $annee = date("Y");
    $mois = date("m");
    if ($mois < 7) {
        $annee = $annee - 1;
    }
    $classe = $pdo->recupClasseUnEleve($annee, $uneLigne['ID_ELEVE']);
// chaque ligne en cours de lecture est insérée dans le fichier
    // les valeurs présentes dans chaque ligne seront séparées par $delimiteur
    fputcsv($fichier_csv, array(utf8_decode($uneLigne['NOM']), utf8_decode($uneLigne['PRENOM']), utf8_decode($uneLigne['DATE_DE_NAISSANCE']), utf8_decode($uneLigne['TÉLÉPHONE_DES_PARENTS']), utf8_decode($uneLigne['ADRESSE_POSTALE']), utf8_decode($uneLigne['CODE_POSTAL']), utf8_decode($uneLigne['VILLE']), utf8_decode($classe['NOM'])), $delimiteur);
}

// fermeture du fichier csv
//fclose($fichier_csv);

//header('Location: '.$chemin.'');      

?>