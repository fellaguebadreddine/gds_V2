<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Accounts::trouve_par_id($session->id_utilisateur);
	if (empty($user)) {
	$user = Fournisseur::trouve_par_id($session->id_utilisateur);
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
$titre = "ThreeSoft | Fournisseur ";
$active_menu = "Facturation";
$active_submenu = "list_fournisseur";
$header = array('image');
$footers = array('validation');
if ($user->type == "administrateur"){
	if (isset($_GET['action']) && $_GET['action'] =='add_fournisseur' ) {
$action = 'add_fournisseur';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_fournisseur' ) {
$action = 'list_fournisseur';}
else if (isset($_GET['action']) && $_GET['action'] =='affiche_fournisseur' ) {
$action = 'affiche_fournisseur';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$action = 'edit';
 if (isset($_POST['id'])|| !empty($_POST['id'])){
	       $id = intval($_POST['id']);
			$editFournisseur = Fournisseur::trouve_par_id($id);
        }elseif (isset($_GET['id'])|| !empty($_GET['id'])){
	       $id = intval($_GET['id']);
		   $editFournisseur = Fournisseur::trouve_par_id($id);
        }
}
else if (isset($_GET['action']) && $_GET['action'] =='open' ) {
$action = 'open';}
else if (isset($_GET['action']) && $_GET['action'] =='close_societe' ) {
$action = 'close_societe';}
if($action == 'open' ){
	$errors = array();
	// verification de données 	
        if (isset($_POST['id'])|| !empty($_POST['id'])){
	       $id = intval($_POST['id']);
			$nsociete = Fournisseur::trouve_par_id($id);
        }elseif (isset($_GET['id'])|| !empty($_GET['id'])){
	       $id = intval($_GET['id']);
		   $nsociete = Fournisseur::trouve_par_id($id);
        }
 	if ($nsociete){
   		// perform Update
	$session->set_societe($nsociete->id_societe);
	readresser_a("index.php");
	}
}
if ($action=='close_societe') {
$session->delete_societe();
readresser_a("index.php");
 } // End of the main Submit conditional.
}
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
?>
<?php

if(isset($_POST['submit']) && $action == 'add_fournisseur'){
	$errors = array();
		// new object fournisseur
	
	// new object admin fournisseur
	
	$fournisseur = new Fournisseur();
	
	$fournisseur->type = htmlentities(trim($_POST['type']));
	$fournisseur->nom = htmlentities(trim($_POST['nom']));
	$fournisseur->Adresse = htmlentities(trim($_POST['Adresse']));
	$fournisseur->Ville = htmlentities(trim($_POST['Ville']));
	$fournisseur->Postal = htmlentities(trim($_POST['Postal']));
	$fournisseur->type_rc = htmlentities(trim($_POST['type_rc']));
	$fournisseur->Rc = htmlentities(trim($_POST['Rc']));
	$fournisseur->Mf = htmlentities(trim($_POST['Mf']));
	$fournisseur->Ai = htmlentities(trim($_POST['Ai']));
	$fournisseur->Nis = htmlentities(trim($_POST['Nis']));
	$fournisseur->Tel1 = htmlentities(trim($_POST['Tel1']));	
	
	$fournisseur->Mob1 = htmlentities(trim($_POST['Mob1']));	
	$fournisseur->Email = htmlentities(trim($_POST['Email']));
	
	$fournisseur->Activite = htmlentities(trim($_POST['Activite']));
	$fournisseur->Compte = htmlentities(trim($_POST['Compte']));
	$fournisseur->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	
	$fournisseur->Solde = htmlentities(trim($_POST['Solde']));
	
	$fournisseur->NCompte = htmlentities(trim($_POST['NCompte']));
	$fournisseur->Etat = 1;
	$fournisseur->id_societe = $nav_societe->id_societe;

	if(!empty($_POST['facture_scan'])){
		$fournisseur->scan_fiche_fournisseur = htmlentities(trim($_POST['facture_scan']));
		}
	// new object admin client
		
				

	if (empty($errors)){
		if ($fournisseur->existe()) {
			$msg_error = '<p >  fournisseur    : ' . $fournisseur->Rc	 . ' existe déja !!!</p><br />';
				
			} else{
				
				$fournisseur->save();
				if (!empty($_POST['facture_scan'])){
					$upload = Upload:: trouve_par_id($_POST['facture_scan']);
					$upload->status = 1;
					$upload->save();
					}
				$msg_positif = '<p ">        fournisseur est bien ajouter  </p><br />';
	/*		
			$client = new Client();
				
	$client->nom = htmlentities(trim($_POST['nom']));
	$client->Adresse = htmlentities(trim($_POST['Adresse']));
	$client->Ville = htmlentities(trim($_POST['Ville']));
	$client->Postal = htmlentities(trim($_POST['Postal']));
	$client->Rc = htmlentities(trim($_POST['Rc']));
	$client->Mf = htmlentities(trim($_POST['Mf']));
	$client->Ai = htmlentities(trim($_POST['Ai']));
	$client->Nis = htmlentities(trim($_POST['Nis']));
	$client->Tel1 = htmlentities(trim($_POST['Tel1']));
	$client->Tel2 = htmlentities(trim($_POST['Tel2']));
	$client->Fax = htmlentities(trim($_POST['Fax']));
	$client->Mob1 = htmlentities(trim($_POST['Mob1']));
	$client->Mob2 = htmlentities(trim($_POST['Mob2']));
	$client->Email = htmlentities(trim($_POST['Email']));
	$client->Web = htmlentities(trim($_POST['Web']));
	$client->Activite = htmlentities(trim($_POST['Activite']));
	$client->Compte = htmlentities(trim($_POST['Compte']));
	$client->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));
	$client->Agence = htmlentities(trim($_POST['Agence']));
	$client->Solde = htmlentities(trim($_POST['Solde']));
	$client->Du = htmlentities(trim($_POST['Du']));
	$client->NCompte = htmlentities(trim($_POST['NCompte']));
	$client->Etat = 1;
	$client->id_societe = $nav_societe->id_societe;
	
		if($client->save()) {
		
		} 
		*/
				 
			}
			
		

 		}else{
		// errors occurred
		$msg_error = '<h1> !! erreur </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}
	if($action == 'edit' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$editFournisseur = Fournisseur:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$editFournisseur = Fournisseur:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object societe
	
	// new object admin societe
	$editFournisseur->type = htmlentities(trim($_POST['type']));
	$editFournisseur->nom = htmlentities(trim($_POST['nom']));
	$editFournisseur->Adresse = htmlentities(trim($_POST['Adresse']));
	$editFournisseur->Ville = htmlentities(trim($_POST['Ville']));
	$editFournisseur->Postal = htmlentities(trim($_POST['Postal']));
	$editFournisseur->type_rc = htmlentities(trim($_POST['type_rc']));
	$editFournisseur->Rc = htmlentities(trim($_POST['Rc']));
	$editFournisseur->Mf = htmlentities(trim($_POST['Mf']));
	$editFournisseur->Ai = htmlentities(trim($_POST['Ai']));
	$editFournisseur->Nis = htmlentities(trim($_POST['Nis']));
	$editFournisseur->Tel1 = htmlentities(trim($_POST['Tel1']));
	
	$editFournisseur->Fax = htmlentities(trim($_POST['Fax']));
	$editFournisseur->Mob1 = htmlentities(trim($_POST['Mob1']));
	
	$editFournisseur->Email = htmlentities(trim($_POST['Email']));
	
	$editFournisseur->Activite = htmlentities(trim($_POST['Activite']));
	$editFournisseur->Compte = htmlentities(trim($_POST['Compte']));
	$editFournisseur->auxiliere_achat = htmlentities(trim($_POST['auxiliere_achat']));

	$editFournisseur->Solde = htmlentities(trim($_POST['Solde']));
	
	$editFournisseur->NCompte = htmlentities(trim($_POST['NCompte']));
	$editFournisseur->Etat = htmlentities(trim($_POST['Etat']));

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($editFournisseur->save()){
		$msg_positif .= '<p >  Le fournisseur ' . html_entity_decode($editFournisseur->Rc) . '  est modifié  avec succes </p><br />';	
														
		}else{
		$msg_system .= "<h1>Une erreur dans le programme ! </h1>
                   <p  >  S'il vous plaît modifier à nouveau !!</p>";
		}
 		
 		}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
		}
}		
	}
	$thisday=date('Y-m-d');
