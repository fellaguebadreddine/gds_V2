<!-- modal SCAN FACTURE DEPENSE -->
		<div id="form_modal12" class="modal container fade" tabindex="-1">
				
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Sélectionner une image</h4>
										</div>
										<div class="modal-body">
								
							<div class="row">
			<?php
				if (isset($nav_societe->id_societe)){	$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); }
					$cpt = 0;
					$file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
				?>
			<div class="col-md-4 ">
				<!-- BEGIN WIDGET THUMB -->
				
				<div class="widget-thumb widget-bg-color-white text-uppercase rounded-3 margin-bottom-30 portlet light bordered ">
				<a  href="operation.php?action=add_fact_depense&id_img=<?php echo $ScanImage->id;  ?>" class="fancybox-button" data-rel="fancybox-button"   >
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
	<!-- END FATUREE DEPENSE -->
	
	<!-- END modal SCAN IMMOBILISATION -->
		<div id="form_modal14" class="modal container fade" tabindex="-1">
				
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Sélectionner une image</h4>
										</div>
										<div class="modal-body">
								
							<div class="row">
			<?php
				if (isset($nav_societe->id_societe)){	$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); }
					$cpt = 0;
					$file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
				?>
			<div class="col-md-4 ">
				<!-- BEGIN WIDGET THUMB -->
				
				<div class="widget-thumb widget-bg-color-white text-uppercase rounded-3 margin-bottom-30 portlet light bordered ">
				<a  href="immobilisation.php?action=add_immobilisations&id_img=<?php echo $ScanImage->id;  ?>" class="fancybox-button" data-rel="fancybox-button"   >
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
	<!-- END FATUREE IMMOBILISATION -->
	
	<!-- FATUREE VENTE -->
		<div id="form_modal10" class="modal container fade" tabindex="-1">
				
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Sélectionner une image</h4>
										</div>
										<div class="modal-body">
								
							<div class="row">
			<?php
					if (isset($nav_societe->id_societe)){$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); }
					$cpt = 0;
					$file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
				?>
			<div class="col-md-4 ">
				<!-- BEGIN WIDGET THUMB -->
				
				<div class="widget-thumb widget-bg-color-white text-uppercase rounded-3 margin-bottom-30 portlet light bordered ">
				<a  href="operation.php?action=vente&id_img=<?php echo $ScanImage->id;  ?>" class="fancybox-button" data-rel="fancybox-button"   >
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
<div id="Detail_Prod" class="modal container fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title prod-modaltitle"><i class="fa fa-cube font-yellow"> </i> </h4>
                                </div>

                                <div class="modalbody-prod">
            
                                </div>
</div>
<div id="Detail_Formule" class="modal container fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title Formule-modaltitle"><i class="fa fa-cube font-yellow"> </i> </h4>
                                </div>

                                <div class="modalbody-Formule">
            
                                </div>
</div>
<div id="delete_annex5" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment supprumer !
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  id="supp_annex5"  data-dismiss="modal"  class="btn red">Supprimer </a>
                  </div>
</div>
<div id="close_societe" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment fermer la société <?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  href="close_file.php?action=close_societe"   class="btn red">Déconnexion </a>
                  </div>
</div>
<div id="delete_fact" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment supprumer cette facture
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  id="supp_fact"  data-dismiss="modal"  class="btn red">Supprimer </a>
                  </div>
</div>
<div id="delete_production" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment supprumer cette production
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  id="supp_production"  data-dismiss="modal"  class="btn red">Supprimer </a>
                  </div>
</div>
<div id="delete_prod" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment supprimer ce produit ?
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  id="supp_prod"  data-dismiss="modal"  class="btn red">Supprimer </a>
                  </div>
</div>
<div id="delete_fact_achat" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment supprumer cette facture
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  id="supp_fact_achat"  data-dismiss="modal"  class="btn red">Supprimer </a>
                  </div>
</div>
<div id="delete_depense" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment supprumer cette Depense
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  id="supp_depense"  data-dismiss="modal"  class="btn red">Supprimer </a>
                  </div>
</div>
<div id="delete_fact_depense" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment supprumer cette facture
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  id="supp_fact_depense"  data-dismiss="modal"  class="btn red">Supprimer </a>
                  </div>
</div>
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="container-fluid">
		 2021 &copy; Mohammed FETTAH. <a href="#" title="Mohammed FETTAH" target="_blank">Mohammed FETTAH</a>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

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
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<?php if (in_array('inputmask',$header)){?> 
<script type="text/javascript" src="assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<?php } ?>
<script src="assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/admin/pages/scripts/editable-invoice.js"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
 <script type="text/javascript" src="assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/table-advanced.js"></script>
<script src="assets/global/scripts/toastr.js" type="text/javascript"></script>

<script src="assets/admin/pages/scripts/ui-extended-modals.js"></script>



<?php if (  $action=='production' || $action=='edit_production' )  { ?>
  <script>
////////////////////////////////// onchange Formule ///////////////////////////

	$(document).on('change','#produitId', function() {
		var id = this.value;
	  
		 $('.produitId').load('ajax/get_formule.php?id='+id,function(){       
		});
		$('.info-formule').load('ajax/get_info-prod.php',function(){       
			});
		
	});

	$(document).on('change','#id_formule', function() {
			var id = this.value;
			var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;

			$('.info-formule').load('ajax/get_info-prod.php?id='+id+'&action=production&id_societe='+id_societe,function(){       
			});
		$('#qty').focus();
		});

</script>
<?php } ?>
<?php if (  $action=='affiche_reglemnt_client' ) { ?>
<!-- modal versement -->
    
                    <div id="Rclient" class="modal container fade" tabindex="-1">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <form   id="versement_form"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-5">
                                                                                                                                        
                                              <?php

                                                            if (isset($_GET['id'])) {
                                                             $id =  htmlspecialchars(intval($_GET['id'])) ;
                                                             $client = Client::trouve_par_id($id);
                                                            }else{
                                                                    echo 'Content not found....';
                                                            }
                                                        $cpt = 0; ?>
                                                
                                                <input type="hidden" name="id_client" value="<?php if(isset($client->id_client)){echo $client->id_client; } ?>">       
                                                <input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">       
                                                        
                                               
                                               <div class="form-group form-md-line-input">
                                                 <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe); ?>    
                                                    <label class="col-md-3 control-label">Mode paiment</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control  "   id="mode_paiment"  name="mode_paiment">
                                                         <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)){ echo $Mode_paiement_societe->id;}  ?>"><?php if(isset($Mode_paiement_societe->type)){ echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>  
                                                                 
                                                    </select> 
                                                    </div>
                                                </div>
                                           <?php if (isset($nav_societe->id_societe)) {
                                                                $Comptes = Compte::trouve_par_societe($nav_societe->id_societe);
                                                                
                                                                
                                                                ?>
                                                    <div class="form-group form-md-line-input mode_paiment ">
                                                    <label class="col-md-3 control-label">Banque</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="banque" id="banque"  placeholder="Choisir" >
                                                    
                                                            <?php  foreach ($Comptes as $Compte){
                                                            $banque = Banque::trouve_par_id($Compte->id_banque) ?>
                                                                <option  value="<?php if (isset($Compte->id)) {
                                                                    echo $Compte->id;}?>"><?php if (isset($banque->Designation)) {
                                                                    echo $banque->Designation;} ?> </option>
                                                <?php } ?>  
                                                                       
                                                        </select> 
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            </div>
                                            <div class="col-md-7 ">
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="credit" class="form-control " name="credit"  placeholder="00.00" required   />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">référence <span class="required" aria-required="true"> * </span></label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="reference" class="form-control " name="reference" placeholder="RG0001" required   />
                                                        
                                                    </div>                                            
                                                  
                                                   <input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;} ?>">
                                                </div>
                                            </div>
                                              
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de versement</label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>" required>
                                                    </div>                                            
                                                  
                                                </div>

                                            </div> 
                                                   
                                            </div>
                                              
                                     </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button  id="save_versment" data-dismiss="modal" class="btn green" > Valider</button>
                                    </div>
                                </div>
                                <!-- END modal versement -->

    <script>

    ////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#mode_paiment', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.mode_paiment').load('ajax/get_mode_paiement.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
/////////////////////////// save versment  ////////////////////////////////

$(document).on('click','button#save_versment', function() {
    var id = <?php if (isset($client->id_client)) {echo $client->id_client;} else {echo '0';} ?>;
$.ajax({
type: "POST",
url: "ajax/save_versment.php",
data: $('#versement_form').serialize(),
success: function(message){
$(".notification").html(message)
},
error: function(){
alert("Error");
}
});
 $('.Versement_client').load('ajax/Versement_client.php?id='+id,function(){       
    });
 
}); 
</script>
     <script>
  $(document).on('click','#delete_reglemnt_client', function() {

		var id = this.value;
        var id_client = <?php if (isset($id)) { echo $id ;} ?>;
              $.ajax({
            type:'POST',
            url:'ajax/delete_reglemnt_client.php',
            dataType: "json",
            data:'id='+id+'&id_client='+id_client,
            success:function(response){
              if(response.status == 'ok'){
                $(".reglement_" + id).parents('.item-row').fadeOut();
                    $('#reglement-somme').text(parseFloat(response.data.somme).toFixed(2));   
                    $('#reglement-solde').text(parseFloat(response.data.solde).toFixed(2));   
                    $('#reglement-credit').text(parseFloat(response.data.credit).toFixed(2));
                     toastr.success(response.msg,"Très bien !");    
              }else{
                toastr.error(response.msg,"Attention !");
              }
 
            },
        error: function(){
    alert("Error");
    }
        });
  });
  </script>
<script>
    var el = document.getElementById("credit");
    el.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
       
        event.preventDefault();
      }
    });

  </script>
<?php }  if (  $action=='affiche_reglemnt_fournisseur' ) { ?> 

<!-- modal versement -->
    
                    <div id="Rfournisseur" class="modal container fade" tabindex="-1">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiment</h4>
                                    </div>
                                    <div class="modal-body">
                                    <form   id="versement_form_f"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-5">
                                                                                                                                        
                                              <?php

                                                            if (isset($_GET['id'])) {
                                                             $id =  htmlspecialchars(intval($_GET['id'])) ;
                                                             $fournisseur = Fournisseur::trouve_par_id($id);
                                                            }else{
                                                                    echo 'Content not found....';
                                                            }
                                                        $cpt = 0; ?>
                                                
                                                <input type="hidden" name="id_fournisseur" value="<?php if(isset($fournisseur->id_fournisseur)){echo $fournisseur->id_fournisseur; } ?>">
                                                <input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">       
                                                        
                                               
                                                <div class="form-group form-md-line-input">
                                                 <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe); ?>    
                                                    <label class="col-md-3 control-label">Mode paiment</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control  "   id="mode_paiment"  name="mode_paiment">
                                                         <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)){ echo $Mode_paiement_societe->id;}  ?>"><?php if(isset($Mode_paiement_societe->type)){ echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>  
                                                                 
                                                    </select> 
                                                    </div>
                                                </div>
                                          <?php if (isset($nav_societe->id_societe)) {
                                                               
                                                                 $Comptes = Compte::trouve_par_societe($nav_societe->id_societe);
                                                                
                                                                
                                                                ?>
                                                    <div class="form-group form-md-line-input mode_paiment ">
                                                    <label class="col-md-3 control-label">Banque</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="banque" id="banque"  placeholder="Choisir" >
                                                    
												                              <?php  foreach ($Comptes as $Compte){
																											$banque = Banque::trouve_par_id($Compte->id_banque);
																											 ?>
																												<option value="<?php if (isset($Compte->id)) {
																													echo $Compte->id;}?>"><?php if (isset($banque->Designation)) {
																													echo $banque->Designation;} ?> </option>
                                                <?php } ?>  
                                                                       
                                                        </select> 
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            
                                            </div>
                                            <div class="col-md-7 ">
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant <span class="required" aria-required="true"> * </span></label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="debit" class="form-control " name="debit"  required placeholder="00.00" />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">référence  <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="reference" class="form-control " name="reference" required placeholder="RG001"  />
                                                        
                                                    </div>                                            
                                                  
                                                   <input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;} ?>">
                                                </div>
                                            </div>
                                              
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de versement</label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>" required>
                                                    </div>                                            
                                                  
                                                </div>

                                            </div> 
                                                   
                                            </div>
                                              
                                     </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button  id="save_versment_f" data-dismiss="modal" class="btn green" > Valider</button>
                                    </div>
                                </div>
     <!-- END modal versement -->



    <script>
    ////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#mode_paiment', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.mode_paiment').load('ajax/get_mode_paiement.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
/////////////////////////// save versment  ////////////////////////////////

$(document).on('click','button#save_versment_f', function() {
    var id = <?php if (isset($fournisseur->id_fournisseur)) {echo $fournisseur->id_fournisseur;} ?>;
$.ajax({
type: "POST",
url: "ajax/save_versment_f.php",
data: $('#versement_form_f').serialize(),
success: function(message){
$(".notification").html(message)
},
error: function(){
alert("Error");
}
});
 $('.Versement_fournisseur').load('ajax/Versement_fournisseur.php?id='+id,function(){       
    });
 
}); 
</script>
<script>
    var el = document.getElementById("credit");
    el.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
       
        event.preventDefault();
      }
    });

  </script>
     <script>
  $(document).on('click','#delete_reglemnt_fournisseur', function() {

		var id = this.value;
        var id_fournisseur = <?php if (isset($id)) { echo $id ;} ?>;
              $.ajax({
            type:'POST',
            url:'ajax/delete_reglemnt_fournisseur.php',
            dataType: "json",
            data:'id='+id+'&id_fournisseur='+id_fournisseur,
            success:function(response){
              if(response.status == 'ok'){
                $(".reglement_" + id).parents('.item-row').fadeOut();
                    $('#reglement-somme').text(parseFloat(response.data.somme).toFixed(2));   
                    $('#reglement-solde').text(parseFloat(response.data.solde).toFixed(2));   
                    $('#reglement-debit').text(parseFloat(response.data.debit).toFixed(2));
                     toastr.success(response.msg,"Très bien !");    
              }else{
                toastr.error(response.msg,"Attention !");
              }
 
            },
        error: function(){
    alert("Error");
    }
        });
  });
  </script>
<?php } ?>
<script>
//////////////// get TVA Produit par famille ////////////////////
		$(document).on('change','#id_famille', function() {
var id = this.value;
     $('.get_tva').load('ajax/get_tva_famille.php?id='+id,function(){       
    });
});

 //////////// delete annexe //////////////////////////////
$(document).on('click','#del_annex5', function() {
    var id = $(this).attr('value'); 
      $("#supp_annex5").attr("value", id);

});
$(document).on('click','#supp_annex5', function() {
    var id = $(this).attr('value'); 
      $(".notification").load('ajax/deleteannexe.php?id='+id+'&action=annex5',function(){       
    });

});

///////////// show product detail////////////////:
    $(document).on('click','#MyProd', function() {
   var title = $(this).attr('name'); 
    $('.prod-modaltitle').html('Produit : '+title);
   var id = $(this).attr('value');
   
 $('.modalbody-prod').load('ajax/GetProdContent.php?id='+id,function(){       
   }); 
});
///////////// show formule detail////////////////:
    $(document).on('click','#MyFormule', function() {
   var title = $(this).attr('name'); 
    $('.Formule-modaltitle').html('Formule : '+title);
   var id = $(this).attr('value');
   
 $('.modalbody-Formule').load('ajax/GetFormuleContent.php?id='+id,function(){       
   }); 
});
///////////// SHOW IMMOBILISATION DETAIL ////////////////:
$(document).on('click','#edit_immobi', function() {
    var id = $(this).attr('value');   
    var title = $(this).attr('name');
	var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
  $('.modaltitle').html(title);
  $('.modalfooter').html('<button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>');
 $('.modalbody-immobil').load('ajax/edit_immo.php?id='+id+'&id_societe='+id_societe,function(){       
    });

});
 //////////// delete facture vente //////////////////////////////
$(document).on('click','#del_fact', function() {
    var id = $(this).attr('value'); 
      $("#supp_fact").attr("value", id);

});
$(document).on('click','#supp_fact', function() {
    var id = $(this).attr('value'); 
      $(".notification").load('ajax/deletefact.php?id='+id+'&action=vente',function(){       
    });

});
 //////////// delete facture production //////////////////////////////
