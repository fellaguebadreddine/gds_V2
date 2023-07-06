<?php
require_once("../includes/initialiser.php");

		$errors = array();

if (empty(htmlspecialchars(trim($_POST['id_client'])))) {
	 $errors[]= 'Choisir  Client !';
}
if (empty(htmlspecialchars(trim($_POST['id_prod'])))) {
	 $errors[]= 'Choisir  Article !';

}
else{
$id_prod =htmlspecialchars(trim($_POST['id_prod']));
$produit= Produit::trouve_par_id($id_prod);
}
if (empty(htmlspecialchars(trim($_POST['prix'])))) {
	 $errors[]= 'Champ prix  est vide !';
}


if (empty(htmlspecialchars(trim($_POST['tva'])))) {
	 $errors[]= 'Choisir  tva ! '.htmlspecialchars(trim($_POST['tva']));
}


if (empty(htmlspecialchars(trim($_POST['qte'])))) {
	 $errors[]= 'Champ quantité  est vide !';
}

$Vente = new Vente();
	$Vente->id_client = htmlspecialchars(trim($_POST['id_client']));
	$Vente->id_prod = htmlspecialchars(trim($_POST['id_prod']));
	$Vente->Prix = htmlspecialchars(trim($_POST['prix']));
	$Vente->Ttva = (htmlspecialchars(trim($_POST['tva'])))/100;
	$Vente->Quantite = htmlspecialchars(trim($_POST['qte']) );
	$Vente->id_person = htmlspecialchars(trim(addslashes($_POST['id_person'])));
	$Vente->id_societe = htmlspecialchars(trim(addslashes($_POST['id_societe'])));
	$Vente->Ht = $Vente->Quantite * $Vente->Prix ;
	$Vente->Tva = $Vente->Ht * $Vente->Ttva ;
	$Vente->total = $Vente->Ht + $Vente->Tva ;

	if (isset($produit->Designation)) {
	$Vente->Designation = $produit->Designation;
	}
		if ( $Vente->Quantite > $produit->stock)
	{
		$errors[] = 'Quantité Entrer Supérieur à quantité de stock !! ';
		$errors[] = 'Quantité  de stock  est : '.$produit->stock.' !! ';
	}

	if (empty($errors)){
if ($Vente->existe()) {
	$existe_prod= Vente::trouve_vente_vide_par_id_prod($Vente->id_prod);
	$existe_prod->supprime();
	if ( $Vente->Quantite > $produit->stock)
	{
		$errors[] = 'Quantité Entrer Supérieur à quantité de stock !! ';
		$errors[] = 'Quantité  de stock  est : '.$produit->stock.' !! ';
	}
	if (empty($errors)){

		$Vente->save();
		echo '<script type="text/javascript">
			toastr.info("'. $Vente->Designation .' Modifier avec succes","Très bien !");
			
			$(document).ready(function(){
			$("#formvente .vente-input").val("");
			$("#id_tva").select2("val", "");
			$("#id_article").select2("open");
			$("#id_client").attr("readonly","readonly");;
 			$("#valider").attr("disabled", false);
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
			
			?>
 		<script type="text/javascript">
			toastr.success(" <?php echo $Vente->Designation ; ?> Ajouter avec succes","Très bien !");
			$(document).ready(function(){
			$('#formvente .vente-input').val('');
			$("#id_tva").select2("val", "");
			$('#id_article').select2('open');
			$("#id_client").attr('readonly','readonly');;
 			$("#valider").attr("disabled", false);
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
 $table_vantes = Vente::trouve_vente_vide_par_admin($Vente->id_person,$Vente->id_societe);  
 				$Somme_ht = Vente::somme_ht($Vente->id_person,$Vente->id_societe); 
				$Somme_tva = Vente::somme_tva($Vente->id_person,$Vente->id_societe); 
				$Somme_ttc = Vente::somme_ttc($Vente->id_person,$Vente->id_societe);  ?>


						<table class="table table-striped table-bordered table-hover" >
							<thead>
							<tr>
								<th>
									 N°
								</th>
								<th>
									Article
								</th>
								<th>
									 Quantité 
								</th>
								<th>
									  Prix U 
								</th>
								<th>
									HT
								</th>
								<th>
									TAUX  TVA 
								</th>
								<th>
									 TVA
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
									<?php if (isset($cpt)) {
										echo $cpt;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Designation)) {
										echo $table_vante->Designation;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Quantite)) {
										echo $table_vante->Quantite;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Prix)) {
										echo $table_vante->Prix;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Ht)) {
										echo $table_vante->Ht;
									} ?>
									
								</td>
								<td>
									<?php if (isset($table_vante->Ttva)) {
										echo ($table_vante->Ttva *100).' %';
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->Tva)) {
										echo $table_vante->Tva;
									} ?>
								</td>
								<td>
									<?php if (isset($table_vante->total)) {
										echo $table_vante->total;
									} ?>
								</td>
								<td>
									<button  id="delete" value="<?php if (isset($table_vante->id)){ echo $table_vante->id; } ?>" class="btn red btn-sm"> <i class="fa fa-times"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
						
						
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
