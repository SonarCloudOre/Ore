// Description: Script JavaScript pour la page de règlement du centre informatique

// --------------------- AJOUT REGLEMENT -----------------------


//---------- VARIABLES GLOBALES -------------
const listeIdGrammes = [3, 4];


//--------------- FONCTIONS -----------------



// Ajout des événements sur les éléments du DOM
function addEvents() {
    // Récupération des éléments du DOM
    var radioAdherent = document.getElementById('adherent');
    var radioNonAdherent = document.getElementById('nonAdherent');
    var checkboxAdhesion = document.getElementById('idAdhesion');
    var listeActivites = document.getElementById('idActivite');
    
    const typeReglement = document.getElementById('idTypeReglement');
    
    const banqueField = document.getElementById('idBanque');
    const labelBanque = banqueField.previousElementSibling;
    const numTransactionField = document.getElementById('idNumTransaction');
    const labelNumTransaction = numTransactionField.previousElementSibling;


    // Ajout des événements sur les éléments du DOM
    // Type de règlement (Espèces, Chèque, Virement, Bon caf, Autre, Exonéré)
    typeReglement.addEventListener('change', function() {
        const selectedType = parseInt(typeReglement.value);
        

        // Désactiver les champs par défaut
        banqueField.required = true;
        banqueField.disabled = false;
        labelBanque.classList.add('required');

        numTransactionField.required = true;
        numTransactionField.disabled = false;
        labelNumTransaction.classList.add('required');

        // Activer/Désactiver les champs en fonction du type de règlement
        // Si le type de règlement est 'Espèces' ou 'Bon caf' ou 'Autre' ou 'Exonéré'
        if (selectedType === 2 || selectedType === 3 || selectedType === 80 || selectedType === 83) {
            banqueField.required = false;
            banqueField.disabled = true;
            labelBanque.classList.remove('required');

            numTransactionField.required = false;
            numTransactionField.disabled = true;
            labelNumTransaction.classList.remove('required');
        }
    });


    // Rend le champ 'Montant' visible pour l'envoi du formulaire
    document.getElementById('formReglement').addEventListener('submit', function(event) {
        var prixTotalField = document.getElementById('idPrixTotal');
        var montant = prixTotalField.value;
        prixTotalField.disabled = false;
        prixTotalField.value = parseFloat(montant).toFixed(2);
        setTimeout(() => {
            prixTotalField.disabled = true;
        }, 50);
    });

    // Ajout des événements
    radioAdherent.addEventListener('click', function() { showAdherent(); });
    radioNonAdherent.addEventListener('click', function() { showNonAdherent(); });
    checkboxAdhesion.addEventListener('change', function() { calculReglementAdhesion(); });
    listeActivites.addEventListener('change', function() { chooseConsommables(); });

    // Intercepter la touche 'Entrée' pour empêcher l'envoi du formulaire
    document.getElementById('formReglement').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
        event.preventDefault(); // Empêche l'envoi du formulaire
        
        }
    });

    // Empêcher la sélection des labels lors d'un double clic
    document.querySelectorAll('label').forEach(function(label) {
        label.addEventListener('mousedown', function(event) {
            event.preventDefault();

            var activeElement = document.activeElement;
            if (activeElement && activeElement.tagName === 'INPUT') {
                activeElement.blur();
            }
        });
    });



    document.getElementById('idUserCI').addEventListener('input', function() {
        var input = this;
        var list = input.getAttribute('list');
        var options = document.getElementById(list).childNodes;
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === input.value) {
                // Set a hidden input field to store the user ID
                document.getElementById('userCI_id').value = options[i].getAttribute('data-id');
                break;
            }
        }
    });

    addEventsLabelsAntiSelection();
}

function addEventsLabelsAntiSelection() {
    // Empêcher la sélection des labels lors d'un double clic à une intervalle de 100ms
    setInterval(() => {
        document.querySelectorAll('label').forEach(function(label) {
            if (label.getAttribute('unselectable') === null) {
                label.addEventListener('mousedown', function(event) {
                    this.setAttribute('unselectable', 'on');
                    event.preventDefault();
                });
            }
        });
    }, 100);
}
    

