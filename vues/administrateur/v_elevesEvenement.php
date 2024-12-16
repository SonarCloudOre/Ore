<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Liste des élèves ayant participé à un évènement
            </div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown" style="text-align:center;">
                <div class="row">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <button type="button" class="btn btn-primary" value="" onClick="imprimer2('sectionAimprimer2');">
                        <i class="fa fa-print"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=eleveevenement">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-6 card">
                <div class="card-body">
                    <div class="form-group">
                        <h4 class="card-title">évènements</h4>
                        <label for="nom">Nom</label>
                        <select name="evenement" class="form-control" style="width:300px">
                            <?php
                            foreach ($lesEvenements as $unEvenement) {
                                echo '<option value="' . $unEvenement['NUMÉROEVENEMENT'] . '"';
                                if ($evenement == $unEvenement['NUMÉROEVENEMENT']) {
                                    echo ' selected="selected"';
                                }
                                echo '>' . $unEvenement['EVENEMENT'] . '</option>';
                            }
                            ?>
                        </select><br>
                        <input value="Valider" class="btn btn-success" type="submit">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php
if ($evenement != '') {
    ?>

    <hr/>

    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Liste des élèves ayant participés à l'évèvenemt
                        : <?php foreach ($lesEvenements as $unEvenement) {
                            if ($evenement == $unEvenement['NUMÉROEVENEMENT']) {
                                echo $unEvenement['EVENEMENT'];
                            }
                        }
                        ?></h4>

                    <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;

                        foreach ($elevesEvenement as $unEvenement) {

                            $i++;

                            echo '<tr>
              <td>' . $unEvenement['NOM'] . '</td>
              <td>' . $unEvenement['PRENOM'] . '</td>
              </tr>';


                        }
                        echo '
            <tfoot>
            <tr>
            <th colspan="6"><i>' . $i . ' inscrits </i></th>
            </tr>
            </tfoot>
            ';

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<?php } ?>
