<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Présence des élèves
                    <div class="page-title-subheading">Scanner les QR-Code</div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="<!--mr-2--> btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <!--
                    <a href="index.php?choixTraitement=administrateur&action=imprimerFichePresencesScolaire">
                        <button type="button" class="btn btn-primary" value="">
                            <i class="fa fa-print"></i>
                        </button>
                    </a>
                    -->
                </div>
            </div>
        </div>
    </div>

    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=administrateur&action=ValidAppelElevesCodeBarre">
        <fieldset>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h4 class="card-title">Présence des élèves</h4>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label for="dateAppel">Date de l'appel</label>
                                        <input type="date" class="form-control" name="dateAppel"
                                               value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="moment">Demi Journée</label><br>

                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            <?php $moment = getMomentJournee(); ?>
                                            <?php $active = [' active', ' checked']; ?>
                                            <?php $selected = $moment === 1 ? $active : ['', '']; ?>
                                            <label class="btn btn-outline-secondary<?= $selected[0] ?>">
                                                <input type="radio" name="moment" id="am" autocomplete="off" value="1"<?= $selected[1] ?>>
                                                Matin
                                            </label>
                                            <?php $selected = $moment === 2 ? $active : ['', '']; ?>
                                            <label class="btn btn-outline-secondary<?= $selected[0] ?>">
                                                <input type="radio" name="moment" id="pm" autocomplete="off" value="2"<?= $selected[1] ?>>
                                                Après-Midi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <div class="form-group">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Appel par QR-Code</h4>

                        <div class="form-row">
                            <div class="col-md-6 col-lg-3">
                                <label for="appel">QR-Code des élèves</label><br>
                                <textarea class="form-control" id="appel" name="appel" rows="10" autofocus></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 col-lg-3">
                                <input value="Faire l'appel" class="form-control btn btn-success mt-3" type="submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
