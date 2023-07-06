<?php

require_once('bd.php');
require_once('fonctions.php');

class Update_achat_importation {
	
	protected static $nom_table="update_achat_importation";
	protected static $champs = array('id','id_achat', 'valeur_DA','id_facture','Num_facture','date_fact','id_societe', 'Quantite', 'Prix','Prix_devise','Contre_Valeur', 'id_fournisseur', 'id_prod','id_famille','Code','Designation', 'id_person','is_frais_annexes','Unite','Empl','Remise','shipping','Ht','Ht_devise','Ttva','Tva','timbre','total','somme_ht','somme_tva','somme_ttc','etat','update_achat','nbr_modif' );
	public $id;
	public $id_achat;
	public $id_facture;
	public $Num_facture;
	public $date_fact;
	public $id_societe;
	public $Quantite;
	public $Prix;
	public $Prix_devise;
	public $Contre_Valeur;
	public $id_fournisseur;
	public $id_prod;
	public $id_famille;
	public $Code;
	public $Designation;
	public $Unite;
	public $Empl;
	public $Remise;
	public $timbre;
	public $shipping;
	public $Ht;
	public $Ht_devise;
	public $valeur_DA;
	public $Ttva;
	public $Tva;
	public $total;
	public $somme_ht;
	public $somme_tva;
	public $somme_ttc;
	public $id_person;
	public $etat;
	public $update_achat;
	public $nbr_modif;
	public $is_frais_annexes;


 	public static function truncate_table($id) {
		return self::trouve_par_sql("delete from   ".self::$nom_table." WHERE etat  = 0 and update_achat = 0 and id_facture = {$id}");
  }
  public static function update_table($id) {
		return self::trouve_par_sql("update ".self::$nom_table." set update_achat = 1 WHERE etat  = 0 and update_achat = 0 and id_facture = {$id}");
  }
    public static function trouve_last_update_par_id_facture($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_facture = {$id} and update_achat = 1 and etat = 0  ORDER BY `id` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
 	public static function insert_achat($id) {
		return self::trouve_par_sql("INSERT INTO `update_achat_importation`( `id_achat`, `id_facture`,`Num_facture`,`date_fact`, `id_societe`, `id_fournisseur`, `id_prod`, `id_famille`, `id_person`, `Ligne`, `Code`, `Designation`, `Unite`, `Empl`, `Quantite`, `Prix`, `Prix_devise`, `Contre_Valeur`, `Remise`, `Ht`, `Ht_devise`, `Ttva`, `Tva`, `timbre`, `shipping`, `valeur_DA`, `total`, `somme_ht`, `somme_prix_devise`, `somme_tva`, `somme_ttc`, `is_frais_annexes`)SELECT `id`,`id_facture`,`Num_facture`, `date_fact`, `id_societe`, `id_fournisseur`, `id_prod`, `id_famille`, `id_person`, `Ligne`, `Code`, `Designation`, `Unite`, `Empl`, `Quantite`, `Prix`, `Prix_devise`, `Contre_Valeur`, `Remise`, `Ht`, `Ht_devise`, `Ttva`, `Tva`, `timbre`, `shipping`, `valeur_DA`, `total`, `somme_ht`, `somme_prix_devise`, `somme_tva`, `somme_ttc`,`is_frais_annexes` FROM achat_importation WHERE id_facture = {$id} ORDER BY `achat_importation`.`id` DESC ");
  }
public static function trouve_importation_par_facture($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	   return  self::trouve_par_sql($q);
	}

	public  function  existe_frais(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE id_prod = '".$this->id_prod."' and id_facture = '".$this->id_facture."' and id_person = '".$this->id_person."' and Num_facture = '".$this->Num_facture."'  AND etat = 0 and is_frais_annexes = 1 ";
    $sql .= "LIMIT 1";
		return !empty($result_array) ? array_shift($result_array) : false;
	}  


	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE id_prod = '".$this->id_prod."' and id_facture = '".$this->id_facture."' and id_person = '".$this->id_person."'  AND etat = 0 and is_frais_annexes = 0 ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	} 
	public static function count(){
	$users = self::not_admin();
	return count($users);
	}

