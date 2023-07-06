<?php
require_once("../includes/initialiser.php");
$errors = array();
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 

    if (empty(htmlspecialchars(trim($_GET['id_Journal'])))) {
     $errors[]= 'Choisir Journal !';}
     else{
        $id_Journal = htmlspecialchars(trim($_GET['id_Journal']));
        $Journal = Journaux::trouve_par_id($id_Journal); 
     }

     if (empty(htmlspecialchars(trim($_GET['reference'])))) {
     $errors[]= 'Champ Référence  est vide  !';}

    if (empty(htmlspecialchars(trim($_GET['libelle'])))) {
     $errors[]= 'Champ Libellé  est vide  !'; }

    $id_societe = htmlspecialchars(trim($_GET['id_societe']));
    $date_comptable = htmlspecialchars(trim($_GET['date_comptable']));
    
    $referenc = htmlspecialchars(trim($_GET['reference']));
    $libell = htmlspecialchars(trim($_GET['libelle']));
    if (isset($libell)) {
        $libelle = str_replace("_"," ", $libell);
    }
    if (isset($referenc)) {
        $reference = str_replace("_"," ", $referenc);
    }
	$id = htmlspecialchars(trim($_GET['id']));
	$Compte = Compte_comptable::trouve_par_id($id);
	$Compte_comptables = Compte_comptable::trouve_compte_comptable_par_societe($id_societe); 
    $Auxle = Auxiliere::trouve_auxiliere_par_lettre_aux($Compte->prefixe,$id_societe);
	 }

?>

                            
                            <?php if (empty($errors)){ ?>
                        
                                <td>
                                    <select class="form-control  select2me"   id="id_compte"  name="id_compte"   placeholder="Choisir Compte" >
                                                            <option value=""></option>
                                                        <?php  foreach ($Compte_comptables as $Compte_comptable) { ?>
                                                                    <option <?php if ($Compte_comptable->id == $Compte->id ){echo "selected";}  ?> value="<?php if(isset($Compte_comptable->id)){echo $Compte_comptable->id; } ?>"><?php if (isset($Compte_comptable->id)) {echo $Compte_comptable->code;  echo  ' |  ' . $Compte_comptable->libelle ;} ?> </option>
                                                                <?php } ?>                                                         
                                                        </select>   
                                <input type="hidden" id="ref" value="<?php if (isset($referenc)) {echo $referenc;  }?>" >
                                <input type="hidden" id="lib" value="<?php if (isset($libell)) {echo $libell;  }?>">
                                <input type="hidden" id="Journal" value="<?php if (isset($Journal->id)) {echo $Journal->id;  }?>"> 
                                </td>
                                
                                <td>
                                   <?php if (isset($date_comptable)) {echo $date_comptable;  }?>
                                   <input id="date" type="hidden" value="<?php if (isset($date_comptable)) {echo $date_comptable;  }?>"  >
                                </td>
                                <td>
                                    <select class="form-control  select2me" <?php if($Compte->aux ==0 ) {echo "disabled";} ?>  id="auxiliere"  name="auxiliere"> <?php if(!empty($Compte->prefixe))  {
                                                        $Auxle = Auxiliere::trouve_auxiliere_par_lettre_aux($Compte->prefixe,$id_societe);
                                                        foreach($Auxle as $Auxs){?>
                                                            <option>  </option>
                                                            <option value=""> Non </option>
                                                        <option  value = "<?php echo $Auxs->id ?>"  > <?php echo $Auxs->code . ' | '. $Auxs->libelle?></option>
                                                            <?php }  }   else {?>
                                                                <option>  </option>
                                                        <?php   }?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name = "Debit" min="0" id="Debit" class="form-control" placeholder="Débit "   >
                                </td>
                                <td>
                                    <input type="number" name = "Credit" id="Credit" min="0" class="form-control" placeholder="Crédit "   >
                                </td>
                                <td>
                                    <input type="number" name = "Annexe_Fiscale" id="Annexe_Fiscale" min="0" class="form-control" placeholder="Annexe Fiscale "   >
                                </td>
                                <td></td>
                                <td>
                                     <button style="width: 72px;" class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
                                </td>

                            <?php } else { ?>
 <td>
                                    <select class="form-control  select2me"   id="id_compte"  name="id_compte"   placeholder="Choisir Compte" >
                                                            <option value=""></option>
                                                        <?php  foreach ($Compte_comptables as $Compte_comptable) { ?>
                                                                    <option <?php if ($Compte_comptable->id == $Compte->id ){echo "selected";}  ?> value="<?php if(isset($Compte_comptable->id)){echo $Compte_comptable->id; } ?>"><?php if (isset($Compte_comptable->id)) {echo $Compte_comptable->code;  echo  ' |  ' . $Compte_comptable->libelle ;} ?> </option>
                                                                <?php } ?>                                                         
                                                        </select>   
                                </td>
                                
                               <td>
                                   
                                   <input id="date" type="hidden" value=""  >
                                   <input type="hidden" id="ref" value="" >
                                    <input type="hidden" id="lib" value="">
                                    <input type="hidden" id="Journal" value="">
                                </td>
                               
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                                <td></td>
                                <td>
                                   
                                </td>
                                <td>
                                    
                                </td>
                                <td>
                                     <button class="btn btn green-jungle btn-sm" class="btn green" id="submit"><i class="fa fa-plus"></i></button>
                                </td>


                                <?php 
                echo '<script type="text/javascript">
                      toastr.error("';
                         foreach ($errors as $msg) {
                        echo ' - '.$msg.' <br />';
                         }
            echo '  ","Attention !");

            $(document).ready(function(){
            $("#id_compte").select2();
            $("#id_compte").select2("val", "");
            });
            </script>'; } ?>

        <script type="text/javascript">
            $(document).ready(function(){
                var aux = <?php echo $Compte->aux ; ?>;
                $('#id_compte').select2();
                $('#auxiliere').select2();
                if (aux == 1) {
                   $('#auxiliere').select2('open');
                }else {
                 $('#Debit').focus();   
                }
            });

            </script>  
<?php unset($errors) ?>