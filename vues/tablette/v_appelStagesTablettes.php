<div id="contenu">
    <form name="frmSelectStage" method="POST"
          action="index.php?choixTraitement=tablette&action=appelStages">
        <fieldset>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Stage Actuel</h4>

                            <select id="stage" name="stage" data-live-search="true"
                                    class="multiselect-dropdown form-control<?= isset($leStage) ? ' no-open' : '' ?>">
                                <option disabled="disabled" selected="selected">Choisir</option>
                                <?php foreach ($lesStages as $unStage) { ?>
                                    <option <?= isset($leStage) ? ($leStage['ID_STAGE'] === $unStage['ID_STAGE'] ? ' selected' : '') : '' ?>
                                            value="<?= $unStage['ID_STAGE'] ?>" name="unEleve">
                                        <?= $unStage['NOM_STAGE'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

    <?php if (isset($leStage)): ?>
        <form name="frmConsultFrais" method="POST"
              action="index.php?choixTraitement=tablette&action=ValidAppelStages">
            <fieldset>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h4 class="card-title">Nom et prénom</h4>

                                <input type="hidden" name="stage" value="<?= $leStage['ID_STAGE'] ?>">
                                <select id="student" name="inscription" class="multiselect-dropdown form-control"
                                        data-live-search="true">
                                    <option disabled="disabled" selected="selected">Choisir</option>
                                    <?php foreach ($lesInscrits as $unEleve) {
                                        if (!in_array($unEleve['ID_INSCRIPTIONS'], $eleves, true)) { ?>
                                            <option value="<?= $unEleve['ID_INSCRIPTIONS'] ?>" name="inscription">
                                                <?= $unEleve['NOM_ELEVE_STAGE'] ?> <?= $unEleve['PRENOM_ELEVE_STAGE'] ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>

                                <input value="Faire l'appel" type="submit" class="mt-3 btn btn-lg btn-success w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    <?php endif; ?>
</div>

<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>

<!-- custome.js -->
<script type="text/javascript" src="./vues/tablette/tablette.js"></script>
<script type="text/javascript" src="./vues/tablette/selectAutoOpen.js"></script>

<script>
    $(document).ready(() => {
        const stage = $('#stage');
        stage.on('change', function () {
            this.form.submit();
        });
    });
</script>
