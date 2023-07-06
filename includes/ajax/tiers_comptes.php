<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $societes= Societe::trouve_par_id($id_societe);
 
 
		?>

					<select class="form-control  "   id="id_tier"  name="id_tier"   placeholder="Choisir Compte"  >
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
												$banques = Banque::trouve_par_societe($id_societe);
												$caisses=Caisse::trouve_caisse_par_societe($id_societe);
											foreach ($banques as $banque) { ?>
											<option value="">Choisir une banque</option>
											<option value="<?php if(isset($banque->id)){echo $banque->id; } ?>">
												<?php if (isset($banque->Designation)) {echo $banque->Designation; } ?>
											</option>
										<?php } 
											break;
											case 6:
											$code_compte='627000';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte);
												
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
											$code_compte='404000';
												$compte_comptables = Compte_comptable::trouve_par_code($code_compte);
												
											 ?>
											<option value="<?php if(isset($compte_comptables->id)){echo $compte_comptables->id; } ?>">
												<?php if (isset($compte_comptables->libelle)) {echo $compte_comptables->libelle; } ?>
											</option>
										<?php 
											break;
											



									}	
								}	?>	
																						   
					</select> 


	<?php } ?>	
 

  