$(document).on('click','#del_production', function() {
    var id = $(this).attr('value'); 
      $("#supp_production").attr("value", id);

});
$(document).on('click','#supp_production', function() {
    var id = $(this).attr('value'); 
      $(".notification").load('ajax/deleteproduction.php?id='+id,function(){       
    });

});
 //////////// delete produit//////////////////////////////
$(document).on('click','#del_prod', function() {
    var id = $(this).attr('value'); 
      $("#supp_prod").attr("value", id);

});
$(document).on('click','#supp_prod', function() {
    var id = $(this).attr('value'); 
      $(".notification").load('ajax/deleteprod.php?id='+id,function(){       
    });

});
 //////////// delete DEPENSE //////////////////////////////
 $(document).on('click','#del_depense', function() {
    var id = $(this).attr('value'); 
      $("#supp_depense").attr("value", id);

});
$(document).on('click','#supp_depense', function() {
    var id = $(this).attr('value'); 
      $(".notification").load('ajax/deleteDepense.php?id='+id,function(){       
    });

});
 //////////// delete facture achat //////////////////////////////
$(document).on('click','#del_fact_achat', function() {
    var id = $(this).attr('value'); 
      $("#supp_fact_achat").attr("value", id);

});

$(document).on('click','#supp_fact_achat', function() {
    var id = $(this).attr('value'); 
      $(".notification").load('ajax/deletefact.php?id='+id+'&action=achat',function(){       
    });

});
 //////////// delete facture depense //////////////////////////////
$(document).on('click','#del_fact_depense', function() {
    var id = $(this).attr('value'); 
      $("#supp_fact_depense").attr("value", id);

});

$(document).on('click','#supp_fact_depense', function() {
    var id = $(this).attr('value'); 
      $(".notification").load('ajax/delete_fact_depense.php?id='+id,function(){       
    });

});

</script>

<style>


#pageFooter:after {
    counter-increment: page;
    content: counter(page);
}
#pageFooter:after {
    counter-increment: page;
    content:"Page " counter(page);
    left: 0; 
    top: 100%;
    white-space: nowrap; 
    z-index: 20;
    -moz-border-radius: 5px; 
    -moz-box-shadow: 0px 0px 4px #222;  
    background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);  
  }

page[size="A4"] {
  width: 205mm;  
  position: relative;
  display: block;
  color: #000000;
  background: #FFFFFf; 
  font-family: Calibri;
  font-size: 14px;
  page-break-after: always;

}
page[size="A4-2"] {
  padding-top: 30px;
  width: 205mm;  
  position: relative;
  display: block;
  color: #FF0000;
  background: #FFFFFf; 
  font-family: Calibri;
  font-size: 14px;
}
.bilan-td-title{
  padding-left: 5px;
  font-weight: 700;
}
.bilan-td{
  padding-left: 15px;
}
.badr{
    background: #ddd !important;

}
.miloud{
    background: #fbd4b4 !important;

}
@media print{
    @page {
        margin-top: 0cm;
        margin-bottom: 0cm;
        margin-left: 0mm;
        margin-right: 5mm;

    }
  body {
                -webkit-print-color-adjust: exact !important;
                -moz-print-color-adjust: exact !important;
                -ms-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
.badr{
    background: #ddd !important;

}.miloud{
    background: #fbd4b4 !important;

}
}

</style>

<?php if (  $action=='add_annexe_5' ||  $action=='edit_annexe_5'  ) { ?>
<script>


$(document).ready(function() {
    $(document).on('click','#add_pertes_valeurs', function() {
      
    $(".item-row:last").after('<tr class="item-row"><td><input required type="text" name="Designation[]" id="Designation" min="0" class="form-control" ></td><td><input required type="number" name="Valeur[]" id="Valeur" min="0" class="form-control" ></td> <td><input required type="number" name="Perte_1[]" id="Perte_1" min="0" class="form-control" ></td><td><a class="btn btn-danger " id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash" ></i></a></td></tr>');

  });
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    $(this).parents('.item-row').remove();
  });
});
$(document).ready(function() {
    $(document).on('click','#add_valeurs_actions', function() {
      
    $(".item-row2:last").after('<tr class="item-row2"><td><input required type="text" name="Filiales[]" id="Filiales" min="0" class="form-control" >    </td><td><input required type="number" name="Valeur_nominale[]" id="Valeur_nominale" min="0" class="form-control" ></td><td><input required type="number" name="Perte_2[]" id="Perte_2" min="0" class="form-control" ></td><td><input  type="number" name="Valeur_nette[]" readonly id="Valeur_nette" min="0" class="form-control" ></td><td><a class="btn btn-danger " id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash" ></i></a></td></tr>');
    
  });
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row2').fadeOut();
    $(this).parents('.item-row2').remove();
  });
});
$(document).ready(function(){
    var i=1;


    $(document).on('keyup change','#tab_actions tbody', function() {
        calc();
    });

});

function calc(){
    $('#tab_actions tbody tr').each(function(i, element) {
        var html = $(this).html();
        if(html!='')
        {
            var Valeur_nominale = $(this).find('#Valeur_nominale').val();
            var Perte_2 = $(this).find('#Perte_2').val();
            var Valeur_nette = (Valeur_nominale - Perte_2);
            if(isNaN(Valeur_nette)) { Valeur_nette = 0;}
            $(this).find('#Valeur_nette').val(Valeur_nette);

        }
    });
}
</script>

<?php } ?>
<script>
$(document).on('click','#societe_link', function() {
    var id = $(this).attr('value');   
    var title = $(this).attr('name');
  //this is just getting the value that is selected
  $('.modaltitle').html(title);
  $('.modalfooter').html('<button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button><a  class="btn blue" href="societe.php?id='+id+'&action=edit" >Modifier</a>');
 $('.modalbody').load('ajax/GetsocieteContent.php?id='+id,function(){       
    });

});
$(document).on('click','#Reglementclient', function() {
    var id = $(this).attr('value');   
    var title = $(this).attr('name');
  //this is just getting the value that is selected
  $('.modaltitle').html(title);
  $('.modalfooter').html('<button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>');
 $('.modalbody').load('ajax/ff.php?id='+id,function(){       
    });

});
$(document).on('click','#ReglementFournisseur', function() {
    var id = $(this).attr('value');   
    var title = $(this).attr('name');
  //this is just getting the value that is selected
  $('.modaltitle').html(title);
  $('.modalfooter').html('<button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>');
 $('.modalbody').load('ajax/ff.php?id='+id,function(){       
    });

});
$(document).on('click','#client_link', function() {
    var id = $(this).attr('value');   
    var title = $(this).attr('name');
  //this is just getting the value that is selected
  $('.modaltitle').html(title);
  $('.modalfooter').html('<button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>');
 $('.modalbody').load('ajax/selectClient.php?id='+id,function(){       
    });

});
$(document).on('click','#fournisseur_link', function() {
    var id = $(this).attr('value');   
    var title = $(this).attr('name');
  //this is just getting the value that is selected
  $('.modaltitle').html(title);
  $('.modalfooter').html('<button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>');
 $('.modalbody').load('ajax/selectFournisseur.php?id='+id,function(){       
    });

});


//////////////////////////////////////////////
      jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
   TableAdvanced.init();
      });

////////////////// onclick index button's //////////////////////
     $(document).on('click','#vente', function() {
window.location = 'operation.php?action=vente';
  });   
////////////////// onclick index button's //////////////////////
     $(document).on('click','#achat', function() {
window.location = 'operation.php?action=achat';
  }); 

function Showinput_Prix_fixe()
{

if (document.getElementById("Prix_fixe").checked == true)
{
document.getElementById("input_Prix_fixe").style.display = "initial";
document.getElementById("input_Prix_fixe").focus();
}
else
{
document.getElementById("input_Prix_fixe").style.display = "none";
}
}

function ShowinputPrix_par_pourcentage()
{

if (document.getElementById("Prix_par_pourcentage").checked == true)
{
document.getElementById("inputPrix_par_pourcentage").style.display = "initial";
document.getElementById("inputPrix_par_pourcentage").focus();
document.getElementById("inputgroupaddon").style.display = "table-cell";
}
else
{
document.getElementById("inputPrix_par_pourcentage").style.display = "none";
document.getElementById("inputgroupaddon").style.display = "none";
}
}

function ShowinputPrix_par_pourcentage_2()
{

if (document.getElementById("Prix_par_pourcentage").checked == true)
{
document.getElementById("inputPrix_par_pourcentage").style.display = "initial";
document.getElementById("inputPrix_par_pourcentage").focus();
document.getElementById("Prix_vente").style.display = "initial";
document.getElementById("inputgroupaddon").style.display = "table-cell";
}
else
{
document.getElementById("inputPrix_par_pourcentage").style.display = "none";
document.getElementById("Prix_vente").style.display = "none";
document.getElementById("inputgroupaddon").style.display = "none";
}
}
     $(document).on('keyup change','#inputPrix_par_pourcentage', function() {
    var prix_achat = parseFloat($('#prix_achat').val());
    var pourcentage =($('#inputPrix_par_pourcentage').val())/100;
    var prix_vente = (prix_achat +(prix_achat*pourcentage));
    $('#Prix_vente').val(prix_vente);

  }); 

   </script>
   <?php if  ($action=='avoir_vente')  { ?>
<div class="notification-paiement"></div>
                      <div id="add-paiment"  data-backdrop="static" data-keyboard="false" aria-hidden="false" class="modal container fade" tabindex="-1" style=" margin-top: -122.5px;">
                                    <div class="modal-header">
                                        
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe);
                                    $somme_Reglement = Reglement_client::trouve_somme_Reglement_vide_par_admin_avoir($user->id,$nav_societe->id_societe); 
                                    
                                    $Reste_fact =$Somme_ttc->somme_ttc - $somme_Reglement->somme ;
                                     ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>?action=fact_vente" method="POST"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row info-TTC" >
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="Remise" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                        
                                                        <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  number_format($Reste_fact,2,"."," "); ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                           
                                            <div class="col-md-12 notification-mode-paiement table-responsive">
                                                <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                             <?php  $table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin_avoir($user->id,$nav_societe->id_societe);     $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                            <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_client= Solde_client::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_client->reference)) {
                                            echo fr_date2($Solde_client->date).' | '.$Solde_client->reference;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_client->solde)) {
                                            echo number_format($Solde_client->solde,2,"."," ");
                                        } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde_client->solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                                    <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture[]" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>
                                                                </select>   
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                     
                                </td>
                                <td>
                                    
                                </td>    
                                <td>
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
                                    
                                            </div>

                                            </div>
                                              
                                     
                                    </div>
                                    <div class="modal-footer">
                                    	<button style="float: left;"  class="btn blue" data-toggle="modal" href="#Rclient"> Nouveau Reglement</button>
                                        <button type="button" id="cancel_paiement" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button type="submit" <?php if (empty($table_Reglements)) {echo 'disabled'; } ?>  id="save_paiement"  class="btn green"> CRÉER UN PAIEMENT</button>
                                    </div>
                                    <input type="hidden" id="facture_scan"  name="facture_scan" value="<?php if (isset($img_select->id)){  echo $img_select->id;} ?>"    />
                                     				
                                            <input type="hidden" id="date_facture"  name="date_fact" value=""    />
                                            <input type="hidden" class="client"  id="client" name="client"  value="" />
                                            <input type="hidden" id="tva_fact" name="tva_fact"  value="" />
                                            <input type="hidden" id="ttc_fact" name="ttc_fact"  value="" />
                                    </form>
                                </div>


<div class="notification-reglement"></div>
<div id="Rclient" class="modal container fade" tabindex="-1">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <form   id="versement_form"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-5">
                                        	 <input type="hidden" class="client" id="id_client" name="id_client"  value="" />
                                                      
                                                <input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">       
                                                        
                                               
                                               <div class="form-group form-md-line-input">
                                                 <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe); ?>    
                                                    <label class="col-md-3 control-label">Mode paiment</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control  "   id="mode_paiment"  name="mode_paiment">
                                                         <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)){ echo $Mode_paiement_societe->id;}  ?>"><?php if(isset($Mode_paiement_societe->type)){ echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>  
                                                                 
                                                    </select> 
                                                    </div>
                                                </div>
                                           <?php if (isset($nav_societe->id_societe)) {
                                                                $Comptes = Compte::trouve_par_societe($nav_societe->id_societe);
                                                                
                                                                
                                                                ?>
                                                    <div class="form-group form-md-line-input mode_paiment ">
                                                    <label class="col-md-3 control-label">Banque</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="banque" id="banque"  placeholder="Choisir" >
                                                    
                                                            <?php  foreach ($Comptes as $Compte){
                                                            $banque = Banque::trouve_par_id($Compte->id_banque) ?>
                                                                <option  value="<?php if (isset($Compte->id)) {
                                                                    echo $Compte->id;}?>"><?php if (isset($banque->Designation)) {
                                                                    echo $banque->Designation;} ?> </option>
                                                <?php } ?>  
                                                                       
                                                        </select> 
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            </div>
                                            <div class="col-md-7 ">
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="credit" class="form-control " name="credit"  placeholder="00.00" required   />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">référence <span class="required" aria-required="true"> * </span></label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="reference" class="form-control " name="reference" placeholder="RG0001" required   />
                                                        
                                                    </div>                                            
                                                  
                                                   <input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;} ?>">
                                                </div>
                                            </div>
                                              
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de versement</label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>" required>
                                                    </div>                                            
                                                  
                                                </div>

                                            </div> 
                                                   
                                            </div>
                                              
                                     </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button  id="save_versment" data-dismiss="modal" class="btn green" > Valider</button>
                                    </div>
                                </div>       
<script>
    ////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#mode_paiment', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.mode_paiment').load('ajax/get_mode_paiement.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
///////////////////////// save_versment ////////////////////
$(document).on('click','button#save_versment', function() {
    var id = $('#id_client').val();
$.ajax({
type: "POST",
url: "ajax/save_versment.php",
data: $('#versement_form').serialize(),
success: function(message){
$(".notification-reglement").html(message)
},
error: function(){
alert("Error");
}
});

 
}); 


    ////////////// get facture info when onclick Enregistrer_paiement //////////////////
$(document).on('click','#Enregistrer_paiement', function() {
    var Remise_fact =$('#REMISE_ht').text();
    var date_facture = $('#date_fact').val();
    var TOTALTVA = parseFloat($('#TOTALTVA').text());
    var TOTALTTC = parseFloat($('#TOTALTTC').text());
    var date_facture = $('#date_fact').val();
    var client =$('#id_client').val();
    var TOTALHT_R = parseFloat($('#TOTALHT_R').text());

    $('#Remise_fact').val(Remise_fact);
    $('#date_facture').val(date_facture);
    $('.client').val(client);
    $('#ht_fact').val(TOTALHT_R);
    $('#tva_fact').val(TOTALTVA);
    $('#ttc_fact').val(TOTALTTC);
    $('#TTC').val((TOTALTTC).toFixed(2));
    $('#Reste_fact').val((TOTALTTC).toFixed(2));
});
////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_client =$('#id_client').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var TOTALTTC =$('#TTC').val();
    $(".info-TTC").load('ajax/calcule_timbre.php?avoir_vente&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC,function(){});
     $(this).parents('.info-mode_paiment').load('ajax/get_mode_paiement_fact.php?avoir_vente&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC,function(){});

});

///////////////////// onchqnge list Paiement fact ///////////////////
$(document).on('change','#list_paiment_facture', function() {
    var id = this.value;
    var TOTALTTC =$('#TTC').val();
    var Reste_fact = parseFloat($('#Reste_fact').val()) || 0;
      $.ajax({
            type:'POST',
            url:'ajax/get_solde_mode_paiement.php',
            dataType: "json",
            data:'action=avoir_vente&id='+id+'&TOTALTTC='+TOTALTTC+'&Reste_fact='+Reste_fact,
            success:function(response){
                    $('#solde').val(parseFloat(response.data.Solde_client).toFixed(2));   
                    $('#Montant').val(parseFloat(response.data.TOTAL).toFixed(2));   
                    $('#reste').val(parseFloat(response.data.rest).toFixed(2));   
            },
        error: function(){
    alert("Error");
    }
        });
    
});

   ////////////// calcul reste mode paiement //////////////////
$(document).on('keyup change','#Montant', function() {
    var solde =parseFloat($('#solde').val());
    var Montant = parseFloat($('#Montant').val());
    var reste = solde - Montant ;

    $('#reste').val((reste).toFixed(2));
});

 //////////////// add_paiement ////////////////////////////
 
