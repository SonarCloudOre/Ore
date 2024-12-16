<div id="contenu">


    <?php // TODO: enlever ce qui est avant ?>

    <div class="row">
        <div class="col-md-12">

            <div class="main-card mb-3 card">
                <div class="card-body">
                    <center><h2 class="card-title">Statistiques des élèves</h2></center>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-2">
            <div class="card mb-3 bg-primary widget-chart text-white card-border">
                <div class="icon-wrapper rounded-circle">
                    <div class="icon-wrapper-bg bg-white opacity-1"></div>
                    <i class="lnr-cog text-white"></i>
                </div>
                <div class="widget-numbers"><b><?php echo $nbEleves['COUNT(*)']; ?></b></div>
                <div class="widget-subheading"><b>Elèves inscrits</b></div>
                <div class="widget-description text-success">
                    <span class="pl-1"><b><?php if ($differenceEleves == 0) {
                                echo '<span style="color:orange;background-color:white;border-radius:5px">= ' . $differenceEleves . ' %</span>';
                            } ?><?php if ($differenceEleves > 0) {
                                echo '<span style="color:green;background-color:white;border-radius:5px">➚ ' . $differenceEleves . ' %</span>';
                            }
                            if ($differenceEleves < 0) {
                                echo '<span style="color:red;background-color:white;border-radius:5px">➘ ' . $differenceEleves . ' %</span>';
                            } ?></b></span>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card mb-3 bg-success widget-chart text-white card-border">
                <div class="icon-wrapper rounded-circle">
                    <div class="icon-wrapper-bg bg-white opacity-10"></div>
                    <i class="lnr-screen text-success"></i>
                </div>
                <div class="widget-numbers"><b><?php echo $nbFamilles; ?></b></div>
                <div class="widget-subheading"><b>Familles inscrites</b></div>
                <div class="widget-description text-white">
                    <span class="pr-1"><b><?php if ($differenceFamilles == 0) {
                                echo '<span style="color:orange;background-color:white;border-radius:5px">= ' . $differenceFamilles . ' %</span>';
                            } ?><?php if ($differenceFamilles > 0) {
                                echo '<span style="color:green;background-color:white;border-radius:5px">➚ ' . $differenceFamilles . ' %</span>';
                            }
                            if ($differenceFamilles < 0) {
                                echo '<span style="color:red;background-color:white;border-radius:5px">➘ ' . $differenceFamilles . ' %</span>';
                            } ?></b></span>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card mb-3 bg-warning widget-chart text-white card-border">
                <div class="icon-wrapper rounded-circle">
                    <div class="icon-wrapper-bg bg-white opacity-2"></div>
                    <i class="lnr-laptop-phone text-white"></i>
                </div>
                <div class="widget-numbers"><b><?php echo $nbFamillesAvecRdv[0]['COUNT(*)']; ?></b></div>
                <div class="widget-subheading"><b>Familles ayant eu RDV</b></div>
                <div class="widget-description text-white">
                    <span class="pl-1"></span>
                    <i></i>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card mb-3 widget-chart text-white card-border" style="background-color:#c1121f ;">
                <div class="icon-wrapper rounded-circle">
                    <div class="icon-wrapper-bg bg-info opacity-5"></div>
                    <i class="lnr-graduation-hat text-white"></i>
                </div>
                <div class="widget-numbers"><b><?php echo $nbFamillesAvecRdvBsb[0]['COUNT(*)']; ?></b></div>
                <div class="widget-subheading"><b>Familles ayant eu RDV avec un étudiant BSB</b></div>
                <div class="widget-description text-info">
                </div>
            </div>
        </div>
        <div class="col-md-2 card mb-3 bg-ripe-malin">
            <div class="widget-chart text-left">
                <div class="progress-circle-wrapper">
                    <div class="circle-progress d-inline-block circle-progress-dark">
                        <small style="color: white"></small>
                    </div>
                </div>
                <div class="widget-chart-content">
                    <div class="widget-subheading" style="color: white"><b>Eleves ayant payés</b></div>
                    <div class="widget-numbers" style="color: white"><b><?php echo $nbElevesPayes['COUNT(*)']; ?></b>
                    </div>
                    <div class="widget-description text-info">
                        <span class="pl-1"><i><small style="color: white"><?php if ($nbEleves['COUNT(*)'] > 0) {
                                        echo 'sur un total de ' . $nbEleves['COUNT(*)'] . ' élèves';
                                    } ?></small></i></span>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-2">
            <div class="card mb-3 bg-info widget-chart text-white card-border">
                <div class="icon-wrapper rounded">
                    <div class="icon-wrapper-bg bg-focus opacity-5"></div>
                    <i class="pe-7s-photo text-white"></i>
                </div>
                <div class="widget-numbers"><b><?php echo $moyennePresencesEleves; ?></b> élèves /
                    <b><?php echo $moyennePresencesIntervenants; ?></b> inter.<br></div>
                <div class="widget-subheading"><b>Moyenne des présences</b></div>
                <div class="widget-description text-white">
                    <span
                        class="pl-1"><i><small>1 inter. pour <?php echo $nbElevesParIntervenant; ?> élève(s)</small></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-5 mr-5 ml-4">
            <div class="card mb-3 widget-chart text-left" style="background-color:#561F8F">
                <div class="widget-chart-content">
                    <div class="progress-circle-wrapper">
                        <div class="circle-progress d-inline-block circle-progress-dark" id="circle-progress-dark2">
                            <small style="color: white"></small>
                        </div>
                    </div>
                    <div class="widget-subheading" style="color: white"><b>Nombre de famille adherents Global</b></div>
                    <div class="widget-numbers" style="color: white"><b><?php echo $nbAdherents; ?></b>
                    </div>
                    <div class="widget-description text-info">
                        <span class="pl-1"><i><small style="color: white"><?php if ($nbAdherents > 0) {
                                        echo 'sur un total de ' . /*$nbFamillesTotal*/ $nbFamilles . ' famille';
                                    } ?></small></i></span>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-5 ml-5">
            <div class="card mb-3 widget-chart text-left" style="background-color:#561F8F">
                <div class="widget-chart-content">
                    <div class="progress-circle-wrapper">
                        <div class="circle-progress d-inline-block circle-progress-dark" id="circle-progress-dark3">
                            <small style="color: white"></small>
                        </div>
                    </div>
                    <div class="widget-subheading" style="color: white"><b>Nombre famille adherents Caf</b></div>
                    <div class="widget-numbers" style="color: white"><b><?php echo $nbAdherentsCaf; ?></b>
                    </div>
                    <div class="widget-description text-info">
                        <span class="pl-1"><i><small style="color: white"><?php if ($nbAdherentsCaf > 0) {
                                        echo 'sur un total de ' .  /*$nbFamillesTotal*/$nbFamilles . ' famille';
                                    } ?></small></i></span>
                    </div>
                </div>
            </div>

        </div>
        <!--Bloc Nb d'eleve en soutien scolaire
            <div class="col-md-4">
            <div class="card mb-3 bg-ripe-malin widget-chart text-left">
                <div class="widget-chart-content">
                    <div class="progress-circle-wrapper">
                        <div class="circle-progress d-inline-block circle-progress-dark" id="circle-progress-dark4">
                            <small style="color: white"></small>
                        </div>
                    </div>
                    <div class="widget-subheading" style="color: white"><b>Nombre d'eleve en soutien scolaire</b></div>
                    <div class="widget-numbers" style="color: white"><b><?php echo $nbEleveSoutien; ?></b>
                    </div>
                    <div class="widget-description text-info">
                        <span class="pl-1"><i><small style="color: white"><?php if ($nbEleveSoutien > 0) {
                                        echo 'sur un total de ' .  $nbEleves['COUNT(*)'] . ' eleves';
                                    } ?></small></i></span>
                    </div>
                </div>
            </div>

        </div>-->
    </div>


    <div class="row">
        <div class="col-md-6">

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
        <!--nombre de filles et de garçon par classe-->
