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
if ($user->type == "administrateur"){

	if (isset($_GET['action']) && $_GET['action'] =='list_pieces' ) {

$active_submenu = "list_pieces";
$action = 'list_pieces';
	}
else if (isset($_GET['action']) && $_GET['action'] =='add_pieces' ) {
$active_submenu = "list_pieces";
$action = 'add_pieces';}
else if (isset($_GET['action']) && $_GET['action'] =='valid_piece' ) {
$active_submenu = "list_pieces";
$action = 'valid_piece';}
else if (isset($_GET['action']) && $_GET['action'] =='edit_piece' ) {
$active_submenu = "list_pieces";
$action = 'edit_piece';}
else if (isset($_GET['action']) && $_GET['action'] =='list_ecriture' ) {
$active_submenu = "list_ecritures";
$action = 'list_ecriture';}
else if (isset($_GET['action']) && $_GET['action'] =='upload' ) {
$active_submenu = "list_pieces";
$action = 'upload';}
else if (isset($_GET['action']) && $_GET['action'] =='comptableser' ) {
$active_submenu = "list_pieces";
$action = 'comptableser';}
else if (isset($_GET['action']) && $_GET['action'] =='list_annexe_5' ) {
$active_submenu = "list_annexe_5";
$action = 'list_annexe_5';}
else if (isset($_GET['action']) && $_GET['action'] =='add_annexe_5' ) {
$active_submenu = "list_annexe_5";
$action = 'add_annexe_5';}
else if (isset($_GET['action']) && $_GET['action'] =='save_5' ) {
$active_submenu = "list_annexe_5";
$action = 'save_5';}
else if (isset($_GET['action']) && $_GET['action'] =='annexe_5' ) {
$active_submenu = "list_annexe_5";
$action = 'annexe_5';}
else if (isset($_GET['action']) && $_GET['action'] =='edit_annexe_5' ) {
$active_submenu = "list_annexe_5";
$action = 'edit_annexe_5';}
else if (isset($_GET['action']) && $_GET['action'] =='releve_comptes' ) {
$active_submenu = "list_pieces";
$action = 'releve_comptes';}
else if (isset($_GET['action']) && $_GET['action'] =='add_releve' ) {
$active_submenu = "add_releve";
$action = 'add_releve';}

if ($action == 'valid_piece') {
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);
	$somme_debit = Ecriture_comptable::somme_debit($user->id,$nav_societe->id_societe); 
	$somme_credit = Ecriture_comptable::somme_credit($user->id,$nav_societe->id_societe); 
	$Ecriture_comptables = Ecriture_comptable::trouve_compte_vide_par_admin($user->id,$nav_societe->id_societe); 
	$last_Ecriture = Ecriture_comptable::trouve_last_ecriture_par_id_admin($user->id,$nav_societe->id_societe);


	$errors = array();
	$random_number = rand();
	$Pieces_comptables = new Pieces_comptables();
	$Pieces_comptables->id_societe = $nav_societe->id_societe;
	$Pieces_comptables->ref_piece = $last_Ecriture->ref_piece;
	$Pieces_comptables->libelle =  $last_Ecriture->lib_piece;
	$Pieces_comptables->date = $last_Ecriture->date;
	$Pieces_comptables->date_valid = date("Y-m-d");
	$Pieces_comptables->journal =  $last_Ecriture->journal;
	$Pieces_comptables->somme_debit =  $somme_debit->somme_debit;
	$Pieces_comptables->somme_credit =  $somme_credit->somme_credit;
	$Pieces_comptables->random =  $random_number;
	
	//////////////////////////////////////////////////


	if (empty($errors)){
   		if ($Pieces_comptables->existe()) {
			$msg_error = '<p style= "font-size: 20px; "> Cette  Facture ' . $Pieces_comptables->N_facture . ' existe déja  !!</p><br />';
			
		}else{
			$Pieces_comptables->save(); ?>
 			<script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
            toastr.success(" Facture créée avec succès","Très bien !");
        },300);


 			});

			</script>
		
	<?php  
			$Pieces = Pieces_comptables::trouve_par_random($random_number);
			$date = date_parse($Pieces->date);
			 foreach($Ecriture_comptables as $Ecriture_comptable){ 

				if (empty($errors)){

		/////////////// mise a jour table Ecriture avec le nv id_piece ////////////////////
					$Ecriture_comptable->id_piece = $Pieces->id;
					$Ecriture_comptable->modifier();


				}else{
					
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	toastr.error("';
        	    foreach ($errors as $msg) {
        	        echo ' - '.$msg.' <br />';
        	    }
			echo '  ","Attention !");
			},400);
			});
			</script>'; 

	}
			 }
			  readresser_a("saisie.php?action=comptableser");
			
		}
 		 
 		}else{
		// errors occurred
		 echo '<script type="text/javascript">
		 $(document).ready(function(){
		  setTimeout(function() {
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			},300);
			});
			</script>'; 
	}

}


if (  isset($_GET['action'] ) && ($_GET['action'] =='annexe_5' ||  $_GET['action'] =='edit_annexe_5') ) {

	$id = htmlentities(trim($_GET['id']));
	$annexe_5= Tab_annexe_5::trouve_par_id($id);

}


if(isset($_POST['update']) ){
	$errors = array();

	$id = htmlentities(trim($_POST['id']));
	$Tab_annexe_5= Tab_annexe_5::trouve_par_id($id);


//////////// Relevé des pertes de valeurs sur créances //////////////
	$Designation = $_POST['Designation'];
	$Valeur = $_POST['Valeur'];
	$Perte_1 = $_POST['Perte_1'];

	$Valeurs_creances = array($Designation, $Valeur,$Perte_1 );
////////////// Relevé des pertes de valeurs sur actions et parts sociales ///////////////:
	$Filiales = $_POST['Filiales'];
	$Valeur_nominale = $_POST['Valeur_nominale'];
	$Perte_2 = $_POST['Perte_2'];
	$Valeur_nette = $_POST['Valeur_nette'];

	$Valeurs_actions = array($Filiales, $Valeur_nominale,$Perte_2,$Valeur_nette );
		// new object Annexe 5
	$Tab_annexe_5->date = htmlentities(trim($_POST['date_annexe']));

	if (empty($errors)){
if ($Tab_annexe_5->modifier()) {


	//// delete old rows ///////////////////////////		
			$creance = Tab_releve_pertes_valeurs_creances::supprime_par_id_annexe($Tab_annexe_5->id);
			$action = Tab_releve_pertes_valeurs_actions::supprime_par_id_annexe($Tab_annexe_5->id);
 						


 			for($i=0;$i<count($Valeurs_creances[0]);$i++){
			$valeurs_creance = new Tab_releve_pertes_valeurs_creances();
			$valeurs_creance->id_annexe= $Tab_annexe_5->id;
			$valeurs_creance->Designation_debiteurs= $Valeurs_creances[0][$i];
			$valeurs_creance->Valeur_creance= $Valeurs_creances[1][$i];
			$valeurs_creance->Perte_valeur_constituee =  $Valeurs_creances[2][$i];
			$valeurs_creance->date =  $Tab_annexe_5->date;
			$valeurs_creance->save();

			}


 			for($i=0;$i<count($Valeurs_actions[0]);$i++){
			$valeurs_action = new Tab_releve_pertes_valeurs_actions();
			$valeurs_action->id_annexe= $Tab_annexe_5->id;
			$valeurs_action->Filiales= $Valeurs_actions[0][$i];
			$valeurs_action->Valeur_nominale= $Valeurs_actions[1][$i];
			$valeurs_action->Perte_valeur_constituee =  $Valeurs_actions[2][$i];
			$valeurs_action->Valeur_nette =  $Valeurs_actions[3][$i];
			$valeurs_action->date =  $Tab_annexe_5->date;
			$valeurs_action->save();

			}


			readresser_a("saisie.php?action=annexe_5&id=".$Tab_annexe_5->id."&update");
		
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

}



$titre = "ThreeSoft | Pieces comptables ";
$active_menu = "saisie";
$header = array('table');
$thisday=date('Y-m-d');
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}

if (isset($_GET['action']) && ( $_GET['action'] =='comptableser'  )) {

			echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.success(" Pièce comptable  Ajouter avec succès","Très bien !");
        },300);
        });
			</script>';

} 
if(isset($_GET['update']) ){
echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.success(" Annexe  modifier avec succès","Très bien !");
        },300);
        });
			</script>';
}

