var selectDate = document.getElementById("selectDate");
var sendAbsencesButton = document.getElementById("notifyAbsents");
var pathname = window.location.pathname.split('/');
var path = window.location.origin + "/" + pathname[0] 

selectDate.addEventListener('change', ()=>{
    var selectInfo = selectDate.options[selectDate.selectedIndex].value;

    window.location.href = "index.php?choixTraitement=administrateur&action=saisirAbsencesStage&num=68"+"&date="+selectInfo;
    selectDate.options[selectDate.options.selectedIndex].selected = true;
})


sendAbsencesButton.addEventListener('click', async () => {
    var email = document.getElementById("emailAbsentsAdresses");
    var names = document.getElementById("names").value;
    var message = document.getElementById("messageAbsents");
    var emailUrl = path + "/index.php?choixTraitement=administrateur&action=EnvoyerMailStage";

    const data = new FormData();
        
    data.append('subject',"Notification d'absence de votre enfant au stage");
    
    var emails = email.value.split(',');
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

    
    for(let i=0; i<emails.length; i++){
        var newMessage = message.value.replace("[NOM PRENOM]",noms[i]);
        data.append('recipient',emails[i]);
        data.append('message',newMessage);

        await fetch(emailUrl, {
            method: 'POST',
            body: data
          }) 
            .then(response => response.json())
            .then(data => {
              // Handle the response data
            })
            .catch(error => {
              // Handle any errors
              console.error('Error:', error);
            });
    }
})

