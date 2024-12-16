<link rel="stylesheet" href="vues/administrateur/croppie.css"/>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Fiche élève
                <?php
                if (isset($num)) {
                    echo '<div class="page-title-subheading">' . $eleveSelectionner["PRENOM"] . ' ' . $eleveSelectionner["NOM"] . '</div>';
                } else {
                    echo '<div class="page-title-subheading">Sélectionner un élève pour accéder à sa fiche</div>';
                }
                ?>
            </div>
        </div>
        <?php if (isset($eleveSelectionner)) { ?>
        <div class="page-title-actions">
        <div class="d-inline-block dropdown">
        <a style="float:left" href="index.php?choixTraitement=administrateur&action=macarte&eleve=<?= $eleveSelectionner["ID_ELEVE"] ?>">
          <button type="button" class="mr-2 btn btn-success">
            <span class="glyphicon glyphicon-plus">Télécharger ma carte</span>
          </button>
        </a>
        <a style="float:left" href="#" id="print-card" data-eleve-id="<?= $eleveSelectionner["ID_ELEVE"] ?>">
            <button type="button" class="mr-2 btn btn-success">
                <span class="glyphicon glyphicon-plus">Imprimer ma carte</span>
            </button>
        </a>
        </div>
        </div>
        <?php } ?>

        <?php if (isset($eleveSelectionner) && $admin == 2) {
            echo '
        <div class="page-title-actions">
        <div class="d-inline-block dropdown">


        <a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette inscription ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerUnEleve&num=' . $eleveSelectionner['ID_ELEVE'] . '\'; } else { void(0); }" class="btn btn-danger" style="float:right">
        <button type="button" class="btn btn-danger" value="">
        <span class="btn-icon-wrapper pr-2 opacity-7">
        <i class="fa fa-print fa-w-20"></i>
        </span>
        Supprimer la fiche complète de l\'élève
        </button>
        </a>
        </div>
        </div>
        ';
        } ?>


    </div>
</div>
<form name="frmConsultFrais" id="LesElevesForm" method="POST"
      action="index.php?choixTraitement=administrateur&action=LesEleves">


    <center>
        <div class="col-md-4">
            <select name="unEleve" onchange="this.form.submit()" class="multiselect-dropdown form-control"
                    data-live-search="true">
                <option disabled="disabled" selected="selected">Choisir</option>
                <?php foreach ($lesEleves as $unEleve) {
                    if (isset($eleveSelectionner) and $unEleve['ID_ELEVE'] == $eleveSelectionner['ID_ELEVE']) {
                        $selectionner = "selected='selected'";
                    } else {
                        $selectionner = "";
                    }


                    echo " <option " . $selectionner . " value='" . $unEleve['ID_ELEVE'] . "' name='unEleve'>" . $unEleve['NOM'] . " " . $unEleve['PRENOM'] . "</option>";
                }
                echo '</select></div></center></form>';


                if (isset($_GET['num'])) {
                    $eleveSelectionner = $pdo->recupUnEleves($_GET['num']);
                }

                if (isset($eleveSelectionner))
                {

                //// TODO: mettre ce bout de code dans upload.php
                // si une photo est envoyée
                if (isset($_FILES['fichier']) or isset($_POST['photo_data'])) {

                    // si c'est une image de la webcam
                    if ($_POST['photo_data'] != '') {

                        $photo = $_POST['photo_data'];

                        // on enregistre l'image
                        $photo = base64_decode(substr($photo, 22));
                        $nom_photo = $_POST['num'] . '_photo.png';
                        file_put_contents('/home/associatry/www/extranet/photosEleves/' . $nom_photo, $photo);


                        $pdo->modifierPhotoEleve($nom_photo, $_POST['num']);

                        //$pdo->executerRequete2('UPDATE `eleves` SET `PHOTO` = "' . $nom_photo . '" WHERE `ID_ELEVE` = '.$_POST['num']);
                        $eleveSelectionner['PHOTO'] = $nom_photo;

                    } else {

                        //c'est un fichier, on stock le fichier
                        move_uploaded_file($_FILES['fichier']['tmp_name'], 'photosEleves/' . $_POST['num'] . '_' . basename($_FILES['fichier']['name']));
                        $photo = $_POST['num'] . '_' . $_FILES['fichier']['name'];


                        //$pdo->executerRequete2('UPDATE `eleves` SET `PHOTO` = "' . $photo . '" WHERE `ID_ELEVE` = '.$_POST['num']);
                        $pdo->modifierPhotoEleve($photo, $_POST['num']);

                        $eleveSelectionner['PHOTO'] = $photo;
                    }
                }

                echo ' <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=LesEleves">
          <input type="text" name="unEleve" value="' . $eleveSelectionner['ID_ELEVE'] . '" style="display:none">';
                $string_a_coder = $eleveSelectionner['CODEBARRETEXTE'];

                if ($eleveSelectionner['PHOTO'] == "") {
                    $photo = "AUCUNE.jpg";
                } else {
                    $photo = $eleveSelectionner['PHOTO'];
                }
                echo '<center><div class="col-md-4"><div class="main-card mb-3 card">

          <div class="card-body">
          <img width="200" height="200" style="box-shadow: 1px 1px 20px #555;image-orientation: 0deg;"  src="photosEleves/' . $photo . '" >
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


                                    <script>

                                        var eleve = <?php echo json_encode($eleveSelectionner['ID_ELEVE']); ?>;

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
                                                        url: "index.php?choixTraitement=administrateur&action=modifierPhotoEleve",
                                                        type: "POST",
                                                        data: {"image": response, "num": eleve},
                                                        success: function (data) {
                                                            $('#uploadimageModal').modal('hide');
                                                            $('#uploaded_image').html(data);
                                                            $("form[id='LesElevesForm']").submit();
                                                        }
                                                    });
                                                })
                                            });
                                        });
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

                <input class="form-control" name="num" value="<?php echo $eleveSelectionner['ID_ELEVE']; ?>"
                       readonly="readonly" autofocus="" style="display:none">
</form>


<!--
<ul class="nav nav-tabs" id="onglets"  role="tablist">
<li role="presentation" class="active"><a href="#infos" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-file"></span> Informations</a></li>
<li role="presentation"><a href="#responsable" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-home"></span> Parents</a></li>
<li role="presentation"><a href="#evenements" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-list"></span> Evènements</a></li>
<li role="presentation"><a href="#reglements" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-tag"></span> Réglements</a></li>
<li role="presentation"><a href="#scolarite" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-education"></span> Scolarité</a></li>
<li role="presentation"><a href="#presences" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-calendar"></span> Présences</a></li>
<li role="presentation"><a href="#rdv" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-pushpin"></span> Rendez-vous</a></li>
</ul>
-->

<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                    <li class="nav-item">
                        <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#infos">
                            <span>Informations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#responsable">
                            <span>Parents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#activites">
                            <span>Activités</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-3" data-toggle="tab" href="#reglements">
                            <span>Règlements</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-4" data-toggle="tab" href="#scolarite">
                            <span>Scolarité</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-5" data-toggle="tab" href="#presences">
                            <span>Présences</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-6" data-toggle="tab" href="#rdv">
                            <span>Rendez-vous</span>
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

