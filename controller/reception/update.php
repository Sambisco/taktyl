<?php 
session_start();
include('../../include/database.php');
$id_reception = $_POST["id_reception"];
$date = $_POST["date"];
$id_article = $_POST["id_article"];
$prix_a = str_replace(' ','',$_POST["prix_a"]);
$quantite = str_replace(' ','',$_POST["quantite"]);
$descriptionr = $_POST["descriptionr"];
$descript = $_POST["descript"];

   $query="UPDATE `reception` SET `date`='$date',`descriptionr`='$descriptionr'  WHERE id_reception='$id_reception'";
   $statement=$db->prepare($query);
   $statement->execute(array( $id_reception));
   
   $query="SELECT * FROM detail_reception 
   INNER JOIN reception ON reception.id_reception=detail_reception.id_reception 
   WHERE reception.id_reception='$id_reception'";
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
WHERE reception.id_reception='$id_reception'";
 $statement=$db->prepare($query);
$statement->execute(array( $id_reception));


for($count=0; $count<$_POST["descript"]; $count++)
{
$statement = $db->prepare("INSERT INTO `detail_reception`( `id_reception`, `id_article`,prix, `quantite`,descript) VALUES (?,?,?,?,?)");
$statement->execute(array($id_reception,$id_article[$count],$prix_a[$count],$quantite[$count],$descript[$count]));

$statement = $db->prepare("UPDATE `article` SET prix_a=:prix_a, qte=qte+:quantite WHERE id_article=:id_article");
        $statement->execute(array(
		':id_article'=>$id_article[$count],
        ':prix_a'=>$prix_a[$count],
		   ':quantite'=>$quantite[$count]
		
		 
		 ));
$_SESSION['message_add']="Enregistrement effectué avec succés";
$_SESSION['msg_type_add']="success";
 header("location:../page/commande.php");
}

?>