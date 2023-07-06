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
		$msg_system ="vous n'avez pas le droit d'acc�der a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 
}
?>
<?php
if ($user->type == "administrateur"){

	if (isset($_GET['action']) && $_GET['action'] =='list_tva' ) {
$active_submenu = "list_tva";
$action = 'list_tva';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$active_submenu = "list_tva";
$action = 'edit';}
else if (isset($_GET['action']) && $_GET['action'] =='add_tva' ) {
$active_submenu = "list_tva";
$action = 'add_tva';}
else if (isset($_GET['action']) && $_GET['action'] =='list_timbre' ) {
$active_submenu = "list_timbre";
$action = 'list_timbre';}
else if (isset($_GET['action']) && $_GET['action'] =='add_timbre' ) {
$active_submenu = "list_timbre";
$action = 'add_timbre';}
else if (isset($_GET['action']) && $_GET['action'] =='edit_timbre' ) {
$active_submenu = "list_timbre";
$action = 'edit_timbre';}
}
$titre = "ThreeSoft | TVA ";
$active_menu = "parametre";
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

	if(isset($_POST['submit']) && $action == 'add_tva'){

	$errors = array();
		// new object TVA
	
	// new object admin TVA
		$tva = new Tva();
	$tva->Designation = htmlentities(trim($_POST['Designation']));
	$tva->taux = htmlentities(trim($_POST['taux']))/100;
	$tva->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$tva->comptes_vente = htmlentities(trim($_POST['comptes_vente']));
	$tva->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$tva->auxiliere_vente = htmlentities(trim($_POST['auxiliere_vente']));
	$tva->id_societe = $nav_societe->id_societe;
	
	if (empty($errors)){
if ($tva->existe()) {
			$msg_error = '<p >  Tva existe déja !!!</p><br />';
			
		}else{
			$tva->save();
 		$msg_positif = '<p ">        Tva est bien ajouter  </p><br />';
		
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
	$tva = Tva:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$tva = Tva:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page est consulter par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object TVA
	
	// new object admin TVA
		
	$tva->Designation = htmlentities(trim($_POST['Designation']));
	$tva->taux = htmlentities(trim($_POST['taux']))/100;
	$tva->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$tva->comptes_vente = htmlentities(trim($_POST['comptes_vente']));
	$tva->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$tva->auxiliere_vente = htmlentities(trim($_POST['auxiliere_vente']));
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($tva->save()){
		$msg_positif .= '<p >  TVA ' . html_entity_decode($tva->taux) . '  est modifier  avec succes </p><br />';
													
														
		}else{
		$msg_system .= "<h1>Une erreur dans le programme ! </h1>
                   <p  >  S'il vous plait modifier est nouveau !!</p>";
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
	if($action == 'edit_timbre' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$timbre = Timbre:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$timbre = Timbre:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page est consulter par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object Timbre
	
	// new object admin Timbre
		
	$timbre->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$timbre->comptes_vente = htmlentities(trim($_POST['comptes_vente']));
	$timbre->prefixe_achat = htmlentities(trim($_POST['prefixe_achat']));
	$timbre->prefixe_vente = htmlentities(trim($_POST['prefixe_vente']));
	$timbre->journal_achat = htmlentities(trim($_POST['journal_achat']));
	$timbre->journal_vente = htmlentities(trim($_POST['journal_vente']));
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($timbre->save()){
		$msg_positif .= '<p >  timbre est modifier  avec succes </p><br />';
													
														
		}else{
		$msg_system .= "<h1>Une erreur dans le programme ! </h1>
                   <p  >  S'il vous plait modifier est nouveau !!</p>";
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
	if(isset($_POST['submit']) && $action == 'add_timbre'){
	$errors = array();
		// new object TVA
	
	// new object admin TVA
	
	$timbre = new Timbre();
	
	$timbre->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$timbre->comptes_vente = htmlentities(trim($_POST['comptes_vente']));
	$timbre->prefixe_achat = htmlentities(trim($_POST['prefixe_achat']));
	$timbre->prefixe_vente = htmlentities(trim($_POST['prefixe_vente']));
	$timbre->journal_achat = htmlentities(trim($_POST['journal_achat']));
	$timbre->journal_vente = htmlentities(trim($_POST['journal_vente']));
	$timbre->id_societe = $nav_societe->id_societe;
	

	if (empty($errors)){
if ($timbre->save() ){
			
 		$msg_positif = '<p > Timbre est bien ajouter  </p>';
		
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
                        <a href="#">TVA</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_tva') { ?>
                        <a href="tva.php?action=add_tva">Ajouter TVA</a> 
                        
                        
                    <?php }elseif ($action == 'list_tva') {
                        echo '<a href="tva.php?action=list_tva">Liste des TVA</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="tva.php?action=edit_tva">Modifier TVA</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
				if ($action == 'list_tva') {
				
				?>
				<div class="row">
					<div class="col-md-12">
					
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				$tvas = Tva::trouve_tva_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

					<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption font-purple bold">
								<i class="icon-share font-purple-sunglo"></i>Liste des TVA 
							</div>
						</div>
					
							<a href="tva.php?action=add_tva" class="btn btn-sm purple ">Nouveau  <i class="fa fa-plus"></i></a>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="">
							<thead>
							<tr>
								
								<th>
									TVA
								</th>
								
								
								<th>
									taux 
								</th>
								<th>
									Compte Achat 
								</th>
								<th>
									Compte Vente 
								</th>
								<th>
									Auxiliere achat 
								</th>
								<th>
									Auxiliere vente
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($tvas as $tva){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
									<b><?php if (isset($tva->Designation)) {
									echo $tva->Designation .' %';
									} ?></b>
								</td>
								
								<td>
									<?php if (isset($tva->taux)) {
									echo $tva->taux;
									} ?>
								</td>
								<td>
									
									<?php if (isset($tva->comptes_achat)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($tva->comptes_achat);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									
									<?php if (isset($tva->comptes_vente)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($tva->comptes_vente);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									
															
									<?php if (isset($tva->auxiliere_achat)) {
															$auxilieres = Auxiliere::trouve_par_id($tva->auxiliere_achat);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>			
								</td>
								<td>
									
									<?php if (isset($tva->auxiliere_vente)) {
															$auxilieres = Auxiliere::trouve_par_id($tva->auxiliere_vente);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>
								</td>
								<td>
									
									<a href="tva.php?action=edit&id=<?php echo $tva->id_tva; ?>" class="btn blue btn-xs">
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
			<?php }  elseif ($action == 'add_tva') { ?>
	<!-- BEGIN PAGE CONTENT-->
			<div class="row ">
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
											<i class="fa fa-bank"></i>Nouveau TVA
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_tva" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">TVA *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Designation" class="form-control" placeholder="Banque" value ="<?php if (isset($tva->Designation)){ echo html_entity_decode($tva->Designation); } ?>"required>
															<span class="input-group-addon ">
															<i class="fa fa-fa-repeat ">%</i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Taux de tva *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "taux" class="form-control" placeholder="taux" value ="<?php if (isset($tva->taux)){ echo html_entity_decode($tva->taux)*100; } ?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-usd"></i>
															</span>
														</div>

													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Compte Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option <?php if ($Compte->id == $tva->comptes_achat) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
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
													
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Compte Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_vente"  name="comptes_vente">
												
															<?php 															
															$Compt_vente = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_vente as $Compte_ventes){?>

														<option <?php if ($Compte_ventes->id == $tva->comptes_vente) { echo "selected";} ?> value = "<?php echo $Compte_ventes->id ?>"  > <?php echo $Compte_ventes->code .' | '. $Compte_ventes->libelle . ' | '. $Compte_ventes->prefixe?></option>
														
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
												
																					
												
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn green">Ajouter</button>
														<button type="button" value="back" onclick="history.go(-1)" class="btn  default">Annuler</button>
														 
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
							</div>
					

	
			<!-- END PAGE CONTENT-->
<?php }  elseif ($action == 'edit') { ?>
	<!-- BEGIN PAGE CONTENT-->
			<div class="row ">
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
											<i class="fa fa-bank"></i>Editer TVA
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">TVA <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Designation" class="form-control" placeholder="Banque" value ="<?php if (isset($tva->Designation)){ echo html_entity_decode($tva->Designation); } ?>"required>
															<span class="input-group-addon ">
															<i class="fa fa-fa-repeat ">%</i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Taux de tva <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "taux" class="form-control" placeholder="taux" value ="<?php if (isset($tva->taux)){ echo html_entity_decode($tva->taux)*100; } ?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-usd"></i>
															</span>
														</div>

													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Compte Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option <?php if ($Compte->id == $tva->comptes_achat) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_achat">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($tva->comptes_achat);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $tva->comptes_achat) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
													<label class="col-md-3 control-label">Compte Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_vente"  name="comptes_vente">
												
															<?php 															
															$Compt_vente = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_vente as $Compte_ventes){?>

														<option <?php if ($Compte_ventes->id == $tva->comptes_vente) { echo "selected";} ?> value = "<?php echo $Compte_ventes->id ?>"  > <?php echo $Compte_ventes->code .' | '. $Compte_ventes->libelle . ' | '. $Compte_ventes->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_vente">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt_venteId = Compte_comptable::trouve_par_id($tva->comptes_vente);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_venteId->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_vente"  name="auxiliere_vente">
														
														<?php 
														 
														if(!empty($Compt_venteId->prefixe))	{
														$Auxiliere = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_venteId->prefixe,$nav_societe->id_societe);
														foreach($Auxiliere as $Auxs){?>
														
														<option <?php if ($Auxs->id == $tva->comptes_vente) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
					<?php  

				}elseif ($action == 'add_timbre') {		
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


                                <div class="portlet box purple">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-align-justify "></i>Ajouter Timbre
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_timbre" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
											<div class="form-group">
													<label class="col-md-3 control-label">Compte Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="comptes_achat">
												
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
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($Compte->id);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="prefixe_achat"  name="prefixe_achat">
														
														<?php 
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe, $nav_societe->id_societe);
														foreach($Aux as $Auxs){?>
														
														<option  value = "<?php echo $Auxs->code ?>"  > <?php echo $Auxs->code ?></option>
														
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
													<label class="col-md-3 control-label">Compte Vente <span class="required" aria-required="true"> * </span></label>
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
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt_venteId = Compte_comptable::trouve_par_id($Compte_ventes->id);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_venteId->aux ==0 ) {echo "disabled";} ?>  id="prefixe_vente"  name="prefixe_vente">
														
														<?php 
														 
														if(!empty($Compt_venteId->prefixe))	{
														$Auxiliere = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_venteId->prefixe, $nav_societe->id_societe);
														foreach($Auxiliere as $Auxs){?>
														
														<option <?php if ($Auxs->id == $famille->comptes_vente) { echo "selected";}?> value = "<?php echo $Auxs->code ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
													<label class="col-md-3 control-label">Journal Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="journal"  name="journal_achat">
												
															<?php 															
															$journals = Journaux::trouve_tous();
															
															foreach($journals as $journal){?>

														<option  value = "<?php echo $journal->id ?>"  > <?php echo $journal->code .' | '. $journal->intitule ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													
												</div>									
												<div class="form-group">
													<label class="col-md-3 control-label">Journal Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="journal"  name="journal_vente">
												
															<?php 															
															$journals = Journaux::trouve_tous();
															
															foreach($journals as $journal){?>

														<option  value = "<?php echo $journal->id ?>"  > <?php echo $journal->code .' | '. $journal->intitule ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
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
							<?php  

				}elseif ($action == 'edit_timbre') {		
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


                                <div class="portlet box purple">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-align-justify "></i>Ajouter Timbre
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit_timbre" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
											<div class="form-group">
													<label class="col-md-3 control-label">Compte Achat <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option <?php if ($Compte->id == $timbre->comptes_achat) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_achat">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($timbre->comptes_achat);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe, $nav_societe->id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $timbre->comptes_achat) { echo "selected";} ?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code ?></option>
														
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
													<label class="col-md-3 control-label">Compte Vente <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_vente"  name="comptes_vente">
												
															<?php 															
															$Compt_vente = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Compt_vente as $Compte_ventes){?>

														<option <?php if ($Compte_ventes->id == $timbre->comptes_vente) { echo "selected";} ?> value = "<?php echo $Compte_ventes->id ?>"  > <?php echo $Compte_ventes->code .' | '. $Compte_ventes->libelle . ' | '. $Compte_ventes->prefixe?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_vente">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt_venteId = Compte_comptable::trouve_par_id($timbre->comptes_vente);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt_venteId->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_vente"  name="auxiliere_vente">
														
														<?php 
														 
														if(!empty($Compt_venteId->prefixe))	{
														$Auxiliere = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt_venteId->prefixe, $nav_societe->id_societe);
														foreach($Auxiliere as $Auxs){?>
														
														<option  <?php if ($Auxs->id == $timbre->comptes_vente) { echo "selected";} ?>  value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
																					
										
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn green">Ajouter</button>
														<button type="reset" class="btn  default">Annuler</button>
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
			<!-- END PAGE CONTENT-->
		<?php }  elseif ($action == 'list_timbre') { ?>
			<div class="row">
				<div class="col-md-12">
					 
					  <div class="page-title">
					<h1>TVA</h1>
				</div>
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				$timbres = Timbre::trouve_timbre_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption font-purple bold">
								<i class="icon-share font-purple-sunglo"></i>Timbre 
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											
											<a href="tva.php?action=add_timbre" class="btn purple">Nouveau Timbre <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							<tr>
								
								
								<th>
									Compte Achat 
								</th>
								<th>
									Compte Vente 
								</th>
								<th>
									prefixe_achat 
								</th>
								<th>
									prefixe_vente
								</th>
								<th>
									Journal Achat
								</th>
								<th>
									Journal Vente
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($timbres as $timbre){
									$cpt ++;
								?>
							<tr>
								
								<td>
									
									<?php if (isset($timbre->comptes_achat)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($timbre->comptes_achat);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									
									<?php if (isset($timbre->comptes_vente)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($timbre->comptes_vente);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								<td>
									<?php if (isset($timbre->prefixe_achat)) {
									echo $timbre->prefixe_achat;
									} ?>
								</td>
								<td>
									<?php if (isset($timbre->prefixe_vente)) {
									echo $timbre->prefixe_vente;
									} ?>
								</td>
								<td>
									
									<?php if (isset($timbre->journal_achat)) {
															$journal = Journaux::trouve_par_id($timbre->journal_achat);
															
															}
															
																
																	if (isset($journal->intitule)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $journal->intitule ;}?>
								</td>
								<td>
									
									<?php if (isset($timbre->journal_vente)) {
															$journal = Journaux::trouve_par_id($timbre->journal_vente);
															
															}
															
																
																	if (isset($journal->intitule)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $journal->intitule ;}?>
								</td>
								<td>
									
									<a href="tva.php?action=edit_timbre&id=<?php echo $timbre->id; ?>" class="btn blue btn-xs">
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
			<?php }}?>
		</div>
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
				<script>
	////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#comptes_achat', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_achat').load('ajax/prefixe.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>
    	<script>
	////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#comptes_vente', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_vente').load('ajax/prefixe_vente.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>