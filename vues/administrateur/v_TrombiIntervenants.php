<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&display=swap" rel="stylesheet">
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Trombinoscope
                <div class="page-title-subheading">Photos des intervenants</div>


            </div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
                <a href="index.php?choixTraitement=administrateur&action=TrombiIntervenantsDiapo" target="_blank">
                    <button type="button" class="mr-2 btn btn-primary">
                        <i class="fa fa-film" aria-hidden="true"></i>
                    </button>
                </a>
                <button type="button" class="btn btn-primary" value="" onClick="imprimer2('sectionAimprimer2');">
                    <i class="fa fa-print"></i>
                </button>
            </div>
        </div>
    </div>
</div>



<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="ben-tab" data-toggle="tab" href="#ben" role="tab" aria-controls="ben" aria-selected="true">Bénévole</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="sal-tab" data-toggle="tab" href="#sal" role="tab" aria-controls="sal" aria-selected="false">Salarié</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="sc-tab" data-toggle="tab" href="#sc" role="tab" aria-controls="sc" aria-selected="false">Service Civique</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="BSB-tab" data-toggle="tab" href="#BSB" role="tab" aria-controls="BSB" aria-selected="false">BSB</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="Stagiaire-tab" data-toggle="tab" href="#Stagiaire" role="tab" aria-controls="Stagiaire" aria-selected="false">Stagiaire</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="benH-tab" data-toggle="tab" href="#benH" role="tab" aria-controls="benH" aria-selected="false">Bénévole nbH</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="ben" role="tabpanel" aria-labelledby="ben-tab">
    
<div class="row">
    <div class="main-card card col-md-12">
        <div class="car-body">
            <center>
                <br>
                <h2 class="card-title">Les Bénévoles</h2>
            </center>
            <div class="row">
                <?php
                $ct = count($lesIntervenants) / 2;
                $lesIntervenants1 = array_chunk($lesIntervenants, $ct / 3);

                for ($i = 0; $i < $ct / 3; $i++) {

                    foreach ($lesIntervenants1[$i] as $unIntervenant) {

                        if ($unIntervenant['NOM'] != 'admin' && $unIntervenant['STATUT'] == "Bénévole") {

                            if ($unIntervenant['PHOTO'] == "") {
                                $photo = "AUCUNE.jpg";
                            } else {
                                $photo = $unIntervenant['PHOTO'];
                            }
                            echo '
                            <div class="col-md-2 card-body">
                                <div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-warning">
                                            <div class="menu-header-content">
                                                <div>
                                                    <a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant["ID_INTERVENANT"] . '" class="avatar-icon-wrapper btn-hover-shine avatar-icon-xl">
                                                        <div class="avatar-icon rounded">
                                                            <img src="photosIntervenants/' . $photo . '" alt="Avatar 5">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">' . $unIntervenant["PRENOM"] . ' ' . $unIntervenant["NOM"] . '</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">';
                            $num = $unIntervenant["ID_INTERVENANT"];
                            $lesMatieres = $pdo->getParametre(6);
                            $lesMatieresIntervenant = $pdo->getSpecialisationIntervenant($num);

                            echo '<ul style="text-align : left; margin: 0px; padding : 10px;">';

                            foreach ($lesMatieres as $uneLigne) {

                                $checked = " ";

                                foreach ($lesMatieresIntervenant as $uneLigne2) {

                                    if ($uneLigne['ID'] == $uneLigne2['ID']) {
                                        echo '<li>' . $uneLigne["NOM"] . '</li>';
                                    }
                                }
                            }
                            echo '</ul>
                                    </div>
                                </div></div>';


                        }
                    }
                }
                ?>
               </div>
            </div>
            </div>
         </div>
  </div>


  <div class="tab-pane fade" id="sal" role="tabpanel" aria-labelledby="sal-tab">

  
<div class="row">
    <div class="main-card card col-md-12">
        <div class="car-body">
            <center>
                <br>
                <h2 class="card-title">Les Salariés</h2>
            </center>
            <div class="row">
                <?php
                $ct = count($lesIntervenants) / 2;
                $lesIntervenants1 = array_chunk($lesIntervenants, $ct / 3);

                for ($i = 0; $i < $ct / 3; $i++) {

                    foreach ($lesIntervenants1[$i] as $unIntervenant) {

                        if ($unIntervenant['NOM'] != 'admin' && $unIntervenant['STATUT'] == "Salarié") {

                            if ($unIntervenant['PHOTO'] == "") {
                                $photo = "AUCUNE.jpg";
                            } else {
                                $photo = $unIntervenant['PHOTO'];
                            }
                            echo '
        <div class="col-md-2 card-body">
<div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-warning">
                                            <div class="menu-header-content">
                                                <div>
                                                    <a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant["ID_INTERVENANT"] . '" class="avatar-icon-wrapper btn-hover-shine avatar-icon-xl">
                                                        <div class="avatar-icon rounded">
                                                            <img src="photosIntervenants/' . $photo . '" alt="Avatar 5">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">' . $unIntervenant["PRENOM"] . ' ' . $unIntervenant["NOM"] . '</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">';
                            $num = $unIntervenant["ID_INTERVENANT"];
                            $lesMatieres = $pdo->getParametre(6);
                            $lesMatieresIntervenant = $pdo->getSpecialisationIntervenant($num);

                            echo '<ul style="text-align : left; margin: 0px; padding : 10px;">';

                            foreach ($lesMatieres as $uneLigne) {

                                $checked = " ";

                                foreach ($lesMatieresIntervenant as $uneLigne2) {

                                    if ($uneLigne['ID'] == $uneLigne2['ID']) {
                                        echo '<li>' . $uneLigne["NOM"] . '</li>';
                                    }
                                }
                            }
                            echo '</ul>
                                    </div>
                                </div></div>';


                        }
                    }
                }
                ?>
               </div>
            </div>
            </div>
         </div>

  </div>

  <div class="tab-pane fade" id="sc" role="tabpanel" aria-labelledby="sc-tab">
    
