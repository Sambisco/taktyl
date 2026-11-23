<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../include/database.php');
$id_client_valide = $_POST['id_client_valide'];
$query = "SELECT *,DATE_FORMAT(datefin,'%m/%Y') AS datefins FROM valide_carte 
INNER JOIN client ON client.id_client=valide_carte.id_client
INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                      WHERE  client.id_client='$id_client_valide'";
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
        $data["id_valide_carte"] = $row["id_valide_carte"];
        $data["id_client"] = $row["id_client"];
        $data["nom_client"] = $row["nom_client"];
        $data["telephonec"] = $row["telephonec"];
        $data["datefin"] = $row["datefin"];
        $data["datefins"] = $row["datefins"];
        $data["point"] = $row["point"];
        $data["deduire"] = $row["deduire"];
    }
    echo json_encode($data);
} else {
    echo "0";
}
// fetch categorie


?>