<?php
require_once("../includes/initialiser.php");
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 

		 $id = htmlspecialchars(trim($_GET['id']));
	$Lot_prod = Lot_prod::trouve_par_id($id);
	 }
if (isset($_GET['action'])) {
 $action =  htmlspecialchars($_GET['action']) ;
}
?>

<?php if ($action == 'vente') {?>

	<input type="number" style="width: 110px !important;" min="0" id="prix" value="<?php if(isset($Lot_prod->prix_vente)){echo $Lot_prod->prix_vente; } ?>" class="form-control input-small vente-input price" name="prix" required />
	<input type="hidden" min="0" id="prix_achat" value="<?php if(isset($Lot_prod->prix_achat)){echo $Lot_prod->prix_achat; } ?>" class="form-control input-small vente-input " name="prix_achat" required />

<?php }else if ($action == 'achat') {  ?>
		<input type="number" style="width: 110px !important;" min="0" id="prix" value="<?php if(isset($Lot_prod->prix_achat)){echo $Lot_prod->prix_achat; } ?>" class="form-control input-small vente-input price" name="prix" required />
	<input type="hidden" min="0" id="prix_achat" value="<?php if(isset($Lot_prod->prix_achat)){echo $Lot_prod->prix_achat; } ?>" class="form-control input-small vente-input " name="prix_achat" required />
	<?php } ?>