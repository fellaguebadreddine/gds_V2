<?php
require_once("../includes/initialiser.php");
$thisday=date('Y-m-d');	
$nature_operations = Nature_operation:: trouve_tous();
if (isset($_GET['id'])) {
  $id =  htmlspecialchars(($_GET['id'])) ;
  $new_id = substr($id, 0, 1);
  
  if ($new_id =='b'){
   $id_banque=substr($id,  2);
  		
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $societes= Societe::trouve_par_id($id_societe);
 $banque = Banque::trouve_par_id($id_banque);
$releves = Releve_comptes::trouve_releve_par_id_banque ($id_banque);
	$Fournisseurs = Fournisseur::trouve_valid_par_societe($societes->id_societe); 
	$banques= Banque::trouve_banque_par_societe($societes->id_societe); 

		?>
<hr>
<div class="  "></div>
<div class="well"><i class="fa fa-university font-yellow"> </i> <?php if (isset($banque->id_banque)){echo $banque->Designation . ' - '.$banque->abreviation; }?></div>
<div class="notification">
					<table class="table table-striped table-hover" id="">
							<thead>
							<tr>
								
								<th>
									Date
								</th>
								<th>
									Référence
								</th>
								<th>
									Désignation
								</th>
								<th>
									Nature Opération
								</th>
								<th>
									Tiers
								</th>
								<th>
									Details
								</th>
								<th>
									Débit
								</th>
								<th>
								 Crédit
								</th>								
								
								<th>Type</th>
								<th width="9%">
									#
								</th>
							</tr>
							</thead>
							<body>				
								<input type="hidden" name="id_societe" id="id_societe" value="<?php if(isset($societes->id_societe)){echo $societes->id_societe; } ?>">	   
								<input type="hidden"  name="date_valid" id="date_valid"  value="<?php echo $thisday; ?>" />
								<input type="hidden"  name="id_caisse" id="id_caisse"  value="0" />
								<input type="hidden"  name="id_banque" id="id_banque"  value="<?php if (isset($id_banque)){echo $id_banque;} ?>" />					
					
							<tr id="releve_form"  >								
								
								<td>
                                   <input type="date" name = "date" id="date"  value="<?php echo $thisday; ?>"  class="form-control"   placeholder="date "  >
                                   
                                </td>

								<td>
									<input type="text" name = "ref_releve" id="ref_releve"    class="form-control  "   placeholder="Référence "  >
								</td>
								<td>
									<input type="text" name = "libelle" id="libelle"  class="form-control  "   placeholder="Désignation "  >
								</td>
								<td>
									<select class="form-control  "   id="id_nature"  name="id_nature"   placeholder="Choisir dans la liste" >
										<option value=""></option>
											<?php  foreach ($nature_operations as $nature_operation) { ?>
												<option value="<?php if(isset($nature_operation->id)){echo $nature_operation->id; } ?>"><?php if (isset($nature_operation->id)) {echo $nature_operation->libelle; } ?> </option>
											<?php } ?>														   
									</select>
								</td>
								<td class=" id_tier">
									  
								</td>
								<td class="id_facture">
								</td>
								<td class="id_debit">
									
								</td>

								<td class="id_credit">
									
								</td>
								
								
								<td>
									<?php $Mode_paiement_societes= Mode_paiement_societe::trouve_mode_paiment_autre_especes_par_societe($id_societe);?>
									<select placeholder="Choisir mode paiement"   name="mode_paiment" id="mode_paiment"   class=" form-control select2me">
                                        <option value=""></option>
                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                        <?php } ?>
									</select> 
								</td>
								
								<td> <a id="save_releve"  class="btn  green-jungle"  > <i class="fa fa-plus"></i></a> </td>
							</tr>
				
						  

							</body>
							<tbody>
							<?php
								foreach($releves as $releve){
									
								?>
							<tr class="item-row">
								
								<td>
									<?php if (isset($releve->date)) {
									echo fr_date2($releve->date);
									} ?>
								</td>
								<td>
									<?php if (isset($releve->ref_releve)) {
									echo $releve->ref_releve;
									} ?>
								</td>
								<td>
									<?php if (isset($releve->libelle)) {
									echo $releve->libelle;
									} ?>
								</td>
								<td>
									<?php if (isset($releve->somme_debit)) {

									echo number_format($releve->somme_debit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($releve->somme_credit)) {
									echo number_format($releve->somme_credit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($releve->id_nature)) {
									 $nature_operations = Nature_operation::trouve_par_id($releve->id_nature); 
									 if (isset($nature_operations->libelle)) {echo $nature_operations->libelle;}
									} ?>
								</td>
								<td>
									<?php if (isset($releve->id_tier)) {
										
											switch ($releve->id_nature) {
												case 1:
													$clients = Client::trouve_par_id($releve->id_tier);  
														if (isset($clients->nom)) {echo $clients->nom;}
												break;
												case 2:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 3:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;

												case 4:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 5:
												
													echo 'Virement Interne';
												break;
												case 6:
												
													echo 'Agios';
												break;
												case 7:
												
													echo 'Intêrets';
												break;
												case 8:
												
													echo 'Impôts';
												break;
												case 9:
												
													echo 'Organismes Sociaux';
												break;
												case 10:
												
													echo 'T.V.A';
												break;
												case 11:
												
													echo 'Caution';
												break;
												case 12:
												
													echo 'Emprunt';
												break;
												case 13:
												
													echo 'Associé';
												break;
												case 14:
												
													echo 'Paiement Fournisseurs immobilisation';
												break;
												case 15:
												
													echo 'Autres';
												break;


											}	
									 
									} ?>
									
								</td>
								<td>
									<?php if (isset($releve->details)) {
										if ($releve->details != 0){
										switch ($releve->id_nature) {
												
												case 1:
													$clients = Client::trouve_par_id($releve->id_tier);  
													$factures = Facture_vente::trouve_par_id($releve->details);
														$date = date_parse($factures->date_fac);
														echo sprintf("%04d", $factures->N_facture).'/'.$date['year'];
												break;
												
											}
										}else if ($releve->details == 0){echo '/';}
									}?>
								</td>
								<td> <?php if (isset($releve->mode_paiment)) { $Mode_paiement_societes= Mode_paiement_societe::trouve_par_id($releve->mode_paiment); echo $Mode_paiement_societes->type;}?></td>
																
								<td>
									
									<a href="saisie.php?action=edit_releve&id=<?php echo $releve->id; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									<button  id=""  value="<?php if (isset($releve->id)){ echo $releve->id; } ?>" class="btn red btn-xs"> <i class="fa fa-trash"></i> </button>
								</td>
							</tr>

							<?php
								}
							?>
						
							</tbody>
							
							</table>
							</div>
		<?php  }else if ($new_id =='c'){
			$id_caisse=substr($id, 2);
			
			$id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
			$societes= Societe::trouve_par_id($id_societe);
			$caisse = Caisse::trouve_par_id($id_caisse);
			$releves_caisse = Releve_comptes::trouve_releve_par_id_caiss ($id_caisse);
			
			?>	
		 <hr>
		<div class="well"><i class="fa fa-archive font-yellow"> </i> <?php if (isset($caisse->id_caisse)){echo $caisse->Designation ; }?></div>
<div class="notification">
					<table class="table table-striped table-hover" id="">
							<thead>
							<tr>
								
								<th>
									Date
								</th>
								<th>
									Référence
								</th>
								<th>
									Désignation
								</th>
								<th>
									Débit
								</th>
								<th>
								 Crédit
								</th>
								<th>
									Nature Opération
								</th>
								<th>
									Tiers
								</th>
								<th>
									Details
								</th>
								<th>
									Scan
								</th>
								<th width="9%">
									#
								</th>
							</tr>
							</thead>
							<body>				
								<input type="hidden" name="id_societe" id="id_societe" value="<?php if(isset($societes->id_societe)){echo $societes->id_societe; } ?>">	   
								<input type="hidden"  name="date_valid" id="date_valid"  value="<?php echo $thisday; ?>" />
								<input type="hidden"  name="id_caisse" id="id_caisse"  value="<?php if (isset($caisse->id_caisse)){echo $caisse->id_caisse;} ?>" />
								<input type="hidden"  name="id_banque" id="id_banque"  value="0" />					
					
								<tr id="releve_form"  >								
								
								<td>
                                   <input type="date" name = "date" id="date"  value="<?php echo $thisday; ?>"  class="form-control"   placeholder="date "  >
                                   
                                </td>

								<td>
									<input type="text" name = "ref_releve" id="ref_releve"    class="form-control  "   placeholder="Référence "  >
								</td>
								<td>
									<input type="text" name = "libelle" id="libelle"  class="form-control  "   placeholder="Désignation "  >
								</td>
								<td>
									<input type="number" name = "somme_debit" id="somme_debit" min="0"   class="form-control  "   placeholder="Débit "  >
								</td>

								<td>
									<input type="number" name = "somme_credit" id="somme_credit" min="0"  class="form-control "  placeholder="Crédit "   >	
								</td>
								<td>
									<select class="form-control  "   id="id_nature"  name="id_nature"   placeholder="Choisir dans la liste" >
										<option value=""></option>
											<?php  foreach ($nature_operations as $nature_operation) { ?>
												<option value="<?php if(isset($nature_operation->id)){echo $nature_operation->id; } ?>"><?php if (isset($nature_operation->id)) {echo $nature_operation->libelle; } ?> </option>
											<?php } ?>														   
									</select>
								</td>
								<td class=" id_tier">
									  
								</td>
								<td class="id_facture">							
									
								
								</td>
								<td>
									<?php $Mode_paiement_societes= Mode_paiement_societe::trouve_mode_paiment_especes_par_societe($id_societe);?>
									<select placeholder="Choisir mode paiement"   name="mode_paiment" id="mode_paiment"   class=" form-control select2me">
                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                        <?php } ?>
									</select> 
								</td>
								
								<td> <a id="save_releve"  class="btn  green-jungle"  > <i class="fa fa-plus"></i></a> </td>
								</tr>
							</body>
							<tbody>
							<?php
								foreach($releves_caisse as $releve){
									
								?>
							<tr class="item-row">
								
								<td>
									<?php if (isset($releve->date)) {
									echo fr_date2($releve->date);
									} ?>
								</td>
								<td>
									<?php if (isset($releve->ref_releve)) {
									echo $releve->ref_releve;
									} ?>
								</td>
								<td>
									<?php if (isset($releve->libelle)) {
									echo $releve->libelle;
									} ?>
								</td>
								<td>
									<?php if (isset($releve->somme_debit)) {

									echo number_format($releve->somme_debit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($releve->somme_credit)) {
									echo number_format($releve->somme_credit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($releve->id_nature)) {
									 $nature_operations = Nature_operation::trouve_par_id($releve->id_nature); 
									 if (isset($nature_operations->libelle)) {echo $nature_operations->libelle;}
									} ?>
								</td>
								<td>
									<?php if (isset($releve->id_tier)) {
										
											switch ($releve->id_nature) {
												case 1:
													$clients = Client::trouve_par_id($releve->id_tier); 
														if (isset($clients->nom)) {echo $clients->nom;}
												break;
												case 2:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 3:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;

												case 4:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->id_tier); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 5:
												
													echo 'Virement Interne';
												break;
												case 6:
												
													echo 'Agios';
												break;
												case 7:
												
													echo 'Intêrets';
												break;
												case 8:
												
													echo 'Impôts';
												break;
												case 9:
												
													echo 'Organismes Sociaux';
												break;
												case 10:
												
													echo 'T.V.A';
												break;
												case 11:
												
													echo 'Caution';
												break;
												case 12:
												
													echo 'Emprunt';
												break;
												case 13:
												
													echo 'Associé';
												break;
												case 14:
												
													echo 'Paiement Fournisseurs immobilisation';
												break;
												case 15:
												
													echo 'Autres';
												break;



											}	
									 
									} ?>
									
								</td>
								<td>
									<?php if (isset($releve->details)) {
										if ($releve->details != 0){
										switch ($releve->id_caisse) {
												
												case 1:
													$clients = Client::trouve_par_id($releve->id_tier);  
													$factures = Facture_vente::trouve_par_id($releve->details);
														$date = date_parse($factures->date_fac);
														echo sprintf("%04d", $factures->N_facture).'/'.$date['year'];
												break;
											}
										}else if ($releve->details == 0){echo '/';}
									}?>
								</td>
								<td>
									<?php if (isset($releve->mode_paiment)) { $Mode_paiement_societes= Mode_paiement_societe::trouve_par_id($releve->mode_paiment); echo $Mode_paiement_societes->type;}?>
								</td>
								
								<td>
									
									<a href="saisie.php?action=edit_releve&id=<?php echo $releve->id; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									<button  id=""  value="<?php if (isset($releve->id)){ echo $releve->id; } ?>" class="btn red btn-xs"> <i class="fa fa-trash"></i> </button>
								</td>
							</tr>

							<?php
								}
							?>
						
						</tbody>
							
					</table>
					</div>
	
<?php }}?>
 
