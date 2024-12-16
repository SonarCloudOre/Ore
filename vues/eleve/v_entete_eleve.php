<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
$anneeEnCours = $pdo->getAnneeEnCours();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>Extranet ORE- Espace eleve</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="pragma" content="no-cache"/>

    <!-- Pas d'indexation par Google -->
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">


    <!-- Javascript -->

    <!-- plugin dependencies -->
    <script type="text/javascript" src="./vendors/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="./vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="./vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script type="text/javascript" src="./vendors/apexcharts/dist/apexcharts.min.js"></script>
    <script type="text/javascript" src="./vendors/metismenu/dist/metisMenu.js"></script>

    <!-- custome.js -->
    <script type="text/javascript" src="./js/demo.js"></script>
    <script type="text/javascript" src="./js/scrollbar.js"></script>
    <script type="text/javascript" src="./js/app.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>


    <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- <link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="./vendors/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./vendors/ionicons-npm/css/ionicons.css">
    <link rel="stylesheet" href="./vendors/linearicons-master/dist/web-font/style.css">
    <link rel="stylesheet" href="./vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css">
    <link href="./styles/css/base2.css" rel="stylesheet">
</head>


<body onload="date_heure('date_heure');">
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    <div class="app-header header-shadow">
        <div class="app-header__logo">
            <a href="index.php?choixTraitement=eleve&action=index">
                <div class="logo-src"></div>
            </a>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic is-active"
                            data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
                    <span>
                        <button type="button"
                                class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
        </div>
        <div class="app-header__content">

            <div class="app-header-right">
                <div class="header-dots">
                    <div class="dropdown">
                        <button type="button" aria-haspopup="true" aria-expanded="false"
                                data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                            <div id="date_heure">
                                <center><span class="heure" style="font-size:30px"></span><br><span class="date"
                                                                                                    style="font-size:12px">Vendredi 15 Janvier 2021</span>
                                </center>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                       class="p-0 btn">
                                        <img width="42" class="rounded-circle"
                                             src="<?php echo 'photosEleves/' . $intervenant["PHOTO"] ?>" alt="">
                                        <span
                                            class="widget-heading"><?php echo $intervenant["PRENOM"] . ' ' . $intervenant["NOM"] ?><i
                                                class="fa fa-angle-down ml-2 opacity-8"></i></span>


                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                         class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-info">
                                                <div class="menu-header-image opacity-2"
                                                     style="background-image: url('images/dropdown-header/city3.jpg');"></div>
                                                <div class="menu-header-content text-left">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3 avatar-icon rounded">
                                                                <img width="42"
                                                                     src="<?php echo 'photosEleves/' . $intervenant["PHOTO"] ?>"
                                                                     alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div
                                                                    class="widget-heading"><?php echo $intervenant["PRENOM"] . ' ' . $intervenant["NOM"] ?></div>
                                                                <div
                                                                    class="widget-subheading opacity-8"><?php echo 'Élève' ?></div>
                                                            </div>
                                                            <div class="widget-content-right mr-2">
                                                                <a href="index.php">
                                                                    <button
                                                                        class="btn-pill btn-shadow btn-shine btn btn-focus">
                                                                        Déconnexion
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="scroll-area-xs" style="height: 90px;">
                                            <div class="scrollbar-container ps">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item-header nav-item">Élève</li>
                                                    <li class="nav-item">
                                                        <a href="index.php?choixTraitement=eleve&action=infospersos"
                                                           class="nav-link">Informations personnelles</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <ul class="nav flex-column">
                                            <li class="nav-item-divider mb-0 nav-item"></li>
                                        </ul>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-12"><a
                                                        href="index.php?choixTraitement=eleve&action=macarte"
                                                        style="text-decoration:none;">
                                                        <button
                                                            class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                            Voir ma carte<br><img src="./images/student-card.png"
                                                                                  width="100" height="100"/>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="nav flex-column">
                                            <li class="nav-item-divider nav-item"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-main">
        <div class="app-sidebar sidebar-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
      <span>
        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
          <span class="btn-icon-wrapper">
            <i class="fa fa-ellipsis-v fa-w-6"></i>
          </span>
        </button>
      </span>
            </div>
            <div class="scrollbar-sidebar">
                <div class="app-sidebar__inner">


                    <ul class="vertical-nav-menu metismenu">
                        <li class="app-sidebar__heading"><a href="index.php?choixTraitement=eleve&action=index"
                                                            aria-expanded="false"
                                                            style="text-transform: uppercase; margin: 0.75rem 0; padding:0px; font-weight: bold; color: #3f6ad8; white-space: nowrap; position: relative;">Accueil</a>
                        </li>
                        <li class="app-sidebar__heading">Élève</li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=presence" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-id"></i>
                                Présences
                            </a>
                        </li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=rdv" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-check"></i>
                                Rendez-vous
                            </a>
                        </li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=reglements" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-clock"></i>
                                Règlements
                            </a>
                        </li>
                    </ul>
                    <ul class="vertical-nav-menu metismenu">
                        <li class="app-sidebar__heading">Stages</li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=inscriptionstages" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-id"></i>
                                Inscriptions
                            </a>
                        </li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=stagehisto" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-check"></i>
                                Historiques
                            </a>
                        </li>
                    </ul>
                    <ul class="vertical-nav-menu metismenu">
                        <li class="app-sidebar__heading">Soutien scolaire</li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=osticket" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-id"></i>
                                Aide aux devoirs
                            </a>
                        </li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=plateformes" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-check"></i>
                                Plateformes
                            </a>
                        </li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=Polycopies" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-check"></i>
                                Polycopiés
                            </a>
                        </li>
                    </ul>
                    <ul class="vertical-nav-menu metismenu">
                        <li class="app-sidebar__heading">Activités</li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=activitehisto" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-check"></i>
                                Historiques
                            </a>
                        </li>
                    </ul>
                    <ul class="vertical-nav-menu metismenu">
                        <li class="app-sidebar__heading">Contact</li>
                        <li>
                            <a href="index.php?choixTraitement=eleve&action=contact" aria-expanded="false">
                                <i class="metismenu-icon pe-7s-id"></i>
                                Contacter l'association
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="app-main__outer">
            <div class="app-main__inner" id='sectionAimprimer'>
                <script>
                    function imprimer(divName) {
                        var printContents = document.getElementById(divName).innerHTML;
                        var originalContents = document.body.innerHTML;
                        document.body.innerHTML = printContents;
                        window.print();
                        document.body.innerHTML = originalContents;
                    }
                </script>
