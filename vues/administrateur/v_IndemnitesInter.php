<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Fiches indemnités
                    <div class="page-title-subheading">Intervenants</div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <div class="row">
                        <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                            <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <form method="POST"
              action="index.php?choixTraitement=administrateur&action=PrepareIndemn&mois=<?= $mois ?>&annee=<?= $annee ?>">
            <div class="row">
                <div class="col-md-8">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <fieldset>
                                <h4 class="card-title">Intervenants</h4>
                                <table style="width: 100%;" id="example"
                                       class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align:right">Sélectionner</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Nombre d'heures</th>
                                        <th>Prélèvement</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($Intervenants as $uneLigne) {
                                        $nbHeures = $pdo->getNbHeuresIntervenant($uneLigne['ID_INTERVENANT'], $mois, $annee);
                                        if ($uneLigne['STATUT'] == 'Salarié') { ?>
                                            <tr>
                                                <td style="text-align: right">
                                                    <?php if ($nbHeures[0] > 0) { ?>
                                                        <input id="<?= $uneLigne['ID_INTERVENANT'] ?>" name="selectionner[]" value="<?= $uneLigne['ID_INTERVENANT'] ?>" type="checkbox" checked>
                                                    <?php } else { ?>
                                                        <input id="<?= $uneLigne['ID_INTERVENANT'] ?>" name="selectionner[]" value="<?= $uneLigne['ID_INTERVENANT'] ?>" type="checkbox">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <label for="<?= $uneLigne['ID_INTERVENANT'] ?>"><?= $uneLigne['NOM'] ?></label>
                                                </td>
                                                <td>
                                                    <label for="<?= $uneLigne['ID_INTERVENANT'] ?>"><?= $uneLigne['PRENOM'] ?></label>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="heure<?= $uneLigne['ID_INTERVENANT'] ?>" value="<?= $nbHeures[0] ?>" step="1" style="width: 100px">
                                                </td>
                                                <td>
                                                    <input type="checkbox" data-ore-prelevement="#p_<?= $uneLigne['ID_INTERVENANT'] ?>">
                                                    <input type="number" class="form-control d-none" name="pre<?= $uneLigne['ID_INTERVENANT'] ?>" id="p_<?= $uneLigne['ID_INTERVENANT'] ?>" placeholder="###.##" step="0.01" style="width: 100px">
                                                </td>
                                            </tr>
                                        <?php }
                                    } ?>
                                    </tbody>
                                </table>
                                <br>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <label for="dateReglement">Date de versement</label><br>
                            <input type="date" value="<?= date('Y-m-d') ?>" name="dateReglement"
                                   class="form-control"><br>

                            <label for="tarif">Tarif de l'heure (en €)</label><br>
                            <input type="number" value="<?= $tarifHeure ?>" name="tarif" class="form-control"><br>

                            <label for="reglement">Type de règlement</label><br>
                            <input type="text" value="Virement" name="reglement" class="form-control"><br>
                            <br>
                            <br>
                            <input type="submit" value="Valider" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(() => {
        $.fn.replaceClass = function (oldClass, newClass) {
            this.removeClass(oldClass);
            this.addClass(newClass);
        }

        $('[data-ore-prelevement]').each((i, _element) => {
            const element = $(_element);
            const target = $(element.attr('data-ore-prelevement'));
            element.click(
                () => element.is(':checked')
                    ? target.removeClass('d-none').addClass('d-inline-block')
                    : target.removeClass('d-inline-block').addClass('d-none')
            );
        });
    });
</script>
