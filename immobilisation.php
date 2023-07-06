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
$titre = "ThreeSoft | Immobilisations ";
$active_menu = "Immobilisations";
$active_submenu = "list_immobilisations";
$header = array('table');
$footer = array('dataTable');

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

	$thisday=date('Y-m-d');
	if (isset($_GET['action']) && $_GET['action'] =='famille_immobilisations' ) {
		$active_submenu = "immobilisations";
		$active_submenu = "famille_immobilisations";
		$action = 'famille_immobilisations';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='edit_famille_immobilisations' ) {
		$active_menu = "immobilisations";
		$action = 'edit_famille_immobilisations';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='list_immobilisations' ) {
		$active_menu = "immobilisations";
		$action = 'list_immobilisations';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='add_immobilisations' ) {
		$active_menu = "immobilisations";
		$active_submenu = "list_immobilisations";
		$action = 'add_immobilisations';
	}
	else if (isset($_GET['action']) && $_GET['action'] =='ammortissement' ) {
		$active_menu = "immobilisations";
		$active_submenu = "list_immobilisations";
		$action = 'ammortissement';
	}
?>
<?php
		// Ajouter depense	
	if(isset ($_POST['submit']) && $action == 'famille_immobilisations' ){
	$errors = array();
 	$random_number = rand();
	
		// new object 

	// new object admin 
	if (!isset($_POST['code'])||empty($_POST['code'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Code est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['libelle'])||empty($_POST['libelle'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Famille est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['type_amortissement'])||empty($_POST['type_amortissement'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ type amortissement est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['duree'])||empty($_POST['duree'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Durée est vides  !","Attention");
				  });
                  </script>';
	}
	
	$famille_immobili = new Famille_immobilisation();
		
	$famille_immobili->id_societe = htmlentities(trim($_POST['id_societe']));
	$famille_immobili->id_user = htmlentities(trim($_POST['id_user']));
	$famille_immobili->code = htmlentities(trim($_POST['code']));
	$famille_immobili->libelle = htmlentities(trim($_POST['libelle']));
	$famille_immobili->type_amortissement = htmlentities(trim($_POST['type_amortissement']));
	$famille_immobili->duree = htmlentities(trim($_POST['duree']));
	$famille_immobili->journal_achat = 1;
	$famille_immobili->journal_dotation = 7;
	$famille_immobili->journal_cession = 7;
	$famille_immobili->random = $random_number;
	
	if (empty($errors)){
if ($famille_immobili->existe()) {

	echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.warning("Famille immobilisation- existe déja  !","Très Bien");
				  });
                  </script>';
			
		}else{
			$famille_immobili->save();
			

		$last_id_famil = Famille_immobilisation::trouve_par_random($random_number);
		
		if (isset($last_id_famil->id_societe)){
				
			$compt_tva_immob = Compte_comptable::trouve_par_compt_tva_immobilisation_par_societe($last_id_famil->id_societe);
						 
				 $edit_famil = Famille_immobilisation:: trouve_par_id($last_id_famil->id);
				 
					$edit_famil->comptes_tva = $compt_tva_immob->id;
					$edit_famil->save();
					
			
			 }
		 if (isset($last_id_famil->id_societe)){
			$compt_amortissement = Compte_comptable::trouve_par_compt_Dotation_amortissement_par_societe($last_id_famil->id_societe);
						 
				 $edit_dotation = Famille_immobilisation:: trouve_par_id($last_id_famil->id);
				 
					$edit_dotation->comptes_dotation = $compt_amortissement->id;
					$edit_dotation->save();
			
			 }
	echo '<script type="text/javascript">
			$(document).ready(function(){
                 toastr.success("Famille immobilisation est enregistrer  avec succes  !","Très Bien");
				  });
                  </script>';
	}
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
                        <a href="#">Famille d'immobilisation</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php if ($action == 'add_client') { ?>
                        <a href="#"><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?></a> 
                        
                        
                    <?php }elseif ($action == 'famille_immobilisations') {
                        echo '<a href="immobilisation.php?action=famille_immobilisations">Famille d Immobilisations</a> ';
                    } elseif ($action == 'edit') {
                        echo '<a href="client.php?action=edit_client">Modifier Client</a> ';
                    } ?>
                        
                    </li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
		<?php if ($user->type == 'administrateur') {			
					if ($action == 'famille_immobilisations') {
				
				?>
			<div class="notification"></div>
			<div class="row">
				<div class="col-md-8">
				
				
				<?php

				$famille_immobilisations = Famille_immobilisation::trouve_famille_immobilisation_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-share font-yellow"></i>Famille d'Immobilisations
							</div>
						</div>
							
						<div class="portlet-body">
						<div class="table ">
							<table class="table table-striped  table-hover" id="sample_4">
							<thead>
							<tr>
								
								<th>
									Famille
								</th>
								
								<th>
									Code 
								</th>
								<th>
									Type d'amortissement
 
								</th>
								<th>
									Durée 
								</th>
								<th>
									# 
								</th>
								
							</tr>
							</thead>
							<tbody>
								<?php
								
								foreach($famille_immobilisations as $famille_immobilisation){
									$cpt ++;
								?>
								
							<tr class="item">
								
								<td>
					
								<?php if (isset($famille_immobilisation->libelle)) {
									
									
									echo '<i class="fa fa-share-alt font-blue"></i><b> '. $famille_immobilisation->libelle.'</b>';
									} ?>
								</td>
								
								<td>
								<?php if (isset($famille_immobilisation->code  )) {
									echo '<i class="fa fa-barcode font-blue"></i><b> '. $famille_immobilisation->code  ;
									} ?>
									
								</td>
								<td>
								<?php if (isset($famille_immobilisation->type_amortissement)) {
									switch ($famille_immobilisation->type_amortissement){
										case 0:
											echo "/";
											break;
										case 1:
											echo "Linéaire";
											break;
										case 2:
											echo "Dégressif";
											break;
										case 3:
											echo "Non Amortisable";
											break;
									}
									
									} ?>
									
								</td>
								<td>
								<?php if (isset($famille_immobilisation->duree   )) {
									echo $famille_immobilisation->duree .' mois'   ;
									} ?>
								</td>
								<td>									
									<a href="immobilisation.php?action=famille_immobi&id=<?php echo $famille_immobilisation->id; ?>" class="btn blue btn-xs">
                                            <i class="fa fa-edit "></i> </a>
									<button id="del_famille_immobil" value="<?php echo $famille_immobilisation->id; ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_famille_immobil" data-toggle="modal"></i> </button>
									
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
				<div class="col-md-4">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-plus font-yellow"></i> Nouveau Famille d'Immobilisations
							</div>
						</div>
					<div class=" notification "></div>
					<div class="portlet-body form">
						<!-- BEGIN FORM-->
						<form action="<?php echo $_SERVER['PHP_SELF']?>?action=famille_immobilisations" method="POST" role="form" class="form-horizontal" enctype="multipart/form-data">
					
						<input type="hidden" name="id_societe" id="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe; } ?>">	   
						<input type="hidden" name="id_user" id="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">
							<div class="form-body">
								<div class="form-group">
								<label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span></label> 
									<div class="col-md-9"> 
									 <input type="text" class="form-control" name = "code" id="code" placeholder="code" >  
									</div> 
								</div>
								<div class="form-group">
								<label class="col-md-3 control-label">Famille <span class="required" aria-required="true"> * </span></label> 
									<div class="col-md-9"> 
									 <input type="text" class="form-control" name = "libelle" id="libelle" placeholder="Famille" >  
									</div> 
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">Type <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-9">
									
										<select class="form-control select" name="type_amortissement" id="type_amortissement" placeholder="Choisir dans la list  "   >
										<option></option>
										<option value="1">Linéaire</option>
										<option value="2">Dégressif</option>
										<option value="3">Non Amortisable</option>
										</select>
									
									</div>
								</div>
								<div class="form-group">
								<label class="col-md-3 control-label">Durée <span class="required" aria-required="true"> * </span></label> 
									<div class="col-md-9"> 
									 <input type="number" class="form-control" name="duree" id="duree" min="0" placeholder="Durée" >  
									 <span class="help-block">Durée en mois exemple: 24 mois </span>
									</div> 
								</div>
							</div>
								<div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button id="" type="submit" name="submit"  class="btn green">Enregistrer</button>
                                            <button type="button" class="btn default">Annuler</button>
                                        </div>
                                    </div>
                                </div>
							
						</form>
						<!-- END FORM-->
						</div>
					</div>
				</div>				
			</div>
			</div>
	<!-- END ADD FAMILLE IMMOBIL -->
	
	<!-- BEGIEN IMMOBILISATION -->
	
		<?php }else if ($action == 'list_immobilisations') {
				
		?>
			<div class="row">
				<div class="col-md-12">
				
				
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				
				<?php

				$immobilisations = Immobilisation::trouve_immobilisation_par_societe($nav_societe->id_societe); 
				$cpt = 0; ?>

						

					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-building font-yellow"></i>Liste d'Immobilisations
							 </div>
						</div>
						<div class="col-md-4">
							<a  href="immobilisation.php?action=add_immobilisations" class="btn red"  ><i class="fa  fa-plus "></i> Créer Immobilisation</a>
							
						</div>
							
						<div class="portlet-body">
						<div class="table ">
						
							<table class="table table-striped  table-hover" id="MDatatab" >
							<thead>
							<tr>								
								<th>
									Code
								</th>
								<th>
									Famille
								</th>
								<th>
									Libellé 
								</th>
								<th>
									Nature
								</th>
								<th>
									Type d'amortissement 
								</th>
								<th>
									Taux d'amortissement
								</th>
								<th>
									Date d'achat 
								</th>
								<th>
									Valeur d'achat
								</th>
								<th>
									Fournisseur
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
								foreach($immobilisations as $immobilisation){
									$cpt ++;
								?>
							
							<tr>
								<td>
					
								<?php if (isset($immobilisation->code)) {?>
									
										<i class="fa fa-barcode font-yellow"></i><b><a href="immobilisation.php?action=ammortissement&id_immobil=<?php $last_ammort= Amortissement::trouve_par_id_immobil($immobilisation->id); echo $last_ammort->id_immobil; ?>"> <?php echo $immobilisation->code;?></a></b>
								<?php	} ?>
								</td>
								<td>
					
								<?php if (isset($immobilisation->id_famille)) {
									$famille_immob= Famille_immobilisation::trouve_par_id($immobilisation->id_famille);
									if(isset($famille_immob->libelle)){
									echo '<i class="fa fa-share-alt font-yellow"></i> '. $famille_immob->libelle.'';
								}} ?>
								</td>
								
								<td>
								<?php if (isset($immobilisation->libelle  )) {
									echo $immobilisation->libelle  ;
									} ?>
									
								</td>
								<td>
								<?php if (isset($immobilisation->nature)) {
										if ($immobilisation->nature == 1){
											echo 'Immobilisation';
										}else if ($immobilisation->nature == 2){
											 echo 'Crédit-Bail';
										}else{ echo '/';}
										
									} ?>
									
								</td>
								<td>
								<?php if (isset($immobilisation->type_amortissement)) {
									switch ($immobilisation->type_amortissement){
										case 0:
											echo "/";
											break;
										case 1:
											echo "Linéaire";
											break;
										case 2:
											echo "Dégressif";
											break;
										case 3:
											echo "Non Amortisable";
											break;
									}
									
									} ?>
									
								</td>
								<td>
								<?php if (isset($immobilisation->taux   )) {
									echo $immobilisation->taux   ;
									} ?>								
							
								</td>
								<td>
								<?php if (isset($immobilisation->date   )) {
									echo $immobilisation->date   ;
									} ?>									
							
								</td>
								<td>
								<?php if (isset($immobilisation->valeur_achat   )) {
									echo $immobilisation->valeur_achat   ;
									} ?>
								</td>
								
								<td>
								<?php if (isset($immobilisation->id_fournisseur   )) {
									$fournisseur=Fournisseur::trouve_par_id($immobilisation->id_fournisseur);
									echo '<i class="fa fa-user font-yellow"></i> '.$fournisseur->nom   ;
									} ?>
								</td>
								<td>
									<?php if (!empty($immobilisation->facture_scan)) {
										 $file = str_replace (" ", "_", $nav_societe->Dossier );
										 $ScanImage = Upload::trouve_par_id($immobilisation->facture_scan);
									echo '<a target="_blank" href="scan/upload/'.$file.'/'.$ScanImage->img .'" class="btn bg-green-jungle fancybox-button btn-xs" ><i class="fa fa-eye"></i></a>';
									
									} ?>
									
								</td>
								<td>									
									<a value="<?php if (isset($immobilisation->id)){echo $immobilisation->id; }?>" id="edit_immobi"  name="<?php if (isset($immobilisation->code)) {echo $immobilisation->code;} ?>" data-target="#edit_immobil" data-toggle="modal" class="btn blue btn-xs">
                                            <i class="fa fa-edit "></i> </a>
									<button id="del_immobil" value="<?php echo $immobilisation->id; ?>" class="btn red btn-xs"> <i class="fa fa-trash" data-target="#delete_immobil" data-toggle="modal"></i> </button>
									
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
	<!-- END LISTE IMMOBILISATION -->
	
	<!-- BEGIEN ADD IMMOBILISATION -->
		<?php } elseif ($action=='add_immobilisations'){
		
				
				?>
		<div class="row">
		
			<div class="col-md-8">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							
							<div class="caption  bold">
								<i class="fa  fa-building font-yellow"></i> Nouveau Immobilisation
							</div>
						</div>
				
				<div class=" notification "></div>
					<div class="portlet-body">
					<div class="portlet-body form">
					<!-- BEGIN FORM-->
					<form   id="immobil_form"   class="form-horizontal" enctype="multipart/form-data">				
						<div class="form-body">
						<h4 class="form-section text-info"><b>Immobilisation</b></h4>
						<input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe; } ?>">	   
						<input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">
								<div class="form-group">
								<label class="col-md-3 control-label">Date Immobilisation<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="date"  name="date" id="date" value="<?php echo $thisday;?>" class="form-control date" placeholder=" "    required />
								</div>
								</div>
								<div class="form-group">
								<label class="col-md-3 control-label">Famille<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-6">
									<select class="form-control select"   id="id_famille"  name="id_famille"   placeholder="Selctionner Famille" >
										<option >Selctionner une famille</option>
										<?php

										$famille_immobil = Famille_immobilisation::trouve_famille_immobilisation_par_societe($nav_societe->id_societe);
		
										foreach($famille_immobil as $famille_immo){ ?>
										<option value="<?php if(isset($famille_immo->id)){echo $famille_immo->id; } ?>"><?php if (isset($famille_immo->libelle)) {echo $famille_immo->libelle;} ?> </option>
											
											<?php } ?>														   
									</select> 
								</div>									
								</div>
								<div class="form-group">
								<label class="col-md-3 control-label">Type d'amortissement<span class="required" aria-required="true"> * </span></label>
									<div class="col-md-6">
										<div class="type_amortissement">
											<select class="form-control select" readonly>
											<option></option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
								<label class="col-md-3 control-label">Type<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-6">
								<select class="form-control select2me"    name="type" id="type"  placeholder="Choisir un Type" >
										<option ></option>
										<option value="1">Acquisition</option>
										<option value="2">Apport</option>
										<option value="3">Création</option>
								</select>
								</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Code<span class="required" aria-required="true"> * </span></label>
									 <div class="col-md-6">
									<input type="text"  name="code"  id="code"  class="form-control code"  placeholder=" " required />
								</div>
								</div>
								<div class="form-group">
								<label class="col-md-3 control-label">Libellé<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-6">
									<input type="text" class="form-control  libelle"   id="libelle"  name="libelle" placeholder=" "    required />								 
								</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Nature<span class="required" aria-required="true"> * </span></label>
									 <div class="col-md-6">
									<select class="form-control select2me"    name="nature" id="nature"  placeholder="Choisir une nature" >
										<option ></option>
										<option value="1">Immobilisation</option>
										<option value="2">Crédit-Bail</option>
										
									</select>									
								</div>
								</div>
								<h4 class="form-section text-info"><b>Amortir fiscalement</b></h4>
								
								<div class="form-group" >
								<label class="col-md-3 control-label">Immobilisation ANDI<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									
									<div class="radio-list" required>
										<label class="radio-inline">
											<input type="radio" name="andi" id="chkYes" value="1" > Oui </label>
										<label class="radio-inline">
											<input type="radio" name="andi" id="chkNo" value="0" checked> Non </label>
										<label class="radio-inline">
															
									</div>
								</div>
								</div>
								<div class="form-group" >
								<label class="col-md-3 control-label">N° Facture<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="text"  name="N_facture" id="N_facture" class="form-control " placeholder="N° Facture"    required />
								</div>
								</div>
								
								
								<div class="form-group" >
								<label class="col-md-3 control-label">N° Décision ANDI<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="text"  name="N_andi" id="N_andi" class="form-control " placeholder="N° Décision ANDI"    required />
								</div>
								</div>
								<div class="form-group" >
								<label class="col-md-3 control-label">Valeur à Amortir fiscalement<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
								 <input type="number"  name="valeur_amortir_fiscal" id="valeur_amortir_fiscal" class="form-control " placeholder="00.00"    required />
								</div>
								</div>
								<div id="calcule_ttc">
								<div class="form-group" >
								<label class="col-md-3 control-label">Valeur d'achat HT<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="number" min="0" name="valeur_achat" id="valeur_achat" class="form-control sum_ttc" placeholder="00.00"    required />
								</div>
								</div>
								<div class="form-group" >
								<label class="col-md-3 control-label">TVA<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="number" min="0" name="tva" id="tva" class="form-control sum_ttc" placeholder="00"    required />
								</div>
								</div>
								<div class="form-group" >
								<label class="col-md-3 control-label">Autres Frais<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="number" min="0" name="autre_frais" id="autre_frais" class="form-control sum_ttc" placeholder="00.00"    required />
								</div>
								</div>
								<div class="form-group" >
								<label class="col-md-3 control-label">TTC<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="number" min="0" name="ttc" id="ttc" class="form-control " placeholder="00.00" readonly />
								</div>
								</div>
								</div>
								
								<div class="form-group">
								<label class="col-md-3 control-label">Date Achat<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="date"  name="date_achat" id="date_achat"  class="form-control " placeholder=" date achat"    required />
								</div>
								</div>
								<h4 class="form-section text-info"><b>Amortissement</b></h4>
								<div class="form-group">
								<label class="col-md-3 control-label">Date Début Amortissement<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="date"  name="date_debut_amortissement" id="date_debut_amortissement"  class="form-control " placeholder=" date"    required />
								</div>
								</div>
								<div class="form-group">
								<label class="col-md-3 control-label">Nombre de mois<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="number" min="0" name="duree" id="duree" class="form-control" placeholder=" 00"    required />
									<span class="help-block">Durée en mois exemple: 3mois </span>
								</div>
								</div>
								<div class="form-group">
								<label class="col-md-3 control-label">Taux<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="number" min="0" name="taux" id="taux" class="form-control taux" placeholder="00.00" readonly />
								</div>
								</div>
								
								<div class="form-group">
								<label class="col-md-3 control-label">Date Fin<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									<input type="date"  name="date_fin" id="date_fin"  class="form-control " placeholder=" date fin"  readonly required />
								</div>
								</div>
								<h4 class="form-section text-info"><b>Cession</b></h4>
								<div class="form-group" >
								<label class="col-md-3 control-label">Cession<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-4">
									
									<div class="radio-list" required>
										<label class="radio-inline">
											<input type="radio" name="cession" id="optionsRadios25" value="1" checked> Oui </label>
										<label class="radio-inline">
											<input type="radio" name="cession" id="optionsRadios26" value="0" checked> Non </label>
										<label class="radio-inline">
															
									</div>
								</div>
								</div>
								<div id="dvPinNo" style="display: none">
								<div class="form-group">
									<label class="col-md-3 control-label">Type de Cession <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-4">
									
										<select class="form-control select2me" name="type_cession" id="type_cession" placeholder="Choisir dans la list  "   >
										<option ></option>
										<option value="1">Cession</option>
										<option value="2">Rebut</option>
										
										</select>
									
									</div>
								</div>
								<div id="calcule_cession">
									<div class="form-group" >
									<label class="col-md-3 control-label">Prix de cession HT<span class="required" aria-required="true"> * </span></label>
									 <div class="col-md-4">
										<input type="number" min="0" name="prix_cession" id="prix_cession" class="form-control som_ttc" placeholder="00.00"    required />
									</div>
									</div>
									<div class="form-group" >
									<label class="col-md-3 control-label">TVA<span class="required" aria-required="true"> * </span></label>
									 <div class="col-md-4">
										<input type="number" min="0"  name="tva_cession" id="tva_cession" class="form-control som_ttc" placeholder="00"    required />
									</div>
									</div>
								
									<div class="form-group" >
									<label class="col-md-3 control-label">TTC<span class="required" aria-required="true"> * </span></label>
									 <div class="col-md-4">
										<input type="number" min="0" name="ttc_cession" id="ttc_cession" class="form-control " placeholder="00.00" readonly />
									</div>
									</div>
								</div>
								</div>
								<h4 class="form-section text-info"><b>Fournisseur</b></h4>
								<div class="form-group">
								<label class="col-md-3 control-label">Fournisseur<span class="required" aria-required="true"> * </span></label>
								 <div class="col-md-6">
									<select class="form-control select2me"    name="id_fournisseur" id="id_fournisseur"  placeholder="Choisir fournisseur" >
								
									<option value=""></option>
									<?php 
											$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 
										foreach ($fournisseurs as $fournisseur) { ?>
										<option value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>"><?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->nom;} ?> </option>
									<?php } ?>	
										
																	   
								</select>  
								</div>
								</div>
								<h4 class="form-section text-info"><b>Compte comtable</b></h4>
								<div class="form-group">
									<label class="col-md-3 control-label">Compte Immobilisation <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-6">
												
										<select class="form-control select2me" id="comptes_immobilisation"  name="comptes_immobilisation">
												
										<?php 															
										$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
											foreach($Comptes as $Compte){?>

											<option value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
										<?php } ?>																   
										</select>
									
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Compte Amortissement <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-6">
									
										<select class="form-control select2me" id="comptes_amortissement"  name="comptes_amortissement">
												
										<?php 															
										$Comptes = Compte_comptable::trouve_compte_comptable_par_societe($nav_societe->id_societe);
															
											foreach($Comptes as $Compte){?>

											<option value = "<?php echo $Compte->id ?>"  > <?php echo $Compte->code .' | '. $Compte->libelle . ' | '. $Compte->prefixe ?></option>
														
										<?php } ?>																   
										</select>
									
									</div>
								</div>
								
								<input type="hidden" name="facture_scan" value="<?php if (isset($_GET['id_img'])) {	 $image =  htmlspecialchars($_GET['id_img']) ; echo  $image ; }?>" />
							
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
								<a  class="btn  green" id="save_immobilisation"  > <i class="fa fa-check "></i>  Enregistrer Immobilisation </a>
								<button type="reset" class="btn btn-default btn-danger">Annuler</button>
								</div>
                            </div>
                        </div>

						
		
					</div>
				</form>	
					<!-- END FORM-->
			</div>
			</div>
				</div>
					
			</div>
					<div class="col-md-4 list-group-item bg-blue-chambray margin-bottom-30">
					<div class=" bg-blue-ebonyclay">
					
							<p>Scan du Facture Depense</p>
				
				</div>
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
				<?php if (isset($image)){
				
					$info = new SplFileInfo($img_select->img);
					$errors[]= 'VIDE !';
					if($info->getExtension() == 'pdf'){?>
					
					<object data="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" type="application/pdf" width="100%" height="1000">
					<?php if (!empty($msg_error)) {?>
						<object data="assets/image/test.pdf" type="application/pdf" width="100%" height="1000">
						alt : <a href="assets/image/test.pdf">test.pdf</a>
						</object> 
						<?php }?>
					</object>

						<?php }else {?>
							

					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" class="img-responsive fancybox-button "><img class="img-responsive margin-bottom-30" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""   ></a>
				
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-retweet"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-download"></i></a>
						<a href="#form_modal11" data-toggle="modal" class="btn bg-grey-cascade btn-sm " ><i class="fa fa-share-alt"></i></a>
					
								<?php }?>
	
				
				
				<?php }else {echo '<a href="#form_modal14" data-toggle="modal"><i class="fa fa-caret-square-o-right font-green-jungle"></i>
								Selctionner une image 
				</a>';}?>				
				</div>
			
		</div>
		
		<!-- BEGIEN AMMORTISSEMENT -->
			<?php } elseif ($action=='ammortissement'){
					$cpt=0;
					$total_days=0;
					$do=0 ;	
					$VA=0;
					$cmule=0;
					$dotation_fiscale=0;
					$ecart=0;
					
					if (isset($_GET['id_immobil'])) {
					 $id_immobils =  htmlspecialchars($_GET['id_immobil']) ;
					 
					 $select_ammortissements = Amortissement::trouve_immobilisation_par_id_immobil ($id_immobils);
					  
					}else{
						echo '<script type="text/javascript">
							$(document).ready(function(){
								  toastr.error("aucune Ammortissement sélectionné  ....  !","Attention");
								  });
								  </script>';
							
					}	
			?>
		<div class="row">

			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light bordered">
					<div class="portlet-title">
						
						<div class="caption  bold">
							<i class="fa  fa-building font-yellow"></i> Ammortissement
						</div>
					</div>
				
			
				<div class="portlet-body">
					<div class="invoice">
					<div class="row invoice-logo" >
								<div class="col-xs-4 invoice-logo-space">
								<h3><b> <?php if (isset($id_immobils ) ){ $immobil =Immobilisation::trouve_par_id($id_immobils); echo "Code : " .$immobil->code ;} ?></b></h3>
						<ul class="list-unstyled">
							<li>
								<?php if (isset($immobil->libelle)) {
									echo "Libelle : ".$immobil->libelle;
								} ?>
							</li>
							<li>
								 <?php if (isset($immobil->nature)) {
									if ($immobil->nature == 1){
										echo 'Nature :Immobilisation';
									}else if ($immobil->nature == 2){
										echo 'Nature : Immobilisation';
										 echo 'Nature : Crédit-Bail';
									}else{ echo 'Nature : /';}
									
								} ?>
							</li>
							<li>
								 <?php if (isset($immobil->date_debut_amortissement)) {
									echo 'Date debut amortissement : '. $immobil->date_debut_amortissement;
								} ?>
							</li>
						</ul>
							</div>
								
					</div>
					<hr/>
					<div class="row">
					
					<div class="col-xs-12">
						<div class="table ">
							<table class="table table-bordered" >
							<thead>
							<tr>
								<th></th>
								<th>
									Date
								</th>
								
								<th>
									Durée 
								</th>
								<th>
									Valeur à Amortir
								</th>
								<th>
									Dotation 
								</th>
								<th>
									Dotation Cumulée 
								</th>
								<th>
									VNC 
								</th>
								<th>
									Dotation Fiscale
								</th>
								<th>
									Ecart
								</th>
								<th>
									REST
								</th>
							</tr>
							</thead>
							<tbody>
								<?php
								
								foreach($select_ammortissements as $select_ammortissement){
									$cpt ++;
								?>
								
							<tr >
								
								<td><?php echo $cpt;?></td>
								<td>
					
								<?php if (isset($select_ammortissement->date)) {
									
									
									echo '<b> '. $select_ammortissement->date.'</b>';
									} ?>
								</td>
								
								<td>
								<?php if (isset($select_ammortissement->dure  )) {
									 $total_days += $select_ammortissement->dure ; 
									echo '<b> '. $select_ammortissement->dure  ;
									} ?>
									
								</td>
								<td>
								<?php  if (isset($select_ammortissement->valeur_amortir)) {
									$VA += $select_ammortissement->valeur_amortir ;
									echo $select_ammortissement->valeur_amortir;									
									} ?>
									
								</td>
								<td>
								<?php 	 if (isset($select_ammortissement->dotation   )) {
									$do +=$select_ammortissement->dotation;
									echo $select_ammortissement->dotation   ;
									} ?>
								</td>
								<td>
								<?php if (isset($select_ammortissement->dotation_cumulee   )) {
									$cmule +=$select_ammortissement->dotation_cumulee;
									echo $select_ammortissement->dotation_cumulee;
									} ?>
								</td>
								<td>
								<?php if (isset($select_ammortissement->vnc   )) {
									echo $select_ammortissement->vnc;
									} ?>
								</td>
								<td>
								<?php if (isset($select_ammortissement->dotation_fiscale   )) {
									$dotation_fiscale += $select_ammortissement->dotation_fiscale;
									echo $select_ammortissement->dotation_fiscale;
									} ?>
								</td>
								<td>									
									<?php if (isset($select_ammortissement->ecart   )) {
										$ecart += $select_ammortissement->ecart;
									echo $select_ammortissement->ecart;
									} ?>
								</td>
								<td>									
									<?php if (isset($select_ammortissement->rest_jours   )) {
									echo $select_ammortissement->rest_jours;
									} ?>
								</td>							
							
							</tr>

							<?php
								}
							?>
						
							</tbody>
							<body>
							<tr>
							<td>totaux
							</td>
							<td>
							</td>
							<td><strong><?php   echo $total_days;?></strong></td>
							<td><strong><?php   echo $VA;?></strong></td>
							<td><strong><?php   echo $do;?></strong></td>
							<td><strong><?php   echo $cmule;?></strong></td>
							<td><strong></strong></td>
							<td><strong><?php   echo $dotation_fiscale;?></strong></td>
							<td><strong><?php   echo $ecart;?></strong></td>
							
							</tr>
							<body>
							
							</table>
							</div>
					</div>
						</div>
				</div>
			</div>
		</div>
<!-- END DISPLAY AMMORTISSEMENT-->
			</div>
		<?php }} ?>
		</div>		
	</div>
</div>
		</div>
	<!-- END  -->
	
<!-- BEGIEN MODEL EDIT IMMOBILISATION -->
	<div id="edit_immobil" class="modal container fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title prod-modaltitle"><i class="fa fa-building font-yellow"> </i> Edit Immobilisation </h4>
                                </div>

                                <div class="modalbody-immobil">
            
                                </div>
	</div>

   <!-- END modal versement -->
<script>

/////////////////////////// save immobilisation  ////////////////////////////////

$(document).on('click','#save_immobilisation', function() {
 
$.ajax({
type: "POST",
url: "ajax/save_immobile.php",
data: $('#immobil_form').serialize(),
success: function(message){
$(".notification").html(message)
},
error: function(){
alert("Error");
}
});
 
});

////////////////////////////////// onchange NATURE OPERATION ///////////////////////////

$(document).on('change','#id_famille', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.type_amortissement').load('ajax/onchange_famille_immo.php?id='+id+'&id_societe='+id_societe,function(){       
    });
}); 
////////////////////////////// CALCULE TTC////////////////////////////////////////////
$(document).ready(function(){
 
	
$("#calcule_ttc").on('input', '.sum_ttc', function () {
       var total_sum_ttc = 0;
     
       $("#calcule_ttc .sum_ttc").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              total_sum_ttc += parseFloat(get_textbox_value);
              }                  
            });
              $("#ttc").val(total_sum_ttc);
			 
			  
       });

});
////////////////////////////// SHOW HIED CESSION////////////////////////////////////////////
 $(function() {
   $("input[name='cession']").click(function() {
     if ($("#optionsRadios25").is(":checked")) {
       $("#dvPinNo").show();
     } else {
       $("#dvPinNo").hide();
     }
   });
 });
