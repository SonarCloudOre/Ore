<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Inscription adhérents
                </div>
            </div>
            <div class="page-title-actions">    
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <button type="button" class="mr-2 btn btn-primary"
                            onclick="document.location.href='index.php?choixTraitement=administrateur&action=index'">
                        <i class="fa fa-fw" aria-hidden="true" title="arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!--BLOC PHOTO-->
    <center>
        <div>
            <div class="col-md"><div class="main-card mb-3 card">
                <div class="card-body">
                    <img width="200" height="200" style="box-shadow: 1px 1px 20px #555;image-orientation: 0deg;" src=""><br><br>
                    <input type="file" id="photo" name="photo" class="mb-1 mr-1 btn btn-primary" style="font-size:15px" onclick="document.getElementById('interface_photo').style.display = 'block';">
                </div>
            </div>
        </div>
    </center>

    <!--ONGLETS-->
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                                <li class="nav-item">
                                    <a role="tab" class="nav-link active" id="infos-tab" data-toggle="tab" href="#infos" role="tab" aria-controls="infos" aria-selected="true">
                                        <span>Informations</span>
                                    </a>
                                </li>
                                <!--<li class="nav-item">
                                    <a role="tab" class="nav-link" id="reglements-tab" data-toggle="tab" href="#reglements" role="tab" aria-controls="infos" aria-selected="false">
                                        <span>Règlements</span>
                                    </a>
                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--CONTENU DES ONGLETS-->
    <div class="tab-content" id="onglets">
        <!-- INFORMATIONS -->
        <div class="tab-pane fade show active" id="infos" role="tabpanel" aria-labelledby="infos-tab">
            <form id="signupFormInfoFabLab" name="signupFormInfoFabLab" method="post"
                action="index.php?choixTraitement=administrateur&action=info_inscriptionAdherentsFabLab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="main-card mb-3 card custom-card1">
                            <div class="card-body">
                                <h4 class="card-title">Informations Générales</h4>
                                <div class="form-group">
                                    <label for="dateInscription" class="required">Date d'inscription</label>
                                    <input type="date" class="form-control" id="dateInscription" name="dateInscription" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="nom" class="required">Nom</label>
                                    <input class="form-control" id="nom" name="nom" placeholder="Votre nom" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="prenom" class="required">Prénom</label>
                                    <input class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="dateNaissance" class="required">Date de naissance</label>
                                    <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="lieuNaissance" class="required">Lieu de naissance</label>
                                    <input type="text" class="form-control" name="lieuNaissance" placeholder="Ville de naissance" required>
                                </div>
                                <div class="form-group">
                                    <label for="sexe" class="required" required>Sexe</label>
                                    <select name="sexe" id="sexe" class="form-control">
                                        <option  value="" selected disabled hidden>Choisir</option>
                                        <option value="F">Femme</option>
                                        <option value="H">Homme</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h4 class="card-title">Adresse Postale</h4>
                                <div class="form-group">
                                    <label for="adresse" class="required">Adresse</label>
                                    <input class="form-control" id="adresse" name="adresse" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="codePostal" class="required">Code postal</label>
                                    <input class="form-control" id="codePostal" name="codePostal" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="ville" class="required">Ville</label>
                                    <input class="form-control" id="ville" name="ville" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="main-card mb-3 card custom-card">
                            <div class="card-body col-md-6">
                                <h4 class="card-title">Coordonnées</h4>
                                <div class="form-group">
                                    <label for="telMobile" class="required">Téléphone (portable)</label>
                                    <input class="form-control" id="telMobile" name="telMobile" value="" maxlength="10" pattern="^\d{10}$" title="Veuillez entrer un numéro de téléphone fixe sans espaces (exactement 10 chiffres)" required>
                                </div>
                                <div class="form-group">
                                    <label for="telFixe">Téléphone (fixe)</label>
                                    <input class="form-control" id="telFixe" name="telFixe" value="" maxlength="10" pattern="^\d{10}$" title="Veuillez entrer un numéro de téléphone fixe sans espaces (exactement 10 chiffres)" required>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="required">Email</label>
                                    <input class="form-control" id="email" name="email" placeholder="xxxx@xxxxx.xx" value="" type="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form Validation -->
                <div class="text-center">
                    <input value="Valider" type="submit" class="mt-3 btn btn-lg btn-success w-50" id="valider"/>
                </div>
            </form>
        </div>
        <!--REGLEMENTS ET ACTIVITES CORRESPONDANTES
        <div class="tab-pane fade" id="reglements" role="tabpanel" aria-labelledby="reglements-tab">
            <form id="paymentFormInfoFabLab" name="paymentFormInfoFabLab" method="post"
                action="index.php?choixTraitement=administrateur&action=validePaiementFabLab">
                <div role="tabpanel" class="tab-pane" id="reglements">
                    <div class="col-lg-13">
                        <div class="main-card mb-3 card">
                            <div class="card-body">

                            <p align='right'>
                                <a href='index.php?choixTraitement=administrateur&action=validePaiementFabLab&num=" . $inscriptionSelectionner['ID_ELEVE'] . "' class='btn btn-success'>
                                    <span class='glyphicon glyphicon-plus'>
                                    </span> Ajouter
                                </a>
                            </p>

                            if (count($reglementsFabLab) != 0) {
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
                                        foreach ($reglementsFabLab as $uneligne) {
                                            $pourHTML = "";
                                            $inscrits = $pdo->recupReglementFabLab($uneligne['ID']);
                                            foreach ($inscrits as $unInscrit) {
                                                if ($unInscrit['ID_UTILISATEUR'] == $inscriptionSelectionner['ID_UTILISATEUR']) {
                                                    $pourHTML = "<strong>" . $unInscrit['NOM'] . " " . $unInscrit['PRENOM'] . "</strong><br>" . $pourHTML;
                                                } else {
                                                    $pourHTML .= $unInscrit['NOM'] . " " . $unInscrit['PRENOM'] . "<br>";
                                                }
                                            }
                                            $inforeglement = "";
                                            if (isset($uneligne['ID_REGLEMENT']) and !is_null($uneligne['ID_REGLEMENT'])) {
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
                                                <td><a href='index.php?choixTraitement=administrateur&action=detailsReglement&num=" . $uneligne['ID'] . "' ><img src='images/recherche.jpg' target=_blank alt='details'/></a></td>
                                                <td><a class='btn btn-primary' href='index.php?choixTraitement=administrateur&action=modifReglement&num=" . $uneligne['ID'] . "' class='btn btn-info'><span class='pe-7s-pen'></span></a></td>
                                                <td><a class='btn btn-secondary' href='index.php?choixTraitement=administrateur&action=recuScolaire&num=" . $uneligne['ID'] . "&eleve=" . $inscriptionSelectionner['ID_ELEVE'] . "' class='btn btn-info'><span class='pe-7s-print'></span></a></td>
                                                <td>";
                                                if ($admin == 2) {
                                                    echo '
                                                            <a href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer ce reglement ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=suppReglement&num=' . $uneligne['ID'] . '&eleve=' . $inscriptionSelectionner['ID_ELEVE'] . '\'; } else { void(0); }" class="btn btn-danger" style="float:right"><span class="pe-7s-trash"></span></a>';
                                                }
                                                echo "</td>
                                                            </tr>";
                                            }
                                            } else {
                                            echo '<h4>L\'élève n\'a jamais fait un réglement</h4>';
                                            }
                                            ?>

                <div class="text-center">
                    <input value="Valider" type="submit" class="mt-3 btn btn-lg btn-success w-50" id="valider"/>
                </div>
            </form>
        </div>--->
    </div>
</div>

<!--permet de contrôler le comportement des onglets dans une interface 
utilisateur en empêchant le rechargement de la page lorsqu'un onglet est cliqué et 
en affichant l'onglet correspondant sans naviguer vers une autre page.-->
<script type="text/javascript">
    $('#onglets a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
    })
</script>

<link rel="stylesheet" href="./styles/css/fablab.css">




<!-- script pour empêcher les espaces -->
<script>
    function removeSpaces(event) {
        event.target.value = event.target.value.replace(/\s+/g, '');
    }

    document.getElementById('telFixe').addEventListener('input', removeSpaces);
    document.getElementById('telMobile').addEventListener('input', removeSpaces);
</script>