<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../../include/database.php');
if(isset($_POST['chambre'])){
 $id=$_POST['chambre'];
 $query="SELECT * FROM categorie_client 
 INNER JOIN boutique ON boutique.id_boutique=categorie_client.id_boutique
 WHERE categorie_client.id_categorie_client='$id' ";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_boutique"]=$row["id_boutique"];
    $data["id_categorie_client"]=$row["id_categorie_client"];
    $data["nom_categorie_client"]=$row["nom_categorie_client"];
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
  $query="SELECT * FROM categorie_client 
  INNER JOIN boutique ON boutique.id_boutique=categorie_client.id_boutique
  WHERE categorie_client.id_id_categorie_client='$id_champ' AND boutique.id_boutique='$id_boutiques'";
     $statement=$db->prepare($query);
   $statement->execute();
 $result=$statement->fetchAll();
 $total_row=$statement->rowCount();
   if ( $total_row>0) {
     $data = array();
   foreach($result as $row){
     $data["id_categorie_client"]=$row["id_categorie_client"];
   }
   echo json_encode($data);
   }
   else {
     echo "0" ; 
   }
 }
?>

