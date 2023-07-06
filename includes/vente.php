<?php

require_once('bd.php');
require_once('fonctions.php');

class Vente {
	
	protected static $nom_table="vente";
	protected static $champs = array('id','Type', 'id_facture','date_fact','id_societe', 'Quantite', 'Prix', 'id_client', 'id_prod','id_lot','id_famille','Code','Designation', 'id_person','Unite','Empl','Remise','Ht_achat','Ht','id_tva','Ttva','Tva','total','somme_ht','somme_tva','somme_ttc');
	
	public $id;
	public $Type;
	public $id_facture;
	public $date_fact;
	public $id_societe;
	public $Quantite;
	public $Prix;
	public $id_client;
	public $id_prod;
	public $id_lot;
	public $id_famille;
	public $Code;
	public $Designation;
	public $id_person;
	public $Unite;
	public $Empl;
	public $Remise;
	public $Ht_achat;
	public $Ht;
	public $id_tva;
	public $Ttva;
	public $Tva;
	public $total;
	public $somme_ht;
	public $somme_tva;
	public $somme_ttc;


	
		public static function trouve_vente_par_facture_exono_espece($id){
			$q =  " SELECT vente.Ht  FROM facture_vente LEFT JOIN vente ON facture_vente.id_facture = vente.id_facture JOIN produit ON vente.id_prod = produit.id_pro";
			$q .= " WHERE vente.id_facture ={$id}";
			$q .= " AND facture_vente.timbre != 0";
			$q .= " AND produit.exonere =1 ";
			return  self::trouve_par_sql($q);
		}
	public static function trouve_vente_par_facture_exono_non_espece($id){
			$q =  " SELECT vente.Ht FROM facture_vente LEFT JOIN vente ON facture_vente.id_facture = vente.id_facture JOIN produit ON vente.id_prod = produit.id_pro";
			$q .= " WHERE vente.id_facture ={$id}";
			$q .= " AND facture_vente.timbre = 0";
			$q .= " AND produit.exonere =1 ";
			return  self::trouve_par_sql($q);
		}
	
	
  public function nom_compler() {
    if(isset($this->nom) && isset($this->prenom)) {
      return $this->nom . " " . $this->prenom;
    } else {
      return "";
    }
  }
	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE    id_lot = '".$this->id_lot."' and id_prod = '".$this->id_prod."'  and id_facture = '0' and id_person = '".$this->id_person."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}   
	public static function count(){
	$users = self::not_admin();
	return count($users);
	}

	public static function trouve_vente_par_facture($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_vente_par_facture_tva_9($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= " AND Ttva = '0.09'";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_vente_par_facture_tva_9_groupe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= " AND Ttva = '0.09' GROUP by id_facture";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_vente_par_facture_tva_id($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture  ={$id}";
	   return  self::trouve_par_sql($q);
	}
	public static function trouve_vente_par_facture_tva_19($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= " AND Ttva = '0.19'";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_vente_par_facture_tva_19_groupe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= " AND Ttva = '0.19' GROUP by id_facture";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_vente_par_facture_tva_0($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= " AND Ttva = '0.00'";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_vente_par_facture_tva_0_groupe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= " AND Ttva = '0.00' GROUP by id_facture";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_vente_par_facture_tva($id){
		$result_array = self::trouve_par_sql("SELECT  SUM(Ht) as somme_ht  FROM ".self::$nom_table." WHERE  id_facture ={$id}");
		return !empty($result_array) ? array_shift($result_array) : false;

		}
	public static function trouve_somme_par_facture_tva_19( $id){
		$result_array = self::trouve_par_sql("SELECT id_facture,SUM(Ht) as somme_ht  FROM ".self::$nom_table." WHERE  id_facture = {$id} AND Ttva =0.19");
		return !empty($result_array) ? array_shift($result_array) : false;

		}
public static function trouve_somme_par_facture_tva_09( $id){
		$result_array = self::trouve_par_sql("SELECT  id_facture,SUM(Ht) as somme_ht FROM ".self::$nom_table." WHERE id_facture = {$id} AND Ttva =0.09");
		return !empty($result_array) ? array_shift($result_array) : false;

		}
	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }

  

  
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_vente_par_id_facture($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_facture ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_vente_vide_par_admin($id,$id_societe) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table ." where id_facture = 0 and id_societe = {$id_societe}   and id_person = {$id}  ");
  }
  public static function trouve_Ttva_vide_par_admin($id,$id_societe) {
		return self::trouve_par_sql("SELECT Ttva FROM ".self::$nom_table ." where id_facture = 0 and id_societe = {$id_societe}   and id_person = {$id}  ");
  }
    public static function somme_Ht_achat($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(Ht_achat) as somme_ht FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_ht($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(Ht) as somme_ht FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_tva($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(Tva) as somme_tva FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_ttc($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(total) as somme_ttc FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function somme_Ht_achat_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(Ht_achat) as somme_ht FROM ".self::$nom_table." where id_facture = {$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function somme_ht_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(Ht) as somme_ht FROM ".self::$nom_table." where id_facture = {$id}");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_tva_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(Tva) as somme_tva FROM ".self::$nom_table." where id_facture = {$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_ttc_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(total) as somme_ttc FROM ".self::$nom_table." where id_facture = {$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function remise_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(Remise) as Remise FROM ".self::$nom_table." where id_facture = {$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_last_client_par_id_admin($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_facture = 0 and id_societe = {$id_societe} and id_person = {$id}  ORDER BY `id` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_last_client_par_id_facture($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_facture = {$id}  ORDER BY `id` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_vente_vide_par_id_prod($id,$id_person) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_facture = 0 and id_lot = {$id} and id_person = {$id_person} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_par_id_prod($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE  id_prod = {$id}  LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_qte_par_lot_and_date($id,$date_fin) {
    $result_array = self::trouve_par_sql("SELECT IFNULL( SUM(Quantite),0)  as Quantite FROM ".self::$nom_table." where id_facture !=0 and id_lot = {$id} and date_fact > '{$date_fin}'  ");
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