<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Informations personnelles
                    <?php
                    if (isset($_SESSION["intervenant"])) {
                        echo '<div class="page-title-subheading">' . $_SESSION["intervenant"]["PRENOM"] . ' ' . $_SESSION["intervenant"]["NOM"] . '</div>';
                    } else {
                        echo '<div class="page-title-subheading">Sélectionner un élève pour accéder à sa fiche</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="page-title-actions">
                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h4 class="card-title">Informations personnelles</h4>
                    <input type="hidden" name="unIntervenant" value="<?php echo $inter['ID_INTERVENANT']; ?>">

                    <div class="row">
                        <div class="position-relative form-group col-md-3">
                            <label for="nom">Nom </label>
                            <input class="form-control" name="nom" value="<?php echo $inter['NOM']; ?>" autofocus=""
                                   readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-2">
                            <label for="prenom">Prénom </label>
                            <input class="form-control" name="prenom" value="<?php echo $inter['PRENOM']; ?>"
                                   autofocus="" readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-2">
                            <label for="date_naissance">Date de naisssance </label>
                            <input class="form-control" name="date_naissance" type="date"
                                   value="<?php echo $inter['DATE_DE_NAISSANCE']; ?>" autofocus="" readonly
                                   placeholder="00-00-0000"><br>
                        </div>

                        <div class="position-relative form-group col-md-3">
                            <label for="lieu_naissance">Lieu de naissance</label>
                            <input class="form-control" name="lieu_naissance"
                                   value="<?php echo $inter['LIEU_DE_NAISSANCE']; ?>" autofocus="" readonly><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="position-relative form-group col-md-3">
                            <label for="email">Votre E-mail</label>
                            <input class="form-control" name="email" value="<?php echo $inter['EMAIL']; ?>" type="email"
                                   readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-2">
                            <label for="tel">Téléphone </label>
                            <input class="form-control" name="tel" value="<?php echo $inter['TELEPHONE']; ?>"
                                   autofocus="" readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-5">
                            <label for="adresse">Adresse</label>
                            <input class="form-control" name="adresse" value="<?php echo $inter['ADRESSE_POSTALE']; ?>"
                                   autofocus="" readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-2">
                            <label for="cp">Code Postal</label>
                            <input class="form-control" name="cp" type="number"
                                   value="<?php echo $inter['CODE_POSTAL']; ?>" autofocus="" readonly><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="position-relative form-group col-md-4">
                            <label for="ville">Ville</label>
                            <input class="form-control" name="ville" value="<?php echo $inter['VILLE']; ?>" autofocus=""
                                   readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-2">
                            <label for="diplome">Diplôme</label>
                            <input class="form-control" name="diplome" value="<?php echo $inter['DIPLOME']; ?>"
                                   autofocus="" readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-3">
                            <label for="numsecu">Numéro de Sécurité Sociale</label>
                            <input class="form-control" name="numsecu" type="number"
                                   value="<?php echo $inter['SECURITE_SOCIALE']; ?>" autofocus="" readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-3">
                            <label for="nationalite">Nationalité</label>
                            <input class="form-control" name="nationalite" value="<?php echo $inter['NATIONALITE']; ?>"
                                   autofocus="" readonly><br>
                        </div>

                        <div class="position-relative form-group col-md-3">
                            <label for="password">Mot de passe <small>(ne rien changer si vous ne souhaitez pas le
                                    modifier)</small></label>
                            <input class="form-control" type="password" name="password" autofocus="" readonly><br>
                        </div>
                    </div>

                    <a href="index.php?choixTraitement=intervenant&action=contact">
                        <button class="btn btn-primary">Nous contacter</button>
                    </a>
                </div>
            </div>
        </div>
    </div>


</div>
