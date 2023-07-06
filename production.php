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

	if (isset($_GET['action']) && $_GET['action'] =='production' ) {

$active_submenu = "production";
$action = 'production';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_production' ) {
$active_submenu = "production";
$action = 'list_production';}
else if (isset($_GET['action']) && $_GET['action'] =='detail_production' ) {
$active_submenu = "production";
$action = 'detail_production';}
else if (isset($_GET['action']) && $_GET['action'] =='formule' ) {
	$active_submenu = "production";
	$action = 'formule';}
	else if (isset($_GET['action']) && $_GET['action'] =='edit_formule' ) {
		$active_submenu = "production";
		$action = 'edit_formule';}
		else if (isset($_GET['action']) && $_GET['action'] =='edit_production' ) {
		$active_submenu = "production";
		$action = 'edit_production';}
}

$titre = "ThreeSoft | Production ";
$active_menu = "Facturation";
$header = array('table');
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
$thisday=date('Y-m-d');

//////////////// get id value from Get or post method /////////////////////

	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];

	 } 


if (isset($_POST['submit']) && $action == 'formule'){
$errors = array();
$random_number = rand();
		// new object produit
	$formules = new Formule();
	$formules->designation = htmlentities(trim($_POST['designation']));
	$formules->id_prod = htmlentities(trim($_POST['id_prod']));
	$formules->id_societe = $nav_societe->id_societe;
	$formules->random = $random_number;

	
	if (empty($errors)){
if ($formules->existe()) {
			$msg_error = '<p >  Formule    : ' . $formules->designation	 . ' existe déja !!!</p><br />';
			
		}else{
			$formules->save();
			
 		$msg_positif = '<p >  Formule    : ' . $formules->designation	 . ' est bien ajouter  </p><br />';
 		$last_formule = Formule::trouve_par_random($random_number);
 		if (isset($last_formule->id)) {
 				$id_produit =$_POST['id_produit'];
				$qty =$_POST['qty'];
				$Table_Detail_formule = array($id_produit, $qty);
				for($i=0;$i<count($Table_Detail_formule[0]);$i++){
			$lot_prod = Lot_prod::trouve_first_lot( $Table_Detail_formule[0][$i]);
			if (empty($lot_prod)) {
			$lot_prod = Lot_prod::trouve_last_lot( $Table_Detail_formule[0][$i]);	
			}
 			$Detail_formule = new Detail_formule();
 			$Detail_formule->id_formule = $last_formule->id;
 			$Detail_formule->id_Matiere_Premiere = $Table_Detail_formule[0][$i];
 			if (isset($lot_prod->id)) {
 			$Detail_formule->id_lot = $lot_prod->id;
 			}
 			$Detail_formule->qte = $Table_Detail_formule[1][$i];
 			$Detail_formule->save();
 			}
 		}

		
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
if (isset($_POST['submit']) && $action == 'production'){
	$errors = array();
	$nbr_lots = 0;
	$total_prix = 0;
	$is_end = false;
	$is_error = false;
	$id_lot_array = array();
	$qte_lot_array = array();
	$id_lot_consomation = array();
	$consomation = array();

	$random_number = rand();

		$date_production = htmlentities(trim($_POST['date']));
		$quantite = htmlentities(trim($_POST['qty']));
		$dechets = htmlentities(trim($_POST['dechet']));
		$productions_formule = htmlentities(trim($_POST['formule']));

			////////////////////////////////////   check Sufficient quantity of stock //////////////////////

			////////////////////////////////////////////////////////////////////////////////////////////////

		  $detail_formules = Detail_formule::trouve_detail_par_id_formule( $productions_formule);
		  foreach ($detail_formules as $detail_formule ){

		  		/////////// calcule qte globale de production //////////
		  		$total_qte =  $qte_globale = $quantite * $detail_formule->qte;

		  		/////   trouve matiere premeire ////
		  	    $prod = Produit::trouve_par_id($detail_formule->id_Matiere_Premiere);
		  	    
		  	    //// trouve lots matiere premiere //////////
		  	    $Lot_prods = Lot_prod::trouve_lot_par_produit_order_by_date($detail_formule->id_Matiere_Premiere); 
		  	    if (!empty($Lot_prods)) {
		  	    $nbr_lots = count($Lot_prods);
		  	    }
		  	    //// trouve lot formule ///////////
                $lot_prod = Lot_prod::trouve_par_id($detail_formule->id_lot);
                if ($nbr_lots >1 ) {
                if ($qte_globale > $lot_prod->qte ) {	
                	while ($qte_globale > 0) {
                	//	echo $qte_globale .'<br>';
                foreach ($Lot_prods as $Lot) {	

                		if ($Lot->date_lot > $date_production) {
							   	$errors[]= 'Date lot est supérieure a date production youcef !';
							   	}

							  $cout_production = $Lot->prix_achat * $Lot->qte;
							   if ($qte_globale > $Lot->qte ) {							     
							    } else {
							    	$cout_production = $Lot->prix_achat * ( $Lot->qte -(($qte_globale - $Lot->qte)*-1));
							    	}
							 $qte_globale -= $Lot->qte;
							    if ($qte_globale <= 0) {
							        break;
							    }
							    if ($Lot === end($Lot_prods)) {
								    $is_end = true;
								  }
							   
							}
							if ($qte_globale <= 0) {
							        break;
							    }
							    if ($is_end) {
   										 break;
										}
                	}	
                		if ($qte_globale > 0) {
                			$errors[]= 'Quantité de matière première '.$prod->Designation.' | '.$prod->code.' est insuffisante !';
                			 $is_error= true;
										}
                }else{

                				if ($lot_prod->date_lot > $date_production) {
							   	$errors[]= 'Date lot est supérieure a date de production adem !';
							   	$is_error= true;
							   	}
							   $qte_globale -=  $lot_prod->qte;
                }		
                }else{
                	if ( $qte_globale > $lot_prod->qte) { 
                		$errors[]= 'Quantité de matière première '.$prod->Designation.' | '.$prod->code.' est insuffisante !';
                		$is_error= true;
                		
                	}else{
                				if ($lot_prod->date_lot > $date_production) {
							   	$errors[]= 'Date lot est supérieure a date de production meriem!';
							   	$is_error= true;
							   	}
							   $qte_globale -=  $lot_prod->qte;
                	}
                }

              				  if ($is_error) {
   										 break;
										}
		  }
		
		if (empty($errors)){

			try {

				 $bd->beginTransactions();

			////////////////////////////////////   valider production //////////////////////////////////////

			////////////////////////////////////////////////////////////////////////////////////////////////



				$nbr_lots = 0;
				$total = 0;
				$qte_globale = 0;
				$cout_production = 0;
				$tolal_production = 0;
				$prix_unitaire = 0;
				$cout = 0;
				$is_end = false;

						foreach ($detail_formules as $detail_formule ){

		  		/////////// calcule qte globale de production //////////
		  		$total_qte =  $qte_globale = $quantite * $detail_formule->qte;

		  		/////   trouve matiere premeire ////
		  	    $prod = Produit::trouve_par_id($detail_formule->id_Matiere_Premiere);
		  	    
		  	    //// trouve lots matiere premiere //////////
		  	    $Lot_prods = Lot_prod::trouve_lot_par_produit_order_by_id($detail_formule->id_Matiere_Premiere); 
		  	    if (!empty($Lot_prods)) {
		  	    $nbr_lots = count($Lot_prods);
		  	    }
		  	    //// trouve lot formule ///////////
                $lot_prod = Lot_prod::trouve_par_id($detail_formule->id_lot);

                if ($nbr_lots >1 ) {
                
                if ($qte_globale > $lot_prod->qte ) {
 						
                	while ($qte_globale > 0) {
                	//	echo $qte_globale .'<br>';
                foreach ($Lot_prods as $Lot) {	


							  $cout_production = $Lot->prix_achat * $Lot->qte;
							   if ($qte_globale > $Lot->qte ) {

							    ////// insert id and  qte into lot ///////////////

							     $id_lot_array[] = $Lot->id;
							     $qte_lot_array[] = 0;
							     
							    } else {
							    	$cout_production = $Lot->prix_achat * ( $Lot->qte -(($qte_globale - $Lot->qte)*-1));

							    	////// insert id and  qte into lot ///////////////

							    	 $id_lot_array[] = $Lot->id;
							    	 $qte_lot_array[] = ( $Lot->qte - $qte_globale );

							 ////// update formule id_lot  /////////////
							
								$detail_formule->id_lot = $Lot->id;
								$detail_formule->modifier();
							    }


							  $tolal_production +=  $cout_production;  
							  $prix_unitaire = $tolal_production / $total_qte; 
							  $total = $prix_unitaire * $detail_formule->qte ;
							  $qte_globale -= $Lot->qte;

							    if ($qte_globale <= 0) {
							        break;
							    }
							    if ($Lot === end($Lot_prods)) {
								    $is_end = true;
								  } 
							}
							$cout += $total;
							unset($tolal_production);
							unset($cout_production);

							if ($qte_globale <= 0) {
							        break;
							    }
							    if ($is_end) {
   										 break;
										}
                	}	
                }else{
							  
							  ////// update qte lot ///////////////
                			  $id_lot_consomation[] = $lot_prod->id;
                			  $consomation[] =  $qte_globale ;
							  $lot_prod->qte = ( $lot_prod->qte - $qte_globale );
							  $lot_prod->save();
							  $total = $lot_prod->prix_achat * $detail_formule->qte ;
							  $cout += $total;
							  $qte_globale -=  $lot_prod->qte;
                }
                			
                }else{

                	if ( $qte_globale > $lot_prod->qte) { 
                		// $errors[]= 'Quantité de matière première '.$prod->Designation.' | '.$prod->code.' est insuffisante !';
                	}else{

                		////// update qte lot ///////////////
                			  $id_lot_consomation[] = $lot_prod->id;
                			  $consomation[] =  $qte_globale ;
							  $lot_prod->qte = ( $lot_prod->qte - $qte_globale );
							  $lot_prod->save();
							  $total = $lot_prod->prix_achat * $detail_formule->qte ;
							  $cout += $total;
							   $qte_globale -=  $lot_prod->qte;
                	}
                }

             
		  //	echo ' $cout '.round($cout,2)  . '<br>';

		  }
		  

		  			// new object Production
		$productions = new Production();
		$productions->produit_finale = htmlentities(trim($_POST['produit_finale']));
		$productions->dechet = $dechets;
		$productions->qty = $quantite - $dechets ;
		$productions->date = htmlentities(trim($_POST['date']));
		$productions->id_societe = $nav_societe->id_societe;
		$productions->random = $random_number;
		 if (!empty($_POST['formule'])){
			 $productions->formule = htmlentities(trim($_POST['formule']));
		 }
		$productions->cout = round($cout,5);
		$productions->save();


		$Production = Production::trouve_par_random($random_number);

			///////////////// mise a jour de stock  ///////////////

			//////	update qte of lot ///////////////////
			if (!empty($id_lot_array)) {
			$Update_lot = array($id_lot_array, $qte_lot_array);
			for($i=0;$i<count($Update_lot[0]);$i++){

				$lot_produit = Lot_prod::trouve_par_id($Update_lot[0][$i]);
				$Produit = Produit::trouve_par_id($lot_produit->id_prod);

				$qte_consomation = $lot_produit->qte - $Update_lot[1][$i];
				if (isset($lot_produit->qte)) {
					$lot_produit->qte = $Update_lot[1][$i];
					$lot_produit->save();
					}
					$Consomation_production = new Consomation_production();
					$Consomation_production->id_production = $Production->id;
					$Consomation_production->id_formule = $Production->formule;
					$Consomation_production->id_Matiere_Premiere = $lot_produit->id_prod;
					$Consomation_production->id_lot = $lot_produit->id;
					$Consomation_production->id_famille = $Produit->id_famille;
					$Consomation_production->qte = $qte_consomation ;
					$Consomation_production->Ht_production = $qte_consomation * $lot_produit->prix_achat ;
					$Consomation_production->date = $Production->date;
					$Consomation_production->id_societe = $nav_societe->id_societe;
					$Consomation_production->save();

					$Produit->stock = $Produit->stock - $qte_consomation ;
					$Produit->modifier();
				
			}
			} if (!empty($consomation)) {
			$consomation_lot = array($id_lot_consomation, $consomation);

			for($i=0;$i<count($consomation_lot[0]);$i++){

				$lot_produit = Lot_prod::trouve_par_id($consomation_lot[0][$i]);
				$Produit = Produit::trouve_par_id($lot_produit->id_prod);
				
					$Consomation_production = new Consomation_production();
					$Consomation_production->id_production = $Production->id;
					$Consomation_production->id_formule = $Production->formule;
					$Consomation_production->id_Matiere_Premiere = $lot_produit->id_prod;
					$Consomation_production->id_lot = $lot_produit->id;
					$Consomation_production->id_famille = $Produit->id_famille;
					$Consomation_production->qte = $consomation_lot[1][$i];
					$Consomation_production->Ht_production = $consomation_lot[1][$i] * $lot_produit->prix_achat ;
					$Consomation_production->date = $Production->date;
					$Consomation_production->id_societe = $nav_societe->id_societe;
					$Consomation_production->save();

					$Produit->stock = $Produit->stock - $qte_consomation ;
					$Produit->modifier();
				
			}
				
			}
		  // UPDATE QNTY PRODUIT EN STOCK
			$produit_stock = Produit::trouve_par_id($productions->produit_finale);
			$qty_stock = $produit_stock->stock + ($quantite - $dechets);
			$produit_stock->stock = $qty_stock;
			if ($produit_stock->pourcentage_prix_vente > 0) {
					$produit_stock->prix_vente = round($cout,5) +(round($cout,5) * $produit_stock->pourcentage_prix_vente) ;
					}  
			$produit_stock->modifier();
			

			 	////////////// add new lot of the procution product ///////////////////////
			 $Lot_prod = new Lot_prod();
						$Lot_prod->code_lot = rand();
						$Lot_prod->id_societe = $nav_societe->id_societe;
						$Lot_prod->id_prod = $produit_stock->id_pro;
						$Lot_prod->id_facture =  $Production->id;
						$Lot_prod->qte = $quantite - $dechets;
						$Lot_prod->qte_initial = $quantite - $dechets;
						$Lot_prod->prix_achat = round($cout,5);
						$Lot_prod->prix_vente = $produit_stock->prix_vente;
						$Lot_prod->date_lot = htmlentities(trim($_POST['date']));
						$Lot_prod->type_achat = 4;
						$Lot_prod->save();	
					
					echo '<script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
            toastr.success(" Production créée avec succès","Très bien !");
        },300);


 			});

			</script>';

			//////////////////////////////////// update formule //////////////////////////////////

			$detail_formules = Detail_formule::trouve_detail_par_id_formule( $productions_formule);
				foreach ($detail_formules as $detail_formule ){

							  	    //// trouve lot formule ///////////
                $lot = Lot_prod::trouve_par_id($detail_formule->id_lot);
                if ($lot->qte == 0 ) {
                	$lot_produit = Lot_prod::trouve_first_lot($detail_formule->id_Matiere_Premiere);
                	if (isset($lot_produit->id)) {
					 			$detail_formule->id_lot = $lot_produit->id;
					 			$detail_formule->save();
					 			}
					 		
                }
				}

/////////////////////// ajouter piece comptable automatiquement  Production prod ///////////////////////////////

	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $nav_societe->id_societe;
	$Pieces_comptables->id_op_auto =  $Production->id;
	$Pieces_comptables->type_op =  9;
	$Pieces_comptables->ref_piece =  $Production->id;
	$Pieces_comptables->libelle =  'Production - '.$produit_stock->Designation;
	$Pieces_comptables->date =  $Production->date;
	$Pieces_comptables->date_valid =  date("Y-m-d");
	$Pieces_comptables->journal = $nav_societe->journal_production;
	$Pieces_comptables->somme_debit = $Production->cout * $Production->qty ;
	$Pieces_comptables->somme_credit = $Production->cout * $Production->qty ;
	$Pieces_comptables->random =  $random_number;
	$Pieces_comptables->save();

///////////// ajouter les ecriture comptable de cette piece /////////////////// 
	$Piece = Pieces_comptables::trouve_par_random($random_number);
	$Hts = Famille::calcule_Ht_par_famille_and_facture_production_mp($Production->id,$nav_societe->id_societe);


		foreach ($Hts as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_consommation;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_consommation);
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
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_consommation;
	$Ecriture_comptable->debit = $Ht->Ht;
	$Ecriture_comptable->save();
				}
		foreach ($Hts as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_stock;
	echo $Ht->comptes_stock;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_stock);
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
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_stock;
	$Ecriture_comptable->credit = $Ht->Ht;
	$Ecriture_comptable->save();
				}

