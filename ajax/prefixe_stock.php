<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $compte_stock = Compte_comptable::trouve_par_id($id);

 
		?>
													
													<label class="col-md-2 control-label">Auxiliaire :  </label>
													<div class="col-md-3">
													
														<div class="input-group">
														<select class="form-control " <?php if($compte_stock->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_stock"  name="auxiliere_stock">
														
														<?php 
														if(!empty($compte_stock->prefixe))	{
														$Auxle = Auxiliere::trouve_auxiliere_par_lettre_aux($compte_stock->prefixe,$id_societe);
														foreach($Auxle as $Auxs){?>
														
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
  