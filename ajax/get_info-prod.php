<?php
require_once("../includes/initialiser.php");
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
    $id_societe = htmlspecialchars(trim($_GET['id_societe']));
		 $id = htmlspecialchars(trim($_GET['id']));
	$Produit = Produit::trouve_par_id($id);
    
	
    $Articles_importation = Produit::trouve_produit_importation_par_societe($id_societe); 
    $formule = Formule::trouve_par_id($id);
	 }
if (isset($_GET['action'])) {
 $action =  htmlspecialchars($_GET['action']) ;
}
?>

                    <?php if ($action == 'vente') {
                    $Lot_prods = Lot_prod::trouve_lot_par_produit($id);
                    $Articles = Produit::trouve_produit_vente_par_societe($id_societe);  ?>
                        
                                <td>
                                    <select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
                                                            <option value=""></option>
                                                        <?php  foreach ($Articles as $Article) {
                                                            $stock_prod = Produit::Calcul_stock_par_id($Article->id_pro); ?>
                                                                    <option <?php if ($Produit->id_pro == $Article->id_pro ) {echo 'selected'; } ?> value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$stock_prod->stock ;} ?> </option>
                                                                <?php } ?>                                                         
                                                        </select>   
                                </td>
                                
                                <td >
                                    <?php  if (!empty($Lot_prods)) { ?>
                                                <select class="form-control  select2me"   id="id_lot"  name="id_lot"   placeholder="Choisir article" >
                                                            <option value=""></option>
                                                        <?php  foreach ($Lot_prods as $Lot_prod) { ?>
                                                                    <option  value="<?php if(isset($Lot_prod->id)){echo $Lot_prod->id; } ?>"><?php if (isset($Lot_prod->id)) {echo 'Date: '.fr_date2($Lot_prod->date_lot); echo  ' |  Qte: '.$Lot_prod->qte;  echo  ' |  '. $Lot_prod->prix_vente.' DA' ;} ?> </option>
                                                                <?php } ?> 
                                                                                                               
                                                </select>   
                                        <?php   } else{ ?>

                                    <select class="form-control  select2me"   id="id_lot"  name="id_lot"  disabled>
                                                            <option value="0"></option>
                                    </select>
                                     <?php } ?>
                                </td>
                                <td>
                                     <input type="number" style="width: 90px !important;" min="0" id="qte" class="form-control input-small  vente-input qty" name="qte"   required/>
                                </td>
                                <td class="prix_prod">
                                     <input type="number" style="width: 110px !important;" min="0" id="prix" value="<?php if(isset($Produit->prix_vente)){echo $Produit->prix_vente; } ?>" class="form-control input-small vente-input price" name="prix" required />
                                     <input type="hidden" min="0" id="prix_achat" value="<?php if(isset($Produit->prix_achat)){echo $Produit->prix_achat; } ?>" class="form-control input-small vente-input " name="prix_achat" required />

                                </td>
                                <td>
                                     <input type="number" style="width: 90px !important;" min="0" id="Remise" value="<?php if(isset($Produit->Remise)){echo $Produit->Remise; } ?>" class="form-control input-small vente-input remise" name="Remise" required />
                                    
                                </td>
                                <td>
                                <?php if (isset($Produit->tva)) {
                                        echo ($Produit->tva *100).' %';
                                    } ?>
                                    <input type="text" value="<?php if (isset($Produit->tva)) { echo $Produit->tva ; } ?>"  class="hidden tva_prod">
                                </td >
                                
                                
                                <td class=" HT">
                                    0.00
                                </td>
                                <td class="TVA">
                                    0.00
                                </td>
                                 <td class="TTC">
                                    0.00
                                </td>

                                <td>
                                     <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
                                </td>

                                <?php }else if($action == 'achat') {
                                $Articles = Produit::trouve_produit_achat_par_societe($id_societe);

                                 ?>
                                <td>
                                    <select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
                                        <option value=""></option>
                                             <?php  foreach ($Articles as $Article) { ?>
                                                                    <option <?php if ($Produit->id_pro == $Article->id_pro ) {echo 'selected'; } ?> value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
                                              <?php } ?>                                                         
                                     </select>   
                                </td>
                                
                                
                               <td>
                                     <input type="number"  style="width: 110px !important;" min="0" id="qte" class="form-control input-small  vente-input qty" name="qte"   required/>
                                </td>
                                <td>
                                     <input type="number"  style="width: 110px !important;" min="0" id="prix" value="<?php if(isset($Produit->prix_achat)){echo $Produit->prix_achat; } ?>" class="form-control input-small vente-input price" name="prix" required />
                                </td>
                                <td>
                                     <input type="number" style="width: 110px !important;" min="0" id="Remise" value="<?php if(isset($Produit->Remise)){echo $Produit->Remise; } ?>" class="form-control input-small vente-input remise" name="Remise" required />
                                </td>
                                <td>
                                <?php if (isset($Produit->tva)) {
                                        echo ($Produit->tva *100).' %';
                                    } ?>
                                    <input type="text" value="<?php if (isset($Produit->tva)) { echo $Produit->tva ; } ?>"  class="hidden tva_prod">
                                </td >
                                
                                
                                <td class=" HT">
                                    0.00
                                </td>
                                <td class="TVA">
                                    0.00
                                </td>
                                 <td class="TTC">
                                    0.00
                                </td>

                                <td>
                                     <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
                                </td>
                            <?php }else if($action == 'avoirachat') {
                                $Articles = Produit::trouve_produit_achat_par_societe($id_societe);
                                $Lot_prods = Lot_prod::trouve_lot_par_produit($id);
                                 ?>
                        
                                <td>
                                    <select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
                                                            <option value=""></option>
                                                        <?php  foreach ($Articles as $Article) { 
                                                        $stock_prod = Produit::Calcul_stock_par_id($Article->id_pro); ?>
                                                                    <option <?php if ($Produit->id_pro == $Article->id_pro ) {echo 'selected'; } ?> value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$stock_prod->stock ;} ?> </option>
                                                                <?php } ?>                                                         
                                                        </select>   
                                </td>
                                
                                <td >
                                    <?php  if (!empty($Lot_prods)) { ?>
                                                <select class="form-control  select2me"   id="id_lot"  name="id_lot"   placeholder="Choisir article" >
                                                            <option value=""></option>
                                                        <?php  foreach ($Lot_prods as $Lot_prod) { ?>
                                                                    <option  value="<?php if(isset($Lot_prod->id)){echo $Lot_prod->id; } ?>"><?php if (isset($Lot_prod->id)) {echo 'Date: '.fr_date2($Lot_prod->date_lot); echo  ' |  Qte: '.$Lot_prod->qte;  echo  ' |  '. $Lot_prod->prix_achat.' DA' ;} ?> </option>
                                                                <?php } ?> 
                                                                                                               
                                                </select>   
                                        <?php   } else{ ?>

                                    <select class="form-control  select2me"   id="id_lot"  name="id_lot"  disabled>
                                                            <option value="0"></option>
                                    </select>
                                     <?php } ?>
                                </td>
                                <td>
                                     <input type="number" style="width: 90px !important;" min="0" id="qte" class="form-control input-small  vente-input qty" name="qte"   required/>
                                </td>
                                <td class="prix_prod">
                                    <input type="number"  style="width: 110px !important;" min="0" id="prix" value="<?php if(isset($Produit->prix_achat)){echo $Produit->prix_achat; } ?>" class="form-control input-small vente-input price" name="prix" required />

                                </td>
                                <td>
                                     <input type="number" style="width: 90px !important;" min="0" id="Remise" value="<?php if(isset($Produit->Remise)){echo $Produit->Remise; } ?>" class="form-control input-small vente-input remise" name="Remise" required />
                                    
                                </td>
                                
                                <td>
                                <?php if (isset($Produit->tva)) {
                                        echo ($Produit->tva *100).' %';
                                    } ?>
                                    <input type="text" value="<?php if (isset($Produit->tva)) { echo $Produit->tva ; } ?>"  class="hidden tva_prod">
                                </td >
                                
                                
                                <td class=" HT">
                                    0.00
                                </td>
                                <td class="TVA">
                                    0.00
                                </td>
                                 <td class="TTC">
                                    0.00
                                </td>

                                <td>
                                     <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
                                </td>

                                     <?php }else if($action == 'importation') { ?>
                                     <td>
                                    <select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
                                                            <option value=""></option>
                                                        <?php  foreach ($Articles_importation as $Article_importation) { ?>
                                                                    <option <?php if ($Produit->id_pro == $Article_importation->id_pro ) {echo 'selected'; } ?> value="<?php if(isset($Article_importation->id_pro)){echo $Article_importation->id_pro; } ?>"><?php if (isset($Article_importation->id_pro)) {echo $Article_importation->Designation;  echo  ' |  ' . $Article_importation->code ;} ?> </option>
                                                                <?php } ?>                                                         
                                                        </select>   
                                </td>
                                
                                <td>
                                     <?php if(isset($Produit->code)){echo $Produit->code; } ?>
                                </td>
                               <td>
                                     <input type="number" min="0" id="qte" class="form-control input-xsmall  vente-input qty" name="qte"   required/>
                                </td>
                                <td>
                                     <input type="number" min="0" id="prix" value="0.00" class="form-control input-small vente-input price" name="prix" required />
                                </td>
                                <td>
                                     <input type="number" min="0" id="Remise" value="<?php if(isset($Produit->Remise)){echo $Produit->Remise; } ?>" class="form-control input-xsmall vente-input remise" name="Remise" required />
                                </td>
                                 <td class=" HT">
                                    0.00
                                </td>
                                 <td class="TTC">
                                    0.00
                                </td>
                                <td>
                                     0.00
                                </td>
                                <td></td>
                                <td>
                                     <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
                                </td>
                                    <?php }else if ($action == 'production'){ ?>
				<table class="table table-hover">
                                                        <thead>
                                                         <tr>
                                                                <th>
                                                                 Produit
                                                                </th>
                                                                <th>
                                                                Lot
                                                                </th>
                                                                <th>
                                                                 Qte
                                                                </th>
                                                                <th>
                                                                 P.U
                                                                </th>
                                                                <th>
                                                                Total
                                                                </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $somme_production = 0; 
                                                        $detail_formules = Detail_formule::trouve_detail_par_id_formule($id);
                                                         foreach ($detail_formules as $detail_formule ){
                                                        $prod = Produit::trouve_par_id($detail_formule->id_Matiere_Premiere);
                                                        $lot_prod = Lot_prod::trouve_par_id($detail_formule->id_lot);
                                                        $cout_production = $lot_prod->prix_achat * $detail_formule->qte; ?>
                                                                <tr>
                                                                        <td><?php if (isset($prod->Designation)) {echo $prod->Designation.' | '.$prod->code;} ?></td>
                                                                        <td>
                                                                                <?php if (isset($lot_prod->code_lot)) {echo $lot_prod->code_lot;} ?>
                                                                        </td>
                                                                        <td><?php if (isset($detail_formule->qte)) {echo $detail_formule->qte;} ?></td>
                                                                        <td><?php if (isset($lot_prod->prix_achat)) {echo number_format($lot_prod->prix_achat,2,',',' ');}  ?></td>
                                                                         <td><?php if (isset($cout_production)) {echo number_format($cout_production,2,',',' ');}  ?>  </td>
                                                                        
                                                                </tr>

                                                        <?php  $tolal_production +=  $cout_production ;} ?>
                                                                </tbody>
                                                                                            </table> 
	
					<?php }?>


        <script type="text/javascript">
            $(document).ready(function(){
                $('#id_article').select2();
                $('#id_lot').select2();
<?php if (empty($Lot_prods)) {
    echo " $('#qte').focus();";
} else{
   echo " $('#id_lot').select2('open');";
} ?>
            });
            </script>
  
           