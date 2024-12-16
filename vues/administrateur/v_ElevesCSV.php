<?php
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=ISO-8859-1');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$fichier_csv = fopen('php://output', 'w');

// Convertit le texte utf8 de la BDD en format windows
/*function utf8_decode($texte) {
	return iconv("UTF-8", "windows-1252", utf8_utf8_decode($texte));
}*/

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
fputcsv($fichier_csv, array('Nom', utf8_decode('Prénom'), 'Sexe', 'Date de naissance', utf8_decode('Responsable légal'), utf8_decode('Prévenir en cas d\'abscence'), utf8_decode('Profession du père'), utf8_decode('Profession de la mère'), 'Adresse postal', 'Code postal', 'Ville', 'Tel parents', 'Tel Parents 2', 'Tel Parents 3', 'Tel eleve', 'Mail parent', 'Mail eleve', 'contact parents', 'CAF', 'Etablissement', 'Classe', 'Specialite 1', 'Specialite 2', utf8_decode('Filière')), $delimiteur);


// Boucle foreach sur chaque ligne du tableau
foreach ($TousEleves as $uneLigne) {
    $annee = date("Y");
    $mois = date("m");
    if ($mois < 7) {
        $annee = $annee - 1;
    }
    /*$classe=$pdo->recupClasseUnEleve($annee,$uneLigne['ID_ELEVE']);
    $filiere=$pdo->recupFiliereUnEleve($annee,$uneLigne['ID_ELEVE']);*/

    $classe = '';
    foreach ($lesClasses as $uneClasse) {
        if ($uneClasse['ID'] == $uneLigne['ID_CLASSE']) {
            $classe = $uneClasse['NOM'];
        }
    }
    $classe = str_replace('Ã', 'ème', $classe);

    $filiere = '';
    foreach ($lesfilieres as $uneFiliere) {
        if ($uneFiliere['ID'] == $uneLigne['ID_FILIERES']) {
            $filiere = $uneFiliere['NOM'];
        }
    }
    //$classe = str_replace('Ã','ème',$classe);
    if ($filiere == 'Aucune') {
        $filiere = '';
    }

    $specialite = '';

    $num = $uneLigne['ID_ELEVE'];

    $lesSpecialitesEleves = $pdo->getSpecialitesEleve($num, $annee);

    foreach ($lesSpecialites as $uneLigne1) {

        $checked = " ";

        foreach ($lesSpecialitesEleves as $uneLigne2) {
            if ($uneLigne1['ID'] == $uneLigne2['ID']) {
                $specialite = "" . $uneLigne1['NOM'] . "<br>";
            }
        }


    }


    $specialite2 = [];
    foreach ($lesSpecialitesEleves as $uneLigne2) {
        foreach ($lesSpecialites2 as $uneLignE1) {

            if ($uneLignE1['ID'] == $uneLigne2['ID']) {
                // /$specialite2 = $specialite2 . $uneLignE1['NOM'];
                array_push($specialite2, $uneLignE1['NOM']);
                //echo '<p style="color:red;">'.$specialite2[0].'</p><br>';

            }
        }
    }

    if ($specialite2 != NULL) {
        $specialite = $specialite2[0];
        $Specialite2 = $specialite2[1];
    } else {
        $specialite = $specialite;
        $Specialite2 = "";
    }


    //$classe = str_replace('Ã','ème',$classe);
    //if($specialite == 'Aucune') { $specialite = ''; }


// chaque ligne en cours de lecture est insérée dans le fichier
    // les valeurs présentes dans chaque ligne seront séparées par $delimiteur

    // enlever les emails vides
    if ($uneLigne['EMAIL_DES_PARENTS'] == "a@a" or $uneLigne['EMAIL_DES_PARENTS'] == "a@a.fr" or $uneLigne['EMAIL_DES_PARENTS'] == "-") {
        $uneLigne['EMAIL_DES_PARENTS'] = '';
    }
    if ($uneLigne['EMAIL_DE_L_ENFANT'] == "a@a" or $uneLigne['EMAIL_DE_L_ENFANT'] == "a@a.fr" or $uneLigne['EMAIL_DE_L_ENFANT'] == "-") {
        $uneLigne['EMAIL_DE_L_ENFANT'] = '';
    }

    // corriger les téléphones
    $uneLigne['TÉLÉPHONE_DES_PARENTS'] = '=("' . $uneLigne['TÉLÉPHONE_DES_PARENTS'] . '")';
    $uneLigne['TÉLÉPHONE_DE_L_ENFANT'] = '=("' . $uneLigne['TÉLÉPHONE_DE_L_ENFANT'] . '")';


    $etablissement = '';
    foreach ($lesEtablissements as $unEtablissement) {
        if ($unEtablissement['ID'] == $uneLigne['ID']) {
            $etablissement = $unEtablissement['NOM'];
        }
    }

    $sexe = $uneLigne['SEXE'];


    fputcsv(
        $fichier_csv,
        array(
            strtoupper(utf8_decode($uneLigne['NOM'])),
            ucfirst(strtolower(utf8_decode($uneLigne['PRENOM']))),
            utf8_decode($sexe),
            utf8_decode($uneLigne['DATE_DE_NAISSANCE']),
            utf8_decode($uneLigne['RESPONSABLE_LEGAL']),
            utf8_decode($uneLigne['PRÉVENIR_EN_CAS_D_ABSENCE']),
            utf8_decode($uneLigne['PROFESSION_DU_PÈRE']),
            utf8_decode($uneLigne['PROFESSION_DE_LA_MÈRE']),
            strtoupper(utf8_decode($uneLigne['ADRESSE_POSTALE'])),
            utf8_decode($uneLigne['CODE_POSTAL']),
            strtoupper(utf8_decode($uneLigne['VILLE'])),
            utf8_decode($uneLigne['TÉLÉPHONE_DES_PARENTS']),
            utf8_decode($uneLigne['TÉLÉPHONE_DES_PARENTS2']),
            utf8_decode($uneLigne['TÉLÉPHONE_DES_PARENTS3']),
            utf8_decode($uneLigne['TÉLÉPHONE_DE_L_ENFANT']),
            utf8_decode($uneLigne['EMAIL_DES_PARENTS']),
            utf8_decode($uneLigne['EMAIL_DE_L_ENFANT']),
            utf8_decode($uneLigne['CONTACT_AVEC_LES_PARENTS']),
            utf8_decode($uneLigne['ASSURANCE_PÉRISCOLAIRE']),
            utf8_decode($etablissement),
            utf8_decode($classe),
            utf8_decode($specialite),
            utf8_decode($Specialite2),
            utf8_decode($filiere)
            
        ),
        $delimiteur);

}

// fermeture du fichier csv
//fclose($fichier_csv);

//header('Location: '.$chemin.'');

?>
