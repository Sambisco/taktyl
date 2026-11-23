<?php
include('config.php');
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];
  $id = encryptor('decrypt',$id);

}
$id_m = encryptor('encrypt', $id);
$id_d = encryptor('encrypt', 0);

?>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <?php
       
      $query = "SELECT * FROM `boutique` WHERE id_boutique='$id'";
      $statement = $db->prepare($query);
      $statement->execute();
      $resultLogo = $statement->fetch();
        
      ?>
      <?php
      if ($_SESSION['profil'] == 'Super_admin') {
       
      ?>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../page/dashboard?id=<?php echo $id_m; ?>">
        <?php } else if ($_SESSION['profil'] == 'Administrateur') { 
          
          ?>
          <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../page/dashboard?id=<?php echo $id_m; ?>">
          <?php } else if ($_SESSION['profil'] == 'Utilisateur') { ?>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">

            <?php } ?>
            <div class="sidebar-brand-icon">
              <?php
              if ($_SESSION['profil'] == 'Super_admin') {
                $query = "SELECT * FROM `boutique`";
              } else {

                $query = "SELECT * FROM `boutique` WHERE id_boutique='$id'";
              }
              $statement = $db->prepare($query);
              $statement->execute();
              $result = $statement->fetchAll();

              ?>
              <img src="../img/logo/taktyl.jpg">
            </div>
            <div class="sidebar-brand-text mx-3">TAKTIL-LITE</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
              <?php
              if ($_SESSION['profil'] == 'Super_admin') {

              ?>
                <a class="nav-link" href="../page/dashboard?id=<?php echo $id_d ?>">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span><?php if ($id == 0) {
                          echo "Boutique";
                        } else {
                          echo $resultLogo['nomb'];
                        } ?></span></a>
              <?php } else  if ($_SESSION['profil'] == 'Administrateur') {?>
                <a class="nav-link" href="../page/dashboard?id=<?php echo $id_m ?>">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span><?php if ($id == 0) {
                          echo "Boutique";
                        } else {
                          echo $resultLogo['nomb'];
                        } ?></span></a>
              <?php } else  if ($_SESSION['profil'] == 'Utilisateur') { ?>
                <a class="nav-link" href="#">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span><?php if ($id == 0) {
                          echo "Boutique";
                        } else {
                          echo $resultLogo['nomb'];
                        } ?></span></a>
              <?php } ?>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
              Menu Principal
            </div>

            <?php if ($id == 0) { ?>
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
                  <i class="fas fa-fw fa-home"></i>
                  <span>Boutique</span>
                </a>
                <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="../page/boutique?id=<?php echo $id_d;  ?>">Creer une boutique</a>
                    <?php
                    $total_row = $statement->rowCount();
                    if ($total_row > 0) {
                      foreach ($result as $row) {
                     $id = encryptor('encrypt', $row["id_boutique"]);
                      
                    ?>
                        <a class="collapse-item" href="../page/dashboard?id=<?php echo $id;  ?>"><?php echo $row["nomb"]; ?></a>
                    <?php
                      }
                    }
                    ?>
                  </div>
                </div>
              </li>
            <?php } else { ?>
              <script>
                if (annyang) {
                  annyang.setLanguage('fr-FR');
                  // Let's define our first command. First the text we expect, and then the function it should call
                  var commands = {
                    continuous: true,
                    'menu vente': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/vente?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'déconnecter': function() {
                      $('#logoutModal').modal('show');

                    },
                    'annuler': function() {
                      $('#logoutModal').modal('hide');

                    },
                    'se déconnecter': function() {
                      $('#logoutModal').modal('hide');
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../controller/deconnecte";

                      }, 3000);
                    },
                  };

                  // Add our commands to annyang
                  annyang.addCommands(commands);

                  // Start listening. You can call this here, or attach this call to an event, button, etc.
                  annyang.start();
                }
              </script>
              <?php if ($_SESSION['profil'] == 'Administrateur') {
                
                ?>
                
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true" aria-controls="collapseForm">
                    <i class="fa fa-fw fa-product-hunt"></i>
                    <span>Article</span>
                  </a>
                  <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/categorie_article?id=<?php echo $id_m;  ?>">Categorie</a>
                      <a class="collapse-item" href="../page/article?id=<?php echo $id_m;  ?>">Article</a>
                      <a class="collapse-item" href="../page/promotion?id=<?php echo $id_m;  ?>">Promotion</a>
                      <a class="collapse-item" href="../page/peremption?id=<?php echo $id_m;  ?>">Peremption</a>
                    </div>
                  </div>
                </li>
              <?php } else if ($_SESSION['profil'] == 'Super_admin') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true" aria-controls="collapseForm">
                    <i class="fa fa-fw fa-product-hunt"></i>
                    <span>Article</span>
                  </a>
                  <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/categorie_article?id=<?php echo $id_m;  ?>">Categorie</a>
                      <a class="collapse-item" href="../page/article?id=<?php echo $id_m;  ?>">Article</a>
                      <a class="collapse-item" href="../page/promotion?id=<?php echo $id_m;  ?>">Promotion</a>
                      <a class="collapse-item" href="../page/peremption?id=<?php echo $id_m;  ?>">Peremption</a>
                    </div>
                  </div>
                </li>
              <?php } ?>
              <?php if ($_SESSION['profil'] == 'Administrateur') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="fas fa-fw fa-car"></i>
                    <span>Approvisionnement</span>
                  </a>
                  <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/fournisseur?id=<?php echo $id_m;  ?>">Fournisseur</a>
                      <a class="collapse-item" href="../page/commande?id=<?php echo $id_m;  ?>">Commande</a>
                      <a class="collapse-item" href="../page/reception?id=<?php echo $id_m;  ?>">Reception</a>
                    </div>
                </li>
              <?php } else if ($_SESSION['profil'] == 'Super_admin') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="fas fa-fw fa-car"></i>
                    <span>Approvisionnement</span>
                  </a>
                  <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/fournisseur?id=<?php echo $id_m;  ?>">Fournisseur</a>
                      <a class="collapse-item" href="../page/commande?id=<?php echo $id_m;  ?>">Commande</a>
                      <a class="collapse-item" href="../page/reception?id=<?php echo $id_m;  ?>">Reception</a>
                    </div>
                </li>
              <?php } ?>
              <?php if ($_SESSION['profil'] === 'Super_admin') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
                    <i class="fas fa-shopping-cart "></i>
                    <span>Vente</span>
                  </a>
                  <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/vente?id=<?php echo $id_m; ?>">Vente</a>
                      <a class="collapse-item" href="../page/categorie_client?id=<?php echo $id_m; ?>">Categorie client</a>
                      <a class="collapse-item" href="../page/client?id=<?php echo $id_m; ?>">Client</a>
                    </div>
                  </div>
                </li>
              <?php } else if ($_SESSION['profil'] === 'Administrateur') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
                    <i class="fas fa-shopping-cart "></i>
                    <span>Vente</span>
                  </a>
                  <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/vente?id=<?php echo $id_m; ?>">Vente</a>
                      <a class="collapse-item" href="../page/categorie_client?id=<?php echo $id_m; ?>">Categorie client</a>
                      <a class="collapse-item" href="../page/client?id=<?php echo $id_m; ?>">Client</a>
                    </div>
                  </div>
                </li>

              <?php } else if ($_SESSION['profil'] === 'Utilisateur') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
                    <i class="fas fa-shopping-cart "></i>
                    <span>Vente</span>
                  </a>
                  <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/vente?id=<?php echo $id_m;  ?>">Vente</a>
                    </div>
                  </div>
                </li>
              <?php } ?>
              <?php if ($_SESSION['profil'] === 'Super_admin') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Business Intelligence</span>
                  </a>
                  <div id="collapsePages" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Rapport</h6>
                      <a class="collapse-item" href="../journal/valeur_stock?id=<?php echo $id_m;  ?>">Valeur Stocks</a>
                      <a class="collapse-item" href="../journal/ca_annuel?id=<?php echo $id_m;  ?>">Rapport de ventes</a>
                      <a class="collapse-item" href="../journal/ra_achat?id=<?php echo $id_m;  ?>">Rapport d'achats</a>
                      <a class="collapse-item" href="../journal/ra_reception_annuel?id=<?php echo $id_m;  ?>">Rapport d'inventaires</a>
                      <a class="collapse-item" href="../journal/fid_annuel?id=<?php echo $id_m;  ?>" >Rapport de fidelités</a>
                    </div>
                  </div>
                </li>
              <?php } else if ($_SESSION['profil'] === 'Administrateur') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Business Intelligence</span>
                  </a>
                  <div id="collapsePages" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Rapport</h6>
                      <a class="collapse-item" href="../journal/valeur_stock?id=<?php echo $id_m;  ?>">Valeur Stocks</a>
                      <a class="collapse-item" href="../journal/ca_annuel?id=<?php echo $id_m;  ?>">Rapport de ventes</a>
                      <a class="collapse-item" href="../journal/ra_achat?id=<?php echo $id_m;  ?>">Rapport d'achats</a>
                      <a class="collapse-item" href="../journal/ra_commande_annuel?id=<?php echo $id_m;  ?>">Rapport d'inventaires</a>
                      <a class="collapse-item" href="../journal/fid_annuel?id=<?php echo $id_m;  ?>" >Rapport de fidelités</a>
                    </div>
                  </div>
                </li>
              <?php
              }
              ?>
              <?php if ($_SESSION['profil'] === 'Super_admin') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagess" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Messagerie</span>
                  </a>
                  <div id="collapsePagess" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/configuration?id=<?php echo $id_m;  ?>">Configuration</a>
                      <a class="collapse-item" href="../page/message?id=<?php echo $id_m;  ?>">Message</a>
                    </div>
                  </div>
                </li>
              <?php } else if ($_SESSION['profil'] === 'Administrateur') { ?>
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagess" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Messagerie</span>
                  </a>
                  <div id="collapsePagess" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="../page/configuration?id=<?php echo $id_m;  ?>">Configuration</a>
                      <a class="collapse-item" href="../page/message?id=<?php echo $id_m;  ?>">Message</a>

                    </div>
                  </div>
                </li>
              <?php
              }
              ?>
              <!-------VOCAL----------->
              <?php if ($_SESSION['profil'] === 'Super_admin') { ?>
                <script>
                if (annyang) {
                  annyang.setLanguage('fr-FR');
                  // Let's define our first command. First the text we expect, and then the function it should call
                  var commands = {
                    continuous:true,
                    'menu tableau de bord': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/dashboard?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu catégorie article': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/categorie_article?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu article': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/article?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu promotion': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/promotion?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu péremption': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/peremption?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu fournisseur': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/fournisseur?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu commande': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/commande?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu réception': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/reception?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu vente': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/vente?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu catégorie client': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/categorie_client?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu client': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/client?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'rapport vente': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../journal/ca_annuel?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'rapport achat': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../journal/ca_annuel?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'rapport inventaire': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../journal/ra_reception_annuel?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    
                     'rapport fidélité': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                       console.log('completed');
                       $('#vocal').modal('hide');
                       window.location.href = "../journal/fid_annuel?id=<?php echo  $id_m; ?>";
                      }, 3000);
                    },
                    'menu configuration': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/configuration?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu message': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/message?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu utilisateur': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/user?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'déconnecter': function() {
                      $('#logoutModal').modal('show');

                    },
                    'annuler': function() {
                      $('#annuler').click();

                    },
                    'se déconnecter': function() {
                      $('#logoutModal').modal('hide');
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../controller/deconnecte";

                      }, 3000);
                    },
                  };

                  // Add our commands to annyang
                  annyang.addCommands(commands);

                  // Start listening. You can call this here, or attach this call to an event, button, etc.
                  annyang.start();
                }
              </script>
              <?php } else if ($_SESSION['profil'] === 'Administrateur') { ?>
                <script>
                if (annyang) {
                  annyang.setLanguage('fr-FR');
                  // Let's define our first command. First the text we expect, and then the function it should call
                  var commands = {
                    continuous:true,
                    'menu tableau de bord': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/dashboard?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu catégorie article': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/categorie_article?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'article': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/article?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu promotion': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/promotion?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu péremption': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/peremption?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu fournisseur': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/fournisseur?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu commande': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/commande?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu réception': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/reception?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu vente': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/vente?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu catégorie client': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/categorie_client?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu client': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/client?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'rapport vente': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../journal/ca_annuel?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'rapport achat': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../journal/ca_annuel?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'rapport inventaire': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../journal/ra_reception_annuel?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'rapport fidélité': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../journal/fid_annuel?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu configuration': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/configuration?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu message': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/message?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'menu utilisateur': function() {
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../page/user?id=<?php echo  $id_m; ?>";

                      }, 3000);
                    },
                    'déconnecter': function() {
                      $('#logoutModal').modal('show');

                    },
                    'annuler': function() {
                      $('#annuler').click();

                    },
                    'se déconnecter': function() {
                      $('#logoutModal').modal('hide');
                      $('#vocal').modal('show');
                      setTimeout(function() {
                        console.log('completed');
                        $('#vocal').modal('hide');
                        window.location.href = "../controller/deconnecte";

                      }, 3000);
                    },
                  };

                  // Add our commands to annyang
                  annyang.addCommands(commands);

                  // Start listening. You can call this here, or attach this call to an event, button, etc.
                  annyang.start();
                }
              </script>
              <?php
              }
              ?>
               <!-------VOCAL----------->
            <?php
            }
            ?>
            <?php
            if ($id == 0) {
            } else if ($_SESSION['profil'] == 'Super_admin') { ?>
              <li class="nav-item">
                <a class="nav-link collapsed" href="../page/user?id=<?php echo $id_m;  ?>">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Utilisateurs</span>
                </a>
              </li>
            <?php  } else if ($_SESSION['profil'] == 'Administrateur') { ?>
              <li class="nav-item">
                <a class="nav-link collapsed" href="../page/user?id=<?php echo $id_m;  ?>">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Utilisateurs</span>
                </a>
              </li>
            <?php
            } else if ($_SESSION['profil'] == 'Utilisateur') {
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
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
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="annuler">Annuler</button>
          </div>
        </div>
      </div>
    </div>