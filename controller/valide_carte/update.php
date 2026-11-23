
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 
  $id_valide_carte=$_POST['id_valide_carte'];
  $id_client_cartes=$_POST['id_client_cartes'];
  $datefin=$_POST['datefin'];
  $point=$_POST['point'];
  $deduire=$_POST['deduire'];
    $query="UPDATE valide_carte SET datefin='$datefin', point= '$point',deduire='$deduire' WHERE id_valide_carte='$id_valide_carte' AND id_client='$id_client_cartes'";
    $statement=$db->prepare($query);
    $statement->execute(array($datefin,$point,$deduire));
    $_SESSION['message_update']="Modification effectuée avec succés";
    $_SESSION['msg_type_update']="warning";
    header("location:../page/client.php");   

 
 ?>