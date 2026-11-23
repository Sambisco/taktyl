<!DOCTYPE html>
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title></title>
    <style type="text/css">
      * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    
    .black{
      position: absolute;
      background: rgb(0, 95, 158, 0.2);
      height:100%;
      width: 100%;
      display: -webkit-flex;
      display:flex;
    }
    .message{
      margin-top: 10%;
      margin-left :auto;
      margin-right:auto;
      text-align: justify;
      text-justify: inter-word;
      text-transform: uppercase;
      font-size: 30px;
      font-weight: 600;
    }
    .message span{
      background:tomato;
      padding-top:2px;
      padding-left:5px;
      padding-right:5px;
      font-size: 28px;
    }
    </style>
</head>

<body>
  <div class="black">
    <div class="message">
        La plateforme est momentanément indisponible.<br> Votre abonnement a expiré le
        <span><?php echo $result["d"];?></span>-<span><?php echo $result["m"];?></span>-<span><?php echo $result["y"];?></span> à <span><?php echo $result["h"];?></span>:<span><?php echo $result["i"];?></span>:<span><?php echo $result["s"];?></span>.
        <br>Veillez renouveler votre abonnement !
      </div>
      </div>
</body>

</html>