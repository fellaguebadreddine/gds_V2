<?php
require_once("../includes/initialiser.php");
if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 $entrp = Societe::trouve_par_id($id);
}else{
        echo 'Content not found....';
}


?>

								<div class="tabbable">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#tab_general" data-toggle="tab">
											General </a>
										</li>
										<li>
											<a href="#tab_meta" data-toggle="tab">
											Adresse & contact </a>
										</li>
										<li>
											<a href="#tab_images" data-toggle="tab">
											info commercial </a>
										</li>
										<li>
											<a href="#tab_reviews" data-toggle="tab">
											Banques & caisse 
											</a>
										</li>
										
									</ul>
									
										<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_general">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Nom de dossier: </b> <?php if (isset($entrp->Dossier)) {
															echo $entrp->Dossier;
															} ?>
													</p>
													<p>
															<b>Raison: </b> <?php if (isset($entrp->Raison)) {
															echo $entrp->Raison;
															} ?>
													</p>
														<p>		
																<b> Activite: </b> <?php if (isset($entrp->Activite)) {
															echo $entrp->Activite;
															} ?>
															</p>
													<p>
															
															<b>Agence: </b> <?php if (isset($entrp->Agence)) {
													echo $entrp->Agence;
													} ?>
													</p>
														</div>
												</div>
											</div>			
										
										<div class="tab-pane " id="tab_meta">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Adresse: </b> <?php if (isset($entrp->Adresse)) {
															echo $entrp->Adresse;
															} ?>
													</p>
													<p>
															<b>Ville: </b> <?php if (isset($entrp->Ville)) {
															echo $entrp->Ville;
															} ?>
													</p>
														<p>		
																<b> Postal: </b> <?php if (isset($entrp->Postal)) {
															echo $entrp->Postal;
															} ?>
															</p>
													<p>
															
															<b>Tel1: </b> <?php if (isset($entrp->Tel1)) {
													echo $entrp->Tel1;
													} ?>
													<br>
													<b>Tel2: </b> <?php if (isset($entrp->Tel2)) {
													echo $entrp->Tel2;
													} ?><br>
													<b>Fax: </b> <?php if (isset($entrp->Fax)) {
													echo $entrp->Fax;
													} ?><br>
													<b>Mob1: </b> <?php if (isset($entrp->Mob1)) {
													echo $entrp->Mob1;
													} ?><br>
													<b>Mob2: </b> <?php if (isset($entrp->Mob2)) {
													echo $entrp->Mob2;
													} ?>
													</p>
														</div>
												</div>
											</div>
											<div class="tab-pane " id="tab_images">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Rc: </b> <?php if (isset($entrp->Rc)) {
															echo $entrp->Rc;
															} ?>
													</p>
													<p>
															<b>Mf : </b> <?php if (isset($entrp->Mf )) {
															echo $entrp->Mf ;
															} ?>
													</p>
														<p>		
																<b> Ai : </b> <?php if (isset($entrp->Ai )) {
															echo $entrp->Ai ;
															} ?>
															</p>
													<p>
															
															<b>Nis : </b> <?php if (isset($entrp->Nis )) {
													echo $entrp->Nis ;
													} ?>
													</p>
													<p>
													<b>Capital : </b> <?php if (isset($entrp->Capital )) {
													echo $entrp->Capital ;
													} ?>
													</p>
													<p>
													<b>Date : </b> <?php if (isset($entrp->Annee )) {
													echo $entrp->Annee ;
													} ?>
													</p>
														</div>
												</div>
											</div>
											<div class="tab-pane " id="tab_reviews">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Banque: </b> </p><?php if (isset($entrp->id_societe)) {
																$banques = Banque::trouve_par_societe($entrp->id_societe);
																$Comptes = Compte::trouve_compte_par_societe($entrp->id_societe);
																
																?>
							
																<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_2">
																<thead>
																<tr>
																	
																	<th>
																		banque
																	</th>
																	
																</tr>
																</thead>
																<tbody>
																	<?php
																	foreach ($banques as $banque){
																	
																	?>
																<tr>
																
																	<td>
																	<?php
																	if (isset($banque->Designation)) {
																	echo $banque->Designation;}?>
																	-
																	<?php
																	if (isset($banque->Code)) {
																	echo $banque->Code;}
																	
																	 ?>
																	
																	
																	
																
																	</td>
																	
										
																	
																	</tr>
														<?php }}?>
																</tbody>
																
																</table>
																<?php if (isset($entrp->id_societe)) {
															
															$caisses=Caisse::trouve_caisse_par_societe($entrp->id_societe);
																		 
																
																$Caisse_societes = Caisse_societe ::trouve_caisse_par_societe($entrp->id_societe);
																$cpt1 = 0;
															
																														
																?>
																<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_2">
																<thead>
																<tr>
																	
																	<th>
																		caisse
																	</th>
																	<th>
																		N° de caisse
																	</th>
																</tr>
																</thead>
																<tbody>
																	<?php
																	foreach ($caisses as $caisse){
																	?>
																<tr>
																	<td>
																	<?php
																	if (isset($caisse->Designation)) {
																	echo $caisse->Designation;}?>
																	-
																	
																
																	</td>
																	<td>
																	
																	</td>
																</tr>
																<?php
																}}
																	?>
																</tbody>
																
																</table>
														</div>
												</div>
											</div>											
										</div>
								
									</div>