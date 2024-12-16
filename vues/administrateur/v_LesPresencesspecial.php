<div id="contenu">
    <h2>Présence des intervenants et élèves</h2>
    <br><br>


    

        <?php
  


    $nbseance=0;
  		foreach($annee20182019 as $uneseance)
		{		
				$nbseance++;
				echo '<tr> <td> '.$uneseance['seance'].'</td>
				<td>';
                if($admin==2) { echo '<button class="btn" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette présence ?\')) { document.location.href =\'index.php?choixTraitement=administrateur&action=suppPresencesUneSeance&type=UnePresence&num=' . $uneLigne['ID'] . '&date='.$laDate.'\'; }"><span class="glyphicon glyphicon-trash"></span> Supprimer</button>'; }
                         
                echo '</td>
				</tr>';
		}
  		
		echo" <tr style='background-color:lightgrey;'><th style='width:300px;' colspan=2> Total d'intervenant :  ".$total." </th></tr> </thead></table>";
  
  
  ?>


        <table cellspacing="0" cellpadding="3px" rules="rows" class="table" style='width:400px;'>
            <thead>
            <tr style='background-color:lightgrey;'>
                <th style='width:300px;font-size:14px' colspan=2> Elèves</th>
            </tr>
            </thead>
            <tbody>
            <?php
  		
  		$total =0;
  		foreach($tableauEleves as $uneLigne)
		{		
				$total++;
				echo '<tr> <td style="width:300px;"> '.$uneLigne['NOM'].' '.$uneLigne['PRENOM'].'</td>
				<td>';
                if($admin==2) { echo '<button class="btn" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette présence ?\')) { document.location.href =\'index.php?choixTraitement=administrateur&action=suppPresencesUneSeance&type=UnePresence&num=' . $uneLigne['ID'] . '&date='.$laDate.'\'; }"><span class="glyphicon glyphicon-trash"></span> Supprimer</button>'; }
            echo '</td>
			</tr>';
		}
  		
		echo" <tr style='background-color:lightgrey;'><th style='width:300px; font-size:14px' colspan=2> Total d'élèves :  ".$total." </th></tr> </tbody></table>";
  
  
  
  ?>


</div>