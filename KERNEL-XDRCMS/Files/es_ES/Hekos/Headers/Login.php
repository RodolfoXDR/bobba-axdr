<?php
Site::SetOnline();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo HotelName; ?>: Inicio</title>

        <link rel="stylesheet" href="<?php echo URL . RES; ?>css/login_v1.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" >

        <script src="https://code.jquery.com/jquery-latest.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script src="<?php echo URL . RES ?>js/login.js"></script>

        <script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
    <body>
		<header class="header">
            <div class="header__container">
                <div class="header__row">
                    <section class="header__column">
                        <a href="#" class="header__logo__link">
                            <h1 class="header__logo">Hekos</h1>
                        </a>
                        <hgroup class="speech-bubble">
                            <p>¡
                            <?php if(Site::$Settings['hotel.status.bool'] == 1): ?>
				               <b><span style="display: -webkit-inline-box; padding: 0;" class="reload_users"></span></b> Usuarios Online
			                <?php else: ?>
				                Muchos Usuarios Online
			                <?php endif; ?>
                            !</p>
                        </hgroup>
                    </section>
                    <section class="header__column">
                            <a href="<?php echo URL . (Site::$Settings['RegisterEnabled'] == 1 ? '/quickregister/start' : '#');?>" class="header__register__link <?php echo (Site::$Settings['RegisterEnabled'] == 1) ? '' : 'disabled'; ?>">
								<?php echo (Site::$Settings['RegisterEnabled'] == 1) ? 'Registrarme' : '<i class="fas fa-lock"></i>  Hotel Cerrado'; ?>
                            </a>
                    </section>
                </div>
            </div>
        </header>