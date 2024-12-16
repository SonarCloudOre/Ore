<div id="contenu">


    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Présence des élèves
                    <div class="page-title-subheading">Présence
                        de <?php echo $UnEleve['PRENOM'] . " " . $UnEleve['NOM']; ?></div>
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


    <?php
    // Date de début et de fin en Français
    list($anneeD, $moisD, $jourD) = explode('-', $debut);
    list($anneeF, $moisF, $jourF) = explode('-', $fin);
    $dateDebut = $jourD . "-" . $moisD . "-" . $anneeD;
    $dateFin = $jourF . "-" . $moisF . "-" . $anneeF;
    ?>

    <div class="col-lg-13">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4 class="card-title">Du <?php echo $dateDebut; ?> AU <?php echo $dateFin; ?></h4>

                <table class="mb-0 table">

                    <tr>
                        <th> Date</th>

                        <?php

                        $total = 0;
                        foreach ($tableau as $uneLigne) {
                            // extraction des jour, mois, an de la date
                            list($annee, $mois, $jour) = explode('-', $uneLigne['SEANCE']);
                            // calcul du timestamp
                            $dateFrench = $jour . "-" . $mois . "-" . $annee;
                            $total++;
                            echo '<tr> <td > ' . $dateFrench . ' </td> </tr>';
                        }

                        echo " <th> TOTAL DE JOUR DE PRESENCE :  " . $total . " </th></tr> </table>";


                        ?>


            </div>
        </div>
    </div>
</div>
