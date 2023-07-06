<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
      if (isset($_GET['action']) &&  $_GET['action'] == 'vente') {
            $id_fact =  htmlspecialchars(intval($_GET['id'])) ;
            $Facture = Facture_vente::trouve_par_id($id_fact);
        echo '<input type="text" id="Reference" class="form-control " value="'.$Facture->Num_facture.'" name="Reference" placeholder="FACT0001/21"    />';    
      }else if (isset($_GET['action']) &&  $_GET['action'] == 'achat') {
            $id_fact =  htmlspecialchars(intval($_GET['id'])) ;
            $Facture = Facture_achat::trouve_par_id($id_fact);
       echo '<input type="text" id="Reference" class="form-control " value="'.$Facture->Num_facture.'" name="Reference" placeholder="FACT0001/21"    />';   
      }


}
     
?>  
