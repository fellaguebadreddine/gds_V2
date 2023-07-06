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
$action ='';
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
     $Fact = Facture_avoir_achat::trouve_par_id($id);
     $date = date_parse($Fact->date_fac);
 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
 	$id = intval($_POST['id']);
 	$Fact = Facture_avoir_achat::trouve_par_id($id);
 	$date = date_parse($Fact->date_fac);
	 
 }
////////////////////////////// remove old Quantité of achat from Articles and delete achat from table ACHAT ///////////////////////
				$table_achats = Achat::trouve_achat_par_facture($id);
				foreach($table_achats as $table_achat){ 
			 	$Article = Produit::trouve_par_id($table_achat->id_prod);
				if (empty($errors)){
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock - $table_achat->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();
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
			if (!empty($table_update_achats)) {
					$last_fournisseur = Update_achat::trouve_last_fournisseur_par_id_facture($id);
					
					}
				foreach($table_update_achats as $table_update_achat){ 
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

	$Achat = new Avoir_achat();
	$Achat->id_facture = $table_update_achat->id_facture;
	$Achat->id_fournisseur = $table_update_achat->id_fournisseur;
	$Achat->id_prod = $table_update_achat->id_prod;
	$Achat->Prix = $table_update_achat->Prix;
	$Achat->Ttva = $table_update_achat->Ttva;
	$Achat->Quantite = $table_update_achat->Quantite;
	$Achat->id_person = $table_update_achat->id_person;
	$Achat->id_societe = $table_update_achat->id_societe;
	$Achat->date_fact = $table_update_achat->date_fact;
	$Achat->Ht = $table_update_achat->Ht ;
	$Achat->Tva = $table_update_achat->Tva ;
	$Achat->total = $table_update_achat->total ;
	$Achat->Designation = $table_update_achat->Designation;
	$Achat->Code = $table_update_achat->Code;
	$Achat->save();

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
				$Fact->Remise = htmlentities(trim($_POST['Remise']));
				$Fact->Num_facture = htmlentities(trim($_POST['Reference']));
				$Journal = htmlentities(trim($_POST['mode_paiment_facture']));
				switch ($Journal) {
			            case '1':
			                  $Fact->mode_paiment ="Chèque";
			            break;
			            case '2':
			                  $Fact->mode_paiment ="Espèces";
			            break;
			            case '3':
			                  $Fact->mode_paiment ="Versement Bancaire";
			            break;
			            case '4':
			                 $Fact->mode_paiment ="Virement Bancaire";
			            break;
			            case '5':
			                  $Fact->mode_paiment ="Carte de crédit";
			            break;
			            case '6':
			                  $Fact->mode_paiment ="Billet à ordre";
			            break;
			            case '7':
			                  $Fact->mode_paiment ="A Terme";
			            break;
			      }
			      	if ($Journal ==2) {
						$timbre=0;
				 		$timbre = $Somme_ttc->somme_ttc /100;
				 		$timbre = ceil($timbre);
				 		if ($timbre < 5 ) {
				 			$timbre =5;	}
				 			elseif( $timbre >= 2500 ){
				 				$timbre = 2500;
				 			}
				 			$total_ttc = $Somme_ttc->somme_ttc - $Fact->Remise;
			                $total_ttc = $total_ttc + $timbre;
				}else{
					$total_ttc = $Somme_ttc->somme_ttc - $Fact->Remise;
					$timbre =0;
				}
				$Fact->somme_ttc =$total_ttc;
				$Fact->timbre =$timbre;
				$Fact->somme_ht =  $Somme_ht->somme_ht;
				$Fact->somme_tva =  $Somme_tva->somme_tva;
				$Fact->id_fournisseur = $last_fournisseur->id_fournisseur;
				$Fact->date_fac = $last_fournisseur->date_fact;
				$Fact->modifier();
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
				if (empty($errors)){
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock + $table_vante->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();
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
			if (!empty($table_update_vantes)) {
					$last_client = Update_vente::trouve_last_client_par_id_facture($id);
					
					}
			foreach($table_update_vantes as $table_update_vante){ 

			 	$Article = Produit::trouve_par_id($table_update_vante->id_prod);

			 	if ( $table_update_vante->Quantite > $Article->stock)
					{
						$errors[] = 'Quantité  Entrer Supérieur à quantité de stock !! ';
						$errors[] = 'Quantité disponible de '.$Article->Designation .'  est : '.$Article->stock.' !! ';
					}
				}
				foreach($table_update_vantes as $table_update_vante){ 
				$Article = Produit::trouve_par_id($table_update_vante->id_prod);

				if (empty($errors)){
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock - $table_update_vante->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();
		///////////////// mise a jour de table update_achat etat = 1 ////////////
					$table_update_vante->etat = 1;
					$table_update_vante->modifier();
		////////////// insert into Table ACHAT updated rows ////////////////////

	$Vente = new Vente();
	$Vente->id_facture = $table_update_vante->id_facture;
	$Vente->id_client = $table_update_vante->id_client;
	$Vente->id_prod = $table_update_vante->id_prod;
	$Vente->Prix = $table_update_vante->Prix;
	$Vente->Ttva = $table_update_vante->Ttva;
	$Vente->Quantite = $table_update_vante->Quantite;
	$Vente->id_person = $table_update_vante->id_person;
	$Vente->id_societe = $table_update_vante->id_societe;
	$Vente->date_fact = $table_update_vante->date_fact;
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

				$Fact->Remise = htmlentities(trim($_POST['Remise']));
				$Fact->Num_facture = htmlentities(trim($_POST['Reference']));
				$Journal = htmlentities(trim($_POST['mode_paiment_facture']));
				switch ($Journal) {
			            case '1':
			                  $Fact->mode_paiment ="Chèque";
			            break;
			            case '2':
			                  $Fact->mode_paiment ="Espèces";
			            break;
			            case '3':
			                  $Fact->mode_paiment ="Versement Bancaire";
			            break;
			            case '4':
			                 $Fact->mode_paiment ="Virement Bancaire";
			            break;
			            case '5':
			                  $Fact->mode_paiment ="Carte de crédit";
			            break;
			            case '6':
			                  $Fact->mode_paiment ="Billet à ordre";
			            break;
			            case '7':
			                  $Fact->mode_paiment ="A Terme";
			            break;
			      }
			      	if ($Journal ==2) {
						$timbre=0;
				 		$timbre = $Somme_ttc->somme_ttc /100;
				 		$timbre = ceil($timbre);
				 		if ($timbre < 5 ) {
				 			$timbre =5;	}
				 			elseif( $timbre >= 2500 ){
				 				$timbre = 2500;
				 			}
				 			$total_ttc = $Somme_ttc->somme_ttc - $Fact->Remise;
			                $total_ttc = $total_ttc + $timbre;
				}else{
					$total_ttc = $Somme_ttc->somme_ttc - $Fact->Remise;
					$timbre =0;
				}
				$Fact->somme_ttc =$total_ttc;
				$Fact->timbre =$timbre;
				$Fact->somme_ht =  $Somme_ht->somme_ht;
				$Fact->somme_tva =  $Somme_tva->somme_tva;
				$Fact->id_client = $last_client->id_client;
				$Fact->date_fac = $last_client->date_fact;
				$Fact->modifier();
			readresser_a("invoice_avoir.php?id=".$id."&action=update");
		}

}

if ($action == 'fact_vente') {
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);
	$Somme_ht = Avoir_vente::somme_ht($user->id,$nav_societe->id_societe);
	$Somme_tva = Avoir_vente::somme_tva($user->id,$nav_societe->id_societe);
	$Somme_ttc = Avoir_vente::somme_ttc($user->id,$nav_societe->id_societe);
	$Somme_Ht_achat = Avoir_vente::somme_Ht_achat($user->id,$nav_societe->id_societe);
	$table_vantes = Avoir_vente::trouve_vente_vide_par_admin($user->id,$nav_societe->id_societe);
	$table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin_avoir($user->id,$nav_societe->id_societe);
    $Reglement = Reglement_client::trouve_somme_and_timbre_vide_par_admin_avoir($user->id,$nav_societe->id_societe);
	$Last_client = Avoir_vente::trouve_last_client_par_id_admin($user->id,$nav_societe->id_societe);
	$Client = Client::trouve_par_id($Last_client->id_client);
	$n_fact = count( $factures = Facture_avoir_vente::trouve_last_par_societe($nav_societe->id_societe))  ;
		if ( $n_fact == 0 ){ $n_facture = 1; }
		else if ( $n_fact > 0 ){	if (!empty($factures->N_facture)){ $n_facture = $factures->N_facture + 1 ;}
												else  { $n_facture = 1; }	
				}
	$errors = array();
	$random_number = rand();
	$facture = new Facture_avoir_vente();
	$facture->id_client = htmlentities(trim($_POST['client'])); 
	$facture->N_facture = $n_facture;
	$facture->id_societe = $nav_societe->id_societe;
	$facture->date_fac = htmlentities(trim($_POST['date_fact'])); 
	$facture->somme_Ht_achat =  $Somme_Ht_achat->somme_ht;
	$facture->date_valid = date("Y-m-d");
	$facture->random =  $random_number;
	$facture->somme_ht =  $Somme_ht->somme_ht;
	$facture->somme_tva =  $Somme_tva->somme_tva;
	$facture->somme_ttc =$Somme_ttc->somme_ttc;
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
            toastr.success(" Facture avoir créée avec succès","Très bien !");
        },300);


 			});

			</script>
		
	<?php  
			$Fact = Facture_avoir_vente::trouve_par_random($random_number);
			$date = date_parse($Fact->date_fac);
			 foreach($table_vantes as $table_vante){ 

			 	$Article = Produit::trouve_par_id($table_vante->id_prod);
			 	$Lot_prod = Lot_prod::trouve_par_id($table_vante->id_lot);


				if (empty($errors)){

		/////////////// mise a jour table vente avec le nv id_facture ////////////////////
					$table_vante->id_facture = $Fact->id_facture;
					$table_vante->modifier();

////////////////////// insret into table histo_vente /////////////////////////
	  $SQL2 = $bd->requete("INSERT INTO `histo_avoir_vente` (`id`, `lib_prod`, `code_prod`, `id_prod`, `id_facture`, `Quantite_vente`, `Quantite_stock`) VALUES (NULL, '$table_vante->Designation', '$table_vante->Code', '$table_vante->id_prod', '$table_vante->id_facture', '$table_vante->Quantite', '$Article->stock');");

		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock + $table_vante->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();


						///////////////// mise a jour de QTE stock produit ///////////////
					
						// code...
					
					$Quantite_stock_Lot = $Lot_prod->qte + $table_vante->Quantite;
					$Lot_prod->qte = $Quantite_stock_Lot;
					$Lot_prod->modifier();
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
                $Reste =  $Solde_client->solde + ($table_Reglement->somme + $table_Reglement->timbre);
                $Solde_client->solde = $Reste;
                if ($Reste == 0 ) {
                $Solde_client->etat = 1;   
                }
                $Solde_client->modifier();
                } 
                
                
                

              }

			 /////////////////////// ajouter piece comptable automatiquement  FACTURE avoir VENTE ///////////////////////////////
