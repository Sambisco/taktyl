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
  <link rel="stylesheet" href="../assets/css/fab.css">

  <style>
    .toggle {
      --width: 100px;
      --height: calc(var(--width) / 3);

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

    .minus,
    .plus,
    .minusR,
    .plusR,
    .addR,
    .delR {
      width: 20px;
      background: #0275d8;
      border-radius: 4px;
      border: 0px solid #ddd;
      display: inline-block;
      vertical-align: middle;
      text-align: center;
      color: #fff;
    }

    .qteA,
    .qteR {
      width: 50px;
      font-size: 14px;
      text-align: center;
      border: 1px solid #ddd;
      border-radius: 4px;
      display: inline-block;
      vertical-align: middle;
    }
    .prix_var{
  width: 50%;
  height:25px;
  border: 1px solid #ddd;
  border-radius: 4px;
  text-align: center;
}
    .paragraph {
      margin-bottom: 5px;
      font-size: 15px;
    }
 
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
  <?php
   if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $id = encryptor('decrypt',$id);
  
  }
  ?>


  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
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
      <div class="col-xl-12 col-lg-12" id="content1">
        <div class="card mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center ">
            <h3 class="h3 mb-0 text-gray-800">Modifier vente</h3>
          </div>
          <div style="float: right;position: fixed;right: 10px;z-index: 1;top: 90px;">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <i class="fas fa-shopping-cart fa-2x" aria-hidden="true" style="cursor: pointer;color: #22bb33;" data-toggle="modal" data-target="#exampleModalScrollable" id="#modalScroll"></i>
              </div>
              <span style="display:inline-block;font-size:12px;background-color: #d9534f;height: 30px;width:30px;margin-left: -1; margin-right: 5px;margin-top: 20px; border-radius: 50%;color: #fff;font-weight: bold;text-align: center;padding-top: 5px;" id="compteur1">
              </span>
            </div>
          </div>

          <div id="demo" class="box jplist p-3" style="margin: -20px 0 50px 0">
            <input type="hidden" id="id_boutiques" value="<?php echo $id; ?>">
            <input type="hidden" class="id_champ" id="id_champ">
            <input type="hidden" class="id_article_vente" id="id_article_vente">
            <!-- ios button: show/hide panel -->
            <div class="jplist-ios-button">
              <i class="fa fa-sort"></i>
              Actions
            </div>

            <!-- panel -->
            <div class="jplist-panel box panel-top">

              <!-- back button button -->
              <button type="button" style="background: #0275d8; color: #fff; width: 120px;" data-control-type="back-button" data-control-name="back-button" data-control-action="back-button">
                <i class="fa fa-arrow-left"></i> Retour
              </button>
              <!-- reset button -->
              <button style="background: #0275d8; color: #fff; width: 120px;" type="button" data-control-type="reset" data-control-name="reset" data-control-action="reset">
                Actualiser &nbsp;<i class="fa fa-share"></i>
              </button>

              <!-- items per page dropdown -->
              <div class="jplist-drop-down" data-control-type="items-per-page-drop-down" data-control-name="paging" data-control-action="paging">

                <ul>
                  <li><span data-number="10"> 10 par page </span></li>
                  <li><span data-number="18" data-default="true"> 18 par page </span></li>
                  <li><span data-number="30"> 30 par page </span></li>
                  <li><span data-number="40"> 40 par page </span></li>
                  <li><span data-number="50"> 50 par page </span></li>
                  <li><span data-number="100"> 100 par page </span></li>
                  <li><span data-number="all"> Affichez tous </span></li>
                </ul>
                </ul>
              </div>

              <!-- sort dropdown -->


              <!-- filter by title -->
              <div class="text-filter-box">

                <i class="fa fa-search  jplist-icon" style="background-color: #0275d8; color: #fff;"></i>

                <!--[if lt IE 10]>
                    <div class="jplist-label">Filter by Title:</div>
                    <![endif]-->

                <input data-path=".title" class="categorie" id="categorie" type="text" value="" placeholder="Catégorie..." data-control-type="textbox" data-control-name="title-filter" data-control-action="filter" style="width: 230px;" />
              </div>

              <!-- filter by description -->
              <div class="text-filter-box">

                <i class="fa fa-search  jplist-icon" style="background-color: #0275d8; color: #fff;"></i>

                <!--[if lt IE 10]>
                    <div class="jplist-label">Filter by Description:</div>
                    <![endif]-->

                <input data-path=".desc" class="produit" id="produit" type="text" value="" placeholder="Article..." data-control-type="textbox" data-control-name="desc-filter" data-control-action="filter" style="width: 230px;" />
              </div>

              <div class="jplist-group">
              <ul>

                <?php

                $query = "SELECT * FROM article 
                 INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
                 INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                 WHERE boutique.id_boutique='$id' GROUP BY categorie_stock.id_categorie_stock ORDER BY id_article DESC";
                $statement = $db->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $total_row = $statement->rowCount();
                if ($total_row > 0) {
                  $count = 1;
                  foreach ($result as $row) {
                    $count++;
                ?>

                      <li>
                        <span data-control-type="button-filter" data-control-action="filter" data-control-name="<?php echo $row["id_categorie_stock"]; ?>" data-path=".<?php echo $row["id_categorie_stock"]; ?>" data-selected="false">
                          <i class="fa fa-caret-right"></i>
                          <?php echo $row["categorie_stock"]; ?>
                        </span>

                      <li>
                    <?php }
                } ?>



                    </ul>

              </div>


              <!-- pagination results -->
              <div class="jplist-label" data-type="Page {current} sur {pages}" data-control-type="pagination-info" data-control-name="paging" data-control-action="paging">

              </div>

              <!-- pagination control -->
              <div class="jplist-pagination" data-control-type="pagination" data-control-name="paging" data-control-action="paging">
              </div>

            </div>
            <!-- data -->
            <div class="table-responsive p-3 ">
              <div class="row mb-3 list box text-shadow conteneur" style="padding-bottom: 20px;margin-top: 10px;">
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
                  $count = 1;
                  foreach ($result as $row) {
                    $count++;
                ?>
                    <div class="col-xl-2 col-md-6 mb-4  list-item box" id="sous_content1_<?php echo $row['id_article']; ?>">
                      <div class="card h-70 ">
                        <div class="card-body ">
                          <center>
                            <div class="date paragraph">
                              <?php if ($row["imgInp"] == null) { ?>
                                <img src="../img/img/image.jpg" class="img-thumbnail img-thumbnail-mobile"  alt="icons8-team-100" id="image_<?php echo $count; ?>">
                              <?php } else { ?>
                                <img src="<?php echo $row['imgInp']; ?>" class="img-thumbnail img-thumbnail-mobile" alt="icons8-team-100" id="image_<?php echo $count; ?>">
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
                            <div class="title paragraph" style="color: #0275d8;margin-top: -2px;font-size: 14px;"> <?php echo $row["categorie_stock"]; ?></div>
                            <div class="desc paragraph" style="margin-top: -5px;font-size: 14px;"> <?php echo $row["description_article"]; ?></div>
                            <div class="like paragraph" style="margin-top: 5px;font-size: 14px;">
                              <span>Prix :</span>&nbsp;<span style="color: green; font-weight: bold;font-size: 12px;"><input type="text" class="prix_var" name="" id="prix_var_<?php echo $row['id_article']; ?>" value="<?php echo number_format($row["prix"], 0, ",", " "); ?>"></span>
                            </div>
                            <div class="paragraph" style="margin-top: 5px;font-size: 14px;">
                              <span>Stock :</span>&nbsp;
                              <span style="color: blue; font-weight: bold;font-size: 12px;" id="stock_red_<?php echo $row['id_article']; ?>">
                                <?php echo $row["qte"]; ?>
                              </span>
                              <span class="stock_red1" style="color: blue; font-weight: bold;display: none;" id="stock_red1_<?php echo $row['id_article']; ?>">
                                <?php echo $row["qte"]; ?>
                              </span>
                              <input type="hidden" name="" class="resultstock" id="resultstock_<?php echo $row['id_article']; ?>" value="<?php echo $row["qte"]; ?>">

                            </div>
                            <div class="theme paragraph">
                              <span class="<?php echo $row["id_categorie_stock"]; ?> paragraph"></span>
                            </div>
                            <div class="message_show" id="message_show_<?php echo $row['id_article']; ?>" style="font-size:11px ; color: red; margin-bottom: 0px;"></div>
                            <div class="number">
                              <button class="minus" id="minus_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">-</button>
                              <input type="text" class="qteA" id="qteA_<?php echo $row['id_article']; ?>" style="text-align: center;" data-id="<?php echo $row['id_article']; ?>" />
                              <button class="plus" id="plus_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">+</button>
                            </div>
                            <div class="promotion" style="margin-top: 5px; font-size: 14px; cursor: pointer;display: none;" id="promotion_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">
                              <span style="color: #22bb33;font-weight: bold;">Promotion </span>
                              <i class="fa fa-eye showpromotion" style="color: #d9534f;" id="showpromotion_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>"></i>
                              <i class="fa fa-close closepromotion" style="color: #d9534f;" id="closepromotion_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>"></i>
                            </div>
                            <div style="top: 50;height: 55%;margin-bottom: 5px; font-size: 14px;border: #0275d8 solid 1px;padding: 2px;display: none;text-align: left;z-index: 2;background-color:#fff;position: absolute;right: 15;left: 15;overflow-y: scroll;" id="descpromotion_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">

                            </div>
                            <div class="number" style="margin-top: 5px;font-size: 14px;">
                              Remise
                              <button class="addR" id="addR_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">%</button>
                              <button class="delR" id="delR_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">&times;</button>
                            </div>
                            <div class="number div_R" style="margin-top: 5px;" id="div_R_<?php echo $row['id_article']; ?>">
                              <button class="minusR" id="minusR_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">-</button>
                              <input type="text" class="qteR" id="qteR_<?php echo $row['id_article']; ?>" style="text-align: center;" data-id="<?php echo $row['id_article']; ?>" />
                              <button class="plusR" id="plusR_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">+</button>
                            </div>
                            <label class="toggle" style="margin-top: 5px;">
                              <input type="checkbox" class="reserver" id="reserver_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">
                              <span class="slider"></span>
                              <span class="labels" data-on="Retirer" data-off="Panier"></span>
                            </label>
                          </center>
                        </div>
                      </div>
                    </div>

                <?php
                  }
                }
                ?>

              </div>

            </div>

            <div class="box jplist-no-results text-shadow align-center">
              <p style="text-align: center;">Aucun résultat trouvé</p>
            </div>
            <!-- panel -->
            <div class="jplist-panel box panel-bottom">

              <!-- items per page dropdown -->
              <div class="jplist-drop-down" data-control-type="items-per-page-drop-down" data-control-name="paging" data-control-action="paging" data-control-animate-to-top="true">

                <ul>
                  <li><span data-number="10"> 10 par page </span></li>
                  <li><span data-number="18" data-default="true"> 18 par page </span></li>
                  <li><span data-number="30"> 30 par page </span></li>
                  <li><span data-number="40"> 40 par page </span></li>
                  <li><span data-number="50"> 50 par page </span></li>
                  <li><span data-number="100"> 100 par page </span></li>
                  <li><span data-number="all"> Affichez tous </span></li>
                </ul>
                </ul>
              </div>

              <!-- sort dropdown -->


              <!-- pagination results -->
              <div class="jplist-label" data-type="{start} - {end} sur {all}" data-control-type="pagination-info" data-control-name="paging" data-control-action="paging">
              </div>

              <!-- pagination -->
              <div class="jplist-pagination" data-control-animate-to-top="true" data-control-type="pagination" data-control-name="paging" data-control-action="paging">
              </div>

            </div>
          </div>

        </div>
      </div>
      <!------DIV 2--------->
      <div class="col-xl-3 col-lg-7">
        <!------CONTENT--------->
      </div>
      <!------FIN DIV 2--------->

      <!------DIV 4--------->

      <!-----POSITION FIXED--------->
      <div>
        <div class="fab-container" style="float: right;	position: fixed;bottom: 270px;right: 10px;">
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="fab fab-icon-holder fab-button">
                <i class="fas fa-user"></i>
              </div>
              <div class="fab fab-icon-holder fab-hide" style="display: none;">
                <i class="fas fa-user-times"></i>
              </div>
            </div>
          </div>
          <ul class="fab-options fab-show" style="display: none;">
            <li style="display: none;">
              <span class="fab-label">Liste client</span>
              <div class="fab-icon-holder" id="listclient">
                <i class="fas fa-users"></i>
              </div>
            </li>
            <li>
              <span class="fab-label">Modifier client</span>
              <div class="fab-icon-holder" id="modclient">
                <i class="fas fa-user-minus"></i>
              </div>
            </li>
            <li>
              <span class="fab-label">code QR</span>
              <div class="fab-icon-holder" id="codeqr">
                <i class="fas fa-video"></i>
              </div>
            </li>

          </ul>
        </div>
      </div>
      </form>
    </div>
    <!-----POSITION FIXED--------->
    <div>
      <div class="fab-container" style="float: right;	position: fixed;bottom: 50px;right: 10px;">
        <div class="input-group mb-3">

          <div class="fab-icon-holder" id="btncalcul">
            <i class="fas fa-calculator"></i>
          </div>
        </div>

      </div>
    </div>
    </form>
  </div>
  <!-- Modal Scrollable -->
  <form id="invoice_form" enctype="multipart/form-data">
    <?php
    $edit_id = $_GET["edit_id"];
    $query = "SELECT *,vente.prix as prix_v FROM tva 
      INNER JOIN vente ON tva.id_tva=vente.id_tva 
      INNER JOIN account ON tva.id_tva=account.id_tva 
      INNER JOIN livraison ON tva.id_tva=livraison.id_tva 
      INNER JOIN detail_vente ON tva.id_tva=detail_vente.id_tva 
      INNER JOIN article ON article.id_article=vente.id_article 
      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
      INNER JOIN client ON client.id_client=tva.id_client 
   INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
