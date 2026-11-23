<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../../include/database.php');
if(isset($_POST['id_boutique'])){
 $id=$_POST['id_boutique'];
 $query="SELECT * FROM `boutique` WHERE id_boutique='$id' ";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
  if ( $total_row>0) {
    $data = array();
  foreach($result as $row){
    $data["id_boutique"]=$row["id_boutique"];
    $data["nomb"]=$row["nomb"];
    $data["lieu"]=$row["lieu"];
    $data["telephone"]=$row["telephone"]; 
    $data["email"]=$row["email"];
     $data["web"]=$row["web"]; 
     $data["ninea"]=$row["ninea"];
    if($row["logo"] == null)
		{
      $data['logo'] ="";
		}else{
      $data['logo'] = '<img src="'.$row['logo'].'" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';

    }
    if($row["cachet"] == null)
		{
      $data['cachet'] ="";
		}else{
      $data['cachet'] = '<img src="'.$row['cachet'].'" class="rounded-circle" width="100" height="100" alt="icons8-team-100" />';

    }
		
  }
  echo json_encode($data);
	}
  else {
    echo "0" ; 
  }
}
?>

