<div id="contenu">


    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Recherche fiches indemnités


                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <div class="row">
                        <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                            <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                        </button>
                        <button type="button" class="btn btn-primary" value=""
                                onClick="imprimer2('sectionAimprimer2');">
                            <i class="fa fa-print"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <form name="frmConsultFrais" method="POST"
              action="index.php?choixTraitement=administrateur&action=FichesIndemnites">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Choix de la date</h4>

                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="annee">Année</label><br>
                                    <input type="number" value="<?php echo $anneeEnCours; ?>" name="annee"
                                           class="form-control"><br>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="mois">Mois</label><br>
                                    <select name="mois" class="form-control">
                                        <option value="01">Janvier</option>
                                        <option value="02">Février</option>
                                        <option value="03">Mars</option>
                                        <option value="04">Avril</option>
                                        <option value="05">Mai</option>
                                        <option value="06">Juin</option>
                                        <option value="07">Juillet</option>
                                        <option value="08">Aout</option>
                                        <option value="09">Septembre</option>
                                        <option value="10">Octobre</option>
                                        <option value="11">Novembre</option>
                                        <option value="12">Décembre</option>
                                    </select><br>
                                </div>
                            </div>


                            <input type="submit" class="mt-1 btn btn-primary " name="OK" value="OK">
        </form>
    </div>
</div></div></div>

</div>
</div>
