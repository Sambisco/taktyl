<?php
session_start();
include('../../include/database.php');
include('../../include/N2TEXT.php');
include('../../include/config.php');
setlocale(LC_TIME, 'fr_FR.utf8');
$timezone = "UTC";
date_default_timezone_set($timezone);
$imprime=encryptor('decrypt',$_GET['imprime']);

   
    $query = "SELECT num, DATE_FORMAT(date,'%d-%M-%Y') AS date,mt_ht,mt_tva,mt_ttc,description_article,vente.prix AS prix, quantite, remise, total,nom_client, telephonec, adresse, emailc,montant,avoir, espece_du, espece_rendu, mode, description,zone, tarif,nomb, lieu, telephone, email, web, ninea, logo FROM tva 
    INNER JOIN vente ON tva.id_tva=vente.id_tva 
    INNER JOIN account ON tva.id_tva=account.id_tva 
    INNER JOIN livraison ON tva.id_tva=livraison.id_tva 
    INNER JOIN detail_vente ON tva.id_tva=detail_vente.id_tva 
    INNER JOIN article ON article.id_article=vente.id_article 
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
    INNER JOIN client ON client.id_client=tva.id_client 
    INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique        
WHERE tva.id_tva='$imprime'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if ($total_row > 0) {
        foreach ($result as $row) {
        }
   

$output = '';
        $output .='
        <link rel="stylesheet" href="ticket.css">
        <div class="reference">
';
if ($row['logo'] == null) {
    $output .= '
<div class="logo">
<p>logo</p>
</div>
';
} else {
    $output .= '
<div class="logo-photo">
<img src="'. $row["logo"] .'" class="img-logo" alt="">
</div>
';
}
$output .= '
<div class="ref">
';
if ($row['nomb'] == null) {
    $output .= "
<div>Entreprise</div>
";
} else {
    $output .= "
<div>".$row['nomb']."</div>
";
}
if ($row['lieu'] == null) {
    $output .= "
<div>Adresse</div>
";
} else {
    $output .= "
<div>".$row['lieu']."</div>
";
}
if ($row['telephone'] == null) {
    $output .= "
<div>Telephone</div>
";
} else {
    $output .= "
<div>".$row['telephone']."</div>
";
}
if ($row['email'] == null) {
    $output .= "
<div>Email</div>
";
} else {
    $output .= '
<div>'.$row['email'].'</div>
';
}
if ($row['web'] == null) {
    $output .= '
<div>Site web</div>
';
} else {
    $output .= '
<div>'.$row['web'].'</div>
';
}
$output .= '
</div>
</div>
<!-----fin reference---->
<div class="ticket">
ticket
</div>
<div class="num">
<div class="numero">
<strong>N°</strong>'."00".$row['num'].'
</div>
<div class="date">
'.strftime("%d-%B-%Y", strtotime($row["date"])).'
</div>
</div>
<div class="client">
<div class="client1">
<div class="titre">Client</div>
';
if ($row['nom_client'] == null) {
    $output .= '
<div>&nbsp;</div>
';
} else {
    $output .= '
<div>'.$row['nom_client'].'</div>
';
}
if ($row['telephonec'] == null) {
    $output .= '
<div>&nbsp;</div>
';
} else {
    $output .= '
<div>'.$row['telephonec'].'</div>
';
}
$output .= '
</div>
<div class="livraison">
<div class="titre">livraison</div>
';
if ($row["zone"] == null) {
    $output.='
<div> &nbsp;</div>
';
}else{
    $output.='
    <div> '.$row["zone"].'</div>
    ';
}
if ($row["tarif"] == 0) {
    $output.='
<div>&nbsp;</div>
';
} else {
$output.='
<div>'.number_format($row["tarif"], 0, ",", " ").'</div>
';
}
$output.='
</div>
</div>
<div class="table-note">
<table class="table1">
<tr>
<th class="th1">Description</th>
<th class="th2">Prix</th>
<th class="th3">Qte</th>
</tr>
';
$count = 0;
foreach ($result as $row) {
    $count++;
$output.='
<tr>
<td class="td1">'.$row["description_article"].'</td>
<td class="td2">'.number_format($row["prix"], 0, ",", " ").'</td>
<td class="td2">'.$row["quantite"].'</td>
</tr>

';
}

$output.='
</table>

</div>
';
$output.='
<div class="total1">
<table class="table2">
<tr>
<th class="th1a">Acompte</th>
<th class="th1b">Espece remis</th>
<th class="th1c">Montant HT</th>
</tr>
<tr>
<td class="td1a">
';
if ($row["montant"] == 0){
    $output.='
<div>
&nbsp;
</div>
';
}else{
    $output.='
    <div>
    '.number_format($row["montant"], 0, ",", " ").'
    </div>
    ';   
}
$output.='
</td>
<td class="td1b">
';
if ($row["espece_du"] == 0){
    $output.='
<div>
&nbsp;
</div>
';
}else{
    $output.='
<div>
'.number_format($row["espece_du"], 0, ",", " ").'
</div>
'; 
}
$output.='
</td>
<td class="td1c">
';
if ($row["mt_ht"] == 0){
    $output.='
<div>
&nbsp;
</div>
';
}else{
    $output.='
    <div class="tt1">
    '.number_format($row["mt_ht"], 0, ",", " ").'
    </div>
    ';   
}
$output.='
</td>
</tr>
</table>
</div>
<div class="total1">
<table class="table2">
<tr>
<th class="th1a">Avoir</th>
<th class="th1b">Espece rendu</th>
<th class="th1c">Montant TVA </th>
</tr>
<tr>
<td class="td1a">
';
if ($row["avoir"] == 0){
    $output.='
<div>
&nbsp;
</div>
';
}else{
    $output.='
    <div>
    '.number_format($row["avoir"], 0, ",", " ").'
    </div>
    ';   
}
$output.='
</td>
<td class="td1b">
';
if ($row["espece_rendu"] == 0){
    $output.='
<div>
&nbsp;
</div>
';
}else{
    $output.='
<div>
'.number_format($row["espece_rendu"], 0, ",", " ").'
</div>
'; 
}
$output.='
</td>
<td class="td1c">
';
if ($row["mt_tva"] == 0){
    $output.='
<div>
Non applicable
</div>
';
}else{
    $output.='
    <div class="tt1">
    '.number_format($row["mt_tva"], 0, ",", " ").'
    </div>
    ';   
}
$output.='
</td>
</tr>
</table>
</div>

<div class="total1">
<table class="table2">
<tr>
<th class="th1a">Mode paiement</th>
<th class="th1c">Montant T.T.C </th>
</tr>
<tr>
<td class="td1a">
';
if ($row["mode"] == null){
    $output.='
<div>
&nbsp;
</div>
';
}else{
    $output.='
    <div>
    '.$row["mode"].'
    </div>
    ';   
}
$output.='
</td>

<td class="td1c">
';
if ($row["mt_ttc"] == 0){
    $output.='
<div>
&nbsp;
</div>
';
}else{
    $output.='
    <div class="tt1">
    '.number_format($row["mt_ttc"], 0, ",", " ").'
    </div>
    ';   
}
$output.='
</td>
</tr>
</table>
</div>

<div class="total1">
<table class="table2">
<tr>
<th class="th3a">Montant Net A Payer </th>
';

$total = $row["mt_ttc"] + $row["tarif"];
$output.='
<td class="td3a">
'.number_format($total, 0, ",", " ") . ' ' . 'FCFA'.'
</td>
</tr>
</table>
</div>
<div class="total1">
<table class="table2">
<tr>
';
$t = new ConvertNumberToText();
if ($row["tarif"]) {
} 
$output.='
<td class="td3L">
'.$t->Convert($total). ' ' . 'FCFA'.'
</td>
</tr>
</table>
</div>
<div class="fin-page">
Merci d\'avoir choisi <strong>'.$row['nomb'].'</strong>
</div>
';
}
    
        require_once '../../dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($output);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('Facture', array("Attachment" => false));
?>