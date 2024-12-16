<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Horaires des intervenants
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

    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">

                    <h4 class="card-title">Horaires des intervenants <?php echo $statut; ?>
                        du <?php echo date('d/m/Y', strtotime($debut)); ?>
                        au <?php echo date('d/m/Y', strtotime($fin)); ?></h4>

                    <table class="table" style="width:500px;padding:0">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nombre d'heures</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($lesIntervenants as $unIntervenant) {

                            $code = '';

                            // On écrit son nom
                            $code = $code . '<tr><th colspan="2" style="background:silver;color:black;text-align:center">' . $unIntervenant['NOM'] . ' ' . $unIntervenant['PRENOM'] . '</th></tr>';

                            // Scolaire
                            $nbHeuresScolaire = 0;
                            if(isset($scolaire[$unIntervenant["ID_INTERVENANT"]])){
                                foreach ($scolaire[$unIntervenant['ID_INTERVENANT']] as $unTableau) {
                                    $moment = '';
                                    if(isset($unTableau["ID_MOMENT"])){
                                        if($unTableau["ID_MOMENT"] == 1){
                                            $moment = "matin";
                                        }
                                        else{
                                            $moment = "après-midi";
                                        }
                                    }
                                    $code = $code . '<tr><td>' . date('d/m/Y', strtotime($unTableau['SEANCE'])) .' '.$moment.'</td><td>' . $unTableau['HEURES'] . '</td></tr>';
                                    $nbHeuresScolaire = $nbHeuresScolaire + $unTableau['HEURES'];
                                }
                                $code = $code . '<tr><th>SOUS-TOTAL DES HEURES DU SCOLAIRE :</th><th>' . $nbHeuresScolaire.'</th></tr>';
                            }
                               
                            
                                

                            // RDV
                            $nbHeuresRdv = 0;
                            if(isset($rdv[$unIntervenant["ID_INTERVENANT"]])){
                                foreach ($rdv[$unIntervenant['ID_INTERVENANT']] as $unTableau) {
                                    $code = $code . '<tr><td>' . date('d/m/Y', strtotime($unTableau['DATE_RDV'])) . '</td><td>' . $unTableau['DUREE'] . '</td></tr>';
                                    $nbHeuresRdv = $nbHeuresRdv + $unTableau['DUREE'];
                                }
                                $code = $code . '<tr><th>SOUS-TOTAL DES HEURES RDV BSB :</th><th>' . $nbHeuresRdv . '</th></tr>';
                            }
                            
                            
                            //Stage
                            $nbHeuresStage = 0;
                            
                            if(isset($stage[$unIntervenant['ID_INTERVENANT']])){
                                foreach($stage[$unIntervenant['ID_INTERVENANT']] as $unTableau){
                                    $moment = '';
                                    if(isset($unTableau["ID_MOMENT"])){
                                        if($unTableau["ID_MOMENT"] == 1){
                                            $moment = "matin";
                                        }
                                        else{
                                            $moment = "après-midi";
                                        }
                                    }
                                    $code = $code. '<tr> <td>' .$unTableau["NOM_STAGE"].': '. date('d/m/Y', strtotime($unTableau['SEANCE'])) .' '.$moment.'</td><td>' . $unTableau['HEURES'] . '</td>
                                    </tr>';
    
                                    $nbHeuresStage += $unTableau['HEURES'];
                                };
                            }
                            $code = $code.'<tr><th>SOUS-TOTAL DES HEURES DES STAGES :</th><th>' . $nbHeuresStage . '</th></tr>';
                            
                            $totalHeures = ($nbHeuresRdv + $nbHeuresScolaire + $nbHeuresStage);

                            $code = $code . '<tr><th class="text-danger style=text-shadow: 4px 4px #000;">TOTAL DES HEURES DE L\'INTERVENANT :</th><th>' . $totalHeures . '</th></tr>';

                            // Si l'intervenant a des heures
                            if ($totalHeures > 0) {
                                if($statut == "Salarié"){
                                    $code .= '<tr><th class="text-danger style=text-shadow: 4px 4px #000;">SALAIRE DE L\'INTERVENANT: </th><th>'. $totalHeures*$prixHoraire.'€</th></tr>';
                                }
                                echo $code;
                            }

                        }
                        ?>
                        <!--
  <?php

                        $total = 0;
                        $id_Intervenant = 1;
                        $liste = 0;
                        foreach ($tableau as $uneLigne) {


                            if (($id_Intervenant != $uneLigne['ID_INTERVENANT']) && ($liste != 0) && ($liste != 1)) {
                                echo " <tr style='background:silver'>
					<th></th>
					<th></th>
					<th style='padding:0'> <p style='font-size:22px'>Total Horaire Intervenant:</p>  </th>
					<th style='padding:0'><p style='font-size:22px'>" . $total . "</p></th>
					</tr>";
                                $prix = $prixHoraire * $total;
                                echo " <tr style='background:silver'>
	<th></th>
	<th></th>
	<th style='padding:0'><p style='font-size:22px'> Total Prix Intervenant:  </p></th>
	<th style='padding:0'><p style='font-size:22px'>" . $prix . "</p></th>
	</tr>";
                                $total = 0;
                                $id_Intervenant = $uneLigne['ID_INTERVENANT'];
                            }

                            $liste++;
                            $id_Intervenant = $uneLigne['ID_INTERVENANT'];
                            // extraction des jour, mois, an de la date
                            list($annee, $mois, $jour) = explode('-', $uneLigne['SEANCE']);
                            $dateFrench = $jour . "-" . $mois . "-" . $annee;
                            $total += $uneLigne['HEURES'];
                            echo '<tr>
		<td style="padding:0"> ' . $uneLigne['NOM'] . '</td>
		<td style="padding:0">' . $uneLigne['PRENOM'] . ' </td>
		<td style="padding:0"> ' . $dateFrench . ' </td>
		<td style="padding:0"> ' . $uneLigne['HEURES'] . ' </td>
		</tr>';
                        }


                        echo " <tr style='background:silver'>
						<th></th>
	<th></th>
					<th style='padding:0'><p style='font-size:22px'> Total Horaire Intervenant:  </p></th>
					<th style='padding:0'><p style='font-size:22px'>" . $total . "</p></th>
					</tr>";
                        $prix = $prixHoraire * $total;
                        echo " <tr style='background:silver'>
						<th></th>
	<th></th>
					<th style='padding:0'><p style='font-size:22px'> Total Prix Intervenant: </p> </th>
					<th style='padding:0'><p style='font-size:22px'>" . $prix . "</p></th>
					</tr>";

                        ?>
  -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