<div class="row">
    <div class="main-card card col-md-12">
        <div class="car-body">
            <center>
                <br>
                <h2 class="card-title">Les Services Civiques</h2>
            </center>
            <div class="row">
                <?php
                $ct = count($lesIntervenants) / 2;
                $lesIntervenants1 = array_chunk($lesIntervenants, $ct / 3);

                for ($i = 0; $i < $ct / 3; $i++) {

                    foreach ($lesIntervenants1[$i] as $unIntervenant) {

                        if ($unIntervenant['NOM'] != 'admin' && $unIntervenant['STATUT'] == "Service Civique") {

                            if ($unIntervenant['PHOTO'] == "") {
                                $photo = "AUCUNE.jpg";
                            } else {
                                $photo = $unIntervenant['PHOTO'];
                            }
                            echo '
        <div class="col-md-2 card-body">
<div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-warning">
                                            <div class="menu-header-content">
                                                <div>
                                                    <a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant["ID_INTERVENANT"] . '" class="avatar-icon-wrapper btn-hover-shine avatar-icon-xl">
                                                        <div class="avatar-icon rounded">
                                                            <img src="photosIntervenants/' . $photo . '" alt="Avatar 5">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">' . $unIntervenant["PRENOM"] . ' ' . $unIntervenant["NOM"] . '</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">';
                            $num = $unIntervenant["ID_INTERVENANT"];
                            $lesMatieres = $pdo->getParametre(6);
                            $lesMatieresIntervenant = $pdo->getSpecialisationIntervenant($num);

                            echo '<ul style="text-align : left; margin: 0px; padding : 10px;">';

                            foreach ($lesMatieres as $uneLigne) {

                                $checked = " ";

                                foreach ($lesMatieresIntervenant as $uneLigne2) {

                                    if ($uneLigne['ID'] == $uneLigne2['ID']) {
                                        echo '<li>' . $uneLigne["NOM"] . '</li>';
                                    }
                                }
                            }
                            echo '</ul>
                                    </div>
                                </div></div>';


                        }
                    }
                }
                ?>
               </div>
            </div>
            </div>
         </div>
  </div>
  <div class="tab-pane fade" id="BSB" role="tabpanel" aria-labelledby="BSB-tab">
    
<div class="row">
    <div class="main-card card col-md-12">
        <div class="car-body">
            <center>
                <br>
                <h2 class="card-title">Les BSB</h2>
            </center>
            <div class="row">
                <?php
                $ct = count($lesIntervenants) / 2;
                $lesIntervenants1 = array_chunk($lesIntervenants, $ct / 3);

                for ($i = 0; $i < $ct / 3; $i++) {

                    foreach ($lesIntervenants1[$i] as $unIntervenant) {

                        if ($unIntervenant['NOM'] != 'admin' && $unIntervenant['STATUT'] == "BSB") {

                            if ($unIntervenant['PHOTO'] == "") {
                                $photo = "AUCUNE.jpg";
                            } else {
                                $photo = $unIntervenant['PHOTO'];
                            }
                            echo '
        <div class="col-md-2 card-body">
<div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-warning">
                                            <div class="menu-header-content">
                                                <div>
                                                    <a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant["ID_INTERVENANT"] . '" class="avatar-icon-wrapper btn-hover-shine avatar-icon-xl">
                                                        <div class="avatar-icon rounded">
                                                            <img src="photosIntervenants/' . $photo . '" alt="Avatar 5">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">' . $unIntervenant["PRENOM"] . ' ' . $unIntervenant["NOM"] . '</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">';
                            $num = $unIntervenant["ID_INTERVENANT"];
                            $lesMatieres = $pdo->getParametre(6);
                            $lesMatieresIntervenant = $pdo->getSpecialisationIntervenant($num);

                            echo '<ul style="text-align : left; margin: 0px; padding : 10px;">';

                            foreach ($lesMatieres as $uneLigne) {

                                $checked = " ";

                                foreach ($lesMatieresIntervenant as $uneLigne2) {

                                    if ($uneLigne['ID'] == $uneLigne2['ID']) {
                                        echo '<li>' . $uneLigne["NOM"] . '</li>';
                                    }
                                }
                            }
                            echo '</ul>
                                    </div>
                                </div></div>';


                        }
                    }
                }
                ?>
              </div>
            </div>
            </div>
         </div>
  </div>
  <div class="tab-pane fade" id="Stagiaire" role="tabpanel" aria-labelledby="Stagiaire-tab">
    
