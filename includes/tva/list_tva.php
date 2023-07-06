<div class="col-md-8">
<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption font-purple bold">
								<i class="icon-share font-purple-sunglo"></i>Liste des TVA 
							</div>
						</div>
					
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="">
							<thead>
							<tr>
								
								<th>
									TVA
								</th>
								
								
								<th>
									taux 
								</th>
								
							
							</tr>
							</thead>
							<tbody>
								<?php
								$tvas = Tva_tab::trouve_tous();
								foreach($tvas as $tva){
									$cpt ++;
								?>
							<tr>
								
								
								<td>
									<b><?php if (isset($tva->Designation)) {
									echo $tva->Designation .' %';
									} ?></b>
								</td>
								
								<td>
									<?php if (isset($tva->taux)) {
									echo $tva->taux;
									} ?>
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