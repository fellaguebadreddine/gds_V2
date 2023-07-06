<?php
require_once("../includes/initialiser.php");


	 if(!empty($_SESSION['societe'])){
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);}

if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { 
		 $id = htmlspecialchars(trim($_POST['id']));
		 $id_client = htmlspecialchars(trim($_POST['id_client']));
	$versements = Solde_client::trouve_par_id($id);
	$Reglement_client = Reglement_client::trouve_Reglement_par_id_solde($id,$nav_societe->id_societe);
	
	if (isset($Reglement_client->id)) {

			 $returnData = array(
            'status' => 'error',
            'msg' => 'Règlement déja utilisé .'
        );


	}else{
		if (isset($versements->id)) {
		 	$versements->supprime();
		 	$Piece = Pieces_comptables::trouve_par_operation_and_type($versements->id,3);
		 	if (isset($Piece->id)) {
		 	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece->id);
		 		$Piece->supprime();
		 	}

		 $reglement = Solde_client::trouve_versement_par_id_client($id_client);
		 	 $Data = array(
        'somme' => $reglement->somme,
        'solde' => $reglement->solde,
        'credit' => $reglement->credit
          );

    $returnData = array(
            'status' => 'ok',
            'msg' => 'Règlement supprimer  avec succes.',
            'data' => $Data
        );
		 }	 
	}


     echo json_encode($returnData);

	
	 }

?>