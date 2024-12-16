<script type="module" src="js/utils.js"></script>
<script type="module" src="js/sms.js"></script>
<script type="module" src="js/stages.js"></script>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Stages
                <?php
                if (isset($stageSelectionner)) {
                    echo '<div class="page-title-subheading">' . $stageSelectionner['NOM_STAGE'] . '</div>';
                } else {
                    echo '<div class="page-title-subheading">Sélectionner un stage dans la liste déroulante</div>';
                }
                $linkInscription = "";
                ?>
            </div>
        </div>

                              <?php
if (isset($stageSelectionner))
{
    $linkInscription = sprintf("https://www.association-ore.fr/extranet/index.php?choixTraitement=inscriptionstage&action=inscription&num=%s",$stageSelectionner["ID_STAGE"]);
    echo '
                              <div class="page-title-actions">
                              <div class="d-inline-block dropdown">
                              <button type="button"  class="mr-2 btn btn-primary" onclick="history.back()">
                               <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                              </button>
                                <a id="inscriptionLink" href="index.php?choixTraitement=inscriptionstage&action=inscription&num=' . $stageSelectionner["ID_STAGE"] . '" target="_blank"><button type="button" class="mr-2 btn btn-primary" value="Imprimer pour les élèves"> <span class="btn-icon-wrapper pr-2">
                                  <i class="fa fa-print fa-w-20"></i>
                                </span>Formulaire d\'inscription</button></a>
                              <button type="button" id="communicateStage" class="mr-2 btn btn-primary">
                              Communication
                              </button>
                                ';

            if (isset($stageSelectionner)) {
                if ($admin == 2) {
                    echo '
                                        <a href="javascript:void(0);" class="btn btn-danger"  onclick="if(confirm(\'Voulez-vous vraiment supprimer ce stage ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerUnStage&num=' . $stageSelectionner['ID_STAGE'] . '\'; } else { void(0); }"><span class="glyphicon glyphicon-trash"></span> Supprimer le stage
                                        </a>';
                }
            }
            echo '
                          </div>
                        </div>
                      ';
        } ?>

    </div>
</div>


<form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=Stages">

    <center>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h2>Chercher un stage</h2>
                        <br>
                        <SELECT style="width:200px;display:inline" name="unStage" onchange="this.form.submit()"
                                class="multiselect-dropdown form-control" data-live-search="true">
                            <option <?php if (!isset($stageSelectionner)) {
                                echo 'selected="selected"';
                            } ?> disabled="disabled">Choisir
                            </option>
                            <?php foreach ($lesStages as $unStage) {
                                if (isset($stageSelectionner) and $unStage['ID_STAGE'] == $stageSelectionner['ID_STAGE']) {
                                    $selectionner = "selected='selected'";
                                } else {
                                    $selectionner = "";
                                }
                                
                                echo " <option " . $selectionner . " value='" . $unStage['ID_STAGE'] . "' name='unStage'>" . stripslashes($unStage['NOM_STAGE']) . "</option>";

                            }
                            echo ' </select></div></div></div></div></center></form>';

                            if (isset($stageSelectionner)) {
                                ?>

                                <?php if (!isset($onglet)) {
                                    $onglet = 'infos';
                                } ?>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body">
                                                <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"
                                                    id="onglets" role="tablist">

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#infos" class="nav-link active" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Stage</span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#partenaires" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Partenaires</span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#ateliers" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Ateliers</span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#inscriptions" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Inscriptions</span>
                                                        </a>
                                                    </li>


                                                    <li class="nav-item" role="presentation">
                                                        <a href="#groupes" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Groupes</span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#impressions" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Documents</span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#intervenants" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Intervenants</span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#notes" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Notes</span>
                                                        </a>
                                                    </li>
                                                    
                                                    <li class="nav-item" role="presentation">
                                                        <a href="#reglements" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Réglements</span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#stats" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Stats</span>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a href="#presencesEleves" class="nav-link" aria-controls="home"
                                                           role="tab" data-toggle="tab">
                                                            <span>Présences des élèves</span>
                                                        </a>
                                                    </li>

                                                </ul>
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

                                <!--script qui doit permettre d'ajouter selected dans la liste déroulante-->
                                <script>
                                    //var Stage = <?php echo json_encode($url); ?>;
                                    //$('#stageURL option[value=fevrier]').attr('selected','selected');
                                    //$("#stageURL").val('fevrier').attr('selected','selected');
                                    //$('#selected option').removeAttr('selected').filter('[value=mai]').attr('selected', true);
                                    $('[name=stageURL]').val(mai);
                                </script>

                                <div class="tab-content">
                                    <!-------------------------------------------------------------------- Informations --------------------------------------------------------------------------------->
                                    <div role="tabpanel"
                                         class="tab-pane <?php if (($onglet == 'infos') or !isset($onglet)) {
                                             echo 'active';
                                         } ?>" id="infos">
                                        <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
                                              action="index.php?choixTraitement=administrateur&action=LesStagesModifier">

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="main-card mb-3 card">
                                                        <div class="card-body">
                                                            <?php
                                                            $lesUrls = ['janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre', 'hiver', 'printemps', 'ete', 'automne', 'informatique', 'revision', 'ecoleouverte', 'bac', 'brevet', 'bts'];

                                                            echo '
        <h4 class="card-title">Stage</h4>
        <div class="form-row">
          <div class="col-md-3">
	 <label for="num">Numéro</label>
';
                                                            echo '
      <input class="form-control" name="num"  value="' . $stageSelectionner['ID_STAGE'] . '" readonly="readonly" autofocus="" ><br>
      </div>
      </div>
      <label for="stageURL">URL numéro stage</label>
      <div class="form-row">
        <div class="col-md-5">
      <div id="selected">
      <select id="stageURL" class="form-control" name="stageURL">
        <option disabled="disabled" selected="selected">Choisir</option>
      ';
                                                            foreach ($lesUrls as $unUrl) {
                                                                if ($existURL["STAGE"] == $num && $existURL["URL"] == $unUrl) {
                                                                    $url = $existURL["URL"];
                                                                    echo '<option value="' . $unUrl . '" selected>' . $unUrl . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $unUrl . '">' . $unUrl . '</option>';
                                                                }
                                                            }

                                                            echo '  </select><br/><br/>
      </div>
      </div>
      </div>

      <div class="form-row">
        <div class="col-md-7">
      <label for="nom">Nom </label>
      <input class="form-control" name="nom" placeholder="Votre nom" value="' . $stageSelectionner['NOM_STAGE'] . '" autofocus="" ><br>
      </div>
      </div>

      <div class="form-row">
        <div class="col-md-3">
      <label for="annee">Année </label>
      <input class="form-control" name="annee" placeholder="Année" value="' . $stageSelectionner['ANNEE_STAGE'] . '" autofocus="" ><br>
</div>
</div>

	  <label for="datedeb">Dates </label><br>
      du <input class="form-control" style="width:200px;display:inline" name="datedeb" value="' . $stageSelectionner['DATEDEB_STAGE'] . '" autofocus="" type="date"> au <input style="width:200px;display:inline" class="form-control" name="datefin" value="' . $stageSelectionner['DATEFIN_STAGE'] . '" autofocus="" type="date"><br>

        <br><label for="datedeb">Date de fermeture des inscriptions </label><br>
      <input class="form-control" style="width:200px;display:inline" name="datefininscrit" value="' . $stageSelectionner['DATE_FIN_INSCRIT_STAGE'] . '" autofocus="" type="date"><br>

        <br><label for="duree_seances">Durée des séances (en heures)</label><br>
        <input class="form-control" type="number" name="duree_seances" placeholder="Durée" value="' . $stageSelectionner['DUREE_SEANCES_STAGE'] . '" autofocus="" style="width:100px"><br>


		 <label for="prix">Prix (mettre 0 pour gratuit)</label>
      <input class="form-control" name="prix" type="number" placeholder="Prix" value="' . $stageSelectionner['PRIX_STAGE'] . '" autofocus="" style="width:100px"><br>

        <label for="prix_sortie">Prix Sortie (mettre 0 pour gratuit)</label>
      <input class="form-control" name="prix_sortie" type="number" placeholder="Prix" value="' . $stageSelectionner['PRIX_STAGE_SORTIE'] . '" autofocus="" style="width:100px"><br>

	 <label for="lieu">Lieu</label>
      <select name="lieu" class="form-control">';
                                                            foreach ($lesLieux as $leLieu) {
                                                                echo '<option';
                                                                if ($leLieu['ID_LIEU'] == $stageSelectionner['ID_LIEU']) {
                                                                    echo ' selected="selected"';
                                                                }
                                                                echo ' value="' . $leLieu['ID_LIEU'] . '">' . $leLieu['NOM_LIEU'] . ' (' . $leLieu['ADRESSE_LIEU'] . ' ' . $leLieu['CP_LIEU'] . ' ' . $leLieu['VILLE_LIEU'] . ')</option>';
                                                            }
                                                            echo '</select> <br>
