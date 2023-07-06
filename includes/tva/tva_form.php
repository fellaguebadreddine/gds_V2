		<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-4">
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
											<i class="fa fa-align-justify "></i>Ajouter TVA
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=ajouter_tva" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												
												<div class="form-group">
													<label class="col-md-3 control-label">TVA <span class="required" aria-required="true"> * </label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "Designation" class="form-control" placeholder="TVA" required>
															<span class="input-group-addon ">
															<i class="">%</i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Taux de tva<span class="required" aria-required="true"> * </label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="text" name = "taux" class="form-control" placeholder="taux de tva" required>
															
															<span class="help-block">Exemple : 19</span>
															
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