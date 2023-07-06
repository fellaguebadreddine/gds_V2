<?php if (isset($nav_societe->type )){
		if ($nav_societe->type =='3' or $nav_societe->type =='5'){?>
		<div class="col-md-12">
    <div class="portlet light bordered">
    <div class="alert bg-purple"> <i class="fa fa-file"></i>
        <span>Achat Importation </span>
    </div>

		<div class="portlet-title">
	<div class="caption">
		<i class="icon-settings font-purple"></i>
		<span class="caption-subject font-purple bold uppercase">Achat Importation non selectionner</span>
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
				
				<th>
					Total HT
				</th>
				<th>Tva</th>
				<th>Timbre</th>
				<th>TTC</th>
				</tr>
			</thead>
			<body>
			<?php
				foreach($facturesImportationAvant as $facture){
                    $Fact = Facture_importation::trouve_par_id($facture->id_facture);
                    if (isset($Fact->id_facture)) {
                        $table_frais = Achat_importation::trouve_frais_par_facture($Fact->id_facture);
                    }
                    
					 foreach($table_frais as $table_frais){
					
				?>
				<tr >
				<td>
				<input type="checkbox"  value="<?php echo $table_frais->id ?>"  name="IdCheckboxImportation" checked="checked"/>
				</td>
				
				<td>
					<?php if (isset($table_frais->Num_facture)) {
								echo $table_frais->Num_facture;
						} ?>
							
				</td>
				<td>
				<i class="fa fa-building  font-yellow"></i>
				
                    <?php if (isset($table_frais->Designation)) {
                     $fourniss= Fournisseur::trouve_par_id($table_frais->Designation);
										echo  $fourniss->nom;
									} ?>
				</td>
				<td>
                <?php if (isset($table_frais->date_fact)) {
										echo $table_frais->date_fact;
									} ?>
				</td>
				
				<td>
                <?php if (isset($table_frais->Ht)) {
										echo number_format($table_frais->Ht , 2, ',', ' ');
									} ?>
				</td>
				<td>
                <?php if (isset($table_frais->Tva)) {
					echo number_format($table_frais->Tva , 2, ',', ' ');
				} ?>
				</td>
				<td>
                <?php if (isset($table_frais->timbre)) {
					echo number_format($table_frais->timbre , 2, ',', ' ');
				} ?>
				</td>
				<td>
                <?php if (isset($table_frais->somme_ttc)) {
					echo number_format($table_frais->somme_ttc , 2, ',', ' ');
				} ?>
				</td>
			</tr>
				<?php
				}}
			?>

			</body>
	</table>
	
    </div>
</div>
<div class="col-md-12">
    <div class="portlet light bordered">
    <div class="alert bg-purple"> <i class="fa fa-file"></i>
        <span>Achat Importation </span>
    </div>

		<div class="portlet-title">
	<div class="caption">
		<i class="icon-settings font-purple"></i>
		<span class="caption-subject font-purple bold uppercase">Achat Importation</span>
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
				
				<th>
					Total HT
				</th>
				<th>Tva</th>
				<th>Timbre</th>
				<th>TTC</th>
				</tr>
			</thead>
			<body>
			<?php
				foreach($facturesImportation as $facture){
                    $Fact = Facture_importation::trouve_par_id($facture->id_facture);
                    if (isset($Fact->id_facture)) {
                        $table_frais = Achat_importation::trouve_frais_par_facture($Fact->id_facture);
                    }
                    
					 foreach($table_frais as $table_frais){
					
				?>
				<tr >
				<td>
				<input type="checkbox"  value="<?php echo $table_frais->id ?>"  name="IdCheckboxImportation" checked="checked"/>
				</td>
				
				<td>
					<?php if (isset($table_frais->Num_facture)) {
								echo $table_frais->Num_facture;
						} ?>
							
				</td>
				<td>
				<i class="fa fa-building  font-yellow"></i>
				
                    <?php if (isset($table_frais->Designation)) {
                     $fourniss= Fournisseur::trouve_par_id($table_frais->Designation);
										echo  $fourniss->nom;
									} ?>
				</td>
				<td>
                <?php if (isset($table_frais->date_fact)) {
										echo $table_frais->date_fact;
									} ?>
				</td>
				
				<td>
                <?php if (isset($table_frais->Ht)) {
										echo number_format($table_frais->Ht , 2, ',', ' ');
									} ?>
				</td>
				<td>
                <?php if (isset($table_frais->Tva)) {
					echo number_format($table_frais->Tva , 2, ',', ' ');
				} ?>
				</td>
				<td>
                <?php if (isset($table_frais->timbre)) {
					echo number_format($table_frais->timbre , 2, ',', ' ');
				} ?>
				</td>
				<td>
                <?php if (isset($table_frais->somme_ttc)) {
					echo number_format($table_frais->somme_ttc , 2, ',', ' ');
				} ?>
				</td>
			</tr>
				<?php
				}}
			?>

			</body>
	</table>
	
    </div>
</div>
<?php }}?>	