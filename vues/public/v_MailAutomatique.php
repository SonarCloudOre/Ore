<?php


//envoi d'un mail

$headers = "From: \"Association ORE\n";
$headers .= "Reply-To: association.ore@gmail.com\n";
$headers .= "X-Priority: 5\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

$mail = 'association.ore@gmail.com';


$subject = 'Intervenants ayant confirmé leurs présences pour cette semaine';

$message = '<p><center><img src="https://association-ore.fr/extranet/images/logo.png"></center></p>';

foreach ($tableaudate as $uneSeance) {

    $message .= '<h4>Intervenants ayant confirmé leurs présences pour les séances du ' . $uneSeance . '</h4><ul>';
    $heures = $pdo->getHeuresSeance($uneSeance);

    $i = 0;
    foreach ($heures as $uneHeure) {
        $unIntervenant = $pdo->recupUnIntervenant($uneHeure['ID_INTERVENANT']);
        $i++;
        $message .= '<li>' . $unIntervenant['NOM'] . ' ' . $unIntervenant['PRENOM'] . '</li>';
    }

    $message .= '</ul><p>Soit <b>' . $i . '</b> intervenant(s).</p>';

}

$result = mail($mail, $subject, $message, $headers);

?>