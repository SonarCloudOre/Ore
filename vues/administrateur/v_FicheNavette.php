<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Fiche navette
                    <?php

                    if (isset($num)) {
                        echo '<div class="page-title-subheading">' . $eleveSelectionner["PRENOM"] . ' ' . $eleveSelectionner["NOM"] . '</div>';
                    } else {
                        echo '<div class="page-title-subheading">Sélectionner un élève pour accéder à sa fiche</div>';
                    }
                    ?>

                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <div class="row">
                        <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                            <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                        </button>
                        <button type="button" class="btn btn-primary" value=""
                                onClick="imprimer2('sectionAimprimer2');">
                            <i class="fa fa-print"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<style type="text/css">
    h4 {
        border-bottom: 1px solid black;
        padding: 5px;
        font-size: 25px;
        font-weight: bold;
        margin-top: 20px;
    }
</style>


<script>
    /*
                 function printDiv() {
                         var divContents = document.getElementById("GFG").innerHTML;
                         var a = window.open('', '', 'height=500, width=500');
                         a.document.write('<html>');
                         a.document.write('<body > <h1>Div contents are <br>');
                         a.document.write(divContents);
                         a.document.write('</body></html>');
                         a.document.close();
                         a.print();
                 }*/
</script>


<?php


if ($eleveSelectionner['PHOTO'] == "") {
    $photo = "AUCUNE.jpg";
} else {
    $photo = $eleveSelectionner['PHOTO'];
}
echo '<center><div class="col-md-3"><div class="main-card mb-3 card">

																	<div class="card-body">
																	<img width="200" style="box-shadow: 1px 1px 20px #555;image-orientation: 0deg;"  src="photosEleves/' . $photo . '" >
																	<br><br>
																	</div></div></div></center>
'; ?>




<?php
$OuiNon = array('Non', 'Oui');
?>