// Affiche les éléments du formulaire pour un adhérent
function showAdherent() {
    // Récupération des éléments du DOM
    var divAdherent = document.getElementById('adherentDiv');
    var divNonAdherent = document.getElementById('nonAdherentDiv');
    var inputAdherent = Array.from(divAdherent.getElementsByClassName('inputCI'));
    var inputNonAdherent = Array.from(divNonAdherent.getElementsByClassName('inputCI'));
    var labelAdherent = Array.from(divAdherent.getElementsByClassName('labelCI'));
    var labelNonAdherent = Array.from(divNonAdherent.getElementsByClassName('labelCI'));
    // On désactive les éléments du formulaire pour un non adhérent et on active ceux pour un adhérent
    inputAdherent.forEach(input => {
        input.disabled = false;
        input.required = true;
    });
    labelAdherent.forEach(label => {
        label.classList.add('required');
    });
    inputNonAdherent.forEach(input => {
        input.disabled = true;
        input.required = false;
    });
    labelNonAdherent.forEach(label => {
        label.classList.remove('required');
    });
}
    
// Affiche les éléments du formulaire pour un non adhérent
function showNonAdherent() {
    // Récupération des éléments du DOM
    var divAdherent = document.getElementById('adherentDiv');
    var divNonAdherent = document.getElementById('nonAdherentDiv');
    var inputAdherent = Array.from(divAdherent.getElementsByClassName('inputCI'));
    var inputNonAdherent = Array.from(divNonAdherent.getElementsByClassName('inputCI'));
    var labelAdherent = Array.from(divAdherent.getElementsByClassName('labelCI'));
    var labelNonAdherent = Array.from(divNonAdherent.getElementsByClassName('labelCI'));

    // On désactive les éléments du formulaire pour un adhérent et on active ceux pour un non adhérent
    inputAdherent.forEach(input => {
        input.disabled = true;
        input.required = false;
        
    });
    labelAdherent.forEach(label => {
        label.classList.remove('required');
    });
    inputNonAdherent.forEach(input => {
        input.disabled = false;
        input.required = true;

    });
    labelNonAdherent.forEach(label => {
        label.classList.add('required');
    });
    
}



function calculReglementAdhesion() {
    // Récupération des éléments du DOM

    var checkboxAdhesion = document.getElementById('idAdhesion');
    var divFabLab = document.getElementById('idFabLab');
    var listeActivites = document.getElementById('idActivite');
    var divConsommables = document.getElementById('idConsommable');
    var toutSelectionner = document.getElementById('idToutSelectionner');
    var listeConsommables = Array.from(divConsommables.getElementsByClassName('inputConsommable'));
    var listeQuantiteConsommables = Array.from(divConsommables.getElementsByClassName('inputQuantiteConsommable'));
    var prixTotal = document.getElementById('idPrixTotal');
    var labelsFabLab = Array.from(divFabLab.getElementsByClassName('labelCI'));
    


    if (checkboxAdhesion.checked) {
    
    // On attribue le règlement total à 20€ de l'adhésion
    prixTotal.value = '20.00';
    // On désactive les listes déroulantes si la case est cochée
    listeActivites.disabled = true;
   
    listeActivites.required = false;
    listeConsommables.required = false;
    labelsFabLab.forEach(label => {
        label.classList.remove('required');
    });
    // On désactive la case tout sélectionner si elle existe
    if (toutSelectionner) {
        toutSelectionner.disabled = true;
    }

    

    listeConsommables.forEach(consommable => {
        consommable.disabled = true;
        consommable.required = false;
    });

    listeQuantiteConsommables.forEach(quantiteConsommable => {
        quantiteConsommable.disabled = true;
    });

    
    
    } else {
    // On attribue le règlement total à 0€
    prixTotal.value = '0.00';
    // On active les listes déroulantes si la case n'est pas cochée
    listeActivites.disabled = false;
    
    listeActivites.required = true;
    
    labelsFabLab.forEach(label => {
        label.classList.add('required');
    });

    // On active la case tout sélectionner si elle existe
    if (toutSelectionner) {
        toutSelectionner.disabled = false;
    }


    listeConsommables.forEach(consommable => {
        consommable.disabled = false;
        consommable.required = true;
    });

    listeQuantiteConsommables.forEach(quantiteConsommable => {
        quantiteConsommable.disabled = false;
    });
    
    }
}

function checkPrixTotal() {

    const inputPrixTotal = document.getElementById('idPrixTotal');
    var submitReglement = document.getElementById('idSubmitReglement');
    let previousValue = inputPrixTotal.value;

    setInterval(() => {
        if (inputPrixTotal.value <= 0) {
            submitReglement.disabled = true;
        }
        else if (inputPrixTotal.value !== previousValue && inputPrixTotal.value !== '0') {
            submitReglement.disabled = false;
        }
    }, 100);
}

