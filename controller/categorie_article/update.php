
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 
  $id=$_POST['edit_id'];

  $categorie_stock=$_POST['categorie_stock'];
  $description_stock=$_POST['description_stock'];
    $query="UPDATE categorie_stock SET  categorie_stock= '$categorie_stock',description_stock='$description_stock' WHERE id_categorie_stock='$id'";
    $statement=$db->prepare($query);
    $statement->execute(array($categorie_stock,$description_stock));
    $_SESSION['message_update']="Modification effectuée avec succés";
    $_SESSION['msg_type_update']="warning";
    header("location:../page/categorie_article.php");   

 
 ?>