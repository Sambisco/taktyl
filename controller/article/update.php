<!-- Topbar Search -->
<?php include('../../include/database.php'); ?>
<?php
session_start();

$id = $_POST['edit_id'];
$id_categorie = $_POST['id_categorie'];
$description_article = $_POST['description_article'];
$prix = str_replace(' ', '', $_POST['prix']);
$prix_a = str_replace(' ', '', $_POST['prix_a']);
$qte = str_replace(' ', '', $_POST['qte']);
$stock_ini = str_replace(' ', '', $_POST['stock_ini']);
$code_b = $_POST['code_b'];
$date_p = $_POST['date_p'];
$id_peremption = $_POST['id_peremption'];
$tmp_name_img=$_FILES['imgInp']['tmp_name'];

$ext_img=pathinfo($tmp_name_img,PATHINFO_EXTENSION);

$data=file_get_contents($tmp_name_img);

$img_base64=base64_encode($data);

$image='data:image/'.$ext_img.';base64,'.$img_base64;

if ($_FILES["imgInp"]["tmp_name"] == "") {
    $query = "UPDATE article SET id_categorie_stock= '$id_categorie',description_article='$description_article',prix='$prix',prix_a='$prix_a',qte='$qte',stock_ini='$stock_ini',code_b='$code_b',date_p='$date_p' WHERE id_article='$id'";
    $statement = $db->prepare($query);
    $statement->execute(array($id_categorie, $description_article, $prix, $prix_a, $qte, $ststock_ini));
    $_SESSION['message_update'] = "Modification effectuée avec succés ";
    $_SESSION['msg_type_update'] = "warning";
    header("location:../page/article.php");
} else {
    $query = "UPDATE article SET id_categorie_stock= '$id_categorie',description_article='$description_article',prix='$prix',qte='$qte',stock_ini='$stock_ini',code_b='$code_b',date_p='$date_p',imgInp='$image' WHERE id_article='$id'";
    $statement = $db->prepare($query);
    $statement->execute(array($id_categorie, $description_article, $prix, $prix_a, $qte, $stock_ini, $image));
}

$_SESSION['message_update'] = "Les modifications ont été effectuées ";
$_SESSION['msg_type_update'] = "warning";
header("location:../page/article.php");


?>