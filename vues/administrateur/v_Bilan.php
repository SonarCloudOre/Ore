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
    <!-- On affiche le titre du document -->
    <center>
        <br>
    </center>
    <br><br><br><br><br><br><br><br><br>
    <h2 id="center"><?php echo stripslashes($stageSelectionner['NOM_STAGE']); ?><br><br>Bilan</h2>
    <br><br><br><br><br><br><br><br>

    <!-- On affiche le logo et le nom des partenaires -->
    <table style="margin:auto;">
        <tr>
            <?php
            foreach ($lesPartenaires as $lePartenaire) { 
                $route = 'https://association-ore.fr/extranet/images/imagePartenaire/' . $lePartenaire['IMAGE_PARTENAIRES'];
                echo '<td><center><img src="'.$route.'" width="180" height="120"><br><br>
                <b>' . $lePartenaire['NOM_PARTENAIRES'] . '</b></center></td>';
            }
            ?>
        </tr>
    </table>

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>

    <!-- On affiche le sommaire -->
    <h3>Sommaire</h3>
    <ul style="font-size:20px;">
        <li>Description</li>
        <li>Communication</li>
        <li>Effectifs des groupes</li>
        <li>Ateliers</li>
        <li>Listes des intervenantes et intervenants</li>
        <li>Planning</li>
        <li>Statistiques</li>
        <li>Photos</li>
        <li>Liste des élèves</li>
    </ul>

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>
    <br><br><br><br><br><br><br><br><br><br><br><br><br>

    <!-- Partie description -->
    <h3>Description</h3>

    <p>
        L'association ORE a organisé un stage de révisions pour les élèves de collège ou de lycée. <br>

        Il a eu lieu du <?php echo dateAnglaisVersFrancais($stageSelectionner['DATEDEB_STAGE']); ?>
        au <?php echo dateAnglaisVersFrancais($stageSelectionner['DATEFIN_STAGE']); ?>, 
        <b><i><?php foreach ($lesLieux as $leLieu) {
            if ($leLieu['ID_LIEU'] == $stageSelectionner['ID_LIEU']) {
                echo $leLieu['NOM_LIEU'];
            }
        }
        ?></b></i>
    </p>
    <p style="text-align:center"><i>
        <?php foreach ($lesLieux as $leLieu) {
            if ($leLieu['ID_LIEU'] == $stageSelectionner['ID_LIEU']) {
                echo $leLieu['ADRESSE_LIEU'] . ' ' . $leLieu['CP_LIEU'] . ' ' . $leLieu['VILLE_LIEU'];


            }
        }
        ?>
    </p></i>

    <?php if ($stageSelectionner['PRIX_STAGE'] == 0) { ?>
        <p>Ce stage était entièrement <b>gratuit</b> pour les stagiaires.</p>
    <?php } else { ?>
        <p>Le coût demandé aux stagiaires était de <b><?php echo $stageSelectionner['PRIX_STAGE']; ?> €</b></p>
    <?php } ?>

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <!-- Partie communication -->
    <h3>Communication</h3>
    <p><b>Affiches :</b>
        Une affiche a été créée pour annoncer le stage :
        <?php
        if ($stageSelectionner['AFFICHE_STAGE'] == '') {
            echo '<i>Aucune affiche envoyée.</i>';
        } else {
            echo '<img src="https://association-ore.fr/extranet/images/afficheStage/' . $stageSelectionner['AFFICHE_STAGE'] .'" width="550" height="850">';
        } ?>
        <br>


    <p>
        <b>Par internet :</b>
        Le stage fait l’objet d’un article sur le site internet de l’association ainsi que sur sa page
        Facebook.
    </p>

    <p><b>Par e-mail : </b>
        Les parents ou les enfants adhérents ont reçu un mail d’information détaillant le déroulement de l’inscription, 
        avec un lien vers le formulaire d’inscription.
    </p>

    <p><b>Par téléphone : </b>
        La totalité des familles adhérentes de ORE ont été contactées par téléphone.
    </p>

    <br><br><br>

    <!-- Partie effectifs des groupes -->
    <h3>Effectifs</h3>

    <h4>Élèves présents :</h4>
    <ul>
        <?php foreach ($lesGroupes as $leGroupe) {
            echo '<li><b>' . $leGroupe['NOM_GROUPE'] . '</b><br><br></li>';
        }
        ?>
    </ul>

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <!-- Partie ateliers -->
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

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <!-- Partie liste des intervenants -->
    <h3>Intervenant·es</h3>
    <p>Les intervenant·es ayant participé à ce stage (activités scolaires, activités ludiques, administration) sont
        :</p>
    <ul>
        <?php
        foreach ($lesIntervenants as $unIntervenant) {
            echo '<li>' . $unIntervenant['PRENOM_INTERVENANT'] . ' ' . $unIntervenant['NOM_INTERVENANT'] . '</li>';
        }
        ?>
    </ul>

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <!-- Partie planning -->
    <h3>Planning</h3>
    <p style="text-align:center"><img
            src="https://association-ore.fr/extranet/images/planningStage/<?php echo $stageSelectionner['PLANNING_STAGE']; ?>"
            width="600" height="auto"></p>

    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <!-- Partie statistiques -->
    <h3>Statistiques</h3>
    <br><br>
    <?php
    // Par classe
    $graph_classes = $pdo->executerRequete2("SELECT CLASSE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.CLASSE_ELEVE_STAGE order by ID_GROUPE");

    // Par sexe
    $graph_sexes = $pdo->executerRequete2("SELECT SEXE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.SEXE_ELEVE_STAGE ");

    // Par établissement
    $graph_etab = $pdo->executerRequete2("SELECT ETABLISSEMENT_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE ");

    // Par ville
    $graph_villes = $pdo->executerRequete2("SELECT VILLE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.VILLE_ELEVE_STAGE");


    // On sélectionne les trois premières villes du stage
    $premieresVilles = $pdo->executerRequete2("SELECT VILLE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.VILLE_ELEVE_STAGE ORDER BY COUNT(*) DESC LIMIT 3");

    //On sélectionne les dernières villes du stage
    $dernieresVilles = $pdo->executerRequete2("SELECT VILLE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.VILLE_ELEVE_STAGE ORDER BY COUNT(*) DESC LIMIT 3, 100");


    //On sélectionne les 4 premiers établissement du stage
    $premiersEtablissements = $pdo->executerRequete2("SELECT ETABLISSEMENT_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND ETABLISSEMENT_ELEVE_STAGE != 10 GROUP BY ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE ORDER BY COUNT(*) DESC LIMIT 3 ");


    $premiersEtablissementsID = array();
    $i = 0;
    foreach ($premiersEtablissements as $unEtablissement) {
        $premiersEtablissementsID[$i] = $unEtablissement['ETABLISSEMENT_ELEVE_STAGE'];
        $i += 1;

    }
    $premiersEtablissementsID_0 = $premiersEtablissementsID[0];
    $premiersEtablissementsID_1 = $premiersEtablissementsID[1];
    $premiersEtablissementsID_2 = $premiersEtablissementsID[2];


    //On sélectionne les dernièrs établissement du stage
    $dernieresEtablissements = $pdo->executerRequete2("SELECT ETABLISSEMENT_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND ETABLISSEMENT_ELEVE_STAGE != $premiersEtablissementsID_0 AND ETABLISSEMENT_ELEVE_STAGE != $premiersEtablissementsID_1 AND ETABLISSEMENT_ELEVE_STAGE != $premiersEtablissementsID_2 OR (INSCRIPTIONS_STAGE.ID_STAGE = " . $num . " AND ETABLISSEMENT_ELEVE_STAGE IS NULL) GROUP BY ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE ORDER BY COUNT(*) DESC;");

    $derniersEtablissementsID = array();
    $i = 0;
    foreach ($dernieresEtablissements as $unEtablissement) {
        $derniersEtablissementsID[$i] = $unEtablissement['ETABLISSEMENT_ELEVE_STAGE'];
        $i += 1;

    }

    $nbAutresEtablissements = 0;
    // On ajoute les autres établissements aux 3 premiers établissements
    foreach ($dernieresEtablissements as $leDernierE) {
        $nbAutresEtablissements += $leDernierE['COUNT(*)'];
    }
    array_push($premiersEtablissements, array('ETABLISSEMENT_ELEVE_STAGE' => '', 'COUNT(*)' => $nbAutresEtablissements));


    // On sélectionne les villes de la métropole du stage
    $villesMetropole = $pdo->executerRequete2("SELECT DISTINCT COMMUNE AS METROPOLE FROM `villes` where commune like 'AHUY' or commune like 'BRESSEY SUR TILLE' or commune like 'BRETENIERE' or commune like 'CHENOVE' or commune like 'CHEVIGNY ST SAUVEUR' or commune like 'CORCELLES LES MONTS' or commune like 'DAIX' or commune like 'DIJON' or commune like 'FENAY' or commune like 'FLAVIGNEROT' or commune like 'FONTAINE LES DIJON' or commune like 'HAUTEVILLE LES DIJON' or commune like 'LONGVIC' or commune like 'MAGNY SUR TILLE' or commune like 'MARSANNAY LA COTE' or commune like 'NEUILLY CRIMOLOIS' or commune like 'OUGES' or commune like 'PERRIGNY LES DIJON' or commune like 'PLOMBIERES LES DIJON' or commune like 'QUETIGNY' or commune like 'ST APOLLINAIRE' or commune like 'SENNECEY LES DIJON' or commune like 'TALANT' ORDER BY `villes`.`COMMUNE` ASC ");

    // On sélectionne les villes qui ne sont pas dans la métropole du stage
    $villesHorsMetropole = $pdo->executerRequete2("SELECT DISTINCT COMMUNE AS HORSMETROPOLE FROM `villes` where commune NOT LIKE 'AHUY' or commune NOT LIKE 'BRESSEY SUR TILLE' or commune NOT LIKE 'BRETENIERE' or commune NOT LIKE 'CHENOVE' or commune NOT LIKE 'CHEVIGNY ST SAUVEUR' or commune NOT LIKE 'CORCELLES LES MONTS' or commune NOT LIKE 'DAIX' or commune NOT LIKE 'DIJON' or commune NOT LIKE 'FENAY' or commune NOT LIKE 'FLAVIGNEROT' or commune NOT LIKE 'FONTAINE LES DIJON' or commune NOT LIKE 'HAUTEVILLE LES DIJON' or commune NOT LIKE 'LONGVIC' or commune NOT LIKE 'MAGNY SUR TILLE' or commune NOT LIKE 'MARSANNAY LA COTE' or commune NOT LIKE 'NEUILLY CRIMOLOIS' or commune NOT LIKE 'OUGES' or commune NOT LIKE 'PERRIGNY LES DIJON' or commune NOT LIKE 'PLOMBIERES LES DIJON' or commune NOT LIKE 'QUETIGNY' or commune NOT LIKE 'ST APOLLINAIRE' or commune NOT LIKE 'SENNECEY LES DIJON' or commune NOT LIKE 'TALANT' ORDER BY `villes`.`COMMUNE` ASC ");


    // On récupère les 4 premières villes + les villes de la métropole + les villes hors métropole
    $nbvilleMetropole = 0;
    $nbVilles = 0;

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


    $nbvilleAutrescommunes = 0;
    foreach ($dernieresVilles as $lastville) {

        $nbvilleAutrescommunes += $lastville['COUNT(*)'];

    }


    $nbvilleHorsMetropole = $nbVilles - $nbvilleMetropole;

    $villesStage = $premieresVilles;
    //array_push($villesStage, array('VILLE_ELEVE_STAGE' => 'Metropole', 'COUNT(*)' => $nbvilleMetropole ));
    //array_push($villesStage, array('VILLE_ELEVE_STAGE' => 'Hors Metropole', 'COUNT(*)' => $nbvilleHorsMetropole ));
    array_push($villesStage, array('VILLE_ELEVE_STAGE' => 'Autres communes', 'COUNT(*)' => $nbvilleAutrescommunes));


    ?>

    <h4>Répartition par classe</h4>
    <br>
    <?php
        $i = 0;
        $res = '';
        foreach ($graph_classes as $uneClasse) {
            if ($i > 0) {
                $res.= '|';
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
            $res.= $nom . ' (' . $uneClasse['COUNT(*)'] . ')';
            $i++;
        }
        $res.= '&chd=t:';
        $i = 0;
        foreach ($graph_classes as $uneClasse) {
            if ($i > 0) {
                $res.= ',';
            }
            $res.= $uneClasse['COUNT(*)'];
            $i++;
        }

        $res.= '&chl=';

        $i = 0;
        foreach ($graph_classes as $uneClasse) {
            if ($i > 0) {
                $res.= '|';
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
            $i++;
    } ?>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=FF0000,FFCD00,1FFF00,00FFC1,0093FF,0004FF,C500FF,FF00BD,FF0068,FF7800&chdl=<?=$res?>&chdlp=t">
            
    </p>
    <br><br><br>

    <h4>Répartition par sexe</h4>
    <br>
    <?php
        $res = '';
        $i = 0;
        foreach ($graph_sexes as $uneClasse) {
            if ($i > 0) {
                $res .= '|';
            }
            if ($uneClasse['SEXE_ELEVE_STAGE'] == '') {
                $uneClasse['SEXE_ELEVE_STAGE'] = 'Inconnu';
            }
            $res.= $uneClasse['SEXE_ELEVE_STAGE'] . ' (' . $uneClasse['COUNT(*)'] . ')';
            $i++;
        }
        $res.= '&chd=t:';
        $i = 0;
        foreach ($graph_sexes as $uneClasse) {
            if ($i > 0) {
                $res.= ',';
            }
            $res.= $uneClasse['COUNT(*)'];
            $i++;
        }

        $res.= '&chl=';

        $i = 0;
        foreach ($graph_sexes as $uneClasse) {
            if ($i > 0) {
                $res.= '|';
            }
            if ($uneClasse['SEXE_ELEVE_STAGE'] == '') {
                $uneClasse['SEXE_ELEVE_STAGE'] = 'Inconnu';
            }
            $i++;
        } ?>
    <p style="text-align:center;">
        <img class="graphique"
            src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=000000,0000FF,FF00FF,&chdl=<?=$res?>&chdlp=t">
    </p>

    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>
    <br><br><br><br>

    <h4>Répartition par établissement</h4>
    <br>
    <?php
        $i = 0;
        $res = '';
        foreach ($premiersEtablissements as $uneClasse) {
            if ($i > 0) {
                $res.= '|';
            }
            $nom = '';
            foreach ($lesEtablissements as $uneClasse2) {
                if ($uneClasse2['ID'] == $uneClasse['ETABLISSEMENT_ELEVE_STAGE']) {
                    $nom = $uneClasse2['NOM'];
                }
            }
            if ($nom == '' || $nom == '0' || $nom == null || $nom == 'Autre') {
                $nom = 'Autres établissements';
            }
            $res.= $nom . ' (' . $uneClasse['COUNT(*)'] . ')';
            $i++;
        }
        $res.= '&chd=t:';
        $i = 0;
        foreach ($premiersEtablissements as $uneClasse) {
            if ($i > 0) {
                $res.= ',';
            }
            $res.= $uneClasse['COUNT(*)'];
            $i++;
        }

        $res.= '&chl=';

        $i = 0;
        foreach ($premiersEtablissements as $uneClasse) {
            if ($i > 0) {
                $res.= '|';
            }
            $nom = '';
            foreach ($lesEtablissements as $uneClasse2) {
                if ($uneClasse2['ID'] == $uneClasse['ETABLISSEMENT_ELEVE_STAGE']) {
                    $nom = $uneClasse2['NOM'];
                }
            }
            if ($nom == '' || $nom == '0' || $nom == null) {
                $nom = 'Autres établissements';
            }
            $i++;
        } 
    ?>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=00FFFF,FFFF00,F0F0F0,0F0F0F,FFF000,000FFF,FF00FF,0000FF,FF0000,00FF00&chdl=<?=$res?>&chdlp=t">
    </p>
    <br><br><br>


    <h4>Répartition par ville</h4>
    <br>
    <?php
        $i = 0;
        $res = '';
        foreach ($villesStage as $uneClasse) {
            if ($i > 0) {
                $res.= '|';
            }
            if ($uneClasse['VILLE_ELEVE_STAGE'] == '') {
                $uneClasse['VILLE_ELEVE_STAGE'] = 'Vide';
            }
            if ($uneClasse['VILLE_ELEVE_STAGE'] == 'Autres communes') {
                $uneClasse['VILLE_ELEVE_STAGE'] = 'Autres communes';
            }
            $res.= $uneClasse['VILLE_ELEVE_STAGE'] . ' (' . $uneClasse['COUNT(*)'] . ')';
            $i++;
        }
        $res.= '&chd=t:';
        $i = 0;
        foreach ($villesStage as $uneClasse) {
            if ($i > 0) {
                $res.= ',';
            }
            $res.= $uneClasse['COUNT(*)'];
            $i++;
        }?>
    <p style="text-align:center;">
        <img class="graphique"
             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=FF00FF,00FFFF,FFFF00,00FFE4,0F0F0F,0000FF,FF0000,00FF00,FFF000,000FFF&chdl=<?=$res?>&chdlp=t">
    </p>

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <!-- Partie photos -->
    <h3>Photos</h3>

    <!-- On change de page -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always;'>

    <!-- Partie liste des élèves -->
    <h3>Liste des élèves</h3>
    <br><br><br>

    <?php
        $classe6 = [];
        $classe5 = [];
        $classe4 = [];
        $classe3 = [];
        $lycee = [];
        
        foreach ($lesClasses as $uneClasse) {
            foreach ($lesInscriptions as $lInscription) {
                if ($uneClasse['ID'] == $lInscription['CLASSE_ELEVE_STAGE']) {
                    if ($uneClasse['NOM'] == '6ème') { array_push($classe6, $lInscription);}
                    elseif ($uneClasse['NOM'] == '5ème') { array_push($classe5, $lInscription);}
                    elseif ($uneClasse['NOM'] == '4ème') { array_push($classe4, $lInscription);}
                    elseif ($uneClasse['NOM'] == '3ème') { array_push($classe3, $lInscription);}
                    else { array_push($lycee, $lInscription);;}
                }
            }
        } 
    ?>
    
    <?php 
        $niveau = $i + 2;
        $nbTab = 1;
        for ($i = 0; $i <= 3; $i++) { 
    ?>

    <table style="width:100%;color:grey">
        <tr>
            <th style="padding:5px;background-color:#99ccff;font-weight: normal;">Nom</th>
            <th style="padding:5px;background-color:#99ccff;font-weight: normal;">Prénom</th>
            <th style="padding:5px;background-color:#99ccff;font-weight: normal;">Classe</th>
        </tr>
        <?php
        
        if ($i == 0) {$classe = $classe6;}
        if ($i == 1) {$classe = $classe5;}
        if ($i == 2) {$classe = $classe4;}
        if ($i == 3) {$classe = $classe3;}

        foreach ($classe as $eleve)
        { 
            echo '<tr>
                <td style="border-bottom:1px solid gray;color:gray">' . $eleve['NOM_ELEVE_STAGE'] . '</td>
                <td style="border-bottom:1px solid gray;color:gray">' . $eleve['PRENOM_ELEVE_STAGE'] . '</td>
                <td style="border-bottom:1px solid gray;color:gray">'.$niveau.'ème</td>
            </tr>
            </tr>';
        }
        ?>
        <tr>
            <td colspan="3" style="border-bottom:1px solid gray;color:green">
                <b><?php echo count($classe); ?> inscrit(s)</b>
            </td>
        </tr>
    </table>
    <br><br><br>
    <?php
    $niveau--;
        } 
    ?>

    <table style="width:100%;color:grey">
        <tr>
            <th style="padding:5px;background-color:#99ccff;font-weight: normal;">Nom</th>
            <th style="padding:5px;background-color:#99ccff;font-weight: normal;">Prénom</th>
            <th style="padding:5px;background-color:#99ccff;font-weight: normal;">Classe</th>
        </tr>
        <?php
            $niv = '';
            foreach ($lycee as $eleve)
            { 
                if($eleve['CLASSE_ELEVE_STAGE'] == 54) { $niv = 'Seconde';}
                if($eleve['CLASSE_ELEVE_STAGE'] == 55) { $niv = 'Première';}
                if($eleve['CLASSE_ELEVE_STAGE'] == 56) { $niv = 'Terminale';}
    
                echo '<tr>
                    <td style="border-bottom:1px solid gray;color:gray">' . $eleve['NOM_ELEVE_STAGE'] . '</td>
                    <td style="border-bottom:1px solid gray;color:gray">' . $eleve['PRENOM_ELEVE_STAGE'] . '</td>
                    <td style="border-bottom:1px solid gray;color:gray">'.$niv.'</td>
                </tr>
                </tr>';
            }
        ?>

        <tr>
            <td colspan="3" style="border-bottom:1px solid gray;color:green">
                <b><?php echo count($lycee); ?> inscrit(s)</b>
            </td>
        </tr>
    </table>
    <br><br><br>

</div>
</body>
</html>
