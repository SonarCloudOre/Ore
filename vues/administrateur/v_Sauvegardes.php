<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Sauvegardes
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
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h2>Sauvegardes</h2>
                    <p><br>
                        <a href='index.php?choixTraitement=administrateur&action=FaireSauvegarde'
                           class='btn btn-info'><span class="glyphicon glyphicon-floppy-disk"></span> Effectuer une
                            sauvegarde</a>
                    </p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Sauvegardé le</th>
                            <th>Taille</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $dir_nom = './sauvegardes/'; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
                        $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
                        $fichier = array(); // on déclare le tableau contenant le nom des fichiers
                        $dossier = array(); // on déclare le tableau contenant le nom des dossiers

                        while ($element = readdir($dir)) {
                            if ($element != '.' && $element != '..') {
                                if (!is_dir($dir_nom . $element)) {
                                    $fichier[] = $element;
                                } else {
                                    $dossier[] = $element;
                                }
                            }
                        }

                        closedir($dir);

                        $i = 0;
                        foreach ($fichier as $lien) {
                            $i++; ?>
                            <tr>
                                <td><a href="<?php echo $dir_nom . $lien; ?>"><?php echo $lien ?></a></td>
                                <td><?php echo date('d/m/Y H:i', filemtime($dir_nom . $lien)); ?></td>
                                <td><?php echo ceil(filesize($dir_nom . $lien) / 1000000); ?> Mo</td>
                                <td><a href="javascript:void(0);" class="btn btn-danger"
                                       onclick="if(confirm('Voulez-vous vraiment supprimer cette sauvegarde ?')) { document.location.href='index.php?choixTraitement=administrateur&action=supprimerUneSauvegarde&num=<?php echo $lien; ?>'; } else { void(0); }"><span
                                            class='pe-7s-trash'> </a></p></td>
                            </tr>
                        <?php }
                        if ($i == 0) {
                            echo '<tr><td colspan="3"><i>Aucune sauvegarde présente.</i></td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
