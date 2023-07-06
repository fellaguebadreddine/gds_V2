<?php
require_once("../includes/initialiser.php");

 if(!empty($_SESSION['societe'])){
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);}
if (isset($nav_societe->id_societe)) {
        
		$list_depenses = Facture_depense::trouve_facture_depense_par_societe($nav_societe->id_societe);
}
?>  

	
						<table class="table table-striped  table-hover ">
							<thead>
							<tr>
								<th>
									Réf 
								</th>
								<th>
									Date 
								</th>
								<th>
									Dépense 
								</th>
								<th>
									Fournisseur 
								</th>
								<th>
									HT 
								</th>
								<th>
									TVA 
								</th>
								<th>
									timbre 
								</th>
								<th>
									TTC 
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($list_depenses as $list_depense){
									
								?>
							<tr>
								
								
								<td>
									
									<?php if (isset($list_depense->reference)) {
										echo '<i class="fa fa-file font-yellow"></i> ' . $list_depense->reference ;
									 } ?>
									
                                   
								</td>
								<td>
									<?php if (isset($list_depense->date_fact)) {
									echo $list_depense->date_fact;
									} ?>
								</td>
								<td>
									<?php if (isset($list_depense->id_depense)) {
										$depenses = Depense::trouve_par_id($list_depense->id_depense);
									echo '<i class="fa fa-dollar font-yellow"></i> ' . $depenses->depense;
									} ?>
								</td>
								<td>
									<?php if (isset($list_depense->id_fournisseur)) {
										$fournisseur = Fournisseur::trouve_par_id($list_depense->id_fournisseur);
									echo '<i class="fa fa-user font-yellow"></i> ' . $fournisseur ->nom;
									} ?>
								</td>								
								<td>
								<?php if (isset($list_depense->ht)) {
									echo $list_depense->ht;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->tva)) {
									echo $list_depense->tva;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->timbre)) {
									echo $list_depense->timbre;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->ttc)) {
									echo $list_depense->ttc;
									} ?>
								</td>
								
							</tr>
							
							
							<?php
								}
							?>
							
						
							</tbody>
							
							</table>
						