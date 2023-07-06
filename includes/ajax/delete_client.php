<?php
require_once("../includes/initialiser.php");

?>  

<?php	
if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { 
		 $id = htmlspecialchars(trim($_POST['id']));
	$clients = Client::trouve_par_id($id);
	if (isset($clients->id_client)) {
		$Facture_vente = Facture_vente::trouve_par_id_client($clients->id_client);
			if (isset($Facture_vente->id_facture)) {
        $returnData = array(
            'status' => 'error',
            'msg' => 'Client déja utilisé  !'
        );
		} else{
					$clients->Etat = 0;
		 	$clients->save();


		 	    $returnData = array(
            'status' => 'ok',
            'msg' => 'Client supprimé avec succes'
        );
		}

		 }	

		 echo json_encode($returnData); 
	 }

?>