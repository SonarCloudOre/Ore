<script src="./js/parametre.js"></script>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Ajout d'un paramètre
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


<form name="frmConsultFrais" method="POST"
      action="index.php?choixTraitement=administrateur&action=ValidationAjoutParametre">

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Ajout d'un paramètre</h4>

                    <div class="form-group">
                        <label for="nom">Nom </label>
                        <textarea name="nom" class="form-control"></textarea><br>


                        <label for="niveau">Niveau ( seulement si établissement )</label>
                        <select name="niveau" class="form-control">
                            <option value="NULL" name="niveau"></option>
                            <option value="Collège" name="niveau">Collège</option>
                            <option value="Lycée" name="niveau">Lycée</option>
                            <option value="Autre" name="niveau">Autre</option>
                        </select><br>

                        
                        <label for="type">Type</label>
                        <select id="typeUpdate" name="type" class="form-control">
                            <?php
                            foreach ($type as $valeur) {
                                echo '<option value="' . $valeur['ID'] . '" name="type">' . $valeur['NOM'] . '</option>';
                            }
                            ?>
                        </select><br>

                        <label for="valeurLabel">Valeur:</label>
                        <div id="valueInstructions">
                            <ul>
                                <li><code>[DATE_DEBUT]/[DATE_FIN]</code>: Affichera la date du début ou la date de fin du stage</li>
                                <li><code>[DESCRIPTION]</code>: Affichera la description du stage</li>
                                <li><code>[LIEN]</code>: Affichera le lien d'inscription au stage</li>
                            </ul> 
                        </div>
                        <textarea name="valeur" id="valeur" class="form-control"></textarea><br>
                        
                        <p><input id="submitUpdate" value="Soumettre" type="submit" class="btn btn-success"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
