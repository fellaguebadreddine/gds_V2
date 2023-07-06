<body >
<!-- BEGIN HEADER -->
<?php

 if(!empty($_SESSION['societe'])){
$nav_societe = Societe::trouve_par_id($_SESSION['societe']);} ?>
<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="index.html"><img src="../../assets/admin/layout3/img/logo-default.png" alt="logo" class="logo-default"></a>
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="icon-bell"></i>
						<span class="badge badge-default">7</span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>You have <strong>12 pending</strong> tasks</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>
								<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;"><ul class="dropdown-menu-list scroller" style="height: 250px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
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
								</ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN TODO DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-tasks" id="header_task_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="icon-calendar"></i>
						<span class="badge badge-default">3</span>
						</a>
						<ul class="dropdown-menu extended tasks">
							<li class="external">
								<h3>You have <strong>12 pending</strong> tasks</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>
								<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 275px;"><ul class="dropdown-menu-list scroller" style="height: 275px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
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
								</ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
							</li>
						</ul>
					</li>
					<!-- END TODO DROPDOWN -->
					<li class="droddown dropdown-separator">
						<span class="separator"></span>
					</li>
					<!-- BEGIN INBOX DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-inbox" id="header_inbox_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="circle">3</span>
						<span class="corner"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>You have <strong>7 New</strong> Messages</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>
								<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 275px;"><ul class="dropdown-menu-list scroller" style="height: 275px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
									<li>
										<a href="inbox.html?a=view">
										<span class="photo">
										<img src="../../assets/admin/layout3/img/avatar2.jpg" class="img-circle" alt="">
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
										<img src="../../assets/admin/layout3/img/avatar3.jpg" class="img-circle" alt="">
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
										<img src="../../assets/admin/layout3/img/avatar1.jpg" class="img-circle" alt="">
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
										<img src="../../assets/admin/layout3/img/avatar2.jpg" class="img-circle" alt="">
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
										<img src="../../assets/admin/layout3/img/avatar3.jpg" class="img-circle" alt="">
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
								</ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
							</li>
						</ul>
					</li>
					<!-- END INBOX DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="../../assets/admin/layout3/img/avatar9.jpg">
						<span class="username username-hide-mobile">Nick</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="extra_profile.html">
								<i class="icon-user"></i> My Profile </a>
							</li>
							<li>
								<a href="page_calendar.html">
								<i class="icon-calendar"></i> My Calendar </a>
							</li>
							<li>
								<a href="inbox.html">
								<i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
								3 </span>
								</a>
							</li>
							<li>
								<a href="javascript:;">
								<i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
								7 </span>
								</a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="extra_lock.html">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="login.html">
								<i class="icon-key"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
	</div>
	<!-- END HEADER TOP -->
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu" style="display: block;">
		<div class="container">
			<!-- BEGIN HEADER SEARCH BOX -->
			<form class="search-form" action="extra_search.html" method="GET">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search" name="query">
					<span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
				</div>
			</form>
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="index.html">Dashboard</a>
					</li>
					<li class="menu-dropdown mega-menu-dropdown">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle hover-initialized">
						Features <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu" style="min-width: 710px">
							<li>
								<div class="mega-menu-content">
									<div class="row">
										<div class="col-md-4">
											<ul class="mega-menu-submenu">
												<li>
													<h3>eCommerce</h3>
												</li>
												<li>
													<a href="ecommerce_index.html" class="iconify">
													<i class="icon-home"></i>
													eCommerce </a>
												</li>
												<li>
													<a href="ecommerce_orders.html" class="iconify">
													<i class="icon-basket"></i>
													Manage Orders </a>
												</li>
												<li>
													<a href="ecommerce_orders_view.html" class="iconify">
													<i class="icon-tag"></i>
													Order View </a>
												</li>
												<li>
													<a href="ecommerce_products.html" class="iconify">
													<i class="icon-handbag"></i>
													Manage Products </a>
												</li>
												<li>
													<a href="ecommerce_products_edit.html" class="iconify">
													<i class="icon-pencil"></i>
													Product Edit </a>
												</li>
											</ul>
										</div>
										<div class="col-md-4">
											<ul class="mega-menu-submenu">
												<li>
													<h3>Layouts</h3>
												</li>
												<li>
													<a href="layout_fluid.html" class="iconify">
													<i class="icon-cursor-move"></i>
													Fluid Layout </a>
												</li>
												<li>
													<a href="layout_mega_menu_fixed.html" class="iconify">
													<i class="icon-pin"></i>
													Fixed Mega Menu </a>
												</li>
												<li>
													<a href="layout_top_bar_fixed.html" class="iconify">
													<i class="icon-bar-chart"></i>
													Fixed Top Bar </a>
												</li>
												<li>
													<a href="layout_light_header.html" class="iconify">
													<i class="icon-paper-plane"></i>
													Light Header Dropdowns </a>
												</li>
												<li>
													<a href="layout_blank_page.html" class="iconify">
													<i class="icon-doc"></i>
													Blank Page Layout </a>
												</li>
											</ul>
										</div>
										<div class="col-md-4">
											<ul class="mega-menu-submenu">
												<li>
													<h3>More Layouts</h3>
												</li>
												<li>
													<a href="layout_click_dropdowns.html" class="iconify">
													<i class="icon-speech"></i>
													Click vs. Hover Dropdowns </a>
												</li>
												<li>
													<a href="layout_fontawesome_icons.html" class="iconify">
													<i class="icon-link"></i>
													Layout with Fontawesome </a>
												</li>
												<li>
													<a href="layout_glyphicons.html" class="iconify">
													<i class="icon-settings"></i>
													Layout with Glyphicon </a>
												</li>
												<li>
													<a href="layout_language_bar.html" class="iconify">
													<i class="icon-globe"></i>
													Language Switch Bar </a>
												</li>
												<li>
													<a href="layout_disabled_menu.html" class="iconify">
													<i class=" icon-lock"></i>
													Disabled Menu Links </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li class="menu-dropdown mega-menu-dropdown mega-menu-full">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle hover-initialized">
						UI Components <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li>
								<div class="mega-menu-content">
									<div class="row">
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3>UI Components</h3>
												</li>
												<li>
													<a href="ui_general.html">
													<i class="fa fa-angle-right"></i>
													General </a>
												</li>
												<li>
													<a href="ui_buttons.html">
													<i class="fa fa-angle-right"></i>
													Buttons </a>
												</li>
												<li>
													<a href="ui_icons.html">
													<i class="fa fa-angle-right"></i>
													Font Icons </a>
												</li>
												<li>
													<a href="ui_colors.html">
													<i class="fa fa-angle-right"></i>
													Flat UI Colors </a>
												</li>
												<li>
													<a href="ui_typography.html">
													<i class="fa fa-angle-right"></i>
													Typography </a>
												</li>
												<li>
													<a href="ui_tabs_accordions_navs.html">
													<i class="fa fa-angle-right"></i>
													Tabs, Accordions &amp; Navs </a>
												</li>
												<li>
													<a href="ui_tree.html">
													<i class="fa fa-angle-right"></i>
													Tree View </a>
												</li>
												<li>
													<a href="ui_page_progress_style_1.html">
													<i class="fa fa-angle-right"></i>
													Page Progress Bar <span class="badge badge-roundless badge-warning">new</span></a>
												</li>
												<li>
													<a href="ui_blockui.html">
													<i class="fa fa-angle-right"></i>
													Block UI </a>
												</li>
												<li>
													<a href="ui_bootstrap_growl.html">
													<i class="fa fa-angle-right"></i>
													Bootstrap Growl Notifications <span class="badge badge-roundless badge-warning">new</span></a>
												</li>
												<li>
													<a href="ui_notific8.html">
													<i class="fa fa-angle-right"></i>
													Notific8 Notifications </a>
												</li>
											</ul>
										</div>
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3>More UI Components</h3>
												</li>
												<li>
													<a href="ui_toastr.html">
													<i class="fa fa-angle-right"></i>
													Toastr Notifications </a>
												</li>
												<li>
													<a href="ui_alert_dialog_api.html">
													<i class="fa fa-angle-right"></i>
													Alerts &amp; Dialogs API <span class="badge badge-roundless badge-danger">new</span></a>
												</li>
												<li>
													<a href="ui_session_timeout.html">
													<i class="fa fa-angle-right"></i>
													Session Timeout </a>
												</li>
												<li>
													<a href="ui_idle_timeout.html">
													<i class="fa fa-angle-right"></i>
													User Idle Timeout </a>
												</li>
												<li>
													<a href="ui_modals.html">
													<i class="fa fa-angle-right"></i>
													Modals </a>
												</li>
												<li>
													<a href="ui_extended_modals.html">
													<i class="fa fa-angle-right"></i>
													Extended Modals </a>
												</li>
												<li>
													<a href="ui_tiles.html">
													<i class="fa fa-angle-right"></i>
													Tiles </a>
												</li>
												<li>
													<a href="ui_datepaginator.html">
													<i class="fa fa-angle-right"></i>
													Date Paginator </a>
												</li>
												<li>
													<a href="ui_nestable.html">
													<i class="fa fa-angle-right"></i>
													Nestable List </a>
												</li>
											</ul>
										</div>
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3>Form Stuff</h3>
												</li>
												<li>
													<a href="form_controls_md.html">
													<i class="fa fa-angle-right"></i>
													Material Design<br>
													Form Controls </a>
												</li>
												<li>
													<a href="form_controls.html">
													<i class="fa fa-angle-right"></i>
													Bootstrap<br>
													Form Controls </a>
												</li>
												<li>
													<a href="form_icheck.html">
													<i class="fa fa-angle-right"></i>
													iCheck Controls </a>
												</li>
												<li>
													<a href="form_layouts.html">
													<i class="fa fa-angle-right"></i>
													Form Layouts </a>
												</li>
												<li>
													<a href="form_editable.html">
													<i class="fa fa-angle-right"></i>
													Form X-editable <span class="badge badge-roundless badge-success">new</span></a>
												</li>
												<li>
													<a href="form_wizard.html">
													<i class="fa fa-angle-right"></i>
													Form Wizard </a>
												</li>
												<li>
													<a href="form_validation.html">
													<i class="fa fa-angle-right"></i>
													Form Validation </a>
												</li>
												<li>
													<a href="form_image_crop.html">
													<i class="fa fa-angle-right"></i>
													Image Cropping </a>
												</li>
												<li>
													<a href="form_fileupload.html">
													<i class="fa fa-angle-right"></i>
													Multiple File Upload </a>
												</li>
												<li>
													<a href="form_dropzone.html">
													<i class="fa fa-angle-right"></i>
													Dropzone File Upload </a>
												</li>
											</ul>
										</div>
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3>Form Components</h3>
												</li>
												<li>
													<a href="components_pickers.html">
													<i class="fa fa-angle-right"></i>
													Date &amp; Time Pickers </a>
												</li>
												<li>
													<a href="components_context_menu.html">
													<i class="fa fa-angle-right"></i>
													Context Menu </a>
												</li>
												<li>
													<a href="components_dropdowns.html">
													<i class="fa fa-angle-right"></i>
													Custom Dropdowns </a>
												</li>
												<li>
													<a href="components_form_tools.html">
													<i class="fa fa-angle-right"></i>
													Form Widgets &amp; Tools </a>
												</li>
												<li>
													<a href="components_form_tools2.html">
													<i class="fa fa-angle-right"></i>
													Form Widgets &amp; Tools 2 </a>
												</li>
												<li>
													<a href="components_editors.html">
													<i class="fa fa-angle-right"></i>
													Markdown &amp; WYSIWYG Editors </a>
												</li>
												<li>
													<a href="components_ion_sliders.html">
													<i class="fa fa-angle-right"></i>
													Ion Range Sliders </a>
												</li>
												<li>
													<a href="components_noui_sliders.html">
													<i class="fa fa-angle-right"></i>
													NoUI Range Sliders </a>
												</li>
												<li>
													<a href="components_jqueryui_sliders.html">
													<i class="fa fa-angle-right"></i>
													jQuery UI Sliders </a>
												</li>
												<li>
													<a href="components_knob_dials.html">
													<i class="fa fa-angle-right"></i>
													Knob Circle Dials </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li class="menu-dropdown classic-menu-dropdown">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="hover-initialized">
						Extra <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
							<li class=" dropdown-submenu">
								<a href=":;">
								<i class="icon-briefcase"></i>
								Data Tables </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="table_basic.html">
										Basic Datatables </a>
									</li>
									<li class=" ">
										<a href="table_tree.html">
										Tree Datatables </a>
									</li>
									<li class=" ">
										<a href="table_responsive.html">
										Responsive Datatables </a>
									</li>
									<li class=" ">
										<a href="table_managed.html">
										Managed Datatables </a>
									</li>
									<li class=" ">
										<a href="table_editable.html">
										Editable Datatables </a>
									</li>
									<li class=" ">
										<a href="table_advanced.html">
										Advanced Datatables </a>
									</li>
									<li class=" ">
										<a href="table_ajax.html">
										Ajax Datatables </a>
									</li>
								</ul>
							</li>
							<li class=" dropdown-submenu">
								<a href=":;">
								<i class="icon-wallet"></i>
								Portlets </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="portlet_general.html">
										General Portlets </a>
									</li>
									<li class=" ">
										<a href="portlet_general2.html">
										New Portlets #1 <span class="badge badge-roundless badge-danger">new</span>
										</a>
									</li>
									<li class=" ">
										<a href="portlet_general3.html">
										New Portlets #2 <span class="badge badge-roundless badge-danger">new</span>
										</a>
									</li>
									<li class=" ">
										<a href="portlet_ajax.html">
										Ajax Portlets </a>
									</li>
									<li class=" ">
										<a href="portlet_draggable.html">
										Draggable Portlets </a>
									</li>
								</ul>
							</li>
							<li class=" dropdown-submenu">
								<a href=":;">
								<i class="icon-bar-chart"></i>
								Charts </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="charts_amcharts.html">
										amChart </a>
									</li>
									<li class=" ">
										<a href="charts_flotcharts.html">
										Flotchart </a>
									</li>
								</ul>
							</li>
							<li class=" dropdown-submenu">
								<a href=":;">
								<i class="icon-pointer"></i>
								Maps </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="maps_google.html">
										Google Maps </a>
									</li>
									<li class=" ">
										<a href="maps_vector.html">
										Vector Maps </a>
									</li>
								</ul>
							</li>
							<li class=" dropdown-submenu">
								<a href=":;">
								<i class="icon-puzzle"></i>
								Multi Level </a>
								<ul class="dropdown-menu">
									<li class=" ">
										<a href="javascript:;">
										<i class="icon-settings"></i>
										Item 1 </a>
									</li>
									<li class=" ">
										<a href="javascript:;">
										<i class="icon-user"></i>
										Item 2 </a>
									</li>
									<li class=" ">
										<a href="javascript:;">
										<i class="icon-globe"></i>
										Item 3 </a>
									</li>
									<li class=" dropdown-submenu">
										<a href="#">
										<i class="icon-folder"></i>
										Sub Items </a>
										<ul class="dropdown-menu">
											<li class=" ">
												<a href="javascript:;">
												Item 1 </a>
											</li>
											<li class=" ">
												<a href="javascript:;">
												Item 2 </a>
											</li>
											<li class=" ">
												<a href="javascript:;">
												Item 3 </a>
											</li>
											<li class=" ">
												<a href="javascript:;">
												Item 4 </a>
											</li>
										</ul>
									</li>
									<li class=" ">
										<a href="javascript:;">
										<i class="icon-share"></i>
										Item 4 </a>
									</li>
									<li class=" ">
										<a href="javascript:;">
										<i class="icon-bar-chart"></i>
										Item 5 </a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="menu-dropdown mega-menu-dropdown mega-menu-full">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle hover-initialized">
						Pages <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li>
								<div class="mega-menu-content">
									<div class="row">
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3>User Pages</h3>
												</li>
												<li>
													<a href="page_timeline.html">
													<i class="fa fa-angle-right"></i>
													New Timeline <span class="badge badge-warning">2</span></a>
												</li>
												<li>
													<a href="extra_profile.html">
													<i class="fa fa-angle-right"></i>
													New User Profile <span class="badge badge-success badge-roundless">new</span></a>
												</li>
												<li>
													<a href="page_todo.html">
													<i class="fa fa-angle-right"></i>
													Todo &amp; Tasks <span class="badge badge-danger">4</span></a>
												</li>
												<li>
													<a href="inbox.html">
													<i class="fa fa-angle-right"></i>
													User Inbox <span class="badge badge-success">4</span></a>
												</li>
												<li>
													<a href="page_calendar.html">
													<i class="fa fa-angle-right"></i>
													User Calendar <span class="badge badge-warning">14</span></a>
												</li>
												<li>
													<a href="page_timeline_old.html">
													<i class="fa fa-angle-right"></i>
													Old Timeline <span class="badge badge-warning">2</span></a>
												</li>
												<li>
													<a href="extra_profile_old.html">
													<i class="fa fa-angle-right"></i>
													Old User Profile </a>
												</li>
											</ul>
										</div>
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3>General Pages</h3>
												</li>
												<li>
													<a href="extra_faq.html">
													<i class="fa fa-angle-right"></i>
													FAQ Page </a>
												</li>
												<li>
													<a href="page_portfolio.html">
													<i class="fa fa-angle-right"></i>
													Portfolio </a>
												</li>
												<li>
													<a href="page_timeline.html">
													<i class="fa fa-angle-right"></i>
													Timeline <span class="badge badge-info">4</span></a>
												</li>
												<li>
													<a href="page_coming_soon.html">
													<i class="fa fa-angle-right"></i>
													Coming Soon </a>
												</li>
												<li>
													<a href="extra_invoice.html">
													<i class="fa fa-angle-right"></i>
													Invoice </a>
												</li>
												<li>
													<a href="page_blog.html">
													<i class="fa fa-angle-right"></i>
													Blog </a>
												</li>
												<li>
													<a href="page_blog_item.html">
													<i class="fa fa-angle-right"></i>
													Blog Post </a>
												</li>
											</ul>
										</div>
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3>Custom Pages</h3>
												</li>
												<li>
													<a href="page_news.html">
													<i class="fa fa-angle-right"></i>
													News <span class="badge badge-success">9</span></a>
												</li>
												<li>
													<a href="page_news_item.html">
													<i class="fa fa-angle-right"></i>
													News View </a>
												</li>
												<li>
													<a href="page_about.html">
													<i class="fa fa-angle-right"></i>
													About Us </a>
												</li>
												<li>
													<a href="page_contact.html">
													<i class="fa fa-angle-right"></i>
													Contact Us </a>
												</li>
												<li>
													<a href="extra_search.html">
													<i class="fa fa-angle-right"></i>
													Search Results </a>
												</li>
												<li>
													<a href="extra_pricing_table.html">
													<i class="fa fa-angle-right"></i>
													Pricing Tables </a>
												</li>
												<li>
													<a href="login.html">
													<i class="fa fa-angle-right"></i>
													Login Form 1 </a>
												</li>
												<li>
													<a href="login_2.html">
													<i class="fa fa-angle-right"></i>
													Login Form 2 </a>
												</li>
												<li>
													<a href="login_3.html">
													<i class="fa fa-angle-right"></i>
													Login Form 3 </a>
												</li>
												<li>
													<a href="login_soft.html">
													<i class="fa fa-angle-right"></i>
													Login Form 4 </a>
												</li>
											</ul>
										</div>
										<div class="col-md-3">
											<ul class="mega-menu-submenu">
												<li>
													<h3>Miscellaneous</h3>
												</li>
												<li>
													<a href="extra_lock.html">
													<i class="fa fa-angle-right"></i>
													Lock Screen 1 </a>
												</li>
												<li>
													<a href="extra_lock2.html">
													<i class="fa fa-angle-right"></i>
													Lock Screen 2 </a>
												</li>
												<li>
													<a href="extra_404_option1.html">
													<i class="fa fa-angle-right"></i>
													404 Page Option 1 </a>
												</li>
												<li>
													<a href="extra_404_option2.html">
													<i class="fa fa-angle-right"></i>
													404 Page Option 2 </a>
												</li>
												<li>
													<a href="extra_404_option3.html">
													<i class="fa fa-angle-right"></i>
													404 Page Option 3 </a>
												</li>
												<li>
													<a href="extra_500_option1.html">
													<i class="fa fa-angle-right"></i>
													500 Page Option 1 </a>
												</li>
												<li>
													<a href="extra_500_option2.html">
													<i class="fa fa-angle-right"></i>
													500 Page Option 2 </a>
												</li>
												<li>
													<a href="email_template1.html">
													<i class="fa fa-angle-right"></i>
													New Email Template 1 </a>
												</li>
												<li>
													<a href="email_template2.html">
													<i class="fa fa-angle-right"></i>
													New Email Template 2 </a>
												</li>
												<li>
													<a href="email_template3.html">
													<i class="fa fa-angle-right"></i>
													New Email Template 3 </a>
												</li>
												<li>
													<a href="email_template4.html">
													<i class="fa fa-angle-right"></i>
													New Email Template 4 </a>
												</li>
												<li>
													<a href="email_newsletter.html">
													<i class="fa fa-angle-right"></i>
													Old Email Template 1 </a>
												</li>
												<li>
													<a href="email_system.html">
													<i class="fa fa-angle-right"></i>
													Old Email Template 2 </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li class="menu-dropdown">
						<a href="angularjs" target="_blank" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="AngularJS version demo">
						AngularJS Version </a>
					</li>
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
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
					<li <?php if ($active_menu == 'index')  { echo 'class=" active open"'; }  ?> >
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
						<li <?php if ($active_menu == 'societe')  { echo 'class=" active open"'; }  ?>>
						<a href="societe.php?action=list_societe">
						<i class="fa fa-university"></i>
						<span class="title">Sociétés </span>
						<?php 		if (isset($nav_societe) ){			 ?>
						<span class="arrow "></span>
						<?php } ?>
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
						<li <?php if ($active_submenu == 'article')  { echo 'class="active"'; }  ?>>
							<a href="produit.php?action=article">
							<i class="fa fa-cube"></i>
							Article</a>
							<ul class="sub-menu">
														
							<li <?php if ($active_submenu == 'list_produit')  { echo 'class="active"'; }  ?>>
								<a href="produit.php?action=list_produit">
								Article</a>
							</li>
							<li <?php if ($active_submenu == 'list_mesure')  { echo 'class="active"'; }  ?>>
								<a href="unite_mesure.php?action=list_mesure">
								Unités de mesure</a>
							</li>
							<li <?php if ($active_submenu == 'list_famille')  { echo 'class="active"'; }  ?>>
								<a href="famille.php?action=list_famille">
								Famille</a>
							</li>
							<li <?php if ($active_submenu == 'article')  { echo 'class="active"'; }  ?>>
								<a href="produit.php?action=stock">
								Stock</a>
							</li>
							</ul>
						</li>
						<li <?php if ($active_submenu == 'tiers')  { echo 'class="active"'; }  ?>>
							<a href="tiers.php?action=tiers">
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
								<a href="operation.php?action=list_achat">
								Achats</a>
							</li>
							<li <?php if ($active_submenu == 'importation')  { echo 'class="active"'; }  ?>>
							<a href="importation.php?action=list_achat">
							Importation</a>
						</li>
							</ul>
						</li>
						<li <?php if ($active_submenu == 'production')  { echo 'class="active"'; }  ?>>
							<a href="javascript:;">
							<i class="fa fa-wrench"></i>
							Production</a>
							<ul class="sub-menu">
							
							<li <?php if ($active_submenu == 'production')  { echo 'class="active"'; }  ?>>
								<a href="production.php?action=formule">
								Formules</a>
							</li>
							<li <?php if ($active_submenu == 'production')  { echo 'class="active"'; }  ?>>
							<a href="production.php?action=production">
							Production</a>
						</li>
							</ul>
						</li>
						<li >
							<a href="javascript:;">
							<i class="fa fa-list"></i>
							Avoir</a>
							<ul class="sub-menu">
							<li <?php if ($active_submenu == 'list_vente')  { echo 'class="active"'; }  ?>>
								<a href="avoir.php?action=list_vente">
								Ventes</a>
							</li>
							<li <?php if ($active_submenu == 'list_achat')  { echo 'class="active"'; }  ?>>
								<a href="avoir.php?action=list_achat">
								Achats</a>
							</li>
							
							</ul>
						</li>

						<li <?php if ($active_submenu == 'reglement')  { echo 'class="active"'; }  ?>>
						<a href="reglement.php?action=list_reglement">
						<i class=" icon-credit-card"></i>
						
								Reglement</a>
						
						
						</li>
						<li <?php if ($active_submenu == 'reglement')  { echo 'class="active"'; }  ?>>
						<a href="reglement.php?action=list_reglement">
						<i class="fa fa-money"></i>
						
								Chèques</a>
						
						
						</li>
						<li <?php if ($active_submenu == 'Rapports')  { echo 'class="active"'; }  ?>>
						<a href="rapports.php?action=get_rapport" >
						<i class="fa fa-print"></i>
						<span class="title">Rapports</span>
						<span class="selected"></span>
						</a>
						
						</li>

						</ul>
					</li>
					
					<li <?php if ($active_menu == 'saisie')  { echo 'class="active"';} ?>>
						<a >
						<i class="fa fa-building"></i>
						<span class="title">Comptabilité</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li>
						<a >
						<i class="fa fa-list"></i>
						<span class="title">Plan</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li <?php if ($active_submenu == 'list_comptes')  { echo 'class="active"'; }  ?>>
						
							<a href="compte_comptable.php?action=list_comptes">
							<i class="fa fa-calendar"></i>
							Plan comptable</a>
						</li>
						<li <?php if ($active_submenu == 'list_journaux')  { echo 'class="active"'; }  ?>>
						
							<a href="journaux.php?action=list_journaux">
							<i class="fa fa-paperclip"></i>
							Journaux</a>
						</li>
						</ul>
						</li>
						
						<li>
						<a >
						<i class="fa fa-sliders"></i>
						<span class="title">Traitment</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li <?php if ($active_submenu == 'list_pieces')  { echo 'class="active"'; }  ?>>
						
							<a href="saisie.php?action=list_pieces">
							<i class="fa fa-clipboard"></i>
							Pièces Comptables</a>
						</li>
						<li <?php if ($active_submenu == 'list_ecritures')  { echo 'class="active"'; }  ?>>
						
							<a href="saisie.php?action=list_ecriture">
							<i class="fa fa-pencil-square"></i>
							Ecritures Comptables</a>
						</li>
						<li <?php if ($active_submenu == 'list_annexe_5')  { echo 'class="active"'; }  ?>>
						
							<a href="saisie.php?action=list_annexe_5">
							<i class="fa fa-file-text"></i>
							Annexe 5</a>
						</li>
						<li <?php if ($active_submenu == 'recherche_ecriture')  { echo 'class="active"'; }  ?>>
						
							<a href="rapports.php?action=recherche_ecriture">
							<i class="fa fa-search"></i>
							Recherche</a>
						</li>
						</ul>
						</li>
						<li>
						<a >
						<i class="fa fa-file-text"></i>
						<span class="title">Etats</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li <?php if ($active_submenu == 'balance')  { echo 'class="active"'; }  ?>>
						
							<a href="rapports.php?action=balance">
							<i class="fa fa-exchange"></i>
							Balance</a>
						</li>
						<li <?php if ($active_submenu == 'grand_livre')  { echo 'class="active"'; }  ?>>
						
							<a href="rapports.php?action=grand_livre">
							<i class="fa fa-book"></i>
							Grand Livre</a>
						</li>
						</ul>
						</li>
						<li>
						<a >
						<i class="fa fa-file-text"></i>
						<span class="title">Liasse fiscale</span>
						<span class="selected"></span>
						</a>
						<ul class="sub-menu">
						<li <?php if ($active_submenu == 'Bilan_actif')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=Bilan_actif">
							<i class="fa fa-exchange"></i>
							BILAN ACTIF</a>
						</li>
						<li <?php if ($active_submenu == 'Bilan_passif')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=Bilan_passif">
							<i class="fa fa-book"></i>
							BILAN PASSIF</a>
						</li>
						<li <?php if ($active_submenu == 'TCR')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=tcr">
							<i class="fa fa- fa-list-alt"></i>
							TCR
							</a>
						</li>
						<li <?php if ($active_submenu == 'mouvements_stocks')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=mouvements_stocks">
							<i class="fa fa- fa-list-alt"></i>
							Annexe 1 
							</a>
						</li>
						<li <?php if ($active_submenu == 'annexe_2')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=annexe_2">
							<i class="fa fa- fa-list-alt"></i>
							Annexe 2 
							</a>
						</li>
						<li <?php if ($active_submenu == 'annexe_3')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=annexe_3">
							<i class="fa fa- fa-list-alt"></i>
							Annexe 3 
							</a>
						</li>
						<li <?php if ($active_submenu == 'annexe_4')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=annexe_4">
							<i class="fa fa- fa-list-alt"></i>
							Annexe 4 
							</a>
						</li>
						<li <?php if ($active_submenu == 'annexe_5')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=annexe_5">
							<i class="fa fa- fa-list-alt"></i>
							Annexe 5
							</a>
						</li>
						<li <?php if ($active_submenu == 'annexe_6')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=annexe_6">
							<i class="fa fa- fa-list-alt"></i>
							Annexe 6
							</a>
						</li>
						<li <?php if ($active_submenu == 'annexe_7')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=annexe_7">
							<i class="fa fa- fa-list-alt"></i>
							Annexe 7 
							</a>
						</li>
						<li <?php if ($active_submenu == 'annexe_8')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_bilan.php?action=annexe_8">
							<i class="fa fa- fa-list-alt"></i>
							Annexe 8 
							</a>
						</li>
						</ul>
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
					<li <?php if ($active_menu == 'g50')  { echo 'class=" active open"'; }  ?>>
						<a href="g50.php?action=list_g50">
						<i class="fa fa-archive"></i>
						<span class="title">G50</span>
						<span class="selected"></span>
						</a>
						
					</li>
					<li <?php if ($active_menu == 'documents')  { echo 'class=" active open"'; }  ?>>
						<a  href="documents.php?action=charger">
						<i class="fa fa-folder-open-o"></i>
						<span class="title">Documents</span>
						<span class="selected"></span>
						<span class="arrow "></span>
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
					
					
					
				
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
