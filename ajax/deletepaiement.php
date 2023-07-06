<?php
require_once("../includes/initialiser.php");

	
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = htmlspecialchars(trim($_GET['id']));
		 $id_societe = htmlspecialchars(trim($_GET['id_societe']));
		 $id_user = htmlspecialchars(trim($_GET['id_user']));
         if (isset($_GET['id_fournisseur'])) {
         $id_fournisseur = htmlspecialchars(trim($_GET['id_fournisseur']));
         }
         if (isset($_GET['id_client'])) {
         $id_client = htmlspecialchars(trim($_GET['id_client']));
         }
         if (isset($_GET['id_facture'])) {
         $id_facture = htmlspecialchars(trim($_GET['id_facture']));
         }
    $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($id_societe);
if (isset($_GET['achat'])) {


    if (isset($_GET['id_facture'])) {

        $Reglement_fournisseur = Update_reglement_fournisseur::trouve_par_id($id);
    if (isset($Reglement_fournisseur->id)) {
        
            $Reglement_fournisseur->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        $Reglement_fournisseur = Update_reglement_fournisseur::delete_Reglement_vide_par_admin($id_facture,1);

        if ($Reglement_fournisseur) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }
        }else{
	$Reglement_fournisseur = Reglement_fournisseur::trouve_par_id($id);
	if (isset($Reglement_fournisseur->id)) {
		
		 	$Reglement_fournisseur->supprime();
			echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
				  });
                  </script>';
		 }	 

	if ($id == 0) {
		$Reglement_fournisseur = Reglement_fournisseur::delete_Reglement_vide_par_admin($id_user,$id_societe,$id_fournisseur,1);

		if ($Reglement_fournisseur) {
			echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
				  });
                  </script>';
		}
		
		 }	 
	 }
    }
if (isset($_GET['avoir_achat'])) {


    if (isset($_GET['id_facture'])) {

        $Reglement_fournisseur = Update_reglement_fournisseur::trouve_par_id($id);
    if (isset($Reglement_fournisseur->id)) {
        
            $Reglement_fournisseur->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        $Reglement_fournisseur = Update_reglement_fournisseur::delete_Reglement_vide_par_admin($id_facture,3);

        if ($Reglement_fournisseur) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }
        }else{
    $Reglement_fournisseur = Reglement_fournisseur::trouve_par_id($id);
    if (isset($Reglement_fournisseur->id)) {
        
            $Reglement_fournisseur->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        $Reglement_fournisseur = Reglement_fournisseur::delete_Reglement_vide_par_admin($id_user,$id_societe,$id_fournisseur,3);

        if ($Reglement_fournisseur) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }   
     }
    }
if (isset($_GET['depence'])) {


    if (isset($_GET['id_facture'])) {

        $Reglement_fournisseur = Update_reglement_fournisseur::trouve_par_id($id);
    if (isset($Reglement_fournisseur->id)) {
        
            $Reglement_fournisseur->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        $Reglement_fournisseur = Update_reglement_fournisseur::delete_Reglement_vide_par_admin($id_facture);

        if ($Reglement_fournisseur) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }
        }else{
    $Reglement_fournisseur = Reglement_fournisseur::trouve_par_id($id);
    if (isset($Reglement_fournisseur->id)) {
        
            $Reglement_fournisseur->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        if (!empty($id_fournisseur)) {
                 $Reglement_fournisseur = Reglement_fournisseur::delete_Reglement_vide_par_admin($id_user,$id_societe,$id_fournisseur,2);
        }else{
             echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.error("Choisir Fournisseur  !","Attention");
                  });
                  </script>';

        }


        if ($Reglement_fournisseur) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }   
     }
    }
