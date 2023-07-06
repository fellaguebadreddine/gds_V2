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


$titre = "ThreeSoft | Rapport ";
$active_menu = "Facturation";
$header = array('table','invoice','print');
if ($user->type == "administrateur"){
	if (isset($_GET['action']) && $_GET['action'] =='list_reglement' ) {
		$active_submenu = "reglement";
$action = 'list_reglement';
	}else if (isset($_GET['action']) && $_GET['action'] =='rapport_stat' ) {
		$active_submenu = "Rapports";
$action = 'rapport_stat';
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
if (isset($_POST['submit']) && $action == 'etat_balance') {
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
if (isset($_POST['submit']) && $action == 'etat_grand_livre') {
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
                        <?PHP
						   if ($action == 'get_rapport') {
						echo '<a href="rapport.php?action=rapport_stat">Rapport </a> ';
					
					}
                        if ($action == 'rapport_stat') {
						echo '<a href="rapport.php?action=rapport_stat">Rapport Par Date entre  : '. fr_date3($date_db) .' et '.fr_date3($date_fin) .'</a> ';
					
					}	 if ($action == 'etat_balance') {
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
							 if($action =="get_rapport" ) {
				
				?>
				<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->

			<div class="row">
				<div class="col-md-12">
					 
					
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="icon-magnifier"></i>RAPPORT 
							</div>
						</div>

							
						<div class="portlet-body">
					<!-- debut rapport-->
								
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
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=rapport" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="2018-07-22" required >
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
															<input type="date" name = "date_fin" class="form-control" value ="13/05/<?php echo date("Y"); ?>" required >
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
									<?php if($action =="rapport_stat") {
										?>
										
							<table class="table table-striped  table-hover " id="">
							<thead>
							<tr>
								
								<th>
									N° de facture
								</th>
								<th>
									date
								</th>
								<th>
									tiers
								</th>
								
								
								<th>
									Crédit
								</th>
								<th>
									Débit
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($facturess as $facture){
									
								?>
							<tr>
								
								
								<td>
								<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
										
									echo sprintf ("%04d", $facture->N_facture).'/'.$date['year']; } ?>
									
								</td>
								<td>
									<?php if (isset($facture->date_valid)) {
									echo $facture->date_valid;
									} ?>
								</td>
								<td>
									<?php if (isset($facture->id_client)) {
															$Clients = Client::trouve_client_par_id_client($facture->id_client);
															
															}
															foreach ($Clients as $client){
																
																	if (isset($client->nom)) {
															echo  $client->nom;}}?>
								</td>
								
							
								<td>
									<?php if (isset($facture->somme_ttc)) {
									echo $facture->somme_ttc;
									} ?>
								</td>
								<td>
								/	
								</td>
							</tr>

							<?php
								}
							?>
							<!-- compte fournisseur-->
							<?php
							
								foreach($factures as $facturee){
									
								?>
							<tr>
								
								<td>
								<?php if (isset($facturee->N_facture)) {
										$date = date_parse($facturee->date_fac);
										
									echo sprintf ("%04d", $facturee->N_facture).'/'.$date['year']; } ?>
									
								</td>
								<td>
									<?php if (isset($facturee->date_valid)) {
									echo $facturee->date_valid;
									} ?>
								</td>
								<td>
									 <?php if (isset($facturee->id_fournisseur)) {
															$fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facturee->id_fournisseur);
															
															}
															foreach ($fournisseurs as $fournisseur){
																
																	if (isset($fournisseur->nom)) {
															echo  $fournisseur->nom;}}?>
								</td>
								
								<td>
									/
								</td>
								<td>
									<?php if (isset($facturee->somme_ttc)) {
									echo $facturee->somme_ttc;
									} ?>
								</td>
							</tr>

							<?php
								}
							?>
							<tr>
							<td ><b>Solde initial &nbsp;  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							
							<td ><?php if (isset($nav_societe)) {
										$soldee = Compte::trouve_compte_par_societe($nav_societe->id_societe);
										
									  } foreach($soldee as $soldes){
										  if (isset ($soldes->solde))
									echo  $soldes->solde;
									  }?></td>
							</tr>
							<?php
							$c=0;
							foreach($facturess as $facture){
								$c += $facture->somme_ttc; 
							
							 }
							 
							?>
							
							<tr>
							<td ><b>Total  credit  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							
							<td ><?php   echo '<b> ' . $c . '  </b>';?></td>
							<td >&nbsp;</td>
							
							
							</tr>
							<?php
							$f=0;
							foreach($factures as $facturee){
								$f += $facturee->somme_ttc; 
							
							 }
							
							 ?>
							<tr>
							<td ><b>Total  debit  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							
							<td ><?php   echo '<b> ' . $f . '  </b>';?></td>
							</tr>
							
							<?php
							$c=0;
							foreach($facturess as $facture){
								$c += $facture->somme_ttc; 
							
							 }
							 $cc = $c + $soldes->solde;
							?>
							<?php
							$f=0;
							foreach($factures as $facturee){
								$f += $facturee->somme_ttc; 
							
							 }
							
							 ?>
							<tr>
							<td ><b>Total  &nbsp;  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							<td ><?php $stol = $cc - $f;  echo '<b> ' . $stol . ' DA </b>';?></td>
							</tr>
						
							</tbody>
							
							</table>
							<div class=" invoice-block">
						<?php if (!empty($factures)) {?>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer
						</a>
						<?php }?>
						</div>
					<?php }?>
								

					 
				
			<!-- end rapport-->
						
						</div>
					</div>
                                          
					
				</div>
			
			</div>


		</div>


		</div>
			<?php } else if($action =="rapport") {
				$thisday=date('Y-m-d');
				?>
				<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->

			<div class="row">
				<div class="col-md-12">
					 
					
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				// $facturess = Facture_vente::trouve_facture_valide_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
											
						<div class="portlet-title">
							<div class="row invoice-logo" style="background-image: url(assets/image/header_paied.png);">
								<div class="col-md-6 invoice-logo-space">
								<h3>Rapport </h3>
								<p ><?php if (isset($nav_societe)){echo $nav_societe->Dossier ;}?></br>
								<?php if (isset($nav_societe)){echo $nav_societe->Adresse .' - '. $nav_societe->Postal.' , ' .$nav_societe->Ville ;}?></br>
								<?php if (isset($nav_societe)){echo $nav_societe->Mob1 ;}?></p>
									
								</div>
								
							</div>
							
							</div>
							<?php if (!empty($factures)) {?>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer
						</a>
						<?php }?>						

							
						<div class="portlet-body">
							<table class="table table-striped  table-hover " id="">
							<thead>
							<tr>
								
								<th>
									N° de facture
								</th>
								<th>
									date
								</th>
								<th>
									tiers
								</th>
								
								
								<th>
									Crédit
								</th>
								<th>
									Débit
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($facturess as $facture){
									
								?>
							<tr>
								
								
								<td>
								<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
										
									echo sprintf ("%04d", $facture->N_facture).'/'.$date['year']; } ?>
									
								</td>
								<td>
									<?php if (isset($facture->date_valid)) {
									echo $facture->date_valid;
									} ?>
								</td>
								<td>
									<?php if (isset($facture->id_client)) {
															$Clients = Client::trouve_client_par_id_client($facture->id_client);
															
															}
															foreach ($Clients as $client){
																
																	if (isset($client->nom)) {
															echo  $client->nom;}}?>
								</td>
								
							
								<td>
									<?php if (isset($facture->somme_ttc)) {
									echo $facture->somme_ttc;
									} ?>
								</td>
								<td>
								/	
								</td>
							</tr>

							<?php
								}
							?>
							<!-- compte fournisseur-->
							<?php
							// $factures = Facture_achat::trouve_facture_valide_par_societe($nav_societe->id_societe);
								foreach($factures as $facturee){
									
								?>
							<tr>
								
								<td>
								<?php if (isset($facturee->N_facture)) {
										$date = date_parse($facturee->date_fac);
										
									echo sprintf ("%04d", $facturee->N_facture).'/'.$date['year']; } ?>
									
								</td>
								<td>
									<?php if (isset($facturee->date_valid)) {
									echo $facturee->date_valid;
									} ?>
								</td>
								<td>
									 <?php if (isset($facturee->id_fournisseur)) {
															$fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facturee->id_fournisseur);
															
															}
															foreach ($fournisseurs as $fournisseur){
																
																	if (isset($fournisseur->nom)) {
															echo  $fournisseur->nom;}}?>
								</td>
								
								<td>
									/
								</td>
								<td>
									<?php if (isset($facturee->somme_ttc)) {
									echo $facturee->somme_ttc;
									} ?>
								</td>
							</tr>

							<?php
								}
							?>
							<tr>
							<td ><b>Solde initial &nbsp;  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							
							<td ><?php if (isset($nav_societe)) {
										$soldee = Compte::trouve_compte_par_societe($nav_societe->id_societe);
										
									  } foreach($soldee as $soldes){
										  if (isset ($soldes->solde))
									echo  $soldes->solde;
									  }?></td>
							</tr>
							<?php
							$c=0;
							foreach($facturess as $facture){
								$c += $facture->somme_ttc; 
							
							 }
							 
							?>
							
							<tr>
							<td ><b>Total  credit  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							
							<td ><?php   echo '<b> ' . $c . '  </b>';?></td>
							<td >&nbsp;</td>
							
							
							</tr>
							<?php
							$f=0;
							foreach($factures as $facturee){
								$f += $facturee->somme_ttc; 
							
							 }
							
							 ?>
							<tr>
							<td ><b>Total  debit  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							
							<td ><?php   echo '<b> ' . $f . '  </b>';?></td>
							</tr>
							
							<?php
							$c=0;
							foreach($facturess as $facture){
								$c += $facture->somme_ttc; 
							
							 }
							 $cc = $c + $soldes->solde;
							?>
							<?php
							$f=0;
							foreach($factures as $facturee){
								$f += $facturee->somme_ttc; 
							
							 }
							
							 ?>
							<tr>
							<td ><b>Total  &nbsp;  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							<td ><?php $stol = $cc - $f;  echo '<b> ' . $stol . ' DA </b>';?></td>
							</tr>
						
							</tbody>
							
							</table>
						
						</div >
						<div class=" invoice-block">
						<?php if (!empty($factures)) {?>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer
						</a>
						<?php }?>
						
						</div>
							  
                                          
					
				</div>
			
			</div>


		</div>


		</div>

		</div>
			<?php } else if($action =="etat_balance") {
				$thisday=date('Y-m-d');
				?>
					<div class="portlet light">
					<div class="portlet-body">
				<div class="invoice">
					<div class="page-header">
							<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 16px;" >Entreprise : <small><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?></small>
									<br>Adresse : <small><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?></small>
									<br>Exercice : <small></small>
									</p>
								</div>
								<div class="col-xs-3">
									<p style="text-align: left ; font-size: 16px;">
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
										BALANCE
										<span style="font-weight: 400; font-size: 14px;">
											Copie Provisoire
										</span>
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
						<table class="table   table-hover" >
							<thead>
							<tr>
								
								<th colspan="2" >
								</th>
								<th colspan="2" style="text-align: center;">
									  Soldes Antérieurs
								</th>
								<th colspan="2" style="text-align: center;">
									  Mouvements de la période
								</th>
								<th colspan="2" style="text-align: center;" >
									  Solde
								</th>

							</tr>
<tr>
								
								<th width="13%" >
									Compte
								</th>
								<th width="30%">
									 Intitulé du Compte
								</th>
								
								<th width="10%" style="text-align: center;">
									  Déblit
								</th>
								<th width="10%" style="text-align: center;">
									Crédit
								</th>
								<th width="10%" style="text-align: center;">
									  Déblit
								</th>
								<th width="10%" style="text-align: center;">
									Crédit
								</th>
								<th width="10%" style="text-align: center;">
									  Déblit
								</th>
								<th width="10%" style="text-align: center;">
									Crédit
								</th>
								
								
							</tr>
							</thead>
							
							<tbody>
								<?php
	$totalg_periode =  Ecriture_comptable::calcul_somme_total_balance_periode_par_societe($nav_societe->id_societe,$date_db,$date_fin); 			
	$totalg_periode_anterieur =  Ecriture_comptable::calcul_somme_total_balance_periode_anterieur_par_societe($nav_societe->id_societe,$date_db); 	
	$totalg_solde =  Ecriture_comptable::calcul_somme_total_solde_balance_par_societe($nav_societe->id_societe,$date_fin); 	
								 for ($i=1; $i <=7; $i++) {  
	$nbr =  Ecriture_comptable::count_row_balance_periode($nav_societe->id_societe,$i,$date_fin); 
	$Somme_periode =  Ecriture_comptable::calcul_somme_balance_periode_par_societe($nav_societe->id_societe,$i,$date_db,$date_fin); 
	$Somme_periode_anterieur =  Ecriture_comptable::calcul_somme_balance_periode_anterieur_par_societe($nav_societe->id_societe,$i,$date_db); 
	$Somme_solde =  Ecriture_comptable::calcul_somme_solde_balance_par_societe($nav_societe->id_societe,$i,$date_fin); 
	$Ecriture_comptables = Ecriture_comptable::trouve_balance_date_fin_par_societe($nav_societe->id_societe,$i,$date_fin);	
					 foreach ($Ecriture_comptables as $Ecriture_comptable) {
	$Debit_credit_periode = Ecriture_comptable::calcul_debit_credit_balance_periode($Ecriture_comptable->id_compte,$date_db,$date_fin);
	$Debit_credit_periode_anterieur = Ecriture_comptable::calcul_debit_credit_balance_periode_anterieur($Ecriture_comptable->id_compte,$date_db);?>
							<tr class="item-row" >
								<td><?php echo $Ecriture_comptable->code_comptable; ?></td>
								<td><?php $Compte_comp = Compte_comptable::trouve_par_id($Ecriture_comptable->id_compte);
									if (isset($Compte_comp->libelle)) { echo  $Compte_comp->libelle;}?> </td>
								<td style="text-align:right;"><?php if ($Debit_credit_periode_anterieur->debit >0) { echo number_format($Debit_credit_periode_anterieur->debit, 2, ',', ' ') ;}  ?></td>
								<td style="text-align:right;"><?php if ($Debit_credit_periode_anterieur->credit >0) { echo  number_format($Debit_credit_periode_anterieur->credit, 2, ',', ' ') ;} ?></td>
								<td style="text-align:right;"><?php if ($Debit_credit_periode->debit >0) { echo number_format($Debit_credit_periode->debit, 2, ',', ' ') ;}  ?></td>
								<td style="text-align:right;"><?php if ($Debit_credit_periode->credit >0) { echo  number_format($Debit_credit_periode->credit, 2, ',', ' ') ;} ?></td>
								<td style="text-align:right;"><?php if ($Ecriture_comptable->debit >0) { echo number_format($Ecriture_comptable->debit, 2, ',', ' ') ;}  ?></td>
								<td style="text-align:right;"><?php if ($Ecriture_comptable->credit >0) { echo  number_format($Ecriture_comptable->credit, 2, ',', ' ') ;} ?></td>	
							</tr>
						<?php } ?>
							<tr class="item-row" <?php if ($nbr == 0) { echo'style="display:none;"';} ?> >
								<td ><strong> Total Classe <?php echo $i; ?>  :  </strong></td>
								<td></td>
								<td style="text-align:right;"><strong><?php if (isset($Somme_periode_anterieur->somme_debit) && $Somme_periode_anterieur->somme_debit >0) {echo number_format($Somme_periode_anterieur->somme_debit, 2, ',', ' ') ;} ?></strong></td>

								<td style="text-align:right;"><strong><?php if (isset($Somme_periode_anterieur->somme_credit) && $Somme_periode_anterieur->somme_credit >0) {echo number_format($Somme_periode_anterieur->somme_credit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($Somme_periode->somme_debit) && $Somme_periode->somme_debit >0) {echo number_format($Somme_periode->somme_debit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($Somme_periode->somme_credit) && $Somme_periode->somme_credit >0) {echo number_format($Somme_periode->somme_credit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($Somme_solde->somme_debit) && $Somme_solde->somme_debit >0) {echo number_format($Somme_solde->somme_debit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($Somme_solde->somme_credit) && $Somme_solde->somme_credit >0) {echo number_format($Somme_solde->somme_credit, 2, ',', ' ') ;} ?></strong></td>
							</tr>
						<?php $total_count +=  $nbr;  }     ?>
							<tr>
								<td ><strong> Total Général : </strong></td>
								<td> </td>
								<td style="text-align:right;"><strong><?php if (isset($totalg_periode_anterieur->somme_debit)) {echo number_format($totalg_periode_anterieur->somme_debit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($totalg_periode_anterieur->somme_credit)) {echo number_format($totalg_periode_anterieur->somme_credit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($totalg_periode->somme_debit)) {echo number_format($totalg_periode->somme_debit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($totalg_periode->somme_credit)) {echo number_format($totalg_periode->somme_credit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($totalg_solde->somme_debit)) {echo number_format($totalg_solde->somme_debit, 2, ',', ' ') ;} ?></strong></td>
								<td style="text-align:right;"><strong><?php if (isset($totalg_solde->somme_credit)) {echo number_format($totalg_solde->somme_credit, 2, ',', ' ') ;} ?></strong></td>
							</tr>
								
							   
							   
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
		<?php } else if($action =="balance") {
				
				?>
				
		<div class="row">
				<div class="col-md-12">
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="icon-magnifier"></i>Balance 
							</div>
						</div>
					<div class="portlet-body">
					<!-- debut balance-->
								
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
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_balance" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Date de Debut</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php echo date("Y"); ?>-01-01" required >
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
															<input type="date" name = "date_fin" class="form-control" value="<?php echo date("Y"); ?>-12-31" required >
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
															<input type="date" name = "date_db" class="form-control" value="<?php echo date("Y"); ?>-01-01" required >
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
															<input type="date" name = "date_fin" class="form-control" value="<?php echo date("Y"); ?>-12-31" required >
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
													<label class="control-label col-md-3">Par montant <input type="checkbox" id="optionsRadios26" value="option1" onclick="EnableDisableTextBox()"> </label>
													
														<div class="input-group col-md-4" >
															<input type="text" name = "debit" class="form-control" id="montant1" disabled>
															<span class="input-group-addon">
															à </span>
															<input type="text" name = "debit" class="form-control" id="montant2" disabled>
															
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
 <?php	}} ?>
		
	</div>
	</div>
	</div>
	
	<!-- END CONTENT -->
<script type="text/javascript">
    function EnableDisableTextBox() {
        var optionsRadios24 = document.getElementById("optionsRadios24");
		var optionsRadios25 = document.getElementById("optionsRadios25");
		var optionsRadios26 = document.getElementById("optionsRadios26");
		var optionsRadios27 = document.getElementById("optionsRadios27");
		var optionsRadios28 = document.getElementById("optionsRadios28");
        var date1 = document.getElementById("date1");
		var date2 = document.getElementById("date2");
		var num1 = document.getElementById("num1");
		var num2 = document.getElementById("num2");
		var montant1 = document.getElementById("montant1");
		var montant2 = document.getElementById("montant2");
		
		var id_Journal = document.getElementById("id_Journal");
        date1.disabled = optionsRadios24.checked ? false : true;
        if (!date1.disabled) {
            date1.focus();
        }
		date2.disabled = optionsRadios24.checked ? false : true;
        if (!date2.disabled) {
            date2.focus();
        }
		num1.disabled = optionsRadios25.checked ? false : true;
        if (!num1.disabled) {
            num1.focus();
        }
		num2.disabled = optionsRadios25.checked ? false : true;
        if (!num2.disabled) {
            num2.focus();
        }
		montant1.disabled = optionsRadios26.checked ? false : true;
        if (!montant1.disabled) {
            montant1.focus();
        }
		montant2.disabled = optionsRadios26.checked ? false : true;
        if (!montant2.disabled) {
            montant2.focus();
        }
		
		id_Journal.disabled = optionsRadios28.checked ? false : true;
        if (!id_Journal.disabled) {
            id_Journal.focus();
        }
    }
</script>

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>