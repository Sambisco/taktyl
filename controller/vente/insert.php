<?php 
session_start();
include('../../include/database.php');

	$id=$_POST['id_boutique'];
   
  
		$id_client = $_POST["id_client"];
		$queryP = "SELECT * FROM valide_carte 
		INNER JOIN client ON client.id_client=valide_carte.id_client
		INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
		WHERE client.id_client='$id_client' ";
	$statementP = $db->prepare($queryP);
	$statementP->execute();
	$resultP = $statementP->fetch();
	$point=$resultP['deduire'];
	$query="UPDATE valide_carte SET point=point-'$point'  WHERE id_client='$id_client'";
	$statement=$db->prepare($query);
   $statement->execute(array($point));

    if ($_POST["id_client"]){
	  $num = $_POST["num"];
	  $date = $_POST["date"];
	 $mt_ht = $_POST["mt_ht"];
    $mt_tva = $_POST["mt_tva"];
	 $mt_ttc = $_POST["mt_ttc"];
	 $iduser = $_POST["iduser"];
	 $stat = $db->prepare("INSERT INTO `tva`( `num`, `date`,`id_client`, `mt_ht`, `mt_tva`, `mt_ttc`) VALUES(?,?,?,?,?,?)");
	 $stat->execute(array( $num, $date,$id_client,$mt_ht,$mt_tva,$mt_ttc));
	 $stat = $db->prepare("SELECT  MAX(tva.id_tva) AS id_tva FROM `tva` 
	 INNER JOIN client ON client.id_client=tva.id_client 
	 INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
	 WHERE  boutique.id_boutique='$id'");
	 $stat->execute();
	 $result = $stat->fetch();
	 $id_tva=$result['id_tva'];
	 if($_POST['id_carte']==""){

	 }else{
		$stat = $db->prepare("INSERT INTO `vente_carte`(`id_tva`) VALUES(?)");
		$stat->execute(array( $id_tva));
	 }
	 $zone = $_POST["zone"];
	  $tarif = $_POST["tarif"];
	$stat = $db->prepare("INSERT INTO `livraison`(`id_tva`,`zone`, `tarif`) VALUES(?,?,?)");
 $stat->execute(array($id_tva,$zone,$tarif));
		  
	  $montant = $_POST["montant"];
	$stat = $db->prepare("INSERT INTO `account`( `id_tva`, `montant`) VALUES(?,?)");
 $stat->execute(array($id_tva,$montant));

          $avoir = $_POST["avoir"];
		  $espece_du = $_POST["espece_du"];
		  $espece_rendu = $_POST["espece_rendu"];
		  $mode = $_POST["mode"];
		  $description = $_POST["description"];
		  $stat = $db->prepare("INSERT INTO `detail_vente`( `id_tva`, `avoir`, `espece_du`, `espece_rendu`, `mode`,description) VALUES (?,?,?,?,?,?)");
	   $stat->execute(array($id_tva,$avoir,$espece_du,$espece_rendu,$mode,$description));
	   if($_POST['iduser']==""){

	   }else{
		  $stat = $db->prepare("INSERT INTO vente_user(id_tva,id_sub_users) VALUES(?,?)");
		  $stat->execute(array($id_tva,$iduser));
	   }
      for($count=0; $count<$_POST["quantite"]; $count++)
      {
      
	$id_article = $_POST["id_article"];
	$prix = $_POST["prix"];
	$quantite = $_POST["quantite"];
	$quant = $_POST["quant"];
	$remise = $_POST["remise"];
	$total = $_POST["total"];
	
$statement = $db->prepare("INSERT INTO `vente`(`id_tva`, `id_article`,prix, `quantite`, `remise`, `total`) VALUES (?,?,?, ?, ?,?)");
$statement->execute(array($id_tva,$id_article[$count],$prix[$count],$quantite[$count],$remise[$count],$total[$count]
		 
		 ));
		 $statement = $db->prepare("UPDATE `article` SET qte=:quant WHERE id_article=:id_article");
		 $statement->execute(array(
		 ':id_article'=>$id_article[$count],
			':quant'=>$quant[$count]
		 
		  
		  ));

		$_SESSION['message_add']="Enregistrement effectué avec succés";
		$_SESSION['msg_type_add']="success";
		  header("location:../page/vente.php");
      }

	}else{
	 $nom_client = $_POST["nom_client"];
	 $adresse = $_POST["adresse"];
    $telephonec = str_replace(' ','',$_POST["telephonec"]);
	$email = $_POST["emailc"];
	 $id_boutique = $_POST["id_boutique"];
	 
	$statc = $db->prepare("INSERT INTO `client`( `nom_client`, `adresse`, `telephonec`,emailc,`id_boutique`) VALUES(?, ?, ?,?, ?)");
 $statc->execute(array($nom_client,$adresse,$telephonec,$email,$id_boutique 
		  ));
		  $stat = $db->prepare("SELECT  MAX(client.id_client) AS id_client FROM `client` 
		  INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
		  WHERE  boutique.id_boutique='$id'");
		  $stat->execute();
		  $result = $stat->fetch();
			$id_client=$result['id_client'];
		
	  $num = $_POST["num"];
	  $date = $_POST["date"];
	 $mt_ht = $_POST["mt_ht"];
    $mt_tva = $_POST["mt_tva"];
	 $mt_ttc = $_POST["mt_ttc"];
	 $iduser = $_POST["iduser"];
	$stat = $db->prepare("INSERT INTO `tva`( `num`, `date`,`id_client`, `mt_ht`, `mt_tva`, `mt_ttc`) VALUES(?,?, ?,?,?,?)");
 $stat->execute(array( $num, $date,$id_client,$mt_ht,$mt_tva,$mt_ttc));
 
 $stat = $db->prepare("SELECT  MAX(tva.id_tva) AS id_tva FROM `tva` 
	 INNER JOIN client ON client.id_client=tva.id_client 
	 INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
	 WHERE  boutique.id_boutique='$id'");
	 $stat->execute();
	 $stat->execute();
	 $result = $stat->fetch();
	 $id_tva=$result['id_tva'];

	 $zone = $_POST["zone"];
	  $tarif = $_POST["tarif"];
	$stat = $db->prepare("INSERT INTO `livraison`(`id_tva`,`zone`, `tarif`) VALUES(?,?, ?)");
 $stat->execute(array($id_tva,$zone,$tarif));
		  
	  $montant = $_POST["montant"];
	$stat = $db->prepare("INSERT INTO `account`( `id_tva`, `montant`) VALUES(?,?)");
 $stat->execute(array($id_tva,$montant ));
		 
 $avoir = $_POST["avoir"];
		  $espece_du = $_POST["espece_du"];
		  $espece_rendu = $_POST["espece_rendu"];
		  $mode = $_POST["mode"];
		  $description = $_POST["description"];
		  $stat = $db->prepare("INSERT INTO `detail_vente`( `id_tva`, `avoir`, `espece_du`, `espece_rendu`, `mode`,description) VALUES (?,?,?,?,?,?)");
	   $stat->execute(array($id_tva,$avoir,$espece_du,$espece_rendu,$mode,$description
				));
				if($_POST['iduser']==""){

				}else{
				   $stat = $db->prepare("INSERT INTO vente_user(id_tva,id_sub_users) VALUES(?,?)");
				   $stat->execute(array($id_tva,$iduser));
				}

      for($count=0; $count<$_POST["quantite"]; $count++)
      {

	$id_article = $_POST["id_article"];
	$prix = $_POST["prix"];
	$quantite = $_POST["quantite"];
	$remise = $_POST["remise"];
	$total = $_POST["total"];
	$quant = $_POST["quant"];

        $statement = $db->prepare("INSERT INTO `vente`(`id_tva`, `id_article`,prix, `quantite`, `remise`, `total`) VALUES (?, ?,?,?, ?, ?)");

        $statement->execute(array($id_tva,$id_article[$count],$prix[$count],$quantite[$count],$remise[$count],$total[$count]));
       
		$statement = $db->prepare("UPDATE `article` SET qte=:quant WHERE id_article=:id_article");
        $statement->execute(array(
		':id_article'=>$id_article[$count],
		   ':quant'=>$quant[$count]
		
		 
		 ));
		
		 $_SESSION['message_add']="Enregistrement effectué avec succés";
		 $_SESSION['msg_type_add']="success";
		  header("location:../page/vente.php");
      }
	}
	
		
	
 