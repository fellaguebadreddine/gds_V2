<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 
 
 
		?>

					<select class="form-control  "   id="type_amortissement"  name="type_amortissement"   placeholder="Choisir un type"  >
						
							<?php
								if (isset($id)){
									switch ($id) {
										case 1:?>
											<option value="<?php if(isset($id)){echo $id; } ?>">
												Linéaire
											</option>
										
										<?php	
											break;
										case 2:?>
											
											<option value="<?php if(isset($id)){echo $id; } ?>">
												Dégressif
											</option>
										<?php	break;
											case 3:?>
											<option value="<?php if(isset($id)){echo $id; } ?>">
												Non Amortisable
											</option>
										
										<?php	break;

									}	
								}	?>	
																						   
					</select> 


	<?php } ?>	
 

  