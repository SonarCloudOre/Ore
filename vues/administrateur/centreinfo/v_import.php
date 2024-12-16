<div id="contenu">
    <div class="col-md-6">
        <h2>Importation</h2>
        <div class="form-group">
            <form method="POST" enctype="multipart/form-data"
                  action="index.php?choixTraitement=administrateur&action=info_import_validation">
                <label for="fichier">Fichier CSV</label>
                <input class="form-control" type="file" name="fichier" required="required"><br>
                <label for="fichier">Type de données</label><br>
                <input type="radio" name="type" value="inscrits" checked="checked"> Inscriptions<br>
                <input type="radio" name="type" value="visites"> Visites<br><br>
                <input value="Importer" type="submit" class="btn btn-success">
            </form>
        </div>
        <div class="alert alert-info">
            <h4>Exporter depuis Cyberlux</h4>
            <ul>
                <li>Cliquer sur <img src="images/cyberlux/Capture.PNG" style="height:30px">pour les inscriptions, ou
                    <img src="images/cyberlux/Capture4.PNG" style="height:30px"> pour les visites
                </li>
                <li>Cliquer sur <img src="images/cyberlux/Capture2.PNG" style="height:30px"> (à droite)</li>
                <li>Régler les paramètres comme ci-dessous :<br><img src="images/cyberlux/Capture3.PNG"
                                                                     style="width:400px"></li>
                <li>Cliquer sur Exporter</li>
            </ul>
            <br>
        </div>
    </div>
    <div class="col-md-6">
        <h2>Exportation</h2>
        <form method="POST" enctype="multipart/form-data"
              action="index.php?choixTraitement=administrateur&action=info_export">
            <input type="hidden" name="anneeEnCours" value="<?php echo $anneeEnCours; ?>">
            <div class="form-group">
                <label for="export">Données à exporter :</label>
                <select name="export" class="form-control">
                    <option disabled="disabled" selected="selected">Choisir...</option>
                    <option value="inscriptions">Inscriptions</option>
                    <option value="activites">Activités</option>
                    <option value="visites">Visites</option>
                    <option value="documents">Documents</option>
                    <option value="reglements">Réglements</option>
                </select><br><br>
                <input value="Exporter" type="submit" class="btn btn-success">
            </div>
        </form>
    </div>
</div>