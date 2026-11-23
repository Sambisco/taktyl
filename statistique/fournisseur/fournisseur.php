<?php
session_start();
include('../../include/database.php');
if(isset($_POST['idfournisseur'])){
    $idfournisseur=$_POST['idfournisseur'];
    $annee=$_POST['annee'];
    $mois=$_POST['mois'];
    $id=$_POST['id_boutique'];
      $query = "SELECT description_article,DATE_FORMAT(reception.date,'%d-%M-%Y') AS date,SUM(detail_reception.prix * detail_reception.quantite) AS prix FROM `detail_reception` 
       INNER JOIN article ON article.id_article=detail_reception.id_article
INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
INNER JOIN reception ON reception.id_reception=detail_reception.id_reception 
INNER JOIN commande ON commande.id_commande=reception.id_commande 
INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
WHERE boutique.id_boutique='$id' AND DATE_FORMAT(reception.date,'%Y')='$annee' AND DATE_FORMAT(reception.date,'%m')='$mois' AND fournisseur.idfournisseur='$idfournisseur'GROUP BY article.id_article ";
    $result = $db->query($query);
    $data = array();
    foreach($result as $row)
    {
        setlocale(LC_TIME,'fr_FR.utf8');
        $data[] = array(
            'language'		=>	$row["description_article"],
            'total'			=>	$row["prix"],
            'color'			=>	'#' . rand(100000, 999999) . ''
        );
    }
    echo json_encode($data);
    }
      ?>