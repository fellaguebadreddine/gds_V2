<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $caisses = Caisse::trouve_par_societe($id_societe);
 $Comptes = Compte::trouve_par_societe($id_societe);  
 $Mode_paiement_societe = Mode_paiement_societe::trouve_par_id($id);
	 if($Mode_paiement_societe->mode_paiement == 2){?>
		
                                                    <label class="col-md-3 control-label">Caisse</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="caisse" id="caisse"  placeholder="Choisir" >
													
															<?php  foreach ($caisses as $caisse){ ?>
																<option <?php if (isset($caisse->Designation)) {
																	
																echo "selected";}
																	 ?> value="<?php if (isset($caisse->id_caisse)) {
																	echo $caisse->id_caisse;}?>"><?php if (isset($caisse->Designation)) {
																	echo $caisse->Designation;} ?> </option>
												
	 <?php }?>   
														</select> 
														
                                                    </div>
  
							<?php }else if($Mode_paiement_societe->mode_paiement == 1) { ?>	
												
                                                    <label class="col-md-3 control-label">Banque</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="banque" id="banque"  placeholder="Choisir" >
													
															<?php  foreach ($Comptes as $Compte){
															$banque = Banque::trouve_par_id($Compte->id_banque);
															 ?>
																<option value="<?php if (isset($Compte->id)) {
																	echo $Compte->id;}?>"><?php if (isset($banque->Designation)) {
																	echo $banque->Designation;} ?> </option>
												 <?php }?>
																	   
														</select> 
                                                    </div>                                              
												<?php }else { ?>	
												
                                                   
                                                
																	   

<?php } }?> 
  