<?php
$hauteurLignes = 7;
$longueurLignes = 63;
$tailleTexte = 11;

// On invoque le module PDF
require('fpdf/fpdf.php');
$pdf = new FPDF();

// On crée une page
$pdf->AddPage();

// On change le format du texte
$pdf->SetFillColor(226, 226, 226);
$pdf->SetFont('Arial', 'B', 18);

// Titre
$pdf->Cell($longueurLignes * 3, 10, utf8_decode(stripslashes($activiteSelectionner['nom_activite']) . ' (' . date('d/m/Y', time()) . ')'), 1, 1, 'C', 'bold', true);
$pdf->Ln();

// On change le format du texte
$pdf->SetFont('Arial', '', $tailleTexte);

$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);

// Entête du tableau
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode('NOM'), 1, 0, 'C', 'bold', true);
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode('PRENOM'), 1, 0, 'C', 'bold', true);
$pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode('SIGNATURE'), 1, 0, 'C', 'bold', true);
$pdf->Ln();

// On change le format du texte
$pdf->SetTextColor(0, 0, 0);

// On écrit la liste des inscrits
$nbInscriptions = 0;
foreach ($lesInscriptions as $uneInscription) {

    $pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($uneInscription['nom_inscription'])), 1, 0, 'L', '', false);
    $pdf->Cell($longueurLignes, $hauteurLignes, utf8_decode(stripslashes($uneInscription['prenom_inscription'])), 1, 0, 'L', '', false);
    $pdf->Cell($longueurLignes, $hauteurLignes, '', 1, 0, 'L', '', false);
    $pdf->Ln();

    $nbInscriptions++;
}

// Si il n'y a aucune inscription, on écrit 20 lignes vides, sinon juste 5
if ($nbInscriptions == 0) {
    $nbLignesVides = 20;
} else {
    $nbLignesVides = 5;
}

// On ajoute 5 lignes vides
for ($i = 0; $i < $nbLignesVides; $i++) {

    $pdf->Cell($longueurLignes, $hauteurLignes, '', 1, 0, 'L', '', false);
    $pdf->Cell($longueurLignes, $hauteurLignes, '', 1, 0, 'L', '', false);
    $pdf->Cell($longueurLignes, $hauteurLignes, '', 1, 0, 'C', '', false);
    $pdf->Ln();

}

// On envoie le fichier généré
$pdf->Output();
?>