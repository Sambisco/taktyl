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
<link rel="stylesheet" href="../assets/css/button.css">
<?php
if (isset($_GET['mail'])) {
    $mail= $_SESSION['mail']=$_GET['mail'];
  }
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $id_d = encryptor('decrypt',$id);
  }
  $b=$_GET['b'];
  ?>
<style>
    .img-thumbnail-mobile{
        width: 100%;
            height:120px
    }
     @media (max-width:576px) {
        .img-thumbnail-mobile{
            width: 100%;
            height:auto;
        }
     }
</style>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Boutique</h1>
        <ol class="breadcrumb">
            
            <li class="breadcrumb-item"><a href="dashboard?mail=<?php echo $mail; ?>">Accueil</a></li>
            
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

                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal">Ajouter</button>


                    <div class="col-md-3">
                        <input type="text" id="search" data-filter class="form-control form-control-sm searchBox"
                            placeholder="Rechercher...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-3 bg-gradient-login">
                        <div class="row mb-3 parent" id="contentpage">
                            <!-- debut -->
                            <?php

                $query = "SELECT * FROM boutique INNER JOIN user ON boutique.iduser=user.iduser WHERE user.iduser='$id_d' ORDER BY id_boutique DESC";
                $statement = $db->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $total_row = $statement->rowCount();
                if ($total_row > 0) {
                  foreach ($result as $row) {
                ?>

                            <div class="col-xl-2 col-md-6 mb-4 box result well">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <center>
                                            <div style="margin-bottom:10px ;">
                                                <?php if ($row["logo"] == "") { ?>
                                                <img src="../img/img/image.jpg" class="img-thumbnail img-thumbnail-mobile"
                                                     alt="card image cap">
                                                <?php } else { 
                                                    ?>
                                                      <img src="<?php echo $row["logo"];?>" class="img-thumbnail img-thumbnail-mobile" alt="card image cap">
                                                    <?php
    
                                            }
                                                    ?>
                                               
                                            </div>
                                            <div class="name"
                                                style="font-weight: bold;text-transform: uppercase;font-size: 12px;">
                                                <?php echo $row["nomb"]; ?>
                                            </div>

                                            <div class="sku" style="margin-bottom:10px ;">
                                                <?php echo $row["lieu"]; ?>
                                            </div>
                                            <div class="fab-container">

                                                <div class="fab fab-icon-holder fab-button"
                                                    id="fab-button_<?php echo $row['id_boutique']; ?>"
                                                    data-id="<?php echo $row['id_boutique']; ?>">
                                                    <i class="fas fa-question"></i>
                                                </div>
                                                <div class="fab fab-icon-holder fab-hide"
                                                    id="fab-hide_<?php echo $row['id_boutique']; ?>"
                                                    data-id="<?php echo $row['id_boutique']; ?>">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                                <ul class="fab-options fab-show"
                                                    id="fab-show_<?php echo $row['id_boutique']; ?>">
                                                    <li>
                                                        <span class="fab-label">Information</span>
                                                        <div class="fab-icon-holder" id="infobtn"
                                                            data-id="<?php echo $row['id_boutique']; ?>">
                                                            <i class="fas fa-info" id="shared"></i>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span class="fab-label">Modifier</span>
                                                        <div class="fab-icon-holder" id="updatebtn"
                                                            data-id="<?php echo $row['id_boutique']; ?>">
                                                            <i class="fas fa-edit" id="shared"></i>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span class="fab-label">Supprimer</span>
                                                        <div class="fab-icon-holder" id="deletebtn"
                                                            data-id="<?php echo $row['id_boutique']; ?>">
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

<!---------FIN CONTENT FLUID------------>
<!------FORMULAIRE AJOUTER------->
<form id="insertForm">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                            <input type="hidden" name="iduser" value="<?php echo $id_d; ?>">

                                <label>Nom boutique</label>
                                <input name="nomb" type="text" class="form-control form-control-sm"
                                    placeholder="Nom boutique" required=""
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Lieu</label>
                                <input name="lieu" type="text" class="form-control form-control-sm" placeholder="Lieu"
                                    required=""
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input name="telephone" type="text" class="form-control form-control-sm"
                                    placeholder="Telephone" required=""
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="text" class="form-control form-control-sm" placeholder="Email"
                                    required=""
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Site web</label>
                                <input name="web" type="text" class="form-control form-control-sm"
                                    placeholder="Site web" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>NINEA</label>
                                <input name="ninea" type="text" class="form-control form-control-sm" placeholder="NINEA"
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" name="logo" id="logo" onchange="showLogo(event);"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Cachet electronique</label>
                                <input type="file" name="cachet" id="cachet" accept="image/*"
                                    onchange="showCachet(event);" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="d-flex flex-column align-items-center text-center">
                                <br />
                                <img id='file-ip-1-logo' class="rounded-circle" width="100" height="100" />
                            </div>
                        </div>

                        <div class="col">
                            <div class="d-flex flex-column align-items-center text-center">
                                <br />
                                <img id='file-ip-1-cachet' class="rounded-circle" width="100" height="100" />
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="insertdata">Enregister</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!------FIN FORMULAIRE AJOUTER------->
<!------FORMULAIRE MODIFIER------->
<form id="updateForm">
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifié !</h5>
                    <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span
                            aria-hidden="true"></span>&times;</button>
                </div>
                <div class="modal-body">
                    <input name="edit_id" type="hidden" id="edit_id">

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">

                                <label>Nom boutique</label>
                                <input name="nomb" id="nomb" type="text" class="form-control form-control-sm"
                                    placeholder="Nom boutique" required=""
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Lieu</label>
                                <input name="lieu" id="lieu" type="text" class="form-control form-control-sm"
                                    placeholder="Lieu" required=""
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input name="telephone" id="telephone" type="text" class="form-control form-control-sm"
                                    placeholder="Telephone" required=""
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" id="email" type="text" class="form-control form-control-sm"
                                    placeholder="Email" required=""
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Site web</label>
                                <input name="web" id="web" type="text" class="form-control form-control-sm"
                                    placeholder="Site web"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>NINEA</label>
                                <input name="ninea" id="ninea" type="text" class="form-control form-control-sm"
                                    placeholder="NINEA" 
                                    onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col">
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" name="logo" id="imgInp-logo" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col">
                        <div class="form-group">
                                <label>Cachet electronique</label>
                                <input type="file" name="cachet" id="imgInp-cachet" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="d-flex flex-column align-items-center text-center">
                                <br />
                                <span id='img-upload-logo' class="rounded-circle" width="100" height="100"></span>
                                <img id='img-uploads-logo' class="rounded-circle" width="100" height="100" />
                            </div>
                        </div>

                        <div class="col">
                            <div class="d-flex flex-column align-items-center text-center">
                                <br />
                                <span id='img-upload-cachet' class="rounded-circle" width="100" height="100"></span>
                                <img id='img-uploads-cachet' class="rounded-circle" width="100" height="100" />
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" id="updatetdata" class="btn btn-primary">Modifier</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!------FIN FORMULAIRE MODIFIER------->
<!------FORMULAIRE INFO------->
<div class="modal fade" id="infomodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Modifié !</h5>
                <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span
                        aria-hidden="true"></span>&times;</button>
            </div>
            <form action="../controller/hotel" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input name="info_id" type="hidden" id="info_id">

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Nom boutique :</label>
                                <div id="info_nomb"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Lieu :</label>
                                <div id="info_lieu"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Telephone :</label>
                                <div id="info_telephone"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email :</label>
                                <div id="info_email"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label>Site web :</label>
                                <div id="info_web"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>NINEA :</label>
                                <div id="info_ninea"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col">
                        <div class="form-group">
                                <label>Logo :</label>
                                <div id="info_img_logo"></div>
                            </div>
                        </div>
                        <div class="col">
                        <div class="form-group">
                                <label>Cachet electronique :</label>
                                <div id="info_img_cachet"></div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                </div>
        </div>
    </div>
</div>
</form>

<!------FIN FORMULAIRE INFO------->
<!------FORMULAIRE SUPPRIMER------->
<form id="deleteForm" enctype="multipart/form-data">
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Supprimer !</h5>
                    <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span
                            aria-hidden="true"></span>&times;</button>
                </div>
                <div class="modal-body">
                    <label>Voulez-vous vraiment supprimer cette boutique ?</label>
                    <input name="delete_id" type="hidden" id="delete_id" class="form-control form-control-sm"
                        readonly />
                    <input name="" type="text" id="nom_del" class="form-control form-control-sm" readonly />
                </div>

                <div class="modal-footer">
                    <button type="submit" id="deletedata" class="btn btn-primary">Supprimer</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!------FIN FORMULAIRE SUPPRIMER------->
<!------FORMULAIRE PROFIL------->
<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Profil employé</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
                    <i class="glyphicon glyphicon-user"></i>
                </h4>
            </div>
            <div class="modal-body">

                <div id="modal-loader" style="display: none; text-align: center;">
                    <img src="ajax-loader.gif">
                </div>
                <!-- content will be load here -->
                <div id="dynamic-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>

</div>

<!------FORMULAIRE PROFIL------->
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

    $("#nb_boutique").on('click', function(e) {
        swal({
            title: "Erreur!",
            text: "Vous avez droit qu'à 3 boutiques.",
            type: "error",
            confirmButtonText: 'Ok',
            confirmButtonColor: '#3085d6',
            showConfirmButton: false,
            timer: 2000
        })
    })
    $("#insertForm").on('submit', function(e) {
        $('#exampleModal').modal("hide");

        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '../controller/boutique/insert',
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
            window.location.href = "boutique?mail=<?php echo  $mail; ?>&id=<?php echo  $id_m; ?>&b=<?php echo  $b; ?>";
        });
    });

    $("#updateForm").on('submit', function(e) {
        $('#editmodal').modal("hide");

        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '../controller/boutique/update',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#updatetdata').attr("disabled", "disabled");
            },
            success: function(response) {
console.log(response)
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
            window.location.href = "boutique?mail=<?php echo  $mail; ?>&id=<?php echo  $id_m; ?>&b=<?php echo  $b; ?>";
        });
    });

    $("#deleteForm").on('submit', function(e) {
        $('#deletemodal').modal("hide");

        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '../controller/boutique/delete',
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
            window.location.href = "boutique?mail=<?php echo  $mail; ?>&id=<?php echo  $id_m; ?>&b=<?php echo  $b; ?>";
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
$(".fab-show").hide();
$('.fab-hide').hide();
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

$("#id_categorie").select2({
    dropdownParent: $("#exampleModal")
});
$("#edit_id_categorie").select2({
    dropdownParent: $("#editmodal")
});

function showLogo(event) {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("file-ip-1-logo");
        preview.src = src;
        preview.style.display = "block";
    }
}

function showCachet(event) {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("file-ip-1-cachet");
        preview.src = src;
        preview.style.display = "block";
    }
}
$('#img-uploads-logo').hide();
$('#img-uploads-cachet').hide();
$(document).ready(function() {
    $(document).on('change', '.btn-file :file', function() {

        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });


    function readURL_Logo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#img-uploads-logo').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp-logo").change(function() {
        readURL_Logo(this);
        $('#img-uploads-logo').show();
        $('#img-upload-logo').hide();
    });

    function readURL_Cachet(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#img-uploads-cachet').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp-cachet").change(function() {
        readURL_Cachet(this);
        $('#img-uploads-cachet').show();
        $('#img-upload-cachet').hide();
    });
});

