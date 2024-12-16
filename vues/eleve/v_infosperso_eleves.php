<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Informations personnelles - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <a href="index.php?choixTraitement=eleve&action=macarte">
                        <button type="button" class="btn-shadow dropdown-toggle btn btn-info">
                                          <span class="btn-icon-wrapper pr-2">
                                              <i class="fa fa-business-time fa-w-20"></i>
                                          </span>
                            Accéder à ma carte ORE
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Élève</h5>
            <div class="position-relative form-group">
                <label for="exampleAddress" class="">Numéro</label>
                <input name="address" id="exampleAddress"
                       placeholder=""
                       type="text" class="form-control" readonly value="<?php echo $intervenant["ID_ELEVE"] ?>">
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="exampleEmail11" class="">Nom</label>
                        <input name="email" id="exampleEmail11"
                               placeholder="with a placeholder" type="text" class="form-control" readonly
                               value="<?php echo $intervenant["NOM"] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="examplePassword11" class="">Prénom</label>
                        <input name="password" id="examplePassword11"
                               placeholder="password placeholder"
                               type="text" class="form-control" readonly value="<?php echo $intervenant["PRENOM"] ?>">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="exampleEmail11" class="">Sexe</label>
                        <input name="email" id="exampleEmail11"
                               placeholder="with a placeholder" type="text" class="form-control" readonly
                               value="<?php if ($intervenant["SEXE"] == "F") {
                                   echo "Femme";
                               }
                               if ($intervenant["SEXE"] == "H") {
                                   echo "Homme";
                               } ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="examplePassword11" class="">Date de naissance</label>
                        <input name="password" id="examplePassword11"
                               placeholder="password placeholder"
                               type="text" class="form-control" readonly
                               value="<?php echo $intervenant["DATE_DE_NAISSANCE"] ?>">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="exampleEmail11" class="">Téléphone</label>
                        <input name="teleleve" id="exampleEmail11"
                               placeholder="with a placeholder" type="text" class="form-control"
                               value="<?php echo $infospersosEleve["TÉLÉPHONE_DE_L_ENFANT"] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="examplePassword11" class="">Email</label>
                        <input name="emaileleve" id="examplePassword11"
                               placeholder="password placeholder"
                               type="text" class="form-control"
                               value="<?php echo $infospersosEleve["EMAIL_DE_L_ENFANT"] ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Parents</h5>
            <div class="position-relative form-group">
                <label for="exampleAddress" class="">Nom et Prénom du Responsable légal</label>
                <input name="address" id="exampleAddress"
                       placeholder=""
                       type="text" class="form-control" readonly
                       value="<?php echo $intervenant["RESPONSABLE_LEGAL"] ?>">
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="exampleEmail11" class="">Profession du père</label>
                        <input name="email" id="exampleEmail11"
                               placeholder="with a placeholder" type="text" class="form-control" readonly
                               value="<?php echo $intervenant["PROFESSION_DU_PÈRE"] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="examplePassword11" class="">Profession de la mère</label>
                        <input name="password" id="examplePassword11"
                               placeholder="password placeholder"
                               type="text" class="form-control" readonly
                               value="<?php echo $intervenant["PROFESSION_DE_LA_MÈRE"] ?>">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="exampleEmail11" class="">Téléphone des parents 1 (portable)</label>
                        <input name="email" id="exampleEmail11"
                               placeholder="with a placeholder" type="text" class="form-control" readonly
                               value="<?php echo $intervenant["TÉLÉPHONE_DES_PARENTS"] ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="examplePassword11" class="">Téléphone des parents 2 (fixe)</label>
                        <input name="password" id="examplePassword11"
                               placeholder="password placeholder"
                               type="text" class="form-control" readonly
                               value="<?php echo $intervenant["TÉLÉPHONE_DES_PARENTS2"] ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="examplePassword11" class="">Email des parents</label>
                        <input name="password" id="examplePassword11"
                               placeholder="password placeholder"
                               type="text" class="form-control" readonly
                               value="<?php echo $intervenant["EMAIL_DES_PARENTS"] ?>">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="position-relative form-group">
                        <label for="exampleCity" class="">Adresse</label>
                        <input name="city" id="exampleCity" type="text" class="form-control" readonly
                               value="<?php echo $intervenant["ADRESSE_POSTALE"] ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="position-relative form-group">
                        <label for="exampleZip" class="">Code postal</label>
                        <input name="zip" id="exampleZip" type="text" class="form-control" readonly
                               value="<?php echo $intervenant["CODE_POSTAL"] ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="position-relative form-group">
                        <label for="exampleState" class="">Ville</label>
                        <input name="state" id="exampleState" type="text" class="form-control" readonly
                               value="<?php echo $intervenant["VILLE"] ?>">
                    </div>
                </div>
            </div>
            <a href="index.php?choixTraitement=eleve&action=contact&numsubject=1">
                <button class="mt-2 btn btn-primary">Demander une modification</button>
            </a>

        </div>
    </div>
</div>
