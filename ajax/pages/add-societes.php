
<?php 
	if(isset($_POST['submit'])){
	$errors = array();
		// new object societes
	
	
	
	$societes = new Societe();
	
	$societes->Raison = htmlentities(trim($_POST['Raison']));
	$societes->Adresse = htmlentities(trim($_POST['Adresse']));
	$societes->Ville = htmlentities(trim($_POST['Ville']));
	$societes->Postal = htmlentities(trim($_POST['Postal']));
	$societes->Rc = htmlentities(trim($_POST['Rc']));
	$societes->Mf = htmlentities(trim($_POST['Mf']));
	$societes->Ai = htmlentities(trim($_POST['Ai']));
	$societes->Nis = htmlentities(trim($_POST['Nis']));
	$societes->Tel1 = htmlentities(trim($_POST['Tel1']));
	$societes->Tel2 = htmlentities(trim($_POST['Tel2']));
	$societes->Fax = htmlentities(trim($_POST['Fax']));
	$societes->Mob1 = htmlentities(trim($_POST['Mob1']));
	$societes->Mob2 = htmlentities(trim($_POST['Mob2']));
	$societes->Email = htmlentities(trim($_POST['Email']));
	$societes->Web = htmlentities(trim($_POST['Web']));
	$societes->Activite = htmlentities(trim($_POST['Activite']));
	$societes->Capital = htmlentities(trim($_POST['Capital']));
	$societes->Agence = htmlentities(trim($_POST['Agence']));
	$societes->Année = htmlentities(trim($_POST['Année']));
	$societes->Logo = htmlentities(trim($_POST['Logo']));

		

	if (empty($errors)){
if ($societes->existe()) {
			$msg_error = '<p >  Societe   : ' . $societes->Rc . ' existe déja !!!</p><br />';
			
		}else{
			$societes->save();
 		$msg_positif = '<p ">       Votre inscription a bien été prise en compte  </p><br />';
		
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
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN STYLE CUSTOMIZER -->
			<div class="theme-panel hidden-xs hidden-sm">


			
			</div>
			<!-- END STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="#">Gestion des Sociétés</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="add_societes.php">Ajouter Société</a>
					</li>
				</ul>
				
			</div>

				<?php if ($user->type == 'administrateur') {    ?>
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

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					
							
						</div>
					</div>
					
				

<div class="row">
				<div class="col-md-12">
					<!-- BEGIN VALIDATION STATES-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Ajouter Société
							</div>
							
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
							<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" id="form_sample_3" class="form-horizontal">
								<div class="form-body">
									
									<div class="alert alert-danger display-hide">
										<button class="close" data-close="alert"></button>
										Vous avez des erreurs de formulaire. S'il vous plaît vérifier ci-dessous.
									</div>
									<div class="alert alert-success display-hide">
										<button class="close" data-close="alert"></button>
										Votre validation de formulaire est réussie!
									</div>
									<div class="form-group">
													<label class="col-md-3 control-label">Raison<span class="required">
										* </span></label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Raison" class="form-control " placeholder="Raison">
															<span class="input-group-addon ">
															<i class="fa fa-user"></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Adresse<span class="required">
										* </span>
													</label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Adresse" class="form-control " placeholder="Adresse">
															<span class="input-group-addon ">
															<i class="fa fa-user"></i>
															</span>
														</div>

													</div>
												</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Ville<span class="required">
										* </span>
										</label>
										<div class="col-md-6">
											<div class="input-group">
												
											<input type="email" name="Ville" class="form-control " placeholder="Ville">
											<span class="input-group-addon ">
												<i class="fa fa-envelope"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
													<label class="col-md-3 control-label">Postal<span class="required">
										* </span></label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="number" name = "Postal" class="form-control " placeholder="Postal">
															<span class="input-group-addon ">
															<i class="icon-call-end"></i>
															</span>
														</div>

													</div>
												</div>		
									<div class="form-group">
										<label class="control-label col-md-3">Rc</label>
										<div class="col-md-6">
										<div class="input-group">
											<input name="Rc" type="text" class="form-control "/>
										
											<span class="input-group-addon ">
												<i class="icon-pointer"></i>
												</span>
										</div>
										</div>
									</div>

							
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit"   name="submit" class="btn green">Ajouter</button>
											<a href="dashboard.php" class="btn default">Annuler </a>
											
										</div>
									</div>
								</div>
							</form>
							<!-- END FORM-->
						</div>
						<!-- END VALIDATION STATES-->
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->

			<?php } ?>
			<!-- END DASHBOARD STATS -->
			<div class="clearfix">
			</div>


		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
