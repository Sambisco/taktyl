<?php
include('config.php');

if (isset($_GET['mail'])) {
  $mail= $_SESSION['mail']=$_GET['mail'];
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];
  $id = encryptor('decrypt',$id);
  $id_b = encryptor('encrypt',$id);
}

$query = "SELECT * FROM user  WHERE login='$mail' OR telephone_user='$mail'";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetch();
$iduser=$result['iduser'];
$id_m = encryptor('encrypt', $iduser);
                     
?>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <img src="../img/logo/taktyl.jpg">
                </div>
                <div class="sidebar-brand-text mx-3">TAKTYL</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <?php if(isset($_SESSION['profil'])){
              ?>
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>

                        <?php 
                    if($_SESSION['nomb']==null){

                    }else{
                    echo $_SESSION['nomb'];
                  }
                  ?>
                    </span>
                </a>
                <?php
                }else{
                ?>
                <a class="nav-link" href="../page/dashboard?mail=<?php echo $mail ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>

                        <?php 
                    if(isset($_GET['mail']) && isset($_GET['id'])==""){ 
                      echo "Boutique";
                    }else if(isset($_GET['b'])){ 
                      echo "Boutique";
                    }else{
                      $query = "SELECT * FROM boutique INNER JOIN user ON boutique.iduser=user.iduser WHERE boutique.id_boutique='$id'";
                      $statement = $db->prepare($query);
                      $statement->execute();
                      $result = $statement->fetch();
                      if($result['id_boutique']==""){
                       echo "Boutique";
                      }else{
                        echo $result['nomb'];
                      }
                    }
                  ?>
                    </span>
                </a>
                <?php  
                }
                  ?>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Menu Principal
            </div>
            <!------------BOUTIQUE---------------------->

            <?php if(isset($_GET['mail']) && isset($_GET['id'])==""){?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable"
                    aria-expanded="true" aria-controls="collapseTable">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Boutique</span>
                </a>
                <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/boutique?mail=<?php echo $mail;?>&id=<?php echo $id_m;?>&b">Creer une
                            boutique</a>

                        <?php
                    $query = "SELECT * FROM boutique INNER JOIN user ON boutique.iduser=user.iduser WHERE login='$mail' OR telephone_user='$mail'";
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    $total_row = $statement->rowCount();
                    if ($total_row > 0) {
                        ?>
                        <?php 
                      

                        foreach ($result as $row) {
                          $id_b = encryptor('encrypt', $row["id_boutique"]);
                    ?>
                        <a class="collapse-item"
                            href="../page/dashboard?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>"><?php echo $row["nomb"]; ?></a>
                        <?php
                      }
                    }
                    ?>
                    </div>
                </div>
            </li>
            <?php }else if(isset($_GET['mail']) && isset($_GET['b'])){ ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable"
                    aria-expanded="true" aria-controls="collapseTable">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Boutique</span>
                </a>
                <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/boutique?mail=<?php echo $mail;?>&id=<?php echo $id_m;?>&b">Creer une
                            boutique</a>

                        <?php
                    $query = "SELECT * FROM boutique INNER JOIN user ON boutique.iduser=user.iduser WHERE login='$mail' OR telephone_user='$mail'";
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    $total_row = $statement->rowCount();
                    if ($total_row > 0) {
                        ?>
                        <?php 
                      foreach ($result as $row) {
                          $id_b = encryptor('encrypt', $row["id_boutique"]);
                    ?>
                        <a class="collapse-item"
                            href="../page/dashboard?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>"><?php echo $row["nomb"]; ?></a>
                        <?php
                      }
                    }
                    ?>
                    </div>
                </div>
            </li>
            <!------------BOUTIQUE---------------------->
            <?php 
             }else { 
              if (isset($_SESSION['profil'])) {
                if( $_SESSION["profil"]=="Utilisateur"){
              ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage"
                    aria-expanded="true" aria-controls="collapsePage">
                    <i class="fas fa-shopping-cart "></i>
                    <span>Vente</span>
                </a>
                <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/vente?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Vente</a>

                    </div>
                </div>
            </li>
            <?php
                }else{
               ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm"
                    aria-expanded="true" aria-controls="collapseForm">
                    <i class="fa fa-fw fa-product-hunt"></i>
                    <span>Article</span>
                </a>
                <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/categorie_article?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Categorie</a>
                        <a class="collapse-item"
                            href="../page/article?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Article</a>
                        <a class="collapse-item"
                            href="../page/promotion?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Promotion</a>
                        <a class="collapse-item"
                            href="../page/peremption?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Peremption</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="fas fa-fw fa-car"></i>
                    <span>Approvisionnement</span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/fournisseur?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Fournisseur</a>
                        <a class="collapse-item"
                            href="../page/commande?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Commande</a>
                        <a class="collapse-item"
                            href="../page/reception?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Reception</a>
                    </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage"
                    aria-expanded="true" aria-controls="collapsePage">
                    <i class="fas fa-shopping-cart "></i>
                    <span>Vente</span>
                </a>
                <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/vente?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Vente</a>
                        <a class="collapse-item"
                            href="../page/categorie_client?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Categorie
                            client</a>
                        <a class="collapse-item"
                            href="../page/client?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Client</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Business Intelligence</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Rapport</h6>
                        <a class="collapse-item"
                            href="../journal/valeur_stock?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Valeur
                            Stocks</a>
                        <a class="collapse-item"
                            href="../journal/ca_annuel?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Rapport de
                            ventes</a>
                        <a class="collapse-item"
                            href="../journal/ra_achat?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Rapport
                            d'achats</a>
                        <a class="collapse-item"
                            href="../journal/ra_reception_annuel?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Rapport
                            d'inventaires</a>
                        <a class="collapse-item"
                            href="../journal/fid_annuel?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Rapport de
                            fidelités</a>
                    </div>
                </div>
            </li>
            <li class="nav-item" style="display:none">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagess"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Messagerie</span>
                </a>
                <div id="collapsePagess" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/configuration?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Configuration</a>
                        <a class="collapse-item"
                            href="../page/message?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Message</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="../page/user?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <?php
                }
                }else{
              ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm"
                    aria-expanded="true" aria-controls="collapseForm">
                    <i class="fa fa-fw fa-product-hunt"></i>
                    <span>Article</span>
                </a>
                <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/categorie_article?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Categorie</a>
                        <a class="collapse-item"
                            href="../page/article?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Article</a>
                        <a class="collapse-item"
                            href="../page/promotion?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Promotion</a>
                        <a class="collapse-item"
                            href="../page/peremption?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Peremption</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="fas fa-fw fa-car"></i>
                    <span>Approvisionnement</span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/fournisseur?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Fournisseur</a>
                        <a class="collapse-item"
                            href="../page/commande?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Commande</a>
                        <a class="collapse-item"
                            href="../page/reception?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Reception</a>
                    </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage"
                    aria-expanded="true" aria-controls="collapsePage">
                    <i class="fas fa-shopping-cart "></i>
                    <span>Vente</span>
                </a>
                <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/vente?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Vente</a>
                        <a class="collapse-item"
                            href="../page/categorie_client?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Categorie
                            client</a>
                        <a class="collapse-item"
                            href="../page/client?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Client</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Business Intelligence</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Rapport</h6>
                        <a class="collapse-item"
                            href="../journal/valeur_stock?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Valeur
                            Stocks</a>
                        <a class="collapse-item"
                            href="../journal/ca_annuel?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Rapport de
                            ventes</a>
                        <a class="collapse-item"
                            href="../journal/ra_achat?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Rapport
                            d'achats</a>
                        <a class="collapse-item"
                            href="../journal/ra_reception_annuel?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Rapport
                            d'inventaires</a>
                        <a class="collapse-item"
                            href="../journal/fid_annuel?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Rapport de
                            fidelités</a>
                    </div>
                </div>
            </li>
            <li class="nav-item" style="display:none">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagess"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Messagerie</span>
                </a>
                <div id="collapsePagess" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"
                            href="../page/configuration?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Configuration</a>
                        <a class="collapse-item"
                            href="../page/message?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">Message</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="../page/user?mail=<?php echo $mail;?>&id=<?php echo $id_b;  ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <?php
                }
             }
            ?>
            <hr class="sidebar-divider">
            <div class="version" id="version-ruangadmin"></div>
        </ul>
        <!-- Sidebar -->
        <div class="modal fade" tabindex="-1" role="dialog" id="vocal">
            <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
                <span class="fa fa-spinner fa-spin fa-3x" style="color:#fff"></span>
            </div>
        </div>
        <!-- Modal Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à mettre fin à votre session en cours
                            ?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="../controller/deconnecte" class="btn btn-primary" id="deconnecte">Déconnexion</a>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal"
                            id="annuler">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
