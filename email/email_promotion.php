<?php
session_start();
include('../include/database.php');
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include( '../PHPMailer/Exception.php');
include( '../PHPMailer/PHPMailer.php');
include( '../PHPMailer/SMTP.php');
$timezone = "UTC";
date_default_timezone_set($timezone);

if (isset($_GET['id_categorie'])) {
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    $id_categorie = $_GET['id_categorie']; 
    $objet = $_GET['objet'];
    $description = $_GET['description'];
    $id_boutique = $_GET['id_boutique']; 
    $saveemail = $_GET['saveemail']; 
    $date = date('Y-m-d H:i:s');
    $querysave = "INSERT INTO `message`( `id_categorie_client`, `date`, `message`) VALUES (?,?,?)";
    $statement = $db->prepare($querysave);
    $statement->execute(array($id_categorie,$date,$saveemail));
    
    $query = "SELECT * FROM configuration 
    INNER JOIN boutique ON boutique.id_boutique=configuration.id_boutique 
    WHERE boutique.id_boutique ='$id_boutique'";
    $statement = $db->prepare($query);
    $statement->execute();
    $resultC=$statement->fetch();
    $sql = "SELECT * FROM add_client_categorie 
    INNER JOIN  client ON client.id_client=add_client_categorie.id_client
    INNER JOIN categorie_client ON categorie_client.id_categorie_client=add_client_categorie.id_categorie_client
    INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
    WHERE categorie_client.id_categorie_client ='$id_categorie'";
  $statement = $db->prepare($sql);
  $statement->execute();
  $result=$statement->fetchAll();

        try {
        //Server settings
         // Enable verbose debug output, 1 for produciton , 2,3 for debuging in devlopment 
        $mail->isSMTP();                                   // Set mailer to use SMTP
            $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.hostinger.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $resultC['emailconf'];                 // SMTP username
        $mail->Password = $resultC['passwordconf'];                             // SMTP password
        // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        // $mail->Port = 587;   // for tls                                 // TCP port to connect to
        $mail->Port = 587;

        //Recipients
        $mail->setFrom($resultC['emailconf']); // from who? 
        foreach ($result as $address) {
            if($address["emailc"]==""){

            }else{
        $mail->addAddress($address["emailc"]); 
                }    // Add a recipient
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        }
        //Content
        // this give you the exact link of you site in the right page 
        // if you are in actual web server, instead of http://" . $_SERVER['HTTP_HOST'] write your link 
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $objet;
        $mail->Body    = "<h1> Nous vous envoyons cette ".$objet." </h1>
                        <div>".$_GET['description']."</div>
";
        $mail->AltBody = 'Ceci est le corps en texte brut pour les clients de messagerie non HTML';
        // to solve a problem 
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );


       
         $_SESSION['message_add']="Le message a été envoyée avec succés";
 $_SESSION['msg_type_add']="success";
header("Location:../page/client.php");
 $mail->send();
exit(); 
    } catch (Exception $e) {
        $_SESSION['message_delete']="Le message n'a pas été envoyée ";
 $_SESSION['msg_type_delete']="danger";
 header("Location:../page/client.php");

    }

}

?>
<script>
      var node=document.getElementById('content');
var btn=document.getElementById('action');
  
btn.onclick=function(){
      domtoimage.toBlob(document.getElementById('content')).then(function(blob){
        window.saveAs(blob,'Carte.png')
      })
}
</script>