$(document).on('click','#add_paiement', function() {
    
    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_solde =$('#list_paiment_facture').val()||0;
    var reste = parseFloat($('#Reste_fact').val()) || 0;
    var Montant =$('#Montant').val();
    var TOTALTTC =$('#TTC').val();
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification-mode-paiement").load('ajax/addmodepaiement.php?avoir_vente&date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_solde='+id_solde+'&reste='+reste+'&Montant='+Montant+'&mode_paiment='+mode_paiment,function(){       
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?avoir_vente&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC,function(){});

});
///////////////////  delete mode paiement //////////////////////////////////////

  $(document).on('click','#delete_row,#cancel_paiement', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).attr('name')|| 0;
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_client =$('#id_client').val();
    var TOTALTTC =$('#TTC').val();
    $.ajax({
    type: "GET",
    url: "ajax/deletepaiement.php?avoir_vente&delete&id="+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client,
    success: function(message){
    $(".notification-mode-paiement").html(message)},
    error: function(){
    alert("Error");
    }
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?avoir_vente&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC,function(){});
  }); 
    ////////////// get facture info when onclick Enregistrer_paiement //////////////////
$(document).on('click','#Enregistrer_paiement', function() {
    var Remise_fact =$('#REMISE_ht').text();
    var date_facture = $('#date_fact').val();
    var TOTALTVA = parseFloat($('#TOTALTVA').text());
    var TOTALTTC = parseFloat($('#TOTALTTC').text());
    var date_facture = $('#date_fact').val();
    var client =$('#id_client').val();
    var TOTALHT_R = parseFloat($('#TOTALHT_R').text());

    $('#Remise_fact').val(Remise_fact);
    $('#date_facture').val(date_facture);
    $('.client').val(client);
    $('#ht_fact').val(TOTALHT_R);
    $('#tva_fact').val(TOTALTVA);
    $('#ttc_fact').val(TOTALTTC);
    $('#TTC').val((TOTALTTC).toFixed(2));
    $('#Reste_fact').val((TOTALTTC).toFixed(2));
}); 
$(document).on('change click','#id_lot', function() {
var id = this.value;
$('#qte').focus();
     $('.prix_prod').load('ajax/get_prix_lot.php?id='+id+'&action=vente',function(){       
    });
});
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_client', function() {
$('#id_article').select2('open');
});
$(document).on('change','#id_article', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.info-prodact').load('ajax/get_info-prod.php?id='+id+'&action=vente&id_societe='+id_societe,function(){       
    });

});


</script>
<?php if (empty($table_vantes)) {?>
   <script>
      $( window ).load(function() {
  $('#id_client').select2('open');
}); 

</script>
<?php }else {?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#Enregistrer_paiement").attr("disabled", false);
            $("#Enregistrer_paiement").attr("data-toggle", "modal");
            });   
</script>
<?php } ?>

<script>
$(document).on('click','#submit', function() {
//$("#id_client").prop("disabled", true);
    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_article =$('#id_article').val();
    var id_lot =$('#id_lot').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var prix_achat =$('#prix_achat').val();
    var Remise =$('#Remise').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addavoirvente.php?date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&id_lot='+id_lot+'&prix_achat='+prix_achat,function(){       
    });
});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_article =$('#id_article').val();
    var id_lot =$('#id_lot').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var prix_achat =$('#prix_achat').val();
    var Remise =$('#Remise').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addavoirvente.php?date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&id_lot='+id_lot+'&prix_achat='+prix_achat,function(){       
    });
    }
});
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    $(this).parents('.item-row').find('.HT').removeClass();
    $(this).parents('.item-row').find('.TVA').removeClass();
    $(this).parents('.item-row').find('.TTC').removeClass();
    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteavoirvente.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe,
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });





////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
            //    window.location = 'invoice.php?action=fact_vente';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
<?php } else if  ($action=='vente')  { ?>
 <div class="notification-paiement"></div>
                      <div id="add-paiment"  data-backdrop="static" data-keyboard="false" aria-hidden="false" class="modal container fade" tabindex="-1" style=" margin-top: -122.5px;">
                                    <div class="modal-header">
                                        
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe);
                                    $somme_Reglement = Reglement_client::trouve_somme_Reglement_vide_par_admin($user->id,$nav_societe->id_societe); 
                                    
                                    $Reste_fact =$Somme_ttc->somme_ttc - $somme_Reglement->somme ;
                                     ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>?action=fact_vente" method="POST"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row info-TTC" >
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="Remise" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                        
                                                        <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  number_format($Reste_fact,2,"."," "); ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                           
                                            <div class="col-md-12 notification-mode-paiement table-responsive">
                                                <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                             <?php  $table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin($user->id,$nav_societe->id_societe);     $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                            <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_client= Solde_client::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_client->reference)) {
                                            echo fr_date2($Solde_client->date).' | '.$Solde_client->reference;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_client->solde)) {
                                            echo number_format($Solde_client->solde,2,"."," ");
                                        } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde_client->solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                                    <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture[]" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>
                                                                </select>   
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                     
                                </td>
                                <td>
                                    
                                </td>    
                                <td>
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
                                    
                                            </div>

                                            </div>
                                              
                                     
                                    </div>
                                    <div class="modal-footer">
                                    	<button style="float: left;"  class="btn blue" data-toggle="modal" href="#Rclient"> Nouveau Reglement</button>
                                        <button type="button" id="cancel_paiement" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button type="submit" <?php if (empty($table_Reglements)) {echo 'disabled'; } ?>  id="save_paiement"  class="btn green"> CRÉER UN PAIEMENT</button>
                                    </div>
                                    <input type="hidden" id="facture_scan"  name="facture_scan" value="<?php if (isset($img_select->id)){  echo $img_select->id;} ?>"    />
                                     				<input type="hidden" id="ht_fact"  name="ht_fact" value=""    />
                                            <input type="hidden" id="date_facture"  name="date_fact" value=""    />
                                            <input type="hidden" id="Remise_fact"   name="Remise_fact" value=""    />
                                            <input type="hidden" class="client"  id="client" name="client"  value="" />
                                            <input type="hidden" id="tva_fact" name="tva_fact"  value="" />
                                            <input type="hidden" id="ttc_fact" name="ttc_fact"  value="" />
                                    </form>
                                </div>


<div class="notification-reglement"></div>
<div id="Rclient" class="modal container fade" tabindex="-1">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <form   id="versement_form"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-5">
                                        	 <input type="hidden" class="client" id="id_client" name="id_client"  value="" />
                                                      
                                                <input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">       
                                                        
                                               
                                               <div class="form-group form-md-line-input">
                                                 <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe); ?>    
                                                    <label class="col-md-3 control-label">Mode paiment</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control  "   id="mode_paiment"  name="mode_paiment">
                                                         <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)){ echo $Mode_paiement_societe->id;}  ?>"><?php if(isset($Mode_paiement_societe->type)){ echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>  
                                                                 
                                                    </select> 
                                                    </div>
                                                </div>
                                           <?php if (isset($nav_societe->id_societe)) {
                                                                $Comptes = Compte::trouve_par_societe($nav_societe->id_societe);
                                                                
                                                                
                                                                ?>
                                                    <div class="form-group form-md-line-input mode_paiment ">
                                                    <label class="col-md-3 control-label">Banque</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="banque" id="banque"  placeholder="Choisir" >
                                                    
                                                            <?php  foreach ($Comptes as $Compte){
                                                            $banque = Banque::trouve_par_id($Compte->id_banque) ?>
                                                                <option  value="<?php if (isset($Compte->id)) {
                                                                    echo $Compte->id;}?>"><?php if (isset($banque->Designation)) {
                                                                    echo $banque->Designation;} ?> </option>
                                                <?php } ?>  
                                                                       
                                                        </select> 
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            </div>
                                            <div class="col-md-7 ">
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="credit" class="form-control " name="credit"  placeholder="00.00" required   />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">référence <span class="required" aria-required="true"> * </span></label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="reference" class="form-control " name="reference" placeholder="RG0001" required   />
                                                        
                                                    </div>                                            
                                                  
                                                   <input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;} ?>">
                                                </div>
                                            </div>
                                              
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de versement</label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>" required>
                                                    </div>                                            
                                                  
                                                </div>

                                            </div> 
                                                   
                                            </div>
                                              
                                     </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button  id="save_versment" data-dismiss="modal" class="btn green" > Valider</button>
                                    </div>
                                </div>                             
<script>
    ////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#mode_paiment', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.mode_paiment').load('ajax/get_mode_paiement.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
///////////////////////// save_versment ////////////////////
$(document).on('click','button#save_versment', function() {
    var id = <?php if (isset($client->id_client)) {echo $client->id_client;} else {echo '0';} ?>;
$.ajax({
type: "POST",
url: "ajax/save_versment.php",
data: $('#versement_form').serialize(),
success: function(message){
$(".notification-reglement").html(message)
},
error: function(){
alert("Error");
}
});

 
}); 
////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_client =$('#id_client').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var TOTALTTC =$('#TTC').val();
    $(".info-TTC").load('ajax/calcule_timbre.php?vente&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC,function(){});
     $(this).parents('.info-mode_paiment').load('ajax/get_mode_paiement_fact.php?vente&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC,function(){});

});

///////////////////// onchqnge list Paiement fact ///////////////////
$(document).on('change','#list_paiment_facture', function() {
    var id = this.value;
    var TOTALTTC =$('#TTC').val();
    var Reste_fact = parseFloat($('#Reste_fact').val()) || 0;
      $.ajax({
            type:'POST',
            url:'ajax/get_solde_mode_paiement.php',
            dataType: "json",
            data:'action=vente&id='+id+'&TOTALTTC='+TOTALTTC+'&Reste_fact='+Reste_fact,
            success:function(response){
                    $('#solde').val(parseFloat(response.data.Solde_client).toFixed(2));   
                    $('#Montant').val(parseFloat(response.data.TOTAL).toFixed(2));   
                    $('#reste').val(parseFloat(response.data.rest).toFixed(2));   
            },
        error: function(){
    alert("Error");
    }
        });
    
});

   ////////////// calcul reste mode paiement //////////////////
$(document).on('keyup change','#Montant', function() {
    var solde =parseFloat($('#solde').val());
    var Montant = parseFloat($('#Montant').val());
    var reste = solde - Montant ;

    $('#reste').val((reste).toFixed(2));
});

 //////////////// add_paiement ////////////////////////////
 
$(document).on('click','#add_paiement', function() {
    
    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_solde =$('#list_paiment_facture').val()||0;
    var reste = parseFloat($('#Reste_fact').val()) || 0;
    var Montant =$('#Montant').val();
    var TOTALTTC =$('#TTC').val();
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification-mode-paiement").load('ajax/addmodepaiement.php?vente&date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_solde='+id_solde+'&reste='+reste+'&Montant='+Montant+'&mode_paiment='+mode_paiment,function(){       
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?vente&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC,function(){});

});
///////////////////  delete mode paiement //////////////////////////////////////

  $(document).on('click','#delete_row,#cancel_paiement', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).attr('name')|| 0;
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_client =$('#id_client').val();
    var TOTALTTC =$('#TTC').val();
    $.ajax({
    type: "GET",
    url: "ajax/deletepaiement.php?vente&delete&id="+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client,
    success: function(message){
    $(".notification-mode-paiement").html(message)},
    error: function(){
    alert("Error");
    }
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?vente&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC,function(){});
  }); 
    ////////////// get facture info when onclick Enregistrer_paiement //////////////////
$(document).on('click','#Enregistrer_paiement', function() {
    var Remise_fact =$('#REMISE_ht').text();
    var date_facture = $('#date_fact').val();
    var TOTALTVA = parseFloat($('#TOTALTVA').text());
    var TOTALTTC = parseFloat($('#TOTALTTC').text());
    var date_facture = $('#date_fact').val();
    var client =$('#id_client').val();
    var TOTALHT_R = parseFloat($('#TOTALHT_R').text());

    $('#Remise_fact').val(Remise_fact);
    $('#date_facture').val(date_facture);
    $('.client').val(client);
    $('#ht_fact').val(TOTALHT_R);
    $('#tva_fact').val(TOTALTVA);
    $('#ttc_fact').val(TOTALTTC);
    $('#TTC').val((TOTALTTC).toFixed(2));
    $('#Reste_fact').val((TOTALTTC).toFixed(2));
}); 
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_client', function() {
$('#id_article').select2('open');
});
$(document).on('change click','#id_lot', function() {
var id = this.value;
$('#qte').focus();
     $('.prix_prod').load('ajax/get_prix_lot.php?id='+id+'&action=vente',function(){       
    });
});
$(document).on('change','#id_article', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;

     $('.info-prodact').load('ajax/get_info-prod.php?id='+id+'&action=vente&id_societe='+id_societe,function(){       
    });
});
$(document).on('click','#reset_total', function() {
    var TOTALTTC1 = parseFloat($('#TOTALTTC1').val());
    var TOTALTVA1 = parseFloat($('#TOTALTVA1').val());
    var TOTALHT = parseFloat($('#TOTALHT').text());
 
    $('#TOTALTVA').html((TOTALTVA1).toFixed(2));
    $('#TOTALTTC').html((TOTALTTC1).toFixed(2));
    $('#TTC_propose').val((TOTALTTC1).toFixed(2));
    $('#TOTALHT_R').html((TOTALHT).toFixed(2));
    $('#REMISE_ht').val((0).toFixed(2));
    $('#rest_calc_tva').html((0).toFixed(2));
    $('#REMISE_ht').html((0).toFixed(2));
});


$(document).on('keyup','#TTC_propose,#REMISE_ht', function() {

    var totalttc = parseFloat($('#TOTALTTC1').val());
    var total = parseFloat($('#TOTALHT').text());
 			
	var TTC_propose = parseFloat($('#TTC_propose').val())

	var  Ttva =  parseFloat($('#last_tva').val());	


	if(isNaN(Ttva)){Ttva =0;}
	var  calc_tva = Ttva + 1;

  if ( TTC_propose >= 0 ) {
   	    reste_calc = totalttc - TTC_propose ;
	      rest_calc_tva = reste_calc / calc_tva ;  
  }



  var  TOTALHT_R = total - rest_calc_tva;
	    TOTALTVA = TOTALHT_R * Ttva;
	    TOTALTTC = TOTALTVA + TOTALHT_R;
	    $('#TOTALHT').html((total).toFixed(2));
        $('#TOTALHT_R').html((TOTALHT_R).toFixed(2));
       	$('#REMISE_ht').html((rest_calc_tva).toFixed(2));	
        $('#TOTALTVA').html((TOTALTVA).toFixed(2));
        $('#TOTALTTC').html((TOTALTTC).toFixed(2));

 });
/*$(document).on('keypress','#prix', function() {
        var _this = $(this); // copy of this object for further usage
        setTimeout(function() {
            $('#id_tva').select2('open');
        },3000);
    });
*/
//focusBanque = function getFocus() {           
 // document.getElementById("n_compte").focus();}
//focusCaisse = function getFocus() {           
 // document.getElementById("n_caisse").focus();}
</script>
<?php if (empty($table_vantes)) {?>
   <script>
      $( window ).load(function() {
  $('#id_client').select2('open');
}); 

</script>
<?php }else {
$array= array();
                foreach ($table_vantes as  $table_vante) {
                array_push($array, $table_vante->Ttva);} ?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#Enregistrer_paiement").attr("disabled", false);
            $("#Enregistrer_paiement").attr("data-toggle", "modal");
            <?php 
    if(count(array_unique($array)) === 1) {
                echo '$("#REMISE_ht").attr("disabled", false);
                $("#TTC_propose").attr("disabled", false);'; 
            }else{
                echo '$("#REMISE_ht").attr("disabled", true);
                $("#TTC_propose").attr("disabled", true);'; 
                }
             ?>
            });   
</script>
<?php } ?>

<script>
$(document).on('click','button#submit', function() {
//$("#id_client").prop("disabled", true);
    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_article =$('#id_article').val();
    var id_lot =$('#id_lot').val()||0;
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var prix_achat =$('#prix_achat').val();
    var Remise =$('#Remise').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addvente.php?date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&id_lot='+id_lot+'&prix_achat='+prix_achat,function(){       
    });
});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_article =$('#id_article').val();
    var id_lot =$('#id_lot').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var prix_achat =$('#prix_achat').val();
    var Remise =$('#Remise').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addvente.php?date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&id_lot='+id_lot+'&prix_achat='+prix_achat,function(){       
    });
    }
});
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    $(this).parents('.item-row').find('.HT').removeClass();
    $(this).parents('.item-row').find('.TVA').removeClass();
    $(this).parents('.item-row').find('.TTC').removeClass();
    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deletevente.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe,
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
    $('.TTC-proposer').load('ajax/get_ttc.php?id_user='+id_user+'&id_societe='+id_societe,function(){       
    });
    
    var TTC = parseFloat($('#TOTALTTC1').val());
    $('#TTC_propose').html((TTC).toFixed(2));


  });
