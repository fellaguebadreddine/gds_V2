<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $id_user =  htmlspecialchars(intval($_GET['id_user'])) ;
 $id_fact =  htmlspecialchars(intval($_GET['id_fact'])) ;
 $caisses = Caisse::trouve_caisse_par_societe($id_societe);
 $banques = Banque::trouve_par_societe($id_societe);  
	 if($id == 2){
        if (isset($_GET['vente'])) {
        if (isset($_GET['id_fact'])) {
         $Somme_ttc = Update_vente::somme_ttc_par_facture($id_fact);
        }else{
           $Somme_ttc = Vente::somme_ttc($id_user,$id_societe); 
        }
        }else if (isset($_GET['achat'])) {
                 if (isset($_GET['id_fact'])) {
         $Somme_ttc = Update_achat::somme_ttc_par_facture($id_fact);
        }else{
           $Somme_ttc = Achat::somme_ttc($id_user,$id_societe); 
        }
        }
        
	 		
	 		$timbre = $Somme_ttc->somme_ttc /100;
	 		$timbre = ceil($timbre);
	 		if ($timbre < 5 ) {
	 			$timbre =5;	}
	 			elseif( $timbre >= 2500 ){
	 				$timbre = 2500;
	 			}

                $total_ttc = $Somme_ttc->somme_ttc + $timbre;
	 	?>
        <?php if (isset($_GET['vente'])) { ?>
															<div class="form-group form-md-line-input   ">
                                                    <label class="col-md-3 control-label">Caisse</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="caisse" id="caisse"  placeholder="Choisir" >
													
															<?php  foreach ($caisses as $caisse){ ?>
																<option <?php if (isset($caisse->Designation)) {
																		echo "selected";}
																	 ?> value="<?php if (isset($caisse->Designation)) {
																	echo $caisse->Designation;}?>"><?php if (isset($caisse->Designation)) {
																	echo $caisse->Designation;} ?> </option>
												<?php } ?>
																	   
														</select> 
                                                    </div>
                                                </div>
                                                <?php  }  ?>
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-3 control-label">Timbre   </label>
                                                <div class="col-md-9 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="Montant" class="form-control " disabled name="Montant"value="<?php if(isset($timbre)) {echo str_replace(',', ' ',number_format($timbre,2)) ; } ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-3 control-label">Total TTC   </label>
                                                <div class="col-md-9 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="Montant" class="form-control " disabled value="<?php if(isset($total_ttc)) {echo str_replace(',', ' ',number_format($total_ttc,2)) ; } ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 
												<?php }  } ?> 
  