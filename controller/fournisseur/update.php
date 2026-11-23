
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();

    $id=$_POST['edit_id'];
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
    $image='data:image/'.$ext_img.';base64,'.$img_base64;

     if($_FILES["imgInp"]["name"]==""){
 $query="UPDATE fournisseur SET nomfour= '$nomfour',adressefour=' $adressefour',telephonefour=' $telephonefour',emailfour=' $emailfour',descriptionfour='$descriptionfour',id_boutique='$id_boutique' WHERE idfournisseur='$id'";
 $statement=$db->prepare($query);
$statement->execute();
 $_SESSION['message_update']="Modification effectuée avec succés";
 $_SESSION['msg_type_update']="warning";
header("location:../page/fournisseur.php");
     }else{
    $query="UPDATE fournisseur SET nomfour= '$nomfour',adressefour=' $adressefour',telephonefour=' $telephonefour',emailfour=' $emailfour',descriptionfour='$descriptionfour',imgInfour='$image',id_boutique='$id_boutique' WHERE idfournisseur='$id'";
    $statement=$db->prepare($query);
    $statement->execute();
    $_SESSION['message_update']="Modification effectuée avec succés";
    $_SESSION['msg_type_update']="warning";
    header("location:../page/fournisseur.php");   
     }
 
 ?>