<?php if (isset($eleveSelectionner)) { ?>
    <script>
        $('#print-card').on('click', function () {
            const {origin, pathname} = document.location;
            const studId = $(this).attr('data-eleve-id');

            const iframe = document.createElement('iframe');
            iframe.style.maxHeight = '10px';
            iframe.style.maxWidth = '10px';
            iframe.src = `${origin}${pathname}?choixTraitement=administrateur&action=macarte&eleve=${studId}&print=true`;
            $('#LesElevesForm').append(iframe);
        });
    </script>
<?php } ?>

<div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="infos">
        <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
              action="index.php?choixTraitement=administrateur&action=LesElevesModifier">
            <div class="form-group">
                <?php echo '

                        <div class="row">
                        <div class="col-md-12">
                        <div class="main-card mb-3 card">
                        <div class="card-body">
                        <h4 class="card-title">Élève</h4>
                        <div class="row">
                        <div class="position-relative form-group col-md-12">
                        <label for="num" class="">Numéro</label>
                        <input class="form-control" name="num"  value="' . $eleveSelectionner['ID_ELEVE'] . '" readonly="readonly" autofocus="" style="max-width:300px;">
                        </div>
                        </div>
                        <div class="row">
                        <div class="position-relative form-group col-md-4">
                        <label for="nom" class="required">Nom</label>
                        <input class="form-control" name="nom" placeholder="Votre nom" value="' . $eleveSelectionner['NOM'] . '" autofocus="" >
                        </div>
                        <div class="position-relative form-group col-md-4">
                        <label for="prenom" class="required">Prénom</label>
                        <input class="form-control" name="prenom" placeholder="Votre prénom" value="' . $eleveSelectionner['PRENOM'] . '" autofocus="" >
                        </div>

                        <div class="position-relative form-group col-md-4">
                        <label for="sexe" class="required">Sexe</label>
                        <select name="sexe" class="form-control">';

                if ($eleveSelectionner['SEXE'] == "F") {
                    echo '<option value="F" selected="selected" name="sexe">Femme</option>
                          <option value="H" name="sexe">Homme</option>';
                } else {
                    echo '<option value="F"  name="sexe">Femme</option>
                            <option value="H" selected="selected" name="sexe">Homme</option>';
                }


                echo '</select>  </div>';
                list($annee, $mois, $jour) = explode('-', $eleveSelectionner['DATE_DE_NAISSANCE']);
                $dateFrancais = $jour . "-" . $mois . "-" . $annee;
                echo '



                            <div class="position-relative form-group col-md-4">
                            <label for="date_naissance" class="required">Date de naissance</label> <br>';
                formulaireDate($jour, $mois, $annee, "date_naissance");
                echo '
                            </div>

                            <div class="position-relative form-group col-md-4">
                            <label for="tel_enfant" class="">Téléphone de l\'enfant</label>
                            <input class="form-control" name="tel_enfant"  value="' . $eleveSelectionner['TÉLÉPHONE_DE_L_ENFANT'] . '" autofocus="" >
                            </div>
                            <div class="position-relative form-group col-md-4">
                            <label for="email_enfant" class="">Email de l\'enfant</label>
                            <input class="form-control" name="email_enfant" placeholder="xxxx@xxxxx.xx" value="' . $eleveSelectionner['EMAIL_DE_L_ENFANT'] . '"  type="email">
                            </div>
                            </div>
                            <button type="submit" class="mt-1 btn btn-primary ">Modifier</button>
                            </div>
                            </div>
                            </div>
                            </div>

                            </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="responsable">


                            <div class="row">
                            <div class="col-12 mb-3">
                                <button type="submit" class="btn btn-success w-100">Modifier</button>
                            </div>
                            <div class="col-md-6">
                            <div class="main-card mb-3 card">
                            <div class="card-body">
                            <h4 class="card-title">Parents</h4>

<div class="position-relative form-group">
                            <label for="responsable_legal" class="required">Nom et prénom du responsable légal </label>
                            <input class="form-control" name="responsable_legal"  autofocus="" value="' . $eleveSelectionner['RESPONSABLE_LEGAL'] . '" style="max-width:200px;">
