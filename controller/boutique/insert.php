
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 $iduser=trim($_POST['iduser']);
 $nomb=trim($_POST['nomb']);
 $lieu=trim($_POST['lieu']);
 $telephone=trim(str_replace(' ','',$_POST['telephone']));
 $email=trim($_POST['email']);
 $web=trim($_POST['web']);
 $ninea=trim($_POST['ninea']);

// LOGO DATABASE
$tmp_name_img_logo=$_FILES['logo']['tmp_name'];

 $ext_img_logo=pathinfo($tmp_name_img_logo,PATHINFO_EXTENSION);

 $data_logo=file_get_contents($tmp_name_img_logo);

 $img_base64_logo=base64_encode($data_logo);
if($_FILES['logo']['tmp_name']==""){
    $img_logo="";
}else{
    $img_logo='data:image/'.$ext_img_logo.';base64,'.$img_base64_logo;

}
 //CACHET DATABASE
 $tmp_name_img_cachet=$_FILES['cachet']['tmp_name'];

 $ext_img_cachet=pathinfo($tmp_name_img_cachet,PATHINFO_EXTENSION);

 $data_cachet=file_get_contents($tmp_name_img_cachet);

 $img_base64_cachet=base64_encode($data_cachet);

 if($_FILES['cachet']['tmp_name']==""){
    $img_cachet="";
 }else{
    $img_cachet='data:image/'.$ext_img_cachet.';base64,'.$img_base64_cachet;
 
 }

 $query = "SELECT COUNT(boutique.iduser) AS id,formule FROM user LEFT JOIN boutique ON boutique.iduser=user.iduser WHERE user.iduser='$iduser' ORDER BY id_boutique DESC";
 $statement = $db->prepare($query);
 $statement->execute();
 $result = $statement->fetch();
 if ($result['id'] >= $result['formule']) {
    $_SESSION['message_add']="Impossible, vous avez atteint la limite";
    $_SESSION['msg_type_add']="success";
 
}else{
    $query="INSERT INTO boutique(nomb,lieu,telephone,email,web,ninea,logo,cachet,iduser)VALUES(?,?,?,?,?,?,?,?,?)";
    $statement=$db->prepare($query);
   $statement->execute(array($nomb,$lieu,$telephone,$email,$web,$ninea, $img_logo,$img_cachet,$iduser));
   $_SESSION['message_add']="Enregistrement effectué avec succés";
   $_SESSION['msg_type_add']="success";
 }
 header("location:../page/boutique");


 ?>