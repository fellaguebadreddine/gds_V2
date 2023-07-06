<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Accounts::trouve_par_id($session->id_utilisateur);
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
$titre = "ThreeSoft | Facture ";
$active_menu = "Facturation";
$header = array('table','invoice');
if ($user->type == "administrateur"){
if (isset($_GET['action']) && $_GET['action'] =='fact_vente' ) {
$active_submenu = "list_vente";
$action = 'fact_vente';}
else if (isset($_GET['action']) && $_GET['action'] =='fact_achat' ) {
$active_submenu = "list_vente";
$action = 'fact_achat';}
// End of the main Submit conditional.
}
if ($user->type =='administrateur' or $user->type =='utilisateur'){
	require_once("header/header.php");
	require_once("header/navbar.php");
}
else {
	readresser_a("profile_utils.php");
	 $personnes = Accounts::not_admin();
}
?>
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Modal title</h4>
							</div>
							<div class="modal-body">
								 Widget settings form goes here
							</div>
							<div class="modal-footer">
								<button type="button" class="btn blue">Save changes</button>
								<button type="button" class="btn default" data-dismiss="modal">Close</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				<!-- BEGIN STYLE CUSTOMIZER -->
				<div class="theme-panel">
					<div class="toggler tooltips" data-container="body" data-placement="left" data-html="true" data-original-title="Click to open advance theme customizer panel">
						<i class="icon-settings"></i>
					</div>
					<div class="toggler-close">
						<i class="icon-close"></i>
					</div>
					<div class="theme-options">
						<div class="theme-option theme-colors clearfix">
							<span>
							THEME COLOR </span>
							<ul>
								<li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default">
								</li>
								<li class="color-grey tooltips" data-style="grey" data-container="body" data-original-title="Grey">
								</li>
								<li class="color-blue tooltips" data-style="blue" data-container="body" data-original-title="Blue">
								</li>
								<li class="color-dark tooltips" data-style="dark" data-container="body" data-original-title="Dark">
								</li>
								<li class="color-light tooltips" data-style="light" data-container="body" data-original-title="Light">
								</li>
							</ul>
						</div>
						<div class="theme-option">
							<span>
							Theme Style </span>
							<select class="layout-style-option form-control input-small">
								<option value="square" selected="selected">Square corners</option>
								<option value="rounded">Rounded corners</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Layout </span>
							<select class="layout-option form-control input-small">
								<option value="fluid" selected="selected">Fluid</option>
								<option value="boxed">Boxed</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Header </span>
							<select class="page-header-option form-control input-small">
								<option value="fixed" selected="selected">Fixed</option>
								<option value="default">Default</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Top Dropdown</span>
							<select class="page-header-top-dropdown-style-option form-control input-small">
								<option value="light" selected="selected">Light</option>
								<option value="dark">Dark</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Sidebar Mode</span>
							<select class="sidebar-option form-control input-small">
								<option value="fixed">Fixed</option>
								<option value="default" selected="selected">Default</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Sidebar Style</span>
							<select class="sidebar-style-option form-control input-small">
								<option value="default" selected="selected">Default</option>
								<option value="compact">Compact</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Sidebar Menu </span>
							<select class="sidebar-menu-option form-control input-small">
								<option value="accordion" selected="selected">Accordion</option>
								<option value="hover">Hover</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Sidebar Position </span>
							<select class="sidebar-pos-option form-control input-small">
								<option value="left" selected="selected">Left</option>
								<option value="right">Right</option>
							</select>
						</div>
						<div class="theme-option">
							<span>
							Footer </span>
							<select class="page-footer-option form-control input-small">
								<option value="fixed">Fixed</option>
								<option value="default" selected="selected">Default</option>
							</select>
						</div>
					</div>
				</div>
				<!-- END STYLE CUSTOMIZER -->
				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
				Invoice <small>invoice sample</small>
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="index.html">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Pages</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Invoice</a>
						</li>
					</ul>
					<div class="page-toolbar">
						<div class="btn-group pull-right">
							<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
							Actions <i class="fa fa-angle-down"></i>
							</button>
							<ul class="dropdown-menu pull-right" role="menu">
								<li>
									<a href="#">Action</a>
								</li>
								<li>
									<a href="#">Another action</a>
								</li>
								<li>
									<a href="#">Something else here</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">Separated link</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="portlet light">
					<div class="portlet-body">
						<div class="invoice">
							<div class="row invoice-logo">
								<div class="col-xs-6 invoice-logo-space">
									<img src="assets/admin/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
								</div>
								<div class="col-xs-6">
									<p>
										 #5652256 / 28 Feb 2013 <span class="muted">
										Consectetuer adipiscing elit </span>
									</p>
								</div>
							</div>
							<hr/>
							<div class="row">
								<div class="col-xs-4">
									<h3>Client:</h3>
									<ul class="list-unstyled">
										<li>
											 John Doe
										</li>
										<li>
											 Mr Nilson Otto
										</li>
										<li>
											 FoodMaster Ltd
										</li>
										<li>
											 Madrid
										</li>
										<li>
											 Spain
										</li>
										<li>
											 1982 OOP
										</li>
									</ul>
								</div>
								<div class="col-xs-4">
									<h3>About:</h3>
									<ul class="list-unstyled">
										<li>
											 Drem psum dolor sit amet
										</li>
										<li>
											 Laoreet dolore magna
										</li>
										<li>
											 Consectetuer adipiscing elit
										</li>
										<li>
											 Magna aliquam tincidunt erat volutpat
										</li>
										<li>
											 Olor sit amet adipiscing eli
										</li>
										<li>
											 Laoreet dolore magna
										</li>
									</ul>
								</div>
								<div class="col-xs-4 invoice-payment">
									<h3>Payment Details:</h3>
									<ul class="list-unstyled">
										<li>
											<strong>V.A.T Reg #:</strong> 542554(DEMO)78
										</li>
										<li>
											<strong>Account Name:</strong> FoodMaster Ltd
										</li>
										<li>
											<strong>SWIFT code:</strong> 45454DEMO545DEMO
										</li>
										<li>
											<strong>V.A.T Reg #:</strong> 542554(DEMO)78
										</li>
										<li>
											<strong>Account Name:</strong> FoodMaster Ltd
										</li>
										<li>
											<strong>SWIFT code:</strong> 45454DEMO545DEMO
										</li>
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<table class="table table-striped table-hover">
									<thead>
									<tr>
										<th>
											 #
										</th>
										<th>
											 Item
										</th>
										<th class="hidden-480">
											 Description
										</th>
										<th class="hidden-480">
											 Quantity
										</th>
										<th class="hidden-480">
											 Unit Cost
										</th>
										<th>
											 Total
										</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>
											 1
										</td>
										<td>
											 Hardware
										</td>
										<td class="hidden-480">
											 Server hardware purchase
										</td>
										<td class="hidden-480">
											 32
										</td>
										<td class="hidden-480">
											 $75
										</td>
										<td>
											 $2152
										</td>
									</tr>
									<tr>
										<td>
											 2
										</td>
										<td>
											 Furniture
										</td>
										<td class="hidden-480">
											 Office furniture purchase
										</td>
										<td class="hidden-480">
											 15
										</td>
										<td class="hidden-480">
											 $169
										</td>
										<td>
											 $4169
										</td>
									</tr>
									<tr>
										<td>
											 3
										</td>
										<td>
											 Foods
										</td>
										<td class="hidden-480">
											 Company Anual Dinner Catering
										</td>
										<td class="hidden-480">
											 69
										</td>
										<td class="hidden-480">
											 $49
										</td>
										<td>
											 $1260
										</td>
									</tr>
									<tr>
										<td>
											 3
										</td>
										<td>
											 Software
										</td>
										<td class="hidden-480">
											 Payment for Jan 2013
										</td>
										<td class="hidden-480">
											 149
										</td>
										<td class="hidden-480">
											 $12
										</td>
										<td>
											 $866
										</td>
									</tr>
									</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4">
									<div class="well">
										<address>
										<strong>Loop, Inc.</strong><br/>
										795 Park Ave, Suite 120<br/>
										San Francisco, CA 94107<br/>
										<abbr title="Phone">P:</abbr> (234) 145-1810 </address>
										<address>
										<strong>Full Name</strong><br/>
										<a href="mailto:#">
										first.last@email.com </a>
										</address>
									</div>
								</div>
								<div class="col-xs-8 invoice-block">
									<ul class="list-unstyled amounts">
										<li>
											<strong>Sub - Total amount:</strong> $9265
										</li>
										<li>
											<strong>Discount:</strong> 12.9%
										</li>
										<li>
											<strong>VAT:</strong> -----
										</li>
										<li>
											<strong>Grand Total:</strong> $12489
										</li>
									</ul>
									<br/>
									<a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
									Print <i class="fa fa-print"></i>
									</a>
									<a class="btn btn-lg green hidden-print margin-bottom-5">
									Submit Your Invoice <i class="fa fa-check"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
		</div>
		<!-- END CONTENT -->
		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="page-footer">
		<div class="page-footer-inner">
			 2014 &copy; Metronic by keenthemes. <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a>
		</div>
		<div class="scroll-to-top">
			<i class="icon-arrow-up"></i>
		</div>
	</div>
	<!-- END FOOTER -->
</div>
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
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="assets/admin/layout2/scripts/layout.js" type="text/javascript"></script>
<script src="assets/admin/layout2/scripts/demo.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>