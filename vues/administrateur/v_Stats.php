<div id="contenu">


    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Statistiques
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


    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#soutienscolaire">
                                <span>Soutien scolaire</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab"
                               href="#soutienscolairepersonalise">
                                <span>Soutien scolaire personalisé</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="soutienscolaire">


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

            <div class="row">
                <div class="col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-body">

                            <!-- Répartition par sexe -->
                            <h4 class="card-title">
                                <center>Répartition par sexe</center>
                            </h4>
                            <div class="bloc_graphique"
                                 style="width:530px"><?php genererGraphique('graph_sexe', 'pie', 300, 520, 'Répartition par sexe', $nbElevesParSexe, 'SEXE', 'COUNT(*)', $nbEleves['COUNT(*)']); ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <!-- Répartition par classe -->
                            <h4 class="card-title">
                                <center>Répartition par classe</center>
                            </h4>
                            <div class="bloc_graphique"
                                 style="width:530px"><?php genererGraphique('graph_classe', 'pie', 300, 520, 'Répartition par classe', $nbElevesParClasse, 'NOM', 'COUNT(*)', $nbEleves['COUNT(*)']); ?></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <!-- Répartition par ville -->
                            <h4 class="card-title">
                                <center>Répartition par ville</center>
                            </h4>
                            <div class="bloc_graphique" style="width:530px">
                                <?php
                                $couleurs = array('red', 'blue', 'green', 'pink', 'orange', 'brown', 'gray', 'lime', 'maroon', 'olive', 'navy', 'teal', 'yellow', 'purple');
                                echo "<canvas id='graph_villes'></canvas>
              <script>
              var ctx = document.getElementById('graph_villes');
              ctx.height = 400;
              ctx.width = 520;
              var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: { labels: [";
                                $i = 0;
                                $totalElevesVille = 0;
                                foreach ($nbElevesParVille as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $uneStat['VILLE'] . " : " . $uneStat['COUNT(*)'] . " (" . round(($uneStat['COUNT(*)'] / $nbEleves['COUNT(*)']) * 100) . " %)'";
                                    $totalElevesVille = $totalElevesVille + $uneStat['COUNT(*)'];
                                    $i++;
                                }
                                echo ",'Autres villes : " . ($nbEleves['COUNT(*)'] - $totalElevesVille) . " (" . round((($nbEleves['COUNT(*)'] - $totalElevesVille) / $nbEleves['COUNT(*)']) * 100) . " %)'],
                  datasets: [{ label: '',
                    data: [";
                                $i = 0;
                                foreach ($nbElevesParVille as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $uneStat['COUNT(*)'] . "'";
                                    $i++;
                                }
                                echo ",'" . ($nbEleves['COUNT(*)'] - $totalElevesVille) . "'], backgroundColor: [";
                                $i = 0;
                                foreach ($nbElevesParVille as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $couleurs[$i] . "'";
                                    $i++;
                                }
                                echo ",'" . $couleurs[$i] . "']
                  }]
                },
                options: { responsive: true,
                  legend: { position: 'top' },
                  title: { display: false, text: 'Répartition par ville' }
                }
              });
              </script>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <!-- Répartition par filière -->
                            <h4 class="card-title">
                                <center>Répartition des lycéens par classe et filière</center>
                            </h4>
                            <div class="bloc_graphique" style="width:530px">
                                <?php
                                echo "<canvas id='graph_filieres'></canvas>
              <script>
              var ctx = document.getElementById('graph_filieres');
              ctx.height = 400;
              ctx.width = 520;
              var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: { labels: [";
                                $i = 0;
                                foreach ($nbElevesParFiliere as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'";
                                    foreach ($lesClasses as $uneClasse) {
                                        if ($uneClasse['ID'] == $uneStat['ID_CLASSE']) {
                                            echo $uneClasse['NOM'];
                                            break;
                                        }
                                    }
                                    echo " " . $uneStat['NOM'] . " : " . $uneStat['COUNT(*)'] . " (" . round(($uneStat['COUNT(*)'] / $nbEleves['COUNT(*)']) * 100) . " %)'";
                                    $i++;
                                }
                                echo "],
                  datasets: [{ label: '',
                    data: [";
                                $i = 0;
                                foreach ($nbElevesParFiliere as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $uneStat['COUNT(*)'] . "'";
                                    $i++;
                                }
                                echo "], backgroundColor: [";
                                $i = 0;
                                foreach ($nbElevesParFiliere as $uneStat) {
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
                  title: { display: false, text: 'Répartition des lycéens par classe et filière' }
                },
                pieceLabel: {
                  mode: 'value',
                  precision: 0,
                  fontSize: 18,
                  fontColor: '#fff',
                  fontStyle: 'bold',
                  fontFamily: \"'Helvetica Neue', 'Helvetica', 'Arial', sans-serif\"
                }
              });
              </script>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <!-- Présences des élèves -->
                            <div class="bloc_graphique" style="width:100%">
                                <h4 class="card-title">
                                    <center>Présences des élèves</center>
                                </h4>
                                <?php
                                echo "<canvas id='graph_presences_eleves'></canvas>
                <script>
    var ctx = document.getElementById('graph_presences_eleves');
    ctx.height = 300;
    ctx.width = 1000;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: { labels: [";
                                $i = 0;
                                $moisPrecedent = '';
                                foreach ($nbPresencesEleves as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    // Si le mois change
                                    if ($moisPrecedent != date('m', strtotime($uneStat['SEANCE']))) {
                                        echo "'" . $moisNoms[date('m', strtotime($uneStat['SEANCE']))] . "'";
                                        $moisPrecedent = date('m', strtotime($uneStat['SEANCE']));
                                    } else {
                                        echo "''";
                                    }
                                    $i++;
                                }
                                echo "],
            datasets: [{ label: 'Année scolaire " . $anneeEnCours . "-" . ($anneeEnCours + 1) . "',
                data: [";
                                $i = 0;
                                foreach ($nbPresencesEleves as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $uneStat['COUNT(*)'] . "'";
                                    $i++;
                                }
                                echo "], borderColor: 'rgb(0,0,255)'
            },
            { label: 'Année scolaire " . ($anneeEnCours - 1) . "-" . $anneeEnCours . "',
                data: [";
                                $i = 0;
                                foreach ($nbPresencesElevesAvant as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $uneStat['COUNT(*)'] . "'";
                                    $i++;
                                }
                                echo "], borderColor: 'rgb(128,128,128)'
            }]
        },
        options: {
            scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
            responsive: true,
            legend: {
                labels: {
                    fontColor: 'black',
                    defaultFontSize: 20
                }
            }
        }
    });
    </script>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="bloc_graphique" style="width:100%">
                                <h4 class="card-title">
                                    <center>Présences des intervenants</center>
                                </h4>
                                <?php
                                echo "<canvas id='graph_presences_intervenants'></canvas>
                <script>
    var ctx = document.getElementById('graph_presences_intervenants');
    ctx.height = 300;
    ctx.width = 1000;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: { labels: [";
                                $i = 0;
                                $moisPrecedent = '';
                                foreach ($nbPresencesIntervenants as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    // Si le mois change
                                    if ($moisPrecedent != date('m', strtotime($uneStat['SEANCE']))) {
                                        echo "'" . $moisNoms[date('m', strtotime($uneStat['SEANCE']))] . "'";
                                        $moisPrecedent = date('m', strtotime($uneStat['SEANCE']));
                                    } else {
                                        echo "''";
                                    }
                                    $i++;
                                }
                                echo "],
            datasets: [{ label: 'Année scolaire " . $anneeEnCours . "-" . ($anneeEnCours + 1) . "',
                data: [";
                                $i = 0;
                                foreach ($nbPresencesIntervenants as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $uneStat['COUNT(*)'] . "'";
                                    $i++;
                                }
                                echo "], borderColor: 'rgb(0,0,255)'
            },
            { label: 'Année scolaire " . ($anneeEnCours - 1) . "-" . $anneeEnCours . "',
                data: [";
                                $i = 0;
                                foreach ($nbPresencesIntervenantsAvant as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $uneStat['COUNT(*)'] . "'";
                                    $i++;
                                }
                                echo "], borderColor: 'rgb(128,128,128)'
            }]
        },
        options: {
            scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
            responsive: true,
            legend: {
                labels: {
                    fontColor: 'black',
                    defaultFontSize: 20
                }
            }
        }
    });
    </script>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="bloc_graphique" style="width:100%">
                                <h4 class="card-title">
                                    <center>Inscriptions</center>
                                </h4>
                                <?php
                                echo "<canvas id='graph_inscriptions'></canvas>
                <script>
    var ctx = document.getElementById('graph_inscriptions');
    ctx.height = 300;
    ctx.width = 1000;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: { labels: [";
                                $i = 0;
                                foreach ($nbInscriptionsEleves as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    // Si le mois change
                                    if ($moisPrecedent != date('m', strtotime($uneStat['DATE_INSCRIPTION']))) {
                                        echo "'" . $moisNoms[date('m', strtotime($uneStat['DATE_INSCRIPTION']))] . "'";
                                        $moisPrecedent = date('m', strtotime($uneStat['DATE_INSCRIPTION']));
                                    } else {
                                        echo "''";
                                    }
                                    $i++;
                                }
                                echo "],
            datasets: [{ label: 'Année scolaire " . $anneeEnCours . "-" . ($anneeEnCours + 1) . "',
                data: [";
                                $i = 0;
                                $nbInscriptions = 0;
                                foreach ($nbInscriptionsEleves as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    $nbInscriptions = $nbInscriptions + $uneStat['COUNT(*)'];
                                    echo "'" . $nbInscriptions . "'";
                                    $i++;
                                }
                                echo "], borderColor: 'rgb(0,0,255)'
            },
            { label: 'Année scolaire " . ($anneeEnCours - 1) . "-" . $anneeEnCours . "',
                data: [";
                                $i = 0;
                                $nbInscriptions = 0;
                                foreach ($nbInscriptionsElevesAvant as $uneStat) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    $nbInscriptions = $nbInscriptions + $uneStat['COUNT(*)'];
                                    echo "'" . $nbInscriptions . "'";
                                    $i++;
                                }
                                echo "], borderColor: 'rgb(128,128,128)'
            }]
        },
        options: {
            scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
            responsive: true,
            legend: {
                labels: {
                    fontColor: 'black',
                    defaultFontSize: 20
                }
            }
        }
    });
    </script>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script type="text/javascript">
            $('#onglets a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            })
        </script>


        <div role="tabpanel" class="tab-pane" id="soutienscolairepersonalise">
            <form name="frmConsultFrais" method="POST"
                  action="index.php?choixTraitement=administrateur&action=Statistiques#graphique">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <script type="text/javascript">
                                    function selectall(nom, bool) {
                                        var nb = document.getElementById(nom).options.length;
                                        for (i = 0; i < nb; i++) {
                                            document.getElementById(nom).options[i].selected = bool;
                                        }
                                    }
                                </script>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Critères <i>(vous pouvez séléctionner plusieurs éléments avec la
                                                touche CTRL)</i></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>Par évènement :</td>
                                        <td>

                                            <select name="critere_stage" style="width:200px" class="form-control">
                                                <option value="tout"<?php if ($_POST['critere_stage'] == 'tout') {
                                                    echo ' selected="selected"';
                                                } ?>>Tout
                                                </option>
                                                <option value="soutien"<?php if ($_POST['critere_stage'] == 'soutien') {
                                                    echo ' selected="selected"';
                                                } ?>>Soutien scolaire
                                                </option>
                                                <?php
                                                foreach ($lesStages as $uneLigne) {
                                                    echo '<option value="' . $uneLigne['ID_STAGE'] . '"';

                                                    if ($_POST['critere_stage'] == $uneLigne['ID_STAGE']) {
                                                        echo ' selected="selected"';
                                                    }
                                                }
                                                echo '> ' . $uneLigne['NOM_STAGE'] . '</option>';

                                                ?>

                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Par année scolaire :</td>
                                        <td>
                                            <input type="text" name="critere_annee" style="width:200px"
                                                   class="form-control" value="<?php
                                            if ($_POST['critere_annee'] != '') {
                                                echo $_POST['critere_annee'];
                                            } else {
                                                echo $anneeEnCours;
                                            }
                                            ?>">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Par sexe :</td>
                                        <td>
                                            <label for="sexe_H" style="font-weight:normal"><input type="checkbox"
                                                                                                  name="critere_sexe_H"
                                                                                                  id="sexe_H"
                                                                                                  value="H"<?php if (isset($_POST['critere_sexe_H']) && $_POST['critere_sexe_H'] == 'H') {
                                                    echo ' checked="checked"';
                                                } ?>> Garçon </label>
                                            <label for="sexe_F" style="font-weight:normal"><input type="checkbox"
                                                                                                  name="critere_sexe_F"
                                                                                                  id="sexe_F"
                                                                                                  value="F"<?php if (isset($_POST['critere_sexe_F']) && $_POST['critere_sexe_F'] == 'F') {
                                                    echo ' checked="checked"';
                                                } ?> style="margin-left:30px"> Fille </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Par classe :</td>
                                        <td>
                                            <select name="critere_classe[]" id="critere_classe" size="5"
                                                    style="width:200px" multiple class="form-control">
                                                <?php
                                                foreach ($lesClasses as $uneLigne) {
                                                    echo '<option value="' . $uneLigne['ID'] . '"';
                                                    if (!empty($_POST['critere_classe'])) {
                                                        foreach ($_POST['critere_classe'] as $selectValue) {
                                                            if ($selectValue == $uneLigne['ID']) {
                                                                echo ' selected="selected"';
                                                            }
                                                        }
                                                    }
                                                    echo '> ' . $uneLigne['NOM'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <a href="javascript:selectall('critere_classe','true');">Selectionner
                                                tout</a> / <a href="javascript:selectall('critere_classe','');">Déselectionner
                                                tout</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Par filière :</td>
                                        <td><select name="critere_filiere[]" id="critere_filiere" size="5"
                                                    style="width:200px" multiple class="form-control">
                                                <?php
                                                foreach ($lesfilieres as $uneLigne) {
                                                    echo '<option value="' . $uneLigne['ID'] . '"';
                                                    if (!empty($_POST['critere_filiere'])) {
                                                        foreach ($_POST['critere_filiere'] as $selectValue) {
                                                            if ($selectValue == $uneLigne['ID']) {
                                                                echo ' selected="selected"';
                                                            }
                                                        }
                                                    }
                                                    echo '> ' . $uneLigne['NOM'] . '</option>';
                                                }
                                                ?>
                                            </select> <a href="javascript:selectall('critere_filiere','true');">Selectionner
                                                tout</a> / <a href="javascript:selectall('critere_filiere','');">Déselectionner
                                                tout</a>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Par établissement :</td>
                                        <td><select name="critere_etablissement[]" id="critere_etablissement" size="5"
                                                    style="width:200px" multiple class="form-control">
                                                <?php
                                                foreach ($lesEtablissements as $uneLigne) {
                                                    echo '<option value="' . $uneLigne['ID'] . '"';
                                                    if (!empty($_POST['critere_etablissement'])) {
                                                        foreach ($_POST['critere_etablissement'] as $selectValue) {
                                                            if ($selectValue == $uneLigne['ID']) {
                                                                echo ' selected="selected"';
                                                            }
                                                        }
                                                    }
                                                    echo '> ' . $uneLigne['NOM'] . '</option>';
                                                }
                                                ?>
                                            </select> <a href="javascript:selectall('critere_etablissement','true');">Selectionner
                                                tout</a> / <a href="javascript:selectall('critere_etablissement','');">Déselectionner
                                                tout</a>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Par ville :</td>
                                        <td>
                                            <select name="critere_ville[]" id="critere_ville" size="5"
                                                    style="width:200px" multiple class="form-control">
                                                <?php
                                                foreach ($lesVilles as $uneLigne) {
                                                    echo '<option value="' . $uneLigne['VILLE'] . '"';
                                                    if (!empty($_POST['critere_ville'])) {
                                                        foreach ($_POST['critere_ville'] as $selectValue) {
                                                            if ($selectValue == $uneLigne['ID']) {
                                                                echo ' selected="selected"';
                                                            }
                                                        }
                                                    }
                                                    echo '> ' . $uneLigne['VILLE'] . '</option>';
                                                }
                                                ?>
                                            </select> <a href="javascript:selectall('critere_ville','true');">Selectionner
                                                tout</a> / <a href="javascript:selectall('critere_ville','');">Déselectionner
                                                tout</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Par langue :</td>
                                        <td><select name="critere_langue[]" id="critere_langue" size="5"
                                                    style="width:200px" multiple class="form-control">
                                                <?php
                                                foreach ($lesLangues as $uneLigne) {
                                                    echo '<option value="' . $uneLigne['ID'] . '"';
                                                    if (!empty($_POST['critere_langue'])) {
                                                        foreach ($_POST['critere_langue'] as $selectValue) {
                                                            if ($selectValue == $uneLigne['ID']) {
                                                                echo ' selected="selected"';
                                                            }
                                                        }
                                                    }
                                                    echo '> ' . $uneLigne['NOM'] . '</option>';
                                                }
                                                ?>
                                            </select> <a href="javascript:selectall('critere_langue','true');">Selectionner
                                                tout</a> / <a href="javascript:selectall('critere_langue','');">Déselectionner
                                                tout</a>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Présents au soutien scolaire :</td>
                                        <td>
                                            <select class="form-control" name="critere_presences_operateur"
                                                    style="width:100px">
                                                <option
                                                    value="plus"<?php if ($_POST['critere_presences_operateur'] == 'plus') {
                                                    echo ' selected="selected"';
                                                } ?>>plus de
                                                </option>
                                                <option
                                                    value="moins"<?php if ($_POST['critere_presences_operateur'] == 'moins') {
                                                    echo ' selected="selected"';
                                                } ?>>moins de
                                                </option>

                                            </select> <input class="form-control" type="number" name="critere_presences"
                                                             value="<?php if ($_POST['critere_presences'] == '') {
                                                                 echo '0';
                                                             } else {
                                                                 echo $_POST['critere_presences'];
                                                             } ?>" style="width:80px"> fois <i>(mettre 0 pour ne pas
                                                prendre en compte les présences)</i>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Afficher les résultats :</td>
                                        <td>
                                            <select name="critere_type" class="form-control" style="width:300px">
                                                <option value="liste"<?php if ($_POST['critere_type'] == 'liste') {
                                                    echo ' selected="selected"';
                                                } ?>> Liste des élèves
                                                </option>
                                                <option value="classe"<?php if ($_POST['critere_type'] == 'classe') {
                                                    echo ' selected="selected"';
                                                } ?> style="margin-left:20px"> Par classe
                                                </option>
                                                <!--<option value="filiere"<?php if ($_POST['critere_type'] == 'filiere') {
                                                    echo ' selected="selected"';
                                                } ?> style="margin-left:20px"> Par filière</option>-->
                                                <option value="sexe"<?php if ($_POST['critere_type'] == 'sexe') {
                                                    echo ' selected="selected"';
                                                } ?> style="margin-left:20px"> Par sexe
                                                </option>
                                                <option
                                                    value="etablissement"<?php if ($_POST['critere_type'] == 'etablissement') {
                                                    echo ' selected="selected"';
                                                } ?> style="margin-left:20px"> Par établissement
                                                </option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Trier par :</td>
                                        <td>
                                            <select name="critere_tri" class="form-control"
                                                    style="width:150px;display:inline">
                                                <option
                                                    value="NOM_ELEVE"<?php if ($_POST['critere_tri'] == 'NOM_ELEVE') {
                                                    echo ' selected="selected"';
                                                } ?>> Nom
                                                </option>
                                                <option
                                                    value="eleves.PRENOM"<?php if ($_POST['critere_tri'] == 'eleves.PRENOM') {
                                                    echo ' selected="selected"';
                                                } ?>> Prénom
                                                </option>
                                                <option
                                                    value="eleves.SEXE"<?php if ($_POST['critere_tri'] == 'eleves.SEXE') {
                                                    echo ' selected="selected"';
                                                } ?>> Sexe
                                                </option>
                                                <option
                                                    value="eleves.DATE_DE_NAISSANCE"<?php if ($_POST['critere_tri'] == 'eleves.DATE_DE_NAISSANCE') {
                                                    echo ' selected="selected"';
                                                } ?>> Date de naissance
                                                </option>
                                                <option
                                                    value="inscrit.ID_CLASSE"<?php if ($_POST['critere_tri'] == 'inscrit.ID_CLASSE') {
                                                    echo ' selected="selected"';
                                                } ?>> Classe
                                                </option>
                                                <option
                                                    value="inscrit.ID_FILIERES"<?php if ($_POST['critere_tri'] == 'inscrit.ID_FILIERES') {
                                                    echo ' selected="selected"';
                                                } ?>> Filière
                                                </option>
                                                <option
                                                    value="inscrit.ID"<?php if ($_POST['critere_tri'] == 'inscrit.ID') {
                                                    echo ' selected="selected"';
                                                } ?>> Etablissement
                                                </option>
                                                <option
                                                    value="inscrit.ID_LV1"<?php if ($_POST['critere_tri'] == 'inscrit.ID_LV1') {
                                                    echo ' selected="selected"';
                                                } ?>> LV1
                                                </option>
                                                <option
                                                    value="inscrit.ID_LV2"<?php if ($_POST['critere_tri'] == 'inscrit.ID_LV2') {
                                                    echo ' selected="selected"';
                                                } ?>> LV2
                                                </option>
                                                <option
                                                    value="eleves.ADRESSE_POSTALE"<?php if ($_POST['critere_tri'] == 'eleves.ADRESSE_POSTALE') {
                                                    echo ' selected="selected"';
                                                } ?>> Adresse
                                                </option>
                                                <option
                                                    value="eleves.CODE_POSTAL"<?php if ($_POST['critere_tri'] == 'eleves.CODE_POSTAL') {
                                                    echo ' selected="selected"';
                                                } ?>> Code postal
                                                </option>
                                                <option
                                                    value="eleves.VILLE"<?php if ($_POST['critere_tri'] == 'eleves.VILLE') {
                                                    echo ' selected="selected"';
                                                } ?>> Ville
                                                </option>
                                            </select> <select name="critere_tri_croissant" class="form-control"
                                                              style="width:125px;display:inline">
                                                <option value="ASC"<?php if ($_POST['critere_tri_croissant'] == 'ASC') {
                                                    echo ' selected="selected"';
                                                } ?>> Croissant
                                                </option>
                                                <option
                                                    value="DESC"<?php if ($_POST['critere_tri_croissant'] == 'DESC') {
                                                    echo ' selected="selected"';
                                                } ?>> Décroissant
                                                </option>
                                            </select>
                                        </td>

                                    <tr>
                                        <td colspan="2"><input type="submit" class="btn btn-success" value="Valider"
                                                               style="width:300px;margin-right:50px"> <input
                                                type="reset" class="btn btn-warning" value="Remettre à zéro"></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <hr>

                                <?php
                                function getNomParametre($id)
                                {
                                    include_once('include/class.pdo.php');
                                    $mysqli = mysqli_connect("mysql51-52.perso", "associatryagain", "E2x6q5Li");
                                    //$base = mysqli_connect (PdoBD::$stats, PdoBD::$user, PdoBD::$mdp);
                                    mysqli_select_db($mysqli, "associatryagain");
                                    $mysqli->set_charset("utf8mb4");
                                    //include ("include/class.pdo.php");
                                    $resultat = mysqli_query($mysqli, 'SELECT ID,NOM FROM parametre WHERE ID = "' . $id . '" LIMIT 0,1') or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());
                                    while ($donnees = mysqli_fetch_array($resultat)) {
                                        return $donnees['NOM'];
                                    }
                                }

                                // Formulaire envoyé
                                if (isset($_POST['critere_annee'])) {

                                    //-----------------------------------------------------------------------------
                                    // Requête
                                    $requete = 'SELECT ' . $villeExtranet . '_eleves.ID_ELEVE, ' . $villeExtranet . '_inscrit.ID_LV1, ' . $villeExtranet . '_inscrit.ID_LV2, ' . $villeExtranet . '_inscrit.ANNEE, ' . $villeExtranet . '_inscrit.ID AS ID_ETABLISSEMENT, ' . $villeExtranet . '_inscrit.ID_FILIERES, ' . $villeExtranet . '_eleves.SEXE, ' . $villeExtranet . '_eleves.NOM as NOM_ELEVE, ' . $villeExtranet . '_eleves.PRENOM, ' . $villeExtranet . '_eleves.DATE_DE_NAISSANCE, ' . $villeExtranet . '_eleves.TÉLÉPHONE_DES_PARENTS AS telparents, ' . $villeExtranet . '_eleves.EMAIL_DES_PARENTS, ' . $villeExtranet . '_eleves.TÉLÉPHONE_DE_L_ENFANT AS telenfant, ' . $villeExtranet . '_eleves.EMAIL_DE_L_ENFANT,  ' . $villeExtranet . '_eleves.ADRESSE_POSTALE, ' . $villeExtranet . '_eleves.CODE_POSTAL, ' . $villeExtranet . '_eleves.VILLE, ' . $villeExtranet . '_inscrit.ID_ELEVE, ' . $villeExtranet . '_inscrit.ID_CLASSE, parametre.ID, parametre.NOM as NOM_PARAMETRE
                              FROM ' . $villeExtranet . '_eleves
                              INNER JOIN ' . $villeExtranet . '_inscrit ON ' . $villeExtranet . '_eleves.ID_ELEVE = ' . $villeExtranet . '_inscrit.ID_ELEVE
                              INNER JOIN parametre ON ' . $villeExtranet . '_inscrit.ID_CLASSE = parametre.ID
                              WHERE';

                                    // Par sexe
                                    if ($_POST['critere_sexe_H'] == 'H' && $_POST['critere_sexe_F'] == 'F') {
                                        $requete .= " (" . $villeExtranet . "_eleves.SEXE = 'H' OR " . $villeExtranet . "_eleves.SEXE = 'F')";
                                    }
                                    if ($_POST['critere_sexe_H'] == '' && $_POST['critere_sexe_F'] == '') {
                                        $requete .= " (" . $villeExtranet . "_eleves.SEXE = 'H' OR " . $villeExtranet . "_eleves.SEXE = 'F')";
                                    }
                                    if ($_POST['critere_sexe_H'] == 'H' && $_POST['critere_sexe_F'] == '') {
                                        $requete .= " " . $villeExtranet . "_eleves.SEXE = 'H'";
                                    }
                                    if ($_POST['critere_sexe_H'] == '' && $_POST['critere_sexe_F'] == 'F') {
                                        $requete .= " " . $villeExtranet . "_eleves.SEXE = 'F'";
                                    }

                                    // Par année
                                    if ($_POST['critere_annee'] != '') {

                                        $requete .= ' AND ' . $villeExtranet . '_inscrit.ANNEE = \'' . $_POST['critere_annee'] . '\'';

                                    }

                                    // Par classe
                                    if (!empty($_POST['critere_classe'])) {
                                        $requete .= ' AND (';
                                        $i = 0;
                                        foreach ($_POST['critere_classe'] as $selectValue) {
                                            if ($i > 0) {
                                                $requete .= ' OR';
                                            }
                                            $requete .= ' ID_CLASSE = "' . $selectValue . '"';
                                            $i++;
                                        }
                                        $requete .= ')';
                                    }

                                    // Par filiere
                                    if (!empty($_POST['critere_filiere'])) {
                                        $requete .= ' AND (';
                                        $i = 0;
                                        foreach ($_POST['critere_filiere'] as $selectValue) {
                                            if ($i > 0) {
                                                $requete .= ' OR';
                                            }
                                            $requete .= ' ' . $villeExtranet . '_inscrit.ID_FILIERES = "' . $selectValue . '"';
                                            $i++;
                                        }
                                        $requete .= ')';
                                    }

                                    // Par etablissement
                                    if (!empty($_POST['critere_etablissement'])) {
                                        $requete .= ' AND (';
                                        $i = 0;
                                        foreach ($_POST['critere_etablissement'] as $selectValue) {
                                            if ($i > 0) {
                                                $requete .= ' OR';
                                            }
                                            $requete .= ' ' . $villeExtranet . '_inscrit.ID = "' . $selectValue . '"';
                                            $i++;
                                        }
                                        $requete .= ')';
                                    }

                                    // Par langue
                                    if (!empty($_POST['critere_langue'])) {
                                        $requete .= ' AND (';
                                        $i = 0;
                                        foreach ($_POST['critere_langue'] as $selectValue) {
                                            if ($i > 0) {
                                                $requete .= ' OR';
                                            }
                                            $requete .= ' (' . $villeExtranet . '_inscrit.ID_LV1 = "' . $selectValue . '" OR ' . $villeExtranet . '_inscrit.ID_LV2 = "' . $selectValue . '")';
                                            $i++;
                                        }
                                        $requete .= ')';
                                    }

                                    // Par ville
                                    if (!empty($_POST['critere_ville'])) {
                                        $requete .= ' AND (';
                                        $i = 0;
                                        foreach ($_POST['critere_ville'] as $selectValue) {
                                            if ($i > 0) {
                                                $requete .= ' OR';
                                            }
                                            $requete .= ' VILLE = "' . $selectValue . '"';
                                            $i++;
                                        }
                                        $requete .= ')';
                                    }

                                    // Par présences
                                    if (($_POST['critere_presences'] != '')) {

                                        if ($_POST['critere_presences'] != 0) {

                                            if ($_POST['critere_presences_operateur'] == 'moins') {
                                                $operateur = '<';
                                            }
                                            if ($_POST['critere_presences_operateur'] == 'plus') {
                                                $operateur = '>';
                                            }

                                            $requete .= ' AND (SELECT COUNT(*) FROM `' . $villeExtranet . '_appel` WHERE ' . $villeExtranet . '_appel.ID_ELEVE = ' . $villeExtranet . '_eleves.ID_ELEVE) ' . $operateur . ' ' . $_POST['critere_presences'];

                                        }
                                    }

                                    // Par stage
                                    if (($_POST['critere_stage'] != '')) {
                                        if ($_POST['critere_stage'] == 'soutien') {
                                            $requete .= ' AND (SELECT COUNT(*) FROM `' . $villeExtranet . '_appel` WHERE ' . $villeExtranet . '_appel.ID_ELEVE = ' . $villeExtranet . '_eleves.ID_ELEVE) > 0';
                                        } else {
                                            if ($_POST['critere_stage'] != 'tout') {
                                                $requete .= ' AND (SELECT COUNT(*) FROM `PRÉSENCES_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON PRÉSENCES_STAGE.`ID_INSCRIPTIONS` = INSCRIPTIONS_STAGE.ID_INSCRIPTIONS INNER JOIN ELEVE_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE ELEVE_STAGE.ID_ELEVE_ANCIENNE_TABLE = ' . $villeExtranet . '_eleves.ID_ELEVE AND INSCRIPTIONS_STAGE.ID_STAGE = ' . $_POST['critere_stage'] . ') > 0';
                                            }
                                        }
                                    }

                                    // Connexion

                                    $mysqli = new mysqli("associatryagain.mysql.db", "associatryagain", "E2x6q5Li", "associatryagain");

                                    // Check connection
                                    if ($mysqli->connect_errno) {
                                        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                                        exit();
                                    }

                                    $db = mysqli_select_db($mysqli, "associatryagain");
                                    $mysqli->set_charset("utf8mb4");


                                    //-----------------------------------------------------------------------------

                                    // Affichage par liste
                                    if ($_POST['critere_type'] == 'liste') {

                                        $requete .= ' ORDER BY ' . $_POST["critere_tri"] . ' ' . $_POST["critere_tri_croissant"];
                                        $resultat = mysqli_query($mysqli, $requete);

                                        $nbStages = 0;
                                        foreach ($lesStages as $unStage) {
                                            $nbStages++;
                                        }

                                        $code = '
                                          <table class="table" id="resultats" style="font-size:11px">
                                          <thead>
                                          <tr>
                                          <th colspan="4" style="text-align:center;background:#E6E6E6;border-bottom:none;border-right:1px solid black">INFORMATIONS</th>
                                          <th colspan="5" style="text-align:center;background:#E6E6E6;border-right:1px solid black">SCOLARITE</th>
                                          <th style="text-align:center;background:#E6E6E6;border-right:1px solid black" colspan="' . ($nbStages + 1) . '">EVENEMENTS</th>
                                          <th colspan="9" style="text-align:center;background:#E6E6E6">COORDONNEES</th>

                                          </tr>
                                          <tr>
                                          <th style="background:#E6E6E6">NOM</th>
                                          <th style="background:#E6E6E6">PRENOM</th>
                                          <th style="background:#E6E6E6">SEXE</th>
                                          <th style="background:#E6E6E6;border-right:1px solid black">DATE DE NAISSANCE</th>

                                          <th style="background:#E6E6E6">CLASSE</th>
                                          <th style="background:#E6E6E6">FILIERE</th>
                                          <th style="background:#E6E6E6">ETABLISSEMENT</th>
                                          <th style="background:#E6E6E6">LV1</th>
                                          <th style="background:#E6E6E6;border-right:1px solid black">LV2</th>

                                          <th style="background:#E6E6E6">SOUTIEN SCOLAIRE</th>';
                                        foreach ($lesStages as $unStage) {
                                            $code .= '<th style="background:#E6E6E6">' . strtoupper(utf8_decode(stripslashes($unStage['NOM_STAGE']))) . '</th>';
                                        }
                                        $code .= '

                                          <th style="background:#E6E6E6;border-left:1px solid black">TEL PARENTS</th>
                                          <th style="background:#E6E6E6">MAIL PARENTS</th>
                                          <th style="background:#E6E6E6">TEL ENFANT</th>
                                          <th style="background:#E6E6E6">MAIL ENFANT</th>
                                          <th style="background:#E6E6E6">ADRESSE</th>
                                          <th style="background:#E6E6E6">CODE POSTAL</th>
                                          <th style="background:#E6E6E6">VILLE</th>

                                          </tr>
                                          </thead>
                                          <tbody>';
                                        $compteur = 0;
                                        $emails = '';
                                        $tels = '';
                                        $gmail = 'Name,E-mail 1 - Value,Phone 1 - Value';

                                        while ($donnees = mysqli_fetch_array($resultat)) {

                                            // Informations
                                            $filiere = getNomParametre($donnees['ID_FILIERES']);
                                            $classe = getNomParametre($donnees['ID_CLASSE']);
                                            $etablissement = getNomParametre($donnees['ID_ETABLISSEMENT']);
                                            $lv1 = getNomParametre($donnees['ID_LV1']);
                                            $lv2 = getNomParametre($donnees['ID_LV2']);


                                            // Enlever les emails vides
                                            if ($donnees['EMAIL_DES_PARENTS'] == 'a@a' || $donnees['EMAIL_DES_PARENTS'] == 'a@a.fr') {
                                                $donnees['EMAIL_DES_PARENTS'] = '';
                                            }
                                            if ($donnees['EMAIL_DE_L_ENFANT'] == 'a@a' || $donnees['EMAIL_DE_L_ENFANT'] == 'a@a.fr') {
                                                $donnees['EMAIL_DE_L_ENFANT'] = '';
                                            }

                                            // On ajoute les coordonnées à la liste
                                            if ($donnees['EMAIL_DES_PARENTS'] != '') {
                                                $emails .= $donnees['EMAIL_DES_PARENTS'] . ',';
                                            }

                                            // Contacts Gmail
                                            if ($donnees['EMAIL_DES_PARENTS'] != '') {
                                                $gmail .= $donnees['NOM_ELEVE'] . ' ' . $donnees['PRENOM'] . ',' . $donnees['EMAIL_DES_PARENTS'] . ',' . $donnees['telparents'] . '
                                              ';
                                            }

                                            // Nettoyage des téléphones
                                            if ($donnees['telparents'] != '') {

                                                // Ajout d'un zéro au début si manquant
                                                if (substr($donnees['telparents'], 0, 1) != '0') {
                                                    $donnees['telparents'] = '0' . $donnees['telparents'];
                                                }

                                                // Suppression des numéros de fixe
                                                if ((substr($donnees['telparents'], 1, 1) == '6') || (substr($donnees['telparents'], 1, 1) == '7')) {

                                                    // Si le numéro n'est pas déjà dans la liste
                                                    if (!preg_match('#' . $donnees['telparents'] . '#', $tels)) {

                                                        // On ne garde que les premiers caractères
                                                        $donnees['telparents'] = substr($donnees['telparents'], 0, 10);

                                                        // On ajoute le tel à la liste
                                                        $tels .= $donnees['telparents'] . ',';
                                                    }
                                                }
                                            }

                                            $code .= '<tr>
                                              <td><a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $donnees['ID_ELEVE'] . '">' . $donnees['NOM_ELEVE'] . '</a></td>
                                              <td><a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $donnees['ID_ELEVE'] . '">' . $donnees['PRENOM'] . '</a></td>
                                              <td>' . $donnees['SEXE'] . '</td>
                                              <td style="border-right:1px solid black">' . $donnees['DATE_DE_NAISSANCE'] . '</td>

                                              <td>' . $classe . '</td>
                                              <td>' . $filiere . '</td>
                                              <td>' . $etablissement . '</td>
                                              <td>' . $lv1 . '</td>
                                              <td style="border-right:1px solid black">' . $lv2 . '</td>';

                                            $nb_presences = $pdo->executerRequete2('SELECT COUNT(*) FROM `' . $villeExtranet . '_appel` WHERE `' . $villeExtranet . '_appel`.`ID_ELEVE` = ' . $donnees['ID_ELEVE']);


                                            if ($nb_presences[0]['COUNT(*)'] == 0) {
                                                $code .= '<td style="text-align:center"><span class="glyphicon glyphicon-remove"></span></td>';
                                            } else {
                                                $code .= '<td style="text-align:center">' . $nb_presences[0]['COUNT(*)'] . '</td>';
                                            }


                                            foreach ($lesStages as $unStage) {

                                                $presencesStage = $pdo->executerRequete2('SELECT COUNT(*) FROM `PRÉSENCES_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON PRÉSENCES_STAGE.`ID_INSCRIPTIONS` = INSCRIPTIONS_STAGE.ID_INSCRIPTIONS INNER JOIN ELEVE_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE ELEVE_STAGE.ID_ELEVE_ANCIENNE_TABLE = ' . $donnees['ID_ELEVE'] . ' AND INSCRIPTIONS_STAGE.ID_STAGE = ' . $unStage['ID_STAGE'] . '');


                                                // Si l'élève est inscrit au stage
                                                if ($presencesStage[0]['COUNT(*)'] == 0) {

                                                    $code .= '<td style="text-align:center"><span class="glyphicon glyphicon-remove"></span></td>';

                                                    // Si l'élève n'est pas inscrit au stage
                                                } else {

                                                    $code .= '<td style="text-align:center">' . $presencesStage[0]['COUNT(*)'] . '</td>';
                                                }
                                            }

                                            $code .= '

                                              <td style="border-left:1px solid black"><a href="tel:' . $donnees['telparents'] . '">' . $donnees['telparents'] . '</a></td>
                                              <td><a href="mailto:' . $donnees['EMAIL_DES_PARENTS'] . '">' . $donnees['EMAIL_DES_PARENTS'] . '</a></td>
                                              <td><a href="tel:' . $donnees['telenfant'] . '">' . $donnees['telenfant'] . '</a></td>
                                              <td><a href="mailto:' . $donnees['EMAIL_DE_L_ENFANT'] . '">' . $donnees['EMAIL_DE_L_ENFANT'] . '</a></td>
                                              <td>' . $donnees['ADRESSE_POSTALE'] . '</td>
                                              <td>' . $donnees['CODE_POSTAL'] . '</td>
                                              <td>' . $donnees['VILLE'] . '</td>

                                              </tr>';

                                            // Compteur du nombre de résultats;
                                            $compteur++;


                                        }
                                        $code .= '</tbody></table>';

                                        echo '<p id="compteur" style="font-weight:bold">' . utf8_encode($compteur) . ' résultats</p>
                                            <p>
                                            <a href="index.php?choixTraitement=administrateur&action=StatsCSV&critere_presences_operateur=' . $POST['critere_presences_operateur'] . '&critere_presences=' . $_POST['critere_presences'] . '&annee=' . $_POST['critere_annee'] . '&req=' . $requete . '" class="btn btn-info">Exporter sur Excel</a><br>
                                            <input type="button" class="form-control" class="btn btn-info" onclick="document.getElementById(\'email_parents\').style.display=\'block\';" value="Contacter ces parents" style="width:300px">
                                            <div id="email_parents" style="display:none;margin:10px;border:1px solid gray;padding:10px">
                                            <h3>Emails</h3>
                                            <ol>
                                            <li>Copier ces adresses mail (CTRL + A et CTRL + C)</li>
                                            <li><a href="http://association-ore.fr/mail/?_task=mail&_action=compose" target="_blank">Aller sur l\'interface mail Roundcube</a></li>
                                            <li>Coller les emails dans le champ CCI (CTRL + V)</li>
                                            </ol>
                                            <textarea id="email_parents_liste" class="form-control">' . $emails . '</textarea><hr>
                                            <h3>Téléphones</h3>
                                            <ol>
                                            <li>Copier ces téléphones (CTRL + A et CTRL + C)</li>
                                            <li>Coller dans un portable</li>
                                            </ol>
                                            <textarea id="email_enfants_liste" class="form-control">' . $tels . '</textarea><br>
                                            <h3>Contacts Gmail</h3>
                                            <ol>
                                            <li>Copier le texte (CTRL + A et CTRL + C)</li>
                                            <li>Enregistrer dans un fichier .csv</li>
                                            <li>Importer dans Google Contacts</li>
                                            </ol>
                                            <textarea id="email_enfants_liste" class="form-control">' . $gmail . '</textarea><br>
                                            </div>
                                            </p>';
                                        echo utf8_encode($code);
                                    }

                                    // Affichage par classe, filiere ou établissement
                                    if ($_POST['critere_type'] == 'classe' || $_POST['critere_type'] == 'filiere' || $_POST['critere_type'] == 'etablissement' || $_POST['critere_type'] == 'sexe') {

                                        // Tri
                                        if ($_POST['critere_type'] == 'classe') {
                                            $requete .= ' ORDER BY ' . $villeExtranet . '_inscrit.ID_CLASSE';
                                        }
                                        if ($_POST['critere_type'] == 'filiere') {
                                            $requete .= ' ORDER BY ' . $villeExtranet . '_inscrit.ID_FILIERES';
                                        }
                                        if ($_POST['critere_type'] == 'etablissement') {
                                            $requete .= ' ORDER BY ID_ETABLISSEMENT';
                                        }
                                        if ($_POST['critere_type'] == 'sexe') {
                                            $requete .= ' ORDER BY ' . $villeExtranet . '_eleves.SEXE';
                                        }

                                        $stats = array();
                                        $compteur = 0;

                                        $resultat = mysqli_query($mysqli, utf8_decode($requete)) or die('Erreur SQL !<br />' . $sql . '<br />' . mysqli_error());
                                        var_dump($resultat);
                                        while ($donnees = mysqli_fetch_array($resultat)) {

                                            // Critère des présences
                                            $nb_presences = $pdo->executerRequete('SELECT COUNT(`SEANCE`) FROM `' . $villeExtranet . '_appel` WHERE `ID_ELEVE` = ' . $donnees['ID_ELEVE'] . ' AND `SEANCE` > "' . $_POST['critere_annee'] . '-09-01" AND `SEANCE` < "' . ($_POST['critere_annee'] + 1) . '-07-30"');
                                            if ($_POST['critere_presences'] == '') {
                                                $_POST['critere_presences'] = '0';
                                            }
                                            $garder = true;
                                            if ($_POST['critere_presences_operateur'] == 'moins') {
                                                if ($nb_presences[0] >= $_POST['critere_presences']) {
                                                    $garder = false;
                                                }
                                            }
                                            if ($_POST['critere_presences_operateur'] == 'plus') {
                                                if ($nb_presences[0] <= $_POST['critere_presences']) {
                                                    $garder = false;
                                                }
                                            }

                                            if ($_POST['critere_presences'] == '' || $_POST['critere_presences'] == '0') {
                                                $garder = true;
                                            }

                                            if ($garder) {

                                                // On compte les résultats
                                                if ($_POST['critere_type'] == 'classe') {
                                                    $nb = $stats[$donnees['ID_CLASSE']];
                                                    $nb++;
                                                    $stats[$donnees['ID_CLASSE']] = $nb;
                                                }
                                                if ($_POST['critere_type'] == 'filiere') {
                                                    $nb = $stats[$donnees['ID_FILIERES']];
                                                    $nb++;
                                                    $stats[$donnees['ID_FILIERE']] = $nb;
                                                }
                                                if ($_POST['critere_type'] == 'etablissement') {
                                                    $nb = $stats[$donnees['ID_ETABLISSEMENT']];
                                                    $nb++;
                                                    $stats[$donnees['ID_ETABLISSEMENT']] = $nb;
                                                }
                                                if ($_POST['critere_type'] == 'sexe') {
                                                    if ($donnees['SEXE'] == 'G') {
                                                        $stats['G'] = $stats['G'] + 1;
                                                    }
                                                    if ($donnees['SEXE'] == 'F') {
                                                        $stats['F'] = $stats['F'] + 1;
                                                    }
                                                }
                                                $compteur++;
                                            }
                                        }
                                        ?>
                                        <p id="compteur" style="font-weight:bold"><?php echo $compteur; ?> résultats</p>
                                        <canvas id="myChart" width="400" height="200"></canvas>
                                        <script type="text/javascript">
                                            var ctx = document.getElementById("myChart");
                                            var myChart = new Chart(ctx, {
                                                type: 'bar',
                                                data: {
                                                    labels: [<?php
                                                        $noms = array_keys($stats);
                                                        $i = 0;
                                                        if ($_POST['critere_type'] == 'classe' || $_POST['critere_type'] == 'filiere' || $_POST['critere_type'] == 'etablissement') {
                                                            foreach ($noms as $nom) {
                                                                echo '"' . utf8_encode(getNomParametre($nom)) . ' (' . $stats[$nom] . ')",';
                                                                if (count($noms) < $i) {
                                                                    echo ',';
                                                                }
                                                                $i++;
                                                            }
                                                        }
                                                        if ($_POST['critere_type'] == 'sexe') {
                                                            echo '"Filles (' . $stats['F'] . ')",';
                                                            echo '"Garçons (' . $stats['G'] . ')"';

                                                        }
                                                        ?>],
                                                    datasets: [{
                                                        <?php if ($_POST['critere_type'] == 'classe') {
                                                            echo "label: 'Répartition par classe',";
                                                        } ?>
                                                        <?php if ($_POST['critere_type'] == 'filiere') {
                                                            echo "label: 'Répartition par filière',";
                                                        } ?>
                                                        <?php if ($_POST['critere_type'] == 'etablissement') {
                                                            echo "label: 'Répartition par établissement',";
                                                        } ?>
                                                        <?php if ($_POST['critere_type'] == 'sexe') {
                                                            echo "label: 'Répartition par sexe',";
                                                        } ?>
                                                        data: [<?php

                                                            $y = 0;
                                                            foreach ($stats as $stat) {
                                                                echo $stat;
                                                                $y++;
                                                                if (count($stats) != $y) {
                                                                    echo ',';
                                                                }
                                                            } ?>],
                                                        backgroundColor: [
                                                            'rgba(255, 0, 255, 1)',
                                                            'rgba(51, 102, 255, 1)',
                                                            'rgba(255, 0, 0, 1)',
                                                            'rgba(255, 153, 0, 1)',
                                                            'rgba(153, 204, 0, 1)',
                                                            'rgba(51, 153, 102, 1)',
                                                            'rgba(51, 204, 204, 1)',
                                                            'rgba(255, 159, 64, 1)',
                                                            'rgba(128, 0, 128, 1)',
                                                            'rgba(150, 150, 150, 1)',
                                                            'rgba(255, 255, 0, 1)',
                                                            'rgba(51, 51, 153, 1)'
                                                        ],
                                                        borderColor: [
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)',
                                                            'rgba(0,0,0,1)'
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true
                                                            }
                                                        }]
                                                    }
                                                }
                                            });
                                        </script>
                                        <?php
                                    }


                                    echo '<hr><p><b>Requete</b><br><small>' . $requete . '</small></p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>


    <script type="text/javascript">
        $('#onglets a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    </script>

</div>
