<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title><?php echo HotelName; ?> - Contrase </title>


<link rel="shortcut icon" href="<?php echo RES ?>v2/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic|Ubuntu+Condensed">
<meta name="csrf-token" content="b6a333d72e"/>

<link rel="stylesheet" href="<?php echo URL; ?>/xdr-web/web-habbo/static/styles/common.css" type="text/css" />
<link rel="stylesheet" href="<?php echo URL; ?>/xdr-web/web-habbo/static/styles/process.css" type="text/css" />
    <meta name="description" content="<?php echo LongName; ?>: haz amig@s, Únete a la diversión y date a conocer." />
    <meta name="keywords" content="<?php echo strtolower(HotelName); ?>, mundo, virtual, red social, gratis, comunidad, personaje, chat, online, adolescente, roleplaying, unirse, social, grupos, forums, seguro, jugar, juegos, amigos, adolescentes, raros, furni raros, coleccionable, crear, coleccionar, conectar, furni, muebles, mascotas, dise�o de salas, compartir, expresi�n, placas, pasar el rato, m�sica, celebridad, visitas de famosos, celebridades, juegos en l�nea, juegos multijugador, multijugador masivo" />

<script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.1.0/prototype.js"></script>

	<link rel="stylesheet" href="<?php echo URL; ?>/xdr-web/web-habbo/static/styles/frontpage.css" type="text/css" />
    <meta name="build" content="<?php echo Site::XDRBuild; ?>" />   
    <meta name="csrf-token" content="bb00a4146f"/>
	
	<script type="text/javascript">
document.habboLoggedIn = true;
var habboName = "<?php echo User::$Data['name']; ?>";
var habboId = <?php echo User::$Data['id'] ; ?>;
var habboReqPath = "";
var habboStaticFilePath = "<?php echo RES; ?>/";
var habboImagerUrl = "<?php echo URL; ?>/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo URL; ?>/client";
window.name = "<?php echo $_SESSION['user']['clientToken']; ?>";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "<?php echo User::$Row['client_token']; ?>";
    HabboClient.maximizeWindow = true;
}
function AdBlockDetected() {
    window.location.href = '<?php echo URL; ?>/adblock';
}
</script>
<body class="process-template black secure-page">