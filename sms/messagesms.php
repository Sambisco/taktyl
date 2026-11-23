<?php
session_start();
include('../include/database.php');
if (isset($_GET['id_categorie_sms'])) {
    $id_categorie_sms = $_GET['id_categorie_sms']; 
    $description_sms = $_GET['description_sms']; 
    $savesms = $_GET['savesms']; 
    $date = date('Y-m-d H:i:s');
    $querysave = "INSERT INTO `message` ( `id_categorie_client`, `date`, `message`) VALUES (?,?,?)";
    $statement = $db->prepare($querysave);
    $statement->execute(array($id_categorie_sms,$date,$savesms));

    $sql = "SELECT * FROM add_client_categorie 
    INNER JOIN  client ON client.id_client=add_client_categorie.id_client
    INNER JOIN categorie_client ON categorie_client.id_categorie_client=add_client_categorie.id_categorie_client
    INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
     WHERE categorie_client.id_categorie_client ='$id_categorie_sms'";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result=$statement->fetchAll();
    $accountid='TAKTYL';
    $password='4sZXfDeHL5';
    $hmac = "2521e323022313f9f037c5251fdb722308f38986f77b71c41954f15f42efd8ca" ;
    $urlapi='https://lampush-tls.lafricamobile.com/api';
foreach ($result as $row) {
    if($row["telephonec"]==""){

    }else{
        $to=$row["telephonec"];
    }
$sender=$row["nomb"];
$text=$_GET['description_sms'];
$text=urlencode($text);
$full_url_called=$urlapi.'?'."accountid=$accountid&password=$password&hmac=$hmac"
."&text=$text"
."&to=$to"
."&sender=$sender" ;
print "$full_url_called\n";
$result=file_get_contents($full_url_called);
print "\nresult=";
print_r($result);
print "\n-­­-­­-­­-­­\n";
}

}
?>