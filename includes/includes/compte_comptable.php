<?php

require_once('bd.php');
require_once('fonctions.php');

class Compte_comptable {
	
	protected static $nom_table="compte_comptable";
	protected static $champs = array('id','code','libelle','aux','prefixe','id_societe');
	public $id;
	public $code;
	public $libelle;
	public $aux;
	public $prefixe;
	public $id_societe;
	
	public static function trouve_par_compt_achat_par_societe($id) {
		$result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_societe ={$id} AND code = '645240' LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
	  }
	public static function trouve_par_compt_tva_immobilisation_par_societe($id) {
		$result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_societe ={$id} AND code = '445620' LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
	  }
	public static function trouve_par_compt_Dotation_amortissement_par_societe($id) {
		$result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_societe ={$id} AND code = '681000' LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
	  }
	public static function trouve_par_compt_vente_par_societe($id) {
		$result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_societe ={$id} AND code = '447240' LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
	  }
	public static function trouve_par_compt_TVA_par_societe($id) {
		$result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_societe ={$id} AND code = '445660' LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
	}
	public static function trouve_par_compt_vente_TVA_par_societe($id) {
		$result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_societe ={$id} AND code = '445710' LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
	}
	public static function trouve_par_compt_caisse_par_societe($id) {
		$result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_societe ={$id} AND code = '530000' LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
	}
	public static function trouve_compte_comptable_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_compte_comptable_par_societe_id($id,$id_societe){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id_societe}";
	$q .= " AND id ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_compte_par_id_compte($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_compte_par_code_compte($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE code ={$id}";
    return  self::trouve_par_sql($q);
	}
		
	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE code = '".$this->code."'";
	$sql .= "AND id_societe = '".$this->id_societe."'";
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
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." ORDER BY code ASC");
  }
  
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

	public static function trouve_par_code($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE code={$id} LIMIT 1");
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