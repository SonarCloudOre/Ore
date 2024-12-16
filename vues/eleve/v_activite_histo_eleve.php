<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Historiques des activités - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
                <button type="button" class="btn btn-primary" value="" onClick="imprimer('sectionAimprimer');">
                                  <span class="btn-icon-wrapper">
                                    <i class="fa fa-print fa-w-20"></i>
                                  </span>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="contenu">

    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Historiques de mes activités </h5>
            <div id="order_table">
                <table class="mb-0 table table-hover" id="table1">
                    <thead>
                    <tr>
                        <th>No Evenement</th>
                        <th>Evenement</th>
                        <th>Date de Début</th>
                        <th>Date de Fin</th>
                        <th>Coûts par Enfant</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        foreach ($lesEvenementsEleve as $uneligne) {
                            if ($uneligne['ANNULER'] == 1) {
                                $ANNULER = "Oui";
                            } else {
                                $ANNULER = "Non";
                            }
                            // extraction des jour, mois, an de la date
                            list($annee, $mois, $jour) = explode('-', $uneligne['DATEDEBUT']);
                            $dateFrancaisDebut = $jour . "-" . $mois . "-" . $annee;
                            // extraction des jour, mois, an de la date
                            list($annee, $mois, $jour) = explode('-', $uneligne['DATEFIN']);
                            $dateFrancaisFin = $jour . "-" . $mois . "-" . $annee;

                            echo '
                  <tr>
                  <td >' . $uneligne["NUMÉROEVENEMENT"] . '</td>
                  <td >' . $uneligne["EVENEMENT"] . '</td>
                  <td >' . $dateFrancaisDebut . '</td>
                  <td >' . $dateFrancaisFin . '</td>
                  <td >' . $uneligne["COUTPARENFANT"] . ' €</td>
                  </tr>';
                        } ?>
                    </tr>
                    </tbody>
                </table><?php if (count($lesEvenementsEleve) == 0) {
                    echo '<br><center><p><i>L\'élève n\'est inscrit à aucun évènement</i></p></center>';
                } ?>
            </div>
        </div>
    </div>
</div>