/////////////////////// ajouter piece comptable Entrée stock automatiquement ///////////////////////////////
		$random_number_2 = rand();

	$Pieces_comptables_Entree = new Pieces_comptables();
	$Pieces_comptables_Entree->id_societe = $nav_societe->id_societe;
	$Pieces_comptables_Entree->id_op_auto =  $Production->id;
	$Pieces_comptables_Entree->type_op =  10;
	$Pieces_comptables_Entree->ref_piece =  $Production->id;
	$Pieces_comptables_Entree->libelle =  'Entrée stock -'.$produit_stock->Designation;
	$Pieces_comptables_Entree->date =  $Production->date;
	$Pieces_comptables_Entree->date_valid =  date("Y-m-d");
	$Pieces_comptables_Entree->journal = $nav_societe->journal_production;
	$Pieces_comptables_Entree->somme_debit = $Production->cout * $Production->qty ;
	$Pieces_comptables_Entree->somme_credit = $Production->cout * $Production->qty ;
	$Pieces_comptables_Entree->random =  $random_number_2;
	$Pieces_comptables_Entree->save();		

///////////// ajouter les ecriture comptable de cette piece /////////////////// 

	$Piece_Entree = Pieces_comptables::trouve_par_random($random_number_2);
	$Ht_Entrees = Famille::calcule_Ht_par_famille_and_facture_production_pf($Production->id,$nav_societe->id_societe);

		foreach ($Ht_Entrees as $Ht) {
		$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_stock;
	echo $Ht->comptes_stock;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_stock);
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
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_consommation;
	$Ecriture_comptable->debit = $Ht->Ht;
	$Ecriture_comptable->save();
				}
		foreach ($Ht_Entrees as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_consommation;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_consommation);
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
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_stock;
	$Ecriture_comptable->credit = $Ht->Ht;
	$Ecriture_comptable->save();
				}

			$bd->commitTransactions();
			} catch (Exception $e) {
			    // If there's an error, rollback the transaction:
			$bd->rollbackTransactions();
			}
			  
			 }else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br /> <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 




	} 
	
	}
	if (isset($_POST['submit']) && $action == 'edit_production'){

	$errors = array();
	$nbr_lots = 0;
	$total_prix = 0;
	$is_end = false;
	$is_error = false;
	$id_lot_array = array();
	$qte_lot_array = array();
	$id_lot_consomation = array();
	$consomation = array();

	$random_number = rand();

		$date_production = htmlentities(trim($_POST['date']));
		$quantite = htmlentities(trim($_POST['qty']));
		$dechets = htmlentities(trim($_POST['dechet']));
		$productions_formule = htmlentities(trim($_POST['formule']));

////////////////////////////////////   check for old consomation ///////////////////////////////////
		if (isset($id)) {
				$edit_production = Production::trouve_par_id($id);
				$Consomation_productions= Consomation_production::trouve_detail_par_id_production($id);

			}
	/////////////////// get lot-production /////////////////////////////////////////
			if (isset($edit_production->produit_finale)) {
				$lot_production = Lot_prod::trouve_lot_par_facture_and_type_and_prod(4,$edit_production->produit_finale,$edit_production->id);
				if ($lot_production->qte !=  $lot_production->qte_initial) {
					$errors[]= '  Lot deja consommé !';
				}
				}
				if (empty($errors)){

			try {

				 $bd->beginTransactions();

////////////////// Restore the quantity  of consomation into the lot qty /////////////////////////////////
								if (!empty($Consomation_productions)) {
				foreach ($Consomation_productions as $Consomation_production) {
					$lot_consomation = Lot_prod::trouve_par_id($Consomation_production->id_lot);
					if (isset($lot_consomation->id)) {
						$lot_consomation->qte = $lot_consomation->qte + $Consomation_production->qte;
						$lot_consomation->save();
						$Consomation_production->supprime();
					}
					
				}
			}

			$detail_formules = Detail_formule::trouve_detail_par_id_formule( $productions_formule);
				foreach ($detail_formules as $detail_formule ){

							  	    //// trouve lot formule ///////////
                $lot = Lot_prod::trouve_par_id($detail_formule->id_lot);
                	$lot_produit = Lot_prod::trouve_first_lot($detail_formule->id_Matiere_Premiere);
                	if (isset($lot_produit->id)) {
					 			$detail_formule->id_lot = $lot_produit->id;
					 			$detail_formule->save();
					 			}
					 		

				}

			////////////////////////////////////   check Sufficient quantity of stock //////////////////////

			////////////////////////////////////////////////////////////////////////////////////////////////

		  $detail_formules = Detail_formule::trouve_detail_par_id_formule( $productions_formule);
		  foreach ($detail_formules as $detail_formule ){

		  		/////////// calcule qte globale de production //////////
		  		$total_qte =  $qte_globale = $quantite * $detail_formule->qte;

		  		/////   trouve matiere premeire ////
		  	    $prod = Produit::trouve_par_id($detail_formule->id_Matiere_Premiere);
		  	    
		  	    //// trouve lots matiere premiere //////////
		  	    $Lot_prods = Lot_prod::trouve_lot_par_produit_order_by_date($detail_formule->id_Matiere_Premiere); 
		  	    if (!empty($Lot_prods)) {
		  	    $nbr_lots = count($Lot_prods);
		  	    }
		  	    //// trouve lot formule ///////////
                $lot_prod = Lot_prod::trouve_par_id($detail_formule->id_lot);
                if ($nbr_lots >1 ) {
                if ($qte_globale > $lot_prod->qte ) {	
                	while ($qte_globale > 0) {
                	//	echo $qte_globale .'<br>';
                foreach ($Lot_prods as $Lot) {	

                		if ($Lot->date_lot > $date_production) {
							   	$errors[]= 'Date lot est supérieure a date production  !';
							   	}

							  $cout_production = $Lot->prix_achat * $Lot->qte;
							   if ($qte_globale > $Lot->qte ) {							     
							    } else {
							    	$cout_production = $Lot->prix_achat * ( $Lot->qte -(($qte_globale - $Lot->qte)*-1));
							    	}
							 $qte_globale -= $Lot->qte;
							    if ($qte_globale <= 0) {
							        break;
							    }
							    if ($Lot === end($Lot_prods)) {
								    $is_end = true;
								  }
							   
							}
							if ($qte_globale <= 0) {
							        break;
							    }
							    if ($is_end) {
   										 break;
										}
                	}	
                		if ($qte_globale > 0) {
                			$errors[]= 'Quantité de matière première '.$prod->Designation.' | '.$prod->code.' est insuffisante !';
                			 $is_error= true;
										}
                }else{

                				if ($lot_prod->date_lot > $date_production) {
							   	$errors[]= 'Date lot est supérieure a date de production  !';
							   	$is_error= true;
							   	}
							   $qte_globale -=  $lot_prod->qte;
                }		
                }else{
                	if ( $qte_globale > $lot_prod->qte) { 
                		$errors[]= 'Quantité de matière première '.$prod->Designation.' | '.$prod->code.' est insuffisante !';
                		$is_error= true;
                		
                	}else{
                				if ($lot_prod->date_lot > $date_production) {
							   	$errors[]= 'Date lot est supérieure a date de production !';
							   	$is_error= true;
							   	}
							   $qte_globale -=  $lot_prod->qte;
                	}
                }

              				  if ($is_error) {
   										 break;
										}
		  }
		
		if (empty($errors)){



			////////////////////////////////////   valider production //////////////////////////////////////

			////////////////////////////////////////////////////////////////////////////////////////////////



				$nbr_lots = 0;
				$total = 0;
				$qte_globale = 0;
				$cout_production = 0;
				$tolal_production = 0;
				$prix_unitaire = 0;
				$cout = 0;
				$is_end = false;

						foreach ($detail_formules as $detail_formule ){

		  		/////////// calcule qte globale de production //////////
		  		$total_qte =  $qte_globale = $quantite * $detail_formule->qte;

		  		/////   trouve matiere premeire ////
		  	    $prod = Produit::trouve_par_id($detail_formule->id_Matiere_Premiere);
		  	    
		  	    //// trouve lots matiere premiere //////////
		  	    $Lot_prods = Lot_prod::trouve_lot_par_produit_order_by_id($detail_formule->id_Matiere_Premiere); 
		  	    if (!empty($Lot_prods)) {
		  	    $nbr_lots = count($Lot_prods);
		  	    }
		  	    //// trouve lot formule ///////////
                $lot_prod = Lot_prod::trouve_par_id($detail_formule->id_lot);

                if ($nbr_lots >1 ) {
                
                if ($qte_globale > $lot_prod->qte ) {
 						
                	while ($qte_globale > 0) {
                	//	echo $qte_globale .'<br>';
                foreach ($Lot_prods as $Lot) {	


							  $cout_production = $Lot->prix_achat * $Lot->qte;
							   if ($qte_globale > $Lot->qte ) {

							    ////// insert id and  qte into lot ///////////////

							     $id_lot_array[] = $Lot->id;
							     $qte_lot_array[] = 0;
							     
							    } else {
							    	$cout_production = $Lot->prix_achat * ( $Lot->qte -(($qte_globale - $Lot->qte)*-1));

							    	////// insert id and  qte into lot ///////////////

							    	 $id_lot_array[] = $Lot->id;
							    	 $qte_lot_array[] = ( $Lot->qte - $qte_globale );

							 ////// update formule id_lot  /////////////
							
								$detail_formule->id_lot = $Lot->id;
								$detail_formule->modifier();
							    }


							  $tolal_production +=  $cout_production;  
							  $prix_unitaire = $tolal_production / $total_qte; 
							  $total = $prix_unitaire * $detail_formule->qte ;
							  $qte_globale -= $Lot->qte;

							    if ($qte_globale <= 0) {
							        break;
							    }
							    if ($Lot === end($Lot_prods)) {
								    $is_end = true;
								  } 
							}
							$cout += $total;
							unset($tolal_production);
							unset($cout_production);

							if ($qte_globale <= 0) {
							        break;
							    }
							    if ($is_end) {
   										 break;
										}
                	}	
                }else{
							  
							  ////// update qte lot ///////////////
                			  $id_lot_consomation[] = $lot_prod->id;
                			  $consomation[] =  $qte_globale ;
							  $lot_prod->qte = ( $lot_prod->qte - $qte_globale );
							  $lot_prod->save();
							  $total = $lot_prod->prix_achat * $detail_formule->qte ;
							  $cout += $total;
							  $qte_globale -=  $lot_prod->qte;
                }
                			
                }else{

                	if ( $qte_globale > $lot_prod->qte) { 
                		// $errors[]= 'Quantité de matière première '.$prod->Designation.' | '.$prod->code.' est insuffisante !';
                	}else{

                		////// update qte lot ///////////////
                			  $id_lot_consomation[] = $lot_prod->id;
                			  $consomation[] =  $qte_globale ;
							  $lot_prod->qte = ( $lot_prod->qte - $qte_globale );
							  $lot_prod->save();
							  $total = $lot_prod->prix_achat * $detail_formule->qte ;
							  $cout += $total;
							   $qte_globale -=  $lot_prod->qte;
                	}
                }

             
		  //	echo ' $cout '.round($cout,2)  . '<br>';

		  }
		  

		  			// new object Production
		$edit_production->produit_finale = htmlentities(trim($_POST['produit_finale']));
		$edit_production->dechet = $dechets;
		$edit_production->qty = $quantite - $dechets ;
		$edit_production->date = htmlentities(trim($_POST['date']));
		 if (!empty($_POST['formule'])){
			 $edit_production->formule = htmlentities(trim($_POST['formule']));
		 }
		$edit_production->cout = round($cout,5);
		$edit_production->save();


			///////////////// mise a jour de stock  ///////////////

			//////	update qte of lot ///////////////////
			if (!empty($id_lot_array)) {
			$Update_lot = array($id_lot_array, $qte_lot_array);
			for($i=0;$i<count($Update_lot[0]);$i++){

				$lot_produit = Lot_prod::trouve_par_id($Update_lot[0][$i]);
				$Produit = Produit::trouve_par_id($lot_produit->id_prod);

				$qte_consomation = $lot_produit->qte - $Update_lot[1][$i];
				if (isset($lot_produit->qte)) {
					$lot_produit->qte = $Update_lot[1][$i];
					$lot_produit->save();
					}
					$Consomation_production = new Consomation_production();
					$Consomation_production->id_production = $edit_production->id;
					$Consomation_production->id_formule = $edit_production->formule;
					$Consomation_production->id_Matiere_Premiere = $lot_produit->id_prod;
					$Consomation_production->id_lot = $lot_produit->id;
					$Consomation_production->id_famille = $Produit->id_famille;
					$Consomation_production->qte = $qte_consomation ;
					$Consomation_production->Ht_production = $qte_consomation * $lot_produit->prix_achat ;
					$Consomation_production->date = $edit_production->date;
					$Consomation_production->id_societe = $nav_societe->id_societe;
					$Consomation_production->save();

					$Produit->stock = $Produit->stock - $qte_consomation ;
					$Produit->modifier();
				
			}
			} if (!empty($consomation)) {
			$consomation_lot = array($id_lot_consomation, $consomation);

			for($i=0;$i<count($consomation_lot[0]);$i++){

				$lot_produit = Lot_prod::trouve_par_id($consomation_lot[0][$i]);
				$Produit = Produit::trouve_par_id($lot_produit->id_prod);
				
					$Consomation_production = new Consomation_production();
					$Consomation_production->id_production = $edit_production->id;
					$Consomation_production->id_formule = $edit_production->formule;
					$Consomation_production->id_Matiere_Premiere = $lot_produit->id_prod;
					$Consomation_production->id_lot = $lot_produit->id;
					$Consomation_production->id_famille = $Produit->id_famille;
					$Consomation_production->qte = $consomation_lot[1][$i];
					$Consomation_production->Ht_production = $consomation_lot[1][$i] * $lot_produit->prix_achat ;
					$Consomation_production->date = $edit_production->date;
					$Consomation_production->id_societe = $nav_societe->id_societe;
					$Consomation_production->save();

					$Produit->stock = $Produit->stock - $consomation_lot[1][$i] ;
					$Produit->modifier();
				
			}
				
			}
		  // UPDATE QNTY PRODUIT EN STOCK
			$produit_stock = Produit::trouve_par_id($edit_production->produit_finale);
			$qty_stock = $produit_stock->stock + ($quantite - $dechets);
			$produit_stock->stock = $qty_stock;
			if ($produit_stock->pourcentage_prix_vente > 0) {
					$produit_stock->prix_vente = round($cout,5) +(round($cout,5) * $produit_stock->pourcentage_prix_vente) ;
					}  
			$produit_stock->modifier();
			
			 	////////////// update lot of the procution product ///////////////////////
						$Lot_prod = Lot_prod::trouve_lot_par_facture_and_type_and_prod(4,$edit_production->produit_finale,$edit_production->id);
						$Lot_prod->qte = $quantite - $dechets;
						$Lot_prod->qte_initial = $quantite - $dechets;
						$Lot_prod->prix_achat = round($cout,5);
						$Lot_prod->prix_vente = $produit_stock->prix_vente;
						$Lot_prod->date_lot = htmlentities(trim($_POST['date']));
						$Lot_prod->type_achat = 4;
						$Lot_prod->save();	
					
					echo '<script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
            toastr.success(" Production créée avec succès","Très bien !");
        },300);


 			});

			</script>';

			//////////////////////////////////// update formule //////////////////////////////////

			$detail_formules = Detail_formule::trouve_detail_par_id_formule( $productions_formule);
				foreach ($detail_formules as $detail_formule ){

							  	    //// trouve lot formule ///////////
                $lot = Lot_prod::trouve_par_id($detail_formule->id_lot);
                if ($lot->qte == 0 ) {
                	$lot_produit = Lot_prod::trouve_first_lot($detail_formule->id_Matiere_Premiere);
                	if (isset($lot_produit->id)) {
					 			$detail_formule->id_lot = $lot_produit->id;
					 			$detail_formule->save();
					 			}
					 		
                }
				}
