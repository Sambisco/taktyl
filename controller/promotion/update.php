
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 
  $id=$_POST['edit_id'];
  $id_article=$_POST['id_article'];
  $datedeb=$_POST['datedeb'];
  $datefin=$_POST['datefin'];
  $reduction=$_POST['reduction'];
  $conditions=$_POST['conditions'];
    $query="UPDATE promotion SET id_article='$id_article', datedeb= '$datedeb',datefin='$datefin',reduction='$reduction',conditions='$conditions' WHERE id_promotion='$id'";
    $statement=$db->prepare($query);
    $statement->execute(array($id_article,$datedeb,$datefin,$reduction,$conditions));
    $_SESSION['message_update']="Modification effectuée avec succés";
    $_SESSION['msg_type_update']="warning";
    header("location:../page/promotion.php");   

 
 ?>