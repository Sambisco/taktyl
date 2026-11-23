<?php 
session_start();
include('../../include/database.php');
$delete_id = $_POST["delete_id"];

   $query="UPDATE `reception` SET `date`='0000-00-00',`descriptionr`=''  WHERE id_reception='$delete_id'";
   $statement=$db->prepare($query);
   $statement->execute(array( $delete_id));
   
   $query="SELECT * FROM detail_reception 
   INNER JOIN reception ON reception.id_reception=detail_reception.id_reception 
   WHERE reception.id_reception='$delete_id'";
     $statement=$db->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    foreach($result as $row){
     echo $rowIdArticle = $row['id_article'];
     echo $rowQuantite = $row['quantite'];
         $statement = $db->prepare("UPDATE `article` SET qte=qte-:quant WHERE id_article=:id_article");
         $statement->execute(array(
         ':id_article'=>$rowIdArticle,
            ':quant'=>$rowQuantite	 
          ));
    }

$query="DELETE detail_reception FROM detail_reception 
INNER JOIN reception ON reception.id_reception=detail_reception.id_reception 
WHERE reception.id_reception='$delete_id'";
 $statement=$db->prepare($query);
$statement->execute(array( $delete_id));



$_SESSION['message_add']="Enregistrement effectué avec succés";
$_SESSION['msg_type_add']="success";
 header("location:../page/commande.php");

?>