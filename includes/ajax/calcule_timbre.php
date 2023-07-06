<?php
require_once("../includes/initialiser.php");
 $action = '';
if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $id_user =  htmlspecialchars(intval($_GET['id_user'])) ;
 $id_fournisseur =  htmlspecialchars(intval($_GET['id_fournisseur'])) ;
 if (isset($_GET['id_facture'])) {
 $id_facture =  htmlspecialchars(intval($_GET['id_facture'])) ;
 }
 $TOTALTTC =  htmlspecialchars(floatval($_GET['TOTALTTC'])) ;
$Mode_paiement = Mode_paiement_societe::trouve_par_id($id);


        if (isset($_GET['vente'])) {
        $action = 'vente';
        if (isset($_GET['id_facture'])) {
        $somme_Reglement = Update_reglement_client::trouve_somme_Reglement_vide_par_admin($id_facture);
        $table_Reglements = Update_reglement_client::trouve_Reglement_vide_par_admin($id_facture);
        $last_Reglement =Update_reglement_client::trouve_last_Reglement_vide_par_admin($id_facture);
        }else{
        $somme_Reglement = Reglement_client::trouve_somme_Reglement_vide_par_admin($id_user,$id_societe);
        $table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin($id_user,$id_societe);
        $last_Reglement =Reglement_client::trouve_last_Reglement_vide_par_admin($id_user,$id_societe);
        ///////////////// calcul rest     ///////////////////////////////////
        }
        $Reste_fact =$TOTALTTC - $somme_Reglement->somme ; 
        }  else if (isset($_GET['avoir_vente'])) {
        $action = 'avoir_vente';
        if (isset($_GET['id_facture'])) {
        $somme_Reglement = Update_reglement_client::trouve_somme_Reglement_vide_par_admin_avoir($id_facture);
        $table_Reglements = Update_reglement_client::trouve_Reglement_vide_par_admin_avoir($id_facture);
        $last_Reglement =Update_reglement_client::trouve_last_Reglement_vide_par_admin_avoir($id_facture);
        }else{
        $somme_Reglement = Reglement_client::trouve_somme_Reglement_vide_par_admin_avoir($id_user,$id_societe);
        $table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin_avoir($id_user,$id_societe);
        $last_Reglement =Reglement_client::trouve_last_Reglement_vide_par_admin_avoir($id_user,$id_societe);
        ///////////////// calcul rest     ///////////////////////////////////
        }
        $Reste_fact =$TOTALTTC - $somme_Reglement->somme ; 
        }else if (isset($_GET['achat'])) {
        $action = 'achat';

                 if (isset($_GET['id_facture'])) {
        $somme_Reglement = Update_reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($id_facture,1);
        $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($id_facture,1);
        $last_Reglement =Update_reglement_fournisseur::trouve_last_Reglement_vide_par_admin($id_facture,1);
        }else{
        $somme_Reglement = Reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($id_user,$id_societe,1);
        $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($id_user,$id_societe,1);
        $last_Reglement =Reglement_fournisseur::trouve_last_Reglement_vide_par_admin($id_user,$id_societe,1);
        }
                ////////////////// calcul rest ///////////////////////
        $Reste_fact =$TOTALTTC - $somme_Reglement->somme ; 
        }else if (isset($_GET['avoir_achat'])) {
        $action = 'avoir_achat';

                 if (isset($_GET['id_facture'])) {
        $somme_Reglement = Update_reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($id_facture,3);
        $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($id_facture,3);
        $last_Reglement =Update_reglement_fournisseur::trouve_last_Reglement_vide_par_admin($id_facture,3);
        }else{
        $somme_Reglement = Reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($id_user,$id_societe,3);
        $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($id_user,$id_societe,3);
        $last_Reglement =Reglement_fournisseur::trouve_last_Reglement_vide_par_admin($id_user,$id_societe,3);
        }
                ////////////////// calcul rest ///////////////////////
        $Reste_fact =$TOTALTTC - $somme_Reglement->somme ; 
        }
        else if (isset($_GET['depence'])) {
        $action = 'depence';

                 if (isset($_GET['id_facture'])) {
        $somme_Reglement = Update_reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($id_facture,2);
        $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($id_facture,2);
        $last_Reglement =Update_reglement_fournisseur::trouve_last_Reglement_vide_par_admin($id_facture,2);
        }else{
        $somme_Reglement = Reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($id_user,$id_societe,2);
        $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($id_user,$id_societe,2);
        $last_Reglement =Reglement_fournisseur::trouve_last_Reglement_vide_par_admin($id_user,$id_societe,2);
        }
                ////////////////// calcul rest ///////////////////////
        $Reste_fact =$TOTALTTC - $somme_Reglement->somme ; 
        }


    if (isset($last_Reglement->mode_paiment)) {
    $last_Mode_paiement = Mode_paiement_societe::trouve_par_id($last_Reglement->mode_paiment);
    }

                if($Mode_paiement->mode_paiement == 2){
                    if ($Reste_fact == 0) {
                        $timbre =0 ;
                    } else{
                        if ( $action == 'depence') {
                            $timbre =0 ;
                        }else{
            $timbre = $Reste_fact /100;
            $timbre = round($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 10000 ){
                    $timbre = 10000;
                }           
                        }

   
                    }

             
              //  $Reste_fact += $timbre;
	 	?>
       
											<div class="col-md-5">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="TTC" value="<?php  if(isset($TOTALTTC)){echo number_format($TOTALTTC,2,".","");} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Timbre <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" <?php if ($action == 'achat') {echo 'id="timbre_achat" name="timbre_achat"'; } else { echo 'id="timbre_vente" name="timbre_vente"'; } ?>   readonly class="form-control "  value="<?php  if(isset($timbre)){echo  number_format($timbre,2,".","");} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                      
                                                        <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  number_format($Reste_fact,2,".",""); ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                                
                                                 
												<?php }else { 
                                                 
                                                   ?>
                                                     <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="TTC" value="<?php  if(isset($TOTALTTC)){echo  number_format($TOTALTTC,2,".","");} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                        
                                                         <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  number_format($Reste_fact,2,".",""); ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                                <?php }} ?>
                                                




<script>
<?php  if ( $Mode_paiement->mode_paiement != 3) { 
     if ($Reste_fact == 0) { ?>
  $(document).ready(function(){
            $("#save_paiement").attr("disabled", false);
            });
<?php }else { ?>
   $(document).ready(function(){
            $("#save_paiement").attr("disabled", true);
            });   
<?php }}else { 
if (!empty($table_Reglements)) { ?>
     $(document).ready(function(){
            $("#save_paiement").attr("disabled", false);
            });  

<?php }} ?>
<?php     if ($last_Mode_paiement->mode_paiement == 3) {?>
       $(document).ready(function(){
            $("#save_paiement").attr("disabled", false);
            });   
<?php } ?>
 $(document).ready(function(){
        $('.select2me').select2('destroy');
        $('.select2me').select2();
       
            }); 

</script>
