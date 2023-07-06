<?php
require_once("../includes/initialiser.php");

?>  

<?php	if(isset($_POST['id_famille']) ){
	$errors = array();
	$random_number = rand();
	
		// new object 

	if (!isset($_POST['id_famille'])||empty($_POST['id_famille'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Famille est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['code'])||empty($_POST['code'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Code est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['libelle'])||empty($_POST['libelle'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Famille est vides  !","Attention");
				  });
                  </script>';
	}
	
	
	if (!isset($_POST['nature'])||empty($_POST['nature'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ nature est vides  !","Attention");
				  });
                  </script>';
	}
	
	if (!isset($_POST['valeur_achat'])||empty($_POST['valeur_achat'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ valeur achat est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['date'])||empty($_POST['date'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ date achat est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['id_fournisseur'])||empty($_POST['id_fournisseur'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ fournisseur achat est vides  !","Attention");
				  });
                  </script>';
	}
	
	if (!isset($_POST['N_andi'])||empty($_POST['N_andi'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ N° ANDI est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['N_facture'])||empty($_POST['N_facture'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ N° Facture est vides  !","Attention");
				  });
                  </script>';
	}
	
	if (!isset($_POST['date_achat'])||empty($_POST['date_achat'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ date achat est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['date_debut_amortissement'])||empty($_POST['date_debut_amortissement'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ date debut amortissement est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['duree'])||empty($_POST['duree'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ duree est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['date_fin'])||empty($_POST['date_fin'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ date fin est vides  !","Attention");
				  });
                  </script>';
	}
	
	
	if (!isset($_POST['comptes_immobilisation'])||empty($_POST['comptes_immobilisation'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ comptes immobilisation est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_POST['comptes_amortissement'])||empty($_POST['comptes_amortissement'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ comptes amortissement est vides  !","Attention");
				  });
                  </script>';
	}
	
////////////// creat new objet immobilisation 

	$immobile = new Immobilisation();
		
	$immobile->id_societe = htmlentities(trim($_POST['id_societe']));
	$immobile->id_user = htmlentities(trim($_POST['id_user']));
	$immobile->id_famille = htmlentities(trim($_POST['id_famille']));
	$immobile->code = htmlentities(trim($_POST['code']));
	$immobile->libelle = htmlentities(trim($_POST['libelle']));
	$immobile->type_amortissement = htmlentities(trim($_POST['type_amortissement']));
	$immobile->nature = htmlentities(trim($_POST['nature']));
	$immobile->taux = htmlentities(trim($_POST['taux']));
	$immobile->valeur_achat = htmlentities(trim($_POST['valeur_achat']));
	$immobile->date = htmlentities(trim($_POST['date']));
	$immobile->id_fournisseur = htmlentities(trim($_POST['id_fournisseur']));
	$immobile->valeur_amortir_fiscal = htmlentities(trim($_POST['valeur_amortir_fiscal']));
	
	$immobile->N_andi = htmlentities(trim($_POST['N_andi']));
	$immobile->tva = htmlentities(trim($_POST['tva']));
	$immobile->autre_frais = htmlentities(trim($_POST['autre_frais']));
	$immobile->ttc = htmlentities(trim($_POST['ttc']));
	$immobile->N_facture = htmlentities(trim($_POST['N_facture']));
	$immobile->date_achat = htmlentities(trim($_POST['date_achat']));
	$immobile->date_debut_amortissement = htmlentities(trim($_POST['date_debut_amortissement']));
	$immobile->duree = htmlentities(trim($_POST['duree'])) * 30;
	$immobile->date_fin = htmlentities(trim($_POST['date_fin']));
	$immobile->cession = htmlentities(trim($_POST['cession']));
	$immobile->type_cession = htmlentities(trim($_POST['type_cession']));
	$immobile->prix_cession = htmlentities(trim($_POST['prix_cession']));
	$immobile->tva_cession = htmlentities(trim($_POST['tva_cession']));
	$immobile->ttc_cession = htmlentities(trim($_POST['ttc_cession']));
	$immobile->comptes_immobilisation = htmlentities(trim($_POST['comptes_immobilisation']));
	$immobile->comptes_amortissement = htmlentities(trim($_POST['comptes_amortissement']));
	$immobile->random =  $random_number;

	if(!empty($_POST['facture_scan'])){
	$immobile->facture_scan = htmlentities(trim($_POST['facture_scan']));
	}

	if (empty($errors)){	
		if ($immobile->existe()) {

		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.warning("Immobilisation- existe déja  !","Très Bien");
				  });
                  </script>';
			
		}else{
			if (empty($errors)){

			try {
				$bd->beginTransactions();
			
			$immobile->save();
// UPDATE UPLOAD SCAN
	 if (!empty($_POST['facture_scan'])){
	$upload = Upload:: trouve_par_id($_POST['facture_scan']);
	$upload->status = 1;
	$upload->save();
	}
/// ajouter amortissement
	if (!empty($_POST['date'])){
		
		$last_immobil=Immobilisation::trouve_par_random($random_number);
		
	// creates DateTime objects
	
		$dateDebutAmortissement =  htmlentities(trim($_POST['date_debut_amortissement']));// date debut amortissement
		$dateFinMois = date("Y-m-t", strtotime($dateDebutAmortissement)); // date du fin de mois amortissement
		$dateFinAmortissement =  $last_immobil->date_fin; // date fin amortissement
		
	// calculates the difference between DateTime objects	
		$difference = strtotime($dateFinMois) - strtotime($dateDebutAmortissement);
		
	//Calculate difference in days	
	$duree_days = abs($difference/(60 * 60)/24);
	
	////////////// calcule amortissement 
	
	$days = $last_immobil->duree ;
	$valeur_amortir = $last_immobil->valeur_achat + $last_immobil->autre_frais;
	$dotation = ($last_immobil->valeur_achat + $last_immobil->autre_frais) * ($duree_days + 1) /$days;
		
	
	////////////// loop days 
	
	$date_debut = date("Y-m-01", strtotime($dateDebutAmortissement)); // increment date
	// find date difference
	// $dateDiff = dateDiffInDays($date_debut, $dateDebutAmortissement);
	$x= $duree_days+1;	
	$rest = $days ;
	$cspt=0;
	while ($x <= $rest) {
		$cspt++;
		$randing=rand();
		
		$amortr = new Amortissement();	
		
		if ($cspt == 1){
		$amortr->date = $dateFinMois;
		$amortr->dure = $duree_days+1;
		$amortr->id_societe = htmlentities(trim($_POST['id_societe']));
		$amortr->valeur_amortir = $valeur_amortir;
		$amortr->dotation = $dotation;
		$amortr->dotation_cumulee = $dotation;
		$amortr->vnc = $valeur_amortir - $dotation ;
		$amortr->dotation_fiscale = ($last_immobil->valeur_amortir_fiscal * ($duree_days + 1)) / $days;
		$amortr->ecart = ($dotation) - (($last_immobil->valeur_amortir_fiscal * ($duree_days+1)) / $days);
		$amortr->rest_jours = $days;
		$amortr->id_immobil = $last_immobil->id;
		$amortr->random =  $randing;
		$amortr->save();
		$last_vnc=Amortissement::trouve_par_random($randing);	
		}else {	
		$rest =$rest - $last_vnc->dure;		
		$date_debut = date('Y-m-d', strtotime("+1 month", strtotime($date_debut)));// increment month
		$last_date= date('Y-m-d', strtotime("+ $rest days", strtotime($last_vnc->date)));// LAST DATE

			$amortr->random =  $randing;	
			$amortr->id_societe = htmlentities(trim($_POST['id_societe']));
			$amortr->id_immobil = $last_immobil->id;		
			
			if ($rest < 28){
			$amortr->dure =$rest;
			$amortr->rest_jours = $rest;
			$amortr->date = $last_date;
			}else{
				$amortr->dure =30;
				$amortr->rest_jours = $rest;
				$amortr->date = date("Y-m-t", strtotime($date_debut));
			}
			$amortr->valeur_amortir = $last_vnc->vnc ;			
			$amortr->dotation = $valeur_amortir * $amortr->dure / $days ;					
			$amortr->vnc = $amortr->valeur_amortir - $amortr->dotation ;
			$amortr->dotation_cumulee = $amortr->dotation + $last_vnc->dotation_cumulee;
			$amortr->dotation_fiscale = ($last_immobil->valeur_amortir_fiscal * ($amortr->dure)) / $days;
			$amortr->ecart = ($amortr->dotation ) - (($last_immobil->valeur_amortir_fiscal * ($amortr->dure)) / $days);
			$amortr->save();
		$last_vnc=Amortissement::trouve_par_random($randing);
		}
		
		
	}
	
	}
			$bd->commitTransactions();
	?>
	<script type="text/javascript">
			toastr.success("Immobilisation enregistrer  avec succes  !","Très Bien");
			
			$(document).ready(function(){
			$('#immobil_form input[type="text"]').val('');
			$('#immobil_form input[type="number"]').val('');
			$('#immobil_form input[type="date"]').val('');
			$(".select2me ").select2("val", "");
			$(".select ").select2("val", "");	
			
			});
			
	</script>
	<?php
		} catch (Exception $e) {
			    // If there's an error, rollback the transaction:
			$bd->rollbackTransactions();
		
			}
			}
		}
 		
		
		}
		
 		 
 		
}

?>