/////////////////////// Modifier piece comptable automatiquement ///////////////////////////////

	$Piece = Pieces_comptables::trouve_par_operation_and_type($edit_production->id,9);


	$Piece->date =  $edit_production->date;
	$Piece->somme_debit = $edit_production->cout * $edit_production->qty ;
	$Piece->somme_credit = $edit_production->cout * $edit_production->qty ;
	$Piece->modifier();

////////////////// delete old ecriture_comptable par id_piece /////////////////////////////

	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece->id);

///////////// add ecriture comptable of this piece /////////////////// 	

$Hts = Famille::calcule_Ht_par_famille_and_facture_production_mp($edit_production->id,$edit_production->id_societe);


		foreach ($Hts as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_consommation;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_consommation);
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
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_consommation;
	$Ecriture_comptable->debit = $Ht->Ht;
	$Ecriture_comptable->save();
				}
		foreach ($Hts as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_stock;
	echo $Ht->comptes_stock;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_stock);
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
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_stock;
	$Ecriture_comptable->credit = $Ht->Ht;
	$Ecriture_comptable->save();
				}

/////////////////////// modifier piece comptable Entrée stock automatiquement ///////////////////////////////

	$Piece_Entree = Pieces_comptables::trouve_par_operation_and_type($edit_production->id,10);

	$Piece_Entree->date =  $edit_production->date;
	$Piece_Entree->somme_debit = $edit_production->cout * $edit_production->qty ;
	$Piece_Entree->somme_credit = $edit_production->cout * $edit_production->qty ;
	$Piece_Entree->modifier();