$(document).on('click', '#updatebtn', function(e) {
    $('#img-uploads').show();
    $('#img-uploadss').hide();
    e.preventDefault();

    var id_boutique = $(this).data('id');
    $.ajax({
        url: "../controller/boutique/fetch_boutique",
        type: "post",
        data: {
            id_boutique: id_boutique
        },
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#edit_id").val(data.id_boutique);
            $("#nomb").val(data.nomb);
            $("#lieu").val(data.lieu);
            $("#telephone").val(data.telephone);
            $("#email").val(data.email);
            $("#web").val(data.web);
            $("#ninea").val(data.ninea);
            $("#img-upload-logo").html(data.logo);
            $("#img-upload-cachet").html(data.cachet);
            $("#editmodal").modal("show");

        }
    });
});
$(document).on('click', '#infobtn', function(e) {
    $('#img-uploads').show();
    $('#img-uploadss').hide();
    e.preventDefault();

    var id_boutique = $(this).data('id');
    $.ajax({
        url: "../controller/boutique/fetch_boutique",
        type: "post",
        data: {
            id_boutique: id_boutique
        },
        dataType: 'json',
        success: function(data) {

            $("#info_id").val(data.id_boutique);
            $("#info_nomb").html(data.nomb);
            $("#info_lieu").html(data.lieu);
            $("#info_telephone").html(data.telephone);
            $("#info_email").html(data.email);
            $("#info_web").html(data.web);
            $("#info_ninea").html(data.ninea);
            $("#info_img_logo").html(data.logo);
            $("#info_img_cachet").html(data.cachet);
            $("#infomodal").modal("show");

        }
    });
});
$(document).on('click', '#deletebtn', function(e) {
    $('#img-uploads').show();
    $('#img-uploadss').hide();
    e.preventDefault();

    var id_boutique = $(this).data('id');
    $.ajax({
        url: "../controller/boutique/fetch_boutique",
        type: "post",
        data: {
            id_boutique: id_boutique
        },
        dataType: 'json',
        success: function(data) {

            $("#delete_id").val(data.id_boutique);
            $("#nom_del").val(data.nomb);
            $("#deletemodal").modal("show");

        }
    });
});
</script>




<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
  header("Location:../");
}
?>