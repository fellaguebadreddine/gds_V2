<?php
require_once("../includes/initialiser.php");
if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 $fournisseurs = Fournisseur::trouve_par_id($id);
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
														<p>	<b>Nom de fournisseur: </b> <?php if (isset($fournisseurs->nom)) {
															echo $fournisseurs->nom;
															} ?>
													</p>
													<p>
															<b>Tarif: </b> <?php if (isset($fournisseurs->Tarif)) {
															echo $fournisseurs->Tarif;
															} ?>
													</p>
														<p>		
																<b> Activite: </b> <?php if (isset($fournisseurs->Activite)) {
															echo $fournisseurs->Activite;
															} ?>
															</p>
													<p>
															
															<b>Agence: </b> <?php if (isset($fournisseurs->Agence)) {
													echo $fournisseurs->Agence;
													} ?>
													</p>
<p>
													<b>Compte : </b> <?php if (isset($fournisseurs->Compte )) {
													echo $fournisseurs->Compte ;
													} ?>
													</p>
														</div>
												</div>
											</div>			
										
										<div class="tab-pane " id="tab_meta">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Adresse: </b> <?php if (isset($fournisseurs->Adresse)) {
															echo $fournisseurs->Adresse;
															} ?>
													</p>
													<p>
															<b>Ville: </b> <?php if (isset($fournisseurs->Ville)) {
															echo $fournisseurs->Ville;
															} ?>
													</p>
														<p>		
																<b> Postal: </b> <?php if (isset($fournisseurs->Postal)) {
															echo $fournisseurs->Postal;
															} ?>
															</p>
													<p>
															
															<b>Tel1: </b> <?php if (isset($fournisseurs->Tel1)) {
													echo $fournisseurs->Tel1;
													} ?>
													<br>
													<b>Tel2: </b> <?php if (isset($fournisseurs->Tel2)) {
													echo $fournisseurs->Tel2;
													} ?><br>
													<b>Fax: </b> <?php if (isset($fournisseurs->Fax)) {
													echo $fournisseurs->Fax;
													} ?><br>
													<b>Mob1: </b> <?php if (isset($fournisseurs->Mob1)) {
													echo $fournisseurs->Mob1;
													} ?><br>
													<b>Mob2: </b> <?php if (isset($fournisseurs->Mob2)) {
													echo $fournisseurs->Mob2;
													} ?>
													</p>
														</div>
												</div>
											</div>
											<div class="tab-pane " id="tab_images">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>	<b>Rc: </b> <?php if (isset($fournisseurs->Rc)) {
															echo $fournisseurs->Rc;
															} ?>
													</p>
													<p>
															<b>Mf : </b> <?php if (isset($fournisseurs->Mf )) {
															echo $fournisseurs->Mf ;
															} ?>
													</p>
														<p>		
																<b> Ai : </b> <?php if (isset($fournisseurs->Ai )) {
															echo $fournisseurs->Ai ;
															} ?>
															</p>
													<p>
															
															<b>Nis : </b> <?php if (isset($fournisseurs->Nis )) {
													echo $fournisseurs->Nis ;
													} ?>
													</p>
													
													
													
														</div>
												</div>
											</div>
											<div class="tab-pane " id="tab_reviews">
												<div class="row static-info">
													<div class="col-md-8 name">
														<p>
													<b>N° de compte : </b> <?php if (isset($fournisseurs->NCompte )) {
													echo $fournisseurs->NCompte ;
													} ?>
													</p>
<p>
													<b>Solde : </b> <?php if (isset($fournisseurs->Solde )) {
													echo $fournisseurs->Solde ;
													} ?>
													</p>
														</div>
												</div>
											</div>											
										</div>
								
									</div>