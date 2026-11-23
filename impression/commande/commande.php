<?php
session_start();
include('../../include/database.php');
include('../../include/config.php');
include('../../include/N2TEXT.php');
setlocale(LC_TIME, 'fr_FR.utf8');
$timezone = "UTC";
date_default_timezone_set($timezone);
$imprime=encryptor('decrypt',$_GET['imprime']);

   
    $query = "SELECT *, DATE_FORMAT(date,'%d-%M-%Y') AS dater FROM detail_commande 
    INNER JOIN commande ON commande.id_commande=detail_commande.id_commande 
    INNER JOIN article ON article.id_article=detail_commande.id_article 
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
     INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
     INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
WHERE commande.id_commande='$imprime'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total_row = $statement->rowCount();
    if ($total_row > 0) {
        foreach ($result as $row) {
        }

$output = '';
        $output .= '
        <link rel="stylesheet" href="commande.css">
<div class="top-page">
    <div class="top-page1">
    BON DE COMMANDE
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
<img src="'.$row["logo"].'" class="img-logo" alt="">
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
<div class="numero1">COMMANDE N°</div>
<div class="numero2">'."00".$row['num'].'</div>
</div>
<div class="date">
<div class="date1">Date</div>
<div class="date2">'.strftime("%d-%B-%Y", strtotime($row["dater"])).'</div>
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
COORDONNEES DU FOURNISSEUR
</div>
<div class="content-client">
<div class="content-client1">
<div>Fournisseur </div>
<div> Téléphone </div>
<div> Adresse </div>
<div> Email </div>
</div>
<div class="content-client2">
';
if ($row['nomfour'] == null) {
    $output .= '
<div>&nbsp;</div>
';
} else {
    $output .= '
<div>'.$row['nomfour'].'</div>
';
}
if ($row['telephonefour'] == null) {
    $output .= '
<div>&nbsp;</div>
';
} else {
    $output .= '
<div>'.$row['telephonefour'].'</div>
';
}
if ($row['adressefour'] == null) {
    $output .= '
<div>&nbsp;</div>
';
} else {
    $output .= '
<div>'.$row['adressefour'].'</div>
';
}
if ($row['emailfour'] == null) {
    $output .= '
<div>&nbsp;</div>
';
} else {
    $output .= '
<div>'.$row['emailfour'].'</div>
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
<div class="content-client2">
</div>
</div>
</div>
</div>
<div class="table-note">
<table class="table1">
<tr>
<th class="th1">#</th>
<th class="th2">Designation</th>
<th class="th3">Quantite</th>
</tr>
';
$count = 0;
foreach ($result as $row) {
    $count++;
$output.='
<tr>
<td class="td1">'.$count.'</td>
<td class="td2">'.$row["description_article"].'</td>
<td class="td3">'.$row["quantite"].'</td>
</tr>';
}
$output.='
</table>
</div>
<div class="remarque">
<div class="remarque1">
Remarque
</div>
<div class="remarque2">
'.$row['description'].'
</div>
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
$dompdf->stream('Commande', array("Attachment" => false));
?>