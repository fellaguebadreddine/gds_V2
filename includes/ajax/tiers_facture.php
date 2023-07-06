<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_nature =  htmlspecialchars(($_GET['id_nature'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $societes= Societe::trouve_par_id($id_societe);
 
 
		?>

					<select class="form-control  "   id="id_facture"  name="id_facture"   placeholder="Choisir Compte"  >
						
							<?php
								if (isset($id_nature)){
									switch ($id_nature) {
										case 1:
											$Clients = Client::trouve_par_id($id);
											$factures = Facture_vente::trouve_facture_par_id_client_etat_facture_non_valide($Clients->id_client);
											if (!empty($factures)) {
											foreach($factures as $facture){?>
											<option value="<?php if (isset($facture->id_facture)) {echo $facture->id_facture; }?>">
												<?php if (isset($facture->N_facture)) {
														$date = date_parse($facture->date_fac);
														echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; }  ?>
											</option>
											<?php }
											}else{
												echo '<option value="">auccune factures trouvées</option>';
											} 
											break;
										case 2:
											$Fournisseurs = Fournisseur::trouve_par_id($id);
											$factures = Facture_achat::trouve_facture_non_valide_par_id_fournisseur($Fournisseurs->id_fournisseur);
											if (!empty($factures)) {
											foreach($factures as $facture){?>
											<option value="<?php if (isset($facture->id_facture)) {echo $facture->id_facture; }?>">
												<?php if (isset($facture->N_facture)) {
														$date = date_parse($facture->date_fac);
														echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; }  ?>
											</option>
											<?php } 
											}else{
												echo '<option value="">auccune factures trouvées</option>';
											} 
											break;
											case 3:
											$Fournisseurs = Fournisseur::trouve_par_id($id);
											$factures = Facture_achat::trouve_facture_par_id_fournisseur($Fournisseurs->id_fournisseur);
											foreach($factures as $facture){?>
											<option value="<?php if (isset($facture->id_facture)) {echo $facture->id_facture; }?>">
												<?php if (isset($facture->N_facture)) {
														$date = date_parse($facture->date_fac);
														echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; }  ?>
											</option>
											<?php } 
											break;
											case 4:
											$Fournisseurs = Fournisseur::trouve_par_id($id);
											$factures = Facture_achat::trouve_facture_par_id_fournisseur($Fournisseurs->id_fournisseur);
											foreach($factures as $facture){?>
											<option value="<?php if (isset($facture->id_facture)) {echo $facture->id_facture; }?>">
												<?php if (isset($facture->N_facture)) {
														$date = date_parse($facture->date_fac);
														echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; }  ?>
											</option>
											<?php } 
											break;
											case 5:
												
											?>
											<option >none</option>
										<?php  
											break;
											case 6:
											
											 ?>
											<option >none</option>
										<?php 
											break;
											case 7:
											
											 ?>
											<option >none</option>
										<?php 
											break;
											case 8:
											      ?>
											<option >none</option>
										<?php 

										 
											break;
											case 9:
											
											 ?>
											<option disabled>none</option>
										<?php 
											break;
											case 10:
											
											 ?>
											<option disabled>none</option>
										<?php 
											break;
											case 11:
											
											 ?>
											<option disabled>none</option>
										<?php 
											break;
											case 12:
											
											 ?>
											<option disabled>none</option>
										<?php 
											break;
											case 13:
											
											 ?>
											<option disabled>none</option>
										<?php 
											break;
											case 14:
											
											 ?>
											<option disabled>none</option>
										<?php 
											break;

									}	
								}	?>	
																						   
					</select> 


	<?php } ?>	
 

  