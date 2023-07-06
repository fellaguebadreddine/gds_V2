<?php 
require_once("../includes/initialiser.php");

 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));

	$errors = array();
				////////////////////////////////////   check for old consomation ///////////////////////////////////
				$edit_production = Production::trouve_par_id($id);
				$Consomation_productions= Consomation_production::trouve_detail_par_id_production($id);
	/////////////////// get lot-production /////////////////////////////////////////
			if (isset($edit_production->produit_finale)) {
				$lot_production = Lot_prod::trouve_lot_par_facture_and_type_and_prod(4,$edit_production->produit_finale,$edit_production->id);
				if ($lot_production->qte !=  $lot_production->qte_initial) {
					$errors[]= '  Lot deja consommé !';
				}
				}
	if (empty($errors)){
		try {

				 $bd->beginTransactions();
					
////////////////// Restore the quantity  of consomation into the lot qty /////////////////////////////////
								if (!empty($Consomation_productions)) {
				foreach ($Consomation_productions as $Consomation_production) {
					$lot_consomation = Lot_prod::trouve_par_id($Consomation_production->id_lot);
					if (isset($lot_consomation->id)) {
						$lot_consomation->qte = $lot_consomation->qte + $Consomation_production->qte;
						$lot_consomation->save();
						$Consomation_production->supprime();
					}
					
				}
			}
						$detail_formules = Detail_formule::trouve_detail_par_id_formule( $edit_production->formule);
				foreach ($detail_formules as $detail_formule ){

							  	    //// trouve lot formule ///////////
                $lot = Lot_prod::trouve_par_id($detail_formule->id_lot);
                	$lot_produit = Lot_prod::trouve_first_lot($detail_formule->id_Matiere_Premiere);
                	if (isset($lot_produit->id)) {
					 			$detail_formule->id_lot = $lot_produit->id;
					 			$detail_formule->save();
					 			}
					 		

				}

		

		$Pieces_comptable = Pieces_comptables::trouve_par_operation_and_type($id,9);
		if (isset($Pieces_comptable->id)) {
		$Ecriture_comptable= Ecriture_comptable::delete_ecriture_par_piece($Pieces_comptable->id);
		$Pieces_comptable->supprime();
		}

		$Pieces_comptable_Sortie = Pieces_comptables::trouve_par_operation_and_type($id,10);
		if (isset($Pieces_comptable_Sortie->id)) {
		$Ecriture_comptable_Sortie= Ecriture_comptable::delete_ecriture_par_piece($Pieces_comptable->id);
		$Pieces_comptable_Sortie->supprime();
		}
		

	
		 	$edit_production->supprime();
		 	$lot_production->supprime();
		 	 ?>	
 <script type="text/javascript">
        	          toastr.warning(" Production supprimé ","Attention !");
     	$(document).ready(function(){
     		var id = <?php echo $id; ?>;
		$("#production_"+id).fadeOut();
 			});
        	          
</script>
	 <?php
	 $bd->commitTransactions();
			} catch (Exception $e) {
			    // If there's an error, rollback the transaction:
			$bd->rollbackTransactions();
			} 	 
	}else{
 					// errors occurred
        	         echo '<script type="text/javascript">
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			</script>'; 	  
	}

 	 }
 ?>