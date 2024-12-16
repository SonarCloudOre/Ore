<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Inscription élève
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <button type="button" class="mr-2 btn btn-primary"
                            onclick="document.location.href='index.php?choixTraitement=administrateur&action=index'">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php //iframe permet d'éviter de rediriger la page
    //<iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe>
    //target="hiddenFrame"?>
    <form id="signupForm" name="signupForm" method="post"
          action="index.php?choixTraitement=inscriptionEleves&action=valideInscription">


        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="nom"><i class="fa fa-file"></i> Importer les infos d'un élève</label>
                                        <select class="multiselect-dropdown form-control"
                                                name="importEleve">
                                            <option value="-1" disabled="disabled" selected="selected">Choisir</option>
                                            <?php
                                            foreach ($lesEleves as $uneLigne) {
                                                echo '<option  value="' . $uneLigne['ID_ELEVE'] . '">' . $uneLigne['NOM'] . ' ' . $uneLigne['PRENOM'] . '</option>';
                                            }
                                            ?>
                                        </select>

                                        <script>
                                            $("select[name='importEleve']").on('change', function () {
                                                var eleveChoisi = $(this).children("option:selected").val();
                                                var jqXHR = $.ajax({ //<-- One . was missing before ajax
                                                    async: false,
                                                    type: "POST",
                                                    dataType: 'JSON',
                                                    url: 'index.php?choixTraitement=inscriptionEleves&action=recupImportEleve',
                                                    data: {eleve: eleveChoisi}, // <-- Comma was missing here
                                                });

                                                var res = jqXHR.responseText.split("~");
                                                var array = [];
                                                array.push(jqXHR.responseText);
                                                $("input[name='nom']").val(res[0]);
                                                $("input[name='responsable_legal']").val(res[1]);
                                                $("input[name='profession_pere']").val(res[2]);
                                                $("input[name='profession_mere']").val(res[3]);
                                                $("input[name='adresse']").val(res[4]);
                                                $("input[name='cp']").val(res[5]);
                                                $("input[name='ville']").val(res[6]);
                                                $("input[name='tel_parent']").val(res[7]);
                                                $("input[name='tel_parent2']").val(res[8]);
                                                $("input[name='tel_parent3']").val(res[9]);
                                                $("input[name='fratries']").val(res[10]);
                                            });
                                        </script>

                                    </div>
                                </div>
                                <div id="smartwizard">
                                    <ul class="forms-wizard">
                                        <li>
                                            <a href="#step-1">
                                                <em>1</em>
                                                <span>Informations de l'élève</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-2">
                                                <em>2</em>
                                                <span>Scolarité</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-3">
                                                <em>3</em>
                                                <span>Responsables légaux</span>
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
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">

                                                        <label for="nom" class="required">Nom</label>
                                                        <input id="nom" name="nom" style="text-transform:uppercase"
                                                               placeholder="NOM" autofocus="" value=""
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="prenom" class="required">Prénom</label>
                                                        <input id="selector" class="form-control"
                                                               style="text-transform:capitalize" name="prenom"
                                                               placeholder="Prénom">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="sexe" class="required">Sexe</label>
                                                    <select class="form-control" id="sexe" name="sexe">
                                                        <option value="F" name="sexe">Femme</option>
                                                        <option value="H" name="sexe">Homme</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="date_naissance" class="required">Date de
                                                            naisssance</label><br>
                                                        <?php formulaireDate(0, 0, 2000, "date_naissance"); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-2">
                                                    <div class="position-relative form-group">
                                                        <label for="tel_enfant">Téléphone de l'enfant</label>
                                                        <input class="form-control" type="tel" name="tel_enfant" id="tel_enfant" placeholder="0000000000">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                        <label for="email_enfant">Email de l'enfant</label>
                                                        <input type="email" class="form-control" value="" name="email_enfant" placeholder="xxxx@xxxxx.xx" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="step-2">


                                            <div data-parent="#accordion" id="collapseOne"
                                                 aria-labelledby="headingOne" class="collapse show">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="annee" class="required">Année scolaire</label>
                                                            <input class="form-control" id="annee" name="annee"
                                                                   type="number" required style="width:200px;"
                                                                   value="<?php echo $anneeEnCours; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="etab" class="required">Établissement</label>
                                                            <select class="form-control selectpicker"
                                                                    data-live-search="true" id="etab" name='etab'
                                                                    style='width:200px;' required>
                                                                <?php
                                                                foreach ($lesEtablissements as $uneLigne) {
                                                                    echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="classe" class="required">Classe</label>
                                                            <select class="form-control" id="classe" name="classe"
                                                                    style="width:200px;" required>
                                                                <?php
                                                                foreach ($lesClasses as $uneLigne) {
                                                                    echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">


                                                        <div class="position-relative form-group">
                                                            <label for="filiere" class="required">Filière</label>
                                                            <select class="form-control" id="filiere" name='filiere'
                                                                    style='width:200px;' required>
                                                                <?php
                                                                foreach ($lesfilieres as $uneLigne) {
                                                                    echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="lv1" class="required">LV1</label>
                                                            <select class="form-control" id="lv1" name='lv1'
                                                                    style='width:200px;' required>
                                                                <?php
                                                                foreach ($lesLangues as $uneLigne) {
                                                                    echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="lv2" class="required">LV2</label>
                                                            <select class="form-control" id="lv2" name='lv2'
                                                                    style='width:200px;' required>
                                                                <?php
                                                                foreach ($lesLangues as $uneLigne) {
                                                                    echo '<option  value="' . $uneLigne['ID'] . '">' . $uneLigne['NOM'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="prof_principal">Professeur principal</label>
                                                            <input class="form-control" id="prof_principal"
                                                                   name="prof_principal"
                                                                   style="width:200px; text-transform:capitalize">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <h2>Difficultés scolaires</h2>
                                                            <br>
                                                            <?php
                                                            foreach ($lesMatieres as $uneLigne) {

                                                                echo '
                              <div class="custom-checkbox custom-control">
                              <input type="checkbox" id="D_' . $uneLigne['NOM'] . '" class="custom-control-input" name="difficultes[]" value=' . $uneLigne['ID'] . ' required>
                              <label class="custom-control-label" for="D_' . $uneLigne["NOM"] . '">' . $uneLigne["NOM"] . '</label>
                              </div>
                              ';
                                                            }
                                                            ?>


                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group div-specialitesA">
                                                            <h2>Spécialités (1ère & T)</h2>
                                                            <br>
                                                            <?php
                                                            foreach ($lesSpecialites as $uneLigne) {

                                                                echo '
                              <div class="custom-checkbox custom-control">
                              <input type="checkbox" id="S_' . $uneLigne['NOM'] . '" class="custom-control-input specialitesA" name="specialitesA[]" value=' . $uneLigne['ID'] . '>
                              <label class="custom-control-label specialitesA" for="S_' . $uneLigne["NOM"] . '">' . $uneLigne["NOM"] . '</label>
                              </div>
                              ';

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

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-group">
                                                            <label for="responsable_legal" class="required">Nom et
                                                                prénom du responsable légal</label>
                                                            <input class="form-control" name="responsable_legal"
                                                                   style="text-transform:capitalize">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-group">
                                                            <label for="tel_parent" class="required">Téléphone des
                                                                parents 1 (portable)</label>
                                                            <input class="form-control" name="tel_parent">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="position-relative form-group">
                                                            <label for="tel_parent">Téléphone des parents 2
                                                                (fixe)</label>
                                                            <input class="form-control" name="tel_parent2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-group">
                                                            <label for="tel_parent">Téléphone des parents 3
                                                                (autre...)</label>
                                                            <input class="form-control" name="tel_parent3">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-group">
                                                            <label for="profession_pere">Profession du père</label>
                                                            <input class="form-control"
                                                                   style="text-transform:capitalize"
                                                                   name="profession_pere">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-group">
                                                            <label for="profession_mere">Profession de la mère</label>
                                                            <input class="form-control"
                                                                   style="text-transform:capitalize"
                                                                   name="profession_mere">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group">
                                                            <label for="adresse" class="required">Rue</label>
                                                            <input class="form-control" style="text-transform:uppercase"
                                                                   name="adresse" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="position-relative form-group">
                                                            <label for="cp" class="required">Code postal</label>
                                                            <input class="form-control" id="cp" name="cp" value="">
                                                        </div>
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
                                                    <script
                                                        src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                                    <script>
                                                        $(function () {
                                                            var villes = <?php echo json_encode($LstVilles); ?>;
                                                            var cp = <?php echo json_encode($LstCP); ?>;
                                                            $("#ville").autocomplete({
                                                                source: villes,
                                                            });
                                                            $("#cp").autocomplete({
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


                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="ville" class="required">Ville</label>
                                                            <div class="ui-widget">
                                                                <input id="ville" class="form-control"
                                                                       style="text-transform:uppercase" name="ville"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="email_parent">Email des parents</label>
                                                            <input class="form-control" name="email_parent"
                                                                   placeholder="xxxx@xxxxx.xx" type="email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-2">
                                                        <label for="prevenir_parent" class="required">Prévenir en cas d'absence de votre enfant ?</label>
                                                        <select class="form-control" name="prevenir_parent">
                                                            <option value="1" name="prevenir_parent">Oui</option>
                                                            <option value="0" name="prevenir_parent">Non</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="fratries" id="fratries" value="">
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="position-relative form-group">
                                                            <legend>Autre</legend>
                                                            <label for="commentaires">Autres précisions à signaler :
                                                                classe, établissements particuliers, difficultés
                                                                scolaires particulières, questions...<br/><br>
                                                            </label>
                                                            <textarea class="form-control"
                                                                      name="commentaires"></textarea><br>
                                                            <div class="custom-checkbox custom-control">
                                                                <input class="custom-control-input"
                                                                       name="responsabilite" type="checkbox" value="1"
                                                                       checked="checked" required/>
                                                                <label class="custom-control-label"
                                                                       for="responsabilite">L'association décline toute
                                                                    responsabilité en cas de perte, vol, dégradation de
                                                                    tout objet possédé par l'élève (téléphone portable,
                                                                    tablette, montre, etc...)</label>
                                                            </div>
                                                            <br><br>
                                                        </div>
                                                    </div>
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
                                                <div class="results-title">l'élève a bien été inscrit et est enregistré
                                                    dans la base
                                                </div>
                                                <div class="mt-3 mb-3"></div>
                                                <div class="text-center">
                                                    <a href="index.php?choixTraitement=inscriptionEleves&action=index">
                                                        <button type="button"
                                                                class="btn-shadow btn-wide btn btn-success btn-lg">
                                                            Ajouter un autre élève
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="clearfix">
                                    <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">
                                        Annuler
                                    </button>
                                    <button type="button" id="next-btn"
                                            class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-primary">
                                        Suivant
                                    </button>
                                    <button type="button" id="prev-btn"
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


    <script type="text/javascript">
        var anneeencours = '<?php echo($_SESSION["anneeExtranet"]);?>';
        $("input[name='annee']").change(function () {
            //alert(annee);
            if ($("input[name='annee']").val() > anneeencours) {
                var nouvelleannee = $("input[name='annee']").val();
                var oui = confirm('Souhaitez-vous modifier l\'année "' + anneeencours + '" par l\'année "' + nouvelleannee + '" ?\nL\'année scolaire actuel est "' + anneeencours + '".\n(Cliquer sur "Ok" pour valider)');
                if (oui == true) {
                    $("input[name='annee']").val(nouvelleannee);
                } else {
                    $("input[name='annee']").val(anneeencours);
                }
            }
        });

    </script>

    <!-- custome.js -->
    <script type="text/javascript" src="./vendors/smartwizard/dist/js/jquery.smartWizard.min.js"></script>
    <script type="text/javascript" src="./js/form-components/form-wizard.js"></script>
    <script type="text/javascript" src="./js/form-components/form-validation.js"></script>

    <script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
    <script type="text/javascript"
            src="./vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="./js/form-components/input-select.js"></script>

</div>

<script type="text/javascript" src="./vendors/metismenu/dist/metisMenu.js"></script>
<script type="text/javascript" src="./vendors/jquery-validation/dist/jquery.validate.min.js"></script>


<script type="text/javascript">
    //On limite le nombre de choix à deux pour les Spécialités
    $('input.specialitesA').on('change', function (evt) {
        if ($('input.specialitesA:checked').length > 2) {
            this.checked = false;
        }
    });

    //On affiche les Spécialités si l'élève est en première ou en terminale

    //initially hide the textbox
    $(".div-specialitesA").hide();
    $('#classe').on('change', function () {
        if ($("#classe").find('option:selected').val() == 55 || $("#classe").find('option:selected').val() == 56) {
            $(".div-specialitesA").show();
        } else {
            $(".div-specialitesA").hide();
            if ($('input.specialitesA:checked').length > 0) {
                $("input.specialitesA").prop("checked", false);
            }
        }
    });

</script>
