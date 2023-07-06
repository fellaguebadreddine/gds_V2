<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $societes= Societe::trouve_par_id($id_societe);
 
 
		?>
							<?php
								if (isset($id)){
									switch ($id) {
										case 1:?>
											<input type="number" name = "somme_credit" id="somme_credit" min="0"  class="form-control "  placeholder="Crédit "   >
											<?php
											break;
										case 2:
										 echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 3:
										echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;

										case 4:
									echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 5:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 6:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 7:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 8:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 9:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 10:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 11:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 12:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 13:
											echo '<input type="number" name = "somme_credit"  class="form-control " placeholder="Crédit " readonly  >';
											break;
											case 14:
											echo '<input type="number" name = "somme_credit" id="somme_credit" min="0"  class="form-control "  placeholder="Crédit "   >';
											break;
											



									}	
								}	?>	
	<?php } ?>	
 

  