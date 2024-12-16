<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-id icon-gradient bg-night-fade"></i>
            </div>
            <div>
                Paramètres
            </div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown" style="text-align:center;">
                <div class="row">
                    <button type="button" class="mr-2 btn btn-primary" onclick="history.back()">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use arrow-circle-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4 class="card-title">Paramètres</h4>


                <p align="right"><a class='btn btn-primary'
                                    href="index.php?choixTraitement=administrateur&action=ajoutParametreIndex"> <span
                            class='pe-7s-plus'></span></a>
                </p>


                <center>
                    <form name="frmConsultFrais" method="POST"
                          action="index.php?choixTraitement=administrateur&action=parametres">

                        <div class="form-row">
                            <div class="col-md-3">


                                <SELECT name="unType" onchange="this.form.submit()" class="form-control"
                                        data-live-search="true">
                                    <?php foreach ($lesTypes as $valeur) {
                                        if (isset($tableau) and $typeNum == $valeur['ID']) {
                                            $selectionner = "selected='selected'";
                                        } else {
                                            $selectionner = "";
                                        }


                                        echo '<option ' . $selectionner . ' value="' . $valeur['ID'] . '" name="unType">' . $valeur['NOM'] . '</option>';
                                    }
                                    echo '</select>  </div>
  </div> </form></center>';

                                    if (isset($tableau)) {


                                        echo ' <hr><table class="table" style="width:700px">
    <thead>
        <tr>
            <th>N°</th>
            <th>Type</th>
            <th>Nom</th>
            <th>Niveau</th>
            <th>Valeur</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>';


                                        foreach ($tableau as $uneligne) {
                                            if ($uneligne['NIVEAU'] == 'NULL') {
                                                $niveau = " ";
                                            } else {
                                                $niveau = $uneligne['NIVEAU'];
                                            }
                                            echo "<tr>
            <td>" . $uneligne['IDPARA'] . "</td>
            <td>" . $uneligne['NOMTYPE'] . "</td>
            <td>" . $uneligne['NOMPARA'] . "</td>

            <td>" . $niveau . "</td>
             <td>" . $uneligne['VALEUR'] . "</td>
            <td><a class='btn btn-primary' href='index.php?choixTraitement=administrateur&action=ModifParametreIndex&num=" . $uneligne['IDPARA'] . "' ><span class='pe-7s-pen'></span></a></td>
            <td><a class='btn btn-danger' href='index.php?choixTraitement=administrateur&action=suppParametre&num=" . $uneligne['IDPARA'] . "'><span class='pe-7s-trash'></span></a></td>
        </tr>";
                                        }


                                    }
                                    ?>
                                    </tbody>
                                    </table>
                            </div>
                        </div>
            </div>
        </div>
        <br/>
