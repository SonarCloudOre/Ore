<?php
$villeExtranet = $_SESSION['villeExtranet'] ?? 'Quetigny';
$anneeExtranet = $_SESSION['anneeExtranet'] ?? getAnneeEnCours();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?= isset($_SESSION['intervenant'])
            ? ucfirst($villeExtranet) . ' // ' . $anneeExtranet . "-" . ($anneeExtranet + 1) : 'Extranet' ?> // ORE</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="pragma" content="no-cache"/>

    <!-- Pas d'indexation par Google -->
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">

    <link rel="shortcut icon" type="image/x-icon" href="./images/logo.png">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" href="./vendors/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="./styles/css/base.css" rel="stylesheet">
    <link rel="stylesheet" href="./vues/tablette/tablette.css">

    <!-- plugin dependencies -->
    <script type="text/javascript" src="./vendors/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="./vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>

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
                            $tabI = tabClasses('fichePresence', $action);
                        ?>
                        <a href="index.php?choixTraitement=tablette&action=fichePresence" class="<?= $tabI ?>">Fiche de présence</a>
                    </div>
                    <a href="index.php?choixTraitement=administrateur&action=index"
                       class="btn btn-danger" id="tablet-back-button">&times;</a>
                </nav>
            </div>
