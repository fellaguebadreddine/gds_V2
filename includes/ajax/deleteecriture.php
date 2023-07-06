<?php
require_once("../includes/initialiser.php");


 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Ecriture_comptable = Ecriture_comptable::trouve_par_id($id);
	if (isset($Ecriture_comptable->id)) {
		 	$Ecriture_comptable->supprime();
		 }	 
	 }

if (isset($_GET['id_piece'])) {

    $id_piece = htmlspecialchars(trim($_GET['id_piece'])); 

    $table_ecritures = Ecriture_comptable::trouve_ecriture_par_piece($id_piece); 
    $Pieces_comptables = Pieces_comptables::trouve_par_id($id_piece); 
    $somme_debit = Ecriture_comptable::somme_debit_par_piece($id_piece); 
    $somme_credit = Ecriture_comptable::somme_credit_par_piece($id_piece);
    $Pieces_comptables->somme_debit = $somme_debit->somme_debit;  
    $Pieces_comptables->somme_credit = $somme_credit->somme_credit;  
    $Pieces_comptables->modifier(); 
}

else{

	$id_user = htmlspecialchars(trim($_GET['id_user']));
 	$id_societe = htmlspecialchars(trim($_GET['id_societe']));

 	$table_ecritures = Ecriture_comptable::trouve_compte_vide_par_admin($id_user,$id_societe);
 	$somme_debit = Ecriture_comptable::somme_debit($id_user,$id_societe);
	$somme_credit = Ecriture_comptable::somme_credit($id_user,$id_societe);	
}




 ?>

								<tr>
									<td colspan="3"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL  : </strong></span></td>
									<td colspan="1" id="TOTALdebit" style="font-size: 14px;"><?php  if(isset($somme_debit->somme_debit)){echo  number_format($somme_debit->somme_debit , 2, ',', ' ');} else {echo "0.00";}  ?> </td>
									<td colspan="1" id="TOTALcredit" style="font-size: 14px;"><?php  if(isset($somme_credit->somme_credit)){echo number_format($somme_credit->somme_credit , 2, ',', ' ') ;} else {echo "0.00";}  ?> </td>
									<?php if ($somme_debit->somme_debit > $somme_credit->somme_credit) { $diff = $somme_debit->somme_debit - $somme_credit->somme_credit;  }else { $diff = $somme_credit->somme_credit - $somme_debit->somme_debit; } ?>
									<td colspan="2" id="Diff" >
											<?php if ($diff >0 ) {
												echo "Différence : ".number_format($diff , 2, ',', ' ') ;
											}  ?>
										</td>
							    </tr>
<?php 
if (empty($table_ecritures)) { ?>
 		
 		<script type="text/javascript">
			$(document).ready(function(){
			$("#id_Journal").attr('readonly',false);
			$("#id_Journal").select2("val", "");
			$("#id_Journal").select2("open");
			$("#id_comtpe").select2("val", "");
			$("#reference").val("");
			$("#libelle").val("");
			$("#Enregistrer_paiement").attr("disabled", true);
			$("#update_paiement").attr("disabled", true);
 			});

			</script> 							  
<?php } else{ ?>
	<script>
		$(document).ready(function(){
		$("#id_comtpe").select2("open");
		});
	</script>
<?php  }
if ($somme_debit->somme_debit == $somme_credit->somme_credit) { ?>
 		
 		<script type="text/javascript">
			$(document).ready(function(){
			$(".Etat-ecriture").html('<span class="font-green"><strong>Équilibré</strong></span>');
 			});

			</script>						  
<?php } else{ ?>
	<script>
		$(document).ready(function(){
		$(".Etat-ecriture").html('<span class="font-red"><strong>Déséquilibré</strong></span>');
		});
	</script>
<?php  } ?> 