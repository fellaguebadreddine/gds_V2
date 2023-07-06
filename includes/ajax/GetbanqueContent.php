<?php
require_once("../includes/initialiser.php");
$banques = Banque::trouve_tous();
?>

								<tr class="item-row">
									<td>
										<select name="id_pro[]"  id="id_banque" class=" form-control select2me" ">
											<?php  foreach ($banques as $banque) { 
												echo'<option value="'.$banque->id_banque.'"> '.addslashes($banque->Designation).' - Code: '.$banque->Code.'</option>';} ?>
													
										</select>
									</td>
									<td>
										<input type="number" name="qte[]" id="n_compte" min="0" class="form-control" >
									</td>
									<td>
										<input  type="number" name="solde_caisse[]" id="qte" min="0" class="form-control" >
									</td>
									<td>
										<a class="btn btn-danger " id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash" ></i></a>
									</td>
								</tr>