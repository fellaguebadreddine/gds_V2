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


$titre = "ThreeSoft | Reglement ";
$active_menu = "Facturation";
$header = array('table');
if ($user->type == "administrateur"){
	if (isset($_GET['action']) && $_GET['action'] =='list_reglement' ) {
		$active_submenu = "reglement";
$action = 'list_reglement';
	}else if (isset($_GET['action']) && $_GET['action'] =='reglement_fournisseur' ) {
		$active_submenu = "reglement";
$action = 'reglement_fournisseur';
	}else if (isset($_GET['action']) && $_GET['action'] =='reglement_client' ) {
		$active_submenu = "reglement";
$action = 'reglement_client';
	}else if (isset($_GET['action']) && $_GET['action'] =='affiche_reglemnt_client' ) {
		$active_submenu = "reglement";
$action = 'affiche_reglemnt_client';
	}else if (isset($_GET['action']) && $_GET['action'] =='affiche_reglemnt_fournisseur' ) {
		$active_submenu = "reglement";
$action = 'affiche_reglemnt_fournisseur';
	}else if (isset($_GET['action']) && $_GET['action'] =='etat_compte' ) {
		$active_submenu = "reglement";
$action = 'etat_compte';
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
$thisday=date('Y-m-d');
?>

<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper ">
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
                        
                        <a href="reglement.php?action=list_reglement">reglement</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
							if ($action == 'list_reglement') {
								require_once("header/menu-reglement.php");
				
				?>
				<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$factures = Facture_vente::trouve_facture_valide_par_societe_client($nav_societe->id_societe); 
				$cpt = 0; ?>

		<div class="row profile">
				<div class="col-md-12">
				
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">

							
						<div class="portlet-body">
						   <div class="row">
                                 <div class="col-md-6">
											<div class="well">
                                                Factures clients  (vente)
                                                
                                            </div>
							<div class="table-scrollable table-scrollable-borderless">
                         <table class="table table-striped  table-hover ">
							<thead>
							<tr>
								
								<th>
									N° Facture
								</th>
								<th>
									Date facture
								</th>
								<th>
									Client
								</th>
								<th>
									Total TTC
								</th>
								<th>
									Etat
								</th>

								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr>
								<?php if ($cpt <=5){?>
								
								<td>
								<i class="fa fa-file-text-o bg-yellow"></i>
								<a href="invoice.php?id=<?php echo $facture->id_facture; ?>" >
									<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?>
									
                                                    <i class="fa fa-download"></i> </a>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								<td>
								<i class="fa  fa-building font-yellow "></i>
									<?php if (isset($facture->id_client)) {
															$Clients = Client::trouve_client_par_id_client($facture->id_client);
															
															}
															foreach ($Clients as $client){
																
																	if (isset($client->nom)) {
															echo $client->nom;}}?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
									echo $facture->somme_ttc;
									} ?>
								</td>
								<td>
								
                                     <i class="fa fa-circle font-green-jungle"></i>
                                 
								</td>
								<?php }?>
							</tr>

							<?php
								}
							?>
							<?php
							$a=0;
							foreach ( $factures as $vent){
								$a += $vent->somme_ttc; 
							
							 }
							 
							 ?>
							<tr>
							<td colspan="2">Total &nbsp; (Montant restant à percevoir ) </td>
							<td>&nbsp;</td>
							<td ><?php echo  $a . ' DA';?></td>
							<td >&nbsp;</td>
							
							</tr>
						
							</tbody>
							
							</table>
                                    </div>
											</div>
							
                          <div class="col-md-6">
											<div class="well">
                                                Statistiques
												</div>
												<div class="table-scrollable table-scrollable-borderless">
                             <table class="table table-striped table-hover ">
                                    
							<tbody>
								
							<tr>
							
								<td>
									<a href="operation.php?action=list_achat" class="">
									Factures fournisseur
									</a>
								</td>
							
								<td>
									 <?php 	
							
							 $nbr_factNpay = count($table_ch = Facture_achat::trouve_facture_par_societe($nav_societe->id_societe));
								echo   $nbr_factNpay ;  
							 							 
							 ?>
							
								</td>
								<td>
								<i class="fa fa-circle font-green-jungle"></i>
								</td>
							</tr>
							
							<tr>
							
								<td>
									<a href="operation.php?action=list_vente" class="">
									Factures  client
									</a>
								</td>
							
								<td>
									 <?php 	
							
							 $nbr_factNpay = count($table_ch = Facture_vente::trouve_facture_par_societe($nav_societe->id_societe));
								echo   $nbr_factNpay ;  
							 							 
							 ?>
								
							
								</td>
								<td>
								<i class="fa fa-circle font-green-jungle"></i>
								</td>
							</tr>
							
							<tr>

								<td>
								
									Total  
								
								</td>
								<td>
								
									
								</td>
								<td>
								
								</td>
							</tr>

							
						
							</tbody>
                                        </table>
                                    </div>
                     </div>
					 <div class="col-md-6"><?php

				$factur = Facture_achat::trouve_facture_valide_par_societe_fournisseur($nav_societe->id_societe); 
				$cptt = 0; ?>
									<div class="well">
                                                Factures fournisseur (achat) 
                                                
                                            </div>

							<table class="table table-striped  table-hover " >
							<thead>
							<tr>
								
								<th>
									N° Facture
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
									Etat
								</th>

							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factur as $facture){
									$cptt ++;
								?>
							<tr>
								<?php if ($cptt <=5){?>
								<td>
									<i class="fa fa-file-text-o bg-yellow"></i>
									<a href="invoce_achat.php?id=<?php echo $facture->id_facture; ?>">
									<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									

									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?>
									
                                                    <i class="fa fa-download"></i> </a>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
									
								</td>
								<td>
								<i class="fa  fa-building font-yellow "></i>
									<?php if (isset($facture->id_fournisseur)) {
															$fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($fournisseurs as $fournisseur){
																
																	if (isset($fournisseur->nom)) {
															echo $fournisseur->nom;}}?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
									echo $facture->somme_ttc;
									} ?>
								</td>
								<td>
								
                                     <i class="fa fa-circle font-green-jungle"></i>
                                
								</td>
								<?php }?>
							</tr>
							
							<?php
								}
							?>
							<?php
							$a=0;
							foreach ( $factur as $vent){
								$a += $vent->somme_ttc; 
							
							 }
							 
							 ?>
							<tr>
							<td colspan="2">Total &nbsp; ( Reste à payer) </td>
							<td>&nbsp;</td>
							<td ><?php echo  $a . ' DA';?></td>
							<td >&nbsp;</td>
							
							</tr>
									
							</tbody>
							
							</table>
							</div>
                                        </div>

						
						</div>
					</div>
                                          
					
				</div>
			
			</div>


		</div>

					
			
			<?php } else if($action =="reglement_fournisseur") {
				require_once("header/menu-reglement.php");
				?>
				<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->

			<div class="row">
				<div class="col-md-12">
					 
					
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$factures = Facture_achat::trouve_facture_valide_par_societe_fournisseur($nav_societe->id_societe); 
				$cpt = 0; ?>

						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-file-text font-yellow"></i>Règlements fournisseurs (achat)  
							</div>
						</div>
						

							
						<div class="portlet-body">
							<table class="table table-striped  table-hover " id="sample_2">
							<thead>
							<tr>
								
								<th>
									N° de facture
								</th>
								<th>
									date
								</th>
								<th>
									fournisseur
								</th>
								
								<th>
									Compte
								</th>

								<th>
									mode_paiment
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
								<i class="fa  fa-credit-card font-yellow "></i> Règlement fournisseur
									
								</td>
								<td>
									<?php if (isset($facture->date_valid)) {
									echo $facture->date_valid;
									} ?>
								</td>
								<td>
									<?php if (isset($facture->id_fournisseur)) {
															$fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($fournisseurs as $fournisseur){
																
																	?>
															<a href="reglement.php?action=affiche_reglemnt_fournisseur&id=<?php if (isset ($fournisseur->nom) ){echo $fournisseur->id_fournisseur;} ?> " > <b><?php  if (isset ($fournisseur->nom) ){echo  $fournisseur->nom ;}?></b></a>
															<?php }?>
								</td>
								
								<td>
								<?php if (isset($Fact->id_facture)) {
										$fournisseur = Fournisseur::trouve_par_id($Fact->id_fournisseur);
									}  ?>
								 <?php if (isset($fournisseur->NCompte)) {
									echo  '<i class="fa  fa-bank font-yellow "></i> '. $fournisseur->NCompte;
								} ?>
								</td>
								
								<td>
									<?php if (isset($facture->mode_paiment)) {
									echo $facture->mode_paiment;
									} ?>
									
								</td>
								
								
							</tr>

							<?php
								}
							?>
							<?php
							$a=0;
							foreach($factures as $facture){
								$a += $facture->somme_ttc; 
							
							 }?>
							<tr>
							<td ><b>Total Factures &nbsp;  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							<td ><?php echo '<b> ' . number_format($a , 2, ',', ' ') . ' DA </b>';?></td>
							</tr>
						
							</tbody>
							
							</table>
						
						</div>
					</div>
                                          
					
				</div>
			
			</div>


		</div>


		</div>
					<?php } else if($action =="reglement_client") {
				require_once("header/menu-reglement.php");
				?>
				<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->

			<div class="row">
				<div class="col-md-12">
					 
					
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$facturess = Facture_vente::trouve_facture_valide_par_societe_client($nav_societe->id_societe); 
				$cpt = 0; ?>

						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-file-text font-yellow"></i>Règlements client (vente)  
							</div>
						</div>

							
						<div class="portlet-body">
							<table class="table table-striped  table-hover " id="sample_2">
							<thead>
							<tr>
								
								<th>
									Description
								</th>
								<th>
									date
								</th>
								<th>
									client
								</th>
								
								<th>
									Compte
								</th>

								<th>
									mode_paiment
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($facturess as $facture){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
								<i class="fa  fa-credit-card font-yellow "></i> Règlement client
									
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
																
																	?>
															<a href="reglement.php?action=affiche_reglemnt_client&id=<?php if (isset ($client->nom) ){echo $client->id_client;} ?> " ><b> <?php  if (isset ($client->nom) ){echo  $client->nom ;}?></b></a>
															<?php }?>
								</td>
								
								<td>
								<?php if (isset($Fact->id_facture)) {
										$client = Client::trouve_par_id($Fact->id_client);
									}  ?>
								 <?php if (isset($client->NCompte)) {
									echo  '<i class="fa  fa-bank font-yellow "></i> '. $client->NCompte;
								} ?>
								</td>
								
								<td>
									<?php if (isset($facture->mode_paiment)) {
									echo $facture->mode_paiment;
									} ?>
									
								</td>
								
								
								
							</tr>

							<?php
								}
							?>
							<?php
							$a=0;
							foreach($facturess as $facture){
								$a += $facture->somme_ttc; 
							
							 }?>
							<tr>
							<td ><b>Total Factures &nbsp;  </b></td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							<td ><?php echo '<b> ' . number_format($a , 2, ',', ' ').' DA </b>';?></td>
							</tr>
						
							</tbody>
							
							</table>
						<div id="myClient" class="modal container fade" tabindex="-1">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title modaltitle" ></h4>
								</div>
								<div class="modal-body modalbody" >
								</div>
								<div class="modal-footer modalfooter">
								</div>
						</div>
						</div>
					</div>
                                          
					
				</div>
			
			</div>


		</div>
		<!--BEGIN AFFICHE SOCIETE-->
					<?php  

				}elseif ($action == 'affiche_reglemnt_client') {		
				  ?>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

					if (isset($_GET['id'])) {
					 $id =  htmlspecialchars(intval($_GET['id'])) ;
					 $clients = Client::trouve_par_id($id);
					}else{
							echo 'Content not found....';
					}
				$cpt = 0; ?>

						<div class="notification"></div>

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-building font-yellow"></i>Reglement Client <span class="caption-helper"><?php if (isset($clients->nom)) {
															echo $clients->nom;
															} ?></span>
							</div>
							</div>
							<div class="portlet-title">
							<!--BEGIEN REFLX-->
							<div class="clearfix">
							<div class="pull-right">
							 <span type = "button" value = "Retour"  onclick = "history.go(-1)" class="btn btn-sm bg-blue" title="list reglement">
									 retour <i class="fa fa-angle-double-left"> </i></span> 
												   
												   </div>
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="javascript:;">

                                                    <img class="media-object" src="assets/image/avatar.png" alt="bank"   > </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><b> <?php if (isset($clients->nom)) {
															echo $clients->nom;
															} ?></b></h4>
                                                    <ul class="list-unstyled" style="">
													<li>
														<?php if (isset($clients->Agence)) {
													echo $clients->Agence;
													} ?>
														
														</li>
													<li>
														<?php if (isset($clients->Adresse)) {
															echo '<i class="fa fa-map-marker font-red"></i>'. $clients->Adresse;
															} ?>
															<?php if (isset($clients->Postal)) {
															echo $clients->Postal;
															} ?>
															- 
														<?php if (isset($clients->Ville)) {
															echo $clients->Ville;
															} ?>
															
													</li>
													<li>
														<?php if (isset($clients->Mob1)) {
															echo '<i class="fa fa-mobile font-plue"></i>'. $clients->Mob1;
															} ?>
															
													</li>
													<li>
														<?php if (isset($clients->Email)) {
															echo '<i class="fa fa-at font-purple bold"></i>'. $clients->Email;
															} ?>
															
															
													</li>
														
													</ul>
                                                   
                                                   
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
									<!--END REFLEX-->
						</div>

					
							<a value="<?php if(isset($clients->id_client)) {echo $clients->id_client; } ?>" id="client_link"  name="<?php if (isset($clients->nom)) {echo $clients->nom;} ?>" data-target="#Rclient" data-toggle="modal" class="btn green btn-sm pull-left">
                                                    <i class="fa fa-usd "></i> Nouveau Reglement </a>
						<div class="portlet-body">
						<div class="row ">
						<div class="col-md-12  Versement_client">
							
							<!--begien reglement-->
						  <?php	  $reglements = Solde_client::trouve_solde_par_id_client($clients->id_client);?>
					
						<table class="table table-striped  table-hover"  id="sample_2">
							<thead>
							<tr>
								
								<th>
									Référence
								</th>
								<th>
									 Mode paiement	
								</th>
								<th>
									Date 
								</th>
								
								<th>
									Montant
								</th>
								<th>
									Reste
								</th>
								<th>
									Consommation
								</th>
								<th>
									
								</th>

							</tr>
							</thead>
							
							<tbody>
								<?php
								foreach($reglements as $reglement){
									$cpt ++;
								?>
							<tr class="item-row">
								
								
								<td >
								
								<b><a href="#">
								<?php if (isset($reglement->reference)) {
									echo $reglement->reference;
									} ?></a></b>
									
								</td>
								<td>
								<b>
								 <?php if (isset($reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>							
                                </b>                
								</td>
								<td>
									<?php if (isset($reglement->date)) {
									echo fr_date2($reglement->date);
									} ?>
									
								</td>
							
								<td>
									<?php if (isset($reglement->credit)) {
									echo number_format ($reglement->credit,2,'.',' ' );
									} ?>
								</td>
								<td>
									<?php if (isset($reglement->solde)) {
									echo number_format ($reglement->solde,2,'.',' ' );
									} ?>
								</td>
								<td>
									<?php   $consommation = $reglement->credit - $reglement->solde;
									$pourcentage = cacul_pourcentage($consommation,$reglement->credit,100);
									if ($pourcentage == 0) {?>
								<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 2%">
									<?php } else if($pourcentage == 100) { ?>
										<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $pourcentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pourcentage; ?>%">
									<?php }else{ ?>
									<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $pourcentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pourcentage ?>%">	
									<?php } ?>
								</div>
							</div>
								</td>
								<td  class="reglement_<?php if (isset($reglement->id)) {echo $reglement->id;} ?>" >
									<button  id="delete_reglemnt_client" na value="<?php if (isset($reglement->id)) {echo $reglement->id;} ?>" class="btn red btn-xs"> <i class="fa fa-trash"></i> </button>
								</td>
								
								<?php
								}
							?>
							
							</tr>
							</tbody>
							<tbody>
								<tr>
							<td colspan="3">
							<b>Total Montant<b>
							</td>
							<td ><?php $c=0;
							
							
							 $reglement = Solde_client::trouve_versement_par_id_client($clients->id_client);;
							?>
								 <b> <div id="reglement-somme" > <?php echo number_format ($reglement->somme,2,'.',' ') ?></div> </b></td>
							
							<td colspan="3">&nbsp;</td>
							
							</tr>
							<tr>
							<td colspan="4">
							<b>Total Reste<b>
							</td>
							
							<td colspan="3" ><b><div id="reglement-solde"><?php echo number_format ($reglement->solde,2,'.',' ') ?></div></b></td>
							</tr>
							<tr>
							<td colspan="5">
							<b>Total Consommation<b>
							</td>
							
							
							<td> <b> <div id="reglement-credit"><?php echo number_format ($reglement->credit,2,'.',' ') ?></div></b></td>
							<td>&nbsp;</td>
							</tr>
							
							</tbody>
							</table>
					 <!--END reglement-->
						</div>
						
						
						
						</div>
						
						</div>
					</div>
				<!--BEGIN AFFICHE SOCIETE-->

		<!--BEGIN AFFICHE SOCIETE-->
					<?php  

				}elseif ($action == 'affiche_reglemnt_fournisseur') {		
				  ?>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

					if (isset($_GET['id'])) {
					 $id =  htmlspecialchars(intval($_GET['id'])) ;
					 $fournisseurs = Fournisseur::trouve_par_id($id);
					}else{
							echo 'Content not found....';
					}
				$cpt = 0; ?>

						<div class="notification"></div>

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-building font-yellow"></i>Reglement fournisseur <span class="caption-helper"><?php if (isset($fournisseurs->nom)) {
															echo $fournisseurs->nom;
															} ?></span>
							</div>
							</div>
							<div class="portlet-title">
							<!--BEGIEN REFLX-->
							<div class="clearfix">
							<div class="pull-right">
							
                                    <span type = "button" value = "Retour"  onclick = "history.go(-1)" class="btn btn-sm bg-blue" title="list reglement">
									 retour <i class="fa fa-angle-double-left"> </i></span> 
                                  
												   
												   </div>
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="javascript:;">

                                                    <img class="media-object" src="assets/image/avatar.png" alt="bank"   > </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><b> <?php if (isset($fournisseurs->nom)) {
															echo $fournisseurs->nom;
															} ?></b></h4>
                                                    <ul class="list-unstyled" style="">
													<li>
														<?php if (isset($fournisseurs->Agence)) {
													echo $fournisseurs->Agence;
													} ?>
														
														</li>
													<li>
														<?php if (isset($fournisseurs->Adresse)) {
															echo '<i class="fa fa-map-marker font-red"></i>'. $fournisseurs->Adresse;
															} ?>
															<?php if (isset($fournisseurs->Postal)) {
															echo $fournisseurs->Postal;
															} ?>
															- 
														<?php if (isset($fournisseurs->Ville)) {
															echo $fournisseurs->Ville;
															} ?>
															
													</li>
													<li>
														<?php if (isset($fournisseurs->Mob1)) {
															echo '<i class="fa fa-mobile font-plue"></i>'. $fournisseurs->Mob1;
															} ?>
															
													</li>
													<li>
														<?php if (isset($fournisseurs->Email)) {
															echo '<i class="fa fa-at font-purple bold"></i>'. $fournisseurs->Email;
															} ?>
															
															
													</li>
														
													</ul>
                                                   
                                                   
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
									<!--END REFLEX-->
						</div>

							<a  value="<?php if(isset($fournisseurs->id_fournisseur)) {echo $fournisseurs->id_fournisseur; } ?>" id="ReglementFournisseur"  name="<?php if (isset($fournisseurs->nom)) {echo $fournisseurs->nom;} ?>" data-target="#Rfournisseur" data-toggle="modal" class="btn green btn-sm">
                                                    <i class="fa fa-usd "></i> Nouveau Règlement</a>

						<div class="portlet-body">
						<div class="row ">
						<div class="col-md-12 Versement_fournisseur ">
							
							<!--begien reglement-->
						  <?php	  $reglements = Solde_fournisseur::trouve_solde_par_id_fournisseur($fournisseurs->id_fournisseur);?>
					
						<table class="table table-striped  table-hover"  id="sample_2">
							<thead>
							<tr>
								
								<th>
									Référence
								</th>
								<th>
									 Mode paiement	
								</th>
								<th>
									Date 
								</th>
								
								<th>
									Montant
								</th>
								<th>
									Reste
								</th>
								<th>
									Consommation
								</th>
								<th>
									
								</th>

							</tr>
							</thead>
							
							<tbody>
								<?php
								foreach($reglements as $reglement){
									$cpt ++;
								?>
							<tr class="item-row">
								
								
								<td >
								
								<b><a href="#">
								<?php if (isset($reglement->reference)) {
									echo $reglement->reference;
									} ?></a></b>
									
								</td>
								<td>
								<b>
								 <?php if (isset($reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>							
                                </b>                
								</td>
								<td>
									<?php if (isset($reglement->date)) {
									echo fr_date2($reglement->date);
									} ?>
									
								</td>
							
								<td>
									<?php if (isset($reglement->debit)) {
									echo number_format ($reglement->debit,2,'.',' ' );
									} ?>
								</td>
								<td>
									<?php if (isset($reglement->solde)) {
									echo number_format ($reglement->solde,2,'.',' ' );
									} ?>
								</td>
								<td>
									<?php   $consommation = $reglement->debit - $reglement->solde;
									$pourcentage = cacul_pourcentage($consommation,$reglement->debit,100);
									if ($pourcentage == 0) {?>
								<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 2%">
									<?php } else if($pourcentage == 100) { ?>
										<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $pourcentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pourcentage; ?>%">
									<?php }else{ ?>
									<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $pourcentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pourcentage ?>%">	
									<?php } ?>
								</div>
							</div>
								</td>
								<td  class="reglement_<?php if (isset($reglement->id)) {echo $reglement->id;} ?>" >
									<button  id="delete_reglemnt_fournisseur" na value="<?php if (isset($reglement->id)) {echo $reglement->id;} ?>" class="btn red btn-xs"> <i class="fa fa-trash"></i> </button>
								</td>
								
								<?php
								}
							?>
							
							</tr>
							</tbody>
							<tbody>
								<tr>
							<td colspan="3">
							<b>Total Montant<b>
							</td>
							<td ><?php $c=0;
							
							
							 $reglement = Solde_fournisseur::trouve_versement_par_id_fournisseur($fournisseurs->id_fournisseur);
							?>
								 <b> <div id="reglement-somme" > <?php echo number_format ($reglement->somme,2,'.',' ') ?></div> </b></td>
							
							<td colspan="3">&nbsp;</td>
							
							</tr>
							<tr>
							<td colspan="4">
							<b>Total Reste<b>
							</td>
							
							<td colspan="3" ><b><div id="reglement-solde"><?php echo number_format ($reglement->solde,2,'.',' ') ?></div></b></td>
							</tr>
							<tr>
							<td colspan="5">
							<b>Total Consommation<b>
							</td>
							
							
							<td> <b> <div id="reglement-debit"><?php echo number_format ($reglement->debit,2,'.',' ') ?></div></b></td>
							<td>&nbsp;</td>
							</tr>
							
							</tbody>
							</table>
					 <!--END reglement-->
						</div>
						
						
						
						</div>
						
						</div>
					</div>
				<!--BEGIN AFFICHE SOCIETE-->

		</div>
			<?php } else if($action =="etat_compte") {
				require_once("header/menu-reglement.php");
				?>
				<?php
						if (isset($_POST['submit']) ) {
						
							$date_db = trim(htmlspecialchars($_POST['date_db']));
							$date_fin = trim(htmlspecialchars($_POST['date_fin']));
							 
							
							
							$factures = Facture_vente::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);
							$factures = Facture_achat::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

						
						}else{
							$facturess = Facture_vente::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
							$factures = Facture_achat::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
						
						}
						
						 ?>
				<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->

			<div class="row">
				<div class="col-md-12">
				
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-bank font-yellow"></i>Etat de compte  
							</div>
						</div>
							<div class="portlet-title">
								
							<!--BEGIEN REFLX-->
							<div class="clearfix">
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="javascript:;">
                                                    <img class="media-object" src="assets/image/bank.JPG" alt="bank"  > </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><b> <?php if (isset($nav_societe) ){
														$banques = Banque::trouve_banque_par_societe_facture($nav_societe->id_societe);
																		
																		foreach ($banques as $banque){
																			if (isset($banque->Designation)) {
																			  
																			echo $banque->Designation;
																			if (isset($banque->Code)) {
																			  
																			
																			echo "<b> - </b> ". $banque->Code;
																		}
																			
																		}
													} }?></b></h4>
                                                    <ul class="list-unstyled" style="">
													<li>
														
														<?php if (isset($nav_societe->id_societe)) {
																		
																		$Comptes = Compte::trouve_compte_par_societe_facture($nav_societe->id_societe);
																												
																		foreach ($Comptes as $Compte){
																		  if (isset($Compte->num_compte)) {
																			  
																			echo '<i class="fa fa-credit-card font-red"></i> <b> compte N°:</b> ' . $Compte->num_compte;
														}}} ?>
														
														</li>
														<li>
														<?php if (isset($nav_societe) ){
														$banques = Banque::trouve_banque_par_societe_facture($nav_societe->id_societe);
																		
																		foreach ($banques as $banque){
																			if (isset($banque->Adresse)) {
																			  
																			echo '<i class="fa fa-map-marker font-purple"></i>'. $banque->Adresse;
																			if (isset($banque->Ville)) {
																			  
																			
																			echo "<b> - </b> ". $banque->Ville;
																		}
																			
																		}
													} }?>
													</li>
														
													</ul>
                                                    <!-- Nested media object -->
                                                
                                                    <!-- Nested media object -->
                                                   
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
									<!--END REFLEX-->
						</div>
						<div class="col-md-8">
										
					<!-- BEGIN FORM-->
						<form action="<?php echo $_SERVER['PHP_SELF']?>?action=etat_compte" method="POST" class="form-horizontal">

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

							
						<div class="portlet-body">
							<table class="table table-striped  table-hover " id="">
							<thead>
							<tr>
								
								<th>
									Description
								</th>
								<th>
									date
								</th>
								<th>
									tiers
								</th>
								
								<th>
									Compte
								</th>

								<th>
									mode_paiment
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
								
                                 <?php if (isset($facture->id_client)) {
															$Clients = Client::trouve_client_par_id_client($facture->id_client);
															
															}
															foreach ($Clients as $client){
																
																	if (isset($client->nom)) {
															echo '<i class="fa  fa-credit-card font-yellow "></i> Règlement client';}}?>
									
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
															echo '<span class="badge  bg-green" title="Client">C</span> '. $client->nom;}}?>
								</td>
								
								<td>
								<?php if (isset($Fact->id_facture)) {
										$client = Client::trouve_par_id($Fact->id_client);
									}  ?>
								 <?php if (isset($client->NCompte)) {
									echo  '<i class="fa  fa-bank font-yellow "></i> '. $client->NCompte;
								} ?>
								</td>
								
								<td>
									<?php if (isset($facture->mode_paiment)) {
									echo $facture->mode_paiment;
									} ?>
									
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
								
                                 <?php if (isset($facturee->id_fournisseur)) {
															$fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facturee->id_fournisseur);
															
															}
															foreach ($fournisseurs as $fournisseur){
																
																	if (isset($fournisseur->nom)) {
															echo '<i class="fa  fa-credit-card font-blue "></i> Paiement fournisseur ';}}?>
									
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
															echo '<span class="badge  bg-blue" title="fournisseur">F</span> '. $fournisseur->nom;}}?>
								</td>
								
								<td>
								<?php if (isset($Fact->id_facture)) {
										$fournisseur = Fournisseur::trouve_par_id($Fact->id_fournisseur);
									}  ?>
								 <?php if (isset($fournisseur->NCompte)) {
									echo  '<i class="fa  fa-bank font-yellow "></i> '. $fournisseur->NCompte;
								} ?>
								</td>
								
								<td>
									<?php if (isset($facturee->mode_paiment)) {
									echo $facturee->mode_paiment;
									} ?>
									
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
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							<td ><?php if (isset($nav_societe)) {
										$soldee = Compte::trouve_compte_par_societe($nav_societe->id_societe);
										
									  } foreach($soldee as $soldes){
										  if (isset ($soldes->solde))
									echo '<b>'. $soldes->solde .'</b>';
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
							<td >&nbsp;</td>
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
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							<td ><?php $stol = $cc - $f;  echo '<b> ' . $stol . ' DA </b>';?></td>
							</tr>
						
							</tbody>
							
							</table>
						
						</div>
					</div>
                                          
					
				</div>
			
			</div>


		</div>


		</div>

		</div>
 <?php	}} ?>
		
	</div>
	</div>
	</div>
	<!-- END CONTENT -->



<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>