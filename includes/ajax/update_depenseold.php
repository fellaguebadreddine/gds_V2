<?php
require_once("../includes/initialiser.php");

?>  

<?php
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
	$errors = array();
 	
	
		// new object 

	// new object admin 
        if (empty(htmlspecialchars(trim($_GET['id_depense'])))) {
                $errors[]= 'Choisir depense !';
        }
        if (empty(htmlspecialchars(trim($_GET['reference'])))) {
            $errors[]= 'Choisir reference !';
        }
        if (empty(htmlspecialchars(trim($_GET['id_fournisseur'])))) {
            $errors[]= 'Choisir fournisseur !';
        }	
        if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
            $errors[]= 'Choisir date !';
        }
        if (empty(htmlspecialchars(trim($_GET['ht'])))) {
            $errors[]= 'Choisir ht !';
        }
    $fact_depnse= Societe::trouve_par_id($_POST['id_societe']);
	$fact_depnse->id_depense = htmlentities(trim($_GET['id_depense']));
	$fact_depnse->id_fournisseur = htmlentities(trim($_GET['id_fournisseur']));
	$fact_depnse->date_fact = htmlentities(trim($_GET['date_fact']));
	$fact_depnse->reference = htmlentities(trim($_GET['reference']));
	$fact_depnse->ht = htmlentities(trim($_GET['ht']));
	$fact_depnse->tva = htmlentities(trim($_GET['tva']));
	$fact_depnse->timbre = htmlentities(trim($_GET['timbre']));
	$fact_depnse->ttc = htmlentities(trim($_GET['ttc']));
	if(!empty($_GET['facture_scan'])){
	$fact_depnse->facture_scan = htmlentities(trim($_GET['facture_scan']));
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
				/////////////////////// ajouter piece comptable automatiquement ///////////////////////////////
				$societe= Societe::trouve_par_id($_POST['id_societe']);
				$Fournisseur = Fournisseur::trouve_par_id($_POST['id_fournisseur']);

				$depense_fournisseur=Facture_depense::trouve_par_id($random_number);
				
				$Pieces_comptables->id_societe = $depense_fournisseur->id_societe;
				$Pieces_comptables->id_op_auto =  $depense_fournisseur->id;
				$Pieces_comptables->ref_piece =  $depense_fournisseur->reference;
				$Pieces_comptables->date =  $depense_fournisseur->date_fact;
				$Pieces_comptables->date_valid =  date("Y-m-d");
				$Pieces_comptables->somme_debit = $depense_fournisseur->ttc;
				$Pieces_comptables->somme_credit = $depense_fournisseur->ttc;
				
				$Pieces_comptables->save();

				///////////// ajouter les ecriture comptable de cette piece /////////////////// 
				$Piece = Pieces_comptables::trouve_par_id($id);
				$depense =Depense::trouve_par_id($depense_fournisseur->id_depense) ;
				
				///////////////////////////////////// ecriture Depense //////////////////////////////

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
				$Ecriture_comptable->id_person = $Solde_fournisseur->id_person;
				$Ecriture_comptable->id_societe = $Piece->id_societe;
				$Ecriture_comptable->id_auxiliere = $Fournisseur->auxiliere_achat;
				$Ecriture_comptable->credit = $depense_fournisseur->ttc;
				$Ecriture_comptable->save();


		}
 		
		
		}
 		 
 		
}

?>