<?php
if(!isset($_SESSION['iduser']) AND isset($_COOKIE['email'],$_COOKIE['password']) AND !empty($_COOKIE['email']) AND !empty($_COOKIE['password'])) {
   $requser = $db->prepare("SELECT * FROM user  WHERE login = ? AND password = ?");
   $requser->execute(array($_COOKIE['email'], $_COOKIE['password']));
   $userexist = $requser->rowCount();
   if($userexist == 1)
   {
      $userinfo = $requser->fetch();
      $_SESSION['iduser'] = $userinfo['iduser'];
      $_SESSION['nomuser']= $userinfo['nomuser'];
$_SESSION['profil']= $userinfo['profil'];
   }
}
?>