if(isset($_POST['submit']) && $action == 'save_5'){
	$errors = array();
	$random_number = rand();
//////////// Relevé des pertes de valeurs sur créances //////////////
	$Designation = $_POST['Designation'];
	$Valeur = $_POST['Valeur'];
	$Perte_1 = $_POST['Perte_1'];

	$Valeurs_creances = array($Designation, $Valeur,$Perte_1 );
////////////// Relevé des pertes de valeurs sur actions et parts sociales ///////////////:
	$Filiales = $_POST['Filiales'];
	$Valeur_nominale = $_POST['Valeur_nominale'];
	$Perte_2 = $_POST['Perte_2'];
	$Valeur_nette = $_POST['Valeur_nette'];

	$Valeurs_actions = array($Filiales, $Valeur_nominale,$Perte_2,$Valeur_nette );
		// new object Annexe 5

	$Tab_annexe_5 = new Tab_annexe_5();

	$Tab_annexe_5->date = htmlentities(trim($_POST['date_annexe']));
	$Tab_annexe_5->id_societe = $nav_societe->id_societe;
	$Tab_annexe_5->random = $random_number;
	


	if (empty($errors)){
if ($Tab_annexe_5->existe()) {
			$msg_error = '<p >  article  existe déja !!!</p><br />';
			
		}else{
			$Tab_annexe_5->save();
			
 						echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.success(" Annexe  Ajouter avec succès","Très bien !");
        },300);
        });
			</script>';

 		$annexe_5 = Tab_annexe_5::trouve_par_random($random_number);

 			for($i=0;$i<count($Valeurs_creances[0]);$i++){
			$valeurs_creance = new Tab_releve_pertes_valeurs_creances();
			$valeurs_creance->id_annexe= $annexe_5->id;
			$valeurs_creance->Designation_debiteurs= $Valeurs_creances[0][$i];
			$valeurs_creance->Valeur_creance= $Valeurs_creances[1][$i];
			$valeurs_creance->Perte_valeur_constituee =  $Valeurs_creances[2][$i];
			$valeurs_creance->date =  $Tab_annexe_5->date;
			$valeurs_creance->save();
			}


 			for($i=0;$i<count($Valeurs_actions[0]);$i++){
			$valeurs_action = new Tab_releve_pertes_valeurs_actions();
			$valeurs_action->id_annexe= $annexe_5->id;
			$valeurs_action->Filiales= $Valeurs_actions[0][$i];
			$valeurs_action->Valeur_nominale= $Valeurs_actions[1][$i];
			$valeurs_action->Perte_valeur_constituee =  $Valeurs_actions[2][$i];
			$valeurs_action->Valeur_nette =  $Valeurs_actions[3][$i];
			$valeurs_action->date =  $Tab_annexe_5->date;
			$valeurs_action->save();
			}
		
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
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id_piece = htmlspecialchars(trim($_GET['id'])); 
	 }

		// upload saisie	
	if($action == 'upload' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$Upload = Pieces_comptables:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$Upload = Pieces_comptables:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object Upload
		
	
	 $Upload->facture_scan = htmlentities(trim($_POST['id_scan']));

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($Upload->save()){
			
					
		$msg_positif = '<p >  Facture N° : <b>' . $Upload->id_facture . '</b> est bien ajouter - <a href="saisie.php?action=list_pieces">  Liste Pièces comptables</a> </p><br />';
													
														
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
		if ( (isset($_GET['id_scan'])) && (is_numeric($_GET['id_scan'])) ) { 
 	$id = $_GET['id_scan']; 
	$edit_upload = Upload:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id_scan'])) &&(is_numeric($_POST['id_scan'])) ) { 
		 $id = $_POST['id_scan'];
	$edit_upload= Upload:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		 $edit_upload->status = 1;
		 $edit_upload->save();
		
		
}


		
	
	}
					?>


	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="container-fluid">
			<!-- BEGIN PAGE CONTENT-->
			
			<!-- BEGIN PAGE HEADER-->
			
			<div class="page-bar">
				<ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Comptabilité</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'list_pieces' || $action == 'list_annexe_5'|| $action == 'add_annexe_5' || $action == 'annexe_5' || $action == 'save_5' || $action == 'edit_annexe_5' ) { ?>
                        <a href="#"><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;
						
						} ?></a> 
                        
                        
                    <?php }elseif ($action == 'add_pieces' or $action == 'comptableser' ) {
                        echo '<a href="saisie.php?action=add_pieces">Créer pièce comptables </a> ';
                    } elseif ($action == 'edit_piece') {
                        echo '<a href="saisie.php?action=edit_importation">Modifier pièce comptable</a> ';
                    } elseif ($action == 'releve_comptes') {
                        echo '<a href="saisie.php?action=releve_comptes">Relevé des Comptes de Trésorerie</a> ';
                    }elseif ($action == 'add_releve') {
                        echo '<a href="saisie.php?action=add_releve">Ajouter Relevé des Comptes de Trésorerie</a> ';
                    }  
					?>
                    </li>
				</ul>

			</div>
	
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {
				if ($action == 'list_pieces') {
				
				?>
			<div class="row">
				<div class="col-md-12">

				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				if (isset($_POST['submit']) ) {
				
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$Pieces = Pieces_comptables::trouve_pieces_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				
				}else{
				$Pieces = Pieces_comptables::trouve_pieces_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}

				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-edit font-blue-hoki"></i>Liste Pièces comptables 
							</div>
						</div>
				<div class="col-md-4">
					<a href="saisie.php?action=add_pieces" class="btn yellow-crusta ">Nouveaux  <i class="fa fa-plus"></i></a>
					</div>
				<div class="col-md-8">
					<!-- BEGIN FORM-->
						<form action="<?php echo $_SERVER['PHP_SELF']?>?action=list_pieces" method="POST" class="form-horizontal">

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
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr>
								<th>
									N° piece
								</th>
								<th>
									Date
								</th>
								<th>
									Référence
								</th>
								<th>
									Libellé
								</th>
								<th>
									Total débit
								</th>
								<th>
								 Tolal	crédit
								</th>
								<th>
									Journal
								</th>
								<th>
									Scan
								</th>
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
							<?php
								foreach($Pieces as $piece){
									$cpt ++;
								?>
							<tr>
								<td>
									<a href="piece.php?id=<?php echo $piece->id ?>" class="">
								<i class="fa fa-file-text-o bg-yellow"></i>
									<b> <?php if (isset($piece->id)) {
										// echo $piece->id;
									 echo sprintf("%04d", $piece->id) ;
									} ?></b> <i class="fa fa-download font-blue"></i> </a>
								</td>
								<td>
									<?php if (isset($piece->date)) {
									echo fr_date2($piece->date);
									} ?>
								</td>
								<td>
									<?php if (isset($piece->ref_piece)) {
									echo $piece->ref_piece;
									} ?>
								</td>
								<td>
									<?php if (isset($piece->libelle)) {
									echo $piece->libelle;
									} ?>
								</td>
								<td>
									<?php if (isset($piece->somme_debit)) {

									echo number_format($piece->somme_debit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($piece->somme_credit)) {
									echo number_format($piece->somme_credit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($piece->journal)) {
									 $Journal = Journaux::trouve_par_id($piece->journal); 
									 if (isset($Journal->intitule)) {echo $Journal->intitule;}
									} ?>
								</td>
								<td>
									<?php if (!empty($piece->facture_scan)) {
										 $file = str_replace (" ", "_", $nav_societe->Dossier );
										 $ScanImage = Upload::trouve_par_id($piece->facture_scan);
									echo '<a href="scan/upload/'.$file.'/'.$ScanImage->img .'" class="btn bg-green-jungle fancybox-button btn-xs" ><i class="fa fa-eye"></i></a>';
									} ?>
									
								</td>
								<td>
									
									<a href="saisie.php?action=edit_piece&id=<?php echo $piece->id; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									
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
			</div>
			<!-- BEGIN Ecritures Comptables-->
			<?php } else	if ($action == 'list_annexe_5') {
				
				?>
				<div class="row">
				<div class="col-md-12">
					<div class="notification"></div>
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				if (isset($_POST['submit']) ) {
				
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$Annexes = Tab_annexe_5::trouve_tab_annexe_5_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				
				}else{
					$Annexes = Tab_annexe_5::trouve_tab_annexe_5_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}

				
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-edit font-blue-hoki"></i>Liste Annexes 
							</div>
						</div>
						<div class="col-md-4">
							<a href="saisie.php?action=add_annexe_5" class="btn yellow-crusta "><i class="fa fa-plus"></i> Nouveaux Annexe</a>
						</div>
						<div class="col-md-8">
										
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=list_annexe_5" method="POST" class="form-horizontal">

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
							
						<div class="portlet-body ">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr>
								<th>
									N° annexe
								</th>
								<th>
									Date
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
							<?php
								foreach($Annexes as $Annexe){ 
									$cpt ++;
								?>
							<tr id="anex5_<?php echo $Annexe->id; ?>">
								<td>
									<a href="saisie.php?action=annexe_5&id=<?php echo $Annexe->id; ?>" class="">
								<i class="fa fa-file-text-o bg-yellow"></i>
									<b> <?php if (isset($Annexe->id)) {
										// echo $piece->id;
									 echo sprintf("%04d", $cpt) ;
									} ?></b>  </a>
								</td>
								<td>
									<?php if (isset($Annexe->date)) {
									echo fr_date2($Annexe->date);
									} ?>
								</td>
								<td>
									<button id="del_annex5" value="<?php echo $Annexe->id; ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_annex5" data-toggle="modal"></i> </button>
									<a href="saisie.php?action=edit_annexe_5&id=<?php echo $Annexe->id; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									
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
		<?php } else	if ($action == 'save_5' ||  $action == 'annexe_5') {

				?>
					<page size="A4" style="height: 290mm;"> 
					<div class="portlet light" style="padding: 0px 20px 15px 10px;">
					<div class="portlet-body" >
				<div class="invoice">
					<div class="page-header" style="margin: 0px;">
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								<div class="col-xs-4 ">
									<p style="text-align: center ; font-size: 14px; border: solid; padding: 0px;" > <small>IMPRIME DESTINE AU CONTRIBUABLE</small>
									</p>
								</div>
								<div class="col-xs-2">
								</div>
								<div class="col-xs-5">
									<?php $nif = str_split($nav_societe->Mf) ?>
									<table border="1" width="100%" >
										<tr>
											<td style="text-align:center;padding-right: 4px; padding-left:4px; " >N.I.F</td>
											<?php foreach ($nif as $nif) { ?>
											<td style="text-align:center; padding-right: 4px; padding-left:4px; ">  <?php echo  $nif[0];    ?></td>
										<?php } ?>
										</tr>
									</table>
									
								</div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >

								<div class="col-xs-9 ">
									<p style="text-align: left ; font-size: 14px; border: solid 2px;padding-left: 10px; font-weight: 500;line-height: 22px;margin-left: 30px ; margin-bottom: 0px;" ><b>  Désignation de l’entreprise : </b><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
									<br><b> Activité : </b><?php if (isset($nav_societe->Activite)){echo $nav_societe->Activite ;} ?>
									<br><b> Adresse : </b><?php if (isset($nav_societe->Adresse)){echo $nav_societe->Adresse ;} ?>
									
									</p>
								</div>
								<div class="col-xs-2"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<table border="1" width="100%" style="margin: 7px 0px 5px 0px; ">
									<tr>
										<td style="text-align:center;"> Exercice du</td>
										<td style="text-align:center;"> <?php echo fr_date3($annexe_5->date); ?></td>
										<td style="text-align:center;"> au</td>
										<td style="text-align:center;"> <?php echo fr_date3($annexe_5->date); ?></td>
									</tr>
								</table>
									
								</div>
								<div class="col-xs-3"></div>
						</div>
						<div class="row invoice-logo " style="margin-bottom: 0px;" >
								
								<div class="col-xs-6 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										8/1 Relevé des pertes de valeurs sur créances :
										
									</p>
									
								</div>
								<div class="col-xs-6"></div>
						</div>
							
					</div>
				<div class="row">
					<div class="col-xs-12 table-responsive">
						<table border="1" width="100%"  >
								
								<tr class="badr">
									<td align="center" ><b>Désignation des débiteurs</b></td>
									<td align="center" ><b>Valeur de la créance</b></td>
									<td align="center" ><b>Perte de valeur constituée</b></td>
								</tr>
								<?php if (isset($annexe_5->id)) {
									$Tab_valeurs_creances = Tab_releve_pertes_valeurs_creances::trouve_par_id_annexe($annexe_5->id);
								} 
								foreach ($Tab_valeurs_creances as $Tab_valeurs_creance) {
								  ?>
								<tr>
									<td class="bilan-td" style="text-align:left; padding-left: 10px;padding-right: 10px; " ><?php if (isset($Tab_valeurs_creance->Designation_debiteurs)) { echo $Tab_valeurs_creance->Designation_debiteurs; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_creance->Valeur_creance)) { echo $Tab_valeurs_creance->Valeur_creance; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_creance->Perte_valeur_constituee)) { echo $Tab_valeurs_creance->Perte_valeur_constituee; } ?></td>
								</tr>
								<?php } ?>
							</table>

								<div class="row invoice-logo " style="margin-bottom: 0px; margin-top: 15px;" >
								
								<div class="col-xs-8 ">
									<p class="badr" style="text-align:left ; padding-left: 10px; border: solid 2px;box-shadow: 3px 3px;text-decoration: underline;text-underline-position: under;font-size: 16px;">

										8/2 Relevé des pertes de valeurs sur actions et parts sociales :
										
									</p>
									
								</div>
								<div class="col-xs-4"></div>
						</div>
						<br>
							
							<table border="1" width="100%"  >
								<tr class="badr">
									<td align="center" width="25%"><b>Filiales </b></td>
									<td align="center" width="25%" ><b>Valeur nominale au début de l’exercice </b></td>
									<td align="center" width="25%" ><b>Perte de valeur constituée</b></td>
									<td align="center" width="25%" ><b>Valeur nette comptable</b></td>
								</tr>
								<?php if (isset($annexe_5->id)) {
									$Tab_valeurs_actions = Tab_releve_pertes_valeurs_actions::trouve_par_id_annexe($annexe_5->id);
								}   
								foreach ($Tab_valeurs_actions as $Tab_valeurs_action) {
								  ?>
								<tr>
									<td class="bilan-td" style="text-align:left; padding-left: 10px;padding-right: 10px; " ><?php if (isset($Tab_valeurs_action->Filiales)) { echo $Tab_valeurs_action->Filiales; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Valeur_nominale)) { echo $Tab_valeurs_action->Valeur_nominale; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Perte_valeur_constituee)) { echo $Tab_valeurs_action->Perte_valeur_constituee; } ?></td>
									<td style="text-align:right; padding-right: 5px;"><?php if (isset($Tab_valeurs_action->Valeur_nette)) { echo $Tab_valeurs_action->Valeur_nette; } ?></td>
								</tr>
								<?php } ?>
								</table>

					</div>
				</div>
			</div>

				</div>
			</div>
		</page>
		<?php } else	if ($action == 'add_annexe_5') {
				
				?>
				<div class="row">
				<div class="col-md-12">

				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$Annexes = Tab_annexe_5::trouve_annexe_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
					
						<div class="portlet-title">
							
							<div class="caption  bold">
								Relevé des pertes de valeurs sur créances 
							</div>
						</div>
					<form action="<?php echo $_SERVER['PHP_SELF']?>?action=save_5" method="POST"  class="form-horizontal" enctype="multipart/form-data">
							
						<div class="portlet-body form">
							<div class="row">
								<div class="col-md-12"style="margin-top: 20px;">
									<div class="form-group ">
													<label class="col-md-3 control-label">Date  </label>
													<div class="col-md-7">
														
															<input type="date" name = "date_annexe" id="date_comptable" class="form-control" placeholder="Date "  
															value="<?php echo   $thisday;  ?>" required>
															
														</div>
														
											</div>
								</div>
							</div>
						
						<div class="row" >

										
									<div class="col-md-10">
									<div class="form-group">
										<div class="table-responsive">
                    				<table id="items" class="table table-bordered table-hover" >
		
		  								<tr>
		      								<th width="40%">Désignation des débiteurs</th>
		      								<th>Valeur de la créance</th>
		      								<th>Perte de valeur constituée</th>
		      								<th>#</th>
		  								</tr>
		  								<tr class="item-row">
		      								<td><input required  type="text" name="Designation[]" id="Designation" min="0" class="form-control" >	</td>
		      								<td><input required type="number" name="Valeur[]" id="Valeur" min="0" class="form-control" ></td>
		      								<td><input required type="number" name="Perte_1[]" id="Perte_1" min="0" class="form-control" ></td>
		      								<td>
		      								</td>
		  								</tr>
		  								<tr>
		  									<td colspan="3"></td>
		  									<td><a id='add_pertes_valeurs' href="javascript:;" title="Ajouter Banque" class="btn btn-primary"><i class="fa fa-plus" ></i></a></td>
		  								</tr>
									</table>
                						</div>		
									</div>
									</div>

									</div>
						
						</div>
						<hr>
						<div class="portlet-title">
							
							<div  class="bold" style="color: #666;padding: 10px 0;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;" >
								Relevé des pertes de valeurs sur actions et parts sociales  
							</div>
							<hr>
						</div>
						<div class="portlet-body form">
							<div class="row" >
										
									<div class="col-md-10">
									<div class="form-group">
										<div class="table-responsive">
                    				<table id="tab_actions" class="table table-bordered table-hover" >
									<thead>
		  								<tr>
		      								<th width="40%">Filiales</th>
		      								<th>Valeur nominale au début de l’exercice</th>
		      								<th>Perte de valeur constituée</th>
		      								<th>Valeur nette comptable</th>
		      								<th>#</th>
		  								</tr>
		  							</thead>
		  								<tbody>
		  								<tr class="item-row2">
		      								<td><input required type="text" name="Filiales[]" id="Filiales" min="0" class="form-control" >	</td>
		      								<td><input required type="number" name="Valeur_nominale[]" id="Valeur_nominale" min="0" class="form-control Valeur_nominale" ></td>
		      								<td><input required type="number" name="Perte_2[]" id="Perte_2" min="0" class="form-control Perte_2" ></td>
		      								<td><input  type="number" name="Valeur_nette[]" readonly id="Valeur_nette" min="0" class="form-control Valeur_nette" ></td>

		      								<td></td>
		  								</tr>
		  								<tr>
		  									<td colspan="4"></td>
		  									<td><a id='add_valeurs_actions' href="javascript:;" title="Ajouter Banque" class="btn btn-primary"><i class="fa fa-plus" ></i></a></td>
		  								</tr>
		  								</tbody>
									</table>
                						</div>		
									</div>
									</div>

									</div>
						
						</div>
						<div class="panel-footer   " align="right">
							<button type="submit" name="submit"  class="btn  green "  >   AJOUTER </button>   
								
						    </div>
					</form>
					</div>
                                          
					
				</div>
				
			</div>
			<?php } else	if ($action == 'edit_annexe_5') {
				
				?>
				<div class="row">
				<div class="col-md-12">

				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$Annexes = Tab_annexe_5::trouve_annexe_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
					
						<div class="portlet-title">
							
							<div class="caption  bold">
								Relevé des pertes de valeurs sur créances 
							</div>
						</div>
					<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"  class="form-horizontal" enctype="multipart/form-data">
							
						<div class="portlet-body form">
							<div class="row">
								<div class="col-md-12"style="margin-top: 20px;">
									<div class="form-group ">
													<label class="col-md-3 control-label">Date  </label>
													<div class="col-md-7">
														
															<input type="date" name = "date_annexe" id="date_comptable" class="form-control" placeholder="Date "  
															value="<?php if (isset($annexe_5->date)) { echo $annexe_5->date; } ?>" required>
															
														</div>
														
											</div>
								</div>
							</div>
						
						<div class="row" >

										
									<div class="col-md-10">
									<div class="form-group">
										<div class="table-responsive">
                    				<table id="items" class="table table-bordered table-hover" >
		
		  								<tr>
		      								<th width="40%">Désignation des débiteurs</th>
		      								<th>Valeur de la créance</th>
		      								<th>Perte de valeur constituée</th>
		      								<th>#</th>
		  								</tr>
								<?php  $Tab_valeurs_creances = Tab_releve_pertes_valeurs_creances::trouve_par_id_annexe($annexe_5->id);
								$cpt=0;
								foreach ($Tab_valeurs_creances as $Tab_valeurs_creance) { $cpt ++?>
		  								<tr class="item-row">
		      								<td><input required  type="text" name="Designation[]" id="Designation" min="0" class="form-control" value="<?php if (isset($Tab_valeurs_creance->Designation_debiteurs)) { echo $Tab_valeurs_creance->Designation_debiteurs; } ?>" >	</td>
		      								<td><input required type="number" name="Valeur[]" id="Valeur" min="0" class="form-control" value="<?php if (isset($Tab_valeurs_creance->Valeur_creance)) { echo $Tab_valeurs_creance->Valeur_creance; } ?>" ></td>
		      								<td><input required type="number" name="Perte_1[]" id="Perte_1" min="0" class="form-control" value="<?php if (isset($Tab_valeurs_creance->Perte_valeur_constituee)) { echo $Tab_valeurs_creance->Perte_valeur_constituee; } ?>" ></td>
		      								<td>
		      									<?php if ($cpt > 1 ) {?>
		      										<a class="btn btn-danger " id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash"></i></a>
		      									<?php } ?>
		      								</td>
		  								</tr>
		  							<?php } ?>
		  								<tr>
		  									<td colspan="3"></td>
		  									<td><a id='add_pertes_valeurs' href="javascript:;" title="Ajouter Banque" class="btn btn-primary"><i class="fa fa-plus" ></i></a></td>
		  								</tr>
									</table>
                						</div>		
									</div>
									</div>

									</div>
						
						</div>
						<hr>
						<div class="portlet-title">
							
							<div  class="bold" style="color: #666;padding: 10px 0;display: inline-block;font-size: 18px;line-height: 18px;padding: 10px 0;" >
								Relevé des pertes de valeurs sur actions et parts sociales  
							</div>
							<hr>
						</div>
						<div class="portlet-body form">
							<div class="row" >
										
									<div class="col-md-10">
									<div class="form-group">
										<div class="table-responsive">
                    				<table id="tab_actions" class="table table-bordered table-hover" >
									<thead>
		  								<tr>
		      								<th width="40%">Filiales</th>
		      								<th>Valeur nominale au début de l’exercice</th>
		      								<th>Perte de valeur constituée</th>
		      								<th>Valeur nette comptable</th>
		      								<th>#</th>
		  								</tr>
		  							</thead>
		  								<tbody>
		  									<?php  $Tab_valeurs_actions = Tab_releve_pertes_valeurs_actions::trouve_par_id_annexe($annexe_5->id);
		  									$cpt_1 =0;
								foreach ($Tab_valeurs_actions as $Tab_valeurs_action) { $cpt_1++;
								  ?>
		  								<tr class="item-row2">
		      								<td><input required type="text" name="Filiales[]" id="Filiales" min="0" class="form-control" value="<?php if (isset($Tab_valeurs_action->Filiales)) { echo $Tab_valeurs_action->Filiales; } ?>" > 	</td>
		      								<td><input required type="number" name="Valeur_nominale[]" id="Valeur_nominale" min="0" class="form-control Valeur_nominale" value="<?php if (isset($Tab_valeurs_action->Valeur_nominale)) { echo $Tab_valeurs_action->Valeur_nominale; } ?>" ></td>
		      								<td><input required type="number" name="Perte_2[]" id="Perte_2" min="0" class="form-control Perte_2" value="<?php if (isset($Tab_valeurs_action->Perte_valeur_constituee)) { echo $Tab_valeurs_action->Perte_valeur_constituee; } ?>" ></td>
		      								<td><input  type="number" name="Valeur_nette[]" readonly id="Valeur_nette" min="0" class="form-control Valeur_nette" value="<?php if (isset($Tab_valeurs_action->Valeur_nette)) { echo $Tab_valeurs_action->Valeur_nette; } ?>" ></td>

		      								<td>
		      									<?php if ($cpt_1 > 1 ) {?>
		      										<a class="btn btn-danger " id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash"></i></a>
		      									<?php } ?>
		      								</td>
		  								</tr>
		  							<?php } ?>
		  								<tr>
		  									<td colspan="4"></td>
		  									<td><a id='add_valeurs_actions' href="javascript:;" title="Ajouter Banque" class="btn btn-primary"><i class="fa fa-plus" ></i></a></td>
		  								</tr>
		  								</tbody>
									</table>
                						</div>		
									</div>
									</div>

									</div>
						
						</div>
						<div class="panel-footer   " align="right">
							<input type="hidden" name="id" value="<?php if (isset($annexe_5->id)) { echo $annexe_5->id; } ?>" >
							<button type="submit" name="update"  class="btn  green "  >   MODIFER </button>   
								
						    </div>
					</form>
					</div>
                                          
					
				</div>
				
			</div>
			 <?php 

				}elseif ($action == 'list_ecriture') {

				if (isset($_POST['submit']) ) {
				
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$Ecritures = Ecriture_comptable::trouve_ecriture_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				
				}else{
				$Ecritures = Ecriture_comptable::trouve_ecriture_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				}
					?>
			<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa fa-edit font-yellow"></i>Ecritures Comptables 
							</div>
						</div>
					<div class="col-md-8">
					<!-- BEGIN FORM-->
						<form action="<?php echo $_SERVER['PHP_SELF']?>?action=list_ecriture" method="POST" class="form-horizontal">

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
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr>
								<th>
									N° piece
								</th>
								<th>
									Date
								</th>
								<th>
									Référence
								</th>
								<th>
									Libellé
								</th>
								<th>
									Compte comptable
								</th>
								<th>
									Auxilière
								</th>
								<th>
									Débit
								</th>
								<th>
								 Crédit
								</th>
								<th>
									Journal
								</th>
								
							</tr>
							</thead>
							<tbody>
							<?php
								foreach($Ecritures as $ecriture){
									$cpt ++;
								?>
							<tr>
								<td>
									<a href="piece.php?id=<?php echo $ecriture->id_piece ?>" class="">
								<i class="fa fa-pencil font-yellow"></i>
									<b> <?php if (isset($ecriture->id_piece)) {
										// echo $piece->id;
									 echo sprintf("%04d", $ecriture->id_piece) ;
									} ?></b> <i class="fa fa-download font-blue"></i> </a>
								</td>
								<td>
									<?php if (isset($ecriture->date)) {
									echo fr_date2($ecriture->date);
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->ref_piece)) {
									echo $ecriture->ref_piece;
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->lib_piece)) {
									echo $ecriture->lib_piece;
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->code_comptable)) {
									echo $ecriture->code_comptable;
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->id_auxiliere)) {
										$Auxilieres = Auxiliere::trouve_par_id($ecriture->id_auxiliere);
									echo $Auxilieres->code;
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->debit)) {

									echo number_format($ecriture->debit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->credit)) {
									echo number_format($ecriture->credit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($ecriture->journal)) {
									 $Journal = Journaux::trouve_par_id($ecriture->journal); 
									 if (isset($Journal->intitule)) {echo $Journal->intitule;}
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
				
			</div>

			<?php  

				}elseif ($action == 'add_pieces' or $action == 'comptableser') {	
						
						$journaux = Journaux:: trouve_tous();
						$Compte_comptables = Compte_comptable:: trouve_compte_comptable_par_societe($nav_societe->id_societe);
						$Ecriture_comptables = Ecriture_comptable::trouve_compte_vide_par_admin($user->id,$nav_societe->id_societe);
						 $nbr_ecriture = count($Ecriture_comptables);
						$somme_debit = Ecriture_comptable::somme_debit($user->id,$nav_societe->id_societe); 
						$somme_credit = Ecriture_comptable::somme_credit($user->id,$nav_societe->id_societe);
				if (!empty($Ecriture_comptables)) {
					$last_Ecriture = Ecriture_comptable::trouve_last_ecriture_par_id_admin($user->id,$nav_societe->id_societe);
					
					}
				  ?>
				  	<div class="show-facture">
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


                                <div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Pièce comptable 
							</div>
						</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
						<form action="#" class="form-horizontal">
										   <div class="panel-body">                                                                        
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<div class="form-group ">
                                                <label class="col-md-3 control-label "> Journal </label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control select2me"    name="id_Journal" id="id_Journal"  placeholder="Choisir journal" >
															<option value=""></option>
														<?php  foreach ($journaux as $journal) { ?>
																<option <?php if (isset($last_Ecriture->journal)) {
																		if ($last_Ecriture->journal == $journal->id) {echo "selected";}
																	} ?> value="<?php if(isset($journal->id)){echo $journal->id; } ?>"><?php if (isset($journal->id)) {echo $journal->intitule;} ?> </option>
																<?php } ?>	
																	   
														</select>   
														<div class="form-control-focus">
														</div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                    		
                                            <div class="form-group ">
													<label class="col-md-3 control-label">Référence </label>
													<div class="col-md-6">
														
															<input type="text" name = "reference" id="reference" class="form-control" placeholder="Référence " value="<?php if (isset($last_Ecriture->ref_piece)) {echo $last_Ecriture->ref_piece;}  ?>"   required>
															
														</div>
														
											</div>
										</div>
                                	</div>
                                	<div class="row">
                                       
                                        <div class="col-md-6">
                                    		
                                            <div class="form-group ">
													<label class="col-md-3 control-label">Date comptable </label>
													<div class="col-md-7">
														
															<input type="date" name = "date_comptable" id="date_comptable" class="form-control" placeholder="Date "  
															value="<?php if (isset($last_Ecriture->date)) {echo $last_Ecriture->date;} else { echo   $thisday;}  ?>" required>
															
														</div>
														
											</div>
										</div>
										<div class="col-md-6">
                                    		
                                            <div class="form-group ">
													<label class="col-md-3 control-label">libellé </label>
													<div class="col-md-6">
														
															<input type="text" name = "libelle" id="libelle" class="form-control" placeholder="Désignation " value="<?php if (isset($last_Ecriture->lib_piece)) {echo $last_Ecriture->lib_piece;}  ?>"  required>
															
														</div>
														
											</div>
										</div>
                                	</div>
                                </div>	
                            </form>
								</div>			
										
										<!-- END FORM-->
									</div>
								
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Liste Ecritures
							</div>
						</div>
						<div class="portlet-body notification">
						<table class="table table-striped table-bordered table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="30%">
									Compte
								</th>
								<th >
									Date
								</th>

								<th width="10%">
									 Aux 
								</th>
								<th width="10%">
									 Débit
								</th>
								<th width="10%">
									Crédit
								</th>
								<th width="10%">
									Annexe Fiscale
								</th>
								<th>
									Etat
								</th>
								<th >
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($Ecriture_comptables as $Ecriture_comptable){ $cpt ++; ?>
							<tr class="item-row" id="<?php if (isset($Ecriture_comptable->id)) {
										echo $Ecriture_comptable->id;
									} ?>">
								
								<td>
									<?php if (isset($Ecriture_comptable->id_compte)) {
										$Compte = Compte_comptable::trouve_par_id($Ecriture_comptable->id_compte);
										if (isset($Compte->id)) {echo $Compte->code;  echo  ' |  ' . $Compte->libelle ;}
									} ?>
									
								</td>
								<td>
									
									<span class="editSpanDate">
										<?php if (isset($Ecriture_comptable->date)) {
										echo $Ecriture_comptable->date;
									} ?>
									</span>
									<input type="date" name = "Date_ecriture" id="Date_ecriture" min="0"  value="<?php if (isset($Ecriture_comptable->date)) {
										echo $Ecriture_comptable->date;} ?>" class="form-control Date_ecriture " style=" display: none;"  placeholder="Débit "  >
								</td>

								<td>
									
									<?php if (!empty($Ecriture_comptable->id_auxiliere)) {
									 $Auxiliere = Auxiliere::trouve_par_id($Ecriture_comptable->id_auxiliere);
									 if (isset($Auxiliere->libelle)) { echo  $Auxiliere->code.' | '.$Auxiliere->libelle; }
									} else { echo "/"; }?>
									 
								
									 
								</td>
								<td >
									<span class="editSpanDebit">
										<?php if (isset($Ecriture_comptable->debit)) {
										echo number_format($Ecriture_comptable->debit , 2, ',', ' ');
									} ?>
									</span>
									
									<input type="number" name = "Debit" id="debit" min="0"  value="<?php if (isset($Ecriture_comptable->debit)) {
										echo $Ecriture_comptable->debit;} ?>" class="form-control Debit " style=" display: none;"  placeholder="Débit "  >
								</td>
								<td>
									<span class="editSpanCredit">
										<?php if (isset($Ecriture_comptable->credit)) {
										echo number_format($Ecriture_comptable->credit , 2, ',', ' ');
									} ?>
									</span>
									 <input type="number" name = "Credit" id="credit" min="0" value="<?php if (isset($Ecriture_comptable->credit)) {
										echo $Ecriture_comptable->credit;} ?>" class="form-control Credit" style=" display: none;" placeholder="Crédit "   >
								</td>
								 <td>
								 	<span class="editSpanAnnexe_Fiscale">
										<?php if (isset($Ecriture_comptable->Annexe_Fiscale)) {
										echo number_format($Ecriture_comptable->Annexe_Fiscale , 2, ',', ' ');
									} ?>
									</span>
									
									<input type="number" name = "Annexe_Fiscale" id="annexe_Fiscale" min="0"  value="<?php if (isset($Ecriture_comptable->Annexe_Fiscale)) {
										echo $Ecriture_comptable->Annexe_Fiscale;} ?>" class="form-control Annexe_Fiscale " style=" display: none;"  placeholder="Annexe_Fiscale "  >
								 	
								 </td>
								<td class="Etat-ecriture" > 
								<?php  if ($somme_debit->somme_debit == $somme_credit->somme_credit) {
								echo '<span class="font-green"><strong>Équilibré</strong></span>' ;} else { echo '<span class="font-red"><strong>Déséquilibré</strong></span>' ; }  ?>
								</td> 
								
								<td>
									<button type="button" class="btn  btn-info btn-sm editBtn" style="float: none;"><span class="glyphicon glyphicon-pencil"></span></button>
									  <button type="button" class="btn green-jungle btn-sm saveBtn" style="float: none; display: none;"><i class="fa fa-save"></i></button>
									<button  id="delete"  value="<?php if (isset($Ecriture_comptable->id)){ echo $Ecriture_comptable->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							<tbody>
								
							<tr class="info-compte" >
								
								<td>
									<select class="form-control  select2me"   id="id_compte"  name="id_compte"   placeholder="Choisir Compte" >
															<option value=""></option>
														<?php  foreach ($Compte_comptables as $Compte_comptable) { ?>
																	<option value="<?php if(isset($Compte_comptable->id)){echo $Compte_comptable->id; } ?>"><?php if (isset($Compte_comptable->id)) {echo $Compte_comptable->code;  echo  ' |  ' . $Compte_comptable->libelle ;} ?> </option>
																<?php } ?>														   
														</select>   
								</td>
								
								<td>
                                   
                                   
                                </td>

								<td></td>
								<td>
	
								</td>
								<td>
									<input type="hidden" id="ref" value="" >
									<input type="hidden" id="lib" value="">
									<input type="hidden" id="Journal" value=""> 
									<input id="date" type="hidden" value=""  >
								</td>

									<td>
										
									</td>
									<td></td>
								<td>
									 <button style="width: 72px;" class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody> 
							<tbody class="total">
								<tr>
									<td colspan="3"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL  : </strong></span></td>
									<td colspan="1" id="TOTALdebit" style="font-size: 14px;"><?php  if(isset($somme_debit->somme_debit)){echo  number_format($somme_debit->somme_debit , 2, ',', ' ');} else {echo "0.00";}  ?> </td>
									<td colspan="1" id="TOTALcredit" style="font-size: 14px;"><?php  if(isset($somme_credit->somme_credit)){echo number_format($somme_credit->somme_credit , 2, ',', ' ') ;} else {echo "0.00";}  ?> </td>
									<?php if ($somme_debit->somme_debit > $somme_credit->somme_credit) { $diff = $somme_debit->somme_debit - $somme_credit->somme_credit;  }else { $diff = $somme_credit->somme_credit - $somme_debit->somme_debit; } ?>
									<td></td>
									<td colspan="2" id="Diff" >
											<?php if ($diff > 0 ) {
												echo "Différence : ".number_format($diff , 2, ',', ' ') ;
											}  ?>
										</td>

							    </tr>
							   

										
                          			  </tbody> 
							</table>
							
						</div>
							<div class="panel-footer " align="right">
							<a id="Enregistrer_paiement" disabled class="btn  green "  > <i class="fa fa-credit-card"></i>  COMPTABILISER </a>   
								
						    </div>	

						</div>
					
				</div>
				<div class="col-md-4 list-group-item bg-blue-ebonyclay">
					
							<p>Scan du Facture Pièce comptable</p>
				
				</div>
				<div class="col-md-4 list-group-item bg-blue-chambray margin-bottom-30">
				<?php
					if (isset($_GET['id_img'])) {
					 $image =  htmlspecialchars($_GET['id_img']) ;
					 
					 $img_select = Upload::trouve_par_id ($image);
					  
					}else{
							echo '<p> aucune facture sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($image)){?>
				
					
					<img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   >
					<a href="#form_modal12" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
					<a href="#form_modal12" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
					<a href="#form_modal12" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
				
				<?php }else {echo '<a href="#form_modal12" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>	
			
			</div>

			
		</div>

			<!-- PAGE PAGE ADD-->
			
			<?php  }elseif ($action == 'edit_piece') {	
						$Pieces_comptables = Pieces_comptables::trouve_par_id($id_piece);
						$thisday=date('Y-m-d');
						$journaux = Journaux:: trouve_tous();
						$Compte_comptables = Compte_comptable:: trouve_compte_comptable_par_societe($nav_societe->id_societe);
						$Ecriture_comptables = Ecriture_comptable::trouve_ecriture_par_piece($id_piece);
						 $nbr_ecriture = count($Ecriture_comptables);
						$somme_debit = Ecriture_comptable::somme_debit_par_piece($id_piece); 
						$somme_credit = Ecriture_comptable::somme_credit_par_piece($id_piece);
				if (!empty($Ecriture_comptables)) {
					$last_Ecriture = Ecriture_comptable::trouve_last_ecriture_par_id_piece($id_piece);
					
					}
				  ?>
				  	<div class="show-facture">
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


                                <div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Pièce comptable 
							</div>
						</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
						<form action="#" class="form-horizontal">
										   <div class="panel-body">                                                                        
                                    <div class="row">
                                        <div class="col-md-6">
                                        	<div class="form-group ">
                                                <label class="col-md-3 control-label "> Journal </label>
                                                <div class="col-md-7">                                                                                            
                                              
												<select class="form-control select2me"    name="id_Journal" id="id_Journal"  placeholder="Choisir journal" >
															<option value=""></option>
														<?php  foreach ($journaux as $journal) { ?>
																<option <?php if (isset($last_Ecriture->journal)) {
																		if ($last_Ecriture->journal == $journal->id) {echo "selected";}
																	} ?> value="<?php if(isset($journal->id)){echo $journal->id; } ?>"><?php if (isset($journal->id)) {echo $journal->intitule;} ?> </option>
																<?php } ?>	
																	   
														</select>   
														<div class="form-control-focus">
														</div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                    		
                                            <div class="form-group ">
													<label class="col-md-3 control-label">Référence </label>
													<div class="col-md-6">
														
															<input type="text" name = "reference" id="reference" class="form-control" placeholder="Référence " value="<?php if (isset($last_Ecriture->ref_piece)) {echo $last_Ecriture->ref_piece;}  ?>"   required>
															
														</div>
														
											</div>
										</div>
                                	</div>
                                	<div class="row">
                                       
                                        <div class="col-md-6">
                                    		
                                            <div class="form-group ">
													<label class="col-md-3 control-label">Date comptable </label>
													<div class="col-md-7">
														
															<input type="date" name = "date_comptable" id="date_comptable" class="form-control" placeholder="Date "  
															value="<?php if (isset($last_Ecriture->date)) {echo $last_Ecriture->date;} else { echo   $thisday;}  ?>" required>
															
														</div>
														
											</div>
										</div>
										<div class="col-md-6">
                                    		
                                            <div class="form-group ">
													<label class="col-md-3 control-label">libellé </label>
													<div class="col-md-6">
														
															<input type="text" name = "libelle" id="libelle" class="form-control" placeholder="Désignation " value="<?php if (isset($last_Ecriture->lib_piece)) {echo $last_Ecriture->lib_piece;}  ?>"  required>
															
														</div>
														
											</div>
										</div>
                                	</div>
                                </div>	
                            </form>
								</div>			
										
										<!-- END FORM-->
									</div>
								</div>
						</div>

			<div class="row">
		
				<div class="col-md-12">
					
						<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Liste Ecritures
							</div>
						</div>
						<div class="portlet-body notification">
						<table class="table table-striped table-bordered table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="35%">
									Compte
								</th>
								<th >
									Date
								</th>

								<th width="12%">
									 Aux 
								</th>
								<th width="12%">
									 Débit
								</th>
								<th width="12%">
									Crédit
								</th>
								<th>
									Etat
								</th>
								<th >
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($Ecriture_comptables as $Ecriture_comptable){ $cpt ++; ?>
							<tr class="item-row" id="<?php if (isset($Ecriture_comptable->id)) {
										echo $Ecriture_comptable->id;
									} ?>">
								
								<td>
									<?php if (isset($Ecriture_comptable->id_compte)) {
										$Compte = Compte_comptable::trouve_par_id($Ecriture_comptable->id_compte);
										if (isset($Compte->id)) {echo $Compte->code;  echo  ' |  ' . $Compte->libelle ;}
									} ?>
								</td>
								<td>
									<?php if (isset($Ecriture_comptable->date)) {
										echo $Ecriture_comptable->date;
									} ?>
								</td>

								<td>
									
									<?php if (!empty($Ecriture_comptable->id_auxiliere)) {
									 $Auxiliere = Auxiliere::trouve_par_id($Ecriture_comptable->id_auxiliere);
									 if (isset($Auxiliere->libelle)) { echo  $Auxiliere->code.' | '.$Auxiliere->libelle; }
									} else { echo "/"; }?>
									 
								
									 
								</td>
								<td >
									<span class="editSpanDebit">
										<?php if (isset($Ecriture_comptable->debit)) {
										echo number_format($Ecriture_comptable->debit , 2, ',', ' ');
									} ?>
									</span>
									
									<input type="number" name = "Debit" id="debit" min="0"  value="<?php if (isset($Ecriture_comptable->debit)) {
										echo $Ecriture_comptable->debit;} ?>" class="form-control Debit " style=" display: none;"  placeholder="Débit "  >
								</td>
								<td>
									<span class="editSpanCredit">
										<?php if (isset($Ecriture_comptable->credit)) {
										echo number_format($Ecriture_comptable->credit , 2, ',', ' ');
									} ?>
									</span>
									 <input type="number" name = "Credit" id="credit" min="0" value="<?php if (isset($Ecriture_comptable->credit)) {
										echo $Ecriture_comptable->credit;} ?>" class="form-control Credit" style=" display: none;" placeholder="Crédit "   >
								</td>
								<td class="Etat-ecriture" > 
								<?php  if ($somme_debit->somme_debit == $somme_credit->somme_credit) {
								echo '<span class="font-green"><strong>Équilibré</strong></span>' ;} else { echo '<span class="font-red"><strong>Déséquilibré</strong></span>' ; }  ?>
								</td> 
								 
								<td>
									<button type="button" class="btn  btn-info btn-sm editBtn" style="float: none;"><span class="glyphicon glyphicon-pencil"></span></button>
									  <button type="button" class="btn green-jungle btn-sm saveBtn" style="float: none; display: none;"><i class="fa fa-save"></i></button>
									<button  id="delete"  value="<?php if (isset($Ecriture_comptable->id)){ echo $Ecriture_comptable->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							<tbody>
								
							<tr class="info-compte" >
								
								<td>
									<select class="form-control  select2me"   id="id_compte"  name="id_compte"   placeholder="Choisir Compte" >
															<option value=""></option>
														<?php  foreach ($Compte_comptables as $Compte_comptable) { ?>
																	<option value="<?php if(isset($Compte_comptable->id)){echo $Compte_comptable->id; } ?>"><?php if (isset($Compte_comptable->id)) {echo $Compte_comptable->code;  echo  ' |  ' . $Compte_comptable->libelle ;} ?> </option>
																<?php } ?>														   
														</select>   
								</td>
								
								<td>
                                   
                                   
                                </td>

								<td></td>
								<td>
	
								</td>
								<td>
									<input type="hidden" id="ref" value="" >
									<input type="hidden" id="lib" value="">
									<input type="hidden" id="Journal" value=""> 
									<input id="date" type="hidden" value=""  >
								</td>

									<td>
										
									</td>
								<td>
									 <button style="width: 72px;" class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody> 
							<tbody class="total">
								<tr>
									<td colspan="3"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL  : </strong></span></td>
									<td colspan="1" id="TOTALdebit" style="font-size: 14px;"><?php  if(isset($somme_debit->somme_debit)){echo  number_format($somme_debit->somme_debit , 2, ',', ' ');} else {echo "0.00";}  ?> </td>
									<td colspan="1" id="TOTALcredit" style="font-size: 14px;"><?php  if(isset($somme_credit->somme_credit)){echo number_format($somme_credit->somme_credit , 2, ',', ' ') ;} else {echo "0.00";}  ?> </td>
									<?php if ($somme_debit->somme_debit > $somme_credit->somme_credit) { $diff = $somme_debit->somme_debit - $somme_credit->somme_credit;  }else { $diff = $somme_credit->somme_credit - $somme_debit->somme_debit; } ?>
									<td colspan="2" id="Diff" >
											<?php if ($diff > 0 ) {
												echo "Différence : ".number_format($diff , 2, ',', ' ') ;
											}  ?>
										</td>
							    </tr>
							   

										
                          			  </tbody> 
							</table>
							
						</div>
							<div class="panel-footer " align="right">
							<a id="Enregistrer_paiement" disabled class="btn  green "  > <i class="fa fa-credit-card"></i>  COMPTABILISER </a>   
								
						    </div>	

						</div>
					
				</div>
					
			</div>
		</div>
		
