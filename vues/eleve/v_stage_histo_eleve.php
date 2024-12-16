<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Historiques des stages - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
                <button type="button" class="btn btn-primary" value="" onClick="imprimer('sectionAimprimer');">
                    <i class="fa fa-print"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="contenu">

    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Historiques de mes stages </h5>
            <div id="order_table">
                <table class="mb-0 table table-hover" id="table1">
                    <thead>
                    <tr>
                        <th>Stage</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        $nbInscriptionsStages = 0;
                        foreach ($lesStages as $unStage) {
                            $date = $unStage["DATEDEB_STAGE"];
                            $dt = DateTime::createFromFormat('Y-m-d', $date);
                            $dt1 = $dt->format('d-m-Y');


                            $idInscriptionStage = $pdo->getIdInscriptionStage($unStage['ID_STAGE'], $intervenant['ID_ELEVE']);
                            // Si l'élève est inscrit au stage
                            if ($idInscriptionStage != '') {
                                // On enregistre le nb de présences
                                $nbPresencesStages = $pdo->nbPresencesStage($unStage['ID_STAGE'], $idInscriptionStage);
                                echo '<tr>

        <td>' . stripslashes($unStage['NOM_STAGE']) . '</td>
        <td>' . $dt1 . '</td>';
                                $nbInscriptionsStages++;
                            }
                        }
                        ?>
                    </tr>
                    </tbody>
                </table>
            </div><?php if ($nbInscriptionsStages == 0) {
                echo '<br><center><p><i>Aucune inscription pour l\'instant</i></p></center>';
            } ?>
        </div>
    </div>
</div>
