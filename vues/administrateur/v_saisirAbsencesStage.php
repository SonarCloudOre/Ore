<script type="module" src="js/sms.js"></script>
<script type="module" src="js/absenceStage.js"></script>
<div id="contenu">
  <div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
        <div class="page-title-icon">
          <i class="pe-7s-id icon-gradient bg-night-fade"></i>
        </div>
        <div>
          Absences du stage
          </div>
        </div>
      </div>
    </div>
      <div class="row">
      <div class="col-md-12">
      <div class="main-card mb-3 card">
      <div class="card-body">
		<input type="hidden" name="num" value="<?php echo $stageSelectionner['ID_STAGE']; ?>">
        <h4 class="card-title">Saisir les absences du stage</h4>
		<div class="form-group">
		 <label for="num">Date : </label>
         <select id="selectDate" name="date" class="form-control">
           <?php if(!isset($_REQUEST['date'])){
              echo '<option value="Choisir" selected>Choisir une date</option>'; 
           }
            else{
              echo '<option value="Choisir">Choisir une date</option>;';
            } 
            foreach($lesDates as $uneDate){
              if($dateValue == $uneDate["value"]){
                echo '<option value="'.$uneDate["value"].'" selected>'.$uneDate["display"].'</option>';
              }
              else{
                echo '<option value="'.$uneDate["value"].'">'.$uneDate["display"].'</option>';
              }
            }
            ?>
	   </select>
       <br>
        <label for="emailAbsentsAdresses">Adresse e-mail des parents:</label><br>
        <textarea name="emailAdresses" id="emailAbsentsAdresses" rows="6" class="form-control" readonly><?=$absents?></textarea><br>
        <label for="telephonesNumbers">Numéros des parents:</label><br>
        <textarea name="telephoneNumbers" id="telephoneNumbers" rows="6" class="form-control" readonly><?=$nums?></textarea><br>
        <label for="telephonesNumbers">Aperçu du message:</label><br>
        <textarea name="message" id="messageAbsents" rows="7" class="form-control">Bonjour

Nous tenons à vous informer que votre enfant [NOM PRENOM] n'est pas présent au stage le <?php echo date('d/m/Y',strtotime($date)).' '.$matinouapDisplay;?>.

Cordialement.
Association ORE.
        </textarea><br>
        <textarea name="names" id="names" class="form-control" hidden><?=$nomsAbsents?></textarea>
      <br>
	   <a id="notifyAbsents" class="btn btn-success">Envoyer</a>
	  <br>
		</div>
    </div>
    </div>
    </div>
    </div>
</div>