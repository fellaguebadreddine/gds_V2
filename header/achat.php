<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Accounts::trouve_par_id($session->id_utilisateur);
	if (empty($user)) {
	$user = Fournisseur::trouve_par_id($session->id_utilisateur);
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
$titre = "ThreeSoft | Achat ";
$active_menu = "Facturation";
$header = array('table','invoice');
if ($user->type == "administrateur"){
if (isset($_GET['action']) && $_GET['action'] =='list_achat' ) {
$active_submenu = "list_achat";
$action = 'list_achat';}
else if (isset($_GET['action']) && $_GET['action'] =='achat' ) {
$active_submenu = "list_achat";
$action = 'achat';}
// End of the main Submit conditional.
}
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
?>

<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			
			<!-- BEGIN PAGE CONTENT-->
			
			<!-- BEGIN PAGE HEADER-->
			
			<div class="page-bar">
				<ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-table"></i>
                        <a href="#">Facturation</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'achat') { ?>
                        <a href="#">Achat</a>  
                         <?php }?>
                        
                    </li>
				</ul>
			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
							if ($action == 'list_achat') {
				
				?>
				<div class="row">
				<div class="col-md-12">
					 
					  <div class="page-title">
					<h1>Achats</h1>
				</div>
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$factures = Facture_achat::trouve_facture_non_valide_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12 ">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption font-red-thunderbird bold">
								<i class="fa  fa-list font-red-thunderbird"></i>Liste des achats non valider 
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											
											<a href="achat.php?action=achat" class="btn yellow-crusta ">Créer  <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									<div class="col-md-6">
										<div class="btn-group pull-right">
											<button class="btn default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
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
							<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_2">
							<thead>
							<tr>
								<th  class="table-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label=" " style="width: 24px;">
									 
								</th>
								<th>
									N° de facture
								</th>
								<th>
									date facture
								</th>
								<th>
									fournisseur
								</th>
								<th>
									Total TTC
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
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr>
								<td>
									<span><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"></span>
								</td>
								
								<td>
									<b>
									
									<?php if (isset($facture->id_facture)) {
										$date = date_parse($facture->date_fac);
									

									echo sprintf("%04d", $facture->id_facture).'/'.$date['year']; } ?></b>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								<td>
									<?php if (isset($facture->id_fournisseur)) {
															$fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($fournisseurs as $fournisseur){
																
																	if (isset($fournisseur->nom)) {
															echo $fournisseur->nom;}}?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
									echo $facture->somme_ttc;
									} ?>
								</td>
								<td>
								<?php if ($facture->etat == '0') { ?>
									<span class="label label-sm label-danger">
									Non valide</span>
                                     
                                  <?php } else{  ?> 
                                     <span class="label label-sm bg-green-jungle">
									valide </span>
                                <?php    } ?> 
								</td>
								<td>
									
									<a href="achat.php?action=edit&id=<?php echo $facture->id_facture; ?>" class="btn blue btn-sm">
                                                    <i class="fa fa-edit "></i> </a>
									<a href="invoce_achat.php?id=<?php echo $facture->id_facture; ?>" class="btn btn-default btn-sm">
                                                    <i class="fa fa-file-o"></i> </a>
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
			<div class="row">
				<div class="col-md-12">
					 
					
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$factures = Facture_achat::trouve_facture_valide_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption font-blue bold">
								<i class="fa  fa-list font-blue"></i>Liste des achats valider  
							</div>
						</div>

							
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_4">
							<thead>
							<tr>
								<th  class="table-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label=" " style="width: 24px;">
									 
								</th>
								<th>
									N° de facture
								</th>
								<th>
									date facture
								</th>
								<th>
									fournisseur
								</th>
								<th>
									Total TTC
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
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr>
								<td>
									<span><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"></span>
								</td>
								
								<td>
									<b><?php if (isset($facture->id_facture)) {
									echo $facture->id_facture;
									} ?></b>
								</td>
								<td>
									<b><?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?></b>
								</td>
								<td>
									<?php if (isset($facture->id_fournisseur)) {
															$fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($fournisseurs as $fournisseur){
																
																	if (isset($fournisseur->nom)) {
															echo $fournisseur->nom;}}?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
									echo $facture->somme_ttc;
									} ?>
								</td>
								<td>
								<?php if ($facture->etat == '1') { ?>
                                    <span class="label label-sm bg-green-jungle">
									valide </span> 
                                  <?php } else{  ?> 
                                    <span class="label label-sm label-danger">
									Non valide</span> 
                                <?php    } ?> 
								</td>
								
								<td>
									
									<a href="achat.php?action=edit&id=<?php echo $facture->id_facture; ?>" class="btn blue btn-sm">
                                                    <i class="fa fa-edit "></i> </a>
									<a href="invoce_achat.php?id=<?php echo $facture->id_facture; ?>" class="btn btn-default btn-sm">
                                                    <i class="fa fa-file-o"></i> </a>
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
				<?php }elseif ($action == 'achat') {
				$Articles = Produit::trouve_produit_par_societe($nav_societe->id_societe);
				$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 	
				$tvas = TVA::trouve_tous(); 
				$Somme_ht = Achat::somme_ht($user->id,$nav_societe->id_societe);
				$Somme_tva = Achat::somme_tva($user->id,$nav_societe->id_societe);
				$Somme_ttc = Achat::somme_ttc($user->id,$nav_societe->id_societe);
				$table_achats = Achat::trouve_achat_vide_par_admin($user->id,$nav_societe->id_societe);
				if (!empty($table_achats)) {
					$last_fournisseur = Achat::trouve_last_fournisseur_par_id_admin($user->id,$nav_societe->id_societe);
					
					}	
			$thisday=date('Y-m-d');
				  ?>
		<div class="show-facture">
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
							<div class="caption font-blue bold">
								achat
							</div>
						</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
						<form  id="formachat" method="POST"  class="form-horizontal" enctype="multipart/form-data" >
										   <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                    	<div class="col-md-8">
                                    		
                                            <div class="form-group form-md-line-input">
													<label class="col-md-2 control-label">Date facturation </label>
													<div class="col-md-10">
														
															<input type="date" name = "date_fact" class="form-control" placeholder="Date " value="<?php if (isset($last_fournisseur->date_fact)) {echo $last_fournisseur->date_fact;  }else { echo   $thisday;}?>"  required>
															
														</div>
														
													</div>
												</div>
                                    	</div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                        	<div class="form-group ">
                                                <label class="col-md-3 control-label "> fournisseur </label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control select2me"    name="id_fournisseur" id="id_fournisseur"  placeholder="Choisir fournisseur" >
													
															<option value=""></option>
														<?php  foreach ($fournisseurs as $fournisseur) { ?>
																<option <?php if (isset($last_fournisseur->id_fournisseur)) {
																		if ($last_fournisseur->id_fournisseur == $fournisseur->id_fournisseur) {echo "selected";}
																	} ?> value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>"><?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?> </option>
																<?php } ?>	
																	   
														</select>   
														<div class="form-control-focus">
														</div>
                                                 
													
                                                </div>
												  
                                            </div> 
                                            
                                         	<div class="form-group ">
                                                <label class="col-md-3 control-label"> Article </label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control  select2me" onchange="focusArticle();"   id="id_article"  name="id_prod"  onchange="showvente(this.value)"  placeholder="Choisir article" >
															<option value=""></option>
														<?php  foreach ($Articles as $Article) { ?>
																	<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;} ?> </option>
																<?php } ?>														   
														</select>   
                                                 <div class="form-control-focus">
														</div>
													
                                                </div>
												  
                                            </div> 
											 <div class="form-group form-md-line-input"  >
                                                <label class="col-md-3 control-label">Quantite </label>
                                                <div class="col-md-7">                                            
                                                    <div class="input-group">
                                                      
                                                        <input type="number" id="qte" class="form-control inputs achat-input" name="qte"   required/>
                                                        <span class="input-group-addon">
                                                        	<i class="">.00</i>
                                                        </span>
                                                    </div>  
														<div class="form-control-focus">
														</div>													
                                                   
                                                </div>
                                            </div> 
                                         
                                          
                                            
                                        </div>

                                        <div class="col-md-6 info-prod" >

                                             <div class="form-group"  >
                                                <label class="col-md-4 control-label">Quantite Disponible </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                      
                                                        <input type="text" class="form-control achat-input" name="qte_dispo" disabled    />
                                                        <span class="input-group-addon">
                                                        	<i class="fa    fa-box"></i>
                                                        </span>
                                                    </div>                                            
                                                   
                                                </div>
                                            </div>
											<div class="form-group"  >
                                                <label class="col-md-4 control-label">TVA % </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                      
                                                        <input type="text" class="form-control achat-input" name="tva"   disabled    />
                                                        <span class="input-group-addon">
                                                        	<i class="fa    fa-dollar"></i>
                                                        </span>
                                                    </div>                                            
                                                   
                                                </div>
                                            </div>
                                            
                                          
                                             <div class="form-group">
                                                <label class="col-md-4 control-label">Prix   </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="prix" class="form-control inputs achat-input" name="prix" required />
														<span class="input-group-addon">
                                                        	<i class="fa   fa-dollar"></i>
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 
                                        </div>
										
                                    </div>

                                </div>
                                <input type="hidden" name="id_person" value="<?php echo $user->id ?>">
                                <input type="hidden" name="id_societe" value="<?php echo $nav_societe->id_societe ?>">
                                </form>
                                 <div class="panel-footer">
                                    <button class="btn btn-default"type = "reset">Vider les champs</button>
                                                                     
                                    <button class="btn btn-primary pull-right" class="btn green" id="submit">Ajouter</button>
                                </div>
												
												
											</div>
											
										
										<!-- END FORM-->
									</div>
								</div>
						</div>

			<div class="row">
		
				<div class="col-md-12">
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Listes
							</div>
						</div>
						<div class="portlet-body notification">
						<table class="table table-striped table-bordered table-hover" >
							<thead>
							<tr>
								<th>
									Code
								</th>
								<th>
									Designation
								</th>
								<th>
									 Quantite 
								</th>
								<th>
									  Prix U 
								</th>
								<th>
									HT
								</th>
								<th>
									TAUX  TVA 
								</th>
								<th>
									 TVA
								</th>
								<th>
									TOTAL  
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_achats as $table_achat){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($table_achat->Code)) {
										echo $table_achat->Code;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Designation)) {
										echo $table_achat->Designation;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Quantite)) {
										echo $table_achat->Quantite;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo $table_achat->Prix;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Ht)) {
										echo $table_achat->Ht;
									} ?>
									
								</td>
								<td>
									<?php if (isset($table_achat->Ttva)) {
										echo ($table_achat->Ttva *100).' %';
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Tva)) {
										echo $table_achat->Tva;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->total)) {
										echo $table_achat->total;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_achat->id)){ echo $table_achat->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="7"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="7"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="7"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> DA</span></td>
							    </tr>

										
                            </tbody>
							</table>
							
						</div>
							<div class="panel-footer " align="right">   
								<button class="btn btn-lg blue" id="valider"  disabled  type = "submit" name = "valider" >Valider </button>
						    </div>	

						</div>
					
				</div>
					
			</div>
		</div>

					
			
			<?php }}?>
		
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
	

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>