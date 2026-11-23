<?php
session_start();
include('../../include/database.php');
include('../../include/config.php');
include('../../include/N2TEXT.php');
setlocale(LC_TIME, 'fr_FR.utf8');
$timezone = "UTC";
date_default_timezone_set($timezone);
    $imprime=encryptor('decrypt',$_GET['imprime']);
   
    $query = "SELECT num, DATE_FORMAT(date,'%d-%M-%Y') AS date,mt_ht,mt_tva,mt_ttc,description_article,vente.prix AS prix, quantite, remise, total,nom_client, telephonec, adresse, emailc,montant,avoir, espece_du, espece_rendu, mode, description,zone, tarif,nomb, lieu, telephone, email, web, ninea, logo,cachet FROM tva 
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
        $output .= '
        <link rel="stylesheet" href="../facture/facture.css">
<div class="top-page">
    <div class="top-page1">
    COMMANDE OU FACTURE
    </div>
    <div class="top-page2">
    Imprimer le : '. strftime("%d-%B-%Y", strtotime(date('d-M-Y'))) .'
    </div>
</div>
<!-----fin top-page---->
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
if ($row['ninea'] == null) {
    $output .= "
<div>Ninea</div>
";
} else {
    $output .= '
<div>'.$row['ninea'].'</div>
';
}
$output .= '
</div>
</div>
<!-----fin reference---->
<div class="num">
<div class="numero">
<div class="numero1">FACTURE N°</div>
<div class="numero2">'."00".$row['num'].'</div>
</div>
<div class="date">
<div class="date1">Date</div>
<div class="date2">'.strftime("%d-%B-%Y", strtotime($row["date"])).'</div>
</div>
<div class="emit">
<div class="emit1">EMIT PAR</div>
<div class="emit2">'.$_SESSION['nomuser'].'</div>
</div>
</div>
<!---------fin numero facture----->
<div class="cordonnee">
<div class="client">
<div class="client1">
COORDONNEES DU CLIENT
</div>
<div class="content-client">
<div class="content-client1">
<div>Client </div>
<div> Téléphone </div>
<div> Adresse </div>
<div> Email </div>
</div>
<div class="content-client2">
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
if ($row['adresse'] == null) {
    $output .= '
<div>&nbsp;</div>
';
} else {
    $output .= '
<div>'.$row['adresse'].'</div>
';
}
if ($row['emailc'] == null) {
    $output .= '
<div>&nbsp;</div>
';
} else {
    $output .= '
<div>'.$row['emailc'].'</div>
';
}
$output .='
</div>
</div>
</div>
<div class="livraison">
<div class="client1">
COORDONNEES LIVRAISON
</div>
<div class="content-client">
<div class="content-client1">
<div>Zone </div>
<div> Tarif </div>
<div>&nbsp;</div>
<div> &nbsp; </div>
</div>
<div class="content-client2">
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
<div> &nbsp; </div>
<div> &nbsp;</div>
</div>
</div>
</div>
</div>
<div class="table-note">
<table class="table1">
<tr>
<th class="th1">#</th>
<th class="th2">Designation</th>
<th class="th3">P. Unitaire</th>
<th class="th4">Quantite</th>
<th class="th5">Total</th>
</tr>
';
$count = 0;
foreach ($result as $row) {
    $count++;
$output.='
<tr>
<td class="td1">'.$count.'</td>
<td class="td2">'.$row["description_article"].'</td>
<td class="td3">'.number_format($row["prix"], 0, ",", " ").'</td>
<td class="td4">'.$row["quantite"].'</td>
<td class="td5">'.number_format($row["total"], 0, ",", " ").'</td>
</tr>';
}
$output.='
</table>
</div>
<div class="total1">
<div>
<div class="Espece-du">
Espece du 
</div>
';
if ($row["espece_du"] == 0){
    $output.='
<div class="Espece-du1">
&nbsp;
</div>
';
}else{
    $output.='
<div class="Espece-du1">
'.number_format($row["espece_du"], 0, ",", " ").'
</div>
'; 
}
$output.='
<div class="Espece-rendu">
Espece rendu 
</div>
';
if ($row["espece_rendu"] == 0){
    $output.='
<div class="Espece-rendu1">
&nbsp;
</div>
';
}else{
    $output.='
    <div class="Espece-rendu1">
    '.number_format($row["espece_rendu"], 0, ",", " ").'
    </div>
';
}
$output.='
</div>
<div>
<div class="avoir">
Avoir
</div>
';
if ($row["avoir"] == 0){
    $output.='
<div class="avoir1">
&nbsp;
</div>
';
}else{
    $output.='
    <div class="avoir1">
    '.number_format($row["avoir"], 0, ",", " ").'
</div>
';
}
$output.='
<div class="mode">
Mode paiement 
</div>
';
if ($row["mode"] == null){
    $output.='
<div class="mode1">
&nbsp;
</div>
';
}else{
    $output.='
    <div class="mode1">
    '.$row["mode"].'
</div>
';
}
$output.='
</div>
<div class="remarque">
Remarque
</div>
<div class="remarque1">
'.$row["description"].'
</div>
</div>
<div class="total2">
<div>
<div class="tt">
Acompte
</div>
';
if ($row["montant"] == 0){
    $output.='
<div class="tt1">
&nbsp;
</div>
';
}else{
    $output.='
    <div class="tt1">
    '.number_format($row["montant"], 0, ",", " ").'
    </div>
    ';   
}
$output.='
</div>
<div>
<div class="tt">
Montant H.T 
</div>
';
if ($row["mt_ht"] == 0){
    $output.='
<div class="tt1">
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
</div>
<div>
<div class="tt">
Montant T.V.A
</div>
';
if ($row["mt_tva"] == 0){
    $output.='
<div class="tt1">
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
</div>
<div>
<div class="tt">
Montant T.T.C
</div>
';
if ($row["mt_ttc"] == 0){
    $output.='
<div class="tt1">
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
</div>
<div>
<div class="tt">
Montant Net A Payer
</div>
';
$total = $row["mt_ttc"] + $row["tarif"];
$output.='
<div class="tt1">
'.number_format($total, 0, ",", " ") . ' ' . 'FCFA'.'</div>
</div>
</div>
';
$t = new ConvertNumberToText();
if ($row["tarif"]) {
} 
$output.='
<div class="smlettre">
<strong>A payer en lettre : </strong> '.$t->Convert($total). ' ' . 'FCFA'.'
</div>
<div class="signature">
Signature et cachet de l\' entreprise, précédés de la mention manuscrite " Bon pour accord "
<div class="img-cachet">
';
if ($row["cachet"]==null) {
    $output.='
    <div class="img-cachet"></div>
    '; 
} else{
    $output.='
    <img src="'. $row["cachet"] .'" class="img-cachet" alt="">
    ';
}
$output.='
</div>
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
$dompdf->stream('Facture', array("Attachment" => true));
?>