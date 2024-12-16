<?php
// Si une inscription a été validée
if (isset($_POST['id_eleve'])) {

    $eleve = $pdo->executerRequete("SELECT * FROM eleves WHERE ID_ELEVE = '" . $_POST['id_eleve'] . "';");

    $id_eleve = $eleve[0];
    $dateBDD = $eleve[4];

    $dateSaisie = $_POST['annee'] . '-' . $_POST['mois'] . '-' . $_POST['jour'];

    // Si l'élève est inconnu

    if ($id_eleve == '') {
        echo '<p style="text-align:center"><img src="http://association-ore.fr/extranet/images/danger.jpg"></p>
		<p style="color:red;font-size:18px;font-weight:bold;">Erreur : ce numéro d\'adhérent est inconnu !<br><ul>
		<li><a href="" style="color:red;font-size:18px;font-weight:bold;text-decoration:underline">Si votre enfant n\'a jamais été inscrit à ORE, cliquez ici pour vous inscrire.</a></li>
		<li><a href="javascript:history.back();" style="color:red;font-size:18px;font-weight:bold;text-decoration:underline">Si vous êtes déjà inscrit à ORE, cliquez ici pour recommencer.</a></li>
		</ul></p>';

        // Eleve connu
    } else {

        // La date de naissance correspond, on inscrit au stage
        if ($dateSaisie == $dateBDD) {

            echo '<p style="text-align:center"><img src="http://association-ore.fr/extranet/images/coche_valid.png"></p>
			<p style="color:green;font-size:18px;font-weight:bold">L\'élève ' . $eleve[2] . ' ' . $eleve[1] . ' a bien été inscrit(e) au stage !<br><br>
			<a href="javascript:history.back();" style="color:red;font-size:18px;font-weight:bold;text-decoration:underline">Cliquez ici pour effectuer une nouvelle inscription</a></p>';

            // La date de naissance ne correspond pas
        } else {
            echo '<p>Erreur : pas la bonne date !<br>
		Date élève : ' . $dateBDD . '<br>
		Daet saisie : ' . $dateSaisie . '</p>';

        }
    }


}
?>


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


    <?php

    if (isset($_GET['id'])) {

    $evenement = $pdo->executerRequete("SELECT * FROM evenements WHERE NUMÉROEVENEMENT = '" . $_GET['id'] . "';");

    ?>
    <h2 style="width:1000px">Inscription à : <?php echo $evenement[1]; ?></h2>
    <?php

    if ($evenement[6] == '0') {

    ?>

    <div class="form-group">


        <p><?php echo $evenement[7]; ?>
        </p>


        <hr>

        <fieldset>

            <legend>Connexion</legend>

            <label for="deja_inscrit">Êtes-vous déjà inscrit à l'association ORE ?</label><br>
            <button onclick="deja_inscrit()" class="btn btn-success" style="padding:15px;margin:15px">Oui</button>
            <button onclick="pas_inscrit()" class="btn btn-danger" style="padding:15px;margin:15px">Non</button>

        </fieldset>

        <!-- Eleve déjà inscrit à ORE -->
        <div id="deja_inscrit" style="display:none">

            <fieldset>

                <legend>Inscription au stage</legend>

                <form name="frmStage" method="POST" action="index.php?choixTraitement=parent&action=InscriptionStage">

                    <label for="id_eleve">Numéro personnel de l'enfant :</label>
                    <input type="text" name="id_eleve" value="" class="form-control" size="5"><br>

                    <label for="date_naissance">Date de naissance de l'enfant :</label><br>
                    <select name="jour">
                        <?php
                        $min = 1;
                        $max = 31;
                        for ($i = $min; $i <= $max; $i++) {
                            // Ajout des 0
                            if (strlen($i) == 1) {
                                $numero = '0';
                            } else {
                                $numero = '';
                            }

                            echo '<option value="' . $numero . $i . '">' . $numero . $i . '</option>';
                        }
                        ?>
                    </select> / <select name="mois">
                        <?php
                        $min = 1;
                        $max = 12;
                        $mois = array('', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
                        for ($i = $min; $i <= $max; $i++) {

                            // Ajout des 0
                            if (strlen($i) == 1) {
                                $numero = '0';
                            } else {
                                $numero = '';
                            }

                            echo '<option value="' . $numero . $i . '">' . $mois[$i] . '</option>';
                        }
                        ?>
                    </select> / <select name="annee">
                        <?php
                        $min = 1980;
                        $max = 2017;
                        for ($i = $min; $i <= $max; $i++) {
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select><br><br><br><br>

                    <p><input value="Soummettre" type="submit" class="btn btn-success"></p>

                </form>

            </fieldset>
        </div>

        <div id="pas_inscrit" style="display:none">

            <fieldset>

                <legend>Nouvelle inscription</legend>

                <form name="frmStage" method="POST"
                      action="index.php?choixTraitement=intervenant&action=InscriptionStage">

                    <label for="nom">Nom </label>
                    <input class="form-control" name="nom" placeholder="Votre nom" value="" autofocus=""><br>

                    <label for="prenom">Prénom </label>
                    <input class="form-control" name="prenom" placeholder="Votre prénom" value="" autofocus=""><br>

                    <label for="sexe">Sexe</label>
                    <select name="sexe" class="form-control">
                        <option value="F" selected="selected" name="sexe">Femme</option>
                        <option value="H" name="sexe">Homme</option>
                    </select>

                    <label for="date_naissance">Date de naissance </label>
                    <input class="form-control" name="date_naissance" value="" autofocus=""><br>

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
                    <input class="form-control" name="email_parent" placeholder="xxxx@xxxxx.xx" value=""
                           type="email"><br>

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

            </fieldset>

        </div>


    </div>

</div>

<?php
} else {

    echo '<p>Ce stage est terminé.</p>';

}
} else {

    ?>
    <P></p>

    <?php

}
?>

<p>Pour toute information, contactez l'association par mail à <a href="mailto:association.ore@gmail.com">association.ore@gmail.com</a>
    ou au <a href="phone:0380482396">03 80 48 23 96</a></p>
</div>
