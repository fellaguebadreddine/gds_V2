<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $societes= Societe::trouve_par_id($id_societe);
 if ($id ==6){
?>
<td> / </td>

<?php }else{?>
    <td class="nature_op">
									<?php $Mode_paiement_societes= Mode_paiement_societe::trouve_mode_paiment_autre_especes_par_societe($id_societe);?>
									<select placeholder="Choisir mode paiement"   name="mode_paiment" id="mode_paiment"   class=" form-control select2me">
                                        <option value=""></option>
                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                        <?php } ?>
									</select> 
								</td>

<?php } } ?>	
 

  