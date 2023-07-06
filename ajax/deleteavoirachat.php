<?php
require_once("../includes/initialiser.php");



 if ( (isset($_GET['id_user'])) && (is_numeric($_GET['id_user'])) && (isset($_GET['id_societe'])) && (is_numeric($_GET['id_societe'])) ) {

 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Achat = Avoir_achat::trouve_par_id($id);
	if (isset($Achat->id)) {
		 	$Achat->supprime();
		 }	 
	 }
 	$id_user = htmlspecialchars(trim($_GET['id_user']));
 	$id_societe = htmlspecialchars(trim($_GET['id_societe']));

 	$table_achats = Avoir_achat::trouve_achat_vide_par_admin($id_user,$id_societe);
 	$Somme_ht = Avoir_achat::somme_ht($id_user,$id_societe);
	$Somme_tva = Avoir_achat::somme_tva($id_user,$id_societe);
	$Somme_ttc = Avoir_achat::somme_ttc($id_user,$id_societe); 
	 	}
	////////////////////////////// if update achat ////////////////////////////////////
 if ( (isset($_GET['id_facture'])) && (is_numeric($_GET['id_facture'])) && (isset($_GET['action'])) && ($_GET['action'] == 'update_achat') ) {
	 
$id_facture = htmlspecialchars(trim($_GET['id_facture']));

 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Achat = Update_achat::trouve_par_id($id);
	if (isset($Achat->id)) {
		 	$Achat->supprime();
		 	$Update_table = Update_achat::update_table($id_facture);
		 }	 
	 }
 	 			$Somme_ht = Update_achat::somme_ht($id_facture);
				$Somme_tva = Update_achat::somme_tva($id_facture);
				$Somme_ttc = Update_achat::somme_ttc($id_facture);
				$table_achats = Update_achat::trouve_achat_notvalide_par_facture($id_facture);
 } 

 	 	

 ?>									

								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2" id="TOTALHT" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; "><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2" id="TOTALTVA" style= "font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2" id="TOTALTTC" style="font-size: 18px;" ><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> DA</td>
							    </tr>
									
<?php 
if (empty($table_achats)) { ?>
 		
 		<script type="text/javascript">
			
			$(document).ready(function(){
			$("#id_fournisseur").attr('readonly',false);
			$("#id_fournisseur").select2("val", "");
			$("#id_article").select2("val", "");
			$("#Enregistrer_paiement").attr("disabled", true);
			$("#update_paiement_achat").attr("disabled", true);
			$('#id_fournisseur').select2('open');
 			});

			</script> ?>							  
<?php } else{ ?>
	<script>
		$(document).ready(function(){
		$("#id_article").select2("open");
		});
	</script>
<?php  } ?>