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
if ($user->type == "administrateur"){

	if (isset($_GET['action']) && $_GET['action'] =='list_importation' ) {

$active_submenu = "importation";
$action = 'list_importation';
	}else if (isset($_GET['action']) && $_GET['action'] =='add_importation' ) {
$active_submenu = "importation";
$action = 'add_importation';}
else if (isset($_GET['action']) && $_GET['action'] =='edit_importation' ) {
$active_submenu = "importation";
$action = 'edit_importation';}
else if (isset($_GET['action']) && $_GET['action'] =='edit_frais_importation' ) {
$active_submenu = "importation";
$action = 'edit_frais_importation';}
else if (isset($_GET['action']) && $_GET['action'] =='importation' ) {
$active_submenu = "importation";
$action = 'importation';}
else if (isset($_GET['action']) && $_GET['action'] =='list_achat' ) {
$active_submenu = "importation";
$action = 'list_achat';}
else if (isset($_GET['action']) && $_GET['action'] =='upload_importation' ) {
$active_submenu = "importation";
$action = 'upload_importation';}
else if (isset($_GET['action']) && $_GET['action'] =='update_importation' ) {
$active_submenu = "importation";
$action = 'update_importation';}
}
if (isset($_GET['action']) && $_GET['action'] =='fact_importation' ) {
				$nav_societe = Societe::trouve_par_id($_SESSION['societe']);
				$Somme_ht = Achat_importation::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Achat_importation::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Achat_importation::somme_ttc($user->id,$nav_societe->id_societe);
	///////////////////////////////////////////////////////////////////////
				$Somme_ht_frais = Achat_importation::somme_ht_frais($user->id,$nav_societe->id_societe);
				$Somme_tva_frais = Achat_importation::somme_tva_frais($user->id,$nav_societe->id_societe);
				$Somme_timbre_frais = Achat_importation::somme_timbre_frais($user->id,$nav_societe->id_societe);
				$Somme_ttc_frais = Achat_importation::somme_ttc_frais($user->id,$nav_societe->id_societe);
	///////////////////////////////////////////////////////////////////////

				$table_achats = Achat_importation::trouve_achat_vide_par_admin($user->id,$nav_societe->id_societe);
				$table_frais = Achat_importation::trouve_frais_vide_par_admin($user->id,$nav_societe->id_societe);
				if (!empty($table_achats)) {
					$Last_fournisseur = Achat_importation::trouve_last_fournisseur_par_id_admin($user->id,$nav_societe->id_societe);
					$Fournisseur = Fournisseur::trouve_par_id($Last_fournisseur->id_fournisseur);
				$n_fact = count( $factures = Facture_importation::trouve_last_par_societe($nav_societe->id_societe))  ;
				if ( $n_fact == 0 ){ $n_facture = 1; }
				else if ( $n_fact > 0 ){		if (!empty($factures->N_facture)){ $n_facture = $factures->N_facture + 1 ;}
												else  { $n_facture = 1; }	
				}


	$errors = array();
	$random_number = rand();
	$factur = new Facture_importation();
	$factur->id_fournisseur = $Fournisseur->id_fournisseur;
	$factur->id_societe = $nav_societe->id_societe;
	$factur->N_facture = $n_facture;
	$factur->date_fac = $Last_fournisseur->date_fact;
	$factur->shipping = $Last_fournisseur->shipping;
	$factur->valeur_DA = $Last_fournisseur->valeur_DA;
	$factur->date_valid = date("Y-m-d");
	$factur->somme_ht =  $Somme_ht->somme_ht;
	$factur->somme_tva =  $Somme_tva->somme_tva;
	$factur->somme_ttc =  $Somme_ttc->somme_ttc;
	$factur->somme_ht_frais =  $Somme_ht_frais->somme_ht;
	$factur->somme_tva_frais =  $Somme_tva_frais->somme_tva;
	$factur->somme_timbre_frais =  $Somme_timbre_frais->timbre;
	$factur->somme_ttc_frais =  $Somme_ttc_frais->somme_ttc;
	$factur->Num_facture =  htmlentities(trim($_POST['Num_facture']));
	$factur->random =  $random_number;
	$factur->etat =1;


	//////////////////////////////////////////////////

	if (empty($errors)){
   		if ($factur->existe()) {
			$msg_error = '<p style= "font-size: 20px; "> Cette  facture ' . $factur->num_fac . ' existe déja  !!</p><br />';
			
		}else{
			$factur->save(); ?>
 			<script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
            toastr.success(" factur créée avec succès","Très bien !");
        },300);


 			});

			</script>
		
	<?php  
			$Fact = Facture_importation::trouve_par_random($random_number);
			$date = date_parse($Fact->date_fac);
			 foreach($table_achats as $table_achat){ 

			 	$Article = Produit::trouve_par_id($table_achat->id_prod);

				if (empty($errors)){
/////////////// mise a jour table Achat avec le nv id_facture ////////////////////
					$table_achat->id_facture = $Fact->id_facture;
					$table_achat->modifier();
					
///////////////////////// inset into histo_achat table ///////////////////////:
			$SQL2 = $bd->requete("INSERT INTO `histo_achat` (`id`, `lib_prod`, `code_prod`, `id_prod`, `id_facture`, `Quantite_achat`, `Quantite_stock`) VALUES (NULL, '$table_achat->Designation', '$table_achat->Code', '$table_achat->id_prod', '$table_achat->id_facture', '$table_achat->Quantite', '$Article->stock');");

		///////////////// mise a jour de Article  ///////////////
					$Quantite_stock = $Article->stock + $table_achat->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->prix_achat = $table_achat->Prix;
					$pourcentage_prix_vente = 1+$Article->pourcentage_prix_vente;
					$Article->prix_vente = $table_achat->Prix * $pourcentage_prix_vente;
					$Article->modifier();

					////// creat new lot /////////////////
						$Lot_prod = new Lot_prod();
						$Lot_prod->code_lot = rand();
						$Lot_prod->id_societe = $nav_societe->id_societe;
						$Lot_prod->id_prod = $Article->id_pro;
						$Lot_prod->id_facture = $Fact->id_facture;
						$Lot_prod->qte = $table_achat->Quantite;
						$Lot_prod->qte_initial = $table_achat->Quantite;
						$Lot_prod->prix_achat = $table_achat->Prix;
						$Lot_prod->prix_vente = $table_achat->Prix * $pourcentage_prix_vente;
						$Lot_prod->date_lot = $Fact->date_fac ;
						$Lot_prod->type_achat = 2;
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
						 echo 'saha';
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
			 			 foreach($table_frais as $table_frais){ 
				if (empty($errors)){
/////////////// mise a jour table Achat avec le nv id_facture ////////////////////
					$table_frais->id_facture = $Fact->id_facture;
					$table_frais->modifier();

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

/////// TROUVE Fournisseur //////////////////////////////
			 
$Fournisseur = Fournisseur::trouve_par_id($factur->id_fournisseur);
	/////////////////////// ajouter piece comptable FACTURE ACHAT automatiquement ///////////////////////////////

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $nav_societe->id_societe;
	$Pieces_comptables->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables->type_op =  8;
	$Pieces_comptables->ref_piece =  $Fact->N_facture;
	$Pieces_comptables->libelle =  'FACTURE ACHAT IMPORTATION - '.$Fournisseur->nom;
	$Pieces_comptables->date =  $Fact->date_fac;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $nav_societe->journal_achat;
	$Pieces_comptables->somme_debit = $Fact->somme_ttc_frais;
	$Pieces_comptables->somme_credit = $Fact->somme_ttc_frais;
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();


///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);
	$Ht_frais = Achat_importation::trouve_somme_ht_frais_par_facture($Fact->id_facture,$nav_societe->id_societe);
	$TVA = Achat_importation::somme_tva_frais_par_facture($Fact->id_facture,$nav_societe->id_societe);
	$timbres = Achat_importation::somme_timbre_frais_par_facture($Fact->id_facture,$nav_societe->id_societe);
	$somme_ttc = Achat_importation::trouve_somme_ttc_frais_par_facture($Fact->id_facture,$nav_societe->id_societe);
	$somme_VA = Achat_importation::somme_VA_frais_par_facture($Fact->id_facture,$nav_societe->id_societe);


	foreach ($Ht_frais as $Ht_frai) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Frais = Frais_annexe::trouve_par_id($Ht_frai->id_fournisseur); 
	$Ecriture_comptable->id_compte = $Frais->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($Frais->comptes_achat);
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
	$Ecriture_comptable->id_auxiliere = $Frais->auxiliere_achat;
	$Ecriture_comptable->debit = $Ht_frai->somme_ht;
	$Ecriture_comptable->save();
				}

	/////////////////// tva ////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $nav_societe->tva_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($nav_societe->tva_achat);
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
	$Ecriture_comptable->id_auxiliere = $societe->aux_tva_achat;
	$Ecriture_comptable->debit = $TVA->somme_tva;
	$Ecriture_comptable->save();

////////////// TIMBRE ////////////////////////


	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $nav_societe->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($nav_societe->comptes_achat);
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
	$Ecriture_comptable->id_auxiliere = $societe->auxiliere_achat;
	$Ecriture_comptable->debit = $timbres->timbre;
	$Ecriture_comptable->save();

/////// somme_VA ///////////////////////

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
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Fournisseur->auxiliere_achat;
	$Ecriture_comptable->credit = $somme_VA->valeur_DA;
	$Ecriture_comptable->save();


//////////////// TTC ///////////////////
 
	foreach ($somme_ttc as $somme_ttc) {

	$Ecriture_comptable = new Ecriture_comptable();
	$Fournisseur = Fournisseur::trouve_par_id($somme_ttc->Designation); 
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
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Fournisseur->auxiliere_achat;
	$Ecriture_comptable->credit = $somme_ttc->somme_ttc;
	$Ecriture_comptable->save();
				}
/////// TROUVE Fournisseur //////////////////////////////
			 
$Fournisseur = Fournisseur::trouve_par_id($factur->id_fournisseur);
/////////////////////// ajouter piece comptable Entrée stock automatiquement ///////////////////////////////
		$random_number_2 = rand();

	$Pieces_comptables_Entree = new Pieces_comptables();
	$Pieces_comptables_Entree->id_societe = $nav_societe->id_societe;
	$Pieces_comptables_Entree->id_op_auto =  $Fact->id_facture;
	$Pieces_comptables_Entree->type_op =  6;
	$Pieces_comptables_Entree->ref_piece =  $Fact->N_facture;
	$Pieces_comptables_Entree->libelle =  'ENTRÉE STOCK - '.$Fournisseur->nom;
	$Pieces_comptables_Entree->date =  $Fact->date_fac;
	$Pieces_comptables_Entree->date_valid =  date("Y-m-d");
	$Pieces_comptables_Entree->journal = $nav_societe->journal_achat;
	$Pieces_comptables_Entree->somme_debit = $Fact->somme_ht_frais;
	$Pieces_comptables_Entree->somme_credit = $Fact->somme_ht_frais;
	$Pieces_comptables_Entree->random =  $random_number_2;
	$Pieces_comptables_Entree->save();

///////////// ajouter les ecriture comptable de cette piece /////////////////// 

	$Piece_Entree = Pieces_comptables::trouve_par_random($random_number_2);
	$Ht_Entrees = Famille::calcule_Ht_par_famille_and_facture_achat_importation($Fact->id_facture,$nav_societe->id_societe);



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
				

		foreach ($Ht_frais as $Ht_frai) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Frais = Frais_annexe::trouve_par_id($Ht_frai->id_fournisseur); 
	$Ecriture_comptable->id_compte = $Frais->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($Frais->comptes_achat);
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
	$Ecriture_comptable->id_auxiliere = $Frais->auxiliere_achat;
	$Ecriture_comptable->credit = $Ht_frai->somme_ht;
	$Ecriture_comptable->save();
				}	
			 readresser_a("invoice_importation.php?id=".$Fact->id_facture."&action=achat");
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

}else if ($action == 'update_importation') {

	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
   echo   $id = intval($_GET['id']);
     $factur = Facture_importation::trouve_par_id($id);
     $date = date_parse($factur->date_fac);
 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
 	$id = intval($_POST['id']);
 	$factur = Facture_importation::trouve_par_id($id);

 	$date = date_parse($factur->date_fac);
	 
 }


////////////////////////////// remove old Quantité of achat from Articles and delete achat from table ACHAT ///////////////////////

				$table_achats = Achat_importation::trouve_achat_par_facture($id);
				$table_frais = Achat_importation::trouve_frais_par_facture($id);
				
				foreach($table_achats as $table_achat){ 
					$lot = lot_prod::trouve_lot_par_facture_and_type_and_prod(2,$table_achat->id_prod,$id);

					if (isset($lot->qte) ) {
					if ($lot->qte_initial != $lot->qte) {
						$errors[]= '  Lot deja consommé !';
						echo $lot->id.'<br>' ; 
					}
					}

				if (empty($errors)){
				$Article = Produit::trouve_par_id($table_achat->id_prod);
		///////////////// mise a jour de QTE stock produit ///////////////
					$Quantite_stock = $Article->stock - $table_achat->Quantite;
					$Article->stock = $Quantite_stock;
					$Article->modifier();
					if (isset($lot->id) ) {
					$lot->supprime();
					}
					$table_achat->supprime();
				}else{
					foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
					
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
			 foreach($table_frais as $table_frai){

			 	if (empty($errors)){
			 		$table_frai->supprime();
			 	}

			  }

			
 if (empty($errors)){
try {

				 $bd->beginTransactions();

			 /////////////////////////////// add new Quantité of new achat into articles and save new achat to table ACHAT ///////////////
			 	$Somme_ht = Update_achat_importation::somme_ht_par_facture($id);
				$Somme_tva = Update_achat_importation::somme_tva_par_facture($id);
				$Somme_ttc = Update_achat_importation::somme_ttc_par_facture($id);  
			///////////////////////////  somme frais ////////////////////////////////////////////
				$Somme_ht_frais = Update_achat_importation::somme_ht_frais_par_facture($id);
				$Somme_tva_frais = Update_achat_importation::somme_tva_frais_par_facture($id);
				$Somme_ttc_frais = Update_achat_importation::somme_ttc_frais_par_facture($id);
			 $nav_societe = Societe::trouve_par_id($_SESSION['societe']);
			$table_frais = Update_achat_importation::trouve_frais_notvalide_par_facture($id);
			$table_update_achats = Update_achat_importation::trouve_achat_notvalide_par_facture($id);
			if (!empty($table_update_achats)) {
					$last_fournisseur = Update_achat_importation::trouve_last_fournisseur_par_id_facture($id);
					
					}
					
				foreach($table_update_achats as $table_update_achat){ 
					$lot = lot_prod::trouve_lot_par_facture_and_type_and_prod(2,$table_update_achat->id_prod,$id);
					if (isset($lot->qte) ) {

						if ($lot->qte_initial != $lot->qte) {
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

					///////////////////////// inset into histo_achat table ///////////////////////:
			$SQL2 = $bd->requete("INSERT INTO `histo_achat` (`id`, `lib_prod`, `code_prod`, `id_prod`, `id_facture`, `Quantite_achat`, `Quantite_stock`) VALUES (NULL, '$table_achat->Designation', '$table_update_achat->Code', '$table_update_achat->id_prod', '$table_update_achat->id_facture', '$table_update_achat->Quantite', '$Article->stock');");

	$Achat = new Achat_importation();
	$Achat->Prix_devise = $table_update_achat->Prix_devise;
	$Achat->id_fournisseur = htmlentities(trim($_POST['fournisseur']));
	$Achat->Num_facture = htmlentities(trim($_POST['Num_facture']));
	$Achat->id_facture = $table_update_achat->id_facture;
	$Achat->id_prod = $table_update_achat->id_prod;
	$Achat->id_famille = $table_update_achat->id_famille;
	$Achat->Remise = $table_update_achat->Remise;
	$Achat->Quantite = $table_update_achat->Quantite;
	$Ht_devise = $Achat->Quantite * $Achat->Prix_devise;
	$Achat->id_person = $table_update_achat->id_person;
	$Achat->id_societe = $table_update_achat->id_societe;
	$Achat->Prix = $table_update_achat->Prix;
	$Achat->Contre_Valeur = $table_update_achat->Contre_Valeur;
	$Achat->Ht = $table_update_achat->Ht;
	$Achat->date_fact = htmlentities(trim($_POST['date_fact']));
	$Achat->shipping = htmlentities(trim($_POST['shipping']));
	$Achat->Ht_devise =  $Ht_devise - $Achat->Remise ;
	$Achat->total = $Achat->Ht_devise  ;
	$Achat->Designation = $table_update_achat->Designation;
	$Achat->Code = $table_update_achat->Code;
	$Achat->save();


			////// creat new lot /////////////////: 

	$last_achat = Achat_importation::trouve_last_fournisseur_par_id_facture($id);

						$Lot_prod = new Lot_prod();
						$Lot_prod->code_lot = rand();
						$Lot_prod->id_societe = $table_update_achat->id_societe;
						$Lot_prod->id_prod = $Article->id_pro;
						$Lot_prod->id_facture = $table_update_achat->id_facture;
						if (isset($last_achat->id)) {
						$Lot_prod->id_achat = $last_achat->id;
						}
						$Lot_prod->qte_initial = $table_update_achat->Quantite;
						$Lot_prod->qte = $table_update_achat->Quantite;
						$Lot_prod->prix_achat = $table_update_achat->Prix;
						$Lot_prod->prix_vente = $Article->prix_vente;
						$Lot_prod->date_lot = htmlentities(trim($_POST['date_fact']));
						$Lot_prod->type_achat = 2;
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

			}

	if (empty($errors)){
foreach($table_frais as $table_frai){ 

			///////////////// mise a jour de table update_achat etat = 1 ////////////
					$table_frai->etat = 1;
					$table_frai->modifier();


	$Achat = new Achat_importation();
	$Achat->Prix_devise = $table_frai->Prix_devise;
	$Achat->id_fournisseur = $table_frai->id_fournisseur;
	$Achat->Num_facture = $table_frai->Num_facture;
	$Achat->id_facture = $table_frai->id_facture;
	$Achat->id_prod = $table_frai->id_prod;
	$Achat->valeur_DA = $table_frai->valeur_DA;
	$Achat->id_famille = $table_frai->id_famille;
	$Achat->Remise = $table_frai->Remise;
	$Achat->Quantite = $table_frai->Quantite;
	$Achat->id_person = $table_frai->id_person;
	$Achat->id_societe = $table_frai->id_societe;
	$Achat->date_fact = $table_frai->date_fact;
	$Achat->Ht = $table_frai->Ht;
	$Achat->Tva =  $table_frai->Tva;
	$Achat->timbre =  $table_frai->timbre;
	$Achat->somme_ht =  $table_frai->somme_ht;
	$Achat->total = $table_frai->total;
	$Achat->is_frais_annexes = $table_frai->is_frais_annexes;
	$Achat->Designation = $table_frai->Designation;
	$Achat->save();

}


	$factur->id_fournisseur = htmlentities(trim($_POST['fournisseur']));
	$factur->date_fac = htmlentities(trim($_POST['date_fact']));
	$factur->shipping = htmlentities(trim($_POST['shipping']));
	$factur->somme_ht =  $Somme_ht->somme_ht;
	$factur->somme_tva =  $Somme_tva->somme_tva;
	$factur->somme_ttc =  $Somme_ttc->somme_ttc;
	$factur->somme_ht_frais =  $Somme_ht_frais->somme_ht;
	$factur->somme_tva_frais =  $Somme_tva_frais->somme_tva;
	$factur->somme_timbre_frais =  $Somme_timbre_frais->timbre;
	$factur->somme_ttc_frais =  $Somme_ttc_frais->somme_ttc;
	$factur->Num_facture =  htmlentities(trim($_POST['Num_facture']));



	//////////////////////////////////////////////////
		$factur->save();

/////////////////////// Modifier piece comptable automatiquement ///////////////////////////////

	$Piece = Pieces_comptables::trouve_par_operation_and_type($factur->id_facture,8);
	$Fournisseur = Fournisseur::trouve_par_id(17);



	$Piece->libelle =  'FACTURE ACHAT IMPORTATION - '.$Fournisseur->nom;
	$Piece->date =  $factur->date_fac;
	$Piece->somme_debit = $factur->somme_ttc_frais;
	$Piece->somme_credit = $factur->somme_ttc_frais;
	$Piece->modifier();

////////////////// delete old ecriture_comptable par id_piece /////////////////////////////

	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece->id);
///////////// ajouter les ecriture comptable de cette piece /////////////////// 

	$Ht_frais = Achat_importation::trouve_somme_ht_frais_par_facture($factur->id_facture,$nav_societe->id_societe);
	$TVA = Achat_importation::somme_tva_frais_par_facture($factur->id_facture,$nav_societe->id_societe);
	$timbres = Achat_importation::somme_timbre_frais_par_facture($factur->id_facture,$nav_societe->id_societe);
	$somme_ttc = Achat_importation::trouve_somme_ttc_frais_par_facture($factur->id_facture,$nav_societe->id_societe);
	$somme_VA = Achat_importation::somme_VA_frais_par_facture($factur->id_facture,$nav_societe->id_societe);


	foreach ($Ht_frais as $Ht_frai) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Frais = Frais_annexe::trouve_par_id($Ht_frai->id_fournisseur); 
	$Ecriture_comptable->id_compte = $Frais->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($Frais->comptes_achat);
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
	$Ecriture_comptable->id_auxiliere = $Frais->auxiliere_achat;
	$Ecriture_comptable->debit = $Ht_frai->somme_ht;
	$Ecriture_comptable->save();
				}

	/////////////////// tva ////////////////////

	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $nav_societe->tva_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($nav_societe->tva_achat);
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
	$Ecriture_comptable->id_auxiliere = $societe->aux_tva_achat;
	$Ecriture_comptable->debit = $TVA->somme_tva;
	$Ecriture_comptable->save();

////////////// TIMBRE ////////////////////////


	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $nav_societe->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($nav_societe->comptes_achat);
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
	$Ecriture_comptable->id_auxiliere = $societe->auxiliere_achat;
	$Ecriture_comptable->debit = $timbres->timbre;
	$Ecriture_comptable->save();

/////// somme_VA ///////////////////////

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
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Fournisseur->auxiliere_achat;
	$Ecriture_comptable->credit = $somme_VA->valeur_DA;
	$Ecriture_comptable->save();


//////////////// TTC ///////////////////
 
	foreach ($somme_ttc as $somme_ttc) {

	$Ecriture_comptable = new Ecriture_comptable();
	$Fournisseur = Fournisseur::trouve_par_id($somme_ttc->Designation); 
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
	$Ecriture_comptable->id_person = $user->id;
	$Ecriture_comptable->id_societe = $Piece->id_societe;
	$Ecriture_comptable->id_auxiliere = $Fournisseur->auxiliere_achat;
	$Ecriture_comptable->credit = $somme_ttc->somme_ttc;
	$Ecriture_comptable->save();
				}
	/////////////////////// modifier piece comptable Entrée stock automatiquement ///////////////////////////////

	$Piece_Entree = Pieces_comptables::trouve_par_operation_and_type($factur->id_facture,6);	

	$Piece_Entree->libelle =  'ENTRÉE STOCK - '.$Fournisseur->nom;
	$Piece_Entree->date =  $factur->date_fac;
	$Piece_Entree->somme_debit = $factur->somme_ht_frais;
	$Piece_Entree->somme_credit = $factur->somme_ht_frais;
	$Piece_Entree->facture_scan = $factur->facture_scan;
	$Piece_Entree->modifier();

	////////////////// delete old ecriture_comptable par id_piece /////////////////////////////

	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece_Entree->id);

	$Ht_Entrees = Famille::calcule_Ht_par_famille_and_facture_achat_importation($factur->id_facture,$nav_societe->id_societe);


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
				

		foreach ($Ht_frais as $Ht_frai) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Frais = Frais_annexe::trouve_par_id($Ht_frai->id_fournisseur); 
	$Ecriture_comptable->id_compte = $Frais->comptes_achat;
	$Compte_comp = Compte_comptable::trouve_par_id($Frais->comptes_achat);
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
	$Ecriture_comptable->id_auxiliere = $Frais->auxiliere_achat;
	$Ecriture_comptable->credit = $Ht_frai->somme_ht;
	$Ecriture_comptable->save();
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
		//	 readresser_a("invoice_importation.php?id=".$factur->id_facture."&action=achat");
	$bd->commitTransactions();
			} catch (Exception $e) {
			    // If there's an error, rollback the transaction:
			$bd->rollbackTransactions();
			}
       }
       else{
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
//////



}
$titre = "ThreeSoft | Importation ";
$active_menu = "importation";
$header = array('table');
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
?>
<?php
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id_facture = htmlspecialchars(trim($_GET['id'])); 
	 }


if(isset($_POST['submit']) && $action == 'add_importation'){
	$errors = array();
		// new object edit_frais
	
	// new object admin edit_frais
	
	$Importations = new Frais_annexe();
	
	
	$Importations->designation = htmlentities(trim($_POST['designation']));
	$Importations->is_douane = htmlentities(trim($_POST['is_douane']));
	$Importations->id_societe = $nav_societe->id_societe;
	$Importations->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$Importations->comptes_vente = htmlentities(trim($_POST['comptes_vente']));
	$Importations->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$Importations->auxiliere_vente = htmlentities(trim($_POST['auxiliere_vente']));
	
	
	

	if (empty($errors)){
if ($Importations->existe()) {
			$msg_error = '<p >  Frais annexe existe déja !!!</p><br />';
			
		}else{
			$Importations->save();
 		$msg_positif = '<p ">      Frais annexe est bien ajouter  </p><br />';
		
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

if($action == 'edit_frais_importation' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$edit_frais = Frais_annexe:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$edit_frais = Frais_annexe:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object edit_frais
	
	// new object admin edit_frais
	
	$edit_frais->designation = htmlentities(trim($_POST['designation']));
	$edit_frais->is_douane = htmlentities(trim($_POST['is_douane']));
	$edit_frais->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$edit_frais->comptes_vente = htmlentities(trim($_POST['comptes_vente']));
	
	$edit_frais->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$edit_frais->auxiliere_vente = htmlentities(trim($_POST['auxiliere_vente']));


	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit_frais->save()){
		$msg_positif .= '<p >    Frais annexe est modifié  avec succes </p><br />';
													
														
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
	if(isset ($_POST['submit']) && $action == 'upload_importation' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$upload_importation = Facture_importation:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$upload_importation = Facture_importation:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 


	$errors = array();
		// new object Upload
		
	
	 $upload_importation->facture_scan = htmlentities(trim($_POST['id_scan']));

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($upload_importation->save()){
			
					
		$msg_positif = '<p >  Facture N° : <b>' . $upload_importation->id_facture . '</b> est bien ajouter - <a href="operation.php?action=list_achat">  Liste des Achat</a> </p><br />';
													
														
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

	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="container-fluid">
			<!-- BEGIN PAGE CONTENT-->
			
			<!-- BEGIN PAGE HEADER-->
			
			<div class="page-bar">
				<ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Importation</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'list_importation') { ?>
                        <a href="#"><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;
						
						} ?></a> 
                        
                        
                    <?php }elseif ($action == 'add_importation') {
                        echo '<a href="importation.php?action=add_importation">Ajouter Frais </a> ';
                    } elseif ($action == 'edit_importation') {
                        echo '<a href="importation.php?action=edit_importation">Modifier </a> ';
                    }elseif ($action == 'list_achat'){echo '<a href="importation.php?action=list_achat">Liste Achat </a> ';
					}elseif ($action == 'importation'){echo '<a href="importation.php?action=importation">Ajouter Achat </a> ';}					?>
                        
                    </li>
				</ul>

			</div>
						<div class="row">
				<div class="col-md-12 ">
                <!-- BEGIN WIDGET MAP -->
                <div class="widget-map">
                    <div id="mapplic" class="widget-map-mapplic"></div>
                    <div class="widget-map-body text-uppercase text-center">
					<div class="widget-sparkline-chart">
						  <a href="importation.php?action=list_achat">
                            <div id="widget_sparkline_bar3"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-list font-blue "></i> Importation</span>
							</a>
                        </div>
					
                        <div class="widget-sparkline-chart">
						 <a href="importation.php?action=importation">
                            <div id="widget_sparkline_bar4"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-shopping-cart font-yellow  "></i> Ajouter Achat</span>
							</a>
                        </div>
                        <div class="widget-sparkline-chart">
							<a href="importation.php?action=list_importation">
                            <div id="widget_sparkline_bar"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-caret-square-o-down font-yellow "></i> Lists des frais annexe</span>
							</a>
							</div>
						
						  <div class="widget-sparkline-chart">
						  <a href="importation.php?action=add_importation">
                            <div id="widget_sparkline_bar2"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-plus-circle font-red-haze"></i> Ajouter Frais</span>
							</a>
                        </div>
						
                    </div>
                </div>
                <!-- END WIDGET MAP -->
            </div>
			</div>
	
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
				if ($action == 'importation') {
				
		
				$Articles = Produit::trouve_produit_importation_par_societe($nav_societe->id_societe);
				$Frais_annexes = Frais_annexe::trouve_frais_annexe_par_societe($nav_societe->id_societe);
				$fournisseurs = Fournisseur::trouve_fournisseur_etranger_par_societe($nav_societe->id_societe); 	
				$tvas = TVA::trouve_tous(); 
				$Somme_ht = Achat_importation::somme_ht_frais($user->id,$nav_societe->id_societe);
				$Somme_tva = Achat_importation::somme_tva_frais($user->id,$nav_societe->id_societe);
				$Somme_ttc = Achat_importation::somme_ttc_frais($user->id,$nav_societe->id_societe);
				$table_achats = Achat_importation::trouve_achat_vide_par_admin($user->id,$nav_societe->id_societe);
				$table_frais = Achat_importation::trouve_frais_vide_par_admin($user->id,$nav_societe->id_societe);
				if (!empty($table_achats)) {
					$last_fournisseur = Achat_importation::trouve_last_fournisseur_par_id_admin($user->id,$nav_societe->id_societe);
					}	
			
				$thisday=date('Y-m-d');
			
		 ?>
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-8">
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Frais annexes
							</div>
						</div>
							<div class="portlet-body table-responsive Frais-annexe">
						<table class="table table-striped table-bordered table-hover" >
							<thead>
							<tr>
								<th width="20%">
									Désignation
								</th>
								<th width="10%">
									 Valeur en DA
								</th>
								<th>
									 Date
								</th>
								<th>
									N° facture
								</th>
								<th>
									 Montant HT 
								</th>
								<th>
									  T.V.A
								</th>
								<th>
									  Timbre
								</th>							
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_frais as $table_frais){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (!empty($table_frais->Designation)) {
										$fourn_service=Fournisseur::trouve_par_id($table_frais->Designation);
										if (isset($fourn_service->nom)) {
										echo $fourn_service->nom;
										}
										
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->valeur_DA)) {
										echo $table_frais->valeur_DA;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->date_fact)) {
										echo $table_frais->date_fact;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->Num_facture)) {
										echo $table_frais->Num_facture;
									} ?>
								</td>
								
								<td>
									<?php if (isset($table_frais->Ht)) {
										echo $table_frais->Ht;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->Tva)) {
										echo $table_frais->Tva;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->timbre)) {
										echo $table_frais->timbre;
									} ?>
								</td>
								
								<td>
									<button  id="delete_frais" value="<?php if (isset($table_frais->id)){ echo $table_frais->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							<tbody>
								
							<tr  >
								
								<td>
									<select class="form-control  select2me"   id="Frais_annexe"  name="Frais_annexe"   placeholder="Choisir Frais" >
										<option value=""></option>
										<?php  foreach ($Frais_annexes as $Frais_annexe) { ?>
											<option value="<?php if(isset($Frais_annexe->id)){echo $Frais_annexe->id; } ?>">
												<?php if (!empty($Frais_annexe->designation)) { $fourn_service = Fournisseur :: trouve_par_id($Frais_annexe->designation);echo $fourn_service->nom; } ?>
											</option>
										<?php } ?>														   
									</select>   
								</td>
								<td class="valeur_DA">
									<input type="number" min="0" id="valeur_DA"  class="form-control   "  disabled  name="valeur_DA" required /> 
								</td>
								<td>
									<input type="date" min="0" id="date_frais"  class="form-control  frais-input "   name="date_frais" required /> 
								</td>
								<td>
									<input type="text"  id="N_facture"  class="form-control input-small frais-input "  name="N_facture" required />
								</td>
								<td>
									<input type="number" min="0" id="M_HT"  class="form-control input-small frais-input " value="0.000" name="M_HT" required /> 
								</td>
								<td>
									 <input type="number" min="0" id="M_TVA"  class="form-control input-small frais-input " value="0.000" name="M_TVA" required />
								</td>
								<td>
									 <input type="number" min="0" id="autre"  class="form-control input-small frais-input " value="0.000" name="autre" required />
								</td>
								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit_frais"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total-frais">
								<tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.000";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.000";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.000";}  ?> DA</span></td>
							    </tr>

										
                            </tbody>
							</table>

							</div>
							

						</div>
					
				
					
			
<?php 
					$Somme_ht = Achat_importation::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Achat_importation::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Achat_importation::somme_ttc($user->id,$nav_societe->id_societe);
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
										Importation
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
														} ?> value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>">
														<?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?>
												</option>
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
													<div class="col-md-8">
														
															<input type="date" name = "date_fact" id="date_fact" class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
										</div>
									</div>  
									<br>                                                                     
                                    <div class="row">
                                       
                                        <div class="col-md-6">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-3 control-label">Shipping </label>
													<div class="col-md-8">
														
															<input type="text" name = "shipping" id="shipping"  class="form-control" placeholder="Shipping " value="<?php if (isset($last_fournisseur->shipping)) {echo $last_fournisseur->shipping;  } ?>"  required>
															
														</div>
														
													</div>
												</div>
										 <div class="col-md-6">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-4 control-label">N° Facture </label>
													<div class="col-md-8">
														
															<input type="text" name = "Num_facture"  id = "Num_facture" class="form-control" placeholder="N° Facture " value="<?php if (isset($last_fournisseur->Num_facture)) {echo $last_fournisseur->Num_facture;  } ?>"  required>
															
														</div>
														
													</div>
										</div>
                                      
									
										
                                	   </div>
                                 </div>
							</div>
							<br><br>
							<div class="portlet-body notification table-responsive">
						<table class="table table-striped table-bordered table-hover" id="table_2" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								<th width="60">
									Code
								</th>
								<th>
									 Qté 
								</th>
								<th>
									  PU($)
								</th>
								<th>
									  Remise
								</th>
								<th>
									VA($)
								</th>
								<th>
									VA(DA) 
								</th>
								<th>
									CV
								</th>
								<th>
									PU(DA)
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
									<?php if (isset($table_achat->Prix_devise)) {
										echo $table_achat->Prix_devise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Remise)) {
										echo $table_achat->Remise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Ht_devise)) {
										echo $table_achat->Ht_devise;
									} ?>
									
								</td>
								<td>
									<?php if (isset($table_achat->Ht)) {
										echo $table_achat->Ht;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Contre_Valeur)) {
										echo $table_achat->Contre_Valeur;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo $table_achat->Prix;
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
								<td></td>
								<td></td>

								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL ACHAT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.000";}  ?> $</span></td>
							    </tr>
							     <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> SHIPPING : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php if (isset($last_fournisseur->shipping)) {echo $last_fournisseur->shipping;  }  else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT: </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc+ $last_fournisseur->shipping; } else {echo "0.000";}  ?> $</span></td>
							    </tr>

										
                            </tbody>
							</table>
							
						</div>
						<div class="panel-footer " align="right">   
								<input type="text" id="id_facture" value="11" class="hidden">
							<a id="valider" class="btn  green " > <i class="fa fa-credit-card"></i>  Valider achat </a>
						    </div>
						</div>
								
										<!-- END FORM-->
									
				</div>
				<div class="col-md-4 list-group-item bg-blue-ebonyclay">
					
							<p>Scan du Facture Importation</p>
				
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
					<a href="#form_modal1" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
					<a href="#form_modal1" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
					<a href="#form_modal1" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
				
				<?php }else {echo '<a href="#form_modal1" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>
				</div>		
			<?php }else if ($action == 'edit_importation') {
				
				$Truncate_table = Update_achat_importation::truncate_table($id_facture);
				$last_update = Update_achat_importation::trouve_last_update_par_id_facture($id_facture);
				if (empty($last_update)) {
				$Insert_achat = Update_achat_importation::insert_achat($id_facture);
				}
				///////////////////////////////////////////////
		
				$Articles = Produit::trouve_produit_importation_par_societe($nav_societe->id_societe);
				$Frais_annexes = Frais_annexe::trouve_frais_annexe_par_societe($nav_societe->id_societe);
				$fournisseurs = Fournisseur::trouve_fournisseur_etranger_par_societe($nav_societe->id_societe); 	
				$tvas = TVA::trouve_tous(); 
				$Somme_ht_frais = Update_achat_importation::somme_ht_frais_par_facture($id_facture);
				$Somme_tva_frais = Update_achat_importation::somme_tva_frais_par_facture($id_facture);
				$Somme_ttc_frais = Update_achat_importation::somme_ttc_frais_par_facture($id_facture);
				$table_achats = Update_achat_importation::trouve_achat_notvalide_par_facture($id_facture);
				$table_frais = Update_achat_importation::trouve_frais_notvalide_par_facture($id_facture);
				if (!empty($table_achats)) {
					$last_fournisseur = Update_achat_importation::trouve_last_fournisseur_par_id_facture($id_facture);
					}	
			
				$thisday=date('Y-m-d');
			
		 ?>
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-8">
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Frais annexes
							</div>
						</div>
							<div class="portlet-body table-responsive Frais-annexe">
						<table class="table table-striped table-bordered table-hover" >
							<thead>
							<tr>
								<th width="20%">
									Désignation
								</th>
								<th width="10%">
									 Valeur en DA
								</th>
								<th>
									 Date
								</th>
								<th>
									N° facture
								</th>
								<th>
									 Montant HT 
								</th>
								<th>
									  T.V.A
								</th>
								<th>
									  Timbre
								</th>							
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_frais as $table_frais){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (!empty($table_frais->Designation)) {
										$fourn_service=Fournisseur::trouve_par_id($table_frais->Designation);
										if (isset($fourn_service->nom)) {
										echo $fourn_service->nom;
										}
										
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->valeur_DA)) {
										echo $table_frais->valeur_DA;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->date_fact)) {
										echo $table_frais->date_fact;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->Num_facture)) {
										echo $table_frais->Num_facture;
									} ?>
								</td>
								
								<td>
									<?php if (isset($table_frais->Ht)) {
										echo $table_frais->Ht;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->Tva)) {
										echo $table_frais->Tva;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->timbre)) {
										echo $table_frais->timbre;
									} ?>
								</td>
								
								<td>
									<button  id="delete_frais" value="<?php if (isset($table_frais->id)){ echo $table_frais->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							<tbody>
								
							<tr  >
								
								<td>
									<select class="form-control  select2me"   id="Frais_annexe"  name="Frais_annexe"   placeholder="Choisir Frais" >
										<option value=""></option>
										<?php  foreach ($Frais_annexes as $Frais_annexe) { ?>
											<option value="<?php if(isset($Frais_annexe->id)){echo $Frais_annexe->id; } ?>">
												<?php if (!empty($Frais_annexe->designation)) { $fourn_service = Fournisseur :: trouve_par_id($Frais_annexe->designation);echo $fourn_service->nom; } ?>
											</option>
										<?php } ?>														   
									</select>   
								</td>
								<td class="valeur_DA">
									<input type="number" min="0" id="valeur_DA"  class="form-control   "  disabled  name="valeur_DA" required /> 
								</td>
								<td>
									<input type="date" min="0" id="date_frais"  class="form-control  frais-input "   name="date_frais" required /> 
								</td>
								<td>
									<input type="text"  id="N_facture"  class="form-control input-small frais-input "  name="N_facture" required />
								</td>
								<td>
									<input type="number" min="0" id="M_HT"  class="form-control input-small frais-input " value="0.000" name="M_HT" required /> 
								</td>
								<td>
									 <input type="number" min="0" id="M_TVA"  class="form-control input-small frais-input " value="0.000" name="M_TVA" required />
								</td>
								<td>
									 <input type="number" min="0" id="autre"  class="form-control input-small frais-input " value="0.000" name="autre" required />
								</td>
								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit_frais"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total-frais">
								<tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht_frais->somme_ht)){echo number_format($Somme_ht_frais->somme_ht,3,'.',' ') ;} else {echo "0.000";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva_frais->somme_tva)){echo number_format($Somme_tva_frais->somme_tva,3,'.',' ');} else {echo "0.000";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc_frais->somme_ttc)){echo number_format($Somme_ttc_frais->somme_ttc,3,'.',' ');} else {echo "0.000";}  ?> DA</span></td>
							    </tr>

										
                            </tbody>
							</table>

							</div>
							

						</div>
					
				
					
			
