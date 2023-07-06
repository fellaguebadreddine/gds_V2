<?php
require_once("../includes/initialiser.php");

if (isset($_POST['id_facture'])) {
$id_fact =  htmlspecialchars(intval($_POST['id_facture'])) ;
      $Facture = Facture_vente::trouve_par_id($id_fact);
}
      $Journal= htmlspecialchars(trim($_POST['Journal']));
      $Facture->etat = 1;
      $Facture->Montant_paiement = htmlspecialchars(trim($_POST['Montant']));
      $Facture->date_reglement = htmlspecialchars(trim($_POST['date_reglement']));
switch ($Journal) {
            case '1':
                  $Facture->mode_paiment ="Chèque";
            break;
            case '2':
                  $Facture->mode_paiment ="Espèces";
            break;
            case '3':
                  $Facture->mode_paiment ="Versement Bancaire";
            break;
            case '4':
                 $Facture->mode_paiment ="Virement Bancaire";
            break;
            case '5':
                  $Facture->mode_paiment ="Carte de crédit";
            break;
            case '6':
                  $Facture->mode_paiment ="Billet à ordre";
            break;
            case '7':
                  $Facture->mode_paiment ="A Terme";
            break;
      }
$Facture->save();
           echo '<script type="text/javascript">
                  toastr.success("Paiement enregistrer  avec succes","Très bien !");
                  </script>';
?>  