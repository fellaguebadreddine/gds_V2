<?php
require_once("../includes/initialiser.php");



 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 

		 $id = htmlspecialchars(trim($_GET['id']));
		



	
		$prod_achat= Vente::trouve_par_id_prod($id);
		$prod_vente= Achat::trouve_par_id_prod($id);
		$prod_importation= Achat_importation::trouve_par_id_prod($id);
		
		if (isset($prod_achat->id) || isset($prod_vente->id) || isset($prod_importation->id)) {
			echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Vous ne pouvez pas supprimer  produit  déja utilisé  !","Attention");
				  });
                  </script>'; 

		}else{
		$Produit = Produit::trouve_par_id($id);			 
		
	if (isset($Produit->id_pro)) {
		 	$Produit->supprime(); ?>	
			<script type="text/javascript">
								toastr.success(" Produit supprimé ","Attention !");
					$(document).ready(function(){
						var id = <?php echo $id; ?>;
					$("#prod_"+id).fadeOut();
						});
								
			</script>
	 <?php 	 }}
}
?>
