<?php 
require_once("../includes/initialiser.php");




if(($_POST['action'] == 'edit') && !empty($_POST['id'])){
    //update data

if (isset($_POST['id_piece'])) {
        $id_piece = htmlspecialchars(trim($_POST['id_piece'])); 
}

    $Debit = htmlspecialchars(trim($_POST['Debit'])) ;
    $Credit = htmlspecialchars(trim($_POST['Credit'])) ;
    $Annexe_Fiscale = htmlspecialchars(trim($_POST['Annexe_Fiscale'])) ;
    $Date_ecriture = htmlspecialchars(trim($_POST['Date_ecriture'])) ;
    $id = htmlspecialchars(trim($_POST['id'])); 
    $id_user = htmlspecialchars(trim($_POST['id_user'])); 
    $id_societe = htmlspecialchars(trim($_POST['id_societe'])); 
    $Ecriture_comptable = Ecriture_comptable::trouve_par_id($id);
    $Ecriture_comptable->debit = $Debit;
    $Ecriture_comptable->credit = $Credit;
    $Ecriture_comptable->Annexe_Fiscale = $Annexe_Fiscale;
    $Ecriture_comptable->date = $Date_ecriture;
    $UpdateEcriture_comptable = $Ecriture_comptable->modifier();

    if (isset($id_piece)) {

    $Pieces_comptables = Pieces_comptables::trouve_par_id($id_piece); 
    $somme_debit = Ecriture_comptable::somme_debit_par_piece($id_piece); 
    $somme_credit = Ecriture_comptable::somme_credit_par_piece($id_piece);
    $Pieces_comptables->somme_debit = $somme_debit->somme_debit;  
    $Pieces_comptables->somme_credit = $somme_credit->somme_credit;  
    $Pieces_comptables->modifier();  
    } else{
    $somme_debit = Ecriture_comptable::somme_debit($id_user,$id_societe);
    $somme_credit = Ecriture_comptable::somme_credit($id_user,$id_societe);  
    }

    if ($somme_debit->somme_debit > $somme_credit->somme_credit) {
           $diff = $somme_debit->somme_debit - $somme_credit->somme_credit;  }
    else { $diff = $somme_credit->somme_credit - $somme_debit->somme_debit; }
if ($somme_debit->somme_debit == $somme_credit->somme_credit) { $etat ='<span class="font-green"><strong>Équilibré</strong></span>';  } else{$etat ='<span class="font-red"><strong>Déséquilibré</strong></span>';}

    $userData = array(
        'Debit' => $Debit,
        'Credit' => $Credit,
        'Annexe_Fiscale' => $Annexe_Fiscale,
        'Date_ecriture' => $Date_ecriture,
        'etat' =>$etat,
        'somme_credit'=>$somme_credit->somme_credit,
        'somme_debit'=> $somme_debit->somme_debit,
        'diff' => $diff   );



    if($UpdateEcriture_comptable){
        $returnData = array(
            'status' => 'ok',
            'msg' => 'Ecriture modifier avec succès.',
            'data' => $userData
        );
    }else{
        $returnData = array(
            'status' => 'error',
            'msg' => 'Aucune modification , Veuillez réessayer.   ',
            'data' => $userData
        );
    }
    
    echo json_encode($returnData);
}
 ?>