<h3>Liste des réglements CAF</h3>
<table>
    <tr>
        <th>N°</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>N° allocataire</th>
        <th>Montant</th>
        <th>Forfaits (8 €)</th>
        <th>Chèque de caution</th>
        <th>Commentaires</th>
    </tr>
    <?php
    $i = 0;
    $lesCaf = $pdo->executerRequete2('SELECT eleves.ID_ELEVE,NOM,PRENOM,N°_ALLOCATAIRE,ID_APPARTIENT_RCAF,ID_TYPEREGLEMENT,MONTANT,reglements.COMMENTAIRES,NOMREGLEMENT FROM eleves INNER JOIN reglements ON eleves.ID_ELEVE = reglements.ID_ELEVE WHERE ID_TYPEREGLEMENT = 3');

    foreach ($lesCaf as $unCaf) {
        $i++;

        echo '<tr>
	<td>' . $i . '</td>
	<td>' . $unCaf['NOM'] . '</td>
	<td>' . $unCaf['PRENOm'] . '</td>
	<td>' . $unEleve['N°_ALLOCATAIRE'] . '</td>
	<td>' . $unEleve['MONTANT'] . '</td>
	<td>' . ($unEleve['MONTANT'] / 8) . '</td>
	<td></td>
	<td>' . $unEleve['COMMENTAIRES'] . '</td>
	</tr>';


    }
    ?>
</table>