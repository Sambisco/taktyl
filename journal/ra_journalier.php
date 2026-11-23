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
    $timezone = "UTC";
    date_default_timezone_set($timezone);
?>
    <link rel="stylesheet" href="../assets/css/button.reservation.css">
   
    <?php 
       $query="SELECT DATE_FORMAT(date,'%Y') AS d FROM `tva` 
       INNER JOIN client ON client.id_client=tva.id_client 
       INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
       WHERE  boutique.id_boutique='$id' GROUP BY DATE_FORMAT(`date`,'%Y')";
       $annee_mois="<option value=''>Selectionnez</option>";
    $statement=$db->prepare($query);
	$statement->execute();
$result=$statement->fetchAll();
$total_row=$statement->rowCount();
    if($total_row>0){
      foreach($result as $row){
        $annee_mois.="<option value='{$row["d"]}' selected='selected'>Année : {$row["d"]}</option>";
      }
    }
  ?>
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">C.A article journalier</h1>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../page/dashboard?mail=<?php echo $mail; ?>&id=<?php echo $id_b; ?>">Accueil</a></li>
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
                    <div class="card-header py-3 ">
                        <div class="form-row">
                            <div class="col-md-2 mb-2">
                                <div class="form-group">
                                Année : <?php echo $_GET['annee']; ?>
                                <input type="hidden" name="" id="annees" value="<?php echo $_GET['annee']; ?> ">  
                                <input type="hidden" name="" id="mois" value="<?php echo $_GET['mois']; ?>">
                                <input type="hidden" name="" id="id_boutique" value="<?php echo $id; ?>">
                                </div>
                            </div>

                            <div class="col-xl-2">

                            </div>

                            <div class="col-xl-5">
                            </div>
                            <div class="col-xl-3">
                                <input type="text" id="search" data-filter class="form-control form-control-sm searchBox" placeholder="Rechercher...">
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class=" p-0 " style="margin-top: -20px;margin-left: 10px;margin-right: 10px;">
                            <div class="row mb-3 parent bg-gradient-login" id="contentpage" style="padding-top: 20px;">
                                <!-- debut -->
                                <?php
$annee=date('Y');
$an=$_GET['annee'];
$mois=$_GET['mois'];
$query = "SELECT DATE_FORMAT(reception.date,'%d')AS date,DATE_FORMAT(reception.date,'%M')AS datec,article.id_article,description_article,SUM(detail_reception.prix * detail_reception.quantite) As total FROM detail_reception 
INNER JOIN article ON article.id_article=detail_reception.id_article
INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock
INNER JOIN reception ON reception.id_reception=detail_reception.id_reception 
INNER JOIN commande ON commande.id_commande=reception.id_commande 
INNER JOIN fournisseur ON fournisseur.idfournisseur=commande.idfournisseur 
INNER JOIN boutique ON boutique.id_boutique=fournisseur.id_boutique
WHERE boutique.id_boutique='$id' AND DATE_FORMAT(reception.date,'%Y')='$an' AND DATE_FORMAT(reception.date,'%m')='$mois' GROUP BY DATE_FORMAT(reception.date,'%d-%m-%Y') ORDER BY DATE_FORMAT(reception.date,'%d-%m-%Y') DESC";
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
if ($total_row > 0) {
    foreach ($result as $row) {
?>
        <div class="col-xl-2 col-md-6 mb-4 result well ">
            <div class="card h-100">
                <div class="card-body ">
                    <center>
                    <div class="nom" style="margin-bottom:0px ;font-size: 14px" data-content="<?php echo $row["date"]; ?>">
                            <?php echo $row["date"]; ?>
                        </div>
                        <div class="nom" style="margin-bottom:0px ;font-size: 14px;font-weight: bold;color: red;" data-content="<?php echo $row["date"]; ?>">
                            <?php echo number_format($row["total"], 0, ",", " "); ?>
                        </div>
                        <div class="nom text-primary" style="font-size: 14px; margin-bottom: 10px;text-transform: capitalize;font-weight: bold;" id="data_<?php echo $row["date"]; ?>" data-id="<?php echo $row["id_article"]; ?>">
                            <?php
                            setlocale(LC_TIME, 'fr_FR.utf8');
                            echo strftime("%B", strtotime($row["datec"]));
                            ?>
                        </div>
                        <div class="fab-container">
                            <div class="fab fab-icon-holder fab-button" id="fab-button_<?php echo $row['date']; ?>" data-id="<?php echo $row['date']; ?>">
                                <i class="fas fa-question"></i>
                            </div>
                            <div class="fab fab-icon-holder fab-hide" id="fab-hide_<?php echo $row['date']; ?>" data-id="<?php echo $row['date']; ?>">
                                <i class="fas fa-times"></i>
                            </div>
                            <ul class="fab-options fab-show" id="fab-show_<?php echo $row['date']; ?>">
                                <li>
                                    <span class="fab-label">Tableau</span>
                                    <div class="fab-icon-holder" data-toggle="modal" data-target="#exampleModalScrollable"  id="tableau" data-id="<?php echo $row['date']; ?>">
                                        <i class="fas fa-table" id="shared"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="fab-label">Statistique</span>
                                    <div class="fab-icon-holder" id="statistique" data-id="<?php echo $row['date']; ?>">
                                        <i class="fas fa-chart-area" id="shared"></i>
                                    </div>
                                </li>
                               

                            </ul>

                        </div>
                    </center>
                </div>
            </div>

        </div>
<?php
    }
}
?>
                                <!----------fin------------->
                            </div>
                            <div id="pagination" style="text-align: center;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---Container Fluid-->
   
     <!-- Modal Scrollable tableau -->
     <div class="modal fade" id="tableed" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalScrollableTitle">Tableau C.A article journalier
