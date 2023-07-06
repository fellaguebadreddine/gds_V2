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
$titre = "ThreeSoft | GDS ";
$active_menu = "index";
$active_submenu = "index";
$header = array('todo');
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
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
						<a href="index.php">Home</a>
						<?php if (isset($nav_societe) ){ ?>
						<i class="fa fa-angle-right"></i>
						<a href="#"><?php echo $nav_societe->Dossier ; ?></a>
					<?php } ?>
					</li>				
				</ul>
			</div>
			<?php if (isset($nav_societe) ){ ?>
			<div class="col-md-9 portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-university font-yellow"></i>Société
							</div>
						</div>
			<div class="portlet-title">
							<!--BEGIEN REFLX-->
							<div class="clearfix">
							<div class="pull-right">
							
									<a href="societe.php?action=affiche_societe&id=<?php if(isset($nav_societe->id_societe)) {echo $nav_societe->id_societe; }?>" class="btn btn-sm bg-green-jungle" title="Afficher Société">
															<i class="glyphicon glyphicon-folder-open "></i>&nbsp;  Afficher </a>
												   
												   </div>
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="javascript:;">

                                                    <img class="media-object" src="assets/image/bank.JPG" alt="bank"   > </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><b> <?php if (isset($nav_societe->Dossier)) {
															echo $nav_societe->Dossier;
															} ?></b></h4>
                                                    <ul class="list-unstyled" style="">
													<li>
														<?php if (isset($nav_societe->Agence)) {
													echo $nav_societe->Agence;
													} ?>
														
														</li>
													<li>
														<?php if (isset($nav_societe->Adresse)) {
															echo '<i class="fa fa-map-marker font-red"></i>'. $nav_societe->Adresse;
															} ?>
															<?php if (isset($nav_societe->Postal)) {
															echo $nav_societe->Postal;
															} ?>
															- 
														<?php if (isset($nav_societe->Ville)) {
															echo $nav_societe->Ville;
															} ?>
															
													</li>
													<li>
														<?php if (isset($nav_societe->Mob1)) {
															echo '<i class="fa fa-mobile font-plue"></i>'. $nav_societe->Mob1;
															} ?>
															
													</li>
													<li>
														<?php if (isset($nav_societe->Email)) {
															echo '<i class="fa fa-at font-purple bold"></i>'. $nav_societe->Email;
															} ?>
															
															
													</li>
														
													</ul>
                                                   
                                                   
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
									<!--END REFLEX-->
						</div>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						<?php $factures = Facture_vente::trouve_facture_par_societe($nav_societe->id_societe); 
						$cpt = 0;
						?>
							
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
									<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?>
									<a href="invoice.php?id=<?php echo $facture->id_facture; ?>" >
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
									echo number_format($facture->somme_ttc , 2, ',', ' ');
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
							<td ><?php echo  number_format($a , 2, ',', ' ') . ' DA';?></td>
							<td >&nbsp;</td>
							
							</tr>
						
							</tbody>
							
							</table>
                                    </div>
											</div>

					 <div class="col-md-6"><?php

				$factur = Facture_achat::trouve_facture_par_societe($nav_societe->id_societe); 
				$cptt = 0; ?>
									<div class="well">
                                                Factures fournisseur  (achat) 
                                                
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
									
									<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									

									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?>
									<a href="invoce_achat.php?id=<?php echo $facture->id_facture; ?>">
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
									echo number_format($facture->somme_ttc , 2, ',', ' ');
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
							 foreach($factur as $facture){
								$a += $facture->somme_ttc; 
							
							 }
							 
							 ?>
							<tr>
							<td colspan="2">Total &nbsp; ( Reste à payer) </td>
							<td>&nbsp;</td>
							<td ><?php echo  number_format($a , 2, ',', ' '). ' DA';?></td>
							<td >&nbsp;</td>
							
							</tr>
									
							</tbody>
							
							</table>
							</div>
                                        </div>

						
						</div>
					</div>
				  
			<!--begin alert-->
						 <div class="col-md-6">
					<div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-settings font-green-sharp"></i>
                                                            <span class="caption-subject font-green-sharp bold uppercase">Statistiques de base</span>
                                                        </div>
                                                        <div class="actions">
                                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                                <i class="icon-cloud-upload"></i>
                                                            </a>
                                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                                <i class="icon-wrench"></i>
                                                            </a>
                                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                                                <i class="icon-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <a href="fournisseur.php?action=list_fournisseur" class="icon-btn">
                                                            <i class="fa fa-group"></i>
                                                            <div> Fournisseur </div>
                                                            <span class="badge badge-danger"> <?php 	 $Nfournisseur = count($table_ch = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe));
															echo  $Nfournisseur ;  ?> </span>
                                                        </a>
														 <a href="client.php?action=list_client" class="icon-btn">
                                                            <i class="fa fa-users"></i>
                                                            <div> Clients </div>
                                                            <span class="badge badge-warning"> <?php 	 $Nclient = count($table_ch = Client::trouve_valid_par_societe($nav_societe->id_societe));
															echo  $Nclient ;  ?> </span>
                                                        </a>
                                                        <a href="produit.php?action=list_produit" class="icon-btn">
                                                            <i class="fa fa-barcode"></i>
                                                            <div> Produits </div>
                                                            <span class="badge badge-success">  <?php 	 $Nproduit = count($table_ch = produit::trouve_produit_par_societe($nav_societe->id_societe));
															echo  $Nproduit ;  ?>  </span>
                                                        </a>
														<a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-bullhorn"></i>
                                                            <div> Notification </div>
                                                            <span class="badge badge-danger"> <?php echo $nbr_alerts;?> </span>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-bar-chart-o"></i>
                                                            <div> Reports </div>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-sitemap"></i>
                                                            <div> Categories </div>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-calendar"></i>
                                                            <div> Calendar </div>
                                                            <span class="badge badge-success"> 4 </span>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-envelope"></i>
                                                            <div> Inbox </div>
                                                            <span class="badge badge-info"> 12 </span>
                                                        </a>
                                                        
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-map-marker"></i>
                                                            <div> Locations </div>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-money">
                                                                <i></i>
                                                            </i>
                                                            <div> Finance </div>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-plane"></i>
                                                            <div> Projects </div>
                                                            <span class="badge badge-info"> 21 </span>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-thumbs-up"></i>
                                                            <div> Feedback </div>
                                                            <span class="badge badge-info"> 2 </span>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-cloud"></i>
                                                            <div> Servers </div>
                                                            <span class="badge badge-danger"> 2 </span>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-globe"></i>
                                                            <div> Regions </div>
                                                        </a>
                                                        <a href="javascript:;" class="icon-btn">
                                                            <i class="fa fa-heart-o"></i>
                                                            <div> Popularity </div>
                                                            <span class="badge badge-info"> 221 </span>
                                                        </a>
                                                    </div>
                                                </div>
						</div>
						<?php $produits = Produit::trouve_produit_par_societe_alert($nav_societe->id_societe); 
				$cpt = 0;?>

						<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							<div class="portlet light ">
								<div class="portlet-body">
									<div class="well">
                                                Produits en alerte stock <span class="btn btn-xs  grey-cascade"><?php echo $nbr_alert_stock;?></span>
                                                
                                            </div>
									
								
								
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table table-striped table-hover ">
                                          
							<tbody>
								<?php
								foreach($produits as $produit){
									$cpt ++;
								?>
							<tr>
							<?php if ($cpt <=5){?>
								<td>
								
									
									
									<a class=" popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?php if (isset($produit->code)) {
									echo  $produit->code . ' ';
									
									echo '|'. $produit->Designation . ' ';
									
									echo '|'. $produit->tva . ' % ';
									echo '|'. $produit->stock . ' en stock ';
									}  ?>" data-original-title="Produit"><?php if (isset($produit->code)) {
									echo '<i class="fa  fa-cube font-yellow bold"></i> '. $produit->code;
									} ?></a>
								</td>
								<td>
									<?php if (isset($produit->Designation)) {
									echo $produit->Designation;
									} ?>
									
								</td>
								
								
								
								<td>
							<?php if (isset($produit->stock)) {
									echo $produit->stock;
									} ?>
									/
									<?php if (isset($produit->alerte)) {
									echo $produit->alerte;
									} ?>
									<i class="fa fa-warning font-yellow"></i>
								</td>
								<td>
								<i class="fa fa-circle font-red-haze"></i>
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
							</div>
							<!-- END PORTLET-->
						</div>


					  <!--end alert-->
			</div>	
			<div class="row">
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
					<a class="dashboard-stat dashboard-stat-light blue-madison" href="produit.php?action=stock">
					<div class="visual">
						<i class="fa fa-cube fa-icon-medium"></i>
					</div>
					<div class="details">
						<div class="number">
							
								
								<?php 	 $nbr_alert_stock = count($table_ch = Produit::trouve_produit_par_societe_alert($nav_societe->id_societe));
									 echo   $nbr_alert_stock  ;  ?> <i class="fa fa-bell"></i>
							
						</div>
						<div class="desc" style="font-size:22px;">
							 Alert en stock
						</div>
					</div>
					</a>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
					<a class="dashboard-stat dashboard-stat-light red-intense" href="operation.php?action=list_achat">
					<div class="visual">
						<i class="fa fa-file-text fa-icon-medium"></i>
					</div>
					<div class="details">
						<div class="number">
							
								<?php $nbr_factpay = count($table_ch = Facture_achat::trouve_facture_par_societe($nav_societe->id_societe));
							 echo  $nbr_factpay ;  
						 
							 ?> <i class="fa fa-file-text"></i>
							
						</div>
						<div class="desc" style="font-size:22px;">
							Facture Achat
						</div>
					</div>
					</a>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
					<a class="dashboard-stat dashboard-stat-light green-haze" href="operation.php?action=list_vente">
					<div class="visual">
						<i class="fa fa-file-text-o fa-icon-medium"></i>
					</div>
					<div class="details">
						<div class="number">
							
								<?php $nbr_factpay = count($table_ch = Facture_vente::trouve_facture_par_societe($nav_societe->id_societe));
							 echo  $nbr_factpay ;   
						 
							 ?> <i class="fa fa-file-text-o"></i>
							
						</div>
						<div class="desc" style="font-size:22px;">
							Facture Vente
						</div>
					</div>
					</a>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
					<a class="dashboard-stat dashboard-stat-light yellow" href="operation.php?action=list_vente">
					<div class="visual">
						<i class="fa fa-dollar fa-icon-medium"></i>
					</div>
					<div class="details">
						<div class="number">
							
								<?php  $sumVente = Facture_vente::trouve_facture_valide_par_societe($nav_societe->id_societe);
							 $a=0;
							foreach ( $sumVente as $vent){
								$a += $vent->somme_ttc; 
							
							 }
							 echo  $a . ' DA'; 
						 
							 ?> <i class="fa fa-"></i>
							
						</div>
						<div class="desc" style="font-size:22px;">
							Montant Vente
						</div>
					</div>
					</a>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
					<a class="dashboard-stat dashboard-stat-light yellow-gold" href="operation.php?action=list_vente">
					<div class="visual">
						<i class="fa fa-money fa-icon-medium"></i>
					</div>
					<div class="details">
						<div class="number">
							
								<?php   $sumAchat = Facture_achat::trouve_facture_valide_par_societe($nav_societe->id_societe);
							 $b=0;
							foreach ( $sumAchat as $achay){
								$b += $achay->somme_ttc; 
							
							 }
							 echo  $b . ' DA'; 
						 
							 ?> <i class="fa fa-"></i>
							
						</div>
						<div class="desc" style="font-size:22px;">
							Montant Achat
						</div>
					</div>
					</a>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
					<a class="dashboard-stat dashboard-stat-light green-jungle" href="operation.php?action=list_vente">
					<div class="visual">
						<i class="fa fa-file-text-o fa-icon-medium"></i>
					</div>
					<div class="details">
						<div class="number">
							
								<?php   $som=0;
						$som =$a - $b;
						echo $som . ' DA'; 
						 
							 ?> <i class="fa fa-"></i>
							
						</div>
						<div class="desc" style="font-size:22px;">
							Total revenu
						</div>
					</div>
					</a>
			</div>

			</div>


		<?php 	} else{ ?>
			<!-- END PAGE HEADER-->
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
			<div class="row">

				<div class="col-md-12">
				
					<div class="row margin-top-10">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-green-sharp"><?php 	 $nbr_societe = count($table_ch = Societe::trouve_tous()); echo  $nbr_societe;  ?></h3>
								<small>Sociétés</small>
							</div>
							<div class="icon">
								<i class="icon-home"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 35%;" class="progress-bar progress-bar-success green-sharp">
								<span class="sr-only">76% progress</span>
								</span>
							</div>
							<div class="status">
								<div class="status-title">
									 voirs +
								</div>
								<div class="status-number">
									 <i class="m-icon-swapright m-icon"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-red-haze"><?php 	 $nbr_clients = count($table_ch = Client::trouve_tous()); echo  $nbr_clients;  ?></h3>
								<small>Clients</small>
							</div>
							<div class="icon">
								<i class="icon-users"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 85%;" class="progress-bar progress-bar-success red-haze">
								<span class="sr-only">85% change</span>
								</span>
							</div>
							<div class="status">
								<div class="status-title">
									 change
								</div>
								<div class="status-number">
									 85%
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-blue-sharp"><?php $nbr_fournisseurs = count($table_ch = Fournisseur::trouve_tous()); echo  $nbr_fournisseurs;  ?></h3>
								<small>Fournisseurs</small>
							</div>
							<div class="icon">
								<i class="icon-users"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 45%;" class="progress-bar progress-bar-success blue-haze">
								<span class="sr-only">45% grow</span>
								</span>
							</div>
							<div class="status">
								<div class="status-title">
									 grow
								</div>
								<div class="status-number">
									 45%
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-purple-soft"><?php $nbr_fournisseurs = count($table_ch = Fournisseur::trouve_tous()); echo  $nbr_fournisseurs;  ?></h3>
								<small>Fournisseurs</small>
							</div>
							<div class="icon">
								<i class="icon-user"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
								<span style="width: 57%;" class="progress-bar progress-bar-success purple-soft">
								<span class="sr-only">56% change</span>
								</span>
							</div>
							<div class="status">
								<div class="status-title">
									 change
								</div>
								<div class="status-number">
									 57%
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> 

					 
				</div>
				
			</div>
		<div class="row">

			<!-- END PAGE CONTENT-->

					<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									
									<div class="portlet-body">
										
									<?php $societes = Societe::trouve_limit(); 
									$cpt = 0;?>
						<div class="row ">
						<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							
									<div class="well">
                                                Les 5 dernières nouvelles societes <span class="btn btn-xs  grey-cascade"><?php echo $nbr_societe;?></span>
                                                
                                            </div>
									
								
								
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table table-striped table-hover ">
                                          
							<tbody>
								<?php
								foreach($societes as $societe){
									$cpt ++;
								?>
							<tr>
							<?php if ($cpt <=5){?>
								<td>
								
									
									<a href="societe.php?action=list_societe" >
									<?php if (isset($societe->Dossier)) {
									echo '<i class="fa  fa-university font-yellow "></i> '. $societe->Dossier;
									} ?></a>
								</td>
								<td>
									<?php if (isset($societe->Raison)) {
									echo $societe->Raison;
									} ?>
									
								</td>
								
								
								
								<td>
							<?php if (isset($societe->Agence)) {
									echo '<i class="fa fa-map-marker font-blue"></i> ' . $societe->Agence;
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
							<tr>
							<td >Voir tout les sociétés </td>
							<td>&nbsp;</td>
							<td >&nbsp;</td>
							<td ><a href="societe.php?action=list_societe" ><i class="fa fa-arrow-circle-right font-blue"></i></a></td>
							
							</tr>
						
							</tbody>
                                        </table>
                                    </div>
							
							<!-- END PORTLET-->
						</div>
							<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							<?php $users = Accounts::trouve_tous();
									$Nusers =count($table_ch = Accounts::trouve_tous());							
									$cpt = 0;?>
							
									<div class="well">
                                                Informations de connexion <span class="btn btn-xs  grey-cascade"><?php echo $Nusers;?></span>
                                                
                                            </div>
									
								
								
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table table-striped table-hover ">
                                          
							<tbody>
								<?php
								foreach($users as $user){
									$cpt ++;
								?>
							<tr>
							<?php if ($cpt <=5){?>
								<td>
								
									
									<a href="#" >
									<?php if (isset($user->user)) {
									echo '<i class="fa  fa-user font-yellow "></i> '. $user->user;
									} ?></a>
								</td>
								<td>
									<?php if (!empty($user->nom_compler())) {
						echo  $user->nom_compler() ;
					} else{echo  $user->nom_clie; } ?>
									
								</td>
								
								
								
								<td>
							<?php if (isset($user->type)) {
									echo '<i class="fa fa-map-marker font-blue"></i> ' . $user->type;
									} ?>
									
								</td>
								<td>
								<?php if ( $user->active == 1){ 
								echo '<i class="fa fa-circle font-green-jungle"></i>';
								}else {echo '<i class="fa fa-circle font-red-haze"></i>';}?>
								</td>
							<?php }?>
								
							</tr>

							<?php
								}
							?>
							
							</tbody>
                                        </table>
                                    </div>
							
							<!-- END PORTLET-->
						</div>
						</div>
									</div>
								</div>
								<!-- END PORTLET -->


		</div>
	<?php } ?>
	</div>
	</div>
	<!-- END CONTENT -->

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>