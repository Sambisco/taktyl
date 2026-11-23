<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['email'])) {
    include('../include/script.php');
    include('../include/database.php');
    include('../include/css.php');
    include('../include/sidebar.php');
    include('../include/topbar.php');
?>
    <style>
        .img-thumbnail-mobile {
            width: 100%;
            height: 120px
        }

        @media (max-width:576px) {
            .img-thumbnail-mobile {
                width: 100%;
                height: auto;
            }
        }
    </style>
    <link rel="stylesheet" href="../assets/css/button.reservation.css">
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Fournisseur</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
            </ol>
        </div>
        <?php
        if (isset($_SESSION['message_add'])) { ?>

            <div class="alert alert-primary alert-dismissible" role="alert" <?= $_SESSION['msg_type_add'] ?>>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-check"></i>
                <?php
                echo $_SESSION['message_add'];
                unset($_SESSION['message_add']);
                ?>
            </div>
        <?php } else if (isset($_SESSION['message_update'])) { ?>
            <div class="alert alert-success alert-dismissible " role="alert" <?= $_SESSION['msg_type_update'] ?>>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-check"></i>
                <?php
                echo $_SESSION['message_update'];
                unset($_SESSION['message_update']);
                ?>
            </div>
        <?php } else if (isset($_SESSION['message_delete'])) { ?>
            <div class="alert alert-danger alert-dismissible " role="alert" <?= $_SESSION['msg_type_delete'] ?>>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-check"></i>
                <?php
                echo $_SESSION['message_delete'];
                unset($_SESSION['message_delete']);
                ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <div class="form-row">
                            <div class="col-xl-10 mb-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="ajouter">Ajouter</button>
                                <button type="button" class="btn btn-primary" id="importer">Importer</button>
                                <button type="button" class="btn btn-primary" id="exporter">Exporter</button>
                            </div>
                            <div class="col-xl-2">
                                <input type="text" id="search" data-filter class="form-control form-control-sm searchBox" placeholder="Rechercher...">
                                <input type="hidden" id="id_boutiques" value="<?php echo $id; ?>">
                                <input type="hidden" class="id_champ" id="id_champ">
                                <input type="hidden" id="numv">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive p-3 bg-gradient-login " style="margin-top: -20px;margin-left: 0px;margin-right: 0px;">
                            <div class="row mb-3 parent bg-gradient-login" id="contentpage">
                                <!-- debut -->
                                <?php
                                $query = "SELECT * FROM fournisseur INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique WHERE boutique.id_boutique='$id' ORDER BY idfournisseur DESC";
                                $statement = $db->prepare($query);
                                $statement->execute();
                                $result = $statement->fetchAll();
                                $total_row = $statement->rowCount();
                                if ($total_row > 0) {
                                    foreach ($result as $row) {
                                ?>
                                        <div class="col-xl-2 col-md-6 mb-4 result well ">
                                            <div class="card h-100">
                                                <div class="card-body ">
                                                    <center>
                                                        <div style="margin-bottom:10px ;">
                                                            <?php if ($row["imgInfour"] == null) { ?>
                                                                <img src="../img/img/image.jpg" class="img-thumbnail img-thumbnail-mobile" alt="icons8-team-100">
                                                            <?php } else { ?>
                                                                <img src="<?php echo $row['imgInfour']; ?>" class="img-thumbnail img-thumbnail-mobile" alt="icons8-team-100">
                                                            <?php } ?>
                                                        </div>
                                                        <div class="nom identifiant" style="font-weight: bold;text-transform: uppercase;font-size: 14px; margin-bottom: 5px;" id="identifiant_<?php if ($row['id_id_fournisseur'] < 10) {
                                                                                                                                                                                                    echo "0" . $row['id_id_fournisseur'];
                                                                                                                                                                                                } else {
                                                                                                                                                                                                    echo $row['id_id_fournisseur'];
                                                                                                                                                                                                } ?>">
                                                            <?php if ($row['id_id_fournisseur'] < 10) {
                                                                echo "0" . $row['id_id_fournisseur'];
                                                            } else {
                                                                echo $row['id_id_fournisseur'];
                                                            } ?>
                                                        </div>
                                                        <div class="nom" style="font-weight: bold;text-transform: uppercase;font-size: 12px; margin-bottom: 10px;">
                                                            <?php echo $row["nomfour"]; ?>
                                                        </div>

                                                        <div class="fab-container" style="margin-top: 25px;">

                                                            <div class="fab fab-icon-holder fab-button" id="fab-button_<?php echo $row['idfournisseur']; ?>" data-id="<?php echo $row['idfournisseur']; ?>">
                                                                <i class="fas fa-question"></i>
                                                            </div>
                                                            <div class="fab fab-icon-holder fab-hide" id="fab-hide_<?php echo $row['idfournisseur']; ?>" data-id="<?php echo $row['idfournisseur']; ?>" style="display: none;">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <ul class="fab-options fab-show" id="fab-show_<?php echo $row['idfournisseur']; ?>" style="display: none;">
                                                                <li>
                                                                    <span class="fab-label">Information</span>
                                                                    <div class="fab-icon-holder infobtn_<?php echo $row['idfournisseur']; ?>" id="infobtn" data-id="<?php echo $row['idfournisseur']; ?>">
                                                                        <i class="fas fa-info" id="shared"></i>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <span class="fab-label">Modification</span>
                                                                    <div class="fab-icon-holder updatebtn_<?php echo $row['idfournisseur']; ?>" id="updatebtn" data-id="<?php echo $row['idfournisseur']; ?>">
                                                                        <i class="fas fa-edit" id="shared"></i>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <span class="fab-label">Suppression</span>
                                                                    <div class="fab-icon-holder deletebtn_<?php echo $row['idfournisseur']; ?>" id="deletebtn" data-id="<?php echo $row['idfournisseur']; ?>">
                                                                        <i class="fas fa-trash"></i>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </center>
                                                </div>
                                            </div>

                                        </div>
                                <?php
                                    }
                                }
                                ?>
                                <!----------fin------------->
                            </div>
                            <div id="pagination" style="text-align: center;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---Container Fluid-->
    <!------FORMULAIRE AJOUTER------->
    <?php
    $query = "SELECT MAX(id_id_fournisseur)+1 AS num FROM fournisseur INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique WHERE boutique.id_boutique='$id' ORDER BY idfournisseur DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    ?>
    <form id="insertForm" enctype="multipart/form-data">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inséré !</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input name="id_boutique" type="hidden" class="form-control form-control-sm" required="" value="<?php echo $id; ?>" />
                        <input type="hidden" name="id_id_fournisseur" id="" value="<?php if ($result["num"] == null) {
                                                                                        echo "1";
                                                                                    } else {
                                                                                        echo $result["num"];
                                                                                    } ?>">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Nom fournisseur</label>
                                    <div style="color:red; font-size:12px;display: none;" id="ajouter_fournisseuradd">Champs requis *</div>
                                    <input name="nomfour" id="ajouter_fournisseur" type="text" class="form-control form-control-sm" placeholder="Nom fournisseur" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Adresse</label>
                                    <div style="color:red; font-size:12px;display: none;" id="ajouter_adresseadd">Champs requis *</div>
                                    <input name="adressefour" id="ajouter_adresse" type="text" class="form-control form-control-sm" placeholder="Adresse" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Telephone</label>
                                    <div style="color:red; font-size:12px;display: none;" id="ajouter_telephoneadd">Champs requis *</div>
                                    <input name="telephonefour" id="ajouter_telephone" type="text" class="form-control form-control-sm" placeholder="Telephone" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Email</label>
                                    <div style="color:red; font-size:12px;display: none;" id="ajouter_emailadd">Champs requis *</div>
                                    <input name="emailfour" id="ajouter_email" type="text" class="form-control form-control-sm" placeholder="Email" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="descriptionfour" id="ajouter_description" class="form-control" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);"></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Photo</label>
                                    <input type="file" name="imgInp" id="file-ip-1" accept="image/*" onchange="showPreview(event);" class="form-control form-control-sm">

                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">

                            </div>
                            <div class="col">
                                <img id='file-ip-1-preview' class="rounded-circle" width="100" height="100" />

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="insertdata">Enregister</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermer">Fermer</button>
                    </div>
    </form>
    </div>
    </div>
    </div>
    <!------FIN FORMULAIRE AJOUTER------->
    <!------FORMULAIRE MODIFIER------->
    <form id="updateForm" enctype="multipart/form-data">
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Modifié !</h5>
                        <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                    </div>
                    <div class="modal-body">
                        <input name="edit_id" type="hidden" id="edit_id">
                        <input name="id_boutique" type="hidden" class="form-control form-control-sm" required="" value="<?php echo $id; ?>" />


                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Nom fournisseur</label>
                                    <div style="color:red; font-size:12px;display: none;" id="nomfoured">Champs requis *</div>
                                    <input name="nomfour" id="nomfour" type="text" class="form-control form-control-sm" placeholder="Nom fournisseur" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Adresse</label>
                                    <div style="color:red; font-size:12px;display: none;" id="adressefoured">Champs requis *</div>
                                    <input name="adressefour" id="adressefour" type="text" class="form-control form-control-sm" placeholder="Adresse" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Telephone</label>
                                    <div style="color:red; font-size:12px;display: none;" id="telephonefoured">Champs requis *</div>
                                    <input name="telephonefour" id="telephonefour" type="text" class="form-control form-control-sm" placeholder="Telephone" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Email</label>
                                    <div style="color:red; font-size:12px;display: none;" id="emailfoured">Champs requis *</div>
                                    <input name="emailfour" id="emailfour" type="text" class="form-control form-control-sm" placeholder="Email" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="descriptionfour" id="descriptionfour" class="form-control" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);"></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Photo</label>
                                    <input type="file" name="imgInp" id="imgInps" accept="image/*" onchange="showPreview(event);" class="form-control form-control-sm">

                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">

                            </div>
                            <div class="col">
                                <span id='img-uploads' class="rounded-circle" width="100" height="100"></span>
                                <img id='img-uploadss' class="rounded-circle" width="100" height="100" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="updatetdata" class="btn btn-primary">Modifier</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermerm">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!------FIN FORMULAIRE MODIFIER------->
    <!------FORMULAIRE SUPPRIMER------->
    <form id="deleteForm" enctype="multipart/form-data">
        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Supprimer !</h5>
                        <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                    </div>
                    <div class="modal-body">
                        <label>Voulez-vous vraiment supprimer ce fournisseur ?</label>
                        <input name="delete_id" type="hidden" id="delete_id" class="form-control form-control-sm" readonly />
                        <input name="" type="text" id="del_cat" class="form-control form-control-sm" readonly />
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="deletedata" class="btn btn-primary">Supprimer</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermers">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!------FIN FORMULAIRE SUPPRIMER------->
    <!------FORMULAIRE INFO------->
    <div class="modal fade " id="infomodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content ">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalLabel"> Info !</h5>
                    <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                </div>
                <div class="modal-body">
                    <input name="edit_id" type="hidden" id="edit_id">
                    <span id='img-upload-info' width="100" height="100"></span>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <strong>Fournisseur</strong>
                                <div id="info_nomfour">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <strong>Adresse</strong>
                                <div id="info_adressefour">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <strong>Telephone</strong>
                                <div id="info_telephonefour">

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <strong>Email</strong>
                                <div id="info_emailfour">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <strong>Description</strong>
                        <div id="info_descriptionfour">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermeri">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <form id="import_form" enctype="multipart/form-data">
        <div class="modal fade" id="importmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="max-width: 50%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Importé !</h5>
                        <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                    </div>
                    <input name="id_boutique" type="text" class="form-control form-control-sm" required="" value="<?php echo $id; ?>" hidden />

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Fichier excel</label>
                            <div style="color:red; font-size:12px;display: none;" id="requireimport">un fichier Excel requis *</div>
                            <input type="file" class="form-control form-control-sm" name="file-import" id="fileupload">
                        </div>
                        <div class="form-group" style="height: 500px;overflow: auto;">
                            <table id="tblItems" class="table align-items-center table-flush table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nom fournisseur</th>
                                        <th>Adresse</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="importdata" class="btn btn-primary">Importer</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermerm">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!------FIN FORMULAIRE IMPORTER------->
    <table id="table_categorie" style="display: none;">
        <?php

        $query = "SELECT * FROM fournisseur INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique WHERE boutique.id_boutique='$id' ORDER BY idfournisseur DESC";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $total_row = $statement->rowCount();
        if ($total_row > 0) {
            foreach ($result as $row) {
        ?>
                <tr>
                    <td><?php echo $row["nomfour"]; ?></td>
                    <td><?php echo $row["adressefour"]; ?></td>
                    <td><?php echo $row["telephonefour"]; ?></td>
                    <td><?php echo $row["emailfour"]; ?></td>
                    <td><?php echo $row["descriptionfour"]; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </table>
    <input type="hidden" name="" id="information">

    <!------FORMULAIRE INFO------->
    <div class="modal fade" tabindex="-1" role="dialog" id="vocal">
        <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
            <span class="fa fa-spinner fa-spin fa-3x" style="color:#fff"></span>
        </div>
    </div>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/ruang-admin.min.js"></script>
    <!-- Page level plugins -->

    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../vendor/labelChart/chartjs-plugin-datalabels@0.7.js"></script>
    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
    <script src="../js/demo/chart-bar-demo.js"></script>
    <script>
        $(document).ready(function(e) {
            // Submit form data via Ajax
            $("#insertForm").on('submit', function(e) {

                e.preventDefault();
                if ($("#ajouter_fournisseur").val() == "") {
                    $("#ajouter_fournisseuradd").show().delay(5000).hide(0);
                } else if ($("#ajouter_adresse").val() == "") {
                    $("#ajouter_adresseadd").show().delay(5000).hide(0);
                } else if ($("#ajouter_telephone").val() == "") {
                    $("#ajouter_telephoneadd").show().delay(5000).hide(0);
                } else if ($("#ajouter_email").val() == "") {
                    $("#ajouter_emailadd").show().delay(5000).hide(0);
                } else {
                    $('#exampleModal').modal("hide");
                    $.ajax({
                        type: 'POST',
                        url: '../controller/fournisseur/insert',
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#insertdata').attr("disabled", "disabled");
                        },
                        success: function(response) {

                        }
                    });

                    swal({
                        title: "Enregistrer!",
                        text: "Enregistrement effectué avec succés.",
                        type: "success",
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#3085d6',
                        showConfirmButton: false,
                        timer: 2000
                    }, function() {
                        window.location.href = "fournisseur?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
                    });
                }
            });
            $("#import_form").on('submit', function(e) {
                e.preventDefault();
                var validExts = new Array(".xlsx", ".xls", ".csv");
                var fileExt = $('#fileupload').val();
                fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                if (validExts.indexOf(fileExt) < 0) {
                    $('#requireimport').show().delay(5000).hide(0);
                    return false;
                } else if ($('#fileupload').val() == "") {
                    $('#requireimport').show().delay(5000).hide(0);
                } else {
                    $('#exampleModal').modal("hide");

                    $.ajax({
                        type: 'POST',
                        url: '../controller/fournisseur/import',
                        data: new FormData(this),
                        //dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#importdata').attr("disabled", "disabled");
                        },
                        success: function(response) {
                            console.log(response)
                        }
                    });

                    swal({
                        title: "Enregistré!",
                        text: "Enregistrement effectué avec succés.",
                        type: "success",
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#3085d6',
                        showConfirmButton: false,
                        timer: 2000
                    }, function() {
                        window.location.href = "fournisseur?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
                    });
                }
            });
            $("#updateForm").on('submit', function(e) {

                e.preventDefault();
                if ($("#nomfour").val() == "") {
                    $("#nomfoured").show().delay(5000).hide(0);
                } else if ($("#adressefour").val() == "") {
                    $("#adressefoured").show().delay(5000).hide(0);
                } else if ($("#telephonefour").val() == "") {
                    $("#telephonefoured").show().delay(5000).hide(0);
                } else if ($("#emailfour").val() == "") {
                    $("#emailfoured").show().delay(5000).hide(0);
                } else {
                    $('#editmodal').modal("hide");
                    $.ajax({
                        type: 'POST',
                        url: '../controller/fournisseur/update',
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#updatetdata').attr("disabled", "disabled");
                        },
                        success: function(response) {

                        }
                    });

                    swal({
                        title: "Modifier!",
                        text: "Modification effectuée avec succés.",
                        type: "success",
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#3085d6',
                        showConfirmButton: false,
                        timer: 2000
                    }, function() {
                        window.location.href = "fournisseur?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
                    });
                }
            });

            $("#deleteForm").on('submit', function(e) {
                $('#deletemodal').modal("hide");

                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../controller/fournisseur/delete',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#deletedata').attr("disabled", "disabled");
                    },
                    success: function(response) {

                    }
                });

                swal({
                    title: "Supprimer!",
                    text: "Suppression effectuée avec succés.",
                    type: "error",
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3085d6',
                    showConfirmButton: false,
                    timer: 2000
                }, function() {
                    window.location.href = "fournisseur?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
                });
            });
        });

        function showPreview(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
        $('#img-uploadss').hide();
        $(document).ready(function() {
            $(document).on('change', '.btn-file :file', function() {

                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img-uploadss').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInps").change(function() {
                readURL(this);
                $('#img-uploadss').show();
                $('#img-uploads').hide();
            });

        });
        $(function() {

            var flexiblePagination = $('#contentpage').flexiblePagination({
                itemsPerPage: 18,
                itemSelector: 'div.result:visible',
                pagingControlsContainer: '#pagination',
                showingInfoSelector: '#showingInfo',
                css: {
                    btnNumberingClass: 'btn btn-sm btn-primary',
                    btnFirstClass: 'btn btn-sm btn-primary',
                    btnLastClass: 'btn btn-sm btn-primary',
                    btnNextClass: 'btn btn-sm btn-primary',
                    btnPreviousClass: 'btn btn-sm btn-primary'
                }
            });
            flexiblePagination.getController().onPageClick = function(pageNum, e) {
                console.log('Cliquez sur la Page: ' + pageNum)
            };

            // Direct JS Object method of using the FlexiblePagination
            //        var pager = new Flexible.Pagination();
            //        pager.itemsPerPage = 1;
            //        pager.pagingContainer = '#content';
            //        pager.itemSelector = 'div.result:visible';  //That is, Select and paginate only the filtered visible '.result' div.
            //        pager.pagingControlsContainer = '#pagingControls';
            //        pager.showCurrentPage();
        });
    </script>

    <script>
        $("#id_boutique").select2({
            dropdownParent: $("#exampleModal")
        });
        $("#edit_id_boutique").select2({
            dropdownParent: $("#editmodal")
        });
        $(".id_n").each(function() {
            $('.id_n').hide();
        });
        $(".id_t").each(function() {
            $('.id_t').hide();
        });

        $("#id_t").hide();

        $(document).on('click', '.fab-button', function(e) {
            var id = $(this).data('id');
            $(".fab-button").each(function() {
                $('#fab-show_' + id).show(600);
                $('#fab-hide_' + id).show();
                $('#fab-button_' + id).hide();
            });
        });
        $(document).on('click', '.fab-hide', function(e) {
            var id = $(this).data('id');
            $(".fab-hide").each(function() {
                $('#fab-show_' + id).hide(300);
                $('#fab-button_' + id).show();
                $('#fab-hide_' + id).hide();
            });
        });
        $(document).on('click', '#importer', function(e) {
            $("#importmodal").modal("show");
        })
        $("#id_categorie").select2({
            dropdownParent: $("#exampleModal")
        });
        $("#edit_id_categorie").select2({
            dropdownParent: $("#editmodal")
        });

        $(document).on('click', '#updatebtn', function(e) {
            $('#img-uploads').show();
            $('#img-uploadss').hide();
            e.preventDefault();

            var fournisseur = $(this).data('id');
            $.ajax({
                url: "../controller/fournisseur/fetch_fournisseur",
                type: "post",
                data: {
                    fournisseur: fournisseur
                },
                dataType: 'json',
                success: function(data) {
                    $("#edit_id").val(data.idfournisseur);
                    $("#nomfour").val(data.nomfour);
                    $("#adressefour").val(data.adressefour);
                    $("#telephonefour").val(data.telephonefour);
                    $("#emailfour").val(data.emailfour);
                    $("#img-uploads").html(data.imgInfour);
                    $("#descriptionfour").val(data.descriptionfour);
                    $("#edit_id_boutique").val(data.id_boutique);
                    $("#editmodal").modal("show");

                }
            });
        });
        $(document).on('click', '#infobtn', function(e) {
            e.preventDefault();

            var fournisseur = $(this).data('id');
            $.ajax({
                url: "../controller/fournisseur/fetch_fournisseur",
                type: "post",
                data: {
                    fournisseur: fournisseur
                },
                dataType: 'json',
                success: function(data) {
                    $("#info_nomfour").html(data.nomfour);
                    $("#info_adressefour").html(data.adressefour);
                    $("#info_telephonefour").html(data.telephonefour);
                    $("#info_emailfour").html(data.emailfour);
                    $("#img-upload-info").html(data.imgInfour);
                    $("#info_descriptionfour").html(data.descriptionfour);
                    $("#infomodal").modal("show");

                }
            });
        });
        $(document).on('click', '#deletebtn', function(e) {
            $('#img-uploads').show();
            $('#img-uploadss').hide();
            e.preventDefault();

            var fournisseur = $(this).data('id');
            $.ajax({
                url: "../controller/fournisseur/fetch_fournisseur",
                type: "post",
                data: {
                    fournisseur: fournisseur
                },
                dataType: 'json',
                success: function(data) {

                    $("#delete_id").val(data.idfournisseur);
                    $("#del_cat").val(data.nomfour);
                    $("#deletemodal").modal("show");

                }
            });
        });
    </script>
    <script>
        var scrolled = 0;
        if (annyang) {
            annyang.setLanguage('fr-FR');
            // Let's define our first command. First the text we expect, and then the function it should call
            var commands = {
                'non fournisseur': function() {
                    $('#ajouter_fournisseur').focus();
                },
                'adresse': function() {
                    $('#ajouter_adresse').focus();
                },
                'téléphone': function() {
                    $('#ajouter_telephone').focus();
                },
                'email': function() {
                    $('#ajouter_email').focus();
                },
                'description': function() {
                    $('#ajouter_description').focus();
                },
                'photo': function() {
                    $('#file-ip-1').focus();
                },
                'modifier non fournisseur': function() {
                    $('#nomfour').focus();
                },
                'modifier adresse': function() {
                    $('#adressefour').focus();
                },
                'modifier téléphone': function() {
                    $('#telephonefour').focus();
                },
                'modifier email': function() {
                    $('#emailfour').focus();
                },
                'modifier description': function() {
                    $('#descriptionfour').focus();
                },
                'modifier photo': function() {
                    $('#imgInps').focus();
                },

                'ajouter': function() {
                    $('#ajouter').click();
                },
                'enregistrer': function() {
                    $('#insertForm').submit();
                },
                'paramètre': function() {
                    var id = $('#numv').val()
                    if ($('#numv').val() == "") {
                        swal({
                            title: "Erreur!",
                            text: "Veillez choisir un identifiant.",
                            type: "error",
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#3085d6',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        $('#fab-button_' + id).click();
                    }
                },
                'modification': function() {
                    var id = $('#numv').val()
                    $('.updatebtn_' + id).click();
                },
                'modifier': function() {
                    if ($('#numv').val() == "") {
                        swal({
                            title: "Erreur!",
                            text: "Veillez choisir un identifiant.",
                            type: "error",
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#3085d6',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        $('#updateForm').submit();
                    }
                },
                'suppression': function() {
                    var id = $('#numv').val()
                    $('.deletebtn_' + id).click();
                },
                'supprimer': function() {
                    if ($('#numv').val() == "") {
                        swal({
                            title: "Erreur!",
                            text: "Veillez choisir un identifiant.",
                            type: "error",
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#3085d6',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    } else {
                        $('#deleteForm').submit();
                    }
                },
                'information': function() {
                    var id = $('#numv').val()
                    $(".infobtn_" + id).click();

                },
                'fermer': function() {
                    $('#fermer').click();
                    $('#fermerm').click();
                    $('#fermers').click();
                    $('#fermeri').click();
                    var id = $('#numv').val()
                    $('#fab-hide_' + id).click();
                },
                'arrêter la recherche': function(variables) {
                    $("#search").val("");
                    if ($("#search").val(variables)) {
                        $(".searchBox").keyup();
                    }
                },
                'vers le bas': function() {
                    scrolled = scrolled + 300;
                    $("#page-top").animate({
                        scrollTop: scrolled
                    });
                },
                'vers le haut': function() {
                    scrolled = scrolled - 300;
                    $("#page-top").animate({
                        scrollTop: scrolled
                    });
                },
                'actualiser': function() {
                    $('#fermer').click();
                    $('#fermerm').click();
                    $('#fermers').click();
                    $('#fermeri').click();
                    $('#vocal').modal('show');
                    setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "fournisseur?id=<?php echo  $id_m; ?>";

                    }, 2000);
                },
                'rechercher *tag': function(variable) {
                    let task_name = document.getElementById("search");
                    task_name.value = variable;
                    var currency = $('#search').val().toLowerCase().replace(/,/g, ''); // exclude commas
                    if (currency) {
                        $(".searchBox").keyup();
                    }

                },
                'identifiant *tag': function(variable) {
                    let task_name = document.getElementById("id_champ");
                    task_name.value = variable;
                    var color_id = $('#id_champ').val();
                    $('.identifiant').css("color", "");
                    if (color_id) {
                        $('#identifiant_' + color_id).animate({
                            'zoom': 3
                        }, 'slow');
                        setTimeout(function() {
                            $('#identifiant_' + color_id).animate({
                                'zoom': 1
                            }, 'slow');

                        }, 3000);
                        $('#identifiant_' + color_id).css({
                            "color": "red",
                        });
                    }
                    var currency = $('#id_champ').val().toLowerCase().replace(/,/g, ''); // exclude commas
                    if (currency) {
                        $(".id_champ").keyup();
                    }
                    var id_champ = $("#id_champ").val()
                    var id_boutiques = $("#id_boutiques").val();
                    $.ajax({
                        url: "../controller/fournisseur/fetch_fournisseur",
                        type: "post",
                        data: {
                            id_champ: id_champ,
                            id_boutiques: id_boutiques
                        },
                        dataType: 'json',
                        success: function(data) {
                            $("#numv").val(data.idfournisseur);
                        }
                    });
                }
            };

            // Add our commands to annyang
            annyang.addCommands(commands);

            // Start listening. You can call this here, or attach this call to an event, button, etc.
            annyang.start();
        }
        var ExcelToJSON = function() {
            this.parseExcel = function(file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var data = e.target.result;
                    var workbook = XLSX.read(data, {
                        type: 'binary',
                        cellText: false,
                        cellDates: true

                    });
                    workbook.SheetNames.forEach(function(sheetName) {
                        var XL_row_object = XLSX.utils.sheet_to_json(workbook.Sheets[
                            sheetName], {
                            header: 1,
                            raw: false,
                            dateNF: 'dd"/"mm"/"yyyy',
                        });
                        var productList = JSON.parse(JSON.stringify(XL_row_object));
                        var rows = $('#tblItems tbody');
                        // console.log(productList)
                        for (i = 0; i < productList.length; i++) {
                            var columns = Object.values(productList[i])

                            if (columns[0] == null) {
                                columns[0] = "";
                            } else {
                                columns[0];
                            }
                            if (columns[1] == null) {
                                columns[1] = "";
                            } else {
                                columns[1];
                            }
                            if (columns[2] == null) {
                                columns[2] = "";
                            } else {
                                columns[2];
                            }
                            if (columns[3] == null) {
                                columns[3] = "";
                            } else {
                                columns[3];
                            }
                            if (columns[4] == null) {
                                columns[4] = "";
                            } else {
                                columns[4];
                            }
                            rows.append(`
                        <tr class="body_caption_top">
                           <td>
                              <div class="form-group">
                                <input name="nomfour[]" id="ajouter_catégorie" type="text" class="form-control form-control-sm" placeholder="Categorie" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[0]}"/>
                              </div>
                           </td>
                            <td>
                              <div class="form-group">
                                 <input name="adressefour[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[1]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input name="telephonefour[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[2]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input name="emailfour[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[3]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input name="descriptionfour[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[4]}">
                              </div>
                            </td>
                        </tr>
                    `);
                        }

                    })
                };
                reader.onerror = function(ex) {
                    console.log(ex);
                };

                reader.readAsBinaryString(file);
            };
        };

        function handleFileSelect(evt) {
            var files = evt.target.files; // FileList object
            var xl2json = new ExcelToJSON();
            xl2json.parseExcel(files[0]);
        }
        $(document).on('click', '#fermerm', function(e) {
            $("#tblItems tr.body_caption_top").remove();
            $('#fileupload').val("");

        })
        document.getElementById('fileupload').addEventListener('change', handleFileSelect, false);
        $('#exporter').click(function() {
            $("#table_categorie").table2excel({
                exclure: ".excludeThisClass",
                name: "Worksheet Name",
                filename: "Fournisseur.xls", // inclure l'extension 
                preserveColors: false // définir sur true si vous souhaitez que les couleurs d'arrière-plan et les couleurs de police soient préservées 
            });
        });
    </script>

<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
    header("Location:../");
}
?>