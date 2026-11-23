
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 $id_boutique=$_POST['id_boutique'];
 $id_id_categorie_client=$_POST['id_id_categorie_client'];
 $nom_categorie_client=$_POST['nom_categorie_client'];
 $query="INSERT INTO categorie_client(id_boutique,id_id_categorie_client,nom_categorie_client)VALUES(?,?,?)";
 $statement=$db->prepare($query);
$statement->execute(array($id_boutique,$id_id_categorie_client,$nom_categorie_client));
 $_SESSION['message_add']="Enregistrement effectué avec succés";
 $_SESSION['msg_type_add']="success";
header("location:../page/categorie_client.php");

 ?>