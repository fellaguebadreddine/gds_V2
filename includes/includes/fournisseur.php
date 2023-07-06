<?php

require_once('bd.php');
require_once('fonctions.php');

class Fournisseur {
	
	protected static $nom_table="fournisseur";    
	protected static $champs = array('id_fournisseur','id_societe','nom','Adresse','Ville', 'Postal','type_rc','Rc','Mf','Ai','Nis','Tel1','Mob1','Email','Activite','Compte','Agence','NCompte','auxiliere_achat','type','scan_fiche_fournisseur', 'Etat');
	public $id_fournisseur;
	public $id_societe;
	public $nom;
	public $Adresse;
	public $Ville;
	public $Postal;
	public $type_rc;
	public $Rc;
	public $Mf;
	public $Ai;
	public $Nis;
	public $Tel1;
	public $Mob1;
	public $Email;
	public $Activite;
	public $Compte;
	public $Solde;
	public $NCompte;
	public $auxiliere_achat;
	public $type;
	public $scan_fiche_fournisseur;
	public $Etat;
	

	public static function trouve_fournisseur_par_id_fournisseur($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_fournisseur ={$id}";
    return  self::trouve_par_sql($q);
	}
	
	
  public function nom_compler() {
    if(isset($this->nom) && isset($this->prenom)) {
      return $this->nom . " " . $this->prenom;
    } else {
      return "";
    }
  }

	public static function valider($login="", $mot_passe="") {
    global $bd;

    $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE login = '{$login}' ";
    $sql .= "AND mot_passe = '".SHA1($mot_passe)."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
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
    $sql .= "WHERE `Mf` =   '".$this->Mf."' ";
  	$sql .= "AND `Rc` = '".$this->Rc."' ";
		$sql .= "AND `id_societe` = ".$this->id_societe." ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	

	

	public static function count(){
	
	$users = self::not_admin();
	return count($users);
	}
	public static function trouve_fournisseur_etranger_par_societe($id){
		$q =  "SELECT * FROM ".self::$nom_table;
		$q .= " WHERE Etat =1";
		$q .= " AND id_societe ={$id}";
		$q .= " AND TYPE = 3";
		return  self::trouve_par_sql($q);
		}
	public static function trouve_fournisseur_service_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE Etat =1";
	$q .= " AND id_societe ={$id}";
	$q .= " AND TYPE = 2";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_fournisseur_produit_par_societe($id){
		$q =  "SELECT * FROM ".self::$nom_table;
		$q .= " WHERE Etat =1";
		$q .= " AND id_societe ={$id}";
		$q .= " AND TYPE = 1";
		return  self::trouve_par_sql($q);
		}
	public static function trouve_valid_par_societe($id){
		$q =  "SELECT * FROM ".self::$nom_table;
		$q .= " WHERE Etat =1";
		$q .= " and id_societe ={$id}";
		return  self::trouve_par_sql($q);
		}
	
	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }
  	public static function trouve_monque() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE `nb_piece`<= `quant_min`");
  }
  public static function trouve_par_re($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE ref_pro  ='$id' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_fournisseur  ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_par_code($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_fournisseur  ={$id} LIMIT 1");
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
	 return isset($this->id_fournisseur)? $this->modifier() : $this->ajouter();
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
$sql .= " WHERE id_fournisseur =". $bd->escape_value($this->id_fournisseur) ;
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