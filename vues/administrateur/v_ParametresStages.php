<div id="contenu">


    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Paramètres des stages
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <?php if (!isset($onglet)) {
        $onglet = 'stages';
    } ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav" id="onglets"
                        role="tablist">
                        <li role="presentation" class="nav-item">
                            <a href="#stages" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab">
                                <span>Stage</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item ">
                            <a href="#lieux" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span>Lieux</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item ">
                            <a href="#partenaires" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span>Partenaires</span>
                            </a>
                        </li>
                        <li role="presentation" class="nav-item ">
                            <a href="#intervenants" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                <span>Intervenants</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $('#onglets a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>


<div class="tab-content">

    <!-------------------------------------------------------------------- Stages --------------------------------------------------------------------------------->
    <div role="tabpanel" class="tab-pane <?php if (($onglet == 'stages')) {
        echo 'active';
    } ?>" id="stages">
        <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
              action="index.php?choixTraitement=administrateur&action=ajouterStage">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Ajouter un stage</h4>
                            <div class="form-group">
                                <?php echo '
      <div class="form-row">
      <div class="col-md-4">
      <label for="nom" class="required">Nom </label>
      <input class="form-control" name="nom" placeholder="Votre nom" value="" autofocus="" required><br>
</div>
</div>

      <input class="form-control" type="hidden" name="annee" placeholder="Année" value="' . $anneeEnCours . '" autofocus="" readonly="readonly">

	  <label for="datedeb" class="required">Dates </label><br>
      du <input class="form-control" style="width:150px;display:inline" name="datedeb" value="" autofocus="" type="date" required> au <input style="width:150px;display:inline" class="form-control" name="datefin" value="" autofocus="" type="date" required><br>

    <br><label for="datedeb" class="required">Date de fermeture des inscriptions </label><br>
      <input class="form-control" style="width:150px;display:inline" name="datefininscrit" value="" autofocus="" type="date" required><br>

        <br><label for="duree_seances" class="required">Durée des séances (en heures)</label><br>
        <input class="form-control" type="number" name="duree_seances" placeholder="Durée" value="" autofocus="" style="width:100px" required><br>


		 <label for="prix" class="required">Prix (mettre 0 pour gratuit)</label>
      <input class="form-control" name="prix" placeholder="Prix" value="" autofocus="" style="width:100px" required><br>
      
		 <label for="prix_sortie" class="required">Prix Sortie(mettre 0 pour gratuit)</label>
      <input class="form-control" name="prix_sortie" placeholder="Prix" value="" autofocus="" style="width:100px" required><br>

	  <br><label for="lieu" class="required">Lieu</label>
    ';
                                echo '<select name="lieu" class="form-control" required>';
                                foreach ($lesLieux as $leLieu) {
                                    echo '<option';

                                    echo ' value="' . $leLieu['ID_LIEU'] . '">' . $leLieu['NOM_LIEU'] . ' (' . $leLieu['ADRESSE_LIEU'] . ' ' . $leLieu['CP_LIEU'] . ' ' . $leLieu['VILLE_LIEU'] . ')</option>';
                                }
                                echo '</select> <br>

	   <br><label for="prix">Couleur</label>
      <input class="form-control" name="couleur" value="" autofocus="" type="color"  style="width:100px"><br>

		<label for="annee" class="required">Description </label>
      <textarea style="width:700px;height:300px" class="form-control" id="editor" name="content" placeholder="Description" required></textarea><br>

		 <br><label for="prix">Image d\'illustration </label><br>	';
                                echo '<i>Aucune image envoyée.</i>';

                                echo '	<br>
		<input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.gif" /><br>


		 <br><label for="prix">Affiche </label><br>	';
                                echo '<i>Aucune affiche envoyée.</i>';

                                echo '	<br>
		<input type="file" class="form-control" name="affiche" accept=".jpg,.jpeg,.png,.gif" /><br>


		 <br><label for="prix">Planning </label><br>	';
                                echo '<i>Aucun planning envoyé.</i>';
                                echo '	<br>
		<input type="file" class="form-control" name="planning" accept=".jpg,.jpeg,.png,.gif" /><br>


		<br></div>'; ?>
                                <input value="Ajouter" type="submit" class="btn btn-success">
                            </div>
                        </div>
                    </div>
                </div>
        </form>

        <!-- Activation du module TinyMCE sur le textarea -->
        <script type="text/javascript">
            tinymce.init({
                selector: 'textarea',
                language: 'fr_FR',
                height: 300,
                theme: 'modern',
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
                ],
                toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
                image_advtab: true,
                templates: [
                    {title: 'Test template 1', content: 'Test 1'},
                    {title: 'Test template 2', content: 'Test 2'}
                ],
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'
                ]
            });
        </script>

    </div>


    <!-------------------------------------------------------------------- Lieux --------------------------------------------------------------------------------->
    <div role="tabpanel" class="tab-pane <?php if (($onglet == 'lieux')) {
        echo 'active';
    } ?>" id="lieux">
        <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
              action="index.php?choixTraitement=administrateur&action=AjouterLieu">

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h4 class="card-title">Ajouter un lieu</h4>
                                <div class="row">
                                    <div class="position-relative form-group col-md-6">
                                        <label for="nom">Nom </label>
                                        <input class="form-control" type="text" name="nom" value="" autofocus=""><br>
                                    </div>
                                    <div class="position-relative form-group col-md-6">
                                        <label for="adresse">Adresse </label>
                                        <input class="form-control" type="text" name="adresse" value=""
                                               autofocus=""><br>
                                    </div>
                                    <div class="position-relative form-group col-md-6">
                                        <label for="cp">Code postal </label>
                                        <input class="form-control" type="text" name="cp" value="" autofocus=""><br>
                                    </div>
                                    <div class="position-relative form-group col-md-6">
                                        <label for="ville">Ville </label>
                                        <input class="form-control" type="text" name="ville" value="" autofocus=""><br>
                                    </div>
                                </div>
                                <input value="Ajouter" type="submit" class="btn btn-success">
                            </div>
                        </div>
                    </div>
                </div>

        </form>


        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Lieux existants</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Code postal</th>
                            <th>Ville</th>
                            <th colspan="1">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($lesLieux as $leLieu) {
                            echo '<tr>
			<td>' . $leLieu['NOM_LIEU'] . '</td>
			<td>' . $leLieu['ADRESSE_LIEU'] . '</td>
			<td>' . $leLieu['CP_LIEU'] . '</td>
			<td>' . $leLieu['VILLE_LIEU'] . '</td>
			<td><a href="index.php?choixTraitement=administrateur&action=modifLieu&num=' . $leLieu['ID_LIEU'] . '" class="btn btn-info pe-7s-pen"></a></td>
			<td>';
                            if ($admin == 2) {
                                echo '<a href="javascript:void(0);" class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment supprimer ce lieu ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&amp;action=supprimerUnLieu&num=' . $leLieu['ID_LIEU'] . '\'; } else { void(0); }"><span class="pe-7s-trash"></span></a>';
                            }
                            echo '</td>
		</tr>';

                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-------------------------------------------------------------------- Partenaires --------------------------------------------------------------------------------->
<div role="tabpanel" class="tab-pane <?php if (($onglet == 'partenaires')) {
    echo 'active';
} ?>" id="partenaires">
    <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
          action="index.php?choixTraitement=administrateur&action=AjouterPartenaire">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Ajouter un partenaire</h4>
                            <label for="nom">Nom </label>
                            <input class="form-control" name="nom" value="" autofocus="" style="max-width : 300px;"><br>
                            <label for="image">Image </label>
                            <input type="file" style="width:300px" class="form-control" name="image"><br>

                            <input value="Ajouter" type="submit" class="btn btn-success">
    </form>
