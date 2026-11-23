<?php 
session_start();
include('../../include/database.php');
$id=$_POST['delete_id']; 
  $query="SELECT * FROM vente 
  INNER JOIN tva ON tva.id_tva=vente.id_tva
  WHERE  tva.id_tva='$id'";
	$statement=$db->prepare($query);
   $statement->execute();
   $result=$statement->fetchAll();
   foreach($result as $row){
	echo $rowIdArticle = $row['id_article'];
	echo $rowQuantite = $row['quantite'];
		$statement = $db->prepare("UPDATE `article` SET qte=qte+:quant WHERE id_article=:id_article");
		$statement->execute(array(
		':id_article'=>$rowIdArticle,
		   ':quant'=>$rowQuantite	 
		 ));
   }
$queryaccount="DELETE FROM tva WHERE id_tva='$id' ";
 $statementaccount=$db->prepare($queryaccount);
$statementaccount->execute(array( $id));

 $_SESSION['message_delete']="Suppression effectuée avec succés";
 $_SESSION['msg_type_delete']="danger";
  header("location:../page/vente.php");
  ?>