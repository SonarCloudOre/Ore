<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Règlements - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
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
            <h5 class="card-title">RDV parents</h5>
            <div id="order_table">
                <table class="mb-0 table table-hover" id="table1">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>N° transaction</th>
                        <th>Banque</th>
                        <th>Montant</th>
                        <th>Commentaire</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        foreach ($lesReglementsEleve as $uneligne) {
                            echo "<tr>

                        <td>" . date('d/m/Y', strtotime($uneligne['DATE_REGLEMENT'])) . "</td>
                        <td>" . $uneligne['NOMREGLEMENT'] . "</td>
                        <td>" . $uneligne['NOM'] . "</td>
                        <td>" . $uneligne['NUMTRANSACTION'] . "</td>
                        <td>" . $uneligne['BANQUE'] . "</td>
                        <th scope='row'>" . $uneligne['MONTANT'] . " €</th>
                        <td>" . $uneligne['COMMENTAIRES'] . "</td>
                        ";
                        }
                        ?>
                    </tr>
                    </tbody>
                </table><?php if (count($lesReglementsEleve) == 0) {
                    echo '<br><center><p><i>Aucun règlements.</i></p></center>';
                } ?>
            </div>
        </div>
    </div>
</div>
