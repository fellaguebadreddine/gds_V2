<?php
require_once("../includes/initialiser.php");

?>  

<?php	if(isset($_POST['id_fournisseur']) ){
	$errors = array();
	
		// new object client
	if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;}
	// new object admin client
	
	$versement = new Solde_fournisseur();
	
	
	$versement->debit = htmlentities(trim($_POST['debit']));
	$versement->credit = htmlentities(trim($_POST['credit']));
	$versement-> date = htmlentities(trim($_POST['date']));
	$versement->id_fournisseur = htmlentities(trim($_POST['id_fournisseur']));
	$versement->id_societe = htmlentities(trim($_POST['id_societe']));

	if (empty($errors)){
if ($versement->save()) {
			
			echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.success("Versement enregistrer  avec succes  !");
				  });
                  </script>';
		}
 		
		
		}
 		 
 		
}
?>