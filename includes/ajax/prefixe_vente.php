<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $compte_vente = Compte_comptable::trouve_par_id($id);

 
		?>
													
													<label class="col-md-3 control-label">Auxiliaire :  </label>
													<div class="col-md-2">
													
														<div class="input-group">
														<select class="form-control " <?php if($compte_vente->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_vente"  name="auxiliere_vente">
														
														<?php 
														if(!empty($compte_vente->prefixe))	{
														$Auxle = Auxiliere::trouve_auxiliere_par_lettre_aux($compte_vente->prefixe,$id_societe);
														foreach($Auxle as $Auxs){?>
														
														<option  value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
															<?php } 	}	else {?>
																
																<option>  </option>
														<?php	}?>											
														
																												   
														</select>
														

													</div>
													
												<?php } ?>	
 

  