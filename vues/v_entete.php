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
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>

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


        <!-- -----------------chargement des scripts js reglement_centreinfo------------------- -->
        <script defer type="text/javascript" src=" ./js/reglement_centreinfo.js"></script>


    </head>

    <body onload="date_heure('date_heure');">

    <?php if (isset($numIntervenant)) { ?><!-- Si l'utilisateur est connecté-->


    <!-- Modal pour récupérer les numéros de téléphones des intervenants -->
    <div id="smsIntervenants" class="modal fade bd-example-modal-lgI" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Téléphones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="errorBox">
                </div>
                <div class="modal-body">
                    <center>
                        <?php
                        $telephonesIntervenants = $pdo->getTelephonesIntervenants($anneeEnCours);
                        ?>
                        <br>
                    </center>
                    <label>Téléphones:</label>
                    <br>
                    <center>
                        <textarea id="Clipboard_Intervenant" class="form-control autosize-input" readonly>
                        <?php
                            $numIndex = count($telephonesIntervenants);
                            $i = 0;
                            foreach ($telephonesIntervenants as $uneLigne) {
                                $uneLigne['TELEPHONE'] = str_replace(",", "", $uneLigne['TELEPHONE']);
                                $uneLigne['TELEPHONE'] = str_replace(".", "", $uneLigne['TELEPHONE']);
                                $uneLigne['TELEPHONE'] = str_replace(" ", "", $uneLigne['TELEPHONE']);
                                if (++$i === $numIndex) {
                                    $text = trim($uneLigne['TELEPHONE']);
                                    echo $text;
                                } else {
                                    echo trim($uneLigne['TELEPHONE']) . ',';
                                }

                            }
                        ?>
                        </textarea>
                        <br>
                    </center>
                    <label>Message:</label>
                    <br>
                    <center>
                        <textarea id="message_Intervenants" class="form-control autosize-input"></textarea>
                        <br>
                    </center>
                    <label>Piece jointe (JPEG ou PNG seulement):</label>
                    <center>
                        <input type="file" id="attach_Intervnants"/>
                        <!-- <button type="button" data-clipboard-target="#Clipboard_Intervenant" class="clipboard-trigger btn-shadow btn-pill btn-wide btn btn-primary">
                          Copier le texte
                        </button> -->
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                    <button type="button" id="sendIntervenants" class="btn btn-primary">Envoyer</button>
                    <!-- data-dismiss="modal" -->
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pour le numéro des téléphones des Elèves -->
    <div id="smsEleves" class="modal fade bd-example-modal-lgE" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Téléphones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="errorBox">
                </div>
                <div class="modal-body">
                    <label for="classes">Classes :</label>
                    <center>
                        <select id="E" class="form-control" name="classes">
                            <option disabled="disabled" selected="selected">Choisir</option>
                            <?php
                                $lesClasses = $pdo->getParametre(4);
                                $telephonesEleves = $pdo->getTelephonesEleves();
                                $tout = "";
                                foreach ($lesClasses as $uneLigne) {
                                    echo '<option value="' . $uneLigne['NOM'] . '">' . $uneLigne['NOM'] . '</option>';
                                    $tout .= $uneLigne['NOM'] . " && ";
                                }
                                echo '<option value="Tout">Tout</option>';
                            ?>
                        </select>
                        <br>
                    </center>
                    <label>Téléphones:</label>
                    <br>
                    <center>
                        <textarea id="Clipboard_Eleves" class="form-control autosize-input" readonly></textarea>
                        <br>
                    </center>
                    <label>Message:</label>
                    <br>
                    <center>
                        <textarea id="message_Eleves" class="form-control autosize-input"></textarea>
                        <br>
                    </center>
                    <label>Piece jointe (JPEG ou PNG seulement):</label>
                    <center>
                        <input type="file" id="attach_Eleves"/>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                    <button type="button" id="sendEleves" class="btn btn-primary"> Envoyer</button>
                    <!-- data-dismiss="modal" -->
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pour les numéros de téléphones des parents d'élèves -->
    <div id="smsParents" class="modal fade bd-example-modal-lgP" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Téléphones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="errorBox">
                </div>
                <div class="modal-body">
                    <label for="classes">Classes :</label>
                    <center>
                        <select id="P" class="form-control" name="classes">
                            <option disabled="disabled" selected="selected">Choisir</option>
                            <?php
                                $lesClasses = $pdo->getParametre(4);
                                $telephonesParents = $pdo->getTelephonesParentsEleves();
                                foreach ($lesClasses as $uneLigne) {
                                    echo '<option value="' . $uneLigne['NOM'] . '">' . $uneLigne['NOM'] . '</option>';
                                }
                                echo '<option value="Tout">Tout</option>';
                            ?>
                        </select>
                        <br>
                    </center>
                    <label>Téléphones:</label>
                    <br>
                    <center>
                        <textarea id="Clipboard_Parents" class="form-control autosize-input" readonly></textarea>
                        <br>
                    </center>
                    <label>Message:</label>
                    <br>
                    <center>
                        <textarea id="message_Parents" class="form-control autosize-input"></textarea>
                        <br>
                    </center>
                    <label>Piece jointe (JPEG ou PNG seulement):</label>
                    <center>
                        <input type="file" id="attach_Parents"/>
                        <!-- <button type="button" data-clipboard-target="#Clipboard_Parents" class="clipboard-trigger btn-shadow btn-pill btn-wide btn btn-primary">
                          Copier le texte
                        </button> -->
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                    <button type="button" id="sendParents" class="btn btn-primary" data-dismiss="modal">Envoyer</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pour les numéros de téléphones des adhérents -->
    <div id="smsAdherents" class="modal fade bd-example-modal-lgA" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Téléphones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="errorBox">
                </div>
                <div class="modal-body">
                    <label>Téléphones:</label>
                    <br>
                    <center>
                        <textarea id="Clipboard_Adherents" class="form-control autosize-input" readonly>
                        <?php
                            $telephonesAdherents = $pdo->getTelephonesAdherents();
                            $numIndex = count($telephonesAdherents);
                            $i = 0;
                            foreach ($telephonesAdherents as $uneLigne) {
                                $uneLigne['TELEPHONE_PORTABLE'] = str_replace(",", "", $uneLigne['TELEPHONE_PORTABLE']);
                                $uneLigne['TELEPHONE_PORTABLE'] = str_replace(".", "", $uneLigne['TELEPHONE_PORTABLE']);
                                $uneLigne['TELEPHONE_PORTABLE'] = str_replace(" ", "", $uneLigne['TELEPHONE_PORTABLE']);
                                if (++$i === $numIndex) {
                                    $text = trim($uneLigne['TELEPHONE_PORTABLE']);
                                    echo $text;
                                } else {
                                    echo trim($uneLigne['TELEPHONE_PORTABLE']) . ',';
                                }

                            }
                        ?>
                        </textarea>
                        <br>
                    </center>
                    <label>Message:</label>
                    <br>
                    <center>
                        <textarea id="message_Adherents" class="form-control autosize-input"></textarea>
                        <br>
                    </center>
                    <label>Piece jointe (JPEG ou PNG seulement):</label>
                    <center>
                        <input type="file" id="attach_Adherents"/>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                    <button type="button" id="sendAdherents" class="btn btn-primary" data-dismiss="modal">Envoyer</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pour les numéros de téléphones de tout le monde -->
    <div id="smsTous" class="modal fade bd-example-modal-lgT" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Téléphones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="errorBox">
                </div>
                <div class="modal-body">
                    <br>
                    <label>Téléphones:</label>
                    <br>
                    <center>
                        <textarea rows="2" cols="10" id="Clipboard_Tous" class="form-control" readonly>
                        <?php
                            foreach ($telephonesParents as $uneLigne1) {
                                $uneLigne1['TÉLÉPHONE_DES_PARENTS'] = str_replace(",", "", $uneLigne1['TÉLÉPHONE_DES_PARENTS']);
                                $uneLigne1['TÉLÉPHONE_DES_PARENTS'] = str_replace(" ", "", $uneLigne1['TÉLÉPHONE_DES_PARENTS']);
                                $uneLigne1['TÉLÉPHONE_DES_PARENTS'] = str_replace(".", "", $uneLigne1['TÉLÉPHONE_DES_PARENTS']);
                                echo trim($uneLigne1['TÉLÉPHONE_DES_PARENTS']) . ',';
                            }

                            foreach ($telephonesEleves as $uneLigne2) {
                                $uneLigne2['TÉLÉPHONE_DE_L_ENFANT'] = str_replace(",", "", $uneLigne2['TÉLÉPHONE_DE_L_ENFANT']);
                                $uneLigne2['TÉLÉPHONE_DE_L_ENFANT'] = str_replace(".", "", $uneLigne2['TÉLÉPHONE_DE_L_ENFANT']);
                                $uneLigne2['TÉLÉPHONE_DE_L_ENFANT'] = str_replace("  ", "", $uneLigne2['TÉLÉPHONE_DE_L_ENFANT']);
                                echo trim($uneLigne2['TÉLÉPHONE_DE_L_ENFANT']) . ',';
                            }

                            $i = 0;
                            foreach ($telephonesIntervenants as $uneLigne3) {
                                $uneLigne3['TELEPHONE'] = str_replace(",", "", $uneLigne3['TELEPHONE']);
                                $uneLigne3['TELEPHONE'] = str_replace(".", "", $uneLigne3['TELEPHONE']);
                                $uneLigne3['TELEPHONE'] = str_replace(" ", "", $uneLigne3['TELEPHONE']);
                                echo trim($uneLigne3['TELEPHONE']) . ',';
                                if (++$i === $numIndex) {
                                    $text = trim($uneLigne3['TELEPHONE']);
                                    echo $text;
                                } else {
                                    echo trim($uneLigne3['TELEPHONE']) . ',';
                                }
                            }
                        ?>
                        </textarea>
                        <br>
                    </center>
                    <label>Message:</label>
                    <br>
                    <center>
                        <textarea id="message_Tous" class="form-control autosize-input"></textarea>
                        <br>
                    </center>
                    <label>Piece jointe (JPEG ou PNG seulement):</label>
                    <center>
                        <input type="file" id="attach_Tous"/>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                    <button type="button" id="sendTous" class="btn btn-primary" data-dismiss="modal">Envoyer</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal pour les messages personnalisés -->
    <div id="smsCustom" class="modal fade bd-example-modal-lgC" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Téléphones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="errorBox">
                </div>
                <div class="modal-body">
                    <label>Téléphones (06 ou 07 dans le format suivant: 06XXXXXXXX,07XXXXXXXX):</label>
                    <br>
                    <center>
                        <textarea id="Clipboard_Custom" class="form-control autosize-input"></textarea>
                        <br>
                    </center>
                    <label>Message:</label>
                    <br>
                    <center>
                        <textarea id="message_Custom" class="form-control autosize-input"></textarea>
                        <br>
                    </center>
                    <label>Piece jointe (JPEG ou PNG seulement):</label>
                    <center>
                        <input type="file" id="attach_Custom"/>
                        <!-- <button type="button" data-clipboard-target="#Clipboard_Parents" class="clipboard-trigger btn-shadow btn-pill btn-wide btn btn-primary">
                          Copier le texte
                        </button> -->
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quitter</button>
                    <button type="button" id="sendCustom" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <?php
                    if ((isset($numIntervenant)) && ($admin > 0)) {
                        echo '<a href="index.php?choixTraitement=administrateur&action=index"><div class="logo-src"></div></a>';
                    } else {
                        echo '<a href="index.php?choixTraitement=intervenant&action=index"><div class="logo-src"></div></a>';
                    }
                ?>
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
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                  <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                  </span>
                </button>
              </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-left">
                    <!-- On affiche la partie gauche de la navbar uniquement si l'utilisateur est admin ou super admin -->
                    <?php if ((isset($numIntervenant)) && ($admin > 0)) { ?>
                        <li class="btn-group nav-item">
                            <a id="sms-menu" class="nav-link" data-toggle="dropdown" aria-expanded="false">
                                SMS
                                <i class="fa fa-angle-down ml-2"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner">
                                        <div id="server-status-container" class="menu-header-image" style="background-color:blue;"></div>
                                        <div class="menu-header-content">
                                            <h5 class="menu-header-title">SMS</h5>
                                            <hp id="server-status" class="h3"></p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button id="linkI" type="button" tabindex="0" class="dropdown-item">Intervenants
                                    </button>
                                    <button id="linkE" type="button" tabindex="0" class="dropdown-item">Élèves</button>
                                    <button id="linkP" type="button" tabindex="0" class="dropdown-item">Parents d'élèves
                                    </button>
                                    <button id="linkA" type="button" tabindex="0" class="dropdown-item">Adhérents</button>
                                    <button id="linkT" type="button" tabindex="0" class="dropdown-item">Tous</button>
                                    <button id="linkC" type="button" tabindex="0" class="dropdown-item">Personnalisé
                                    </button>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </div>


                <div class="app-header-right">


                    <!-- On affiche l'année et les villes uniquement si l'utilisateur est un admin ou super admin -->
                    <?php
                        if ((isset($numIntervenant)) && ($admin > 0)) {?>
                        <div class="header-dotsIntervenant">
                            <div class="dropdown">
                                <div class="heure" style="  position: fixed; left: 45%; pointer-events: none; bottom: 92%;">
                                    <button type="button" aria-haspopup="true" aria-expanded="false"
                                            data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                    </button>
                                </div>
                                <div class="app-header-right">
                                    <!-- On affiche l'année et les villes uniquement si l'utilisateur est un admin ou super admin -->
                                    <?php if ((isset($numIntervenant)) && ($admin > 0)) { ?>
                                    <div class="header-dotsIntervenant">
                                        <div class="dropdown">
                                          <button type="button" id="goto-tabletinfo" aria-haspopup="true" aria-expanded="false" class="p-0 mr-2 btn btn-link" title="Tablette centre info">
                                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                              <span class="icon-wrapper-bg bg-info"></span>
                                              <img src="images/tabletteCentreInfo.png" alt="Icon de pc portable" class="icon" style="width: 30px; display: flex; margin-left:auto; margin-right:auto">
                                            </span>
                                          </button>
                                          <script>
                                              $(document).ready(() => {
                                                  $('#goto-tabletinfo').click(() => {
                                                      window.location.search = '?choixTraitement=tablette&action=indexInfo';
                                                  });
                                              });
                                          </script>
                                        </div>
                                        <div class="dropdown">
                                            <button type="button" id="goto-tablet" aria-haspopup="true" aria-expanded="false" class="p-0 mr-2 btn btn-link">
                                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                                    <span class="icon-wrapper-bg bg-primary"></span>
                                                    <span class="tablet"></span>
                                                </span>
                                            </button>
                                            <script>
                                                $(document).ready(() => {
                                                    $('#goto-tablet').click(() => {
                                                        window.location.search = '?choixTraitement=tablette&action=index';
                                                    });
                                                });
                                            </script>
                                        </div>
                                        <div class="dropdown">
                                            <div class="heure"
                                                 style="  position: fixed; left: 45%; pointer-events: none; bottom: 92%;">
                                                <button type="button" aria-haspopup="true" aria-expanded="false"
                                                        data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                                    <div id="date_heure"><span class="heure"
                                                                               style="font-size:30px">16:11:38</span><br><span
                                                                class="date"
                                                                style="font-size:12px">Vendredi 15 Janvier 2021</span></div>
                                                </button>
                                            </div>
                                            <button type="button" aria-haspopup="true" aria-expanded="false"
                                                    data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                                  <span class="icon-wrapper-bg bg-danger"></span>
                                                  <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                                                  <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
                                                </span>
                                            </button>
                                            <div tabindex="-1" role="menu" aria-hidden="true"
                                                 class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                                <div class="dropdown-menu-header mb-0">
                                                    <div class="dropdown-menu-header-inner bg-deep-blue">
                                                        <div class="menu-header-image opacity-1"
                                                             style="background-image: url(\'images/dropdown-header/city3.jpg\');"></div>
                                                        <div class="menu-header-content text-dark">
                                                            <h5 class="menu-header-title">Dernières informations
                                                                importantes</h5>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                                        <div class="scroll-area-sm">
                                                            <div class="scrollbar-container">
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
                                                                    <div class="tab-content" style="padding : 30px;">
                                                                        <div class="tab-pane active" id="tab-animated-0"
                                                                             role="tabpanel">
                                                                            <div class="scroll-area-sm">
                                                                                <div class="scrollbar-container">
                                                                                    <div class="p-3">
                                                                                        <div class="notifications-box">
                                                                                            <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                                                                <?php
                                                                                                    foreach ($lesnotifs as $uneNotif) {
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
                                                                                                          </div>';
                                                                                                    }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button type="button" aria-haspopup="true" aria-expanded="false"
                                                    data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                                    <span class="icon-wrapper-bg bg-primary"></span>
                                                    <b>
                                                    <?php
                                                        // Liste des années
                                                        $lesAnneesScolaires = $pdo->getAnneesScolaires2();

                                                        // Si il y a au moins une année
                                                        if (count($lesAnneesScolaires) > 0) {
                                                            foreach ($lesAnneesScolaires as $uneAnnee) {
                                                                // Si c'est l'année actuelle
                                                                if ($uneAnnee['ANNEE'] == $anneeEnCours) {
                                                                    // On écrit en gras
                                                                    echo '' . substr($uneAnnee['ANNEE'], 2) . '-' . substr($uneAnnee['ANNEE'] + 1, 2) . '';

                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    </b>
                                                </span>
                                            </button>
                                            <div tabindex="-1" role="menu" aria-hidden="true"
                                                 class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                                <div class="dropdown-menu-header">
                                                    <div class="dropdown-menu-header-inner bg-plum-plate">
                                                        <div class="menu-header-image"
                                                             style="background-image: url('images/dropdown-header/abstract4.jpg');"></div>
                                                        <div class="menu-header-content text-white">
                                                            <h5 class="menu-header-title">Années</h5>
                                                            <h6 class="menu-header-subtitle">Choisir une année</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="grid-menu grid-menu-xl grid-menu-3col">
                                                        <div class="no-gutters row">
                                                        <?php
                                                            // Liste des années
                                                            $lesAnneesScolaires = $pdo->getAnneesScolaires2();

                                                            // Si il y a au moins une année
                                                            if (count($lesAnneesScolaires) > 0) {
                                                                foreach ($lesAnneesScolaires as $uneAnnee) {
                                                                    // Si c'est l'année actuelle
                                                                    if ($uneAnnee['ANNEE'] == $anneeEnCours) {
                                                                        // On écrit en gras
                                                                        echo '<div class="col-sm-6 col-xl-4">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                                <b  style="margin-right:15px">' . $uneAnnee['ANNEE'] . '-' . ($uneAnnee['ANNEE'] + 1) . '</b>
                                                                            </button>
                                                                        </div>';
                                                                    } else {
                                                                        // Sinon on affiche un lien
                                                                        //echo '<a href="index.php?choixTraitement=administrateur&action=ModifParametreValidation&num=82&niveau=&type=7&nom='.$uneAnnee['ANNEE'].'" style="margin-right:15px">'.$uneAnnee['ANNEE'].'-'.($uneAnnee['ANNEE']+1).'</a>';
                                                                        echo '<div class="col-sm-6 col-xl-4">
                                                                            <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                              <a href="index.php?choixTraitement=administrateur&action=changerAnneeExtranet&anneeExtranet=' . $uneAnnee['ANNEE'] . '" style="margin-right:15px">' . $uneAnnee['ANNEE'] . '-' . ($uneAnnee['ANNEE'] + 1) . '</a>
                                                                            </button>
                                                                        </div>';
                                                                    }
                                                                }
                                                            } else {
                                                    // Sinon on affiche l'année en cours
                                                                echo '<div class="col-sm-6 col-xl-4">
                                                                    <button class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                                        <b>' . $anneeEnCours . '-' . ($anneeEnCours + 1) . '</b>
                                                                    </button>
                                                                </div>';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <button type="button" aria-haspopup="true" aria-expanded="false"
                                                    data-toggle="dropdown"
                                                    class="p-0 mr-2 btn btn-link">
                                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                                    <span class="icon-wrapper-bg bg-primary"></span>
                                                    <?php


                                                        foreach ($listeVilleExtranet as $uneVille) {
                                                            if ($uneVille == $_SESSION['villeExtranet']) {
                                                                echo '<span class="' . $uneVille . '"></span>';
                                                            }
                                                        }
                                                    ?>
                                                </span>
                                            </button>
                                            <div tabindex="-1" role="menu" aria-hidden="true"
                                                 class="rm-pointers dropdown-menu dropdown-menu-right">
                                                <div class="dropdown-menu-header">
                                                    <div class="dropdown-menu-header-inner pt-4 pb-4 bg-focus">
                                                        <div class="menu-header-image opacity-05"
                                                             style="background-image: url('images/dropdown-header/city2.jpg');"></div>
                                                        <div class="menu-header-content text-center text-white">
                                                            <h6 class="menu-header-subtitle mt-0"> Choisir la ville</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h6 tabindex="-1" class="dropdown-header"> Villes</h6>

                                                <!-- on affiches les villes -->
                                                <?php
                                                    foreach ($listeVilleExtranet as $uneVille) {

                                                        echo '<a href="index.php?choixTraitement=administrateur&action=changerVilleExtranet&villeExtranet=' . $uneVille . '" style="margin-right:15px">
                                                            <button type="button" tabindex="0" class="dropdown-item">
                                                              <span class="' . $uneVille . '"></span>
                                                              ' . ucfirst($uneVille) . '
                                                            </button>
                                                        </a>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php }

                        if ($admin == 0) {
                    ?>

                        <div class="dropdown">
                            <div class="heure"
                                 style="  position: fixed; left: 45%; pointer-events: none; bottom: 92%;">
                                <button type="button" aria-haspopup="true" aria-expanded="false"
                                        data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                    <div id="date_heure"><span class="heure"
                                                               style="font-size:30px">16:11:38</span><br><span
                                                class="date"
                                                style="font-size:12px">Vendredi 15 Janvier 2021</span></div>
                                </button>
                            </div>
                            <button type="button" aria-haspopup="true" aria-expanded="false"
                                    data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-danger"></span>
                                    <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                                    <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true"
                                         class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="dropdown-menu-header mb-0">
                                    <div class="dropdown-menu-header-inner bg-deep-blue">
                                        <div class="menu-header-image opacity-1"
                                             style="background-image: url(\'images/dropdown-header/city3.jpg\');"></div>
                                        <div class="menu-header-content text-dark">
                                            <h5 class="menu-header-title">Dernières informations
                                                importantes</h5>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                        <div class="scroll-area-sm">
                                            <div class="scrollbar-container">
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
                                                    <div class="tab-content" style="padding : 30px;">
                                                        <div class="tab-pane active" id="tab-animated-0"
                                                             role="tabpanel">
                                                            <div class="scroll-area-sm">
                                                                <div class="scrollbar-container">
                                                                    <div class="p-3">
                                                                        <div class="notifications-box">
                                                                            <div
                                                                                    class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                                            <?php
                                                                                foreach ($lesnotifs as $uneNotif) {
                                                                                     echo '<div class="vertical-timeline-item dot-success vertical-timeline-element">
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
                                                                                     </div>';
                                                                                }
                                                                            ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>


                        <div class="header-btn-lg pr-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                               class="p-0 btn">
                                                <img width="42" class="rounded-circle"
                                                     src="<?php echo 'photosIntervenants/' . $intervenant["PHOTO"] ?>"
                                                     alt="">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
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
                                                                    <div class="widget-content-left mr-3">
                                                                        <img width="42" class="rounded-circle"
                                                                             src="<?php echo 'photosIntervenants/' . $intervenant["PHOTO"] ?>"
                                                                             alt="">
                                                                    </div>
                                                                    <div class="widget-content-left">
                                                                        <!-- on affiche le nom et le prénom de l'intervenant -->
                                                                        <div
                                                                                class="widget-heading"><?php echo $intervenant["PRENOM"] . ' ' . $intervenant["NOM"] ?>
                                                                        </div>
                                                                        <div class="widget-subheading opacity-8">
                                                                            <?php if ($intervenant["ADMINISTRATEUR"] == 0) {
                                                                                echo "Intervenant";
                                                                            } elseif ($intervenant["ADMINISTRATEUR"] == 1) {
                                                                                echo "Administrateur";
                                                                            } else {
                                                                                echo "Super Administrateur";
                                                                            }
                                                                            ?>
                                                                        </div>
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
                                                <div class="scroll-area-xs" style="height: 150px;">
                                                    <div class="scrollbar-container ps">
                                                        <ul class="nav flex-column">
                                                            <li class="nav-item-header nav-item">Mon profil</li>
                                                            <li class="nav-item">
                                                                <a href="index.php?choixTraitement=intervenant&action=modifInfos"
                                                                   class="nav-link">
                                                                    Informations personnelles
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php
                                                    if ($intervenant["ADMINISTRATEUR"] == 0) {
                                                        echo '<ul class="nav flex-column">
                                                              <li class="nav-item-divider mb-0 nav-item"></li>
                                                            </ul>
                                                            <div class="grid-menu grid-menu-2col">
                                                                <div class="no-gutters row">
                                                                    <div class="col-sm-12"><a href="index.php?choixTraitement=intervenant&action=macarte" style="text-decoration:none;">
                                                                        <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                                            Voir ma carte<br><img src="./images/student-card.png" width="100" height="100"/>
                                                                        </button></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        ';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!--  on affiche le nom et le prénom de l'utilisateur, ainsi que s'il est intervenant ou pas -->
                                    <div class="widget-content-left  ml-3 header-user-info">
                                        <div
                                                class="widget-heading"> <?php echo $intervenant["PRENOM"] . ' ' . $intervenant["NOM"] ?></div>
                                        <div class="widget-subheading">

                                            <?php
                                                if ($intervenant["ADMINISTRATEUR"] == 0) {
                                                    echo "Intervenant";
                                                } elseif ($intervenant["ADMINISTRATEUR"] == 1) {
                                                    echo "Administrateur";
                                                } else {
                                                    echo "Super Administrateur";
                                                }
                                            ?>
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
                        <!-- l'intervenant est un utilisateur -->
                        <?php
                            if ((isset($numIntervenant)) && ($admin == 0)) {
                                echo '<ul class="vertical-nav-menu metismenu">
                                    <li class="app-sidebar__heading">
                                        <a href="index.php?choixTraitement=intervenant&action=index" aria-expanded="false" style="text-transform: uppercase; margin: 0.75rem 0; padding:0px; font-weight: bold; color: #3f6ad8; white-space: nowrap; position: relative;">Accueil</a>
                                    </li>
                                    <li class="app-sidebar__heading">Menu</li>
                                    <li>
                                        <a href="index.php?choixTraitement=intervenant&action=modifInfos" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-id"></i>
                                          Informations personnelles
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?choixTraitement=intervenant&action=Planning" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-check"></i>
                                          Disponibilités
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?choixTraitement=intervenant&action=recapPlanning" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-clock"></i>
                                          Heures effectuées
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?choixTraitement=administrateur&action=TrombiIntervenants" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-clock"></i>
                                          Trombinoscope
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?choixTraitement=intervenant&action=Documents" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-file"></i>
                                          Documents
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?choixTraitement=intervenant&action=Polycopies" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-file"></i>
                                          Polycopiés
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?choixTraitement=intervenant&action=plateformes" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-file"></i>
                                          Plateformes
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index.php?choixTraitement=intervenant&action=contact" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-file"></i>
                                          Contacter l\'association
                                        </a>
                                    </li>
                                </ul>';
                            }
                            if ((isset($numIntervenant)) && ($admin == 1)) {
                                echo '<ul class="vertical-nav-menu metismenu">
                                    <li class="app-sidebar__heading"><a href="index.php?choixTraitement=administrateur&action=index" aria-expanded="false" style="text-transform: uppercase; margin: 0.75rem 0; padding:0px; font-weight: bold; color: #3f6ad8; white-space: nowrap; position: relative;">Accueil</a></li>
                                    <li class="app-sidebar__heading">Élèves</li>
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=LesEleves" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-search"></i>
                                        Recherche
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=inscriptionEleves&action=index" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-plus"></i>
                                        Inscription
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=ElevesCSV" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-cloud-download"></i>
                                        Export
                                      </a>
                                    </li>

                                    
                                    
                                    
                                    
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=PayesImpayes">
                                        <i class="metismenu-icon pe-7s-cash"></i>
                                        Payés et impayés
                                      </a>
                                    </li>
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=Trombi">
                                        <i class="metismenu-icon pe-7s-camera"></i>
                                        Trombinoscope
                                      </a>
                                    </li>
                                    
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=InfosManquantes">
                                        <i class="metismenu-icon pe-7s-close-circle"></i>
                                        Infos manquantes
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=absents">
                                        <i class="metismenu-icon pe-7s-shield"></i>
                                        Liste eleves CLAS
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=importerEleve">
                                        <i class="metismenu-icon pe-7s-next-2"></i>
                                        Exporter vers une ville
                                      </a>
                                    </li>
                                    
                                    
                                    <li>
                                      <a href="#">
                                        <i class="metismenu-icon pe-7s-date"></i>
                                        Rendez-vous
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                      </a>
                                      <ul class="mm-collapse">
                                        <li>
                                          <a href="index.php?choixTraitement=administrateur&action=Calendrier">
                                            <i class="metismenu-icon"></i>
                                            Parents
                                          </a>
                                        </li>
                                        <li>
                                          <a href="index.php?choixTraitement=administrateur&action=planningBSB">
                                            <i class="metismenu-icon"></i>
                                            BSB
                                          </a>
                                        </li>
                                      </ul>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=eleve&action=plateformes">
                                        <i class="metismenu-icon pe-7s-browser"></i>
                                        Plateformes
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=eleve&action=Polycopies">
                                        <i class="metismenu-icon pe-7s-bookmarks"></i>
                                        Polycopiés
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=eleve&action=notifications">
                                        <i class="metismenu-icon pe-7s-bell"></i>
                                        Notifications
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=eleveevenement">
                                        <i class="metismenu-icon pe-7s-bell"></i>
                                        Liste élèves évènements
                                      </a>
                                    </li>
                                    
                                    <li class="app-sidebar__heading">Intervenants</li>
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=LesIntervenants" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-search"></i>
                                        Recherche
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=inscriptionIntervenants&action=index" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-plus"></i>
                                        Inscription
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=intervenantsHoraires" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-clock"></i>
                                        Horaires
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=ValidationPresence" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-note2"></i>
                                        Planning
                                      </a>
                                    </li>
                                    
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=TrombiIntervenants" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-camera"></i>
                                        Trombinoscope
                                      </a>
                                    </li>
                                    
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=InfosManquantes" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-close-circle"></i>
                                        Infos manquantes
                                      </a>
                                    </li>
                                    
                                    
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=PreparerFichesIndemnites" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-file"></i>
                                        Fiches indemnités
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=IntervenantCSV" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-cloud-download"></i>
                                        Export
                                      </a>
                                    </li>
                                    
                                    
                                    
                                    
                                    
                                    <li class="app-sidebar__heading">Présences</li>
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=index.php?choixTraitement=administrateur&action=appelElevesCase" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-user"></i>
                                        Élèves
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=appelIntervenant" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-user"></i>
                                        Intervenants
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=LesPresencesAUneDate" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-look"></i>
                                        Consulter
                                      </a>
                                    </li>
                                    
                                    
                                    
                                    
                                    
                                    <li class="app-sidebar__heading">Statistiques</li>
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=Statistiques" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-graph"></i>
                                        Statistiques
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=localisationEleves" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-map-2"></i>
                                        Localisation
                                      </a>
                                    </li>
                                    
                                    
                                    
                                    <li class="app-sidebar__heading">Stages</li>
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=Stages" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-search"></i>
                                        Gestion
                                      </a>
                                    </li>
                                    
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=ParametresStages" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-pen"></i>
                                        Création
                                      </a>
                                    </li>
                                    
                                    
                                    
                                    
                                  
                                    
                                    <li class="app-sidebar__heading">Centre informatique</li>
                                    <li>
                                    <a href="index.php?choixTraitement=administrateur&action=info_ajouterUneInscription" aria-expanded="false">
                                      <i class="metismenu-icon pe-7s-plus"></i>
                                      New Inscription
                                    </a>
                                  </li>
                                  
                                  <li>
                                    <a href="index.php?choixTraitement=administrateur&action=info_activites" aria-expanded="false">
                                      <i class="metismenu-icon pe-7s-smile"></i>
                                      Les activités
                                    </a>
                                  </li>
                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=info_inscriptions" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-search"></i>
                                        Les Inscrits
                                      </a>
                                    </li>

                                    <li>
                                      <a href="index.php?choixTraitement=administrateur&action=info_ajouterUneActivite" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-pen"></i>
                                        Add Activité
                                      </a>
                                    </li>
                                </ul>
                                ';
                            }
                            if ((isset($numIntervenant)) && ($admin == 2)) {
                                echo '<ul class="vertical-nav-menu metismenu">
                                    <li class="app-sidebar__heading"><a href="index.php?choixTraitement=administrateur&action=index" aria-expanded="false" style="text-transform: uppercase; margin: 0.75rem 0; padding:0px; font-weight: bold; color: #3f6ad8; white-space: nowrap; position: relative;">Accueil</a></li>
                                      <li class="app-sidebar__heading">Élèves</li>
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=LesEleves" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-search"></i>
                                          Recherche
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=inscriptionEleves&action=index" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-plus"></i>
                                          Inscription
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=ElevesCSV" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-cloud-download"></i>
                                          Export
                                        </a>
                                      </li>

                                      <li>
                                      <a href="index.php?choixTraitement=administrateur&action=listeCompleteEleves" aria-expanded="false">
                                        <i class="metismenu-icon pe-7s-cloud-download"></i>
                                        Exporter tous les élèves 
                                      </a>
                                    </li>
                            
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=PayesImpayes">
                                          <i class="metismenu-icon pe-7s-cash"></i>
                                          Payés et impayés
                                        </a>
                                      </li>
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=Trombi">
                                          <i class="metismenu-icon pe-7s-camera"></i>
                                          Trombinoscope
                                        </a>
                                      </li>
                            
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=InfosManquantes">
                                          <i class="metismenu-icon pe-7s-close-circle"></i>
                                          Infos manquantes
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=absents">
                                          <i class="metismenu-icon pe-7s-shield"></i>
                                          Absents
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=importerEleve">
                                          <i class="metismenu-icon pe-7s-next-2"></i>
                                          Exporter vers une ville
                                        </a>
                                      </li>
                            
                            
                                      <li>
                                        <a href="#">
                                          <i class="metismenu-icon pe-7s-date"></i>
                                          Rendez-vous
                                          <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                        </a>
                                        <ul class="mm-collapse">
                                          <li>
                                            <a href="index.php?choixTraitement=administrateur&action=Calendrier">
                                              <i class="metismenu-icon"></i>
                                              Parents
                                            </a>
                                          </li>
                                          <li>
                                            <a href="index.php?choixTraitement=administrateur&action=planningBSB">
                                              <i class="metismenu-icon"></i>
                                              BSB
                                            </a>
                                          </li>
                                        </ul>
                                      </li>
                            
                            
                                      <li>
                                        <a href="index.php?choixTraitement=eleve&action=plateformes">
                                          <i class="metismenu-icon pe-7s-browser"></i>
                                          Plateformes
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=eleve&action=Polycopies">
                                          <i class="metismenu-icon pe-7s-bookmarks"></i>
                                          Polycopiés
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=eleve&action=notifications">
                                          <i class="metismenu-icon pe-7s-bell"></i>
                                          Notifications
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=eleveevenement">
                                          <i class="metismenu-icon pe-7s-bell"></i>
                                          Liste élèves évènements
                                        </a>
                                      </li>
                            
                            
                                      <li class="app-sidebar__heading">Intervenants</li>
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=LesIntervenants" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-search"></i>
                                          Recherche
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=inscriptionIntervenants&action=index" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-plus"></i>
                                          Inscription
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=intervenantsHoraires" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-clock"></i>
                                          Horaires
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=ValidationPresence" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-note2"></i>
                                          Planning
                                        </a>
                                      </li>
                            
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=TrombiIntervenants" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-camera"></i>
                                          Trombinoscope
                                        </a>
                                      </li>
                            
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=InfosManquantes" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-close-circle"></i>
                                          Infos manquantes
                                        </a>
                                      </li>
                            
                            
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=PreparerFichesIndemnites" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-file"></i>
                                          Fiches indemnités
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=IntervenantCSV" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-cloud-download"></i>
                                          Export
                                        </a>
                                      </li>
                            
                            
                            
                            
                            
                                      <li class="app-sidebar__heading">Présences</li>
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=appelElevesCase" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-user"></i>
                                          Élèves
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=appelIntervenant" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-user"></i>
                                          Intervenants
                                        </a>
                                      </li>

                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=appelCentreInfoTest" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-user"></i>
                                          Centre info
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=LesPresencesAUneDate" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-look"></i>
                                          Consulter les présences
                                        </a>
                                      </li>
                            
                            
                                      <li class="app-sidebar__heading">Gestion</li>
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=parametres" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-config"></i>
                                          Paramètres
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=ModifParametreIndex&num=82" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-refresh-2"></i>
                                          Changement d\'année
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=Sauvegardes" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-download"></i>
                                          Sauvegarde
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=lesLogs" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-diskette"></i>
                                          Logs de connexion
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=evenements" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-ribbon"></i>
                                          Gérer les évènements
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=LesEvenements" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-ribbon"></i>
                                          Inscrits à un évènement
                                        </a>
                                      </li>
                            
                            
                            
                                      <li class="app-sidebar__heading">Statistiques</li>
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=Statistiques" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-graph"></i>
                                          Statistiques
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=localisationEleves" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-map-2"></i>
                                          Localisation
                                        </a>
                                      </li>
                            
                            
                            
                                      <li class="app-sidebar__heading">Stages</li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=Stages" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-search"></i>
                                          Gestion
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=ParametresStages" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-pen"></i>
                                          Création
                                        </a>
                                      </li>
                            
                            
                            
                            
                            
                                      <li class="app-sidebar__heading">Centre informatique</li>
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=info_rechercheInscriptions" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-search"></i>
                                          Recherche
                                        </a>
                                      </li>
                            
                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=info_inscriptionAdherentsFabLab" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-plus"></i>
                                          Inscription
                                        </a>
                                      </li>

                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=info_gererDesActivitesConso" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-plus"></i>
                                          Gestion des activités/conso
                                        </a>
                                      </li>

                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=bordereau" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-smile"></i>
                                          Bordereaux
                                        </a>
                                      </li>

                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=LesPresencesCentreInfo" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-look"></i>
                                          Consulter les présences
                                        </a>
                                      </li>

                                      <li>
                                        <a href="index.php?choixTraitement=administrateur&action=reglementCentreInfo" aria-expanded="false">
                                          <i class="metismenu-icon pe-7s-cash"></i>
                                          Gérer les règlements
                                        </a>
                                      </li>
                                </ul>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="app-main__outer">
                <div class="app-main__inner" id='sectionAimprimer2'>
                    <script>
                        function imprimer2(divName) {
                            var printContents = document.getElementById(divName).innerHTML;
                            var originalContents = document.body.innerHTML;
                            document.body.innerHTML = printContents;
                            window.print();
                            document.body.innerHTML = originalContents;
                        }
                    </script>

                    <?php if (empty($numIntervenant)){ ?>

                        <div class="app-main">
                            <div class="app-main__outer">
                                <div class="app-main__inner" id='sectionAimprimer2'>
                    <?php
                    }
                    ?>
    <?php
        }
    ?>