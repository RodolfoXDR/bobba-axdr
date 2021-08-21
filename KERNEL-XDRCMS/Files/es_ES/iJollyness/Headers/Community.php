<?php
Site::SetOnline();
?>
<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<title><?php echo HotelName . ': ' . Site::$PageName; ?></title>		
		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo RES ?>vendor/bootstrap/bootstrap.css">
		<link rel="stylesheet" href="<?php echo RES ?>vendor/fontawesome/css/font-awesome.css">
		<link rel="stylesheet" href="<?php echo RES ?>vendor/owlcarousel/owl.carousel.min.css" media="screen">
		<link rel="stylesheet" href="<?php echo RES ?>vendor/owlcarousel/owl.theme.default.min.css" media="screen">
		<link rel="stylesheet" href="<?php echo RES ?>vendor/magnific-popup/magnific-popup.css" media="screen">
		<link rel='shortcut icon' href='<?php echo RES; ?>img/favicon.ico' type='image/x-icon'/ >
		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo RES ?>css/theme.css">
		<link rel="stylesheet" href="<?php echo RES ?>css/theme-elements.css">
		<link rel="stylesheet" href="<?php echo RES ?>css/theme-blog.css">
		<link rel="stylesheet" href="<?php echo RES ?>css/theme-shop.css">
		<link rel="stylesheet" href="<?php echo RES ?>css/theme-animate.css">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="<?php echo RES ?>vendor/rs-plugin/css/settings.css" media="screen">
		<link rel="stylesheet" href="<?php echo RES ?>vendor/circle-flip-slideshow/css/component.css" media="screen">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo RES ?>css/skins/default.css">
		<link rel="stylesheet" href="<?php echo RES ?>css/skins/jollyness.css?<?php echo rand(1,50); ?>">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo RES ?>css/custom.css">

		<!-- Head Libs -->
		<script src="<?php echo RES ?>vendor/modernizr/modernizr.js"></script>

		<!--[if IE]>
			<link rel="stylesheet" href="<?php echo RES ?>css/ie.css">
		<![endif]-->

		<!--[if lte IE 8]>
			<script src="<?php echo RES ?>vendor/respond/respond.js"></script>
			<script src="<?php echo RES ?>vendor/excanvas/excanvas.js"></script>
		<![endif]-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
	</head>
	<body>
		<div class="body">
			<header id="header">
				<div class="container">
					<div class="logo">
						<a href="<?php echo URL; ?>/">
							<img width="120" height="48" data-sticky-width="180" data-sticky-height="70" src="<?php echo RES ?>img/habbo-logo.png">
						</a>
					</div>
					<nav>
						<ul class="nav nav-pills nav-top">
						<li>
							<a class="active" href="#">
								<?php if(Site::$Settings['hotel.status.bool'] == 1): ?>
									<span style="display: -webkit-inline-box; padding: 0;" class="reload_users"></span> Usuarios Online
								<?php else: ?>
									Muchos Usuarios Online
								<?php endif; ?>
							</a>
						</li>
						<?php if(User::$Logged): ?>
						<?php if(User::hasPermission('ase.access')):?>
						<li>
							<a href="<?php echo HURL; ?>"><i class="fa fa-angle-right"></i>ASE</a>
						</li>
						<?php endif; ?>
						<li>
							<a href="<?php echo URL; ?>/account/logout?token=<?php echo User::$Row['token']; ?>"><i class="fa fa-angle-right"></i>Salir</a>
						</li>
						<?php endif; ?>
						</ul>
					</nav>
					<button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
						<i class="fa fa-bars"></i>
					</button>
				</div>	
				<div class="navbar-collapse nav-main-collapse collapse">
					<div class="container">
						<nav class="nav-main mega-menu">
							<ul class="nav nav-pills nav-main" id="mainMenu">
								<?php
									//aXDR 2.0 Navi System
									if(User::$Logged)
									$NaviPages = [
										User::$Data['name'] => '/me',
										'Comunidad' => '/community',
										'Noticias' => '/articles',
										'Equipo' => '/team',
										//'Tienda' => '/shop'
									];
									else
									$NaviPages = [
										'Comunidad' => '/community',
										'Noticias' => '/articles',
										'Equipo' => '/team',
										//'Tienda' => '/shop'
									];
								
									if(Site::$Settings['staff.page.visibility'] == 1 && User::$Data['rank'] < 3)
										unset($NaviPages['Equipo']);
								
									$NaviUrls = [
										User::$Data['name'] => ['/me', '/profile'],
										'Comunidad' => ['/community', '/top'],
										'Noticias' => ['/articles'],
										'Equipo' => ['/team', '/alpha'],
										//'Tienda' => ['/shop'],
									];

									foreach ($NaviPages as $PageName => $PageUrl):
										$s = (URI == $PageUrl);
										$_c = (count($NaviUrls[$PageName]) > 1);
										$c = ((count($NaviUrls[$PageName]) > 1) ? 'class="dropdown"' : '');
								?>
									<li <?php echo $c; ?>">
										<a class="dropdown-toggle disabled" href="<?php echo URL . $PageUrl; ?>"><?php echo $PageName; ?> <?php if($_c): ?><i class="fa fa-angle-down"></i><?php endif; ?></a>
										<?php if($_c):?>
											<ul class="dropdown-menu">
											<?php
												$Navi2Pages = [
													User::$Data['name'] => [
														'Ajustes' => '/profile'
													],
													'Comunidad' => [
														'Tops' => '/top'
													],
													'Noticias' => [
													],
													'Equipo' => [
														'Alfas' => '/alpha'
													],
													'Tienda' => [
													]
												];
												
												foreach ($Navi2Pages[$PageName] as $SubPageName => $SubPageUrl):
											?>
												<li><a href="<?php echo $SubPageUrl; ?>"><?php echo $SubPageName; ?></a></li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</nav>
					</div>
				</div>
			</header>
			<br />