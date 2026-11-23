<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
  $timezone = "UTC";
  date_default_timezone_set($timezone);
}
include('../../include/database.php');
if(isset($_POST['id_article'])){
 $id=$_POST['id_article'];
 $query="SELECT * FROM article 
 INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
 INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
 WHERE article.id_article='$id' ";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_article"]=$row["id_article"];
    $data["id_boutique"]=$row["id_boutique"];
    $data["id_categorie_stock"]=$row["id_categorie_stock"];
    $data["categorie_stock"]=$row["categorie_stock"];
    $data["description_article"]=$row["description_article"];
    $data["prix"]=$row["prix"];
    $data["prix_v"]=number_format($row["prix"], 0, ",", " ");
    $data["prix_a"]=number_format($row["prix_a"], 0, ",", " ");
    $data["qte"]=$row["qte"];
    $data["stock_ini"]=$row["stock_ini"];
    $data["code_b"]=$row["code_b"];
      $data["date_p"] = $row["date_p"];
    if($row["imgInp"] != null)
		{
			$data['imgInp'] = '<img src="'.$row["imgInp"].'" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';
      $data['imgInp1'] = '<img src="'.$row["imgInp"].'"  width="30" height="20" alt="icons8-team-100" />';
		}else{
      $data['imgInp'] = '<img src="../img/img/image.jpg" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';

      $data['imgInp1'] = '<img src="../img/img/image.jpg" width="30" height="20" alt="icons8-team-100" />';
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
  $query="SELECT * FROM article 
  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
  WHERE article.id_id_article='$id_champ' AND boutique.id_boutique='$id_boutiques'";
     $statement=$db->prepare($query);
   $statement->execute();
 $result=$statement->fetchAll();
 $total_row=$statement->rowCount();
   if ( $total_row>0) {
     $data = array();
   foreach($result as $row){
     $data["id_article"]=$row["id_article"];
     $data["id_boutique"]=$row["id_boutique"];
     $data["id_categorie_stock"]=$row["id_categorie_stock"];
     $data["id_id_article"]=$row["id_id_article"];
     $data["categorie_stock"]=$row["categorie_stock"];
     $data["description_article"]=$row["description_article"];
     $data["prix"]=$row["prix"];
     $data["prix_v"]=number_format($row["prix"], 0, ",", " ");
     $data["prix_a"]=number_format($row["prix_a"], 0, ",", " ");
     $data["qte"]=$row["qte"];
     $data["stock_ini"]=$row["stock_ini"];
     $data["code_b"]=$row["code_b"];
     if($row["imgInp"] != '')
     {
       $data['imgInp'] = '<img src="../img/img/'.$row["imgInp"].'" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';
       $data['imgInp1'] = '<img src="../img/img/'.$row["imgInp"].'"  width="30" height="20" alt="icons8-team-100" />';
     }else{
       $data['imgInp'] = '<img src="../img/img/image.jpg" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';
 
       $data['imgInp1'] = '<img src="../img/img/image.jpg" width="30" height="20" alt="icons8-team-100" />';
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

if(isset($_POST["id_categorie"])) 
{
  $id_categorie =$_POST['id_categorie'];
  $query="SELECT * FROM article 
  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
  WHERE categorie_stock.id_categorie_stock='$id_categorie' ";
  $statement=$db->prepare($query);
$statement->execute();
$result=$statement->fetchAll();
?>
<option value="">Selectionnez article</option>
<?php

 foreach($result as $row){
?>
<option value="<?php echo $row["id_article"]; ?>"><?php echo $row["description_article"]; ?></option>

   <?php
}
}
?>

