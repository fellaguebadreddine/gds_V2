<?php 
require_once("../includes/initialiser.php");


$array= array();

$table_vantes = Vente::trouve_Ttva_vide_par_admin(22,22);
foreach ($table_vantes as $key => $table_vante) {
    array_push($array, $table_vante->Ttva);
}
//var_dump($array);
//echo "<br>";


if(count(array_unique($array)) === 1) {
  echo count(array_unique($array));
} else {
    echo 'mafihach <br>';
    echo count(array_unique($array));
}
?>


