<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
$anneeEnCours = $pdo->getAnneeEnCours();
$intervenant = $_SESSION['intervenant'];
$numIntervenant = $intervenant['ID_INTERVENANT'];
$admin = $intervenant['ADMINISTRATEUR'];

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <script type="text/javascript" src="./js/jquery.js"></script>
        <script type="text/javascript" src=
        "https://code.jquery.com/jquery-1.7.1.min.js">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="js/entete.js"></script>

        <script type="module" src="js/utils.js"></script>
        <script type="module" src="js/sms.js"></script>
        <title><?php

            // Si on est connecté
            if (isset($_SESSION['intervenant'])) {
                echo ucfirst($villeExtranet) . ' // ' . $anneeEnCours . "-" . ($anneeEnCours + 1) . '';
            } else {
                echo 'Extranet';
            } ?> // ORE</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <meta http-equiv="pragma" content="no-cache"/>

        <!-- Pas d'indexation par Google -->
        <meta name="googlebot" content="noindex">
        <meta name="robots" content="noindex">

        <?php /*

    // TODO: Enlever les commentaires si problème, ces lignes sont ceux de l'ancien extranet
        <!-- Bootstrap (interface) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="./styles/bootstrap/js/bootstrap.min.js"></script>

        <!-- Bootstrap select -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

        <!-- Nouveau CSS -->
        <link href="./styles/nouveau.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" media="print" href="./styles/print.css">

        <!-- TinyMCE -->
        <script type="text/javascript" src="./include/tinymce/tinymce.min.js"></script>

        <!-- Chart.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js" integrity="sha256-GcknncGKzlKm69d+sp+k3A2NyQE+jnu43aBl6rrDN2I=" crossorigin="anonymous"></script>
        <script src="./include/chartjs/chart_label.js" charset="utf-8"></script>
    
        <!-- Font Awesome icons -->
        <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">

        <!-- Lightbox -->
        <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" />

        <!-- datatables -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" />
    */
        /*echo'
            <!-- Cartes OpenStreetMap -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js" integrity="sha256-CNm+7c26DTTCGRQkM9vp7aP85kHFMqs9MhPEuytF+fQ=" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" integrity="sha256-iYUgmrapfDGvBrePJPrMWQZDcObdAcStKBpjP3Az+3s=" crossorigin="anonymous" />';*/
        ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
      integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
      crossorigin=""></script>


        <link rel="shortcut icon" type="image/x-icon" href="./images/logo.png">


        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
              integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
              crossorigin=""/>
        <script type="text/javascript" src="https://association-ore.fr/extranet/js/script.js"></script>

        <script src="https://kit.fontawesome.com/xxxxxxxxxx.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="./styles/css/error.css">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Analytics Dashboard - This is an example dashboard created using build-in elements and components.</title>
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
        <link href="./styles/css/base.css" rel="stylesheet">
        <link href="./styles/css/jquery-ui.css" rel="stylesheet"> <!--pour la ville le code postale -->


        <!-- plugin dependencies -->
        <script type="text/javascript" src="./vendors/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="./vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="./vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script type="text/javascript" src="./vendors/clipboard/dist/clipboard.min.js"></script>
        <script type="text/javascript" src="./vendors/metismenu/dist/metisMenu.js"></script>
        <script type="text/javascript" src="./vendors/jquery-validation/dist/jquery.validate.min.js"></script>
        <script type="text/javascript" src="./js/form-components/form-validation.js"></script>
        <!-- Chart.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"
                integrity="sha256-GcknncGKzlKm69d+sp+k3A2NyQE+jnu43aBl6rrDN2I=" crossorigin="anonymous"></script>
        <script src="./include/chartjs/chart_label.js" charset="utf-8"></script>

        <script src="https://cdn.jsdelivr.net/npm/jimp/browser/lib/jimp.min.js"></script>

        <script type="text/javascript" src="./js/scrollbar.js"></script>
    </head>
<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>

<div id="contenu">
    <div class="your-class">
        <!-- si les [...] ont plus de 8 pers alors on fait une autre pages, etc-->
        <?php 
        $nb = 0;
        echo '<div class="row" style="padding:20px"><div class="row">';

        foreach ($lesIntervenants as $intervenant)
        {
            if ($nb == 12)
            {
                // Fin de la page
                echo '</div></div><div class="row" style="padding:20px"><div class="row">';
                // Nouvelle page
                $nb = 0;
            }

            if ($intervenant['PHOTO'] == "") {
                $photo = "AUCUNE.jpg";
            } else {
                $photo = $intervenant['PHOTO'];
            }
            echo '<div class="col-md-2 card-body">
                <div class="card-hover-shadow card-border mb-3 card">
                    <div class="dropdown-menu-header">
                        <div class="dropdown-menu-header-inner bg-warning">
                            <div class="menu-header-content">
                                <div>
                                    <a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $intervenant["ID_INTERVENANT"] . 
                                            '" class="avatar-icon-wrapper btn-hover-shine avatar-icon-xl">
                                        <div class="avatar-icon rounded">
                                            <img src="photosIntervenants/' . $photo . '" alt="Avatar 5">
                                        </div>
                                    </a>
                                </div>
                                <div>
                                    <h5 class="menu-header-title">' . $intervenant["PRENOM"] . ' ' . $intervenant["NOM"] . '</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">';
                        $num = $intervenant["ID_INTERVENANT"];
                        $lesMatieres = $pdo->getParametre(6);
                        $lesMatieresIntervenant = $pdo->getSpecialisationIntervenant($num);

                        echo '<ul style="text-align : left; margin: 0px; padding : 10px;">';

                            foreach ($lesMatieres as $uneLigne) 
                            {
                                $checked = " ";

                                foreach ($lesMatieresIntervenant as $uneLigne2) 
                                {
                                    if ($uneLigne['ID'] == $uneLigne2['ID']) 
                                    {
                                        echo '<li>' . $uneLigne["NOM"] . '</li>';
                                    }
                                }
                            }
                        echo '</ul>
                    </div>
                </div>
            </div>';

            $nb++;
        } 
        ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="slick/slick.min.js"></script>

<script type="text/javascript" src="js/diaposlick.js"></script>