WHERE tva.id_tva='$edit_id'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if ($total_row > 0) {
      foreach ($result as $row) {
      }
    ?>
      <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalScrollableTitle">Panier Vente 00<?php echo $row["num"]; ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="d-flex flex-row-reverse">
                <div class="p-0">
                  <div class="form-group" id="simple-date1">
                    <label for="simpleDataInput">Date :</label>
                    <div class="input-group date">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                      </div>
                      <input type="hidden" name="id_tva" id="" value="00<?php echo $row["id_tva"]; ?>">
                      <input type="datetime-local" id="date1" name="date" class="form-control form-control-sm" value="<?php echo $row["date"]; ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6" style="display: flex;">
                  <i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
                  <input type="hidden" name="id_client" id="id_clientCheck" value=" <?php if($row['id_client']<10){echo "0" . $row['id_client'];}else{ echo $row['id_client'];} ?>">
                  <div id="id_nom_client" style="margin-left: 5px;margin-right: 10px; font-size: 13px;padding-top: 10px;">
                    <?php echo $row["nom_client"]; ?>

                  </div>
                </div>
                <div class="form-group col-md-6" style="display: flex;font-size: 13px;">
                  <span class='fa-stack fa-lg'>
                    <i class='fas fa-circle fa-stack-2x'></i>
                    <i class='fas fa-phone fa-stack-1x fa-inverse'></i>
                  </span>
                  <div id="id_phone_client" style="margin-left: 10px;padding-top: 10px;">
                    <?php echo $row["telephonec"]; ?>

                  </div>
                </div>

              </div>

              <hr style="margin-bottom: 5px; margin-top: -10px;">
              <div class="row" id="client">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Nom client</label>
                    <input type="text" name="nom_client" id="nom_client" class="form-control form-control-sm" placeholder="Nom client" value="<?php echo $row["nom_client"]; ?>" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                    <input type="hidden" name="id_client" class="form-control form-control-sm" value="<?php echo $row['id_client']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="">Telephone</label>
                    <input type="text" name="telephonec" id="telephonec" class="form-control form-control-sm" placeholder="Telephone" value="<?php echo $row["telephonec"]; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Adresse</label>
                    <input type="text" name="adresse" id="adresse" class="form-control form-control-sm" placeholder="Adresse" value="<?php echo $row["adresse"]; ?>" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="emailc" id="emailc" class="form-control form-control-sm" placeholder="Email" value="<?php echo $row["emailc"]; ?>">
                  </div>
                </div>
              </div>
              <div class="table-responsive p-0">
                <table class="table align-items-center table-flush table-hover table-bordered table-sm" width="100%">
                  <tr>
                    <th style="display: none;">ID</th>
                    <th style="width: 200px;">Article</th>
                    <th style="width: 60px;display: none;">MONTANT</th>
                    <th style="width: 40px;">Qte</th>
                    <th style="width: 60px;display: none;">TOTAL</th>
                    <th style="width: 40px;text-align: right;">Rem %</th>
                    <th style="width: 60px;display: none;">MT TOTAL</th>
                  </tr>
                  <tbody id="invoiceItem">
                    <?php

                    $count = 0;
                    foreach ($result as $row) {
                      $count++;
                    ?>
                      <tr id="row" class="itemRow" data-mode="<?php echo $row['id_article']; ?>">
                        <td style="display: none;" class="spot"><input type="text" name="id_article[]" class="form-control form-control-sm prix" value="<?php echo $row['id_article']; ?>" readonly required="required"></td>
                        <td class="spot">
                          <?php if ($row["imgInp"] == null) { ?>
                            <img src="../img/img/image.jpg" width="30" height="20" alt="icons8-team-100">
                          <?php } else { ?>
                            <img src="<?php echo $row["imgInp"]; ?>" width="30" height="20" alt="icons8-team-100" />
                            <?php } ?>&nbsp;&nbsp;&nbsp;<?php echo $row["description_article"]; ?>
                        </td>
                        <td style="padding-top:15px;display: none;" class="spot"><input type="text" name="prix[]" class="form-control form-control-sm prix prix_var" value="<?php echo $row['prix_v']; ?>" id="prix_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>" required="required" readonly></td>
                        <td style="padding-top:7px" class="spot">
                          <div id="resultQte_<?php echo $row['id_article']; ?>"><?php echo $row["quantite"]; ?></div>
                          <input type="hidden" name="quantite[]" class="form-control form-control-sm quantite_<?php echo $row['id_article']; ?> egal_<?php echo $row['id_article']; ?>" value="<?php echo $row['quantite']; ?>" id="quantite_<?php echo $count; ?>" data-id="<?php echo $row['id_article']; ?>" onKeyUp="calculateTotal()" required="required" readonly>
                          <input type="hidden" name="" class="resultstockretourtab" id="resultstockretourtab_<?php echo $row['id_article']; ?>" value="<?php echo $row['quantite']; ?>">

                        </td>
                        <td style="padding-top:15px;display: none;" class="spot"><input type="hidden" name="quant[]" class="form-control form-control-sm quant_<?php echo $row['id_article'] ?>" value="<?php echo $row['qte']; ?>" id="quant_<?php echo $row['id_article']; ?>" required="required" readonly></td>
                        <td style="padding-top:7px;display: none;"><input type="text" name="total[]" id="total_<?php echo $count; ?>" class="form-control form-control-sm total" value="<?php echo $row['total']; ?>" readonly required="required"></td>
                        <td style="text-align: right;padding-top:7px;">
                          <div id="result_remise_<?php echo $row['id_article']; ?>"><?php if ($row["remise"] == 0) {
                                                                                    } else {
                                                                                      echo $row["remise"];
                                                                                    } ?></div><input type="hidden" name="remise[]" class="form-control form-control-sm remise rem remiseegal_<?php echo $row['id_article']; ?>" id="remise_<?php echo $count; ?>" data-id="<?php echo $row['id_article']; ?>" autocomplete="off" value="<?php if ($row["remise"] == 0) {
                                                                                                                                                                                                                                                                                                                                          echo "0";
                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                          echo $row["remise"];
                                                                                                                                                                                                                                                                                                                                        } ?>">

                        </td>
                        <td style="display: none;"><input type="text" name="mt_remise[]" id="mt_remise_<?php echo $count; ?>" class="form-control form-control-sm mt_remise" autocomplete="off" readonly></td>
                        <td style="display: none;"><input type="text" name="tot[]" id="tot_<?php echo $count; ?>" class="form-control form-control-sm tot" value="<?php echo $row['total']; ?>" readonly></td>
                        <td style="padding-top:15px;display: none;" class="spot">
                          <label class="toggle">
                            <input type="checkbox" class="checkrow" id="checkrow_" checked=" <?php echo $row["id_article"]; ?>checked" data-id="<?php echo $row['id_article']; ?>">
                            <span class="slider"></span>
                            <span class="labels" data-on="Retirer" data-off="Reserver"></span>
                          </label>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <hr style="margin-top:-17px ;">
              <div class="row">
                <div class="col-md-4">
                  <div class="">
                    <label>Acompte:</label>
                    <input name="id_account" type="hidden" value="<?php echo $row["id_account"]; ?>" />
                    <div id="div_montant" style="margin-top: -10px;"><?php if ($row["montant"] == 0) {
                                                                        echo "-----";
                                                                      } else {
                                                                        echo number_format($row["montant"], 0, ",", " ");
                                                                      } ?></div>
                  </div>
                  <hr style="margin: 0px;border-width: 2px;">
                  <div class="">
                    <label>Zone de livraison:</label>
                    <input name="id_livraison" type="hidden" value="<?php echo $row["id_livraison"]; ?>" />
                    <div id="div_zone" style="margin-top: -10px;"><?php if ($row["zone"] == "") {
                                                                    echo "-----";
                                                                  } else {
                                                                    echo $row["zone"];
                                                                  } ?></div>
                  </div>
                  <hr style="margin: 0px;border-width: 2px;">
                  <div class="">
                    <label>Tarif:</label>
                    <div id="div_tarif" style="margin-top: -10px;"><?php if ($row["tarif"] == 0) {
                                                                      echo "-----";
                                                                    } else {
                                                                      echo number_format($row["tarif"], 0, ",", " ");
                                                                    } ?></div>
                  </div>
                </div>
                <div class="col-md-4" style="text-align: right;">
                  <div class="">
                    <label>Espece remis:</label>
                    <div id="div_espece_du" style="margin-top: -10px;"><?php if ($row["espece_du"] == 0) {
                                                                          echo "-----";
                                                                        } else {
                                                                          echo number_format($row["espece_du"], 0, ",", " ");
                                                                        } ?></div>
                  </div>
                  <hr style="margin: 0px;border-width: 2px;">
                  <div class="">
                    <label>Espece rendu:</label>
                    <div id="div_espece_rendu" style="margin-top: -10px;"><?php if ($row["espece_rendu"] == 0) {
                                                                            echo "-----";
                                                                          } else {
                                                                            echo number_format($row["espece_rendu"], 0, ",", " ");
                                                                          } ?>
                    </div>
                  </div>
                  <hr style="margin: 0px;border-width: 2px;">
                  <div class="">
                    <label>Avoir:</label>
                    <input type="hidden" name="id_detail_vente" class="form-control form-control-sm" value="<?php echo $row["id_detail_vente"]; ?>">
                    <div id="div_avoir" style="margin-top: -10px;"><?php if ($row["avoir"] == 0) {
                                                                      echo "-----";
                                                                    } else {
                                                                      echo number_format($row["avoir"], 0, ",", " ");
                                                                    } ?></div>
                  </div>
                  <hr style="margin: 0px;border-width: 2px;">
                  <div class="">
                    <label>Mode paiement:</label>
                    <div id="div_mode" style="margin-top: -10px;"><?php if ($row["mode"] == 0) {
                                                                    echo "-----";
                                                                  } else {
                                                                    echo $row["mode"];
                                                                  } ?></div>
                  </div>
                </div>
                <div class="col-md-4" style="text-align: right;">
                  <div class="">
                    <label> Montant HT:</label>
                    <div id="div_mt_ht" style="margin-top: -10px;"><?php echo number_format($row["mt_ht"], 0, ",", " "); ?></div>
                  </div>
                  <hr style="margin: 0px;border-width: 2px;">
                  <div class="">
                    <label>Taux(%):</label>
                    <div id="div_tva" style="margin-top: -10px;">-----</div>
                  </div>
                  <hr style="margin: 0px;border-width: 2px;">
                  <div class="">
                    <label>Montant TVA :</label>
                    <div id="div_mt_tva" style="margin-top: -10px;"><?php if ($row["mt_tva"] == 0) {
                                                                      echo "-----";
                                                                    } else {
                                                                      echo number_format($row["mt_tva"], 0, ",", " ");
                                                                    } ?>
                    </div>
                  </div>
                  <hr style="margin: 0px;border-width: 2px;">
                  <div class="">
                    <label>Montant TTC :</label>
                    <div id="div_mt_ttc" style="margin-top: -10px;"><?php echo number_format($row["mt_ttc"], 0, ",", " "); ?></div>
                  </div>
                </div>
              </div>
              <hr style="margin: 0px;border-width: 2px;">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Remarque:</label>
                  <div id="div_description"><?php echo $row["description"]; ?></div>

                </div>
              </div>
            </div>
          <?php } ?>
          <div class="modal-footer">
            <button type="button" name="updatetdata" class="btn btn-primary" id="btn_enreg">Modifier</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fermer</button>
          </div>

          </div>
        </div>
      </div>
      </div>
      <!------FORMULAIRE AJOUT TVA------->
      <div class="modal fade" id="modaltva" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> Total vente !</h5>
              <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Acompte:</label>
                    <input type="text" name="montant" id="montant" class="form-control form-control-sm montant" value="<?php if ($row["montant"] == 0) {
                                                                                                                        } else {
                                                                                                                          echo $row["montant"];
                                                                                                                        } ?>">
                  </div>
                  <div class="form-group">
                    <label>Zone de livraison:</label>
                    <input type="text" name="zone" id="zone" class="form-control form-control-sm zone" value="<?php echo $row["zone"]; ?>">
                  </div>
                  <div class="form-group">
                    <label>Tarif:</label>
                    <input type="text" name="tarif" id="tarif" class="form-control form-control-sm tarif" value="<?php if ($row["tarif"] == 0) {
                                                                                                                    echo "";
                                                                                                                  } else {
                                                                                                                    echo $row["tarif"];
                                                                                                                  } ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Espece remis:</label>
                    <input type="text" name="espece_du" id="espece_du" class="form-control form-control-sm espece_du" value="<?php if ($row["espece_du"] == 0) {
                                                                                                                                echo "";
                                                                                                                              } else {
                                                                                                                                echo $row["espece_du"];
                                                                                                                              } ?>" onkeyup="monnaie()">
                  </div>
                  <div class="form-group">
                    <label>Espece rendu:</label>
                    <input type="text" name="espece_rendu" id="espece_rendu" class="form-control form-control-sm " value="<?php if ($row["espece_rendu"] == 0) {
                                                                                                                            echo "";
                                                                                                                          } else {
                                                                                                                            echo $row["espece_rendu"];
                                                                                                                          } ?>" readonly>
                    <input type="hidden" name="espece_rendu1" id="espece_rendu1" class="form-control form-control-sm " value="<?php if ($row["espece_rendu"] == 0) {
                                                                                                                                echo "";
                                                                                                                              } else {
                                                                                                                                echo $row["espece_rendu"];
                                                                                                                              } ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>Avoir:</label>
                    <input type="text" name="avoir" id="avoir" class="form-control form-control-sm avoir" value="<?php if ($row["avoir"] == 0) {
                                                                                                                    echo "";
                                                                                                                  } else {
                                                                                                                    echo $row["avoir"];
                                                                                                                  } ?>">
                  </div>
                  <div class="form-group">
                    <label>Mode paiement:</label>
                    <input type="text" name="mode" id="mode" class="form-control form-control-sm mode" value="<?php echo $row["mode"]; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label> Montant HT:</label>
                    <input type="text" name="mt_ht" id="mt_ht" class="form-control form-control-sm mt_ht" value="<?php echo $row["mt_ht"]; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>T.V.A(%):</label>
                    <input type="text" name="tva" id="tva" class="form-control form-control-sm tva " onkeyup="keytva()">
                  </div>
                  <div class="form-group">
                    <label>Montant TVA :</label>
                    <input type="text" name="mt_tva" id="mt_tva" class="form-control form-control-sm mt_tva" value="<?php if ($row["mt_tva"] == 0) {
                                                                                                                    } else {
                                                                                                                      echo $row["mt_tva"];
                                                                                                                    } ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>Montant TTC :</label>
                    <input type="text" name="mt_ttc" id="mt_ttc" class="form-control form-control-sm mt_ttc" value="<?php echo $row["mt_ttc"]; ?>" required="required" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Remarque:</label>
                  <textarea name="description" id="description" cols="" rows="" class="form-control"><?php echo $row["description"]; ?></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" name="deletedata" class="btn btn-primary" data-dismiss="modal" id="addclient">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      <!------FIN FORMULAIRE TVA------->
  </form>

  <!-- Modal Scrollable -->
  <!------FORMULAIRE MODIFIER CLIENT------->
  <div class="modal fade" id="modalclientmodifier" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Client !</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
        <form action="../controller/vente" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Nom client</label>
                  <input type="text" id="nom_clientmm" class="form-control form-control-sm" placeholder="Nom client" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">

                </div>
                <div class="form-group">
                  <label for="">Telephone</label>
                  <input type="text" id="telephonecmm" class="form-control form-control-sm" placeholder="(+221)">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Adresse</label>
                  <input type="text" id="adressemm" class="form-control form-control-sm" placeholder="Adresse" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                </div>
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" id="emailcmm" class="form-control form-control-sm" placeholder="Email" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" name="deletedata" class="btn btn-primary" data-dismiss="modal" id="modificlient">Ajouter</button>
          </div>

        </form>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE MODIFIER CLIENT------->
  <!------FORMULAIRE LIST CLIENT------->
  <?php

  $query = "SELECT  * FROM client
  INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
  WHERE boutique.id_boutique='$id'";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  ?>
  <div class="modal fade" id="ModalListeClient" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Liste client !</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
        <div class="modal-body">
          <div class="table-responsive p-0">
            <table id="example" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" data-order='[[0,"desc"]]'>
              <thead>
                <tr>
                <th>ID </th>
                  <th style="width: 300px;">Nom </th>
                  <th style="width: 150px;">Telephone</th>
                  <th style="width: 100px;">Actions</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                <th>ID </th>
                  <th>Nom </th>
                  <th>Telephone</th>
                  <th>Actions</th>
                </tr>
              </tfoot>
              <tbody class="tbody_m">
                <?php foreach ($result as $row) {
                  if ($row["nom_client"] == null) { ?>

                  <?php } else { ?>
                    <tr>
                    <td>
                    <div class="identifiant_cl" style="font-weight: bold;text-transform: uppercase;font-size: 14px; margin-bottom: 0px;" id="identifiant_cl_<?php if($row['id_client']<10){echo "0" . $row['id_client'];}else{ echo $row['id_client'];} ?>">  
                    <?php if($row['id_client']<10){echo "0" . $row['id_client'];}else{ echo $row['id_client'];} ?>
                    </div>
                  </td>
                      <td><?php echo $row["nom_client"]; ?></td>
                      <td><?php echo $row["telephonec"]; ?></td>
                      <td>
                        <label class="toggle" style="margin-top: 0px;">
                          <input type="checkbox" class="checked_id_client" id="checked_id_client_<?php if($row['id_client']<10){echo "0" . $row['id_client'];}else{ echo $row['id_client'];} ?>" data-id="<?php if($row['id_client']<10){echo "0" . $row['id_client'];}else{ echo $row['id_client'];} ?>">
                          <span class="slider"></span>
                          <span class="labels" data-on="Annuler" data-off="Achat"></span>
                        </label>
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

        <div class="modal-footer">
          <button type="button" name="deletedata" class="btn btn-primary" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE LIST CLIENT------->
  <!------FORMULAIRE AJOUT code------->
  <div class="modal fade" id="modalcodeqr" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" id="actived" class="btn btn-primary mr-1"><i class="fa fa-camera"></i></button>

          <label class="btn btn-success active mr-1">

            <input autocomplete="off" checked="" name="options" type="radio" value="1" />

          </label>

          <label class="btn btn-secondary">

            <input autocomplete="off" name="options" type="radio" value="2" />

          </label>
          <button class="close">
            <span aria-hidden="true"></span>
            <div>
              <div id="" style="text-align: right;font-size: 14px;display: inline-block;">Client :</div>
              <div id="smsnom" style="text-align: right;font-size: 14px;display: inline-block;color: blue;"></div>
            </div>
            <div>
              <div id="" style="text-align: right;font-size: 14px;display: inline-block;">Point :</div>
              <div id="smspoint" style="text-align: right;font-size: 14px;display: inline-block;color: red;"></div>
            </div>
            <div>
              <div id="" style="text-align: right;font-size: 14px;display: inline-block;">EX :</div>
              <div id="smsEX" style="text-align: right;font-size: 14px;display: inline-block;color: green;"></div>
            </div>
          </button>
        </div>
        <form action="../controller/vente" method="post" enctype="multipart/form-data">
          <div class="modal-body">

            <audio id="myAudio2">
              <source src="../img/codeQR/beep.mp3" type="audio/ogg">
            </audio>
            <center>
              <video id="preview" width="100%" height="100%" style="display: none;" controls="true">
              </video>
              <canvas id="canvas" style="width: 100%;" height="200"></canvas>
              <div id="divcanvas" style="border: solid 50px ;width: 100%;" height="300"><img src="../img/logo/video.png" alt="" width="200" height="200"></div>
            </center>
            <input type="hidden" id="sowcode" onkeyup="showCode();">
          </div>
          <div class="modal-footer">
            <button type="button" name="deletedata" class="btn btn-primary" data-dismiss="modal" id="addclient">Fermer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!----affiche promotion------->
  <div style="display: none;">
    <table>
      <tr>
        <th>1</th>
        <th>2</th>
        <th>3</th>
      </tr>
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
          if (strtotime($row["datefin"]) < strtotime(date("Y-m-d"))) {
          } else {
      ?>
            <tr>
              <td><input type="text" name="" class="tab_id_article_promo" id="tab_id_article_promo_<?php echo $row['id_article']; ?>" value="<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>"></td>
              <td><input type="text" name="" id="tab_reduction_promo_<?php echo $row['id_article']; ?>" value="<?php echo $row['reduction']; ?>"></td>
              <td><input type="text" name="" id="tab_conditions_promo_<?php echo $row['id_article']; ?>" value="<?php echo $row['conditions']; ?>"></td>
        <?php
          }
        }
      }
        ?>
            </tr>
    </table>
  </div>
  <!----affiche fin promotion------->
  <!------FIN FORMULAIRE code------->
  <!------FIN DIV 4--------->
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
    $(document).on('click', '#btn_enreg', function(e) {
      $("#btn_enreg").prop("disabled", true)
      var form_data = $("#invoice_form").serialize();
      $.ajax({
        url: "vente/update",
        method: "POST",
        data: form_data,
        success: function(data) {
          console.log(data)
        }
      })
      $('#exampleModalScrollable').modal("hide");

      swal({
        title: "Modifié!",
        text: "Modification effectuée avec succés.",
        type: "success",
        confirmButtonText: 'Ok',
        confirmButtonColor: '#3085d6',
        showConfirmButton: false,
        timer: 2000
      }, function() {
        window.location.href = "../page/vente?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>";
      });
    })
    $(function() {
      var compte = $('#invoiceItem >tr').length;
      $('#compteur1').html(compte);
      $(':input[type="submit"]').prop('disabled', false);
    })
    $('document').ready(function() {

      $('#demo').jplist({
        itemsBox: '.list',
        itemPath: '.list-item',
        panelPath: '.jplist-panel'
        //,debug: true
      });
    });
  </script>
  <script>
    $(".minus").each(function() {
      var chambre = $(this).data('id');
      $('#minus_' + chambre).prop('disabled', true);
    })
    $(".minusR").each(function() {
      var chambre = $(this).data('id');
      $('#minusR_' + chambre).prop('disabled', true);

    })
    $(".qteA").each(function() {
      var chambre = $(this).data('id');
      $('.qteA').attr('value', 0);
    })
    $(".qteR").each(function() {
      var chambre = $(this).data('id');
      $('.qteR').attr('value', 0);
      if ($('#qteR_' + chambre).val() == 1) {
        var stock_red = parseFloat($('#stock_red_' + chambre).text());
        var result = stock_red - 1;
        $('#stock_red_' + chambre).html(result);
        $('#resultstock_' + chambre).val(result);
      }
    })
    ooo();
    function ooo(){
      var id_clientCheck= $("#id_clientCheck").val();
  $('#checked_id_client_' + id_clientCheck).prop('checked', true);
    }

