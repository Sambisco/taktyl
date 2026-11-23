<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
  $timezone = "UTC";
  date_default_timezone_set($timezone);
}
include('../../include/database.php');
if(isset($_POST['id_article_p'])){
 $id=$_POST['id_article_p'];
 $query="SELECT *,DATE_FORMAT(date_p,'%d/%m/%Y') AS date_pp FROM `peremption`
 INNER JOIN article ON article.id_article=peremption.id_article
 INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
 WHERE article.id_article='$id'";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_peremption"]=$row["id_peremption"];
    $data["id_article"]=$row["id_article"];
    $data["id_boutique"]=$row["id_boutique"];
        $data["date_p"]=$row["date_p"];
    $data["date_pp"]=$row["date_pp"];
		
  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
}
  // fetch categorie


  if(isset($_POST['id_champ'])){
    $id_champ=$_POST['id_champ'];
    $id_boutiques=$_POST['id_boutiques'];
    $query="SELECT *,DATE_FORMAT(date_p,'%d/%m/%Y') AS date_pp FROM `peremption`
    INNER JOIN article ON article.id_article=peremption.id_article
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
     INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
    WHERE article.id_id_article='$id_champ' AND boutique.id_boutique='$id_boutiques'";
       $statement=$db->prepare($query);
     $statement->execute();
   $result=$statement->fetchAll();
   $total_row=$statement->rowCount();
     if ( $total_row>0) {
       $data = array();
     foreach($result as $row){
       $data["id_peremption"]=$row["id_peremption"];
       $data["id_article"]=$row["id_article"];
       $data["id_boutique"]=$row["id_boutique"];
           $data["date_p"]=$row["date_p"];
       $data["date_pp"]=$row["date_pp"];
       
     }
     echo json_encode($data);
     }
     else {
       echo "0" ; 
     }
   }
  ?>