<div class="row">
    <div class="main-card card col-md-12">
        <div class="car-body">
            <center>
                <br>
                <h2 class="card-title">Les Stagiaires</h2>
            </center>
            <div class="row">
                <?php
                $ct = count($lesIntervenants) / 2;
                $lesIntervenants1 = array_chunk($lesIntervenants, $ct / 3);

                for ($i = 0; $i < $ct / 3; $i++) {

                    foreach ($lesIntervenants1[$i] as $unIntervenant) {

                        if ($unIntervenant['NOM'] != 'admin' && $unIntervenant['STATUT'] == "Stagiaire") {

                            if ($unIntervenant['PHOTO'] == "") {
                                $photo = "AUCUNE.jpg";
                            } else {
                                $photo = $unIntervenant['PHOTO'];
                            }
                            echo '
        <div class="col-md-2 card-body">
<div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-warning">
                                            <div class="menu-header-content">
                                                <div>
                                                    <a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant["ID_INTERVENANT"] . '" class="avatar-icon-wrapper btn-hover-shine avatar-icon-xl">
                                                        <div class="avatar-icon rounded">
                                                            <img src="photosIntervenants/' . $photo . '" alt="Avatar 5">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">' . $unIntervenant["PRENOM"] . ' ' . $unIntervenant["NOM"] . '</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">';
                            $num = $unIntervenant["ID_INTERVENANT"];
                            $lesMatieres = $pdo->getParametre(6);
                            $lesMatieresIntervenant = $pdo->getSpecialisationIntervenant($num);

                            echo '<ul style="text-align : left; margin: 0px; padding : 10px;">';

                            foreach ($lesMatieres as $uneLigne) {

                                $checked = " ";

                                foreach ($lesMatieresIntervenant as $uneLigne2) {

                                    if ($uneLigne['ID'] == $uneLigne2['ID']) {
                                        echo '<li>' . $uneLigne["NOM"] . '</li>';
                                    }
                                }
                            }
                            echo '</ul>
                                    </div>
                                </div></div>';


                        }
                    }
                }
                ?>
               </div>
            </div>
            </div>
         </div>
  </div>
  <div class="tab-pane fade" id="benH" role="tabpanel" aria-labelledby="benH-tab">

  
<div class="row">
    <div class="main-card card col-md-12">
        <div class="car-body">
            <center>
                <br>
                <h2 class="card-title">Les Bénévoles nbH</h2>
            </center>
            <div class="row">
                <?php
                $ct = count($lesIntervenants) / 2;
                $lesIntervenants1 = array_chunk($lesIntervenants, $ct / 3);

                for ($i = 0; $i < $ct / 3; $i++) {

                    foreach ($lesIntervenants1[$i] as $unIntervenant) {

                        if ($unIntervenant['NOM'] != 'admin' && $unIntervenant['STATUT'] == "Bénévole nbH") {

                            if ($unIntervenant['PHOTO'] == "") {
                                $photo = "AUCUNE.jpg";
                            } else {
                                $photo = $unIntervenant['PHOTO'];
                            }
                            echo '
        <div class="col-md-2 card-body">
<div class="card-hover-shadow card-border mb-3 card">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-warning">
                                            <div class="menu-header-content">
                                                <div>
                                                    <a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant["ID_INTERVENANT"] . '" class="avatar-icon-wrapper btn-hover-shine avatar-icon-xl">
                                                        <div class="avatar-icon rounded">
                                                            <img src="photosIntervenants/' . $photo . '" alt="Avatar 5">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div>
                                                    <h5 class="menu-header-title">' . $unIntervenant["PRENOM"] . ' ' . $unIntervenant["NOM"] . '</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">';
                            $num = $unIntervenant["ID_INTERVENANT"];
                            $lesMatieres = $pdo->getParametre(6);
                            $lesMatieresIntervenant = $pdo->getSpecialisationIntervenant($num);

                            echo '<ul style="text-align : left; margin: 0px; padding : 10px;">';

                            foreach ($lesMatieres as $uneLigne) {

                                $checked = " ";

                                foreach ($lesMatieresIntervenant as $uneLigne2) {

                                    if ($uneLigne['ID'] == $uneLigne2['ID']) {
                                        echo '<li>' . $uneLigne["NOM"] . '</li>';
                                    }
                                }
                            }
                            echo '</ul>
                                    </div>
                                </div></div>';


                        }
                    }
                }
                ?>
                </div>
            </div>
            </div>
         </div>
  </div>
</div>