$(".checked_id_client").each(function() {
  var id_clientCheck= $("#id_clientCheck").val();
  $('#checked_id_client_' + id_clientCheck).prop('checked', true);
  if($('#checked_id_client_' + id_clientCheck).prop('checked', true)){
    $('#checked_id_client_' + id_clientCheck).prop('checked', true);
  }else{
    $('.checked_id_client').prop('checked', false);
  }
    })
    
    $(".div_R").each(function() {
      $('.div_R').hide();
    })
    $(".message_show").each(function() {
      $('.message_show').hide();
    })

    var qteM = 1;
    $(document).on('click', '.minus', function(e) {
      var chambre = $(this).data('id');
      var nb = parseFloat($('#qteA_' + chambre).val());
      $('#qteA_' + chambre).val(nb - qteM);
      if (nb <= 1) {
        $('#minus_' + chambre).prop('disabled', true);
        $('#reserver_' + chambre).prop('checked', false);
        $('#reserver_' + chambre).removeAttr('checked');
        $("[data-mode='" + chambre + "']").remove();
        var compte = $('#invoiceItem >tr').length;
        $('#compteur1').html(compte);
        if ($('#invoiceItem  tr').length < 1) {
          $('#btn_enreg').prop('disabled', true);
        }
      }
      var stock_red = parseFloat($('#stock_red_' + chambre).text());
      var result = stock_red + 1;
      $('#stock_red_' + chambre).html(result);
      $('#resultstock_' + chambre).val(result);
      $('.quantite_' + chambre).val($('#qteA_' + chambre).val());
      $('.quant_' + chambre).val($('#resultstock_' + chambre).val());
      $('#resultQte_' + chambre).html($('#qteA_' + chambre).val());
      calculateTotal();
      calculateRemise();
    })
    $(document).on('click', '.minusR', function(e) {
      var chambre = $(this).data('id');
      var nb = parseFloat($('#qteR_' + chambre).val());
      $('#qteR_' + chambre).val(nb - qteM);
      if (nb <= 1) {
        $('#minusR_' + chambre).prop('disabled', true);
      }
      $("#result_remise_" + chambre).html($('#qteR_' + chambre).val())
      $(".remiseegal_" + chambre).val($('#qteR_' + chambre).val())
      calculateTotal()
      calculateRemise()
    })
    $(".delR").hide()

    $(document).on('click', ".addR", function(e) {
      var chambre = $(this).data('id');
      $("#div_R_" + chambre).show(1000)
      $("#addR_" + chambre).hide()
      $("#delR_" + chambre).show()
    })
    $(document).on('click', ".delR", function(e) {
      var chambre = $(this).data('id');
      $("#div_R_" + chambre).hide(1000)
      $('#qteR_' + chambre).val(0);
      $("#addR_" + chambre).show()
      $("#delR_" + chambre).hide()
      $(".remiseegal_" + chambre).val(0)
      $("#result_remise_" + chambre).html("")

      calculateTotal()

    })
    $(document).on('click', ".plusR", function(e) {
      click1
      var chambre = $(this).data('id');
      $('#minusR_' + chambre).prop('disabled', false);
      if (!$('#qteR_' + chambre).val()) {
        $('#qteR_' + chambre).val(0);
      }
      var nb = parseFloat($('#qteR_' + chambre).val());
      $('#qteR_' + chambre).val(nb + qteA);
      $("#result_remise_" + chambre).html($('#qteR_' + chambre).val())
      $(".remiseegal_" + chambre).val($('#qteR_' + chambre).val())
      calculateTotal()
      calculateRemise()
    })
    var qteA = 1;
    var click1 = 0;
    $(document).on('click', ".plus", function(e) {
      click1
      var chambre = $(this).data('id');
      $('#minus_' + chambre).prop('disabled', false);
      if (!$('#qteA_' + chambre).val()) {
        $('#qteA_' + chambre).val(0);
      }
      var nb = parseFloat($('#qteA_' + chambre).val());
      $('#qteA_' + chambre).val(nb + qteA);
      var stock_red = parseFloat($('#stock_red_' + chambre).text());
      var result = stock_red - 1;
      $('#stock_red_' + chambre).html(result);
      $('#resultstock_' + chambre).val(result);
      $('.quantite_' + chambre).val($('#qteA_' + chambre).val());
      $('#resultQte_' + chambre).html($('#qteA_' + chambre).val());
      $('.quant_' + chambre).val($('#resultstock_' + chambre).val());

      calculateTotal();
      calculateRemise();
    })
    $(document).on('input', '.qteR', function(e) {
      var chambre = $(this).data('id');
      $(".remiseegal_" + chambre).val($('#qteR_' + chambre).val())
      $("#result_remise_" + chambre).html($('#qteR_' + chambre).val())
      calculateTotal()
      calculateRemise()
    })
    $(document).on('input', '.qteA', function(e) {
      var chambre = $(this).data('id');
     var ajout= parseFloat($('#qteA_' + chambre).val())
    var stock_red= parseFloat($('#stock_red_' + chambre).text())
    var stock_red1= parseFloat($('#stock_red1_' + chambre).text())
    var resultstock= parseFloat($('#resultstock_' + chambre).val())
    if ($('#qteA_' + chambre).val() <= 1) {
      $('#reserver_' + chambre).prop('checked', false);
        $("[data-mode='" + chambre + "']").remove();
        var compte = $('#invoiceItem >tr').length;
        $('#compteur1').html(compte);
        if ($('#invoiceItem  tr').length < 1) {
          $('#btn_enreg').prop('disabled', true);
        }
    }
    if (!isNaN(ajout)) {
      stock_red1 -= ajout;
      }
      $('#resultstock_' + chambre).val(stock_red1);
      $('#stock_red_' + chambre).text(stock_red1)
      $('.quantite_' + chambre).val($('#qteA_' + chambre).val());
      $('#resultQte_' + chambre).html($('#qteA_' + chambre).val());
      $('.quant_' + chambre).val($('#resultstock_' + chambre).val());
      calculateTotal();
      calculateRemise();
    })

    $(function() {
      function action(selectedEffect) {
        $("#compteur1").effect(selectedEffect, 300);
      };
      $(document).on('change', '.reserver', function(e) {
        action("bounce");
        return false;
      });
    });
    $('#paie').change(function() {
      if ($(this).prop('checked')) {
        $('#hidden_paie').val('1');
      } else {
        $('#hidden_paie').val('0');
      }
    });



    //SHOW HIDE DIVE
    $('#content2').hide();
    $('#imprimer').hide();
    $('#creer').hide();
    $('#stylereservation').hide();

    $('#calendrier').on('click', function() {
      $("#content2").show(1000);
      $("#content1").hide();
      $("#creer").hide();
      $('#imprimer').hide();

    });

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

    $('#retour_div').on('click', function() {
      $("#creer").hide();

      $('#content1').show(1000);
      $('#content2').hide();
    })


    $('#compteur').html(0);
    $('#compteur1').html(0);

    $('#panier').on('click', function() {
      $('#stylereservation').show(1000);
      $('#creer').show(1000);
      $('#content1').hide();
      $('#content2').hide();
    })
    $('#panier1').on('click', function() {
      $('#stylereservation').show(1000);
      $('#creer').show(1000);
      $('#content1').hide();

    })
    //FIN SHOW HIDE DIVE
    //FIN PAGINATION

    //FIN PAGINATION
    //FIN RECHERCHE
    $(document).ready(function() {

      $(document).on('input', '#data-filter1', function(e) {
        $.autofilter({
          duration: 300
        });
      });



      $(document).on('input', '#date2', function(e) {
        var date1 = new Date($("#date1").val());
        var date2 = new Date($("#date2").val());
        var Diff_temps = date2.getTime() - date1.getTime();
        var Diff_jours = Diff_temps / (1000 * 3600 * 24);
        if (date2 < date1) {
          $("#dateresult").val("Invalide");
        } else {
          $("#dateresult").val(Math.round(Diff_jours));
          calculateTotal();
        }
      });
    })


    //FIN RECHERCHE
    //CREER  RESERVATION
    $("#searchc").select2();
    $('.client').select2();
    $('#client').hide();
    $('#hrcache').hide();
    $(':input[type="submit"]').prop('disabled', true);

    $("#open").click(function() {
      $('#client').show(1000);
      $('#hrcache').show();
    });
    var count = $(".itemRow").length;
    var click = 0;
    $(document).on('change', '.reserver', function(e) {
      count++;
      var id_article = $(this).data('id');
      var qteA = $('#qteA_' + id_article).val();
      var qteR = $('#qteR_' + id_article).val();
      var prix_var = $('#prix_var_' + id_article).val();
      var resultstock = $('#resultstock_' + id_article).val();
      $('#message_show_' + id_article).html("Quantité requise *")
      if ($(this).is(":checked")) {
        if ($('#qteA_' + id_article).val() == 0) {
          $('#reserver_' + id_article).prop('checked', false);

          $('#message_show_' + id_article).show().delay(5000).hide(0);

        } else {
          $.ajax({
            url: "article/fetch_article",
            type: "post",
            data: {
              id_article: id_article
            },
            dataType: 'json',
            success: function(data) {
              var htmlRows = '';
              htmlRows += '<tr id="row' + count + '" class="itemRow" data-mode="' + id_article + '">';
              htmlRows += '<td style="display: none;" class="spot"><input type="text"  name="id_article[]" class="form-control form-control-sm prix" value="' + data.id_article + '" readonly required="required"></td>';
              htmlRows += '<td class="spot">' + data.imgInp1 + '&nbsp;&nbsp;&nbsp;' + data.description_article + '</td>';
              htmlRows += '<td style="padding-top:15px;display: none;" class="spot"><input type="text" name="prix[]"  class="form-control form-control-sm prix" value="' + prix_var.replace(/\s+/g, '') + '" id="prix_' + count + '"   required="required" readonly></td>';
              htmlRows += '<td style="padding-top:7px" class="spot"><div id="resultQte_' + id_article + '">' + qteA + '</div><input type="hidden" name="quantite[]"  class="form-control form-control-sm quantite_' + id_article + '" value="' + qteA + '" id="quantite_' + count + '" onKeyUp="calculateTotal()"  required="required" readonly></td>';
              htmlRows += '<td style="padding-top:15px;display: none;" class="spot"><input type="text" name="quant[]"  class="form-control form-control-sm quant_' + id_article + '" value="' + resultstock + '" id="quant_' + id_article + '"  required="required" readonly></td>';
              htmlRows += '<td style="padding-top:15px;display: none;"><input type="text" name="total[]" id="total_' + count + '"  class="form-control form-control-sm total" readonly required="required"></td>';
              htmlRows += '<td style="text-align:right;padding-top:7px;text-align:right;"><div id="result_remise_' + id_article + '">' + qteR + '</div><input type="hidden"  name="remise[]" id="remise_' + count + '" value="' + qteR + '" class="form-control form-control-sm remise rem remiseegal_' + id_article + '" autocomplete="off" onKeyUp="calculateRemise()" >' +
                '</td>';
              htmlRows += '<td style="display: none ;"><input type="text"  name="mt_remise[]" id="mt_remise_' + count + '" class="form-control form-control-sm mt_remise" autocomplete="off" readonly "></td>';
              htmlRows += '<td style="display: none;"><input type="text" name="tot[]" id="tot_' + count + '"  class="form-control form-control-sm tot" readonly ></td>';
              htmlRows += '</tr>';
              if ($('#invoiceItem > tr').length < 15) {
                $('#invoiceItem').append(htmlRows);
              } else {
                swal({
                  title: "Limite 15!",
                  text: "Le panier ne doit pas depasser 10 élément.",
                  type: "success",
                  confirmButtonText: 'Ok',
                  confirmButtonColor: '#3085d6',
                  showConfirmButton: true
                });
                $('#reserver_' + id_article).prop('checked', false);

              }
              calculateTotal();
              calculateRemise();
              var compte = $('#invoiceItem > tr').length;

              $('#compteur1').html(compte);

              $("#btn_enreg").prop("disabled", false)

            }

          });
        }


      } else {
        $("[data-mode='" + id_article + "']").remove();
        calculateTotal();
        var compte = $('#invoiceItem > tr').length;
        $('#compteur1').html(compte);
        $(function() {
          if ($('#invoiceItem  tr').length < 1) {
            $("#btn_enreg").prop("disabled", true)
          }
        })
      }
      calculateTotal();
    })
    $(document).on('input', '.prixmod', function(e) {
      var id = $(this).data('id');
      var input = $('.prixmod_' + id).val();;
      $('.remiseegal_' + id).val(input);
      $('#textremarque_' + id).html(input);
    });
    $(document).on('click', '.annuler_prix', function(e) {
      var id = $(this).data('id');
      $('#textremarque_' + id).html("");
      $('.remiseegal_' + id).val("");
      $('.prixmod_' + id).val("");
      calculateTotal();
    });
    $(document).on('click', '#btncalcul', function(e) {
      $('#modaltva').modal('show');
    })
    $(document).on('change', '.checked_id_client', function(e) {
      var checked_id_client = $(this).data('id');
      if ($('#checked_id_client_' + checked_id_client).is(':checked')) {
        $.ajax({
          url: "../fetch/fetch_client",
          type: "post",
          data: {
            checked_id_client: checked_id_client
          },
          dataType: 'json',
          success: function(data) {
            console.log(data);
            $('#id_clientCheck').val(data.id_client);
            $("#nom_client").val(data.nom_client);
            $("#telephonec").val(data.telephonec);
            $("#adresse").val(data.adresse);
            $("#emailc").val(data.emailc);
            $("#id_nom_client").html(data.nom_client);
            $("#id_phone_client").html(data.telephonec);
          }
        });
        $('.checked_id_client').prop('checked', false);
        $('#checked_id_client_' + checked_id_client).prop('checked', true);
      }
    })
    checked();

    function checked() {
      $("[id^='checkrow_']").each(function() {
        var chambre = $(this).data('id');
        var det = $('#sous_content1_' + chambre).detach();
        $('.conteneur').prepend(det);
        $('#qteA_' + chambre).val($('.egal_' + chambre).val())
        var stockred =parseFloat( $('#stock_red_' + chambre).text())
        var quantite= parseFloat( $('#qteA_' + chambre).val())
        var resultat= stockred + quantite
        $('#stock_red1_' + chambre).text(resultat)
        $('#qteR_' + chambre).val($('.remiseegal_' + chambre).val())
        $("#div_R_" + chambre).show()
        if ($('#qteA_' + chambre).val($('.egal_' + chambre).val()) <= 1) {

          $('#minus_' + chambre).prop('disabled', true);
          $('#minusR_' + chambre).prop('disabled', true);
        } else {
          $('#minus_' + chambre).prop('disabled', false);
          $('#minusR_' + chambre).prop('disabled', false);
        }
        if ($('#qteR_' + chambre).val() == 0) {
          $("#div_R_" + chambre).hide()
          $("#addR_" + chambre).show()
          $("#delR_" + chambre).hide()
        } else {
          $("#addR_" + chambre).hide()
          $("#delR_" + chambre).show()
        }
        $('#reserver_' + chambre).prop('checked', true);
      });
    }
    prix_variable();
