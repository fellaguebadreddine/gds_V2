<?php if (!empty($facturesDepense)){?>
<div class="col-md-12">
    <div class="portlet light bordered">
    <div class="alert bg-yellow"> <i class="fa fa-dollar"></i>
        <span>Depenses </span>
    </div>

		<div class="portlet-title">
	<div class="caption">
		<i class="icon-settings font-yellow"></i>
		<span class="caption-subject font-yellow bold uppercase">Depenses</span>
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
				<th> HT</th>
				<th>Tva</th>
				<th>Timbre</th>
				<th>TTC</th>
				</tr>
			</thead>
			<body>
			<?php
				foreach($facturesDepense as $facture){
                    
                    
					
					
				?>
				<tr >
				<td>
				<input type="checkbox"  value="<?php echo $facture->id ?>"  name="IdCheckboxDepense" checked="checked"/>
				</td>
				
				<td>
					<?php if (isset($facture->reference)) {
								echo $facture->reference;
						} ?>
							
				</td>
				<td>
				<i class="fa fa-building  font-yellow"></i>
				
                    <?php if (isset($facture->id_fournisseur)) {
                     $fourniss= Fournisseur::trouve_par_id($facture->id_fournisseur);
										echo  $fourniss->nom;
									} ?>
				</td>
				<td>
                <?php if (isset($facture->date_fact)) {
										echo $facture->date_fact;
									} ?>
				</td>
				
				<td>
                <?php if (isset($facture->ht)) {
						echo number_format($facture->ht , 2, ',', ' ');
				} ?>
				</td>
				<td>
				<?php if (isset($facture->tva)) {
					echo number_format($facture->tva , 2, ',', ' ');
				} ?>
				</td>
				<td>
				<?php if (isset($facture->timbre)) {
					echo number_format($facture->timbre , 2, ',', ' ');
				} ?>
				</td>
				<td>
				<?php if (isset($facture->ttc)) {
					echo number_format($facture->ttc , 2, ',', ' ');
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
	<?php } ?>