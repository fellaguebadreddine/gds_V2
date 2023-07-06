<div id="close_societe" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                  <div class="modal-body">
                    <p>
                      Voulez-vous vraiment fermer la société <?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?>
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button>
                    <a  href="close_file.php?action=close_societe"   class="btn red">Déconnexion </a>
                  </div>
</div>
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
         2021 &copy; Mohammed FETTAH. <a href="#" title="Mohammed FETTAH" target="_blank">Mohammed FETTAH</a>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/table-advanced.js"></script>
<script src="assets/global/scripts/toastr.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/ui-extended-modals.js"></script>
<?php if ( ($action=='add_societe') or $action=='edit' ) { ?>
<script>
$(document).ready(function() {
    $(document).on('click','#add_banque', function() {
      
    $(".item-row:last").after('<tr class="item-row"><td><select name="id_banque[]"  id="id_banque" class=" form-control select2me" onchange="focusBanque();"><?php  foreach ($banques as $banque) { echo'<option value="'.$banque->id_banque.'"> '.addslashes($banque->Designation).' - Code: '.$banque->Code.'</option>';} ?></select></td><td><input type="number" name="n_compte[]" id="n_compte" min="0" class="form-control" ></td> <td><input  type="number" name="solde[]" id="qte" min="0" class="form-control" ></td><td><a class="btn btn-danger " id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash" ></i></a></td></tr>');

  });
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    $(this).parents('.item-row').remove();
  });
});
$(document).ready(function() {
    $(document).on('click','#add_caisse', function() {
      
    $(".item-row2:last").after('<tr class="item-row2"><td><select name="id_caisse[]"  id="id_caisse" class=" form-control select2me" onchange="focusCaisse();"><?php  foreach ($caisses as $caisse)  { echo'<option value="'.$caisse->id_caisse.'"> '.addslashes($caisse->Designation).' - Code: '.$caisse->Code.'</option>';} ?></select></td><td><input  type="number" name="solde_caisse[]" id="solde_caisse" min="0" class="form-control" ></td><td><a class="btn btn-danger " id="delete" style="" href="javascript:;" title="Remove row"> <i class="fa fa-trash" ></i></a></td></tr>');
    
  });
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row2').fadeOut();
    $(this).parents('.item-row2').remove();
  });
  $('#id_banque').select2();
});
</script>
<?php } ?>
<script>
$(document).on('click','#societe_link', function() {
    var id = $(this).attr('value');   
    var title = $(this).attr('name');
  //this is just getting the value that is selected
  $('.modaltitle').html(title);
  $('.modalfooter').html('<button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button><a  class="btn blue" href="societe.php?id='+id+'&action=edit" >Modifier</a>');
 $('.modalbody').load('ajax/GetsocieteContent.php?id='+id,function(){       
    });

});

$(document).on('click','#client_link', function() {
    var id = $(this).attr('value');   
    var title = $(this).attr('name');
  //this is just getting the value that is selected
  $('.modaltitle').html(title);
  $('.modalfooter').html('<button type="button" data-dismiss="modal" class="btn btn-default">Fermer</button><a  class="btn blue" href="client.php?id='+id+'&action=edit" >Modifier</a>');
 $('.modalbody').load('ajax/selectClient.php?id='+id,function(){       
    });

});

      jQuery(document).ready(function() {    
         Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
   TableAdvanced.init();
      });
        function removeDefaultFunction()
        {
            window.onhelp = function () { return false; }
        }
////////////////// onclick index button's //////////////////////
     $(document).on('click','#vente', function() {
window.location = 'operation.php?action=vente';
  });   
////////////////// onclick index button's //////////////////////
     $(document).on('click','#achat', function() {
window.location = 'achat.php?action=achat';
  }); 
////////////////////////////////// onchange journal Paiement ///////////////////////////

$(document).on('change','#Journal', function() {
    var id = this.value;
    var id_fact = <?php if (isset($Fact->id_facture)) {echo $Fact->id_facture;} ?>;
     $('.mode-paiment').load('ajax/get_paiement.php?id='+id+'&id_fact='+id_fact,function(){       
    });
});
 
/////////////////////////// save Paiement ////////////////////////////////

$(document).on('click','button#save_paiement', function() {
$.ajax({
type: "POST",
url: "ajax/save_paiement.php",
data: $('#paiement_form').serialize(),
success: function(message){
$(".notification").html(message)
},
error: function(){
alert("Error");
}
});
 $('.facture-payee').html('<div class="  alert alert-success hidden-print"><p><strong>NOTE: Facture payée.</strong></p></div>');
 $('.invoice-block').html('<a class="btn btn-sm blue hidden-print margin-bottom-5" onclick="javascript:window.print();" ><i class="fa fa-print"></i> Imprimer</a><a class="btn btn-sm green hidden-print margin-bottom-5" disabled ><i class="fa fa-credit-card"></i> Enregistrer un paiement</a>');

});


   </script>
