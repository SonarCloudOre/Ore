<div id="contenu">
    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=tablette&action=ValidAppelIntervenant">
        <fieldset>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Nom et prénom</h4>

                            <select name="unIntervenant" class="multiselect-dropdown form-control" data-live-search="true">
                                <option disabled="disabled" selected="selected">Choisir</option>
                                <?php foreach ($lesIntervenants as $unIntervenant) {
                                    if (!in_array($unIntervenant['ID_INTERVENANT'], $presents, true)) { ?>
                                        <option value="<?= $unIntervenant['ID_INTERVENANT'] ?>" name="unIntervenant">
                                            <?= $unIntervenant['NOM'] ?> <?= $unIntervenant['PRENOM'] ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>

                            <h4 class="card-title mt-3">Durée de presence</h4>

                            <div class="btn-group btn-group-lg btn-group-toggle w-100" data-toggle="buttons">
                                <label class="btn btn-lg btn-outline-secondary">
                                    <input type="radio" name="hours" id="1h" autocomplete="off" value="1">1h
                                </label>
                                <label class="btn btn-lg btn-outline-secondary">
                                    <input type="radio" name="hours" id="2h" autocomplete="off" value="2">2h
                                </label>
                                <label class="btn btn-lg btn-outline-secondary active">
                                    <input type="radio" name="hours" id="3h" autocomplete="off" value="3" checked>3h
                                </label>
                            </div>

                            <input value="Valider la présence" type="submit" class="mt-3 btn btn-lg btn-success w-100">
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>

<!-- custome.js -->
<script type="text/javascript" src="./vues/tablette/tablette.js"></script>
<script type="text/javascript" src="./vues/tablette/selectAutoOpen.js"></script>
