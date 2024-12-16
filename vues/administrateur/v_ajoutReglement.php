<?php echo ' <form name="frmConsultFrais" method="POST" action="index.php?choixTraitement=administrateur&action=ajoutReglementValidation&num=' . $num . '">  ';


?>

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Ajouter un réglement
                <div class="page-title-subheading">Ajout d'un réglement pour <?php echo $UnEleve['PRENOM'] . ' ' . $UnEleve['NOM']; ?></div>
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
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="form-group">
                    <h4 class="card-title">Ajouter un réglement</h4>
                    <div class="form-group" style="background-color: #ccbcbc; padding: 10px; border-radius: 10px;">
                        <h5 style="font-weight: bold; color: #333;">Choix fratries </h5>
                        <label for="select-payement-eleves">Ajouter des frères ou soeurs au réglement :</label>
                        <select id="select-payement-eleves" class="multiselect-dropdown form-control" data-live-search="true">
                            <option value="-1" disabled="disabled" selected="selected">Choisir</option>
                            <?php
                            foreach ($lesFratries as $uneFratrie) {
                                echo '<option value="' . $uneFratrie['ID_ELEVE'] . '">' . $uneFratrie['PRENOM'] . ' ' . $uneFratrie['NOM'] . '</option>';
                            }
                            ?>
                        </select>
                        <button type="button" class="btn btn-primary mt-2" id="button-add-fratrie">Ajouter à la liste</button>

                        <input type="hidden" name="selectedEleves" id="selected-eleves" value="" required>
                        <div class="list-group mt-3" id="list-payement-eleves">
                            <a class="list-group-item disabled" data-name="<?=$UnEleve['ID_ELEVE']?>"><?php echo $UnEleve['PRENOM'] . ' ' . $UnEleve['NOM']; ?></a>
                        </div>
                    </div>

                    <label for="nom" class="required">Nom</label>
                    <select name="nom" required class="form-control">
                        <option value="Autre">Autre</option>
                        <?php
                            foreach ($lesAnneesScolaires as $value) {
                                $annee = "Soutien scolaire " . $value['ANNEE'] . '-' . ($value['ANNEE'] + 1);
                                $selected = "";
                                if ($uneAnnee['ANNEE'] == $value['ANNEE']) {
                                    $selected = "selected";
                                }
                                echo '<option value="' . $annee . '" ' . $selected . '>' . $annee . '</option>';
                            }
                        ?>
                    </select><br>


                    <label for="date" class="required">Date </label>
                    <input name="date" class="form-control" type="date" autofocus="" placeholder="0000/00/00"
                           required value="<?php echo date('Y-m-d', time()); ?>"><br>


                    <label for="type" class="required">Type</label>
                    <select id="type" name="type" required class="form-control">
                        <option disabled="disabled" selected="selected">Choisir</option>
                        <?php
                        foreach ($lesTypesReglements as $valeur) {
                            echo '<option id="' . $valeur['NOM'] . '" value="' . $valeur['ID'] . '" name="type">' . $valeur['NOM'] . '</option>';
                        }
                        ?>
                    </select><br>


                    <div id="cheque">
                        <label for="num_transaction" class="required">N° de transaction</label>
                        <input name="num_transaction" autofocus="" class="form-control" required><br>
                    </div>

                    <div id="banque">
                        <label for="banque" class="required">Banque</label>
                        <select class="form-control" name="banque" required>
                            <option disabled="disabled" selected="selected">Choisir</option>
                            <?php
                            foreach ($lesBanques as $uneLigne) {
                                echo '<option id="' . $uneLigne['NOM'] . '" value="' . $uneLigne['NOM'] . '" name="' . $uneLigne['NOM'] . '">' . $uneLigne['NOM'] . '</option>';
                            }
                            ?>
                        </select><br>
                    </div>

                    <div class="mb-1 mt-1">
                        <?php
                            echo '<div class="mb-1 mt-1">';
                            if ($adhesion) {
                                $none = 'class="d-none"';
                                echo '<span class="badge badge-success">Adhérent</span>';
                            } else {
                                $none = '';
                                echo '<span class="badge badge-danger">Pas Adhérent</span>';
                            }
                            echo '</div>';

                            echo '<div ' . $none . '>
                                <label for="adhesion" class="mr-2">
                                    Adhésion Choix :
                                </label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="adhesion_caf" name="adhesion_caf">
                                    <label class="form-check-label" for="adhesion_caf">CAF <span class="badge bg-warning">' . $lesTarifs["Prix Caf"] . '€</span></label>
                                </div>
        
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="adhesion_tarif_plein" name="adhesion_tarif">
                                    <label class="form-check-label" for="adhesion_tarif_plein">Tarif Plein <span class="badge bg-warning">' . $lesTarifs["Prix Tarif Plein"] . '€</span></label>
                                </div>
                            </div>';
                        ?>
                    </div>

                    <div class="mb-1 mt-1">
                        <label for="adhesion-ajout" class="mr-2">Ajout :</label>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="soutien" name="soutien">
                            <label class="form-check-label" for="soutien">Soutien Scolaire <span class="badge bg-warning"><?=$lesTarifs["Prix Soutien Scolaire"]?>€/pers</span></label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="dons" name="dons">
                            <label class="form-check-label" for="dons">Dons</label>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="montant" class="required">Montant </label><br>
                        <input name="montant" autofocus="" id="montant" required type="number" class="form-control"
                               style="width:100px;display:inline"> €
                    </div>

                    <script>
                        var selectedOptions = [];
                        let adhesionMontant = 0;

                        const buttonAddFratrie = document.getElementById("button-add-fratrie");

                        const adhesionCafCheckbox = document.getElementById("adhesion_caf");
                        const adhesionCheckbox = document.getElementById("adhesion_tarif_plein");
                        const soutienCheckbox = document.getElementById("soutien");
                        const donsCheckbox = document.getElementById("dons");
                        const montantInput = document.getElementById("montant");

                        const montantTarifPlein = <?php echo $lesTarifs["Prix Tarif Plein"]; ?>;
                        const montantTarifCaf = <?php echo $lesTarifs["Prix Caf"]; ?>;
                        const montantSoutien = <?php echo $lesTarifs["Prix Soutien Scolaire"]; ?>;

                        var items = document.getElementsByClassName("list-group-item");
                        for (var i = 0; i < items.length; i++) {
                            selectedOptions.push(items[i].getAttribute("data-name"));
                            items[i].addEventListener("click", function () {
                                removeItem(this);
                            });
                        }

                        document.getElementById("selected-eleves").value = selectedOptions.join(',');

                        function removeItem(item) {
                            var itemName = item.getAttribute("data-name");
                            var index = selectedOptions.indexOf(itemName);
                            if (index > -1) {
                                selectedOptions.splice(index, 1);
                                if (soutienCheckbox.checked) {
                                    calculMontant();
                                }
                            }
                            item.remove();

                            document.getElementById("selected-eleves").value = selectedOptions.join(',');
                        }

                        function calculMontant() {
                            adhesionMontant = 0;
                            if (document.getElementById('type').value == 83) {
                                return;
                            }
                            if (!donsCheckbox.checked) {
                                if (adhesionCafCheckbox.checked) {
                                    adhesionMontant += montantTarifCaf;
                                } else if (adhesionCheckbox.checked) {
                                    adhesionMontant += montantTarifPlein;
                                }
                                if (soutienCheckbox.checked) {
                                    adhesionMontant += montantSoutien * (selectedOptions.length);
                                }
                            } else {
                                montantTarifCaf.checked = false;
                                montantTarifPlein.checked = false;
                                soutienCheckbox.checked = false;
                            }
                            montantInput.value = adhesionMontant;
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

                            if (soutienCheckbox.checked) {
                                calculMontant();
                            }

                            var newItem = document.createElement("a");
                            newItem.className = "list-group-item";
                            newItem.innerHTML = selectedItem;
                            var removeButton = document.createElement("button");
                            removeButton.className = "btn btn-danger btn-sm ml-2 float-right";
                            var icon = document.createElement("i");
                            icon.className = "fa fa-trash";
                            removeButton.appendChild(icon);
                            removeButton.onclick = function() {
                                removeItem(newItem);
                            };
                            newItem.appendChild(removeButton);
                            newItem.setAttribute("data-name", selectedItemId);
                            list.appendChild(newItem);

                            document.getElementById("selected-eleves").value = selectedOptions.join(',');
                        })

                        adhesionCafCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                                if (adhesionCheckbox.checked) {
                                    adhesionCheckbox.checked = false;
                                }
                            }
                            calculMontant();
                        });

                        adhesionCheckbox.addEventListener("change", function() {
                            if (this.checked) {
                                if (adhesionCafCheckbox.checked) {
                                    adhesionCafCheckbox.checked = false;
                                }
                            }
                            calculMontant();
                        });

                        soutienCheckbox.addEventListener("change", function() {
                            calculMontant();
                        });

                        donsCheckbox.addEventListener("change", function() {
                            calculMontant();
                        });

                    </script>

                    <label for="commentaires">Commentaires : <br/>
                    </label>
                    <textarea name="commentaires" class="form-control"></textarea><br>

                    <p><input value="Soummettre" type="submit" class="btn btn-success"></p>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
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
    let adhesionMontant = 0;

    const buttonAddFratrie = document.getElementById("button-add-fratrie");

    const adhesionCafCheckbox = document.getElementById("adhesion_caf");
    const adhesionCheckbox = document.getElementById("adhesion_tarif_plein");
    const soutienCheckbox = document.getElementById("soutien");
    const donsCheckbox = document.getElementById("dons");
    const montantInput = document.getElementById("montant");

    const montantTarifPlein = <?php echo $lesTarifs["Prix Tarif Plein"]; ?>;
    const montantTarifCaf = <?php echo $lesTarifs["Prix Caf"]; ?>;
    const montantSoutien = <?php echo $lesTarifs["Prix Soutien Scolaire"]; ?>;

    var items = document.getElementsByClassName("list-group-item");
    for (var i = 0; i < items.length; i++) {
        console.log(items[i].getAttribute("data-name"));
        selectedOptions.push(items[i].getAttribute("data-name"));
        items[i].addEventListener("click", function () {
            removeItem(this);
        });
    }

    document.getElementById("selected-eleves").value = selectedOptions.join(',');

    function removeItem(item) {
        var itemName = item.getAttribute("data-name");
        var index = selectedOptions.indexOf(itemName);
        if (index > -1) {
            selectedOptions.splice(index, 1);
            if (soutienCheckbox.checked) {
                calculMontant();
            }
        }
        item.remove();

        document.getElementById("selected-eleves").value = selectedOptions.join(',');
    }

    function calculMontant() {
        adhesionMontant = 0;
        console.log(document.getElementById('type').value);
        if (document.getElementById('type').value == 83) {
            return;
        }
        if (!donsCheckbox.checked) {
            if (adhesionCafCheckbox.checked) {
                adhesionMontant += montantTarifCaf;
            } else if (adhesionCheckbox.checked) {
                adhesionMontant += montantTarifPlein;
            }
            if (soutienCheckbox.checked) {
                adhesionMontant += montantSoutien * (selectedOptions.length);
            }
        } else {
            montantTarifCaf.checked = false;
            montantTarifPlein.checked = false;
            soutienCheckbox.checked = false;
        }
        montantInput.value = adhesionMontant;
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

        if (soutienCheckbox.checked) {
            calculMontant();
        }

        var newItem = document.createElement("a");
        newItem.className = "list-group-item";
        newItem.innerHTML = selectedItem;
        var removeButton = document.createElement("button");
        removeButton.className = "btn btn-danger btn-sm ml-2 float-right";
        var icon = document.createElement("i");
        icon.className = "fa fa-trash";
        removeButton.appendChild(icon);
        removeButton.onclick = function() {
            removeItem(newItem);
        };
        newItem.appendChild(removeButton);
        newItem.setAttribute("data-name", selectedItemId);
        list.appendChild(newItem);

        document.getElementById("selected-eleves").value = selectedOptions.join(',');
    })

    adhesionCafCheckbox.addEventListener("change", function() {
        if (this.checked) {
            if (adhesionCheckbox.checked) {
                adhesionCheckbox.checked = false;
            }
        }
        calculMontant();
    });

    adhesionCheckbox.addEventListener("change", function() {
        if (this.checked) {
            if (adhesionCafCheckbox.checked) {
                adhesionCafCheckbox.checked = false;
            }
        }
        calculMontant();
    });

    soutienCheckbox.addEventListener("change", function() {
        calculMontant();
    });

    donsCheckbox.addEventListener("change", function() {
        calculMontant();
    });

</script>
