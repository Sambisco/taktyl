
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 $id_article=$_POST['id_article'];
 $datedeb=$_POST['datedeb'];
 $datefin=$_POST['datefin'];
 $reduction=$_POST['reduction'];
 $conditions=$_POST['conditions'];
 $query="INSERT INTO promotion( `id_article`, `datedeb`, `datefin`, `reduction`, `conditions`)VALUES(?,?,?,?,?)";
 $statement=$db->prepare($query);
$statement->execute(array($id_article,$datedeb,$datefin,$reduction,$conditions));
 $_SESSION['message_add']="Enregistrement effectué avec succés";
 $_SESSION['msg_type_add']="success";
header("location:../page/promotion.php");

 ?>