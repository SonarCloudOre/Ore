<?php
header("Cache-Control: ");
header('Content-type: application/msword');
header('Content-Disposition: attachment; filename="bilan.doc"');
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

/////// LIRE ATTENTIVEMENT : NE PAS MODIFIER LES URLS DES IMAGES EN METTANT DES CHEMINS RELATIFS CAR L'IMAGE CONTENU DANS LE FICHIER WORD CREE EST RECHERCHER EN FONCTION DE SON EMPLACEMENT ///////
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>Bilan</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">
    <style type="text/css">
        h3 {
            color: <?php echo $stageSelectionner['FOND_STAGE']; ?>;
            border-bottom: 2px solid<?php echo $stageSelectionner['FOND_STAGE']; ?>;
            font-size: 30px;
        }

        h4 {
            color: <?php echo $stageSelectionner['FOND_STAGE']; ?>;
            border-bottom: 1px solid<?php echo $stageSelectionner['FOND_STAGE']; ?>;
            font-size: 20px;
            margin-left: 20px;
        }

        body {
            font-family: arial;

        }

        #pied {
            display: none;
        }

        h2 {
            font-size: 50px;
            color: <?php echo $stageSelectionner['FOND_STAGE']; ?>;
        }

        #justify {
            text-align: justify;
        }

        #left {
            text-align: left;
        }

        #center {
            text-align: center;
        }
    </style>
</head>

