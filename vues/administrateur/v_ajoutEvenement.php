<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Ajout évenement
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


    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=administrateur&action=AjoutEvenementValidation">


        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Ajout d'un évenement</h4>

                        <label for="nom">Nom </label>
                        <input class="form-control" name="nom" autofocus="" required=""><br>

                        <label for="cout">Cout par participant </label>
                        <input class="form-control" name="cout" autofocus="" required=""><br>

                        <label for="nb">Nombre de participants </label>
                        <input class="form-control" name="nb" autofocus="" required=""><br>

                        <label for="dateDebut">Date Début </label>
                        <input class="form-control" name="dateDebut" placeholder="XX-XX-XXXX" autofocus=""
                               required=""><br>

                        <label for="dateFin">Date Fin </label>
                        <input class="form-control" name="dateFin" placeholder="XX-XX-XXXX" autofocus=""
                               required=""><br>

                        <label for="dateFin">Description </label>
                        <textarea class="form-control" name="description" autofocus="" required=""></textarea><br>


                        <p><input class="btn btn-primary" value="Soummettre" type="submit"></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
