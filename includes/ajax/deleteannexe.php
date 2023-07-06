<?php
require_once("../includes/initialiser.php");



 	 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 

		 $id = htmlspecialchars(trim($_GET['id']));
		 $action = htmlspecialchars(trim($_GET['action']));
$errors = array();
if ($action == 'annex5') {

	$Tab_annexe_5 = Tab_annexe_5::trouve_par_id($id);

	if (empty($errors)){
			$creance = Tab_releve_pertes_valeurs_creances::supprime_par_id_annexe($Tab_annexe_5->id);
			$action = Tab_releve_pertes_valeurs_actions::supprime_par_id_annexe($Tab_annexe_5->id);
		
		$fact_Vente = Facture_vente::trouve_par_id($id);
	if (isset($Tab_annexe_5->id)) {
		 	$Tab_annexe_5->supprime(); ?>	
 <script type="text/javascript">
        	          toastr.warning(" Annexe 5 supprimé  avec ","Attention !");
     	$(document).ready(function(){
     		var id = <?php echo $id; ?>;
		$("#anex5_"+id).fadeOut();
 			});
        	          
</script>
	 <?php 	 }
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


}	 
?>
