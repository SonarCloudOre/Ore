<?php
$hauteurLignes = 6;
$longueurLignes = 80;
$longueurTitres = 50;
$tailleTexte = 12;

// On invoque le module PDF
require('fpdf/fpdf.php');
$pdf = new FPDF();

// On crée une page
$pdf->AddPage();

// On change le format du texte
$pdf->SetFillColor(226, 226, 226);
$pdf->SetFont('Arial', 'B', 18);

// Titre
$pdf->Cell(0, 10, utf8_decode('RECU POUR PAIEMENT'), 1, 1, 'C', true);
$pdf->Ln();

// On change le format du texte
$pdf->SetFont('Arial', '', $tailleTexte);

// Adresse ORE
$pdf->Cell(0, $hauteurLignes, utf8_decode('Association ' . $nom[0]['NOM']), 0, 1, 'L', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($adresse[0]['NOM']), 0, 1, 'L', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($cp[0]['NOM'] . ' ' . $ville[0]['NOM']), 0, 1, 'L', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($tel[0]['NOM']), 0, 1, 'L', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($email[0]['NOM']), 0, 1, 'L', false);

// Adresse du parent
$pdf->Cell(120, $hauteurLignes, '', 0, 'L', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($uneInscription['NOM_ELEVE_STAGE']), 0, 1, 'L', false);
$pdf->Cell(120, $hauteurLignes, '', 0, 'L', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($uneInscription['ADRESSE_ELEVE_STAGE']), 0, 1, 'L', false);
$pdf->Cell(120, $hauteurLignes, '', 0, 'L', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($uneInscription['CP_ELEVE_STAGE'] . ' ' . $uneInscription['VILLE_ELEVE_STAGE']), 0, 1, 'L', false);
$pdf->Ln();

$pdf->Cell(0, $hauteurLignes, utf8_decode('Fait le ' . date('d/m/Y', time()) . ' à ' . $ville[0]['NOM']), 0, 1, 'L', false);
$pdf->Ln();
$pdf->Ln();

$hauteurLignes = 9;


$pdf->SetFillColor(226, 226, 226);
$pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Action :'), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($stageSelectionner['NOM_STAGE'])), 1, 0, 'L', false);
$pdf->Ln();

$pdf->SetFillColor(226, 226, 226);
$pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Type de paiement :'), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($uneInscription['PAIEMENT_INSCRIPTIONS'])), 1, 0, 'L', false);
$pdf->Ln();

// Si c'est un chèque
if ($uneInscription['PAIEMENT_INSCRIPTIONS'] == 'CHEQUE') {

    $pdf->SetFillColor(226, 226, 226);
    $pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('N° de chèque :'), 1, 0, 'L', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($uneInscription['NUMTRANSACTION'])), 1, 0, 'L', false);
    $pdf->Ln();

    $pdf->SetFillColor(226, 226, 226);
    $pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Banque :'), 1, 0, 'L', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($uneInscription['BANQUE_INSCRIPTION'])), 1, 0, 'L', false);
    $pdf->Ln();

}

$pdf->SetFillColor(226, 226, 226);
$pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Montant du paiement :'), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($uneInscription['MONTANT_INSCRIPTION']) . ' euros'), 1, 0, 'L', false);
$pdf->Ln();

$pdf->SetFillColor(226, 226, 226);

$eleveslist = utf8_decode(stripslashes($uneInscription['NOM_ELEVE_STAGE']) . ' ' . stripslashes($uneInscription['PRENOM_ELEVE_STAGE']) . "\n");
foreach ($LesInscriptionsFratries as $unEleve) {
    $eleveslist .= utf8_decode(stripslashes($unEleve['NOM_ELEVE_STAGE']) . ' ' . stripslashes($unEleve['PRENOM_ELEVE_STAGE']) . "\n");
}

$nbLignesEleves = substr_count($eleveslist, "\n");

$hauteurCellules = $nbLignesEleves * $hauteurLignes;

$pdf->Cell($longueurTitres, $hauteurCellules, utf8_decode('Elève(s) :'), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell($longueurLignes, $hauteurLignes, utf8_decode($eleveslist), 1, 'L', false);

$pdf->Ln();

$pdf->SetFillColor(226, 226, 226);

$infoslist = "";

if (isset($infos['SOUTIEN'])) {
    if ($infos['SOUTIEN'] == 1) {
        $infoslist .= "Soutien \n";
    }
}
if (isset($infos['ADESION_CAF'])) {
    if ($infos['ADESION_CAF'] == 1) {
        $infoslist .= "Adhésion CAF \n";
    }
}
if (isset($infos['ADESION_TARIF_PLEIN'])) {
    if ($infos['ADESION_TARIF_PLEIN'] == 1) {
        $infoslist .= "Adhésion \n";
    }
}
if (isset($infos['STAGE'])) {
    if ($infos['STAGE'] == 1) {
        $infoslist .= "Stage \n";
    }
}

if (isset($infos['SORTIE_STAGE'])) {
    if ($infos['SORTIE_STAGE'] == 1) {
        $infoslist .= "Sortie Stage \n";
    }
}

if (isset($infos['DONS'])) {
    if ($infos['DONS'] == 1) {
        $infoslist .= "Dons \n";
    }
}
if ($infoslist == "") {
    $infoslist = "Aucune \n";
}

$nbLignesInfos = substr_count($infoslist, "\n");

$hauteurCellules = $nbLignesInfos * $hauteurLignes;

$pdf->Cell($longueurTitres, $hauteurCellules, utf8_decode('Info(s) :'), 1, 0, 'L', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell($longueurLignes, $hauteurLignes, utf8_decode($infoslist), 1, 'L', false);

$pdf->Ln();

$pdf->Ln();
$pdf->Ln();

$pdf->Cell(0, $hauteurLignes, utf8_decode('Pour faire valoir ce que de droit.'), 0, 1, 'L', false);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0, $hauteurLignes, utf8_decode('Association ' . $nom[0]['NOM']), 0, 1, 'R', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode('[TAMPON]'), 0, 1, 'R', false);


// On envoie le fichier généré
$pdf->Output();
?>