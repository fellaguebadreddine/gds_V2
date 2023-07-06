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

	if (isset($_GET['action']) && $_GET['action'] =='add_produit' ) {

$active_submenu = "add_produit";
$action = 'add_produit';
	}else if (isset($_GET['action']) && $_GET['action'] =='list_produit' ) {
$active_submenu = "list_produit";
$action = 'list_produit';}
else if (isset($_GET['action']) && $_GET['action'] =='list_matiere_premiere' ) {
	$active_submenu = "list_produit";
	$action = 'list_matiere_premiere';}
else if (isset($_GET['action']) && $_GET['action'] =='edit' ) {
$active_submenu = "list_produit";
$action = 'edit';}
else if (isset($_GET['action']) && $_GET['action'] =='article' ) {
$active_submenu = "article";
$action = 'article';}
else if (isset($_GET['action']) && $_GET['action'] =='stock' ) {
$active_submenu = "article";
$action = 'stock';}
else if (isset($_GET['action']) && $_GET['action'] =='stock_par_date' ) {
$active_submenu = "article";
$action = 'stock_par_date';}
}
$titre = "ThreeSoft | Article ";
$active_menu = "Facturation";
$header = array('table');
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
$thisday=date('Y-m-d');
?>
<?php

if(isset($_POST['submit']) && $action == 'add_produit'){
	$errors = array();
		// new object produit
	
	// new object admin produit
	$random_number = rand();
	$produit = new Produit();

	$produit->Designation = htmlentities(trim($_POST['Designation']));
	$produit->id_unite = htmlentities(trim($_POST['Unite']));
	$produit->id_famille = htmlentities(trim($_POST['Famille']));
	$produit->stock = htmlentities(trim($_POST['stock']));
	$produit->stock_initial = htmlentities(trim($_POST['stock']));
	$produit->initial = htmlentities(trim($_POST['initial']));
	$produit->alerte = htmlentities(trim($_POST['alerte']));
	$produit->id_tva = htmlentities(trim($_POST['tva']));
	if (!empty($_POST['code'])){
		$produit->code = htmlentities(trim($_POST['code']));
	}else{ $produit->code = 'PR'.sprintf("%06d", mt_rand(1, 999999));}
	if (isset($produit->id_tva)) {
		$tva=Tva::trouve_par_id($produit->id_tva);
	$produit->tva = $tva->taux;
	}
	$produit->date = htmlentities(trim($_POST['date']));
	$produit->is_importation = htmlentities(trim($_POST['is_importation']));
	$produit->matiere_premiere = htmlentities(trim($_POST['matiere_premiere']));
	$produit->is_production = htmlentities(trim($_POST['is_production']));
	$produit->exonere = htmlentities(trim($_POST['exonere']));
	$produit->stockable = htmlentities(trim($_POST['stockable']));
	$produit->immobil = htmlentities(trim($_POST['immobil']));
	$produit->id_societe = $nav_societe->id_societe;
	$produit->random =  $random_number;
	if ($_POST['radio1'] == 0) {
	$produit->prix_vente = htmlentities(trim($_POST['input_Prix_fixe']));
	}
	if ($_POST['radio1'] == 1) {
	$produit->pourcentage_prix_vente = (htmlentities(trim($_POST['inputPrix_par_pourcentage'])))/100;
	}
	if($_FILES["image"]["size"]>0) {
		$file_name = str_replace (" ", "_", $produit->Designation );
// Validate the type. Should be JPEG or PNG.
$allowed = array ('image/jpeg','image/pjpeg','image/png');
if (in_array($_FILES['image']['type'], $allowed)) {
  
   // Move the file over.
   if (file_exists("scan/produit/".$file_name.".jpg")){unlink("scan/produit/".$file_name .".jpg");}
   if (move_uploaded_file($_FILES['image']['tmp_name'],"scan/produit/".$file_name .".jpg")) {

	   
	   $produit->img_produit = $file_name.".jpg";
	   
   }else{
	   $errors[]= "un probleme au transfert  des données ";
   } 
} else { // Invalid type.
   $errors[]= "l'image doit être en format jpeg ";
}
	   // Check for an error:
if ($_FILES['image']['error'] > 0) {
$errors[]= 'le image est mal téléchargé accause : <br/>';

// Print a message based upon the error.
switch ($_FILES['image']['error']) {
   case 1:
   $errors[]= 'The image exceeds the upload_max_filesize setting in php.ini.';
   break;
   case 2:
   $errors[]= 'The image exceeds the MAX_FILE_SIZE setting in the HTML form.';
   break;
   case 3:
   $errors[]= 'The image was only partially uploaded.';
   break;
   case 4:
   $errors[]= 'No image was uploaded.';
   break;
   case 6:
   $errors[]= 'No temporary folder was available.';
   break;
   case 7:
   $errors[]= 'Unable to write to the disk.';
   break;
   case 8:
   $errors[]= 'File upload stopped.';
   break;
   default:
   $errors[]= 'A system error occurred.';
   break;
} // End of switch.
} // End of error IF.



// Delete the image if it still exists:
if (file_exists($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']) ) {
   unlink($_FILES['image']['tmp_name']);
}


}
	

	if (empty($errors)){
			if (empty($_POST['code'])){
if ($produit->existe_name()) {
			$msg_error = '<p >  Produit : ' . $produit->Designation	 . '  existe déja !!!</p><br />';
			
		}else{
			$produit->save();
			
 		$msg_positif = '<p >  Produit    : ' . $produit->Designation	 . ' est bien ajouter  </p><br />';

 		/////////////// get this prod ////////////////////

 		$Article = Produit::trouve_par_random($random_number);

 					$Lot_prod = new Lot_prod();
						$Lot_prod->code_lot = rand();
						$Lot_prod->id_societe = $nav_societe->id_societe;
						$Lot_prod->id_prod = $Article->id_pro;
						$Lot_prod->qte = $Article->stock_initial;
						$Lot_prod->qte_initial = $Article->stock_initial;
						$Lot_prod->prix_achat = $Article->initial;
						if ($Article->pourcentage_prix_vente > 0) {
					$Lot_prod->prix_vente = $Article->initial +($Article->initial  * $Article->pourcentage_prix_vente) ;
					}else{
						$Lot_prod->prix_vente = $Article->prix_vente;
					}
						$Lot_prod->date_lot = "2000-01-01";
						$Lot_prod->type_achat = 3;
						$Lot_prod->save();

		
		}
			}
				else{
	if ($produit->existe()) {
			$msg_error = '<p >  Code : ' . $produit->code	 . ' Produit existe déja !!!</p><br />';
			
		}else{
			$produit->save();
			
 		$msg_positif = '<p >  Produit    : ' . $produit->Designation	 . ' est bien ajouter  </p><br />';

 		/////////////// get this prod ////////////////////

 		$Article = Produit::trouve_par_random($random_number);

 					$Lot_prod = new Lot_prod();
						$Lot_prod->code_lot = rand();
						$Lot_prod->id_societe = $nav_societe->id_societe;
						$Lot_prod->id_prod = $Article->id_pro;
						$Lot_prod->qte = $Article->stock_initial;
						$Lot_prod->qte_initial = $Article->stock_initial;
						$Lot_prod->prix_achat = $Article->initial;
						if ($Article->pourcentage_prix_vente > 0) {
					$Lot_prod->prix_vente = $Article->initial +($Article->initial  * $Article->pourcentage_prix_vente) ;
					}else{
						$Lot_prod->prix_vente = $Article->prix_vente;
					}
						$Lot_prod->date_lot = "2000-01-01";
						$Lot_prod->type_achat = 3;
						$Lot_prod->save();

		
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

	if($action == 'edit' ){
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
 	$id = $_GET['id']; 
	$produit = produit:: trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
	$produit = produit:: trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
	if (isset($_POST['submit'])) {

	$errors = array();
		// new object produit
	
	// new object admin produit
	
	$produit->Designation = htmlentities(trim($_POST['Designation']));
	$produit->id_unite = htmlentities(trim($_POST['Unite']));
	$produit->code = htmlentities(trim($_POST['code']));
	$produit->id_famille = htmlentities(trim($_POST['Famille']));
	$produit->alerte = htmlentities(trim($_POST['alerte']));
	$stock_initial = htmlentities(trim($_POST['stock']));
	$produit->stock - $produit->stock_initial + $stock_initial;
	$produit->stock_initial = $stock_initial;
	$produit->initial = htmlentities(trim($_POST['initial']));
	$produit->id_tva = htmlentities(trim($_POST['tva']));
	if (isset($produit->id_tva)) {
		$tva=Tva::trouve_par_id($produit->id_tva);
	$produit->tva = $tva->taux;
	}
	$produit->is_importation = htmlentities(trim($_POST['is_importation']));
	$produit->matiere_premiere = htmlentities(trim($_POST['matiere_premiere']));
	$produit->is_production = htmlentities(trim($_POST['is_production']));
	$produit->exonere = htmlentities(trim($_POST['exonere']));
	$produit->stockable = htmlentities(trim($_POST['stockable']));
	$produit->immobil = htmlentities(trim($_POST['immobil']));
	
	if ($_POST['radio1'] == 0) {
	$produit->prix_vente = htmlentities(trim($_POST['input_Prix_fixe']));
} 	if ($_POST['radio1'] == 1) {
	$produit->pourcentage_prix_vente = (htmlentities(trim($_POST['inputPrix_par_pourcentage'])))/100;
	$produit->prix_vente = $produit->prix_achat + ($produit->prix_achat * $produit->pourcentage_prix_vente);
}
		if($_FILES["image"]["size"]>0) {
		$file_name = str_replace (" ", "_", $produit->code );
// Validate the type. Should be JPEG or PNG.
$allowed = array ('image/jpeg','image/pjpeg','image/png');
if (in_array($_FILES['image']['type'], $allowed)) {
  
   // Move the file over.
   if (file_exists("scan/produit/".$file_name.".jpg")){unlink("scan/produit/".$file_name .".jpg");}
   if (move_uploaded_file($_FILES['image']['tmp_name'],"scan/produit/".$file_name .".jpg")) {

	   
	   $produit->img_produit = $file_name.".jpg";
	   
   }else{
	   $errors[]= "un probleme au transfert  des données ";
   } 
} else { // Invalid type.
   $errors[]= "l'image doit être en format jpeg ";
}
	   // Check for an error:
if ($_FILES['image']['error'] > 0) {
$errors[]= 'le image est mal téléchargé accause : <br/>';

// Print a message based upon the error.
switch ($_FILES['image']['error']) {
   case 1:
   $errors[]= 'The image exceeds the upload_max_filesize setting in php.ini.';
   break;
   case 2:
   $errors[]= 'The image exceeds the MAX_FILE_SIZE setting in the HTML form.';
   break;
   case 3:
   $errors[]= 'The image was only partially uploaded.';
   break;
   case 4:
   $errors[]= 'No image was uploaded.';
   break;
   case 6:
   $errors[]= 'No temporary folder was available.';
   break;
   case 7:
   $errors[]= 'Unable to write to the disk.';
   break;
   case 8:
   $errors[]= 'File upload stopped.';
   break;
   default:
   $errors[]= 'A system error occurred.';
   break;
} // End of switch.
} // End of error IF.



// Delete the image if it still exists:
if (file_exists($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']) ) {
   unlink($_FILES['image']['tmp_name']);
}


}

	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($produit->save()){
		$msg_positif .= '<p >  article ' . html_entity_decode($produit->Designation) . '  est modifié  avec succes </p><br />';

				/////edit lot prod ////////////////////


		 				$Lot_prod = Lot_prod::trouve_lot_par_type_and_prod(3,$produit->id_pro);
		 				if (isset($Lot_prod->id_societe)) {
		 				
						$Lot_prod->id_societe = $nav_societe->id_societe;
						if ($Lot_prod->qte == $Lot_prod->qte_initial) {
						$Lot_prod->qte = $produit->stock_initial;
						$Lot_prod->qte_initial = $produit->stock_initial;
						}
						$Lot_prod->prix_achat = $produit->initial;
						if ($produit->pourcentage_prix_vente > 0) {
					$Lot_prod->prix_vente = $produit->initial +($produit->initial  * $produit->pourcentage_prix_vente) ;
					}else{
						$Lot_prod->prix_vente = $produit->prix_vente;
					}
						$Lot_prod->date_lot = "2000-01-01";
						$Lot_prod->save();
						}


													
														
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
	if (isset($_POST['submit']) && $action == 'stock_par_date') {
	$errors = array();

	// verification de données 	
	
 	if (empty($errors)){
   		// perform Update
	
	$date_db = trim(htmlspecialchars($_POST['date']));
	
 	
 	    $stocks  = Produit::recherche($date_db,$nav_societe->id_societe);
		
	}else{
		// errors occurred
		$msg_error = '<h1>erreur!</h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
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
                       
                        <i class="fa fa-angle-right"></i>
                    </li>
					<li>
                        
                        <a href="produit.php?action=list_produit">Article</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_produit') { 
                        echo  '<a href="produit.php?action=add_produit">Ajouter articles</a> '?>
                        
                        
                    <?php }elseif ($action == 'list_matiere_premiere') {
                        echo '<a href="produit.php?action=list_matiere_premiere">Liste des atiere Premiere</a> ';
                    }	 elseif ($action == 'edit') {
                        echo '<a href="produit.php?action=edit_produit">Modifier articles</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			
		<?php if ($user->type == 'administrateur') {
			
				$Nproduit= count($table_ch = Produit::trouve_produit_par_societe($nav_societe->id_societe));
				$Nunite= count($table_ch = Unite::trouve_unite_par_societe($nav_societe->id_societe));
				$Nfamil= count($table_ch = Famille::trouve_famille_par_societe($nav_societe->id_societe));
				$produits = Produit::trouve_produit_stockable($nav_societe->id_societe);
				$produits_non_stockables = Produit::trouve_produit_non_stockable($nav_societe->id_societe); 
				$matiere_premieres = Produit::trouve_matiere_premiere_par_societe($nav_societe->id_societe);
				$productions = Produit::trouve_produit_production($nav_societe->id_societe);
				$Immobilisations = Produit::trouve_produit_immobil($nav_societe->id_societe);
				$cpt = 0; 
				if ($action == 'list_produit') {
			
				?>
	
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				
		<div class="notification"></div>
		<div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-cube font-yellow"></i>Produits <span class="caption-helper"> (<?php echo $Nproduit;?>)</span> 
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group pull-right">
											
											<a href="produit.php?action=add_produit" class="btn yellow-crusta pull-right">Nouveau produit  <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
						<div class="portlet-body">
						<div class="tabbable-custom ">
						<ul class="nav nav-tabs ">
                             <li class="active">
                                 <a href="#tab_5_1" data-toggle="tab"> Produits stockable</a>
                             </li>
							 <li >
                                 <a href="#tab_5_5" data-toggle="tab"> Produits non stockable </a>
                             </li>
							 <li>
                                 <a href="#tab_5_2" data-toggle="tab"> Matiere Premiere </a>
                             </li>
							 <li>
                                 <a href="#tab_5_3" data-toggle="tab">  Production </a>
                             </li>
							 <li>
                                 <a href="#tab_5_4" data-toggle="tab">  Immobilisation </a>
                             </li>
						</ul>
						
						<div class="tab-content">
						 <div class="tab-pane active" id="tab_5_1">
							<table class="table table-striped table-hover" id="sample_5">
							<thead>
							<tr>
								<th>
									N°
								</th>
								<th>
									Code 
								</th>
								<th>
									Article
								</th>
								<th>
									Exonérer TAP
								</th>
								<th>
								Quantité 
								</th>
								
								<th>#</th>
								
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($produits as $produit){
									$cpt ++;
								?>
							<tr  id="prod_<?php echo $produit->id_pro; ?>">
								<td><?php echo $cpt;?></td>
								<td>
									<a data-target="#Detail_Prod" name="<?php if (isset($produit->Designation)) {
										echo $produit->Designation;
									} ?>" data-toggle="modal" id="MyProd" value="<?php if(isset($produit->id_pro)){
										echo $produit->id_pro; } ?>"  class=""><?php if (isset($produit->code)) {
									echo '<i class="fa  fa-barcode font-yellow"></i> '. $produit->code;
									} ?></a>
								</td>
								<td>
									<b><?php if (isset($produit->Designation)) {
									echo '<i class="fa  fa-cube font-yellow bold"></i> '. $produit->Designation;
									} ?></b>
								</td>
								<td>
									<?php if (isset($produit->exonere)) {
										if ($produit->exonere == 1){
											echo '<span class="label label-sm bg-green-jungle">	Exonerer TAP </span>';
										}else{
											echo '<span class="label label-sm bg-red">	Non Exonerer  </span>';;
										}
									
									} ?> 
									
								</td>
								<td>
									<?php if (isset($produit->id_pro)) {
										$stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);
										if (isset($stock_prod->stock)) {
										echo $stock_prod->stock;
										}
									} ?> 
									
								</td>
								
								<td>
									<button id="del_prod" value="<?php echo $produit->id_pro; ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_prod" data-toggle="modal"></i> </button>
								</td>
								
								
								
							</tr>
							
							<?php
								}
							?>
						
							</tbody>
							
							</table>
						</div>
						<div class="tab-pane" id="tab_5_2">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr>
								<th>
									N°
								</th>
								<th>
									Code 
								</th>
								<th>
									Article
								</th>
								
								<th>
									Quantité
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>

								<?php $cpt = 0;
								foreach($matiere_premieres as $matiere_premiere){
									$cpt ++;
								?>
							<tr>
								<td>
									<?php echo $cpt; ?>
								</td>
								<td>
									<a data-target="#Detail_Prod" name="<?php if (isset($matiere_premiere->Designation)) {
										echo $matiere_premiere->Designation;
									} ?>" data-toggle="modal" id="MyProd" value="<?php if(isset($matiere_premiere->id_pro)){
										echo $matiere_premiere->id_pro; } ?>"  class=""><?php if (isset($matiere_premiere->code)) {
									echo '<i class="fa  fa-barcode font-yellow"></i> '. $matiere_premiere->code;
									} ?></a>
								</td>
								
								<td>
									<b><?php if (isset($matiere_premiere->Designation)) {
									echo $matiere_premiere->Designation;
									} ?></b>
								</td>
							
								<td>
									
									<?php if (isset($matiere_premiere->id_pro)) {
										$stock_prod = Produit::Calcul_stock_par_id($matiere_premiere->id_pro);
										if (isset($stock_prod->stock)) {
										echo $stock_prod->stock;
										}
									} ?> 
									
								</td>
								
							
								
								<td>
									
									<a href="produit.php?action=edit&id=<?php echo $matiere_premiere->id_pro; ?>" class="btn blue btn-xs">
                                                    <i class="fa fa-edit "></i> </a>
									
								</td>
							</tr>

							<?php
								}
							?>
						
							</tbody>
							
							</table>
						</div>
						<div class="tab-pane" id="tab_5_3">
							<table class="table table-striped table-hover" id="sample_2">
							<thead>
							<tr>
								<th>
									N°
								</th>
								<th>
									Code 
								</th>
								<th>
									Article
								</th>
								
								<th>
								Quantité 
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								<?php $cpt = 0;
								foreach($productions as $produit){
									$cpt ++;
								?>
							<tr>
								<td><?php echo $cpt;?></td>
								<td>
									<a data-target="#Detail_Prod" name="<?php if (isset($produit->Designation)) {
										echo $produit->Designation;
									} ?>" data-toggle="modal" id="MyProd" value="<?php if(isset($produit->id_pro)){
										echo $produit->id_pro; } ?>"  class=""><?php if (isset($produit->code)) {
									echo '<i class="fa  fa-barcode font-yellow"></i> '. $produit->code;
									} ?></a>
								</td>
								<td>
									<b><?php if (isset($produit->Designation)) {
									echo '<i class="fa  fa-cube font-yellow bold"></i> '. $produit->Designation;
									} ?></b>
								</td>
							
								<td>
									<?php if (isset($produit->id_pro)) {
										$stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);
										if (isset($stock_prod->stock)) {
										echo $stock_prod->stock;
										}
									} ?> 
									
								</td>
							
								
								
								
							</tr>
						
							
							<?php
								}
							?>
						
							</tbody>
							
							</table>
						</div>
						<div class="tab-pane" id="tab_5_4">
							<table class="table table-striped table-hover" id="sample_2">
							<thead>
							<tr>
								<th>
									N°
								</th>
								<th>
									Code 
								</th>
								<th>
									Article
								</th>
								
								<th>
								Quantité 
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								<?php $cpt = 0;
								foreach($Immobilisations as $produit){
									$cpt ++;
								?>
							<tr>
								<td><?php echo $cpt;?></td>
								<td>
									<a data-target="#Detail_Prod" name="<?php if (isset($produit->Designation)) {
										echo $produit->Designation;
									} ?>" data-toggle="modal" id="MyProd" value="<?php if(isset($produit->id_pro)){
										echo $produit->id_pro; } ?>"  class=""><?php if (isset($produit->code)) {
									echo '<i class="fa  fa-barcode font-yellow"></i> '. $produit->code;
									} ?></a>
								</td>
								<td>
									<b><?php if (isset($produit->Designation)) {
									echo '<i class="fa  fa-cube font-yellow bold"></i> '. $produit->Designation;
									} ?></b>
								</td>
							
								<td>
									<?php if (isset($produit->id_pro)) {
										$stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);
										if (isset($stock_prod->stock)) {
										echo $stock_prod->stock;
										}
									} ?> 
									
								</td>
							
								
								
								
							</tr>
						
							
							<?php
								}
							?>
						
							</tbody>
							
							</table>
						</div>
						<div class="tab-pane" id="tab_5_5">
							<table class="table table-striped table-hover" id="sample_2">
							<thead>
							<tr>
								<th>
									N°
								</th>
								<th>
									Code 
								</th>
								<th>
									Article
								</th>
								
								<th>
								Quantité 
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								<?php $cpt = 0;
								foreach($produits_non_stockables as $produit){
									$cpt ++;
								?>
							<tr>
								<td><?php echo $cpt;?></td>
								<td>
									<a data-target="#Detail_Prod" name="<?php if (isset($produit->Designation)) {
										echo $produit->Designation;
									} ?>" data-toggle="modal" id="MyProd" value="<?php if(isset($produit->id_pro)){
										echo $produit->id_pro; } ?>"  class=""><?php if (isset($produit->code)) {
									echo '<i class="fa  fa-barcode font-yellow"></i> '. $produit->code;
									} ?></a>
								</td>
								<td>
									<b><?php if (isset($produit->Designation)) {
									echo '<i class="fa  fa-cube font-yellow bold"></i> '. $produit->Designation;
									} ?></b>
								</td>
							
								<td>
									<?php if (isset($produit->id_pro)) {
										$stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);
										if (isset($stock_prod->stock)) {
										echo $stock_prod->stock;
										}
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
                                          
					
				</div>

				
			</div>
		<?php }elseif ($action == 'list_matiere_premiere') {
require_once("header/menu-bar.php");	
$matiere_premieres = Produit::trouve_matiere_premiere_par_societe($nav_societe->id_societe)				;
				  ?>
				  <!-- BEGIN matiere_premiere-->
				  <div class="row">
				<div class="col-md-12">
						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light ">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-cube font-yellow"></i>Matiere Premiere  
							</div>
						</div>
						<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group pull-right">
											
											<a href="produit.php?action=add_produit" class="btn yellow-crusta pull-right">Nouveau produit  <i class="fa fa-plus"></i></a>
											
										</div>
									</div>
									
								</div>
							</div>
							
						<div class="portlet-body">
							<table class="table table-striped table-hover" id="sample_4">
							<thead>
							<tr>
								<th>
									Code 
								</th>
								<th>
									article
								</th>
								
								<th>
									Quantité
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								foreach($matiere_premieres as $matiere_premiere){
									$cpt ++;
								?>
							<tr>
								<td>
									<a class=" popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?php if (isset($matiere_premiere->code)) {
									echo  $matiere_premiere->code . ' ';
									
									echo '  | '. $matiere_premiere->Designation . ' ';
									
								
									echo ' | '. $produit->stock . '  ';
									}  ?>" data-original-title="Produit"><?php if (isset($matiere_premiere->code)) {
									echo '<i class="fa  fa-cube font-yellow bold"></i> '. $matiere_premiere->code;
									} ?></a>
								</td>
								<td>
									<b><?php if (isset($matiere_premiere->Designation)) {
									echo $matiere_premiere->Designation;
									} ?></b>
								</td>
							
								<td>
									<?php if (isset($matiere_premiere->stock)) {
									echo $matiere_premiere->stock;
									} ?> 
									
								</td>
								
							
								
								<td>
									
									<a href="produit.php?action=edit&id=<?php echo $matiere_premiere->id_pro; ?>" class="btn blue btn-xs">
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
				  <!-- END  matiere_premiere-->
			<?php  

				}elseif ($action == 'add_produit') {				
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


                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption bold">
											<i class="fa  fa-plus-square font-yellow "></i>Ajouter Article
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=add_produit" method="POST" class="form-horizontal margin-bottom-40 form-bordered" enctype="multipart/form-data">
											<div class="form-body ">
												
											
											<div class="form-group form-md-line-input has-warning">
													<label for="" class="col-md-2 control-label">Article</label>
												<div class="col-md-6 ">
													<div class="input-icon">
													<input type="text" name = "Designation" class="form-control margin-bottom-40" placeholder="Nom de l'article" required>
													<div class="form-control-focus"> </div>
													<i class="fa fa-cubes"></i>
													</div>
													
												<div class="input-icon ">
													<input type="text" name = "code" class="form-control" placeholder="Code" >
													<div class="form-control-focus"> </div>
													<i class="fa fa-barcode"></i>
												
											
												</div>
												</div>
												<div class="col-md-4 ">
													<div class="pull-right fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 94px; height: 94px;">
															<img class="media-object bg-grey" src="assets/image/placeholder.png" alt="64x64" style="width: 94px; height: 94px;">
															</div>

															<div >
																<span class="btn btn-file">
																<input type="file" name="image" accept=".png,.jpg,.jpeg,.gif"></span>
																
															</div>
													</div>
													
												</div>
											</div>
						
							<div class="tab-content">
							
										<div class="form-group ">
													<label class="col-md-2 control-label">Unite <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
															<select class="form-control select2me"   id="form_control_1"  name="Unite" required>
																<option value=""></option>
															<?php $Unites = Unite::trouve_unite_par_societe($nav_societe->id_societe);
															foreach($Unites as $Unite){
														
															
														echo '<option  value = "'.$Unite->id_unite.'" > '.$Unite->unite.'</option>';
														} ?>															   
														</select> 
															<span class="input-group-addon ">
															<i class="fa fa-tags"></i>
															</span>
														</div>

													</div>
													
												</div>
												<div class="form-group  ">
													<label class="col-md-2 control-label">Famille <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														<select class="form-control select2me"  id="id_famille"  name="Famille" required>
															<option value=""></option>
												
															
														<?php $Familles = Famille::trouve_famille_par_societe($nav_societe->id_societe);
															foreach($Familles as $Famille){
														
															
														echo '<option  value = "'.$Famille->id_famille.'" > '.$Famille->famille.'</option>';
														} ?>																   
														</select>  
															
															<span class="input-group-addon " required >
															<i class="fa fa-filter"></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group form-md-line-input has-warrning get_tva">
													<label class="col-md-2 control-label">TVA <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<select class="form-control " data-live-search="true" id="form_control_1"  name="tva" required>
												
															
														<?php $tvass = Tva::trouve_tva_par_societe($nav_societe->id_societe);
															foreach($tvass as $tva){

														echo '<option  value = "'.$tva->id_tva.'" > '.$tva->Designation. ' % </option>';
														} ?>																   
														</select> 
															<span class="input-group-addon " required >
															tva
															</span>
														</div>
														
													</div>
												</div>	
																				
																
											<div class="form-group form-md-line-input has-error">
											<label class="col-md-2 control-label">Stock <span class="required" aria-required="true"> * </span></label>
											<div class="col-md-9">
											<div class="row margin-bottom-30">
												<div class="col-md-6">
														<div class="input-icon">
															
																<input type="text" min="0" name = "stock" class="form-control"  placeholder="Stock initial">
															
														<i class="fa fa-database"></i>	
															</div>
												</div>
												<div class="col-md-6 ">
														<div class="input-icon">
														
															<input type="text" min="0" name = "initial" class="form-control" placeholder=" Prix ">
														
													<i class="fa fa-money"></i>	
													</div>
												</div>
											</div>
												<div class="row ">
													<div class="col-md-6 ">
													<div class="input-icon">
														
															<input type="text" min="0" name = "alerte" class="form-control" placeholder="alerte" >
														
													<i class="fa fa-bell"></i>	
													</div>
												</div>
												</div>
													
											</div>
											</div>
								
												<div class="form-group">
											<label class="control-label col-md-3">Choisir le type de Prix de vente</label>
											<div class="col-md-9">
												<div class="margin-bottom-10">
													<div class="row">
														<div class="col-md-6">
													<label for="option1" style="margin-right: 10%;">Prix fixe</label>
													<input onchange="javascript:Showinput_Prix_fixe();" id="Prix_fixe" type="radio" name="radio1"   class="make-switch switch-radio1" data-on-color="success" data-off-color="danger" data-on-text="Oui" data-off-text="Non" value="0" >
													</div>
													<div class="col-md-4">
													<input style="display:none;"   id="input_Prix_fixe" type="number"  step="0.01"  name = "input_Prix_fixe" class="form-control" placeholder="Prix fixe" >
													</div>
													</div>
												</div>
												<div class="margin-bottom-10">
													<div class="row">
														<div class="col-md-6">
													<label for="option1" style="margin-right: 5%;">Prix par %</label>
													<input checked onchange="javascript:ShowinputPrix_par_pourcentage();" id="Prix_par_pourcentage" type="radio" name="radio1"   class="make-switch switch-radio1" data-on-color="success" data-off-color="danger" data-on-text="Oui" data-off-text="Non" value="1" >
													</div>
													<div class="col-md-4">
														<div class="input-group">
													<input id="inputPrix_par_pourcentage" type="number"  step="0.01"  name = "inputPrix_par_pourcentage" class="form-control" value="<?php if(isset($nav_societe->Taux_interet)) {echo $nav_societe->Taux_interet*100;} ?>" placeholder="Prix par %" >
															<span class="input-group-addon  "  id="inputgroupaddon"  >
															%
															</span>
														</div>
													</div>
													</div>
												</div>
											</div>
										</div>
							
							
										<div class="form-group ">
													<label class="col-md-3 control-label">Produit Imporation <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list" required>
															<label class="radio-inline">
															<input type="radio" name="is_importation" <?php if ($nav_societe->type == 3) { echo "checked";} ?>   value="1" > Oui </label>
															<label class="radio-inline">
															<input type="radio" name="is_importation" <?php if ($nav_societe->type != 3) { echo "checked";} ?> value="0" > Non </label>
															<label class="radio-inline">
															
														</div>

													</div>

										</div>
										<div class="form-group">
													<label class="col-md-3 control-label">Matiere Premiere <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="matiere_premiere" id="optionsRadios27" value="1" > Oui </label>
															<label class="radio-inline">
															<input type="radio" name="matiere_premiere" id="optionsRadios28" value="0" checked> Non </label>
															<label class="radio-inline">
															
														</div>

													</div>

										</div>
											<div class="form-group">
													<label class="col-md-3 control-label">Production <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="is_production" id="optionsRadios29" value="1" > Oui </label>
															<label class="radio-inline">
															<input type="radio" name="is_production" id="optionsRadios30" value="0" checked> Non </label>
															<label class="radio-inline">
															
														</div>

													</div>

											</div>
											<div class="form-group">
													<label class="col-md-3 control-label">Exonérer TAP<span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="exonere" id="optionsRadios29" value="1" > Oui </label>
															<label class="radio-inline">
															<input type="radio" name="exonere" id="optionsRadios30" value="0" checked> Non </label>
															<label class="radio-inline">
															
														</div>

													</div>

											</div>
											<div class="form-group">
													<label class="col-md-3 control-label">Stockable<span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="stockable" id="optionsRadios29" value="1" checked> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="stockable" id="optionsRadios30" value="0" > Non </label>
															<label class="radio-inline">															
														</div>
													</div>
											</div>
											<div class="form-group">
													<label class="col-md-3 control-label">Immobilisation<span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="immobil" id="optionsRadios29" value="1" > Oui </label>
															<label class="radio-inline">
															<input type="radio" name="immobil" id="optionsRadios30" value="0" checked> Non </label>
															<label class="radio-inline">															
														</div>
													</div>
											</div>
							
							</div>

												<input type="hidden" name="date" value="<?php echo   $thisday;?>">
												
											</div>
											<div class="form-actions">
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
			<div class="col-md-4">
			 <div class="portlet light bordered">
			<div class="margin-bottom-20"> Ajouter Catégorie d'article (famille) <a href="famille.php?action=add_famille"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a></div>
			 <div class="margin-bottom-20"> Ajouter unite <a href="unite_mesure.php?action=add_unite"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a></div>
			 <div class="margin-bottom-20"> liste de produit <a href="produit.php?action=list_produit"><i class="fa fa-external-link btn btn-secondary o_external_button"></i></a></div>
			 
			 </div>
			 </div>
		</div>
			<!-- END PAGE CONTENT-->
<?php }  elseif ($action == 'edit') { ?>
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
										<div class="caption bold">
											<i class="fa  fa-pencil font-yellow"></i>Modifer Article
										</div>

									</div>
									<div class="portlet-body form">
											<!-- BEGIN FORM-->
											<form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit" method="POST" class="form-horizontal margin-bottom-40 form-bordered" enctype="multipart/form-data">
											<div class="form-body ">
												
											
											<div class="form-group form-md-line-input has-warning">
													<label for="" class="col-md-2 control-label">Article</label>
												<div class="col-md-6 ">
													<div class="input-icon">
													<input type="text" name = "Designation" class="form-control margin-bottom-40" value ="<?php if (isset($produit->Designation)){ echo html_entity_decode($produit->Designation); } ?>" placeholder="Nom de l'article" required>
													<div class="form-control-focus"> </div>
													<i class="fa fa-cubes"></i>
													</div>
													
												<div class="input-icon ">
													<input type="text" name = "code" class="form-control" value ="<?php if (isset($produit->code)){ echo html_entity_decode($produit->code); } ?>" placeholder="Code" required>
													<div class="form-control-focus"> </div>
													<i class="fa fa-barcode"></i>
												
											
												</div>
												</div>
												<div class="col-md-4">
												<div class="pull-right fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 94px; height: 94px;">
															<?php  if (!empty($produit->img_produit)) {
															echo' <img src="scan/produit/'.$produit->img_produit.'" alt=""> '; 
															} else { ?>
															<img class="media-object bg-grey" src="assets/image/placeholder.png" alt="64x64" style="width: 94px; height: 94px;">
															<?php } ?>
															
															</div>

															<div >
																<span class="btn btn-file">
																<input type="file" name="image" accept=".png,.jpg,.jpeg,.gif"></span>
																
															</div>
													</div>
												</div>
											</div>
						
							<div class="tab-content">
							
										<div class="form-group form-md-line-input has-success">
													<label class="col-md-2 control-label">Unite <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
															<select class="form-control"   id="form_control_1"  name="Unite" required>
															<?php $Unites = Unite::trouve_unite_par_societe($nav_societe->id_societe);
															foreach($Unites as $Unite){ ?>
														
															
														<option <?php if ($Unite->id_unite==$produit->id_unite) { echo "selected";} ?>  value = "<?php echo $Unite->id_unite ?>" > <?php echo $Unite->unite ?></option>';
														<?php } ?>															   
														</select> 
															<span class="input-group-addon ">
															<i class="fa fa-tags"></i>
															</span>
														</div>

													</div>
													
												</div>
												<div class="form-group form-md-line-input has-success">
													<label class="col-md-2 control-label">Famille <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-4">
														<div class="input-group">
														<select class="form-control select2me"  id="id_famille" name="Famille" required>
														<?php $Familles = Famille::trouve_famille_par_societe($nav_societe->id_societe); ?>
														<option value=""></option>
														<?php  
														foreach($Familles as $Famille){ ?>
														<option <?php if ($Famille->id_famille ==$produit->id_famille) { echo "selected";} ?>  value = "<?php echo $Famille->id_famille ?>" > <?php echo $Famille->famille ?></option>
														<?php } ?>																   
														</select>  
															
															<span class="input-group-addon " required >
															<i class="fa fa-filter"></i>
															</span>
														</div>

													</div>
												</div>
												<div class="form-group form-md-line-input has-warrning get_tva">
													<label class="col-md-2 control-label">TVA <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-3">
														<div class="input-group">
															<select class="form-control " data-live-search="true" id="form_control_1"  name="tva" required>
															<?php $tvass = Tva::trouve_tva_par_societe($nav_societe->id_societe);
															foreach($tvass as $tva){ ?>
														
															
														<option <?php if ($produit->id_tva == $tva->id_tva  ) { echo "selected";} ?>  value = "<?php echo $tva->id_tva ?>" > <?php echo $tva->Designation . ' %'?></option>
												<?php } ?>																   
														</select> 
															<span class="input-group-addon " required >
															tva
															</span>
														</div>
														
													</div>
												</div>	
																				
																
											<div class="form-group form-md-line-input has-error">
											<label class="col-md-2 control-label">Stock <span class="required" aria-required="true"> * </span></label>
												<div class="col-md-3">
														<div class="input-icon">
															
														<input type="text" name = "stock" class="form-control" value ="<?php if (isset($produit->stock_initial)){ echo html_entity_decode($produit->stock_initial); } ?>"  >
															
														<i class="fa fa-database"></i>	
															</div>
												</div>
												<div class="col-md-3 ">
														<div class="input-icon">
														
														<input type="text" name = "initial" class="form-control" placeholder="initial " value ="<?php if (isset($produit->initial)){ echo html_entity_decode($produit->initial); } ?>"  >
														
													<i class="fa fa-tasks"></i>	
													</div>
												</div>
												<div class="col-md-3 ">
													<div class="input-icon">
														
													<input type="text" name = "alerte" class="form-control" placeholder="alerte " value ="<?php if (isset($produit->alerte)){ echo html_entity_decode($produit->alerte); } ?>" >
														
													<i class="fa fa-bell"></i>	
													</div>
												</div>	
											</div>
											<div class="form-group">
											<label class="control-label col-md-3">Choisir le type de Prix de vente</label>
											<div class="col-md-9">
												<div class="margin-bottom-10">
													<div class="row">
														<div class="col-md-3">
													<label for="option1" style="margin-right: 10%;">Prix fixe</label>
													<input onchange="javascript:Showinput_Prix_fixe();" id="Prix_fixe" <?php if (isset($produit->pourcentage_prix_vente) && ($produit->pourcentage_prix_vente == 0)){ echo 'checked'; } ?> type="radio" name="radio1"   class="make-switch switch-radio1" data-on-color="success" data-off-color="danger" data-on-text="Oui" data-off-text="Non" value="0" >
													</div>
													<div class="col-md-2">
													<input  <?php if (isset($produit->pourcentage_prix_vente) && ($produit->pourcentage_prix_vente > 0)){ echo 'style="display:none;"'; } ?> id="input_Prix_fixe" type="number"  step="0.01"  name = "input_Prix_fixe" class="form-control" placeholder="Prix fixe" value="<?php if (isset($produit->prix_vente)){ echo html_entity_decode($produit->prix_vente); } ?>" >
													</div>
													
													</div>
												</div>
												<div class="margin-bottom-10">
													<div class="row">
														<div class="col-md-3">
													<label for="option1" style="margin-right: 5%;">Prix par %</label>
													<input  <?php if (isset($produit->pourcentage_prix_vente) && ($produit->pourcentage_prix_vente > 0)){ echo 'checked'; } ?> onchange="javascript:ShowinputPrix_par_pourcentage_2();" id="Prix_par_pourcentage" type="radio" name="radio1"   class="make-switch switch-radio1" data-on-color="success" data-off-color="danger" data-on-text="Oui" data-off-text="Non" value="1" >
													</div>
													<div class="col-md-2">
														<div class="input-group">

													<input <?php if (isset($produit->pourcentage_prix_vente) && ($produit->pourcentage_prix_vente == 0)){ echo 'style="display:none;"'; } ?> id="inputPrix_par_pourcentage" type="number"  step="0.01" min="0" name = "inputPrix_par_pourcentage" class="form-control" value="<?php if (isset($produit->pourcentage_prix_vente)){ echo (html_entity_decode($produit->pourcentage_prix_vente))*100; } ?>" placeholder="Prix par %" >

														<span class="input-group-addon "   id="inputgroupaddon" <?php if (isset($produit->pourcentage_prix_vente) && ($produit->pourcentage_prix_vente == 0)){ echo 'style="display:none;"'; } ?>>
															%
															</span>
														</div>
														</div>
													<div class="col-md-2">
														<input type="hidden"  id="prix_achat" value="<?php if (isset($produit->prix_achat)){ echo html_entity_decode($produit->prix_achat); } ?>">
														<input <?php if (isset($produit->pourcentage_prix_vente) && ($produit->pourcentage_prix_vente == 0)){ echo 'style="display:none;"'; } ?> disabled id="Prix_vente" type="number"  step="0.01"  value="<?php if (isset($produit->prix_vente)){ echo html_entity_decode($produit->prix_vente); } ?>" class="form-control" placeholder="Prix vente" >
													</div>
													</div>
												</div>
											</div>
										</div>
							
							
										<div class="form-group">
													<label class="col-md-3 control-label">Produit Imporation<span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="is_importation" id="optionsRadios25" value="1" <?php if ($produit->is_importation ==1){ echo 'checked';}?>> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="is_importation" id="optionsRadios26" value="0" <?php if ( $produit->is_importation ==0){ echo 'checked';}?>> Non </label>
															<label class="radio-inline">
															
														</div>
													</div>
												</div>
										<div class="form-group">
													<label class="col-md-3 control-label">Matiere Premiere <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="matiere_premiere" id="optionsRadios27" value="1" <?php if ($produit->matiere_premiere ==1){ echo 'checked';}?>> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="matiere_premiere" id="optionsRadios28" value="0" <?php if ($produit->matiere_premiere ==0){ echo 'checked';}?>> Non </label>
															<label class="radio-inline">
															
														</div>

													</div>

										</div>

										<div class="form-group">
													<label class="col-md-3 control-label">Produire <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="is_production" id="optionsRadios29" value="1" <?php if ($produit->is_production ==1){ echo 'checked';}?>> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="is_production" id="optionsRadios30" value="0" <?php if ($produit->is_production ==0){ echo 'checked';}?>> Non </label>
															<label class="radio-inline">
															
														</div>

													</div>

										</div>
										<div class="form-group">
													<label class="col-md-3 control-label">Exonérer TAP <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="exonere" id="optionsRadios29" value="1" <?php if ($produit->exonere ==1){ echo 'checked';}?>> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="exonere" id="optionsRadios30" value="0" <?php if ($produit->exonere ==0){ echo 'checked';}?>> Non </label>
															<label class="radio-inline">
															
														</div>

													</div>

										</div>
										<div class="form-group">
													<label class="col-md-3 control-label">Stockable <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="stockable" id="optionsRadios29" value="1" <?php if ($produit->stockable ==1){ echo 'checked';}?>> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="stockable" id="optionsRadios30" value="0" <?php if ($produit->stockable ==0){ echo 'checked';}?>> Non </label>
															<label class="radio-inline">															
														</div>
													</div>
										</div>
										<div class="form-group">
													<label class="col-md-3 control-label">Immobilisation <span class="required" aria-required="true"> * </span></label>
													<div class="col-md-9">
														<div class="radio-list">
															<label class="radio-inline">
															<input type="radio" name="immobil" id="optionsRadios29" value="1" <?php if ($produit->immobil ==1){ echo 'checked';}?>> Oui </label>
															<label class="radio-inline">
															<input type="radio" name="immobil" id="optionsRadios30" value="0" <?php if ($produit->immobil ==0){ echo 'checked';}?>> Non </label>
															<label class="radio-inline">															
														</div>
													</div>
										</div>
							
							</div>

												<input type="hidden" name="date" value="<?php echo   $thisday;?>">
												
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
			<?php }elseif ($action == 'article') { 
	
				
				?>
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
				<div class="col-md-12 ">
                <!-- BEGIN WIDGET MAP -->
                <div class="widget-map">
                    <div id="mapplic" class="widget-map-mapplic"></div>
                    <div class="widget-map-body text-uppercase text-center">
                       
						<div class="widget-sparkline-chart">
							<a href="produit.php?action=list_produit">
                            <div id="widget_sparkline_bar"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-cube font-yellow "></i> Produit</span>
							</a>
							</div>
						  <div class="widget-sparkline-chart">
						  <a href="unite_mesure.php?action=list_mesure">
                            <div id="widget_sparkline_bar2"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-tags font-green"></i> unite de mesure</span>
							</a>
                        </div>
						
						  <div class="widget-sparkline-chart">
						  <a href="famille.php?action=list_famille">
                            <div id="widget_sparkline_bar3"></div>
                            <span class="widget-sparkline-title"><i class="icon icon-share font-red"></i> famille</span>
							</a>
                        </div>
						
                        <div class="widget-sparkline-chart">
						 <a href="produit.php?action=stock">
                            <div id="widget_sparkline_bar4"></div>
                            <span class="widget-sparkline-title"><i class="fa  fa-database font-yellow"></i> Stocks</span>
							</a>
                        </div>
                    </div>
                </div>
                <!-- END WIDGET MAP -->
            </div>
			</div>
			<div class="row profile">
				<div class="col-md-12">
						


                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption ">
											<i class="fa  fa-cube font-yellow bold"></i>Produits<span class="caption-helper"> (<?php echo $Nproduit;?>)</span>
										</div>

									</div>
								<div class="portlet-body">
                            <div class="row">
                                            <div class="col-md-6">
											<div class="well">
                                                Les 5 derniers produits enregistrés
                                                
                                            </div>
							<div class="table-scrollable table-scrollable-borderless">
                             <table class="table table-striped table-hover ">
                                          
							<tbody>
								<?php
								foreach($produits as $produit){
									$cpt ++;
								?>
							<tr>
							<?php if ($cpt <=5){?>
								<td>
								
									
									
									<a class=" popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?php if (isset($produit->code)) {
									echo  $produit->code . ' ';
									
									echo '|'. $produit->Designation . ' ';
									
									echo '|'. $produit->tva . ' % ';
									echo '|'. $produit->stock . ' en stock ';
									}  ?>" data-original-title="Produit"><?php if (isset($produit->code)) {
									echo '<i class="fa  fa-cube font-yellow bold"></i> '. $produit->code;
									} ?></a>
								</td>
								<td>
									<?php if (isset($produit->Designation)) {
									echo $produit->Designation;
									} ?>
								</td>
								
								
								
								<td>
									
									<?php if (isset($produit->id_unite)) {
															$Unites = Unite::trouve_unite_par_id_unite($produit->id_unite);
															
															}
															foreach ($Unites as $unite){
																
																	if (isset($unite->unite)) {
															echo $unite->unite;}}?>
								</td>
								<td>
								<i class="fa fa-circle font-green-jungle"></i>
								</td>
							<?php }?>
								
							</tr>

							<?php
								}
							?>
						
							</tbody>
                                        </table>
                                    </div>
											</div>
                                            <div class="col-md-6">
											<div class="well">
                                                Statistiques
												</div>
												<div class="table-scrollable table-scrollable-borderless">
                             <table class="table table-striped table-hover ">
                                    
							<tbody>
								
							<tr>
							
								<td>
									<a href="unite_mesure.php?action=list_mesure">
									Unite de mesure
									</a>
								</td>
							
								<td>
									<?php echo $Nunite;?>
								</td>
								<td>
								<i class="fa fa-circle font-green-jungle"></i>
								</td>
							</tr>
							<tr>
							
								<td>
									<a href="famille.php?action=list_famille">
									Famille
									</a>
								</td>
								<td>
								<?php echo $Nfamil;?>	
								</td>
								<td>
								<i class="fa fa-circle font-green-jungle"></i>
								</td>
						
							</tr>
							<tr>

								<td>
								<a href="produit.php?action=stock">
									Total produit 
								</a>
								</td>
								<td>
								
									<?php echo $Nproduit;?>
									
								</td>
								<td>
								
								</td>
							</tr>

							
						
							</tbody>
                                        </table>
                                    </div>
                                                </div>
                                        </div>
                            </div>
                            <!-- END GENERAL PORTLET-->
                          
                            
                            
                            <!-- END WELLS PORTLET-->
                       

								</div>
			<?php }	elseif ($action == 'stock') { 
			
			?>
	<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">
				<div class="page-bar">
					<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=stock_par_date" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Choisir une date</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date" class="form-control" value="<?php echo $thisday; ?>" required >
															<span class="input-group-btn">
															<button type="submit" name = "submit" class="btn blue">Envoyer</button>
															</span>
															
														</div>
														
													</div>
												</div>														
												
											</div>
											
										</form>
										<!-- END FORM-->
										
									</div>
				</div>
						


                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption ">
											<i class="fa  fa-database font-yellow bold"></i>Stock <span class="caption-helper"> </span>  
										</div>
										<div class="tools"><?php echo '<b>Stock jusqu a </b>' .  $thisday;?></div>

									</div>
								<div class="portlet-body">
                            <div class="row">
                                            <div class="col-md-12">
						
						

							<div class="table table-borderless">
                             <table class="table table-striped table-hover " id="sample_2">
                               <thead>
											<tr >
												<th >
													 Code
												</th>
												
												<th>
													 Produit
												</th>
												<th>
													 Unite
												</th>
												<th>
													Quantité
												</th>
												<th>
													 Lot
												</th>
												
												<th>
													 Prix achat
												</th>
												<th>
													 Valeur
												</th>
												<th>
													 Etat
												</th>
											</tr>
											</thead>           
							<tbody>
						<?php 
						$valeur_stock =0;
							$produits = Produit::trouve_produit_par_societe_and_date_lot($nav_societe->id_societe,$thisday); 
						
								foreach($produits as $produit){
									$cpt ++;
							$stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);
								?>
							<tr>
							
								<td>
									<a data-target="#Detail_Prod" name="<?php if (isset($produit->Designation)) {
										echo $produit->Designation;
									} ?>" data-toggle="modal" id="MyProd" value="<?php if(isset($produit->id_pro)){
										echo $produit->id_pro; } ?>"  class=""><?php if (isset($produit->code)) {
									echo '<i class="fa  fa-barcode font-yellow"></i> '. $produit->code;
									} ?></a>
								</td>
								<td>
									<?php if (isset($produit->Designation)) {
									echo $produit->Designation;
									} ?>
								</td>
								
								<td>
									
									<?php if (isset($produit->id_unite)) {
															$Unites = Unite::trouve_unite_par_id_unite($produit->id_unite);
															
															}
															foreach ($Unites as $unite){
																
																	if (isset($unite->unite)) {
															echo $unite->unite;}}?>
								</td>
								<td>
									<?php if (isset($produit->id_pro)) {
										if (isset($stock_prod->stock)) {
										echo $stock_prod->stock;
										}
									} ?> 
									
								</td>
								<td>
								<?php if (isset($produit->id_pro)) {
									$Lot_prods = Lot_prod::trouve_tous_lot_par_produit($produit->id_pro,$thisday);
									foreach ($Lot_prods as $Lot_prod) {
										$Vente = Vente::somme_qte_par_lot_and_date($Lot_prod->id,$thisday);
										$qte_glob = $Lot_prod->qte + $Vente->Quantite;
										if ($qte_glob > 0) {
										
										echo 'Date :'.fr_date2($Lot_prod->date_lot).' | Code : '.$Lot_prod->code_lot.' | Qte: '.$qte_glob.' <br>'  ;
										unset($qte_glob);

										}
									}
									} ?>
								</td>
								
								<td>
								<?php foreach ($Lot_prods as $Lot_prod) {
										$Vente = Vente::somme_qte_par_lot_and_date($Lot_prod->id,$thisday);
										$qte_glob = $Lot_prod->qte + $Vente->Quantite;
										if ($qte_glob > 0) {
										echo number_format($Lot_prod->prix_achat,2,'.',' ').'<br>'  ;
										unset($qte_glob);
											
										}
									} ?>
								</td>
								<td>
									<?php foreach ($Lot_prods as $Lot_prod) {
										
										$Vente = Vente::somme_qte_par_lot_and_date($Lot_prod->id,$thisday);
										$qte = $Lot_prod->qte + $Vente->Quantite;
										$prix= $qte * $Lot_prod->prix_achat ;
										$valeur_stock += $prix;
										if ($qte > 0) {
										echo number_format($prix,2,'.',' ').'<br>'  ;
										unset($qte);
									}
									} ?>
								</td>
								<td>
								<?php foreach ($Lot_prods as $Lot_prod) {
									$Vente = Vente::somme_qte_par_lot_and_date($Lot_prod->id,$thisday);
										$qte = $Lot_prod->qte + $Vente->Quantite;
										if ($qte > 0) {
										if ($Lot_prod->qte <= $produit->alerte){ 
														
														echo '<i class="fa fa-circle font-red-haze"></i> <br>' ;
													}else { echo '<i class="fa fa-circle font-green-jungle"></i> <br>' ;}
										}
									
									} ?>
																				
								
								</td>
							
								
							</tr>

							<?php
								}
							?>
						
							</tbody>
                                        </table>
						<div class="well" style="text-align: right;">
						
						Valeur en stock
						 <span class="grey-cascade ">  : <b><?php echo number_format($valeur_stock,2,'.',' ') ;?> DA </b></span>
						</div>
                </div>
						</div>
                         
                         </div>
                         </div>
                            <!-- END GENERAL PORTLET-->
                          
                            
                            
                            <!-- END WELLS PORTLET-->
                       

				</div>
			<?php }elseif ($action='stock_par_date'){?>
					<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">
				<div class="page-bar">
					<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=stock_par_date" method="POST" class="form-horizontal">

											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
											
												
													<label class="col-md-3 control-label">Choisir une date</label>
													<div class="col-md-4">
														<div class="input-group">
															<input type="date" name = "date" class="form-control" value="<?php echo $date_db; ?>" required >
															<span class="input-group-btn">
															<button type="submit" name = "submit" class="btn blue">Envoyer</button>
															</span>
															
														</div>
														
													</div>
												</div>														
												
											</div>
											
										</form>
										<!-- END FORM-->
										
									</div>
				</div>
				<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption ">
											<i class="fa  fa-database font-yellow bold"></i>Stock <span class="caption-helper"> </span>  
										</div>
										<div class="tools"><?php echo '<b>Stock jusqu a </b>' .  $date_db;?></div>

									</div>
								<div class="portlet-body">
                            <div class="row">
                                            <div class="col-md-12">
						
						

						<div class="table table-borderless">
                             <table class="table table-striped table-hover " id="sample_2">
                               <thead>
											<tr >
												<th >
													 Code
												</th>
												
												<th>
													 Produit
												</th>
												<th>
													 Unite
												</th>
												<th>
													Quantité
												</th>
												<th>
													 Lot
												</th>
												
												<th>
													 Prix achat
												</th>
												<th>
													 Valeur
												</th>
												<th>
													 Etat
												</th>
											</tr>
											</thead>           
							<tbody>
						<?php 
						$valeur_stock =0;
							$produits = Produit::trouve_produit_par_societe_and_date_lot($nav_societe->id_societe,$date_db); 

						
								foreach($produits as $produit){
									$cpt ++;
								$stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);
								?>
							<tr>
							
								<td>
									<a data-target="#Detail_Prod" name="<?php if (isset($produit->Designation)) {
										echo $produit->Designation;
									} ?>" data-toggle="modal" id="MyProd" value="<?php if(isset($produit->id_pro)){
										echo $produit->id_pro; } ?>"  class=""><?php if (isset($produit->code)) {
									echo '<i class="fa  fa-barcode font-yellow"></i> '. $produit->code;
									} ?></a>
								</td>
								<td>
									<?php if (isset($produit->Designation)) {
									echo $produit->Designation;
									} ?>
								</td>
								
								<td>
									
									<?php if (isset($produit->id_unite)) {
															$Unites = Unite::trouve_unite_par_id_unite($produit->id_unite);
															
															}
															foreach ($Unites as $unite){
																
																	if (isset($unite->unite)) {
															echo $unite->unite;}}?>
								</td>
								<td>
									<?php if (isset($produit->id_pro)) {
										if (isset($stock_prod->stock)) {
										echo $stock_prod->stock;
										}
									} ?> 
									
								</td>
								<td>
								<?php if (isset($produit->id_pro)) {
									$Lot_prods = Lot_prod::trouve_tous_lot_par_produit($produit->id_pro,$date_db);
									foreach ($Lot_prods as $Lot_prod) {
										$Vente = Vente::somme_qte_par_lot_and_date($Lot_prod->id,$date_db);
										$qte_glob = $Lot_prod->qte + $Vente->Quantite;
										if ($qte_glob > 0) {
										
										echo 'Date :'.fr_date2($Lot_prod->date_lot).' | Code : '.$Lot_prod->code_lot.' | Qte: '.$qte_glob.' <br>'  ;
										unset($qte_glob);

										}
										
									}
									} ?>
								</td>
								
								<td>
								<?php foreach ($Lot_prods as $Lot_prod) {
										
										$qte_glob = $Lot_prod->qte + $Vente->Quantite;
										if ($qte_glob > 0) {
										echo number_format($Lot_prod->prix_achat,2,'.',' ').'<br>'  ;
										unset($qte_glob);
											
										}
									} ?>
								</td>
								<td>
									<?php foreach ($Lot_prods as $Lot_prod) {

										$Vente = Vente::somme_qte_par_lot_and_date($Lot_prod->id,$date_db);
										$qte = $Lot_prod->qte + $Vente->Quantite;
										$prix = $qte * $Lot_prod->prix_achat ;
										$valeur_stock = $valeur_stock + $prix;
										if ($qte

										 > 0) {
										echo number_format($prix,2,'.',' ').'<br>'  ;
										unset($qte);
									}
										

										
									} ?>
								</td>
								<td>
								<?php foreach ($Lot_prods as $Lot_prod) {
									$Vente = Vente::somme_qte_par_lot_and_date($Lot_prod->id,$date_db);
										$qte = $Lot_prod->qte + $Vente->Quantite;
										if ($qte > 0) {
										if ($Lot_prod->qte <= $produit->alerte){ 
														
														echo '<i class="fa fa-circle font-red-haze"></i> <br>' ;
													}else { echo '<i class="fa fa-circle font-green-jungle"></i> <br>' ;}
										}
									
									} ?>
																				
								
								</td>
							
								
							</tr>

							<?php
							//unset($valeur_stock);
								}
							?>
						
							</tbody>
                                        </table>
						<div class="well" style="text-align: right;">
						
						Valeur en stock
						 <span class="grey-cascade ">  : <b><?php echo number_format($valeur_stock,2,'.',' ') ;?> DA </b></span>
						</div>
                </div>			<div class="pull-right">
							
                                    <span type="button" value="Retour" onclick="history.go(-1)" class="btn btn-sm bg-blue" title="list reglement">
									 retour <i class="fa fa-angle-double-left"> </i></span> 
                                  
												   
												   </div>
						</div>
                         
                         </div>
                         </div>
                            <!-- END GENERAL PORTLET-->
                          
                            
                            
                            <!-- END WELLS PORTLET-->
                       

				</div>
			
			
			<?php }}?>
		</div>
		</div>
	</div>
	</div>
	</div>
	<!-- END CONTENT -->
	
<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>