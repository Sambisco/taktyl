<!-- Topbar Search -->
<?php include('../../include/database.php'); 
session_start();
for ($count = 0; $count < $_POST["desc_categ_client"]; $count++) {
	$id_boutique = $_POST['id_boutique'];
	$nom_client = $_POST['nom_client'];
	$telephonec = $_POST['telephonec'];
	$adresse = $_POST['adresse'];
	$emailc = $_POST['emailc'];
	$desc_categ_client = $_POST['desc_categ_client'];
	$query = "INSERT INTO client (id_boutique,nom_client,telephonec,adresse,emailc,desc_categ_client) VALUES(?,?,?,?,?,?)";
	$statement = $db->prepare($query);
	$statement->execute(array($id_boutique, $nom_client[$count], $telephonec[$count], $adresse[$count], $emailc[$count], $desc_categ_client[$count]));

$_SESSION['message_add'] = "Enregistrement effectué avec succés";
$_SESSION['msg_type_add'] = "success";
}
header("location:../page/client");

?>