
// Permet de cocher le bouton radio "datePrecise" lorsqu'on clique sur le label
document.addEventListener('DOMContentLoaded', function() {
    var label = document.querySelector('label[for="datePrecise"]');
    label.addEventListener('click', function() {
        var radioBtn = document.getElementById('datePrecise');
        radioBtn.checked = true;
    });
});

// Permet de cocher le bouton radio "plusieursJoursMois" lorsqu'on clique sur le label
document.addEventListener('DOMContentLoaded', function() {
    var label = document.querySelector('label[for="plusieursJoursMois"]');
    label.addEventListener('click', function() {
        var radioBtn = document.getElementById('plusieursJoursMois');
        radioBtn.checked = true;
    });
});

// Permet de cocher le bouton radio "stages" lorsqu'on clique sur le label
document.addEventListener('DOMContentLoaded', function() {
    var label = document.querySelector('label[for="stages"]');
    label.addEventListener('click', function() {
        var radioBtn = document.getElementById('stages');
        radioBtn.checked = true;
    });
});