</div>
</div>
</div>
</div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4 class="card-title">Partenaires existants</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Image</th>
                        <th colspan="2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($lesPartenaires as $lePartenaire) {
                        if ($lePartenaire['IMAGE_PARTENAIRES'] == '') {
                            $lePartenaire['IMAGE_PARTENAIRES'] = 'AUCUNE.jpg';
                        }
                        echo '<tr>
			<td>' . $lePartenaire['NOM_PARTENAIRES'] . '</td>
			<td><img src="images/imagePartenaire/' . $lePartenaire['IMAGE_PARTENAIRES'] . '" style="width:100px"></td>
						<td><a class="btn btn-primary" href="index.php?choixTraitement=administrateur&action=modifPartenaire&num=' . $lePartenaire['ID_PARTENAIRES'] . '"><span class="pe-7s-pen"></span></a></td>
						<td>';
                        if ($admin == 2) {
                            echo '<a href="javascript:void(0);" class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment supprimer ce partenaire ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&amp;action=supprimerPartenaire&num=' . $lePartenaire['ID_PARTENAIRES'] . '\'; } else { void(0); }"><span class="pe-7s-trash"></span></a>';
                        }
                        echo '</td>

		</tr>';

                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</div>


<!-------------------------------------------------------------------- Intervenants --------------------------------------------------------------------------------->
<div role="tabpanel" class="tab-pane <?php if (($onglet == 'intervenants')) {
    echo 'active';
} ?>" id="intervenants">
    <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
          action="index.php?choixTraitement=administrateur&action=importerIntervenantStage">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Importer un intervenant</h4>
                        <label for="intervenat">Intervenant :</label>
                        <select class="form-control" name="intervenant" style="max-width : 300px;">
                            <?php

                            foreach ($lesIntervenants as $unIntervenant) {
                                echo '<option value="' . $unIntervenant['ID_INTERVENANT'] . '"';

                                foreach ($lesIntervenantsStageTout as $unIntervenantStage) {
                                    // Si l'intervenant a déjà été importé
                                    if ($unIntervenantStage['ID_INTERVENANT'] == $unIntervenant['ID_INTERVENANT']) {
                                        echo ' disabled';
                                    }
                                }
                                echo '>' . $unIntervenant['NOM'] . ' ' . $unIntervenant['PRENOM'] . '</option>';
                            }
                            ?>
                        </select><br>

                        <input value="Importer" type="submit" class="btn btn-success">
    </form>
