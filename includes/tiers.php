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

	
 if (isset($_GET['action']) && $_GET['action'] =='tiers' ) {
$active_submenu = "tiers";
$action = 'tiers';}
}
$titre = "ThreeSoft | Tiers ";
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
?>
<?php


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
                        
                        <a href="tiers.php?action=tiers">Tiers</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			
		<?php if ($user->type == 'administrateur') {
			
				$Nbr_client= count($table_ch = Client::trouve_valid_par_societe($nav_societe->id_societe));
				$Nbr_fournisseur= count($table_ch = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe));
				$Nbr_tires= $Nbr_client+$Nbr_fournisseur;
				$cpt = 0; 
				
				?>
	
				
				

	<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">

			<?php if ($action == 'tiers') { 
	
				$clients = Client::trouve_valid_par_societe($nav_societe->id_societe); 
				$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 
				$cpt = 0;
				$cptt = 0;		?>
				
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
				<div class="col-md-12 ">
                <!-- BEGIN WIDGET MAP -->
                <div class="widget-map">
                    <div id="mapplic" class="widget-map-mapplic"></div>
                    <div class="widget-map-body text-uppercase text-center">
                        <div class="widget-sparkline-chart">
							<a href="tiers.php?action=tiers">
                            <div id="widget_sparkline_bar"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-group font-blue "></i> Tiers</span>
							</a>
							</div>
						
						  <div class="widget-sparkline-chart">
						  <a href="client.php?action=list_client">
                            <div id="widget_sparkline_bar2"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-building font-yellow"></i> liste des clients</span>
							</a>
                        </div>
						
						  <div class="widget-sparkline-chart">
						  <a href="fournisseur.php?action=list_fournisseur">
                            <div id="widget_sparkline_bar3"></div>
                            <span class="widget-sparkline-title"><i class="fa fa-building font-yellow"></i> liste des fournisseurs</span>
							</a>
                        </div>
						
                    </div>
                </div>
                <!-- END WIDGET MAP -->
            </div>
			</div>
			<div class="row profile">
				<div class="col-md-12">
						


                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption bold">
											<i class="fa fa-users font-yellow "></i>Tiers<span class="caption-helper"> (<?php echo $Nbr_tires;?>)</span>
										</div>

									</div>
								<div class="portlet-body">
                            <div class="row">
                                 <div class="col-md-6">
											<div class="well">
                                                Les 5 derniers tiers enregistrés
                                                
                                            </div>
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table table-striped table-hover ">
                                          
							<tbody>
								<?php
								foreach($fournisseurs as $fournisseur){
									$cpt ++;
								?>
							<tr>
							<?php if ($cpt <=3){?>
								<td>
								
									
									
									<a class=" popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?php if (isset($fournisseur->nom)) {
									echo   $fournisseur->nom . ' ';
									
									echo '|'. $fournisseur->Activite . ' ';
									
									echo '|'. $fournisseur->Tarif . '  ';
									
									}  ?>" data-original-title="fournisseur"><?php if (isset($fournisseur->nom)) {
									echo '<i class="fa  fa-building font-yellow "></i> '. $fournisseur->nom;
									} ?></a>
								</td>
								
								<td>
									
									<span class="badge bg-blue-hoki" title="fournisseur">F</span>
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
								foreach($clients as $client){
									$cptt ++;
								?>
							<tr>
							<?php if ($cptt <=3){?>
								<td>
								
									
									
									<a class=" popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?php if (isset($client->nom)) {
									echo  $client->nom . ' ';
									
									echo '|'. $client->Activite . ' ';
									
									echo '|'. $client->Tarif . '  ';
									
									}  ?>" data-original-title="client"><?php if (isset($client->nom)) {
									echo '<i class="fa  fa-building font-yellow "></i> '. $client->nom;
									} ?></a>
								</td>
								
								<td>
									
									<span class="badge  bg-purple" title="Client">C</span>
								</td>
								<td>
								<i class="fa fa-circle font-green-jungle"></i>
								</td>
							<?php }?>
								
							</tr>

							<?php
								}
							?>
						
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
									<a href="client.php?action=list_client">
									Client
									</a>
								</td>
							
								<td>
									 <?php 	 $Nclient = count($table_ch = Client::trouve_valid_par_societe($nav_societe->id_societe));
															echo  $Nclient ;  ?>
								</td>
								<td>
								<i class="fa fa-circle font-green-jungle"></i>
								</td>
							</tr>
							<tr>
							
								<td>
									<a href="fournisseur.php?action=list_fournisseur">
									Fournisseur
									</a>
								</td>
								<td>
								<?php 	 $Nfournisseur = count($table_ch = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe));
															echo  $Nfournisseur ;  ?>	
								</td>
								<td>
								<i class="fa fa-circle font-green-jungle"></i>
								</td>
						
							</tr>
							<tr>

								<td>
								
									Total de tiers 
								
								</td>
								<td>
								
									<?php echo $Nbr_tires;?>
									
								</td>
								<td>
								
								</td>
							</tr>

							
						
							</tbody>
                                        </table>
                                    </div>
                                                </div>
                                        </div>
                            </div>
                            <!-- END GENERAL PORTLET-->
                          
                            
                            
                            <!-- END WELLS PORTLET-->
                       

								</div>
			
			<?php }}?>
		</div>
		</div>
	</div>
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
	

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>