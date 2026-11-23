<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
	$timezone = "UTC";
	date_default_timezone_set($timezone);
}
include('../../include/database.php');
if(isset($_POST['id_categorie'])){
	$id = $_POST['id_categorie'];
	$query = "SELECT *,DATE_FORMAT(date_p,'%d/%m/%Y') AS date_pp FROM article 
 INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
 INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
 WHERE article.id_categorie_stock='$id' ";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$response = array();
		$data = array();
		foreach ($result as $row) {
			
			$response["categorie_stock"] = $row["categorie_stock"];
			$response["description_article"] = $row["description_article"];
			$response["prix"] = number_format($row["prix"], 0, ",", " ");
			$response["prix_a"] = number_format($row["prix_a"], 0, ",", " ");
			$response["qte"] = $row["qte"];
			$response["stock_ini"] = $row["stock_ini"];
			$response["code_b"] = $row["code_b"];
			if($row["date_pp"]=="00/00/0000"){
			$response["date_p"] = "";
			}else{
			$response["date_p"] = $row["date_pp"];
			}
			
		array_push($data, $response);
		}
		echo json_encode($data);
	
	}

?>