<div class="col-md-12 mb-4">
    <div class="main-card mb-10 card">
        <div class="card-body">
            <h4 class="card-title text-center">Nombre de filles et de garçons par classe</h4>
            <div class="d-flex justify-content-center">
                <table class="tableFilleGarcon" style="border-collapse: separate; border-spacing: 0 10px;">
                <thead>
                    <tr>
                        <th width="120">Classe</th>
                        <th width="100" align="center">Filles</th>
                        <th width="100" align="center">Garçons</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nbSexeParClasse as $ligne) { ?>
                        <tr>
                            <td><?= htmlspecialchars($ligne['Classes']) ?></td>
                            <td><?= htmlspecialchars($ligne['Filles']) ?></td>
                            <td><?= htmlspecialchars($ligne['Garcons']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



	    			<div class="col-lg-6">
					<div class="main-card mb-3 card">
					<div class="card-body">

					<!-- Répartition par ville -->
					<h4 class="card-title"><center>Répartition par ville</center></h4>
					<div class="bloc_graphique" style="width:530px">
					<?php
					$couleurs = array('red','blue','green','pink','orange','brown','gray','lime','maroon','olive','navy','teal','yellow','purple');
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

					foreach($nbElevesParVille as $uneStat) {
					if($i > 0) { echo ','; }
					echo "'".$uneStat['VILLE']." : ".$uneStat['COUNT(*)']." (".round(($uneStat['COUNT(*)'] / $nbEleves['COUNT(*)']) * 100)." %)'";
					$totalElevesVille = $totalElevesVille + $uneStat['COUNT(*)'];
					$i++;
					}
					echo ",'Autres villes : ".($nbEleves['COUNT(*)'] - $totalElevesVille)." (".round((($nbEleves['COUNT(*)'] - $totalElevesVille) / $nbEleves['COUNT(*)']) * 100)." %)'],
					datasets: [{ label: '',
					data: [";
					$i = 0;
					foreach($nbElevesParVille as $uneStat) {
					if($i > 0) { echo ','; }
					echo "'".$uneStat['COUNT(*)']."'";
					$i++;
					}
					echo ",'".($nbEleves['COUNT(*)'] - $totalElevesVille)."'], backgroundColor: [";
					$i = 0;
					foreach($nbElevesParVille as $uneStat) {
					if($i > 0) { echo ','; }
					echo "'".$couleurs[$i]."'";
					$i++;
					} echo ",'".$couleurs[$i]."']
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
                    <!--Répartition par filière-->
                    <h4 class="card-title">
                        <center>Répartition des eleves par Établissement</center>
                    </h4>
                    <div class="bloc_graphique" style="width:530px">
    <canvas id="graph_etablissements" width="530" height="400"></canvas>
    <script>
        var ctx = document.getElementById('graph_etablissements').getContext('2d');
        var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                <?php
                    $i = 0;
                    $totalElevesEtablissement = 0;
                    $nbEleves;
                    foreach($nbElevesParEtablissement as $uneStat) {
                        if($i > 0) { echo ','; }
                        echo "'" . $uneStat['NOM'] . " : " . $uneStat['COUNT(*)'] . " (" . round(($uneStat['COUNT(*)'] / $nbEleves['COUNT(*)']) * 100) . " %)'";
                        $totalElevesEtablissement += $uneStat['COUNT(*)'];
                        $i++;
                    }
                ?>
            ],
            datasets: [{
                data: [
                    <?php
                        $i = 0;
                        foreach($nbElevesParEtablissement as $uneStat) {
                            if($i > 0) { echo ','; }
                            echo $uneStat['COUNT(*)'];
                            $i++;
                        }
                    ?>
                ],
                backgroundColor: [
                    <?php
                    $couleurs = array('red', 'blue', 'green', 'pink', 'orange', 'brown', 'gray', 'lime', 'maroon', 'olive', 'navy', 'teal', 'yellow', 'purple');
                    foreach($nbElevesParEtablissement as $index => $uneStat) {
                        echo "'" . $couleurs[$index % count($couleurs)] . "',"; // Utilise le modulo pour répéter les couleurs si nécessaire
                    }
                    ?>
                ]
            }]
        },
        options: {
            responsive: true,
            legend: { position: 'top' },
            title: { display: false, text: 'Répartition par établissement' }
        }
    });
    </script>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    $moisNoms = array(
        '01' => 'Janvier',
        '02' => 'Février',
        '03' => 'Mars',
        '04' => 'Avril',
        '05' => 'Mai',
        '06' => 'Juin',
        '07' => 'Juillet',
        '08' => 'Août',
        '09' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Décembre');
    $joursNoms = array(
        '1' => 'Lundi',
        '2' => 'Mardi',
        '3' => 'Mercredi',
        '4' => 'Jeudi',
        '5' => 'Vendredi',
        '6' => 'Samedi',
        '7' => 'Dimanche');
    ?>

            <!--Répartition des intervenant & élève-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title"><center>Présences des élèves et intervenants</center></h4>
                            <!--liste des mois pour le filtre>
                            <select id="FiltreMois">
                                <option value="">Filtrer par mois</option>
                                <option value="défaut">Vue d'ensemble</option>
                                <?php foreach ($moisNoms as $moisNum => $moisNom): ?>
                                    <option value="<?php echo $moisNum; ?>"><?php echo $moisNom; ?></option>
                                <?php endforeach; ?>-->
                            </select>
                            <center><canvas id='graph_presences_combinees'></canvas></center>
                            <script>
                                //Stocke les dates dans un tableau
                                <?php
                                $datesComplete = [];
                                foreach ($nbPresencesEleves as $uneStat) {
                                    $datesComplete[] = date('d/m/Y', strtotime($uneStat['SEANCE']));
                                }
                                ?>
                                var ctx = document.getElementById('graph_presences_combinees').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: [<?php
                                        $i = 0;
                                        $moisPrecedent = '';
                                            foreach ($nbPresencesEleves as $uneStat) {
                                                if ($i > 0) { echo ','; }
                                                if ($moisPrecedent != date('m', strtotime($uneStat['SEANCE']))) {
                                                    echo "'" . $moisNoms[date('m', strtotime($uneStat['SEANCE']))] . "'";
                                                    $moisPrecedent = date('m', strtotime($uneStat['SEANCE']));
                                                    
                                                } else {
                                                    echo "''";
                                                }
                                            $i++;
                                            }
                                        ?>],
                                        datasets: [ 
                                        {
                                            //Données eleves année en cours
                                            label: 'Élèves <?php echo $anneeEnCours . "-" . ($anneeEnCours + 1); ?>',
                                            data: [<?php
                                            $i = 0;
                                            foreach ($nbPresencesEleves as $uneStat) {
                                                if ($i > 0) { echo ','; }
                                                echo $uneStat['COUNT(*)'];
                                                
                                                
                                                $i++;
                                            }
                                            ?>],
                                            borderColor: 'blue',
                                            fill: true
                                        },
                                        {
                                            //Données Intervenant année actuelle
                                            label: 'Intervenants <?php echo $anneeEnCours . "-" . ($anneeEnCours + 1); ?>',
                                            data: [<?php
                                            $i = 0;
                                            foreach ($nbPresencesIntervenants as $uneStat) {
                                                if ($i > 0) { echo ','; }
                                                echo $uneStat['COUNT(*)'];
                                                $i++;
                                            }
                                            ?>],
                                            borderColor: 'yellow',
                                            fill: true,
                                        },
                                        {
                                            //Données eleves année passée
                                            label: 'Élèves <?php echo ($anneeEnCours - 1) . "-" . $anneeEnCours; ?>',
                                            data: [<?php
                                                
                                                $i = 0;
                                                foreach ($nbPresencesElevesAvant as $uneStat) {
                                                    if ($i > 0) { echo ','; }
                                                    echo $uneStat['COUNT(*)'];
                                                    $i++;
                                                }
                                            ?>],
                                            borderColor: '#8ecae6',
                                            fill: false
                                        },
                                        {
                                            //Données Intervenant année passée
                                            label: 'Intervenants <?php echo ($anneeEnCours - 1) . "-" . $anneeEnCours; ?>',
                                            data: [<?php
                                                $i = 0;
                                                foreach ($nbPresencesIntervenantsAvant as $uneStat) {
                                                    if ($i > 0) { echo ','; }
                                                    echo $uneStat['COUNT(*)'];
                                                    $i++;
                                                }
                                                ?>],
                                                borderColor: '#ff792e',
                                                fill: false
                                        }
                                    ]
                                    },
                                    options: {    
                                        scales: {
                                            yAxes: [{
                                                ticks: { beginAtZero: true }
                                            }]
                                        },
                                        responsive: true,
                                        legend: {
                                            labels: { fontColor: 'black', defaultFontSize: 20 }
                                        },
                                        tooltips: {
                                            callbacks: {
                                                title: function(tooltipItems, data) {
                                                    //récupère la date complète 
                                                    return <?php echo json_encode($datesComplete); ?>[tooltipItems[0].index];
                                                }
                                            }
                                        },
                                        
                                        
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="bloc_graphique">
                        <h4 class="card-title">
                            <center>Nombre d'inscriptions</center>
                        </h4>
                        <?php
                        echo "<center><canvas id='graph_inscriptions'></canvas></center>
									<script>
						var ctx = document.getElementById('graph_inscriptions');
						ctx.height = 300;
						ctx.width = 1000;
						var myChart = new Chart(ctx, {
						type: 'bar',
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
                        foreach ($nbInscriptionsEleves as $uneStat) {
                            if ($i > 0) {
                                echo ',';
                            }
                            $nbInscriptions = $uneStat['COUNT(*)'];
                            echo "'" . $nbInscriptions . "'";
                            $i++;
                        }
                        
                        echo "], backgroundColor: 'rgb(0,0,255)'
							},
							{ label: 'Année scolaire " . ($anneeEnCours - 1) . "-" . $anneeEnCours . "',
									data: [";
                        $i = 0;
                        $nbInscriptions = 0;
                        foreach ($nbInscriptionsElevesAvant as $uneStat) {
                            if ($i > 0) {
                                echo ',';
                            }
                            $nbInscriptions = $uneStat['COUNT(*)'];
                            echo "'" . $nbInscriptions . "'";
                            $i++;
                        }
                        echo "], backgroundColor: '#f5bb00'
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

    <div class="row">
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="car-body">


                    <h4 class="card-header">Soutien Scolaire</h4>
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Manquants</th>
                            <th class="text-center">Quantités</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">

                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading"><span
                                                    style="color:<?php if ($photosManquantes['COUNT(*)'] > 0) {
                                                        echo 'red';
                                                    } else {
                                                        echo 'green';
                                                    } ?>">Photo Eleves</span></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><?php echo $photosManquantes['COUNT(*)']; ?></td>
                            <td class="text-center">
                                <a href="index.php?choixTraitement=administrateur&action=InfosManquantes&type=eleves&infos=photos"
                                   style="display:inline">
                                    <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">

                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading"><span
                                                    style="color:<?php if ($emailsManquantes['COUNT(*)'] > 0) {
                                                        echo 'red';
                                                    } else {
                                                        echo 'green';
                                                    } ?>">Emails parents</span></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><?php echo $emailsManquantes['COUNT(*)']; ?></td>
                            <td class="text-center">
                                <a href="index.php?choixTraitement=administrateur&action=InfosManquantes&type=eleves&infos=emails"
                                   style="display:inline">
                                    <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">

                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading"><span
                                                    style="color:<?php if ($telsManquantes['COUNT(*)'] > 0) {
                                                        echo 'red';
                                                    } else {
                                                        echo 'green';
                                                    } ?>">Téléphones parents</span></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><?php echo $telsManquantes['COUNT(*)']; ?></td>
                            <td class="text-center">
                                <a href="index.php?choixTraitement=administrateur&action=InfosManquantes&type=eleves&infos=telephones"
                                   style="display:inline">
                                    <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">

                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading"><span
                                                    style="color:<?php if ($adressesManquantes['COUNT(*)'] > 0) {
                                                        echo 'red';
                                                    } else {
                                                        echo 'green';
                                                    } ?>">Adresses postales</span></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><?php echo $adressesManquantes['COUNT(*)']; ?></td>
                            <td class="text-center">
                                <a href="index.php?choixTraitement=administrateur&action=InfosManquantes&type=eleves&infos=adresses"
                                   style="display:inline">
                                    <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">

                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading"><span
                                                    style="color:<?php if ($rdvParentsManquants > 0) {
                                                        echo 'red';
                                                    } else {
                                                        echo 'green';
                                                    } ?>">Eleves sans RDV parents</span></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><?php echo $rdvParentsManquants; ?></td>
                            <td class="text-center">
                                <a href="index.php?choixTraitement=administrateur&action=InfosManquantes&type=eleves&infos=rdv"
                                   style="display:inline">
                                    <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm">Details
                                    </button>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-header">Présence des élèves</h4>
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Activité</th>
                            <th>Nombre</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php
                            $totalPresences = 0;
                            foreach ($listeVilleExtranet as $laVille) {
                                $presencesVille = $pdo->nbHeuresPresencesScolaireEleves($anneeEnCours, $laVille, 1.5);
                                $totalPresences = $totalPresences + $presencesVille['total'];
                                echo '<tr>
																															<td>Scolaire hebdomadaire à ' . ucfirst($laVille) . '</td>
																															<td><b>' . $presencesVille['total'] . '</b> heures</td>
																													</tr>';
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Rendez-vous BSB</td>
                            <td><b><?php
                                    $presencesBsb = round($nbHeuresPresencesRdvBsb['total']);
                                    $totalPresences = $totalPresences + $presencesBsb;
                                    echo $presencesBsb; ?></b> heures
                            </td>
                        </tr>
                        <?php
                        foreach ($lesStages as $leStage) {
                            $lesPresences = $pdo->nbHeuresPresencesStageEleves($leStage['ID_STAGE']);
                            $presencesStage = round($lesPresences['total'] * $leStage['DUREE_SEANCES_STAGE']);
                            echo '<tr><td>' . stripslashes($leStage['NOM_STAGE']) . '</td><td><b>' . $presencesStage . '</b> heures</td></tr>';
                            $totalPresences = $totalPresences + $presencesStage;
                        } ?>
                        <tr>
                            <th style="text-align:right">Total</th>
                            <th><?php echo $totalPresences; ?> heures</th>
                        </tr>
                        </tbody>
                    </table>
                    </center>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="main-card mb-3 card">
                <div class="card-body">
                    <center><h2 class="card-title">Statistiques des cours informatiques</h2></center>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <p>Il y a <b><?php echo $nbInscrits; ?></b> personne(s) inscrite(s).</p>

                    <p>Il y a eu en moyenne <b><?php echo $stats_moyennePresences; ?></b> personne(s) présente(s) par
                        date.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">
                        <center>Évolution des présences</center>
                    </h4>
                    <canvas id="stats_presences" style="width:500px;height:300px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">
                        <center>Répartition par genre</center>
                    </h4>
                    <center>
                        <canvas id="stats_sexe" style="width:500px;height:300px"></canvas>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">
                        <center>Répartition par ville</center>
                    </h4>
                    <center>
                        <canvas id="stats_ville" style="width:500px;height:300px"></canvas>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">
                        <center>Répartition par tranche d'age</center>
                    </h4>
                    <center>
                        <canvas id="stats_age" style="width:500px;height:300px"></canvas>
                    </center>
                </div>
                <?php if ($estAccesLibre) { ?>
                    <div class="col-md-12">
                        <center>
                            <canvas id="stats_visites" style="width:500px;height:300px"></canvas>
                        </center>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    var ctx1 = document.getElementById("stats_presences");
    var labels = [];
    var data = [];
    var datesComplete = [];
    <?php foreach ($stats_totalPresences as $unePresence): ?>
        var dateLabel = '<?php echo date('M', strtotime($unePresence['DATE_DEBUT'])); ?>';
        if (!labels.includes(dateLabel)) {
            labels.push(dateLabel);
        }
        //Date complète pour les tooltips
        datesComplete.push('<?php echo date('d/m/Y', strtotime($unePresence['DATE_DEBUT'])); ?>');
        data.push(<?php echo $unePresence['COUNT(*)']; ?>);
    <?php endforeach; ?>

    var myChart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Evolution des présences',
                data: data,
                backgroundColor: 'rgba(0,0,255,0.5)',
                borderColor: 'blue',
                fill: true
            }]
        },
        options: {
            responsive: true,
            legend: {
                labels: {
                    fontColor: 'black',
                    defaultFontSize: 20
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dateComplete = datesComplete[tooltipItem.index];
                        var count = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        return dateComplete + ': ' + count + ' présences';
                    }
                }
            },
            scales: {
                yAxes: [{
                    ticks: {stepSize: 1, autoskip: true, beginAtZero: true},
                }],
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Mois'
                    }
                }]
            }
        }
    });



        /* ---------------- Répartition par sexe --------------- */
        var ctx2 = document.getElementById("stats_sexe");
        var myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: [<?php
                    $i = 0;
                    foreach ($stats_repartitionSexe as $uneStat) {
                        if ($i > 0) {
                            echo ',';
                        }
                        echo "'" . $uneStat['SEXE'] . " (" . $uneStat['COUNT(*)'] . ")'";
                        $i++;
                    }
                    ?>],
                datasets: [{
                    label: 'Répartition par sexe',
                    data: [<?php
                        $i = 0;
                        foreach ($stats_repartitionSexe as $uneStat) {
                            if ($i > 0) {
                                echo ',';
                            }
                            echo "'" . $uneStat['COUNT(*)'] . "'";
                            $i++;
                        } ?>],
                    backgroundColor: ['red', 'blue']
                }]
            },
            options: {
                responsive: true,
                legend: {position: 'top'},
                title: {display: false, text: 'Répartition par genre'}
            }
        });

        /* ---------------- Répartition par ville --------------- */
        var ctx3 = document.getElementById("stats_ville");
        var myChart3 = new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: [<?php
                    $i = 0;
                    foreach ($stats_repartitionVille as $uneStat) {
                        if ($i > 0) {
                            echo ',';
                        }
                        echo "'" . $uneStat['VILLE'] . " (" . $uneStat['COUNT(*)'] . ")'";
                        $i++;
                    }
                    ?>],
                datasets: [{
                    label: 'Répartition par ville',
                    data: [<?php
                        $i = 0;
                        foreach ($stats_repartitionVille as $uneStat) {
                            if ($i > 0) {
                                echo ',';
                            }
                            echo "'" . $uneStat['COUNT(*)'] . "'";
                            $i++;
                        } ?>],
                    backgroundColor: [<?php
                        $i = 0;
                        foreach ($stats_repartitionVille as $uneStat) {
                            if ($i > 0) {
                                echo ',';
                            }
                            //echo "'".$couleurs[$i]."'";
                            echo "'rgb(" . rand(0, 200) . "," . rand(0, 200) . "," . rand(0, 200) . ")'";
                            $i++;
                        } ?>]
                }]
            },
            options: {
                responsive: true,
                legend: {position: 'top'},
                title: {display: false, text: 'Répartition par ville'}
            }
        });

        <?php
        $age_tranches = array();
        $age_intervalle = 10;

        // On parcours les tranches selon l'intervalle choisi
        for ($i = 0; $i <= 100; $i = $i + 10) {

            // On initiliase le compteur de cette tranxche
            $age_tranches[$i] = 0;

            // On parcours les inscriptions
            foreach ($stats_repartitionAge as $uneStat) {

                // Calcul de l'age de la personne
                $age = (date('Y', time()) - $uneStat['YEAR(`DATE_DE_NAISSANCE`)']);

                // Si l'age rentre dans cet tranche
                if ($age >= $i and $age <= ($i + $age_intervalle)) {

                    // On le comptabilise
                    $age_tranches[$i] = $age_tranches[$i] + 1;
                }
            }
        }
        ?>
        /* ---------------- Répartition par age --------------- */
        var ctx4 = document.getElementById("stats_age");
        var myChart4 = new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: [<?php
                    $i = 0;
                    foreach ($age_tranches as $uneTranche) {

                        // Si la tranche d'age n'est pas vide
                        if ($uneTranche > 0) {
                            if ($i > 0) {
                                echo ',';
                            }
                            echo "'" . ($i * $age_intervalle) . "-" . (($i * $age_intervalle) + $age_intervalle) . " ans (" . $uneTranche . ")'";
                            $i++;
                        }
                    }
                    ?>],
                datasets: [{
                    label: 'Répartition par ville',
                    data: [<?php
                        $i = 0;
                        foreach ($age_tranches as $uneTranche) {

                            // Si la tranche d'age n'est pas vide
                            if ($uneTranche > 0) {
                                if ($i > 0) {
                                    echo ',';
                                }
                                echo "'" . $uneTranche . "'";
                                $i++;
                            }
                        } ?>],
                    backgroundColor: [<?php
                        $i = 0;
                        foreach ($age_tranches as $uneTranche) {

                            // Si la tranche d'age n'est pas vide
                            if ($uneTranche > 0) {
                                if ($i > 0) {
                                    echo ',';
                                }
                                echo "'" . $couleurs[$i] . "'";
                                $i++;
                            }
                        } ?>]
                }]
            },
            options: {
                responsive: true,
                legend: {position: 'top'},
                title: {display: false, text: 'Répartition par tranche d\'âge'}
            }
        });

        <?php if($estAccesLibre) { ?>
        /* ---------------- Stats sur les visites --------------- */
        var ctx5 = document.getElementById("stats_visites");
        var myChart5 = new Chart(ctx5, {
            type: 'doughnut',
            data: {
                labels: [<?php
                    $i = 0;
                    foreach ($stats_repartitionPC as $uneTranche) {

                        if ($i > 0) {
                            echo ',';
                        }
                        echo "'" . stripslashes($uneTranche['valeur']) . "'";
                        $i++;

                    }
                    ?>],
                datasets: [{
                    label: 'Répartition des visites par PC',
                    data: [<?php
                        $i = 0;
                        foreach ($stats_repartitionPC as $uneTranche) {

                            if ($uneTranche > 0) {
                                if ($i > 0) {
                                    echo ',';
                                }
                                echo "'" . $uneTranche['nb'] . "'";
                                $i++;
                            }
                        } ?>],
                    backgroundColor: [<?php
                        $i = 0;
                        foreach ($stats_repartitionPC as $uneTranche) {

                            // Si la tranche d'age n'est pas vide
                            if ($uneTranche > 0) {
                                if ($i > 0) {
                                    echo ',';
                                }
                                echo "'" . $couleurs[$i] . "'";
                                $i++;
                            }
                        } ?>]
                }]
            },
            options: {
                responsive: true,
                legend: {position: 'top'},
                title: {display: true, text: 'Répartition des visites par PC'}
            }
        });
        <?php } ?>
    </script>


