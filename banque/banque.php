<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa fa-university font-yellow"></i>Liste des Banques 
							</div>
						</div>
						<div class="btn-group">
											
											<a href="societe.php?action=ajouter_banque" class="btn red">Nouveau <i class="fa fa-plus"></i></a>
											
										</div>
				
							
						<div class="portlet-body">
							<table class="table table-striped  table-hover" id="sample_2">
							<thead>
							<tr>
								
								<th>
									Banque
								</th>
								<th>
									Abreviation
								</th>
								
								<th>
									Code 
								</th>
								<th>
									Adresse 
								</th>
								
								<th>
									N° Compte 
								</th>
								<th>
									Tel 
								</th>
							
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
                                $banques = Banque::trouve_tous();
								foreach($banques as $banque){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
								<i class="fa fa-university font-yellow"></i>
									<b><?php if (isset($banque->Designation)) {
									echo $banque->Designation;
									} ?></b>
								</td>
								<td>
									<?php if (isset($banque->abreviation)) {
									echo $banque->abreviation;
									} ?>
								</td>
								<td>
									<?php if (isset($banque->Code)) {
									echo $banque->Code;
									} ?>
								</td>
								<td>
								<i class="fa fa-map-marker font-purple"></i>
									<?php if (isset($banque->Adresse)) {
									echo $banque->Adresse;
									} ?>
									<?php if (isset($banque->Ville)) {
									echo $banque->Ville;
									} ?>
								</td>
								
								</td>
								<td>
									<?php if (isset($banque->NCompte)) {
									echo $banque->NCompte;
									} ?>
								</td>
								<td>
								<i class="fa fa-mobile"></i>
									<?php if (isset($banque->Tel)) {
									echo $banque->Tel;
									} ?>
								</td>
							
								
							
						
								<td>
									
									<a href="societe.php?action=edit_banque&id=<?php echo $banque->id_banque; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i></a>
									
								</td>
							</tr>

							<?php
				}
							?>
						
							</tbody>
							
							</table>
						
						</div>
					</div>
                                          
					
				</div>
			</div>