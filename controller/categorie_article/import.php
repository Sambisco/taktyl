<!-- Topbar Search -->
<?php include('../../include/database.php'); ?>
<?php
session_start();
for ($count = 0; $count < $_POST["description_stock"]; $count++) {
	$id = $_POST['id_boutique'];

	$query = "SELECT MAX(id_id_categorie)+1 AS num FROM categorie_stock INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique WHERE boutique.id_boutique='$id' ORDER BY id_categorie_stock DESC";

	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	if ($result["num"] == null) {
		$id_id_categorie= "1";
	} else {
		$id_id_categorie =$result["num"];
	}
$id_boutique = $_POST['id_boutique'];
$categorie_stock = $_POST['categorie_stock'];
$description_stock = $_POST['description_stock'];

$query = "INSERT INTO categorie_stock(id_boutique,id_id_categorie,categorie_stock,description_stock)VALUES(?,?,?,?)";
$statement = $db->prepare($query);
$statement->execute(array($id_boutique, $id_id_categorie, $categorie_stock[$count], $description_stock[$count]));
$_SESSION['message_add'] = "Enregistrement effectué avec succés";
$_SESSION['msg_type_add'] = "success";
}
header("location:../page/categorie_article");

?>