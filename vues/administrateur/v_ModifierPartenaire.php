<div id="contenu">
    <!-------------------------------------------------------------------- Lieux --------------------------------------------------------------------------------->

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Modifier un partenaire
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
                    <?php
                    foreach ($lesPartenaires

                    as $leLieu) {
                    if ($leLieu['ID_PARTENAIRES'] == $num) {
                    ?>
                    <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
                          action="index.php?choixTraitement=administrateur&action=ModifierPartenaireConfirmation">
                        <div class="form-group">
                            <input type="hidden" name="num" value="<?php echo $leLieu['ID_PARTENAIRES']; ?>">
                            <input type="hidden" name="imageAvant" value="<?php echo $leLieu['IMAGE_PARTENAIRES']; ?>">
                            <h4 class="card-title">Modifier un partenaire</h4>
                            <label for="nom">Nom </label>
                            <input class="form-control" name="nom" value="<?php echo $leLieu['NOM_PARTENAIRES']; ?>"
                                   autofocus=""><br>
                            <label for="image">Image </label><br><br>
                            <img src="images/imagePartenaire/<?php echo $leLieu['IMAGE_PARTENAIRES']; ?>"
                                 style="width:100px"><br>
                            <input type="file" style="width:300px" class="form-control" name="image" value=""><br>

                            <input value="Modifier" type="submit" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php }
    } ?>
</div>
