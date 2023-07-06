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

	if (isset($_GET['action']) && $_GET['action'] =='add_caisse' ) {

$active_submenu = "add_caisse";
$action = 'add_caisse';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_caisse' ) {
$active_submenu = "list_caisse";
$action = 'list_caisse';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$active_submenu = "list_caisse";
$action = 'edit';}
}
$titre = "ThreeSoft | Caisse ";
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

if(isset($_POST['submit']) && $action == 'add_caisse'){
	$errors = array();
		// new object caisse
	
	// new object admin caisse
	
	$caisse = new Caisse();
	$caisse->Code = htmlentities(trim($_POST['Code']));
	$caisse->solde = htmlentities(trim($_POST['solde']));
	if (isset($nav_societe->id_societe)) {
	$caisse->id_societe = $nav_societe->id_societe ;
	}else{ 
	$caisse->id_societe = htmlentities(trim($_POST['id_societe'])); }
	$caisse->Designation = htmlentities(trim($_POST['Designation']));	
	$caisse->comptes_caisse = htmlentities(trim($_POST['comptes_achat']));
	$caisse->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$caisse->journal = htmlentities(trim($_POST['journal']));

	if (empty($errors)){
if ($caisse->existe()) {
			$msg_error = '<p >  caisse    : ' . $caisse->Code	 . ' existe déja !!!</p><br />';
			
		}else{
			$caisse->save();
 		$msg_positif = '<p ">        caisse est bien ajouter  </p><br />';
		
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
	$caisse = Caisse:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$caisse = Caisse:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object caisse
	
	// new object admin caisse
	if (isset($nav_societe->id_societe)) {
	$caisse->id_societe = $nav_societe->id_societe ;
	}else{ 
	$caisse->id_societe = htmlentities(trim($_POST['id_societe'])); }
	$caisse->Code = htmlentities(trim($_POST['Code']));
	$caisse->solde = htmlentities(trim($_POST['solde']));
	$caisse->Designation = htmlentities(trim($_POST['Designation']));	
	$caisse->comptes_caisse = htmlentities(trim($_POST['comptes_achat']));
	$caisse->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$caisse->journal = htmlentities(trim($_POST['journal']));
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($caisse->save()){
		$msg_positif .= '<p >  La caisse ' . html_entity_decode($caisse->Code) . '  est modifié  avec succes </p><br />';
													
														
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
			<div class="container-fluid">
			<!-- BEGIN PAGE CONTENT-->
			
			<!-- BEGIN PAGE HEADER-->
			
			<div class="page-bar">
				<ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Caisses</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_caisse') { ?>
                        <a href="#"><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?></a> 
                        
                        
                    <?php }elseif ($action == 'list_caisse') {
                        echo '<a href="caisse.php?action=list_caisse">Liste des caisse</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="caisse.php?action=edit_caisse">Modifier caisse</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
				if ($action == 'list_caisse') {
				
				?>
				<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
					if (isset($nav_societe->id_societe)) {
					$caisses = Caisse::trouve_par_societe($nav_societe->id_societe); 
					}
					
				
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="icon-share font-yellow-sunglo"></i>Liste des caisses 
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											
											<a href="caisse.php?action=add_caisse" class="btn yellow">Nouvelle caisse <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped  table-hover" id="sample_2">
							<thead>
							<tr>
								
								<th>
									Caisse
								</th>
								<?php if (isset($nav_societe->id_societe)) {
							echo "<th>
									Société
								</th>";
								} ?>
								
								
								<th>
									Code 
								</th>								
								<th>
									Compte  
								</th>
								
								<th>
									Auxiliere 
								</th>
								<th>
									Journal
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($caisses as $caisse){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
								<i class="fa fa-inbox font-yellow"></i>
									<b><?php if (isset($caisse->Designation)) {
									echo $caisse->Designation;
									} ?></b>
								</td>

							
								<?php if (isset($nav_societe->id_societe)) {?>
								<td>
									<?php if (isset($caisse->id_societe)) {
									$Societe = Societe::trouve_par_id($caisse->id_societe); 
									if (isset($Societe->Dossier)) {
										echo $Societe->Dossier;
									}
									} ?>
								</td>
								<?php } ?>
								<td>
									<?php if (isset($caisse->Code)) {
									echo $caisse->Code;
									} ?>
								</td>
								
								<td>
									
									<?php if (isset($caisse->comptes_caisse)) {
															$Compte = Compte_comptable::trouve_par_id($caisse->comptes_caisse); }
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}?>
								</td>
								
								<td>
									<?php if (isset($caisse->auxiliere_achat)) {
															$auxilieres = Auxiliere::trouve_par_id($caisse->auxiliere_achat);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;} else{ echo "/";}?>
								</td>
								<td>
									
									<?php if (isset($caisse->journal)) {
															$journal = Journaux::trouve_par_id($caisse->journal);
															
															}
															
																
																	if (isset($journal->intitule)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $journal->intitule ;}?>
								</td>
								<td>
									
									<a href="caisse.php?action=edit&id=<?php echo $caisse->id_caisse; ?>" class="btn blue btn-sm">
                                                    <i class="fa fa-edit "></i> Edit</a>
									
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

				}elseif ($action == 'add_caisse') {		
				  ?>

			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
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
											<i class="fa fa-bank "></i>Ajouter caisse
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_caisse" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Caisse *</label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Designation" class="form-control" placeholder="caisse" required>
															<span class="input-group-addon ">
															<i class="fa fa-fa-bank "></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Code *</label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Code" class="form-control" placeholder="Code caisse" required>
															<span class="input-group-addon ">
															<i class="fa fa-home"></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Solde </label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "solde" class="form-control" placeholder="Solde caisse" >
															<span class="input-group-addon ">
															<i class="fa fa-home"></i>
															</span>
														</div>

													</div>
												</div>
												
																						
												
											<?php if (!isset($nav_societe->id_societe)) {?>
											<div class="form-group">
                                                <label class="col-md-3 control-label"> Société </label>
                                                <div class="col-md-6">                                                                                            
                                              
												<select class="form-control select2me" data-live-search="true"  name="id_societe" required>
															<?php
                                                            $societes = Societe::trouve_tous(); 
												foreach($societes as $societe){	
														echo '<option  value = "'.$societe->id_societe.'" >'.$societe->Dossier.'</option>';
														}  ?>															   
														</select>   
                                                </div>
                                            </div>
                                        <?php } ?>
												
													<div class="form-group">
													<label class="col-md-3 control-label">Compte  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control select2me" id="comptes_achat"  name="comptes_achat">
												
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
													<label class="col-md-3 control-label">Journal <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control select2me"   name="journal">
												
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
											<i class="fa fa-archive"></i>Editer Caisse
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">Caisse *</label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Designation" class="form-control" placeholder="caise" value ="<?php if (isset($caisse->Designation)){ echo html_entity_decode($caisse->Designation); } ?>"required>
															<span class="input-group-addon ">
															<i class="fa fa-fa-bank "></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Code *</label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Code" class="form-control" placeholder="Code caisse" value ="<?php if (isset($caisse->Code)){ echo html_entity_decode($caisse->Code); } ?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-home"></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Solde </label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "solde" class="form-control" placeholder="Solde caisse" value ="<?php if (isset($caisse->solde)){ echo html_entity_decode($caisse->solde); } ?>" >
															<span class="input-group-addon ">
															<i class="fa fa-home"></i>
															</span>
														</div>

													</div>
												</div>																						
												
												<?php if (!isset($nav_societe->id_societe)) {?>
												<div class="form-group">
                                                <label class="col-md-3 control-label"> Société </label>
                                                <div class="col-md-6">                                                                                            
                                              
												<select class="form-control select2me" data-live-search="true" id="id_pro"  name="id_societe" required>
															<?php
                                                            $societes = Societe::trouve_tous(); 
												foreach($societes as $societe){	?>
														<option  <?php if ($caisse->id_societe == $societe->id_societe ) { echo 'selected';} ?> value = "<?php if(isset($societe->id_societe)){echo $societe->id_societe;} ?>" ><?php echo $societe->Dossier ; ?></option>';
													<?php	}  ?>															   
														</select>   
                                                </div>
                                            </div>
                                        <?php } ?>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Compte  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control select2me" id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option  <?php if ($Compte->id == $caisse->comptes_caisse) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
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

														 
														 $Compt = Compte_comptable::trouve_par_id($caisse->comptes_caisse);
														
															  ?>	
														<div class="input-group">
														<select class="form-control select2me" <?php if($Compt->aux == 0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $caisse->comptes_achat) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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
													<label class="col-md-3 control-label">Journal <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control select2me"   name="journal">
												
															<?php 															
															$journals = Journaux::trouve_tous();
															
															foreach($journals as $journal){?>

														<option <?php if ($journal->id == $caisse->journal) { echo "selected";} ?> value = "<?php echo $journal->id ?>"  > <?php echo $journal->code .' | '. $journal->intitule ?></option>
														
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
	<script>
	////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#comptes_achat', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_achat').load('ajax/prefixe.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>