<?php 
require_once("../includes/initialiser.php");
	 if(!empty($_SESSION['societe'])){
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);} 
$Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($nav_societe->id_societe);
		$errors = array();
if (isset($_GET['depence'])) {
if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
     $errors[]= 'Choisir  la date !';
}
if (empty(htmlspecialchars(trim($_GET['id_fournisseur'])))) {
     $errors[]= 'Choisir  Fournisseur !';
}

if (empty(htmlspecialchars(trim($_GET['mode_paiment'])))) {
     $errors[]= 'Choisir  mode_paiment !';

}else{
    $Mode_paiement = Mode_paiement_societe::trouve_par_id(htmlspecialchars(trim($_GET['mode_paiment'])));
}
if(isset($Mode_paiement->mode_paiement ) && ($Mode_paiement->mode_paiement != 3)){ 
if (empty(htmlspecialchars(trim($_GET['id_solde'])))) {
     $errors[]= 'Choisir  Réference  !';

}
if (empty(htmlspecialchars(trim($_GET['Montant'])))) {
     $errors[]= 'Champ Montant  est vide !';
}
}


    $Montant = htmlspecialchars(trim($_GET['Montant']));
     $reste = htmlspecialchars(trim($_GET['reste']));
     if ($reste == 0) {
         $errors[]= 'Paiement facture est terminé  !';
     }
     if ($Montant > $reste ) {
          $errors[]= 'Montant  entrer  est supérieur a TTC  !';
     }

     if (isset($_GET['id_facture'])) {

    $Reglement_fournisseur = new Update_reglement_fournisseur();
    $Reglement_fournisseur->id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
    $Reglement_fournisseur->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_fournisseur->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_fournisseur->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_fournisseur->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_fournisseur->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_fournisseur->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_fournisseur->id_facture = htmlspecialchars(trim(addslashes($_GET['id_facture'])));

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_fournisseur->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_fournisseur->timbre = $timbre;  

    $last_Reglement =Update_reglement_fournisseur::trouve_last_Reglement_vide_par_admin($Reglement_fournisseur->id_facture );
     }else{

    $Reglement_fournisseur = new Reglement_fournisseur();
    $Reglement_fournisseur->id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
    $Reglement_fournisseur->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_fournisseur->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_fournisseur->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_fournisseur->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_fournisseur->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_fournisseur->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_fournisseur->type_fact = 2 ;

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_fournisseur->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_fournisseur->timbre = $timbre;  

    $last_Reglement =Reglement_fournisseur::trouve_last_Reglement_vide_par_admin($Reglement_fournisseur->id_person,$Reglement_fournisseur->id_societe,2);
   
     }

      if (isset($last_Reglement->mode_paiment)) {
    $last_Mode_paiement = Mode_paiement_societe::trouve_par_id($last_Reglement->mode_paiment);
     if ($last_Mode_paiement->mode_paiement == 3) {
        $errors[]= 'Mode Paiement facture est \" A tèrme\" vous ne pouvez pas ajouter autre  !';
     }

    }
   
    if (empty($errors)){
if ($Reglement_fournisseur->existe(2)) {
    if (isset($_GET['id_facture'])) {
    $existe_Reglement= Update_reglement_fournisseur::trouve_reglement_vide_par_id_solde($Reglement_fournisseur->id_solde,$Reglement_fournisseur->id_person,$Reglement_fournisseur->id_facture,2);
    }else{
    $existe_Reglement= Reglement_fournisseur::trouve_reglement_vide_par_id_solde($Reglement_fournisseur->id_solde,$Reglement_fournisseur->id_person,2);       
    }

    if (isset($existe_Reglement->id)) {
        $existe_Reglement->supprime();
    }
    

    if (empty($errors)){

        $Reglement_fournisseur->save();
        echo '<script type="text/javascript">
            toastr.info(" Réglement Modifier avec succes","Très bien !");
            

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
            $Reglement_fournisseur->save();
            
            ?>
        <script type="text/javascript">
            toastr.success(" Réglement  Ajouter avec succes","Très bien !");

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
    
 ?>

  <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                       <?php if (isset($_GET['id_facture'])) {
                        $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($Reglement_fournisseur->id_facture);
                       }
                       else{
                        $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($Reglement_fournisseur->id_person,$nav_societe->id_societe,2);
                       }


                             $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                                 <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)  ) {
                                        if ($table_Reglement->id_facture > 0 ) {
                                           $Reglement =  Reglement_fournisseur::trouve_par_solde_and_facture($table_Reglement->id_solde,$table_Reglement->id_facture,2);
                                        }
                                        

                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
                                        }else {echo '/';}
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_fournisseur->solde)) {
                                                if ($table_Reglement->id_facture > 0) {
                                                $Solde = $Solde_fournisseur->solde + $Reglement->somme + $Reglement->timbre;
                                                }else{
                                                  $Solde = $Solde_fournisseur->solde;  
                                                }
                                            
                                            echo number_format($Solde,2,"."," ");
                                        }else {echo '/';} ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                        <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
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
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
<?php } else  if (isset($_GET['achat'])) {
if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
	 $errors[]= 'Choisir  la date !';
}
if (empty(htmlspecialchars(trim($_GET['id_fournisseur'])))) {
	 $errors[]= 'Choisir  Fournisseur !';
}

