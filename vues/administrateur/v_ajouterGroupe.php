<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Ajouter un groupe
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

    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=creerGroupe">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">


                        <input type="hidden" name="num" value="<?php echo $num; ?>">
                        <h4 class="card-title">Créer un groupe</h4>

                        <div class="form-row">
                            <div class="col-md-3">
                                <label for="num">Nom : </label>
                                <input type="text" class="form-control" name="nom" value="" autofocus=""
                                       required="required"><br>
                            </div>
                            <div class="col-md-3">
                                <label for="nbmax">Nombre maximum d'élèves : </label>
                                <input type="number" class="form-control" name="nbmax" value="" autofocus=""
                                       required="required"><br>
                            </div>
                            <div class="col-md-1">
                                <label for="salle">Salle : </label>
                                <input type="text" class="form-control" name="salles" value="" autofocus=""
                                       required="required"><br>
                            </div>
                        </div>
                        <br>
                        <input value="Envoyer" type="submit" class="btn btn-success">
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
