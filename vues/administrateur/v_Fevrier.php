<?php
$base = mysql_connect('mysql51-61.perso', 'tresuniobdd', '231057az');
mysql_select_db('tresuniobdd', $base);

if (isset($_POST['ID'])) {
    $req = mysql_query('DELETE FROM `avril_inscriptionProgramme` WHERE `id` = ' . $_POST['ID'] . '');
}
?>
<div id="contenu">
    <h2>Inscriptions au stage d'avril</h2>
    <br><br>
    <p><b><a href="http://tresunion.fr/avril/" style="color:red">Nouvelle inscription</a></b> - <b><a
                href="http://tresunion.fr/avril/telechargerCSV.php" style="color:green">Export Excel</a></b></p>
    <br><br>
    <table class="table">
        <thead>
        <tr>
            <th>N°</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Classe</th>
            <th>Groupe</th>
            <th>Association</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Etablissement</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;

        $groupes = array('', 'Sratch', 'Théâtre', 'Cuisine', 'Boxe', 'Foot');

        $req = mysql_query('SELECT * FROM avril_inscriptionProgramme ORDER BY avril_inscriptionProgramme.id;') or die('Erreur SQL !<br />' . $sql . '<br />' . mysql_error());
        while ($data = mysql_fetch_array($req)) {
            $i++;
            if ($data['association'] == '') {
                $data['association'] = 'ORE';
            }
            echo utf8_encode('<tr style=font-size:12px>
	<td>' . $i . '</td>
	<td>' . $data['nom'] . '</td>
	<td>' . $data['prenom'] . '</td>
	<td>' . $data['classe'] . '</td>
	<td>' . $groupes[$data['groupe']] . '</td>
	<td>' . $data['association'] . '</td>
	<td>' . $data['telephone'] . '</td>
	<td>' . $data['email'] . '</td>
	<td>' . $data['etablissement'] . '</td>
	<td>' . $data['adresse'] . '</td>
	<td>' . $data['cp'] . '</td>
	<td>' . $data['ville'] . '</td>
	<td> <form name="frmConsultFrais" method="POST" action="http://association-ore.fr/extranet/index.php?choixTraitement=administrateur&action=Avril">
	<input type="text" style="display:none" name="ID" value="' . $data['id'] . '"><input type="submit" value="Supprimer"></form></td>
	</tr>');

        }

        ?>
        </tbody>
    </table>
    <div style="clear:both"></div>
    </center>

</div>

<p>

    </div>