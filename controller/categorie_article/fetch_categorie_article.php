<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../../include/database.php');
if(isset($_POST['chambre'])){
 $id=$_POST['chambre'];
 $query="SELECT * FROM categorie_stock 
 INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
 WHERE categorie_stock.id_categorie_stock='$id'";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_boutique"]=$row["id_boutique"];
    $data["id_categorie_stock"]=$row["id_categorie_stock"];
    $data["categorie_stock"]=$row["categorie_stock"];
    $data["description_stock"]=$row["description_stock"];		
  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
}

if(isset($_POST['id_champ'])){
  $id_champ=$_POST['id_champ'];
  $id_boutiques = $_POST['id_boutiques'];
  $query="SELECT * FROM categorie_stock 
  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
  WHERE categorie_stock.id_id_categorie='$id_champ' AND boutique.id_boutique='$id_boutiques'";
     $statement=$db->prepare($query);
   $statement->execute();
 $result=$statement->fetchAll();
 $total_row=$statement->rowCount();
   if ( $total_row>0) {
     $data = array();
   foreach($result as $row){
     $data["id_boutique"]=$row["id_boutique"];
     $data["id_categorie_stock"]=$row["id_categorie_stock"];
     $data["categorie_stock"]=$row["categorie_stock"];
     $data["description_stock"]=$row["description_stock"];		
   }
   echo json_encode($data);
   }
   else {
     echo "0" ; 
   }
 }
?>

