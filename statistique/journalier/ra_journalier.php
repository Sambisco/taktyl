<?php
session_start();
include('../../include/database.php');
      if(isset($_POST['date'])){
        $date=$_POST['date'];
      $mois=$_POST['mois'];
      $annee=$_POST['annee'];
      $id=$_POST['id_boutique'];
      $query = "SELECT DATE_FORMAT(reception.date,'%d-%M-%Y') AS date,article.id_article,description_article,COUNT(article.id_article) AS total FROM detail_reception 
     INNER JOIN article ON article.id_article=detail_reception.id_article
INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
INNER JOIN reception ON reception.id_reception=detail_reception.id_reception 
INNER JOIN commande ON commande.id_commande=reception.id_commande 
INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
      WHERE boutique.id_boutique='$id' AND DATE_FORMAT(reception.date,'%Y')='$annee' AND DATE_FORMAT(reception.date,'%m')='$mois' AND DATE_FORMAT(reception.date,'%d')='$date' GROUP BY article.id_article,DATE_FORMAT(reception.date,'%d')";
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