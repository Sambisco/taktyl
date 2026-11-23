<?php
session_start();
include('../../include/database.php');
?>
 <table id="example" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" data-order='[[0,"desc"]]'>
              <thead>
                <tr>
                  <th >ID </th>
                  <th style="width: 200px;">Date</th>
                  <th style="width: 200px;">Article</th>
                  <th style="width: 100px;">Total</th>
                  <th style="width: 100px;">Nombre</th>
                </tr>
              </thead>
              <tfoot>
              <tr>
                  <th ></th>
                  <th style="width: 200px;text-align: right;"></th>
                  <th style="width: 200px;text-align: right;">Total</th>
                  <th style="width: 100px;"></th>
                  <th style="width: 100px;"></th>
                </tr>
              </tfoot>
              <tbody id="invoiceItem">
<?php
      if(isset($_POST['id_article'])){
        $id_article=$_POST['id_article'];
        $mois=$_POST['mois'];
        $annee=$_POST['annee'];
        $id=$_POST['id_boutique'];
      $query = "SELECT DATE_FORMAT(date,'%d-%M-%Y') AS date,article.id_article,description_article,SUM(vente.total) AS total,COUNT(article.id_article) AS nombre FROM tva 
      INNER JOIN vente ON tva.id_tva=vente.id_tva 
      INNER JOIN article ON article.id_article=vente.id_article 
      INNER JOIN categorie_stock ON categorie_stock.id_categorie_stock=article.id_categorie_stock 
      INNER JOIN boutique ON boutique.id_boutique=categorie_stock.id_boutique 
      WHERE boutique.id_boutique='$id' AND DATE_FORMAT(date,'%Y')='$annee' AND DATE_FORMAT(date,'%m')='$mois' AND article.id_article='$id_article' GROUP BY article.id_article,DATE_FORMAT(date,'%d-%m-%Y') ";
      $statement = $db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      $total_row = $statement->rowCount();
      if ($total_row > 0) {
          foreach ($result as $row) {
      ?>
      <tr>
          <td><?php echo $row['id_article']; ?></td>
          <td style="text-transform: capitalize;"><?php  setlocale(LC_TIME, 'fr_FR.utf8');   echo strftime("%d-%B-%Y", strtotime($row["date"])); ?></td>
          <td><?php echo $row["description_article"]; ?></td>
          <td><?php echo $row['total']; ?></td>
          <td><?php echo $row['nombre']; ?></td>
      </tr>
      <?php 
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

   
  </script>
