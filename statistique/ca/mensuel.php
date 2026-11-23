<?php
session_start();
include('../../include/database.php');
      if(isset($_POST['mois'])){
      $mois=$_POST['mois'];
      $annee=$_POST['annee'];
      $id=$_POST['id_boutique'];
      $query = "SELECT tva.id_tva,DATE_FORMAT(date,'%M') AS moischeck,DATE_FORMAT(date,'%d-%M-%Y') AS date,SUM(mt_ttc) AS mt_ttc FROM `tva` 
       INNER JOIN client ON client.id_client=tva.id_client 
       INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
       WHERE  boutique.id_boutique='$id' AND DATE_FORMAT(date,'%Y')='$annee' AND DATE_FORMAT(date,'%m')='$mois' GROUP BY DATE_FORMAT(date,'%d-%m-%Y')   ORDER BY DATE_FORMAT(date,'%d-%m-%Y') DESC";
    $result = $db->query($query);
    $data = array();
    foreach($result as $row)
    {
        setlocale(LC_TIME,'fr_FR.utf8');
        $data[] = array(
            'language'		=>	strftime("%d",strtotime($row["date"])),
            'total'			=>	$row["mt_ttc"],
            'color'			=>	'#' . rand(100000, 999999) . ''
        );
    }
    echo json_encode($data);
    }
      ?>