?>
<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="container-fluid">
			<!-- BEGIN PAGE CONTENT-->
			
			<!-- BEGIN PAGE HEADER-->
			
			<div class="page-bar">
				<ul class="page-breadcrumb  breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Fournisseur</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_fournisseur') { ?>
                        <a href="#"><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?></a> 
                        
                        
                    <?php }elseif ($action == 'list_fournisseur') {
                        echo '<a href="fournisseur.php?action=list_fournisseur">Liste des fournisseur</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="fournisseur.php?action=edit_fournisseur">Modifier fournisseur</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
				if ($action == 'list_fournisseur') {
				
				?>
				<div class="row">
				<div class="col-md-12">
				
				<div class="notification"></div>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$Fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-building font-blue-hoki"></i>Liste des fournisseurs <span class="caption-helper">(<?php 	 $Nfournisseur = count($table_ch = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe));
															echo  $Nfournisseur ;  ?> )</span>
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											
											
											
										</div>
									</div>
									<div class="col-md-6">
										<div class="btn-group pull-right">
											
											<a  href="fournisseur.php?action=add_fournisseur" class="btn btn-sm bg-red"  title="Nouveau Fournisseur"><i class="icon-user-follow "></i> Nouveau Fournisseur </a>
										</div>
									</div>
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped  table-hover" id="sample_2">
							<thead>
							<tr>
								
								<th>
									Fournisseurs
								</th>
								
								<th>
									Type 
								</th>
								<th>
									Activite 
								</th>
								<th>
									Scan fiche client 
								</th>
								<th>
									# 
								</th>
								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($Fournisseurs as $Fournisseur){
									$cpt ++;
								?>
							<tr class="item-row">
								
								<td>
								
								<?php if (isset($Fournisseur->nom)) {
									echo '<i class="fa  fa-building font-yellow "></i> ';
									} ?>
									<a  href="fournisseur.php?action=affiche_fournisseur&id=<?php echo $Fournisseur->id_fournisseur; ?>" class=""> <?php if (isset($Fournisseur->nom)) {
									echo  $Fournisseur->nom;
									} ?></a>
								</td>
								
								<td>
								<?php if (isset($Fournisseur->type   )) {
									switch ($Fournisseur->type) {
									  case "1":
										echo "Fournisseur de produit";
										break;
									  case "2":
										echo "Fournisseur de service";
										break;
									  case "3":
										echo "Fournisseur Etranger";
									break;}
											
									
									} ?>
									
								</td>
								<td>
								<?php if (isset($Fournisseur->Activite   )) {
									echo $Fournisseur->Activite   ;
									} ?>
									
								</td>
								<td>
									<?php if (!empty($Fournisseur->scan_fiche_fournisseur)) {
										 $file = str_replace (" ", "_", $nav_societe->Dossier );
										 $ScanImage = Upload::trouve_par_id($Fournisseur->scan_fiche_fournisseur);
									echo '<a href="scan/upload/'.$file.'/'.$ScanImage->img .'" class="btn bg-green-jungle fancybox-button btn-xs " ><i class="fa fa-eye"></i></a>';
									
									} ?>
									
								</td>
								
								<td class="fournisseur_<?php if (isset($Fournisseur->id_fournisseur)) {echo $Fournisseur->id_fournisseur;} ?>">
								
								<button  id="delete_fournisseur" value="<?php if (isset($Fournisseur->id_fournisseur)) {echo $Fournisseur->id_fournisseur;} ?>" class="btn red btn-xs"> <i class="fa fa-trash"></i> </button>
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
					<!--BEGIN AFFICHE SOCIETE-->
					<?php  

				}elseif ($action == 'affiche_fournisseur') {		
				  ?>
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

					if (isset($_GET['id'])) {
					 $id =  htmlspecialchars(intval($_GET['id'])) ;
					 $fournisseur = Fournisseur::trouve_par_id($id);
					}else{
							echo 'Content not found....';
					}
				$cpt = 0; ?>
				<div class="notification"></div>
							<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-building font-yellow"></i>Fournisseur
							</div>
							</div>
							<div class="portlet-title">
							<!--BEGIEN REFLX-->
							<div class="clearfix">
							<div class="pull-right">
							<?php if ($fournisseur->Etat == '1') { ?>
                                    <span class="btn btn-sm bg-green-jungle" title="Client ouvert">
									Active </span> 
                                  <?php } else {  ?> 
                                    <span class="btn btn-sm btn-danger">
									Désactive </span> 
                                <?php    } ?>
												   
												   </div>
                                        <ul class="media-list">
                                            <li class="media">
                                                <a class="pull-left" href="javascript:;">

                                                    <img class="media-object" src="assets/image/avatar.png" alt="bank"   > </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><b> <?php if (isset($fournisseur->nom)) {
															echo $fournisseur->nom;
															} ?></b></h4>
                                                    <ul class="list-unstyled" style="">
													<li>
														<?php if (isset($fournisseur->Agence)) {
													echo $fournisseur->Agence;
													} ?>
														
														</li>
													<li>
														<?php if (isset($fournisseur->Adresse)) {
															echo '<i class="fa fa-map-marker font-red"></i>'. $fournisseur->Adresse;
															} ?>
															<?php if (isset($fournisseur->Postal)) {
															echo $fournisseur->Postal;
															} ?>
															- 
														<?php if (isset($fournisseur->Ville)) {
															echo $fournisseur->Ville;
															} ?>
															
													</li>
													<li>
														<?php if (isset($fournisseur->Mob1)) {
															echo '<i class="fa fa-mobile font-plue"></i>'. $fournisseur->Mob1;
															} ?>
															
													</li>
													<li>
														<?php if (isset($fournisseur->Email)) {
															echo '<i class="fa fa-at font-purple bold"></i>'. $fournisseur->Email;
															} ?>
															
															
													</li>
														
													</ul>
                                                    <!-- Nested media object -->
                                                
                                                    <!-- Nested media object -->
                                                   
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
									<!--END REFLEX-->
						</div>

							
						<div class="portlet-body">
						<div class="row ">
						<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table  table-hover ">
                                          
							<tbody>
							<tr>
								<td><b>Type :</b></td>
								<td>
								<?php if (isset($fournisseur->type   )) {
									switch ($fournisseur->type) {
									  case "1":
										echo "Fournisseur de produit";
										break;
									  case "2":
										echo "Fournisseur de service";
										break;
									  case "3":
										echo "Fournisseur Etranger";
									break;}
											
									
									} ?>
								</td>
							</tr>
							<tr>
								

								<td>
								<b>Nom: </b> 
								</td>
								
								<td>
								<?php if (isset($fournisseur->nom)) {
											echo $fournisseur->nom ;
										} ?>
										
								</td>
							
							</tr>
							<tr>

							</tr>
							<tr>

								<td>
								<b> Activite: </b> 
															
								</td>
								
								<td>
								<?php if (isset($fournisseur->Activite)) {
															echo $fournisseur->Activite;
															} ?>
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Agence: </b> 	
								</td>
								
								<td>
								<?php if (isset($fournisseur->Agence)) {
													echo $fournisseur->Agence;
													} ?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Compte : </b>  	
								</td>
								
								<td>
								
								<?php if (!empty($fournisseur->Compte)) {
															$Comptes = Compte_comptable::trouve_par_id($fournisseur->Compte);
															
															}else{echo '';}
															
																
																	if (isset($Comptes->code)) {
															echo  $Comptes->code  ;}?>	
									|						
									<?php if (!empty($fournisseur->auxiliere_achat)) {
															$auxilieres = Auxiliere::trouve_par_id($fournisseur->auxiliere_achat);
															
															}else{echo '';}
															
																
																	if (isset($auxilieres->code)) {
															echo  $auxilieres->code ;}?>																		
													
								</td>
							
							</tr>
							
							<tr>
								<td>
									
								</td>
								
								<td>
								
													
								</td>
							
							</tr>
						
							</tbody>
                                        </table>
                                    </div>
							
							<!-- END PORTLET-->
					
						</div>
						
						<div class="col-md-6 ">
							<!-- BEGIN PORTLET-->
							
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table  table-hover ">
                                          
							<tbody>
								
							<tr>

								<td>
								<b>Rc: </b> 
								</td>
								
								<td>
								<?php if (isset($fournisseur->Rc)) {
															echo $fournisseur->Rc;
															} ?>
								</td>
							
							</tr>
							<tr>

								<td>
								<b>Mf: </b>  
								</td>
								
								<td>
								<?php if (isset($fournisseur->Mf)) {
															echo $fournisseur->Mf;
															} ?> 
								</td>
							
							</tr>
							<tr>

								<td>
								<b> Ai: </b> 
															
								</td>
								
								<td>
								<?php if (isset($fournisseur->Ai)) {
															echo $fournisseur->Ai;
															} ?>
								</td>
							
							</tr>
							<tr>
								<td>
								<b>Nis: </b> 	
								</td>
								
								<td>
								<?php if (isset($fournisseur->Nis)) {
													echo $fournisseur->Nis;
													} ?>
													
								</td>
							
							</tr>
							<tr>
								<td>
								<b>N° Compte : </b>  	
								</td>
								
								<td>
								<?php if (isset($fournisseur->NCompte)) {
													echo $fournisseur->NCompte ;
													} ?>
													
								</td>
							
							</tr>
							
							<tr>
								<td>
								
								</td>
								
								<td>
								
								<a  href="reglement.php?action=affiche_reglemnt_fournisseur&id=<?php echo $fournisseur->id_fournisseur; ?>"  class="btn green btn-sm pull-right"> <i class="fa fa-usd "></i> Reglement </a>
								<a href="operation.php?action=achat" class="btn yellow btn-sm pull-right">
                                                    <i class="fa fa-file-text "></i> Crées une facture </a>
								 <a href="fournisseur.php?action=edit&id=<?php echo $fournisseur->id_fournisseur;  ?>" class="btn purple btn-sm pull-right">
                                                    <i class="fa fa-edit "></i>Modifier </a>
													
								</td>
							
							</tr>
							
						
							</tbody>
                                        </table>
					
                                    </div>
							
							<!-- END PORTLET-->
						</div>
						
						</div>
						
						</div>
					</div>
				<!--BEGIN FICHE FOURNISSEUR-->
				
					<?php
						if (isset($_POST['submit']) ) {
						
							$date_db = trim(htmlspecialchars($_POST['date_db']));
							$date_fin = trim(htmlspecialchars($_POST['date_fin']));
							 
							
							
						$factures = Facture_achat::trouve_facture_par_societe_and_Exercice_and_id_fournisseur($nav_societe->id_societe,$fournisseur->id_fournisseur,$date_db,$date_fin);
						$reglements = Solde_fournisseur::trouve_facture_par_societe_and_Exercice_and_id_fournisseur($nav_societe->id_societe,$fournisseur->id_fournisseur,$date_db,$date_fin);
						$avoirs = Facture_avoir_achat::trouve_avoir_par_societe_and_Exercice_and_id_fournisseur($nav_societe->id_societe,$fournisseur->id_fournisseur,$date_db,$date_fin);
						$depenses = Facture_depense::trouve_depense_par_societe_and_Exercice_and_id_fournisseur($nav_societe->id_societe,$fournisseur->id_fournisseur,$date_db,$date_fin);

						
						}else{
							$factures = Facture_achat::trouve_facture_par_societe_and_Exercice_and_id_fournisseur($nav_societe->id_societe,$fournisseur->id_fournisseur,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
							$reglements = Solde_fournisseur::trouve_facture_par_societe_and_Exercice_and_id_fournisseur($nav_societe->id_societe,$fournisseur->id_fournisseur,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
							$avoirs = Facture_avoir_achat::trouve_avoir_par_societe_and_Exercice_and_id_fournisseur($nav_societe->id_societe,$fournisseur->id_fournisseur,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
							$depenses = Facture_depense::trouve_depense_par_societe_and_Exercice_and_id_fournisseur($nav_societe->id_societe,$fournisseur->id_fournisseur,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
						
						}
						
						 ?>
                   <div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption bold">
								<i class="fa  fa-building font-yellow"></i>Fiche Fournisseur
							</div>
						</div>
						<div class="row">

								
										<div class="col-md-8">
										
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=affiche_fournisseur&id=<?php echo $fournisseur->id_fournisseur;?>" method="POST" class="form-horizontal">

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="col-md-3 control-label">Du</label>
														<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_db" class="form-control" value="<?php if(isset($nav_societe->exercice_debut)){echo $nav_societe->exercice_debut;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>					
														</div>
												</div>
											</div>	
											<div class="col-md-4">													
												<div class="form-group">
													<label class="col-md-3 control-label">au</label>
													<div class="col-md-9">
														<div class="input-group">
															<input type="date" name = "date_fin" class="form-control" value="<?php if(isset($nav_societe->exercice_fin)){echo $nav_societe->exercice_fin;} ?>" required >
															<span class="input-group-addon ">
															<i class="fa fa-calendar"></i>
															</span>
														</div>
														
													</div>
												</div>			
											</div>
											
										
													<div class="col-md-4">
														<button type="submit" name = "submit" class="btn green">Chercher</button>
														
													</div>
												
										</div>
										</form>
										<!-- END FORM-->
										
									
											
										</div>
									
									
							</div>
						<div class="portlet-body" id="divToPrint">
						<!--begien reglement-->
						<hr>
						<h2>FICHE FOURNISSEUR</h2>

						<?php if (isset($fournisseur->nom)) { echo $fournisseur->nom.'<br>';echo $fournisseur->Activite.'<br>';echo $fournisseur->Adresse;	} ?>
						
						<hr>
						
						<table class="table table-striped  table-hover" >
							<thead>
							<tr>
								<th>
									Type
								</th>
								<th>
									N° 
								</th>
								<th>
									Date 
								</th>
								
								<th>
									Total TTC
								</th>
								<th>
									debit
								</th>
								<th>
									mode_paiment
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
								
								 <i class="fa fa-file-text font-blue"></i>
									<b><?php if (isset($facture->N_facture)) {
										echo 'Facture';
										 } ?></b>
									
                                                   
								</td>
								<td>
								<a href="invoice.php?id=<?php echo $facture->id_facture; ?>" class="">
								<i class="fa fa-file-text-o bg-yellow"></i>
									<b><?php if (isset($facture->N_facture)) {
										$date = date_parse($facture->date_fac);
									echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?></b>
									
                                                    <i class="fa fa-download font-blue"></i> </a>
								</td>
								<td>
									<?php if (isset($facture->date_fac)) {
									echo $facture->date_fac;
									} ?>
								</td>
							
								<td>
									<?php 
									if (isset($facture->somme_ttc)) {
									echo number_format($facture->somme_ttc , 2, ',', ' ');
									} ?>
								</td>
								<td>
									/ 
								</td>
								<td>
									<?php if (isset($facture->id_facture)) {
										$Reglement_fournisseurs= Reglement_fournisseur::trouve_Reglement_par_id_facture($facture->id_facture,$nav_societe->id_societe,0);
										foreach ($Reglement_fournisseurs as $Reglement_fournisseur) {
										if (isset($Reglement_fournisseur->mode_paiment)) {
											$Mode_paiement_societe = Mode_paiement_societe::trouve_par_id($Reglement_fournisseur->mode_paiment);
											$Solde_fournisseur = Solde_fournisseur::trouve_par_id($Reglement_fournisseur->id_solde);
											if (isset($Solde_fournisseur->id)) {
											echo $Mode_paiement_societe->type.'  Ref: '.$Solde_fournisseur->reference.' <br>';	
											}else{
											echo $Mode_paiement_societe->type;	
											}
											
										}
										}
										
									}

									 ?>
								</td>
							</tr>

							<?php
								}
							?>
							
							</tbody>
							
							<tbody>
								<?php
								foreach($reglements as $reglement){
									$cpt ++;
								?>
							<tr>
								
								<td>
								
								 <i class="fa fa-usd font-blue"></i>
									<?php if (isset($reglement->id)) {
										echo 'Reglement';
										 } ?>
									
                                                   
								</td>
								<td>
								<i class="fa fa-usd font-yellow"></i>
								<a href="#">
								<?php if (isset($reglement->reference)) {
									echo $reglement->reference;
									} ?></a>
								</td>
								<td>
									<?php if (isset($reglement->date)) {
									echo $reglement->date;
									} ?>
								</td>
							
								<td>
									<?php if (isset($reglement->credit)) {
									echo str_replace(',',' ',number_format ($reglement->credit,2 ));
									} ?>
								</td>
								<td>
									<?php if (isset($reglement->debit)) {
									echo str_replace(',',' ',number_format ($reglement->debit,2 ));
									} ?>
								</td>
								<td>
								<?php if (isset($reglement->mode_paiment)) {
										if (isset($reglement->mode_paiment)) {
											$Mode_paiement_societe = Mode_paiement_societe::trouve_par_id($reglement->mode_paiment);
											echo $Mode_paiement_societe->type.'  Ref: '.$reglement->reference.' <br>';
										}
										
								//	echo $reglement->mode_paiment;
									} ?>
								</td>
								<?php
								}
							?>
							</tr>
							</tbody>
							<tbody>
								<?php
								foreach($avoirs as $avoir){
									$cpt ++;
								?>
							<tr>
								
								<td>
								
								 <i class="fa fa-file-text font-blue"></i>
									<b><?php if (isset($avoir->N_facture)) {
										echo 'Avoir';
										 } ?></b>
								</td>
								<td>
								<a href="invoice.php?id=<?php echo $avoir->id_facture; ?>" class="">
								<i class="fa fa-file-text-o bg-yellow"></i>
									<b><?php if (isset($avoir->N_facture)) {
										$date = date_parse($avoir->date_fac);
									echo sprintf("%04d", $avoir->N_facture).'/'.$date['year']; } ?></b>
									
                                                    <i class="fa fa-download font-blue"></i> </a>
								</td>
								<td>
									<?php if (isset($avoir->date_fac)) {
									echo $avoir->date_fac;
									} ?>
								</td>
								<td>
									/ 
								</td>							
								<td>
									<?php if (isset($avoir->somme_ttc)) {
									echo number_format($avoir->somme_ttc , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($avoir->id_facture)) {
										$Reglement_fournisseurs= Reglement_fournisseur::trouve_Reglement_par_id_facture($avoir->id_facture,$nav_societe->id_societe,3);
										foreach ($Reglement_fournisseurs as $Reglement_fournisseur) {
										if (isset($Reglement_fournisseur->mode_paiment)) {
											$Mode_paiement_societe = Mode_paiement_societe::trouve_par_id($Reglement_fournisseur->mode_paiment);
											$Solde_fournisseur = Solde_fournisseur::trouve_par_id($Reglement_fournisseur->id_solde);
											if (isset($Solde_fournisseur->id)) {
											echo $Mode_paiement_societe->type.'  Ref: '.$Solde_fournisseur->reference.' <br>';	
											}else{
											echo $Mode_paiement_societe->type;	
											}
											
										}
										}
										
									}

									 ?>
								</td>
							</tr>

							<?php
								}
							?>
							
							</tbody>
							<tbody>
								<?php
								foreach($depenses as $depense){
									$cpt ++;
								?>
							<tr>
								
								<td>
								
								 <i class="fa fa-dollar font-blue"></i>
									<b><?php if (isset($depense->reference)) {
										echo 'Depense';
										 } ?></b>
								</td>
								<td>
								<a href="#" class="">
								<i class="fa fa-dollar font-yellow"></i>
									<b><?php if (isset($depense->reference)) {
										$date = date_parse($depense->date_fact);
									echo sprintf( $depense->reference).'/'.$date['year']; } ?></b>
									
                                                    <i class="fa fa-download font-blue"></i> </a>
								</td>
								<td>
									<?php if (isset($depense->date_fact)) {
									echo $depense->date_fact;
									} ?>
								</td>
							
								<td>
									<?php if (isset($depense->ttc)) {
									echo number_format($depense->ttc , 2, ',', ' ');
									} ?>
								</td>
								<td>
									/ 
								</td>
								<td>
									<?php if (isset($depense->id_depense)) {
										$Reglement_fournisseurs= Reglement_fournisseur::trouve_Reglement_par_id_facture($depense->id_depense,$nav_societe->id_societe,2);
										foreach ($Reglement_fournisseurs as $Reglement_fournisseur) {
										if (isset($Reglement_fournisseur->mode_paiment)) {
											$Mode_paiement_societe = Mode_paiement_societe::trouve_par_id($Reglement_fournisseur->mode_paiment);
											$Solde_fournisseur = Solde_fournisseur::trouve_par_id($Reglement_fournisseur->id_solde);
											if (isset($Solde_fournisseur->id)) {
											echo $Mode_paiement_societe->type.'  Ref: '.$Solde_fournisseur->reference.' <br>';	
											}else{
											echo $Mode_paiement_societe->type;	
											}
											
										}
										}
										
									}

									 ?>
								</td>
							</tr>

							<?php
								}
							?>
							
							</tbody>
							<tr>
							<td>
							<b>Total debit<b>
							</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td ><?php $c=0;
							foreach($reglements as $reglement){							
							
								$c += $reglement->debit; 
							}
							$avoire =0;
							foreach($avoirs as $avoir){
							
								$avoire += $avoir->somme_ttc; 
							
							}
							$total_reglement_avoir=0;
							$total_reglement_avoir=$c+$avoire;
							
							?>
								<?php echo '<b>' . str_replace(',',' ',number_format ($total_reglement_avoir,2 )). '</b>'; ?></td>
							
							<td>&nbsp;</td>
							</tr>
							<tr>
							<td>
							<b>Total TTC<b>
							</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							
							<td >
							<?php
							$f=0;
							foreach($factures as $facture){							
								$f += $facture->somme_ttc; 							
							}							
							$deepns=0;
							foreach($depenses as $deepnse){							
								$deepns += $deepnse->ttc; 							
							}
							$total_ttc_fournisseur=0;
							$total_ttc_fournisseur =$f+$deepns;
							 ?>
							<?php echo '<b>' . str_replace(',',' ',number_format ($total_ttc_fournisseur,2 )) . '</b>'; ?></td>
							<td >&nbsp;</td>	
							<td>&nbsp;</td>
							</tr>
							<tr>
							<td>
							<b>Solde initail<b>
							</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td>
							<?php if (isset($fournisseur->Solde)) {
													echo $fournisseur->Solde ;
													} ?>								
							</td>
							</tr>
							<tr>
							<td>
							<b>Total<b>
							</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td>
							
							<?php $stol = $total_reglement_avoir - $total_ttc_fournisseur ;  echo '<b> ' . str_replace(',',' ',number_format ($stol,2 )) . ' DA </b>'; ?>								
							</td>
							
							</tr>

							</tbody>
							</table>
					 <!--END reglement-->
						</div>
						<div class="row">
							<div class="col-xs-12 invoice-block">
								<br>
								<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="PrintDiv();">
										 <i class="fa fa-print"></i> Imprimer
										</a>
								
								
							</div>
						</div>
					</div>							
					
				</div>

			</div>
			<?php  

				}elseif ($action == 'add_fournisseur') {		
				  ?>

			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-8">
									<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
								<?php

					if (isset($_GET['id'])) {
					 $id =  htmlspecialchars(intval($_GET['id'])) ;
					 $fournisseur = Societe::trouve_par_id($id);
					}
				 ?>


                                <div class="portlet light">
							
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-user font-yellow"></i>Ajouter fournisseur
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_fournisseur" id="form_sample_2" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<h3 class="form-section">General</h3>
												<div class="form-group">
													<label class="col-md-3 control-label">Type  fournisseur <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-icon right">															
															<i class="fa"></i>
														<select class="form-control " id=""  name="type" required="">
															<option>sélectionner un type </option>
															<option value="1">Fournisseur de produit </option>
															<option value="2">Fournisseur de service </option>
															<option value="3">Fournisseur Etranger </option>
														</select>
													</div>

													</div>
												</div>
													<div class="form-group">
														<label class="control-label col-md-3">Nom <span class="required">
														* </span>
														</label>
														<div class="col-md-6">
															<div class="input-icon right">
																<i class="fa"></i>
																<input type="text" class="form-control" name="nom" required/>
															</div>
														</div>
													</div>
												<div class="form-group">
														<label class="control-label col-md-3">Activite <span class="required">
														* </span>
														</label>
														<div class="col-md-6">
															<div class="input-icon right">
																<i class="fa"></i>
																<input type="text" class="form-control" name="Activite" required/>
															</div>
														</div>
												</div>
												
										
											<h3 class="form-section">Adresse & contact </h3>
												<div class="form-group">
														<label class="control-label col-md-3">Adresse <span class="required">
														* </span>
														</label>
														<div class="col-md-6">
															<div class="input-icon right">
																<i class="fa"></i>
																<input type="text" class="form-control" name="Adresse" required/>
															</div>
														</div>
												</div>
												<div class="form-group">
														<label class="control-label col-md-3">Ville <span class="required">
														* </span>
														</label>
														<div class="col-md-6">
															<div class="input-icon right">
																<i class="fa"></i>
																<select class="form-control" name="Ville" required >
																	<option value = "">-----</option>
																	<option value = "Adrar">Adrar</option>
																	<option value = "Chlef">Chlef</option>
																	<option value = "Laghouat">Laghouat</option>
																	<option value = "Oum El Bouaghi">Oum El Bouaghi</option>
																	<option value = "Batna">Batna</option>
																	<option value = "Bejaia">Bejaia</option>
																	<option value = "Biskra">Biskra</option>
																	<option value = "Bechar">Bechar</option>
																	<option value = "Blida">Blida</option>
																	<option value = "Bouira">Bouira</option>
																	<option value = "Tamanrasset">Tamanrasset</option>
																	<option value = "Tebessa">Tebessa</option>
																	<option value = "Tlemcen">Tlemcen</option>
																	<option value = "Tiaret">Tiaret</option>
																	<option value = "Tizi Ouzou">Tizi Ouzou</option>
																	<option value = "Alger">Alger</option>
																	<option value = "Djelfa">Djelfa</option>
																	<option value = "Jijel">Jijel</option>
																	<option value = "Setif">Setif</option>
																	<option value = "Saida">Saida</option>
																	<option value = "Skikda">Skikda</option>
																	<option value = "Sidi Bel Abbes">Sidi Bel Abbes</option>
																	<option value = "Annaba">Annaba</option>
																	<option value = "Guelma">Guelma</option>
																	<option value = "Constantine">Constantine</option>
																	<option value = "Medea">Medea</option>
																	<option value = "Mostaganem">Mostaganem</option>
																	<option value = "MSila">MSila</option>
																	<option value = "Mascara">Mascara</option>
																	<option value = "Ouargla">Ouargla</option>
																	<option value = "Oran">Oran</option>
																	<option value = "El Bayadh">El Bayadh</option>
																	<option value = "Illizi">Illizi</option>
																	<option value = "Bordj Bou Arreridj">Bordj Bou Arreridj</option>
																	<option value = "Boumerdes">Boumerdes</option>
																	<option value = "El Tarf">El Tarf</option>
																	<option value = "Tindouf">Tindouf</option>
																	<option value = "Tissemsilt">Tissemsilt</option>
																	<option value = "El Oued">El Oued</option>
																	<option value = "Khenchela">Khenchela</option>
																	<option value = "Souk Ahras">Souk Ahras</option>
																	<option value = "Tipaza">Tipaza</option>
																	<option value = "Mila">Mila</option>
																	<option value = "Ain Defla">Ain Defla</option>
																	<option value = "Naama">Naama</option>
																	<option value = "Ain Temouchent">Ain Temouchent</option>
																	<option value = "Ghardaia">Ghardaia</option>
																	<option value = "Relizane">Relizane</option>
																</select>
															</div>
														</div>
												</div>																								
												<div class="form-group">
													<label class="control-label col-md-3">Postal <span class="required">
													* </span>
													</label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input type="text" class="form-control" name="Postal"  required=""/>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Tel</label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input type="text" class="form-control" name="Tel1"  placeholder="027 00 00 00"/>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Mobile </label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input type="text" class="form-control" name="mob1"  placeholder="0550 00 00 00"/>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-3">Email</label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input type="text" class="form-control" name="Email" placeholder="contct@mail.com"/>
														</div>
													</div>
												</div>											
												
												<!-- INFO COMMERCIAL -->
												
																<legend>info commercial</legend>
																<div class="form-group">
																	<label class="col-md-3 control-label">Type  <span class="required" aria-required="true"> * </span></label>
																	<div class="col-md-6">
																	<div class="input-icon right">															
																		<i class="fa"></i>																	
																		<select name = "type_rc" id="type_rc" class="form-control" required="">
																			<option value="1">Rc</option>
																			<option value="2">Agrement</option>
																			<option value="3">Carte artisan</option>
																			<option value="4">Carte fellah</option>
																		</select>
																		</div>
																	</div>
																</div>
																<div class="form-group" id="rc_input">
																	<label class="col-lg-3 control-label">Numéro du registre commerce (RC): <span class="required" aria-required="true"><em>(3)</em> * </span></label>
																	<div class="col-lg-6 ">
																	<div class="input-icon right">															<i class="fa"></i>
																	<i class="fa"></i>
																		<input type="text" class="form-control show-on" name = "Rc" id="mask_rc" required="" >
																		<span class="help-block"> Numéro du registre commerce:  16/00-876443B15 </span>
																	</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-lg-3 control-label">NIF <span class="required" aria-required="true"><em>(4)</em> * </span></label>
																	<div class="col-lg-6">
																		<div class="input-icon right">															
																		<i class="fa"></i>
																		<input type="text" class="form-control show-on" name = "Mf" class="form-control" maxlength="20" minlength="20" placeholder="NIF " id="nif" required="" >
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-lg-3 control-label">Ai <em>(5)</em> </label>
																	<div class="col-lg-6">
																	<div class="input-icon right">
																		<i class="fa"></i>													
																		<input type="text" class="form-control show-on"name ="Ai" maxlength="11" minlength="11" class="form-control" placeholder="Ai" id="ai" required="" >
																	</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-lg-3 control-label">Nis <em>(6)</em></label>
																	<div class="col-lg-6">
																		<div class="input-icon right">														
																		<i class="fa"></i>
																		<input type="text" class="form-control show-on" name ="Nis" class="form-control" placeholder="Nis "  id="nis"  >
																		</div>
																	</div>
																</div>
																
																<div class="form-group">
																	<label class="col-md-3 control-label">Solde </label>
																	<div class="col-md-6">
																	<div class="input-icon right">														
																		<i class="fa"></i>
																		<input type="text" name = "Solde" class="form-control" placeholder="00.00 " required="" >
																	</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-3 control-label">NCompte </label>
																	<div class="col-md-6">
																	<div class="input-icon right">													
																		<i class="fa"></i>
																		<input type="text" name = "NCompte" class="form-control" placeholder="NCompte "  >
																	</div>
																	</div>
																</div>
																<div class="form-group">
																		<label class="col-md-3 control-label">Compte  <span class="required" aria-required="true"> * </span></label>
																		<div class="col-md-4">
																		<div class="input-icon right">															
																		<i class="fa"></i>
																			<select class="form-control " id="comptes_achat"  name="Compte" required="">
																	
																				<?php 															
																				$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
																				
																				foreach($Comptes as $Compte){?>

																			<option <?php if ($Compte->id ) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
																			
																				<?php } ?>															   
																			</select>
																		</div>
																		</div>
																		<div class="form-group comptes_achat">
																		<label class="col-md-2 control-label">Auxiliere :  </label>
																		<div class="col-md-2">
																		<?php 

																			  if(isset($Compte->id)){
																			 $Compt = Compte_comptable::trouve_par_id($Compte->id);
																			  }
																				  ?>	
																			<div class="input-group">
																			<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
																			
																			<?php 
																			$id_societe = $nav_societe->id_societe;
																			if(!empty($Compt->prefixe))	{
																			$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
																			foreach($Aux as $Auxs){?>
																			
																			<option <?php if ($Auxs->id) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
																			
																				<?php } 	}	else {?>
																					
																					<option>  </option>
																			<?php	}?>											
																			
																																	   
																			</select>
																			<span class="input-group-addon ">
																				AUX
																				</span>	
																			</div>

																		</div>
																		</div>
																		
																	</div>
														
													
												
												<input type="hidden" name="facture_scan" value="<?php if (isset($_GET['id_img'])) {	 $image =  htmlspecialchars($_GET['id_img']) ; echo  $image ; }?>" />
												
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn green">Ajouter</button>
														<button type="reset" class="btn  default">Annuler</button>
														
													</div>
												</div>
											
										</div>
										
										</form>
										<!-- END FORM-->
										</div>
									</div>
																	
			</div>
			<div class="col-md-4 list-group-item bg-blue-chambray margin-bottom-30">
					<div class=" bg-blue-ebonyclay">
						<p>Scan du fiche client</p>
					</div>
				<?php
					if (isset($_GET['id_img'])) {
					 $image =  htmlspecialchars($_GET['id_img']) ;
					 
					 $img_select = Upload::trouve_par_id ($image);
					  
					}else{
							echo '<p> aucune fiche sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($image)){
				
					$info = new SplFileInfo($img_select->img);
					$errors[]= '  erreur !';
					if($info->getExtension() == 'pdf'){?>
					
					<object data="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" type="application/pdf" width="100%" height="1000" class="figure-wrap">
					<?php if (!empty($msg_error)) {?>
						<object data="assets/image/test.pdf" type="application/pdf" width="100%" height="1000">
						alt : <a href="assets/image/test.pdf">test.pdf</a>
						</object> 
						<?php }?>
					</object>

						<?php }else {?>
							

					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" class="img-responsive fancybox-button figure-wrap" style="transform: scale(1); transform-origin: 0px 0px;"><img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   ></a>
				
						<a href="#scan_fiche_fournisseur" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
						<a href="#scan_fiche_fournisseur" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
						<a href="#scan_fiche_fournisseur" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
					
								<?php }?>
	
				
				
				<?php }else {echo '<a href="#scan_fiche_fournisseur" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>
		</div>
			<!-- END PAGE CONTENT-->
<?php }  elseif ($action == 'edit') { ?>
	<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">
<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>


                                <div class="portlet light">
							
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-user font-yellow"></i>Editer Fournisseur
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<h3 class="form-section">General</h3>
												<div class="form-group">
													<label class="col-md-3 control-label">Type  fournisseur <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
														<select class="form-control " id=""  name="type">

															<option>sélectionner un type </option>
															<option  <?php if(isset($editFournisseur->type)&&($editFournisseur->type=="1")){echo "selected";} ?> value="1">fournisseur de produit </option>
															<option  <?php if(isset($editFournisseur->type)&&($editFournisseur->type=="2")){echo "selected";} ?> value="2">fournisseur de service </option>
															<option  <?php if(isset($editFournisseur->type)&&($editFournisseur->type=="3")){echo "selected";} ?> value="3">Fournisseur Etranger </option>
														</select>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Nom  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "nom" class="form-control" placeholder="Nom " value ="<?php if (isset($editFournisseur->nom)){ echo html_entity_decode($editFournisseur->nom); } ?>" required>
															<span class="input-group-addon ">
															<i class="fa fa-folder"></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Activite </label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Activite" class="form-control" placeholder="Activite " value ="<?php if (isset($editFournisseur->Activite)){ echo html_entity_decode($editFournisseur->Activite); } ?>" >

															<span class="input-group-addon ">
															
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">

													<label class="col-md-3 control-label">Etat </label>
													<div class="col-md-6">
														<div class="input-group">
														<span class="input-group-btn">
															<button class="btn red" type="button">Etat </button>
															</span>
															<select class="form-control" name="Etat" id="Etat">
																<option value="1" <?php if(isset($editFournisseur->Etat)&&($editFournisseur->Etat=="1")){echo "selected";} ?>>Active</option>
																<option value="0" <?php if(isset($editFournisseur->Etat)&&($editFournisseur->Etat=="0")){echo "selected";} ?>>Désactive</option>
																
															</select>
														</div>
														
													</div>
												</div>
											<h3 class="form-section">Adresse & contact </h3>												
												<div class="form-group">
													<label class="col-md-3 control-label">Adresse <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-6">
														<div class="input-group">
															<input type="text" name = "Adresse" class="form-control" placeholder="Adresse" value ="<?php if (isset($editFournisseur->Adresse)){ echo html_entity_decode($editFournisseur->Adresse); } ?>" required>
															<span class="input-group-addon " required >
															<i class="fa fa-exchange"></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Ville <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Ville" class="form-control" value ="<?php if (isset($editFournisseur->Ville)){ echo html_entity_decode($editFournisseur->Ville); } ?>" required>
															<span class="input-group-addon " required >
															<i class="fa fa-building"></i>
															</span>
														</div>
														
													</div>
												</div>												
												
												<div class="form-group">
													<label class="col-md-3 control-label">Postal </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Postal" class="form-control" placeholder="Postal " value ="<?php if (isset($editFournisseur->Postal)){ echo html_entity_decode($editFournisseur->Postal); } ?>" >
															<span class="input-group-addon ">
															<i class="">Postal</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Tel  01 </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Tel1" class="form-control" placeholder="021 00 00 00 " value ="<?php if (isset($editFournisseur->Tel1)){ echo html_entity_decode($editFournisseur->Tel1); } ?>" >
															<span class="input-group-addon ">
															<i class="fa  fa-phone"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Mobile  01 </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Mob1" class="form-control" placeholder="050 00 00 00" value ="<?php if (isset($editFournisseur->Mob1)){ echo html_entity_decode($editFournisseur->Mob1); } ?>" >
															<span class="input-group-addon ">
															<i class="fa  fa-mobile-phone"></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Email  </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="email" name = "Email" class="form-control" placeholder="Email@exemple.com " value ="<?php if (isset($editFournisseur->Email)){ echo html_entity_decode($editFournisseur->Email); } ?>" >
															<span class="input-group-addon ">
															<i class="fa fa-envelope"></i>
															</span>
														</div>
														
													</div>
												</div>	
												<h3 class="form-section">info commercial </h3>
												<div class="form-group">
													<label class="col-md-3 control-label">Type  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
														<select name = "type_rc" id="type_rc" class="form-control">
															<option value="1" <?php if(isset($editFournisseur->type_rc)&&($editFournisseur->type_rc=="1")){echo "selected";} ?>>Rc</option>
															<option value="2" <?php if(isset($editFournisseur->type_rc)&&($editFournisseur->type_rc=="2")){echo "selected";} ?>>Agrement</option>
															<option value="3" <?php if(isset($editFournisseur->type_rc)&&($editFournisseur->type_rc=="3")){echo "selected";} ?>>Carte artisan</option>
															<option value="4" <?php if(isset($editFournisseur->type_rc)&&($editFournisseur->type_rc=="4")){echo "selected";} ?>>Carte fellah</option>
														</select>
														<span class="input-group-addon ">
															<i class=""></i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group" id="rc_input">
													<label class="col-md-3 control-label">Rc </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Rc" id="mask_rc" class="form-control" placeholder="RC "  value ="<?php if (isset($editFournisseur->Rc)){ echo html_entity_decode($editFournisseur->Rc); } ?>" >
															<span class="input-group-addon ">
															<i class="">RC</i>
															</span>
															
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">NIF *</label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Mf" maxlength="20" minlength="20" class="form-control" placeholder="Mf " value ="<?php if (isset($editFournisseur->Mf)){ echo html_entity_decode($editFournisseur->Mf); } ?>" required>
															<span class="input-group-addon ">
															<i class="">Mf</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Ai </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Ai" maxlength="11" minlength="11" class="form-control" placeholder="Ai " value ="<?php if (isset($editFournisseur->Ai)){ echo html_entity_decode($editFournisseur->Ai); } ?>" >
															<span class="input-group-addon ">
															<i class="">Ai</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Nis </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Nis" class="form-control" placeholder="Nis " value ="<?php if (isset($editFournisseur->Nis)){ echo html_entity_decode($editFournisseur->Nis); } ?>" >
															<span class="input-group-addon ">
															<i class="">Nis</i>
															</span>
														</div>
														
													</div>
												</div>
												

												<div class="form-group">
													<label class="col-md-3 control-label">Solde </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "Solde" class="form-control" placeholder="00.00 " value ="<?php if (isset($editFournisseur->Solde)){ echo html_entity_decode($editFournisseur->Solde); } ?>" >

															<span class="input-group-addon ">
															<i class="">DZD</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">NCompte </label>
													<div class="col-md-3">
														<div class="input-group">
															<input type="text" name = "NCompte" class="form-control" placeholder="NCompte " value ="<?php if (isset($editFournisseur->NCompte)){ echo html_entity_decode($editFournisseur->NCompte); } ?>" >

															<span class="input-group-addon ">
															<i class="">NCompte</i>
															</span>
														</div>
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Compte  <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														
														<select class="form-control " id="comptes_achat"  name="Compte">
												
															<?php 															
															$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
															foreach($Comptes as $Compte){?>

														<option <?php if ($Compte->id == $editFournisseur->Compte) { echo "selected";} ?> value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
															<?php } ?>															   
														</select>
															
  
														<span class="input-group-addon ">
															<i class="fa fa-table "></i>
															</span>	
															</div>
													</div>
													<div class="form-group comptes_achat">
													<label class="col-md-2 control-label">Auxiliere :  </label>
													<div class="col-md-2">
													<?php 

														  if(isset($editFournisseur->Compte)){
														 $Compt = Compte_comptable::trouve_par_id($editFournisseur->Compte);
														  }
															  ?>	
														<div class="input-group">
														<select class="form-control " <?php if($Compt->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
														<?php 
														$id_societe = $nav_societe->id_societe;
														if(!empty($Compt->prefixe))	{
														$Aux = Auxiliere::trouve_auxiliere_par_lettre_aux($Compt->prefixe,$id_societe);
														foreach($Aux as $Auxs){?>
														
														<option <?php if ($Auxs->id == $editFournisseur->Compte) { echo "selected";}?> value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
															<?php } 	}	else {?>
																
																<option>  </option>
														<?php	}?>											
														
																												   
														</select>
														<span class="input-group-addon ">
															AUX
															</span>	
														</div>

													</div>
													</div>
													
												</div>
												
												
													
												
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn green">Modifier</button>
														<button type="button" value="back" onclick="history.go(-1)" class="btn  default">Annuler</button>
														 <?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
													</div>
												</div>
											</div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
			<?php }}?>
		</div>
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
	<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container-fluid">
		 2021 &copy; Mohammed FETTAH. <a href="#" title="Mohammed FETTAH" target="_blank">Mohammed FETTAH</a>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
	<!-- MODEL UPLOAD SCAN-->
	<div id="scan_fiche_fournisseur" class="modal container fade" tabindex="-1">
					
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Sélectionner une image</h4>
					</div>
					<div class="modal-body">
			
		<div class="row">
	<?php
	$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); 
	$cpt = 0;
	$file = str_replace (" ", "_", $nav_societe->Dossier );
		foreach($ScanImages as $ScanImage){
	?>
	<div class="col-md-4 ">
	<!-- BEGIN WIDGET THUMB -->

	<div class="widget-thumb widget-bg-color-white text-uppercase rounded-3 margin-bottom-30 portlet light bordered ">
	<a  href="fournisseur.php?action=add_fournisseur&id_img=<?php echo $ScanImage->id;  ?>" class="fancybox-button" data-rel="fancybox-button"   >
	<div class="widget-news ">
	<?php 
	$info = new SplFileInfo($ScanImage->img);

	if($info->getExtension() == 'pdf'){?>
	<img class="widget-news-left-elem" src="assets/image/pdf-icon.png" alt="" style="width: 80px; height: 80px;"  >
	<?php }else {?>
		<img class="widget-news-left-elem" src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>" alt="" style="width: 80px; height: 80px;"  >
	<?php }?>
	<div class="widget-news-right-body">
		<p><?php echo $file?>/<?php echo $ScanImage->img ;?>
				
		</p>
		<span > <?php echo $thisday;?> </span>
		
	</div>

	</div>
	</a>
	</div>

	<!-- END WIDGET THUMB -->
	</div>
	<?php }?>
	</div>

					</div>
					<div class="modal-footer">
						<button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
						
					</div>
				
	</div>		
	
	<script>
	////////////////////////////////// onchange   comptes_achat ///////////////////////////

$(document).on('change','#comptes_achat', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.comptes_achat').load('ajax/prefixe.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>
    <script>
	////////////////////////////////// onchange TYPE RC ///////////////////////////

$(document).on('change','#type_rc', function() {
    var id = this.value;
    var id_fournisseur = <?php if (isset($editFournisseur->id_fournisseur)) {echo $editFournisseur->id_fournisseur;}else{echo 0;}   ?>;
     $('#rc_input').load('ajax/change_type_rc.php?id='+id+'&id_fournisseur='+id_fournisseur,function(){       
    });
});

  </script>	
   <script type="text/javascript">     
    function PrintDiv() {    
       var divToPrint = document.getElementById('divToPrint');
       var popupWin = window.open('', 'width=300,height=300');
       popupWin.document.open();
       popupWin.document.write('<html><head><link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"></head><body onload="window.print()"><div class="container-fluid">' + divToPrint.innerHTML + '</div></html>');
        popupWin.document.close();
            }
 </script>
<!-- END CONTAINER -->


<!-- END CONTAINER -->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="assets/global/plugins/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
<script src="assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-form-tools.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

	    <script>
  	$(document).ready(function() {
   $("#mask_rc").inputmask("mask", {
            "mask": "99/99-9999999A99"
        }); 
});
  </script>  
      <script type="text/javascript" src="assets/global/js/modernizr.js"></script> 
     <script type="text/javascript" src="assets/global/js/show-on.js"></script>   
   
<script>


    $(function() {
        $('input').showOn({ //.show-on
            target: '.figure-wrap',
            bind: {
                'mask_rc': ['76% 7%', 4.5],
                'nif': ['75% 10%', 4],
                'ai': ['85% 1%', 3],
				'nis': ['85% 1%', 3],
            },
        });
    });
</script>
	<?php if (in_array('validation',$footers)){?>	
	<script>
        jQuery(document).ready(function() {       
           // initiate layout and plugins
           Metronic.init(); // init metronic core components

		    FormValidation.init();
        });   
    </script>
       <script type="text/javascript" src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
	   <script type="text/javascript" src="assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
	   <script src="assets/admin/pages/scripts/form-validation.js"></script>
	<?php } ?>
</html>


<?php
//require_once("footer/footer.php");
?>