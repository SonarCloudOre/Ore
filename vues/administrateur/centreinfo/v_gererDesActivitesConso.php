<div id="contenu">
    <link rel="stylesheet" type="text/css" href="./styles/css/fablab.css">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Gestion des activités/consommables
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm text_container">
            <!-- Bouton "Ajouter une activité" -->
            <button id="togg1" class="btn btn-primary btn-lg btn-block btn-success mb-3">
                Ajouter une activité
            </button>
            
            <div id="d1" style="display:none"> <!-- Div à cacher -->
                <!-- Ajouter une activité -->
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=info_gererDesActivitesConso" enctype="multipart/form-data">
                            <div class="form-row col-md">
                                <div class="col-md-11">
                                    <h4 class="card-title">Ajouter une activité</h4>
                                </div>
                                <div class="col-md">
                                    <i class="metismenu-icon pe-7s-plus"></i>
                                </div>
                            </div>

                            <div class="col-md mb-3">
                                <label for="Nom" class="required">Nom</label>
                                <input type="text" class="form-control" name="NOM" id="Nom" placeholder="Nom de l'activité" required>
                            </div>

                            <div class="col-md mb-3">
                                <label for="Description" class="required">Description</label>
                                <textarea class="form-control" name="DESCRIPTION" id="Description" placeholder="Description de l'activité" required></textarea>
                            </div>

                            <div class="col-md mb-3">
                                <label for="Prix" class="required">Prix</label>
                                <input type="text" class="form-control" name="PRIX" id="Prix" placeholder="Prix de l'activité" required>
                            </div>

                            <div class="col-md mb-3">
                                <label for="Photo" class="required">Photo</label>
                                <input type="file" class="form-control" name="PHOTO" id="Photo" accept="image/png, image/jpeg" required>
                            </div>

                            <div class="col-md mb-3">
                                <label for="ADHERENT" class="required">L'utilisateur doit-il être adhérent ?</label>
                                <select class="form-control" name="ADHERENT" id="ADHERENT" required>
                                    <option value="1" selected>Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </div>

                            <div class="col-md mb-3">
                                <input name="AjouterActivite" value="Ajouter" type="submit" class="form-control btn btn-success mt-3">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm text_container">
            <!-- Bouton "Ajouter une activité" -->
            <button id="togg2" class="btn btn-primary btn-lg btn-block btn-success mb-3">
                Ajouter un consommable
            </button>

            <div id="d2" style="display:none"> <!-- Div à cacher -->
                <!-- Ajouter un consommable -->
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=info_gererDesActivitesConso" enctype="multipart/form-data">
                            <div class="form-row col-md">
                                <div class="col-md-11">
                                    <h4 class="card-title">Ajouter un consommable</h4>
                                </div>
                                <div class="col-md">
                                    <i class="metismenu-icon pe-7s-plus"></i>
                                </div>
                            </div>

                            <div class="col-md mb-3">
                                <label for="Nom" class="required">Nom</label>
                                <input type="text" class="form-control" name="NOM" id="Nom" placeholder="Nom du consommable" required>
                            </div>

                            <div class="col-md mb-3">
                                <label for="Description" class="required">Description</label>
                                <textarea class="form-control" name="DESCRIPTION" id="Description" placeholder="Description du consommable" required></textarea>
                            </div>

                            <div class="col-md mb-3">
                                <label for="Prix" class="required">Prix</label>
                                <input type="text" class="form-control" name="PRIX" id="Prix" placeholder="Prix du consommable" required>
                            </div>

                            <div class="col-md mb-3">
                                <label for="Photo" class="required">Photo</label>
                                <input type="file" class="form-control" name="PHOTO" id="Photo" accept="image/png, image/jpeg" required>
                                </select>
                            </div>

                            <div class="col-md mb-3">
                                <input name="AjouterConsommable" value="Ajouter" type="submit" class="form-control btn btn-success mt-3">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <!-- Tableau des activités -->
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Liste des activités</h5>
                <table class="table">
                    <thead>
                        <tr style="text-align:center">
                            <th hidden>Id</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Photo</th>
                            <th>Doit-être adhérent ?</th>
                            <th>Désactiver</th>
                            <th>Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lesActivites as $uneActivite) {?>
                            <tr style="text-align:center">
                                <td hidden><?=$uneActivite['ID_ACTIVITE'] ?></td>
                                <td><?=$uneActivite['NOM'] ?></td>
                                <td><?=$uneActivite['DESCRIPTION'] ?></td>
                                <td><?=$uneActivite['PRIX'] ?> €</td>
                                <td>
                                    <div class="hover-title"><p>Survolez pour voir l'image</p></div>
                                    <div class="hover-image"><img src="images/activites/<?=$uneActivite['PHOTO'] ?>" class="img-thumbnail"></div>
                                </td>
                                <td><?=$uneActivite['ADHERENT'] == 1 ? "Oui" : "Non" ?></td>
                                <td><?=$uneActivite['DESACTIVER'] == 1 ? "Oui" : "Non" ?></td>
                                <td><a class='btn btn-primary' href="index.php?choixTraitement=administrateur&action=info_modifActivite&ID=<?=$uneActivite['ID_ACTIVITE'] ?>" class="btn btn-info"><span class='pe-7s-pen'></span></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Tableau des consommables -->
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Liste des consommables</h5>
                <table class="table">
                    <thead>
                        <tr style="text-align:center">
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Photo</th>
                            <th>Désactiver</th>
                            <th>Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lesConsommables as $unConsommable) {?>
                            <tr style="text-align:center">
                                <td><?=$unConsommable['NOM'] ?></td>
                                <td><?=$unConsommable['DESCRIPTION'] ?></td>
                                <td><?=$unConsommable['PRIX'] ?> €</td>
                                <td>
                                    <div class="hover-title"><p>Survolez pour voir l'image</p></div>
                                    <div class="hover-image"><img src="images/consommables/<?=$unConsommable['PHOTO'] ?>" class="img-thumbnail"></div>
                                </td>
                                <td><?=$unConsommable['DESACTIVER'] == 1 ? "Oui" : "Non" ?></td>
                                <td><a class='btn btn-primary' href="index.php?choixTraitement=administrateur&action=info_modifConsommable&ID=<?=$uneActivite['ID_ACTIVITE'] ?>" class="btn btn-info"><span class='pe-7s-pen'></span></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
                
</div>

<script type="text/javascript" src="./js/gererDesActivitesConso.js"></script>