<?php
require_once("../includes/initialiser.php");
		$errors = array();


 if ( (isset($_GET['id_user'])) && (is_numeric($_GET['id_user'])) && (isset($_GET['id_societe'])) && (is_numeric($_GET['id_societe'])) ) {
 	$id_user = htmlspecialchars(trim($_GET['id_user']));
 	$id_societe = htmlspecialchars(trim($_GET['id_societe']));

 	$table_vantes = Vente::trouve_vente_vide_par_admin($id_user,$id_societe);
 	$societe = Societe::trouve_par_id($id_societe);
 	$Somme_ht = Vente::somme_ht($id_user,$id_societe);
	$Somme_tva = Vente::somme_tva($id_user,$id_societe);
	$Somme_ttc = Vente::somme_ttc($id_user,$id_societe);
 	if (!empty($table_vantes)) {
		$Last_client = Vente::trouve_last_client_par_id_admin($id_user,$id_societe);
		$client = Client::trouve_par_id($Last_client->id_client);
	}	
 }
?>


				<div class="portlet light">
					<div class="portlet-body">
				<div class="invoice">
					<div class="row invoice-logo">
								<div class="col-xs-6 invoice-logo-space">
									<img src="assets/admin/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
								</div>
								<div class="col-xs-6">
									<p>
										 #5652256 / 28 Feb 2013 <span class="muted">
										Consectetuer adipiscing elit </span>
									</p>
								</div>
							</div>
					<hr/>
					<div class="row">
				<div class="col-xs-7">
						<h3>Client:  <?php if (isset($client->nom)) { echo  $client->nom;} ?></h3>
						<ul class="list-unstyled">
							<li>
								<?php if (isset($client->Adresse)) {
									echo "Adresse: ".$client->Adresse;
								} ?>
							</li>
							<li>
								 <?php if (isset($client->Tel1)) {
									echo "Tel: ".$client->Tel1;
								} ?>
							</li>
							<li>
								
							</li>
							
						</ul>
					</div>
					<div class="col-xs-5 invoice-payment">
						<h3>Facture N°: </h3>
						<ul class="list-unstyled" style="font-size: 14px;">
							<li>
								<strong>Date : </strong> 
							</li>
							<li>
								<strong></strong> 
							</li>
							<li>
								<strong></strong> 
							</li>
							
						</ul>
					</div>
				</div>
				

				<div class="row">
					<div class="col-xs-12">
						<table class="table table-striped table-bordered table-hover" >
							<thead>
							<tr>
								<th>
									 N°
								</th>
								<th>
									Article
								</th>
								<th>
									 Quantité 
								</th>
								<th>
									  Prix U 
								</th>
								<th>
									HT
								</th>
								<th>
									TAUX  TVA 
								</th>
								<th>
									 TVA
								</th>
								<th>
									TOTAL  
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_vantes as $table_vante){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($cpt)) {
										echo $cpt;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Designation)) {
										echo $table_vante->Designation;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Quantite)) {
										echo $table_vante->Quantite;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Prix)) {
										echo $table_vante->Prix;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Ht)) {
										echo $table_vante->Ht;
									} ?>
									
								</td>
								<td>
									<?php if (isset($table_vante->Ttva)) {
										echo ($table_vante->Ttva *100).' %';
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Tva)) {
										echo $table_vante->Tva;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->total)) {
										echo $table_vante->total;
									} ?>
								</td>
								
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						<ul class="list-unstyled amounts">
							<li >
								<strong> TOTAL HT: </strong> <?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> DA 
							</li>
							<li >
								<strong> TOTAL TVA: </strong> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> DA 
							</li>
							<li >
								<strong> TOTAL TTC: </strong> <?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> DA
							</li>
						</ul>
						<br/>
						<a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer
						</a>
					</div>
				</div>
			</div>
				</div>
			</div>