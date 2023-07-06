<?php
require_once("../includes/initialiser.php");


 if (isset($_GET['id_caisse'])){
	$id_caisse =  htmlspecialchars(($_GET['id_caisse'])) ;
	$id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
	$societes= Societe::trouve_par_id($id_societe);
	$caisse = Caisse::trouve_par_id($id_caisse);
	$releves_caisse = Releve_comptes::trouve_releve_par_id_caiss ($id_caisse);
	?>	
 
<div class="well"><i class="fa fa-archive font-yellow"> </i> <?php if (isset($caisse->id_caisse)){echo $caisse->Designation ; }?></div>

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
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
							<?php
								foreach($releves_caisse as $releve){
									
								?>
							<tr class="">
								
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
									<?php if (isset($releve->id_caisse)) {
									 $nature_operations = Nature_operation::trouve_par_id($releve->id_caisse); 
									 if (isset($nature_operations->libelle)) {echo $nature_operations->libelle;}
									} ?>
								</td>
								<td>
									<?php if (isset($releve->tiers)) {
										
											switch ($releve->id_caisse) {
												case 1:
													$clients = Client::trouve_par_id($releve->tiers); 
														if (isset($clients->nom)) {echo $clients->nom;}
												break;
												case 2:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->tiers); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;
												case 3:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->tiers); 
														if (isset($Fournisseurs->nom)) {echo $Fournisseurs->nom;}
												break;

												case 4:
												
													$Fournisseurs = Fournisseur::trouve_par_id($releve->tiers); 
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
													$clients = Client::trouve_par_id($releve->tiers);  
													$factures = Facture_vente::trouve_par_id($releve->details);
														$date = date_parse($factures->date_fac);
														echo sprintf("%04d", $factures->N_facture).'/'.$date['year'];
												break;
											}
										}else if ($releve->details == 0){echo '/';}
									}?>
								</td>
								<td>
									<?php if (!empty($releve->facture_scan)) {
										 $file = str_replace (" ", "_", $societes->Dossier );
										 $ScanImage = Upload::trouve_par_id($releve->facture_scan);
									echo '<a href="scan/upload/'.$file.'/'.$ScanImage->img .'" class="btn bg-green-jungle fancybox-button btn-xs" ><i class="fa fa-eye"></i></a>';
									
									} ?>
								</td>
								<td>
									
									<a href="saisie.php?action=edit_releve&id=<?php echo $releve->id; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									
								</td>
							</tr>

							<?php
								}
							?>
						
						</tbody>
							
					</table>
<?php }?>
  