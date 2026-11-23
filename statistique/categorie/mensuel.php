<?php
session_start();
include('../../include/database.php');
      if(isset($_POST['id_categorie'])){
        $id_categorie=$_POST['id_categorie'];
      $mois=$_POST['mois'];
      $annee=$_POST['annee'];
      $id=$_POST['id_boutique'];
      $query = "SELECT DATE_FORMAT(date,'%d') AS date,categorie_stock.id_categorie_stock,categorie_stock,SUM(vente.total) AS total FROM tva 
      INNER JOIN vente ON tva.id_tva=vente.id_tva 
      INNER JOIN article ON article.id_article=vente.id_article 
      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
      INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
      WHERE boutique.id_boutique='$id' AND DATE_FORMAT(date,'%Y')='$annee' AND DATE_FORMAT(date,'%m')='$mois' AND categorie_stock.id_categorie_stock='$id_categorie' GROUP BY DATE_FORMAT(date,'%d-%m-%Y')";
    $result = $db->query($query);
    $data = array();
    foreach($result as $row)
    {
        setlocale(LC_TIME,'fr_FR.utf8');
        $data[] = array(
            'language'		=>	$row["date"],
            'total'			=>	$row["total"],
            'color'			=>	'#' . rand(100000, 999999) . ''
        );
    }
    echo json_encode($data);
    }
      ?>