<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 // $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $produits = Produit::trouve_par_id($id);

 
		?>
						<div class="form-group" style=" padding-top: 10px;margin-bottom: 20px; margin: 0 -15px 20px -15px;">
									<label for="" class="col-md-3 control-label">Formule <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-8">
										<?php 
								if(!empty($produits->id_pro))	{						
								$formules = Formule::trouve_formule_par_id($produits->id_pro); ?>
                                     <select class="form-control select2me"   id="id_formule"  name="formule" required>
									 <option value=""></option>
										<?php 
								foreach($formules as $formule){?>
														
									<option value = "<?php echo $formule->id ?>" > <?php echo $formule->designation ?></option>
														
								<?php }?>															   
									</select> 
								<?php } ?>
									</div>				
                         			</div>				
				
	<script type="text/javascript">
            $(document).ready(function(){
		 $('#id_formule').select2('destroy');
		 $('#id_formule').select2();
		 $('#id_formule').select2('open');
            });


            </script> 				
			
													
	<?php } ?>	
 

  