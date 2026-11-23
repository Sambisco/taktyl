<?php
session_start();
include('../../include/database.php');
?>
 <table id="example" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" data-order='[[3,"desc"]]'>
              <thead>
                <tr>
                  <th >Client</th>
                  <th >Telephone</th>
                  <th >Total</th>
                  <th >Nombre</th>
                </tr>
              </thead>
              <tfoot>
              <tr>
                  <th ></th>
                  <th >Total</th>
                  <th ></th>
                  <th ></th>

                </tr>
              </tfoot>
              <tbody id="invoiceItem">
<?php
      if(isset($_POST['annee'])){
      $annee=$_POST['annee'];
      $id=$_POST['id_boutique'];
      $query = "SELECT *,COUNT(DISTINCT num) AS nb,SUM(mt_ttc)AS total FROM `tva`
      INNER JOIN client ON client.id_client=tva.id_client
     INNER JOIN boutique ON boutique.id_boutique=client.id_boutique
       WHERE  boutique.id_boutique='$id' AND DATE_FORMAT(date,'%Y')='$annee' GROUP BY client.id_client ";
      $statement = $db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      $total_row = $statement->rowCount();
      if ($total_row > 0) {
          foreach ($result as $row) {
            if ($row['nom_client'] == null) {
            } else {
      ?>
      <tr>
          <td><?php echo $row['nom_client']; ?></td>
          <td><?php  echo $row["telephonec"]; ?></td>
          <td><?php echo $row['mt_ttc']; ?></td>
          <td><?php echo $row['nb']; ?></td>

      </tr>
      <?php 
            }
      }
      }
      }
?>
</tbody>
            </table>
  
            <script type="text/javascript">
      $('#example').DataTable({
        "bLengthChange": true,
        "bAutoWidth": true,
        "info": false,

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
          "sSearch": " ",
          "searchPlaceholder": "Rechercher...",
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
        ,
			"autoWidth": true,
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 2;
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

   
  </script>
