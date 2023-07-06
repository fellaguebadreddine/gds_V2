<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Accounts::trouve_par_id($session->id_utilisateur);
	if (empty($user)) {
	$user = Client::trouve_par_id($session->id_utilisateur);
	}
	$accestype = array('administrateur','utilisateur');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 
}
?>

<?php 
$action="";
if (isset($_GET['action']) && $_GET['action'] =='update_achat' ) {
$action = 'update_achat';
}
if (isset($_GET['action']) && $_GET['action'] =='update_vente' ) {
$action = 'update_vente';
}
if (isset($_GET['action']) && $_GET['action'] =='fact_vente' ) {
$action = 'fact_vente';
}
if ($action == 'update_achat') {

	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
     $id = intval($_GET['id']);
     $Fact = Facture_achat::trouve_par_id($id);
     $date = date_parse($Fact->date_fac);
 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
 	$id = intval($_POST['id']);
 	$Fact = Facture_achat::trouve_par_id($id);
 	$date = date_parse($Fact->date_fac);
	 
 }
////////////////////////////// remove old Quantité of achat from Articles and delete achat from table ACHAT ///////////////////////
				$table_achats = Achat::trouve_achat_par_facture($id);
				foreach($table_achats as $table_achat){ 
					$lot = lot_prod::trouve_lot_par_id_achat($table_achat->id);
					if (isset($lot->qte) ) {
					if ($table_achat->Quantite != $lot->qte) {
						$errors[]= '  Lot deja consommé !';
					}
					}
			 	$Article = Produit::trouve_par_id($table_achat->id_prod);
				if (empty($errors)){
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock - $table_achat->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();
					if (isset($lot->id) ) {
					$lot->supprime();
					}
					$table_achat->supprime();
				}else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 
	}
	unset($errors);
			 }
/////////////////////////////// add new Quantité of new achat into articles and save new achat to table ACHAT ///////////////

			$table_update_achats = Update_achat::trouve_achat_notvalide_par_facture($id);
			$table_update_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($id,1);
			$Reglement = Update_reglement_fournisseur::trouve_somme_and_timbre_vide_par_admin($id,1);
			if (!empty($table_update_achats)) {
					$last_fournisseur = Update_achat::trouve_last_fournisseur_par_id_facture($id);
					
					}
				foreach($table_update_achats as $table_update_achat){ 

					$lot = lot_prod::trouve_lot_par_id_achat($table_update_achat->id_achat);
					if (isset($lot->qte) ) {
					if ($table_update_achat->Quantite != $lot->qte) {
						$errors[]= '  Lot deja consommé !';
						$table_update_achat->etat = 1;
						$table_update_achat->modifier();
					}
					}


				$Article = Produit::trouve_par_id($table_update_achat->id_prod);
				if (empty($errors)){
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock + $table_update_achat->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->prix_achat = $table_update_achat->Prix;
					if ($Article->pourcentage_prix_vente > 0) {
					$Article->prix_vente = $table_update_achat->Prix +($table_update_achat->Prix * $Article->pourcentage_prix_vente) ;
					}
					$Article->modifier();
		///////////////// mise a jour de table update_achat etat = 1 ////////////
					$table_update_achat->etat = 1;
					$table_update_achat->modifier();
		////////////// insert into Table ACHAT updated rows ////////////////////

	$Achat = new Achat();
	$Achat->id_facture = $table_update_achat->id_facture;
	$Achat->id_fournisseur = htmlentities(trim($_POST['fournisseur']));
	$Achat->id_prod = $table_update_achat->id_prod;
	$Achat->id_famille = $table_update_achat->id_famille;
	$Achat->Prix = $table_update_achat->Prix;
	$Achat->Ttva = $table_update_achat->Ttva;
	$Achat->Quantite = $table_update_achat->Quantite;
	$Achat->id_person = $table_update_achat->id_person;
	$Achat->id_societe = $table_update_achat->id_societe;
	$Achat->date_fact = htmlentities(trim($_POST['date_facture']));
	$Achat->Reference_fact = htmlentities(trim($_POST['Reference']));
	$Achat->Ht = $table_update_achat->Ht ;
	$Achat->id_tva = $table_update_achat->id_tva ;
	$Achat->Tva = $table_update_achat->Tva ;
	$Achat->total = $table_update_achat->total ;
	$Achat->Designation = $table_update_achat->Designation;
	$Achat->Code = $table_update_achat->Code;
	$Achat->save();


			////// creat new lot /////////////////: 

	$last_achat = Achat::trouve_last_fournisseur_par_id_facture($id);
						$Lot_prod = new Lot_prod();
						$Lot_prod->code_lot = rand();
						$Lot_prod->id_societe = $table_update_achat->id_societe;
						$Lot_prod->id_prod = $Article->id_pro;
						$Lot_prod->id_facture = $Fact->id_facture;
						if (isset($last_achat->id)) {
						$Lot_prod->id_achat = $last_achat->id;
						}
						$Lot_prod->qte_initial = $table_update_achat->Quantite;
						$Lot_prod->qte = $table_update_achat->Quantite;
						$Lot_prod->prix_achat = $table_update_achat->Prix;
						$Lot_prod->prix_vente = $Article->prix_vente;
						$Lot_prod->date_lot = htmlentities(trim($_POST['date_facture']));
						$Lot_prod->type_achat = 1;
						$Lot_prod->save();	

			///////////////////////		mise a jour de la formule if existe id prod in formule and if existe formule ////////////////////	

						if ($Article->matiere_premiere == 1) {
						$Detail_formules = Detail_formule::trouve_formule_par_id_Matiere_Premiere($Article->id_pro);
						if (!empty($Detail_formules)) {
						foreach ($Detail_formules as $Detail_formule) {
						$lot_prod = Lot_prod::trouve_first_lot($Article->id_pro);	
						if (isset($lot_prod->id)) {
					 			$Detail_formule->id_lot = $lot_prod->id;
					 			}
					 	$Detail_formule->save();
							
						}
						
						}
						}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

						

					}else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 
	}
	unset($errors);

			}
		if (empty($errors)){
////////////////// recalculer les Sommes et enregistrer dans la facture ////////////////////////////
				$Somme_ht = Achat::somme_ht_par_facture($id);
				$Somme_tva = Achat::somme_tva_par_facture($id);
				$Somme_ttc = Achat::somme_ttc_par_facture($id);
				$Fact->Num_facture = htmlentities(trim($_POST['Reference']));
				$Fact->date_fac = htmlentities(trim($_POST['date_facture']));
				if (!empty($_POST['facture_scan'])) {
				$Fact->facture_scan = htmlentities(trim($_POST['facture_scan']));
				}
				$Remise_facture = htmlentities(trim($_POST['Remise']));
				if ($Remise_facture > 0) {
				$Fact->somme_ttc =  $Somme_ttc->somme_ttc;
				}else{
				$Fact->somme_ttc =$Reglement->somme;		
				}
				$Fact->timbre =$Reglement->timbre;
				$Fact->somme_ht =  $Somme_ht->somme_ht;
				$Fact->somme_tva =  $Somme_tva->somme_tva;
				$Fact->id_fournisseur = htmlentities(trim($_POST['fournisseur']));
				$Fact->modifier();


			/////////// delete old table Reglement ////////////////
			$table_Reglements = Reglement_fournisseur::trouve_Reglement_par_facture($Fact->id_facture,1);
			 
			 	 foreach($table_Reglements as $table_Reglement){
			 	 	if ($table_Reglement->id_solde != 0) {
			 	$Solde_fournisseur = Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
			 	$Solde  =  $Solde_fournisseur->solde + ($table_Reglement->somme + $table_Reglement->timbre);
			 	$Solde_fournisseur->solde = $Solde ;
			 	$Solde_fournisseur->etat = 0;	
			 	$Solde_fournisseur->modifier();
			 	 }
			 	$table_Reglement->supprime(); 
			 
			}

			 /////////// add table Reglement ////////////////


	foreach($table_update_Reglements as $table_update_Reglement){
	$Reglement_fournisseur = new Reglement_fournisseur();
	$Reglement_fournisseur->id_fournisseur = $table_update_Reglement->id_fournisseur;
	$Reglement_fournisseur->id_facture = $table_update_Reglement->id_facture;
	$Reglement_fournisseur->id_societe = $table_update_Reglement->id_societe;
	$Reglement_fournisseur->id_solde = $table_update_Reglement->id_solde;
	$Reglement_fournisseur->date = $table_update_Reglement->date ;
	$Reglement_fournisseur->somme = $table_update_Reglement->somme;
	$Reglement_fournisseur->id_person = $table_update_Reglement->id_person;
	$Reglement_fournisseur->mode_paiment = $table_update_Reglement->mode_paiment;
    $Reglement_fournisseur->timbre = $table_update_Reglement->timbre; 
    $Reglement_fournisseur->type_fact = 1;
    $Reglement_fournisseur->save();

    $table_update_Reglement->etat = 1;
	$table_update_Reglement->modifier();
			  }


			   /////////// Valid table Reglement ////////////////
 $table_Reglements = Reglement_fournisseur::trouve_Reglement_par_facture($id,1);

			 foreach($table_Reglements as $table_Reglement){
			 	$table_Reglement->id_facture = $Fact->id_facture;
			 	$table_Reglement->modifier();
			 	if ($table_Reglement->id_solde != 0) {
			 	$Solde_fournisseur = Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
			 	$Reste =  $Solde_fournisseur->solde - ($table_Reglement->somme + $table_Reglement->timbre);
			 	$Solde_fournisseur->solde = $Reste;
			 	if ($Reste == 0 ) {
			 	$Solde_fournisseur->etat = 1;	
			 	}
			 	$Solde_fournisseur->modifier();
			 	} 
			  }

			 


/////////////////////// Modifier piece comptable automatiquement ///////////////////////////////

	$Piece = Pieces_comptables::trouve_par_operation_and_type($Fact->id_facture,1);
	$Fournisseur = Fournisseur::trouve_par_id($Fact->id_fournisseur);


	$Piece->libelle =  'FACTURE ACHAT - '.$Fournisseur->nom;
	$Piece->date =  $Fact->date_fac;
	$Piece->somme_debit = $Fact->somme_ttc;
	$Piece->somme_credit = $Fact->somme_ttc;
	$Piece->facture_scan = $Fact->facture_scan;
	$Piece->modifier();

////////////////// delete old ecriture_comptable par id_piece /////////////////////////////

	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece->id);

///////////// add ecriture comptable of this piece /////////////////// 
	$Ht = Famille::calcule_Ht_par_famille_and_facture_achat($Fact->id_facture,$Fact->id_societe);
	$TVA = Famille::calcule_TVA_par_famille_and_facture_achat($Fact->id_facture,$Fact->id_societe);
	$timbres = Famille::calcule_timbre_par_famille_and_facture_achat($Fact->id_facture,$Fact->id_societe);
	$somme_ttc = Famille::calcule_somme_ttc_par_famille_and_facture_achat($Fact->id_facture,$Fact->id_societe);

	foreach ($Ht as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_achat);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_achat;
	$Ecriture_comptable->debit = $Ht->Ht;
	$Ecriture_comptable->save();
				}
	foreach ($TVA as $TVA) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $TVA->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($TVA->comptes_achat);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $TVA->auxiliere_achat;
	$Ecriture_comptable->debit = $TVA->total_tva;
	$Ecriture_comptable->save();
				}
	foreach ($timbres as $timbre) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $timbre->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($timbre->comptes_achat);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $timbre->auxiliere_achat;
	$Ecriture_comptable->debit = $timbre->timbre;
	$Ecriture_comptable->save();
				}
	foreach ($somme_ttc as $somme_ttc) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $somme_ttc->Compte;
	$Compte_comp = Compte_comptable::trouve_par_id($somme_ttc->Compte);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $somme_ttc->auxiliere_achat;
	$Ecriture_comptable->credit = $somme_ttc->somme_ttc;
	$Ecriture_comptable->save();
				}

/////////////////////// modifier piece comptable Entrée stock automatiquement ///////////////////////////////

	$Piece_Entree = Pieces_comptables::trouve_par_operation_and_type($Fact->id_facture,6);


	$Piece_Entree->libelle =  'Entrée stock - '.$Fournisseur->nom;
	$Piece_Entree->date =  $Fact->date_fac;
	$Piece_Entree->somme_debit = $Fact->somme_ht;
	$Piece_Entree->somme_credit = $Fact->somme_ht;
	$Piece_Entree->facture_scan = $Fact->facture_scan;
	$Piece_Entree->modifier();

////////////////// delete old ecriture_comptable par id_piece /////////////////////////////

	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece_Entree->id);

///////////// ajouter les ecriture comptable de cette piece /////////////////// 

	$Ht_Entrees = Famille::calcule_Ht_par_famille_and_facture_achat($Fact->id_facture,$Fact->id_societe);
	
	foreach ($Ht_Entrees as $Ht_Entree) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht_Entree->comptes_stock;
		if(isset($Ht_Entree->comptes_stock)){
	$Compte_comp = Compte_comptable::trouve_par_id($Ht_Entree->comptes_stock);	
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece_Entree->id;
	$Ecriture_comptable->date = $Piece_Entree->date;
	$Ecriture_comptable->ref_piece = $Piece_Entree->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece_Entree->libelle;
	$Ecriture_comptable->journal = $Piece_Entree->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece_Entree->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht_Entree->auxiliere_stock;
	$Ecriture_comptable->debit = $Ht_Entree->Ht;
	$Ecriture_comptable->save();
				}
				
		foreach ($Ht_Entrees as $Ht_Entree) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht_Entree->comptes_achat;
	if(isset($Ht_Entree->comptes_achat)){
	$Compte_comp = Compte_comptable::trouve_par_id($Ht_Entree->comptes_achat);	
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece_Entree->id;
	$Ecriture_comptable->date = $Piece_Entree->date;
	$Ecriture_comptable->ref_piece = $Piece_Entree->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece_Entree->libelle;
	$Ecriture_comptable->journal = $Piece_Entree->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece_Entree->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht_Entree->auxiliere_achat;
	$Ecriture_comptable->credit = $Ht_Entree->Ht;
	$Ecriture_comptable->save();
				}

			readresser_a("invoice_achat.php?id=".$id."&action=update");
		}

} else if ($action == 'update_vente') {

	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
     $id = intval($_GET['id']);
     $Fact = Facture_vente::trouve_par_id($id);
     $date = date_parse($Fact->date_fac);
 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
 	$id = intval($_POST['id']);
 	$Fact = Facture_vente::trouve_par_id($id);
 	$date = date_parse($Fact->date_fac);
 }

////////////////////////////// remove old Quantité of vente from Articles and delete vente from table VENTE ///////////////////////
				$table_vantes = Vente::trouve_vente_par_facture($id);
				 
				foreach($table_vantes as $table_vante){ 
			 	$Article = Produit::trouve_par_id($table_vante->id_prod);
			 	$Lot_prod = Lot_prod::trouve_par_id($table_vante->id_lot);
				if (empty($errors)){
					if (isset($Lot_prod->qte)) {
	///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock_Lot = $Lot_prod->qte + $table_vante->Quantite;
					$Lot_prod->qte = $Quantite_stock_Lot;
					$Lot_prod->modifier();
					

		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock + $table_vante->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();
					
				}
				$table_vante->supprime();
				}else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 
	}
	unset($errors);
			 }

