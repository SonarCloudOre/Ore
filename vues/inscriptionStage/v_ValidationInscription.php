<script type="module" src="js/inscriptionStage.js"></script>
<div id="contenu">
	<p><center style="font-size:30px;color:green">
		<img src="./images/coche_valid.png"><br><br>
		Votre inscription a bien été validée !<br><br>
		Cliquez sur le bouton ci-dessous pour effectuer une nouvelle inscription :<br><br>
		<a href="index.php?choixTraitement=inscriptionstage&action=inscription&num=<?php echo $num; ?>" style="font-size:30px;" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Nouvelle inscription</a>
	</center></p>
	<textarea id="nums" hidden><?=$tel_parent?></textarea>
	<textarea id="message" hidden><?=$message?></textarea>
</div>
<?=include(dirname(__DIR__,2)."/include/mail.php")?>
<?php
	sendMail($mail,"Confirmation d'inscription au ".$nom_stage,$message,null);
?>
