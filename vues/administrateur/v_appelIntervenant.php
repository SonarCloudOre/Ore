<div id="contenu">
	<div class="app-page-title">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div class="page-title-icon">
					<i class="pe-7s-id icon-gradient bg-night-fade"></i>
				</div>
				<div>Présence des intervenants</div>
			</div>
			<div class="page-title-actions">
				<div class="d-inline-block dropdown">
					<button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
						<i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
					</button>
					<a href="index.php?choixTraitement=administrateur&action=FichePresenceIntervenants">
						<button type="button" class="btn btn-primary" value="">
							<i class="fa fa-print"></i>
						</button>
					</a>
				</div>
			</div>
		</div>
	</div>

	<form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=appelIntervenant">
		<?php $dateCircuit = date('Y-m-d'); ?>
		<?php $laDate = ($laDate !== "") ? $laDate : $dateCircuit ?>
		<fieldset>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<div class="main-card mb-3 card">
							<div class="card-body">
								<h4 class="card-title">Présence des intervenants</h4>
								<div class="form-row">
									<div class="col-md-3">
										<label for="dateAppel">Date de l'appel</label>
										<input type="date" class="form-control" name="dateAppel" required=""
											   value="<?= $laDate ?>"><br>
									</div>
									<div class="col-md-3">
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</form>

	<form name="frmConsultFrais" method="POST"
		  action="index.php?choixTraitement=administrateur&action=valideAppelIntervenants&laDate=<?= $laDate ?>&moment=<?= $moment ?>">
		<fieldset>
			<div class="row">
				<div class="col-lg-12">
					<div class="main-card mb-3 card">
						<div class="card-body">
							<h4 class="card-title">Présence</h4>

							<table class="mb-0 table">
								<thead>
									<tr>
										<th style="text-align:center">Présent ?</th>
										<th>Nom</th>
										<th>Prénom</th>
										<th>Nombre d'heures</th>
									</tr>
								</thead>
								<tbody>
									<script type="text/javascript">
										function afficheHoraire(id) {
											const checkbox = document.getElementById(id);
											$('#heure' + id).val(checkbox.checked ? '3' : '');
										}
									</script>

									<?php foreach ($lesIntervenants as $uneLigne): ?>
										<?php $checked = array_key_exists($uneLigne['ID_INTERVENANT'], $presents); ?>
										<?php $hours = $checked ? $presents[$uneLigne['ID_INTERVENANT']] : null; ?>
										<tr>
											<td style="text-align:center">
												<input id='<?= $uneLigne['ID_INTERVENANT'] ?>'<?= !$checked ? ' name="appel[]"' : '' ?>
													   value='<?= $uneLigne['ID_INTERVENANT'] ?>' onclick='afficheHoraire(this.id)'
													   type='checkbox'<?= $checked ? ' checked disabled' : '' ?>>
											</td>
											<td><label for="<?= $uneLigne['ID_INTERVENANT'] ?>"><?= $uneLigne['NOM'] ?></label></td>
											<td><label for="<?= $uneLigne['ID_INTERVENANT'] ?>"><?= $uneLigne['PRENOM'] ?></label></td>
											<td>
												<input type="number"<?= !$checked ? ' name="heure' . $uneLigne['ID_INTERVENANT'] . '"' : '' ?>
													   id="heure<?= $uneLigne['ID_INTERVENANT'] ?>" class="form-control" min="1" max="3"
													   style="width:70px"<?= $checked ? ' value="' . $hours . '" disabled' : '' ?>>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<br/>
							<input value="Soumettre" type="submit" class="btn btn-success">
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</form>
</div>

<script type="text/javascript" src="./vendors/moment/moment.js"></script>
<script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/dist/datepicker.min.js"></script>
<script type="text/javascript" src="./vendors/@chenfengyuan/datepicker/i18n/datepicker.fr-FR.js"></script>

<!-- custome.js -->
<script type="text/javascript" src="./js/form-components/toggle-switch.js"></script>
<script type="text/javascript" src="./js/form-components/datepicker.js"></script>

<script>
    $(document).ready(() => {
        $('#am').on('click', function () { this.form.submit(); });
        $('#pm').on('click', function () { this.form.submit(); });
    });
</script>
