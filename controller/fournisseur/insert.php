
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
$id_id_fournisseur=$_POST['id_id_fournisseur'];
 $nomfour=$_POST['nomfour'];
 $adressefour=$_POST['adressefour'];
 $telephonefour=$_POST['telephonefour'];
 $emailfour=$_POST['emailfour'];
 $descriptionfour=$_POST['descriptionfour'];
 $id_boutique=$_POST['id_boutique'];
 
 $tmp_name_img=$_FILES['imgInp']['tmp_name'];

 $ext_img=pathinfo($tmp_name_img,PATHINFO_EXTENSION);
 
 $data=file_get_contents($tmp_name_img);
 
 $img_base64=base64_encode($data);
 if($_FILES['imgInp']['tmp_name']==""){
    $image="";
 }else{
 $image='data:image/'.$ext_img.';base64,'.$img_base64;
 }
 $query="INSERT INTO fournisseur(id_id_fournisseur,nomfour,adressefour,telephonefour,emailfour,imgInfour,descriptionfour,id_boutique)VALUES(?,?,?,?,?,?,?,?)";
 $statement=$db->prepare($query);
$statement->execute(array($id_id_fournisseur,$nomfour,$adressefour,$telephonefour, $emailfour, $image,$descriptionfour,$id_boutique));
 $_SESSION['message_add']="Enregistrement effectué avec succés";
 $_SESSION['msg_type_add']="success";
header("location:../page/fournisseur.php");

 ?>