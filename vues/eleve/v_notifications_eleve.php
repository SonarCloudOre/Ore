<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Notifications
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

<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                    <li class="nav-item">
                        <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab"
                           href="#consulternotifications">
                            <span>Consulter</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#ajouternotification">
                            <span>Ajouter</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="consulternotifications">
        <div class="row">
            <div class="col-md-6">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-cloud-download icon-gradient bg-happy-itmeo"></i>
                                Dernières informations importantes
                            </div>
                        </div>
                        <div class="p-0 card-body">
                            <div class="dropdown-menu-header mt-0 mb-0">
                                <div class="dropdown-menu-header-inner bg-heavy-rain">
                                    <div class="menu-header-image opacity-1"
                                         style="background-image: url('images/dropdown-header/city3.jpg');"></div>
                                    <div class="menu-header-content text-dark">
                                        <h5 class="menu-header-title">Notifications</h5>
                                        <h6 class="menu-header-subtitle">
                                            Il y a
                                            <b class="text-danger">12</b>
                                            nouvelles vous concernant !
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-animated-0" role="tabpanel">
                                    <div class="scroll-area-sm">
                                        <div class="scrollbar-container">
                                            <div class="p-3">
                                                <div class="notifications-box">
                                                    <div
                                                        class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                        <?php foreach ($lesnotifs as $uneNotif) {
                                                            echo '
                                    <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                    <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                    <h4 class="timeline-title">
                                    ' . $uneNotif['libelle'] . '
                                    <br>
                                    <span class="text-success">Le ' . dateAnglaisVersFrancais($uneNotif['date_evenement']) . '</span>
                                    <span class="mb-2 mr-2 badge badge-pill badge-danger">Nouveau</span>
                                    <a href="index.php?choixTraitement=eleve&action=modifierNotification&notif=' . $uneNotif['id'] . '"><span class="pe-7s-pen btn btn-primary"></span></a>
                                    <a href="index.php?choixTraitement=eleve&action=supprimerNotification&notif=' . $uneNotif['id'] . '"><span class="pe-7s-trash btn btn-danger"></span></a>
                                    </h4>
                                    <span class="vertical-timeline-element-date"></span>
                                    </div>
                                    </div>
                                    </div>

                                    ';
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav flex-column">
                                <li class="nav-item-btn text-center pt-4 pb-3 nav-item">

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="ajouternotification">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form class="" action="index.php?choixTraitement=eleve&action=ajouterNotification"
                              method="post">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="Libelle">Libellé</label>
                                    <input class="form-control" type="text" name="Libelle" value="">
                                </div>
                                <div class="col-md-2">
                                    <label for="Date_publie">Date de mise en ligne</label>
                                    <input class="form-control" type="date" name="Date_publie"
                                           value="<?php echo date("Y-m-d") ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="Libelle">Date de l'évènement</label>
                                    <input class="form-control" type="date" name="Date_evenement" value="">
                                </div>
                                <div class="col-md-2">
                                    <label for="Cible">Cible</label>
                                    <select multiple="multiple" class="multiselect-dropdown form-control"
                                            name="Cible[]">
                                        <?php foreach ($lesUtilisateurs as $unUtilisateur) {
                                            echo '<option value="' . $unUtilisateur['NOM'] . '">' . $unUtilisateur['NOM'] . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="Auteur">Auteur</label>
                                    <?php
                                    echo '<input type="hidden" name="Auteur" value="' . $intervenant . '">';
                                    echo '<input class="form-control" type="text" name="" value="' . $intervenantPrenom . ' ' . $intervenantNom . '" readonly >';
                                    ?>
                                    <br>
                                </div>
                            </div>
                            <input class="mt-1 btn btn-primary" type="submit" name="ajouter" value="Ajouter">
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="./js/form-components/input-select.js"></script>