////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
     $('.mode_paiment_facture').load('ajax/get_mode_paiement_facture.php?vente&id='+id+'&id_societe='+id_societe+'&id_user='+id_user,function(){       
    });
});
//////////////////////////  valider vente//////////////////

  $(document).on('click','#valider', function() {
window.location = 'invoice.php?action=fact_vente';
  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'invoice.php?action=fact_vente';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
<?php } else if  ($action=='add_pieces' or $action=='comptableser')  { ?>

<script>
///// edit ecriture ///////////////
    $(document).on('click','.editBtn', function() {

        var Debit=  $(this).closest("tr").find(".Debit").val();
        var Credit= $(this).closest("tr").find(".Credit").val();
        var Annexe_Fiscale= $(this).closest("tr").find(".Annexe_Fiscale").val();
        var Date_ecriture= $(this).closest("tr").find(".Date_ecriture").val();

        //hide edit span
        $(this).closest("tr").find(".editSpanDebit").hide();
        $(this).closest("tr").find(".editSpanCredit").hide();
        $(this).closest("tr").find(".editSpanAnnexe_Fiscale").hide();
        $(this).closest("tr").find(".editSpanDate").hide();
        
        //show edit input
        $(this).closest("tr").find(".Debit").show();
        $(this).closest("tr").find(".Credit").show();
        $(this).closest("tr").find(".Annexe_Fiscale").show();
        $(this).closest("tr").find(".Date_ecriture").show();

        if (Debit > Credit) {
                       $(this).closest("tr").find(".Debit").focus(); 
                   }else{
                    $(this).closest("tr").find(".Credit").focus();
                   }         
        //hide edit button
        $(this).closest("tr").find(".editBtn").hide();
        
        //show edit button
        $(this).closest("tr").find(".saveBtn").show();
        
    });
    $(document).on('click','.saveBtn', function() {
        var trObj = $(this).closest("tr");
        var ID = $(this).closest("tr").attr('id');
        var Debit = $(this).closest("tr").find(".Debit").serialize();
        var Credit = $(this).closest("tr").find(".Credit").serialize();
        var Annexe_Fiscale = $(this).closest("tr").find(".Annexe_Fiscale").serialize();
        var Date_ecriture = $(this).closest("tr").find(".Date_ecriture").serialize();
        var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
        var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
        $.ajax({
            type:'POST',
            url:'ajax/update_ecriture.php',
            dataType: "json",
            data:'action=edit&id='+ID+'&'+Debit+'&'+Credit+'&'+Annexe_Fiscale+'&'+Date_ecriture+'&id_user='+id_user+'&id_societe='+id_societe,
            success:function(response){
                if(response.status == 'ok'){
                    var diff = parseFloat(response.data.diff);
                   // trObj.find(".editSpanDebit").text(response.data.Debit);
                    trObj.find(".editSpanDebit").text(parseFloat(response.data.Debit).toFixed(2));
                    trObj.find(".editSpanCredit").text(parseFloat(response.data.Credit).toFixed(2));
                    trObj.find(".editSpanAnnexe_Fiscale").text(parseFloat(response.data.Annexe_Fiscale).toFixed(2));
                    trObj.find(".editSpanDate").text(response.data.Date_ecriture);
                    
                    trObj.find("#debit").text(parseFloat(response.data.Debit).toFixed(2));
                    trObj.find(".Credit").text(parseFloat(response.data.Credit).toFixed(2));
                    trObj.find(".Annexe_Fiscale").text(parseFloat(response.data.Annexe_Fiscale).toFixed(2));
                    trObj.find(".Date_ecriture").text(response.data.Date_ecriture);
                    
                    trObj.find(".Debit").hide();
                    trObj.find(".Credit").hide();
                    trObj.find(".Annexe_Fiscale").hide();
                    trObj.find(".Date_ecriture").hide();
                    trObj.find(".saveBtn").hide();
                    trObj.find(".editSpanDebit").show();
                    trObj.find(".editSpanCredit").show();
                    trObj.find(".editSpanAnnexe_Fiscale").show();
                    trObj.find(".editSpanDate").show();
                    trObj.find(".editBtn").show();
                    $('.Credit').removeAttr('readonly'); 
                    $('.Debit').removeAttr('readonly'); 
                    $(".Etat-ecriture").html(response.data.etat);
                    $("#TOTALdebit").html(response.data.somme_debit);
                    $("#TOTALcredit").html(response.data.somme_credit);
                    if (diff > 0) { $("#Diff").html('Différence: '+diff.toFixed(2));}
                     else{$("#Diff").html(''); }
                     toastr.success(response.msg,"Très bien !");

                }else{
                    var diff = parseFloat(response.data.diff);
                    trObj.find(".Debit").hide();
                    trObj.find(".Credit").hide();
                    trObj.find(".Annexe_Fiscale").hide();
                    trObj.find(".Date_ecriture").hide();
                    trObj.find(".saveBtn").hide();
                    trObj.find(".editSpanDebit").show();
                    trObj.find(".editSpanCredit").show();
                    trObj.find(".editSpanAnnexe_Fiscale").show();
                    trObj.find(".editSpanDate").show();
                    trObj.find(".editBtn").show();
                    $('.Credit').removeAttr('readonly'); 
                    $('.Debit').removeAttr('readonly');
                    $(".Etat-ecriture").html(response.data.etat);
                    $("#TOTALdebit").html(response.data.somme_debit);
                    $("#TOTALcredit").html(response.data.somme_credit);
                    if (diff > 0) { $("#Diff").html('Différence : '+diff.toFixed(2));}
                     else{$("#Diff").html(''); }
                    toastr.info(response.msg,"Attention !");
                }
            }
        });
    });
///////////////////////// focus on change ////////////////

$(document).on('change','#id_Journal', function() {
$('#reference').focus();
});
$(document).on('change','#auxiliere', function() {
$('#Debit').focus();
});
///////////disable input debut or credit /////////////////
$(document).on('input','.Debit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('.Credit').attr("readonly", "readonly");
  }   
  else  {
    $('.Credit').removeAttr('readonly'); 
  } 

});

$(document).on('input','.Credit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('.Debit').attr("readonly", "readonly");
  }   
  else  {
    $('.Debit').removeAttr('readonly'); 

  } 

});

$(document).on('input','#Debit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('#Credit').attr("readonly", "readonly");
  }   
  else  {
    $('#Credit').removeAttr('readonly'); 
  } 

});

$(document).on('input','#Credit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('#Debit').attr("readonly", "readonly");
  }   
  else  {
    $('#Debit').removeAttr('readonly'); 

  } 

});
////////////// get info compte when onchange ////////////////////
$(document).on('change','#id_compte', function() {
    var id = this.value;
    var date_comptable =$('#date_comptable').val();
    var id_Journal =$('#id_Journal').val();
    var reference =$('#reference').val();
    var libelle =$('#libelle').val();
    libelle = libelle.replace(/ /gi, "_");
    reference = reference.replace(/ /gi, "_");
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $('.info-compte').load('ajax/get_info-compte.php?id='+id+'&id_societe='+id_societe+'&date_comptable='+date_comptable+'&id_Journal='+id_Journal+'&reference='+reference+'&libelle='+libelle,function(){       
    });
});


</script>
<?php if (empty($Ecriture_comptables)) {?>
   <script>
      $( window ).load(function() {
  $('#id_Journal').select2('open');
}); 

</script>
<?php }else {?>
   <script>
            $(document).ready(function(){
            $("#id_compte").select2("open");
            $("#Enregistrer_paiement").attr("disabled", false);
            $("#Enregistrer_paiement").attr("data-toggle", "modal");
            });   
</script>
<?php } ?>

<script>
    //////// add ecriture //////////////////////:
$(document).on('click','button#submit', function() {

    var id_compte =$('#id_compte').val();
    var date_comptable =$('#date').val();
    var reference =$('#ref').val();
    var libelle =$('#lib').val();
    var id_Journal =$('#Journal').val();
    var auxiliere =$('#auxiliere').val();
    var Debit =$('#Debit').val();
    var Credit =$('#Credit').val();
    var Annexe_Fiscale =$('#Annexe_Fiscale').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addecriture.php?date='+date_comptable+'&id_compte='+id_compte+'&id_person='+id_user+'&id_societe='+id_societe+'&ref='+reference+'&lib='+libelle+'&Journal='+id_Journal+'&auxiliere='+auxiliere+'&Debit='+Debit+'&Credit='+Credit+'&Annexe_Fiscale='+Annexe_Fiscale,function(){       
    });
});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
 var id_compte =$('#id_compte').val();
    var date_comptable =$('#date').val();
    var reference =$('#ref').val();
    var libelle =$('#lib').val();
    var id_Journal =$('#Journal').val();
    var auxiliere =$('#auxiliere').val();
    var Debit =$('#Debit').val();
    var Credit =$('#Credit').val();
    var Annexe_Fiscale =$('#Annexe_Fiscale').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addecriture.php?date='+date_comptable+'&id_compte='+id_compte+'&id_person='+id_user+'&id_societe='+id_societe+'&ref='+reference+'&lib='+libelle+'&Journal='+id_Journal+'&auxiliere='+auxiliere+'&Debit='+Debit+'&Credit='+Credit+'&Annexe_Fiscale='+Annexe_Fiscale,function(){       
    });
    }
});
/////////// delete ecriture //////////////////
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteecriture.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe,
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });

//////////////////////////  valider ecriture//////////////////

  $(document).on('click','#Enregistrer_paiement', function() {
    var somme_debit = parseFloat($('#TOTALdebit').text());
    var somme_credit = parseFloat($('#TOTALcredit').text());
    if (somme_credit != somme_debit) {
        toastr.error("Ecritures Déséquilibrés","Attention !");
    }else{
        window.location = '<?php echo $_SERVER['PHP_SELF']?>?action=valid_piece';
    }

  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            var somme_debit = parseFloat($('#TOTALdebit').text());
            var somme_credit = parseFloat($('#TOTALcredit').text());
            var nbr_ecriture = <?php if (isset($nbr_ecriture)) { echo $nbr_ecriture; } else { echo '0';} ?>;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;

                // Add valider ecriture //
                if (somme_credit != somme_debit) {
                    toastr.error("Ecritures Déséquilibrés","Attention !");
                } else{
                   toastr.success("Ecritures Equilibrés","Très Bien !");
                }
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
<?php } else if  ($action=='edit_piece')  { ?>

<script>
///// edit ecriture ///////////////
    $(document).on('click','.editBtn', function() {

        var Debit=  $(this).closest("tr").find(".Debit").val();
        var Credit= $(this).closest("tr").find(".Credit").val();

        //hide edit span
        $(this).closest("tr").find(".editSpanDebit").hide();
        $(this).closest("tr").find(".editSpanCredit").hide();
        
        //show edit input
        $(this).closest("tr").find(".Debit").show();
        $(this).closest("tr").find(".Credit").show();

        if (Debit > Credit) {
                       $(this).closest("tr").find(".Debit").focus(); 
                   }else{
                    $(this).closest("tr").find(".Credit").focus();
                   }         
        //hide edit button
        $(this).closest("tr").find(".editBtn").hide();
        
        //show edit button
        $(this).closest("tr").find(".saveBtn").show();
        
    });
    $(document).on('click','.saveBtn', function() {
        var trObj = $(this).closest("tr");
        var ID = $(this).closest("tr").attr('id');
        var Debit = $(this).closest("tr").find(".Debit").serialize();
        var Credit = $(this).closest("tr").find(".Credit").serialize();
        var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
        var id_piece = <?php if (isset($id_piece)) {echo $id_piece;}  ?>;
        var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
        $.ajax({
            type:'POST',
            url:'ajax/update_ecriture.php',
            dataType: "json",
            data:'action=edit&id='+ID+'&'+Debit+'&'+Credit+'&id_user='+id_user+'&id_societe='+id_societe+'&id_piece='+id_piece,
            success:function(response){
                if(response.status == 'ok'){
                    var diff = parseFloat(response.data.diff);
                   // trObj.find(".editSpanDebit").text(response.data.Debit);
                    trObj.find(".editSpanDebit").text(parseFloat(response.data.Debit).toFixed(2));
                    trObj.find(".editSpanCredit").text(parseFloat(response.data.Credit).toFixed(2));
                    
                    trObj.find("#debit").text(parseFloat(response.data.Debit).toFixed(2));
                    trObj.find(".Credit").text(parseFloat(response.data.Credit).toFixed(2));
                    
                    trObj.find(".Debit").hide();
                    trObj.find(".Credit").hide();
                    trObj.find(".saveBtn").hide();
                    trObj.find(".editSpanDebit").show();
                    trObj.find(".editSpanCredit").show();
                    trObj.find(".editBtn").show();
                    $('.Credit').removeAttr('readonly'); 
                    $('.Debit').removeAttr('readonly'); 
                    $(".Etat-ecriture").html(response.data.etat);
                    $("#TOTALdebit").html(response.data.somme_debit);
                    $("#TOTALcredit").html(response.data.somme_credit);
                    if (diff > 0) { $("#Diff").html('Différence: '+diff.toFixed(2));}
                     else{$("#Diff").html(''); }
                     toastr.success(response.msg,"Très bien !");

                }else{
                    var diff = parseFloat(response.data.diff);
                    trObj.find(".Debit").hide();
                    trObj.find(".Credit").hide();
                    trObj.find(".saveBtn").hide();
                    trObj.find(".editSpanDebit").show();
                    trObj.find(".editSpanCredit").show();
                    trObj.find(".editBtn").show();
                    $('.Credit').removeAttr('readonly'); 
                    $('.Debit').removeAttr('readonly');
                    $(".Etat-ecriture").html(response.data.etat);
                    $("#TOTALdebit").html(response.data.somme_debit);
                    $("#TOTALcredit").html(response.data.somme_credit);
                    if (diff > 0) { $("#Diff").html('Différence : '+diff.toFixed(2));}
                     else{$("#Diff").html(''); }
                    toastr.info(response.msg,"Attention !");
                }
            }
        });
    });
///////////////////////// focus on change ////////////////

$(document).on('change','#id_Journal', function() {
$('#reference').focus();
});
$(document).on('change','#auxiliere', function() {
$('#Debit').focus();
});
///////////disable input debut or credit /////////////////
$(document).on('input','.Debit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('.Credit').attr("readonly", "readonly");
  }   
  else  {
    $('.Credit').removeAttr('readonly'); 
  } 

});

$(document).on('input','.Credit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('.Debit').attr("readonly", "readonly");
  }   
  else  {
    $('.Debit').removeAttr('readonly'); 

  } 

});

$(document).on('input','#Debit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('#Credit').attr("readonly", "readonly");
  }   
  else  {
    $('#Credit').removeAttr('readonly'); 
  } 

});

$(document).on('input','#Credit', function() {
   
   if  (this.value.trim().length >= 1) {
    $('#Debit').attr("readonly", "readonly");
  }   
  else  {
    $('#Debit').removeAttr('readonly'); 

  } 

});
////////////// get info compte when onchange ////////////////////
$(document).on('change','#id_compte', function() {
    var id = this.value;
    var date_comptable =$('#date_comptable').val();
    var id_Journal =$('#id_Journal').val();
    var reference =$('#reference').val();
    var libelle =$('#libelle').val();
    libelle = libelle.replace(/ /gi, "_");
    reference = reference.replace(/ /gi, "_");
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $('.info-compte').load('ajax/get_info-compte.php?id='+id+'&id_societe='+id_societe+'&date_comptable='+date_comptable+'&id_Journal='+id_Journal+'&reference='+reference+'&libelle='+libelle,function(){       
    });
});


</script>
<?php if (empty($Ecriture_comptables)) {?>
   <script>
      $( window ).load(function() {
  $('#id_Journal').select2('open');
}); 

</script>
<?php }else {?>
   <script>
            $(document).ready(function(){
            $("#id_compte").select2("open");
            $("#Enregistrer_paiement").attr("disabled", false);
            $("#Enregistrer_paiement").attr("data-toggle", "modal");
            });   
</script>
<?php } ?>

<script>
    //////// add ecriture //////////////////////:
