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

	if (isset($_GET['action']) && $_GET['action'] =='add_journaux' ) {

$active_submenu = "add_journaux";
$action = 'add_journaux';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_journaux' ) {
$active_submenu = "list_journaux";
$action = 'list_journaux';}

else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$active_submenu = "list_journaux";
$action = 'edit';}

}
$titre = "ThreeSoft | Comptabilité ";
$active_menu = "saisie";
$header = array('table');
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
<?php

if(isset($_POST['submit']) && $action == 'add_journaux'){
	$errors = array();
		// new object produit
	
	// new object admin produit
	
	$journaux = new Journaux();
	
	
	$journaux->code = htmlentities(trim($_POST['code']));
	$journaux->intitule = htmlentities(trim($_POST['intitule']));
	$journaux->type = htmlentities(trim($_POST['type']));
	
	if (empty($errors)){
if ($journaux->existe()) {
			$msg_error = '<p >  article    : <b>' . $journaux->intitule	 . '</b> existe déja !!!</p><br />';
			
		}else{
			$journaux->save();
			
 		$msg_positif = '<p >  article    :<b> ' . $journaux->intitule	 . '</b> est bien ajouter <a href="journaux.php?action=list_journaux"> Liste des journaux </a></p><br />';
		
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
	$journaux = Journaux:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$journaux = Journaux:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object journaux
	
	// new object admin journaux
	
	$journaux->code = htmlentities(trim($_POST['code']));
	$journaux->intitule = htmlentities(trim($_POST['intitule']));
	$journaux->type = htmlentities(trim($_POST['type']));

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($journaux->save()){
		$msg_positif .= '<p >  article ' . html_entity_decode($journaux->intitule) . '  est modifié  avec succes <a href="journaux.php?action=list_journaux"> Liste des journaux </a> </p><br />';
													
														
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
                       
                        <i class="fa fa-angle-right"></i>
                    </li>
					<li>
                        
                        <a href="produit.php?action=list_produit">Journaux</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_journaux') { 
                        echo  '<a href="journaux.php?action=add_journaux">Ajouter journaux</a> '?>
                        
                        
                    <?php }elseif ($action == 'list_journaux') {
                        echo '<a href="journaux.php?action=list_journaux">Liste des journaux</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="journaux.php?action=edit_journaux">Modifier journaux</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			
		<?php if ($user->type == 'administrateur') {
			
				if ($action == 'list_journaux') {
				
				$journaux = Journaux ::trouve_tous();
				?>
	
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				

		<div class="row">
			
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-cube font-yellow"></i>Journaux <span class="caption-helper"> (<?php echo $Nproduit;?>)</span> 
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group pull-right">
											
											<a href="journaux.php?action=add_journaux" class="btn yellow-crusta pull-right">Nouveau journaux  <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr>
								<th>
									Code 
								</th>
								<th>
									Intitule
								</th>
								
								<th>
									Type 
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($journaux as $journau){
									$cpt ++;
								?>
							<tr>
								<td>
									<a class=" popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?php if (isset($journau->code)) {
									echo  $journau->code . ' ';
									
									echo '  | '. $journau->intitule . ' ';
									
									echo ' | '. $journau->type ;
									
									}  ?>" data-original-title="journaux"><?php if (isset($journau->code)) {
									echo '<i class="fa  fa-barcode font-yellow "></i>  '. $journau->code;
									} ?></a>
								</td>
								<td>
									<b><?php if (isset($journau->intitule)) {
									echo $journau->intitule;
									} ?></b>
								</td>
								
								<td>
									<?php if (isset($journau->type)) {
									echo $journau->type;
									} ?> 
								</td>
								
								
								<td>
									
									<a href="journaux.php?action=edit&id=<?php echo $journau->id; ?>" class="btn blue btn-xs">
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

				}elseif ($action == 'add_journaux') {
					
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
										<div class="caption bold">
											<i class="fa  fa-plus-square font-yellow "></i>Ajouter Journaux
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_journaux" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "code" class="form-control" placeholder="Code" required>
															<span class="input-group-addon ">
															<i class="fa fa-barcode"></i>
															</span>
														</div>

													</div>
												</div>
										
													
												<div class="form-group">
													<label class="col-md-3 control-label">Intitule <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "intitule" class="form-control" placeholder="intitule ">
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Type <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "type" class="form-control" placeholder="type" >
															<span class="input-group-addon ">
															<i class="fa fa-bell"></i>
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
										<div class="caption bold">
											<i class="fa  fa-pencil font-yellow"></i>Modifer journaux
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												
												<div class="form-group">
													<label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "code" class="form-control" placeholder="Code" value ="<?php if (isset($journaux->code)){ echo html_entity_decode($journaux->code); } ?>"required>
															<span class="input-group-addon ">
															<i class="fa fa-barcode "></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Intitule <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "intitule" class="form-control" placeholder="intitule" value ="<?php if (isset($journaux->intitule)){ echo html_entity_decode($journaux->intitule); } ?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Type <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "type" class="form-control" placeholder="type" value ="<?php if (isset($journaux->type)){ echo html_entity_decode($journaux->type); } ?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-bell"></i>
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

			<!-- END PAGE CONTENT-->
		<?php }	} ?> 
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