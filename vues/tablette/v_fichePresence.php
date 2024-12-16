<div id="contenu">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Fiche de présence</h4>

                    <!-- Représente les boutons "S'inscrire" et "Rechercher son profil"-->
                    <div class="form-row">
                        <div class="col-md">
                            <div class="card-body">
                                <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav nav-fill">
                                    <li class="nav-item">
                                        <a role="tab" class="nav-link active justify-content-center" id="tab-0" data-toggle="tab" href="#ajouterUtilisateur">
                                            <span>S'inscrire</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a role="tab" class="nav-link justify-content-center" id="tab-1" data-toggle="tab" href="#rechercherUtilisateur">
                                            <span>Rechercher son profil</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    
                    <div class="tab-content">
                        <!-- Représente le formulaire d'ajout d'un utilisateur-->
                        <div role="tabpanel" class="tab-pane active" id="ajouterUtilisateur">
                            <div class="row">
                                <div class="col-md">
                                    <form method="POST" action="index.php?choixTraitement=tablette&action=fichePresence" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="nom" class="required">Nom</label>
                                                <input type="text" class="form-control" name="nom" required>
                                            </div>
                                            <div class="col-md">
                                                <label for="prenom" class="required">Prénom</label>
                                                <input type="text" class="form-control" name="prenom" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="email" class="required">Email</label>
                                                <input type="email" class="form-control" name="email" required>
                                            </div>
                                            <div class="col-md">
                                                <label for="sexe" class="required">Sexe</label>
                                                <select name="sexe" class="form-control" required>
                                                    <option disabled selected value="">Choisir</option>
                                                    <option value="H" name="sexe">Homme</option>
                                                    <option value="F" name="sexe">Femme</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="telMobile" class="required">Téléphone mobile</label>
                                                <input type="tel" class="form-control" name="telMobile" required>
                                            </div>

                                            <div class="col-md">
                                                <label for="telFixe">Téléphone fixe</label>
                                                <input type="tel" class="form-control" name="telFixe">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="dateNaissance" class="required">Date de naissance</label>
                                                <input type="date" class="form-control" name="dateNaissance" required>
                                            </div>

                                            <div class="col-md">
                                                <label for="lieuNaissance" class="required">Lieu de naissance</label>
                                                <input type="text" class="form-control" name="lieuNaissance" required>
                                            </div>
                                        </div>

                                        <label for="adresse" class="required">Adresse</label>
                                        <input type="text" class="form-control" name="adresse" required>

                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="codePostal" class="required">Code postal</label>
                                                <input type="text" class="form-control" name="codePostal" required>
                                            </div>

                                            <div class="col-md">
                                                <label for="ville" class="required">Ville</label>
                                                <input type="text" class="form-control" name="ville" required>
                                            </div>
                                        </div>

                                        <label for="photo">Photo</label>
                                        <input type="file" class="form-control" name="photo">

                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="arrive" class="required">Date et Heure d'arrivé</label><br>
                                                <input type="datetime-local" class="form-control" name="arrive" required>
                                            </div>

                                            <div class="col-md">
                                                <label for="sortie" class="required">Date et Heure de sortie</label><br>
                                                <input type="datetime-local" class="form-control" name="sortie" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="uneActivitee" class="required">Activités</label><br>
                                                <select name="uneActivitee" class="multiselect-dropdown form-control" data-live-search="true" required>
                                                    <option disabled selected value="">Choisir</option>
                                                    <?php if (isset($lesActivites)) {
                                                        foreach ($lesActivites as $uneActivite) {
                                                            echo " <option " . $selectionner . " value='" . $uneActivite['ID_ACTIVITE'] . "' name='uneActivite'>" . stripslashes($uneActivite['NOM']) . "</option>";
                                                        } 
                                                    }?>
                                                </select>
                                            </div>
                                        </div>

                                        <input value="Valider la présence" type="submit" class="mt-3 btn btn-lg btn-success w-100">
                                        
                                    </form>
                                </div>
                            </div>
                        </div>    
                    

                        <!-- Représente le formulaire de recherche d'un utilisateur-->
                        <div role="tabpanel" class="tab-pane" id="rechercherUtilisateur">
                            <div class="row">
                                <div class="col-md">
                                    <form method="POST" action="index.php?choixTraitement=tablette&action=fichePresence">
                                        <label for="unUtilisateur" class="required">Utilisateur</label><br>
                                        <select name="unUtilisateur" class="multiselect-dropdown form-control" data-live-search="true" required>
                                            <option disabled selected value="">Choisir</option>
                                            <?php foreach ($lesUtilisateurs as $unUtilisateur) { ?>
                                                    <option value="<?= $unUtilisateur['ID_UTILISATEUR'] ?>" name="unUtilisateur">
                                                        <?= $unUtilisateur['NOM'] ?> <?= $unUtilisateur['PRENOM'] ?>
                                                    </option>
                                            <?php } ?>
                                        </select>

                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="arrive" class="required">Date et Heure d'arrivé</label><br>
                                                <input type="datetime-local" class="form-control" name="arrive" required>
                                            </div>

                                            <div class="col-md">
                                                <label for="sortie" class="required">Date et Heure de sortie</label><br>
                                                <input type="datetime-local" class="form-control" name="sortie" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="uneActivitee" class="required">Activités</label><br>
                                                <select name="uneActivitee" class="multiselect-dropdown form-control" data-live-search="true" required>
                                                    <option disabled selected value="">Choisir</option>
                                                    <?php if (isset($lesActivites)) {
                                                        foreach ($lesActivites as $uneActivite) {
                                                            echo " <option " . $selectionner . " value='" . $uneActivite['ID_ACTIVITE'] . "' name='uneActivite'>" . stripslashes($uneActivite['NOM']) . "</option>";
                                                        } 
                                                    }?>
                                                </select>
                                            </div>
                                        </div>

                                        <input value="Valider la présence" type="submit" class="mt-3 btn btn-lg btn-success w-100">
                                    </form>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- custome.js -->
<script type="text/javascript" src="./vues/tablette/tablette.js"></script>

<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="./js/form-components/input-select.js"></script>