/////////////////////////////// add new Quantité of new achat into articles and save new achat to table ACHAT ///////////////
			$table_update_vantes = Update_vente::trouve_vente_notvalide_par_facture($id);
			$table_update_Reglements = Update_reglement_client::trouve_Reglement_vide_par_admin($id);
			$Reglement = Update_reglement_client::trouve_somme_and_timbre_vide_par_admin($id);
			if (!empty($table_update_vantes)) {
					$last_client = Update_vente::trouve_last_client_par_id_facture($id);
					
					}
			foreach($table_update_vantes as $table_update_vante){ 

			 	$Articles = Produit::trouve_par_id($table_update_vante->id_prod);
			 	$Lot_prod = Lot_prod::trouve_par_id($table_update_vante->id_lot);

			 	// echo $Article->stockable.'<br>';

			 		if (( $table_update_vante->Quantite > $Lot_prod->qte) && ($Articles->stockable == 1))
					{
						$errors[] = 'Quantité  Entrer Supérieur à quantité de stock !! ';
						$errors[] = 'Quantité disponible de '.$Articles->Designation .'  est : '.$Article->stock.' !! ';
					}
				}
				foreach($table_update_vantes as $table_update_vante){ 
				$Article = Produit::trouve_par_id($table_update_vante->id_prod);
				$Lot_prod = Lot_prod::trouve_par_id($table_update_vante->id_lot);

				if (empty($errors)){

					if ($Lot_prod->qte ) {
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock - $table_update_vante->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();

					
						///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock_Lot = $Lot_prod->qte - $table_update_vante->Quantite;
					$Lot_prod->qte = $Quantite_stock_Lot;
					$Lot_prod->modifier();
					}

		///////////////// mise a jour de table update_achat etat = 1 ////////////
					$table_update_vante->etat = 1;
					$table_update_vante->modifier();
		////////////// insert into Table ACHAT updated rows ////////////////////

	$Vente = new Vente();
	$Vente->id_facture = $table_update_vante->id_facture;
	$Vente->id_client =  htmlentities(trim($_POST['client']));
	$Vente->id_prod = $table_update_vante->id_prod;
	$Vente->id_lot = $table_update_vante->id_lot;
	if (!empty($Vente->id_lot)) {
	$Lot_prod = Lot_prod::trouve_par_id($Vente->id_lot);

	}
	$Vente->id_famille = $table_update_vante->id_famille;
	$Vente->Prix = $table_update_vante->Prix;
	$Vente->Remise = $table_update_vante->Remise;
	$Vente->Ttva = $table_update_vante->Ttva;
	$Vente->id_tva = $table_update_vante->id_tva ;
	$Vente->Quantite = $table_update_vante->Quantite;
	$Vente->id_person = $table_update_vante->id_person;
	$Vente->id_societe = $table_update_vante->id_societe;
	$Vente->date_fact = htmlentities(trim($_POST['date_fact']));
	$Vente->Ht_achat = $table_update_vante->Ht_achat;
	$Vente->Ht = $table_update_vante->Ht ;
	$Vente->Tva = $table_update_vante->Tva ;
	$Vente->total = $table_update_vante->total ;
	$Vente->Designation = $table_update_vante->Designation;
	$Vente->Code = $table_update_vante->Code;
	$Vente->save();
					}else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 
	}
	unset($errors);

			}
		if (empty($errors)){
////////////////// recalculer les Sommes et enregistrer dans la facture ////////////////////////////
				$Somme_ht = Vente::somme_ht_par_facture($id);
				$Somme_tva = Vente::somme_tva_par_facture($id);
				$Somme_ttc = Vente::somme_ttc_par_facture($id);
				$Somme_Ht_achat = Vente::somme_Ht_achat_par_facture($id);

				$Fact->id_client = htmlentities(trim($_POST['client']));
				$Fact->date_fac = htmlentities(trim($_POST['date_fact']));
				$Fact->somme_Ht_achat =  $Somme_Ht_achat->somme_ht;
					if(!empty($_POST['facture_scan'])){
				$Fact->facture_scan = htmlentities(trim($_POST['facture_scan']));
				}
				$Fact->Remise = htmlentities(trim($_POST['Remise_fact']));
					if ($Fact->Remise >0 ) {
			    $Fact->somme_ht =  htmlentities(trim($_POST['ht_fact']));
			    $Fact->somme_tva =  htmlentities(trim($_POST['tva_fact']));
				} else{
			    $Fact->somme_ht =   $Somme_ht->somme_ht;
			    $Fact->somme_tva =  $Somme_tva->somme_tva;	
				}

			    $Remise_facture = htmlentities(trim($_POST['Remise']));
			    if ($Remise_facture > 0) {
				if ($Fact->Remise >0 ) {
			    $Fact->somme_ttc =  htmlentities(trim($_POST['ttc_fact']));
			    }else{
			    $Fact->somme_ttc =  $Somme_ttc->somme_ttc;	
			    }
			    }else{
			    $Fact->somme_ttc =$Reglement->somme;      
			    }
			    $Fact->timbre =$Reglement->timbre;
				$Fact->save();

//print_r($Fact);


			/////////// delete old table Reglement ////////////////
			$table_Reglements = Reglement_client::trouve_Reglement_par_facture($Fact->id_facture);
			 
			 	 foreach($table_Reglements as $table_Reglement){
			 	$Solde_client = Solde_client::trouve_par_id($table_Reglement->id_solde);
			 	if (isset($Solde_client->solde)) {
			 	$Solde  =  $Solde_client->solde + ($table_Reglement->somme + $table_Reglement->timbre);
			 	$Solde_client->solde = $Solde ;
			 	$Solde_client->etat = 0;	
			 	$Solde_client->modifier();
			 	} 
			 	$table_Reglement->supprime(); 
			  }

			 /////////// add table Reglement ////////////////


	foreach($table_update_Reglements as $table_update_Reglement){
	$Reglement_client = new Reglement_client();
	$Reglement_client->id_client = $table_update_Reglement->id_client;
	$Reglement_client->id_facture = $table_update_Reglement->id_facture;
	$Reglement_client->id_societe = $table_update_Reglement->id_societe;
	$Reglement_client->id_solde = $table_update_Reglement->id_solde;
	$Reglement_client->date = $table_update_Reglement->date ;
	$Reglement_client->somme = $table_update_Reglement->somme;
	$Reglement_client->id_person = $table_update_Reglement->id_person;
	$Reglement_client->mode_paiment = $table_update_Reglement->mode_paiment;
    $Reglement_client->timbre = $table_update_Reglement->timbre; 
    $Reglement_client->save();

    $table_update_Reglement->etat = 1;
	$table_update_Reglement->modifier();
			  }


			   /////////// Valid table Reglement ////////////////
 			$table_Reglements = Reglement_client::trouve_Reglement_par_facture($id);

			 foreach($table_Reglements as $table_Reglement){
			 	$table_Reglement->id_facture = $Fact->id_facture;
			 	$table_Reglement->modifier();
			 	if ($table_Reglement->id_solde != 0) {
			 	$Solde_client = Solde_client::trouve_par_id($table_Reglement->id_solde);
			 	$Reste =  $Solde_client->solde - ($table_Reglement->somme + $table_Reglement->timbre);
			 	$Solde_client->solde = $Reste;
			 	if ($Reste == 0 ) {
			 	$Solde_client->etat = 1;	
			 	}
			 	$Solde_client->modifier();
			 	} 
			 	
			 	
			 	

			  }


/////////////////////// Modifier piece comptable automatiquement ///////////////////////////////

	$Piece = Pieces_comptables::trouve_par_operation_and_type($Fact->id_facture,2);
	$Client = Client::trouve_par_id($Fact->id_client);


	$Piece->libelle =  'FACTURE VENTE - '.$Client->nom;
	$Piece->date =  $Fact->date_fac;
	$Piece->somme_debit = $Fact->somme_ttc;
	$Piece->somme_credit = $Fact->somme_ttc;
	$Piece->facture_scan = $Fact->facture_scan;
	$Piece->modifier();

////////////////// delete old ecriture_comptable par id_piece /////////////////////////////

	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece->id);

///////////// add ecriture comptable of this piece /////////////////// 
	$Ht = Famille::calcule_Ht_par_famille_and_facture_vente($Fact->id_facture,$Fact->id_societe);
	$TVA = Famille::calcule_TVA_par_famille_and_facture_vente($Fact->id_facture,$Fact->id_societe);
	$timbres = Famille::calcule_timbre_par_famille_and_facture_vente($Fact->id_facture,$Fact->id_societe);
	$somme_ttc = Famille::calcule_somme_ttc_par_famille_and_facture_vente($Fact->id_facture,$Fact->id_societe);

	foreach ($somme_ttc as $somme_ttc) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $somme_ttc->Compte;
	$Compte_comp = Compte_comptable::trouve_par_id($somme_ttc->Compte);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $somme_ttc->auxiliere_achat;
	$Ecriture_comptable->debit= $somme_ttc->somme_ttc;
	$Ecriture_comptable->save();
				}
	foreach ($Ht as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_vente;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_vente);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_vente;
	$Ecriture_comptable->credit = $Ht->Ht;
	$Ecriture_comptable->save();
				}
	foreach ($TVA as $TVA) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $TVA->comptes_vente;
	$Compte_comp = Compte_comptable::trouve_par_id($TVA->comptes_vente);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $TVA->auxiliere_vente;
	$Ecriture_comptable->credit = $TVA->total_tva;
	$Ecriture_comptable->save();
				}
	foreach ($timbres as $timbre) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $timbre->comptes_vente;
	$Compte_comp = Compte_comptable::trouve_par_id($timbre->comptes_vente);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $timbre->auxiliere_vente;
	$Ecriture_comptable->credit = $timbre->timbre;
	$Ecriture_comptable->save();
				}
////////////////////////////////////// 
	$Pieces_comptables_Sortie = Pieces_comptables::trouve_par_operation_and_type($Fact->id_facture,7);

	$Pieces_comptables_Sortie->libelle =  ' SORTIE STOCK  - '.$Client->nom;
	$Pieces_comptables_Sortie->date =  $Fact->date_fac;
	$Pieces_comptables_Sortie->somme_debit = $Fact->somme_Ht_achat;
	$Pieces_comptables_Sortie->somme_credit = $Fact->somme_Ht_achat;
	$Pieces_comptables_Sortie->facture_scan = $Fact->facture_scan;
	$Pieces_comptables_Sortie->modifier();

////////////////// delete old ecriture_comptable par id_piece /////////////////////////////

	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Pieces_comptables_Sortie->id);
///////////// ajouter les ecriture comptable de cette piece /////////////////// 


	$Piece_Sortie = Pieces_comptables::trouve_par_operation_and_type($Fact->id_facture,7);

	$Hts = Famille::calcule_Ht_par_famille_and_facture_vente($Fact->id_facture,$Fact->id_societe);


	foreach ($Hts as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_consommation;
	if (isset($Ht->comptes_consommation)) {
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_consommation);
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece_Sortie->id;
	$Ecriture_comptable->date = $Piece_Sortie->date;
	$Ecriture_comptable->ref_piece = $Piece_Sortie->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece_Sortie->libelle;
	$Ecriture_comptable->journal = $Piece_Sortie->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece_Sortie->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_consommation;
	$Ecriture_comptable->debit = $Ht->Ht_achat;
	$Ecriture_comptable->save();
				}

	foreach ($Hts as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_stock;
	if (isset($Ht->comptes_stock)) {
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_stock);
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece_Sortie->id;
	$Ecriture_comptable->date = $Piece_Sortie->date;
	$Ecriture_comptable->ref_piece = $Piece_Sortie->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece_Sortie->libelle;
	$Ecriture_comptable->journal = $Piece_Sortie->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece_Sortie->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_vente;
	$Ecriture_comptable->credit = $Ht->Ht_achat;
	$Ecriture_comptable->save();
				}

			readresser_a("invoice.php?id=".$id."&action=update");
		}

}

if ($action == 'fact_vente') {
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);
	$Somme_ht = Vente::somme_ht($user->id,$nav_societe->id_societe);
	$Somme_Ht_achat = Vente::somme_Ht_achat($user->id,$nav_societe->id_societe);
	$Somme_tva = Vente::somme_tva($user->id,$nav_societe->id_societe);
	$Somme_ttc = Vente::somme_ttc($user->id,$nav_societe->id_societe);
	$table_vantes = Vente::trouve_vente_vide_par_admin($user->id,$nav_societe->id_societe);
	$table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin($user->id,$nav_societe->id_societe);
    $Reglement = Reglement_client::trouve_somme_and_timbre_vide_par_admin($user->id,$nav_societe->id_societe);
if (!empty($table_vantes)) {
	$Last_client = Vente::trouve_last_client_par_id_admin($user->id,$nav_societe->id_societe);
	$Client = Client::trouve_par_id(htmlentities(trim($_POST['client'])));
	$n_fact = count( $factures = Facture_vente::trouve_last_par_societe($nav_societe->id_societe))  ;
		if ( $n_fact == 0 ){ $n_facture = 1; }
		else if ( $n_fact > 0 ){	if (!empty($factures->N_facture)){ $n_facture = $factures->N_facture + 1 ;}
												else  { $n_facture = 1; }	
				}
	$errors = array();
	$random_number = rand();
	$facture = new Facture_vente();
	$facture->id_client = htmlentities(trim($_POST['client'])); 
	$facture->N_facture = $n_facture;
	$facture->id_societe = $nav_societe->id_societe;
	$facture->date_fac = htmlentities(trim($_POST['date_fact'])); 
	$facture->somme_Ht_achat =  $Somme_Ht_achat->somme_ht;
	$facture->date_valid = date("Y-m-d");
	$facture->random =  $random_number;
	if(!empty($_POST['facture_scan'])){
	$facture->facture_scan = htmlentities(trim($_POST['facture_scan']));
	}

	$facture->Remise = htmlentities(trim($_POST['Remise_fact']));
	if ($facture->Remise >0 ) {
    $facture->somme_ht =  htmlentities(trim($_POST['ht_fact']));
    $facture->somme_tva =  htmlentities(trim($_POST['tva_fact']));
	} else{
    $facture->somme_ht =   $Somme_ht->somme_ht;
    $facture->somme_tva =  $Somme_tva->somme_tva;	
	}

    $Remise_facture = htmlentities(trim($_POST['Remise']));
    if ($Remise_facture > 0) {
	if ($facture->Remise >0 ) {
    $facture->somme_ttc =  htmlentities(trim($_POST['ttc_fact']));
    }else{
    $facture->somme_ttc =  $Somme_ttc->somme_ttc;	
    }
    }else{
    $facture->somme_ttc =$Reglement->somme;      
    }
    $facture->timbre =$Reglement->timbre;
    $facture->etat =1;

	//////////////////////////////////////////////////



				 foreach($table_vantes as $table_vante){ 

			 	$Article = Produit::trouve_par_id($table_vante->id_prod);
			 	$Lot_prod = Lot_prod::trouve_par_id($table_vante->id_lot);


			 	if (( $table_vante->Quantite > $Lot_prod->qte) && ($Article->stockable == 1))
					{
						$errors[] = 'Quantité  Entrer Supérieur à quantité de stock !! ';
						$errors[] = 'Quantité disponible de '.$Article->Designation .'  est : '.$Lot_prod->qte.' !! ';
					}
				}

	if (empty($errors)){
   		if ($facture->existe()) {
			$msg_error = '<p style= "font-size: 20px; "> Cette  Facture ' . $facture->N_facture . ' existe déja  !!</p><br />';
			
		}else{
			$facture->save(); ?>
 			<script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
            toastr.success(" Facture créée avec succès","Très bien !");
        },300);


 			});

			</script>
		
	<?php  if (!empty($_POST['facture_scan'])){
	$upload = Upload:: trouve_par_id($_POST['facture_scan']);
	$upload->status = 1;
	$upload->save();
	}
			$Fact = Facture_vente::trouve_par_random($random_number);
			$date = date_parse($Fact->date_fac);
			 foreach($table_vantes as $table_vante){ 

			 	$Article = Produit::trouve_par_id($table_vante->id_prod);
			 	$Lot_prod = Lot_prod::trouve_par_id($table_vante->id_lot);

				if (empty($errors)){

		/////////////// mise a jour table vente avec le nv id_facture ////////////////////
					$table_vante->id_facture = $Fact->id_facture;
					$table_vante->modifier();

////////////////////// insret into table histo_vente /////////////////////////
	  $SQL2 = $bd->requete("INSERT INTO `histo_vente` (`id`, `lib_prod`, `code_prod`, `id_prod`, `id_facture`, `Quantite_vente`, `Quantite_stock`) VALUES (NULL, '$table_vante->Designation', '$table_vante->Code', '$table_vante->id_prod', '$table_vante->id_facture', '$table_vante->Quantite', '$Article->stock');");

if ($Article->stockable == 1 ) {
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock - $table_vante->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();


	///////////////// mise a jour de QTE stock produit ///////////////
					
						// code...
					
					$Quantite_stock_Lot = $Lot_prod->qte - $table_vante->Quantite;
					$Lot_prod->qte = $Quantite_stock_Lot;
					$Lot_prod->modifier();
					}
				}else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 

	}
	unset($errors);
			 }
			              /////////// Valid table Reglement ////////////////

             foreach($table_Reglements as $table_Reglement){
                $table_Reglement->id_facture = $Fact->id_facture;
                $table_Reglement->modifier();
                if ($table_Reglement->id_solde != 0) {
                $Solde_client = Solde_client::trouve_par_id($table_Reglement->id_solde);
                $Reste =  $Solde_client->solde - ($table_Reglement->somme + $table_Reglement->timbre);
                $Solde_client->solde = $Reste;
                if ($Reste == 0 ) {
                $Solde_client->etat = 1;   
                }
                $Solde_client->modifier();
                } 
                
              }

			 /////////////////////// ajouter piece comptable automatiquement  FACTURE VENTE ///////////////////////////////
