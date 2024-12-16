<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Élèves absents
                    <div class="page-title-subheading">Saisissez un nombre ci-dessous</div>
                </div>
            </div>
        </div>
    </div>


    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=ImpayesPayesPDF">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Eleves absents</h4>
                            <label for="nom">Nombre d'absences</label>
                            <input type="number" class="form-control" style="width:100px" name="num" value="5">
                            <br>
                            <input value="Valider" class="btn btn-success" type="submit">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php if (isset($num)) { ?>
        <hr>
        <table class="table">
            <thead>
            <tr>
                <td>N°</td>
                <td>Nom</td>
                <td>Prénom</td>
            </tr>
            </thead>
            <tbody>
            <?php

            ?>
            </tbody>
        </table>

    <?php } ?>
</div>
