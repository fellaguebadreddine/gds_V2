<?php
require_once("../includes/initialiser.php");

		$errors = array();




if (empty(htmlspecialchars(trim($_GET['Journal'])))) {
     $errors[]= 'Choisir Journal !';}
     else{
        $id_Journal = htmlspecialchars(trim($_GET['Journal']));
        $Journal = Journaux::trouve_par_id($id_Journal); 
     }
if (empty(htmlspecialchars(trim($_GET['date'])))) {
	 $errors[]= 'Choisir une date !';
}
if (empty(htmlspecialchars(trim($_GET['ref'])))) {
	 $errors[]= 'Champ Référence est vide !';
}
if (empty(htmlspecialchars(trim($_GET['lib'])))) {
	 $errors[]= 'Champ Libellé est vide !';
}
if (empty(htmlspecialchars(trim($_GET['Debit']))) && empty(htmlspecialchars(trim($_GET['Credit'])))) {
	 $errors[]= 'Champ Début ou Crédit est vide   !';
}

if (  ($_GET['Debit'] == 0 ) and ($_GET['Credit'] == 0 )) {
	 $errors[]= 'Crédit et Début ou Crédit égale à 0 !';
}

if (empty(htmlspecialchars(trim($_GET['id_compte'])))) {
	 $errors[]= 'Choisir  Compte !';
}else{
	$id_compte = htmlspecialchars(trim($_GET['id_compte']));
	$Compte_comp = Compte_comptable::trouve_par_id($id_compte);
}
if (isset($_GET['id_piece'])) {
	 $id_piece = htmlspecialchars(trim($_GET['id_piece']));
}

    $reference = htmlspecialchars(trim($_GET['ref']));
    $libelle = htmlspecialchars(trim($_GET['lib']));
    if (isset($libelle)) {
        $libelle = str_replace("_"," ", $libelle);
    }
    if (isset($reference)) {
        $reference = str_replace("_"," ", $reference);
    }
	$Ecriture_comptable = new Ecriture_comptable();
	$Ecriture_comptable->id_compte = htmlspecialchars(trim($_GET['id_compte']));
	if (isset($Compte_comp->code)) {
	$Ecriture_comptable->code_comptable = $Compte_comp->code;
	}
	if (isset($id_piece)) {
	$Ecriture_comptable->id_piece = $id_piece;
	}
	$Ecriture_comptable->date = htmlspecialchars(trim($_GET['date']));
	$Ecriture_comptable->ref_piece = $reference;
	$Ecriture_comptable->lib_piece = $libelle;
	$Ecriture_comptable->journal = htmlspecialchars(trim($_GET['Journal']) );
	$Ecriture_comptable->id_person = htmlspecialchars(trim($_GET['id_person']));
	$Ecriture_comptable->id_societe = htmlspecialchars(trim($_GET['id_societe']));
	$Ecriture_comptable->id_auxiliere = htmlspecialchars(trim($_GET['auxiliere']));
	$Ecriture_comptable->debit = htmlspecialchars(trim($_GET['Debit']));
	$Ecriture_comptable->credit = htmlspecialchars(trim($_GET['Credit']));
	$Ecriture_comptable->Annexe_Fiscale = htmlspecialchars(trim($_GET['Annexe_Fiscale']));


	if (empty($errors)){
if ($Ecriture_comptable->save()) {
			
			
			?>
 		<script type="text/javascript">
			toastr.success(" <?php echo $Compte_comp->code.' |'.$Compte_comp->libelle ; ?> Ajouter avec succes","Très bien !");
			$(document).ready(function(){
			$('#id_compte').select2('open');
 			$("#Enregistrer_paiement").attr("disabled", false);
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
			$Compte_comptables = Compte_comptable:: trouve_compte_comptable_par_societe($Ecriture_comptable->id_societe);

			if (isset($id_piece)) {

			$Pieces_comptables = Pieces_comptables::trouve_par_id($id_piece);
 			$Ecriture_comptables = Ecriture_comptable::trouve_ecriture_par_piece($id_piece); 
			$somme_debit = Ecriture_comptable::somme_debit_par_piece($id_piece); 
			$somme_credit = Ecriture_comptable::somme_credit_par_piece($id_piece);
			$Pieces_comptables->somme_debit = $somme_debit->somme_debit;  
    		$Pieces_comptables->somme_credit = $somme_credit->somme_credit;  
   			$Pieces_comptables->modifier(); 
			}else {

 			$Ecriture_comptables = Ecriture_comptable::trouve_compte_vide_par_admin($Ecriture_comptable->id_person,$Ecriture_comptable->id_societe); 
 			$somme_debit = Ecriture_comptable::somme_debit($Ecriture_comptable->id_person,$Ecriture_comptable->id_societe); 
			$somme_credit = Ecriture_comptable::somme_credit($Ecriture_comptable->id_person,$Ecriture_comptable->id_societe);

			}
				  ?>

						<table class="table table-striped table-bordered table-hover"  id="table_1">
							<thead>
							<tr>
								
								<th width="35%">
									Compte
								</th>
								<th >
									Date
								</th>

								<th width="10%">
									 Aux 
								</th>
								<th width="10%">
									 Débit
								</th>
								<th width="10%">
									Crédit
								</th>
								<th width="10%">
									Annexe Fiscale
								</th>
								<th>
									Etat
								</th>
								<th >
									#
								</th>
							</tr>
							</thead>
							<tbody>
								<?php  $cpt =0; foreach($Ecriture_comptables as $Ecriture_comptable){ $cpt ++; ?>
							<tr class="item-row" id="<?php if (isset($Ecriture_comptable->id)) {
										echo $Ecriture_comptable->id;
									} ?>">
								
								<td>
									<?php if (isset($Ecriture_comptable->id_compte)) {
										$Compte = Compte_comptable::trouve_par_id($Ecriture_comptable->id_compte);
										if (isset($Compte->id)) {echo $Compte->code;  echo  ' |  ' . $Compte->libelle ;}
									} ?>
								</td>
								<td>
									
									<span class="editSpanDate">
										<?php if (isset($Ecriture_comptable->date)) {
										echo $Ecriture_comptable->date;
									} ?>
									</span>
									<input type="date" name = "Date_ecriture" id="Date_ecriture" min="0"  value="<?php if (isset($Ecriture_comptable->date)) {
										echo $Ecriture_comptable->date;} ?>" class="form-control Date_ecriture " style=" display: none;"  placeholder="Débit "  >
								</td>

								<td>
									
									<?php if (!empty($Ecriture_comptable->id_auxiliere)) {
									 $Auxiliere = Auxiliere::trouve_par_id($Ecriture_comptable->id_auxiliere);
									 if (isset($Auxiliere->libelle)) { echo  $Auxiliere->code.' | '.$Auxiliere->libelle; }
									} else { echo "/"; }?>
									 
								
									 
								</td>
								<td >
									<span class="editSpanDebit">
										<?php if (isset($Ecriture_comptable->debit)) {
										echo number_format($Ecriture_comptable->debit , 2, ',', ' ');
									} ?>
									</span>
									
									<input type="number" name = "Debit" id="debit" min="0"  value="<?php if (isset($Ecriture_comptable->debit)) {
										echo $Ecriture_comptable->debit;} ?>" class="form-control Debit " style=" display: none;"  placeholder="Débit "  >
								</td>
								<td>
									<span class="editSpanCredit">
										<?php if (isset($Ecriture_comptable->credit)) {
										echo number_format($Ecriture_comptable->credit , 2, ',', ' ');
									} ?>
									</span>
									 <input type="number" name = "Credit" id="credit" min="0" value="<?php if (isset($Ecriture_comptable->credit)) {
										echo $Ecriture_comptable->credit;} ?>" class="form-control Credit" style=" display: none;" placeholder="Crédit "   >
								</td>
								 <td>
								 	<span class="editSpanAnnexe_Fiscale">
										<?php if (isset($Ecriture_comptable->Annexe_Fiscale)) {
										echo number_format($Ecriture_comptable->Annexe_Fiscale , 2, ',', ' ');
									} ?>
									</span>
									
									<input type="number" name = "Annexe_Fiscale" id="annexe_Fiscale" min="0"  value="<?php if (isset($Ecriture_comptable->Annexe_Fiscale)) {
										echo $Ecriture_comptable->Annexe_Fiscale;} ?>" class="form-control Annexe_Fiscale " style=" display: none;"  placeholder="Annexe_Fiscale "  >
								 	
								 </td>
								<td class="Etat-ecriture" > 
								<?php  if ($somme_debit->somme_debit == $somme_credit->somme_credit) {
								echo '<span class="font-green"><strong>Équilibré</strong></span>' ;} else { echo '<span class="font-red"><strong>Déséquilibré</strong></span>' ; }  ?>
								</td> 
								 
								<td>
									<button type="button" class="btn  btn-info btn-sm editBtn" style="float: none;"><span class="glyphicon glyphicon-pencil"></span></button>
									  <button type="button" class="btn green-jungle btn-sm saveBtn" style="float: none; display: none;"><i class="fa fa-save"></i></button>
									<button  id="delete"  value="<?php if (isset($Ecriture_comptable->id)){ echo $Ecriture_comptable->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </button>
								</td>
								
							</tr>
						<?php } ?>

							<tbody>
								
							<tr class="info-compte" >
								
								<td>
									<select class="form-control  select2me"   id="id_compte"  name="id_compte"   placeholder="Choisir Compte" >
															<option value=""></option>
														<?php  foreach ($Compte_comptables as $Compte_comptable) { ?>
																	<option value="<?php if(isset($Compte_comptable->id)){echo $Compte_comptable->id; } ?>"><?php if (isset($Compte_comptable->id)) {echo $Compte_comptable->code;  echo  ' |  ' . $Compte_comptable->libelle ;} ?> </option>
																<?php } ?>														   
														</select>   
								</td>
								
								<td>
                                   
                                   
                                </td>

								<td></td>
								<td>
	
								</td>
								<td>
									<input type="hidden" id="ref" value="" >
									<input type="hidden" id="lib" value="">
									<input type="hidden" id="Journal" value=""> 
									<input id="date" type="hidden" value=""  >
								</td>

									<td>
										
									</td>
									<td>
										
									</td>
								<td>
									 <button style="width: 72px;" class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
								</td>
								
							</tr>
							
							</tbody> 
							<tbody class="total">
								<tr>
									<td colspan="3"><span style="float : right;   font-size: 18px; ;"><strong> TOTAL  : </strong></span></td>
									<td colspan="1" id="TOTALdebit" style="font-size: 14px;"><?php  if(isset($somme_debit->somme_debit)){echo  number_format($somme_debit->somme_debit , 2, ',', ' ');} else {echo "0.00";}  ?> </td>
									<td colspan="1" id="TOTALcredit" style="font-size: 14px;"><?php  if(isset($somme_credit->somme_credit)){echo number_format($somme_credit->somme_credit , 2, ',', ' ') ;} else {echo "0.00";}  ?> </td>
									<?php if ($somme_debit->somme_debit > $somme_credit->somme_credit) { $diff = $somme_debit->somme_debit - $somme_credit->somme_credit;  }else { $diff = $somme_credit->somme_credit - $somme_debit->somme_debit; } ?>
									<td>
										
									</td>
									<td colspan="2" id="Diff" >
											<?php if ($diff >0 ) {
												echo "Différence : ".number_format($diff , 2, ',', ' ') ;
											}  ?>
										</td>
							    </tr>
							   

										
                          			  </tbody> 
							</table>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#id_compte').select2();
                $("#id_compte").select2("open");
            });
        </script> 