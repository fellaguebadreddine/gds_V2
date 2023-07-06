<?php

require_once('bd.php');
require_once('fonctions.php');

class Facture_achat {
	
	protected static $nom_table="facture_achat";
	protected static $champs = array('id_facture','N_facture','Num_facture','id_fournisseur','id_societe', 'date_fac','date_valid','time', 'somme_ht','somme_tva','somme_ttc', 'mode_paiment', 'etat','random','timbre','Remise','id_g50','facture_scan');
	public $id_facture;
	public $N_facture;
	public $Num_facture;
	public $id_fournisseur;
	public $id_societe;
	public $date_fac;
	public $date_valid;
	public $time;
	public $somme_ht;
	public $somme_tva;
	public $timbre;
	public $Remise;
	public $somme_ttc;
	public $mode_paiment;
	public $etat;
	public $facture_scan;
	public $id_g50;
	public $random;
	
	public static function recherche($d1,$d2){
	global $bd ;
	
	$q =  "SELECT * FROM ".self::$nom_table."   WHERE date_valid BETWEEN  '{$d1}' and '{$d2}'  ;" ;
	return  self::trouve_par_sql($q);
		
	}
	public static function trouve_facture_achat($id){
		$q =  "SELECT * FROM ".self::$nom_table;
		$q .= " WHERE id_facture ={$id}";
		return  self::trouve_par_sql($q);
		}

	public static function trouve_facture_achat_par_id_g50($id){
			$q =  "SELECT * FROM ".self::$nom_table;
			$q .= " WHERE id_g50 ={$id}";
			return  self::trouve_par_sql($q);
			}
	public static function trouve_facture_par_id_fournisseur($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_fournisseur ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_facture_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_facture_par_societe_and_Exercice($id,$date_debut,$date_fin){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
		$q .= " AND date_fac BETWEEN  '{$date_debut}' and '{$date_fin}'";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_facture_par_societe_and_Exercice_and_id_fournisseur($id,$id_fournisseur,$date_debut,$date_fin){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	$q .= " AND id_fournisseur ={$id_fournisseur}";
	$q .= " AND date_fac BETWEEN  '{$date_debut}' and '{$date_fin}'";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_facture_non_valide_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE Etat =0";
	$q .= " and id_societe ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_facture_valide_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE Etat =1";
	$q .= " and id_societe ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_facture_valide_par_societe_fournisseur($id){
		$q =  "SELECT * FROM ".self::$nom_table;
		$q .= " WHERE Etat =1";
		$q .= " and id_societe ={$id}";
		$q .= " Group by id_fournisseur ";
		return  self::trouve_par_sql($q);
		}
	public static function trouve_facture_par_societe_etat_g50($id,$d1,$d2){
			$q =  "SELECT * FROM ".self::$nom_table;
			$q .= " WHERE id_societe ={$id}";
			$q .= " AND id_g50 = 0 ";
			$q .= " AND mode_paiment NOT IN ('A_terme')";
			$q .= " AND date_fac BETWEEN  '{$d1}' and '{$d2}'";
			return  self::trouve_par_sql($q);
	}
	public static function trouve_facture_par_societe_month($id,$d1,$d2){
			$q =  "SELECT * FROM ".self::$nom_table;
			$q .= " WHERE id_societe ={$id}";
			$q .= " AND id_g50 = 0 ";
			$q .= " AND mode_paiment NOT IN ('A_terme','Espèces')";
			$q .= " AND date_fac BETWEEN  '{$d1}' and '{$d2}'";
			return  self::trouve_par_sql($q);
	}
	public static function trouve_facture_par_societe_especes($id,$d1,$d2){
				$q =  "SELECT * FROM ".self::$nom_table;
				$q .= " WHERE id_societe ={$id}";
				$q .= " AND id_g50 = 0 ";
				$q .= " AND  timbre != 0";
				$q .= " AND date_fac BETWEEN  '{$d1}' and '{$d2}'";
				return  self::trouve_par_sql($q);
			}
	public static function trouve_facture_par_societe_aTerme($id,$d1,$d2){
				$q =  "SELECT * FROM ".self::$nom_table;
				$q .= " WHERE id_societe ={$id}";
				$q .= " AND mode_paiment LIKE 'A_terme'";
				$q .= " AND date_fac BETWEEN  '{$d1}' and '{$d2}'";
				return  self::trouve_par_sql($q);
			}
  public function nom_compler() {
    if(isset($this->nom) && isset($this->prenom)) {
      return $this->nom . " " . $this->prenom;
    } else {
      return "";
    }
  }
	public static function count_util(){
		global $bd;
		$q =  "SELECT count(*) FROM ".self::$nom_table;
		$q .= " WHERE type !='administrateur' "; 
		
		$result_array = $bd->requete($q);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
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
	

	
	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE id_fournisseur = '".$this->id_fournisseur."'  and date_fac =  '".$this->date_fac."' and Num_facture = '".$this->Num_facture."' ";
	//$sql .= "OR email = '".$this->email."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	

	
	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }
  
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_facture ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_par_id_fournisseur($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_fournisseur ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_par_random($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE random = {$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }  

   public static function trouve_last_par_societe($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_societe ={$id} ORDER BY `id_facture` DESC LIMIT 1");
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
	   // mais dans le cas o� il y a de jointure dans la requete.... 
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
	 return isset($this->id_facture)? $this->modifier() : $this->ajouter();
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
$sql .= " WHERE id_facture =". $bd->escape_value($this->id_facture) ;
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
$sql .= " WHERE id_facture =". $bd->escape_value($this->id_facture) ;
$sql .=" LIMIT 1";
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
	}

	}


?>