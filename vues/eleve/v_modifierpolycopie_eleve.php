<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Modifier une polycopie</h5>
                <form class=""
                      action="index.php?choixTraitement=eleve&action=modifierPocycopie&id=<?php echo $unePolycopie[0]['id']; ?>"
                      method="post" enctype="multipart/form-data">
                    <div class="">
                        <label for="Nom">Nom :</label>
                        <input class="form-control" type="text" name="Nom"
                               value="<?php echo $unePolycopie[0]["nom"]; ?>" style="max-width:200px;">
                        <label for="Commentaires">Commentaires :</label>
                        <input class="form-control" type="text" name="Commentaires"
                               value="<?php echo $unePolycopie[0]["Commentaires"]; ?>" style="max-width:200px;">
                        <label for="Fichier">Fichier:</label>
                        <i style="color:red;"><?php echo $unePolycopie[0]["urlfichier"]; ?></i>
                        <input class="form-control" type="file" name="Fichier" accept=".pdf" style="max-width:200px;">
                        <label for="Corrige">Corrigé:</label>
                        <i style="color:red;"><?php echo $unePolycopie[0]["urlcorrige"]; ?></i>
                        <input class="form-control" type="file" name="Corrige" accept=".pdf" style="max-width:200px;">
                        <label for="Date">Date de mise en ligne :</label>
                        <input class="form-control" type="date" name="Date"
                               value="<?php echo $unePolycopie[0]["dateMiseEnLigne"]; ?>" readonly
                               style="max-width:200px;">
                        <label for="Classe">Classe :</label>
                        <select class="form-control" name="Classe" style="max-width:200px;">
                            <?php foreach ($lesClasses as $uneClasse) {
                                if ($unePolycopie[0]["Classe"] == $uneClasse["NOM"]) {
                                    echo '<option value="' . $uneClasse["NOM"] . '" ' . $selectionner . '>' . $uneClasse["NOM"] . '</option>';

                                } else {
                                    echo '<option value="' . $uneClasse["NOM"] . '">' . $uneClasse["NOM"] . '</option>';
                                }
                            } ?>
                        </select>
                        <label for="Photo">Photo :</label>
                        <i style="color:red;"><?php echo $unePolycopie[0]["urlphoto"]; ?></i>
                        <input class="form-control" type="file" name="Photo" style="max-width:200px;">
                        <label for="Type">Type :</label>
                        <select class="form-control" name="Type" style="max-width:200px;">
                            <?php foreach ($lesTypes as $unType) {
                                if ($unePolycopie[0]["Type"] == $unType["Type"]) {
                                    echo '<option value="' . $unType["Type"] . '" ' . $selectionner . '>' . $unType["Type"] . '</option>';

                                } else {
                                    echo '<option value="' . $unType["Type"] . '">' . $unType["Type"] . '</option>';
                                }
                            } ?>
                        </select>
                        <label for="Categorie">Catégorie :</label>
                        <select class="form-control" name="Categorie" style="max-width:200px;">
                            <?php foreach ($lesCategoriesDocs as $uneCategorie) {
                                if ($unePolycopie[0]["ID_CATEGDOC"] == $uneCategorie["id"]) {
                                    echo '<option value="' . $uneCategorie["id"] . '" ' . $selectionner . '>' . $uneCategorie["Matieres"] . '</option>';

                                } else {
                                    echo '<option value="' . $uneCategorie["id"] . '">' . $uneCategorie["Matieres"] . '</option>';
                                }
                            } ?>
                        </select>
                        <?php if ((isset($numIntervenant)) && $admin >= 1) { ?>


                            <label for="Valide">Document validé ?</label><br>
                            <div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php
                                if ($unePolycopie[0]["valide"] == "1") {
                                    echo '<label class="btn btn-warning">
              <input type="radio" value="1" name="Valide" checked autocomplete="off">
              Oui
              </label>
              <label class="btn btn-warning">
              <input type="radio" value="0" name="Valide" autocomplete="off">
              Non
              </label>';
                                } else {
                                    echo '<label class="btn btn-warning">
              <input type="radio" value="1" name="Valide" autocomplete="off">
              Oui
              </label>
              <label for="CAF" class="btn btn-warning">
              <input type="radio" value="0" name="Valide" checked autocomplete="off">
              Non
              </label>';
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <br/><br/>
                        <button type="submit" name="modifier" class="mt-1 btn btn-primary ">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