$Ht_total = 0;
$TVA_total = 0;
$timbre_total = 0;
$TTC = 0;
	$Ht = Famille::calcule_Ht_par_famille_and_facture_vente($Fact->id_facture,$nav_societe->id_societe);
	foreach ($Ht as $Hts) {
		$Ht_total += $Hts->Ht; 
	}

	$TVA = Famille::calcule_TVA_par_famille_and_facture_vente($Fact->id_facture,$nav_societe->id_societe);

	$timbres = Famille::calcule_timbre_par_famille_and_facture_vente($Fact->id_facture,$nav_societe->id_societe);

	$somme_ttc = Famille::calcule_somme_ttc_par_famille_and_facture_vente($Fact->id_facture,$nav_societe->id_societe);
		foreach ($somme_ttc as $somme_ttcs) {
		$TTC += $somme_ttcs->somme_ttc;
	}

		$TVA_total = $TTC - $Ht_total - $Fact->timbre;

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $nav_societe->id_societe;
	$Pieces_comptables->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables->type_op =  2;
	$Pieces_comptables->ref_piece =  $Fact->N_facture;
	$Pieces_comptables->libelle =  'FACTURE VENTE - '.$Client->nom;
	$Pieces_comptables->date =  $Fact->date_fac;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $nav_societe->journal_vente;
	$Pieces_comptables->somme_debit = $Fact->somme_ttc;
	$Pieces_comptables->somme_credit = $Fact->somme_ttc;
	$Pieces_comptables->facture_scan = $Fact->facture_scan;
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();



///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);


	foreach ($somme_ttc as $somme_ttc) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $somme_ttc->Compte;
	$Compte_comp = Compte_comptable::trouve_par_id($somme_ttc->Compte);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $somme_ttc->auxiliere_achat;
	$Ecriture_comptable->debit= $somme_ttc->somme_ttc;
	$Ecriture_comptable->save();

				}


/////////////////// HT////////////////////////////////	



	foreach ($Ht as $Ht) {

		$pourcentage_Ht =  ($Ht->Ht * $Fact->Remise) / ( $Fact->somme_ht + $Fact->Remise);
		 $Ht_final = $Ht->Ht - $pourcentage_Ht ;


	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_vente;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_vente);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_vente;
	$Ecriture_comptable->credit = $Ht->Ht;
	$Ecriture_comptable->save();
				}

	if ($Fact->Remise > 0) {

	foreach ($TVA as $TVA) {

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $TVA->comptes_vente;
	$Compte_comp = Compte_comptable::trouve_par_id($TVA->comptes_vente);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $TVA->auxiliere_vente;
	$Ecriture_comptable->credit = $TVA_total;
	$Ecriture_comptable->save();
				}
	}else{
	foreach ($TVA as $TVA) {

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $TVA->comptes_vente;
	$Compte_comp = Compte_comptable::trouve_par_id($TVA->comptes_vente);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $TVA->auxiliere_vente;
	$Ecriture_comptable->credit = $TVA->total_tva ;
	$Ecriture_comptable->save();
				}
				}			

	foreach ($timbres as $timbre) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $timbre->comptes_vente;
	$Compte_comp = Compte_comptable::trouve_par_id($timbre->comptes_vente);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $timbre->auxiliere_vente;
	$Ecriture_comptable->credit = $timbre->timbre;
	$Ecriture_comptable->save();
				}


 /////////////////////// ajouter piece comptable automatiquement  Sortie stock ///////////////////////////////

	$random_number_2 = rand();

	$Pieces_comptables_Sortie = new Pieces_comptables();
	$Pieces_comptables_Sortie->id_societe = $nav_societe->id_societe;
	$Pieces_comptables_Sortie->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables_Sortie->type_op =  7;
	$Pieces_comptables_Sortie->ref_piece =  $Fact->N_facture;
	$Pieces_comptables_Sortie->libelle =  ' SORTIE STOCK  - '.$Client->nom;
	$Pieces_comptables_Sortie->date =  $Fact->date_fac;
	$Pieces_comptables_Sortie->date_valid =  date("Y-m-d");
	if ($nav_societe->journal_stock != 0) {
	$Pieces_comptables_Sortie->journal = $nav_societe->journal_stock;
	} else{
	$Pieces_comptables_Sortie->journal = $nav_societe->journal_depense;	
	}
	$Pieces_comptables_Sortie->somme_debit = $Fact->somme_Ht_achat;
	$Pieces_comptables_Sortie->somme_credit = $Fact->somme_Ht_achat;
	$Pieces_comptables_Sortie->facture_scan = $Fact->facture_scan;
	$Pieces_comptables_Sortie->random =  $random_number_2;
	$Pieces_comptables_Sortie->save();


///////////// ajouter les ecriture comptable de cette piece /////////////////// 


	$Piece_Sortie = Pieces_comptables::trouve_par_random($random_number_2);
	$Hts = Famille::calcule_Ht_par_famille_and_facture_vente($Fact->id_facture,$nav_societe->id_societe);

foreach ($Hts as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_consommation;
	if (isset($Ht->comptes_consommation)) {
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_consommation);
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece_Sortie->id;
	$Ecriture_comptable->date = $Piece_Sortie->date;
	$Ecriture_comptable->ref_piece = $Piece_Sortie->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece_Sortie->libelle;
	$Ecriture_comptable->journal = $Piece_Sortie->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece_Sortie->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_consommation;
	$Ecriture_comptable->debit = $Ht->Ht_achat;
	$Ecriture_comptable->save();
				}

	foreach ($Hts as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_stock;
	if (isset($Ht->comptes_stock)) {
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_stock);
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece_Sortie->id;
	$Ecriture_comptable->date = $Piece_Sortie->date;
	$Ecriture_comptable->ref_piece = $Piece_Sortie->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece_Sortie->libelle;
	$Ecriture_comptable->journal = $Piece_Sortie->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece_Sortie->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_vente;
	$Ecriture_comptable->credit = $Ht->Ht_achat;
	$Ecriture_comptable->save();
				}
	



			 readresser_a("invoice.php?id=".$Fact->id_facture."&action=vente");
		}
 		 
 		}else{
		// errors occurred
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 
	}
}
}
if (isset($_GET['action']) && $_GET['action'] =='fact_achat' ) {

				$nav_societe = Societe::trouve_par_id($_SESSION['societe']);
				$Somme_ht = Achat::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Achat::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Achat::somme_ttc($user->id,$nav_societe->id_societe);
				$table_achats = Achat::trouve_achat_vide_par_admin($user->id,$nav_societe->id_societe);
				$table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($user->id,$nav_societe->id_societe,1);
				$Reglement = Reglement_fournisseur::trouve_somme_and_timbre_vide_par_admin($user->id,$nav_societe->id_societe,1);
if (!empty($table_achats)) {
					$Last_fournisseur = Achat::trouve_last_fournisseur_par_id_admin($user->id,$nav_societe->id_societe);
					$Fournisseur = Fournisseur::trouve_par_id($Last_fournisseur->id_fournisseur);
					$n_fact = count( $factures = Facture_achat::trouve_last_par_societe($nav_societe->id_societe))  ;
				if ( $n_fact == 0 ){ $n_facture = 1; }
				else if ( $n_fact > 0 ){		if (!empty($factures->N_facture)){ $n_facture = $factures->N_facture + 1 ;}
												else  { $n_facture = 1; }	
				}

	$errors = array();
	$random_number = rand();
	$factur = new Facture_achat();
	$factur->N_facture = $n_facture;
	$factur->id_societe = $nav_societe->id_societe;
	$factur->date_valid = date("Y-m-d");
	$factur->somme_ht =  $Somme_ht->somme_ht;
	$factur->somme_tva =  $Somme_tva->somme_tva;

	$factur->random =  $random_number;
	$factur->Num_facture = htmlentities(trim($_POST['Reference']));
	$factur->date_fac = htmlentities(trim($_POST['date_fact']));
	$factur->id_fournisseur = htmlentities(trim($_POST['fournisseur']));
	if (!empty($_POST['facture_scan'])) {
	$factur->facture_scan = htmlentities(trim($_POST['facture_scan']));
	}

	$Remise_facture = htmlentities(trim($_POST['Remise']));
	if ($Remise_facture > 0) {
	$factur->somme_ttc =  $Somme_ttc->somme_ttc;
	}else{
	$factur->somme_ttc =$Reglement->somme;		
	}
	$factur->timbre =$Reglement->timbre;
	$factur->etat =1;


	//////////////////////////////////////////////////

	if (empty($errors)){
   		if ($factur->existe()) { 

   			echo '<script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
            toastr.success(" Facture créée avec succès","Très bien !");
        },300);


 			});

			</script>';
			 readresser_a("operation.php?action=achat");

	}else{
			$factur->save();


			 ?>
 			<script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
            toastr.success(" Facture créée avec succès","Très bien !");
        },300);


 			});

			</script>
		
	<?php  
	if (!empty($_POST['facture_scan'])) {
	$upload = Upload:: trouve_par_id($_POST['facture_scan']);
	$upload->status = 1;
	$upload->save();
	}

			$Fact = Facture_achat::trouve_par_random($random_number);
			$date = date_parse($Fact->date_fac);
			 foreach($table_achats as $table_achat){ 

			 	$Article = Produit::trouve_par_id($table_achat->id_prod);


				if (empty($errors)){
/////////////// mise a jour table Achat avec le nv id_facture ////////////////////
					$table_achat->id_facture = $Fact->id_facture;
					$table_achat->date_fact = htmlentities(trim($_POST['date_fact']));
					$table_achat->id_fournisseur = htmlentities(trim($_POST['fournisseur']));
					$table_achat->Reference_fact = htmlentities(trim($_POST['Reference']));
					$table_achat->modifier();
					
///////////////////////// inset into histo_achat table ///////////////////////:
			$SQL2 = $bd->requete("INSERT INTO `histo_achat` (`id`, `lib_prod`, `code_prod`, `id_prod`, `id_facture`, `Quantite_achat`, `Quantite_stock`) VALUES (NULL, '$table_achat->Designation', '$table_achat->Code', '$table_achat->id_prod', '$table_achat->id_facture', '$table_achat->Quantite', '$Article->stock');");

		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock + $table_achat->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->prix_achat = $table_achat->Prix;
					if ($Article->pourcentage_prix_vente > 0) {
					$Article->prix_vente = $table_achat->Prix +($table_achat->Prix * $Article->pourcentage_prix_vente) ;
					}
					$Article->prix_achat = $table_achat->Prix ;
					$Article->modifier();

					////// creat new lot /////////////////

						$Lot_prod = new Lot_prod();
						$Lot_prod->code_lot = rand();
						$Lot_prod->id_societe = $nav_societe->id_societe;
						$Lot_prod->id_prod = $Article->id_pro;
						$Lot_prod->id_facture = $Fact->id_facture;
						$Lot_prod->id_achat = $table_achat->id;
						$Lot_prod->qte = $table_achat->Quantite;
						$Lot_prod->qte_initial = $table_achat->Quantite;
						$Lot_prod->prix_achat = $table_achat->Prix;
						$Lot_prod->prix_vente = $Article->prix_vente;
						$Lot_prod->date_lot = $Fact->date_fac ;
						$Lot_prod->type_achat = 1;
						$Lot_prod->save();

			///////////////////////		mise a jour de la formule if existe id prod in formule and if existe formule ////////////////////	

						if ($Article->matiere_premiere == 1) {
						$Detail_formules = Detail_formule::trouve_formule_par_id_Matiere_Premiere($Article->id_pro);
						if (!empty($Detail_formules)) {
						foreach ($Detail_formules as $Detail_formule) {
						$lot_prod = Lot_prod::trouve_first_lot($Article->id_pro);	
						if (isset($lot_prod->id)) {
					 			$Detail_formule->id_lot = $lot_prod->id;
					 			}
					 	$Detail_formule->save();
							
						}
						
						}
						}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


				}else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 

	}
	unset($errors);
			 }

			 /////////// Valid table Reglement ////////////////

			 foreach($table_Reglements as $table_Reglement){
			 	$table_Reglement->id_facture = $Fact->id_facture;
			 	$table_Reglement->modifier();
			 	if ($table_Reglement->id_solde != 0) {
			 	$Solde_fournisseur = Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
			 	$Reste =  $Solde_fournisseur->solde - ($table_Reglement->somme + $table_Reglement->timbre);
			 	$Solde_fournisseur->solde = $Reste;
			 	if ($Reste == 0 ) {
			 	$Solde_fournisseur->etat = 1;	
			 	}
			 	$Solde_fournisseur->modifier();
			 	} 
			 	
			 	
			 	

			  }

/////// TROUVE Fournisseur //////////////////////////////
			 
$Fournisseur = Fournisseur::trouve_par_id($factur->id_fournisseur);			 
/////////////////////// ajouter piece comptable FACTURE ACHAT automatiquement ///////////////////////////////

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $nav_societe->id_societe;
	$Pieces_comptables->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables->type_op =  1;
	$Pieces_comptables->ref_piece =  $Fact->N_facture;
	$Pieces_comptables->libelle =  'FACTURE ACHAT - '.$Fournisseur->nom;
	$Pieces_comptables->date =  $Fact->date_fac;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $nav_societe->journal_achat;
	$Pieces_comptables->somme_debit = $Fact->somme_ttc;
	$Pieces_comptables->somme_credit = $Fact->somme_ttc;
	$Pieces_comptables->facture_scan = $Fact->facture_scan;
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();


