<div id="contenu">
    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=administrateur&action=validationEnvoiMailIntervenant">
        <h2>Envoi d'email aux intervenants</h2>

        <h3>Envoi d'email aux intervenants</h3>

        <center>

            <label for="tous">Tous les intervenants ?</label>
            <select name="tous">
                <option value="1" name="tous">Oui</option>
                <option value="0" selected="selected" name="tous">Non</option>
            </select>
            <br/>

        </center>
        <?php
        foreach ($lesIntervenants as $unIntervenant) {
            echo "<input type='checkbox' name='unIntervenant[]'  value ='" . $unIntervenant['EMAIL'] . "'/>" . $unIntervenant['NOM'] . " " . $unIntervenant['PRENOM'] . "<br>";
        }
        ?>


        <center>


            <fieldset>
                <legend>E-mail</legend>


                <label for="sujet">Sujet : </label>
                <input name="sujet" autofocus=""><br>

                <br/>

                <label for="contenu">Contenu du e-mail :<br/>
                </label>
                <textarea name="contenu" class="mceEditor"></textarea>

            </fieldset>
            <INPUT TYPE="submit" VALUE="Valider">
    </form>
    <p>

</div>