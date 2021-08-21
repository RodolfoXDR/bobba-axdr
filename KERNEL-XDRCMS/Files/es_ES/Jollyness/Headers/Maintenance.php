<html>
	<head>
		<meta charset="UTF-8">
		
		<title><?php echo HotelName . ': ' . Site::$PageName; ?></title>
		
		<link rel="stylesheet" href="<?php echo RES ?>CSS/v0_main.css" />
		<link rel="stylesheet" href="<?php echo RES ?>CSS/v1_global.css" />
		<link rel="stylesheet" href="<?php echo RES ?>CSS/v2_fonts.css" />
		<link rel="stylesheet" href="<?php echo RES ?>CSS/v2_boxes.css" />
		<script src='https://www.google.com/recaptcha/api.js'></script>
		
		<script>
		window.console = window.console || function(t) {};
		</script>
	</head>

  <body translate="no" style="height: 1226px;">

	<div id="page">
	
		<div id="toolbar" class="<?php echo Site::$PageColor; ?>"style="height:192px;">
		<div id="hotel-bg" style="height: 192px; background-position: 0 -140px;"></div>
			
			<div id="title" style="font-size: 60px; padding: 0 0 24px 120px;">
				<?php echo HotelName; ?> 
			</div>
		</div>