<!-- ancienne vue de la connexion -->


<div id="contenu">

    <form class="navbar-form navbar-left" name="frmIdentification" method="POST"
          action="index.php?choixTraitement=connexion&action=valideConnexion" style="margin-left:30%;text-align:center">
        <div class="form-group">
		<fieldset><legend>Connexion</legend>
            <br/>
			<center><img src="images/cadenas.png" style="width:100px"></center>
			<br/><br/>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i></span>
					<input id="login" class="form-control"	type="text" 	name="login"  size="30" maxlength="45" 	placeholder="Email">
				</div>
		   </p>
            <p>
                <div class="input-group" style="text-align:center">
					 <span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
					<input id="mdp" class="form-control"	type="password"  name="mdp" size="30" 	maxlength="45" 	placeholder="Mot de Passe">
				</div>
            </p><br ><br/>
                <input type="submit" class="btn btn-success"	name="valider"		value="Valider">
            </p>
        </fieldset>
		</div>
	</form>

</div>
