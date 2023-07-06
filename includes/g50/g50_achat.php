<!-- BEGIN PAGE ACHAT-->
	

<div class="col-md-12">


        <div class="portlet light bordered">
        <div class="alert bg-red"> <i class="fa fa-shopping-cart"></i>
        <span>Achat </span>
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
								Fournisseur
								</th>
								<th>
									Date facture
								</th>
								
								<th>HT</th>
								<th>Remise</th>
								<th>Tva</th>
								<th>Timbre</th>
								<th>TTC</th>
                                </tr>
                            </thead>
                            <body>
                            <?php
								foreach($facturesAchatAvant as $facture){
									
								?>
                                <tr >
								<td>
								
								<input type="checkbox" name="IdCheckboxachat" value="<?php echo $facture->id_facture ?>" />
								
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
									<?php if (isset($facture->id_fournisseur)) {
															$Fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($Fournisseurs as $Fournisseur){
																
																	if (isset($Fournisseur->nom)) {
															echo $Fournisseur->nom;}}?>
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

            <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red bold uppercase">Autre que Espèces</span> 
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
                                     Fournisseur
								</th>
								<th>
									Date facture
								</th>
								<th>HT</th>
								<th>Remise</th>
								<th>Tva</th>
								<th>Timbre</th>
								<th>TTC</th>
                                </tr>
                            </thead>
                            <body>
                            <?php
								foreach($facturesAchatNonEspese as $facture){
									
								?>
                                <tr >
								<td>
								<input type="checkbox"  value="<?php echo $facture->id_facture ?>"  name="IdCheckboxachat" checked="checked"/>
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
									<?php if (isset($facture->id_fournisseur)) {
															$Fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($Fournisseurs as $Fournisseur){
																
																	if (isset($Fournisseur->nom)) {
															echo $Fournisseur->nom;}}?>
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
				 
					

            <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red bold uppercase">Espèces</span> 
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
                                Fournisseur
								</th>
								<th>
									Date facture
								</th>
								<th>HT</th>
								<th>Remise</th>
								<th>Tva</th>
								<th>Timbre</th>
								<th>TTC</th>
                                </tr>
                            </thead>
                            <body>
                            <?php
								foreach($facturesAchatEspese as $facture){
									
								?>
                                <tr >
								<td>
								<input type="checkbox"  value="<?php echo $facture->id_facture ?>"  name="IdCheckboxachat" checked="checked"/>
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
									<?php if (isset($facture->id_fournisseur)) {
															$Fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($Fournisseurs as $Fournisseur){
																
																	if (isset($Fournisseur->nom)) {
															echo $Fournisseur->nom;}}?>
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
			
        
            <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red bold uppercase">Non payés (A terme)</span>
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
                                Fournisseur
								</th>
								<th>
									Date facture
								</th>
								<th>HT</th>
								<th>Remise</th>
								<th>Tva</th>
								<th>Timbre</th>
								<th>TTC</th>
                                </tr>
                            </thead>
                            <body>
                            <?php
								foreach($facturesAchatAterme as $facture){
									
								?>
                                <tr >
								<td>
								<input type="checkbox"  value="<?php echo $facture->id_facture ?>"  name="" checked="checked"/>
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
									<?php if (isset($facture->id_fournisseur)) {
															$Fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($Fournisseurs as $Fournisseur){
																
																	if (isset($Fournisseur->nom)) {
															echo $Fournisseur->nom;}}?>
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
	
			<div  class="well " >
   			   <p>Total Achat:
               <b id="sommeht_achat"> 0.00 </b></p>			   
               
			</div>
        </div>
    

	</div>
	
	<script >
	// onclik checkbox
  $('input').on('click', function(){

        
        var idAchat = [];
		

        // Initializing array with Checkbox checked values
        $("input[name='IdCheckboxachat']:checked").each(function(){
            idAchat.push(this.value);
			
        });
		

        if("input[name='IdCheckboxachat']:checked" ){
            $.ajax({
                url: 'ajax/getDataAchat.php',
                type: 'post',
                data: {id_facture:idAchat },
                dataType: 'JSON',
                success: function(response){

                   

                    // selecting values from response Object
                   
					 var somme_ht_achat = response.somme_ht_achat;
					 

                    // setting values
                    
					 $('#sommeht_achat').html(somme_ht_achat);
					
                }
            });
        }
    });
	 </script>
