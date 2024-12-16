function date_heure(id) {
    date = new Date;
    annee = date.getFullYear();
    moi = date.getMonth();
    mois = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    j = date.getDate();
    jour = date.getDay();
    jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
    h = date.getHours();
    if (h < 10) {
        h = "0" + h;
    }
    m = date.getMinutes();
    if (m < 10) {
        m = "0" + m;
    }
    s = date.getSeconds();
    if (s < 10) {
        s = "0" + s;
    }
    resultat = '<center><span class="heure" style="font-size:30px">' + h + ':' + m + ':' + s + '</span><br><span class="date" style="font-size:12px">' + jours[jour] + ' ' + j + ' ' + mois[moi] + ' ' + annee + '</span></center>';
    document.getElementById(id).innerHTML = resultat;
    setTimeout('date_heure("' + id + '");', '1000');
    return true;
}

function imprimer() {
    document.getElementById('entete').style.display = 'none';
    document.getElementById('pied').style.display = 'none';
    window.print()
}


function imprime_zone(titre, obj) {
// Définie la zone à imprimer
    var zi = document.getElementById(obj).innerHTML;
// Ouvre une nouvelle fenetre
    var f = window.open("", "ZoneImpr", "height=500, width=600,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");
// Définit le Style de la page
    f.document.body.style.color = '#000000';
    f.document.body.style.backgroundColor = '#FFFFFF';
    f.document.body.style.padding = "10px";
// Ajoute les Données
    f.document.title = titre;
    f.document.body.innerHTML += " " + zi + " ";
// Imprime et ferme la fenetre
    f.window.print();
    f.window.close();
    return true;
}


/*
tinymce.init({

    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
mode : "specific_textareas",
    editor_selector : /(mceEditor|mceRichText)/,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});
*/
