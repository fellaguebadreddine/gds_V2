<?php
require_once("../includes/initialiser.php");

 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 


    $id_Journal = htmlspecialchars(trim($_GET['id_Journal']));
    $id_societe = htmlspecialchars(trim($_GET['id_societe']));
    $date_comptable = htmlspecialchars(trim($_GET['date_comptable']));
    
    $reference = htmlspecialchars(trim($_GET['reference']));
    if (isset($reference)) {
        $reference = str_replace("_"," ", $reference);
    }
    $libelle = htmlspecialchars(trim($_GET['libelle']));
    if (isset($libelle)) {
        $libelle = str_replace("_"," ", $libelle);
    }
	$id_piece = htmlspecialchars(trim($_GET['id']));
	$Pieces_comptables = Pieces_comptables::trouve_par_id($id_piece);
	$Pieces_comptables->ref_piece = $reference ;
	$Pieces_comptables->libelle = $libelle ;
	$Pieces_comptables->date = $date_comptable ;
	$Pieces_comptables->journal = $id_Journal ;
   	$Pieces_comptables->modifier();

   	$Ecriture_comptables = Ecriture_comptable::trouve_ecriture_par_piece($id_piece); 
   	foreach($Ecriture_comptables as $Ecriture_comptable){

   	$Ecriture_comptable->date = $date_comptable;
	$Ecriture_comptable->ref_piece = $reference;
	$Ecriture_comptable->lib_piece = $libelle;
	$Ecriture_comptable->journal = $id_Journal;
	$Ecriture_comptable->modifier();

   	} 
	 }

?>