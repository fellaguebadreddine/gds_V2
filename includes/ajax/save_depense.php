<?php
require_once("../includes/initialiser.php");

?>  

<?php	if(isset($_POST['id_depense']) ){
	$errors = array();
 	$random_number = rand();
	
		// new object 

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
	
 $id_societe =  htmlspecialchars(intval($_POST['id_societe'])) ;
 $id_user =  htmlspecialchars(intval($_POST['id_user'])) ;
	
	$fact_depnse = new Facture_depense();
		
	$fact_depnse->id_societe = htmlentities(trim($_POST['id_societe']));
	$fact_depnse->id_user = htmlentities(trim($_POST['id_user']));
	$fact_depnse->id_depense = htmlentities(trim($_POST['id_depense']));
	$fact_depnse->id_fournisseur = htmlentities(trim($_POST['id_fournisseur']));
	$fact_depnse->date_fact = htmlentities(trim($_POST['date_fact']));
	$fact_depnse->reference = htmlentities(trim($_POST['reference']));
	$fact_depnse->ht = htmlentities(trim($_POST['ht']));
	$fact_depnse->tva = htmlentities(trim($_POST['tva']));
	$fact_depnse->timbre = htmlentities(trim($_POST['timbre']));
	$fact_depnse->ttc = htmlentities(trim($_POST['ttc']));
	if(!empty($_POST['facture_scan'])){
	$fact_depnse->facture_scan = htmlentities(trim($_POST['facture_scan']));
	}
	
	$fact_depnse->random =  $random_number;

	if (empty($errors)){
if ($fact_depnse->existe()) {

	echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.warning("facture depense existe déja  !","Très Bien");
				  });
                  </script>';
			
		}else{
			$fact_depnse->save();?>
				  <script type="text/javascript">
			toastr.success("facture depense enregistrer  avec succes  !","Très Bien");
			$(document).ready(function(){
			$('#depense_form input[type="text"]').val('');
			$('#depense_form input[type="number"]').val('');
			$('#depense_form input[type="date"]').val('');
			$('.img-responsive input[type="hidden"]').val('');
			$(".select2me").select2("val", "");
			});
			</script>
	<?php
		// UPDATE UPLOAD SCAN
	 if (!empty($_POST['facture_scan'])){
	$upload = Upload:: trouve_par_id($_POST['facture_scan']);
	$upload->status = 1;
	$upload->save();
	}

		$depense_fournisseur=Facture_depense::trouve_par_random($random_number);

				             /////////// Valid table Reglement ////////////////
		$table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($id_user,$id_societe,2);


		        foreach($table_Reglements as $table_Reglement){
                $table_Reglement->id_facture = $depense_fournisseur->id;
                $table_Reglement->modifier();
                if ($table_Reglement->id_solde != 0) {
                $Solde_fournisseur = Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                $Reste =  $Solde_fournisseur->solde - ($table_Reglement->somme + $table_Reglement->timbre);
                $Solde_fournisseur->solde = $Reste;
                if ($Reste == 0 ) {
                $Solde_fournisseur->etat = 2;   
                }
                $Solde_fournisseur->modifier();
                } 
                   
              		}



				/////////////////////// ajouter piece comptable automatiquement ///////////////////////////////
				$societe= Societe::trouve_par_id($_POST['id_societe']);
				$Fournisseur = Fournisseur::trouve_par_id($_POST['id_fournisseur']);

			
				$Pieces_comptables = new Pieces_comptables();

				$Pieces_comptables->id_societe = $depense_fournisseur->id_societe;
				$Pieces_comptables->id_op_auto =  $depense_fournisseur->id;
				$Pieces_comptables->type_op =  5;
				$Pieces_comptables->ref_piece =  $depense_fournisseur->reference;
				$Pieces_comptables->libelle =  ' DEPENSE - '.$Fournisseur->nom;
				$Pieces_comptables->date =  $depense_fournisseur->date_fact;
				$Pieces_comptables->date_valid =  date("Y-m-d");
				$Pieces_comptables->journal = $societe->journal_depense;
				$Pieces_comptables->somme_debit = $depense_fournisseur->ttc;
				$Pieces_comptables->somme_credit = $depense_fournisseur->ttc;
				$Pieces_comptables->random =  $random_number;
				$Pieces_comptables->save();

				///////////// ajouter les ecriture comptable de cette piece /////////////////// 
				$Piece = Pieces_comptables::trouve_par_random($random_number);
				$depense =Depense::trouve_par_id($depense_fournisseur->id_depense) ;
				
				///////////////////////////////////// ecriture Depense //////////////////////////////

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
				$Ecriture_comptable->id_person = $Solde_fournisseur->id_person;
				$Ecriture_comptable->id_societe = $Piece->id_societe;
				$Ecriture_comptable->id_auxiliere = $Fournisseur->auxiliere_achat;
				$Ecriture_comptable->credit = $depense_fournisseur->ttc;
				$Ecriture_comptable->save();


		}
 		
		
		}
 		 
 		
}

?>