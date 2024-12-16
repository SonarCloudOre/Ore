<div id="contenu">
    <link rel="stylesheet" type="text/css" href="./styles/css/fablab.css">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Modifier l'activité
                </div>
            </div>
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-body">
            <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=info_modifActivite&ID=<?=$activiteSelectionner['ID_ACTIVITE']?>" enctype="multipart/form-data">
                <div class="form-row col-md">
                    <div class="col-md-11">
                        <h4 class="card-title">Modifier une activité</h4>
                    </div>
                    <div class="col-md">
                        <i class="metismenu-icon pe-7s-plus"></i>
                    </div>
                </div>

                <div class="col-md mb-3">
                    <label for="Nom" class="required">Nom</label>
                    <input type="text" value="<?=$activiteSelectionner['NOM']?>" class="form-control" name="NOM" id="Nom" placeholder="Nom de l'activité" required>
                </div>

                <div class="col-md mb-3">
                    <label for="Description" class="required">Description</label>
                    <textarea class="form-control" name="DESCRIPTION" id="Description" placeholder="Description de l'activité" required><?=$activiteSelectionner['DESCRIPTION']?></textarea>
                </div>

                <div class="col-md mb-3">
                    <label for="Prix" class="required">Prix</label>
                    <input type="text" value="<?=$activiteSelectionner['PRIX']?>" class="form-control" name="PRIX" id="Prix" placeholder="Prix de l'activité" required>
                </div>

                <div class="col-md mb-3">
                    <label for="Photo" class="required">Photo</label>
                    <input type="file" class="form-control" name="PHOTO" id="Photo" accept="image/png, image/jpeg">
                    <!-- Afficher la photo actuelle -->
                    <img src="./images/activites/<?=$activiteSelectionner['PHOTO']?>" alt="Photo de l'activité" class="img-thumbnail mt-3" style="max-width: 200px;">
                </div>

                <div class="col-md mb-3">
                    <label for="ADHERENT" class="required">L'utilisateur doit-il être adhérent ?</label>
                    <select class="form-control" name="ADHERENT" id="ADHERENT" required>
                        <?php if($activiteSelectionner['ADHERENT'] == 1) { ?>
                            <option value="1" selected>Oui</option>
                            <option value="0">Non</option>
                        <?php } else { ?>
                            <option value="1">Oui</option>
                            <option value="0" selected>Non</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md mb-3">
                    <label for="DESACTIVER" class="required">L'activité est-elle active ?</label>
                    <select class="form-control" name="DESACTIVER" id="DESACTIVER" required>
                        <?php if($activiteSelectionner['DESACTIVER'] == 1) { ?>
                            <option value="0">Oui</option>
                            <option value="1" selected>Non</option>
                        <?php } else { ?>
                            <option value="0" selected>Oui</option>
                            <option value="1">Non</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md mb-3">
                    <input name="ModifierActivite" value="Modifier" type="submit" class="form-control btn btn-success mt-3">
                </div>
            </form>
        </div>
    </div>

</div>