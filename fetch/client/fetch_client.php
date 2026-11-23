<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../include/database.php');
$id_client = $_POST['id_client'];
$query = "SELECT * FROM client
                     INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                      WHERE  client.id_client='$id_client'";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
if ($total_row > 0) {
    $data = array();
    foreach ($result as $row) {
        $data["id_client"] = $row["id_client"];
        $data["nom_client"] = $row["nom_client"];
        $data["telephonec"] = $row["telephonec"];
        $data["adresse"] = $row["adresse"];
        $data["emailc"] = $row["emailc"];
        $data["desc_categ_client"] = $row["desc_categ_client"];
    }
    echo json_encode($data);
} else {
    echo "0";
}
// fetch categorie


?>