</div>
                            <div class="form-row">
                              <div class="col-md-6">
                            <label for="profession_pere">Profession du père</label>
                            <input class="form-control" name="profession_pere"  autofocus="" value="' . $eleveSelectionner['PROFESSION_DU_PÈRE'] . '" >
  </div>
                              <div class="col-md-6">
                            <label for="profession_mere">Profession de la mère</label>
                            <input class="form-control" name="profession_mere"  autofocus="" value="' . $eleveSelectionner['PROFESSION_DE_LA_MÈRE'] . '" >
                              </div>
                                </div>

                            <div class="position-relative form-group">
                            <label for="adresse" class="required">Adresse</label>
                            <input class="form-control" name="adresse"  autofocus="" value="' . $eleveSelectionner['ADRESSE_POSTALE'] . '" style="max-width:500px;">
                            </div>
                            <div class="form-row">
                              <div class="col-md-4">

                            <label for="cp" class="required">Code postal</label>
                            <input class="form-control" name="cp"  autofocus="" value="' . $eleveSelectionner['CODE_POSTAL'] . '" >
                            </div>

                              <div class="col-md-8">
                            <label for="ville" class="required">Ville</label>
                            <input class="form-control" name="ville"  autofocus="" value="' . $eleveSelectionner['VILLE'] . '" >
                          </div>
                        </div>



                            <!--</form>-->
                            </div>
                            </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                       <div class="position-relative form-group col-md-8">
                                            <h4 class="card-title">Fratries</h4>
                                            
                                            <label for="select-fratries-eleves">Sélectionner les frere et soeurs :</label>
                                            <select id="select-fratries-eleves" class="multiselect-dropdown form-control" data-live-search="true">';
                                                foreach ($lesEleves as $unEleve) {
                                                    $selected = "";
                                                    if ($unEleve['ID_ELEVE'] == $eleveSelectionner['ID_ELEVE']) {
                                                        $selected = ' disabled="true"';
                                                    }
                                                    if ($selected == "" and $unEleve['NOM'] === $eleveSelectionner['NOM']) {
                                                        $selected = ' selected="selected"';
                                                    }
                                                    echo '<option value="' . $unEleve['ID_ELEVE'] . '" ' . $selected . '>' . $unEleve['NOM'] . ' ' . $unEleve['PRENOM'] . '</option>';
                                                }
                                            echo '</select>
                                            <div class="mt-3 mb-5">
                                                <button type="button" class="btn btn-primary" onclick="addFratries(' . $eleveSelectionner['ID_ELEVE'] . ')">Ajouter à la liste</button>
                                            </div>
                                            <ul class="list-group">';
                                                foreach ($lesFratries as $uneFratrie) {
                                                    echo '<li class="list-group-item">' . $uneFratrie['NOM'] . ' ' . $uneFratrie['PRENOM'] . ' 
                                                        <a href="index.php?choixTraitement=administrateur&action=SuprimmerFratries&unEleve=' . $uneFratrie['ID_ELEVE'] . '" class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash"></i></a>
                                                        <a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $uneFratrie['ID_ELEVE'] . '" class="btn btn-primary btn-xs pull-right" style="margin-right: 5px;"><i class="fa fa-user"></i></a>
                                                    </li>';
                                                }
                                            echo '</ul>
                            
                                            <script>
                                                function addFratries(eleveid) {
                                                    var select = document.getElementById("select-fratries-eleves");
                                                    var selectedItemId = select.options[select.selectedIndex].value;
                                                    
                                                    window.location.href = "index.php?choixTraitement=administrateur&action=AjouterFratries&unEleve=" + eleveid + "&uneFratrie=" + selectedItemId;
                                                }
                                            </script>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                            <div class="main-card mb-3 card">
                            <div class="card-body">
                            <h4 class="card-title">Contact</h4>

                            <div class="form-row">
                            <div class="col-md-6">
                            <label for="tel_parent" class="required">Téléphone des parents 1 (portable)</label>
                            <input class="form-control" name="tel_parent"  autofocus="" value="' . $eleveSelectionner['TÉLÉPHONE_DES_PARENTS'] . '" style="max-width:200px;">
                            </div>
                            <div class="col-md-6">
                            <label for="tel_parent">Téléphone des parents 2 (fixe)</label>
                            <input class="form-control" name="tel_parent2"  autofocus="" value="' . $eleveSelectionner['TÉLÉPHONE_DES_PARENTS2'] . '" style="max-width:200px;">
                            </div>
                            </div>
                            <div class="position-relative form-group">
                            <label for="tel_parent">Téléphone des parents 3 (autre...)</label>
                            <input class="form-control" name="tel_parent3"  autofocus="" value="' . $eleveSelectionner['TÉLÉPHONE_DES_PARENTS3'] . '" style="max-width:200px;">
                            </div>
                            <div class="position-relative form-group">
                            <label for="email_parent">Email des parents</label>
                            <input class="form-control" name="email_parent" placeholder="xxxx@xxxxx.xx" value="' . $eleveSelectionner['EMAIL_DES_PARENTS'] . '"   type="email" style="max-width:300px;">
                            </div>
                            <!--</form>-->
                            </div>
                            </div>
                            




                            <div class="main-card mb-3 card">
                            <div class="card-body">
                            <h4 class="card-title">Absence</h4>

                            <fieldset class="position-relative form-group">
                            <div class="position-relative form-check">
                            <label for="prevenir_parent">Voulez-vous être prévenu en cas d\'absence de votre enfant ?</label>
                            ';


                echo '
                            <br>
                            <div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">';
                if ($eleveSelectionner["PRÉVENIR_EN_CAS_D_ABSENCE"] == "1") {
                    echo '
                              <label class="btn btn-warning">
                              <input type="radio" value="1" name="prevenir_parent" checked autocomplete="off">
                              Oui
                              </label>
                              <label class="btn btn-warning">
                              <input type="radio" value="0" name="prevenir_parent" autocomplete="off">
                              Non
                              </label>
                              ';
                } else {
                    echo '
                              <label class="btn btn-warning">
                              <input type="radio" value="1" name="prevenir_parent" autocomplete="off">
                              Oui
                              </label>
                              <label class="btn btn-warning">
                              <input type="radio" value="0" name="prevenir_parent" checked autocomplete="off">
                              Non
                              </label>
                              ';
                }
                echo '</div>
                              ';

                echo '
                              </div>


                              </fieldset>

                              </div>
                              </div>
                              <div class="main-card mb-3 card">
                              <div class="card-body">
                              <h4 class="card-title">CAF</h4>

                              <fieldset class="position-relative form-group">
                              <div class="position-relative form-check">
                              <label for="assurance">Quotient familial de la CAF inférieur à 800€ ?</label><br>
                              <div role="group" class="btn-group btn-group-toggle" data-toggle="buttons">';
                if ($eleveSelectionner['ASSURANCE_PÉRISCOLAIRE'] == "1") {
                    echo '<label class="btn btn-warning">
                                <input type="radio" value="1" name="CAF" checked autocomplete="off">
                                Oui
                                </label>
                                <label class="btn btn-warning">
                                <input type="radio" value="0" name="CAF" autocomplete="off">
                                Non
                                </label>';
                } else {
                    echo '<label class="btn btn-warning">
                                <input type="radio" value="1" name="CAF" autocomplete="off">
                                Oui
                                </label>
                                <label for="CAF" class="btn btn-warning">
                                <input type="radio" value="0" name="CAF" checked autocomplete="off">
                                Non
                                </label>';
                }
                echo '
                              </div>
                              </div>
                              </fieldset>

                              </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                            <div class="main-card mb-3 card">
                            <div class="card-body">
                            <h4 class="card-title">Observations</h4>

                            <textarea  class="form-control" name="commentaires" cols="30" rows="10">' . $eleveSelectionner['COMMENTAIRES'] . '</textarea>

                            <br>
                            <h4 class="card-title">Contact avec les parents</h4>
                            <textarea  class="form-control" name="contactParents">' . $eleveSelectionner['CONTACT_AVEC_LES_PARENTS'] . '</textarea>
                            </div>
                            </div>
                            <div class="main-card mb-3 card">

                            </div>
                              <div class="main-card mb-3 card">
                              <div class="card-body">
                              <h4 class="card-title">Paiement</h4>
    
                              <fieldset>
                              <input name="numAllocataire" type="hidden" autofocus="" value="' . $eleveSelectionner['N°_ALLOCATAIRE'] . '" >
                              <label for="nombreTempsLibres">Nombre temps libres</label><br>
                              <input class="form-control" name="nombreTempsLibres"  autofocus="" value="' . $eleveSelectionner['NOMBRE_TPS_LIBRE'] . '" style="max-width:100px;">
                              </fieldset>
    
                              </div>
                              </div>
                            </div>
                              </form>


                              </div>


                              </div>

                              ';


                echo '<div role="tabpanel" class="tab-pane" id="activites">

                              <fieldset>


                              <div class="col-md-12">
                              <div class="main-card mb-3 card">
                              <div class="card-body">
                              <form name="frmC" method="POST" action="index.php?choixTraitement=administrateur&action=AjoutEvenementAEleve&num=' . $eleveSelectionner['ID_ELEVE'] . '">


                              <div class="input-group" style="left : 35%; top: 50%;">


                              <select class="form-control" name="evenement" style="max-width:300px">';
                foreach ($lesEvenements as $unEvenement) {
                    echo " <option value='" . $unEvenement['NUMÉROEVENEMENT'] . "' name='evenement'>" . $unEvenement['EVENEMENT'] . "</option>";
                }


                echo '</select>

                              <div class="input-group-addon input-group-button">
                              <input value="Inscription" type="submit" class="btn btn-success">
                              </div>
                              </div>
                              </form>
                              </div>
                              </div>
                              </div>



                              <div class="row">




                              <div class="col-md-4">
                              <div class="main-card mb-3 card">
                              <div class="card-body">
                              <h4 class="card-title">L\'élève est inscrit aux stages suivants</h4>
                              <div class="scroll-area-sm">
                              <div class="scrollbar-container">
                              <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                              <div class="vertical-timeline-item vertical-timeline-element">
                              <div>

                              <span class="vertical-timeline-element-icon bounce-in">
                              <i class="badge badge-dot badge-dot-xl badge-success"></i>
                              </span>



                              ';


                $nbInscriptionsStages = 0;
                foreach ($lesStages as $unStage) {
                    $date = $unStage["DATEDEB_STAGE"];
                    $dt = DateTime::createFromFormat('Y-m-d', $date);
                    $dt1 = $dt->format('d-m');


                    $idInscriptionStage = $pdo->getIdInscriptionStage($unStage['ID_STAGE'], $eleveSelectionner['ID_ELEVE']);
                    // Si l'élève est inscrit au stage
                    if ($idInscriptionStage != '') {
                        // On enregistre le nb de présences
                        $nbPresencesStages = $pdo->nbPresencesStage($unStage['ID_STAGE'], $idInscriptionStage);
                        echo '<div class="vertical-timeline-element-content bounce-in">
                                  <h4 class="timeline-title"><a href="index.php?choixTraitement=administrateur&action=Stages&unStage=' . $unStage['ID_STAGE'] . '">' . stripslashes($unStage['NOM_STAGE']) . '</a></h4>
                                  <span class="vertical-timeline-element-date">' . $dt1 . '</span>';
                        $nbInscriptionsStages++;
                        echo '            </div><br>
                                  ';
                        $nbInscriptionsStages++;
                    }
                }
                if ($nbInscriptionsStages == 0) {
                    echo '<div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title">Aucune inscription pour l\'instant</h4>
                                <span class="vertical-timeline-element-date pe-7s-close-circle"></span>  </div>';
                }


                echo '
                                </div>
                                </div>






                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>




                                <div class="col-lg-8">
                                <div class="main-card mb-3 card">
                                <div class="card-body">
                                ';
                if (count($lesEvenementsEleve) != 0) {
                    echo '
                                  <h4 class="card-title">L\'élève est inscrit sur ces évènements</h4>
                                  <table class="mb-0 table table-hover">
                                  <thead>
                                  <tr>
                                  <th>N° Évènement</th>
                                  <th>Évènement</th>
                                  <th>Date de début</th>
                                  <th>Date de fin</th>
                                  <th>Coûts par enfant</th>
                                  <th>Nb participants</th>
                                  <th>Annuler ?</th>
                                  <th>Supprimer</th>
                                  </tr>
                                  </thead>
                                  <tbody>';
                    foreach ($lesEvenementsEleve as $uneligne) {
                        if ($uneligne['ANNULER'] == 1) {
                            $ANNULER = "Oui";
                        } else {
                            $ANNULER = "Non";
                        }
                        // extraction des jour, mois, an de la date
                        list($annee, $mois, $jour) = explode('-', $uneligne['DATEDEBUT']);
                        $dateFrancaisDebut = $jour . "-" . $mois . "-" . $annee;
                        // extraction des jour, mois, an de la date
                        list($annee, $mois, $jour) = explode('-', $uneligne['DATEFIN']);
                        $dateFrancaisFin = $jour . "-" . $mois . "-" . $annee;

                        echo '<tr>
                                    <tr>
                                    <td >' . $uneligne["NUMÉROEVENEMENT"] . '</td>
                                    <td >' . $uneligne["EVENEMENT"] . '</td>
                                    <td >' . $dateFrancaisDebut . '</td>
                                    <td >' . $dateFrancaisFin . '</td>
                                    <td >' . $uneligne["COUTPARENFANT"] . ' €</td>
                                    <td >' . $uneligne ["NBPARTICIPANTS"] . '</td>
                                    <td >' . $ANNULER . '</td>
                                    <td>
<a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette inscription ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=suppInscriptionEvenements&eleve=' . $eleveSelectionner["ID_ELEVE"] . '&num=' . $uneligne["NUMÉROEVENEMENT"] . '\'; } else { void(0); }" class="btn btn-danger" style="float:right">
                                    <span class="pe-7s-trash"></span></a>
                                    </td>
                                    </tr>';
                    }
                    echo '
                                  </tbody>
                                  </table>
                                  ';
                } else {
                    echo 'L\'élève n\'est inscrit à aucunes activités';
                }
                echo '
                                </div>
                                </div>
                                </div>






                                </div>


                                <br><hr><br>







                                </fieldset></div>';


                echo '<div role="tabpanel" class="tab-pane" id="reglements">
                                <div class="col-lg-13">
                                <div class="main-card mb-3 card">
                                <div class="card-body">

                                ';

                echo "<p align='right'><a href='index.php?choixTraitement=administrateur&action=ajoutReglement&num=" . $eleveSelectionner['ID_ELEVE'] . "' class='btn btn-success'><span class='glyphicon glyphicon-plus'></span> Ajouter</a></p>";
                if (count($lesReglementsEleve) != 0) {
                    echo '

                                  <h4 class="card-title">Règlements</h4>
                                  <table class="mb-0 table table-hover">
                                  <thead>
                                  <table class="table">
                                  <thead>
                                  <tr>
                                  <th>Date</th>
                                  <th>Nom</th>
                                  <th>Pour</th>
                                  <th>Type</th>
                                  <th>N° transaction</th>
                                  <th>Banque</th>
                                  <th>Montant</th>
                                  <th>Infos</th>
                                  <th colspan="3">Actions</th>
                                  </tr>
                                  </thead>
                                  <tbody>';
                    foreach ($lesReglementsEleve as $uneligne) {
                        $pourHTML = "";
                        $eleves = $pdo->recupeElevesWithReglement($uneligne['ID']);
                        foreach ($eleves as $unEleve) {
                            if ($unEleve['ID_ELEVE'] == $eleveSelectionner['ID_ELEVE']) {
                                $pourHTML = "<strong>" . $unEleve['NOM'] . " " . $unEleve['PRENOM'] . "</strong><br>" . $pourHTML;
                            } else {
                                $pourHTML .= $unEleve['NOM'] . " " . $unEleve['PRENOM'] . "<br>";
                            }
                        }
                        $inforeglement = "";
                        if (isset($uneligne['ID_INFO_REGLEMENT']) and !is_null($uneligne['ID_INFO_REGLEMENT'])) {
                            $infos = $pdo->getInfosReglement($uneligne['ID_INFO_REGLEMENT']);
                            if (isset($infos['SOUTIEN'])) {
                                if ($infos['SOUTIEN'] == 1) {
                                    $inforeglement .= 'Soutien<br>';
                                }
                            }
                            if (isset($infos['ADESION_CAF'])) {
                                if ($infos['ADESION_CAF'] == 1) {
                                    $inforeglement .= 'Adhésion CAF<br>';
                                }
                            }
                            if (isset($infos['ADESION_TARIF_PLEIN'])) {
                                if ($infos['ADESION_TARIF_PLEIN'] == 1) {
                                    $inforeglement .= 'Adhésion<br>';
                                }
                            }
                            if (isset($infos['STAGE'])) {
                                if ($infos['STAGE'] == 1) {
                                    $inforeglement .= 'Stage<br>';
                                }
                            }
                            if (isset($infos['DONS'])) {
                                if ($infos['DONS'] == 1) {
                                    $inforeglement .= 'Dons<br>';
                                }
                            }
                        }
                        echo "<tr>

                                    <td>" . date('d/m/Y', strtotime($uneligne['DATE_REGLEMENT'])) . "</td>
                                    <td>" . $uneligne['NOMREGLEMENT'] . "</td>
                                    <td>" . $pourHTML . "</td>
                                    <td>" . $uneligne['NOM'] . "</td>
                                    <td>" . $uneligne['NUMTRANSACTION'] . "</td>
                                    <td>" . $uneligne['BANQUE'] . "</td>
                                    <td><b>" . $uneligne['MONTANT'] . " €</b></td>
                                    <td>" . $inforeglement . "</td>
                                    <!--<td><a href='index.php?choixTraitement=administrateur&action=detailsReglement&num=" . $uneligne['ID'] . "' ><img src='images/recherche.jpg' target=_blank alt='details'/></a></td>-->
                                    <td><a class='btn btn-primary' href='index.php?choixTraitement=administrateur&action=modifReglement&num=" . $uneligne['ID'] . "' class='btn btn-info'><span class='pe-7s-pen'></span></a></td>
                                    <td><a class='btn btn-secondary' href='index.php?choixTraitement=administrateur&action=recuScolaire&num=" . $uneligne['ID'] . "&eleve=" . $eleveSelectionner['ID_ELEVE'] . "' class='btn btn-info'><span class='pe-7s-print'></span></a></td>
                                    <td>";
                        if ($admin == 2) {
                            echo '
                                      <a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer ce reglement ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=suppReglement&num=' . $uneligne['ID'] . '&eleve=' . $eleveSelectionner['ID_ELEVE'] . '\'; } else { void(0); }" class="btn btn-danger" style="float:right"><span class="pe-7s-trash"></span></a>';
                        }
                        echo "</td>
                                    </tr>";
                    }
                } else {
                    echo '<h4>L\'élève n\'a jamais fait un réglement</h4>';
                }

                echo '</tbody></table></div></div></div>


                                </div><div role="tabpanel" class="tab-pane" id="scolarite">';


                // Onglets années scolaires
                echo '

                                <div class="row">
                                <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                <div class="card-body">
                                <ul class="nav" id="onglets_annees"  role="tablist">';
                $i = 0;
                foreach ($LesInscriptions as $uneInscription) {
                    echo '<li class="nav-link" role="presentation"';
                    if ($i == 0) {
                        echo ' class="nav-link active"';
                    }
                    echo '><a id="' . $uneInscription['ANNEE'] . '" href="#onglet_annee_' . $uneInscription['ANNEE'] . '" aria-controls="home" role="tab" data-toggle="tab">' . $uneInscription['ANNEE'] . '-' . ($uneInscription['ANNEE'] + 1) . '</a></li>';
                    $i++;
                }
                ?>
                <li class="nav-link" role="presentation"><a href="#onglet_annee_ajouter" aria-controls="home" role="tab"
                                                            data-toggle="tab">Nouvelle inscription <i class="fa fa-fw"
                                                                                                      aria-hidden="true"
                                                                                                      title="Copy to use plus"></i>
                    </a></li>
                </ul>
            </div>
    </div>
