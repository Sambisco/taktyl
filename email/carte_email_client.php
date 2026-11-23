<?php
session_start();
include('../include/database.php');
include('../include/config.php');
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include( '../PHPMailer/Exception.php');
include( '../PHPMailer/PHPMailer.php');
include( '../PHPMailer/SMTP.php');

if (isset($_GET['id_client'])) {
  $mail = new PHPMailer(true);  

    $emailTo = trim($_GET['informa_email']);
    $id_client = $_GET['id_client']; 
    $id_boutique = $_GET['id_boutique']; 
    $query = "SELECT * FROM configuration 
    INNER JOIN boutique ON boutique.id_boutique=configuration.id_boutique 
    WHERE boutique.id_boutique ='$id_boutique'";
    $statement = $db->prepare($query);
    $statement->execute();
    $resultC=$statement->fetch();
    // Passing `true` enables exceptions
    $sql = "SELECT * FROM client WHERE id_client ='$id_client'";
  $statement = $db->prepare($sql);
  $statement->execute();
  $result=$statement->fetch();
  if($result){
    
  $codeTo_id_boutique = encryptor('encrypt',$id_boutique);;
  $codeTo = encryptor('encrypt',$result['id_client']); 
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
        $mail->addAddress($emailTo);     // Add a recipient
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Content
        // this give you the exact link of you site in the right page 
        // if you are in actual web server, instead of http://" . $_SERVER['HTTP_HOST'] write your link 
        $url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/../carte/fetch_carte_email?id=$codeTo_id_boutique &id_client=$codeTo"; 
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Carte de fidelite';
        $mail->Body    = "<h1> Nous vous envoyons cette carte de fidélité </h1>
                        Cliquez sur <a href='$url' id='action'>Carte-fidelité</a> pour ouvrir le fichier
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


       
         $_SESSION['message_add']="La carte a été envoyée par email";
 $_SESSION['msg_type_add']="success";
header("Location:../page/client.php");
 $mail->send();
exit(); 
    } catch (Exception $e) {
        $_SESSION['message_delete']="La carte n'a pas été envoyée par email";
 $_SESSION['msg_type_delete']="danger";
 header("Location:../page/client.php");

    }
	  
}
   $_SESSION['message_add']="La carte a été envoyée par email";
 $_SESSION['msg_type_add']="success";
header("Location:../page/client.php");
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