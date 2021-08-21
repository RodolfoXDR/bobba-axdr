<?php
	$e = isset($_GET['e']) ? $_GET['e'] : 0;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo LongName; ?>: ASE</title>
	
	<link rel="stylesheet" href="public/css/main.201806101917.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
	<link id="subStyle" rel="stylesheet" href="<?php if(isset($_COOKIE['acpColor']) && is_numeric($_COOKIE['acpColor']) && isset($_acpColors[$_COOKIE['acpColor']])): ?>public/css/main<?php echo $_acpColors[$_COOKIE['acpColor']]; ?>.201806101917.css<?php endif; ?>">
	<link rel="stylesheet" href="public/css/icons.css" />
	
	
	<script src="public/js/jquery-2.1.3.min.js"></script>
    <script src="public/js/metro.js"></script>
</head>
<body>
	<div id="jolly__upper_bar">
	<div id="title"><?php echo LongName; ?></div>
	</div>
	<div class="container">
		<div class="row2">
			<div class="cell">
				<h1 id="login__title">Iniciar Sesión</h1>
				<?php if(isset($e) && ($e == Text::ACP_LOGIN_ERROR || $e == Text::ACP_LOGIN_RANK || $e == Text::ACP_LOGIN_EMPTY_BOTH)): ?>
					<div id="error"><?php echo Text::Get($e); ?></div>
					<?php endif; ?>
				<form style="float:none" action="<?php echo HHURL; ?>/login" method="post">
					<div class="input-control modern text" data-role="input">
						<input type="text" name="login">
						<span class="label">Usuario</span>
						<span class="placeholder">Usuario</span>
					</div>
					<br><br>
					<div class="input-control modern text" data-role="input">
						<input type="password" name="password">
						<span class="label">Contraseña</span>
						<span class="placeholder">Contraseña</span>
					</div>
					<br><br>
					<?php if(Config::$Restrictions['security']['secretKeys']['enabled']): ?>
					<div class="input-control modern text" data-role="input">
						<input type="password" maxlength="5" name="secretKey">
						<span class="label">Secret Key</span>
						<span class="placeholder">Secret Key</span>
					</div>
					<br><br>
					<?php endif; ?>
					<button class="button" type="submit">Conectar</button>
				</form>
			</div>
			<div class="v-divider"></div>
			<div class="cell">
				<h2>Bienvenido al Control Panel de <?php echo LongName; ?></h2>
				<div class="listview-outlook" data-role="listview">
					<div class="list-group ">
						<span class="list-group-toggle">Actualizaciones</span>
						<div class="list-group-content">
						<?php
							if($query && $query->num_rows):
								while($queryRow = $query->fetch_assoc()):
								
									switch($queryRow['type']):
										case 0:
											$Category = "Web";
											break;
										case 1:
											$Category = "Cliente";
											break;
										case 2:
											$Category = "All Seeing Eye";
											break;
										case 3:
											$Category = "Otro";
											break;
										default:
											$Category = 'Unknown';
									endswitch;
								
						?>
							<a class="list marked" href="#">
								<div class="list-content">
									<span class="list-title"><?php echo $queryRow['title'];?></span>
									<span class="list-subtitle"><?php echo $Category; ?></span>
									<span class="list-remark">REVISION <?php echo $queryRow['date'];?></span>
								</div>
							</a>
						<?php
								endwhile;
							endif;
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<body>