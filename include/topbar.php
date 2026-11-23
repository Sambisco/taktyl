<script>
$(document).ready(function() {
    function load_unseen_notification() {
        var id_boutiquess = $('#id_boutiquess').val();
        $.ajax({
            url: "../controller/notification",
            method: "POST",
            data: {
                view: 'view',
                id_boutiquess: id_boutiquess
            },
            dataType: "html",
            success: function(data) {
                $('#drop').html(data);
            }
        });

        $.ajax({
            url: "../controller/notification",
            method: "POST",
            data: {
                count: 'count',
                id_boutiquess: id_boutiquess
            },
            dataType: "json",
            success: function(data) {
                if (data.nombre > 0) {
                    $('#count').html(data.nombre);
                } else {
                    $('#count').hide();
                }
            }
        });
    }

    load_unseen_notification();
    $(document).on('click', '#alertsDropdown', function() {
        $('#count').html('');
        load_unseen_notification();

    });

    setInterval(function() {
        load_unseen_notification();;
    }, 5000);


});
</script>
<?php 
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];
  $id = encryptor('decrypt',$id);

}


?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
            <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-1 small"
                                    placeholder="Recherche..." aria-label="Search" aria-describedby="basic-addon2"
                                    style="border-color: #3f51b5;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <span class="badge badge-danger badge-counter" id="count"> </span>
                        <input type="hidden" name="" id="id_boutiquess" value="<?php if(isset($_GET['id'])==""){}else{echo $id;} ?>">
                    </a>
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header" style="text-align: center;">
                            Alerte Rupture de stock
                        </h6>
                        <a id="drop">

                        </a>
                        <?php if(isset($_GET['id'])==""){?>
                        <a class="dropdown-item text-center small  dropdown-header" style="font-size: 10px;color: #fff;"
                            href="#">Voir toutes les notifications</a>
                        <?php }else if(isset($_SESSION['profil'])==='Administrateur'){?>
                        <a class="dropdown-item text-center small dropdown-header" style="font-size: 10px;color: #fff;"
                            href="../controller/cree_commande.php?mail=<?php echo $mail ?>&id=<?php echo $id_b ?>">Voir
                            toutes les notifications</a>
                        <?php }else if(isset($_SESSION['profil'])==='Utilisateur'){?>
                        <a class="dropdown-item text-center small  dropdown-header" style="font-size: 10px;color: #fff;"
                            href="#">Voir toutes les notifications</a>
                        <?php }else{?>
                        <a class="dropdown-item text-center small dropdown-header" style="font-size: 10px;color: #fff;"
                            href="../controller/cree_commande.php?mail=<?php echo $mail ?>&id=<?php echo $id_b ?>">Voir
                            toutes les notifications</a>
                        <?php } ?>
                    </div>
                </li>
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <?php if(isset($_GET['mail']) && isset($_GET['id'])==""){ ?>
                        <img class="img-profile rounded-circle" src="../img/img/image.jpg" style="max-width: 60px">

                        <?php }else if(isset($_GET['b'])){ ?>

                        <img class="img-profile rounded-circle" src="../img/img/image.jpg" style="max-width: 60px">

                        <?php }else{
                  $query="SELECT * FROM boutique WHERE id_boutique='$id'";
                  $statement=$db->prepare($query);
                  $statement->execute();
                  $resultLogo=$statement->fetch();
                    ?>
                    <?php if($resultLogo['logo']==null){
                     ?>
                    <img class="img-profile rounded-circle" src="../img/img/image.jpg" style="max-width: 60px">

                     <?php   
                    }else{?>
                     <img class="img-profile rounded-circle" src="<?php echo $resultLogo['logo']; ?>" style="max-width: 60px">
                        <?php
                    }
                    }
                    ?>
                        <span class="ml-2 d-none d-lg-inline text-white small">
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
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            <?php 
                  if(isset($_SESSION['profil'])){ 
                    echo $_SESSION['nom_sub_user'];
                  }else{
                    echo $_SESSION['nomuser'];
                  }?>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                            data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Se déconnecter
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- Topbar -->