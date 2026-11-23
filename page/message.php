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
    .toggle {
      --width: 120px;
      --height: calc(var(--width) / 3.5);

      position: relative;
      display: inline-block;
      width: var(--width);
      height: var(--height);
      box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
      border-radius: var(--height);
      cursor: pointer;
    }

    .toggle input {
      display: none;
    }

    .toggle .slider {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: var(--height);
      background-color: #0275d8;
      transition: all 0.4s ease-in-out;
    }

    .toggle .slider::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: calc(var(--height));
      height: calc(var(--height));
      border-radius: calc(var(--height) / 2);
      background-color: #fff;
      box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
      transition: all 0.4s ease-in-out;
    }

    .toggle input:checked+.slider {
      background-color: #d9534f;
    }

    .toggle input:checked+.slider::before {
      transform: translateX(calc(var(--width) - var(--height)));
    }

    .toggle .labels {
      position: absolute;
      top: 8px;
      left: 0;
      width: 100%;
      height: 100%;
      font-size: 13px;
      font-family: sans-serif;
      transition: all 0.4s ease-in-out;
    }

    .toggle .labels::after {
      content: attr(data-off);
      position: absolute;
      right: 15px;
      color: #ffff;
      opacity: 1;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
      transition: all 0.4s ease-in-out;
    }

    .toggle .labels::before {
      content: attr(data-on);
      position: absolute;
      left: 15px;
      color: #ffffff;
      opacity: 0;
      text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.4);
      transition: all 0.4s ease-in-out;
    }

    .toggle input:checked~.labels::after {
      opacity: 0;
    }

    .toggle input:checked~.labels::before {
      opacity: 1;
    }

  
  </style>
    <link rel="stylesheet" href="../assets/css/fab.css">
    
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Messagerie</h1>
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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush table-hover" id="dataTableHover" data-order='[[0,"desc"]]' width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th >Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>ID</th>
                                        <th>Client</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $query = "SELECT *,DATE_FORMAT(date, '%m/%d/%Y %H:%i') AS date FROM message INNER JOIN categorie_client ON categorie_client.id_categorie_client=message.id_categorie_client INNER JOIN boutique ON boutique.id_boutique=categorie_client.id_boutique WHERE boutique.id_boutique='$id'";
                                    $statement = $db->prepare($query);
                                    $statement->execute();
                                    $result = $statement->fetchAll();
                                    $total_row = $statement->rowCount();
                                    if ($total_row > 0) {
                                        foreach ($result as $row) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["id_message"]; ?></td>
                                                <td><?php echo $row["nom_categorie_client"]; ?></td>
                                                <td><?php echo $row["message"]; ?></td>
                                                <td><?php echo $row["date"]; ?> </td>
                                                <td>
					  <button class="btn btn-outline-danger btn-sm deletebtn"> <i class="fa fa-trash"></i></button>
					  </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div>
        <div class="fab-container" style="float: right;	position: fixed;bottom: 270px;right: 10px;">

            <div class="input-group mb-3">

                <div class="input-group-append">
                    <div class="fab fab-icon-holder fab-button" style="cursor: pointer;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="fab fab-icon-holder fab-hide" style="cursor: pointer;display: none;">
                        <i class="fas fa-close"></i>
                    </div>
                </div>
            </div>
            <ul class="fab-options fab-show" style="display: none;">
                
                <li>
                    <span class="fab-label">Email</span>
                    <div class="fab-icon-holder" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-at"></i>
                    </div>
                </li>
                <li>
                    <span class="fab-label">SMS</span>
                    <div class="fab-icon-holder" data-toggle="modal" data-target="#exampleModal1">
                        <i class="fas fa-phone"></i>
                    </div>
                </li>

            </ul>
        </div>
    </div>
    </form>
    </div>
    <!------FORMULAIRE EMAIL------->
    <?php
    $query = "SELECT * FROM boutique WHERE id_boutique='$id'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    ?>
        <form id="form_email">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Message Email</h5>
                    <div class="form-group" style="float: right;">
                            
                    </div>
                                    </div>
                <div class="modal-body">
                    <div id="email">
                    <div class="form-group">
                        <label>Categorie client</label>
                        <input type="hidden" name="" id="saveemail" value="Email">
                        <input type="hidden" name="id_boutique_email" id="id_boutique_email" value="<?php echo $id; ?>">
                        <select class="form-control form-control-sm" required id="edit_id_info" style="width: 100%;">
                        <option value="">Choisissez</option>
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
<option value="<?php echo $row["id_categorie_client"]; ?>"><?php echo $row["nom_categorie_client"]; ?></option>
<?php 
}
}?>
                        </select>
                    </div>
                    <div class="form-group">
                            <label>Objet</label>
                            <input type="text" name="objet" id="objet" class="form-control form-control-sm" required >
                        </div>
                            <label>Message</label>
                            <textarea class="description" placeholder="Message"></textarea>
                            </div>
                            <div id="promotion" style="display: none;">
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
        if(strtotime($row["datefin"]) < strtotime(date("Y-m-d"))) {

        }else{
?>
<div id="promotion_<?php echo $row['id_promotion'] ?>" style="display: inline-block;">
                                <div style="font-size: 14px; display: inline-block;font-weight: bold;">
<?php echo $row['description_article'] ?>
                                </div>
                                <div style="font-size: 14px; display: inline-block;">
<?php echo $row['datedeb'] ?>
                                </div>
                                <div style="font-size: 14px; display: inline-block;color: #d9534f;">
<?php echo $row['reduction'] ?>%
                                </div>
                                <div style="font-size: 14px; display: inline-block;">
<?php echo $row['conditions'] ?>
                                </div>
                                </div>
                                <div style="font-size: 14px; display: inline-block;">
                                <input type="checkbox" class="id_promotion"  id="id_promotion_<?php echo $row['id_promotion'] ?>" data-id="<?php echo $row['id_promotion'] ?>
" >                            </div>
                                <?php 
                                
                            }
                            }
                            } 
                        
                            ?>
                            </div>
                </div>
                <div class="modal-footer">
                <button name="btn_envoyer" class="btn btn-primary btn_email" id="btn_email" type="button">Envoyer</i>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <!------FIN FORMULAIRE EMAIL------->
    <!------FORMULAIRE SMS------->
    <?php
    $query = "SELECT * FROM boutique WHERE id_boutique='$id'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    ?>
        <form id="form_sms">
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Message SMS</h5>
                    <div class="form-group" style="float: right;">
                            
                    </div>
                                    </div>
                <div class="modal-body">
                    <div id="sms">
                    <div class="form-group">
                        <label>Categorie client</label>
                        <input type="hidden" name="" id="savesms" value="sms">
                        <input type="hidden" name="id_boutique_sms" id="id_boutique_sms" value="<?php echo $id; ?>">
                        <select class="form-control form-control-sm" required id="edit_id_info_sms" style="width: 100%;">
                        <option value="">Choisissez</option>

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
<option value="<?php echo $row["id_categorie_client"]; ?>"><?php echo $row["nom_categorie_client"]; ?></option>
<?php 
}
}?>
                        </select>
                    </div>
                   
                            <label>Message</label>
                            <textarea class="description_sms" placeholder="Message"></textarea>
                            </div>
                            <div id="promotion_sms" style="display: none;">
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
        if(strtotime($row["datefin"]) < strtotime(date("Y-m-d"))) {

        }else{
?>
<div id="promotion_sms_<?php echo $row['id_promotion'] ?>" style="display: inline-block;">
                                <div style="font-size: 14px; display: inline-block;font-weight: bold;">
<?php echo $row['description_article'] ?>
                                </div>
                                <div style="font-size: 14px; display: inline-block;">
<?php echo $row['datedeb'] ?>
                                </div>
                                <div style="font-size: 14px; display: inline-block;color: #d9534f;">
<?php echo $row['reduction'] ?>%
                                </div>
                                <div style="font-size: 14px; display: inline-block;">
<?php echo $row['conditions'] ?>
                                </div>
                                </div>
                                <div style="font-size: 14px; display: inline-block;">
                                <input type="checkbox" class="id_promotion_sms"  id="id_promotion_sms_<?php echo $row['id_promotion'] ?>" data-id="<?php echo $row['id_promotion'] ?>
" >                            </div>
                                <?php 
                                
                            }
                            }
                            } 
                        
                            ?>
                            </div>
                </div>
                <div class="modal-footer">
                <button name="btn_envoyer" class="btn btn-primary btn_sms" id="btn_sms" type="button">Envoyer</i>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <!------FIN FORMULAIRE SMS------->
    <!------FORMULAIRE MODIFIER------->
    <div class="modal fade" id="exampleModal0" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifié</h5>
                    <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                </div>
                <form action="../controller/user" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input name="update_user" type="hidden" id="update_user">

                        <div class="form-group">
                            <label>Telephone</label>
                            <input name="telephoneconf" type="text" id="nom" class="form-control form-control-sm" placeholder="Telephone" required readonly="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="emailconf" id="logins" type="text" class="form-control form-control-sm" placeholder="Email" required readonly="">
                        </div>


                        <input type="hidden" name="id_boutique" value="<?php echo $id; ?>">

                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input name="passwordconf" id="newpassword" type="password" class="form-control form-control-sm" placeholder="Nouveau Mot de passe" />
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="updatetdata" class="btn btn-primary">Modifier</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>


                    </div>
                </form>
            </div>
        </div>
    </div>
    <!------FIN FORMULAIRE MODIFIER------->
    <!------FORMULAIRE SUPPRIMER------->
    <form id="deleteForm" enctype="multipart/form-data">
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Supprimer</h5>
                    <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
                </div>
                    <div class="modal-body">
                        <input name="delete_id" type="hidden" id="delete_id" />
                        <input type="hidden" name="id_boutique" value="<?php echo $id; ?>">
                        <h4>Voulez-vous vraiment supprimer ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="deletedata"  class="btn btn-primary">Supprimer</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>

                    </div>
            </div>
        </div>
    </div>
    </form>

    <!------FIN FORMULAIRE SUPPRIMER------->
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

    <!---Container Fluid-->
    <script>
         
      $("#deleteForm").on('submit', function(e) {
        $('#deletemodal').modal("hide");

        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: '../email/delete',
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
                timer:2000
        }, function() {
          window.location.href = "message?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
        });
      });

        $(document).on('click', '.btn_email', function(e) {
            var id_categorie = $("#edit_id_info").val();
            var objet = $("#objet").val();
            var description = $(".description").val();
            var id_boutique = $("#id_boutique_email").val();
            var saveemail = $("#saveemail").val();
            if (navigator.onLine) {
     
            $.ajax({
                type: "GET",
                url: "../email/email_promotion",
                data: {
                    id_categorie: id_categorie,
                    objet: objet,
                    description: description,
                    id_boutique:id_boutique,
                    saveemail:saveemail
                },
                success: function(data) {
                    console.log(data)

                }
            })
            $("#exampleModal").modal("hide");
            swal({
                title: "Email!",
                text: "Email envoyé avec succés.",
                type: "success",
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showConfirmButton: false,
                timer:2000
            }, function() {
                window.location.href = "message?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
            });
    }else {
        $("#exampleModal").modal("hide");
            swal({
                title: "Connexion perdue!",
                text: "vous n'etes pas connecté à internet.",
                type: "error",
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showConfirmButton: false,
                timer:2000
            });
    }

        })
        $(document).on('click', '.btn_sms', function(e) {
            var id_categorie_sms = $("#edit_id_info_sms").val();
            var description_sms = $(".description_sms").val();
            var savesms = $("#savesms").val();
            if (navigator.onLine) {
     
            $.ajax({
                type: "GET",
                url: "../sms/messagesms",
                data: {
                    id_categorie_sms: id_categorie_sms,
                    description_sms: description_sms,
                    savesms:savesms
                },
                success: function(data) {
                    console.log(data)

                }
            })
            $("#exampleModal1").modal("hide");
            swal({
                title: "SMS!",
                text: "SMS envoyé avec succés.",
                type: "success",
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showConfirmButton: false,
                timer:2000
            }, function() {
                window.location.href = "message?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
            });
        }else{
            $("#exampleModal1").modal("hide");
            swal({
                title: "Connexion perdue!",
                text: "vous n'etes pas connecté à internet.",
                type: "error",
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showConfirmButton: false,
                timer:2000
            }); 
        }

        })
        $('.fab-button').on('click', function() {
            $(".fab-show").show(600);
            $(".fab-hide").show();
            $(".fab-button").hide();
        })
        $('.fab-hide').on('click', function() {
            $(".fab-button").show();

            $(".fab-show").hide(600);
            $(".fab-hide").hide();
        })

        $(document).ready(function() {
            $('#edit_id_info').select2({
                dropdownParent: $("#exampleModal")
            });
            $('#edit_id_info_sms').select2({
                dropdownParent: $("#exampleModal1")
            });
            $('#edit_id_boutique').select2({
                dropdownParent: $("#editmodal")
            });

            $(".editbtn").click(function() {
                $("#editmodal").modal('show');
                $str = $(this).closest('tr');
                var data = $str.children("td").map(function() {
                    return $(this).text();
                }).get();
                console.log(data);
                $("#update_user").val(data[0]);
                $("#nom").val(data[1]);
                $("#logins").val(data[2]);
                $("#profil").val(data[3]);
            });
        });
        $(document).ready(function() {
            $(".deletebtn").click(function() {
                $("#deletemodal").modal('show');
                $str = $(this).closest('tr');
                var data = $str.children("td").map(function() {
                    return $(this).text();
                }).get();
                console.log(data);
                $("#delete_id").val(data[0]);
            });
        });
        $(document).ready(function() {
            $(document).on('change', '.id_promotion', function(e) {
                count++;
                var id = $(this).data('id');
                e.preventDefault();
                if ($("#id_promotion_"+id).is(":checked")) {
                $("#description").append('<div data-mode="' + id + '"">'+$("#promotion_"+id).html()+'</div>');
                }else{
                    $("[data-mode='" + id + "']").remove();
                        }
            });
            $(document).on('change', '.choisirpromoemail', function(e) {
                e.preventDefault();
                if ($(this).is(":checked")) {
                $("#email").hide();
                $("#promotion").show();
                }else{
                    $("#email").show();
                $("#promotion").hide();
                }
            });

        })

        $(document).ready(function() {
            $(document).on('change', '.id_promotion_sms', function(e) {
                count++;
                var id = $(this).data('id');
                e.preventDefault();
                if ($("#id_promotion_sms_"+id).is(":checked")) {
                $("#description_sms").append('<div data-mode="' + id + '"">'+$("#promotion_sms_"+id).html()+'</div>');
                }else{
                    $("[data-mode='" + id + "']").remove();
                        }
            });
            $(document).on('change', '.choisirpromosms', function(e) {
                e.preventDefault();
                if ($(this).is(":checked")) {
                $("#sms").hide();
                $("#promotion_sms").show();
                }else{
                    $("#sms").show();
                $("#promotion_sms").hide();
                }
            });

        })
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTableHover').DataTable({
                "language": {
                    "sEmptyTable": "Aucune donnée disponible dans le tableau",
                    "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
                    "sInfoFiltered": "(filtré à partir de _MAX_ éléments au total)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "Afficher _MENU_ éléments",
                    "sLoadingRecords": "Chargement...",
                    "sProcessing": "Traitement...",
                    "sSearch": "Rechercher :",
                    "sZeroRecords": "Aucun élément correspondant trouvé",
                    "oPaginate": {
                        "sFirst": "Premier",
                        "sLast": "Dernier",
                        "sNext": "Suivant",
                        "sPrevious": "Précédent"
                    },
                    "oAria": {
                        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                    },
                    "select": {
                        "rows": {
                            "_": "%d lignes sélectionnées",
                            "0": "Aucune ligne sélectionnée",
                            "1": "1 ligne sélectionnée"
                        }
                    }
                }
            }); // ID From dataTable with Hover
        });
    </script>