$Ht_total = 0;
$TVA_total = 0;
$timbre_total = 0;
$TTC = 0;
	$Ht = Famille::calcule_Ht_par_famille_and_facture_vente_avoir($Fact->id_facture,$nav_societe->id_societe);
	foreach ($Ht as $Hts) {
		$Ht_total += $Hts->Ht; 
	}

	$TVA = Famille::calcule_TVA_par_famille_and_facture_vente_avoir($Fact->id_facture,$nav_societe->id_societe);

	$timbres = Famille::calcule_timbre_par_famille_and_facture_vente_avoir($Fact->id_facture,$nav_societe->id_societe);

	$somme_ttc = Famille::calcule_somme_ttc_par_famille_and_facture_vente_avoir($Fact->id_facture,$nav_societe->id_societe);
		foreach ($somme_ttc as $somme_ttcs) {
		$TTC += $somme_ttcs->somme_ttc;
	}

		$TVA_total = $TTC - $Ht_total - $Fact->timbre;

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $nav_societe->id_societe;
	$Pieces_comptables->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables->type_op =  2;
	$Pieces_comptables->ref_piece =  $Fact->N_facture;
	$Pieces_comptables->libelle =  'FACTURE AVOIR VENTE - '.$Client->nom;
	$Pieces_comptables->date =  $Fact->date_fac;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $nav_societe->journal_vente;
	$Pieces_comptables->somme_debit = - $Fact->somme_ttc;
	$Pieces_comptables->somme_credit = - $Fact->somme_ttc;
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
	$Ecriture_comptable->debit=  - $somme_ttc->somme_ttc;
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
	$Ecriture_comptable->credit = - $Ht->Ht;
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
	$Ecriture_comptable->credit = - $TVA_total;
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
	$Ecriture_comptable->credit = - $TVA->total_tva ;
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
	$Ecriture_comptable->credit = - $timbre->timbre;
	$Ecriture_comptable->save();
				}


 /////////////////////// ajouter piece comptable automatiquement  Sortie stock ///////////////////////////////

	$random_number_2 = rand();

	$Pieces_comptables_Sortie = new Pieces_comptables();
	$Pieces_comptables_Sortie->id_societe = $nav_societe->id_societe;
	$Pieces_comptables_Sortie->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables_Sortie->type_op =  7;
	$Pieces_comptables_Sortie->ref_piece =  $Fact->N_facture;
	$Pieces_comptables_Sortie->libelle =  ' ENTREE STOCK  - '.$Client->nom;
	$Pieces_comptables_Sortie->date =  $Fact->date_fac;
	$Pieces_comptables_Sortie->date_valid =  date("Y-m-d");
	if ($nav_societe->journal_stock != 0) {
	$Pieces_comptables_Sortie->journal = $nav_societe->journal_stock;
	} else{
	$Pieces_comptables_Sortie->journal = $nav_societe->journal_depense;	
	}
	$Pieces_comptables_Sortie->somme_debit = - $Fact->somme_Ht_achat;
	$Pieces_comptables_Sortie->somme_credit = - $Fact->somme_Ht_achat;
	$Pieces_comptables_Sortie->random =  $random_number_2;
	$Pieces_comptables_Sortie->save();


