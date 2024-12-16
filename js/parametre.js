window.addEventListener('load', () => {
    let typeSelect = document.getElementById("typeUpdate");
    let valueInstructions = document.getElementById("valueInstructions");
    valueInstructions.style.display = "none";
    if(typeSelect.options[typeSelect.selectedIndex].value == "24" || typeSelect.options[typeSelect.selectedIndex].value == "25"){
        valueInstructions.style.display = "";
    }
    else{
        valueInstructions.style.display = "none";
    }


    typeSelect.addEventListener('change', () => {
        if(typeSelect.options[typeSelect.selectedIndex].value == "24" || typeSelect.options[typeSelect.selectedIndex].value == "25"){
            valueInstructions.style.display = "";
        }
        else{
            valueInstructions.style.display = "none";
        }
    });
});