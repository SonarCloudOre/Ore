<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Chercher une activité
                    <?php

                    if (isset($activiteSelectionner)) {
                        echo '<div class="page-title-subheading">' . $activiteSelectionner["nom_activite"] . '</div>';
                    } else {
                        echo '<div class="page-title-subheading">Sélectionner une activité</div>';
                    }
                    ?>

                </div>
            </div>
            <?php
            if (isset($activiteSelectionner)) {

                if ($admin == 2) {
                    echo '
                                  <div class="page-title-actions">
                                  <div class="d-inline-block dropdown">
                                  <button type="button"  class="mr-2 btn btn-primary" onclick="history.back()">
                                   <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                                  </button>
                                  <a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette activité ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=info_supprimerUneActivite&num=' . $activiteSelectionner['id_activite'] . '\'; } else { void(0); }" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Supprimer l\'activité</a>
                                  </div>
                                  </div>
                              ';
                }
            } ?>
        </div>
    </div>


    <form method="POST" action="index.php?choixTraitement=administrateur&action=info_activites">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Chercher une activité</h4>

                        <select name="uneActivite" onchange="this.form.submit()"
                                class="multiselect-dropdown form-control" data-live-search="true"
                                style="max-width:300px">
                            <option disabled="disabled" selected="selected">Choisir</option>
                            <?php foreach ($lesActivites as $uneActivite) {
                                if (isset($activiteSelectionner) and $uneActivite['id_activite'] == $activiteSelectionner['id_activite']) {
                                    $selectionner = "selected='selected'";
                                } else {
                                    $selectionner = "";
                                }


                                echo " <option " . $selectionner . " value='" . $uneActivite['id_activite'] . "'>" . stripslashes($uneActivite['nom_activite']) . "</option>";
                            } ?>
                        </select>
                        <br>
                        <p style="text-align:left">
                            <a href="index.php?choixTraitement=administrateur&action=info_ajouterUneActivite"
                               class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Nouvelle activité</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <?php if (isset($activiteSelectionner)) { ?>


    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav" id="onglets"
                        role="tablist" style="clear:both">
                        <li role="presentation" class="nav-item">
                            <a href="#infos" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-file">Informations</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#inscriptions" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-user">Inscriptions</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#reglements" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-euro">Réglements</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#presences" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-edit">Présences</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#stats" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-stats">Statistiques</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="infos">

            <form method="POST" enctype="multipart/form-data"
                  action="index.php?choixTraitement=administrateur&action=info_modifierUneActivite">

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">

                                    <h4 class="card-title">Informations générales</h4>

                                    <label for="num">Numéro</label>
                                    <input class="form-control" name="num"
                                           value="<?php echo $activiteSelectionner['id_activite']; ?>"
                                           readonly="readonly" style="max-width:300px"><br>


                                    <label for="num">Nom</label>
                                    <input class="form-control" name="nom"
                                           value="<?php echo stripslashes($activiteSelectionner['nom_activite']); ?>"
                                           required="required" style="max-width:300px"><br>

                                    <input value="Modifier" type="submit" class="btn btn-success">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <hr>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">


                                <h4 class="card-title">Années</h4>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Année</th>
                                        <th>Supprimer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($lesAnnees as $uneAnnee) {
                                        echo '<tr>
<td>' . $uneAnnee['annee_activite'] . '-' . ($uneAnnee['annee_activite'] + 1) . '</td>
<td>';
                                        if ($admin == 2) {
                                            echo '<a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette année ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=info_supprimerUneAnneeActivite&num=' . $activiteSelectionner['id_activite'] . '&annee=' . $uneAnnee['annee_activite'] . '\'; } else { void(0); }" class="btn btn-danger"><span class="pe-7s-trash"></span></a>';
                                        }
                                        echo '</td>
</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <h4>Ajouter une année</h4>
                                <form method="POST" enctype="multipart/form-data"
                                      action="index.php?choixTraitement=administrateur&action=info_ajouterUneAnneeActivite">
                                    <input class="form-control" name="num" type="hidden"
                                           value="<?php echo $activiteSelectionner['id_activite']; ?>">
                                    <input class="form-control" name="annee" type="number"
                                           style="display:inline;width:100px" value="<?php echo $anneeEnCours; ?>">
                                    <input value="Ajouter" type="submit" class="btn btn-success">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div role="tabpanel" class="tab-pane" id="inscriptions">

            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Nouvelle inscription</h4>
                            <br>
                            <form method="POST" enctype="multipart/form-data"
                                  action="index.php?choixTraitement=administrateur&action=info_inscrire">
                                <div class="form-group">
                                    <input type="hidden" name="uneActivite"
                                           value="<?php echo $activiteSelectionner['id_activite']; ?>">
                                    <select name="uneInscription" class="form-control" data-live-search="true"
                                            style="max-width:300px;">
                                        <option disabled="disabled" selected="selected">Choisir</option>
                                        <?php // On parcours toutes les inscriptions
                                        foreach ($lesInscriptionsTotales as $uneInscriptionTotale) {

                                            $desactive = '';
                                            // Si la personne est déjà inscrite à cette activité
                                            foreach ($lesInscriptions as $uneInscription) {
                                                if ($uneInscriptionTotale['id_inscription'] == $uneInscription['id_inscription']) {
                                                    $desactive = ' disabled="disabled"';
                                                }
                                            }
                                            echo " <option $desactive value='" . $uneInscriptionTotale['id_inscription'] . "'>" . stripslashes($uneInscriptionTotale['nom_inscription']) . " " . stripslashes($uneInscriptionTotale['prenom_inscription']) . "</option>";
                                        } ?>
                                    </select> <br><input value="Inscrire" type="submit" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>


            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Inscriptions</h4>
                    <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Tél 1</th>
                            <th>Tél 2</th>
                            <th>Adresse</th>
                            <th>CP</th>
                            <th>Ville</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        // On parcours les inscriptions
                        $nbInscrits = 0;
                        foreach ($lesInscriptions as $uneInscription) {
                            $nbInscrits++;
                            echo '<tr>
<td><a href="index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $uneInscription['id_inscription'] . '">' . $uneInscription['nom_inscription'] . '</a></td>
<td><a href="index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $uneInscription['id_inscription'] . '">' . $uneInscription['prenom_inscription'] . '</a></td>
<td><a href="mailto:' . $uneInscription['email_inscription'] . '">' . $uneInscription['email_inscription'] . '</a></td>
<td><a href="tel:' . $uneInscription['tel1_inscription'] . '">' . $uneInscription['tel1_inscription'] . '</a></td>
<td><a href="tel:' . $uneInscription['tel2_inscription'] . '">' . $uneInscription['tel2_inscription'] . '</a></td>
    <td><a href="tel:' . $uneInscription['adresse_inscription'] . '">' . $uneInscription['adresse_inscription'] . '</a></td>

        <td><a href="tel:' . $uneInscription['cp_inscription'] . '">' . $uneInscription['cp_inscription'] . '</a></td>

            <td><a href="tel:' . $uneInscription['ville_inscription'] . '">' . $uneInscription['ville_inscription'] . '</a></td>

<td>
    <a href="index.php?choixTraitement=administrateur&action=info_ajouterUnReglement&uneActivite=' . $activiteSelectionner['id_activite'] . '&uneInscription=' . $uneInscription['id_inscription'] . '" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-euro"></span> Ajouter un réglement</a>
    ';
                            if ($admin == 2) {
                                echo '<a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment désinscrire cette inscription ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=info_desinscrire&uneInscription=' . $uneInscription['id_inscription'] . '&uneActivite=' . $activiteSelectionner['id_activite'] . '\'; } else { void(0); }" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Désinscrire</a>';
                            }

                            echo '</td>
</tr>';
                        }

                        // Message d'information si il n'y a aucune inscription
                        if ($nbInscrits == 0) {
                            echo '<div class="alert alert-info col-md-4" role="alert">Aucune inscription enregistrée pour le moment.</div>';
                        } else {
                            echo '<div class="alert alert-info col-md-4" role="info">' . $nbInscrits . ' personne(s) inscrite(s).</div>';
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div role="tabpanel" class="tab-pane" id="reglements">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Réglements</h4>

                            <br>

                            <p>
                                <a href="index.php?choixTraitement=administrateur&action=info_ajouterUnReglement&uneActivite=<?php echo $activiteSelectionner['id_activite']; ?>"
                                   class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Ajouter un
                                    réglement</a>
                            </p>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Inscription</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>N° de Transaction</th>
                                    <th>Banque</th>
                                    <th>Montant</th>
                                    <th colspan="3">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $montantTotal = 0;
                                foreach ($lesReglements as $unReglement) {
                                    echo '<tr>
<td><a href="index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $unReglement['id_inscription'] . '">' . $unReglement['nom_inscription'] . ' ' . $unReglement['prenom_inscription'] . '</a></td>
        <td>' . date('d/m/Y', strtotime($unReglement['date_reglement'])) . '</td>
<td>';
                                    foreach ($lesTypesReglements as $leTypedeReglement) {
                                        if ($leTypedeReglement['ID'] == $unReglement['type_reglement']) {
                                            echo $leTypedeReglement['NOM'];
                                        }
                                    }
                                    echo '</td>
<td>' . $unReglement['num_transaction_reglement'] . '</td>
<td>' . stripslashes($unReglement['banque_reglement']) . '</td>
<td><b>' . $unReglement['montant_reglement'] . ' €</b></td>
<td><a href="index.php?choixTraitement=administrateur&action=info_modifierUnReglement&unReglement=' . $unReglement['id_reglement'] . '&activite=' . $activiteSelectionner['id_activite'] . '&inscription=' . $unReglement['id_inscription'] . '" class="btn btn-primary"><span class="pe-7s-pen"></span></a></td>
<td><a href="index.php?choixTraitement=administrateur&action=recuInfo&num=' . $unReglement['id_reglement'] . '&inscription=' . $unReglement['id_inscription'] . '&activite=' . $activiteSelectionner['id_activite'] . '" class="btn btn-secondary"><span class="pe-7s-print"></span></a></td>
<td>';
                                    if ($admin == 2) {
                                        echo '<a href="index.php?choixTraitement=administrateur&action=info_supprimerUnReglement&unReglement=' . $unReglement['id_reglement'] . '&uneActivite=' . $activiteSelectionner['id_activite'] . '" class="btn btn-danger"><span class="pe-7s-trash"></span></a>';
                                    }
                                    echo '</td>
</tr>';
                                    $montantTotal = ($montantTotal + $unReglement['montant_reglement']);
                                }
                                ?>
                                <tr>
                                    <th colspan="5" style="text-align:right">Total :</th>
                                    <th colspan="4"><?php echo $montantTotal; ?> €</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div role="tabpanel" class="tab-pane" id="stats">
            <?php
            $couleurs = array('blue', 'green', 'red', 'orange', 'brown', 'gray', 'pink', 'lime', 'maroon', 'olive', 'navy', 'teal', 'yellow', 'purple');
            ?>


            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <p>Il y a <b><?php echo $nbInscrits; ?></b> personne(s) inscrite(s).</p>

                            <p>Il y a eu en moyenne <b><?php echo $stats_moyennePresences; ?></b> personne(s)
                                présente(s) par date.</p>
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


            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div id="map"></div>

                            <style type="text/css">
                                #map {
                                    width: 1100px;
                                    height: 700px;
                                }
                            </style>


                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div role="tabpanel" class="tab-pane" id="presences">

            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Présences</h4>

                            <br>

                            <p>
                                <a href="index.php?choixTraitement=administrateur&action=info_fichePresences&num=<?php echo $activiteSelectionner['id_activite']; ?>"
                                   class="btn btn-info"><span class="glyphicon glyphicon-print"></span> Fiche de
                                    présence</a>
                                <a href="index.php?choixTraitement=administrateur&action=info_saisirPresences&num=<?php echo $activiteSelectionner['id_activite']; ?>"
                                   class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Saisir les
                                    présences</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php
                $iTotal = 0;
                $datePrecedente = '';
                // On parcours les présences
                foreach ($lesPresences as $unePresenceDate) {

                    $matinOuAprem = array('matin', 'après-midi');

                    $dateComplete = $unePresenceDate['date_presence'] . ' ' . $unePresenceDate['matin_ap_presence'];

// Si on a changé de date
                    if ($datePrecedente != $dateComplete) {

// On écrit le total de la date précédente, si elle existe
                        if ($iTotal > 0) {
                            echo '<tr><td colspan="3">' . $i . ' présence(s).</td></tr>
</tbody></table></div></div></div>';
                        }

// On le remet à zéro pour la prochaine date
                        $i = 0;

// On maj la date précédente
                        $datePrecedente = $dateComplete;

// On écrit la prochaine date
                        echo '



<div class="col-md-6">
<div class="main-card mb-3 card">
<div class="card-body">
<h4 class="card-title">' . date('d/m/Y', strtotime($unePresenceDate['date_presence'])) . ' ' . $matinOuAprem[$unePresenceDate['matin_ap_presence']] . '</h4>

<table class="mb-0 table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';
                    }

// On écrit la présence
                    echo '<tr>
    <td><a href="index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $unePresenceDate['id_inscription'] . '">' . $unePresenceDate['nom_inscription'] . '</a></td>
    <td><a href="index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $unePresenceDate['id_inscription'] . '">' . $unePresenceDate['prenom_inscription'] . '</a></td>
    <td>';

// Bouton supprimer réservé à l'admin
                    if ($admin == 2) {
                        echo '<a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment désinscrire cette présence ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=info_supprimerUnePresence&num=' . $unePresenceDate['id_presence'] . '&uneActivite=' . $activiteSelectionner['id_activite'] . '\'; } else { void(0); }" class="btn btn-danger"><span class="pe-7s-trash"></span></a>';
                    }

                    echo '</td></tr>';

// On comptabilise la présence
                    $i++;
                    $iTotal++;
                }

                // Fin du tableau
                echo '</tbody></table>';


                // Si il n'y a aucune présence pour cette activité
                if ($iTotal == 0) {
                    echo '<div class="alert alert-info col-md-4" role="alert">Aucune présence enregistrée pour le moment.</div>';
                }

                ?>

            </div>


            <?php } ?>


            <script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
            <script type="text/javascript"
                    src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
            <script type="text/javascript" src="./js/form-components/input-select.js"></script>


            <script type="text/javascript">
                $('#onglets a').click(function (e) {
                    e.preventDefault()
                    $(this).tab('show')
                })
            </script>


            <script>
                var map = L.map('map').setView([47.322047, 5.04148], 13);

                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'pk.eyJ1Ijoib3JlLXF1ZXRpZ255IiwiYSI6ImNrbzMwMnd2bzE0cXQycXBnY3BrOGpxZ3gifQ.eA2lCbOvIhxh973t1khghw'
                }).addTo(map);

                <?php
                // On parcours les inscriptions
                $i = 0;
                foreach ($lesInscriptions as $uneInscription) {

// Si l'adresse n'est pas vide
                    if ($uneInscription['adresse_inscription'] != "") {

                        $lat = 0;
                        $lon = 0;

// Si les coordonnées ne sont déjà enregistrées
                        if ($uneInscription['lat_inscription'] == '0' or $uneInscription['lat_inscription'] == '') {


                            // Sinon, on récupère les coordonnées GPS de l'adresse
                            $address = addslashes($uneInscription['adresse_inscription']) . ' ' . addslashes($uneInscription['cp_inscription']) . ' ' . addslashes($uneInscription['ville_inscription']) . ', France';

                            $request_url = "https://maps.googleapis.com/maps/api/geocode/xml?key=AIzaSyA_C2zsDEHSud_LkZbu4KuoTwyx6hIpDQU&address=" . $address . "&sensor=true";

                            $xml = simplexml_load_file($request_url) or die("url not loading");

                            $status = $xml->status;

                            if ($status == "OK") {
                                $lat = $xml->result->geometry->location->lat;
                                $lon = $xml->result->geometry->location->lng;
                            }

                            // On met à jour les coordonnées dans l'inscription
                            $pdo->info_majCoordonnees($uneInscription['id_inscription'], $lat, $lon);
                        } else {
                            $lat = $uneInscription['lat_inscription'];
                            $lon = $uneInscription['lon_inscription'];

                        }


                        // On crée la bulle d'info
                        echo "L.marker([" . $lat . ", " . $lon . "]).addTo(map)
.bindPopup('<b><a href=index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=" . $uneInscription['id_inscription'] . ">" . addslashes($uneInscription['nom_inscription']) . " " . addslashes($uneInscription['prenom_inscription']) . "</a></b><br>" . addslashes($uneInscription['adresse_inscription']) . " " . addslashes($uneInscription['cp_inscription']) . " " . addslashes($uneInscription['ville_inscription']) . "');
";

                        $i++;

                    }
                }
                ?>
            </script>


            <script type="text/javascript">
                var ctx1 = document.getElementById("stats_presences");
                var myChart1 = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: [<?php
                            $i = 0;
                            foreach ($stats_totalPresences as $unePresence) {
                                if ($i > 0) {
                                    echo ',';
                                }
                                echo "'" . date('d/m/Y', strtotime($unePresence['date_presence'])) . " (" . $unePresence['COUNT(*)'] . ")'";
                                $i++;
                            }
                            ?>],
                        datasets: [{
                            label: 'Evolution des présences',
                            data: [<?php
                                $i = 0;
                                foreach ($stats_totalPresences as $unePresence) {
                                    if ($i > 0) {
                                        echo ',';
                                    }
                                    echo "'" . $unePresence['COUNT(*)'] . "'";
                                    $i++;
                                } ?>],
                            backgroundColor: [
                                'rgba(0,0,255,0.5)',
                            ],
                            borderColor: [
                                'blue',
                            ]
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
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
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
                                echo "'" . $uneStat['sexe_inscription'] . " (" . $uneStat['COUNT(*)'] . ")'";
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
                                echo "'" . $uneStat['ville_inscription'] . " (" . $uneStat['COUNT(*)'] . ")'";
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
                        $age = (date('Y', time()) - $uneStat['YEAR(`ddn_inscription`)']);

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