if (empty(htmlspecialchars(trim($_GET['mode_paiment'])))) {
	 $errors[]= 'Choisir  mode_paiment !';

}else{
    $Mode_paiement = Mode_paiement_societe::trouve_par_id(htmlspecialchars(trim($_GET['mode_paiment'])));
}
if(isset($Mode_paiement->mode_paiement ) && ($Mode_paiement->mode_paiement != 3)){ 
if (empty(htmlspecialchars(trim($_GET['id_solde'])))) {
     $errors[]= 'Choisir  Réference  !';

}
if (empty(htmlspecialchars(trim($_GET['Montant'])))) {
     $errors[]= 'Champ Montant  est vide !';
}
}


    $Montant = htmlspecialchars(trim($_GET['Montant']));
     $reste = htmlspecialchars(trim($_GET['reste']));
     if ($reste == 0) {
         $errors[]= 'Paiement facture est terminé  !';
     }
     if ($Montant > $reste ) {
          $errors[]= 'Montant  entrer  est supérieur a TTC  !';
     }

     if (isset($_GET['id_facture'])) {

    $Reglement_fournisseur = new Update_reglement_fournisseur();
    $Reglement_fournisseur->id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
    $Reglement_fournisseur->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_fournisseur->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_fournisseur->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_fournisseur->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_fournisseur->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_fournisseur->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_fournisseur->id_facture = htmlspecialchars(trim(addslashes($_GET['id_facture'])));
    $Reglement_fournisseur->type_fact = 1;

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_fournisseur->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_fournisseur->timbre = $timbre;  

    $last_Reglement =Update_reglement_fournisseur::trouve_last_Reglement_vide_par_admin($Reglement_fournisseur->id_facture,1);
     }else{

	$Reglement_fournisseur = new Reglement_fournisseur();
	$Reglement_fournisseur->id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
	$Reglement_fournisseur->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
	$Reglement_fournisseur->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
	$Reglement_fournisseur->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
	$Reglement_fournisseur->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
	$Reglement_fournisseur->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
	$Reglement_fournisseur->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_fournisseur->type_fact = 1;

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_fournisseur->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_fournisseur->timbre = $timbre;  

    $last_Reglement =Reglement_fournisseur::trouve_last_Reglement_vide_par_admin($Reglement_fournisseur->id_person,$Reglement_fournisseur->id_societe,1);
   
     }

      if (isset($last_Reglement->mode_paiment)) {
    $last_Mode_paiement = Mode_paiement_societe::trouve_par_id($last_Reglement->mode_paiment);
     if ($last_Mode_paiement->mode_paiement == 3) {
        $errors[]= 'Mode Paiement facture est \" A tèrme\" vous ne pouvez pas ajouter autre  !';
     }

    }
   
	if (empty($errors)){
if ($Reglement_fournisseur->existe(1)) {

    if (isset($_GET['id_facture'])) {
    $existe_Reglement= Update_reglement_fournisseur::trouve_reglement_vide_par_id_solde($Reglement_fournisseur->id_solde,$Reglement_fournisseur->id_person,$Reglement_fournisseur->id_facture,1);
    }else{
    $existe_Reglement= Reglement_fournisseur::trouve_reglement_vide_par_id_solde($Reglement_fournisseur->id_solde,$Reglement_fournisseur->id_person,1);       
    }

	if (isset($existe_Reglement->id)) {
		$existe_Reglement->supprime();
	}
	

	if (empty($errors)){

		$Reglement_fournisseur->save();
		echo '<script type="text/javascript">
			toastr.info(" Réglement Modifier avec succes","Très bien !");
			

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
			$Reglement_fournisseur->save();
			
			?>
 		<script type="text/javascript">
			toastr.success(" Réglement  Ajouter avec succes","Très bien !");

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
	
 ?>

  <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                       <?php if (isset($_GET['id_facture'])) {
                        $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($Reglement_fournisseur->id_facture,1);
                       }
                       else{
                        $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($Reglement_fournisseur->id_person,$nav_societe->id_societe,1);
                       }


                       	     $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
          						  <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)  ) {
                                        if ($table_Reglement->id_facture > 0 ) {
                                           $Reglement =  Reglement_fournisseur::trouve_par_solde_and_facture($table_Reglement->id_solde,$table_Reglement->id_facture,1);
                                        }
                                        

                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
                                        }else {echo '/';}
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_fournisseur->solde)) {
                                                if ($table_Reglement->id_facture > 0) {
                                                $Solde = $Solde_fournisseur->solde + $Reglement->somme + $Reglement->timbre;
                                                }else{
                                                  $Solde = $Solde_fournisseur->solde;  
                                                }
                                            
                                            echo number_format($Solde,2,"."," ");
                                        }else {echo '/';} ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
          				<?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
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
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
<?php } else  if (isset($_GET['avoir_achat'])) {
if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
     $errors[]= 'Choisir  la date !';
}
if (empty(htmlspecialchars(trim($_GET['id_fournisseur'])))) {
     $errors[]= 'Choisir  Fournisseur !';
}

