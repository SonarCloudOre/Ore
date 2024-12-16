<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Importer un élève dans un stage
                </div>
            </div>

            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>


        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">

                    <h4 class="card-title">Importer un élève dans un stage</h4>
                    <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
                          action="index.php?choixTraitement=administrateur&action=importerEleveStageNouveau">
                        <div class="form-group">
                            <input type="hidden" name="id_stage" value="<?php echo $idStage; ?>">

                            <div class="form-row">
                                <div class="col-md-3">
                                    <label for="nom">Eleve à importer :</label><br>

                                    <SELECT name="id_ancien" class="multiselect-dropdown form-control"
                                            data-live-search="true">
                                        <option disabled="disabled" selected="selected">Choisir</option>
                                        <?php foreach ($lesEleves as $unEleve) {
                                            echo ' <option value="' . $unEleve['ID_ELEVE'] . '"';

                                            // On parcours les inscriptions du stage
                                            foreach ($lesInscriptions as $uneInscription) {
                                                if ($uneInscription['ID_ELEVE_ANCIENNE_TABLE'] == $unEleve['ID_ELEVE']) {
                                                    echo ' disabled="disabled"';
                                                }
                                            }
                                            echo ">" . $unEleve['NOM'] . " " . $unEleve['PRENOM'] . "</option>";
                                        }
                                        ?>
                                    </select><br><br>
                                </div>
                            </div>
                            <p><input value="Importer" type="submit" class="btn btn-success"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript"
        src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="./js/form-components/input-select.js"></script>
