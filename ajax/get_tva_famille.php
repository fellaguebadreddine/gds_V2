<?php 
require_once("../includes/initialiser.php");
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Famille = Famille::trouve_par_id($id);
	 if(!empty($_SESSION['societe'])){
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);} 
	 }


	  ?>


<label class="col-md-2 control-label">TVA <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<select class="form-control " data-live-search="true" id="form_control_1"  name="tva" required>
												
															
														<?php $tvass = Tva::trouve_tva_par_societe($nav_societe->id_societe);
															foreach($tvass as $tva){?>

														<option <?php if ($Famille->id_tva == $tva->id_tva) { echo 'selected';} ?>  value = "<?php echo $tva->id_tva ?>" > <?php echo $tva->Designation ?> % </option>
														<?php } ?>																   
														</select> 
															<span class="input-group-addon " required >
															tva
															</span>
														</div>
														
													</div>