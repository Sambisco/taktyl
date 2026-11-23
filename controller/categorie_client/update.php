
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 
  $id=$_POST['edit_id'];

  $nom_categorie_client=$_POST['nom_categorie_client'];
    $query="UPDATE categorie_client SET nom_categorie_client= '$nom_categorie_client' WHERE id_categorie_client='$id'";
    $statement=$db->prepare($query);
    $statement->execute(array($nom_categorie_client));
    $_SESSION['message_update']="Modification effectuée avec succés";
    $_SESSION['msg_type_update']="warning";
    header("location:../page/categorie_client.php");   

 
 ?>