<?php
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=windows-1252');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$fichier_csv = fopen('php://output', 'w');

function encode($texte)
{
    return iconv("UTF-8", "windows-1252", $texte);
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

//$Laligne[] = array('NOM', 'PRENOM','DATE_DE_NAISSANCE','TÉLÉPHONE_DES_PARENTS','ADRESSE_POSTALE','CODE_POSTAL','VILLE');
// chaque ligne en cours de lecture est insérée dans le fichier
// les valeurs présentes dans chaque ligne seront séparées par $delimiteur
fputcsv($fichier_csv, array('Nom', 'Prenom', 'Statut', 'Email', 'Téléphone', 'Adresse postale', 'code postal', 'Ville', 'Diplome', 'Date de naissance', 'Lieu de naissance', 'Nationalité', 'Sécurité social'), $delimiteur);


// Boucle foreach sur chaque ligne du tableau
foreach ($TousIntervenant as $uneLigne) {
    $uneLigne['TELEPHONE'] = '=("' . $uneLigne['TELEPHONE'] . '")';
    $uneLigne['SECURITE_SOCIALE'] = '=("' . $uneLigne['SECURITE_SOCIALE'] . '")';
// chaque ligne en cours de lecture est insérée dans le fichier
    // les valeurs présentes dans chaque ligne seront séparées par $delimiteur
    fputcsv($fichier_csv,
        array(
            encode($uneLigne['NOM']),
            encode($uneLigne['PRENOM']),
            encode($uneLigne['STATUT']),
            encode($uneLigne['EMAIL']),
            encode($uneLigne['TELEPHONE']),
            encode($uneLigne['ADRESSE_POSTALE']),
            encode($uneLigne['CODE_POSTAL']),
            encode($uneLigne['VILLE']),
            encode($uneLigne['DIPLOME']),
            encode($uneLigne['DATE_DE_NAISSANCE']),
            encode($uneLigne['LIEU_DE_NAISSANCE']),
            encode($uneLigne['NATIONALITE']),
            encode($uneLigne['SECURITE_SOCIALE']),
        )
        , $delimiteur);
}

// fermeture du fichier csv
//fclose($fichier_csv);

//header('Location: '.$chemin.'');

?>