function prix_variable(){
  $(".prix_var").each(function() {
        var id_article = $(this).data('id');
        var prix =$('#prix_' + id_article).val()
        $('#prix_var_' + id_article).val(Number(prix).toLocaleString('fi-FI'))
      
      });
}

    $(document).on('click', '#modclient', function(e) {
      $("#modalclientmodifier").modal("show");

      $("#nom_clientmm").val($("#nom_client").val());
      $("#telephonecmm").val($("#telephonec").val());
      $("#adressemm").val($("#adresse").val());
      $("#emailcmm").val($("#emailc").val());

    });
    $(document).on('click', '#modificlient', function(e) {
      $("#nom_client").val($("#nom_clientmm").val());
      $("#telephonec").val($("#telephonecmm").val());
      $("#adresse").val($("#adressemm").val());
      $("#emailc").val($("#emailcmm").val());
      $("#id_nom_client").html($("#nom_clientmm").val());
      $("#id_phone_client").html($("#telephonecmm").val());

    });
    $(document).on('click', '#listclient', function(e) {

      $("#ModalListeClient").modal("show");
    });

    $(document).on('click', '#codeqr', function(e) {
      $("#modalcodeqr").modal("show");

    });

    $(document).on('click', '#printbtn', function(e) {
      e.preventDefault();

      var facture = $(this).data('id');
      $('#view-modal').modal("show");
      $.ajax({
        url: "../fetch/fetch_facture",
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

    $(function() {
      $('#btn_print').on('click', function() {
        //Print ele2 with default options
        $("#dynamic-content").print();
      });
    });



    $("#del").click(function() {
      $('#client').hide(1000);
      $('#hrcache').hide();
    })
    $("#shared").click(function() {
      $('#content1').hide();
      $('#content2').show(1000);
    })
    $("#retourDiv").click(function() {
      $('#creer').show(1000);
    })

    $("#photo").change(function() {
      const file = this.files[0];
      if (file) {
        let reader = new FileReader();
        reader.onload = function(event) {
          $("#file-ip-1-preview").attr("src", event.target.result);
        };
        reader.readAsDataURL(file);
      }

    });

    function calculateTotal() {
      var totalAmount = 0;
      $("[id^='prix_']").each(function() {
        var id = $(this).attr('id');
        
        id = id.replace("prix_", '');
        var prix = $('#prix_' + id).val();
        var quantite = $('#quantite_' + id).val();
        if (!quantite) {
          quantite = 0;
        }
        var total = prix * quantite;
        $('#total_' + id).val(parseFloat(total));
        $('#tot_' + id).val(parseFloat(total));
        totalAmount += total;
      });
      var sum = 0;
      $(".tot").each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
          sum += parseFloat(this.value);
        }
      });
      $("#mt_ht").val(sum);
      $("#mt_ttc").val(sum);
      $("#div_mt_ht").html(Number(sum).toLocaleString('fi-FI'));
      $("#div_mt_ttc").html(Number(sum).toLocaleString('fi-FI'));

    }

    function calculateRemise() {
      var totalAmount = 0;
      $("[id^='remise_']").each(function() {
        var id = $(this).attr('id');
        id = id.replace("remise_", '');
        var remise = $('#remise_' + id).val();
        var total = $('#total_' + id).val();
        if (!total) {
          total_remise = 1;
        }
        var total_remise = total * remise / 100;
        $('#mt_remise_' + id).val(parseFloat(total_remise));
        totalAmount += total;
        calculateREMISE_Total();
      });

    }

    function calculateRemise() {
      var totalAmount = 0;
      $("[id^='remise_']").each(function() {
        var id = $(this).attr('id');
        id = id.replace("remise_", '');
        var remise = $('#remise_' + id).val();
        var total = $('#total_' + id).val();
        if (!total) {
          total_remise = 1;
        }
        var total_remise = total * remise / 100;
        $('#mt_remise_' + id).val(parseFloat(total_remise));
        totalAmount += total;
        calculateREMISE_Total();
      });

    }

    function calculateREMISE_Total() {
      var totalAmount = 0;
      $("[id^='total_']").each(function() {
        var id = $(this).attr('id');
        id = id.replace("total_", '');
        var total = $('#total_' + id).val();
        var mt_remise = $('#mt_remise_' + id).val();
        if (!mt_remise) {
          mt_remise = 1;
        }
        var grand_total = total - mt_remise;
        $('#tot_' + id).val(parseFloat(grand_total));
        totalAmount += grand_total;
      });
      var sum = 0;
      $(".tot").each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
          sum += parseFloat(this.value);
        }
      });
      $('#mt_ht').val(sum);
      $('#mt_ttc').val(sum);
      $("#div_mt_ht").html(Number(sum).toLocaleString('fi-FI'));
      $("#div_mt_ttc").html(Number(sum).toLocaleString('fi-FI'));
    }

    function keytva() {
      var taxRate = $("#tva").val();
      var subTotal = $('#mt_ht').val();
      $("#div_tva").html(taxRate);

      if (subTotal) {
        var taxAmount = subTotal * taxRate / 100;
        $('#mt_tva').val(taxAmount);
        $("#div_mt_tva").html(Number(taxAmount).toLocaleString('fi-FI'));
        subTotal = parseFloat(subTotal) + parseFloat(taxAmount);
        $('#mt_ttc').val(subTotal);
        $("#div_mt_ttc").html(Number(subTotal).toLocaleString('fi-FI'));
        var amountPaid = $('#amountPaid').val();
        var totalAftertax = $('#totalAftertax').val();
        if (amountPaid && totalAftertax) {
          totalAftertax = totalAftertax - amountPaid;
          $('#mt_ttc').val(totalAftertax);
        } else {
          $('#mt_ttc').val(subTotal);
        }
      }
    }
    $(document).on('input', '#tarif', function(e) {
      $("#div_tarif").html(Number($("#tarif").val()).toLocaleString('fi-FI'))
      if ($("#tarif").val() == "") {
        $("#div_tarif").html("-----")
      }
    })
    $(document).on('input', '#zone', function(e) {
      $("#div_zone").html($("#zone").val())
      if ($("#zone").val() == "") {
        $("#div_zone").html("-----")
      }
    })
    $(document).on('input', '#montant', function(e) {
      $("#div_montant").html(Number($("#montant").val()).toLocaleString('fi-FI'))
      if ($("#montant").val() == "") {
        $("#div_montant").html("-----")
      }
    })
    $(document).on('input', '#description', function(e) {
      $("#div_description").html($("#description").val())
    })
    $(document).on('input', '#mode', function(e) {
      $("#div_mode").html($("#mode").val())
      if ($("#mode").val() == "") {
        $("#div_mode").html("-----")
      }
    })

    $(document).on('input', '#avoir', function(e) {
      var avoir = parseFloat($("#avoir").val());
      var result = parseFloat($('#espece_rendu1').val());
      var imp = result - avoir;
      $('#espece_rendu').val(imp)
      $("#div_espece_rendu").html(Number(imp).toLocaleString('fi-FI'))
      $("#div_avoir").html(Number($("#avoir").val()).toLocaleString('fi-FI'))
      if ($("#avoir").val() == "") {
        $("#div_avoir").html("-----")
        $('#espece_rendu').val($('#espece_rendu1').val());
        $("#div_espece_rendu").html(Number(result).toLocaleString('fi-FI'))
      }
    })

    function monnaie() {
      var espece_du = $("#espece_du").val();
      $("#div_espece_du").html(Number(espece_du).toLocaleString('fi-FI'))
      var mt_ttc = $('#mt_ttc').val();
      if (espece_du) {
        subTotal = parseFloat(espece_du) - parseFloat(mt_ttc);
        $('#espece_rendu').val(subTotal);
        $('#espece_rendu1').val(subTotal);
        $("#div_espece_rendu").html(Number(subTotal).toLocaleString('fi-FI'))

      } else {
        $('#espece_rendu').val("");
        $('#espece_rendu').val("");
        $('#espece_rendu1').val("");
        if ($("#espece_rendu").val() == "") {
          $("#div_espece_rendu").html("-----")
        }
        if ($("#espece_du").val() == "") {
          $("#div_espece_du").html("-----")
        }
      }
    }
    //FIN CREER RESERVATION
  </script>
  </script>
  <script type="text/javascript">
    $(function() {
      $("#btnPrint").click(function() {
        var contents = $("#dvContents").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({
          "position": "absolute",
          "top": "-1000000px"
        });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>DIV Contents</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function() {
          window.frames["frame1"].focus();
          window.frames["frame1"].print();
          frame1.remove();
        }, 500);
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        "bLengthChange": false,
        "bAutoWidth": false,
        "info": false,

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
          "sSearch": " ",
          "searchPlaceholder": "Rechercher...",
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
    let scanner = new Instascan.Scanner({
      video: document.getElementById('preview')
    });
    $(document).on('click', '#actived', function(e) {
      Instascan.Camera.getCameras().then(function(cameras) {

        if (cameras.length > 0) {

          scanner.start(cameras[0]);

          $('[name="options"]').on('change', function() {

            if ($(this).val() == 1) {

              if (cameras[0] != "") {

                scanner.start(cameras[0]);

              } else {

                alert('Aucune caméra frontale trouvée!');

              }

            } else if ($(this).val() == 2) {

              if (cameras[1] != "") {

                scanner.start(cameras[1]);

              } else {

                alert('Aucune caméra arrière trouvée!');

              }

            }

          });

        } else {

          console.error('Aucune caméra trouvée.');

          alert('Aucune caméra trouvée.');

        }

      }).catch(function(e) {

        console.error(e);

        alert(e);

      });
    })
    $('#desactived').hide()
    $('#camera1').hide()
    $('#camera2').hide()

    $(document).on('click', '#desactived', function(e) {
      Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
          scanner.stop(cameras[0]);
          const canvas = document.getElementById("canvas");
          const ctx = canvas.getContext("2d");

          const image = new Image(0, 0); // Using optional size for image
          image.onload = drawImageActualSize; // Draw when image has loaded

          // Load an image of intrinsic size 300x227 in CSS pixels
          image.src = "../img/logo/video.png";

          function drawImageActualSize() {
            // Use the intrinsic size of image in CSS pixels for the canvas element
            canvas.width = 300;
            canvas.height = 200;

            // Will draw the image as 300x227, ignoring the custom size of 60x45
            // given in the constructor

            // To use the custom size we'll have to specify the scale parameters
            // using the element's width and height properties - lets draw one
            // on top in the corner:
            ctx.drawImage(this, 80, 20, 150, 150);
          }
          $('#desactived').hide()
          $('#camera1').hide()
          $('#camera2').hide()
          $('#actived').show()
          $("#sms").html("<div style='color: #d9534f'>Veillez activer le camera</div>");

        } else {
          alert("camera no trouver")
          scanner.stop(cameras[1]);

        }
      }).catch(function(e) {
        console.error(e);
      });

    })
    scanner.addListener('scan', function(c) {
      document.getElementById('sowcode').value = c;
      showCode()
    })

    function showCode() {
      var id_client_valide = $("#sowcode").val();
      if ($("#sowcode").val()) {
        playAudio();
        scanner.stop()
      }
      $('#view-modal').modal("show");
      $.ajax({
        url: "valide_carte/fetch_valide_carte",
        type: "post",
        data: {
          id_client_valide: id_client_valide
        },
        dataType: 'json',
        success: function(data) {
          console.log(data);
          $('#id_clientCheck').val(data.id_client);
          $('#id_nom_client').html(data.nom_client);
          $('#id_phone_client').html(data.telephonec);
          $('#smsnom').html(data.nom_client);
          $('#smspoint').html(data.point);
          $('#smsEX').html(data.datefins);
        }
      });
    }

    $("#canvas").hide();
    $("#sms").html("<div style='color: #d9534f'>Veillez activer le camera</div>");

    $(function() {
      var canvas = document.getElementById('canvas');
      var ctx = canvas.getContext('2d');
      var video = document.getElementById('preview');

      video.addEventListener('play', function() {
        var $this = this; //cache
        (function loop() {
          if (!$this.paused && !$this.ended) {
            $("#canvas").show();
            $("#divcanvas").hide();

            ctx.drawImage($this, 0, 0);
            setTimeout(loop, 1000 / 30); // drawing at 30fps
            ctx.globalAlpha = 0.5;

            ctx.strokeStyle = "rgb(120, 120, 120)";
            ctx.beginPath();
            ctx.roundRect(0, 0, 300, 200);
            ctx.lineWidth = 70;
            ctx.stroke();
          }
        })();
      }, 0);
    });

    function playAudio() {
      var x = document.getElementById("myAudio2");
      x.play();
    }
    promotion();

    function promotion() {
      $("[id^='tab_id_article_promo_']").each(function() {
        var id_promotionV = $(this).data('id');
        if ($("#descpromotion_" + id_promotionV).html() == "") {
          $("#promotion_" + id_promotionV).hide();
          $("#descpromotion_" + id_promotionV).hide()
        } else {
          $("#promotion_" + id_promotionV).show();
          $("#descpromotion_" + id_promotionV).html("<span> Remise </span><span style='color:red;font-size:13px;'> " + $("#tab_reduction_promo_" + id_promotionV).val() + " %</span>" + " " + "<span style='font-size:14px;'>" + $("#tab_conditions_promo_" + id_promotionV).val() + "</span>");

        }
      })
    }
    $(".closepromotion").hide()
    $(document).on('click', '.showpromotion', function(e) {
      var id = $(this).data('id');
      $('#descpromotion_' + id).show(1000);
      $("#closepromotion_" + id).show()
      $("#showpromotion_" + id).hide()
    });

    $(document).on('click', '.closepromotion', function(e) {
      var id = $(this).data('id');
      $('#descpromotion_' + id).hide(1000);
      $("#closepromotion_" + id).hide()
      $("#showpromotion_" + id).show()
    });
  </script>
  <script>
        var scrolled = 0;
    if (annyang) {
      annyang.setLanguage('fr-FR');
      // Let's define our first command. First the text we expect, and then the function it should call
      var commands = {
        'non client': function() {
          $("#nom_clientmm").focus();
        },
        'téléphone': function() {
          $("#telephonecmm").focus()
        },
        'adresse': function() {
          $("#adressemm").focus()
        },
        'email': function() {
          $("#emailcmm").focus()
        },
        'acompte': function() {
          $("#montant").focus()
        },
        'zone de livraison': function() {
          $("#zone").focus()
        },
        'tarif': function() {
          $("#tarif").focus()
        },
        'espèce': function() {
          $("#espece_du").focus()
        },
        'avoir': function() {
          $("#avoir").focus()
        },
        'mode paiement': function() {
          $("#mode").focus()
        },
        'tva': function() {
          $("#tva").focus()
        },
        'remarque': function() {
          $("#description").focus()
        },
        'quantité *tag': function(a) {
          var id = $("#id_article_vente").val();
          $('#qteA_' + id).val(a);
          $('#qteA_' + id).focus()
          var currency = $('#qteA_' + id).val().toLowerCase().replace(/,/g, ''); // exclude commas
          if (currency) {
            $('#qteA_' + id).keyup();
          }
          if ($('#qteA_' + id).val() < 1) {

            $('#stock_red_' + id).html($('#stock_red1_' + id).html());
            $('#resultstock_' + id).val($('#stock_red1_' + id).html());
            $('.quant_' + id).val($('#resultstock1_' + id).val());

          } else {
            $('#stock_red_' + id).html($('#stock_red1_' + id).html());
            var stock_red = parseFloat($('#stock_red_' + id).text());
            var result = stock_red - $('#qteA_' + id).val();
            $('#stock_red_' + id).html(result);
            $('#resultstock_' + id).val(result);
            $('.quantite_' + id).val($('#qteA_' + id).val());
            $('#resultQte_' + id).html($('#qteA_' + id).val());
            $('.quant_' + id).val($('#resultstock_' + id).val());

            calculateTotal();
            calculateRemise();
          }
        },
        'retirer la quantité': function() {
          var id = $("#id_article_vente").val();
          $('#qteA_' + id).val(0);
          $('#qteA_' + id).blur()
          $('#stock_red_' + id).html($('#stock_red1_' + id).html());
          if ($('#qteA_' + id).val(0)) {
            $('#reserver_' + id).prop("checked", false)
            $("[data-mode='" + id + "']").remove();
            calculateTotal();
            var compte = $('#invoiceItem > tr').length;
            $('#compteur1').html(compte);
            if($('#invoiceItem > tr').length<1){
          $('#btn_enreg').prop('disabled', true);
}
          }
        },
        'ajouter la remise': function(a) {
          var id = $("#id_article_vente").val();
          $('#addR_' + id).click()
          $('#qteR_' + id).focus()
        },
        'retirer la remise': function(a) {
          var id = $("#id_article_vente").val();
          $('#delR_' + id).click()
          $('#qteR_' + id).blur()
        },
        'remise *tag': function(a) {
          var id = $("#id_article_vente").val();
          $('#qteR_' + id).val(a);
          $('#qteR_' + id).focus()
          var currency = $('#qteR_' + id).val().toLowerCase().replace(/,/g, ''); // exclude commas
          if (currency) {
            $('#qteR_' + id).keyup();
          }
          $(".remiseegal_" + id).val($('#qteR_' + id).val())
          $("#result_remise_" + id).html($('#qteR_' + id).val())
          calculateTotal()
          calculateRemise()
        },
        'panier': function() {
          var id_article = $("#id_article_vente").val();
          $('#reserver_' + id_article).click();

        },
        'afficher la promotion': function() {
          var id_article = $("#id_article_vente").val();
          $('#showpromotion_' + id_article).click();

        },
        'fermer la promotion': function() {
          var id_article = $("#id_article_vente").val();
          $('#closepromotion_' + id_article).click();

        },
        'retirer': function() {
          var id_article = $("#id_article_vente").val();
          $('#reserver_' + id_article).prop("checked", false)
          $("[data-mode='" + id_article + "']").remove();
          calculateTotal();
          var compte = $('#invoiceItem > tr').length;
          $('#compteur1').html(compte);
          if($('#invoiceItem > tr').length<1){
          $('#btn_enreg').prop('disabled', true);
        }
        },
        'chariot': function() {
          $("#exampleModalScrollable").modal('show')

        },
        'fermer': function() {
          $("#exampleModalScrollable").modal('hide')
          $(".fab-hide").hide()
          $(".fab-button").show()
          $(".fab-show").hide()
          $("#modalcodeqr").modal('hide')
          $("#ModalListeClient").modal('hide')
          $("#modaltva").modal('hide')
          $("#modalclientmodifier").modal('hide')

        },
        'paramètre client': function() {
          $(".fab-show").show()
          $(".fab-hide").show()
          $(".fab-button").hide()
        },
        'modifier client': function() {
          $("#modclient").click()
        },
        'code': function() {
          $("#modalcodeqr").modal('show')

        },
        'total': function() {
          $("#modaltva").modal('show')

        },
        'liste client': function() {
          $("#ModalListeClient").modal('show')
        },
        'ajouter': function() {
          $("#modificlient").click()
        },
       
        'caméra': function() {
          $("#actived").click()
          $('#reserver_' + id_article).prop('checked', false);

        },
        'page suivante':function(){
$("#example_next a").click()
        },
        'page précédente':function(){
          $("#example_previous a").click()

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
        'actualiser': function(variable) {
          $("#exampleModalScrollable").modal('hide')
          $(".fab-hide").hide()
          $(".fab-button").show()
          $(".fab-show").hide()
          $("#modalcodeqr").modal('hide')
          $("#ModalListeClient").modal('hide')
          $("#modaltva").modal('hide')
          $("#modalclientmodifier").modal('hide')
          $('#vocal').modal('show');
          setTimeout(function() {
            console.log('completed');
            $('#vocal').modal('hide');
            window.location.href = "modifier_vente?mail=<?php echo  $mail; ?>&edit_id=<?php echo  $_GET['edit_id']; ?> &id=<?php echo  $id_b; ?>";

          }, 1000);
        },
        'modifier': function() {
          $("#btn_enreg").prop("disabled", false)
          if ($('#invoiceItem > tr').length < 1) {
            $('#exampleModalScrollable').modal("hide");
            swal({
              title: "Panier vide!",
              text: "Enregistrement ne peut pas etre effectué.",
              type: "error",
              showConfirmButton: false,
              timer: 2000
            });
          } else {
            $("#btn_enreg").click()
          }
        },
        'arrêter la recherche': function(variables) {
          $("#produit").val("");
          $("#categorie").val("");
          if ($("#produit").val(variables)) {
            $(".produit").keyup();
          } else if ($("#categorie").val(variables)) {
            $(".categorie").keyup();
          }
        },
        'catégorie *tag': function(variable) {
          let task_name = document.getElementById("categorie");
          task_name.value = variable;
          var currency = $('#categorie').val().toLowerCase().replace(/,/g, ''); // exclude commas
          if (currency) {
            $(".categorie").keyup();
          }

        },
        'article *tag': function(variable) {
          let task_name = document.getElementById("produit");
          task_name.value = variable;
          var currency = $('#produit').val().toLowerCase().replace(/,/g, ''); // exclude commas
          if (currency) {
            $(".produit").keyup();
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
              $("#id_article_vente").val(data.id_article);

            }
          });
        }
      }


      // Add our commands to annyang
      annyang.addCommands(commands);

      // Start listening. You can call this here, or attach this call to an event, button, etc.
      annyang.start();
    }
  </script>
  <!---Container Fluid-->
<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
  header("Location:../");
}
?>