<?php
require_once("../includes/initialiser.php");



 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 

		 $id = htmlspecialchars(trim($_GET['id']));
		



	
		$depense_exsist= Facture_depense::trouve_par_id_depence($id);
		
		if (isset($depense_exsist->id)) {
			echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("vous ne pouvez pas supprimer cette depense,  il existe deja comme une facture depense  !","Attention");
				  });
                  </script>'; 

		}else{
		$depenses = Depense::trouve_par_id($id);			 
		
	if (isset($depenses->id)) {
		 	$depenses->supprime(); ?>	
			<script type="text/javascript">
								toastr.warning(" Depense supprimé ","Attention !");
					$(document).ready(function(){
						var id = <?php echo $id; ?>;
					$("#fact_"+id).fadeOut();
						});
								
			</script>
	 <?php 	 }}
}
?>
