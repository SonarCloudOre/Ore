<div id="contenu">


    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Horaires des intervenants
                    <div class="page-title-subheading">Horaires de travail
                        de <?php echo $UnIntervenant['PRENOM'] . " " . $UnIntervenant['NOM']; ?></div>
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                    <button type="button" class="btn btn-primary" value="" onClick="imprimer2('sectionAimprimer2');">
                        <i class="fa fa-print"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <?php
    //Date de début et de fin en Français
    list($anneeD, $moisD, $jourD) = explode('-', $debut);
    $dateDebut = $jourD . "-" . $moisD . "-" . $anneeD;
    list($anneeF, $moisF, $jourF) = explode('-', $fin);
    $dateFin = $jourF . "-" . $moisF . "-" . $anneeF;
    ?>

    <div class="col-lg-13">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4 class="card-title">Du <?php echo $dateDebut; ?> AU <?php echo $dateFin; ?></h4>


                <table class="mb-0 table">
                    <tr>
                        <th> Date</th>
                        <th> Nombre Heure</th>
                    </tr>

                    <?php

                    

                    $totalScolaire = 0;
                    $totalStage = 0;
                    foreach($scolaire as $uneLigne){
                        $moment = "";
                        if($uneLigne["ID_MOMENT"] != null){
                            if($uneLigne["ID_MOMENT"] == 1){
                                $moment = " matin";
                            }
                            else{
                                $moment = " après-midi";
                            }
                        }
                         // extraction des jour, mois, an de la date
                         list($annee, $mois, $jour) = explode('-', $uneLigne['SEANCE']);
                         // calcul du timestamp
                         $dateFrench = $jour . "-" . $mois . "-" . $annee;

                         $totalScolaire += $uneLigne['HEURES'];
                         echo '<tr> <td style="width:200px;"> ' . $dateFrench . ' '.$moment.' </td> <td style="width:200px;"> ' . $uneLigne['HEURES'] . ' </td>  </tr>';
                    }

                    echo " <tr style='background-color:lightgrey;'><th style='width:200px;'> SOUS-TOTAL DES HEURES DU SCOLAIRE:  </th><th style='width:200px;'>" . $totalScolaire . "</th></tr>";
                    
                    foreach($horaireStage as $unHoraire){
                        $moment = "";
                        if($unHoraire["ID_MOMENT"] != null){
                            if($unHoraire["ID_MOMENT"] == 1){
                                $moment = " matin";
                            }
                            else{
                                $moment = " après-midi";
                            }
                        }
                        // extraction des jour, mois, an de la date
                        list($annee, $mois, $jour) = explode('-', $unHoraire['SEANCE']);
                        // calcul du timestamp
                        $dateFrench = $jour . "-" . $mois . "-" . $annee;

                        
                        $totalStage += $unHoraire['HEURES'];
                        echo '<tr> <td style="width:200px;"> ' .$unHoraire["NOM_STAGE"].': '.$dateFrench . ' '.$moment.' </td> <td style="width:200px;"> ' . $unHoraire['HEURES'] . ' </td>  </tr>';
                    }

                    echo " <tr style='background-color:lightgrey;'><th style='width:200px;'> SOUS-TOTAL DES HEURES DES STAGES:  </th><th style='width:200px;'>" . $totalStage . "</th></tr>";
                    $total = $totalScolaire + $totalStage;
                    
                    echo " <tr style='background-color:lightgrey;'><th style='width:200px;text-shadow: 0.5px 0.5px #000' class='text-danger'> TOTAL DES HEURES DE L'INTERVENANT:  </th><th style='width:200px;'>" . $total . "</th></tr>";
                    $prix = $prixHoraire * $total;
                    echo " <tr style='background-color:lightgrey;'><th style='width:200px;text-shadow: 0.5px 0.5px #000' class='text-danger'> SALAIRE DE L'INTERVENANT :  </th><th style='width:200px;'>" . $prix . " €</th></tr> </table></div></div></div>";
                    ?>


            </div>
