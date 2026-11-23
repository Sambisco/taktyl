
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 
$id_client=$_POST['id_client'];
$id_categorie_client=$_POST['id_categorie_client'];
    $query="UPDATE client SET id_categorie_client='$id_categorie_client' WHERE id_client='$id_client'";
    $statement=$db->prepare($query);
    $statement->execute(array($id_categorie_client));
    $_SESSION['message_update']="Modification effectuée avec succés";
    $_SESSION['msg_type_update']="success";
    header("location:../page/client.php");   

 
 ?>