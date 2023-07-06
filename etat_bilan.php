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

$titre = "ThreeSoft | Bilan ";
$active_menu = "saisie";
$total_count=0;
$header = array('table','invoice','print');
if ($user->type == "administrateur"){
	if (isset($_GET['action']) && $_GET['action'] =='Bilan_actif' ) {
		$active_submenu = "Bilan_actif";
$action = 'Bilan_actif';
$titre = "ThreeSoft | BILAN ACTIF ";
	}else if (isset($_GET['action']) && $_GET['action'] =='Bilan_passif' ) {
		$active_submenu = "Bilan_passif";
$action = 'Bilan_passif';
$titre = "ThreeSoft | BILAN PASSIF ";
	}else if (isset($_GET['action']) && $_GET['action'] =='tcr' ) {
		$active_submenu = "TCR";
$action = 'tcr';
$titre = "ThreeSoft | BILAN TCR ";
	}else if (isset($_GET['action']) && $_GET['action'] =='mouvements_stocks' ) {
		$active_submenu = "mouvements_stocks";
$action = 'mouvements_stocks';
$titre = "ThreeSoft | Mouvements des stocks ";
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_mouvements_stocks' ) {
		$active_submenu = "etat_mouvements_stocks";
$action = 'etat_mouvements_stocks';
$titre = "ThreeSoft | Mouvements des stocks ";
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_Bilan_actif' ) {
		$active_submenu = "Bilan_actif";
$action = 'etat_Bilan_actif';
$titre = "ThreeSoft | BILAN ACTIF ";
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_Bilan_passif' ) {
		$active_submenu = "Bilan_passif";
$action = 'etat_Bilan_passif';
$titre = "ThreeSoft | BILAN PASSIF ";
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_Bilan_tcr' ) {
		$active_submenu = "TCR";
$action = 'etat_Bilan_tcr';
$titre = "ThreeSoft | TCR ";
	}else if (isset($_GET['action']) && $_GET['action'] =='get_rapport' ) {
		$active_submenu = "Rapports";
$action = 'get_rapport';
	}else if (isset($_GET['action']) && $_GET['action'] =='rapport' ) {
		$active_submenu = "Rapports";
$action = 'rapport';
	}else if (isset($_GET['action']) && $_GET['action'] =='balance' ) {
		$active_submenu = "balance";
		$active_menu = 'saisie';
$titre = "ThreeSoft | BALANCE ";
$action = 'balance';
	}else if (isset($_GET['action']) && $_GET['action'] =='grand_livre' ) {
		$active_submenu = "grand_livre";
		$active_menu = 'saisie';
$action = 'grand_livre';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_balance' ) {
		$active_submenu = "balance";
		$active_menu = 'saisie';
$titre = "ThreeSoft | BALANCE ";
$action = 'etat_balance';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_grand_livre' ) {
		$active_submenu = "grand_livre";
		$active_menu = 'saisie';
$titre = "ThreeSoft | GRAND LIVRE ";
$action = 'etat_grand_livre';
	}	else if (isset($_GET['action']) && $_GET['action'] =='recherche_ecriture' ) {
		$active_submenu = "recherche_ecriture";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Recherche Ecriture ";
$action = 'recherche_ecriture';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_recherche_ecriture' ) {
		$active_submenu = "etat_recherche_ecriture";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Recherche Ecriture ";
$action = 'etat_recherche_ecriture';
	} else if (isset($_GET['action']) && $_GET['action'] =='annexe_2' ) {
		$active_submenu = "annexe_2";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 2 ";
$action = 'annexe_2';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_annexe_2' ) {
		$active_submenu = "etat_annexe_2";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 2 ";
$action = 'etat_annexe_2';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='annexe_3' ) {
		$active_submenu = "annexe_3";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 3 ";
$action = 'annexe_3';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_annexe_3' ) {
		$active_submenu = "etat_annexe_3";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 3 ";
$action = 'etat_annexe_3';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='annexe_4' ) {
		$active_submenu = "annexe_4";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 4 ";
$action = 'annexe_4';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_annexe_4' ) {
		$active_submenu = "etat_annexe_4";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 4 ";
$action = 'etat_annexe_4';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='annexe_5' ) {
		$active_submenu = "annexe_5";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 5 ";
$action = 'annexe_5';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_annexe_5' ) {
		$active_submenu = "etat_annexe_5";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 5 ";
$action = 'etat_annexe_5';
	}
		else if (isset($_GET['action']) && $_GET['action'] =='annexe_6' ) {
		$active_submenu = "annexe_6";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 6 ";
$action = 'annexe_6';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_annexe_6' ) {
		$active_submenu = "etat_annexe_6";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 6 ";
$action = 'etat_annexe_6';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='annexe_7' ) {
		$active_submenu = "annexe_7";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 7 ";
$action = 'annexe_7';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_annexe_7' ) {
		$active_submenu = "etat_annexe_7";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 7 ";
$action = 'etat_annexe_7';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='annexe_8' ) {
		$active_submenu = "annexe_8";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 8 ";
$action = 'annexe_8';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_annexe_8' ) {
		$active_submenu = "etat_annexe_8";
		$active_menu = 'saisie';
$titre = "ThreeSoft | Annexe 8 ";
$action = 'etat_annexe_8';
	}

}
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
if (isset($_POST['submit']) && $action == 'rapport') {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date_db']));
	$date_fin = trim(htmlspecialchars($_POST['date_fin']));
 	
 	    $factures  = Facture_achat::recherche($date_db,$date_fin);
		$facturess = Facture_vente::recherche($date_db,$date_fin);
	    
	
	
	
	

	}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}

if (isset($_POST['submit']) && $action == 'etat_Bilan_actif') {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date_db']));
	$date_fin = trim(htmlspecialchars($_POST['date_fin']));
 	
	

	}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}
if (isset($_POST['submit']) && $action == 'etat_annexe_2') {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date_db']));
	$date_fin = trim(htmlspecialchars($_POST['date_fin']));
 	
	

	}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}
if (isset($_POST['submit']) && ($action == 'etat_annexe_3' || $action == 'etat_annexe_4' || $action == 'etat_annexe_5' || $action == 'etat_annexe_6' || $action == 'etat_annexe_7' || $action == 'etat_annexe_8')) {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date_db']));
	$date_fin = trim(htmlspecialchars($_POST['date_fin']));
 	
	

	}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}

if (isset($_POST['submit']) && $action == 'etat_Bilan_passif') {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date_db']));
	$date_fin = trim(htmlspecialchars($_POST['date_fin']));
 	
	

	}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}
if (isset($_POST['submit']) && $action == 'etat_Bilan_tcr') {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date_db']));
	$date_fin = trim(htmlspecialchars($_POST['date_fin']));
 	
	

	}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}
if (isset($_POST['submit']) && $action == 'etat_mouvements_stocks') {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date_db']));
	$date_fin = trim(htmlspecialchars($_POST['date_fin']));
 	
	

	}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}
