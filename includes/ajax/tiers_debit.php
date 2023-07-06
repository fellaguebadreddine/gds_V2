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
										case 1:
											echo '<input type="number" name = "somme_credit" min="0"  class="form-control "  placeholder="Crédit " readonly  >';
											
											break;
										case 2:
										 echo '<input type="number" name = "somme_debit" id="somme_debit" min="0"   class="form-control  "   placeholder="Débit "  >';
											break;
											case 3:
										echo '<input type="number" name = "somme_debit" id="somme_debit" min="0"   class="form-control  "   placeholder="Débit "  >';
											break;

										case 4:
									echo '<input type="number" name = "somme_debit" id="somme_debit" min="0"   class="form-control  "   placeholder="Débit "  >';
											break;
											case 5:
											echo '';
											break;
											case 6:
											echo '';
											break;
											case 7:
											echo '';
											break;
											case 8:
											echo '';
											break;
											case 9:
											echo '';
											break;
											case 10:
											echo '';
											break;
											case 11:
											echo '';
											break;
											case 12:
											echo '';
											break;
											case 13:
											echo '';
											break;
											case 14:
											echo '<input type="number" name = "somme_debit" id="somme_debit" min="0"   class="form-control  "   placeholder="Débit "  >';
											break;
											



									}	
								}	?>	
	<?php } ?>	
 

  