<!-- BEGIEN RELEVE DE COMPTE-->

			<?php }else if ($action =='releve_comptes'){?>
			<div class="col-md-12">

				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php
				if (isset($_POST['submit']) ) {
				
					$date_db = trim(htmlspecialchars($_POST['date_db']));
					$date_fin = trim(htmlspecialchars($_POST['date_fin']));
					 
					$releves =Releve_comptes::trouve_releve_par_societe_and_Exercice($nav_societe->id_societe,$date_db,$date_fin);

				
				}
				if (isset($_GET['id'])) {
					 $id_banque =  htmlspecialchars($_POST['id']) ;
					 
					 $releves = Releve_comptes::trouve_releve_par_id_banque ($id_banque);
					  
					}
				// $releves = Releve_comptes::trouve_releve_par_societe_and_Exercice($nav_societe->id_societe,$nav_societe->exercice_debut,$nav_societe->exercice_fin);
				$banques=  Compte::trouve_par_societe($nav_societe->id_societe); 
				$caisses=Caisse::trouve_par_societe($nav_societe->id_societe);
				 ?>

		<div class="row">
				<div class="col-md-12">

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-file font-yellow-crusta"></i>Relevé des Comptes de Trésorerie
							</div>
						</div>
					<div class="row ">
					
						<div class="col-md-4">
							<div class="form-group">
								
								<div class="col-md-10">
								<div class="input-group">
									<select class="form-control " id="banque"  name="id"   placeholder="Choisir dans la liste">
									<option>Selectionner dans la liste</option>
										
											<?php  foreach ($banques as $banque) {
												?>
												<option value="<?php if (isset($banque->id_banque)) {echo 'b_'.$banque->id_banque;}?>">
														<?php if (isset($banque->id_banque)) {$bank = Banque::trouve_par_id($banque->id_banque);
													if (isset($bank->Designation)) {
													echo $bank->Designation;
													} } ?>
												</option>
											<?php } ?>	
										
											<?php  foreach ($caisses as $caisse) { ?>
												<option value="<?php if(isset($caisse->id_caisse)){echo 'c_'.$caisse->id_caisse; } ?>"><?php if (isset($caisse->id_caisse)) {echo $caisse->Designation; } ?> </option>
											<?php } ?>	
									</select>
									<span class="input-group-addon ">
										<i class="fa fa-university font-yellow"></i>
									</span>									
								</div>					
								</div>
							
						
							</div>							
						</div>
						
						
					</div>
					
				<div class="row"> 
					<div class="portlet-body id_ti ">
				
					</div>
				</div>
                                          
					
				</div>
				
			</div>
			</div>
<!-- END RELEVE DE COMPTE-->

<!-- BEGIEN ADD RELEVE -->
	<?php  

				}elseif ($action == 'add_releve') {	
						
						$nature_operations = Nature_operation:: trouve_tous();
						$Fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 
						$banques= Banque::trouve_par_societe($nav_societe->id_societe);
						// $Compte_comptables = Compte_comptable:: trouve_compte_comptable_par_societe($nav_societe->id_societe);
						$releve_comptes = Releve_comptes::trouve_releve_par_societe($nav_societe->id_societe);
						 // $nbr_ecriture = count($Ecriture_comptables);
						// $somme_debit = Ecriture_comptable::somme_debit($user->id,$nav_societe->id_societe); 
						// $somme_credit = Ecriture_comptable::somme_credit($user->id,$nav_societe->id_societe);
						$thisday=date('Y-m-d');	
				
				  ?>
		<div class="show-fact">
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-9">
					<?php 
						if (!empty($msg_error)){
								echo error_message($msg_error); 
						}elseif(!empty($msg_positif)){ 
								echo positif_message($msg_positif);	
						}elseif(!empty($msg_system)){ 
								echo system_message($msg_system);
					} ?>
						
					
			<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-blue bold">
								Relevé des Comptes de Trésorerie

							</div>
						</div>
				<div class=" notification "></div>
				<div class="col-md-4">
									<select class="form-control  "   id="banque"  name="id_nature"   placeholder="Choisir dans la liste" >
										<option value=""></option>
											<?php  foreach ($banques as $banque) { ?>
												<option value="<?php if(isset($banque->id_banque)){echo $banque->id_banque; } ?>"><?php if (isset($banque->id_banque)) {echo $banque->Designation; } ?> </option>
											<?php } ?>														   
									</select>
				</div>
				
				<div class="portlet-body ">
				<form   id="releve_form"   class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe; } ?>">	   
					<input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">
					<input type="hidden"  name="date_valid" id="date_valid"  value="<? echo $thisday; ?>" />
					
					<table class="table table-striped table-bordered table-hover"  id="">
						<thead>
							<tr>
								<th width="5%">
									Date
								</th>
								<th >
									Référence
								</th>
								<th >
									Désignation
								</th>
								<th width="10%">
									 Débit
								</th>
								<th width="10%">
									Crédit
								</th>
								<th width="20%">
									Nature Opération
								</th>
								
								<th width="20%">
									Tiers
								</th>
								<th width="10%">
									Details
								</th>
							</tr>
						</thead>
						<tbody>
								
							<tr class="info-releve" >
								
								
								<td>
                                   <input type="date" name = "date" id="date"  value="<? echo $thisday; ?>"  class="form-control"   placeholder="date "  >
                                   
                                </td>

								<td>
									<input type="text" name = "ref_releve" id="ref_releve"    class="form-control ref_releve "   placeholder="Référence "  >
								</td>
								<td>
									<input type="text" name = "libelle" id="libelle"  class="form-control libelle "   placeholder="Désignation "  >
								</td>
								<td>
									<input type="number" name = "somme_debit" id="somme_debit" min="0"   class="form-control somme_debit "   placeholder="Débit "  >
								</td>

								<td>
									<input type="number" name = "somme_credit" id="somme_credit" min="0"  class="form-control Credit"  placeholder="Crédit "   >	
								</td>
								<td>
									<select class="form-control  "   id="id_nature"  name="id_nature"   placeholder="Choisir dans la liste" >
										<option value=""></option>
											<?php  foreach ($nature_operations as $nature_operation) { ?>
												<option value="<?php if(isset($nature_operation->id)){echo $nature_operation->id; } ?>"><?php if (isset($nature_operation->id)) {echo $nature_operation->libelle; } ?> </option>
											<?php } ?>														   
									</select>
								</td>
								<td class=" id_tires">
									  
								</td>
								<td class="id_facture">
								
									
								
								</td>
								
								
							</tr>
							
							
							</tbody> 
							
					</table>
					
				</div>
							<div class="panel-footer " align="right">
							<a id="save_releve"  class="btn  green "  > <i class="fa fa-check"></i>    Enregistrer   </a>   
								
						    </div>	

						</div>
					</form>
				</div>
				<div class="col-md-3 list-group-item bg-blue-ebonyclay">
					
							<p>Scan du Facture Pièce comptable</p>
				
				</div>
				<div class="col-md-3 list-group-item bg-blue-chambray margin-bottom-30">
				<?php
					if (isset($_GET['id_img'])) {
					 $image =  htmlspecialchars($_GET['id_img']) ;
					 
					 $img_select = Upload::trouve_par_id ($image);
					  
					}else{
							echo '<p> aucune facture sélectionné  ....</p>'; 
							
					}
				$cpt = 0; 

				$file = str_replace (" ", "_", $nav_societe->Dossier );
				  
				?>
				<?php if (isset($image)){?>
				
					
					<img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   >
					<a href="#form_modal12" data-toggle="" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
					<a href="#form_modal12" data-toggle="" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
					<a href="#form_modal12" data-toggle="" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
				
				<?php }else {echo '<a href="#form_modal12" data-toggle=""><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>	
			
			</div>

			
		</div>
<!--END ADD RELEVE -->

		<?php  } else if ($action=='upload') {
			
					if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
						$id = $_GET['id']; 
						$Upload = Facture_vente:: trouve_par_id($id);
						 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
							 $id = $_POST['id'];
						$Upload = Facture_vente:: trouve_par_id($id);
						 } else { 
								$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
							} 
					?>
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


                           
			
				<?php
					$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); 
					$cpt = 0;
				?>					

                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption bold">
											<i class="fa  fa-folder font-yellow "></i> Dossier sacan
										</div>

									</div>
							<div class="row">
							
							<?php  $file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
							?>
								<div class="col-sm-1 col-md-1">
								<form action="<?php echo $_SERVER['PHP_SELF']?>?action=upload" method="POST" class="form-horizontal" enctype="multipart/form-data">
									<a href="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>"  class="fancybox-button" data-rel="fancybox-button" alt ="">
									<img src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>"  style="height: 107px; width: 107px; display: block;" class="img-responsive" >
										<input type="hidden" name="id_scan" value="<?php echo $ScanImage->id ;?>" /> 								
									</a>
									<button type="submit" name = "submit" class="btn btn-sm btn-block"><i class="fa fa-plus"></i></button>
									<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
									<hr>
								</form>
								</div>
								
						<?php }?>
					
							</div>
							
					</div>
			</div>
		</div>
		<?php	}} ?>
			</div>
			</div>
			</div>
			</div>
			<!-- END CONTENT  ADIT-->
			<div id="form_modal12" class="modal container fade" tabindex="-1">
				
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Sélectionner une image</h4>
										</div>
										<div class="modal-body">
								
							<div class="row">
			<?php
					$ScanImages = Upload::trouve_upload_societe($nav_societe->id_societe); 
					$cpt = 0;
					$file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
				?>
			<div class="col-md-4 ">
				<!-- BEGIN WIDGET THUMB -->
				
				<div class="widget-thumb widget-bg-color-white text-uppercase rounded-3 margin-bottom-30 portlet light bordered ">
				<a  href="saisie.php?action=add_pieces&id_img=<?php echo $ScanImage->id;  ?>" class="fancybox-button" data-rel="fancybox-button"   >
					<div class="widget-news ">
						
							<img class="widget-news-left-elem" src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>" alt="" style="width: 80px; height: 80px;">
						
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

