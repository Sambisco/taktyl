
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 $id_id_categorie=$_POST['id_id_categorie'];
 $id_boutique=$_POST['id_boutique'];
 $categorie_stock=$_POST['categorie_stock'];
 $description_stock=$_POST['description_stock'];

 $query="INSERT INTO categorie_stock(id_boutique,id_id_categorie,categorie_stock,description_stock)VALUES(?,?,?,?)";
 $statement=$db->prepare($query);
$statement->execute(array($id_boutique,$id_id_categorie,$categorie_stock,$description_stock));
 $_SESSION['message_add']="Enregistrement effectué avec succés";
 $_SESSION['msg_type_add']="success";
header("location:../page/categorie_article");

 ?>