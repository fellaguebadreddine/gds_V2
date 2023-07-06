<?php
require_once("../includes/initialiser.php");
if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 //$entrp = Societe::trouve_par_id($id);
}else{
        echo 'Content not found....';
}
if (isset($_GET['id_fact'])) {
$id_fact =  htmlspecialchars(intval($_GET['id_fact'])) ;
      $Fact = Facture_achat::trouve_par_id($id_fact);
      $date = date_parse($Fact->date_fac);
}
$thisday=date('Y-m-d');
?>                                     

                                        <?php  if ($id == 7) { ?>
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant   </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="Montant" class="form-control " name="Montant"value="0.00"   required />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de règlement   </label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date_paiement" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>"  required>
                                                    </div>                                            
                                                  
                                                </div>
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Facture   </label>
                                                <div class="col-md-8">                                            
                                                        <input type="text" id="Montant" class="form-control " name="Montant"value="<?php if (isset($Fact->id_facture)) { echo 'FAC/'.sprintf("%04d", $Fact->id_facture).'/'.$date['year']; } ?>"   disabled />
                                                </div>
                                            </div> 
                                            <?php } else {?>
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant   </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="Montant" class="form-control " name="Montant"value="<?php if(isset($Fact->somme_ttc)) {echo $Fact->somme_ttc; } ?>"   required />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div> 
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de règlement   </label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date_paiement" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>"  required>
                                                    </div>                                            
                                                  
                                                </div>
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Facture   </label>
                                                <div class="col-md-8">                                            
                                                        <input type="text" id="Montant" class="form-control " name="Montant"value="<?php if (isset($Fact->id_facture)) { echo 'FAC/'.sprintf("%04d", $Fact->id_facture).'/'.$date['year']; } ?>"   disabled />
                                                </div>
                                            </div> 
                                                <?php } ?>