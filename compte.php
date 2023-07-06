<?php

require_once('bd.php');
require_once('fonctions.php');

class Compte {
	
	protected static $nom_table="compte";
	protected static $champs = array('id','id_banque', 'id_societe', 'num_compte','solde','comptes_achat','journal','auxiliere_achat','compte_defaut');
	public $id;
	public $id_banque;
	public $id_societe;
	public $num_compte;
	public $solde;
	public $comptes_achat;
	public $journal;
	public $auxiliere_achat;
	public $compte_defaut;



	public static function trouve_par_societe($id_societe){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe = $id_societe";
    return  self::trouve_par_sql($q);
	}

	public function date_der(){
	global $bd;
     $sql  = "UPDATE ".self::$nom_table." SET ";
     $sql .= "date_der  = '".mysql_datetime()."' ";
	 $sql .= " WHERE id =".$this->id." ";
	 $sql .= "LIMIT 1 ";
	
	 $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE id_banque = '".$this->id_banque."'";
	$sql .= "AND id_societe = '".$this->id_societe."'";
	$sql .= "AND num_compte = '".$this->num_compte."'";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}


	

	public static function count(){
	
	$users = self::not_admin();
	return count($users);
	}
	
	public static function not_sup_admin(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='super_administrateur'";
    return  self::trouve_par_sql($q);
	}


	
	public static function trouve_compte_par_societe($id_societe){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ='{$id_societe}'";
	$q .= " ORDER BY `id` ";
    return  self::trouve_par_sql($q);
	}	
	public static function trouve_compte_par_societe_facture($id_societe){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ='{$id_societe}'";
	$q .= " ORDER BY `id` ASC LIMIT 1";
	 return  self::trouve_par_sql($q);
	}
	
	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }
  public static function trouve_fact_vide_client_libre() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table ." where num_fac = 0 and num_clie = 0 ");
  }
  
  public static function trouve_fact_vide_non_client_libre() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table ." where num_fac = 0 and num_clie != 0 ");
  }
  
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_par_id_banque($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_banque ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_fact_num($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE num_fac= {$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
public static function trouve_fact_num_clie($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE num_fac= {$id} and num_clie = 0 LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    
  public static function trouve_fact_vide() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table ." where num_fac = 0 ");
  }
    public static function trouve_par_last($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where num_fac != '0'  ORDER BY `id_vent` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_client_par_facture($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where num_fac = {$id} and num_clie != 0   ORDER BY `id` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_par_last_client_not_fact($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where num_fac  != '0'  ORDER BY `id` and num_clie != 0 ORDER BY `id`  DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
     public static function trouve_par_last_client($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where num_fac  = '0' and num_clie != 0 ORDER BY `id_vent` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_par_classee($classe=0){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE classe ='{$classe}'";
	$q .= " AND type ='eleve'";
    return  self::trouve_par_sql($q);
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