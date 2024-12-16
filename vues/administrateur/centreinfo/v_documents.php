<h2>Documents envoyés</h2>
<table class="table">
    <thead>
    <tr>
        <th>Element</th>
        <th>Commentaire</th>
        <th>Taille</th>
        <th>Date d'ajout</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $inscription_prec = '';

    // Parcours des documents
    foreach ($lesDocuments as $unDocument) {

        // Si l'inscription change
        if ($unDocument['id_inscription'] != $inscription_prec) {

            echo '<tr>
			<th colspan="5">
				<i class="fas fa-folder-open"></i>
				<a href="index.php?choixTraitement=administrateur&action=info_inscriptions&uneInscription=' . $unDocument['id_inscription'] . '">
					' . $unDocument['nom_inscription'] . ' ' . $unDocument['prenom_inscription'] . '
				</a>
			</th>
		</tr>';

            $inscription_prec = $unDocument['id_inscription'];
        }

        // URL du fichier
        $url_fichier = 'documentsCentreInfo/' . $unDocument['id_inscription'] . '/' . $unDocument['nom_document'];

        // Icone
        $icone = 'file';
        $ext = $unDocument['type_document'];
        switch ($ext) {

            // Documents
            case 'application/msword':
            case 'application/vnd.oasis.opendocument.text':
                $icone = 'file-word';
                break;
            case 'application/msexcel':
            case 'application/vnd.oasis.opendocument.spreadsheet':
                $icone = 'file-excel';
                break;
            case 'application/mspowerpoint':
            case 'application/vnd.oasis.opendocument.presentation':
                $icone = 'file-powerpoint';
                break;
            case 'application/pdf':
                $icone = 'file-pdf';
                break;

            // Images
            case 'image/png':
            case 'image/jpeg':
            case 'image/gif':
            case 'image/bmp':
                $icone = 'file-image';
                break;

            // Autres
            case 'application/zip':
            case 'application/x-rar-compressed':
                $icone = 'file-archive';
                break;
        }

        // Taille du fichier
        $taille = $unDocument['taille_document'];
        $lesUnites = array('octet', 'Ko', 'Mo', 'Go', 'To');
        $base = 1024;
        for ($i = 0; $i < count($lesUnites); $i++) {
            if ($taille >= pow($base, $i)) {
                $taille = round($taille / pow($base, $i));
                $unite = $lesUnites[$i];
            } else break;
        }

        // Génération de la ligne
        echo '<tr>
			<td style="padding-left:40px"><i class="fas fa-' . $icone . '" title="' . $ext . '"></i> ' . $unDocument['nom_document'] . '</td>
			<td><em>' . stripslashes($unDocument['commentaire_document']) . '</em></td>
			<td>' . $taille . ' ' . $unite . '</td>
			<td>' . date('d/m/Y', strtotime($unDocument['date_document'])) . '</td>
			<td><a href="index.php?choixTraitement=administrateur&action=info_telechargerDocument&id_document=' . $unDocument['id_document'] . '" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download-alt"></span> Télécharger</a></td>
		</tr>';
    }
    ?>
    </tbody>
</table>