<script>
        $('.description').summernote({
            editing: true,
            lang: 'fr-FR',
            height: 100,
            toolbar: [
                ['', ['', '', '', '', '', '']],
                ['', ['', '', '', '', '',
                '', '', '', '', '']],
                ['', ['', '', '', '', '']],
                ['', ['', '', '', '', '']]
                ['', ['']],
            ],
            summernoteGallery: {
                source: {
                    // data: data,
                    url: location.origin+location.pathname+'/server/example.json',
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
        $('.description_sms').summernote({
            editing: true,
            lang: 'fr-FR',
            height: 100,
            toolbar: [
                ['', ['', '', '', '', '', '']],
                ['', ['', '', '', '', '',
                '', '', '', '', '']],
                ['', ['', '', '', '', '']],
                ['', ['', '', '', '', '']]
                ['', ['']],
            ],
            summernoteGallery: {
                source: {
                    // data: data,
                    url: location.origin+location.pathname+'/server/example.json',
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
    if (annyang) {
      annyang.setLanguage('fr-FR');
      // Let's define our first command. First the text we expect, and then the function it should call
      var commands = {
        'email': function() {
          $('#exampleModal').modal('show');
        },
        //'sms': function() {
           // $('#exampleModal1').modal('show');
        //},
        'envoie email': function() {
            $('.btn_email').click();
        },
        //'envoie sms': function() {
            //$('.btn_sms').click();
       // },
        'actualiser': function() {
          $('#vocal').modal('show');
            setTimeout(function() {
              console.log('completed');
              $('#vocal').modal('hide');
              window.location.href = "message?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";

            }, 1000);
        },
        'supprimer': function() {
          $('#deleteForm').submit();
        },
        'fermer': function() {
            $('#exampleModal').modal('hide');
            $('#exampleModal1').modal('hide');
        },
        
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