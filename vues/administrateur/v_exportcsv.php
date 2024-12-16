<?php
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf8');
header('Content-Disposition: attachment; filename=export_' . date('d-m-Y_H\hi', time()) . '.csv');

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
fprintf($fichier_csv, chr(0xEF) . chr(0xBB) . chr(0xBF));


// Parcours du nom des champs
foreach ($donnees as $uneEntree) {

    // Initialisation de la ligne
    $ligne = array();
    $i = 0;

    foreach (array_keys($uneEntree) as $unChamp) {

        // On saute une ligne sur deux
        if ($i % 2 == 0) {
            array_push($ligne, strtoupper(stripslashes($unChamp)));
        }

        $i++;
    }

    // On ajoute la ligne créé au fichier CSV
    fputcsv($fichier_csv, $ligne, $delimiteur);

    break;
}

// Parcours des enregistrements
foreach ($donnees as $uneEntree) {

    // Initialisation de la ligne
    $ligne = array();
    $i = 0;

    foreach ($uneEntree as $unChamp) {

        // On saute une ligne sur deux
        if ($i % 2 == 0) {
            array_push($ligne, stripslashes($unChamp));
        }

        $i++;
    }

    // On ajoute la ligne créé au fichier CSV
    fputcsv($fichier_csv, $ligne, $delimiteur);
}

// fermeture du fichier csv
fclose($fichier_csv);

//header('Location: '.$chemin.'');      
?>