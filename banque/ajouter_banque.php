

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


                  <div class="portlet box red">
                      <div class="portlet-title">
                          <div class="caption">
                              <i class="fa fa-bank "></i>Ajouter Banque
                          </div>

                      </div>
                      <div class="portlet-body form">
                          <!-- BEGIN FORM-->
                          <form action="<?php echo $_SERVER['PHP_SELF']?>?action=ajouter_banque" method="POST" class="form-horizontal" enctype="multipart/form-data">
                              <div class="form-body">
                                  <br/>
                                  <br/>
                                  
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Banque <span class="required" aria-required="true"> * </span></label>
                                      <div class="col-md-6">
                                          <div class="input-group">
                                              <input type="text" name = "Designation" class="form-control" placeholder="Banque" required>
                                              <span class="input-group-addon ">
                                              <i class="fa fa-fa-bank "></i>
                                              </span>
                                          </div>

                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">abreviation <span class="required" aria-required="true"> * </span></label>
                                      <div class="col-md-3">
                                          <div class="input-group">
                                              <input type="text" name = "abreviation" class="form-control" placeholder="abreviation" required>
                                              <span class="input-group-addon ">
                                              <i class="fa fa-fa-bank "></i>
                                              </span>
                                          </div>

                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Code </label>
                                      <div class="col-md-3">
                                          <div class="input-group">
                                              <input type="text" name = "Code" class="form-control" placeholder="Code banque" >
                                              <span class="input-group-addon ">
                                              <i class="fa fa-home"></i>
                                              </span>
                                          </div>

                                      </div>
                                  </div>
                                  
                                                                          
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Adresse <span class="required" aria-required="true"> * </span></label>
                                      <div class="col-md-6">
                                          <div class="input-group">
                                              <input type="text" name = "Adresse" class="form-control" placeholder="Adresse" required>
                                              <span class="input-group-addon " required >
                                              <i class="fa fa-exchange"></i>
                                              </span>
                                          </div>

                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Ville <span class="required" aria-required="true"> * </span></label>
                                      <div class="col-md-3">
                                          <div class="input-group">
                                              <input type="text" name = "Ville" class="form-control" >
                                              <span class="input-group-addon " required >
                                              <i class="fa fa-building"></i>
                                              </span>
                                          </div>
                                          
                                      </div>
                                  </div>												
                                  
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Postal <span class="required" aria-required="true"> * </span></label>
                                      <div class="col-md-3">
                                          <div class="input-group">
                                              <input type="text" name = "Postal" class="form-control" placeholder="Postal ">
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
                                              <input type="text" name = "Tel" class="form-control" placeholder="021 00 00 00 " >
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
                                              <input type="text" name = "Type" class="form-control" placeholder="Type " >
                                              
                                              
                                          </div>
                                          
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Num de Compte </label>
                                      <div class="col-md-4">
                                          <div class="input-group">
                                              <input type="text" name = "NCompte" class="form-control" placeholder="Num de Compte " >
                                              
                                          </div>
                                          
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">Jc </label>
                                      <div class="col-md-4">
                                          <div class="input-group">
                                              <input type="text" name = "Jc" class="form-control" placeholder="Jc " >
                                              
                                          </div>
                                          
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-md-3 control-label">JTC </label>
                                      <div class="col-md-4">
                                          <div class="input-group">
                                              <input type="text" name = "Jtc" class="form-control" placeholder="Jtc " >
                                              
                                          </div>
                                          
                                      </div>
                                  </div>

                                  
                      
                                  
                              </div>
                              <div class="form-actions">
                                  <div class="row">
                                      <div class="col-md-offset-3 col-md-9">
                                          <button type="submit" name = "submit" class="btn green">Ajouter</button>
                                          <button type="reset" class="btn  default">Annuler</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                          <!-- END FORM-->
                          
                      </div>
                  </div>
</div>
</div>