﻿<?php
require_once("../includes/initialiser.php");
if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 $clients = Client::trouve_par_id($id);
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
											Banques 
											</a>
										</li>
										
									</ul>
									
										<div class="tab-content no-space">
										<div class="tab-pane active" id="tab_general">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Nom: </b> <?php if (isset($clients->nom)) {
															echo $clients->nom;
															} ?>
													</p>
													<p>
															<b>Tarif: </b> <?php if (isset($clients->Tarif)) {
															echo $clients->Tarif;
															} ?>
													</p>
														<p>		
																<b> Activite: </b> <?php if (isset($clients->Activite)) {
															echo $clients->Activite;
															} ?>
															</p>
													<p>
															
															<b>Agence: </b> <?php if (isset($clients->Agence)) {
													echo $clients->Agence;
													} ?>
													</p>
</p>
													<p>
													<b>Compte : </b> <?php if (isset($clients->Compte)) {
													echo $clients->Compte ;
													} ?>
													</p>
														</div>
												</div>
											</div>			
										
										<div class="tab-pane " id="tab_meta">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Adresse: </b> <?php if (isset($clients->Adresse)) {
															echo $clients->Adresse;
															} ?>
													</p>
													<p>
															<b>Ville: </b> <?php if (isset($clients->Ville)) {
															echo $clients->Ville;
															} ?>
													</p>
														<p>		
																<b> Postal: </b> <?php if (isset($clients->Postal)) {
															echo $clients->Postal;
															} ?>
															</p>
													<p>
															
															<b>Tel1: </b> <?php if (isset($clients->Tel1)) {
													echo $clients->Tel1;
													} ?>
													<br>
													<b>Tel2: </b> <?php if (isset($clients->Tel2)) {
													echo $clients->Tel2;
													} ?><br>
													<b>Fax: </b> <?php if (isset($clients->Fax)) {
													echo $clients->Fax;
													} ?><br>
													<b>Mob1: </b> <?php if (isset($clients->Mob1)) {
													echo $clients->Mob1;
													} ?><br>
													<b>Mob2: </b> <?php if (isset($clients->Mob2)) {
													echo $clients->Mob2;
													} ?>
													</p>
														</div>
												</div>
											</div>
											<div class="tab-pane " id="tab_images">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Rc: </b> <?php if (isset($clients->Rc)) {
															echo $clients->Rc;
															} ?>
													</p>
													<p>
															<b>Mf : </b> <?php if (isset($clients->Mf )) {
															echo $clients->Mf ;
															} ?>
													</p>
														<p>		
																<b> Ai : </b> <?php if (isset($clients->Ai )) {
															echo $clients->Ai ;
															} ?>
															</p>
													<p>
															
															<b>Nis : </b> <?php if (isset($clients->Nis )) {
													echo $clients->Nis ;
													} ?>
													
													
														</div>
												</div>
											</div>
											<div class="tab-pane " id="tab_reviews">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>
													<b>N° de compte : </b> <?php if (isset($clients->NCompte )) {
													echo $clients->NCompte ;
													} ?>
													</p>
<p>
													<b>Solde : </b> <?php if (isset($clients->Solde)) {
													echo $clients->Solde ;
													} ?>
													</p>
														</div>
												</div>
											</div>											
										</div>
								
									</div>