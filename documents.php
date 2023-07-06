<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Accounts::trouve_par_id($session->id_utilisateur);
	if (empty($user)) {
	$user = Client::trouve_par_id($session->id_utilisateur);
	}
	$accestype = array('administrateur','utilisateur');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 
}
?>
<?php
if ($user->type == "administrateur"){

	if (isset($_GET['action']) && $_GET['action'] =='charger' ) {

$active_submenu = "documents";
$action = 'charger';
	}else if (isset($_GET['action']) && $_GET['action'] =='delete_image' ) {

$active_submenu = "documents";
$action = 'delete_image';
	}

}
$titre = "ThreeSoft | Documents ";
$active_menu = "documents";
$header = array('table');
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
$thisday=date('Y-m-d');
?>
<?php 
  
if(isset($_POST['submit']) && $action == 'charger'){
	
   $file = str_replace (" ", "_", $nav_societe->Dossier );
   $nom = 'scan/upload/'.$file.''; // Le nom du répertoire à créer
    if (is_dir($nom)) {
                      'Le répertoire existe déjà!';  
                      }
    // Création du nouveau répertoire
    else { 
          mkdir($nom, 0777, true);
         'Le répertoire '.$nom.' vient d\'être créé!';      
          }
    // Include the database configuration file
    // File upload configuration
    $targetDir = 'scan/upload/'.$file.'/';
    $allowTypes = array('jpg','png','jpeg','JPG','pdf');
    $id_societe = $nav_societe->id_societe;
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';

    if(!empty(array_filter($_FILES['files']['name']))){
        foreach($_FILES['files']['name'] as $key=>$val){ 

            // File upload path
            $fileName = basename($_FILES['files']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;
            
            // Check whether file type is valid
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                    // Image db insert sql
                   
                    $insertValuesSQL .= "('".$id_societe."','".$fileName."' ),";
                }else{
                    $errorUpload .= $_FILES['files']['name'][$key].', ';
                }
            }else{
                $errorUploadType .= $_FILES['files']['name'][$key].', ';
            }
        }
        
        if(!empty($insertValuesSQL)){
            $insertValuesSQL = trim($insertValuesSQL,',');
            // Insert image file name into database
            $insert = $bd->requete("INSERT INTO upload (id_societe,img) VALUES $insertValuesSQL");
            if($insert){
            $errorUpload = !empty($errorUpload)?'Upload Error: '.$errorUpload:'';
            $errorUploadType = !empty($errorUploadType)?'File Type Error: '.$errorUploadType:'';
            $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
            $errorMsg = '<span style= "color : #e80707; font-size: medium;" >'.$errorMsg.'</span>';

                $msg_positif = "Les images sont téléchargés avec succès..".$errorMsg;
            }else{
                $msg_error = "Désolé, une erreur s'est produite lors de l'envoi des images.";
            }
        }
    }
    

}
// delete image
	if(isset($_POST['delete_file']) && $action == 'delete_image'){
		 if ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
		$delet_img = Upload::trouve_par_id($id);
		 }
	if (array_key_exists('delete_file', $_POST)) {
	  $filename = $_POST['delete_file'];
	  if (file_exists($filename)) {
		unlink($filename);
		$delet_img->supprime();
		$msg_positif = 'Image  '.$filename.' has been deleted';
	  } else {
		 $msg_error = 'Could not delete '.$filename.', file does not exist';
	  }
	}
}

 ?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="container-fluid">
			<!-- BEGIN PAGE CONTENT-->
			<!-- BEGIN PAGE HEADER-->
			<div class="page-bar">
				<ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                       
                        <i class="fa fa-angle-right"></i>
                    </li>
					<li>
                        
                        <a href="documents.php?action=charger">Documents</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                   
				</ul>

			</div>

			<!-- END PAGE HEADER-->


	
	<!-- BEGIN Upload file-->
	<?php  
	if ($user->type == 'administrateur') {
		if ($action == 'charger' or $action ="delete_image") {
						
	 ?>
	<div class="portlet light bordered">
		<div class="portlet-body ">
			<a  href="#doc" data-toggle="modal" class="btn green"  ><i class="fa  fa-upload "></i> Importer factures</a> 
		</div>
	</div>
<div class="row profile">
	<div class="col-md-9">
			<?php 
					if (!empty($msg_error)){
							echo error_message($msg_error); 
					}elseif(!empty($msg_positif)){ 
							echo positif_message($msg_positif);	
						}elseif(!empty($msg_system)){ 
								echo system_message($msg_system);
			} ?>
				
			<div class="row">
			<?php
					$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); 
					$cpt = 0;
					$file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
					$cpt ++;
					
				?>
			<div class="col-md-4 ">
				<!-- BEGIN WIDGET THUMB -->
				
				<div class="widget-thumb widget-bg-color-white text-uppercase rounded-3 margin-bottom-30 portlet light bordered ">
				<a>
				<div    id="<?php if (isset($ScanImage->id)) {echo $ScanImage->id;} ?>"   class="select_doc">
					<div class="widget-news  ">
					<?php 
					$info = new SplFileInfo($ScanImage->img);
					
					if($info->getExtension() == 'pdf'){?>
						<img class="widget-news-left-elem" src="assets/image/pdf-icon.png" alt="" style="width: 80px; height: 80px;"  >
						<?php }else {?>
							<img class="widget-news-left-elem" src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>" alt="" style="width: 80px; height: 80px;"  >
						<?php }?>
						
						<div class="widget-news-right-body">
							<p><?php echo $file?>/<?php echo $ScanImage->img ;?>
									
							</p>
							<span > <?php echo $thisday;?> </span>
							
						</div>
						
				
					</div>
				</div>
				</a>
				</div>
				
				<!-- END WIDGET THUMB -->
			</div>
			<?php }?>
			</div>
			
                            
			</div>
		
			 <div class="col-md-3 list-group-item bg-blue-ebonyclay">
					
							<p>Selctionnez une documents pour créer une facture.</p>
				<div class=" list-group-item bg-blue-chambray select_document margin-bottom-500">
			<p><i class="fa fa-file-photo-o font-green-jungle"></i> Documents : <?php echo $cpt ;?> </p>
				
				
			</div>
				
			</div>
			
		
		
		</div>
			<!-- END upload file-->
		
		<?php }}?>
		</div>
		
	
	</div>
	</div>
		<div id="doc" class="modal fade in" tabindex="-1" data-width="760"  >
											
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title"><i class="fa  fa-upload font-yellow "></i> Upload </h4>
				</div>
				<div class="modal-body">
				<form action="<?php echo $_SERVER['PHP_SELF']?>?action=charger" method="POST" class="form-horizontal" enctype="multipart/form-data">
						<div class="form-body">
							<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">Sélectionner des images </label>
													<div class="col-md-4">
														<div class="fileinput fileinput-new" data-provides="fileinput">
														<input type="file" required  name="files[]"  accept=".png,.jpg,.jpeg,.gif,.pdf" multiple>
														</div>
													</div>
												</div>
												
											
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" name = "submit" class="btn green">Importer</button>
														<button type="reset" class="btn  default">Annuler</button>
													</div>
												</div>
											</div>
										</form>							
										
										
												
				</div>
										<div class="modal-footer">
											<button class="btn red" data-dismiss="modal" aria-hidden="true">Fermer</button>
											
										</div>
									
		</div>

	<!-- END CONTENT -->
			<script>
	////////////////////////////////// onchange    ///////////////////////////

$(document).on('click','.select_doc', function() {
    var id = $(this).attr("id");
	var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
        $('.select_document').load('ajax/onclick_image.php?id='+id+'&id_societe='+id_societe,function(){       
    });
});

  </script>
<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>