<?php
session_start();
include('../../include/database.php');
      if(isset($_POST['id_article'])){
        $id_article=$_POST['id_article'];
      $annee=$_POST['annee'];
      $id=$_POST['id_boutique'];
      $query = "SELECT DATE_FORMAT(reception.date,'%M') AS date,DATE_FORMAT(reception.date,'%M-%Y')AS dateM,article.id_article,categorie_stock,SUM(detail_reception.prix * detail_reception.quantite) AS total FROM detail_reception 
      INNER JOIN article ON article.id_article=detail_reception.id_article
INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
INNER JOIN reception ON reception.id_reception=detail_reception.id_reception 
INNER JOIN commande ON commande.id_commande=reception.id_commande 
INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
      WHERE boutique.id_boutique='$id' AND DATE_FORMAT(reception.date,'%Y')='$annee' AND article.id_article='$id_article' GROUP BY DATE_FORMAT(reception.date,'%m-%Y') ";
    $result = $db->query($query);
    $data = array();
    foreach($result as $row)
    {
        setlocale(LC_TIME,'fr_FR.utf8');
        $data[] = array(
            'language'	=>	strftime("%B", strtotime($row["date"])),
            'total'			=>	$row["total"],
            'color'			=>	'#' . rand(100000, 999999) . ''
        );
    }
    echo json_encode($data);
    }
      ?>