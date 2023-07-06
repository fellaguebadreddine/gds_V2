<!-- BEGIN PAGE ACHAT-->
<div class="col-md-12">

        <div class="portlet light bordered">
            <div class="alert bg-blue-ebonyclay"> <i class="fa fa-shopping-cart"></i>
            <span>Avoir Vente </span>
            </div>
		<div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-blue-ebonyclay"></i>
                        <span class="caption-subject font-blue-ebonyclay bold uppercase">non sélectionné</span> 
                    </div>
            </div>
                    
			
                    <table class="table table-striped table-bordered " >
							<thead>
							<tr>
								<th >
									#
								</th>
                                <th>
									Client
								</th>
								<th>
									Date facture
								</th>
								
								<th>
									HT
								</th>
								<th>Remise</th>
								<th>Tva</th>
								<th>Timbre</th>
								<th>TTC</th>
                                </tr>
                            </thead>
                            <body>
                            <?php
								foreach($facturesAvoirVentetNotSelected as $facture){
									
								?>
                                <tr >
								<td>
								
								<input type="checkbox" name="IdCheckboxAvoirVente" value="<?php echo $facture->id_facture ?>" />
								
								</td>
                                <td>
								<a href="#" class="">
								
									<b><?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?></b>
									
                                                    </a>
								</td>
                                <td>
								<i class="fa fa-building  font-yellow"></i>
									<?php if (isset($fact->id_client)) {
															$Clients = Client::trouve_client_par_id_client($fact->id_client);
															
															}
															foreach ($Clients as $client){
																
																	if (isset($client->nom)) {
															echo $client->nom;}}?>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								
								<td>
									<?php if (isset($facture->somme_ht)) {
									echo number_format($facture->somme_ht , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->Remise)) {
									echo number_format($facture->Remise , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_tva)) {
									echo number_format($facture->somme_tva , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
									echo number_format($facture->somme_ttc , 2, ',', ' ');
									} ?>
								</td>
                            </tr>
                                <?php
								}
							?>

                            </body>
                   </table>

            <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-blue-ebonyclay"></i>
                        <span class="caption-subject font-blue-ebonyclay bold uppercase">Avoir Vente</span> 
                    </div>
            </div>
                    
			
                    <table class="table table-striped table-bordered " >
							<thead>
							<tr>
								<th >
									#
								</th>
                                <th>
									N°  Facture
								</th>
                                <th>
									Client
								</th>
								<th>
									Date facture
								</th>
								
								<th>
									HT
								</th>
								<th>Remise</th>
								<th>Tva</th>
								<th>Timbre</th>
								<th>TTC</th>
                                </tr>
                            </thead>
                            <body>
                            <?php
								foreach($facturesAvoirVente as $facture){
									
								?>
                                <tr >
								<td>
								<input type="checkbox"  value="<?php echo $facture->id_facture ?>"  name="IdCheckboxAvoirVente" checked="checked"/>
								</td>
                                <td>
								<a href="#" class="">
								
									<b><?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?></b>
									
                                                    </a>
								</td>
                                <td>
								<i class="fa fa-building  font-yellow"></i>
									<?php if (isset($fact->id_client)) {
															$Clients = Client::trouve_client_par_id_client($fact->id_client);
															
															}
															foreach ($Clients as $client){
																
																	if (isset($client->nom)) {
															echo $client->nom;}}?>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								
								<td>
									<?php if (isset($facture->somme_ht)) {
									echo number_format($facture->somme_ht , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->Remise)) {
									echo number_format($facture->Remise , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_tva)) {
									echo number_format($facture->somme_tva , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
									echo number_format($facture->somme_ttc , 2, ',', ' ');
									} ?>
								</td>
                            </tr>
                                <?php
								}
							?>

                            </body>
                   </table>
</div>
	</div>