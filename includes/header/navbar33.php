<body class="page-boxed page-header-fixed page-container-bg-solid page-sidebar-closed-hide-logo ">
<!-- BEGIN HEADER -->
<?php if(!empty($_SESSION['societe'])){
$nav_societe = Societe::trouve_par_id($_SESSION['societe']);} ?>
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="index.php">
			<img src="assets/image/logo - menu.png" alt="logo" class="logo-default"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN PAGE ACTIONS -->
		<!-- DOC: Remove "hide" class to enable the page header actions -->
		
		<!-- END PAGE ACTIONS -->
		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			<!-- BEGIN HEADER SEARCH BOX -->
			<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
			<form class="search-form search-form-expanded" action="extra_search.html" method="GET">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search..." name="query">
					<span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
				</div>
			</form>
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN SOCIETE NAME -->

			<!-- END SOCIETE NAME -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="icon-bell"></i>
						<span class="badge badge-default">
						7 </span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3><span class="bold">12 pending</span> notifications</h3>
								<a href="extra_profile.html">view all</a>
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
									<li>
										<a href="javascript:;">
										<span class="time">just now</span>
										<span class="details">
										<span class="label label-sm label-icon label-success">
										<i class="fa fa-plus"></i>
										</span>
										New user registered. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">3 mins</span>
										<span class="details">
										<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
										</span>
										Server #12 overloaded. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">10 mins</span>
										<span class="details">
										<span class="label label-sm label-icon label-warning">
										<i class="fa fa-bell-o"></i>
										</span>
										Server #2 not responding. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">14 hrs</span>
										<span class="details">
										<span class="label label-sm label-icon label-info">
										<i class="fa fa-bullhorn"></i>
										</span>
										Application error. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">2 days</span>
										<span class="details">
										<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
										</span>
										Database overloaded 68%. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">3 days</span>
										<span class="details">
										<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
										</span>
										A user IP blocked. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">4 days</span>
										<span class="details">
										<span class="label label-sm label-icon label-warning">
										<i class="fa fa-bell-o"></i>
										</span>
										Storage Server #4 not responding dfdfdfd. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">5 days</span>
										<span class="details">
										<span class="label label-sm label-icon label-info">
										<i class="fa fa-bullhorn"></i>
										</span>
										System Error. </span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="time">9 days</span>
										<span class="details">
										<span class="label label-sm label-icon label-danger">
										<i class="fa fa-bolt"></i>
										</span>
										Storage server failed. </span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN INBOX DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="icon-envelope-open"></i>
						<span class="badge badge-default">
						4 </span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>You have <span class="bold">7 New</span> Messages</h3>
								<a href="page_inbox.html">view all</a>
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
									<li>
										<a href="inbox.html?a=view">
										<span class="photo">
										<img src="assets/admin/layout/img/avatar2.jpg" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										Lisa Wong </span>
										<span class="time">Just Now </span>
										</span>
										<span class="message">
										Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
										</a>
									</li>
									<li>
										<a href="inbox.html?a=view">
										<span class="photo">
										<img src="assets/admin/layout/img/avatar3.jpg" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										Richard Doe </span>
										<span class="time">16 mins </span>
										</span>
										<span class="message">
										Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
										</a>
									</li>
									<li>
										<a href="inbox.html?a=view">
										<span class="photo">
										<img src="assets/admin/layout/img/avatar1.jpg" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										Bob Nilson </span>
										<span class="time">2 hrs </span>
										</span>
										<span class="message">
										Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
										</a>
									</li>
									<li>
										<a href="inbox.html?a=view">
										<span class="photo">
										<img src="assets/admin/layout/img/avatar2.jpg" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										Lisa Wong </span>
										<span class="time">40 mins </span>
										</span>
										<span class="message">
										Vivamus sed auctor 40% nibh congue nibh... </span>
										</a>
									</li>
									<li>
										<a href="inbox.html?a=view">
										<span class="photo">
										<img src="assets/admin/layout/img/avatar3.jpg" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										Richard Doe </span>
										<span class="time">46 mins </span>
										</span>
										<span class="message">
										Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- END INBOX DROPDOWN -->
					<!-- BEGIN TODO DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="icon-calendar"></i>
						<span class="badge badge-default">
						3 </span>
						</a>
						<ul class="dropdown-menu extended tasks">
							<li class="external">
								<h3>You have <span class="bold">12 pending</span> tasks</h3>
								<a href="page_todo.html">view all</a>
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
									<li>
										<a href="javascript:;">
										<span class="task">
										<span class="desc">New release v1.2 </span>
										<span class="percent">30%</span>
										</span>
										<span class="progress">
										<span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">40% Complete</span></span>
										</span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="task">
										<span class="desc">Application deployment</span>
										<span class="percent">65%</span>
										</span>
										<span class="progress">
										<span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">65% Complete</span></span>
										</span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="task">
										<span class="desc">Mobile app release</span>
										<span class="percent">98%</span>
										</span>
										<span class="progress">
										<span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">98% Complete</span></span>
										</span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="task">
										<span class="desc">Database migration</span>
										<span class="percent">10%</span>
										</span>
										<span class="progress">
										<span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">10% Complete</span></span>
										</span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="task">
										<span class="desc">Web server upgrade</span>
										<span class="percent">58%</span>
										</span>
										<span class="progress">
										<span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">58% Complete</span></span>
										</span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="task">
										<span class="desc">Mobile development</span>
										<span class="percent">85%</span>
										</span>
										<span class="progress">
										<span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">85% Complete</span></span>
										</span>
										</a>
									</li>
									<li>
										<a href="javascript:;">
										<span class="task">
										<span class="desc">New UI release</span>
										<span class="percent">38%</span>
										</span>
										<span class="progress progress-striped">
										<span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">38% Complete</span></span>
										</span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="assets/admin/layout2/img/avatar3_small.jpg"/>
						<span class="username username-hide-on-mobile">
						<?php if (!empty($user->nom_compler())) {
						echo  $user->nom_compler() ;
					} else{echo  $user->nom_clie; } ?> </span>
						<i class="fa fa-angle-down"></i>
						</a>
                        <ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="#">
							<i class="icon-lock"></i> Fermer la session </a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="logout.php">
							<i class="icon-key"></i> Déconnexion </a>
						</li>
					</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">


				<?php 		if (isset($nav_societe)){			 ?>
						<li class=" active open " style="margin-bottom: 2px;">
						<a href="index.php">
						<i class="fa fa-dashboard"></i>
						<span class="title"><?php if (isset($nav_societe->Dossier)){echo $nav_societe->Dossier ;} ?></span>
						<span class="selected"></span>
						
						</a>
					</li>
						<?php } else{ ?>
				<li <?php if ($active_menu == 'index')  { echo 'class=" active open"'; }  ?>>
						<a href="index.php">
						<i class="fa fa-dashboard"></i>
						<span class="title">Acceuil</span>
						<span class="selected"></span>
						
						</a>
					</li>	
					<?php }
						if (isset($nav_societe) ){
							?>
					<li <?php if ($active_menu == 'Facturation')  { echo 'class=" active open"'; }  ?>>
						<a href="javascript:;" >
						<i class="fa fa-table"></i>
						<span class="title">Facturation</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li >
							<a href="javascript:;">
							<i class="glyphicon glyphicon-folder-open"></i>
							Article</a>
							<ul class="sub-menu">
							<li <?php if ($active_submenu == 'list_produit')  { echo 'class="active"'; }  ?>>
								<a href="produit.php?action=list_produit">
								Liste des article</a>
							</li>
							<li <?php if ($active_submenu == 'list_mesure')  { echo 'class="active"'; }  ?>>
								<a href="unite_mesure.php?action=list_mesure">
								Unités de mesure</a>
							</li>
							<li <?php if ($active_submenu == 'list_famille')  { echo 'class="active"'; }  ?>>
								<a href="famille.php?action=list_famille">
								Famille</a>
							</li>
							</ul>
						</li>
						<li >
							<a href="javascript:;">
							<i class="glyphicon glyphicon-user"></i>
							Tiers</a>
							<ul class="sub-menu">
							<li <?php if ($active_submenu == 'list_client')  { echo 'class="active"'; }  ?>>
								<a href="client.php?action=list_client">
								Clients</a>
							</li>
							<li <?php if ($active_submenu == 'list_fournisseur')  { echo 'class="active"'; }  ?>>
								<a href="fournisseur.php?action=list_fournisseur">
								Fournisseurs</a>
							</li>
							</ul>
						</li>
						<li >
							<a href="javascript:;">
							<i class="glyphicon glyphicon-list-alt"></i>
							Facturation</a>
							<ul class="sub-menu">
							<li <?php if ($active_submenu == 'list_vente')  { echo 'class="active"'; }  ?>>
								<a href="operation.php?action=list_vente">
								Ventes</a>
							</li>
							<li <?php if ($active_submenu == 'list_achat')  { echo 'class="active"'; }  ?>>
								<a href="achat.php?action=list_achat">
								Achats</a>
							</li>
							<li id="Importation">
							<a href="#">
							Importation</a>
						</li>
							</ul>
						</li>
						<li class="menu-list"  id="Réglements">
						<a >
						<i class="fa fa-folder"></i>
						<span class="title">Réglements</span>
						<span class="selected"></span>
						</a>
						
						</li><li class="menu-list"  id="Rapports">
						<a >
						<i class="fa fa-folder"></i>
						<span class="title">Rapports</span>
						<span class="selected"></span>
						</a>
						
						</li>

						</ul>
					</li>
					
					<li class="menu-list"  id="Comptabilité">
						<a >
						<i class="fa fa-building"></i>
						<span class="title">Comptabilité</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li id="Plan comptable">
							<a href="#">
							Plan comptable</a>
						</li>
						<li id="Journaux">
							<a href="#">
							Journaux</a>
						</li>
						
						</ul>
					</li>
					<li class="menu-list"  id="Paie">
						<a >
						<i class="fa fa-money"></i>
						<span class="title">Paie</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li id="Salaries">
							<a href="#">
							Salariés</a>
						</li>
						<li id="Rubriques">
							<a href="#">
							Rubriques</a>
						</li>
						<li>
							<a href="#">
							Bulletins de paie</a>
						</li>
						</ul>
					</li>
					<li class="menu-list"  id="G50">
						<a >
						<i class="fa fa-archive"></i>
						<span class="title">G50</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li id="Liste G50">
							<a href="#">
							Liste G50</a>
						</li>
						
						</ul>
					</li>
					<li >
						<a  data-target="#close_societe" data-toggle="modal" class="font-red-haze bold">
						<i class="icon-logout font-red-haze"></i>
						<span class="title">Fermer Sociéte</span>
						<span class="selected"></span>
						</a>
					</li>
				<?php } ?>
					<li <?php if ($active_menu == 'societe')  { echo 'class=" active open"'; }  ?>>
						<a href="societe.php?action=list_societe">
						<i class="icon-home"></i>
						<span class="title">Sociétés </span>
						<?php 		if (isset($nav_societe) ){			 ?>
						<span class="arrow "></span>
						<?php } ?>
						<span class="selected"></span>
						
						</a>

					</li>
					<li <?php if ($active_menu == 'parametre')  { echo 'class=" active open"'; }  ?>>
						<a href="javascript:;">
						<i class="fa fa-gears"></i>
						<span class="title">Paramètres</span>
						<span class="selected"></span>
						<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
						<li <?php if ($active_submenu == 'list_banque')  { echo 'class="active"'; }  ?>>
							<a href="banque.php?action=list_banque">
							Banque</a>
						</li>
						<li <?php if ($active_submenu == 'list_caisse')  { echo 'class="active"'; }  ?>>
							<a href="caisse.php?action=list_caisse">
							Caisse</a>
						</li>

						<li <?php if ($active_submenu == 'list_tva')  { echo 'class="active"'; }  ?>>
							<a href="tva.php?action=list_tva">
							Taux de TVA</a>
						</li>

					</li>
					
				
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
