// Gestions des divs à afficher ou non
let togg1 = document.getElementById("togg1");
let togg2 = document.getElementById("togg2");
let d1 = document.getElementById("d1");
let d2 = document.getElementById("d2");
togg1.addEventListener("click", () => {
  if(getComputedStyle(d1).display != "block"){
    d1.style.display = "block";
  } else {
    d1.style.display = "none";
  }
})

function togg(){
  if(getComputedStyle(d2).display != "block"){
    d2.style.display = "block";
  } else {
    d2.style.display = "none";
  }
};
togg2.onclick = togg;


// Si la checkbox est cochée, on modifie la bdd
let checkboxActivite = document.getElementById("#desactiveActivite");
checkboxActivite.addEventListener("change", () => {
    if(checkboxActivite.checked){
        // On modifie la bdd
        console.log("Activité désactivée");
        // On envoi un post pour désactiver l'activité
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "desactiverActivite.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("idActivite" + idActivite);

    }
});