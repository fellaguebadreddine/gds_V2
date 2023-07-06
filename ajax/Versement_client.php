<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
        $id = htmlspecialchars(trim($_GET['id'])); 
        $clients = Client::trouve_par_id($id);
}
?>  

					
					
<!--begien reglement-->
						   <?php	  $reglements = Solde_client::trouve_solde_par_id_client($clients->id_client);?>
					
						<table class="table table-striped  table-hover"  id="sample_2">
							<thead>
							<tr>
								
								<th>
									Référence
								</th>
								<th>
									 Mode paiement	
								</th>
								<th>
									Date 
								</th>
								
								<th>
									Montant
								</th>
								<th>
									Reste
								</th>
								<th>
									Consommation
								</th>
								<th>
									
								</th>

							</tr>
							</thead>
							
							<tbody>
								<?php
								foreach($reglements as $reglement){
									$cpt ++;
								?>
							<tr class="item-row">
								
								
								<td >
								
								<b><a href="#">
								<?php if (isset($reglement->reference)) {
									echo $reglement->reference;
									} ?></a></b>
									
								</td>
								<td>
								<b>
								 <?php if (isset($reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>							
                                </b>                
								</td>
								<td>
									<?php if (isset($reglement->date)) {
									echo fr_date2($reglement->date);
									} ?>
									
								</td>
							
								<td>
									<?php if (isset($reglement->credit)) {
									echo number_format ($reglement->credit,2,'.',' ' );
									} ?>
								</td>
								<td>
									<?php if (isset($reglement->solde)) {
									echo number_format ($reglement->solde,2,'.',' ' );
									} ?>
								</td>
								<td>
									<?php   $consommation = $reglement->credit - $reglement->solde;
									$pourcentage = cacul_pourcentage($consommation,$reglement->credit,100);
									if ($pourcentage == 0) {?>
								<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 2%">
									<?php } else if($pourcentage == 100) { ?>
										<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $pourcentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pourcentage; ?>%">
									<?php }else{ ?>
									<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $pourcentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $pourcentage ?>%">	
									<?php } ?>
								</div>
							</div>
								</td>
								<td  class="reglement_<?php if (isset($reglement->id)) {echo $reglement->id;} ?>" >
									<button  id="delete_reglemnt_client" na value="<?php if (isset($reglement->id)) {echo $reglement->id;} ?>" class="btn red btn-xs"> <i class="fa fa-trash"></i> </button>
								</td>
								
								<?php
								}
							?>
							
							</tr>
							</tbody>
							<tbody>
								<tr>
							<td colspan="3">
							<b>Total Montant<b>
							</td>
							<td ><?php $c=0;
							
							
							 $reglement = Solde_client::trouve_versement_par_id_client($clients->id_client);;
							?>
								 <b> <div id="reglement-somme" > <?php echo number_format ($reglement->somme,2,'.',' ') ?></div> </b></td>
							
							<td colspan="3">&nbsp;</td>
							
							</tr>
							<tr>
							<td colspan="4">
							<b>Total Reste<b>
							</td>
							
							<td colspan="3" ><b><div id="reglement-solde"><?php echo number_format ($reglement->solde,2,'.',' ') ?></div></b></td>
							</tr>
							<tr>
							<td colspan="5">
							<b>Total Consommation<b>
							</td>
							
							
							<td> <b> <div id="reglement-credit"><?php echo number_format ($reglement->credit,2,'.',' ') ?></div></b></td>
							<td>&nbsp;</td>
							</tr>
							
							</tbody>
							</table>
					 <!--END reglement-->
<script>
	$(document).ready(function() {
    $('#sample_2').DataTable();

});
</script>