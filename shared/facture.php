<?php
session_start();
include('../include/database.php');
$timezone="UTC"; 
date_default_timezone_set($timezone);
ob_start();
?>
<style type="text/css">
table{
width:100%;
min-width:rem-calc(640);
border-collapse:collapse;
border:#000000;
table-layout:auto;
}
.Style1 {
	color: #FFFFFF;
	font-size: 10px;
}
.Style4 {font-size: 10px}
.Style5 {
	color: #000000;
	font-weight: bold;
}
.Style6 {
	color: #FFFFFF;
	font-weight: bold;
}
.Style8 {color: #FFFFFF}
</style>
<?php
if(isset($_GET['code'])){
    $code=$_GET['code'];
    $hotel_id = $_GET['hotel_id'];
		$id =$_SESSION['id_hotel'];
		$query = "SELECT facture.id_facture, DATE_FORMAT(date,'%d-%m-%Y') AS date, total,paie,acompte,mode,nom_client,client.telephone AS telephonec,adresse,emailc, DATE_FORMAT(datedebut,'%d-%m-%Y') AS datedebut ,DATE_FORMAT(datefin,'%d-%m-%Y') AS datefin ,categorie,montant,jour,num,tarif,imgInp,logo,nomh,lieu,email,reference.telephone,reference.web,reference.ninea FROM facture 
		INNER JOIN client ON client.id_client=facture.id_client 
		INNER JOIN reservation ON facture.id_facture=reservation.id_facture 
		INNER JOIN chambre ON chambre.id_chambre=reservation.id_chambre 
		INNER JOIN categorie ON categorie.id_categorie=chambre.id_categorie 
		INNER JOIN hotel ON hotel.id_hotel=categorie.id_hotel 
		INNER JOIN reference ON hotel.id_hotel=reference.id_hotel
        WHERE  facture.id_facture='$code'
        ";
		$statement=$db->prepare($query);
        $statement->execute();
		  $result=$statement->fetchAll();
		  foreach($result as $row){}
         ?>
         <page backtop="10mm" backleft="5mm" backright="5mm" backbottom="100mn" footer="page">
<page_header>
<table width="100%" border="0">
  <tr>
    <td style="width:50%;text-transform:uppercase;"><strong>Facture et Ticket de reservation</strong></td>
    <td style="width:50%"><div align="right"><strong>Imprimer le :&nbsp;</strong><?php echo date('d/m/Y');?></div></td>
  </tr>
</table>
<hr/>
</page_header>		   
<table width="100%" border="0">
  
  <tr>
     <td rowspan="6" style="width:100px;">
	 <div style="width:100px;height:80px;border:1px solid #000000;padding-right:1px">
	
    <img class="avatar" src="../img/logo/<?php if($row['logo']==null){ ?>boy.png <?php }else{echo $row['logo'];}?>" width="120" height="80" alt="icons8-team-100"/>
			    
	 </div>
  </td>
    <td style="width:58%; padding-left:10px;word-wrap: break-word;font-size: 10px;"><strong>Entreprise :</strong> <?php if($row['nomh']==null){ ?>.........<?php }else{echo $row['nomh'];}?> </td>
    <td rowspan="6" style="width:25%; height:100px;">
	<div style="height:100px; border:0px solid #000000">
	
<table width="100%" border="1" align="right">
  <tr>
    <td style="width:90%;text-transform:uppercase; background:#000000" scope="col"><div align="center" class="Style1" style="background-color:#000000;">emit par:</div></td>
  </tr>
  <tr>
    <td style="width:90%; padding-top: 2px;" height="10"><div align="center" class="Style4"><?php echo $_SESSION['nomuser']; ?></div></td>
  </tr>
</table>

	</div>
	</td>
  </tr>
  <tr>
    <td style="width:50%; padding-left:10px;font-size: 10px;"><strong>Adresse :&nbsp;</strong><?php if($row['lieu']==null){ ?>.........<?php }else{echo $row['lieu'];}?></td>
  </tr>
  <tr>
    <td style="width:50%; padding-left:10px;font-size: 10px;"><strong>Email :&nbsp;</strong><?php if($row['email']==null){ ?>.........<?php }else{echo $row['email'];}?></td>
  </tr>
  <tr>
    <td style="width:50%; padding-left:10px;font-size: 10px;"><strong>Tel :&nbsp;</strong><?php if($row['telephone']==null){ ?>.........<?php }else{echo $row['telephone'];}?></td>
  </tr>
  <tr>
    <td style="width:50%; padding-left:10px;font-size: 10px;">&nbsp;<strong>Web :&nbsp;</strong><?php if($row['web']==null){ ?>.........<?php }else{echo $row['web'];}?></td>
  </tr>
  <tr>
    <td style="width:50%; padding-left:13px;font-size: 10px;"><strong>Ninea :&nbsp;</strong><?php if($row['ninea']==null){ ?>.........<?php }else{echo $row['ninea'];}?></td>
  </tr>
</table>
<hr/>

<table border="0" style="margin-top:0px">
  <tr>
    <td style="width:50%;text-transform:uppercase"><span class="Style5">Facture et Ticket N°&nbsp;00<?php echo $row [ "id_facture" ];?></span></td>
    <td style="width:50%"><div align="right"><strong>Date</strong>:&nbsp;<?php echo $row [ "date" ];?></div></td>
  </tr>
</table>
<table border="1" style="margin-top:0px">
  <tr>
    <td  style="width:40%;height:15px;text-transform:uppercase;background-color:#000000">
    <div align="center" class="Style6">
      CoordonnEes du client
    </div>
</td>
    <td style="width:20%;height:15px; border:0px"></td>
	<td bgcolor="#000000" style="width:40%;height:15px;text-transform:uppercase;background-color:#000000">
    <div align="center" class="Style6">
        CoordonnEes reservation
    </div>
</td>
  </tr>
  <tr>
    <td valign="top" style="width:40%; padding-top: 5px; padding-left: 5px;padding-right: 5px;">
    <table border="0">
        <tr>
            <td style="width: 30%;font-size: 11px;"><strong>Nom client :</strong> </td>
            <td style="width: 70%;text-align: right; font-size: 11px;"><?php echo $row [ "nom_client" ];?></td>
        </tr>
        <tr>
            <td style="width: 30%;font-size: 11px;"><strong>Adresse  :</strong></td>
            <td style="width: 70%;text-align: right;font-size: 11px;"><?php echo $row [ "adresse" ];?></td>
        </tr>
        <tr>
            <td style="width: 30%;font-size: 11px;"><strong>Téléphone  :</strong></td>
            <td style="width: 70%;text-align: right;font-size: 11px;"><?php echo $row [ "telephonec" ];?></td>
        </tr>
        <tr>
            <td style="width: 30%;font-size: 11px;"><strong>Email  :</strong></td>
            <td style="width: 70%;text-align: right;font-size: 11px;padding-bottom: 10px;"><?php echo $row [ "emailc" ];?></td>
        </tr>
    </table>
	</td>
    <td style="width:20%; border-bottom:solid 0px;border-right:solid 0.5px"></td>
	<td valign="top" style="width:40%; padding-top: 5px; padding-left: 5px; padding-right: 5px;" >
    <table border="0">
        <tr>
            <td style="width: 30%;font-size: 11px;"><strong>Date debut :</strong> </td>
            <td style="width: 70%;text-align: right; font-size: 11px;"><?php echo $row [ "datedebut" ];?></td>
        </tr>
        <tr>
            <td style="width: 30%;font-size: 11px;"><strong>Date fin :</strong></td>
            <td style="width: 70%;text-align: right;font-size: 11px;"><?php if($row [ "datefin" ]==null){}else{echo $row [ "datefin" ];}?></td>
        </tr>
        <tr>
            <td style="width: 30%;font-size: 11px;"><strong>Jours  :</strong></td>
            <td style="width: 70%;text-align: right;font-size: 11px;"><?php echo $row [ "jour" ];?></td>
        </tr>
        <tr>
            <td style="width: 30%;font-size: 11px;"><strong>Paiement :</strong></td>
            <td style="width: 70%;text-align: right;font-size: 11px;">
            <?php if($row [ "paie" ]==0){ 
              echo "Impayé";
              }else{
                echo "Payé";
                }?>
          </td>
        </tr>
    </table>
	</td>
  </tr>
</table>
<table border="1">
                     <thead>
                         <tr>
                             <th height="20" valign="middle" bgcolor="#000000" style="width: 68px;height:20px;text-align: center;" class="Style8">#</th>
                             <th height="20" valign="middle" bgcolor="#000000" style="width:15%;height:20px; padding-left: 10px; text-align: center;" class="Style8"><strong>Image</strong></th>
                           <th height="20" valign="middle" bgcolor="#000000"  style="width:38%;height:20px;text-align: center;" class="Style8" ><strong>Categorie</strong></th>
                           <th height="20" valign="middle" bgcolor="#000000"  style="width:20%;height:20px;text-align: center;" class="Style8"><strong>N° Chambre</strong></th>  
                           <th height="20" valign="middle" bgcolor="#000000"  style="width:17%;height:20px;text-align: right;padding-right: 10px;" class="Style8"><strong>Tarif</strong></th>
                         </tr>
                     </thead>
					
                     <tbody>
                     <?php 

					 $count = 0;   
foreach($result as $row){
	$count++;
					 ?>
                         <tr>
                             <td height="20" align="center" valign="middle" ><?php echo $count;?></td>
                             <td height="20" align="center" class="left" style="padding-left: 10px;"><img src="../img/img/<?php if($row['imgInp']==null){ ?>image.jpg <?php }else{echo $row['imgInp'];}?>" width="30" height="20" alt="icons8-team-100" ></td>
                             <td height="20"  align="center" valign="middle" class=" prix"><span ><?php echo $row[ "categorie" ];?></span></td>
                             <td height="20"  align="center" valign="middle" class=" prix"><span ><?php echo $row[ "num" ];?></span></td>
                             <td height="20"   align="right" valign="middle" style="padding-right: 10px;"><?php echo number_format($row[ "tarif" ],0,","," ");?></td>
                         </tr>
                         <?php 
}
?>
                     </tbody>
  </table>
<table border="1" align="right">
    <tr>
        <td style="width:20%;height:20px;text-align: center; border-bottom: #FFFFFF;" bgcolor="#000000" class="Style8"><strong>Acompte</strong></td>
        <td style="width:17%;height:20px;text-align: right;padding-right: 10px;"><?php if($row [ "acompte" ]==0){}else{echo  number_format($row [ "acompte" ],0,","," ");}?></td>
    </tr>
    <tr>
        <td style="width:20%;height:20px;text-align: center;border-bottom: #FFFFFF;" bgcolor="#000000" class="Style8"><strong>Total</strong></td>
        <td style="width:17%;height:20px;text-align: right;padding-right: 10px;"><?php if($row [ "total" ]==null){}else{echo number_format($row [ "total" ],0,","," ");}?></td>
    </tr>
    <tr>
        <td style="width:20%;height:20px;text-align: center;" bgcolor="#000000" class="Style8"><strong>Mode de paiement</strong></td>
        <td style="width:17%;height:20px;text-align: right;padding-right: 10px;"><?php echo $row [ "mode" ];?></td>
    </tr>
</table>
</page>	
	
	<?php
}
    $content = ob_get_clean();

    // convert in PDF
    require('../html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
		$html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('Bulletin.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>