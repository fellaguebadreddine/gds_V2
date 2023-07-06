<?php
require_once("../includes/initialiser.php");


	 if(!empty($_SESSION['societe'])){
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);}

if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { 
		 $id = htmlspecialchars(trim($_POST['id']));
		 $id_fournisseur = htmlspecialchars(trim($_POST['id_fournisseur']));
	$versements = Solde_fournisseur::trouve_par_id($id);
	$Reglement_fournisseur = Reglement_fournisseur::trouve_Reglement_par_id_solde($id,$nav_societe->id_societe);
	
	if (isset($Reglement_fournisseur->id)) {

			 $returnData = array(
            'status' => 'error',
            'msg' => 'Règlement déja utilisé .'
        );


	}else{
		if (isset($versements->id)) {
		 	$versements->supprime();
		 	$Piece = Pieces_comptables::trouve_par_operation_and_type($versements->id,4);
		 	if (isset($Piece->id)) {
		 	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece->id);
		 		$Piece->supprime();
		 	}

		 $reglement = Solde_fournisseur::trouve_versement_par_id_fournisseur($id_fournisseur);
		 	 $Data = array(
        'somme' => $reglement->somme,
        'solde' => $reglement->solde,
        'debit' => $reglement->debit
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