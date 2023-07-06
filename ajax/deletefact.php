<?php
require_once("../includes/initialiser.php");



 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 

		 $id = htmlspecialchars(trim($_GET['id']));
		 $action = htmlspecialchars(trim($_GET['action']));
$errors = array();
if ($action == 'vente') {
			$fact_Vente = Facture_vente::trouve_par_id($id);
if (isset($fact_Vente->id_facture)) {
	if (empty($errors)){
					$table_vantes = Vente::trouve_vente_par_facture($id);			 
				foreach($table_vantes as $table_vante){ 
			 	$Article = Produit::trouve_par_id($table_vante->id_prod);
			 	$Lot_prod = Lot_prod::trouve_par_id($table_vante->id_lot);
				
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock + $table_vante->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();
					

		///////////////// mise a jour de QTE stock lot ///////////////
					
					
					$Quantite_stock_Lot = $Lot_prod->qte + $table_vante->Quantite;
					$Lot_prod->qte = $Quantite_stock_Lot;
					$Lot_prod->modifier();

		//////////////////////// delete $table_vante ////////////////////
					$table_vante->supprime();

			}

				/////////// delete old table Reglement ////////////////
			$table_Reglements = Reglement_client::trouve_Reglement_par_facture($id);
			 
			 	 foreach($table_Reglements as $table_Reglement){
			 	$Solde_client = Solde_client::trouve_par_id($table_Reglement->id_solde);
			 	if (isset($Solde_client->solde)) {
			 	$Solde  =  $Solde_client->solde + ($table_Reglement->somme + $table_Reglement->timbre);
			 	$Solde_client->solde = $Solde ;
			 	$Solde_client->etat = 0;	
			 	$Solde_client->modifier();
			 	} 
			 	$table_Reglement->supprime(); 
			  }
		

		$Pieces_comptable = Pieces_comptables::trouve_par_operation_and_type($id,2);
		if (isset($Pieces_comptable->id)) {
		$Ecriture_comptable= Ecriture_comptable::delete_ecriture_par_piece($Pieces_comptable->id);
		$Pieces_comptable->supprime();
		}

		$Pieces_comptable_Sortie = Pieces_comptables::trouve_par_operation_and_type($id,7);
		if (isset($Pieces_comptable_Sortie->id)) {
		$Ecriture_comptable_Sortie= Ecriture_comptable::delete_ecriture_par_piece($Pieces_comptable->id);
		$Pieces_comptable_Sortie->supprime();
		}
		

	
		 	$fact_Vente->supprime(); ?>	
 <script type="text/javascript">
        	          toastr.warning(" Facture supprimé ","Attention !");
     	$(document).ready(function(){
     		var id = <?php echo $id; ?>;
		$("#fact_"+id).fadeOut();
 			});
        	          
</script>
	 <?php 	 
	}else{
 					// errors occurred
        	         echo '<script type="text/javascript">
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			</script>'; 	  
	}}

}else if ($action == 'achat') {
	$Achat = Facture_achat::trouve_par_id($id);
	if (isset($Achat->id_facture)) {

					$table_achats = Achat::trouve_achat_par_facture($id);
				if (empty($errors)){
				foreach($table_achats as $table_achat){ 
			 	$Article = Produit::trouve_par_id($table_achat->id_prod);
			    $lot = lot_prod::trouve_lot_par_id_achat($table_achat->id);

		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock - $table_achat->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();

				$last_prod_achat = Achat::trouve_par_id_prod($table_achat->id_prod);
				if (isset($last_prod_achat->id_prod)) {
					$Article->prix_achat = $table_achat->Prix;
					$Article->modifier();	
				}
		//////////////////////// delete lot prod ////////////////

					if (isset($lot->id) ) {
					$lot->supprime();
					}
		//////////////////////// delete table achat //////////////
					$table_achat->supprime();
				
			 }


					/////////// delete old table Reglement ////////////////
			$table_Reglements = Reglement_fournisseur::trouve_Reglement_par_facture($id,1);
			 
			 	 foreach($table_Reglements as $table_Reglement){
			 	 	if ($table_Reglement->id_solde != 0) {
			 	$Solde_fournisseur = Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
			 	$Solde  =  $Solde_fournisseur->solde + ($table_Reglement->somme + $table_Reglement->timbre);
			 	$Solde_fournisseur->solde = $Solde ;
			 	$Solde_fournisseur->etat = 0;	
			 	$Solde_fournisseur->modifier();
			 	 }
			 	$table_Reglement->supprime(); 
			 
			}
		
		$Pieces_comptable = Pieces_comptables::trouve_par_operation_and_type($id,1);
		if (isset($Pieces_comptable->id)) {
		$Ecriture_comptable= Ecriture_comptable::delete_ecriture_par_piece($Pieces_comptable->id);
		$Pieces_comptable->supprime();
		}
		$Piece_Entree = Pieces_comptables::trouve_par_operation_and_type($id,6);
		if (isset($Piece_Entree->id)) {
		$Ecriture_comptable= Ecriture_comptable::delete_ecriture_par_piece($Piece_Entree->id);
		$Piece_Entree->supprime();
		}
	
		 	$Achat->supprime();?>
 <script type="text/javascript">
        	          toastr.warning(" Facture supprimé ","Attention !");
     	$(document).ready(function(){
     		var id = <?php echo $id; ?>;
		$("#fact_"+id).fadeOut();
 			});
        	          
</script>
	<?php 	 
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
	 
}}


}	 
?>
