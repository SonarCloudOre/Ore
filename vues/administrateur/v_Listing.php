<div id="contenu">
    <h2>Listing</h2>

    <ul class="nav nav-tabs" id="onglets" role="tablist">
        <li role="presentation" class="active"><a href="#payes" aria-controls="home" role="tab" data-toggle="tab"><span
                    class=""></span> Payés/Impayés</a></li>
        <li role="presentation"><a href="#evenements" aria-controls="home" role="tab" data-toggle="tab"><span
                    class=""></span> Evènements</a></li>
        <li role="presentation"><a href="#trombi" aria-controls="home" role="tab" data-toggle="tab"><span
                    class=""></span> Trombinoscope</a></li>
        <li role="presentation"><a href="#appels" aria-controls="home" role="tab" data-toggle="tab"><span
                    class=""></span> Appels</a></li>
        <li role="presentation"><a href="#presences" aria-controls="home" role="tab" data-toggle="tab"><span
                    class=""></span> Présences</a></li>
        <li role="presentation"><a href="#eleves" aria-controls="home" role="tab" data-toggle="tab"><span
                    class=""></span> Les élèves</a></li>
        <li role="presentation"><a href="#intervenants" aria-controls="home" role="tab" data-toggle="tab"><span
                    class=""></span> Les intervenants</a></li>
        <li role="presentation"><a href="#stats" aria-controls="home" role="tab" data-toggle="tab"><span
                    class=""></span> Statistiques</a></li>

    </ul>

    <script type="text/javascript">
        $('#onglets a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    </script>


    <div class="tab-content">


        <div role="tabpanel" class="tab-pane active" id="payes">
            <center>
                <form name="frmConsultFrais" method="POST"
                      action="index.php?choixTraitement=administrateur&action=ImpayesPayesPDF">
                    <h4> Les Payés/Impayés d'un réglement spécifique :</h4><br/>

                    <label for='Les Impayés'><input id='Les Impayés' name='valeur' value='0'
                                                    type='radio'>Impayés</label>
                    <label for='Les Payés'><input id='Les Payés' name='valeur' value='1' type='radio'>Payés</label>

                    <br><br>
                    <label for="reglement">Réglements</label>
                    <select name="reglement" style="width:200px;">

                        <?php
                        foreach ($lesAnneesScolaires as $value) {
                            $annee = "Soutien scolaire " . $value['ANNEE'] . '-' . ($value['ANNEE'] + 1);
                            echo '<option value="' . $annee . '" >' . $annee . '</option>';
                        }
                        ?>
                    </select> <br> <br>

                    <legend>En fonction d'un évènement ?</legend>

                    <label for='Oui'><input id='Oui' name='evenementON' value='1' type='radio'> Oui</label><br>
                    <label for='Non'><input id='Non' name='evenementON' value='0' type='radio'> Non</label>


                    <br><br>

                    <label for="evenements">Evènements</label>
                    <select name="evenements" style="width:200px;">

                        <?php foreach ($lesEvenements as $uneLigne) {
                            echo '<option  value="' . $uneLigne['NUMÉROEVENEMENT'] . '">' . $uneLigne['EVENEMENT'] . '</option>';
                        }
                        ?>
                    </select>
                    <br><br>

                    <p><input value="Soummettre" type="submit"></p>
                    <br>

                </form>
            </center>

        </div>


        <div role="tabpanel" class="tab-pane" id="evenements">

            <center>
                <form name="frmConsultFrais" method="POST"
                      action="index.php?choixTraitement=administrateur&action=evenementsPDF">
                    <legend>Sous quel format ?</legend>

                    <label for='Oui'><input id='Oui' name='valeur' value='1' type='radio'> PDF</label><br>
                    <label for='Non'><input id='Non' name='valeur' value='0' type='radio'> Excel</label>

                    <h4> Les Evènements disponibles :</h4><br/>

                    <label for="evenements">Evènements</label>
                    <select name="evenements" style="width:200px;">

                        <?php foreach ($lesEvenements as $uneLigne) {
                            echo '<option  value="' . $uneLigne['NUMÉROEVENEMENT'] . '">' . $uneLigne['EVENEMENT'] . '</option>';
                        }
                        ?>
                    </select> <br>
                    <p><input value="Soummettre" type="submit"></p>
                    <br>
                </form>
            </center>
        </div>

        <div role="tabpanel" class="tab-pane" id="trombi">
            <center>
                <form name="frmConsultFrais" method="POST"
                      action="index.php?choixTraitement=administrateur&action=TrombinoscopePDF">
                    <h4>Trombinoscope - Les Classes disponibles :</h4><br/>
                    <label for="classe">Classe</label>
                    <select name="classe" style="width:200px;">

                        <?php foreach ($lesClasses as $uneLigne) {
                            echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
                        }
                        ?>
                    </select> <br>
                    <p><input value="Soummettre" type="submit"></p>
                    <br>
                </form>
            </center>
        </div>

        <div role="tabpanel" class="tab-pane" id="appels">
            <center>
                <form name="frmConsultFrais" method="POST"
                      action="index.php?choixTraitement=administrateur&action=AppelsPDF">
                    <h4> Les Classes disponibles :</h4><br/>
                    <label for="classe">Classe</label>
                    <select name="classe" style="width:200px;">

                        <?php foreach ($lesClasses as $uneLigne) {
                            echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <p><input value="Soummettre" type="submit"></p>
                    <br>
                </form>
            </center>
        </div>

        <div role="tabpanel" class="tab-pane" id="presences">

            <center>
                <form name="frmConsultFrais" method="POST"
                      action="index.php?choixTraitement=administrateur&action=LesPresencesAUneDate">
                    <h4> Merci de marquer la date :</h4><br/>

                    <?php
                    $dateCircuit = date('d-m-Y', strtotime('+0 day'));
                    ?>

                    <label for="laDate">Date de l'appel </label>
                    <input name="laDate" required="" value="<?php echo $dateCircuit; ?>"><br>


                    <br>
                    <p><input value="Soummettre" type="submit"></p>

                </form>
            </center>
        </div>

        <div role="tabpanel" class="tab-pane" id="eleves">

            <center>
                <form name="frmConsultFrais" method="POST"
                      action="index.php?choixTraitement=administrateur&action=ElevesCSV">
                    <h4> Exporter la liste de tous les élèves sur excel :</h4><br/>

                    <br>
                    <p><input value="Exporter Format Excel" type="submit"></p>

                </form>
            </center>
        </div>

        <div role="tabpanel" class="tab-pane" id="intervenants">

            <center>
                <form name="frmConsultFrais" method="POST"
                      action="index.php?choixTraitement=administrateur&action=IntervenantCSV">
                    <h4> Exporter la liste de tous les intervenants sur excel :</h4><br/>

                    <br>
                    <p><input value="Exporter Format Excel" type="submit"></p>

                </form>
            </center>
        </div>


    </div>


    <script type="text/javascript">
        //<!--
        Affiche(Onglet_afficher);
        //-->
    </script>
    <p>

</div>