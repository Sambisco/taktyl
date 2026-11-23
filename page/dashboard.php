<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$timezone = "UTC";
date_default_timezone_set($timezone);
include('../include/database.php');

$mail = $_GET['mail'];
$query = "SELECT *,DATE_FORMAT(date_exp,'%d') AS d,DATE_FORMAT(date_exp,'%m') AS m,DATE_FORMAT(date_exp,'%Y') AS y,DATE_FORMAT(date_exp,'%H') AS h,DATE_FORMAT(date_exp,'%i') AS i,DATE_FORMAT(date_exp,'%s') AS s FROM user LEFT JOIN boutique ON boutique.iduser=user.iduser
LEFT JOIN sub_users ON sub_users.id_boutique=boutique.id_boutique 
WHERE user.login='".$mail."' OR user.telephone_user='".$mail."' OR sub_email='".$mail."' OR telephone_sub_user='".$mail."' LIMIT 1";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();
if(date($result["date_exp"]) < date('Y-m-d H:i:s')){
    include("../page/maintenance.php");
  }else{
if (isset($_SESSION['email'])) {
  include('../include/script.php');
  include('../include/css.php');
  include('../include/sidebar.php');
  include('../include/topbar.php');
 
?>
<style media="screen">
@import url(http://fonts.googleapis.com/css?family=Roboto:400,700,300);

.chart {
    position: relative;
    display: inline-block;
    width: 110px;
    height: 110px;
    margin-top: 0px;
    margin-bottom: 0px;
    text-align: center;
}

.chart canvas {
    position: absolute;
    top: 0;
    left: 0;
}

.percent {
    display: inline-block;
    line-height: 110px;
    z-index: 2;
}

.percent:after {
    content: '%';
    margin-left: 0.1em;
    font-size: .8em;
}
</style>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord <?php echo date("Y"); ?> </h1>
        <ol class="breadcrumb">
        <?php if(isset($_GET['mail']) && isset($_GET['id'])==""){ 
                     
                      ?>
                       <li class="breadcrumb-item"><a href="dashboard?mail=<?php echo $mail; ?>">Accueil</a></li>
                      <?php
                    }else{
                   ?>
                   <li class="breadcrumb-item"><a href="dashboard?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>">Accueil</a></li>
                   <?php }?>
                  <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
        </ol>
    </div>

    <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Chiffre d'affaires</div>
                            <?php
                $date = date("Y");
                if (isset($_GET["id"])=="") {
                  $queryTva = "SELECT  sum(mt_ttc) as mt FROM tva 
INNER JOIN client ON client.id_client=tva.id_client 
INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
INNER JOIN user ON user.iduser=boutique.iduser
WHERE DATE_FORMAT(`date`,'%Y')='$date' AND user.login='$mail' OR user.telephone_user='$mail'
";
                } else {
                  $queryTva = "SELECT  sum(mt_ttc) as mt FROM tva 
INNER JOIN client ON client.id_client=tva.id_client 
INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
WHERE DATE_FORMAT(`date`,'%Y')='$date' 
AND boutique.id_boutique='$id'";
                }
                $statementTva = $db->prepare($queryTva);
                $statementTva->execute();
                $resultTva = $statementTva->fetch();
                ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 counterPlugin"><?php if ($resultTva['mt'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultTva['mt'], 0, '.', ' ');
                                                                                  } ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 100%</span>
                                <span>Gains Annuels</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">NOMBRE DE VENTES</div>
                            <?php
                $date = date("Y");
                if (isset($_GET["id"])=="") {
                  $queryVente = "SELECT  count(id_tva) as id FROM tva 
INNER JOIN client ON client.id_client=tva.id_client 
INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
INNER JOIN user ON user.iduser=boutique.iduser
WHERE DATE_FORMAT(`date`,'%Y')='$date' AND user.login='$mail' OR user.telephone_user='$mail'";
                } else {
                  $queryVente = "SELECT  count(id_tva) as id FROM tva 
INNER JOIN client ON client.id_client=tva.id_client 
INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
WHERE DATE_FORMAT(`date`,'%Y')='$date' AND boutique.id_boutique='$id'";
                }
                $statementVente = $db->prepare($queryVente);
                $statementVente->execute();
                $resultVente = $statementVente->fetch();
                ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 counterPlugin"><?php if ($resultVente['id'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultVente["id"], 0, '.', ' ');
                                                                                  } ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 80%</span>
                                <span>Nombres illimités</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cart-plus fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New User Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                $date = date("Y");
                if (isset($_GET["id"])=="") {
                  $queryAC = "SELECT  COUNT(article.id_article)/COUNT(tva.id_tva) AS date FROM `vente` 
                      INNER JOIN tva ON tva.id_tva=vente.id_tva
                      INNER JOIN client ON client.id_client=tva.id_client 
                      INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                      INNER JOIN article ON article.id_article=vente.id_article 
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
    INNER JOIN user ON user.iduser=boutique.iduser
                      WHERE DATE_FORMAT(`date`,'%Y')='$date' AND user.login='$mail' OR user.telephone_user='$mail'";
                } else {
                  $queryAC = "SELECT COUNT(article.id_article)/COUNT(tva.id_tva) AS date FROM `vente` 
                      INNER JOIN tva ON tva.id_tva=vente.id_tva
                      INNER JOIN client ON client.id_client=tva.id_client 
                      INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                       INNER JOIN article ON article.id_article=vente.id_article 
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
                      WHERE DATE_FORMAT(`date`,'%Y')='$date' AND boutique.id_boutique='$id'";
                }

                $statementAC = $db->prepare($queryAC);
                $statementAC->execute();
                $resultAC = $statementAC->fetch();
                ?>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Indice de vente</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 counterPlugin"><?php if ($resultAC['date'] == null) {
                                                                                          echo "0";
                                                                                        } else {
                                                                                          echo number_format($resultAC['date'], 0, '.', ' ');
                                                                                        } ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 98.5%</span>
                                <span>Quantités illimités</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                $date = date("Y");
                if (isset($_GET["id"])=="") {
                  $queryProd = "SELECT  SUM(mt_ttc) /COUNt(tva.id_tva) as tarif FROM `tva` 
                      INNER JOIN client ON client.id_client=tva.id_client 
                      INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                      INNER JOIN user ON user.iduser=boutique.iduser

 WHERE DATE_FORMAT(`date`,'%Y')='$date' AND user.login='$mail' OR user.telephone_user='$mail'";
                } else {
                  $queryProd = "SELECT SUM(mt_ttc) /COUNt(tva.id_tva) as tarif FROM `tva` 
                  INNER JOIN client ON client.id_client=tva.id_client 
                      INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                   WHERE DATE_FORMAT(`date`,'%Y')=$date AND boutique.id_boutique='$id'";
                }
                $statementProd = $db->prepare($queryProd);
                $statementProd->execute();
                $resultProd = $statementProd->fetch();
                ?>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Panier Moyen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 counterPlugin"><?php if ($resultProd['tarif'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultProd['tarif'], 0, '.', ' ');
                                                                                  } ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                <span>Nombres illimités</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sort-numeric-down fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-----------Marge benefice----------------------->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Valeur ventes</div>
                            <?php
                $date = date("Y");
                if (isset($_GET["id"])=="") {
                  $queryTva = "SELECT SUM(prix*qte) as total_prix_vente FROM article 
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
    INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
    INNER JOIN user ON user.iduser=boutique.iduser
    WHERE user.login='$mail' OR user.telephone_user='$mail'
";
                } else {
                  $queryTva = "SELECT SUM(prix*qte) as total_prix_vente FROM article 
    INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
    INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
WHERE boutique.id_boutique='$id'";
                }
                $statementTva = $db->prepare($queryTva);
                $statementTva->execute();
                $resultTva = $statementTva->fetch();
                ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 counterPlugin"><?php if ($resultTva['total_prix_vente'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultTva['total_prix_vente'], 0, '.', ' ');
                                                                                  } ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 100%</span>
                                <span>Gains Annuels</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Valeur achats</div>
                            <?php
                $date = date("Y");
                if (isset($_GET["id"])=="") {
                  $queryVente = "SELECT SUM(prix_a * qte) as total_prix_a FROM article 
INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
INNER JOIN user ON user.iduser=boutique.iduser
WHERE user.login='$mail' OR user.telephone_user='$mail'

";
                } else {
                  $queryVente = "SELECT SUM(prix_a* qte) as total_prix_a FROM article 
                  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
                  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
WHERE boutique.id_boutique='$id'";
                }
                $statementVente = $db->prepare($queryVente);
                $statementVente->execute();
                $resultVente = $statementVente->fetch();
                ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 counterPlugin"><?php if ($resultVente['total_prix_a'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultVente["total_prix_a"], 0, '.', ' ');
                                                                                  } ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 80%</span>
                                <span>Nombres illimités</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cart-plus fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New User Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                $date = date("Y");
                if (isset($_GET["id"])=="") {
                  $queryAC = "SELECT SUM(prix*qte) as total_prix_vente, SUM(prix_a*qte) AS total_prix_achat FROM article 
                  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
                  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                  INNER JOIN user ON user.iduser=boutique.iduser
                  WHERE user.login='$mail' OR user.telephone_user='$mail'

";
                } else {
                  $queryAC = "SELECT SUM(prix*qte) as total_prix_vente, SUM(prix_a*qte) AS total_prix_achat FROM article 
                  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
                  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                      WHERE  boutique.id_boutique='$id'";
                }

                $statementAC = $db->prepare($queryAC);
                $statementAC->execute();
                $resultAC = $statementAC->fetch();
                ?>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">marge bénéficiaire</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 counterPlugin">
                                <?php  $marge=$resultAC['total_prix_vente']-$resultAC['total_prix_achat'];
                                                                                      if ($resultAC['total_prix_vente'] == 0) {
                                                                                          echo "0";
                                                                                        }else if ($resultAC['total_prix_achat'] == 0){
                                                                                          echo "0";
                                                                                        } else {
                                                                                          echo number_format($marge, 0, '.', ' ');
                                                                                        } ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 98.5%</span>
                                <span>Quantités illimités</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                $date = date("Y");
                if (isset($_GET["id"])=="") {
                  $queryProd = "SELECT SUM(qte) as total_stock FROM article 
                  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
                  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                  INNER JOIN user ON user.iduser=boutique.iduser
                  WHERE user.login='$mail' OR user.telephone_user='$mail'

";
                } else {
                  $queryProd = "SELECT SUM(qte) as total_stock FROM article 
                  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
                  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                   WHERE boutique.id_boutique='$id'";
                }
                $statementProd = $db->prepare($queryProd);
                $statementProd->execute();
                $resultProd = $statementProd->fetch();
                ?>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">total du stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 counterPlugin"><?php if ($resultProd['total_stock'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultProd['total_stock'], 0, '.', ' ');
                                                                                  } ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                <span>Nombres illimités</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sort-numeric-down fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/social-box-Facebok--->
        <?php
      $date = date("m-Y");
      $mois = date("M");

      if (isset($_GET["id"])=="") {
        $queryPourcv = "SELECT  count(*) * 100.0 / (select count(*) from tva) AS pourcentage FROM `tva` 
                      INNER JOIN client ON client.id_client=tva.id_client 
                      INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                      INNER JOIN user ON user.iduser=boutique.iduser

 WHERE DATE_FORMAT(`date`,'%m-%Y')='$date' AND user.login='$mail' OR user.telephone_user='$mail'";
      } else {
        $queryPourcv = "SELECT count(*) * 100.0 / (select count(*) from tva) AS pourcentage FROM `tva` 
                  INNER JOIN client ON client.id_client=tva.id_client 
                      INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
                   WHERE DATE_FORMAT(`date`,'%m-%Y')='$date' AND boutique.id_boutique='$id'";
      }
      $statementPourcv = $db->prepare($queryPourcv);
      $statementPourcv->execute();
      $resultPourcv = $statementPourcv->fetch();
      ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Client
                                (<?php setlocale(LC_TIME, 'fr_FR.utf8');
                                                                                  echo strftime("%B", strtotime($mois)); ?>)</div>
                            <div class="chart" data-percent="<?php if ($resultPourcv['pourcentage'] == null) {
                                                    echo "0";
                                                  } else {
                                                    echo $resultPourcv['pourcentage'];
                                                  } ?>" id="easy-pie-chart1">
                                <span class="percent counterPlugin"><?php if ($resultPourcv['pourcentage'] == null) {
                                                        echo "0";
                                                      } else {
                                                        echo number_format($resultPourcv['pourcentage'], 0, '.', ' ');
                                                      } ?></span>
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php if ($resultPourcv['pourcentage'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultPourcv['pourcentage'], 0, '.', ' ');
                                                                                  } ?>%</span>
                                <span>Achat des clients</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/social-box-Facebok--->
        <?php
      $date = date("m-Y");
      $mois = date("M");

      if (isset($_GET["id"])=="") {
        $queryPourcp = "SELECT count( article.id_article) * 100.0 / (select count(*) from vente 
INNER JOIN article ON article.id_article=vente.id_article) AS pourcentage FROM `vente` 
INNER JOIN tva ON tva.id_tva=vente.id_tva 
INNER JOIN article ON article.id_article=vente.id_article 
INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
INNER JOIN user ON user.iduser=boutique.iduser

 WHERE DATE_FORMAT(`date`,'%m-%Y')='$date' AND user.login='$mail' OR user.telephone_user='$mail'";
      } else {
        $queryPourcp = "SELECT count( article.id_article) * 100.0 / (select count(*) from vente 
                  INNER JOIN article ON article.id_article=vente.id_article) AS pourcentage FROM `vente` 
                  INNER JOIN tva ON tva.id_tva=vente.id_tva 
                  INNER JOIN article ON article.id_article=vente.id_article 
                  INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
                  INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                   WHERE DATE_FORMAT(`date`,'%m-%Y')='$date' AND boutique.id_boutique='$id'";
      }
      $statementPourcp = $db->prepare($queryPourcp);
      $statementPourcp->execute();
      $resultPourcp = $statementPourcp->fetch();
      ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Produit
                                (<?php setlocale(LC_TIME, 'fr_FR.utf8');
                                                                                    echo strftime("%B", strtotime($mois)); ?>)</div>
                            <div class="chart" data-percent="<?php if ($resultPourcp['pourcentage'] == null) {
                                                    echo "0";
                                                  } else {
                                                    echo $resultPourcp['pourcentage'];
                                                  } ?>" id="easy-pie-chart2">
                                <span class="percent counterPlugin"><?php if ($resultPourcp['pourcentage'] == null) {
                                                        echo "0";
                                                      } else {
                                                        echo number_format($resultPourcp['pourcentage'], 0, '.', ' ');
                                                      } ?></span>
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php if ($resultPourcp['pourcentage'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultPourcp['pourcentage'], 0, '.', ' ');
                                                                                  } ?>%</span>
                                <span>Produits vendus</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--/social-box-twitter--->
        <?php
      $date = date("m-Y");
      $mois = date("M");

      if (isset($_GET["id"])=="") {
        $queryPourcc = "SELECT count(*) * 100.0 / (select count(*) from commande)AS pourcentage FROM commande  
               INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
               INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
               INNER JOIN user ON user.iduser=boutique.iduser

 WHERE DATE_FORMAT(`date`,'%m-%Y')='$date' AND user.login='$mail' OR user.telephone_user='$mail'";
      } else {
        $queryPourcc = "SELECT count(*) * 100.0 / (select count(*) from commande )AS pourcentage FROM commande
                   INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
               INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
                   WHERE DATE_FORMAT(`date`,'%m-%Y')='$date' AND boutique.id_boutique='$id'";
      }
      $statementPourcc = $db->prepare($queryPourcc);
      $statementPourcc->execute();
      $resultPourcc = $statementPourcc->fetch();
      ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Commande
                                (<?php setlocale(LC_TIME, 'fr_FR.utf8');
                                                                                    echo strftime("%B", strtotime($mois)); ?>)</div>
                            <div class="chart" data-percent="<?php if ($resultPourcc['pourcentage'] == null) {
                                                    echo "0";
                                                  } else {
                                                    echo $resultPourcc['pourcentage'];
                                                  } ?>" id="easy-pie-chart3">
                                <span class="percent counterPlugin"><?php if ($resultPourcc['pourcentage'] == null) {
                                                        echo "0";
                                                      } else {
                                                        echo number_format($resultPourcc['pourcentage'], 0, '.', ' ');
                                                      } ?></span>
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i><?php if ($resultPourcc['pourcentage'] == null) {
                                                                                  echo "0";
                                                                                } else {
                                                                                  echo number_format($resultPourcc['pourcentage'], 0, '.', ' ');
                                                                                } ?>%</span>
                                <span>Commande</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/social-box-twitter--->
        <!--/social-box-linkedin--->
        <?php
      $date = date("m-Y");
      $mois = date("M");

      if (isset($_GET["id"])=="") {
        $queryPourcr = "SELECT count(*) * 100.0 / (select count(*) from reception)AS pourcentage FROM reception  
                INNER JOIN commande ON commande.id_commande=reception.id_commande
               INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
               INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
               INNER JOIN user ON user.iduser=boutique.iduser

 WHERE DATE_FORMAT(reception.date,'%m-%Y')='$date' AND user.login='$mail' OR user.telephone_user='$mail'";
      } else {
        $queryPourcr = "SELECT count(*) * 100.0 / (select count(*) from reception )AS pourcentage FROM reception
                   INNER JOIN commande ON commande.id_commande=reception.id_commande
               INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
               INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
                   WHERE DATE_FORMAT(reception.date,'%m-%Y')='$date' AND boutique.id_boutique='$id'";
      }
      $statementPourcr = $db->prepare($queryPourcr);
      $statementPourcr->execute();
      $resultPourcr = $statementPourcr->fetch();
      ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Reception
                                (<?php setlocale(LC_TIME, 'fr_FR.utf8');
                                                                                      echo strftime("%B", strtotime($mois)); ?>)</div>
                            <div class="chart" data-percent="<?php if ($resultPourcr['pourcentage'] == null) {
                                                    echo "0";
                                                  } else {
                                                    echo $resultPourcr['pourcentage'];
                                                  } ?>" id="easy-pie-chart4">
                                <span class="percent counterPlugin"><?php if ($resultPourcr['pourcentage'] == null) {
                                                        echo "0";
                                                      } else {
                                                        echo number_format($resultPourcr['pourcentage'], 0, '.', ' ');
                                                      } ?></span>
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php if ($resultPourcr['pourcentage'] == null) {
                                                                                    echo "0";
                                                                                  } else {
                                                                                    echo number_format($resultPourcr['pourcentage'], 0, '.', ' ');
                                                                                  } ?>%</span>
                                <span>Reception</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/social-box-linkedin--->
        <!--/social-box-google-plus--->

        <!--/social-box-google-plus--->
        <!-- Area Chart -->
        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-sm-6">
                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="hidden" name="" id="boutique" value="<?php if (isset($_GET["id"])=="") { }else { echo $id;} ?>">
                            <input type="hidden" name="" id="mail" value="<?php  echo $mail; ?>">
                        </div>
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Exporter:</div>
                            <a class="dropdown-item" id="action1"><i class="fas fa-download"></i>&nbsp;Telecharger</a>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 350px;" id="chart1">
                        <canvas id="chart_annee_mois" style="width: 100%;height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pie Chart -->
        <!-- bart Chart -->



        <!-- bar Chart -->
        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-sm-8">
                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Exporter:</div>
                            <a class="dropdown-item" id="action2"><i class="fas fa-download"></i>&nbsp;Telecharger</a>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 350px;" id="chart2">
                        <canvas id="cm" style="width: 100%;height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pie Chart -->

        <div class="col-xl-6 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-sm-8">
                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Exporter:</div>
                            <a class="dropdown-item" id="action3"><i class="fas fa-download"></i>&nbsp;Telecharger</a>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 350px;" id="chart3">
                        <canvas id="indice" style="width: 100%;height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- car Chart -->
        <div class="col-xl-6 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-sm-8">
                        <h6 class="m-0 font-weight-bold text-primary"></h6>
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Exporter:</div>
                            <a class="dropdown-item" id="action4"><i class="fas fa-download"></i>&nbsp;Telecharger</a>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 350px;" id="chart4">
                        <canvas id="panier" style="width: 100%;height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- car Chart -->
        <!-- sal Chart -->

        <!-- sal Chart -->

        <!-- Invoice Example -->

        <!-- Message From Customer-->
        <div class="col-xl-4 col-lg-5 ">
            <div class="card">

                <div>


                </div>
            </div>
        </div>
    </div>
    <!--Row-->

    <div class="row">
        <div class="col-lg-12 text-center">
            <p>Retrouvez-nous sur notre page <a href="#" class="btn btn-primary btn-sm" target="_blank"><i
                        class="fab fa-fw fa-facebook"></i>&nbsp;Facebook</a></p>
        </div>
    </div>


