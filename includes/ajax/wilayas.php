<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 // $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $wilayas = Wilayas::trouve_par_id($id);

 
		?>
										
				
					<div class="form-group form-md-line-input has-info">
						<select class="form-control "   id="commune"  name="commune">
														
							<?php 
								if(!empty($wilayas->id))	{
															
								$commune = Communes::trouve_communes_par_id_wilayas($wilayas->id);
								foreach($commune as $commun){?>
														
									<option <?php if ($commun->id == $editSoct->commune) { echo "selected";} ?> value = "<?php echo $commun->id ?>" > <?php echo $commun->nom ?></option>
														
								<?php } 	}	else {?>
																
									<option>  </option>
									<?php	}?>											
														
																												   
						</select>
					</div>

			
													
	<?php } ?>	
 

  