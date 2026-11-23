<!-- Topbar Search -->
<?php include('../../include/database.php'); ?>
<?php
session_start();
for ($count = 0; $count < $_POST["descriptionfour"]; $count++) {
	$id = $_POST['id_boutique'];

	$query = "SELECT MAX(id_id_fournisseur)+1 AS num FROM fournisseur INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique WHERE boutique.id_boutique='$id' ORDER BY idfournisseur DESC";

	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	if ($result["num"] == null) {
		$id_id_fournisseur= "1";
	} else {
		$id_id_fournisseur =$result["num"];
	}
$id_boutique = $_POST['id_boutique'];
	$nomfour = $_POST['nomfour'];
	$adressefour = $_POST['adressefour'];
	$telephonefour = $_POST['telephonefour'];
	$emailfour = $_POST['emailfour'];
	$descriptionfour = $_POST['descriptionfour'];

	$query = "INSERT INTO fournisseur(id_id_fournisseur,nomfour,adressefour,telephonefour,emailfour,descriptionfour,id_boutique)VALUES(?,?,?,?,?,?,?)";
	$statement = $db->prepare($query);
	$statement->execute(array($id_id_fournisseur, $nomfour[$count], $adressefour[$count], $telephonefour[$count], $emailfour[$count], $descriptionfour[$count], $id_boutique));
$_SESSION['message_add'] = "Enregistrement effectué avec succés";
$_SESSION['msg_type_add'] = "success";
}
header("location:../page/fournisseur");

?>