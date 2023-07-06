<?php
require_once("../includes/initialiser.php");

$sommeht = 0;


if (isset($_POST['id_facture']) ){

	$id = $_POST['id_facture'];
	

foreach( $id as $ids){
	
	$fact = Achat_importation::trouve_importation_par_facture($ids);
	
	foreach ($fact as $facts){ 
	
	$sommeht += $facts->Ht ;
	$affiche = number_format($sommeht , 2);
	$return_arr = array("somme_ht_importation"=>$affiche);
	
	}
	
}
	
}else {
	$id = 'vide';
	$return_arr = array("somme_ht_importation"=>'00');
}


// Converting the array to comma separated string
echo json_encode($return_arr);

?>