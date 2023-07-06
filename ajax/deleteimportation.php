<?php
require_once("../includes/initialiser.php");



 if ( (isset($_GET['id_user'])) && (is_numeric($_GET['id_user'])) && (isset($_GET['id_societe'])) && (is_numeric($_GET['id_societe'])) && ($_GET['action'] == 'frais') ) {

 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Achat_importation = Achat_importation::trouve_par_id($id);
	if (isset($Achat_importation->id)) {
		 	$Achat_importation->supprime();
		 }	 
	 }
 	$id_user = htmlspecialchars(trim($_GET['id_user']));
 	$id_societe = htmlspecialchars(trim($_GET['id_societe']));
 	$table_achats = Achat_importation::trouve_frais_vide_par_admin($id_user,$id_societe);
 	$Somme_ht = Achat_importation::somme_ht_frais($id_user,$id_societe);
	$Somme_tva = Achat_importation::somme_tva_frais($id_user,$id_societe);
	$Somme_ttc = Achat_importation::somme_ttc_frais($id_user,$id_societe); 
?>
 		<tr>
									<tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo number_format($Somme_ht->somme_ht,3,' ','.') ;} else {echo "0.000";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo number_format($Somme_tva->somme_tva,3,' ','.');} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo number_format($Somme_ttc->somme_ttc,3,' ','.');} else {echo "0.00";}  ?> DA</span></td>
							    </tr>

 <?php } 
 else  if ( (isset($_GET['id_user'])) && (is_numeric($_GET['id_user'])) && (isset($_GET['id_societe'])) && (is_numeric($_GET['id_societe'])) && ($_GET['action'] == 'importation') ) {
 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Achat_importation = Achat_importation::trouve_par_id($id);
	if (isset($Achat_importation->id)) {
		 	$Achat_importation->supprime();
		 }	 
	 }
 	$id_user = htmlspecialchars(trim($_GET['id_user']));
 	$id_societe = htmlspecialchars(trim($_GET['id_societe']));
 	$table_achats = Achat_importation::trouve_achat_vide_par_admin($id_user,$id_societe);
 	$Somme_ht = Achat_importation::somme_ht($id_user,$id_societe);
	$Somme_tva = Achat_importation::somme_tva($id_user,$id_societe);
	$Somme_ttc = Achat_importation::somme_ttc($id_user,$id_societe); 
	if (!empty($table_achats)) {
	$last_fournisseur = Achat_importation::trouve_last_fournisseur_par_id_admin($id_user,$id_societe); 
	}
?>


								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL ACHAT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo number_format($Somme_ht->somme_ht,3,' ','.') ;} else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo number_format($Somme_tva->somme_tva,3,' ','.');} else {echo "0.000";}   ?> $</span></td>
							    </tr>
							     <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> SHIPPING : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php if (isset($last_fournisseur->shipping)) {echo number_format($last_fournisseur->shipping,3,' ','.') ;  }  else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT: </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo
									number_format($Somme_ttc->somme_ttc+ $last_fournisseur->shipping,3,' ','.') ; } else {echo "0.000";}  ?> $</span></td>
							    </tr>
<?php 							    
 }

 	////////////////////////////// if update imporation ////////////////////////////////////
 if ( (isset($_GET['id_facture'])) && (is_numeric($_GET['id_facture'])) && (isset($_GET['action'])) && ($_GET['action'] == 'update_frais_importation') ) {

$id_facture = htmlspecialchars(trim($_GET['id_facture']));

 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Achat_importation = Update_achat_importation::trouve_par_id($id);
	if (isset($Achat_importation->id)) {
		 	$Achat_importation->supprime();
		 	$Update_table = Update_achat_importation::update_table($id_facture);
		 }	 
	 }

 	$table_achats =  Update_achat_importation::trouve_frais_notvalide_par_facture($id_facture);
				$Somme_ht_frais = Update_achat_importation::somme_ht_frais_par_facture($id_facture);
				$Somme_tva_frais = Update_achat_importation::somme_tva_frais_par_facture($id_facture);
				$Somme_ttc_frais = Update_achat_importation::somme_ttc_frais_par_facture($id_facture);
?>
 		<tr>
									<tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht_frais->somme_ht)){echo number_format($Somme_ht_frais->somme_ht,3,'.',' ') ;} else {echo "0.000";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva_frais->somme_tva)){echo number_format($Somme_tva_frais->somme_tva,3,'.',' ');} else {echo "0.000";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc_frais->somme_ttc)){echo number_format($Somme_ttc_frais->somme_ttc,3,'.',' ');} else {echo "0.000";}  ?> DA</span></td>
							    </tr>
 <?php }
 else  if ( (isset($_GET['id_facture'])) && (is_numeric($_GET['id_facture'])) && (isset($_GET['action'])) && ($_GET['action'] == 'update_importation') ) {

 $id_facture = htmlspecialchars(trim($_GET['id_facture']));

 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Achat_importation = Update_achat_importation::trouve_par_id($id);
	if (isset($Achat_importation->id)) {
		 	$Achat_importation->supprime();
		 	$Update_table = Update_achat_importation::update_table($id_facture);
		 }	 
	 }

 	$table_achats = Update_achat_importation::trouve_achat_notvalide_par_facture($id_facture);
 	$Somme_ht = Update_achat_importation::somme_ht_par_facture($id_facture);
	$Somme_tva = Update_achat_importation::somme_tva_par_facture($id_facture);
	$Somme_ttc = Update_achat_importation::somme_ttc_par_facture($id_facture);
	$last_fournisseur = Update_achat_importation::trouve_last_fournisseur_par_id_facture($id_facture);
	 ?>
<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL ACHAT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo number_format($Somme_ht->somme_ht,3,' ','.') ;} else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo number_format($Somme_tva->somme_tva,3,' ','.');} else {echo "0.000";}   ?> $</span></td>
							    </tr>
							     <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> SHIPPING : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php if (isset($last_fournisseur->shipping)) {echo number_format($last_fournisseur->shipping,3,' ','.') ;  }  else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT: </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo
									number_format($Somme_ttc->somme_ttc+ $last_fournisseur->shipping,3,' ','.') ; } else {echo "0.000";}  ?> $</span></td>
							    </tr>

 <?php } ?>

<?php if (empty($table_achats)) { ?>
 		
 		<script type="text/javascript">
			$(document).ready(function(){
			$("#Frais_annexe").select2("val", "");
			$("#update_paiement").attr("disabled", true);
 			});

			</script> 							  
<?php }  ?>
