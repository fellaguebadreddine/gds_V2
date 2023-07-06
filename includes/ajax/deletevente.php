<?php
require_once("../includes/initialiser.php");


$array= array();

 if ( (isset($_GET['id_user'])) && (is_numeric($_GET['id_user'])) && (isset($_GET['id_societe'])) && (is_numeric($_GET['id_societe'])) ) {

 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Vente = Vente::trouve_par_id($id);
	if (isset($Vente->id)) {
		 	$Vente->supprime();
		 }	 
	 }
 	$id_user = htmlspecialchars(trim($_GET['id_user']));
 	$id_societe = htmlspecialchars(trim($_GET['id_societe']));

 	$table_vantes = Vente::trouve_vente_vide_par_admin($id_user,$id_societe);
 	$Somme_ht = Vente::somme_ht($id_user,$id_societe);
	$Somme_tva = Vente::somme_tva($id_user,$id_societe);
	$Somme_ttc = Vente::somme_ttc($id_user,$id_societe); 
	if (!empty($table_vantes)) {
	$last_client = Vente::trouve_last_client_par_id_admin($id_user,$id_societe); 
					
	}	

 	}
 	////////////////////////////// if update VENTE ////////////////////////////////////
 if ( (isset($_GET['id_facture'])) && (is_numeric($_GET['id_facture'])) && (isset($_GET['action'])) && ($_GET['action'] == 'update_vente') ) {

$id_facture = htmlspecialchars(trim($_GET['id_facture']));

 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Vente = Update_vente::trouve_par_id($id);
	if (isset($Vente->id)) {
		 	$Vente->supprime();
		 	$Update_table = Update_vente::update_table($id_facture);
		 }	 
	 }
				$Somme_ht = Update_vente::somme_ht($id_facture);
				$Somme_tva = Update_vente::somme_tva($id_facture);
				$Somme_ttc = Update_vente::somme_ttc($id_facture);
				$table_vantes = Update_vente::trouve_vente_notvalide_par_facture($id_facture);
			if (!empty($table_vantes)) {
					$last_client = Update_vente::trouve_last_client_par_id_facture($id_facture); 
					
					}	
 }
 ?>
									
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2" id="TOTALHT" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> </td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> REMISE : </strong></span></td>
									<td colspan="2" id="REMISE_td" style="font-size: 18px;">0.00</td>
							    </tr>

							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT APRES REMISE : </strong></span></td>
									<td colspan="2" id="TOTALHT_R" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> </td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; "><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2" id="TOTALTVA" style= "font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?>
									
									 </td>
							    </tr>
							    <tr>
							    	

									<td colspan="8" ><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2" id="TOTALTTC" style="font-size: 18px;" ><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> 
									 </td>
									 <input type="hidden" id="TOTALTTC1" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> ">
									 <input type="hidden" id="TOTALTVA1" value="<?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> ">
									 <input id="last_tva" type="hidden" value="<?php echo $last_client->Ttva; ?>">
							    </tr>

										
                          			  


<?php 
if (empty($table_vantes)) { ?>
 		
 		<script type="text/javascript">
			$(document).ready(function(){
			$("#id_client").attr('readonly',false);
			$("#id_client").select2("val", "");
			$("#id_client").select2("open");
			$("#id_article").select2("val", "");
			$("#Enregistrer_paiement").attr("disabled", true);
			$("#update_paiement").attr("disabled", true);
 			});

			</script> ?>							  
<?php } else{ ?>
	<script>
		$(document).ready(function(){
		$("#id_client").attr('readonly',false);
		$("#id_article").select2("open");
		});
	</script>
<?php  } ?>