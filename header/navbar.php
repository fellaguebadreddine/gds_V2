<div class="page-header">
	<!-- BEGIN HEADER TOP -->
	<?php

	 if(!empty($_SESSION['societe'])){
	$nav_societe = Societe::trouve_par_id($_SESSION['societe']);}
	if (isset($nav_societe->id_societe)) {
			$Detail_formules = Detail_formule::trouve_detail_formule_par_societe($nav_societe->id_societe);
			//var_dump($Detail_formules);
			foreach ($Detail_formules as $Detail_formule) {
				$Article = Produit::trouve_par_id($Detail_formule->id_Matiere_Premiere);
				if ($Article->matiere_premiere == 1) {
					$lot_prod = Lot_prod::trouve_first_lot($Article->id_pro);	
						if (isset($lot_prod->id)) {
					 			$Detail_formule->id_lot = $lot_prod->id;
					 			}
					 	$Detail_formule->save();
				}
			}
	}

	 ?>
	<div class="page-header-top">
		<div class="container-fluid">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="index.php">
				<img src="assets/image/fav.png" alt="logo" class="logo-default">
				</a>
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
						<?php 
			if (isset($nav_societe->id_societe) ){ 
				 $nbr_stock = count($table_ch = Produit::trouve_produit_par_societe_alert($nav_societe->id_societe));
				 
				 $nbr_alerts = 0;
				  $nbr_alerts = $nbr_stock;

			?>
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="icon-bell"></i>
						<?php if ($nbr_stock >0){echo 
						'<span class="badge badge-danger">' . $nbr_alerts ; '</span>';
						 }?>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3><span class="bold">12 pending</span> notifications</h3>
								<a href="#">view all</a>
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
								<?php 
								if ($nbr_stock >0){
									echo
									'<li>
										<a href="produit.php?action=stock">
										<span class="time">3 mins</span>
										<span class="details " >
										<span class="label label-sm label-icon label-warning">
										<i class="fa fa-bell-o"></i>
										</span>
										<b class="font-red-haze">' . $nbr_stock . ' Alert en stock </b>
										 </span>
										</a>
									</li>' ;
									
								}
								?>
								
									
								</ul>
							</li>
						</ul>
					</li>
					<?php }?>
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
										<img src="assets/admin/layout3/img/avatar2.jpg" class="img-circle" alt="">
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
										<img src="assets/admin/layout3/img/avatar3.jpg" class="img-circle" alt="">
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
										<img src="assets/admin/layout3/img/avatar1.jpg" class="img-circle" alt="">
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
										<img src="assets/admin/layout3/img/avatar2.jpg" class="img-circle" alt="">
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
										<img src="assets/admin/layout3/img/avatar3.jpg" class="img-circle" alt="">
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
						<img alt="" class="img-circle" src="assets/admin/layout3/img/avatar9.jpg">
						<span class="username username-hide-on-mobile">
						<?php if (!empty($user->nom_compler())) {
						echo  $user->nom_compler() ;
					} else{echo  $user->nom_clie; } ?> </span>
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
	</div>
	<!-- END HEADER TOP -->
	<!-- BEGIN HEADER MENU -->
	<div class="page-header-menu " style="display: block;">
		<div class="container-fluid">
			<!-- BEGIN HEADER SEARCH BOX -->
			
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu">
				<ul class="nav navbar-nav">
					<?php 		if (isset($nav_societe)){			 ?>
					<li <?php if ($active_menu == 'index')  { echo 'class=" active open"'; }  ?> >
						<a href="index.php">
						<i class="fa fa-home"></i>
						
						<span class="selected"></span>
						
						</a>
					</li>
						<?php } else{ ?>
						<li <?php if ($active_menu == 'index')  { echo 'class=" active open"'; }  ?>>
								<a href="index.php">
								<i class="fa fa-home"></i>
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
						<li <?php if ($active_menu == 'user')  { echo 'class=" active open"'; }  ?>>
							<a href="user.php?action=list_user">
							<i class="fa fa-user"></i>
							<span class="title">Utilisateurs </span>
							<?php 		if (isset($nav_societe) ){			 ?>
							<span class="arrow "></span>
							<?php } ?>
							<span class="selected"></span>
							
							</a>
						</li>
						<li <?php if ($active_menu == '#')  { echo 'class=" active open"'; }  ?>>
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="#">
						<i class="fa fa-gear"></i>
						<span class="title">Paramètres</span>
						<i class="fa fa-angle-down"></i>
						<span class="selected"></span>
						<span class="arrow "></span>
						</a>
						<ul class="dropdown-menu pull-left">
						<li <?php if ($active_submenu == 'banque')  { echo 'class="active"'; }  ?>>
							<a href="societe.php?action=banque">
							Banque</a>
						</li>
						
						<li <?php if ($active_submenu == 'tab_tva')  { echo 'class="active"'; }  ?>>
							<a href="societe.php?action=tab_tva">
							Taux de TVA</a>
						</li>
						
						</ul>

					</li>
						<?php }
						if (isset($nav_societe) ){
						?>
							
						<li class=" menu-dropdown classic-menu-dropdown " >
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" >
						
						Facturation <i class="fa fa-angle-down"></i>
						</a>
						<ul  class="dropdown-menu pull-left">
							<li class=" dropdown-submenu" >
								<a href="produit.php?action=article">
								<i class="icon-briefcase"></i>
								Article </a>
								<ul class="dropdown-menu">
									<li >
										<a href="produit.php?action=list_produit">
										Article</a>
									</li>
									<li >
										<a href="unite_mesure.php?action=list_mesure">
										Unités de mesure</a>
									</li>
									<li >
										<a href="famille.php?action=list_famille">
										Famille</a>
									</li>
									<li >
										<a href="produit.php?action=stock">
										Stock</a>
									</li>
								</ul>
							</li>
							<li class=" dropdown-submenu" >
								<a href="tiers.php?action=tiers">
								<i class="glyphicon glyphicon-user"></i>
								Tiers</a>
								<ul class="dropdown-menu">
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
							<li class=" dropdown-submenu">
								<a href="javascript:;">
								<i class="glyphicon glyphicon-list-alt"></i>
								Facturation</a>
								<ul class="dropdown-menu">
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
								<li <?php if ($active_submenu == 'depense')  { echo 'class="active"'; }  ?>>
								<a href="operation.php?action=list_depense">
								Dépenses</a>
								</li>
								</ul>
							</li>
							<li class=" dropdown-submenu">
								<a href="javascript:;">
								<i class="fa fa-wrench"></i>
								Production</a>
								<ul class="dropdown-menu">
								
								<li <?php if ($active_submenu == 'production')  { echo 'class="active"'; }  ?>>
									<a href="production.php?action=formule">
									Formules</a>
								</li>
								<li <?php if ($active_submenu == 'list_production')  { echo 'class="active"'; }  ?>>
								<a href="production.php?action=list_production">
								Production</a>
							</li>
								</ul>
							</li>
							<li class=" dropdown-submenu">
								<a href="javascript:;">
								<i class="fa fa-list"></i>
								Avoir</a>
								<ul class="dropdown-menu">
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
							<li class=" dropdown-submenu">
							<a href="reglement.php?action=list_reglement">
							<i class=" icon-credit-card"></i>
							
									Reglement</a>
							
							
							</li>
							<li class=" dropdown-submenu">
							<a href="rapports.php?action=get_rapport" >
							<i class="fa fa-print"></i>
							<span class="title">Rapports</span>
							<span class="selected"></span>
							</a>
							
							</li>

						</ul>
					</li>
					
					<li class="menu-dropdown classic-menu-dropdown">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						
						<span class="title">Comptabilité</span>
						<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
							<li  class=" dropdown-submenu">
								<a  href="">
								<i class="fa fa-list"></i>
								<span class="title">Plan</span>
								
								</a>
								<ul class="dropdown-menu">
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
						
						<li class=" dropdown-submenu">
						<a  href="#">
						<i class="fa fa-sliders"></i>
						<span class="title">Traitment</span>
						
						</a>
							<ul class="dropdown-menu">
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
							<li <?php if ($active_submenu == 'list_pieces')  { echo 'class="active"'; }  ?>>
							
								<a href="saisie.php?action=releve_comptes">
								<i class="fa fa-file-text-o"></i>
								Relevé des comptes </a>
							</li>
							<li <?php if ($active_submenu == 'recherche_ecriture')  { echo 'class="active"'; }  ?>>
							
								<a href="rapports.php?action=recherche_ecriture">
								<i class="fa fa-search"></i>
								Recherche</a>
							</li>
							</ul>
						</li>
						<li class=" dropdown-submenu">
						<a href=":;">
						<i class="fa fa-file-text"></i>
						<span class="title">Etats</span>
						
						</a>
						<ul class="dropdown-menu">
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
						<li <?php if ($active_submenu == 'etat_104')  { echo 'class="active"'; }  ?>>
						
							<a href="etat_104.php?action=etat_104">
							<i class="fa fa-file"></i>
							Etat 104</a>
						</li>
						</ul>
						</li>
						<li class=" dropdown-submenu">
						<a href=":;">
						<i class="fa fa-file-text"></i>
						<span class="title">Liasse fiscale</span>
						
						</a>
						<ul class="dropdown-menu">
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
					<li class="menu-dropdown classic-menu-dropdown" >
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						
						<span class="title">Paie</span>
						<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
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
						
						<span class="title">G50</span>
						<span class="selected"></span>
						</a>
						
					</li>
					
					<li  <?php if ($active_menu == 'Immobilisations')  { echo 'class="menu-dropdown classic-menu-dropdown active open"'; }  ?> >
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						
						<span class="title">Immobilisations</span>
						<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-left">
						<li <?php if ($active_submenu == 'list_immobilisations')  { echo 'class=" active open"'; }  ?>>
						<a href="immobilisation.php?action=list_immobilisations">
						<i class="glyphicon glyphicon-list-alt"></i>
						<span class="title">Liste Immobilisations</span>
						<span class="selected"></span>
						</a>
						
						</li>
						<li <?php if ($active_submenu == 'famille_immobilisations')  { echo 'class=" active open"'; }  ?>>
						<a href="immobilisation.php?action=famille_immobilisations">
						<i class="fa fa-share-alt"></i>
						<span class="title">Famille d'Immobilisations</span>
						<span class="selected"></span>
						</a>
						
						</li>
						
						</ul>
					</li>
					<li <?php if ($active_menu == 'documents')  { echo 'class=" active open"'; }  ?>>
						<a  href="documents.php?action=charger">
						
						<span class="title">Doc</span>
						<span class="selected"></span>
						<span class="arrow "></span>
						</a>
						

					</li>
					<li class="menu-dropdown classic-menu-dropdown">
						<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
						
						<span class="title"><i class="glyphicon glyphicon-cog"></i></span>
						<i class="fa fa-angle-down"></i>
						<span class="selected"></span>
						<span class="arrow "></span>
						</a>
						<ul class="dropdown-menu pull-left">
						<li <?php if ($active_submenu == 'list_banque')  { echo 'class="active"'; }  ?>>
							<a href="banque.php?action=list_banque">
							<i class="fa fa-university"></i>
							Banque</a>
						</li>
						<li <?php if ($active_submenu == 'list_caisse')  { echo 'class="active"'; }  ?>>
							<a href="caisse.php?action=list_caisse">
							<i class="fa fa-archive"></i>
							Caisse</a>
						</li>

						<li <?php if ($active_submenu == 'list_tva')  { echo 'class="active"'; }  ?>>
							<a href="tva.php?action=list_tva">
							<i class="fa fa-dollar"></i>
							Taux de TVA</a>
						</li>
						
						</ul>

					</li>
					<?php if ($user->id_societe == 0) {?>

					<li >
						<a  data-target="#close_societe" data-toggle="modal" class="font-red-haze bold">
						
						<span class="title">Fermer Sociéte</span>
						<span class="selected"></span>
						</a>
					</li>
						<?php } }?>
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	<!-- END HEADER MENU -->
</div>