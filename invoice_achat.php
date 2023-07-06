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
     $Fact = Facture_achat::trouve_par_id($id);
     $date = date_parse($Fact->date_fac);
   
 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
 	 $id = intval($_POST['id']);
     $Fact = Facture_achat::trouve_par_id($id);
     $date = date_parse($Fact->date_fac);
	 
 }

if (isset($_GET['action']) &&( $_GET['action'] =='update'  )) {

			echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.success(" Facture  N°'.sprintf("%04d", $Fact->N_facture).'/'.$date['year'].' Modifier avec succès","Très bien !");
        },300);
        });
			</script>';

}
if (isset($_GET['action']) &&( $_GET['action'] =='achat'  )) {

			echo ' <script type="text/javascript">
			$(document).ready(function(){
				 setTimeout(function() {
           toastr.success(" Facture achat N°'.sprintf("%04d", $Fact->N_facture).'/'.$date['year'].' Ajouter avec succès","Très bien !");
        },300);
        });
			</script>';

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
						<a href="#">Facture Achat</a>               
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

			<!-- BEGIN PAGE CONTENT-->
			<div class="notification"></div>
					<div class="portlet light">
					<div class="portlet-body">
				<div class="invoice">
					<div class="row invoice-logo" >
								<div class="col-xs-4 invoice-logo-space">
									
								</div>
								<div class="col-xs-8">
									<p>
										 Référence: <?php if (isset($Fact->Num_facture)) { echo $Fact->Num_facture; } ?>
										 <span class="muted">
										 FACTURE: <?php if (isset($Fact->N_facture)) { echo sprintf("%04d", $Fact->N_facture).'/'.$date['year'].'<br>'; } ?>
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
								 <?php if (isset($fournisseur->Activite)) {
									echo $fournisseur->Activite;
								} ?>
							</li>
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
								 <?php if (!empty($fournisseur->Nis)) {
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
								$list_achats = Achat::trouve_achat_par_facture($Fact->id_facture);
								}
								  foreach($list_achats as $list_achat){  ?>
							<tr class="item-row" style="font-size:11px;" >
								<td style="text-align:center;">
									<?php if (isset($list_achat->Code)) {
										echo $list_achat->Code;
									} ?>
								</td>
								<td>
									<?php if (isset($list_achat->Designation)) {
										echo $list_achat->Designation;
									} ?>
								</td>
								<td style="text-align:center;">
									<?php if (isset($list_achat->Quantite)) {
										echo $list_achat->Quantite;
									} ?>
								</td>
								<td style="text-align:right;">
									<?php if (isset($list_achat->Prix)) {
										echo number_format($list_achat->Prix , 2, ',', ' ') ;
									} ?>
								</td>
								<td>
									<?php if (isset($list_achat->Remise)) {
										echo number_format($list_achat->Remise , 2, ',', ' ');
									} ?>
									
								</td>
								<td style="text-align:right;">
									<?php if (isset($list_achat->Ht)) {
										echo number_format($list_achat->Ht , 2, ',', ' ') ;
									} ?>
								</td>
								<td style="text-align:right;">
									<?php if (isset($list_achat->Ttva)) {
										echo ($list_achat->Ttva *100).' %';
									} ?>
								</td>
								
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							</table>
							<table  class="table" style="margin: 0px 0px 0px 0px !important;"  >
								<tbody class="total">
								<tr>
									<td style="padding-top: 16px !important;" width="60%" colspan="6" rowspan="5">
										<div class="mode-paiement">
											<br> 
										<table class="table table-bordered" style=" width: 95% !important;">
								<?php $table_Reglements = Reglement_fournisseur::trouve_Reglement_par_id_facture($Fact->id_facture,$nav_societe->id_societe,1); ?>
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
                                       
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
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
									</td>
									<td style="text-align : center !important;   font-size: 15px; ;"><strong> TOTAL H.T : </strong></td>
									<td style="text-align:right; font-size:14px;" ><?php  if(isset($Fact->somme_ht)){ echo str_replace(',', ' ', number_format($Fact->somme_ht,2));} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
							    	
									<td  style="text-align : center !important;font-size: 15px;"><strong>  T.V.A : </strong></td>
									<td style="text-align:right; font-size:14px;"><?php  if(isset($Fact->somme_tva)){ echo str_replace(',', ' ', number_format($Fact->somme_tva,2)); } else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
							    	
									<td  style="text-align : center !important;font-size: 15px;"><strong>  Timbre : </strong></td>
									<td style="text-align:right; font-size:14px;"><?php  if(isset($Fact->timbre)){ echo str_replace(',', ' ', number_format($Fact->timbre,2)); } else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
							    	
									<td  style="text-align : center !important;font-size: 15px;"><strong>  Remise : </strong></td>
									<td style="text-align:right; font-size:14px;"><?php  if(isset($Fact->Remise)){ echo str_replace(',', ' ', number_format($Fact->Remise,2)); } else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
							    	
									<td style="text-align : center !important;   font-size: 15px; ;"><strong>TOTAL T.T.C : </strong></td>
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
						<?php if (!empty($list_achats)) {?>
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