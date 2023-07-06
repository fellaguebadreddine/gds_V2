<?php

require_once('bd.php');
require_once('fonctions.php');

class Produit {
	
	protected static $nom_table="produit";    
	protected static $champs = array('id_pro','code','id_societe','Designation', 'id_unite','id_famille','stock','stock_initial','initial', 'alerte','tva','id_tva','prix_achat','prix_vente', 'date','Remise','pourcentage_prix_vente','is_importation','matiere_premiere','is_production','exonere','stockable','immobil','img_produit','random');
	public $id_pro;
	public $code;
	public $id_societe;
	public $Designation;
	public $id_unite;
	public $id_famille;
	public $stock;
	public $stock_initial;
	public $initial;
	public $alerte;
	public $tva;
	public $id_tva;
	public $prix_achat;
	public $prix_vente;
	public $date;
	public $Remise;
	public $pourcentage_prix_vente;
	public $is_importation;
	public $matiere_premiere;
	public $is_production;
	public $exonere;
	public $stockable;
	public $immobil;
	public $img_produit;
	public $random;
	

	public static function trouve_produit_par_societe_and_date_lot($id,$date_fin){
	$q =  "SELECT * FROM `lot_prod`,produit WHERE produit.id_pro = lot_prod.id_prod  ";
	$q .= " and lot_prod.`id_societe`  ={$id}";
	$q .= "  and lot_prod.date_lot <='{$date_fin}'";
	$q .= "  GROUP by produit.id_pro ORDER BY `lot_prod`.`date_lot` DESC";
    return  self::trouve_par_sql($q);
	}

   public static function Calcul_stock_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT SUM(lot_prod.qte)as stock FROM `produit`,lot_prod WHERE produit.id_pro = lot_prod.id_prod and id_pro = {$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
	public static function update_pourcentage_prix_vente_produit_par_societe($pourcentage,$id){
	$q =  " UPDATE ".self::$nom_table." SET" ;
	$q .= " pourcentage_prix_vente  ={$pourcentage}";
	$q .= " WHERE id_societe ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_produit_par_societe_alert($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	$q .= " AND stock <= alerte";
    return  self::trouve_par_sql($q);
	}
	public static function recherche($d1,$nav_societe){
	global $bd ;
	$q =  "SELECT * FROM ".self::$nom_table." WHERE  id_societe ='{$nav_societe}' and date BETWEEN '00/00/0000' AND'{$d1}'  " ;
	return  self::trouve_par_sql($q);
		
	}
	public static function trouve_produit_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	return  self::trouve_par_sql($q);
	}	
	