</div></div></div>
<div class="col-lg-8">
    <div class="main-card mb-3 card">
        <div class="card-body">

	   <label for="prix">Couleur</label>
      <input class="form-control" name="couleur"value="' . $stageSelectionner['FOND_STAGE'] . '" autofocus="" type="color"  style="width:100px"><br>

		<label for="annee">Description </label>
    '; ?>
                                                            <textarea name="content"
                                                                      id="editor"><?php echo stripslashes($stageSelectionner['DESCRIPTION_STAGE']) ?></textarea>

                                                            <script
                                                                src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
                                                            <script>
                                                                CKEDITOR.replace('content');
                                                            </script>
                                                            <?php
                                                            echo '

		 <br><label for="prix">Image d\'illustration </label><br>	';
                                                            if ($stageSelectionner['IMAGE_STAGE'] == '') {
                                                                echo '<i>Aucune image envoyée.</i>';
                                                            } else {
                                                                echo '<img src="./images/imageStage/' . $stageSelectionner['IMAGE_STAGE'] . '" style="width:800px">';
                                                            }

                                                            echo '	<br>
		<input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.gif" /><br>


		 <br><label for="prix">Affiche </label><br>	';
                                                            if ($stageSelectionner['AFFICHE_STAGE'] == '') {
                                                                echo '<i>Aucune affiche envoyée.</i>';
                                                            } else {
                                                                echo '<img src="./images/afficheStage/' . $stageSelectionner['AFFICHE_STAGE'] . '" style="width:300px">';
                                                            }
                                                            echo '	<br>
		<input type="file" class="form-control" name="affiche" accept=".jpg,.jpeg,.png,.gif" /><br>


		 <br><label for="prix">Planning </label><br>	';
                                                            if ($stageSelectionner['PLANNING_STAGE'] == '') {
                                                                echo '<i>Aucun planning envoyé.</i>';
                                                            } else {
                                                                echo '<img src="./images/planningStage/' . $stageSelectionner['PLANNING_STAGE'] . '" style="width:600px">';
                                                            }
                                                            echo '	<br>
		<input type="file" class="form-control" name="planning" accept=".jpg,.jpeg,.png,.gif" /><br>


		<br>
    <input value="Modifier" type="submit" class="btn btn-success" id="modifierBtn" >;
                                                            
                                                            
  </div>'
 ?>


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


                                    <!-------------------------------------------------------------------- Partenaires --------------------------------------------------------------------------------->
                                    <div role="tabpanel" class="tab-pane<?php if ($onglet == 'partenaires') {
                                        echo ' active';
                                    } ?>" id="partenaires">
                                        <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
                                              action="index.php?choixTraitement=administrateur&action=LesPartenairesAssocier">
                                            <input type="hidden" name="numStage"
                                                   value="<?php echo $stageSelectionner['ID_STAGE']; ?>">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="main-card mb-3 card">
                                                            <div class="card-body">
                                                                <h4 class="card-title">Partenaires</h4>
                                                                <div class="form-row">
                                                                    <div class="col-md-2">

                                                                        <h4>Associer un partenaire au stage</h4>
                                                                        <?php
                                                                        echo '<select name="partenaire" class="form-control">';
                                                                        $partenairesDejAssocies = 0;
                                                                        $nbPartenaires = 0;
                                                                        foreach ($lesPartenairesTout as $leLieu) {
                                                                            $nbPartenaires++;
                                                                            echo '<option';

                                                                            foreach ($lesPartenaires as $lePartenaire) {
                                                                                if ($leLieu['ID_PARTENAIRES'] == $lePartenaire['ID_PARTENAIRES']) {
                                                                                    echo ' disabled="disabled"';
                                                                                    $partenairesDejAssocies++;
                                                                                }
                                                                            }
                                                                            echo ' value="' . $leLieu['ID_PARTENAIRES'] . '">' . $leLieu['NOM_PARTENAIRES'] . ' </option>';
                                                                        }
                                                                        echo '</select> <br> </div></div>	';

                                                                        ?>
                                                                        <?php if ($nbPartenaires == $partenairesDejAssocies) { ?>
                                                                            <input disabled="disabled" type="submit"
                                                                                   value="Associer"
                                                                                   style="clear:both;margin-right:50px"
                                                                                   class="btn btn-success">
                                                                            <?php
                                                                        } else { ?>
                                                                            <input type="submit" value="Associer"
                                                                                   style="clear:both;margin-right:50px"
                                                                                   class="btn btn-success">
                                                                            <?php
                                                                        } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                        </form>
                                        <hr>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h4>Partenaires déjà associés</h4>
                                                        <p>
                                                            <a href='index.php?choixTraitement=administrateur&action=ParametresStages&onglet=partenaires'
                                                               class='btn btn-info'><span
                                                                    class="glyphicon pe-7s-pen"></span> Gérer les
                                                                partenaires</a>

                                                        </p>
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Nom</th>
                                                                <th>Logo</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($lesPartenaires as $lePartenaire) {
                                                                $i++;
                                                                if ($lePartenaire['IMAGE_PARTENAIRES'] == '') {
                                                                    $lePartenaire['IMAGE_PARTENAIRES'] = 'AUCUNE.jpg';
                                                                }
                                                                echo '<tr>
						<td>' . $lePartenaire['NOM_PARTENAIRES'] . '</td>
						<td><img src="./images/imagePartenaire/' . $lePartenaire['IMAGE_PARTENAIRES'] . '" style="width:100px"></td>
						<td>';
                                                                if ($admin == 2) {
                                                                    echo '<a href="javascript:void(0);" class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment dissocier ce partenaire ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&amp;action=dissocierUnPartenaire&partenaire=' . $lePartenaire['ID_PARTENAIRES'] . '&numStage=' . $stageSelectionner['ID_STAGE'] . '\'; } else { void(0); }"><span class="pe-7s-trash"></span> Dissocier</a>';
                                                                }

                                                                echo '</td>
					 </tr>';

                                                            }

                                                            if ($i == 0) {
                                                                echo '<tr><td colspan="3"><i>Aucun partenaire associé pour l\'instant.</i></td></tr>';
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-------------------------------------------------------------------- Ateliers --------------------------------------------------------------------------------->
                                    <div role="tabpanel" class="tab-pane<?php if ($onglet == 'ateliers') {
                                        echo ' active';
                                    } ?>" id="ateliers">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="main-card mb-3 card">
                                                        <div class="card-body">
                                                            <br>


                                                            <p>
                                                                <a href="#"
                                                                   onclick="document.getElementById('ajouter_atelier').style.display='block';"
                                                                   class="btn btn-success">Ajouter un atelier</a>
                                                            </p>


                                                            <!-------- Ajouter un atelier ------------------>

                                                            <form id="ajouter_atelier" style="display:none"
                                                                  name="frmConsultFrais" method="POST"
                                                                  enctype="multipart/form-data"
                                                                  action="index.php?choixTraitement=administrateur&action=LesAteliersAjouter">
                                                                <h2>Ajouter un atelier</h2>
                                                                <input type="hidden" name="numStage"
                                                                       value="<?php echo $stageSelectionner['ID_STAGE']; ?>">

                                                                <div>
                                                                    <label></label>

                                                                    <b>Description :</b><br><textarea
                                                                        style="width:600px" class="form-control"
                                                                        name="description"></textarea>

                                                                    <b>Image :</b><input type="file" style="width:300px"
                                                                                         class="form-control"
                                                                                         name="image"/><br>

                                                                    <b>Nom :</b> <input type="text" style="width:300px"
                                                                                        class="form-control" name="nom"
                                                                                        value=""><br>

                                                                    <b>Nb max d'élèves :</b> <input type="number"
                                                                                                    style="width:300px"
                                                                                                    name="nbmax"
                                                                                                    class="form-control"
                                                                                                    value=""><br>

                                                                    <b>Atelier destiné aux :</b> <select
                                                                        style="width:300px" class="form-control"
                                                                        name="niveau">
                                                                        <option value="0">Collégiens</option>
                                                                        <option value="1">Lycéens</option>
                                                                        <option value="2">Tout</option>
                                                                    </select><br>

                                                                    <b>Groupe :</b> <select style="width:300px"
                                                                                            class="form-control"
                                                                                            name="groupe">
                                                                        <?php
                                                                        foreach ($lesGroupesAtelier as $unGroupeAtelier) {
                                                                            echo '<option value="' . $unGroupeAtelier['ID'] . '">' . $unGroupeAtelier['NOM'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><br>


                                                                    <br><input type="submit" value="Ajouter"
                                                                               style="margin-right:50px"
                                                                               class="btn btn-success">
                                                                </div>
                                                            </form>


                                                            <?php
                                                            $niveauAteliers = array(
                                                                'collégiens',
                                                                'lycéens',
                                                                'tout'
                                                            );
                                                            $i = 0;
                                                            $groupePrecedent = '';

                                                            // On parcours les ateliers
                                                            foreach ($lesAteliers as $unAtelier) {

                                                                // Si c'est un nouveau groupe d'atelier
                                                                if ($groupePrecedent != $unAtelier['GROUPE_ATELIER']) {

                                                                    // On écrit le titre
                                                                    echo '<h2>';
                                                                    foreach ($lesGroupesAtelier as $unGroupeAtelier) {
                                                                        if ($unGroupeAtelier['ID'] == $unAtelier['GROUPE_ATELIER']) {
                                                                            echo $unGroupeAtelier['NOM'];
                                                                        }
                                                                    }
                                                                    echo '</h2>';

                                                                    // On le met à jour
                                                                    $groupePrecedent = $unAtelier['GROUPE_ATELIER'];
                                                                }

                                                                $numeroAtelier = rand();
                                                                echo '<form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=LesAteliersModifier">

	<input type="hidden" name="numStage" value="' . $stageSelectionner['ID_STAGE'] . '">
	<input type="hidden" name="num" value="' . $unAtelier['ID_ATELIERS'] . '">


	<label for="atelier_' . $numeroAtelier . '" style="width:1000px;cursor:pointer"></label>

		<div style="float:right">
			<b>Description :</b><br> <textarea style="width:600px" class="form-control" name="description">' . stripslashes($unAtelier['DESCRIPTIF_ATELIERS']) . '</textarea>
		</div>
		<b>Image :</b><img src="./images/ateliers/' . $unAtelier['IMAGE_ATELIERS'] . '" style="width:100px;margin:10px">
		<input type="file" style="width:300px" class="form-control" name="image"><br>

		<b>Nom :</b> <input type="text" style="width:300px" class="form-control" name="nom" value="' . stripslashes($unAtelier['NOM_ATELIERS']) . '"><br>

		<b>Nb max d\'élèves :</b> <input type="number" style="width:300px" name="nbmax" class="form-control" value="' . $unAtelier['NBMAX_ATELIERS'] . '"><br>

		<b>Atelier destiné aux :</b> <select  style="width:300px" class="form-control" name="niveau">
			<option value="0"';
                                                                if ($unAtelier['NIVEAU_ATELIER'] == '0') {
                                                                    echo ' selected="selected"';
                                                                }
                                                                echo '>Collégiens</option>
			<option value="1"';
                                                                if ($unAtelier['NIVEAU_ATELIER'] == '1') {
                                                                    echo ' selected="selected"';
                                                                }
                                                                echo '>Lycéens</option>
            <option value="2"';
                                                                if ($unAtelier['NIVEAU_ATELIER'] == '2') {
                                                                    echo ' selected="selected"';
                                                                }
                                                                echo '>Tout</option>
		</select><br>

         <b>Groupe :</b> <select  style="width:300px" class="form-control" name="groupe">';
                                                                foreach ($lesGroupesAtelier as $unGroupeAtelier) {
                                                                    echo '<option value="' . $unGroupeAtelier['ID'] . '"';

                                                                    if ($unAtelier['GROUPE_ATELIER'] == $unGroupeAtelier['ID']) {
                                                                        echo ' selected="selected"';
                                                                    }
                                                                    echo '>' . $unGroupeAtelier['NOM'] . '</option>';
                                                                }
                                                                echo '</select><br>


	<br><input type="submit" value="Modifier" style="clear:both;margin-right:50px" class="btn btn-success">';
                                                                if ($admin == 2) {
                                                                    echo '<a href="javascript:void(0);" class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment supprimer cet atelier ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerUnAtelier&num=' . $unAtelier['ID_ATELIERS'] . '&numStage=' . $stageSelectionner['ID_STAGE'] . '\'; } else { void(0); }">Supprimer</a>';
                                                                }
                                                                echo '

</form></div></div></div></div>
  <hr>
  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="main-card mb-3 card">
                                              <div class="card-body">


	<h4>Inscrits (' . count($inscritsAtelier[$unAtelier['ID_ATELIERS']]) . ')</h4>
	<table class="table" >
	<thead>
	<tr>
	<th>Nom</th>
	<th>Prenom</th>
    <th>Actions</th>
	</tr>
	</thead>
	<tbody>';

                                                                $iiiiii = 0;
                                                                foreach ($inscritsAtelier[$unAtelier['ID_ATELIERS']] as $unInscrit) {
                                                                    $iiiiii++;
                                                                    echo '<tr>
            <td>' . $iiiiii . '</td>
            <td>' . $unInscrit['NOM_ELEVE_STAGE'] . '</td>
            <td>' . $unInscrit['PRENOM_ELEVE_STAGE'] . '</td>
            <td><a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="if(confirm(\'Voulez-vous vraiment désinscrire cet élève ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=desinscrireAtelier&numAtelier=' . $unAtelier['ID_ATELIERS'] . '&numEleve=' . $unInscrit['ID_INSCRIPTIONS'] . '&numStage=' . $stageSelectionner['ID_STAGE'] . '\'; } else { void(0); }">Désinscrire</a></td>
        </tr>';
                                                                }

                                                                echo '</tbody></table><div style="clear:both"></div>';
                                                                $i++;
                                                            }

                                                            // Si y'a aucun atelier
                                                            if ($i == 0) {
                                                                echo '<div class="alert alert-danger">Aucun atelier programmé pour ce stage.</div>';
                                                            }
                                                            ?>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-------------------------------------------------------------------- Inscriptions --------------------------------------------------------------------------------->
                                    <div role="tabpanel" class="tab-pane<?php if ($onglet == 'inscriptions') {
                                        echo ' active';
                                    } ?>" id="inscriptions">


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Inscriptions</h4>
                                                        <br><a
                                                            href="index.php?choixTraitement=administrateur&action=importerEleveStageNouveauVue&id_stage=<?php echo $stageSelectionner['ID_STAGE']; ?>"
                                                            class="btn btn-success"><span
                                                                class="glyphicon glyphicon-plus"></span> Importer un
                                                            élève</a>
                                                        <a href="index.php?choixTraitement=administrateur&action=ElevesStageCSV&num=<?php echo $stageSelectionner['ID_STAGE']; ?>"
                                                           class="btn btn-info"><span
                                                                class="glyphicon glyphicon-download-alt"></span>
                                                            Exporter sur Excel</a><br><br>
                                                        <p><b><?php echo $nombreInscriptions; ?></b> inscription(s).
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <table style="width: 100%;" id="example"
                                                               class="table table-hover table-striped table-bordered"
                                                               id="tableau_inscriptions">
                                                            <thead>
                                                            <tr>
                                                                <th colspan="3">Actions</th>

                                                                <th>N°</th>
                                                                <!--
                                                                <th>Date</th>
                                                                -->
                                                                <th>Validé</th>

                                                                <th>Photo</th>
                                                                <th>Nom</th>
                                                                <th>Prénom</th>
                                                                <?php
                                                                foreach ($lesGroupesAtelier as $unGroupeAtelier) {
                                                                    echo '<th>Atelier <i>' . $unGroupeAtelier['NOM'] . '</i></th>';
                                                                }
                                                                ?>
                                                                <!--
                                                                <th>Sexe</th>
                                                                <th>Date de naissance</th>-->
                                                                <th>Etablissement</th>
                                                                <th>Groupe</th>
                                                                <th>Classe</th>
                                                                <th>Filière</th>

                                                                <th>Association</th>
                                                                <th>Tél parents</th>
                                                                <th>Email parents</th>
                                                                <!--<th>Tél enfant</th>
                                                                <th>Email enfant</th>
                                                                <th>Adresse</th>
                                                                <th>Code postal</th>
                                                                <th>Ville</th>
                                                                <th>Documents</th>-->

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $ii = 0;
                                                            foreach ($lesInscriptions as $lInscription) {
                                                                $ii++;

                                                                // On récupère les informations
                                                                $classe = '';
                                                                foreach ($lesClasses as $uneClasse) {
                                                                    if ($uneClasse['ID'] == $lInscription['CLASSE_ELEVE_STAGE']) {
                                                                        $classe = $uneClasse['NOM'];
                                                                    }
                                                                }

                                                                $filiere = '';
                                                                foreach ($lesfilieres as $uneFiliere) {
                                                                    if ($uneFiliere['ID'] == $lInscription['FILIERE_ELEVE_STAGE']) {
                                                                        $filiere = $uneFiliere['NOM'];
                                                                    }
                                                                }

                                                                $etab = '';
                                                                foreach ($lesEtablissements as $unEtab) {
                                                                    if ($unEtab['ID'] == $lInscription['ETABLISSEMENT_ELEVE_STAGE']) {
                                                                        $etab = $unEtab['NOM'];
                                                                    }
                                                                }

                                                                if ($lInscription['PHOTO_ELEVE_STAGE'] == '') {
                                                                    $lInscription['PHOTO_ELEVE_STAGE'] = 'AUCUNE.jpg';
                                                                }

                                                                echo '<tr';
                                                                if ($lInscription['VALIDE'] == 0) {
                                                                    echo ' style="background:#EEE;color:gray"';
                                                                }
                                                                echo '>

        <td><a href="index.php?choixTraitement=administrateur&action=ModifInscriptionStage&lInscription=' . $lInscription['ID_INSCRIPTIONS'] . '&leStage=' . $stageSelectionner['ID_STAGE'] . '" class="btn btn-info btn-sm"><span class="glyphicon pe-7s-pen"></span> Modifier</a></td>

		<td><a href="javascript:void(0)" onclick="document.getElementById(\'import_' . $lInscription['ID_INSCRIPTIONS'] . '\').style.display=\'block\';this.style.display=\'none\';" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-refresh"></span> Importer</a><br>
		<div id="import_' . $lInscription['ID_INSCRIPTIONS'] . '" style="display:none">
			<form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=importerEleveStage">
				<input type="hidden" name="num" value="' . $stageSelectionner['ID_STAGE'] . '">
				<input type="hidden" name="id_inscription" value="' . $lInscription['ID_ELEVE_STAGE'] . '">
				<select name="id_ancien">
					<option selected="selected" disabled="disabled">Choisir</option>';
                                                                foreach ($lesEleves as $unEleve) {
                                                                    echo '<option value="' . $unEleve['ID_ELEVE'] . '">' . $unEleve['NOM'] . ' ' . $unEleve['PRENOM'] . '</option>';
                                                                }
                                                                echo '</select><input type="submit" value="OK">
			</form>
		</div>
		</td>
        <td>';

                                                                // on regarde si jamais absent
                                                                $bool = true;
                                                                foreach ($participationsofImpaye as $participation) {
                                                                    if ($participation['ID_INSCRIPTIONS'] == $lInscription['ID_INSCRIPTIONS']) {
                                                                        $bool = false;
                                                                    }

                                                                }

                                                                // Bouton de suppression
                                                                if ($admin == 2 || $bool) {
                                                                    echo '<a href="javascript:void(0)" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette inscription ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=suprInscriptionStage&num=' . $lInscription['ID_ELEVE_STAGE'] . '&numStage=' . $stageSelectionner['ID_STAGE'] . '&numInscription=' . $lInscription['ID_INSCRIPTIONS'] . '\'; } else { void(0); }" class="btn btn-danger btn-sm"><span class ="glyphicon glyphicon-trash"></span> Supprimer</a>';
                                                                }

                                                                echo '</td>




        <td>' . $ii . '</td>
		<!--<td>';

                                                                // Date d'inscription
                                                                if (strtotime($lInscription['DATE_INSCRIPTIONS']) > 0) {
                                                                    echo '<input type="text" value="' . date("d/m/Y H:i", strtotime($lInscription['DATE_INSCRIPTIONS'])) . '" style="width:100px" disabled="disabled">';

                                                                }
                                                                echo '</td>-->

        <td>
            <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=changerValiderEleve">
                <input type="hidden" name="num" value="' . $stageSelectionner['ID_STAGE'] . '">
				<input type="hidden" name="id_inscription" value="' . $lInscription['ID_INSCRIPTIONS'] . '">
                <input type="checkbox" onchange="this.form.submit()" name="valide"';
                                                                if ($lInscription['VALIDE']) {
                                                                    echo ' checked="checked"';
                                                                }
                                                                echo '></form>
        </td>

        <td><img src="photosEleves/' . $lInscription['PHOTO_ELEVE_STAGE'] . '" style="width:30px" class="fancybox"></td>
		<td><b><a href="index.php?choixTraitement=administrateur&action=LesEleves&num=' . $lInscription['ID_ELEVE_STAGE'] . '">' . stripslashes($lInscription['NOM_ELEVE_STAGE']) . '</a></b></td>
		<td><b><a href="index.php?choixTraitement=administrateur&action=LesEleves&num=' . $lInscription['ID_ELEVE_STAGE'] . '">' . stripslashes($lInscription['PRENOM_ELEVE_STAGE']) . '</a></b></td>

		';

                                                                $niveauAteliers = array(
                                                                    'collégiens',
                                                                    'lycéens',
                                                                    'tout le monde'
                                                                );

                                                                // On parcours les groupres d'atelier
                                                                foreach ($lesGroupesAtelier as $unGroupeAtelier) {
                                                                    echo '<td>
		<form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=changerAtelierEleve">
				<input type="hidden" name="num" value="' . $stageSelectionner['ID_STAGE'] . '">
				<input type="hidden" name="id_inscription" value="' . $lInscription['ID_INSCRIPTIONS'] . '">

				<select name="id_atelier" onchange="this.form.submit()">';
                                                                    $id_ancien_atelier = 0;
                                                                    // On parcours les ateliers de ce groupe
                                                                    foreach ($lesAteliers as $unAtelier) {

                                                                        // Si l'atelier est dans ce groupe
                                                                        if ($unGroupeAtelier['ID'] == $unAtelier['GROUPE_ATELIER']) {

                                                                            // Si l'é
                                                                            //if($unAtelier['GROUPE_ATELIER'] == 0 AND $lInscription['CLASSE_ELEVE_STAGE'] <= 53) {
                                                                            echo '<option value="' . $unAtelier['ID_ATELIERS'] . '"';

                                                                            // On parcours les inscrits à cet atelier
                                                                            foreach ($inscritsAtelier[$unAtelier['ID_ATELIERS']] as $unInscritAtelier) {

                                                                                // Si l'élève est inscrit à cet atelier
                                                                                if ($lInscription['ID_INSCRIPTIONS'] == $unInscritAtelier['ID_INSCRIPTION']) {

                                                                                    // On séléctionne cet atelier
                                                                                    echo ' selected="selected"';

                                                                                    // On stocke son ID
                                                                                    $id_ancien_atelier = $unInscritAtelier['ID_ATELIER'];

                                                                                    //}

                                                                                }
                                                                            }
                                                                            echo '>' . stripslashes($unAtelier['NOM_ATELIERS']) . ' (' . $niveauAteliers[$unAtelier['NIVEAU_ATELIER']] . ')</option>';
                                                                        }
                                                                    }

                                                                    // Aucun atelier
                                                                    echo '<option value="" disabled="disabled"';
                                                                    // SI l'élève n'est inscrit à aucun atelier
                                                                    if ($id_ancien_atelier == 0) {
                                                                        echo ' selected="selected"';
                                                                    }
                                                                    echo '>Aucun</option>';

                                                                    echo '</select>
            <input type="hidden" name="id_ancien_atelier" value="' . $id_ancien_atelier . '">
            </form></td>';
                                                                }

                                                                echo '
		<!--

        <td>' . $lInscription['SEXE_ELEVE_STAGE'] . '</td>
		<td><input type="text" value="' . date("d-m-Y", strtotime($lInscription['DDN_ELEVE_STAGE'])) . '" style="width:100px" disabled="disabled"></td>
		-->
        <td>' . $etab . '</td>

        <td>

        <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=ajouterEleveGroupe" >
            <input type="hidden" name="num" value="' . $stageSelectionner['ID_STAGE'] . '">
            <input type="hidden" name="id_inscription"  value="' . $lInscription['ID_INSCRIPTIONS'] . '">
            <select name="id_groupe" onchange="this.form.submit()">
                <option selected="selected" disabled="disabled">Choisir un groupe</option>';

                                                                foreach ($lesGroupes as $unGroupe) {

                                                                    echo '<option value="' . $unGroupe['ID_GROUPE'] . '"';
                                                                    // Si c'est le groupe de l'élève
                                                                    if ($unGroupe['ID_GROUPE'] == $lInscription['ID_GROUPE']) {
                                                                        echo ' selected="selected"';
                                                                    }

                                                                    echo '>' . stripslashes($unGroupe['NOM_GROUPE']) . '</option>';
                                                                }
                                                                echo '</select></form>

        </td>

		<td>' . $classe . '</td>
		<td>' . $filiere . '</td>
		<td>' . stripslashes($lInscription['ASSOCIATION_ELEVE_STAGE']) . '</td>
		<td><a href="tel:' . $lInscription['TELEPHONE_PARENTS_ELEVE_STAGE'] . '">' . $lInscription['TELEPHONE_PARENTS_ELEVE_STAGE'] . '</a></td>
		<td><a href="mailto:' . stripslashes($lInscription['EMAIL_PARENTS_ELEVE_STAGE']) . '">' . stripslashes($lInscription['EMAIL_PARENTS_ELEVE_STAGE']) . '</a></td>
		<!--
        <td><a href="tel:' . $lInscription['TELEPHONE_ELEVE_ELEVE_STAGE'] . '">' . $lInscription['TELEPHONE_ELEVE_ELEVE_STAGE'] . '</a></td>
		<td><a href="mailto:' . stripslashes($lInscription['EMAIL_ELEVE_ELEVE_STAGE']) . '">' . stripslashes($lInscription['EMAIL_ELEVE_ELEVE_STAGE']) . '</a></td>
		<td><input type="text" value="' . stripslashes($lInscription['ADRESSE_ELEVE_STAGE']) . '" style="width:200px" disabled="disabled"></td>
		<td>' . $lInscription['CP_ELEVE_STAGE'] . '</td>
		<td>' . stripslashes($lInscription['VILLE_ELEVE_STAGE']) . '</td>
		<td>' . $lInscription['DOCUMENT1_ELEVE_STAGE'] . '</td>-->

		<!--
        <td><a href="javascript:alert(\'Infos techniques :\n\nAdresse IP : ' . addslashes($lInscription['IP_INSCRIPTIONS']) . '\n\nSystème : ' . addslashes($lInscription['USER_AGENT_INSCRIPTIONS']) . '\n\nOrigine : ' . addslashes($lInscription['ORIGINE_INSCRIPTIONS']) . '\');" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-cog"></span> Technique</a></td>
		-->


	</tr>
	';
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--
                                        Fait un long chargement
                                        <script>
                                            $(document).ready(function () {
                                                $('#tableau_inscriptions').DataTable({
                                                    "paging": false,
                                                    "filter": false
                                                });
                                            });
                                        </script>-->
                                    </div>


                                    <!-------------------------------------------------------------------- Groupes --------------------------------------------------------------------------------->
                                    <div role="tabpanel" class="tab-pane<?php if ($onglet == 'groupes') {
                                        echo ' active';
                                    } ?>" id="groupes">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <center>
                                                            <p>
                                                                <a href="index.php?choixTraitement=administrateur&action=ajouterGroupe&num=<?php echo $stageSelectionner['ID_STAGE']; ?>"
                                                                   class="btn btn-info">
                                                                    <span class="glyphicon glyphicon-plus"></span> Créer
                                                                    un groupe
                                                                </a>
                                                                <a href="javascript:window.print()"
                                                                   class="btn btn-secondary">
                                                                    <span class="glyphicon pe-7s-print"></span> Imprimer
                                                                </a>
                                                            </p>
                                                        </center>
                                                        <h4>Ajouter un élève dans un groupe</h4>


                                                        <form name="frmConsultFrais" method="POST"
                                                              enctype="multipart/form-data"
                                                              action="index.php?choixTraitement=administrateur&action=ajouterEleveGroupe">
                                                            <input type="hidden" name="num"
                                                                   value="<?php echo $stageSelectionner['ID_STAGE']; ?>">

                                                            <select name="id_inscription" class="form-control"
                                                                    data-live-search="true" style="max-width:300px;">
                                                                <option selected="selected" disabled="disabled">Choisir
                                                                    un élève
                                                                </option>
                                                                <?php
                                                                foreach ($lesInscriptions as $lInscription) {
                                                                    echo '<option value="' . $lInscription['ID_INSCRIPTIONS'] . '"';
                                                                    // Si l'élève n'est pas déjà inscrit dans un groupe
                                                                    if ($lInscription['ID_GROUPE'] != 0) {
                                                                        echo ' disabled="disabled"';
                                                                    }
                                                                    echo '>' . $lInscription['NOM_ELEVE_STAGE'] . ' ' . $lInscription['PRENOM_ELEVE_STAGE'] . '</option>';
                                                                }

                                                                ?>
                                                            </select>
                                                            <br/>
                                                            <select name="id_groupe" class="form-control"
                                                                    data-live-search="true" style="max-width:300px;">
                                                                <option selected="selected" disabled="disabled">Choisir
                                                                    un groupe
                                                                </option>
                                                                <?php
                                                                foreach ($lesGroupes as $unGroupe) {
                                                                    echo '<option value="' . $unGroupe['ID_GROUPE'] . '">' . stripslashes($unGroupe['NOM_GROUPE']) . '</option>';
                                                                }

                                                                ?>

                                                            </select>
                                                            <br/>
                                                            <input type="submit" value="Ajouter"
                                                                   class="btn btn-success">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <?php
                                            foreach ($lesGroupes as $unGroupe) {
                                                echo '
  <div class="col-lg-6">
      <div class="main-card mb-3 card">
          <div class="card-body">
  <table class="table">
			<thead>
			<tr>
        <th colspan="4" style="text-align:center;background:#99CCFF;padding:2px"><big><big>' . stripslashes($unGroupe['NOM_GROUPE']) . '</big></big><br>Nombre d\'élèves max : ' . $unGroupe['NBMAX_GROUPE'] . ' - Salle : ' . stripslashes($unGroupe['SALLES_GROUPE']) . '</th>
      </tr>
			<tr>
			<th style="text-align:center;background:#99CCFF;padding:2px" colspan="2">Nom</th>
			<th style="text-align:center;background:#99CCFF;padding:2px">Prénom</th>
			<th style="text-align:center;background:#99CCFF;padding:2px">Classe</th>
			</tr>
		</thead>
    <tbody>
		<form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=supprimerElevesDuGroupe">
			<input type="hidden" name="numStage" value="' . $stageSelectionner['ID_STAGE'] . '">
			<input type="hidden" name="num" value="' . $unGroupe['ID_GROUPE'] . '">';

                                                $lesElevesDuGroupe = $pdo->getElevesDuGroupe($unGroupe['ID_GROUPE']);

                                                $compteur = 0;
                                                foreach ($lesElevesDuGroupe as $unEleveDuGroupe) {

                                                    // On récupére la classe
                                                    $classe = '';
                                                    foreach ($lesClasses as $uneClasse) {
                                                        if ($uneClasse['ID'] == $unEleveDuGroupe['CLASSE_ELEVE_STAGE']) {
                                                            $classe = $uneClasse['NOM'];
                                                        }
                                                    }

                                                    echo '<tr>
			<td><input type="checkbox" name="eleves[]" value="' . $unEleveDuGroupe['ID_INSCRIPTIONS'] . '"></td>
			<td>' . $unEleveDuGroupe['NOM_ELEVE_STAGE'] . '</td>
			<td>' . $unEleveDuGroupe['PRENOM_ELEVE_STAGE'] . '</td>
			<td>' . $classe . '</td>
		</tr>';
                                                    $compteur++;

                                                }
                                                if ($compteur < $unGroupe['NBMAX_GROUPE']) {
                                                    $couleur = 'green';
                                                }
                                                if ($compteur == $unGroupe['NBMAX_GROUPE']) {
                                                    $couleur = 'orange';
                                                }
                                                if ($compteur > $unGroupe['NBMAX_GROUPE']) {
                                                    $couleur = 'red';
                                                }

                                                echo '<tr><td colspan="4"><b><span style="color:' . $couleur . '">' . $compteur . ' inscrit(s) sur un total de ' . $unGroupe['NBMAX_GROUPE'] . ' maximum.</span></b></td></tr>';

                                                echo '
	<tr>
		<td colspan="4">';
                                                if ($admin == 2) {
                                                    echo '<input type="submit" class="btn btn-danger" style="font-size:10px" value="Enlever les élèves séléctionnés du groupe">';
                                                }
                                                echo '</td></form></tbody></table>';
                                                if ($admin == 2) {
                                                    echo '<a href="index.php?choixTraitement=administrateur&action=supprimerUnGroupe&num=' . $unGroupe['ID_GROUPE'] . '&numStage=' . $stageSelectionner['ID_STAGE'] . '" class="btn btn-danger" style="font-size:10px">Supprimer le groupe</a>';
                                                }
                                                echo '</td>
	</tr>
  </tbody>
</table>
</div>
</div>
</div>
<br>';
                                            }
                                            ?>


                                        </div>
                                    </div>


                                    <!-------------------------------------------------------------------- Impressions --------------------------------------------------------------------------------->
                                    <div role="tabpanel" class="tab-pane<?php if ($onglet == 'impressions') {
                                        echo ' active';
                                    } ?>" id="impressions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">

                                                        <h4 class="card-title">Documents</h4>
                                                        <br><br>
                                                        <center>
                                                            <p>
                                                                <a href="index.php?choixTraitement=administrateur&action=imprimerListeEleves&num=<?php echo $stageSelectionner['ID_STAGE']; ?>"
                                                                   class="btn btn-info btn-lg" target="_blank"><span
                                                                        class="glyphicon glyphicon-list-alt"></span>
                                                                    Imprimer la liste des élèves</a>
                                                                <a href="index.php?choixTraitement=administrateur&action=imprimerListeGroupes&num=<?php echo $stageSelectionner['ID_STAGE']; ?>"
                                                                   class="btn btn-info btn-lg" target="_blank"><span
                                                                        class="glyphicon glyphicon-tag"></span> Imprimer
                                                                    la liste des groupes</a>
                                                                <a href="index.php?choixTraitement=administrateur&action=bilan&num=<?php echo $stageSelectionner['ID_STAGE']; ?>"
                                                                   class="btn btn-info btn-lg" target="_blank"><span
                                                                        class="glyphicon glyphicon-file"></span> Ouvrir
                                                                    le bilan</a>
                                                            </p></center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Fiches de présences</h4>
                                                        <form name="frmConsultFrais" method="POST"
                                                              enctype="multipart/form-data"
                                                              action="index.php?choixTraitement=administrateur&action=imprimerFichePresences">
                                                            <div class="form-group">
                                                                <input type="hidden" name="num"
                                                                       value="<?php echo $stageSelectionner['ID_STAGE']; ?>">
                                                                <label>Date et période :</label><br>
                                                                <input type="date" name="periode" class="form-control"
                                                                       style="max-width:300px;"><br>
                                                                <input type="submit" class="btn btn-success"
                                                                       value="Imprimer">
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Fiches de groupes pour sortie</h4>
                                                        <form name="frmConsultFrais" method="POST"
                                                              enctype="multipart/form-data"
                                                              action="index.php?choixTraitement=administrateur&action=imprimerFicheGroupesSortie">
                                                            <div class="form-group">
                                                                <input type="hidden" name="idStage"
                                                                       value="<?php echo $stageSelectionner['ID_STAGE']; ?>">
                                                                <label>Atelier concerné :</label><br>
                                                                <select name="idAtelier" class="form-control"
                                                                        style="max-width:300px;">
                                                                    <option selected="selected" disabled="disabled">
                                                                        Choisir
                                                                    </option>
                                                                    <?php foreach ($lesAteliers as $unAtelier) {
                                                                        echo '<option value="' . $unAtelier['ID_ATELIERS'] . '">' . stripslashes($unAtelier['NOM_ATELIERS']) . '</option>';
                                                                    } ?></select><br>
                                                                <label>Nombre d'élèves max par groupe :</label><br>
                                                                <input type="number" name="nb" class="form-control"
                                                                       style="max-width:300px;"><br>
                                                                <input type="submit" class="btn btn-success"
                                                                       value="Générer">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-------------------------------------------------------------------- Intervenants --------------------------------------------------------------------------------->
                                    <div role="tabpanel" class="tab-pane<?php if ($onglet == 'intervenants') {
                                        echo ' active';
                                    } ?>" id="intervenants">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <form name="frmConsultFrais" method="POST"
                                                              enctype="multipart/form-data"
                                                              action="index.php?choixTraitement=administrateur&action=associerIntervenantStage">
                                                            <input type="hidden" name="numStage"
                                                                   value="<?php echo $stageSelectionner['ID_STAGE']; ?>"/>
                                                            <fieldset>
                                                                <h4 class="card-title">Associer un intervenant</h4>
                                                                <div class="form-group">
                                                                    <label for="intervenat">Intervenant :</label>
                                                                    <select class="form-control" name="intervenant"
                                                                            style="max-width:300px;">
                                                                        <?php
                                                                        $nbIntervenants = 0;
                                                                        $intervenatsDejAssocies = 0;
                                                                        foreach ($lesIntervenantsTout as $unIntervenant) {
                                                                            $nbIntervenants++;
                                                                            echo '<option value="' . $unIntervenant['ID_INTERVENANT'] . '"';
                                                                            foreach ($lesIntervenants as $unIntervenantStage) {
                                                                                // Si l'intervenant a déjà été associé
                                                                                if ($unIntervenantStage['ID_INTERVENANT'] == $unIntervenant['ID_INTERVENANT']) {
                                                                                    echo ' disabled';
                                                                                    $intervenatsDejAssocies++;
                                                                                }
                                                                            }
                                                                            echo '>' . $unIntervenant['NOM'] . ' ' . $unIntervenant['PRENOM'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><br>
                                                                    <?php if ($nbIntervenants == $intervenatsDejAssocies) { ?>
                                                                        <input disabled="disabled" type="submit"
                                                                               value="Associer"
                                                                               class="btn btn-success"/>
                                                                        <?php
                                                                    } else { ?>
                                                                        <input type="submit" value="Associer"
                                                                               class="btn btn-success"/>
                                                                        <?php
                                                                    } ?>


                                                                </div>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form name="frmHorairesIntervStage" method="POST" enctype="multipart/form-data"
                                              action="index.php?choixTraitement=administrateur&action=ajoutIntervenantHoraireStage">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="main-card mb-3 card">
                                                        <div class="card-body">
                                                            <h4>Intervenants déjà associés</h4>
                                                            <p>
                                                                <a href='index.php?choixTraitement=administrateur&action=ParametresStages&onglet=intervenants'
                                                                   class='btn btn-info'><span
                                                                        class="glyphicon pe-7s-pen"></span> Gérer les
                                                                    intervenants</a>

                                                            </p>
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th style="display:none;">R</th>
                                                                    <th style="display:none;">R</th>
                                                                    <th>Nom</th>
                                                                    <th>Prénom</th>
                                                                    <th>Email</th>
                                                                    <th>Téléphone</th>
                                                                    <th>Heures</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $lesIntervenants = $pdo->recupIntervenantsStage($num);
                                                                foreach ($lesIntervenants as $unIntervenant) {
                                                                    echo '<tr>

  <td style="display:none;"><label for="numStage"></label><input type="number" name="numStage" value="' . $stageSelectionner["ID_STAGE"] . '"></td>
  <td style="display:none;"><label for="idIntervenant[]"></label><input type="number" name="idIntervenant[]" value="' . $unIntervenant['ID_INTERVENANT'] . '"></td>
	<td><a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant['ID_INTERVENANT'] . '">' . $unIntervenant['NOM_INTERVENANT'] . '</a></td>
	<td>' . $unIntervenant['PRENOM_INTERVENANT'] . '</td>
	<td>' . $unIntervenant['EMAIL_INTERVENANT'] . '</td>
	<td>' . $unIntervenant['TEL_INTERVENANT'] . '</td>
	<td> ';
                                                                    if ($admin != 3) {
                                                                        echo ' <label for="heures[]">';
                                                                        echo '<input name="heures[]" style="width:70px;" class="form-control" type="text" value="' . $unIntervenant["HEURES"] . '" /></td>';
                                                                    }

                                                                    if ($admin == 2) {
                                                                        echo '<td><a href="javascript:void(0);" class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment dissocier cet intervenant ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&amp;action=dissocierIntervenant&num=' . $unIntervenant['ID_INTERVENANT'] . '&numStage=' . $stageSelectionner['ID_STAGE'] . '\'; } else { void(0); }"><span class="glyphicon glyphicon-trash">Dissocier</span> </a></td>';
                                                                    }


                                                                    echo '
	</tr>';
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                            <input type="submit" class="btn btn-primary"
                                                                   value="Soumettre"/>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!----  </div> -->
<!-- notes------------------------------------------------------------------------------------------- -->
<div role="tabpanel" class="tab-pane<?php if ($onglet == 'notes') { echo ' active'; } ?>" id="notes">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <form method="POST" action="index.php?choixTraitement=administrateur&action=setNotesStageRevision&unStage=<?php echo $stageSelectionner['ID_STAGE']; ?>">
                                                        <div class="mt-3">
                                                            <h4 class="card-title">Notes globales du stage</h4>
                                                            <textarea name="notes" id="content"><?php echo html_entity_decode(stripslashes($stageSelectionner['NOTES'])); ?></textarea>
                                                            <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
                                                            <script>
                                                                CKEDITOR.replace('content', {
                                                                    allowedContent: true,
                                                                    removePlugins: 'sourcearea'
                                                                });
                                                            </script>
                                                            <input type="submit" value="Envoyer" class="btn btn-primary mt-3">
                                                        </div>
                                                        
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-------------------------------------------------------------------- Reglements --------------------------------------------------------------------------------->
                                    <div role="tabpanel" class="tab-pane <?php if ($onglet == 'reglements') {
                                        echo 'active';
                                    } ?>" id="reglements">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <form name="frmConsultFrais" method="POST"
                                                              enctype="multipart/form-data"
                                                              action="index.php?choixTraitement=administrateur&action=AjouterReglementStage">
                                                            <h4 class="card-title">Règlements</h4>
                                                            <input type="hidden" name="numStage"
                                                                   value="<?php echo $stageSelectionner['ID_STAGE']; ?>">
                                                            <label for="select-payement-eleves">
                                                            </label><select class="form-control" data-live-search="true"
                                                                                                                name="eleve" id="eleve">
                                                                <?php
                                                                foreach ($lesInscriptionsNonPayees as $uneInscription) {
                                                                    echo '<option value="' . $uneInscription['ID_INSCRIPTIONS'] . '">' . $uneInscription['NOM_ELEVE_STAGE'] . ' ' . $uneInscription['PRENOM_ELEVE_STAGE'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                            <br><input value="Ajouter un reglement" type="submit"
                                                                       class="btn btn-primary" id="button_add">
                                                            <br>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-lg-8 h-20">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <p>
                                                            <h4 class="card-title">Bordereau</h4>
                                                            <input type="hidden" name="stage" id="stage" value="<?=$num?>">
                                                            <div class="form-row">
                                                                <div class="col-md-3">
                                                                    <div class="position-relative form-group">
                                                                        <label for="dateDebut" class="">Date de début</label>
                                                                        <input name="dateDebut" id="dateDebut" placeholder="Date de début" type="date" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="position-relative form-group">
                                                                        <label for="dateFin" class="">Date de fin</label>
                                                                        <input name="dateFin" id="dateFin" placeholder="Date de fin" type="date" value="<?=$stageSelectionner['DATE_FIN_INSCRIT_STAGE']?>" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="position-relative form-group">
                                                                        <label for="type" class="">Types</label>
                                                                        <select name="type" id="type" class="form-control">
                                                                            <option value="-1">Tous</option>
                                                                            <?php
                                                                            foreach ($lesTypesReglements as $valeur) {
                                                                                echo '<option id="' . $valeur['NOM'] . '" value="' . $valeur['ID'] . '" name="type">' . $valeur['NOM'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button class="mt-2 btn btn-primary">Générer le bordereau</button>
                                                        </form>
                                                        <br>

                                                        <script>
                                                            function validateForm() {
                                                                const dateDebutInput = document.getElementById('dateDebut');
                                                                const dateFinInput = document.getElementById('dateFin');
                                                                const dateDebut = new Date(dateDebutInput.value);
                                                                const dateFin = new Date(dateFinInput.value);

                                                                // Vérification que les deux dates sont saisies
                                                                if (!dateDebutInput.value || !dateFinInput.value) {
                                                                    alert('Veuillez saisir les deux dates.');
                                                                    return false;
                                                                }

                                                                // Vérification que la date de fin n'est pas antérieure à la date de début
                                                                if (dateFin < dateDebut) {
                                                                    alert('La date de fin ne peut pas être antérieure à la date de début.');
                                                                    return false;
                                                                }

                                                                return true;
                                                            }
                                                        </script>

                                                        <div class="mb-3 progress-bar-animated-alt progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                 aria-valuenow="<?php echo $nbPayes; ?>"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="<?php echo $nombreInscriptions ?>"
                                                                 style="width: <?php echo round(($nombreInscriptionsPayees / $nombreInscriptions) * 100); ?>%;">
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <?php echo round(($nombreInscriptionsPayees / $nombreInscriptions) * 100); ?> %
                                                            de payés (<?php echo $nombreInscriptionsPayees . ' / ' . $nombreInscriptions; ?>)
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 h-20">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h4>Impayés</h4>
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Nom</th>
                                                                <th>Prénom</th>
                                                                <th>Nb Présences</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            foreach ($lesInscriptionsNonPayees as $uneInscription) {

                                                                    echo '<tr>
        <td>' . $uneInscription['NOM_ELEVE_STAGE'] . '</td>
        <td>' . $uneInscription['PRENOM_ELEVE_STAGE'] . '</td>';
                                                                    foreach ($participationsofImpaye as $participation) {
                                                                        if ($participation['ID_INSCRIPTIONS'] == $uneInscription['ID_INSCRIPTIONS']) {
                                                                            echo ' <td>' . $participation['nbP'] . '</td>';
                                                                        }

                                                                    }


                                                                    echo ' </tr>';
                                                            }
                                                            echo '<tr><td colspan="6"><i>' . $nombreInscriptionsNonPayees . ' impayé(s) sur ' . $nombreInscriptions . ' inscription(s).</i></tr>';

                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">


                                                        <h4>Payés</h4>
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Nom Prénom</th>
                                                                <th>Type de réglement</th>
                                                                <th>N° de transaction</th>
                                                                <th>Banque</th>
                                                                <th>Montant</th>
                                                                <th>Infos</th>
                                                                <th colspan="3">Actions</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php

                                                            $totalMontant = 0;
                                                            foreach ($lesInscriptionsPayees as $uneInscription) {
                                                                $montant = 0;
                                                                if (isset($uneInscription['MONTANT_INSCRIPTION']) and is_numeric($uneInscription['MONTANT_INSCRIPTION'])) {
                                                                    $montant = $uneInscription['MONTANT_INSCRIPTION'];
                                                                }

                                                                $leTypeReglement = $pdo->getParametreId($uneInscription['PAIEMENT_INSCRIPTIONS']);
                                                                if (isset($leTypeReglement['NOM'])) {
                                                                    $typeName = $leTypeReglement['NOM'];
                                                                } else {
                                                                    $typeName = "";
                                                                }

                                                                $nomPrenomFrat = "";
                                                                if ($uneInscription['PAIEMENTS_FRATRIES'] != []) {
                                                                    foreach ($uneInscription['PAIEMENTS_FRATRIES'] as $unPaiementFrat) {
                                                                        $nomPrenomFrat .= '<br>' . $unPaiementFrat['NOM_ELEVE_STAGE'] . ' ' . $unPaiementFrat['PRENOM_ELEVE_STAGE'];
                                                                    }
                                                                }
                                                                $leReglementInfos = $pdo->getInfosReglementStage($uneInscription['ID_INSCRIPTIONS']);
                                                                $infosText = "";
                                                                if (isset($leReglementInfos["STAGE"]) AND $leReglementInfos["STAGE"] == 1) {
                                                                    $infosText .= "Stage<br>";
                                                                }
                                                                if (isset($leReglementInfos["SORTIE_STAGE"]) AND $leReglementInfos["SORTIE_STAGE"] == 1) {
                                                                    $infosText .= "Sortie de stage<br>";
                                                                }

                                                                echo '<tr>
			                                                        <td><strong>' . stripslashes($uneInscription['NOM_ELEVE_STAGE']) . ' ' . stripslashes($uneInscription['PRENOM_ELEVE_STAGE']) . '</strong>' . $nomPrenomFrat . '</td>
			                                                        <td>' . $typeName . '</td>
                                                                    <td>' . $uneInscription['NUMTRANSACTION'] . '</td>
                                                                    <td>' . stripslashes(ucfirst(strtolower($uneInscription['BANQUE_INSCRIPTION']))) . '</td>
                                                                    <td>' . $montant . ' €</td>
                                                                    <td>' . $infosText . '</td>
                                                                    <td><a href="index.php?choixTraitement=administrateur&action=modifierReglementStage&uneInscription=' . $uneInscription['ID_INSCRIPTIONS'] . '&unStage=' . $stageSelectionner['ID_STAGE'] . '" class="btn btn-primary"><span class="glyphicon pe-7s-pen"></span></a></td>
                                                                    <td><a href="index.php?choixTraitement=administrateur&action=recuStage&num=' . $uneInscription['ID_INSCRIPTIONS'] . '&numStage=' . $stageSelectionner['ID_STAGE'] . '" class="btn btn-secondary"><span class="glyphicon pe-7s-print"></span></a></td>
                                                                    <td>';
                                                                    if ($admin == 2) {
                                                                        echo '<a href="javascript:void(0);" class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment supprimer ce règlement ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&amp;action=supprimerUnReglementStage&num=' . $uneInscription['ID_INSCRIPTIONS'] . '&numStage=' . $stageSelectionner['ID_STAGE'] . '\'; } else { void(0); }"><span class="pe-7s-trash"></span></a>';
                                                                    }
                                                                    echo '</td>
		                                                        </tr>';
                                                                $totalMontant += $montant;
                                                            }
                                                            echo '<tr><td colspan="4"><i>' . $nombreInscriptionsPayees . ' payé(s) sur ' . $nombreInscriptions . ' inscription(s).</i></td>
<th>Montant total :</th>
<th colspan="2">' . $totalMontant . ' €</th>
</tr>';

                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>


                                    </div>


                                    <!-------------------------------------------------------------------- Stats --------------------------------------------------------------------------------->
                                    <div role="tabpanel" class="tab-pane<?php if ($onglet == 'stats') {
                                        echo ' active';
                                    } ?>" id="stats">


                                        <?php
                                        // Par classe
                                        $graph_classesx = $pdo->executerRequete2("SELECT parametre.NOM,CLASSE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE LEFT JOIN parametre ON ELEVE_STAGE.CLASSE_ELEVE_STAGE = parametre.ID WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.CLASSE_ELEVE_STAGE ");
                                        $nbEleves = $pdo->nbEleves($anneeEnCours);
                                        $nbElevesParSexe = $pdo->nbElevesParSexe($anneeEnCours);

                                        // Par filiere
                                        $graph_filieresx = $pdo->executerRequete2("SELECT parametre.NOM,FILIERE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE LEFT JOIN parametre ON ELEVE_STAGE.FILIERE_ELEVE_STAGE = parametre.ID WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.FILIERE_ELEVE_STAGE ");


                                        // Par sexe
                                        $graph_sexesx = $pdo->executerRequete2("SELECT SEXE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.SEXE_ELEVE_STAGE ");

                                        // Par établissement
                                        $graph_etabx = $pdo->executerRequete2("SELECT parametre.NOM,ETABLISSEMENT_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE LEFT JOIN parametre ON ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE = parametre.ID WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE ");

                                        // Par ville
                                        $graph_villesx = $pdo->executerRequete2("SELECT VILLE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.VILLE_ELEVE_STAGE ");

                                        // Par association
                                        $graph_assocx = $pdo->executerRequete2("SELECT ASSOCIATION_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ASSOCIATION_ELEVE_STAGE ");

                                        // Par classe et par filiere
                                        $graph_ElevesSPremierex = $pdo->StatClasseFiliere();

                                        $nbElevesParClasse = NULL;
                                        foreach ($graph_classesx as $key) {
                                            $nbElevesParClasse += $key['COUNT(*)'];
                                        }

                                        $nbElevesParFiliere = NULL;
                                        foreach ($graph_filieresx as $key) {
                                            $nbElevesParFiliere += $key['COUNT(*)'];
                                        }

                                        $nbElevesParSexe = NULL;
                                        foreach ($graph_sexesx as $key) {
                                            $nbElevesParSexe += $key['COUNT(*)'];
                                        }

                                        $nbElevesParEtablissement = NULL;
                                        foreach ($graph_etabx as $key) {
                                            $nbElevesParEtablissement += $key['COUNT(*)'];
                                        }

                                        $nbElevesParVille = NULL;
                                        foreach ($graph_villesx as $key) {
                                            $nbElevesParVille += $key['COUNT(*)'];
                                        }

                                        $nbElevesParAssociation = NULL;
                                        foreach ($graph_assocx as $key) {
                                            $nbElevesParAssociation += $key['COUNT(*)'];
                                        }

                                        // Génére un grapghique camembert avec les valeurs demandées
                                        function genererGraphique($id, $type, $hauteur, $largeur, $titre, $valeurs, $nom, $nb, $total)
                                        {
                                            $couleurs = array('red', 'blue', 'green', 'pink', 'orange', 'brown', 'gray', 'lime', 'maroon', 'olive', 'navy', 'teal', 'yellow', 'purple');
                                            echo "<canvas id='" . $id . "'></canvas>
        <script>
        var ctx = document.getElementById('" . $id . "');
        ctx.height = " . $hauteur . ";
        ctx.width = " . $largeur . ";
        var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: { labels: [";
                                            $i = 0;
                                            foreach ($valeurs as $uneStat) {
                                                if ($i > 0) {
                                                    echo ',';
                                                }
                                                if ($uneStat[$nom] == 1 || $uneStat[$nom] == 10 || $uneStat[$nom] == NULL) {
                                                    $uneStat[$nom] = "vide";
                                                }
                                                echo "'" . $uneStat[$nom] . " : " . $uneStat[$nb] . " (" . round(($uneStat[$nb] / $total) * 100) . " %)'";
                                                $i++;
                                            }
                                            echo "],
            datasets: [{ label: '',
              data: [";
                                            $i = 0;
                                            foreach ($valeurs as $uneStat) {
                                                if ($i > 0) {
                                                    echo ',';
                                                }
                                                echo "'" . $uneStat[$nb] . "'";
                                                $i++;
                                            }
                                            echo "], backgroundColor: [";
                                            $i = 0;
                                            foreach ($valeurs as $uneStat) {
                                                if ($i > 0) {
                                                    echo ',';
                                                }
                                                echo "'" . $couleurs[$i] . "'";
                                                $i++;
                                            }
                                            echo "]
            }]
          },
          options: { responsive: true,
            legend: { position: 'top' },
            title: { display: false, text: '" . $titre . "' }
          }
        });
        </script>";
                                        }

                                        ?>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">

                                                        <!-- Répartition par classe -->
                                                        <h4 class="card-title">
                                                            <center>Répartition par classe</center>
                                                        </h4>
                                                        <div class="bloc_graphique"
                                                             style="width:530px"><?php genererGraphique('graph_classes', 'pie', 300, 520, 'Répartition par classe', $graph_classesx, 'NOM', 'COUNT(*)', $nbElevesParClasse); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">

                                                        <!-- Répartition par filière -->
                                                        <h4 class="card-title">
                                                            <center>Répartition par filière</center>
                                                        </h4>
                                                        <div class="bloc_graphique"
                                                             style="width:530px"><?php genererGraphique('graph_filiere', 'pie', 300, 520, 'Répartition par filière', $graph_filieresx, 'NOM', 'COUNT(*)', $nbElevesParFiliere); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">

                                                        <!-- Répartition par sexe -->
                                                        <h4 class="card-title">
                                                            <center>Répartition par sexe</center>
                                                        </h4>
                                                        <div class="bloc_graphique"
                                                             style="width:530px"><?php genererGraphique('graph_sexe', 'pie', 300, 520, 'Répartition par sexe', $graph_sexesx, 'SEXE_ELEVE_STAGE', 'COUNT(*)', $nbElevesParSexe); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">

                                                        <!-- Répartition par établissement -->
                                                        <h4 class="card-title">
                                                            <center>Répartition par établissement</center>
                                                        </h4>
                                                        <div class="bloc_graphique"
                                                             style="width:530px"><?php genererGraphique('graph_etablissement', 'pie', 300, 520, 'Répartition par sexe', $graph_etabx, 'ETABLISSEMENT_ELEVE_STAGE', 'COUNT(*)', $nbElevesParEtablissement); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <!-- Répartition par ville -->
                                                        <h4 class="card-title">
                                                            <center>Répartition par ville</center>
                                                        </h4>
                                                        <div class="bloc_graphique"
                                                             style="width:530px"><?php genererGraphique('graph_ville', 'pie', 300, 520, 'Répartition par ville', $graph_villesx, 'VILLE_ELEVE_STAGE', 'COUNT(*)', $nbElevesParVille); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <!-- Répartition par associations -->
                                                        <h4 class="card-title">
                                                            <center>Répartition par association</center>
                                                        </h4>
                                                        <div class="bloc_graphique"
                                                             style="width:530px"><?php genererGraphique('graph_association', 'pie', 300, 520, 'Répartition par association', $graph_assocx, 'ASSOCIATION_ELEVE_STAGE', 'COUNT(*)', $nbElevesParAssociation); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        // Par classe
                                        $graph_classes = $pdo->executerRequete2("SELECT CLASSE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.CLASSE_ELEVE_STAGE ");

                                        // Par filiere
                                        $graph_filieres = $pdo->executerRequete2("SELECT FILIERE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.FILIERE_ELEVE_STAGE ");


                                        // Par classe et par filiere
                                        $graph_ElevesSPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=60");
                                        $graph_ElevesSTerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=60");
                                        $graph_ElevesESPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=61");
                                        $graph_ElevesESTerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=61");
                                        $graph_ElevesLPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=62");
                                        $graph_ElevesLTerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=62");
                                        $graph_ElevesST2SPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=63");
                                        $graph_ElevesST2STerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=63");
                                        $graph_ElevesSTIPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=64");
                                        $graph_ElevesSTITerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=64");
                                        $graph_ElevesSTMGPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=65");
                                        $graph_ElevesSTMGTerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=65");
                                        $graph_ElevesSTLPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=66");
                                        $graph_ElevesSTLTerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=66");
                                        $graph_ElevesASSPPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=67");
                                        $graph_ElevesASSPTerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=67");
                                        $graph_ElevesBPGAPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=68");
                                        $graph_ElevesBPGATerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=68");
                                        $graph_ElevesSTAVPremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=69");
                                        $graph_ElevesSTAVTerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=69");
                                        $graph_ElevesAutrePremiere = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 55 AND `FILIERE_ELEVE_STAGE`=70");
                                        $graph_ElevesAutreTerminale = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = 56 AND `FILIERE_ELEVE_STAGE`=70");


                                        // Par sexe
                                        $graph_sexes = $pdo->executerRequete2("SELECT SEXE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.SEXE_ELEVE_STAGE ");

                                        // Par établissement
                                        $graph_etab = $pdo->executerRequete2("SELECT ETABLISSEMENT_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ETABLISSEMENT_ELEVE_STAGE ");

                                        // Par ville
                                        $graph_villes = $pdo->executerRequete2("SELECT VILLE_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.VILLE_ELEVE_STAGE ");

                                        // Par association
                                        $graph_assoc = $pdo->executerRequete2("SELECT ASSOCIATION_ELEVE_STAGE,COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON INSCRIPTIONS_STAGE.ID_ELEVE_STAGE = ELEVE_STAGE.ID_ELEVE_STAGE WHERE INSCRIPTIONS_STAGE.ID_STAGE = $num GROUP BY ELEVE_STAGE.ASSOCIATION_ELEVE_STAGE ");

                                        ?>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Répartition par classe</h4>
                                                        <img class="graphique"
                                                             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=FF00FF,0000FF,FF0000,00FF00,00FFFF,FFFF00,F0F0F0,0F0F0F,FFF000,000FFF&chd=t:<?php
                                                             $i = 0;
                                                             foreach ($graph_classes as $uneClasse) {
                                                                 if ($i > 0) {
                                                                     echo ',';
                                                                 }
                                                                 echo $uneClasse['COUNT(*)'];
                                                                 $i++;
                                                             }

                                                             echo '&chl=';

                                                             $i = 0;
                                                             foreach ($graph_classes as $uneClasse) {
                                                                 if ($i > 0) {
                                                                     echo '|';
                                                                 }
                                                                 $nom = '';
                                                                 foreach ($lesClasses as $uneClasse2) {
                                                                     if ($uneClasse2['ID'] == $uneClasse['CLASSE_ELEVE_STAGE']) {
                                                                         $nom = $uneClasse2['NOM'];
                                                                     }
                                                                 }
                                                                 if ($nom == '') {
                                                                     $nom = 'Vide';
                                                                 }
                                                                 echo $nom . ' (' . $uneClasse['COUNT(*)'] . ')';
                                                                 $i++;
                                                             } ?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Répartition par filière</h4>
                                                        <img class="graphique"
                                                             src="http://chart.apis.google.com/chart?cht=p3&chs=500x200&chco=FF00FF,0000FF,FF0000,00FF00,00FFFF,FFFF00,F0F0F0,0F0F0F,FFF000,000FFF&chd=t:<?php
                                                             $i = 0;
                                                             foreach ($graph_filieres as $uneClasse) {
                                                                 if ($i > 0) {
                                                                     echo ',';
                                                                 }
                                                                 echo $uneClasse['COUNT(*)'];
                                                                 $i++;
                                                             }

                                                             echo '&chl=';

                                                             $i = 0;
                                                             foreach ($graph_filieres as $uneClasse) {
                                                                 if ($i > 0) {
                                                                     echo '|';
                                                                 }
                                                                 $nom = '';
                                                                 foreach ($lesfilieres as $uneClasse2) {
                                                                     if ($uneClasse2['ID'] == $uneClasse['FILIERE_ELEVE_STAGE']) {
                                                                         $nom = $uneClasse2['NOM'];
                                                                     }
                                                                 }
                                                                 if ($nom == '') {
                                                                     $nom = 'Vide';
                                                                 }
                                                                 echo $nom . ' (' . $uneClasse['COUNT(*)'] . ')';
                                                                 $i++;
                                                             } ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Répartition par classe et filière</h4>

                                                        <img class="graphique" src="http://chart.apis.google.com/chart?cht=p3&chs=600x200&chco=FF0000,0000FF,FFFF00,FF6600,00FF00,FFCC99,FF00FF,666699,808000,800000,008080
  &chd=t:<?php echo $graph_ElevesSPremiere[0][0] . ',' . $graph_ElevesSTerminale[0][0] . ',' . $graph_ElevesESPremiere[0][0] . ',' . $graph_ElevesESTerminale[0][0] . ',' . $graph_ElevesLPremiere[0][0] . ',' . $graph_ElevesLTerminale[0][0] . ',' . $graph_ElevesST2SPremiere[0][0] . ',' . $graph_ElevesST2STerminale[0][0] . ',' . $graph_ElevesSTIPremiere[0][0] . ',' . $graph_ElevesSTITerminale[0][0] . ',' . $graph_ElevesSTMGPremiere[0][0] . ',' . $graph_ElevesSTMGTerminale[0][0] . ',' . $graph_ElevesSTLPremiere[0][0] . ',' . $graph_ElevesSTLTerminale[0][0] . ',' . $graph_ElevesASSPPremiere[0][0] . ',' . $graph_ElevesASSPTerminale[0][0] . ',' . $graph_ElevesBPGAPremiere[0][0] . ',' . $graph_ElevesBPGATerminale[0][0] . ',' . $graph_ElevesSTAVPremiere[0][0] . ',' . $graph_ElevesSTAVTerminale[0][0] . ',' . $graph_ElevesAutrePremiere[0][0] . ',' . $graph_ElevesAutreTerminale[0][0]; ?>
  &chl=t:1ere S (<?php echo $graph_ElevesSPremiere[0][0] . ')|Term S (' . $graph_ElevesSTerminale[0][0] . ')|1ere ES (' . $graph_ElevesESPremiere[0][0] . ')|Term ES(' . $graph_ElevesESTerminale[0][0] . ')|1ere L (' . $graph_ElevesLPremiere[0][0] . ')|Term L (' . $graph_ElevesLTerminale[0][0] . ')|1ere ST2S (' . $graph_ElevesST2SPremiere[0][0] . ')|Term ST2S (' . $graph_ElevesST2STerminale[0][0] . ')|1ere STI (' . $graph_ElevesSTIPremiere[0][0] . ')|Term STI (' . $graph_ElevesSTITerminale[0][0] . ')|1ere STMG (' . $graph_ElevesSTMGPremiere[0][0] . ')|Term STMG (' . $graph_ElevesSTMGTerminale[0][0] . ')|1ere STL (' . $graph_ElevesSTLPremiere[0][0] . ')|Term STL (' . $graph_ElevesSTLTerminale[0][0] . ')|1ere ASSP (' . $graph_ElevesASSPPremiere[0][0] . ')|Term ASSP (' . $graph_ElevesASSPTerminale[0][0] . ')|BPGA Premiere (' . $graph_ElevesBPGAPremiere[0][0] . ')|Term BPGA (' . $graph_ElevesBPGATerminale[0][0] . ')|Prem STAV (' . $graph_ElevesSTAVPremiere[0][0] . ')|Term STAV (' . $graph_ElevesSTAVTerminale[0][0] . ')|1ere Autre (' . $graph_ElevesAutrePremiere[0][0] . ')|Term Autre (' . $graph_ElevesAutreTerminale[0][0] . ')'; ?>
  ">

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-5">
                                                <div class="main-card mb-3 card">
                                                    <div class="card-body">
                                                        <table class="table" style="width:300px">
                                                            <thead>
                                                            <tr>
                                                                <th>Classe et filière</th>
                                                                <th>Inscrits</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $nbTotal = 0;
                                                            for ($iFiliere = 60; $iFiliere < 71; $iFiliere++) {

                                                                echo '';
                                                                for ($iClasse = 55; $iClasse < 57; $iClasse++) {
                                                                    $nbInscrits = $pdo->executerRequete2("SELECT COUNT(*) FROM `ELEVE_STAGE` INNER JOIN INSCRIPTIONS_STAGE ON ELEVE_STAGE.ID_ELEVE_STAGE = INSCRIPTIONS_STAGE.ID_ELEVE_STAGE WHERE CLASSE_ELEVE_STAGE > 54 AND INSCRIPTIONS_STAGE.ID_STAGE = $num AND `CLASSE_ELEVE_STAGE` = $iClasse AND `FILIERE_ELEVE_STAGE`=$iFiliere");

                                                                    if ($nbInscrits[0][0] > 0) {

                                                                        foreach ($lesClasses as $uneClasse2) {
                                                                            if ($uneClasse2['ID'] == $iClasse) {
                                                                                $nomClasse = $uneClasse2['NOM'];
                                                                            }
                                                                        }

                                                                        foreach ($lesfilieres as $uneFiliere) {
                                                                            if ($uneFiliere['ID'] == $iFiliere) {
                                                                                $nomFiliere = $uneFiliere['NOM'];
                                                                            }
                                                                        }

                                                                        $nbTotal = ($nbTotal + $nbInscrits[0][0]);

                                                                        echo '<tr><td>' . $nomClasse . ' ' . $nomFiliere . '</td>
          <td>' . $nbInscrits[0][0] . '</td>
          </tr>';

                                                                    }
                                                                }

                                                            }
                                                            echo '<tr>
      <th>Total</th>
      <th>' . $nbTotal . '</th>
      </tr>';
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    
                                    <!-------------------------------------------------------------------- Présences Elèves --------------------------------------------------------------------------------->


  <div role="tabpanel" class="tab-pane<?php if($onglet == 'presencesEleves') { echo ' active'; } ?>" id="presencesEleves">
    <div class="row">
      <div class="col-md-6">
    <br>
    <br>
    <p>
      <a href="index.php?choixTraitement=administrateur&action=saisirPresencesStage&num=<?php echo $stageSelectionner['ID_STAGE']; ?>" class="btn btn-info">Saisir les présences</a>
      <a href="index.php?choixTraitement=administrateur&action=saisirAbsencesStage&num=<?php echo $stageSelectionner['ID_STAGE']; ?>"  class="mr-2 btn btn-info">Notifier les absents</a>
    <!--<a href="index.php?choixTraitement=administrateur&action=voirAbsencesStage&num=1" class="btn btn-info">Voir les absents</a>-->
    </p>

                                                <?php
                                                $datePrecedente = '';

                                                $matinouap = array('matin', 'après-midi');

                                                $nbPresences = 0;
                                                foreach ($lesPresences as $laPresence) {

                                                    $infosEleve = $pdo->recupEleveStage($laPresence['ID_INSCRIPTIONS']);

                                                    // Si c'est une nouvelle date

                                                    if ($datePrecedente != $laPresence['DATE_PRESENCE'] . $laPresence['MATINOUAP']) {


                                                        echo '<div class="main-card mb-3 card">
          <div class="card-body">
      <table class="mb-0 table">
        <thead>
        <tr>
        <th colspan="3" style="text-align:center;background:#99CCFF;padding:2px">Date : ' . date('d/m/Y', strtotime($laPresence['DATE_PRESENCE'])) . ' ' . $matinouap[$laPresence['MATINOUAP']] . '</th>
        </tr>
        <tr>
        <th style="text-align:center;background:#99CCFF;padding:2px">Nom</th>
        <th style="text-align:center;background:#99CCFF;padding:2px">Prénom</th>
        <th style="text-align:center;background:#99CCFF;padding:2px">Classe</th>
        </tr>
      </thead>
      <tbody>
      ';
                                                        $datePrecedente = $laPresence['DATE_PRESENCE'] . $laPresence['MATINOUAP'];
                                                        $nbPresences = 0;
                                                    }
                                                    // On récupére la classe
                                                    $classe = '';
                                                    foreach ($lesClasses as $uneClasse) {
                                                        if ($uneClasse['ID'] == $infosEleve['CLASSE_ELEVE_STAGE']) {
                                                            $classe = $uneClasse['NOM'];
                                                        }
                                                    }
                                                    // On la compte dans les totauxClasses
                                                    $nbPresences++;
                                                    echo '<tr>
    <td style="padding:2px">' . $nbPresences . ' ' . $infosEleve['NOM_ELEVE_STAGE'] . '</td>
    <td style="padding:2px">' . $infosEleve['PRENOM_ELEVE_STAGE'] . '</td>
    <td style="padding:2px">' . $classe . '</td>
    </tr>';
                                                }
                                                // Si ce n'est pas la première date, on ferme la précédente
                                                if ($datePrecedente != '') {
                                                    echo '
      </tbody>
      </table>
      </div>
      </div>';
                                                    $nbPresences = 0;
                                                }

                                                ?>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <?php
                            } ?>








<?php 
  $datedeb = dateAnglaisVersFrancais($stageSelectionner["DATEDEB_STAGE"]);
  $datefin = dateAnglaisVersFrancais($stageSelectionner["DATEFIN_STAGE"]);
?>


<div id="communicationModal" class="modal fade bd-example-modal-lgI" tabindex="-1" role="dialog">
    <!-- AMINEFF -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1>Communication de <?php echo $stageSelectionner["NOM_STAGE"]?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
          </div>

          <div id="stageErrorBox" class="errorBox">
          </div>

          <div class="modal-body">
            <div>
              <select id="stageTarget" class="form-control autosize-input">
                <option value="default">Choisir</option>
                <option value="parents">Parents et élèves de l'année en cours</option>
                <option value="inscrits">Parents et élèves inscrits au stage</option>
              </select><br>
            </div>
            <div id="communicationContent">
              <div id="checkboxes">
              </div><br>
              <div id="pubContent">
                <label for="emailadresses">Adresse(s) e-mail:</label>
                <textarea name="emailadresses" id="emailadresses" class="form-control autosize-input" cols="30"></textarea><br>

                <label for="emailadresses">Télephones:</label>
                <textarea name="telephones" id="telephones" class="form-control autosize-input" cols="30"></textarea><br>
                <h1>Aperçu du message</h1>
                <br>
                <textarea name="message" id="messageBody" cols="30" rows="10" class="form-control autosize-input"></textarea><br>
                <img id="attach" src="" alt="" width="500" height="700">

                
                <!--Permet la récupération des informations-->
                <textarea id="nomStage" hidden><?=$stageSelectionner["NOM_STAGE"]?></textarea>
                <textarea id="hiddenTypes" hidden><?=$types?></textarea>
                <textarea id="hiddenEmailAnnee" hidden><?=$emailsAnneeFinal?></textarea>
                <textarea id="hiddenTelephoneAnnee" hidden><?=$numsAnnee?></textarea>
                <textarea id="hiddenEmailInscrit" hidden><?=$emailsInscrit?></textarea>
                <textarea id="hiddenTelephoneInscrit" hidden><?=$numsInscrit?></textarea>
                <textarea id="afficheNom" hidden><?=$stageSelectionner['AFFICHE_STAGE']?></textarea><br>
                <textarea id="dates" hidden><?=$datedeb.",".$datefin?></textarea>
                <textarea id="description" hidden><?=strip_tags(html_entity_decode($stageSelectionner["DESCRIPTION_STAGE"]));?></textarea>
                <textarea id="lienInscription" hidden><?=$linkInscription?></textarea>
                <textarea id="hiddenMessage" hidden><?= $msg ?></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
            <button type="button" id="sendStageButton" class="btn btn-primary">Envoyer par SMS</button>
            <button type="button" id="sendMailStageButton" class="btn btn-primary">Envoyer par E-mail</button>
          </div>
        </div>
      </div>
    </div>
</div>




<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="./js/form-components/input-select.js"></script>