</div>


<?php // TODO: mettr les fichiers js suivants en entete et regarder quel est le fichier qui fais bugger le nav ?>
<script type="text/javascript" src="./vendors/jquery-circle-progress/dist/circle-progress.min.js"></script>
<script type="text/javascript" src="./vendors/toastr/build/toastr.min.js"></script>
<script type="text/javascript" src="./vendors/jquery.fancytree/dist/jquery.fancytree-all-deps.min.js"></script>
<script type="text/javascript" src="./vendors/apexcharts/dist/apexcharts.min.js"></script>

<!-- custome.js -->
<script type="text/javascript" src="./js/charts/apex-charts.js"></script>
<script type="text/javascript" src="./js/circle-progress.js"></script>
<script type="text/javascript" src="./js/toastr.js"></script>


<?php $pourcent = '0.' . round(($nbElevesPayes['COUNT(*)'] / $nbEleves['COUNT(*)']) * 100); ?>
<script type="text/javascript">
    var pourcent = <?php echo json_encode($pourcent); ?>;
    $(".circle-progress-dark")
        .circleProgress({
            value: pourcent,
            size: 52,
            lineCap: "round",
            fill: {color: "#3c8ed6"},
        })
        .on("circle-animation-progress", function (event, progress, stepValue) {
            $(this)
                .find("small")
                .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
        });
