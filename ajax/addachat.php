<?php
require_once("../includes/initialiser.php");

		$errors = array();
if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
	 $errors[]= 'Choisir  la date !';
}
if (empty(htmlspecialchars(trim($_GET['id_fournisseur'])))) {
	 $errors[]= 'Choisir  Fournisseur !';
}
if (empty(htmlspecialchars(trim($_GET['Reference'])))) {
	 $errors[]= 'Champ Référence  est vide !';
}
if (empty(htmlspecialchars(trim($_GET['id_prod'])))) {
	 $errors[]= 'Choisir  Article !';

}
else{
$id_prod =htmlspecialchars(trim($_GET['id_prod']));
$produit= Produit::trouve_par_id($id_prod);
}
if (empty(htmlspecialchars(trim($_GET['prix'])))) {
	 $errors[]= 'Champ prix  est vide !';
}

if (empty(htmlspecialchars(trim($_GET['qte'])))) {
	 $errors[]= 'Champ quantité  est vide !';
}

$Achat = new Achat();
	$Achat->id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
	$Achat->id_prod = htmlspecialchars(trim($_GET['id_prod']));
	$Achat->Prix = htmlspecialchars(trim($_GET['prix']));
	$Achat->Remise = htmlspecialchars(trim($_GET['Remise']));
		if (isset($produit->tva)) {
	$Achat->Ttva = $produit->tva;
	$Achat->id_tva = $produit->id_tva;
	}
		if (isset($produit->id_famille)) {
	$Achat->id_famille = $produit->id_famille;
	}	
	$Achat->Quantite = htmlspecialchars(trim($_GET['qte']) );
	$Achat->Reference_fact = htmlspecialchars(trim($_GET['Reference']) );
	$Achat->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
	$Achat->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
	$Achat->date_fact = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
	$Achat->Ht = ($Achat->Quantite * $Achat->Prix) - $Achat->Remise ;
	$Achat->Tva = $Achat->Ht * $Achat->Ttva ;
	$Achat->total = $Achat->Ht + $Achat->Tva ;

	if (isset($produit->Designation)) {
	$Achat->Designation = $produit->Designation;
	}
	if (isset($produit->code)) {
	$Achat->Code = $produit->code;
	}

	if (empty($errors)){
if ($Achat->existe()) {
	$existe_prod= Achat::trouve_achat_vide_par_id_prod($Achat->id_prod,$Achat->id_person);
	if (isset($existe_prod->id)) {
		$existe_prod->supprime();
	}
	

	if (empty($errors)){

		$Achat->save();
		echo '<script type="text/javascript">
			toastr.info("'. $Achat->Designation .' Modifier avec succes","Très bien !");
			
			$(document).ready(function(){
			$(".achat-input").val("");
			$("#id_tva").select2("val", "");
			$("#id_article").select2("open");
 			$("#Enregistrer_paiement").attr("disabled", false);
 			$("#Enregistrer_paiement").attr("data-toggle", "modal");
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
			$Achat->save();
			
			?>
 		<script type="text/javascript">
			toastr.success(" <?php echo $Achat->Designation ; ?> Ajouter avec succes","Très bien !");
			$(document).ready(function(){
			$('.achat-input').val('');
			$("#id_tva").select2("val", "");
			$('#id_article').select2('open');
 			$("#Enregistrer_paiement").attr("disabled", false);
 			$("#Enregistrer_paiement").attr("data-toggle", "modal");
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
				$Articles = Produit::trouve_produit_achat_par_societe($Achat->id_societe);
 				$table_achats = Achat::trouve_achat_vide_par_admin($Achat->id_person,$Achat->id_societe);  
 				$Somme_ht = Achat::somme_ht($Achat->id_person,$Achat->id_societe); 
				$Somme_tva = Achat::somme_tva($Achat->id_person,$Achat->id_societe); 
				$Somme_ttc = Achat::somme_ttc($Achat->id_person,$Achat->id_societe);  ?>


						<table class="table table-striped table-bordered table-hover" id="table_1">
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								
								<th>
									 Quantité 
								</th>
								<th>
									  Prix U 
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
									TAUX  TVA 
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
								<?php  $cpt =0; foreach($table_achats as $table_achat){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($table_achat->Designation)) {
										echo $table_achat->Designation.' | '.$table_achat->Code;
									} ?>
								</td>
								
								
								<td>
									<?php if (isset($table_achat->Quantite)) {
										echo $table_achat->Quantite;
									} ?>
									<input type="text" value="<?php if (isset($table_achat->Quantite)) { echo $table_achat->Quantite ; } ?>"  class="hidden qty">
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo $table_achat->Prix;
									} ?>
									<input type="text" value="<?php if (isset($table_achat->Prix)) { echo $table_achat->Prix ; } ?>"  class="hidden price">
								</td>
								<td>
									<?php if (isset($table_achat->Remise)) {
										echo $table_achat->Remise;
									} ?>
									<input type="text" value="<?php if (isset($table_achat->Remise)) { echo $table_achat->Remise ; } ?>"  class="hidden remise">
								</td>
								<td>
									<?php if (isset($table_achat->Ttva)) {
										echo ($table_achat->Ttva *100).' %';
									} ?>
									 <input type="text" value="<?php if (isset($table_achat->Ttva)) { echo $table_achat->Ttva ; } ?>"  class="hidden tva_prod">
								</td>
								<td class=" HT">
									<?php if (isset($table_achat->Ht)) {
										echo $table_achat->Ht;
									} ?>
									
								</td>
								
								<td class="TVA">
									<?php if (isset($table_achat->Tva)) {
										echo $table_achat->Tva;
									} ?>
								</td>
								<td class="TTC">
									<?php if (isset($table_achat->total)) {
										echo $table_achat->total;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_achat->id)){ echo $table_achat->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							<tbody>
								
							<tr class="info-prodact" >
								
								<td>
									<select class="form-control  select2me"   id="id_article"  name="id_prod"   placeholder="Choisir article" >
															<option value=""></option>
														<?php  foreach ($Articles as $Article) { ?>
																	<option value="<?php if(isset($Article->id_pro)){echo $Article->id_pro; } ?>"><?php if (isset($Article->id_pro)) {echo $Article->Designation;  echo  ' |  ' . $Article->code ;} ?> </option>
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
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2" id="TOTALHT" style="font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; "><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2" id="TOTALTVA" style= "font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> DA</td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2" id="TOTALTTC" style="font-size: 18px;" ><?php  if(isset($Somme_ttc->somme_ttc)){echo $Somme_ttc->somme_ttc;} else {echo "0.00";}  ?> DA</td>
							    </tr>
                          	 </tbody>
							</table>
							
        <script type="text/javascript">
            $(document).ready(function(){
                $('#id_article').select2();
                $("#id_article").select2("open");
            });


            </script> 