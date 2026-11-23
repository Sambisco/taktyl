<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../../include/database.php');
if(isset($_POST['fournisseur'])){
  $id=$_POST['fournisseur'];
  $query="SELECT * FROM fournisseur 
  INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
  WHERE fournisseur.idfournisseur='$id' ";
     $statement=$db->prepare($query);
   $statement->execute();
 $result=$statement->fetchAll();
 $total_row=$statement->rowCount();
   if ( $total_row>0) {
     $data = array();
   foreach($result as $row){
     $data["idfournisseur"]=$row["idfournisseur"];
     $data["id_boutique"]=$row["id_boutique"];
     $data["nomfour"]=$row["nomfour"];
     $data["adressefour"]=$row["adressefour"];
     $data["telephonefour"]=$row["telephonefour"];
     $data["emailfour"]=$row["emailfour"];
     $data["descriptionfour"]=$row["descriptionfour"];
     if($row["imgInfour"] != null)
     {
       $data['imgInfour'] = '<img src="'.$row["imgInfour"].'" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';
       $data['imgInp1'] = '<img src="'.$row["imgInfour"].'"  width="40" height="40" alt="icons8-team-100" />';
     }else{
       $data['imgInfour'] = '<img src="../img/img/image.jpg" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';
 
       $data['imgInp1'] = '<img src="../img/img/image.jpg" width="40" height="40" alt="icons8-team-100" />';
     }
     
   }
   echo json_encode($data);
   }
   else {
     echo "0" ; 
   }
 }
if(isset($_POST['id_champ'])){
 $id_champ=$_POST['id_champ'];
 $id_boutiques=$_POST['id_boutiques'];
 $query="SELECT * FROM fournisseur 
 INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
 WHERE fournisseur.id_id_fournisseur='$id_champ' AND boutique.id_boutique='$id_boutiques'";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["idfournisseur"]=$row["idfournisseur"];
    $data["id_boutique"]=$row["id_boutique"];
    $data["nomfour"]=$row["nomfour"];
    $data["adressefour"]=$row["adressefour"];
    $data["telephonefour"]=$row["telephonefour"];
    $data["emailfour"]=$row["emailfour"];
    $data["descriptionfour"]=$row["descriptionfour"];
    if($row["imgInfour"] != '')
		{
			$data['imgInfour'] = '<img src="../img/img/'.$row["imgInfour"].'" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';
      $data['imgInp1'] = '<img src="../img/img/'.$row["imgInfour"].'"  width="40" height="40" alt="icons8-team-100" />';
		}else{
      $data['imgInfour'] = '<img src="../img/img/image.jpg" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';

      $data['imgInp1'] = '<img src="../img/img/image.jpg" width="40" height="40" alt="icons8-team-100" />';
    }
		
  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
}
  // fetch categorie
  if(!empty($_POST["id_articles"])) 
{
  $id =$_POST['id_articles'];
  $query="SELECT * FROM article 
  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
  WHERE article.id_article='$id' ";
  $statement=$db->prepare($query);
$statement->execute();
$result=$statement->fetchAll();
 foreach($result as $row){
?>
<option value="<?php echo $row["id_categorie_stock"]; ?>"><?php echo $row["categorie_stock"]; ?></option>

   <?php
}
}
?>

