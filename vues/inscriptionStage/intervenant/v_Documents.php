<div id="contenu">
    <h2>Mes documents</h3>
        <p>Retrouvez tous vos documents en lien avec l'association : déclarations, fiches de paie, justificatif,
            etc...</p>
        <table class="table">
            <thead>
            <tr>
                <th>Nom</th>
                <!--<th>Date d'ajout</th>
                <th>Taille</th>-->
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $dir_nom = './documentsIntervenants/' . $numIntervenant . '/'; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
            if (file_exists($dir_nom)) {
                $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
                $fichier = array(); // on déclare le tableau contenant le nom des fichiers
                $dossier = array(); // on déclare le tableau contenant le nom des dossiers

                while ($element = readdir($dir)) {
                    if ($element != '.' && $element != '..') {
                        if (!is_dir($dir_nom . '/' . $element)) {
                            $fichier[] = $element;
                        } else {
                            $dossier[] = $element;
                        }
                    }
                }

                closedir($dir);

                $i = 0;

                if ($IntervenantSelectionner['FICHIER_RIB'] != '') {
                    echo '<tr>
		<td><b>' . $IntervenantSelectionner['FICHIER_RIB'] . '</b></td>
		<td><a class="btn btn-primary" href="ribIntervenants/' . $IntervenantSelectionner['FICHIER_RIB'] . '"><span class="glyphicon glyphicon-save"></span> Télécharger</a></td>
		</tr>';
                    $i++;
                }

                if ($IntervenantSelectionner['FICHIER_DIPLOME'] != '') {
                    echo '<tr>
		<td><b>' . $IntervenantSelectionner['FICHIER_DIPLOME'] . '</b></td>
		<td><a class="btn btn-primary" href="diplomesIntervenants/' . $IntervenantSelectionner['FICHIER_DIPLOME'] . '"><span class="glyphicon glyphicon-save"></span> Télécharger</a></td>
		</tr>';
                    $i++;
                }

                if ($IntervenantSelectionner['FICHIER_CV'] != '') {
                    echo '<tr>
		<td><b>' . $IntervenantSelectionner['FICHIER_CV'] . '</b></td>
		<td><a class="btn btn-primary" href="cvIntervenants/' . $IntervenantSelectionner['FICHIER_CV'] . '"><span class="glyphicon glyphicon-save"></span> Télécharger</a></td>
		</tr>';
                    $i++;
                }


                foreach ($fichier as $lien) {
                    $i++; ?>
                    <tr>
                        <td><b><?php echo $lien ?></b></td>
                        <!--<td><?php echo date('d/m/Y H:i', filemtime($dir_nom . '/' . $lien)); ?></td>
	<td><?php echo ceil(filesize($dir_nom . '/' . $lien) / 1000000); ?> Mo</td>-->
                        <td><a class="btn btn-primary" href="<?php echo $dir_nom . $lien; ?>"><span
                                    class="glyphicon glyphicon-save"></span> Télécharger</a></td>
                    </tr>
                <?php }
                if ($i == 0) {
                    echo '<tr><td colspan="3"><i>Aucun document ajouté pour le moment.</i></td></tr>';
                }
            } else {
                echo '<tr><td colspan="3"><i>Aucun document ajouté pour le moment.</i></td></tr>';
            }
            ?>
            </tbody>
        </table>
</div>