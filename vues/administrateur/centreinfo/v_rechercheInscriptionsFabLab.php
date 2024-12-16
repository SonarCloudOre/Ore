<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Centre Informatique
                    <?php
                    if (isset($inscriptionSelectionner)) {
                        echo '<div class="page-title-subheading">Inscription de ' . $inscriptionSelectionner['PRENOM'] . ' ' . $inscriptionSelectionner['NOM'] . ' </div>';
                    } else {
                        echo '<div class="page-title-subheading">Sélectionner une personne pour accéder à sa fiche</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <a style="float:left" href="index.php?choixTraitement=administrateur&action=info_inscriptionAdherentsFabLab">
                        <button type="button" class="mr-2 btn btn-success">
                            <span class="glyphicon glyphicon-plus">Inscrire</span>
                        </button>
                    </a>
                </div>
                <?php
                if (isset($inscriptionSelectionner)) {
                    
                    if ($admin == 2) {
                        echo '
                                <a style="float:right" href="javascript:void(0);" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette inscription ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=info_supprimerInscriptionFabLab&unUtilisateur=' . $inscriptionSelectionner['ID_UTILISATEUR'] . '\'; } else { void(0); }">
                                <button type="button"  class="mr-2 btn btn-danger">
                                <span class="glyphicon glyphicon-trash">Supprimer l\'inscription</span>
                                </button>
                                </a>';
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <form method="POST" action="index.php?choixTraitement=administrateur&action=info_rechercheInscriptions">
        <div class="row">
            <div class="col-md">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <center>
                            <h2>Chercher une inscription</h2>
                            <br/>
                            <!-- Représente le formulaire de recherche d'un utilisateur-->
                            <div role="tabpanel" class="tab-pane" id="rechercherUtilisateur">
                                <div class="row">
                                    <div class="col-md">
                                        <label for="unUtilisateur">Utilisateur</label><br>
                                        <select name="unUtilisateur" onchange="this.form.submit()" class="multiselect-dropdown form-control" data-live-search="true">
                                            <option disabled="disabled" selected="selected">Choisir</option>
                                            <?php 
                                            foreach ($lesUtilisateurs as $unUtilisateur) {
                                                if (isset($inscriptionSelectionner) && $unUtilisateur['ID_UTILISATEUR'] == $inscriptionSelectionner['ID_UTILISATEUR']) {
                                                    $selectionner = "selected='selected'";
                                                } else {
                                                    $selectionner = "";
                                                }
                                                echo "<option " . $selectionner . " value='" . $unUtilisateur['ID_UTILISATEUR'] . "'>" . $unUtilisateur['NOM'] . " " . $unUtilisateur['PRENOM'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php

    if (isset($_REQUEST['unUtilisateur'])){
                   
        echo '
        <div class="tab-content" id="onglets">
            <!-- INFORMATIONS -->
                <div class="tab-pane fade show active" id="infos" role="tabpanel" aria-labelledby="infos-tab">
                    <form id="editFormInfoLab" name="editFormInfoLab" method="post"
                action="index.php?choixTraitement=administrateur&action=info_ModifierInscripFabLab&unUtilisateur=' . $inscriptionSelectionner['ID_UTILISATEUR'] . '">
        '

        ?>

                    <!--BLOC PHOTO-->
                    <center>
                        <div>
                            <div class="col-md-5">
                                <div class="main-card mb-3 card">
                                <!-- Afficher la photo actuelle -->
                                    <div class="card-body">
                                        <img width="200" height="200" class="img-thumbnail mt-3" style="box-shadow: 1px 1px 20px #555;image-orientation: 0deg;" alt="Photo de l'adherent" src="./images/adherentsFablab/<?=$inscriptionSelectionner['PHOTO']?>"> <br><br>
                                        <input type="file" id="photo" name="PHOTO" class="mb-2 mr-2 btn btn-primary" accept="image/png, image/jpeg" style="font-size:15px" onclick="document.getElementById('interface_photo').style.display = 'block';">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </center>
        
                    <?php
                    echo '

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav" id="onglets"
                                        role="tablist" style="clear:both">
                                        <li role="presentation" class="active nav-item">
                                            <a href="#infos" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab">
                                                <span class="glyphicon glyphicon-file">Informations</span>
                                            </a>
                                        </li>'?>
                                        <!--<li role="presentation" class="nav-item">
                                            <a href="#reglements" class="nav-link" aria-controls="home" role="tab" data-toggle="tab">
                                                <span class="glyphicon glyphicon-folder-open">Règlements et activités</span>
                                            </a>
                                        </li>-->
                                        <?php
                                        echo '
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>'
                ?>

                <!--permet de contrôler le comportement des onglets dans une interface 
                utilisateur en empêchant le rechargement de la page lorsqu'un onglet est cliqué et 
                en affichant l'onglet correspondant sans naviguer vers une autre page.-->
                <script type="text/javascript">
                    $('#onglets a').click(function (e) {
                    e.preventDefault()
                    $(this).tab('show')
                    })
                </script>

    <?php
    echo '                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="main-card mb-3 card custom-card1">
                                <div class="card-body">
                                    <h4 class="card-title">Informations Générales</h4>
                                    <div class="form-group">
                                        <label for="dateInscription">Date d \'inscription :</label>
                                        <input type="date" class="form-control" id="dateInscription" name="dateInscription" readonly="readonly" value="' . $inscriptionSelectionnerDate['DATE_INSCRIPTION'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="nom">Nom</label>
                                        <input class="form-control" id="nom" name="NOM" placeholder="Votre nom" value="' . $inscriptionSelectionner['NOM'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="prenom">Prénom</label>
                                        <input class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" value="' . $inscriptionSelectionner['PRENOM'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="dateNaissance">Date de naissance</label>
                                        <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="' . $inscriptionSelectionner['DATE_DE_NAISSANCE'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="lieuNaissance">Lieu de naissance</label>
                                        <input type="text" class="form-control" name="lieuNaissance" placeholder="Ville de naissance" value="' . $inscriptionSelectionner['LIEU_DE_NAISSANCE'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="sexe">Sexe</label>
                                        <select name="sexe" id="sexe" class="form-control">';
                                            if ($inscriptionSelectionner['SEXE'] == "F") {
                                                echo '<option value="F" selected="selected" name="sexe">Femme</option>
                                                    <option value="H" name="sexe">Homme</option>';
                                            } else {
                                                echo '<option value="F"  name="sexe">Femme</option>
                                                        <option value="H" selected="selected" name="sexe">Homme</option>';
                                            }
                                            echo '
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
                                        <label for="adresse">Adresse</label>
                                        <input class="form-control" id="adresse" name="adresse" value="' . $inscriptionSelectionner['ADRESSE_POSTALE'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="codePostal">Code postal</label>
                                        <input class="form-control" id="codePostal" name="codePostal" value="' . $inscriptionSelectionner['CODE_POSTAL'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="ville">Ville</label>
                                        <input class="form-control" id="ville" name="ville" value="' . $inscriptionSelectionner['VILLE'] . '">
                                    </div>
                                </div>
                            </div>
                            <div class="main-card mb-3 card custom-card">
                                <div class="card-body col-md-6">
                                    <h4 class="card-title">Coordonnées</h4>
                                    <div class="form-group">
                                        <label for="telMobile">Téléphone (portable)</label>
                                        <input class="form-control" id="telMobile" name="telMobile" value="' . $inscriptionSelectionner['TELEPHONE_PORTABLE'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="telFixe">Téléphone (fixe)</label>
                                        <input class="form-control" id="telFixe" name="telFixe" value="' . $inscriptionSelectionner['TELEPHONE_FIXE'] . '">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" id="email" name="email" placeholder="xxxx@xxxxx.xx" type="email" value="' . $inscriptionSelectionner['EMAIL'] . '">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form Validation -->
                    <div class="text-center">
                        <input name="ModifierInscrip" value="Modifier" type="submit" class="mt-3 btn btn-lg btn-success w-50" id="modifier"/>
                    </div>';
                    ?>
                </form>
            </div>
        <?php 
    } 
    ?>
</div>


<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript"
        src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="./js/form-components/input-select.js"></script>