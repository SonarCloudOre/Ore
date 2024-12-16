<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Informations manquantes
                </div>
            </div>

            <?php if ($type != '') {
                echo '
  <div class="page-title-actions">
    <div class="d-inline-block dropdown" style="text-align:center;">
      <div class="row">
      <button type="button"  class="mr-2 btn btn-primary" onclick="history.back()">
       <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
      </button>
      <button type="button" class="btn btn-primary" value="" onClick="imprimer2(\'sectionAimprimer2\');">
          <i class="fa fa-print"></i>
      </button>
    </div>
</div>
</div>
';
            } ?>

        </div>
    </div>

    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=InfosManquantes">
        <div class="form-group">


            <div class="col-lg-13">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Informations manquantes</h4>
                        <div class="form-row">
                            <div class="col-md-2">


                                <label for="sexe">Afficher élèves ou intervenants ?</label>
                                <select name="type" class="form-control">
                                    <option value="eleves"<?php if ($type == 'eleves') {
                                        echo ' selected="selected"';
                                    } ?>>Eleves
                                    </option>
                                    <option value="intervenants"<?php if ($type == 'intervenants') {
                                        echo ' selected="selected"';
                                    } ?>>Intervenants
                                    </option>
                                </select><br>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-2">
                                <label for="sexe">Informations manquantes à rechercher</label>
                                <select name="infos" class="form-control" style="max-width : 300px;">
                                    <option value="tout"<?php if ($infos == 'tout') {
                                        echo ' selected="selected"';
                                    } ?>>Tout afficher
                                    </option>
                                    <option value="photos"<?php if ($infos == 'photos') {
                                        echo ' selected="selected"';
                                    } ?>>Photos
                                    </option>
                                    <option value="emails"<?php if ($infos == 'emails') {
                                        echo ' selected="selected"';
                                    } ?>>Emails
                                    </option>
                                    <option value="telephones"<?php if ($infos == 'telephones') {
                                        echo ' selected="selected"';
                                    } ?>>Téléphones
                                    </option>
                                    <option value="adresses"<?php if ($infos == 'adresses') {
                                        echo ' selected="selected"';
                                    } ?>>Adresses postales
                                    </option>
                                    <option value="rdv"<?php if ($infos == 'rdv') {
                                        echo ' selected="selected"';
                                    } ?>>Rendez-vous
                                    </option>
                                </select><br>
                            </div>
                        </div>

                        <input value="Valider" type="submit" class="btn btn-success"><br><br>
                    </div>
                </div>
            </div>

            <?php
            if ($type != '') {

                $i = 0;
                $codeOK = '<span class="lnr-checkmark-circle" style="color:green"></span>';
                $codeKO = '<span class="lnr-cross-circle" style="color:red"></span>';

                if ($type == 'eleves') {
                    echo '<hr>

<div class="col-lg-13">
  <div class="main-card mb-3 card">
    <div class="card-body">
<table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th><center>Nom</center></th>
			<th><center>Prénom</center></th>
			<th><center>Photo</center></th>
			<th><center>Email</center></th>
			<th><center>Téléphone<br>parents 1</center></th>
			<th><center>Téléphone<br>parents 2</center></th>
			<th><center>Téléphone<br>parents 3</center></th>
			<th><center>Adresse postale</center></th>
            <th style="width:300px"><center>Rendez-vous</center></th>
		</tr>
	</thead>
	<tbody>
    </div></div></div>';
                }

                if ($type == 'intervenants') {
                    echo '<hr>
<div class="col-lg-13">
  <div class="main-card mb-3 card">
    <div class="card-body">
<table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th><center>Nom</center></th>
			<th><center>Prénom</center></th>
			<th><center>Photo</center></th>
			<th><center>Email</center></th>
			<th><center>Téléphone</center></th>
			<th><center>Adresse postale</center></th>
		</tr>
	</thead>
	<tbody>
    </div></div></div>';
                }

                if ($type == 'eleves') {

                    foreach ($lesEleves as $unEleve) {

                        if ($unEleve['EMAIL_DES_PARENTS'] == 'a@a') {
                            $unEleve['EMAIL_DES_PARENTS'] = '';
                        }
                        if ($unEleve['EMAIL_DES_PARENTS'] == 'a@a.fr') {
                            $unEleve['EMAIL_DES_PARENTS'] = '';
                        }
                        if ($unEleve['TÉLÉPHONE_DES_PARENTS'] == '0') {
                            $unEleve['TÉLÉPHONE_DES_PARENTS'] = '';
                        }
                        if ($unEleve['TÉLÉPHONE_DES_PARENTS'] == '-') {
                            $unEleve['TÉLÉPHONE_DES_PARENTS'] = '';
                        }
                        if ($unEleve['TÉLÉPHONE_DES_PARENTS'] == ' ') {
                            $unEleve['TÉLÉPHONE_DES_PARENTS'] = '';
                        }
                        if ($unEleve['ADRESSE_POSTALE'] == '-') {
                            $unEleve['ADRESSE_POSTALE'] = '';
                        }
                        if ($unEleve['ADRESSE_POSTALE'] == ' ') {
                            $unEleve['ADRESSE_POSTALE'] = '';
                        }
                        if ($unEleve['PHOTO'] == 'AUCUNE.jpg') {
                            $unEleve['PHOTO'] = '';
                        }

                        // RDV
                        $rdvEleve = false;
                        $dateRdv = '';
                        foreach ($lesRendezvous as $unRdv) {

                            // Si le rdv correspond à l'élève
                            if ($unRdv['ID_ELEVE'] == $unEleve['ID_ELEVE']) {
                                $rdvEleve = true;
                                $dateRdv = $unRdv['DATE_RDV'];
                            }
                        }

                        // Tri
                        if ($infos == 'photos') {
                            if ($unEleve['PHOTO'] != '') {
                                continue;
                            }
                        }
                        if ($infos == 'emails') {
                            if ($unEleve['EMAIL_DES_PARENTS'] != '') {
                                continue;
                            }
                        }
                        if ($infos == 'telephones') {
                            if ($unEleve['TÉLÉPHONE_DES_PARENTS'] != '') {
                                continue;
                            }
                        }
                        if ($infos == 'adresses') {
                            if ($unEleve['ADRESSE_POSTALE'] != '') {
                                continue;
                            }
                        }
                        if ($infos == 'rdv') {
                            if ($rdvEleve) {
                                continue;
                            }
                        }


                        echo '<tr>
				<td><center><a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $unEleve['ID_ELEVE'] . '">' . $unEleve['NOM'] . '</a></center></td>
				<td><center><a href="index.php?choixTraitement=administrateur&action=LesEleves&unEleve=' . $unEleve['ID_ELEVE'] . '">' . $unEleve['PRENOM'] . '</a></center></td>
				<td><center>';
                        if ($unEleve['PHOTO'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
				<td><center>';
                        if ($unEleve['EMAIL_DES_PARENTS'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
				<td><center>';
                        if ($unEleve['TÉLÉPHONE_DES_PARENTS'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
				<td><center>';
                        if ($unEleve['TÉLÉPHONE_DES_PARENTS2'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
				<td><center>';
                        if ($unEleve['TÉLÉPHONE_DES_PARENTS3'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
				<td><center>';
                        if ($unEleve['ADRESSE_POSTALE'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
                <td><center>';
                        if ($rdvEleve == false) {
                            echo $codeKO;
                        } else {
                            echo dateAnglaisVersFrancaisHMS($dateRdv);
                        }
                        echo '</center></td>
			</tr>';
                        $i++;

                    }

                }


                if ($type == 'intervenants') {

                    foreach ($TousIntervenant as $unIntervenant) {


                        if ($unIntervenant['EMAIL'] == 'a@a') {
                            $unIntervenant['EMAIL'] = '';
                        }
                        if ($unIntervenant['EMAIL'] == 'a@a.fr') {
                            $unIntervenant['EMAIL'] = '';
                        }
                        if ($unIntervenant['TELEPHONE'] == '0') {
                            $unIntervenant['TELEPHONE'] = '';
                        }
                        if ($unIntervenant['TELEPHONE'] == '-') {
                            $unIntervenant['TELEPHONE'] = '';
                        }
                        if ($unIntervenant['TELEPHONE'] == ' ') {
                            $unIntervenant['TELEPHONE'] = '';
                        }
                        if ($unIntervenant['ADRESSE_POSTALE'] == '-') {
                            $unIntervenant['ADRESSE_POSTALE'] = '';
                        }
                        if ($unIntervenant['ADRESSE_POSTALE'] == ' ') {
                            $unIntervenant['ADRESSE_POSTALE'] = '';
                        }
                        if ($unIntervenant['PHOTO'] == 'AUCUNE.jpg') {
                            $unIntervenant['PHOTO'] = '';
                        }

                        // Tri
                        if ($infos == 'photos') {
                            if ($unIntervenant['PHOTO'] != '') {
                                continue;
                            }
                        }
                        if ($infos == 'emails') {
                            if ($unIntervenant['EMAIL'] != '') {
                                continue;
                            }
                        }
                        if ($infos == 'telephones') {
                            if ($unIntervenant['TELEPHONE'] != '') {
                                continue;
                            }
                        }
                        if ($infos == 'adresses') {
                            if ($unIntervenant['ADRESSE_POSTALE'] != '') {
                                continue;
                            }
                        }


                        echo '<tr>
				<td><center><a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant['ID_INTERVENANT'] . '">' . $unIntervenant['NOM'] . '</a></center></td>
				<td><center><a href="index.php?choixTraitement=administrateur&action=LesIntervenants&unIntervenant=' . $unIntervenant['ID_INTERVENANT'] . '">' . $unIntervenant['PRENOM'] . '</a></center></td>
				<td><center>';
                        if ($unIntervenant['PHOTO'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
				<td><center>';
                        if ($unIntervenant['EMAIL'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
				<td><center>';
                        if ($unIntervenant['TELEPHONE'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
				<td><center>';
                        if ($unIntervenant['ADRESSE_POSTALE'] == '') {
                            echo $codeKO;
                        } else {
                            echo $codeOK;
                        }
                        echo '</center></td>
			</tr>';
                        $i++;

                    }

                }

                echo '
	</tbody></table><p><b>' . $i . ' résultat(s)</b></p>';
            }
            ?>


        </div>
    </form>
</div>
