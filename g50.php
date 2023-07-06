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
$titre = "ThreeSoft | G50 ";
$active_menu = "g50";
$active_submenu = "g50";
$header = array('table');
if ($user->type == "administrateur"){
	if (isset($_GET['action']) && $_GET['action'] =='list_g50' ) {
$action = 'list_g50';
	}else if (isset($_GET['action']) && $_GET['action'] =='add_g50' ) {
		$action = 'add_g50';}
else if (isset($_GET['action']) && $_GET['action'] =='save_g50' ) {
	$action = 'save_g50';}
	else if (isset($_GET['action']) && $_GET['action'] =='affiche_G50' ) {
	$action = 'affiche_G50';}
else if (isset($_GET['action']) && $_GET['action'] =='open' ) {
$action = 'open';}
else if (isset($_GET['action']) && $_GET['action'] =='close_societe' ) {
$action = 'close_societe';}
if($action == 'open' ){
	$errors = array();
	// verification de données 	
        if (isset($_POST['id'])|| !empty($_POST['id'])){
	       $id = intval($_POST['id']);
			$nsociete = Client::trouve_par_id($id);
        }elseif (isset($_GET['id'])|| !empty($_GET['id'])){
	       $id = intval($_GET['id']);
		   $nsociete = Client::trouve_par_id($id);
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
	$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
	
?>
<?php
// BEGIN add_g50
if ($user->type == "administrateur"){
	if(isset($_POST['submit']) && $action == 'add_g50'){
		$errors = array();
		// new object Upload
		
	if (empty($errors)){
		$month = htmlentities(trim($_POST['month']));
		$monthAvant = htmlentities(trim($_POST['month'])) - 1;
		$thisyear = htmlentities(trim($_POST['year']));
		$dateMonthAvant = 	$thisyear.'-'.'01-01';	
		$dateMonthAvantFin = 	$thisyear.'-'.$monthAvant.'-31';	
		
		$date_db = $thisyear.'-'.$month.'-01';
		$date_fin =  $thisyear.'-'.$month.'-31' ;

		$facturesAvant  = Facture_vente::trouve_facture_par_societe_etat_g50($nav_societe->id_societe,$dateMonthAvant,$dateMonthAvantFin);
		$facturesNonEspese  = Facture_vente::trouve_facture_par_societe_NoEspece_month($nav_societe->id_societe,$date_db,$date_fin);
		$facturesEspese  = Facture_vente::trouve_facture_par_societe_especes($nav_societe->id_societe,$date_db,$date_fin);
		$facturesAterme  = Facture_vente::trouve_facture_par_societe_aTerme($nav_societe->id_societe,$date_db,$date_fin);

		$facturesAchatAvant  = Facture_achat::trouve_facture_par_societe_etat_g50($nav_societe->id_societe,$dateMonthAvant,$dateMonthAvantFin);
		$facturesAchatNonEspese  = Facture_achat::trouve_facture_par_societe_month($nav_societe->id_societe,$date_db,$date_fin);
		$facturesAchatEspese  = Facture_achat::trouve_facture_par_societe_especes($nav_societe->id_societe,$date_db,$date_fin);
		$facturesAchatAterme  = Facture_achat::trouve_facture_par_societe_aTerme($nav_societe->id_societe,$date_db,$date_fin);
		$facturesImportation  = facture_importation ::trouve_importation_par_societe_etat_g50($nav_societe->id_societe,$date_db,$date_fin);
		$facturesDepense  = Facture_depense ::trouve_Depense_par_societe_etat_g50($nav_societe->id_societe,$date_db,$date_fin);
		
 		}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
		}
	}

// g50 form
	if($action == 'save_g50'){
		$thisday=date('Y-m-d');	
		$errors = array();
		// new object Upload
		
	if (empty($errors)){
		


		 if (isset($_GET['id_facture']))  {
			$id_facture = $_GET['id_facture'];
			
			if (!empty($id_facture) ){
			$all = $id_facture ;
						
			$idArray1 = explode(',',$all);
				
			$total_HT = 0;
			$total_HT19 =0;
			$total_HT_vente =0;
			$total_timbre_impo =0;
			$chiffre_affaire_imposable = 0;
			$montant_timbre = 0;
			$montant_timbre_tva = 0;

			$total_vente = 0;
			$total_venteeES =0;	
			$sommeTol09 = 0;	
			$sommeTol19a =0;
			$sommeTol0a =0;
			$tot_tva_depense=0;
			$total_somme_depense=0;
			foreach ($idArray1 as $idArrays){
				if (!empty($idArrays)){				
				
					$factVenteNoEspece = Facture_vente::trouve_facture_vente_autre_espece($idArrays);
					$factEspeces = Facture_vente::trouve_facture_vente_espece($idArrays);
					$timbres = Facture_vente::trouve_vente_par_facture_timbre($idArrays);	
					
					foreach($timbres as $timbre){
						
						$chiffre_affaire_imposable +=  $timbre->somme_ttc;
						$montant_timbre_tva += $timbre->timbre;
						
					}
					foreach ($factVenteNoEspece as $fatures){ 
						
						$total_vente += $fatures->somme_ht ;
						
					}
					foreach ($factEspeces as $faturess){ 
						
						$total_venteeES += $faturess->somme_ht ;
						
						}

					$IdFactVente = vente::trouve_vente_par_facture($idArrays);
					$HT_09 = vente::trouve_vente_par_facture_tva_9($idArrays);
					$HT_19 = vente::trouve_vente_par_facture_tva_19($idArrays);
					$HT_00 = vente::trouve_vente_par_facture_tva_0($idArrays);
								foreach($HT_09 as $HT_09s){
								$sommeTol09 +=	$HT_09s->Ht;
									
								}
								foreach($HT_19 as $HT_19s){
								$sommeTol19a +=	$HT_19s->Ht;
									
								}
								foreach($HT_00 as $HT_00s){
								$sommeTol0a +=	$HT_00s->Ht;
									
								}
			}}
			$total_somme_vente= 0; 
			$total_somme_vente = $total_vente + $total_venteeES;
			$sommeTol19 = $sommeTol19a + $sommeTol0a;
			$montantDroit09 = $sommeTol09 * 0.09;	

		}
		}
		if (isset($_GET['id_achat']) ){
			$id_achat = $_GET['id_achat'];
			
			if (!empty($id_achat) ){
				$all_id_achat = $id_achat ;
						
				$idArrayachat = explode(',',$all_id_achat); 
				$total_achat = 0;
				$totalTva_achat = 0;
				$total_achat_espece = 0;
				$totalTva_achat_espece = 0;
				foreach ( $idArrayachat as $idArrayachats){
				if (!empty($idArrayachats)){
					
				$fact = Facture_achat::trouve_facture_achat($idArrayachats);
				
					foreach ($fact as $facts){ 
					
					$total_achat += $facts->somme_ht ;
					$totalTva_achat += $facts->somme_tva ;
					$total_achat_espece += $facts->somme_ht ;
					$totalTva_achat_espece += $facts->somme_tva ;
					}
					
					
				}
				$total_somme_achat= 0; 
				$total_somme_achat = $total_achat + $total_achat_espece;
				}
		
			}
		}
		if (isset($_GET['id_importation']) ){
				$id_importation = $_GET['id_importation'];
				$totalTva_imortation =0;
				if (!empty($id_importation) ){								
					$idArrayImportation = explode(',',$id_importation); 
					 $total_impotation = 0;
					 $totalTva_imortation = 0;
					
					foreach ( $idArrayImportation as $idArrayImportations){
						$table_frais = Achat_importation::trouve_frais_par_annexe($idArrayImportations);
						
						
						 foreach($table_frais as $table_frais){
							 $total_impotation += $table_frais->Ht ;
							$totalTva_imortation += $table_frais->Tva ;
						 }
					}
				}
		}	
		if (isset($_GET['id_depense']) ){
				$id_depense = $_GET['id_depense'];
				if (!empty($id_depense) ){
					$all_id_depense = $id_depense ;
					$depenses = explode(',',$all_id_depense); 
								
				foreach ( $depenses as $depense){
					if (!empty($depense)){					
				$fact = Facture_depense::trouve_facture_depense_par_id_facture($depense);
					foreach($fact  as $fact_depense){ 
							$tot_tva_depense += $fact_depense->tva ;
							$total_somme_depense += $fact_depense->ht;
				}
				}
				}}
		}	

		if (isset($_GET['year_g50'])){
			$date_of_year = htmlentities(trim($_GET['year_g50']));
		}
		if (isset($_GET['date_g50'])){
			$month = htmlentities(trim($_GET['date_g50']));
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

	if (isset($_POST['submit']) && $action == 'save_g50'){

	$id_facture_vente = unserialize($_POST['id_facture_vente']);
	$id_facture_achat = unserialize($_POST['id_facture_achat']);
	$id_facture_importation = unserialize($_POST['id_importation']);
	$id_facture_depense = unserialize($_POST['id_facture_depense']);
	$month = htmlentities(trim($_POST['month']));
	$annee = htmlentities(trim($_POST['annee']));
	$date_of_year = $annee.'-'.$month.'-01';

	$random_number = rand();

	$errors = array();
	// new object G50
	$g50 = new G50();

	$g50->annee = htmlentities(trim($_POST['annee']));
	$g50->mois = htmlentities(trim($_POST['mois']));
	$g50->date_creation = htmlentities(trim($_POST['date_creation']));
	$g50->date_g50 = $date_of_year;
	$g50->id_societe = $nav_societe->id_societe;
	$g50->id_user = $user->id;
	$g50->etat = 1;
	$g50->random = $random_number;	

	$msg_positif= '';
	$msg_system= '';

	if (empty($errors)){
				
		if ($g50->existe()) {
			$msg_error = '<p >  G50 du    : ' . $g50->mois	 . ' existe déja !!!</p><br />';
			
		}else{
			$g50->save();

			$last_G50 = G50::trouve_par_random($random_number);

			foreach ($id_facture_vente as $ArrayId){
				$Upfact = Facture_vente::trouve_par_id($ArrayId);
				$Upfact->id_g50 = $last_G50->id;
				$Upfact->save();
			}
			
			foreach ($id_facture_achat as $idArrayachats){
				
				$Upfact_achat = Facture_achat::trouve_par_id($idArrayachats);
				$Upfact_achat->id_g50 =$last_G50->id;
				$Upfact_achat->save();
				
			}
			foreach ($id_facture_importation as $idArrayImportations){
				
				$Upfact_imortation = Achat_importation::trouve_par_id($idArrayImportations);
				
				$Upfact_imortation->id_g50 =$last_G50->id;
				$Upfact_imortation->save();
				
			}
			foreach ($id_facture_depense as $idArrayDepense){
				$Upfact_depense = Facture_depense::trouve_par_id($idArrayDepense);
				
				$Upfact_depense->id_g50 =$last_G50->id;
				$Upfact_depense->save();
				
			}
	// Taxe_activite
	
			$taxe_activite = new Taxe_activite();
			$taxe_activite->total_vente = htmlentities(trim($_POST['total_vente']));
			$taxe_activite->total_vente_espece = htmlentities(trim($_POST['total_vente_espece']));
			$taxe_activite->imposable = htmlentities(trim($_POST['imposable']));
			$taxe_activite->imposable_espece = htmlentities(trim($_POST['imposable_espece']));
			$taxe_activite->montant_payer_autre = htmlentities(trim($_POST['montant_payer_autre']));
			$taxe_activite->montant_payer_espece = htmlentities(trim($_POST['montant_payer_espece']));
			$taxe_activite->total_chiffre_affaire = htmlentities(trim($_POST['total_chiffre_affaire']));
			$taxe_activite->total_imposable = htmlentities(trim($_POST['total_imposable']));
			$taxe_activite->total_montant_payer = htmlentities(trim($_POST['total_montant_payer']));
			// droit de timbre
	
			$taxe_activite->des_e2 = htmlentities(trim($_POST['des_e2']));
			$taxe_activite->montant_timbre_tva = htmlentities(trim($_POST['montant_timbre_tva']));
			$taxe_activite->total_chiffre_affaire_imposable = htmlentities(trim($_POST['total_chiffre_affaire_imposable']));
			$taxe_activite->chiffre_affaire_imposable = htmlentities(trim($_POST['chiffre_affaire_imposable']));
			$taxe_activite->total_montant_timbre_tva = htmlentities(trim($_POST['total_montant_timbre_tva']));
			//
			
			$taxe_activite->autre_C = htmlentities(trim($_POST['autre_C']));
			$taxe_activite->total_recaptulation = htmlentities(trim($_POST['total_recaptulation']));


			$taxe_activite->id_g50 = $last_G50->id;
			$taxe_activite->id_user = $user->id;
			$taxe_activite->save();
	//IBS 
			if (isset($_POST['trimestre'])){
			$ibs = new Ibs();
			$ibs->trimestre = htmlentities(trim($_POST['trimestre']));
			$ibs->montant_payer_ibs = htmlentities(trim($_POST['montant_payer_ibs']));
			$ibs->total_payer_ibs = htmlentities(trim($_POST['total_payer_ibs']));
			$ibs->id_g50 = $last_G50->id;
			$ibs->id_user = $user->id;
			$ibs->save();
			}
	//Taxe_valeur_ajoutee 
		
			$taxe_valeur = new Taxe_valeur_ajoutee();

			$taxe_valeur->Chiffre_affaires_total9 = htmlentities(trim($_POST['Chiffre_affaires_total9']));
			$taxe_valeur->Chiffre_affaires_total19 = htmlentities(trim($_POST['Chiffre_affaires_total19']));
			$taxe_valeur->Chiffre_affaires_exonere19 = htmlentities(trim($_POST['Chiffre_affaires_exonere19']));
			$taxe_valeur->tva_imp9 = htmlentities(trim($_POST['tva_imp9']));
			$taxe_valeur->tva_imp19 = htmlentities(trim($_POST['tva_imp19']));
			$taxe_valeur->mont_tva9 = htmlentities(trim($_POST['mont_tva9']));
			$taxe_valeur->mont_tva19 = htmlentities(trim($_POST['mont_tva19']));
			$taxe_valeur->total_gen_CA = htmlentities(trim($_POST['total_gen_CA']));
			$taxe_valeur->total_gen_exonere = htmlentities(trim($_POST['total_gen_exonere']));
			$taxe_valeur->TotalChiffreAffaireImposable = htmlentities(trim($_POST['TotalChiffreAffaireImposable']));
			$taxe_valeur->TotalmontantDroit = htmlentities(trim($_POST['TotalmontantDroit']));
			$taxe_valeur->id_g50 = $last_G50->id;
			$taxe_valeur->id_user = $user->id;

			$taxe_valeur->save();
		//Deductions a operer /  
		
			$Deductions = new Deductions_tva ();

			$Deductions->precompte = htmlentities(trim($_POST['precompte']));
			$Deductions->tva_achats_biens = htmlentities(trim($_POST['tva_achats_biens']));
			$Deductions->tva_ded2 = htmlentities(trim($_POST['tva_ded2']));
			$Deductions->ded_compl = htmlentities(trim($_POST['ded_compl']));
			$Deductions->tva_recup = htmlentities(trim($_POST['tva_recup']));
			$Deductions->autre_ded = htmlentities(trim($_POST['autre_ded']));
			$Deductions->Total_deductions = htmlentities(trim($_POST['Total_deductions']));

			$Deductions->TOTAL_dus = htmlentities(trim($_POST['TOTAL_dus']));
			$Deductions->ded_exce = htmlentities(trim($_POST['ded_exce']));
			$Deductions->rever_ded = htmlentities(trim($_POST['rever_ded']));
			$Deductions->tot_rap = htmlentities(trim($_POST['tot_rap']));
			$Deductions->total_B = htmlentities(trim($_POST['total_B']));
			$Deductions->tva_paye = htmlentities(trim($_POST['tva_paye']));
			$Deductions->prec_repor = htmlentities(trim($_POST['prec_repor']));

			$Deductions->id_g50 = $last_G50->id;
			$Deductions->id_user = $user->id;
			$Deductions->save();
			
 		$msg_positif = '<p >  G50 du    : ' . $g50->mois	 . ' est bien ajouter  </p><br />';
		
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
// END G50
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
                        <a href="#">G50</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_g50') { ?>
                        <a href="g50.php?action=add_g50">Nouveau G50</a> 
                        
                        
                    <?php }elseif ($action == 'list_g50') {
                        echo '<a href="g50.php?action=list_g50">Liste G50</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="client.php?action=edit_client">Modifier Client</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
			
				if ($action == 'list_g50') {
							
				?>
				<div class="notification"></div>
		<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				if (isset($_POST['submit']) ) {
				
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$list_g50 = G50::trouve_g50_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin); 

				
				}else{
					$list_g50 = G50::trouve_g50_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin); 
				}
				

			
				 ?>

			<div class="row">
				<div class="col-md-7">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
					<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>G50
							</div>
						</div>
				
							
						<div class="portlet-body">
						<a  href="#g50" data-toggle="modal" class="btn red"  ><i class="fa  fa-file "></i> Nouveau G50</a>
						<div class="table-scrollable table-scrollable-borderless">
                         <table class="table table-striped  table-hover ">
							<thead>
							<tr>
								
								<th>
									Mois 
								</th>
								<th>
									Annee 
								</th>
								<th>
									Date de creation 
								</th>
								<th>
									#
								</th>
								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($list_g50 as $list_g50S){
									
								?>
							<tr>
								
								
								<td>
									<a href="g50.php?action=affiche_G50&id=<?php if(isset($list_g50S->id)) {echo $list_g50S->id; }?>">
									<i class="fa fa-file-text-o bg-yellow"></i>
								
									<?php if (isset($list_g50S->mois)) {
										echo $list_g50S->mois ;
									 } ?>
									</a>
								</td>
								<td>
									<?php if (isset($list_g50S->annee)) {
									echo $list_g50S->annee;
									} ?>
								</td>
								<td>
									<?php if (isset($list_g50S->date_creation)) {
									echo '<i class="fa fa-calendar font-yellow"></i> '. $list_g50S->date_creation;
									} ?>
								</td>
								<td></td>
								
							
								
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
				<div class="col-md-5">
					<div class="portlet light bordered"> 					
						<!-- BEGIN FORM-->
							<form action="<?php echo $_SERVER['PHP_SELF']?>?action=list_g50" method="POST" class="form-horizontal">

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="col-md-3 control-label">Du</label>
														<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="" required >
															
														</div>					
														</div>
												</div>
											</div>	
											<div class="col-md-4">													
												<div class="form-group">
													<label class="col-md-3 control-label">au</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value ="" required >
															
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
				
			</div>
			
			<?php  

				}elseif ($action == 'add_g50') {		
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
										<div class="caption">
											<i class="fa fa-archive font-yellow"></i> G50 <span class="caption-helper"> - Mois:
                            <?php
                                $month_name = mktime(0, 0, 0, $month, 10);
								$g50_mois = $mois[date("n", $month_name)];
                                echo $g50_mois."\n";?></span> 
										</div>

									</div>
							
									<div class="portlet-body">
										<div class="row">
										<div class="col-md-12"> 
										<!-- BEGIN g50-->
											<?php
											require_once("g50/g50_vente.php");
											require_once("g50/g50_achat.php");
											require_once("g50/g50_importation.php");
											require_once("g50/g50_depense.php");
										
											?>
										</div>
										 <div class="col-md-12">       
											<div  class="well" >
										
											
											
											<label class=" control-label"></label>
										
												<button class=" select_g50 btn  blue pull-right" id="valider_g50" type="submit" value="Submit" > <i class="fa fa-check-square-o"></i> Valider G50 </button> 
											
													</div>
											</div>
										<!-- END g50-->
									</div>
									</div>
								</div>
				</div>
			</div>
			<?php  

				}elseif ($action == 'save_g50') {		
				  ?>

			<!-- BEGIN PAGE CONTENT-->
			
			<div class="row ">
			
				<div class="portlet-body">
				
					<div class="col-md-12">

					<?php 
						if (!empty($msg_error)){
							echo error_message($msg_error); 
								}elseif(!empty($msg_positif)){ 
									echo positif_message($msg_positif);	
								}elseif(!empty($msg_system)){ 
									echo system_message($msg_system);
						} ?>
						<!-- BEGIN g50-->
							<?php
							
								require_once("g50/form.php");
							?>
						<!-- END g50-->
					</div>

				</div>
			</div>
						<?php  

				}elseif ($action == 'affiche_G50') {		
				 
					
					if (isset($_GET['id'])) {
					 $id =  htmlspecialchars(intval($_GET['id'])) ;
					 $id_g50 = G50::trouve_par_id($id,$nav_societe->id_societe);
					}else{
							echo 'Content not found....';
					} ?>
			<div class="row ">
			
				<div class="portlet-body">
				
					<div class="col-md-12">

					<?php 
						if (!empty($msg_error)){
							echo error_message($msg_error); 
								}elseif(!empty($msg_positif)){ 
									echo positif_message($msg_positif);	
								}elseif(!empty($msg_system)){ 
									echo system_message($msg_system);
						} ?>
						<!-- BEGIN g50-->
							<?php
							
								require_once("g50/form_affiche_G50.php");
							?>
						<!-- END g50-->
					</div>

			</div>
			<?php }}?>
		
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN Model G50 THUMB -->
	
	<div id="g50" class="modal  fade" tabindex="-1" data-backdrop="static" data-keyboard="false"  >
											
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title"><i class="fa  fa-calendar font-yellow "></i> G50 Année </h4>
			</div>
				<div class="modal-body">
					<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_g50" method="POST" class="form-horizontal" enctype="multipart/form-data">
						<div class="form-body">
						<br/>
						<div class="form-group">
							<label class="control-label col-md-4">Mois <span class="required" aria-required="true"> * </span></label>
								<div class="col-md-8">
									<div class="input-group date form_datetime input-medium">
										<select class="form-control" id="month" name="month" required >
										<option >Selectonner un mois</option>
										<option value="01">Janvier</option>
										<option value="02">Février</option>
										<option value="03">Mars</option>
										<option value="04">Avril</option>
										<option value="05">Mai</option>
										<option value="06">Juin</option>
										<option value="07">Juillet</option>
										<option value="08">Août</option>
										<option value="09">Septembre</option>
										<option value="10">Octobre</option>
										<option value="11">Novembre</option>
										<option value="12">Décembre</option>
										
									</select>
										<span class="input-group-btn">
										<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								<!-- /input-group -->
								</div>
						</div>
						<?php if (isset($nav_societe->id_societe)){ $entrp = Societe::trouve_par_id($nav_societe->id_societe);
							 $date1 = $entrp->exercice_debut;} ?>
							<div class="form-group">
							<label class="control-label col-md-4">Année <span class="required" aria-required="true"> * </span></label>
								<div class="col-md-8">
									<div class="input-group date form_datetime input-medium">
										<input type="text" class="form-control" name="year" value="<?php echo date('Y', strtotime( $date1));?>" id="datepicker" required />
										<span class="input-group-btn">
										<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								<!-- /input-group -->
								</div>
	
							</div>
							
								<div class="modal-footer">
									<button  class="btn btn-success" type="submit" name = "submit"><i class="fa fa-arrow-right fa-fw"></i> Valider</button>
									<button class="btn red" data-dismiss="modal" aria-hidden="true">Fermer</button>
																		
								</div>
						</div>
					</form>							
																			
																	
																			
			</div>
		
																
	</div>
	<!-- END Model G50 -->
<!-- END CONTAINER -->
<script>
		$(document).ready(function(){
		  $("#datepicker").datepicker({
			 format: "yyyy",
			 viewMode: "years", 
			 minViewMode: "years",
			 autoclose:true
		  });   
		})

	  $(document).on('click','#valider_g50', function() {
		var idVente = [];     
       
        // Initializing array with Checkbox checked values
		$("input[name='IdCheckbox']:checked").each(function(){
            idVente.push(this.value);
			
        });
		
       
		///
		var idAchat = [];
		
        // Initializing array with Checkbox checked values
        $("input[name='IdCheckboxachat']:checked").each(function(){
            idAchat.push(this.value);
			
        });
		///
		var idImportation = [];
		
        // Initializing array with Checkbox checked values
        $("input[name='IdCheckboxImportation']:checked").each(function(){
            idImportation.push(this.value);
			
        });
		var idDepense = [];
		
        // Initializing array with Checkbox checked values
        $("input[name='IdCheckboxDepense']:checked").each(function(){
            idDepense.push(this.value);
			
        });
		///
	
		var date_g50 =<?php echo $month ;?>;
		var year_g50 = <?php echo $thisyear ;?>;
			window.location = 'g50.php?action=save_g50&date_g50='+date_g50+'&year_g50='+year_g50+'&id_facture='+idVente+'&id_achat='+idAchat+'&id_importation='+idImportation+'&id_depense='+idDepense;
		
  });
  

</script>


<?php
require_once("footer/footer.php");
?>