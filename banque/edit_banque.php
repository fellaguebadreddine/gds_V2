<!-- BEGIN PAGE CONTENT-->
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


                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bank"></i>Editer Banque
                            </div>

                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="<?php echo $_SERVER['PHP_SELF']?>?action=edit_banque" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-body">
                                    <br/>
                                    <br/>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Banque *</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" name = "Designation" class="form-control" placeholder="Banque" value ="<?php if (isset($banque->Designation)){ echo html_entity_decode($banque->Designation); } ?>"required>
                                                <span class="input-group-addon ">
                                                <i class="fa fa-fa-bank "></i>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Abreviation </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" name = "abreviation" class="form-control" placeholder="Banque" value ="<?php if (isset($banque->abreviation)){ echo html_entity_decode($banque->abreviation); } ?>">
                                                <span class="input-group-addon ">
                                                <i class="fa fa-fa-bank "></i>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Code </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" name = "Code" class="form-control" placeholder="Code banque" value ="<?php if (isset($banque->Code)){ echo html_entity_decode($banque->Code); } ?>" required>
                                                <span class="input-group-addon ">
                                                <i class="fa fa-home"></i>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    
                                                                            
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Adresse *</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" name = "Adresse" class="form-control" placeholder="Adresse" value ="<?php if (isset($banque->Adresse)){ echo html_entity_decode($banque->Adresse); } ?>">
                                                <span class="input-group-addon " required >
                                                <i class="fa fa-exchange"></i>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Ville</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name = "Ville" class="form-control" value ="<?php if (isset($banque->Ville)){ echo html_entity_decode($banque->Ville); } ?>" >
                                                <span class="input-group-addon " required >
                                                <i class="fa fa-building"></i>
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div>												
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Postal *</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name = "Postal" class="form-control" placeholder="Postal " value ="<?php if (isset($banque->Postal)){ echo html_entity_decode($banque->Postal); } ?>">
                                                <span class="input-group-addon ">
                                                <i class="">Postal</i>
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Tel</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name = "Tel" class="form-control" placeholder="021 00 00 00 " value ="<?php if (isset($banque->Tel)){ echo html_entity_decode($banque->Tel); } ?>" >
                                                <span class="input-group-addon ">
                                                <i class="fa  fa-phone"></i>
                                                </span>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Type </label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name = "Type" class="form-control" placeholder="Type " value ="<?php if (isset($banque->Type)){ echo html_entity_decode($banque->Type); } ?>" >
                                                
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Num de Compte </label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name = "NCompte" class="form-control" placeholder="Num de Compte " value ="<?php if (isset($banque->NCompte)){ echo html_entity_decode($banque->NCompte); } ?>" >
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Jc </label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name = "Jc" class="form-control" placeholder="Jc " value ="<?php if (isset($banque->Jc)){ echo html_entity_decode($banque->Jc); } ?>" >
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">JTC </label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name = "Jtc" class="form-control" placeholder="Jtc " value ="<?php if (isset($banque->Jtc)){ echo html_entity_decode($banque->Jtc); } ?>" >
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                  
                                    
                                    
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" name = "submit" class="btn green">Modifier</button>
                                            <button type="button" value="back" onclick="history.go(-1)" class="btn  default">Annuler</button>
                                             <?php echo '<input type="hidden" name="id" value="' .$id . '" />';?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>

</div>
</div>