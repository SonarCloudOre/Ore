
/*
format SMS EAGLE
01XXXXXXXX a 09XXXXXXXX
01 XX XX XX XX a 09 XX XX XX XX
*/
$.validator.addMethod("phonePattern", function(value, element) {
    return this.optional(element) || /^(0[1-9]\d{8}|0[1-9]\s\d{2}\s\d{2}\s\d{2}\s\d{2})$/.test(value);
});

// Form Validation
$(document).ready(() => {
    $("#signupForm").validate({
        rules: {
            nom: "required",
            prenom: "required",
            sexe: "required",
            date_naissance: "required",
            annee: "required",
            etab: "required",
            classe: "required",
            filiere: "required",
            lv1: "required",
            lv2: "required",
            "specialitesA[]":
                {
                    required: true,
                    minlength: 2,
                    maxlength: 2,
                },
            responsable_legal: "required",
            responsabilite: "required",
            responsable_legal: "required",
            tel_parent: {
                required: true,
                phonePattern: true,
            },
            tel_parent2: {
                phonePattern: true,
            },
            tel_parent3: {
                phonePattern: true,
            },
            tel_enfant: {
                phonePattern: true,
            },
            adresse: "required",
            cp: {
                required: true,
                minlength: 5,
                maxlength: 5,
                number: true,
            },
            ville: "required",
        },
        messages: {
            nom: "Veuillez saisir le nom",
            prenom: "Veuillez saisir le prénom",
            date_naissance: "Veuillez saisir la date de naissance",
            prof_principal: "Veuillez saisir le nom",
            responsableLegal: "Veuillez saisir le nom et le prénom du responsable légal",
            "specialitesA[]": {
                required: "Ce champ est requis",
                minlength: "Il faut deux spécialités",
                maxlength: "Il faut deux spécialités",
            },
            tel_parent: {
                phonePattern: "Format de numéro de téléphone invalide.",
            },
            tel_parent2: {
                phonePattern: "Format de numéro de téléphone invalide.",
            },
            tel_parent3: {
                phonePattern: "Format de numéro de téléphone invalide.",
            },
            tel_enfant: {
                phonePattern: "Format de numéro de téléphone invalide.",
            },
            adresse: "Veuillez saisir un nom de rue",
            cp: {
                required: "Veuillez saisir un numéro de code postal",
                minlength: "Le numéro de code postal doit comporter 5 chiffres",
            },
            ville: "Veuillez saisir une ville",
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `invalid-feedback` class to the error element
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
    });
});

$(document).ready(() => {
    $("#signupStageForm").validate({
        rules: {
            nom: "required",
            prenom: "required",
            ddnaissance: "required",
            sexe: "required",
            etab: "required",
            classe: "required",
            filiere: "required",
            tel_enfant: {
                phonePattern: true,
            },
            tel_parent: {
                required: true,
                phonePattern: true,
            },
            adresse: "required",
            cp: {
                required: true,
                minlength: 5,
                maxlength: 5,
                number: true,
            },
            ville: "required",
        },
        messages: {
            nom: "Veuillez saisir le nom",
            prenom: "Veuillez saisir le prénom",
            ddnaissance: "Veuillez saisir la date de naissance",
            tel_parent: {
                phonePattern: "Format de numéro de téléphone invalide.",
            },
            tel_enfant: {
                phonePattern: "Format de numéro de téléphone invalide.",
            },
            adresse: "Veuillez saisir un nom de rue",
            cp: {
                required: "Veuillez saisir un numéro de code postal",
                minlength: "Le numéro de code postal doit comporter 5 chiffres",
            },
            ville: "Veuillez saisir une ville",
        },

        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `invalid-feedback` class to the error element
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });
});

$(document).ready(() => {
    $("#signupStageInscritForm").validate({
        rules: {
            nom: "required",
            prenom: "required",
            ddnaissance: "required"
        },
        messages: {
            nom: "Veuillez saisir le nom",
            prenom: "Veuillez saisir le prénom",
            ddnaissance: "Veuillez saisir la date de naissance"
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `invalid-feedback` class to the error element
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });
});

$(document).ready(() => {
    $("#signupFormIntervenant").validate({
        rules: {
            nom: "required",
            prenom: "required",
            actif: "required",
            statut: "required",
            date_naissance: "required",
            ville: "required",
            tel: {
                phonePattern: true,
            },
            adresse: "required",
            cp: {
                required: true,
                minlength: 5,
                maxlength: 5,
                number: true,
            },
            diplome: "required",
            nationalite: "required",
        },
        messages: {
            nom: "Veuillez saisir le nom",
            prenom: "Veuillez saisir le prénom",
            date_naissance: "Veuillez saisir la date de naissance",
            tel: {
                phonePattern: "Format de numéro de téléphone invalide."
            },
            adresse: "Veuillez saisir l'adresse",
            cp: "Veuillez saisir le code postal",
            diplome: "Veuillez saisir le diplome",
            nationalite: "Veuillez saisir la nationnalité",
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `invalid-feedback` class to the error element
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
    });
});


$(document).ready(() => {
    $("#ajouterAnneeScolaire").validate({
        rules: {
            nom: "required",
        },
        messages: {
            nom: "Veuillez saisir le nom",
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `invalid-feedback` class to the error element
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
    });
});