</div>
</div>

<script type="text/javascript">
    $('#onglets_annees a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

</script>

<div class="tab-content">
    <?php
    $i = 0;
    foreach ($LesInscriptions as $uneInscription) {
        $dateInscription = $uneInscription["DATE_INSCRIPTION"];
        $annee = $uneInscription['ANNEE'];
        $annee1 = $uneInscription['ANNEE'] + 1;

        echo '<div role="tabpanel" class="tab-pane';
        if ($i == 0) {
            echo ' active';
        }
        $i++;
        echo '" id="onglet_annee_' . $annee . '">
                          <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                          <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=ModificationAnnuelValidation&num=' . $eleveSelectionner['ID_ELEVE'] . '&annee=' . $uneInscription['ANNEE'] . '">
                          <div class="row">
                          <div class="col-md-6">
                          <div class="main-card mb-3 card">
                          <div class="card-body">

                          ';
        echo '<div class="form-group">
                          <input type="hidden" name="nouveau" value="false">
                          <div class="tab-content">

                          <fieldset>
                          <h4 class="card-title">Année scolaire ' . $annee . '-' . $annee1 . '</h4><br>
                          <div class="form-row">
                            <div class="col-md-6">
                          <label for="etab" class="required">Établissement</label>
                          <select name="etab"   class="form-control selectpicker" data-live-search="true">
                          ';
        foreach ($lesEtablissements as $uneLigne) {
            if ($uneInscription['ID'] == $uneLigne['ID']) {
                echo '<option  selected="selected" value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            } else {
                echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            }

        }
        echo '
                          </select><br>

                        </div>
                            <div class="col-md-6">
                          <label for="classe" class="required">Classe</label>
                          <select class="form-control" id="classe' . $annee . '" name="classe" >
                          ';
        foreach ($lesClasses as $uneLigne) {
            if ($uneInscription['ID_CLASSE'] == $uneLigne['ID']) {
                echo '<option  selected="selected" value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            } else {
                echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            }
        }
        echo '
                          </select><br>
                          </div>
                          <div class="col-md-6">
                          <label for="filiere" class="required">Filière</label>
                          <select class="form-control" name="filiere">
                          ';
        foreach ($lesfilieres as $uneLigne) {
            if ($uneInscription['ID_FILIERES'] == $uneLigne['ID']) {
                echo '<option  selected="selected" value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            } else {
                echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            }
        }
        echo '
                            </select><br>




                            </div>
                            <div class="col-md-6">
                            <label for="lv1" class="required">LV1</label>
                            <select class="form-control" name="lv1" >
                            ';
        foreach ($lesLangues as $uneLigne) {
            if ($uneInscription['ID_LV1'] == $uneLigne['ID']) {
                echo '<option  selected="selected" value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            } else {
                echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            }
        }
        echo '
                              </select><br>
</div>
<div class="col-md-6">
                              <label for="lv2" class="required">LV2</label>
                              <select class="form-control" name="lv2" >
                              ';
        foreach ($lesLangues as $uneLigne) {
            if ($uneInscription['ID_LV2'] == $uneLigne['ID']) {
                echo '<option  selected="selected" value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            } else {
                echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
            }
        }


        echo '
                                </select><br>
                                </div>

<div class="col-md-6">
                                <label for="date_inscription" class="required">Date d\'inscription</label>
                                <input type="date" class="form-control" name="date_inscription"  autofocus=""  value="' . $dateInscription . '"><br>
</div>
</div>

                                <label for="prof_principal">Professeur principal </label>
                                <input class="form-control" name="prof_principal"  autofocus=""  value="' . $uneInscription['NOM_DU_PROF_PRINCIPAL'] . '" style="width:200px;"><br>

                                <label for="commentaires">Commentaires : <br />
                                </label>
                                <textarea  class="form-control" name="commentaires">' . $uneInscription['COMMENTAIRESANNEE'] . '</textarea><br>

                                <input type="hidden" name="nouveau" value="false"><br><br><input value="Modifier" id="modifierAnneeScolaire' . $annee . '" type="submit" class="btn btn-success">';

        if ($admin == 2) {
            echo '<p style="float:right">
<a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette inscription ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerUneScolarite&num=' . $eleveSelectionner["ID_ELEVE"] . '&annee=' . $uneInscription['ANNEE'] . '\'; } else { void(0); }" class="btn btn-danger" style="float:right"><span class="pe-7s-trash"></span></a></p>';
        }


        echo '
                                </fieldset>
                                </div></div></div>











                                </div>
                                </div>





                                <div class="col-md-6">
                                <div class="main-card mb-3 card div-specialites' . $annee . '">
                                <div class="card-body">


                                <h4 class="card-title" id="Tspecialite' . $annee . '">Spécialités (première & terminale)</h4>
                                <br>
                                ';

        $lesSpecialitesEleves = $pdo->getSpecialitesEleve($num, $uneInscription['ANNEE']);

        foreach ($lesSpecialites as $uneLigne) {


            $checked = " ";

            foreach ($lesSpecialitesEleves as $uneLigne2) {
                if ($uneLigne['ID'] == $uneLigne2['ID']) {
                    $checked = "checked='checked'";
                }
            }

            echo '

                                  <div class="custom-checkbox custom-control">
                                  <input type="checkbox" id="S_' . $uneInscription['ANNEE'] . '_' . $uneLigne['NOM'] . '" ' . $checked . ' class="custom-control-input specialites' . $annee . '" name="specialites[]" value=' . $uneLigne['ID'] . '>
                                  <label class="custom-control-label specialites" for="S_' . $uneInscription['ANNEE'] . '_' . $uneLigne['NOM'] . '">' . $uneLigne["NOM"] . '</label>
                                  </div>




                                  ';
        }

        ?>

        <script type="text/javascript">

            // Sur le clic d'une année
            $('#onglets_annees a').click(function () {
                var annee = ($(this).attr("id"));

                // Lorsqu'on change de classe
                $('select[id="classe' + annee + '"]').on('change', function (evt) {
                    //Si la classe est première ou terminale
                    if ($('select[id="classe' + annee + '"]').find('option:selected').val() == 55 || $('select[id="classe' + annee + '"]').find('option:selected').val() == 56) {
                        // On affiche les spécialités
                        $(".div-specialites" + annee).show();
                        // Si la classe est première ou terminale, et qu'on a pas 2 spécialités choisi, on ne peut modifier l'année scolaire
                        if (($('select[id="classe' + annee + '"]').val() == 55 || 56) && $('input.specialites' + annee + ':checked').length < 2 || $('input.specialites' + annee + ':checked').length > 2) {
                            $('#Tspecialite' + annee).removeClass("validespecialite");
                            $('#Tspecialite' + annee).addClass("pasvalidespecialite");
                            $("#modifierAnneeScolaire" + annee).attr("disabled", true);
                        }
                    }
                    // Sinon on cache les spécialités
                    else {
                        $(".div-specialites" + annee).hide();
                        // Si il y a plus de 0 spécialités, on vide les spécialités, on enlève les messages, on autorise la modification, on cache les spécialités
                        $("input.specialites" + annee).prop("checked", false);
                        $('#Tspecialite' + annee).removeClass("validespecialite");
                        $('#Tspecialite' + annee).removeClass("pasvalidespecialite");
                        $("#modifierAnneeScolaire" + annee).attr("disabled", false);

                    }
                });


// Lorsqu'on clique sur une spécialité
                $('input.specialites' + annee).on('change', function (evt) {
                    // Si plus de 2 sont choisis, on bloque le clique
                    if ($('input.specialites' + annee + ':checked').length > 2) {
                        this.checked = false;
                    }
                    // Si la classe est première ou terminale, et qu'on a pas 2 spécialités choisi, on ne peut pas modifier l'année scolaire
                    if (($('select[id="classe' + annee + '"]').val() == 55 || 56) && $('input.specialites' + annee + ':checked').length < 2 || $('input.specialites' + annee + ':checked').length > 2) {
                        $('#Tspecialite' + annee).removeClass("validespecialite");
                        $('#Tspecialite' + annee).addClass("pasvalidespecialite");
                        $("#modifierAnneeScolaire" + annee).attr("disabled", true);
                    }
                    // La classe n'est pas première ou terminale et moins de 2 spécialités sont choisis, on ne peut pas validé, donc on ne peut pas modifier l'année
                    else {
                        $('#Tspecialite' + annee).addClass("validespecialite");
                        $('#Tspecialite' + annee).removeClass("pasvalidespecialite");
                        $("#modifierAnneeScolaire" + annee).attr("disabled", false);

                    }
                });

// Si on a pas choisi d'année
                if ($('input.specialites' + annee + ':checked').length <= 0) {
                    //Si on à choisi la classe première ou terminale, on affiche les spécialités, sinon, on ne les affiche pas
                    if ($('select[id="classe' + annee + '"]').find('option:selected').val() == 55 || $('select[id="classe' + annee + '"]').find('option:selected').val() == 56) {
                        $(".div-specialites" + annee).show();
                    } else {
                        $(".div-specialites" + annee).hide();
                    }
                }
//Si on change les spécialités
                $('input.specialites' + annee).on('change', function (evt) {
                    //Si le nombre de spécialité choisi est différent de 2, les spécialités ne sont pas valides
                    if ($('input.specialites' + annee + ':checked').length < 2 || $('input.specialites' + annee + ':checked').length > 2) {
                        $('#Tspecialite' + annee).removeClass("validespecialite");
                        $('#Tspecialite' + annee).addClass("pasvalidespecialite");
                        $("#modifierAnneeScolaire" + annee).attr("disabled", true);
                    }
                    //Le nombre de spécialité est égale à 2, les spécialités sont valides
                    else {
                        $('#Tspecialite' + annee).addClass("validespecialite");
                        $('#Tspecialite' + annee).removeClass("pasvalidespecialite");
                        $("#modifierAnneeScolaire" + annee).attr("disabled", false);
                    }
                });


            });
        </script>

        <?php
        echo '
                                </div></div>


                                <div class="main-card mb-3 card">
                                <div class="card-body">


                                <h4 class="card-title">Difficultés scolaires</h4>
                                <br>
                                ';
        $lesDifficultesEleves = $pdo->getDifficultesEleve($num, $uneInscription['ANNEE']);
        foreach ($lesMatieres as $uneLigne) {

            $checked = " ";

            foreach ($lesDifficultesEleves as $uneLigne2) {
                if ($uneLigne['ID'] == $uneLigne2['ID']) {
                    $checked = "checked='checked'";
                }
            }

            echo '

                                  <div class="custom-checkbox custom-control">
                                  <input type="checkbox" id="D_' . $uneInscription['ANNEE'] . '_' . $uneLigne['NOM'] . '" ' . $checked . ' class="custom-control-input" name="difficultes[]" value=' . $uneLigne['ID'] . '>
                                  <label class="custom-control-label" for="D_' . $uneInscription['ANNEE'] . '_' . $uneLigne["NOM"] . '">' . $uneLigne["NOM"] . '</label>
                                  </div>

                                  ';
        }
        echo '
                                </div></div></div>


                                </div>
                                </form>
                                </div>
                                </div>';
    }
    /*--------------------- Onglet pour ajouter une année -----------------------*/

    echo '<div role="tabpanel" class="tab-pane" id="onglet_annee_ajouter">';

    echo '<form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=AjoutAnnuelValidation&num=' . $eleveSelectionner['ID_ELEVE'] . '">
                              <input type="hidden" name="nouveau" value="true">
                              <div class="form-group">
                              <fieldset>
                              <div class="row">

                              <div class="col-md-8">
                              <div class="main-card mb-3 card">
                              <div class="card-body">
                              <h4 class="card-title">Ajouter une année scolaire</h4>
                              <div class="form-row">
                              <div class="col-md-3">
                              <label for="date_inscription" class="required">Date d\'inscription</label>
                              <input type="date" class="form-control" name="date_inscription"  autofocus=""  value="" required><br>
</div>

                              <div class="col-md-4">
                              <label for="prof_principal">Professeur principal </label>
                              <input class="form-control" name="prof_principal"  autofocus=""  value="" ><br>
                              </div>
                              </div>
                              <label for="commentaires">Commentaires : <br />
                              </label>
                              <textarea  class="form-control" name="commentaires"></textarea><br>

                              <div class="div-specialitesA">
                              <h4 class="card-title" id="TspecialiteA">Spécialités</h4>

                              ';
    foreach ($lesSpecialites as $uneLigne) {
        echo '
                                <div class="custom-checkbox custom-control">
                                <input type="checkbox" id="NS_' . $uneLigne['NOM'] . '" class="custom-control-input specialitesA" name="specialitesA[]" value=' . $uneLigne['ID'] . '>
                                <label class="custom-control-label" for="NS_' . $uneLigne["NOM"] . '">' . $uneLigne["NOM"] . '
                                </label>

                                </div>

                                ';

    }

    echo '</div></br>
                              <h4 class="card-title">Difficultés scolaires</h4>

                              ';
    foreach ($lesMatieres as $uneLigne) {
        echo '
                                <div class="custom-checkbox custom-control">

                                <input type="checkbox" id="ND_' . $uneLigne['NOM'] . '" class="custom-control-input" name="difficultes[]" value=' . $uneLigne['ID'] . '>

                                <label class="custom-control-label" for="ND_' . $uneLigne["NOM"] . '">' . $uneLigne["NOM"] . '
                                </label>

                                </div>
                                ';

    }

    echo '<br><br><input id="ajouterAnneeScolaire" value="Ajouter" type="submit" class="btn btn-success"></div></div></div>

                              <div class="col-md-4">
                              <div class="main-card mb-3 card">
                              <div class="card-body">

                              <label for="annee" class="required"> Année</label>
                              <!--<input class="form-control" name="annee"  autofocus=""  value="" style="size:200px" type="number"><br>-->
                              <select name="annee" style="width:200px;" class="form-control" required>
                              <option value="" disabled selected>Choisir une année</option>';
    for ($i = ($anneeEnCours - 2); $i < ($anneeEnCours + 2); $i++) {
        echo '<option value="' . $i . '">' . $i . '-' . ($i + 1) . '</option>';
    }
    echo '</select><br>

                              <label for="etab" class="required">Établissement</label>
                              <select name="etab" style="width:200px;"  class="form-control selectpicker" data-live-search="true" required>
                              <option value="" disabled selected>Choisir un établissement</option>';
    foreach ($lesEtablissements as $uneLigne) {
        echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
    }
    echo '
                              </select><br>

                              <label for="classeA" class="required">Classe</label>
                              <select class="form-control" name="classeA" style="width:200px;" required>
                              <option value="" disabled selected>Choisir une classe</option>';
    foreach ($lesClasses as $uneLigne) {
        echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
    }
    echo '
                              </select><br>

                              <label for="filiere" class="required">Filière</label>
                              <select class="form-control" name="filiere" style="width:200px;" required>
                              <option value="" disabled selected>Choisir une filière</option>';
    foreach ($lesfilieres as $uneLigne) {
        echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
    }
    echo '
                              </select><br>

                              <label for="lv1" class="required">LV1</label>
                              <select class="form-control" name="lv1" style="width:200px;" required>
                              <option value="" disabled selected>Choisir une LV1</option>';
    foreach ($lesLangues as $uneLigne) {
        echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
    }
    echo '
                              </select><br>

                              <label for="lv2" class="required">LV2</label>
                              <select class="form-control" name="lv2" style="width:200px;" required>
                              <option value="" disabled selected>Choisir une LV2</option>';
    foreach ($lesLangues as $uneLigne) {
        echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
    }


    echo '
                              </select><br>
                              </div></div></div>


                              </div></fieldset>
                              </form></div></div></div></div>

                              ';


    // TODO: voir ici présence des élèves pour modifier le champ
    echo '<div role="tabpanel" class="tab-pane" id="presences">

                              <form method="POST" action="index.php?choixTraitement=administrateur&action=PresenceEleveIndividuel&eleve=' . $eleveSelectionner['ID_ELEVE'] . '">
                              <div class="row">
                              <div class="col-md-12">
                              <div class="main-card mb-3 card">
                              <div class="card-body">
                              <h4 class="card-title">Présences</h4>
                              <button type="button" class="btn btn-primary" id="reportrange">


                              <i class="fa fa-calendar pr-1"></i>
                              <span></span>
                              <i class="fa pl-1 fa-caret-down"></i>
                              <input type="hidden" name="debut" id="from" value="">
                              <input type="hidden" name="fin" id="to" value="">

                              </button>
                              <input type="submit" name="filter" id="filter" value="Filtrer" class="btn btn-info" />
                              </div>
                              </div>
                              </div>
                              </div>
                              </form>
                              </div>



                              <div class="tab-pane" role="tabpanel" id="rdv">
                              <div class="row">
                              <div class="col-md-12">
                              <div class="main-card mb-3 card">
                              <div class="card-body">


                              <p style="margin-top:30px">
                              <center>
                              <a href="index.php?choixTraitement=administrateur&action=FicheNavette&unEleve=' . $eleveSelectionner['ID_ELEVE'] . '" class="btn btn-info">Fiche navette</a>
                              <a href="index.php?choixTraitement=administrateur&action=Calendrier" class="btn btn-success">Ajouter un rendez-vous</a>
                              </center>
                              </p>
                              </div></div></div>

                              <div class="col-md-12">
                              <div class="main-card mb-3 card">
                              <div class="card-body">
                              <h4 class="card-title">RDV parents</h4>
                              <table class="table">
                              <thead>
                              <tr>
                              <th>Date et heure</th>
                              <th>Intervenant</th>
                              <th>Commentaires</th>
                              <th>Supprimer</th>
                              </tr>
                              </thead>
                              <tbody>';


    $i = 0;
    // On parcours les rdv
    foreach ($lesRendezvous as $unRdv) {
        if ($unRdv['ID_ELEVE'] == $eleveSelectionner['ID_ELEVE']) {
            $unIntervenant = $pdo->recupUnIntervenant($unRdv['ID_INTERVENANT']);

            $i++;
            echo '<tr>
                                  <td>' . date("d/m/Y H:i", strtotime($unRdv['DATE_RDV'])) . '</td>
                                  <td><a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unRdv['ID_INTERVENANT'] . '">' . $unIntervenant['PRENOM'] . ' ' . $unIntervenant['NOM'] . '</a></td>
                                  <td>' . $unRdv['COMMENTAIRE'] . '</td>
                                  <td>';
            if ($admin == 2) {
                echo '<a href="javascript:if(confirm(\'Voulez-vous vraiment supprimer ce rendez-vous ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerRdv&num=' . $unRdv['ID_RDV'] . '&typeRDV=PARENTS\'; };" class="btn btn-danger"><span class="pe-7s-trash"></span></a>';
            }
            echo '</td>
                                  </tr>
                                  ';
        }
    }
    echo '</tbody></table>';
    if ($i == 0) {
        echo '<center><p><i>Aucun rendez-vous pris.</i></p></center>';
    }
    ?>
</div></div></div>
<div class="col-md-12">
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h4 class="card-title">RDV étudiants BSB</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Date et heure</th>
                    <th>Durée</th>
                    <th>Intervenant</th>
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
                    if ($unRdv['ID_ELEVE'] == $eleveSelectionner['ID_ELEVE']) {

                        // On récupère les infos
                        $totalHeuresRdv = ($totalHeuresRdv + $unRdv['DUREE']);
                        $unIntervenant = $pdo->recupUnIntervenant($unRdv['ID_INTERVENANT']);
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
                                          <td><a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unRdv['ID_INTERVENANT'] . '">' . $unIntervenant['PRENOM'] . ' ' . $unIntervenant['NOM'] . '</a></td>
                                          <td>' . $laMatiere . '</td>
                                          <td>' . stripslashes($unRdv['COMMENTAIRE']) . '</td>
                                          <td>';
                        if ($admin == 2) {
                            echo '<a href="javascript:if(confirm(\'Voulez-vous vraiment supprimer ce rendez-vous ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerRdv&num=' . $unRdv['ID_RDV'] . '&typeRDV=BSB\'; };" class="btn btn-danger"><span class="pe-7s-trash"></span></a>';
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
                                      </tr></tbody></table>';
                if ($i == 0) {
                    echo '<center><p><i>Aucun rendez-vous pris.</i></p></center>';
                }
                ?>


                <!--<h4 id="form_ajout">Ajouter un rendez-vous</h4><br>
                                      <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"  action="index.php?choixTraitement=administrateur&action=ajoutRdv">
                                      <div class="form-group">

                                      <input type="hidden" name="num" value="<?php echo $eleveSelectionner['ID_ELEVE']; ?>">

                                      <label for="num">Intervenant </label>
                                      <select  class="form-control" name="intervenant" style="width:200px" required>
                                      <option disabled selected>Choisir</option>
                                      <?php
                foreach ($lesIntervenants as $unIntervenant) {
                    echo '<option value="' . $unIntervenant['ID_INTERVENANT'] . '">' . $unIntervenant['NOM'] . ' ' . $unIntervenant['PRENOM'] . '</option>';
                }
                ?>
                                  </select><br>

                                  <label for="date_inscription">Date du rendez-vous</label>
                                  <input class="form-control" name="date" autofocus="" id="date" value="" placeholder="0000-00-00"  style="width:200px" type="date" required> AAAA-MM-JJ<br><br>

                                  <label for="heure_inscription">Heure du rendez-vous</label>
                                  <input class="form-control" name="heure" autofocus="" value="" placeholder="00:00"  style="width:200px" type="time" required> HH:MM<br><br>

                                  <label for="commentaire">Commentaire</label>
                                  <textarea name="commentaire" class="form-control"></textarea><br><br>

                                  <input value="Valider" type="submit" class="btn btn-success">
                                </div>
                              </form>	-->


                <?php } ?>


        </div>
    </div>
</div>

</div>
</div>

<script type="text/javascript">
    /*
    //<!--
    Affiche(Onglet_afficher);
    //-->*/
</script>


</div>


<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript"
        src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>

<script src="vues/administrateur/croppie.js"></script>
<script type="text/javascript" src="./js/form-components/datepicker.js"></script>
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
                var eleve = <?php echo json_encode($eleveSelectionner['ID_ELEVE']); ?>;
                xhr.open("POST", "index.php?choixTraitement=administrateur&action=modifierPhotoEleve"); //change this to .php or .asp, depending on your server
                xhr.onload = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            var image = new Image();
                            image.src = "../photosEleves/" + xhr.responseText;
                            document.getElementById("buttonSave").innerHTML = "Sauvegardé";
                            document.getElementById("buttonSave").disabled = true;
                            makeCaptureButton();
                        }
                    }
                };
                var form = new FormData();
                form.append("image_webcam", dataURL);
                form.append("num", eleve);
                xhr.send(form);
                //$("form[id='LesElevesForm']").submit();
            }
        }
    }
