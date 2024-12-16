<?php
$villeExtranet = $_SESSION['villeExtranet'] ?? 'Quetigny';
$anneeExtranet = $_SESSION['anneeExtranet'] ?? getAnneeEnCours();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?= isset($_SESSION['intervenant'])
            ? ucfirst($villeExtranet) . ' // ' . $anneeExtranet . "-" . ($anneeExtranet + 1)
            : 'Extranet' ?> // ORE</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="pragma" content="no-cache"/>

    <!-- Pas d'indexation par Google -->
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">

    <link rel="shortcut icon" type="image/x-icon" href="./images/logo.png">

    <!--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script type="text/javascript" src="https://association-ore.fr/extranet/js/script.js"></script>-->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!--<link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!--<link rel="stylesheet" href="./vendors/ionicons-npm/css/ionicons.css">
    <link rel="stylesheet" href="./vendors/linearicons-master/dist/web-font/style.css">
    <link rel="stylesheet" href="./vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css">-->
    <link rel="stylesheet" href="./vendors/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="./styles/css/base.css" rel="stylesheet">
    <link rel="stylesheet" href="./vues/tablette/tablette.css">

    <!-- plugin dependencies -->
    <script type="text/javascript" src="./vendors/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="./vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="app-main">
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="card main-card mb-3 p-1">
                <nav role="navigation" id="nav">
                    <div class="btn-group btn-group-lg" id="nav-buttons">
                        <?php
                        function tabClasses($tab, $action) {
                            return 'btn btn-lg ' . ($tab !== $action ? 'btn-outline-secondary' : 'btn-warning');
                        }
                        $tabI = tabClasses('appelIntervenant', $action);
                        $tabE = tabClasses('appelEleves', $action);
                        $tabS = tabClasses('appelStages', $action);
                        $tabQR = tabClasses('appelQRCode', $action);
                        ?>
                        <a href="index.php?choixTraitement=tablette&action=appelIntervenant" class="<?= $tabI ?>">Appel Intervenants</a>
                        <a href="index.php?choixTraitement=tablette&action=appelEleves" class="<?= $tabE ?>">Appel Élèves</a>
                        <a href="index.php?choixTraitement=tablette&action=appelStages" class="<?= $tabS ?>">Appel Stages</a>
                        <a href="index.php?choixTraitement=tablette&action=appelQRCode" class="<?= $tabQR ?>">Appel QR-Code</a>
                    </div>
                    <a href="index.php?choixTraitement=administrateur&action=index"
                       class="btn btn-danger" id="tablet-back-button">&times;</a>
                </nav>
            </div>

            <?php if (isset($eleves, $intervenants)): ?>
                <div class="row">
                    <div class="col-md-3 order-md-last">
                        <div class="card main-card">
                            <div class="card-body">
                                <span class="h4 card-title">
                                    Présences le <?= date('d/m/Y') ?> <?= getMomentJourneeTexte() ?>
                                </span>

                                <div class="card mt-3 bg-secondary widget-chart text-white card-border">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-white opacity-1"></div>
                                        <i class="lnr-graduation-hat text-white"></i>
                                    </div>
                                    <div class="widget-numbers"><b><?= count($eleves ?? []) ?></b></div>
                                    <div><b>Élèves</b></div>
                                </div>
                                <div class="card mt-3 bg-secondary widget-chart text-white card-border">
                                    <div class="icon-wrapper rounded-circle">
                                        <div class="icon-wrapper-bg bg-white opacity-1"></div>
                                        <i class="lnr-book text-white"></i>
                                    </div>
                                    <div class="widget-numbers"><b><?= count($intervenants ?? []) ?></b></div>
                                    <div><b>Intervenants</b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
            <?php endif; ?>
