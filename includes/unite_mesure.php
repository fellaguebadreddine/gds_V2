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

	if (isset($_GET['action']) && $_GET['action'] =='add_unite' ) {

$active_submenu = "add_unite";
$action = 'add_unite';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_mesure' ) {
$active_submenu = "list_mesure";
$action = 'list_mesure';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$active_submenu = "list_mesure";
$action = 'edit';}
}
$titre = "ThreeSoft | Unite de mesure ";
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

if(isset($_POST['submit']) && $action == 'add_unite'){
	$errors = array();
		// new object uniteMesure
	
	// new object admin uniteMesure
	
	$uniteMesure = new Unite();
	
	
	$uniteMesure->unite = htmlentities(trim($_POST['unite']));
	$uniteMesure->id_societe = $nav_societe->id_societe;
	
	
	

	if (empty($errors)){
if ($uniteMesure->existe()) {
			$msg_error = '<p >  Unite de mesure    : ' . $uniteMesure->Unite	 . ' existe déja !!!</p><br />';
			
		}else{
			$uniteMesure->save();
 		$msg_positif = '<p ">        article est bien ajouter  </p><br />';
		
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
	$uniteMesure = Unite:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$uniteMesure = Unite:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object uniteMesure
	
	// new object admin uniteMesure
	
		$uniteMesure->unite = htmlentities(trim($_POST['unite']));


	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($uniteMesure->save()){
		$msg_positif .= '<p >  article ' . html_entity_decode($uniteMesure->unite) . '  est modifié  avec succes </p><br />';
													
														
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
			<div class="main-content">
			<!-- BEGIN PAGE CONTENT-->
			
			<!-- BEGIN PAGE HEADER-->
			
			<div class="page-bar">
				<ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Article</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_unite') { ?>
                        <a href="#"><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?></a> 
                        
                        
                    <?php }elseif ($action == 'list_mesure') {
                        echo '<a href="unite_mesure.php?action=list_mesure">Liste des unites</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="unite_mesure.php?action=list_mesure">Modifier unite</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
						<div class="row">
				<div class="col-md-12 ">
                <!-- BEGIN WIDGET MAP -->
                <div class="widget-map">
                    <div id="mapplic" class="widget-map-mapplic"></div>
                    <div class="widget-map-body text-uppercase text-center">
                        <div class="widget-sparkline-chart">
							<a href="produit.php?action=article">
                            <div id="widget_sparkline_bar"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-cube font-yellow "></i> Produit</span>
							</a>
							</div>
						
						  <div class="widget-sparkline-chart">
						  <a href="unite_mesure.php?action=add_unite">
                            <div id="widget_sparkline_bar2"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-plus-circle font-red-haze"></i> Nouveau unite</span>
							</a>
                        </div>
						
						  <div class="widget-sparkline-chart">
						  <a href="unite_mesure.php?action=list_mesure">
                            <div id="widget_sparkline_bar3"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-list font-blue "></i> Liste des Unite de mesure</span>
							</a>
                        </div>
						
                        <div class="widget-sparkline-chart">
						 <a href="produit.php?action=stock">
                            <div id="widget_sparkline_bar4"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-database font-yellow  "></i> Stocks</span>
							</a>
                        </div>
                    </div>
                </div>
                <!-- END WIDGET MAP -->
            </div>
			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
				if ($action == 'list_mesure') {
				
				?>
				<div class="row">
				<div class="col-md-12">

				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$uniteMesures = Unite::trouve_unite_par_societe($nav_societe->id_societe);
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-8">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-tags font-blue-hoki"></i>Liste des Unite de mesure 
							</div>
						</div>
					
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="">
							<thead>
							<tr>
								
								<th>
									Unite
								</th>

								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($uniteMesures as $uniteMesure){
									$cpt ++;
								?>
							<tr>
								
								<td>
									<b><?php if (isset($uniteMesure->unite)) {
									echo $uniteMesure->unite;
									} ?></b>
								</td>
								
								
								<td>
									
									<a href="unite_mesure.php?action=edit&id=<?php echo $uniteMesure->id_unite; ?>" class="btn blue btn-sm">
                                                    <i class="fa fa-edit "></i> </a>
									
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
				<div class="col-md-4">
				<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Unite de mesure!
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse" data-original-title="" title="">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<ol>
							<strong>une Unite de mesure :</strong>
								<li>
									 Poids	(Kg, g, mg ...)

								</li>
								<li>
									 Longueur x Largeur x Hauteur(m, dm ,cm ...)
								</li>
								<li>
									 Surface (m²,dm²,cm²)
								</li>
								<li>
									Volume (m³ ...)
								</li>
								
							</ol>
						</div>
					</div>
				</div>
			</div>
			<?php  

				}elseif ($action == 'add_unite') {		
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


                                <div class="portlet box blue-hoki">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa  fa-shopping-cart "></i>Ajouter unite de mesure
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_unite" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Unite de mesure *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "unite" class="form-control" placeholder="unite" required>
															<span class="input-group-addon ">
															<i class="fa fa-fa-bank ">unite</i>
															</span>
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


                                <div class="portlet box blue-hoki">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa  fa-shopping-cart"></i>Editer Unite de mesure
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">Unite de mesure *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "unite" class="form-control" placeholder="unite" value ="<?php if (isset($uniteMesure->unite)){ echo html_entity_decode($uniteMesure->unite); } ?>"required>
															<span class="input-group-addon ">
															<i class="">unite</i>
															</span>
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
			<?php }}?>
		</div>
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
	

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>