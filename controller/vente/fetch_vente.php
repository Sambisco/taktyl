<?php
session_start();
include('../../include/database.php');
?>
<?php
      if(isset($_POST['search'])){
		$search = $_POST['search'];
    $id_boutique = $_POST['id_boutique'];
      $query="SELECT * FROM tva 
      INNER JOIN client ON client.id_client=tva.id_client 
      INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
 WHERE tva.num = '$search' AND boutique.id_boutique='$id_boutique'";
 
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_tva"]=$row["id_tva"];
    $data["num"]=$row["num"];
    $data["emailc"]=$row["emailc"];
  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
    }
         ?>
		 

	<?php 
if(isset($_POST['num'])){
 $num=$_POST['num'];


$query="SELECT * FROM tva 
 INNER JOIN client ON client.id_client=tva.id_client 
 INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
 WHERE tva.id_tva = '$num' ";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_tva"]=$row["id_tva"];
    $data["num"]=$row["num"];
    $data["id_client"]=$row["id_client"];
    $data["id_boutique"]=$row["id_boutique"];
  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
}
?>
<?php 
if(isset($_POST['del'])){
 $del=$_POST['del'];

  $query="SELECT * FROM tva 
 INNER JOIN client ON client.id_client=tva.id_client 
 INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
 WHERE tva.id_tva = '$del' ";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_tva"]=$row["id_tva"];
    $data["num"]=$row["num"];
    $data["id_client"]=$row["id_client"];
    $data["id_boutique"]=$row["id_boutique"];

  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
}
?>