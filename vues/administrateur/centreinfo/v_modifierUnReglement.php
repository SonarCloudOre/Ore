<div id="contenu">

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-night-fade"></i>
                </div>
                <div>
                    Modifier un réglement
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


    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form method="POST"
                          action="index.php?choixTraitement=administrateur&action=info_modifierUnReglementValidation">
                        <h4 class="card-title">Modifier un réglement</h4>

                        <div class="form-group">


                            <input type="hidden" name="unReglement"
                                   value="<?php echo $leReglement[0]['id_reglement']; ?>" readonly="readonly">
                            <label for="uneInscription">Inscription</label><br>
                            <select name="uneInscription" class="form-control" data-live-search="true">
                                <option disabled="disabled" selected="selected">Choisir</option>
                                <?php foreach ($lesInscriptions as $uneInscription) {
                                    if (isset($inscriptionSelectionner) and $uneInscription['id_inscription'] == $inscriptionSelectionner) {
                                        $selectionner = "selected='selected'";
                                    } else {
                                        $selectionner = "";
                                    }

                                    echo " <option " . $selectionner . " value='" . $uneInscription['id_inscription'] . "'>" . stripslashes($uneInscription['nom_inscription'] . ' ' . $uneInscription['prenom_inscription']) . "</option>";
                                } ?>
                            </select><br>

                            <label for="type">Type de réglement</label><br>
                            <select id="type" name="type" class="form-control" data-live-search="true">
                                <option disabled="disabled" selected="selected">Choisir</option>
                                <?php foreach ($lesTypesReglements as $leTypedeReglement) {
                                    if (isset($leReglement) and $leReglement[0]["type_reglement"] == $leTypedeReglement['ID']) {
                                        $selectionner = "selected='selected'";
                                    } else {
                                        $selectionner = "";
                                    }
                                    echo " <option " . $selectionner . " value='" . $leTypedeReglement['ID'] . "'>" . stripslashes($leTypedeReglement['NOM']) . "</option>";
                                } ?>
                            </select><br>


                            <label for="date">Date du réglement</label><br>
                            <input class="form-control" type="date" name="date"
                                   value="<?php echo $leReglement[0]["date_reglement"] ?>"
                                   placeholder="dd-mm-yyyy"></br>

                            <div id="cheque">
                                <label for="num_transaction">N° de Transaction</label>
                                <input class="form-control" type="number" name="num_transaction"
                                       value="<?php echo $leReglement[0]['num_transaction_reglement']; ?>"><br>
                            </div>

                            <div id="banque">
                                <label for="banque">Banque (seulement si chèque) </label>
                                <select class="form-control" name="banque">
                                    <option disabled="disabled" selected="selected">Choisir</option>
                                    <?php foreach ($lesBanques as $uneBanque) {
                                        if (isset($leReglement) and $leReglement[0]["banque_reglement"] == $uneBanque['NOM']) {
                                            $selectionner = "selected='selected'";
                                        } else {
                                            $selectionner = "";
                                        }
                                        echo " <option " . $selectionner . " value='" . $uneBanque['NOM'] . "'>" . stripslashes($uneBanque['NOM']) . "</option>";
                                    } ?>
                                </select><br>
                            </div>

                            <label for="montant">Montant</label>
                            <input class="form-control" type="number" name="montant"
                                   value="<?php echo $leReglement[0]['montant_reglement']; ?>" required="required"><br>

                            <input value="Modifier" type="submit" class="btn btn-success">

                    </form>
                </div>
            </div>
        </div>
    </div>
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