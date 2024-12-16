<?php
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Eleves_Stage.csv');

// create a file pointer connected to the output stream
$fichier_csv = fopen('php://output', 'w');

// Convertit le texte utf8 de la BDD en format windows
function encode($texte)
{
    return iconv("UTF-8", "windows-1252", utf8_encode($texte));
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
fputcsv($fichier_csv, array('Date', 'Valide', 'Nom', 'Prenom', 'Sexe', 'Date de naissance', 'Etablissement', 'Classe', 'Filiere', 'Association', 'Tel Parent', 'Mail parent', 'Tel eleve', 'Mail eleve', 'Adresse', 'Code postal', 'Ville', 'IP', 'Origine', 'Système'), $delimiteur);


// Boucle foreach sur chaque ligne du tableau
foreach ($lesInscriptions as $uneLigne) {
    $classe = '';
    foreach ($lesClasses as $uneClasse) {
        if ($uneClasse['ID'] == $uneLigne['CLASSE_ELEVE_STAGE']) {
            $classe = $uneClasse['NOM'];
        }
    }

    $filiere = '';
    foreach ($lesfilieres as $uneFiliere) {
        if ($uneFiliere['ID'] == $uneLigne['FILIERE_ELEVE_STAGE']) {
            $filiere = $uneFiliere['NOM'];
        }
    }

    $etab = '';
    foreach ($lesEtablissements as $unEtab) {
        if ($unEtab['ID'] == $uneLigne['ETABLISSEMENT_ELEVE_STAGE']) {
            $etab = $unEtab['NOM'];
        }
    }

// chaque ligne en cours de lecture est insérée dans le fichier
    // les valeurs présentes dans chaque ligne seront séparées par $delimiteur

    // enlever les emails vides
    if ($uneLigne['EMAIL_PARENTS_ELEVE_STAGE'] == "a@a" or $uneLigne['EMAIL_PARENTS_ELEVE_STAGE'] == "a@a.fr" or $uneLigne['EMAIL_PARENTS_ELEVE_STAGE'] == "-") {
        $uneLigne['EMAIL_PARENTS_ELEVE_STAGE'] = '';
    }
    if ($uneLigne['EMAIL_ELEVE_ELEVE_STAGE'] == "a@a" or $uneLigne['EMAIL_ELEVE_ELEVE_STAGE'] == "a@a.fr" or $uneLigne['EMAIL_ELEVE_ELEVE_STAGE'] == "-") {
        $uneLigne['EMAIL_ELEVE_ELEVE_STAGE'] = '';
    }

    // corriger les téléphones
    $uneLigne['TELEPHONE_PARENTS_ELEVE_STAGE'] = '=("' . $uneLigne['TELEPHONE_PARENTS_ELEVE_STAGE'] . '")';
    $uneLigne['TELEPHONE_ELEVE_ELEVE_STAGE'] = '=("' . $uneLigne['TELEPHONE_ELEVE_ELEVE_STAGE'] . '")';

    fputcsv($fichier_csv, array(

        encode($uneLigne['DATE_INSCRIPTIONS']),
        encode($uneLigne['VALIDE']),
        encode(stripslashes($uneLigne['NOM_ELEVE_STAGE'])),
        encode(stripslashes($uneLigne['PRENOM_ELEVE_STAGE'])),
        encode($uneLigne['SEXE_ELEVE_STAGE']),
        encode($uneLigne['DDN_ELEVE_STAGE']),
        encode($etab),
        encode($classe),
        encode($filiere),
        encode(stripslashes($uneLigne['ASSOCIATION_ELEVE_STAGE'])),
        encode($uneLigne['TELEPHONE_PARENTS_ELEVE_STAGE']),
        encode(stripslashes($uneLigne['EMAIL_PARENTS_ELEVE_STAGE'])),
        encode($uneLigne['TELEPHONE_ELEVE_ELEVE_STAGE']),
        encode(stripslashes($uneLigne['EMAIL_ELEVE_ELEVE_STAGE'])),
        encode(stripslashes($uneLigne['ADRESSE_ELEVE_STAGE'])),
        encode($uneLigne['CP_ELEVE_STAGE']),
        encode(stripslashes($uneLigne['VILLE_ELEVE_STAGE'])),
        encode(stripslashes($uneLigne['IP_INSCRIPTIONS'])),
        encode(stripslashes($uneLigne['ORIGINE_INSCRIPTIONS'])),
        encode(stripslashes($uneLigne['USER_AGENT_INSCRIPTIONS']))),
        $delimiteur);

}

// fermeture du fichier csv
//fclose($fichier_csv);

//header('Location: '.$chemin.'');      

?>