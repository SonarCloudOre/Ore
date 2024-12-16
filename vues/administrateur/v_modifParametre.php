<script src="./js/parametre.js"></script>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Modification d'un paramètre
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
      action="index.php?choixTraitement=administrateur&action=ModifParametreValidation">

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Modification d'un paramètre</h4>


                    <div class="form-group">
                        <div class="form-row">

                            <div class="col-md-1">
                                <label for="num">Numéro </label>
                                <input name="num" class="form-control" autofocus="" required=""
                                       value="<?php echo $parametre['ID']; ?>" readonly="readonly"><br>
                            </div>

                            <div class="col-md-3">
                                <label for="nom">Nom </label>
                                <input name="nom" autofocus="" class="form-control"
                                       value="<?php echo $parametre['NOM']; ?>" required=""><br>
                            </div>

                            <div class="col-md-3">
                                <label for="niveau">Niveau ( seulement si établissement )</label>
                                <select name="niveau" class="form-control">
                                    <?php if ($parametre['NIVEAU'] == 'Collège') {
                                        echo ' <option value="NULL" name="niveau"> </option>
      <option value="Collège" selected="selected"name="niveau">Collège</option>
      <option value="Lycée" name="niveau">Lycée</option>
      <option value="Autre" name="niveau">Autre</option>';
                                    }
                                    if ($parametre['NIVEAU'] == 'Lycée') {
                                        echo ' <option value="NULL" name="niveau"> </option>
      <option value="Collège" name="niveau">Collège</option>
      <option value="Lycée" selected="selected" name="niveau">Lycée</option>
      <option value="Autre" name="niveau">Autre</option>';
                                    }

                                    if ($parametre['NIVEAU'] == 'Autre') {
                                        echo ' <option value="NULL" name="niveau"> </option>
      <option value="Collège" name="niveau">Collège</option>
      <option value="Lycée" name="niveau">Lycée</option>
      <option value="Autre" selected="selected" name="niveau">Autre</option>';
                                    }

                                    if ($parametre['NIVEAU'] == NULL) {
                                        echo ' <option value="NULL" selected="selected" name="niveau"> </option>
      <option value="Collège" name="niveau">Collège</option>
      <option value="Lycée" name="niveau">Lycée</option>
      <option value="Autre" name="niveau">Autre</option>';
                                    } ?>

                                </select><br>
                            </div>

                            <div class="col-md-4">
                                <label for="type">Type</label>
                                <select id="typeUpdate" name="type" class="form-control">
                                    <?php
                                    foreach ($type as $valeur) {
                                        if ($parametre['ID_AVOIR'] == $valeur['ID']) {
                                            echo '<option value="' . $valeur['ID'] . '" selected="selected" name="type">' . $valeur['NOM'] . '</option>';
                                        } else {
                                            echo '<option value="' . $valeur['ID'] . '" name="type">' . $valeur['NOM'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select><br>
                            </div>

                            
                            <div>
                                <label for="valeur" id="valeurUpdateLabel">Valeur:</label>
                                <div id="valueInstructions">
                                    <ul>
                                        <li><code>[DATE_DEBUT]/[DATE_FIN]</code>: Affichera la date du début ou la date de fin du stage</li>
                                        <li><code>[DESCRIPTION]</code>: Affichera la description du stage</li>
                                        <li><code>[LIEN]</code>: Affichera le lien d'inscription au stage</li>
                                    </ul> 
                                </div>
                                <textarea type="text" id="valeur" name="valeur" class="form-control" rows="10" cols="60"><?php echo $parametre["VALEUR"]?></textarea><br>
                            </div>
                        </div>


                        <p><input id="submitUpdate" value="Soummettre" class="btn btn-success" type="submit"></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
