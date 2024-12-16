<?php
foreach ($lesClasses as $uneClasse) {
    if ($uneClasse['ID'] == $classeSelectionner) {
        $pdf->AddPage();
        $posX = $pdf->getX();
        $posY = $pdf->getY();
        $pdf->SetXY($posX + 40, $posY);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(100, 20, utf8_decode('CLASSE : ' . $uneClasse['NOM']), 0, 'C');
        $pdf->Ln();

        $classeEnCours = $uneClasse['ID'];
        $lesEleves = $pdo->recupTousEleves();
        $total = 0;
        foreach ($lesEleves as $unEleve) {
            $eleve = $unEleve['ID_ELEVE'];
            $string_a_coder = $unEleve['CODEBARRETEXTE'];

            if ($unEleve['PHOTO'] == "" or $unEleve['PHOTO'] == NULL) {
                $photo = "AUCUNE.jpg";
            } else {
                $photo = $unEleve['PHOTO'];
            }
            $nomPrenom = $unEleve['NOM'] . ' ' . $unEleve['PRENOM'];

            $annee = date("Y");
            $mois = date("m");
            if ($mois < 7) {
                $annee = $annee - 1;
            }
            $classe = $pdo->recupClasseUnEleve($annee, $eleve);
            if ($classeEnCours == $classe['ID_CLASSE']) {
                //$posX = $pdf->getX();
                //$posY = $pdf->getY();
                $pdf->SetX(4);
                $pdf->Image('photosEleves/' . $photo, null, null, 25, 25, 'jpg');
                $pdf->SetFont('Arial', 'B', 8);

                $posX = $pdf->getX();
                $posY = $pdf->getY();
                $pdf->SetXY($posX + 25, $posY - 25);
                $pdf->MultiCell(70, 25, utf8_decode($nomPrenom), 1, 'L');

                $posX = $pdf->getX();
                $posY = $pdf->getY();
                $pdf->SetXY($posX + 25 + 70, $posY - 25);
                $pdf->MultiCell(25, 25, '', 1, 'L');

                $posX = $pdf->getX();
                $posY = $pdf->getY();
                $pdf->SetXY($posX + 25 + 95, $posY - 25);
                $pdf->MultiCell(25, 25, '', 1, 'L');


                $posX = $pdf->getX();
                $posY = $pdf->getY();
                $pdf->SetXY($posX + 25 + 120, $posY - 25);
                $pdf->Image('http://www.association-ore.fr/extranet/include/generation.php?code=' . $string_a_coder . '', null, null, 50, 25, 'png');


                //$pdf->Ln();
            }
        }
    }

} ?>