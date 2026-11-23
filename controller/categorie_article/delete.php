
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();

  $id=$_POST['delete_id'];

 $query="DELETE FROM categorie_stock WHERE id_categorie_stock=$id";
 $statement=$db->prepare($query);
$statement->execute(array( $id));
 $_SESSION['message_delete']="Suppression effectuée avec succés";
 $_SESSION['msg_type_delete']="danger";
header("location:../page/categorie_article.php");
 ?>