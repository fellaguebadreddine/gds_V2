<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 $TOTALTTC =  htmlspecialchars(floatval($_GET['TOTALTTC'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
  $id_user =  htmlspecialchars(intval($_GET['id_user'])) ;
if (isset($_GET['id_fournisseur'])) {
 $id_fournisseur =  htmlspecialchars(intval($_GET['id_fournisseur'])) ;
}
if (isset($_GET['id_client'])) {
 $id_client =  htmlspecialchars(intval($_GET['id_client'])) ;
}
if (isset($_GET['id_facture'])) {
 $id_facture =  htmlspecialchars(intval($_GET['id_facture'])) ;
}

$Mode_paiement = Mode_paiement_societe::trouve_par_id($id);
$Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($id_societe); 


        if (isset($_GET['vente'])) {
 if (isset($_GET['id_facture'])) {
$Mode_and_ties = Solde_client::trouve_par_all_mode_and_client($id_societe,$id_client,$id);
                } else{
$Mode_and_ties = Solde_client::trouve_par_mode_and_client($id_societe,$id_client,$id);                        
                }

        }else if (isset($_GET['achat'])) {
                if (isset($_GET['id_facture'])) {
$Mode_and_ties = Solde_fournisseur::trouve_par_all_mode_and_fournisseur($id_societe,$id_fournisseur,$id);
                } else{
$Mode_and_ties = Solde_fournisseur::trouve_par_mode_and_fournisseur($id_societe,$id_fournisseur,$id);                        
                }



        }else if (isset($_GET['avoir_vente'])) {
$Mode_and_ties = Solde_client::trouve_par_mode_and_client_negatif($id_societe,$id_client,$id);   

        }else if (isset($_GET['avoir_achat'])) {
$Mode_and_ties = Solde_fournisseur::trouve_par_mode_and_fournisseur_negatif($id_societe,$id_fournisseur,$id);   

        }
  ?>
                                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php  foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option <?php if (isset($Mode_paiement_societe->id) && $Mode_paiement_societe->id == $id) { echo 'selected'; } ?> value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>
                                                                </select>      
                                                </td>
                                            <td><select <?php if($Mode_paiement->mode_paiement == 3){ echo 'disabled'; } ?> placeholder="Liste mode paiement"   name="list_paiment_facture" id="list_paiment_facture"  class=" form-control select2me">
                                                       <option value=""></option>
                                                       <?php foreach ($Mode_and_ties as $Mode_and_tie) {?>
                                                        <option  value="<?php if(isset($Mode_and_tie->id)) {echo $Mode_and_tie->id;}?>"><?php if (isset($Mode_and_tie->reference)) {echo fr_date2($Mode_and_tie->date).' | '.$Mode_and_tie->reference;} ?></option>
                                                        <?php } ?>
                                                                </select>
                                            </td>

                                            <td class="get-solde"><input disabled type="number" name="solde" id="solde" min="0" class="form-control" ></td>
                                            <td>
                                                <input <?php if($Mode_paiement->mode_paiement == 3){ echo 'disabled'; } ?> type="text" name="Montant" id="Montant" min="0" value="<?php if(isset($TOTALTTC) && ($Mode_paiement->mode_paiement != 3) ) {echo $TOTALTTC;} else {echo '0.00';}?>" class="form-control" >
                                            </td>
                                            <td><input <?php if($Mode_paiement->mode_paiement == 3){ echo 'disabled'; } ?> type="number" name="reste" id="reste" min="0" class="form-control" value='0.00' ></td>
                                            <td><a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a></td>
                                                 <?php } ?> 
  

<script>
 $(document).ready(function(){
        $('.select2me').select2('destroy');
        $('.select2me').select2();
        //$('#list_paiment_facture').select2('open');
            }); 

</script>
