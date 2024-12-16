<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    EVENEMENTS
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
                    <h4 class="card-title">EVENEMENTS</h4>


                    <p align="right"><a class='btn btn-primary'
                                        href="index.php?choixTraitement=administrateur&action=AjoutEvenementIndex"><span
                                class='pe-7s-plus'></span></a>
                    </p>

                    <table class="table">


                        <tr>
                            <th>No Evenement</th>
                            <th>Evenement</th>
                            <th>Date de Début</th>
                            <th>Date de Fin</th>
                            <th>Cout par Enfant</th>
                            <th>Nb participants</th>
                            <th>Annuler?</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>

                        <?php


                        foreach ($tableau as $uneligne) {
                            if ($uneligne['ANNULER'] == 1) {
                                $ANNULER = "Oui";
                            } else {
                                $ANNULER = "Non";
                            }

                            // extraction des jour, mois, an de la date
                            list($annee, $mois, $jour) = explode('-', $uneligne['DATEDEBUT']);
                            $dateFrancaisDebut = $jour . "-" . $mois . "-" . $annee;
                            // extraction des jour, mois, an de la date
                            list($annee, $mois, $jour) = explode('-', $uneligne['DATEFIN']);
                            $dateFrancaisFin = $jour . "-" . $mois . "-" . $annee;

                            echo "<tr><td>" . $uneligne['NUMÉROEVENEMENT'] . "</td><td>" . $uneligne['EVENEMENT'] . "</td><td>" . $dateFrancaisDebut . "</td><td>" . $dateFrancaisFin . "</td><td>" . $uneligne['COUTPARENFANT'] . " €</td><td>" . $uneligne ['NBPARTICIPANTS'] . "</td><td>" . $ANNULER . "</td><td ><a class='btn btn-primary' href='index.php?choixTraitement=administrateur&action=modifEvenements&num=" . $uneligne['NUMÉROEVENEMENT'] . "' ><span class='pe-7s-pen'></span></a></td><td><a class='btn btn-danger' href='index.php?choixTraitement=administrateur&action=suppEvenements&num=" . $uneligne['NUMÉROEVENEMENT'] . "'><span class='pe-7s-trash'></a></td></tr>";
                        }
                        ?>


                    </table>
                </div>
