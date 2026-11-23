
          <!-- Topbar Search -->
          <?php include('../../include/database.php');?>
<?php 
session_start();
$id=$_POST['id_client'];
 $id_categorie_client=$_POST['id_categorie_client'];
$stat = $db->prepare("SELECT * FROM add_client_categorie 
INNER JOIN  client ON client.id_client=add_client_categorie.id_client
INNER JOIN categorie_client ON categorie_client.id_categorie_client=add_client_categorie.id_categorie_client
INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
	 WHERE  client.id_client='$id'");
$stat->execute();
$result = $stat->fetch();

if ($result['id_client'] == null) {
    
        $stat = $db->prepare("INSERT INTO add_client_categorie(id_client,id_categorie_client) VALUES(?,?)");
        $stat->execute(array($id, $id_categorie_client));
} else {
    
        $query = "UPDATE `add_client_categorie` SET`id_categorie_client`='$id_categorie_client' WHERE id_client='$id'";
        $statement = $db->prepare($query);
        $statement->execute(array($id_categorie_client, $id));
   
}

 $_SESSION['message_add']="Enregistrement effectué avec succés";
 $_SESSION['msg_type_add']="success";
header("location:../page/categorie_article");

 ?>