<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Logs de connexion
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

    <form method="POST" action="index.php?choixTraitement=administrateur&action=lesLogs">
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <center>
                            <h2 class="card-title">Sélectionnner élève ou intervenant</h2>
                            <br/>
                            <select name="estintervenant" onchange="this.form.submit();"
                                    class="multiselect-dropdown form-control" data-live-search="true"
                                    style="max-width:200px">
                                <option disabled="disabled" selected>Choisir</option>
                                <?php
                                foreach ($utilisateurs as $unUtilisateur) {

                                    echo '<option ';
                                    if (isset($Selectionner) && $unUtilisateur["id"] == $Selectionner) {
                                        echo "selected";
                                    }
                                    echo ' value="' . $unUtilisateur["id"] . '">' . $unUtilisateur["text"] . '</option>';
                                }
                                ?>
                            </select>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php

    if (isset($Selectionner)) { ?>


        <div id="tableau" class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Logs de connexion</h4>
                        <div class="main-card mb-3 card loading-log">
                        </div>
                        <table style="font-size:12px; display: none;" id="example"
                               class="table table-hover table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Intervant</th>
                                <th>Connexion réussie</th>
                                <th>IP</th>
                                <th>Localisation</th>
                                <th>Email</th>
                                <th>Mot de passe crypté</th>
                                <th>Ordinateur</th>
                                <th>Origine</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $reussite = array('Non', 'Oui');
                            $couleur = array('red', 'green');
                            foreach ($lesLogs as $leLog) {
                                if ($leLog["estintervenant"] == 1) {
                                    $estintervenant = "OUI";
                                }
                                if ($leLog["estintervenant"] == 0) {
                                    $estintervenant = "NON";
                                }
                                if ($leLog["estintervenant"] == null) {
                                    $estintervenant = "?";
                                }
                                echo '<tr>
                  ';
                                //<td>'.date('d/m/Y H:i',strtotime($leLog['date'])).'</td>
                                echo '
                  <td>' . $leLog['date'] . '</td>
                  <td>' . $estintervenant . '</td>
                  <td><span style="color:' . $couleur[$leLog['connexion']] . '">' . $reussite[$leLog['connexion']] . '</span></td>
                  <td>' . $leLog['ip'] . '</td>
                  <td>' . stripslashes($leLog['ip_localisation']) . '</td>
                  <td>' . stripslashes($leLog['email']) . '</td>
                  <td>' . $leLog['mdp'] . '</td>
                  <td>' . stripslashes($leLog['user_agent']) . '</td>
                  <td>' . stripslashes($leLog['forward']) . '</td>
                  </tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>


<script type="text/javascript" src="./vendors/bootstrap-table/dist/bootstrap-table.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="./vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="./vendors/block-ui/jquery.blockUI.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
<script type="text/javascript" src="./js/tables.js"></script>

<script type="text/javascript" src="./js/blockui.js"></script>
