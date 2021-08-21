<?php
const FastLoad = true;
require '../../../KERNEL-XDRCMS/Init.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo HotelName; ?>: La petición se ha realizado con éxito </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo URL; ?><?php echo RES; ?>/v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="alternate" type="application/rss+xml" title="<?php echo HotelName; ?>: RSS" href="<?php echo URL; ?>/articles/rss.xml" />

<link rel="stylesheet" href="<?php echo RES; ?>/static/styles/common.css" type="text/css" />
<link rel="stylesheet" href="<?php echo RES; ?>/static/styles/process.css" type="text/css" />
<script src="<?php echo RES; ?>/static/js/libs2.js" type="text/javascript"></script>

<script src="<?php echo RES; ?>/static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo RES; ?>/static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo RES; ?>/static/js/common.js" type="text/javascript"></script>
<script src="<?php echo RES; ?>/static/js/fullcontent.js" type="text/javascript"></script>
<link rel="stylesheet" href="/styles/local/secure.es.css" type="text/css" />

<script src="/js/local/secure.es.js" type="text/javascript"></script>

<script type="text/javascript">
var ad_keywords = "";
var ad_key_value = "";
</script>
<script type="text/javascript">
document.habboLoggedIn = false;
var habboName = null;
var habboId = null;
var habboReqPath = "";
var habboStaticFilePath = "<?php echo RES; ?>/";
var habboImagerUrl = "<?php echo URL; ?>/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo URL; ?>/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "client";
    HabboClient.maximizeWindow = true;
}


</script>

<meta property="fb:app_id" content="157382664122" />

<meta property="og:site_name" content="Habbo Hotel" />
<meta property="og:title" content="Habbo: La petición se ha realizado con éxito" />
<meta property="og:url" content="<?php echo URL; ?>" />
<meta property="og:image" content="<?php echo URL; ?>/v2/images/facebook/app_habbo_hotel_image.gif" />
<meta property="og:locale" content="es_ES" />



<meta name="description" content="Habbo Hotel: haz amig@s, únete a la diversión y date a conocer." />
<meta name="keywords" content="habbo hotel, mundo, virtual, red social, gratis, comunidad, personaje, chat, online, adolescente, roleplaying, unirse, social, grupos, forums, seguro, jugar, juegos, amigos, adolescentes, raros, furni raros, coleccionable, crear, coleccionar, conectar, furni, muebles, mascotas, diseño de salas, compartir, expresión, placas, pasar el rato, música, celebridad, visitas de famosos, celebridades, juegos en línea, juegos multijugador, multijugador masivo" />



<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo RES; ?>/static/styles/ie8.css" type="text/css" />
<![endif]-->

<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo RES; ?>/static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo RES; ?>/static/styles/ie6.css" type="text/css" />
<script src="<?php echo RES; ?>/static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="63-BUILD944 - 30.11.2011 12:59 - es" />
</head>
<body class="process-template secure-page">

<div id="overlay"></div>

<div id="change-password-form" style="display: none;">
    <div id="change-password-form-container" class="clearfix">
        <div id="change-password-form-title" class="bottom-border">¿Contraseña olvidada?</div>
        <div id="change-password-form-content" style="display: none;">
            <form method="post" action="<?php echo URL; ?>/account/password/identityResetForm" id="forgotten-pw-form">

                <input type="hidden" name="page" value="/account/password/resetConfirmation?changePwd=true" />
                <span>Por favor, introduce el email de tu Habbo cuenta:</span>
                <div id="email" class="center bottom-border">
                    <input type="text" id="change-password-email-address" name="emailAddress" value="" class="email-address" maxlength="48"/>
                    <div id="change-password-error-container" class="error" style="display: none;">Por favor, introduce un e-mail</div>
                </div>
            </form>
            <div class="change-password-buttons">

                <a href="#" id="change-password-cancel-link">Cancelar</a>
                <a href="#" id="change-password-submit-button" class="new-button"><b>Enviar email</b><i></i></a>
            </div>
        </div>
        <div id="change-password-email-sent-notice" style="display: none;">
            <div class="bottom-border">
                <span>Te hemos enviado un email a tu dirección de correo electrónico con el link que necesitas clicar para cambiar tu contraseña.<br>

<br>

¡NOTA!: Recuerda comprobar también la carpeta de 'Spam'</span>
                <div id="email-sent-container"></div>
            </div>
            <div class="change-password-buttons">
                <a href="#" id="change-password-change-link">Atrás</a>
                <a href="#" id="change-password-success-button" class="new-button"><b>Cerrar</b><i></i></a>
            </div>

        </div>
    </div>
    <div id="change-password-form-container-bottom"></div>
</div>

<script type="text/javascript">
HabboView.add( function() {
     ChangePassword.init();


});
</script>
<div id="container">
	<div class="cbb process-template-box clearfix">
		<div id="content" class="wide">
					<div id="header" class="clearfix">

						<h1><a href="<?php echo URL; ?>/"></a></h1>
<ul class="stats">
</ul>
					</div>
			<div id="process-content">
	        	<div class="cbb clearfix">
    <h2 class="title">¡Hecho!</h2>

    <div class="box-content">
    <p>Tu contraseña ha sido cambiada con éxito.</p>
    <p><a href="<?php echo URL; ?>">Volver a la Home &raquo;</a></p>
    </div>
</div>
<div id="footer">
</div>			</div>
        </div>
    </div>
</div>
<script type="text/javascript">
if (typeof HabboView != "undefined") {
	HabboView.run();
}
</script>


<!-- END Nielsen Online SiteCensus V6.0 -->
    

    



</body>
</html>