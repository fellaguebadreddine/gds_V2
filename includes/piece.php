<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Accounts::trouve_par_id($session->id_utilisateur);
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
$titre = "ThreeSoft | Piéce Comptable ";
$active_menu = "saisie";
$header = array('table','invoice');
if ($user->type == "administrateur"){
if (isset($_GET['action']) && $_GET['action'] =='comptableser' ) {
$active_submenu = "list_pieces";
$action = 'comptableser';}
if (isset($_GET['action']) && $_GET['action'] =='update' ) {
$active_submenu = "list_pieces";
$action = 'update';}
// End of the main Submit conditional.
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
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
     $id = intval($_GET['id']);
     $Piece = Pieces_comptables::trouve_par_id($id);
if (isset($_GET['action']) && ( $_GET['action'] =='comptableser'  )) {

			echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.success(" Pièce comptable N°'.$Piece->ref_piece.' Ajouter avec succès","Très bien !");
        },300);
        });
			</script>';

} 
if (isset($_GET['action']) && ( $_GET['action'] =='update'  )) {

			echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.info(" Pièce comptable N°'.$Piece->ref_piece.' Modifier avec succès","Très bien !");
        },300);
        });
			</script>';

}    
 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
 	 $id = intval($_POST['id']);
     $Piece = Pieces_comptables::trouve_par_id($id);
	 
 }





 ?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
		<div class="container-fluid">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN STYLE CUSTOMIZER -->
			<!-- END STYLE CUSTOMIZER -->
			<!-- BEGIN PAGE HEADER-->
			<div class="page-bar">
				<ul class="page-breadcrumb breadcrumb">
					<li>
						<i class="fa fa-table"></i>
						<a href="#">Comptabité</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Pièce comptable</a>
					</li>
				</ul>
				<div class="page-toolbar">

				</div>
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN PAGE CONTENT-->
			<div class="notification"></div>
					<div class="portlet light">
					<div class="portlet-body">
				<div class="invoice">
							<div class="row invoice-logo" >
								<div class="col-xs-8 invoice-logo-space">
									<p style="text-align: left ; font-size: 18px;" >EPE: <?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?></p>
								</div>
								<div class="col-xs-4">
									<p style="text-align: left ; font-size: 18px;">
										 N°: <?php if (isset($Piece->id)) { echo sprintf("%04d", $Piece->id); } ?>
										<br>
										<span style="font-size: 14px;margin-top: 0px;" > DATE: <?php if (isset($Piece->date)) { echo fr_date2($Piece->date);
										 } ?> 
										 </span>
									</p>
									
								</div>
							</div>
							<div class="row invoice-logo" >
								
								<div class="col-xs-12">
									<p style="text-align: center ;">
										 FEUILLE D'IMPUTATION COMPTABLE
									</p>
									
								</div>
							</div>
					<hr/>
					<div class="row">
					<div class="col-xs-7">
						
						<ul class="list-unstyled" style="font-size: 14px;">
							<li style="margin:8px;">
									
									<?php  if(isset($Piece->somme_debit)){echo "<b>Montant : </b>".number_format($Piece->somme_debit , 2, ',', ' ');} else {echo "0.00 ";}  ?>
								
							</li>
							<li style="margin:8px;">
								 <?php if (isset($Piece->libelle)) {
									echo "<b>Libellé: </b>".$Piece->libelle;
								} ?>
								 
							</li>
							<li style="margin:8px;">
								<?php if (isset($Piece->journal) ){$Journal = Journaux::trouve_par_id($Piece->journal); 
									 if (isset($Journal->intitule)) {echo "<b>Journal :</b> ".$Journal->intitule;}
									} ?>
							</li>
							<li style="margin:8px;">
								<?php if (isset($Piece->ref_piece)) {
									echo "<b>Référence :</b> ".$Piece->ref_piece;
								} ?>
							</li>
							
							
							
						</ul>
					</div>
				
				</div>
				

				<div class="row">
					<div class="col-xs-12">
						<table class="table  table-bordered " >
							<thead>
							<tr>
								
								<th >
									Compte
								</th>
								<th>
									 Auxilière
								</th>
								
								<th>
									  Déblit
								</th>
								<th>
									Crédit
								</th>
								
								
							</tr>
							</thead>
							
							<tbody>
								<?php 
								if (isset($Piece->id)) {
								$Ecriture_comptables = Ecriture_comptable::trouve_ecriture_par_piece($Piece->id);

								}
								    foreach($Ecriture_comptables as $Ecriture_comptable){  ?>
							<tr class="item-row" >
								
								<td>
									<?php 
									 $Compte = Compte_comptable::trouve_par_id($Ecriture_comptable->id_compte);
									if (isset($Compte->id)) {echo $Compte->code;  echo  ' |  ' . $Compte->libelle ;} ?>
								</td>
								<td>
									<?php if (!empty($Ecriture_comptable->id_auxiliere)) {
									 $Auxiliere = Auxiliere::trouve_par_id($Ecriture_comptable->id_auxiliere);
									 if (isset($Auxiliere->libelle)) { echo  $Auxiliere->code.' | '.$Auxiliere->libelle; }
									} else { echo '<span style="text-align: center;">/</span>'; }?> 
								</td>
								
								<td>
									<?php if (isset($Ecriture_comptable->debit)) {
										echo number_format($Ecriture_comptable->debit , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($Ecriture_comptable->credit)) {
										echo number_format($Ecriture_comptable->credit , 2, ',', ' ');
									} ?>
								</td>
								
								
							</tr>
						<?php } ?>
							<tr>
									<td colspan="2"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL  : </strong></span></td>
									<td colspan="1" id="TOTALdebit" style="font-size: 14px;"><?php  if(isset($Piece->somme_debit)){echo  number_format($Piece->somme_debit , 2, ',', ' ');} else {echo "0.00";}  ?> </td>
									<td colspan="1" id="TOTALcredit" style="font-size: 14px;"><?php  if(isset($Piece->somme_credit)){echo number_format($Piece->somme_credit , 2, ',', ' ') ;} else {echo "0.00";}  ?> </td>
									
							    </tr>
								
							   
							   
                            </tbody>
							</table>
							

					</div>
				</div>
				<div class="row">
					<div class="col-xs-12" style="margin-top: 20px; font-size:14px;"><strong>Observation:</strong> </div>
				</div>
				<div class="row">
					<div class="col-xs-6" style="font-size:18px; margin-top: 10px; text-align: center;text-decoration: underline">VISA AGENT DE SAISIE</div>
					<div class="col-xs-6"style="font-size:18px; margin-top: 10px; text-align: center;text-decoration: underline">VISA COMPTABLE</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br/>
						<?php if (!empty($Ecriture_comptables)) {?>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
						 <i class="fa fa-print"></i> Imprimer
						</a>
					<?php } else { ?>
						<a class="btn btn-sm blue hidden-print margin-bottom-5" disabled >
						 <i class="fa fa-print"></i> Imprimer
						</a>
					<?php } ?>
					</div>
				</div>
			</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
</div>
<?php
require_once("footer/footer.php");
?>