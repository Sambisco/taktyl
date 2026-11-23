<!-- Topbar Search -->
<?php include('../../include/database.php'); ?>
<?php
session_start();
for ($count = 0; $count < $_POST["date_p"]; $count++) {
	$id = $_POST['id_boutique'];

	$query = "SELECT MAX(id_id_article)+1 AS num FROM article 
 INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
 INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
  WHERE boutique.id_boutique='$id'";

	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	if ($result["num"] == null) {
		$id_id_article= "1";
	} else {
		$id_id_article =$result["num"];
	}
	$id_categorie = $_POST['id_categorie'];
	$description_article = $_POST['description_article'];
	$prix = str_replace(' ', '', $_POST['prix']);
	$prix_a = str_replace(' ', '', $_POST['prix_a']);
	$qte = str_replace(' ', '', $_POST['qte']);
	$stock_ini = str_replace(' ', '', $_POST['stock_ini']);
	$code_b = $_POST['code_b'];
	$date_p = $_POST['date_p'];

	$query = "INSERT INTO article(id_categorie_stock,id_id_article,description_article,prix,prix_a,qte,stock_ini,code_b,date_p)VALUES(?,?,?,?,?,?,?,?,?)";
	$statement = $db->prepare($query);
	$statement->execute(array($id_categorie, $id_id_article, $description_article[$count], $prix[$count], $prix_a[$count], $qte[$count], $stock_ini[$count], $code_b[$count], $date_p[$count]));
$_SESSION['message_add'] = "Enregistrement effectué avec succés";
$_SESSION['msg_type_add'] = "success";
}
header("location:../page/article");

?>