</div>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../js/ruang-admin.min.js"></script>
<!-- Page level plugins -->
<script src="../vendor/chart.js/Chart.min.js"></script>
<script src="../vendor/labelChart/chartjs-plugin-datalabels@0.7.js"></script>
<!-- Page level custom scripts -->
<script src="../js/demo/chart-area-demo.js"></script>
<script src="../js/demo/chart-pie-demo.js"></script>
<script src="../js/demo/chart-bar-demo.js"></script>

<script>
$(document).ready(function() {

    ca_mensuel();

    function ca_mensuel() {
        var boutique_s = $("#boutique").val();
        var mail = $("#mail").val();
        if (boutique_s == "") {
            $.ajax({
                url: "../statistique/dashboard/ca_nb",
                method: "POST",
                data: {
                    action: 'somme',mail:mail
                },
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                                label: 'Montant total',
                                backgroundColor: color,
                                color: '#fff',
                                data: total,
                                borderWidth: 2,
                                borderColor: "blue",
                            }

                        ]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var group_chart1 = $('#chart_annee_mois');

                    var graph1 = new Chart(group_chart1, {

                        type: "line",
                        data: chart_data,

                        options: {
                            title: {
                                display: true,
                                text: "Chiffre d'affaires par boutique",
                                fontSize: 15,
                                padding: 20
                            },
                            legend: {
                                position: 'bottom'
                            },
                            plugins: {
                                datalabels: {
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor;
                                    },
                                    borderColor: 'white',
                                    borderRadius: 25,
                                    borderWidth: 3,
                                    color: 'white',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 6,
                                    rotation: -90,
                                }
                            },
                            layout: {
                                padding: {
                                    right: 20
                                }
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    position: 'right',
                                    ticks: {
                                        beginAtZero: true,
                                        autoSkip: false,
                                        maxRotation: 90,
                                        minRotation: 90,
                                        fontSize: 15,
                                        padding: 25
                                    }
                                }]
                            }
                        }
                    });

                }
            })
        } else {
            $.ajax({
                url: "../statistique/dashboard/ca_nb",
                method: "POST",
                data: {
                    boutique_s: boutique_s
                },
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                                label: 'Montant total',
                                backgroundColor: color,
                                color: '#fff',
                                data: total,
                                borderWidth: 2,
                                borderColor: "blue",
                            }

                        ]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var group_chart1 = $('#chart_annee_mois');

                    var graph1 = new Chart(group_chart1, {

                        type: "line",
                        data: chart_data,

                        options: {
                            title: {
                                display: true,
                                text: "Chiffre d'affaires par boutique",
                                fontSize: 15,
                                padding: 20
                            },
                            legend: {
                                position: 'bottom'
                            },
                            plugins: {
                                datalabels: {
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor;
                                    },
                                    borderColor: 'white',
                                    borderRadius: 25,
                                    borderWidth: 3,
                                    color: 'white',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 6,
                                    rotation: -90,
                                }
                            },
                            layout: {
                                padding: {
                                    right: 20
                                }
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    position: 'right',
                                    ticks: {
                                        beginAtZero: true,
                                        autoSkip: false,
                                        maxRotation: 90,
                                        minRotation: 60,
                                        fontSize: 15,
                                        padding: 25
                                    }
                                }]
                            }
                        }
                    });

                }
            })
        }
    }
    var node = document.getElementById('chart1');
    var btn = document.getElementById('action1');

    btn.onclick = function() {
        domtoimage.toBlob(document.getElementById('chart1')).then(function(blob) {
            window.saveAs(blob, 'Graphique.png')
        })
    }
    nb_vente();

    function nb_vente() {
        var boutique_n = $("#boutique").val();
        var mail = $("#mail").val();
        if (boutique_n == "") {
            $.ajax({
                url: "../statistique/dashboard/ca_nb",
                method: "POST",
                data: {
                    action: 'nombre',mail:mail
                },
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                                label: 'Montant total',
                                backgroundColor: color,
                                color: '#fff',
                                data: total,
                            }

                        ]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var group_chart1 = $('#cm');

                    var graph1 = new Chart(group_chart1, {

                        type: "doughnut",
                        data: chart_data,
                        is3D: true,
                        options: {
                            title: {
                                display: true,
                                text: "Nombre de ventes",
                                fontSize: 15,
                            },
                            legend: {
                                position: 'right'
                            },
                            plugins: {
                                datalabels: {
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor;
                                    },
                                    borderColor: 'white',
                                    borderRadius: 25,
                                    borderWidth: 3,
                                    color: 'white',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 6,
                                    rotation: -90,
                                }
                            }

                        }
                    });

                }

            })
        } else {
            $.ajax({
                url: "../statistique/dashboard/ca_nb",
                method: "POST",
                data: {
                    boutique_n: boutique_n
                },
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                                label: 'Montant total',
                                backgroundColor: color,
                                color: '#fff',
                                data: total,
                            }

                        ]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var group_chart1 = $('#cm');

                    var graph1 = new Chart(group_chart1, {

                        type: "doughnut",
                        data: chart_data,
                        is3D: true,
                        options: {
                            title: {
                                display: true,
                                text: "Nombre de ventes",
                                fontSize: 15,
                            },
                            legend: {
                                position: 'right'
                            },
                            plugins: {
                                datalabels: {
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor;
                                    },
                                    borderColor: 'white',
                                    borderRadius: 25,
                                    borderWidth: 3,
                                    color: 'white',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 6,
                                    rotation: -90,
                                }
                            }

                        }
                    });

                }

            })
        }

    }
    var node = document.getElementById('chart2');
    var btn = document.getElementById('action2');

    btn.onclick = function() {
        domtoimage.toBlob(document.getElementById('chart2')).then(function(blob) {
            window.saveAs(blob, 'Graphique.png')
        })
    }
    indice_vente();

    function indice_vente() {
        var boutique_n = $("#boutique").val();
        var mail = $("#mail").val();
        if (boutique_n == "") {
            $.ajax({
                url: "../statistique/dashboard/indice_panier",
                method: "POST",
                data: {
                    action: 'indice',mail:mail
                },
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                                label: 'Montant total',
                                backgroundColor: color,
                                color: '#fff',
                                data: total,
                            }

                        ]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var group_chart1 = $('#indice');

                    var graph1 = new Chart(group_chart1, {

                        type: "doughnut",
                        data: chart_data,
                        is3D: true,
                        options: {
                            title: {
                                display: true,
                                text: "Indice de ventes",
                                fontSize: 15,
                            },
                            legend: {
                                position: 'right'
                            },
                            plugins: {
                                datalabels: {
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor;
                                    },
                                    borderColor: 'white',
                                    borderRadius: 25,
                                    borderWidth: 3,
                                    color: 'white',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 6,
                                    rotation: -90,
                                }
                            }

                        }
                    });

                }

            })
        } else {
            $.ajax({
                url: "../statistique/dashboard/indice_panier",
                method: "POST",
                data: {
                    boutique_n: boutique_n
                },
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                                label: 'Montant total',
                                backgroundColor: color,
                                color: '#fff',
                                data: total,
                            }

                        ]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var group_chart1 = $('#indice');

                    var graph1 = new Chart(group_chart1, {

                        type: "doughnut",
                        data: chart_data,
                        is3D: true,
                        options: {
                            title: {
                                display: true,
                                text: "Indice de ventes",
                                fontSize: 15,
                            },
                            legend: {
                                position: 'right'
                            },
                            plugins: {
                                datalabels: {
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor;
                                    },
                                    borderColor: 'white',
                                    borderRadius: 25,
                                    borderWidth: 3,
                                    color: 'white',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 6,
                                    rotation: -90,
                                }
                            }

                        }
                    });

                }

            })
        }

    }
    var node = document.getElementById('chart3');
    var btn = document.getElementById('action3');

    btn.onclick = function() {
        domtoimage.toBlob(document.getElementById('chart3')).then(function(blob) {
            window.saveAs(blob, 'Graphique.png')
        })
    }
    Panier_moyen();

    function Panier_moyen() {
        var boutique_s = $("#boutique").val();
        var mail = $("#mail").val();
        if (boutique_s == "") {
            $.ajax({
                url: "../statistique/dashboard/indice_panier",
                method: "POST",
                data: {
                    action: 'panier',mail:mail
                },
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                                label: 'Montant total',
                                backgroundColor: color,
                                color: '#fff',
                                data: total,
                                borderWidth: 2,
                                borderColor: "blue",
                            }

                        ]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var group_chart1 = $('#panier');

                    var graph1 = new Chart(group_chart1, {

                        type: "line",
                        data: chart_data,

                        options: {
                            title: {
                                display: true,
                                text: "Panier Moyen",
                                fontSize: 15,
                                padding: 20
                            },
                            legend: {
                                position: 'bottom'
                            },
                            plugins: {
                                datalabels: {
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor;
                                    },
                                    borderColor: 'white',
                                    borderRadius: 25,
                                    borderWidth: 3,
                                    color: 'white',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 6,
                                    rotation: -90,
                                }
                            },
                            layout: {
                                padding: {
                                    right: 20
                                }
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    position: 'right',
                                    ticks: {
                                        beginAtZero: true,
                                        autoSkip: false,
                                        maxRotation: 90,
                                        minRotation: 90,
                                        fontSize: 15,
                                        padding: 25
                                    }
                                }]
                            }
                        }
                    });

                }
            })
        } else {
            $.ajax({
                url: "../statistique/dashboard/indice_panier",
                method: "POST",
                data: {
                    boutique_s: boutique_s
                },
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                                label: 'Montant total',
                                backgroundColor: color,
                                color: '#fff',
                                data: total,
                                borderWidth: 2,
                                borderColor: "blue",
                            }

                        ]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };

                    var group_chart1 = $('#panier');

                    var graph1 = new Chart(group_chart1, {

                        type: "line",
                        data: chart_data,

                        options: {
                            title: {
                                display: true,
                                text: "Panier Moyen",
                                fontSize: 15,
                                padding: 20
                            },
                            legend: {
                                position: 'bottom'
                            },
                            plugins: {
                                datalabels: {
                                    backgroundColor: function(context) {
                                        return context.dataset.backgroundColor;
                                    },
                                    borderColor: 'white',
                                    borderRadius: 25,
                                    borderWidth: 3,
                                    color: 'white',
                                    font: {
                                        weight: 'bold'
                                    },
                                    padding: 6,
                                    rotation: -90,
                                }
                            },
                            layout: {
                                padding: {
                                    right: 20
                                }
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    position: 'right',
                                    ticks: {
                                        beginAtZero: true,
                                        autoSkip: false,
                                        maxRotation: 90,
                                        minRotation: 60,
                                        fontSize: 15,
                                        padding: 25
                                    }
                                }]
                            }
                        }
                    });

                }
            })
        }
    }
    var node = document.getElementById('chart4');
    var btn = document.getElementById('action4');

    btn.onclick = function() {
        domtoimage.toBlob(document.getElementById('chart4')).then(function(blob) {
            window.saveAs(blob, 'Graphique.png')
        })
    }
})
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('sworker.js');
}
</script>
<script type="text/javascript">
var chartSize = '70';

