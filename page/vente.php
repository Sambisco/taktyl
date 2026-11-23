<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../include/database.php');
$mail = $_GET['mail'];
$query = "SELECT *,DATE_FORMAT(date_exp,'%d') AS d,DATE_FORMAT(date_exp,'%m') AS m,DATE_FORMAT(date_exp,'%Y') AS y,DATE_FORMAT(date_exp,'%H') AS h,DATE_FORMAT(date_exp,'%i') AS i,DATE_FORMAT(date_exp,'%s') AS s FROM user LEFT JOIN boutique ON boutique.iduser=user.iduser
LEFT JOIN sub_users ON sub_users.id_boutique=boutique.id_boutique 
WHERE user.login='".$mail."' OR user.telephone_user='".$mail."' OR sub_email='".$mail."' OR telephone_sub_user='".$mail."' LIMIT 1";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();
if($result["date_exp"] < date('Y-m-d H:i:s')){
    include("../page/maintenance.php");
  }else{
if (isset($_SESSION['email'])) {
  include('../include/script.php');
  include('../include/css.php');
  include('../include/sidebar.php');
  include('../include/topbar.php');
?>
  <link rel="stylesheet" href="../assets/css/button.reservation.css">
 
  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Vente</h1>
      <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <?php  if (isset($_SESSION['profil'])) { 
           if ($_SESSION['profil']=="Utilisateur") {
          ?>
        <a href="">Accueil</a></li>
        <?php  }else { ?>
          <a href="dashboard?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>">Accueil</a></li>

        <?php } 
             }else { ?>
          <a href="dashboard?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>">Accueil</a></li>
          <?php  } ?>
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
          <div class="card-header py-3 ">
            <div class="form-row">
              <div class="col-md-1 mb-2">
                <a href="../controller/cree_vente?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>" class="btn btn-primary">Ajouter</a>
              </div>

              <div class="col-xl-3">
                <input type="hidden" id="id_boutique" value="<?php echo $id; ?>">
                <input type="hidden" class="id_champ" id="id_champ">
                <input type="hidden" id="numv">
              </div>


              <div class="col-xl-5">
              </div>
              <div class="col-xl-3">
                <input type="text" id="search" data-filter class="form-control form-control-sm searchBox" placeholder="Rechercher...">
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class=" p-0 " style="margin-top: -20px;margin-left: 10px;margin-right: 10px;">
              <div class="row mb-3 parent bg-gradient-login" id="contentpage" style="padding-top: 20px;">
                <!-- debut -->
                <?php
                
                if (isset($_SESSION['profil'])) {
                  $idu = $_SESSION['id_sub_users'];
                if( $_SESSION["profil"]=="Utilisateur"){
                  $query = "SELECT tva.id_tva, num,DATE_FORMAT(date,'%d/%m/%Y %H:%i') AS date,nom_client,client.telephonec,adresse,emailc,nomb,account.montant AS montant,detail_vente.avoir AS avoir,boutique.id_boutique AS id_boutique,sub_users.id_sub_users FROM `tva` 
                  INNER JOIN account ON tva.id_tva=account.id_tva 
                INNER JOIN detail_vente ON tva.id_tva=detail_vente.id_tva 
                  INNER JOIN client ON client.id_client=tva.id_client 
                  INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                  INNER JOIN vente_user ON vente_user.id_tva=tva.id_tva
                  INNER JOIN sub_users ON sub_users.id_sub_users=vente_user.id_sub_users                 
               WHERE  sub_users.id_sub_users='$idu'  ORDER BY tva.id_tva DESC";
                }else  if($_SESSION["profil"]=="Administrateur"){
                $query = "SELECT tva.id_tva, num,DATE_FORMAT(date,'%d/%m/%Y %H:%i') AS date,nom_client,client.telephonec,adresse,emailc,nomb,account.montant AS montant,detail_vente.avoir AS avoir,boutique.id_boutique AS id_boutique FROM `tva` 
                INNER JOIN account ON tva.id_tva=account.id_tva 
                 INNER JOIN detail_vente ON tva.id_tva=detail_vente.id_tva 
                INNER JOIN client ON client.id_client=tva.id_client 
                INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                WHERE  boutique.id_boutique='$id' ORDER BY tva.id_tva DESC";
                }
                } else{
                  $query = "SELECT tva.id_tva, num,DATE_FORMAT(date,'%d/%m/%Y %H:%i') AS date,nom_client,client.telephonec,adresse,emailc,nomb,account.montant AS montant,detail_vente.avoir AS avoir,boutique.id_boutique AS id_boutique FROM `tva` 
  INNER JOIN account ON tva.id_tva=account.id_tva 
               INNER JOIN detail_vente ON tva.id_tva=detail_vente.id_tva 
  INNER JOIN client ON client.id_client=tva.id_client 
  INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
  WHERE  boutique.id_boutique='$id'  ORDER BY tva.id_tva DESC";
                }
                $statement = $db->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $total_row = $statement->rowCount();
                if ($total_row > 0) {
                  foreach ($result as $row) {
                ?>

                    <div class="col-xl-2 col-md-6 mb-4 result well vocal_<?php echo $row["num"]; ?>">
                      <div class="card h-100">
                        <div class="card-body ">
                          <center>
                            <div class="nom identifiant" style="margin-bottom:0px ;font-size: 13px;font-weight: bold;" id="identifiant_<?php if ($row['num'] < 10) {
                                                                                                                                          echo "0" . $row['num'];
                                                                                                                                        } else {
                                                                                                                                          echo $row['num'];
                                                                                                                                        }  ?>">
                              <?php if ($row['num'] < 10) {
                                echo "0" . $row['num'];
                              } else {
                                echo $row['num'];
                              }  ?>
                            </div>
                            <div class="" style="font-size: 14px; margin-bottom: 0px;" data-content="<?php echo $row["date"]; ?>">
                              <?php echo $row["date"]; ?>
                            </div>

                            <div class=" id_n" style="font-size: 14px; margin-bottom: 0px;" data-content="<?php echo $row["nom_client"]; ?>">
                              <?php if ($row["nom_client"] == null) {
                                echo "Neant";
                              } else {
                                echo $row["nom_client"];
                              } ?>
                            </div>
                            <div class=" id_n" style="font-size: 14px; margin-bottom: 0px;" data-content="<?php echo $row["nom_client"]; ?>">
                              <?php if ($row["montant"] == 0) { ?>
                                <span>Acompte non</span>&nbsp;&nbsp;<i class="fas fa-ban fa-1x" style="color: red;"></i>
                              <?php } else { ?>
                                <span>Acompte oui</span>&nbsp;&nbsp;<i class="fas fa-check fa-1x" style="color: green;"></i>
                              <?php } ?>
                            </div>
                            <div class="nom id_n" style="font-size: 14px; margin-bottom: 10px;" data-content="<?php echo $row["nom_client"]; ?>">
                              <?php if ($row["avoir"] == 0) { ?>
                                <span>Avoir non</span>&nbsp;&nbsp;<i class="fas fa-ban fa-1x" style="color: red;"></i>
                              <?php } else { ?>
                                <span> Avoir oui</span>&nbsp;&nbsp;<i class="fas fa-check fa-1x" style="color: green;"></i>
                              <?php } ?>
                            </div>
                            <div id="id_t" class="nom id_t" style="font-size: 14px; margin-bottom: 10px;" data-content="<?php echo $row["telephone"]; ?>">
                              <?php echo $row["telephonec"]; ?>
                            </div>
                            <div class="fab-container">

                              <div class="fab fab-icon-holder fab-button" id="fab-button_<?php echo $row['id_tva']; ?>" data-id="<?php echo $row['id_tva']; ?>">
                                <i class="fas fa-question"></i>
                              </div>
                              <div class="fab fab-icon-holder fab-hide" id="fab-hide_<?php echo $row['id_tva']; ?>" data-id="<?php echo $row['id_tva']; ?>" style="display: none;">
                                <i class="fas fa-times"></i>
                              </div>
                              <ul class="fab-options fab-show" id="fab-show_<?php echo $row['id_tva']; ?>" style="display: none;">
                                <li class="div_partage" style="margin-bottom: -10px; text-align: center;padding-right: 20px;display: none;" id="div_partage_<?php echo $row['id_tva']; ?>">
                                  <!----------partager------->
                                  <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                    <a href="../impression/facture/facture?imprime=<?php $id_tva=encryptor('encrypt',$row['id_tva']); echo $id_tva; ?>&id=<?php echo $id_b; ?>" class="btn btn-secondary rounded-circle btn-sm" data-id="<?php echo $row['id_tva']; ?>" target="_blank"><i class="fa fa-print" style="font-size:15px;" aria-hidden="true"></i>
                                    </a>
                                  </div>
                                  <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                    <a href="../impression/ticket/ticket?imprime=<?php $id_tva=encryptor('encrypt',$row['id_tva']); echo $id_tva; ?>&id=<?php echo $id_b; ?>" class="btn btn-info rounded-circle btn-sm" data-id="<?php echo $row['id_tva']; ?>" target="_blank"><i class="fas fa-receipt" style="font-size:15px;" aria-hidden="true"></i>
                                    </a>
                                  </div>
                                  
                                  <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                  <button class="btn btn-dark rounded-circle btn-sm btninfo_<?php echo $row['id_tva']; ?>" style="width: 30px;display: inline-block;margin-right: 2px;" id="btninfo" data-id="<?php echo $row['id_tva']; ?>"><i class="fa fa-info" style="font-size:15px;"></i>
                                    </button>
                                  </div>
                                  <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                      <input type="hidden" id="imprime_<?php echo $row['id_tva']; ?>" value="<?php echo encryptor('encrypt',$row['id_tva']); ?>">
                                      <button name="btn_envoyer" class="btn btn-danger rounded-circle btn-sm shared-nav" data-id="<?php echo $row['id_tva']; ?>" type="button"><i class="fas fa-share-alt" style="font-size:15px;" aria-hidden="true"></i>
                                      </button>
                                  </div>
                                  <!----------partager------->

                                </li>
                                <li>
                                  <span class="fab-label">Partager</span>
                                  <div class="addremarque fab-icon-holder addremarque_<?php echo $row['id_tva']; ?>" style="display: inline-block;" id="addremarque_<?php echo $row['id_tva']; ?>" data-id="<?php echo $row['id_tva']; ?>">
                                    <i class="fas fa-share "></i>
                                  </div>
                                  
                                </li>
                                <li>
                                  <span class="fab-label">Modification</span>
                                  <div class="fab-icon-holder updatebtn_<?php echo $row['id_tva']; ?>" id="updatebtn" data-id="<?php echo $row['id_tva']; ?>">
                                    <i class="fas fa-edit" id="shared"></i>
                                  </div>
                                </li>
                                <?php 
                        if (isset($_SESSION['profil'])) {
                            if( $_SESSION["profil"]=="Utilisateur"){

                            }else{
                            ?>
                                <li>
                                  <span class="fab-label">Suppression</span>
                                  <div class="fab-icon-holder deletebtn_<?php echo $row['id_tva']; ?>" id="deletebtn" id="deletebtn" data-id="<?php echo $row['id_tva']; ?>">
                                    <i class="fas fa-trash"></i>
                                  </div>

                                </li>
                                <?php
                            }
                        }else{
                            ?>
                           <li>
                                  <span class="fab-label">Suppression</span>
                                  <div class="fab-icon-holder deletebtn_<?php echo $row['id_tva']; ?>" id="deletebtn" id="deletebtn" data-id="<?php echo $row['id_tva']; ?>">
                                    <i class="fas fa-trash"></i>
                                  </div>

                                </li>

                            <?php }?>
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
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <center>
            <div class="form-row">


            </div>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE AJOUTER------->
  <!------FORMULAIRE MODIFIER------->
  <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Modifié !</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-row">

            <label>Voulez vous vraiment modifier cette vente ?</label>
            <input name="edit_id" type="hidden" id="edit_id" class="form-control form-control-sm" readonly>
            <input name="numero_id" type="text" id="ed_numero_id" class="form-control form-control-sm" readonly />
            <input name="id" type="hidden" value="<?php echo $id; ?>" class="form-control form-control-sm" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" name="updatetdataS" class="btn btn-primary" id="modifie">Modifier</button>
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermerm">Fermer</button>
        </div>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE MODIFIER------->
  <!------FORMULAIRE SUPPRIMER------->
  <form id="supprimer">
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Supprimer !</h5>
            <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
          </div>
          <div class="modal-body">
            <label>Voulez-vous vraiment supprimer cette vente ?</label>
            <input name="delete_id" type="hidden" id="delete_id" class="form-control form-control-sm" readonly />
            <input name="numero_id" type="text" id="numero_id" class="form-control form-control-sm" readonly />
          </div>
          <div class="modal-footer">
            <button type="button" id="deletedata" class="btn btn-primary">Supprimer</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermers">Fermer</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!------FIN FORMULAIRE SUPPRIMER------->
  <!------FORMULAIRE INFO------->
  <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Info vente <span id="numerov"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div  id="dynamic-content" style="margin-right: 5px;margin-left: 5px; margin-top: 5px;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermeri">Fermer</button>

        </div>
      </div>
    </div>
  </div>

  <input type="hidden" name="" id="information">
  <input type="hidden" name="" id="informa_email_vocal">
  <input type="hidden" name="" id="imprime_vocal">
  <input type="hidden" name="" id="id_boutique_vocal" value="<?php echo $id; ?>">
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
    
    $(document).on('click', '#deletedata', function(e) {
      var form_data = $("#supprimer").serialize();
      $.ajax({
        url: "../controller/vente/delete",
        method: "POST",
        data: form_data,
        success: function(data) {
          console.log(data)

        }
      })
      $("#deletemodal").modal("hide");

      swal({
        title: "Supprimé!",
        text: "Suppression effectuée avec succés.",
        type: "error",
        confirmButtonText: 'Ok',
        confirmButtonColor: '#3085d6',
        showConfirmButton: false,
        timer: 2000
      }, function() {
        window.location.href = "vente?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
      });
    })
    $(document).on('click', '.shared-nav', function(e) {
      var id = $(this).data('id');
    var imprime=$("#imprime_"+id).val();
    navigator.share({
        text: 'Cliquez sur le lien pour télécharger la facture !', // Text to be shared
        url: "../impression/email/facture?imprime="+imprime, // URL to be shared
        files: [] // An array of File objects to be shared
    })
    })

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
    $(".id_t").each(function() {
      $('.id_t').hide();
    });
    
    $("#id_t").hide();
    $(document).on('click', '.addremarque', function(e) {
      var id = $(this).data('id');
        $('#div_partage_'+id).toggle('slow');
    });
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
    $("#id_boutique_r").select2();

    $("#id_categorie").select2({
      dropdownParent: $("#exampleModal")
    });
    $("#edit_id_categorie").select2({
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

    $(document).on('click', '#updatebtn', function(e) {
      e.preventDefault();

      var num = $(this).data('id');
      $.ajax({
        url: "../controller/vente/fetch_vente",
        type: "post",
        data: {
          num: num
        },
        dataType: 'json',
        success: function(data) {
          $("#edit_id").val(data.id_tva);
          if(data.num<10){
           var num=  "0"+data.num
          }else{
            var num=   data.num
          }
          $("#ed_numero_id").val(num);
          $("#client_id").val(data.id_client);
          $("#boutique_id").val(data.id_boutique);
          $("#editmodal").modal("show");
        }

      });
    });
    $(document).on('click', '#modifie', function(e) {
      var edit_id = $("#edit_id").val();
      window.location.href = "../controller/modifier_vente?mail=<?php echo  $mail; ?>&edit_id=" + edit_id + '&id=<?php echo  $id_b; ?>';

    })

    $(document).on('click', '#deletebtn', function(e) {

      e.preventDefault();

      var del = $(this).data('id');
      $.ajax({
        url: "../controller/vente/fetch_vente",
        type: "post",
        data: {
          del: del
        },
        dataType: 'json',
        success: function(data) {

          $("#delete_id").val(data.id_tva);
          if(data.num<10){
           var num=  "0"+data.num
          }else{
            var num=   data.num
          }
          $("#numero_id").val(num);
          $("#deletemodal").modal("show");

        }
      });
    });

    $(document).on('click', '#btninfo', function(e) {
      e.preventDefault();

      var facture = $(this).data('id');

      $('#view-modal').modal("show");
      $.ajax({
        url: "../fetch/info/info_vente",
        type: "post",
        data: {
          facture: facture
        },
        dataType: 'html',
        success: function(data) {
          console.log(data);
          $('#dynamic-content').html(data);
        }
      });
    });


function printPageArea(areaID){
    var printContent = document.getElementById(areaID).innerHTML;
    var originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
}
    $(function() {
      $('#btn_print').on('click', function() {
        //Print ele2 with default options
        $("#dynamic-content").print();
      });
    });
  </script>
  <script>
    var scrolled = 0;
    if (annyang) {
      annyang.setLanguage('fr-FR');
      // Let's define our first command. First the text we expect, and then the function it should call
      var commands = {
        continuous: true,

        'ajouter': function() {
          $('#vocal').modal('show');
          setTimeout(function() {
            console.log('completed');
            $('#vocal').modal('hide');
            window.location.href = "../controller/cree_vente?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";

          }, 3000);
        },

        'imprimer': function() {
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
            $('#vocal').modal('show');
            setTimeout(function() {
              console.log('completed');
              $('#vocal').modal('hide');

              window.open("../impression/facture/facture?imprime=" + id + '&id=<?php echo  $id_b; ?>', '_blank');

            }, 3000);
          }
        },
        'information': function() {
          var id = $('#numv').val()
          $('.btninfo_' + id).click();
        },
        'email': function() {
          var id = $('#numv').val()
          $('#btn_email_' + id).click();
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
        'WhatsApp': function() {
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
            $('#vocal').modal('show');
            setTimeout(function() {
              console.log('completed');
              $('#vocal').modal('hide');

              var url = $('.whatsapp_' + id).attr("href");
          window.open(url, '_blank');
            }, 3000);
          }
        },
        'partager': function() {
          var id = $('#numv').val()
          $('#addremarque_' + id).click();
        },
        'modification': function() {
          var id = $('#numv').val()
          $('.updatebtn_' + id).click();
        },
        'suppression': function() {
          var id = $('#numv').val()
          $('.deletebtn_' + id).click();
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
          } else if ($("#edit_id").val() == "") {
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
            $('#vocal').modal('show');
            $('#editmodal').modal('hide');
            setTimeout(function() {
              console.log('completed');
              $('#vocal').modal('hide');
              $("#modifie").click();
            }, 3000);
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
          } else if ($("#delete_id").val() == "") {
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
            $("#deletedata").click();
          }
        },
        'fermer': function() {
          $('#editmodal').modal('hide');
          $('#deletemodal').modal('hide');
          $("#fermeri").click();
          var id = $('#numv').val()
          $('#fab-hide_' + id).click();
          $('#addremarque_' + id).click();
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
            window.location.href = "vente?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";

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

          var id_boutique = $("#id_boutique").val();
          var search = $("#id_champ").val();
          $.ajax({
            url: "../controller/vente/fetch_vente",
            type: "post",
            data: {
              id_boutique: id_boutique,
              search: search
            },
            dataType: 'json',
            success: function(data) {
              console.log(data);
              $("#numv").val(data.id_tva)
              $("#edit_id").val(data.id_tva)
              $("#delete_id").val(data.id_tva);

            }
          });

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
  }
?>