$(document).on('click','button#submit', function() {

    var id_compte =$('#id_compte').val();
    var date_comptable =$('#date').val();
    var reference =$('#ref').val();
    var libelle =$('#lib').val();
    var id_Journal =$('#Journal').val();
    var auxiliere =$('#auxiliere').val();
    var Debit =$('#Debit').val();
    var Credit =$('#Credit').val();
    var id_piece =<?php if (isset($id_piece)) {echo $id_piece;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addecriture.php?date='+date_comptable+'&id_compte='+id_compte+'&id_person='+id_user+'&id_societe='+id_societe+'&ref='+reference+'&lib='+libelle+'&Journal='+id_Journal+'&auxiliere='+auxiliere+'&Debit='+Debit+'&Credit='+Credit+'&id_piece='+id_piece,function(){       
    });
});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
 var id_compte =$('#id_compte').val();
    var date_comptable =$('#date').val();
    var reference =$('#ref').val();
    var libelle =$('#lib').val();
    var id_Journal =$('#Journal').val();
    var auxiliere =$('#auxiliere').val();
    var Debit =$('#Debit').val();
    var Credit =$('#Credit').val();
    var id_piece =<?php if (isset($id_piece)) {echo $id_piece;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addecriture.php?date='+date_comptable+'&id_compte='+id_compte+'&id_person='+id_user+'&id_societe='+id_societe+'&ref='+reference+'&lib='+libelle+'&Journal='+id_Journal+'&auxiliere='+auxiliere+'&Debit='+Debit+'&Credit='+Credit+'&id_piece='+id_piece,function(){       
    });
    }
});
/////////// delete ecriture //////////////////
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).val();
    var id_piece =<?php if (isset($id_piece)) {echo $id_piece;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteecriture.php?id="+id+"&id_piece="+id_piece,
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });

//////////////////////////  valider ecriture//////////////////

  $(document).on('click','#Enregistrer_paiement', function() {
    var somme_debit = parseFloat($('#TOTALdebit').text());
    var somme_credit = parseFloat($('#TOTALcredit').text());
    var date_comptable =$('#date_comptable').val();
    var id_Journal =$('#id_Journal').val();
    var reference =$('#reference').val();
    var libelle =$('#libelle').val();
    libelle = libelle.replace(/ /gi, "_");
    reference = reference.replace(/ /gi, "_");
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_piece =<?php if (isset($id_piece)) {echo $id_piece;}  ?>;
    if (somme_credit != somme_debit) {
        toastr.error("Ecritures Déséquilibrés","Attention !");
    } else{
    $('.notification').load('ajax/update_piece.php?id='+id_piece+'&id_societe='+id_societe+'&date_comptable='+date_comptable+'&id_Journal='+id_Journal+'&reference='+reference+'&libelle='+libelle,function(){       
    });
        
        window.location = 'piece.php?id='+id_piece+'&action=update';
    }

  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            var somme_debit = parseFloat($('#TOTALdebit').text());
            var somme_credit = parseFloat($('#TOTALcredit').text());
            var nbr_ecriture = <?php if (isset($nbr_ecriture)) { echo $nbr_ecriture; } else { echo '0';} ?>;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;

                // Add valider ecriture //
                if (somme_credit != somme_debit) {
                    toastr.error("Ecritures Déséquilibrés","Attention !");
                } else{
                   toastr.success("Ecritures Equilibrés","Très Bien !");
                }
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
    <?php }  else if  ($action=='achat')   { ?>
                        <div class="notification-paiement"></div>
                      <div id="add-paiment_achat" data-backdrop="static" data-keyboard="false" aria-hidden="false" class="modal container fade" tabindex="-1" style=" margin-top: -122.5px;">
                                    <div class="modal-header">
                                        
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe);

                                    $somme_Reglement = Reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($user->id,$nav_societe->id_societe,1); 
                                    
                                    $Reste_fact =$Somme_ttc->somme_ttc - $somme_Reglement->somme ;
                                     ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>?action=fact_achat" method="POST"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row info-TTC" >
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="Remise" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                        
                                                        <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  number_format($Reste_fact,2,"."," "); ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                           
                                            <div class="col-md-12 notification-mode-paiement table-responsive">
                                                <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                             <?php  $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($user->id,$nav_societe->id_societe,1);     $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                            <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_fournisseur->solde)) {
                                            echo number_format($Solde_fournisseur->solde,2,"."," ");
                                        } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde_fournisseur->solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                                    <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture[]" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>
                                                                </select>   
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                     
                                </td>
                                <td>
                                    
                                </td>    
                                <td>
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
                                    
                                            </div>

                                            </div>
                                              
                                     
                                    </div>
                                    <div class="modal-footer">
                                    	<button style="float: left;"  class="btn blue" data-toggle="modal" href="#Rfournisseur"> Nouveau Reglement</button>
                                        <button type="button" id="cancel_paiement" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button type="submit" <?php if (empty($table_Reglements)) {echo 'disabled'; } ?>  id="save_paiement"  class="btn green"> CRÉER UN PAIEMENT</button>
                                    </div>
                                     <input type="hidden" id="facture_scan" class="form-control " name="facture_scan" value="<?php if (isset($img_select->id)){  echo $img_select->id;} ?>"    />
                                            <input type="hidden" id="date_facture" class="form-control " name="date_fact" value=""    />
                                            <input type="hidden" id="Reference_facture" class="form-control " name="Reference" value=""    />
                                            <input type="hidden" class="fournisseur" id="fournisseur" name="fournisseur"  value="" />
                                    </form>


                               </div>

<!-- modal versement -->
  <div class="notification-reglement"></div>  
                    <div id="Rfournisseur" class="modal container fade" tabindex="-1">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiment</h4>
                                    </div>
                                    <div class="modal-body">
                                    <form   id="versement_form_f"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-5">
                                                                                                                                        
                                            
                                                <input type="hidden" class="fournisseur" id="fournisseur" name="id_fournisseur"  value="" />
                                              
                                                <input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">       
                                                        
                                               
                                                <div class="form-group form-md-line-input">
                                                 <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe); ?>    
                                                    <label class="col-md-3 control-label">Mode paiment</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control  "   id="mode_paiment"  name="mode_paiment">
                                                         <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)){ echo $Mode_paiement_societe->id;}  ?>"><?php if(isset($Mode_paiement_societe->type)){ echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>  
                                                                 
                                                    </select> 
                                                    </div>
                                                </div>
                                          <?php if (isset($nav_societe->id_societe)) {
                                                               
                                                                 $Comptes = Compte::trouve_par_societe($nav_societe->id_societe);
                                                                
                                                                
                                                                ?>
                                                    <div class="form-group form-md-line-input mode_paiment ">
                                                    <label class="col-md-3 control-label">Banque</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="banque" id="banque"  placeholder="Choisir" >
                                                    
												                              <?php  foreach ($Comptes as $Compte){
																											$banque = Banque::trouve_par_id($Compte->id_banque);
																											 ?>
																												<option value="<?php if (isset($Compte->id)) {
																													echo $Compte->id;}?>"><?php if (isset($banque->Designation)) {
																													echo $banque->Designation;} ?> </option>
                                                <?php } ?>  
                                                                       
                                                        </select> 
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            
                                            </div>
                                            <div class="col-md-7 ">
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant <span class="required" aria-required="true"> * </span></label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="debit" class="form-control " name="debit"  required placeholder="00.00" />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">référence  <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="reference" class="form-control " name="reference" required placeholder="RG001"  />
                                                        
                                                    </div>                                            
                                                  
                                                   <input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;} ?>">
                                                </div>
                                            </div>
                                              
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de versement</label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>" required>
                                                    </div>                                            
                                                  
                                                </div>

                                            </div> 
                                                   
                                            </div>
                                              
                                     </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button  id="save_versment_f" data-dismiss="modal" class="btn green" > Valider</button>
                                    </div>
                                </div>
     <!-- END modal versement -->



    <script>
    ////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#mode_paiment', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.mode_paiment').load('ajax/get_mode_paiement.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
/////////////////////////// save versment  ////////////////////////////////

$(document).on('click','button#save_versment_f', function() {

$.ajax({
type: "POST",
url: "ajax/save_versment_f.php",
data: $('#versement_form_f').serialize(),
success: function(message){
$(".notification-reglement").html(message)
},
error: function(){
alert("Error");
}
});

 
}); 
</script>
<script>

////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_fournisseur =$('#id_fournisseur').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var TOTALTTC =$('#TTC').val();
    $(".info-TTC").load('ajax/calcule_timbre.php?achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});
     $(this).parents('.info-mode_paiment').load('ajax/get_mode_paiement_fact.php?achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});

});
///////////////////// onchqnge list Paiement fact ///////////////////
$(document).on('change','#list_paiment_facture', function() {
    var id = this.value;
    var TOTALTTC =$('#TTC').val();
    var Reste_fact = parseFloat($('#Reste_fact').val()) || 0;
      $.ajax({
            type:'POST',
            url:'ajax/get_solde_mode_paiement.php',
            dataType: "json",
            data:'action=achat&id='+id+'&TOTALTTC='+TOTALTTC+'&Reste_fact='+Reste_fact,
            success:function(response){
                    $('#solde').val(parseFloat(response.data.Solde_fournisseur).toFixed(2));   
                    $('#Montant').val(parseFloat(response.data.TOTAL).toFixed(2));   
                    $('#reste').val(parseFloat(response.data.rest).toFixed(2));   
            },
        error: function(){
    alert("Error");
    }
        });
    
});

///////////////////  delete mode paiement //////////////////////////////////////

  $(document).on('click','#delete_row,#cancel_paiement', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).attr('name')|| 0;
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_fournisseur =$('#id_fournisseur').val();
    var TOTALTTC =$('#TTC').val();
    $.ajax({
    type: "GET",
    url: "ajax/deletepaiement.php?achat&delete&id="+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur,
    success: function(message){
    $(".notification-mode-paiement").html(message)},
    error: function(){
    alert("Error");
    }
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?achat&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});
  }); 

    ////////////// get facture reference when onclick Enregistrer_paiement //////////////////
$(document).on('click','#Enregistrer_paiement', function() {
    var Reference_facture =$('#Reference').val();
    var date_facture = $('#date_fact').val();
    var fournisseur =$('#id_fournisseur').val();
    var TTC = parseFloat($('#TOTALTTC').text());

    $('#Reference_facture').val(Reference_facture);
    $('#date_facture').val(date_facture);
    $('.fournisseur').val(fournisseur);
    $('#TTC').val((TTC).toFixed(2));
}); 
   ////////////// calcul reste mode paiement //////////////////
$(document).on('keyup change','#Montant', function() {
    var solde =parseFloat($('#solde').val());
    var Montant = parseFloat($('#Montant').val());
    var reste = solde - Montant ;

    $('#reste').val((reste).toFixed(2));
});
 //////////////// add_paiement ////////////////////////////
 
$(document).on('click','#add_paiement', function() {
    
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_solde =$('#list_paiment_facture').val()||0;
    var reste = parseFloat($('#Reste_fact').val()) || 0;
    var Montant =$('#Montant').val();
    var TOTALTTC =$('#TTC').val();
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification-mode-paiement").load('ajax/addmodepaiement.php?achat&date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_solde='+id_solde+'&reste='+reste+'&Montant='+Montant+'&mode_paiment='+mode_paiment,function(){       
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?achat&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});

});
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_fournisseur', function() {
$('#id_article').select2('open');
});
$(document).on('change','#id_article', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
      $('.info-prodact').load('ajax/get_info-prod.php?id='+id+'&action=achat&id_societe='+id_societe,function(){       
    });
});

/*$(document).on('keypress','#prix', function() {
        var _this = $(this); // copy of this object for further usage
        setTimeout(function() {
            $('#id_tva').select2('open');
        },3000);
    });
*/
//focusBanque = function getFocus() {           
 // document.getElementById("n_compte").focus();}
//focusCaisse = function getFocus() {           
 // document.getElementById("n_caisse").focus();}
</script>
<?php if (empty($table_achats)) {?>
   <script>
      $( window ).load(function() {
  $('#id_fournisseur').select2('open');
}); 

</script>
<?php }else { ?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#Enregistrer_paiement").attr("disabled", false);
            $("#Enregistrer_paiement").attr("data-toggle", "modal");
            });   
</script>
<?php } ?>

<script>
$(document).on('click','button#submit', function() {

    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var Reference =$('#Reference').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addachat.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&Reference='+Reference,function(){       
    });

});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var Reference =$('#Reference').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addachat.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&Reference='+Reference,function(){       
    });
    }
});
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    $(this).parents('.item-row').find('.HT').removeClass();
    $(this).parents('.item-row').find('.TVA').removeClass();
    $(this).parents('.item-row').find('.TTC').removeClass();
    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteachat.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe,
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });


//////////////////////////  valider achat//////////////////

  $(document).on('click','#valider', function() {
window.location = 'invoce_achat.php?action=fact_achat';
  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'invoce_achat.php?action=fact_achat';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
    <?php }  else if  ($action=='avoir_achat')   { ?>

    	 <div class="notification-paiement"></div>
                      <div id="add-paiment_achat" data-backdrop="static" data-keyboard="false" aria-hidden="false" class="modal container fade" tabindex="-1" style=" margin-top: -122.5px;">
                                    <div class="modal-header">
                                        
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe);

                                    $somme_Reglement = Reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($user->id,$nav_societe->id_societe,1); 
                                    
                                    $Reste_fact =$Somme_ttc->somme_ttc - $somme_Reglement->somme ;
                                     ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>?action=fact_achat" method="POST"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row info-TTC" >
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="Remise" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                        
                                                        <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  $Reste_fact; ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                           
                                            <div class="col-md-12 notification-mode-paiement table-responsive">
                                                <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                             <?php  $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($user->id,$nav_societe->id_societe,3);     $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                            <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_fournisseur->solde)) {
                                            echo number_format($Solde_fournisseur->solde,2,"."," ");
                                        } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde_fournisseur->solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                                    <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture[]" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>
                                                                </select>   
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                     
                                </td>
                                <td>
                                    
                                </td>    
                                <td>
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
                                    
                                            </div>

                                            </div>
                                              
                                     
                                    </div>
                                    <div class="modal-footer">
                                    	<button style="float: left;"  class="btn blue" data-toggle="modal" href="#Rfournisseur"> Nouveau Reglement</button>
                                        <button type="button" id="cancel_paiement" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button type="submit" <?php if (empty($table_Reglements)) {echo 'disabled'; } ?>  id="save_paiement"  class="btn green"> CRÉER UN PAIEMENT</button>
                                    </div>
                                     <input type="hidden" id="facture_scan" class="form-control " name="facture_scan" value="<?php if (isset($img_select->id)){  echo $img_select->id;} ?>"    />
                                            <input type="hidden" id="date_facture" class="form-control " name="date_fact" value=""    />
                                            <input type="hidden" id="Reference_facture" class="form-control " name="Reference" value=""    />
                                            <input type="hidden" class="fournisseur" id="fournisseur" name="fournisseur"  value="" />
                                    </form>


                               </div>

<!-- modal versement -->
  <div class="notification-reglement"></div>  
                    <div id="Rfournisseur" class="modal container fade" tabindex="-1">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiment</h4>
                                    </div>
                                    <div class="modal-body">
                                    <form   id="versement_form_f"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-5">
                                                                                                                                        
                                            
                                                <input type="hidden" class="fournisseur" id="fournisseur" name="id_fournisseur"  value="" />
                                              
                                                <input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">       
                                                        
                                               
                                                <div class="form-group form-md-line-input">
                                                 <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe); ?>    
                                                    <label class="col-md-3 control-label">Mode paiment</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control  "   id="mode_paiment"  name="mode_paiment">
                                                         <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)){ echo $Mode_paiement_societe->id;}  ?>"><?php if(isset($Mode_paiement_societe->type)){ echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>  
                                                                 
                                                    </select> 
                                                    </div>
                                                </div>
                                          <?php if (isset($nav_societe->id_societe)) {
                                                               
                                                                 $Comptes = Compte::trouve_par_societe($nav_societe->id_societe);
                                                                
                                                                
                                                                ?>
                                                    <div class="form-group form-md-line-input mode_paiment ">
                                                    <label class="col-md-3 control-label">Banque</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="banque" id="banque"  placeholder="Choisir" >
                                                    
												                              <?php  foreach ($Comptes as $Compte){
																											$banque = Banque::trouve_par_id($Compte->id_banque);
																											 ?>
																												<option value="<?php if (isset($Compte->id)) {
																													echo $Compte->id;}?>"><?php if (isset($banque->Designation)) {
																													echo $banque->Designation;} ?> </option>
                                                <?php } ?>  
                                                                       
                                                        </select> 
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            
                                            </div>
                                            <div class="col-md-7 ">
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant <span class="required" aria-required="true"> * </span></label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="debit" class="form-control " name="debit"  required placeholder="00.00" />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">référence  <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="reference" class="form-control " name="reference" required placeholder="RG001"  />
                                                        
                                                    </div>                                            
                                                  
                                                   <input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;} ?>">
                                                </div>
                                            </div>
                                              
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de versement</label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>" required>
                                                    </div>                                            
                                                  
                                                </div>

                                            </div> 
                                                   
                                            </div>
                                              
                                     </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button  id="save_versment_f" data-dismiss="modal" class="btn green" > Valider</button>
                                    </div>
                                </div>
     <!-- END modal versement -->                 