<?php 

				$Somme_ht = Update_achat_importation::somme_ht_par_facture($id_facture);
				$Somme_tva = Update_achat_importation::somme_tva_par_facture($id_facture);
				$Somme_ttc = Update_achat_importation::somme_ttc_par_facture($id_facture);
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
										Importation
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
														} ?> value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>">
														<?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?>
												</option>
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
													<div class="col-md-8">
														
															<input type="date" name = "date_fact" id="date_fact" class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
										</div>
									</div>  
									<br>                                                                     
                                    <div class="row">
                                       
                                        <div class="col-md-6">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-3 control-label">Shipping </label>
													<div class="col-md-8">
														
															<input type="text" name = "shipping" id="shipping"  class="form-control" placeholder="Shipping " value="<?php if (isset($last_fournisseur->shipping)) {echo $last_fournisseur->shipping;  } ?>"  required>
															
														</div>
														
													</div>
												</div>
										 <div class="col-md-6">
                                    		
                                           		 <div class="form-group ">
													<label class="col-md-4 control-label">N° Facture </label>
													<div class="col-md-8">
														
															<input type="text" name = "Num_facture"  id = "Num_facture" class="form-control" placeholder="N° Facture " value="<?php if (isset($last_fournisseur->Num_facture)) {echo $last_fournisseur->Num_facture;  } ?>"  required>
															
														</div>
														
													</div>
										</div>
                                      
									
										
                                	   </div>
                                 </div>
							
							<br><br>
							<div class="portlet-body notification table-responsive">
						<table class="table table-striped table-bordered table-hover" id="table_2" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								<th width="60">
									Code
								</th>
								<th>
									 Qté 
								</th>
								<th>
									  PU($)
								</th>
								<th>
									  Remise
								</th>
								<th>
									VA($)
								</th>
								<th>
									VA(DA) 
								</th>
								<th>
									CV
								</th>
								<th>
									PU(DA)
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
									<?php if (isset($table_achat->Prix_devise)) {
										echo $table_achat->Prix_devise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Remise)) {
										echo $table_achat->Remise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Ht_devise)) {
										echo $table_achat->Ht_devise;
									} ?>
									
								</td>
								<td>
									<?php if (isset($table_achat->Ht)) {
										echo $table_achat->Ht;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Contre_Valeur)) {
										echo $table_achat->Contre_Valeur;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo $table_achat->Prix;
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
								<td></td>
								<td></td>

								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL ACHAT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.000";}  ?> $</span></td>
							    </tr>
							     <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> SHIPPING : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php if (isset($last_fournisseur->shipping)) {echo $last_fournisseur->shipping;  }  else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT: </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc+ $last_fournisseur->shipping; } else {echo "0.000";}  ?> $</span></td>
							    </tr>

										
                            </tbody>
							</table>
							
						</div>
						<div class="panel-footer " align="right">   
								<input type="text" id="id" name="id" value="<?php if (isset($id_facture)) {echo $id_facture ;} ?>" class="hidden">

							<button   id="valider" class="btn  green " > <i class="fa fa-credit-card"></i>  Valider achat </button>
						    </div>
						  
						</div>
						</div>		
										<!-- END FORM-->
									
				</div>
				<div class="col-md-4 list-group-item bg-blue-ebonyclay">
					
							<p>Scan du Facture Importation</p>
				
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
					<a href="#form_modal1" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
					<a href="#form_modal1" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
					<a href="#form_modal1" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
				
				<?php }else {echo '<a href="#form_modal1" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>
				</div>
			<?php }elseif ($action =='list_achat'){
						if (isset($_POST['submit']) ) {
				
							$date_db = trim(htmlspecialchars($_POST['date_db']));
							$date_fin = trim(htmlspecialchars($_POST['date_fin']));
								$factures = Facture_importation::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);
							}else{
								$factures = Facture_importation::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
							}
						$cpt = 0;
			?>
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>Factures <span class="caption-helper">&nbsp;&nbsp;()</span>
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-4">
										<div class="btn-group">
											
											<a href="importation.php?action=importation" class="btn yellow-crusta ">Nouvelle facture  <i class="fa fa-plus"></i></a>
											
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
									Date facture
								</th>
								<th>
									Fournisseur
								</th>
								<th>
									Total TTC
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
							<tr>
								
								
								<td>
								<a href="invoice_importation.php?id=<?php echo $facture->id_facture; ?>" class="">
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
									<?php if (isset($facture->somme_ttc)) {
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
									
									<a href="importation.php?action=edit_importation&id=<?php echo $facture->id_facture; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									
								</td>
							</tr>

							<?php
								}
							?>
							
							</tbody>
							
							</table>
							<a href="print.php?action=print_impotation&date_db=<?php echo $date_db;?>&date_fin=<?php echo $date_fin;?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Imprimer</a>
						</div>
					</div>
			<!-- END upload file-->
				<?php  } else if ($action=='upload_importation') {
			if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
						$id = $_GET['id']; 
						$Upload_achat = Facture_importation:: trouve_par_id($id);
						 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
							 $id = $_POST['id'];
						$Upload_achat = Facture_importation:: trouve_par_id($id);
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
								<form action="<?php echo $_SERVER['PHP_SELF']?>?action=upload_importation" method="POST" class="form-horizontal" enctype="multipart/form-data">
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
				<?php }	else if ($action == 'list_importation') {
				
				?>
				<div class="row">
				<div class="col-md-12">

				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$Frais_annexes = Frais_annexe::trouve_frais_annexe_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-8">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-navicon font-blue-hoki"></i>Frais Annexe 
							</div>
						</div>
					<a href="importation.php?action=add_importation" class="btn yellow-crusta ">Ajouter Frais Annexe  <i class="fa fa-plus"></i></a>
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="">
							<thead>
							<tr>
								
								<th>
									Frais
								</th>
								<th>
									Douane
								</th>
								<th>
									Compte Achat 
								</th>
								<th>
									Compte Vente 
								</th>
								<th>
									prefixe_achat 
								</th>
								<th>
									prefixe_vente
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($Frais_annexes as $frais_annexe){
									$cpt ++;
								?>
							<tr>
								
								<td>
									<b><?php if (!empty($frais_annexe->designation)) {
										 $fourn_service = Fournisseur ::trouve_par_id($frais_annexe->designation);
									echo $fourn_service->nom;
									} ?></b>
								</td>
								<td>
									<?php if (isset($frais_annexe->is_douane) && $frais_annexe->is_douane ==1) {
										
									echo '<i class="fa  fa-check-square font-green"></i>';
									}else{ echo '<i class="fa  fa-times-circle font-red"></i>';} ?>
								</td>
								<td>
									
									<?php if (isset($frais_annexe->comptes_achat)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($frais_annexe->comptes_achat);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									
									<?php if (isset($frais_annexe->comptes_vente)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($frais_annexe->comptes_vente);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									<?php if (isset($frais_annexe->auxiliere_achat)) {
										$auxilieres = Auxiliere::trouve_par_id($frais_annexe->auxiliere_achat);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>
								</td>
								<td>
									<?php if (isset($frais_annexe->auxiliere_vente)) {
									$auxilieres = Auxiliere::trouve_par_id($frais_annexe->auxiliere_vente);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>
								</td>

								<td>
									
									<a href="importation.php?action=edit_frais_importation&id=<?php echo $frais_annexe->id; ?>" class="btn blue btn-sm">
                                                    <i class="fa fa-edit "></i> </a>
									
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
				<div class="col-md-4">
				<div class="portlet light ">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Frais Annexe!
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse" data-original-title="" title="">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<ol>
							<strong>Frais Annexe :</strong>
								<li>
									 

								</li>
								<li>
									 
								</li>
								<li>
									 
								</li>
								<li>
									
								</li>
								
							</ol>
						</div>
					</div>
				</div>
			</div>
			<?php  

				}elseif ($action == 'add_importation') {		
				  ?>
				  	<!-- BEGIN PAGE CONTENT ADD-->
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


                                <div class="portlet light">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa  fa-tag font-yellow "></i>Ajouter Frais annexe
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->

										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_importation" method="POST" class="form-horizontal" enctype="multipart/form-data">

													<br>
													<br>

											<div class="form-group">
												<label class="col-md-2 control-label">Designation du frais<span class="required" aria-required="true"> * </span></label>
												<div class="col-md-4">
												<select class="form-control  select2me"   id=""  name="designation"   placeholder="Choisir Frais" >
															<option value=""></option>
														<?php $fourn_service =  Fournisseur::trouve_fournisseur_service_par_societe($nav_societe->id_societe);
														foreach ($fourn_service as $fourn_services) { ?>
																	<option value="<?php if(isset($fourn_services->id_fournisseur)){echo $fourn_services->id_fournisseur; } ?>"><?php if (isset($fourn_services->nom)) {echo $fourn_services->nom; } ?> </option>
																<?php } ?>														   
														</select> 
													
													
												</div>
											
													<label class="col-md-2 control-label">Douane <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="is_douane" id="optionsRadios29" value="1" checked> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="is_douane" id="optionsRadios30" value="0" checked> Non </label>
															<label class="radio-inline">
															
														</div>

													</div>

											</div>
											<div class="form-group">
													<label class="col-md-2 control-label">Compte Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option  value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_achat">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($Compte->id);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe, $nav_societe->id_societe);
														foreach($Aux as $Auxs){?>
														
														<option  value = "<?php echo $Auxs->code ?>"  > <?php echo $Auxs->code ?></option>
														
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
												
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_vente"  name="comptes_vente">
												
															<?php 															
															$Compt_vente = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_vente as $Compte_ventes){?>

														<option  value = "<?php echo $Compte_ventes->id ?>"  > <?php echo $Compte_ventes->code .' | '. $Compte_ventes->libelle . ' | '. $Compte_ventes->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_vente">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt_venteId = Compte_comptable::trouve_par_id($Compte_ventes->id);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_venteId->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_vente"  name="auxiliere_vente">
														
														<?php 
														 
														if(!empty($Compt_venteId->prefixe))	{
														$Auxiliere = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_venteId->prefixe, $nav_societe->id_societe);
														foreach($Auxiliere as $Auxs){?>
														
														<option <?php if ($Auxs->id == $famille->comptes_vente) { echo "selected";}?> value = "<?php echo $Auxs->code ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
									</div>
								</div>
			</div>
		</div>
			<!-- PAGE PAGE ADD-->
		<?php }  elseif ($action == 'edit_frais_importation') { ?>
		<!-- BEGIN PAGE EDIT-->
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


                                <div class="portlet light ">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa  fa-navicon font-yellow"></i>Edit Frais annexe
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit_frais_importation" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
									
											<div class="form-group">
												<label class="col-md-2 control-label">Designation du frais<span class="required" aria-required="true"> * </span></label>
												<div class="col-md-4">
												<select class="form-control  select2me"   id=""  name="designation"   placeholder="Choisir Frais" >
												<?php $fourn_service =  Fournisseur::trouve_fournisseur_service_par_societe($nav_societe->id_societe);
														foreach ($fourn_service as $fourn_services) { ?>
														<option <?php if ($fourn_services->id_fournisseur == $edit_frais->designation) { echo "selected";} ?> value="<?php if(isset($fourn_services->id_fournisseur)){echo $fourn_services->id_fournisseur; } ?>"><?php if (isset($fourn_services->nom)) {echo $fourn_services->nom; } ?> </option>
												<?php } ?>														   
												</select> 
													
												</div>
												
													<label class="col-md-2 control-label">Douane <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="is_douane" id="optionsRadios29" value="1" <?php if ($edit_frais->is_douane ==1){ echo 'checked';}?>> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="is_douane" id="optionsRadios30" value="0" <?php if ($edit_frais->is_douane ==0){ echo 'checked';}?>> Non </label>
															<label class="radio-inline">
															
														</div>

													</div>
										
												
											</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option <?php if ($Compte->id == $edit_frais->comptes_achat) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_achat">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($edit_frais->comptes_achat);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $edit_frais->comptes_achat) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
												
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_vente"  name="comptes_vente">
												
															<?php 															
															$Compt_vente = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_vente as $Compte_ventes){?>

														<option <?php if ($Compte_ventes->id == $edit_frais->comptes_vente) { echo "selected";} ?> value = "<?php echo $Compte_ventes->id ?>"  > <?php echo $Compte_ventes->code .' | '. $Compte_ventes->libelle . ' | '. $Compte_ventes->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_vente">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt_venteId = Compte_comptable::trouve_par_id($edit_frais->comptes_vente);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_venteId->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_vente"  name="auxiliere_vente">
														
														<?php 
														 
														if(!empty($Compt_venteId->prefixe))	{
														$Auxiliere = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_venteId->prefixe,$nav_societe->id_societe);
														foreach($Auxiliere as $Auxs){?>
														
														<option <?php if ($Auxs->id == $edit_frais->comptes_vente) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
														<button type="submit" name = "submit" class="btn green">Modifier</button>
														<button type="button" value="back" onclick="history.go(-1)" class="btn  default">Annuler</button>
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
			
			
		<?php	}} ?>
			</div>
			</div>
			</div>
			</div>
			<!-- END CONTENT  ADIT-->
		<div id="form_modal1" class="modal container fade" tabindex="-1">
				
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
				<a  href="importation.php?action=importation&id_img=<?php echo $ScanImage->id;  ?>" class="fancybox-button" data-rel="fancybox-button"   >
					<div class="widget-news ">
						
							<img class="widget-news-left-elem" src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>" alt="" style="width: 80px; height: 80px;">
						
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
	<script>
	////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#comptes_achat', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_achat').load('ajax/prefixe.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>
  	<script>
	////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#comptes_vente', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_vente').load('ajax/prefixe_vente.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>