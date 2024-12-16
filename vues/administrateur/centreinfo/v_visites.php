<h2>Visites sur les ordinateurs</h2>
<form method="POST" action="index.php?choixTraitement=administrateur&action=info_visites">
    <center>
        <select name="periode" onchange="this.form.submit()" class="form-control" data-live-search="true">
            <option disabled="disabled" selected="selected">Choisir</option>
            <option value="tout">Toutes périodes</option>
            <?php foreach ($lesMois as $unMois) {
                if (isset($_REQUEST['periode']) and $_REQUEST['periode'] == $unMois['periode']) {
                    $selectionner = "selected='selected'";
                } else {
                    $selectionner = "";
                }


                echo " <option " . $selectionner . " value='" . $unMois['periode'] . "'>" . $unMois['periode'] . "</option>";
            } ?>
        </select>
    </center>
</form>

<?php if (isset($_REQUEST['periode'])) { ?>
    <br><br>
    <hr>
    <?php if ($admin == 2 && $_REQUEST['periode'] != 'tout') { ?><p style="text-align:right">
        <a href="javascript:void(0);"
           onclick="if(confirm('Voulez-vous vraiment supprimer ces visites ?')) { document.location.href='index.php?choixTraitement=administrateur&action=info_supprimerVisites&periode=<?php echo $_REQUEST['periode']; ?>'; } else { void(0); }"
           class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Supprimer les visites de ce mois</a>
        </p><?php } ?>
    <br><br>
    <table class="table">
        <thead>
        <tr>
            <th>Utilisateur</th>
            <th>Date</th>
            <th>PC n°</th>
            <th>Logiciel</th>
            <th>URL</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($lesVisites as $uneVisite) {
            echo '<tr>
        <td>' . $uneVisite['code_cyberlux'] . '</td>
        <td>' . date('d/m/Y H:i', strtotime($uneVisite['date_visite'])) . '</td>
        <td>' . $uneVisite['pc_visite'] . '</td>
        <td>' . $uneVisite['logiciel_visite'] . '</td>
        <td>' . $uneVisite['url_visite'] . '</td>
    </tr>';
        }

        ?>
        </tbody>
    </table>
<?php } ?>