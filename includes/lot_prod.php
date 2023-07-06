<?php

require_once('bd.php');
require_once('fonctions.php');

class Lot_prod {
	
	protected static $nom_table="lot_prod";    
	protected static $champs = array('id','id_achat','code_lot','id_societe','id_prod','id_facture','qte','qte_initial','prix_achat','prix_vente','date_lot','type_achat' );
	public $id;
	public $id_achat;
	public $code_lot;
	public $id_societe;
	public $id_prod;
	public $id_facture;
	public $qte;
	public $qte_initial;
	public $prix_achat;
	public $prix_vente;
	public $date_lot;
	public $type_achat;
	
	

	public static function update_prix_vente_produit_par_societe($pourcentage,$id){
	$q .= "UPDATE `lot_prod` SET  lot_prod.prix_vente = lot_prod.prix_achat + lot_prod.prix_achat* $pourcentage WHERE `id_societe` = {$id}   AND IF(lot_prod.qte = lot_prod.qte_initial, TRUE, FALSE);";
    return  self::trouve_par_sql($q);
	}

		public static function trouve_lot_par_produit($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_prod ={$id}";
	$q .= " and qte > 0 order by date_lot asc ";
    return  self::trouve_par_sql($q);
	}
		public static function trouve_lot_par_produit_order_by_id($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_prod ={$id}";
	$q .= " and qte > 0 order by id asc ";
    return  self::trouve_par_sql($q);
	}
			public static function trouve_lot_par_produit_order_by_date($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_prod ={$id}";
	$q .= " and qte > 0 order by date_lot asc ";
    return  self::trouve_par_sql($q);
	}
	
		public static function trouve_tous_lot_par_produit($id,$date_fin){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_prod ={$id}";
	$q .= "  and date_lot <='{$date_fin}'";
    return  self::trouve_par_sql($q);
	}
	public static function recherche($d1,$nav_societe){
	global $bd ;
	$q =  "SELECT * FROM ".self::$nom_table." WHERE  id_societe ='{$nav_societe}' and date BETWEEN '00/00/0000' AND'{$d1}'  " ;
	return  self::trouve_par_sql($q);
		
	}
	
	
	public static function trouve_formule_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	 return  self::trouve_par_sql($q);
	}	
	
	

	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE designation = '".$this->designation."' ";
    $sql .= "and id_societe = '".$this->id_societe."'";
	//$sql .= "OR email = '".$this->email."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	public static function trouve_formule_par_id($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_prod ={$id}";
	 return  self::trouve_par_sql($q);
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
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id  ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_first_lot($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_prod  ={$id} and qte > 0 order by date_lot 	asc LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_last_lot($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_prod  ={$id}  order by date_lot 	DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_lot_par_id_achat($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_achat  ={$id} and type_achat = 1 LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function trouve_lot_par_facture_and_type_and_prod($id=0,$id_prod,$id_facture) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE type_achat  ={$id} and id_prod = {$id_prod} and id_facture = {$id_facture} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
      public static function trouve_lot_par_type_and_prod($id=0,$id_prod) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE type_achat  ={$id} and id_prod = {$id_prod} LIMIT 1");
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
	 return isset($this->id)? $this->modifier() : $this->ajouter();
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
$sql .= " WHERE id =". $bd->escape_value($this->id) ;
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
$sql .= " WHERE id =". $bd->escape_value($this->id) ;
$sql .=" LIMIT 1";
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
	}

	}


?>