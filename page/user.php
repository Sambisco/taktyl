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
<?php 
 if (isset($_GET['mail'])) {
  $mail= $_SESSION['mail']=$_GET['mail'];
}
       if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $id = encryptor('decrypt',$id);
      
      }
       
  ?>


 <!-- Container Fluid-->
 <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Utilisateurs</h1>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard?mail=<?php echo $mail; ?>&id=<?php echo $id_boutique_p; ?>">Accueil</a></li>
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
 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Ajouter</button>
                </div>
                <div class="card-body">
                <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover" data-order='[[0,"desc"]]' width="100%">
                    <thead class="thead-light">
                      <tr>
                      <th style="display:none">ID</th>
                        <th>Nom complet</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Profil</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th style="display:none">ID</th>
                        <th>Nom complet</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Profil</th>
                        <th>Actions</th>
                      </tr>
                    </tfoot>
                    <tbody>
                    <?php 
                      $query="SELECT * FROM sub_users 
                      INNER JOIN boutique ON boutique.id_boutique=sub_users.id_boutique 
                      WHERE boutique.id_boutique='$id'";
                      $statement=$db->prepare($query);
                      $statement->execute();
                      $result=$statement->fetchAll();
                      $total_row=$statement->rowCount();
					  if ($total_row>0){
		               foreach($result as $row){
					  ?>
                      <tr>
                      <td style="display:none"><?php echo $row["id_sub_users"];?></td>
                      <td><?php echo $row["nom_sub_user"];?></td>
                      <td><?php echo $row["telephone_sub_user"];?></td>
                      <td><?php echo $row["sub_email"];?></td>
					  <td><?php echo $row["profil"];?></td>
                      <td><button class="btn btn-outline-success btn-sm editbtn"><i class="fa fa-edit"></i></button>
					  <button class="btn btn-outline-danger btn-sm deletebtn"> <i class="fa fa-trash"></i></button>
					  </td>
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
<input name="nom_sub_user" type="text" class="form-control form-control-sm" placeholder="Nom complet" required>
</div>
<div class="form-group">
<label>Telephone</label>
<input name="telephone_sub_user" type="text" class="form-control form-control-sm" placeholder="Telephone" required>
</div>
<div class="form-group">
<label>Email</label>
<input name="sub_email" type="text" class="form-control form-control-sm" placeholder="Email" required>
</div>
<div class="form-group">
<label>Profil</label>
<select name="profil" class="form-control form-control-sm" required="">
  <option>Selectionnez</option>
  <option value="Administrateur">Administrateur</option>
  <option value="Utilisateur">Utilisateur</option>
</select>
</div>
<input type="hidden" name="id_boutique" value="<?php echo $id; ?>">
<input type="hidden" name="show_email" value="<?php echo $mail; ?>">
<div class="form-group">
<label>Mot de passe</label>
<input name="sub_password" id="password" type="password" class="form-control form-control-sm" placeholder="Mot de passe" required>
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
<input name="nom" type="text" id="nom" class="form-control form-control-sm" placeholder="Nom Complet" required>
</div>
<div class="form-group">
<label>Telephone</label>
<input name="telephone_sub_user" id="telephone_sub_user" type="text" class="form-control form-control-sm" placeholder="Telephone" required>
</div>
<div class="form-group">
<label>Email</label>
<input name="sub_users" id="logins" type="text" class="form-control form-control-sm" placeholder="Email" required>
</div>

<div class="form-group">
<label>Profil</label>
<select name="profil" id="profil" class="form-control form-control-sm" required="">
  <option>Selectionnez</option>
 
  <option value="Administrateur">Administrateur</option>
  <option value="Utilisateur">Utilisateur</option>
</select>
<input type="hidden" name="id_boutique" value="<?php echo $id; ?>">
<input type="hidden" name="show_email" value="<?php echo $mail; ?>">

</div>
<div class="form-group">
<label>Nouveau Mot de passe</label>
<input name="newpassword" id="newpassword" type="password" class="form-control form-control-sm" placeholder="Nouveau Mot de passe"  />
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
<input type="hidden" name="show_email" value="<?php echo $mail; ?>">
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
$(document).ready(function(){
  $('#id_boutique').select2({
    dropdownParent: $("#exampleModal")
  } );
  $('#edit_id_boutique').select2({
    dropdownParent: $("#editmodal")
  } );

$(".editbtn").click(function(){
$("#editmodal").modal('show');
$str=$(this).closest('tr');
var data=$str.children("td").map(function(){
return $(this).text();
}).get();
console.log(data);
$("#update_user").val(data[0]);
$("#nom").val(data[1]);
$("#telephone_sub_user").val(data[2]);

$("#logins").val(data[3]);
$("#profil").val(data[4]);

});
});
$(document).ready(function(){
$(".deletebtn").click(function(){
$("#deletemodal").modal('show');
$str=$(this).closest('tr');
var data=$str.children("td").map(function(){
return $(this).text();
}).get();
console.log(data);
$("#delete_id").val(data[0]);
});
});
$(document).ready(function () {
     
     $(document).on('input', '#password', function(e){
      e.preventDefault();
          $("#password_show").val( $("#password").val());
         });
         $(document).on('input', '#newpassword', function(e){
      e.preventDefault();
          $("#newpassword_show").val( $("#newpassword").val());
         });

    })
</script>
        <script>
    $(document).ready(function () {
      $('#dataTableHover').DataTable(
        {
            "language": {
                "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "Afficher _MENU_ éléments",
                "sLoadingRecords": "Chargement...",
                "sProcessing":     "Traitement...",
                "sSearch":         "Rechercher :",
                "sZeroRecords":    "Aucun élément correspondant trouvé",
                "oPaginate": {
                    "sFirst":    "Premier",
                    "sLast":     "Dernier",
                    "sNext":     "Suivant",
                    "sPrevious": "Précédent"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
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
    }
      ); // ID From dataTable with Hover
    });
  </script>
 
        <?php include('../include/Footer.php');
        }else if(isset($_SESSION['profil'])==''){
          header("Location:../");
          }
        ?>
      