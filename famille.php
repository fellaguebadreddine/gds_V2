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

	if (isset($_GET['action']) && $_GET['action'] =='add_famille' ) {

$active_submenu = "list_famille";
$action = 'add_famille';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_famille' ) {
$active_submenu = "list_famille";
$action = 'list_famille';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$active_submenu = "list_famille";
$action = 'edit';}
}
$titre = "ThreeSoft | Famille";
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

if(isset($_POST['submit']) && $action == 'add_famille'){
	$errors = array();
		// new object famille
	
	// new object admin famille
	
	$famille = new Famille();
	
	
	$famille->famille = htmlentities(trim($_POST['famille']));
	$famille->id_tva = htmlentities(trim($_POST['tva']));
	$famille->id_societe = $nav_societe->id_societe;	
	$famille->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$famille->comptes_vente = htmlentities(trim($_POST['comptes_vente']));
	$famille->comptes_stock = htmlentities(trim($_POST['comptes_stock']));
	$famille->comptes_consommation = htmlentities(trim($_POST['comptes_consommation']));
	$famille->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$famille->auxiliere_vente = htmlentities(trim($_POST['auxiliere_vente']));
	$famille->auxiliere_stock = htmlentities(trim($_POST['auxiliere_stock']));	
	$famille->auxiliere_consommation = htmlentities(trim($_POST['auxiliere_consommation']));

	if (empty($errors)){
if ($famille->existe()) {
			$msg_error = '<p >  Famille    : ' . $famille->famille	 . ' existe déja !!!</p><br />';
			
		}else{
			$famille->save();
 		$msg_positif = '<p ">        famille est bien ajouter  </p><br />';
		
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
	$famille = Famille:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$famille = Famille:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object famille
	
	// new object admin famille
	
		$famille->famille = htmlentities(trim($_POST['famille']));
		$famille->id_tva = htmlentities(trim($_POST['tva']));
		$famille->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
		$famille->comptes_vente = htmlentities(trim($_POST['comptes_vente']));
		$famille->comptes_stock = htmlentities(trim($_POST['comptes_stock']));
		$famille->comptes_consommation = htmlentities(trim($_POST['comptes_consommation']));
		$famille->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
		$famille->auxiliere_vente = htmlentities(trim($_POST['auxiliere_vente']));
		$famille->auxiliere_stock = htmlentities(trim($_POST['auxiliere_stock']));	
		$famille->auxiliere_consommation = htmlentities(trim($_POST['auxiliere_consommation']));

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($famille->save()){
		$msg_positif .= '<p >  article ' . html_entity_decode($famille->famille) . '  est modifié  avec succes </p><br />';
													
														
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
                    <li><?php if ($action == 'add_famille') { 
                         echo '<a href="famille.php?action=list_famille">Liste des familles</a> ';
                        
                        
                    }elseif ($action == 'list_famille') {
                        echo '<a href="famille.php?action=list_famille">Liste des familles</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="famille.php?action=add_famille">Modifier famille</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			<div class="row">
				<div class="col-md-12 ">
                <!-- BEGIN WIDGET MAP -->
                <div class="widget-map">
                    <div id="mapplic" class="widget-map-mapplic"></div>
                    <div class="widget-map-body text-uppercase text-center">
                        <div class="widget-sparkline-chart">
							<a href="produit.php?action=article">
                            <div id="widget_sparkline_bar"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-cube font-yellow"></i> Produit</span>
							</a>
							</div>
						
						  <div class="widget-sparkline-chart">
						  <a href="famille.php?action=add_famille">
                            <div id="widget_sparkline_bar2"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-plus-circle font-red"></i> Nouveau Famille</span>
							</a>
                        </div>
						
						  <div class="widget-sparkline-chart">
						  <a href="famille.php?action=list_famille">
                            <div id="widget_sparkline_bar3"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-list font-blue-hoki "></i> Liste famille</span>
							</a>
                        </div>
						
                        <div class="widget-sparkline-chart">
						 <a href="produit.php?action=stock">
                            <div id="widget_sparkline_bar4"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-database font-yellow "></i> Stocks</span>
							</a>
                        </div>
                    </div>
                </div>
                <!-- END WIDGET MAP -->
            </div>
			</div>
		<?php if ($user->type == 'administrateur') {
			
				$Nfamil= count($table_ch = Famille::trouve_famille_par_societe($nav_societe->id_societe));
				$familles = Famille::trouve_famille_par_societe($nav_societe->id_societe); 
				$cpt = 0; 
				if ($action == 'list_famille') {
				
				?>
				<div class="row">
				<div class="col-md-12">

				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="icon-share font-blue-hoki"></i>Famille<span class="caption-helper"> (<?php echo $Nfamil;?>)</span>
							</div>
						</div>

							
						<div class="portlet-body">
							<table class="table table-bordered table-striped table-condensed flip-content" id="" >
							<thead>
							<tr>

								<th>
									famille
								</th>
								<th>
									TVA
								</th>
								<th>
									Compte Achat 
								</th>
								<th>
									Compte Vente 
								</th>
								<th>
									Compte Stock 
								</th>
								<th>
									Compte consommation 
								</th>
								<th>
									Auxiliere achat 
								</th>
								<th>
									Auxiliere vente
								</th>
								<th>
									Auxiliere Stock
								</th>
								<th>
									Auxiliere consommation
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($familles as $famile){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
									<b><?php if (isset($famile->famille)) {
									echo $famile->famille;
									} ?></b>
								</td>
								<td>
									<?php if (isset($famile->id_tva)) {
									if (isset($famile->id_tva)) {
									$tva = Tva::trouve_par_id($famile->id_tva);
									echo $tva->Designation . ' %';
									}
									
									} ?>
								</td>
								<td>
									
									<?php if (isset($famile->comptes_achat)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($famile->comptes_achat);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									
									<?php if (isset($famile->comptes_vente)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($famile->comptes_vente);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									
									<?php if (isset($famile->comptes_stock)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($famile->comptes_stock);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									
									<?php if (isset($famile->comptes_consommation)) {
															$compte_consommation = Compte_comptable::trouve_compte_par_id_compte($famile->comptes_consommation);
															
															}
															foreach ($compte_consommation as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									
															
									<?php if (isset($famile->auxiliere_achat)) {
															$auxilieres = Auxiliere::trouve_par_id($famile->auxiliere_achat);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>			
								</td>
								<td>
									
									<?php if (isset($famile->auxiliere_vente)) {
															$auxilieres = Auxiliere::trouve_par_id($famile->auxiliere_vente);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>
								</td>
								<td>
									
									<?php if (isset($famile->auxiliere_stock)) {
															$auxilieres = Auxiliere::trouve_par_id($famile->auxiliere_stock);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>
								</td>
								<td>
									
									<?php if (isset($famile->auxiliere_consommation)) {
										
															$consommation = Auxiliere::trouve_par_id($famile->auxiliere_consommation);
															
															}
															
																
																	if (isset($consommation->code)) {
															echo  $consommation->code ;}?>
								</td>
							
								
								<td>
									
									<a href="famille.php?action=edit&id=<?php echo $famile->id_famille; ?>" class="btn blue btn-xs">
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
		
			</div>
			<?php  

				}elseif ($action == 'add_famille') {		
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


                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa  fa-shopping-cart "></i>Ajouter une Famille
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_famille" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
											<div class="form-group">
													<label class="col-md-2 control-label">Famille <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "famille" class="form-control" placeholder="famille" required>
															<span class="input-group-addon ">
															<i class="">famille</i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group form-md-line-input has-warrning">
													<label class="col-md-2 control-label">TVA <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
															<select class="form-control " data-live-search="true" id="form_control_1"  name="tva" required>
												
															
														<?php $tvass = Tva::trouve_tva_par_societe($nav_societe->id_societe);
															foreach($tvass as $tva){

														echo '<option  value = "'.$tva->id_tva.'" > '.$tva->Designation. ' % </option>';
														} ?>																   
														</select> 
															<span class="input-group-addon " required >
															tva
															</span>
														</div>
														
													</div>
												</div>	
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control" id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option  value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
												<div class="form-group comptes_achat">
													
												</div>
													
												</div>
												
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_vente"  name="comptes_vente">
												
															<?php 															
															$Compt_vente = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_vente as $Compte_ventes){?>

														<option  value = "<?php echo $Compte_ventes->id ?>"  > <?php echo $Compte_ventes->code .' | '. $Compte_ventes->libelle . ' | '. $Compte_ventes->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_vente">
					
													</div>
													
													
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Stock <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_stock"  name="comptes_stock">
												
															<?php 															
															$Compt_stock = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_stock as $Compte_stocks){?>

														<option  value = "<?php echo $Compte_stocks->id ?>"  > <?php echo $Compte_stocks->code .' | '. $Compte_stocks->libelle . ' | '. $Compte_stocks->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-database "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_stock">
					
													</div>
													
													
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Compte consommation <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control" id="comptes_consommation"  name="comptes_consommation">
												
															<?php 															
															$Compt_consommation = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_consommation as $Compte_consommations){?>

														<option  value = "<?php echo $Compte_consommations->id ?>"  > <?php echo $Compte_consommations->code .' | '. $Compte_consommations->libelle . ' | '. $Compte_consommations->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-database "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_consommation">
					
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


                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa  fa-shopping-cart"></i>Editer Famille
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-2 control-label">Famille <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "famille" class="form-control" placeholder="famille" value ="<?php if (isset($famille->famille)){ echo html_entity_decode($famille->famille); } ?>"required>
															<span class="input-group-addon ">
															<i class="">famille</i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group form-md-line-input has-warrning">
													<label class="col-md-2 control-label">TVA <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
															<select class="form-control " data-live-search="true" id="form_control_1"  name="tva" required>
															<?php $tvass = Tva::trouve_tva_par_societe($nav_societe->id_societe);
															foreach($tvass as $tva){ ?>
														
															
														<option <?php if ($famille->id_tva == $tva->id_tva  ) { echo "selected";} ?>  value = "<?php echo $tva->id_tva ?>" > <?php echo $tva->Designation . ' %'?></option>
												<?php } ?>																   
														</select> 
															<span class="input-group-addon " required >
															tva
															</span>
														</div>
														
													</div>
												</div>	
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option <?php if ($Compte->id == $famille->comptes_achat) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_achat">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-3">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($famille->comptes_achat);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $famille->comptes_achat) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
															<?php } 	}	else {?>
																
																<option>  </option>
														<?php	}?>											
														
																												   
														</select>
														<span class="input-group-addon ">
															AUX
															</span>	
														</div>

													</div>
													</div>
													
												</div>
												
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_vente"  name="comptes_vente">
												
															<?php 															
															$Compt_vente = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_vente as $Compte_ventes){?>

														<option <?php if ($Compte_ventes->id == $famille->comptes_vente) { echo "selected";} ?> value = "<?php echo $Compte_ventes->id ?>"  > <?php echo $Compte_ventes->code .' | '. $Compte_ventes->libelle . ' | '. $Compte_ventes->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_vente">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-3">
													<?php 

														 
														 $Compt_venteId = Compte_comptable::trouve_par_id($famille->comptes_vente);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_venteId->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_vente"  name="auxiliere_vente">
														
														<?php 
														 
														if(!empty($Compt_venteId->prefixe))	{
														$Auxiliere = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_venteId->prefixe,$nav_societe->id_societe);
														foreach($Auxiliere as $Auxs){?>
														
														<option <?php if ($Auxs->id == $famille->comptes_vente) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
															<?php } 	}	else {?>
																
																<option>  </option>
														<?php	}?>											
														
																												   
														</select>
														<span class="input-group-addon ">
															AUX
															</span>	
														</div>

													</div>
													</div>
													
													
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Compte Stock <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_stock"  name="comptes_stock">
												
															<?php 															
															$Compt_stock = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_stock as $Compte_stocks){?>

														<option <?php if ($Compte_stocks->id == $famille->comptes_stock) { echo "selected";} ?> value = "<?php echo $Compte_stocks->id ?>"  > <?php echo $Compte_stocks->code .' | '. $Compte_stocks->libelle . ' | '. $Compte_stocks->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_stock">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-3">
													<?php 

														 if (isset($famille->comptes_stock)){
														 $Compt_StockId = Compte_comptable::trouve_par_id($famille->comptes_stock);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_StockId->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_stock"  name="auxiliere_stock">
														
														<?php 
														 
														if(!empty($Compt_StockId->prefixe))	{
														$Auxili = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_StockId->prefixe,$nav_societe->id_societe);
														foreach($Auxili as $Auxs){?>
														
														<option <?php if ($Auxs->id == $famille->comptes_vente) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
															<?php } 	}	else {?>
																
																<option>  </option>
														<?php	}}?>											
														
																												   
														</select>
														<span class="input-group-addon ">
															AUX
															</span>	
														</div>

													</div>
													</div>
													
													
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label">Compte consommation <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_consommation"  name="comptes_consommation">
												
															<?php 															
															$Compt_consommation = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_consommation as $Compte_consommations){?>

														<option <?php if ($Compte_consommations->id == $famille->comptes_consommation) { echo "selected";} ?> value = "<?php echo $Compte_consommations->id ?>"  > <?php echo $Compte_consommations->code .' | '. $Compte_consommations->libelle . ' | '. $Compte_consommations->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_consommation">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-3">
													<?php 

														 if (isset($famille->comptes_consommation)){
														 $Compt_consommationId = Compte_comptable::trouve_par_id($famille->comptes_consommation);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_consommationId->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_consommation"  name="auxiliere_consommation">
														
														<?php 
														 
														if(!empty($Compt_consommationId->prefixe))	{
														$Auxilires = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_consommationId->prefixe,$nav_societe->id_societe);
														foreach($Auxilires as $Auxs){?>
														
														<option <?php if ($Auxs->id == $famille->comptes_vente) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
															<?php } 	}	else {?>
																
																<option>  </option>
														<?php	}}?>											
														
																												   
														</select>
														<span class="input-group-addon ">
															AUX
															</span>	
														</div>

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
								</div>
								</div>
			<?php }}?>
		</div>
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
	<script>
	////////////////////////////////// onchange comptes_achat ///////////////////////////

$(document).on('change','#comptes_achat', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_achat').load('ajax/prefixe.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>
  	<script>
	////////////////////////////////// onchange comptes_vente ///////////////////////////

$(document).on('change','#comptes_vente', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_vente').load('ajax/prefixe_vente.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
////////////////////////////////// onchange comptes_stock ///////////////////////////

$(document).on('change','#comptes_stock', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_stock').load('ajax/prefixe_stock.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
////////////////////////////////// onchange comptes consommation ///////////////////////////

$(document).on('change','#comptes_consommation', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_consommation').load('ajax/prefixe_consommation.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
  </script>

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>