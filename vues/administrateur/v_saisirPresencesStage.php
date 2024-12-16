<div id="contenu">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Présences du stage
                </div>
            </div>
        </div>
    </div>
    <form name="frmConsultFrais" method="POST"
          action="index.php?choixTraitement=administrateur&action=ajouterPresencesStage">
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <input type="hidden" name="num" value="<?php echo $stageSelectionner['ID_STAGE']; ?>">
                        <h4 class="card-title">Saisir les présences du stage</h4>
                        <div class="form-group">
                            <label for="num">Date : </label>
                            <input type="date" class="form-control" name="date" value="" autofocus=""
                                   required="required"><br>
                            <label for="num">Matin ou après-midi : </label>
                            <select name="matinouap" class="form-control">
                                <option value="0">Matin</option>
                                <option value="1">Après-midi</option>
                            </select><br>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Classe</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($lesInscriptions as $lInscription) {
                                    $classe = '';
                                    foreach ($lesClasses as $uneClasse) {
                                        if ($uneClasse['ID'] == $lInscription['CLASSE_ELEVE_STAGE']) {
                                            $classe = $uneClasse['NOM'];
                                        }
                                    }

                                    echo '<tr>
		<td><input type="checkbox" name="presences[]" value="' . $lInscription['ID_INSCRIPTIONS'] . '"></td>
		<td>' . stripslashes($lInscription['NOM_ELEVE_STAGE']) . '</td>
		<td>' . stripslashes($lInscription['PRENOM_ELEVE_STAGE']) . '</td>
		<td>' . $classe . '</td>
	</tr>';
                                }
                                ?>
                                </tbody>
                            </table>

                            <input value="Envoyer" type="submit" class="btn btn-success">
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('input[name="presences[]"]').on("click", function () {
            var uneInscriptionStage = $(this);
            if (uneInscriptionStage.prop("checked")) {

                var id = $(this).val();
                var datepresence = $('input[name="date"]').val();
                var matinouap = $('select[name="matinouap"]').val();
                var stage = <?php echo $stageSelectionner['ID_STAGE']; ?>;

                $.ajax({

                    type: "GET",
                    url: "./vues/administrateur/verifpresencestage.php",
                    data: {
                        stage: stage,
                        matinouap: matinouap,
                        id_inscription_stage: id,
                        date_presence: datepresence
                    },
                    error: function () {
                        console.log("error")
                    },
                    success: function (data) {
                        console.log(data); //Try to log the data and check the response
                        if (data == 'true') {
                            alert('Cet élève est déjà présent à cet appel');
                            uneInscriptionStage.prop('checked', false);
                        } else {

                        }
                    }
                });

            }
        });


    });
</script>