<?php if  ($action=='vente')  { ?>
<script>
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_client', function() {
$('#id_article').select2('open');
});
$(document).on('change','#id_article', function() {
    var id = this.value;
     $('.info-prod').load('ajax/get_article.php?id='+id,function(){       
    });
});

/*$(document).on('keypress','#prix', function() {
        var _this = $(this); // copy of this object for further usage
        setTimeout(function() {
            $('#id_tva').select2('open');
        },3000);
    });
*/
//focusBanque = function getFocus() {           
 // document.getElementById("n_compte").focus();}
//focusCaisse = function getFocus() {           
 // document.getElementById("n_caisse").focus();}
</script>
<?php if (empty($table_vantes)) {?>
   <script>
      $( window ).load(function() {
  $('#id_client').select2('open');
}); 

</script>
<?php }else {?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#id_client").attr("readonly","readonly");;
            $("#valider").attr("disabled", false);
            });   
</script>
<?php } ?>

<script>
$(document).on('click','button#submit', function() {
//$("#id_client").prop("disabled", true);
$.ajax({
type: "POST",
url: "ajax/addvente.php",
data: $('#formvente').serialize(),
success: function(message){
    $(".notification").html(message)

},
error: function(){
alert("Error");
}
});
});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
$.ajax({
type: "POST",
url: "ajax/addvente.php",
data: $('#formvente').serialize(),
success: function(message){
    $(".notification").html(message)

},
error: function(){
alert("Error");
}
});
    }
});
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deletevente.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe,
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });

//////////////////////////  valider vente//////////////////

  $(document).on('click','#valider', function() {
window.location = 'invoice.php?action=fact_vente';
  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'invoice.php?action=fact_vente';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
    <?php } ?>
    <?php if  ($action=='achat')  { ?>
<script>
focusArticle = function getFocus() {           
  document.getElementById("qte").focus();}     
$(document).on('change','#id_fournisseur', function() {
$('#id_article').select2('open');
});
$(document).on('change','#id_article', function() {
    var id = this.value;
     $('.info-prod').load('ajax/get_article.php?id='+id,function(){       
    });
});

/*$(document).on('keypress','#prix', function() {
        var _this = $(this); // copy of this object for further usage
        setTimeout(function() {
            $('#id_tva').select2('open');
        },3000);
    });
*/
//focusBanque = function getFocus() {           
 // document.getElementById("n_compte").focus();}
//focusCaisse = function getFocus() {           
 // document.getElementById("n_caisse").focus();}
</script>
<?php if (empty($table_achats)) {?>
   <script>
      $( window ).load(function() {
  $('#id_fournisseur').select2('open');
}); 

</script>
<?php }else {?>
   <script>
            $(document).ready(function(){
            $("#id_article").select2("open");
            $("#id_fournisseur").attr("readonly","readonly");;
            $("#valider").attr("disabled", false);
            });   
</script>
<?php } ?>

<script>
$(document).on('click','button#submit', function() {
//$("#id_fournisseur").prop("disabled", true);
$.ajax({
type: "POST",
url: "ajax/addachat.php",
data: $('#formachat').serialize(),
success: function(message){
    $(".notification").html(message)

},
error: function(){
alert("Error");
}
});
});
$(document).on('keypress',function(e) {
    if(e.which == 13) {
$.ajax({
type: "POST",
url: "ajax/addachat.php",
data: $('#formachat').serialize(),
success: function(message){
    $(".notification").html(message)

},
error: function(){
alert("Error");
}
});
    }
});
  $(document).on('click','#delete', function() {
    $(this).parents('.item-row').fadeOut();
    var id =$(this).val();
    var id_user = <?php if (isset($user->id)) {echo $user->id;}  ?>;
    var id_societe = <?php if (isset($nav_societe->id_societe)) {echo $nav_societe->id_societe;}  ?>;
    $.ajax({
    type: "GET",
    url: "ajax/deleteachat.php?id="+id+"&id_user="+id_user+"&id_societe="+id_societe,
    success: function(message){
    $(".total").html(message)},
    error: function(){
    alert("Error");
    }
    });
  });

//////////////////////////  valider achat//////////////////

  $(document).on('click','#valider', function() {
window.location = 'invoce_achat.php?action=fact_achat';
  });

////////////////////////
        $(window).bind('keydown', function(e) {
            //This is the F1 key code, but NOT with SHIFT/CTRL/ALT
            var keyCode = e.keyCode || e.which;
            if((keyCode == 112 || e.key == 'F1') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Add 
                //window.open('invoice.php?action=fact_vente');
                window.location = 'invoce_achat.php?action=fact_achat';
                }
            // Add other F-keys here:
            else if((keyCode == 113 || e.key == 'F2') && 
                    !(event.altKey ||event.ctrlKey || event.shiftKey || event.metaKey))
             {
                // prevent code starts here:
                removeDefaultFunction();
                e.cancelable = true;
                e.stopPropagation();
                e.preventDefault();
                e.returnValue = false;
                // Do something else for F2
                alert('F2 key opened, ' + keyCode);
                }
        });
</script>
    <?php } ?>
   
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>