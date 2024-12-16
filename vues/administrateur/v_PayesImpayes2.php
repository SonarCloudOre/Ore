<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Règlements
                    <div class="page-title-subheading">Rechercher les règlements</div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <div class="row">
                        <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                            <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Types de règlements</h4>
                    <canvas id="doughnut-chart-5"></canvas>
                </div>
            </div>
        </div>
    </div>

    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=PayesImpayes">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-6 card">
                    <div class="card-body">


                        <div class="form-group">
                            <h4 class="card-title">Règlements</h4>
                            <label for="nom">Nom</label>
                            <select name="nom" class="form-control" style="width:300px">
                                <?php
                                foreach ($lesAnneesScolaires as $value) {
                                    $annee = "Soutien scolaire " . $value['ANNEE'] . '-' . ($value['ANNEE'] + 1);
                                    $selected = "";
                                    if ($nom  == $annee) {
                                        $selected = "selected";
                                    }
                                    echo '<option value="' . $annee . '" ' . $selected . '>' . $annee . '</option>';
                                }
                                ?>
                            </select><br>
                            <label for="type">Type</label>
                            <select name="type" class="form-control" style="width:300px">
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
    if ($nom != '') {

        $nbPayes = 0;
        $nbInscriptions = 0;
        $lesImpayes = array();


        foreach ($lesEleves as $unEleve) {
            $nbInscriptions++;
            $lesImpayes[] = $unEleve['ID_ELEVE'];
        }

        foreach ($lesReglements as $unReglement) {
            $nbPayes++;
        }


        ?>
        <hr>


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
                            <li class="nav-item">
                                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#bordereau">
                                    <span>Bordereau</span>
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
                                    <?php echo round(($nbPayes / $nbInscriptions) * 100); ?> % de payés
                                    (<?php echo $nbPayes . ' / ' . $nbInscriptions; ?>)
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
                                        <th>Type de réglement</th>
                                        <th>Date du réglement</th>
                                        <th>N° de transaction</th>
                                        <th>Banque</th>
                                        <th>Montant</th>
                                        <th>Commentaire</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $i = 0;
                                    $totalMontant = 0;
                                    foreach ($lesReglements as $unReglement) {

                                        // Récup les infos de l'élève
                                        $eleves = $pdo->recupeElevesWithReglement($unReglement['ID']);


                                        $i++;

                                        echo '<tr>
                                              <td>' . $i . '</td>
                                              <td>';
                                        $pourHTML = "";
                                        foreach ($eleves as $unEleve) {
                                            $pourHTML .= '<a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $unEleve['ID_ELEVE'] . '">' . $unEleve['NOM'] . ' ' . $unEleve['PRENOM'] . '</a><br>';
                                            // Suppression de l'élève de la liste des impayés
                                            unset($lesImpayes[array_search($unEleve['ID_ELEVE'], $lesImpayes)]);
                                        
                                        
                                        }
                                        echo $pourHTML;
                                        echo '</td>
                                              <td>';
                                        foreach ($pdo->getParametre(5) as $chequeOuEspeces) {
                                            if ($chequeOuEspeces['ID'] == $unReglement['ID_TYPEREGLEMENT']) {
                                                echo $chequeOuEspeces['NOM'];
                                            }
                                        }
                                        echo '</td>
                          <td>' . date('d-m-Y', strtotime($unReglement['DATE_REGLEMENT'])) . '</td>
                          <td>' . $unReglement['NUMTRANSACTION'] . '</td>
                          <td>' . ucfirst(strtolower($unReglement['BANQUE'])) . '</td>
                          <td>' . $unReglement['MONTANT'] . ' €</td>
                          <td>' . $unReglement['COMMENTAIRES'] . '</td>
                          </tr>';

                                        // Calcul du montant total
                                        $totalMontant = ($totalMontant + $unReglement['MONTANT']);

                                    

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

            <div role="tabpanel" class="tab-pane" id="bordereau">

                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h4 class="card-title">Bordereau</h4>
                                <section class="mb-3">
                                    <form method="post" action="index.php?choixTraitement=administrateur&action=genererBordereauEleve" onsubmit="return validateForm()">
                                        <div class="form-row">
                                            <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                    <label for="dateDebut" class="">Date de début</label>
                                                    <input name="dateDebut" id="dateDebut" placeholder="Date de début" type="date" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                    <label for="dateFin" class="">Date de fin</label>
                                                    <input name="dateFin" id="dateFin" placeholder="Date de fin" type="date" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                    <label for="type" class="">Types</label>
                                                    <select name="type" id="type" class="form-control">
                                                        <option value="0">Tous</option>
                                                        <option value="1">Chèque</option>
                                                        <option value="151">CB</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="mt-2 btn btn-primary">Générer le bordereau</button>
                                    </form>

                                    <script>
                                        function validateForm() {
                                            const dateDebutInput = document.getElementById('dateDebut');
                                            const dateFinInput = document.getElementById('dateFin');
                                            const dateDebut = new Date(dateDebutInput.value);
                                            const dateFin = new Date(dateFinInput.value);

                                            // Vérification que les deux dates sont saisies
                                            if (!dateDebutInput.value || !dateFinInput.value) {
                                                alert('Veuillez saisir les deux dates.');
                                                return false;
                                            }

                                            // Vérification que la date de fin n'est pas antérieure à la date de début
                                            if (dateFin < dateDebut) {
                                                alert('La date de fin ne peut pas être antérieure à la date de début.');
                                                return false;
                                            }

                                            return true;
                                        }
                                    </script>
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($lesImpayes as $unImpaye) {

                                        // Récup les infos de l'élève
                                        $UnEleveReglement = $pdo->recupUnEleves($unImpaye);

                                        $i++;
                                        echo '<tr>
                                      <td>' . $i . '</td>
                                      <td><a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $UnEleveReglement['ID_ELEVE'] . '">' . $UnEleveReglement['NOM'] . " " . $UnEleveReglement['PRENOM'] . '</a></td>
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

<script type="text/javascript" src="./vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="./vendors/chart.js/dist/Chart.min.js"></script>
<script type="text/javascript" src="./js/tables.js"></script>


<script type="text/javascript">

    var camembert = <?php echo json_encode($camembert); ?>;

    chartColors = {
        red: "#dc3545",
        orange: "#fd7e14",
        yellow: "#ffc107",
        green: "#28a745",
        blue: "#007bff",
        purple: "#6f42c1",
        grey: "#6c757d",
    };


    if (document.getElementById("doughnut-chart-5")) {
        var ctx = document.getElementById("doughnut-chart-5");

    }


    var myChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            datasets: [
                {
                    data: camembert,
                    backgroundColor: [
                        chartColors.red,
                        chartColors.orange,
                        chartColors.yellow,
                        chartColors.green,
                        chartColors.blue,
                    ],
                    label: "Dataset 1",
                },
            ],
            labels: ["Chèque", "CB", "Espèces", "Bon caf", "Autre", "Exonérés"],
        },
        options: {
            responsive: true,
            legend: {
                position: "top",
            },
            title: {
                display: false,
                text: "Chart.js Doughnut Chart",
            },
            animation: {
                animateScale: true,
                animateRotate: true,
            },
        },
    });

</script>
