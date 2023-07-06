<?php
require_once("../includes/initialiser.php");
 if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { 
 $TOTALTTC =  htmlspecialchars(floatval($_POST['TOTALTTC'])) ;
 $Reste_fact =  htmlspecialchars(floatval($_POST['Reste_fact'])) ;
 $id = htmlspecialchars(trim($_POST['id']));
if (isset($_POST['id_facture'])) {
 $id_facture =  htmlspecialchars(intval($_POST['id_facture'])) ;
}
	 }
      $action ='';
if (isset($_POST['action'])) {
 $action =  htmlspecialchars($_POST['action']) ;
}
 
  if ($action == 'achat') {

    $Solde_fournisseur = Solde_fournisseur::trouve_par_id($id);
    if (isset($_POST['id_facture'])) {
 $Reglement =  Reglement_fournisseur::trouve_par_solde_and_facture($id,$id_facture,1);
 $Solde = $Solde_fournisseur->solde + $Reglement->somme + $Reglement->timbre;
} else{
   $Solde = $Solde_fournisseur->solde ;
}
if ($Reste_fact > 0 ) {
    if ($Reste_fact >= $Solde) {
     $rest = 0;
     $TOTAL = $Solde; 
    } else{
    $rest = $Solde - $Reste_fact ;
    $TOTAL = $Reste_fact;  
    }

}else{
	$rest= $Solde  ;
	$TOTAL = 0;
}


    $Data = array(
        'rest' => $rest,
        'Solde_fournisseur' => $Solde,
        'TOTAL' => $TOTAL
          );

    $returnData = array(
            'status' => 'ok',
            'msg' => 'Ecriture modifier avec succès.',
            'data' => $Data
        );
     echo json_encode($returnData);
    // var_dump($Reglement);
 } else if ($action == 'depence') {

    $Solde_fournisseur = Solde_fournisseur::trouve_par_id($id);
    if (isset($_POST['id_facture'])) {
 $Reglement =  Reglement_fournisseur::trouve_par_solde_and_facture($id,$id_facture,2);
 $Solde = $Solde_fournisseur->solde + $Reglement->somme + $Reglement->timbre;
} else{
   $Solde = $Solde_fournisseur->solde ;
}
if ($Reste_fact > 0 ) {
    if ($Reste_fact >= $Solde) {
     $rest = 0;
     $TOTAL = $Solde; 
    } else{
    $rest = $Solde - $Reste_fact ;
    $TOTAL = $Reste_fact;  
    }

}else{
    $rest= $Solde  ;
    $TOTAL = 0;
}


    $Data = array(
        'rest' => $rest,
        'Solde_fournisseur' => $Solde,
        'TOTAL' => $TOTAL
          );

    $returnData = array(
            'status' => 'ok',
            'msg' => 'Ecriture modifier avec succès.',
            'data' => $Data
        );
     echo json_encode($returnData);
    // var_dump($Reglement);

  } else if ($action == 'avoir_achat') {

    $Solde_fournisseur = Solde_fournisseur::trouve_par_id($id);
    if (isset($_POST['id_facture'])) {
 $Reglement =  Reglement_fournisseur::trouve_par_solde_and_facture($id,$id_facture,3);
 $Solde = $Solde_fournisseur->solde + $Reglement->somme + $Reglement->timbre;
} else{
   $Solde = $Solde_fournisseur->solde ;
}

if ($Reste_fact > 0 ) {

    $rest = $Solde + $Reste_fact ;
    $TOTAL = $Reste_fact;  
    

}else{
    $rest= $Solde  ;
    $TOTAL = 0;
}

    $Data = array(
        'rest' => $rest,
        'Solde_fournisseur' => $Solde,
        'TOTAL' => $TOTAL
          );

    $returnData = array(
            'status' => 'ok',
            'msg' => 'Ecriture modifier avec succès.',
            'data' => $Data
        );
     echo json_encode($returnData);
    // var_dump($Reglement);

 
 }else if ($action == 'vente') {
   
///////////////////////

    $Solde_client = Solde_client::trouve_par_id($id);
if (isset($_POST['id_facture'])) {
 $Reglement =  Reglement_client::trouve_par_solde_and_facture($id,$id_facture);
 $Solde = $Solde_client->solde + $Reglement->somme + $Reglement->timbre;
} else{
   $Solde= $Solde_client->solde ;
}


if ($Reste_fact > 0 ) {
    if ($Reste_fact >= $Solde) {
     $rest = 0;
     $TOTAL = $Solde; 
    } else{
    $rest = $Solde - $Reste_fact ;
    $TOTAL = $Reste_fact;  
    }

}else{
    $rest= $Solde  ;
    $TOTAL = 0;
}



    $Data = array(
        'rest' => $rest,
        'Solde_client' => $Solde,
        'TOTAL' => $TOTAL
          );

    $returnData = array(
            'status' => 'ok',
            'msg' => 'Ecriture modifier avec succès.',
            'data' => $Data
        );
     echo json_encode($returnData);
    // var_dump($Reglement);






 } else if ($action == 'avoir_vente') {
   
///////////////////////

    $Solde_client = Solde_client::trouve_par_id($id);
if (isset($_POST['id_facture'])) {
 $Reglement =  Reglement_client::trouve_par_solde_and_facture_avoir($id,$id_facture);
 $Solde = $Solde_client->solde + $Reglement->somme + $Reglement->timbre;
} else{
   $Solde= $Solde_client->solde ;
}


if ($Reste_fact > 0 ) {

    $rest = $Solde + $Reste_fact ;
    $TOTAL = $Reste_fact;  
    

}else{
    $rest= $Solde  ;
    $TOTAL = 0;
}



    $Data = array(
        'rest' => $rest,
        'Solde_client' => $Solde,
        'TOTAL' => $TOTAL
          );

    $returnData = array(
            'status' => 'ok',
            'msg' => 'Ecriture modifier avec succès.',
            'data' => $Data
        );
     echo json_encode($returnData);
    // var_dump($Reglement);





} ?>