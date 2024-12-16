<link rel="stylesheet" href="vues/administrateur/croppie.css"/>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Fiche intervenant
                <?php
                if (isset($num)) {
                    echo '<div class="page-title-subheading">' . $IntervenantSelectionner["PRENOM"] . ' ' . $IntervenantSelectionner["NOM"] . '</div>';
                } else {
                    echo '<div class="page-title-subheading">Sélectionner un élève pour accéder à sa fiche</div>';
                }
                ?>
            </div>
        </div>

        <?php if (isset($IntervenantSelectionner)) { ?>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a style="float:left" href="#" id="print-card" data-intervenant-id="<?= $IntervenantSelectionner["ID_INTERVENANT"] ?>">
                        <button type="button" class="mr-2 btn btn-success">
                            <span class="glyphicon glyphicon-plus">Imprimer ma carte</span>
                        </button>
                    </a>
                    <?php if ($IntervenantSelectionner['STATUT'] === 'Bénévole') { ?>
                        <a style="float:left" href="index.php?choixTraitement=administrateur&action=contratBenevole&intervenant=<?= $IntervenantSelectionner["ID_INTERVENANT"] ?>">
                            <button type="button" class="mr-2 btn btn-success">
                                <span class="glyphicon glyphicon-plus"><i class="fas fa-download"></i> Contrat bénévole</span>
                            </button>
                        </a>
					<?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($IntervenantSelectionner) && $admin == 2) {
            echo '
            <div class="page-title-actions">
              <div class="d-inline-block dropdown">
              <a href="javascript:if(confirm(\'Voulez-vous vraiment supprimer ce rendez-vous ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerUnIntervenant&num=' . $IntervenantSelectionner['ID_INTERVENANT'] . '\'; };" class="btn btn-danger">

                <button type="button" class="btn btn-danger" value="">
                <span class="btn-icon-wrapper pr-2 opacity-7">
                  <i class="fa fa-print fa-w-20"></i>
                </span>
                Supprimer l\'intervenant
              </button>
              </a>
            </div>
          </div>
            ';
        } ?>


    </div>
</div>
<form name="frmConsultFrais" id="LesIntervenantsForm" method="POST"
      action="index.php?choixTraitement=administrateur&action=LesIntervenants">
        

    <center>
        <div class="col-md-4">
            <select name="unIntervenant" onchange="this.form.submit()" class="multiselect-dropdown form-control"
                    data-live-search="true">
                <option disabled="disabled" selected="selected">Choisir</option>
                <?php foreach ($lesIntervenants as $unIntervenant) {

                    // Si c'est un admin et qu'on est pas super admin
                    if ($admin < 2 and $unIntervenant['ADMINISTRATEUR'] > 0) {
                        continue;
                    }

                    // Si c'est l'intervenant en cours
                    if (isset($IntervenantSelectionner) and $IntervenantSelectionner['ID_INTERVENANT'] == $unIntervenant['ID_INTERVENANT']) {
                        $selectionner = "selected='selected'";
                    } else {
                        $selectionner = "";
                    }
                    // extraction des jour, mois, an de la date

                    echo " <option " . $selectionner . " value='" . $unIntervenant['ID_INTERVENANT'] . "' name='unIntervenant'>" . $unIntervenant['NOM'] . " " . $unIntervenant['PRENOM'] . "</option>";
                }
                echo '</select></center>';
                if (!isset($IntervenantSelectionner)) {
                    echo '</div>';
                }
                echo '</form>';

                // si un rib est envoyé
                if (isset($_FILES['fichier_rib'])) {

                    //c'est un fichier, on stock le fichier
                    move_uploaded_file($_FILES['fichier_rib']['tmp_name'], 'ribIntervenants/' . $_POST['num'] . '_' . basename($_FILES['fichier_rib']['name']));
                    $photo = $_POST['num'] . '_' . $_FILES['fichier_rib']['name'];
                    $pdo->executerRequete2('UPDATE `intervenants` SET `FICHIER_RIB` = "' . $photo . '" WHERE `ID_INTERVENANT` = ' . $_POST['num']);
                    $IntervenantSelectionner['FICHIER_RIB'] = $photo;
                }

                // si un cv est envoyé
                if (isset($_FILES['fichier_cv'])) {

                    //c'est un fichier, on stock le fichier
                    move_uploaded_file($_FILES['fichier_cv']['tmp_name'], 'cvIntervenants/' . $_POST['num'] . '_' . basename($_FILES['fichier_cv']['name']));
                    $photo = $_POST['num'] . '_' . $_FILES['fichier_cv']['name'];
                    $pdo->executerRequete2('UPDATE `intervenants` SET `FICHIER_CV` = "' . $photo . '" WHERE `ID_INTERVENANT` = ' . $_POST['num']);
                    $IntervenantSelectionner['FICHIER_CV'] = $photo;
                }

                // si un diplome est envoyé
                if (isset($_FILES['fichier_diplome'])) {

                    //c'est un fichier, on stock le fichier
                    move_uploaded_file($_FILES['fichier_diplome']['tmp_name'], 'diplomesIntervenants/' . $_POST['num'] . '_' . basename($_FILES['fichier_diplome']['name']));
                    $photo = $_POST['num'] . '_' . $_FILES['fichier_diplome']['name'];
                    $pdo->executerRequete2('UPDATE `intervenants` SET `FICHIER_DIPLOME` = "' . $photo . '" WHERE `ID_INTERVENANT` = ' . $_POST['num']);
                    $IntervenantSelectionner['FICHIER_DIPLOME'] = $photo;
                }

                // si une photo est envoyée
                if (isset($_FILES['fichier']) or isset($_POST['photo_data'])) {

                    // si c'est une image de la webcam
                    if ($_POST['photo_data'] != '') {

                        $photo = $_POST['photo_data'];

                        // on enregistre l'image
                        $photo = base64_decode(substr($photo, 22));
                        $nom_photo = $_POST['num'] . '_photo.png';
                        file_put_contents('/home/associatry/www/extranet/photosIntervenants/' . $nom_photo, $photo);

                        $pdo->executerRequete2('UPDATE `intervenants` SET `PHOTO` = "' . $nom_photo . '" WHERE `ID_INTERVENANT` = ' . $_POST['num']);
                        $IntervenantSelectionner['PHOTO'] = $nom_photo;

                    } else {

                        //c'est un fichier, on stock le fichier
                        move_uploaded_file($_FILES['fichier']['tmp_name'], 'photosIntervenants/' . $_POST['num'] . '_' . basename($_FILES['fichier']['name']));
                        $photo = $_POST['num'] . '_' . $_FILES['fichier']['name'];
                        $pdo->executerRequete2('UPDATE `intervenants` SET `PHOTO` = "' . $photo . '" WHERE `ID_INTERVENANT` = ' . $_POST['num']);
                        $IntervenantSelectionner['PHOTO'] = $photo;
                    }
                }

                echo ' <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=LesIntervenants">
          <input type="text" name="unIntervenant" value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" style="display:none">';

                if (isset($IntervenantSelectionner))
                {

                if ($IntervenantSelectionner['PHOTO'] == "") {
                    $photo = "AUCUNE.jpg";
                } else {
                    $photo = $IntervenantSelectionner['PHOTO'];
                }
                echo '<center><div class="col-md-4"><div class="main-card mb-3 card">

            <div class="card-body">
            <img width="200" height="200" style="box-shadow: 1px 1px 20px #555;image-orientation: 0deg;"  src="photosIntervenants/' . $photo . '" >
            <br><br>
            <input type="button" value="Modifier la photo" class="mb-2 mr-2 btn btn-primary" style="font-size:20px" onclick="document.getElementById(\'interface_photo\').style.display = \'block\';">
            </div></div></div></center>
            '; ?>


                <div id="interface_photo" style="display:none;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-shadow-primary border mb-3 card card-body border-primary">
                                <div class="card-body">

                                    <!-- Début webcam_new -->
                                    <div class="content" style="text-align:center;">
                                        <div class="holder">
                                            <video autoplay id="video"></video>
                                            <div id="fallback" style="display: none">
                                                <div id="alternativeContent"> You need Flash Player to play this game.
                                                    <p><a href="http://www.adobe.com/go/getflashplayer"><img
                                                                src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
                                                                alt="Get Adobe Flash player"/></a></p>
                                                </div>
                                            </div>
                                            <canvas id="canvas"></canvas>
                                        </div>
                                        <div class="buttons">
                                            <button type="button" id="buttonCapture" disabled>Capturer</button>
                                            <button type="button" id="buttonSave" disabled>Sauvegarder</button>
                                        </div>
                                        <div id="savedImages"></div>
                                    </div>
                                    <!--fin webcam_new -->


                                    <center><br><b>Fichier</b><br><br>
                                        <img src="images/logo_fichier.jpg" style="width:100px"></center>
                                    <br>


                                    <center>
                                        <?php //<input type="file" onchange="this.form.submit()" name="fichier" />
                                        ?>
                                        <div class="container">
                                            <div class="panel panel-default">
                                                <div class="panel-body" align="center">
                                                    <input type="file" name="upload_image" id="upload_image"/>
                                                    <br/>
                                                    <div id="uploaded_image"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </center>


                                    <br><br>


                                    <script type="text/javascript">
                                        (function () {

                                            var streaming = false,
                                                video = document.querySelector('#video'),
                                                cover = document.querySelector('#cover'),
                                                canvas = document.querySelector('#canvas'),
                                                photo = document.querySelector('#photo'),
                                                startbutton = document.querySelector('#startbutton'),
                                                width = 320,
                                                height = 0;

                                            navigator.getMedia = (navigator.getUserMedia ||
                                                navigator.webkitGetUserMedia ||
                                                navigator.mozGetUserMedia ||
                                                navigator.msGetUserMedia);

                                            navigator.getMedia(
                                                {
                                                    video: true,
                                                    audio: false
                                                },
                                                function (stream) {
                                                    if (navigator.mozGetUserMedia) {
                                                        video.mozSrcObject = stream;
                                                    } else {
                                                        var vendorURL = window.URL || window.webkitURL;
                                                        video.src = vendorURL.createObjectURL(stream);
                                                    }
                                                    video.play();
                                                },
                                                function (err) {
                                                    console.log("An error occured! " + err);
                                                }
                                            );

                                            video.addEventListener('canplay', function (ev) {
                                                if (!streaming) {
                                                    height = video.videoHeight / (video.videoWidth / width);
                                                    video.setAttribute('width', width);
                                                    video.setAttribute('height', height);
                                                    canvas.setAttribute('width', width);
                                                    canvas.setAttribute('height', height);
                                                    streaming = true;
                                                }
                                            }, false);

                                            function takepicture() {
                                                canvas.width = width;
                                                canvas.height = height;
                                                canvas.getContext('2d').drawImage(video, 0, 0, width, height);
                                                var data = canvas.toDataURL('image/png');
                                                photo.setAttribute('value', data);
                                                document.getElementById('photo_apercu').src = data;
                                            }

                                            startbutton.addEventListener('click', function (ev) {
                                                takepicture();
                                                ev.preventDefault();
                                            }, false);

                                        })();
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input class="form-control" name="num" value="<?php echo $IntervenantSelectionner['ID_INTERVENANT']; ?>"
                       readonly="readonly" autofocus="" style="display:none">
</form>


<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav" id="onglets" role="tablist">
                    <li role="presentation" class="nav-item">
                        <a href="#infos" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab">
                            <span class="glyphicon glyphicon-file">Informations</span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#reglements" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                            <span class="glyphicon glyphicon-tag"> Règlements</span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#annees" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                            <span class="glyphicon glyphicon-pencil">Années</span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#documents" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                            <span class="glyphicon glyphicon-folder-open">Documents</span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#rdv" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                            <span class="glyphicon glyphicon-pushpin">Rendez-vous</span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#horaires" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                            <span class="glyphicon glyphicon-time">Horaires</span>
                        </a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#presences" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                            <span class="glyphicon glyphicon-calendar">Présences</span>
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

<?php if (isset($IntervenantSelectionner)) { ?>
    <script>
        $('#print-card').on('click', function () {
            const {origin, pathname} = document.location;
            const collabId = $(this).attr('data-intervenant-id');

            const iframe = document.createElement('iframe');
            iframe.style.maxHeight = '10px';
            iframe.style.maxWidth = '10px';
            iframe.src = `${origin}${pathname}?choixTraitement=administrateur&action=macarte&intervenant=${collabId}&print=true`;
            $('#LesIntervenantsForm').append(iframe);
        });
    </script>
<?php } ?>


<div class="tab-content">
    <?php echo '


                <div role="tabpanel" class="tab-pane active" id="infos">
                  <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=LesIntervenantsModifier">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="main-card mb-3 card">
                        <div class="card-body">
                        <h4 class="card-title">Intervenant</h4>
                        <div class="form-row">
                          <div class="col-md-2">
                <label for="num">Numéro </label>
                <input class="form-control" name="num"  value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" readonly="readonly" autofocus="">
                </div>
                </div>
<div class="form-row">
<div class="col-md-6">
                <label for="nom" class="required">Nom </label>
                <input class="form-control" name="nom"  value="' . $IntervenantSelectionner['NOM'] . '" autofocus="" >
                </div>
<div class="col-md-6">
                <label for="prenom" class="required">Prénom </label>
                <input class="form-control" name="prenom" value="' . $IntervenantSelectionner['PRENOM'] . '" autofocus="" >
                </div>
<div class="col-md-2">
                <label for="actif" class="required">Actif ?</label><br>
                <select name="actif" class="form-control">
                ';
    if ($IntervenantSelectionner['ACTIF'] == 1) {
        echo '<option value="1" selected="selected" name="actif">Oui</option>
                  <option value="0" name="actif">Non</option>';
    } else {
        echo '<option value="1" name="actif">Oui</option>
                    <option value="0"  selected="selected" name="actif">Non</option>';
    }


    list($annee, $mois, $jour) = explode('-', $IntervenantSelectionner['DATE_DE_NAISSANCE']);
    $dateFrancais = $jour . "-" . $mois . "-" . $annee;


    echo '
                    </select></div><br>
<div class="col-md-4">
                    <label for="date_naissance" class="required">Date de naissance </label><br>
                    <input type="date" class="form-control" name="date_naissance" value="' . $IntervenantSelectionner['DATE_DE_NAISSANCE'] . '" autofocus=""  ><br>
</div>
<div class="col-md-6">
                    <label for="lieu_naissance" class="required">Lieu de naissance</label>
                    <input class="form-control" name="lieu_naissance" value="' . $IntervenantSelectionner['LIEU_DE_NAISSANCE'] . '" autofocus="" ><br>
                    </div>

<div class="col-md-6">
                    <label for="email" class="required">E-mail</label>
                    <input class="form-control" name="email"  value="' . $IntervenantSelectionner['EMAIL'] . '"  type="email"><br>
</div>

<div class="col-md-6">
                    <label for="statut" class="required">Statut </label>
                    <select class="form-control" name="statut">
                    ';
    foreach ($lesStatuts as $unStatut) {
        echo '<option value="' . $unStatut . '"';
        if ($IntervenantSelectionner['STATUT'] == $unStatut) {
            echo ' selected="selected"';
        }
        echo '>' . $unStatut . '</option>';
    }
  

    echo '
                    </select>
                    </div><br>

<div class="col-md-6">
                    <label for="tel" class="required">Téléphone </label>
                    <input class="form-control" name="tel" value="' . $IntervenantSelectionner['TELEPHONE'] . '"  autofocus="" ><br>
                    </div>
</div>

</div></div></div>


<div class="col-md-6">
  <div class="main-card mb-3 card">
    <div class="card-body">
                    ';

    /*
    <label for="adresse">Adresse</label>
    <input class="form-control" name="adresse"  value="'.$IntervenantSelectionner['ADRESSE_POSTALE'].'" autofocus="" ><br>

    <label for="cp">Code Postal</label>
    <input class="form-control" name="cp"  value="'.$IntervenantSelectionner['CODE_POSTAL'].'" autofocus="" ><br>

    <label for="ville">Ville</label>
    <input class="form-control" name="ville" value="'.$IntervenantSelectionner['VILLE'].'" autofocus="" ><br>
    */


    //formulaireAdresse(stripslashes($IntervenantSelectionner['ADRESSE_POSTALE']), $IntervenantSelectionner['CODE_POSTAL'], $IntervenantSelectionner['VILLE']);


    echo '
                    <label for="adresse" class="required">Adresse</label>
                    <input class="form-control" name="adresse" value="' . $IntervenantSelectionner['ADRESSE_POSTALE'] . '" autofocus="" ><br>

                    <label for="cp" class="required">Code postal</label>
                    <input class="form-control" name="cp" value="' . $IntervenantSelectionner['CODE_POSTAL'] . '" autofocus="" ><br>

                    <label for="ville" class="required">Ville</label>
                    <input class="form-control" name="ville" value="' . $IntervenantSelectionner['VILLE'] . '" autofocus="" ><br>

                    <label for="diplome" class="required">Diplôme</label>
                    <input class="form-control" name="diplome" value="' . $IntervenantSelectionner['DIPLOME'] . '" autofocus="" ><br>

                    <label for="numsecu" class="required">Numéro de Sécurité Sociale</label>
                    <input class="form-control" name="numsecu" value="' . $IntervenantSelectionner['SECURITE_SOCIALE'] . '" autofocus="" ><br>

                    <label for="nationalite" class="required">Nationalité</label>
                    <input class="form-control" name="nationalite" value="' . $IntervenantSelectionner['NATIONALITE'] . '"   autofocus="" ><br>

                    <label for="password" class="required">Code Personnel <small>(ne rien marquer si vous ne souhaitez pas le modifier)</small></label>
                    <input class="form-control" name="password" autofocus="" ><br>

                    <br><br>
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                  <div class="main-card mb-12 card">
                    <div class="card-body">
<h4 class="card-title">Spécialités</h4>
                      <br>
<div class="row">
                      ';

    $ct = count($lesMatieres) / 4;
    $lesMatieres1 = array_chunk($lesMatieres, round($ct));
    for ($i = 0; $i < $ct; $i++) {
        foreach ($lesMatieres1[$i] as $uneLigne) {

            $checked = " ";

            foreach ($lesMatieresIntervenant as $uneLigne2) {
                if ($uneLigne['ID'] == $uneLigne2['ID']) {
                    $checked = "checked='checked'";
                }
            }

            echo '

<div class="col-md-3 main ">
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" id=' . $uneLigne['NOM'] . ' ' . $checked . ' class="custom-control-input" name="specialite[]" value=' . $uneLigne['ID'] . '>
                            <label class="custom-control-label" for=' . $uneLigne["NOM"] . '>' . $uneLigne["NOM"] . '</label>
                        </div></div>

                        ';
        }
    }
    echo '</div><br><input value="Modifier" type="submit" class="btn btn-success">';
    echo '
                      <br /></div></div></div>



                      <div class="col-md-6">
                        <div class="main-card mb-12 card">
                          <div class="card-body">
                      <label for="commentaires" class="card-title">Commentaires<br />
                      </label>
                      <textarea  class="form-control"  name="commentaires">' . $IntervenantSelectionner['COMMENTAIRES'] . '</textarea>
                      ';
    if ($IntervenantSelectionner['STATUT'] == "Service Civique") {
        echo ' <label class="card-title" for="service">Service Civique :<br />
                        </label>
                        <textarea class="form-control" name="service">' . $IntervenantSelectionner['SERVICECIVIQUE'] . '</textarea>';
    }
    echo '
                      <br>
                      </div></div></div>



                    </div>

            </div>
          </form>
        </div>













                    <div role="tabpanel" class="tab-pane" id="reglements">
<form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=LesIntervenantsModifierReglement">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="main-card mb-3 card">
                            <div class="card-body">
                            <h4 class="card-title">Règlements</h4>
                    <div class="row">
                    <div class="position-relative form-group col-md-4">
                    <input  name="num" type="hidden" value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" readonly="readonly">
                    <label for="compte">RIB (avec clé)</label><br>
                    <input name="compte" class="form-control" value="' . $IntervenantSelectionner['COMPTEBANCAIRE'] . '"   autofocus="" ><br>
                    </div>
                    <div class="position-relative form-group col-md-3">
                    <label for="iban">IBAN </label><br>
                    <input name="iban" class="form-control" value="' . $IntervenantSelectionner['IBAN'] . '"    autofocus="" ><br>
                    </div>
                    <div class="position-relative form-group col-md-2">
                    <label for="bic">BIC </label><br>
                    <input name="bic" class="form-control" value="' . $IntervenantSelectionner['BIC'] . '"    autofocus="" ><br>
                    </div>
                    <div class="position-relative form-group col-md-3">
                    <label for="banque">Votre Banque</label><br>
                    <select class="form-control" name="banque">
                      <option value="" disabled="disabled" selected="selected">Choisir</option>';
    foreach ($lesBanques as $uneLigne) {
        echo '<option ';
        if ($uneLigne['NOM'] == $IntervenantSelectionner['BANQUE']) {
            echo 'selected="selected"';
        }
        echo ' id="' . $uneLigne['NOM'] . '" value="' . $uneLigne['NOM'] . '" name="' . $uneLigne['NOM'] . '">' . $uneLigne['NOM'] . '</option>';
    }
    echo '
                    </select>
                    </div>
                    </div>
                    <input value="Modifier" type="submit"  class="btn btn-success">
                    </div></div></div></div></div></form></div>';


    ?>


    <div role="tabpanel" class="tab-pane" id="rdv">
        <div class="col-lg-13">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Rendez-vous</h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date et heure</th>
                            <th>Durée</th>
                            <th>Élève</th>
                            <th>Matière</th>
                            <th>Commentaires</th>
                            <th>Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $i = 0;
                        // On parcours les rdv
                        $totalHeuresRdv = 0;
                        foreach ($lesRendezvousBsb as $unRdv) {
                            if ($unRdv['ID_INTERVENANT'] == $IntervenantSelectionner['ID_INTERVENANT']) {

                                // On récupère les infos
                                $totalHeuresRdv = ($totalHeuresRdv + $unRdv['DUREE']);
                                $unEleve = $pdo->recupUnEleves($unRdv['ID_ELEVE']);
                                $laMatiere = '';
                                foreach ($lesMatieres as $uneMatiere) {
                                    if ($uneMatiere['ID'] == $unRdv['ID_MATIERE']) {
                                        $laMatiere = $uneMatiere['NOM'];
                                    }
                                }
                                $i++;
                                echo '<tr>
                              <td>' . date("d/m/Y H:i", strtotime($unRdv['DATE_RDV'])) . '</td>
                              <td>' . $unRdv['DUREE'] . 'h</td>
                              <td><a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $unRdv['ID_ELEVE'] . '">' . $unEleve['PRENOM'] . ' ' . $unEleve['NOM'] . '</a></td>
                              <td>' . $laMatiere . '</td>
                              <td>' . $unRdv['COMMENTAIRE'] . '</td>
                              <td>';
                                if ($admin == 2) {
                                    echo '<a href="javascript:if(confirm(\'Voulez-vous vraiment supprimer ce rendez-vous ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerRdv&num=' . $unRdv['ID_RDV'] . '\'; };" class="btn btn-danger"><span class="glyphicon glyphicon-trash" style="width:10px"></span></a>';
                                }
                                echo '</td>
                              </tr>
                              ';
                            }
                        }
                        echo '<tr>
                          <th>Total des heures :</th>
                          <th>' . $totalHeuresRdv . 'h</th>
                          <th colspan="4"></th>
                          </tr></tbody></table></div></div></div>';
                        if ($i == 0) {
                            echo '<center><p><i>Aucun rendez-vous pris</i></p></center>';
                        }
                        ?>
                </div>


                <?php


                echo '
                        <div role="tabpanel" class="tab-pane" id="horaires">
                        <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=ValidationIntervenantsHoraires&intervenants=' . $IntervenantSelectionner['ID_INTERVENANT'] . '&tableau=1">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="main-card mb-3 card">
                                <div class="card-body">

                                <button type="button" class="btn btn-primary" id="reportrange">


                                    <i class="fa fa-calendar pr-1"></i>
                                    <span></span>
                                    <i class="fa pl-1 fa-caret-down"></i>
                                    <input type="hidden" name="debut" id="from" value="">
                                    <input type="hidden" name="fin" id="to" value="">

                                </button>
                        <input type="submit" name="filter" id="filter" value="Filtrer" class="btn btn-info" />';
                echo '</div></div></div></div></form></div>';


                echo '
                        <div role="tabpanel" class="tab-pane" id="presences">
                        <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=PresenceIntervenantIndividuel&intervenants=' . $IntervenantSelectionner['ID_INTERVENANT'] . '">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="main-card mb-3 card">
                                <div class="card-body">

                                <button type="button" class="btn btn-primary" id="reportrange2">


                                    <i class="fa fa-calendar pr-1"></i>
                                    <span></span>
                                    <i class="fa pl-1 fa-caret-down"></i>
                                    <input type="hidden" name="debut" id="from2" value="">
                                    <input type="hidden" name="fin" id="to2" value="">

                                </button>
                        <input type="submit" name="filter2" id="filter2" value="Filtrer" class="btn btn-info" />';
                echo '</div></div></div></div></form></div>';


                echo '
                        <div role="tabpanel" class="tab-pane" id="annees">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="main-card mb-3 card">
                                <div class="card-body">

                        <h4 class="card-title">Années d\'inscription</h4>
                        <div class="scroll-area-sm">
                          <div class="scrollbar-container">
                            <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                              <div class="vertical-timeline-item vertical-timeline-element">
                                <div>

                                  <span class="vertical-timeline-element-icon bounce-in">
                                    <i class="badge badge-dot badge-dot-xl badge-success"></i>
                                  </span>

                        ';
                $i = 0;
                foreach ($lesAnneesInscrites as $uneAnnee) {
                    echo '

                          <div class="vertical-timeline-element-content bounce-in">
                            <h4 class="timeline-title">' . $uneAnnee['ANNEE'] . '-' . ($uneAnnee['ANNEE'] + 1) . '</h4>';
                    if ($admin == 2) {
                        echo '(
                          <a href="index.php?choixTraitement=administrateur&action=supprimerAnneeIntervenant&num=' . $IntervenantSelectionner['ID_INTERVENANT'] . '&annee=' . $uneAnnee['ANNEE'] . '" style="color:red">
                              Désinscrire
                            </a>)

                            ';
                    }
                    echo '
                            <span class="vertical-timeline-element-date">' . $dt1 . '</span>';
                    $nbInscriptionsStages++;
                    echo '            </div>



                             ';


                    $i++;
                }
                echo '</div></div></div></div></div>';

                // Si aucune inscription
                if ($i == 0) {
                    echo '<p>Aucune année inscrite à ce jour.</p>';
                }

                echo '
                        </div></div></div>

                        <div class="col-md-8 h-auto">
                          <div class="main-card mb-3 card">
                            <div class="card-body">
                            <h4 class="card-title">Inscrire à une année</h4>
                        <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=ajoutAnneeIntervenant&num=' . $IntervenantSelectionner['ID_INTERVENANT'] . '">
                          <br>
                        <label for="annee">Année à inscrire</label><br>
                        <input name="annee" placeholder="aaaa" autofocus="" required="" class="form-control" style="width:100px"><br><input value="Inscrire" type="submit"class="btn btn-success">
                        </form></div></div></div>


                        </div></div>';


                echo '<div role="tabpanel" class="tab-pane" id="documents">
                          <div class="row">
                                                              <div class="col-lg-12">
                                                                  <div class="main-card mb-3 card">
                                                                      <div class="card-body">
                        <h4 class="card-title">Documents</h4>
                        <table>
                        <tr>
                        <th style="width:200px;">RIB</th>
                        <td>';
                if ($admin == 2) {
                    if ($IntervenantSelectionner['FICHIER_RIB'] == '') {
                        echo '<i>Aucun fichier envoyé.</i> <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=LesIntervenants">
                            <input type="text" name="unIntervenant" value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" style="display:none">
                            <input class="form-control" name="num"  value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" readonly="readonly" autofocus="" style="display:none">
                            <input type="file" onchange="this.form.submit()" name="fichier_rib" />
                            </form>';
                    } else {
                        echo '<a href="ribIntervenants/' . $IntervenantSelectionner['FICHIER_RIB'] . '">Ouvrir <b>' . $IntervenantSelectionner['FICHIER_RIB'] . '</b></a> (<a href="index.php?choixTraitement=administrateur&action=supprimerUnFichierIntervenant&num=' . $IntervenantSelectionner['ID_INTERVENANT'] . '&fichier=rib" style="color:red">Supprimer</a>)';
                    }
                } else {
                    if ($IntervenantSelectionner['FICHIER_RIB'] == '') {
                        echo '<i>Aucun fichier envoyé.</i>';
                    } else {
                        echo 'RIB envoyé.';
                    }
                }


                echo '</td>
                        </tr>
                        <tr style="height:50px;"></tr>

                        <tr>
                        <th>CV</th>
                        <td>';
                if ($IntervenantSelectionner['FICHIER_CV'] == '') {
                    echo '<i>Aucun fichier envoyé.</i> <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=LesIntervenants">
                          <input type="text" name="unIntervenant" value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" style="display:none">
                          <input class="form-control" name="num"  value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" readonly="readonly" autofocus="" style="display:none">
                          <input type="file" onchange="this.form.submit()" name="fichier_cv" />
                          </form>';
                } else {
                    echo '<a href="cvIntervenants/' . $IntervenantSelectionner['FICHIER_CV'] . '">Ouvrir <b>' . $IntervenantSelectionner['FICHIER_CV'] . '</b></a>  (<a href="index.php?choixTraitement=administrateur&action=supprimerUnFichierIntervenant&num=' . $IntervenantSelectionner['ID_INTERVENANT'] . '&fichier=cv" style="color:red">Supprimer</a>)';
                }
                echo '</td>
                        </tr>

                        <tr style="height:50px;"></tr>

                        <tr>
                        <th>Diplôme</th>
                        <td>';
                if ($IntervenantSelectionner['FICHIER_DIPLOME'] == '') {
                    echo '<i>Aucun fichier envoyé.</i> <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=LesIntervenants">
                          <input type="text" name="unIntervenant" value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" style="display:none">
                          <input class="form-control" name="num"  value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '" readonly="readonly" autofocus="" style="display:none">
                          <input type="file" onchange="this.form.submit()" name="fichier_diplome" />
                          </form>';
                } else {
                    echo '<a href="diplomesIntervenants/' . $IntervenantSelectionner['FICHIER_DIPLOME'] . '">Ouvrir <b>' . $IntervenantSelectionner['FICHIER_DIPLOME'] . '</b></a>  (<a href="index.php?choixTraitement=administrateur&action=supprimerUnFichierIntervenant&num=' . $IntervenantSelectionner['ID_INTERVENANT'] . '&fichier=diplome" style="color:red">Supprimer</a>)';
                }
                echo '</td>
                        </tr>
                        </table>




                        <hr>
                        <h4>Justificatifs, fiches de paie...</h4>

                        <div class="form-group">
                        <form name="frmConsultFrais" method="POST" enctype="multipart/form-data" action="index.php?choixTraitement=administrateur&action=AjouterDocumentIntervenant">
                        <label for="nom">Ajouter un document</label>
                        <input type="hidden" name="num"  value="' . $IntervenantSelectionner['ID_INTERVENANT'] . '">
                        <center><input type="file" onchange="this.form.submit()" name="fichier1" /></center>			</form>
                        </div>

                        <table class="table">
                        <thead>
                        <tr>
                        <th>Nom</th>
                        <th>Date d\'ajout</th>
                        <th>Taille</th>
                        <th colspan="2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>';

                $dir_nom = './documentsIntervenants/' . $IntervenantSelectionner['ID_INTERVENANT'] . '/'; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
                if (file_exists($dir_nom)) {
                    $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
                    $fichier = array(); // on déclare le tableau contenant le nom des fichiers
                    $dossier = array(); // on déclare le tableau contenant le nom des dossiers

                    while ($element = readdir($dir)) {
                        if ($element != '.' && $element != '..') {
                            if (!is_dir($dir_nom . '/' . $element)) {
                                $fichier[] = $element;
                            } else {
                                $dossier[] = $element;
                            }
                        }
                    }
                    closedir($dir);
                    $i = 0;

                    foreach ($fichier as $lien) {
                        $i++; ?>
                        <tr>
                            <td><b><?php echo $lien ?></b></td>
                            <td><?php echo date('d/m/Y H:i', filemtime($dir_nom . '/' . $lien)); ?></td>
                            <td><?php echo ceil(filesize($dir_nom . '/' . $lien) / 1000000); ?> Mo</td>
                            <td><?php if ($admin == 2) { ?><a class="btn btn-primary"
                                                              href="<?php echo $dir_nom . $lien; ?>"><span
                                            class="glyphicon glyphicon-save"></span> Télécharger</a><?php } ?></td>
                            <td><?php if ($admin == 2) { ?><a style="color:white" class="btn btn-danger navbar-right"
                                                              href="index.php?choixTraitement=administrateur&action=supprimerUnDocumentIntervenant&num=<?php echo $IntervenantSelectionner['ID_INTERVENANT']; ?>&fichier=<?php echo $lien; ?>">
                                        <span class="glyphicon glyphicon-trash"></span> Supprimer</a><?php } ?></td>
                        </tr>

                        <?php
                    }
                    if ($i == 0) {
                        echo '<tr><td colspan="4"><i>Aucun document ajouté pour le moment.</i></td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="4"><i>Aucun document ajouté pour le moment.</i></td></tr>';
                }
                echo '</tbody></table>

                          </div></div></div></div></div>';
                }
                ?>
                <script type="text/javascript">

                    Affiche(Onglet_afficher);

                </script>

                <p>

            </div>

            <script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
            <script type="text/javascript"
                    src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>

            <script src="vues/administrateur/croppie.js"></script>
            <script type="text/javascript" src="./js/form-components/input-select.js"></script>


            <script type="text/javascript" src="./vendors/moment/min/moment-with-locales.js"></script>
            <script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/dist/datepicker.min.js"></script>
            <script type="text/javascript" src="./vendors/daterangepicker/daterangepicker.js"></script>
            <script type="text/javascript" src="./vendors/countup.js/dist/countUp.js"></script>
            <script type="text/javascript" src="./js/form-components/datepicker.js"></script>


            <script>

                $(document).ready(function () {

                    $(function () {
                        $("#from").datepicker();
                        $("#to").datepicker();
                    });

                    $('#filter').click(function () {
                        var from_date = $('#from').val();
                        var to_date = $('#to').val();

                    });

                    $(function () {
                        $("#from2").datepicker();
                        $("#to2").datepicker();
                    });

                    $('#filter2').click(function () {
                        var from_date2 = $('#from2').val();
                        var to_date2 = $('#to2').val();

                    });

                });
            </script>


            <!-- Début webcam_new -->
            <script type="text/javascript">
                //All the files, with PHP and ASP server side files are here for you to download: https://vamapaull.com/html5-webcam-photobooth-web-app/

                var context;
                var width = 320; //set width of the video and image
                var height = 240; //only used for the Flash fallback

                //this function is used to receive the image from the Flash Player, if Flash is used.
                function imageResult(data, videoWidth, videoHeight) {
                    var imageData = "data:image/png;base64," + data;
                    var image = new Image;
                    image.onload = function () {
                        context.drawImage(this, 0, 0);
                    };
                    image.src = imageData;
                }

                //wait for the document to load and then initiate the application
                document.addEventListener("DOMContentLoaded", init);

                function init() {
                    var isFlash = false;
                    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
                    var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer, Inc/.test(navigator.vendor);

                    var video = document.querySelector("#video");
                    video.width = width;

                    var canvas = document.getElementById("canvas");
                    canvas.style.width = width + "px";
                    canvas.width = width;

                    context = canvas.getContext("2d");

                    if ((isChrome || isSafari) && window.location.protocol == "http:") {
                        document.getElementById("savedImages").innerHTML = "<h1>This browser only supports camera streams over https:</h1>";
                    } else {
                        startWebcam();
                    }

                    function startWebcam() {
                        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mediaDevices || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

                        if (navigator.mediaDevices) {
                            navigator.mediaDevices.getUserMedia({video: true}, handleVideo, videoError).then(function (stream) {
                                video.onloadedmetadata = setHeight;
                                document.getElementById("buttonCapture").disabled = false;
                                return video.srcObject = stream;
                            }).catch(function (e) {
                                console.log(e.name + ": " + e.message);

                                document.getElementById("buttonCapture").disabled = true;

                                switch (e.name) {
                                    case "NotAllowedError":
                                        document.getElementById("savedImages").innerHTML = "<i class='messageWebcam'>Vueillez accorder votre permission si vous souhaitez capturer une image a partir de la webcam</i>";
                                        break;
                                    case "NotReadableError":
                                        document.getElementById("savedImages").innerHTML = "<i class='messageWebcam'>La webcam n'est pas disponible. Assurez vous qu'elle n'est pas utilisé dans une autre application</i>";
                                        break;
                                    case "NotFoundError":
                                        document.getElementById("savedImages").innerHTML = "<i class='messageWebcam'>Aucune webcam trouvé. Assurez-vous que votre webcam est bien branché a votre ordinateur</i>";
                                        break;
                                }
                            });
                        } else {
                            canvas.style.height = height + "px";
                            canvas.height = height;

                            document.getElementById("buttonCapture").disabled = false;
                            isFlash = true;
                            video.style.display = "none";
                            document.getElementById("fallback").style.display = "block";

                            var script = document.createElement("script");
                            document.getElementsByTagName("head")[0].appendChild(script);
                            script.type = "text/javascript";
                            script.onload = function () {
                                var flashvars = {};

                                var parameters = {};
                                parameters.scale = "noscale";
                                parameters.wmode = "transparent";
                                parameters.allowFullScreen = "true";
                                parameters.allowScriptAccess = "always";
                                parameters.bgColor = "#999999";

                                var attributes = {};
                                attributes.name = "FlashWebcam";

                                swfobject.embedSWF("fallback/webcam_fallback.swf", "fallback", width, height, "27", "expressInstall.swf", flashvars, parameters, attributes);
                            }
                            script.src = "fallback/swfobject.js";
                        }

                        function thisMovie(movieName) {
                            if (navigator.appName.indexOf("Microsoft") != -1) {
                                return window[movieName];
                            } else {
                                return document[movieName];
                            }
                        }

                        function handleVideo(stream) {
                            video.src = window.URL.createObjectURL(stream);
                        }

                        function videoError(e) {
                            document.getElementById("savedImages").innerHTML = "<h3>" + e + "</h3>";
                        }

                        function setHeight() {
                            var ratio = video.videoWidth / video.videoHeight;
                            height = width / ratio;
                            canvas.style.height = height + "px";
                            canvas.height = height;
                        }

                        //add event listener and handle the capture button
                        document.getElementById("buttonCapture").addEventListener("mousedown", handleButtonCaptureClick);

                        function handleButtonCaptureClick() {
                            console.log("style: " + document.getElementById("canvas").style.display)
                            if (document.getElementById("canvas").style.display == "none" || document.getElementById("canvas").style.display == "") {
                                document.getElementById("canvas").style.display = "block";
                                document.getElementById("buttonCapture").innerHTML = "Re-capturer";
                                if (isFlash) {
                                    thisMovie("FlashWebcam").capture();
                                } else {
                                    setHeight();
                                    context.drawImage(video, 0, 0, width, height);
                                }

                                document.getElementById("buttonSave").innerHTML = "Sauvegarder";
                                document.getElementById("buttonSave").disabled = false;
                            } else {
                                makeCaptureButton();
                            }
                        }

                        function makeCaptureButton() {
                            document.getElementById("canvas").style.display = "none";
                            document.getElementById("buttonCapture").innerHTML = "Capturer";
                            document.getElementById("buttonSave").innerHTML = "Sauvegarder";
                            document.getElementById("buttonSave").disabled = true;
                        }

                        //add event listener and handle the save button
                        document.getElementById("buttonSave").addEventListener("mousedown", handleButtonSaveClick);

                        function handleButtonSaveClick() {
                            var dataURL = canvas.toDataURL("image/jpg");
                            var xhr = new XMLHttpRequest();
                            var intervenant = <?php echo json_encode($IntervenantSelectionner['ID_INTERVENANT']); ?>;
                            xhr.open("POST", "index.php?choixTraitement=administrateur&action=modifierPhotoIntervenant"); //change this to .php or .asp, depending on your server
                            xhr.onload = function () {
                                if (xhr.readyState == 4) {
                                    if (xhr.status == 200) {
                                        var image = new Image();
                                        image.src = "../photosIntervenants/" + xhr.responseText;
                                        document.getElementById("buttonSave").innerHTML = "Sauvegardé";
                                        document.getElementById("buttonSave").disabled = true;
                                        makeCaptureButton();
                                    }
                                }
                            };
                            var form = new FormData();
                            form.append("image_webcam", dataURL);
                            form.append("num", intervenant);
                            xhr.send(form);
                            //$("form[id='LesElevesForm']").submit();
                        }
                    }
                }
            </script>
            <!-- Fin webcam_new -->


            <script>

                var intervenant = <?php echo json_encode($IntervenantSelectionner['ID_INTERVENANT']); ?>;

                $(document).ready(function () {

                    $image_crop = $('#image_demo').croppie({
                        enableExif: true,
                        viewport: {
                            width: 150,
                            height: 150,
                            type: 'square' //circle
                        },
                        boundary: {
                            width: 310,
                            height: 310
                        }
                    });

                    $('#upload_image').on('change', function () {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            $image_crop.croppie('bind', {
                                url: event.target.result
                            }).then(function () {
                                console.log('jQuery bind complete');
                            });
                        }
                        reader.readAsDataURL(this.files[0]);
                        $('#uploadimageModal').modal('show');
                    });

                    $('.crop_image').click(function (event) {
                        $image_crop.croppie('result', {
                            type: 'canvas',
                            size: 'viewport'
                        }).then(function (response) {
                            $.ajax({
                                url: "index.php?choixTraitement=administrateur&action=modifierPhotoIntervenant",
                                type: "POST",
                                data: {"image": response, "num": intervenant},
                                success: function (data) {
                                    $('#uploadimageModal').modal('hide');
                                    $('#uploaded_image').html(data);
                                    $("form[id='LesIntervenantsForm']").submit();
                                }
                            });
                        })
                    });
                });
            </script>
