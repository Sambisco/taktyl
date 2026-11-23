<?php
session_start();
include('../include/database.php');
include('../include/N2TEXT.php');
if (isset($_SESSION['profil'])) {
    /**
     * HTML2PDF Librairy - example
     *
     * HTML => PDF convertor
     * distributed under the LGPL License
     *
     * @author      Laurent MINGUET <webmaster@html2pdf.fr>
     *
     * isset($_GET['vuehtml']) is not mandatory
     * it allow to display the result in the HTML format
     */

    // get the HTML
    ob_start();
?>

    <style type="text/css">
        table {
            width: 100%;
            min-width: rem-calc(640);
            border-collapse: collapse;
            border: #000000;
            table-layout: auto;
        }

        .Style1 {
            color: #FFFFFF;
            font-size: 10px;
        }

        .Style4 {
            font-size: 10px
        }

        .Style5 {
            color: #000000;
            font-weight: bold;
        }

        .Style6 {
            color: #FFFFFF;
            font-weight: bold;
        }

        .Style8 {
            color: #FFFFFF
        }
    </style>
    <?php
    if (isset($_GET["imprimer"])) {
        $imprime = $_GET['imprime'];
        $query = "SELECT num, DATE_FORMAT(date,'%d-%m-%Y') AS date,mt_ht,mt_tva,mt_ttc,description_article,vente.prix AS prix, quantite, remise, total,nom_client, telephonec, adresse, emailc,montant,avoir, espece_du, espece_rendu, mode, description,zone, tarif,nomb, lieu, telephone, email, web, ninea, logo FROM tva 
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
    ?>
            <page backtop="10mm" backleft="5mm" backright="5mm" backbottom="100mn" footer="page">
                <page_header>
                    <table width="100%" border="0">
                        <tr>
                            <td style="width:50%;text-transform:uppercase;"><strong>Commande ou Facture</strong></td>
                            <td style="width:50%">
                                <div align="right"><strong>Imprimer le :&nbsp;</strong><?php echo date('d/m/Y'); ?></div>
                            </td>
                        </tr>
                    </table>

                    <hr />
                </page_header>
                <page_footer>


                    <hr />
                    <p align="center">Merci d'avoir choisi <strong><?php echo $row['nomb']; ?></strong></p>
                </page_footer>



                <table width="100%" border="0">

                    <tr>
                        <td rowspan="6" style="width:100px;">
                            <div style="width:100px;height:80px;border:1px solid #000000;padding-right:1px">

                                <img class="avatar" src="../img/logo/<?php if ($row['logo'] == null) { ?>boy.png <?php } else {
                                                                                                                echo $row['logo'];
                                                                                                            } ?>" width="120" height="80" alt="icons8-team-100" />

                            </div>
                        </td>
                        <td style="width:58%; padding-left:10px;word-wrap: break-word;font-size: 10px;"><strong>Entreprise :</strong> <?php if ($row['nomb'] == null) { ?>.........<?php } else {
                                                                                                                                                                                    echo $row['nomb'];
                                                                                                                                                                                } ?> </td>
                        <td rowspan="6" style="width:25%; height:100px;">
                            <div style="height:100px; border:0px solid #000000">

                                <table width="100%" border="1" align="right">
                                    <tr>
                                        <td style="width:90%;text-transform:uppercase; background:#000000" scope="col">
                                            <div align="center" class="Style1" style="background-color:#000000;">emit par:</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:90%; padding-top: 2px;" height="10">
                                            <div align="center" class="Style4"><?php echo $_SESSION['nomuser']; ?></div>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; padding-left:10px;font-size: 10px;"><strong>Adresse :&nbsp;</strong><?php if ($row['lieu'] == null) { ?>.........<?php } else {
                                                                                                                                                                    echo $row['lieu'];
                                                                                                                                                                } ?></td>
                    </tr>
                    <tr>
                        <td style="width:50%; padding-left:10px;font-size: 10px;"><strong>Email :&nbsp;</strong><?php if ($row['email'] == null) { ?>.........<?php } else {
                                                                                                                                                                echo $row['email'];
                                                                                                                                                            } ?></td>
                    </tr>
                    <tr>
                        <td style="width:50%; padding-left:10px;font-size: 10px;"><strong>Tel :&nbsp;</strong><?php if ($row['telephone'] == null) { ?>.........<?php } else {
                                                                                                                                                                echo $row['telephone'];
                                                                                                                                                            } ?></td>
                    </tr>
                    <tr>
                        <td style="width:50%; padding-left:10px;font-size: 10px;">&nbsp;<strong>Web :&nbsp;</strong><?php if ($row['web'] == null) { ?>.........<?php } else {
                                                                                                                                                                echo $row['web'];
                                                                                                                                                            } ?></td>
                    </tr>
                    <tr>
                        <td style="width:50%; padding-left:13px;font-size: 10px;"><strong>Ninea :&nbsp;</strong><?php if ($row['ninea'] == null) { ?>.........<?php } else {
                                                                                                                                                                echo $row['ninea'];
                                                                                                                                                            } ?></td>
                    </tr>
                </table>
                <hr />
                <table border="0" style="margin-top:0px">
                    <tr>
                        <td style="width:50%;text-transform:uppercase"><span class="Style5">Commande/Facture N°&nbsp;00<?php echo $row["num"]; ?></span></td>
                        <td style="width:50%">
                            <div align="right"><strong>Date</strong>:&nbsp;<?php echo $row["date"]; ?></div>
                        </td>

                    </tr>
                </table>
                <table border="1" style="margin-top:0px">
                    <tr>
                        <td style="width:40%;height:15px;text-transform:uppercase;background-color:#000000">
                            <div align="center" class="Style6">
                                CoordonnEes du client
                            </div>
                        </td>
                        <td style="width:20%;height:15px; border:0px"></td>
                        <td bgcolor="#000000" style="width:40%;height:15px;text-transform:uppercase;background-color:#000000">
                            <div align="center" class="Style6">CoordonnEes livraison</div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" style="width:40%; padding-top: 5px; padding-left: 10px;">
                            <div style="margin-top:0px;height:60px">
                                <div><strong>Nom client :</strong> <?php echo $row["nom_client"]; ?></div>
                                <div style="margin-top:5px"><strong>Adresse :</strong> <?php echo $row["adresse"]; ?></div>
                                <div style="margin-top:5px"><strong>Téléphone :</strong> <?php echo $row["telephonec"]; ?></div>
                                <div style="margin-top:5px"><strong>Email :</strong> <?php echo $row["emailc"]; ?></div>
                            </div>
                        </td>
                        <td style="width:20%; border-bottom:solid 0px;border-right:solid 0.5px"></td>
                        <td valign="top" style="width:40%; padding-top: 5px; padding-left: 10px;">
                            <div style="margin-top:0px;height:60px">
                               
                                <div><strong>Zone :</strong> <?php echo $row["zone"]; ?></div>
                                <div style="margin-top:5px"><strong>Tarif :</strong> <?php if ($row["tarif"] == 0) {
                                                                                        } else {
                                                                                            echo number_format($row["tarif"], 0, ",", " ");
                                                                                        } ?></div>
                            </div>
                        </td>
                    </tr>
                </table>
                <div style="border:solid 1px #000000; height:400px ;margin-top:10px">
                    <table border="1">
                        <thead>
                            <tr>
                                <th width="10" height="20" valign="middle" bgcolor="#000000" style="width:10%;height:20px">
                                    <div align="center" class="Style8">#</div>
                                </th>
                                <th height="20" valign="middle" bgcolor="#000000" style="width:42%;height:20px; padding-left: 10px;"><span class="Style8"><strong>Designation</strong></span></th>
                                <th height="20" valign="middle" bgcolor="#000000" style="width:17%;height:20px">
                                    <div align="center" class="Style8"><strong>Prix Unitaire</strong></div>
                                </th>
                                <th height="20" valign="middle" bgcolor="#000000" style="width:16%;height:20px">
                                    <div align="center" class="Style8"><strong>Quantite</strong></div>
                                </th>
                                <th height="20" valign="middle" bgcolor="#000000" style="width:15%;height:20px;padding-right: 10px;">
                                    <div align="right" class="Style8">Total</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $count = 0;
                            foreach ($result as $row) {
                                $count++;
                            ?>
                                <tr>
                                    <td height="20" align="center" valign="middle"><?php echo $count; ?></td>
                                    <td height="20" valign="middle" class="left" style="padding-left: 10px;"><?php echo $row["description_article"]; ?></td>
                                    <td height="20" align="center" valign="middle" class=" prix"><span><?php echo number_format($row["prix"], 0, ",", " "); ?></span></td>
                                    <td height="20" align="center" valign="middle"><?php echo $row["quantite"]; ?></td>
                                    <td height="20" align="right" valign="middle" class=" total" style="padding-right: 10px;"><?php echo number_format($row["total"], 0, ",", " "); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div style="border:solid 0px #000000; margin-top:5px; width:100%">
                    <table width="100%">
                        <tr>
                            <td style="width: 50%;">
                                <!------------Avoir-------->
                                
                                <table width="100%" border="1">
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;border-top: 1px;">Avoir</th>
                                        <td style="width: 50%;text-align: right;border-top: 1px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php if ($row["avoir"] == 0) {
                                                                                                                                                                echo "";
                                                                                                                                                            } else {
                                                                                                                                                                echo $row["avoir"];
                                                                                                                                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;border-top: 0px;">Espece du:</th>
                                        <td style="width: 50%;text-align: right;border-top: 0px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php if ($row["espece_du"] == 0) {
                                                                                                                                                                echo "";
                                                                                                                                                            } else {
                                                                                                                                                                echo $row["espece_du"];
                                                                                                                                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;border-top: 0px;">Espece rendu:</th>
                                        <td style="width: 50%;text-align: right;border-top: 0px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php if ($row["espece_rendu"] == 0) {
                                                                                                                                                                echo "";
                                                                                                                                                            } else {
                                                                                                                                                                echo $row["espece_rendu"];
                                                                                                                                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;border-top: 0px;">Mode paiement:</th>
                                        <td style="width: 50%;text-align: right;border-top: 0px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php echo $row["mode"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style=" height: 30px;">
                                            <div style="margin-top: 0px;"><strong>Remarque</strong></div>
                                            <div style="margin-top: 0px; font-size: 9px;"><?php echo $row["description"]; ?></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 2%;"></td>
                            <td style="width:48% ;">
                                <!-----------TOTAL ET ACOMPTE------------>
                                <table width="100%" border="1">
                                   
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;">Acompte</th>
                                        <td style="width: 50%;text-align: right;padding-left: 5px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php if ($row["montant"] == 0) {
                                                                                                                                                                } else {
                                                                                                                                                                    echo number_format($row["montant"], 0, ",", " ") . " " . "FCFA";
                                                                                                                                                                } ?></td>
                                    </tr>
                                </table>
                                
                                <table width="100%" border="1">
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;border-top: 0px;">Montant H.T</th>
                                        <td style="width: 50%;text-align: right;border-top: 0px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php echo  number_format($row["mt_ht"], 0, ",", " "); ?>&nbsp; F CFA</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;border-top: 0px;">Montant T.V.A</th>
                                        <td style="width: 50%;text-align: right;border-top: 0px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php if ($row["mt_tva"] == 0) {
                                                                                                                                                                echo "Non applicable";
                                                                                                                                                            } else {
                                                                                                                                                                echo  number_format($row["mt_tva"], 0, ",", " ") . " " . "FCFA";
                                                                                                                                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;border-top: 0px;">Montant T.T.C</th>
                                        <td style="width: 50%;text-align: right;border-top: 0px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php echo  number_format($row["mt_ttc"], 0, ",", " ") . " " . "FCFA"; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 49%; padding-left: 5px;padding-top: 5px;padding-bottom: 5px;border-top: 0px;">Montant Net A Payer</th>
                                        <td style="width: 50%;text-align: right;border-top: 0px;padding-top: 5px;padding-bottom: 5px;padding-right: 10px;"><?php $total = $row["mt_ttc"] + $row["tarif"];
                                                                                                                                                            echo  number_format($total, 0, ",", " ") . " " . "FCFA"; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top:10px;text-align:center"><strong>La somme totale à payer en lettre :</strong><?php $t = new ConvertNumberToText();
                                                                                                                    if ($row["tarif"]) {
                                                                                                                    }
                                                                                                                    echo  $t->Convert($total); ?> </div>
            <?php
        }

            ?>
            <hr />
            <h4>Signature et cachet de l'entreprise, précédés de la mention manuscrite "Bon pour accord"</h4>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            </page>

    <?php
    }
    $content = ob_get_clean();

    // convert in PDF
    require('../html2pdf/html2pdf.class.php');
    try {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('Facture.pdf');
    } catch (HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
} else if (isset($_SESSION['profil']) == '') {
    header("Location:../index.php");
} ?>