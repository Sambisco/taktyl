<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
  $timezone = "UTC";
  date_default_timezone_set($timezone);
}
include('../../include/database.php');
 $id=$_POST['id_promotion'];
 $query="SELECT *,DATE_FORMAT(datedeb,'%d-%M-%Y') AS datedebp,DATE_FORMAT(datefin,'%d-%M-%Y') AS datefinp FROM promotion 
 INNER JOIN article ON article.id_article=promotion.id_article
INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
WHERE promotion.id_promotion='$id'";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    setlocale(LC_TIME, 'fr_FR.utf8');
    $data["id_promotion"]=$row["id_promotion"];
    $data["id_categorie_stock"]=$row["id_categorie_stock"];
    $data["categorie_stock"]=$row["categorie_stock"];
    $data["id_article"]=$row["id_article"];
    $data["description_article"]=$row["description_article"];
    $data["datedeb"]=$row["datedeb"];
    $data["datedebp"]=strftime("%d-%B-%Y", strtotime($row["datedebp"]));
    $data["datefin"]=$row["datefin"];
    $data["datefinp"]=strftime("%d-%B-%Y", strtotime($row["datefinp"]));
    $data["reduction"]=$row["reduction"];
    $data["conditions"]=$row["conditions"];
    if($row["imgInp"] != '')
    {
        $data['imgInp'] = '<img src="../img/img/'.$row["imgInp"].'" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';
  $data['imgInp1'] = '<img src="../img/img/'.$row["imgInp"].'"  width="30" height="20" alt="icons8-team-100" />';
    }else{
  $data['imgInp'] = '<img src="../img/img/image.jpg" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';

  $data['imgInp1'] = '<img src="../img/img/image.jpg" width="30" height="20" alt="icons8-team-100" />';
}
  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
  // fetch categorie
  if(isset($_POST["id_promotions"])) 
{
  $id_promotions =$_POST['id_promotions'];
  $query="SELECT * FROM promotion 
  INNER JOIN article ON article.id_article=promotion.id_article
 INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
 INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
 WHERE promotion.id_promotion='$id_promotions'";
  $statement=$db->prepare($query);
$statement->execute();
$result=$statement->fetchAll();
 foreach($result as $row){
?>
<option value="<?php echo $row["id_article"]; ?>" selected><?php echo $row["description_article"]; ?></option>

   <?php
}
}

if(isset($_POST["id_categorie"])) 
{
  $id_categorie =$_POST['id_categorie'];
  $query="SELECT * FROM article 
  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
  WHERE categorie_stock.id_categorie_stock='$id_categorie' ";
  $statement=$db->prepare($query);
$statement->execute();
$result=$statement->fetchAll();
?>
<option value="">Selectionnez article</option>
<?php
 foreach($result as $row){
?>
<option value="<?php echo $row["id_article"]; ?>"><?php echo $row["description_article"]; ?></option>

   <?php
}
}
?>