if (isset($_GET['vente'])) {
        if (isset($_GET['id_facture'])) {

        $Reglement_client = Update_reglement_client::trouve_par_id($id);
    if (isset($Reglement_client->id)) {
        
            $Reglement_client->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        $Reglement_client = Update_reglement_client::delete_Reglement_vide_par_admin($id_facture);

        if ($Reglement_client) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }
        }else{

      $Reglement_client = Reglement_client::trouve_par_id($id);
    $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($id_societe);
    if (isset($Reglement_client->id)) {
        
            $Reglement_client->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        $Reglement_client = Reglement_client::delete_Reglement_vide_par_admin($id_user,$id_societe,$id_client);
        if ($Reglement_client) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }            
        }
 
     }
     if (isset($_GET['avoir_vente'])) {
        if (isset($_GET['id_facture'])) {

        $Reglement_client = Update_reglement_client::trouve_par_id($id);
    if (isset($Reglement_client->id)) {
        
            $Reglement_client->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        $Reglement_client = Update_reglement_client::delete_Reglement_vide_par_admin_avoir($id_facture);

        if ($Reglement_client) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }
        }else{

      $Reglement_client = Reglement_client::trouve_par_id($id);
    $Mode_paiement_societes= Mode_paiement_societe::trouve_par_societe($id_societe);
    if (isset($Reglement_client->id)) {
        
            $Reglement_client->supprime();
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.warning("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
         }   

    if ($id == 0) {
        $Reglement_client = Reglement_client::delete_Reglement_vide_par_admin_avoir($id_user,$id_societe,$id_client);
        if ($Reglement_client) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                  toastr.info("Reglement supprimer  avec succes  !","Attention");
                  });
                  </script>';
        }
        
         }            
        }
 
     }
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
                       <?php 
                       if (isset($_GET['achat'])) {
                        if (isset($_GET['id_facture'])) {
                            $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($id_facture,1);     $cpt =0;
                        }else{
                            $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($id_user,$id_societe,1);     $cpt =0;  
                        }
                       
                       } else if (isset($_GET['depence'])) {
                        if (isset($_GET['id_facture'])) {
                            $table_Reglements = Update_reglement_fournisseur::trouve_Reglement_vide_par_admin($id_facture,2);     $cpt =0;
                        }else{
                            $table_Reglements = Reglement_fournisseur::trouve_Reglement_vide_par_admin($id_user,$id_societe,2);     $cpt =0;  
                        }
                       
                       } else if (isset($_GET['vente'])) {
                         if (isset($_GET['id_facture'])) {
                            $table_Reglements = Update_reglement_client::trouve_Reglement_vide_par_admin($id_facture);     $cpt =0;
                        }else{
                           $table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin($id_user,$id_societe);     $cpt =0; 
                        }
                        
                       } else if (isset($_GET['avoir_vente'])) {
                         if (isset($_GET['id_facture'])) {
                            $table_Reglements = Update_reglement_client::trouve_Reglement_vide_par_admin_avoir($id_facture);     $cpt =0;
                        }else{
                           $table_Reglements = Reglement_client::trouve_Reglement_vide_par_admin_avoir($id_user,$id_societe);     $cpt =0; 
                        }
                        
                       }
                        foreach($table_Reglements as $table_Reglement){ $cpt ++; ?>
          						 <tr class="item-row" >
                                        <td>
                                    <?php if (isset($table_Reglement->mode_paiment)) {
                                        
                                        $Mode_paiement_societe= Mode_paiement_societe::trouve_par_id($table_Reglement->mode_paiment);
                                        if (isset($Mode_paiement_societe->type)) {
                                            echo $Mode_paiement_societe->type;
                                        }
                                    } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->id_solde)) {
                                      if (isset($_GET['achat'])) {
                                        $Solde_fournisseur= Solde_fournisseur::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_fournisseur->reference)) {
                                            echo fr_date2($Solde_fournisseur->date).' | '.$Solde_fournisseur->reference;
                                        } {echo '/';}
                                    } else if (isset($_GET['vente'])) {
                                        $Solde_client= Solde_client::trouve_par_id($table_Reglement->id_solde);
                                        if (isset($Solde_client->reference)) {
                                            echo fr_date2($Solde_client->date).' | '.$Solde_client->reference;
                                        }else {echo '/';}
                                     }
                                        
                                    } ?>
                                        </td>
                                        <td>
                                            <?php 
                                             if (isset($_GET['achat'])) {
                                            if (isset($Solde_fournisseur->solde)) {
                                            echo number_format($Solde_fournisseur->solde,2,"."," ");
                                            }else {echo '/';}  } else if (isset($_GET['vente'])) {
                                            if (isset($Solde_client->solde)) {
                                            echo number_format($Solde_client->solde,2,"."," ");
                                        }else {echo '/';} } ?>
                                        </td>
                                        <td>
                                            <?php if (isset($table_Reglement->somme)) {
                                        echo number_format($table_Reglement->somme,2,"."," ");
                                    } ?>
                                        </td>
                                        <td>
                                            <?php
                                                if (isset($_GET['achat'])) {

                                             $Reste = $Solde_fournisseur->solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                        } else if (isset($_GET['vente'])) {
                                            $Reste = $Solde_client->solde - $table_Reglement->somme;
                                            echo number_format($Reste,2,"."," ");
                                        }
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