if (empty(htmlspecialchars(trim($_GET['mode_paiment'])))) {
     $errors[]= 'Choisir  mode_paiment !';

}else{
    $Mode_paiement = Mode_paiement_societe::trouve_par_id(htmlspecialchars(trim($_GET['mode_paiment'])));
}
if(isset($Mode_paiement->mode_paiement ) && ($Mode_paiement->mode_paiement != 3)){ 
if (empty(htmlspecialchars(trim($_GET['id_solde'])))) {
     $errors[]= 'Choisir  Réference  !';

}
if (empty(htmlspecialchars(trim($_GET['Montant'])))) {
     $errors[]= 'Champ Montant  est vide !';
}
}


    $Montant = htmlspecialchars(trim($_GET['Montant']));
     $reste = htmlspecialchars(trim($_GET['reste']));
     if ($reste == 0) {
         $errors[]= 'Paiement facture est terminé  !';
     }
     if ($Montant > $reste ) {
          $errors[]= 'Montant  entrer  est supérieur a TTC  !';
     }

     if (isset($_GET['id_facture'])) {

    $Reglement_fournisseur = new Update_reglement_fournisseur();
    $Reglement_fournisseur->id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
    $Reglement_fournisseur->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_fournisseur->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_fournisseur->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_fournisseur->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_fournisseur->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_fournisseur->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_fournisseur->id_facture = htmlspecialchars(trim(addslashes($_GET['id_facture'])));
    $Reglement_fournisseur->type_fact = 3;

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_fournisseur->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_fournisseur->timbre = $timbre;  

    $last_Reglement =Update_reglement_fournisseur::trouve_last_Reglement_vide_par_admin($Reglement_fournisseur->id_facture,3);
     }else{

    $Reglement_fournisseur = new Reglement_fournisseur();
    $Reglement_fournisseur->id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
    $Reglement_fournisseur->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_fournisseur->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_fournisseur->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_fournisseur->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_fournisseur->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_fournisseur->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_fournisseur->type_fact = 3;

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_fournisseur->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_fournisseur->timbre = $timbre;  

    $last_Reglement =Reglement_fournisseur::trouve_last_Reglement_vide_par_admin($Reglement_fournisseur->id_person,$Reglement_fournisseur->id_societe,3);
   
     }

      if (isset($last_Reglement->mode_paiment)) {
    $last_Mode_paiement = Mode_paiement_societe::trouve_par_id($last_Reglement->mode_paiment);
     if ($last_Mode_paiement->mode_paiement == 3) {
        $errors[]= 'Mode Paiement facture est \" A tèrme\" vous ne pouvez pas ajouter autre  !';
     }

    }
   
    if (empty($errors)){
if ($Reglement_fournisseur->existe(3)) {

    if (isset($_GET['id_facture'])) {
    $existe_Reglement= Update_reglement_fournisseur::trouve_reglement_vide_par_id_solde($Reglement_fournisseur->id_solde,$Reglement_fournisseur->id_person,$Reglement_fournisseur->id_facture,3);
    }else{
    $existe_Reglement= Reglement_fournisseur::trouve_reglement_vide_par_id_solde($Reglement_fournisseur->id_solde,$Reglement_fournisseur->id_person,3);       
    }

    if (isset($existe_Reglement->id)) {
        $existe_Reglement->supprime();
    }
    

    if (empty($errors)){

        $Reglement_fournisseur->save();
        echo '<script type="text/javascript">
            toastr.info(" Réglement Modifier avec succes","Très bien !");
            

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
            $Reglement_fournisseur->save();
            
            ?>
        <script type="text/javascript">
            toastr.success(" Réglement  Ajouter avec succes","Très bien !");

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
    
 ?>

  <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                       <?php if (isset($_GET['id_facture'])) {
                        $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($Reglement_fournisseur->id_facture,3);
                       }
                       else{
                        $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($Reglement_fournisseur->id_person,$nav_societe->id_societe,3);
                       }


                             $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                                  <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)  ) {
                                        if ($table_Reglement->id_facture > 0 ) {
                                           $Reglement =  Reglement_fournisseur::trouve_par_solde_and_facture($table_Reglement->id_solde,$table_Reglement->id_facture,3);
                                        }
                                        

                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
                                        }else {echo '/';}
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_fournisseur->solde)) {
                                                if ($table_Reglement->id_facture > 0) {
                                                $Solde = $Solde_fournisseur->solde + $Reglement->somme + $Reglement->timbre;
                                                }else{
                                                  $Solde = $Solde_fournisseur->solde;  
                                                }
                                            
                                            echo number_format($Solde,2,"."," ");
                                        }else {echo '/';} ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                        <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
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
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
<?php } elseif(isset($_GET['vente'])) { 
if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
     $errors[]= 'Choisir  la date !';
}
if (empty(htmlspecialchars(trim($_GET['id_client'])))) {
     $errors[]= 'Choisir  Fournisseur !';
}

