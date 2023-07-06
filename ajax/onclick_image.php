<?php
require_once("../includes/initialiser.php");

if (isset($_GET['id'])) {
 $id =  htmlspecialchars(($_GET['id'])) ;
 $id_societe =  htmlspecialchars(intval($_GET['id_societe'])) ;
 $img_select = Upload::trouve_par_id ($id);
 $name_societe = Societe::trouve_par_id ($id_societe);
 	$file = str_replace (" ", "_", $name_societe->Dossier );
 	$files = 'scan/upload/'. $file.'/' .$img_select->img ;
								 
		?>
		
			
		
					
		<div class=" list-group-item bg-blue-chambray ">
		
			<div class="widget-news-right-body">
			<?php 
					$info = new SplFileInfo($img_select->img);
					
					if($info->getExtension() == 'pdf'){?>
					<a href="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>">
						<img class="widget-news-left-elem" src="assets/image/pdf-icon.png" alt="" style="width: 80px; height: 80px;"  >
					</a>
						<?php }else {?>
							<img class="img-responsive" src="scan/upload/<?php echo $file?>/<?php echo $img_select->img ;?>" alt=""  style="width: 100%; height: 200px;"  >
			<?php }?>
	
						
			</div>
				<hr>		
			<form action="documents.php?action=delete_image" method="POST" class="form-horizontal" enctype="multipart/form-data">
					
						<button type="submit" name="Delete image" class="btn red btn-xs pull-right" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></button>
							
							<input type="hidden" value="<?php echo $files; ?>" name="delete_file" />
						
						<?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
					
			</form>
			<label><i class="fa fa-play"></i> Actions</label>
			
			<p><a href="operation.php?action=vente&id_img=<?php echo $id;  ?>"><i class="fa fa-caret-square-o-right font-green-jungle "></i> Créer une Facture Vente</a></p>
			<p><a href="operation.php?action=achat&id_img=<?php echo $id;  ?>"><i class="fa fa-caret-square-o-right font-green-jungle"></i> Créer une Facture Achat</a></p>
			<p><a href="importation.php?action=importation&id_img=<?php echo $id;  ?>"><i class="fa fa-caret-square-o-right font-green-jungle"></i> Créer une Facture  Importation</a></p>
			<p><a href="saisie.php?action=add_pieces&id_img=<?php echo $id;  ?>"><i class="fa fa-caret-square-o-right font-green-jungle"></i> Créer une pièce comptables</a></p>
			
			
		</div>
						
		<?php } ?>	
 