$('#easy-pie-chart1').easyPieChart({
    animate: 2000,
    scaleColor: false,
    lineWidth: 10,
    lineCap: 'square',
    size: chartSize,
    trackColor: '#e5e5e5',
    barColor: '#3da0ea'
});
$('#easy-pie-chart1').css({
    width: chartSize + 'px',
    height: chartSize + 'px'
});
$('#easy-pie-chart1 .percent').css({
    "line-height": chartSize + 'px'
})


$('#easy-pie-chart2').easyPieChart({
    animate: 2000,
    scaleColor: false,
    lineWidth: 10,
    lineCap: 'square',
    size: chartSize,
    trackColor: '#e5e5e5',
    barColor: '#36e617'
});
$('#easy-pie-chart2').css({
    width: chartSize + 'px',
    height: chartSize + 'px'
});
$('#easy-pie-chart2 .percent').css({
    "line-height": chartSize + 'px'
})

$('#easy-pie-chart3').easyPieChart({
    animate: 2000,
    scaleColor: false,
    lineWidth: 10,
    lineCap: 'square',
    size: chartSize,
    trackColor: '#e5e5e5',
    barColor: '#3da0ea'
});
$('#easy-pie-chart3').css({
    width: chartSize + 'px',
    height: chartSize + 'px'
});
$('#easy-pie-chart3 .percent').css({
    "line-height": chartSize + 'px'
})

$('#easy-pie-chart4').easyPieChart({
    animate: 2000,
    scaleColor: false,
    lineWidth: 10,
    lineCap: 'square',
    size: chartSize,
    trackColor: '#e5e5e5',
    barColor: '#36e617'
});
$('#easy-pie-chart4').css({
    width: chartSize + 'px',
    height: chartSize + 'px'
});
$('#easy-pie-chart4 .percent').css({
    "line-height": chartSize + 'px'
})
$(document).ready(function() {
    $('.counterPlugin').counterUp({
        'time': 1000,
        'delay': 10
    });
})
</script>
<!---Container Fluid-->
<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
  header("Location:../");
}
  }
?>