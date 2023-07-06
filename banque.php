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

	if (isset($_GET['action']) && $_GET['action'] =='add_banque' ) {

$active_submenu = "add_banque";
$action = 'add_banque';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_banque' ) {
$active_submenu = "list_banque";
$action = 'list_banque';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$active_submenu = "list_banque";
$action = 'edit';}
}
$titre = "ThreeSoft | Banque ";
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

if(isset($_POST['submit']) && $action == 'add_banque'){
	$errors = array();
		// new object Banque
	
	// new object admin Banque
	
	$banque = new Compte();
	
	$banque->id_banque = htmlentities(trim($_POST['id_banque']));
	$banque->journal = htmlentities(trim($_POST['journal']));
	$banque->solde = htmlentities(trim($_POST['solde']));
	$banque->num_compte = htmlentities(trim($_POST['num_compte']));
	$banque->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$banque->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$banque->compte_defaut = htmlentities(trim($_POST['compte_defaut']));
	$banque->id_societe = $nav_societe->id_societe;

	

	if (empty($errors)){
if ($banque->existe()) {
			$msg_error = '<p >  banque existe déja !!!</p><br />';
			
		}else{
			$banque->save();
 		$msg_positif = '<p ">        banque est bien ajouter  </p><br />';
		
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
	$compte_banque = Compte:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$compte_banque = Compte:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object comptes
	$updat_compte=Compte::annuler_par_defaut($compte_banque->id_societe);
	// new object admin comptes
	$compte_banque->id_banque = htmlentities(trim($_POST['id_banque']));
	$compte_banque->journal = htmlentities(trim($_POST['journal']));
	$compte_banque->solde = htmlentities(trim($_POST['solde']));
	$compte_banque->num_compte = htmlentities(trim($_POST['num_compte']));
	$compte_banque->comptes_achat = htmlentities(trim($_POST['comptes_achat']));
	$compte_banque->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	
	$compte_banque->compte_defaut = htmlentities(trim($_POST['compte_defaut']));
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
 		if ($compte_banque->save()){
			
		$msg_positif .= '<p >  La banque   est modifié  avec succes </p><br />';
													
														
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
                        <a href="#">Banques</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_banque') { ?>
                        <a href="banque.php?action=add_banque">Ajouter banque</a> 
                    <?php }elseif ($action == 'list_banque') {
                        echo '<a href="banque.php?action=list_banque">Liste des banques</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="banque.php?action=edit_banque">Modifier banque</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
					if ($action == 'list_banque') {
				
				?>
				<div class="row">
				<div class="col-md-12">
					 
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				if (isset($nav_societe->Dossier)){
					
				$banques = Compte::trouve_compte_par_societe($nav_societe->id_societe); 
				}
					else{
						$banques = Banque::trouve_tous();
					}
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa fa-university font-yellow"></i>Liste des Banques 
							</div>
						</div>
						<div class="btn-group">
											
											<a href="banque.php?action=add_banque" class="btn red">Nouveau <i class="fa fa-plus"></i></a>
											
										</div>
				
							
						<div class="portlet-body">
							<table class="table table-striped  table-hover" id="sample_2">
							<thead>
							<tr>
								
								<th>
									Banque
								</th>
								<th>
									Abreviation
								</th>
								
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
									Compte par defaut
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($banques as $banque){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
								<i class="fa fa-university font-yellow"></i>
								<?php if (isset($banque->id_banque)) {
										$bank = Banque::trouve_par_id($banque->id_banque);
										if (isset($bank->Designation)) {
											echo $bank->Designation;
											}					
									}
									?>	
									
								</td>
								<td>
								<?php if (isset($banque->id_banque)) {
										$bank = Banque::trouve_par_id($banque->id_banque);
										if (isset($bank->abreviation)) {
											echo $bank->abreviation;
											}					
									}
									?>
									
								</td>
								<td>
								<?php if (isset($banque->id_banque)) {
										$bank = Banque::trouve_par_id($banque->id_banque);
										if (isset($bank->Code)) {
											echo $bank->Code;
											}					
									}
									?>
									
								</td>
								
								
								
								<td>
									
									<?php if (isset($banque->comptes_achat)) {
															$Compte = Compte_comptable::trouve_par_id($banque->comptes_achat);
															
															}
															if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}?>
								</td>
								
								<td>
									<?php if (isset($banque->auxiliere_achat)) {
															$auxilieres = Auxiliere::trouve_par_id($banque->auxiliere_achat);
															
															}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;} else{ echo '/'; }?>
								</td>
								<td>
									
									<?php if (isset($banque->journal)) {
											$journal = Journaux::trouve_par_id($banque->journal);
											}
											if (isset($journal->intitule)) {
												echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $journal->intitule ;}?>
								</td>
								<td>
									<?php if (isset($banque->compte_defaut) && $banque->compte_defaut ==1 ){										
										echo '<span class="fa fa-check font-green"></span>';				
									}
									?>
								</td>
								<td>
									
									<a href="banque.php?action=edit&id=<?php echo $banque->id; ?>" class="btn blue btn-sm">
                                                    <i class="fa fa-edit "></i></a>
									
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

				}elseif ($action == 'add_banque') {		
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


                                <div class="portlet box red">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-bank "></i>Ajouter Banque
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_banque" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Banque <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														
															<select class="form-control select2me" id="id_banque"  name="id_banque">
												
															<?php 															
															$banques = Banque::trouve_tous();
															
															foreach($banques as $banque){?>

														<option  value = "<?php echo $banque->id_banque ?>"  > <?php echo $banque->Code .' | '. $banque->Designation ;?></option>
														
															<?php } ?>															   
														</select>
													

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Solde  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
													<div class="input-group">
													<input type="text" class="form-control" name="solde" placeholder="10000000.00"/>
													<span class="input-group-addon ">
															<i class="fa fa-dollar "></i>
															</span>
													</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">N° compte  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
													<div class="input-group">
													<input type="text" maxlength="17" placeholder="17 chiffres" class="form-control" name="num_compte" />
													<span class="input-group-addon ">
															<i class="fa fa-dollar "></i>
															</span>
													</div>
													</div>
												</div>
											
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
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														 
														 $Compt = Compte_comptable::trouve_par_id($Compte->id);
														
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe, $nav_societe->id_societe);
														foreach($Aux as $Auxs){?>
														
														<option  value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code ?></option>
														
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
														
														<select class="form-control " id="journal"  name="journal">
												
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
													<label class="col-md-3 control-label">Compte par défaut <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control"   name="compte_defaut">
														<option value = "0"  > Non</option>
														<option value = "1"  > Oui</option>									   
														</select>
														<span class="input-group-addon ">
															<i class="fa fa-check "></i>
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


                                <div class="portlet light">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-bank"></i>Editer Banque
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">Banque *</label>
													<div class="col-md-4">
														
														<select class="form-control select2me" id="id_banque"  name="id_banque">
												
															<?php 
															 $banquee= Banque::trouve_tous();
																foreach ($banquee as $banque){	 ?>	
																<option <?php if ($compte_banque->id_banque == $banque->id_banque) { echo "selected";} ?> value="<?php if(isset( $banque->id_banque)){ echo  $banque->id_banque;}?>"  ><?php echo $banque->Code .' | '. $banque->Designation ;?></option>													   
														
														<?php }?>	</select>
													

													</div>
												</div>
											
												<div class="form-group">
													<label class="col-md-3 control-label">Solde  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
													<div class="input-group">
													<input type="number" class="form-control" name="solde" placeholder="10000000.00" value="<?php if (isset($compte_banque->solde)){ echo html_entity_decode($compte_banque->solde); }?>"/>
													<span class="input-group-addon ">
															<i class="fa fa-dollar "></i>
															</span>
													</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">N° de compte  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
													<div class="input-group">
													<input type="text" maxlength="17" placeholder="17 chiffres" class="form-control" name="num_compte" placeholder="32658989" value="<?php if (isset($compte_banque->num_compte)){echo  html_entity_decode($compte_banque->num_compte); }?>" />
													<span class="input-group-addon ">
															<i class="fa fa-dollar "></i>
															</span>
													</div>
													</div>
												</div>
												
												
												<div class="form-group">
													<label class="col-md-3 control-label">Compte  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control select2me" id="comptes_achat"  name="comptes_achat">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option  <?php if ($Compte->id == $compte_banque->comptes_achat) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
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

														 
														 $Compt = Compte_comptable::trouve_par_id($compte_banque->comptes_achat);
														
															  ?>	
														<div class="input-group">
														<select class="form-control select2me" <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $compte_banque->comptes_achat) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
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

														<option <?php if ($journal->id == $compte_banque->journal) { echo "selected";} ?> value = "<?php echo $journal->id ?>"  > <?php echo $journal->code .' | '. $journal->intitule ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Compte par défaut <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control"   name="compte_defaut">												

														<option <?php if ($compte_banque->compte_defaut == 1) { echo "selected";} ?> value = "1"  > Oui</option>
														<option <?php if ($compte_banque->compte_defaut == 0) { echo "selected";} ?> value = "0"  > Non</option>
																												   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-check "></i>
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