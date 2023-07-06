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
		$msg_system ="vou<pa></pa>s le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_compo<sition_temp></sition_temp>late('simple_footer.php');
		exit();
	} 
}
?>
<?php
if ($user->type == "administrateur"){

	if (isset($_GET['action']) && $_GET['action'] =='add_bilan_actif' ) {

$active_submenu = "bilan_actif";
$action = 'add_bilan_actif';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_bilan_actif' ) {
$active_submenu = "bilan_actif";
$action = 'list_bilan_actif';}
else if (isset($_GET['action']) && $_GET['action'] =='add_bilan_passif' ) {
$active_submenu = "list_bilan_passif";
$action = 'add_bilan_passif';}
else if (isset($_GET['action']) && $_GET['action'] =='add_tcr' ) {
$active_submenu = "list_tcr";
$action = 'add_tcr';}
else if (isset($_GET['action']) && $_GET['action'] =='list_bilan_passif' ) {
$active_submenu = "bilan";
$action = 'list_bilan_passif';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$active_submenu = "bilan_actif";
$action = 'edit';}
}
$titre = "ThreeSoft | Bilan";
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

if(isset($_POST['submit']) && $action == 'add_bilan_actif'){
	$errors = array();
		// new object Bilan_actif
	
	// new object admin Bilan_actif
	
	$bilan_actif = new Bilan_actif();
	
	
	$bilan_actif->actif = htmlentities(trim($_POST['actif']));
	$bilan_actif->montants_bruts = htmlentities(trim($_POST['montants_bruts']));
	$bilan_actif->amortissement_provision_pertes = htmlentities(trim($_POST['amortissement_provision_pertes']));
	

	if (empty($errors)){
if ($bilan_actif->existe()) {
			$msg_error = '<p >  Bilan_actif    : ' . $bilan_actif->actif	 . ' existe déja !!!</p><br />';
			
		}else{
			$bilan_actif->save();
 		$msg_positif = '<p ">        Bilan_actif est bien ajouter  </p><br />';
		
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

if(isset($_POST['submit']) && $action == 'add_bilan_passif'){
	$errors = array();
		// new object Bilan_passif
	
	// new object admin Bilan_passif
	
	$bilan_passif = new Bilan_passif();
	
	
	$bilan_passif->actif = htmlentities(trim($_POST['actif']));
	
	

	if (empty($errors)){
if ($bilan_passif->existe()) {
			$msg_error = '<p >  bilan_passif    : ' . $bilan_passif->actif	 . ' existe déja !!!</p><br />';
			
		}else{
			$bilan_passif->save();
 		$msg_positif = '<p ">     ' . $bilan_passif->actif	 . '   est bien ajouter  </p><br />';
		
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
if(isset($_POST['submit']) && $action == 'add_tcr'){
	$errors = array();
		// new object tcr
	
	// new object admin tcr
	
	$tcr = new Tcr();
	
	
	$tcr->rubriques = htmlentities(trim($_POST['rubriques']));
	
	

	if (empty($errors)){
if ($tcr->existe()) {
			$msg_error = '<p >  tcr    : ' . $tcr->rubriques	 . ' existe déja !!!</p><br />';
			
		}else{
			$tcr->save();
 		$msg_positif = '<p ">     ' . $tcr->rubriques	 . '   est bien ajouter  </p><br />';
		
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
	$bilan_actif = Bilan_actif:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$bilan_actif = Bilan_actif:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object actif
	
	// new object admin actif
	
		$bilan_actif->actif = htmlentities(trim($_POST['actif']));
		

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($bilan_actif->save()){
		$msg_positif .= '<p >  article ' . html_entity_decode($bilan_actif->actif) . '  est modifié  avec succes </p><br />';
													
														
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
                        <a href="#">Bilan</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_bilan_actif') { 
                         echo '<a href="bilan.php?action=add_bilan_actif">Ajouter bilan actif</a> ';
                        
                        
                    }elseif ($action == 'list_bilan_actif') {
                        echo '<a href="bilan.php?action=list_bilan_actif">Liste bilan actif</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="bilan.php?action=edit">Modifier bilan actif</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			
		<?php if ($user->type == 'administrateur') {
			
				
				$Bilan_actif = Bilan_actif::trouve_tous(); 
				$cpt = 0; 
				if ($action == 'list_bilan_actif') {
				
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
								<i class="icon-share font-blue-hoki"></i>Bilan_actifs<span class="caption-helper"> (<?php echo $Nfamil;?>)</span>
							</div>
						</div>

							
						<div class="portlet-body">
							<table class="table table-striped table-hover" >
							<thead>
							<tr>

								<th>
									Bilan_actifs
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($Bilan_actif as $Bilan_actifs){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
									<b><?php if (isset($Bilan_actifs->actif)) {
									echo $Bilan_actifs->actif;
									} ?></b>
								</td>
								
							
								
								<td>
									
									<a href="bilan.php?action=edit&id=<?php echo $Bilan_actifs->id; ?>" class="btn blue btn-xs">
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
			
				</div>
			</div>
			<?php  

				}elseif ($action == 'list_bilan_passif') {
					$Bilan_passif = Bilan_passif::trouve_tous();					
				  ?>
					<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="icon-share font-blue-hoki"></i>Bilan passif<span class="caption-helper"> (<?php echo $Nfamil;?>)</span>
							</div>
						</div>

							
						<div class="portlet-body">
							<table class="table table-striped table-hover" >
							<thead>
							<tr>

								<th>
									Bilan passif
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($Bilan_passif as $Bilan_passifs){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
									<b><?php if (isset($Bilan_passifs->actif)) {
									echo $Bilan_passifs->actif;
									} ?></b>
								</td>
								
							
								
								<td>
									
									<a href="bilan.php?action=edit_bilan_passif&id=<?php echo $Bilan_passifs->id; ?>" class="btn blue btn-xs">
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
			
				</div>
			</div>
			<?php  

				}elseif ($action == 'add_bilan_actif') {		
				  ?>

			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-10">
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
											<i class="fa  fa-shopping-cart "></i>Ajouter une add_bilan_actif
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_bilan_actif" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
											<div class="form-group">
													<label class="col-md-3 control-label">add_bilan_actif *</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "actif" class="form-control" placeholder="actif" required>
															<span class="input-group-addon ">
															<i class="">add_bilan_actif</i>
															</span>
														</div>

													</div>
											</div>
											<div class="form-group">
													<label class="col-md-3 control-label">montants_bruts *</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "montants_bruts" class="form-control" placeholder="montants_bruts" >
															<span class="input-group-addon ">
															<i class="">montants_bruts</i>
															</span>
														</div>

													</div>
											</div>
											<div class="form-group">
													<label class="col-md-3 control-label">amortissement_provision_pertes *</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "amortissement_provision_pertes" class="form-control" placeholder="amortissement_provision_pertes" >
															<span class="input-group-addon ">
															<i class="">amortissement_provision_pertes</i>
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

				}elseif ($action == 'add_bilan_passif') {		
				  ?>

			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-10">
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
											<i class="fa  fa-shopping-cart "></i>Ajouter bilan passif
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_bilan_passif" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
											<div class="form-group">
													<label class="col-md-3 control-label">add_bilan_passif *</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "actif" class="form-control" placeholder="actif" required>
															<span class="input-group-addon ">
															
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

				}elseif ($action == 'add_tcr') {		
				  ?>

			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-10">
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
											<i class="fa  fa-shopping-cart "></i>Ajouter tcr
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_tcr" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
											<div class="form-group">
													<label class="col-md-3 control-label">rubriques *</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "rubriques" class="form-control" placeholder="rubriques" required>
															<span class="input-group-addon ">
															
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
				<div class="col-md-10">
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
											<i class="fa  fa-shopping-cart"></i>Editer Bilan actif
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">actif *</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "actif" class="form-control" placeholder="actif" value ="<?php if (isset($bilan_actif->actif)){ echo html_entity_decode($bilan_actif->actif); } ?>"required>
															<span class="input-group-addon ">
															<i class="">actif</i>
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