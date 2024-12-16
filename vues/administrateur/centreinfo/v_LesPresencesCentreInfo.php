<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Présences des utilisateurs
                    <div class="page-title-subheading">
                        Présence des utilisateurs le <?= date('d/m/Y', strtotime($dateCircuit)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=LesPresencesCentreInfo">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Présences des utilisateurs</h4>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="plusieursJoursMois">
                                        <div class="form-row">
                                            <div class="col-md">
                                                <label for="jourSemaine">Tous les...</label><br>
                                                <select name="jourSemaine" id="jourSemaine" class="form-control">
                                                    <option value="1">Lundi</option>
                                                    <option value="2">Mardi</option>
                                                    <option value="3">Mercredi</option>
                                                    <option value="4">Jeudi</option>
                                                    <option value="5">Vendredi</option>
                                                    <option value="6">Samedi</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label for="mois">De...</label><br>
                                                <select name="mois" class="form-control">
                                                    <?php
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        $moisLabel = strftime('%B', mktime(0, 0, 0, $i, 1));
                                                        echo "<option value=\"$i\">$moisLabel</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                    </label><br>
                                </div>
                            </div>
                            <input name="Soumettre" value="Soumettre" type="submit" class="form-control btn btn-success mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php if (!empty($tableauUtilisateur)): ?>
        <?php foreach ($tableauUtilisateur as $date => $presences): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Présences pour le <?= date('d/m/Y', strtotime($date)) ?></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($presences as $presence): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($presence['NOM']) ?></td>
                                        <td><?= htmlspecialchars($presence['PRENOM']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">Aucune présence trouvée pour les critères sélectionnés.</div>
    <?php endif; ?>
</div>