<div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">

                <h4>L'élève</h4>
                <p><b>Nom-prénom
                        : </b><?php echo $eleveSelectionner['NOM']; ?> <?php echo $eleveSelectionner['PRENOM']; ?> <br>
                    <b>Sexe :</b> <?php echo $eleveSelectionner['SEXE']; ?><br>
                    <?php
                    //Date de naissance en Français
                    list($anneeNaiss, $moisNaiss, $jourNaiss) = explode('-', $eleveSelectionner['DATE_DE_NAISSANCE']);
                    $date_naissance = $jourNaiss . "-" . $moisNaiss . "-" . $anneeNaiss;
                    ?>
                    <b>Né(e) le:</b> <?php echo $date_naissance ?><br>
                    <b>Téléphone de l'enfant:</b> <?php echo $eleveSelectionner['TÉLÉPHONE_DE_L_ENFANT']; ?><br>
                    <b>Email de l'enfant:</b> <?php echo $eleveSelectionner['EMAIL_DE_L_ENFANT']; ?><br>
                </p>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4>Les parents</h4>
                <b>Nom et Prénom:</b> <?php echo $eleveSelectionner['RESPONSABLE_LEGAL']; ?><br>
                <b>Téléphone 1 des parents (portable) :</b> <?php echo $eleveSelectionner['TÉLÉPHONE_DES_PARENTS']; ?>
                <br>
                <b>Téléphone 2 des parents (fixe) :</b> <?php echo $eleveSelectionner['TÉLÉPHONE_DES_PARENTS2']; ?><br>
                <b>Téléphone 3 des parents (autre) :</b> <?php echo $eleveSelectionner['TÉLÉPHONE_DES_PARENTS3']; ?><br>
                <b>Mail des parents:</b> <?php echo $eleveSelectionner['EMAIL_DES_PARENTS']; ?><br>
                <b>Profession du Père:</b> <?php echo $eleveSelectionner['PROFESSION_DU_PÈRE']; ?><br>
                <b>Profession de la mère:</b> <?php echo $eleveSelectionner['PROFESSION_DE_LA_MÈRE']; ?><br>
                <b>Adresse:</b> <?php echo $eleveSelectionner['ADRESSE_POSTALE'] . ' ' . $eleveSelectionner['CODE_POSTAL'] . ' ' . $eleveSelectionner['VILLE']; ?>
                <br>
                <b>Etre prévenu en cas d'absence
                    ?</b> <?php echo $OuiNon[$eleveSelectionner['PRÉVENIR_EN_CAS_D_ABSENCE']]; ?><br>
                <b>Commentaires :</b> <?php echo $eleveSelectionner['COMMENTAIRES']; ?><br>
                <b>Contact avec les parents :</b> <?php echo $eleveSelectionner['CONTACT_AVEC_LES_PARENTS']; ?><br>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <?php
    foreach ($LesInscriptions as $uneInscription) {
        $annee = $uneInscription['ANNEE'];
        $annee1 = $uneInscription['ANNEE'] + 1;
        ?>
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4>Soutien scolaire en <?php echo $annee . '-' . $annee1; ?></h4>
                    <p><b>Etablissement :</b> <?php
                        foreach ($lesEtablissements as $uneLigne) {
                            if ($uneInscription['ID'] == $uneLigne['ID']) {
                                echo $uneLigne['NOM'];
                            }
                        } ?><br>
                    <p><b>Classe :</b> <?php foreach ($lesClasses as $uneLigne) {
                            if ($uneInscription['ID_CLASSE'] == $uneLigne['ID']) {
                                echo $uneLigne['NOM'];
                            }
                        } ?>
                    <p><b>Filières :</b> <?php foreach ($lesfilieres as $uneLigne) {
                            if ($uneInscription['ID_FILIERES'] == $uneLigne['ID']) {
                                echo $uneLigne['NOM'];
                            }
                        } ?>
                    <p><b>LV1 :</b> <?php foreach ($lesLangues as $uneLigne) {
                            if ($uneInscription['ID_LV1'] == $uneLigne['ID']) {
                                echo $uneLigne['NOM'];
                            }
                        } ?>
                    <p><b>LV2 :</b> <?php foreach ($lesLangues as $uneLigne) {
                            if ($uneInscription['ID_LV2'] == $uneLigne['ID']) {
                                echo $uneLigne['NOM'];
                            }
                        }
                        list($annee, $mois, $jour) = explode('-', $uneInscription['DATE_INSCRIPTION']);
                        $dateFrancaisInscription = $jour . "-" . $mois . "-" . $annee;
                        ?>
                    <p><b>Spécialités :</b> <br>
                        <?php
                        $lesSpecialitesEleves = $pdo->getSpecialitesEleve($num, $uneInscription['ANNEE']);

                        foreach ($lesSpecialites as $uneLigne) {

                            $checked = " ";

                            foreach ($lesSpecialitesEleves as $uneLigne2) {
                                if ($uneLigne['ID'] == $uneLigne2['ID']) {
                                    echo "" . $uneLigne['NOM'] . "<br>";
                                }
                            }


                        } ?>
                    <p><b>Date d'inscription :</b> <?php echo $dateFrancaisInscription; ?><br>
                    <p><b>Professeur Principal :</b> <?php echo $uneInscription['NOM_DU_PROF_PRINCIPAL']; ?><br>
                    <p><b>Commentaires :</b> <?php echo $uneInscription['COMMENTAIRESANNEE']; ?><br>
                    <p><b>Difficultés Scolaire :</b> <br>
                </div>
            </div>
        </div>

        <?php
        $lesMatieresEleves = $pdo->getDifficultesEleve($num, $uneInscription['ANNEE']);

        foreach ($lesMatieres as $uneLigne) {

            $checked = " ";

            foreach ($lesMatieresEleves as $uneLigne2) {
                if ($uneLigne['ID'] == $uneLigne2['ID']) {
                    echo "" . $uneLigne['NOM'] . "<br>";
                }
            }


        } ?>
    <?php } ?>

    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4>Stages</h4>
                <?php
                $nbInscriptionsStages = 0;

                foreach ($lesStages as $unStage) {
                    $idInscriptionStage = $pdo->getIdInscriptionStage($unStage['ID_STAGE'], $eleveSelectionner['ID_ELEVE']);
                    // Si l'élève est inscrit au stage
                    if ($idInscriptionStage != '') {
                        // On enregistre le nb de présences
                        $nbPresencesStages = $pdo->nbPresencesStage($unStage['ID_STAGE'], $idInscriptionStage);
                        echo '<li><b>' . stripslashes($unStage['NOM_STAGE']) . '</b></li>';
                        $nbInscriptionsStages++;
                    }
                }

                if ($nbInscriptionsStages == 0) {
                    echo '<li><i>Aucune inscription pour l\'instant.</i></li>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4>Documents de l'inscription</h4>
                <b>Assurance:</b> <?php echo $OuiNon[$eleveSelectionner['ASSURANCE_PÉRISCOLAIRE']]; ?><br>
                <b>Réglements:</b> <br>
                <?php
                if (count($lesReglementsEleve) != 0) {
                    echo '
		<table cellspacing="0" cellpadding="3px" rules="rows"
   style="border:solid 1px #777777; border-collapse:collapse; font-family:verdana; font-size:11px;">


  <tr style="background-color:lightgrey;"><th style="border:1px solid black">No Reglement</th><th style="border:1px solid black">Date</th><th style="border:1px solid black">Nom</th><th style="border:1px solid black">Type</th><th style="border:1px solid black">Montant</th>';
                    foreach ($lesReglementsEleve as $uneligne) {
                        // extraction des jour, mois, an de la date
                        list($annee, $mois, $jour) = explode('-', $uneligne['DATE_REGLEMENT']);
                        $dateReglement = $jour . "-" . $mois . "-" . $annee;


                        echo "<tr><tr><td style='border:1px solid black'>" . $uneligne['ID'] . "</td><td style='border:1px solid black'>" . $dateReglement . "</td><td style='border:1px solid black'>" . $uneligne['NOMREGLEMENT'] . "</td><td style='border:1px solid black'>" . $uneligne['NOM'] . "</td><td style='border:1px solid black'>" . $uneligne['MONTANT'] . " €</td></tr>";
                    }
                } else {
                    echo '<p>L\'élève n\'a jamais fait un réglement</p>';
                }

                echo '</table>';
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <textarea cols=50 rows=4 class="form-control" name="commentaires">Commentaires</textarea><br><br>
            </div>
        </div>
    </div>
</div>
<p><input value="Valider" class="btn btn-success btn-lg" type="submit"></p>
