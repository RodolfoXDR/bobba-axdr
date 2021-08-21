<html>
	<head>
		<meta charset="UTF-8">
		
		<title><?php echo HotelName . ': ' . Site::$PageName; ?></title>
		
		<link rel="stylesheet" href="<?php echo RES ?>CSS/v1_global.css" />
		<link rel="stylesheet" href="<?php echo RES; ?>CSS/v0_main.css" />
		<link rel="stylesheet" href="<?php echo RES; ?>CSS/v2_boxes.css" />
		<link rel="stylesheet" href="<?php echo RES ?>CSS/v2_fonts.css" />
		<link rel="stylesheet" href="<?php echo RES; ?>CSS/v2_404.css" />
		<script src='https://www.google.com/recaptcha/api.js'></script>
		
		<script>
		window.console = window.console || function(t) {};
		</script>
	</head>

  <body translate="no">

	<div id="page">
	
		<div id="toolbar" class="<?php echo Site::$PageColor; ?>" style="height:70px;">
		<div id="actions">
			<div class="spacer"></div>
			<div class="icon">
				<p><b><?php echo Site::$Onlines; ?></b> Online</p>
			</div>
		</div>
			
			<div id="title" class="login">
			<?php echo HotelName; ?>
			</div>
		</div>