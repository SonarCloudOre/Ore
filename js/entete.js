window.addEventListener('load', () => {
    var buttonSmsIntervenants = document.getElementById("linkI");
    var buttonSmsParents = document.getElementById("linkP");
    var buttonSmsEleves = document.getElementById("linkE");
    var buttonSmsAdherents = document.getElementById("linkA");
    var buttonSmsTous = document.getElementById("linkT");
    var buttonSmsCustom = document.getElementById("linkC");
    

    var modalIntervenants = new bootstrap.Modal(document.getElementById("smsIntervenants"));
    var modalEleves = new bootstrap.Modal(document.getElementById("smsEleves"));
    var modalParents = new bootstrap.Modal(document.getElementById("smsParents"));
    var modalAdherents = new bootstrap.Modal(document.getElementById("smsAdherents"));
    var modalTous = new bootstrap.Modal(document.getElementById("smsTous"));
    var modalCustom = new bootstrap.Modal(document.getElementById("smsCustom"));



    buttonSmsIntervenants.addEventListener('click', () => {
        
        modalIntervenants.show();
    })

    buttonSmsEleves.addEventListener('click', () => {
        modalEleves.show();
    })

    buttonSmsParents.addEventListener('click', () => {
        modalParents.show();
    })

    buttonSmsAdherents.addEventListener('click', () => {
        modalAdherents.show();
    })

    buttonSmsTous.addEventListener('click', () => {
        modalTous.show();
    })

    buttonSmsCustom.addEventListener('click', () =>{
        modalCustom.show();
    })
})



    
