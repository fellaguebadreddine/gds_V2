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

	if (isset($_GET['action']) && $_GET['action'] =='fileupload' ) {

$active_submenu = "upload";
$action = 'fileupload';
	}
}
$titre = "ThreeSoft | upload ";
$active_menu = "parametre";
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
  
if(isset($_POST['submit']) && $action == 'fileupload'){
	
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
    $allowTypes = array('jpg','png','jpeg','JPG');
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
 ?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="main-content">
			<!-- BEGIN PAGE CONTENT-->
			<!-- BEGIN PAGE HEADER-->
			<div class="page-bar">
				<ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                       
                        <i class="fa fa-angle-right"></i>
                    </li>
					<li>
                        
                        <a href="upload.php?action=fileupload">Upload file</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                   
				</ul>

			</div>

			<!-- END PAGE HEADER-->


	
	<!-- BEGIN Upload file-->
	<?php  
	if ($user->type == 'administrateur') {
		if ($action == 'fileupload') {
						
	 ?>

			
			<div class="row profile">
				<div class="col-md-12">
									<?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>


                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption bold">
											<i class="fa  fa-upload font-yellow "></i> Upload
										</div>

									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="<?php echo $_SERVER['PHP_SELF']?>?action=fileupload" method="POST" class="form-horizontal" enctype="multipart/form-data">
											<div class="form-body">
												<br/>
												<br/>
												<div class="form-group">
													<label class="col-md-3 control-label">Sélectionner des images </label>
													<div class="col-md-4">
														<div class="fileinput fileinput-new" data-provides="fileinput">
														<input type="file" required  name="files[]"  accept=".png,.jpg,.jpeg,.gif" multiple>
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
										<!-- END FORM-->
										
									</div>
								</div>
			</div>
			<div class="col-md-12">
				<?php
					$ScanImages = Upload::trouve_upload_par_societe($nav_societe->id_societe); 
					$cpt = 0;
				?>					

                                <div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption bold">
											<i class="fa  fa-folder font-yellow "></i> Dossier sacan
										</div>

									</div>
							<div class="row">
							
							<?php  $file = str_replace (" ", "_", $nav_societe->Dossier );
							foreach($ScanImages as $ScanImage){
							?>
								<div class="col-sm-1 col-md-1">
									<a href="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>"  class="fancybox-button" data-rel="fancybox-button">
									<img src="scan/upload/<?php echo $file?>/<?php echo $ScanImage->img ;?>" alt="" style="height: 107px; width: 107px; display: block;" class="img-responsive" >
																		
									</a>
									<hr>
								</div>
								
						<?php }?>
					
							</div>
							
					</div>
			</div>
		</div>
			<!-- END upload file-->
		<?php }
		
	}?>
	</div>
	</div>
	<!-- END CONTENT -->

<!-- END CONTAINER -->
<?php
require_once("footer/footer.php");
?>