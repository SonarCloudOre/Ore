<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Plateformes externes - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <?php if (isset($admin)) {
                        ?>
                        <button type="button" class="btn btn-primary" value="" onClick="imprimer2('sectionAimprimer2')">
                <span class="btn-icon-wrapper">
                  <i class="fa fa-print fa-w-20"></i>
                </span>
                        </button>
                    <?php } else {
                        ?>
                        <button type="button" class="btn btn-primary" value="" onClick="imprimer('sectionAimprimer')">
               <span class="btn-icon-wrapper">
                 <i class="fa fa-print fa-w-20"></i>
               </span>
                        </button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row" <?php if ((empty($numIntervenant)) && ($admin != 2)) {
        echo 'style="display: none;"';
    } ?>>
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab"
                               href="#consulterplateforme">
                                <span>Consulter</span>
                            </a>
                        </li>
                        <?php if ((isset($numIntervenant)) && ($admin >= 1)) { ?>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#ajouterplateforme">
                                    <span>Ajouter</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#modifierplateforme">
                                    <span>Modifier</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="consulterplateforme">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Liens externes</h5>
                    <div class="grid-menu grid-menu-2col">
                        <div class="no-gutters row">
                            <?php foreach ($lesPlateformes as $unePlateforme) {
                                echo '
                      <div class="col-sm-6">
                      <div class="btn-icon-vertical btn-transition  btn btn-outline-link">
                      <img src="./images/imageplateforme/' . $unePlateforme['logo'] . '" style="width: 350px;height: 150px; object-fit: cover; ">
                      <br><br>
                      <span class="badge badge-info badge-dot badge-dot-lg badge-dot-inside"></span>
                      ' . $unePlateforme['nom'] . '
                      <br><br>
                      <a style="text-decoration:none;" href="' . $unePlateforme['url'] . '" target="_blank"><button class="ladda-button mb-2 mr-2 btn btn-warning" data-style="slide-down">
                      <span class="ladda-label">Accéder</span>
                      <span class="ladda-spinner"></span>
                      </button></a>
                      <i> Identifiant : ' . $unePlateforme['login'] . '<br>
                      Mot de passe : ' . $unePlateforme['mdp'] . '<br>
                      ' . $unePlateforme['commentaires'] . '</i><br>
                      </div>
                      </div>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ((isset($numIntervenant)) && ($admin >= 0)) {
                echo '
              </div>
              <div role="tabpanel" class="tab-pane" id="ajouterplateforme">
              <div class="main-card mb-3 card">
              <div class="card-body">
              <h5 class="card-title">Ajouter une plateforme</h5>
              <form class="" action="index.php?choixTraitement=intervenant&action=ajoutplateformes" method="post" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-2">
                  <label for="Nom">Nom :</label>
                  <input class="form-control" type="text" name="Nom" value="" style="max-width:200px;">
                  </div>
                  <div class="col-md-2">
                  <label for="Logo">Logo :</label>
                  <input class="form-control" type="file" name="Logo" accept=".jpg,.jpeg,.png,.gif" style="max-width:200px;">
                  </div>
                  <div class="col-md-2">
                  <label for="Url">Url :</label>
                  <input class="form-control" type="text" name="Url" value="" style="max-width:200px;">
                  </div>
                  <div class="col-md-2">
                  <label for="Login">Login :</label>
                  <input class="form-control" type="text" name="Login" value="" style="max-width:200px;">
                  </div>
                  <div class="col-md-2">
                  <label for="Mdp">Mot de passe :</label>
                  <input class="form-control" type="password" name="Mdp" value="" style="max-width:200px;">
                  </div>
                  <div class="col-md-2">
                  <label for="Commentaires">Commentaires :</label>
                  <input class="form-control" type="text" name="Commentaires" value="" style="max-width:200px;">
                  </div>
                </div>
                <br/>
                <button type="submit" name="soumettre" class="mt-1 btn btn-primary float-right">Ajouter</button>
              </form>
              </div>
              </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="modifierplateforme">
              <div class="main-card mb-3 card">
              <div class="card-body">
              <h5 class="card-title">Modifier une plateforme</h5>
                <div class="grid-menu grid-menu-2col">
                  <div class="no-gutters row">';
                foreach ($lesPlateformes as $unePlateforme) {
                    echo '

                      <div class="col-sm-6">
                      <form class="" action="index.php?choixTraitement=eleve&action=modifplateformes&id=' . $unePlateforme['id'] . '" method="post" enctype="multipart/form-data">
                      <div style="text-align : center; padding-top : 1rem">
                      <img src="./images/imageplateforme/' . $unePlateforme['logo'] . '" style="width: 350px;height: 150px; object-fit: cover; ">
                      <br><br>
                      <span class="badge badge-info badge-dot badge-dot-lg badge-dot-inside"></span>
                      ' . $unePlateforme['nom'] . '
                      <br><br>
                      <label for="Login">Nom :</label>
                      <input class="form-control mx-auto" type="text" value="' . $unePlateforme['nom'] . '" name="Nom" style="max-width:400px; text-align: center"><br>
                      <label for="Login">Logo :</label>
                      <input class="form-control mx-auto" type="file" value="' . $unePlateforme['logo'] . '" name="Logo" style="max-width:400px; text-align: center"><br>
                      <label for="Login">Url :</label>
                      <input class="form-control mx-auto" type="text" value="' . $unePlateforme['url'] . '" name="Url" style="max-width:400px; text-align: center"><br>
                      <label for="Login">Login :</label>
                      <input class="form-control mx-auto" type="text" value="' . $unePlateforme['login'] . '" name="Login" style="max-width:400px; text-align: center"><br>
                      <label for="Mdp">Mot de passe :</label>
                      <input class="form-control mx-auto" type="text" value="' . $unePlateforme['mdp'] . '" name="Mdp" style="max-width:400px; text-align: center"><br>
                      <label for="Commentaires">Commentaires :</label>
                      <input class="form-control mx-auto" type="textarea" value="' . $unePlateforme['commentaires'] . '" name="Commentaires" style="max-width:400px; text-align: center"><br>
                      <table class="mx-auto">

        <tr>
            <th colspan="2"></th>
            <th colspan="2"></th>
        </tr>

    <tbody>
        <tr>
            <td><button type="submit" name="modifier" class="mt-1 btn btn-primary">Modifier</button></td>
            </form>
            <form class="" action="index.php?choixTraitement=eleve&action=supprimerplateformeeleves&id=' . $unePlateforme['id'] . '" method="post">
            <td><button type="submit" name="supprimer" class="mt-1 btn btn-danger">Supprimer</button></td>
            </form>
        </tr>
    </tbody>
</table>
                      </div>

                      </div>

                      ';
                }
                echo '
                    </div>
                  </div>

              </div>
              </div>
              </div>
              </div>
              ';
            }
            if ((isset($numIntervenant)) && ($admin >= 0)) {
                echo '</div>
</div>
</div>
</div>';
            }
            ?>
