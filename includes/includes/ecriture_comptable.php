<?php

require_once('bd.php');
require_once('fonctions.php');

class Ecriture_comptable {
	
	protected static $nom_table="ecriture_comptable";
	protected static $champs = array('id','id_piece','date','id_societe','id_compte','code_comptable','id_auxiliere', 'id_person','ref_piece','lib_piece','journal','debit','credit','Annexe_Fiscale','somme_debit','somme_credit');
	public $id;
	public $id_piece;
	public $date;
	public $id_societe;
	public $id_compte;
	public $code_comptable;
	public $id_auxiliere;
	public $id_person;
	public $ref_piece;
	public $lib_piece;
	public $journal;
	public $debit;
	public $credit;
	public $Annexe_Fiscale;
	public $somme_debit;
	public $somme_credit;



////////////////////// annexe_3 //////////////////////////////////////

	public static function trouve_credit_debit_par_date_and_2_attribut($id,$att1,$att2,$date_db,$date_fin){
    $result_array = self::trouve_par_sql("SELECT sum(debit) as debit,SUM(credit) as credit,SUM(debit-credit) as somme_debit, SUM(credit-debit) as somme_credit, SUM(Annexe_Fiscale) as Annexe_Fiscale FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND code_comptable NOT REGEXP '".$att2."' AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
	public static function trouve_credit_debit_par_date_and_1_attribut($id,$att1,$date_db,$date_fin){
    $result_array = self::trouve_par_sql("SELECT sum(debit) as debit,SUM(credit) as credit,SUM(debit-credit) as somme_debit, SUM(credit-debit) as somme_credit, SUM(Annexe_Fiscale) as Annexe_Fiscale FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."'  AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
 	public static function trouve_credit_debit_par_date_and_2_attribut_anterieur($id,$att1,$att2,$date_db){
    $result_array = self::trouve_par_sql("SELECT sum(debit) as debit,SUM(credit) as credit,SUM(debit-credit) as somme_debit, SUM(credit-debit) as somme_credit, SUM(Annexe_Fiscale) as Annexe_Fiscale FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND code_comptable NOT REGEXP '".$att2."' AND  date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  	public static function trouve_credit_debit_par_date_and_1_attribut_anterieur($id,$att1,$date_db){
    $result_array = self::trouve_par_sql("SELECT sum(debit) as debit,SUM(credit) as credit,SUM(debit-credit) as somme_debit, SUM(credit-debit) as somme_credit, SUM(Annexe_Fiscale) as Annexe_Fiscale FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND  date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;

  }
////////////////////  annexe 3 tab immobilisation ////////////////////


  public static function trouve_immob_debit_par_date_and_2_attribut($id,$att1,$att2,$date_db,$date_fin){
	$q = "SELECT id_piece,SUM(debit) as debit, SUM(credit) as credit  FROM  ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND code_comptable NOT REGEXP '".$att2."' AND date BETWEEN '{$date_db}' AND '{$date_fin}'   GROUP by  id_piece ";
    return  self::trouve_par_sql($q);
  }
  public static function trouve_immob_debit_par_date_and_1_attribut($id,$att1,$date_db,$date_fin){
	$q = "SELECT id_piece,SUM(debit) as debit, SUM(credit) as credit  FROM  ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date BETWEEN '{$date_db}' AND '{$date_fin}'   GROUP by  id_piece ";
    return  self::trouve_par_sql($q);
  }

    public static function trouve_tva_par_id_piece($id=0) {
    $result_array = self::trouve_par_sql("SELECT SUM(debit) as debit, SUM(credit) as credit FROM ".self::$nom_table." WHERE id_piece={$id} AND code_comptable REGEXP '^445' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
/////////// mouvement de stocks/tcr //////////////////////////////

	public static function trouve_debit_credit_par_date_and_mouvement($id,$att1,$date_db,$date_fin){
    $result_array = self::trouve_par_sql("SELECT sum(debit) as debit,SUM(credit) as credit,SUM(debit-credit) as somme_debit, SUM(credit-debit) as somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
	public static function trouve_debit_credit_par_date_and_mouvement_anterieur($id,$att1,$date_db){
    $result_array = self::trouve_par_sql("SELECT sum(debit) as debit,SUM(credit) as credit,SUM(debit-credit) as somme_debit, SUM(credit-debit) as somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND  date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
	public static function trouve_solde_debut_exercice($id,$att1,$date_db){
    $result_array = self::trouve_par_sql("SELECT SUM(debit - credit) as somme_debit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
	public static function trouve_solde_fin_exercice($id,$att1,$date_fin){
    $result_array = self::trouve_par_sql("SELECT SUM(debit - credit) as somme_debit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date <= '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;

  }	public static function trouve_Tab_fluctuation($id,$att1,$date_db,$date_fin){
	$q = "SELECT code_comptable, debit,credit,SUM(debit-credit) as somme_debit, SUM(credit-debit) as somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date BETWEEN '{$date_db}' AND '{$date_fin}' GROUP BY id_compte ";
    return  self::trouve_par_sql($q);
  }

/////////// BILAN PASSIF //////////////////////////////

	public static function trouve_somme_credit_par_date_and_2_attribut($id,$att1,$att2,$date_db,$date_fin){
    $result_array = self::trouve_par_sql("SELECT SUM(credit - debit ) as somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND code_comptable NOT REGEXP '".$att2."' AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

	public static function trouve_somme_credit_par_date_and_1_attribut($id,$att1,$date_db,$date_fin){
    $result_array = self::trouve_par_sql("SELECT SUM(credit - debit ) as somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
		
	public static function trouve_somme_credit_par_date_and_2_attribut_anterieur($id,$att1,$att2,$date_db){
    $result_array = self::trouve_par_sql("SELECT SUM(credit - debit ) as somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND code_comptable NOT REGEXP '".$att2."' AND  date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

	public static function trouve_somme_credit_par_date_and_1_attribut_anterieur($id,$att1,$date_db){
    $result_array = self::trouve_par_sql("SELECT SUM(credit - debit ) as somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

/////////// BILAN ACTIF //////////////////////////////

	public static function trouve_somme_debit_par_date_and_2_attribut($id,$att1,$att2,$date_db,$date_fin){
    $result_array = self::trouve_par_sql("SELECT SUM(debit - credit) as somme_debit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND code_comptable NOT REGEXP '".$att2."' AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

	public static function trouve_somme_debit_par_date_and_1_attribut($id,$att1,$date_db,$date_fin){
    $result_array = self::trouve_par_sql("SELECT SUM(debit - credit) as somme_debit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
		
	public static function trouve_somme_debit_par_date_and_2_attribut_anterieur($id,$att1,$att2,$date_db){
    $result_array = self::trouve_par_sql("SELECT SUM(debit - credit) as somme_debit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND code_comptable NOT REGEXP '".$att2."' AND  date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

	public static function trouve_somme_debit_par_date_and_1_attribut_anterieur($id,$att1,$date_db){
    $result_array = self::trouve_par_sql("SELECT SUM(debit - credit) as somme_debit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable REGEXP '".$att1."' AND date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }


	//// Recherche 
	public static function recherche_par_1_attribue($d1,$d2){
	global $bd ;
	
	$q =  "SELECT * FROM ".self::$nom_table."   WHERE date BETWEEN  '{$d1}' and '{$d2}';" ;
	return  self::trouve_par_sql($q);
		
	}
	public static function recherche_par_2_attribue($attribue1,$attribue2,$d1,$d2,$c1,$c2){
	global $bd ;
	
	$q =  "SELECT * FROM ".self::$nom_table."   WHERE '{$attribue1}' BETWEEN  '{$d1}' and '{$d2}' AND '{$attribue2}' BETWEEN  '{$d1}' and '{$d2}' ;" ;
	return  self::trouve_par_sql($q);
		
	}
	
///////////////////////////// Balance /////////////////////////	

	 	public static function count_row_balance_periode($id,$class,$date_fin){
		global $bd;
	$q =  "SELECT id_compte  FROM ".self::$nom_table;
	$q .= " WHERE id_societe ='".$id."'";
	$q .= " AND code_comptable like '".$class."%' ";
	$q .= " AND `date` <= '{$date_fin}' GROUP BY id_compte ";
		$result_array = $bd->requete($q);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}

	public static function trouve_balance_date_fin_par_societe($id,$class,$date_fin){
	$q =  "SELECT id_compte,code_comptable,SUM(debit - credit) as debit,SUM(credit - debit) as credit FROM ".self::$nom_table;
	$q .= " WHERE id_societe ='".$id."'";
	$q .= " AND code_comptable like '".$class."%' ";
	$q .= " AND `date` <= '{$date_fin}' GROUP BY id_compte  ORDER BY id_compte  ASC";
    return  self::trouve_par_sql($q);
	}	
	public static function trouve_balance_date_periode_par_societe($id,$class,$date_db,$date_fin){
	$q =  "SELECT id_compte,code_comptable,SUM(debit - credit) as debit,SUM(credit - debit) as credit FROM ".self::$nom_table;
	$q .= " WHERE id_societe ='".$id."'";
	$q .= " AND code_comptable like '".$class."%' ";
	$q .= " AND date BETWEEN '{$date_db}' AND '{$date_fin}' GROUP BY id_compte  ORDER BY id_compte  ASC";
    return  self::trouve_par_sql($q);
	}	

		    public static function calcul_somme_solde_balance_par_societe($id,$class,$date_fin) {
    $result_array = self::trouve_par_sql("  SELECT SUM(case when debit>0 then debit else 0 end) AS somme_debit, SUM(case when credit>0 then credit else 0 end) AS somme_credit FROM ( SELECT SUM(debit-credit)AS debit, SUM(credit-debit) AS credit FROM ".self::$nom_table." WHERE id_societe = '".$id."' AND date <= '{$date_fin}'  AND code_comptable LIKE '".$class."%' GROUP by id_compte ) AS alias ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

	    public static function calcul_somme_total_solde_balance_par_societe($id,$date_fin) {
    $result_array = self::trouve_par_sql(" SELECT SUM(case when debit>0 then debit else 0 end) AS somme_debit, SUM(case when credit>0 then credit else 0 end) AS somme_credit FROM ( SELECT SUM(debit-credit)AS debit, SUM(credit-debit) AS credit FROM ".self::$nom_table." WHERE id_societe = '".$id."' AND date <= '{$date_fin}'   GROUP by id_compte ) AS alias ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

		    public static function calcul_debit_credit_balance_periode($id,$date_db,$date_fin) {
    $result_array = self::trouve_par_sql("SELECT sum(debit) AS debit, SUM(credit) AS credit ,SUM(debit - credit) as somme_debit FROM  ".self::$nom_table." WHERE id_compte ='".$id."'  AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

	    public static function calcul_somme_balance_periode_par_societe($id,$class,$date_db,$date_fin) {
    $result_array = self::trouve_par_sql("SELECT SUM(debit) AS somme_debit, SUM(credit) AS somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable like '".$class."%'  AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
	    public static function calcul_somme_total_balance_periode_par_societe($id,$date_db,$date_fin) {
    $result_array = self::trouve_par_sql("SELECT SUM(debit) AS somme_debit, SUM(credit) AS somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."'  AND date BETWEEN '{$date_db}' AND '{$date_fin}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }


   		public static function calcul_debit_credit_balance_periode_anterieur($id,$date_db) {
    $result_array = self::trouve_par_sql("SELECT sum(debit) AS debit, SUM(credit) AS credit FROM  ".self::$nom_table." WHERE id_compte ='".$id."'  AND date < '{$date_db}'  ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
	    public static function calcul_somme_balance_periode_anterieur_par_societe($id,$class,$date_db) {
    $result_array = self::trouve_par_sql("SELECT SUM(debit) AS somme_debit, SUM(credit) AS somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."' AND code_comptable like '".$class."%'  AND date < '{$date_db}'  ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
	    public static function calcul_somme_total_balance_periode_anterieur_par_societe($id,$date_db) {
    $result_array = self::trouve_par_sql("SELECT SUM(debit) AS somme_debit, SUM(credit) AS somme_credit FROM ".self::$nom_table." WHERE id_societe ='".$id."'  AND date < '{$date_db}' ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }



////////////////////// Grand livre //////////////////////////////////


  	 	public static function count_row_Grand_livre_periode($id,$id_societe,$date_db,$date_fin){
		global $bd;
	$q =  "SELECT id_compte FROM ".self::$nom_table;
	$q .= " WHERE id_compte ={$id} and id_societe  = {$id_societe}";
	$q .= " AND date BETWEEN '{$date_db}' AND '{$date_fin}'";
		$result_array = $bd->requete($q);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	public static function trouve_ecriture_periode_par_id_compte($id,$id_societe,$date_db,$date_fin){
	$q =  "SELECT id_compte,date,code_comptable,journal,lib_piece,ref_piece,debit,credit,SUM(debit-credit) AS somme_debit   FROM ".self::$nom_table;
	$q .= " WHERE id_compte ={$id} and id_societe  = {$id_societe}";
	$q .= " AND date BETWEEN '{$date_db}' AND '{$date_fin}' ";
	$q .= " GROUP by id ORDER BY `date` ASC";
    return  self::trouve_par_sql($q);
	}
//////////////////////////////////////////////////////


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
    $sql .= "WHERE id_compte = '".$this->id_compte."' and id_piece = '0' and id_person = '".$this->id_person."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}   
	public static function count(){
	$users = self::not_admin();
	return count($users);
	}

	public static function trouve_ecriture_par_piece($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_piece ={$id}";
	$q .= " ORDER BY `id` ASC";
    return  self::trouve_par_sql($q);
	}
	public static function delete_ecriture_par_piece($id){
	$q =  "DELETE FROM ".self::$nom_table;
	$q .= " WHERE id_piece ={$id}";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_ecriture_par_societe($id){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
	$q .= " AND id_piece !=0";
    return  self::trouve_par_sql($q);
	}
	public static function trouve_ecriture_par_societe_and_Exercice($id,$date_debut,$date_fin){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_societe ={$id}";
		$q .= " AND date BETWEEN  '{$date_debut}' and '{$date_fin}'";
    return  self::trouve_par_sql($q);
	}

	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }

 	public static function count_row(){
		global $bd;
		$q =  "SELECT count(*) FROM ".self::$nom_table;
		$q .= " WHERE type !='administrateur' "; 
		
		$result_array = $bd->requete($q);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
	public static function trouve_par_id_piece($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_piece={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_compte_vide_par_admin($id,$id_societe) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table ." where id_piece = 0 and id_societe = {$id_societe}   and id_person = {$id}  ");
  }
  public static function somme_credit($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(credit) as somme_credit FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_piece = 0 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_debit($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT SUM(debit) as somme_debit FROM ".self::$nom_table." where id_societe = {$id_societe}   and id_person = {$id} and id_piece = 0 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function somme_credit_par_piece($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(credit) as somme_credit FROM ".self::$nom_table." where id_piece = {$id}");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function somme_debit_par_piece($id) {
    $result_array = self::trouve_par_sql("SELECT SUM(debit) as somme_debit FROM ".self::$nom_table." where id_piece = {$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function trouve_last_ecriture_par_id_admin($id,$id_societe) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_piece = 0 and id_societe = {$id_societe} and id_person = {$id}  ORDER BY `id` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_last_ecriture_par_id_piece($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_piece = {$id}  ORDER BY `id` DESC LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function trouve_vente_vide_par_id_compte($id,$id_person) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE   id_piece = 0 and id_compte = {$id} and id_person = {$id_person} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
 	public static function trouve_ecriture_par_id_pieces($id){
		$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE id_piece ={$id}";
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