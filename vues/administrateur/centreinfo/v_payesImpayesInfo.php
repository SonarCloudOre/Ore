<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Payés et impayés
                <div class="page-title-subheading">Rechercher les règlements</div>
            </div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
                <button type="button" class="btn btn-primary" value="" onClick="imprimer2('sectionAimprimer2');">
          <span class="btn-icon-wrapper">
            <i class="fa fa-print fa-w-20"></i>
          </span>
                </button>
            </div>
        </div>
    </div>
</div>


<form name="frmConsultFrais" method="POST"
      action="index.php?choixTraitement=administrateur&action=info_recupPayesImpayes">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-6 card">
                <div class="card-body">
                    <div class="form-group">
                        <h4 class="card-title">Règlements</h4>
                        <label for="annee">Année</label>
                        <select name="annee" class="form-control" style="width:100px">
                            <?php
                            foreach ($lesAnneesInscription as $uneAnnee) {
                                echo '<option value="' . $uneAnnee['annee_inscription'] . '"';
                                if (isset($Annee) && $Annee == $uneAnnee['annee_inscription']) {
                                    echo ' selected="selected"';
                                }
                                echo '>' . $uneAnnee['annee_inscription'] . '</option>';
                            }
                            ?>
                        </select><br>
                        <label for="type">Type</label>
                        <select name="type" class="form-control" style="width:100px">
                            <option value="tout"<?php if ($type == 'tout') {
                                echo ' selected="selected"';
                            } ?>>Tout
                            </option>
                            <?php
                            foreach ($pdo->getParametre(5) as $chequeOuEspeces) {
                                echo '<option value="' . $chequeOuEspeces['ID'] . '"';
                                if ($type == $chequeOuEspeces['ID']) {
                                    echo ' selected="selected"';
                                }
                                echo '>' . $chequeOuEspeces['NOM'] . '</option>';
                            }
                            ?>
                        </select><br>
                        <input value="Valider" class="btn btn-success" type="submit">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
