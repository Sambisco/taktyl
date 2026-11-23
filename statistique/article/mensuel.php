<?php
session_start();
include('../../include/database.php');
      if(isset($_POST['id_article'])){
        $id_article=$_POST['id_article'];
      $mois=$_POST['mois'];
      $annee=$_POST['annee'];
      $id=$_POST['id_boutique'];
      $query = "SELECT DATE_FORMAT(date,'%d') AS date,article.id_article,description_article,SUM(vente.total) AS total FROM tva 
      INNER JOIN vente ON tva.id_tva=vente.id_tva 
      INNER JOIN article ON article.id_article=vente.id_article 
      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
      INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
      WHERE boutique.id_boutique='$id' AND DATE_FORMAT(date,'%Y')='$annee' AND DATE_FORMAT(date,'%m')='$mois' AND article.id_article='$id_article' GROUP BY DATE_FORMAT(date,'%d-%m-%Y')";
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