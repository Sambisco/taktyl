<?php
//fetch.php;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  include('../include/database.php');
  if(isset($_POST["view"]))
{
    if($_POST["view"]=='view')
    {
        $id_boutiquess =$_POST['id_boutiquess'];

	$query="SELECT * FROM `article` 
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
    INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
    WHERE qte < stock_ini AND boutique.id_boutique='$id_boutiquess'  ORDER BY article.id_article limit 10";
    $statement=$db->prepare($query);
    $statement->execute();
	if($statement->rowCount() > 0){
	while($row = $statement->fetch(PDO::FETCH_ASSOC)){
    ?>
	<a class="dropdown-item d-flex align-items-center" href="#" >
      <div class="mr-3" >
       <div class="icon-circle bg-primary">
                      <i class="fas fa-cube text-white" style="font-size: 20px;"></i>
                    </div>
                  </div>
                  <div>
                  <div class="small text-gray-500">&nbsp;</div>
                  <strong><?php echo $row['description_article'];?></strong>&nbsp;=>&nbsp;&nbsp;&nbsp;<?php echo $row['qte']?><i class="fa fa-circle" style="color: red; margin-left:200px;font-size:8px;"></i>
     </div>
</a>
<?php
	}
}else{
	echo '<div style="text-align: center;"><a href="#" class="text-bold text-italic">Aucune notification</a></div>';
	}
	}
  
}

if(isset($_POST["count"]))
{
    if($_POST["count"]=='count')
    {
        $id_boutiquess =$_POST['id_boutiquess'];
        $query="SELECT COUNT(*) AS nombre FROM `article` 
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
    INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
    WHERE qte < stock_ini AND boutique.id_boutique='$id_boutiquess' ORDER BY article.id_article DESC";
    $statement=$db->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    $data = array();
    foreach($result as $row){
        $data["nombre"]=$row["nombre"];
    }
    echo json_encode($data);
}
}
?>