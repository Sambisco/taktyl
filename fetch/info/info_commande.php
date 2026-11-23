<?php
session_start();
include('../../include/database.php');
?>
<?php
if (isset($_POST["facture"])) {
  $facture = $_POST["facture"];
  $query = "SELECT * FROM detail_commande 
      INNER JOIN commande ON commande.id_commande=detail_commande.id_commande 
      INNER JOIN article ON article.id_article=detail_commande.id_article 
      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
       INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
       INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
WHERE commande.id_commande='$facture'";
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
        <div class="form-row" style="margin-top: -10px;">
          <div class="form-group col-md-6" style="display: flex;">
            <div class="form-group" id="simple-date1">
              <label for="simpleDataInput">Numero :</label>
              <div class="input-group date">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
                </div>
                <input type="hidden" name="id_tva" id="" value="00<?php echo $row["id_commande"]; ?>">

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
                <input type="hidden" name="id_tva" id="" value="00<?php echo $row["id_commande"]; ?>">
                <input type="datetime-local" id="date1" name="date" class="form-control form-control-sm" value="<?php echo $row["date"]; ?>" readonly>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
    <div class="form-row" style="margin-top: -10px;">
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
          <th style="width: 180px;">ARTICLE</th>
          <th style="width: 40px;">QTE</th>
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
              <td style="padding-top:8px" class="spot">
                <div id="resultQte_<?php echo $row['id_article']; ?>"><?php echo $row['quantite']; ?></div><input type="hidden" name="quantite[]" class="form-control form-control-sm quantite egal_<?php echo $row['id_article']; ?>" value="<?php echo $row['quantite']; ?>" id="quantite_<?php echo $count; ?>" data-id="<?php echo $row['id_article']; ?>" onKeyUp="calculateTotal()" required="required" readonly>
              </td>

            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <hr style="margin-top:-17px ;">

    <div class="col-md-12">
      <div class="form-group">
        <label>Remarque:</label>
        <?php echo $row["description"]; ?>
      </div>
    </div>
<?php
  }
}
?>