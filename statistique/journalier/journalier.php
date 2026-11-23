<?php
session_start();
include('../../include/database.php');
      if(isset($_POST['date'])){
        $date=$_POST['date'];
      $mois=$_POST['mois'];
      $annee=$_POST['annee'];
      $id=$_POST['id_boutique'];
      $query = "SELECT DATE_FORMAT(date,'%d-%M-%Y') AS date,article.id_article,description_article,COUNT(article.id_article) AS total FROM tva 
      INNER JOIN vente ON tva.id_tva=vente.id_tva 
      INNER JOIN article ON article.id_article=vente.id_article 
      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
      INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
      WHERE boutique.id_boutique='$id' AND DATE_FORMAT(date,'%Y')='$annee' AND DATE_FORMAT(date,'%m')='$mois' AND DATE_FORMAT(date,'%d')='$date' GROUP BY article.id_article,DATE_FORMAT(date,'%d')";
          $result = $db->query($query);
    $data = array();
    foreach($result as $row)
    {
        setlocale(LC_TIME,'fr_FR.utf8');
        $data[] = array(
            'language'		=>	$row["description_article"],
            'total'			=>	$row["total"],
            'color'			=>	'#' . rand(100000, 999999) . ''
        );
    }
    echo json_encode($data);
    }
      ?>