function chooseConsommables() {
    reinitialiserMontant();

    var listeActivites = document.getElementById('idActivite');
    var idActivite = listeActivites.value;

    // Obtenir le chemin de base dynamiquement
    var basePath = window.location.pathname.split('/')[1];

    // Request AJAX en POST asynchrone
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/' + basePath + '/index.php?choixTraitement=administrateur&action=ajax_reglement', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            //console.log('Statut de la requête:', xhr.status);
            if (xhr.status === 200) {
                var divConsommables = document.getElementById('idConsommable');
                var consommables = JSON.parse(xhr.responseText); // Parse JSON response
                divConsommables.innerHTML = `
                        <input type="checkbox" class="custom-control-input custom-input" id="idToutSelectionner" onclick="selectAllConsommables()">
                        <label class="tout-selectionner custom-control-label" for="idToutSelectionner">Tout sélectionner</label>
                    `;
                consommables.forEach(function(consommable) {
                    var div = document.createElement('div');
                    div.id = `consommable-item_${consommable.ID_CONSOMMABLE}`;
                    div.className = `custom-control custom-checkbox custom-checkbox-container`;
                    div.innerHTML = `
                        <input type="checkbox" class='custom-control-input custom-input inputConsommable' onchange='addQuantiteConsommables("consommable-item_${consommable.ID_CONSOMMABLE}")' id="consommable_${consommable.ID_CONSOMMABLE}" name="consommable_${consommable.ID_CONSOMMABLE}" value="${consommable.ID_CONSOMMABLE}" data-id="${consommable.ID_CONSOMMABLE}"  data-prix="${consommable.PRIX}">
                        <label class='custom-control-label' for="consommable_${consommable.ID_CONSOMMABLE}">${consommable.NOM} - <em>${consommable.DESCRIPTION}</em> - ${consommable.PRIX}€</label>
                    `;
                    divConsommables.appendChild(div);
                });
                //console.log('Réponse du serveur:', xhr.responseText);
                // Attendre quelques secondes
                setTimeout(() => {
                    checkCheckboxesSelected();
                }, 1000);
            } else {
                console.error('Erreur lors de la requête AJAX');
            }
        }
    };
    // Send POST request
    xhr.send('idActivite=' + idActivite);
    
}

function selectAllConsommables() {
    var idToutSelectionner = document.getElementById('idToutSelectionner');
    var divConsommables = document.getElementById('idConsommable');
    var listeInputCheckbox = Array.from(divConsommables.getElementsByClassName('inputConsommable'));

    listeInputCheckbox.forEach(inputCheckbox => {
        inputCheckbox.checked = idToutSelectionner.checked;
        addQuantiteConsommables(inputCheckbox.parentElement.id);
    });
}

function addQuantiteConsommables(idDivConsommable) {
    var divConsommables = document.getElementById('idConsommable');
    var divUnConsommable = divConsommables.querySelector("#"+idDivConsommable);
    var listeInputCheckbox = Array.from(divUnConsommable.getElementsByClassName('inputConsommable'));
    var inputCheckbox = listeInputCheckbox[0];
    var toutSelectionner = document.getElementById('idToutSelectionner');
    var prixTotal = document.getElementById('idPrixTotal');
    var idConsommable = inputCheckbox.getAttribute('data-id');
    
    if (toutSelectionner.checked === false) {
        prixTotal.value = '0.00';
    }

    if (inputCheckbox.checked) {
        // Vérifiez si l'input number existe déjà
        if (!divUnConsommable.querySelector('.custom-number-input')) {
            var inputQuantite = document.createElement('input');

            inputQuantite.type = 'number';
            inputQuantite.min = '1';
            inputQuantite.setAttribute('data-quantite-definie', 'false');
            inputQuantite.className = 'custom-number-input inputQuantiteConsommable';
            inputQuantite.id = "quantite_"+idDivConsommable.slice(-1);
            inputQuantite.name = "quantite_"+idDivConsommable.slice(-1);

            if (listeIdGrammes.includes(parseInt(idConsommable, 10))) {
                inputQuantite.placeholder = 'Quantité (en grammes)';
                inputQuantite.step = '1';
            } else {
                inputQuantite.placeholder = 'Quantité';
                inputQuantite.step = '1';
            }

            // Insérer l'input number après le label
            var labelConsommable = divUnConsommable.querySelector(`label[for="${inputCheckbox.id}"]`);
            if (labelConsommable) {
                labelConsommable.insertAdjacentElement('afterend', inputQuantite);
            }
        }
    } else {
        var listeInputQuantite = divUnConsommable.getElementsByClassName('inputQuantiteConsommable');
        var inputQuantite = listeInputQuantite[0];
        inputQuantite.remove();
        toutSelectionner.checked = false;
    }
}

