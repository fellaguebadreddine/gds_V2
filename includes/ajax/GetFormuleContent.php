<?php
require_once("../includes/initialiser.php");
$cpt=0;
$tolal_production =0;
if (isset($_GET['id'])) {
 $id =  htmlspecialchars(intval($_GET['id'])) ;
 $formule = Formule::trouve_par_id($id);
}else{
        echo 'Content not found....';
}


?>



                                <div class="modal-body">
                                        <div class="row">
                                          <div class="col-md-12">
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
                                                                        <td><?php if (isset($lot_prod->prix_achat)) {echo $lot_prod->prix_achat;}  ?></td>
                                                                         <td><?php if (isset($cout_production)) {echo $cout_production;}  ?>  </td>
                                                                        
                                                                </tr>

                                                        <?php  $tolal_production +=  $cout_production ;} ?>
                                                                </tbody>
                                                        <tbody>
                                                                <tr>
                                                                        <td colspan="4"><span style="float : right;   font-size: 18px; ;"><strong> Coût de production : </strong></span></td>
                                                                        <td  style="font-size: 18px;"><?php if (isset($tolal_production)) { echo $tolal_production;} ?> </td>
                                                            </tr>
                                                        </tbody>
                                                                </table>                                                                
                                                                                                                                
                                          </div>
                                        </div>
                                </div>
                                 <div class="modal-footer">
                                        <button class="btn red" data-dismiss="modal" aria-hidden="true">Fermer</button>
                                                                                        
                                </div>



