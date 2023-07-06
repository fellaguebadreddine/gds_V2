<?php
require_once("../includes/initialiser.php");

?>  

<?php	if(isset($_POST['id_fournisseur']) ){
	$errors = array();

		if (!isset($_POST['debit'])||empty($_POST['debit'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Montant est vides  !","Attention");
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
                  toastr.error("Choisir un Fournisseur  !","Attention");
				  });
                  </script>';
	}
	
		// new object client
	// new object admin client
	$random_number = rand();
	$versement = new Solde_fournisseur();
	$versement->debit = htmlentities(trim($_POST['debit']));
	$versement->solde = htmlentities(trim($_POST['debit']));
	$versement->reference = htmlentities(trim($_POST['reference']));
	$versement->mode_paiment = htmlentities(trim($_POST['mode_paiment']));
if (isset($_POST['banque'])) {
	$versement->banque = htmlentities(trim($_POST['banque']));
}
if (isset($_POST['caisse'])) {
	$versement->caisse = htmlentities(trim($_POST['caisse']));
}
	$versement-> date = htmlentities(trim($_POST['date']));
	$versement->id_fournisseur = htmlentities(trim($_POST['id_fournisseur']));
	$versement->id_societe = htmlentities(trim($_POST['id_societe']));
	$versement->id_person = htmlentities(trim($_POST['id_user']));
	$versement->random = $random_number;
	$Fournisseur = Fournisseur::trouve_par_id($versement->id_fournisseur);

	if (empty($errors)){
if ($versement->save()) { ?>
			
			
			<script type="text/javascript">
			$(document).ready(function(){
                  toastr.success("Versement enregistrer  avec succes  !","Très bien");
				  });
			$(document).ready(function(){
			$('#versement_form_f input[type="text"]').val('');
			$('#versement_form_f input[type="number"]').val('');
			});
                  </script>
<?php  
$Solde_fournisseur=Solde_fournisseur::trouve_par_random($random_number);
$nav_societe = Societe::trouve_par_id($versement->id_societe);
if (isset($_POST['banque'])) {
	$Banque_caisse = Compte::trouve_par_id($versement->banque) ; 
} else if ($_POST['caisse']) {
	$Banque_caisse = Caisse::trouve_par_id($versement->caisse) ; 
}
/////////////////////// ajouter piece comptable automatiquement ///////////////////////////////

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $Solde_fournisseur->id_societe;
	$Pieces_comptables->id_op_auto =  $Solde_fournisseur->id;
	$Pieces_comptables->type_op =  4;
	$Pieces_comptables->ref_piece =  $Solde_fournisseur->reference;
	$Pieces_comptables->libelle =  ' REGLEMENT FOURNISSEUR - '.$Fournisseur->nom;
	$Pieces_comptables->date =  $Solde_fournisseur->date;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $Banque_caisse->journal;
	$Pieces_comptables->somme_debit = $Solde_fournisseur->debit;
	$Pieces_comptables->somme_credit = $Solde_fournisseur->debit;
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();

///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);

/////////////////////////////////////////////////// ecriture Banque_caisse //////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
		$Ecriture_comptable->id_compte = $Fournisseur->Compte;
	if (isset($Fournisseur->Compte)) {
	$Compte_comp = Compte_comptable::trouve_par_id($Fournisseur->Compte);
	}
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
	$Ecriture_comptable->id_auxiliere = $Banque_caisse->auxiliere_achat;
	$Ecriture_comptable->debit = $Solde_fournisseur->debit;
	$Ecriture_comptable->save();

///////////////////////////////////// ecriture Fournisseur //////////////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Banque_caisse->comptes_achat;

	if (isset($Banque_caisse->comptes_achat)) {
	$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_achat);
	}
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
	$Ecriture_comptable->credit = $Solde_fournisseur->debit;
	$Ecriture_comptable->save();
		}
 		
		
		}
 		 
 		
}

?>