function checkCheckboxesSelected() {
    setInterval(() => {
        var divConsommables = document.getElementById('idConsommable');
        var listeInputCheckbox = Array.from(divConsommables.getElementsByClassName('inputConsommable'));
        var toutSelectionner = document.getElementById('idToutSelectionner');
        var compteur = 0;

        listeInputCheckbox.forEach(inputCheckbox => {
            if (inputCheckbox.checked) {
                compteur++;
            }
            if (inputCheckbox.checked === false) {
                if (compteur > 0) {
                    compteur--;
                }
                
            }
        });

        if (compteur === listeInputCheckbox.length) {
            toutSelectionner.checked = true;
        }

    }, 100);
}

function calculPrixTotal() {
    setInterval(() => {
        var adhesion = document.getElementById('idAdhesion');
        var prixTotal = document.getElementById('idPrixTotal');
        var divConsommables = document.getElementById('idConsommable');
        var listeInputQuantite = Array.from(divConsommables.getElementsByClassName('inputQuantiteConsommable'));
        var prix = 0;

        // Si la case adhésion n'est pas cochée
        if (!adhesion.checked) {
            if (listeInputQuantite.length !== 0 && listeInputQuantite !== null) {
                listeInputQuantite.forEach(inputQuantite => {
                    var quantite = parseFloat(inputQuantite.value);
                    var inputCheckbox = inputQuantite.previousElementSibling.previousElementSibling;
                    var idConsommable = inputCheckbox.getAttribute('data-id');
                    var prixUnitaire = parseFloat(inputCheckbox.getAttribute('data-prix'));
                    if (isNaN(quantite)) {
                        quantite = 0;
                    }
                    if (listeIdGrammes.includes(parseInt(idConsommable, 10))) {
                        quantite = quantite / 1000;
                    }
                    prix += quantite * prixUnitaire;
                });

                if (prix < 0 || isNaN(prix)) {
                    prix = 0;
                }
                prixTotal.value = prix.toFixed(2);
                
            }
        }
    }, 100);
}

// function stockMontant() {
//     setInterval(() => {
//         var montant = document.getElementById('idPrixTotal').value;
//         var inputMontant = document.getElementById('idMontant');
//         inputMontant.value = parseFloat(montant);
//     }, 100);
// }

function reinitialiserMontant() {
    // Attendre quelques secondes
    setTimeout(() => {
            // Réinitialiser le montant total à 0
            var prixTotal = document.getElementById('idPrixTotal');
            prixTotal.value = '0.00';
        }, 300);
}
// function addEventsInputsQuantite() {
//     setInterval(() => {
//         var divConsommables = document.getElementById('idConsommable');
//         var listeInputQuantite = Array.from(divConsommables.getElementsByClassName('inputQuantiteConsommable'));
//         if (listeInputQuantite.length !== 0 && listeInputQuantite !== null) {
//             listeInputQuantite.forEach(inputQuantite => {
//                 var quantiteDefinie = inputQuantite.getAttribute('data-quantite-definie');
//                 if (quantiteDefinie === 'false' || quantiteDefinie === null) {
//                     inputQuantite.addEventListener('change', function () {
//                         checkQuantiteConsommables(this.id, this.value);
//                     });
//                     inputQuantite.setAttribute('data-quantite-definie', 'true');
//                 }
//             });
//         }
//     }, 100);
// }


// // Losque l'utilisateur change la quantité d'un consommable augmente ou diminue le prix total
// function checkQuantiteConsommables(idQuantiteConsommable, valueConsommable) {
//     if (idQuantiteConsommable !== undefined || idQuantiteConsommable !== undefined) {
//         var inputQuantite = document.getElementById(idQuantiteConsommable);
//         valueConsommable = parseFloat(valueConsommable);
//         var value = parseFloat(inputQuantite.value);
//         var prixTotal = document.getElementById('idPrixTotal');

