<?php
$pdf->AddPage();
foreach ($LesEleves as $unEleve) {
    if ($unEleve['PHOTO'] == "" or $unEleve['PHOTO'] == NULL) {
        $photo = "AUCUNE.jpg";
    } else {
        $photo = $unEleve['PHOTO'];
    }
    $string_a_coder = $unEleve['CODEBARRETEXTE'];
    $nomPrenom = $unEleve['NOM'] . ' ' . $unEleve['PRENOM'];

    $posX = $pdf->getX();
    $posY = $pdf->getY();
    $pdf->SetXY($posX, $posY + 10);
    $pdf->Image('photosEleves/' . $photo, null, null, 40, 40, 'jpg');

    $posX = $pdf->getX();
    $posY = $pdf->getY();
    $pdf->SetXY($posX + 42, $posY - 40);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(80, 10, utf8_decode($nomPrenom), 0, 'L');


    $posX = $pdf->getX();
    $posY = $pdf->getY();
    $pdf->SetXY($posX + 110, $posY - 5);
    $pdf->Image('images/logoCarte.png', null, null, 60, 30, 'png');

    $posX = $pdf->getX();
    $posY = $pdf->getY();
    $pdf->SetXY($posX - 70, $posY - 23);
    $pdf->Image('http://www.association-ore.fr/extranet/include/generation.php?code=' . $string_a_coder . '', null, null, 50, 20, 'png');


    $pdf->Ln();
}


?>