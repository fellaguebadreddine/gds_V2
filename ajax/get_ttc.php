<?php 
require_once("../includes/initialiser.php");

$array= array();
 if ( (isset($_GET['id_user'])) && (is_numeric($_GET['id_user'])) && (isset($_GET['id_societe'])) && (is_numeric($_GET['id_societe'])) ) {


 	$id_user = htmlspecialchars(trim($_GET['id_user']));
 	$id_societe = htmlspecialchars(trim($_GET['id_societe']));

 	$table_vantes = Vente::trouve_vente_vide_par_admin($id_user,$id_societe);
	$Somme_ttc = Vente::somme_ttc($id_user,$id_societe); 
	

 	} else 
 		
 	 	////////////////////////////// if update VENTE ////////////////////////////////////
 if ( (isset($_GET['id_facture'])) && (is_numeric($_GET['id_facture'])) && (isset($_GET['action'])) && ($_GET['action'] == 'update_vente') ) {

	$id_facture = htmlspecialchars(trim($_GET['id_facture']));

	$Somme_ttc = Update_vente::somme_ttc($id_facture);
	$table_vantes = Update_vente::trouve_vente_notvalide_par_facture($id_facture);
 }
foreach ($table_vantes as  $table_vante) {
    			array_push($array, $table_vante->Ttva);}
 ?>
 											<table class="table table-striped table-bordered table-hover "  >
											<tr   >
												<td colspan="8" width="81.5%" ><span style="float : right;   font-size: 18px; ;"><strong> TTC proposer :  </strong></span></td>
												<td colspan="2" ><input id="TTC_propose" disabled type="number" min="0" value="<?php if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} ?>"  class="form-control input-small " ></td>
											</tr>
							</table>


		<script>
		$(document).ready(function(){
		<?php if(count(array_unique($array)) === 1) {
  				echo '$("#TTC_propose").attr("disabled", false);'; 
  			}else{
  				echo '$("#TTC_propose").attr("disabled", true);'; 
  				} ?>
		});
	</script>