//         if (value > valueConsommable) {
//             // Augmenter le prix total arrondi à 2 chiffres après la virgule
//             prixTotal.value = (parseFloat(prixTotal.value) + value).toFixed(2);
//         } else if (value < valueConsommable) {
//             // Diminuer le prix total arrondi à 2 chiffres après la virgule
//             prixTotal.value = (parseFloat(prixTotal.value) - value).toFixed(2);
//         }
//     }

// }


// --------------------- CONSULTATION REGLEMENT -----------------------


//---------- VARIABLES GLOBALES -------------


//--------------- FONCTIONS -----------------

function addEventsConsulter() {
    // Récupération des éléments du DOM
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('searchInput');
        const dropdown = document.getElementById('dropdown');
        const hiddenInput = document.getElementById('user_id');  // Champ caché pour le premier input

        const input2 = document.getElementById('idUserCI2');
        const dropdown2 = document.getElementById('dropdown2');
        const hiddenInput2 = document.getElementById('userCI_id2');  // Champ caché pour le deuxième input

        const searchButton = document.getElementById('searchButton');
        
        const popupReglement = document.getElementById('popupReglement');
        const closePopupButton = document.getElementById('closePopupReglement');

        const deleteAllButton = document.getElementById('deleteAllReglements');
        
        // Ajouter un événement click pour le bouton de fermeture du popup
        closePopupButton.addEventListener('click', () => {
            closePopup();
        });

        // Récupération des utilisateurs
        const options = utilisateurs.map(user => ({
            id: user.ID_UTILISATEUR,
            name: `${user.NOM} ${user.PRENOM}`
        }));

        // Afficher toutes les options pour le premier champ
        const showAllOptions = () => {
            dropdown.innerHTML = '';
            options.forEach(option => {
                const div = document.createElement('div');
                div.textContent = option.name;
                div.dataset.id = option.id;
                div.addEventListener('click', () => {
                    input.value = option.name;
                    hiddenInput.value = option.id;  // Stocker l'ID de l'utilisateur
                    dropdown.innerHTML = '';
                    dropdown.style.display = 'none';
                });
                dropdown.appendChild(div);
            });
            dropdown.style.display = 'block';
        };

        // Afficher toutes les options pour le deuxième champ
        const showAllOptions2 = () => {
            dropdown2.innerHTML = '';
            options.forEach(option => {
                const div = document.createElement('div');
                div.textContent = option.name;
                div.dataset.id = option.id;
                div.addEventListener('click', () => {
                    input2.value = option.name;
                    hiddenInput2.value = option.id;  // Stocker l'ID de l'utilisateur
                    dropdown2.innerHTML = '';
                    dropdown2.style.display = 'none';
                });
                dropdown2.appendChild(div);
            });
            dropdown2.style.display = 'block';
        };


        // Filtrer les options pour le premier champ
        input.addEventListener('input', () => {
            const value = input.value.toLowerCase();
            dropdown.innerHTML = '';
            if (value) {
                const filteredOptions = options.filter(option => option.name.toLowerCase().includes(value));
                filteredOptions.forEach(option => {
                    const div = document.createElement('div');
                    div.textContent = option.name;
                    div.dataset.id = option.id;
                    div.addEventListener('click', () => {
                        input.value = option.name;
                        hiddenInput.value = option.id;  // Stocker l'ID de l'utilisateur
                        dropdown.innerHTML = '';
                        dropdown.style.display = 'none';
                    });
                    dropdown.appendChild(div);
                });
                dropdown.style.display = 'block';
            } else {
                showAllOptions();
            }
        });

        // Filtrer les options pour le deuxième champ
        input2.addEventListener('input', () => {
            const value = input2.value.toLowerCase();
            dropdown2.innerHTML = '';
            if (value) {
                const filteredOptions = options.filter(option => option.name.toLowerCase().includes(value));
                filteredOptions.forEach(option => {
                    const div = document.createElement('div');
                    div.textContent = option.name;
                    div.dataset.id = option.id;
                    div.addEventListener('click', () => {
                        input2.value = option.name;
                        hiddenInput2.value = option.id;  // Stocker l'ID de l'utilisateur
                        dropdown2.innerHTML = '';
                        dropdown2.style.display = 'none';
                    });
                    dropdown2.appendChild(div);
                });
                dropdown2.style.display = 'block';
            } else {
                showAllOptions2();
            }
        });

        // Afficher toutes les options au clic
        input.addEventListener('click', () => {
            showAllOptions();
        });

        input2.addEventListener('click', () => {
            showAllOptions2();
        });

        // Cacher le dropdown si on clique en dehors
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && e.target !== input) {
                dropdown.style.display = 'none';
            }
        });

        document.addEventListener('click', (e) => {
            if (!dropdown2.contains(e.target) && e.target !== input2) {
                dropdown2.style.display = 'none';
            }
        });

        // Réinitialiser le champ de recherche et le champ caché du premier input lors du changement d'onglet
        const tabs = document.querySelectorAll('[data-toggle="tab"]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                input.value = '';  // Réinitialiser le premier champ de recherche
                dropdown.innerHTML = '';  // Clear the dropdown as well
                dropdown.style.display = 'none';  // Hide the dropdown
                hiddenInput.value = '';  // Réinitialiser l'ID de l'utilisateur caché pour le premier input
            });
        });

        // Ajouter un événement click pour le bouton de recherche
        searchButton.addEventListener('click', () => {
            const userId = hiddenInput.value;
            if (userId) {
                fetchReglements(userId);
            } else {
                alert('Veuillez sélectionner un utilisateur');
            }
        });

        // Fermer le popup si on clique en dehors
        window.onclick = function(event) {
            if (event.target == popupReglement) {
                popupReglement.style.display = 'none';
                // Arrêter la fonction de vérification des champs du formulaire
                clearInterval(checkFormFields);
            }
        }

        // Ajouter un événement pour le bouton de suppression de tous les règlements
        deleteAllButton.addEventListener('click', () => {
            const userId = hiddenInput.value;
            deleteAllReglements(userId);
        });

    });

    
}


