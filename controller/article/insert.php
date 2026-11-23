
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
 $id_categorie=$_POST['id_categorie'];
 $id_id_article=$_POST['id_id_article'];
 $description_article=$_POST['description_article'];
 $prix=str_replace(' ','',$_POST['prix']);
 $prix_a=str_replace(' ','',$_POST['prix_a']);
 $qte=str_replace(' ','',$_POST['qte']);
 $stock_ini=str_replace(' ','',$_POST['stock_ini']);
 $code_b=$_POST['code_b'];
 $date_p=$_POST['date_p'];
 $id=$_POST['id_boutique_article'];
 // LOGO DATABASE
$tmp_name_img=$_FILES['imgInp']['tmp_name'];

$ext_img=pathinfo($tmp_name_img,PATHINFO_EXTENSION);

$data=file_get_contents($tmp_name_img);

$img_base64=base64_encode($data);
if($_FILES['imgInp']['tmp_name']==""){
   $image="";
}else{
$image='data:image/'.$ext_img.';base64,'.$img_base64;
}
// used to store the filename in a variable
 $query= "INSERT INTO article(id_categorie_stock,id_id_article,description_article,prix,prix_a,qte,stock_ini,code_b,date_p,imgInp)VALUES(?,?,?,?,?,?,?,?,?,?)";
 $statement=$db->prepare($query);
$statement->execute(array($id_categorie,$id_id_article,$description_article,$prix,$prix_a,$qte,$stock_ini,$code_b, $date_p, $image));

 $_SESSION['message_add']="Enregistrement effectué avec succés";
 $_SESSION['msg_type_add']="success";
header("location:../page/article.php");

 ?>