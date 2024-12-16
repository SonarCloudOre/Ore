<link rel="stylesheet" href="./vendors/fullcalendar/dist/fullcalendar.css">
<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-date icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Rendez-vous
                    <div class="page-title-subheading">Parents</div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="#form_ajout">
                        <button type="button" aria-haspopup="true"
                                aria-expanded="false" class="mb-2 mr-2 btn btn-primary" value="Ajouter un rendez-vous">
        <span class="btn-icon-wrapper pr-2 opacity-7">
          <i class="fa fa-calendar fa-w-20"></i>
        </span>
                            Ajouter un rendez-vous
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </div>


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
            padding: 3px;
            margin: 3px;
            background: #337ab7;
            border-radius: 10px;
            margin-bottom: 10px;
            color: white;
            font-size: 11px;
        }

        .unRdv a {
            color: white;
            text-decoration: underline;
        }
    </style>
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
        return "<a href=index.php?choixTraitement=administrateur&action=Calendrier&m=$m&a=$a> &raquo; </a>";
    }

    //FONCTION POUR AFFICHER LE MOIS PRECEDENT
    function mois_precedent($m, $mois, $a)
    {
        $m--;
        if ($m == 0) {
            $a--;
            $m = 12;
        }
        return "<a href=index.php?choixTraitement=administrateur&action=Calendrier&m=$m&a=$a> &laquo; </a>";
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
    $m = $_GET['m'];
    $a = $_GET['a'];

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
    $premierdumois = jddayofweek(cal_to_jd($CAL_FRENCH, $m, 1, $a), 0);
    if ($premierdumois == 0) {
        $premierdumois = 7;
    }

    //Préparation du tableau avec le nom du mois et la liste des jours de la semaine
    echo "
<div class='row'>
  <div class='col-lg-12'>
                                  <div class='main-card mb-12 card'>
                                      <div class='card-body'>
  <table id=calendrier border=1 bordercolor=\"#FFFFFF\"><tr><td class=\"fleches\">"
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

    $semaineAujourdhui = date('W', time());

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

            $semaineEnCours = date('W', strtotime($a . '-' . $moisRdv . '-' . $jourRdv));

            // On parcours les rdv
            foreach ($lesRendezvous as $unRdv) {

                // Si le rdv correspond à cette date
                if (substr($unRdv['DATE_RDV'], 0, 10) == $a . '-' . $moisRdv . '-' . $jourRdv) {

                    $unIntervenant = $pdo->recupUnIntervenant($unRdv['ID_INTERVENANT']);
                    echo '<div class="unRdv">
						' . substr($unRdv['DATE_RDV'], 10, 15) . '<br>
						<a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $unRdv['ID_ELEVE'] . '"><b>' . $unRdv['NOM'] . ' ' . $unRdv['PRENOM'] . '</b></a><br>(<a href="index.php?choixTraitement=administrateur&action=FicheNavette&unEleve=' . $unRdv['ID_ELEVE'] . '">fiche navette</a> - <a href="https://www.google.fr/maps/place/' . $unRdv['ADRESSE_POSTALE'] . '+' . $unRdv['CODE_POSTAL'] . '+' . $unRdv['VILLE'] . '/">adresse</a>)
						<br>avec <a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unRdv['ID_INTERVENANT'] . '"><b>' . $unIntervenant['NOM'] . ' ' . $unIntervenant['PRENOM'] . '</b></a><br>
						<small><i>' . stripslashes($unRdv['COMMENTAIRE']) . '</i></small>';

                    if ($admin == 2 or $semaineAujourdhui == $semaineEnCours or strtotime($unRdv['DATE_RDV']) > time()) {
                        echo '<br><a href="javascript:if(confirm(\'Voulez-vous vraiment supprimer ce rendez-vous ?\')) { document.location.href=\'index.php?choixTraitement=administrateur&action=supprimerRdv&page=Calendrier&num=' . $unRdv['ID_RDV'] . '\'; };" class="btn btn-danger"><span class="glyphicon glyphicon-trash" style="width:10px"></span></a>';
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
                echo "</tr></table></div></div></div></div>";
                $i = 41;
            }
        }

        // Si la variable i correspond à un dimanche (multiple de 7), on passe à la ligne suivante dans le tableau
        if ($i % 7 == 0) {
            echo "</tr><tr>";
        }

    }

    ?><br><br><br>

    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-2" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div id="calendar-bg-events"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h3 id="form_ajout" class="card-title">Ajouter un rendez-vous</h3>
                    <br>
                    <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
                          action="index.php?choixTraitement=administrateur&action=ajoutRdv">
                        <div class="form-group">

                            <label for="num">Enfant </label>
                            <select class="form-control" name="num" style="width:200px" required>
                                <option disabled selected>Choisir</option>
                                <?php
                                foreach ($lesEleves as $unEleve) {
                                    echo '<option value="' . $unEleve['ID_ELEVE'] . '">' . $unEleve['NOM'] . ' ' . $unEleve['PRENOM'] . '</option>';
                                }
                                ?>
                            </select><br>

                            <label for="num">Intervenant </label>
                            <select class="form-control" name="intervenant" style="width:200px" required>
                                <option disabled selected>Choisir</option>
                                <?php
                                foreach ($lesIntervenants as $unIntervenant) {
                                    echo '<option value="' . $unIntervenant['ID_INTERVENANT'] . '">' . $unIntervenant['NOM'] . ' ' . $unIntervenant['PRENOM'] . '</option>';
                                }
                                ?>
                            </select><br>

                            <label for="date_inscription">Date du rendez-vous</label><br>
                            <?php formulaireDate(0, 0, 0, "date_inscription"); ?><br><br>

                            <label for="heure_inscription">Heure du rendez-vous</label>
                            <input class="form-control" name="heure" autofocus="" value="" placeholder="00:00"
                                   style="width:200px" type="time" required> HH:MM<br><br>

                            <label for="commentaire">Commentaires</label>
                            <textarea name="commentaire" class="form-control"></textarea><br><br>

                            <input value="Valider" type="submit" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="./vendors/moment/moment.js"></script>
<script type="text/javascript" src="./vendors/fullcalendar/dist/fullcalendar.js"></script>
<script type="text/javascript" src="./js/calendar.js"></script>
<script type="text/javascript" src="./vendors/fullcalendar/dist/locale/fr.js"></script>
<script type="text/javascript" src="./vendors/fullcalendar/dist/gcal.js"></script>
