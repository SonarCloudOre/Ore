<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>Présence des utilisateurs du centre info</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <a href="index.php?choixTraitement=administrateur&action=appelCentreInfo">
                        <button type="button" class="btn btn-primary" value="">
                            <i class="fa fa-print"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire pour la présence des utilisateurs du centre info -->
    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=valideAppelUtilisateursCentreInfo">
    <fieldset>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Présence des utilisateurs du centre info</h4>

                        <!-- Sélection de la date -->
                        <label for="date">Date :</label>
                        <input type="date" class="form-control" name="date" id="date">

                        <table class="mb-0 table">
                            <thead>
                                <tr>
                                    <th style="text-align:center">Présent ?</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Ville de l'utilisateur</th>
                                    <th>Nombre d'heures</th>
                                    <th>Heure d'arrivée</th>
                                    <th>Activité</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lesUtilisateursCentreInfo as $unUtilisateur): ?>
                                    <tr>
                                        <td style="text-align:center">
                                            <input id='<?= $unUtilisateur['ID_UTILISATEUR'] ?>' name="appel[]" value='<?= $unUtilisateur['ID_UTILISATEUR'] ?>' type='checkbox'>
                                        </td>
                                        <td><?= $unUtilisateur['NOM'] ?></td>
                                        <td><?= $unUtilisateur['PRENOM'] ?></td>
                                        <td><?= $unUtilisateur['VILLE'] ?></td>
                                        <td>
                                            <input type="number" name="heure<?= $unUtilisateur['ID_UTILISATEUR'] ?>" id="heure<?= $unUtilisateur['ID_UTILISATEUR'] ?>" class="form-control" style="width:70px">
                                        </td>
                                        <td><input type="time" name="heure_arrivee<?= $unUtilisateur['ID_UTILISATEUR'] ?>" id="heure_arrivee<?= $unUtilisateur['ID_UTILISATEUR'] ?>" class="form-control" style="width:100px"></td>
                                        <td>
                                            <select name="activite<?= $unUtilisateur['ID_UTILISATEUR'] ?>" id="activite<?= $unUtilisateur['ID_UTILISATEUR'] ?>" class="form-control">
                                                <option value="fablab">Fablab</option>
                                                <option value="casque_vr">Casque VR</option>
                                                <option value="jeux">Jeux</option>
                                                <option value="cours_info">Cours Info</option>
                                                <option value="centre_info">Centre Info</option>
                                                <option value="club_robotique">Club Robotique</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <br/>
                        <input value="Soumettre" type="submit" class="btn btn-success">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>
</div>

<script type="text/javascript" src="./vendors/moment/moment.js"></script>
<script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/dist/datepicker.min.js"></script>
<script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/i18n/datepicker.fr-FR.js"></script>

