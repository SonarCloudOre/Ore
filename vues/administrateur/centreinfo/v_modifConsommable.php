<div id="contenu">
    <link rel="stylesheet" type="text/css" href="./styles/css/fablab.css">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Modifier le consommable
                </div>
            </div>
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-body">
            <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=info_modifConsommable&ID=<?=$consommableSelectionner['ID_CONSOMMABLE']?>" enctype="multipart/form-data">
                <div class="form-row col-md">
                    <div class="col-md-11">
                        <h4 class="card-title">Modifier un consommable</h4>
                    </div>
                    <div class="col-md">
                        <i class="metismenu-icon pe-7s-plus"></i>
                    </div>
                </div>

                <div class="col-md mb-3">
                    <label for="Nom" class="required">Nom</label>
                    <input type="text" value="<?=$consommableSelectionner['NOM']?>" class="form-control" name="NOM" id="Nom" placeholder="Nom du consommable" required>
                </div>

                <div class="col-md mb-3">
                    <label for="Description" class="required">Description</label>
                    <textarea class="form-control" name="DESCRIPTION" id="Description" placeholder="Description du consommable" required><?=$consommableSelectionner['DESCRIPTION']?></textarea>
                </div>

                <div class="col-md mb-3">
                    <label for="Prix" class="required">Prix</label>
                    <input type="text" value="<?=$consommableSelectionner['PRIX']?>" class="form-control" name="PRIX" id="Prix" placeholder="Prix du consommable" required>
                </div>

                <div class="col-md mb-3">
                    <label for="Photo" class="required">Photo</label>
                    <input type="file" class="form-control" name="PHOTO" id="Photo" accept="image/png, image/jpeg">
                    <!-- Afficher la photo actuelle -->
                    <img src="./images/consommables/<?=$consommableSelectionner['PHOTO']?>" alt="Photo du consommable" class="img-thumbnail mt-3" style="max-width: 200px;">
                </div>

                <div class="col-md mb-3">
                    <label for="DESACTIVER" class="required">Le consommable est-il actif ?</label>
                    <select class="form-control" name="DESACTIVER" id="DESACTIVER" required>
                        <?php if($consommableSelectionner['DESACTIVER'] == 1) { ?>
                            <option value="0">Oui</option>
                            <option value="1" selected>Non</option>
                        <?php } else { ?>
                            <option value="0" selected>Oui</option>
                            <option value="1">Non</option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="col-md mb-3">
                    <input name="ModifierConsommable" value="Modifier" type="submit" class="form-control btn btn-success mt-3">
                </div>
            </form>
        </div>
    </div>

</div>