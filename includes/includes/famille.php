<?php

require_once('bd.php');
require_once('fonctions.php');

class Famille {
	
	protected static $nom_table="famille";
	protected static $champs = array('id_famille','id_societe','famille','id_tva','comptes_achat','comptes_vente','comptes_stock','comptes_consommation','auxiliere_achat','auxiliere_vente','auxiliere_stock','auxiliere_consommation','Ht','Ht_achat','total_tva','timbre','somme_ttc','Compte');
	public $id_famille;
	public $id_societe;
	public $famille;
	public $id_tva;
	public $comptes_achat;
	public $comptes_vente;
	public $comptes_stock;
	public $comptes_consommation;
	public $auxiliere_achat;
	public $auxiliere_vente;
	public $auxiliere_stock;
	public $auxiliere_consommation;
	public $Ht;
	public $Ht_achat;
	public $total_tva;
	public $timbre;
	public $somme_ttc;
	public $Compte;
	


	//////////////////  production  /////////////////////////
		public static function calcule_Ht_par_famille_and_facture_production_mp($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_stock,comptes_consommation,auxiliere_consommation,auxiliere_stock, SUM(consomation_production.Ht_production) AS Ht FROM consomation_production,famille WHERE consomation_production.id_famille = famille.id_famille AND id_production = {$id_facture} AND famille.id_societe ={$id_societe} GROUP by consomation_production.id_famille");
	}	
		public static function calcule_Ht_par_famille_and_facture_production_pf($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_stock,comptes_consommation,auxiliere_consommation,auxiliere_stock, SUM(production.cout*production.qty) AS Ht FROM production,famille,produit WHERE production.produit_finale =produit.id_pro and  produit.id_famille = famille.id_famille  AND id = {$id_facture} AND famille.id_societe ={$id_societe} GROUP by produit.id_famille");
	}	
	//////////////////:achat  /////////////////////////
		public static function calcule_Ht_par_famille_and_facture_achat($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_stock,comptes_achat,auxiliere_achat,auxiliere_stock, SUM(achat.Ht) AS Ht FROM achat,famille WHERE achat.id_famille = famille.id_famille AND id_facture = {$id_facture} AND famille.id_societe ={$id_societe} GROUP by achat.id_famille");
	}
			public static function calcule_TVA_par_famille_and_facture_achat($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_achat,auxiliere_achat, SUM(Tva) as total_tva FROM achat,tva WHERE achat.id_tva = tva.id_tva AND id_facture = {$id_facture} and tva.id_societe = {$id_societe} GROUP by achat.id_tva HAVING total_tva >0 ");
	}

			public static function calcule_timbre_par_famille_and_facture_achat($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_achat,auxiliere_achat, timbre FROM `facture_achat`,societe WHERE facture_achat.id_societe= societe.id_societe and id_facture = {$id_facture} and societe.id_societe = {$id_societe} and facture_achat.timbre > 0 ");
	}

public static function calcule_somme_ttc_par_famille_and_facture_achat($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT Compte,auxiliere_achat, `somme_ttc` FROM `facture_achat`,fournisseur WHERE facture_achat.id_fournisseur= fournisseur.id_fournisseur and id_facture = {$id_facture} and fournisseur.id_societe = {$id_societe} ");
	}	
	////////////////// avoir achat  /////////////////////////
		public static function calcule_Ht_par_famille_and_facture_achat_avoir($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_stock,comptes_achat,auxiliere_achat,auxiliere_stock, SUM(avoir_achat.Ht) AS Ht FROM avoir_achat,famille WHERE avoir_achat.id_famille = famille.id_famille AND id_facture = {$id_facture} AND famille.id_societe ={$id_societe} GROUP by avoir_achat.id_famille");
	}
			public static function calcule_TVA_par_famille_and_facture_achat_avoir($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_achat,auxiliere_achat, SUM(Tva) as total_tva FROM avoir_achat,tva WHERE avoir_achat.id_tva = tva.id_tva AND id_facture = {$id_facture} and tva.id_societe = {$id_societe} GROUP by avoir_achat.id_tva HAVING total_tva >0 ");
	}

			public static function calcule_timbre_par_famille_and_facture_achat_avoir($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_achat,auxiliere_achat, timbre FROM `facture_avoir_achat`,societe WHERE facture_avoir_achat.id_societe= societe.id_societe and id_facture = {$id_facture} and societe.id_societe = {$id_societe} and facture_avoir_achat.timbre > 0 ");
	}

public static function calcule_somme_ttc_par_famille_and_facture_achat_avoir($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT Compte,auxiliere_achat, `somme_ttc` FROM `facture_avoir_achat`,fournisseur WHERE facture_avoir_achat.id_fournisseur= fournisseur.id_fournisseur and id_facture = {$id_facture} and fournisseur.id_societe = {$id_societe} ");
	}	

	
		//////////////////:achat importation  /////////////////////////
		public static function calcule_Ht_par_famille_and_facture_achat_importation($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_stock,comptes_achat,auxiliere_achat,auxiliere_stock, SUM(achat_importation.Contre_Valeur) AS Ht FROM achat_importation,famille WHERE achat_importation.id_famille = famille.id_famille AND id_facture = {$id_facture} AND famille.id_societe ={$id_societe} GROUP by achat_importation.id_famille");
	}


