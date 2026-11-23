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
    $timezone = "UTC";
    date_default_timezone_set($timezone);
?>
    <link rel="stylesheet" href="../assets/css/button.reservation.css">
    
    <?php
    $query = "SELECT * FROM categorie_stock WHERE id_boutique='$id'  ORDER BY id_categorie_stock DESC";
    $categorie = "<option value=''>Categorie</option>";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if ($total_row > 0) {
        foreach ($result as $row) {
            $categorie .= "<option value='{$row["id_categorie_stock"]}'>{$row["categorie_stock"]}</option>";
        }
    }
    ?>


    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Promotion</h1>
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
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="ajouter">Ajouter</button>
                        <div class="col-md-3">
                            <input type="text" id="search" data-filter class="form-control form-control-sm searchBox" placeholder="Rechercher...">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive p-3 bg-gradient-login " style="margin-top: -20px;margin-left: 0px;margin-right: 0px;">
                            <div class="row mb-3 parent" id="contentpage">

                                <!-- debut -->
                                <?php

                                $query = "SELECT * FROM promotion 
                                INNER JOIN article ON article.id_article=promotion.id_article
                INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
                INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                WHERE boutique.id_boutique='$id' ORDER BY promotion.id_promotion DESC";
                                $statement = $db->prepare($query);
                                $statement->execute();
                                $result = $statement->fetchAll();
                                $total_row = $statement->rowCount();
                                if ($total_row > 0) {
                                    foreach ($result as $row) {
                                ?>

                                        <div class="col-xl-2 col-md-6 mb-4 result well">
                                            <div class="card h-90">
                                                <div class="card-body ">
                                                    <center>
                                                        <div style="margin-bottom:10px ;">
                                                            <?php if ($row["imgInp"] == null) { ?>
                                                                <img src="../img/img/image.jpg" class="img-thumbnail" style="height: 100px;width: 100%;" alt="icons8-team-100">
                                                            <?php } else { ?>
                                                                <img src="../img/img/<?php echo $row['imgInp']; ?>" class="img-thumbnail" style="height: 100px;width: 100%;" alt="icons8-team-100">
                                                            <?php } ?>
                                                        </div>
                                                        <div class="nom identifiant desc" style="font-weight: bold;text-transform: uppercase;font-size: 14px; margin-bottom: 0px;" id="identifiant_<?php if ($row['id_id_article'] < 10) {
                                                                                                                                                                                                        echo "0" . $row['id_id_article'];
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                        echo $row['id_id_article'];
                                                                                                                                                                                                    } ?>">
                                                            <?php if ($row['id_id_article'] < 10) {
                                                                echo "0" . $row['id_id_article'];
                                                            } else {
                                                                echo $row['id_id_article'];
                                                            } ?>
                                                        </div>
                                                        <div class="nom" style="font-weight: bold;text-transform: uppercase;font-size: 12px;">
                                                            <?php echo $row["categorie_stock"]; ?>
                                                        </div>

                                                        <div class="nom" style="font-size: 14px;">
                                                            <?php echo $row["description_article"]; ?>
                                                        </div>

                                                        <div class="sku" style="font-size: 14px;">
                                                            <strong>Reduction:</strong> <?php echo $row['reduction']; ?>%
                                                        </div>

                                                        <div class="sku" style="margin-bottom:5px ;">
                                                            <?php if (strtotime($row["datefin"]) < strtotime(date("Y-m-d"))) { ?>
                                                                <i class="fas fa-ban fa-1x" style="color: red;"></i>
                                                            <?php } else { ?>
                                                                <i class="fas fa-check fa-1x" style="color: green;"></i>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="fab-container">

                                                            <div class="fab fab-icon-holder fab-button" id="fab-button_<?php echo $row['id_promotion']; ?>" data-id="<?php echo $row['id_promotion']; ?>">
                                                                <i class="fas fa-question"></i>
                                                            </div>
                                                            <div class="fab fab-icon-holder fab-hide" id="fab-hide_<?php echo $row['id_promotion']; ?>" data-id="<?php echo $row['id_promotion']; ?>" style="display: none;">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <ul class="fab-options fab-show" id="fab-show_<?php echo $row['id_promotion']; ?>" style="display: none;">
                                                                <li>
                                                                    <span class="fab-label">Information</span>
                                                                    <div class="fab-icon-holder" id="infobtn" data-id="<?php echo $row['id_promotion']; ?>">
                                                                        <i class="fas fa-info" id="shared"></i>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <span class="fab-label">Modifier</span>
                                                                    <div class="fab-icon-holder" id="updatebtn" data-id="<?php echo $row['id_promotion']; ?>">
                                                                        <i class="fas fa-edit" id="shared"></i>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <span class="fab-label">Supprimer</span>
                                                                    <div class="fab-icon-holder" id="deletebtn" data-id="<?php echo $row['id_promotion']; ?>">
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
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Categorie</label>
                                    <div style="color:red; font-size:12px;display: none;" id="id_categorie_add">Champs requis *</div>
                                    <select name="id_categorie" id="id_categorie" class="form-control form-control-sm" style="width: 100%;">
                                        <?php
                                        echo $categorie;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Article</label>
                                    <div style="color:red; font-size:12px;display: none;" id="id_article_add">Champs requis *</div>
                                    <select name="id_article" id="id_article" class="form-control form-control-sm" style="width: 100%;" >
                                        <option value="">Selectionnez article</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                <div style="color:red; font-size:12px;display: none;" id="datedeb_add">Champs requis *</div>
                                    <label>Date debut</label>
                                    <input name="datedeb" type="date" id="add_datedeb" class="form-control form-control-sm" placeholder="Nom categorie" value="<?php echo date('Y-m-d'); ?>"  onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Date fin</label>
                                    <div style="color:red; font-size:12px;display: none;" id="datefin_add">Champs requis *</div>
                                    <input name="datefin" id="add_datefin" type="date" class="form-control form-control-sm" placeholder="Nom categorie" value="<?php echo date('Y-m-d'); ?>" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Reduction (%)</label>
                                    <div style="color:red; font-size:12px;display: none;" id="reduction_add">Champs requis *</div>
                                    <input name="reduction" id="add_reduction" type="text" class="form-control form-control-sm" placeholder="Reduction (%)" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Condition</label>
                                    <div style="color:red; font-size:12px;display: none;" id="conditions_add">Champs requis *</div>
                                    <textarea name="conditions" id="add_conditions" class="form-control form-control-sm" placeholder="Condition"></textarea>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="insertdata">Enregister</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermer">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
                        <div class="form-row">
                            <div class="col">
                                <input name="edit_id" type="hidden" id="edit_id">
                                <div class="form-group">
                                    <label>Categorie</label>
                                    <div style="color:red; font-size:12px;display: none;" id="edit_id_categorie1_ed">Champs requis *</div>
                                    <select name="id_categorie" id="edit_id_categorie1" class="form-control form-control-sm" style="width: 100%;">
                                        <?php echo $categorie; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Article</label>
                                    <div style="color:red; font-size:12px;display: none;" id="edit_id_article_ed">Champs requis *</div>
                                    <select name="id_article" id="edit_id_article" class="form-control form-control-sm" style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Date debut</label>
                                    <div style="color:red; font-size:12px;display: none;" id="datedeb_ed">Champs requis *</div>
                                    <input name="datedeb" id="datedeb" type="date" class="form-control form-control-sm" placeholder="Nom categorie" value="<?php echo date('Y-m-d'); ?>"  onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Date fin</label>
                                    <div style="color:red; font-size:12px;display: none;" id="datefin_ed">Champs requis *</div>
                                    <input name="datefin" id="datefin" type="date" class="form-control form-control-sm" placeholder="Nom categorie" value="<?php echo date('Y-m-d'); ?>"  onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Reduction (%)</label>
                                    <div style="color:red; font-size:12px;display: none;" id="reduction_ed">Champs requis *</div>
                                    <input name="reduction" id="reduction" type="text" class="form-control form-control-sm" placeholder="Reduction (%)"  onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Condition</label>
                                    <div style="color:red; font-size:12px;display: none;" id="conditions_ed">Champs requis *</div>
                                    <textarea name="conditions" id="conditions" class="form-control form-control-sm" placeholder="Condition"></textarea>
                                </div>
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
                        <label>Voulez-vous vraiment supprimer ?</label>
                        <input name="delete_id" type="hidden" id="delete_id" class="form-control form-control-sm" readonly />
                        <input name="" type="text" id="del_stock" class="form-control form-control-sm" readonly />
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
                    <h5 class="modal-title" id="exampleModalLabel"> info !</h5>
                    <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                </div>
                <form action="../controller/chambre" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input name="edit_id" type="hidden" id="edit_id">
                        <center>
                            <span id='img-upload-info' width="100" height="100"></span>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <strong>Categorie</strong>
                                        <div id="categorie"></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <strong>Description</strong>
                                        <div id="description"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <strong>Date Debut</strong>
                                        <div id="prixx"></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <strong>Date Fin</strong>
                                        <div id="qtee"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <strong>Reduction %</strong>
                                        <div id="initial"></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <strong>Condition</strong>
                                        <div id="id_code"></div>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermeri">Fermer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                if ($("#id_categorie").val() == "") {
                $("#id_categorie_add").show().delay(5000).hide(0);
            } else if ($("#id_article").val() == "") {
                $("#id_article_add").show().delay(5000).hide(0);
              } else if ($("#add_datedeb").val() == "") {
                $("#datedeb_add").show().delay(5000).hide(0);
              } else if ($("#add_datefin").val() == "") {
                $("#datefin_add").show().delay(5000).hide(0);
              } else if ($("#add_reduction").val() == "") {
                $("#reduction_add").show().delay(5000).hide(0);
              } else if ($("#add_conditions").val() == "") {
                $("#conditions_add").show().delay(5000).hide(0);
              } else {
                $('#exampleModal').modal("hide");

                $.ajax({
                    type: 'POST',
                    url: '../controller/promotion/insert',
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
                    title: "Enregistré!",
                    text: "Enregistrement effectué avec succés.",
                    type: "success",
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3085d6',
                    showConfirmButton: false,
                    timer: 2000
                }, function() {
                    window.location.href = "promotion?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
                });
            }
            });

            $("#updateForm").on('submit', function(e) {

                e.preventDefault();
                if ($("#edit_id_categorie1").val() == "") {
                $("#edit_id_categorie1_ed").show().delay(5000).hide(0);
            } else if ($("#edit_id_article").val() == "") {
                $("#edit_id_article_ed").show().delay(5000).hide(0);
              } else if ($("#datedeb").val() == "") {
                $("#datedeb_ed").show().delay(5000).hide(0);
              } else if ($("#datefin").val() == "") {
                $("#datefin_ed").show().delay(5000).hide(0);
              } else if ($("#reduction").val() == "") {
                $("#reduction_ed").show().delay(5000).hide(0);
              } else if ($("#conditions").val() == "") {
                $("#conditions_ed").show().delay(5000).hide(0);
              } else {
                $('#editmodal').modal("hide");

                $.ajax({
                    type: 'POST',
                    url: '../controller/promotion/update',
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
                    title: "Modifié!",
                    text: "Modification effectuée avec succés.",
                    type: "success",
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3085d6',
                    showConfirmButton: false,
                    timer: 2000
                }, function() {
                    window.location.href = "promotion?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
                });
            }
            });

            $("#deleteForm").on('submit', function(e) {
                $('#deletemodal').modal("hide");

                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '../controller/promotion/delete',
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
                    title: "Supprimé!",
                    text: "Suppression effectuée avec succés.",
                    type: "error",
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3085d6',
                    showConfirmButton: false,
                    timer: 2000
                }, function() {
                    window.location.href = "promotion?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
                });
            });
        });
        $(function() {

            var flexiblePagination = $('#contentpage').flexiblePagination({
                itemsPerPage: 12,
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
        $("#searchc").select2();
        $("#id_article").select2({
            dropdownParent: $("#exampleModal")
        });
        $("#id_categorie").select2({
            dropdownParent: $("#exampleModal")
        });
        $("#edit_id_article").select2({
            dropdownParent: $("#editmodal")
        });
        $("#edit_id_categorie").select2({
            dropdownParent: $("#editmodal")
        });
        $("#edit_id_categorie1").select2({
            dropdownParent: $("#editmodal")
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

        $(document).on('change', '#id_categorie', function(e) {
            e.preventDefault();

            var id_categorie = $('#id_categorie').val();
            $.ajax({
                url: '../controller/article/fetch_article',
                type: "post",
                data: {
                    id_categorie: id_categorie
                },
                dataType: 'html',
                success: function(data) {

                    $("#id_article").html(data);

                }
            });
        });
        $(document).on('change', '#edit_id_categorie1', function(e) {
            e.preventDefault();

            var id_categorie = $('#edit_id_categorie1').val();
            $.ajax({
                url: '../controller/article/fetch_article',
                type: "post",
                data: {
                    id_categorie: id_categorie
                },
                dataType: 'html',
                success: function(data) {

                    $("#edit_id_article").html(data);

                }
            });
        });

        $(document).on('click', '#updatebtn', function(e) {

            e.preventDefault();

            var id_promotion = $(this).data('id');
            var id_promotions = $(this).data('id');
            $.ajax({
                url: '../controller/promotion/fetch_promotion',
                type: "post",
                data: {
                    id_promotion: id_promotion
                },
                dataType: 'json',
                success: function(data) {

                    $("#edit_id").val(data.id_promotion);
                    $("#edit_id_article").html(data.id_article);
                    $("#edit_id_categorie1").val(data.id_categorie_stock);
                    $("#datedeb").val(data.datedeb);
                    $("#datefin").val(data.datefin);
                    $("#reduction").val(data.reduction);
                    $("#conditions").val(data.conditions);
                    $("#img-uploads").html(data.imgInp);

                }
            });
            $.ajax({
                url: '../controller/promotion/fetch_promotion',
                type: "post",
                data: {
                    id_promotions: id_promotions
                },
                dataType: 'html',
                success: function(data) {
                    $("#edit_id_article").html(data);
                }
            });
            $("#editmodal").modal("show");

        });

        $(document).on('click', '#deletebtn', function(e) {
            $('#img-uploads').show();
            $('#img-uploadss').hide();
            e.preventDefault();

            var id_promotion = $(this).data('id');
            $.ajax({
                url: '../controller/promotion/fetch_promotion',
                type: "post",
                data: {
                    id_promotion: id_promotion
                },
                dataType: 'json',
                success: function(data) {

                    $("#delete_id").val(data.id_promotion);
                    $("#del_stock").val(data.description_article);
                    $("#deletemodal").modal("show");

                }
            });
        });
        $(document).on('click', '#infobtn', function(e) {
            e.preventDefault();

            var id_promotion = $(this).data('id');
            $.ajax({
                url: '../controller/promotion/fetch_promotion',
                type: "post",
                data: {
                    id_promotion: id_promotion
                },
                dataType: 'json',
                success: function(data) {

                    $("#info_id_categorie").html(data.id_article);
                    $("#categorie").html(data.categorie_stock);
                    $("#description").html(data.description_article);
                    $("#prixx").html(data.datedebp);
                    $("#qtee").html(data.datefinp);
                    $("#initial").html(data.reduction);
                    $("#id_code").html(data.conditions);
                    $("#img-upload-info").html(data.imgInp);
                    $("#infomodal").modal("show");

                }
            });
        });
    </script>
    <script>
        if (annyang) {
            annyang.setLanguage('fr-FR');
            // Let's define our first command. First the text we expect, and then the function it should call
            var commands = {
                'ajouter': function() {
                    $('#ajouter').click();
                },
                'enregistrer': function() {
                    $('#insertForm').submit();
                },
                'modifier': function() {
                    $('#updateForm').submit();
                },
                'supprimer': function() {
                    $('#deleteForm').submit();
                },
                'fermer': function() {
                    $('#fermer').click();
                    $('#fermerm').click();
                    $('#fermers').click();
                    $('#fermeri').click();
                },
                'retirer': function(variables) {
                    $("#search").val("");
                    if ($("#search").val(variables)) {
                        $(".searchBox").keyup();
                    }
                },
                '*rechercher': function(variable) {
                    let task_name = document.getElementById("search");
                    task_name.value = variable;
                    var currency = $('#search').val().toLowerCase().replace(/,/g, ''); // exclude commas


                    if (currency) {
                        $(".searchBox").keyup();

                    }
                    if ($('#search').val() === "actualiser") {
                        $('#vocal').modal('show');
                        setTimeout(function() {
                            console.log('completed');
                            $('#vocal').modal('hide');
                            window.location.href = "promotion?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";

                        }, 1000);
                    }
                }
            };

            // Add our commands to annyang
            annyang.addCommands(commands);

            // Start listening. You can call this here, or attach this call to an event, button, etc.
            annyang.start();
        }
    </script>


<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
    header("Location:../");
}
?>