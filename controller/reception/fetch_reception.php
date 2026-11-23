<?php
session_start();
include('../../include/database.php');
?>
<?php
      if(isset($_POST['facture'])){
		$facture = $_POST['facture'];
   
      $query="SELECT * FROM reception 
      INNER JOIN commande ON commande.id_commande=reception.id_commande
    INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
    INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
     WHERE reception.id_reception= '$facture'";
 
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_reception"]=$row["id_reception"];
    $data["emailfour"]=$row["emailfour"];
  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
    }
         ?>
	<?php
     if (isset($_POST['search'])) {
      $search = $_POST['search'];
      $id_boutique = $_POST['id_boutique'];
      $query="SELECT * FROM reception 
      INNER JOIN commande ON commande.id_commande=reception.id_commande
    INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
    INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
     WHERE reception.num = '$search' AND boutique.id_boutique='$id_boutique'";
 
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_reception"]=$row["id_reception"];
    $data["num"] = $row["num"];
    $data["emailfour"]=$row["emailfour"];
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


$query="SELECT * FROM reception 
  INNER JOIN commande ON commande.id_commande=reception.id_commande
               INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
               INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
 WHERE reception.id_reception = '$num' ";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_reception"]=$row["id_reception"];
    $data["num"]=$row["num"];
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

  $query="SELECT * FROM reception 
  INNER JOIN commande ON commande.id_commande=reception.id_commande
INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
 WHERE reception.id_reception = '$del' ";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_reception"]=$row["id_reception"];
    $data["num"]=$row["num"];

  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
}
?>