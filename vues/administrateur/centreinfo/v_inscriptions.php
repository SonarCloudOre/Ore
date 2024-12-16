<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Centre Informatique
                    <?php

                    if (isset($inscriptionSelectionner)) {
                        echo '<div class="page-title-subheading">Inscription de ' . $inscriptionSelectionner['prenom_inscription'] . ' ' . $inscriptionSelectionner['nom_inscription'] . ' </div>';
                    } else {
                        echo '<div class="page-title-subheading">Sélectionner une personne pour accéder à sa fiche</div>';
                    }
                    ?>

                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <a style="float:left"
                       href="index.php?choixTraitement=administrateur&action=info_inscriptionAdherentsFabLab">
                        <button type="button" class="mr-2 btn btn-success">
                            <span class="glyphicon glyphicon-plus">Inscrire</span>
                        </button>
                    </a>
                </div>
                <?php
                if (isset($inscriptionSelectionner)) {


                    if ($admin == 2) {
                        echo '
                                               <a style="float:right" href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette inscription ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=info_supprimerUneInscription&num=' . $inscriptionSelectionner['id_inscription'] . '\'; } else { void(0); }">
                                               <button type="button"  class="mr-2 btn btn-danger">
                                               <span class="glyphicon glyphicon-trash">Supprimer l\'inscription</span>
                                               </button>
                                               </a>';
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <form method="POST" action="index.php?choixTraitement=administrateur&action=info_inscriptions">
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">

                        <center>
                            <h2>Chercher une inscription</h2>
                            <br/>
                            <select name="uneInscription" onchange="this.form.submit()"
                                    class="multiselect-dropdown form-control" data-live-search="true"
                                    style="max-width:300px">
                                <option disabled="disabled" selected="selected">Choisir</option>
                                <?php foreach ($lesInscriptions as $uneInscription) {
                                    if (isset($inscriptionSelectionner) and $uneInscription['id_inscription'] == $inscriptionSelectionner['id_inscription']) {
                                        $selectionner = "selected='selected'";
                                    } else {
                                        $selectionner = "";
                                    }


                                    echo " <option " . $selectionner . " value='" . $uneInscription['id_inscription'] . "'>" . stripslashes($uneInscription['nom_inscription']) . " " . stripslashes($uneInscription['prenom_inscription']) . "</option>";
                                } ?>
                            </select>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php if (isset($inscriptionSelectionner)) { ?>

    <hr>


    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav" id="onglets"
                        role="tablist" style="clear:both">
                        <li role="presentation" class="active nav-item">
                            <a href="#infos" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-file">Informations</span> </a></li>
                        <li role="presentation" class="nav-item">
                            <a href="#activites" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-folder-open">Activités</span></a></li>
                        <li role="presentation" class="nav-item">
                            <a href="#documents" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-file">Documents</span></a></li>
                        <li role="presentation" class="nav-item">
                            <a href="#visites" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span class="glyphicon glyphicon-eye-open">Visites</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="infos">

            <form method="POST" enctype="multipart/form-data"
                  action="index.php?choixTraitement=administrateur&action=info_modifierUneInscription">

                <div class="form-group">

                    <br>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h3>Informations générales</h3>

                                    <div class="row">
                                        <div class="position-relative form-group col-md-6">
                                            <label for="num">Numéro</label>
                                            <input class="form-control" name="num"
                                                   value="<?php echo $inscriptionSelectionner['id_inscription']; ?>"
                                                   readonly="readonly"><br>
                                        </div>
                                        <div class="position-relative form-group col-md-6">
                                            <label for="ddn">Date d'inscription</label>
                                            <input class="form-control" name="date"
                                                   value="<?php echo $inscriptionSelectionner['date_inscription']; ?>"
                                                   readonly="readonly">
                                            <i>(au format <?php echo date('Y-m-d H:i:s', time()); ?>)</i><br><br>
                                        </div>
                                        <div class="position-relative form-group col-md-6">
                                            <label for="num">Nom</label>
                                            <input class="form-control" name="nom"
                                                   value="<?php echo stripslashes($inscriptionSelectionner['nom_inscription']); ?>"><br>
                                        </div>
                                        <div class="position-relative form-group col-md-6">
                                            <label for="num">Prénom</label>
                                            <input class="form-control" name="prenom"
                                                   value="<?php echo stripslashes($inscriptionSelectionner['prenom_inscription']); ?>"><br>
                                        </div>
                                        <div class="position-relative form-group col-md-6">
                                            <label for="ddn">Date de naissance</label>
                                            <input type="date" class="form-control" name="ddn"
                                                   value="<?php echo $inscriptionSelectionner['ddn_inscription']; ?>">
                                            <br><br>
                                        </div>
                                        <div class="position-relative form-group col-md-6">
                                            <label for="sexe">Sexe</label>
                                            <select name="sexe" class="form-control">
                                                <option
                                                    value=""<?php if ($inscriptionSelectionner['sexe_inscription'] == "") {
                                                    echo ' selected="selected"';
                                                } ?> disabled="disabled">Choisir
                                                </option>
                                                <option
                                                    value="F"<?php if ($inscriptionSelectionner['sexe_inscription'] == "F") {
                                                    echo ' selected="selected"';
                                                } ?>>Femme
                                                </option>
                                                <option
                                                    value="H"<?php if ($inscriptionSelectionner['sexe_inscription'] == "H") {
                                                    echo ' selected="selected"';
                                                } ?>>Homme
                                                </option>
                                            </select><br>
                                        </div>

                                        <div class="position-relative form-group col-md-6">
                                            <label for="tel1">Téléphone 1</label>
                                            <input class="form-control" type="text" name="tel1"
                                                   value="<?php echo $inscriptionSelectionner['tel1_inscription']; ?>"><br>
                                        </div>
                                        <div class="position-relative form-group col-md-6">
                                            <label for="tel2">Téléphone 2</label>
                                            <input class="form-control" type="text" name="tel2"
                                                   value="<?php echo $inscriptionSelectionner['tel2_inscription']; ?>"><br>
                                        </div>
                                        <div class="position-relative form-group col-md-6">
                                            <label for="tel1">E-mail</label>
                                            <input class="form-control" name="email"
                                                   value="<?php echo stripslashes($inscriptionSelectionner['email_inscription']); ?>"><br>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h3>Adresse postale</h3>

                                    <label for="tel1">Adresse</label>
                                    <input class="form-control" type="text" name="adresse"
                                           value="<?php echo $inscriptionSelectionner['adresse_inscription']; ?>"><br>

                                    <label for="tel2">Code postal</label>
                                    <input class="form-control" type="text" name="cp"
                                           value="<?php echo $inscriptionSelectionner['cp_inscription']; ?>"><br>

                                    <label for="tel1">ville</label>
                                    <input class="form-control" name="ville"
                                           value="<?php echo stripslashes($inscriptionSelectionner['ville_inscription']); ?>"><br>

                                    <?php //formulaireAdresse(stripslashes($inscriptionSelectionner['adresse_inscription']), $inscriptionSelectionner['cp_inscription'], stripslashes($inscriptionSelectionner['ville_inscription'])); ?>

                                    <label for="ville">Coordonnées GPS</label>
                                    <input class="form-control"
                                           value="<?php echo $inscriptionSelectionner['lat_inscription'] . ', ' . $inscriptionSelectionner['lon_inscription']; ?>"
                                           readonly="readonly"><br>
                                    <input value="Modifier" type="submit" class="btn btn-success">
                                </div>
                            </div>
                        </div>


                    </div>


                </div>

            </form>

        </div>

        <div role="tabpanel" class="tab-pane" id="annees">


        </div>

        <div role="tabpanel" class="tab-pane" id="activites">

            <div class="form-group">


                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h3>Inscriptions aux activités</h3>

                                <ul>
                                    <?php

                                    // On parcours les activité
                                    $i = 0;
                                    foreach ($lesActivitesInscrites as $uneActivite) {
                                        $i++;
                                        echo '<li><a href="index.php?choixTraitement=administrateur&action=info_activites&uneActivite=' . $uneActivite['id_activite'] . '">' . stripslashes($uneActivite['nom_activite']) . '</a></li>';
                                    }

                                    // Message d'information si il n'y a aucune inscription
                                    if ($i == 0) {
                                        echo '<div class="alert alert-info" role="alert">Aucune inscription enregistrée pour le moment.</div>';
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div role="tabpanel" class="tab-pane" id="documents">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">

                            <h3>Envoyer un fichier</h3>

                            <div class="form-group">

                                <form method="POST" enctype="multipart/form-data"
                                      action="index.php?choixTraitement=administrateur&action=info_envoyerDocument">

                                    <input type="hidden" name="MAX_FILE_SIZE" value="134217728"/>

                                    <input class="form-control" name="num" type="hidden"
                                           value="<?php echo $inscriptionSelectionner['id_inscription']; ?>"
                                           readonly="readonly"><br>

                                    <label for="num">Fichier</label>

                                    <input class="form-control" type="file" name="fichier" required="required"><br>

                                    <label for="commentaire">Commentaire</label>

                                    <input class="form-control" name="commentaire"><br>

                                    <input value="Envoyer" type="submit" class="btn btn-success">

                                </form>

                            </div>

                            <hr>

                            <h3>Fichiers envoyés</h3>

                            <table class="table">

                                <thead>

                                <tr>

                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Commentaire</th>
                                    <th>Taille</th>
                                    <th>Ajouté le</th>
                                    <th colspan="2">Actions</th>

                                </tr>

                                </thead>

                                <tbody>

                                <?php
                                $lesUnites = array('octet', 'Ko', 'Mo', 'Go', 'To');
                                $base = 1024;

                                // On parcours les documents
                                $i = 0;
                                foreach ($lesDocuments as $unDocument) {

                                    // On récupère les informations sur le documents
                                    $nom = $unDocument['nom_document'];
                                    $type = $unDocument['type_document'];
                                    $taille = $unDocument['taille_document'];

                                    for ($i = 0; $i < count($lesUnites); $i++) {
                                        if ($taille >= pow($base, $i)) {
                                            $taille = round($taille / pow($base, $i));
                                            $unite = $lesUnites[$i];
                                        } else break;
                                    }

                                    echo '                  <tr>
                                <td><small><b>' . $nom . '</b></small></td>
                                <td>' . $type . '</td>
                                <td>' . stripslashes($unDocument['commentaire_document']) . '</td>
                                <td>' . $taille . ' ' . $unite . '</td>
                                <td>' . date('d/m/Y H:i', strtotime($unDocument['date_document'])) . '</td>
                                <td><a href="index.php?choixTraitement=administrateur&action=info_telechargerDocument&id_document=' . $unDocument['id_document'] . '" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download-alt"></span> Télécharger</a></td>
                                <td>';
                                    if ($admin == 2) {
                                        echo '<a href="index.php?choixTraitement=administrateur&action=info_supprimerDocument&id=' . $unDocument['id_document'] . '&num=' . $inscriptionSelectionner['id_inscription'] . '" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Supprimer</a>';
                                    }
                                    echo '</td></tr>';

                                    $i++;
                                }

                                ?>

                                </tbody>

                            </table>

                            <?php
                            // Message d'information si il n'y a aucun document
                            if ($i == 0) {
                                echo '<div class="alert alert-info" role="alert">Aucun document envoyé pour le moment.</div>';
                            } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div role="tabpanel" class="tab-pane" id="visites">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h3>Liste des visites</h3>

                            <div class="alert alert-info col-md-3" role="alert"><b><?php echo count($lesVisites); ?></b>
                                visites enregistrées.
                            </div>

                            <table class="table">

                                <thead>

                                <tr>

                                    <th>Date</th>
                                    <th>PC n°</th>
                                    <th>Logiciel</th>
                                    <th>URL</th>
                                </tr>

                                </thead>

                                <tbody>

                                <?php
                                foreach ($lesVisites as $uneVisite) {
                                    echo '<tr>
        <td>' . date('d/m/Y H:i', strtotime($uneVisite['date_visite'])) . '</td>
        <td>' . $uneVisite['pc_visite'] . '</td>
        <td>' . $uneVisite['logiciel_visite'] . '</td>
        <td>' . $uneVisite['url_visite'] . '</td>
    </tr>';
                                }

                                ?>
                                </tbody>
                            </table>
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

        <?php } ?>

    </div>


    <script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
    <script type="text/javascript"
            src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="./js/form-components/input-select.js"></script>
