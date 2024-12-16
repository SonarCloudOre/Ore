let currentModal = null;

/**
 * Baisse la résolution de l'image en fonction de max_width et de max_height sans déformer l'image.
 * @param {File} file L'image à modifier
 * @param {Integer} max_width La largeur maximale de l'image
 * @param {Integer} max_height La hauteur maximale de l'image
 * @returns {Promise<File>} Un fichier de la nouvelle image 
 */
export function reduceImageResolution(file,max_width,max_height) {
    // On vérifie que le fichier soit bien une image soit PNG soit JPEG
    if(file.type !== 'image/jpeg' && file.type !== 'image/png'){
        throw new Error("Le format de fichier est incorrect, veuillez choisir un fichier JPEG ou PNG !");
    }
    else{
        return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.onload = function(event) {
            const img = new Image();

            img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            let width = img.width;
            let height = img.height;

            // Réduire la taille de l'image si elle dépasse la dimension maximale
            if (width > max_width || height > max_height) {

                // On calcule le ratio pour éviter de déformer l'image
                const aspectRatio = width / height;

                if (width > height) {
                    width = max_width;
                    height = width / aspectRatio;
                } 
                else {
                    height = max_height;
                    width = height * aspectRatio;
                }
            }

            // Définir les dimensions du canvas
            canvas.width = width;
            canvas.height = height;

            // Dessiner l'image sur le canvas avec la nouvelle taille
            ctx.drawImage(img, 0, 0, width, height);

            // Convertir le canvas en Blob
            canvas.toBlob((blob) => {
                // Créer un nouveau File avec le Blob
                const newFile = new File([blob], file.name, {
                type: file.type,
                lastModified: Date.now()
                });
                resolve(newFile);
            }, file.type, 0.7); // 0.7 est la qualité de compression de l'image
        };

            img.src = event.target.result;
    };
        reader.readAsDataURL(file);
        });
    }
} 



// Gestion d'alerte personnalisée
/**
 * Affiche un message d'information concernant l'éxecution d'un programme
 * @param {string} message  Le message à afficher
 * @param {string} type Le type de message (success,info,error) 
 */
async function showAlert(message, type,timeout = null) {
    if(currentModal != null){
        var errorBox = $('.errorBox', currentModal);

        var msgDiv = document.createElement('div');
        msgDiv.classList.add('custom-alert');
        msgDiv.classList.add(type);
        msgDiv.innerText = message;

        errorBox[0].appendChild(msgDiv);

        if(timeout > 0 || timeout != null){
            await setTimeout(function(){
                errorBox[0].removeChild(msgDiv);
                $('#smsIntervants').hide();
            },timeout)
        }
    }   
  }



  export async function showError(message) {
    await showAlert(message, 'error',3000);
  }

  export async function showSuccess(message) {
    await showAlert(message, 'success',3000);
  }

  export async function showInfo(message) {
    await showAlert(message, 'info',3000);
  }



function changeCurrentModal(modal){
    currentModal = modal;
}


window.addEventListener("load", () => {
    let modalIntervenants = document.getElementById("smsIntervenants");
    let modalParents = document.getElementById("smsParents");
    let modalEleves = document.getElementById("smsEleves");
    let modalTous = document.getElementById("smsTous");
    let modalCustom = document.getElementById("smsCustom");
    let communicationModal = document.getElementById("communicationModal");

    $("#smsIntervenants").on("shown.bs.modal",function(){
        changeCurrentModal(modalIntervenants);
    })

    $("#smsParents").on("shown.bs.modal",function(){
        changeCurrentModal(modalParents);
    })

    $("#smsEleves").on("shown.bs.modal",function(){
        changeCurrentModal(modalEleves);
    })

    $("#smsTous").on("shown.bs.modal",function(){
        changeCurrentModal(modalTous);
    })
    $("#smsCustom").on("shown.bs.modal",function(){
        changeCurrentModal(modalCustom);
    })
    $("#communicationModal").on("shown.bs.modal", function(){
        changeCurrentModal(communicationModal);
    })
});