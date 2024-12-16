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
                <h4 class="card-title">Modifier un réglement</h4>
                <form name="frmConsultFrais" method="POST" enctype="multipart/form-data"
                      action="index.php?choixTraitement=administrateur&action=modifierReglementStageValidation">
                    <input type="hidden" name="id_stage" value="<?php echo $numStage; ?>">
                    <input class="form-control" type="hidden" name="id_inscription"
                           value="<?php echo $leReglement['ID_INSCRIPTIONS']; ?>">

                    <div class="form-group">

                        <div class="form-group" style="background-color: #ccbcbc; padding: 10px; border-radius: 10px;">
                            <h5 style="font-weight: bold; color: #333;">Choix fratries </h5>
                            <label for="select-payement-eleves">Ajouter des frères ou soeurs au réglement :</label>
                            <select id="select-payement-eleves" class="multiselect-dropdown form-control" data-live-search="true">
                                <?php
                                if (count($lesFratries) > 0) {
                                    echo '<option value="-1" disabled="disabled" selected="selected">Choisir</option>';
                                    foreach ($lesFratries as $uneFratrie) {
                                        echo '<option value="' . $uneFratrie['ID_INSCRIPTIONS'] . '">' . $uneFratrie['NOM_ELEVE_STAGE']. ' ' . $uneFratrie['PRENOM_ELEVE_STAGE'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="-1" disabled="disabled" selected="selected">Il n\'y a pas de frere inscrit</option>';
                                }
                                ?>
                            </select>
                            <button type="button" class="btn btn-primary mt-2" id="button-add-fratrie">Ajouter à la liste</button>

                            <input type="hidden" name="eleve" value="<?=$num?>">
                            <input type="hidden" name="selectedEleves" id="selected-eleves" value="" required>
                            <div class="list-group mt-3" id="list-payement-eleves">
                                <a class="list-group-item disabled" data-name="<?=$uneInscription['ID_INSCRIPTIONS']?>"><?php echo $uneInscription['NOM_ELEVE_STAGE']. ' ' . $uneInscription['PRENOM_ELEVE_STAGE']; ?></a>
                                <?php
                                    foreach ($lesFratriesReglement as $uneFratrie) {
                                        echo '<a class="list-group-item" data-name="' . $uneFratrie['ID_INSCRIPTIONS'] . '">' . $uneFratrie['NOM_ELEVE_STAGE'] . ' ' . $uneFratrie['PRENOM_ELEVE_STAGE'] . '<i class="btn btn-danger btn-sm ml-2 float-right"><i class="fa fa-trash"></i></i></a>';
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-2">
                                <label for="type" class="required">Type de réglement :</label>
                                <select id="type" class="form-control" name="type" required>
                                    <?php
                                    foreach ($lesTypesReglements as $valeur) {
                                        $required = "";
                                        if ($leReglement['PAIEMENT_INSCRIPTIONS'] == $valeur['ID']) {
                                            $required = "selected";
                                        }
                                        echo '<option id="' . $valeur['NOM'] . '" value="' . $valeur['ID'] . '" name="type"' . $required . '>' . $valeur['NOM'] . '</option>';
                                    }
                                    ?>
                                </select><br>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <div id="cheque">
                                    <label for="num_transaction" class="required">N° de transaction : </label>
                                    <input class="form-control" type="number" name="num_transaction"
                                           value="<?php echo $leReglement['NUMTRANSACTION']; ?>" required><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">
                                <div id="banque">
                                    <label for="banque" class="required">Banque (seulement si chèque) </label>
                                    <select class="form-control" name="banque" required>
                                        <option disabled="disabled" selected="selected">Choisir</option>
                                        <?php
                                        foreach ($lesBanques as $uneLigne) {
                                            if ($uneLigne['NOM'] == $leReglement['BANQUE_INSCRIPTION']) {
                                                echo '<option id="' . $uneLigne['NOM'] . '" value="' . $uneLigne['NOM'] . '" name="' . $uneLigne['NOM'] . '" selected>' . $uneLigne['NOM'] . '</option>';
                                            } else {
                                                echo '<option id="' . $uneLigne['NOM'] . '" value="' . $uneLigne['NOM'] . '" name="' . $uneLigne['NOM'] . '">' . $uneLigne['NOM'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select><br>
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 mt-1">
                            <label for="adhesion-ajout" class="mr-2">Ajout :</label>

                            <?php
                                if (isset($leReglementInfos["STAGE"]) and $leReglementInfos["STAGE"] == 1) {
                                    $checkedStage = "checked";
                                } else {
                                    $checkedStage = "";
                                }

                                if (isset($leReglementInfos["SORTIE_STAGE"]) and $leReglementInfos["SORTIE_STAGE"] == 1) {
                                    $checkedStageSortie = "checked";
                                } else {
                                    $checkedStageSortie = "";
                                }
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="stage" name="stage" <?=$checkedStage?>>
                                <label class="form-check-label" for="stage">Inscription Stage <span class="badge bg-warning"><?php echo $leStage['PRIX_STAGE']; ?>€/PERS</span></label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="stage_sortie" name="stage_sortie" <?=$checkedStageSortie?>>
                                <label class="form-check-label" for="stage_sortie">Stage Sortie <span class="badge bg-warning"><?php echo is_null($leStage['PRIX_STAGE_SORTIE']) ? 0 : $leStage['PRIX_STAGE_SORTIE']; ?>€/PERS</span></label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-1">
                                <label for="montant" class="required">Montant : </label><br>
                                <input class="form-control" name="montant" type="number" id="montant"
                                       value="<?php
                                       if (isset($leReglement['MONTANT_INSCRIPTION'])
                                           and
                                           !is_null($leReglement['MONTANT_INSCRIPTION'])
                                           and
                                           $leReglement['MONTANT_INSCRIPTION'] != "") {
                                           echo $leReglement['MONTANT_INSCRIPTION'];
                                       } else {
                                           echo "0";
                                       }
                                       ?>" required>
                                <br><br>
                            </div>
                        </div>

                        <input value="Modifier" type="submit" class="btn btn-success">
                    </div>
                </form>
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
<script>
    var selectedOptions = [];

    const buttonAddFratrie = document.getElementById("button-add-fratrie");
    var items = document.getElementsByClassName("list-group-item");
    for (var i = 0; i < items.length; i++) {
        selectedOptions.push(items[i].getAttribute("data-name"));
        items[i].addEventListener("click", function () {
            if (selectedOptions.length <= 1) {
                alert("Vous devez sélectionner au moins un élève !");
            } else {
                removeItem(this);
            }
        });
    }
    document.getElementById("selected-eleves").value = selectedOptions.join(',');


    function removeItem(item) {
        var itemName = item.getAttribute("data-name");
        var index = selectedOptions.indexOf(itemName);
        if (index > -1) {
            selectedOptions.splice(index, 1);
        }
        item.remove();

        document.getElementById("selected-eleves").value = selectedOptions.join(',');
    }

    buttonAddFratrie.addEventListener("click", function () {
        var select = document.getElementById("select-payement-eleves");
        var list = document.getElementById("list-payement-eleves");
        var selectedItemId = select.options[select.selectedIndex].value;
        var selectedItem = select.options[select.selectedIndex].text;

        // Vérifier si l'option sélectionnée n'a pas déjà été ajoutée à la liste
        if (selectedOptions.includes(selectedItemId)) {
            alert("Cette option a déjà été ajoutée à la liste !");
            return;
        }

        if (selectedItemId == -1) {
            alert("Veuillez sélectionner un élève !");
            return;
        }

        // Ajouter l'option à la liste
        selectedOptions.push(selectedItemId);

        var newItem = document.createElement("a");
        newItem.className = "list-group-item";
        newItem.innerHTML = selectedItem;
        var removeButton = document.createElement("i");
        removeButton.className = "btn btn-danger btn-sm ml-2 float-right";
        var icon = document.createElement("i");
        icon.className = "fa fa-trash";
        removeButton.appendChild(icon);
        removeButton.onclick = function() {
            if (selectedOptions.length <= 1) {
                alert("Vous devez sélectionner au moins un élève !");
            } else {
                removeItem(newItem);
            }
        };
        newItem.appendChild(removeButton);
        newItem.setAttribute("data-name", selectedItemId);
        list.appendChild(newItem);

        document.getElementById("selected-eleves").value = selectedOptions.join(',');
    })
</script>
<script>
    const montantTarifStage = <?php echo $leStage['PRIX_STAGE']; ?>;
    const montantTarifSortie = <?php echo is_null($leStage['PRIX_STAGE_SORTIE']) ? 0 : $leStage['PRIX_STAGE_SORTIE']; ?>;

    document.getElementById('stage').addEventListener('click',
        function (e) {
            if (!document.getElementById('stage').checked) {
                document.getElementById('stage_sortie').checked = false;
            }
            calculMontant();
        }
    );

    document.getElementById('stage_sortie').addEventListener('click',
        function (e) {
            if (document.getElementById('stage_sortie').checked) {
                if (!document.getElementById('stage').checked) {
                    document.getElementById('stage').checked = true;
                }
            }
            calculMontant();
        }
    );

    function calculMontant() {
        let montant = 0;
        if (document.getElementById('type').value == 83) {
            return;
        }
        if (document.getElementById('stage').checked) {
            montant += montantTarifStage * (selectedOptions.length);
        }
        if (document.getElementById('stage_sortie').checked) {
            montant += montantTarifSortie * (selectedOptions.length);
        }
        document.getElementById('montant').value = montant;
    }

</script>