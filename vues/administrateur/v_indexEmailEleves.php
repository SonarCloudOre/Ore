<div id="contenu">
    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=administrateur&action=validationEnvoiMailEleves">
        <h2>Envoi d'email aux élèves</h2>

        <h3>Envoi d'email aux élèves</h3>

        <center>
            <label for="tous">Tous les élèves ?</label>
            <select name="tous">
                <option value="1" name="tous">Oui</option>
                <option value="0" selected="selected" name="tous">Par niveau</option>
            </select>
            <br/>

            <label for="option">Email ?</label>
            <select name="option">
                <option value="1" name="option">Parents</option>
                <option value="0" name="option">Elèves</option>
                <option value="2" selected="selected" name="option">Les Deux</option>

            </select>
            <br/>

            <label for="niveau">Niveau </label>
            <select name="niveau">
                <option value="1" name="niveau">Collégiens</option>
                <option value="0" name="niveau">Lycéens</option>
            </select>
            <br/>

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