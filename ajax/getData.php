<?php
require_once("../includes/initialiser.php");

$sommeht = 0;
$sommehtEspece = 0;
//  avant


// autre que espece
if (isset($_POST['id_facture']) ){

	$id = $_POST['id_facture'];
	
		foreach( $id as $ids){
			
			$fact = Facture_vente::trouve_facture_vente($ids);
			
			foreach ($fact as $facts){ 
			
			$sommeht += $facts->somme_ht ;
			$affiche = number_format($sommeht , 2);
			$return_arr = array("somme_ht"=>$affiche);
			
			}
			
		}
}else {
	$id = 'vide';
	$return_arr = array("somme_ht"=>'00.00');
}

// espece
if (isset($_POST['id_factureEspese'])){

	
	$id_Espece = $_POST['id_factureEspese'];

		foreach( $id_Espece as $id_Especes){
			
			$factt = Facture_vente::trouve_facture_vente($id_Especes);
			
			foreach ($factt as $facts){ 
			
			$sommehtEspece += $facts->somme_ht ;
			$affichea = number_format($sommehtEspece , 2);
			$return_arr_es = array("somme_ht_ecpece"=>$affichea);
			
			}
			
		}
	
}else{
	$id_Espece = 'vide';
	$return_arr_es = array("somme_ht_ecpece"=>'00.00');
}


$newArray = array_push($return_arr, $return_arr_es);

// Converting the array to comma separated string
echo json_encode($return_arr);
 



?>