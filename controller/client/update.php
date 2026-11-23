
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 
$edit_id=$_POST['edit_id'];
$nom_client=$_POST['nom_client'];
$telephonec=$_POST['telephonec'];
$adresse=$_POST['adresse'];
$emailc=$_POST['emailc'];
$desc_categ_client=$_POST['desc_categ_client'];
    $query="UPDATE client SET nom_client='$nom_client',telephonec='$telephonec',adresse='$adresse',emailc='$emailc',desc_categ_client='$desc_categ_client' WHERE id_client='$edit_id'";
    $statement=$db->prepare($query);
    $statement->execute(array($nom_client,$telephonec,$adresse,$emailc,$desc_categ_client,$edit_id));
    $_SESSION['message_update']="Modification effectuée avec succés";
    $_SESSION['msg_type_update']="success";
    header("location:../page/client.php");   

 
 ?>