</script>
<!-- Fin webcam_new -->


<script>


    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////


    // On n'affiche pas les spécialités de base
    $(".div-specialitesA").hide();
    // Lorsqu'on change la classe
    $('select[name="classeA"]').on('change', function () {
        // Si la classe correspond à la première ou à la terminale
        if ($('select[name="classeA"]').find('option:selected').val() == 55 || $('select[name="classeA"]').find('option:selected').val() == 56) {
            // On affiche les spécialités
            $(".div-specialitesA").show();
            // Si on a pas 2 spécialités choisi, on ne peut pas modifier l'année scolaire
            if ($('input.specialitesA:checked').length < 2 || $('input.specialitesA:checked').length > 2) {
                $('#TspecialiteA').removeClass("validespecialite");
                $('#TspecialiteA').addClass("pasvalidespecialite");
                $("#ajouterAnneeScolaire").attr("disabled", true);
            } else {
                $('#TspecialiteA').addClass("validespecialite");
                $('#TspecialiteA').removeClass("pasvalidespecialite");
                $("#ajouterAnneeScolaire").attr("disabled", false);
            }

        } else {
            $(".div-specialitesA").hide();
            //if($('input.specialitesA:checked').length > 0) {
            $("input.specialitesA").prop("checked", false);
            $('#TspecialiteA').removeClass("validespecialite");
            $('#TspecialiteA').removeClass("pasvalidespecialite");
            $("#ajouterAnneeScolaire").attr("disabled", false);
            //}
        }


    });

    //Lorsqu'on change de spécialité
    $('input.specialitesA').on('change', function (evt2) {
        // On limite les spécialités à 2
        if ($('input.specialitesA:checked').length > 2) {
            this.checked = false;
        }
        // Si la classe est première ou terminale, et que le nombre de spécialité est différent de 2, les spécialités ne sont pas validés, on ne peut pas ajouter l'année
        if (($('select[name="classeA"]').val() == 55 || 56) && $('input.specialitesA:checked').length < 2 || $('input.specialitesA:checked').length > 2) {
            $('#TspecialiteA').removeClass("validespecialite");
            $('#TspecialiteA').addClass("pasvalidespecialite");
            $("#ajouterAnneeScolaire").attr("disabled", true);
        }
        // Sinon, on peut ajouter l'année
        else {
            $('#TspecialiteA').addClass("validespecialite");
            $('#TspecialiteA').removeClass("pasvalidespecialite");
            $("#ajouterAnneeScolaire").attr("disabled", false);
        }
    });

</script>


<script type="text/javascript">
    // On rérupère la dernière année
    var anneeEnCours = <?php echo $LesInscriptions[0]['ANNEE']; ?>
// On click après un lapse de temps automatiquement sur la dernière année scolaire de l'élève pour faire fonctionner le script sur les spécialités lorsque qu'on click sur l'onglet spécialité
        $("#tab-4").click(function () {
            setTimeout(
                function () {
                    $('#' + anneeEnCours).click();
                    return false;
                },
                100);
        });

</script>
