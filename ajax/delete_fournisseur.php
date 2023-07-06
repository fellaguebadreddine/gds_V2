<?php
require_once("../includes/initialiser.php");

?>  

<?php	
if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { 
		 $id = htmlspecialchars(trim($_POST['id']));
	$fournissuer = Fournisseur::trouve_par_id($id);
	if (isset($fournissuer->id_fournisseur)) {
			$Facture_achat = Facture_achat::trouve_par_id_fournisseur($fournissuer->id_fournisseur);
			$Achat_importation = Achat_importation::trouve_par_id_fournisseur($fournissuer->id_fournisseur);
			if (isset($Facture_achat->id_facture) || isset($Achat_importation->id)) {
				        $returnData = array(
            'status' => 'error',
            'msg' => 'Fournissuer déja utilisé  !'
        );
			}else{
			$fournissuer->Etat = 0;
		 	$fournissuer->save();
				$returnData = array(
            'status' => 'ok',
            'msg' => 'Fournissuer supprimé avec succes'
        );
			} 


		 }	 
		  echo json_encode($returnData); 
	 }

?>