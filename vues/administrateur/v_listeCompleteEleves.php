<?php
    //En-tête pour télécharger le fichier et non l'afficher
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Liste_Eleves_complet.csv');
    echo "\xEF\xBB\xBF"; //indique que le fichier est en UTF-8
    // create a file pointer connected to the output stream
    $fichier_csv = fopen('php://output', 'w');
    $footerANePasAfficher = 1;
    //Délimiter l'affichage des données
    $delimiteur = ';';
    // les valeurs présentes dans chaque ligne seront séparées par $delimiteur
    fputcsv($fichier_csv, array('Nom', ('Prénom'), 'Sexe', 'Date de naissance', ('Responsable légal'), ('Prévenir en cas d\'abscence'), ('Profession du père'), ('Profession de la mère'), 'Adresse postal', 'Code postal', 'Ville', 'Tel parents', 'Tel Parents 2', 'Tel Parents 3', 'Tel eleve', 'Mail parent', 'Mail eleve', 'contact parents', 'CAF', 'Etablissement', 'Classe', 'Specialite 1', 'Specialite 2', ('Filière')), $delimiteur);
    
    // create a file pointer connected to the output stream
$footerANePasAfficher = 1;

$elevesEcrits = [];

    // Boucle foreach sur chaque ligne du tableau
    foreach ($TousEleves as $uneLigne) { 
   //identifiant unique pour tester la présence de doublon
    $cleUnique = strtolower($uneLigne['NOM']) . strtolower($uneLigne['PRENOM']) . $uneLigne['DATE_DE_NAISSANCE'];

    //Informations supplémentaires
    $annee = date("Y");
    $mois = date("m");
    if ($mois < 7) {
        $annee = $annee - 1;
    }
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
                array_push($specialite2, $uneLignE1['NOM']);
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
    //si les informations ne sont pas présents dans le tableau
    if (!isset($elevesEcrits[$cleUnique])) {
    fputcsv(
        $fichier_csv,
        array(
            strtoupper(($uneLigne['NOM'])),
            strtolower($uneLigne['PRENOM']),
            ($uneLigne['SEXE']),
            ($uneLigne['DATE_DE_NAISSANCE']),
            ($uneLigne['RESPONSABLE_LEGAL']),
            ($uneLigne['PRÉVENIR_EN_CAS_D_ABSENCE']),
            ($uneLigne['PROFESSION_DU_PÈRE']),
            ($uneLigne['PROFESSION_DE_LA_MÈRE']),
            strtoupper(($uneLigne['ADRESSE_POSTALE'])),
            ($uneLigne['CODE_POSTAL']),
            strtoupper(($uneLigne['VILLE'])),
            ($uneLigne['TÉLÉPHONE_DES_PARENTS']),
            ($uneLigne['TÉLÉPHONE_DES_PARENTS2']),
            ($uneLigne['TÉLÉPHONE_DES_PARENTS3']),
            ($uneLigne['TÉLÉPHONE_DE_L_ENFANT']),
            ($uneLigne['EMAIL_DES_PARENTS']),
            ($uneLigne['EMAIL_DE_L_ENFANT']),
            ($uneLigne['CONTACT_AVEC_LES_PARENTS']),
            ($uneLigne['ASSURANCE_PÉRISCOLAIRE']),
            ($etablissement),
            ($classe),
            ($specialite),
            ($Specialite2),
            ($filiere)
            
        ),
        $delimiteur);
        $elevesEcrits[$cleUnique] = true;
    }
    }
    fputcsv($fichier_csv, array('---------- Début des élèves présents en stage uniquement ----------'), $delimiteur);
    // Récupérer tout les élèves de stage
    $elevesStages = $pdo->getElevesAllStage();
    $SansDonnees ="Données non renseignées";  //Donnée non présente dans la table des participants aux
    foreach ($elevesStages as $eleve) {
        $etablissement = '';
        foreach ($lesEtablissements as $unEtablissement) {
            if ($unEtablissement['ID'] == $eleve['ETABLISSEMENT_ELEVE_STAGE']) {
                $etablissement = $unEtablissement['NOM'];
            }
        }
        $classe = '';
        foreach ($lesClasses as $uneClasse) {
            if ($uneClasse['ID'] == $eleve['CLASSE_ELEVE_STAGE']) {
                $classe = $uneClasse['NOM'];
            }
        }
        $classe = str_replace('Ã', 'ème', $classe);

        $filiere = '';
        foreach ($lesfilieres as $uneFiliere) {
            if ($uneFiliere['ID'] == $eleve['FILIERE_ELEVE_STAGE']) {
                $filiere = $uneFiliere['NOM'];
            }
        } 
        // corriger les téléphones
    $uneLigne['TÉLÉPHONE_DES_PARENTS'] = '=("' . $eleve['TELEPHONE_PARENTS_ELEVE_STAGE'] . '")';
    $uneLigne['TÉLÉPHONE_DE_L_ENFANT'] = '=("' . $eleve['TELEPHONE_ELEVE_ELEVE_STAGE'] . '")'; 

        $cleUnique = strtolower($eleve['NOM_ELEVE_STAGE']).strtolower($eleve['PRENOM_ELEVE_STAGE']).$eleve['DDN_ELEVE_STAGE'];
        //si les informations ne sont pas présents dans le tableau
        if (!isset($elevesEcrits[$cleUnique])) {
        $donneesEleveStage = array(
            strtoupper(($eleve['NOM_ELEVE_STAGE'])),
                ucfirst(strtolower(mb_convert_encoding($eleve['PRENOM_ELEVE_STAGE'],'UTF-8'))),
                ($eleve['SEXE_ELEVE_STAGE']),
                ($eleve['DDN_ELEVE_STAGE']),
                $SansDonnees,
                $SansDonnees, 
                $SansDonnees,
                $SansDonnees,
                (($eleve['ADRESSE_ELEVE_STAGE'])),
                ($eleve['CP_ELEVE_STAGE']),
                (($eleve['VILLE_ELEVE_STAGE'])),
                ($eleve['TELEPHONE_PARENTS_ELEVE_STAGE']),
                $SansDonnees,
                $SansDonnees,
                ($eleve['TELEPHONE_ELEVE_ELEVE_STAGE']),
                ($eleve['EMAIL_PARENTS_ELEVE_STAGE']),
                ($eleve['EMAIL_ENFANT_ELEVE_STAGE']),
                $SansDonnees,
                $SansDonnees,
                $etablissement,
                
                $SansDonnees,
                $SansDonnees,
               
        );
        $elevesEcrits[$cleUnique] = true;
        fputcsv($fichier_csv, $donneesEleveStage, $delimiteur);
    }
    }
?>