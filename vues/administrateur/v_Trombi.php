<div id="contenu">
    <div id="divid">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                    </div>
                    <div>
                        Trombinoscope
                        <div class="page-title-subheading">Photos des élèves par classes</div>


                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown" style="text-align:center;">
                        <div class="row">
                            <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                                <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                            </button>
                            <button type="button" class="btn btn-primary" value=""
                                    onClick="imprimer2('sectionAimprimer2');">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        foreach ($lesClasses as $laClasse) {

            echo '
                    <div class="main-card mb-3 card">
                                            <div class="card-body">
                                            <center>
                                                <h3 class="card-title">' . $laClasse["NOM"] . '</h3>
                                            </center>
                                                ';
            foreach ($lesEleves as $unEleve) {

                if ($laClasse['ID'] == $unEleve['ID_CLASSE']) {


                    if ($unEleve['PHOTO'] == "") {
                        $photo = "AUCUNE.jpg";
                    } else {
                        $photo = $unEleve['PHOTO'];
                    }
                    echo
                        '
    <a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $unEleve["ID_ELEVE"] . '" class="avatar-icon-wrapper btn-hover-shine avatar-icon-xl" style="text-decoration: none;">
        <div class="avatar-icon rounded">
            <img src="photosEleves/' . $photo . '">
        </div>
        <center>
        <p>' . $unEleve["PRENOM"] . ' ' . $unEleve["NOM"] . '</p>
        </center>
    </a>

';

                }
            }

            echo '

                                            </div>
                                        </div>';

        } ?>
    </div>
</div>
