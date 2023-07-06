<?php
require_once("../includes/initialiser.php");

?>  

<?php	if(isset($_GET['code']) ){
	$errors = array();
 	$random_number = rand();
	
		// new object 

	// new object admin 
	if (!isset($_GET['code'])||empty($_GET['code'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Code est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['libelle'])||empty($_GET['libelle'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Famille est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['type_amortissement'])||empty($_GET['type_amortissement'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ type amortissement est vides  !","Attention");
				  });
                  </script>';
	}
	if (!isset($_GET['duree'])||empty($_GET['duree'])){
		$errors[]='Le champ est vide';
		echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.error("Le champ Durée est vides  !","Attention");
				  });
                  </script>';
	}
	
	$famille_immobili = new Famille_immobilisation();
		
	$famille_immobili->id_societe = htmlentities(trim($_GET['id_societe']));
	$famille_immobili->id_user = htmlentities(trim($_GET['id_user']));
	$famille_immobili->code = htmlentities(trim($_GET['code']));
	$famille_immobili->libelle = htmlentities(trim($_GET['libelle']));
	$famille_immobili->type_amortissement = htmlentities(trim($_GET['type_amortissement']));
	$famille_immobili->duree = htmlentities(trim($_GET['duree']));
	
	if (empty($errors)){
if ($famille_immobili->existe()) {

	echo '<script type="text/javascript">
			$(document).ready(function(){
                  toastr.warning("Famille immobilisation- existe déja  !","Très Bien");
				  });
                  </script>';
			
		}else{
			$famille_immobili->save();?>
				  <script type="text/javascript">
			toastr.success("Famille immobilisation est enregistrer  avec succes  !","Très Bien");
			
			$(document).ready(function(){
			$('#immobil_form input[type="text"]').val('');
			$('#immobil_form input[type="number"]').val('');
			$('#immobil_form input[type="date"]').val('');
			
			$(".select ").select2("val", "");
			 var id_societe = <?php if (isset($famille_immobili->id_societe)) {echo $famille_immobili->id_societe;}  ?>;
			$('.item').load('ajax/display_famille_immobil.php?id_societe='+id_societe,function(){       
    });
			
			});
			
			</script>
			
			

	<?php
		

		}
 		
		
		}
		
 		 
 		
}

?>
