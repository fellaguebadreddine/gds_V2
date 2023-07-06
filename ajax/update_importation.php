<?php
require_once("../includes/initialiser.php");

if ( $_GET['action'] == 'frais') {
	$errors = array();
if (empty(htmlspecialchars(trim($_GET['Frais_annexe'])))) {
	 $errors[]= 'Champ Frais  est vide  !';
}else{
$id_Frais =htmlspecialchars(trim($_GET['Frais_annexe']));
$Frais_annexe= Frais_annexe::trouve_par_id($id_Frais);
}
if (empty(htmlspecialchars(trim($_GET['date_frais'])))) {
	 $errors[]= 'Champ date  est vide !';
}
if (empty(htmlspecialchars(trim($_GET['N_facture'])))) {
	 $errors[]= 'Champ N° facture  est vide !';

}

if (empty(htmlspecialchars(trim($_GET['M_HT'])))) {
	 $errors[]= 'Champ Montant HT  est vide !';
}
if($Frais_annexe->is_douane == 1 && ($_GET['valeur_DA']== 0)){
		$errors[]= 'Champ valeur en DA  est vide !';
}
if (isset($_GET['id_facture'])) {
	 $id_facture = htmlspecialchars(trim($_GET['id_facture']));
}
$id_societe= htmlspecialchars(trim(addslashes($_GET['id_societe']))); 
$Achat = new Update_achat_importation();
	$Achat->id_fournisseur = htmlspecialchars(trim($_GET['Frais_annexe']));
	$Achat->id_prod = htmlspecialchars(trim($_GET['Frais_annexe']));
	if($Frais_annexe->is_douane == 1){
	$Achat->valeur_DA = htmlspecialchars(trim($_GET['valeur_DA']) );
	} else{ 
		$Achat->valeur_DA = 0;
	}
	$Achat->Num_facture = htmlspecialchars(trim($_GET['N_facture']) );
	$Achat->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
	$Achat->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
	$Achat->date_fact = htmlspecialchars(trim(addslashes($_GET['date_frais'])));
	$Achat->id_facture = htmlspecialchars(trim(addslashes($_GET['id_facture'])));
	$Achat->Ht = htmlspecialchars(trim(addslashes($_GET['M_HT'])));
	$Achat->Tva = htmlspecialchars(trim(addslashes($_GET['M_TVA'])));
	$Achat->timbre = htmlspecialchars(trim(addslashes($_GET['autre'])));
	
	$Achat->somme_ht = $Achat->valeur_DA+$Achat->Ht;
	$Achat->total = $Achat->Ht + $Achat->Tva + $Achat->valeur_DA ;
	$Achat->is_frais_annexes = 1;
		if (isset($Frais_annexe->designation)) {
	$Achat->Designation = $Frais_annexe->designation;
	}

	if (empty($errors)){
if ($Achat->existe_frais()) {
	$existe_prod= Update_achat_importation::trouve_frais_vide_par_id_prod($Achat->id_prod,$Achat->id_person);
	if (isset($existe_prod->id)) {
		$existe_prod->supprime();
	}
	

	if (empty($errors)){

		$Achat->save();
		$Update_table = Update_achat_importation::update_table($id_facture);
		echo '<script type="text/javascript">
			toastr.info(" Frais est modifier avec succes","Très bien !");
			
			$(document).ready(function(){
			$(".frais-input").val("");
			$("#Frais_annexe").select2("open");
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
			$Update_table = Update_achat_importation::update_table($id_facture);
			?>
 		<script type="text/javascript">
			toastr.success(" Frais Ajouter avec succes","Très bien !");
			$(document).ready(function(){
			$(".frais-input").val("");
			$("#Frais_annexe").select2("open");
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
				$Frais_annexes = Frais_annexe::trouve_frais_annexe_par_societe($Achat->id_societe);
 				$table_frais = Update_achat_importation::trouve_frais_notvalide_par_facture($id_facture);
				$Somme_ht_frais = Update_achat_importation::somme_ht_frais_par_facture($id_facture,$id_societe);
				$Somme_tva_frais = Update_achat_importation::somme_tva_frais_par_facture($id_facture,$id_societe);
				$Somme_ttc_frais = Update_achat_importation::somme_ttc_frais_par_facture($id_facture,$id_societe); ?>


									<table class="table table-striped table-bordered table-hover" >
							<thead>
							<tr>
								<th width="20%">
									Désignation
								</th>
								<th width="10%">
									 Valeur en DA
								</th>
								<th>
									 Date
								</th>
								<th>
									N° facture
								</th>
								<th>
									 Montant HT 
								</th>
								<th>
									  T.V.A
								</th>
								<th>
									  Timbre
								</th>							
								<th>
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($table_frais as $table_frais){ $cpt ++; ?>
							<tr class="item-row" >
								<td>
									<?php if (isset($table_frais->Designation)) {
										$fourn_service=Fournisseur::trouve_par_id($table_frais->Designation);
										echo $fourn_service->nom;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->valeur_DA)) {
										echo $table_frais->valeur_DA;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->date_fact)) {
										echo $table_frais->date_fact;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->Num_facture)) {
										echo $table_frais->Num_facture;
									} ?>
								</td>
								
								<td>
									<?php if (isset($table_frais->Ht)) {
										echo $table_frais->Ht;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->Tva)) {
										echo $table_frais->Tva;
									} ?>
								</td>
								<td>
									<?php if (isset($table_frais->timbre)) {
										echo $table_frais->timbre;
									} ?>
								</td>
								<td>
									<button  id="delete_frais" value="<?php if (isset($table_frais->id)){ echo $table_frais->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							
								
						
							</tbody>
							<tbody>
								
							<tr  >
								
								<td>
									<select class="form-control  select2me"   id="Frais_annexe"  name="Frais_annexe"   placeholder="Choisir Frais" >
															<option value=""></option>
														<?php  foreach ($Frais_annexes as $Frais_annexe) { ?>
																	<option value="<?php if(!empty($Frais_annexe->id)){echo $Frais_annexe->id; } ?>">
																	<?php if (!empty($Frais_annexe->designation)) { $fourn_service = Fournisseur :: trouve_par_id($Frais_annexe->designation);echo $fourn_service->nom; } ?>
																	</option>
																<?php } ?>														   
														</select>   
								</td>
								<td class="valeur_DA">
									<input type="number" min="0" id="valeur_DA"  class="form-control   "  disabled  name="valeur_DA" required /> 
								</td>
								<td>
									<input type="date" min="0" id="date_frais"  class="form-control  frais-input "   name="date_frais" required /> 
								</td>
								<td>
									<input type="text"  id="N_facture"  class="form-control input-small frais-input "  name="N_facture" required />
								</td>
								<td>
									<input type="number" min="0" id="M_HT"  class="form-control input-small frais-input " value="0.00" name="M_HT" required /> 
								</td>
								<td>
									 <input type="number" min="0" id="M_TVA"  class="form-control input-small frais-input " value="0.00" name="M_TVA" required />
								</td>
								<td>
									 <input type="number" min="0" id="autre"  class="form-control input-small frais-input " value="0.00" name="autre" required />
								</td>
								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit_frais"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total-frais">
								<tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht_frais->somme_ht)){echo $Somme_ht_frais->somme_ht;} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva_frais->somme_tva)){echo $Somme_tva_frais->somme_tva;} else {echo "0.00";}  ?> DA</span></td>
							    </tr>
							    <tr>
									<td colspan="6"><span style="float : right;   font-size: 18px; ;"><strong> TTC : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ttc_frais->somme_ttc)){echo $Somme_ttc_frais->somme_ttc;} else {echo "0.00";}  ?> DA</span></td>
							    </tr>			
                            </tbody>
							</table>
							
        <script type="text/javascript">
            $(document).ready(function(){
                $('#Frais_annexe').select2();
                $("#Frais_annexe").select2("open");
            });


            </script> 
            <?php  
} else {
	$errors = array();
if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
	 $errors[]= 'Choisir  la date !';
}
if (empty(htmlspecialchars(trim($_GET['id_fournisseur'])))) {
	 $errors[]= 'Choisir  Fournisseur !';
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
if (empty(htmlspecialchars(trim($_GET['Num_facture'])))) {
	 $errors[]= 'Champ N Facture  est vide !';
}
if (isset($_GET['id_facture'])) {
	 $id_facture = htmlspecialchars(trim($_GET['id_facture']));
}

$id_person= htmlspecialchars(trim(addslashes($_GET['id_person'])));
$id_societe= htmlspecialchars(trim(addslashes($_GET['id_societe']))); 
$Somme_ht_frais = Update_achat_importation::somme_ht_frais_par_facture($id_facture,$id_societe);
if ($Somme_ht_frais->somme_ht == 0) {
 	 $errors[]= ' Table Frais annexes  est vide !';
 } 


$Achat = new Update_achat_importation();
	$Achat->Prix_devise = htmlspecialchars(trim($_GET['prix']));
	$Achat->id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
	$Achat->Num_facture = htmlspecialchars(trim($_GET['Num_facture']) );
	$Achat->id_facture = htmlspecialchars(trim(addslashes($_GET['id_facture'])));
	$Achat->id_prod = htmlspecialchars(trim($_GET['id_prod']));
			if (isset($produit->id_famille)) {
	$Achat->id_famille = $produit->id_famille;
	}
	$Achat->Remise = htmlspecialchars(trim($_GET['Remise']));
	$Achat->Quantite = htmlspecialchars(trim($_GET['qte']) );
	$Ht_devise = $Achat->Quantite * $Achat->Prix_devise;
	$Achat->id_person = $id_person;
	$Achat->id_societe = $id_societe;
	$Achat->date_fact = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
	$Achat->shipping = htmlspecialchars(trim(addslashes($_GET['shipping'])));
	
	$Achat->Ht_devise =  $Ht_devise - $Achat->Remise ;
	$Achat->total = $Achat->Ht_devise  ;

	if (isset($produit->Designation)) {
	$Achat->Designation = $produit->Designation;
	}
	if (isset($produit->code)) {
	$Achat->Code = $produit->code;
	}




	if (empty($errors)){
if ($Achat->existe()) {
	$existe_prod= Update_achat_importation::trouve_achat_vide_par_id_prod($id_facture,$Achat->id_prod,$Achat->id_person);
	if (isset($existe_prod->id)) {
		$existe_prod->supprime();
	}
	

	if (empty($errors)){

		$Achat->save();
		$Update_table = Update_achat_importation::update_table($id_facture);
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
 			//////////////////////////////////////////////// 
 				$achats = Update_achat_importation::trouve_achat_notvalide_par_facture($id_facture);	
				 	$Somme_ht = Update_achat_importation::somme_ht_par_facture($id_facture);
					$Somme_tva = Update_achat_importation::somme_tva_par_facture($id_facture);
					$Somme_ttc = Update_achat_importation::somme_ttc_par_facture($id_facture);  
				$last_fournisseur = Update_achat_importation::trouve_last_fournisseur_par_id_facture($id_facture); 
			///////////////////////////  somme frais ////////////////////////////////////////////
				$Somme_ht_frais = Update_achat_importation::somme_ht_frais_par_facture($id_facture);
				$Somme_tva_frais = Update_achat_importation::somme_tva_frais_par_facture($id_facture);
				$Somme_ttc_frais = Update_achat_importation::somme_ttc_frais_par_facture($id_facture);
				$total_importation = $Somme_ht->somme_ht+$last_fournisseur->shipping;
	 		//////////////////////////////////////

 			/////////////// update valeur achat et contre valeur en DA /////////////////

 			foreach($achats as $achat){ 
 			  		$achat->Ht = $achat->Ht_devise+( $achat->Ht_devise *($last_fournisseur->shipping/$Somme_ht->somme_ht));
 			  		$achat->Contre_Valeur = $Somme_ht_frais->somme_ht / $total_importation * $achat->Ht ;
 			  		$achat->Prix = $achat->Contre_Valeur / $achat->Quantite ;
 			  		$achat->save();
 			  										} 


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
			$Update_table = Update_achat_importation::update_table($id_facture);

 			//////////////////////////////////////////////// 
 				$achats = Update_achat_importation::trouve_achat_notvalide_par_facture($id_facture);	
				 	$Somme_ht = Update_achat_importation::somme_ht_par_facture($id_facture);
					$Somme_tva = Update_achat_importation::somme_tva_par_facture($id_facture);
					$Somme_ttc = Update_achat_importation::somme_ttc_par_facture($id_facture);  
				$last_fournisseur = Update_achat_importation::trouve_last_fournisseur_par_id_facture($id_facture); 
			///////////////////////////  somme frais ////////////////////////////////////////////
				$Somme_ht_frais = Update_achat_importation::somme_ht_frais_par_facture($id_facture);
				$Somme_tva_frais = Update_achat_importation::somme_tva_frais_par_facture($id_facture);
				$Somme_ttc_frais = Update_achat_importation::somme_ttc_frais_par_facture($id_facture);
				$total_importation = $Somme_ht->somme_ht+$last_fournisseur->shipping;
	 		//////////////////////////////////////

 			/////////////// update valeur achat et contre valeur en DA /////////////////

 			foreach($achats as $achat){ 
 			  		$achat->Ht = $achat->Ht_devise+( $achat->Ht_devise *($last_fournisseur->shipping/$Somme_ht->somme_ht));
 			  		$achat->Contre_Valeur = $Somme_ht_frais->somme_ht / $total_importation * $achat->Ht ;
 			  		$achat->Prix = $achat->Contre_Valeur / $achat->Quantite ;
 			  		$achat->save();
 			  										} 
			
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
						$Articles = Produit::trouve_produit_importation_par_societe($id_societe);
 						$table_achats = Update_achat_importation::trouve_achat_notvalide_par_facture($id_facture);	
					 	$Somme_ht = Update_achat_importation::somme_ht_par_facture($id_facture);
						$Somme_tva = Update_achat_importation::somme_tva_par_facture($id_facture);
						$Somme_ttc = Update_achat_importation::somme_ttc_par_facture($id_facture);  
						$last_fournisseur = Update_achat_importation::trouve_last_fournisseur_par_id_facture($id_facture); 
						$total_importation = $Somme_ht->somme_ht+$last_fournisseur->shipping; 
				?>


						<table class="table table-striped table-bordered table-hover" >
							<thead>
							<tr>
								<th width="30%">
									Désignation
								</th>
								<th>
									Code
								</th>
								<th>
									 Quantité 
								</th>
								<th>
									  Prix U ($)
								</th>
								<th>
									  Remise
								</th>
								<th>
									Valeur achat ($)
								</th>
								<th>
									Valeur achat 
								</th>
								<th>
									Contre valeur 
								</th>
								<th>
									Prix U (DA) 
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
										echo $table_achat->Designation;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Code)) {
										echo $table_achat->Code;
									} ?>
								</td>
								
								<td>
									<?php if (isset($table_achat->Quantite)) {
										echo $table_achat->Quantite;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix_devise)) {
										echo $table_achat->Prix_devise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Remise)) {
										echo $table_achat->Remise;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Ht_devise)) {
										echo $table_achat->Ht_devise;
									} ?>
									
								</td>
								<td>
									<?php if (isset($table_achat->Ht)) {
										echo $table_achat->Ht;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Contre_Valeur)) {
										echo $table_achat->Contre_Valeur;
									} ?>
								</td>
								<td>
									<?php if (isset($table_achat->Prix)) {
										echo $table_achat->Prix;
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
								<td></td>
								<td></td>

								<td>
									 <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody>
							<tbody class="total">
								<tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL ACHAT : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($Somme_ht->somme_ht)){echo $Somme_ht->somme_ht;} else {echo "0.00";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL TVA : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php  if(isset($Somme_tva->somme_tva)){echo $Somme_tva->somme_tva;} else {echo "0.00";}  ?> $</span></td>
							    </tr>
							     <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> SHIPPING : </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"> <?php if (isset($last_fournisseur->shipping)) {echo $last_fournisseur->shipping;  }  else {echo "0.00";}  ?> $</span></td>
							    </tr>
							    <tr>
									<td colspan="8"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL HT: </strong></span></td>
									<td colspan="2"><span style="float : left; font-size: 18px;"><?php  if(isset($total_importation)){echo $total_importation; } else {echo "0.00";}  ?> $</span></td>
							    </tr>

										
                            </tbody>
							</table>
							
        <script type="text/javascript">
            $(document).ready(function(){
                $('#id_article').select2();
                $('#Frais_annexe').select2();
                $("#id_article").select2("open");
            });


            </script> 
<?php } ?>
		