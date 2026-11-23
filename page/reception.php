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
      <h1 class="h3 mb-0 text-gray-800">Reception</h1>
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
          <div class="card-header py-3 ">
            <div class="form-row">
              <div class="col-md-1 mb-2">
                <input type="hidden" name="" id="id_boutique" value="<?php echo $id; ?>">
                <input type="hidden" class="id_champ" id="id_champ">
                <input type="hidden" id="numv">
              </div>
              <div class="col-xl-3">
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

                $query = "SELECT reception.id_reception, reception.num,DATE_FORMAT(reception.date,'%d/%m/%Y %H:%i') AS date,reception.date as daterecept,nomfour,telephonefour,emailfour FROM `reception` 
               INNER JOIN commande ON commande.id_commande=reception.id_commande
               INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
               INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
               WHERE  boutique.id_boutique='$id' GROUP BY reception.id_reception ORDER BY reception.id_reception DESC";
                $statement = $db->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $total_row = $statement->rowCount();
                if ($total_row > 0) {
                  foreach ($result as $row) {
                    if ($row["daterecept"] == 0000 - 00 - 00) {
                    } else {
                ?>

                      <div class="col-xl-2 col-md-6 mb-4 result well ">
                        <div class="card h-100">
                          <div class="card-body ">
                            <center>
                              <div class="nom identifiant" style="font-weight: bold;text-transform: uppercase;font-size: 14px; margin-bottom: 5px;" id="identifiant_<?php if ($row['num'] < 10) {
                                                                                                                                                                      echo "0" . $row['num'];
                                                                                                                                                                    } else {
                                                                                                                                                                      echo $row['num'];
                                                                                                                                                                    } ?>">
                                <?php if ($row['num'] < 10) {
                                  echo "0" . $row['num'];
                                } else {
                                  echo $row['num'];
                                } ?>
                              </div>
                              <div class="nom" style="font-size: 14px; margin-bottom: 10px;" data-content="<?php echo $row["id_reception"]; ?>">
                                <?php echo $row["date"]; ?>
                              </div>
                              <div class="nom" style="font-size: 14px; margin-bottom: 10px;" data-content="<?php echo $row["nom_client"]; ?>">
                                <?php echo $row["nomfour"]; ?>
                              </div>
                              <div id="id_t" class="nom id_t" style="font-size: 14px; margin-bottom: 10px;" data-content="<?php echo $row["telephone"]; ?>">
                                <?php echo $row["telephonefour"]; ?>
                              </div>
                              <div class="fab-container">

                                <div class="fab fab-icon-holder fab-button" id="fab-button_<?php echo $row['id_reception']; ?>" data-id="<?php echo $row['id_reception']; ?>">
                                  <i class="fas fa-question"></i>
                                </div>
                                <div class="fab fab-icon-holder fab-hide" id="fab-hide_<?php echo $row['id_reception']; ?>" data-id="<?php echo $row['id_reception']; ?>" style="display: none;">
                                  <i class="fas fa-times"></i>
                                </div>
                                <ul class="fab-options fab-show" id="fab-show_<?php echo $row['id_reception']; ?>" style="display: none;">
                                  <li class="div_partage" style="margin-bottom: -10px; text-align: center;padding-right: 20px;display: none;" id="div_partage_<?php echo $row['id_reception']; ?>">
                                    <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                    
                                      <a href="../impression/reception/reception?imprime=<?php echo encryptor('encrypt',$row['id_reception']); ?>&id=<?php echo $id_m; ?>" class="btn btn-secondary rounded-circle btn-sm" data-id="<?php echo $row['id_reception']; ?>" target="_blank"><i class="fa fa-print" style="font-size:15px;" aria-hidden="true"></i>
                                      </a>
                                    </div>
                                    
                                    <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                      <button class="btn btn-dark rounded-circle btn-sm btninfo_<?php echo $row['id_reception']; ?>" style="width: 30px;display: inline-block;margin-right: 2px;" id="btninfo" data-id="<?php echo $row['id_reception']; ?>"><i class="fa fa-info" style="font-size:18px;"></i>
                                      </button>
                                    </div>
                                    <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                      <input type="hidden" id="imprime_<?php echo $row['id_reception']; ?>" value="<?php echo encryptor('encrypt',$row['id_reception']); ?>">
                                      <button name="btn_envoyer" class="btn btn-danger rounded-circle btn-sm shared-nav" data-id="<?php echo $row['id_reception']; ?>" type="button"><i class="fas fa-share-alt" style="font-size:15px;" aria-hidden="true"></i>
                                      </button>
                                  </div>
                                  </li>
                                  <li>
                                    <span class="fab-label">Partager</span>
                                    <div class="addremarque fab-icon-holder addremarque_<?php echo $row['id_reception']; ?>" style="display: inline-block;" id="addremarque_<?php echo $row['id_reception']; ?>" data-id="<?php echo $row['id_reception']; ?>">
                                      <i class="fas fa-share "></i>
                                    </div>
                                  </li>
                                  <li>
                                    <span class="fab-label">Modification</span>
                                    <div class="fab-icon-holder updatebtn_<?php echo $row['id_reception']; ?>" id="updatebtn" data-id="<?php echo $row['id_reception']; ?>">
                                      <i class="fas fa-edit" id="shared"></i>
                                    </div>
                                  </li>
                                  <li>
                                    <span class="fab-label">Suppression</span>
                                    <div class="fab-icon-holder deletebtn_<?php echo $row['id_reception']; ?>" id="deletebtn" id="deletebtn" data-id="<?php echo $row['id_reception']; ?>">
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
              <div class="col">
                <form action="../impression/facture_vente.php" method="get">
                  <input type="text" id="informa_imprimer" name="imprime">
                  <button type="submit" name="imprimer" class="btn btn-secondary rounded-circle btn-sm"><i class="fa fa-print" style="font-size:38px;" aria-hidden="true"></i>
                  </button>
                </form>
              </div>
              <div class="col">
                <form action="../controller/send_email_fournisseur" method="get" style="float: center;">
                  <input name="code" type="hidden" id="cod" />
                  <input type="text" id="informa_email" name="informa_email">
                  <button name="btn_envoyer" class="btn btn-danger rounded-circle btn-sm" type="submit"><i class="fa fa-at" style="font-size:38px;" aria-hidden="true"></i>
                  </button>
                </form>
              </div>
              <div class="col">
                <input type="text" id="informa_info" name="informa_info">
                <button class="btn btn-dark rounded-circle btn-sm" style="width: 50px;" id="btninfo"><i class="fa fa-info" style="font-size:38px;"></i>
                </button>
              </div>
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

            <label>Voulez vous vraiment modifier cette reception ?</label>
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
  <form id="supprimer" enctype="multipart/form-data">
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Supprimer !</h5>
            <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
          </div>
          <div class="modal-body">
            <label>Voulez-vous vraiment supprimer cette reception ?</label>
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
  <!------FORMULAIRE RECEPTION------->


  <!------FIN FORMULAIRE RECEPTION------->
  <!------FORMULAIRE INFO------->
  <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Info reception <span id="numerov"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="dynamic-content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermeri">Fermer</button>

        </div>
      </div>
    </div>
  </div>
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
    $(document).on('click', '#bb', function(e) {
      $(".searchBox").unbind();

    })
    $(document).on('click', '#deletedata', function(e) {
      var form_data = $("#supprimer").serialize();
      $.ajax({
        url: "../controller/reception/delete",
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
        window.location.href = "reception?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
      });
    })

    $(document).on('click', '.shared-nav', function(e) {
      var id = $(this).data('id');
    var imprime=$("#imprime_"+id).val();
    navigator.share({
        text: 'Cliquez sur le lien pour télécharger la facture !', // Text to be shared
        url: "../impression/email/reception?imprime="+imprime, // URL to be shared
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
    $(".id_n").each(function() {
      $('.id_n').hide();
    });
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
        url: "../controller/reception/fetch_reception",
        type: "post",
        data: {
          num: num
        },
        dataType: 'json',
        success: function(data) {
          $("#edit_id").val(data.id_reception);
          if(data.num<10){
           var num=  "0"+data.num
          }else{
            var num=   data.num
          }
          $("#ed_numero_id").val(num);

          $("#editmodal").modal("show");

        }
      });
    });

    $(document).on('click', '#modifie', function(e) {
      var edit_id = $("#edit_id").val();
      window.location.href = "../controller/modifier_reception?mail=<?php echo  $mail; ?>&edit_id=" + edit_id + '&id=<?php echo  $id_b; ?>';

    })
    $(document).on('click', '#deletebtn', function(e) {

      e.preventDefault();

      var del = $(this).data('id');
      $.ajax({
        url: "../controller/reception/fetch_reception",
        type: "post",
        data: {
          del: del
        },
        dataType: 'json',
        success: function(data) {

          $("#delete_id").val(data.id_reception);
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
    $(document).on('click', '#receptbtn', function(e) {

      e.preventDefault();

      var del = $(this).data('id');
      $.ajax({
        url: "../controller/reception/fetch_reception",
        type: "post",
        data: {
          del: del
        },
        dataType: 'json',
        success: function(data) {

          $("#recept_id").val("00" + data.id_reception);
          $("#numero_id_recept").val("00" + data.num);
          $("#receptionmodal").modal("show");

        }
      });
    });
    $(document).on('click', '#btninfo', function(e) {
      e.preventDefault();

      var facture = $(this).data('id');
      $('#view-modal').modal("show");
      $.ajax({
        url: "../fetch/info/info_reception",
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

    $(document).on('click', '#infobtn', function(e) {
      e.preventDefault();

      var facture = $(this).data('id');
      $.ajax({
        url: "../controller/reception/fetch_reception",
        type: "post",
        data: {
          facture: facture
        },
        dataType: 'json',
        success: function(data) {
          console.log(data);
          $("#informa_imprimer").val(data.id_reception);
          $("#informa_info").val(data.id_reception);
          $("#co").val(data.id_reception);
          $("#informa_whatssap").val(data.telephone);
          $("#informa_email").val(data.emailfour);
          $('#numerov').html("00" + data.num)
          $('#exampleModal').modal("show");

        }
      });
    });
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
        'partager': function() {
          var id = $('#numv').val()
          $('#addremarque_' + id).click();
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
          $("#fermerm").click();
          $("#fermers").click();
          $("#fermeri").click();
          var id = $('#numv').val()
          $('#fab-hide_' + id).click();
          $('#addremarque_' + id).click();

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

              window.open("../impression/reception/reception?imprime=" + id + '&id=<?php echo  $id_m; ?>', '_blank');

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
        'WhatsApp': function() {
          var id = $('#numv').val()
          var url = $('.whatsapp_' + id).attr("href");
          window.open(url, '_blank');

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
            window.location.href = "reception?id=<?php echo  $id_m; ?>";

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
            url: "../controller/reception/fetch_reception",
            type: "post",
            data: {
              id_boutique: id_boutique,
              search: search
            },
            dataType: 'json',
            success: function(data) {
              console.log(data);
              $("#numv").val(data.id_reception)
              $("#edit_id").val(data.id_reception)
              $("#delete_id").val(data.id_reception);

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
?>