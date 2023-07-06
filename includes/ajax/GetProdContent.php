<?php
require_once("../includes/initialiser.php");
$cpt=0;
if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 $produit = Produit::trouve_par_id($id);
 $Lot_prods= Lot_prod::trouve_lot_par_produit($id);
}else{
        echo 'Content not found....';
}


?>
                        <div class="modal-body">
                                <!-- BEGIN FORM-->                        
                                      <div class="row ">
                                            <div class="col-md-8">
                                        <h2><?php if (isset($produit->Designation)){ echo $produit->Designation ;}?>
                                                                                 <?php if (isset($produit->Designation)){ echo  $produit->code  ;}?></h2>                                
                                                </div>  
                                             <div class="col-md-4">
                                       <?php  if (!empty($produit->img_produit)) {
                                         echo'<a class="pull-right " href="javascript:;"> <img class="thumbnail" src="scan/produit/'.$produit->img_produit.'" alt="64x64" style="width: 94px; height: 94px;" /></a> '; 
                                                 } else { ?>
                                                <a class="pull-right " href="javascript:;">
                                                 <img class="media-object bg-grey" src="assets/image/placeholder.png" alt="64x64" style="width: 94px; height: 94px;">     </a>
                                     <?php }?>
                                                </div>
                                                </div>
                                                          <hr>
                                                <div class="row ">
                                                <div class="tab-content">
                                                <div class="col-md-6">
                                            <p><b>Type d'article : </b><?php if ($produit->is_importation ==1){ echo 'Produit Imporation';}?>
                                                <?php if ($produit->matiere_premiere ==1){ echo ', Matiere Premiere';}?>
                                                <?php if ($produit->is_production ==1){ echo ', Produire';}?></p> 
                                                <p><b>Prix de vente :</b> <?php echo $produit->prix_vente ;?>   DA</p>
                                                <p><b>Quantité en stock  :</b> <?php if (isset($produit->id_pro)) {
                                                                                $stock_prod = Produit::Calcul_stock_par_id($produit->id_pro);
                                                                                if (isset($stock_prod->stock)) {
                                                                                echo $stock_prod->stock;
                                                                                }
                                                                        } ?>    </p>
                                                </div>
                                                <div class="col-md-6">
                                                <p><b>TVA :</b> <?php echo $produit->tva*100 ; echo " %";?></p>
                                                <?php $Unites = Unite::trouve_par_id($produit->id_unite); ?>
                                                <p><b> Unite : </b><?php  echo $Unites->unite ?></p>
                                                <?php $Familles = Famille::trouve_par_id($produit->id_famille); ?>                  
                                                <p><b>Catégorie d'article :</b> <?php echo $Familles->famille ?></p>
                                                                                                                                                                                                                                                   
                                                 </div>                                                        
                                                 </div>  
                                                </div>
                                                <?php if (!empty($Lot_prods)) { ?>
                                
                                <div class="row">
                                        <div class="col-md-8">
                                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                                        <div class="portlet light " style=" margin-bottom: 10px;padding: 12px 20px 0px 20px;">
                                                
                                                <div class="portlet-title">
                                                        
                                                        <div class="caption  bold">
                                                                Lots</span>
                                                        </div>
                                                </div>
                                                </div>
                                                <div class="portlet-body">
                                                        <div class="table-scrollable">
                                                                <table class="table table-hover">
                                                                <thead>
                                                                <tr>
                                                                        <th>
                                                                                 #
                                                                        </th>
                                                                        <th>
                                                                                 N° facture
                                                                        </th>
                                                                        <th>
                                                                                date
                                                                        </th>
                                                                        <th>
                                                                                 Code
                                                                        </th>
                                                                        <th>
                                                                                 Qte
                                                                        </th>
                                                                        <th>
                                                                                 P.U
                                                                        </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php foreach($Lot_prods as $Lot_prod){ $cpt++; ?>
                                                                <tr>
                                                                        <td>
                                                                                 <?php echo $cpt; ?>
                                                                        </td>
                                                                        <td>
                                                                                 <?php if (isset($Lot_prod->type_achat) && ($Lot_prod->type_achat == 2)) {
                                                                        $facture= Facture_importation::trouve_par_id($Lot_prod->id_facture);
                                                                                        ?>
                                                                 <a href="invoice_importation.php?id=<?php echo $facture->id_facture; ?>" class="">
                                                                <i class="fa fa-file-text-o bg-yellow"></i>
                                                                        <b><?php if (isset($facture->N_facture)) {
                                                                                $date = date_parse($facture->date_fac);
                                                                        echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?></b> </a>
                                                                             <?php     }else if (isset($Lot_prod->type_achat) && ($Lot_prod->type_achat == 1)) {
                                                                                 $facture= Facture_achat::trouve_par_id($Lot_prod->id_facture);?>
                                                                <a href="invoice_achat.php?id=<?php echo $facture->id_facture; ?>" class="">
                                                                <i class="fa fa-file-text-o bg-yellow"></i>
                                                                        <b><?php if (isset($facture->N_facture)) {
                                                                                $date = date_parse($facture->date_fac);
                                                                        echo sprintf("%04d", $facture->N_facture).'/'.$date['year']; } ?></b> </a>
                                                                <?php } ?>
                                                                        </td>
                                                                        <td>
                                                                                  <?php if (isset($Lot_prod->code_lot)) {
                                                                                         echo fr_date2($Lot_prod->date_lot);
                                                                                 } ?>
                                                                        </td>
                                                                        <td>
                                                                                  <?php if (isset($Lot_prod->code_lot)) {
                                                                                         echo $Lot_prod->code_lot;
                                                                                 } ?>
                                                                        </td>
                                                                        <td>
                                                                                  <?php if (isset($Lot_prod->qte)) {
                                                                                         echo $Lot_prod->qte;
                                                                                 } ?>
                                                                        </td>
                                                                        <td>
                                                                                <?php if (isset($Lot_prod->prix_vente)) {
                                                                                         echo number_format($Lot_prod->prix_vente,2,'.',' ');
                                                                                 } ?>
                                                                        </td>
                                                                </tr>
                                                        <?php } ?>
                                                                </tbody>
                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                        <!-- END SAMPLE TABLE PORTLET-->
                                </div>
                        <?php } ?>
                                </div>
                                                </div>
                
                                                                
                <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default bg-red btn-sm">Fermer</button>
                <a href="produit.php?action=edit&id=<?php echo $produit->id_pro; ?>" class="btn blue btn-sm">
                    <i class="fa fa-edit "></i> modifier</a>
                </div>