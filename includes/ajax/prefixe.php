<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $compte = Compte_comptable::trouve_par_id($id);

 
		?>
													
		<label class="col-md-2 control-label">Auxiliaire: </label>
		<div class="col-md-2">
													
				<div class="input-group">
					<select class="form-control " <?php if($compte->aux ==0 ) {echo "disabled";} ?>  id="auxiliere_achat"  name="auxiliere_achat">
														
				<?php 
					if(!empty($compte->prefixe))	{
						$Auxl = Auxiliere::trouve_auxiliere_par_lettre_aux($compte->prefixe,$id_societe);
							foreach($Auxl as $Auxs){?>
														
							<option  value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle ?></option>
														
							<?php } 	}	else {?>
																
							<option>  </option>
				<?php	}?>											
														
																												   
					</select>
						
			</div>

		</div>

	<?php } ?>	
 

  