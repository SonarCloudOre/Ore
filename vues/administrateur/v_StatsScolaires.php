<?php
// Génére un grapghique camembert avec les valeurs demandées
function genererGraphique($id, $type, $hauteur, $largeur, $titre, $valeurs, $nom, $nb, $total)
{
    $couleurs = array('red', 'blue', 'green', 'pink', 'orange', 'brown', 'gray', 'lime', 'maroon', 'olive', 'navy', 'teal', 'yellow', 'purple');
    echo "<canvas id='" . $id . "'></canvas>
            <script>
var ctx = document.getElementById('" . $id . "');
ctx.height = " . $hauteur . ";
ctx.width = " . $largeur . ";
var myChart = new Chart(ctx, {
    type: '" . $type . "',
    data: { labels: [";
    $i = 0;
    foreach ($valeurs as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat[$nom] . " : " . $uneStat[$nb] . " (" . round(($uneStat[$nb] / $total) * 100) . " %)'";
        $i++;
    }
    echo "],
        datasets: [{ label: '',
            data: [";
    $i = 0;
    foreach ($valeurs as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat[$nb] . "'";
        $i++;
    }
    echo "], backgroundColor: [";
    $i = 0;
    foreach ($valeurs as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $couleurs[$i] . "'";
        $i++;
    }
    echo "]
        }]
    },
    options: { responsive: false,
        legend: { position: 'right' },
        title: { display: true, text: '" . $titre . "' }
    }
});
</script>";
}

?>

<!-- Répartition par sexe -->
<div class="bloc_graphique"
     style="width:530px"><?php genererGraphique('graph_sexe', 'pie', 300, 520, 'Répartition par sexe', $nbElevesParSexe, 'SEXE', 'COUNT(*)', $nbEleves['COUNT(*)']); ?></div>


<!-- Répartition par classe -->
<div class="bloc_graphique"
     style="width:530px"><?php genererGraphique('graph_classe', 'pie', 300, 520, 'Répartition par classe', $nbElevesParClasse, 'NOM', 'COUNT(*)', $nbEleves['COUNT(*)']); ?></div>


<!-- Répartition par ville -->
<div class="bloc_graphique" style="width:530px">
    <?php
    $couleurs = array('red', 'blue', 'green', 'pink', 'orange', 'brown', 'gray', 'lime', 'maroon', 'olive', 'navy', 'teal', 'yellow', 'purple');
    echo "<canvas id='graph_villes'></canvas>
            <script>
var ctx = document.getElementById('graph_villes');
ctx.height = 400;
ctx.width = 520;
var myChart = new Chart(ctx, {
    type: 'pie',
    data: { labels: [";
    $i = 0;
    $totalElevesVille = 0;
    foreach ($nbElevesParVille as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat['VILLE'] . " : " . $uneStat['COUNT(*)'] . " (" . round(($uneStat['COUNT(*)'] / $nbEleves['COUNT(*)']) * 100) . " %)'";
        $totalElevesVille = $totalElevesVille + $uneStat['COUNT(*)'];
        $i++;
    }
    echo ",'Autres villes : " . ($nbEleves['COUNT(*)'] - $totalElevesVille) . " (" . round((($nbEleves['COUNT(*)'] - $totalElevesVille) / $nbEleves['COUNT(*)']) * 100) . " %)'],
        datasets: [{ label: '',
            data: [";
    $i = 0;
    foreach ($nbElevesParVille as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat['COUNT(*)'] . "'";
        $i++;
    }
    echo ",'" . ($nbEleves['COUNT(*)'] - $totalElevesVille) . "'], backgroundColor: [";
    $i = 0;
    foreach ($nbElevesParVille as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $couleurs[$i] . "'";
        $i++;
    }
    echo ",'" . $couleurs[$i] . "']
        }]
    },
    options: { responsive: false,
        legend: { position: 'right' },
        title: { display: true, text: 'Répartition par ville' }
    }
});
</script>";
    ?>
</div>


<!-- Répartition par filière -->
<div class="bloc_graphique" style="width:530px">
    <?php
    echo "<canvas id='graph_filieres'></canvas>
            <script>
var ctx = document.getElementById('graph_filieres');
ctx.height = 400;
ctx.width = 520;
var myChart = new Chart(ctx, {
    type: 'pie',
    data: { labels: [";
    $i = 0;
    foreach ($nbElevesParFiliere as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'";
        foreach ($lesClasses as $uneClasse) {
            if ($uneClasse['ID'] == $uneStat['ID_CLASSE']) {
                echo $uneClasse['NOM'];
                break;
            }
        }
        echo " " . $uneStat['NOM'] . " : " . $uneStat['COUNT(*)'] . " (" . round(($uneStat['COUNT(*)'] / $nbEleves['COUNT(*)']) * 100) . " %)'";
        $i++;
    }
    echo "],
        datasets: [{ label: '',
            data: [";
    $i = 0;
    foreach ($nbElevesParFiliere as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat['COUNT(*)'] . "'";
        $i++;
    }
    echo "], backgroundColor: [";
    $i = 0;
    foreach ($nbElevesParFiliere as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $couleurs[$i] . "'";
        $i++;
    }
    echo "]
        }]
    },
    options: { responsive: false,
        legend: { position: 'right' },
        title: { display: true, text: 'Répartition des lycéens par classe et filière' }
    },
    pieceLabel: {
        mode: 'value',
        precision: 0,
        fontSize: 18,
        fontColor: '#fff',
        fontStyle: 'bold',
        fontFamily: \"'Helvetica Neue', 'Helvetica', 'Arial', sans-serif\"
    }
});
</script>";
    ?>
</div>


<!-- Présences des élèves -->
<div class="bloc_graphique" style="width:100%">
    <h4>
        <center>Présences des élèves</center>
    </h4>
    <?php
    echo "<canvas id='graph_presences_eleves'></canvas>
            <script>
var ctx = document.getElementById('graph_presences_eleves');
ctx.height = 300;
ctx.width = 1000;
var myChart = new Chart(ctx, {
    type: 'line',
    data: { labels: [";
    $i = 0;
    $moisPrecedent = '';
    foreach ($nbPresencesEleves as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        // Si le mois change
        if ($moisPrecedent != date('m', strtotime($uneStat['SEANCE']))) {
            echo "'" . $moisNoms[date('m', strtotime($uneStat['SEANCE']))] . "'";
            $moisPrecedent = date('m', strtotime($uneStat['SEANCE']));
        } else {
            echo "''";
        }
        $i++;
    }
    echo "],
        datasets: [{ label: 'Année scolaire " . $anneeEnCours . "-" . ($anneeEnCours + 1) . "',
            data: [";
    $i = 0;
    foreach ($nbPresencesEleves as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat['COUNT(*)'] . "'";
        $i++;
    }
    echo "], borderColor: 'rgb(0,0,255)'
        },
        { label: 'Année scolaire " . ($anneeEnCours - 1) . "-" . $anneeEnCours . "',
            data: [";
    $i = 0;
    foreach ($nbPresencesElevesAvant as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat['COUNT(*)'] . "'";
        $i++;
    }
    echo "], borderColor: 'rgb(128,128,128)'
        }]
    },
    options: {
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    },
        responsive: false,
        legend: {
            labels: {
                fontColor: 'black',
                defaultFontSize: 20
            }
        }
    }
});
</script>";
    ?>
</div>


<div class="bloc_graphique" style="width:100%">
    <h4>
        <center>Présences des intervenants</center>
    </h4>
    <?php
    echo "<canvas id='graph_presences_intervenants'></canvas>
            <script>
var ctx = document.getElementById('graph_presences_intervenants');
ctx.height = 300;
ctx.width = 1000;
var myChart = new Chart(ctx, {
    type: 'line',
    data: { labels: [";
    $i = 0;
    $moisPrecedent = '';
    foreach ($nbPresencesIntervenants as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        // Si le mois change
        if ($moisPrecedent != date('m', strtotime($uneStat['SEANCE']))) {
            echo "'" . $moisNoms[date('m', strtotime($uneStat['SEANCE']))] . "'";
            $moisPrecedent = date('m', strtotime($uneStat['SEANCE']));
        } else {
            echo "''";
        }
        $i++;
    }
    echo "],
        datasets: [{ label: 'Année scolaire " . $anneeEnCours . "-" . ($anneeEnCours + 1) . "',
            data: [";
    $i = 0;
    foreach ($nbPresencesIntervenants as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat['COUNT(*)'] . "'";
        $i++;
    }
    echo "], borderColor: 'rgb(0,0,255)'
        },
        { label: 'Année scolaire " . ($anneeEnCours - 1) . "-" . $anneeEnCours . "',
            data: [";
    $i = 0;
    foreach ($nbPresencesIntervenantsAvant as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        echo "'" . $uneStat['COUNT(*)'] . "'";
        $i++;
    }
    echo "], borderColor: 'rgb(128,128,128)'
        }]
    },
    options: {
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    },
        responsive: false,
        legend: {
            labels: {
                fontColor: 'black',
                defaultFontSize: 20
            }
        }
    }
});
</script>";
    ?>
</div>


<div class="bloc_graphique" style="width:100%">
    <h4>
        <center>Inscriptions</center>
    </h4>
    <?php
    echo "<canvas id='graph_inscriptions'></canvas>
            <script>
var ctx = document.getElementById('graph_inscriptions');
ctx.height = 300;
ctx.width = 1000;
var myChart = new Chart(ctx, {
    type: 'line',
    data: { labels: [";
    $i = 0;
    foreach ($nbInscriptionsEleves as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        // Si le mois change
        if ($moisPrecedent != date('m', strtotime($uneStat['DATE_INSCRIPTION']))) {
            echo "'" . $moisNoms[date('m', strtotime($uneStat['DATE_INSCRIPTION']))] . "'";
            $moisPrecedent = date('m', strtotime($uneStat['DATE_INSCRIPTION']));
        } else {
            echo "''";
        }
        $i++;
    }
    echo "],
        datasets: [{ label: 'Année scolaire " . $anneeEnCours . "-" . ($anneeEnCours + 1) . "',
            data: [";
    $i = 0;
    $nbInscriptions = 0;
    foreach ($nbInscriptionsEleves as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        $nbInscriptions = $nbInscriptions + $uneStat['COUNT(*)'];
        echo "'" . $nbInscriptions . "'";
        $i++;
    }
    echo "], borderColor: 'rgb(0,0,255)'
        },
        { label: 'Année scolaire " . ($anneeEnCours - 1) . "-" . $anneeEnCours . "',
            data: [";
    $i = 0;
    $nbInscriptions = 0;
    foreach ($nbInscriptionsElevesAvant as $uneStat) {
        if ($i > 0) {
            echo ',';
        }
        $nbInscriptions = $nbInscriptions + $uneStat['COUNT(*)'];
        echo "'" . $nbInscriptions . "'";
        $i++;
    }
    echo "], borderColor: 'rgb(128,128,128)'
        }]
    },
    options: {
        scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    },
        responsive: false,
        legend: {
            labels: {
                fontColor: 'black',
                defaultFontSize: 20
            }
        }
    }
});
</script>";
    ?>
</div>

<?php
foreach ($lesActivites as $uneActivite) {
    ?>
    <div role="tabpanel" class="tab-pane" id="stats_activite_<?php echo $uneActivite['id_activite']; ?>">

    </div>
<?php } ?>

</div>

<?php
// Contenu des Onglets des stats des activités
foreach ($lesActivites as $uneActivite) {

    // Création de l'onglet
    echo '<div role="tabpanel" class="tab-pane" id="stats_activite_' . $uneActivite['id_activite'] . '">';

    // Récupération des différentes stats
    $num = $uneActivite['id_activite'];
    // Liste des présences
    $stats_totalPresences = $pdo->info_getTotalPresences($num, $anneeEnCours);

    // Répartition par sexe
    $stats_repartitionSexe = $pdo->info_getRepartitionSexe($num);

    // Répartition par ville
    $stats_repartitionVille = $pdo->info_getRepartitionVille($num);

    // Répartition par age
    $stats_repartitionAge = $pdo->info_getRepartitionAge($num);

    // Calcul des présences
    $totalPresences = 0;
    $nbDates = 0;
    foreach ($stats_totalPresences as $unePresence) {
        $totalPresences = ($totalPresences + $unePresence['COUNT(*)']);
        $nbDates++;
    }

    // Calcul de la moyenne des présences
    if ($nbDates == 0) {
        $stats_moyennePresences = 0;
    } else {
        $stats_moyennePresences = round($totalPresences / $nbDates);
    }

    // On inclut la vue qui va afficher ces stats
    //include("vues/administrateur/centreinfo/v_stats.php");

    // Fin de l'onglet
    echo '</div>';
} ?>

<script type="text/javascript">
    $('#onglets a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>