</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="table-responsive p-0" id="invoiceItem">
                  
              </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_export">Export Excel</button>
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Scrollable tableau-->  
          <div class="modal fade" id="statistiques" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Statistique C.A article journalier
<span id="month"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <canvas id="chart_annee_mois" width="800" height="400"></canvas>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="action">Telecharger</button>
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                </div>
              </div>
            </div>
          </div>

    <!-- Modal Scrollable chart -->
    <div class="modal fade" id="" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalScrollableTitle">Statistique categorie mensuel
</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <div class="chart-area"  id="chart1">
                    <canvas id="chart_annee_mois" width="800" height="700"></canvas>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_export">Export Excel</button>
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Annuler</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Scrollable chart-->    
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
       
        $(function() {

            var flexiblePagination = $('#contentpage').flexiblePagination({
                itemsPerPage: 12,
                itemSelector: 'div.result:visible',
                pagingControlsContainer: '#pagination',
                showingInfoSelector: '#showingInfo',
                css: {
                    btnNumberingClass: 'btn btn-sm btn-primary',
                    btnFirstClass: 'btn btn-sm btn-primary',
                    btnLastClass: 'btn btn-sm btn-primary',
                    btnNextClass: 'btn btn-sm btn-primary',
                    btnPreviousClass: 'btn btn-sm btn-primary'
                }
            });
            flexiblePagination.getController().onPageClick = function(pageNum, e) {
                console.log('Cliquez sur la Page: ' + pageNum)
            };

            // Direct JS Object method of using the FlexiblePagination
            //        var pager = new Flexible.Pagination();
            //        pager.itemsPerPage = 1;
            //        pager.pagingContainer = '#content';
            //        pager.itemSelector = 'div.result:visible';  //That is, Select and paginate only the filtered visible '.result' div.
            //        pager.pagingControlsContainer = '#pagingControls';
            //        pager.showCurrentPage();
        });
    </script>

    <script>
        $(".id_n").each(function() {
            $('.id_n').hide();
        });
        $(".id_t").each(function() {
            $('.id_t').hide();
        });

        $("#id_t").hide();
        $(".fab-show").hide();
        $('.fab-hide').hide();
        $(document).on('click', '.fab-button', function(e) {
            var id = $(this).data('id');
            $(".fab-button").each(function() {
                $('#fab-show_' + id).show(600);
                $('#fab-hide_' + id).show();
                $('#fab-button_' + id).hide();
            });
        });
        $(document).on('click', '.fab-hide', function(e) {
            var id = $(this).data('id');
            $(".fab-hide").each(function() {
                $('#fab-show_' + id).hide(300);
                $('#fab-button_' + id).show();
                $('#fab-hide_' + id).hide();
            });
        });
        $("#annee").select2();

        $("#id_categorie").select2({
            dropdownParent: $("#exampleModal")
        });
        $("#edit_id_categorie").select2({
            dropdownParent: $("#editmodal")
        });

        function showPreview(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
        $('#img-uploadss').hide();
        $(document).ready(function() {
            $(document).on('change', '.btn-file :file', function() {

                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img-uploadss').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInps").change(function() {
                readURL(this);
                $('#img-uploadss').show();
                $('#img-uploads').hide();
            });

        });


        $(document).on('click', '#tableau', function(e) {
            var annee=$("#annees").val();
            var id_boutique=$("#id_boutique").val();
            var mois=$("#mois").val();
            var date = $(this).data('id');
            $.ajax({
                url: "../fetch/journalier/fetch_ra_tableau_journalier",
                type: "post",
                data: {
                    annee: annee,id_boutique:id_boutique,date:date,mois:mois
                },
                dataType: 'html',
                success: function(data) {
                    console.log(data);
                    $("#invoiceItem").html(data);
                    $('#tableed').modal('show')
                }
            });
        });
        $(document).on('click', '#statistique', function(e) {
          var annee=$("#annees").val();
            var id_boutique=$("#id_boutique").val();
            var mois=$("#mois").val();
            var date = $(this).data('id');
            $("#month").html(date+" "+$("#data_"+date).html());
            var month=$("#data_"+date).html();
            $.ajax({
                url: "../statistique/journalier/ra_journalier",
                type: "post",
                data: {
                    annee: annee,id_boutique:id_boutique,date:date,mois:mois
                },
                dataType: 'json',
                success:function(data)
    {
        $("#month").html(data.moischeck);
      var language = [];
      var total = [];
      var color = [];
      for(var count = 0; count < data.length; count++)
      {
        language.push(data[count].language);
        total.push(data[count].total);
        color.push(data[count].color);
      }

      var chart_data = {
        labels:language,
        datasets:[
          {
            label:'Inventaire article journalier',
            backgroundColor:color,
            color:'#fff',
            data:total
          }
        ]
      };

      var options = {
        responsive:true,
        scales:{
          yAxes:[{
            ticks:{
              min:0
            }
          }]
        }
      };

      var group_chart1 = $('#chart_annee_mois');

      var graph1 = new Chart(group_chart1, {
        type:"line",
        data:chart_data,
        options:{
          title:{
              display:true,
              text:date,
              fontSize:15,
              padding:20             
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
    layout:{
      padding:{
        right:30
      }
    },   
    scales:{
            xAxes:[{
              display:true,
              position:'right',
            ticks:{
              beginAtZero:true,
              autoSkip:false,
              maxRotation:90,
              minRotation:80,
              fontSize:15,
              padding:15
            }
          }
        ]
          }
        }
      });
      $('#statistiques').modal('show');

    }
     
            });
        });
        var node=document.getElementById('chart_annee_mois');
var btn=document.getElementById('action');
  
btn.onclick=function(){
      domtoimage.toBlob(document.getElementById('chart_annee_mois')).then(function(blob){
        window.saveAs(blob,'Graphique.png')
      })
}
    </script>
<script type="text/javascript">
    $('#btn_export').click(function(){
	   $ ( "#example" ) . table2excel ( { 
    exclure : ".excludeThisClass" ,
    name : "Worksheet Name" , 
    filename : "Rapport-inventaires.xls" ,  // inclure l'extension 
    preserveColors : false  // définir sur true si vous souhaitez que les couleurs d'arrière-plan et les couleurs de police soient préservées 
} ) ;
	   });
  </script>

<?php include('../include/Footer.php');
} else if (isset($_SESSION['profil']) == '') {
    header("Location:../");
}
?>