<?php
require_once("../includes/initialiser.php");

	if (isset($_GET['id'])) {
	$id =  htmlspecialchars(($_GET['id'])) ;
	$id_banque =  htmlspecialchars(($_GET['id_banque'])) ;
	$id_caisse =  htmlspecialchars(($_GET['id_caisse'])) ;
	$id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
	$societes= Societe::trouve_par_id($id_societe); 
 
	?>
					<select class="form-control  select2me"   id="id_tier"  name="id_tier"   placeholder="Choisir Compte"  >
						<option></option>
							<?php
								if (isset($id)){
									switch ($id) {
										case 1:
											$Clients = Client::trouve_valid_par_societe($id_societe);
											foreach ($Clients as $Client) { ?>
											
											<option value="<?php if(isset($Client->id_client)){echo $Client->id_client; } ?>">
												<?php if (isset($Client->nom)) {echo $Client->nom;} ?>
											</option>
											<?php } 
											break;
										case 2:
										$Fournisseurs = Fournisseur::trouve_fournisseur_produit_par_societe($id_societe);
											foreach ($Fournisseurs as $Fournisseur) { ?>
											
											<option value="<?php if(isset($Fournisseur->id_fournisseur)){echo $Fournisseur->id_fournisseur; } ?>">
												<?php if (isset($Fournisseur->nom)) {echo $Fournisseur->nom; } ?>
											</option>
										<?php } 
											break;
											case 3:
										$Fournisseurs = Fournisseur::trouve_fournisseur_service_par_societe($id_societe);
											foreach ($Fournisseurs as $Fournisseur) { ?>
											
											<option value="<?php if(isset($Fournisseur->id_fournisseur)){echo $Fournisseur->id_fournisseur; } ?>">
												<?php if (isset($Fournisseur->nom)) {echo $Fournisseur->nom; } ?>
											</option>
										<?php } 
											break;

										case 4:
										$Fournisseurs = Fournisseur::trouve_fournisseur_etranger_par_societe($id_societe);
											foreach ($Fournisseurs as $Fournisseur) { ?>
											<option value="">Choisir un fournisseur</option>
											<option value="<?php if(isset($Fournisseur->id_fournisseur)){echo $Fournisseur->id_fournisseur; } ?>">
												<?php if (isset($Fournisseur->nom)) {echo $Fournisseur->nom; } ?>
											</option>
										<?php } 
											break;
											case 5:
												$banks = compte::trouve_compte_banque_defrent_id_banque($id_societe,$id_banque);
												$caisses= Caisse::trouve_caisse_defrent_id_caisse($id_societe,$id_caisse);
											?>
												<option selected >Choisir dans la liste </option>
											<?php foreach ($banks as $bank) { ?>

											<option value="<?php if (isset($bank->id_banque)){ echo 'b_'.$bank->id_banque; } ?>">
											<?php if (isset($bank->id_banque)) {$banque = Banque::trouve_par_id($bank->id_banque);
													if (isset($banque->Designation)) {
													echo $banque->Designation;
													} } ?>
											</option>

										<?php } 
										 foreach ($caisses as $caisse) { ?>
											<option value="<?php if(isset($caisse->id_caisse)){echo 'c_'.$caisse->id_caisse; } ?>"><?php if (isset($caisse->id_caisse)) {echo $caisse->Designation; } ?> </option>
										<?php }
											break;
											case 6:
											$code_compte='627000';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte,$id_societe);												
											 ?>
											<option value="<?php if(isset($compte_comptables->id)){echo $compte_comptables->id; } ?>">
												<?php if (isset($compte_comptables->libelle)) {echo $compte_comptables->libelle; } ?>
											</option>
										<?php 
											break;
											case 7:
											$code_compte='661000';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte);												
											 ?>
											<option value="<?php if(isset($compte_comptables->id)){echo $compte_comptables->id; } ?>">
												<?php if (isset($compte_comptables->libelle)) {echo $compte_comptables->libelle; } ?>
											</option>
										<?php 
											break;
											case 8:
											
												$listS_g50 = G50::trouve_g50_valid_par_societe($id_societe);
												
											foreach ($listS_g50 as $list_g50) { ?>
											<option value="">Choisir dans la liste</option>
											<option value="<?php if(isset($list_g50->id)){echo $list_g50->id; } ?>">
												<?php if (isset($list_g50->mois)) {echo $list_g50->mois; } ?>
											</option>
										<?php } 
										 
											break;
											case 9:
											$code_compte='431000';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte);
												
											 ?>
											<option value="<?php if(isset($compte_comptables->id)){echo $compte_comptables->id; } ?>">
												<?php if (isset($compte_comptables->libelle)) {echo $compte_comptables->libelle; } ?>
											</option>
										<?php 
											break;
											case 10:
											$code_compte='445660';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte);
												
											 ?>
											<option value="<?php if(isset($compte_comptables->id)){echo $compte_comptables->id; } ?>">
												<?php if (isset($compte_comptables->libelle)) {echo $compte_comptables->libelle; } ?>
											</option>
										<?php 
											break;
											case 11:
											$code_compte='275000';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte);
												
											 ?>
											<option value="<?php if(isset($compte_comptables->id)){echo $compte_comptables->id; } ?>">
												<?php if (isset($compte_comptables->libelle)) {echo $compte_comptables->libelle; } ?>
											</option>
										<?php 
											break;
											case 12:
											$code_compte='164000';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte);
												
											 ?>
											<option value="<?php if(isset($compte_comptables->id)){echo $compte_comptables->id; } ?>">
												<?php if (isset($compte_comptables->libelle)) {echo $compte_comptables->libelle; } ?>
											</option>
										<?php 
											break;
											case 13:
											$code_compte='455000';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte);
												
											 ?>
											<option value="<?php if(isset($compte_comptables->id)){echo $compte_comptables->id; } ?>">
												<?php if (isset($compte_comptables->libelle)) {echo $compte_comptables->libelle; } ?>
											</option>
										<?php 
											break;
											case 14:
											
												$compte_comptables = Compte_comptable::trouve_compte_comptable_par_societe($id_societe);
												foreach ($compte_comptables as $compte_comptable){
											 ?>
											<option value="<?php if(isset($compte_comptable->id)){echo $compte_comptable->id; } ?>">
												<?php if (isset($compte_comptable->libelle)) {echo $compte_comptable->code.' | '.$compte_comptable->libelle; } ?>
											</option>
										<?php 
												 }
											break;
							
									}	
								}	?>	
																						   
					</select> 
	<?php } ?>	
 

  