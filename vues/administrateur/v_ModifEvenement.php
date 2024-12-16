<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Ajout événement
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
                    <form name="frmConsultFrais" method="POST"
                          action="index.php?choixTraitement=administrateur&action=ModifEvenementValidation">

                        <h4 class="card-title">Ajout d'un évenement</h4>

                        <label for="num">Numéro </label>
                        <input class="form-control" name="num" autofocus="" required=""
                               value="<?php echo $evenement['NUMÉROEVENEMENT']; ?>" readonly="readonly"><br>

                        <label for="nom">Nom </label>
                        <input class="form-control" name="nom" autofocus=""
                               value="<?php echo $evenement['EVENEMENT']; ?>" required=""><br>

                        <label for="cout">Cout par participant </label>
                        <input class="form-control" name="cout" autofocus=""
                               value="<?php echo $evenement['COUTPARENFANT']; ?>" required=""><br>

                        <label for="nb">Nombre de participants </label>
                        <input class="form-control" name="nb" autofocus=""
                               value="<?php echo $evenement['NBPARTICIPANTS']; ?>" required=""><br>

                        <label for="dateDebut">Date Début </label>
                        <input class="form-control" name="dateDebut" autofocus="" value="<?php
                        // extraction des jour, mois, an de la date
                        list($annee, $mois, $jour) = explode('-', $evenement['DATEDEBUT']);
                        $dateFrancaisDebut = $jour . "-" . $mois . "-" . $annee;
                        echo $dateFrancaisDebut; ?>" required=""><br>

                        <label for="dateFin">Date Fin </label>
                        <input class="form-control" name="dateFin" autofocus="" value="<?php
                        // extraction des jour, mois, an de la date
                        list($annee, $mois, $jour) = explode('-', $evenement['DATEFIN']);
                        $dateFrancaisdeFin = $jour . "-" . $mois . "-" . $annee;
                        echo $dateFrancaisdeFin; ?>" required=""><br>

                        <label for="annuler">Annuler ?</label>
                        <select class="form-control" name="annuler">
                            <?php

                            if ($evenement['ANNULER'] == 1) {
                                echo '<option value="1" selected="selected" name="annuler">OUI</option>';
                                echo '<option value="0"  name="annuler">NON</option>';
                            } else {
                                echo '	<option value="1" name="annuler">OUI</option>';
                                echo '<option value="0" selected="selected"  name="annuler">NON</option>';
                            }

                            ?>

                        </select><br>


                        <p><input value="Soummettre" type="submit" class="btn btn-primary"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
