<?php
Site::SetOnline();
?>
<html class="skrollr skrollr-desktop">
	<head>
		<meta charset="UTF-8">
		
		<title><?php echo HotelName . ': ' . Site::$PageName; ?></title>
		
		<link rel="stylesheet" href="<?php echo RES ?>CSS/v1_global.css?<?php echo rand(1,50); ?>" />
		<link rel="stylesheet" href="<?php echo RES; ?>CSS/v0_main.css?<?php echo rand(1,50); ?>" />
		<link rel="stylesheet" href="<?php echo RES; ?>CSS/v2_boxes.css?<?php echo rand(1,50); ?>" />
		<link rel="stylesheet" href="<?php echo RES ?>CSS/v2_fonts.css" />
		<link rel="stylesheet" href="<?php echo RES; ?>CSS/v2_404.css" />
		<link rel='shortcut icon' href='<?php echo RES; ?>CSS/Images/web/favicon.ico' type='image/x-icon'/ >
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-1157334545507939",
          enable_page_level_ads: true
     });
</script>
		<script>
		window.console = window.console || function(t) {};
		</script>
	</head>

  <body translate="no">

	<div id="page">
		<div id="toolbar" class="<?php echo Site::$PageColor; ?> scrolly" data-0="height:192px" data-128="height: 64px" class="skrollable skrollable-between" style="height: 192px;">
		<div id="hotel-bg" class="skrollable skrollable-between <?php echo Site::$PageName; ?>" data-0="height:192px; background-position:0 35px;" data-128="height: 64px; background-position:0 0"></div>
		<div id="actions">
      <div class="icon">
		<p>
			<?php if(Site::$Settings['hotel.status.bool'] == 1): ?>
				<span style="display: -webkit-inline-box; padding: 0;" class="reload_users"></span> Usuarios Online
			<?php else: ?>
				Muchos Usuarios Online
			<?php endif; ?>

		</p>
      </div>
			<div class="spacer"></div>
			
			<?php if(!User::$Logged): ?>
				<div class="icon">
					<a class="links" href="<?php echo URL; ?>">Conectar</a>
				</div>
				<?php if(Site::$Settings['RegisterEnabled'] == 0): ?>
				<div class="icon">
					<a class="links" href="/quickregister/start">¡ÚNETE AHORA!</a>
				</div>
				<?php endif; ?>
			<?php else:  ?>
			
			<?php
			
			//aXDR 2.0 Navi System
			
			$NaviPages = [
				User::$Data['name'] => '/me',
				//'Comunidad' => '/community',
				'Noticias' => '/articles',
				'Equipo' => '/team',
				'Alfas' => '/alpha',
				//'Tops' => '/top',
				//'Tienda' => '/shop'
			];

			if(Site::$Settings['staff.page.visibility'] == 1 && User::$Data['rank'] < 3)
				unset($NaviPages['Equipo']);
			
			foreach ($NaviPages as $PageName => $PageUrl):
				$s = (URI == $PageUrl);
			?>
			
			<div class="icon">
				<?php if(!$s): ?>
					<a class="links" href="<?php echo URL . $PageUrl; ?>"><?php echo $PageName; ?></a>
				<?php else: ?>
					<strong><?php echo $PageName; ?></strong>
				<?php endif; ?>
			</div>
			
			<?php endforeach; ?>
				<div class="icon">
					<a class="links" href="<?php echo URL; ?>/account/logout?token=<?php echo User::$Row['token']; ?>">Salir</a>
				</div>
			<?php endif; ?>
		</div>
			
			<div id="title" data-0="font-size: 60px; padding: 0 0 24px 120px;" data-128="font-size: 39px; padding: 0 0 5px 90px;" class="skrollable skrollable-between" style="font-size: 60px; padding: 0px 0px 24px 12px;">
				<div class="if__logo"></div><?php echo HotelName; ?>
			</div>
		</div>