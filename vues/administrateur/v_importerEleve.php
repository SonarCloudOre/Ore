<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-date icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Exporter
                    <div class="page-title-subheading">Exporter un élève vers une ville</div>
                </div>
            </div>
        </div>
    </div>


    <fieldset>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='main-card mb-12 card'>
                    <div class='card-body'>
                        <form name="frmConsultFrais" method="POST"
                              action="index.php?choixTraitement=administrateur&action=importerEleve">

                            <input type="hidden" name="uneVilleOrigine" value="<?php echo $villeExtranet; ?>">
                            <input type="hidden" name="anneeEnCours" value="<?php echo $anneeEnCours; ?>">
                            <h4 class="card-title">Exporter</h4>
                            <label for="unEleve">Exporter l'élève</label><br>
                            <SELECT name="unEleve" class="form-control" data-live-search="true"
                                    style="max-width : 300px;">
                                <option disabled="disabled" selected="selected">Choisir</option>
                                <?php foreach ($lesEleves as $unEleve) {
                                    echo " <option value='" . $unEleve['ID_ELEVE'] . "' name='unEleve'>" . $unEleve['NOM'] . " " . $unEleve['PRENOM'] . "</option>";
                                }
                                ?> </select><br><br>

                            <label for="uneVille">Vers la ville</label><br>
                            <select name="uneVille" class="form-control" data-live-search="true"
                                    style="max-width : 300px;">
                                <?php foreach ($listeVilleExtranet as $uneVille) {

                                    // Si ce n'est pas la ville actuelle
                                    if ($uneVille != $villeExtranet) {
                                        echo '<option value="' . $uneVille . '">' . ucfirst($uneVille) . '</option>';
                                    }

                                } ?>
                            </select><br><br>

                            <input type="submit" class="btn btn-success" value="Exporter">


                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