// Fonction pour récupérer les règlements d'un utilisateur
function fetchReglements(userId) {
    fetch(`index.php?choixTraitement=administrateur&action=getReglements&userId=${userId}`)
        .then(response => response.json())
        .then(data => {
            // Récupérer les éléments du DOM
            const reglementsSection = document.getElementById('reglementsSection');
            const reglementsContent = document.getElementById('reglementsContent');
            const autresActions = document.getElementById('autresActions');
            const spanNameUser = document.getElementById('nameUser');
        
            // Récupérer le nom et prénom de l'utilisateur
            const nomUser = data.nom;
            const prenomUser = data.prenom;

            // Ajourter le nom de l'utilisateur
            spanNameUser.textContent = `${nomUser} ${prenomUser}`;

            // Vider le contenu précédent
            reglementsContent.innerHTML = '';

            // Créer un tableau pour afficher les règlements
            var tableReglements = document.createElement('table');
            tableReglements.className = 'table table-bordered table-striped';
            var thead = document.createElement('thead');
            var tbody = document.createElement('tbody');
            tableReglements.appendChild(thead);
            tableReglements.appendChild(tbody);

            
            thead.id = 'enteteReglements';
            tbody.id = 'corpsReglements';

            // Créer les entêtes du tableau
            var tr = document.createElement('tr');
            var thTypeReglement = document.createElement('th');
            var thBanque = document.createElement('th');
            var thNumTransaction = document.createElement('th');
            var thDateReglement = document.createElement('th');
            var thMontantReglement = document.createElement('th');
            var thCommentaire = document.createElement('th');
            var thActions = document.createElement('th');

            // Ajouter les titres aux entêtes
            thTypeReglement.textContent = 'Type de règlement';
            thBanque.textContent = 'Banque';
            thNumTransaction.textContent = 'Numéro de transaction';
            thDateReglement.textContent = 'Date de règlement';
            thMontantReglement.textContent = 'Montant';
            thCommentaire.textContent = 'Commentaire';
            thActions.textContent = 'Actions';

            // Ajouter les titres d'entête aux lignes du tableau
            tr.appendChild(thTypeReglement);
            tr.appendChild(thBanque);
            tr.appendChild(thNumTransaction);
            tr.appendChild(thDateReglement);
            tr.appendChild(thMontantReglement);
            tr.appendChild(thCommentaire);
            tr.appendChild(thActions);

            // Ajouter la ligne d'entête au tableau
            thead.appendChild(tr);

            // Ajouter l'en-tête et le corps du tableau
            tableReglements.appendChild(thead);
            tableReglements.appendChild(tbody);


            // Afficher les règlements
            if (data.reglements.length > 0) {
                data.reglements.forEach(reglement => {                    
                    var idReglement = reglement.id;
                    var typeReglement = reglement.type;
                    var banque = reglement.banque;
                    var numTransaction = reglement.numTransaction;
                    var dateReglement = reglement.date;
                    // Convertir la date au format 'jj/mm/aaaa'
                    dateReglement = new Date(dateReglement).toLocaleDateString('fr-FR');
                    var montantReglement = reglement.montant;
                    var commentaire = reglement.commentaire;

                    // Créer une ligne pour chaque règlement
                    var tr = document.createElement('tr');
                    var tdTypeReglement = document.createElement('td');
                    var tdBanque = document.createElement('td');
                    var tdNumTransaction = document.createElement('td');
                    var tdDateReglement = document.createElement('td');
                    var tdMontantReglement = document.createElement('td');
                    var tdCommentaire = document.createElement('td');
                    var tdActions = document.createElement('td');

                    // Ajouter les données aux cellules de la ligne
                    tr.id = idReglement;
                    tdTypeReglement.textContent = typeReglement;
                    tdBanque.textContent = banque;
                    tdNumTransaction.textContent = numTransaction;
                    tdDateReglement.textContent = dateReglement;
                    tdMontantReglement.textContent = montantReglement + ' €';
                    tdCommentaire.textContent = commentaire;
                    // Ajouter les actions (boutons dont le contenu est une icone (stylo pour modifier et poubelle pour supprimer)) aux cellules
                    tdActions.innerHTML = `
                        <button class="btn btn-primary btn-sm" onclick="editReglement(${idReglement})">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteReglement(${idReglement})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;

                    // Si null, remplacer par une balise em 'Non renseigné'
                    if (banque === null) {
                        banque = '<em>Non renseigné</em>';
                        tdBanque.innerHTML = banque;
                    }
                    if (numTransaction === null) {
                        numTransaction = '<em>Non renseigné</em>';
                        tdNumTransaction.innerHTML = numTransaction;
                    }
                    if (commentaire === null) {
                        commentaire = '<em>Non renseigné</em>';
                        tdCommentaire.innerHTML = commentaire;
                    }

                    // Ajouter les cellules à la ligne
                    tr.appendChild(tdTypeReglement);
                    tr.appendChild(tdBanque);
                    tr.appendChild(tdNumTransaction);
                    tr.appendChild(tdDateReglement);
                    tr.appendChild(tdMontantReglement);
                    tr.appendChild(tdCommentaire);
                    tr.appendChild(tdActions);
                    
                    // Ajouter la ligne au corps du tableau
                    tbody.appendChild(tr);
                });

                // Ajouter le tableau des règlements
                reglementsContent.appendChild(tableReglements);
            } else {
                const div = document.createElement('div');
                div.textContent = 'Aucun règlement trouvé pour cet utilisateur.';
                reglementsContent.appendChild(div);
            }

            // Afficher la section des règlements
            reglementsSection.style.display = 'block';
            autresActions.style.display = 'block';

            // Afficher les autres actions

        })
        .catch(error => {
            console.error('Erreur lors de la récupération des règlements:', error);
        });
}

function editReglement(idReglement) {

    // Afficher le popup
    const popup = document.getElementById('popupReglement');
    popup.style.display = 'flex';

    // Récupérer les données du règlement
    const tr = document.getElementById(idReglement);
    const idReglementP = tr.id;
    const hiddenInputIDReglement = document.getElementById('idReglementP');
    const typeReglement = tr.cells[0].textContent;
    const banque = tr.cells[1].textContent;
    const numTransaction = tr.cells[2].textContent;
    var dateReglement = tr.cells[3].textContent;
    var montantReglement = tr.cells[4].textContent;
    const commentaire = tr.cells[5].textContent;

    // Lancer la fonction pour vérifier les champs du formulaire
    checkFormFields();

    // Remplir le champ caché de l'ID du règlement
    hiddenInputIDReglement.value = idReglementP;

    // Remplir les champs du formulaire

    // Type de règlement
    const typeReglementField = document.getElementById('idTypeReglementP');
    // Sélectionner l'option correspondante, si elle existe sinon la première option
    const optionTypeReglement = Array.from(typeReglementField.options).find(option => option.text === typeReglement);
    typeReglementField.selectedIndex = optionTypeReglement ? optionTypeReglement.index : 0;

    // Banque
    const banqueField = document.getElementById('idBanqueP');
    // Sélectionner l'option correspondante, si elle existe sinon la première option
    const optionBanque = Array.from(banqueField.options).find(option => option.text === banque);
    banqueField.selectedIndex = optionBanque ? optionBanque.index : 0;

    // Numéro de transaction
    const numTransactionField = document.getElementById('idNumTransactionP');
    numTransactionField.value = numTransaction;

    // Date de règlement
    const dateReglementField = document.getElementById('idDateReglementP');
    dateReglement = dateReglement.split('/').reverse().join('-');  // Convertir la date au format 'aaaa-mm-jj'
    dateReglementField.value = dateReglement;


    // Montant
    const montantField = document.getElementById('idMontantP');
    montantReglement = montantReglement.replace(' €', '');  // Retirer le symbole '€'
    montantField.value = montantReglement  // Retirer le symbole '€'

    // Commentaire
    const commentaireField = document.getElementById('idCommentaireP');
    commentaireField.value = commentaire;

    // Ajouter un événement pour le bouton de soumission du formulaire
    const submitReglement = document.getElementById('idSubmitReglement');
}

function checkFormFields() {
    setInterval(() => {
        // Récupération des champs du formulaire
        const typeReglementField = document.getElementById('idTypeReglementP');
        const banqueField = document.getElementById('idBanqueP');
        const labelBanque = banqueField.previousElementSibling;
        const numTransactionField = document.getElementById('idNumTransactionP');
        const labelNumTransaction = numTransactionField.previousElementSibling;
        const montantField = document.getElementById('idMontantP');

        // Si le type de règlement est 'Espèces' ou 'Bon caf' ou 'Autre' ou 'Exonéré'
        if (typeReglementField.value === '2' || typeReglementField.value === '3' || typeReglementField.value === '80' || typeReglementField.value === '83') {
            banqueField.required = false;
            banqueField.disabled = true;
            labelBanque.classList.remove('required');
            numTransactionField.required = false;
            numTransactionField.disabled = true;
            labelNumTransaction.classList.remove('required');
        } else {
            banqueField.required = true;
            banqueField.disabled = false;
            labelBanque.classList.add('required');
            numTransactionField.required = true;
            numTransactionField.disabled = false;
            labelNumTransaction.classList.add('required');
        }
    }, 100);
}


function closePopup() {
    const popup = document.getElementById('popupReglement');
    popup.style.display = 'none';
    // Arrêter la fonction de vérification des champs du formulaire
    clearInterval(checkFormFields);
}

function deleteReglement(idReglement) {

    // Afficher le popup de confirmation
    const popupConfirmation = document.getElementById('popupDeleteReglement');
    const cancelButton = document.getElementById('cancelDeleteReglement');
    const cancelButton2 = document.getElementById('closePopupDeleteReglement');
    popupConfirmation.style.display = 'flex';

    // Récupérer les éléments du DOM
    const tr = document.getElementById(idReglement);
    const idReglementD = tr.id;
    const hiddenInputIDReglement = document.getElementById('idReglementD');

    // Remplir le champ caché de l'ID du règlement à supprimer
    hiddenInputIDReglement.value = idReglementD;

    // Ajouter un événement pour le bouton d'anulation de la suppression
    cancelButton.addEventListener('click', () => {
        popupConfirmation.style.display = 'none';
    });
    cancelButton2.addEventListener('click', () => {
        popupConfirmation.style.display = 'none';
    });

}


function deleteAllReglements(userId) {
    
    // Afficher le popup de confirmation
    const popupConfirmation = document.getElementById('popupDeleteAllReglements');
    const cancelButton = document.getElementById('cancelDeleteAllReglements');
    const cancelButton2 = document.getElementById('closePopupDeleteAllReglements');
    popupConfirmation.style.display = 'flex';

    // Récupérer les éléments du DOM
    const hiddenInputIDUser = document.getElementById('idUserD');

    // Remplir le champ caché de l'ID de l'utilisateur
    hiddenInputIDUser.value = userId;

    // Ajouter un événement pour le bouton d'anulation de la suppression
    cancelButton.addEventListener('click', () => {
        popupConfirmation.style.display = 'none';
    });
    cancelButton2.addEventListener('click', () => {
        popupConfirmation.style.display = 'none';
    });

}






// addEventsInputsQuantite();
checkPrixTotal();
calculPrixTotal();
// stockMontant();
addEvents();
addEventsConsulter();