	public static function trouve_achat_par_facture($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= "  and is_frais_annexes = 0";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_achat_notvalide_par_facture($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= "  and is_frais_annexes = 0";
	$q .= " and etat = 0";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_achat_valide_par_facture($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= "  and is_frais_annexes = 0";
	$q .= " and etat = 1";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_frais_par_facture($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= "  and is_frais_annexes = 1";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_frais_notvalide_par_facture($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= "  and is_frais_annexes = 1 and etat = 0";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_frais_valide_par_facture($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= "  and is_frais_annexes = 1";
	$q .= " and etat = 1";
    return  self::trouve_par_sql($q);
	}
		public static function trouve_somme_ht_frais_par_facture($id,$id_societe){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= "  and is_frais_annexes = 1";
	$q .= "  and id_societe ={$id_societe} ";
    return  self::trouve_par_sql($q);
	}
		public static function trouve_somme_ttc_frais_par_facture($id,$id_societe){
	$q =  "SELECT *, SUM(total - valeur_DA + timbre) as somme_ttc  FROM ".self::$nom_table;
	$q .= " WHERE id_facture ={$id}";
	$q .= "  and is_frais_annexes = 1";
	$q .= "  and id_societe ={$id_societe} GROUP by id ";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_frais_par_annexe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id ={$id}";
	$q .= "  and is_frais_annexes = 1";
    return  self::trouve_par_sql($q);
	}

	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }

  
		public static function trouve_facture_achat_par_id_g50($id){
			$q =  "SELECT * FROM ".self::$nom_table;
			$q .= " WHERE id_g50 ={$id}";
			return  self::trouve_par_sql($q);
			}
  
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_achat_vide_par_admin($id,$id_societe) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table ." where id_facture = 0 and id_societe = {$id_societe}   and id_person = {$id} and is_frais_annexes =0  ");
  }
  public static function trouve_frais_vide_par_admin($id,$id_societe) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table ." where id_facture = 0 and id_societe = {$id_societe}   and id_person = {$id} and is_frais_annexes = 1 ");
  }
  public static function somme_ht($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(Ht_devise) as somme_ht FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0  and is_frais_annexes = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function somme_tva($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(Tva) as somme_tva FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0  and is_frais_annexes = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_ttc($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(total) as somme_ttc FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0  and is_frais_annexes = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function somme_ht_frais($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(somme_ht) as somme_ht FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0 and is_frais_annexes = 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_tva_frais($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(Tva) as somme_tva FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0 and is_frais_annexes = 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_timbre_frais($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(timbre) as timbre FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0 and is_frais_annexes = 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_ttc_frais($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(total + timbre) as somme_ttc FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_facture = 0 and is_frais_annexes = 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_ht_frais_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(somme_ht) as somme_ht FROM ".self::$nom_table." where id_facture = {$id}  and is_frais_annexes = 1 and etat = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_tva_frais_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(Tva) as somme_tva FROM ".self::$nom_table." where  id_facture = {$id}  and is_frais_annexes = 1 and etat = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_timbre_frais_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(timbre) as timbre FROM ".self::$nom_table." where  id_facture = {$id}  and is_frais_annexes = 1 and etat = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_ttc_frais_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(total + timbre) as somme_ttc FROM ".self::$nom_table." where  id_facture = {$id}  and is_frais_annexes = 1 and etat = 0 and etat = 0 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_VA_frais_par_facture($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(valeur_DA) as valeur_DA FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_facture = {$id}  and is_frais_annexes = 1 and etat = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function somme_ht_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT id, id_fournisseur, SUM(Ht_devise) as somme_ht FROM ".self::$nom_table." where id_facture = {$id} and is_frais_annexes = 0 and etat = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_tva_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(Tva) as somme_tva FROM ".self::$nom_table." where id_facture = {$id} and is_frais_annexes = 0 and etat = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_ttc_par_facture($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(total) as somme_ttc FROM ".self::$nom_table." where id_facture = {$id} and is_frais_annexes = 0 and etat = 0");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_last_fournisseur_par_id_admin($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_facture = 0 and id_societe = {$id_societe} and id_person = {$id} and is_frais_annexes = 0  ORDER BY `id` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_last_fournisseur_par_id_facture($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_facture = {$id}  and is_frais_annexes = 0 and etat = 0 ORDER BY `id` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_achat_vide_par_id_prod($id,$id_prod,$id_person) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_facture = {$id} and id_prod = {$id_prod}  and etat = 0 and id_person = {$id_person} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_par_id_prod($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE  id_prod = {$id}  LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_par_id_fournisseur($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE (Designation ={$id} or id_fournisseur ={$id}) LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function trouve_frais_vide_par_id_prod($id,$id_person) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_facture = 0 and id_prod = {$id} AND id_person = {$id_person} and is_frais_annexes =1 LIMIT 1");
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