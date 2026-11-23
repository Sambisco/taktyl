
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 $id_client_carte=$_POST['id_client_carte'];
 $date_created=date('Y-m-d');
 $datefin=$_POST['datefin'];
 $point=$_POST['point'];
 $deduire=$_POST['deduire'];
 $query="INSERT INTO valide_carte(id_client,date_created,datefin,point,deduire)VALUES(?,?,?,?,?)";
 $statement=$db->prepare($query);
$statement->execute(array($id_client_carte,$date_created,$datefin,$point,$deduire));
 $_SESSION['message_add']="Enregistrement effectué avec succés";
 $_SESSION['msg_type_add']="success";
header("location:../page/client.php");

 ?>