<?php
require_once("../includes/initialiser.php");

?>  

<?php

	$errors = array();
 	
	
		// new object 
if(isset($_POST['id']) ){
	$id= htmlspecialchars(trim($_POST['id']));
	
	// new object admin 
        	if (!isset($_POST['id_depense'])||empty($_POST['id_depense'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Depense est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['reference'])||empty($_POST['reference'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ reference est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['id_fournisseur'])||empty($_POST['id_fournisseur'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ fournisseur est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['date_fact'])||empty($_POST['date_fact'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ date facture est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['ht'])||empty($_POST['ht'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ HT est vides  !","Attention");
				  });
                  </script>';
	}
   
	$fact_depnse = Facture_depense::trouve_par_id($id);
	
	$fact_depnse->id_depense = htmlentities(trim($_POST['id_depense']));
	$fact_depnse->id_fournisseur = htmlentities(trim($_POST['id_fournisseur']));
	$fact_depnse->date_fact = htmlentities(trim($_POST['date_fact']));
	$fact_depnse->reference = htmlentities(trim($_POST['reference']));
	$fact_depnse->ht = htmlentities(trim($_POST['ht']));
	$fact_depnse->tva = htmlentities(trim($_POST['tva']));
	$fact_depnse->timbre = htmlentities(trim($_POST['timbre']));
	$fact_depnse->ttc = htmlentities(trim($_POST['ttc']));
	$fact_depnse->id_societe = htmlentities(trim($_POST['id_societe']));
	$fact_depnse->id_user = htmlentities(trim($_POST['id_user']));
	if(!empty($_POST['facture_scan'])){
	$fact_depnse->facture_scan = htmlentities(trim($_POST['facture_scan']));
	}
	
	
	if (empty($errors)){
if ($fact_depnse->save()) {

            echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.success("Depense est bien modifier  !");
				  });
                  </script>';
		// UPDATE UPLOAD SCAN
	 if (!empty($_POST['facture_scan'])){
	$upload = Upload:: trouve_par_id($_POST['facture_scan']);
	$upload->status = 1;
	$upload->save();
	}
				/////////////////////// MODIFIER piece comptable automatiquement ///////////////////////////////
				
				$societe= Societe::trouve_par_id($_POST['id_societe']);
				$Fournisseur = Fournisseur::trouve_par_id($_POST['id_fournisseur']);

				$depense_fournisseur=Facture_depense::trouve_par_id($id);
				
				$Pieces_comptables = Pieces_comptables::trouve_par_random($depense_fournisseur->random);
				
				$Pieces_comptables->id_societe = $depense_fournisseur->id_societe;
				$Pieces_comptables->id_op_auto =  $depense_fournisseur->id;
				$Pieces_comptables->ref_piece =  $depense_fournisseur->reference;
				$Pieces_comptables->date =  $depense_fournisseur->date_fact;
				$Pieces_comptables->date_valid =  date("Y-m-d");
				$Pieces_comptables->somme_debit = $depense_fournisseur->ttc;
				$Pieces_comptables->somme_credit = $depense_fournisseur->ttc;
				
				$Pieces_comptables->save();

				///////////// ajouter les ecriture comptable de cette piece /////////////////// 
				$Piece = Pieces_comptables::trouve_par_random($depense_fournisseur->random);
				$depense =Depense::trouve_par_id($depense_fournisseur->id_depense) ;
				///////////////////////////////////// ecriture Depense //////////////////////////////
				$Ecriture_comptables = Ecriture_comptable::trouve_ecriture_par_id_pieces($Piece->id);

				foreach ($Ecriture_comptables as $Ecriture_comptabl){
				$Ecriture_comptabl->supprime();
				
				}
				
				$Ecriture_comptable = new Ecriture_comptable();
			
				$Ecriture_comptable->id_compte = $depense->comptes_depense;

				$Compte_comp = Compte_comptable::trouve_par_id($depense->comptes_depense);
				if (isset($Compte_comp->code)) {
				$Ecriture_comptable->code_comptable = $Compte_comp->code;
				}
				$Ecriture_comptable->id_piece = $Piece->id;
				$Ecriture_comptable->date = $Piece->date;
				$Ecriture_comptable->ref_piece = $Piece->ref_piece;
				$Ecriture_comptable->lib_piece = $Piece->libelle;
				$Ecriture_comptable->journal = $Piece->journal;
				$Ecriture_comptable->id_person = $depense_fournisseur->id_user;
				$Ecriture_comptable->id_societe = $Piece->id_societe;
				$Ecriture_comptable->id_auxiliere = $depense->auxiliere_depense;
				$Ecriture_comptable->debit = $depense_fournisseur->ht;
				$Ecriture_comptable->save();
				///////////////////////////////////// ecriture TVA DEPENCE //////////////////////////////
				
				$Ecriture_comptable = new Ecriture_comptable();
			
				$Ecriture_comptable->id_compte = $societe->tva_achat;
				$Ecriture_comptable->id_auxiliere = $societe->aux_tva_achat;
				$Compte_comp = Compte_comptable::trouve_par_id($societe->tva_achat);
				if (isset($Compte_comp->code)) {
				$Ecriture_comptable->code_comptable = $Compte_comp->code;
				}
				$Ecriture_comptable->id_piece = $Piece->id;
				$Ecriture_comptable->date = $Piece->date;
				$Ecriture_comptable->ref_piece = $Piece->ref_piece;
				$Ecriture_comptable->lib_piece = $Piece->libelle;
				$Ecriture_comptable->journal = $Piece->journal;
				$Ecriture_comptable->id_person = $depense_fournisseur->id_user;
				$Ecriture_comptable->id_societe = $Piece->id_societe;
				
				$Ecriture_comptable->debit = $depense_fournisseur->tva;
				$Ecriture_comptable->save();

				///////////////////////////////////// ecriture TIMBRE DEPENCE //////////////////////////////

				$Ecriture_comptable = new Ecriture_comptable();
			
				$Ecriture_comptable->id_compte = $societe->comptes_achat;
				$Ecriture_comptable->id_auxiliere = $societe->auxiliere_achat;

				$Compte_comp = Compte_comptable::trouve_par_id($societe->comptes_achat);
				if (isset($Compte_comp->code)) {
				$Ecriture_comptable->code_comptable = $Compte_comp->code;
				}
				$Ecriture_comptable->id_piece = $Piece->id;
				$Ecriture_comptable->date = $Piece->date;
				$Ecriture_comptable->ref_piece = $Piece->ref_piece;
				$Ecriture_comptable->lib_piece = $Piece->libelle;
				$Ecriture_comptable->journal = $Piece->journal;
				$Ecriture_comptable->id_person = $depense_fournisseur->id_user;
				$Ecriture_comptable->id_societe = $Piece->id_societe;
				
				$Ecriture_comptable->debit = $depense_fournisseur->timbre;
				$Ecriture_comptable->save();
				///////////////////////////////////// ecriture Fournisseur //////////////////////////////

				$Ecriture_comptable = new Ecriture_comptable();
			
				$Ecriture_comptable->id_compte = $Fournisseur->Compte;

				$Compte_comp = Compte_comptable::trouve_par_id($Fournisseur->Compte);
				if (isset($Compte_comp->code)) {
				$Ecriture_comptable->code_comptable = $Compte_comp->code;
				}
				$Ecriture_comptable->id_piece = $Piece->id;
				$Ecriture_comptable->date = $Piece->date;
				$Ecriture_comptable->ref_piece = $Piece->ref_piece;
				$Ecriture_comptable->lib_piece = $Piece->libelle;
				$Ecriture_comptable->journal = $Piece->journal;
				$Ecriture_comptable->id_person =  $depense_fournisseur->id_user;
				$Ecriture_comptable->id_societe = $Piece->id_societe;
				$Ecriture_comptable->id_auxiliere = $Fournisseur->auxiliere_achat;
				$Ecriture_comptable->credit = $depense_fournisseur->ttc;
				$Ecriture_comptable->save();


		}
 		
		
		}
 		 
 		

}
?>