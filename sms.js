import {reduceImageResolution} from './utils.js';
import { showError } from './utils.js';
import { showInfo } from './utils.js';
import { showSuccess } from './utils.js';

const SMSEAGLE_IP = "109.190.124.157";
const API_KEY = "V6e6UUtu2CGEJmafTo6SUxdb4tUdmWJM";

let sendIntervenantsButton = document.getElementById("sendIntervenants");
let sendParentsButton = document.getElementById("sendParents");
let sendElevesButton = document.getElementById("sendEleves");
let sendTousButton = document.getElementById("sendTous");
let sendCustomButton = document.getElementById("sendCustom");
let serverStatus = document.getElementById("server-status");
let serverStatusDiv = document.getElementById("server-status-container");

sendIntervenantsButton.addEventListener("click", async () => {

    let messageIntervenants = document.getElementById("message_Intervenants").value;
    let telephonesIntervenants = document.getElementById("Clipboard_Intervenant").value;
    let attachIntervenants = document.getElementById("attach_Intervnants");

    await Send(telephonesIntervenants,messageIntervenants,attachIntervenants.files[0])

});

sendElevesButton.addEventListener("click", async () => {
    let messageEleves = document.getElementById("message_Eleves").value;
    let teleponesEleves = document.getElementById("Clipboard_Eleves").value;
    let attachEleves = document.getElementById("attach_Eleves");

    await Send(teleponesEleves,messageEleves,attachEleves.files[0])}
);

sendParentsButton.addEventListener("click",async () => {
    let telephonesParents = document.getElementById("Clipboard_Parents").value;
    let messageParents = document.getElementById("message_Parents").value;
    let attachParents = document.getElementById("attach_Parents");

    await Send(telephonesParents,messageParents,attachParents.files[0])
});

sendTousButton.addEventListener("click", async () => {
    let messageTous = document.getElementById("message_Tous").value;
    let telephonesTous = document.getElementById("Clipboard_Tous").value;
    let attachTous = document.getElementById("attach_Tous");

    await Send(telephonesTous,messageTous,attachTous.files[0])
});


sendCustomButton.addEventListener('click', async () =>{
    let messageCustom = document.getElementById("message_Custom").value;
    let telephonesCustom = document.getElementById("Clipboard_Custom").value;
    let attachCustom = document.getElementById("attach_Custom");

    await Send(telephonesCustom,messageCustom,attachCustom.files[0]);
})



/**
 * Envoi un SMS par défaut ou un MMS si une pièce jointe a été ajoutée
 * @param {string} telephones 
 * @param {string} message 
 * @param {File} attachment 
 */
export async function Send(telephones,message,attachment){
    // Vérifie si la liste des numéros est vide
    if(telephones != ""){
        // Vérifie si le message est vide
        if(message != ""){
            // Valid numbers XXXXXXXXXX
            message += "\n\nCe message est un message automatique et provient de l'association ORE - 03 80 48 23 96";
            // On envoie un SMS
            try{
                await sendSMS(telephones,message);
                if(!attachment){
                }
                else{
                    await sendMMS(telephones,attachment);
                }
                await showSuccess("Le message a bien été envoyé au serveur !");
            }
            catch(error){
                await showError(error.message);
            }                    
        }
        else{
            await showError("Veuillez entrer un message !");
        }
    }
    else{
        await showError("Aucun contact n'a été sélectionné !");
    }
    
}


/**
 * Envoie un SMS
 * @param {string} telephones Le ou les numéros de téléphones récepteur du message (doit être séparé par des virgules et au format 0000000000)
 * @param {string} message Le message a envoyé 
 */
async function sendSMS(telephones,message){
    let url = `https://${SMSEAGLE_IP}/jsonrpc/sms`;

    // Création de la requête
    let data = {
        method: "sms.send_sms",
        params: {
            access_token: API_KEY,
            to: telephones,
            message: message,
            send_before: "21:00:00",
            send_after: "10:00:00"
    }};

    let res = '';
    telephones = telephones.split(',');
    telephones.forEach(async (element) => {
        data['params']['to'] = element;
    
        await fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            mode:'no-cors',
            body: JSON.stringify(data)
          })
    });
}



/**
 * Envoie un MMS séparé en deux. Un SMS contenant le message et un MMS contenant uniquement la pièce jointe.
 * @param {string} telephones Le ou les numéros de téléphones récepteur du message (doit être séparé par des virgules et au format 0000000000)
 * @param {string} message Le message a envoyé 
 * @param {*} attachment La pièce jointe a envoyé
 */
async function sendMMS(telephones,attachment){
    let url = `https://${SMSEAGLE_IP}/jsonrpc/sms`;
    try{
        // Reduit la résolution de l'image afin de ne pas dépasser la limite des MMS.
        await reduceImageResolution(attachment,450,450).then(function(compressedImage){
            attachment = compressedImage;
        });
        
        const reader = new FileReader();                            
        reader.readAsDataURL(attachment);
        reader.onload =  async () => {
            const result = reader.result;
            const fileData = result.split(',')[1];
            let data = {
                method: "sms.send_sms",
                params: {
                    access_token: API_KEY,
                    to: telephones,
                    message_type: "mms",
                    send_after: "10:00:00",
                    attachments: [
                        {
                            content_type: attachment.type,
                            content: fileData
                        }
                    ]
                }
            }
            
            // On éxecute la requête
            fetch(url, {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                mode: "no-cors",
                body: JSON.stringify(data)
            })
        }
    }
    catch(error){
        await showError(error.message);
     }
}


try{
    document.getElementById("notifyAbsents").addEventListener('click',async () => {
        var tels = document.getElementById("telephoneNumbers").value;
        var names = document.getElementById("names").value;
        var message = document.getElementById("messageAbsents").value;
     
        var telephones = tels.split(',');
     
        var fullnames = names.split(',');
     
        var noms = [];
     
        fullnames.forEach(element => {
         if(element != "undefined"){
             noms.push(element.replace(";"," "));
         }   
         else{
             noms.push("");
         }
     
        });
     
     
        for(let i=0; i<=telephones.length; i++){
         var newMessage = message.replace("[NOM PRENOM]",noms[i]);
         await Send(telephones[i],newMessage,null);
        }
        
     });
}
catch(error){
    showError(error.message);
}



async function getServerStatus(){
    var url = "https://109.190.124.157/";

    let res = '';
    await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        mode:'no-cors',
      })
    .then(() => res = "success")
    .catch((error) => {
        console.error(error); 
        res = "failed"
    });

    if(res == "failed"){
        serverStatus.innerText = 'Le serveur est indisponible !';
        serverStatusDiv.style.backgroundColor = "red";
        return;
    }
    else{
        serverStatus.innerText = "Le serveur est disponible !";
        serverStatusDiv.style.backgroundColor = "green";
    }
}



window.addEventListener('load',() => {
    document.getElementById("sms-menu").addEventListener('click',() => {
        getServerStatus();
    })
});