						/////////////////////////// vente ////////////////////////////////

			public static function calcule_Ht_par_famille_and_facture_vente($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_stock,comptes_consommation,comptes_vente,auxiliere_vente,auxiliere_consommation, SUM(vente.Ht_achat) AS Ht_achat,round( SUM( vente.Ht - ((vente.Ht*facture_vente.Remise)/(facture_vente.somme_ht+facture_vente.Remise))),2) AS Ht FROM facture_vente, vente,famille WHERE vente.id_famille = famille.id_famille AND vente.id_facture = facture_vente.id_facture and vente.id_facture = {$id_facture} AND famille.id_societe ={$id_societe} GROUP by vente.id_famille");
	}

		public static function calcule_TVA_par_famille_and_facture_vente($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_vente,auxiliere_vente, sum( Tva) as tva ,sum( vente.Ttva *( vente.Ht - ((vente.Ht*facture_vente.Remise)/(facture_vente.somme_ht+facture_vente.Remise)))) AS total_tva FROM facture_vente, vente,tva WHERE vente.id_facture= facture_vente.id_facture and vente.id_tva = tva.id_tva AND facture_vente.id_facture = {$id_facture} and tva.id_societe = {$id_societe} GROUP by vente.id_tva HAVING total_tva > 0 ");
	}

			public static function calcule_timbre_par_famille_and_facture_vente($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_vente,auxiliere_vente, timbre FROM `facture_vente`,societe WHERE facture_vente.id_societe= societe.id_societe and id_facture = {$id_facture} and societe.id_societe = {$id_societe} and facture_vente.timbre > 0 ");
	}

public static function calcule_somme_ttc_par_famille_and_facture_vente($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT Compte,auxiliere_achat, `somme_ttc` FROM `facture_vente`,Client WHERE facture_vente.id_client= Client.id_client and id_facture = {$id_facture} and Client.id_societe = {$id_societe} ");
	}	

 					////////////////////// avoir vente /////////////////////////////////

			public static function calcule_Ht_par_famille_and_facture_vente_avoir($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_stock,comptes_consommation,comptes_vente,auxiliere_vente,auxiliere_consommation, SUM(avoir_vente.Ht_achat) AS Ht_achat,round( SUM( avoir_vente.Ht - ((avoir_vente.Ht*facture_avoir_vente.Remise)/(facture_avoir_vente.somme_ht+facture_avoir_vente.Remise))),2) AS Ht FROM facture_avoir_vente, avoir_vente,famille WHERE avoir_vente.id_famille = famille.id_famille AND avoir_vente.id_facture = facture_avoir_vente.id_facture and avoir_vente.id_facture = {$id_facture} AND famille.id_societe ={$id_societe} GROUP by avoir_vente.id_famille");
	}

		public static function calcule_TVA_par_famille_and_facture_vente_avoir($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_vente,auxiliere_vente, sum( Tva) as tva ,sum( avoir_vente.Ttva *( avoir_vente.Ht - ((avoir_vente.Ht*facture_avoir_vente.Remise)/(facture_avoir_vente.somme_ht+facture_avoir_vente.Remise)))) AS total_tva FROM facture_avoir_vente, avoir_vente,tva WHERE avoir_vente.id_facture= facture_avoir_vente.id_facture and avoir_vente.id_tva = tva.id_tva AND facture_avoir_vente.id_facture = {$id_facture} and tva.id_societe = {$id_societe} GROUP by avoir_vente.id_tva HAVING total_tva > 0 ");
	}

			public static function calcule_timbre_par_famille_and_facture_vente_avoir($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT comptes_vente,auxiliere_vente, timbre FROM `facture_avoir_vente`,societe WHERE facture_avoir_vente.id_societe= societe.id_societe and id_facture = {$id_facture} and societe.id_societe = {$id_societe} and facture_avoir_vente.timbre > 0 ");
	}

public static function calcule_somme_ttc_par_famille_and_facture_vente_avoir($id_facture,$id_societe){
	return self::trouve_par_sql("SELECT Compte,auxiliere_achat, `somme_ttc` FROM `facture_avoir_vente`,Client WHERE facture_avoir_vente.id_client= Client.id_client and id_facture = {$id_facture} and Client.id_societe = {$id_societe} ");
	}	





		public static function trouve_famille_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_famille_par_id_famille($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_famille ={$id}";
    return  self::trouve_par_sql($q);
	}

		
	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE famille = '".$this->famille."'";
    $sql .= "and id_societe = '".$this->id_societe."'";
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
  
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_famille={$id} LIMIT 1");
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
	 return isset($this->id_famille)? $this->modifier() : $this->ajouter();
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
$sql .= " WHERE id_famille =". $bd->escape_value($this->id_famille) ;
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