if (empty(htmlspecialchars(trim($_GET['mode_paiment'])))) {
     $errors[]= 'Choisir  mode_paiment !';

}else{
    $Mode_paiement = Mode_paiement_societe::trouve_par_id(htmlspecialchars(trim($_GET['mode_paiment'])));
}
if(isset($Mode_paiement->mode_paiement ) && ($Mode_paiement->mode_paiement != 3)){ 
if (empty(htmlspecialchars(trim($_GET['id_solde'])))) {
     $errors[]= 'Choisir  Réference  !';

}
if (empty(htmlspecialchars(trim($_GET['Montant'])))) {
     $errors[]= 'Champ Montant  est vide !';
}
}


    $Montant = htmlspecialchars(trim($_GET['Montant']));
     $reste = htmlspecialchars(trim($_GET['reste']));
     if ($reste == 0) {
         $errors[]= 'Paiement facture est terminé  !';
     }
     if ($Montant > $reste ) {
          $errors[]= 'Montant  entrer  est supérieur a TTC  !';
     }

     if (isset($_GET['id_facture'])) {

    $Reglement_client = new Update_reglement_client();
    $Reglement_client->id_client = htmlspecialchars(trim($_GET['id_client']));
    $Reglement_client->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_client->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_client->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_client->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_client->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_client->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_client->id_facture = htmlspecialchars(trim(addslashes($_GET['id_facture'])));

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_client->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_client->timbre = $timbre;  

    $last_Reglement =Update_reglement_client::trouve_last_Reglement_vide_par_admin($Reglement_client->id_facture);


     }else{

    $Reglement_client = new Reglement_client();
    $Reglement_client->id_client = htmlspecialchars(trim($_GET['id_client']));
    $Reglement_client->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_client->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_client->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_client->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_client->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_client->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_client->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_client->timbre = $timbre;  

    $last_Reglement =Reglement_client::trouve_last_Reglement_vide_par_admin($Reglement_client->id_person,$Reglement_client->id_societe);
   
     }

      if (isset($last_Reglement->mode_paiment)) {
    $last_Mode_paiement = Mode_paiement_societe::trouve_par_id($last_Reglement->mode_paiment);
     if ($last_Mode_paiement->mode_paiement == 3) {
        $errors[]= 'Mode Paiement facture est \" A tèrme\" vous ne pouvez pas ajouter autre  !';
     }

    }
   
    if (empty($errors)){
if ($Reglement_client->existe()) {
    if (isset($_GET['id_facture'])) {
    $existe_Reglement= Update_reglement_client::trouve_reglement_vide_par_id_solde($Reglement_client->id_solde,$Reglement_client->id_person,$Reglement_client->id_facture);
    }else{
    $existe_Reglement= Reglement_client::trouve_reglement_vide_par_id_solde($Reglement_client->id_solde,$Reglement_client->id_person);       
    }

    if (isset($existe_Reglement->id)) {
        $existe_Reglement->supprime();
    }
    

    if (empty($errors)){

        $Reglement_client->save();
        echo '<script type="text/javascript">
            toastr.info(" Réglement Modifier avec succes","Très bien !");
            

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
            $Reglement_client->save();
            
            ?>
        <script type="text/javascript">
            toastr.success(" Réglement  Ajouter avec succes","Très bien !");

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
    
 ?>

  <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                       <?php if (isset($_GET['id_facture'])) {
                        $table_Reglements = Update_reglement_client::trouve_Reglement_vide_par_admin($Reglement_client->id_facture);

                       }
                       else{
                        $table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin($Reglement_client->id_person,$nav_societe->id_societe);
                       }


                             $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                                 <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        if ($table_Reglement->id_facture > 0 ) {
                                    $Reglement =  Reglement_client::trouve_par_solde_and_facture($table_Reglement->id_solde,$table_Reglement->id_facture);
                                        }
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_client= Solde_client::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_client->reference)) {
                                            echo fr_date2($Solde_client->date).' | '.$Solde_client->reference;
                                        }else {echo '/';}
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_client->solde)) {
                                                if ($table_Reglement->id_facture > 0 ) {
                                            $Solde = $Solde = $Solde_client->solde + $Reglement->somme + $Reglement->timbre;
                                        } else{
                                            $Solde = $Solde = $Solde_client->solde;
                                        }  

                                            echo number_format($Solde,2,"."," ");
                                        }else {echo '/';} ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                        <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
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
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
<?php } elseif(isset($_GET['avoir_vente'])) { 
if (empty(htmlspecialchars(trim($_GET['date_fact'])))) {
     $errors[]= 'Choisir  la date !';
}
if (empty(htmlspecialchars(trim($_GET['id_client'])))) {
     $errors[]= 'Choisir  Fournisseur !';
}

if (empty(htmlspecialchars(trim($_GET['mode_paiment'])))) {
     $errors[]= 'Choisir  mode_paiment !';

}else{
    $Mode_paiement = Mode_paiement_societe::trouve_par_id(htmlspecialchars(trim($_GET['mode_paiment'])));
}
if(isset($Mode_paiement->mode_paiement ) && ($Mode_paiement->mode_paiement != 3)){ 
if (empty(htmlspecialchars(trim($_GET['id_solde'])))) {
     $errors[]= 'Choisir  Réference  !';

}
if (empty(htmlspecialchars(trim($_GET['Montant'])))) {
     $errors[]= 'Champ Montant  est vide !';
}
}


    $Montant = htmlspecialchars(trim($_GET['Montant']));
     $reste = htmlspecialchars(trim($_GET['reste']));
     if ($reste == 0) {
         $errors[]= 'Paiement facture est terminé  !';
     }
     if ($Montant > $reste ) {
          $errors[]= 'Montant  entrer  est supérieur a TTC  !';
     }

     if (isset($_GET['id_facture'])) {

    $Reglement_client = new Update_reglement_client();
    $Reglement_client->id_client = htmlspecialchars(trim($_GET['id_client']));
    $Reglement_client->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_client->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_client->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_client->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_client->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_client->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_client->id_facture = htmlspecialchars(trim(addslashes($_GET['id_facture'])));
    $Reglement_client->type_fact = 1;

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_client->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_client->timbre = $timbre;  

    $last_Reglement =Update_reglement_client::trouve_last_Reglement_vide_par_admin_avoir($Reglement_client->id_facture);


     }else{

    $Reglement_client = new Reglement_client();
    $Reglement_client->id_client = htmlspecialchars(trim($_GET['id_client']));
    $Reglement_client->id_societe = htmlspecialchars(trim(addslashes($_GET['id_societe'])));
    $Reglement_client->id_solde = htmlspecialchars(trim(addslashes($_GET['id_solde'])));
    $Reglement_client->date = htmlspecialchars(trim(addslashes($_GET['date_fact'])));
    $Reglement_client->somme = htmlspecialchars(trim(addslashes($_GET['Montant'])));
    $Reglement_client->id_person = htmlspecialchars(trim(addslashes($_GET['id_person'])));
    $Reglement_client->mode_paiment = htmlspecialchars(trim(addslashes($_GET['mode_paiment'])));
    $Reglement_client->type_fact = 1;

    if($Mode_paiement->mode_paiement == 2){
        $timbre = $Reglement_client->somme /100;
            $timbre = ceil($timbre);
            if ($timbre < 5 ) {
                $timbre =5; }
                elseif( $timbre >= 2500 ){
                    $timbre = 2500;
                }   
    }else  {$timbre = 0;}
     $Reglement_client->timbre = $timbre;  

    $last_Reglement =Reglement_client::trouve_last_Reglement_vide_par_admin_avoir($Reglement_client->id_person,$Reglement_client->id_societe);
   
     }

      if (isset($last_Reglement->mode_paiment)) {
    $last_Mode_paiement = Mode_paiement_societe::trouve_par_id($last_Reglement->mode_paiment);
     if ($last_Mode_paiement->mode_paiement == 3) {
        $errors[]= 'Mode Paiement facture est \" A tèrme\" vous ne pouvez pas ajouter autre  !';
     }

    }
   
    if (empty($errors)){
if ($Reglement_client->existe()) {
    if (isset($_GET['id_facture'])) {
    $existe_Reglement= Update_reglement_client::trouve_reglement_vide_par_id_solde_avoir($Reglement_client->id_solde,$Reglement_client->id_person,$Reglement_client->id_facture);
    }else{
    $existe_Reglement= Reglement_client::trouve_reglement_vide_par_id_solde_avoir($Reglement_client->id_solde,$Reglement_client->id_person);       
    }

    if (isset($existe_Reglement->id)) {
        $existe_Reglement->supprime();
    }
    

    if (empty($errors)){

        $Reglement_client->save();
        echo '<script type="text/javascript">
            toastr.info(" Réglement Modifier avec succes","Très bien !");
            

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
            $Reglement_client->save();
            
            ?>
        <script type="text/javascript">
            toastr.success(" Réglement  Ajouter avec succes","Très bien !");

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
    
 ?>

  <table width="100%" id="items" class="table table-bordered table-hover" >
        
                                        <tr>
                                            <th width="40%">Mode paiement</th>
                                            <th>Réference</th>
                                            <th>Solde</th>
                                            <th>Montant</th>
                                            <th>Reste</th>
                                            <th>#</th>
                                        </tr>
                       <?php if (isset($_GET['id_facture'])) {
                        $table_Reglements = Update_reglement_client::trouve_Reglement_vide_par_admin_avoir($Reglement_client->id_facture);

                       }
                       else{
                        $table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin_avoir($Reglement_client->id_person,$nav_societe->id_societe);
                       }


                             $cpt =0;
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
                                 <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        if ($table_Reglement->id_facture > 0 ) {
                                    $Reglement =  Reglement_client::trouve_par_solde_and_facture_avoir($table_Reglement->id_solde,$table_Reglement->id_facture);
                                        }
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                       
                                        $Solde_client= Solde_client::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_client->reference)) {
                                            echo fr_date2($Solde_client->date).' | '.$Solde_client->reference;
                                        }else {echo '/';}
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if (isset($Solde_client->solde)) {
                                                if ($table_Reglement->id_facture > 0 ) {
                                            $Solde = $Solde = $Solde_client->solde + $Reglement->somme + $Reglement->timbre;
                                        } else{
                                            $Solde = $Solde = $Solde_client->solde;
                                        }  

                                            echo number_format($Solde,2,"."," ");
                                        }else {echo '/';} ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php $Reste = $Solde + $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                             ?>
                                        </td>
                                        <td>
                                            <a  id="delete_row" name="<?php if (isset($table_Reglement->id)){ echo $table_Reglement->id; } ?>" class="btn red btn-sm"> <i class="fa fa-trash"></i> </a>
                                        </td>   
                                    </tr>
                        <?php } ?>
                                       <tr class="info-mode_paiment" >
                                
                                <td><select placeholder="Choisir mode paiement"   name="mode_paiment_facture" id="mode_paiment_facture"  class=" form-control select2me">
                                                        <option value=""></option>
                                                        <?php foreach ($Mode_paiement_societes as $Mode_paiement_societe) {?>
                                                        <option value="<?php if(isset($Mode_paiement_societe->id)) {echo $Mode_paiement_societe->id;}?>"><?php if (isset($Mode_paiement_societe->type)) {echo $Mode_paiement_societe->type;} ?></option>
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
                                     <a class="btn btn green-jungle btn-sm" class="btn green" id="add_paiement"><i class="fa fa-plus"></i></a>
                                </td>
                                
                            </tr>
                                    </table>
<?php } ?>
        <script type="text/javascript">
            $(document).ready(function(){
			$('#mode_paiment_facture').select2();
			$('#mode_paiment_facture').select2('open');
            });


            </script> 