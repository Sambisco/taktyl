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
    .plus {
      width: 20px;
      background: #0275d8;
      border-radius: 4px;
      border: 0px solid #ddd;
      display: inline-block;
      vertical-align: middle;
      text-align: center;
      color: #fff;
    }

    .qteA {
      width: 50px;
      font-size: 14px;
      text-align: center;
      border: 1px solid #ddd;
      border-radius: 4px;
      display: inline-block;
      vertical-align: middle;
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
            <h3 class="h3 mb-0 text-gray-800">Modifier reception commande</h3>
          </div>
          <div style="float: right;position: fixed;right: 10px;z-index: 1;top: 100px;">
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
            <input type="hidden" id="numv">
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
                  <li><span data-number="10" > 10 par page </span></li>
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

                <input data-path=".title" type="text" class="categorie" id="categorie" value="" placeholder="Catégorie..." data-control-type="textbox" data-control-name="title-filter" data-control-action="filter" style="width: 230px;" />
              </div>

              <!-- filter by description -->
              <div class="text-filter-box">

                <i class="fa fa-search  jplist-icon" style="background-color: #0275d8; color: #fff;"></i>

                <!--[if lt IE 10]>
                    <div class="jplist-label">Filter by Description:</div>
                    <![endif]-->

                <input data-path=".desc" type="text" class="produit" id="produit" value="" placeholder="Article..." data-control-type="textbox" data-control-name="desc-filter" data-control-action="filter" style="width: 230px;" />
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
                    if ($row['qte'] < $row['stock_ini']) {
                ?>

                        <li>
                          <span data-control-type="button-filter" data-control-action="filter" data-control-name="<?php echo $row["id_categorie_stock"]; ?>" data-path=".<?php echo $row["id_categorie_stock"]; ?>" data-selected="false">
                            <i class="fa fa-caret-right"></i>
                            <?php echo $row["categorie_stock"]; ?>
                          </span>

                        <li>
                    <?php
                    }
                  }
                }
                    ?>
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
                $edit_id = $_GET["edit_id"];
                $query = "SELECT *  FROM detail_reception 
                INNER JOIN reception ON reception.id_reception=detail_reception.id_reception
                INNER JOIN commande ON commande.id_commande=reception.id_commande 
                INNER JOIN article ON article.id_article=detail_reception.id_article 
                INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
                 INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
                 INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
           WHERE reception.id_reception='$edit_id' ORDER BY article.id_article DESC";
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
                                <img src="../img/img/image.jpg" class="img-thumbnail img-thumbnail-mobile" style="height: 100px;width: 100%;" alt="icons8-team-100" id="image_<?php echo $count; ?>">
                              <?php } else { ?>
                                <img src="<?php echo $row['imgInp']; ?>" class="img-thumbnail img-thumbnail-mobile" style="height: 100px;width: 100%;" alt="icons8-team-100" id="image_<?php echo $count; ?>">
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
                            <div class="title paragraph" style="color: #0275d8;margin-top: -2px;font-size: 14px;"> <?php echo $row["categorie_stock"]; ?></div>
                            <div class="desc paragraph" style="margin-top: -5px;font-size: 14px;"> <?php echo $row["description_article"]; ?></div>
                            <div style="margin-top:-30px;margin-bottom: 5px;z-index: -999;display: none;width: 100%;" id="prx_div_<?php echo $row['id_article']; ?>">
                              <div class="input-group">
                                <input type="text" class="form-control form-control-sm prixmod" name="" placeholder="Prix" id="prixmod_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>" placeholder="Prix" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);" style="border-color: #3f51b5;">
                              </div>
                            </div>
                            <div class="desc paragraph" style="margin-top: -5px;font-size: 14px;">
                              <div id=prix_result_<?php echo $row['id_article']; ?> style="display: inline-block;font-size: 13px;"> <?php echo number_format($row['prix_a'], 0, ",", " "); ?></div>
                              <div class="addprix" style="display: inline-block;margin-left: 5px;font-size: 14px;" id="addprix_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">
                                <i class="fa fa-edit" style="color: #0275d8;cursor: pointer;"></i>
                              </div>
                              <input type="hidden" name="prix1[]" class="form-control form-control-sm prix1 prixegal1_<?php echo $row['id_article']; ?>" value="<?php echo $row['prix_a']; ?>" id="prix1_<?php echo $count; ?>" data-id="<?php echo $row['id_article']; ?>" onKeyUp="calculateTotal()" required="required" readonly>
                              <input type="hidden" name="prix[]" class="form-control form-control-sm prix prixegal_<?php echo $row['id_article']; ?>" value="<?php echo $row['prix_a']; ?>" id="prix_<?php echo $count; ?>" data-id="<?php echo $row['id_article']; ?>" onKeyUp="calculateTotal()" required="required" readonly>

                            </div>
                            <div class="paragraph" style="margin-top: -5px;font-size: 14px;">
                              <span>Stock :</span>&nbsp;
                              <span style="color: blue; font-weight: bold;font-size: 13px;" id="stock_red_<?php echo $row['id_article']; ?>">
                                <?php echo $row["qte"]; ?>
                              </span>
                            </div>
                            <div style="margin-top:-50px;margin-bottom: 5px;z-index: -999;display: none;width: 100%;" id="prx_remarq_<?php echo $row['id_article']; ?>">
                              <div class="input-group">
                              <textarea name="" class="form-control form-control-sm bg-light border-1 small remarq" placeholder="Remarque..." aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;" id="remarq_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>"></textarea>
                              </div>
                            </div>
                            <div class="desc paragraph" style="margin-top: -5px;font-size: 14px;">
                              <div style="display: inline-block;font-size: 14px;"> Remarque</div>
                              <div class="addremarque" style="display: inline-block;margin-left: 5px;font-size: 14px;" id="addremarque_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">
                                <i class="fa fa-edit" style="color: #0275d8;cursor: pointer;"></i>
                              </div>

                            </div>
                              <div style="margin-top: -5px;width: 70px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;font-size: 14px;" id="text_remarque_<?php echo $row['id_article']; ?>"><?php echo $row['descript']; ?></div>
                            <div class="theme paragraph">
                              <span class="<?php echo $row["id_categorie_stock"]; ?> paragraph"></span>
                            </div>
                            <div class="number" style="margin-top: 5px;">
                              <button class="minus" id="minus_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">-</button>
                              <input type="text" class="qteA" id="qteA_<?php echo $row['id_article']; ?>" style="text-align: center;" data-id="<?php echo $row['id_article']; ?>" />
                              <button class="plus" id="plus_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>">+</button>
                            </div>
                            <div class="message_show" id="message_show_<?php echo $row['id_article']; ?>" style="font-size:11px ; color: red;"></div>
                            <label class="toggle" style="margin-top: 7px;">
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


      <!-- Modal Scrollable -->
      <form id="invoice_form" enctype="multipart/form-data">
        <?php
        $edit_id = $_GET["edit_id"];
        $query = "SELECT *,reception.date AS dater  FROM detail_reception 
      INNER JOIN reception ON reception.id_reception=detail_reception.id_reception
      INNER JOIN commande ON commande.id_commande=reception.id_commande 
      INNER JOIN article ON article.id_article=detail_reception.id_article 
      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
       INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
       INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
 WHERE reception.id_reception='$edit_id'";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $total_row = $statement->rowCount();
        if ($total_row > 0) {
          foreach ($result as $row) {
          }
        ?>
          <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable  " role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalScrollableTitle">Panier commande 00<?php echo $row["num"]; ?></h5>
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
                          <input type="hidden" name="num" id="" value="<?php echo $row['id_commande']  ?>">
                          <input type="hidden" name="id_reception" id="" value="<?php echo $row['id_reception']  ?>">
                          <input type="datetime-local" id="date1" name="date" class="form-control form-control-sm" value="<?php echo $row['dater'] ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="info_four" style="text-align: center;font-size: 14px; color: #d9534f;"></div>
                  <div class="form-row">
                    <div class="form-group col-md-6" style="display: flex;">
                      <i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
                      <input type="hidden" name="idfournisseur" id="id_clientCheck" value="<?php echo $row["idfournisseur"]; ?>">
                      <div id="id_nom_client" style="margin-left: 5px;margin-right: 10px; font-size: 13px;padding-top: 10px;">
                        <?php echo $row["nomfour"]; ?>
                      </div>
                    </div>
                    <div class="form-group col-md-6" style="display: flex;font-size: 13px;">
                      <span class='fa-stack fa-lg'>
                        <i class='fas fa-circle fa-stack-2x'></i>
                        <i class='fas fa-phone fa-stack-1x fa-inverse'></i>
                      </span>
                      <div id="id_phone_client" style="margin-left: 10px;padding-top: 10px;">
                        <?php echo $row["telephonefour"]; ?>
                      </div>
                    </div>

                  </div>

                  <hr style="margin-bottom: 5px; margin-top: -10px;">

                  <hr style="margin-top: 1px; border: 0;">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center table-flush table-hover table-bordered table-sm" width="100%">
                      <tr>
                        <th style="display: none;">ID</th>
                        <th style="width: 190px;">ARTICLE</th>
                        <th style="width: 80px;">Prix</th>
                        <th style="width: 40px;">QTE</th>
                        <th style="width: 60px;text-align: right;">Rem...</th>
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
                            <td style="padding-top:5px" class="spot">
                              <div id="prixtab_<?php echo $row['id_article']; ?>"><?php echo number_format($row['prix_a'], 0, ",", " "); ?></div>
                              <input type="hidden" name="prix_a[]" class="form-control form-control-sm prix prixegal_<?php echo $row['id_article']; ?>" value="<?php echo $row['prix_a']; ?>" id="prix_<?php echo $row['id_article']; ?>" onKeyUp="calculateTotal()" required="required" readonly><input type="hidden" name="prix1[]" class="form-control form-control-sm prix1 prixegal1_<?php echo $row['id_article']; ?>" value="<?php echo $row['prix_a']; ?>" id="prix1_<?php echo $row['id_article']; ?>" data-id="<?php echo $row['id_article']; ?>" required="required" readonly>
                            </td>
                            <td style="padding-top:5px" class="spot">
                              <div id="resultQte_<?php echo $row['id_article']; ?>"><?php echo $row['quantite']; ?></div><input type="hidden" name="quantite[]" class="form-control form-control-sm quantite egal_<?php echo $row['id_article']; ?>" value="<?php echo $row['quantite']; ?>" id="quantite_<?php echo $count; ?>" data-id="<?php echo $row['id_article']; ?>" required="required" readonly>
                            </td>
                            <td style="padding-top:5px;text-align: right;" class="spot">
                              <input type="hidden" name="descript[]" id="descript_<?php echo $row['id_article']; ?>" value="<?php echo $row['descript']; ?>">
                              <div id="descript1_<?php echo $row['id_article']; ?>" style="width: 70px;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo $row['descript']; ?></div>
                            </td>
                            <td style="display: none;">
                              <label class="toggle">
                                <input type="checkbox" class="checkrow  egal_<?php echo $row['id_article']; ?>" id="checkrow_" checked=" <?php echo $row["id_article"]; ?>checked" data-id="<?php echo $row['id_article']; ?>">
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

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Observation:</label>
                      <textarea name="descriptionr" id="ob1" cols="" rows="" class="form-control" style="text-align: left;"><?php echo $row["descriptionr"]; ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" name="updatetdata" class="btn btn-primary" id="btn_enreg">Modifier</button>
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                </div>

              </div>
            </div>
          </div>
    </div>
  <?php } ?>
  </form>

  <!-- Modal Scrollable -->
  <!------FORMULAIRE AJOUT CLIENT------->
  <div class="modal fade" id="modalclient" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Remarque !</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="">Nom client</label>
            <input type="text" id="nom_clientm" class="form-control form-control-sm" placeholder="Nom client" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" name="deletedata" class="btn btn-primary" data-dismiss="modal" id="addclient">Remarque</button>
        </div>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE AJOUT CLIENT------->
  <!------FORMULAIRE MODIFIER CLIENT------->
  <div class="modal fade" id="modalclientmodifier" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Modifier client !</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
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
          <button type="button" name="deletedata" class="btn btn-primary" data-dismiss="modal" id="modificlient">Modifier</button>


        </div>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE MODIFIER CLIENT------->
  <!------FORMULAIRE LIST CLIENT------->
  <?php

  $query = "SELECT  * FROM fournisseur
  INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
  WHERE boutique.id_boutique='$id'";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  ?>
  <div class="modal fade" id="ModalListeClient" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Fournisseur !</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
        <div class="modal-body">
          <div class="table-responsive p-0">
            <table id="example" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" data-order='[[0,"desc"]]'>
              <thead>
                <tr>
                  <th style="width: 300px;">Nom </th>
                  <th style="width: 150px;">Telephone</th>
                  <th style="width: 100px;">Actions</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nom </th>
                  <th>Telephone</th>
                  <th>Actions</th>
                </tr>
              </tfoot>
              <tbody class="tbody_m">
                <?php foreach ($result as $row) {
                ?>
                  <tr>
                    <td><?php echo $row["nomfour"]; ?></td>
                    <td><?php echo $row["telephonefour"]; ?></td>
                    <td>
                      <label class="toggle" style="margin-top: 0px;">
                        <input type="checkbox" class="checked_id_client" id="checked_id_client_<?php echo $row['idfournisseur']; ?>" data-id="<?php echo $row['idfournisseur']; ?>">
                        <span class="slider"></span>
                        <span class="labels" data-on="Annuler" data-off="Achat"></span>
                      </label>
                    </td>
                  </tr>
                <?php
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
      var id_clientCheck = $("#id_clientCheck").val();

      $("#btn_enreg").prop("disabled", true)
      var form_data = $("#invoice_form").serialize();
      $.ajax({
        url: "reception/update",
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
        window.location.href = "../page/reception?mail=<?php echo  $mail; ?>&id=<?php echo  $id_b; ?>";
      });

    })
    $('document').ready(function() {

      $('#demo').jplist({
        itemsBox: '.list',
        itemPath: '.list-item',
        panelPath: '.jplist-panel'
        //,debug: true
      });
    });
    $(function() {
      var compte = $('#invoiceItem >tr').length;
      $('#compteur1').html(compte);
      $(':input[type="submit"]').prop('disabled', false);
    })
  </script>
  <script>
    $(".minus").each(function() {
      var chambre = $(this).data('id');
      $('#minus_' + chambre).prop('disabled', true);

    })
    $(".qteA").each(function() {
      var chambre = $(this).data('id');
      $('.qteA').attr('value', 0);
      if ($('#qteA_' + chambre).val() == 1) {
        var stock_red = parseFloat($('#stock_red_' + chambre).text());
        var result = stock_red - 1;
        $('#stock_red_' + chambre).html(result);
        $('#resultstock_' + chambre).val(result);
      }
    })


    $(".stock_red1").each(function() {
      $('.stock_red1').hide();
    })

    $(".message_show").each(function() {
      $('.message_show').hide();
    })

    $(document).on('click', '.addprix', function(e) {
        var id = $(this).data('id');
        $('#prx_div_' + id).toggle('slow');
      });

      $(document).on('click', '.addremarque', function(e) {
        var id = $(this).data('id');
        $('#prx_remarq_' + id).toggle('slow');
      });

    var qteM = 1;
    $(document).on('click', '.minus', function(e) {
      var chambre = $(this).data('id');

      var nb = parseFloat($('#qteA_' + chambre).val());


      $('#qteA_' + chambre).val(nb - qteM);
      $('.egal_' + chambre).val($('#qteA_' + chambre).val());
      $('#resultQte_' + chambre).html($('#qteA_' + chambre).val());

      if (nb <= 1) {
        $('#minus_' + chambre).prop('disabled', true);
        $('#reserver_' + chambre).prop('checked', false);
        $('#reserver_' + chambre).removeAttr('checked');
        $("[data-mode='" + chambre + "']").remove();
        calculateTotal();
        var compte = $('#invoiceItem >tr').length;
        $('#compteur1').html(compte);
        if($('#invoiceItem > tr').length<1){
          $('#btn_enreg').prop('disabled', true);
}
      }
      var stock_red = parseFloat($('#stock_red_' + chambre).text());
      var result = stock_red + 1;

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
      $('.egal_' + chambre).val($('#qteA_' + chambre).val());
      $('#resultQte_' + chambre).html($('#qteA_' + chambre).val());

    })

    $(document).on('input', '.qteA', function(e) {
      var chambre = $(this).data('id');
      if ($('#qteA_' + chambre).val() <= 1) {

        $('#stock_red_' + chambre).html($('#stock_red1_' + chambre).html());
        $('#resultstock_' + chambre).val($('#stock_red1_' + chambre).html());
        $('#reserver_' + chambre).prop('checked', false);
        $("[data-mode='" + chambre + "']").remove();
        calculateTotal();
        var compte = $('#invoiceItem >tr').length;
        $('#compteur1').html(compte);
        if($('#invoiceItem > tr').length<1){
          $('#btn_enreg').prop('disabled', true);
}
      } else {
        var stock_red = parseFloat($('#stock_red_' + chambre).text());
        var result = stock_red - $('#qteA_' + chambre).val();
        $('.egal_' + chambre).val($('#qteA_' + chambre).val());
        $('#resultQte_' + chambre).html($('#qteA_' + chambre).val());
      }

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
    $('.checked_id_client').prop('disabled', false);

    $('.checked_id_client').change(function() {
      var checked_id_client = $(this).data('id');
      var $row = $(this).closest('tr:has(td)');
      $('#id_clientCheck').val(checked_id_client);
      $("#id_nom_client").html($row.children()[0].textContent);
      $("#id_phone_client").html($row.children()[1].textContent);
      if ($('#checked_id_client_' + checked_id_client).is(':checked')) {
        $('.checked_id_client').prop('checked', false);
        $('#checked_id_client_' + checked_id_client).prop('checked', true);
        $('#id_clientCheck').val(checked_id_client);

      } else {
        $('#id_clientCheck').val("");
        $("#id_nom_client").html('');
        $("#id_phone_client").html('');
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
    $(".fab-show").hide();
    $(".fab-hide").hide();
    $(".fab-four").hide();
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
    var count = 1;
    var click = 0;
    $(document).on('change', '.reserver', function(e) {
      count++;
      var id_article = $(this).data('id');
      var qteA = $('#qteA_' + id_article).val();
      var resultstock = $('#resultstock_' + id_article).val();
      var remarq = $('#remarq_' + id_article).val();
      $('#message_show_' + id_article).html("Quantité requise *")
      if ($(this).is(":checked")) {

        if ($('#qteA_' + id_article).val() == 0) {
          $('#reserver_' + id_article).prop('checked', false);

          $('#message_show_' + id_article).show().delay(5000).hide(0);

        } else {

          $.ajax({
            url: "../controller/article/fetch_article",
            type: "post",
            data: {
              id_article: id_article
            },
            dataType: 'json',
            success: function(data) {
              var htmlRows = '';
              htmlRows += '<tr id="row' + count + '" class="item" data-mode="' + id_article + '">';
              htmlRows += '<td style="display: none;" class="spot"><input type="text"  name="id_article[]" class="form-control form-control-sm prix" value="' + data.id_article + '" readonly required="required"></td>';
              htmlRows += '<td class="spot">' + data.imgInp1 + '&nbsp;&nbsp;&nbsp;' + data.description_article + '</td>';
              htmlRows += '<td style="padding-top:5px" class="spot"><div id=prixtab_' + id_article + '>' + data.prix + ' </div><input type="hidden" name="prix[]"  class="form-control form-control-sm prix prixegal_' + id_article + '" value="' + data.prix + '" id="prix_' + count + '" onKeyUp="calculateTotal()"  required="required" readonly><input type="hidden" name="prix1[]"  class="form-control form-control-sm prix1 prixegal1_' + id_article + '" value="' + data.prix + '" id="prix1_' + count + '" data-id="' + id_article + '"   required="required" readonly>' +
                '</td>';
              htmlRows += '<td style="padding-top:5px" class="spot"><div id="resultQte_' + id_article + '">' + qteA + '</div><input type="hidden" name="quantite[]"  class="form-control form-control-sm quantite egal_' + id_article + '" value="' + qteA + '" id="quantite_' + id_article + '"  required="required" readonly></td>';
              htmlRows += '<td style="padding-top:5px;text-align: right;" class="spot">' +
                '<input type="hidden" name="descript[]" id="descript_' + id_article + '" value="' + remarq + '">' +
                '<div id="descript1_' + id_article + '">' + remarq + '</div>' +
                '</td>';
              htmlRows += '</tr>';

              $('#invoiceItem').append(htmlRows);
              calculateTotal();
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
            $('#btn_enreg').prop('disabled', true);
          }
        })
      }
      $(function() {

      })
    })

    $(document).on('input', '.remarq', function(e) {
      var id = $(this).data('id');
      var input = $('#remarq_' + id).val();
      $('#descript_' + id).val(input);
      $('#descript1_' + id).html(input);
      var txt = $('#remarq_' + id).val();
      if (txt.length > 2) {
        $('#text_remarque_' + id).html(txt.substring(0, 5) + '.....');
        $('#descript1_' + id).html(txt.substring(0, 5) + '.....');

      } else {
        $('#text_remarque_' + id).html("");
        $('#descript1_' + id).html("");

      }
    });
    $(document).on('input', '.prixmod', function(e) {
      var id = $(this).data('id');
      var input = $('#prixmod_' + id).val();;
      $('.prixegal_' + id).val(input);
      $('#prix_result_' + id).html(Number(input).toLocaleString('fi-FI'));
      $('#prixtab_' + id).html(Number(input).toLocaleString('fi-FI'));
      if ($('.prixegal_' + id).val() == "") {
        $('.prixegal_' + id).val($('.prixegal1_' + id).val());
        $('#prix_result_' + id).html(Number($('.prixegal1_' + id).val()).toLocaleString('fi-FI'));
        $('#prixtab_' + id).html(Number($('.prixegal1_' + id).val()).toLocaleString('fi-FI'));

      }
    });
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
    checked();

    function checked() {
      $("[id^='checkrow_']").each(function() {
        var chambre = $(this).data('id');
        var det = $('#sous_content1_' + chambre).detach();
        $('.conteneur').prepend(det);
        $('#qteA_' + chambre).val($('.egal_' + chambre).val())
        if ($('#qteA_' + chambre).val($('.egal_' + chambre).val()) <= 1) {

          $('#minus_' + chambre).prop('disabled', true);

        } else {
          $('#minus_' + chambre).prop('disabled', false);

        }
        $('#reserver_' + chambre).prop('checked', true);
      });
    }

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
      $("#mt_ht").val(sum);
      $("#mt_ttc").val(sum);
    }

    function keytva() {
      var taxRate = $("#tva").val();
      var subTotal = $('#mt_ht').val();
      if (subTotal) {
        var taxAmount = subTotal * taxRate / 100;
        $('#mt_tva').val(taxAmount);
        subTotal = parseFloat(subTotal) + parseFloat(taxAmount);
        $('#mt_ttc').val(subTotal);
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

    function monnaie() {
      var espece_du = $("#espece_du").val();
      var mt_ttc = $('#mt_ttc').val();
      if (espece_du) {
        subTotal = parseFloat(espece_du) - parseFloat(mt_ttc);
        $('#espece_rendu').val(subTotal);
      } else {
        $('#espece_rendu').val("");
      }
    }
    //FIN CREER RESERVATION
  </script>
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
            var scrolled = 0;

    if (annyang) {
      annyang.setLanguage('fr-FR');
      // Let's define our first command. First the text we expect, and then the function it should call
      var commands = {
        'chariot': function() {
            $("#exampleModalScrollable").modal('show')

          },
          'catégorie *tag': function(variable) {
          let task_name = document.getElementById("categorie");
          task_name.value = variable;
          var currency = $('#categorie').val().toLowerCase().replace(/,/g, ''); // exclude commas
          if (currency) {
            $(".categorie").keyup();
          }

        },
        "prix d'achat":function(event){
          var id= $("#numv").val();
          $("#addprix_"+id).click()
          $("#prixmod_"+id).focus()
          event.preventDefault();

        },
        'remarque':function(event){
          var id= $("#numv").val();
          $("#addremarque_"+id).click()
          $("#remarq_"+id).focus()
          event.preventDefault();
},
        'observation':function(){
          $("#ob1").focus()
         
        },
        'article *tag': function(variable) {
          let task_name = document.getElementById("produit");
          task_name.value = variable;
          var currency = $('#produit').val().toLowerCase().replace(/,/g, ''); // exclude commas
          if (currency) {
            $(".produit").keyup();
          }
        },
        'quantité *tag':function(a){
          var id = $("#numv").val();
          $('#qteA_' + id).focus()
          $('#qteA_' + id).val(a);

          var currency = $('#qteA_' + id).val().toLowerCase().replace(/,/g, ''); // exclude commas
          if (currency) {
            $('#qteA_' + id).keyup();
          }
          $('.egal_' + id).val($('#qteA_' + id).val());
        $('#resultQte_' + id).html($('#qteA_' + id).val());

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
        'arrêter la recherche': function(variables) {
          $("#produit").val("");
          $("#categorie").val("");
        
          if ($("#produit").val(variables)) {
            $(".produit").keyup();
          } else if ($("#categorie").val(variables)) {
            $(".categorie").keyup();
          }
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
            var id= $("#numv").val();
            $("#prx_remarq_"+id).hide(1000)
            $("#prx_div_"+id).hide(1000)
          },
        'bouton client': function() {

          $(".fab-show").show()
          $(".fab-hide").show()
          $(".fab-button").hide()
        },



        'actualiser': function(variable) {
          $("#exampleModalScrollable").modal('hide')

          $('#vocal').modal('show');
          setTimeout(function() {
            console.log('completed');
            $('#vocal').modal('hide');
            window.location.href = "modifier_reception?edit_id=<?php echo  $_GET['edit_id']; ?>&id=<?php echo  $_GET['id']; ?>";

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
            success: function(data) {
              $("#numv").val(data.id_article);
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