///////////// ajouter les ecriture comptable de cette piece /////////////////// 


	$Piece_Sortie = Pieces_comptables::trouve_par_random($random_number_2);
	$Hts = Famille::calcule_Ht_par_famille_and_facture_vente_avoir($Fact->id_facture,$nav_societe->id_societe);

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
	$Ecriture_comptable->debit = - $Ht->Ht_achat;
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
	$Ecriture_comptable->credit = - $Ht->Ht_achat;
	$Ecriture_comptable->save();
				}
	




			 readresser_a("invoice_avoir.php?id=".$Fact->id_facture."&action=vente");
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
if (isset($_GET['action']) && $_GET['action'] =='fact_achat' ) {


				$nav_societe = Societe::trouve_par_id($_SESSION['societe']);
				$Somme_ht = Avoir_achat::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Avoir_achat::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Avoir_achat::somme_ttc($user->id,$nav_societe->id_societe);
				$table_achats = Avoir_achat::trouve_achat_vide_par_admin($user->id,$nav_societe->id_societe);
				$table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($user->id,$nav_societe->id_societe,3);
				$Reglement = Reglement_fournisseur::trouve_somme_and_timbre_vide_par_admin($user->id,$nav_societe->id_societe,3);
if (!empty($table_achats)) {
					$Last_fournisseur = Avoir_achat::trouve_last_fournisseur_par_id_admin($user->id,$nav_societe->id_societe);
					$Fournisseur = Fournisseur::trouve_par_id($Last_fournisseur->id_fournisseur);
					$n_fact = count( $factures = Facture_avoir_achat::trouve_last_par_societe($nav_societe->id_societe))  ;
				if ( $n_fact == 0 ){ $n_facture = 1; }
				else if ( $n_fact > 0 ){		if (!empty($factures->N_facture)){ $n_facture = $factures->N_facture + 1 ;}
												else  { $n_facture = 1; }	
				}

	$errors = array();
	$random_number = rand();
	$factur = new Facture_avoir_achat();
	$factur->N_facture = $n_facture;
	$factur->id_societe = $nav_societe->id_societe;
	$factur->date_valid = date("Y-m-d");

	$factur->random =  $random_number;
	$factur->Num_facture = htmlentities(trim($_POST['Reference']));
	$factur->date_fac = htmlentities(trim($_POST['date_fact']));
	$factur->id_fournisseur = htmlentities(trim($_POST['fournisseur']));
	if (!empty($_POST['facture_scan'])) {
	$factur->facture_scan = htmlentities(trim($_POST['facture_scan']));
	}
	$factur->somme_ht =  $Somme_ht->somme_ht;
	$factur->somme_tva =  $Somme_tva->somme_tva;
	$factur->somme_ttc =$Somme_ttc->somme_ttc;
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

			$Fact = Facture_avoir_achat::trouve_par_random($random_number);
			$date = date_parse($Fact->date_fac);
			 foreach($table_achats as $table_achat){ 

			 	$Article = Produit::trouve_par_id($table_achat->id_prod);
			 	 $Lot_prod = Lot_prod::trouve_par_id($table_achat->id_lot);


				if (empty($errors)){
/////////////// mise a jour table Achat avec le nv id_facture ////////////////////
					$table_achat->id_facture = $Fact->id_facture;
					$table_achat->date_fact = htmlentities(trim($_POST['date_fact']));
					$table_achat->id_fournisseur = htmlentities(trim($_POST['fournisseur']));
					$table_achat->Reference_fact = htmlentities(trim($_POST['Reference']));
					$table_achat->modifier();
					
///////////////////////// inset into histo_achat table ///////////////////////:
			$SQL2 = $bd->requete("INSERT INTO `histo_avoir_achat` (`id`, `lib_prod`, `code_prod`, `id_prod`, `id_facture`, `Quantite_achat`, `Quantite_stock`) VALUES (NULL, '$table_achat->Designation', '$table_achat->Code', '$table_achat->id_prod', '$table_achat->id_facture', '$table_achat->Quantite', '$Article->stock');");

		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock - $table_achat->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();

	                        ///////////////// mise a jour de QTE stock produit ///////////////
                    
                        // code...
                    
                    $Quantite_stock_Lot = $Lot_prod->qte - $table_achat->Quantite;
                    $Lot_prod->qte = $Quantite_stock_Lot;
                    $Lot_prod->modifier();
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
	$Pieces_comptables->libelle =  'FACTURE AVOIR ACHAT - '.$Fournisseur->nom;
	$Pieces_comptables->date =  $Fact->date_fac;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $nav_societe->journal_achat;
	$Pieces_comptables->somme_debit = - $Fact->somme_ttc;
	$Pieces_comptables->somme_credit = -  $Fact->somme_ttc;
	$Pieces_comptables->facture_scan = $Fact->facture_scan;
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();


///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);
	$Ht = Famille::calcule_Ht_par_famille_and_facture_achat_avoir($Fact->id_facture,$nav_societe->id_societe);
	$TVA = Famille::calcule_TVA_par_famille_and_facture_achat_avoir($Fact->id_facture,$nav_societe->id_societe);
	$timbres = Famille::calcule_timbre_par_famille_and_facture_achat_avoir($Fact->id_facture,$nav_societe->id_societe);
	$somme_ttc = Famille::calcule_somme_ttc_par_famille_and_facture_achat_avoir($Fact->id_facture,$nav_societe->id_societe);

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
	$Ecriture_comptable->debit = - $Ht->Ht;
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
	$Ecriture_comptable->debit = - $TVA->total_tva;
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
	$Ecriture_comptable->debit = - $timbre->timbre;
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
	$Ecriture_comptable->credit = - $somme_ttc->somme_ttc;
	$Ecriture_comptable->save();
				}

/////////////////////// ajouter piece comptable Entrée stock automatiquement ///////////////////////////////
		$random_number_2 = rand();

	$Pieces_comptables_Entree = new Pieces_comptables();
	$Pieces_comptables_Entree->id_societe = $nav_societe->id_societe;
	$Pieces_comptables_Entree->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables_Entree->type_op =  6;
	$Pieces_comptables_Entree->ref_piece =  $Fact->N_facture;
	$Pieces_comptables_Entree->libelle =  'SORTIE STOCK - '.$Fournisseur->nom;
	$Pieces_comptables_Entree->date =  $Fact->date_fac;
	$Pieces_comptables_Entree->date_valid =  date("Y-m-d");
	if ($nav_societe->journal_stock != 0) {
	$Pieces_comptables_Entree->journal = $nav_societe->journal_stock;
	} else{
	$Pieces_comptables_Entree->journal = $nav_societe->journal_depense;	
	}
	$Pieces_comptables_Entree->somme_debit = - $Fact->somme_ht;
	$Pieces_comptables_Entree->somme_credit = - $Fact->somme_ht;
	$Pieces_comptables_Entree->facture_scan =  $Fact->facture_scan;
	$Pieces_comptables_Entree->random =  $random_number_2;
	$Pieces_comptables_Entree->save();

///////////// ajouter les ecriture comptable de cette piece /////////////////// 

	$Piece_Entree = Pieces_comptables::trouve_par_random($random_number_2);
	$Ht_Entrees = Famille::calcule_Ht_par_famille_and_facture_achat_avoir($Fact->id_facture,$nav_societe->id_societe);
	
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
	$Ecriture_comptable->debit = - $Ht_Entree->Ht;
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
	$Ecriture_comptable->credit = - $Ht_Entree->Ht;
	$Ecriture_comptable->save();
				}
		

			 readresser_a("invoice_avoir_achat.php?id=".$Fact->id_facture."&action=achat");
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
if ($user->type == "administrateur"){
if (isset($_GET['action']) && $_GET['action'] =='list_vente' ) {
$active_submenu = "list_vente";
$action = 'list_vente';
$titre = "ThreeSoft | Avoir Vente ";}
else if (isset($_GET['action']) && $_GET['action'] =='avoir_vente' ) {
$active_submenu = "list_vente";
$action = 'avoir_vente';
$titre = "ThreeSoft | Avoir  Vente ";}
else if (isset($_GET['action']) && $_GET['action'] =='list_achat' ) {
$active_submenu = "list_achat";
$action = 'list_achat';
$titre = "ThreeSoft | Avoir Achat ";}
else if (isset($_GET['action']) && $_GET['action'] =='avoir_achat' ) {
$active_submenu = "list_achat";
$action = 'avoir_achat';
$titre = "ThreeSoft | Avoir  Achat ";}
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
$titre = "ThreeSoft | Modifier avoir Achat ";}
else if (isset($_GET['action']) && $_GET['action'] =='edit_vente' ) {
$active_submenu = "list_vente";
$action = 'edit_vente';
$titre = "ThreeSoft | Modifier avoir Vente ";}
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
		// upload facture	vente	
	if($action == 'upload' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$Upload = Facture_vente:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$Upload = Facture_vente:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object Upload
	
	
		        if($_FILES["image"]["size"]>0) {
				 $file_name = $Upload->id_facture; 
        // Validate the type. Should be JPEG or PNG.
        $allowed = array ('image/jpeg','image/pjpeg','image/png');
        if (in_array($_FILES['image']['type'], $allowed)) {
           
            // Move the file over.
            if (file_exists("scan/vente/".$file_name.".jpg")){unlink("scan/vente/".$file_name .".jpg");}
            if (move_uploaded_file($_FILES['image']['tmp_name'],"scan/vente/".$file_name .".jpg")) {

                
                $Upload->facture_scan = $file_name.".jpg";
                
            }else{
                $errors[]= "un probleme au transfert  des données ";
            } 
        } else { // Invalid type.
            $errors[]= "l'image doit être en format jpeg ";
        }
                // Check for an error:
        if ($_FILES['image']['error'] > 0) {
        $errors[]= 'le image est mal téléchargé accause : <br/>';

        // Print a message based upon the error.
        switch ($_FILES['image']['error']) {
            case 1:
            $errors[]= 'The image exceeds the upload_max_filesize setting in php.ini.';
            break;
            case 2:
            $errors[]= 'The image exceeds the MAX_FILE_SIZE setting in the HTML form.';
            break;
            case 3:
            $errors[]= 'The image was only partially uploaded.';
            break;
            case 4:
            $errors[]= 'No image was uploaded.';
            break;
            case 6:
            $errors[]= 'No temporary folder was available.';
            break;
            case 7:
            $errors[]= 'Unable to write to the disk.';
            break;
            case 8:
            $errors[]= 'File upload stopped.';
            break;
            default:
            $errors[]= 'A system error occurred.';
            break;
        } // End of switch.
        } // End of error IF.
    
    
    
        // Delete the image if it still exists:
        if (file_exists($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']) ) {
            unlink($_FILES['image']['tmp_name']);
        }
    
    
    }
	

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($Upload->save()){
			
					
		$msg_positif = '<p >  Facture N° : <b>' . $Upload->id_facture . '</b> est bien ajouter - <a href="avoir.php?action=list_vente">  Liste des vente</a> </p><br />';
													
														
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
}		
	}
					?>
<?php
		// upload facture	Achat	
	if(isset ($_POST['submit']) && $action == 'upload_achat' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$upload_achat = Facture_avoir_achat:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$upload_achat = Facture_avoir_achat:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	

	$errors = array();
		// new object Upload
	
	
		        if($_FILES["image"]["size"]>0) {
				 $file_name = $upload_achat->id_facture; 
        // Validate the type. Should be JPEG or PNG.
        $allowed = array ('image/jpeg','image/pjpeg','image/png');
        if (in_array($_FILES['image']['type'], $allowed)) {
           
            // Move the file over.
            if (file_exists("scan/achat/".$file_name.".jpg")){unlink("scan/achat/".$file_name .".jpg");}
            if (move_uploaded_file($_FILES['image']['tmp_name'],"scan/achat/".$file_name .".jpg")) {

                
                $upload_achat->facture_scan = $file_name.".jpg";
                
            }else{
                $errors[]= "un probleme au transfert  des données ";
            } 
        } else { // Invalid type.
            $errors[]= "l'image doit être en format jpeg ";
        }
                // Check for an error:
        if ($_FILES['image']['error'] > 0) {
        $errors[]= 'le image est mal téléchargé accause : <br/>';

        // Print a message based upon the error.
        switch ($_FILES['image']['error']) {
            case 1:
            $errors[]= 'The image exceeds the upload_max_filesize setting in php.ini.';
            break;
            case 2:
            $errors[]= 'The image exceeds the MAX_FILE_SIZE setting in the HTML form.';
            break;
            case 3:
            $errors[]= 'The image was only partially uploaded.';
            break;
            case 4:
            $errors[]= 'No image was uploaded.';
            break;
            case 6:
            $errors[]= 'No temporary folder was available.';
            break;
            case 7:
            $errors[]= 'Unable to write to the disk.';
            break;
            case 8:
            $errors[]= 'File upload stopped.';
            break;
            default:
            $errors[]= 'A system error occurred.';
            break;
        } // End of switch.
        } // End of error IF.
    
    
    
        // Delete the image if it still exists:
        if (file_exists($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']) ) {
            unlink($_FILES['image']['tmp_name']);
        }
    
    
    }
	

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($upload_achat->save()){
			
					
		$msg_positif = '<p >  Facture N° : <b>' . $upload_achat->id_facture . '</b> est bien ajouter - <a href="avoir.php?action=list_achat">  Liste des achat</a> </p><br />';
													
														
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
                    <li><?php if ($action == 'avoir_vente') { ?>
                        <a href="#">Avoir vente</a>  
                         <?php } else if($action == 'avoir_achat'){
                         	echo '<a href="#">Avoir achat</a> ';
                         } else if($action == 'list_achat'){
                         	echo '<a href="#">Liste  avoir achats</a> ';
                         } else if($action == 'list_vente'){
                         	echo '<a href="#">Liste  avoir ventes</a> ';
                         }else if($action == 'edit_achat'){
                         	echo '<a href="#">Modifier avoir achat</a> ';
                         }else if($action == 'edit_vente'){
                         	echo '<a href="#">Modifier avoir vente</a> ';
                          }else if($action == 'avoir_achat'){
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
					
					$factures = Facture_avoir_vente::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);


				}else{
					$factures = Facture_avoir_vente::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}
				$NfactNV = count($table_ch = Facture_avoir_vente::trouve_facture_non_valide_par_societe($nav_societe->id_societe));
				$NfactV = count($table_ch = Facture_avoir_vente::trouve_facture_valide_par_societe($nav_societe->id_societe));
				$Nfact = $NfactNV + $NfactV; 				
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12 ">						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">						
						<div class="portlet-title">							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>Avoir vente<span class="caption-helper">&nbsp;&nbsp;(<?php echo $Nfact;?>)</span>
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-4">
										<div class="btn-group">											
											<a href="avoir.php?action=avoir_vente" class="btn yellow-crusta ">Nouveau  <i class="fa fa-plus"></i></a>
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
									Date facture
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
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
								<a href="invoice_avoir.php?id=<?php echo $facture->id_facture; ?>" class="">
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
															$Clients = Client::trouve_client_par_id_client($facture->id_client);
															
															}
															foreach ($Clients as $client){
																
																	if (isset($client->nom)) {
															echo $client->nom;}}?>
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

							</tbody>
							</table>
						
						</div>
					</div>
                                          
							</div>
				</div>
			
			</div>
				<?php }elseif ($action == 'avoir_vente') {
				$Articles = Produit::trouve_produit_vente_par_societe($nav_societe->id_societe);
				$clients = Client::trouve_valid_par_societe($nav_societe->id_societe); 	
				$tvas = TVA::trouve_tous(); 
				$Somme_ht = Avoir_vente::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Avoir_vente::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Avoir_vente::somme_ttc($user->id,$nav_societe->id_societe);
				$table_vantes = Avoir_vente::trouve_vente_vide_par_admin($user->id,$nav_societe->id_societe);
				if (!empty($table_vantes)) {
					$last_client = Avoir_vente::trouve_last_client_par_id_admin($user->id,$nav_societe->id_societe);
					
					}	
			$thisday=date('Y-m-d');
				  ?>
		<div class="show-facture">
			<!-- BEGIN PAGE CONTENT-->
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
								</div>
						</div>

			<div class="row">
		
				<div class="col-md-12">
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Listes
							</div>
						</div>
						<div class="portlet-body notification">
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
														<?php  foreach ($Articles as $Article) { ?>
																	<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$Article->stock  ;} ?> </option>
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
							<button id="Enregistrer_paiement" disabled="" class="btn  green " data-target="#add-paiment"> <i class="fa fa-credit-card"></i>  Enregistrer un paiement </button>   
								
						    </div>	

						</div>
					
				</div>
					
			</div>
		</div>

					
			
			<?php } else if($action =="list_achat") {?>
				<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

					if (isset($_POST['submit']) ) {
									
						$date_db = trim(htmlspecialchars($_POST['date_db']));
						$date_fin = trim(htmlspecialchars($_POST['date_fin']));
						
						$factures = Facture_avoir_achat::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);


					}else{
						$factures = Facture_avoir_achat::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
					}
				$NfactNA = count($table_ch = Facture_avoir_achat::trouve_facture_non_valide_par_societe($nav_societe->id_societe));
				$NfactA = count($table_ch = Facture_avoir_achat::trouve_facture_valide_par_societe($nav_societe->id_societe));
				$Nfact = $NfactNA + $NfactA; 				
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12 ">
											

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>Avoir achat<span class="caption-helper">&nbsp;&nbsp;(<?php echo $Nfact;?>)</span>
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-4">
										<div class="btn-group">
											
											<a href="avoir.php?action=avoir_achat" class="btn yellow-crusta ">Nouvelle facture  <i class="fa fa-plus"></i></a>
											
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
							
						<div class="portlet-body">
							<table class="table table-striped  table-hover" id="sample_2">
							<thead>
							<tr>
								
								<th>
									N°  Facture
								</th>
								<th>
									Date facture
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
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
								<a href="invoice_avoir_achat.php?id=<?php echo $facture->id_facture; ?>" class="">
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
									<?php if (isset($facture->id_fournisseur)) {
															$Fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($Fournisseurs as $fournisseur){
																
																	if (isset($fournisseur->nom)) {
																		
															echo $fournisseur->nom;}}?>
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

							</tbody>
							</table>
						
						</div>
					</div>
                                          
					
				</div>
			
			</div>


		<?php } else if($action =="avoir_achat") { 

			$Articles = Produit::trouve_produit_achat_par_societe($nav_societe->id_societe);
				$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 	
				$tvas = TVA::trouve_tous(); 
				$Somme_ht = Avoir_achat::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Avoir_achat::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Avoir_achat::somme_ttc($user->id,$nav_societe->id_societe);
				$table_achats = Avoir_achat::trouve_achat_vide_par_admin($user->id,$nav_societe->id_societe);
				if (!empty($table_achats)) {
					$last_fournisseur = Avoir_achat::trouve_last_fournisseur_par_id_admin($user->id,$nav_societe->id_societe);
					
					}	
			$thisday=date('Y-m-d');
				  ?>
		<div class="show-facture">
			<!-- BEGIN PAGE CONTENT-->
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
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-3 control-label">Date </label>
													<div class="col-md-9">
														
															<input type="date" name = "date_fact" id="date_fact" class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
                                	   </div>
                                 </div>
							</div>
						</div>
											
										
										<!-- END FORM-->
									</div>
								</div>
						</div>

			<div class="row">
		
				<div class="col-md-12">
					
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
									Lot
								</th>
								<th>
									 Qté 
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
									TAUX  TVA 
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
									<?php if (isset($table_achat->id_lot)) {
										if ($table_achat->id_lot == 0) {
											echo "/";
										}else{
										$lot = $Lot_prod=Lot_prod::trouve_par_id($table_achat->id_lot);
										if (isset($Lot_prod->id)) {
											echo $Lot_prod->code_lot;
										}
										}
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
														 <?php  foreach ($Articles as $Article) { ?>
                                                                    <option <?php if ($Produit->id_pro == $Article->id_pro ) {echo 'selected'; } ?> value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$Article->stock ;} ?> </option>
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
							<button id="Enregistrer_paiement" class="btn  green " data-target="#add-paiment_achat" data-toggle="modal" disabled="disabled"> <i class="fa fa-credit-card"></i>  Enregistrer un paiement </button>   
								
						    </div>	

						</div>
					
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
				$Articles = Produit::trouve_produit_par_societe($nav_societe->id_societe);
				$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 	
				$Somme_ht = Update_achat::somme_ht($id_facture);
				$Somme_tva = Update_achat::somme_tva($id_facture);
				$Somme_ttc = Update_achat::somme_ttc($id_facture);
				$Facture = Facture_avoir_achat::trouve_par_id($id_facture);
				$table_achats = Update_achat::trouve_achat_notvalide_par_facture($id_facture);
				if (!empty($table_achats)) {
					$last_fournisseur = Update_achat::trouve_last_fournisseur_par_id_facture($id_facture);
					
					}	
			$thisday=date('Y-m-d');
				  ?>
		<div class="show-facture">
			<!-- BEGIN PAGE CONTENT-->
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
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-3 control-label">Date facturation </label>
													<div class="col-md-9">
														
															<input type="date" name = "date_fact" id="date_fact" class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
                                	   </div>
                                 </div>	
                                    

                                		   </div>
                               
												
												
											</div>
											
										
										<!-- END FORM-->
									</div>
								</div>
						</div>

			<div class="row">
		
				<div class="col-md-12">
					
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
									Code
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
									TAUX  TVA 
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
										echo $table_achat->Designation;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Code)) {
										echo $table_achat->Code;
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
														<?php  foreach ($Articles as $Article) { ?>
																	<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
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
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> DA</span></td>
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
				<div class="col-md-12">
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
								</div>
						</div>

<div class="row">
		
				<div class="col-md-12">
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Listes
							</div>
						</div>
						<div class="portlet-body notification">
						<table class="table table-striped table-bordered table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="30%">
									Désignation
								</th>
								<th>
									Code
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
									TAUX  TVA 
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
										echo $table_vante->Designation;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Code)) {
										echo $table_vante->Code;
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
								<td class=" HT">
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
								</td>								<td>
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
														<?php  foreach ($Articles as $Article) { ?>
																	<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
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
							<a id="update_paiement" disabled class="btn  green " data-target="#update-paiment"  > <i class="fa fa-credit-card"></i>  Enregistrer un paiement </a>
						    </div>	

						</div>
					
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

		<div class="row">
				<div class="col-md-12 ">
						
								<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>				
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-download font-yellow"></i>Télécharger facture scan
							</div>
						</div>
						
							
						<div class="portlet-body">
							<form action="<?php echo $_SERVER['PHP_SELF']?>?action=upload" method="POST" class="form-horizontal" enctype="multipart/form-data">
							<div class="form-body">
							<div class="form-group">
													<label class="control-label col-md-3">scan </label>
													<div class="col-md-8">
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 175px; ">
															 <?php  if (!empty($Upload->facture_scan)) {
															echo' <img src="scan/vente/'.$Upload->facture_scan.'" alt=""> '; 
															} else { 
																echo '<img src="assets/image/no_image.jpg" alt="">';
															 }?>
																</div>
															<div >
																<span class="btn btn blue btn-file"><span class="fileinput-new">Telecharger</span><span class="fileinput-exists">Changer</span>
																<input type="file" name="image" accept=".png,.jpg,.jpeg,.gif"></span>
																<a href="#" class="btn btn red fileinput-exists" data-dismiss="fileinput">Retirer</a>
															</div>
														</div>
													</div>
												</div>
						
						</div>
						</div>
						<hr>
						<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn green">Ajouter</button>
														<a href="avoir.php?action=list_vente" type="reset" class="btn  default">Annuler</a>
														<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
													</div>
												</div>
											</div>
						</form>
					</div>
                                          
					
				</div>
			
			</div>
				<?php  } else if ($action=='upload_achat') {
			if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
						$id = $_GET['id']; 
						$Upload_achat = Facture_avoir_achat:: trouve_par_id($id);
						 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
							 $id = $_POST['id'];
						$Upload_achat = Facture_avoir_achat:: trouve_par_id($id);
						 } else { 
								$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
							} 
					
					?>

		<div class="row">
				<div class="col-md-12 ">
						
								<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>				
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-download font-yellow"></i>Télécharger facture scan
							</div>
						</div>
						
							
						<div class="portlet-body">
							<form action="<?php echo $_SERVER['PHP_SELF']?>?action=upload_achat" method="POST" class="form-horizontal" enctype="multipart/form-data">
							<div class="form-body">
							<div class="form-group">
													<label class="control-label col-md-3">scan </label>
													<div class="col-md-8">
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 175px; ">
															 <?php  if (!empty($Upload_achat->facture_scan)) {
															echo' <img src="scan/achat/'.$Upload_achat->facture_scan.'" alt=""> '; 
															} else { 
																echo '<img src="assets/image/no_image.jpg" alt="">';
															 }?>
																</div>

															<div >
																<span class="btn btn blue btn-file"><span class="fileinput-new">Telecharger</span><span class="fileinput-exists">Changer</span>
																<input type="file" name="image" accept=".png,.jpg,.jpeg,.gif"></span>
																<a href="#" class="btn btn red fileinput-exists" data-dismiss="fileinput">Retirer</a>
															</div>
														</div>
													</div>
												</div>
						
						</div>
						</div>
						<hr>
						<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn green">Ajouter</button>
														<a href="avoir.php?action=list_achat" type="reset" class="btn  default">Annuler</a>
														<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
													</div>
												</div>
											</div>
						</form>
					</div>
                                          
					
				</div>
			
			</div>
 <?php	}} ?>
		</div>
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
	

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>