if (isset($_POST['submit']) && $action == 'etat_recherche_ecriture') {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date_db']));
	$date_fin = trim(htmlspecialchars($_POST['date_fin']));
	
 	$id_piece = trim(htmlspecialchars($_POST['id_piece']));
	
	

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
			
			<!-- BEGIN PAGE CONTENT-->
			
			<!-- BEGIN PAGE HEADER-->
			
			<div class="page-bar">
				<ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                       
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                       <a href="#">Liasse fiscale</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
					<li>
                     <?PHP
					if ($action == 'Bilan_actif') {
						echo '<a href="etat_bilan.php?action=Bilan_actif">Bilan actif </a> ';
					
					}
					if ($action == 'Bilan_passif') {
							echo '<a href="etat_bilan.php?action=Bilan_passif">Bilan passif </a> ';
						
						}
					if ($action == 'tcr') {
							echo '<a href="etat_bilan.php?action=tcr"> TCR </a> ';
						
						}
                    if ($action == 'etat_Bilan_actif') {
						echo '<a href="etat_bilan.php?action=Bilan_actif">Bilan actif - Exercice clos le : '.fr_date3($date_fin) .'</a> ';
					
					}	
					if ($action == 'etat_Bilan_passif') {
						echo '<a href="etat_bilan.php?action=Bilan_passif">Bilan passif - Exercice clos le : '.fr_date3($date_fin) .'</a> ';
					
					}
					if ($action == 'etat_Bilan_tcr') {
						echo '<a href="etat_bilan.php?action=etat_Bilan_tcr">Bilan TCR - Exercice clos le : '.fr_date3($date_fin) .'</a> ';
					
					}
					if ($action == 'annexe_2') {
						echo '<a href="etat_bilan.php?action=annexe_2">Annexe 2 </a> ';
					
					}	
					if ($action == 'etat_annexe_2') {
						echo '<a href="etat_bilan.php?action=annexe_2">Annexe 2 - période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin) .'</a> ';
					
					}
					if ($action == 'annexe_3') {
						echo '<a href="etat_bilan.php?action=annexe_3">Annexe 3 </a> ';
					
					}	
					if ($action == 'etat_annexe_3') {
						echo '<a href="etat_bilan.php?action=annexe_3">Annexe 3 - période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin) .'</a> ';
					
					}
					if ($action == 'annexe_4') {
						echo '<a href="etat_bilan.php?action=annexe_4">Annexe 4 </a> ';
					
					}	
					if ($action == 'etat_annexe_4') {
						echo '<a href="etat_bilan.php?action=annexe_4">Annexe 4 - période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin) .'</a> ';
					
					}
					if ($action == 'annexe_5') {
						echo '<a href="etat_bilan.php?action=annexe_5">Annexe 5 </a> ';
					
					}	
					if ($action == 'etat_annexe_5') {
						echo '<a href="etat_bilan.php?action=annexe_5">Annexe 5 - période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin) .'</a> ';
					
					}
					if ($action == 'annexe_6') {
						echo '<a href="etat_bilan.php?action=annexe_6">Annexe 6 </a> ';
					
					}	
					if ($action == 'etat_annexe_6') {
						echo '<a href="etat_bilan.php?action=annexe_6">Annexe 6 - période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin) .'</a> ';
					
					}
					if ($action == 'annexe_7') {
						echo '<a href="etat_bilan.php?action=annexe_7">Annexe 7 </a> ';
					
					}	
					if ($action == 'etat_annexe_7') {
						echo '<a href="etat_bilan.php?action=annexe_7">Annexe 7 - période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin) .'</a> ';
					
					}
					if ($action == 'annexe_8') {
						echo '<a href="etat_bilan.php?action=annexe_8">Annexe 8 </a> ';
					
					}	
					if ($action == 'etat_annexe_8') {
						echo '<a href="etat_bilan.php?action=annexe_8">Annexe 8 - période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin) .'</a> ';
					
					}							
						if ($action == 'etat_balance') {
						echo '<a href="rapport.php?action=balance">BALANCE  période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin) .'</a> ';
					
					}if ($action == 'etat_grand_livre') {
						echo '<a href="rapport.php?action=grand_livre">GRAND LIVRE  période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin).'</a> ';
					
					}if ($action == 'etat_recherche_ecriture') {
						echo '<a href="rapport.php?action=recherche_ecriture">Ecriture  période  entre  : '. fr_date3($date_db) .' et '. fr_date3($date_fin).'</a> ';
					
					}
					?>
                    </li>
                    
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
							
						 if($action =="etat_Bilan_actif") {
				$thisday=date('Y-m-d');
				?>
		<!-- DEBUT Etat Actif-->
				<page size="A4" class="page-A4"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice cols le</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
									<p style="text-align: center ; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										BILAN (ACTIF)
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
							</div>
							<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
								</div>
								<div class="col-xs-4" style="text-align:right;font-weight: 700;">Série G, n°2 (2011)</div>
							</div>
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%" >
								<tr class="badr">
									<td rowspan="2"  width="40%" align="center"><b>ACTIF</b></td>
									<td colspan="3" align="center"><b>N</b></td>
									<td align="center"><b>N-1</b></td>
								</tr>
								<tr class="badr">
									<td align="center"  width="15%"><b>Montants<BR>
									Bruts</b></td>
									<td align="center" width="15%"><b>Amortissements
									,<br> provisions et <br>
									pertes de <br>
									valeurs</b></td>
									<td align="center" width="15%"><b>Net</b></td>
									<td align="center" width="15%"><b>Net</b></td>
								</tr>
								<?php $Bilan_actifs= Bilan_actif::trouve_tous(); $cpt=0;
								$TOTAL_ACTIF_NON_COURANT_mb=0;$TOTAL_ACTIF_COURANT_mb=0;$TOTAL_GENERAL_ACTIF_mb=0;
								$TOTAL_ACTIF_NON_COURANT_app=0;$TOTAL_ACTIF_COURANT_app=0;$TOTAL_GENERAL_ACTIF_app=0;
								////////////////////////////////// anterieur///////////////////////////////////////////////
								$TOTAL_ACTIF_NON_COURANT_app_anterieur=0;$TOTAL_ACTIF_COURANT_app_anterieur=0;$TOTAL_GENERAL_ACTIF_app_anterieur=0;
								$TOTAL_ACTIF_NON_COURANT_mb_anterieur=0;$TOTAL_ACTIF_COURANT_mb_anterieur=0;$TOTAL_GENERAL_ACTIF_mb_anterieur=0;
									foreach ($Bilan_actifs as $Bilan_actif) { $cpt++;

 ////////////////////// Montants ///////////////////////////////////////
 			if (!empty($Bilan_actif->mb) && !empty($Bilan_actif->mb_sauf)) {

				$Montants=Ecriture_comptable::trouve_somme_debit_par_date_and_2_attribut($nav_societe->id_societe,$Bilan_actif->mb,$Bilan_actif->mb_sauf,$date_db,$date_fin);
				$Montants_anterieur=Ecriture_comptable::trouve_somme_debit_par_date_and_2_attribut_anterieur($nav_societe->id_societe,$Bilan_actif->mb,$Bilan_actif->mb_sauf,$date_db);
									
									} else if(!empty($Bilan_actif->mb)){

				$Montants=Ecriture_comptable::trouve_somme_debit_par_date_and_1_attribut($nav_societe->id_societe,$Bilan_actif->mb,$date_db,$date_fin);
				$Montants_anterieur=Ecriture_comptable::trouve_somme_debit_par_date_and_1_attribut_anterieur($nav_societe->id_societe,$Bilan_actif->mb,$date_db); }

				if ($cpt<=15 ) {$TOTAL_ACTIF_NON_COURANT_mb = $TOTAL_ACTIF_NON_COURANT_mb + $Montants->somme_debit; 
									$TOTAL_ACTIF_NON_COURANT_mb_anterieur = $TOTAL_ACTIF_NON_COURANT_mb_anterieur+$Montants_anterieur->somme_debit;	} 

				if ($cpt >16) {$TOTAL_ACTIF_COURANT_mb = $TOTAL_ACTIF_COURANT_mb + $Montants->somme_debit;
									$TOTAL_ACTIF_COURANT_mb_anterieur = $TOTAL_ACTIF_COURANT_mb_anterieur + $Montants_anterieur->somme_debit;  }

				$TOTAL_GENERAL_ACTIF_mb =$TOTAL_ACTIF_NON_COURANT_mb+$TOTAL_ACTIF_COURANT_mb ; 
				$TOTAL_GENERAL_ACTIF_mb_anterieur =$TOTAL_ACTIF_NON_COURANT_mb_anterieur + $TOTAL_ACTIF_COURANT_mb_anterieur ; 

////////////////////////////////////////////  Amortissements ////////////////////////////////////
				if (!empty($Bilan_actif->app) && !empty($Bilan_actif->app_sauf)) {
				$Amortissements=Ecriture_comptable::trouve_somme_debit_par_date_and_2_attribut($nav_societe->id_societe,$Bilan_actif->app,$Bilan_actif->app_sauf,$date_db,$date_fin);
				$Amortissements_anterieur=Ecriture_comptable::trouve_somme_debit_par_date_and_2_attribut_anterieur($nav_societe->id_societe,$Bilan_actif->app,$Bilan_actif->app_sauf,$date_db);

										} else if(!empty($Bilan_actif->app)){

				$Amortissements=Ecriture_comptable::trouve_somme_debit_par_date_and_1_attribut($nav_societe->id_societe,$Bilan_actif->app,$date_db,$date_fin); 
				$Amortissements_anterieur=Ecriture_comptable::trouve_somme_debit_par_date_and_1_attribut_anterieur($nav_societe->id_societe,$Bilan_actif->app,$date_db); }

							if ($cpt<=15 ) {$TOTAL_ACTIF_NON_COURANT_app = $TOTAL_ACTIF_NON_COURANT_app + $Amortissements->somme_debit;
											    $TOTAL_ACTIF_NON_COURANT_app_anterieur = $TOTAL_ACTIF_NON_COURANT_app_anterieur + $Amortissements_anterieur->somme_debit; } 

							if ($cpt >16) {$TOTAL_ACTIF_COURANT_app = $TOTAL_ACTIF_COURANT_app + $Amortissements->somme_debit;
												$TOTAL_ACTIF_COURANT_app_anterieur = $TOTAL_ACTIF_COURANT_app_anterieur + $Amortissements_anterieur->somme_debit; }

							$TOTAL_GENERAL_ACTIF_app =$TOTAL_ACTIF_NON_COURANT_app + $TOTAL_ACTIF_COURANT_app ; 
							$TOTAL_GENERAL_ACTIF_app_anterieur =$TOTAL_ACTIF_NON_COURANT_app_anterieur + $TOTAL_ACTIF_COURANT_app_anterieur ; 

///////////////////////////////////////////// Net N-1//////////////////////////////////////////////////


										?>
								<tr  <?php if ($Bilan_actif->id == 16 || $Bilan_actif->id == 27 || $Bilan_actif->id == 28) { echo'class="badr"';} ?> >
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?> ><?php if (isset($Bilan_actif->actif)) {echo $Bilan_actif->actif; } ?>
										
									</td>
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?> style="text-align:right; padding-right: 5px;" ><?php 
											if ($Bilan_actif->id == 16) { echo number_format($TOTAL_ACTIF_NON_COURANT_mb,2,',',' '); }
											elseif ($Bilan_actif->id == 27) { echo number_format($TOTAL_ACTIF_COURANT_mb,2,',',' '); }
											elseif ($Bilan_actif->id == 28) { echo number_format($TOTAL_GENERAL_ACTIF_mb,2,',',' '); }
											else if(isset($Montants->somme_debit)) {echo number_format($Montants->somme_debit,2,',',' ');} ?>
												
									</td>

									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;" ><?php 

											if ($Bilan_actif->id == 16) { echo number_format($TOTAL_ACTIF_NON_COURANT_app,2,',',' '); }
											elseif ($Bilan_actif->id == 27) { echo number_format($TOTAL_ACTIF_COURANT_app,2,',',' '); }
											elseif ($Bilan_actif->id == 28) { echo number_format($TOTAL_GENERAL_ACTIF_app,2,',',' '); }
											else if(isset($Amortissements->somme_debit)) {echo number_format($Amortissements->somme_debit,2,',',' ');} ?>
											
									</td>
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;"  >  <?php 
											if ($Bilan_actif->id == 16) { echo number_format($TOTAL_ACTIF_NON_COURANT_mb-$TOTAL_ACTIF_NON_COURANT_app,2,',',' '); }
											elseif ($Bilan_actif->id == 27) { echo number_format($TOTAL_ACTIF_COURANT_mb-$TOTAL_ACTIF_COURANT_app,2,',',' '); }
											elseif ($Bilan_actif->id == 28) { echo number_format($TOTAL_GENERAL_ACTIF_mb-$TOTAL_GENERAL_ACTIF_app,2,',',' '); }
											else if(isset($Amortissements->somme_debit) or isset($Montants->somme_debit)) {echo number_format($Montants->somme_debit - $Amortissements->somme_debit,2,',',' ');} ?> 
									</td>
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;"  >
										 <?php 
											if ($Bilan_actif->id == 16) { echo number_format($TOTAL_ACTIF_NON_COURANT_mb_anterieur - $TOTAL_ACTIF_NON_COURANT_app_anterieur ,2,',',' '); }
											elseif ($Bilan_actif->id == 27) { echo number_format($TOTAL_ACTIF_COURANT_mb_anterieur - $TOTAL_ACTIF_COURANT_app_anterieur,2,',',' '); }
											elseif ($Bilan_actif->id == 28) { echo number_format($TOTAL_GENERAL_ACTIF_mb_anterieur - $TOTAL_GENERAL_ACTIF_app_anterieur,2,',',' '); }
											else if(isset($Amortissements_anterieur->somme_debit) or isset($Montants_anterieur->somme_debit)) {echo number_format($Montants_anterieur->somme_debit - $Amortissements_anterieur->somme_debit,2,',',' ');} ?> 
									</td>
								</tr>	
								<?php if ($Amortissements->somme_debit) {unset($Amortissements->somme_debit);}
										if ($Montants->somme_debit) {unset($Montants->somme_debit);}

										if ($Amortissements_anterieur->somme_debit) {unset($Amortissements_anterieur->somme_debit);}
										if ($Montants_anterieur->somme_debit) {unset($Montants_anterieur->somme_debit);}  }  ?>
							</table>
							

					</div>
				</div>


			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice cols le</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
									<p style="text-align: center ; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										BILAN (ACTIF)
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
							</div>
							<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
								</div>
								<div class="col-xs-4" style="text-align:right;font-weight: 700;">Série G, n°2 (2011)</div>
							</div>
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
								<table border="1" width="100%"  bordercolor="#FF0000">
								<tr class="miloud">
									<td rowspan="2"  width="40%" align="center"><b>ACTIF</b></td>
									<td colspan="3" align="center"><b>N</b></td>
									<td align="center"><b>N-1</b></td>
								</tr>
								<tr class="miloud">
									<td align="center"  width="15%"><b>Montants<BR>
									Bruts</b></td>
									<td align="center" width="15%"><b>Amortissements
									,<br> provisions et <br>
									pertes de <br>
									valeurs</b></td>
									<td align="center" width="15%"><b>Net</b></td>
									<td align="center" width="15%"><b>Net</b></td>
								</tr>
								<?php $Bilan_actifs= Bilan_actif::trouve_tous(); $cpt=0;
								$TOTAL_ACTIF_NON_COURANT_mb=0;$TOTAL_ACTIF_COURANT_mb=0;$TOTAL_GENERAL_ACTIF_mb=0;
								$TOTAL_ACTIF_NON_COURANT_app=0;$TOTAL_ACTIF_COURANT_app=0;$TOTAL_GENERAL_ACTIF_app=0;
								////////////////////////////////// anterieur///////////////////////////////////////////////
								$TOTAL_ACTIF_NON_COURANT_app_anterieur=0;$TOTAL_ACTIF_COURANT_app_anterieur=0;$TOTAL_GENERAL_ACTIF_app_anterieur=0;
								$TOTAL_ACTIF_NON_COURANT_mb_anterieur=0;$TOTAL_ACTIF_COURANT_mb_anterieur=0;$TOTAL_GENERAL_ACTIF_mb_anterieur=0;
									foreach ($Bilan_actifs as $Bilan_actif) { $cpt++;

 ////////////////////// Montants ///////////////////////////////////////
 			if (!empty($Bilan_actif->mb) && !empty($Bilan_actif->mb_sauf)) {

				$Montants=Ecriture_comptable::trouve_somme_debit_par_date_and_2_attribut($nav_societe->id_societe,$Bilan_actif->mb,$Bilan_actif->mb_sauf,$date_db,$date_fin);
				$Montants_anterieur=Ecriture_comptable::trouve_somme_debit_par_date_and_2_attribut_anterieur($nav_societe->id_societe,$Bilan_actif->mb,$Bilan_actif->mb_sauf,$date_db);
									
									} else if(!empty($Bilan_actif->mb)){

				$Montants=Ecriture_comptable::trouve_somme_debit_par_date_and_1_attribut($nav_societe->id_societe,$Bilan_actif->mb,$date_db,$date_fin);
				$Montants_anterieur=Ecriture_comptable::trouve_somme_debit_par_date_and_1_attribut_anterieur($nav_societe->id_societe,$Bilan_actif->mb,$date_db); }

				if ($cpt<=15 ) {$TOTAL_ACTIF_NON_COURANT_mb = $TOTAL_ACTIF_NON_COURANT_mb + $Montants->somme_debit; 
									$TOTAL_ACTIF_NON_COURANT_mb_anterieur = $TOTAL_ACTIF_NON_COURANT_mb_anterieur+$Montants_anterieur->somme_debit;	} 

				if ($cpt >16) {$TOTAL_ACTIF_COURANT_mb = $TOTAL_ACTIF_COURANT_mb + $Montants->somme_debit;
									$TOTAL_ACTIF_COURANT_mb_anterieur = $TOTAL_ACTIF_COURANT_mb_anterieur + $Montants_anterieur->somme_debit;  }

				$TOTAL_GENERAL_ACTIF_mb =$TOTAL_ACTIF_NON_COURANT_mb+$TOTAL_ACTIF_COURANT_mb ; 
				$TOTAL_GENERAL_ACTIF_mb_anterieur =$TOTAL_ACTIF_NON_COURANT_mb_anterieur + $TOTAL_ACTIF_COURANT_mb_anterieur ; 

////////////////////////////////////////////  Amortissements ////////////////////////////////////
				if (!empty($Bilan_actif->app) && !empty($Bilan_actif->app_sauf)) {
				$Amortissements=Ecriture_comptable::trouve_somme_debit_par_date_and_2_attribut($nav_societe->id_societe,$Bilan_actif->app,$Bilan_actif->app_sauf,$date_db,$date_fin);
				$Amortissements_anterieur=Ecriture_comptable::trouve_somme_debit_par_date_and_2_attribut_anterieur($nav_societe->id_societe,$Bilan_actif->app,$Bilan_actif->app_sauf,$date_db);

										} else if(!empty($Bilan_actif->app)){

				$Amortissements=Ecriture_comptable::trouve_somme_debit_par_date_and_1_attribut($nav_societe->id_societe,$Bilan_actif->app,$date_db,$date_fin); 
				$Amortissements_anterieur=Ecriture_comptable::trouve_somme_debit_par_date_and_1_attribut_anterieur($nav_societe->id_societe,$Bilan_actif->app,$date_db); }

							if ($cpt<=15 ) {$TOTAL_ACTIF_NON_COURANT_app = $TOTAL_ACTIF_NON_COURANT_app + $Amortissements->somme_debit;
											    $TOTAL_ACTIF_NON_COURANT_app_anterieur = $TOTAL_ACTIF_NON_COURANT_app_anterieur + $Amortissements_anterieur->somme_debit; } 

							if ($cpt >16) {$TOTAL_ACTIF_COURANT_app = $TOTAL_ACTIF_COURANT_app + $Amortissements->somme_debit;
												$TOTAL_ACTIF_COURANT_app_anterieur = $TOTAL_ACTIF_COURANT_app_anterieur + $Amortissements_anterieur->somme_debit; }

							$TOTAL_GENERAL_ACTIF_app =$TOTAL_ACTIF_NON_COURANT_app + $TOTAL_ACTIF_COURANT_app ; 
							$TOTAL_GENERAL_ACTIF_app_anterieur =$TOTAL_ACTIF_NON_COURANT_app_anterieur + $TOTAL_ACTIF_COURANT_app_anterieur ; 


										?>
								<tr  <?php if ($Bilan_actif->id == 16 || $Bilan_actif->id == 27 || $Bilan_actif->id == 28) { echo'class="miloud"';} ?> >
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?> ><?php if (isset($Bilan_actif->actif)) {echo $Bilan_actif->actif; } ?>
										
									</td>
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?> style="text-align:right; padding-right: 5px;" ><?php 
											if ($Bilan_actif->id == 16) { echo number_format($TOTAL_ACTIF_NON_COURANT_mb,2,',',' '); }
											elseif ($Bilan_actif->id == 27) { echo number_format($TOTAL_ACTIF_COURANT_mb,2,',',' '); }
											elseif ($Bilan_actif->id == 28) { echo number_format($TOTAL_GENERAL_ACTIF_mb,2,',',' '); }
											else if(isset($Montants->somme_debit)) {echo number_format($Montants->somme_debit,2,',',' ');} ?>	
									</td>
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;" ><?php 

											if ($Bilan_actif->id == 16) { echo number_format($TOTAL_ACTIF_NON_COURANT_app,2,',',' '); }
											elseif ($Bilan_actif->id == 27) { echo number_format($TOTAL_ACTIF_COURANT_app,2,',',' '); }
											elseif ($Bilan_actif->id == 28) { echo number_format($TOTAL_GENERAL_ACTIF_app,2,',',' '); }
											else if(isset($Amortissements->somme_debit)) {echo number_format($Amortissements->somme_debit,2,',',' ');} ?>
											
									</td>
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;"  >  <?php 
											if ($Bilan_actif->id == 16) { echo number_format($TOTAL_ACTIF_NON_COURANT_mb-$TOTAL_ACTIF_NON_COURANT_app,2,',',' '); }
											elseif ($Bilan_actif->id == 27) { echo number_format($TOTAL_ACTIF_COURANT_mb-$TOTAL_ACTIF_COURANT_app,2,',',' '); }
											elseif ($Bilan_actif->id == 28) { echo number_format($TOTAL_GENERAL_ACTIF_mb-$TOTAL_GENERAL_ACTIF_app,2,',',' '); }
											else if(isset($Amortissements->somme_debit) or isset($Montants->somme_debit)) {echo number_format($Montants->somme_debit - $Amortissements->somme_debit,2,',',' ');} ?> 
									</td>
									<td <?php if ($Bilan_actif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;"  >
										 <?php 
											if ($Bilan_actif->id == 16) { echo number_format($TOTAL_ACTIF_NON_COURANT_mb_anterieur - $TOTAL_ACTIF_NON_COURANT_app_anterieur ,2,',',' '); }
											elseif ($Bilan_actif->id == 27) { echo number_format($TOTAL_ACTIF_COURANT_mb_anterieur - $TOTAL_ACTIF_COURANT_app_anterieur,2,',',' '); }
											elseif ($Bilan_actif->id == 28) { echo number_format($TOTAL_GENERAL_ACTIF_mb_anterieur - $TOTAL_GENERAL_ACTIF_app_anterieur,2,',',' '); }
											else if(isset($Amortissements_anterieur->somme_debit) or isset($Montants_anterieur->somme_debit)) {echo number_format($Montants_anterieur->somme_debit - $Amortissements_anterieur->somme_debit,2,',',' ');} ?> 
									</td>
								</tr>	
								<?php if ($Amortissements->somme_debit) {unset($Amortissements->somme_debit);}
										if ($Montants->somme_debit) {unset($Montants->somme_debit);}

										if ($Amortissements_anterieur->somme_debit) {unset($Amortissements_anterieur->somme_debit);}
										if ($Montants_anterieur->somme_debit) {unset($Montants_anterieur->somme_debit);}  }  ?>
							</table>
							

					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br/>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>
			</div>

				</div>
			</div>
		</page>
		<!-- FIN Etat actif-->
		<!-- DEBUT ETAT PASSIF-->
				<?PHP
						 }else if($action =="etat_Bilan_passif") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice cols le</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
									<p style="text-align: center ; border: solid 2px;box-shadow: 5px 5px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										BILAN (PASSIF)
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
							</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  >

								<tr class="badr" style=" height: 45px;">
									<td  align="center" width="60%"><b>PASSIF</b></td>
									<td width="20%" align="center"><b>N</b></td>
									<td width="20%" align="center"><b>N-1</b></td>
								</tr>
								
								<?php  $Bilan_passifs= Bilan_passif::trouve_tous(); $cpt=0;
								$TOTAL_I=0;$TOTAL_II=0;$TOTAL_III=0; $TOTAL_GENERAL=0;
								$TOTAL_I_anterieur=0;$TOTAL_II_anterieur=0;$TOTAL_III_anterieur=0; $TOTAL_GENERAL_anterieur=0;
								foreach ($Bilan_passifs as $Bilan_passif) { $cpt++;

 ////////////////////// PASSIF N ///////////////////////////////////////
 			if (!empty($Bilan_passif->mn) && !empty($Bilan_passif->mn_sauf)) {

				$Montants=Ecriture_comptable::trouve_somme_credit_par_date_and_2_attribut($nav_societe->id_societe,$Bilan_passif->mn,$Bilan_passif->mn_sauf,$date_db,$date_fin);
				$Montants_anterieur=Ecriture_comptable::trouve_somme_credit_par_date_and_2_attribut_anterieur($nav_societe->id_societe,$Bilan_passif->mn,$Bilan_passif->mn_sauf,$date_db);
									
									} else if(!empty($Bilan_passif->mn)){

				$Montants=Ecriture_comptable::trouve_somme_credit_par_date_and_1_attribut($nav_societe->id_societe,$Bilan_passif->mn,$date_db,$date_fin);
				$Montants_anterieur=Ecriture_comptable::trouve_somme_credit_par_date_and_1_attribut_anterieur($nav_societe->id_societe,$Bilan_passif->mn,$date_db); }	

								if ($cpt<=10 ) {$TOTAL_I = $TOTAL_I + $Montants->somme_credit;
											    $TOTAL_I_anterieur = $TOTAL_I_anterieur + $Montants_anterieur->somme_credit; } 

							if ($cpt >11 &&  $cpt <= 16) {$TOTAL_II = $TOTAL_II + $Montants->somme_credit;
												$TOTAL_II_anterieur = $TOTAL_II_anterieur + $Montants_anterieur->somme_credit; }	

							if ($cpt >17) {$TOTAL_III = $TOTAL_III + $Montants->somme_credit;
												$TOTAL_III_anterieur = $TOTAL_III_anterieur + $Montants_anterieur->somme_credit; }

							$TOTAL_GENERAL =$TOTAL_I+ $TOTAL_II+$TOTAL_III; 
							$TOTAL_GENERAL_anterieur =$TOTAL_I_anterieur+ $TOTAL_II_anterieur + $TOTAL_III_anterieur; 
								 ?>
								<tr <?php if ($Bilan_passif->id == 12 || $Bilan_passif->id == 18 || $Bilan_passif->id == 24 || $Bilan_passif->id == 25) { echo'class="badr"';} ?>>
									<td <?php if ($Bilan_passif->id == 12 || $Bilan_passif->id == 18 || $Bilan_passif->id == 24 || $Bilan_passif->id == 25) { echo'style="padding-left:120px;"';} ?> <?php if ($Bilan_passif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?> style=" padding-right: 5px;" > 
										<?php if (isset($Bilan_passif->actif)) {echo $Bilan_passif->actif; } ?>
									</td>
									<td <?php if ($Bilan_passif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;" ><?php 
											if ($Bilan_passif->id == 12) { echo number_format($TOTAL_I,2,',',' '); }
											elseif ($Bilan_passif->id == 18) { echo number_format($TOTAL_II,2,',',' '); }
											elseif ($Bilan_passif->id == 24) { echo number_format($TOTAL_III,2,',',' '); }
											elseif ($Bilan_passif->id == 25) { echo number_format($TOTAL_GENERAL,2,',',' '); }
											else if(isset($Montants->somme_credit)) {echo number_format($Montants->somme_credit,2,',',' ');}?>
									</td>
									<td <?php if ($Bilan_passif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;" >
									<?php 
											if ($Bilan_passif->id == 12) { echo number_format($TOTAL_I_anterieur,2,',',' '); }
											elseif ($Bilan_passif->id == 18) { echo number_format($TOTAL_II_anterieur,2,',',' '); }
											elseif ($Bilan_passif->id == 24) { echo number_format($TOTAL_III_anterieur,2,',',' '); }
											elseif ($Bilan_passif->id == 25) { echo number_format($TOTAL_GENERAL_anterieur,2,',',' '); }
											else if(isset($Montants_anterieur->somme_credit)) {echo number_format($Montants_anterieur->somme_credit,2,',',' ');}?>
									</td>
								</tr>
								<?php if ($Montants->somme_credit) {unset($Montants->somme_credit);}
								if ($Montants_anterieur->somme_credit) {unset($Montants_anterieur->somme_credit);} } ?>
								
								
							</table>
							

					</div>
				</div>
				<div class="row" style="padding-top: 50px;">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-10">
						(1) à utiliser uniquement pour la présentation d’états financiers consolidés
					</div>

					
				</div>

			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice cols le</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
									<p style="text-align: center ; border: solid 2px;box-shadow: 5px 5px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										BILAN (PASSIF)
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
							</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  bordercolor="#FF0000">
								
								<tr class="miloud" style=" height: 45px;">
									<td  align="center" width="60%"><b>PASSIF</b></td>
									<td width="20%" align="center"><b>N</b></td>
									<td width="20%" align="center"><b>N-1</b></td>
								</tr>
								<?php  $Bilan_passifs= Bilan_passif::trouve_tous(); $cpt=0;
								$TOTAL_I=0;$TOTAL_II=0;$TOTAL_III=0; $TOTAL_GENERAL=0;
								$TOTAL_I_anterieur=0;$TOTAL_II_anterieur=0;$TOTAL_III_anterieur=0; $TOTAL_GENERAL_anterieur=0;
								foreach ($Bilan_passifs as $Bilan_passif) { $cpt++;

 ////////////////////// PASSIF N ///////////////////////////////////////
 			if (!empty($Bilan_passif->mn) && !empty($Bilan_passif->mn_sauf)) {

				$Montants=Ecriture_comptable::trouve_somme_credit_par_date_and_2_attribut($nav_societe->id_societe,$Bilan_passif->mn,$Bilan_passif->mn_sauf,$date_db,$date_fin);
				$Montants_anterieur=Ecriture_comptable::trouve_somme_credit_par_date_and_2_attribut_anterieur($nav_societe->id_societe,$Bilan_passif->mn,$Bilan_passif->mn_sauf,$date_db);
									
									} else if(!empty($Bilan_passif->mn)){

				$Montants=Ecriture_comptable::trouve_somme_credit_par_date_and_1_attribut($nav_societe->id_societe,$Bilan_passif->mn,$date_db,$date_fin);
				$Montants_anterieur=Ecriture_comptable::trouve_somme_credit_par_date_and_1_attribut_anterieur($nav_societe->id_societe,$Bilan_passif->mn,$date_db); }	

								if ($cpt<=10 ) {$TOTAL_I = $TOTAL_I + $Montants->somme_credit;
											    $TOTAL_I_anterieur = $TOTAL_I_anterieur + $Montants_anterieur->somme_credit; } 

							if ($cpt >11 &&  $cpt <= 16) {$TOTAL_II = $TOTAL_II + $Montants->somme_credit;
												$TOTAL_II_anterieur = $TOTAL_II_anterieur + $Montants_anterieur->somme_credit; }	

							if ($cpt >17) {$TOTAL_III = $TOTAL_III + $Montants->somme_credit;
												$TOTAL_III_anterieur = $TOTAL_III_anterieur + $Montants_anterieur->somme_credit; }

							$TOTAL_GENERAL =$TOTAL_I+ $TOTAL_II+$TOTAL_III; 
							$TOTAL_GENERAL_anterieur =$TOTAL_I_anterieur+ $TOTAL_II_anterieur + $TOTAL_III_anterieur; 
								 ?>
								<tr <?php if ($Bilan_passif->id == 12 || $Bilan_passif->id == 18 || $Bilan_passif->id == 24 || $Bilan_passif->id == 25) { echo'class="miloud"';} ?>>
									<td <?php if ($Bilan_passif->id == 12 || $Bilan_passif->id == 18 || $Bilan_passif->id == 24 || $Bilan_passif->id == 25) { echo'style="padding-left:120px;"';} ?> <?php if ($Bilan_passif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?> style=" padding-right: 5px;" > 
										<?php if (isset($Bilan_passif->actif)) {echo $Bilan_passif->actif; } ?>
									</td>
									<td <?php if ($Bilan_passif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;" ><?php 
											if ($Bilan_passif->id == 12) { echo number_format($TOTAL_I,2,',',' '); }
											elseif ($Bilan_passif->id == 18) { echo number_format($TOTAL_II,2,',',' '); }
											elseif ($Bilan_passif->id == 24) { echo number_format($TOTAL_III,2,',',' '); }
											elseif ($Bilan_passif->id == 25) { echo number_format($TOTAL_GENERAL,2,',',' '); }
											else if(isset($Montants->somme_credit)) {echo number_format($Montants->somme_credit,2,',',' ');}?>
									</td>
									<td <?php if ($Bilan_passif->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?>  style="text-align:right; padding-right: 5px;" >
									<?php 
											if ($Bilan_passif->id == 12) { echo number_format($TOTAL_I_anterieur,2,',',' '); }
											elseif ($Bilan_passif->id == 18) { echo number_format($TOTAL_II_anterieur,2,',',' '); }
											elseif ($Bilan_passif->id == 24) { echo number_format($TOTAL_III_anterieur,2,',',' '); }
											elseif ($Bilan_passif->id == 25) { echo number_format($TOTAL_GENERAL_anterieur,2,',',' '); }
											else if(isset($Montants_anterieur->somme_credit)) {echo number_format($Montants_anterieur->somme_credit,2,',',' ');}?>
									</td>
								</tr>
								<?php if ($Montants->somme_credit) {unset($Montants->somme_credit);}
								if ($Montants_anterieur->somme_credit) {unset($Montants_anterieur->somme_credit);} } ?>
								
								
							</table>
							

					</div>
				</div>
				<div class="row" style="padding-top: 50px;">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-10">
						(1) à utiliser uniquement pour la présentation d’états financiers consolidés
					</div>

					
				</div>
				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br/>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>
			</div>

				</div>
			</div>
			</div>
		</page>
		<!-- END ETAT PASSIF-->
		<!-- DEBUT TCR-->
				<?PHP
						 }else if($action =="etat_Bilan_tcr") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
									<p style="text-align: center ; border: solid 2px;box-shadow: 5px 5px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										COMPTE DE RESULTAT
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
							</div>
							
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  >
								<tr>
									<td rowspan="2" width="52%" align="center" colspan="2"><b>Rubriques</b></td>
									<td colspan="2" align="center"><b>N</b></td>
									<td align="center" colspan="2"><b>N-1</b></td>
								</tr>
								<tr>
									<td align="center"><b>DEBIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>CREDIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>DEBIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>CREDIT<br>
									(en Dinars)</b></td>
								</tr>
								<?php   $Tcrs= Tcr::trouve_33(); $cpt=0;
								$Chiffre_affaires_Debit =0; $Chiffre_affaires_Credit=0;
								$Debit_Valeur_ajoute =0; $Credit_Valeur_ajoute=0;
								$TOTAL_I_Debit=0;$TOTAL_I_Credit=0;
								$TOTAL_II_Debit=0;$TOTAL_II_Credit=0;
								$Excedent_brut_Debit=0; $Excedent_brut_Credit=0;
								//////////////////// N-1 ////////////////////////
								$Chiffre_affaires_Debit_anterieur =0; $Chiffre_affaires_Credit_anterieur=0;
								$Debit_Valeur_ajoute_anterieur =0; $Credit_Valeur_ajoute_anterieur=0;
								$TOTAL_I_Debit_anterieur=0;$TOTAL_I_Credit_anterieur=0;
								$TOTAL_II_Debit_anterieur=0;$TOTAL_II_Credit_anterieur=0;
								$Excedent_brut_Debit_anterieur=0; $Excedent_brut_Credit_anterieur=0;

								foreach ($Tcrs as $Tcr) { $cpt++;
							if (!empty($Tcr->debit_credit)) {
							$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tcr->debit_credit,$date_db,$date_fin);
							$Debit_credit_anterieur=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement_anterieur($nav_societe->id_societe,$Tcr->debit_credit,$date_db);
							}
							if ($cpt < 7 ) {
								////////////// Chiffre_affaires ////////////////
								$Chiffre_affaires_Credit = $Chiffre_affaires_Credit + $Debit_credit->somme_credit;
								$Chiffre_affaires_Debit = $Chiffre_affaires_Debit + $Debit_credit->somme_debit;
								$Chiffre_affaires_Credit_anterieur = $Chiffre_affaires_Credit_anterieur + $Debit_credit_anterieur->somme_credit;
								$Chiffre_affaires_Debit_anterieur = $Chiffre_affaires_Debit_anterieur + $Debit_credit_anterieur->somme_debit; } 
								//////////// TOTAL_I ///////////////////////
							if ($cpt < 11) {
								$TOTAL_I_Debit = $TOTAL_I_Debit + $Debit_credit->somme_debit;
								$TOTAL_I_Credit = $TOTAL_I_Credit + $Debit_credit->somme_credit;
								$TOTAL_I_Debit_anterieur = $TOTAL_I_Debit_anterieur + $Debit_credit_anterieur->somme_debit;
								$TOTAL_I_Credit_anterieur = $TOTAL_I_Credit_anterieur + $Debit_credit_anterieur->somme_credit; }
								//////////////////////////// TOTAL_II /////////////	
							if ($cpt >11 &&  $cpt < 29) {
								$TOTAL_II_Debit = $TOTAL_II_Debit + $Debit_credit->somme_debit;
								$TOTAL_II_Credit = $TOTAL_II_Credit + $Debit_credit->somme_credit;
								$TOTAL_II_Debit_anterieur = $TOTAL_II_Debit_anterieur + $Debit_credit_anterieur->somme_debit;
								$TOTAL_II_Credit_anterieur = $TOTAL_II_Credit_anterieur + $Debit_credit_anterieur->somme_credit; }
								///////////////////// Excedent_brut ///////////////

							if ($cpt < 33) {
								$Excedent_brut_Credit = $Excedent_brut_Credit + $Debit_credit->somme_credit;
								$Excedent_brut_Debit = $Excedent_brut_Debit + $Debit_credit->somme_debit;
								$Excedent_brut_Credit_anterieur = $Excedent_brut_Credit_anterieur + $Debit_credit_anterieur->somme_credit;
								$Excedent_brut_Debit_anterieur = $Excedent_brut_Debit_anterieur + $Debit_credit_anterieur->somme_debit; }
								//////////////////// Valeur_ajoute //////////////////////////
								if ($TOTAL_I_Credit > $TOTAL_II_Debit) {
									$Credit_Valeur_ajoute = $TOTAL_I_Credit - $TOTAL_II_Debit; 
								}
								if ( $TOTAL_II_Debit > $TOTAL_I_Credit ) {
									$Debit_Valeur_ajoute =  $TOTAL_II_Debit - $TOTAL_I_Credit ; 
								}
								if ($TOTAL_I_Credit_anterieur > $TOTAL_II_Debit_anterieur) {
									$Credit_Valeur_ajoute_anterieur = $TOTAL_I_Credit_anterieur - $TOTAL_II_Debit_anterieur; 
								}
								if ( $TOTAL_II_Debit_anterieur > $TOTAL_I_Credit_anterieur ) {
									$Debit_Valeur_ajoute_anterieur =  $TOTAL_II_Debit_anterieur - $TOTAL_I_Credit_anterieur ; 
								}

								 ?>
								 <?php if ($cpt == 2 || $cpt == 19) { ?>
								<tr>
									<td <?php if ($cpt == 2) {echo 'rowspan="3"'; }else{ echo 'rowspan="8"'; } ?>  <?php if ($Tcr->is_bold == 1 ) { echo'style="padding-left:5px;"';} ?> <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" style="padding-left:5px;"';} ?>  > 
										<?php if (isset($Tcr->rubriques)) {echo $Tcr->rubriques; } ?>
									</td>
									<td  class="bilan-td " style="padding-left: 5px;"><?php if (isset($Tcr->father_rubriques)) {echo $Tcr->father_rubriques; } ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit->debit)) { echo number_format($Debit_credit->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit->credit)) { echo number_format($Debit_credit->credit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit_anterieur->debit)) { echo number_format($Debit_credit_anterieur->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit_anterieur->credit)) { echo number_format($Debit_credit_anterieur->credit,'2',',',' ');} ?></td>
								</tr>
							<?php } else if($cpt == 3 || $cpt == 4 || $cpt == 20 || $cpt == 21 || $cpt == 22 || $cpt == 23 || $cpt == 24 || $cpt == 25 || $cpt == 26) { ?>
								<tr>
									<td  <?php if ($Tcr->is_bold == 1 ) { echo'style="padding-left:5px;"';} ?> <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" style="padding-left:5px;"';} ?> style=" padding-right: 5px;" > 
										<?php if (isset($Tcr->rubriques)) {echo $Tcr->rubriques; } ?>
									</td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit->debit)) { echo number_format($Debit_credit->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php  if (isset($Debit_credit->credit)) { echo number_format($Debit_credit->credit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit_anterieur->debit)) { echo number_format($Debit_credit_anterieur->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit_anterieur->credit)) { echo number_format($Debit_credit_anterieur->credit,'2',',',' ');} ?></td>
								</tr>
							<?php 	} else  { ?>
							<tr <?php if ($Tcr->id == 7 || $Tcr->id == 11 || $Tcr->id == 29 || $Tcr->id == 30 || $Tcr->id == 33 ) { echo'class="badr"';} ?> >
									<td colspan="2" <?php if ($Tcr->is_bold == 1 ) { echo'style="padding-left:5px;"';} ?> <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" style="padding-left:5px;"';} ?> style=" padding-right: 5px;" > 
										<?php if (isset($Tcr->rubriques)) {echo $Tcr->rubriques; } ?>
									</td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;"  ><?php
									 if ($Tcr->id == 7 && $Chiffre_affaires_Debit > 0) {  echo number_format($Chiffre_affaires_Debit,2,',',' '); }
									 else if ($Tcr->id == 11 && $TOTAL_I_Debit>0) { echo number_format($TOTAL_I_Debit,2,',',' '); }
									 else if ($Tcr->id == 29 && $TOTAL_II_Debit>0) { echo number_format($TOTAL_II_Debit,2,',',' '); }
									 else if ($Tcr->id == 30 && $Debit_Valeur_ajoute > 0 ) { echo number_format($Debit_Valeur_ajoute,2,',',' '); }
									 else if ($Tcr->id == 33  && $Excedent_brut_Debit > 0 ) { echo number_format($Excedent_brut_Debit,2,',',' '); }
									 else if (isset($Debit_credit->debit) && $Debit_credit->debit >0) { echo number_format($Debit_credit->debit,'2',',',' ');} ?>
									 </td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;" >
							<?php if ($Tcr->id == 7 && $Chiffre_affaires_Credit > 0) {  echo number_format($Chiffre_affaires_Credit,2,',',' '); }
									else if ($Tcr->id == 11 && $TOTAL_I_Credit>0) { echo number_format($TOTAL_I_Credit,2,',',' ');  }
									else if ($Tcr->id == 29 && $TOTAL_II_Credit>0) { echo number_format($TOTAL_II_Credit,2,',',' '); }
									else if ($Tcr->id == 30 && $Credit_Valeur_ajoute > 0 ) { echo number_format($Credit_Valeur_ajoute,2,',',' '); }
									else if ($Tcr->id == 33  && $Excedent_brut_Credit > 0 ) { echo number_format($Excedent_brut_Credit,2,',',' '); } 
									else if (isset($Debit_credit->credit) && $Debit_credit->credit >0) { echo number_format($Debit_credit->credit,'2',',',' ');}
									 ?>
									</td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;"  ><?php
									 if ($Tcr->id == 7 && $Chiffre_affaires_Debit_anterieur > 0) {  echo number_format($Chiffre_affaires_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 11 && $TOTAL_I_Debit_anterieur>0) { echo number_format($TOTAL_I_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 29 && $TOTAL_II_Debit_anterieur>0) { echo number_format($TOTAL_II_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 30 && $Debit_Valeur_ajoute_anterieur > 0 ) { echo number_format($Debit_Valeur_ajoute_anterieur,2,',',' '); }
									 else if ($Tcr->id == 33  && $Excedent_brut_Debit_anterieur > 0 ) { echo number_format($Excedent_brut_Debit_anterieur,2,',',' '); }
									 else if (isset($Debit_credit_anterieur->debit) && $Debit_credit_anterieur->debit >0) { echo number_format($Debit_credit_anterieur->debit,'2',',',' ');} ?>
									 </td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;" >
							<?php if ($Tcr->id == 7 && $Chiffre_affaires_Credit_anterieur > 0) {  echo number_format($Chiffre_affaires_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 11 && $TOTAL_I_Credit_anterieur>0) { echo number_format($TOTAL_I_Credit_anterieur,2,',',' ');  }
									else if ($Tcr->id == 29 && $TOTAL_II_Credit_anterieur>0) { echo number_format($TOTAL_II_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 30 && $Credit_Valeur_ajoute_anterieur > 0 ) { echo number_format($Credit_Valeur_ajoute_anterieur,2,',',' '); }
									else if ($Tcr->id == 33  && $Excedent_brut_Credit_anterieur > 0 ) { echo number_format($Excedent_brut_Credit_anterieur,2,',',' '); } 
									else if (isset($Debit_credit_anterieur->credit) && $Debit_credit_anterieur->credit >0) { echo number_format($Debit_credit_anterieur->credit,'2',',',' ');}
									 ?>
									</td>
								</tr>
					<?php unset($Debit_credit); unset($Debit_credit_anterieur);	}} ?>
								

							</table>
							

					</div>
				</div>


			</div>

				</div>
			</div>
		</div>
		</page>
		<page size="A4" style="padding-top: 30px; height: 290mm;" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; " >
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
									<p style="text-align: center ; border: solid 2px;box-shadow: 5px 5px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										COMPTE DE RESULTAT
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
							</div>
							
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  >
								<tr>
									<td rowspan="2" align="center" colspan="2"><b>Rubriques</b></td>
									<td colspan="2" align="center"><b>N</b></td>
									<td align="center" colspan="2"><b>N-1</b></td>
								</tr>
								<tr>
									<td align="center"><b>DEBIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>CREDIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>DEBIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>CREDIT<br>
									(en Dinars)</b></td>
								</tr>
								<?php   $Tcrs= Tcr::trouve_rest(); $cpt=33;

								$Resultat_operationnel_Debit =$Excedent_brut_Debit; $Resultat_operationnel_Credit=$Excedent_brut_Credit;
								$Resultat_financier_Debit =0; $Resultat_financier_Credit=0;
								$Resultat_ordinaire_Debit =0; $Resultat_ordinaire_Credit=0;
								$Resultat_extraordinaire_Debit =0; $Resultat_extraordinaire_Credit=0;
								$Resultat_NET_EXERCICE_Debit =$Excedent_brut_Debit; $Resultat_NET_EXERCICE_Credit=$Excedent_brut_Credit;
						//////////////////// N-1 //////////////////////////////////
								$Resultat_operationnel_Debit_anterieur =$Excedent_brut_Debit_anterieur; $Resultat_operationnel_Credit_anterieur=$Excedent_brut_Credit_anterieur;
								$Resultat_financier_Debit_anterieur =0; $Resultat_financier_Credit_anterieur=0;
								$Resultat_ordinaire_Debit_anterieur =0; $Resultat_ordinaire_Credit_anterieur=0;
								$Resultat_extraordinaire_Debit_anterieur =0; $Resultat_extraordinaire_Credit_anterieur=0;
								$Resultat_NET_EXERCICE_Debit_anterieur =0; $Resultat_NET_EXERCICE_Credit_anterieur=0;								
								

								foreach ($Tcrs as $Tcr) { $cpt++;
								if (!empty($Tcr->debit_credit)) {
							$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tcr->debit_credit,$date_db,$date_fin);
							$Debit_credit_anterieur=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement_anterieur($nav_societe->id_societe,$Tcr->debit_credit,$date_db);
							}
							if ($cpt < 40) {
								$Resultat_operationnel_Credit =  $Resultat_operationnel_Credit + $Debit_credit->somme_credit;
								$Resultat_operationnel_Debit = $Resultat_operationnel_Debit + $Debit_credit->somme_debit;
								$Resultat_operationnel_Credit_anterieur = $Resultat_operationnel_Credit_anterieur + $Debit_credit_anterieur->somme_credit;
								$Resultat_operationnel_Debit_anterieur = $Resultat_operationnel_Debit_anterieur + $Debit_credit_anterieur->somme_debit; }
							if ($cpt >40 &&  $cpt < 43) {
								$Resultat_financier_Debit = $Resultat_financier_Debit + $Debit_credit->somme_debit;
								$Resultat_financier_Credit = $Resultat_financier_Credit + $Debit_credit->somme_credit;
								$Resultat_financier_Debit_anterieur = $Resultat_financier_Debit_anterieur + $Debit_credit_anterieur->somme_debit;
								$Resultat_financier_Credit_anterieur = $Resultat_financier_Credit_anterieur + $Debit_credit_anterieur->somme_credit; }

							if ($Resultat_operationnel_Credit > $Resultat_financier_Debit) {
									$Resultat_ordinaire_Credit = $Resultat_operationnel_Credit + $Resultat_financier_Debit; 
								}
								if ( $Resultat_financier_Debit > $Resultat_operationnel_Credit ) {
									$Resultat_ordinaire_Debit =  $Resultat_financier_Debit + $Resultat_operationnel_Credit ; 
								}
								if ($Resultat_operationnel_Credit_anterieur > $Resultat_financier_Debit_anterieur) {
									$Resultat_ordinaire_Credit_anterieur = $Resultat_operationnel_Credit_anterieur + $Resultat_financier_Debit_anterieur; 
								}
								if ( $Resultat_financier_Debit_anterieur > $Resultat_operationnel_Credit_anterieur ) {
									$Resultat_ordinaire_Debit_anterieur =  $Resultat_financier_Debit_anterieur - $Resultat_operationnel_Credit_anterieur ; 
								}
							if ($cpt >44 &&  $cpt < 47) {
								$Resultat_extraordinaire_Debit +=  $Debit_credit->somme_debit;
								$Resultat_extraordinaire_Credit +=  $Debit_credit->somme_credit;
								$Resultat_extraordinaire_Debit_anterieur = $Resultat_extraordinaire_Debit_anterieur + $Debit_credit_anterieur->somme_debit;
								$Resultat_extraordinaire_Credit_anterieur = $Resultat_extraordinaire_Credit_anterieur + $Debit_credit_anterieur->somme_credit; }
							if ($cpt < 50) {
								$Resultat_NET_EXERCICE_Credit =  $Resultat_NET_EXERCICE_Credit + $Debit_credit->somme_credit;
								$Resultat_NET_EXERCICE_Debit = $Resultat_NET_EXERCICE_Debit + $Debit_credit->somme_debit;
								$Resultat_NET_EXERCICE_Credit_anterieur = $Resultat_NET_EXERCICE_Credit_anterieur + $Debit_credit_anterieur->somme_credit;
								$Resultat_NET_EXERCICE_Debit_anterieur = $Resultat_NET_EXERCICE_Debit_anterieur + $Debit_credit_anterieur->somme_debit; }
								 ?>
								<tr <?php if ( $Tcr->id == 40 || $Tcr->id == 43 || $Tcr->id == 44 || $Tcr->id == 47 || $Tcr->id == 50) { echo'class="badr"';} ?>>
									<td colspan="2" <?php if ($Tcr->is_bold == 1 ) { echo'style="padding-left:20px;"';} ?> <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?> style=" padding-right: 5px;" > 
										<?php if (isset($Tcr->rubriques)) {echo $Tcr->rubriques; } ?>
									</td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;"  ><?php
									 if ($Tcr->id == 40 && $Resultat_operationnel_Debit > 0) {  echo number_format($Resultat_operationnel_Debit,2,',',' '); }
									 else if ($Tcr->id == 43 && $Resultat_financier_Debit>0) { echo number_format($Resultat_financier_Debit,2,',',' '); }
									 else if ($Tcr->id == 44 && $Resultat_ordinaire_Debit>0) { echo number_format($Resultat_ordinaire_Debit,2,',',' '); }
									 else if ($Tcr->id == 47 && $Resultat_extraordinaire_Debit>0 ) { echo number_format($Resultat_extraordinaire_Debit,2,',',' '); }
									 else if ($Tcr->id == 50  && $Resultat_NET_EXERCICE_Debit > 0 ) { echo number_format($Resultat_NET_EXERCICE_Debit,2,',',' '); }
									 else if (isset($Debit_credit->debit) && $Debit_credit->debit >0) { echo number_format($Debit_credit->debit,'2',',',' ');} ?>
									 </td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;" >
							<?php if ($Tcr->id == 40 && $Resultat_operationnel_Credit > 0) {  echo number_format($Resultat_operationnel_Credit,2,',',' '); }
									else if ($Tcr->id == 43 && $Resultat_financier_Credit >0) { echo number_format($Resultat_financier_Credit ,2,',',' ');  }
									else if ($Tcr->id == 44 && $Resultat_ordinaire_Credit>0) { echo number_format($Resultat_ordinaire_Credit,2,',',' '); }
									else if ($Tcr->id == 47 && $Resultat_extraordinaire_Credit>0 ) { echo number_format($Resultat_extraordinaire_Credit,2,',',' '); }
									else if ($Tcr->id == 50  && $Resultat_NET_EXERCICE_Credit > 0 ) { echo number_format($Resultat_NET_EXERCICE_Credit,2,',',' '); } 
									else if (isset($Debit_credit->credit) && $Debit_credit->credit >0) { echo number_format($Debit_credit->credit,'2',',',' ');}
									 ?>
									</td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;"  ><?php
									 if ($Tcr->id == 40 && $Resultat_operationnel_Debit_anterieur > 0) {  echo number_format($Resultat_operationnel_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 43 && $Resultat_financier_Debit_anterieur>0) { echo number_format($Resultat_financier_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 44 && $Resultat_ordinaire_Debit_anterieur>0) { echo number_format($Resultat_ordinaire_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 47 && $Resultat_extraordinaire_Debit_anterieur>0 ) { echo number_format($Resultat_extraordinaire_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 50  && $Resultat_NET_EXERCICE_Debit_anterieur > 0 ) { echo number_format($Resultat_NET_EXERCICE_Debit_anterieur,2,',',' '); }
									 else if (isset($Debit_credit_anterieur->debit) && $Debit_credit_anterieur->debit >0) { echo number_format($Debit_credit_anterieur->debit,'2',',',' ');} ?>
									 </td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;" >
							<?php if ($Tcr->id == 40 && $Resultat_operationnel_Credit_anterieur > 0) {  echo number_format($Resultat_operationnel_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 43 && $Resultat_financier_Credit_anterieur >0) { echo number_format($Resultat_financier_Credit_anterieur ,2,',',' ');  }
									else if ($Tcr->id == 44 && $Resultat_ordinaire_Credit_anterieur>0) { echo number_format($Resultat_ordinaire_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 47 && $Resultat_extraordinaire_Credit_anterieur >0 ) { echo number_format($Resultat_extraordinaire_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 50  && $Resultat_NET_EXERCICE_Credit_anterieur > 0 ) { echo number_format($Resultat_NET_EXERCICE_Credit_anterieur,2,',',' '); } 
									else if (isset($Debit_credit_anterieur->credit) && $Debit_credit_anterieur->credit >0) { echo number_format($Debit_credit_anterieur->credit,'2',',',' ');}
									 ?>
									</td>
								</tr>
							<?php unset($Debit_credit); unset($Debit_credit_anterieur); } ?>
								

							</table>
							

					</div>
				</div>


			</div>

				</div>
			</div>
		</div>
		</page>	
<page size="A4-2" style="MARGIN-TOP:20px;" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE  A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" bordercolor="#FF0000" style="margin: 7px 0px 12px 0px;  ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
									<p style="text-align: center ; border: solid 2px;box-shadow: 5px 5px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										COMPTE DE RESULTAT
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
							</div>
							
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%" bordercolor="#FF0000" >
								<tr>
									<td rowspan="2" width="52%" align="center" colspan="2"><b>Rubriques</b></td>
									<td colspan="2" align="center"><b>N</b></td>
									<td align="center" colspan="2"><b>N-1</b></td>
								</tr>
								<tr>
									<td align="center"><b>DEBIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>CREDIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>DEBIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>CREDIT<br>
									(en Dinars)</b></td>
								</tr>
								<?php   $Tcrs= Tcr::trouve_33(); $cpt=0;
								$Chiffre_affaires_Debit =0; $Chiffre_affaires_Credit=0;
								$Debit_Valeur_ajoute =0; $Credit_Valeur_ajoute=0;
								$TOTAL_I_Debit=0;$TOTAL_I_Credit=0;
								$TOTAL_II_Debit=0;$TOTAL_II_Credit=0;
								$Excedent_brut_Debit=0; $Excedent_brut_Credit=0;
								//////////////////// N-1 ////////////////////////
								$Chiffre_affaires_Debit_anterieur =0; $Chiffre_affaires_Credit_anterieur=0;
								$Debit_Valeur_ajoute_anterieur =0; $Credit_Valeur_ajoute_anterieur=0;
								$TOTAL_I_Debit_anterieur=0;$TOTAL_I_Credit_anterieur=0;
								$TOTAL_II_Debit_anterieur=0;$TOTAL_II_Credit_anterieur=0;
								$Excedent_brut_Debit_anterieur=0; $Excedent_brut_Credit_anterieur=0;

								foreach ($Tcrs as $Tcr) { $cpt++;
							if (!empty($Tcr->debit_credit)) {
							$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tcr->debit_credit,$date_db,$date_fin);
							$Debit_credit_anterieur=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement_anterieur($nav_societe->id_societe,$Tcr->debit_credit,$date_db);
							}
							if ($cpt < 7 ) {
								////////////// Chiffre_affaires ////////////////
								$Chiffre_affaires_Credit = $Chiffre_affaires_Credit + $Debit_credit->somme_credit;
								$Chiffre_affaires_Debit = $Chiffre_affaires_Debit + $Debit_credit->somme_debit;
								$Chiffre_affaires_Credit_anterieur = $Chiffre_affaires_Credit_anterieur + $Debit_credit_anterieur->somme_credit;
								$Chiffre_affaires_Debit_anterieur = $Chiffre_affaires_Debit_anterieur + $Debit_credit_anterieur->somme_debit; } 
								//////////// TOTAL_I ///////////////////////
							if ($cpt < 11) {
								$TOTAL_I_Debit = $TOTAL_I_Debit + $Debit_credit->somme_debit;
								$TOTAL_I_Credit = $TOTAL_I_Credit + $Debit_credit->somme_credit;
								$TOTAL_I_Debit_anterieur = $TOTAL_I_Debit_anterieur + $Debit_credit_anterieur->somme_debit;
								$TOTAL_I_Credit_anterieur = $TOTAL_I_Credit_anterieur + $Debit_credit_anterieur->somme_credit; }
								//////////////////////////// TOTAL_II /////////////	
							if ($cpt >11 &&  $cpt < 29) {
								$TOTAL_II_Debit = $TOTAL_II_Debit + $Debit_credit->somme_debit;
								$TOTAL_II_Credit = $TOTAL_II_Credit + $Debit_credit->somme_credit;
								$TOTAL_II_Debit_anterieur = $TOTAL_II_Debit_anterieur + $Debit_credit_anterieur->somme_debit;
								$TOTAL_II_Credit_anterieur = $TOTAL_II_Credit_anterieur + $Debit_credit_anterieur->somme_credit; }
								///////////////////// Excedent_brut ///////////////

							if ($cpt < 33) {
								$Excedent_brut_Credit = $Excedent_brut_Credit + $Debit_credit->somme_credit;
								$Excedent_brut_Debit = $Excedent_brut_Debit + $Debit_credit->somme_debit;
								$Excedent_brut_Credit_anterieur = $Excedent_brut_Credit_anterieur + $Debit_credit_anterieur->somme_credit;
								$Excedent_brut_Debit_anterieur = $Excedent_brut_Debit_anterieur + $Debit_credit_anterieur->somme_debit; }
								//////////////////// Valeur_ajoute //////////////////////////
								if ($TOTAL_I_Credit > $TOTAL_II_Debit) {
									$Credit_Valeur_ajoute = $TOTAL_I_Credit - $TOTAL_II_Debit; 
								}
								if ( $TOTAL_II_Debit > $TOTAL_I_Credit ) {
									$Debit_Valeur_ajoute =  $TOTAL_II_Debit - $TOTAL_I_Credit ; 
								}
								if ($TOTAL_I_Credit_anterieur > $TOTAL_II_Debit_anterieur) {
									$Credit_Valeur_ajoute_anterieur = $TOTAL_I_Credit_anterieur - $TOTAL_II_Debit_anterieur; 
								}
								if ( $TOTAL_II_Debit_anterieur > $TOTAL_I_Credit_anterieur ) {
									$Debit_Valeur_ajoute_anterieur =  $TOTAL_II_Debit_anterieur - $TOTAL_I_Credit_anterieur ; 
								}

								 ?>
								 <?php if ($cpt == 2 || $cpt == 19) { ?>
								<tr>
									<td <?php if ($cpt == 2) {echo 'rowspan="3"'; }else{ echo 'rowspan="8"'; } ?>  <?php if ($Tcr->is_bold == 1 ) { echo'style="padding-left:5px;"';} ?> <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" style="padding-left:5px;"';} ?>  > 
										<?php if (isset($Tcr->rubriques)) {echo $Tcr->rubriques; } ?>
									</td>
									<td  class="bilan-td " style="padding-left: 5px;"><?php if (isset($Tcr->father_rubriques)) {echo $Tcr->father_rubriques; } ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit->debit)) { echo number_format($Debit_credit->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit->credit)) { echo number_format($Debit_credit->credit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit_anterieur->debit)) { echo number_format($Debit_credit_anterieur->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit_anterieur->credit)) { echo number_format($Debit_credit_anterieur->credit,'2',',',' ');} ?></td>
								</tr>
							<?php } else if($cpt == 3 || $cpt == 4 || $cpt == 20 || $cpt == 21 || $cpt == 22 || $cpt == 23 || $cpt == 24 || $cpt == 25 || $cpt == 26) { ?>
								<tr>
									<td  <?php if ($Tcr->is_bold == 1 ) { echo'style="padding-left:5px;"';} ?> <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" style="padding-left:5px;"';} ?> style=" padding-right: 5px;" > 
										<?php if (isset($Tcr->rubriques)) {echo $Tcr->rubriques; } ?>
									</td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit->debit)) { echo number_format($Debit_credit->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php  if (isset($Debit_credit->credit)) { echo number_format($Debit_credit->credit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit_anterieur->debit)) { echo number_format($Debit_credit_anterieur->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;" ><?php if (isset($Debit_credit_anterieur->credit)) { echo number_format($Debit_credit_anterieur->credit,'2',',',' ');} ?></td>
								</tr>
							<?php 	} else  { ?>
							<tr <?php if ($Tcr->id == 7 || $Tcr->id == 11 || $Tcr->id == 29 || $Tcr->id == 30 || $Tcr->id == 33 ) { echo'class="miloud"';} ?> >
									<td colspan="2" <?php if ($Tcr->is_bold == 1 ) { echo'style="padding-left:5px;"';} ?> <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" style="padding-left:5px;"';} ?> style=" padding-right: 5px;" > 
										<?php if (isset($Tcr->rubriques)) {echo $Tcr->rubriques; } ?>
									</td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;"  ><?php
									 if ($Tcr->id == 7 && $Chiffre_affaires_Debit > 0) {  echo number_format($Chiffre_affaires_Debit,2,',',' '); }
									 else if ($Tcr->id == 11 && $TOTAL_I_Debit>0) { echo number_format($TOTAL_I_Debit,2,',',' '); }
									 else if ($Tcr->id == 29 && $TOTAL_II_Debit>0) { echo number_format($TOTAL_II_Debit,2,',',' '); }
									 else if ($Tcr->id == 30 && $Debit_Valeur_ajoute > 0 ) { echo number_format($Debit_Valeur_ajoute,2,',',' '); }
									 else if ($Tcr->id == 33  && $Excedent_brut_Debit > 0 ) { echo number_format($Excedent_brut_Debit,2,',',' '); }
									 else if (isset($Debit_credit->debit) && $Debit_credit->debit >0) { echo number_format($Debit_credit->debit,'2',',',' ');} ?>
									 </td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;" >
							<?php if ($Tcr->id == 7 && $Chiffre_affaires_Credit > 0) {  echo number_format($Chiffre_affaires_Credit,2,',',' '); }
									else if ($Tcr->id == 11 && $TOTAL_I_Credit>0) { echo number_format($TOTAL_I_Credit,2,',',' ');  }
									else if ($Tcr->id == 29 && $TOTAL_II_Credit>0) { echo number_format($TOTAL_II_Credit,2,',',' '); }
									else if ($Tcr->id == 30 && $Credit_Valeur_ajoute > 0 ) { echo number_format($Credit_Valeur_ajoute,2,',',' '); }
									else if ($Tcr->id == 33  && $Excedent_brut_Credit > 0 ) { echo number_format($Excedent_brut_Credit,2,',',' '); } 
									else if (isset($Debit_credit->credit) && $Debit_credit->credit >0) { echo number_format($Debit_credit->credit,'2',',',' ');}
									 ?>
									</td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;"  ><?php
									 if ($Tcr->id == 7 && $Chiffre_affaires_Debit_anterieur > 0) {  echo number_format($Chiffre_affaires_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 11 && $TOTAL_I_Debit_anterieur>0) { echo number_format($TOTAL_I_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 29 && $TOTAL_II_Debit_anterieur>0) { echo number_format($TOTAL_II_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 30 && $Debit_Valeur_ajoute_anterieur > 0 ) { echo number_format($Debit_Valeur_ajoute_anterieur,2,',',' '); }
									 else if ($Tcr->id == 33  && $Excedent_brut_Debit_anterieur > 0 ) { echo number_format($Excedent_brut_Debit_anterieur,2,',',' '); }
									 else if (isset($Debit_credit_anterieur->debit) && $Debit_credit_anterieur->debit >0) { echo number_format($Debit_credit_anterieur->debit,'2',',',' ');} ?>
									 </td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;" >
							<?php if ($Tcr->id == 7 && $Chiffre_affaires_Credit_anterieur > 0) {  echo number_format($Chiffre_affaires_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 11 && $TOTAL_I_Credit_anterieur>0) { echo number_format($TOTAL_I_Credit_anterieur,2,',',' ');  }
									else if ($Tcr->id == 29 && $TOTAL_II_Credit_anterieur>0) { echo number_format($TOTAL_II_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 30 && $Credit_Valeur_ajoute_anterieur > 0 ) { echo number_format($Credit_Valeur_ajoute_anterieur,2,',',' '); }
									else if ($Tcr->id == 33  && $Excedent_brut_Credit_anterieur > 0 ) { echo number_format($Excedent_brut_Credit_anterieur,2,',',' '); } 
									else if (isset($Debit_credit_anterieur->credit) && $Debit_credit_anterieur->credit >0) { echo number_format($Debit_credit_anterieur->credit,'2',',',' ');}
									 ?>
									</td>
								</tr>
					<?php unset($Debit_credit); unset($Debit_credit_anterieur);	}} ?>
								

							</table>
							

					</div>
				</div>


			</div>

				</div>
			</div>
		</div>
		</page>
		<page size="A4-2" style="padding-top: 30px; height: 290mm;" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE  A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4"></div>
								<div class="col-xs-4">
									<p style="text-align: center ; border: solid 2px;box-shadow: 5px 5px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										COMPTE DE RESULTAT
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
							</div>
							
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  bordercolor="#FF0000" >
								<tr>
									<td rowspan="2" align="center" colspan="2"><b>Rubriques</b></td>
									<td colspan="2" align="center"><b>N</b></td>
									<td align="center" colspan="2"><b>N-1</b></td>
								</tr>
								<tr>
									<td align="center"><b>DEBIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>CREDIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>DEBIT<br>
									(en Dinars)</b></td>
									<td align="center"><b>CREDIT<br>
									(en Dinars)</b></td>
								</tr>
								<?php   $Tcrs= Tcr::trouve_rest(); $cpt=33;

								$Resultat_operationnel_Debit =$Excedent_brut_Debit; $Resultat_operationnel_Credit=$Excedent_brut_Credit;
								$Resultat_financier_Debit =0; $Resultat_financier_Credit=0;
								$Resultat_ordinaire_Debit =0; $Resultat_ordinaire_Credit=0;
								$Resultat_extraordinaire_Debit =0; $Resultat_extraordinaire_Credit=0;
								$Resultat_NET_EXERCICE_Debit =$Excedent_brut_Debit; $Resultat_NET_EXERCICE_Credit=$Excedent_brut_Credit;
						//////////////////// N-1 //////////////////////////////////
								$Resultat_operationnel_Debit_anterieur =$Excedent_brut_Debit_anterieur; $Resultat_operationnel_Credit_anterieur=$Excedent_brut_Credit_anterieur;
								$Resultat_financier_Debit_anterieur =0; $Resultat_financier_Credit_anterieur=0;
								$Resultat_ordinaire_Debit_anterieur =0; $Resultat_ordinaire_Credit_anterieur=0;
								$Resultat_extraordinaire_Debit_anterieur =0; $Resultat_extraordinaire_Credit_anterieur=0;
								$Resultat_NET_EXERCICE_Debit_anterieur =0; $Resultat_NET_EXERCICE_Credit_anterieur=0;								
								

								foreach ($Tcrs as $Tcr) { $cpt++;
								if (!empty($Tcr->debit_credit)) {
							$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tcr->debit_credit,$date_db,$date_fin);
							$Debit_credit_anterieur=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement_anterieur($nav_societe->id_societe,$Tcr->debit_credit,$date_db);
							}
							if ($cpt < 40) {
								$Resultat_operationnel_Credit =  $Resultat_operationnel_Credit + $Debit_credit->somme_credit;
								$Resultat_operationnel_Debit = $Resultat_operationnel_Debit + $Debit_credit->somme_debit;
								$Resultat_operationnel_Credit_anterieur = $Resultat_operationnel_Credit_anterieur + $Debit_credit_anterieur->somme_credit;
								$Resultat_operationnel_Debit_anterieur = $Resultat_operationnel_Debit_anterieur + $Debit_credit_anterieur->somme_debit; }
							if ($cpt >40 &&  $cpt < 43) {
								$Resultat_financier_Debit = $Resultat_financier_Debit + $Debit_credit->somme_debit;
								$Resultat_financier_Credit = $Resultat_financier_Credit + $Debit_credit->somme_credit;
								$Resultat_financier_Debit_anterieur = $Resultat_financier_Debit_anterieur + $Debit_credit_anterieur->somme_debit;
								$Resultat_financier_Credit_anterieur = $Resultat_financier_Credit_anterieur + $Debit_credit_anterieur->somme_credit; }

							if ($Resultat_operationnel_Credit > $Resultat_financier_Debit) {
									$Resultat_ordinaire_Credit = $Resultat_operationnel_Credit + $Resultat_financier_Debit; 
								}
								if ( $Resultat_financier_Debit > $Resultat_operationnel_Credit ) {
									$Resultat_ordinaire_Debit =  $Resultat_financier_Debit + $Resultat_operationnel_Credit ; 
								}
								if ($Resultat_operationnel_Credit_anterieur > $Resultat_financier_Debit_anterieur) {
									$Resultat_ordinaire_Credit_anterieur = $Resultat_operationnel_Credit_anterieur + $Resultat_financier_Debit_anterieur; 
								}
								if ( $Resultat_financier_Debit_anterieur > $Resultat_operationnel_Credit_anterieur ) {
									$Resultat_ordinaire_Debit_anterieur =  $Resultat_financier_Debit_anterieur - $Resultat_operationnel_Credit_anterieur ; 
								}
							if ($cpt >44 &&  $cpt < 47) {
								$Resultat_extraordinaire_Debit +=  $Debit_credit->somme_debit;
								$Resultat_extraordinaire_Credit +=  $Debit_credit->somme_credit;
								$Resultat_extraordinaire_Debit_anterieur = $Resultat_extraordinaire_Debit_anterieur + $Debit_credit_anterieur->somme_debit;
								$Resultat_extraordinaire_Credit_anterieur = $Resultat_extraordinaire_Credit_anterieur + $Debit_credit_anterieur->somme_credit; }
							if ($cpt < 50) {
								$Resultat_NET_EXERCICE_Credit =  $Resultat_NET_EXERCICE_Credit + $Debit_credit->somme_credit;
								$Resultat_NET_EXERCICE_Debit = $Resultat_NET_EXERCICE_Debit + $Debit_credit->somme_debit;
								$Resultat_NET_EXERCICE_Credit_anterieur = $Resultat_NET_EXERCICE_Credit_anterieur + $Debit_credit_anterieur->somme_credit;
								$Resultat_NET_EXERCICE_Debit_anterieur = $Resultat_NET_EXERCICE_Debit_anterieur + $Debit_credit_anterieur->somme_debit; }
								 ?>
								<tr <?php if ( $Tcr->id == 40 || $Tcr->id == 43 || $Tcr->id == 44 || $Tcr->id == 47 || $Tcr->id == 50) { echo'class="miloud"';} ?>>
									<td colspan="2" <?php if ($Tcr->is_bold == 1 ) { echo'style="padding-left:20px;"';} ?> <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td"';} ?> style=" padding-right: 5px;" > 
										<?php if (isset($Tcr->rubriques)) {echo $Tcr->rubriques; } ?>
									</td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;"  ><?php
									 if ($Tcr->id == 40 && $Resultat_operationnel_Debit > 0) {  echo number_format($Resultat_operationnel_Debit,2,',',' '); }
									 else if ($Tcr->id == 43 && $Resultat_financier_Debit>0) { echo number_format($Resultat_financier_Debit,2,',',' '); }
									 else if ($Tcr->id == 44 && $Resultat_ordinaire_Debit>0) { echo number_format($Resultat_ordinaire_Debit,2,',',' '); }
									 else if ($Tcr->id == 47 && $Resultat_extraordinaire_Debit>0 ) { echo number_format($Resultat_extraordinaire_Debit,2,',',' '); }
									 else if ($Tcr->id == 50  && $Resultat_NET_EXERCICE_Debit > 0 ) { echo number_format($Resultat_NET_EXERCICE_Debit,2,',',' '); }
									 else if (isset($Debit_credit->debit) && $Debit_credit->debit >0) { echo number_format($Debit_credit->debit,'2',',',' ');} ?>
									 </td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;" >
							<?php if ($Tcr->id == 40 && $Resultat_operationnel_Credit > 0) {  echo number_format($Resultat_operationnel_Credit,2,',',' '); }
									else if ($Tcr->id == 43 && $Resultat_financier_Credit >0) { echo number_format($Resultat_financier_Credit ,2,',',' ');  }
									else if ($Tcr->id == 44 && $Resultat_ordinaire_Credit>0) { echo number_format($Resultat_ordinaire_Credit,2,',',' '); }
									else if ($Tcr->id == 47 && $Resultat_extraordinaire_Credit>0 ) { echo number_format($Resultat_extraordinaire_Credit,2,',',' '); }
									else if ($Tcr->id == 50  && $Resultat_NET_EXERCICE_Credit > 0 ) { echo number_format($Resultat_NET_EXERCICE_Credit,2,',',' '); } 
									else if (isset($Debit_credit->credit) && $Debit_credit->credit >0) { echo number_format($Debit_credit->credit,'2',',',' ');}
									 ?>
									</td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;"  ><?php
									 if ($Tcr->id == 40 && $Resultat_operationnel_Debit_anterieur > 0) {  echo number_format($Resultat_operationnel_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 43 && $Resultat_financier_Debit_anterieur>0) { echo number_format($Resultat_financier_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 44 && $Resultat_ordinaire_Debit_anterieur>0) { echo number_format($Resultat_ordinaire_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 47 && $Resultat_extraordinaire_Debit_anterieur>0 ) { echo number_format($Resultat_extraordinaire_Debit_anterieur,2,',',' '); }
									 else if ($Tcr->id == 50  && $Resultat_NET_EXERCICE_Debit_anterieur > 0 ) { echo number_format($Resultat_NET_EXERCICE_Debit_anterieur,2,',',' '); }
									 else if (isset($Debit_credit_anterieur->debit) && $Debit_credit_anterieur->debit >0) { echo number_format($Debit_credit_anterieur->debit,'2',',',' ');} ?>
									 </td>
									<td <?php if ($Tcr->is_bold == 1) { echo 'class="bilan-td-title"'; } else{ echo ' class="bilan-td" ';} ?> style="padding-left:5px; text-align:right; padding-right: 5px;" >
							<?php if ($Tcr->id == 40 && $Resultat_operationnel_Credit_anterieur > 0) {  echo number_format($Resultat_operationnel_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 43 && $Resultat_financier_Credit_anterieur >0) { echo number_format($Resultat_financier_Credit_anterieur ,2,',',' ');  }
									else if ($Tcr->id == 44 && $Resultat_ordinaire_Credit_anterieur>0) { echo number_format($Resultat_ordinaire_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 47 && $Resultat_extraordinaire_Credit_anterieur >0 ) { echo number_format($Resultat_extraordinaire_Credit_anterieur,2,',',' '); }
									else if ($Tcr->id == 50  && $Resultat_NET_EXERCICE_Credit_anterieur > 0 ) { echo number_format($Resultat_NET_EXERCICE_Credit_anterieur,2,',',' '); } 
									else if (isset($Debit_credit_anterieur->credit) && $Debit_credit_anterieur->credit >0) { echo number_format($Debit_credit_anterieur->credit,'2',',',' ');}
									 ?>
									</td>
								</tr>
							<?php unset($Debit_credit); unset($Debit_credit_anterieur); } ?>
								

							</table>
							

					</div>
				</div>


			</div>

				</div>
			</div>
		</div>
		</page>	
		<!-- END TCR-->
				<!-- DEBUT Etat Mouvements de Stocks-->
				<?PHP
						 }else if($action =="etat_mouvements_stocks") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" style="height: 290mm;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-6 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										1/Tableau des mouvements des stocks:
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  >
								<tr class="badr">
									<td rowspan="3" align="center"><b>Rubriques</b></td>
								</tr>
								<tr class="badr">
									<td align="center" rowspan="2"><b>Solde de début
									<br>
									d’exercice</b></td>
									<td align="center" colspan="2"><b>Mouvements de la 
									période</b></td>
									<td align="center" rowspan="2"><b>Solde de fin <br>
									d’exercice</b></td>
								</tr>
								<tr class="badr">
									<td align="center"><b>Débit</b></td>
									<td align="center"><b>Crédit</b></td>
								</tr>
								<?php $Tab_mouv_stocks = Tab_mouv_stock::trouve_tous();
				$total_Solde_debut =0;					
				$total_Solde_final =0;					
				$total_debit =0;					
				$total_credit =0;		
								foreach ($Tab_mouv_stocks as $Tab_mouv_stock) {
			
				$Solde_debut_exercice=Ecriture_comptable::trouve_solde_debut_exercice($nav_societe->id_societe,$Tab_mouv_stock->debit_credit,$date_db);
				$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tab_mouv_stock->debit_credit,$date_db,$date_fin);
				$Solde_fin_exercice=Ecriture_comptable::trouve_solde_fin_exercice($nav_societe->id_societe,$Tab_mouv_stock->debit_credit,$date_fin);
								 ?>
								<tr>
									<td class="bilan-td" ><?php if (isset($Tab_mouv_stock->rubriques)) { echo $Tab_mouv_stock->rubriques; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Solde_debut_exercice->somme_debit)) { echo number_format($Solde_debut_exercice->somme_debit,'2',',',' ') ; $total_Solde_debut = $total_Solde_debut + $Solde_debut_exercice->somme_debit;} ?></td>
									<td class="bilan-td"style="text-align:right; padding-right: 5px;"><?php if (isset($Debit_credit->debit)) { echo number_format($Debit_credit->debit,'2',',',' ') ; $total_debit = $total_debit+$Debit_credit->debit;} ?></td>
									<td class="bilan-td"style="text-align:right; padding-right: 5px;"><?php if (isset($Debit_credit->credit)) { echo number_format($Debit_credit->credit,'2',',',' ') ; $total_credit= $total_credit+ $Debit_credit->credit; } ?></td>
									<td class="bilan-td"style="text-align:right; padding-right: 5px;"><?php if (isset($Solde_fin_exercice->somme_debit)) { echo number_format($Solde_fin_exercice->somme_debit,'2',',',' ') ; $total_Solde_final = $total_Solde_final+$Solde_fin_exercice->somme_debit;} ?></td>
								</tr>
							<?php } ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;"><b>TOTAL</b></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_Solde_debut,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_debit,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_credit,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_Solde_final,'2',',',' ') ?></td>
								</tr>
								</table>
								<br>
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-7 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										2/ Tableau de la fluctuation de la production stockée :
										
									</p>
									
								</div>
								<div class="col-xs-5"></div>
						</div>

							
						<br>
							<table border="1" width="100%">
								<tr class="badr">
									<td rowspan="3" align="center"><b>Débit</b></td>
									<td rowspan="3" align="center"><b>Crédit</b></td>
								</tr>
								<tr class="badr">
									<td align="center" colspan="2"><b>Solde de fin 
									d’exercice</b></td>
								</tr>
								<tr class="badr">
									<td align="center"><b>Débiteur</b></td>
									<td align="center"><b>Créditeur</b></td>
								</tr>
								<?php $att='^72'; $Tab_fluctuations=Ecriture_comptable::trouve_Tab_fluctuation($nav_societe->id_societe,$att,$date_db,$date_fin);
								if (!empty($Tab_fluctuations)) {
								foreach ($Tab_fluctuations as $Tab_fluctuation) {
									?>
								<tr>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_fluctuation->debit)) { echo number_format($Tab_fluctuation->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_fluctuation->credit)) { echo number_format($Tab_fluctuation->credit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_fluctuation->debit) &&  $Tab_fluctuation->somme_debit >0) { echo number_format($Tab_fluctuation->somme_debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_fluctuation->credit) &&  $Tab_fluctuation->somme_credit >0) { echo number_format($Tab_fluctuation->somme_credit,'2',',',' ');} ?></td>
								</tr>
								<?php }}else{ ?>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								<?php } ?>

							</table>
							

					</div>
				</div>


			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" style="MARGIN-TOP: 20PX; HEIGHT: 270MM; padding-top:0px;" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-6">
									<p class="miloud"  style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										1/Tableau des mouvements des stocks:
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  bordercolor="#FF0000">
								<tr class="miloud">
									<td rowspan="3" align="center"><b>Rubriques</b></td>
								</tr>
								<tr class="miloud">
									<td align="center" rowspan="2"><b>Solde de début
									<br>
									d’exercice</b></td>
									<td align="center" colspan="2"><b>Mouvements de la 
									période</b></td>
									<td align="center" rowspan="2"><b>Solde de fin <br>
									d’exercice</b></td>
								</tr>
								<tr class="miloud">
									<td align="center"><b>Débit</b></td>
									<td align="center"><b>Crédit</b></td>
								</tr>
								<?php $Tab_mouv_stocks = Tab_mouv_stock::trouve_tous();
				$total_Solde_debut =0;					
				$total_Solde_final =0;					
				$total_debit =0;					
				$total_credit =0;		
								foreach ($Tab_mouv_stocks as $Tab_mouv_stock) {
			
				$Solde_debut_exercice=Ecriture_comptable::trouve_solde_debut_exercice($nav_societe->id_societe,$Tab_mouv_stock->debit_credit,$date_db);
				$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tab_mouv_stock->debit_credit,$date_db,$date_fin);
				$Solde_fin_exercice=Ecriture_comptable::trouve_solde_fin_exercice($nav_societe->id_societe,$Tab_mouv_stock->debit_credit,$date_fin);
								 ?>
								<tr>
									<td class="bilan-td" ><?php if (isset($Tab_mouv_stock->rubriques)) { echo $Tab_mouv_stock->rubriques; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Solde_debut_exercice->somme_debit)) { echo number_format($Solde_debut_exercice->somme_debit,'2',',',' ') ; $total_Solde_debut = $total_Solde_debut + $Solde_debut_exercice->somme_debit;} ?></td>
									<td class="bilan-td"style="text-align:right; padding-right: 5px;"><?php if (isset($Debit_credit->debit)) { echo number_format($Debit_credit->debit,'2',',',' ') ; $total_debit = $total_debit+$Debit_credit->debit;} ?></td>
									<td class="bilan-td"style="text-align:right; padding-right: 5px;"><?php if (isset($Debit_credit->credit)) { echo number_format($Debit_credit->credit,'2',',',' ') ; $total_credit= $total_credit+ $Debit_credit->credit; } ?></td>
									<td class="bilan-td"style="text-align:right; padding-right: 5px;"><?php if (isset($Solde_fin_exercice->somme_debit)) { echo number_format($Solde_fin_exercice->somme_debit,'2',',',' ') ; $total_Solde_final = $total_Solde_final+$Solde_fin_exercice->somme_debit;} ?></td>
								</tr>
							<?php } ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;"><b>TOTAL</b></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_Solde_debut,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_debit,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_credit,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_Solde_final,'2',',',' ') ?></td>
								</tr>
								</table>
								<br>
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-7 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										2/ Tableau de la fluctuation de la production stockée :
										
									</p>
									
								</div>
								<div class="col-xs-5"></div>
						</div>

							
						<br>
							<table border="1" width="100%" bordercolor="#FF0000">
								<tr class="miloud">
									<td rowspan="3" align="center"><b>Débit</b></td>
									<td rowspan="3" align="center"><b>Crédit</b></td>
								</tr>
								<tr class="miloud">
									<td align="center" colspan="2"><b>Solde de fin 
									d’exercice</b></td>
								</tr>
								<tr class="miloud">
									<td align="center"><b>Débiteur</b></td>
									<td align="center"><b>Créditeur</b></td>
								</tr>
								<?php $att='^72'; $Tab_fluctuations=Ecriture_comptable::trouve_Tab_fluctuation($nav_societe->id_societe,$att,$date_db,$date_fin);
									if (!empty($Tab_fluctuations)) {
								foreach ($Tab_fluctuations as $Tab_fluctuation) {
									?>
								<tr>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_fluctuation->debit)) { echo number_format($Tab_fluctuation->debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_fluctuation->credit)) { echo number_format($Tab_fluctuation->credit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_fluctuation->credit) &&  $Tab_fluctuation->somme_debit >0) { echo number_format($Tab_fluctuation->somme_debit,'2',',',' ');} ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_fluctuation->credit) &&  $Tab_fluctuation->somme_credit >0) { echo number_format($Tab_fluctuation->somme_credit,'2',',',' ');} ?></td>
								</tr>
								<?php }}else{ ?>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								<?php } ?>

							</table>
							

					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br/>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>
			</div>

				</div>
			</div>
		</page>
		<!-- END ETAT Mouvements_stocks-->
		<!-- DEBUT ANNEXE 2-->
				<?PHP
						 }else if($action =="etat_annexe_2") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" style="height: 290mm; font-size: 9.1pt;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px; padding-bottom: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px; margin-bottom: 5px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="margin-bottom: 0px;text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 5px 0px 5px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-9 ">
									<p class="badr" style="text-align:left ;PADDING: 0px; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										3/ Charges de personnel, impôts, taxes et versements assimilés, autres services:
										
									</p>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
										<table border="1" width="100%"  style="margin-bottom: 5px;" >
								
								<tr class="badr">
									<td align="center" width="80%" ><b>Rubrique </td>
									<td align="center" ><b>Montants</b></td>
								</tr>
								
								<?php $Tab_charge_personels = Tab_charge_personel::trouve_23();
				$total_1=0;
				$total_2=0;
				$total_3=0;
				$total_Debit_credit =0;					
				$cpt=0;					
								foreach ($Tab_charge_personels as $Tab_charge_personel) { $cpt++;

			if (!empty($Tab_charge_personel->debit_credit)) {
		$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tab_charge_personel->debit_credit,$date_db,$date_fin);

						if ($cpt < 9) {
						$total_1 += $Debit_credit->somme_debit;
						}
						if ($cpt > 9 && $cpt < 17) {
						$total_2 += $Debit_credit->somme_debit;
						}
						if ( $cpt > 17 && $cpt < 22) {
						$total_3 += $Debit_credit->somme_debit;
						}
						$total_1_2_3 = $total_1 + $total_2 + $total_3;
		 
			}


								 ?>
								<tr <?php  if ($Tab_charge_personel->is_bold == 1) { echo 'class="badr"'; } ?>>
									<td <?php if ($Tab_charge_personel->is_total == 1) { echo 'style="padding-right:10px; text-align:right ;font-weight: bold;" '; } if ($Tab_charge_personel->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:center;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>   ><?php if (isset($Tab_charge_personel->rubriques)) { echo $Tab_charge_personel->rubriques; } ?> </td>
									<td <?php if ($Tab_charge_personel->is_total == 1) { echo ' style="text-align:right ;font-weight: bold; padding-right:5px; " '; } ?> class="bilan-td" style="text-align:right; padding-right: 5px;"><?php 
									 if($cpt==9){  echo  number_format($total_1,'2',',',' ') ; }
									 if($cpt==17){  echo  number_format($total_2,'2',',',' ') ; }
									 if($cpt==22){  echo  number_format($total_3,'2',',',' ') ; }
									 if($cpt==23){  echo  number_format($total_1_2_3,'2',',',' ') ; }
									else if (isset($Debit_credit->somme_debit)) { echo number_format($Debit_credit->somme_debit,'2',',',' ') ;} 
									  ?> 
									  </td>
									
								</tr>
							<?php unset($Debit_credit); }  ?>
								
								</table>
								
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-7 ">
									<p class="badr" style="text-align:left ; PADDING: 0px; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										4/ Autres charges et produits opérationnels :
										
									</p>
									
								</div>
								<div class="col-xs-5"></div>
						</div>

							<table border="1" width="100%" >
								
								<tr class="badr">
									<td align="center" width="80%" ><b>Rubrique </td>
									<td align="center" ><b>Montants</b></td>
								</tr>
								
								<?php $Tab_charge_personels = Tab_charge_personel::trouve_rest();					
				$total_1 =0;					
				$total_2=0;	
				$cpt= 23;	
								foreach ($Tab_charge_personels as $Tab_charge_personel) { $cpt++;

			if (!empty($Tab_charge_personel->debit_credit)) {
		$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tab_charge_personel->debit_credit,$date_db,$date_fin);

						if ($cpt > 23 && $cpt < 33) {
						$total_1 += $Debit_credit->somme_debit;
						}
						if ($cpt > 33 && $cpt < 43) {
						$total_2 += $Debit_credit->somme_credit;
						}

			}


								 ?>
								<tr <?php  if ($Tab_charge_personel->is_bold == 1) { echo 'class="badr"'; } ?>>
									<td <?php if ($Tab_charge_personel->is_total == 1) { echo 'style="padding-right:10px; text-align:right ;font-weight: bold;" '; } if ($Tab_charge_personel->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:center;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>   ><?php if (isset($Tab_charge_personel->rubriques)) { echo $Tab_charge_personel->rubriques; } ?> </td>
									<td <?php if ($Tab_charge_personel->is_total == 1) { echo ' style="text-align:right ;font-weight: bold; padding-right:5px; " '; } ?> class="bilan-td" style="text-align:right; padding-right: 5px;"><?php 
									if($cpt==33){  echo  number_format($total_1,'2',',',' ') ; }
									 if($cpt==43){  echo  number_format($total_2,'2',',',' ') ; }
									else if (isset($Debit_credit->somme_debit) && $cpt > 23 && $cpt < 33) { echo number_format($Debit_credit->somme_debit,'2',',',' ') ;}
									else if (isset($Debit_credit->somme_credit) && $cpt > 33 && $cpt < 43) { echo number_format($Debit_credit->somme_credit,'2',',',' ') ;}  
									  ?>  </td>
									
								</tr>
							<?php  unset($Debit_credit); }   ?>
								
								</table>
							
							

					</div>
				</div>


			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" style="margin-top: 10px; padding-top: 5px;  font-size: 9.1pt;" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px; padding-bottom: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px; margin-bottom: 5px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%"  bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="margin-bottom: 0px;text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" bordercolor="#FF0000" style="margin: 5px 0px 5px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-9 ">
									<p class="miloud" style="text-align:left ;PADDING: 0px; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										3/ Charges de personnel, impôts, taxes et versements assimilés, autres services:
										
									</p>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  style="margin-bottom: 5px;" bordercolor="#FF0000" >
								
								<tr class="miloud">
									<td align="center" width="80%" ><b>Rubrique </td>
									<td align="center" ><b>Montants</b></td>
								</tr>
								
								<?php $Tab_charge_personels = Tab_charge_personel::trouve_23();
				$total_1=0;
				$total_2=0;
				$total_3=0;
				$total_Debit_credit =0;					
				$cpt=0;					
								foreach ($Tab_charge_personels as $Tab_charge_personel) { $cpt++;

			if (!empty($Tab_charge_personel->debit_credit)) {
		$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tab_charge_personel->debit_credit,$date_db,$date_fin);

						if ($cpt < 9) {
						$total_1 += $Debit_credit->somme_debit;
						}
						if ($cpt > 9 && $cpt < 17) {
						$total_2 += $Debit_credit->somme_debit;
						}
						if ( $cpt > 17 && $cpt < 22) {
						$total_3 += $Debit_credit->somme_debit;
						}
						$total_1_2_3 = $total_1 + $total_2 + $total_3;
		 
			}


								 ?>
								<tr <?php  if ($Tab_charge_personel->is_bold == 1) { echo 'class="miloud"'; } ?>>
									<td <?php if ($Tab_charge_personel->is_total == 1) { echo 'style="padding-right:10px; text-align:right ;font-weight: bold;" '; } if ($Tab_charge_personel->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:center;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>   ><?php if (isset($Tab_charge_personel->rubriques)) { echo $Tab_charge_personel->rubriques; } ?> </td>
									<td <?php if ($Tab_charge_personel->is_total == 1) { echo ' style="text-align:right ;font-weight: bold; padding-right:5px; " '; } ?> class="bilan-td" style="text-align:right; padding-right: 5px;"><?php 
									 if($cpt==9){  echo  number_format($total_1,'2',',',' ') ; }
									 if($cpt==17){  echo  number_format($total_2,'2',',',' ') ; }
									 if($cpt==22){  echo  number_format($total_3,'2',',',' ') ; }
									 if($cpt==23){  echo  number_format($total_1_2_3,'2',',',' ') ; }
									else if (isset($Debit_credit->somme_debit)) { echo number_format($Debit_credit->somme_debit,'2',',',' ') ;} 
									  ?> 
									  </td>
									
								</tr>
							<?php unset($Debit_credit); }  ?>
								
								</table>
								
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-7 ">
									<p class="miloud" style="text-align:left ; PADDING: 0px; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										4/ Autres charges et produits opérationnels :
										
									</p>
									
								</div>
								<div class="col-xs-5"></div>
						</div>

							<table border="1" width="100%"  bordercolor="#FF0000" >
								
								<tr class="miloud">
									<td align="center" width="80%" ><b>Rubrique </td>
									<td align="center" ><b>Montants</b></td>
								</tr>
								
								<?php $Tab_charge_personels = Tab_charge_personel::trouve_rest();					
				$total_1 =0;					
				$total_2=0;	
				$cpt= 23;	
								foreach ($Tab_charge_personels as $Tab_charge_personel) { $cpt++;

			if (!empty($Tab_charge_personel->debit_credit)) {
		$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$Tab_charge_personel->debit_credit,$date_db,$date_fin);

						if ($cpt > 23 && $cpt < 33) {
						$total_1 += $Debit_credit->somme_debit;
						}
						if ($cpt > 33 && $cpt < 43) {
						$total_2 += $Debit_credit->somme_credit;
						}

			}


								 ?>
								<tr <?php  if ($Tab_charge_personel->is_bold == 1) { echo 'class="miloud"'; } ?>>
									<td <?php if ($Tab_charge_personel->is_total == 1) { echo 'style="padding-right:10px; text-align:right ;font-weight: bold;" '; } if ($Tab_charge_personel->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:center;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>   ><?php if (isset($Tab_charge_personel->rubriques)) { echo $Tab_charge_personel->rubriques; } ?> </td>
									<td <?php if ($Tab_charge_personel->is_total == 1) { echo ' style="text-align:right ;font-weight: bold; padding-right:5px; " '; } ?> class="bilan-td" style="text-align:right; padding-right: 5px;"><?php 
									if($cpt==33){  echo  number_format($total_1,'2',',',' ') ; }
									 if($cpt==43){  echo  number_format($total_2,'2',',',' ') ; }
									else if (isset($Debit_credit->somme_debit) && $cpt > 23 && $cpt < 33) { echo number_format($Debit_credit->somme_debit,'2',',',' ') ;}
									else if (isset($Debit_credit->somme_credit) && $cpt > 33 && $cpt < 43) { echo number_format($Debit_credit->somme_credit,'2',',',' ') ;}  
									  ?>  </td>
									
								</tr>
							<?php  unset($Debit_credit); }   ?>
								
								</table>
							

					</div>
				</div>


			</div>

				</div>
			</div>
		</page>
		<!-- END annexe 2-->
		<!-- DEBUT ANNEXE 3-->
				<?PHP
						 }else if($action =="etat_annexe_3") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" style="height: 290mm;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-7 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										5/ Tableau des amortissements et pertes de valeurs :
										
									</p>
									
								</div>
								<div class="col-xs-5"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  >
								<tr class="badr">
									<td  align="center" width="12%"><b>Rubriques et Postes</b></td>
									<td align="center" width="15%" ><b>Dotations Cumulées en début d’exercice </b></td>
									<td align="center" width="15%"><b>Dotations de l’exercice (1)</b></td>
									<td align="center" width="15%" ><b>Diminutions éléments sortis</b></td>
									<td align="center" width="15%"><b>Dotations cumulées en fin d’exercice</b></td>
									<td align="center" width="15%"><b>Dotations fiscales de l’exercice (2)</b></td>
									<td align="center" width="15%"><b>Ecarts <BR> (1) – (2)</b></td>
								</tr>
								
								<?php $tab_amort_immobs = Tab_amort_immob::trouve_tous();
				$TOTAL_Dotations_Cumulees =0;					
				$TOTAL_Dotations_exercice =0;					
				$TOTAL_Diminutions_Elements_sortis =0;					
				$total_debit =0;					
				$total_credit =0;		
								foreach ($tab_amort_immobs as $tab_amort_immob) {

			if (!empty($tab_amort_immob->amort) && !empty($tab_amort_immob->amort_sauf)) {

				$Dotations=Ecriture_comptable::trouve_credit_debit_par_date_and_2_attribut($nav_societe->id_societe,$tab_amort_immob->amort,$tab_amort_immob->amort_sauf,$date_db,$date_fin);
				$Dotations_anterieur=Ecriture_comptable::trouve_credit_debit_par_date_and_2_attribut_anterieur($nav_societe->id_societe,$tab_amort_immob->amort,$tab_amort_immob->amort_sauf,$date_db);
									
									} else if(!empty($tab_amort_immob->amort)){

				$Dotations=Ecriture_comptable::trouve_credit_debit_par_date_and_1_attribut($nav_societe->id_societe,$tab_amort_immob->amort,$date_db,$date_fin);
				$Dotations_anterieur=Ecriture_comptable::trouve_credit_debit_par_date_and_1_attribut_anterieur($nav_societe->id_societe,$tab_amort_immob->amort,$date_db); }

				$Ecarts =  $Dotations->credit - $Dotations->Annexe_Fiscale;
				$Dotations_cumulees_fin_exercice = $Dotations_anterieur->somme_credit + $Dotations->credit - $Dotations->debit;

				$TOTAL_Dotations_Cumulees +=  $Dotations_anterieur->somme_credit;
				$TOTAL_Dotations_exercice +=  $Dotations->credit;
				$TOTAL_Diminutions_Elements_sortis +=  $Dotations->debit;
				$TOTAL_Dotations_cumulees_fin_exercice += $Dotations_cumulees_fin_exercice; 
				$TOTAL_Dotations_fiscales_exercice += $Dotations->Annexe_Fiscale;
				$TOTAL_Ecarts += $Ecarts;
				
								 ?>
								<tr>
									<td class="bilan-td" style="text-align:center; padding-left: 10px;padding-right: 10px; height: 40px;" ><?php if (isset($tab_amort_immob->rubriques)) { echo $tab_amort_immob->rubriques; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations_anterieur->somme_credit)) { echo $Dotations_anterieur->somme_credit; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations->credit)) { echo $Dotations->credit; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations->debit)) { echo $Dotations->debit; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations_cumulees_fin_exercice)) {  echo number_format($Dotations_cumulees_fin_exercice,'2','.',' ');  } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations->Annexe_Fiscale)) { echo $Dotations->Annexe_Fiscale; } ?> </td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Ecarts)) { echo number_format($Ecarts,'2','.',' ') ;} ?></td>
								</tr>
							<?php } ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 40px;"><b>TOTAL</b></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Dotations_Cumulees,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Dotations_exercice,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Diminutions_Elements_sortis,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Dotations_cumulees_fin_exercice,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Dotations_fiscales_exercice,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Ecarts,'2','.',' ') ?></td>
								</tr>
								</table>
								<br>
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-9 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										6/ Tableau des immobilisations créées ou acquises au cours de l’exercice :
										
									</p>
									
								</div>
								<div class="col-xs-3"></div>
						</div>

							
						<br>
							<table border="1" width="100%"  >
								<tr class="badr">
									<td  align="center" width="30%"><b>Rubrique <BR> (Nature des immobilisations créées ou acquises à détailler)</b></td>
									<td align="center" width="25%" ><b>Montants bruts </b></td>
									<td align="center" width="25%"><b>TVA déduite</b></td>
									<td align="center" width="25%" ><b>Montant net à amortir</b></td>
									
								</tr>
								
								<?php $tab_amort_immobs = Tab_amort_immob::trouve_tous();
				$TOTAL_Montant_amortir =0;					
				$TOTAL_Montants_bruts =0;					
				$TOTAL_TVA_deduite =0;					
				$Dotation_debit =0;					
				$TOLAL_TVA =0;		
				$Montant_net =0;		
								foreach ($tab_amort_immobs as $tab_amort_immob) {
			
			if (!empty($tab_amort_immob->immob) && !empty($tab_amort_immob->immob_sauf)) {

				$Dotations=Ecriture_comptable::trouve_immob_debit_par_date_and_2_attribut($nav_societe->id_societe,$tab_amort_immob->immob,$tab_amort_immob->immob_sauf,$date_db,$date_fin);
									} else if(!empty($tab_amort_immob->immob)){
				$Dotations=Ecriture_comptable::trouve_immob_debit_par_date_and_1_attribut($nav_societe->id_societe,$tab_amort_immob->immob,$date_db,$date_fin);}
					
				foreach ($Dotations as $Dotation) {

					$TVA = Ecriture_comptable::trouve_tva_par_id_piece($Dotation->id_piece);
					//var_dump($TVA);
					//echo '<br>';
					$TOLAL_TVA += $TVA->debit; 
				   $Dotation_debit +=  $Dotation->debit;
				   $Montant_net = $TOLAL_TVA + $Dotation_debit;	
				}
				$TOTAL_Montant_amortir +=  $Montant_net ;
				$TOTAL_Montants_bruts+= $Dotation_debit;
				$TOTAL_TVA_deduite+=  $TOLAL_TVA;
				
								 ?>
								<tr>
									<td class="bilan-td" style=" padding-left: 10px;padding-right: 5px; height: 40px;" ><?php if (isset($tab_amort_immob->rubriques)) { echo $tab_amort_immob->rubriques; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotation_debit)) { echo  number_format($Dotation_debit,'2','.',' ') ;} ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($TOLAL_TVA)) { echo  number_format($TOLAL_TVA,'2','.',' ') ;} ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Montant_net)) { echo  number_format($Montant_net,'2','.',' ') ;} ?></td>
									
									
									
								</tr>
							<?php unset($Dotation_debit);
									unset($TOLAL_TVA);
									unset($Montant_net);
						} ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 40px;"><b>TOTAL</b></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Montants_bruts,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_TVA_deduite,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Montant_amortir,'2','.',' ') ?></td>
									
								</tr>
								</table>

					</div>
				</div>


			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" style="MARGIN-TOP: 20PX; HEIGHT: 270MM; padding-top:0px;" > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 12px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-7 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										5/ Tableau des amortissements et pertes de valeurs :
										
									</p>
									
								</div>
								<div class="col-xs-5"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  bordercolor="#FF0000" >
								<tr class="miloud">
									<td  align="center" width="12%"><b>Rubriques et Postes</b></td>
									<td align="center" width="15%" ><b>Dotations Cumulées en début d’exercice </b></td>
									<td align="center" width="15%"><b>Dotations de l’exercice (1)</b></td>
									<td align="center" width="15%" ><b>Diminutions éléments sortis</b></td>
									<td align="center" width="15%"><b>Dotations cumulées en fin d’exercice</b></td>
									<td align="center" width="15%"><b>Dotations fiscales de l’exercice (2)</b></td>
									<td align="center" width="15%"><b>Ecarts <BR> (1) – (2)</b></td>
								</tr>
								
								<?php $tab_amort_immobs = Tab_amort_immob::trouve_tous();
				$TOTAL_Dotations_Cumulees =0;					
				$TOTAL_Dotations_exercice =0;					
				$TOTAL_Diminutions_Elements_sortis =0;					
				$total_debit =0;					
				$total_credit =0;		
								foreach ($tab_amort_immobs as $tab_amort_immob) {

			if (!empty($tab_amort_immob->amort) && !empty($tab_amort_immob->amort_sauf)) {

				$Dotations=Ecriture_comptable::trouve_credit_debit_par_date_and_2_attribut($nav_societe->id_societe,$tab_amort_immob->amort,$tab_amort_immob->amort_sauf,$date_db,$date_fin);
				$Dotations_anterieur=Ecriture_comptable::trouve_credit_debit_par_date_and_2_attribut_anterieur($nav_societe->id_societe,$tab_amort_immob->amort,$tab_amort_immob->amort_sauf,$date_db);
									
									} else if(!empty($tab_amort_immob->amort)){

				$Dotations=Ecriture_comptable::trouve_credit_debit_par_date_and_1_attribut($nav_societe->id_societe,$tab_amort_immob->amort,$date_db,$date_fin);
				$Dotations_anterieur=Ecriture_comptable::trouve_credit_debit_par_date_and_1_attribut_anterieur($nav_societe->id_societe,$tab_amort_immob->amort,$date_db); }

				$Ecarts =  $Dotations->credit - $Dotations->Annexe_Fiscale;
				$Dotations_cumulees_fin_exercice = $Dotations_anterieur->somme_credit + $Dotations->credit - $Dotations->debit;

				$TOTAL_Dotations_Cumulees +=  $Dotations_anterieur->somme_credit;
				$TOTAL_Dotations_exercice +=  $Dotations->credit;
				$TOTAL_Diminutions_Elements_sortis +=  $Dotations->debit;
				$TOTAL_Dotations_cumulees_fin_exercice += $Dotations_cumulees_fin_exercice; 
				$TOTAL_Dotations_fiscales_exercice += $Dotations->Annexe_Fiscale;
				$TOTAL_Ecarts += $Ecarts;
				
								 ?>
								<tr>
									<td class="bilan-td" style="text-align:center; padding-left: 10px;padding-right: 10px; height: 40px;" ><?php if (isset($tab_amort_immob->rubriques)) { echo $tab_amort_immob->rubriques; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations_anterieur->somme_credit)) { echo $Dotations_anterieur->somme_credit; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations->credit)) { echo $Dotations->credit; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations->debit)) { echo $Dotations->debit; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations_cumulees_fin_exercice)) {  echo number_format($Dotations_cumulees_fin_exercice,'2','.',' ');  } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotations->Annexe_Fiscale)) { echo $Dotations->Annexe_Fiscale; } ?> </td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Ecarts)) { echo number_format($Ecarts,'2','.',' ') ;} ?></td>
								</tr>
							<?php } ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 40px;"><b>TOTAL</b></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Dotations_Cumulees,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Dotations_exercice,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Diminutions_Elements_sortis,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Dotations_cumulees_fin_exercice,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Dotations_fiscales_exercice,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Ecarts,'2','.',' ') ?></td>
								</tr>
								</table>
								<br>
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-9 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										6/ Tableau des immobilisations créées ou acquises au cours de l’exercice :
										
									</p>
									
								</div>
								<div class="col-xs-3"></div>
						</div>

							
						<br>
						<table border="1" width="100%" bordercolor="#FF0000"  >
								<tr class="miloud">
									<td  align="center" width="30%"><b>Rubrique <BR> (Nature des immobilisations créées ou acquises à détailler)</b></td>
									<td align="center" width="25%" ><b>Montants bruts </b></td>
									<td align="center" width="25%"><b>TVA déduite</b></td>
									<td align="center" width="25%" ><b>Montant net à amortir</b></td>
									
								</tr>
								
								<?php $tab_amort_immobs = Tab_amort_immob::trouve_tous();
				$TOTAL_Montant_amortir =0;					
				$TOTAL_Montants_bruts =0;					
				$TOTAL_TVA_deduite =0;					
				$Dotation_debit =0;					
				$TOLAL_TVA =0;		
				$Montant_net =0;		
								foreach ($tab_amort_immobs as $tab_amort_immob) {
			
			if (!empty($tab_amort_immob->immob) && !empty($tab_amort_immob->immob_sauf)) {

				$Dotations=Ecriture_comptable::trouve_immob_debit_par_date_and_2_attribut($nav_societe->id_societe,$tab_amort_immob->immob,$tab_amort_immob->immob_sauf,$date_db,$date_fin);
									} else if(!empty($tab_amort_immob->immob)){
				$Dotations=Ecriture_comptable::trouve_immob_debit_par_date_and_1_attribut($nav_societe->id_societe,$tab_amort_immob->immob,$date_db,$date_fin);}
					
				foreach ($Dotations as $Dotation) {

					$TVA = Ecriture_comptable::trouve_tva_par_id_piece($Dotation->id_piece);
					//var_dump($TVA);
					//echo '<br>';
					$TOLAL_TVA += $TVA->debit; 
				   $Dotation_debit +=  $Dotation->debit;
				   $Montant_net = $TOLAL_TVA + $Dotation_debit;	
				}
				$TOTAL_Montant_amortir +=  $Montant_net ;
				$TOTAL_Montants_bruts+= $Dotation_debit;
				$TOTAL_TVA_deduite+=  $TOLAL_TVA;
				
								 ?>
								<tr>
									<td class="bilan-td" style=" padding-left: 10px;padding-right: 5px; height: 40px;" ><?php if (isset($tab_amort_immob->rubriques)) { echo $tab_amort_immob->rubriques; } ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Dotation_debit)) { echo  number_format($Dotation_debit,'2','.',' ') ;} ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($TOLAL_TVA)) { echo  number_format($TOLAL_TVA,'2','.',' ') ;} ?></td>
									<td class="bilan-td" style="text-align:right; padding-right: 5px;"><?php if (isset($Montant_net)) { echo  number_format($Montant_net,'2','.',' ') ;} ?></td>
									
									
									
								</tr>
							<?php unset($Dotation_debit);
									unset($TOLAL_TVA);
									unset($Montant_net);
						} ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 40px;"><b>TOTAL</b></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Montants_bruts,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_TVA_deduite,'2','.',' ') ?></td>
									<td style="text-align:right; padding-right: 5px; font-weight: 700;"><?php echo number_format($TOTAL_Montant_amortir,'2','.',' ') ?></td>
									
								</tr>
								</table>
							
							

					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br/>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>
			</div>

				</div>
			</div>
		</page>
		<!-- END annexe 3-->
		<!-- DEBUT ANNEXE 4-->
				<?PHP
						 }else if($action =="etat_annexe_4") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" style="height: 290mm;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px ; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-10 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										7/ Tableau des immobilisations cédées (plus ou moins value) au cours de l’exercice :
										
									</p>
									
								</div>
								<div class="col-xs-2"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"  >
								
								<tr class="badr">
									<td rowspan="3" align="center" width="15%"><b>Nature des immobilisations cédées</b></td>
								</tr>
								<tr class="badr">
									<td align="center" rowspan="2"><b>Date acquisition </b></td>
									<td align="center" rowspan="2"  width="12%"><b>Montant net figurant à l’actif</b></td>
									<td align="center" rowspan="2" width="14%" ><b>Amortissements pratiqués</b></td>
									<td align="center" rowspan="2" width="12%"><b>Valeur nette <br> comptable</b></td>
									<td align="center" rowspan="2" width="13%"><b>Prix de <br> cession</b></td>
									<td align="center" colspan="2"><b>Plus ou moins value</b></td>
									
								</tr>
								<tr class="badr">
									<td align="center"><b>Plus value</b></td>
									<td align="center"><b>Moins value</b></td>
								</tr>
								
								<?php $tab_amort_immobs = Tab_provisions_perte::trouve_tous();
				$total_Solde_debut =0;					
				$total_Solde_final =0;					
				$total_debit =0;					
				$total_credit =0;		
								foreach ($tab_amort_immobs as $tab_amort_immob) {
			
				$Solde_debut_exercice=Ecriture_comptable::trouve_solde_debut_exercice($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_db);
				$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_db,$date_fin);
				$Solde_fin_exercice=Ecriture_comptable::trouve_solde_fin_exercice($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_fin);
								 ?>
								<tr>
									<td class="bilan-td" style="text-align:center; padding-left: 10px;padding-right: 10px; height: 20px;" ></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							<?php } ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 20px;"><b>TOTAL</b></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								</table>

								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 5px;" >
								
								<div class="col-xs-6 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										8/ Tableau des provisions et pertes de valeurs :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>

							
							<table border="1" width="100%"  >
								<tr class="badr">
									<td  align="center" width="40%"><b>Rubriques et postes </b></td>
									<td align="center" width="15%" ><b>Provisions cumulées en début d'exercice </b></td>
									<td align="center" width="15%"><b>Dotations de L’exercice</b></td>
									<td align="center" width="15%" ><b>Reprises sur l’exercice</b></td>
									<td align="center" width="15%" ><b>Provisions cumulées en fin d'exercice </b></td>
									
								</tr>
								
								<?php $tab_amort_immobs = Tab_provisions_perte::trouve_tous();
				$total_Solde_debut =0;					
				$total_Solde_final =0;					
				$total_debit =0;					
				$total_credit =0;		
								foreach ($tab_amort_immobs as $tab_amort_immob) {
			
				$Solde_debut_exercice=Ecriture_comptable::trouve_solde_debut_exercice($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_db);
				$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_db,$date_fin);
				$Solde_fin_exercice=Ecriture_comptable::trouve_solde_fin_exercice($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_fin);
								 ?>
								<tr>
									<td class="bilan-td" style=" padding-left: 10px;padding-right: 5px; height: 20px;" ><?php if (isset($tab_amort_immob->rubriques)) { echo $tab_amort_immob->rubriques; } ?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									
								</tr>
							<?php } ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 20px;"><b>TOTAL</b></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_Solde_debut,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_debit,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_credit,'2',',',' ') ?></td>
									<td></td>
									
								</tr>
								</table>

					</div>
				</div>
				<div class="row" style="padding-top: 50px;">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-10">
						(1) A détailler en tableau 8/1 <br>
						(2) A détailler en tableau 8/2
					</div>

					
				</div>

			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" style="MARGIN-TOP: 20PX;  padding-top:0px; " > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-10 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										7/ Tableau des immobilisations cédées (plus ou moins value) au cours de l’exercice :
										
									</p>
									
								</div>
								<div class="col-xs-2"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
							<table border="1" width="100%"   bordercolor="#FF0000">
								
								<tr class="miloud">
									<td rowspan="3" align="center" width="15%"><b>Nature des immobilisations cédées</b></td>
								</tr>
								<tr class="miloud">
									<td align="center" rowspan="2"><b>Date acquisition </b></td>
									<td align="center" rowspan="2"  width="12%"><b>Montant net figurant à l’actif</b></td>
									<td align="center" rowspan="2" width="14%" ><b>Amortissements pratiqués</b></td>
									<td align="center" rowspan="2" width="12%"><b>Valeur nette <br> comptable</b></td>
									<td align="center" rowspan="2" width="13%"><b>Prix de <br> cession</b></td>
									<td align="center" colspan="2"><b>Plus ou moins value</b></td>
									
								</tr>
								<tr class="miloud">
									<td align="center"><b>Plus value</b></td>
									<td align="center"><b>Moins value</b></td>
								</tr>
								
								<?php $tab_amort_immobs = Tab_provisions_perte::trouve_tous();
				$total_Solde_debut =0;					
				$total_Solde_final =0;					
				$total_debit =0;					
				$total_credit =0;		
								foreach ($tab_amort_immobs as $tab_amort_immob) {
			
				$Solde_debut_exercice=Ecriture_comptable::trouve_solde_debut_exercice($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_db);
				$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_db,$date_fin);
				$Solde_fin_exercice=Ecriture_comptable::trouve_solde_fin_exercice($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_fin);
								 ?>
								<tr>
									<td class="bilan-td" style="text-align:center; padding-left: 10px;padding-right: 10px; height: 20px;" ></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							<?php } ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 20px;"><b>TOTAL</b></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								</table>
								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 5px;" >
								
								<div class="col-xs-6 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										8/ Tableau des provisions et pertes de valeurs :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>

							
							<table border="1" width="100%" bordercolor="#FF0000" >
								<tr class="miloud">
									<td  align="center" width="40%"><b>Rubriques et postes </b></td>
									<td align="center" width="15%" ><b>Provisions cumulées en début d'exercice </b></td>
									<td align="center" width="15%"><b>Dotations de L’exercice</b></td>
									<td align="center" width="15%" ><b>Reprises sur l’exercice</b></td>
									<td align="center" width="15%" ><b>Provisions cumulées en fin d'exercice </b></td>
									
								</tr>
								
								<?php $tab_amort_immobs = Tab_provisions_perte::trouve_tous();
				$total_Solde_debut =0;					
				$total_Solde_final =0;					
				$total_debit =0;					
				$total_credit =0;		
								foreach ($tab_amort_immobs as $tab_amort_immob) {
			
				$Solde_debut_exercice=Ecriture_comptable::trouve_solde_debut_exercice($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_db);
				$Debit_credit=Ecriture_comptable::trouve_debit_credit_par_date_and_mouvement($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_db,$date_fin);
				$Solde_fin_exercice=Ecriture_comptable::trouve_solde_fin_exercice($nav_societe->id_societe,$tab_amort_immob->debit_credit,$date_fin);
								 ?>
								<tr>
									<td class="bilan-td" style=" padding-left: 10px;padding-right: 5px; height: 20px;" ><?php if (isset($tab_amort_immob->rubriques)) { echo $tab_amort_immob->rubriques; } ?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									
								</tr>
							<?php } ?>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 20px;"><b>TOTAL</b></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_Solde_debut,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_debit,'2',',',' ') ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php echo number_format($total_credit,'2',',',' ') ?></td>
									<td></td>
									
								</tr>
								</table>

					</div>
				</div>
				<div class="row" style="padding-top: 50px;">
					<div class="col-xs-1">
					</div>
					<div class="col-xs-10">
						(1) A détailler en tableau 8/1 <br>
						(2) A détailler en tableau 8/2
					</div>

					
				</div>
				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>

			</div>

				</div>
			</div>
		</page>
		<!-- END annexe 4-->
				<!-- DEBUT ANNEXE 5-->
				<?PHP
						 }else if($action =="etat_annexe_5") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" style="height: 290mm;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px ; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-6 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										8/1 Relevé des pertes de valeurs sur créances :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table border="1" width="100%"  >
								
								<tr class="badr">
									<td align="center" ><b>Désignation des débiteurs</b></td>
									<td align="center" ><b>Valeur de la créance</b></td>
									<td align="center" ><b>Perte de valeur constituée</b></td>
								</tr>
								<?php  $Tab_annexe_5 = Tab_annexe_5::trouve_annexe_5($nav_societe->id_societe,$date_db,$date_fin);
								foreach ($Tab_annexe_5 as $annexe_5) {
								 $Tab_valeurs_creances = Tab_releve_pertes_valeurs_creances::trouve_par_id_annexe($annexe_5->id);
								foreach ($Tab_valeurs_creances as $Tab_valeurs_creance) {
								  ?>
								<tr>
									<td class="bilan-td" style="text-align:left; padding-left: 10px;padding-right: 10px; " ><?php if (isset($Tab_valeurs_creance->Designation_debiteurs)) { echo $Tab_valeurs_creance->Designation_debiteurs; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_creance->Valeur_creance)) { echo $Tab_valeurs_creance->Valeur_creance; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_creance->Perte_valeur_constituee)) { echo $Tab_valeurs_creance->Perte_valeur_constituee; } ?></td>
								</tr>
								<?php }} ?>
							</table>

								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 15px;" >
								
								<div class="col-xs-8 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										8/2 Relevé des pertes de valeurs sur actions et parts sociales :
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
						</div>
						<br>
							
							<table border="1" width="100%"  >
								<tr class="badr">
									<td align="center" width="25%"><b>Filiales </b></td>
									<td align="center" width="25%" ><b>Valeur nominale au début de l’exercice </b></td>
									<td align="center" width="25%" ><b>Perte de valeur constituée</b></td>
									<td align="center" width="25%" ><b>Valeur nette comptable</b></td>
								</tr>
								<?php foreach ($Tab_annexe_5 as $annexe_5) { 

								$Tab_valeurs_actions = Tab_releve_pertes_valeurs_actions::trouve_par_id_annexe($annexe_5->id);
								foreach ($Tab_valeurs_actions as $Tab_valeurs_action) {
								  ?>
								<tr>
									<td class="bilan-td" style="text-align:left; padding-left: 10px;padding-right: 10px; " ><?php if (isset($Tab_valeurs_action->Filiales)) { echo $Tab_valeurs_action->Filiales; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Valeur_nominale)) { echo $Tab_valeurs_action->Valeur_nominale; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Perte_valeur_constituee)) { echo $Tab_valeurs_action->Perte_valeur_constituee; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Valeur_nette)) { echo $Tab_valeurs_action->Valeur_nette; } ?></td>
								</tr>
								<?php }} ?>
								</table>

					</div>
				</div>
			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" style="MARGIN-TOP: 20PX;  padding-top:0px; " > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-6 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										8/1 Relevé des pertes de valeurs sur créances :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive" >
						<table border="1" width="100%"  bordercolor="#FF0000" >
								
								<tr class="miloud">
									<td align="center" ><b>Désignation des débiteurs</b></td>
									<td align="center" ><b>Valeur de la créance</b></td>
									<td align="center" ><b>Perte de valeur constituée</b></td>
								</tr>
								
									<?php  $Tab_annexe_5 = Tab_annexe_5::trouve_annexe_5($nav_societe->id_societe,$date_db,$date_fin);
								foreach ($Tab_annexe_5 as $annexe_5) {
								 $Tab_valeurs_creances = Tab_releve_pertes_valeurs_creances::trouve_par_id_annexe($annexe_5->id);
								foreach ($Tab_valeurs_creances as $Tab_valeurs_creance) {
								  ?>
								<tr>
									<td class="bilan-td" style="text-align:left; padding-left: 10px;padding-right: 10px; " ><?php if (isset($Tab_valeurs_creance->Designation_debiteurs)) { echo $Tab_valeurs_creance->Designation_debiteurs; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_creance->Valeur_creance)) { echo $Tab_valeurs_creance->Valeur_creance; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_creance->Perte_valeur_constituee)) { echo $Tab_valeurs_creance->Perte_valeur_constituee; } ?></td>
								</tr>
								<?php }} ?>
							</table>

								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 15px;" >
								
								<div class="col-xs-8 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										8/2 Relevé des pertes de valeurs sur actions et parts sociales :
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
						</div>
						<br>
							
							<table border="1" width="100%"  bordercolor="#FF0000">
								<tr class="miloud">
									<td align="center" width="25%"><b>Filiales </b></td>
									<td align="center" width="25%" ><b>Valeur nominale au début de l’exercice </b></td>
									<td align="center" width="25%" ><b>Perte de valeur constituée</b></td>
									<td align="center" width="25%" ><b>Valeur nette comptable</b></td>
								</tr>
							<?php foreach ($Tab_annexe_5 as $annexe_5) { 

								$Tab_valeurs_actions = Tab_releve_pertes_valeurs_actions::trouve_par_id_annexe($annexe_5->id);
								foreach ($Tab_valeurs_actions as $Tab_valeurs_action) {
								  ?>
								<tr>
									<td class="bilan-td" style="text-align:left; padding-left: 10px;padding-right: 10px; " ><?php if (isset($Tab_valeurs_action->Filiales)) { echo $Tab_valeurs_action->Filiales; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Valeur_nominale)) { echo $Tab_valeurs_action->Valeur_nominale; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Perte_valeur_constituee)) { echo $Tab_valeurs_action->Perte_valeur_constituee; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Valeur_nette)) { echo $Tab_valeurs_action->Valeur_nette; } ?></td>
								</tr>
								<?php }} ?>
								</table>

					</div>

				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>

			</div>

				</div>
			</div>
		</page>
		<!-- END annexe 5-->
				<!-- DEBUT ANNEXE 6-->
				<?PHP
						 }else if($action =="etat_annexe_6") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" style="height: 290mm;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px ; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-6 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										9/ Tableau de détermination du résultat fiscal :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table border="1" width="100%"  >

								<?php   $Tab_resultat_fiscals= Tab_resultat_fiscal::trouve_tous(); $cpt=0;?>
								<tr class="badr">
									<td class="bilan-td"  width=" 40%"  ><b>I. Résultat net de l’exercice</b></td>
									<td class="bilan-td" width=" 40%" ><b>Bénéfice</b></td>
									<td class="bilan-td"  width=" 20%" ><b></b></td>
								</tr>
								<tr class="badr">
									<td class="bilan-td"  ><b>(Compte de résultat)</b></td>
									<td class="bilan-td" ><b>Perte</b></td>
									<td class="bilan-td"  width=" 20%" ><b></b></td>
								</tr>
								<?php foreach ($Tab_resultat_fiscals as $Tab_resultat_fiscal) {
								if ($Tab_resultat_fiscal->id == 13) { ?>

								<tr>
									<td  class="bilan-td" style="padding-left:10px;" rowspan="2"> <?php echo $Tab_resultat_fiscal->father_rubriques; ?></td>							
									<td  <?php  if ($Tab_resultat_fiscal->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold;" '; }if ($Tab_resultat_fiscal->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>   ><?php echo $Tab_resultat_fiscal->rubriques; ?></td>
									<td>&nbsp;</td>
								</tr>
									
								<?php	} else if ($Tab_resultat_fiscal->id == 14) { ?>
									<tr <?php  if ($Tab_resultat_fiscal->is_bold == 1 or $Tab_resultat_fiscal->is_total == 1 ) { echo 'class="badr"'; } ?>>
									<td  <?php  if ($Tab_resultat_fiscal->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold;" '; }if ($Tab_resultat_fiscal->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>   ><?php echo $Tab_resultat_fiscal->rubriques; ?></td>
									<td style="text-align:right; padding-right: 5px;" ></td>
								</tr>
							<?php 	} else{ ?>
								<tr <?php  if ($Tab_resultat_fiscal->is_bold == 1 or $Tab_resultat_fiscal->is_total == 1 ) { echo 'class="badr"'; } ?>>
									<td colspan="2" <?php  if ($Tab_resultat_fiscal->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold;" '; }if ($Tab_resultat_fiscal->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>  colspan="2" ><?php echo $Tab_resultat_fiscal->rubriques; ?></td>
									<td style="text-align:right; padding-right: 5px;" ></td>
								</tr>


							<?php }} ?>
							<tr class="badr">
									<td class="bilan-td"  width=" 40%"  ><b>Résultat fiscal (I+II+III+IV)</b></td>
									<td class="bilan-td" width=" 40%" ><b>Bénéfice</b></td>
									<td class="bilan-td"  width=" 20%" ><b></b></td>
								</tr>
								<tr class="badr">
									<td class="bilan-td"  ><b></b></td>
									<td class="bilan-td" ><b>Déficit</b></td>
									<td class="bilan-td"  width=" 20%" ><b></b></td>
								</tr>
							</table>
					</div>
				</div>
			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" style="MARGIN-TOP: 20PX;  padding-top:0px; " > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-6 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										9/ Tableau de détermination du résultat fiscal :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive" >
						<table border="1" width="100%"  bordercolor="#FF0000" >
								
								<tr class="miloud">
									<td class="bilan-td"  width=" 40%"  ><b>I. Résultat net de l’exercice</b></td>
									<td class="bilan-td" width=" 40%" ><b>Bénéfice</b></td>
									<td class="bilan-td"  width=" 20%" ><b></b></td>
								</tr>
								<tr class="miloud">
									<td class="bilan-td"  ><b>(Compte de résultat)</b></td>
									<td class="bilan-td" ><b>Perte</b></td>
									<td class="bilan-td"  width=" 20%" ><b></b></td>
								</tr>
								<?php foreach ($Tab_resultat_fiscals as $Tab_resultat_fiscal) {
								if ($Tab_resultat_fiscal->id == 13) { ?>

								<tr>
									<td  class="bilan-td" style="padding-left:10px;" rowspan="2"> <?php echo $Tab_resultat_fiscal->father_rubriques; ?></td>							
									<td  <?php  if ($Tab_resultat_fiscal->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold;" '; }if ($Tab_resultat_fiscal->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>   ><?php echo $Tab_resultat_fiscal->rubriques; ?></td>
									<td>&nbsp;</td>
								</tr>
									
								<?php	} else if ($Tab_resultat_fiscal->id == 14) { ?>
									<tr <?php  if ($Tab_resultat_fiscal->is_bold == 1 or $Tab_resultat_fiscal->is_total == 1 ) { echo 'class="miloud"'; } ?>>
									<td  <?php  if ($Tab_resultat_fiscal->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold;" '; }if ($Tab_resultat_fiscal->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>   ><?php echo $Tab_resultat_fiscal->rubriques; ?></td>
									<td style="text-align:right; padding-right: 5px;" ></td>
								</tr>
							<?php 	} else{ ?>
								<tr <?php  if ($Tab_resultat_fiscal->is_bold == 1 or $Tab_resultat_fiscal->is_total == 1 ) { echo 'class="miloud"'; } ?>>
									<td colspan="2" <?php  if ($Tab_resultat_fiscal->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold;" '; }if ($Tab_resultat_fiscal->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;" ';}  ?>  colspan="2" ><?php echo $Tab_resultat_fiscal->rubriques; ?></td>
									<td style="text-align:right; padding-right: 5px;" ></td>
								</tr>


							<?php }} ?>
							<tr class="miloud">
									<td class="bilan-td"  width=" 40%"  ><b>Résultat fiscal (I+II+III+IV)</b></td>
									<td class="bilan-td" width=" 40%" ><b>Bénéfice</b></td>
									<td class="bilan-td"  width=" 20%" ><b></b></td>
								</tr>
								<tr class="miloud">
									<td class="bilan-td"  ><b></b></td>
									<td class="bilan-td" ><b>Déficit</b></td>
									<td class="bilan-td"  width=" 20%" ><b></b></td>
								</tr>
							</table>

					</div>

				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>

			</div>

				</div>
			</div>
		</page>
		<!-- END annexe 6-->
						<!-- DEBUT ANNEXE 7-->
				<?PHP
						 }else if($action =="etat_annexe_7") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" style="height: 290mm;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px ; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-7 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										10/ Tableau d’affectation du résultat et des réserves (N-1) :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table border="1" width="100%"  >
								
								<tr >
									<td width="20%" align="center" style="border-top: solid 1px #FFF;border-left: solid 1px #FFF;" ></td>
									<td width="40%" align="center" style="border-top: solid 1px #FFF;border-left: solid 1px #FFF;" ></td>
									<td class="badr" align="center" ><b>Montants</b></td>
								</tr>
								<?php
								$Tab_affectation_resultats= Tab_affectation_resultat::trouve_tous();
								 foreach ($Tab_affectation_resultats as $Tab_affectation_resultat) {
								if ($Tab_affectation_resultat->id == 1 or $Tab_affectation_resultat->id == 5) { ?>
								<tr>
									<td  class="bilan-td badr" style="padding-left:10px; text-align:center;" <?php if ($Tab_affectation_resultat->id == 1 ) { echo 'rowspan="4"';} else{ echo 'rowspan="5"';}  ?>  > <?php  echo $Tab_affectation_resultat->father_rubriques; ?></td>							
									<td  <?php  if ($Tab_affectation_resultat->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold; height:30px" '; }if ($Tab_affectation_resultat->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;  height:30px;" ';}  ?>   ><?php echo $Tab_affectation_resultat->rubriques; ?></td>
									<td>&nbsp;</td>
								</tr>
									
								<?php	} else { ?>
									<tr >
									<td  <?php  if ($Tab_affectation_resultat->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold;  height:30px" '; }if ($Tab_affectation_resultat->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px; height:30px" ';}  ?>   ><?php echo $Tab_affectation_resultat->rubriques; ?></td>
									<td style="text-align:right; padding-right: 5px;" ></td>
								</tr>
							<?php }} ?>
								
							</table>

								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 15px;" >
								
								<div class="col-xs-7 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										11/ Tableau des participations (filiales et entités associées) :

										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
						</div>
						<br>
							
							<table border="1" width="100%"  >
								<tr class="badr">
									<td align="center" width="15%" ><b>Filiales et entités <br> associées </b></td>
									<td align="center"  ><b>Capitaux <br> propres </b></td>
									<td align="center" width="12%"  ><b>Dont <br> capital</b></td>
									<td align="center"  ><b>Quote-part <BR>de capital<br> détenu %</b></td>
									<td align="center" ><b>Résultat <br> Dernier <br> exercice </b></td>
									<td align="center"  ><b>Prêts et <br>avances <br> accordées </b></td>
									<td align="center"  ><b>Dividendes <br> encaissés</b></td>
									<td align="center"  ><b>Valeur<br> comptable<br> des titres<br> détenus</b></td>
								</tr>
								<tr class="badr">
									<td class="bilan-td-title" style="text-align:center;height: 30px;"> <u>Filiales :</u> </td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr class="badr">
									<td class="bilan-td-title" style="text-align:center;height: 30px;"> <u>Entités associées</u> </td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								</table>

					</div>
				</div>
			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" style="MARGIN-TOP: 20PX;  padding-top:0px; " > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-8 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										10/ Tableau d’affectation du résultat et des réserves (N-1) :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive" >
						<table border="1" width="100%"  bordercolor="#FF0000" >
								
								<tr >
									<td width="20%" align="center" style="border-top: solid 1px #FFF;border-left: solid 1px #FFF;" ></td>
									<td width="40%" align="center" style="border-top: solid 1px #FFF;border-left: solid 1px #FFF;" ></td>
									<td class="miloud" align="center" ><b>Montants</b></td>
								</tr>
								<?php
								$Tab_affectation_resultats= Tab_affectation_resultat::trouve_tous();
								 foreach ($Tab_affectation_resultats as $Tab_affectation_resultat) {
								if ($Tab_affectation_resultat->id == 1 or $Tab_affectation_resultat->id == 5) { ?>
								<tr>
									<td  class="bilan-td miloud" style="padding-left:10px; text-align:center;" <?php if ($Tab_affectation_resultat->id == 1 ) { echo 'rowspan="4"';} else{ echo 'rowspan="5"';}  ?>  > <?php  echo $Tab_affectation_resultat->father_rubriques; ?></td>							
									<td  <?php  if ($Tab_affectation_resultat->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold; height:30px" '; }if ($Tab_affectation_resultat->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px;  height:30px;" ';}  ?>   ><?php echo $Tab_affectation_resultat->rubriques; ?></td>
									<td>&nbsp;</td>
								</tr>
									
								<?php	} else { ?>
									<tr >
									<td  <?php  if ($Tab_affectation_resultat->is_total == 1) { echo ' style="padding-right:10px; text-align:right ;font-weight: bold;  height:30px" '; }if ($Tab_affectation_resultat->is_bold == 1) { echo 'class="bilan-td-title" style="padding-left:10px; text-align:left;" '; } else{ echo ' class="bilan-td" style="padding-left:10px; height:30px" ';}  ?>   ><?php echo $Tab_affectation_resultat->rubriques; ?></td>
									<td style="text-align:right; padding-right: 5px;" ></td>
								</tr>
							<?php }} ?>
							</table>

								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 15px;" >
								
								<div class="col-xs-8 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										11/ Tableau des participations (filiales et entités associées) :
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
						</div>
						<br>
							
							<table border="1" width="100%"  bordercolor="#FF0000">
								<tr class="miloud">
									<td align="center" width="15%" ><b>Filiales et entités <br> associées </b></td>
									<td align="center"  ><b>Capitaux <br> propres </b></td>
									<td align="center" width="12%"  ><b>Dont <br> capital</b></td>
									<td align="center"  ><b>Quote-part <BR>de capital<br> détenu %</b></td>
									<td align="center" ><b>Résultat <br> Dernier <br> exercice </b></td>
									<td align="center"  ><b>Prêts et <br>avances <br> accordées </b></td>
									<td align="center"  ><b>Dividendes <br> encaissés</b></td>
									<td align="center"  ><b>Valeur<br> comptable<br> des titres<br> détenus</b></td>
								</tr>
								<tr class="miloud">
									<td class="bilan-td-title" style="text-align:center;height: 30px;"> <u>Filiales :</u> </td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr class="miloud">
									<td class="bilan-td-title" style="text-align:center;height: 30px;"> <u>Entités associées</u> </td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								</table>

					</div>

				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>

			</div>

				</div>
			</div>
		</page>
		<!-- END annexe 7-->
						<!-- DEBUT ANNEXE 8-->
				<?PHP
						 }else if($action =="etat_annexe_8") {
				$thisday=date('Y-m-d');
				?>
		
				<page size="A4" style="height: 290mm;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px ; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-12 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 15px;">
								12/ Commissions et courtages, redevances, honoraires, sous-traitance, rémunérations diverses et frais de siège :
										
									</p>
									
								</div>
								
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table border="1" width="100%"  >
								
								<tr class="badr">
									<td align="center" width="25%" ><b>Désignation des personnes bénéficiaires</b></td>
									<td align="center" width="25%" ><b>Numéro d’identifiant fiscal</b></td>
									<td align="center" width="25%" ><b>Adresse</b></td>
									<td align="center" width="25%" ><b>Montant perçu</b></td>
								</tr>
								
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
							</table>

								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 15px;" >
								
								<div class="col-xs-5 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										13/ Taxe sur l’activité professionnelle :
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
						</div>
						<br>
							
							<table border="1" width="100%"  >
								<tr class="badr">
									<td align="center" width="25%"><b>Lieu de payement de la TAP </b></td>
									<td align="center" width="25%" ><b>Chiffre d’affaires<br> imposable <br> Par commune</b></td>
									<td align="center" width="25%" ><b>Chiffre d’affaires exonéré</b></td>
									<td align="center" width="25%" ><b>TAP acquittée</b></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								</table>

					</div>
				</div>
			</div>

				</div>
			</div>
		</page>
					<page size="A4-2" style="MARGIN-TOP: 20PX;  padding-top:0px; " > 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE A L’ADMINISTRATION</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" bordercolor="#FF0000">
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; " bordercolor="#FF0000">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_db); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($date_fin); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
								<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-12 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 15px;">
							12/ Commissions et courtages, redevances, honoraires, sous-traitance, rémunérations diverses et frais de siège :
									</p>
								</div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive" >
						<table border="1" width="100%"  bordercolor="#FF0000" >
								
								<tr class="miloud">
									<td align="center" width="25%" ><b>Désignation des personnes bénéficiaires</b></td>
									<td align="center" width="25%" ><b>Numéro d’identifiant fiscal</b></td>
									<td align="center" width="25%" ><b>Adresse</b></td>
									<td align="center" width="25%" ><b>Montant perçu</b></td>
								</tr>
								
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td style="text-align:right; padding-right: 5px;" height="30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
							</table>

								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 15px;" >
								
								<div class="col-xs-6 ">
									<p class="miloud" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										13/ Taxe sur l’activité professionnelle :
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
						</div>
						<br>
							
							<table border="1" width="100%"  bordercolor="#FF0000">
								<tr class="miloud">
									<td align="center" width="25%"><b>Lieu de payement de la TAP </b></td>
									<td align="center" width="25%" ><b>Chiffre d’affaires<br> imposable <br> Par commune</b></td>
									<td align="center" width="25%" ><b>Chiffre d’affaires exonéré</b></td>
									<td align="center" width="25%" ><b>TAP acquittée</b></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								<tr>
									<td class="bilan-td-title" style="text-align:center;height: 30px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
									<td style="text-align:right; padding-right: 5px;"></td>
								</tr>
								</table>

					</div>

				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					</div>
				</div>

			</div>

				</div>
			</div>
		</page>
		<!-- END annexe 8-->
		<?php } else if($action =="etat_grand_livre") {
				$thisday=date('Y-m-d');
				?>
					<div class="portlet light " >
					<div class="portlet-body">
				<div class="invoice " >
					<div class="page-header">
							<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-8 ">
									<p style="text-align: left ; font-size: 14px;" >Entreprise : <small><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?></small>
									<br>Adresse : <small><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?></small>
									<br>Exercice : <small></small>
									</p>
								</div>
								<div class="col-xs-4">
									<p style="text-align: left ; font-size: 14px;">
										 R.C.N° : <small><?php if (isset($nav_societe->Rc)){echo $nav_societe->Rc ;} ?></small>
										<br> Mat. Fisc : <small><?php if (isset($nav_societe->Mf)){echo $nav_societe->Mf ;} ?></small>
										<br> Art. Impo : <small><?php if (isset($nav_societe->Ai)){echo $nav_societe->Ai ;} ?></small>
										
									</p>
									
								</div>
							</div>
							<hr style="margin: 0px 0px 15px 0px;" />
							<div class="row invoice-logo" style="margin-bottom: 0px;" >
								
								<div class="col-xs-12">
									<p style="text-align: center ;">
										GRAND LIVRE
										
									</p>
									
								</div>
							</div>
					</div>
					<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 16px;" >Du : <small><?php  echo fr_date3($date_db ).' Au : '.fr_date3($date_fin) ;  ?></small>
									<br>Du compte : <small> 100 Au compte : 899</small>
									
									</p>
								</div>
								<div class="col-xs-3">
									<p style="text-align: left ; font-size: 16px;">
										 Date : <small><?php echo fr_date3($thisday); ?></small>
										<br> N° Page : <small><?php ?></small>
										
										
									</p>
									
								</div>
							</div>
				

				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table class="table   table-hover"  style="font-size: 12px;">
							<thead>
							
							<tr>
								
								
								<th >
									Date
								</th>
								<th >
									Journal
								</th>
								<th >
									  Libellé
								</th>
								<th >
									Pièce
								</th>
								<th >
									  Déblit
								</th>
								<th >
									Crédit
								</th>
								<th >
									  Solde
								</th>
								
								
								
							</tr>
							</thead>
							
							<tbody>
								<?php	$total_count=0;
								 for ($i=1; $i <=7; $i++) {  
	 $total_count += $nbr =  Ecriture_comptable::count_row_balance_periode($nav_societe->id_societe,$i,$date_fin); 
	$Ecriture_comptables = Ecriture_comptable::trouve_balance_date_fin_par_societe($nav_societe->id_societe,$i,$date_fin);		
					 foreach ($Ecriture_comptables as $Ecriture_comptable) {
	$solde_anterieur =0;
	$Debit_credit_periode = Ecriture_comptable::calcul_debit_credit_balance_periode($Ecriture_comptable->id_compte,$date_db,$date_fin);
	$Debit_credit_periode_anterieur = Ecriture_comptable::calcul_debit_credit_balance_periode_anterieur($Ecriture_comptable->id_compte,$date_db);
	$Ecriture_compts = Ecriture_comptable::trouve_ecriture_periode_par_id_compte($Ecriture_comptable->id_compte,$nav_societe->id_societe,$date_db,$date_fin);
	$nbr_ecriture = Ecriture_comptable::count_row_Grand_livre_periode($Ecriture_comptable->id_compte,$nav_societe->id_societe,$date_db,$date_fin);
					 	if ($nbr_ecriture>0) {
					 	?> 
					 		<tr class="active">
					 			<th>Compte</th>
					 			<th><?php echo $Ecriture_comptable->code_comptable; ?></th>
								<th><?php $Compte_comp = Compte_comptable::trouve_par_id($Ecriture_comptable->id_compte);
								if (isset($Compte_comp->libelle)) { echo  $Compte_comp->libelle;}?> </th>
					 			<th ></th>
					 			<th colspan="2" style="text-align:center;">Solde de Départ : </th>
					 			<th><?php if (isset($Debit_credit_periode_anterieur->debit)) { $solde_anterieur = $Debit_credit_periode_anterieur->debit - $Debit_credit_periode_anterieur->credit;
					 				echo number_format($solde_anterieur,2,',',' '); } else{ echo '0.00';}  ?></th>
					 		</tr>
					 		<?php
					 		$nb_line =0;
					 		$solde =0;
					 		 foreach ($Ecriture_compts as $Ecriture_compt) { $nb_line++;  ?>
							<tr class="item-row" >
								<td> <?php echo fr_date3($Ecriture_compt->date); ?></td>
								<td><?php $Journal = Journaux::trouve_par_id($Ecriture_compt->journal);
									if (isset($Journal->intitule)) { echo $Journal->intitule;};  ?></td>
								<td><?php echo $Ecriture_compt->lib_piece; ?></td>
								<td><?php echo $Ecriture_compt->ref_piece; ?></td>
								<td><?php echo number_format($Ecriture_compt->debit,2,',',' '); ?></td>
								<td><?php echo number_format($Ecriture_compt->credit,2,',',' '); ?></td>
								<td><?php   if ($nb_line == 1) {$solde = $solde_anterieur + $Ecriture_compt->somme_debit;} else{
										$solde = $solde + $Ecriture_compt->somme_debit;} echo number_format($solde,2,',',' '); ?></td>
							</tr>
						<?php } unset($solde_anterieur);  ?>
							<tr>
								<th colspan="4" style="text-align:right;">Total compte  <?php echo $Ecriture_comptable->code_comptable; ?></th>
								<th><?php if (isset($Debit_credit_periode->debit) ) { echo number_format($Debit_credit_periode->debit, 2, ',', ' ') ;}  ?></th>
								<th><?php if (isset($Debit_credit_periode->credit) ) { echo number_format($Debit_credit_periode->credit, 2, ',', ' ') ;}  ?></th>
								<th></th>
							</tr>
							<tr>
								<th colspan="4" style="text-align:right;">Solde de la Période :</th>
								<th></th>
								<th></th>
								<th><?php if (isset($Debit_credit_periode->debit)) {
					 				echo number_format($Debit_credit_periode->debit - $Debit_credit_periode->credit,2,',',' '); } else{ echo '0.00';}  ?></th>
							</tr>
							<tr class="active">
								<th colspan="4" style="text-align:right;">Solde Final :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th></th>
								<th></th>
								<th><?php echo number_format($Ecriture_comptable->debit,2,',',' '); ?></th>
							</tr>
							<tr>
								<td colspan="7"></td>
							</tr>

						<?php } }     }     ?>
 
                            </tbody>
							</table>
							

					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br/>
						<?php if ($total_count>0) {?>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer 
						</a>
					<?php } else { ?>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" disabled >
						 <i class="fa fa-print"></i> Imprimer
						</a>
					<?php } ?>
					</div>
				</div>
			</div>
				</div>
			</div>
		<?php } else if($action =="Bilan_actif") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>BILAN ACTIF 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut BILAN ACTIF -->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_Bilan_actif" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
	<!-- debut Annexe 2 -->
 <?php  }	 else if($action =="annexe_2") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>ANNEXE 2 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut BILAN ACTIF -->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_annexe_2" method="POST" class="form-horizontal">

										<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
	<!-- debut Annexe 3 -->
 <?php  }	 else if($action =="annexe_3") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>ANNEXE 3 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut BILAN ACTIF -->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_annexe_3" method="POST" class="form-horizontal">

										<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
	<!-- debut Annexe 4 -->
 <?php  }	 else if($action =="annexe_4") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>ANNEXE 4 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut BILAN ACTIF -->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_annexe_4" method="POST" class="form-horizontal">

										<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
	<!-- debut Annexe 5 -->
 <?php  }	 else if($action =="annexe_5") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>ANNEXE 5 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut BILAN ACTIF -->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_annexe_5" method="POST" class="form-horizontal">

										<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
	<!-- debut Annexe 6 -->
 <?php  }	 else if($action =="annexe_6") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>ANNEXE 6 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut BILAN ACTIF -->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_annexe_6" method="POST" class="form-horizontal">

										<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
	<!-- debut Annexe 7 -->
 <?php  }	 else if($action =="annexe_7") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>ANNEXE 7 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut BILAN ACTIF -->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_annexe_7" method="POST" class="form-horizontal">

											<<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
	<!-- debut Annexe 8 -->
 <?php  }	 else if($action =="annexe_8") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>ANNEXE 8 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut BILAN ACTIF -->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_annexe_8" method="POST" class="form-horizontal">

										<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
	<!-- debut BILAN PASSIF -->
			<?php } else if($action =="Bilan_passif") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>BILAN PASSIF 
							</div>
						</div>
					<div class="portlet-body">
					
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_Bilan_passif" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
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
	</div>
	<!-- END BILAN PASSIF -->
	<!-- debut TCR -->
			<?php } else if($action =="tcr") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i>COMPTE DE RESULTAT (TCR) 
							</div>
						</div>
					<div class="portlet-body">
					
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_Bilan_tcr" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
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
	</div>
	<!-- END TCR -->
	<!-- debut mouvements_stocks -->
			<?php } else if($action =="mouvements_stocks") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-file-text"></i> Mouvements des stocks 
							</div>
						</div>
					<div class="portlet-body">
					
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_mouvements_stocks" method="POST" class="form-horizontal">

										<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
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
	</div>
	<!-- END mouvements_stocks -->
		<?php } else if($action =="grand_livre") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-book"></i>Grand livre 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut grand_livre-->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_grand_livre" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut) ){ echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>														
											<div class="form-group">
													<label class="col-md-3 control-label">Date de fin</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin) ){ echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
												
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END Balanc -->
				</div>
			</div>
		</div>
	</div>
			<?php } else if($action =="recherche_ecriture") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa fa-search font-yellow"></i>Recherche
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut recherche_ecriture-->
								
										<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
									
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="rapports.php?action=etat_recherche_ecriture" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="control-label col-md-3">Par Date <input type="checkbox" id="optionsRadios24" value="option1" onclick="EnableDisableTextBox()"> </label>
													
														<div class="input-group col-md-4 date-picker input-daterange" >
															<input type="date" name = "date_db" class="form-control" id="date1" required >
															<span class="input-group-addon">
															à </span>
															<input type="date" name = "date_fin" class="form-control" id="date2" required >
														</div>
														<!-- /input-group -->
													
												</div>														
												<div class="form-group">
													<label class="control-label col-md-3">Par Numéro <input type="checkbox" id="optionsRadios25" value="1" onclick="EnableDisableTextBox()"> </label>
													
													
														<div class="input-group col-md-4" >
														<input type="text" name = "id_piece" class="form-control" id="num1" disabled >
															<span class="input-group-addon">
															à </span>
																													
															<input type="text" name = "id_piece" class="form-control"  id="num2" disabled>
															
														</div>
														<!-- /input-group -->
														
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Par Début <input type="checkbox" id="optionsRadios26" value="option1" onclick="EnableDisableTextBox()"> </label>
													
														<div class="input-group col-md-4" >
															<input type="text" name = "debit" class="form-control" id="debit1" disabled>
															<span class="input-group-addon">
															à </span>
															<input type="text" name = "debit" class="form-control" id="debit2" disabled>
															
														</div>
														<!-- /input-group -->
											
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Par Credit <input type="checkbox" id="optionsRadios27" value="option1" onclick="EnableDisableTextBox()"> </label>
													
														<div class="input-group col-md-4" >
															<input type="text" name = "credit" class="form-control" id="credit1" disabled>
															<span class="input-group-addon">
															à </span>
															<input type="text" name = "credit" class="form-control" id="credit2" disabled>
														</div>
														<!-- /input-group -->
													
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Par Journal <input type="checkbox" id="optionsRadios28" value="option1" onclick="EnableDisableTextBox()"> </label>
													<div class="col-md-4">
														<select class="form-control select2me"    name="journal" id="id_Journal"  placeholder="Choisir journal" disabled >
															<option value=""></option>
														<?php $journaux = Journaux:: trouve_tous();
															foreach ($journaux as $journal) { ?>
																<option <?php if (isset($last_Ecriture->journal)) {
																		if ($last_Ecriture->journal == $journal->id) {echo "selected";}
																	} ?> value="<?php if(isset($journal->id)){echo $journal->id; } ?>"><?php if (isset($journal->id)) {echo $journal->intitule;} ?> </option>
																<?php } ?>	
																	   
														</select>
														<!-- /input-group -->
														
													</div>
												</div>
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn blue">Envoyer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
										
						</div>
					<!-- END recherche_ecriture -->
				</div>
			</div>
		</div>
	</div>
	<!-- BEGIN Ecritures Comptables-->
			<?php  

				}elseif ($action == 'etat_recherche_ecriture') {
					$Ecritures = Ecriture_comptable::recherche_par_1_attribue($date_db,$date_fin);
					$cpt=0;
					?>
			<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa fa-edit font-yellow"></i>Ecritures Comptables 
							</div>
						</div>
					
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr>
								<th>
									N° piece
								</th>
								<th>
									Date
								</th>
								<th>
									Référence
								</th>
								<th>
									Libellé
								</th>
								<th>
									Compte comptable
								</th>
								<th>
									Auxilière
								</th>
								<th>
									Débit
								</th>
								<th>
								 Crédit
								</th>
								<th>
									Journal
								</th>
								
							</tr>
							</thead>
							<tbody>
							<?php
								foreach($Ecritures as $ecriture){
									$cpt ++;
								?>
							<tr>
								<td>
									<a href="piece.php?id=<?php echo $ecriture->id_piece ?>" class="">
								<i class="fa fa-pencil font-yellow"></i>
									<b> <?php if (isset($ecriture->id_piece)) {
										// echo $piece->id;
									 echo sprintf("%04d", $ecriture->id_piece) ;
									} ?></b> <i class="fa fa-download font-blue"></i> </a>
								</td>
								<td>
									<?php if (isset($ecriture->date)) {
									echo fr_date2($ecriture->date);
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->ref_piece)) {
									echo $ecriture->ref_piece;
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->lib_piece)) {
									echo $ecriture->lib_piece;
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->code_comptable)) {
									echo $ecriture->code_comptable;
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->id_auxiliere)) {
										$Auxilieres = Auxiliere::trouve_par_id($ecriture->id_auxiliere);
										if(isset($Auxilieres->code)){
									echo $Auxilieres->code;
									}} ?>
								</td>
								<td>
									<?php if (isset($ecriture->debit)) {

									echo number_format($ecriture->debit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->credit)) {
									echo number_format($ecriture->credit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->journal)) {
									 $Journal = Journaux::trouve_par_id($ecriture->journal); 
									 if (isset($Journal->intitule)) {echo $Journal->intitule;}
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
 <?php	} } ?>
		
	</div>
	</div>
	
	<!-- END CONTENT -->


<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>