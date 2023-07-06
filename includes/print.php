<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Accounts::trouve_par_id($session->id_utilisateur);
	if (empty($user)) {
	$user = Client::trouve_par_id($session->id_utilisateur);
	}
	$accestype = array('administrateur','utilisateur');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 
}

?>
<?php
$titre = "ThreeSoft | GDS ";

if ($user->type =='administrateur' or $user->type =='utilisateur'){
	
		$nav_societe = Societe::trouve_par_id($_SESSION['societe']);
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}

?>
<?php if ($user->type == "administrateur"){
		if (isset($_GET['action']) && $_GET['action'] =='print_vente' ) {
			
			$action = 'print_vente';
			$titre = "ThreeSoft | Print Vente ";
		}else if (isset($_GET['action']) && $_GET['action'] =='print_achat' ){
			$action = 'print_achat';
			$titre = "ThreeSoft | Print Achat ";
		}else if (isset($_GET['action']) && $_GET['action'] =='print_impotation' ){
			$action = 'print_impotation';
			$titre = "ThreeSoft | Print Impotation ";
		}else if (isset($_GET['action']) && $_GET['action'] =='print_depense' ){
			$action = 'print_depense';
			$titre = "ThreeSoft | Print Depense ";
		}
	} 
	?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
	 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	    
    <!-- Style -->
    <title><?php echo $titre;?></title>
  </head>
  <body onload="window.print()">
  <div class="container-fluid" >    
    <div class="col-md-12">
	<?php if ($user->type == "administrateur"){
		if ($action == 'print_vente') { 
	?>

      <h2 >Facture vente </h2>
	   <p ><?php if (isset($nav_societe)){echo $nav_societe->Dossier ;}?></br>
	    <?php if (isset($nav_societe)){echo $nav_societe->Adresse .' - '. $nav_societe->Postal.' , ' .$nav_societe->Ville ;}?></br>
		<?php if (isset($nav_societe)){echo $nav_societe->Mob1 ;}?></p>
		<hr>	  
	  <b><?php if (!empty($_GET['date_db'] && $_GET['date_fin']) ) { echo 'Du : ' .$_GET['date_db'].' au ' . $_GET['date_fin'] ; }else { echo 'Du : ' .$nav_societe->exercice_debut.' au ' . $nav_societe->exercice_fin ;}?></b>
	  <?php
		if (!empty($_GET['date_db'] && $_GET['date_fin']) ) {
			$date_db = $_GET['date_db'];
			$date_fin =$_GET['date_fin'];
					 
			$factures = Facture_vente::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

		}else{
			$factures = Facture_vente::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
		}
							
		$cpt = 0; ?>
		<hr>
					<div class="portlet-body">
					
							<table class="table table-striped  table-hover" id="">
							
							<thead>
							<tr>
								
								<th>
									N°  Facture
								</th>
								<th>
									Date 
								</th>
								<th>
									Client
								</th>
								<th>
									HT
								</th>
								<th>
									REMISE
								</th>
								<th>
									TVA
								</th>
								<th>
									TIMBRE
								</th>
								<th>
									 TTC
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr>
								
								
								<td>								
									<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								<td>
								<i class="fa fa-building  font-yellow"></i>
									<?php if (isset($facture->id_client)) {
															$client = Client::trouve_par_id($facture->id_client);
															if (isset($client->nom)) {
															echo $client->nom;}
															}?>
								</td>
								<td>
									<?php 
									if (isset($facture->somme_ht)) {
									$total_somme_ht +=$facture->somme_ht;
									echo number_format($facture->somme_ht , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php 
									if (isset($facture->Remise)) {
									$total_Remise +=$facture->Remise;
									echo number_format($facture->Remise , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php 
									if (isset($facture->somme_tva)) {
										$total_somme_tva +=$facture->somme_tva;
									echo number_format($facture->somme_tva , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php 
									if (isset($facture->timbre)) {
										$total_timbre +=$facture->timbre;
									echo number_format($facture->timbre , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php 
									if (isset($facture->somme_ttc)) {
										$total_somme_ttc +=$facture->somme_ttc;
									echo number_format($facture->somme_ttc , 2, ',', ' ');
									} ?>
								</td>
							</tr>

							<?php
								}
							?>
							
						
							</tbody>
							<tbody>
								<td colspan="2"></td>
								<td > <span style="float : left;   font-size: 18px; ;"><strong> TOTAUX: </strong></span></td>
								<td>  <strong><?php echo number_format($total_somme_ht , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_Remise , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_tva , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_timbre , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_ttc , 2, ',', ' '); ?></strong></td>

							</tbody>
							
							</table>						
							
						</div>
	  <?php } else if ($action == 'print_achat') {?>
		
		<h2 >Facture achat </h2>
	   <p ><?php if (isset($nav_societe)){echo $nav_societe->Dossier ;}?></br>
	    <?php if (isset($nav_societe)){echo $nav_societe->Adresse .' - '. $nav_societe->Postal.' , ' .$nav_societe->Ville ;}?></br>
		<?php if (isset($nav_societe)){echo $nav_societe->Mob1 ;}?></p>
		<hr>	  
	  <b><?php if (!empty($_GET['date_db'] && $_GET['date_fin']) ) { echo 'Du : ' .$_GET['date_db'].' au ' . $_GET['date_fin'] ; }else { echo 'Du : ' .$nav_societe->exercice_debut.' au ' . $nav_societe->exercice_fin ;}?></b>
	  <?php
		if (!empty($_GET['date_db'] && $_GET['date_fin']) ) {
			$date_db = $_GET['date_db'];
			$date_fin =$_GET['date_fin'];
					 
			$factures = Facture_achat::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

		}else{
			$factures = Facture_achat::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
		}
							
		$cpt = 0; ?>
		<hr>
					<div class="portlet-body">
					
					<table class="table table-striped  table-hover" id="sample_2">
							<thead>
							<tr>
								
								<th>
									N°  Facture
								</th>
								<th>
									Date 
								</th>
								<th>
									Fournisseur
								</th>
								<th>
									HT
								</th>
								<th>
									REMISE
								</th>
								<th>
									TVA
								</th>
								<th>
									TIMBRE
								</th>
								<th>
									 TTC
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr id="fact_<?php echo $facture->id_facture; ?>">
								
								
								<td>
								
									<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								
								<td>
								<i class="fa fa-building  font-yellow"></i>
									<?php if (isset($facture->id_fournisseur)) {
															$fournisseur = Fournisseur::trouve_par_id($facture->id_fournisseur);
															 if (isset($fournisseur->nom)) {
																		
															echo $fournisseur->nom;}
															}?>
								</td>
								<td>
									<?php if (isset($facture->somme_ht)) {
									$total_somme_ht +=$facture->somme_ht;
									echo number_format($facture->somme_ht , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->Remise)) {
									$total_Remise +=$facture->Remise;
									echo number_format($facture->Remise , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_tva)) {
										$total_somme_tva +=$facture->somme_tva;
									echo number_format($facture->somme_tva , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->timbre)) {
										$total_timbre +=$facture->timbre;
									echo number_format($facture->timbre , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($facture->somme_ttc)) {
										$total_somme_ttc +=$facture->somme_ttc;
									echo number_format($facture->somme_ttc , 2, ',', ' ');
									} ?>
								</td>
							</tr>

							<?php
								}
							?>
							
							</tbody>
							<tbody>
								<td colspan="2"></td>
								<td > <span style="float : left;   font-size: 18px; ;"><strong> TOTAUX: </strong></span></td>
								<td>  <strong><?php echo number_format($total_somme_ht , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_Remise , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_tva , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_timbre , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_ttc , 2, ',', ' '); ?></strong></td>
							</tbody>
							
							</table>				
							
						</div>
		<?php } else if ($action == 'print_impotation') {?>
		
				<h2 >Facture Impotation </h2>
			<p ><?php if (isset($nav_societe)){echo $nav_societe->Dossier ;}?></br>
				<?php if (isset($nav_societe)){echo $nav_societe->Adresse .' - '. $nav_societe->Postal.' , ' .$nav_societe->Ville ;}?></br>
				<?php if (isset($nav_societe)){echo $nav_societe->Mob1 ;}?></p>
				<hr>	  
			<b><?php if (!empty($_GET['date_db'] && $_GET['date_fin']) ) { echo 'Du : ' .$_GET['date_db'].' au ' . $_GET['date_fin'] ; }else { echo 'Du : ' .$nav_societe->exercice_debut.' au ' . $nav_societe->exercice_fin ;}?></b>
			<?php
				if (!empty($_GET['date_db'] && $_GET['date_fin']) ) {
					$date_db = $_GET['date_db'];
					$date_fin =$_GET['date_fin'];
							
					$factures = Facture_importation::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				}else{
					$factures = Facture_importation::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}
									
				$cpt = 0; ?>
				<hr>
					<div class="portlet-body">
					
					<table class="table table-striped  table-hover" id="sample_2">
							<thead>
							<tr>
								
								<th>
									N°  Facture
								</th>
								<th>
									Date facture
								</th>
								<th>
									Fournisseur
								</th>
								<th>
									Total TTC
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($factures as $facture){
									$cpt ++;
								?>
							<tr>
								<td>
								<?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
								<td>
								<i class="fa fa-building  font-yellow"></i>
									<?php if (isset($facture->id_fournisseur)) {
															$Fournisseurs = Fournisseur::trouve_fournisseur_par_id_fournisseur($facture->id_fournisseur);
															
															}
															foreach ($Fournisseurs as $fournisseur){
																
																	if (isset($fournisseur->nom)) {
																		
															echo $fournisseur->nom;}}?>
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
							
							</tbody>
							
							</table>				
							
						</div>			
						
		<?php } else if ($action == 'print_depense') {?>
		
				<h2 >Facture Depense </h2>
			<p ><?php if (isset($nav_societe)){echo $nav_societe->Dossier ;}?></br>
				<?php if (isset($nav_societe)){echo $nav_societe->Adresse .' - '. $nav_societe->Postal.' , ' .$nav_societe->Ville ;}?></br>
				<?php if (isset($nav_societe)){echo $nav_societe->Mob1 ;}?></p>
				<hr>	  
			<b><?php if (!empty($_GET['date_db'] && $_GET['date_fin']) ) { echo 'Du : ' .$_GET['date_db'].' au ' . $_GET['date_fin'] ; }else { echo 'Du : ' .$nav_societe->exercice_debut.' au ' . $nav_societe->exercice_fin ;}?></b>
			<?php
				if (!empty($_GET['date_db'] && $_GET['date_fin']) ) {
					$date_db = $_GET['date_db'];
					$date_fin =$_GET['date_fin'];
							
					$list_depenses = Facture_depense::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				}else{
					$list_depenses = Facture_depense::trouve_facture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}
									
				$cpt = 0; ?>
				<hr>
			<div class="portlet-body">
			
			<table class="table table-striped  table-hover " id="sample_2" >
							<thead>
							<tr>
								<th>
									Réf 
								</th>
								<th>
									Date 
								</th>
								<th>
									Dépense 
								</th>
								<th>
									Fournisseur 
								</th>
								<th>
									HT 
								</th>
								<th>
									TVA 
								</th>
								<th>
									timbre 
								</th>
								<th>
									TTC 
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($list_depenses as $list_depense){
									
								?>
							<tr id="fact_<?php echo $list_depense->id; ?>">
								<td>
									<?php if (isset($list_depense->reference)) {
										echo $list_depense->reference ;
									 } ?>
								</td>
								<td>
									<?php if (isset($list_depense->date_fact)) {
									echo $list_depense->date_fact;
									} ?>
								</td>
								<td>
									<?php if (isset($list_depense->id_depense)) {
										$depenses = Depense::trouve_par_id($list_depense->id_depense);
									echo '<i class="fa fa-dollar font-yellow"></i> ' . $depenses->depense;
									} ?>
								</td>
								<td>
									<?php if (isset($list_depense->id_fournisseur)) {
										$fournisseur = Fournisseur::trouve_par_id($list_depense->id_fournisseur);
									echo '<i class="fa fa-user font-yellow"></i> ' . $fournisseur ->nom;
									} ?>
								</td>								
								<td>
								<?php if (isset($list_depense->ht)) {
									$total_somme_ht +=$list_depense->ht;
									echo $list_depense->ht;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->tva)) {
									$total_somme_tva +=$list_depense->tva;
									echo $list_depense->tva;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->timbre)) {
									$total_timbre +=$list_depense->timbre;
									echo $list_depense->timbre;
									} ?>
								</td>
								<td>
								<?php if (isset($list_depense->ttc)) {
									$total_somme_ttc +=$list_depense->timbre;
									echo $list_depense->ttc;
									} ?>
								</td>
							</tr>
							<?php
								}
							?>
							
						
							</tbody>
							<tbody>
								<td colspan="3"></td>
								<td > <span style="float : left;   font-size: 18px; ;"><strong> TOTAUX: </strong></span></td>
								<td>  <strong><?php echo number_format($total_somme_ht , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_tva , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_timbre , 2, ',', ' '); ?></strong></td>
								<td> <strong><?php echo number_format($total_somme_ttc , 2, ',', ' '); ?></strong></td>
							
							</table>
					
				</div>	
	  <?php }}?>
		
		
    </div>

  </div>

  </body >
</html>
	