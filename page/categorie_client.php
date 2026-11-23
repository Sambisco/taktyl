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

    <link rel="stylesheet" href="../assets/css/button.reservation.css">
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Categorie client</h1>
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
                                <input type="hidden" class="id_champ" id="id_champ">
                                <input type="hidden" name="" id="id_boutiques" value=" <?php echo $id ?>">
                                <input type="hidden" id="numv">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="" style="margin-top: -20px;margin-left: 10px;margin-right: 10px;">
                            <div class="row mb-3 parent bg-gradient-login" id="contentpage" style="padding-top: 20px;">
                                <!-- debut -->
                                <?php

                                $query = "SELECT * FROM categorie_client 
                                INNER JOIN boutique ON boutique.id_boutique=categorie_client.id_boutique
                                 WHERE boutique.id_boutique='$id' ORDER BY id_categorie_client DESC";

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
                                                        <div class="nom identifiant" style="font-weight: bold;text-transform: uppercase;font-size: 14px; margin-bottom: 5px;" id="identifiant_<?php if ($row['id_id_categorie_client'] < 10) {
                                                                                                                                                                                                    echo "0" . $row['id_id_categorie_client'];
                                                                                                                                                                                                } else {
                                                                                                                                                                                                    echo $row['id_id_categorie_client'];
                                                                                                                                                                                                }  ?>">
                                                            <?php if ($row['id_id_categorie_client'] < 10) {
                                                                echo "0" . $row['id_id_categorie_client'];
                                                            } else {
                                                                echo $row['id_id_categorie_client'];
                                                            } ?>
                                                        </div>
                                                        <div class="" style="font-weight: bold;text-transform: uppercase;font-size: 12px; margin-bottom: 10px;">
                                                            <?php echo $row["nom_categorie_client"]; ?>
                                                        </div>

                                                        <div class="fab-container">

                                                            <div class="fab fab-icon-holder fab-button" id="fab-button_<?php echo $row['id_categorie_client']; ?>" data-id="<?php echo $row['id_categorie_client']; ?>">
                                                                <i class="fas fa-question"></i>
                                                            </div>
                                                            <div class="fab fab-icon-holder fab-hide" id="fab-hide_<?php echo $row['id_categorie_client']; ?>" data-id="<?php echo $row['id_categorie_client']; ?>" style="display: none;">
                                                                <i class="fas fa-times"></i>
                                                            </div>
                                                            <ul class="fab-options fab-show" id="fab-show_<?php echo $row['id_categorie_client']; ?>" style="display: none;">

                                                                <li>
                                                                    <span class="fab-label">Modification</span>
                                                                    <div class="fab-icon-holder updatebtn_<?php echo $row['id_categorie_client']; ?>" id="updatebtn" data-id="<?php echo $row['id_categorie_client']; ?>">
                                                                        <i class="fas fa-edit" id="shared"></i>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <span class="fab-label">Suppression</span>
                                                                    <div class="fab-icon-holder deletebtn_<?php echo $row['id_categorie_client']; ?>" id="deletebtn" data-id="<?php echo $row['id_categorie_client']; ?>">
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
    $query = "SELECT MAX(id_id_categorie_client)+1 AS num FROM categorie_client INNER JOIN boutique ON boutique.id_boutique=categorie_client.id_boutique WHERE boutique.id_boutique='$id' ORDER BY id_categorie_client DESC";

    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    ?>
    <form id="insert_form" enctype="multipart/form-data">
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
                        <input type="hidden" name="id_id_categorie_client" id="" value="<?php if ($result["num"] == null) {
                                                                                            echo "1";
                                                                                        } else {
                                                                                            echo $result["num"];
                                                                                        } ?>">
                        <input name="id_boutique" type="hidden" class="form-control form-control-sm" required="" value="<?php echo $id; ?>" />
                        <div class="form-group">
                            <label>Categorie</label>
                            <input name="nom_categorie_client" id="ajouter_catégorie" type="text" class="form-control form-control-sm" placeholder="Categorie" required onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="insertdata">Enregister</button>
                        <button type="button" id="fermer" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!------FIN FORMULAIRE AJOUTER------->
    <!------FORMULAIRE MODIFIER------->
    <form id="update_form" enctype="multipart/form-data">
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Modifié !</h5>
                        <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                    </div>
                    <div class="modal-body">
                        <input name="edit_id" type="hidden" id="edit_id">


                        <div class="form-group">
                            <label>Categorie</label>
                            <input name="nom_categorie_client" id="nom_categorie_client" type="text" class="form-control form-control-sm" placeholder="Categorie" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="updatetdata" class="btn btn-primary">Modifier</button>
                        <button type="button" class="btn btn-outline-danger" id="fermerm" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!------FIN FORMULAIRE MODIFIER------->
    <!------FORMULAIRE SUPPRIMER------->
    <form id="delete_form" enctype="multipart/form-data">
        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Supprimer !</h5>
                        <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                    </div>
                    <div class="modal-body">
                        <label>Voulez-vous vraiment supprimer cette categorie ?</label>
                        <input name="delete_id" type="hidden" id="delete_id" class="form-control form-control-sm" readonly />
                        <input name="" type="text" id="del_cat" class="form-control form-control-sm" readonly />
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="deletedata" class="btn btn-primary">Supprimer</button>
                        <button type="button" class="btn btn-outline-danger" id="fermers" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!------FIN FORMULAIRE SUPPRIMER------->
    <!------FORMULAIRE EMAIL------->
    <form id="form_email">
        <div class="modal fade " id="infomodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content ">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalLabel"> Email !</h5>
                        <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                    </div>
                    <div class="modal-body">
                        <input name="edit_id_info" type="hidden" id="edit_id_info">
                        <input type="hidden" name="id_boutique_email" id="id_boutique_email" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label>Objet</label>
                            <input type="text" name="objet" id="objet" class="form-control form-control-sm" required>
                        </div>
                        <label>Message</label>
                        <textarea class="description"></textarea>

                    </div>
                    <div class="modal-footer">
                        <button name="btn_envoyer" class="btn btn-primary btn_email" id="btn_email" type="button">Envoyer</i>
                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!------FIN FORMULAIRE INFO------->
    <form id="import_form" enctype="multipart/form-data">
        <div class="modal fade" id="importmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
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
                                        <th>Categorie client</th>
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

        $query = "SELECT * FROM categorie_client 
                                INNER JOIN boutique ON boutique.id_boutique=categorie_client.id_boutique
                                 WHERE boutique.id_boutique='$id' ORDER BY id_categorie_client DESC";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $total_row = $statement->rowCount();
        if ($total_row > 0) {
            foreach ($result as $row) {
        ?>
                <tr>
                    <td><?php echo $row["nom_categorie_client"]; ?></td>
            <?php
            }
        }
            ?>
    </table>
    <input type="hidden" name="" id="information">

    <!------FORMULAIRE VOCAL------->
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
        $(document).on('click', '#insertdata', function(e) {
            $("#insertdata").prop("disabled", true)

            var form_data = $("#insert_form").serialize();
            $.ajax({
                url: "../controller/categorie_client/insert",
                method: "POST",
                data: form_data,
                success: function(data) {
                    console.log(data)

                }

            })
            $('#exampleModal').modal("hide");

            swal({
                title: "Enregistré!",
                text: "Enregistrement effectué avec succés.",
                type: "success",
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showConfirmButton: false,
                timer: 2000
            }, function() {
                window.location.href = "categorie_client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
            });
        })
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
                    url: '../controller/categorie_client/import',
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
                    window.location.href = "categorie_client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
                });
            }
        });
        $(document).on('click', '#updatetdata', function(e) {
            $("#updatetdata").prop("disabled", true)
            var form_data = $("#update_form").serialize();
            $.ajax({
                url: "../controller/categorie_client/update",
                method: "POST",
                data: form_data,
                success: function(data) {
                    console.log(data)

                }
            })
            $('#editmodal').modal("hide");

            swal({
                title: "Modifié!",
                text: "Modification effectuée avec succés.",
                type: "success",
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showConfirmButton: false,
                timer: 2000
            }, function() {
                window.location.href = "categorie_client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
            });
        })
        $(document).on('click', '#deletedata', function(e) {

            var form_data = $("#delete_form").serialize();
            $.ajax({
                url: "../controller/categorie_client/delete",
                method: "POST",
                data: form_data,
                success: function(data) {
                    console.log(data)
                }
            })
            $('#deletemodal').modal("hide");

            swal({
                title: "Supprimé!",
                text: "Suppression effectuée avec succés.",
                type: "error",
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showConfirmButton: false,
                timer: 2000
            }, function() {
                window.location.href = "categorie_client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
            });
        })

        $(document).on('click', '.btn_email', function(e) {
            var id_categorie = $("#edit_id_info").val();
            var objet = $("#objet").val();
            var description = $(".description").val();
            var id_boutique = $("#id_boutique_email").val();
            $.ajax({
                type: "GET",
                url: "../email/email_promotion",
                data: {
                    id_categorie: id_categorie,
                    objet: objet,
                    description: description,
                    id_boutique: id_boutique
                },
                success: function(data) {
                    console.log(data)

                }
            })
            $("#infomodal").modal("hide");
            swal({
                title: "Email!",
                text: "Email envoyé avec succés.",
                type: "success",
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showConfirmButton: false,
                timer: 2000
            }, function() {
                window.location.href = "categorie_client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
            });


        })
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

            e.preventDefault();

            var chambre = $(this).data('id');
            $.ajax({
                url: "../controller/categorie_client/fetch_categorie_client",
                type: "post",
                data: {
                    chambre: chambre
                },
                dataType: 'json',
                success: function(data) {
                    $("#edit_id").val(data.id_categorie_client);
                    $("#nom_categorie_client").val(data.nom_categorie_client);
                    $("#editmodal").modal("show");

                }
            });
        });
        $(document).on('click', '#infobtn', function(e) {
            e.preventDefault();

            var chambre = $(this).data('id');
            $.ajax({
                url: "../controller/categorie_client/fetch_categorie_client",
                type: "post",
                data: {
                    chambre: chambre
                },
                dataType: 'json',
                success: function(data) {
                    $("#edit_id_info").val(data.id_categorie_client);
                    $("#infomodal").modal("show");

                }
            });
        });

        $(document).on('click', '#deletebtn', function(e) {

            e.preventDefault();

            var chambre = $(this).data('id');
            $.ajax({
                url: "../controller/categorie_client/fetch_categorie_client",
                type: "post",
                data: {
                    chambre: chambre
                },
                dataType: 'json',
                success: function(data) {
                    $("#delete_id").val(data.id_categorie_client);
                    $("#del_cat").val(data.nom_categorie_client);
                    $("#deletemodal").modal("show");

                }
            });
        });
    </script>
    <script>
        $('.description').summernote({
            editing: true,
            lang: 'fr-FR',
            height: 150,
            toolbar: [
                ['insert', ['picture', 'link', 'video', 'table', 'hr', 'summernoteGallery']],
                ['font style', ['fontname', 'fontsize', 'color', 'bold', 'italic',
                    'underline', 'strikethrough', 'superscript', 'subscript', ''
                ]],
                ['paragraph style', ['style', 'ol', 'ul', 'paragraph', 'height']],
                ['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
                ['extensions', ['summernoteGallery']],
            ],
            summernoteGallery: {
                source: {
                    // data: data,
                    url: location.origin + location.pathname + '/server/example.json',
                    responseDataKey: 'data',
                    nextPageKey: 'links.next',
                },
                modal: {
                    loadOnScroll: true,
                    noImageSelected_msg: 'No image was selected, please select one by clicking it!',
                },
                buttonLabel: '<i class="fa fa-file-image-o"></i> SN Gallery'
            }

        });
    </script>
    <script>
        var scrolled = 0;
        if (annyang) {
            annyang.setLanguage('fr-FR');
            // Let's define our first command. First the text we expect, and then the function it should call
            var commands = {
                'catégorie': function() {
                    $("#ajouter_catégorie").focus()
                },
                'modifier catégorie': function() {
                    $("#nom_categorie_client").focus()

                },
                'ajouter': function() {
                    $('#ajouter').click();
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
                        $('#updatetdata').click();
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
                        $('#deletedata').click();
                    }
                },
                'enregistrer': function() {
                    $('#insertdata').click();
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
                        $('#updatetdata').click();
                    }
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
                        $('#deletedata').click();
                    }
                },
                'fermer': function() {
                    $('#fermer').click();
                    $('#fermerm').click();
                    $('#fermers').click();
                    $('#fermeri').click();
                    var id = $('#numv').val()
                    $('#fab-hide_' + id).click();
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
                    $('#vocal').modal('show');
                    setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        $('#editmodal').modal('hide');
                        $('#deletemodal').modal('hide');
                        $("#fermeri").click();
                        window.location.href = "categorie_client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";

                    }, 1000);
                },
                'arrêter la recherche': function(variables) {
                    $("#search").val("");
                    if ($("#search").val(variables)) {
                        $(".searchBox").keyup();
                    }
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
                        url: "../controller/categorie_client/fetch_categorie_client",
                        type: "post",
                        data: {
                            id_champ: id_champ,
                            id_boutiques: id_boutiques
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data.id_categorie_client);
                            $("#numv").val(data.id_categorie_client)
                            $("#edit_id").val(data.id_categorie_client);
                            $("#delete_id").val(data.id_categorie_client);

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

                            rows.append(`
                        <tr class="body_caption_top">
                           <td>
                              <div class="form-group">
                                <input name="nom_categorie_client[]" id="ajouter_catégorie" type="text" class="form-control form-control-sm" placeholder="Categorie" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[0]}"/>
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
                filename: "Categorie_client.xls", // inclure l'extension 
                preserveColors: false // définir sur true si vous souhaitez que les couleurs d'arrière-plan et les couleurs de police soient préservées 
            });
        });
    </script>

<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
    header("Location:../");
}
?>