if ($Annee != '') {

    $nbPayes = 0;
    $nbInscriptions = 0;
    $lesImpayes = array();


    foreach ($inscritsInfoAnnee as $uneInscription) {
        $nbInscriptions++;
        $lesImpayes[] = $uneInscription['id_inscription'];
    }

    foreach ($payesInfoAnnee as $unReglement) {
        $nbPayes++;
    }


    ?>
    <hr>

    <div class="row">
        <div class="col-md-6 mx-auto">

            <?php
            // Génére un grapghique camembert avec les valeurs demandées
            function genererGraphique($id, $type, $hauteur, $largeur, $titre, $valeurs, $nom, $nb, $total)
            {
                $couleurs = array('red', 'blue', 'green', 'pink', 'orange', 'brown', 'gray', 'lime', 'maroon', 'olive', 'navy', 'teal', 'yellow', 'purple');
                echo "<canvas id='" . $id . "'></canvas>
         <script>
         var ctx = document.getElementById('" . $id . "');
         ctx.height = " . $hauteur . ";
         ctx.width = " . $largeur . ";
         var myChart = new Chart(ctx, {
           type: 'doughnut',
           data: { labels: [";
                $i = 0;
                foreach ($valeurs as $uneStat) {
                    if ($i > 0) {
                        echo ',';
                    }
                    echo "'" . $uneStat[$nom] . " : " . $uneStat[$nb] . " (" . round(($uneStat[$nb] / $total) * 100) . " %)'";
                    $i++;
                }
                echo "],
             datasets: [{ label: '',
               data: [";
                $i = 0;
                foreach ($valeurs as $uneStat) {
                    if ($i > 0) {
                        echo ',';
                    }
                    echo "'" . $uneStat[$nb] . "'";
                    $i++;
                }
                echo "], backgroundColor: [";
                $i = 0;
                foreach ($valeurs as $uneStat) {
                    if ($i > 0) {
                        echo ',';
                    }
                    echo "'" . $couleurs[$i] . "'";
                    $i++;
                }
                echo "]
             }]
           },
           options: { responsive: true,
             legend: { position: 'top' },
             title: { display: false, text: '" . $titre . "' }
           }
         });
         </script>";
            }

            ?>

            <div class="main-card mb-3 card">
                <div class="card-body">

                    <!-- Répartition par règlements -->
                    <h4 class="card-title">
                        <center>Types de règlements</center>
                    </h4>
                    <div class="bloc_graphique"
                         style="width:530px"><?php genererGraphique('graph_reglements', 'pie', 300, 520, 'Répartition par règlements', $camambert, 'Type', 'COUNT(*)', $camambert['COUNT(*)']); ?></div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#payes">
                                <span>Payés</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#impayes">
                                <span>Impayés</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="payes">


            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">


                            <div class="mb-3 progress-bar-animated-alt progress">
                                <div class="progress-bar bg-info" role="progressbar"
                                     aria-valuenow="<?php echo round(($nbPayes / $nbInscriptions) * 100); ?>"
                                     aria-valuemin="0" aria-valuemax="<?php echo $nbInscriptions ?>"
                                     style="width: <?php echo round(($nbPayes / $nbInscriptions) * 100); ?>%;">
                                </div>
                            </div>
                            <div class="text-center">
                                <?php echo round(($ctpayesInscritsInfoAnnee / $ctInscritsInfoAnnee) * 100); ?> % de
                                payés (<?php echo $ctpayesInscritsInfoAnnee . ' / ' . $ctInscritsInfoAnnee; ?>)
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Payés</h4>

                            <table style="width: 100%;" id="example"
                                   class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Type de réglement</th>
                                    <th>Date du réglement</th>
                                    <th>N° de transaction</th>
                                    <th>Banque</th>
                                    <th>Montant</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $i = 0;
                                $totalMontant = 0;
                                foreach ($payesInfoAnnee as $unReglement) {

                                    // Récup les infos de l'élève
                                    $UnEleveReglement = $pdo->info_getUneInscription($unReglement['id_inscription']);

                                    $i++;

                                    echo '<tr>
                           <td>' . $i . '</td>
                           <td>' . $UnEleveReglement['nom_inscription'] . '</td>
                           <td>' . $UnEleveReglement['prenom_inscription'] . '</td>
                           ';
                                    $TypeReglement = $pdo->returnUnParametre($unReglement["type_reglement"]);
                                    echo '
                           <td>' . $TypeReglement["NOM"] . '</td>
                           <td>' . date('d-m-Y', strtotime($unReglement['date_reglement'])) . '</td>
                           <td>' . $unReglement['num_cheque_reglement'] . '</td>
                           <td>' . ucfirst(strtolower($unReglement['banque_reglement'])) . '</td>
                           <td>' . $unReglement['montant_reglement'] . ' €</td>
                           </tr>';

                                    // Calcul du montant total
                                    $totalMontant = ($totalMontant + $unReglement['montant_reglement']);

                                    // Suppression de l'élève de la liste des impayés
                                    unset($lesImpayes[array_search($unReglement['id_inscription'], $lesImpayes)]);

                                }
                                echo '
                         <tfoot>
                         <tr>
                         <th colspan="6"><i>' . $i . ' payé(s) sur ' . $nbInscriptions . ' inscription(s), soit ' . round(($i / $nbInscriptions) * 100) . ' %</i></th>
                         <th>Montant total :</th>
                         <th colspan="2">' . $totalMontant . ' €</th>
                         </tr>
                         </tfoot>
                         ';

                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div role="tabpanel" class="tab-pane" id="impayes">


            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Impayés</h4>
                            <table style="width: 100%;" id="example3"
                                   class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                foreach ($lesReglementsNonEffectues as $unImpaye) {

                                    $i++;
                                    echo '<tr>
                                       <td>' . $i . '</td>
                                       <td>' . $unImpaye['nom_inscription'] . '</td>
                                       <td>' . $unImpaye['prenom_inscription'] . '</td>
                                       </tr>';

                                }

                                echo '<tfoot><tr><th colspan="3"><i>' . $i . ' impayé(s) sur ' . $nbInscriptions . ' inscription(s), soit ' . round(($i / $nbInscriptions) * 100) . ' %</i></th></tr></tfoot>';

                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>
</div>
</div>


<script type="text/javascript" src="./vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="./vendors/apexcharts/dist/apexcharts.min.js"></script>
<script type="text/javascript" src="./js/charts/apex-charts.js"></script>
<script type="text/javascript" src="./js/tables.js"></script>
