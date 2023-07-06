<?php
require_once("../includes/initialiser.php");



 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 

		 $id = htmlspecialchars(trim($_GET['id']));
		$fat_depenses = Facture_depense::trouve_par_id($id);	
		
		if (isset($fat_depenses->id)) {
			echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("vous ne pouvez pas supprimer cette Facture,  elle existe deja comme une facture depense  !","Attention");
				  });
                  </script>'; 

		}else{

				 
		
	if (isset($fat_depenses->id)) {
		 	$fat_depenses->supprime();
			

			?>	
			<script type="text/javascript">
								toastr.warning(" Facture Depense supprimé ","Attention !");
					$(document).ready(function(){
						var id = <?php echo $id; ?>;
					$("#fact_"+id).fadeOut();
						});
								
			</script>
	 <?php 

		}}
}
?>