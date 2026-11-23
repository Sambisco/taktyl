<!-- Topbar Search -->
<?php include('../../include/database.php'); ?>
<?php
session_start();
for ($count = 0; $count < $_POST["nom_categorie_client"]; $count++) {
	$id = $_POST['id_boutique'];

	$query = "SELECT MAX(id_id_categorie_client)+1 AS num FROM categorie_client INNER JOIN boutique ON boutique.id_boutique=categorie_client.id_boutique WHERE boutique.id_boutique='$id' ORDER BY id_categorie_client DESC";

	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	if ($result["num"] == null) {
		$id_id_categorie_client= "1";
	} else {
		$id_id_categorie_client =$result["num"];
	}
$id_boutique = $_POST['id_boutique'];
	$nom_categorie_client = $_POST['nom_categorie_client'];
	$query = "INSERT INTO categorie_client(id_boutique,id_id_categorie_client,nom_categorie_client)VALUES(?,?,?)";
	$statement = $db->prepare($query);
	$statement->execute(array($id_boutique, $id_id_categorie_client, $nom_categorie_client[$count]));
$_SESSION['message_add'] = "Enregistrement effectué avec succés";
$_SESSION['msg_type_add'] = "success";
}
header("location:../page/categorie_client");

?>