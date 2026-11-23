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
  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Article</h1>
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
              <div class="col-xl-2 mb-4">
                <input type="text" id="search" data-filter class="form-control form-control-sm searchBox" placeholder="Rechercher...">
                <input type="hidden" id="id_boutiques" value="<?php echo $id; ?>">
                <input type="hidden" class="id_champ" id="id_champ">
                <input type="hidden" id="numv">

              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive p-3 bg-gradient-login " style="margin-top: -20px;margin-left: 0px;margin-right: 0px;">
              <div class="row mb-3 parent" id="contentpage">

                <!-- debut -->
                <?php

                $query = "SELECT * FROM article 
                INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
                INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                WHERE boutique.id_boutique='$id' ORDER BY id_article DESC";
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
                                <img src="../img/img/image.jpg" alt="icons8-team-100" class="img-thumbnail img-thumbnail-mobile img-responsive">
                              <?php } else { ?>
                                <img src="<?php echo $row['imgInp']; ?>" alt="icons8-team-100" class="img-thumbnail img-thumbnail-mobile img-responsive">
                              <?php } ?>
                            </div>
                            <div class="nom identifiant" style="font-weight: bold;text-transform: uppercase;font-size: 14px; margin-bottom: 5px;" id="identifiant_<?php if ($row['id_id_article'] < 10) {
                                                                                                                                                                    echo "0" . $row['id_id_article'];
                                                                                                                                                                  } else {
                                                                                                                                                                    echo $row['id_id_article'];
                                                                                                                                                                  } ?>">
                              <?php if ($row['id_id_article'] < 10) {
                                echo "0" . $row['id_id_article'];
                              } else {
                                echo $row['id_id_article'];
                              }  ?>
                            </div>
                            <div class="nom" style="font-weight: bold;text-transform: uppercase;font-size: 12px;">
                              <?php echo $row["categorie_stock"]; ?>
                            </div>

                            <div class="nom">
                              <?php echo $row["description_article"]; ?>
                            </div>

                            <div class="sku" style="margin-bottom:5px ;">
                              <?php if ($row["qte"] < $row["stock_ini"]) { ?>
                                <i class="fas fa-ban fa-1x" style="color: red;"></i>
                              <?php } else { ?>
                                <i class="fas fa-check fa-1x" style="color: green;"></i>
                              <?php } ?>
                            </div>

                            <div class="fab-container">

                              <div class="fab fab-icon-holder fab-button" id="fab-button_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">
                                <i class="fas fa-question"></i>
                              </div>
                              <div class="fab fab-icon-holder fab-hide" id="fab-hide_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>" style="display: none;">
                                <i class="fas fa-times"></i>
                              </div>
                              <ul class="fab-options fab-show" id="fab-show_<?php echo $row['id_article']; ?>" style="display: none;">
                                <li>
                                  <span class="fab-label">Information</span>
                                  <div class="fab-icon-holder infobtn_<?php echo $row['id_article']; ?>" id="infobtn" data-id="<?php echo $row['id_article']; ?>">
                                    <i class="fas fa-info" id="shared"></i>
                                  </div>
                                </li>
                                <li>
                                  <span class="fab-label">Modification</span>
                                  <div class="fab-icon-holder updatebtn_<?php echo $row['id_article']; ?>" id="updatebtn" data-id="<?php echo $row['id_article']; ?>">
                                    <i class="fas fa-edit" id="shared"></i>
                                  </div>
                                </li>
                                <li>
                                  <span class="fab-label">Suppression</span>
                                  <div class="fab-icon-holder deletebtn_<?php echo $row['id_article']; ?>" id="deletebtn" data-id="<?php echo $row['id_article']; ?>">
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
  <?php
  $query = "SELECT MAX(id_id_article)+1 AS num  FROM article 
  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
  WHERE boutique.id_boutique='$id' ORDER BY id_article DESC";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetch();
  ?>
  <!------FORMULAIRE AJOUTER------->
  <form id="insertForm">
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
                  <div style="color:red; font-size:12px;display: none;" id="id_categorieadd">Champs requis *</div>
                  <select name="id_categorie" id="id_categorie" class="form-control form-control-sm" style="width: 100%;">
                    <?php
                    echo $categorie;
                    ?>
                  </select>
                  <input type="hidden" name="id_boutique_article" value="<?php echo $id; ?>">
                  <input type="hidden" name="id_id_article" id="" value="<?php if ($result["num"] == null) {
                                                                            echo "1";
                                                                          } else {
                                                                            echo $result["num"];
                                                                          } ?>">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Description</label>
                  <div style="color:red; font-size:12px;display: none;" id="ajout_descriptionadd">Champs requis *</div>
                  <input name="description_article" id="ajout_description" type="text" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Prix de vente</label>
                  <div style="color:red; font-size:12px;display: none;" id="ajout_prix_venteadd">Champs requis *</div>
                  <input name="prix" id="ajout_prix_vente" type="text" class="form-control form-control-sm" placeholder="Prix de vente" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Prix d'achat</label>
                  <div style="color:red; font-size:12px;display: none;" id="ajout_prix_achatadd">Champs requis *</div>
                  <input name="prix_a" type="text" id="ajout_prix_achat" class="form-control form-control-sm" placeholder="Prix d'achat" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Stock (quantité)</label>
                  <div style="color:red; font-size:12px;display: none;" id="ajout_qteadd">Champs requis *</div>
                  <input name="qte" id="ajout_qte" type="text" class="form-control form-control-sm" placeholder="Stock (quantité)" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Stock (quantité) initial</label>
                  <div style="color:red; font-size:12px;display: none;" id="ajout_stock_iniadd">Champs requis *</div>
                  <input name="stock_ini" id="ajout_stock_ini" type="text" class="form-control form-control-sm" placeholder="Stock (quantité) initial" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Code</label>
                  <input type="text" name="code_b" id="ajout_code" placeholder="Code" class="form-control form-control-sm">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Date de péremption</label>
                  <input type="date" name="date_p" id="ajout_date_p" placeholder="Code" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Photo</label>
                  <input type="file" name="imgInp" id="file-ip-1" onchange="showPreview(event);" class="form-control form-control-sm file-ip-1">
                </div>
                <input name="id_boutique" type="hidden" class="form-control form-control-sm" required="" value="<?php echo $_SESSION['id_boutique']; ?>" />
              </div>

              <div class="col">
                <div class="d-flex flex-column align-items-center text-center">
                  <br />
                  <img id='file-ip-1-preview' class="rounded-circle" width="100" height="100" />
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
                  <div style="color:red; font-size:12px;display: none;" id="id_categorieed">Champs requis *</div>
                  <select name="id_categorie" id="edit_id_categorie1" class="form-control form-control-sm" style="width: 100%;">
                    <?php echo $categorie; ?>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Description</label>
                  <div style="color:red; font-size:12px;display: none;" id="description_articleed">Champs requis *</div>
                  <input name="description_article" id="description_article" type="text" class="form-control form-control-sm" placeholder="Description" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Prix de vente</label>
                  <div style="color:red; font-size:12px;display: none;" id="prixed">Champs requis *</div>
                  <input name="prix" id="prix" type="text" class="form-control form-control-sm" placeholder="Prix de vente" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Prix d'achat</label>
                  <div style="color:red; font-size:12px;display: none;" id="prix_aed">Champs requis *</div>
                  <input name="prix_a" id="prix_a" type="text" class="form-control form-control-sm" placeholder="Prix d'achat" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Stock (quantité)</label>
                  <div style="color:red; font-size:12px;display: none;" id="qteed">Champs requis *</div>
                  <input name="qte" id="qte" type="text" class="form-control form-control-sm" placeholder="Stock (quantité)" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Stock (quantité) initial</label>
                  <div style="color:red; font-size:12px;display: none;" id="stock_inied">Champs requis *</div>
                  <input name="stock_ini" id="stock_ini" type="text" class="form-control form-control-sm" placeholder="Stock (quantité) initial" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" />
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Code</label>
                  <input type="text" name="code_b" id="code_b" placeholder="Code" class="form-control form-control-sm">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Date de péremption</label>
                  <input type="date" name="date_p" id="date_p" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Photo</label>
                  <input type="file" name="imgInp" id="imgInps" class="form-control form-control-sm">
                </div>
              </div>

              <div class="col">
                <div class="d-flex flex-column align-items-center text-center">
                  <br />
                  <span id='img-uploads' class="rounded-circle" width="100" height="100"></span>
                  <img id='img-uploadss' class="rounded-circle" width="100" height="100" />
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
                  <strong>Prix de vente</strong>
                  <div id="prixx"></div>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <strong>Prix d'achat</strong>
                  <div id="prix_aa"></div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <strong>Stock</strong>
                  <div id="qtee"></div>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <strong>Stock initial</strong>
                  <div id="initial"></div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <strong>Code</strong>
                  <div id="id_code"></div>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <strong>Date de péremption</strong>
                  <div id="date_pp"></div>
                </div>
              </div>
            </div>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermeri">Fermer</button>
        </div>
      </div>
    </div>
  </div>
  <!------IMPORTER--------------->
  <form id="import_form" enctype="multipart/form-data">
    <div class="modal fade" id="importmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" style="max-width: 70%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Importé !</h5>
            <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
          </div>
          <input name="id_boutique" type="text" class="form-control form-control-sm" required="" value="<?php echo $id; ?>" hidden />

          <div class="modal-body">
            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <label>Fichier excel</label>
                  <input type="file" class="form-control form-control-sm" name="file-import" id="fileupload">
                  <div style="color:red; font-size:12px;display: none;" id="requireimport"> un fichier Excel requis *</div>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label>Categorie</label>
                  <select name="id_categorie" id="select_categorie" class="form-control form-control-sm" style="width: 100%;">
                    <?php echo $categorie; ?>
                  </select>
                  <div style="color:red; font-size:12px;display: none;" id="id_categorie_import">Champs requis *</div>
                </div>
              </div>
              <div class="col">
              </div>
            </div>
            <div class="form-group" style="height: 500px;overflow: auto;">
              <table id="tblItems" class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>Description</th>
                    <th>Prix de vente</th>
                    <th>Prix d'achat</th>
                    <th>Stock (quantité)</th>
                    <th>Stock (quantité) initial</th>
                    <th>Code</th>
                    <th>Date de péremption</th>
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
  <!------FORMULAIRE EXPORTER------->
  <div class="modal fade" id="exportmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Exporter !</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
        <div class="modal-body">
          <label>Categorie</label>
          <div style="color:red; font-size:12px;display: none;" id="id_categorie_export">Champs requis *</div>
          <select name="id_categorie" id="select_categorie_export" class="form-control form-control-sm" style="width: 100%;">
            <?php echo $categorie; ?>
          </select>
          <table id="table_categorie" style="display: none;">
            <tbody>

            </tbody>
          </table>
          <div class="nom_categorie" style="display: none;"></div>
          <div class="compte_product" style="text-align: center;color:red; font-size:12pt;display: none;margin-top: 5px;">Aucune donnée à exporter</div>
          <div class="nombre_product" style="text-align: center;color:blue; font-size:12pt;display: none;margin-top: 5px;"><span id="nbr_table"></span> donnée(s) à exporter</div>
          <input type="text" name="" id="compte_product" hidden>
        </div>

        <div class="modal-footer">
          <button type="submit" id="exportdata" class="btn btn-primary">Exporter</button>
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="fermers">Fermer</button>
        </div>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE EXPORTER------->

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
    $('#btn_photo').click(function() {
      $('.file-ip-1').click()
    })
    $(document).ready(function(e) {
      // Submit form data via Ajax
      $("#insertForm").on('submit', function(e) {
        e.preventDefault();

        if ($("#id_categorie").val() == "") {
          $("#id_categorieadd").show().delay(5000).hide(0);
        } else if ($("#ajout_description").val() == "") {
          $("#ajout_descriptionadd").show().delay(5000).hide(0);
        } else if ($("#ajout_prix_vente").val() == "") {
          $("#ajout_prix_venteadd").show().delay(5000).hide(0);
        } else if ($("#ajout_prix_achat").val() == "") {
          $("#ajout_prix_achatadd").show().delay(5000).hide(0);
        } else if ($("#ajout_qte").val() == "") {
          $("#ajout_qteadd").show().delay(5000).hide(0);
        } else if ($("#ajout_stock_ini").val() == "") {
          $("#ajout_stock_iniadd").show().delay(5000).hide(0);
        } else {
          $('#exampleModal').modal("hide");

          $.ajax({
            type: 'POST',
            url: '../controller/article/insert',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
              $('#insertdata').attr("disabled", "disabled");
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
            window.location.href = "article?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
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
        } else if ($("#select_categorie").val() == "") {
          $("#id_categorie_import").show().delay(5000).hide(0);
        } else {
          $('#exampleModal').modal("hide");

          $.ajax({
            type: 'POST',
            url: '../controller/article/import',
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
            window.location.href = "article?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
          });
        }
      });
      $("#updateForm").on('submit', function(e) {

        e.preventDefault();
        if ($("#edit_id_categorie1").val() == "") {
          $("#id_categorieed").show().delay(5000).hide(0);
        } else if ($("#description_article").val() == "") {
          $("#description_articleed").show().delay(5000).hide(0);
        } else if ($("#prix").val() == "") {
          $("#prixed").show().delay(5000).hide(0);
        } else if ($("#prix_a").val() == "") {
          $("#prix_aed").show().delay(5000).hide(0);
        } else if ($("#qte").val() == "") {
          $("#qteed").show().delay(5000).hide(0);
        } else if ($("#stock_ini").val() == "") {
          $("#stock_inied").show().delay(5000).hide(0);
        } else {
          $('#editmodal').modal("hide");

          $.ajax({
            type: 'POST',
            url: '../controller/article/update',
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
            window.location.href = "article?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
          });
        }
      });

      $("#deleteForm").on('submit', function(e) {
        e.preventDefault();
        $('#deletemodal').modal("hide");

        $.ajax({
          type: 'POST',
          url: '../controller/article/delete',
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
          window.location.href = "article?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
        });

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
    $("#id_boutique").select2({
      dropdownParent: $("#exampleModal")
    });
    $("#id_categorie").select2({
      dropdownParent: $("#exampleModal")
    });
    $("#edit_id_boutique").select2({
      dropdownParent: $("#editmodal")
    });
    $("#edit_id_categorie").select2({
      dropdownParent: $("#editmodal")
    });
    $("#select_categorie").select2({
      dropdownParent: $("#importmodal")
    });
    $("#select_categorie_export").select2({
      dropdownParent: $("#exportmodal")
    });
    $("#edit_id_categorie1").select2({
      dropdownParent: $("#editmodal")
    });
    $("#edit_id_categorie1").select2({
      dropdownParent: $("#editmodal")
    });
    $(document).on('click', '#importer', function(e) {
      $("#importmodal").modal("show");
    })
    $(document).on('click', '#exporter', function(e) {
      $('#exportmodal').modal("show");
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
      $('#img-uploads').show();
      $('#img-uploadss').hide();
      e.preventDefault();

      var id_article = $(this).data('id');
      var id_article_p = $(this).data('id');
      $.ajax({
        url: '../controller/article/fetch_article',
        type: "post",
        data: {
          id_article: id_article
        },
        dataType: 'json',
        success: function(data) {

          $("#edit_id").val(data.id_article);
          $("#edit_id_boutique").val(data.id_boutique);
          $("#edit_id_categorie1").val(data.id_categorie_stock).trigger("change");
          $("#description_article").val(data.description_article);
          $("#prix").val(data.prix_v);
          $("#prix_a").val(data.prix_a);
          $("#qte").val(data.qte);
          $("#stock_ini").val(data.stock_ini);
          $("#code_b").val(data.code_b);
          $("#date_p").val(data.date_p);
          $("#img-uploads").html(data.imgInp);

        }
      });

      $("#editmodal").modal("show");

    });

    $(document).on('click', '#deletebtn', function(e) {
      $('#img-uploads').show();
      $('#img-uploadss').hide();
      e.preventDefault();

      var id_article = $(this).data('id');
      $.ajax({
        url: '../controller/article/fetch_article',
        type: "post",
        data: {
          id_article: id_article
        },
        dataType: 'json',
        success: function(data) {

          $("#delete_id").val(data.id_article);
          $("#del_stock").val(data.description_article);
          $("#deletemodal").modal("show");

        }
      });
    });
    $(document).on('change', '#select_categorie_export', function(e) {

      e.preventDefault();

      var id_categorie = $(this).val();
      $.ajax({
        url: '../controller/article/fetch_categorie',
        type: "post",
        data: {
          id_categorie: id_categorie
        },
        //dataType: 'json',
        success: function(response) {
          var gp_data = $.parseJSON(response);
          $('#table_categorie tbody').html("");
          for (var i = 0; i < gp_data.length; i++) {

            $('.nom_categorie').html(gp_data[i].categorie_stock)
            var div = `
            <tr>
            <td>${gp_data[i].description_article}</td>
             <td>${gp_data[i].prix}</td>
              <td>${gp_data[i].prix_a}</td>
               <td>${gp_data[i].qte}</td>
                <td>${gp_data[i].stock_ini}</td>
                <td>${gp_data[i].code_b}</td>
                 <td>${gp_data[i].date_p}</td>
            </tr>
            `;
            $('#table_categorie tbody').append(div);

          }
          var compte = $('#table_categorie tbody tr').length;
          $("#compte_product").val(compte)
          $("#nbr_table").html(compte)
          if ($("#compte_product").val() == "") {
            $('.compte_product').show()
            $(".nombre_product").hide()
          } else if ($("#compte_product").val() == "0") {
            $('.compte_product').show()
            $(".nombre_product").hide()
          } else {
            $(".nombre_product").show()
            $('.compte_product').hide()
          }
        }
      });
    })
    $(document).on('click', '#infobtn', function(e) {
      e.preventDefault();

      var id_article = $(this).data('id');
      var id_article_p = $(this).data('id');
      $.ajax({
        url: '../controller/article/fetch_article',
        type: "post",
        data: {
          id_article: id_article
        },
        dataType: 'json',
        success: function(data) {

          $("#info_id_categorie").html(data.id_article);
          $("#categorie").html(data.categorie_stock);
          $("#description").html(data.description_article);
          $("#prixx").html(data.prix_v);
          $("#prix_aa").html(data.prix_a);
          $("#qtee").html(data.qte);
          $("#initial").html(data.stock_ini);
          $("#id_code").html(data.code_b);
          $("#date_pp").html(data.date_pp);
          $("#img-upload-info").html(data.imgInp);
        }
      });
      $.ajax({
        url: '../controller/article/fetch_peremption',
        type: "post",
        data: {
          id_article_p: id_article_p
        },
        dataType: 'json',
        success: function(data) {
          $("#date_pp").html(data.date_pp);

        }
      });
      $("#infomodal").modal("show");

    });
  </script>

  <script>
    var scrolled = 0;

    if (annyang) {
      annyang.setLanguage('fr-FR');
      // Let's define our first command. First the text we expect, and then the function it should call
      var commands = {
        'catégorie': function() {
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("open");
        },
        'description': function() {
          $("#ajout_description").focus()
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("close");
        },
        'prix de vente': function() {
          $("#ajout_prix_vente").focus()
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("close");
        },
        "prix d'achat": function() {
          $("#ajout_prix_achat").focus()
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("close");
        },
        "quantité": function() {
          $("#ajout_qte").focus()
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("close");
        },
        "quantité initiale": function() {
          $("#ajout_stock_ini").focus()
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("close");
        },
        "code": function() {
          $("#ajout_code").focus()
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("close");
        },
        "date de péremption": function() {
          $("#ajout_date_p").focus()
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("close");
        },
        "photo": function() {
          $('.file-ip-1').focus();
          var opencustomer = $("#id_categorie").select2();
          opencustomer.select2("close");
        },
        'modifier catégorie': function() {
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("open");
        },
        'modifier description': function() {
          $("#description_article").focus()
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("close");
        },
        'modifier prix de vente': function() {
          $("#prix").focus()
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("close");
        },
        "modifier prix d'achat": function() {
          $("#prix_a").focus()
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("close");
        },
        "modifier quantité": function() {
          $("#qte").focus()
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("close");
        },
        "modifier quantité initiale": function() {
          $("#stock_ini").focus()
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("close");
        },
        "modifier code": function() {
          $("#code_b").focus()
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("close");
        },
        "modifier date de péremption": function() {
          $("#date_p").focus()
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("close");
        },
        "modifier photo": function() {
          $('#imgInps').focus();
          var opencustomer = $("#edit_id_categorie1").select2();
          opencustomer.select2("close");
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
          $('#btn_photo').click()
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
            window.location.href = "article?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";

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
            url: '../controller/article/fetch_article',
            type: "post",
            data: {
              id_champ: id_champ,
              id_boutiques: id_boutiques
            },
            dataType: 'json',
            cache: false,
            async: true,
            success: function(data) {
              console.log(data.id_article)
              $("#numv").val(data.id_article)
              $("#edit_id").val(data.id_article);
              $("#edit_id_boutique").val(data.id_boutique);
              $("#edit_id_categorie1").val(data.id_categorie_stock);
              $("#description_article").val(data.description_article);
              $("#prix").val(data.prix_v);
              $("#prix_a").val(data.prix_a);
              $("#qte").val(data.qte);
              $("#stock_ini").val(data.stock_ini);
              $("#code_b").val(data.code_b);
              $("#img-uploads").html(data.imgInp);
              $("#info_id_categorie").html(data.id_article);
              $("#categorie").html(data.categorie_stock);
              $("#description").html(data.description_article);
              $("#prixx").html(data.prix_v);
              $("#prix_aa").html(data.prix_a);
              $("#qtee").html(data.qte);
              $("#initial").html(data.stock_ini);
              $("#id_code").html(data.code_b);
              $("#img-upload-info").html(data.imgInp);
              $("#delete_id").val(data.id_article);
              $("#del_stock").val(data.description_article);
              $.ajax({
                url: '../controller/article/fetch_peremption',
                type: "post",
                data: {
                  id_champ: id_champ,
                  id_boutiques: id_boutiques
                },
                dataType: 'json',
                cache: false,
                async: true,
                success: function(data) {
                  console.log(data.date_p)
                  $("#date_p").val(data.date_p);
                  $("#date_pp").html(data.date_pp);
                }
              });
            }
          });
        }
      };

      // Add our commands to annyang
      annyang.addCommands(commands);

      // Start listening. You can call this here, or attach this call to an event, button, etc.
      annyang.start();
    }
    $('#fileupload').on("change", function() {
      var validExts = new Array(".xlsx", ".xls", ".csv");
      var fileExt = $('#fileupload').val();
      fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
      if (validExts.indexOf(fileExt) < 0) {
        $('#requireimport').show().delay(5000).hide(0);
        return false;
      } else {

      }
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
              if (columns[5] == null) {
                columns[5] = "";
              } else {
                columns[5];
              }
              if (columns[6] == null) {
                columns[6] = "";
              } else {
                columns[6];
              }
              rows.append(`
                        <tr class="body_caption_top">
                           <td>
                              <div class="form-group">
                                <input type="text" name="description_article[]" id="ajouter_catégorie" type="text" class="form-control form-control-sm" placeholder="Description" required="" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[0]}"/>
                              </div>
                           </td>
                            <td>
                              <div class="form-group">
                                 <input type="text" name="prix[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Prix de vente" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[1]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input type="text" name="prix_a[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Prix d'achat" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[2]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input type="text" name="qte[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Stock (quantité)" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[3]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input type="text" name="stock_ini[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Stock (quantité) initial" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[4]}">
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                 <input type="text" name="code_b[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Code" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[5]}">
                              </div>
                            </td>
                             <td>
                              <div class="form-group">
                                 <input type="date" name="date_p[]" id="ajouter_description" class="form-control form-control-sm" placeholder="Code" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" value="${columns[6].split("/").reverse().join("-")}">
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
    $('#exportdata').click(function() {
      var nom_categorie = $('.nom_categorie').text()
      if ($("#select_categorie_export").val() == "") {
        $('#id_categorie_export').show().delay(5000).hide(0)
      } else if ($("#compte_product").val() == "") {
        $('.compte_product').show().delay(5000).hide(0)
        $(".nombre_product").hide()
      } else if ($("#compte_product").val() == "0") {
        $('.compte_product').show().delay(5000).hide(0)
        $(".nombre_product").hide()
      } else {
        $(".nombre_product").show()
        $("#table_categorie").table2excel({
          exclure: ".excludeThisClass",
          name: "Worksheet Name",
          filename: `Article ${nom_categorie}.xls`, // inclure l'extension 
          preserveColors: false // définir sur true si vous souhaitez que les couleurs d'arrière-plan et les couleurs de police soient préservées 
        });
      }
    });
  </script>

<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
  header("Location:../");
}
?>