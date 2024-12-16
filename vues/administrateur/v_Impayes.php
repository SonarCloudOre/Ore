<div id="contenu">
    <center>
        <form name="frmConsultFrais" method="POST"
              action="index.php?choixTraitement=administrateur&action=ImpayesPayesPDF">
            <h4> Les Payés/Impayés d'un réglement spécifique :</h4><br/>

            <label for='Les Impayés'><input id='Les Impayés' name='valeur' value='0' type='radio'>Impayés</label>
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