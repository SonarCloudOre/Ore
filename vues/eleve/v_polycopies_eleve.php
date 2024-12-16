<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Polycopies
                    <div class="page-title-subheading">Consulter les polycopies</div>
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

    <div class="row" <?php if ((empty($numIntervenant)) && ($admin != 2)) {
        echo 'style="display: none;"';
    } ?>>
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab"
                               href="#consulterpolycopies">
                                <span>Consulter</span>
                            </a>
                        </li>
                        <?php if ((isset($numIntervenant)) && ($admin >= 0)) { ?>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#ajouterpolycopies">
                                    <span>Ajouter</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="consulterpolycopies">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Classes</h5>
                    <div class="position-relative form-group">
                        <div>

                            <div class="mb-2 mr-2 btn btnn active btn-primary">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="6ème" class="custom-control-input" name="fl-classe"
                                           value="6ème">
                                    <label class="custom-control-label" for="6ème">6ème</label>
                                </div>
                                <span id="Count6" class="badge badge-pill badge-light"></span></div>
                            <div class="mb-2 mr-2 btn btnn active btn-alternate">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="5ème" class="custom-control-input" name="fl-classe"
                                           value="5ème">
                                    <label class="custom-control-label" for="5ème">5ème</label>
                                </div>
                                <span id="Count5" class="badge badge-pill badge-light"></span>
                            </div>
                            <div class="mb-2 mr-2 btn btnn active btn-secondary">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="4ème" class="custom-control-input" name="fl-classe"
                                           value="4ème">
                                    <label class="custom-control-label" for="4ème">4ème</label>
                                </div>
                                <span id="Count4" class="badge badge-pill badge-light"></span>
                            </div>
                            <div class="mb-2 mr-2 btn btnn active btn-success">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="3ème" class="custom-control-input" name="fl-classe"
                                           value="3ème">
                                    <label class="custom-control-label" for="3ème">3ème</label>
                                </div>
                                <span id="Count3" class="badge badge-pill badge-light"></span>
                            </div>
                            <div class="mb-2 mr-2 btn btnn active btn-info">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="Seconde" class="custom-control-input" name="fl-classe"
                                           value="Seconde">
                                    <label class="custom-control-label" for="Seconde">2nd</label>
                                </div>
                                <span id="Count2" class="badge badge-pill badge-light"></span>
                            </div>
                            <div class="mb-2 mr-2 btn btnn active btn-warning">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="Premiere" class="custom-control-input" name="fl-classe"
                                           value="Première">
                                    <label class="custom-control-label" for="Premiere">1ère</label>
                                </div>
                                <span id="Count1" class="badge badge-pill badge-light"></span>
                            </div>
                            <div class="mb-2 mr-2 btn btnn active btn-danger">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="Terminale" class="custom-control-input" name="fl-classe"
                                           value="Terminale">
                                    <label class="custom-control-label" for="Terminale">Tle</label>
                                </div>
                                <span id="Counttle" class="badge badge-pill badge-light"></span>
                            </div>
                            <div class="mb-2 mr-2 btn btnn active btn-danger">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="BTS1" class="custom-control-input" name="fl-classe"
                                           value="1ère BTS">
                                    <label class="custom-control-label" for="Bts1">1ère BTS</label>
                                </div>
                                <span id="Countbts1" class="badge badge-pill badge-light"></span>
                            </div>
                            <div class="mb-2 mr-2 btn btnn active btn-danger">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="BTS1" class="custom-control-input" name="fl-classe"
                                           value="2ème BTS">
                                    <label class="custom-control-label" for="Bts2">2ème BTS</label>
                                </div>
                                <span id="Countbts2" class="badge badge-pill badge-light"></span>
                            </div>
                            <div class="mb-2 mr-2 btn btnn active btn-danger">
                                <div class="custom-checkbox custom-control custom-control-inline">
                                    <input type="checkbox" id="FAC" class="custom-control-input" name="fl-classe"
                                           value="FAC">
                                    <label class="custom-control-label" for="Fac">FAC</label>
                                </div>
                                <span id="Countfac" class="badge badge-pill badge-light"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Type de documents</h5>
                            <div class="position-relative form-group">
                                <div>
                                    <div class="custom-checkbox custom-control custom-control-inline">
                                        <input type="checkbox" id="exampleCustomInline" class="custom-control-input"
                                               name="fl-type" value="Cours">
                                        <label class="custom-control-label" for="exampleCustomInline">Cours</label>
                                    </div>
                                    <div class="custom-checkbox custom-control custom-control-inline">
                                        <input type="checkbox" id="exampleCustomInline2" class="custom-control-input"
                                               name="fl-type" value="Exercices">
                                        <label class="custom-control-label" for="exampleCustomInline2">Exercices</label>
                                    </div>
                                    <div class="custom-checkbox custom-control custom-control-inline">
                                        <input type="checkbox" id="exampleCustomInline3" class="custom-control-input"
                                               name="fl-type" value="Autres">
                                        <label class="custom-control-label" for="exampleCustomInline3">Autres</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Matières</h5>
                            <div class="position-relative form-group">
                                <div id="filterControls2">
                                    <form>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox"
                                                   class="custom-control-input" name="fl-colour" value="Français">
                                            <label class="custom-control-label"
                                                   for="exampleCustomCheckbox">Français</label>
                                        </div>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox2"
                                                   class="custom-control-input" name="fl-colour" value="Mathématiques">
                                            <label class="custom-control-label" for="exampleCustomCheckbox2">Mathématiques</label>
                                        </div>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox3"
                                                   class="custom-control-input" name="fl-colour"
                                                   value="Histoire - Géographie">
                                            <label class="custom-control-label" for="exampleCustomCheckbox3">Histoire -
                                                Géographie</label>
                                        </div>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox4"
                                                   class="custom-control-input" name="fl-colour"
                                                   value="Physique chimie">
                                            <label class="custom-control-label" for="exampleCustomCheckbox4">Physique
                                                chimie</label>
                                        </div>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox5"
                                                   class="custom-control-input" name="fl-colour" value="Anglais">
                                            <label class="custom-control-label"
                                                   for="exampleCustomCheckbox5">Anglais</label>
                                        </div>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox6"
                                                   class="custom-control-input" name="fl-colour" value="Espagnol">
                                            <label class="custom-control-label"
                                                   for="exampleCustomCheckbox6">Espagnol</label>
                                        </div>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" id="exampleCustomCheckbox7"
                                                   class="custom-control-input" name="fl-colour" value="Allemand">
                                            <label class="custom-control-label"
                                                   for="exampleCustomCheckbox7">Allemand</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="main-card mb-3 card">
                        <ul id="tabela1" class="list-group list-group-flush">
                            <?php foreach ($lesDocs as $unDoc) {
                                $now = time(); // or your date as well
                                $your_date = strtotime($unDoc['dateMiseEnLigne']);
                                $datediff = $now - $your_date;

                                if ($unDoc['valide'] == 1 && empty($numIntervenant)) {
                                    echo '
  <li class="flower list-group-item" data-id="aloe" data-category="' . $unDoc['Matieres'] . ' ' . $unDoc['Type'] . ' ' . $unDoc['Classe'] . '">
              <div class="widget-content p-0">
                  <div class="widget-content-wrapper">
                      <div class="widget-content-left mr-3">
                          <img width="42" class="rounded-circle"
                              src="./images/imagespolycopies/' . $unDoc['urlphoto'] . '" alt="">
                      </div>
                      <div class="widget-content-left">
                          <div class="widget-heading"><a href="./documentseleve/' . $unDoc['urlfichier'] . '">' . $unDoc['nom'] . ' </a>
                          ';
                                    if (round($datediff / (60 * 60 * 24)) < 15) {
                                        echo '<div class="mb-2 mr-2 badge badge-dot badge-dot-lg badge-danger">NOUVEAU</div>';
                                    }

                                    if ($unDoc['urlcorrige'] != NULL) {
                                        echo '
                          <div class="badge badge-danger "><a style="color:white;" href="./documentseleve/' . $unDoc['urlcorrige'] . '">corrigé </a></div>';
                                    }

                                    if ((isset($numIntervenant)) && ($admin >= 0)) {
                                        if ($unDoc['valide'] == 0) {
                                            echo ' <div class="badge badge-focus ">Non validé</div>';
                                        }
                                        if ($unDoc['valide'] == 1) {
                                            echo ' <div class="badge badge-success ">validé</div>';
                                        }
                                    }
                                    echo '</div>
                          <div class="widget-subheading"><span class="classe">' . $unDoc['Classe'] . '</span> - <span class="matiere">' . $unDoc['Matieres'] . '</span> - ' . $unDoc['Type'] . ' - <i>' . $unDoc['Commentaires'] . '</i></div>
                      </div>
                      <div class="widget-content-right">

                          <div class="widget-numbers text-primary">
                            <button class="btn-icon btn-icon-only btn btn-link">
                              <span id="show-count" class="count-up-wrapper"></span> <a id="download-btn" href="./documentseleve/' . $unDoc['urlfichier'] . '" download><i class="pe-7s-download fsize-6 btn-icon-wrapper"></i></a>
                              ';

                                    if ((isset($numIntervenant)) && ($admin >= 0)) {
                                        echo '
                              <span id="show-count" class="count-up-wrapper"></span><a href="index.php?choixTraitement=intervenant&action=supprimerpolycopie&polycopie=' . $unDoc['IDPOLYCOP'] . '"<i class="pe-7s-trash fsize-6 btn-icon-wrapper"></i>
                              <span id="show-count" class="count-up-wrapper"></span><a href="index.php?choixTraitement=intervenant&action=vueModifierPolycopies&polycopie=' . $unDoc['IDPOLYCOP'] . '"<i id="modifierPolycopie" class="pe-7s-pen fsize-6 btn-icon-wrapper"></i></a>
                              ';
                                    }
                                    echo '
                            </button>
                          </div>
                      </div>
                  </div>

              </div>
          </li>';
                                } else if ((isset($numIntervenant)) && ($admin >= 0)) {
                                    echo '
            <li class="flower list-group-item" data-id="aloe" data-category="' . $unDoc['Matieres'] . ' ' . $unDoc['Type'] . ' ' . $unDoc['Classe'] . '">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <img width="42" class="rounded-circle"
                                        src="./images/imagespolycopies/' . $unDoc['urlphoto'] . '" alt="">
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading"><a href="./documentseleve/' . $unDoc['urlfichier'] . '">' . $unDoc['nom'] . ' </a>
                                    ';
                                    if (round($datediff / (60 * 60 * 24)) < 15) {
                                        echo '<div class="mb-2 mr-2 badge badge-dot badge-dot-lg badge-danger">NOUVEAU</div>';
                                    }

                                    if ($unDoc['urlcorrige'] != NULL) {
                                        echo '
                                    <div class="badge badge-danger "><a style="color:white;" href="./documentseleve/' . $unDoc['urlcorrige'] . '">corrigé </a></div>';
                                    }

                                    if ((isset($numIntervenant)) && ($admin >= 0)) {
                                        if ($unDoc['valide'] == 0) {
                                            echo ' <div class="badge badge-focus ">Non validé</div>';
                                        }
                                        if ($unDoc['valide'] == 1) {
                                            echo ' <div class="badge badge-success ">validé</div>';
                                        }
                                    }
                                    echo '</div>
                                    <div class="widget-subheading"><span class="classe">' . $unDoc['Classe'] . '</span> - <span class="matiere">' . $unDoc['Matieres'] . '</span> - ' . $unDoc['Type'] . ' - <i>' . $unDoc['Commentaires'] . '</i></div>
                                </div>
                                <div class="widget-content-right">

                                    <div class="widget-numbers text-primary">
                                      <button class="btn-icon btn-icon-only btn btn-link">
                                        <span id="show-count" class="count-up-wrapper"></span> <a id="download-btn" href="./documentseleve/' . $unDoc['urlfichier'] . '" download><i class="pe-7s-download fsize-6 btn-icon-wrapper"></i></a>
                                        ';

                                    if ((isset($numIntervenant)) && ($admin >= 0)) {
                                        echo '
                                        <span id="show-count" class="count-up-wrapper"></span><a href="index.php?choixTraitement=intervenant&action=supprimerpolycopie&polycopie=' . $unDoc['IDPOLYCOP'] . '"<i class="pe-7s-trash fsize-6 btn-icon-wrapper"></i>
                                        <span id="show-count" class="count-up-wrapper"></span><a href="index.php?choixTraitement=intervenant&action=vueModifierPolycopies&polycopie=' . $unDoc['IDPOLYCOP'] . '"<i id="modifierPolycopie" class="pe-7s-pen fsize-6 btn-icon-wrapper"></i></a>
                                        ';
                                    }
                                    echo '
                                      </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>';
                                }
                            } ?>


                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="ajouterpolycopies">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Ajouter une polycopie</h5>
                    <form class="" action="index.php?choixTraitement=eleve&action=ajoutPolycopies" method="post"
                          enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-3">
                                <label for="Nom">Nom :</label>
                                <input class="form-control" type="text" name="Nom" value="">
                            </div>
                            <div class="col-md-4">
                                <label for="Commentaires">Commentaires :</label>
                                <input class="form-control" type="text" name="Commentaires">
                            </div>
                            <div class="col-md-2">
                                <label for="Fichier">Fichier:</label>
                                <input class="form-control" type="file" name="Fichier" value="" accept=".pdf">
                            </div>
                            <div class="col-md-2">
                                <label for="Corrige">Corrigé:</label>
                                <input class="form-control" type="file" name="Corrige" value="" accept=".pdf">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <label for="Date">Date de mise en ligne :</label>
                                <input class="form-control" type="date" name="Date" value="<?php echo date("Y-m-d") ?>"
                                       readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="Classe">Classe :</label>
                                <select class="form-control" name="Classe">
                                    <?php foreach ($lesClasses as $uneClasse) {
                                        echo '<option value="' . $uneClasse["NOM"] . '">' . $uneClasse["NOM"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="Photo">Photo :</label>
                                <input class="form-control" type="file" name="Photo" value="">
                            </div>
                            <div class="col-md-2">
                                <label for="Type">Type :</label>
                                <select class="form-control" name="Type">
                                    <?php foreach ($lesTypes as $unType) {
                                        echo '<option value="' . $unType["Type"] . '">' . $unType["Type"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="Categorie">Catégorie :</label>
                                <select class="form-control" name="Categorie">
                                    <?php foreach ($lesCategoriesDocs as $uneCategorie) {
                                        echo '<option value="' . $uneCategorie["id"] . '">' . $uneCategorie["Matieres"] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        </br>
                        <button type="submit" name="soumettre" class="mt-1 btn btn-primary ">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    /*jQuery( document ).ready( function() {
        jQuery('#download-btn').click(function() {
            jQuery('#show-count').html(function(i, val) {
                return val*1+1
               });
        });
    });*/

    var num6 = $('.list-group-item[data-category~="6ème"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Count6").text(num6);
    var num5 = $('.list-group-item[data-category~="5ème"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Count5").text(num5);
    var num4 = $('.list-group-item[data-category~="4ème"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Count4").text(num4);
    var num3 = $('.list-group-item[data-category~="3ème"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Count3").text(num3);
    var num2 = $('.list-group-item[data-category~="Seconde"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Count2").text(num2);
    var num1 = $('.list-group-item[data-category~="Première"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Count1").text(num1);
    var numTle = $('.list-group-item[data-category~="Terminale"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Counttle").text(numTle);
    var numBTS1 = $('.list-group-item[data-category~="1ère BTS"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Countbts1").text(numBTS1);
    var numBTS2 = $('.list-group-item[data-category~="2ème BTS"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Countbts2").text(numBTS2);
    var numFAC = $('.list-group-item[data-category~="FAC"]').filter(function () {
        return $(this).css('display') !== 'none';
    }).length;
    $("#Countfac").text(numFAC);


    var $filterCheckboxes = $('input[type="checkbox"]');

    $filterCheckboxes.on('change', function () {

        var selectedFilters = {};

        $filterCheckboxes.filter(':checked').each(function () {

            if (!selectedFilters.hasOwnProperty(this.name)) {
                selectedFilters[this.name] = [];
            }

            selectedFilters[this.name].push(this.value);

        });

        // create a collection containing all of the filterable elements
        var $filteredResults = $('.flower');

        // loop over the selected filter name -> (array) values pairs
        $.each(selectedFilters, function (name, filterValues) {

            // filter each .flower element
            $filteredResults = $filteredResults.filter(function () {

                var matched = false,
                    currentFilterValues = $(this).data('category').split(' ');

                // loop over each category value in the current .flower's data-category
                $.each(currentFilterValues, function (_, currentFilterValue) {

                    // if the current category exists in the selected filters array
                    // set matched to true, and stop looping. as we're ORing in each
                    // set of filters, we only need to match once

                    if ($.inArray(currentFilterValue, filterValues) != -1) {
                        matched = true;
                        return false;
                    }
                });

                // if matched is true the current .flower element is returned
                return matched;

            });
        });

        $('.flower').hide().filter($filteredResults).show();

    });


</script>

<script type="text/javascript">
    $("#modifierpolycopie").click(function () {
        var id = $(this).data('id');
        $.ajax(
            {
                //url: "vues/eleve/v_polycopies_eleve.php",
                url: "vues/v_pied.php",
                // /url: "aaa.php",
                type: "POST",
                data: {id: id},
                success: function (result) {
                }
            });
    });

</script>
