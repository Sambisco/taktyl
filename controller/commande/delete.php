<?php 
session_start();
include('../../include/database.php');
$id=$_POST['delete_id']; 
$query="DELETE  FROM commande WHERE id_commande=$id";
$statement=$db->prepare($query);
$statement->execute(array( $id));

$_SESSION['message_add']="Suppression effectuée avec succés";
$_SESSION['msg_type_add']="success";
 header("location:../page/commande.php");

?>