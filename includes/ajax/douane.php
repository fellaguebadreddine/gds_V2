<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 // $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $Frais_annexe = Frais_annexe::trouve_par_id($id);

 
		?>
				
					
						
														
							<?php 
								if(!empty($Frais_annexe->is_douane) && $Frais_annexe->is_douane ==1)	{
															
								?>
								<input type="number" min="0" id="valeur_DA"  class="form-control  valeur_DA "  name="valeur_DA" required /> 		
								<script>
									  $(document).ready(function(){
										$('#valeur_DA').focus();
										});
								</script>	
																						
								<?php 	}	else {?>
																
									<input type="number" min="0" id="valeur_DA"  class="form-control  valeur_DA "  disabled  name="valeur_DA"  /> 

									<script>
									  $(document).ready(function(){
										$('#date_frais').focus();
										});
								</script>	
									<?php	}?>																		
	<?php } ?>	
