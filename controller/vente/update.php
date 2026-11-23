<?php 
session_start();
include('../../include/database.php');

$id=$_SESSION['id_hotel'];
$id=$_POST['id_tva'];
 $query="DELETE vente FROM vente INNER JOIN tva ON tva.id_tva=vente.id_tva WHERE tva.id_tva=$id";
 $statement=$db->prepare($query);
$statement->execute(array( $id));

 $nom_client = $_POST["nom_client"];
	 $adresse = $_POST["adresse"];
    $telephonec = str_replace(' ','',$_POST["telephonec"]);
	$emailc = $_POST["emailc"];
	 $id_client = $_POST["id_client"];
	$statc = $db->prepare("UPDATE client SET nom_client=:nom_client,adresse=:adresse, telephonec=:telephonec,emailc=:emailc WHERE id_client=:id_client");
 $statc->execute(array(
		':nom_client'=>$nom_client,
		':adresse'=>$adresse,
		':telephonec'=>$telephonec,
		':emailc'=>$emailc,
		  ':id_client'=>$id_client 
		  ));
  $id_tva = $_POST["id_tva"];
	 $mt_ht = $_POST["mt_ht"];
    $mt_tva = $_POST["mt_tva"];
	 $mt_ttc = $_POST["mt_ttc"];
	$stat = $db->prepare("UPDATE tva SET mt_ht=:mt_ht, mt_tva=:mt_tva, mt_ttc=:mt_ttc WHERE id_tva=:id_tva");
 $stat->execute(array(
         ':id_tva'=>$id_tva,
		':mt_ht'=>$mt_ht,
		 ':mt_tva'=>$mt_tva,
		 ':mt_ttc'=>$mt_ttc,
		  ));
		 $id_livraison = $_POST["id_livraison"];
		
         $zone = $_POST["zone"];
	  $tarif = $_POST["tarif"];
	$stat = $db->prepare("UPDATE livraison SET zone=:zone, tarif=:tarif WHERE id_livraison=:id_livraison");
 $stat->execute(array(
		':id_livraison'=>$id_livraison,
		':zone'=>$zone,
		 ':tarif'=>$tarif,
		  ));
		   $id_account = $_POST["id_account"];
	  $montant = $_POST["montant"];
	$stat = $db->prepare("UPDATE `account` SET `montant`=:montant WHERE id_account=:id_account");
 $stat->execute(array(
		':id_account'=>$id_account,
		    ':montant'=>$montant,
		  ));
		  $id_detail_vente = $_POST["id_detail_vente"];
		  $avoir = $_POST["avoir"];
		  $espece_du = $_POST["espece_du"];
		  $espece_rendu = $_POST["espece_rendu"];
		  $mode = $_POST["mode"];
		  $description = $_POST["description"];
		  $stat = $db->prepare("UPDATE detail_vente  SET `avoir`=:avoir, `espece_du`=:espece_du, `espece_rendu`=:espece_rendu, `mode`=:mode,description=:description WHERE id_detail_vente=:id_detail_vente");
	   $stat->execute(array(
	
			  ':id_detail_vente'=>$id_detail_vente,
				  ':avoir'=>$avoir,
				  ':espece_du'=>$espece_du,
				  ':espece_rendu'=>$espece_rendu,
				  ':mode'=>$mode,
				  ':description'=>$description
				));
     for($count=0; $count<$_POST["quantite"]; $count++)
      {
	$id_article = $_POST["id_article"];
	$prix = $_POST["prix"];
	$quantite = $_POST["quantite"];
	$remise = $_POST["remise"];
	$total = $_POST["total"];
	$quant = $_POST["quant"];

$statement = $db->prepare("INSERT INTO `vente`(`id_tva`, `id_article`,prix, `quantite`, `remise`, `total`) VALUES (?, ?,?,?,?,?)");
        $statement->execute(array($id_tva,$id_article[$count],$prix[$count],$quantite[$count],$remise[$count],$total[$count]));
		
		$statement = $db->prepare("UPDATE `article` SET qte=:quant WHERE id_article=:id_article");
        $statement->execute(array(
		':id_article'=>$id_article[$count],
		   ':quant'=>$quant[$count]
		
		 
		 ));
		$_SESSION['message_update']="Modification effectuée avec succés.";
 $_SESSION['msg_type_update']="warning";
		  header("location:../page/vente.php");
      }
      ?>