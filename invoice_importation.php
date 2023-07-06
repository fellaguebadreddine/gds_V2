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
$titre = "ThreeSoft | Facture ";
$active_menu = "Facturation";
$header = array('table','invoice');
if ($user->type == "administrateur"){
if (isset($_GET['action']) && $_GET['action'] =='fact_achat' ) {
$active_submenu = "list_achat";
$action = 'fact_achat';}
else if (isset($_GET['action']) && $_GET['action'] =='update_achat' ) {
$active_submenu = "list_achat";
$action = 'update_achat';}
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
				$thisday=date('Y-m-d');
				$tvas = TVA::trouve_tous(); 
				$Articles = Produit::trouve_produit_par_societe($nav_societe->id_societe);
				$fournisseurs = Fournisseur::trouve_valid_par_societe($nav_societe->id_societe); 
?>
<?php 
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
     $id = intval($_GET['id']);
     $Fact = Facture_importation::trouve_par_id($id);
     $date = date_parse($Fact->date_fac);
if (isset($_GET['action']) && ( $_GET['action'] =='update' or  $_GET['action'] =='achat' )) {

			echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.success(" Facture achat N°'.sprintf("%04d", $Fact->N_facture).'/'.$date['year'].' Modifier avec succès","Très bien !");
        },300);
        });
			</script>';

}    
 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
 	 $id = intval($_POST['id']);
     $Fact = Facture_importation::trouve_par_id($id);
     $date = date_parse($Fact->date_fac);
	 
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
						<a href="#">Facturation</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<?php if ($action == 'fact_achat') { ?>
                        <a href="#">Facture Achat</a>  
                         <?php }else{?>
						<a href="#">Facture vente</a>
					<?php } ?>
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
								<div class="col-xs-4 invoice-logo-space">
									<img src="assets/admin/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
								</div>
								<div class="col-xs-8">
									<p>
										 FACTURE: <?php if (isset($Fact->N_facture)) { echo sprintf("%04d", $Fact->N_facture).'/'.$date['year']; } ?><span class="muted">
										 DATE: <?php if (isset($Fact->date_fac)) {
										 	echo fr_date2($Fact->date_fac);
										 } ?> </span>
									</p>
									
								</div>
							</div>
					<hr/>
					<div class="row">
				<div class="col-xs-7">
						<h3><b> <?php if (isset($nav_societe) ){echo $nav_societe->Dossier ;} ?></b></h3>
						<ul class="list-unstyled" style="font-size: 11px;">
							<li>
								<?php if (isset($nav_societe->Capital)) {
									echo "Au Capital Social de : ".$nav_societe->Capital;
								} ?>
							</li>
							<li>
								 <?php if (isset($nav_societe->Activite)) {
									echo $nav_societe->Activite;
								} ?>
							</li>
							<li>
								 <?php if (isset($nav_societe->Adresse)) {
									echo $nav_societe->Adresse;
								} ?>
								<br>
								<?php if (isset($nav_societe->Ville)) {
									echo $nav_societe->Ville;
								} ?>
								<?php if (isset($nav_societe->Postal)) {
									echo $nav_societe->Postal;
								} ?>
							</li>
							<li>
								 <?php if (isset($nav_societe->Rc)) {
									echo "<b>RC N°</b>: ". $nav_societe->Rc;
								} ?>
							</li>
							<li>
								 <?php if (isset($nav_societe->Mf)) {
									echo "<b>MF N°</b>: ". $nav_societe->Mf;
								} ?>
							</li>
							<li>
								 <?php if (isset($nav_societe->Ai)) {
									echo "<b>AI N°:</b> ". $nav_societe->Ai;
								} ?>
							</li>
							<li>
								 <?php if (isset($nav_societe->Nis)) {
									echo "<b>NIS N°: </b>". $nav_societe->Nis;
								} ?>
							</li>
							
							<li>
							<?php if (isset($nav_societe->id_societe)) {
											$banques = Banque::trouve_banque_par_societe_facture($nav_societe->id_societe);
											
											foreach ($banques as $banque){
												if (isset($banque->abreviation)) {
												  
												echo "<b>Banque:</b> ". $banque->abreviation;
												
											}
											if (isset($banque->Code)) {
												  
												
												echo "<b> </b> ". $banque->Code;
											}
											} }?>
							<?php if (isset($nav_societe->id_societe)) {
											
											$Comptes = Compte::trouve_compte_par_societe_facture($nav_societe->id_societe);
																					
											foreach ($Comptes as $Compte){
											  if (isset($Compte->num_compte)) {
												  
												echo "<b> / N°:</b> ". $Compte->num_compte;
							}}} ?>
							
							</li>
							
							
						</ul>
					</div>
					<div class="col-xs-5 invoice-payment">
						<?php if (isset($Fact->id_facture)) {
							$fournisseur = Fournisseur::trouve_par_id($Fact->id_fournisseur);
						}  ?>
						<h3><strong>Fournisseur: </strong><?php if (isset($fournisseur->nom)) {
									echo $fournisseur->nom;
								} ?></h3>
						<ul class="list-unstyled" style="font-size: 11px;">
							<li>
								 <?php if (isset($fournisseur->Adresse)) {
									echo $fournisseur->Adresse;
								} ?>
								
								<?php if (isset($fournisseur->Ville)) {
									echo $fournisseur->Ville;
								} ?>
								<?php if (isset($fournisseur->Postal)) {
									echo $fournisseur->Postal;
								} ?> 
							</li>
							<li>
								 <?php if (isset($fournisseur->Rc)) {
									echo "<b>RC N°</b>: ". $fournisseur->Rc;
								} ?>
							</li>
							<li>
								 <?php if (isset($fournisseur->Mf)) {
									echo "<b>MF N°</b>: ". $fournisseur->Mf;
								} ?>
							</li>
							<li>
								 <?php if (isset($fournisseur->Ai)) {
									echo "<b>AI N°:</b> ". $fournisseur->Ai;
								} ?>
							</li>
							<li>
								 <?php if (isset($fournisseur->Nis)) {
									echo "<b>NIS N°: </b>". $fournisseur->Nis;
								} ?>
							</li>
							<li>
								 <?php if (isset($fournisseur->NCompte)) {
									echo "<b>Banque N°:</b> ". $fournisseur->NCompte;
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
								<th width="20%">
									Désignation
								</th>
								<th>
									Valeur en DA	
								</th>
								<th>
									 Date
								</th>
								<th>
									N° facture
								</th>
								<th>
									 Montant HT 
								</th>
								<th>
									  T.V.A
								</th>
								<th>
									  Timbre
								</th>
							</tr>
							</thead>
							<tbody>
								<?php 
								if (isset($Fact->id_facture)) {
								$table_frais = Achat_importation::trouve_frais_par_facture($Fact->id_facture);
								}
								  foreach($table_frais as $table_frais){  ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($table_frais->Designation)) {
										$fournisseurs = Fournisseur::trouve_par_id($table_frais->Designation);
										echo $fournisseurs->nom;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->valeur_DA)) {
										echo number_format($table_frais->valeur_DA,2,'.',' ');
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->date_fact)) {
										echo fr_date2($table_frais->date_fact);
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->Num_facture)) {
										echo $table_frais->Num_facture;
									} ?>
								</td>
								
								<td>
									<?php if (isset($table_frais->Ht)) {
										echo number_format($table_frais->Ht , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->Tva)) {
										echo number_format($table_frais->Tva , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->timbre)) {
										echo number_format($table_frais->timbre , 2, ',', ' ');
									} ?>
								</td>
								
							</tr>
						<?php } ?>
							
								<tr>
									<td colspan="6"><span style="float : right;   font-size: 14px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 14px;"><?php  if(isset($Fact->somme_ht_frais)){echo number_format($Fact->somme_ht_frais , 2, ',', ' ');} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 14px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 14px;"> <?php  if(isset($Fact->somme_tva_frais)){echo number_format($Fact->somme_tva_frais , 2, ',', ' ');} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 14px; ;"><strong> TOTAL TIMBRE : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 14px;"> <?php  if(isset($Fact->somme_timbre_frais)){echo number_format($Fact->somme_timbre_frais , 2, ',', ' ');} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							     <tr>
									<td colspan="6"><span style="float : right;   font-size: 14px; ;"><strong> TOTAL TTC : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 14px;"> <?php  if(isset($Fact->somme_ttc_frais)){echo number_format($Fact->somme_ttc_frais , 2, ',', ' ');} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							   
                            </tbody>
							</table>
							<?php $table_achats = Achat_importation::trouve_achat_par_facture($Fact->id_facture); ?>
							<table class="table table-striped table-bordered table-hover" id="table_2" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								<th>
									Code
								</th>
								<th>
									 Quantité 
								</th>
								<th>
									  Prix U ($)
								</th>
								<th>
									Prix U (DA)
								</th>
								<th>
									  Remise
								</th>
								<th>
									Valeur achat ($)
								</th>
								<th>
									Valeur achat 
								</th>
								<th>
									Contre valeur 
								</th>
								
								
								
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_achats as $table_achat){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($table_achat->Designation)) {
										echo $table_achat->Designation;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Code)) {
										echo $table_achat->Code;
									} ?>
								</td>
								
								<td>
									<?php if (isset($table_achat->Quantite)) {
										echo $table_achat->Quantite;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix_devise)) {
										echo number_format($table_achat->Prix_devise , 2, ',', ' ').' $';
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo number_format($table_achat->Prix , 2, ',', ' ').' DA';
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Remise)) {
										echo number_format($table_achat->Remise , 2, ',', ' ');
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Ht_devise)) {
										echo number_format($table_achat->Ht_devise , 2, ',', ' ').' $';
									} ?>
									
								</td>
								<td>
									<?php if (isset($table_achat->Ht)) {
										echo number_format($table_achat->Ht , 2, ',', ' ').' DA';
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Contre_Valeur)) {
										echo number_format($table_achat->Contre_Valeur , 2, ',', ' ').' DA';
									} ?>
								</td>
								
								
								
							</tr>
						<?php } ?>

							
								
						
							
							<tbody class="total">
								<tr>
									<td colspan="7"><span style="float : right;   font-size: 14px; ;"><strong> TOTAL ACHAT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 14px;"><?php  if(isset($Fact->somme_ht)){echo number_format($Fact->somme_ht , 2, ',', ' ');} else {echo "0.00";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="7"><span style="float : right;   font-size: 14px; ;"><strong> SHIPPING : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 14px;"> <?php if (isset($Fact->shipping)) {echo number_format($Fact->shipping , 2, ',', ' ');  }  else {echo "0.00";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="7"><span style="float : right;   font-size: 14px; ;"><strong> TOTAL HT: </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 14px;"><?php  if(isset($Fact->somme_ttc)){echo number_format($Fact->somme_ttc+ $Fact->shipping , 2, ',', ' '); } else {echo "0.00";}  ?> $</span></td>
							    </tr>

										
                            </tbody>
							</table>

					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						
					</div>

					<div class="col-xs-6 invoice-block">
						
						<br/>
						<?php if (!empty($table_achats)) {?>
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
	</div>
	<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
<script>
	////////////////////////////////// onchange journal Paiement ///////////////////////////

$(document).on('change','#Journal', function() {
    var id = this.value;
    var id_fact = <?php if (isset($Fact->id_facture)) {echo $Fact->id_facture;} ?>;
     $('.mode-paiment_achat').load('ajax/get_paiement_achat.php?id='+id+'&id_fact='+id_fact,function(){       
    });
});
/////////////////////////// save Paiement Achat ////////////////////////////////

$(document).on('click','button#save_paiement_achat', function() {
	var id = <?php if (isset($Fact->id_facture)) {echo $Fact->id_facture;} ?>;
$.ajax({
type: "POST",
url: "ajax/save_paiement_achat.php",
data: $('#paiement_form_achat').serialize(),
success: function(message){
$(".notification").html(message)
},
error: function(){
alert("Error");
}
});
 $('.facture-payee').html('<div class="  alert alert-success hidden-print"><p><strong>NOTE: Facture payée.</strong></p></div>');
 $('.invoice-block').html('<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();" ><i class="fa fa-print"></i> Imprimer</a><a class="btn btn-sm green hidden-print margin-bottom-5" disabled ><i class="fa fa-credit-card"></i> Enregistrer un paiement</a>');
 $('.mode-paiement').load('ajax/get_mode_paiement.php?id_fact='+id+'&action=achat',function(){});
}); 
</script>
<?php
require_once("footer/footer.php");
?>