// Form Wizard

$(document).ready(() => {
    setTimeout(function () {
        $("#smartwizard").smartWizard({
            selected: 0,
            transitionEffect: "fade",
            toolbarSettings: {
                toolbarPosition: "none",
            },
        });


        // External Button Events
        $("#reset-btn").on("click", function () {
            // Reset wizard
            $("#smartwizard").smartWizard("reset");
            return true;
        });

        $("#prev-btn").on("click", function () {
            // Navigate previous
            $("#smartwizard").smartWizard("prev");
            return true;
        });

        $("#next-btn").on("click", function () {


            if (document.URL.includes("step-1")) {
                if ($("input[name='nom']").valid() && $("input[name='prenom']").valid() && $("#date_naissance").valid()) {
                    console.log('valid');
                    $("#smartwizard").smartWizard("next");
                    console.log('valid');
                    return true;
                } else {
                    console.log('not valid');
                }
            } else if (document.URL.includes("step-2")) {
                if ($("input[name='annee']").valid() && $("input[name='prof_principal']").valid() && $("input[name='specialitesA[]']").valid()) {
                    $("#smartwizard").smartWizard("next");
                    console.log('valid');
                    return true;
                } else {
                    console.log('not valid');
                }
            } else if (document.URL.includes("step-3")) {
                if ($("input[name='responsable_legal']").valid() && $("input[name='tel_parent2']").valid() && $("input[name='tel_parent3']").valid() && $("input[name='tel_parent']").valid() && $("input[name='adresse']").valid() && $("input[name='cp']").valid() && $("input[name='ville']").valid()) {
                    $("#smartwizard").smartWizard("next");
                    console.log('valid');
                    $("form[name='signupForm']").submit();
                    console.log('send');
                    return true;
                } else {
                    console.log('not valid');
                }
            }
        });


        $("#smartwizardIntervenant").smartWizard({
            selected: 0,
            transitionEffect: "fade",
            toolbarSettings: {
                toolbarPosition: "none",
            },
        });

        // External Button Events
        $("#reset-btn2").on("click", function () {
            // Reset wizard
            $("#smartwizardIntervenant").smartWizard("reset");
            return true;
        });

        $("#prev-btn2").on("click", function () {
            // Navigate previous
            $("#smartwizardIntervenant").smartWizard("prev");
            return true;
        });

        $("#next-btn2").on("click", function () {


            if (document.URL.includes("step-1")) {
                if ($("input[name='nom']").valid() && $("input[name='prenom']").valid() && $("input[name='date_naissance']").valid() && $("input[name='lieu_naissance']").valid() && $("input[name='nationalite']").valid() && $("input[name='email']").valid() && $("input[name='tel']").valid() && $("input[name='adresse']").valid() && $("input[name='cp']").valid() && $("input[name='ville']").valid() && $("input[name='numsecu']").valid() && $("input[name='password']").valid()) {
                    console.log('valid');
                    $("#smartwizardIntervenant").smartWizard("next");
                    console.log('valid');
                    return true;
                } else {
                    console.log('not valid');
                }
            } else if (document.URL.includes("step-2")) {
                if ($("input[name='diplome']").valid()) {
                    $("#smartwizardIntervenant").smartWizard("next");
                    console.log('valid');
                    return true;
                } else {
                    console.log('not valid');
                }
            } else if (document.URL.includes("step-3")) {
                if ($("input[name='compte']").valid() && $("input[name='iban']").valid() && $("input[name='bic']").valid() && $("input[name='banque']").valid()) {
                    $("#smartwizardIntervenant").smartWizard("next");
                    console.log('valid');
                    $("form[name='signupFormIntervenant']").submit();
                    console.log('send');
                    return true;
                } else {
                    console.log('not valid');
                }
            }
        });


    }, 2000);
});
