<?php
require_once("../includes/initialiser.php");

?>  

<?php	if(isset($_POST['id_client']) ){
	$errors = array();
	
		// new object client
	if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;}
	// new object admin client
	if (!isset($_POST['credit'])||empty($_POST['credit'])){
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
    $random_number = rand();
	$versement = new Solde_client();
	$versement->credit = htmlentities(trim($_POST['credit']));
	$versement->solde = htmlentities(trim($_POST['credit']));
	$versement->reference = htmlentities(trim($_POST['reference']));
	$versement->mode_paiment = htmlentities(trim($_POST['mode_paiment']));
if (isset($_POST['banque'])) {
	$versement->banque = htmlentities(trim($_POST['banque']));
}
if (isset($_POST['caisse'])) {
	$versement->caisse = htmlentities(trim($_POST['caisse']));
}
	$versement->date = htmlentities(trim($_POST['date']));
	$versement->id_client = htmlentities(trim($_POST['id_client']));
	$versement->id_societe = htmlentities(trim($_POST['id_societe']));
	$versement->id_person = htmlentities(trim($_POST['id_user']));
	$versement->random = $random_number;
	$Client = Client::trouve_par_id($versement->id_client);

	if (empty($errors)){
		if  ($versement->existe()) { ?>
				<script type="text/javascript">
							$(document).ready(function(){
								toastr.error("Référence existe déja  !","Attens");
								});
							$(document).ready(function(){
							$('#versement_form input[type="text"]').val('');
							$('#versement_form input[type="number"]').val('');
							});
							</script>

<?php		}
else if ($versement->save()) { ?>
			
			<script type="text/javascript">
			$(document).ready(function(){
                  toastr.success("Versement enregistrer  avec succes  !","Très Bien");
				  });
			$(document).ready(function(){
			$('#versement_form input[type="text"]').val('');
			$('#versement_form input[type="number"]').val('');
			});
            </script>

<?php 
$Solde_client=Solde_client::trouve_par_random($random_number);
$nav_societe = Societe::trouve_par_id($versement->id_societe);
if (isset($_POST['banque'])) {
	$Banque_caisse = Compte::trouve_par_id($versement->banque) ; 
} else if ($_POST['caisse']) {
	$Banque_caisse = Caisse::trouve_par_id($versement->caisse) ; 
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

		}
 		
		
		}
 		 
 		
}

?>