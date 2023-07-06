<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $compte_consommation = Compte_comptable::trouve_par_id($id);

 
		?>
													
													<label class="col-md-2 control-label">Auxiliaire :  </label>
													<div class="col-md-3">
													
														<div class="input-group">
														<select class="form-control " <?php if($compte_consommation->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_consommation"  name="auxiliere_consommation">
														
														<?php 
														if(!empty($compte_consommation->prefixe))	{
														$Auxlere = Auxiliere::trouve_auxiliere_par_lettre_aux($compte_consommation->prefixe,$id_societe);
														foreach($Auxlere as $Auxs){?>
														
														<option  value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle?></option>
														
															<?php } 	}	else {?>
																
																<option>  </option>
														<?php	}?>											
														
																												   
														</select>
														<span class="input-group-addon ">
															Aux
															</span>	
														</div>

													</div>
													
												<?php } ?>	
  