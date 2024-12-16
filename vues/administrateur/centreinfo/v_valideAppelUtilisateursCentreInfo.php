<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Présences des utilisateurs
                    <div class="page-title-subheading">
                        Présence des utilisateurs le <?= date('d/m/Y', strtotime($dateCircuit)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=LesPresencesCentreInfo">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Présences des utilisateurs</h4>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="plusieursJoursMois">
                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="jourSemaine">Tous les...</label><br>
                                                <select name="jourSemaine" id="jourSemaine" class="form-control">
                                                    <option value="1">Lundi</option>
                                                    <option value="2">Mardi</option>
                                                    <option value="3">Mercredi</option>
                                                    <option value="4">Jeudi</option>
                                                    <option value="5">Vendredi</option>
                                                    <option value="6">Samedi</option>
                                                    <option value="7">Dimanche</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label for="mois">De...</label><br>
                                                <select name="mois" class="multiselect-dropdown form-control" data-live-search="true">
                                                    <option value="9">Septembre <?= $anneeExtranet ?></option>
                                                    <option value="10">Octobre <?= $anneeExtranet ?></option>
                                                    <option value="11">Novembre <?= $anneeExtranet ?></option>
                                                    <option value="12">Décembre <?= $anneeExtranet ?></option>
                                                    <option value="1">Janvier <?= $anneeExtranet + 1 ?></option>
                                                    <option value="2">Février <?= $anneeExtranet + 1 ?></option>
                                                    <option value="3">Mars <?= $anneeExtranet + 1 ?></option>
                                                    <option value="4">Avril <?= $anneeExtranet + 1 ?></option>
                                                    <option value="5">Mai <?= $anneeExtranet + 1 ?></option>
                                                    <option value="6">Juin <?= $anneeExtranet + 1 ?></option>
                                                    <option value="7">Juillet <?= $anneeExtranet + 1 ?></option>
                                                    <option value="8">Août <?= $anneeExtranet + 1 ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </label><br>
                                </div>
                            </div>
                            <input name="Soumettre" value="Soumettre" type="submit" class="form-control btn btn-success mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php if (isset($presencesHtml)) { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <?= $presencesHtml ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else {
        echo "Aucune donnée à afficher.";
    } ?>
</div>