<!-- END CONTAINER -->
<script>

////////////////////////////////// onchange BANQUE ///////////////////////////

$(document).on('change','#banque', function() {
	
    var id = this.value;
	 var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.id_ti').load('ajax/change_bank.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

////////////////////////////////// onchange NATURE OPERATION ///////////////////////////

$(document).on('change','#id_nature', function() {
    var id = this.value;
	var id_banque = $('#id_banque').val();
	var id_caisse = $('#id_caisse').val();
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.id_tier').load('ajax/tiers_comptes.php?id='+id+'&id_societe='+id_societe+'&id_banque='+id_banque+'&id_caisse='+id_caisse,function(){       
    });
	 $('.id_credit').load('ajax/tiers_credit.php?id='+id+'&id_societe='+id_societe,function(){       
    });
	 $('.id_debit').load('ajax/tiers_debit.php?id='+id+'&id_societe='+id_societe,function(){       
    });
	$('.nature_op').load('ajax/nature_opration.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
////////////////////////////////// onchange TIERS ///////////////////////////

$(document).on('change','#id_tier', function() {
    var id = this.value;
	var id_nature = $('#id_nature').val();
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.id_facture').load('ajax/tiers_facture.php?id='+id+'&id_societe='+id_societe+'&id_nature='+id_nature,function(){       
    });
});
////////////////////////////////// onchange TIERS ///////////////////////////

$(document).on('change','.select_banque', function() {
    var id = this.value;
	var id_nature = $('#id_nature').val();
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.id_frct').load('ajax/tiers_facture.php?id='+id+'&id_societe='+id_societe+'&id_nature='+id_nature,function(){       
    });
});
///////////disable input debut or credit /////////////////
$(document).on('input','.somme_debit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('.somme_credit').attr("readonly", "readonly");
  }   
  else  {
    $('.somme_credit').removeAttr('readonly'); 
  } 

});

$(document).on('input','.somme_credit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('.somme_debit').attr("readonly", "readonly");
  }   
  else  {
    $('.somme_debit').removeAttr('readonly'); 

  } 

});

$(document).on('input','#somme_debit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('#somme_credit').attr("readonly", "readonly");
  }   
  else  {
    $('#somme_credit').removeAttr('readonly'); 
  } 

});

$(document).on('input','#somme_credit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('#somme_debit').attr("readonly", "readonly");
  }   
  else  {
    $('#somme_debit').removeAttr('readonly'); 

  } 

});
</script>

<?php
require_once("footer/footer.php");
?>