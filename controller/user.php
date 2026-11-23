<!-- Topbar Search -->
<?php include('../include/database.php');
include('../include/config.php');
session_start();
 if(isset($_POST['insertdata'])){
  $id_boutique=$_POST['id_boutique'];
  $telephone_sub_user=trim(str_replace(' ','',$_POST['telephone_sub_user']));
  $sub_email = strtolower(trim($_POST["sub_email"]));
  $show_email=trim($_POST['show_email']);
  $id_m = encryptor('encrypt',$id_boutique);
   $query="SELECT * FROM user LEFT JOIN boutique ON boutique.iduser=user.iduser
   LEFT JOIN sub_users ON sub_users.id_boutique=boutique.id_boutique 
    WHERE sub_email='$sub_email' OR telephone_sub_user='$telephone_sub_user' OR email='$sub_email' OR telephone_user='$telephone_sub_user' LIMIT 1";
     $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
    if ($total_row>0){
	$_SESSION['message_delete']="L'identifiant existe déja. Veillez créér un nouveau identifiant!";
 $_SESSION['msg_type_delete']="alert alert-danger";

  header("location:../page/user?mail=$show_email&id=$id_m");
	}else{
 $nom_sub_user=trim($_POST['nom_sub_user']);
 $telephone_sub_user=trim(str_replace(' ','',$_POST['telephone_sub_user']));
 $sub_email=strtolower(trim($_POST['sub_email']));
 $sub_password=trim(md5($_POST['sub_password']));
 $profil=trim($_POST['profil']);
 $show_email=trim($_POST['show_email']);
 $id_m = encryptor('encrypt',$id_boutique);
 $query="INSERT INTO sub_users(nom_sub_user,telephone_sub_user, sub_email, sub_password, profil,id_boutique) VALUES(?,?,?,?,?,?)";
 $statement=$db->prepare($query);
$statement->execute(array($nom_sub_user,$telephone_sub_user,$sub_email,$sub_password,$profil,$id_boutique));
 $_SESSION['message_add']="Les données ont été enregistrées";
 $_SESSION['msg_type_add']="alert alert-primary alert-dismissible";
 
 header("location:../page/user?mail=$show_email&id=$id_m");
} 
 }
 if(isset($_POST['updatetdata'])){
  $update_user=trim($_POST['update_user']);
  $profil=trim($_POST['profil']);
  $id_boutique=trim($_POST['id_boutique']);
$newpassword=trim(md5($_POST['newpassword']));
$sub_email=strtolower(trim($_POST['sub_email']));
$id_m = encryptor('encrypt',$id_boutique);
$show_email=trim($_POST['show_email']);
if($_POST['newpassword']==""){
  $con="UPDATE sub_users SET profil='$profil' WHERE id_sub_users='$update_user'";
}else{
  $con="UPDATE sub_users SET profil='$profil',sub_password='$newpassword' WHERE id_sub_users='$update_user'";
}
  $chngpwd1 = $db->prepare($con);
  $chngpwd1->execute();

  $_SESSION['message_update']="Les identifiants ont été modifier ";
 $_SESSION['msg_type_update']="alert alert-success";
 header("location:../page/user?mail=$show_email&id=$id_m");
    }

 if(isset($_POST['deletedata'])){
  $id_boutique=$_POST['id_boutique'];
  $id=$_POST['delete_id'];
  $id_m = encryptor('encrypt',$id_boutique);
  $show_email=trim($_POST['show_email']);
 $query="DELETE FROM sub_users WHERE id_sub_users=$id";
 $statement=$db->prepare($query);
$statement->execute();
 $_SESSION['message_delete']="Suppression effectuée avec succés";
 $_SESSION['msg_type_delete']="alert alert-danger";
 header("location:../page/user?mail=$show_email&id=$id_m");
}
 ?>