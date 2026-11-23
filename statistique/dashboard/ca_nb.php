<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  $timezone = "UTC";
  date_default_timezone_set($timezone);
//data.php

include('../../include/database.php');

if(isset($_POST["boutique_s"]))
	{
		$boutique_s=$_POST["boutique_s"];
		$annee =date('Y');
		$query = "SELECT DATE_FORMAT(`date`,'%M') AS date , SUM(mt_ttc) AS total FROM tva 
		INNER JOIN client ON client.id_client=tva.id_client 
			INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
        WHERE DATE_FORMAT(`date`,'%Y')='$annee' AND boutique.id_boutique='$boutique_s'  GROUP BY  DATE_FORMAT(`date`,'%m-%Y')
		";
		$result = $db->query($query);
		$data = array();
		foreach($result as $row)
		{
			setlocale(LC_TIME,'fr_FR.utf8');
			$data[] = array(
				'language'		=>	strftime("%B",strtotime($row["date"])),
				'total'			=>	$row["total"],
				'color'			=>	'#' . rand(100000, 999999) . ''
			);
		}
		echo json_encode($data);
	}
	else if(isset($_POST["boutique_n"]))
	{
		$boutique_n=$_POST["boutique_n"];
		$annee =date('Y');
		$query = "SELECT DATE_FORMAT(`date`,'%M') AS date , COUNT(id_tva) AS total FROM tva 
		INNER JOIN client ON client.id_client=tva.id_client 
			INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
        WHERE DATE_FORMAT(`date`,'%Y')='$annee' AND boutique.id_boutique='$boutique_n'  GROUP BY DATE_FORMAT(`date`,'%m-%Y')
		";
		$result = $db->query($query);
		$data = array();
		foreach($result as $row)
		{
			setlocale(LC_TIME,'fr_FR.utf8');
			$data[] = array(
				'language'		=>	strftime("%B",strtotime($row["date"])),
				'total'			=>	$row["total"],
				'color'			=>	'#' . rand(100000, 999999) . ''
			);
		}
		echo json_encode($data);
	}else{
		// fetch all
	if($_POST["action"])
			{
		 if($_POST["action"] == 'somme')
		{ 
			$mail =$_POST['mail'];
			$annee =date('Y');
			$query = "SELECT nomb , SUM(mt_ttc) AS total FROM tva 
			INNER JOIN client ON client.id_client=tva.id_client 
			INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
			INNER JOIN user ON user.iduser=boutique.iduser
			WHERE DATE_FORMAT(`date`,'%Y')='$annee' AND user.login='$mail' OR user.telephone_user='$mail' GROUP BY boutique.id_boutique
			";
			$result = $db->query($query);
			$data = array();
			foreach($result as $row)
			{
				$data[] = array(
					'language'		=>	$row["nomb"],
					'total'			=>	$row["total"],
					'color'			=>	'#' . rand(100000, 999999) . ''
				);
			}
			echo json_encode($data);
		}else  if($_POST["action"] == 'nombre')
		{
			$mail =$_POST['mail'];
			$annee =date('Y');
			$query = "SELECT nomb , COUNT(id_tva) AS total FROM tva 
			INNER JOIN client ON client.id_client=tva.id_client 
			INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
			INNER JOIN user ON user.iduser=boutique.iduser

			WHERE DATE_FORMAT(`date`,'%Y')='$annee' AND user.login='$mail' OR user.telephone_user='$mail' GROUP BY boutique.id_boutique
			";
			$result = $db->query($query);
			$data = array();
			foreach($result as $row)
			{
				$data[] = array(
					'language'		=>	$row["nomb"],
					'total'			=>	$row["total"],
					'color'			=>	'#' . rand(100000, 999999) . ''
				);
			}
			echo json_encode($data);
		}
	}
}
?>