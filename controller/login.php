<?php 
include('../include/database.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

$timezone = "UTC";
date_default_timezone_set($timezone);

if(isset($_POST['register'])){
    $nom=trim($_POST['nom']);
    $telephone=trim(str_replace(' ','',$_POST['telephone']));
    $emailconnect=strtolower(trim($_POST['emailconnect']));
    $mdp=trim($_POST['mdpconnect']);
    $mdpconnect=trim(md5($_POST['mdpconnect']));
    $date= date("Y-m-d");
    $formule=trim($_POST['formule']);
    $query="SELECT * FROM user 
    LEFT JOIN boutique ON boutique.iduser=user.iduser
    LEFT JOIN sub_users ON sub_users.id_boutique=boutique.id_boutique 
     WHERE login='$emailconnect' OR telephone_user='$telephone' OR sub_email='$emailconnect' OR telephone_sub_user='$telephone' LIMIT 1";
    $statement=$db->prepare($query);
    $statement->execute();
    $result=$statement->rowCount();
    if($result>0){
        $_SESSION['message_delete']="L'identifiant existe déja. Veillez créér un nouveau identifiant!";
        $_SESSION['msg_type_delete']="danger";
        header("location:../register");
    }else{
        $query="INSERT INTO user(nomuser,telephone_user,login,password,date_user,formule) VALUES (?,?,?,?,?,?)";
        $statement=$db->prepare($query);
        $statement->execute(array($nom,$telephone,$emailconnect,$mdpconnect,$date,$formule));
        $_SESSION['emailconnect']=$emailconnect;
        $_SESSION['mdpconnect']=$mdp;
        header("location:../");
    }
}

if(isset($_POST['login'])){
    $emailconnect =strtolower(trim(str_replace(' ','',$_POST['emailconnect'])));
    $mdpconnect=trim(md5($_POST['mdpconnect']));
    $query="SELECT * FROM user LEFT JOIN boutique ON boutique.iduser=user.iduser
    LEFT JOIN sub_users ON sub_users.id_boutique=boutique.id_boutique 
    WHERE user.login='".$emailconnect."' AND user.password='".$mdpconnect."' OR user.telephone_user='".$emailconnect."' AND user.password='".$mdpconnect."'
    OR sub_email='".$emailconnect."' AND sub_password='".$mdpconnect."' OR telephone_sub_user='".$emailconnect."' AND sub_password='".$mdpconnect."' LIMIT 1";
    $statement=$db->prepare($query);
    $statement->execute();
    $userexist=$statement->rowCount();
if($userexist==1){
    if(isset($_POST['rememberme'])){
        setcookie('email',$emailconnect,time()+365*24*3600,null,null,false,true);
        setcookie('password',$mdpconnect,time()+365*24*3600,null,null,false,true);
        }
    $userinfo=$statement->fetch();
    $mail=$_SESSION['email']= $emailconnect;
    $_SESSION['iduser']=$userinfo['iduser'];
    $_SESSION['id_sub_users']=$userinfo['id_sub_users'];
    $_SESSION['nomuser']=$userinfo['nomuser'];
    $_SESSION['nom_sub_user']=$userinfo['nom_sub_user'];
    if($userinfo['sub_email']==$emailconnect||$userinfo['telephone_sub_user']==$emailconnect){
        $_SESSION['email']= $emailconnect;
        $_SESSION['profil']= $userinfo['profil'];
        $id=$_SESSION['id_boutique']= $userinfo['id_boutique'];
        $_SESSION['nomb']= $userinfo['nomb'];
        $id = encryptor('encrypt',$id);
        if($userinfo['profil']=="Utilisateur"){
header("location:../page/vente?mail=$mail&id=$id");
     }else{
        header("location:../page/dashboard?mail=$mail&id=$id");
     }
     
     }else{
        header("location:../page/dashboard?mail=$mail");
     }
}else{
    $_SESSION['message_delete']="Identifiants incorrects";
 $_SESSION['msg_type_delete']="danger";
header("location:../");
exit();
}
}

?>