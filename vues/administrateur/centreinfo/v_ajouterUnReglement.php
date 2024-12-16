<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Ajouter un réglement
                <?php

                if (isset($uneInscription)) {
                    echo '<div class="page-title-subheading">Ajout d\'un réglement pour ' . $inscriptionSelectionner['prenom_inscription'] . ' ' . $inscriptionSelectionner['nom_inscription'] . '</div>';
                }
                ?>
            </div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                    <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="contenu">
    <form method="POST" action="index.php?choixTraitement=administrateur&action=info_ajouterUnReglementValidation">
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="card-title">Ajouter un réglement</h4>

                        <div class="form-group">

                            <label for="uneActivite">Activité</label><br>
                            <input class="form-control"
                                   value="<?php echo stripslashes($activiteSelectionner['nom_activite']); ?>"
                                   readonly="readonly"><br>
                            <input type="hidden" name="uneActivite"
                                   value="<?php echo $activiteSelectionner['id_activite']; ?>" readonly="readonly">

                            <label for="uneInscription">Inscription</label><br>
                            <select name="uneInscription" class="form-control" data-live-search="true">
                                <option disabled="disabled" selected="selected">Choisir</option>
                                <?php foreach ($lesInscriptions as $uneInscription) {
                                    if (isset($inscriptionSelectionner) and $uneInscription['id_inscription'] == $inscriptionSelectionner['id_inscription']) {
                                        $selectionner = "selected='selected'";
                                    } else {
                                        $selectionner = "";
                                    }

                                    echo " <option " . $selectionner . " value='" . $uneInscription['id_inscription'] . "'>" . stripslashes($uneInscription['nom_inscription'] . ' ' . $uneInscription['prenom_inscription']) . "</option>";
                                } ?>
                            </select><br>

                            <label for="type" class="required">Type de règlement :</label>
                            <select id="type" class="form-control" name="type" required>
                                <option disabled selected>Choisir</option>
                                <?php
                                foreach ($lesTypesReglements as $valeur) {
                                    echo '<option id="' . $valeur['NOM'] . '" value="' . $valeur['ID'] . '">' . $valeur['NOM'] . '</option>';
                                }
                                ?>
                            </select>
                            <br>

                            <label for="date">Date du réglement</label><br>
                            <?php formulaireDate(0, 0, 0, "date"); ?><br>


                            <div id="cheque">
                                <label for="num_transaction" class="required">N° de transaction : </label>
                                <input class="form-control" name="num_transaction"
                                       placeholder="N° de transaction" value=""
                                       autofocus="" required><br>
                            </div>

                            <div id="banque">
                                <label for="banque" class="required">Banque (seulement si
                                    chèque) </label>
                                <select class="form-control" name="banque">
                                    <option disabled="disabled"
                                            selected="selected" required>Choisir
                                    </option>
                                    <?php
                                    foreach ($lesBanques as $uneLigne) {
                                        echo '<option id="' . $uneLigne['NOM'] . '" value="' . $uneLigne['NOM'] . '" name="' . $uneLigne['NOM'] . '">' . $uneLigne['NOM'] . '</option>';
                                    }
                                    ?>
                                </select><br>
                            </div>

                            <label for="montant">Montant</label>
                            <input class="form-control" type="number" name="montant" value="" required="required"><br>

                            <input value="Ajouter" type="submit" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>

<script type="text/javascript">
    $(function () {
        //initially hide the textbox
        if ($("#type").find('option:selected').val() != 1 && $("#type").find('option:selected').val() != 151) {
            $("#cheque").hide();
            $("input[name=num_transaction]").val("");
            $("input[name=num_transaction]").prop('required', false);
            $("#banque").hide();
            $("input[name=banque]").val("");
            $("input[name=banque]").prop('required', false);
        } else if ($("#type").find('option:selected').val() == 151) {
            $("#banque").hide();
            $("input[name=banque]").val("");
            $("input[name=banque]").prop('required', false);
        }

        $('#type').change(function () {
            if ($(this).find('option:selected').val() == 1) {
                $("#cheque").show();
                $("input[name=num_transaction]").prop('required', true);
                $("#banque").show();
                $("input[name=banque]").prop('required', true);
            } else if ($(this).find('option:selected').val() == 151) {
                $("#cheque").show();
                $("input[name=num_transaction]").prop('required', true);
                $("#banque").hide();
                $("input[name=banque]").val("");
                $("input[name=banque]").prop('required', false);
            } else {
                console.log("nice")
                $("#cheque").hide();
                $("input[name=num_transaction]").val("");
                $("input[name=num_transaction]").prop('required', false);
                $("#banque").hide();
                $("input[name=banque]").val("");
                $("input[name=banque]").prop('required', false);
            }
        });
        $("#cheque").keyup(function (ev) {
            var othersOption = $('#type').find('option:selected');
            if (othersOption.val() == 1 || othersOption.val() == 151) {
                ev.preventDefault();
                //change the selected drop down text
                $(othersOption).html($("#type").val());
            }
        });
        $("#type").change(function () {
            if ($("#type").val() == 83) {
                $("input[name=montant]").val("0");
                $("input[name=montant]").prop('readonly', true);
            } else {
                $("input[name=montant]").prop('readonly', false);
                calculMontant();
            }
        });
    });
</script>