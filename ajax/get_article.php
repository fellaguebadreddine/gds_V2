<?php
require_once("../includes/initialiser.php");
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
	$Produit = Produit::trouve_par_id($id);
	 
	 }
if (isset($_GET['action'])) {
 $action =  htmlspecialchars($_GET['action']) ;
}
?>

                    <?php if ($action == 'vente') { ?>
						                  <div class="form-group"  >
                                                <label class="col-md-4 control-label">Quantité Disponible </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                      
                                                        <input type="text" class="form-control vente-input" value="<?php if(isset($Produit->stock)){echo $Produit->stock; } ?>" name="qte_dispo" disabled    />
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
                                                      
                                                        <input type="text" class="form-control vente-input" name="tva"  value="<?php if(isset($Produit->tva)){echo $Produit->tva; } ?>"   disabled     />
                                                        <span class="input-group-addon">
                                                        	<i class="fa    fa-dollar"></i>
                                                        </span>
                                                    </div>                                            
                                                   
                                                </div>
                                            </div>
                                            
                                          
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Prix vente </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="prix" value="<?php if(isset($Produit->prix_vente)){echo $Produit->prix_vente; } ?>" class="form-control inputs vente-input" name="prix" required />
														<span class="input-group-addon">
                                                        	<i class="fa   fa-dollar"></i>
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 

                                <?php }else if($action == 'achat') { ?>
                                     <div class="form-group"  >
                                                <label class="col-md-4 control-label">Quantité Disponible </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                      
                                                        <input type="text" class="form-control achat-input" value="<?php if(isset($Produit->stock)){echo $Produit->stock; } ?>" name="qte_dispo" disabled    />
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
                                                      
                                                        <input type="text" class="form-control achat-input" name="tva"  value="<?php if(isset($Produit->tva)){echo $Produit->tva; } ?>"   disabled     />
                                                        <span class="input-group-addon">
                                                            <i class="fa    fa-dollar"></i>
                                                        </span>
                                                    </div>                                            
                                                   
                                                </div>
                                            </div>
                                            
                                          
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Prix achat </label>
                                                <div class="col-md-8">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="prix" value="<?php if(isset($Produit->prix_achat)){echo $Produit->prix_achat; } ?>" class="form-control inputs achat-input" name="prix" required />
                                                        <span class="input-group-addon">
                                                            <i class="fa   fa-dollar"></i>
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 
                                    <?php } ?>