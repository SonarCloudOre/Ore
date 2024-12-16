<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Saisir les présences
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data"
                          action="index.php?choixTraitement=administrateur&action=info_saisirPresences">

                        <div class="form-group">

                            <label for="date">Choisir l'activité</label><br>
                            <select name="num" onchange="this.form.submit()" class="form-control"
                                    data-live-search="true">
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

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php // Si une activité a été choisie
    if (isset($lesInscriptions)) { ?>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data"
                              action="index.php?choixTraitement=administrateur&action=info_saisirPresencesValidation">

                            <input class="form-control" name="num" type="hidden" value="<?php echo $num; ?>">

                            <div class="form-group">

                                <label for="date">Date</label><br>
                                <input class="form-control" name="date" type="date"
                                       value="<?php echo date("d-m-Y"); ?>">
                                <?php //formulaireDate(0,0,0, "date"); ?>
                                <br><br>

                                <label for="periode">Période</label>
                                <select class="form-control" name="periode">
                                    <option value="0">Matin</option>
                                    <option value="1">Après-midi</option>
                                </select>
                                <hr>
                                <br>

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <center>Présent ?</center>
                                        </th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($lesInscriptions as $uneInscription) {
                                        echo '<tr>
        <td><center><input type="checkbox" name="presences[]" value="' . $uneInscription['id_inscription'] . '"></center></td>
        <td>' . $uneInscription['nom_inscription'] . '</td>
        <td>' . $uneInscription['prenom_inscription'] . '</td>
    </tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>


                                <input value="Ajouter" type="submit" class="btn btn-success">

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>
