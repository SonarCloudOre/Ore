<?php
// Date de début et de fin en Français
list($anneeD, $moisD, $jourD) = explode('-', $debut);
list($anneeF, $moisF, $jourF) = explode('-', $fin);
$dateDebut = $jourD . "-" . $moisD . "-" . $anneeD;
$dateFin = $jourF . "-" . $moisF . "-" . $anneeF;
?>
<div id="contenu">
    <div class="row">
        <div class="col-lg-6 col-xl-4">
            <div class="mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-shirt mr-3 text-muted opacity-6"></i>
                        Mes présences
                    </div>
                </div>
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content widget-chart-content-lg">
                            <div class="widget-chart-flex">
                                <div class="widget-title opacity-5 text-muted text-uppercase">Mes présences cette
                                    année
                                </div>
                            </div>
                            <div class="widget-numbers">
                                <div class="widget-chart-flex">
                                    <div>
                                        <!--<span class="opacity-10 text-success pr-2">
                                            <i class="fa fa-angle-up"></i>
                                        </span>-->
                                        <span></span>
                                        <small class="opacity-5 pl-1"></small>
                                    </div>
                                    <div class="widget-title ml-2 font-size-lg font-weight-normal text-muted">
                                        <span class="text-danger pl-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-chart-wrapper widget-chart-wrapper-xlg opacity-10 m-0">
                            <div id="dashboard-sparkline-3"></div>
                        </div>
                    </div>
                </div>
                <div class="pt-2 pb-0 card-body">
                    <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 font-weight-normal">Dernières
                        présences</h6>
                    <div class="scroll-area-md shadow-overflow">
                        <div class="scrollbar-container">
                            <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                <?php $total = 0;
                                foreach ($tableau as $uneLigne) {
                                    // extraction des jour, mois, an de la date
                                    list($annee, $mois, $jour) = explode('-', $uneLigne['SEANCE']);
                                    // calcul du timestamp
                                    $dateFrench = $jour . "-" . $mois . "-" . $annee;
                                    $total++;
                                    echo '<li class="list-group-item">
                                  <div class="widget-content p-0">
                                      <div class="widget-content-wrapper">
                                          <div class="widget-content-left mr-3">
                                              <img width="38" class="rounded-circle"
                                                  src="https://image.flaticon.com/icons/png/512/2/2123.png" alt="">
                                          </div>
                                          <div class="widget-content-left">
                                              <div class="widget-heading">Soutien scolaire</div>
                                              <div class="widget-subheading mt-1 opacity-10">
                                                  <div class="badge badge-pill badge-dark">' . $dateFrench . '</div>
                                              </div>
                                          </div>
                                          <div class="widget-content-right">
                                              <div class="fsize-1 text-focus">
                                                  <small class="opacity-5 pr-1"></small>
                                                  <span>' . substr($dateFrench, -4) . '</span>
                                                  <small class="text-warning pl-2">

                                                  </small>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-block text-center rm-border card-footer">
                    <a href="index.php?choixTraitement=eleve&action=presence">
                        <button class="btn btn-primary">
                            Toutes mes présences
                            <span class="text-white pl-2 opacity-3">
                          <i class="fa fa-arrow-right"></i>
                      </span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="card-shadow-primary card-border mb-3 profile-responsive card">
                <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-alternate">
                        <div class="menu-header-image opacity-4"
                             style="background-image: url('images/dropdown-header/abstract2.jpg');"></div>
                        <div class="menu-header-content btn-pane-right">
                            <div class="avatar-icon-wrapper mr-3 avatar-icon-xl btn-hover-shine">
                                <div class="avatar-icon rounded">
                                    <img src="<?php echo 'photosIntervenants/' . $intervenant["PHOTO"] ?>"
                                         alt="Avatar 5">
                                </div>
                            </div>
                            <div>
                                <br><h5
                                    class="menu-header-title"><?php echo $intervenant["PRENOM"] . ' ' . $intervenant["NOM"] ?></h5>
                                <h6 class="menu-header-subtitle"><?php if ($intervenant["ADMINISTRATEUR"] == 0) {
                                        echo "Intervenant";
                                    } elseif ($intervenant["ADMINISTRATEUR"] == 1) {
                                        echo "Administrateur";
                                    } else {
                                        echo "Super Administrateur";
                                    }
                                    ?></h6>
                            </div>

                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="p-0 list-group-item">
                        <div class="grid-menu grid-menu-2col">
                            <div class="no-gutters row">
                                <div class="col-sm-6">
                                    <div class="p-1">
                                        <a href="index.php?choixTraitement=intervenant&action=modifInfos"
                                           style="text-decoration: none;">
                                            <button
                                                class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-focus">
                                                <i class="lnr-user text-primary opacity-7 btn-icon-wrapper mb-2"></i>
                                                Mon profil
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-1">
                                        <a href="index.php?choixTraitement=intervenant&action=macarte"
                                           style="text-decoration: none;">
                                            <button
                                                class="btn-icon-vertical btn-transition-text btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-focus">
                                                <i class="lnr-license text-primary opacity-7 btn-icon-wrapper mb-2"></i>
                                                Ma carte
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-cloud-download icon-gradient bg-happy-itmeo"></i>
                        Dernières informations importantes
                    </div>
                </div>
                <div class="p-0 card-body">
                    <div class="dropdown-menu-header mt-0 mb-0">
                        <div class="dropdown-menu-header-inner bg-heavy-rain">
                            <div class="menu-header-image opacity-1"
                                 style="background-image: url('images/dropdown-header/city3.jpg');"></div>
                            <div class="menu-header-content text-dark">
                                <h5 class="menu-header-title">Notifications</h5>
                                <h6 class="menu-header-subtitle">
                                    Il y a
                                    <b class="text-danger">12</b>
                                    nouvelles vous concernant !
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-animated-0" role="tabpanel">
                            <div class="scroll-area-sm">
                                <div class="scrollbar-container">
                                    <div class="p-3">
                                        <div class="notifications-box">
                                            <div
                                                class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                <?php foreach ($lesnotifs as $uneNotif) {
                                                    echo '
                                              <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                                  <div>
                                                      <span class="vertical-timeline-element-icon bounce-in"></span>
                                                      <div class="vertical-timeline-element-content bounce-in">
                                                          <h4 class="timeline-title">
                                                             ' . $uneNotif['libelle'] . '
<br>
                                                               <span class="text-success">Le ' . $uneNotif['date_evenement'] . '</span>
                                                              <span class="mb-2 mr-2 badge badge-pill badge-danger">Nouveau</span>
                                                          </h4>
                                                          <span class="vertical-timeline-element-date"></span>
                                                      </div>
                                                  </div>
                                              </div>

                                              ';
                                                } ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-animated-1" role="tabpanel">
                            <div class="scroll-area-sm">
                                <div class="scrollbar-container">
                                    <div class="p-3">
                                        <div
                                            class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">

                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                  <span class="vertical-timeline-element-icon bounce-in">
                                                      <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                                  </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <h4 class="timeline-title">'.$uneNotif['libelle']. '</h4>
                                                        <p>
                                                            Lorem ipsum dolor sic amet, today at
                                                            <a href="javascript:void(0);"></a>
                                                        </p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                  <span class="vertical-timeline-element-icon bounce-in">
                                                      <i class="badge badge-dot badge-dot-xl badge-warning"></i>
                                                  </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <p>
                                                            Another meeting today, at
                                                            <b class="text-danger">12:00 PM</b>
                                                        </p>
                                                        <p>
                                                            Yet another one, at
                                                            <span class="text-success">15:00 PM</span>
                                                        </p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                  <span class="vertical-timeline-element-icon bounce-in">
                                                      <i class="badge badge-dot badge-dot-xl badge-danger"></i>
                                                  </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <h4 class="timeline-title">Build the production release</h4>
                                                        <p>
                                                            Lorem ipsum dolor sit amit,consectetur eiusmdd tempor
                                                            incididunt ut labore et dolore magna elit enim at
                                                            minim veniam quis nostrud
                                                        </p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                  <span class="vertical-timeline-element-icon bounce-in">
                                                      <i class="badge badge-dot badge-dot-xl badge-primary"></i>
                                                  </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <h4 class="timeline-title text-success">Something not
                                                            important</h4>
                                                        <p>
                                                            Lorem ipsum dolor sit amit,consectetur elit enim at
                                                            minim veniam quis nostrud
                                                        </p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                  <span class="vertical-timeline-element-icon bounce-in">
                                                      <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                                  </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <h4 class="timeline-title">All Hands Meeting</h4>
                                                        <p>
                                                            Lorem ipsum dolor sic amet, today at
                                                            <a href="javascript:void(0);">12:00 PM</a>
                                                        </p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                  <span class="vertical-timeline-element-icon bounce-in">
                                                      <i class="badge badge-dot badge-dot-xl badge-warning"></i>
                                                  </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <p>
                                                            Another meeting today, at
                                                            <b class="text-danger">12:00 PM</b>
                                                        </p>
                                                        <p>
                                                            Yet another one, at
                                                            <span class="text-success">15:00 PM</span>
                                                        </p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                  <span class="vertical-timeline-element-icon bounce-in">
                                                      <i class="badge badge-dot badge-dot-xl badge-danger"></i>
                                                  </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <h4 class="timeline-title">Build the production release</h4>
                                                        <p>
                                                            Lorem ipsum dolor sit amit,consectetur eiusmdd tempor
                                                            incididunt ut labore et dolore magna elit enim at
                                                            minim veniam quis nostrud
                                                        </p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertical-timeline-item vertical-timeline-element">
                                                <div>
                                                  <span class="vertical-timeline-element-icon bounce-in">
                                                      <i class="badge badge-dot badge-dot-xl badge-primary"></i>
                                                  </span>
                                                    <div class="vertical-timeline-element-content bounce-in">
                                                        <h4 class="timeline-title text-success">Something not
                                                            important</h4>
                                                        <p>
                                                            Lorem ipsum dolor sit amit,consectetur elit enim at
                                                            minim veniam quis nostrud
                                                        </p>
                                                        <span class="vertical-timeline-element-date"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-animated-2" role="tabpanel">
                            <div class="scroll-area-sm">
                                <div class="scrollbar-container">
                                    <div class="no-results pt-3 pb-0">
                                        <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                            <div class="swal2-success-circular-line-left"
                                                 style="background-color: rgb(255, 255, 255);"></div>
                                            <span class="swal2-success-line-tip"></span>
                                            <span class="swal2-success-line-long"></span>
                                            <div class="swal2-success-ring"></div>
                                            <div class="swal2-success-fix"
                                                 style="background-color: rgb(255, 255, 255);"></div>
                                            <div class="swal2-success-circular-line-right"
                                                 style="background-color: rgb(255, 255, 255);"></div>
                                        </div>
                                        <div class="results-subtitle">All caught up!</div>
                                        <div class="results-title">There are no system errors!</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item-btn text-center pt-4 pb-3 nav-item">

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-4">
            <div class="mb-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                        <i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"></i>
                        Mes documents
                    </div>
                </div>
                <div class="widget-chart widget-chart2 text-left p-0">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content widget-chart-content-lg">
                            <div class="widget-chart-flex">
                                <div class="widget-title opacity-5 text-muted text-uppercase">
                                    Nombre de documents
                                </div>
                            </div>
                            <div class="widget-numbers">
                                <div class="widget-chart-flex">
                                    <div>
                                      <span class="opacity-10 text-warning pr-2">
                                          <i class="fa fa-dot-circle"></i>
                                      </span>
                                        <span>23</span>
                                    </div>
                                    <div class="widget-title ml-2 font-size-lg font-weight-normal text-muted">
                                        <span class="text-success pl-2">+14</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-chart-wrapper widget-chart-wrapper-xlg opacity-10 m-0">
                            <center><img src="./images/paper.png" alt="" width="150" height="150"></center>

                        </div>
                    </div>
                </div>
                <div class="pt-2 pb-0 card-body">
                    <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 font-weight-normal">
                        Derniers documents ajoutés
                    </h6>
                    <div class="scroll-area-md shadow-overflow">
                        <div class="scrollbar-container">
                            <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                <?php


                                $dir_nom = './documentsIntervenants/' . $numIntervenant . '/'; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
                                if (file_exists($dir_nom)) {
                                    $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
                                    $fichier = array(); // on déclare le tableau contenant le nom des fichiers
                                    $dossier = array(); // on déclare le tableau contenant le nom des dossiers

                                    while ($element = readdir($dir)) {
                                        if ($element != '.' && $element != '..') {
                                            if (!is_dir($dir_nom . '/' . $element)) {
                                                $fichier[] = $element;
                                            } else {
                                                $dossier[] = $element;
                                            }
                                        }
                                    }

                                    closedir($dir);
                                    $i = 0;
                                    foreach ($fichier as $lien) {
                                        $i++;

                                        {
                                            echo '<li class="list-group-item">
                                      <div class="widget-content p-0">
                                          <div class="widget-content-wrapper">
                                              <div class="widget-content-left mr-3">
                                              <img width="38" class="rounded-circle"
                                                  src="https://image.flaticon.com/icons/png/512/32/32329.png" alt="">
                                              </div>
                                              <div class="widget-content-left">
                                                  <div class="widget-heading"><a href="' . $dir_nom . $lien . '">' . $lien . '</a></div>
                                                  <div class="widget-subheading mt-1 opacity-10">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </li>';
                                        }

                                        ?>
                                    <?php }
                                    if ($i == 0) {
                                        echo '<i>Aucun document ajouté pour le moment.</i>';
                                    }
                                } else {
                                    echo '<i>Aucun document ajouté pour le moment.</i>';
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-block text-center rm-border card-footer">
                    <a href="index.php?choixTraitement=intervenant&action=Documents">
                        <button class="btn btn-primary">
                            Tout les documents
                            <span class="text-white pl-2 opacity-3">
                        <i class="fa fa-arrow-right"></i>
                    </span>
                        </button>
                    </a>
                </div>
            </div>
        </div>


    </div>
</div>

<script type="text/javascript" src="./vendors/apexcharts/dist/apexcharts.min.js"></script>

<script>
    // Apex Charts

    window.Apex = {
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 2
        },
    };

    var series =
        {
            "monthDataSeries1": {
                "prices": [
                    8107.85,
                    8128.0,
                    8122.9,
                    8165.5,
                    8340.7,
                    8423.7,
                    8423.5,
                    8514.3,
                    8481.85,
                    8487.7,
                    8506.9,
                    8626.2,
                    8668.95,
                    8602.3,
                    8607.55,
                    8512.9,
                    8496.25,
                    8600.65,
                    8881.1,
                    9340.85
                ],
                "dates": [
                    "13 Nov 2017",
                    "14 Nov 2017",
                    "15 Nov 2017",
                    "16 Nov 2017",
                    "17 Nov 2017",
                    "20 Nov 2017",
                    "21 Nov 2017",
                    "22 Nov 2017",
                    "23 Nov 2017",
                    "24 Nov 2017",
                    "27 Nov 2017",
                    "28 Nov 2017",
                    "29 Nov 2017",
                    "30 Nov 2017",
                    "01 Dec 2017",
                    "04 Dec 2017",
                    "05 Dec 2017",
                    "06 Dec 2017",
                    "07 Dec 2017",
                    "08 Dec 2017"
                ]
            },
            "monthDataSeries2": {
                "prices": [
                    8423.7,
                    8423.5,
                    8514.3,
                    8481.85,
                    8487.7,
                    8506.9,
                    8626.2,
                    8668.95,
                    8602.3,
                    8607.55,
                    8512.9,
                    8496.25,
                    8600.65,
                    8881.1,
                    9040.85,
                    8340.7,
                    8165.5,
                    8122.9,
                    8107.85,
                    8128.0
                ],
                "dates": [
                    "13 Nov 2017",
                    "14 Nov 2017",
                    "15 Nov 2017",
                    "16 Nov 2017",
                    "17 Nov 2017",
                    "20 Nov 2017",
                    "21 Nov 2017",
                    "22 Nov 2017",
                    "23 Nov 2017",
                    "24 Nov 2017",
                    "27 Nov 2017",
                    "28 Nov 2017",
                    "29 Nov 2017",
                    "30 Nov 2017",
                    "01 Dec 2017",
                    "04 Dec 2017",
                    "05 Dec 2017",
                    "06 Dec 2017",
                    "07 Dec 2017",
                    "08 Dec 2017"
                ]
            },
            "monthDataSeries3": {
                "prices": [
                    7114.25,
                    7126.6,
                    7116.95,
                    7203.7,
                    7233.75,
                    7451.0,
                    7381.15,
                    7348.95,
                    7347.75,
                    7311.25,
                    7266.4,
                    7253.25,
                    7215.45,
                    7266.35,
                    7315.25,
                    7237.2,
                    7191.4,
                    7238.95,
                    7222.6,
                    7217.9,
                    7359.3,
                    7371.55,
                    7371.15,
                    7469.2,
                    7429.25,
                    7434.65,
                    7451.1,
                    7475.25,
                    7566.25,
                    7556.8,
                    7525.55,
                    7555.45,
                    7560.9,
                    7490.7,
                    7527.6,
                    7551.9,
                    7514.85,
                    7577.95,
                    7592.3,
                    7621.95,
                    7707.95,
                    7859.1,
                    7815.7,
                    7739.0,
                    7778.7,
                    7839.45,
                    7756.45,
                    7669.2,
                    7580.45,
                    7452.85,
                    7617.25,
                    7701.6,
                    7606.8,
                    7620.05,
                    7513.85,
                    7498.45,
                    7575.45,
                    7601.95,
                    7589.1,
                    7525.85,
                    7569.5,
                    7702.5,
                    7812.7,
                    7803.75,
                    7816.3,
                    7851.15,
                    7912.2,
                    7972.8,
                    8145.0,
                    8161.1,
                    8121.05,
                    8071.25,
                    8088.2,
                    8154.45,
                    8148.3,
                    8122.05,
                    8132.65,
                    8074.55,
                    7952.8,
                    7885.55,
                    7733.9,
                    7897.15,
                    7973.15,
                    7888.5,
                    7842.8,
                    7838.4,
                    7909.85,
                    7892.75,
                    7897.75,
                    7820.05,
                    7904.4,
                    7872.2,
                    7847.5,
                    7849.55,
                    7789.6,
                    7736.35,
                    7819.4,
                    7875.35,
                    7871.8,
                    8076.5,
                    8114.8,
                    8193.55,
                    8217.1,
                    8235.05,
                    8215.3,
                    8216.4,
                    8301.55,
                    8235.25,
                    8229.75,
                    8201.95,
                    8164.95,
                    8107.85,
                    8128.0,
                    8122.9,
                    8165.5,
                    8340.7,
                    8423.7,
                    8423.5,
                    8514.3,
                    8481.85,
                    8487.7,
                    8506.9,
                    8626.2
                ],
                "dates": [
                    "02 Jun 2017",
                    "05 Jun 2017",
                    "06 Jun 2017",
                    "07 Jun 2017",
                    "08 Jun 2017",
                    "09 Jun 2017",
                    "12 Jun 2017",
                    "13 Jun 2017",
                    "14 Jun 2017",
                    "15 Jun 2017",
                    "16 Jun 2017",
                    "19 Jun 2017",
                    "20 Jun 2017",
                    "21 Jun 2017",
                    "22 Jun 2017",
                    "23 Jun 2017",
                    "27 Jun 2017",
                    "28 Jun 2017",
                    "29 Jun 2017",
                    "30 Jun 2017",
                    "03 Jul 2017",
                    "04 Jul 2017",
                    "05 Jul 2017",
                    "06 Jul 2017",
                    "07 Jul 2017",
                    "10 Jul 2017",
                    "11 Jul 2017",
                    "12 Jul 2017",
                    "13 Jul 2017",
                    "14 Jul 2017",
                    "17 Jul 2017",
                    "18 Jul 2017",
                    "19 Jul 2017",
                    "20 Jul 2017",
                    "21 Jul 2017",
                    "24 Jul 2017",
                    "25 Jul 2017",
                    "26 Jul 2017",
                    "27 Jul 2017",
                    "28 Jul 2017",
                    "31 Jul 2017",
                    "01 Aug 2017",
                    "02 Aug 2017",
                    "03 Aug 2017",
                    "04 Aug 2017",
                    "07 Aug 2017",
                    "08 Aug 2017",
                    "09 Aug 2017",
                    "10 Aug 2017",
                    "11 Aug 2017",
                    "14 Aug 2017",
                    "16 Aug 2017",
                    "17 Aug 2017",
                    "18 Aug 2017",
                    "21 Aug 2017",
                    "22 Aug 2017",
                    "23 Aug 2017",
                    "24 Aug 2017",
                    "28 Aug 2017",
                    "29 Aug 2017",
                    "30 Aug 2017",
                    "31 Aug 2017",
                    "01 Sep 2017",
                    "04 Sep 2017",
                    "05 Sep 2017",
                    "06 Sep 2017",
                    "07 Sep 2017",
                    "08 Sep 2017",
                    "11 Sep 2017",
                    "12 Sep 2017",
                    "13 Sep 2017",
                    "14 Sep 2017",
                    "15 Sep 2017",
                    "18 Sep 2017",
                    "19 Sep 2017",
                    "20 Sep 2017",
                    "21 Sep 2017",
                    "22 Sep 2017",
                    "25 Sep 2017",
                    "26 Sep 2017",
                    "27 Sep 2017",
                    "28 Sep 2017",
                    "29 Sep 2017",
                    "03 Oct 2017",
                    "04 Oct 2017",
                    "05 Oct 2017",
                    "06 Oct 2017",
                    "09 Oct 2017",
                    "10 Oct 2017",
                    "11 Oct 2017",
                    "12 Oct 2017",
                    "13 Oct 2017",
                    "16 Oct 2017",
                    "17 Oct 2017",
                    "18 Oct 2017",
                    "19 Oct 2017",
                    "23 Oct 2017",
                    "24 Oct 2017",
                    "25 Oct 2017",
                    "26 Oct 2017",
                    "27 Oct 2017",
                    "30 Oct 2017",
                    "31 Oct 2017",
                    "01 Nov 2017",
                    "02 Nov 2017",
                    "03 Nov 2017",
                    "06 Nov 2017",
                    "07 Nov 2017",
                    "08 Nov 2017",
                    "09 Nov 2017",
                    "10 Nov 2017",
                    "13 Nov 2017",
                    "14 Nov 2017",
                    "15 Nov 2017",
                    "16 Nov 2017",
                    "17 Nov 2017",
                    "20 Nov 2017",
                    "21 Nov 2017",
                    "22 Nov 2017",
                    "23 Nov 2017",
                    "24 Nov 2017",
                    "27 Nov 2017",
                    "28 Nov 2017"
                ]
            }
        };

    // Radial

    var options444 = {
        chart: {
            height: 350,
            type: 'radialBar',
            toolbar: {
                show: true
            }
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 225,
                hollow: {
                    margin: 0,
                    size: '70%',
                    background: '#fff',
                    image: undefined,
                    imageOffsetX: 0,
                    imageOffsetY: 0,
                    position: 'front',
                    dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.24
                    }
                },
                track: {
                    background: '#fff',
                    strokeWidth: '67%',
                    margin: 0, // margin is in pixels
                    dropShadow: {
                        enabled: true,
                        top: -3,
                        left: 0,
                        blur: 4,
                        opacity: 0.35
                    }
                },

                dataLabels: {
                    showOn: 'always',
                    name: {
                        offsetY: -10,
                        show: true,
                        color: '#888',
                        fontSize: '17px'
                    },
                    value: {
                        formatter: function (val) {
                            return parseInt(val);
                        },
                        color: '#111',
                        fontSize: '36px',
                        show: true,
                    }
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: 'horizontal',
                shadeIntensity: 0.5,
                gradientToColors: ['#ABE5A1'],
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100]
            }
        },
        series: [75],
        stroke: {
            lineCap: 'round'
        },
        labels: ['Percent'],

    };

    var chart444 = new ApexCharts(
        document.querySelector("#chart-radial"),
        options444
    );

    // Vertical Bars

    var optionsBar = {
        chart: {
            type: 'bar',
            height: 200,
            width: '100%',
            stacked: true,
            foreColor: '#999'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: false
                },
                columnWidth: '75%',
                endingShape: 'rounded'
            }
        },
        colors: ["#00C5A4", '#F3F2FC'],
        series: [{
            name: "Sessions",
            data: [20, 16, 24, 28, 26, 22, 15, 5, 14, 16, 22, 29, 24, 19, 15, 10, 11, 15, 19, 23],
        }, {
            name: "Views",
            data: [20, 16, 24, 28, 26, 22, 15, 5, 14, 16, 22, 29, 24, 19, 15, 10, 11, 15, 19, 23],
        }],
        labels: [15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 1, 2, 3, 4],
        xaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                show: false
            },
            labels: {
                show: false,
                style: {
                    fontSize: '14px'
                }
            },
        },
        grid: {
            xaxis: {
                lines: {
                    show: false
                },
            },
            yaxis: {
                lines: {
                    show: false
                },
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            labels: {
                show: false
            },
        },
        legend: {
            floating: true,
            position: 'top',
            horizontalAlign: 'center',
            offsetY: 15
        },
        subtitle: {
            text: 'Sessions and Views'
        },
        tooltip: {
            shared: true
        }

    };
    var optionsBarLg = {
        chart: {
            type: 'bar',
            height: 318,
            width: '100%',
            stacked: true,
            foreColor: '#999'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: false
                },
                columnWidth: '75%',
                endingShape: 'rounded'
            }
        },
        colors: ["#6086c5", '#d2f5fc'],
        series: [{
            name: "Sessions",
            data: [20, 16, 24, 28, 26, 22, 15, 5, 14, 16, 22, 29, 24, 19, 15, 10, 11, 15, 19, 23],
        }, {
            name: "Views",
            data: [20, 16, 24, 28, 26, 22, 15, 5, 14, 16, 22, 29, 24, 19, 15, 10, 11, 15, 19, 23],
        }],
        labels: [15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 1, 2, 3, 4],
        xaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                show: false
            },
            labels: {
                show: false,
                style: {
                    fontSize: '14px'
                }
            },
        },
        grid: {
            xaxis: {
                lines: {
                    show: false
                },
            },
            yaxis: {
                lines: {
                    show: false
                },
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            labels: {
                show: false
            },
        },
        legend: {
            floating: true,
            position: 'top',
            horizontalAlign: 'center',
            offsetY: 15
        },
        subtitle: {
            text: 'Sessions and Views'
        },
        tooltip: {
            shared: true
        }

    };

    var chartBar = new ApexCharts(document.querySelector('#bar-vertical-candle'), optionsBar);
    var chartBarLg = new ApexCharts(document.querySelector('#bar-vertical-candle-lg'), optionsBarLg);

    // 3Cols

    var options3col1 = {
        chart: {
            height: 200,
            type: 'bar',
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                endingShape: 'rounded',
                columnWidth: '55%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Net Profit',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: '$ (thousands)'
            }
        },
        fill: {
            opacity: 1

        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$ " + val + " thousands";
                }
            }
        }
    };

    var col3Chart1 = new ApexCharts(
        document.querySelector("#chart-col-1"),
        options3col1
    );


    var options3col2 = {
        chart: {
            height: 200,
            type: 'line',
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                endingShape: 'rounded',
                columnWidth: '55%',
            },
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['#998787']
        },
        series: [{
            name: 'Net Profit',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: '$ (thousands)'
            }
        },
        fill: {
            opacity: 1

        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$ " + val + " thousands";
                }
            }
        }
    };

    var col3Chart2 = new ApexCharts(
        document.querySelector("#chart-col-2"),
        options3col2
    );


    var options3col3 = {
        chart: {
            height: 200,
            type: 'area',
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                endingShape: 'rounded',
                columnWidth: '55%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Net Profit',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: '$ (thousands)'
            }
        },
        fill: {
            opacity: 1

        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$ " + val + " thousands";
                }
            }
        }
    };

    var col3Chart3 = new ApexCharts(
        document.querySelector("#chart-col-3"),
        options3col3
    );

    // Combined

    var options777 = {
        chart: {
            height: 397,
            type: 'line',
            toolbar: {
                show: false,
            }
        },
        series: [{
            name: 'Website Blog',
            type: 'column',
            data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
        }, {
            name: 'Social Media',
            type: 'line',
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
        }],
        stroke: {
            width: [0, 4]
        },
        // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
        xaxis: {
            type: 'datetime'
        },
        yaxis: [{
            title: {
                text: 'Website Blog',
            },

        }, {
            opposite: true,
            title: {
                text: 'Social Media'
            }
        }]

    };

    var chart777 = new ApexCharts(
        document.querySelector("#chart-combined"),
        options777
    );


    // Area

    var options = {
        chart: {
            height: 350,
            type: 'area',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        series: [{
            name: "STOCK ABC",
            data: series.monthDataSeries1.prices
        }],
        title: {
            text: 'Fundamental Analysis of Stocks',
            align: 'left'
        },
        subtitle: {
            text: 'Price Movements',
            align: 'left'
        },
        labels: series.monthDataSeries1.dates,
        xaxis: {
            type: 'datetime'
        },
        yaxis: {
            opposite: true
        },
        legend: {
            horizontalAlign: 'left'
        }
    };

    var chart = new ApexCharts(
        document.querySelector("#chart-apex-area"),
        options
    );

    // Area Negative

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
            name: 'north',
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
            name: 'south',
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
            text: 'Area with Negative Values',
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

    var chart2 = new ApexCharts(
        document.querySelector("#chart-apex-negative"),
        options2
    );

    // Column

    var options3 = {
        chart: {
            height: 350,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                horizontal: false,
                endingShape: 'rounded',
                columnWidth: '55%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Net Profit',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: '$ (thousands)'
            }
        },
        fill: {
            opacity: 1

        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$ " + val + " thousands";
                }
            }
        }
    };

    var chart3 = new ApexCharts(
        document.querySelector("#chart-apex-column"),
        options3
    );


    // Stacked Bar

    var options4 = {
        chart: {
            height: 350,
            type: 'bar',
            stacked: true,
        },
        plotOptions: {
            bar: {
                horizontal: true,
            },

        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        series: [{
            name: 'Marine Sprite',
            data: [44, 55, 41, 37, 22, 43, 21]
        }, {
            name: 'Striking Calf',
            data: [53, 32, 33, 52, 13, 43, 32]
        }, {
            name: 'Tank Picture',
            data: [12, 17, 11, 9, 15, 11, 20]
        }, {
            name: 'Bucket Slope',
            data: [9, 7, 5, 8, 6, 9, 4]
        }, {
            name: 'Reborn Kid',
            data: [25, 12, 19, 32, 25, 24, 10]
        }],
        title: {
            text: 'Fiction Books Sales'
        },
        xaxis: {
            categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
            labels: {
                formatter: function (val) {
                    return val + "K";
                }
            }
        },
        yaxis: {
            title: {
                text: undefined
            },

        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + "K";
                }
            }
        },
        fill: {
            opacity: 1

        },

        legend: {
            position: 'top',
            horizontalAlign: 'left',
            offsetX: 40
        }
    };

    var chart4 = new ApexCharts(
        document.querySelector("#chart-apex-stacked"),
        options4
    );

    // Dashboard Commerce chart > Variation 2

    var optionsCommerce = {
        chart: {
            height: 274,
            type: 'bar',
            stacked: true,
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
            },

        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        series: [{
            name: 'Marine',
            data: [44, 55, 41, 37, 22, 43]
        }, {
            name: 'Striking',
            data: [53, 32, 33, 52, 13, 43]
        }, {
            name: 'Tank',
            data: [12, 17, 11, 9, 15, 11]
        }, {
            name: 'Bucket',
            data: [9, 7, 5, 8, 6, 9]
        }, {
            name: 'Reborn',
            data: [25, 12, 19, 32, 25, 24]
        }],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + "K";
                }
            }
        },
        fill: {
            opacity: 1

        },

        legend: {
            position: 'top',
            horizontalAlign: 'center',
        }
    };

    var chartCommerce = new ApexCharts(
        document.querySelector("#chart-apex-stacked-commerce"),
        optionsCommerce
    );

    // Sparklines

    var randomizeArray = function (arg) {
        var array = arg.slice();
        var currentIndex = array.length,
            temporaryValue, randomIndex;

        while (0 !== currentIndex) {

            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    };

    var sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46];

    var options1 = {
        chart: {
            type: 'line',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
        }],
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };
    var options22 = {
        chart: {
            type: 'line',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        series: [{
            data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14]
        }],
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };
    var options33 = {
        chart: {
            type: 'line',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        series: [{
            data: [47, 45, 74, 14, 56, 74, 14, 11, 7, 39, 82]
        }],
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };
    var options44 = {
        chart: {
            type: 'line',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        series: [{
            data: [15, 75, 47, 65, 14, 2, 41, 54, 4, 27, 15]
        }],
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };
    var options5 = {
        chart: {
            type: 'bar',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                columnWidth: '80%'
            }
        },
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
        }],
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
        xaxis: {
            crosshairs: {
                width: 1
            },
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };
    var options6 = {
        chart: {
            type: 'bar',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                columnWidth: '80%'
            }
        },
        series: [{
            data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14]
        }],
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
        xaxis: {
            crosshairs: {
                width: 1
            },
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };
    var options7 = {
        chart: {
            type: 'bar',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                columnWidth: '80%'
            }
        },
        series: [{
            data: [47, 45, 74, 14, 56, 74, 14, 11, 7, 39, 82]
        }],
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
        xaxis: {
            crosshairs: {
                width: 1
            },
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };
    var options8 = {
        chart: {
            type: 'bar',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                columnWidth: '80%'
            }
        },
        colors: ["#4a47c4"],
        stroke: {
            width: 0,
            curve: 'smooth',
        },
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
        }],
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
        xaxis: {
            crosshairs: {
                width: 1
            },
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };
    var options9 = {
        chart: {
            type: 'area',
            width: 100,
            height: 35,
            sparkline: {
                enabled: true
            }
        },
        colors: ["#3ac47d"],
        stroke: {
            width: 2,
            curve: 'smooth',
        },
        series: [{
            data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
        }],
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
        xaxis: {
            crosshairs: {
                width: 1
            },
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        }
    };

    // Dashboard Charts

    var dashSpark1 = {
        chart: {
            type: 'area',
            height: 152,
            sparkline: {
                enabled: true
            },
        },
        colors: ["#3f6ad8"],
        stroke: {
            width: 5,
            curve: 'smooth',
        },

        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            },
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSpark4 = {
        chart: {
            type: 'area',
            height: 152,
            sparkline: {
                enabled: true
            },
        },
        colors: ["rgba(255,255,255,.8)"],
        stroke: {
            width: 5,
            curve: 'smooth',
        },

        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.2,
                opacityTo: 0.7,
                stops: [0, 90, 100]
            },
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSpark2 = {
        chart: {
            type: 'area',
            height: 152,
            sparkline: {
                enabled: true
            },
        },
        stroke: {
            width: 5,
            curve: 'smooth'
        },
        colors: ['#f7b924'],
        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            }
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSpark3 = {
        chart: {
            type: 'area',
            height: 152,
            sparkline: {
                enabled: true
            },
        },
        colors: ['#3ac47d'],
        stroke: {
            width: 5,
            curve: 'smooth'
        },

        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            }
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSpark33 = {
        chart: {
            type: 'area',
            height: 332,
            sparkline: {
                enabled: true
            },
        },
        colors: ['#3ac47d'],
        stroke: {
            width: 5,
            curve: 'smooth'
        },

        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 90, 100]
            }
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };

    var dashSparkLines1 = {
        chart: {
            type: 'line',
            height: 100,
            sparkline: {
                enabled: true
            },
        },
        colors: ["#3ac47d"],
        stroke: {
            width: 3,
            curve: 'smooth',
        },

        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: true
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSparkLines2 = {
        chart: {
            type: 'line',
            height: 100,
            sparkline: {
                enabled: true
            },
        },
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        colors: ['#007bff'],
        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: true
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSparkLines3 = {
        chart: {
            type: 'line',
            height: 100,
            sparkline: {
                enabled: true
            },
        },
        colors: ['#f7b924'],
        stroke: {
            width: 3,
            curve: 'smooth'
        },

        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: true
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSparkLines4 = {
        chart: {
            type: 'line',
            height: 100,
            sparkline: {
                enabled: true
            },
        },
        colors: ['#d92550'],
        stroke: {
            width: 3,
            curve: 'smooth'
        },

        markers: {
            size: 0
        },
        tooltip: {
            fixed: {
                enabled: true
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };

    var dashSparkLinesSimple1 = {
        chart: {
            type: 'line',
            height: 120,
            sparkline: {
                enabled: true
            },
        },
        tooltip: {
            enabled: false,
        },
        colors: ["#3ac47d"],
        stroke: {
            width: 3,
            curve: 'smooth',
        },

        markers: {
            size: 0
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSparkLinesSimple2 = {
        chart: {
            type: 'bar',
            height: 120,
            sparkline: {
                enabled: true
            },
        },
        tooltip: {
            enabled: false,
        },
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        colors: ['#007bff'],
        markers: {
            size: 0
        },

        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSparkLinesSimple3 = {
        chart: {
            type: 'area',
            height: 120,
            sparkline: {
                enabled: true
            },
        },
        tooltip: {
            enabled: false,
        },
        colors: ['#f7b924'],
        stroke: {
            width: 3,
            curve: 'smooth'
        },

        markers: {
            size: 0
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };

    var sparklinesBigPrimary = {
        chart: {
            height: 265,
            type: 'bar',
            stacked: false,
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
            },

        },
        colors: ['#007bff', '#16aaff'],
        stroke: {
            width: 0,
            colors: ['#fff'],
            curve: 'smooth'
        },
        series: [{
            name: 'Marine',
            data: [44, 55, 41, 37, 22, 43]
        }, {
            name: 'Striking',
            data: [53, 32, 33, 52, 13, 43]
        },],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + "K";
                }
            }
        },
        fill: {
            opacity: .8

        },

        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
        }
    };

    var dashSparkLinesTrans2 = {
        chart: {
            type: 'bar',
            height: 174,
            sparkline: {
                enabled: true
            },
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        stroke: {
            width: 2,
            curve: 'smooth'
        },
        colors: ['rgba(255,255,255,.3)'],
        markers: {
            size: 0
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };
    var dashSparkLinesTrans3 = {
        chart: {
            type: 'line',
            height: 148,
            sparkline: {
                enabled: true
            },
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return '';
                    }
                }
            },
            marker: {
                show: false
            }
        },
        colors: ['rgba(255,255,255,.3)'],
        stroke: {
            width: 2,
            curve: 'smooth'
        },

        markers: {
            size: 0
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        yaxis: {
            min: 0
        },
    };

    // Apex Charts Init

    $(document).ready(() => {

        setTimeout(function () {

            if (document.getElementById('chart-apex-area')) {
                chart.render();
            }
            if (document.getElementById('chart-apex-negative')) {
                chart2.render();
            }
            if (document.getElementById('chart-apex-column')) {
                chart3.render();
            }
            if (document.getElementById('chart-apex-stacked')) {
                chart4.render();
            }
            if (document.getElementById('chart-col-1')) {
                col3Chart1.render();
            }
            if (document.getElementById('chart-col-2')) {
                col3Chart2.render();
            }
            if (document.getElementById('chart-col-3')) {
                col3Chart3.render();
            }

            if (document.getElementById('sparkline-chart1')) {
                new ApexCharts(document.querySelector("#sparkline-chart1"), options1).render();
            }
            if (document.getElementById('sparkline-chart2')) {
                new ApexCharts(document.querySelector("#sparkline-chart2"), options22).render();
            }
            if (document.getElementById('sparkline-chart3')) {
                new ApexCharts(document.querySelector("#sparkline-chart3"), options33).render();
            }
            if (document.getElementById('sparkline-chart4')) {
                new ApexCharts(document.querySelector("#sparkline-chart4"), options44).render();
            }
            if (document.getElementById('sparkline-chart5')) {
                new ApexCharts(document.querySelector("#sparkline-chart5"), options5).render();
            }
            if (document.getElementById('sparkline-chart6')) {
                new ApexCharts(document.querySelector("#sparkline-chart6"), options6).render();
            }
            if (document.getElementById('sparkline-chart7')) {
                new ApexCharts(document.querySelector("#sparkline-chart7"), options7).render();
            }
            if (document.getElementById('sparkline-chart8')) {
                new ApexCharts(document.querySelector("#sparkline-chart8"), options8).render();
            }
            if (document.getElementById('sparkline-chart9')) {
                new ApexCharts(document.querySelector("#sparkline-chart9"), options9).render();
            }

            // Dashboard Charts

            if (document.getElementById('dashboard-sparkline-1')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-1"), dashSpark1).render();
            }

            if (document.getElementById('dashboard-sparkline-4')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-4"), dashSpark4).render();
            }

            if (document.getElementById('dashboard-sparkline-2')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-2"), dashSpark2).render();
            }

            if (document.getElementById('dashboard-sparkline-3')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-3"), dashSpark3).render();
            }

            if (document.getElementById('dashboard-sparklines-1')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-1"), dashSparkLines1).render();
            }

            if (document.getElementById('dashboard-sparklines-2')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-2"), dashSparkLines2).render();
            }

            if (document.getElementById('dashboard-sparklines-3')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-3"), dashSparkLines3).render();
            }

            if (document.getElementById('dashboard-sparklines-4')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-4"), dashSparkLines4).render();
            }

            if (document.getElementById('dashboard-sparklines-primary')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-primary"), sparklinesBigPrimary).render();
            }

            if (document.getElementById('dashboard-sparklines-simple-1')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-simple-1"), dashSparkLinesSimple1).render();
            }

            if (document.getElementById('dashboard-sparklines-simple-2')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-simple-2"), dashSparkLinesSimple2).render();
            }

            if (document.getElementById('dashboard-sparklines-simple-3')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-simple-3"), dashSparkLinesSimple3).render();
            }

            if (document.getElementById('dashboard-sparklines-transparent-2')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-transparent-2"), dashSparkLinesTrans2).render();
            }

            if (document.getElementById('dashboard-sparklines-transparent-3')) {
                new ApexCharts(document.querySelector("#dashboard-sparklines-transparent-3"), dashSparkLinesTrans3).render();
            }

            if (document.getElementById('dashboard-sparkline-carousel-1')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-carousel-1"), dashSparkLinesSimple1).render();
            }

            if (document.getElementById('dashboard-sparkline-carousel-2')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-carousel-2"), dashSparkLinesSimple2).render();
            }

            if (document.getElementById('dashboard-sparkline-carousel-3')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-carousel-3"), dashSparkLinesSimple3).render();
            }

            if (document.getElementById('sparkline-carousel-3')) {
                new ApexCharts(document.querySelector("#sparkline-carousel-3"), dashSparkLinesSimple1).render();
            }

            if (document.getElementById('dashboard-sparkline-11')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-11"), options7).render();
            }

            if (document.getElementById('dashboard-sparkline-22')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-22"), options8).render();
            }

            if (document.getElementById('dashboard-sparkline-33')) {
                new ApexCharts(document.querySelector("#dashboard-sparkline-33"), options9).render();
            }

            if (document.getElementById('chart-apex-stacked-commerce')) {
                chartCommerce.render();
            }

            if (document.getElementById('chart-radial')) {
                chart444.render();
            }

            if (document.getElementById('chart-combined')) {
                chart777.render();
            }

            if (document.getElementById('bar-vertical-candle')) {
                chartBar.render();
            }

            if (document.getElementById('bar-vertical-candle-lg')) {
                chartBarLg.render();
            }

        }, 1000);

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
