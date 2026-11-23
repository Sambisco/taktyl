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

if (isset($_POST['btn_envoyer'])) {

    $emailTo = trim($_POST['email']); 
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    $sql = "SELECT * FROM user WHERE login ='$emailTo'";
  $statement = $db->prepare($sql);
  $statement->execute();
  $result=$statement->fetch();
  if($result){
  $email=$result['iduser'];
    try {
        //Server settings
         // Enable verbose debug output, 1 for produciton , 2,3 for debuging in devlopment 
        $mail->isSMTP();                                   // Set mailer to use SMTP
            $mail->SMTPDebug = 2;

        $mail->Host = 'smtp.hostinger.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'mot-de-passe@taktyl-light.com';                 // SMTP username
        $mail->Password = 'Clonel1990@';                           // SMTP password
        // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        // $mail->Port = 587;   // for tls                                 // TCP port to connect to
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('mot-de-passe@taktyl-light.com'); // from who? 
        $mail->addAddress($emailTo);     // Add a recipient
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Content
        // this give you the exact link of you site in the right page 
        // if you are in actual web server, instead of http://" . $_SERVER['HTTP_HOST'] write your link 
        $url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/initialise_password?code=$email"; 
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Votre lien de reinitialisation de mot de passe';
        $mail->Body    = "<h1> vous avez demandé la réinitialisation du mot de passe </h1>
                        Cliquez sur <a href='$url'>ce lien</a> pour modifier votre mot de passe
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


       
         $_SESSION['message_add']="Le Message de reinitialisation a été envoyer sur votre email";
 $_SESSION['msg_type_add']="success";
header("Location:../email_recupe");
 $mail->send();
exit(); 
    } catch (Exception $e) {
        $_SESSION['message_delete']="Le Message de reinitialisation n'a pas été envoyer sur votre email";
 $_SESSION['msg_type_delete']="danger";
 header("Location:../email_recupe");

    }
	  
}
   $_SESSION['message_add']="Le Message de reinitialisation a été envoyer sur votre email";
 $_SESSION['msg_type_add']="success";
header("Location:../email_recupe");
}

?>