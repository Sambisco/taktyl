
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();

  $id=$_POST['delete_id'];

 $query="DELETE FROM promotion WHERE id_promotion=$id";
 $statement=$db->prepare($query);
$statement->execute(array( $id));
 $_SESSION['message_delete']="Suppression effectuée avec succés";
 $_SESSION['msg_type_delete']="danger";
header("location:../page/promotion.php");
 ?>