<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/database.php');
include('../include/phpqrcode/qrlib.php');

?>
<style>
    .content {
        width: 100%;
        border-radius: 10px;
        padding-top: 15px;
        padding-left: 15px;
        padding-right: 15px;
        background-color: #000;
    }

    .head {
        width: 100%;
        height: 18vh;
        background-color: rgb(179, 116, 0);
        padding-top: 5px;
    }

    .box-1 {
        float: left;
        width: 20%;
        height: 100px;
        margin-left: 30px;
        margin-top: -40px;
        background-color: #fff;
    }

    .box-2 {
        float: left;
        width: 57%;
        height: 50px;
        padding-top: 15px;
        padding-left: 30px;
    }

    .box-2 h3 {
        font-size: 1.1rem;
        margin-top: -5px;
        color: rgb(27, 27, 49);
        ;
    }

    .box-2 p {
        font-size: 0.8rem;
        margin-top: -5px;
        color: rgb(179, 116, 0);
    }

    .box-3 {
        float: left;
        width: 15%;
        height: 10px;
        padding-top: 10px;
        margin-right: 0px;
    }

    .logo {
        float: left;
        width: 50px;
        height: 30px;
        margin-bottom: 5px;
    }

    .info-1 {
        /* border: 1px solid rgb(255, 38, 0); */
        width: 17vh;
        height: 11vh;
        width: 100%;
    }

    .info-2 {
        /* border: 1px solid rgb(255, 38, 0); */
        width: 20vh;
        width: 100%;
        margin-top: 10px;
    }

    .info-3 {
        /* border: 1px solid rgb(255, 38, 0); */
        width: 20vh;
        width: 100%;
        margin-top: 10px;
    }

    .desc-1 {
        float: left;
        width: 30%;
    }

    .desc-2 {
        float: left;
        width: 70%;
    }



    .titre {
        color: rgb(179, 116, 0);
        font-size: 15px;
    }

    .paragraph {
        font-size: 13px;
        margin-top: 0px;
        color: burlywood;
    }
</style>
<?php
if (isset($_GET['id_client'])) {
    $id_client = $_GET['id_client'];
    $query = "SELECT * FROM `client`
                     
                     INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                      WHERE  client.id_client='$id_client'";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();

    $queryP = "SELECT DATE_FORMAT(datefin,'%m/%Y') AS datefin,point FROM valide_carte 
    INNER JOIN client ON client.id_client=valide_carte.id_client
    INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
    WHERE client.id_client='$id_client' ";
$statementP = $db->prepare($queryP);
$statementP->execute();
$resultP = $statementP->fetch();
?>
    <div class='content' style='text-align:left; border:2px dotted black;'>
        <div class='head'>
            <div style="color: #fff;font-size: 15px;text-transform: uppercase;text-align: right;margin-right:10px ;">Carte de fidelité</div>
            <div style="color: #fff;font-size: 12px;text-align: right;margin-right:10px ; margin-top: -5px;"><?php echo $result['nomb'] ?></div>
            <div style="color: #fff;font-size: 12px;text-align: right;margin-right:10px ; margin-top: -5px;"><?php echo $result['lieu'] ?></div>
            <div style="color: #fff;font-size: 12px;text-align: right;margin-right:10px ; margin-top: -5px;"><?php echo $result['telephone'] ?></div>
            <div style="color: #fff;font-size: 12px;text-align: right;margin-right:10px ; margin-top: -5px;"><?php echo $result['email'] ?></div>
            <div style="color: #fff;font-size: 12px;text-align: right;margin-right:10px ; margin-top: -5px;"><?php echo $result['web'] ?></div>
            <div style="color: #fff;font-size: 12px;text-align: right;margin-right:10px ; margin-top: -5px;margin-bottom: 5px;"><?php echo $result['ninea'] ?></div>

        </div>

        <div class="box-1" >
            <?php
$text=$result['id_client'];
$folder="../img/codeQR/";
$file_name="qr.png";
$file_name=$folder.$file_name;
QRcode::png($text,$file_name);
echo'<img src="../img/codeQR/qr.png" style="width:100px;height:100px;">';



            //To Display Code Without Storing

            ?>
        </div>
        <div class="box-2">
            <h3 style="color:burlywood;font-size: 15px;"><?php echo $result['nom_client'] ?></h3>
            <p style='font-size: 14px;'>Client fidéle</p>
        </div>
        <div class="box-3">
            <img src="../img/logo/<?php echo $result['logo'] ?>" class="logo">
            <div class="titre">Expire</div>
                <div class="paragraph"><?php if($resultP['datefin']==null){ echo "00/0000";}else{ echo $resultP['datefin'] ;}?></div>
        </div>
        <div class="info-1">

        </div>
        <div class="info-2">
            <div class='desc-1'>
                <div class="titre">ID</div>
                <div class="paragraph"><?php echo $result['id_client'] ?></div>
            </div>
            <div class='desc-2'>
                <div class="titre">Adresse</div>
                <div class="paragraph"><?php echo $result['adresse'] ?></div>
            </div>
        </div>
        <div class="info-3">
            <div class='desc-1'>
                <div class="titre">Telephone</div>
                <div class="paragraph"><?php echo $result['telephonec'] ?></div>
            </div>
            <div class='desc-2'>
                <div class="titre">Email</div>
                <div class="paragraph"><?php echo $result['emailc'] ?></div>
            </div>
            <div style="text-align: right;margin-right: 30px;color:burlywood;">Signature</div>
            <div style="background-color:  rgb(179, 116, 0); height: 30px;margin-bottom: 10px;"></div>
        </div>
    </div>
<?php } ?>