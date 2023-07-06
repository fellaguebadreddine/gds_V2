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

	if (isset($_GET['action']) && $_GET['action'] =='add' ) {

$active_submenu = "add_comptes";
$action = 'add';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_comptes' ) {
$active_submenu = "list_comptes";
$action = 'list_comptes';}

else if (isset($_GET['action']) && $_GET['action'] =='edit_comptes' ) {
$active_submenu = "list_comptes";
$action = 'edit_comptes';}

else if (isset($_GET['action']) && $_GET['action'] =='list_auxiliere' ) {
$active_submenu = "list_comptes";
$action = 'list_auxiliere';}
else if (isset($_GET['action']) && $_GET['action'] =='add_auxiliere' ) {
$active_submenu = "list_comptes";
$action = 'add_auxiliere';}
else if (isset($_GET['action']) && $_GET['action'] =='edit_aux' ) {
$active_submenu = "list_comptes";
$action = 'edit_aux';}
else if (isset($_GET['action']) && $_GET['action'] =='add_compt' ) {
$active_submenu = "";
$action = 'add_compt';}
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

if(isset($_POST['submit']) && $action == 'add'){
	$errors = array();
		// new object add_comptes
	
	// new object admin add_comptes
	
	$comptes = new Compte_auxiliere();
	
	
	
	$comptes->aux = htmlentities(trim($_POST['aux']));
	$comptes->prefixe = htmlentities(trim($_POST['prefixe']));
	$comptes->id_societe = $nav_societe->id_societe;
	if (empty($errors)){
if ($comptes->existe()) {
			$msg_error = '<p >  article    : <b>' . $comptes->code	 . '</b> existe déja !!!</p><br />';
			
		}else{
			$comptes->save();
			
 		$msg_positif = '<p >  article    :<b> ' . $comptes->code	 . '</b> est bien ajouter <a href="journaux.php?action=list_journaux"> Liste des journaux </a></p><br />';
		
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


	if($action == 'edit_comptes' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$comptes = compte_comptable:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$comptes = compte_comptable:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object comptes
	
	// new object admin comptes
	
	
	
	$comptes->libelle = htmlentities(trim($_POST['libelle']));
	$comptes->aux = htmlentities(trim($_POST['aux']));
	$comptes->prefixe = htmlentities(trim($_POST['prefixe']));
	$comptes->id_societe = $nav_societe->id_societe;

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($comptes->save()){
		$msg_positif .= '<p >  article ' . html_entity_decode($comptes->libelle) . '  est modifié  avec succes <a href="compte_comptable.php?action=list_comptes"> Liste des comptes </a> </p><br />';
													
														
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
	if(isset($_POST['submit']) && $action == 'add_auxiliere'){
	$errors = array();
		// new object add_comptes
	
	// new object admin add_comptes
	
	$Auxilieres = new Auxiliere();
	
	
	$Auxilieres->code = htmlentities(trim($_POST['code']));
	$Auxilieres->libelle = htmlentities(trim($_POST['libelle']));
	$Auxilieres->activite = htmlentities(trim($_POST['raison']));
	$Auxilieres->rc = htmlentities(trim($_POST['rc']));
	$Auxilieres->mf = htmlentities(trim($_POST['mf']));
	$Auxilieres->ai = htmlentities(trim($_POST['ai']));
	$Auxilieres->nis = htmlentities(trim($_POST['nis']));
	$Auxilieres->adresse = htmlentities(trim($_POST['adresse']));
	$Auxilieres->id_societe = $nav_societe->id_societe;
	
	if (empty($errors)){
if ($Auxilieres->existe()) {
			$msg_error = '<p >  Auxiliere    : <b>' . $Auxilieres->code	 . '</b> existe déja !!!</p><br />';
			
		}else{
			$Auxilieres->save();
			
 		$msg_positif = '<p >  Auxiliere    :<b> ' . $Auxilieres->code	 . '</b> est bien ajouter <a href="compte_comptable.php?action=list_auxiliere"> Liste des auxilieres </a></p><br />';
		
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

	if(isset($_POST['submit']) && $action == 'add_compt'){
	$errors = array();
		// new object add_comptes
	
	// new object admin add_comptes
	
	$compts = new Compte_comptable();
	
	
	$compts->code = htmlentities(trim($_POST['code']));
	$compts->libelle = htmlentities(trim($_POST['libelle']));
	$compts->aux = htmlentities(trim($_POST['aux']));
	$compts->prefixe = htmlentities(trim($_POST['prefixe']));
	$compts->id_societe = $nav_societe->id_societe;
	
	if (empty($errors)){
if ($compts->existe()) {
			$msg_error = '<p >  article    : <b>' . $compts->code	 . '</b> existe déja !!!</p><br />';
			
		}else{
			$compts->save();
			
	
 		$msg_positif = '<p >  article    :<b> ' . $compts->code	 . '</b> est bien ajouter <a href="compte_comptable.php?action=list_comptes"> Liste des list_comptes </a></p><br />';
		
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
	if($action == 'edit_aux' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$Auxilieres = Auxiliere:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$Auxilieres = Auxiliere:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object client
	
	$Auxilieres->code = htmlentities(trim($_POST['code']));
	$Auxilieres->libelle = htmlentities(trim($_POST['libelle']));
	$Auxilieres->activite = htmlentities(trim($_POST['raison']));
	$Auxilieres->rc = htmlentities(trim($_POST['rc']));
	$Auxilieres->mf = htmlentities(trim($_POST['mf']));
	$Auxilieres->ai = htmlentities(trim($_POST['ai']));
	$Auxilieres->nis = htmlentities(trim($_POST['nis']));
	$Auxilieres->adresse = htmlentities(trim($_POST['adresse']));
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($Auxilieres->save()){
		$msg_positif .= '<p >  Auxilieres ' . html_entity_decode($Auxilieres->libelle) . '  est modifié  avec succes </p><br />';
				
			
		
														
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
                       
                        <i class="fa fa-angle-right"></i>
                    </li>
					<li>
                        
                        <a href="compte_comptable.php?action=list_comptes">Plan comptable </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add') { 
                        echo  '<a href="compte_comptable.php?action=add">Ajouter compte_comptable</a> '?>
                        
                        
                    <?php }elseif ($action == 'list_comptes') {
                        echo '<a href="compte_comptable.php?action=list_comptes">Liste des compte_comptable</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="compte_comptable.php?action=edit_comptes">Modifier compte_comptable</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			
		<?php if ($user->type == 'administrateur') {
			
				if ($action == 'list_comptes') {
					require_once("header/menu-plan-comptable.php");
				$compte_auxilieres = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
				
				?>
	
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				

		<div class="row">
				<div class="col-md-12">
						
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-cube font-yellow"></i>Plan comptable  <span class="caption-helper"> (<?php echo $Nproduit;?>)</span> 
							</div>
						</div>
					<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group pull-right">
											
											<a href="compte_comptable.php?action=add_compt" class="btn yellow pull-right ">Nouveau Compte <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr >
								<th width="30%">
									Compte 
								</th>
								<th>
									Intitule
								</th>
								
								<th>
									Auxilière 
								</th>
								<th>
									Préfixe 
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($compte_auxilieres as $compte_auxiliere){
									
								?>
							<tr>
								<td>
									
									<?php if (isset($compte_auxiliere->id)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($compte_auxiliere->id);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo  '<i class="fa  fa-barcode font-yellow "></i> ' . $Compte->code ;}}?>
								</td>
								
								<td>
								<?php if (isset($compte_auxiliere->id)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($compte_auxiliere->id);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->libelle)) {
															echo $Compte->libelle ;}}?>
								</td>
								
								<td>
									<?php if ($compte_auxiliere->aux == '1') { ?>
                                    <span class="label label-sm bg-green-jungle">
									OUI </span> 
                                  <?php } else{  ?> 
                                    <span class="label label-sm label-danger">
									NON </span> 
                                <?php    } ?> 
								</td>
								<td>
									<?php if (isset($compte_auxiliere->prefixe)) {
									echo $compte_auxiliere->prefixe;
									}else if (empty($compte_auxiliere->prefixe)){ echo '/';} ?> 
								</td>
								
								<td>
									
									<a href="compte_comptable.php?action=edit_comptes&id=<?php echo $compte_auxiliere->id; ?>" class="btn blue btn-xs">
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
	
          
			<?php }  elseif ($action == 'edit_comptes') { 
				require_once("header/menu-plan-comptable.php");
			?>
	
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
											<i class="fa  fa-pencil font-yellow"></i>Modifer Comptes
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit_comptes"  method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												
												<div class="form-group">
													<label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "code" class="form-control" placeholder="Code" disabled="" value ="<?php if (isset($comptes->code)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($comptes->id);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->code)) {
															echo $Compte->code ;}}?>"required>
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
															<input type="text" name = "libelle" class="form-control" placeholder="intitule" value ="<?php if (isset($comptes->id)) {
															$Comptes = Compte_comptable::trouve_compte_par_id_compte($comptes->id);
															
															}
															foreach ($Comptes as $Compte){
																
																	if (isset($Compte->libelle)) {
															echo $Compte->libelle ;}}?>"required>
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Auxilière </label>
													<div class="col-md-3">
														<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="aux" id="optionsRadios25" value="1" <?php if ($comptes->aux ==1){ echo 'checked';}?>  onclick="EnableDisableTextBox()"> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="aux" id="optionsRadios26" value="0" <?php if ( $comptes->aux ==0){ echo 'checked';}?>  onclick="EnableDisableTextBox()"> Non </label>
															<label class="radio-inline">
															
														</div>
													</div>
														
														
													</div>
												</div>
											
												<div class="form-group">
													<label class="col-md-3 control-label">Préfixe </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "prefixe" id="prefixe" class="form-control" placeholder="Préfixe"  disabled="false" value ="<?php if (!empty($comptes->prefixe)){ echo html_entity_decode($comptes->prefixe); }else {  "disabled = 'true' " ;} ?>" >
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
						<?php }  elseif ($action == 'add_compt') { 
				require_once("header/menu-plan-comptable.php");
			?>
	
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
											<i class="fa  fa-pencil font-yellow"></i>Nouveau Compte
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_compt"  method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												
												<div class="form-group">
													<label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "code" class="form-control" placeholder="Code" required>
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
															<input type="text" name = "libelle" class="form-control" placeholder="intitule" required>
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Auxilière </label>
													<div class="col-md-3">
														<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="aux" id="optionsRadios25" value="1" onclick="EnableDisableTextBox()"  > Oui </label>
															<label class="radio-inline">
															<input type="radio" name="aux" id="optionsRadios26" value="0" onclick="EnableDisableTextBox()" Checked> Non </label>
															<label class="radio-inline">
															
														</div>
													</div>
														
														
													</div>
												</div>
											
												<div class="form-group">
													<label class="col-md-3 control-label">Préfixe </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "prefixe" id="prefixe" class="form-control" placeholder="Préfixe" disabled>
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
														<button type="button" value="back" onclick="history.go(-1)" class="btn  default">Annuler</button>
														
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
			<?php  

				}elseif ($action == 'add') {
					require_once("header/menu-plan-comptable.php");
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
											<i class="fa  fa-plus-square font-yellow "></i>Ajouter Compte
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">Compte comptable <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "code" class="form-control" placeholder="Code"  >
															<span class="input-group-addon ">
															<i class="fa fa-bell"></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Auxiliere <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="aux" id="optionsRadios25" value="1" checked> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="aux" id="optionsRadios26" value="0" checked> Non </label>
															<label class="radio-inline">
															
														</div> 
															
															<span class="input-group-addon " required >
															<i class="fa fa-table"></i>
															</span>
														</div>

													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Préfixe </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "prefixe" class="form-control" placeholder="Préfixe"  >
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
				<?php  

				}elseif ($action == 'list_auxiliere') {
					$auxilieres = Auxiliere::trouve_auxilere_par_societe($nav_societe->id_societe); 
					require_once("header/menu-plan-comptable.php");
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
											<i class="fa  fa-plus-square font-yellow "></i>Auxilière
										</div>

									</div>
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group pull-right">
											
											<a href="compte_comptable.php?action=add_auxiliere" class="btn yellow pull-right ">Nouveau Auxiliere <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr >
								<th >
									Code 
								</th>
								<th>
									Libelle
								</th>
								
								<th>
									Raison 
								</th>
								<th>
									Rc 
								</th>
								<th>
									Mf 
								</th>
								<th>
									Ai 
								</th>
								<th>
									Nis 
								</th>
								<th>
									Adresse 
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($auxilieres as $auxiliere){
									
								?>
							<tr>
								<td>
									<a class=" popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?php if (isset($auxiliere->code)) {
									echo  $auxiliere->code . ' ';
									
									echo '  | '. $auxiliere->libelle . ' ';
									
									
									
									}  ?>" data-original-title="journaux"><?php if (isset($auxiliere->code)) {
									echo '<i class="fa  fa-barcode font-yellow "></i>  '. $auxiliere->code;
									} ?></a>
								</td>
								
								
								<td>
									<?php if (isset($auxiliere->libelle)) {
									echo $auxiliere->libelle;
									} ?>
								</td>
								<td>
									<?php if (isset($auxiliere->raison)) {
									echo $auxiliere->raison;
									} ?>
								</td>
								<td>
									<?php if (isset($auxiliere->rc)) {
									echo $auxiliere->rc;
									} ?>
								</td>
								<td>
									<?php if (isset($auxiliere->mf)) {
									echo $auxiliere->mf;
									} ?>
								</td>
								<td>
									<?php if (isset($auxiliere->ai)) {
									echo $auxiliere->ai;
									} ?>
								</td>
								<td>
									<?php if (isset($auxiliere->nis)) {
									echo $auxiliere->nis;
									} ?>
								</td>
								<td>
									<?php if (isset($auxiliere->adresse)) {
									echo $auxiliere->adresse;
									} ?>
								</td>
								<td>
									
									<a href="compte_comptable.php?action=edit_aux&id=<?php echo $auxiliere->id; ?>" class="btn blue btn-xs">
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

	}elseif ($action == 'add_auxiliere') {
			$auxilieres = Auxiliere :: trouve_auxilere_par_societe($nav_societe->id_societe);
		require_once("header/menu-plan-comptable.php");
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
											<i class="fa  fa-plus-square font-yellow "></i>Nouveau Auxilière
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_auxiliere" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-2">
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
															<input type="text" name = "libelle" class="form-control" placeholder="libelle " required>
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Activité <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "raison" class="form-control" placeholder="Raison " required>
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Rc *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "rc" class="form-control" placeholder="RC " required>
															<span class="input-group-addon ">
															<i class="">RC</i>
															</span>
															
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Mf *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "mf" class="form-control" placeholder="Mf " required>
															<span class="input-group-addon ">
															<i class="">Mf</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Ai *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "ai" class="form-control" placeholder="Ai " required>
															<span class="input-group-addon ">
															<i class="">Ai</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Nis </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "nis" class="form-control" placeholder="Nis " >
															<span class="input-group-addon ">
															<i class="">Nis</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Adresse </label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "adresse" class="form-control" placeholder="Adresse " required>
															<span class="input-group-addon ">
															<i class="fa fa-map-marker"></i>
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
		<?php  

	}elseif ($action == 'edit_aux') {
			
		require_once("header/menu-plan-comptable.php");
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
											<i class="fa  fa-plus-square font-yellow "></i>Edit Auxilière
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit_aux" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Code  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "code" class="form-control" placeholder="libelle " value ="<?php if (!empty($Auxilieres->code)){ echo html_entity_decode($Auxilieres->code); }?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
										
													
												<div class="form-group">
													<label class="col-md-3 control-label">Intitule <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "libelle" class="form-control" placeholder="libelle " value ="<?php if (!empty($Auxilieres->libelle)){ echo html_entity_decode($Auxilieres->libelle); }?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Activité  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "raison" class="form-control" placeholder="Raison " value ="<?php if (!empty($Auxilieres->activite)){ echo html_entity_decode($Auxilieres->activite ); }?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-ban"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Rc *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "rc" class="form-control" placeholder="RC " value ="<?php if (!empty($Auxilieres->rc)){ echo html_entity_decode($Auxilieres->rc); }?>" required>
															<span class="input-group-addon ">
															<i class="">RC</i>
															</span>
															
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Mf *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "mf" class="form-control" placeholder="Mf " value ="<?php if (!empty($Auxilieres->mf)){ echo html_entity_decode($Auxilieres->mf); }?>" required>
															<span class="input-group-addon ">
															<i class="">Mf</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Ai *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "ai" class="form-control" placeholder="Ai " value ="<?php if (!empty($Auxilieres->ai)){ echo html_entity_decode($Auxilieres->ai); }?>" required>
															<span class="input-group-addon ">
															<i class="">Ai</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Nis </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "nis" class="form-control" placeholder="Nis " value ="<?php if (!empty($Auxilieres->nis)){ echo html_entity_decode($Auxilieres->nis); }?>" >
															<span class="input-group-addon ">
															<i class="">Nis</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Adresse </label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "adresse" class="form-control" placeholder="Adresse " value ="<?php if (!empty($Auxilieres->adresse)){ echo html_entity_decode($Auxilieres->adresse); }?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-map-marker"></i>
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
			<!-- END PAGE CONTENT-->
		<?php }	} ?> 
			
	
	</div>
	</div>
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
<script type="text/javascript">
    function EnableDisableTextBox() {
        var optionsRadios25 = document.getElementById("optionsRadios25");
        var prefixe = document.getElementById("prefixe");
        prefixe.disabled = optionsRadios25.checked ? false : true;
        if (!prefixe.disabled) {
            prefixe.focus();
        }
    }
</script>

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>