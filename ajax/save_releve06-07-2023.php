<?php
require_once("../includes/initialiser.php");

?>  

<?php	if(isset($_GET['id_nature']) ){
	$id_societe=htmlentities(trim($_GET['id_societe']));
	$errors = array();
 	$random_number = rand();
 	$random_number2 = rand();	
		// new object 

	// new object admin 

	if (!isset($_GET['date'])||empty($_GET['date'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ date est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['ref_releve'])||empty($_GET['ref_releve'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ reference est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['id_tier'])||empty($_GET['id_tier'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ TIER est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['libelle'])||empty($_GET['libelle'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Désignation est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['id_nature'])||empty($_GET['id_nature'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Nature Opération  est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['somme_debit']) ){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ debit est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['somme_credit'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ credit est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['mode_paiment'])||empty($_GET['mode_paiment'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ mode paiment est vides  !","Attention");
				  });
                  </script>';
	}
		
	$releve_comptes = new Releve_comptes();
		
	$releve_comptes->id_societe = htmlentities(trim($_GET['id_societe']));
	$releve_comptes->id_user = htmlentities(trim($_GET['id_user']));
	$releve_comptes->id_nature = htmlentities(trim($_GET['id_nature']));
	
	$releve_comptes->id_banque = htmlentities(trim($_GET['id_banque']));
	$releve_comptes->id_caisse = htmlentities(trim($_GET['id_caisse']));
	
	if (isset($_GET['id_tier'])) {
  $id =  htmlspecialchars(($_GET['id_tier'])) ;
  $new_id = substr($id, 0, 1);
  
  if ($new_id =='b'){
   $id_banque=substr($id,  2);
   
	$releve_comptes->id_tier = $id_banque;
  }else if ($new_id =='c'){
			$id_caisse=substr($id, 2);
			$releve_comptes->id_tier = $id_caisse;
  }else{
	  $releve_comptes->id_tier = htmlentities(trim($_GET['id_tier']));
  }
	}
	$releve_comptes->date = htmlentities(trim($_GET['date']));
	$releve_comptes->date_valid = htmlentities(trim($_GET['date_valid']));
	$releve_comptes->ref_releve = htmlentities(trim($_GET['ref_releve']));
	$releve_comptes->somme_debit = htmlentities(trim($_GET['somme_debit']));
	$releve_comptes->somme_credit = htmlentities(trim($_GET['somme_credit']));
	$releve_comptes->libelle = htmlentities(trim($_GET['libelle']));
	$releve_comptes->mode_paiment = htmlentities(trim($_GET['mode_paiment']));
	if(!empty($_GET['facture_scan'])){
	$releve_comptes->facture_scan = htmlentities(trim($_GET['facture_scan']));
	}
	
	$releve_comptes->random =  $random_number;
	////////////////////////////// DEBUT ERROR ////////////////////////////////
	if (empty($errors)){
		try {
			$bd->beginTransactions();
	////////////////////////////// DEBUT TRANSACTION //////////////////////////////
		
	if ($releve_comptes->existe()) {

	echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.warning("Releve existe déja  !","Très Bien");
				  });
            </script>';
			
		}else{
			$releve_comptes->save();?>
			<script type="text/javascript">
				toastr.success("releve enregistrer  avec succes  !","Très Bien");
				$(document).ready(function(){			
				$('#releve_form input[type="text"]').val('');
				$('#releve_form input[type="number"]').val('');
				$('#releve_form input[type="date"]').val('');
				$('.img-responsive input[type="hidden"]').val('');
				$("#id_nature").select2("val", "");			
				});
		</script>
	<?php
		// UPDATE UPLOAD SCAN
	 if (!empty($_GET['facture_scan'])){
	$upload = Upload:: trouve_par_id($_GET['facture_scan']);
	$upload->status = 1;
	$upload->save();
	}
	if (isset($_GET['id_nature'])){
		switch ($_GET['id_nature']) {
			case 1:			
	$versement = new Solde_client();
	$versement->credit = htmlentities(trim($_GET['somme_credit']));
	$versement->solde = htmlentities(trim($_GET['somme_credit']));
	$versement->reference = htmlentities(trim($_GET['ref_releve']));
	$versement->mode_paiment = htmlentities(trim($_GET['mode_paiment']));
	if (isset($_GET['id_banque'])) {
		$versement->banque = htmlentities(trim($_GET['id_banque']));
	}
	if (isset($_GET['id_caisse'])) {
		$versement->caisse = htmlentities(trim($_GET['id_caisse']));
	}
	$versement->date = htmlentities(trim($_GET['date']));
	$versement->id_client = htmlentities(trim($_GET['id_tier']));
	$versement->id_societe = htmlentities(trim($_GET['id_societe']));
	$versement->id_person = htmlentities(trim($_GET['id_user']));
	$versement->random = $random_number;
	$versement->save();
	
	////////////// ajouter piece //////////////
	
	$Solde_client=Solde_client::trouve_par_random($random_number);
	$nav_societe = Societe::trouve_par_id($versement->id_societe);
	$Client = Client::trouve_par_id($_GET['id_tier']);
	
	if (!empty($_GET['id_banque'])) {
		$Banque_caisse = Compte::trouve_par_id_banque_and_id_societe($_GET['id_banque'],$id_societe) ; 
	} 
	if (!empty($_GET['id_caisse'])) {
		$Banque_caisse = Caisse::trouve_par_id($_GET['id_caisse']) ; 
	}
/////////////////////// ajouter piece comptable automatiquement ///////////////////////////////

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $Solde_client->id_societe;
	$Pieces_comptables->id_op_auto =  $Solde_client->id;
	$Pieces_comptables->type_op =  3;
	$Pieces_comptables->ref_piece =  $Solde_client->reference;
	$Pieces_comptables->libelle =  ' REGLEMENT CLIENT - '.$Client->nom;
	$Pieces_comptables->date =  $Solde_client->date;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $Banque_caisse->journal;
	$Pieces_comptables->somme_debit = $Solde_client->credit;
	$Pieces_comptables->somme_credit = $Solde_client->credit;
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();

	///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);

	/////////////////////////////////////////////////// ecriture Banque_caisse //////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	if (!empty($_GET['id_banque'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_achat;
		if (isset($Banque_caisse->comptes_achat)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_achat);
		}
	} 
	if (!empty($_GET['id_caisse'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_caisse;
		if (isset($Banque_caisse->comptes_caisse)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_caisse);
		}
	}

	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $Solde_client->id_person;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Banque_caisse->auxiliere_achat;
	$Ecriture_comptable->debit = $Solde_client->credit;
	$Ecriture_comptable->save();

///////////////////////////////////// ecriture Client //////////////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Client->Compte;
	if (isset($Client->Compte)) {
	$Compte_comp = Compte_comptable::trouve_par_id($Client->Compte);
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $versement->id_person;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Client->auxiliere_achat;
	$Ecriture_comptable->credit = $versement->credit;
	$Ecriture_comptable->save();
				
			break;
			case 2:
			case 3:
			case 4:
				$versement = new Solde_fournisseur();
	$versement->debit = htmlentities(trim($_GET['somme_debit']));
	$versement->solde = htmlentities(trim($_GET['somme_debit']));
	$versement->reference = htmlentities(trim($_GET['ref_releve']));
	$versement->mode_paiment = htmlentities(trim($_GET['mode_paiment']));
	if (!empty($_GET['id_banque'])) {
		$versement->banque = htmlentities(trim($_GET['id_banque']));
	}
	if (!empty($_GET['id_caisse'])) {
		$versement->caisse = htmlentities(trim($_GET['id_caisse']));
	}
	$versement->date = htmlentities(trim($_GET['date']));
	$versement->id_fournisseur = htmlentities(trim($_GET['id_tier']));
	$versement->id_societe = htmlentities(trim($_GET['id_societe']));
	$versement->id_person = htmlentities(trim($_GET['id_user']));
	$versement->random = $random_number;
	$versement->save();
	///// ajouter piece /////
	$Solde_fournisseur=Solde_fournisseur::trouve_par_random($random_number);
	$nav_societe = Societe::trouve_par_id($versement->id_societe);
	$Fournisseur = Fournisseur::trouve_par_id($_GET['id_tier']);

	if (!empty($_GET['id_banque'])) {
		$Banque_caisse = Compte::trouve_par_id_banque_and_id_societe($_GET['id_banque'],$id_societe) ; 
	} 
	if (!empty($_GET['id_caisse'])) {
		$Banque_caisse = Caisse::trouve_par_id($_GET['id_caisse']) ; 
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
	if (!empty($_GET['id_banque'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_achat;
		if (isset($Banque_caisse->comptes_achat)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_achat);
		}
	} 
	if (!empty($_GET['id_caisse'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_caisse;
		if (isset($Banque_caisse->comptes_caisse)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_caisse);
		}
	}
	/////////////////////////
	
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
			
			break;
	/////////////////  VEREMENET INTERNE //////////////////
		case 5:

	
	$id_releve=Releve_comptes::trouve_par_random($random_number);
	
	$releve_compte = new Releve_comptes();
		
	$releve_compte->id_societe = htmlentities(trim($_GET['id_societe']));
	$releve_compte->id_user = htmlentities(trim($_GET['id_user']));
	$releve_compte->id_nature = htmlentities(trim($_GET['id_nature']));
	
	if (isset($_GET['id_tier'])) {
		$id =  htmlspecialchars(($_GET['id_tier'])) ;
		$new_id = substr($id, 0, 1);				
		  if ($new_id =='b'){
		   if (!empty($id_releve->id_banque)){
			$releve_compte->id_tier = $id_releve->id_banque;
		   }
		   if (!empty($id_releve->id_caisse)){
			$releve_compte->id_tier = $id_releve->id_caisse;
		   }
			$releve_compte->id_banque =$id_releve->id_tier;			
		  }
		  if ($new_id =='c'){
			if (!empty($id_releve->id_banque)){
			$releve_compte->id_tier = $id_releve->id_banque;
		   }
		   if (!empty($id_releve->id_caisse)){
			$releve_compte->id_tier = $id_releve->id_caisse;
		   }						
			$releve_compte->id_caisse = $id_releve->id_tier;
		  }
	}
	
	$releve_compte->date = htmlentities(trim($_GET['date']));
	$releve_compte->date_valid = htmlentities(trim($_GET['date_valid']));
	$releve_compte->ref_releve = htmlentities(trim($_GET['ref_releve']));
	$releve_compte->somme_debit = htmlentities(trim($_GET['somme_credit']));
	$releve_compte->somme_credit = htmlentities(trim($_GET['somme_debit']));
	$releve_compte->libelle = htmlentities(trim($_GET['libelle']));
	$releve_compte->mode_paiment = htmlentities(trim($_GET['mode_paiment']));
	if(!empty($_GET['facture_scan'])){
	$releve_compte->facture_scan = htmlentities(trim($_GET['facture_scan']));
	}	
	$releve_compte->random =  $random_number;
	$releve_compte->save();
	
	////////////// ajouter piece //////////////
	
	$code_compte='580000';
	$compte_comptables = Compte_comptable::trouve_par_code($code_compte,$id_societe);

	
	if (!empty($_GET['id_banque'])) {
		$Banque_caisse = Compte::trouve_par_id_banque_and_id_societe($_GET['id_banque'],$id_societe) ; 
		if (isset($Banque_caisse->id_banque)){
			$bank_caisse=Banque::trouve_par_id($Banque_caisse->id_banque);
		}
	} 
	if (!empty($_GET['id_caisse'])) {
		$Banque_caisse = Caisse::trouve_par_id($_GET['id_caisse']) ; 
		if (isset($Banque_caisse->id_caisse)){
			$bank_caisse=Caisse::trouve_par_id($Banque_caisse->id_caisse);
		}
	} 
	/////////////////////// ajouter piece comptable automatiquement ///////////////////////////////

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $id_societe;
	$Pieces_comptables->id_op_auto =  $id_releve->id;
	$Pieces_comptables->type_op = 10;
	$Pieces_comptables->ref_piece =  $id_releve->ref_releve;
	$Pieces_comptables->libelle =  ' Virement Interne - '.$bank_caisse->Designation;
	$Pieces_comptables->date =  $id_releve->date;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $Banque_caisse->journal;
	if ($id_releve->somme_credit > 0){
	$Pieces_comptables->somme_debit = $id_releve->somme_credit;
	$Pieces_comptables->somme_credit = $id_releve->somme_credit;
	}else {
		$Pieces_comptables->somme_debit = $id_releve->somme_debit;
		$Pieces_comptables->somme_credit = $id_releve->somme_debit;
	}
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();
	
	
	///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);
	

	///////////////////////////////////// ecriture Virement Interne //////////////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $compte_comptables->id;
	if (isset($compte_comptables->id)) {
	$Compte_comp = Compte_comptable::trouve_par_id($compte_comptables->id);
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $id_releve->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $compte_comptables->code;
	if ($id_releve->somme_credit >0){
	$Ecriture_comptable->debit = $id_releve->somme_credit;
	}else{
		$Ecriture_comptable->debit = $id_releve->somme_debit;
	}
	$Ecriture_comptable->save();
	
	
	////////////////////////////// ecriture Banque_caisse //////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	if (!empty( $id_banque)) {
		$Banque_caisse2 =  Compte::trouve_par_id_banque_and_id_societe($id_banque,$id_societe) ; 
		$Ecriture_comptable->id_compte = $Banque_caisse2->comptes_achat;
		if (isset($Banque_caisse2->comptes_achat)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse2->comptes_achat);
		}
		if (isset($Banque_caisse2->id_banque)){
			$bank_caisse=Banque::trouve_par_id($Banque_caisse2->id_banque);
		}
	} 
	if (!empty($id_caisse)) {
		$Banque_caisse2 =  Caisse::trouve_par_id($id_caisse) ; 
		$Ecriture_comptable->id_compte = $Banque_caisse2->comptes_caisse;
		if (isset($Banque_caisse2->comptes_caisse)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse2->comptes_caisse);
		}
		if (isset($Banque_caisse2->id_caisse)){
			$bank_caisse=Caisse::trouve_par_id($Banque_caisse2->id_caisse);
		}
	}


	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $id_releve->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Banque_caisse2->auxiliere_achat;
	
	if ($id_releve->somme_credit >0){
	
	$Ecriture_comptable->credit = $id_releve->somme_credit;
	}else{
		
		$Ecriture_comptable->credit = $id_releve->somme_debit;
	}
	$Ecriture_comptable->save();
	
	/////////////////////// ajouter piece comptable automatiquement ///////////////////////////////

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $id_societe;
	$Pieces_comptables->id_op_auto =  $id_releve->id;
	$Pieces_comptables->type_op = 10;
	$Pieces_comptables->ref_piece =  $id_releve->ref_releve;
	$Pieces_comptables->libelle =  ' Virement Interne - '.$bank_caisse->Designation;
	$Pieces_comptables->date =  $id_releve->date;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $Banque_caisse->journal;
	if ($id_releve->somme_credit >0){
	$Pieces_comptables->somme_debit = $id_releve->somme_credit;
	$Pieces_comptables->somme_credit = $id_releve->somme_credit;
	}else{
		$Pieces_comptables->somme_debit = $id_releve->somme_debit;
		$Pieces_comptables->somme_credit = $id_releve->somme_debit;
	}
	$Pieces_comptables->random =  $random_number2;
	$Pieces_comptables->save();
	
	
	///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number2);
	
	
	
	////////////////////////////// ecriture Banque_caisse //////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	if (!empty($_GET['id_banque'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_achat;
		if (isset($Banque_caisse->comptes_achat)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_achat);
		}
	} 
	if (!empty($_GET['id_caisse'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_caisse;
		if (isset($Banque_caisse->comptes_caisse)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_caisse);
		}
	}

	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $id_releve->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Banque_caisse->auxiliere_achat;
	if ($id_releve->somme_credit > 0){
		$Ecriture_comptable->debit = $id_releve->somme_credit;
	}else{
		$Ecriture_comptable->debit = $id_releve->somme_debit;
	}
	$Ecriture_comptable->save();


	///////////////////////////////////// ecriture Virement Interne //////////////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $compte_comptables->id;
	if (isset($compte_comptables->id)) {
	$Compte_comp = Compte_comptable::trouve_par_id($compte_comptables->id);
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $id_releve->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $compte_comptables->code;
	if ($id_releve->somme_credit>0){
		$Ecriture_comptable->credit = $id_releve->somme_credit;
	}else{
		$Ecriture_comptable->credit = $id_releve->somme_debit;
	}
	$Ecriture_comptable->save();

	
	break;
	/////////////////  AGIOS //////////////////
		
		case 6:

	////////////// ajouter piece //////////////
	$id_releve=Releve_comptes::trouve_par_random($random_number);
	$code_compte='627000';
	$compte_comptables = Compte_comptable::trouve_par_code($code_compte,$id_societe);
	
	if (!empty($_GET['id_banque'])) {
		$Banque_caisse = Compte::trouve_par_id_banque_and_id_societe($_GET['id_banque'],$id_societe) ; 
	} 
	
/////////////////////// ajouter piece comptable automatiquement ///////////////////////////////

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $id_societe;
	$Pieces_comptables->id_op_auto =  $id_releve->id;
	$Pieces_comptables->type_op = 9;
	$Pieces_comptables->ref_piece =  $id_releve->ref_releve;
	$Pieces_comptables->libelle =  ' Agios - '.$compte_comptables->libelle;
	$Pieces_comptables->date =  $id_releve->date;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $Banque_caisse->journal;
	$Pieces_comptables->somme_debit = $id_releve->somme_credit;
	$Pieces_comptables->somme_credit = $id_releve->somme_credit;
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();

	///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);
	
	
///////////////////////////////////// ecriture agios //////////////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $compte_comptables->id;
	if (isset($compte_comptables->id)) {
	$Compte_comp = Compte_comptable::trouve_par_id($compte_comptables->id);
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $id_releve->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $compte_comptables->code;
	$Ecriture_comptable->debit = $id_releve->somme_credit;
	$Ecriture_comptable->save();
		

	////////////////////////////// ecriture Banque_caisse //////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	if (!empty($_GET['id_banque'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_achat;
		if (isset($Banque_caisse->comptes_achat)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_achat);
		}
	} 

	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $id_releve->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Banque_caisse->auxiliere_achat;
	$Ecriture_comptable->credit = $id_releve->somme_credit;
	$Ecriture_comptable->save();
	
	break;
				
	////////////////////// AUTRE /////////////////////////////////////////////////

	case 14:

		////////////// ajouter piece //////////////
		$id_releve=Releve_comptes::trouve_par_random($random_number);
		
		$compte_comptables = Compte_comptable::trouve_par_id($_GET['id_tier']);
		if (!empty($_GET['id_banque'])) {
			$Banque_caisse = Compte::trouve_par_id_banque_and_id_societe($_GET['id_banque'],$id_societe) ; 
		} 
		if (!empty($_GET['id_caisse'])) {
			$Banque_caisse = Caisse::trouve_par_id($_GET['id_caisse']) ; 
		} 
		
	/////////////////////// ajouter piece comptable automatiquement ///////////////////////////////
	
		$Pieces_comptables = new Pieces_comptables();
		$Pieces_comptables->id_societe = $id_societe;
		$Pieces_comptables->id_op_auto =  $id_releve->id;
		$Pieces_comptables->type_op = 11;
		$Pieces_comptables->ref_piece =  $id_releve->ref_releve;
		$Pieces_comptables->libelle =  ' Autres - '.$compte_comptables->libelle;
		$Pieces_comptables->date =  $id_releve->date;
		$Pieces_comptables->date_valid =  date("Y-m-d");
		$Pieces_comptables->journal = $Banque_caisse->journal;
		if ($id_releve->somme_credit > 0){
			$Pieces_comptables->somme_debit = $id_releve->somme_credit;
			$Pieces_comptables->somme_credit = $id_releve->somme_credit;
			}else {
				$Pieces_comptables->somme_debit = $id_releve->somme_debit;
				$Pieces_comptables->somme_credit = $id_releve->somme_debit;
			}
		$Pieces_comptables->random =  $random_number;
		$Pieces_comptables->save();
	
		///////////// ajouter les ecriture comptable de cette piece /////////////////// 
		$Piece = Pieces_comptables::trouve_par_random($random_number);
		
		
	///////////////////////////////////// ecriture autre //////////////////////////////
	
		$Ecriture_comptable = new Ecriture_comptable();
		$Ecriture_comptable->id_compte = $compte_comptables->id;
		if (isset($compte_comptables->id)) {
		$Compte_comp = Compte_comptable::trouve_par_id($compte_comptables->id);
		}
		if (isset($Compte_comp->code)) {
		$Ecriture_comptable->code_comptable = $Compte_comp->code;
		}
		$Ecriture_comptable->id_piece = $Piece->id;
		$Ecriture_comptable->date = $Piece->date;
		$Ecriture_comptable->ref_piece = $Piece->ref_piece;
		$Ecriture_comptable->lib_piece = $Piece->libelle;
		$Ecriture_comptable->journal = $Piece->journal;
		$Ecriture_comptable->id_person = $id_releve->id;
		$Ecriture_comptable->id_societe = $Piece->id_societe;
		$Ecriture_comptable->id_auxiliere = $compte_comptables->code;
		if ($id_releve->somme_credit>0){
			$Ecriture_comptable->credit = $id_releve->somme_credit;
		
		}else{
			$Ecriture_comptable->debit = $id_releve->somme_debit;
		}
		$Ecriture_comptable->save();
			
	
		////////////////////////////// ecriture Banque_caisse //////////////////////
	
		$Ecriture_comptable = new Ecriture_comptable();
	if (!empty($_GET['id_banque'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_achat;
		if (isset($Banque_caisse->comptes_achat)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_achat);
		}
	} 
	if (!empty($_GET['id_caisse'])) {
		$Ecriture_comptable->id_compte = $Banque_caisse->comptes_caisse;
		if (isset($Banque_caisse->comptes_caisse)) {
		$Compte_comp = Compte_comptable::trouve_par_id($Banque_caisse->comptes_caisse);
		}
	}

	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $id_releve->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Banque_caisse->auxiliere_achat;
	if ($id_releve->somme_credit > 0){
		$Ecriture_comptable->debit = $id_releve->somme_credit;
	}else{
		$Ecriture_comptable->credit = $id_releve->somme_debit;
	}
	$Ecriture_comptable->save();
	
	break;
			}
		}
	
		}
		$bd->commitTransactions();
	} catch (Exception $e) {
		// If there's an error, rollback the transaction:
	$bd->rollbackTransactions();
	}
		//////// end erreur//
		}else{
			echo '<script type="text/javascript">
			$(document).ready(function(){
			 setTimeout(function() {
						 toastr.warning("veuillez réessayer plus tard ","Attention !");
			   },300);
			   });
			   </script>';
		}		 
 		
}
if (!empty($_GET['id_banque'])){
$releves = Releve_comptes::trouve_releve_par_id_banque ($_GET['id_banque'],$_GET['id_societe']);
?>
					<table class="table table-striped table-hover" id="">
							<thead>
							<tr>
								
								<th>
									Date
								</th>
								<th>
									Référence
								</th>
								<th>
									Désignation
								</th>
								
								<th>
									Nature Opération
								</th>
								<th>
									Tiers
								</th>
								<th>
									Débit
								</th>
								<th>
								 Crédit
								</th>
								<th>Type</th>
								<th width="9%">
									#
								</th>
							</tr>
							</thead>
							<body>				
								<input type="hidden" name="id_societe" id="id_societe" value="<?php if (isset($_GET['id_societe'])){echo $_GET['id_societe']; } ?>">	   
								<input type="hidden"  name="date_valid" id="date_valid"  value="<?php $thisday=date('Y-m-d'); echo $thisday; ?>" />
								<input type="hidden"  name="id_caisse" id="id_caisse"  value="0" />
								<input type="hidden"  name="id_banque" id="id_banque"  value="<?php if (isset($_GET['id_banque'])){echo $_GET['id_banque'];} ?>" />					
					
							<tr id="releve_form"  >								
								
								<td>
                                   <input type="date" name = "date" id="date"  value="<?php $thisday=date('Y-m-d');echo $thisday; ?>"  class="form-control"   placeholder="date "  >
                                   
                                </td>

								<td>
									<input type="text" name = "ref_releve" id="ref_releve"    class="form-control  "   placeholder="Référence "  >
								</td>
								<td>
									<input type="text" name = "libelle" id="libelle"  class="form-control  "   placeholder="Désignation "  >
								</td>
								
								<td>
									<select class="form-control  "   id="id_nature"  name="id_nature"   placeholder="Choisir dans la liste" >
										<option value=""></option>
											<?php $nature_operations = Nature_operation:: trouve_tous();
											  foreach ($nature_operations as $nature_operation) { ?>
												<option value="<?php if(isset($nature_operation->id)){echo $nature_operation->id; } ?>"><?php if (isset($nature_operation->id)) {echo $nature_operation->libelle; } ?> </option>
											<?php } ?>														   
									</select>
								</td>
								<td class=" id_tier">
									  
								</td>
								<td class="id_debit">
									
								</td>
								<td class="id_credit">
									
								</td>
								<td>
									<?php $Mode_paiement_societes= Mode_paiement_societe::trouve_mode_paiment_autre_especes_par_societe($_GET['id_societe']);?>
									<select placeholder="Choisir mode paiement"   name="mode_paiment" id="mode_paiment"   class=" form-control select2me">
                                        <option value=""></option>
                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                        <?php } ?>
									</select> 
								</td>
								
								<td> <a id="save_releve"  class="btn  green-jungle"  > <i class="fa fa-plus"></i></a> </td>
							</tr>
				
							</body>
							<tbody>
							<?php
								foreach($releves as $releve){
									
								?>
							<tr class="">
								
								<td>
									<?php if (isset($releve->date)) {
									echo fr_date2($releve->date);
									} ?>
								</td>
								<td>
									<?php if (isset($releve->ref_releve)) {
									echo $releve->ref_releve;
									} ?>
								</td>
								<td>
									<?php if (isset($releve->libelle)) {
									echo $releve->libelle;
									} ?>
								</td>
								
								<td>
									<?php if (isset($releve->id_nature)) {
									 $nature_operations = Nature_operation::trouve_par_id($releve->id_nature); 
									 if (isset($nature_operations->libelle)) {echo $nature_operations->libelle;}
									} ?>
								</td>
								<td>
									<?php if (isset($releve->id_tier)) {
										
											switch ($releve->id_nature) {
												case 1:
													$clients = Client::trouve_par_id($releve->id_tier);  
														if (isset($clients->nom)) {echo $clients->nom;}
												break;
												case 2:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 3:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;

												case 4:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 5:
													echo 'Virement Interne';
												break;
												case 6:
												
													echo 'Agios';
												break;
												case 7:
												
													echo 'Intêrets';
												break;
												case 8:
												
													echo 'Impôts';
												break;
												case 9:
												
													echo 'Organismes Sociaux';
												break;
												case 10:
												
													echo 'T.V.A';
												break;
												case 11:
												
													echo 'Caution';
												break;
												case 12:
												
													echo 'Emprunt';
												break;
												case 13:
												
													echo 'Associé';
												break;
												case 14:
													$comptes = Compte_comptable::trouve_par_id($releve->id_tier,$id_societe); 
														if (isset($comptes->libelle)) {echo $comptes->libelle;}
												break;
													
												break;
												case 15:
												
													echo 'Autres';
												break;



											}	
									 
									} ?>
									
								</td>
								<td>
									<?php if (isset($releve->somme_debit)) {

									echo number_format($releve->somme_debit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($releve->somme_credit)) {
									echo number_format($releve->somme_credit , 2, ',', ' ');
									} ?>
								</td>
								<td> <?php if (isset($releve->mode_paiment)) { $Mode_paiement_societes= Mode_paiement_societe::trouve_par_id($releve->mode_paiment); echo $Mode_paiement_societes->type;}?></td>
																
								<td>
									
									<a href="saisie.php?action=edit_releve&id=<?php echo $releve->id; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									<button  id=""  value="<?php if (isset($releve->id)){ echo $releve->id; } ?>" class="btn red btn-xs"> <i class="fa fa-trash"></i> </button>
								</td>
							</tr>

							<?php
								}
							?>
						
							</tbody>
							
							</table>
<?php }else if (!empty($_GET['id_caisse'])){
	$id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
	$id_caisse = htmlspecialchars(intval($_GET['id_caisse'])) ;
	$societes= Societe::trouve_par_id($id_societe);
	$caisse = Caisse::trouve_par_id($id_caisse);
	$releves_caisse = Releve_comptes::trouve_releve_par_id_caiss ($id_caisse,$id_societe);
	?>
<table class="table table-striped table-hover" id="">
							<thead>
							<tr>
								
								<th>
									Date
								</th>
								<th>
									Référence
								</th>
								<th>
									Désignation
								</th>
								
								<th>
									Nature Opération
								</th>
								<th>
									Tiers
								</th>
								<th>
									Débit
								</th>
								<th>
								 Crédit
								</th>
								<th width="9%">
									#
								</th>
							</tr>
							</thead>
							<body>				
								<input type="hidden" name="id_societe" id="id_societe" value="<?php if (isset($societes->id_societe)){ echo $societes->id_societe; } ?>">	   
								<input type="hidden"  name="date_valid" id="date_valid"  value="<?php $thisday=date('Y-m-d'); echo $thisday; ?>" />
								<input type="hidden"  name="id_caisse" id="id_caisse"  value="<?php if (isset($caisse->id_caisse)){echo $caisse->id_caisse;} ?>" />
								<input type="hidden"  name="id_banque" id="id_banque"  value="0" />					
					
								<tr id="releve_form"  >								
								
								<td>
                                   <input type="date" name = "date" id="date"  value="<?php $thisday=date('Y-m-d'); echo $thisday; ?>"  class="form-control"   placeholder="date "  >
                                   
                                </td>

								<td>
									<input type="text" name = "ref_releve" id="ref_releve"    class="form-control  "   placeholder="Référence "  >
								</td>
								<td>
									<input type="text" name = "libelle" id="libelle"  class="form-control  "   placeholder="Désignation "  >
								</td>
								
								<td>
									<select class="form-control  "   id="id_nature"  name="id_nature"   placeholder="Choisir dans la liste" >
										<option value=""></option>
											<?php $nature_operations = Nature_operation:: trouve_tous();
											 foreach ($nature_operations as $nature_operation) { ?>
												<option value="<?php if(isset($nature_operation->id)){echo $nature_operation->id; } ?>"><?php if (isset($nature_operation->id)) {echo $nature_operation->libelle; } ?> </option>
											<?php } ?>														   
									</select>
								</td>
								<td class=" id_tier">
									  
								</td>
								<td class="id_debit">
									
								</td>
								<td class="id_credit">
									
								</td>
								<td>
									<?php $Mode_paiement_societes= Mode_paiement_societe::trouve_mode_paiment_especes_par_societe($_GET['id_societe']);?>
									<select placeholder="Choisir mode paiement"   name="mode_paiment" id="mode_paiment"   class=" form-control select2me">
                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                        <?php } ?>
									</select> 
								</td>
								
								<td> <a id="save_releve"  class="btn  green-jungle"  > <i class="fa fa-plus"></i></a> </td>
								</tr>
							</body>
							<tbody>
							<?php
								foreach($releves_caisse as $releve){
									
								?>
							<tr class="item-row">
								
								<td>
									<?php if (isset($releve->date)) {
									echo fr_date2($releve->date);
									} ?>
								</td>
								<td>
									<?php if (isset($releve->ref_releve)) {
									echo $releve->ref_releve;
									} ?>
								</td>
								<td>
									<?php if (isset($releve->libelle)) {
									echo $releve->libelle;
									} ?>
								</td>
								
								<td>
									<?php if (isset($releve->id_nature)) {
									 $nature_operations = Nature_operation::trouve_par_id($releve->id_nature); 
									 if (isset($nature_operations->libelle)) {echo $nature_operations->libelle;}
									} ?>
								</td>
								<td>
									<?php if (isset($releve->id_tier)) {
										
											switch ($releve->id_nature) {
												case 1:
													$clients = Client::trouve_par_id($releve->id_tier); 
														if (isset($clients->nom)) {echo $clients->nom;}
												break;
												case 2:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 3:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;

												case 4:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 5:
												
													echo 'Virement Interne';
												break;
												case 6:
												
													echo 'Agios';
												break;
												case 7:
												
													echo 'Intêrets';
												break;
												case 8:
												
													echo 'Impôts';
												break;
												case 9:
												
													echo 'Organismes Sociaux';
												break;
												case 10:
												
													echo 'T.V.A';
												break;
												case 11:
												
													echo 'Caution';
												break;
												case 12:
												
													echo 'Emprunt';
												break;
												case 13:
												
													echo 'Associé';
												break;
												case 14:
												
													echo 'Paiement Fournisseurs immobilisation';
												break;
												case 15:
												
													echo 'Autres';
												break;



											}	
									 
									} ?>
									
								</td>
								<td>
									<?php if (isset($releve->somme_debit)) {

									echo number_format($releve->somme_debit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($releve->somme_credit)) {
									echo number_format($releve->somme_credit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($releve->mode_paiment)) { $Mode_paiement_societes= Mode_paiement_societe::trouve_par_id($releve->mode_paiment); echo $Mode_paiement_societes->type;}?>
								</td>
								
								<td>
									
									<a href="saisie.php?action=edit_releve&id=<?php echo $releve->id; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									<button  id=""  value="<?php if (isset($releve->id)){ echo $releve->id; } ?>" class="btn red btn-xs"> <i class="fa fa-trash"></i> </button>
								</td>
							</tr>

							<?php
								}
							?>
						
						</tbody>
							
					</table>
<?php }?>