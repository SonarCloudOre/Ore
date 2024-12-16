<div class="container mt-5 mb-5">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Bordereau de Paiement
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <button class="btn btn-success" onclick="downloadCSV()"><i class="fas fa-file-csv"></i> Télécharger CSV</button>
                    <button class="btn btn-primary" onclick="printTable()"><i class="fas fa-print"></i> Imprimer</button>
                    <button type="button" class="mr-2 btn btn-primary" onclick="document.location.href='index.php?choixTraitement=administrateur&action=PayesImpayes'" data-bcup-haslogintext="no">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" id="bordereauTable">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex">
                                <img src="./images/logo.png" alt="Logo" class="mr-3">
                                <div>
                                    <h5 class="card-title">ORE</h5>
                                    <p class="card-text">Association Ouverture Rencontres Evolution</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 text-right">
                            <div style="background-color: black; color: white; padding: 10px; text-align: center">
                                <p>Ces paiements sont compris du <?=dateAnglaisVersFrancais($dateDebut)?> au <?=dateAnglaisVersFrancais($dateFin)?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="text-center">Bordereau de Paiement</h1>

                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="title">
                            Type : <?=$typeName?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Date</th>
                                <th scope="col">N° de Transaction</th>
                                <th scope="col">Nom</th>
                                <?php
                                    if ($hasBanque) {
                                        echo "<th scope='col'>Banque</th>";
                                    }
                                ?>
                                <th scope="col">Info</th>
                                <th scope="col">Montant</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $n = 1;
                                foreach ($lesReglements as $unReglement) {
                                    $montant = 0;
                                    if (isset($unReglement['MONTANT_INSCRIPTION']) and is_numeric($unReglement['MONTANT_INSCRIPTION'])) {
                                        $montant = $unReglement['MONTANT_INSCRIPTION'];
                                    }
                                    echo "<tr>";
                                    echo "<th scope='row'>".$n."</th>";
                                    echo "<td>".$unReglement['DATE']."</td>";
                                    echo "<td>".$unReglement['NUMTRANSACTION']."</td>";

                                    $nomPrenomFrat = "";
                                    $fratrie = $pdo->getReglementFratrieStage($unReglement['ID_INSCRIPTIONS']);
                                    if ($fratrie !== []) {
                                        foreach ($fratrie as $unFratrie) {
                                            $unFratrie = $pdo->recupUneInscription($unFratrie['ID_INSCRIPTIONS2']);
                                            $nomPrenomFrat .= "<br>" . $unFratrie['NOM_ELEVE_STAGE'] . " " . $unFratrie['PRENOM_ELEVE_STAGE'];
                                        }
                                    }
                                    echo "<td><b>".$unReglement['NOM_ELEVE_STAGE']." ".$unReglement['PRENOM_ELEVE_STAGE']."</b>" . $nomPrenomFrat . "</td>";
                                    if ($hasBanque) {
                                        echo "<td>".$unReglement['BANQUE_INSCRIPTION']."</td>";
                                    }
                                    $inforeglement = "";
                                    if (isset($unReglement['ID_INFO_REGLEMENT']) and !is_null($unReglement['ID_INFO_REGLEMENT'])) {
                                        $infos = $pdo->getInfosReglement($unReglement['ID_INFO_REGLEMENT']);
                                        if (isset($infos['STAGE'])) {
                                            if ($infos['STAGE'] == 1) {
                                                $inforeglement .= 'Stage<br>';
                                            }
                                        }
                                        if (isset($infos['SORTIE_STAGE'])) {
                                            if ($infos['SORTIE_STAGE'] == 1) {
                                                $inforeglement .= 'Sortie Stage<br>';
                                            }
                                        }
                                    }
                                    echo "<td>".$inforeglement."</td>";
                                    echo "<td>".$montant." €</td>";
                                    echo "</tr>";
                                    $n++;
                                }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th scope="row" colspan="<?php
                                if ($hasBanque) {
                                    echo 5;
                                } else {
                                    echo 4;
                                } ?>">Il y a au total de <?=$totalReglement?> paiements.</th>
                                <th scope="row">Montant Total</th>
                                <td><?=$totalMontant?> €</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printTable() {
        var printContents = document.getElementById("bordereauTable").outerHTML;
        var originalContents = document.body.innerHTML;
        printContents = printContents.replace(/table/g, "table style='table-layout: fixed; width: 100%; border-collapse: collapse; border: 3px solid black;'");

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    function downloadCSV() {
        var table = document.querySelector('.table');

        // Créer un tableau pour stocker les données CSV
        var csvData = [];

        // Ajouter l'en-tête CSV
        var headerRow = table.querySelector('thead tr');
        var headerCells = headerRow.querySelectorAll('th');
        var headerData = [];
        headerCells.forEach(function(cell) {
            headerData.push(cell.textContent);
        });
        csvData.push(headerData);

        var rows = table.querySelectorAll('tbody tr');
        rows.forEach(function(row) {
            var cells = row.querySelectorAll('td');
            var rowData = [];
            cells.forEach(function(cell) {
                rowData.push('"' + cell.textContent + '"');
            });
            csvData.push(rowData);
        });

        var footerRow = table.querySelector('tfoot tr');
        var footerCells = footerRow.querySelectorAll('th, td');
        var footerData = [];
        footerCells.forEach(function(cell) {
            footerData.push('"' + cell.textContent + '"');
        });
        csvData.push(footerData);

        // Générer le contenu CSV
        var csvContent = csvData.map(function(row) {
            return row.join(';');
        }).join('\n');

        // Ajouter un en-tête UTF-8 BOM
        var csvContentWithBOM = "\ufeff" + csvContent;

        // Créer le fichier CSV en tant que Blob avec l'encodage spécifié
        var blob = new Blob([csvContentWithBOM], { type: 'text/csv;charset=utf-8;' });

        // Créer un lien de téléchargement pour le fichier CSV
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'bordereau_<?=$dateDebut?>_<?=$dateFin?>.csv';
        link.style.visibility = 'hidden';

        // Ajouter le lien de téléchargement à la page et le cliquer
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
