<?php 
require_once("../includes/initialiser.php");
if ( $_GET['action'] == 'importation') {


} else if ($_GET['action'] == 'update_importation') {

if (isset($_GET['id_facture'])) {
$id_facture = htmlspecialchars(trim($_GET['id_facture']));
$nav_societe = Societe::trouve_par_id($_SESSION['societe']);
}
$Articles = Produit::trouve_produit_importation_par_societe($nav_societe->id_societe);

//////////////////////////////////////////////// 
 				$achats = Update_achat_importation::trouve_achat_notvalide_par_facture($id_facture);	
				 	$Somme_ht = Update_achat_importation::somme_ht_par_facture($id_facture);
					$Somme_tva = Update_achat_importation::somme_tva_par_facture($id_facture);
					$Somme_ttc = Update_achat_importation::somme_ttc_par_facture($id_facture);  
				$last_fournisseur = Update_achat_importation::trouve_last_fournisseur_par_id_facture($id_facture); 
			///////////////////////////  somme frais ////////////////////////////////////////////
				$Somme_ht_frais = Update_achat_importation::somme_ht_frais_par_facture($id_facture);
				$Somme_tva_frais = Update_achat_importation::somme_tva_frais_par_facture($id_facture);
				$Somme_ttc_frais = Update_achat_importation::somme_ttc_frais_par_facture($id_facture);
				$total_importation = $Somme_ht->somme_ht+$last_fournisseur->shipping;
	 		//////////////////////////////////////

 			/////////////// update valeur achat et contre valeur en DA /////////////////

 			foreach($achats as $achat){ 
 			  		$achat->Ht = $achat->Ht_devise+( $achat->Ht_devise *($last_fournisseur->shipping/$Somme_ht->somme_ht));
 			  		$achat->Contre_Valeur = $Somme_ht_frais->somme_ht / $total_importation * $achat->Ht ;
 			  		$achat->Prix = $achat->Contre_Valeur / $achat->Quantite ;
 			  		$achat->save();
 			  										} 
	?>




<table class="table table-striped table-bordered table-hover" id="table_2" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								<th width="60">
									Code
								</th>
								<th>
									 Qté 
								</th>
								<th>
									  PU($)
								</th>
								<th>
									  Remise
								</th>
								<th>
									VA($)
								</th>
								<th>
									VA(DA) 
								</th>
								<th>
									CV
								</th>
								<th>
									PU(DA)
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								$table_achats = Update_achat_importation::trouve_achat_notvalide_par_facture($id_facture);
								  $cpt =0; foreach($table_achats as $table_achat){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($table_achat->Designation)) {
										echo $table_achat->Designation;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Code)) {
										echo $table_achat->Code;
									} ?>
								</td>
								
								<td>
									<?php if (isset($table_achat->Quantite)) {
										echo $table_achat->Quantite;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix_devise)) {
										echo $table_achat->Prix_devise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Remise)) {
										echo $table_achat->Remise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Ht_devise)) {
										echo $table_achat->Ht_devise;
									} ?>
									
								</td>
								<td>
									<?php if (isset($table_achat->Ht)) {
										echo $table_achat->Ht;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Contre_Valeur)) {
										echo $table_achat->Contre_Valeur;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo $table_achat->Prix;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_achat->id)){ echo $table_achat->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							<tbody>
								
							<tr class="info-prodact" >
								
								<td>
									<select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
															<option value=""></option>
														<?php  foreach ($Articles as $Article) { ?>
																	<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
																<?php } ?>														   
														</select>   
								</td>
								
								<td>
									
								</td>
								<td>
									 
								</td>
								<td>
									 
								</td>
								<td>
									
								</td>
								<td>
									
								</td>
								<td>
									

								</td>
								<td></td>
								<td></td>

								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL ACHAT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.000";}  ?> $</span></td>
							    </tr>
							     <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> SHIPPING : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php if (isset($last_fournisseur->shipping)) {echo $last_fournisseur->shipping;  }  else {echo "0.000";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT: </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc+ $last_fournisseur->shipping; } else {echo "0.000";}  ?> $</span></td>
							    </tr>

										
                            </tbody>
							</table>
	<?php }?>
	        <script type="text/javascript">
            $(document).ready(function(){
                $('#id_article').select2();
                $('#Frais_annexe').select2();
                $("#id_article").select2("open");
            });


            </script> 