///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);
	$Ht = Famille::calcule_Ht_par_famille_and_facture_achat($Fact->id_facture,$nav_societe->id_societe);
	$TVA = Famille::calcule_TVA_par_famille_and_facture_achat($Fact->id_facture,$nav_societe->id_societe);
	$timbres = Famille::calcule_timbre_par_famille_and_facture_achat($Fact->id_facture,$nav_societe->id_societe);
	$somme_ttc = Famille::calcule_somme_ttc_par_famille_and_facture_achat($Fact->id_facture,$nav_societe->id_societe);

	foreach ($Ht as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_achat);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_achat;
	$Ecriture_comptable->debit = $Ht->Ht;
	$Ecriture_comptable->save();
				}
	foreach ($TVA as $TVA) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $TVA->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($TVA->comptes_achat);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $TVA->auxiliere_achat;
	$Ecriture_comptable->debit = $TVA->total_tva;
	$Ecriture_comptable->save();
				}
	foreach ($timbres as $timbre) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $timbre->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($timbre->comptes_achat);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $timbre->auxiliere_achat;
	$Ecriture_comptable->debit = $timbre->timbre;
	$Ecriture_comptable->save();
				}
	foreach ($somme_ttc as $somme_ttc) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $somme_ttc->Compte;
	$Compte_comp = Compte_comptable::trouve_par_id($somme_ttc->Compte);
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece->id;
	$Ecriture_comptable->date = $Piece->date;
	$Ecriture_comptable->ref_piece = $Piece->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece->libelle;
	$Ecriture_comptable->journal = $Piece->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $somme_ttc->auxiliere_achat;
	$Ecriture_comptable->credit = $somme_ttc->somme_ttc;
	$Ecriture_comptable->save();
				}

/////////////////////// ajouter piece comptable Entrée stock automatiquement ///////////////////////////////
		$random_number_2 = rand();

	$Pieces_comptables_Entree = new Pieces_comptables();
	$Pieces_comptables_Entree->id_societe = $nav_societe->id_societe;
	$Pieces_comptables_Entree->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables_Entree->type_op =  6;
	$Pieces_comptables_Entree->ref_piece =  $Fact->N_facture;
	$Pieces_comptables_Entree->libelle =  'Entrée stock - '.$Fournisseur->nom;
	$Pieces_comptables_Entree->date =  $Fact->date_fac;
	$Pieces_comptables_Entree->date_valid =  date("Y-m-d");
	if ($nav_societe->journal_stock != 0) {
	$Pieces_comptables_Entree->journal = $nav_societe->journal_stock;
	} else{
	$Pieces_comptables_Entree->journal = $nav_societe->journal_depense;	
	}
	$Pieces_comptables_Entree->somme_debit = $Fact->somme_ht;
	$Pieces_comptables_Entree->somme_credit = $Fact->somme_ht;
	$Pieces_comptables_Entree->facture_scan = $Fact->facture_scan;
	$Pieces_comptables_Entree->random =  $random_number_2;
	$Pieces_comptables_Entree->save();

///////////// ajouter les ecriture comptable de cette piece /////////////////// 

	$Piece_Entree = Pieces_comptables::trouve_par_random($random_number_2);
	$Ht_Entrees = Famille::calcule_Ht_par_famille_and_facture_achat($Fact->id_facture,$nav_societe->id_societe);
	
	foreach ($Ht_Entrees as $Ht_Entree) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht_Entree->comptes_stock;
		if(isset($Ht_Entree->comptes_stock)){
	$Compte_comp = Compte_comptable::trouve_par_id($Ht_Entree->comptes_stock);	
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece_Entree->id;
	$Ecriture_comptable->date = $Piece_Entree->date;
	$Ecriture_comptable->ref_piece = $Piece_Entree->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece_Entree->libelle;
	$Ecriture_comptable->journal = $Piece_Entree->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece_Entree->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht_Entree->auxiliere_stock;
	$Ecriture_comptable->debit = $Ht_Entree->Ht;
	$Ecriture_comptable->save();
				}
				
		foreach ($Ht_Entrees as $Ht_Entree) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht_Entree->comptes_achat;
	if(isset($Ht_Entree->comptes_achat)){
	$Compte_comp = Compte_comptable::trouve_par_id($Ht_Entree->comptes_achat);	
	}
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	$Ecriture_comptable->id_piece = $Piece_Entree->id;
	$Ecriture_comptable->date = $Piece_Entree->date;
	$Ecriture_comptable->ref_piece = $Piece_Entree->ref_piece;
	$Ecriture_comptable->lib_piece = $Piece_Entree->libelle;
	$Ecriture_comptable->journal = $Piece_Entree->journal;
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece_Entree->id_societe;
	$Ecriture_comptable->id_auxiliere = $Ht_Entree->auxiliere_achat;
	$Ecriture_comptable->credit = $Ht_Entree->Ht;
	$Ecriture_comptable->save();
				}
		

			 readresser_a("invoice_achat.php?id=".$Fact->id_facture."&action=achat");
		}
 		 
 		}else{
		// errors occurred
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 
	}

	}

}
 ?>
 <?php
$active_menu = "Facturation";
$header = array('table','invoice');
$footer = array('dataTable');
if ($user->type == "administrateur"){
if (isset($_GET['action']) && $_GET['action'] =='list_vente' ) {
$active_submenu = "list_vente";
$action = 'list_vente';
$titre = "ThreeSoft | Vente ";}
else if (isset($_GET['action']) && $_GET['action'] =='vente' ) {
$active_submenu = "list_vente";
$action = 'vente';
$titre = "ThreeSoft | Vente ";}
else if (isset($_GET['action']) && $_GET['action'] =='list_achat' ) {
$active_submenu = "list_achat";
$action = 'list_achat';
$titre = "ThreeSoft | Achat ";}
else if (isset($_GET['action']) && $_GET['action'] =='achat' ) {
$active_submenu = "list_achat";
$action = 'achat';
$titre = "ThreeSoft | Achat ";}
else if (isset($_GET['action']) && $_GET['action'] =='list_depense' ) {
$active_submenu = "depense";
$action = 'list_depense';
$titre = "ThreeSoft | Dépense ";}
else if (isset($_GET['action']) && $_GET['action'] =='add_depense' ) {
$active_submenu = "depense";
$action = 'add_depense';
$titre = "ThreeSoft | Dépense ";}
else if (isset($_GET['action']) && $_GET['action'] =='edit_depense' ) {
	$active_submenu = "depense";
	$action = 'edit_depense';
	$titre = "ThreeSoft | Dépense ";}
else if (isset($_GET['action']) && $_GET['action'] =='add_fact_depense' ) {
		$active_submenu = "depense";
		$action = 'add_fact_depense';
		$titre = "ThreeSoft | Dépense ";}
else if (isset($_GET['action']) && $_GET['action'] =='edit_fact_depense' ) {
		$active_submenu = "depense";
		$action = 'edit_fact_depense';
		$titre = "ThreeSoft | Dépense ";}
else if (isset($_GET['action']) && $_GET['action'] =='depense' ) {
$active_submenu = "depense";
$action = 'depense';
$titre = "ThreeSoft | Dépense ";}
else if (isset($_GET['action']) && $_GET['action'] =='upload' ) {
$active_submenu = "list_vente";
$action = 'upload';
$titre = "ThreeSoft | upload ";}
else if (isset($_GET['action']) && $_GET['action'] =='upload_achat' ) {
$active_submenu = "list_achat";
$action = 'upload_achat';
$titre = "ThreeSoft | upload ";}
else if (isset($_GET['action']) && $_GET['action'] =='edit_achat' ) {
$active_submenu = "list_achat";
$action = 'edit_achat';
$titre = "ThreeSoft | Modifier Achat ";}
else if (isset($_GET['action']) && $_GET['action'] =='edit_vente' ) {
$active_submenu = "list_vente";
$action = 'edit_vente';
$titre = "ThreeSoft | Modifier Vente ";}
// End of the main Submit conditional.
}
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id_facture = htmlspecialchars(trim($_GET['id'])); 
	 }
?>
 
