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
  $query = "SELECT * FROM categorie_client WHERE id_boutique='$id'  ORDER BY id_categorie_client DESC";
  $categorie = "<option value=''>Categorie</option>";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $total_row = $statement->rowCount();
  if ($total_row > 0) {
    foreach ($result as $row) {
      $categorie .= "<option value='{$row["id_categorie_client"]}'>{$row["nom_categorie_client"]}</option>";
    }
  }
  ?>

  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Client</h1>
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
              <!----div button------->

              <div class="col-xl-10 mb-4">
                  <button type="button" class="btn btn-primary" id="importer">Importer</button>
                  <button type="button" class="btn btn-primary" id="exporter">Exporter</button>
                <input type="hidden" name="" id="id_boutique" value="<?php echo $id; ?>">
              </div>
              <div class="col-xl-2 mb-4">
                <input type="text" id="search" data-filter class="form-control form-control-sm searchBox" placeholder="Rechercher...">
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class=" p-0 " style="margin-top: -20px;margin-left: 10px;margin-right: 10px;">
              <div class="row mb-3 parent bg-gradient-login" id="contentpage" style="padding-top: 20px;">
                <!-- debut -->
                <?php

                $query = "SELECT * FROM client
               INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
               WHERE  boutique.id_boutique='$id'";
                $statement = $db->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $total_row = $statement->rowCount();
                if ($total_row > 0) {
                  foreach ($result as $row) {
                    $id_client = $row['id_client'];
                    if ($row['nom_client'] == null) {
                    } else {

                      $query = "SELECT COUNT(DISTINCT num) AS nb,SUM(mt_ttc)AS total FROM tva
                INNER JOIN client ON client.id_client=tva.id_client
               INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
               WHERE  client.id_client='$id_client' AND boutique.id_boutique='$id' ORDER BY COUNT(DISTINCT num) DESC";
                      $statement = $db->prepare($query);
                      $statement->execute();
                      $resultca = $statement->fetch();
                ?>

                      <div class="col-xl-2 col-md-6 mb-4 result well ">
                        <div class="card h-100">
                          <div class="card-body ">
                            <center>

                              <div class="nom" style="margin-bottom:0px ;font-size: 14px" data-content="<?php echo $row["id_tva"]; ?>">
                                <?php echo $row["nom_client"]; ?>
                              </div>
                              <div class="nom" style="font-size: 14px; " data-content="<?php echo $row["date"]; ?>">
                                <?php echo $row["telephonec"]; ?>
                              </div>
                              <hr style="border: dotted 1px; margin-top: 0px;margin-bottom: 0px;" />
                              <div style="font-size: 14px;font-weight: bold;">A+C.A</div>
                              <div class="nom" style="font-size: 14px;" data-content="<?php echo $row["date"]; ?>">
                                <span style="color:green;font-weight: bold;"><?php echo $resultca["nb"]; ?></span>
                              </div>
                              <div class="nom" style="font-size: 14px;" data-content="<?php echo $row["date"]; ?>">
                                <span style="color:red;font-weight: bold;"><?php echo number_format($resultca["total"], 0, ",", " "); ?></span>
                              </div>
                              <hr style="border: dotted 1px; margin-top: 0px;margin-bottom: 0px;" />
                              <div class="nom" style="font-size: 14px; margin-bottom: 10px;font-weight: bold;" id="cate_gorie_<?php echo $row["id_client"]; ?>">
                                Non categorisé
                              </div>
                              <div class="nom" style="font-size: 14px; margin-bottom: 10px;font-weight: bold;" id="carte_<?php echo $row["id_client"]; ?>">
                                <i class="fas fa-credit-card" style="color: #d9534f;font-size: large;"></i>
                                <div style="display: none;">rouge</div>

                              </div>
                              <div class="fab fab-icon-holder fab-button" id="fab-button_<?php echo $row['id_client']; ?>" data-id="<?php echo $row['id_client']; ?>">
                                <i class="fas fa-question"></i>
                              </div>
                              <div class="fab fab-icon-holder fab-hide" id="fab-hide_<?php echo $row['id_client']; ?>" data-id="<?php echo $row['id_client']; ?>" style="display: none;">
                                <i class="fas fa-times"></i>
                              </div>
                              <div class="fab-container" style="z-index: 1;">
                                <ul class="fab-options fab-show" id="fab-show_<?php echo $row['id_client']; ?>" style="display: none;">
                                  <li class="div_partage" style="margin-bottom: -10px; text-align: center;padding-right: 20px;display: none;" id="div_partage_<?php echo $row['id_client']; ?>">

                                    <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                      <?php $id_c = encryptor('encrypt', $row['id_client']);  ?>
                                      <a href="../carte/carte?mail=<?php echo $mail; ?>&id_client=<?php echo $id_c; ?>&id=<?php echo $id_b; ?>" style="width: 30px;" class="btn btn-dark rounded-circle btn-sm" target="_blank"><i class="fa fa-info" style="font-size:15px;"></i></a>
                                    </div>

                                    <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                      <button class="btn btn-outline-danger rounded-circle btn-sm activeCarte" id="activeCarte_<?php echo $row['id_client']; ?>" data-id="<?php echo $row['id_client']; ?>"><i class="fas fa-credit-card" style="font-size:13px;"></i>
                                      </button>
                                      <button class="btn btn-outline-primary rounded-circle btn-sm updateCarte" style="display:none" id="updateCarte_<?php echo $row['id_client']; ?>" data-id="<?php echo $row['id_client']; ?>"><i class="fas fa-credit-card" style="font-size:13px;"></i>
                                      </button>
                                    </div>
                                    <div style="display: inline-block;width: 30px;height: 30px;margin-right: 5px;">
                                      <input type="hidden" id="imprime_<?php echo $row['id_client']; ?>" value="<?php echo encryptor('encrypt', $row['id_client']); ?>">
                                      <button name="btn_envoyer" class="btn btn-danger rounded-circle btn-sm shared-nav" data-id="<?php echo $row['id_client']; ?>" type="button"><i class="fas fa-share-alt" style="font-size:15px;" aria-hidden="true"></i>
                                      </button>
                                    </div>
                                  </li>
                                  <li style="">
                                    <span class="fab-label">Carte</span>
                                    <div class="addremarque fab-icon-holder" style="display: inline-block;" id="addremarque_<?php echo $row['id_client']; ?>" data-id="<?php echo $row['id_client']; ?>">
                                      <i class="fas fa-share "></i>
                                    </div>
                                  </li>
                                  <li>
                                    <span class="fab-label">Categorie</span>
                                    <div class="fab-icon-holder" id="catebtn" id="catebtn" data-id="<?php echo $row['id_client']; ?>">
                                      <i class="fas fa-list-alt"></i>
                                    </div>
                                  </li>
                                  <li>
                                    <span class="fab-label">Achat</span>
                                    <div class="fab-icon-holder" id="deletebtn" id="deletebtn" data-id="<?php echo $row['id_client']; ?>">
                                      <i class="fas fa-shopping-cart"></i>
                                    </div>
                                  </li>
                                  <li>
                                    <span class="fab-label">Modifier</span>
                                    <div class="fab-icon-holder" id="updatebtn" id="updatebtn" data-id="<?php echo $row['id_client']; ?>">
                                      <i class="fas fa-edit"></i>
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
                <form action="../impression/facture_vente" method="get">
                  <input type="hidden" id="informa_imprimer" name="imprime">
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
                <input type="hidden" id="informa_info" name="informa_info">
                <button class="btn btn-dark rounded-circle btn-sm" id="btninfo" style="width: 50px;"><i class="fa fa-info" style="font-size:38px;"></i>
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
  <form id="update_form" enctype="multipart/form-data">
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Modifié !</h5>
            <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
          </div>
          <div class="modal-body">
            <input name="edit_id" type="hidden" id="edit_id" class="form-control form-control-sm" readonly>
            <input name="id_boutique" type="hidden" value="<?php echo $id; ?>" class="form-control form-control-sm" readonly>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Nom client</label>
                  <input name="nom_client" type="text" id="nom_client" class="form-control form-control-sm" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Telephone</label>
                  <input name="telephonec" type="text" id="telephonec" class="form-control form-control-sm" />
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Adresse</label>
                  <input name="adresse" type="text" id="adresse" class="form-control form-control-sm" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Email</label>
                  <input name="emailc" type="text" id="emailc" class="form-control form-control-sm" />
                </div>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Description</label>
                <textarea name="desc_categ_client" id="desc_categ_client" class="form-control form-control-sm"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" name="updatetdataS" id="updatetdata" class="btn btn-primary">Modifier</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!------FIN FORMULAIRE MODIFIER------->
  <!------FORMULAIRE ACHAT------->
  <form id="achat" enctype="multipart/form-data">
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Achat !</h5>
            <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
          </div>
          <div class="modal-body" id="achat_client">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!------FIN FORMULAIRE ACHAT------->
  <!------FORMULAIRE RECEPTION------->


  <!------FIN FORMULAIRE RECEPTION------->
  <!------FORMULAIRE PROFIL------->
  <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Carte de fidelite</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="dynamic-content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="action">Telecharger</button>
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>

        </div>
      </div>
    </div>
  </div>
  <!------FORMULAIRE PROFIL------->
  <!------FORMULAIRE CATEGORIE------->
  <form id="form_categorie_client">
    <div id="view-categorie" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Categorie</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="id_client" id="id_client">
              <label>Categorie</label>
              <select name="id_categorie_client" id="categorie_id" class="form-control form-control-sm" style="width: 100%;">
                <?php echo $categorie ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="insertCategorie">Ajouter</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!------FORMULAIRE CATEGORIE------->
  <!------FORMULAIRE VALIDITE CARTE------->
  <form id="form_valide_carte">
    <div id="modal_active" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Active carte</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="id_client_carte" id="id_client_carte">
              <label>Date d'expiration</label>
              <input name="datefin" type="date" class="form-control form-control-sm" placeholder="Nom categorie" value="<?php $date = date("d/m/Y");
                                                                                                                        echo date('Y-m-d'); ?>" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
            </div>
            <div class="form-group">
              <label>Point</label>
              <input name="point" type="text" class="form-control form-control-sm" placeholder="Point" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
            </div>
            <div class="form-group">
              <label>Deduction</label>
              <input name="deduire" type="text" class="form-control form-control-sm" placeholder="Deduction" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="insertCarte">Activer</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!------FORMULAIRE VALIDITE CARTE------->
  <!------FORMULAIRE VALIDITE CARTE UPDATE------->
  <form id="form_valide_carte_update">
    <div id="modal_active_update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Reactive carte</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="id_valide_carte" id="id_valide_carte">
              <input type="hidden" name="id_client_cartes" id="id_client_cartes">
              <label>Date d'expiration</label>
              <input name="datefin" id="datefin" type="date" class="form-control form-control-sm" placeholder="Nom categorie" value="<?php $date = date("d/m/Y");
                                                                                                                                      echo date('Y-m-d'); ?>" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
            </div>
            <div class="form-group">
              <label>Point</label>
              <input name="point" id="point" type="text" class="form-control form-control-sm" placeholder="Point" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
            </div>
            <div class="form-group">
              <label>Deduction</label>
              <input name="deduire" id="deduire" type="text" class="form-control form-control-sm" placeholder="Deduction" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="updateCarte">Reactiver</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!------FORMULAIRE VALIDITE CARTE UPDATE------->
  <!----affiche tableau categorie------->
  <div style="display: none;">
    <table>
      <tr>
        <th>1</th>
        <th>2</th>
      </tr>
      <?php

      $query = "SELECT * FROM add_client_categorie 
      INNER JOIN  client ON client.id_client=add_client_categorie.id_client
      INNER JOIN categorie_client ON categorie_client.id_categorie_client=add_client_categorie.id_categorie_client
INNER JOIN boutique ON boutique.id_boutique=client.id_boutique      
                WHERE boutique.id_boutique='$id' ";
      $statement = $db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      $total_row = $statement->rowCount();
      if ($total_row > 0) {
        foreach ($result as $row) {
          if ($row["nom_client"] == null) {
          } else {
      ?>
            <tr>
              <td><input type="text" name="" class="tab_id_categorie_client" id="tab_id_categorie_client_<?php echo $row['id_client']; ?>" value="<?php echo $row['id_client']; ?>" data-id="<?php echo $row['id_client']; ?>"></td>
              <td><input type="text" name="" id="tab_categorie_client_<?php echo $row['id_client']; ?>" value="<?php echo $row['nom_categorie_client']; ?>"></td>
            </tr>
      <?php
          }
        }
      }
      ?>
    </table>
  </div>
  <!----affiche fin tableau categorie------->
  <!----affiche tableau carte------->
  <div style="display: none;">
    <table>
      <tr>
        <th>1</th>
        <th>2</th>
      </tr>
      <?php

      $query = "SELECT * FROM valide_carte 
                INNER JOIN client ON client.id_client=valide_carte.id_client
                INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                WHERE boutique.id_boutique='$id' ";
      $statement = $db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      $total_row = $statement->rowCount();
      if ($total_row > 0) {
        foreach ($result as $row) {
      ?>
          <tr>
            <td><input type="text" name="" class="tab_id_carte_client" id="tab_id_carte_client_<?php echo $row['id_client']; ?>" value="<?php echo $row['id_client']; ?>" data-id="<?php echo $row['id_client']; ?>"></td>
            <td>
              <div id="tab_carte_client_<?php echo $row['id_client']; ?>">
                <?php if (strtotime($row["datefin"]) < strtotime(date("Y-m-d"))) { ?>
                  EX <i class="fas fa-credit-card" style="color: #d9534f;font-size: large;"></i>
                  <div style="display: none;">rouge</div>

                <?php } else { ?>
                  <i class="fas fa-credit-card" style="color: #0275d8;font-size: large;"></i>
                  <div style="display: none;"> bleu</div>

                <?php } ?>
              </div>
            </td>
          </tr>
      <?php
        }
      }
      ?>
    </table>
  </div>
  <!------IMPORTER--------------->
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
              <div style="color:red; font-size:12px;display: none;" id="requireimport">Champs requis *</div>
              <input type="file" class="form-control form-control-sm" name="file-import" id="fileupload">
            </div>
            <div class="form-group" style="height: 500px;overflow: auto;">
              <table id="tblItems" class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>Nom client</th>
                    <th>Telephone</th>
                    <th>Adresse</th>
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

    $query = "SELECT * FROM client INNER JOIN boutique ON boutique.id_boutique=client.id_boutique WHERE boutique.id_boutique='$id' ORDER BY id_client DESC";

    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if ($total_row > 0) {
      foreach ($result as $row) {
        if ($row['nom_client'] == null) {
        } else {
    ?>
          <tr>
            <td><?php echo $row["nom_client"]; ?></td>
            <td><?php echo $row["telephonec"]; ?></td>
            <td><?php echo $row["adresse"]; ?></td>
            <td><?php echo $row["emailc"]; ?></td>
            <td><?php echo $row["desc_categ_client"]; ?></td>
          </tr>
    <?php
        }
      }
    }
    ?>
  </table>
  <!----affiche fin tableau carte------->
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
          url: '../controller/client/import',
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
          window.location.href = "client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
        });
      }
    });
    $(document).on('click', '#updatetdata', function(e) {
      $("#updatetdata").prop("disabled", true)
      var form_data = $("#update_form").serialize();
      $.ajax({
        url: "../controller/client/update",
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
        window.location.href = "client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
      });
    })
    $(document).on('click', '#insertCategorie', function(e) {
      var form_data = $("#form_categorie_client").serialize();
      $.ajax({
        url: "../controller/classement_client/insert",
        method: "POST",
        data: form_data,
        success: function(data) {
          console.log(data)
        }
      })
      $("#view-categorie").modal("hide");

      swal({
        title: "Enregistré!",
        text: "Enregistrement effectué avec succés.",
        type: "success",
        confirmButtonText: 'Ok',
        confirmButtonColor: '#3085d6',
        showConfirmButton: false,
        timer: 2000
      }, function() {
        window.location.href = "client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
      });
    })
    $(document).on('click', '#insertCarte', function(e) {
      var form_data = $("#form_valide_carte").serialize();
      $.ajax({
        url: "../controller/valide_carte/insert",
        method: "POST",
        data: form_data,
        success: function(data) {
          console.log(data)
        }
      })
      $("#modal_active").modal("hide");
      swal({
        title: "Enregistré!",
        text: "Enregistrement effectué avec succés.",
        type: "success",
        confirmButtonText: 'Ok',
        confirmButtonColor: '#3085d6',
        showConfirmButton: false,
        timer: 2000
      }, function() {
        window.location.href = "client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
      });
    })
    $(document).on('click', '#updateCarte', function(e) {
      var form_data = $("#form_valide_carte_update").serialize();
      $.ajax({
        url: "../controller/valide_carte/update",
        method: "POST",
        data: form_data,
        success: function(data) {
          console.log(data)
        }
      })
      $("#modal_active_update").modal("hide");
      swal({
        title: "Modifié!",
        text: "Modification effectuée avec succés.",
        type: "success",
        confirmButtonText: 'Ok',
        confirmButtonColor: '#3085d6',
        showConfirmButton: false,
        timer: 2000
      }, function() {
        window.location.href = "client?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
      });
    })
    $(document).on('click', '.shared-nav', function(e) {
      var id = $(this).data('id');
      var imprime = $("#imprime_" + id).val();
      navigator.share({
        text: 'Cliquez sur le lien pour télécharger la facture !', // Text to be shared
        url: "../carte/carte?id_client=" + imprime, // URL to be shared
        files: [] // An array of File objects to be shared
      })
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
    $(".id_n").each(function() {
      $('.id_n').hide();
    });
    $(".id_t").each(function() {
      $('.id_t').hide();
    });

    $("#id_t").hide();

    $(document).on('click', '.addremarque', function(e) {
      var id = $(this).data('id');
      $('#div_partage_' + id).toggle('slow');
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
    $(document).on('click', '#importer', function(e) {
      $("#importmodal").modal("show");
    })
    $("#categorie_id").select2();

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

      var id_client = $(this).data('id');
      $.ajax({
        url: "../fetch/client/fetch_client",
        type: "post",
        data: {
          id_client: id_client
        },
        dataType: 'json',
        success: function(data) {
          $("#edit_id").val("00" + data.id_client);
          $("#nom_client").val(data.nom_client);
          $("#telephonec").val(data.telephonec);
          $("#adresse").val(data.adresse);
          $("#emailc").val(data.emailc);
          $("#desc_categ_client").val(data.desc_categ_client);
          $("#editmodal").modal("show");

        }
      });
    });

    $(document).on('click', '#deletebtn', function(e) {

      e.preventDefault();

      var id_client = $(this).data('id');
      $.ajax({
        url: "../fetch/client/fetch_achat_client",
        type: "post",
        data: {
          id_client: id_client
        },
        dataType: 'html',
        success: function(data) {
          console.log(data)
          $("#achat_client").html(data);
          $("#deletemodal").modal("show");

        }
      });
    });


    $(document).on('click', '#btninfo', function(e) {
      e.preventDefault();

      var id_client = $(this).data('id');

      $('#view-modal').modal("show");
      $.ajax({
        url: "../carte/carte",
        type: "GET",
        data: {
          id_client: id_client
        },
        dataType: 'html',
        success: function(data) {
          console.log(data);
          $('#dynamic-content').html(data);
        }
      });
    });
    var node = document.getElementById('dynamic-content');
    var btn = document.getElementById('action');

    btn.onclick = function() {
      domtoimage.toBlob(document.getElementById('dynamic-content')).then(function(blob) {
        window.saveAs(blob, 'Carte.png')
      })
    }
    $(document).on('click', '#catebtn', function(e) {
      e.preventDefault();

      var id_client = $(this).data('id');
      $.ajax({
        url: "../fetch/client/fetch_client",
        type: "post",
        data: {
          id_client: id_client
        },
        dataType: 'json',
        success: function(data) {
          console.log(data);
          $("#id_client").val(data.id_client);
          $('#view-categorie').modal("show");

        }
      });
    });
    $(document).on('click', '.activeCarte', function(e) {
      e.preventDefault();
      var id_client = $(this).data('id');
      $.ajax({
        url: "../fetch/client/fetch_client",
        type: "post",
        data: {
          id_client: id_client
        },
        dataType: 'json',
        success: function(data) {
          console.log(data);
          $("#id_client_carte").val(data.id_client);
          $('#modal_active').modal("show");
        }
      });
    });
    $(document).on('click', '.updateCarte', function(e) {
      e.preventDefault();
      var id_client_valide = $(this).data('id');
      $.ajax({
        url: "../controller/valide_carte/fetch_valide_carte",
        type: "post",
        data: {
          id_client_valide: id_client_valide
        },
        dataType: 'json',
        success: function(data) {
          console.log(data);
          $("#id_valide_carte").val(data.id_valide_carte);
          $("#id_client_cartes").val(data.id_client);
          $("#datefin ").val(data.datefin);
          $("#point").val(data.point);
          $("#deduire").val(data.deduire);
          $('#modal_active_update').modal("show");
        }
      });
    });
    categorie()

    function categorie() {
      $("[id^='tab_id_categorie_client_']").each(function() {
        var id_promotionV = $(this).data('id');
        $("#cate_gorie_" + id_promotionV).html($("#tab_categorie_client_" + id_promotionV).val())

      })
    }
    carte()

    function carte() {
      $("[id^='tab_id_carte_client_']").each(function() {
        var id_promotionV = $(this).data('id');
        $("#carte_" + id_promotionV).html($("#tab_carte_client_" + id_promotionV).html())
        if ($("#carte_" + id_promotionV).html($("#tab_carte_client_" + id_promotionV).html())) {
          $("#activeCarte_" + id_promotionV).hide()
          $("#updateCarte_" + id_promotionV).show()
        } else {
          $("#activeCarte_" + id_promotionV).show()
          $("#updateCarte_" + id_promotionV).hide()
        }
      })
    }
    $(function() {
      $('#btn_print').on('click', function() {
        //Print ele2 with default options
        $("#dynamic-content").print();
      });
    });
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
                                <input name="nom_client[]" id="ajouter_catégorie" type="text" class="form-control form-control-sm" placeholder="Categorie" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[0]}"/>
                              </div>
                           </td>
                            <td>
                              <div class="form-group">
                                 <input name="telephonec[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[1]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input name="adresse[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[2]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input name="emailc[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[3]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input name="desc_categ_client[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[4]}">
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
        filename: "client.xls", // inclure l'extension 
        preserveColors: false // définir sur true si vous souhaitez que les couleurs d'arrière-plan et les couleurs de police soient préservées 
      });
    });
  </script>


<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
  header("Location:../");
}
?>