
          <!-- Topbar Search -->
          <?php include('../include/database.php');?>
<?php 
session_start();

  $id=$_POST['delete_id'];
  $idb=$_POST['id_boutique'];
 $query="DELETE FROM message WHERE id_message=$id";
 $statement=$db->prepare($query);
$statement->execute(array( $id));
 $_SESSION['message_delete']="Suppression effectuée avec succés";
 $_SESSION['msg_type_delete']="danger";
header("location:../page/message?id=$idb");
 ?>