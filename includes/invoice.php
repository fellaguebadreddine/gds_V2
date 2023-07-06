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
if (isset($_GET['action']) && $_GET['action'] =='fact_vente' ) {
$active_submenu = "list_vente";
$action = 'fact_vente';}
else if (isset($_GET['action']) && $_GET['action'] =='fact_achat' ) {
$active_submenu = "list_vente";
$action = 'fact_achat';}
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
				$clients = Client::trouve_valid_par_societe($nav_societe->id_societe); 
?>
<?php 
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
     $id = intval($_GET['id']);
     $Fact = Facture_vente::trouve_par_id($id);
     $date = date_parse($Fact->date_fac);
if (isset($_GET['action']) &&( $_GET['action'] =='update' or  $_GET['action'] =='vente') ) {

			echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.success(" Facture achat N°'.sprintf("%04d", $Fact->N_facture).'/'.$date['year'].' Modifier avec succès","Très bien !");
        },300);
        });
			</script>';

}
 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
     $Fact = Facture_vente::trouve_par_id($id);
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
					<i class="fa fa-angle-right"></i>						
                        <a href="#">Facture vente</a>                     
					</li>
					<li>
						<i class="fa fa-angle-right"></i>
						<a href="#">Impréssion facture</a>
					</li>
				</ul>
				<div class="page-toolbar">

				</div>
			</div>
			<!-- END PAGE HEADER-->

				<div class="notification"></div>
			<!-- BEGIN PAGE CONTENT-->
					<div class="portlet light">
					<div class="portlet-body">
				<div class="invoice">
					<div class="row invoice-logo" >
								<div class="col-xs-4 invoice-logo-space">
									
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
									echo "Au Capital Social de : ".number_format($nav_societe->Capital, 2, ',', ' ');
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
								 <?php if (!empty($nav_societe->Nis)) {
									echo "<b>NIS N°: </b>". $nav_societe->Nis;
								} ?>
							</li>
							
							<li>
							<?php if (isset($nav_societe->id_societe)) {
									$compte = Compte::trouve_compte_par_defaut_and_id_societe($nav_societe->id_societe);
									if(isset($compte->id_banque)){
										$banques=Banque::trouve_par_id($compte->id_banque);												
												  
										echo "<b>Banque:</b> ". $banques->Designation;
										echo "<b> </b> ". $banques->Code;
										echo "<b> / N°:</b> ". $compte->num_compte;
									}
							} ?>
							
							</li>
							
							
						</ul>
					</div>
					<div class="col-xs-5 invoice-payment">
						<?php if (isset($Fact->id_facture)) {
							$client = Client::trouve_par_id($Fact->id_client);
						}  ?>
						<h3><strong>Client: </strong><?php if (isset($client->nom)) {
									echo $client->nom;
								} ?></h3>
						<ul class="list-unstyled" style="font-size: 11px;">
							<li>
								 <?php if (isset($client->Activite)) {
									echo $client->Activite;
								} ?>
							</li>
							<li>
								 <?php if (isset($client->Adresse)) {
									echo $client->Adresse;
								} ?>
								
								<?php if (isset($client->Ville)) {
									echo $client->Ville;
								} ?>
								<?php if (isset($client->Postal)) {
									echo $client->Postal;
								} ?> 
							</li>
							<li>
								 <?php if (isset($client->Rc)) {
									echo "<b>RC N°</b>: ". $client->Rc;
								} ?>
							</li>
							<li>
								 <?php if (isset($client->Mf)) {
									echo "<b>MF N°</b>: ". $client->Mf;
								} ?>
							</li>
							<li>
								 <?php if (isset($client->Ai)) {
									echo "<b>AI N°:</b> ". $client->Ai;
								} ?>
							</li>
							<li>
								 <?php if (!empty($client->Nis)) {
									echo "<b>NIS N°: </b>". $client->Nis;
								} ?>
							</li>
							<li>
								 <?php if (isset($client->Designation)) {
									echo "Banque N°: ". $client->Designation;
								} ?>
							</li>
							<li>
								 <?php if (isset($client->num_compte)) {
									echo "Compte N°: ". $client->num_compte;
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
								<th style="text-align:center;">
									Code
								</th>
								<th width="30%" >
									Désignation
								</th>
								<th style="text-align:center;">
									 Quantité 
								</th>
								<th style="text-align:right;">
									  Prix Unitaire 
								</th>
								<th style="text-align:center;">
									Remise
								</th>
								
								<th style="text-align:right;">
									 Montant H.T
								</th>
								<th style="text-align:right;">
									T.V.A  
								</th>
								
								
							</tr>
							</thead>
							<tbody>
								<?php 
								if (isset($Fact->id_facture)) {
								$list_vantes = Vente::trouve_vente_par_facture($Fact->id_facture);
								}
								  foreach($list_vantes as $list_vante){  ?>
							<tr class="item-row" style="font-size:11px;" >
								<td style="text-align:center;">
									<?php if (isset($list_vante->Code)) {
										echo $list_vante->Code;
									} ?>
								</td>
								<td>
									<?php if (isset($list_vante->Designation)) {
										echo $list_vante->Designation;
									} ?>
								</td>
								<td style="text-align:center;">
									<?php if (isset($list_vante->Quantite)) {
										echo $list_vante->Quantite;
									} ?>
								</td>
								<td style="text-align:right;">
									<?php if (isset($list_vante->Prix)) {
										echo number_format($list_vante->Prix , 2, ',', ' ');
									} ?>
								</td>
								<td style="text-align:center;">
										<?php if (isset($list_vante->Remise)) {
										echo number_format($list_vante->Remise , 2, ',', ' ');
									} ?>
									
								</td>
								<td style="text-align:right;">
									<?php if (isset($list_vante->Ht)) {
										echo number_format($list_vante->Ht , 2, ',', ' ');
									} ?>
								</td>
								<td style="text-align:right;">
									<?php if (isset($list_vante->Ttva)) {
										echo ($list_vante->Ttva *100).' %';
									} ?>
								</td>
								
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							</table>
							<table   class="table" style="margin: 0px 0px 0px 0px !important;"  >
								<tbody class="total">
								<tr>
									<td style="padding-top: 16px !important;" width="60%" colspan="6" <?php if ($Fact->Remise > 0) { echo 'rowspan="6"';  } else{ echo 'rowspan="5"';} ?> >
										<div class="mode-paiement">
											<br> 
										<table class="table table-bordered" style=" width: 95% !important;">
								<?php $table_Reglements = Reglement_client::trouve_Reglement_par_id_facture($Fact->id_facture,$nav_societe->id_societe); ?>
											<tr>
												<th width="15%"><strong> Règlement</strong></th>
												<th width="38%" >Référence</th>
												<th>Payé</th>
												<th>Timbre</th>
											</tr>
											<?php  foreach($table_Reglements as $table_Reglement){   ?>
											<tr style="font-size:11px;">
												<td>
												<?php if (isset($table_Reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?></td>
												<td>
													<?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_client= Solde_client::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_client->reference)) {
                                            echo fr_date2($Solde_client->date).' | '.$Solde_client->reference;
                                        } else{ echo '/';}
                                    } ?>
												</td>
												<td>
													<?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
												</td>
												<td>
													<?php if (isset($table_Reglement->timbre)) {
                                        echo number_format($table_Reglement->timbre,2,"."," ");
                                    } ?>
												</td>
											</tr>
										<?php } ?>
										</table>
									</div>
									<br>
										<strong>Arrêtée la présente facture à la somme de :</strong>
										<br><br> <?php echo chifre_en_lettre($Fact->somme_ttc); ?> 
										<div class="mode-paiement">
										<?php if (!empty($Fact->mode_paiment)) {  ?>
												<br> <strong> Mode de réglement : </strong>
												<?php echo $Fact->mode_paiment;
												 ?>
										<?php } ?>
										</div>
									</td>
									<td style="text-align : left !important;   font-size: 15px; ;"><strong> TOTAL H.T : </strong></td>
									<td style="text-align:right; font-size:14px;" ><?php  if(isset($Fact->somme_ht)){ echo str_replace(',', ' ', number_format($Fact->somme_ht+$Fact->Remise,2));} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
							    	
									<td  style="text-align : left !important;font-size: 15px;"><strong>  Remise : </strong></td>
									<td style="text-align:right; font-size:14px;"><?php  if(isset($Fact->Remise)){ echo str_replace(',', ' ', number_format($Fact->Remise,2)); } else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <?php if ($Fact->Remise > 0) { ?>
							     <tr>
							    	
									<td  style="text-align : left !important;font-size: 15px;"><strong>  TOTAL H.T <br>APRES REMISE : </strong></td>
									<td style="text-align:right; font-size:14px;"><?php  if(isset($Fact->somme_ht)){ echo str_replace(',', ' ', number_format($Fact->somme_ht,2)); } else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <?php } ?>
							    <tr>
							    	
									<td  style="text-align : left !important;font-size: 15px;"><strong>  T.V.A : </strong></td>
									<td style="text-align:right; font-size:14px;"><?php  if(isset($Fact->somme_tva)){ echo str_replace(',', ' ', number_format($Fact->somme_tva,2)); } else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
							    	
									<td  style="text-align : left !important;font-size: 15px;"><strong>  Timbre : </strong></td>
									<td style="text-align:right; font-size:14px;"><?php  if(isset($Fact->timbre)){ echo str_replace(',', ' ', number_format($Fact->timbre,2)); } else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
							    	
									<td style="text-align : left !important;   font-size: 15px; ;"><strong>TOTAL T.T.C : </strong></td>
									<td style="text-align:right; font-size:14px;"><?php  if(isset($Fact->somme_ttc)){echo str_replace(',', ' ', number_format($Fact->somme_ttc,2)) ;} else {echo "0.00";}  ?> DA</td>
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
						<?php if (!empty($list_vantes)) {?>
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

<script>

/////////////////////////// save Paiement Vente ////////////////////////////////

$(document).on('click','button#save_paiement', function() {
	var id = <?php if (isset($Fact->id_facture)) {echo $Fact->id_facture;} ?>;
$.ajax({
type: "POST",
url: "ajax/save_paiement.php",
data: $('#paiement_form').serialize(),
success: function(message){
$(".notification").html(message)
},
error: function(){
alert("Error");
}
});
 $('.facture-payee').html('<div class="  alert alert-success hidden-print"><p><strong>NOTE: Facture payée.</strong></p></div>');
 $('.invoice-block').html('<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();" ><i class="fa fa-print"></i> Imprimer</a><a class="btn btn-sm green hidden-print margin-bottom-5" disabled ><i class="fa fa-credit-card"></i> Enregistrer un paiement</a>');
 $('.mode-paiement').load('ajax/get_mode_paiement.php?id_fact='+id+'&action=vente',function(){});

}); 
</script>
<?php
require_once("footer/footer.php");
?>