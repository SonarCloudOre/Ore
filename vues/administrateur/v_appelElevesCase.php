<div id="contenu">
	<div class="app-page-title">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div class="page-title-icon">
					<i class="pe-7s-id icon-gradient bg-night-fade"></i>
				</div>
				<div>Présence des élèves</div>
			</div>
			<div class="page-title-actions">
				<div class="d-inline-block dropdown">
					<button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
						<i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
					</button>
					<a href="index.php?choixTraitement=administrateur&action=imprimerFichePresencesScolaire">
						<button type="button" class="btn btn-primary" value="">
							<i class="fa fa-print"></i>
						</button>
					</a>
				</div>
			</div>
		</div>
	</div>

	<form name="frmConsultFrais" method="POST"
		  action="index.php?choixTraitement=administrateur&action=valideAppelElevesCase">
		<fieldset>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<div class="main-card mb-3 card">
							<div class="card-body">
								<h4 class="card-title">Présence des élèves</h4>

								<div class="form-row">
									<div class="col-md-3">
										<label for="dateAppel">Date de l'appel</label>
										<input type="date" class="form-control" name="dateAppel" required=""
											   value="<?= date('Y-m-d') ?>"><br>
									</div>
									<div class="col-md-3">
										<label for="moment">Demi Journée</label><br>

										<div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
											<?php $moment = getMomentJournee(); ?>
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
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="main-card mb-3 card">
						<div class="card-body">
							<h1 class="text-center">Collège</h1>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="main-card mb-3 card">
						<div class="card-body">
							<h1 class="text-center">Lycée</h1>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<?php
				$ct = count($lesClasses);
				$ct /= 2;
				$tab = array_chunk($lesClasses, $ct - 1);
				?>
				<div class="col-md-6">
					<?php foreach ($tab[0] as $uneClasse) { ?>
						<div class="main-card mb-3 card">
							<div class="card-body">
								<h2 class="text-center"><?= $uneClasse['NOM'] ?></h2>

								<table class="table">
									<thead>
										<tr>
											<th style="text-align:center">Présent ?</th>
											<th>Nom</th>
											<th>Prénom</th>
										</tr>
									</thead>
									<tbody>
										<?php
										// On parcours les élèves
										foreach ($lesEleves as $unEleve) {
											// Si il appartient à cette classe
											if ($unEleve['ID_CLASSE'] == $uneClasse['ID']) { ?>
												<tr>
													<td style="text-align:center">
														<input id="<?= $unEleve['ID_ELEVE'] ?>" name="appel[]"
															   type="checkbox" value="<?= $unEleve['ID_ELEVE'] ?>">
													</td>
													<td><?= $unEleve['NOM'] ?></td>
													<td><?= $unEleve['PRENOM'] ?></td>
												</tr>
												<?php
											}
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="col-md-6">
					<?php foreach ($tab[1] as $uneClasse) { ?>
						<div class="main-card mb-3 card">
							<div class="card-body">
								<h2 class="text-center"><?= $uneClasse["NOM"] ?></h2>

								<table class="table">
									<thead>
										<tr>
											<th style="text-align:center">Présent ?</th>
											<th>Nom</th>
											<th>Prénom</th>
										</tr>
									</thead>
									<tbody>
										<?php
										// On parcours les élèves
										foreach ($lesEleves as $unEleve) {
											// Si il appartient à cette classe
											if ($unEleve['ID_CLASSE'] == $uneClasse['ID']) { ?>
												<tr>
													<td style="text-align:center">
														<input type="checkbox" id="<?= $unEleve['ID_ELEVE'] ?>"
															   name="appel[]" value="<?= $unEleve['ID_ELEVE'] ?>">
													</td>
													<td><?= $unEleve['NOM'] ?></td>
													<td><?= $unEleve['PRENOM'] ?></td>
												</tr>
												<?php
											}
										} ?>
									</tbody>
								</table>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</fieldset>

		<p><input value="Soumettre" type="submit" class="btn btn-success"></p>
	</form>
</div>

<script type="text/javascript" src="./vendors/moment/moment.js"></script>
<script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/dist/datepicker.min.js"></script>
<script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/i18n/datepicker.fr-FR.js"></script>

<!-- custome.js -->
<script type="text/javascript" src="./js/form-components/toggle-switch.js"></script>
<script type="text/javascript" src="./js/form-components/datepicker.js"></script>
