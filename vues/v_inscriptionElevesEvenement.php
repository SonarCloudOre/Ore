<div id="contenu">
    <h2>Formulaire d'inscription à un évenement</h2>
    <?php
    if (!isset($_REQUEST['numCarte'])) {
        echo ' <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=inscriptionEleves&action=evenementInscriptionEleve">    
  
  
  <fieldset>
    <legend>Inscription à un évenement </legend>
      <label for="numCarte">Numéro de carte </label>
      <input name="numCarte"  autofocus="" required=""><br>
   </fieldset>
  <p><input value="Soummettre" type="submit"></p>
</form>';
    }


    if (isset($_REQUEST['numCarte'])) {
        echo ' 
		
		<h4>Bonjour,<br>
		Nous avons réussi a vous reconnaitre ' . $unEleve['NOM'] . '  ' . $unEleve['PRENOM'] . ' .
		Voici la liste des évènements à venir où tu peux t\'inscrire :<h4>
	
<form name="frmC" method="POST" action="index.php?choixTraitement=administrateur&action=AjoutEvenementAEleve&num=' . $numeroEleve . '">    
        

<center>
    <SELECT name="evenement">';
        foreach ($lesEvenements as $unEvenement) {
            echo " <option value='" . $unEvenement['NUMÉROEVENEMENT'] . "' name='evenement'>" . $unEvenement['EVENEMENT'] . "</option>";
        }


        echo '<input value="Inscription" type="submit"> </form></center>';


    }

    ?>
</div>