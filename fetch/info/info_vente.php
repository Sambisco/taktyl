<?php
session_start();
include('../../include/database.php');
?>
<?php
if (isset($_POST["facture"])) {
  $facture = $_POST["facture"];
  $query = "SELECT * FROM tva 
      INNER JOIN vente ON tva.id_tva=vente.id_tva 
      INNER JOIN account ON tva.id_tva=account.id_tva 
      INNER JOIN livraison ON tva.id_tva=livraison.id_tva 
      INNER JOIN detail_vente ON tva.id_tva=detail_vente.id_tva 
      INNER JOIN article ON article.id_article=vente.id_article 
      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
      INNER JOIN client ON client.id_client=tva.id_client 
   INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
WHERE tva.id_tva='$facture'";
  $statement = $db->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $total_row = $statement->rowCount();
  if ($total_row > 0) {
    foreach ($result as $row) {
    }
?>

    <div class="d-flex flex-row-reverse">
      <div class="p-0">
        
      </div>
    </div>
    <div class="form-row" style="margin-top: -10px;">
      <div class="form-group col-md-6" style="display: flex;">
      <div class="form-group" id="simple-date1">
          <label for="simpleDataInput">Numero :</label>
          <div class="input-group date">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
            </div>
            <input type="hidden" name="id_tva" id="" value=" <?php if ($row['num'] < 10) {
                                echo "0" . $row['num'];
                              } else {
                                echo $row['num'];
                              }  ?>">

            <input type="text" name="date" class="form-control form-control-sm" value=" <?php if ($row['num'] < 10) {
                                echo "0" . $row['num'];
                              } else {
                                echo $row['num'];
                              }  ?>" readonly>
          </div>
        </div>
      </div>
      <div class="form-group col-md-6" style="display: flex;">
      <div class="form-group" id="simple-date1">
          <label for="simpleDataInput">Date :</label>
          <div class="input-group date">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
            </div>
            <input type="hidden" name="id_tva" id="" value="00<?php echo $row["id_tva"]; ?>">
            <input type="datetime-local" id="date1" name="date" class="form-control form-control-sm" value="<?php echo $row["date"]; ?>" readonly>
          </div>
        </div>
      </div>

    </div>
    <div class="form-row" style="margin-top: -10px;">
      <div class="form-group col-md-6" style="display: flex;">
        <i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
        <input type="hidden" name="id_client" id="id_clientCheck" value=" <?php echo $row["id_client"]; ?>">
        <div id="id_nom_client" style="margin-left: 5px;margin-right: 10px; font-size: 14px;padding-top: 10px;">
          <?php echo $row["nom_client"]; ?>

        </div>
      </div>
      <div class="form-group col-md-6" style="display: flex;font-size: 14px;">
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
              <td style="padding-top:15px;display: none;" class="spot"><input type="text" name="prix[]" class="form-control form-control-sm prix" value="<?php echo $row['prix']; ?>" id="prix_<?php echo $count; ?>" required="required" readonly></td>
              <td style="padding-top:7px" class="spot">
                <div id="resultQte_<?php echo $row['id_article']; ?>"><?php echo $row["quantite"]; ?></div><input type="hidden" name="quantite[]" class="form-control form-control-sm quantite_<?php echo $row['id_article']; ?> egal_<?php echo $row['id_article']; ?>" value="<?php echo $row['quantite']; ?>" id="quantite_<?php echo $count; ?>" data-id="<?php echo $row['id_article']; ?>" onKeyUp="calculateTotal()" required="required" readonly>
              </td>
              <td style="padding-top:15px;display: none;" class="spot"><input type="hidden" name="quant[]" class="form-control form-control-sm quant_<?php echo $row['qte'] ?>" value="<?php echo $row['qte']; ?>" id="quant_<?php echo $count; ?>" required="required" readonly></td>
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
<?php
  }
}
?>