<!-- BEGIN PAGE VENTE-->

<div class="col-md-12">

        <div class="portlet light bordered">
        <div class="alert bg-green"><i class="fa fa-money"></i>
        <span>Vente </span>
        </div>
		<div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-green-sharp"></i>
                        <span class="caption-subject font-purple bold uppercase">non sélectionné</span> 
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
								foreach($facturesAvant as $fact){
									
								?>
                                <tr >
								<td>
								
								<input type="checkbox"  value="<?php echo $fact->id_facture ?>"  name="IdCheckbox"    />
								</td>
                                <td>
								<a href="#" class="">
								
									<b><?php if (isset($fact->N_facture)) {
										$date = date_parse($fact->date_fac);
									echo sprintf("%04d", $fact->N_facture).'/'.$date['year']; } ?></b>
									
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
									<?php if (isset($fact->date_fac)) {
									echo $fact->date_fac;
									} ?>
								</td>								
								<td>
									<?php if (isset($fact->somme_ht)) {
									echo number_format($fact->somme_ht , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($fact->Remise)) {
									echo number_format($fact->Remise , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($fact->somme_tva)) {
									echo number_format($fact->somme_tva , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($fact->timbre)) {
									echo number_format($fact->timbre , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($fact->somme_ttc)) {
									echo number_format($fact->somme_ttc , 2, ',', ' ');
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
                        <i class="icon-settings font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Autre que espèces</span> 
                    </div>
            </div>
                    
		
                    <table class="table table-striped table-bordered table-hover" >
							<thead>
							<tr>
								<th>
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
								foreach($facturesNonEspese as $facture){
									
								?>
                                <tr >
								<td>
								
								<input type="checkbox"  value="<?php echo $facture->id_facture ?>"  name="IdCheckbox" checked="checked"   />
								
								</td>
                                <td>
								<a >
								
									<b><?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?></b>
									
                                                    </a>
								</td>
                                <td>
								<i class="fa fa-building  font-yellow"></i>
									<?php if (isset($facture->id_client)) {
															$Clients = Client::trouve_client_par_id_client($facture->id_client);
															
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
									<?php if (isset($facture->timbre)) {
									echo number_format($facture->timbre , 2, ',', ' ');
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
				 <?php $totalSommeNonEspese = 0; foreach($facturesNonEspese as $facture){$totalSommeNonEspese += $facture->somme_ht; }  ?>
				
            <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Espèces</span> 
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
								foreach($facturesEspese as $facture){
									
								?>
                                <tr >
								<td>
								<input type="checkbox" value="<?php echo $facture->id_facture ?>"  name="IdCheckbox" checked="checked"    />
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
									<?php if (isset($facture->id_client)) {
															$Clients = Client::trouve_client_par_id_client($facture->id_client);
															
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
									<?php if (isset($facture->timbre)) {
									echo number_format($facture->timbre , 2, ',', ' ');
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
				  
				  <?php $totalSommeEspese = 0; foreach($facturesEspese as $facture){$totalSommeEspese += $facture->somme_ht; }   ?>
            
       
            <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Non payés (A terme)</span>
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
								foreach($facturesAterme as $facture){
									
								?>
                                <tr >
								<td>
								<input type="checkbox" value="<?php echo $facture->id_facture ?>"  name="IdCheckbox" checked="checked"  />
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
									<?php if (isset($facture->id_client)) {
															$Clients = Client::trouve_client_par_id_client($facture->id_client);
															
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
									<?php if (isset($facture->timbre)) {
									echo number_format($facture->timbre , 2, ',', ' ');
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
				   
						
					
				<div class="well">
					<p> Total Vente:<b id="sommeht_vente"> 0.00 </b></p>
				
					</div>									
			
			
        </div>
    
	</div>
	
	<script >
	// onclik checkbox
  $('input').on('click', function(){

       
        var idNonEspese = [];
		

        // Initializing array with Checkbox checked values
		
        $("input[name='IdCheckbox']:checked").each(function(){
            idNonEspese.push(this.value);
			
        });
		


        if("input[name='IdCheckbox']:checked" ) {
            $.ajax({
                url: 'ajax/getData.php',
                type: 'post',
                data: {id_facture:idNonEspese },
                dataType: 'JSON',
                success: function(response){

                    // selecting values from response Object
                   
					 var somme_ht = response.somme_ht;
					 
					
                    // setting values
					
					 $('#sommeht_vente').text(somme_ht);
					 
                }
            });
        }
		
    });
	 </script>
	 