</script>

<?php $pourcent = round(($nbAdherents / /*$nbFamillesTotal*/$nbFamilles), 2); ?>
<script type="text/javascript">
    var pourcent = <?php echo json_encode($pourcent); ?>;
    $("#circle-progress-dark2")
        .circleProgress({
            value: pourcent,
            size: 52,
            lineCap: "round",
            fill: {color: "#3c8ed6"},
        })
        .on("circle-animation-progress", function (event, progress, stepValue) {
            $(this)
                .find("small")
                .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
        });
</script>

<?php $pourcent = round(($nbAdherentsCaf / /*$nbFamillesTotal*/ $nbFamilles), 2); ?>
<script type="text/javascript">
    var pourcent = <?php echo json_encode($pourcent); ?>;
    $("#circle-progress-dark3")
        .circleProgress({
            value: pourcent,
            size: 52,
            lineCap: "round",
            fill: {color: "#3c8ed6"},
        })
        .on("circle-animation-progress", function (event, progress, stepValue) {
            $(this)
                .find("small")
                .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
        });
</script>
<?php $pourcent = round(($nbEleveSoutien / $nbEleves['COUNT(*)']), 2); ?>
<script type="text/javascript">
    var pourcent = <?php echo json_encode($pourcent); ?>;
    $("#circle-progress-dark4")
        .circleProgress({
            value: pourcent,
            size: 52,
            lineCap: "round",
            fill: {color: "#3c8ed6"},
        })
        .on("circle-animation-progress", function (event, progress, stepValue) {
            $(this)
                .find("small")
                .html("<span>" + stepValue.toFixed(2).substr(2) + "%<span>");
        });
