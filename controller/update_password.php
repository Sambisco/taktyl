<?php 
session_start();
include('../include/database.php');
 if(isset($_GET['submit'])){
 $id=$_GET['id'];
$newpassword=md5($_GET['password']);
$con="update user set password=:newpassword where iduser=:id";
$chngpwd1 = $db->prepare($con);
$chngpwd1-> bindParam(':id', $id, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
 $_SESSION['message_add']="Le mot de passe a été mise à jour&nbsp;Cliquez<a href='../'><font color='blue'> ici</font></a> pour se connecter";
 $_SESSION['msg_type_add']="success";
header("Location:initialise_password?code=$id");
}
 

?>
