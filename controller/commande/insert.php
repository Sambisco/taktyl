<?php 
session_start();
include('../../include/database.php');
$num = $_POST["num"];
$date = $_POST["date"];
$id_article = $_POST["id_article"];
$quantite = $_POST["quantite"];
$description = $_POST["description"];
$idfournisseur = $_POST["idfournisseur"];
$id_boutique = $_POST["id_boutique"];
$statement = $db->prepare("INSERT INTO `commande`( `num`, `date`, `idfournisseur`,description) VALUES (?,?,?,?)");
$statement->execute(array($num,$date,$idfournisseur,$description));

$statement = $db->prepare("SELECT MAX(commande.id_commande) as id_commande FROM `commande` 
               INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
               INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
               WHERE  boutique.id_boutique='$id_boutique'");
$statement->execute();
$result = $statement->fetch();
$id_commande=$result['id_commande'];

$statement = $db->prepare("INSERT INTO `reception`(num,id_commande) VALUES (?,?)");
$statement->execute(array($num,$id_commande));
for($count=0; $count<$_POST["quantite"]; $count++)
{
$statement = $db->prepare("INSERT INTO `detail_commande`( `id_commande`, `id_article`, `quantite`) VALUES (?,?,?)");
$statement->execute(array($id_commande,$id_article[$count],$quantite[$count]));
$_SESSION['message_add']="Enregistrement effectué avec succés";
$_SESSION['msg_type_add']="success";
 header("location:../page/commande.php");
}
?>