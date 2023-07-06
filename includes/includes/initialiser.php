<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
$project_path = dirname(__FILE__);
$project_path = str_replace('includes', '', $project_path);
defined('SITE_ROOT') ? null : 
	define('SITE_ROOT',$project_path);
	
defined('SITE_PATH') ? null : 
	define('SITE_PATH',dirname($_SERVER['PHP_SELF']));
    
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.'includes');

// charger fichier config  avant tout
require_once(LIB_PATH.DS.'config.php');

// charger fonctions
require_once(LIB_PATH.DS.'fonctions.php');

// charger core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'bd.php');


// charger  classes
require_once(LIB_PATH.DS.'accounts.php');
require_once(LIB_PATH.DS.'societes.php');
require_once(LIB_PATH.DS.'banque.php');
require_once(LIB_PATH.DS.'caisse.php');
require_once(LIB_PATH.DS.'compte.php');
require_once(LIB_PATH.DS.'tva.php');
require_once(LIB_PATH.DS.'tva_tab.php');
require_once(LIB_PATH.DS.'produit.php');
require_once(LIB_PATH.DS.'caisse_societe.php');
require_once(LIB_PATH.DS.'unite.php');
require_once(LIB_PATH.DS.'famille.php');
require_once(LIB_PATH.DS.'client.php');
require_once(LIB_PATH.DS.'fournisseur.php');
require_once(LIB_PATH.DS.'vente.php');
require_once(LIB_PATH.DS.'achat.php');
require_once(LIB_PATH.DS.'facture_vente.php');
require_once(LIB_PATH.DS.'facture_achat.php');
require_once(LIB_PATH.DS.'update_achat.php');
require_once(LIB_PATH.DS.'update_vente.php');
require_once(LIB_PATH.DS.'reglement_client.php');
require_once(LIB_PATH.DS.'update_reglement_client.php');
require_once(LIB_PATH.DS.'solde_client.php');
require_once(LIB_PATH.DS.'solde_fournisseur.php');
require_once(LIB_PATH.DS.'reglement_fournisseur.php');
require_once(LIB_PATH.DS.'update_reglement_fournisseur.php');
require_once(LIB_PATH.DS.'frais_annexe.php');
require_once(LIB_PATH.DS.'facture_importation.php');
require_once(LIB_PATH.DS.'achat_importation.php');
require_once(LIB_PATH.DS.'update_achat_importation.php');
require_once(LIB_PATH.DS.'compte_comptable.php');
require_once(LIB_PATH.DS.'journaux.php');
require_once(LIB_PATH.DS.'pieces.php');
require_once(LIB_PATH.DS.'auxiliere.php');
require_once(LIB_PATH.DS.'facture_avoir_vente.php');
require_once(LIB_PATH.DS.'facture_avoir_achat.php');
require_once(LIB_PATH.DS.'avoir_vente.php');
require_once(LIB_PATH.DS.'avoir_achat.php');
require_once(LIB_PATH.DS.'compte_auxiliere.php');
require_once(LIB_PATH.DS.'ecriture_comptable.php');
require_once(LIB_PATH.DS.'upload.php');
require_once(LIB_PATH.DS.'bilan_actif.php');
require_once(LIB_PATH.DS.'bilan_passif.php');
require_once(LIB_PATH.DS.'tcr.php');
require_once(LIB_PATH.DS.'mouv_stock.php');
require_once(LIB_PATH.DS.'compte_table.php');
require_once(LIB_PATH.DS.'type_societe.php');
require_once(LIB_PATH.DS.'wilayas.php');
require_once(LIB_PATH.DS.'commune.php');
require_once(LIB_PATH.DS.'annexe_2.php');
require_once(LIB_PATH.DS.'annexe_3.php');
require_once(LIB_PATH.DS.'annexe_4.php');
require_once(LIB_PATH.DS.'annexe_5.php');
require_once(LIB_PATH.DS.'tab_annexe_5.php');
require_once(LIB_PATH.DS.'annexe_6.php');
require_once(LIB_PATH.DS.'annexe_7.php');
require_once(LIB_PATH.DS.'tab_releve_pertes_valeurs_creances.php');
require_once(LIB_PATH.DS.'tab_releve_pertes_valeurs_actions.php');
require_once(LIB_PATH.DS.'mode_paiement.php');
require_once(LIB_PATH.DS.'mode_paiement_societe.php');
require_once(LIB_PATH.DS.'g50.php');
require_once(LIB_PATH.DS.'taxe_activite.php');
require_once(LIB_PATH.DS.'ibs.php');
require_once(LIB_PATH.DS.'etat_annuel_societe.php');
require_once(LIB_PATH.DS.'formule.php');
require_once(LIB_PATH.DS.'production.php');
require_once(LIB_PATH.DS.'lot_prod.php');
require_once(LIB_PATH.DS.'depense.php');
require_once(LIB_PATH.DS.'facture_depense.php');
require_once(LIB_PATH.DS.'taxe_valeur_ajoutee.php');
require_once(LIB_PATH.DS.'deductions_tva.php');
require_once(LIB_PATH.DS.'nature_operation.php');
require_once(LIB_PATH.DS.'releve_comptes.php');
require_once(LIB_PATH.DS.'famille_immobilisation.php');
require_once(LIB_PATH.DS.'immobilisation.php');
require_once(LIB_PATH.DS.'amortissement.php');
require_once(LIB_PATH.DS.'detail_formule.php');
require_once(LIB_PATH.DS.'consomation_production.php');


//require_once(LIB_PATH.DS.'contact_us.php');

?>