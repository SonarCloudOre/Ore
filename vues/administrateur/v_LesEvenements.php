<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Les évenements
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


    <center>

        <form name="frmConsultFrais" method="POST"
              action="index.php?choixTraitement=administrateur&action=evenementsPDF">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Ajout d'un évenement</h4>
                            <legend>Sous quel format ?</legend>

                            <label for='Oui'><input id='Oui' name='valeur' value='1' type='radio'> PDF</label><br>
                            <label for='Non'><input id='Non' name='valeur' value='0' type='radio'> Excel</label>

                            <h4> Les Evènements disponibles :</h4><br/>

                            <label for="evenements">Evènements</label>
                            <select class="form-control" name="evenements" style="width:200px;">

                                <?php foreach ($lesEvenements as $uneLigne) {
                                    echo '<option  value="' . $uneLigne['NUMÉROEVENEMENT'] . '">' . $uneLigne['EVENEMENT'] . '</option>';
                                }
                                ?>
                            </select> <br>
                            <p><input class="btn btn-primary" value="Soummettre" type="submit"></p>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </center>
</div>
