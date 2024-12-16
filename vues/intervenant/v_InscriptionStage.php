<script type="text/javascript">
    function deja_inscrit() {
        document.getElementById('deja_inscrit').style.display = 'block';
        document.getElementById('pas_inscrit').style.display = 'none';
    }

    function pas_inscrit() {
        document.getElementById('pas_inscrit').style.display = 'block';
        document.getElementById('deja_inscrit').style.display = 'none';
    }
</script>

<div id="contenu">

    <h2>Inscription</h2>

    <h3>Coordonnées</h3>

    <label for="deja_inscrit">Êtes-vous déjà inscrit à l'association ORE ?</label>
    <input class="form-control" type="radio" name="deja_inscrit" value="1" onclick="deja_inscrit()"> Oui<br>
    <input class="form-control" type="radio" name="deja_inscrit" value="0" onclick="pas_inscrit()"> Non<br>

    <!-- Eleve déjà inscrit à ORE -->
    <div id="deja_inscrit" style="display:none">

        <form name="frmStage" method="POST" action="index.php?choixTraitement=intervenant&action=InscriptionStage">

            <label for="id_eleve">Numéro personnel de l'enfant :</label>
            <input type="text" name="id_eleve" value="" class="form-control"><br>

            <label for="date_naissance">Date de naissance de l'enfant :</label>
            <input type="text" name="date_naissance" value="" class="form-control"><br>

            <p><input value="Soummettre" type="submit" class="btn btn-success"></p>

        </form>
    </div>

    <div id="pas_inscrit" style="display:none">

        <form name="frmStage" method="POST" action="index.php?choixTraitement=intervenant&action=InscriptionStage">

            <label for="nom">Nom </label>
            <input class="form-control" name="nom" placeholder="Votre nom" value="'.$eleveSelectionner['NOM'].'"
                   autofocus=""><br>

            <label for="prenom">Prénom </label>
            <input class="form-control" name="prenom" placeholder="Votre prénom"
                   value="'.$eleveSelectionner['PRENOM'].'" autofocus=""><br>

            <label for="sexe">Sexe</label>
            <select name="sexe" class="form-control">
                <option value="F" selected="selected" name="sexe">Femme</option>
                <option value="H" name="sexe">Homme</option>
            </select>

            <label for="date_naissance">Date de naissance </label>
            <input class="form-control" name="date_naissance" value="'.$dateFrancais.'" autofocus=""><br>

            <label for="tel_enfant">Téléphone de l'enfant</label>
            <input class="form-control" name="tel_enfant" value="" autofocus=""> <br>

            <label for="email_enfant">Email de l'enfant</label>
            <input class="form-control" name="email_enfant" placeholder="xxxx@xxxxx.xx" type="email">

            <label for="responsable_legal">Nom et Prénom du Responsable légal </label>
            <input class="form-control" name="responsable_legal" autofocus="" value=""><br>

            <label for="tel_parent">Téléphone des parents</label>
            <input class="form-control" name="tel_parent" autofocus="" value=""><br>

            <label for="profession_pere">Profession du Père</label>
            <input class="form-control" name="profession_pere" autofocus="" value=""><br>

            <label for="profession_mere">Profession de la mère</label>
            <input class="form-control" name="profession_mere" autofocus="" value=""><br>

            <label for="adresse">Adresse</label>
            <input class="form-control" name="adresse" autofocus="" value=""><br>

            <label for="cp">Code Postal</label>
            <input class="form-control" name="cp" autofocus="" value=""><br>

            <label for="ville">Ville</label>
            <input class="form-control" name="ville" autofocus="" value=""><br>

            <label for="email_parent">Email des parents</label>
            <input class="form-control" name="email_parent" placeholder="xxxx@xxxxx.xx" value="" type="email"><br>

            <label for="prevenir_parent">Voulez vous êtes prévenu en cas d'absence de votre enfant ?</label>
            <select class="form-control" name="prevenir_parent">
                <option value="1" selected="selected" name="prevenir_parent">Oui</option>
                <option value="0" name="prevenir_parent">Non</option>
            </select>


            <label for="commentaires">Commentaires : <br/>
            </label>
            <textarea class="form-control" name="commentaires"></textarea><br>

            <label for="contactParents">Contact avec les parents : <br/>
            </label>
            <textarea class="form-control" name="contactParents"></textarea> <br>

        </form>

    </div>

    <p><input value="Soummettre" type="submit" class="btn btn-success"></p>


</div>


<!--<label for="cout">Cout par participant </label>
<input name="cout" autofocus="" required=""><br>

<label for="nb">Nombre de participants </label>
<input name="nb" autofocus="" required=""><br>

<label for="dateDebut">Date Début </label>
<input name="dateDebut" placeholder="XX-XX-XXXX" autofocus="" required=""><br>

<label for="dateFin">Date Fin </label>
<input name="dateFin"placeholder="XX-XX-XXXX" autofocus="" required=""><br>-->

</div>