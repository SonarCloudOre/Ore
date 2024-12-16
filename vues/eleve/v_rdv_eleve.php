<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Rendez vous - <?php echo $intervenant["NOM"] . " " . $intervenant["PRENOM"] ?></div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">


                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
                <button type="button" class="btn btn-primary" value="" onClick="imprimer('sectionAimprimer');">
                    <i class="fa fa-print"></i>
                </button>

                <a href="index.php?choixTraitement=eleve&action=contact">
                    <button type="button" class="btn btn-primary" value="">
                                    <span class="btn-icon-wrapper">
                                      <i class="fa fa-calendar fa-w-20"></i>
                                      RDV
                                    </span>
                    </button>
                </a>

            </div>
        </div>
    </div>
</div>
<div id="contenu">
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">RDV parents</h5>
            <div id="order_table">
                <table class="mb-0 table table-hover" id="table1">
                    <thead>
                    <tr>
                        <th>Date et heure</th>
                        <th>Intervenant</th>
                        <th>Commentaire</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <?php

                        $i = 0;
                        // On parcours les rdv
                        foreach ($lesRendezvous as $unRdv) {
                            if ($unRdv['ID_ELEVE'] == $intervenant['ID_ELEVE']) {
                                $unIntervenant = $pdo->recupUnIntervenant($unRdv['ID_INTERVENANT']);

                                $i++;
                                echo '<tr>
                          <th scope="row">' . date("d/m/Y H:i", strtotime($unRdv['DATE_RDV'])) . '</th>
                          <td>' . $unIntervenant['PRENOM'] . ' ' . $unIntervenant['NOM'] . '</td>
                          <td>' . $unRdv['COMMENTAIRE'] . '</td>
                          </tr>
                          ';
                            }
                        }

                        ?>


                    </tr>
                    </tbody>
                </table><?php if ($i == 0) {
                    echo '<br><center><p><i>Aucun rendez-vous pris.</i></p></center>';
                } ?>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">RDV BSB</h5>
            <div id="order_table">
                <table class="mb-0 table table-hover" id="table1">
                    <thead>
                    <tr>
                        <th>Date et heure</th>
                        <th>Durée</th>
                        <th>Intervenant</th>
                        <th>Matière</th>
                        <th>Commentaire</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <?php

                        $i = 0;
                        // On parcours les rdv
                        $totalHeuresRdv = 0;
                        foreach ($lesRendezvousBsb as $unRdv) {
                            if ($unRdv['ID_ELEVE'] == $intervenant['ID_ELEVE']) {

                                // On récupère les infos
                                $totalHeuresRdv = ($totalHeuresRdv + $unRdv['DUREE']);
                                $unIntervenant = $pdo->recupUnIntervenant($unRdv['ID_INTERVENANT']);
                                $laMatiere = '';
                                foreach ($lesMatieres as $uneMatiere) {
                                    if ($uneMatiere['ID'] == $unRdv['ID_MATIERE']) {
                                        $laMatiere = $uneMatiere['NOM'];
                                    }
                                }
                                $i++;
                                echo '<tr>
                          <th scope="row">' . date("d/m/Y H:i", strtotime($unRdv['DATE_RDV'])) . '</td>
                          <td>' . $unRdv['DUREE'] . 'h</td>
                          <td>' . $unIntervenant['PRENOM'] . ' ' . $unIntervenant['NOM'] . '</td>
                          <td>' . $laMatiere . '</td>
                          <td>' . stripslashes($unRdv['COMMENTAIRE']) . '</td>
                          </tr>
                          <tr>
                            <th>Total des heures :</th>
                            <th>' . $totalHeuresRdv . 'h</th>
                            <th colspan="4"></th>
                          </tr>
                          ';
                            }
                        }
                        ?>


                    </tr>
                    </tbody>
                </table><?php if ($i == 0) {
                    echo '<br><center><p><i>Aucun rendez-vous pris.</i></p></center>';
                } ?>
            </div>
        </div>
    </div>
</div>
