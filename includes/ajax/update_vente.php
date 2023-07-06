<?php
require_once("../includes/initialiser.php");
		$errors = array();
		$array  = array();
if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
	 $errors[]= 'Choisir  la date !';
}
if (empty(htmlspecialchars(trim($_GET['id_client'])))) {
	 $errors[]= 'Choisir  Client !';
}
if (empty(htmlspecialchars(trim($_GET['id_prod'])))) {
	 $errors[]= 'Choisir  Article !';

}
else{
$id_prod =htmlspecialchars(trim($_GET['id_prod']));
$produit= Produit::trouve_par_id($id_prod);
$Lot_prods = Lot_prod::trouve_lot_par_produit($id_prod);

if (!empty($Lot_prods)) {
if (empty(htmlspecialchars(trim($_GET['id_lot'])))) {
	 $errors[]= 'Choisir  lot !';
}	
}
}
if (empty(htmlspecialchars(trim($_GET['prix'])))) {
	 $errors[]= ' Champ prix  est vide !';
}


if (empty(htmlspecialchars(trim($_GET['qte'])))) {
	 $errors[]= 'Champ quantité  est vide !';
}

if (isset($_GET['id_facture'])) {
	 $id_facture = htmlspecialchars(trim($_GET['id_facture']));
}

	$Vente = new Update_Vente();

	$Vente->id_client = htmlspecialchars(trim($_GET['id_client']));
	$Vente->id_prod = htmlspecialchars(trim($_GET['id_prod']));
	$Vente->id_lot = htmlspecialchars(trim($_GET['id_lot']));
	if (!empty($Vente->id_lot)) {
	$Lot_prod = Lot_prod::trouve_par_id($Vente->id_lot);

	}

	$Vente->Prix = htmlspecialchars(trim($_GET['prix']));
	$prix_achat = htmlspecialchars(trim($_GET['prix_achat']));
	$Vente->Remise = htmlspecialchars(trim($_GET['Remise']));
		if (isset($produit->tva)) {
	$Vente->Ttva = $produit->tva;
	$Vente->id_tva = $produit->id_tva;
	}
		if (isset($produit->id_famille)) {
	$Vente->id_famille = $produit->id_famille;
	}	
	$Vente->Quantite = htmlspecialchars(trim($_GET['qte']) );
	$Vente->id_person = htmlspecialchars(trim($_GET['id_person']));
	$Vente->id_societe = htmlspecialchars(trim($_GET['id_societe']));
	$Vente->date_fact = htmlspecialchars(trim($_GET['date_fact']));
	$Vente->id_facture = htmlspecialchars(trim(addslashes($_GET['id_facture'])));
	$Vente->Ht_achat =  $Vente->Quantite * $prix_achat ;
	$Vente->Ht = ($Vente->Quantite * $Vente->Prix) - $Vente->Remise ;
	$Vente->Tva = $Vente->Ht * $Vente->Ttva ;
	$Vente->total = $Vente->Ht + $Vente->Tva ;

	if (isset($produit->Designation)) {
	$Vente->Designation = $produit->Designation;
	}
	if (isset($produit->code)) {
	$Vente->Code = $produit->code;
	}
		if (( $Vente->Quantite > $Lot_prod->qte) && ($produit->stockable == 1))
			
	{
		$errors[] = 'Quantité Entrer Supérieur à quantité de lot !! ';
		$errors[] = 'Quantité  de lot  est : '.$Lot_prod->qte.' !! ';
	}
	if (empty($errors)){
if ($Vente->existe()) {
	$existe_prod= Update_Vente::trouve_vente_vide_par_id_prod($id_facture,$Vente->id_lot,$Vente->id_person);
	if (( $Vente->Quantite > $Lot_prod->qte) && ($produit->stockable == 1))
	{
		$errors[] = 'Quantité Entrer Supérieur à quantité de stock !! ';
		$errors[] = 'Quantité  de stock  est : '.$Lot_prod->qte.' !! ';
	}

	if (isset($existe_prod->id)&& empty($errors)) {
	$existe_prod->supprime();
	}
	if (empty($errors)){

		$Vente->save();
		$Update_table = Update_Vente::update_table($id_facture);
		echo '<script type="text/javascript">
			toastr.info("'. $Vente->Designation .' Modifier avec succes","Très bien !");
			
			$(document).ready(function(){
			$(".vente-input").val("");
			$("#id_tva").select2("val", "");
			$("#id_article").select2("open");
			$("#id_client").attr("readonly",false);
 			$("#update_paiement").attr("disabled", false);
 			});
 			</script>';


	}else{
		 echo '<script type="text/javascript">
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			</script>'; 

	}

			
			
		}else{
			$Vente->save();
			$Update_table = Update_Vente::update_table($id_facture);
			?>
 		<script type="text/javascript">
			toastr.success(" <?php echo $Vente->Designation ; ?> Ajouter avec succes","Très bien !");
			$(document).ready(function(){
			$('.vente-input').val('');
			$("#id_tva").select2("val", "");
			$('#id_article').select2('open');
			$("#id_client").attr('readonly',false);;
 			$("#update_paiement").attr("disabled", false);
 			});

			</script>
<?php
 		 }
 		}else{
 					// errors occurred
        	         echo '<script type="text/javascript">
        	          toastr.error("';
        	         	 foreach ($errors as $msg) {
        	         	echo ' - '.$msg.' <br />';
        	         	 }
			echo '  ","Attention !");
			</script>'; 	  
	}
				$Articles = Produit::trouve_produit_par_societe($Vente->id_societe);
				$Somme_ht = Update_vente::somme_ht($id_facture);
				$Somme_tva = Update_vente::somme_tva($id_facture);
				$Somme_ttc = Update_vente::somme_ttc($id_facture);
				$table_vantes = Update_vente::trouve_vente_notvalide_par_facture($id_facture); 
								if (!empty($table_vantes)) {
					$last_client = Update_vente::trouve_last_client_par_id_facture($id_facture); 
					
					}	

				foreach ($table_vantes as $table_vante) {
    			array_push($array, $table_vante->Ttva);}

				 ?>

						<table class="table table-striped table-bordered table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="30%">
									Désignation
								</th>
								<th>
									Lot
								</th>
								<th>
									 Qté 
								</th>
								<th>
									  PU 
								</th>
								<th>
									 Remise
								</th>
								<th>
									 TVA
								</th>
								<th>
									HT
								</th>
								<th>
									T.TVA 
								</th>
								
								<th>
									TOTAL  
								</th>
								
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_vantes as $table_vante){ $cpt ++; ?>
							<tr class="item-row" >
								
								<td>
									<?php if (isset($table_vante->Designation)) {
										echo $table_vante->Designation.' | '.$table_vante->Code;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->id_lot)) {
										if ($table_vante->id_lot == 0) {
											echo "/";
										}else{
										$lot = $Lot_prod=Lot_prod::trouve_par_id($table_vante->id_lot);
										if (isset($Lot_prod->id)) {
											echo $Lot_prod->code_lot;
										}
										}
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Quantite)) {
										echo $table_vante->Quantite;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Quantite)) { echo $table_vante->Quantite ; } ?>"  class="hidden qty">
								</td>
								<td>
									<?php if (isset($table_vante->Prix)) {
										echo $table_vante->Prix;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Prix)) { echo $table_vante->Prix ; } ?>"  class="hidden price">
								</td>
								<td>
									<?php if (isset($table_vante->Remise)) {
										echo $table_vante->Remise;
									} ?>
									<input type="text" value="<?php if (isset($table_vante->Remise)) { echo $table_vante->Remise ; } ?>"  class="hidden remise">
								</td>
								<td>
									<?php if (isset($table_vante->Ttva)) {
										echo ($table_vante->Ttva *100).' %';
									} ?>
									 <input type="text" value="<?php if (isset($table_vante->Ttva)) { echo $table_vante->Ttva ; } ?>"  class="hidden tva_prod">
								</td>
								<td class="HT">
									<?php if (isset($table_vante->Ht)) {
										echo $table_vante->Ht;
									} ?>
									
								</td>
								
								 <td class="TVA">
									<?php if (isset($table_vante->Tva)) {
										echo $table_vante->Tva;
									} ?>
								</td>
								<td class="TTC">
									<?php if (isset($table_vante->total)) {
										echo $table_vante->total;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_vante->id)){ echo $table_vante->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							<tbody>
								
							<tr class="info-prodact" >
								
								<td>
								<select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
															<option value=""></option>
														<?php  foreach ($Articles as $Article) { ?>
																	<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code.' | Qte: '.$Article->stock  ;} ?> </option>
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
	
								</td>
								
								
								<td>
									
								</td>
								<td>
									
								</td>
								<td>
									

								</td>

								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody> <tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2" id="TOTALHT" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> </td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> REMISE : </strong></span></td>
									<td colspan="2" id="REMISE_ht" style="font-size: 18px;">0.00</td>
							    </tr>

							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT APRES REMISE : </strong></span></td>
									<td colspan="2" id="TOTALHT_R" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> </td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; "><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2" id="TOTALTVA" style= "font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?>
									
									 </td>
							    </tr>
							    <tr>
							    	

									<td colspan="8" ><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2" id="TOTALTTC" style="font-size: 18px;" ><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> 
									 </td>
									 <input type="hidden" id="TOTALTTC1" value="<?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> ">
									 <input type="hidden" id="TOTALTVA1" value="<?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> ">
									 <input id="last_tva" type="hidden" value="<?php echo $last_client->Ttva; ?>">
							    </tr>

										
                          			  </tbody> 
							</table>

						
						<br>
						<div class="TTC-proposer">
							<table class="table table-striped table-bordered table-hover "  >
											<tr   >
												<td colspan="8" width="84.5%" ><span style="float : right;   font-size: 18px; ;"><strong> TTC proposer :  </strong></span></td>
												<td colspan="2" ><input id="TTC_propose" disabled type="number" min="0" value="<?php if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} ?>"  class="form-control input-small " ></td>
											</tr>
							</table>
						</div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#id_article').select2();
                $("#id_article").select2("open");
             	<?php if(count(array_unique($array)) === 1) {
  				echo '$("#REMISE_ht").attr("disabled", false);
  				$("#TTC_propose").attr("disabled", false);'; 
  			}else{
  				echo '$("#REMISE_ht").attr("disabled", true);
  				$("#TTC_propose").attr("disabled", true);'; 
  				} ?>
            });
            
            	$(document).on('keyup change','#table_1 tbody', function() {
		calc();
	});

            </script> 