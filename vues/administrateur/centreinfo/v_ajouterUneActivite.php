<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Nouvelle activité


                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <button type="button" class="mr-2 btn btn-primary"
                            onclick="document.location.href='index.php?choixTraitement=administrateur&action=index'">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <h1></h1>


    <form method="POST" enctype="multipart/form-data"
          action="index.php?choixTraitement=administrateur&action=info_ajouterUneActiviteValidation">

        <div class="form-group">

            <br>

            <fieldset>

                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h4 class="">Informations générales</h4>

                                <label for="num">Nom</label>
                                <input class="form-control" name="nom" value=""><br>

                                <label for="num">Année</label>
                                <input class="form-control" type="number" name="annee"
                                       value="<?php echo $anneeEnCours; ?>"><br>
                                <input value="Ajouter" type="submit" class="btn btn-success">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>


        </div>

    </form>

</div>
