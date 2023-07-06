<?php
require_once("../includes/initialiser.php");
$cpt=0;
if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $immobils = Immobilisation::trouve_par_id($id);
 $societe= Societe::trouve_par_id($id_societe);
}else{
        echo 'Content not found....';
}

?>
                        <div class="modal-body">
                       <!-- BEGIN FORM-->
					<form   id="immobil_form"   class="form-horizontal" enctype="multipart/form-data">				
			
				<input type="hidden" name="id_societe" value="<?php if(isset($societe->id_societe)){echo $societe->id_societe; } ?>">	   
				
                    
            
						<table class="table " id="" >
							<thead>
							<tr>
								<th >
									Famille
								</th>
								<th>
									Type d'amortissement
 
								</th>
								<th>
									Code
								</th>
								
								<th>
									Libellé 
								</th>
								<th>
									Nature
								</th>
								
								<th>
									Taux d'amortissement
								</th>
								<th>
									Date d'achat 
								</th>
								<th>
									Valeur d'achat
								</th>
								<th>
									Fournisseur
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								
							<tr id="" >
								<td>
									<select class="form-control select"   id="id_famille"  name="id_famille"   placeholder="Selctionner Famille" >
										<option value=""></option>
										<?php

										$famille_immobil = Famille_immobilisation::trouve_famille_immobilisation_par_societe($societe->id_societe);
		
										foreach($famille_immobil as $famille_immo){ ?>
										<option <?php if ($immobils->id == $famille_immo->id) {echo "selected";}?>
										 value="<?php if(isset($famille_immo->id)){echo $famille_immo->id; } ?>"><?php if (isset($famille_immo->libelle)) {echo $famille_immo->libelle;} ?> </option>
											
											<?php } ?>														   
									</select>   
								</td>
								<td class="type_amortissement">
								</td>
								<td>
									
									<input type="text"  name="code"  id="code"  class="form-control Code"  placeholder=" Code" required />
								</td>
								<td >
									<input type="text" class="form-control  libelle"   id="libelle"  name="libelle" placeholder=" libelle"    required />								 
								</td>
								<td >
									<input type="text" class="form-control  nature"   id="nature"  name="nature" placeholder=" nature"    required />								 
								</td>
								
								
								<td >
									<input type="number"  name="taux" id="taux" class="form-control taux" placeholder=" taux"    required />
								</td>
								<td >
									<input type="date"  name="date" id="date" value="<?php echo $thisday;?>" class="form-control date" placeholder=" taux"    required />
								</td>
								<td >
									<input type="number"  name="valeur_achat" id="valeur_achat" class="form-control valeur_achat" placeholder=" valeur achat"    required />
								</td>
								<td>
								<select class="form-control select2me"    name="id_fournisseur" id="id_fournisseur"  placeholder="Choisir fournisseur" >
								
								<option value=""></option>
									<?php 
											$fournisseurs = Fournisseur::trouve_valid_par_societe($societe->id_societe); 
										foreach ($fournisseurs as $fournisseur) { ?>
										<option <?php if ($edit_fact->id_fournisseur == $fournisseur->id_fournisseur) {echo "selected";}?>
										 value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>"><?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?> </option>
									<?php } ?>	
										
																	   
							</select>  
								</td>
								
							</tr>
						
						
							</tbody>
							
							
							</table>
							
						
						<input type="hidden" name="facture_scan" value="<?php if (isset($_GET['id_img'])) {	 $image =  htmlspecialchars($_GET['id_img']) ; echo  $image ; }?>" />
							
				</form>	
					<!-- END FORM-->
                                
               
                                                                
                <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default bg-red btn-sm">Fermer</button>
                <a href="" class="btn blue btn-sm">
                    <i class="fa fa-edit "></i> modifier</a>
                </div>
				 </div>