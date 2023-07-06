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


$titre = "ThreeSoft | Etat 104 ";
$active_menu = "Facturation";
$header = array('table','invoice','print');
if ($user->type == "administrateur"){
	if (isset($_GET['action']) && $_GET['action'] =='etat_104' ) {
		$active_submenu = "etat_104";
        $action = 'etat_104';}	
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
                    
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
			 if($action =="etat_104" ) {
		?>
        			<div class="row">
				<div class="col-md-12">				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
					if (isset($_POST['submit']) ) {
				
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$etats_104 = Facture_vente::trouve_etat_104_par_societe($nav_societe->id_societe,$date_db,$date_fin);

				
				}else{			 
					$etats_104 = Facture_vente::trouve_etat_104_par_societe($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}
					
				$cpt = 0; ?>

				<div class="row">
				<div class="col-md-12 ">
				<div class="notification"></div>		

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered ">
						
						<div class="portlet-title">
							
							<div class="col-md-8 caption  bold">
								<i class="fa  fa-file-text font-yellow"></i>Etat 104  
							</div>
							
						</div>
						<div class="table-toolbar">
							<div class="row">
									
								
									<div class="col-md-8">										
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_104" method="POST" class="form-horizontal">

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
									<div class="col-md-4 bold">Etat 104 <?php if (isset($date_db) and isset($date_fin)){echo 'Du :'.fr_date2($date_db) .' au :'.fr_date2($date_fin);}?></div>
								</div>
                            </div>
							
						<div class="portlet-body">
							<table class="table table-striped  table-hover" id="">
							<thead>
							<tr>
								
								<th>
								RAISON SOCIAL
								</th>
								<th>
								ADRESSE 
								</th>
								<th>
								REG-COM
								</th>
								<th>
								N D'ARTICLE
								</th>
								<th>
								NIF
								</th>
								<th>
									HT
								</th>
								
								<th>
									TVA
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($etats_104 as $etat_104){
									$cpt ++;
								?>
							<tr  id="fact_<?php echo $etat_104->id_facture; ?>">
								
								
								<td>
									<?php if (isset($etat_104->id_client)) {
										$client = Client::trouve_par_id($etat_104->id_client);
										if (isset($client->nom)) {
											echo $client->nom;}
									}?>
								</td>
								<td>								
									<?php if (isset($etat_104->id_client)) {
										$client = Client::trouve_par_id($etat_104->id_client);
										if (isset($client->Adresse)) {
											echo $client->Adresse;}
									}?>
								</td>
								<td>
									<?php if (isset($etat_104->id_client)) {
										$client = Client::trouve_par_id($etat_104->id_client);
										if (isset($client->Rc)) {
											echo $client->Rc;}
									}?>
								</td>
								<td>
									<?php if (isset($etat_104->id_client)) {
										$client = Client::trouve_par_id($etat_104->id_client);
										if (isset($client->Ai)) {
											echo $client->Ai;}
									}?>
								</td>
								<td>
									<?php if (isset($etat_104->id_client)) {
										$client = Client::trouve_par_id($etat_104->id_client);
										if (isset($client->Mf)) {
											echo $client->Mf;}
									}?>
								</td>
								<td>
									<?php if (isset($etat_104->somme_ht)) {
									$total_somme_ht +=$etat_104->somme_ht;
									echo number_format($etat_104->somme_ht , 2, ',', ' ');
									} ?>
								</td>
								
								<td>
									<?php if (isset($etat_104->somme_tva)) {
										$total_somme_tva +=$etat_104->somme_tva;
									echo number_format($etat_104->somme_tva , 2, ',', ' ');
									} ?>
								</td>
								
							</tr>

							<?php
								}
							?>
							
						
							</tbody>
							<tbody>
								<td colspan="4"></td>
								<td > <span style="float : left;   font-size: 18px; ;"><strong> TOTAUX: </strong></span></td>
								<td>  <strong><?php echo number_format($total_somme_ht , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_tva , 2, ',', ' '); ?></strong></td>								
								
							</tbody>
							
							</table>
							
						</div>
					
								<div class="portlet-body ">						
									<br>
									<div class="col-md-10"></div>
									<div class=""><a class="btn btn-sm blue hidden-print" onclick="javascript:window.print();"><i class="fa fa-print"></i> Imprimer </a></div>				
								</div>
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