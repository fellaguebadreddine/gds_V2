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
$titre = "ThreeSoft | Notification stock ";
$active_menu = "Facturation";
$active_submenu = "list_produit";
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
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="main-content">
			<!-- BEGIN PAGE CONTENT-->
			<!-- BEGIN PAGE HEADER-->
			<div class="page-bar">
				<ul class="page-breadcrumb">
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
						<div class="row">
			<div class="col-md-12">
			<?php  
			 
			  $Articles= Produit::trouve_produit_par_societe_alert($nav_societe->id_societe);
			  $produits= Produit::trouve_produit_par_societe($nav_societe->id_societe);
				
			  ?>
				
	 
				
					<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="fa fa-alert theme-font "></i>
											<span class="caption-subject font-red bold uppercase"> stock & Alert!</span>
											<span class="caption-helper hide">weekly stats...</span>
										</div>
										
									</div>
									<div class="portlet-body">
										
										<div class="">
											<table class="table table-toolbar " id="sample_2">
											<thead>
											<tr class="uppercase">
												<th >
													 Produit
												</th>
												
												<th>
													 stock
												</th>
												<th>
													 alert
												</th>
												
											</tr>
											</thead>
											<?php foreach ($produits as $produit) { ?>
											<tr>
												<td class="bold theme-font" >
												
													<?php 
													if (isset($produit->Designation)){
														ECHO  $produit->Designation ; 
														
													}
													?>
													|
													<?php 
													if (isset($produit->code)){
														
														echo $produit->code ;
													}
													?>
						
												</td>
												
												
													 <?php 
													if (isset($produit->stock)){
														if ($produit->stock <= $produit->alerte){ 
														
														echo '<td class="alert alert-danger"> <b>' .$produit->stock . ' </b></td>' ;
													}else { echo '<td class="success"> ' .$produit->stock . ' </td>' ;}}
													?>
												<td>
													 <?php 
													if (isset($produit->alerte)){
														
														echo $produit->alerte ;
													}
													?>
												</td>
												
											</tr>
											
											<?php }?>
											
											</table>
										</div>
									</div>
								</div>
								<!-- END PORTLET -->
								</div>
			</div>

		<?php 	} else{ ?>
			<!-- END PAGE HEADER-->
			<div class="row">

				<div class="col-md-12">
				
					<div class="row margin-top-10">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat2">
						<div class="display">
							<div class="number">
								<h3 class="font-green-sharp"><?php 	 $nbr_societe = count($table_ch = Societe::trouve_tous()); echo  $nbr_societe;  ?><small class="font-green-sharp"> Sociétés</small></h3>
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
								<h3 class="font-red-haze"><?php 	 $nbr_clients = count($table_ch = Client::trouve_tous()); echo  $nbr_clients;  ?><small class="font-red-haze"> Clients</small></h3>
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
								<h3 class="font-blue-sharp"><?php $nbr_fournisseurs = count($table_ch = Fournisseur::trouve_tous()); echo  $nbr_fournisseurs;  ?><small class="font-blue-sharp"> Fournisseurs</small></h3>
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
			<div class="tiles">
				<div class="tile  double bg-red-haze">
					<div class="tile-body">
						<i class="fa fa-bell-o"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Notifications
						</div>
						<div class="number">
							 6
						</div>
					</div>
				</div>
				
				<div class="tile bg-blue-steel">
					<div class="tile-body">
						<i class="fa fa-plane"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Projects
						</div>
						<div class="number">
							 34
						</div>
					</div>
				</div>
				<div class="tile bg-green-turquoise">
					<div class="tile-body">
						<i class="fa fa-plane"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Projects
						</div>
						<div class="number">
							 34
						</div>
					</div>
				</div>
				<div id="vente" class="tile bg-purple-studio">
					<div class="tile-body">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Orders
						</div>
						<div class="number">
							 121
						</div>
					</div>
				</div>
				<div class="tile bg-red-sunglo">
					<div class="tile-body">
						<i class="fa fa-plane"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Projects
						</div>
						<div class="number">
							 34
						</div>
					</div>
				</div>
				<div class="tile bg-yellow-lemon ">
					<div class="corner">
					</div>
					<div class="check">
					</div>
					<div class="tile-body">
						<i class="fa fa-cogs"></i>
					</div>
					<div class="tile-object">
						<div class="name">
							 Settings
						</div>
					</div>
				</div>
				
			</div>
					 
				</div>
				
			</div>
		<div class="row">

			<!-- END PAGE CONTENT-->

				<div class="col-md-6">

					<!-- BEGIN PORTLET -->
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption caption-md">
											<i class="icon-bar-chart theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Client /Fournisseurs</span>
											<span class="caption-helper hide">weekly stats...</span>
										</div>
										<div class="actions">
											<div class="btn-group btn-group-devided" data-toggle="buttons">
												<label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
												<input type="radio" name="options" class="toggle" id="option1">Today</label>
												<label class="btn btn-transparent grey-salsa btn-circle btn-sm">
												<input type="radio" name="options" class="toggle" id="option2">Week</label>
												<label class="btn btn-transparent grey-salsa btn-circle btn-sm">
												<input type="radio" name="options" class="toggle" id="option2">Month</label>
											</div>
										</div>
									</div>
									<div class="portlet-body">
										<div class="row number-stats margin-bottom-30">
											<div class="col-md-6 col-sm-6 col-xs-6">
												<div class="stat-left">
													<div class="stat-chart">
														<!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
														<div id="sparkline_bar"></div>
													</div>
													<div class="stat-number">
														<div class="title">
															 Clients
														</div>
														<div class="number">
															 <?php 	 $nbr_clients = count($table_ch = Client::trouve_tous()); echo  $nbr_clients;  ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6">
												<div class="stat-right">
													<div class="stat-chart">
														<!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
														<div id="sparkline_bar2"></div>
													</div>
													<div class="stat-number">
														<div class="title">
															 Fournisseurs
														</div>
														<div class="number">
															 <?php $nbr_fournisseurs = count($table_ch = Fournisseur::trouve_tous()); echo  $nbr_fournisseurs;  ?>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="table-scrollable table-scrollable-borderless">
											<table class="table table-hover table-light">
											<thead>
											<tr class="uppercase">
												<th colspan="2">
													 MEMBER
												</th>
												<th>
													 Earnings
												</th>
												<th>
													 CASES
												</th>
												<th>
													 CLOSED
												</th>
												<th>
													 RATE
												</th>
											</tr>
											</thead>
											<tr>
												<td class="fit">
													<img class="img-circle" src="assets/admin/layout2/img/avatar3_small.jpg">
												</td>
												<td>
													<a href="javascript:;" class="primary-link">Brain</a>
												</td>
												<td>
													 $345
												</td>
												<td>
													 45
												</td>
												<td>
													 124
												</td>
												<td>
													<span class="bold theme-font">80%</span>
												</td>
											</tr>
											<tr>
												<td class="fit">
													<img class="img-circle" src="assets/admin/layout2/img/avatar3_small.jpg">
												</td>
												<td>
													<a href="javascript:;" class="primary-link">Nick</a>
												</td>
												<td>
													 $560
												</td>
												<td>
													 12
												</td>
												<td>
													 24
												</td>
												<td>
													<span class="bold theme-font">67%</span>
												</td>
											</tr>
											<tr>
												<td class="fit">
													<img class="img-circle" src="assets/admin/layout2/img/avatar3_small.jpg">
												</td>
												<td>
													<a href="javascript:;" class="primary-link">Tim</a>
												</td>
												<td>
													 $1,345
												</td>
												<td>
													 450
												</td>
												<td>
													 46
												</td>
												<td>
													<span class="bold theme-font">98%</span>
												</td>
											</tr>
											<tr>
												<td class="fit">
													<img class="img-circle" src="assets/admin/layout2/img/avatar3_small.jpg">
												</td>
												<td>
													<a href="javascript:;" class="primary-link">Tom</a>
												</td>
												<td>
													 $645
												</td>
												<td>
													 50
												</td>
												<td>
													 89
												</td>
												<td>
													<span class="bold theme-font">58%</span>
												</td>
											</tr>
											</table>
										</div>
									</div>
								</div>
								<!-- END PORTLET -->
                                         
					
				</div>
			<div class="col-md-4">
				<?php   
				$societes = Societe::trouve_limit(); 
				$cpt = 0; ?>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Les nouvelles sociétés
							</div>
						</div>
						<div class="table-toolbar">

							
						<div class="table-scrollable table-scrollable-borderless">
											<table class="table table-hover table-light">
							<thead>
							<tr>
								<th>
									Société
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
									<a href="societe.php?action=list_societe" ><b><?php if (isset($entrp->Dossier)) {
									echo $entrp->Dossier;
									} ?></b></a>
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
				<div class="col-md-2">
				<?php   
				$societes = Societe::trouve_limit(); 
				$cpt = 0; ?>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Les nouvelles sociétés 
							</div>
						</div>
						<div class="table-toolbar">

							
						<div class="table-scrollable table-scrollable-borderless">
											<table class="table table-hover table-light">
							<thead>
							<tr>
								<th>
									Société
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
									<a href="societe.php?action=list_societe" ><b><?php if (isset($entrp->Dossier)) {
									echo $entrp->Dossier;
									} ?></b></a>
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
		</div>
	<?php } ?>
	</div>
	</div>
	<!-- END CONTENT -->

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>