<body>
<div id="contenu">
    <center>
        <?php
        $affc = $stageSelectionner['AFFICHE_STAGE'];
        $affc = imagejpeg($affc);
        if ($stageSelectionner['AFFICHE_STAGE'] == '') {
            echo '<i>Aucune affiche envoyée.</i>';
        } else {
            echo '<img src="https://association-ore.fr/extranet/images/afficheStage/' . $stageSelectionner['AFFICHE_STAGE'] . '" width="600" height="auto">';
        } ?>
        <br>
    </center>
    <br><br><br><br><br><br><br><br><br>
    <h2 style="text-align:center;"><?php echo stripslashes($stageSelectionner['NOM_STAGE']); ?><br>Bilan</h2>
    <br><br><br><br><br><br><br><br>
    <table style="margin:auto;">
        <tr>
            <?php
            foreach ($lesPartenaires as $lePartenaire) {
                echo '<td><center><img src="https://association-ore.fr/extranet/images/imagePartenaire/' . $lePartenaire['IMAGE_PARTENAIRES'] . '" width="100" height="50"><br><br>
		<b>' . $lePartenaire['NOM_PARTENAIRES'] . '</b></center></td>';
            }
            ?>
        </tr>
    </table>

    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <h3>Sommaire</h3>
    <ul style="font-size:20px;">
        <li>Description</li>
        <li>Communication</li>
        <!--<li>Structures et matériel à notre disposition</li>-->
        <li>Groupes et Cout par Effectifs et Ateliers</li>
        <li>Contenu et organisation</li>
        <ul>
            <li>Groupes</li>
            <li>Coût</li>
            <li>Intervenants</li>
            <li>Planning</li>
        </ul>
        <li>Statistiques</li>
        <li>Photos</li>
        <li>Liste des éleves</li>
    </ul>

    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <h3>Description</h3>

    <p>L'association ORE a organisé un stage de révisions pour les élèves de collège ou de lycée. <br>

        Il a eu lieu du <?php echo dateAnglaisVersFrancais($stageSelectionner['DATEDEB_STAGE']); ?>
        au <?php echo dateAnglaisVersFrancais($stageSelectionner['DATEFIN_STAGE']); ?></p>
    <p>Ce stage s'est déroulé au lieu suivant :</p>
    <p style="text-align:center;font-style:italic">
        <?php foreach ($lesLieux as $leLieu) {
            if ($leLieu['ID_LIEU'] == $stageSelectionner['ID_LIEU']) {
                echo '<b>' . $leLieu['NOM_LIEU'] . '</b><br><br>' . $leLieu['ADRESSE_LIEU'] . ' ' . $leLieu['CP_LIEU'] . ' ' . $leLieu['VILLE_LIEU'];


            }
        }
        ?>
    </p>
    <?php if ($stageSelectionner['PRIX_STAGE'] == 0) { ?>
        <p>Ce stage était entièrement <b>gratuit</b> pour les stagiaires.</p>
    <?php } else { ?>
        <p>Le coût demandé aux stagiaires était de <b><?php echo $stageSelectionner['PRIX_STAGE']; ?> €</b></p>
    <?php } ?>


    <p id="justify"><?php echo htmlspecialchars_decode(stripslashes($stageSelectionner['DESCRIPTION_STAGE'])); ?></p>

    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <h3>Communication</h3>
    <p>Affiches :
        Une affiche a été créée pour annoncer le stage :
        <?php
        if ($stageSelectionner['IMAGE_STAGE'] == '') {
            echo '<i>Aucune affiche envoyée.</i>';
        } else {
            echo '<img src="https://association-ore.fr/extranet/images/imageStage/' . $stageSelectionner['IMAGE_STAGE'] . '" width="600" height="auto">';
        } ?>
        <br>


    <p id="center"><b>Par internet :</b></p><br>
    <p id="justify">Le stage fait l’objet d’un article sur le site internet de l’association ainsi que sur sa page
        Facebook.</p>


    <p id="justify">Par e-mail :
        Les parents ou les enfants adhérents ont reçu un mail d’information détaillant le déroulement de l’inscription
        et avec un lien vers le formulaire d’inscription.

        Par téléphone :
        La totalité des familles adhérentes de ORE ont été contactées par téléphone.


    </p>

    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>


    <h3>Effectifs</h3>

    <h4>Élèves présents :</h4>
    <ul>
        <?php foreach ($lesGroupes as $leGroupe) {
            echo '<li><b>' . $leGroupe['NOM_GROUPE'] . '</b> (salle ' . $leGroupe['SALLES_GROUPE'] . ') : ' . $leGroupe['NBMAX_GROUPE'] . ' élèves maximum<br><br> </li>';
        }
        ?>
    </ul>


    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <h3>Ateliers</h3>
    <p>En dehors des demi journées consacrées au travail scolaire, les jeunes ont pu participer à des activités
        ludiques.</p>
    <?php
    $niveaux = array('collégiens', 'lycéens');
    foreach ($lesAteliers as $lAtelier) {
        if ($lAtelier['ID_STAGE'] == $num) {
            echo '<h4>' . $lAtelier['NOM_ATELIERS'] . '</h4>
		<p style="text-align:center"><img src="https://association-ore.fr/extranet/images/ateliers/' . $lAtelier['IMAGE_ATELIERS'] . '" width="600" height="auto"></p>
		<p>' . $lAtelier['DESCRIPTIF_ATELIERS'] . '</p>
		<p>Cet atelier était destiné aux ' . $niveaux[$lAtelier['NIVEAU_ATELIER']] . ' et était limité à ' . $lAtelier['NBMAX_ATELIERS'] . ' jeunes maximum.</p>';
        }
    }
    ?>

    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <h3>Intervenant·es</h3>
    <p>Les Intervenant·es ayant participé à ce stage (activités scolaires, activités ludiques, administration) sont
        :</p>
    <ul>
        <?php
        foreach ($lesIntervenants as $unIntervenant) {
            echo '<li>' . $unIntervenant['NOM_INTERVENANT'] . ' ' . $unIntervenant['PRENOM_INTERVENANT'] . '</li>';
        }
        ?>
    </ul>

    <h3>Planning</h3>
    <p style="text-align:center"><img
            src="https://association-ore.fr/extranet/images/planningStage/<?php echo $stageSelectionner['PLANNING_STAGE']; ?>"
            width="600" height="auto"></p>

    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <h3>Statistiques</h3>
    <?php
    // Par classe
    $graph_classes = $pdo->executerRequete2("SELECT CLASSE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.CLASSE_ELEVE_STAGE ");

    // Par filiere
    $graph_filieres = $pdo->executerRequete2("SELECT FILIERE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.FILIERE_ELEVE_STAGE ");

    // Par sexe
    $graph_sexes = $pdo->executerRequete2("SELECT SEXE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.SEXE_ELEVE_STAGE ");

    // Par établissement
    $graph_etab = $pdo->executerRequete2("SELECT ETABLISSEMENT_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE ");

    // Par ville
    $graph_villes = $pdo->executerRequete2("SELECT VILLE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.VILLE_ELEVE_STAGE");

    // Par association
    $graph_assoc = $pdo->executerRequete2("SELECT ASSOCIATION_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ASSOCIATION_ELEVE_STAGE");


    // On sélectionne les trois premières villes  du stage
    $premieresVilles = $pdo->executerRequete2("SELECT VILLE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.VILLE_ELEVE_STAGE ORDER BY COUNT(*) DESC LIMIT 3");

    //On sélectionne les dernières villes du stage
    $dernieresVilles = $pdo->executerRequete2("SELECT VILLE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.VILLE_ELEVE_STAGE ORDER BY COUNT(*) DESC LIMIT 3, 100");


    //On sélectionne les 4 premiers établissement du stage
    $premiersEtablissements = $pdo->executerRequete2("SELECT ETABLISSEMENT_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE ORDER BY COUNT(*) DESC LIMIT 4 ");


    //On sélectionne les dernièrs établissement du stage
    $dernieresEtablissements = $pdo->executerRequete2("SELECT COUNT(*) as total FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE ORDER BY COUNT(*) DESC LIMIT 4, 100");


    // On ajoute les autres établissements aux 4 premiers établissements
    foreach ($dernieresEtablissements as $leDernierE) {
        $nbAutresEtablissements += $leDernierE[0];
    }
    array_push($premiersEtablissements, array('ETABLISSEMENT_ELEVE_STAGE' => '', 'COUNT(*)' => $nbAutresEtablissements));


    // On sélectionne les villes de la métropole du stage
    $villesMetropole = $pdo->executerRequete2("SELECT DISTINCT COMMUNE AS METROPOLE FROM `villes` where commune like 'AHUY' or commune like 'BRESSEY SUR TILLE' or commune like 'BRETENIERE' or commune like 'CHENOVE' or commune like 'CHEVIGNY ST SAUVEUR' or commune like 'CORCELLES LES MONTS' or commune like 'DAIX' or commune like 'DIJON' or commune like 'FENAY' or commune like 'FLAVIGNEROT' or commune like 'FONTAINE LES DIJON' or commune like 'HAUTEVILLE LES DIJON' or commune like 'LONGVIC' or commune like 'MAGNY SUR TILLE' or commune like 'MARSANNAY LA COTE' or commune like 'NEUILLY CRIMOLOIS' or commune like 'OUGES' or commune like 'PERRIGNY LES DIJON' or commune like 'PLOMBIERES LES DIJON' or commune like 'QUETIGNY' or commune like 'ST APOLLINAIRE' or commune like 'SENNECEY LES DIJON' or commune like 'TALANT' ORDER BY `villes`.`COMMUNE` ASC ");

    // On sélectionne les villes qui ne sont pas dans la métropole du stage
    $villesHorsMetropole = $pdo->executerRequete2("SELECT DISTINCT COMMUNE AS HORSMETROPOLE FROM `villes` where commune NOT LIKE 'AHUY' or commune NOT LIKE 'BRESSEY SUR TILLE' or commune NOT LIKE 'BRETENIERE' or commune NOT LIKE 'CHENOVE' or commune NOT LIKE 'CHEVIGNY ST SAUVEUR' or commune NOT LIKE 'CORCELLES LES MONTS' or commune NOT LIKE 'DAIX' or commune NOT LIKE 'DIJON' or commune NOT LIKE 'FENAY' or commune NOT LIKE 'FLAVIGNEROT' or commune NOT LIKE 'FONTAINE LES DIJON' or commune NOT LIKE 'HAUTEVILLE LES DIJON' or commune NOT LIKE 'LONGVIC' or commune NOT LIKE 'MAGNY SUR TILLE' or commune NOT LIKE 'MARSANNAY LA COTE' or commune NOT LIKE 'NEUILLY CRIMOLOIS' or commune NOT LIKE 'OUGES' or commune NOT LIKE 'PERRIGNY LES DIJON' or commune NOT LIKE 'PLOMBIERES LES DIJON' or commune NOT LIKE 'QUETIGNY' or commune NOT LIKE 'ST APOLLINAIRE' or commune NOT LIKE 'SENNECEY LES DIJON' or commune NOT LIKE 'TALANT' ORDER BY `villes`.`COMMUNE` ASC ");


    // On récupère les 4 premières villes + les villes de la métropole + les villes hors métropole
    $nbvilleMetropole = 0;

    foreach ($graph_villes as $key) {
        $nbVilles += $key['COUNT(*)'];
    }

    foreach ($villesMetropole as $metropole) {
        foreach ($premieresVilles as $firstville) {
            if ($firstville['VILLE_ELEVE_STAGE'] == $metropole['METROPOLE']) {
                $nbvilleMetropole += $firstville['COUNT(*)'];
            }
        }
    }

    foreach ($villesMetropole as $metropole) {
        foreach ($dernieresVilles as $lastville) {
            if ($lastville['VILLE_ELEVE_STAGE'] == $metropole['METROPOLE']) {
                $nbvilleMetropole += $lastville['COUNT(*)'];
            }
        }
    }

    $nbvilleHorsMetropole = $nbVilles - $nbvilleMetropole;
    $villesStage = $premieresVilles;
    array_push($villesStage, array('VILLE_ELEVE_STAGE' => 'Metropole', 'COUNT(*)' => $nbvilleMetropole));
    array_push($villesStage, array('VILLE_ELEVE_STAGE' => 'Hors Metropole', 'COUNT(*)' => $nbvilleHorsMetropole));


    ?>

    <h4>Répartition par classe</h4>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=FF00FF,0000FF,FF0000,00FF00,00FFFF,FFFF00,F0F0F0,0F0F0F,FFF000,000FFF&chdl=<?
             $i = 0;
             foreach ($graph_classes as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 $nom = '';
                 foreach ($lesClasses as $uneClasse2) {
                     if ($uneClasse2['ID'] == $uneClasse['CLASSE_ELEVE_STAGE']) {
                         $nom = $uneClasse2['NOM'];
                     }
                 }
                 if ($nom == '') {
                     $nom = 'Vide';
                 }
                 echo $nom . ' (' . $uneClasse['COUNT(*)'] . ')';
                 $i++;
             }
             ?>&chd=t:<?php
             $i = 0;
             foreach ($graph_classes as $uneClasse) {
                 if ($i > 0) {
                     echo ',';
                 }
                 echo $uneClasse['COUNT(*)'];
                 $i++;
             }

             echo '&chl=';

             $i = 0;
             foreach ($graph_classes as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 $nom = '';
                 foreach ($lesClasses as $uneClasse2) {
                     if ($uneClasse2['ID'] == $uneClasse['CLASSE_ELEVE_STAGE']) {
                         $nom = $uneClasse2['NOM'];
                     }
                 }
                 if ($nom == '') {
                     $nom = 'Vide';
                 }
                 //echo $nom.' ('. $uneClasse['COUNT(*)'].')';
                 $i++;
             } ?>&chdlp=t">
    </p>

    <h4>Répartition par filière</h4>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=FF00FF,0000FF,FF0000,00FF00,00FFFF,FFFF00,F0F0F0,0F0F0F,FFF000,000FFF&chdl=<?
             $i = 0;
             foreach ($graph_filieres as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 $nom = '';
                 foreach ($lesfilieres as $uneClasse2) {
                     if ($uneClasse2['ID'] == $uneClasse['FILIERE_ELEVE_STAGE']) {
                         $nom = $uneClasse2['NOM'];
                     }
                 }
                 if ($nom == '') {
                     $nom = 'Vide';
                 }
                 echo $nom . ' (' . $uneClasse['COUNT(*)'] . ')';
                 $i++;
             }
             ?>&chd=t:<?php
             $i = 0;
             foreach ($graph_filieres as $uneClasse) {
                 if ($i > 0) {
                     echo ',';
                 }
                 echo $uneClasse['COUNT(*)'];
                 $i++;
             }

             echo '&chl=';

             $i = 0;
             foreach ($graph_filieres as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 $nom = '';
                 foreach ($lesfilieres as $uneClasse2) {
                     if ($uneClasse2['ID'] == $uneClasse['FILIERE_ELEVE_STAGE']) {
                         $nom = $uneClasse2['NOM'];
                     }
                 }
                 if ($nom == '') {
                     $nom = 'Vide';
                 }
                 //echo $nom.' ('. $uneClasse['COUNT(*)'].')';
                 $i++;
             } ?>&chdlp=t">
    </p>

    <h4>Répartition par sexe</h4>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=000000,0000FF,FF00FF,&chdl=<?
             $i = 0;
             foreach ($graph_sexes as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 if ($uneClasse['SEXE_ELEVE_STAGE'] == '') {
                     $uneClasse['SEXE_ELEVE_STAGE'] = 'Vide';
                 }
                 echo $uneClasse['SEXE_ELEVE_STAGE'] . ' (' . $uneClasse['COUNT(*)'] . ')';
                 $i++;
             }
             ?>&chd=t:<?php
             $i = 0;
             foreach ($graph_sexes as $uneClasse) {
                 if ($i > 0) {
                     echo ',';
                 }
                 echo $uneClasse['COUNT(*)'];
                 $i++;
             }

             echo '&chl=';

             $i = 0;
             foreach ($graph_sexes as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 if ($uneClasse['SEXE_ELEVE_STAGE'] == '') {
                     $uneClasse['SEXE_ELEVE_STAGE'] = 'Vide';
                 }
                 //echo $uneClasse['SEXE_ELEVE_STAGE'].' ('. $uneClasse['COUNT(*)'].')';
                 $i++;
             } ?>&chdlp=t">
    </p>

    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <h4>Répartition par association</h4>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=FF00FF,0000FF,FF0000,00FF00,00FFFF,FFFF00,F0F0F0,0F0F0F,FFF000,000FFF&chdl=<?
             $i = 0;
             foreach ($graph_assoc as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 echo $uneClasse['ASSOCIATION_ELEVE_STAGE'] . ' (' . $uneClasse['COUNT(*)'] . ')';
                 $i++;
             }
             ?>&chd=t:<?php
             $i = 0;
             foreach ($graph_assoc as $uneClasse) {
                 if ($i > 0) {
                     echo ',';
                 }
                 echo $uneClasse['COUNT(*)'];
                 $i++;
             }

             echo '&chl=';

             $i = 0;
             foreach ($graph_assoc as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 //echo $uneClasse['ASSOCIATION_ELEVE_STAGE'] .' ('. $uneClasse['COUNT(*)'].')';
                 $i++;
             } ?>&chdlp=t">
    </p>

    <h4>Répartition par établissement</h4>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=00FFFF,FFFF00,F0F0F0,0F0F0F,FFF000,000FFF,FF00FF,0000FF,FF0000,00FF00&chdl=<?
             $i = 0;
             foreach ($premiersEtablissements as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 $nom = '';
                 foreach ($lesEtablissements as $uneClasse2) {
                     if ($uneClasse2['ID'] == $uneClasse['ETABLISSEMENT_ELEVE_STAGE']) {
                         $nom = $uneClasse2['NOM'];
                     }
                 }
                 if ($nom == '' || $nom == '0' || $nom == null) {
                     $nom = 'Autres';
                 }
                 echo $nom . ' (' . $uneClasse['COUNT(*)'] . ')';
                 $i++;
             }
             ?>&chd=t:<?php
             $i = 0;
             foreach ($premiersEtablissements as $uneClasse) {
                 if ($i > 0) {
                     echo ',';
                 }
                 echo $uneClasse['COUNT(*)'];
                 $i++;
             }

             echo '&chl=';

             $i = 0;
             foreach ($premiersEtablissements as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 $nom = '';
                 foreach ($lesEtablissements as $uneClasse2) {
                     if ($uneClasse2['ID'] == $uneClasse['ETABLISSEMENT_ELEVE_STAGE']) {
                         $nom = $uneClasse2['NOM'];
                     }
                 }
                 if ($nom == '' || $nom == '0' || $nom == null) {
                     $nom = 'Autres';
                 }
                 //echo $nom.' ('. $uneClasse['COUNT(*)'].')';
                 $i++;
             } ?>&chdlp=t">
    </p>


    <h4>Répartition par ville</h4>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=FF00FF,00FFFF,FFFF00,F0F0F0,0F0F0F,0000FF,FF0000,00FF00,FFF000,000FFF&chdl=<?
             $i = 0;
             foreach ($villesStage as $uneClasse) {
                 if ($i > 0) {
                     echo '|';
                 }
                 if ($uneClasse['VILLE_ELEVE_STAGE'] == '') {
                     $uneClasse['VILLE_ELEVE_STAGE'] = 'Vide';
                 }
                 if ($uneClasse['VILLE_ELEVE_STAGE'] == 'Metropole') {
                     $uneClasse['VILLE_ELEVE_STAGE'] = 'Metropole';
                 }
                 if ($uneClasse['VILLE_ELEVE_STAGE'] == 'Hors Metropole') {
                     $uneClasse['VILLE_ELEVE_STAGE'] = 'Hors Metropole';
                 }
                 echo $uneClasse['VILLE_ELEVE_STAGE'] . ' (' . $uneClasse['COUNT(*)'] . ')';
                 $i++;
             }
             ?>&chd=t:<?php
             $i = 0;
             foreach ($villesStage as $uneClasse) {
                 if ($i > 0) {
                     echo ',';
                 }
                 echo $uneClasse['COUNT(*)'];
                 $i++;
             }


             ?>&chdlp=t">
    </p>

    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <h3>Photos</h3>

    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <h3>Liste des élèves</h3>

    <table style="border:1px solid black;border-collapse:collapse; width:600px">
        <tr>
            <th style="border:1px solid black;border-collapse:collapse;padding:5px"><b>Nom</b></th>
            <th style="border:1px solid black;border-collapse:collapse;padding:5px">Prénom</th>
            <th style="border:1px solid black;border-collapse:collapse;padding:5px">Classe</th>
            <th style="border:1px solid black;border-collapse:collapse;padding:5px">Date de naissance</th>
        </tr>
        <?php
        foreach ($lesInscriptions as $lInscription) {
            $classe = '';
            foreach ($lesClasses as $uneClasse) {
                if ($uneClasse['ID'] == $lInscription['CLASSE_ELEVE_STAGE']) {
                    $classe = $uneClasse['NOM'];
                }
            }
            echo '<tr>
		<td style="border:1px solid black;border-collapse:collapse;padding:5px">' . $lInscription['NOM_ELEVE_STAGE'] . '</td>
		<td style="border:1px solid black;border-collapse:collapse;padding:5px">' . $lInscription['PRENOM_ELEVE_STAGE'] . '</td>
		<td style="border:1px solid black;border-collapse:collapse;padding:5px">' . $classe . '</td>
    <td style="border:1px solid black;border-collapse:collapse">' . dateAnglaisVersFrancais($lInscription['DDN_ELEVE_STAGE']) . '</td>
    </tr>
    </tr>';
        }
        ?>
    </table>

</div>
</body>
</html>
