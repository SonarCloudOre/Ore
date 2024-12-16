<style type="text/css">
    #calendrier {
        border: 1px solid silver;
        border-collapse: collapse;
        width: 1000px;
        margin: auto;
    }

    #calendrier td, #calendrier th {
        text-align: center;
        padding: 5px;
        font-size: 14px;
    }

    .nom_mois, .fleches {
        background: #337ab7;
        color: white;
        font-weight: bold;
    }

    .fleches a {
        color: white;
    }

    .noms_jours {
        background: #DDDDDD;
        font-weight: bold;
    }

    .cases_vides, .aujourdhui, .jours {
        height: 100px;
        vertical-align: top;
    }

    .cases_vides:hover, .jours:hover {
        background: #EEEEEE;
    }

    .cases_vides {
        color: gray;
    }

    .aujourdhui {
        background: #337ab7;
        color: white;
        font-weight: bold;
    }

    .aujourdhui a {
        color: white;
    }

    .unRdv {
        padding: 5px 0 5px 0;
        margin: 1px;
        background: #337ab7;
        border-radius: 10px;
        margin-bottom: 5px;
        color: white;
        font-size: 11px;
    }

    .unRdv a {
        color: white;
        text-decoration: underline;
    }
</style>

<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Mon planning
                    <div class="page-title-subheading"></div>
                    <div class="page-title-subheading">Mes disponibilités confirmé</div>
                </div>
            </div>
            <div class="page-title-actions">
                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
            </div>
        </div>
    </div>

    <?php

    //FONCTION PRINCIPALE DU CALENDRIER
    //FONCTION POUR AFFICHER LE MOIS SUIVANT
    function mois_suivant($m, $a)
    {
        $m++;    //mois suivant, donc on incrémente de 1
        if ($m == 13) {    //si le mois et 13 ça joue pas! cela veut dire qu'il faut augmenter l'année de 1 et repasser le mois à 1
            $a++;
            $m = 1;
        }
        return "<a href=index.php?choixTraitement=intervenant&action=Planning&m=$m&a=$a> &raquo; </a>";
    }

    //FONCTION POUR AFFICHER LE MOIS PRECEDENT
    function mois_precedent($m, $mois, $a)
    {
        $m--;
        if ($m == 0) {
            $a--;
            $m = 12;
        }
        return "<a href=index.php?choixTraitement=intervenant&action=Planning&m=$m&a=$a> &laquo; </a>";
    }

    // Tableau pour le noms des mois
    $mois = array();
    $mois[1] = "Janvier";
    $mois[2] = "Février";
    $mois[3] = "Mars";
    $mois[4] = "Avril";
    $mois[5] = "Mai";
    $mois[6] = "Juin";
    $mois[7] = "Juillet";
    $mois[8] = "Août";
    $mois[9] = "Septembre";
    $mois[10] = "Octobre";
    $mois[11] = "Novembre";
    $mois[12] = "Décembre";

    // Tableau pour le noms des jours
    $jours = array();
    $jours[1] = "Lu";
    $jours[2] = "Ma";
    $jours[3] = "Me";
    $jours[4] = "Je";
    $jours[5] = "Ve";
    $jours[6] = "Sa";
    $jours[7] = "Di";

    // On récupère le mois et l'année dans la barre de navigation
    $m = @$_GET['m'];
    $a = @$_GET['a'];

    // Si rien n'est spécifié, cela veut dire qu'il faut afficher le mois et l'année donnés par la fonction
    if ($m == "") {
        $m = date("n");
    }
    if ($a == "") {
        $a = date("Y");
    }

    // Calcul du nombre de jours dans chaque mois en prenant compte des années bisextiles. les tableaux PHP commençant à 0 et non à 1, le premier mois est un mois "factice"
    if (($a % 4) == 0) {
        $nbrjour = array(0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    } else {
        $nbrjour = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    }

    // On cherche grâce à cette fonction à quel jour de la semaine correspond le 1er du mois
    $premierdumois = jddayofweek(cal_to_jd(CAL_FRENCH, $m, 1, $a), 0);
    if ($premierdumois == 0) {
        $premierdumois = 7;
    }


    //Préparation du tableau avec le nom du mois et la liste des jours de la semaine
    echo '<div class="row">
																			<div class="col-lg-12">
																					<div class="main-card mb-3 card">
																							<div class="card-body">';

    echo "<table id=calendrier border=1 bordercolor=\"#FFFFFF\"><tr><td class=\"fleches\">"
        . mois_precedent($m, $mois[$m], $a)
        . "</td><td class=\"nom_mois\" colspan=\"5\">$mois[$m] $a</td><td class=\"fleches\">"
        . mois_suivant($m, $a)
        . "</td></tr><tr class=\"noms_jours\">"
        . "<td>$jours[1]</td><td>$jours[2]</td><td>$jours[3]</td><td>$jours[4]</td><td>$jours[5]</td><td>$jours[6]</td><td>$jours[7]</td></tr><tr>";

    $jour = 1;    //Cette variable est celle qui va afficher les jours de la semaine
    $joursmoisavant = $nbrjour[$m - 1] - $premierdumois + 2;        //Celle-ci sert à afficher les jours du mois précédent qui apparaissent
    $jourmoissuivant = 1; //Et celle-ci les jours du mois suivant
    if ($m == 1) {
        $joursmoisavant = $nbrjour[$m + 11] - $premierdumois + 2; //Si c'est janvier, le mois d'avant n'est pas à 0 mais 31 jours!
    }

    //Et c'est parti pour la boucle for qui va créer l'affichage de notre calendrier !
    for ($i = 1; $i < 40; $i++) {
        if ($i < $premierdumois) {    // Tant que la variable i ne correspond pas au premier jour du mois, on fait des cellules de tableau avec les derniers jours du mois précédent
            echo "<td class=\"cases_vides\">$joursmoisavant</td>";
            $joursmoisavant++;
        } else {
            if ($jour == date("d") && $m == date("n")) {    //Si la variable $jour correspond à la date d'aujourd'hui, la case est d'une couleur différente
                $class = 'aujourdhui';
            } else {
                $class = 'jours';
            }

            // Rajout des zéros
            if (strlen($m) == 1) {
                $moisRdv = '0' . $m;
            } else {
                $moisRdv = $m;
            }
            if (strlen($jour) == 1) {
                $jourRdv = '0' . $jour;
            } else {
                $jourRdv = $jour;
            }

            echo "<td class=\"" . $class . "\" style=width:300px>
				<a href=\"#form_ajout\" onclick=\"document.getElementById('date').value='$a-$moisRdv-$jourRdv';\">$jour</a>
				<br>";

            // On parcours les dispos

            foreach ($planning as $uneLigne) {

                // Si la dispo correspond au jour actuel
                if ($a . '-' . $moisRdv . '-' . $jourRdv == $uneLigne['DATE_PRESENCE']) {

                    echo '<div class="unRdv"><b>DISPONIBLE</b><br>';

                    $dateSeance = mktime(0, 0, 0, $moisRdv, $jourRdv, $a);
                    $dateToday = time();
                    $difference = $dateSeance - $dateToday;

                    // Si c'est dans moins d'une semaine
                    if ($difference < 604800) {
                        echo '<br><b style="color:white;background:green;padding:10px">Validée</b><br><br>';
                    } else {
                        echo '<a href="javascript:if(confirm(\'Voulez-vous vraiment supprimer cette disponibilité ?\')) { document.location.href=\'index.php?choixTraitement=intervenant&action=supprimerDispo&m=' . $m . '&a=' . $a . '&date=' . $uneLigne['DATE_PRESENCE'] . '\'; };" class="btn btn-danger"><span class="glyphicon glyphicon-trash" style="width:10px"></span> Supprimer</a>';
                    }

                    echo '</div>';

                }

            }


            echo "</td>";


            $jour++;    //On passe au lendemain ^^

            /*Si la variable $jour est plus élevée que le nombre de jours du mois,  c'est que c'est la fin du mois!
                On remplit les cases vides avec les premiers jours des mois suivants
                Hop on ferme le tableau,
                et on met la variable $i à 41 pour sortir de la boucle */
            if ($jour > ($nbrjour[$m])) {
                while ($i % 7 != 0) {
                    echo "<td class=\"cases_vides\">$jourmoissuivant</td>";
                    $i++;
                    $jourmoissuivant++;
                }
                echo "</tr></table> </div></div></div></div>";
                $i = 41;
            }
        }

        // Si la variable i correspond à un dimanche (multiple de 7), on passe à la ligne suivante dans le tableau
        if ($i % 7 == 0) {
            echo "</tr><tr>";
        }

    }

    ?><br>

    <ul>
        <?php
        /*
        $i = 0;
        foreach ($planning as $uneLigne)
                           {
                               $valeur1= date("d-m-Y", strtotime($uneLigne['DATE_PRESENCE']));
                               echo "<li>".$valeur1."</li>";
                               $i++;
                           }
           if($i == 0) { echo '<p><i>Aucune dispo.</i></p>'; } */
        ?>

    </ul>

    <br/>
    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=intervenant&action=valideModif">
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Ajouter des dates de disponibilité</h4>
                        <p>Toute confirmation de votre présence ne peut être annulée, en cas d'empêchement de dernière
                            minute, merci de contacter l'association.</p>
                        <div class="alert alert-info"><strong>Pour rappel, voici les dates des vacances scolaires
                                :</strong><br>
                            <?php foreach ($lesVacances as $uneVacance) {
                                echo nl2br($uneVacance['NOM']);
                            } ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <label class="card-title" for="date">Cochez vos disponibilités<br></label><br><br>
                        <?php

                        //$dateAujourdhui=date();
                        // $tableaudate=array();

                        for ($i = 2; $i < 40; $i++) {
                            $dateCircuit = date('d-m-Y', strtotime('+' . $i . ' day'));


                            // extraction des jour, mois, an de la date
                            list($jour, $mois, $annee) = explode('-', $dateCircuit);
                            // calcul du timestamp
                            $timestamp = mktime(0, 0, 0, $mois, $jour, $annee);
                            // affichage du jour de la semaine
                            $jour = date("w", $timestamp);


                            if ($jour == 3) //si mercredi
                            {

                                echo " <input name='date[]' type='checkbox' value='" . $dateCircuit . "'  /> Mercredi " . $dateCircuit . "<br>";

                            }

                            if ($jour == 6) // si samedi
                            {
                                echo " <input name='date[]' type='checkbox' value='" . $dateCircuit . "'  /> Samedi " . $dateCircuit . "<br>";
                            }

                        }
                        ?>

                        <br/>

                        <p><input value="Soummettre" type="submit" class="btn btn-success"></p>
                    </div>
                </div>
            </div>
        </div>
    </form>


</div>
