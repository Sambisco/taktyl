<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if(isset($_SESSION['email'])){
include('../include/script.php');
include('../include/database.php');
include('../include/css.php');
include('../include/sidebar.php');
include('../include/topbar.php');
?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Valeur stock</h1>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../page/dashboard?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
        </ol>
    </div>
    <?php 
	if(isset($_SESSION['message_add'])){?>

    <div class="alert alert-primary alert-dismissible" role="alert" <?=$_SESSION['msg_type_add'] ?>>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="fas fa-check"></i>
        <?php 
	echo $_SESSION['message_add'];
	unset($_SESSION['message_add']);
	?>
    </div>
    <?php }else if(isset($_SESSION['message_update'])){?>
    <div class="alert alert-success alert-dismissible " role="alert" <?=$_SESSION['msg_type_update'] ?>>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="fas fa-check"></i>
        <?php 
	echo $_SESSION['message_update'];
	unset($_SESSION['message_update']);
	?>
    </div>
    <?php }else if(isset($_SESSION['message_delete'])){?>
    <div class="alert alert-danger alert-dismissible " role="alert" <?=$_SESSION['msg_type_delete'] ?>>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="fas fa-check"></i>
        <?php 
	echo $_SESSION['message_delete'];
	unset($_SESSION['message_delete']);
	?>
    </div>
    <?php }?>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Tabs navs -->
<ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
  <li class="nav-item" role="presentation">
    <a
      class="nav-link active"
      id="ex1-tab-1"
      data-mdb-toggle="tab"
      href="#ex1-tabs-1"
      data-toggle="tab"
      aria-controls="ex1-tabs-1"
      aria-selected="true"
      >Valeur vente</a
    >
  </li>
  <li class="nav-item" role="presentation">
    <a
      class="nav-link"
      id="ex1-tab-2"
      data-mdb-toggle="tab"
      href="#ex1-tabs-2"
      data-toggle="tab"
      aria-controls="ex1-tabs-2"
      aria-selected="false"
      >Valeur achat</a
    >
  </li>
  
</ul>
<!-- Tabs navs -->

<!-- Tabs content -->
<div class="tab-content" id="ex1-content">
  <div
    class="tab-pane fade show active"
    id="ex1-tabs-1"
    role="tabpanel"
    aria-labelledby="ex1-tab-1"
  >
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <button type="button" class="btn btn-primary" id="btn_export_v">Export Excel</button>
                </div>
                <div class="table-responsive p-3">
  <table class="table align-items-center table-flush table-hover" id="dataTableHover_v"
                            data-order='[[0,"desc"]]' width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Categorie</th>
                                    <th>Article</th>
                                    <th>P. vente</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th style="display:none">Total</th>
                                </tr>
                            </thead>
                            <tfoot>
              <tr>
                  <th colspan="3">Total</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th style="display:none"></th>
                </tr>
              </tfoot>
                            <tbody>
                                <?php 
                      $query="SELECT *,prix * qte as total FROM article 
                      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
                      INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                      WHERE boutique.id_boutique='$id'";
                      $statement=$db->prepare($query);
                      $statement->execute();
                      $result=$statement->fetchAll();
                      $total_row=$statement->rowCount();
					  if ($total_row>0){
		               foreach($result as $row){
					  ?>
                                <tr>
                                    <td><?php echo $row["id_id_article"];?></td>
                                    <td><?php echo $row["categorie_stock"];?></td>
                                    <td><?php echo $row["description_article"];?></td>
                                    <td><?php echo number_format($row["prix"], 0, '.', ' ');?></td>
                                    <td><?php echo $row["qte"];?></td>
                                    <td><?php echo number_format($row["total"], 0, '.', ' ');?></td>
                                    <td style="display:none"><?php echo $row["total"];?></td>
                                </tr>
                                <?php
                    }
                }
                      ?>
                            </tbody>
                        </table>
            </div>
  </div>
  <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <button type="button" class="btn btn-primary" id="btn_export_a">Export Excel</button>
                </div>
                <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover_a"
                            data-order='[[0,"desc"]]' width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Categorie</th>
                                    <th>Article</th>
                                    <th>P. Achat</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th style="display:none">Total</th>
                                </tr>
                            </thead>
                            <tfoot>
              <tr>
                  <th colspan="3">Total</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th style="display:none"></th>
                </tr>
              </tfoot>
                            <tbody>
                                <?php 
                      $query="SELECT *,prix_a * qte as total FROM article 
                      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
                      INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique
                      WHERE boutique.id_boutique='$id'";
                      $statement=$db->prepare($query);
                      $statement->execute();
                      $result=$statement->fetchAll();
                      $total_row=$statement->rowCount();
					  if ($total_row>0){
		               foreach($result as $row){
					  ?>
                                <tr>
                                    <td><?php echo $row["id_id_article"];?></td>
                                    <td><?php echo $row["categorie_stock"];?></td>
                                    <td><?php echo $row["description_article"];?></td>
                                    <td><?php echo number_format($row["prix_a"], 0, '.', ' ');?></td>
                                    <td><?php echo $row["qte"];?></td>
                                    <td><?php echo number_format($row["total"], 0, '.', ' ');?></td>
                                    <td style="display:none"><?php echo $row["total"];?></td>
                                </tr>
                                <?php
                    }
                }
                      ?>
                            </tbody>
                        </table>
            </div>
  </div>
  
</div>
<!-- Tabs content -->
                </div>
            </div>
        </div>
    </div>
</div>
<!------FORMULAIRE AJOUTER------->

<!------FIN FORMULAIRE AJOUTER------->
<!------FORMULAIRE MODIFIER------->

<!------FIN FORMULAIRE MODIFIER------->
<!------FORMULAIRE SUPPRIMER------->

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
    $('#dataTableHover_v').DataTable({
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
        },
			"autoWidth": true,
            "footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 3;
				while(j < nb_cols){
					var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                  if(typeof a==='string'){
                   a=a.replace(/[^\d.-]/g, '') * 1;
                  }
                  if(typeof b==='string'){
                   b=b.replace(/[^\d.-]/g, '') * 1;
                  }
                    return parseFloat(a) + parseFloat(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal.toLocaleString("fi-FI"));
					j++;
				} 
			}
    }); // ID From dataTable with Hover
    $('#dataTableHover_a').DataTable({
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
        },
			"autoWidth": true,
            "footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 3;
				while(j < nb_cols){
					var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                  if(typeof a==='string'){
                   a=a.replace(/[^\d.-]/g, '') * 1;
                  }
                  if(typeof b==='string'){
                   b=b.replace(/[^\d.-]/g, '') * 1;
                  }
                    return parseFloat(a) + parseFloat(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal.toLocaleString("fi-FI"));
					j++;
				} 
			}
    }); // ID From dataTable with Hover

});

</script>
<script type="text/javascript">
$('#btn_export_v').click(function() {
    $("#dataTableHover_v").table2excel({
        exclure: ".excludeThisClass",
        name: "Worksheet Name",
        filename: "Valeur-vente.xls", // inclure l'extension 
        preserveColors: false // définir sur true si vous souhaitez que les couleurs d'arrière-plan et les couleurs de police soient préservées 
    });
});
$('#btn_export_a').click(function() {
    $("#dataTableHover_a").table2excel({
        exclure: ".excludeThisClass",
        name: "Worksheet Name",
        filename: "Valeur-achat.xls", // inclure l'extension 
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
        }else if(isset($_SESSION['profil'])==''){
          header("Location:../");
          }
        ?>