<script>

    ////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#mode_paiment', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.mode_paiment').load('ajax/get_mode_paiement.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
/////////////////////////// save versment  ////////////////////////////////

$(document).on('click','button#save_versment_f', function() {

$.ajax({
type: "POST",
url: "ajax/save_versment_f.php",
data: $('#versement_form_f').serialize(),
success: function(message){
$(".notification-reglement").html(message)
},
error: function(){
alert("Error");
}
});

 
}); 
</script>
<script>

////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_fournisseur =$('#id_fournisseur').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var TOTALTTC =$('#TTC').val();
    $(".info-TTC").load('ajax/calcule_timbre.php?avoir_achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});
     $(this).parents('.info-mode_paiment').load('ajax/get_mode_paiement_fact.php?avoir_achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});

});
///////////////////// onchqnge list Paiement fact ///////////////////
$(document).on('change','#list_paiment_facture', function() {
    var id = this.value;
    var TOTALTTC =$('#TTC').val();
    var Reste_fact = parseFloat($('#Reste_fact').val()) || 0;
      $.ajax({
            type:'POST',
            url:'ajax/get_solde_mode_paiement.php',
            dataType: "json",
            data:'action=avoir_achat&id='+id+'&TOTALTTC='+TOTALTTC+'&Reste_fact='+Reste_fact,
            success:function(response){
                    $('#solde').val(parseFloat(response.data.Solde_fournisseur).toFixed(2));   
                    $('#Montant').val(parseFloat(response.data.TOTAL).toFixed(2));   
                    $('#reste').val(parseFloat(response.data.rest).toFixed(2));   
            },
        error: function(){
    alert("Error");
    }
        });
    
});

///////////////////  delete mode paiement //////////////////////////////////////

  $(document).on('click','#delete_row,#cancel_paiement', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).attr('name')|| 0;
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_fournisseur =$('#id_fournisseur').val();
    var TOTALTTC =$('#TTC').val();
    $.ajax({
    type: "GET",
    url: "ajax/deletepaiement.php?achat&delete&id="+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur,
    success: function(message){
    $(".notification-mode-paiement").html(message)},
    error: function(){
    alert("Error");
    }
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?avoir_achat&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});
  }); 

    ////////////// get facture reference when onclick Enregistrer_paiement //////////////////
$(document).on('click','#Enregistrer_paiement', function() {
    var Reference_facture =$('#Reference').val();
    var date_facture = $('#date_fact').val();
    var fournisseur =$('#id_fournisseur').val();
    var TTC = parseFloat($('#TOTALTTC').text());

    $('#Reference_facture').val(Reference_facture);
    $('#date_facture').val(date_facture);
    $('.fournisseur').val(fournisseur);
    $('#TTC').val((TTC).toFixed(2));
}); 
   ////////////// calcul reste mode paiement //////////////////
$(document).on('keyup change','#Montant', function() {
    var solde =parseFloat($('#solde').val());
    var Montant = parseFloat($('#Montant').val());
    var reste = solde - Montant ;

    $('#reste').val((reste).toFixed(2));
});
 //////////////// add_paiement ////////////////////////////
 
$(document).on('click','#add_paiement', function() {
    
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_solde =$('#list_paiment_facture').val()||0;
    var reste = parseFloat($('#Reste_fact').val()) || 0;
    var Montant =$('#Montant').val();
    var TOTALTTC =$('#TTC').val();
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification-mode-paiement").load('ajax/addmodepaiement.php?avoir_achat&date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_solde='+id_solde+'&reste='+reste+'&Montant='+Montant+'&mode_paiment='+mode_paiment,function(){       
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?avoir_achat&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});

});


	$(document).on('change click','#id_lot', function() {
var id = this.value;
$('#qte').focus();
     $('.prix_prod').load('ajax/get_prix_lot.php?id='+id+'&action=achat',function(){       
    });
});
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_fournisseur', function() {
$('#id_article').select2('open');
});
$(document).on('change','#id_article', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
      $('.info-prodact').load('ajax/get_info-prod.php?id='+id+'&action=avoirachat&id_societe='+id_societe,function(){       
    });
});

/*$(document).on('keypress','#prix', function() {
        var _this = $(this); // copy of this object for further usage
        setTimeout(function() {
            $('#id_tva').select2('open');
        },3000);
    });
*/
//focusBanque = function getFocus() {           
 // document.getElementById("n_compte").focus();}
//focusCaisse = function getFocus() {           
 // document.getElementById("n_caisse").focus();}
</script>
<?php if (empty($table_achats)) {?>
   <script>
      $( window ).load(function() {
  $('#id_fournisseur').select2('open');
}); 

</script>
<?php }else { ?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#Enregistrer_paiement").attr("disabled", false);
            $("#Enregistrer_paiement").attr("data-toggle", "modal");
            });   
</script>
<?php } ?>

<script>
$(document).on('click','button#submit', function() {

    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var id_lot =$('#id_lot').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addavoirachat.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&id_lot='+id_lot,function(){       
    });

});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var id_lot =$('#id_lot').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addavoirachat.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&id_lot='+id_lot,function(){       
    });
    }
});
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    $(this).parents('.item-row').find('.HT').removeClass();
    $(this).parents('.item-row').find('.TVA').removeClass();
    $(this).parents('.item-row').find('.TTC').removeClass();
    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteavoirachat.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe,
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });
////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_fact =  $('#id_facture').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
     $('.mode_paiment_facture').load('ajax/get_mode_paiement_facture.php?achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user,function(){       
    });
});
//////////////////////////  valider achat//////////////////



////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'invoce_achat.php?action=fact_achat';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>

    <?php }  else if  ($action=='edit_achat')   { ?>
<div class="notification-paiement"></div>
                      <div id="update-paiment_achat" data-backdrop="static" data-keyboard="false" aria-hidden="false" class="modal container fade" tabindex="-1" style=" margin-top: -122.5px;">
                                    <div class="modal-header">
                                        
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe);
                                      if (isset($_GET['id'])) {
                              $somme_Reglement = Update_reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($id_facture,1);
                                     }
															 $Reste_fact =$Somme_ttc->somme_ttc - $somme_Reglement->somme ;
                                     ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>?action=update_achat" method="POST"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row info-TTC" >
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="Remise" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                        
                                                        <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  number_format($Reste_fact,2,"."," "); ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                           
                                            <div class="col-md-12 notification-mode-paiement table-responsive">
                                                <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                             <?php  if (isset($_GET['id'])) {
                        $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($id_facture,1);
                       }
                           $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                            <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                      
                                      $Reglement =  Reglement_fournisseur::trouve_par_solde_and_facture($table_Reglement->id_solde,$table_Reglement->id_facture,1);


                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_fournisseur->solde)) {
                                         $Solde = $Solde_fournisseur->solde + $Reglement->somme + $Reglement->timbre;
                                            echo number_format($Solde,2,"."," ");
                                        } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                                    <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture[]" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>
                                                                </select>   
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                     
                                </td>
                                <td>
                                    
                                </td>    
                                <td>
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
                                    
                                            </div>

                                            </div>
                                              
                                     
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="cancel_paiement" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button type="submit" <?php if (empty($table_Reglements)) {echo 'disabled'; } ?>  id="save_paiement"  class="btn green"> CRÉER UN PAIEMENT</button>
                                    </div>
                                     				<input type="hidden" id="facture_scan" class="form-control " name="facture_scan" value="<?php if (isset($img_select->id)){  echo $img_select->id;} ?>"    />
                                        <input type="text" id="facture_id" name="id" class="hidden" >
                                        <input type="text" id="Reference_facture" name="Reference" class="hidden" >
                                        <input type="date" id="date_facture" name="date_facture" class="hidden" >
                                        <input type="text" id="fournisseur" name="fournisseur" class="hidden" >
                                    </form>
                                </div>
<script>

    ////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_fournisseur =$('#id_fournisseur').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_facture = $('#id_facture').val();
    var TOTALTTC =$('#TTC').val();
    $(".info-TTC").load('ajax/calcule_timbre.php?achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC+'&id_facture='+id_facture,function(){});
     $(this).parents('.info-mode_paiment').load('ajax/get_mode_paiement_fact.php?achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC+'&id_facture='+id_facture,function(){});

});

///////////////////// onchange list Paiement fact ///////////////////
$(document).on('change','#list_paiment_facture', function() {
    var id = this.value;
    var TOTALTTC =$('#TTC').val();
    var id_facture = $('#id_facture').val();
    var Reste_fact = parseFloat($('#Reste_fact').val()) || 0;
      $.ajax({
            type:'POST',
            url:'ajax/get_solde_mode_paiement.php',
            dataType: "json",
            data:'action=achat&id='+id+'&TOTALTTC='+TOTALTTC+'&Reste_fact='+Reste_fact+'&id_facture='+id_facture,
            success:function(response){
                    $('#solde').val(parseFloat(response.data.Solde_fournisseur).toFixed(2));   
                    $('#Montant').val(parseFloat(response.data.TOTAL).toFixed(2));   
                    $('#reste').val(parseFloat(response.data.rest).toFixed(2));   
            },
        error: function(){
    alert("Error");
    }
        });
    
});

 //////////////// add_paiement ////////////////////////////
 
$(document).on('click','#add_paiement', function() {
    var id_facture = $('#id_facture').val();   
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_solde =$('#list_paiment_facture').val()||0;
    var reste = parseFloat($('#Reste_fact').val()) || 0;
    var Montant =$('#Montant').val();
    var TOTALTTC =$('#TTC').val();
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification-mode-paiement").load('ajax/addmodepaiement.php?achat&date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_solde='+id_solde+'&reste='+reste+'&Montant='+Montant+'&mode_paiment='+mode_paiment+'&id_facture='+id_facture,function(){       
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?achat&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC+'&id_facture='+id_facture,function(){});

});

///////////////////  delete mode paiement //////////////////////////////////////

  $(document).on('click','#delete_row,#cancel_paiement', function() {
    var id_facture = $('#id_facture').val(); 
    $(this).parents('.item-row').fadeOut();
    var id =$(this).attr('name')|| 0;
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_fournisseur =$('#id_fournisseur').val();
    var TOTALTTC =$('#TTC').val();
    $.ajax({
    type: "GET",
    url: "ajax/deletepaiement.php?achat&delete&id="+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&id_facture='+id_facture,
    success: function(message){
    $(".notification-mode-paiement").html(message)},
    error: function(){
    alert("Error");
    }
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?achat&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC+'&id_facture='+id_facture,function(){});
  }); 

     ////////////// calcul reste mode paiement //////////////////
$(document).on('keyup change','#Montant', function() {
    var solde =parseFloat($('#solde').val());
    var Montant = parseFloat($('#Montant').val());
    var reste = solde - Montant ;

    $('#reste').val((reste).toFixed(2));
});
    ////////////// get facture reference when onclick Enregistrer_paiement //////////////////
$(document).on('click','#update_paiement_achat', function() {
    var id = $('#id_facture').val();
    var Reference_facture = $('#Reference').val();
    var date_facture = $('#date_fact').val();
    var fournisseur = $('#id_fournisseur').val();
    var TTC = parseFloat($('#TOTALTTC').text());
    
     $('#TTC').val((TTC).toFixed(2));
      $("#facture_id").attr("value", id);
      $("#Reference_facture").attr("value", Reference_facture);
      $("#date_facture").attr("value", date_facture);
      $("#fournisseur").attr("value", fournisseur);

});

 
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_fournisseur', function() {
$('#id_article').select2('open');
});
$(document).on('change','#id_article', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
      $('.info-prodact').load('ajax/get_info-prod.php?id='+id+'&action=achat&id_societe='+id_societe,function(){       
    });
});

/*$(document).on('keypress','#prix', function() {
        var _this = $(this); // copy of this object for further usage
        setTimeout(function() {
            $('#id_tva').select2('open');
        },3000);
    });
*/
//focusBanque = function getFocus() {           
 // document.getElementById("n_compte").focus();}
//focusCaisse = function getFocus() {           
 // document.getElementById("n_caisse").focus();}
</script>
<?php if (empty($table_achats)) {?>
   <script>
      $( window ).load(function() {
  $('#id_fournisseur').select2('open');
}); 


</script>
<?php }else { ?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#update_paiement_achat").attr("disabled", false);
            $("#update_paiement_achat").attr("data-toggle", "modal");
            });   
</script>
<?php } ?>

<script>
$(document).on('click','button#submit', function() {

    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var Reference =$('#Reference').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/update_achat.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&id_facture='+id_facture+'&Remise='+Remise+'&Reference='+Reference,function(){       
    });
});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var Reference =$('#Reference').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/update_achat.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&id_facture='+id_facture+'&Remise='+Remise+'&Reference='+Reference,function(){       
    });
    }
});
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    $(this).parents('.item-row').find('.HT').removeClass();
    $(this).parents('.item-row').find('.TVA').removeClass();
    $(this).parents('.item-row').find('.TTC').removeClass();
    var id =$(this).val();
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteachat.php?id="+id+"&id_facture="+id_facture+"&action=update_achat",
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });


//////////////////////////  valider achat//////////////////

  $(document).on('click','#valider', function() {
   var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>; 
window.location = 'operation.php?id='+id_facture+'&action=update_achat';
  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>; 
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'operation.php?id='+id_facture+'&action=update_achat';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
    <?php }  else if  ($action=='edit_vente')   { ?>
<div class="notification-paiement"></div>
                      <div id="update-paiment"  data-backdrop="static" data-keyboard="false" aria-hidden="false" class="modal container fade" tabindex="-1" style=" margin-top: -122.5px;">
                                    <div class="modal-header">
                                        
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe);
                                     if (isset($_GET['id'])) {
                              $somme_Reglement = Update_reglement_client::trouve_somme_Reglement_vide_par_admin($id_facture);
                                     } 
                                    
                                    $Reste_fact =$Somme_ttc->somme_ttc - $somme_Reglement->somme ;
                                     ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>?action=update_vente" method="POST"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row info-TTC" >
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="Remise" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?>"      />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                        
                                                        <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  number_format($Reste_fact,2,"."," "); ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                           
                                            <div class="col-md-12 notification-mode-paiement table-responsive">
                                                <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                                        <?php  if (isset($_GET['id'])) {
                        $table_Reglements = Update_reglement_client::trouve_Reglement_vide_par_admin($id_facture);
                       }		    $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                            <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        $Reglement =  Reglement_client::trouve_par_solde_and_facture($table_Reglement->id_solde,$table_Reglement->id_facture);

                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_client= Solde_client::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_client->reference)) {
                                            echo fr_date2($Solde_client->date).' | '.$Solde_client->id;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_client->solde)) {
                                             $Solde = $Solde = $Solde_client->solde + $Reglement->somme + $Reglement->timbre;
                                            echo number_format($Solde,2,"."," ");
                                        } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste =  $Solde  - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                                    <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture[]" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>
                                                                </select>   
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                     
                                </td>
                                <td>
                                    
                                </td>    
                                <td>
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
                                    
                                            </div>

                                            </div>
                                              
                                     
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="cancel_paiement" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button type="submit" <?php if (empty($table_Reglements)) {echo 'disabled'; } ?>  id="save_paiement"  class="btn green"> CRÉER UN PAIEMENT</button>
                                    </div>
                                    <input type="hidden" id="facture_scan"  name="facture_scan" value="<?php if (isset($img_select->id)){  echo $img_select->id;} ?>"    />
                                     <input type="text" id="facture_id" name="id" class="hidden" >
                                     				<input type="hidden" id="ht_fact"  name="ht_fact" value=""    />
                                            <input type="hidden" id="date_facture"  name="date_fact" value=""    />
                                            <input type="hidden" id="Remise_fact"   name="Remise_fact" value=""    />
                                            <input type="hidden" id="client" name="client"  value="" />
                                            <input type="hidden" id="tva_fact" name="tva_fact"  value="" />
                                            <input type="hidden" id="ttc_fact" name="ttc_fact"  value="" />
                                    </form>
                                </div>
