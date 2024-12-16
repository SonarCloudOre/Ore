<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Présences des intervenants et des élèves
                    <?php
                    $dateCircuit = date('d-m-Y', strtotime('+0 day'));
                    if ($laDate !== ''): ?>
						<div class="page-title-subheading">
							Présence des élèves et intervenants le <?= date('d/m/Y', strtotime($laDate)) ?>
						</div>
                    <?php else: ?>
                        <div class="page-title-subheading">Veuillez saisir une date ci-dessous</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($laDate !== ''): ?>
				<div class="page-title-actions">
					<div class="d-inline-block dropdown">
						<button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
							<i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
						</button>
						<button type="button" class="btn btn-primary" value="" onClick="imprimer2(\'sectionAimprimer2\');">
							<i class="fa fa-print"></i>
						</button>
					</div>
				</div>
            <?php endif; ?>
        </div>
    </div>

    <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=LesPresencesAUneDate">
        <?php $dateCircuit = date('Y-m-d'); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h4 class="card-title">Présences des intervenants/élèves</h4>
							
							<input type="radio" name="presences" id="datePrecise" value="datePrecise"/>

							<label for="datePrecise">
								<div class="form-row">
									<div class="col-md-5">
										<label for="laDate">Date de l'appel</label><br>
										<input type="date" class="form-control" name="laDate"
											value="<?= ($laDate !== "") ? $laDate : $dateCircuit ?>">
									</div>

									<div class="col-md-7">
										<label for="moment">Demi Journée</label><br>
										<div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
											<?php $active = [' active', ' checked']; ?>
											<?php $selected = $moment === 1 ? $active : ['', '']; ?>
											<label class="btn btn-outline-secondary<?= $selected[0] ?>">
												<input type="radio" name="moment" id="am" autocomplete="off" value="1"<?= $selected[1] ?>>
												Matin
											</label>
											<?php $selected = $moment === 2 ? $active : ['', '']; ?>
											<label class="btn btn-outline-secondary<?= $selected[0] ?>">
												<input type="radio" name="moment" id="pm" autocomplete="off" value="2"<?= $selected[1] ?>>
												Après-Midi
											</label>
										</div>
									</div>
								</div>
							</label><br>

							
							<input type="radio" name="presences" id="plusieursJoursMois" value="plusieursJoursMois"/>

							<label for="plusieursJoursMois">
								<div class="form-row">
									<div class="col-md">
										<label for="laDate">Tous les...</label><br>
										<div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
											<?php $active = [' active', ' checked']; ?>
											<?php $selected = $jourSemaine === 4 ? $active : ['', '']; ?>
											<label class="btn btn-outline-secondary<?= $selected[0] ?>">
												<input type="radio" name="jourSemaine" id="jourSemaine" autocomplete="off" value="4"<?= $selected[1] ?>>
												Mercredis
											</label>
											<?php $selected = $jourSemaine === 7 ? $active : ['', '']; ?>
											<label class="btn btn-outline-secondary<?= $selected[0] ?>">
												<input type="radio" name="jourSemaine" id="jourSemaine" autocomplete="off" value="7"<?= $selected[1] ?>>
												Samedis
											</label>
										</div>
									</div>

									<div class="col-md">
										<label for="laDate">De...</label><br>
										<select name="mois" class="multiselect-dropdown form-control"
											data-live-search="true">
											<option value="9">Septembre <?php echo $anneeExtranet ?></option>
											<option value="10">Octobre <?php echo $anneeExtranet ?></option>
											<option value="11">Novembre <?php echo $anneeExtranet ?></option>
											<option value="12">Décembre <?php echo $anneeExtranet ?></option>
											<option value="1">Janvier <?php echo $anneeExtranet +1 ?></option>
											<option value="2">Février <?php echo $anneeExtranet +1 ?></option>
											<option value="3">Mars <?php echo $anneeExtranet +1 ?></option>
											<option value="4">Avril <?php echo $anneeExtranet +1 ?></option>
											<option value="5">Mai <?php echo $anneeExtranet +1 ?></option>
											<option value="6">Juin <?php echo $anneeExtranet +1 ?></option>
											<option value="7">Juillet <?php echo $anneeExtranet +1 ?></option>
											<option value="8">Août <?php echo $anneeExtranet +1 ?></option>
										</select>
									</div>
								</div>
							</label><br>

							
							<input type="radio" name="presences" id="stages" value="stages"/>

							<label for="stages">
								<div class="form-row">
									<div class="col-md">
										<label for="laDate">Stages</label><br>
										<select name="unStage" class="multiselect-dropdown form-control"
											data-live-search="true">
											<option disabled selected value="">Choisir</option>
											<?php 
												foreach ($lesStages as $unStage) {
												if (isset($stageSelectionner) and $unStage['ID_STAGE'] == $stageSelectionner['ID_STAGE']) {
													$selectionner = "selected='selected'";
												} else {
													$selectionner = "";
												}

												echo " <option " . $selectionner . " value='" . $unStage['ID_STAGE'] . "' name='unStage'>" . stripslashes($unStage['NOM_STAGE']) . "</option>";
											} ?>
										</select>
									</div>
								</div>
							</label>
							

                            <input name="Soumettre" value="Soumettre" type="submit" class="form-control btn btn-success mt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php if ($laDate !== ''): ?>
		<div class="row">
			<div class="col-lg-6">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<table cellspacing="0" cellpadding="3px" rules="rows" class="table" style='width:400px;'>
							<?php if ($admin == 2) { ?>
								<a href="#"
								   onclick="if(confirm('Voulez-vous vraiment supprimer cette présence ?')) { document.location.href ='index.php?choixTraitement=administrateur&action=suppPresencesUneSeance&type=intervenants&date=<?= $laDate ?>&moment=<?= $moment ?>'; }"
								   class="btn btn-danger mb-3">
										<span class="glyphicon glyphicon-trash"></span> Supprimer les présences des intervenants
								</a>
							<?php } ?>
							<thead>
								<tr style='background-color:lightgrey;'>
									<th colspan=2>Intervenants</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$total = 0;
								if (isset($tableauIntervenant))
								{
									foreach ($tableauIntervenant as $uneLigne) {
										$total++;
										echo '<tr><td style="width:300px;">' . $uneLigne['NOM'] . ' ' . $uneLigne['PRENOM'] . '</td><td>';
										if ($admin == 2) {
											echo '<button class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette présence ?\')) { document.location.href =\'index.php?choixTraitement=administrateur&action=suppPresencesUneSeance&type=UnePresence&num=' . $uneLigne['ID'] . '&date=' . $laDate . '\'; }"><span class="pe-7s-trash"></span></button>';
										}
										echo '</td></tr>';
									}
									echo "<tr style='background-color:lightgrey;'><th style='width:300px;' colspan=2>Total d'intervenant : " . $total . "</th></tr>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="main-card mb-3 card">
					<div class="card-body">
						<table cellspacing="0" cellpadding="3px" rules="rows" class="table" style='width:400px;'>
							<?php if ($admin == 2) { ?>
								<a href="#"
								   onclick="if(confirm('Voulez-vous vraiment supprimer cette présence ?')) { document.location.href ='index.php?choixTraitement=administrateur&action=suppPresencesUneSeance&type=eleves&date=<?= $laDate ?>&moment=<?= $moment ?>'; }"
								   class="btn btn-danger mb-3">
									<span class="glyphicon glyphicon-trash"></span>Supprimer les présences des élèves
								</a>
							<?php } ?>
							<thead>
							<tr style='background-color:lightgrey;'>
								<th style='width:300px;font-size:14px' colspan=2> Elèves</th>
							</tr>
							</thead>
							<tbody>
								<?php
								$total = 0;
								if (isset($tableauEleves))
								{
									foreach ($tableauEleves as $uneLigne) {
										$total++;
										echo '<tr> <td style="width:300px;">' . $uneLigne['NOM'] . ' ' . $uneLigne['PRENOM'] . '</td><td>';
										if ($admin == 2) {
											echo '<button class="btn btn-danger" onclick="if(confirm(\'Voulez-vous vraiment supprimer cette présence ?\')) { document.location.href =\'index.php?choixTraitement=administrateur&action=suppPresencesUneSeance&type=UnePresence&num=' . $uneLigne['ID'] . '&date=' . $laDate . '\'; }"><span class="pe-7s-trash"></span></button>';
										}
										echo '</td></tr>';
									}
									echo "<tr style='background-color:lightgrey;'><th style='width:300px; font-size:14px' colspan=2>Total d'élèves : " . $total . "</th></tr>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>

<script type="text/javascript" src="./js/LesPresencesDuneDate.js"></script>