	public static function trouve_produit_vente_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	$q .= " and matiere_premiere = 0";
	return  self::trouve_par_sql($q);
	}	
	public static function trouve_produit_achat_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	$q .= " and is_importation = 0";
	$q .= " AND is_production = 0";
	return  self::trouve_par_sql($q);
	}	
	
	public static function trouve_matiere_premiere_par_societe($id){
		$q =  "SELECT * FROM ".self::$nom_table;
		$q .= " WHERE id_societe ={$id}";
		$q .= " AND matiere_premiere = 1";
		return  self::trouve_par_sql($q);
		}	
	public static function trouve_produit_production($id){
			$q =  "SELECT * FROM ".self::$nom_table;
			$q .= " WHERE id_societe ={$id}";
			$q .= " AND is_production = 1";
			return  self::trouve_par_sql($q);
	}
	public static function trouve_produit_immobil($id){
			$q =  "SELECT * FROM ".self::$nom_table;
			$q .= " WHERE id_societe ={$id}";
			$q .= " AND immobil = 1";
			return  self::trouve_par_sql($q);
	}
	public static function trouve_produit_stockable($id){
		$q =  "SELECT * FROM ".self::$nom_table;
		$q .= " WHERE id_societe ={$id}";
		$q .= " AND stockable = 1";
		return  self::trouve_par_sql($q);
}
public static function trouve_produit_non_stockable($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	$q .= " AND stockable = 0";
	$q .= " AND immobil = 0";
	return  self::trouve_par_sql($q);
}
	public static function trouve_produit_importation_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	$q .= " and is_importation = 1";
    return  self::trouve_par_sql($q);
	}

	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE code = '".$this->code."' ";
    $sql .= "and id_societe = '".$this->id_societe."'";
	//$sql .= "OR email = '".$this->email."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	public  function  existe_name(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE Designation like '".$this->Designation."' ";
    $sql .= "and id_societe = '".$this->id_societe."'";
	//$sql .= "OR email = '".$this->email."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	public static function count(){
	
	$users = self::not_admin();
	return count($users);
	}

	
	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }
  	public static function trouve_monque() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE `nb_piece`<= `quant_min`");
  }
   public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_pro  ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_par_random($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE random = {$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  } 
  
  // pour que ne tompa dans des erreurs foux qu'on selection tous "SELECT * FROM" 
  public static function trouve_par_sql($sql="") {
    global $bd;
    $result_set = $bd->requete($sql);
    $object_array = array();
    while ($row = $bd->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
	/* // on peu utiliser la fonction predefinit mysqli_fetch_object
	   // mais dans le cas où il y a de jointure dans la requete.... 
	while ($object = $bd->fetch_object($result_set)){
	  $object_array[] = $object;
	}
	*/
    return $object_array;
  }

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->login 	= $record['login'];
		// $object->mot_passe 	= $record['mot_passe'];
		// $object->nom = $record['nom'];
		// $object->prenom 	= $record['prenom'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
	  $object_vars = $this ->attributes();
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $object_vars);
	}

	public function save(){
	 // A new record won't have an id yet.
	 return isset($this->id_pro)? $this->modifier() : $this->ajouter();
	}
	
	protected function attributes(){
	// return an array of attribute keys and their values
	 $attributes = array();
	 foreach(self::$champs as $field){
	     if(property_exists($this, $field)){
		     $attributes[$field] = $this->$field; 
		 }
	 }
	 return $attributes;
	}
	
	protected function sanitized_attributes(){
	 global $bd;
	 $clean_attributes = array();
	 // sanitize the values before submitting
	 // note : does not alter the actual value of each attribute
	 foreach($this->attributes() as $key => $value){
	   $clean_attributes[$key] = $bd->escape_value($value);
	 }
	  return $clean_attributes;
	}
	
	public function ajouter(){
	 global $bd;
	 $attributes = $this->sanitized_attributes();
	 $sql = "INSERT INTO ".self::$nom_table."(";
	 $sql .= join(", ", array_keys($attributes));
	 $sql .= ") VALUES (' ";
	 $sql .= join("', '", array_values($attributes));
	 $sql .= "')";
	 if($bd->requete($sql)){
	     $this->id = $bd->insert_id();
		 return true;
	 }else{
	     return false;
	 }
	}
	
    public function modifier(){
global $bd;
$attributes = $this->sanitized_attributes();
$attribute_pairs = array();
foreach($attributes as $key => $value){
 $attribute_pairs[] = "{$key}='{$value}'";
}
$sql = "update ".self::$nom_table." SET ";
$sql .= join(", ", $attribute_pairs);
$sql .= " WHERE id_pro =". $bd->escape_value($this->id_pro) ;
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
}
	    public function modifier_num(){
global $bd;
$attributes = $this->sanitized_attributes();
$attribute_pairs = array();
foreach($attributes as $key => $value){
 $attribute_pairs[] = "{$key}='{$value}'";
}
$sql = "update ".self::$nom_table." SET ";
$sql .= "n_immatriculation = '".$this->n_immatriculation."' ";
$sql .= " WHERE id =". $bd->escape_value($this->id) ;
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
}
	
public function supprime(){
global $bd;
$sql = "DELETE FROM ".self::$nom_table;
$sql .= " WHERE id_pro =". $bd->escape_value($this->id_pro) ;
$sql .=" LIMIT 1";
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
	}

	}


?>