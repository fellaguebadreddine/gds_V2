<?php
require_once("../includes/initialiser.php");


	
if (isset($_GET['id_societe'])) {
	$id_societe=$_GET['id_societe'];
        
		$famille_immobilisations = Famille_immobilisation::trouve_famille_immobilisation_par_societe($id_societe->id_societe);
}
?>  

	
						
								<?php
								foreach($famille_immobilisations as $famille_immobilisation){
								
								?>
							<tr class="">
								
								<td>
					
								<?php if (isset($famille_immobilisation->libelle)) {
									
									
									echo $famille_immobilisation->libelle;
									} ?>
								</td>
								
								<td>
								<?php if (isset($famille_immobilisation->code  )) {
									echo $famille_immobilisation->code  ;
									} ?>
									
								</td>
								<td>
								<?php if (isset($famille_immobilisation->type_amortissement)) {
									switch ($famille_immobilisation->type_amortissement){
										case 0:
											echo "/";
											break;
										case 1:
											echo "Linéaire";
											break;
										case 2:
											echo "Dégressif";
											break;
										case 3:
											echo "Non Amortisable";
											break;
									}
									
									} ?>
									
								</td>
								<td>
								<?php if (isset($famille_immobilisation->duree   )) {
									echo $famille_immobilisation->duree   ;
									} ?>
									
							
								</td>
								
							</tr>
							<?php
								}
							?>
							
						
							