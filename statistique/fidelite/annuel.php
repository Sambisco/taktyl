<?php
session_start();
include('../../include/database.php');
if (isset($_POST['annee'])) {
    $annee = $_POST['annee'];
    $id = $_POST['id_boutique'];
    $query = "SELECT tva.id_tva,DATE_FORMAT(date,'%M') AS date,SUM(mt_ttc) AS mt_ttc FROM `tva` 
             INNER JOIN vente_carte ON tva.id_tva=vente_carte.id_tva 
           INNER JOIN client ON client.id_client=tva.id_client 
      INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
      WHERE  boutique.id_boutique='$id' AND DATE_FORMAT(date,'%Y')='$annee' GROUP BY DATE_FORMAT(date,'%M')";
    $result = $db->query($query);
    $data = array();
    foreach ($result as $row) {
        setlocale(LC_TIME, 'fr_FR.utf8');
        $data[] = array(
            'language'        =>    strftime("%B", strtotime($row["date"])),
            'total'            =>    $row["mt_ttc"],
            'color'            =>    '#' . rand(100000, 999999) . ''
        );
    }
    echo json_encode($data);
}
