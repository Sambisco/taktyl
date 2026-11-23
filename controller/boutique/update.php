
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();

  $id=trim($_POST['edit_id']);
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

 $img_logo='data:image/'.$ext_img_logo.';base64,'.$img_base64_logo;
 //CACHET DATABASE
 $tmp_name_img_cachet=$_FILES['cachet']['tmp_name'];

 $ext_img_cachet=pathinfo($tmp_name_img_cachet,PATHINFO_EXTENSION);

 $data_cachet=file_get_contents($tmp_name_img_cachet);

 $img_base64_cachet=base64_encode($data_cachet);

 $img_cachet='data:image/'.$ext_img_cachet.';base64,'.$img_base64_cachet;
 
     if($_FILES["logo"]["tmp_name"]==""){
 $query="UPDATE boutique SET nomb= '$nomb',lieu='$lieu',telephone='$telephone',email='$email',web='$web',ninea='$ninea' WHERE id_boutique='$id'";
 $statement=$db->prepare($query);
$statement->execute(array($nomb,$lieu,$telephone,$email,$web,$ninea,));
 $_SESSION['message_update']="Modification effectuée avec succés";
 $_SESSION['msg_type_update']="warning";
header("location:../page/boutique.php");
     }else{
    $query="UPDATE boutique SET nomb= '$nomb',lieu='$lieu',telephone='$telephone',email='$email',web='$web',ninea='$ninea',logo='$img_logo' WHERE id_boutique='$id'";
    $statement=$db->prepare($query);
    $statement->execute();
    $_SESSION['message_update']="Les modifications ont été effectuées ";
    $_SESSION['msg_type_update']="warning";
    header("location:../page/boutique.php");   
     }
     if($_FILES["cachet"]["tmp_name"]==""){
        $query="UPDATE boutique SET nomb= '$nomb',lieu='$lieu',telephone='$telephone',email='$email',web='$web',ninea='$ninea' WHERE id_boutique='$id'";
        $statement=$db->prepare($query);
       $statement->execute(array($nomb,$lieu,$telephone,$email,$web,$ninea,));
        $_SESSION['message_update']="Modification effectuée avec succés";
        $_SESSION['msg_type_update']="warning";
       header("location:../page/boutique.php");
            }else{
           $query="UPDATE boutique SET nomb= '$nomb',lieu='$lieu',telephone='$telephone',email='$email',web='$web',ninea='$ninea',cachet='$img_cachet' WHERE id_boutique='$id'";
           $statement=$db->prepare($query);
           $statement->execute();
           $_SESSION['message_update']="Les modifications ont été effectuées ";
           $_SESSION['msg_type_update']="warning";
           header("location:../page/boutique.php");   
            }
 ?>