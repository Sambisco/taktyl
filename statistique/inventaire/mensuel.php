<?php
session_start();
include('../../include/database.php');
      if(isset($_POST['mois'])){
      $mois=$_POST['mois'];
      $annee=$_POST['annee'];
      $id=$_POST['id_boutique'];
      $query = "SELECT reception.id_reception,DATE_FORMAT(reception.date,'%M') AS moischeck,DATE_FORMAT(reception.date,'%d-%M-%Y') AS date,SUM(detail_reception.prix * detail_reception.quantite) AS prix FROM `reception` 
       INNER JOIN detail_reception ON reception.id_reception=detail_reception.id_reception
INNER JOIN commande ON commande.id_commande=reception.id_commande
INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur
INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
       WHERE  boutique.id_boutique='$id' AND DATE_FORMAT(reception.date,'%Y')='$annee' AND DATE_FORMAT(reception.date,'%m')='$mois' GROUP BY DATE_FORMAT(reception.date,'%d-%m-%Y')   ORDER BY DATE_FORMAT(reception.date,'%d-%m-%Y') DESC";
    $result = $db->query($query);
    $data = array();
    foreach($result as $row)
    {
        setlocale(LC_TIME,'fr_FR.utf8');
        $data[] = array(
            'language'		=>	strftime("%d",strtotime($row["date"])),
            'total'			=>	$row["prix"],
            'color'			=>	'#' . rand(100000, 999999) . ''
        );
    }
    echo json_encode($data);
    }
      ?>