</div>
</div>
</div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4 class="card-title">Intervenants déjà importés</h4>
                <table class="table">
                    <thead>
                    <tr>
                    <tr>
                        <th>Fiche</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($lesIntervenantsStageTout as $unIntervenant) {
                        echo '<tr>
	<td><a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant['ID_INTERVENANT'] . '">Voir la fiche</a></td>
	<td>' . $unIntervenant['NOM_INTERVENANT'] . '</td>
	<td>' . $unIntervenant['PRENOM_INTERVENANT'] . '</td>
	<td>' . $unIntervenant['EMAIL_TABLE_INTERVENANT'] . '</td>
	<td>' . $unIntervenant['TELEPHONE_INTERVENANT'] . '</td>
	<td>';
                        if ($admin == 2) {
                            echo '<a href="javascript:void(0);" class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment supprimer cet intervenant ? Il ne sera pas supprimé de l extranet !\')) { document.location.href=\'index.php?choixTraitement=administrateur&amp;action=supprimerIntervenantStage&num=' . $unIntervenant['ID_INTERVENANT'] . '\'; } else { void(0); }"><span class="pe-7s-trash"></span> Supprimer des stages</a>';
                        }
                        echo '</td>
	</tr>';

                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>


</div>


<?php
$LstVilles = array();
$LstCP = array();
for ($i = 0; $i < count($villesFrance); $i++) {
    $ville = $villesFrance[$i]["COMMUNE"];
    $cp = $villesFrance[$i]["CP"];
    array_push($LstVilles, $ville);
    array_push($LstCP, $cp);
}
?>
<link rel="stylesheet" href="./styles/css/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function () {
        var villes = <?php echo json_encode($LstVilles); ?>;
        var cp = <?php echo json_encode($LstCP); ?>;
        $("input[name='ville']").autocomplete({
            source: villes,
        });
        $("input[name='cp']").autocomplete({
            source: cp,
        });
    });

    $(function () {
        $("input[name='ville']").change(function () {
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

    $(function () {
        $("input[name='cp']").change(function () {
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
