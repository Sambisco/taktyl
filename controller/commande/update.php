<?php 
session_start();
include('../../include/database.php');
$id=$_POST['num'];
$query="DELETE detail_commande FROM detail_commande INNER JOIN commande ON commande.id_commande=detail_commande.id_commande  WHERE commande.id_commande=$id";
$statement=$db->prepare($query);
$statement->execute(array( $id));
$id_article = $_POST["id_article"];
$quantite = $_POST["quantite"];
$description = $_POST["description"];
$idfournisseur = $_POST["idfournisseur"];

$query="UPDATE `commande` SET`idfournisseur`='$idfournisseur',`description`='$description' WHERE id_commande=$id";
$statement=$db->prepare($query);
$statement->execute(array( $id));
for($count=0; $count<$_POST["quantite"]; $count++)
{
$statement = $db->prepare("INSERT INTO `detail_commande`( `id_commande`, `id_article`, `quantite`) VALUES (?,?,?)");
$statement->execute(array($id,$id_article[$count],$quantite[$count]));
$_SESSION['message_add']="Modification effectuée avec succés";
$_SESSION['msg_type_add']="success";
 header("location:../page/commande.php");
}
?>