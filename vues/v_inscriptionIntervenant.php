<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Inscription
                    <div class="page-title-subheading">Inscrire un nouveau intervenant</div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <div class="row">
                        <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                            <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="signupFormIntervenant" name="signupFormIntervenant" method="POST"
          action="index.php?choixTraitement=inscriptionIntervenants&action=valideInscription">
        <input type="hidden" name="annee" value="<?php echo $anneeEnCours; ?>">
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <div id="smartwizardIntervenant">
                                    <ul class="forms-wizard">
                                        <li>
                                            <a href="#step-1">
                                                <em>1</em>
                                                <span>Informations de l'intervenant</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-2">
                                                <em>2</em>
                                                <span>Spécialités de l'intervenant</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-3">
                                                <em>3</em>
                                                <span>Coordonnées bancaires de l'intervanant</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-4">
                                                <em>4</em>
                                                <span>Validation</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="form-wizard-content">
                                        <div id="step-1">
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="nom" class="required">Nom</label>
                                                        <input id="nom" name="nom" style="text-transform:uppercase"
                                                               placeholder="NOM" autofocus="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="prenom" class="required">Prénom</label>
                                                        <input id="selector" class="form-control"
                                                               style="text-transform:capitalize" name="prenom"
                                                               placeholder="Prénom">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="position-relative form-group">
                                                        <label for="actif" class="required">Actif ?</label>
                                                        <select name="actif" class="form-control" required>
                                                            <option value="1" name="actif">Oui</option>
                                                            <option value="0" name="actif">Non</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="statut" class="required">Statut </label>
                                                        <select name="statut" class="form-control" required>
                                                            <option value="Bénévole" selected="selected" name="statut">
                                                                Bénévole
                                                            </option>
                                                            <option value="Service Civique" name="statut">Service
                                                                Civique
                                                            </option>
                                                            <option value="Salarié" name="statut">Salarié</option>
                                                            <option value="Stagiaire" name="statut">Stagiaire</option>
                                                            <option value="Bénévole nbH" name="statut">Bénévole nbH</option>
                                                            <option value="BSB" name="statut">BSB</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="date_naissance" class="required" class="required">Date
                                                            de naisssance</label>
                                                        <input type="date" class="form-control" name="date_naissance"
                                                               placeholder="00-00-0000" autofocus=""
                                                               required=""><br><br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="lieu_naissance" class="required">Lieu de
                                                            naissance</label>
                                                        <input class="form-control" name="lieu_naissance" required
                                                               autofocus="">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="nationalite" class="required">Nationalite</label>
                                                    <input class="form-control" name="nationalite" required=""
                                                           autofocus="">
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="email" class="required">E-mail</label>
                                                        <input class="form-control" name="email"
                                                               placeholder="xxxx@xxxxx.xx" required="" type="email">
                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="tel" class="required">Téléphone </label>
                                                        <input class="form-control" name="tel" autofocus="" required="">
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <label for="adresse" class="required">Adresse</label>
                                                    <input class="form-control" name="adresse" autofocus="" required="">
                                                </div>
                                                <?php
                                                $LstVilles = array();
                                                $LstCP = array();
                                                for ($i = 0; $i < count($villesFrance); $i++) {
                                                    $ville = $villesFrance[$i]["COMMUNE"];
                                                    $cp = $villesFrance[$i]["CP"];
                                                    array_push($LstVilles, $ville);
                                                    array_push($LstCP, $cp);
                                                }
                                                ?>
                                                <link rel="stylesheet" href="./styles/css/jquery-ui.css">
                                                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                                <script>
                                                    $(function () {
                                                        var villes = <?php echo json_encode($LstVilles); ?>;
                                                        var cp = <?php echo json_encode($LstCP); ?>;
                                                        $("input[name='ville']").autocomplete({
                                                            source: villes,
                                                        });
                                                        $("input[name='cp']").autocomplete({
                                                            source: cp,
                                                        });
                                                    });

                                                    $(function () {
                                                        $("input[name='ville']").change(function () {
                                                            var villes = <?php echo json_encode($LstVilles); ?>;
                                                            var cp = <?php echo json_encode($LstCP); ?>;
                                                            var a = $("input[name='ville']").val();
                                                            indexVille = villes.indexOf(a);
                                                            //alert(indexVille);
                                                            var cpText = cp[indexVille];
                                                            //alert(cpText);
                                                            $("input[name='cp']").val(cpText);
                                                        });
                                                    });

                                                    $(function () {
                                                        $("input[name='cp']").change(function () {
                                                            var villes = <?php echo json_encode($LstVilles); ?>;
                                                            var cp = <?php echo json_encode($LstCP); ?>;
                                                            var a = $("input[name='cp']").val();
                                                            indexCp = cp.indexOf(a);
                                                            //alert(indexVille);
                                                            var villeText = villes[indexCp];
                                                            //alert(cpText);
                                                            $("input[name='ville']").val(villeText);
                                                        });
                                                    });

                                                </script>
                                                <div class="col-md-2">
                                                    <label for="cp" class="required">Code Postal</label>
                                                    <input class="form-control" name="cp" autofocus="" required="">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="ville" class="required">Ville</label>
                                                    <input class="form-control" name="ville" autofocus="" required="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="numsecu">Numéro de Sécurité Sociale</label>
                                                    <input class="form-control" name="numsecu" autofocus="">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="password">Code Personnel</label>
                                                    <input class="form-control" name="password" autofocus="">
                                                </div>

                                            </div>
                                        </div>

                                        <div id="step-2">


                                            <div data-parent="#accordion" id="collapseOne"
                                                 aria-labelledby="headingOne" class="collapse show">

                                                <div class="form-row">
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-group">
                                                            <label for="diplome" class="required">Diplôme</label>
                                                            <input class="form-control" name="diplome" autofocus=""
                                                                   required=""><br>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <label for="commentaires">Autres précisions à signaler ? Un
                                                                commentaire ?<br/>
                                                            </label>
                                                            <textarea name="commentaires"
                                                                      class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <legend>Spécialités</legend>

                                                            <?php
                                                            foreach ($lesMatieres as $uneLigne) {

                                                                echo '<div class="custom-checkbox custom-control">
                                  <input type="checkbox" id=' . $uneLigne['NOM'] . ' class="custom-control-input" name="specialites[]" value=' . $uneLigne['ID'] . '>
                                  <label class="custom-control-label" for=' . $uneLigne["NOM"] . '>' . $uneLigne["NOM"] . '</label>
                              </div>';
                                                            }
                                                            ?>


                                                        </div>
                                                    </div>

                                                </div>

                                            </div>


                                        </div>
                                        <div id="step-3">


                                            <div data-parent="#accordion" id="collapseOne"
                                                 aria-labelledby="headingOne" class="collapse show">


                                                <div class="col-md-4">
                                                    <label for="compte">RIB (avec clé)</label>
                                                    <input class="form-control" name="compte" autofocus=""><br>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="iban">IBAN </label>
                                                    <input class="form-control" name="iban" autofocus=""><br>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="bic">BIC </label>
                                                    <input class="form-control" name="bic" autofocus=""><br>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="banque">Votre Banque</label>
                                                    <input type="text" name="banque" value="">

                                                </div>
                                            </div>
                                        </div>

                                        <div id="step-4">
                                            <div class="no-results">
                                                <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                                    <div class="swal2-success-circular-line-left"
                                                         style="background-color: rgb(255, 255, 255);"></div>
                                                    <span class="swal2-success-line-tip"></span>
                                                    <span class="swal2-success-line-long"></span>
                                                    <div class="swal2-success-ring"></div>
                                                    <div class="swal2-success-fix"
                                                         style="background-color: rgb(255, 255, 255);"></div>
                                                    <div class="swal2-success-circular-line-right"
                                                         style="background-color: rgb(255, 255, 255);"></div>
                                                </div>
                                                <div class="results-subtitle mt-4">Inscription finalisée!</div>
                                                <div class="results-title">l'intervenant a bien été inscrit et est
                                                    enregistré dans la base
                                                </div>
                                                <div class="mt-3 mb-3"></div>
                                                <div class="text-center">
                                                    <a href="index.php?choixTraitement=inscriptionEleves&action=index">
                                                        <button type="button"
                                                                class="btn-shadow btn-wide btn btn-success btn-lg">
                                                            Ajouter un autre intervenant
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="clearfix">
                                    <button type="button" id="reset-btn2" class="btn-shadow float-left btn btn-link">
                                        Annuler
                                    </button>
                                    <button type="button" id="next-btn2"
                                            class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">
                                        Suivant
                                    </button>
                                    <button type="button" id="prev-btn2"
                                            class="btn-shadow float-right btn-wide btn-pill mr-3 btn btn-outline-secondary">
                                        précédent
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- custome.js -->
    <script type="text/javascript" src="./vendors/smartwizard/dist/js/jquery.smartWizard.min.js"></script>
    <script type="text/javascript" src="./js/form-components/form-wizard.js"></script>
    <script type="text/javascript" src="./js/form-components/form-validation.js"></script>
</div>
<script type="text/javascript" src="./vendors/metismenu/dist/metisMenu.js"></script>
<script type="text/javascript" src="./vendors/jquery-validation/dist/jquery.validate.min.js"></script>
