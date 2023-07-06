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

<!-- BEGIN PAGE CONTENT-->
	<div class="row">
				<div class="col-md-12">
					 
					  <div class="page-title">
					<h1>Société</h1>
				</div>
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				//$societes = Societe::trouve_tous(); 
				//$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Liste des Sociétés 
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											
											<a href="add-societes.php" class="btn red">Créer Société <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									<div class="col-md-6">
										<div class="btn-group pull-right">
											<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="javascript:;">
													Print </a>
												</li>
												<li>
													<a href="javascript:;">
													Save as PDF </a>
												</li>
												<li>
													<a href="javascript:;">
													Export to Excel </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_4">
							<thead>
							<tr>
								<th>
									 N°
								</th>
								<th>
									Société
								</th>
								
								
								<th>
									Etat 
								</th>
								<th>
									#
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
									<?php if (isset($entrp->id_societe)) {
									echo $cpt;
									} ?>
								</td>
								
								<td>
									<?php if (isset($entrp->Raison)) {
									echo $entrp->Raison;
									} ?>
								</td>
								
								<td>
									4 
								</td>
								<td>
									
									<a href="#" class="btn blue btn-sm">
                                                    <i class="fa fa-pencil"></i> </a>
									
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
<!-- END PAGE CONTENT-->

        <script type="text/javascript">
            $(document).ready(function(){
				// Reinitialize
				$("#sample_4").dataTable();
				$.getScript('/javascript/myscript.js');
				TableAdvanced.init();
            });
            </script>
			