<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if(isset($_SESSION['email'])){
include('../include/script.php');
include('../include/phpqrcode/qrlib.php');
include('../include/database.php');
include('../include/css.php');
include('../include/config.php');

?>

<style>
  
   @media screen and (orientation:landscape) {
       /* Landscape styles */
   }
.content{
    border: solid 1px #000;
    width: 500px;
    margin-top: 30px;
    padding-left: 10px;
    padding-top: 10px;
    border-radius: 10px;
background-color: #000;}
.head{
    width: 479px;
    font-size: 12px;
    padding-top: 3px;
    padding-right: 5px;
    padding-bottom: 3px;
    text-align: right;
    background-color: rgb(179, 116, 0);
color: #fff;
}
.divpn{
    width: 479px;
}
.divpn1{
    width: 100px; 
    height: 90px;
    float: left;
    margin-left: 20px;
margin-top: -40px;
z-index: 1;
}
.divpn2{
    border: solid 1px #000;
    width: 280px; 
    float: left;
    padding-left: 10px;
    padding-top: 0px;
}
.titre {
    color: rgb(179, 116, 0);
    font-size: 15px;
}
.paragraph {
    font-size: 13px;
    margin-top: 0px;
    color: burlywood;
}
.logo{
    border: solid 1px #000;
    width: 60px; 
    height: 40px;
    float: left;
}
.divref{
    border: solid 1px #000;
    width: 488px; 
    display: flex;
margin-top: 5px;
}
.divref1{
    border: solid 1px #000;
    width: 125px; 
    margin-top: 10px;

}
.divref2{
    margin-top: 10px;
    border: solid 1px #000;
    width: 285px; 
    padding-left: 10px;

}
.divref3{
    border: solid 1px #000;
    width: 75px; 
}
.signature{
    text-align: right;
    margin-right: 20px;
    color:burlywood;
}
.bande{
    background-color:  rgb(179, 116, 0);
     height: 30px;
     margin-bottom: 10px;
     width: 479px;
}  
</style>

 <!-- Container Fluid-->
<?php 
 if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $id = encryptor('decrypt',$id);
  
  }

  if (isset($_GET['id_client']) && !empty($_GET['id_client'])) {
    $id_client = $_GET['id_client'];
    $id_client = encryptor('decrypt',$id_client);
  
  }
  
?>
                <?php

    $query = "SELECT * FROM `client`
                     INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                      WHERE  client.id_client='$id_client'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    $queryP = "SELECT DATE_FORMAT(datefin,'%m/%Y') AS datefin,point FROM valide_carte 
    INNER JOIN client ON client.id_client=valide_carte.id_client
    INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
    WHERE client.id_client='$id_client' ";
$statementP = $db->prepare($queryP);
$statementP->execute();
$resultP = $statementP->fetch();
?>
                <div class="content">
<!-----------HEAD----------->
<div class="head">
<div>CARTE DE FIDELITÉ</div>
<div ><?php echo $result['nomb'] ?></div>
<div ><?php echo $result['lieu'] ?></div>
<div ><?php echo $result['telephone'] ?></div>
<div ><?php echo $result['email'] ?></div>
<div><?php echo $result['web'] ?></div>
<div><?php echo $result['ninea'] ?></div>
</div>
<!-----------FIN HEAD----------->
<!-----------photo AND nom----------->
<div class="divpn">
<div class="divpn1">
<?php
$text=$result['id_client'];
$folder="../img/codeQR/";
$file_name="qr.png";
$file_name=$folder.$file_name;
QRcode::png($text,$file_name);
echo'<img src="../img/codeQR/qr.png" style="width:100px;height:90px;">';
//To Display Code Without Storing
            ?>  
</div>
<div class="divpn2">
<div class="titre" style="margin-top: 5px;"><?php echo $result['nom_client'] ?></div>
<div class="paragraph">Client fidéle</div>
</div>
<div class="divpn3">
<img src="../img/logo/<?php echo $result['logo'] ?>" class="logo">
</div>
</div>
<!-----------fin photo AND nom----------->
<!-----------reference----------->
<div class="divref">
<div class="divref1">
<div class="titre">ID</div>
<div class="paragraph"><?php echo $result['id_client'] ?></div>
<div class="titre">Telephone</div>
<div class="paragraph"><?php echo $result['telephonec'] ?></div>
</div>
<div class="divref2">
<div class="titre">Adresse</div>
<div class="paragraph"><?php echo $result['adresse'] ?></div>
<div class="titre">Email</div>
<div class="paragraph"><?php echo $result['emailc'] ?></div>
</div>
<div class="divref3">
<div class="titre">Expire</div>
<div class="paragraph"><?php  if($resultP['datefin']==null){ echo "00/0000";}else{ echo $resultP['datefin'];} ?></div>
</div>
</div>
<!-----------fin reference----------->
<!-----------signature----------->
<div class="signature">Signature</div>
<!-----------fin signature----------->
<!-----------Bande----------->
<div class="bande"></div>
<!-----------fin bande----------->
</div>
<div id="previewImg" style="text-align: center;margin-top: 30px;height: 400px;"></div>
<div style="text-align: center;margin-top: -30px;margin-bottom: 100px;">
<button class="btn btn-primary" id="telecharger">Telecharger</button>
</div>

                
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  
  <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../vendor/labelChart/chartjs-plugin-datalabels@0.7.js"></script>
  <!-- Page level custom scripts -->
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script>
  <script src="../js/demo/chart-bar-demo.js"></script>
       
        <!---Container Fluid-->
        <script>
    
    image();
    function image(){
    var element = $(".content"); // global variable
var getCanvas; // global variable

         html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImg").append(canvas); 
				getCanvas = canvas;
                $(".content").hide()
             }
         });
         var node = document.getElementById('previewImg');
    var btn = document.getElementById('telecharger');

    btn.onclick = function() {
      domtoimage.toBlob(document.getElementById('previewImg')).then(function(blob) {
        window.saveAs(blob, 'Carte-fidelité.png')
      })
    }
}
</script>
<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
  header("Location:../");
}
?>
      