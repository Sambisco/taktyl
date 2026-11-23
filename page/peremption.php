<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (isset($_SESSION['email'])) {
  include('../include/script.php');
  include('../include/database.php');
  include('../include/css.php');
  include('../include/sidebar.php');
  include('../include/topbar.php');
?>
  <!-- Container Fluid-->
  <div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Peremption</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>">Accueil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
      </ol>
    </div>
    <?php
    if (isset($_SESSION['message_add'])) { ?>

      <div class="alert alert-primary alert-dismissible" role="alert" <?= $_SESSION['msg_type_add'] ?>>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <i class="fas fa-check"></i>
        <?php
        echo $_SESSION['message_add'];
        unset($_SESSION['message_add']);
        ?>
      </div>
    <?php } else if (isset($_SESSION['message_update'])) { ?>
      <div class="alert alert-success alert-dismissible " role="alert" <?= $_SESSION['msg_type_update'] ?>>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <i class="fas fa-check"></i>
        <?php
        echo $_SESSION['message_update'];
        unset($_SESSION['message_update']);
        ?>
      </div>
    <?php } else if (isset($_SESSION['message_delete'])) { ?>
      <div class="alert alert-danger alert-dismissible " role="alert" <?= $_SESSION['msg_type_delete'] ?>>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <i class="fas fa-check"></i>
        <?php
        echo $_SESSION['message_delete'];
        unset($_SESSION['message_delete']);
        ?>
      </div>
    <?php } ?>
    <div class="row">
      <div class="col-xl-12 col-lg-12">
        <div class="card mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <button type="button" class="btn btn-primary" id="btn_export">Export Excel</button>
          </div>
          <div class="card-body">
            <div class="table-responsive p-3">
              <table class="table align-items-center table-flush table-hover" id="dataTableHover" data-order='[[0,"desc"]]' width="100%">
                <thead class="thead-light">
                  <tr>
                    <th>Categorie</th>
                    <th>Prix</th>
                    <th>Date de péremption </th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $query = "SELECT *,DATE_FORMAT(date_p,'%d/%m/%Y') AS date_pp FROM article
                      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
                       INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                     WHERE boutique.id_boutique='$id'";
                  $statement = $db->prepare($query);
                  $statement->execute();
                  $result = $statement->fetchAll();
                  $total_row = $statement->rowCount();
                  if ($total_row > 0) {
                    foreach ($result as $row) {
                      if ($row['date_p'] == "0000-00-00") {
                      } else {
                  ?>
                        <tr>
                          <td><?php echo $row["categorie_stock"]; ?></td>
                          <td><?php echo $row["description_article"]; ?></td>
                          <td><?php echo $row["date_pp"]; ?></td>
                          <td><?php if (strtotime($row['date_p']) < strtotime(date('Y-m-d'))) { ?><i class="fas fa-ban fa-1x" style="color: red;"></i><?php } else { ?> <i class="fas fa-check fa-1x" style="color: green;"></i><?php } ?></td>
                        </tr>
                  <?php
                      }
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!------FORMULAIRE AJOUTER------->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Inséré un utilisateur</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <form action="../controller/user" method="post" enctype="multipart/form-data">
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nom complet</label>
            <input name="nom" type="text" class="form-control form-control-sm" placeholder="Nom complet" required>
          </div>
          <div class="form-group">
            <label>Email ou identifiant</label>
            <input name="login" type="text" class="form-control form-control-sm" placeholder="Email ou identifiant" required>
          </div>
          <div class="form-group">
            <label>Profil</label>
            <select name="profil" class="form-control form-control-sm" required="">
              <option>Selectionnez</option>
              <?php if ($_SESSION['profil'] === 'Super_admin') { ?>
                <option value="Super_admin">Super Administrateur</option>
                <option value="Administrateur">Administrateur</option>
                <option value="Utilisateur">Utilisateur</option>
              <?php } else if ($_SESSION['profil'] === 'Administrateur') { ?>
                <option value="Administrateur">Administrateur</option>
                <option value="Utilisateur">Utilisateur</option>
              <?php } ?>
            </select>
          </div>
          <input type="hidden" name="id_boutique" value="<?php echo $id; ?>">

          <div class="form-group">
            <label>Mot de passe</label>
            <input name="password" id="password" type="password" class="form-control form-control-sm" placeholder="Mot de passe" required>
          </div>
          <div class="form-group">
            <input name="password_show" id="password_show" type="hidden" class="form-control form-control-sm" placeholder="Mot de passe" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="insertdata">Enregister</button>
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE AJOUTER------->
  <!------FORMULAIRE MODIFIER------->
  <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Modifié un utilisateur</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
        <form action="../controller/user" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <input name="update_user" type="hidden" id="update_user">

            <div class="form-group">
              <label>Nom Complet</label>
              <input name="nom" type="text" id="nom" class="form-control form-control-sm" placeholder="Nom Complet" required readonly="">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input name="login" id="logins" type="text" class="form-control form-control-sm" placeholder="Email ou identifiant" required readonly="">
            </div>

            <div class="form-group">
              <label>Profil</label>
              <select name="profil" id="profil" class="form-control form-control-sm" required="">
                <option>Selectionnez</option>
                <?php if ($_SESSION['profil'] === 'Super_admin') { ?>
                  <option value="Super_admin">Super Administrateur</option>
                  <option value="Administrateur">Administrateur</option>
                  <option value="Utilisateur">Utilisateur</option>
                <?php } else if ($_SESSION['profil'] === 'Administrateur') { ?>
                  <option value="Administrateur">Administrateur</option>
                  <option value="Utilisateur">Utilisateur</option>
                <?php } ?>
              </select>
              <input type="hidden" name="id_boutique" value="<?php echo $id; ?>">

            </div>
            <div class="form-group">
              <label>Nouveau Mot de passe</label>
              <input name="newpassword" id="newpassword" type="password" class="form-control form-control-sm" placeholder="Nouveau Mot de passe" />
            </div>
            <div class="form-group">
              <input name="password_show" id="newpassword_show" type="hidden" class="form-control form-control-sm" placeholder="Nouveau Mot de passe" />
            </div>

          </div>

          <div class="modal-footer">
            <button type="submit" name="updatetdata" class="btn btn-primary">Modifier</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>


          </div>
        </form>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE MODIFIER------->
  <!------FORMULAIRE SUPPRIMER------->
  <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" area-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Supprimer un utilisateur</h5>
          <button class="close" data-dismiss="modal" aria-label="aria-label""close"><span aria-hidden="true"></span>&times;</button>
        </div>
        <form action="../controller/user" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <input name="delete_id" type="hidden" id="delete_id" />
            <input type="hidden" name="id_boutique" value="<?php echo $id; ?>">

            <h4>Voulez-vous vraiment supprimer un utilisateur ?</h4>

          </div>

          <div class="modal-footer">
            <button type="submit" name="deletedata" class="btn btn-primary">Supprimer</button>
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>


          </div>
        </form>
      </div>
    </div>
  </div>
  <!------FIN FORMULAIRE SUPPRIMER------->

  <input type="hidden" name="" id="information">

  <!------FORMULAIRE INFO------->
  <div class="modal fade" tabindex="-1" role="dialog" id="vocal">
    <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
      <span class="fa fa-spinner fa-spin fa-3x" style="color:#fff"></span>
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

  <!---Container Fluid-->
  <script>
    $(document).ready(function() {
      $('#id_boutique').select2({
        dropdownParent: $("#exampleModal")
      });
      $('#edit_id_boutique').select2({
        dropdownParent: $("#editmodal")
      });

      $(".editbtn").click(function() {
        $("#editmodal").modal('show');
        $str = $(this).closest('tr');
        var data = $str.children("td").map(function() {
          return $(this).text();
        }).get();
        console.log(data);
        $("#update_user").val(data[0]);
        $("#nom").val(data[1]);
        $("#logins").val(data[2]);
        $("#profil").val(data[3]);
      });
    });
    $(document).ready(function() {
      $(".deletebtn").click(function() {
        $("#deletemodal").modal('show');
        $str = $(this).closest('tr');
        var data = $str.children("td").map(function() {
          return $(this).text();
        }).get();
        console.log(data);
        $("#delete_id").val(data[0]);
      });
    });
    $(document).ready(function() {

      $(document).on('input', '#password', function(e) {
        e.preventDefault();
        $("#password_show").val($("#password").val());
      });
      $(document).on('input', '#newpassword', function(e) {
        e.preventDefault();
        $("#newpassword_show").val($("#newpassword").val());
      });

    })
  </script>
  <script>
    $(document).ready(function() {
      $('#dataTableHover').DataTable({
        "language": {
          "sEmptyTable": "Aucune donnée disponible dans le tableau",
          "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
          "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
          "sInfoFiltered": "(filtré à partir de _MAX_ éléments au total)",
          "sInfoPostFix": "",
          "sInfoThousands": ",",
          "sLengthMenu": "Afficher _MENU_ éléments",
          "sLoadingRecords": "Chargement...",
          "sProcessing": "Traitement...",
          "sSearch": "Rechercher :",
          "sZeroRecords": "Aucun élément correspondant trouvé",
          "oPaginate": {
            "sFirst": "Premier",
            "sLast": "Dernier",
            "sNext": "Suivant",
            "sPrevious": "Précédent"
          },
          "oAria": {
            "sSortAscending": ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
          },
          "select": {
            "rows": {
              "_": "%d lignes sélectionnées",
              "0": "Aucune ligne sélectionnée",
              "1": "1 ligne sélectionnée"
            }
          }
        }
      }); // ID From dataTable with Hover
    });
  </script>
  <script type="text/javascript">
    $('#btn_export').click(function() {
      $("#dataTableHover").table2excel({
        exclure: ".excludeThisClass",
        name: "Worksheet Name",
        filename: "peremption.xls", // inclure l'extension 
        preserveColors: false // définir sur true si vous souhaitez que les couleurs d'arrière-plan et les couleurs de police soient préservées 
      });
    });
  </script>
  <script>
    if (annyang) {
      annyang.setLanguage('fr-FR');
      // Let's define our first command. First the text we expect, and then the function it should call
      var commands = {
        'exporter': function() {
          $('#btn_export').click();
        },

      };

      // Add our commands to annyang
      annyang.addCommands(commands);

      // Start listening. You can call this here, or attach this call to an event, button, etc.
      annyang.start();
    }
  </script>
<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
  header("Location:../");
}
?>