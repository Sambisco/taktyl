<!-- Topbar Search -->
<?php include('../include/database.php');
include('../include/config.php');

session_start();
 if(isset($_POST['insertdata'])){
  $id_boutique=trim($_POST['id_boutique']);
  $telephoneconf = trim($_POST["telephoneconf"]);
  $emailconf = trim($_POST["emailconf"]);
  $passwordconf = trim($_POST["passwordconf"]);
  $show_email = trim($_POST["show_email"]);
  $id_m = encryptor('encrypt',$id_boutique);
   $query="SELECT id_boutique FROM configuration WHERE id_boutique='$id_boutique'";
     $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
    if ($total_row>0){
	$_SESSION['message_delete']="Le messagerie a déja été configurée!";
 $_SESSION['msg_type_delete']="alert alert-danger";
  header("location:../page/configuration?mail=$show_email&id=$id_m");
	}else{

 $query="INSERT INTO `configuration`( `telephoneconf`, `emailconf`, `passwordconf`, `id_boutique`) VALUES(?,?,?,?)";
 $statement=$db->prepare($query);
$statement->execute(array($telephoneconf,$emailconf,$passwordconf,$id_boutique));
 $_SESSION['message_add']="Les données ont été enregistrées";
 $_SESSION['msg_type_add']="alert alert-primary alert-dismissible";
 header("location:../page/configuration?mail=$show_email&id=$id_m");
} 
 }


 if(isset($_POST['deletedata'])){
  $id_boutique=$_POST['id_boutique'];
  $id=$_POST['delete_id'];
  $show_email = trim($_POST["show_email"]);

  $id_m = encryptor('encrypt',$id_boutique);
 $query="DELETE FROM configuration WHERE id_configuration=$id";
 $statement=$db->prepare($query);
$statement->execute();
 $_SESSION['message_delete']="Suppression effectuée avec succés";
 $_SESSION['msg_type_delete']="alert alert-danger";
 header("location:../page/configuration?mail=$show_email&id=$id_m");
}
 ?>