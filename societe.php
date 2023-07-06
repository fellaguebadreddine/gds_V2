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
$titre = "ThreeSoft | Sociétés ";
$active_menu = "societe";
$active_submenu = "list_societe";
$header = array('table','inputmask');
if ($user->type == "administrateur"){
	if (isset($_GET['action']) && $_GET['action'] =='add_societe' ) {
$action = 'add_societe';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_societe' ) {
$action = 'list_societe';}
else if (isset($_GET['action']) && $_GET['action'] =='list_user' ) {
$action = 'list_user';
$active_menu = "user";}
else if (isset($_GET['action']) && $_GET['action'] =='add_user' ) {
	$action = 'add_user';
	$active_menu = "user";}
else if (isset($_GET['action']) && $_GET['action'] =='edit_user' ) {
	$action = 'edit_user';
	$active_menu = "user";}
else if (isset($_GET['action']) && $_GET['action'] =='affiche_societe' ) {
$action = 'affiche_societe';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$action = 'edit';
 if (isset($_POST['id'])|| !empty($_POST['id'])){
	       $id = intval($_POST['id']);
			$editSoct = Societe::trouve_par_id($id);
        }elseif (isset($_GET['id'])|| !empty($_GET['id'])){
	       $id = intval($_GET['id']);
		   $editSoct = Societe::trouve_par_id($id);
        }
}
if (isset($_GET['action']) && $_GET['action'] =='ajouter_tva' ) {
$active_submenu = "add_tva";
$action = 'ajouter_tva';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='tab_tva' ) {
$active_menu = "#";
$active_submenu = "tab_tva";
$action = 'tab_tva';}
else if (isset($_GET['action']) && $_GET['action'] =='ajouter_banque' ) {
	$active_menu = "#";
	$active_submenu = "banque";
	$action = 'ajouter_banque';}
else if (isset($_GET['action']) && $_GET['action'] =='edit_banque' ) {
		$active_menu = "#";
		$active_submenu = "banque";
		$action = 'edit_banque';}
else if (isset($_GET['action']) && $_GET['action'] =='banque' ) {
		$active_menu = "#";
		$active_submenu = "banque";
		$action = 'banque';}
else if (isset($_GET['action']) && $_GET['action'] =='open' ) {
$action = 'open';}
else if (isset($_GET['action']) && $_GET['action'] =='close_societe' ) {
$action = 'close_societe';}
if($action == 'open' ){
	$errors = array();
	// verification de données 	
        if (isset($_POST['id'])|| !empty($_POST['id'])){
	       $id = intval($_POST['id']);
			$nsociete = Societe::trouve_par_id($id);
        }elseif (isset($_GET['id'])|| !empty($_GET['id'])){
	       $id = intval($_GET['id']);
		   $nsociete = Societe::trouve_par_id($id);
        }
 	if ($nsociete){
   		// perform Update
	$session->set_societe($nsociete->id_societe);
	readresser_a("index.php");
	}
}
if ($action=='close_societe') {
$session->delete_societe();
readresser_a("index.php");
 } // End of the main Submit conditional.
}
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
$thisday=date('Y-m-d');
if(isset($_POST['submit']) && $action == 'add_societe'){
	$errors = array();
	$random_number = rand();
		// new object Societe
	// new object admin Societe
	$societe = new Societe();
	$societe->Taux_interet = htmlentities(trim($_POST['Taux_interet']))/100 ;
	$societe->Dossier = htmlentities(trim($_POST['Dossier']));
	$societe->wilayas = htmlentities(trim($_POST['wilayas']));
	$societe->commune = htmlentities(trim($_POST['commune']));
	$societe->type = htmlentities(trim($_POST['type']));
	$societe->Raison = htmlentities(trim($_POST['Raison']));
	$societe->Adresse = htmlentities(trim($_POST['Adresse']));
	$societe->Ville = htmlentities(trim($_POST['Ville']));
	$societe->Postal = htmlentities(trim($_POST['Postal']));
	$societe->Rc = htmlentities(trim($_POST['Rc']));
	$societe->Mf = htmlentities(trim($_POST['Mf']));
	$societe->Ai = htmlentities(trim($_POST['Ai']));
	$societe->Nis = htmlentities(trim($_POST['Nis']));
	$societe->Tel1 = htmlentities(trim($_POST['Tel1']));
	$societe->Tel2 = htmlentities(trim($_POST['Tel2']));
	$societe->Fax = htmlentities(trim($_POST['Fax']));
	$societe->Mob1 = htmlentities(trim($_POST['Mob1']));
	$societe->Mob2 = htmlentities(trim($_POST['Mob2']));
	$societe->Email = htmlentities(trim($_POST['Email']));
	$societe->Web = htmlentities(trim($_POST['Web']));
	$societe->Activite = htmlentities(trim($_POST['Activite']));
	$societe->Capital = htmlentities(trim($_POST['Capital']));
	$societe->Annee = htmlentities(trim($_POST['Annee']));
	$societe->exercice_debut = htmlentities(trim($_POST['exercice_debut']));
	$societe->exercice_fin = htmlentities(trim($_POST['exercice_fin']));
	$societe->inspection = htmlentities(trim($_POST['inspection']));
	$societe->recette = htmlentities(trim($_POST['recette']));
	$societe->nature = htmlentities(trim($_POST['nature']));
	$societe->journal_achat = 1;
	$societe->journal_vente = 3;
	$societe->journal_depense = 7;
	$societe->journal_stock = 8;
	$societe->journal_production = 9;
	
	
	$societe->Etat = 1;
	$societe->random = $random_number;
	
	if (empty($errors)){
if ($societe->existe()) {
			$msg_error = '<p >  societe    : ' . $societe->Rc	 . ' existe déja !!!</p><br />';
			
		}else{
			$societe->save();

			$last_societe = Societe::trouve_par_random($random_number);


			$Compte_tables=Compte_table::trouve_tous();

			foreach ($Compte_tables as $Compte_table) {

	$compts = new Compte_comptable();
	$compts->code = $Compte_table->code;
	$compts->libelle = $Compte_table->libelle;
	$compts->id_societe = $last_societe->id_societe;
	$compts->save();
				
			}
			$Mode_paiements = Mode_paiement::trouve_tous();
			foreach ($Mode_paiements as $Mode_paiement) {

	$Mode_paiement_societe = new Mode_paiement_societe();
	$Mode_paiement_societe->type = $Mode_paiement->type;
	$Mode_paiement_societe->mode_paiement = $Mode_paiement->mode_paiement;
	$Mode_paiement_societe->id_societe = $last_societe->id_societe;
	$Mode_paiement_societe->etat = 1;
	$Mode_paiement_societe->save();
				
			}
			$add_compts = new Compte_comptable();
	
			$add_compts->code = '645240';
			$add_compts->libelle = 'Timbre sur Achats';
			$add_compts->id_societe = $last_societe->id_societe;
			$add_compts->save();

			
			$add_compt = new Compte_comptable();
			
			$add_compt->code = '447240';
			$add_compt->libelle = 'Timbre sur Ventes';
			$add_compt->id_societe = $last_societe->id_societe;
			
			$add_compt->save();

			$add_compte = new Compte_comptable();
			
			$add_compte->code = '445660';
			$add_compte->libelle = 'TVA sur Achat';
			$add_compte->id_societe = $last_societe->id_societe;
			
			$add_compte->save();
			
/////////// COMPTE COMTABLE PAR DEFAUT TVA SUR IMMOBILISATION

			$add_compts = new Compte_comptable();
	
			$add_compts->code = '445620';
			$add_compts->libelle = 'TVA sur Immobilisation';
			$add_compts->id_societe = $last_societe->id_societe;
			$add_compts->save();
			
			 if (isset($last_societe->id_societe)){
				
				 $compt_achat = Compte_comptable::trouve_par_compt_achat_par_societe($last_societe->id_societe);
								 
				 $edit_s = Societe:: trouve_par_id($last_societe->id_societe);
				 
					$edit_s->comptes_achat = $compt_achat->id;
					$edit_s->save();
		
			
			 }
			  if (isset($last_societe->id_societe)){
				
				 $compt_vente = Compte_comptable::trouve_par_compt_vente_par_societe($last_societe->id_societe);
									
				 $edit_so = Societe:: trouve_par_id($last_societe->id_societe);	
					$edit_so->comptes_vente = $compt_vente->id;
					$edit_so->save();
								
			 }
			 if (isset($last_societe->id_societe)){
				
				$compt_tva_achat = Compte_comptable::trouve_par_compt_TVA_par_societe($last_societe->id_societe);
				$compt_tva_vente = Compte_comptable::trouve_par_compt_vente_TVA_par_societe($last_societe->id_societe);
								   
				$edit_so = Societe:: trouve_par_id($last_societe->id_societe);	
				   $edit_so->tva_achat = $compt_tva_achat->id;
				   $edit_so->save();
							   
			}
			 if (isset($last_societe->id_societe)){
				
				$tva_tabs = Tva_tab::trouve_tous();
					foreach ($tva_tabs as $tva_tab){			   
				
						$add_tva = new Tva();

						$add_tva->Designation = $tva_tab->Designation;
						$add_tva->taux = $tva_tab->taux;
						$add_tva->id_societe = $last_societe->id_societe;
						$add_tva->comptes_achat = $compt_tva_achat->id;
						$add_tva->comptes_vente = $compt_tva_vente->id;

						$add_tva->save();
					}		   
			}
			 if (isset($last_societe->id_societe)){		   
				$compt_caisse = Compte_comptable::trouve_par_compt_caisse_par_societe($last_societe->id_societe);
						$caisse = new Caisse();

						$caisse->Code = 'CAI';
						$caisse->solde = 0;
						$caisse->Designation = 'caisse';
						$caisse->id_societe = $last_societe->id_societe;
						$caisse->comptes_caisse = $compt_caisse->id;
						$caisse->journal = 6;

						$caisse->save();	   
			}
			


 		$msg_positif = '<p >        societe est bien ajouter <a href="societe.php?action=list_societe"> Liste des societes</a> </p>';
		
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

	if($action == 'edit' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$editSoct = Societe:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$editSoct = Societe:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object societe
	
	// new object admin societe
	$editSoct->Dossier = htmlentities(trim($_POST['Dossier']));
	$editSoct->wilayas = htmlentities(trim($_POST['wilayas']));
	$editSoct->commune = htmlentities(trim($_POST['commune']));
	$editSoct->type = htmlentities(trim($_POST['type']));
	$editSoct->Raison = htmlentities(trim($_POST['Raison']));
	$editSoct->Adresse = htmlentities(trim($_POST['Adresse']));
	$editSoct->Ville = htmlentities(trim($_POST['Ville']));
	$editSoct->Postal = htmlentities(trim($_POST['Postal']));
	$Taux_interet = htmlentities(trim($_POST['Taux_interet']))/100;
		if ($Taux_interet != $editSoct->Taux_interet ) {
		$update_taux_interet_prod = Produit::update_pourcentage_prix_vente_produit_par_societe($Taux_interet,$nav_societe->id_societe);
		$update_prix_vente_Lot_prod = Lot_prod::update_prix_vente_produit_par_societe($Taux_interet,$nav_societe->id_societe);
		
	}
	$editSoct->Taux_interet = $Taux_interet ;

	$editSoct->Rc = htmlentities(trim($_POST['Rc']));
	$editSoct->Mf = htmlentities(trim($_POST['Mf']));
	$editSoct->Ai = htmlentities(trim($_POST['Ai']));
	$editSoct->Nis = htmlentities(trim($_POST['Nis']));
	$editSoct->Tel1 = htmlentities(trim($_POST['Tel1']));
	$editSoct->Tel2 = htmlentities(trim($_POST['Tel2']));
	$editSoct->Fax = htmlentities(trim($_POST['Fax']));
	$editSoct->Mob1 = htmlentities(trim($_POST['Mob1']));
	$editSoct->Mob2 = htmlentities(trim($_POST['Mob2']));
	$editSoct->Email = htmlentities(trim($_POST['Email']));
	$editSoct->Web = htmlentities(trim($_POST['Web']));
	$editSoct->Activite = htmlentities(trim($_POST['Activite']));
	$editSoct->Capital = htmlentities(trim($_POST['Capital']));
	$editSoct->Annee = htmlentities(trim($_POST['Annee']));
	$editSoct->exercice_debut = htmlentities(trim($_POST['exercice_debut']));
	$editSoct->exercice_fin = htmlentities(trim($_POST['exercice_fin']));
	$editSoct->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$editSoct->comptes_vente = htmlentities(trim($_POST['comptes_vente']));	
	$editSoct->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$editSoct->auxiliere_vente = htmlentities(trim($_POST['auxiliere_vente']));
	$editSoct->tva_achat = htmlentities(trim($_POST['tva_achat']));
	$editSoct->aux_achat = htmlentities(trim($_POST['aux_achat']));
	$editSoct->journal_achat = htmlentities(trim($_POST['journal_achat']));
	$editSoct->journal_vente = htmlentities(trim($_POST['journal_vente']));
	$editSoct->journal_depense = htmlentities(trim($_POST['journal_depense']));
	$editSoct->journal_stock = htmlentities(trim($_POST['journal_stock']));
	$editSoct->journal_production = htmlentities(trim($_POST['journal_production']));
	$editSoct->inspection = htmlentities(trim($_POST['inspection']));
	$editSoct->recette = htmlentities(trim($_POST['recette']));
	$editSoct->nature = htmlentities(trim($_POST['nature']));
	
	$editSoct->Etat = htmlentities(trim($_POST['Etat']));
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($editSoct->save()){
		$msg_positif .= '<p >  Le societe ' . html_entity_decode($editSoct->Rc) . '  est modifié  avec succes </p><br />';
	
														
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
 // ajouter TVA 
 if(isset($_POST['submit']) && $action == 'add_tva'){
	$errors = array();
		// new object TVA
	
	// new object admin TVA
	
	$tva = new Tva_tab();
	
	$tva->id_societe = $nav_societe->id_societe;
	$tva->Designation = htmlentities(trim($_POST['Designation']));
	$tva->taux = htmlentities(trim($_POST['taux']))/100;
	
	

	if (empty($errors)){
if ($tva->existe()) {
			$msg_error = '<p >  TVA    : ' . $tva->Designation	 . ' existe deja !!!</p><br />';
			
		}else{
			$tva->save();
 		$msg_positif = '<p ">        TVA est bien ajouter  </p><br />';
		
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
// Banque


if(isset($_POST['submit']) && $action == 'ajouter_banque'){
	$errors = array();
		// new object Banque
	
	// new object admin Banque
	
	$banque = new Banque();
	
	$banque->Code = htmlentities(trim($_POST['Code']));
	$banque->Designation = htmlentities(trim($_POST['Designation']));
	$banque->abreviation = htmlentities(trim($_POST['abreviation']));
	$banque->Adresse = htmlentities(trim($_POST['Adresse']));
	$banque->Ville = htmlentities(trim($_POST['Ville']));
	$banque->Postal = htmlentities(trim($_POST['Postal']));
	$banque->Tel = htmlentities(trim($_POST['Tel']));
	$banque->Type = htmlentities(trim($_POST['Type']));
	$banque->journal = htmlentities(trim($_POST['journal']));
	$banque->NCompte = htmlentities(trim($_POST['NCompte']));
	$banque->Jc = htmlentities(trim($_POST['Jc']));
	$banque->Jtc = htmlentities(trim($_POST['Jtc']));
	

	

	if (empty($errors)){
if ($banque->existe()) {
			$msg_error = '<p >  banque    : ' . $banque->NCompte	 . ' existe déja !!!</p><br />';
			
		}else{
			$banque->save();
 		$msg_positif = '<p ">        banque est bien ajouter  </p><br />';
		
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
if($action == 'edit_banque' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$banque = Banque:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$banque = Banque:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object banque
	
	// new object admin banque
	$banque->Code = htmlentities(trim($_POST['Code']));
	$banque->Designation = htmlentities(trim($_POST['Designation']));
	$banque->abreviation = htmlentities(trim($_POST['abreviation']));
	$banque->Adresse = htmlentities(trim($_POST['Adresse']));
	$banque->Ville = htmlentities(trim($_POST['Ville']));
	$banque->Postal = htmlentities(trim($_POST['Postal']));
	$banque->Tel = htmlentities(trim($_POST['Tel']));
	$banque->Type = htmlentities(trim($_POST['Type']));
	$banque->journal = htmlentities(trim($_POST['journal']));
	$banque->NCompte = htmlentities(trim($_POST['NCompte']));
	$banque->Jc = htmlentities(trim($_POST['Jc']));
	$banque->Jtc = htmlentities(trim($_POST['Jtc']));

	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($banque->save()){
		$msg_positif .= '<p >  La banque ' . html_entity_decode($banque->Code) . '  est modifié  avec succes </p><br />';
													
														
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['submit']) && $action == 'add_user'){
			$errors = array();
			
	////////////// creat new objet user 
	
		$administrateur = new Accounts();
			
		$administrateur->user = htmlentities(trim($_POST['user']));
		$administrateur->nom = htmlentities(trim($_POST['nom']));
		$administrateur->prenom = htmlentities(trim($_POST['prenom']));
		$administrateur->id_societe = htmlentities(trim($_POST['id_societe']));
		$administrateur->active = 1;
		$administrateur->date_creation = mysql_datetime();
		// verification de données 	
		if (isset($_POST['password'])&& !empty($_POST['password'])){
			if($_POST['password'] != $_POST['rpassword']){
			 $errors[]='Fausse confirmation de mot de passe.'; 
			 }else{
			  $administrateur->mot_passe = password_hash($_POST['password'], PASSWORD_BCRYPT);
			}
		}
		$administrateur->phash = $bd->escape_value(md5(rand(0,1000)));
		$administrateur->type = 'administrateur';
	
	if (empty($errors)){
		if ($administrateur->existe()) {
			$msg_error = '<p > administrateur existe déja !!!</p><br />';			
				;
			}else{
				$administrateur->save();
				
				$msg_positif = "<p>" . html_entity_decode($administrateur->nom) . " a été enregistré en attendant la validation</p><br />";
				
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
	}
	if($action == 'edit_user' ){
		if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id']; 
		$administrateur = Accounts:: trouve_par_id($id);
		 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
			 $id = $_POST['id'];
		$administrateur = Accounts:: trouve_par_id($id);
		 } else { 
				$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
			} 
		if (isset($_POST['submit'])) {
	
		$errors = array();
			
		
		// new object admin administrateur
		$administrateur->user = htmlentities(trim($_POST['user']));
		$administrateur->nom = htmlentities(trim($_POST['nom']));
		$administrateur->prenom = htmlentities(trim($_POST['prenom']));
		$administrateur->id_societe = htmlentities(trim($_POST['id_societe']));
		$administrateur->active = 1;
		$administrateur->date_modif = mysql_datetime();
		// verification de données 	
		if (isset($_POST['password'])&& !empty($_POST['password'])){
			if($_POST['password'] != $_POST['rpassword']){
			 $errors[]='Fausse confirmation de mot de passe.'; 
			 }else{
			  $administrateur->mot_passe = password_hash($_POST['password'], PASSWORD_BCRYPT);
			}
		}
		$administrateur->phash = $bd->escape_value(md5(rand(0,1000)));
		$administrateur->type = 'administrateur';
	
		
		$msg_positif= '';
		 $msg_system= '';
		if (empty($errors)){
						
	
			 if ($administrateur->save()){
			$msg_positif .= '<p >  La banque ' . html_entity_decode($administrateur->user) . '  est modifié  avec succes </p><br />';
														
															
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
                        <a href="#">societe</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_societe') { ?>
                        <a href="societe.php?action=add_societe">Ajouter societe</a> 
                        
                        
                    <?php }elseif ($action == 'list_societe') {
                        echo '<a href="societe.php?action=list_societe">Liste des societes</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="societe.php?action=edit_societe">Modifier societe</a> ';
                    } elseif ($action == 'affiche_societe') {
                        echo '<a href="societe.php?action=affiche_societe">afficher societe</a> ';
                    }?>
                        
                    </li>
				</ul>

			</div>
		<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
		$banques = Banque::trouve_tous();
		$caisses = Caisse::trouve_tous(); 
		 	 $nbr_societe = count($table_ch = Societe::trouve_tous());
			?>

			<?php
				if ($action == 'list_societe') {
				
				?>
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				$societes = Societe::trouve_tous(); 
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						<div class="portlet-title">
						
							
							<div class="caption bold">
											<i class="fa  fa-university font-yellow "></i>Sociétés<span class="caption-helper"> (<?php echo $nbr_societe;?>)</span>
										</div>
								 
							
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group ">
											
											<a href="societe.php?action=add_societe"  class="btn btn-sm red">Nouveau Société <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
							
								</div>
							</div>
							
						<div class="table table-scrollable-borderless">
							<table class="table table-striped table-hover" id="sample_2">
							<thead>
							<tr>
								<th>
									Société
								</th>
								<th>
									Raison
								</th>
								<th>
									Ville
								</th>
								<th>
									Type 
								</th>
								<th>
								Date de création
								</th>
								<th>
								Etat
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($societes as $entrp){
									$cpt ++;
								?>
							<tr>								
								<td>
								
                                                   
									<i class="fa  fa-university font-yellow "></i> <a href="societe.php?action=affiche_societe&id=<?php if(isset($entrp->id_societe)) {echo $entrp->id_societe; }?>" class="" title="Afficher Société"><?php if (isset($entrp->Dossier)) {
									echo $entrp->Dossier;
									} ?></a>
								</td>
								<td>
									<?php if(isset($entrp->Raison)) {echo '<i class="fa  fa-circle font-green-jungle "></i> '. $entrp->Raison; } ?>
									
								</td>
								<td>
									<?php if(isset($entrp->Ville)) {echo '<i class="fa  fa-map-marker font-purple "></i> '. $entrp->Ville; } ?>
								</td>
								<td>
									<?php if (isset($entrp->type)) {
											$types = Type_societe::trouve_par_id($entrp->type);
															
											}
																
											if (isset($types->type)) {
												echo   '<p class="font-red bold">' .$types->type. '</p>' ;}?>
								</td>
								<td>
									<?php if(isset($entrp->Annee)) {echo $entrp->Annee; } ?>
								</td>
								<td>
									
									<?php if ($entrp->Etat == '1') { ?>
                                    <span class="label label-sm bg-green-jungle">
									Active </span> 
                                  <?php } else{  ?> 
                                    <span class="label label-sm label-danger">
									Désactive </span> 
                                <?php    } ?> 
								</td>
								<td>
								<?php if ($entrp->Etat == '1') { ?>
                                    <a href="societe.php?id=<?php if(isset($entrp->id_societe)) {echo $entrp->id_societe; }?>&action=open" class="btn blue btn-xs" title="open">
                                                    <i class="glyphicon glyphicon-folder-open "></i> </a>
									
                                  <?php } else{  ?> 
                                   <a href="javascript:;" class="btn red disabled btn-sm" >
													 <i class="glyphicon glyphicon-folder-close "></i></a>
                                <?php    } ?> 
									
									
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
			</div>
            <!--BEGIN LISTE USER -->
			<?php } else if ($action == 'list_user') {
				
			?>
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
			<?php
				$Accounts = Accounts::trouve_tous(); 
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						<div class="portlet-title">
						
							
							<div class="caption bold">
											<i class="fa  fa-user font-yellow "></i>Utilisateurs<span class="caption-helper"> (<?php echo count($Accounts);?>)</span>
										</div>
								 
							
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group ">
											
											<a href="societe.php?action=add_user"  class="btn btn-sm red">Nouveau utilisateur <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
							
								</div>
							</div>
							
						<div class="table table-scrollable-borderless">
							<table class="table table-striped table-hover" id="sample_2">
							<thead>
							<tr>
								<th>
									Utilisateur
								</th>
								<th>
									Nom & prénom
								</th>
								<th>
									Type
								</th>
								<th>
									Societé 
								</th>
								<th>
								Date de création
								</th>
								<th>
								Etat
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($Accounts as $Account){
									$cpt ++;
								?>
							<tr>								
								<td>
								
                                                   
									<i class="fa  fa-user font-yellow "></i> <a href="societe.php?action=affiche_user&id=<?php if(isset($Account->id)) {echo $Account->id; }?>" class="" title="Afficher utilisateur"><?php if (isset($Account->user)) {
									echo $Account->user;
									} ?></a>
								</td>
								<td>
									<?php if(isset($Account->nom)) {echo '<i class="fa  fa-circle font-green-jungle "></i> '. $Account->nom_compler(); } ?>
									
								</td>
								<td>
									<?php if(isset($Account->type)) {echo $Account->type; } ?>
								</td>
								<td>
									<?php if ($Account->id_societe > 0 ) {
											$Societie = Societe::trouve_par_id($Account->id_societe);
												if (isset($Societie->Dossier)) {
														echo $Societie->Dossier;
															}			
											}else { echo 'Super admin ( Toutes les societes)';}
																
											?>
								</td>
								<td>
									<?php if(isset($Account->date_creation)) {echo fr_date2($Account->date_creation); } ?>
								</td>
								<td>
									
									<?php if ($Account->active == '1') { ?>
                                    <span class="label label-sm bg-green-jungle">
									Active </span> 
                                  <?php } else{  ?> 
                                    <span class="label label-sm label-danger">
									Désactive </span> 
                                <?php    } ?> 
								</td>
								<td>
								<a href="societe.php?action=edit_user&id=<?php echo $Account->id; ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
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
			</div>
            
				<!--BEGIN AFFICHE SOCIETE-->
			<?php  
			}elseif ($action == 'affiche_societe') {		
				  ?>
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
					
					if (isset($_GET['id'])) {
					 $id =  htmlspecialchars(intval($_GET['id'])) ;
					 $entrp = Societe::trouve_par_id($id);
					}else{
							echo 'Content not found....';
					} ?>

						

					<!-- BEGIN AFFICHE SOCIETE -->
						<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-university font-yellow"></i>Société
							</div>
							</div>
							<div class="portlet-title">
							<!--BEGIEN REFLX-->
							<div class="clearfix">
							<div class="pull-right">
							<?php if ($entrp->Etat == '1') { ?>
                                    <span class="btn btn-sm bg-green-jungle" title="Société ouvert">
									Active </span> 
                                  <?php } else {  ?> 
                                    <span class="btn btn-sm btn-danger">
									Désactive </span> 
                                <?php    } ?>
												   
												   </div>
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="javascript:;">

                                                    <img class="media-object" src="assets/image/bank.JPG" alt="bank"   > </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><b> <?php if (isset($entrp->Dossier)) {
															echo $entrp->Dossier;
															} ?></b></h4>
                                                    <ul class="list-unstyled" style="">
												
													<li>
														<?php if (isset($entrp->Adresse)) {
															echo '<i class="fa fa-map-marker font-red"></i>'. $entrp->Adresse;
															} ?>
															<?php if (isset($entrp->Postal)) {
															echo $entrp->Postal;
															} ?>
															- 
														<?php if (isset($entrp->Ville)) {
															echo $entrp->Ville;
															} ?>
															
													</li>
													<li>
														<?php if (isset($entrp->Mob1)) {
															echo '<i class="fa fa-mobile font-plue"></i>'. $entrp->Mob1;
															} ?>
															
													</li>
													<li>
														<?php if (isset($entrp->Email)) {
															echo '<i class="fa fa-at font-purple bold"></i>'. $entrp->Email;
															} ?>
															
															
													</li>
														
													</ul>
                                                   
                                                   
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
									<!--END REFLEX-->
						</div>

							
						<div class="portlet-body">
						<div class="row ">
						<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table  table-hover ">
                                          
							<tbody>
								<tr>

								<td>
								<b>Société </b> 
								</td>
								
								<td>
									<?php if (isset($entrp->nature)){ echo  '<b class="font-blue ">' . $entrp->nature .'</b>'; }?>
									|
									<?php if (isset($entrp->type)) {
											$types = Type_societe::trouve_par_id($entrp->type);
															
											}
																
											if (isset($types->type)) {
												echo   '<b class="font-red bold">' .$types->type. '</b>' ;}?>
								</td>
							
							</tr>
							<tr>

								<td>
								<b>Nom de Dossier </b> 
								</td>
								
								<td>
								<?php if (isset($entrp->Dossier)) {
															echo $entrp->Dossier;
															} ?>
								</td>
							
							</tr>
							<tr>

								<td>
								<b>Raison </b>  
								</td>
								
								<td>
								<?php if (isset($entrp->Raison)) {
															echo $entrp->Raison;
															} ?> 
								</td>
							
							</tr>
							<tr>

								<td>
								<b> Activite: </b> 
															
								</td>
								
								<td>
								<?php if (isset($entrp->Activite)) {
															echo $entrp->Activite;
															} ?>
								</td>
							
							</tr>
							<tr>
								
							
							</tr>
							<tr>
								<td>
								<b>Direction </b>  	
								</td>
								
								<td>
								
								<?php if (isset($entrp->wilayas)) {
															$wilayas = Wilayas::trouve_par_id($entrp->wilayas);
															
															
															echo  '<i class="fa  fa-map-marker font-yellow "></i> ' . $wilayas->nom ;}
															$commune = Communes::trouve_par_id($entrp->commune);
								
														
									echo ' | '. $commune->nom;
								 ?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Inspection </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->inspection)) {
													echo $entrp->inspection ;
													} ?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Recette </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->recette)) {
													echo $entrp->recette ;
													} ?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Date de création </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->Annee)) {
													echo fr_date2($entrp->Annee) ;
													} ?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Exercice </b>  	
								</td>
								
								<td> <strong>DU</strong>
								<?php if (isset($entrp->exercice_debut)) {
													echo fr_date2($entrp->exercice_debut) ;
													} ?> <strong>AU</strong>  <?php if (isset($entrp->exercice_fin)) {
													echo fr_date2($entrp->exercice_fin) ;
													} ?>
													
								</td>
							
							</tr>
							
						
							</tbody>
                                        </table>
                                    </div>
							
							<!-- END PORTLET-->
						</div>
						
						<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table  table-hover ">
                                          
							<tbody>
								
							<tr>

								<td>
								<b>Rc: </b> 
								</td>
								
								<td>
								<?php if (isset($entrp->Rc)) {
															echo $entrp->Rc;
															} ?>
								</td>
							
							</tr>
							<tr>

								<td>
								<b>Mf: </b>  
								</td>
								
								<td>
								<?php if (isset($entrp->Mf)) {
															echo $entrp->Mf;
															} ?> 
								</td>
							
							</tr>
							<tr>

								<td>
								<b> Ai: </b> 
															
								</td>
								
								<td>
								<?php if (isset($entrp->Ai)) {
															echo $entrp->Ai;
															} ?>
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Nis: </b> 	
								</td>
								
								<td>
								<?php if (isset($entrp->Nis)) {
													echo $entrp->Nis;
													} ?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Capital </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->Capital)) {
													echo $entrp->Capital ;
													} ?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Timbre Achat </b>  	
								</td>
								
								<td>
								
									<?php if (isset($entrp->comptes_achat)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($entrp->comptes_achat);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
									|
									<?php if (isset($entrp->auxiliere_achat)) {
															$auxilieres = Auxiliere::trouve_par_id($entrp->auxiliere_achat);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Timbre Vente </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->comptes_vente)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($entrp->comptes_vente);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
										|
									<?php if (isset($entrp->auxiliere_vente)) {
															$auxilieres = Auxiliere::trouve_par_id($entrp->auxiliere_vente);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>TVA sur Achat </b>  	
								</td>
								
								<td>
								
									<?php if (isset($entrp->tva_achat)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($entrp->tva_achat);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
									|
									<?php if (isset($entrp->aux_achat)) {
															$auxilieres = Auxiliere::trouve_par_id($entrp->aux_achat);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Journal Achat </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->journal_achat)) {
															$Journaux = Journaux::trouve_par_id($entrp->journal_achat);
															
															}
															
																
																	if (isset($Journaux->intitule)) {
															echo   $Journaux->intitule ;}?>
								
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Journal Vente </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->journal_vente)) {
															$Journaux = Journaux::trouve_par_id($entrp->journal_vente);
															
															}
															
																
																	if (isset($Journaux->intitule)) {
															echo   $Journaux->intitule ;}?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Journal Depense </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->journal_depense)) {
															$Journaux = Journaux::trouve_par_id($entrp->journal_depense);
															
															}
															
																
																	if (isset($Journaux->intitule)) {
															echo   $Journaux->intitule ;}?>
								
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Journal Stock </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->journal_stock)) {
															$Journaux = Journaux::trouve_par_id($entrp->journal_stock);
															
															}
															
																
																	if (isset($Journaux->intitule)) {
															echo   $Journaux->intitule ;}?>
								
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Taux d'intérêt </b>  	
								</td>
								
								<td>
								<?php if (isset($entrp->Taux_interet)) {
															echo ($entrp->Taux_interet)*100 ; echo " %";
															} ?>
													
								</td>
							
							</tr>
						
							</tbody>
                                        </table>
                                    </div>
							
							<!-- END PORTLET-->
						</div>
					</div>
					<div class="portlet-body">
					<div class="row">
						<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							<?php if (isset($entrp->id_societe)) {
																$Comptes = Compte::trouve_par_societe($entrp->id_societe);
																// $Comptes = Compte::trouve_compte_par_societe($entrp->id_societe);
																
																?>
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table  table-hover ">
							 	<thead>
																<tr>
																	
																	<th>
																		banque
																	</th>
																	
																</tr>
																</thead>
                                          
							<tbody>
																	<?php
																	foreach ($Comptes as $Compte){
																	
																	?>
																<tr>
																
																
																	<td>
																	<?php
																	$banque = Banque::trouve_par_id($Compte->id_banque);
																	if (isset($banque->Designation)) {
																	echo $banque->Designation;}?>
																	-
																	<?php
																	if (isset($banque->Code)) {
																	echo $banque->Code;}
																	
																	 ?>
																	
																	
																	
																
																	</td>
																	
										
																	
																	</tr>
														<?php }}?>
															
																</tbody>
                                        </table>
                                    </div>
							
							<!-- END PORTLET-->
						</div>
						<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							<?php if (isset($entrp->id_societe)) {
															
															$caisses=Caisse::trouve_par_societe($entrp->id_societe);?>
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table  table-hover ">
								<thead>
																<tr>
																	
																	<th>
																		caisse
																	</th>
																	
																</tr>
																</thead>
																<tbody>
																	<?php
																	foreach ($caisses as $caisse){
																	?>
																<tr>
																	<td>
																	<?php
																	if (isset($caisse->Designation)) {
																	echo $caisse->Designation;}?>
																	
																	
																
																	</td>
																	
																<?php
																}}
																	?>
																	</tr>
																	<tr>
																	
																	
								<td><?php if(isset($nav_societe->Dossier)){ echo 
										 '<a href="societe.php?action=edit&id='.$entrp->id_societe.'" class="btn purple btn-sm pull-right">
								<i class="fa fa-edit "></i>&nbsp; Modifier </a>' ;}?>
																						
												
										  					
								</td>
																
																</tr>
																</tbody>							 		
                                        </table>
                                    </div>
							
							<!-- END PORTLET-->
						</div>
						</div>
						</div>
					
						</div>
					</div>
				<!--END AFFICHE SOCIETE-->                   
				
			<!-- full width -->
					<div id="mysociete" class="modal container fade" tabindex="-1">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title modaltitle" ></h4>
								</div>
								<div class="modal-body modalbody" >
								</div>
								<div class="modal-footer modalfooter">
								</div>
					</div>
			<?php  

				}elseif ($action == 'add_societe') {	

				  ?>

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


                                <div class="portlet light">
									<div class="portlet-title">
										<div class="caption bold">
											<i class="fa fa-university font-yellow "></i>Ajouter société
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_societe" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
											<h3 class="form-section">Type de société</h3>
												<div class="row">
												<div class="col-md-6">
														<div class="form-group">
														
																	<label class="col-md-3 control-label">Nature de société <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-6">
																		<div class="form-group form-md-line-input has-info ">
																			<select  name="nature"  class=" form-control" required>
																			<option  value="EURL">EURL</option>
																			<option  value="SARL">SARL</option>
																			<option  value="SPA">SPA</option>
																			<option  value="SNC">SNC</option>
																			<option  value="personne_physique">personne physique</option>
																			</select>
																		</div>

																	</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
														
																	<label class="col-md-3 control-label">Type de société <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-6">
																		<div class="form-group form-md-line-input has-info ">
																			<select  name="type"  class=" form-control" required>
																			<option  value="">Selectionner un type</option>
																			<?php 															
																				$types = Type_societe::trouve_tous();
																				
																				foreach($types as $type){?>

																			<option  value = "<?php echo $type->id ?>"  > <?php echo $type->type ; ?></option>
																			
																				<?php } ?>
																			</select>
																		</div>

																	</div>
														</div>
													</div>
													
											</div>
											<h3 class="form-section">Exercice</h3>
												<div class="row">
												<div class="col-md-6">
														<div class="form-group">

															<label class="col-md-3 control-label">Date début <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="form-group ">
																<input type="date" name = "exercice_debut" value="<?php echo date("Y"); ?>-01-01" class="form-control" placeholder="Inspection" required>
																</div>
																
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">

															<label class="col-md-3 control-label">Date fin <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="form-group ">
																<input type="date" name = "exercice_fin" value="<?php echo date("Y"); ?>-12-31" class="form-control" placeholder="Inspection" required>
																</div>
																
															</div>
														</div>
													</div>
													
											</div>
											<h3 class="form-section">Fiscalité</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
														
																	<label class="col-md-3 control-label">Direction <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-6">
																		<div class="form-group form-md-line-input has-info ">
																			<select  id ="wilaya" name="wilayas" class=" form-control   "required>
																			
																			<?php 															
																				 $wilayas = Wilayas::trouve_tous();
																				
																				foreach($wilayas as $wilaya){?>

																			<option  value="<?php if (isset($wilaya->id)) {
																	echo $wilaya->id;}?>"> <?php echo $wilaya->nom ; ?></option>
																			
																				<?php } ?>
																			</select>
																		</div>

																	</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">

															<label class="col-md-3 control-label">Inspection <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="form-group ">
																<input type="text" name = "inspection" class="form-control" placeholder="Inspection" required>
																</div>
																
															</div>
														</div>
													</div>
											</div>
											<div class="row">
													<div class="col-md-6">
														<div class="form-group">
														
																	<label class="col-md-3 control-label">Commune <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-6">
																		<div class="form-group form-md-line-input has-info wilaya">
																			<select class="form-control "   id="commune"  name="commune" readonly="">
														
																											
																			
																																	   
																			</select>
																		</div>

																	</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">

															<label class="col-md-3 control-label">Recette <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="form-group ">
																	<input type="text" name = "recette" class="form-control" placeholder="Recette" required>
																</div>
																
															</div>
														</div>
													</div>
											</div>
												<h3 class="form-section">Géneral</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Nom de dossier <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-9">
																<div class="input-group">
																	<input type="text" name = "Dossier" class="form-control" placeholder="Nom de dossier" required>
																	<span class="input-group-addon ">
																	<i class="fa fa-folder"></i>
																	</span>
																</div>

															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Raison <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-7">
																<div class="input-group">
																	<input type="text" name = "Raison" class="form-control" placeholder="Raison" required>
																	<span class="input-group-addon ">
																	<i class="fa fa-home"></i>
																	</span>
																</div>

															</div>
														</div>
													</div>
												</div>
												<div class="row">
													
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Activite <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-7">
																<div class="input-group">
																	<input type="text" name = "Activite" class="form-control" placeholder="Activite " required>

																	<span class="input-group-addon ">
																	<i class="fa fa-exchange"></i>
																	</span>
																</div>
																
															</div>
														</div>
													</div>
												</div>
											<h3 class="form-section">Adresse & contact </h3>												
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Adresse <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="input-group">
																	<input type="text" name = "Adresse" class="form-control" placeholder="Adresse">
																	<span class="input-group-addon " required >
																	<i class="fa fa-exchange"></i>
																	</span>
																</div>

															</div>
														</div>
													</div>	
												
													<div class="col-md-3">
														<div class="form-group">
															<label class="col-md-3 control-label">Ville <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="input-group">
																	<input type="text" name = "Ville" class="form-control" >
																	<span class="input-group-addon " required >
																	<i class="fa fa-building"></i>
																	</span>
																</div>
																
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="col-md-3 control-label">Postal <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="input-group">
																	<input type="text" name = "Postal" class="form-control" placeholder="Postal ">
																	<span class="input-group-addon ">
																	<i class="">Postal</i>
																	</span>
																</div>
																
															</div>
														</div>
													</div>
												</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Mob 01 <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Mob1" class="form-control" placeholder="050 00 00 00" required>
																<span class="input-group-addon ">
																<i class="fa  fa-mobile-phone"></i>
																</span>
															</div>
															
														</div>
													</div>
												
													<div class="form-group">
														<label class="col-md-3 control-label">Mob 2 </label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Mob2" class="form-control" placeholder="050 00 00 00" >
																<span class="input-group-addon ">
																<i class="fa  fa-mobile-phone"></i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Tel  01 </label>
															<div class="col-md-6">
																<div class="input-group">
																	<input type="text" name = "Tel1" class="form-control" placeholder="021 00 00 00 " >
																	<span class="input-group-addon ">
																	<i class="fa  fa-phone"></i>
																	</span>
																</div>
																
															</div>
														</div>
													<div class="form-group">
													<label class="col-md-3 control-label">Fax </label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Fax" class="form-control" placeholder="Fax">
															<span class="input-group-addon ">
															<i class="fa  fa-fax"></i>
															</span>
														</div>
														
													</div>
												</div>
												</div>
											
											</div>
											<div class="row">
												<div class="col-md-6">	
												
													<div class="form-group">
														<label class="col-md-3 control-label">Email </label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="email" name = "Email" class="form-control" placeholder="Email@exemple.com " >
																<span class="input-group-addon ">
																<i class="fa fa-envelope"></i>
																</span>
															</div>
															
														</div>
													</div>												
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Web </label>
														<div class="col-md-6">
															<div class="input-group">
																<input  type="text" name = "Web" class="form-control" placeholder="www.exemple.com " >
																<span class="input-group-addon ">
																<i class="fa  fa-institution"></i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
										<h3 class="form-section">info commercial </h3>
											<div class="row">
												<div class="col-md-6">	
													<div class="form-group">
														<label class="col-md-3 control-label">Rc <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" id="mask_rc" name = "Rc" class="form-control" placeholder="RC " required>
																<span class="input-group-addon ">
																<i class="">RC</i>
																</span>
																
															</div>
															
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">NIF <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Mf"  maxlength="20" minlength="20" class="form-control" placeholder="NIF " required>
																<span class="input-group-addon ">
																<i class="">Mf</i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Ai <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Ai" maxlength="11" minlength="11" class="form-control" placeholder="Ai " required>
																<span class="input-group-addon ">
																<i class="">Ai</i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Nis </label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Nis" class="form-control" placeholder="Nis " >
																<span class="input-group-addon ">
																<i class="">Nis</i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Capital <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Capital" class="form-control" placeholder="00.00 " required>

																<span class="input-group-addon ">
																<i class="">DZD</i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Date <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="date" name = "Annee" class="form-control" placeholder="Annee " value="<?php echo   $thisday;?>" required>
																<span class="input-group-addon ">
																<i class="fa fa-calendar"></i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">	
													<div class="form-group">
														<label class="col-md-3 control-label">Taux d'intérêt  <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="number" name = "Taux_interet" step="0.01" class="form-control" placeholder="Taux d'intérêt " value =""required>
																<span class="input-group-addon ">
																%
															</span>
																</span>
																
															</div>
															
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
			<!-- END PAGE CONTENT-->
		<?php }  elseif ($action == 'edit') { ?>
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


                                <div class="portlet light ">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-university font-yellow "></i>Modifier société
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
											<h3 class="form-section">Type de société</h3>
											<div class="row">
											<div class="col-md-4">
														<div class="form-group">
														
																	<label class="col-md-3 control-label">Nature <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-6">
																		<div class="form-group  ">
																			<select  name="nature"  class=" form-control" required>
																			<option  value="EURL" <?php if(isset($editSoct->nature)&&($editSoct->nature=="EURL")){echo "selected";} ?>>EURL</option>
																			<option  value="SARL" <?php if(isset($editSoct->nature)&&($editSoct->nature=="SARL")){echo "selected";} ?>>SARL</option>
																			<option  value="SPA" <?php if(isset($editSoct->nature)&&($editSoct->nature=="SPA")){echo "selected";} ?>>SPA</option>
																			<option  value="SNC" <?php if(isset($editSoct->nature)&&($editSoct->nature=="SNC")){echo "selected";} ?>>SNC</option>
																			<option  value="personne_physique" <?php if(isset($editSoct->nature)&&($editSoct->nature=="personne_physique")){echo "selected";} ?>>personne physique</option>
																			</select>
																		</div>

																	</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
														
																	<label class="col-md-3 control-label">Type <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-4">
																		<div class="form-group  ">
																			<select  name="type"  class=" form-control   ">
																			<option>Selectionner un type</option>
																			<?php 															
																				$types = Type_societe::trouve_tous();
																				
																				foreach($types as $type){?>

																			<option <?php if ($editSoct->type == $type->id) { echo "selected";} ?> value = "<?php echo $type->id ?>"  > <?php echo $type->type ; ?></option>
																			
																				<?php } ?>
																			</select>
																		</div>

																	</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">

															<label class="col-md-3 control-label">Etat *</label>
															<div class="col-md-6">
																<div class="input-group">
																<span class="input-group-btn">
																	<button class="btn red" type="button">Etat *</button>
																	</span>
																	<select class="form-control" name="Etat" id="Etat">
																		<option value="1" <?php if(isset($editSoct->Etat)&&($editSoct->Etat=="1")){echo "selected";} ?>>Active</option>
																		<option value="0" <?php if(isset($editSoct->Etat)&&($editSoct->Etat=="0")){echo "selected";} ?>>Désactive</option>
																		
																	</select>
																</div>
																
															</div>
														</div>
													</div>
											</div>
											<h3 class="form-section">Exercice</h3>
												<div class="row">
												<div class="col-md-6">
														<div class="form-group">

															<label class="col-md-3 control-label">Date début <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="form-group ">
																<input type="date" name = "exercice_debut" value="<?php if (isset($editSoct->exercice_debut)){ echo html_entity_decode($editSoct->exercice_debut); } ?>" class="form-control" required>
																</div>
																
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">

															<label class="col-md-3 control-label">Date fin <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="form-group ">
																<input type="date" name = "exercice_fin" value="<?php if (isset($editSoct->exercice_fin)){ echo html_entity_decode($editSoct->exercice_fin); } ?>" class="form-control"  required>
																</div>
																
															</div>
														</div>
													</div>
													
											</div>
											<h3 class="form-section">Fiscalité</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
														
																	<label class="col-md-3 control-label">Direction <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-6">
																		<div class="form-group form-md-line-input has-info ">
																			<select  id ="wilaya" name="wilayas" class=" form-control   "required>
																			
																			<?php 															
																				 $wilayas = Wilayas::trouve_tous();
																				
																				foreach($wilayas as $wilaya){?>

																			<option <?php if ($wilaya->id == $editSoct->wilayas) { echo "selected";} ?> value="<?php if (isset($wilaya->id)) {
																	echo $wilaya->id;}?>"> <?php echo $wilaya->nom ; ?></option>
																			
																				<?php } ?>
																			</select>
																		</div>

																	</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">

															<label class="col-md-3 control-label">Inspection <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="form-group ">
																<input type="text" name = "inspection" class="form-control" placeholder="Inspection" value ="<?php if (isset($editSoct->inspection)){ echo html_entity_decode($editSoct->inspection); } ?>" required>
																</div>
																
															</div>
														</div>
													</div>
											</div>
											<div class="row">
													<div class="col-md-6">
														<div class="form-group">
														
																	<label class="col-md-3 control-label">Commune <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-6">
																		<div class="form-group form-md-line-input has-info wilaya">
																			<select class="form-control "   id="commune"  name="commune" readonly="">
																			<?php 
							
															
								$commune = Communes::trouve_communes_par_id_wilayas($editSoct->wilayas);
								foreach($commune as $commun){?>
														
									<option <?php if ($commun->id == $editSoct->commune) { echo "selected";} ?> value = "<?php echo $commun->id ?>" > <?php echo $commun->nom ?></option>
														
								<?php } 	?>	
																											
																			
																																	   
																			</select>
																		</div>

																	</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">

															<label class="col-md-3 control-label">Recette <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="form-group ">
																	<input type="text" name = "recette" class="form-control" placeholder="Recette" value ="<?php if (isset($editSoct->recette)){ echo html_entity_decode($editSoct->recette); } ?>" required>
																</div>
																
															</div>
														</div>
													</div>
											</div>
												<h3 class="form-section">Géneral</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Nom de dossier <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-9">
																<div class="input-group">
																	<input type="text" name = "Dossier" class="form-control" placeholder="Nom de dossier" value ="<?php if (isset($editSoct->Dossier)){ echo html_entity_decode($editSoct->Dossier); } ?>" required>
																	<span class="input-group-addon ">
																	<i class="fa fa-folder"></i>
																	</span>
																</div>

															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Raison <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-7">
																<div class="input-group">
																	<input type="text" name = "Raison" class="form-control" placeholder="Raison" value ="<?php if (isset($editSoct->Raison)){ echo html_entity_decode($editSoct->Raison); } ?>" required>
																	<span class="input-group-addon ">
																	<i class="fa fa-home"></i>
																	</span>
																</div>

															</div>
														</div>
													</div>
												</div>
												<div class="row">
													
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Activite <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-7">
																<div class="input-group">
																	<input type="text" name = "Activite" class="form-control" placeholder="Activite " value ="<?php if (isset($editSoct->Activite)){ echo html_entity_decode($editSoct->Activite); } ?>" required>

																	<span class="input-group-addon ">
																	<i class="fa fa-exchange"></i>
																	</span>
																</div>
																
															</div>
														</div>
													</div>
												</div>
											<h3 class="form-section">Adresse & contact </h3>												
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Adresse <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="input-group">
																	<input type="text" name = "Adresse" class="form-control" placeholder="Adresse" value ="<?php if (isset($editSoct->Adresse)){ echo html_entity_decode($editSoct->Adresse); } ?>">
																	<span class="input-group-addon " required >
																	<i class="fa fa-exchange"></i>
																	</span>
																</div>

															</div>
														</div>
													</div>	
												
													<div class="col-md-3">
														<div class="form-group">
															<label class="col-md-3 control-label">Ville <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="input-group">
																	<input type="text" name = "Ville" class="form-control" value ="<?php if (isset($editSoct->Ville)){ echo html_entity_decode($editSoct->Ville); } ?>" >
																	<span class="input-group-addon " required >
																	<i class="fa fa-building"></i>
																	</span>
																</div>
																
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label class="col-md-3 control-label">Postal <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-6">
																<div class="input-group">
																	<input type="text" name = "Postal" class="form-control" placeholder="Postal " value ="<?php if (isset($editSoct->Postal)){ echo html_entity_decode($editSoct->Postal); } ?>">
																	<span class="input-group-addon ">
																	<i class="">Postal</i>
																	</span>
																</div>
																
															</div>
														</div>
													</div>
												</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Mob 01 <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Mob1" class="form-control" placeholder="050 00 00 00" value ="<?php if (isset($editSoct->Mob1)){ echo html_entity_decode($editSoct->Mob1); } ?>"required>
																<span class="input-group-addon ">
																<i class="fa  fa-mobile-phone"></i>
																</span>
															</div>
															
														</div>
													</div>
												
													<div class="form-group">
														<label class="col-md-3 control-label">Mob 2 </label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Mob2" class="form-control" placeholder="050 00 00 00" value ="<?php if (isset($editSoct->Mob2)){ echo html_entity_decode($editSoct->Mob2); } ?>" >
																<span class="input-group-addon ">
																<i class="fa  fa-mobile-phone"></i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label">Tel  01 </label>
															<div class="col-md-6">
																<div class="input-group">
																	<input type="text" name = "Tel1" class="form-control" placeholder="021 00 00 00 " value ="<?php if (isset($editSoct->Tel1)){ echo html_entity_decode($editSoct->Tel1); } ?>">
																	<span class="input-group-addon ">
																	<i class="fa  fa-phone"></i>
																	</span>
																</div>
																
															</div>
														</div>
													<div class="form-group">
													<label class="col-md-3 control-label">Fax </label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Fax" class="form-control" placeholder="Fax" value ="<?php if (isset($editSoct->Fax)){ echo html_entity_decode($editSoct->Fax); } ?>">
															<span class="input-group-addon ">
															<i class="fa  fa-fax"></i>
															</span>
														</div>
														
													</div>
												</div>
												</div>
											
											</div>
											<div class="row">
												<div class="col-md-6">	
												
													<div class="form-group">
														<label class="col-md-3 control-label">Email </label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="email" name = "Email" class="form-control" placeholder="Email@exemple.com " value ="<?php if (isset($editSoct->Email)){ echo html_entity_decode($editSoct->Email); } ?>" >
																<span class="input-group-addon ">
																<i class="fa fa-envelope"></i>
																</span>
															</div>
															
														</div>
													</div>												
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Web </label>
														<div class="col-md-6">
															<div class="input-group">
																<input  type="text" name = "Web" class="form-control" placeholder="www.exemple.com " value ="<?php if (isset($editSoct->Web)){ echo html_entity_decode($editSoct->Web); } ?>" >
																<span class="input-group-addon ">
																<i class="fa  fa-institution"></i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
										<h3 class="form-section">info commercial </h3>
											<div class="row">
												<div class="col-md-6">	
													<div class="form-group">
														<label class="col-md-3 control-label">Rc <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Rc" id="mask_rc" class="form-control" placeholder="RC " value ="<?php if (isset($editSoct->Rc)){ echo html_entity_decode($editSoct->Rc); } ?>"required>
																<span class="input-group-addon ">
																<i class="">RC</i>
																</span>
																
															</div>
															
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">NIF<span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Mf" maxlength="20" minlength="20" class="form-control" placeholder="NIF " value ="<?php if (isset($editSoct->Mf)){ echo html_entity_decode($editSoct->Mf); } ?>"required>
																<span class="input-group-addon ">
																<i class="">Mf</i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Ai <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Ai" maxlength="11" minlength="11" class="form-control" placeholder="Ai " value ="<?php if (isset($editSoct->Ai)){ echo html_entity_decode($editSoct->Ai); } ?>" required>
																<span class="input-group-addon ">
																<i class="">Ai</i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Nis </label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Nis" class="form-control" placeholder="Nis " value ="<?php if (isset($editSoct->Nis)){ echo html_entity_decode($editSoct->Nis); } ?>">
																<span class="input-group-addon ">
																<i class="">Nis</i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Capital <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="text" name = "Capital" class="form-control" placeholder="00.00 " value ="<?php if (isset($editSoct->Capital)){ echo html_entity_decode($editSoct->Capital); } ?>" required>

																<span class="input-group-addon ">
																<i class="">DZD</i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Date de création <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="date" name = "Annee" class="form-control" placeholder="Annee " value="<?php echo   $thisday;?>" required>
																<span class="input-group-addon ">
																<i class="fa fa-calendar"></i>
																</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
													<label class="col-md-3 control-label">Timbre Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option <?php if ($Compte->id == $editSoct->comptes_achat) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
												</div>
												</div>
												<div class="col-md-6">
													<div class="form-group comptes_achat">
													<label class="col-md-3 control-label">Auxiliere :  </label>
													<div class="col-md-6">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($editSoct->comptes_achat);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $editSoct->comptes_achat) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
											<div class="row">
												<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Timbre Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														
														<select class="form-control " id="comptes_vente"  name="comptes_vente">
												
															<?php 															
															$Compt_vente = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_vente as $Compte_ventes){?>

														<option <?php if ($Compte_ventes->id == $editSoct->comptes_vente) { echo "selected";} ?> value = "<?php echo $Compte_ventes->id ?>"  > <?php echo $Compte_ventes->code .' | '. $Compte_ventes->libelle . ' | '. $Compte_ventes->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
												</div>
												</div>
												<div class="col-md-6">
													<div class="form-group comptes_vente">
													<label class="col-md-3 control-label">Auxiliere :  </label>
													<div class="col-md-6">
													<?php 

														 
														 $Compt_venteId = Compte_comptable::trouve_par_id($editSoct->comptes_vente);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_venteId->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_vente"  name="auxiliere_vente">
														
														<?php 
														 
														if(!empty($Compt_venteId->prefixe))	{
														$Auxiliere = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_venteId->prefixe,$nav_societe->id_societe);
														foreach($Auxiliere as $Auxs){?>
														
														<option <?php if ($Auxs->id == $editSoct->comptes_vente) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
													<label class="col-md-3 control-label">TVA sur Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														
														<select class="form-control " id="tva_achat"  name="tva_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option <?php if ($Compte->id == $editSoct->tva_achat) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
												</div>
												</div>
												<div class="col-md-6">
													<div class="form-group tva_achat">
													<label class="col-md-3 control-label">Auxiliere :  </label>
													<div class="col-md-6">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($editSoct->tva_achat);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $editSoct->tva_achat) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
											<div class="row">
												<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Journal Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														<select class="form-control " data-live-search="true" id="journal_achat"  name="journal_achat">
												
															<?php $journal_achats = Journaux::trouve_tous();
															foreach($journal_achats as $journal_achate){?>

														<option <?php if ($editSoct->journal_achat == $journal_achate->id) { echo "selected";} ?> value = "<?php echo $journal_achate->id ?>"  > <?php echo  $journal_achate->intitule ?></option>
														<?php } ?>															   
														</select>  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
												</div>	
												</div>
												<div class="col-md-6">
													<div class="form-group">
													<label class="col-md-3 control-label">Journal Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														<select class="form-control " data-live-search="true" id="journal_vente"  name="journal_vente">
												
															<?php $journal_ventes = Journaux::trouve_tous();
															foreach($journal_ventes as $journal_ventee){?>

														<option <?php if ($editSoct->journal_vente == $journal_ventee->id) { echo "selected";} ?> value = "<?php echo $journal_ventee->id ?>"  > <?php echo $journal_ventee->intitule ?></option>
														<?php } ?>																   
														</select>  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
														</span>	
															</div>
													</div>
												</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Journal Depense <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														<select class="form-control " data-live-search="true" id="journal_depense"  name="journal_depense">
												
															<?php $journal_depenses = Journaux::trouve_tous();
															foreach($journal_depenses as $journal_depense){?>

														<option <?php if ($editSoct->journal_depense == $journal_depense->id) { echo "selected";} ?> value = "<?php echo $journal_depense->id ?>"  > <?php echo  $journal_depense->intitule ?></option>
														<?php } ?>															   
														</select>  
														<span class="input-group-addon ">
															<i class="fa fa-file "></i>
															</span>	
															</div>
													</div>
												</div>	
												</div>
												<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Journal Stock <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														<select class="form-control " data-live-search="true" id="journal_stock"  name="journal_stock">
												
															<?php $journal_depenses = Journaux::trouve_tous();
															foreach($journal_depenses as $journal_depense){?>

														<option <?php if ($editSoct->journal_stock == $journal_depense->id) { echo "selected";} ?> value = "<?php echo $journal_depense->id ?>"  > <?php echo  $journal_depense->intitule ?></option>
														<?php } ?>															   
														</select>  
														<span class="input-group-addon ">
															<i class="fa fa-file "></i>
															</span>	
															</div>
													</div>
												</div>	
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Journal Production <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														<select class="form-control " data-live-search="true" id="journal_production"  name="journal_production">
												
															<?php $journal_depenses = Journaux::trouve_tous();
															foreach($journal_depenses as $journal_depense){?>

														<option <?php if ($editSoct->journal_production == $journal_depense->id) { echo "selected";} ?> value = "<?php echo $journal_depense->id ?>"  > <?php echo  $journal_depense->intitule ?></option>
														<?php } ?>															   
														</select>  
														<span class="input-group-addon ">
															<i class="fa fa-file "></i>
															</span>	
															</div>
													</div>
												</div>	
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">	
													<div class="form-group">
														<label class="col-md-3 control-label">Taux d'intérêt  <span class="required" aria-required="true"> * </span></label>
														<div class="col-md-6">
															<div class="input-group">
																<input type="number" name = "Taux_interet" step="0.01" class="form-control" placeholder="RC " value ="<?php if (isset($editSoct->Taux_interet)){ echo html_entity_decode($editSoct->Taux_interet)*100; } ?>"required>
																<span class="input-group-addon ">
																%
															</span>
																</span>
																
															</div>
															
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
		<?php }elseif ($action =='tab_tva'){
			// List TVA						
				require_once("tva/list_tva.php");
			// Ajouter TVA					
				require_once("tva/tva_form.php");
				?>
		<?php }elseif ($action =='banque'){
			// 	list Banques		
				require_once("banque/banque.php");
				
		?>
		<?php }elseif ($action =='ajouter_banque'){
			// 	Ajouter Banques		
				require_once("banque/ajouter_banque.php");
				
		?>
		<?php }elseif ($action =='edit_banque'){
			// 	Ajouter Banques		
				require_once("banque/edit_banque.php");
				
		?>
				<?php }}?>

	</div>
	</div>
	<!-- END CONTENT -->
	</div>
	<script>
	////////////////////////////////// onchange comptes_achat ///////////////////////////

$(document).on('change','#comptes_achat', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;} else { echo '0';}  ?>;
     $('.comptes_achat').load('ajax/prefixe.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>
  <script>
	////////////////////////////////// onchange tva_achat ///////////////////////////

$(document).on('change','#tva_achat', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;} else { echo '0';}  ?>;
     $('.tva_achat').load('ajax/prefixe_tva_achat.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>
  	<script>
	////////////////////////////////// onchange comptes_vente ///////////////////////////

$(document).on('change','#comptes_vente', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;} else { echo '0';} ?>;
     $('.comptes_vente').load('ajax/prefixe_vente.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>
<script>
	////////////////////////////////// onchange wilaya ///////////////////////////

$(document).on('change','#wilaya', function() {
    var id = this.value;
  
     $('.wilaya').load('ajax/wilayas.php?id='+id,function(){       
    });
});

  </script>

<?php
require_once("footer/footer.php");
?>