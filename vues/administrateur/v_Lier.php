<div id="contenu">
    <h2>Lier</h2>
    <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
          action="index.php?choixTraitement=administrateur&action=lierEleve">
        <br><label for="lieu">Eleve</label><br>

        <?php
        foreach ($lesElevesDesStages as $unEleve) {
            echo '<label for="eleve_' . $unEleve['ID_ELEVE_STAGE'] . '"><input type="checkbox" value="' . $unEleve['ID_ELEVE_STAGE'] . '" name="eleves[]" id="eleve_' . $unEleve['ID_ELEVE_STAGE'] . '">' . $unEleve['NOM_ELEVE_STAGE'] . ' ' . $unEleve['PRENOM_ELEVE_STAGE'] . '</label><br>';
        }
        ?>
        <br>

        <br><label for="lieu">Stage</label>
        <select name="stage" class="form-control">
            <?php
            foreach ($lesStages as $unStage) {
                echo '<option value="' . $unStage['ID_STAGE'] . '"';
                if ($unStage['ID_STAGE'] == 19) {
                    echo ' selected="selected"';
                }
                echo '>' . $unStage['NOM_STAGE'] . '</option>';
            }
            ?>
        </select><br>
        <input value="Ajouter" type="submit" class="btn btn-success">
    </form>

    </form>
</div>