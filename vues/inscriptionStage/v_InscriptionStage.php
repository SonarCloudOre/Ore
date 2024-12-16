<?php
if (isset($intervenant)) {
  echo '
  <div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
        <div class="page-title-icon">
          <i class="pe-7s-id icon-gradient bg-night-fade"></i>
        </div>
        <div>
          Inscription au stage
        </div>
        </div>
      </div>
    </div>
  ';
}
 ?>


<style type="text/css">
h2,h3,h4,h5 {
	border-bottom:2px solid <?php echo $leStage['FOND_STAGE']; ?>;
	padding:5px;
	margin-top:40px;
}
@media screen and (min-width: 240px) and (max-width: 720px) {
  img{
       width:100%;
       height:auto;
  }
}
@media screen and (min-width: 720px) and (max-width: 2160px) {
  img.live{
       width:25%;
       height:auto;
  }
  img{
       width:45%;
       height:auto;
  }
}
</style>
<script type="text/javascript">
function afficher(id) {
	document.getElementById('deja_inscrit').style.display = 'none';
	document.getElementById('pas_inscrit').style.display = 'none';
	document.getElementById(id).style.display = 'block';
}
</script>

<div id="contenu">
	<div class="row">
		<div class="col-md-12">
			<div class="main-card mb-3 card">
		<div class="card-body">

	<h3 class="card-title" style="text-align:center">Inscription à <?php echo stripslashes($leStage['NOM_STAGE']); ?></h3>

    <?php if(strtotime($leStage['DATE_FIN_INSCRIT_STAGE']) > time()) { ?>

	<div>
		<p style="text-align:center"><img class="live" src="./images/afficheStage/<?php echo $leStage['AFFICHE_STAGE']; ?>"></p></p>
<p style="text-align:center"><img class="live" src="./images/imageStage/<?php echo $leStage['IMAGE_STAGE']; ?>"></p>
</div>
</div>
</div>
</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
	<div class="card-body">

<div style="text-align: justify; text-justify: inter-word;">

<?php
if (!empty($lesPartenairesStage)) {
  echo '
  <p>
    <br>
    <b><i>Avec nos partenaires :</i></b>
    <br>
  <center>
  ';
  foreach($lesPartenairesStage as $unPartenaire) {
  	echo '<div style="padding:0 20px 0 20px;"><center><img src="./images/imagePartenaire/' . $unPartenaire['IMAGE_PARTENAIRES'] . '" style="max-width:90px;max-height:90px"><br><b>' . stripslashes($unPartenaire['NOM_PARTENAIRES']) . '</b></center><br><br></div>';
  }
  echo'
  </center>
</p>
<div style="clear:both"></div>
  ';
}
?>







				<p><b>Description :</b></p>
				<p style="padding-bottom:10px;"><?php echo html_entity_decode(htmlspecialchars_decode($leStage['DESCRIPTION_STAGE']));   ?></p>

				<p><b>Dates :</b></p>
				<p style="padding-bottom:10px"> du <?php echo date("d/m/Y", strtotime($leStage['DATEDEB_STAGE'])); ?> au <?php echo date("d/m/Y", strtotime($leStage['DATEFIN_STAGE'])); ?></p>

				<p><b>Lieu :</b></p>
				<p style="padding-bottom:10px">

				<?php
				foreach($lesLieux as $leLieu) {

					if($leLieu['ID_LIEU'] == $leStage['ID_LIEU']) {
					echo $leLieu['NOM_LIEU']; ?><br><small><?php echo $leLieu['ADRESSE_LIEU']; ?> <?php echo $leLieu['CP_LIEU']; ?> <?php echo $leLieu['VILLE_LIEU']; ?> (<a href="https://www.google.fr/maps/place/<?php echo $leLieu['ADRESSE_LIEU']; ?>+
            <?php echo $leLieu['CP_LIEU']; ?>+<?php echo $leLieu['VILLE_LIEU']; ?>" target="_blank">localiser sur Google Maps</a>)</small>

				<?php } } ?>
      </p>

				<p><span class="glyphicon glyphicon-euro" style="color:<?php echo $leStage['FOND_STAGE']; ?>"></span> <b>Coût :</b></p>
				<p style="padding-bottom:10px"><?php if($leStage['PRIX_STAGE'] == 0) { echo 'Gratuit'; } else { echo $leStage['PRIX_STAGE'].' € par élève'; } ?></p>

			<?php if($leStage['PLANNING_STAGE'] != '') { ?>

				<p><span class="glyphicon glyphicon-list-alt" style="color:<?php echo $leStage['FOND_STAGE']; ?>"></span>  <b>Planning : </b></p>
				<p><img src="./images/planningStage/<?php echo $leStage['PLANNING_STAGE']; ?>" style="width:400px;" class="fancybox"><br><br>Cliquez sur le planning pour l'afficher en plus grand.</p>

			<?php } ?>
</div>
	</div>
	</div>
	</div>
	</div>

<?php


function ecrireLesAteliers($lesAteliers,$lesGroupesAtelier,$lesParticipes) {


$codeAteliers = '<h4>Ateliers ludiques</h4><p><i>Choissiez d\'abord une classe pour pouvoir choisir ensuite un atelier.</i></p>';
$niveauAteliers = array('collégiens','lycéens','tout le monde');

$i = 0;
$idAteliersCollegiens = array();
$idAteliersLyceens = array();
$groupePrecedent = '';

// On parcours les ateliers
foreach($lesAteliers as $unAtelier) {

    // Nombre d'inscrits à l'atelier
    //$nbInscritsAtelier = $pdo->nbInscritsAtelier($unAtelier['ID_ATELIERS']);

    // Si c'est un nouveau groupe d'atelier
    if($groupePrecedent != $unAtelier['GROUPE_ATELIER']) {

        // On écrit le titre
        $codeAteliers .= '<h5>';

        for($i = 0; $i < count($lesGroupesAtelier); $i++) {

            if($lesGroupesAtelier[$i]['ID'] == $unAtelier['GROUPE_ATELIER']) {
                $codeAteliers .= $lesGroupesAtelier[$i]['NOM'];
            }
        }
        $codeAteliers .= '</h5><p><i>Choisissez parmi l\'une de ces options.</i></p>';

        // On le met à jour
        $groupePrecedent = $unAtelier['GROUPE_ATELIER'];
    }

    // Numéro aléatoire
	$numeroAtelier = rand();

    if($unAtelier['NIVEAU_ATELIER'] <2) {
        $display = 'none';
    } else {
        $display = 'block';
    }

    // ON compte les inscrits
    $nbInscritsAtelier = 0;
    foreach($lesParticipes as $unParticipe) {

        if($unParticipe['ID_ATELIER'] == $unAtelier['ID_ATELIERS']) {
            $nbInscritsAtelier++;
        }
        //echo $unParticipe['ID_ATELIER'];
    }


    // Création du code
	$codeAteliers .= '<div style="border:1px solid silver;padding:10px;margin-top:25px;display:'.$display.';width:800px" class="niveau_'.$unAtelier['NIVEAU_ATELIER'].'">
	<label for="atelier_'.$numeroAtelier.'" style="width:800px;cursor:pointer">
	<img src="./images/ateliers/'.$unAtelier['IMAGE_ATELIERS'].'" style="float:left;width:100px;margin:10px">';

    // Si l'atelier est libre
    if($nbInscritsAtelier < $unAtelier['ID_ATELIERS']) {
        $codeAteliers .= '<input type="radio" name="atelier_'.$groupePrecedent.'" id="atelier_'.$numeroAtelier.'" value="'.$unAtelier['ID_ATELIERS'].'" required="required"> <input type="hidden" name="groupeAtelier" value="'.$groupePrecedent.'"> <b>'.stripslashes($unAtelier['NOM_ATELIERS']).'</b><br><br>
        '.stripslashes($unAtelier['DESCRIPTIF_ATELIERS']).' <br>
        Pour '.$niveauAteliers[$unAtelier['NIVEAU_ATELIER']].'.';
    } else {
        $codeAteliers .= '<b>'.stripslashes($unAtelier['NOM_ATELIERS']).'</b><br><br><b style="color:red">Cet atelier est désormais complet.</b>';
    }

	$codeAteliers .= '<div style="clear:both"></div></label></div>';
	$i++;

	if($unAtelier['NIVEAU_ATELIER'] == 0) { $idAteliersCollegiens[] = $numeroAtelier; }
	if($unAtelier['NIVEAU_ATELIER'] == 1) { $idAteliersLyceens[] = $numeroAtelier; }
}

// Si y'a aucun atelier
if($i == 0) { $codeAteliers = ''; }
echo $codeAteliers;
}
?>


	<!-- Module lightbox -->
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.pack.min.js"></script>
<script type="text/javascript">
    $(function($){
        var addToAll = false;
        var gallery = false;
        var titlePosition = 'inside';
        $(addToAll ? 'img' : 'img.fancybox').each(function(){
            var $this = $(this);
            var title = $this.attr('title');
            var src = $this.attr('data-big') || $this.attr('src');
            var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
            $this.wrap(a);
        });
        if (gallery)
            $('a.fancybox').attr('rel', 'fancyboxgallery');
        $('a.fancybox').fancybox({
            titlePosition: titlePosition
        });
    });
    $.noConflict();
</script>

<script type="text/javascript">
function afficherAteliers(id) {

    document.getElementById('tous_ateliers_ore').style.display = 'block';
	document.getElementById('tous_ateliers_pas_ore').style.display = 'block';


	classe = document.getElementById(id).selectedIndex;

	// College
	if(classe < 5) {

		// On affiche le collège
		var x = document.getElementsByClassName("niveau_0");
		for (i = 0; i < x.length; i++) { x[i].style.display = 'block'; }

		// On masque le lycée
		var x = document.getElementsByClassName("niveau_1");
		for (i = 0; i < x.length; i++) { x[i].style.display = 'none'; }

	// Lycee
	} else {

		// On affiche le lycée
		var x = document.getElementsByClassName("niveau_1");
		for (i = 0; i < x.length; i++) { x[i].style.display = 'block'; }

		// On masque le collège
		var x = document.getElementsByClassName("niveau_0");
		for (i = 0; i < x.length; i++) { x[i].style.display = 'none'; }

	}
}
</script>

<div class="row">
  <div class="col-md-12">
    <div class="main-card mb-3 card">
  <div class="card-body">
	<h3 style="text-align:center" class="card-title">Inscription - étape 1</h3>
	<center>
	 <label for="inscrit_ore" style="font-size:16px;text-align:center">Êtes-vous déjà adhérent de l'association ORE ?</label><br>
	 <a href="#deja_inscrit" onclick="afficher('deja_inscrit')" class="btn btn-success" style="font-size:24px;margin-right:20px">Oui</a>
	 <a href="#pas_inscrit" onclick="afficher('pas_inscrit')" class="btn btn-danger" style="font-size:24px">Non</a>
	 </center>
  </div>
  </div>
  </div>
  </div>

  <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=inscriptionstage&action=valideInscriptionOre">
<div id="deja_inscrit" style="display:none">
  <div class="row">
    <div class="col-md-12">
      <div class="main-card mb-3 card">
    <div class="card-body">
	<h3 class="card-title" style="text-align:center">Inscription - étape 2</h3>

	<!-- Champs cachés -->
	<input type="hidden" name="num" value="<?php echo $leStage['ID_STAGE']; ?>">
	<input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s', time()); ?>">
	<input type="hidden" name="ip" value="<?php echo $_SERVER["REMOTE_ADDR"]; ?>">
	<input type="hidden" name="user_agent" value="<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>">
	<input type="hidden" name="origine" value="<?php echo $_SERVER["HTTP_REFERER"]; ?>">
	<input type="hidden" name="nom_stage" value="<?php echo addslashes($leStage['NOM_STAGE']); ?>">

	<div class="form-group">
		 <label class="required" for="nom">Nom de l'élève </label>
      <input class="form-control" name="nom" placeholder="Nom" value="" autofocus=""  required><br>

      <label class="required" for="prenom">Prénom de l'élève </label>
      <input class="form-control" name="prenom" placeholder="Prénom" value="" autofocus=""  required><br>


	   <label class="required" for="classe">Classe</label>
       <select class="form-control" name="classe" id="classe_deja_inscrit" style="width:200px;" onchange="afficherAteliers('classe_deja_inscrit')" required>
	   <option value="" disabled="disabled" selected="selected">Choisir</option>
			<?php foreach ($lesClasses as $uneLigne)
			{
				echo '<option value="'.$uneLigne['ID'].'">'.$uneLigne['NOM'].'</option>';}
			 ?>
			</select><br>

	  <label class="required" for="ddnaissance">Date de naissance de l'élève </label><br>
      <input type="date" class="form-control" name="ddnaissance"    style="width:200px" required>
	  <br><br>

    <label class="required" for="tel_parent">Téléphone des parents</label><br>
        <input type="tel" class="form-control" name="tel_parent" id="telParent" placeholder="Téléphone" required>
    <br><br>
    
    <label class="required" for="tel_eleve">Téléphone de l'enfant</label><br>
        <input type="tel" class="form-control" name="tel_eleve" id="telEleve" placeholder="Téléphone" required>
    <br><br>

      
	  <label for="email_parent">Email des parents</label>
      <input class="form-control" name="email_parent" placeholder="xxxx@xxxxx.xx" value=""   type="email"><br>
	  <div id="tous_ateliers_ore" style="display:none">
	  <?php
	  /* Ateliers */
	  ecrireLesAteliers($lesAteliers,$lesGroupesAtelier,$lesParticipes);
	  ?>
        </div>

	 <br><br> <input id="inscrireEleve" value="Envoyer" type="submit" class="btn btn-success">
	</div>
	</div>
  </div>
  </div>
  </div>
  </div>
	</form>

















	<div id="pas_inscrit" style="display:none">
    <div class="row">
      <div class="col-md-12">
        <div class="main-card mb-3 card">
          <div class="card-body">


	<h3 class="card-title" style="text-align:center">Inscription - étape 2</h3>
	<form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=inscriptionstage&action=valideInscriptionNouvelle">

	<!-- Champs cachés -->
	<input type="hidden" name="num" value="<?php echo $leStage['ID_STAGE']; ?>">
	<input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s', time()); ?>">
	<input type="hidden" name="ip" value="<?php echo $_SERVER["REMOTE_ADDR"]; ?>">
	<input type="hidden" name="user_agent" value="<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>">
	<input type="hidden" name="origine" value="<?php echo $_SERVER["HTTP_REFERER"]; ?>">
	<input type="hidden" name="nom_stage" value="<?php echo addslashes($leStage['NOM_STAGE']); ?>">

	<div class="form-group">
		<h4 class="card-title">Informations sur l'élève</h4>
		<label class="required" for="nom">Nom de l'élève </label>
      <input class="form-control" name="nom" placeholder="Nom" value="" autofocus="" required><br>

      <label class="required" for="prenom">Prénom de l'élève </label>
      <input class="form-control" name="prenom" placeholder="Prénom" value="" autofocus=""  required><br>

	   <label class="required" for="ddnaissance">Date de naissance de l'élève </label><br>
      <input type="date" class="form-control" name="ddnaissance"    style="width:200px" required>
	  <br>

	  <br>

	  <label class="required" for="sexe">Sexe de l'élève</label>
      <select name="sexe" class="form-control" required style="width:200px;">
    <option value="" selected="selected" disabled="disabled">Choisir</option>
		<option value="H">Garçon</option>
		<option value="F">Fille</option>
      </select><br>

	   <label class="required" for="etab">Etablissement</label>
       <select class="form-control" name="etab" style="width:200px;" required>
		<option value="" selected="selected" disabled="disabled">Choisir</option>
			<?php foreach ($lesEtablissements as $uneLigne)
			{
				echo '<option  value="'.$uneLigne['ID'].'">'.$uneLigne['NOM'].'</option>';}
			?>
			</select><br>

	  <label class="required" for="classe">Classe</label>
       <select class="form-control" name="classe" style="width:200px;" required id="classe_pas_inscrit" onchange="afficherAteliers('classe_pas_inscrit')">
	   <option value="" selected="selected" disabled="disabled">Choisir</option>
			<?php foreach ($lesClasses as $uneLigne)
			{
				echo '<option  value="'.$uneLigne['ID'].'">'.$uneLigne['NOM'].'</option>';}
			 ?>
			</select><br>

       <label class="required" for="filiere">Filière</label>
       <select class="form-control" name="filiere" style="width:200px;" required>
	   <option value="" selected="selected" disabled="disabled">Choisir</option>

			<?php foreach ($lesfilieres as $uneLigne)
			{
				echo '<option  value="'.$uneLigne['ID'].'">'.$uneLigne['NOM'].'</option>';		}
			?>
			</select><br>

	    <label for="tel_enfant">Téléphone de l'enfant</label>
      <input class="form-control" name="tel_enfant"  value="" autofocus="" placeholder="0000000000" type="number"> <br>

       <label for="email_enfant">Email de l'enfant</label>
      <input class="form-control" name="email_enfant" placeholder="xxxx@xxxxx.xx" value=""  type="email" ><br>

	  <h4 class="card-title">Informations sur le(s) parent(s)</h4>
	   <label for="email_parent">Email des parents</label>
      <input class="form-control" name="email_parent" placeholder="xxxx@xxxxx.xx" value=""   type="email"><br>

	   <label class="required" for="tel_parent">Téléphone des parents</label>
      <input class="form-control" name="tel_parent"  autofocus="" value=""  required><br>

	   <label class="required" for="adresse">Adresse</label>
      <input class="form-control" name="adresse"  autofocus="" value=""  required><br>

      <?php
      $LstVilles = array();
      $LstCP = array();
      for ($i=0; $i < count($villesFrance); $i++) {
        $ville = $villesFrance[$i]["COMMUNE"];
        $cp = $villesFrance[$i]["CP"];
        array_push($LstVilles, $ville);
        array_push($LstCP, $cp);
      }
      ?>


      <label class="required" for="cp">Code Postal</label>
      <input class="form-control" name="cp"  value=""  required><br>

      <link rel="stylesheet" href="./styles/css/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


      <label class="required" for="ville">Ville</label>
      <input class="form-control" name="ville"  value=""  required><br>

	  <label for="association">Association</label>
      <select class="form-control"  name="association">
        <option value="" readonly selected>Choisir</option>
        <?php foreach ($lesAssociations as $uneAssociation)
        {
          echo '<option value="'.$uneAssociation[1].'">'.$uneAssociation[1].'</option>';
        }
          ?>


      </select>

        <div id="tous_ateliers_pas_ore" style="display:none">
	  <?php
	  /* Ateliers */
	 ecrireLesAteliers($lesAteliers,$lesGroupesAtelier,$lesParticipes);
	  ?>
        </div>

	  <br><br>  <input value="Envoyer" type="submit" class="btn btn-success">
	</div>
	</form>
</div>
</div>
</div>
</div>
	</div>





    <?php } else { ?>
    <center><img src="images/danger.jpg" style="width:100px"></center>
    <p style="color:red;font-size:30px;text-align:center;font-weight:bold">Les inscriptions à ce stage sont fermées !<br><br>
        Pour plus d'informations, contactez-nous :<br>
        - Par téléphone au <a href="tel:0380482396">0380482396</a><br>
        - Par mail à <a href="mailto:association.ore@gmail.com">association.ore@gmail.com</a><br>
        - Au Centre Informatique Municipal au 3 rue des Prairies 21800 Quetigny.
        </p>



    <?php
}
?>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  var villes = <?php echo json_encode($LstVilles); ?>;
  var cp = <?php echo json_encode($LstCP); ?>;
  $("input[name='ville']").autocomplete({
    source: villes,
  });
  $("input[name='cp']").autocomplete({
    source: cp,
  });
} );

$( function() {
  $("input[name='ville']").change(function() {
    var villes = <?php echo json_encode($LstVilles); ?>;
    var cp = <?php echo json_encode($LstCP); ?>;
    var a = $("input[name='ville']").val();
    indexVille = villes.indexOf(a);
    //alert(indexVille);
    var cpText = cp[indexVille];
    //alert(cpText);
    $("input[name='cp']").val(cpText);
  });
});

$( function() {
  $("input[name='cp']").change(function() {
    var villes = <?php echo json_encode($LstVilles); ?>;
    var cp = <?php echo json_encode($LstCP); ?>;
    var a = $("input[name='cp']").val();
    indexCp = cp.indexOf(a);
    //alert(indexVille);
    var villeText = villes[indexCp];
    //alert(cpText);
    $("input[name='ville']").val(villeText);
  });
});

</script>