<?php
		// upload facture	Achat	
	if(isset ($_POST['submit']) && $action == 'upload_achat' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$upload_achat = Facture_achat:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$upload_achat = Facture_achat:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 


	$errors = array();
		// new object Upload
		
	
	 $upload_achat->facture_scan = htmlentities(trim($_POST['id_scan']));

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($upload_achat->save()){
			
					
		$msg_positif = '<p >  Facture N° : <b>' . $upload_achat->id_facture . '</b> est bien ajouter - <a href="operation.php?action=list_achat">  Liste des Achat</a> </p><br />';
													
														
		}else{
		$msg_system .= "<h1>Une erreur dans le programme ! </h1>
                   <p  >  S'il vous plaît modifier à nouveau !!</p>";
		}
 		
 		}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
		}
		if ( (isset($_GET['id_scan'])) && (is_numeric($_GET['id_scan'])) ) { 
 	$id = $_GET['id_scan']; 
	$edit_upload = Upload:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id_scan'])) &&(is_numeric($_POST['id_scan'])) ) { 
		 $id = $_POST['id_scan'];
	$edit_upload= Upload:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		 $edit_upload->status = 1;
		 $edit_upload->save();
		

		
	}
					?>
	<?php
		// Ajouter depense	
	if(isset ($_POST['submit']) && $action == 'add_depense' ){
	
	$errors = array();
		// new object Upload
	$depnse = new Depense();
	
	$depnse->id_societe = $nav_societe->id_societe;
	$depnse->depense = htmlentities(trim($_POST['depense']));
	$depnse->comptes_depense = htmlentities(trim($_POST['comptes_depense']));
	$depnse->auxiliere_depense = htmlentities(trim($_POST['auxiliere_depense']));
	
	

	if (empty($errors)){
if ($depnse->existe()) {
			$msg_error = '<p >  depnse : ' . $depnse->depense . ' existe deja !!!</p><br />';
			
		}else{
			$depnse->save();
 		$msg_positif = '<p ">        depnse est bien ajouter  </p><br />';
		
		}
 		 
 		}else{
		// errors occurred
		$msg_error = '<h1> !! erreur </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}

		
	}
// Edit depense	
if($action == 'edit_depense' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$depenses = Depense:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$depenses = Depense:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page est consulter par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object 
		
		$depenses->depense = htmlentities(trim($_POST['depense']));
		$depenses->comptes_depense = htmlentities(trim($_POST['comptes_depense']));
		$depenses->auxiliere_depense = htmlentities(trim($_POST['auxiliere_depense']));
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($depenses->save()){
		$msg_positif .= '<p >  depnse ' . html_entity_decode($depenses->depense) . '  est modifier  avec succes </p><br />';
													
														
		}else{
		$msg_system .= "<h1>Une erreur dans le programme ! </h1>
                   <p  >  S'il vous plait modifier est nouveau !!</p>";
		}
 		
 		}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
		}
}		
	}
			// Ajouter  FACTURE depense	
	if(isset ($_POST['submit']) && $action == 'depense' ){
	
	$errors = array();
		// new object Upload
	$fact_depnse = new Facture_depense();
	
	$fact_depnse->id_societe = $nav_societe->id_societe;
	$fact_depnse->id_depense = htmlentities(trim($_POST['id_depense']));
	$fact_depnse->id_fournisseur = htmlentities(trim($_POST['id_fournisseur']));
	$fact_depnse->date_fact = htmlentities(trim($_POST['date_fact']));
	$fact_depnse->reference = htmlentities(trim($_POST['reference']));
	$fact_depnse->ht = htmlentities(trim($_POST['ht']));
	$fact_depnse->tva = htmlentities(trim($_POST['tva']));
	$fact_depnse->timbre = htmlentities(trim($_POST['timbre']));
	$fact_depnse->ttc = htmlentities(trim($_POST['tcc']));
		

	if (empty($errors)){
if ($fact_depnse->existe()) {
			
			$msg_error = '<p >  Facture : ' . $fact_depnse->reference . ' existe deja !!!</p><br />';
			
		}else{
			$fact_depnse->save();
 		$msg_positif = '<p ">        Facture est bien ajouter  </p><br />';
		
		}
 		 
 		}else{
		// errors occurred
		$msg_error = '<h1> !! erreur </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}

		
	}
	?>

<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
		<div class="container-fluid">
			<!-- BEGIN PAGE CONTENT-->
			
			<!-- BEGIN PAGE HEADER-->
			
			<div class="page-bar">
				<ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-table"></i>
                        <a href="#">Facturation</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'vente') { ?>
                        <a href="#">Vente</a>  
                         <?php } else if($action == 'vente'){
                         	echo '<a href="#">Achat</a> ';
                         } else if($action == 'list_achat'){
                         	echo '<a href="#">Liste Achats</a> ';
                         } else if($action == 'list_vente'){
                         	echo '<a href="#">Liste Ventes</a> ';
                         }else if($action == 'edit_achat'){
                         	echo '<a href="#">Modifier Achat</a> ';
                         }else if($action == 'edit_vente'){
                         	echo '<a href="#">Modifier Vente</a> ';
                          }else if($action == 'achat'){
                         	echo '<a href="#">Achat</a> ';
                         }
                         ?>
                        
                    </li>
				</ul>
			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
							if ($action == 'list_vente') {
				
				?>
			<div class="row">
				<div class="col-md-12">
								
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				if (isset($_POST['submit']) ) {
				
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$factures = Facture_vente::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				
				}else{
					$factures = Facture_vente::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}
				
				$NfactNV = count($table_ch = Facture_vente::trouve_facture_non_valide_par_societe($nav_societe->id_societe));
				$NfactV = count($table_ch = Facture_vente::trouve_facture_valide_par_societe($nav_societe->id_societe));
				$Nfact = $NfactNV + $NfactV; 				
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12 ">
				<div class="notification"></div>		

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered " >
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>Factures clients (ventes)<span class="caption-helper">&nbsp;&nbsp;(<?php echo $Nfact;?>)</span>
							</div>
						</div>
						<div class="table-toolbar">
							<div class="row">
									<div class="col-md-4">
										<div class="btn-group">
											
											<a href="operation.php?action=vente" class="btn yellow-crusta ">Nouvelle facture  <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
								
										<div class="col-md-8">
										
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=list_vente" method="POST" class="form-horizontal">

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="col-md-3 control-label">Du</label>
														<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut)){echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>					
														</div>
												</div>
											</div>	
											<div class="col-md-4">													
												<div class="form-group">
													<label class="col-md-3 control-label">au</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin)){echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
											</div>
											
										
													<div class="col-md-4">
														<button type="submit" name = "submit" class="btn green">Chercher</button>
														
													</div>
												
										</div>
										</form>
										<!-- END FORM-->
										
									
											
										</div>
									
									
							</div>
						</div>
							
						<div class="portlet-body" id="">
					
							<table class="table table-striped  table-hover" id="sample_2">
							
							<thead>
							<tr>
								
								<th>
									N°  Facture
								</th>
								<th>
									Date 
								</th>
								<th>
									Client
								</th>
								<th>
									HT
								</th>
								<th>
									REMISE
								</th>
								<th>
									TVA
								</th>
								<th>
									TIMBRE
								</th>
								<th>
									 TTC
								</th>
								
								<th>
									Facture scan
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr  id="fact_<?php echo $facture->id_facture; ?>">
								
								
								<td>
								<a href="invoice.php?id=<?php echo $facture->id_facture; ?>" class="">
								<i class="fa fa-file-text-o bg-yellow"></i>
									<b><?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?></b>
									
                                                    <i class="fa fa-download font-blue"></i> </a>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								<td>
								<i class="fa fa-building  font-yellow"></i>
									<?php if (isset($facture->id_client)) {
															$client = Client::trouve_par_id($facture->id_client);
															if (isset($client->nom)) {
															echo $client->nom;}
															}?>
								</td>
								<td>
									<?php if (isset($facture->somme_ht)) {
									$total_somme_ht +=$facture->somme_ht;
									echo number_format($facture->somme_ht , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->Remise)) {
									$total_Remise +=$facture->Remise;
									echo number_format($facture->Remise , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_tva)) {
										$total_somme_tva +=$facture->somme_tva;
									echo number_format($facture->somme_tva , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->timbre)) {
										$total_timbre +=$facture->timbre;
									echo number_format($facture->timbre , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
										$total_somme_ttc +=$facture->somme_ttc;
									echo number_format($facture->somme_ttc , 2, ',', ' ');
									} ?>
								</td>
								
								<td>
									<?php if (!empty($facture->facture_scan)) {
										 $file = str_replace (" ", "_", $nav_societe->Dossier );
										 $ScanImage = Upload::trouve_par_id($facture->facture_scan);
									echo '<a href="scan/upload/'.$file.'/'.$ScanImage->img .'" class="btn bg-green-jungle fancybox-button btn-xs " ><i class="fa fa-eye"></i></a>';
									
									} ?>
									
								</td>
								<td>
									
									<a href="operation.php?action=edit_vente&id=<?php echo $facture->id_facture; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
                                    <button id="del_fact" value="<?php echo $facture->id_facture; ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_fact" data-toggle="modal"></i> </button>
									
								</td>
							</tr>

							<?php
								}
							?>
							
						
							</tbody>
							<tbody>
								<td colspan="2"></td>
								<td > <span style="float : left;   font-size: 18px; ;"><strong> TOTAUX: </strong></span></td>
								<td>  <strong><?php echo number_format($total_somme_ht , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_Remise , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_tva , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_timbre , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_ttc , 2, ',', ' '); ?></strong></td>

								<td></td>
								<td></td>
							</tbody>
							
							</table>						
							<a href="print.php?action=print_vente&date_db=<?php echo $date_db;?>&date_fin=<?php echo $date_fin;?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Imprimer</a>
						</div>
					</div>
					
				</div>
			
			</div>
				<?php }elseif ($action == 'vente') {
				$Articles = Produit::trouve_produit_vente_par_societe($nav_societe->id_societe);
				$clients = Client::trouve_valid_par_societe($nav_societe->id_societe); 	
				$tvas = TVA::trouve_tous(); 
				$Somme_ht = Vente::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Vente::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Vente::somme_ttc($user->id,$nav_societe->id_societe);
				$table_vantes = Vente::trouve_vente_vide_par_admin($user->id,$nav_societe->id_societe);
				if (!empty($table_vantes)) {
					$last_client = Vente::trouve_last_client_par_id_admin($user->id,$nav_societe->id_societe);
					
					}	
			$thisday=date('Y-m-d');
				  ?>
		<div class="show-facture">
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-9">
								<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} 
								?>


                    <div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Vente
							</div>
						</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
						
										   <div class="panel-body">                                                                        
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<div class="form-group ">
                                                <label class="col-md-3 control-label "> Client </label>
                                                <div class="col-md-9">                                                                                            
                                              
												<select class="form-control select2me"    name="id_client" id="id_client"  placeholder="Choisir client" >
															<option value=""></option>
														<?php  foreach ($clients as $client) { ?>
																<option <?php if (isset($last_client->id_client)) {
																		if ($last_client->id_client == $client->id_client) {echo "selected";}
																	} ?> value="<?php if(isset($client->id_client)){echo $client->id_client; } ?>"><?php if (isset($client->id_client)) {echo $client->nom;} ?> </option>
																<?php } ?>	
																	   
														</select>   
														<div class="form-control-focus">
														</div>
                                                </div>
                                            </div> 

                                        </div>
                                        <div class="col-md-6">
                                    		
                                            <div class="form-group ">
													<label class="col-md-4 control-label">Date facturation </label>
													<div class="col-md-8">
														
															<input type="date" name = "date_fact" id="date_fact" class="form-control" placeholder="Date " value="<?php if (isset($last_client->date_fact)) {echo $last_client->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
                                </div>
                                <br>
 								
												
											</div>	
											</div>
											
										
										<!-- END FORM-->
									</div>
							
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Listes
							</div>
						</div>
						<div class="portlet-body notification table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="30%">
									Désignation
								</th>
								<th width="15%">
									Lot
								</th>
								<th>
									 Qté 
								</th>
								<th>
									  PU 
								</th>
								<th>
									 Remise
								</th>
								<th>
									 TVA
								</th>
								<th>
									HT
								</th>
								<th>
									T.TVA 
								</th>
								
								<th>
									TOTAL  
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_vantes as $table_vante){ $cpt ++; ?>
							<tr class="item-row" >
								
								<td>
									<?php if (isset($table_vante->Designation)) {
										echo $table_vante->Designation.' | '.$table_vante->Code;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->id_lot)) {
										if ($table_vante->id_lot == 0) {
											echo "/";
										}else{
										$lot = $Lot_prod=Lot_prod::trouve_par_id($table_vante->id_lot);
										if (isset($Lot_prod->id)) {
											echo $Lot_prod->code_lot;
										}
										}
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Quantite)) {
										echo $table_vante->Quantite;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Quantite)) { echo $table_vante->Quantite ; } ?>"  class="hidden qty">
								</td>
								<td>
									<?php if (isset($table_vante->Prix)) {
										echo $table_vante->Prix;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Prix)) { echo $table_vante->Prix ; } ?>"  class="hidden price">
								</td>
								<td>
									<?php if (isset($table_vante->Remise)) {
										echo $table_vante->Remise;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Remise)) { echo $table_vante->Remise ; } ?>"  class="hidden remise">
								</td>
								<td>
									<?php if (isset($table_vante->Ttva)) {
										echo ($table_vante->Ttva *100).' %';
									} ?>
									 <input type="text" value="<?php if (isset($table_vante->Ttva)) { echo $table_vante->Ttva ; } ?>"  class="hidden tva_prod">
								</td>
								<td class="HT">
									<?php if (isset($table_vante->Ht)) {
										echo $table_vante->Ht;
									} ?>
									
								</td>
								
								 <td class="TVA">
									<?php if (isset($table_vante->Tva)) {
										echo $table_vante->Tva;
									} ?>
								</td>
								<td class="TTC">
									<?php if (isset($table_vante->total)) {
										echo $table_vante->total;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_vante->id)){ echo $table_vante->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							<tbody>
								
							<tr class="info-prodact" >
								
								<td>
								<select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
															<option value=""></option>
														 <?php  foreach ($Articles as $Article) {
                                                            $stock_prod = Produit::Calcul_stock_par_id($Article->id_pro); ?>
                                                                    <option  value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$stock_prod->stock ;} ?> </option>
                                                                <?php } ?> 													   
								</select>   
								</td>
								
								<td>
									
								</td>
								<td>
									
								</td>
								<td>
									 
								</td>
								<td>
									 
								</td>
								<td>
	
								</td>
								
								
								<td>
									
								</td>
								<td>
									
								</td>
								<td>
									

								</td>

								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody> 
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2" id="TOTALHT" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> </td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> REMISE : </strong></span></td>
									<td colspan="2" id="REMISE_ht" style="font-size: 18px;">0.00</td>
							    </tr>

							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT APRES REMISE : </strong></span></td>
									<td colspan="2" id="TOTALHT_R" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> </td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; "><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2" id="TOTALTVA" style= "font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?>
									
									 </td>
							    </tr>
							    <tr>
							    	

									<td colspan="8" ><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2" id="TOTALTTC" style="font-size: 18px;" ><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> 
									 </td>
									 <input type="hidden" id="TOTALTTC1" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> ">
									 <input type="hidden" id="TOTALTVA1" value="<?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> ">
									 <input id="last_tva" type="hidden" value="<?php echo $last_client->Ttva; ?>">
							    </tr>

										
                          			  </tbody> 
							</table>
							<br>
							<div class="TTC-proposer">
							<table class="table table-striped table-bordered table-hover "  >
											<tr   >
												<td colspan="8" width="81.5%" ><span style="float : right;   font-size: 18px; ;"><strong> TTC proposer :  </strong></span></td>
												<td colspan="2" ><input id="TTC_propose" disabled type="number" min="0" value="<?php if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} ?>"  class="form-control input-small " ></td>
											</tr>
							</table>
						</div>

						</div>
							<div class="panel-footer "  align="right">
									<button id="reset_total"  class="btn red"><i class="fa fa-refresh"></i> Réinitialiser TTC </button>
										<button id="Enregistrer_paiement"  disabled class="btn  green " data-target="#add-paiment"  > <i class="fa fa-credit-card"></i>  Enregistrer un paiement </button>
						    </div>	

						</div>
					
				</div>

					
				<div class="col-md-3 list-group-item bg-blue-chambray margin-bottom-30">
					<div class=" bg-blue-ebonyclay">
						<p>Scan du Facture Vente</p>
					</div>
				<?php
					if (isset($_GET['id_img'])) {
					 $image =  htmlspecialchars($_GET['id_img']) ;
					 
					 $img_select = Upload::trouve_par_id ($image);
					  
					}else{
							echo '<p> aucune facture sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($image)){
				
					$info = new SplFileInfo($img_select->img);
					$errors[]= '  Lot deja consommé !';
					if($info->getExtension() == 'pdf'){?>
					
					<object data="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" type="application/pdf" width="100%" height="1000">
					<?php if (!empty($msg_error)) {?>
						<object data="assets/image/test.pdf" type="application/pdf" width="100%" height="1000">
						alt : <a href="assets/image/test.pdf">test.pdf</a>
						</object> 
						<?php }?>
					</object>

						<?php }else {?>
							

					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" class="img-responsive fancybox-button "><img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   ></a>
				
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
					
								<?php }?>
	
				
				
				<?php }else {echo '<a href="#form_modal11" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>
			</div>
		</div>

					
			
			<?php } else if($action =="list_achat") {?>
				<div class="row">
				<div class="col-md-12">
				<div class="notification"></div>
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				if (isset($_POST['submit'])){
					
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$factures = Facture_achat::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				}else{
					$factures = Facture_achat::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}
				$NfactNA = count($table_ch = Facture_achat::trouve_facture_non_valide_par_societe($nav_societe->id_societe));
				$NfactA = count($table_ch = Facture_achat::trouve_facture_valide_par_societe($nav_societe->id_societe));
				$Nfact = $NfactNA + $NfactA; 				
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12 ">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>Factures fournisseur (achats)<span class="caption-helper">&nbsp;&nbsp;(<?php echo $Nfact;?>)</span>
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-4">
										<div class="btn-group">
											
											<a href="operation.php?action=achat" class="btn yellow-crusta ">Nouvelle facture  <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								
								<div class="col-md-8">
										
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=list_achat" method="POST" class="form-horizontal">

										<div class="row">
												<div class="col-md-4">
												<div class="form-group">
													<label class="col-md-3 control-label">Du</label>
														<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut)){echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>					
														</div>
												</div>
											</div>	
											<div class="col-md-4">													
												<div class="form-group">
													<label class="col-md-3 control-label">au</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin)){echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
											</div>
											
										
													<div class="col-md-4">
														<button type="submit" name = "submit" class="btn green">Chercher</button>
														
													</div>
												
										</div>
										</form>
										<!-- END FORM-->
											
										</div>
									</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped  table-hover" id="sample_2">
							<thead>
							<tr>
								
								<th>
									N°  Facture
								</th>
								<th>
									Référence
								</th>
								<th>
									Date 
								</th>
								<th>
									Fournisseur
								</th>
								<th>
									HT
								</th>
								<th>
									REMISE
								</th>
								<th>
									TVA
								</th>
								<th>
									TIMBRE
								</th>
								<th>
									 TTC
								</th>
								
								<th>
									Facture scan
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr id="fact_<?php echo $facture->id_facture; ?>">
								
								
								<td>
								<a href="invoice_achat.php?id=<?php echo $facture->id_facture; ?>" class="">
								<i class="fa fa-file-text-o bg-yellow"></i>
									<b><?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?></b>
									
                                                    <i class="fa fa-download font-blue"></i> </a>
								</td>
								<td>
									<?php if (isset($facture->Num_facture)) {
									echo $facture->Num_facture;
									} ?>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								
								<td>
								<i class="fa fa-building  font-yellow"></i>
									<?php if (isset($facture->id_fournisseur)) {
															$fournisseur = Fournisseur::trouve_par_id($facture->id_fournisseur);
															 if (isset($fournisseur->nom)) {
																		
															echo $fournisseur->nom;}
															}?>
								</td>
								<td>
									<?php if (isset($facture->somme_ht)) {
									$total_somme_ht +=$facture->somme_ht;
									echo number_format($facture->somme_ht , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->Remise)) {
									$total_Remise +=$facture->Remise;
									echo number_format($facture->Remise , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_tva)) {
										$total_somme_tva +=$facture->somme_tva;
									echo number_format($facture->somme_tva , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->timbre)) {
										$total_timbre +=$facture->timbre;
									echo number_format($facture->timbre , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
										$total_somme_ttc +=$facture->somme_ttc;
									echo number_format($facture->somme_ttc , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (!empty($facture->facture_scan)) {
										 $file = str_replace (" ", "_", $nav_societe->Dossier );
										 $ScanImage = Upload::trouve_par_id($facture->facture_scan);
									echo '<a href="scan/upload/'.$file.'/'.$ScanImage->img .'" class="btn bg-green-jungle fancybox-button btn-xs" ><i class="fa fa-eye"></i></a>';
									
									} ?>
									
								</td>
								<td>
									
									<a href="operation.php?action=edit_achat&id=<?php echo $facture->id_facture; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
                                    <button id="del_fact_achat" value="<?php echo $facture->id_facture; ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_fact_achat" data-toggle="modal"></i> </button>
									
								</td>
							</tr>

							<?php
								}
							?>
							
							</tbody>
							<tbody>
								<td colspan="3"></td>
								<td > <span style="float : left;   font-size: 18px; ;"><strong> TOTAUX: </strong></span></td>
								<td>  <strong><?php echo number_format($total_somme_ht , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_Remise , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_tva , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_timbre , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_ttc , 2, ',', ' '); ?></strong></td>

								<td></td>
								<td></td>
							</tbody>
							
							</table>
							<a href="print.php?action=print_achat&date_db=<?php echo $date_db;?>&date_fin=<?php echo $date_fin;?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Imprimer</a>
						</div>
					</div>
                                          
					
				</div>
			
			</div>


		<?php } else if($action =="achat") { 

			$Articles = Produit::trouve_produit_achat_par_societe($nav_societe->id_societe);
				$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 	
				$tvas = TVA::trouve_tous(); 
				$Somme_ht = Achat::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Achat::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Achat::somme_ttc($user->id,$nav_societe->id_societe);
				$table_achats = Achat::trouve_achat_vide_par_admin($user->id,$nav_societe->id_societe);
				if (!empty($table_achats)) {
					$last_fournisseur = Achat::trouve_last_fournisseur_par_id_admin($user->id,$nav_societe->id_societe);
					
					}	
			$thisday=date('Y-m-d');
				  ?>
		<div class="show-facture">
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-8">
<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>


                        <div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue bold">
										achat
									</div>
								</div>
							<div class="portlet-body form">
										<!-- BEGIN FORM-->
								 <div class="panel-body">                                                                        
                                    <div class="row">
                                        <div class="col-md-4">
                                        	<div class="form-group ">
                                                <label class="col-md-3 control-label "> Fournisseur </label>
                                                <div class="col-md-8">                                                                                            
                                              
												<select class="form-control select2me"    name="id_fournisseur" id="id_fournisseur"  placeholder="Choisir fournisseur" >
													
															<option value=""></option>
														<?php  foreach ($fournisseurs as $fournisseur) { ?>
																<option <?php if (isset($last_fournisseur->id_fournisseur)) {
																		if ($last_fournisseur->id_fournisseur == $fournisseur->id_fournisseur) {echo "selected";}
																	} ?> value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>"><?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?> </option>
																<?php } ?>	
																	   
														</select>   
														<div class="form-control-focus">
														</div>
                                                 
													
                                                </div>
												  
                                            </div> 
                                        </div>
                                        <div class="col-md-3">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-3 control-label">Date </label>
													<div class="col-md-9">
														
															<input type="date" name = "date_fact" id="date_fact" class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
										<div class="col-md-5">
											<div class="form-group ">
													<label class="col-md-3 control-label">Référence <span class="required" aria-required="true"> * </span> </label>
													<div class="col-md-9">
														
															<input type="text" id="Reference" class="form-control " name="Reference" placeholder="FACT0001/21" value="<?php if (isset($last_fournisseur->Reference_fact)) {echo $last_fournisseur->Reference_fact;  }?>"  required />
															
														</div>
														
													</div>

										</div>
                                	   </div>
                                 </div>
							</div>
						</div>
											
						
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Listes
							</div>
						</div>
						<div class="portlet-body notification table-responsive">
						<table class="table table-striped table-bordered table-hover" id="table_1" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								
								<th>
									 Quantité 
								</th>
								<th>
									  Prix U 
								</th>
								<th>
									  Remise 
								</th>
								<th>
									 TVA
								</th>
								<th>
									HT
								</th>
								<th>
									T.TVA 
								</th>
								
								<th>
									TOTAL  
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_achats as $table_achat){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($table_achat->Designation)) {
										echo $table_achat->Designation.' | '.$table_achat->Code;
									} ?>
								</td>
								
								
								<td>
									<?php if (isset($table_achat->Quantite)) {
										echo $table_achat->Quantite;
									} ?>
									<input type="text" value="<?php if (isset($table_achat->Quantite)) { echo $table_achat->Quantite ; } ?>"  class="hidden qty">
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo $table_achat->Prix;
									} ?>
									<input type="text" value="<?php if (isset($table_achat->Prix)) { echo $table_achat->Prix ; } ?>"  class="hidden price">
								</td>
								<td>
									<?php if (isset($table_achat->Remise)) {
										echo $table_achat->Remise;
									} ?>
									<input type="text" value="<?php if (isset($table_achat->Remise)) { echo $table_achat->Remise ; } ?>"  class="hidden remise">
								</td>
								<td>
									<?php if (isset($table_achat->Ttva)) {
										echo ($table_achat->Ttva *100).' %';
									} ?>
									 <input type="text" value="<?php if (isset($table_achat->Ttva)) { echo $table_achat->Ttva ; } ?>"  class="hidden tva_prod">
								</td>
								<td class=" HT">
									<?php if (isset($table_achat->Ht)) {
										echo $table_achat->Ht;
									} ?>
									
								</td>
								
								<td class="TVA">
									<?php if (isset($table_achat->Tva)) {
										echo $table_achat->Tva;
									} ?>
								</td>
								<td class="TTC">
									<?php if (isset($table_achat->total)) {
										echo $table_achat->total;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_achat->id)){ echo $table_achat->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							<tbody>
								
							<tr class="info-prodact" >
								
								<td>
									<select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
															<option value=""></option>
														<?php  foreach ($Articles as $Article) {
                                                            $stock_prod = Produit::Calcul_stock_par_id($Article->id_pro); ?>
                                                                    <option  value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$stock_prod->stock ;} ?> </option>
                                                                <?php } ?> 														   
														</select>   
								</td>
								
								<td>
									
								</td>
								
								<td>
									 
								</td>
								<td>
	
								</td>
								
								
								<td>
									</td>
								
								
								<td>
									
								</td>
								<td>
									
								</td>
								<td>
									

								</td>

								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2" id="TOTALHT" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; "><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2" id="TOTALTVA" style= "font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2" id="TOTALTTC" style="font-size: 18px;" ><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> DA</td>
							    </tr>
                          	 </tbody>
							</table>
							
						</div>
							<div class="panel-footer " align="right">   
								<a id="Enregistrer_paiement" disabled class="btn  green " data-target="#add-paiment_achat"  > <i class="fa fa-credit-card"></i>  Enregistrer un paiement </a>
						    </div>	

						</div>
					
				</div>
					<div class="col-md-4 list-group-item bg-blue-ebonyclay">
					
							<p>Scan du Facture Achat</p>
				
				</div>
				<div class="col-md-4 list-group-item bg-blue-chambray margin-bottom-30">
				<?php
					if (isset($_GET['id_img'])) {
					 $image =  htmlspecialchars($_GET['id_img']) ;
					 
					 $img_select = Upload::trouve_par_id ($image);
					  
					}else{
							echo '<p> aucune facture sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($image)){?>
				
					
					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" class="img-responsive fancybox-button "><img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   ></a>
					<a href="#form_modal10" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
						<a href="#form_modal10" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
						<a href="#form_modal10" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
				
				<?php }else {echo '<a href="#form_modal10" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>
			</div>
		</div>

		<?php }else if ($action=='edit_achat') {
				$Truncate_table = Update_achat::truncate_table($id_facture);
				$last_update = Update_achat::trouve_last_update_par_id_facture($id_facture);
				if (empty($last_update)) {
				$Insert_achat = Update_achat::insert_achat($id_facture);
				}
				///////////////////////////////////////////////
				$Articles = Produit::trouve_produit_achat_par_societe($nav_societe->id_societe);
				$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 	
				$Somme_ht = Update_achat::somme_ht($id_facture);
				$Somme_tva = Update_achat::somme_tva($id_facture);
				$Somme_ttc = Update_achat::somme_ttc($id_facture);
				$Facture = Facture_achat::trouve_par_id($id_facture);
				$table_achats = Update_achat::trouve_achat_notvalide_par_facture($id_facture);
				if (!empty($table_achats)) {
					$last_fournisseur = Update_achat::trouve_last_fournisseur_par_id_facture($id_facture);
					
					}	
			$thisday=date('Y-m-d');
				  ?>
		<div class="show-facture">
		</div>
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-8">
<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>


                                <div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								achat
							</div>
						</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
						
										   <div class="panel-body">                                                                        
                                    
										   <div class="row">
                                        <div class="col-md-4">
                                        	<div class="form-group ">
                                                <label class="col-md-3 control-label "> Fournisseur </label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control select2me"    name="id_fournisseur" id="id_fournisseur"  placeholder="Choisir fournisseur" >
													
															<option value=""></option>
														<?php  foreach ($fournisseurs as $fournisseur) { ?>
																<option <?php if (isset($last_fournisseur->id_fournisseur)) {
																		if ($last_fournisseur->id_fournisseur == $fournisseur->id_fournisseur) {echo "selected";}
																	} ?> value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>"><?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?> </option>
																<?php } ?>	
																	   
														</select>   
														<div class="form-control-focus">
														</div>
                                                 
													
                                                </div>
												  
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-3 control-label">Date facturation </label>
													<div class="col-md-9">
														
															<input type="date" name = "date_fact" id="date_fact" class="form-control" placeholder="Date " value="<?php if (isset($Facture->date_fac)) {echo $Facture->date_fac;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
										<div class="col-md-4">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-3 control-label">Référence </label>
													<div class="col-md-9">
														
															<input type="text" id="Reference" class="form-control " name="Reference"  value="<?php if (isset($Facture->Num_facture)) {echo $Facture->Num_facture;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
                                	   </div>
                                 </div>	
                                    

                                		   </div>
                               
												
												
											</div>
											
										
										<!-- END FORM-->
									
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Listes
							</div>
						</div>
						<div class="portlet-body notification">
						<table class="table table-striped table-bordered table-hover" id="table_1" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								
								<th>
									 Quantité 
								</th>
								<th>
									  PU 
								</th>
								<th>
									 Remise
								</th>
								<th>
									 TVA
								</th>
								<th>
									HT
								</th>
								<th>
									T.TVA 
								</th>
								
								<th>
									TOTAL  
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_achats as $table_achat){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($table_achat->Designation)) {
										echo $table_achat->Designation.' | '.$table_achat->Code;
									} ?>
								</td>
								
								
								<td>
									<?php if (isset($table_achat->Quantite)) {
										echo $table_achat->Quantite;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo $table_achat->Prix;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Remise)) {
										echo $table_achat->Remise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Ttva)) {
										echo ($table_achat->Ttva *100).' %';
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Ht)) {
										echo $table_achat->Ht;
									} ?>
									
								</td>
								
								<td>
									<?php if (isset($table_achat->Tva)) {
										echo $table_achat->Tva;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->total)) {
										echo $table_achat->total;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_achat->id)){ echo $table_achat->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							<tbody>
								
							<tr class="info-prodact" >
								
								<td>
									<select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
															<option value=""></option>
														<?php  foreach ($Articles as $Article) {
                                                            $stock_prod = Produit::Calcul_stock_par_id($Article->id_pro); ?>
                                                                    <option  value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$stock_prod->stock ;} ?> </option>
                                                                <?php } ?> 														   
														</select>   
								</td>
								
								<td>
									
								</td>
								
								<td>
									 
								</td>
								<td>
	
								</td>
								
								<td>
	
								</td>
								<td>
									
								</td>
								<td>
									
								</td>
								<td>
									

								</td>

								<td>
									<button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2" id="TOTALHT" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; "><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2" id="TOTALTVA" style= "font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2" id="TOTALTTC" style="font-size: 18px;" ><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> DA</td>
							    </tr>
										
                            </tbody>
							</table>
							
						</div>
							<div class="panel-footer " align="right">   
								<input type="text"  id="id_facture"  value="<?php echo $id_facture; ?>" class="hidden">
							<a id="update_paiement_achat" disabled class="btn  green " data-target="#update-paiment_achat"  > <i class="fa fa-credit-card"></i>  Enregistrer un paiement </a>
						    </div>	

						</div>
					
				</div>
				<div class="col-md-4 list-group-item bg-blue-ebonyclay">
					
							<p>Scan du Facture Achat</p>
				
				</div>
				<div class="col-md-4 list-group-item bg-blue-chambray margin-bottom-30">
				<?php
					if (isset($Facture->facture_scan)) {
					
					 
					 $img_select = Upload::trouve_par_id ($Facture->facture_scan);
					  
					}else{
							echo '<p> aucune facture sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($Facture->facture_scan)){?>
				
					
					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" class="img-responsive fancybox-button "><img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   ></a>
					<a href="#form_modal10" data-toggle="" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
						<a href="#form_modal10" data-toggle="" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
						<a href="#form_modal10" data-toggle="" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
				
				<?php }else {echo '<a href="#form_modal10" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>	
			</div>
		</div>
		<?php } else if ($action=='edit_vente') { 

				$Truncate_table = Update_vente::truncate_table($id_facture);
				$last_update = Update_vente::trouve_last_update_par_id_facture($id_facture);
				if (empty($last_update)) {
				$Insert_achat = Update_vente::insert_vente($id_facture);
				}
	///////////////////////////////////////////////////////////////
				$Articles = Produit::trouve_produit_par_societe($nav_societe->id_societe);
				$clients = Client::trouve_valid_par_societe($nav_societe->id_societe); 	 
				$Somme_ht = Update_vente::somme_ht($id_facture);
				$Somme_tva = Update_vente::somme_tva($id_facture);
				$Somme_ttc = Update_vente::somme_ttc($id_facture);
				$Facture = Facture_vente::trouve_par_id($id_facture);
				$table_vantes = Update_vente::trouve_vente_notvalide_par_facture($id_facture);
				if (!empty($table_vantes)) {
					$last_client = Update_vente::trouve_last_client_par_id_facture($id_facture);
					
					}	
			$thisday=date('Y-m-d'); ?>
		<div class="show-facture">
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-9">
<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>


<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Vente
							</div>
						</div>
					<div class="portlet-body form">
										<!-- BEGIN FORM-->
						
										   <div class="panel-body">                                                                        
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<div class="form-group ">
                                                <label class="col-md-3 control-label "> Client </label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control select2me"    name="id_client" id="id_client"  placeholder="Choisir client" >
													
															<option value=""></option>
														<?php  foreach ($clients as $client) { ?>
																<option <?php if (isset($last_client->id_client)) {
																		if ($last_client->id_client == $client->id_client) {echo "selected";}
																	} ?> value="<?php if(isset($client->id_client)){echo $client->id_client; } ?>"><?php if (isset($client->id_client)) {echo $client->nom;} ?> </option>
																<?php } ?>	
																	   
														</select>   
														<div class="form-control-focus">
														</div>
                                                 
													
                                                </div>
												  
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                    		
                                            <div class="form-group ">
													<label class="col-md-3 control-label">Date facturation </label>
													<div class="col-md-9">
														
															<input type="date" name = "date_fact" id="date_fact" class="form-control" placeholder="Date " value="<?php if (isset($last_client->date_fact)) {echo $last_client->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
                                </div>

												
											</div>	
											</div>
											
										
										<!-- END FORM-->
									</div>
									<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Listes
							</div>
						</div>
						<div class="portlet-body notification table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="30%">
									Désignation
								</th>
								<th width="15%">
									Lot
								</th>
								<th>
									 Qté 
								</th>
								<th>
									  PU 
								</th>
								<th>
									 Remise
								</th>
								<th>
									 TVA
								</th>
								<th>
									HT
								</th>
								<th>
									T.TVA 
								</th>
								
								<th>
									TOTAL  
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_vantes as $table_vante){ $cpt ++; ?>
							<tr class="item-row" >
								
								<td>
									<?php if (isset($table_vante->Designation)) {
										echo $table_vante->Designation.' | '.$table_vante->Code;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->id_lot)) {
										if ($table_vante->id_lot == 0) {
											echo "/";
										}else{
										$lot = $Lot_prod=Lot_prod::trouve_par_id($table_vante->id_lot);
										if (isset($Lot_prod->id)) {
											echo $Lot_prod->code_lot;
										}
										}
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Quantite)) {
										echo $table_vante->Quantite;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Quantite)) { echo $table_vante->Quantite ; } ?>"  class="hidden qty">
								</td>
								<td>
									<?php if (isset($table_vante->Prix)) {
										echo $table_vante->Prix;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Prix)) { echo $table_vante->Prix ; } ?>"  class="hidden price">
								</td>
								<td>
									<?php if (isset($table_vante->Remise)) {
										echo $table_vante->Remise;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Remise)) { echo $table_vante->Remise ; } ?>"  class="hidden remise">
								</td>
								<td>
									<?php if (isset($table_vante->Ttva)) {
										echo ($table_vante->Ttva *100).' %';
									} ?>
									 <input type="text" value="<?php if (isset($table_vante->Ttva)) { echo $table_vante->Ttva ; } ?>"  class="hidden tva_prod">
								</td>
								<td class="HT">
									<?php if (isset($table_vante->Ht)) {
										echo $table_vante->Ht;
									} ?>
									
								</td>
								
								 <td class="TVA">
									<?php if (isset($table_vante->Tva)) {
										echo $table_vante->Tva;
									} ?>
								</td>
								<td class="TTC">
									<?php if (isset($table_vante->total)) {
										echo $table_vante->total;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_vante->id)){ echo $table_vante->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							</tbody>
							<tbody>
								
							<tr class="info-prodact" >
								
								<td>
									<select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
															<option value=""></option>
														<?php  foreach ($Articles as $Article) {
                                                            $stock_prod = Produit::Calcul_stock_par_id($Article->id_pro); ?>
                                                                    <option  value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$stock_prod->stock ;} ?> </option>
                                                                <?php } ?> 														   
														</select>   
								</td>
								
								<td>
									
								</td>
								<td>
									 
								</td>
								<td>
									
								</td>
								<td>
									 
								</td>
								<td>
									
								</td>
								
								<td>
									
								</td>
								<td>
									
								</td>
								<td>
									
								</td>

								<td>
									<button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2" id="TOTALHT" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> </td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> REMISE : </strong></span></td>
									<td colspan="2" id="REMISE_ht" style="font-size: 18px;">0.00</td>
							    </tr>

							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT APRES REMISE : </strong></span></td>
									<td colspan="2" id="TOTALHT_R" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> </td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; "><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2" id="TOTALTVA" style= "font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?>
									
									 </td>
							    </tr>
							    <tr>
							    	

									<td colspan="8" ><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2" id="TOTALTTC" style="font-size: 18px;" ><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> 
									 </td>
									 <input type="hidden" id="TOTALTTC1" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> ">
									 <input type="hidden" id="TOTALTVA1" value="<?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> ">
									 <input id="last_tva" type="hidden" value="<?php echo $last_client->Ttva; ?>">
							    </tr>

										
                          			  </tbody> 
							</table>
							<br>
							<div class="TTC-proposer">
							<table class="table table-striped table-bordered table-hover "  >
											<tr   >
												<td colspan="8" width="81.5%" ><span style="float : right;   font-size: 18px; ;"><strong> TTC proposer :  </strong></span></td>
												<td colspan="2" ><input id="TTC_propose" disabled type="number" min="0" value="<?php if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} ?>"  class="form-control input-small " ></td>
											</tr>
							</table>
							
						</div>
						</div>
							<div class="panel-footer " align="right"> 
								<input type="text"  id="id_facture"  value="<?php echo $id_facture; ?>" class="hidden">
								<button id="reset_total"  class="btn red"><i class="fa fa-refresh"></i> Réinitialiser TTC </button>
							<a id="update_paiement" disabled class="btn  green " data-target="#update-paiment"  > <i class="fa fa-credit-card"></i>  Enregistrer un paiement </a>
						    </div>	

						
								</div>
				</div>
				<div class="col-md-3 list-group-item bg-blue-chambray margin-bottom-30">
					<div class=" bg-blue-ebonyclay">
					
							<p>Scan du Facture Vente</p>
				
				</div>
				<?php
					if (isset($Facture->facture_scan)) {
					
					 
					 $img_select = Upload::trouve_par_id ($Facture->facture_scan);
					  
					}else{
							echo '<p> aucune facture sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($Facture->facture_scan)){
				
					$info = new SplFileInfo($img_select->img);
					$errors[]= '  Lot deja consommé !';
					if($info->getExtension() == 'pdf'){?>
					
					<object data="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" type="application/pdf" width="100%" height="1000">
					<?php if (!empty($msg_error)) {?>
						<object data="assets/image/test.pdf" type="application/pdf" width="100%" height="1000">
						alt : <a href="assets/image/test.pdf">test.pdf</a>
						</object> 
						<?php }?>
					</object>

						<?php }else {?>
							

					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" class="img-responsive fancybox-button "><img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   ></a>
				
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
					
								<?php }?>
	
				
				
				<?php }else {echo '<a href="#form_modal11" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>

						</div>


		

				
				
					

		</div>
			<?php  } else if ($action=='upload') {
			
					if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
						$id = $_GET['id']; 
						$Upload = Facture_vente:: trouve_par_id($id);
						 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
							 $id = $_POST['id'];
						$Upload = Facture_vente:: trouve_par_id($id);
						 } else { 
								$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
							} 
					?>

				<div class="row profile">
				<div class="col-md-12">
									<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>


                           
			<div class="col-md-12">
				<?php
					$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); 
					$cpt = 0;
				?>					

                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption bold">
											<i class="fa  fa-folder font-yellow "></i> Dossier sacan
										</div>

									</div>
							<div class="row">
							
							<?php  $file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
							?>
								<div class="col-sm-1 col-md-1">
								<form action="<?php echo $_SERVER['PHP_SELF']?>?action=upload" method="POST" class="form-horizontal" enctype="multipart/form-data">
									<a href="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>"  class="fancybox-button" data-rel="fancybox-button" alt ="">
									<img src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>"  style="height: 107px; width: 107px; display: block;" class="img-responsive" >
										<input type="hidden" name="id_scan" value="<?php echo $ScanImage->id ;?>" /> 								
									</a>
									<button type="submit" name = "submit" class="btn btn-sm btn-block">sélectionner</button>
									<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
									<hr>
								</form>
								</div>
								
						<?php }?>
					
							</div>
							
					</div>
			</div>
		</div>
			<!-- END upload file-->
				<?php  } else if ($action=='upload_achat') {
			if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
						$id = $_GET['id']; 
						$Upload_achat = Facture_achat:: trouve_par_id($id);
						 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
							 $id = $_POST['id'];
						$Upload_achat = Facture_achat:: trouve_par_id($id);
						 } else { 
								$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
							} 
					
					?>

			<div class="row profile">
	
			<div class="col-md-12">
				<?php
					$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); 
					$cpt = 0;
				?>					

                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption bold">
											<i class="fa  fa-folder font-yellow "></i> Dossier sacan
										</div>

									</div>
							<div class="row">
							
							<?php  $file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
							?>
								<div class="col-sm-1 col-md-1">
								<form action="<?php echo $_SERVER['PHP_SELF']?>?action=upload_achat" method="POST" class="form-horizontal" enctype="multipart/form-data">
									<a href="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>"  class="fancybox-button" data-rel="fancybox-button" alt ="">
									<img src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>"  style="height: 107px; width: 107px; display: block;" class="img-responsive" >
										<input type="hidden" name="id_scan" value="<?php echo $ScanImage->id ;?>" /> 								
									</a>
									<button type="submit" name = "submit" class="btn btn-sm btn-block">sélectionner</button>
									<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
									<hr>
								</form>
								</div>
								
						<?php }?>
					
							</div>
							
					</div>
			</div>
		</div>
			<!-- END upload file-->
	<?php } elseif ($action=='list_depense'){
			if (isset($_POST['submit']) ) {
				
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$list_depenses = Facture_depense::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				
				}else{
					$list_depenses = Facture_depense::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}
	?>
		<div class="row">
			<div class="col-md-12">
			<div class="notification"></div>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>Dépenses
							</div>
						</div>
			<div class="table-toolbar">
				<div class="col-md-8">
										
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=list_depense" method="POST" class="form-horizontal">

										<div class="row">
												<div class="col-md-4">
												<div class="form-group">
													<label class="col-md-3 control-label">Du</label>
														<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut)){echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>					
														</div>
												</div>
											</div>	
											<div class="col-md-4">													
												<div class="form-group">
													<label class="col-md-3 control-label">au</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin)){echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
											</div>
											
										
													<div class="col-md-4">
														<button type="submit" name = "submit" class="btn green">Chercher</button>
														
													</div>
												
										</div>
										</form>
										<!-- END FORM-->
											
				</div>
				<div class="col-md-4 pull-right">
				<a  href="operation.php?action=add_fact_depense"  data-toggle="" class="btn blue"  ><i class="fa  fa-plus "></i> Nouveau Facture Dépense</a>
				<a  href="operation.php?action=add_depense" class="btn red "  ><i class="fa  fa-plus "></i> Créer Dépense</a>
				</div>
							
				<div class="portlet-body">			
				
			
						<table class="table table-striped  table-hover " id="sample_2" >
							<thead>
							<tr>
								<th>
									Réf 
								</th>
								<th>
									Date 
								</th>
								<th>
									Dépense 
								</th>
								<th>
									Fournisseur 
								</th>
								<th>
									HT 
								</th>
								<th>
									TVA 
								</th>
								<th>
									timbre 
								</th>
								<th>
									TTC 
								</th>
								<th>
									Scan 
								</th>
								<th>
									#
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($list_depenses as $list_depense){
									
								?>
							<tr id="fact_<?php echo $list_depense->id; ?>">
								
								
								<td>
									
									<?php if (isset($list_depense->reference)) {
										echo '<i class="fa fa-file font-yellow"></i> ' . $list_depense->reference ;
									 } ?>
									
                                   
								</td>
								<td>
									<?php if (isset($list_depense->date_fact)) {
									echo $list_depense->date_fact;
									} ?>
								</td>
								<td>
									<?php if (isset($list_depense->id_depense)) {
										$depenses = Depense::trouve_par_id($list_depense->id_depense);
									echo '<i class="fa fa-dollar font-yellow"></i> ' . $depenses->depense;
									} ?>
								</td>
								<td>
									<?php if (isset($list_depense->id_fournisseur)) {
										$fournisseur = Fournisseur::trouve_par_id($list_depense->id_fournisseur);
									echo '<i class="fa fa-user font-yellow"></i> ' . $fournisseur ->nom;
									} ?>
								</td>								
								<td>
								<?php if (isset($list_depense->ht)) {
									$total_somme_ht +=$list_depense->ht;
									echo $list_depense->ht;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->tva)) {
									$total_somme_tva +=$list_depense->tva;
									echo $list_depense->tva;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->timbre)) {
									$total_timbre +=$list_depense->timbre;
									echo $list_depense->timbre;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->ttc)) {
									$total_somme_ttc +=$list_depense->timbre;
									echo $list_depense->ttc;
									} ?>
								</td>
								<td>
									<?php if (!empty($list_depense->facture_scan)) {
										 $file = str_replace (" ", "_", $nav_societe->Dossier );
										 $ScanImage = Upload::trouve_par_id($list_depense->facture_scan);
									echo '<a href="scan/upload/'.$file.'/'.$ScanImage->img .'" class="btn bg-green-jungle fancybox-button btn-xs" ><i class="fa fa-eye"></i></a>';
									
									} ?>
									
								</td>
								
							
							<td>									
									<a href="operation.php?action=edit_fact_depense&id=<?php echo $list_depense->id; ?>" class="btn blue btn-xs">
                                            <i class="fa fa-edit "></i> </a>
									<button id="del_fact_depense" value="<?php echo $list_depense->id; ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_fact_depense" data-toggle="modal"></i> </button>
									
								</td>
							</tr>
							<?php
								}
							?>
							
						
							</tbody>
							<tbody>
								<td colspan="3"></td>
								<td > <span style="float : left;   font-size: 18px; ;"><strong> TOTAUX: </strong></span></td>
								<td>  <strong><?php echo number_format($total_somme_ht , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_tva , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_timbre , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_ttc , 2, ',', ' '); ?></strong></td>

								<td></td>
								<td></td>
							</tbody>
							
							</table>
							<a href="print.php?action=print_depense&date_db=<?php echo $date_db;?>&date_fin=<?php echo $date_fin;?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Imprimer</a>
						
						</div>
					</div>
				</div>
					
			</div>
			
		</div>
				<?php } elseif ($action=='add_fact_depense'){
		
				
				?>
		<div class="row">
		
			<div class="col-md-8">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-plus font-yellow"></i> Nouveau facture depense
							</div>
						</div>
				
							
				<div class="portlet-body">
					<!-- BEGIN FORM-->
					<form   id="depense_form"   class="form-horizontal" enctype="multipart/form-data">				
			<div class="row">
			<div class="panel-body"> 
				<input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe; } ?>">	   
				<input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">
                      <div class="row">
                         <div class="col-md-5">
                                        	
                          <label class="col-md-4 control-label "> Fournisseur <span class="required" aria-required="true"> * </span> </label>
                             <div class="col-md-6">                                                                                            
                                              
								<select class="form-control select2me"    name="id_fournisseur" id="id_fournisseur"  placeholder="Choisir fournisseur" >
								
								<option value=""></option>
									<?php 
											$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 
										foreach ($fournisseurs as $fournisseur) { ?>
										<option <?php if ($edit_fact->id_fournisseur == $fournisseur->id_fournisseur) {echo "selected";}?>
										 value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>"><?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?> </option>
									<?php } ?>	
										
																	   
							</select>   
									<div class="form-control-focus">
									</div>
                                                 
													
                          </div>
												  
                                           
                                        </div>
                                        <div class="col-md-3">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-4 control-label">Date <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-8">
														
															<input type="date" name = "date_fact" id="date_fact"  class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
										<div class="col-md-4">
											<div class="form-group ">
													<label class="col-md-4 control-label">Référence <span class="required" aria-required="true"> * </span> </label>
													<div class="col-md-8">
														
															<input type="text" id="reference" class="form-control "  name="reference" placeholder="FACT0001/21"   required />
															
														</div>
														
													</div>

										</div>
                                	   </div>
                                 </div>
				<div class="portlet light ">
						<div class=" notification "></div>
						<div class="portlet-body  table-responsive">
						<table class="table table-striped table-bordered table-hover" id="" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								<th>
									HT
								</th>
								<th>
									 TVA
								</th>
								<th>
									  Timbre 
								</th>

								<th>
									TOTAL  TTC 
								</th>
								
							</tr>
							</thead>
							<tbody>
								
							<tr id="fact_depense" >
								<td>
									<select class="form-control  select2me"   id="id_depense"  name="id_depense"   placeholder="Selctionner depense" >
										<option value=""></option>
										<?php

										$depenes = Depense::trouve_depense_par_societe($nav_societe->id_societe);
		
										foreach($depenes as $dep){ ?>
										<option <?php if ($edit_fact->id_depense == $dep->id) {echo "selected";}?>
										 value="<?php if(isset($dep->id)){echo $dep->id; } ?>"><?php if (isset($dep->depense)) {echo $dep->depense;} ?> </option>
											
											<?php } ?>														   
									</select>   
								</td>
								
								<td>
									
									<input type="number"  name="ht"  id="ht" min="0" class="form-control depense" required />
								</td>
								<td >
									
									<input type="number" class="form-control depense "   id="tva"  name="tva" min="0"    required />
								 
								</td>
								<td >
								
									<input type="number"  name="timbre"  id="timbre" min="0" class="form-control depense" required />
								</td>
								
								
								<td >
									<input type="number"  name="ttc" id="ttc_depence"  value="0.00"   readonly class="form-control ttc" />
								</td>
								
								
							</tr>
						
						
							</tbody>
							
							
							</table>
							
						</div>
						<input type="hidden" name="facture_scan" value="<?php if (isset($_GET['id_img'])) {	 $image =  htmlspecialchars($_GET['id_img']) ; echo  $image ; }?>" />
							<div class="panel-footer " align="right">   
								<button id="Enregistrer_depence" class="btn  green " data-target="#add-depense" data-toggle="modal"> <i class="fa fa-credit-card"></i>  Enregistrer un paiement </button> 
								
								
						    </div>	

						</div>
		
					</div>
				</form>	
					<!-- END FORM-->
			
				</div>
				</div>
					
			</div>
					<div class="col-md-4 list-group-item bg-blue-chambray margin-bottom-30">
					<div class=" bg-blue-ebonyclay">
					
							<p>Scan du Facture Depense</p>
				
				</div>
				<?php
					if (isset($_GET['id_img'])) {
					 $image =  htmlspecialchars($_GET['id_img']) ;
					 
					 $img_select = Upload::trouve_par_id ($image);
					  
					}else{
							echo '<p> aucune facture sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($image)){
				
					$info = new SplFileInfo($img_select->img);
					$errors[]= 'VIDE !';
					if($info->getExtension() == 'pdf'){?>
					
					<object data="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" type="application/pdf" width="100%" height="1000">
					<?php if (!empty($msg_error)) {?>
						<object data="assets/image/test.pdf" type="application/pdf" width="100%" height="1000">
						alt : <a href="assets/image/test.pdf">test.pdf</a>
						</object> 
						<?php }?>
					</object>

						<?php }else {?>
							

					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" class="img-responsive fancybox-button "><img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   ></a>
				
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
					
								<?php }?>
	
				
				
				<?php }else {echo '<a href="#form_modal12" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>
			
		</div>
		<?php } elseif ($action=='edit_fact_depense'){
			if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
				$id = $_GET['id']; 
			   $edit_fact = Facture_depense:: trouve_par_id($id);
				} elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
					$id = $_POST['id'];
			   $edit_fact = Facture_depense:: trouve_par_id($id);
				} else { 
					   $msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
				   } 
				
				?>
		<div class="row">
		
			<div class="col-md-8">
			<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-pencil font-yellow"></i> Edit facture depense
							</div>
						</div>
				
							
				<div class="portlet-body">
					<!-- BEGIN FORM-->
			<form   id="update_depense_form"  class="form-horizontal" enctype="multipart/form-data">				
			<div class="row">
			<div class="panel-body"> 
				<input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe; } ?>">	   
				<input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">
                      <div class="row">
                         <div class="col-md-5">
                                        	
                          <label class="col-md-4 control-label "> Fournisseur <span class="required" aria-required="true"> * </span> </label>
                             <div class="col-md-6">                                                                                            
                                              
								<select class="form-control select2me"    name="id_fournisseur" id="id_fournisseur"  placeholder="Choisir fournisseur" >
								
								<option value=""></option>
									<?php 
											$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 
										foreach ($fournisseurs as $fournisseur) { ?>
										<option <?php if ($edit_fact->id_fournisseur == $fournisseur->id_fournisseur) {echo "selected";}?>
										 value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>"><?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?> </option>
									<?php } ?>	
										
																	   
							</select>   
									<div class="form-control-focus">
									</div>
                                                 
													
                          </div>
												  
                                           
                                        </div>
                                        <div class="col-md-3">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-4 control-label">Date <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-8">
														
															<input type="date" name = "date_fact" id="" value="<?php if (isset($edit_fact->date_fact)){ echo $edit_fact->date_fact;}?>" class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
										<div class="col-md-4">
											<div class="form-group ">
													<label class="col-md-4 control-label">Référence <span class="required" aria-required="true"> * </span> </label>
													<div class="col-md-8">
														
															<input type="text" id="" class="form-control " value="<?php if (isset($edit_fact->reference)){ echo $edit_fact->reference;}?>" name="reference" placeholder="FACT0001/21"   required />
															
														</div>
														
													</div>

										</div>
                                	   </div>
                                 </div>
				<div class="portlet light ">
						<div class=" notification "></div>
						<div class="portlet-body  table-responsive">
						<table class="table table-striped table-bordered table-hover" id="" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								<th>
									HT
								</th>
								<th>
									 TVA
								</th>
								<th>
									  Timbre 
								</th>

								<th>
									TOTAL  TTC 
								</th>
								
							</tr>
							</thead>
							<tbody>
								
							<tr id="fact_depense" >
								<td>
									<select class="form-control  select2me"   id=""  name="id_depense"   placeholder="Selctionner depense" >
										<option value=""></option>
										<?php

										$depenes = Depense::trouve_depense_par_societe($nav_societe->id_societe);
		
										foreach($depenes as $dep){ ?>
										<option <?php if ($edit_fact->id_depense == $dep->id) {echo "selected";}?>
										 value="<?php if(isset($dep->id)){echo $dep->id; } ?>"><?php if (isset($dep->depense)) {echo $dep->depense;} ?> </option>
											
											<?php } ?>														   
									</select>   
								</td>
								
								<td>
									
									<input type="number"  name="ht" value="<?php if (isset($edit_fact->ht)){ echo $edit_fact->ht;}?>" id="ht" min="0" class="form-control depense" required />
								</td>
								<td >
									
									<input type="number" class="form-control depense " value="<?php if (isset($edit_fact->tva)){ echo $edit_fact->tva;}?>"  id="tva"  name="tva" min="0"    required />
								 
								</td>
								<td >
								
									<input type="number"  name="timbre" value="<?php if (isset($edit_fact->timbre)){ echo $edit_fact->timbre;}?>" id="timbre" min="0" class="form-control depense" required />
								</td>
								
								
								<td >
									<input type="number"  name="ttc" id="ttc_depence"  value="<?php if (isset($edit_fact->ttc)){ echo $edit_fact->ttc;}?>"  readonly class="form-control ttc" />
								</td>
								
								
							</tr>
						
						
							</tbody>
							
							
							</table>
							
						</div>
						<input type="hidden" name="facture_scan" value="<?php if (isset($edit_fact->facture_scan)) {	 echo htmlspecialchars($edit_fact->facture_scan) ;  }?>" />
							<div class="panel-footer " align="right">   
								<a  class="btn  green" id="update_depense" > <i class="fa fa-check "></i>  Modifier Facture </a>
								<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
						    </div>	

						</div>
		
					</div>
				</form>	
					<!-- END FORM-->
			
				</div>
				</div>
					
			</div>
			<div class="col-md-4 list-group-item bg-blue-chambray margin-bottom-30">
				<?php
					if (!empty($edit_fact->facture_scan)) {
					
					 
					 $img_select = Upload::trouve_par_id ($edit_fact->facture_scan);
					  
					}else{
							echo '<p> aucune facture sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($edit_fact->facture_scan)){
				
					$info = new SplFileInfo($img_select->img);
					$errors[]= 'VIDE !';
					if($info->getExtension() == 'pdf'){?>
					
					<object data="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" type="application/pdf" width="100%" height="1000">
					<?php if (!empty($msg_error)) {?>
						<object data="assets/image/test.pdf" type="application/pdf" width="100%" height="1000">
						alt : <a href="assets/image/test.pdf">test.pdf</a>
						</object> 
						<?php }?>
					</object>

						<?php }else {?>
							

					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" class="img-responsive fancybox-button "><img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   ></a>
				
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
					
								<?php }?>
	
				
				
				<?php }else {echo '<a href="#form_modal12" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>
				
			
		</div>
			<?php } elseif ($action=='add_depense'){
				$depenes = Depense::trouve_depense_par_societe($nav_societe->id_societe);
				?>
		<div class="row">
		<div class="col-md-6">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>Dépenses
							</div>
						</div>
				
							
				<div class="portlet-body">
					
						 <table class="table table-striped  table-hover ">
							<thead>
							<tr>
								
								<th>
									Dépense 
								</th>
								<th>
									Comptes dépense 
								</th>
								<th>
									Auxiliere dépense 
								</th>
								
								<th>
									#
								</th>
								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($depenes as $depene){
									
								?>
							<tr id="fact_<?php echo $depene->id; ?>">
								
								
								<td>
									<a>
									
								
									<?php if (isset($depene->depense)) {
										echo '<i class="fa  fa-dollar font-yellow "></i> ' .$depene->depense ;
									 } ?>
									
                                   </a>
								</td>
								<td>
									<?php if (isset($depene->comptes_depense)) {
									$Comptes = Compte_comptable::trouve_compte_par_id_compte($depene->comptes_depense);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
								<?php if (isset($depene->auxiliere_depense)) {
									$auxilieres = Auxiliere::trouve_par_id($depene->auxiliere_depense);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>	
								</td>
								<td>									
									<a href="operation.php?action=edit_depense&id=<?php echo $depene->id; ?>" class="btn blue btn-xs">
                                            <i class="fa fa-edit "></i> </a>
                                    <button id="del_depense" value="<?php echo $depene->id; ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_depense" data-toggle="modal"></i> </button>
									
								</td>
								
							</tr>
							
							
							<?php
								}
							?>
							
						
							</tbody>
							
							</table>
						</div>
				</div>
					
			</div>
			<div class="col-md-6">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i> Créer Dépense
							</div>
						</div>
				
							
				<div class="portlet-body">
					<!-- BEGIN FORM-->
					<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_depense" method="POST" class="form-horizontal" enctype="multipart/form-data">
						<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label">Dépense <span class="required" aria-required="true"> * </span></label>
							<div class="col-md-6">
								<div class="input-group">
								<input type="text" name = "depense" class="form-control" placeholder="dépense" required>
								
							</div>

						</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Compte Dépense <span class="required" aria-required="true"> * </span></label>
								<div class="col-md-4">
								<div class="input-group">
														
								<select class="form-control" id="comptes_depense"  name="comptes_depense">
												
									<?php 															
									$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
										foreach($Comptes as $Compte){?>

										<option  value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
										<?php } ?>															   
								</select>
												
								</div>
								</div>
								<div class="form-group auxiliere_depense">
													
								</div>
													
						</div>
						</div>
						<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" name = "submit" class="btn green">Ajouter</button>
								<button type="reset" class="btn  default">Annuler</button>
							</div>
						</div>
						</div>
					</form>
					<!-- END FORM-->
			
				</div>
				</div>
					
			</div>
			
		</div>
		<?php } elseif ($action=='edit_depense'){
				
				?>
		<div class="row">
		
			<div class="col-md-6">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-pensil font-yellow"></i> Edit Dépense
							</div>
						</div>
				
							
				<div class="portlet-body">
					<!-- BEGIN FORM-->
					<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit_depense" method="POST" class="form-horizontal" enctype="multipart/form-data">
						<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Dépense <span class="required" aria-required="true"> * </span></label>
							<div class="col-md-6">
								<div class="input-group">
								<input type="text" name = "depense" value ="<?php if (isset($depenses->depense)){ echo html_entity_decode($depenses->depense); } ?>" class="form-control"  required>
								
							</div>

						</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Compte Dépense <span class="required" aria-required="true"> * </span></label>
								<div class="col-md-4">
								<div class="input-group">
														
								<select class="form-control" id="comptes_depense"  name="comptes_depense">
												
									<?php 															
										$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
											foreach($Comptes as $Compte){?>

											<option <?php if ($Compte->id == $depenses->comptes_depense) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
										<?php } ?>																   
								</select>
												
								</div>
								</div>
								<div class="form-group auxiliere_depense">
								<div class="col-md-2">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($depenses->comptes_depense);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_depense"  name="auxiliere_depense">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $depenses->comptes_depense) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
															<?php } 	}	else {?>
																
																<option>  </option>
														<?php	}?>											
														
																												   
														</select>
														<span class="input-group-addon ">
															AUX
															</span>	
														</div>

													</div>
													
								</div>
													
						</div>
						</div>
						<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" name = "submit" class="btn green">Ajouter</button>
								<button type="reset" class="btn  default">Annuler</button>
								<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
							</div>
						</div>
						</div>
					</form>
					<!-- END FORM-->
			
				</div>
				</div>
					
			</div>
			
		</div>
	<?php } elseif ($action=='depense'){
		$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 
		$depenes = Depense::trouve_depense_par_societe($nav_societe->id_societe);
		$thisday=date('Y-m-d');		
		?>
		<div class="row">
		<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<?php 
					if (!empty($msg_error)){
						echo error_message($msg_error); 
					}elseif(!empty($msg_positif)){ 
						echo positif_message($msg_positif);	
					}elseif(!empty($msg_system)){ 
						echo system_message($msg_system);
				} ?>


                        <div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-blue bold">
										Dépense
									</div>
								</div>
							<div class="portlet-body form">
										<!-- BEGIN FORM-->
										
							<form action="<?php echo $_SERVER['PHP_SELF']?>?action=depense" method="POST" class="form-horizontal" enctype="multipart/form-data">
						
								 <div class="panel-body">                                                                        
                                    <div class="row">
                                        <div class="col-md-4">
                                        	<div class="form-group ">
                                                <label class="col-md-3 control-label "> Fournisseur <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8">                                                                                            
                                              
												<select class="form-control select2me"    name="id_fournisseur" id="id_fournisseur"  placeholder="Choisir fournisseur" >
													
															<option value=""></option>
														<?php  foreach ($fournisseurs as $fournisseur) { ?>
																<option <?php if (isset($last_fournisseur->id_fournisseur)) {
																		if ($last_fournisseur->id_fournisseur == $fournisseur->id_fournisseur) {echo "selected";}
																	} ?> value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>"><?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?> </option>
																<?php } ?>	
																	   
														</select>   
														<div class="form-control-focus">
														</div>
                                                 
													
                                                </div>
												  
                                            </div> 
                                        </div>
                                        <div class="col-md-3">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-3 control-label">Date </label>
													<div class="col-md-9">
														
															<input type="date" name = "date_fact" id="" value="<?php echo $thisday;?>"class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
										<div class="col-md-5">
											<div class="form-group ">
													<label class="col-md-3 control-label">Référence <span class="required" aria-required="true"> * </span> </label>
													<div class="col-md-9">
														
															<input type="text" id="" class="form-control " name="reference" placeholder="FACT0001/21"   required />
															
														</div>
														
													</div>

										</div>
                                	   </div>
                                 </div>
							</div>
						</div>
											
						
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Listes
							</div>
						</div>
						<div class="portlet-body notification table-responsive">
						<table class="table table-striped table-bordered table-hover" id="table_1" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								<th>
									HT
								</th>
								<th>
									 TVA
								</th>
								<th>
									  Timbre 
								</th>

								<th>
									TOTAL  TTC 
								</th>
								
							</tr>
							</thead>
							<tbody>
								
							<tr id="fact_depense" >
								<td>
									<select class="form-control  select2me"   id=""  name="id_depense"   placeholder="Selctionner depense" >
										<option value=""></option>
										<?php foreach($depenes as $depene){ ?>
															<option value="<?php if(isset($depene->id)){echo $depene->id; } ?>"><?php if (isset($depene->depense)) { echo $depene->depense; } ?> </option>
																<?php } ?>														   
														</select>   
								</td>
								
								<td>
									
									<input type="number"  name="ht" id="ht" min="0" class="form-control depense" required />
								</td>
								<td >
									
									<input type="number" class="form-control depense "   id="tva"  name="tva" min="0"    required />
								 
								</td>
								<td >
								
									<input type="number"  name="timbre" id="timbre" min="0" class="form-control depense" required />
								</td>
								
								
								<td >
									<input type="number"  name="ttc" id="ttc"  value="00.00" readonly class="form-control" />
								</td>
								
								
							</tr>
						
						
							</tbody>
							
							
							</table>
							
						</div>
							<div class="panel-footer " align="right">   
								<button  class="btn  green " type="submit" name="submit"  > <i class="fa fa-check "></i>  Enregistrer Facture </button>
								<button type="reset" class="btn  default">Annuler</button>
						    </div>	

						</div>
					</form>
			</div>

			
		</div>
 <?php	}} ?>
		
	</div>
	</div>
	</div>
			</div>
	<!-- END CONTENT -->
					<div id="form_modal11" class="modal container fade" tabindex="-1">
				
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Sélectionner une image</h4>
										</div>
										<div class="modal-body">
								
							<div class="row">
			<?php
					$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); 
					$cpt = 0;
					$file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
				?>
			<div class="col-md-4 ">
				<!-- BEGIN WIDGET THUMB -->
				
				<div class="widget-thumb widget-bg-color-white text-uppercase rounded-3 margin-bottom-30 portlet light bordered ">
				<a  href="operation.php?action=vente&id_img=<?php echo $ScanImage->id;  ?>" class="fancybox-button" data-rel="fancybox-button"   >
					<div class="widget-news ">
						<?php 
					$info = new SplFileInfo($ScanImage->img);
					
					if($info->getExtension() == 'pdf'){?>
						<img class="widget-news-left-elem" src="assets/image/pdf-icon.png" alt="" style="width: 80px; height: 80px;"  >
						<?php }else {?>
							<img class="widget-news-left-elem" src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>" alt="" style="width: 80px; height: 80px;"  >
						<?php }?>
						<div class="widget-news-right-body">
							<p><?php echo $file?>/<?php echo $ScanImage->img ;?>
									
							</p>
							<span > <?php echo $thisday;?> </span>
							
						</div>
						
					</div>
					</a>
				</div>
				
				<!-- END WIDGET THUMB -->
			</div>
			<?php }?>
			</div>
					
										</div>
										<div class="modal-footer">
											<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
											
										</div>
									
			</div>
	<!--  Model achat -->
		

<!-- END CONTAINER -->
	<script>
	////////////////////////////////// onchange depense ///////////////////////////

$(document).on('change','#comptes_depense', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.auxiliere_depense').load('ajax/depense.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});




//////////////////// SAVE update_depense_form////////////////

$(document).on('click','#update_depense', function() {
 
$.ajax({
type: "POST",
url: "ajax/update_depense.php",
data: $('#update_depense_form').serialize(),
success: function(message){
$(".notification").html(message)
},
error: function(){
alert("Error");
}
});

 
});  
  </script>

  <script>
$(document).ready(function(){
 
	
$("#fact_depense").on('input', '.depense', function () {
       var total_sum_depense = 0;
     
       $("#fact_depense .depense").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              total_sum_depense += parseFloat(get_textbox_value);
              }                  
            });
              $("#ttc_depence").val(total_sum_depense);
			 
			  
       });

});
 </script>
 
<?php
require_once("footer/footer.php");
?>