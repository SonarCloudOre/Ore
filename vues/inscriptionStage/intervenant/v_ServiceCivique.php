<div id="contenu">
    <h2>Planning Intervenant Très d'Union</h2>

    <h3>Service Civique de <?php echo $intervenant['NOM'] . " " . $intervenant['PRENOM']; ?></h3>
    <br/>
    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=intervenant&action=ServiceCiviqueModif">


        <ul> <?php
            echo ' <label for="service">Service Civique : <br />
       </label>
      <textarea  name="service">' . $serviceCivique . '</textarea><br>'; ?>
        </ul>
        <input value="Valider" type="submit">
    </form>
    <br/>

    <p>
</div>