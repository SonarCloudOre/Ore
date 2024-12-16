<?php
$hauteurLignes = 6;
$longueurLignes = 100;
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
$pdf->Cell(0, 10, utf8_decode('RECU POUR PAIEMENT'), 1, 1, 'C', 'bold', true);
$pdf->Ln();

// On change le format du texte
$pdf->SetFont('Arial', '', $tailleTexte);

// Adresse ORE
$pdf->Cell(0, $hauteurLignes, strtoupper(utf8_decode('Association ' . $nom[0]['NOM'])), 0, 1, 'L', '', false);
$pdf->Cell(0, $hauteurLignes, strtoupper(utf8_decode($adresse[0]['NOM'])), 0, 1, 'L', '', false);
$pdf->Cell(0, $hauteurLignes, strtoupper(utf8_decode($cp[0]['NOM'] . ' ' . $ville[0]['NOM'])), 0, 1, 'L', '', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($tel[0]['NOM']), 0, 1, 'L', '', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($email[0]['NOM']), 0, 1, 'L', '', false);

// Adresse du parent
$pdf->Cell(120, $hauteurLignes, '', 0, 0, 'L', '', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($uneInscription['prenom_inscription'] . ' ' . $uneInscription['nom_inscription']), 0, 1, 'L', '', false);
$pdf->Cell(120, $hauteurLignes, '', 0, 0, 'L', '', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($uneInscription['adresse_inscription']), 0, 1, 'L', '', false);
$pdf->Cell(120, $hauteurLignes, '', 0, 0, 'L', '', false);
$pdf->Cell(0, $hauteurLignes, utf8_decode($uneInscription['cp_inscription'] . ' ' . $uneInscription['ville_inscription']), 0, 1, 'L', '', false);
$pdf->Ln();

$pdf->Cell(0, $hauteurLignes, utf8_decode('Fait le ' . date('d/m/Y', time()) . ' à ' . $ville[0]['NOM']), 0, 1, 'L', '', false);
$pdf->Ln();
$pdf->Ln();

$hauteurLignes = 9;

$pdf->SetFillColor(226, 226, 226);
$pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Date du paiement :'), 1, 0, 'L', 'bold', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(date('d/m/y', strtotime($unReglement[0]['date_reglement']))), 1, 0, 'L', '', false);
$pdf->Ln();

$pdf->SetFillColor(226, 226, 226);
$pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Action :'), 1, 0, 'L', 'bold', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($uneActivite['nom_activite'])), 1, 0, 'L', '', false);
$pdf->Ln();

$pdf->SetFillColor(226, 226, 226);
$pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Type de paiement :'), 1, 0, 'L', 'bold', true);
$pdf->SetFillColor(255, 255, 255);
foreach ($lesTypesReglements as $unTypeReglement) {
    if ($unTypeReglement['ID'] == $unReglement[0]['type_reglement']) {
        $pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($unTypeReglement['NOM'])), 1, 0, 'L', '', false);
    }
}
$pdf->Ln();

// Si c'est un chèque
if ($unReglement[0]['type_reglement'] == 1) {

    $pdf->SetFillColor(226, 226, 226);
    $pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('N° de transaction :'), 1, 0, 'L', 'bold', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($unReglement[0]['num_cheque_reglement'])), 1, 0, 'L', '', false);
    $pdf->Ln();

    $pdf->SetFillColor(226, 226, 226);
    $pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Banque :'), 1, 0, 'L', 'bold', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($unReglement[0]['banque_reglement'])), 1, 0, 'L', '', false);
    $pdf->Ln();

}

$pdf->SetFillColor(226, 226, 226);
$pdf->Cell($longueurTitres, $hauteurLignes, utf8_decode('Montant du paiement :'), 1, 0, 'L', 'bold', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($unReglement[0]['montant_reglement']) . ' euros'), 1, 0, 'L', '', false);
$pdf->Ln();


$pdf->Ln();
$pdf->Ln();

$pdf->Cell(0, $hauteurLignes, utf8_decode('Pour faire valoir ce que de droit.'), 0, 1, 'L', '', false);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0, $hauteurLignes, utf8_decode('Association ' . $nom[0]['NOM']), 0, 1, 'R', '', false);


// On envoie le fichier généré
$pdf->Output();
?>