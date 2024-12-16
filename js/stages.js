import {Send} from './sms.js';
import { showError, showSuccess } from './utils.js';
var pathname = window.location.pathname.split('/');
var path = window.location.origin + "/" + pathname[1];

window.addEventListener('load', () => {
    
    var buttonCommunicateStage = document.getElementById("communicateStage");
    var buttonAbsenceNotif = document.getElementById("smsAbsents");
    
    buttonCommunicateStage.addEventListener('click',displayCommunicationModal);


    if(buttonAbsenceNotif != null){
        buttonAbsenceNotif.addEventListener('click',displayAbsent);
    }
    
    var communicationModal = document.getElementById("communicationModal");

    var telephones = document.getElementById("telephones");
    var message = document.getElementById("messageBody");
    var attachmentSrc = document.getElementById("attach");

    var buttonSendStage = document.getElementById("sendStageButton");
    var buttonSendMailStage = document.getElementById("sendMailStageButton");

    let attachFile = "";
    buttonSendStage.addEventListener('click', async () => {
        if(attachmentSrc.style.display != "none"){
            attachFile = await getFileFromServer(attachmentSrc.src);
        }
        await Send(telephones.value,message.value,attachFile);
        communicationModal.scrollTo(0,0);
    });
    

    buttonSendMailStage.addEventListener('click',async () => {
        var email = document.getElementById("emailadresses").value;
        
        
        var url = path + "/index.php?choixTraitement=administrateur&action=EnvoyerMailStage";

        var affiche = document.getElementById("attach");
        const data = new FormData();
        
        
        
        data.append('subject',document.getElementById("nomStage").value);
        data.append('message',message.value);
        
        email = email.split(',');
        data.append('recipient',email);
        
        if(affiche.style.display != "none"){
            data.append('attachment',new URL(affiche.src).pathname);
        }
        
        await fetch(url, {
            method: 'POST',
            headers: {
                mode: "no-cors",
            },
            body: data,
            }) 
            .then(response => response.text())
            .then(response => {
                if(response == 'true'){
                    showSuccess("L'e-email a bien été envoyé !");
                }
                else{
                    showError(response);
                }
            })
    });   
});


/**
 * Manage all the display of the modal (select and checkbox choices, etc)
 */
function displayCommunicationModal(){
    $("#communicationModal").modal("show");
    $("#communicationModal").prependTo("body");
    resetModal();

    let typesStage = JSON.parse(document.getElementById("hiddenTypes").value);
    let communicationTargetSelect = document.getElementById("stageTarget");
    let checkboxesContainer = document.getElementById("checkboxes");

    communicationTargetSelect.value = "default";
    

    communicationTargetSelect.addEventListener('change', () => {
        let choosen = communicationTargetSelect.options[communicationTargetSelect.selectedIndex].value;
        let emailArea = document.getElementById("emailadresses");
        let telephoneArea = document.getElementById("telephones");
        let inputs = [];

        switch(choosen){
            case "parents":
                checkboxesContainer.innerHTML = '';
                emailArea.value = document.getElementById("hiddenEmailAnnee").value;
                emailArea.readOnly = true;

                telephoneArea.value = document.getElementById("hiddenTelephoneAnnee").value;
                telephoneArea.readOnly = true;

                if(typesStage["annee"].length > 0){
                    typesStage["annee"].forEach(element => {
                        let input = createCheckbox("checkbox",element['NOM']+"Checkbox",element["ID"],element["NOM"],element,inputs,true);
                        inputs.push(input[0]);

                        checkboxesContainer.appendChild(input[0]);
                        checkboxesContainer.appendChild(input[1]);
                    });
                }
                break;

            case "inscrits":
                resetModal();
                checkboxesContainer.innerHTML = '';

                emailArea.value = document.getElementById("hiddenEmailInscrit").value;
                emailArea.readOnly = true;
        
                telephoneArea.value = document.getElementById("hiddenTelephoneInscrit").value;
                telephoneArea.readOnly = true;

                
                if(typesStage["inscrit"].length > 0){
                    typesStage["inscrit"].forEach(element => {
                        let input = createCheckbox("checkbox",element['NOM']+"Checkbox",element["ID"],element["NOM"],element,inputs,false);
                        inputs.push(input[0]);

                        checkboxesContainer.appendChild(input[0]);
                        checkboxesContainer.appendChild(input[1]);
                    });
                }
                break;

            case "default":
                checkboxesContainer.innerHTML = '';
                resetModal();
                break;
        }
    });
}



/**
 * Reset the modal with all the inputs to nothing
 */
function resetModal(){
    let imgDisplay = document.getElementById("attach");
    let emailArea = document.getElementById("emailadresses");
    let telephoneArea = document.getElementById("telephones");

    let message = document.getElementById("messageBody");


    emailArea.value = "";
    telephoneArea.value = "";
    emailArea.readOnly = false;
    telephoneArea.readOnly = false;
    
    document.getElementById("checkboxes").innerHTML = '';

    imgDisplay.src = "";
    imgDisplay.style.display = "none";

    message.value = "";
}


/**
 * Check if the pub checkbox is checked or not and display the correct informations
 */
function checkValue(element,input,inputs){
    let imgDisplay = document.getElementById("attach");
    
    let messageArea = document.getElementById("messageBody");

    let nomAffiche = document.getElementById("afficheNom");


    if(input.checked){
        inputs.forEach(element => {
            if(element != input){
                if(element.checked){
                    element.checked = false;
                }
            }
        });
        let dates = document.getElementById("dates").value;
        dates = dates.split(",");
        let message = element["VALEUR"].replace('[DATE_DEBUT]',dates[0]);
        
        message = message.replace('[DATE_FIN]',dates[1]);
        message = message.replace('[DESCRIPTION]',document.getElementById("description").value);
        message = message.replace('[LIEN]',document.getElementById("lienInscription").value);
        

        messageArea.value = message;
        messageArea.readOnly = true;
       
        
        if(input.id == "Pub stageCheckbox"){
            imgDisplay.src = "./images/afficheStage/" + nomAffiche.value;
            imgDisplay.style.display = "";

        }
        else{
            imgDisplay.src = "";
            imgDisplay.style.display = "none";
        }
    }
    else{
        imgDisplay.src = "";
        imgDisplay.style.display = "none";
        messageArea.value = "";
        messageArea.readOnly = false;
    }
}


function createCheckbox(type,id,name,content,element,inputs,annee){
    let i = document.createElement("input");
    i.type = type;
    i.id = id
    i.name = name;
    i.style.marginRight = "5px";
    i.addEventListener('change',() => checkValue(element,i,inputs,annee));

    let iLabel = document.createElement("label");
    iLabel.innerText = content;
    iLabel.name = name;
    iLabel.style.marginRight = "10px";

    return [i,iLabel]
}


async function getFileFromServer(path){
    const response = await fetch(path);
    const blob = await response.blob();
    
    return new Promise((resolve, reject) => {
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onload = function() {
            var dataUrl = reader.result;
            var img = new Image();
            img.src = dataUrl;
            img.onload = async function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    canvas.toBlob(function(blob) {
                        const newFile = new File([blob], "affiche.jpg",{
                            type: "image/jpeg",
                            lastModified: Date.now()
                        });
                        resolve(newFile);
                    }, 'image/jpeg', 0.7);        
            };
        };
    });
}

function displayAbsent(){
    $("#absentsModal").modal("show");
    $("#absentsModal").prependTo("body");
}



    
    