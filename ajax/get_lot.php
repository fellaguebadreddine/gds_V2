<?php
require_once("../includes/initialiser.php");
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
    $id_societe = htmlspecialchars(trim($_GET['id_societe']));
		 $id = htmlspecialchars(trim($_GET['id']));
	$Produit = Produit::trouve_par_id($id);
	$Lot_prods = Lot_prod::trouve_lot_par_produit($id);
	 }
if (isset($_GET['action'])) {
 $action =  htmlspecialchars($_GET['action']) ;
}
?>
										<?php if ($action == 'vente') {
											if (!empty($Lot_prods)) { ?>
												<select class="form-control  select2me"   id="id_lot"  name="id_lot"   placeholder="Choisir article" >
															<option value=""></option>
                                                        <?php  foreach ($Lot_prods as $Lot_prod) { ?>
                                                                    <option  value="<?php if(isset($Lot_prod->id)){echo $Lot_prod->id; } ?>"><?php if (isset($Lot_prod->id)) {echo 'Qte; '.$Lot_prod->qte;  echo  ' |  ' . $Lot_prod->prix_vente.' DA' ;} ?> </option>
                                                                <?php } ?> 
																											   
												</select>   
										<?php	} ?>



										<?php } ?>

 
        <script type="text/javascript">
            $(document).ready(function(){
                $('#id_lot').select2();
                
            });


            </script>  