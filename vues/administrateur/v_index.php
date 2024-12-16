<div id="contenu">
    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=intervenant&action=valideModif">
        <h2>Planning Intervenant Très d'Union</h2>

        <h3>Planning de <?php echo $intervenant['NOM'] . " " . $intervenant['PRENOM']; ?></h3>
        <h4>Toute confirmation de votre présence ne peut être annulée, en cas d'empêchement de dernière minute, Merci de
            contacter l'association</h4>
        <label for="date"></label><br/>
        <?php

        $dateAujourdhui = date();
        $tableaudate = array();

        for ($i = 0; $i < 30; $i++) {
            $dateCircuit = date('d-m-Y', strtotime('+' . $i . ' day'));


            // extraction des jour, mois, an de la date
            list($jour, $mois, $annee) = explode('-', $dateCircuit);
            // calcul du timestamp
            $timestamp = mktime(0, 0, 0, $mois, $jour, $annee);
            // affichage du jour de la semaine
            $jour = date("w", $timestamp);


            if ($jour == 3) //si mercredi
            {
                echo " <input name='date[]' type='checkbox' value='" . $dateCircuit . "'  /> Mercredi " . $dateCircuit . "<br>";
            }

            if ($jour == 6) // si samedi
            {
                echo " <input name='date[]' type='checkbox' value='" . $dateCircuit . "'  /> Samedi " . $dateCircuit . "<br>";
            }

        }
        ?>

        <br/>

        <p><input value="Soummettre" type="submit"></p>
    </form>
</div>