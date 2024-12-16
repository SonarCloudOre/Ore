<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <title>Extranet - Association ORE</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

    <!-- Ancien CSS
    <link href="./styles/styles.css" rel="stylesheet" type="text/css" />-->

    <link href="./styles/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./styles/bootstrap/js/bootstrap.min.js"></script>

    <style type="text/css">
        .glyphicon {
            margin-right: 5px;
        }


        /*  Elements */
        ul.nav a:hover {
            background: linear-gradient(#4866EA, #0E37E7) !important;
            color: white !important;
        }

        nav {
            background: linear-gradient(#99CCFF, #359AFF) !important;
        }

        @media (min-width: 979px) {
            ul.nav li.dropdown:hover > ul.dropdown-menu {
                display: block;
            }
        }

        .form-group {
            width: 400px;
        }

    </style>
    <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico"/>
    <script type="text/javascript" src="http://association-ore.fr/extranet/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
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
            mode: "specific_textareas",
            editor_selector: /(mceEditor|mceRichText)/,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ]
        });
    </script>
</head>

<body onload="donner_focus('<?php echo $formulaire . "','" . $champ; ?>');">
<div id="page" class="container">
    <div id="entete">
        <center><img src="./images/logo.png" id="logo" alt="Tres union" title="logo tres union"/></center>
    </div>
	