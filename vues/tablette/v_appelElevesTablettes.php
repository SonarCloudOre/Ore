<div id="contenu">
	<form name="frmConsultFrais" method="POST"
		  action="index.php?choixTraitement=tablette&action=ValidAppelEleves">
		<fieldset>
			<div class="row" id="ae-main">
				<div class="col-lg-12">
					<div class="main-card mb-3 card">
						<div class="card-body">
							<h4 class="card-title">Nom et prénom</h4>

							<select id="student" name="unEleve" class="multiselect-dropdown form-control"
									data-live-search="true">
								<option disabled="disabled" selected="selected">Choisir</option>
								<?php foreach ($lesEleves as $unEleve) { ?>
								
								<? 					 
								        $lesClasses = $pdo->getParametre(4);

									foreach ($lesClasses as $uneLigne) {
										if ($unEleve['ID_CLASSE'] == $uneLigne['ID']) {
											$unEleve['CLASSE'] = $uneLigne['NOM'];
										} 
									}
								?>
		
		
                                    <option value="<?= $unEleve['ID_ELEVE'] ?>" name="unEleve">
                                        <?= $unEleve['NOM'] ?> <?= $unEleve['PRENOM']?>  <?= $unEleve['CLASSE']?>
                                    </option>
                                <?php } ?>
							</select>

							<div class="d-none" id="student-details">
								<h4 class="card-title mt-3">Photo de l'élève</h4>
								
								 
		
								<div class="text-center">
                                    <img id="student-photo" alt="L'élève n'a pas de photo"
                                         src="https://association-ore.fr/extranet/photosEleves/AUCUN.jpg"><br>
                                    <span class="font-italic" id="student-no-photo">L'élève n'a pas de photo<br></span>
                                </div>
                                <div class="btn-group mt-2 w-100">
									<a href="index.php?choixTraitement=tablette&action=prendrePhotoEleve"
									   class="btn btn-outline-primary" id="student-add-photo"></a>
                                    <a href="#" class="btn btn-outline-primary" id="student-card">
                                        <i class="far fa-address-card"></i> Carte ORE
                                    </a>
								</div>
							</div>

							<input value="Faire l'appel" type="submit" class="mt-2 btn btn-lg btn-success w-100" id="submit">
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</form>
</div>

<script type="text/javascript" src="./vendors/select2/dist/js/select2.min.js"></script>

<!-- custome.js -->
<script type="text/javascript" src="./vues/tablette/tablette.js"></script>
<script type="text/javascript" src="./vues/tablette/selectAutoOpen.js"></script>

<script>
	const showStudent = student => {
        $('#student-details').removeClass('d-none');

		const photoImg = $('#student-photo');
		const noPhoto = $('#student-no-photo');
		const editPhoto = $('#student-add-photo');

        const picture = student.querySelector('PHOTO');
        const studentId = student.querySelector('ID_ELEVE').textContent;
        $('#student-card').attr('data-student-id', studentId);

        const params = new URLSearchParams(window.location.search);
        params.set('action', 'prendrePhotoEleve');
        params.set('id', studentId);

		if (picture !== null && picture.textContent !== '') {
            const nom = student.querySelector('NOM').textContent;
            const prenom = student.querySelector('PRENOM').textContent;

			noPhoto.addClass('d-none');
			photoImg.removeClass('d-none');
			photoImg.attr('src', `https://association-ore.fr/extranet/photosEleves/${picture.textContent}`);
			photoImg.attr('alt', `Photo de ${nom} ${prenom}`);

            params.set('type', 'edit');
            editPhoto.attr('href', `index.php?${params}`);
            editPhoto.html('<i class="fa fa-pen"></i> Modifier la photo');
		} else {
			photoImg.addClass('d-none');
			noPhoto.removeClass('d-none');

            params.set('type', 'add');
			editPhoto.attr('href', `index.php?${params}`);
            editPhoto.html('<i class="fa fa-plus"></i> Ajouter une photo');
		}
	};

    $('#student-card').click(function() {
        const {origin, pathname} = document.location;
        const studentId = $(this).attr('data-student-id');

        const iframe = document.createElement('iframe');
        iframe.style.maxHeight = '10px';
        iframe.style.maxWidth = '10px';
        iframe.src = `${origin}${pathname}?choixTraitement=administrateur&action=macarte&eleve=${studentId}&print=true`;
        $('#ae-main').append(iframe);
    });

    $(document).ready(() => {
        const studentsHere = <?= json_encode($presents) ?>;

        const student = $('#student');
        student.on('change', async () => {
            const selected = $('#student option:selected').get(0);
            if (studentsHere.includes(selected.value))
                $('#submit').attr('disabled', true).addClass('disabled');
            else
                $('#submit').attr('disabled', false).removeClass('disabled');

            const response = await fetch(`index.php?choixTraitement=administrateur&action=ajax_unEleve&id=${selected.value}`);
            if (response.ok) {
                const xml = await response.text();
                const parser = new DOMParser();

                let student = parser.parseFromString(xml, 'application/xml');
                showStudent(student.querySelector('eleve'));
			}
        });
    });
</script>
