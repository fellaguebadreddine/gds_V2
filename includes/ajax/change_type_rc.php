<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 if (isset ($_GET['id_client'])){
 $id_client =  htmlspecialchars(($_GET['id_client'])) ;
 $tier=Client::trouve_par_id($id_client);
 }
 if (isset ($_GET['id_fournisseur'])){
 $id_fournisseur =  htmlspecialchars(($_GET['id_fournisseur'])) ;
 $tier=Fournisseur::trouve_par_id($id_fournisseur);
 }
	if ($id==0) {
   
	echo "";       
    }else if ($id==1){ ?>
       
		<label class="col-lg-4 control-label">Numéro du registre commerce (RC): <span class="required" aria-required="true"><em>(3)</em> * </span></label>
			<div class="col-lg-8">
			<div class="input-icon right">
				<i class="fa"></i>	
				<input type="text" class="form-control show-on" name = "Rc" id="mask_rc" value ="<?php if (isset($tier->Rc)){ echo html_entity_decode($tier->Rc); } ?>" required="" >
				<span class="help-block"> Numéro du registre commerce:  16/00-876443B15 </span>
			</div>
			</div>
	<?php  } else if ($id==2){?>

		<label class="col-lg-4 control-label">Agrement: <span class="required" aria-required="true"> * </span></label>
			<div class="col-lg-8">
			<div class="input-icon right">
				<i class="fa"></i>
				<input type="text" name = "Rc"  class="form-control" placeholder="Agrement "  value ="<?php if (isset($tier->Rc)){ echo html_entity_decode($tier->Rc); } ?>" required>
			</div>
			</div>
     <?php   } else if ($id==3){?>
       
		<label class="col-lg-4 control-label">Carte artisan: <span class="required" aria-required="true"> * </span></label>
			<div class="col-lg-8">
			<div class="input-icon right">
				<i class="fa"></i>
				<input type="text" name = "Rc" class="form-control" placeholder="Carte artisan "  value ="<?php if (isset($tier->Rc)){ echo html_entity_decode($tier->Rc); } ?>" required>
			</div>
			</div>
       <?php  } else if ($id==4){?>
      
		<label class="col-lg-4 control-label">Carte fellah: <span class="required" aria-required="true"> * </span></label>
			<div class="col-lg-8">
			<div class="input-icon right">
				<i class="fa"></i>
				<input type="text" name = "Rc" class="form-control" placeholder="Carte fellah "  value ="<?php if (isset($tier->Rc)){ echo html_entity_decode($tier->Rc); } ?>" required>
			</div>
			</div>
        <?php 
	}
	 } ?>	
 

  <script>
  	$(document).ready(function() {
   $("#mask_rc").inputmask("mask", {
            "mask": "99/99-9999999A99"
        }); 
});
  </script>

