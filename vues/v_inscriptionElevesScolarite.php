<div id="contenu">
    <h2>Formulaire d'inscription au soutien scolaire</h2>
    <?php
    if (!isset($_REQUEST['numCarte'])) {
        echo ' <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=inscriptionEleves&action=InscriptionScolarite">    
  
  
  <fieldset>
    <legend>Inscription au soutien scolaire </legend>
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
		Pour cette nouvelle année, nous te laissons remplir tes informations sur ta scolarité :<h4>
	
<form name="frmC" method="POST" action="index.php?choixTraitement=inscriptionEleves&action=InscriptionScolariteValidation&num=' . $numeroEleve . '">    
        


    

<fieldset>
    <legend>Scolarité</legend>
    
    <label for="etab">Etablissement</label>
       <select name="etab" style="width:200px;">';

        foreach ($lesEtablissements as $uneLigne) {
            echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
        }
        echo '
			</select><br>
            
            
	  <label for="classe">Classe</label>
       <select name="classe" style="width:200px;">';

        foreach ($lesClasses as $uneLigne) {
            echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
        }
        echo '
			</select><br>
            
       <label for="filiere">Filières</label>
       <select name="filiere" style="width:200px;">';

        foreach ($lesfilieres as $uneLigne) {
            echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
        }
        echo '
			</select><br>
            
        <label for="lv1">LV1</label>
       <select name="lv1" style="width:200px;">';

        foreach ($lesLangues as $uneLigne) {
            echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
        }
        echo '
			</select><br>
            
        <label for="lv2">LV2</label>
       <select name="lv2" style="width:200px;">';

        foreach ($lesLangues as $uneLigne) {
            echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
        }
        echo '
			</select><br>
            
            <label for="prof_principal">Professeur Principal </label>
      <input name="prof_principal"  autofocus="" required=""><br>
      
      
    <legend>Difficultés Scolaire</legend>';


        foreach ($lesMatieres as $uneLigne) {
            echo "<label for='" . $uneLigne['NOM'] . "'><input id='" . $uneLigne['NOM'] . "' name='difficultes[]' value='" . $uneLigne['ID'] . "' type='checkbox'> " . $uneLigne['NOM'] . "</label>";
        }

        echo '<input value="Inscription" type="submit"> </form></fieldset>            
';


    }

    ?>
</div>