</script>


<?php // Area Negative ?>
<script type="text/javascript">

    var options2 = {
        chart: {
            height: 350,
            type: 'area',
            // zoom: {
            //     enabled: false
            // }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        series: [{
            name: 'nord',
            data: [{
                x: 1996,
                y: 322
            },
                {
                    x: 1997,
                    y: 324
                },
                {
                    x: 1998,
                    y: 329
                },
                {
                    x: 1999,
                    y: 342
                },
                {
                    x: 2000,
                    y: 348
                },
                {
                    x: 2001,
                    y: 334
                },
                {
                    x: 2002,
                    y: 325
                },
                {
                    x: 2003,
                    y: 316
                },
                {
                    x: 2004,
                    y: 318
                },
                {
                    x: 2005,
                    y: 330
                },
                {
                    x: 2006,
                    y: 355
                },
                {
                    x: 2007,
                    y: 366
                },
                {
                    x: 2008,
                    y: 337
                },
                {
                    x: 2009,
                    y: 352
                },
                {
                    x: 2010,
                    y: 377
                },
                {
                    x: 2011,
                    y: 383
                },
                {
                    x: 2012,
                    y: 344
                },
                {
                    x: 2013,
                    y: 366
                },
                {
                    x: 2014,
                    y: 389
                },
                {
                    x: 2015,
                    y: 334
                }
            ]
        }, {
            name: 'sud',
            data: [

                {
                    x: 1996,
                    y: 162
                },
                {
                    x: 1997,
                    y: 90
                },
                {
                    x: 1998,
                    y: 50
                },
                {
                    x: 1999,
                    y: 77
                },
                {
                    x: 2000,
                    y: 35
                },
                {
                    x: 2001,
                    y: -45
                },
                {
                    x: 2002,
                    y: -88
                },
                {
                    x: 2003,
                    y: -120
                },
                {
                    x: 2004,
                    y: -156
                },
                {
                    x: 2005,
                    y: -123
                },
                {
                    x: 2006,
                    y: -88
                },
                {
                    x: 2007,
                    y: -66
                },
                {
                    x: 2008,
                    y: -45
                },
                {
                    x: 2009,
                    y: -29
                },
                {
                    x: 2010,
                    y: -45
                },
                {
                    x: 2011,
                    y: -88
                },
                {
                    x: 2012,
                    y: -132
                },
                {
                    x: 2013,
                    y: -146
                },
                {
                    x: 2014,
                    y: -169
                },
                {
                    x: 2015,
                    y: -184
                }
            ]
        }],
        title: {
            text: 'présences sur les deux dernières années',
            align: 'left',
            style: {
                fontSize: '14px'
            }
        },
        xaxis: {
            type: 'datetime',
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            tickAmount: 4,
            floating: false,

            labels: {
                style: {
                    color: '#8e8da4',
                },
                offsetY: -7,
                offsetX: 0,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            opacity: 0.5,
            gradient: {
                enabled: false
            }
        },
        tooltip: {
            x: {
                format: "yyyy",
            },
            fixed: {
                enabled: false,
                position: 'topRight'
            }
        },
        grid: {
            yaxis: {
                lines: {
                    offsetX: -30
                }
            },
            padding: {
                left: 20
            }
        },
    };


    // Apex Charts Init

    $(document).ready(() => {

        setTimeout(function () {

            if (document.getElementById('chart-apex-negative')) {
                chart2.render();
            }

        }, 1000);

        if (document.getElementById('chart-col-2')) {
            col3Chart2.render();
        }


        if (document.getElementById('sparkline-chart2')) {
            new ApexCharts(document.querySelector("#sparkline-chart2"), options22).render();
        }


        $('.minimal-tab-btn-1').one('click', function () {

            setTimeout(function () {
                new ApexCharts(document.querySelector("#chart-combined-tab"), options777).render();
            }, 500);

        });

        $('.dd-chart-btn').one('click', function () {

            setTimeout(function () {
                if (document.getElementById('dashboard-sparkline-carousel-3-pop')) {
                    new ApexCharts(document.querySelector("#dashboard-sparkline-carousel-3-pop"), dashSparkLinesSimple3).render();
                }
            }, 500);

        });

        $('.dd-chart-btn-2').one('click', function () {

            setTimeout(function () {
                if (document.getElementById('dashboard-sparkline-carousel-4-pop')) {
                    new ApexCharts(document.querySelector("#dashboard-sparkline-carousel-4-pop"), dashSparkLinesSimple2).render();
                }
            }, 500);

        });

        $('.minimal-tab-btn-3').one('click', function () {
            setTimeout(function () {
                new ApexCharts(document.querySelector("#chart-combined-tab-3"), optionsCommerce).render();
            }, 500);
        });

        $('.second-tab-toggle').one('click', function () {
            setTimeout(function () {
                new ApexCharts(document.querySelector("#dashboard-sparklines-333"), dashSparkLines4).render();
            }, 500);
        });

        $('.second-tab-toggle-alt').one('click', function () {
            setTimeout(function () {
                new ApexCharts(document.querySelector("#dashboard-sparkline-37"), dashSpark33).render();
            }, 500);
        });

    });
</script>
