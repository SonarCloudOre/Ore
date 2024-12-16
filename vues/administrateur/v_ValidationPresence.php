<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Disponibilités des intervenants
                </div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown" style="text-align:center;">
                    <div class="row">
                        <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                            <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                        </button>
                        <button type="button" class="btn btn-primary" value=""
                                onClick="imprimer2('sectionAimprimer2');">
                            <i class="fa fa-print"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <form name="frmConsultFrais" method="POST"
              action="index.php?choixTraitement=administrateur&action=ValidationPresence">
            <div class="row">
                <div class="col col-md-6">
                    <div class="card main-card">
                        <div class="card-body">

                            <h4 class="card-title">Disponibilités des intervenants </h4>
                            <label for="seance">Séance</label><br>
                            <?php
                            $orgDate = "2019-02-26";
                            $SeanceFr = date("d-m-Y", strtotime($seance));
                            ?>
                            <input type="date" class="form-control" name="seance" value="<?php echo $seance; ?>"
                                   style="max-width:200px;">

                            <br><br>
                            <p><input value="Valider" type="submit" class="btn btn-success"></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php
    if ($seance != '--') {
        echo '
  <div class="row">
    <div class="col col-md-6">
      <div class="card main-card">
        <div class="card-body">

  <hr><h2>Intervenants pour la séance du ' . $SeanceFr . '</h2>

	<table class="table">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Spécialités</th>
			</tr>
		</thead>
		<tbody>
	';

        foreach ($heures as $uneHeure) {
            $unIntervenant = $pdo->recupUnIntervenant($uneHeure['ID_INTERVENANT']);
            echo '<tr>
			<td><a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $uneHeure['ID_INTERVENANT'] . '">' . $unIntervenant['NOM'] . '</a></td>
			<td><a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $uneHeure['ID_INTERVENANT'] . '">' . $unIntervenant['PRENOM'] . '</a></td>
			<td>' . $unIntervenant['DIPLOME'] . '</td>
		</tr>';

        }

        echo '</tbody></table>

</div>
</div>
</div>
</div>
  ';

    }

    ?>


    <?php
    /*
    echo "<h4>Disponibilités des intervenants</h4>";
            echo '<table> <tr>';
               for($i=0;$i<30;$i++)
          {
                $dateCircuit = date('d-m-Y', strtotime('+'.$i.' day'));

                // extraction des jour, mois, an de la date
                list($jour, $mois, $annee) = explode('-', $dateCircuit);
                // calcul du timestamp
                $timestamp = mktime (0, 0, 0, $mois, $jour, $annee);
                $dateEnglish = $annee."-".$mois."-".$jour;
                // affichage du jour de la semaine
                $jour=date("w",$timestamp);


              if($jour==3) //si mercredi
              {
                  echo '<table cellspacing="0" cellpadding="3px" rules="rows"
       style="border:solid 1px #777777; border-collapse:collapse; font-family:verdana; font-size:11px;">';
                    echo'    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=ValidationPresenceIntervenant"> ';

                  echo "<tr style='background-color:lightgrey;'><th style='width:20px;'></th><th style='width:100px;'> Mercredi ".$dateCircuit."</th></tr>";

                  echo "<input name='date' type='text' hidden='hidden' value='".$dateCircuit."'  />";

                  $recupIntervenants=$pdo->recupIntervenantsSansValider($dateEnglish);
                  if ($recupIntervenants!=array()){
                      foreach($recupIntervenants as $ligne)
                      {
                          echo "<tr><td><input name='intervenant[]' type='checkbox' value='".$ligne['ID_INTERVENANT']."'  /></td><td>".$ligne['NOM']." ".$ligne['PRENOM']."</td></tr>";
                      }
                  }
                  else
                  {
                            echo "<tr><td>Personne à cette date</td></tr>";
                  }
                  echo"<tr><td></td><td><input type='submit' value='Envoyer' /></td>";
                  echo "</table></form>";
              }

               if($jour==6) // si samedi
              {
                   echo '<table cellspacing="0" cellpadding="3px" rules="rows"
       style="border:solid 1px #777777; border-collapse:collapse; font-family:verdana; font-size:11px;">';
          echo'    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=ValidationPresenceIntervenant"> ';

                  echo "<tr style='background-color:lightgrey;'><th style='width:20px;'></th><th style='width:100px;'> Samedi ".$dateCircuit."</th></tr>";
                  echo "<input name='date' type='text' hidden='hidden' value='".$dateCircuit."'  />";

                  $recupIntervenants=$pdo->recupIntervenantsSansValider($dateEnglish);
                  if ($recupIntervenants!=array()){
                      foreach($recupIntervenants as $ligne)
                      {
                          echo "<tr><td><input name='intervenant[]' type='checkbox' value='".$ligne['ID_INTERVENANT']."'  /></td><td>".$ligne['NOM']." ".$ligne['PRENOM']."</td></tr>";
                      }
                  }
                  else
                  {
                            echo "<tr><td>Personne à cette date</td></tr>";
                  }
                                echo"<tr><td></td><td><input type='submit' value='Envoyer' /></td>";

                  echo "</table></form>";
              }

          }
         echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";*/
    ?>
</div>