////////////////// delete old ecriture_comptable par id_piece /////////////////////////////

	$Ecriture = Ecriture_comptable::delete_ecriture_par_piece($Piece_Entree->id);

///////////// ajouter les ecriture comptable de cette piece /////////////////// 	
	$Ht_Entrees = Famille::calcule_Ht_par_famille_and_facture_production_pf($edit_production->id,$edit_production->id_societe);

			foreach ($Ht_Entrees as $Ht) {
		$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_stock;
	echo $Ht->comptes_stock;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_stock);
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
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_consommation;
	$Ecriture_comptable->debit = $Ht->Ht;
	$Ecriture_comptable->save();
				}
		foreach ($Ht_Entrees as $Ht) {
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = $Ht->comptes_consommation;
	$Compte_comp = Compte_comptable::trouve_par_id($Ht->comptes_consommation);
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
	$Ecriture_comptable->id_auxiliere = $Ht->auxiliere_stock;
	$Ecriture_comptable->credit = $Ht->Ht;
	$Ecriture_comptable->save();

	}	
			  
			 }else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br /> <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 




	}

			$bd->commitTransactions();
			} catch (Exception $e) {
			    // If there's an error, rollback the transaction:
			$bd->rollbackTransactions();
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

 
	
	}
	


	if($action == 'edit_formule' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$formules = Formule:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$formules = Formule:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object produit
		$formules->designation = htmlentities(trim($_POST['designation']));
		$formules->id_prod = htmlentities(trim($_POST['id_prod']));
		$msg_positif= '';
	 	$msg_system= '';
	if (empty($errors)){
					

 		if ($formules->save()){
		$msg_positif .= '<p >  article ' . html_entity_decode($formules->designation) . '  est modifié  avec succes </p><br />';
			$detele_detail = Detail_formule::delete_Detail_formule_par_id_formule($formules->id);
			 		if (isset($formules->id)) {
 				$id_produit =$_POST['id_produit'];
				$qty =$_POST['qty'];
				$Table_Detail_formule = array($id_produit, $qty);
				for($i=0;$i<count($Table_Detail_formule[0]);$i++){
			$lot_prod = Lot_prod::trouve_first_lot( $Table_Detail_formule[0][$i]);
			if (empty($lot_prod)) {
			$lot_prod = Lot_prod::trouve_last_lot( $Table_Detail_formule[0][$i]);	
			}
 			$Detail_formule = new Detail_formule();
 			$Detail_formule->id_formule = $formules->id;
 			$Detail_formule->id_Matiere_Premiere = $Table_Detail_formule[0][$i];
 			if (isset($lot_prod->id)) {
 			$Detail_formule->id_lot = $lot_prod->id;
 			}
 			$Detail_formule->qte = $Table_Detail_formule[1][$i];
 			$Detail_formule->save();
 			}
 		}
													
														
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
                       
                        <i class="fa fa-angle-right"></i>
                    </li>
					<li>
                        
                        <a href="production.php?action=list_production">Production</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_production') { 
                        echo  '<a href="production.php?action=add_production">Ajouter articles</a> '?>
                        
                        
                    <?php }
                    	 elseif ($action == 'edit') {
                        echo '<a href="production.php?action=edit_produit">Modifier articles</a> ';
                    } 
                    	 elseif ($action == 'formule') {
                        echo '<a href="production.php?action=formule">formule</a> ';
                    } ?>
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			
		<?php  if (isset($nav_societe) ){  
		if ($user->type == 'administrateur') {
			
				
				
				
				if ($action == 'list_production') {
				require_once("header/menu-production.php");

				$productions = Production::trouve_production_par_societe($nav_societe->id_societe); 
				$cpt = 0; 
				?>
	
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				

		<div class="row">
				<div class="col-md-12">
						
					<div class="notification"></div>
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-cube font-yellow"></i>Production</span> 
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group">
											
											<a href="production.php?action=production" class="btn red">Nouveau produit  <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_2">
							<thead>
							<tr>
								<th>
									N°
								</th>
								<th>
									Produit
								</th>
								<th>
									Date production
								</th>
								
								<th>
									Formule 
								</th>
								<th>
									Quantité
								</th>
								<th>
									Cout
								</th>
								<th>
									Prix Total
								</th>
								
							
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($productions as $production){
									$cpt ++;
								?>
							<tr  id="production_<?php echo $production->id; ?>">
								<td>
									<?php echo $cpt ; ?>
								</td>
								<td>
									<b><?php if (isset($production->produit_finale)) {
										$prod = Produit::trouve_par_id($production->produit_finale);
									echo $prod->Designation.' | '.$prod->code;
									} ?></b>
								</td>
								
								<td>
									<?php if (isset($production->qty)) {
									echo fr_date2($production->date);
									} ?> 
									
								</td>
								<td>
									
									<?php if (isset($production->formule)) {
											$formules = Formule::trouve_par_id($production->formule);
											if (isset($formules->designation)) {
									echo $formules->designation;}}?>
								</td>
								<td>
									<?php if (isset($production->qty)) {
									echo $production->qty;
									} ?> 
									
								</td>
								<td>
									<?php if (isset($production->cout)) {
									echo number_format($production->cout,2,',',' ');
									} ?> 
								</td>
								<td>
									<?php
									if (isset($production->qty)) {

									echo number_format(($production->qty*$production->cout),2,',',' ');
									}
									
									  ?>
								</td>
								
								
								<td>
									
									<a target="_blanck" href="production.php?action=detail_production&id=<?php if (isset($production->id)) {echo $production->id;} ?>" class="btn purple-plum btn-xs">
                                                    <i class="fa fa-external-link "></i> </a>
                                    <a href="production.php?action=edit_production&id=<?php if (isset($production->id)) {echo $production->id;} ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
                                    <button id="del_production" value="<?php if (isset($production->id)) {echo $production->id;} ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_production" data-toggle="modal"></i> </button>                
									
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
		<?php }  else if ($action == 'detail_production') {
				require_once("header/menu-production.php");
				$Production = Consomation_production::trouve_par_id_production($id);
				if (isset($Production->id_production)) {
					$Productions = Production::trouve_par_id($Production->id_production);
					if (isset($Productions->produit_finale)) {
						$Produit = Produit::trouve_par_id($Productions->produit_finale);
					}
				}
				$Consomation_productions= Consomation_production::trouve_detail_par_id_production($id);
				?>
	
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-cube font-yellow"></i>Production: <?php if (isset($Produit->Designation)) { echo $Produit->Designation.' | '.$Produit->code;} ?></span> 
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group">
											
											<a href="production.php?action=production" class="btn red">Nouveau produit  <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_2">
							<thead>
							<tr>
								<th>
									N°
								</th>
								<th>
									Matière première
								</th>
								<th>
									Formule
								</th>
								
								<th>
									Lot 
								</th>
								<th>
									Quantité
								</th>
								<th>
									Date
								</th>
								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($Consomation_productions as $Consomation_production){
									$cpt ++;
								?>
							<tr>
								<td>
									<?php echo $cpt ; ?>
								</td>
								<td>
									<b><?php if (isset($Consomation_production->id_Matiere_Premiere)) {
										$prod = Produit::trouve_par_id($Consomation_production->id_Matiere_Premiere);
									echo $prod->code.' | '.$prod->Designation;
									} ?></b>
								</td>
								
								<td>
									<?php if (isset($Consomation_production->id_formule)) {
									$formule = Formule::trouve_par_id($Consomation_production->id_formule);	
									echo ($formule->designation);
									} ?> 
									
								</td>
								<td>
									<?php if (isset($Consomation_production->id_lot)) {
									$Lot_prod = Lot_prod::trouve_par_id($Consomation_production->id_lot);	
									echo ($Lot_prod->code_lot);
									} ?> 
									<?php if (isset($production->formule)) {
											$formules = Formule::trouve_par_id($production->formule);
											if (isset($formules->designation)) {
									echo $formules->designation;}}?>
								</td>
								<td>
									<?php if (isset($Consomation_production->qte)) {
									echo $Consomation_production->qte;
									} ?> 
									
								</td>
								<td>
									<?php if (isset($Consomation_production->date)) {
									echo fr_date2($Consomation_production->date);
									} ?> 
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

<!-- END PAGE CONTENT-->
			<?php  

}elseif ($action == 'formule') {
				
  ?>

<!-- BEGIN PAGE CONTENT-->
<div class="row profile">
	<div class="col-md-7">
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
						<div class="caption bold">
							<i class="fa  fa-plus-square font-yellow "></i>Ajouter Formule
						</div>

					</div>
					<div class="portlet-body form">
						<!-- BEGIN FORM-->
						<form action="<?php echo $_SERVER['PHP_SELF']?>?action=formule" method="POST" class="form-horizontal margin-bottom-40 form-bordered" enctype="multipart/form-data">
							<div class="form-body">
								<div class="form-group  ">
									
									<label for="" class="col-md-2 control-label">Produit <span class="required" aria-required="true"> * </span></label>
									
									<div class="col-md-4">
                                     <select class="form-control select2me" id=""  name="id_prod"   placeholder="Choisir une produit " required >
										<option value="" ></option>
										<?php 
										$produits = Produit::trouve_produit_production($nav_societe->id_societe);  
										  foreach ($produits as $Article) { ?>
										<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
											<?php } ?>															   
									</select> 
								</div>	
								<label for="" class="col-md-2 control-label">Formule <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-4 has-warning">
									
								<input type="text" name = "designation" class="form-control"  placeholder="Formule" required>
														
								</div>		
								</div>
								
							</div>
							
							<table id="items" class="table table-striped  table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="50%">
									Article
								</th>
								
								<th >
								Quantité
								</th>
							</tr>
							</thead>
							<tbody>
							
							<tr class="item-row">
									<td>
									<select class="form-control  select2me" id="id_produit"  name="id_produit[]"   placeholder="Choisir article" required >
											<option value=""></option>
										<?php 
										$Articles = Produit:: trouve_matiere_premiere_par_societe($nav_societe->id_societe);

										foreach ($Articles as $Article) { ?>
																	<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
																<?php } ?>														   
														</select>  
									
									</td>
									<td>
									<input type="text" name = "qty[]" id="qty" class="form-control" min="0"placeholder="Quantité" required>
	
									</td>
	
									<td>
										 <a class="btn btn green-jungle btn-sm" id="add_formule" class="btn green" href="javascript:;"><i class="fa fa-plus"></i></a>
									</td>
									</tr>
							</tbody>
							
							</table>
									<div class="row">
													<div class="col-md-offset-9 col-md-9">
														<button type="submit" name = "submit" class="btn green">Ajouter</button>
													
													</div>
												</div>
											</div>
						</form>
					</div>
				</div>
				<div class="col-md-5">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption bold">
							<i class="fa  fa-list font-yellow "></i>Liste Formule
						</div>

					</div>
					<div class="portlet-body">
					<?php 
						
							$formulee = Formule::trouve_formule_par_societe($nav_societe->id_societe);
					 ?>
					 <table  class="table table-responsive  table-hover"  id="">
							<thead>
							<tr>
								
								<th >
									Formule
								</th>
								<th >
								Produit
								</th>
								<th >
								Code produit
								</th>
								<th>
									#		
								</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($formulee as $formule){?>
							<tr >
								<td>
								<?php if(isset($formule->id)) {
										echo '<i class="fa fa-cubes font-yellow"></i> <a name="'. $formule->designation.'" href="#Detail_Formule" data-toggle="modal" id="MyFormule" value='.$formule->id.'  class=""> '. $formule->designation.'</a>';} ?>
								</td>
								<td>
								<?php if (isset($formule->id_prod))  {
													
													
												$prod = Produit::trouve_par_id($formule->id_prod);
												echo $prod->Designation;}
											?>
								</td>
								<td>
								<?php if (isset($formule->id_prod))  {
													
													
													$prod = Produit::trouve_par_id($formule->id_prod);
													echo  $prod->code;}
												?>
									</td>
								<td><a  href="production.php?action=edit_formule&id=<?php echo $formule->id; ?>" ><i class="fa fa-edit "></i></a></td>
							<?php } ?>
							
							</tbody>
					 </table>

					</div>
				</div>
				</div>
	</div>
	<?php  

}elseif ($action == 'edit_formule') {
			
  ?>

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
						<div class="caption bold">
							<i class="fa  fa-pencil font-yellow "></i>Edit Formule
						</div>

					</div>
					<div class="portlet-body form">
						<!-- BEGIN FORM-->
						<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit_formule" method="POST" class="form-horizontal" enctype="multipart/form-data">
							<div class="form-body">
								<div class="form-group  ">
									<label for="" class="col-md-2 control-label">Produit <span class="required" aria-required="true"> * </span></label>
									
									<div class="col-md-4">
                                     <select class="form-control  select2me" id=""  name="id_prod"   placeholder="Choisir une produit " required >
										<option value="" ></option>
										<?php 
										$produits = Produit::trouve_produit_production($nav_societe->id_societe);  
										  foreach ($produits as $Article) { ?>
										<option <?php if ($formules->id_prod == $Article->id_pro ){ echo "selected"; } ?> value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
											<?php } ?>															   
									</select> 
								</div>
									<label for="" class="col-md-2 control-label">Formule <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-4 has-warning">
									
								<input type="text" name = "designation" class="form-control" value="<?php if (isset($formules->designation)){ echo html_entity_decode($formules->designation); } ?>" placeholder="Formule" required>
														
								</div>
												
								</div>
								
							</div>
							<table id="items" class="table table-striped  table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="60%">
									Article
								</th>
								<th >
								Quantité
								</th>
								
							</tr>
							</thead>
							
							<tbody>
							<?php if (isset($formules->id_prod))  {
													
								 $detail_formules = Detail_formule::trouve_detail_par_id_formule($id);
                                                           
                                    foreach($detail_formules as $detail_formule ) {
                                                              
                                      $produit= Produit::trouve_par_id($detail_formule->id_Matiere_Premiere);
                                                                
                          ?>
                             <tr class="item-row">
                                                                
								<td> <select class="form-control  select2me" id="id_produit"  name="id_produit[]"   placeholder="Choisir article" >
								<?php 
										$Articles = Produit:: trouve_matiere_premiere_par_societe($nav_societe->id_societe);

										foreach ($Articles as $Article) { ?>								
								 <option  <?php if ($produit->id_pro == $Article->id_pro ){ echo "selected"; } ?>   value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>">
									 <?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
									 <?php }?>														   
									 </select></td> 
																
								<td width="50%" ><input type="text" name = "qty[]" id="qty" value ="<?php echo  $detail_formule->qte ;?>" class="form-control" min="0"placeholder="Quantité" required></td>

								<td><a class="btn btn-danger btn-sm" id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash" ></i></a></td>
                          </tr>
                                                                
                           <?php  }
                         
                          }?>
							<tr>
																
							<td><a class="btn btn green-jungle btn-sm" id="add_formule" class="btn green" href="javascript:;"><i class="fa fa-plus"></i></a></td>
							<td></td>	
							<td></td>
							</tr>

							</tbody>
							
							</table>
									<div class="row">
													<div class="col-md-offset-9 col-md-9">
														<button type="submit" name = "submit" class="btn green">Ajouter</button>
														<button type="button" value="back" onclick="history.go(-1)" class="btn  default">Annuler</button>
														 <?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
													</div>
												</div>
											</div>
						</form>
					</div>
				</div>
				<div class="col-md-4">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption bold">
							<i class="fa  fa-list font-yellow "></i>Liste Formule
						</div>

					</div>
					<div class="portlet-body">
					<?php 
						
							$formulee = Formule::trouve_formule_par_societe($nav_societe->id_societe);
					 ?>
					<table  class="table table-responsive  table-hover"  id="">
							<thead>
							<tr>
								
								<th >
									Formule
								</th>
								<th >
								Produit
								</th>
								<th >
								Code produit
								</th>
								<th>
									#		
								</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($formulee as $formule){?>
							<tr >
								<td>
								<?php if(isset($formule->id)) {
										echo '<i class="fa fa-cubes font-yellow"></i> <a name="'. $formule->designation.'" href="#Detail_Formule" data-toggle="modal" id="MyFormule" value='.$formule->id.'  class=""> '. $formule->designation.'</a>';} ?>
								</td>
								<td>
								<?php if (isset($formule->id_prod))  {
													
													
												$prod = Produit::trouve_par_id($formule->id_prod);
												echo $prod->Designation;}
											?>
								</td>
								<td>
								<?php if (isset($formule->id_prod))  {
													
													
													$prod = Produit::trouve_par_id($formule->id_prod);
													echo  $prod->code;}
												?>
									</td>
								<td><a  href="production.php?action=edit_formule&id=<?php echo $formule->id; ?>" ><i class="fa fa-edit "></i></a></td>
							<?php } ?>
							
							</tbody>
					 </table>

					</div>
				</div>
				</div>
	</div>
	<?php  

}elseif ($action == 'production') {

$thisday=date('Y-m-d');					
  ?>

<!-- BEGIN PAGE CONTENT-->

<div class="row profile">
	<div class="col-md-8 ">

			
			<?php 
						if (!empty($msg_error)){
							echo error_message($msg_error); 
						}elseif(!empty($msg_positif)){ 
							echo positif_message($msg_positif);	
						}elseif(!empty($msg_system)){ 
							echo system_message($msg_system);
						} ?>	
			<div class="portlet light bordered ">
				<div class="portlet-title">
					<div class="simplelineicons-demo">
						<span class="item-box">
							<span class="item">
								<span class="icon-plus font-yellow"></span> <span class="bs-glyphicon-class">
								Nouveau </span> 
							</span>
						</span>
					</div>
				</div>
	
	
		<div class="portlet-body form">
		<div class="notification"></div>
			<div class="form-body">
							<!-- BEGIN FORM-->
					<form action="<?php echo $_SERVER['PHP_SELF']?>?action=production" method="POST" class="form-horizontal margin-bottom-40 " enctype="multipart/form-data">
						<div class="form-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-md-line-input">					
										<label class="control-label col-md-3">Date <span class="required" aria-required="true"> * </span></label>
										<div class="col-md-8">
										<input type="date" name ="date" class="form-control input-inline input-medium "  value="<?php echo $thisday;?>" required>						
										</div>					
									</div>  
								</div>
								<div class="col-md-6">
									<div class="form-group  ">
									<label for="" class="col-md-2 control-label">Article <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-10">
                                     <select class="form-control select2me" id="produitId"  placeholder="Choisir Article"  name="produit_finale"   required >
									 <option value=""></option>
										<?php 
										$produits = Produit::trouve_produit_production($nav_societe->id_societe);  
										  foreach ($produits as $Article) { ?>
										<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
											<?php } ?>															   
									</select> 
									</div>				
                         			</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 produitId ">
									
								</div>
								<div class="col-md-6">
									<div class="form-group form-md-line-input ">
										<label for="" class="col-md-2 control-label">Quantité </label>
										<div class="col-md-4 has-warning">
											<div class="input-icon">
												<input type="number" name="qty" id="qty" class="form-control  " min="0" placeholder="Quantité" required />
												<i class="fa fa-database"></i>
											</div>							
										</div>
										<label for="" class="col-md-2 control-label">Déchet </label>
										<div class="col-md-4 has-error">
											<div class="input-icon">
												<input type="number" name="dechet" class="form-control  " min="0" placeholder="déchet" required />
												<i class="fa fa-gear"></i>
											</div>							
										</div>
									</div>
								</div>
								
							</div>
					</div>
					<?php 
					
					$formulee = Formule::trouve_formule_par_societe($nav_societe->id_societe);
					 ?>
				<!-- nav product -->
				<div class="portlet-body">
				
								
										<div class="info-formule">
										
										</div>
			
				</div>
					<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-9 col-md-9">
									<button type="submit" name = "submit" class="btn green">Ajouter</button>
													
								</div>
							</div>
						</div>
					</form>
					<!-- END FORM-->
			</div>
	
		</div>
	</div>
	</div>
	<div class="col-md-4">
				<?php 
					$production = Production ::trouve_last_production_par_societe($nav_societe->id_societe);
					$cpt = 0;
					if (!empty($production)){ ?>
			<div class=" rounded-3 margin-bottom-30 portlet light bordered ">
				<a  href="#production<?php echo $production->id ; ?>" data-toggle="modal"   class="">
				<div    id="<?php if (isset($production->id)) {echo $production->id;} ?>"   class="select_doc">
					<div class="widget-news  ">
					<?php 
					$produit = Produit::trouve_par_id($production->produit_finale);
					if (!empty($produit->img_produit)) {
											echo'<a class="pull-right " href="javascript:;"> <img class="thumbnail" src="scan/produit/'.$produit->img_produit.'" alt="64x64" style="width: 94px; height: 94px;" /></a> '; 
															} else { ?>
													<a class=" " href="javascript:;">
														<img class="widget-news-left-elem bg-gray" src="scan/produit/no-image.png" alt="" style="width: 80px; height: 80px;"  >
													</a>
															<?php } ?>
					
							
						
						<div class="widget-news-right-body">
							<p><b><?php $produit = Produit ::trouve_par_id($production->produit_finale);
							echo $produit->Designation .'|' . $produit->code  ;?></b>	</p>
							<p>Disponible : <?php $stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);  if (isset($stock_prod->stock)) {echo $stock_prod->stock; }?>	Unités</p>
							<span >Prix :<?php echo $produit->prix_vente;?> DZ</span><br>
							<span class="font-yellow">Date :<?php echo $production->date;?> </span>
							
						</div>
						
					</div>
				</div>
				</a>
				</div>
					<?php } ?>
							</div>
	<div class="col-md-4">
		<div class="portlet light bordered">
			<div class="margin-bottom-20"><i class="fa fa-cubes font-red "></i>  Ajouter Formule
				<a href="production.php?action=formule"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a>
			</div>
			<div class="margin-bottom-20"><i class="fa fa-barcode font-yellow "></i> Ajouter Produit
				<a href="produit.php?action=add_produit"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a>
			</div>
			<div class="margin-bottom-20"><i class="fa fa-list font-blue "></i> Liste de Produit
				<a href="produit.php?action=list_produit"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a>
			</div>
				

		</div>
	</div>
	</div>
				
			
		<?php } else if ($action == 'edit_production') {

		 $thisday=date('Y-m-d');		
if (isset($id)) {
				$production = Production::trouve_par_id($id);
			}			
  ?>

<!-- BEGIN PAGE CONTENT-->

<div class="row profile">
	<div class="col-md-8 ">

			
			<?php 
						if (!empty($msg_error)){
							echo error_message($msg_error); 
						}elseif(!empty($msg_positif)){ 
							echo positif_message($msg_positif);	
						}elseif(!empty($msg_system)){ 
							echo system_message($msg_system);
						} ?>	
			<div class="portlet light bordered ">
				<div class="portlet-title">
					<div class="simplelineicons-demo">
						<span class="item-box">
							<span class="item">
								<span class="icon-plus font-yellow"></span> <span class="bs-glyphicon-class">
								Modifier </span> 
							</span>
						</span>
					</div>
				</div>
	
	
		<div class="portlet-body form">
		<div class="notification"></div>
			<div class="form-body">
							<!-- BEGIN FORM-->
					<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit_production" method="POST" class="form-horizontal margin-bottom-40 " enctype="multipart/form-data">
						<div class="form-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-md-line-input">					
										<label class="control-label col-md-3">Date <span class="required" aria-required="true"> * </span></label>
										<div class="col-md-8">
										<input type="date" name ="date" class="form-control input-inline input-medium "  value="<?php if (isset($production->date)) {echo $production->date;} ?>" required>						
										</div>					
									</div>  
								</div>
								<div class="col-md-6">
									<div class="form-group  ">
									<label for="" class="col-md-2 control-label">Article <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-10">
                                     <select class="form-control select2me" id="produitId"  placeholder="Choisir Article"  name="produit_finale"   required >
									 <option value=""></option>
										<?php 
										$produits = Produit::trouve_produit_production($nav_societe->id_societe);  
										  foreach ($produits as $Article) { ?>
										<option <?php if ($production->produit_finale == $Article->id_pro ) {echo "selected";}  ?> value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
											<?php } ?>															   
									</select> 
									</div>				
                         			</div>
								</div>
							</div>
							<div class="row">

								<div class="col-md-6 produitId ">
									<div class="form-group" style=" padding-top: 10px;margin-bottom: 20px; margin: 0 -15px 20px -15px;">
									<label for="" class="col-md-3 control-label">Formule <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-8">
										<?php 
													
								$formules = Formule::trouve_formule_par_id($production->produit_finale); ?>
                                     <select class="form-control select2me"   id="id_formule"  name="formule" required>
									 <option value=""></option>
										<?php 
								foreach($formules as $formule){?>
														
									<option <?php if ($production->formule == $formule->id ) {echo "selected";}  ?> value = "<?php echo $formule->id ?>" > <?php echo $formule->designation ?></option>
														
								<?php }?>															   
									</select> 
								
									</div>				
                         			</div>		
								</div>
								<div class="col-md-6">
									<div class="form-group form-md-line-input ">
										<label for="" class="col-md-2 control-label">Quantité </label>
										<div class="col-md-4 has-warning">
											<div class="input-icon">
												<input type="number" name="qty" id="qty" class="form-control  " value="<?php if (isset($production->qty)) {echo $production->qty;} ?>" min="0" placeholder="Quantité" required />
												<i class="fa fa-database"></i>
											</div>							
										</div>
										<label for="" class="col-md-2 control-label">Déchet </label>
										<div class="col-md-4 has-error">
											<div class="input-icon">
												<input type="number" name="dechet" class="form-control  " value="<?php if (isset($production->dechet)) {echo $production->dechet;} ?>" min="0" placeholder="déchet" required />
												<i class="fa fa-gear"></i>
											</div>							
										</div>
									</div>
								</div>
								
							</div>
					</div>
					<?php 
					
					$formulee = Formule::trouve_formule_par_societe($nav_societe->id_societe);
					 ?>
				<!-- nav product -->
				<div class="portlet-body">
				
								
										<div class="info-formule">
														<table class="table table-hover">
                                                        <thead>
                                                         <tr>
                                                                <th>
                                                                 Produit
                                                                </th>
                                                                <th>
                                                                Lot
                                                                </th>
                                                                <th>
                                                                 Qte
                                                                </th>
                                                                <th>
                                                                 P.U
                                                                </th>
                                                                <th>
                                                                Total
                                                                </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $somme_production = 0; 
                                                        $detail_formules = Detail_formule::trouve_detail_par_id_formule($production->formule);
                                                         foreach ($detail_formules as $detail_formule ){
                                                        $prod = Produit::trouve_par_id($detail_formule->id_Matiere_Premiere);
                                                        $lot_prod = Lot_prod::trouve_par_id($detail_formule->id_lot);
                                                        $cout_production = $lot_prod->prix_achat * $detail_formule->qte; ?>
                                                                <tr>
                                                                        <td><?php if (isset($prod->Designation)) {echo $prod->Designation.' | '.$prod->code;} ?></td>
                                                                        <td>
                                                                                <?php if (isset($lot_prod->code_lot)) {echo $lot_prod->code_lot;} ?>
                                                                        </td>
                                                                        <td><?php if (isset($detail_formule->qte)) {echo $detail_formule->qte;} ?></td>
                                                                        <td><?php if (isset($lot_prod->prix_achat)) {echo number_format($lot_prod->prix_achat,2,',',' ');}  ?></td>
                                                                         <td><?php if (isset($cout_production)) {echo number_format($cout_production,2,',',' ');}  ?>  </td>
                                                                        
                                                                </tr>

                                                        <?php  $tolal_production +=  $cout_production ;} ?>
                                                                </tbody>
                                                                                            </table> 
										</div>
			
				</div>
					<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-9 col-md-9">
									<input type="hidden" name="id" value="<?php if (isset($production->id)) {echo $production->id;} ?>">
									<button type="submit" name = "submit" class="btn green">Modifier</button>
													
								</div>
							</div>
						</div>
					</form>
					<!-- END FORM-->
			</div>
	
		</div>
	</div>
	</div>
	<div class="col-md-4">
				<?php 
					$production = Production ::trouve_last_production_par_societe($nav_societe->id_societe);
					$cpt = 0;
					if (!empty($production)){ ?>
			<div class=" rounded-3 margin-bottom-30 portlet light bordered ">
				<a  href="#production<?php echo $production->id ; ?>" data-toggle="modal"   class="">
				<div    id="<?php if (isset($production->id)) {echo $production->id;} ?>"   class="select_doc">
					<div class="widget-news  ">
					<?php 
					$produit = Produit::trouve_par_id($production->produit_finale);
					if (!empty($produit->img_produit)) {
											echo'<a class="pull-right " href="javascript:;"> <img class="thumbnail" src="scan/produit/'.$produit->img_produit.'" alt="64x64" style="width: 94px; height: 94px;" /></a> '; 
															} else { ?>
													<a class=" " href="javascript:;">
														<img class="widget-news-left-elem bg-gray" src="scan/produit/no-image.png" alt="" style="width: 80px; height: 80px;"  >
													</a>
															<?php } ?>
					
							
						
						<div class="widget-news-right-body">
							<p><b><?php $produit = Produit ::trouve_par_id($production->produit_finale);
							echo $produit->Designation .'|' . $produit->code  ;?></b>	</p>
							<p>Disponible : <?php $stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);  if (isset($stock_prod->stock)) {echo $stock_prod->stock; }?>	Unités</p>
							<span >Prix :<?php echo $produit->prix_vente;?> DZ</span><br>
							<span class="font-yellow">Date :<?php echo $production->date;?> </span>
							
						</div>
						
					</div>
				</div>
				</a>
				</div>
					<?php } ?>
							</div>
	<div class="col-md-4">
		<div class="portlet light bordered">
			<div class="margin-bottom-20"><i class="fa fa-cubes font-red "></i>  Ajouter Formule
				<a href="production.php?action=formule"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a>
			</div>
			<div class="margin-bottom-20"><i class="fa fa-barcode font-yellow "></i> Ajouter Produit
				<a href="produit.php?action=add_produit"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a>
			</div>
			<div class="margin-bottom-20"><i class="fa fa-list font-blue "></i> Liste de Produit
				<a href="produit.php?action=list_produit"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a>
			</div>
				

		</div>
	</div>
	</div>

<?php 	}}}?>
			
		
	</div>
	</div>
	
	<!-- END CONTENT -->

	<script>

		$(document).ready(function() {
			$(document).on('click','#add_formule', function() {
			
			$(".item-row:last").before('<tr class="item-row"><td><select name="id_produit[]"  id="id_produit" class=" form-control select2me" required ><option value=""  ></option><?php  foreach ($Articles as $Article) { echo'<option value="'.$Article->id_pro.'"> '.$Article->Designation.' | '.$Article->code.'</option>';} ?></select></td><td><input type="text" name="qty[]" id="qty" min="0" class="form-control" ></td> <td><a class="btn btn-danger btn-sm" id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash" ></i></a></td></tr>');
			$('.select2me').select2('destroy');
			$('.select2me').select2();
				
		});

		$(document).on('click','#delete', function() {
			$(this).parents('.item-row').fadeOut();
			$(this).parents('.item-row').remove();
		});
		$('#id_produit').select2();
		});
		


  </script>

		

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>