////////////////////////////// CALCULE TTC CESSION////////////////////////////////////////////
$(document).ready(function(){
 
	
$("#calcule_cession").on('input', '.som_ttc', function () {
       var total_som_ttc = 0;
     
       $("#calcule_cession .som_ttc").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              total_som_ttc += parseFloat(get_textbox_value);
              }                  
            });
              $("#ttc_cession").val(total_som_ttc);
			 
			  
       });

});
////////////////////////////// CALCULE TAUX////////////////////////////////////////////
  $(document).on("input", "#duree", function() {
            var main = $('#duree').val();
            var sum_taux = 12 / main;
            $('#taux').val(sum_taux);
        });
		
////////////////////////////////// onchange valeur_amortir_fiscal ///////////////////////////
$(function () {
        $("input[name='andi']").click(function () {
            if ($("#chkNo").is(":checked")) {
                $("#tva").removeAttr("disabled");
                $("#tva").focus();
            } else {
                $("#tva").attr("disabled", "disabled");
            }
        });
    });
/////////////////////// CALCLUER LA DATE FIN AMMORTISSEMENT ///////
(function($, window, document, undefined){
    $("#duree").on("change", function(){
       var date = new Date($("#date_debut_amortissement").val()),
           days = parseInt($("#duree").val());
        
        if(!isNaN(date.getTime())){
            date.setMonth(date.getMonth() + days);
            
            $("#date_fin").val(date.toInputFormat());
        } else {
            alert("Invalid Date");  
        }
    });
    
    
   
    Date.prototype.toInputFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = (this.getDate()-1).toString();
       return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
    };
})(jQuery, this, document);

 </script>

 

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>