<script>

    ////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_client =$('#id_client').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_facture = $('#id_facture').val();
    var TOTALTTC =$('#TTC').val();
    $(".info-TTC").load('ajax/calcule_timbre.php?vente&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC+'&id_facture='+id_facture,function(){});
     $(this).parents('.info-mode_paiment').load('ajax/get_mode_paiement_fact.php?vente&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC+'&id_facture='+id_facture,function(){});

});

///////////////////// onchange list Paiement fact ///////////////////
$(document).on('change','#list_paiment_facture', function() {
    var id = this.value;
    var TOTALTTC =$('#TTC').val();
    var id_facture = $('#id_facture').val();
    var Reste_fact = parseFloat($('#Reste_fact').val()) || 0;
      $.ajax({
            type:'POST',
            url:'ajax/get_solde_mode_paiement.php',
            dataType: "json",
            data:'action=vente&id='+id+'&TOTALTTC='+TOTALTTC+'&Reste_fact='+Reste_fact+'&id_facture='+id_facture,
            success:function(response){
                    $('#solde').val(parseFloat(response.data.Solde_client).toFixed(2));   
                    $('#Montant').val(parseFloat(response.data.TOTAL).toFixed(2));   
                    $('#reste').val(parseFloat(response.data.rest).toFixed(2));   
            },
        error: function(){
    alert("Error");
    }
        });
    
});

    ////////////// get facture info when onclick Enregistrer_paiement //////////////////
$(document).on('click','#update_paiement', function() {
    var Remise_fact =$('#REMISE_ht').text();
    var date_facture = $('#date_fact').val();
    var TOTALTVA = parseFloat($('#TOTALTVA').text());
    var TOTALTTC = parseFloat($('#TOTALTTC').text());
    var date_facture = $('#date_fact').val();
    var client =$('#id_client').val();
    var TOTALHT_R = parseFloat($('#TOTALHT_R').text());

    $('#Remise_fact').val(Remise_fact);
    $('#date_facture').val(date_facture);
    $('#client').val(client);
    $('#ht_fact').val(TOTALHT_R);
    $('#tva_fact').val(TOTALTVA);
    $('#ttc_fact').val(TOTALTTC);
    $('#TTC').val((TOTALTTC).toFixed(2));
    $('#Reste_fact').val((TOTALTTC).toFixed(2));
});

 //////////////// add_paiement ////////////////////////////
 
$(document).on('click','#add_paiement', function() {
    var id_facture = $('#id_facture').val();   
    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_solde =$('#list_paiment_facture').val()||0;
    var reste = parseFloat($('#Reste_fact').val()) || 0;
    var Montant =$('#Montant').val();
    var TOTALTTC =$('#TTC').val();
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification-mode-paiement").load('ajax/addmodepaiement.php?vente&date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_solde='+id_solde+'&reste='+reste+'&Montant='+Montant+'&mode_paiment='+mode_paiment+'&id_facture='+id_facture,function(){       
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?vente&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC+'&id_facture='+id_facture,function(){});

});
///////////////////  delete mode paiement //////////////////////////////////////

  $(document).on('click','#delete_row,#cancel_paiement', function() {
    var id_facture = $('#id_facture').val(); 
    $(this).parents('.item-row').fadeOut();
    var id =$(this).attr('name')|| 0;
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_client =$('#id_client').val();
    var TOTALTTC =$('#TTC').val();
    $.ajax({
    type: "GET",
    url: "ajax/deletepaiement.php?vente&delete&id="+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&id_facture='+id_facture,
    success: function(message){
    $(".notification-mode-paiement").html(message)},
    error: function(){
    alert("Error");
    }
    });
  $(".info-TTC").load('ajax/calcule_timbre.php?vente&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_client='+id_client+'&TOTALTTC='+TOTALTTC+'&id_facture='+id_facture,function(){});
  }); 
   ////////////// calcul reste mode paiement //////////////////
$(document).on('keyup change','#Montant', function() {
    var solde =parseFloat($('#solde').val());
    var Montant = parseFloat($('#Montant').val());
    var reste = solde - Montant ;

    $('#reste').val((reste).toFixed(2));
});





$(document).on('change click','#id_lot', function() {
var id = this.value;
$('#qte').focus();
     $('.prix_prod').load('ajax/get_prix_lot.php?id='+id+'&action=vente',function(){       
    });
});

focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_client', function() {
$('#id_article').select2('open');
});
$(document).on('change','#id_article', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;

     $('.info-prod').load('ajax/get_article.php?id='+id+'&action=vente',function(){       
    });
     $('.info-prodact').load('ajax/get_info-prod.php?id='+id+'&action=vente&id_societe='+id_societe,function(){       
    });
});

////////////// get facture reference when onclick Enregistrer_paiement //////////////////
$(document).on('click','#update_paiement', function() {
    var id = $('#id_facture').val();
     $('.Reference_facture').load('ajax/get_reference_facture.php?id='+id+'&action=vente',function(){       
    });
      $("#facture_id").attr("value", id);

});
$(document).on('click','#reset_total', function() {
    var TOTALTTC1 = parseFloat($('#TOTALTTC1').val());
    var TOTALTVA1 = parseFloat($('#TOTALTVA1').val());
    var TOTALHT = parseFloat($('#TOTALHT').text());
 
    $('#TOTALTVA').html((TOTALTVA1).toFixed(2));
    $('#TOTALTTC').html((TOTALTTC1).toFixed(2));
    $('#TTC_propose').val((TOTALTTC1).toFixed(2));
    $('#TOTALHT_R').html((TOTALHT).toFixed(2));
    $('#REMISE_ht').val((0).toFixed(2));
    $('#rest_calc_tva').html((0).toFixed(2));
    $('#REMISE_ht').html((0).toFixed(2));
});


$(document).on('keyup','#TTC_propose,#REMISE_ht', function() {

    var totalttc = parseFloat($('#TOTALTTC1').val());
    var total = parseFloat($('#TOTALHT').text());
 			
	var TTC_propose = parseFloat($('#TTC_propose').val())

	var  Ttva =  parseFloat($('#last_tva').val());	


	if(isNaN(Ttva)){Ttva =0;}
	var  calc_tva = Ttva + 1;

  if ( TTC_propose >= 0 ) {
   	    reste_calc = totalttc - TTC_propose ;
	      rest_calc_tva = reste_calc / calc_tva ;  
  }



  var  TOTALHT_R = total - rest_calc_tva;
	    TOTALTVA = TOTALHT_R * Ttva;
	    TOTALTTC = TOTALTVA + TOTALHT_R;
	    $('#TOTALHT').html((total).toFixed(2));
        $('#TOTALHT_R').html((TOTALHT_R).toFixed(2));
       	$('#REMISE_ht').html((rest_calc_tva).toFixed(2));	
        $('#TOTALTVA').html((TOTALTVA).toFixed(2));
        $('#TOTALTTC').html((TOTALTTC).toFixed(2));

 });
</script>
<?php if (empty($table_vantes)) {?>
   <script>
      $( window ).load(function() {
  $('#id_client').select2('open');
}); 

</script>
<?php }else {
$array= array();
                foreach ($table_vantes as  $table_vante) {
                array_push($array, $table_vante->Ttva);} ?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#update_paiement").attr("disabled", false);
            $("#update_paiement").attr("data-toggle", "modal");
            
            <?php 
    if(count(array_unique($array)) === 1) {
                echo '$("#REMISE_ht").attr("disabled", false);
                $("#TTC_propose").attr("disabled", false);'; 
            }else{
                echo '$("#REMISE_ht").attr("disabled", true);
                $("#TTC_propose").attr("disabled", true);'; 
                }
             ?>
            });   
</script>
<?php } ?>

<script>
$(document).on('click','button#submit', function() {
//$("#id_fournisseur").prop("disabled", true);

    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_article =$('#id_article').val();
    var id_lot =$('#id_lot').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var prix_achat =$('#prix_achat').val();
    var Remise =$('#Remise').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/update_vente.php?date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&id_facture='+id_facture+'&Remise='+Remise+'&id_lot='+id_lot+'&prix_achat='+prix_achat,function(){       
    });
});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
    var date_fact =$('#date_fact').val();
    var id_client =$('#id_client').val();
    var id_article =$('#id_article').val();
    var id_lot =$('#id_lot').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var prix_achat =$('#prix_achat').val();
    var Remise =$('#Remise').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/update_vente.php?date_fact='+date_fact+'&id_client='+id_client+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&id_facture='+id_facture+'&Remise='+Remise+'&id_lot='+id_lot+'&prix_achat='+prix_achat,function(){       
    });
    }
});

    $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    $(this).parents('.item-row').find('.HT').removeClass();
    $(this).parents('.item-row').find('.TVA').removeClass();
    $(this).parents('.item-row').find('.TTC').removeClass();
    var id =$(this).val();
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deletevente.php?id="+id+"&id_facture="+id_facture+"&action=update_vente",
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
        $('.TTC-proposer').load('ajax/get_ttc.php?id_facture='+id_facture+'&action=update_vente',function(){       
    });
    
    var TTC = parseFloat($('#TOTALTTC1').val());
    $('#TTC_propose').html((TTC).toFixed(2));


  });


//////////////////////////  valider VENTE//////////////////

  $(document).on('click','#valider', function() {
   var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>; 
window.location = 'operation.php?id='+id_facture+'&action=update_vente';
  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>; 
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'operation.php?id='+id_facture+'&action=update_vente';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
    <?php }  else if  ($action=='importation')   { ?>
                      <div id="add-paiment_achat" class="modal container fade" tabindex="-1">
                                                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <form action="<?php echo $_SERVER['PHP_SELF']?>?action=fact_achat" method="POST"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-5">                                                 
                                                <div class="form-group form-md-line-input">
                                                    <label class="col-md-3 control-label">Mode paiement</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control  "   id="mode_paiment_facture"  name="mode_paiment_facture">
                                                        <option value="1" >Chèque</option>
                                                        <option value="2" >Especes</option>              
                                                        <option value="3" >Versement Bancaire</option>                              
                                                        <option value="4" >Virement Bancaire</option>                               
                                                        <option value="5" >Carte de crédit</option>         
                                                        <option value="6" >Billet à ordre</option>     
                                                    </select> 
                                                    </div>
                                                </div>
                                                    <div class="mode_paiment_facture">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-7 ">
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Remise <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="Remise" class="form-control " name="Remise" value="0.00"  placeholder="00.00"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Référence <span class="required" aria-required="true"> * </span></label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="Reference" class="form-control " name="Reference" placeholder="FACT0001/21"    />
                                                        
                                                    </div>                                            
                                                  
                                                   
                                                </div>
                                            </div>
                                            </div> 
                                                   
                                            </div>
                                              
                                     
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button type="submit" id="save_paiement"  class="btn green"> CRÉER UN PAIEMENT</button>
                                    </div>
                                    </form>
                                </div>
   <script>
	////////////////////////////////// onchange doane ///////////////////////////

$(document).on('change','#Frais_annexe', function() {
    var id = this.value;
	var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.valeur_DA').load('ajax/douane.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>                                
<script>
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_fournisseur', function() {
$('#shipping').focus();
});

$(document).on('change','#id_article', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
      $('.info-prodact').load('ajax/get_info-prod.php?id='+id+'&action=importation&id_societe='+id_societe,function(){       
    });
});

/*$(document).on('keypress','#prix', function() {
        var _this = $(this); // copy of this object for further usage
        setTimeout(function() {
            $('#id_tva').select2('open');
        },3000);
    });
*/
//focusBanque = function getFocus() {           
 // document.getElementById("n_compte").focus();}
//focusCaisse = function getFocus() {           
 // document.getElementById("n_caisse").focus();}
</script>
<?php if (empty($table_achats)) {?>
   <script>
 /*     $( window ).load(function() {
  $('#id_fournisseur').select2('open');
}); 
*/
</script>
<?php }else { ?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#id_fournisseur").attr("readonly","readonly");
            $("#Enregistrer_paiement").attr("disabled", false);
            $("#Enregistrer_paiement").attr("data-toggle", "modal");
            });   
</script>
<?php } ?>

<script>
$(document).on('click','button#submit_frais', function() {
    var Frais_annexe =$('#Frais_annexe').val();
    var date_frais =$('#date_frais').val();
    var N_facture =$('#N_facture').val();
    var M_HT =$('#M_HT').val();
    var M_TVA =$('#M_TVA').val();
    var autre =$('#autre').val();
    var valeur_DA =$('#valeur_DA').val() || 0;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".Frais-annexe").load('ajax/addimportation.php?id_person='+id_user+'&id_societe='+id_societe+'&Frais_annexe='+Frais_annexe+'&date_frais='+date_frais+'&N_facture='+N_facture+'&M_HT='+M_HT+'&M_TVA='+M_TVA+'&autre='+autre+'&valeur_DA='+valeur_DA+'&action=frais',function(){       
    });

});
    
$(document).on('click','button#submit', function() {
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var shipping =$('#shipping').val();
    var Num_facture =$('#Num_facture').val();
     var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addimportation.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&shipping='+shipping+'&Num_facture='+Num_facture+'&action=importation',function(){       
    });

});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var shipping =$('#shipping').val();
    var Num_facture =$('#Num_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/addimportation.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&shipping='+shipping+'&Num_facture='+Num_facture+'&action=importation',function(){       
    });
    }
});
  $(document).on('click','#delete_frais', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteimportation.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe+"&action=frais",
    success: function(message){
    $(".total-frais").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });

  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();

    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteimportation.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe+"&action=importation",
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });
////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_fact =  $('#id_facture').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
     $('.mode_paiment_facture').load('ajax/get_mode_paiement_facture.php?achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user,function(){       
    });
});
//////////////////////////  valider achat//////////////////

  $(document).on('click','#valider', function() {
window.location = 'importation.php?action=fact_importation';
  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'invoce_achat.php?action=fact_achat';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
    <?php }  else if  ($action=='edit_importation')   { ?>
                     
   <script>
	////////////////////////////////// onchange doane ///////////////////////////

$(document).on('change','#Frais_annexe', function() {
    var id = this.value;
	var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.valeur_DA').load('ajax/douane.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>                                
<script>
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_fournisseur', function() {
$('#shipping').focus();
});

$(document).on('change','#id_article', function() {
    var id = this.value;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
      $('.info-prodact').load('ajax/get_info-prod.php?id='+id+'&action=importation&id_societe='+id_societe,function(){       
    });
});

/*$(document).on('keypress','#prix', function() {
        var _this = $(this); // copy of this object for further usage
        setTimeout(function() {
            $('#id_tva').select2('open');
        },3000);
    });
*/
//focusBanque = function getFocus() {           
 // document.getElementById("n_compte").focus();}
//focusCaisse = function getFocus() {           
 // document.getElementById("n_caisse").focus();}
</script>
<?php if (empty($table_achats)) {?>
   <script>
 /*     $( window ).load(function() {
  $('#id_fournisseur').select2('open');
}); 
*/
</script>
<?php }else { ?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#Enregistrer_paiement").attr("disabled", false);
            $("#Enregistrer_paiement").attr("data-toggle", "modal");
            });   
</script>
<?php } ?>

<script>
$(document).on('click','#submit_frais', function() {
    var Frais_annexe =$('#Frais_annexe').val();
    var date_frais =$('#date_frais').val();
    var N_facture =$('#N_facture').val();
    var M_HT =$('#M_HT').val();
    var M_TVA =$('#M_TVA').val();
    var autre =$('#autre').val();
    var valeur_DA =$('#valeur_DA').val() || 0;
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".Frais-annexe").load('ajax/update_importation.php?id_person='+id_user+'&id_societe='+id_societe+'&Frais_annexe='+Frais_annexe+'&date_frais='+date_frais+'&N_facture='+N_facture+'&M_HT='+M_HT+'&M_TVA='+M_TVA+'&autre='+autre+'&valeur_DA='+valeur_DA+'&id_facture='+id_facture+'&action=frais',function(){       
    });
 $('.notification').load('ajax/calcule_importation.php?id_facture='+id_facture+'&action=update_importation',function(){       
    });

});
    
$(document).on('click','#submit', function() {
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    var shipping =$('#shipping').val();
    var Num_facture =$('#Num_facture').val();
     var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/update_importation.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&shipping='+shipping+'&Num_facture='+Num_facture+'&id_facture='+id_facture+'&action=importation',function(){       
    });

});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
   var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_article =$('#id_article').val();
    var qte =$('#qte').val();
    var prix =$('#prix').val();
    var Remise =$('#Remise').val();
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    var shipping =$('#shipping').val();
    var Num_facture =$('#Num_facture').val();
     var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification").load('ajax/update_importation.php?date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_prod='+id_article+'&prix='+prix+'&qte='+qte+'&Remise='+Remise+'&shipping='+shipping+'&Num_facture='+Num_facture+'&id_facture='+id_facture+'&action=importation',function(){       
    });
    }
});
  $(document).on('click','#delete_frais', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).val();
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteimportation.php?id="+id+"&id_facture="+id_facture+"&action=update_frais_importation",
    success: function(message){
    $(".total-frais").html(message)},
    error: function(){
    alert("Error");
    }
    });
    $('.notification').load('ajax/calcule_importation.php?id_facture='+id_facture+'&action=update_importation',function(){       
    });
  });

  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();

    var id =$(this).val();
    var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteimportation.php?id="+id+"&id_facture="+id_facture+"&action=update_importation",
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
     $('.notification').load('ajax/calcule_importation.php?id_facture='+id_facture+'&action=update_importation',function(){       
    });
  });

//////////////////////////  valider achat//////////////////

  $(document).on('click','#valider', function() {

var date_fact = $('#date_fact').val();
var id_fournisseur = $('#id_fournisseur').val();
var shipping = $('#shipping').val();
var Num_facture = $('#Num_facture').val();
var id_facture = <?php if (isset($id_facture)) {echo $id_facture;}  ?>;

var form = $('<form method="POST" action="importation.php?action=update_importation"></form>');
form.append($('<input type="hidden" name="date_fact">').val(date_fact));
form.append($('<input type="hidden" name="fournisseur">').val(id_fournisseur));
form.append($('<input type="hidden" name="shipping">').val(shipping));
form.append($('<input type="hidden" name="Num_facture">').val(Num_facture));
form.append($('<input type="hidden" name="id">').val(id_facture));
$('body').append(form);
form.submit();
  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'invoce_achat.php?action=fact_achat';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
    <?php } ?>
	<?php   if  ($action=='list_client')   { ?>
 <script>
  $(document).on('click','#delete_client', function() {   
		var id = this.value;
		
  $.ajax({
            type:'POST',
            url:'ajax/delete_client.php',
            dataType: "json",
            data:'id='+id,
            success:function(response){
              if(response.status == 'ok'){
                $(".client_" + id).parents('.item-row3').fadeOut();
                     toastr.success(response.msg,"Très bien !");    
              }else{
                toastr.error(response.msg,"Attention !");
              }
 
            },
        error: function(){
    alert("Error");
    }
        });

  });
  </script>
	<?php }?>
	<?php if  ($action=='list_fournisseur')   { ?>
   <script>
  $(document).on('click','#delete_fournisseur', function() {   
		var id = this.value;


       $.ajax({
            type:'POST',
            url:'ajax/delete_fournisseur.php',
            dataType: "json",
            data:'id='+id,
            success:function(response){
              if(response.status == 'ok'){
                $(".fournisseur_" + id).parents('.item-row').fadeOut();
                     toastr.success(response.msg,"Très bien !");    
              }else{
                toastr.error(response.msg,"Attention !");
              }
 
            },
        error: function(){
    alert("Error");
    }
        });

  });
  </script>
  <?php }?>

  <?php if ($action =='releve_comptes'){ ?>
  <script>
/////////////////////////// SAVE  ////////////////////////////////

$(document).on('click','#save_releve', function() {
	 $(this).parents('.item-row').show();
    var date =$('#date').val();
    var ref_releve =encodeURIComponent($('#ref_releve').val());
    var id_banque =$('#id_banque').val();
	var id_caisse =$('#id_caisse').val();
    var libelle =encodeURIComponent($('#libelle').val());
    var somme_debit =$('#somme_debit').val();
    var somme_credit =$('#somme_credit').val();
    var id_nature =$('#id_nature').val();
    var id_facture =$('#id_facture').val();
	var id_tier =$('#id_tier').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
	var date_valid =$('#date_valid').val();
    var id_societe = $('#id_societe').val();
    var mode_paiment = $('#mode_paiment').val();
$(".notification").load('ajax/save_releve.php?date='+date+'&date_valid='+date_valid+'&ref_releve='+ref_releve+'&id_user='+id_user+'&id_societe='+id_societe+'&id_banque='+id_banque+'&id_caisse='+id_caisse+'&somme_credit='+somme_credit+'&somme_debit='+somme_debit+'&id_facture='+id_facture+'&id_tier='+id_tier+'&libelle='+libelle+'&id_nature='+id_nature+'&mode_paiment='+mode_paiment,function(){       
    });
 
});
 

</script>
<?php }  if ($action =='add_fact_depense'){ ?>

<div class="notification-paiement"></div>
                      <div id="add-depense"  data-backdrop="static" data-keyboard="false" aria-hidden="false" class="modal container fade" tabindex="-1" style=" margin-top: -122.5px;">
                                    <div class="modal-header">
                                        
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                   <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe);

                                    $somme_Reglement = Reglement_fournisseur::trouve_somme_Reglement_vide_par_admin($user->id,$nav_societe->id_societe,2); 
                                    
                                    $Reste_fact = $Somme_ttc->somme_ttc - $somme_Reglement->somme ;
                                     ?>
                                    <form id="depense_form"   class="form-horizontal" enctype="multipart/form-data">
                                         <div class="row info-TTC" >
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">TTC <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="TTC"  readonly class="form-control " name="Remise"       />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Reste <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group ">
                                                        
                                                        <input type="text" id="Reste_fact" readonly class="form-control " name="Remise" value="<?php  echo  number_format($Reste_fact,2,"."," "); ?>"    />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                           
                                            <div class="col-md-12 notification-mode-paiement table-responsive">
                                                <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                             <?php  $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($user->id,$nav_societe->id_societe,2);     $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                            <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_fournisseur->solde)) {
                                            echo number_format($Solde_fournisseur->solde,2,"."," ");
                                        } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde_fournisseur->solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                                    <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture[]" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>
                                                                </select>   
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                     
                                </td>
                                <td>
                                    
                                </td>    
                                <td>
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
                                    
                                            </div>

                                            </div>
                                        <input type="hidden" id="facture_scan" class="form-control " name="facture_scan" value="<?php if (isset($img_select->id)){  echo $img_select->id;} ?>"    />
                                            <input type="hidden" id="date_dep" class="form-control " name="date_fact" value=""    />
                                            <input type="hidden" id="Reference_dep" class="form-control " name="reference" value=""    />
                                            <input type="hidden" id="ht_dep" class="form-control " name="ht" value=""    />
                                            <input type="hidden" id="tva_dep" class="form-control " name="tva" value=""    />
                                            <input type="hidden" id="timbre_dep" class="form-control " name="timbre" value=""    />
                                            <input type="hidden" class="fournisseur" id="fournisseur" name="id_fournisseur"  value="" /> 
                                            <input type="hidden"  id="depense" name="id_depense"  value="" />     
                                            <input type="hidden"  id="ttc_dep" name="ttc"  value="" />     
                                     
                                    </div>
                                    </form>
                                    <div class="modal-footer">
                                    	<button style="float: left;"  class="btn blue" data-toggle="modal" href="#Rfour"> Nouveau Reglement</button>
                                        <button type="button" id="cancel_paiement" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button data-dismiss="modal"  id="save_paiement" <?php if (empty($table_Reglements)) {echo 'disabled'; } ?> class="btn green"> CRÉER UN PAIEMENT</button>
                                    </div>
                                     
                                    
                                </div>
<div class="notification-reglement"></div>
<div id="Rfour" class="modal container fade" tabindex="-1">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title"> <i class="fa fa-credit-card"></i>  Paiement</h4> 
                                    </div>
                                    <div class="modal-body">
                                    <form   id="versement_form_f"  class="form-horizontal" enctype="multipart/form-data">
                                        <div class="row">
                                        <div class="col-md-5">
                                            <input type="hidden" class="fournisseur" id="fournisseur" name="id_fournisseur"  value="" />
                                                      
                                                <input type="hidden" name="id_user" value="<?php if(isset($user->id)){echo $user->id; } ?>">       
                                                        
                                               
                                               <div class="form-group form-md-line-input">
                                                 <?php $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe); ?>    
                                                    <label class="col-md-3 control-label">Mode paiment</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control  "   id="mode_paiment"  name="mode_paiment">
                                                         <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)){ echo $Mode_paiement_societe->id;}  ?>"><?php if(isset($Mode_paiement_societe->type)){ echo $Mode_paiement_societe->type;} ?></option>
                                                        <?php } ?>  
                                                                 
                                                    </select> 
                                                    </div>
                                                </div>
                                           <?php if (isset($nav_societe->id_societe)) {
                                                                $Comptes = Compte::trouve_par_societe($nav_societe->id_societe);
                                                                
                                                                
                                                                ?>
                                                    <div class="form-group form-md-line-input mode_paiment ">
                                                    <label class="col-md-3 control-label">Banque</label>
                                                    <div class="col-md-9">
                                                    <select class="form-control "    name="banque" id="banque"  placeholder="Choisir" >
                                                    
                                                            <?php  foreach ($Comptes as $Compte){
                                                            $banque = Banque::trouve_par_id($Compte->id_banque) ?>
                                                                <option  value="<?php if (isset($Compte->id)) {
                                                                    echo $Compte->id;}?>"><?php if (isset($banque->Designation)) {
                                                                    echo $banque->Designation;} ?> </option>
                                                <?php } ?>  
                                                                       
                                                        </select> 
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            </div>
                                            <div class="col-md-7 ">
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Montant <span class="required" aria-required="true"> * </span> </label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="number" id="debit" class="form-control " name="debit"  placeholder="00.00" required   />
                                                        <span class="input-group-addon">
                                                            DA
                                                        </span>
                                                    </div>                                            
                                                  
                                                </div>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">référence <span class="required" aria-required="true"> * </span></label>
                                                <div class="col-md-8 ">                                            
                                                    <div class="input-group">
                                                        
                                                        <input type="text" id="reference" class="form-control " name="reference" placeholder="RG0001" required   />
                                                        
                                                    </div>                                            
                                                  
                                                   <input type="hidden" name="id_societe" value="<?php if(isset($nav_societe->id_societe)){echo $nav_societe->id_societe;} ?>">
                                                </div>
                                            </div>
                                              
                                             <div class="form-group form-md-line-input">
                                                <label class="col-md-4 control-label">Date de versement</label>
                                                <div class="col-md-8">                                            
                                                       <input type="date" name = "date" class="form-control" placeholder="Date " value="<?php echo   $thisday;?>" required>
                                                    </div>                                            
                                                  
                                                </div>

                                            </div> 
                                                   
                                            </div>
                                              
                                     </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">ANNULER</button>
                                        <button  id="save_versment_f" data-dismiss="modal" class="btn green" > Valider</button>
                                    </div>
                                </div>                             


	<script>

    ////////////////////////////////// onchange mode  Paiement ///////////////////////////

$(document).on('change','#mode_paiment', function() {
    var id = this.value;
   var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
     $('.mode_paiment').load('ajax/get_mode_paiement.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});
/////////////////////////// save versment  ////////////////////////////////

$(document).on('click','button#save_versment_f', function() {

$.ajax({
type: "POST",
url: "ajax/save_versment_f.php",
data: $('#versement_form_f').serialize(),
success: function(message){
$(".notification-reglement").html(message)
},
error: function(){
alert("Error");
}
});
}); 

////////////////////////////////// onchange mode  Paiement facure ///////////////////////////

$(document).on('change','#mode_paiment_facture', function() {
    var id = this.value;
    var id_fournisseur =$('#id_fournisseur').val();
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var TOTALTTC =$('#TTC').val();
    $(".info-TTC").load('ajax/calcule_timbre.php?depence&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});
     $(this).parents('.info-mode_paiment').load('ajax/get_mode_paiement_fact.php?achat&id='+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});

});
///////////////////// onchqnge list Paiement fact ///////////////////
$(document).on('change','#list_paiment_facture', function() {
    var id = this.value;
    var TOTALTTC =$('#TTC').val();
    var Reste_fact = parseFloat($('#Reste_fact').val()) || 0;
      $.ajax({
            type:'POST',
            url:'ajax/get_solde_mode_paiement.php',
            dataType: "json",
            data:'action=achat&id='+id+'&TOTALTTC='+TOTALTTC+'&Reste_fact='+Reste_fact,
            success:function(response){
                    $('#solde').val(parseFloat(response.data.Solde_fournisseur).toFixed(2));   
                    $('#Montant').val(parseFloat(response.data.TOTAL).toFixed(2));   
                    $('#reste').val(parseFloat(response.data.rest).toFixed(2));   
            },
        error: function(){
    alert("Error");
    }
        });
    
});

 //////////////// add_paiement ////////////////////////////
 
$(document).on('click','#add_paiement', function() {
    
    var date_fact =$('#date_fact').val();
    var id_fournisseur =$('#id_fournisseur').val();
    var id_solde =$('#list_paiment_facture').val()||0;
    var reste = parseFloat($('#Reste_fact').val()) || 0;
    var Montant =$('#Montant').val();
    var TOTALTTC =$('#TTC').val();
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
$(".notification-mode-paiement").load('ajax/addmodepaiement.php?depence&date_fact='+date_fact+'&id_fournisseur='+id_fournisseur+'&id_person='+id_user+'&id_societe='+id_societe+'&id_solde='+id_solde+'&reste='+reste+'&Montant='+Montant+'&mode_paiment='+mode_paiment,function(){       
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?depence&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});

});

   ////////////// calcul reste mode paiement //////////////////
$(document).on('keyup change','#Montant', function() {
    var solde =parseFloat($('#solde').val());
    var Montant = parseFloat($('#Montant').val());
    var reste = solde - Montant ;

    $('#reste').val((reste).toFixed(2));
});
///////////////////  delete mode paiement //////////////////////////////////////

  $(document).on('click','#delete_row,#cancel_paiement', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).attr('name')|| 0;
    var mode_paiment =$('#mode_paiment_facture').val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    var id_fournisseur =$('#id_fournisseur').val();
    var TOTALTTC =$('#TTC').val();
    $.ajax({
    type: "GET",
    url: "ajax/deletepaiement.php?depence&delete&id="+id+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur,
    success: function(message){
    $(".notification-mode-paiement").html(message)},
    error: function(){
    alert("Error");
    }
    });
    $(".info-TTC").load('ajax/calcule_timbre.php?depence&id='+mode_paiment+'&id_societe='+id_societe+'&id_user='+id_user+'&id_fournisseur='+id_fournisseur+'&TOTALTTC='+TOTALTTC,function(){});
  }); 

    ////////////// get facture info when onclick Enregistrer_depence //////////////////
$(document).on('click','#Enregistrer_depence', function() {
    var Reference_facture =$('#reference').val();
    var date_facture = $('#date_fact').val();
    var fournisseur =$('#id_fournisseur').val();
	  var id_depense =$('#id_depense').val();
    var ht_dep = parseFloat($('#ht').val())||0;
    var tva = parseFloat($('#tva').val())||0;
    var timbre = parseFloat($('#timbre').val())||0;
    var TTC = parseFloat($('#ttc_depence').val())||0;

    $('#Reference_dep').val(Reference_facture);
    $('#date_dep').val(date_facture);
    $('#depense').val(id_depense);
    $('.fournisseur').val(fournisseur);
    $('#ht_dep').val((ht_dep).toFixed(2));
    $('#tva_dep').val((tva).toFixed(2));
    $('#timbre_dep').val((timbre).toFixed(2));
    $('#TTC').val((TTC).toFixed(2));
    $('#ttc_dep').val((TTC).toFixed(2));
}); 
		/////////////////////////// save DEPENSE  ////////////////////////////////

$(document).on('click','#save_paiement', function() {
 
$.ajax({
type: "POST",
url: "ajax/save_depense.php",
data: $('#depense_form').serialize(),
success: function(message){
$(".notification").html(message)
},
error: function(){
alert("Error");
}
});
 $('.display_depense').load('ajax/display_depense.php',function(){       
    });
 
}); 

$(document).ready(function(){
 
	
$("#fact_depense").on('input', '.depense', function () {
       var total_sum_depense = 0;
     
       $("#fact_depense .depense").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              total_sum_depense += parseFloat(get_textbox_value);
              }                  
            });
              $("#ttc_depence").val(total_sum_depense);
			 
			  
       });

});
	</script>
	<?php } ?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>