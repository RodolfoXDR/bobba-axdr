<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

/*if($siteBlocked):
	header('Location:' . URL . '/error/blocked');
	exit;
endif;*/

Site::$PageId = isset(Site::$PageId) ? Site::$PageId : '';
/*$body_id = isset($body_id) ? $body_id : '';*/

Site::SetOnline();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo Site::Charset; ?>">
	<meta charset="UTF-8">
	<title><?php echo HotelName; ?>: <?php if(isset(Site::$PageName)) echo Site::$PageName; ?> </title>

<script type="text/javascript">
var andSoItBegins = (new Date()).getTime();
</script>
<link rel="shortcut icon" href="<?php echo RES; ?>v2/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="alternate" type="application/rss+xml" title="<?php echo HotelName; ?>: RSS" href="<?php echo URL; ?>/articles/rss.xml">
<meta name="csrf-token" content="b6a333d72e"/>
<link rel="stylesheet" href="<?php echo RES; ?>static/styles/common.css?<?php echo rand(1,50); ?>" type="text/css" />
<script src="<?php echo RES; ?>static/js/libs2.js" type="text/javascript"></script>
<script src="<?php echo RES; ?>static/js/visual.js" type="text/javascript"></script>
<script src="<?php echo RES; ?>static/js/libs.js" type="text/javascript"></script>
<script src="<?php echo RES; ?>static/js/common.js" type="text/javascript"></script>
<script src="<?php echo RES; ?>static/js/lightweightmepage.js" type="text/javascript"></script>
<script src="<?php echo RES; ?>static/js/fullcontent.js" type="text/javascript"></script>

<link rel="stylesheet" href="https://habbo.es/styles/local/es.css" type="text/css" />

<script src="https://habbo.es/js/local/es.js" type="text/javascript"></script>

<script type="text/javascript"> 
document.habboLoggedIn = <?php echo (User::$Logged) ? 'true' : 'false'; ?>;
var habboName = <?php echo (User::$Logged) ? '"' . User::$Data['name'] . '"' : 'null'; ?>;
var habboId = <?php echo (User::$Logged) ? USER::$Data['id'] : 'null'; ?>;
var habboReqPath = "<?php echo URL; ?>";
var habboStaticFilePath = "<?php echo RES; ?>";
var habboImagerUrl = "<?php echo URL; ?>/habbo-imaging/";
var habboPartner = "";
var habboDefaultClientPopupUrl = "<?php echo URL; ?>/client";
window.name = "habboMain";
if (typeof HabboClient != "undefined") {
    HabboClient.windowName = "<?php echo (User::$Logged) ? USER::$Row['client_token'] : 'client'; ?>";
    HabboClient.maximizeWindow = true;
}
function AdBlockDetected() {
    window.location.href = '<?php echo URL; ?>/adblock';
}
</script>

<meta property="fb:app_id" content="<?php echo Config::$FaceBook['app']['id']; ?>"> 

<meta property="og:site_name" content="<?php echo HotelName; ?> Hotel" />
<meta property="og:title" content="<?php echo HotelName; ?>: Home" />
<meta property="og:url" content="<?php echo URL; ?>" />
<meta property="og:image" content="<?php echo URL; ?>/v2/images/facebook/app_habbo_hotel_image.gif" />
<meta property="og:locale" content="es_ES" />

<?php if(Site::$PageId == 'myprofile'): ?>
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/home.css" type="text/css" />
    <link href="<?php echo URL; ?>/myhabbo/styles/assets/backgrounds.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo URL; ?>/myhabbo/styles/assets/stickers.css" type="text/css" rel="stylesheet" />

	<link href="<?php echo URL; ?>/myhabbo/styles/assets/other.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo URL; ?>/myhabbo/styles/assets/backgrounds.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo URL; ?>/myhabbo/styles/assets/stickers.css" type="text/css" rel="stylesheet" />

	<script src="<?php echo RES; ?>static/js/homeview.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/lightwindow.css" type="text/css" />
	<script src="<?php echo RES; ?>static/js/homeauth.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/group.css" type="text/css" />

	<style type="text/css">
		#playground, #playground-outer {
			width: 922px;
			height: 1360px;
		}
	</style>

	<?php if($edit_mode === false): ?>
		<meta name="description" content="This is the <?php echo HotelName; ?> Home of <?php echo $user_row['name']; ?>." />
		<meta name="keywords" content="mypage.metadata.keywords" />
		<script type="text/javascript">
			document.observe("dom:loaded", function() { initView(<?php echo $user_row['id']; ?>, null); });
		</script>
	<?php else: ?>
		<script src="<?php echo RES; ?>static/js/homeedit.js" type="text/javascript"></script>
		<?php if(isset($user_row)): ?>
			<script language="JavaScript" type="text/javascript">
				document.observe("dom:loaded", function() {
					initView(<?php echo $user_row['id']; ?>, <?php echo $user_row['id']; ?>); 
				});

				function isElementLimitReached() {
					if (getElementCount() >= 200) {
						showHabboHomeMessageBox("Error", "You have already reached the maximum number of elements on the page. Remove a sticker, note or widget to be able to place this item.", "Close");
						return true;
					}

					return false;
				}

				function cancelEditing(expired) {
					location.replace("/myhabbo/cancel/<?php echo $user_row['id']; ?>" + (expired ? "?expired=true" : ""));
				}

				function getSaveEditingActionName(){
					return '/myhabbo/save';
				}

				function showEditErrorDialog() {
					var closeEditErrorDialog = function(e) { if (e) { Event.stop(e); } Element.remove($("myhabbo-error")); Overlay.hide(); };
					var dialog = Dialog.createDialog("myhabbo-error", "", false, false, false, closeEditErrorDialog);
					Dialog.setDialogBody(dialog, '<p>Error occurred! Please try again in couple of minutes.</p><p><a href="#" class="new-button" id="myhabbo-error-close"><b>Close</b><i></i></a></p><div class="clear"></div>');
					Event.observe($("myhabbo-error-close"), "click", closeEditErrorDialog);
					Dialog.moveDialogToCenter(dialog);
					Dialog.makeDialogDraggable(dialog);
				}


				function showSaveOverlay() {
					var invalidPos = getElementsInInvalidPositions();
					if (invalidPos.length > 0) {
						$A(invalidPos).each(function(el) { Element.scrollTo(el);  Effect.Pulsate(el); });
						showHabboHomeMessageBox("¡Ehhh! ¡No puedes hacer eso!", "Lo sentimos, pero no puedes colocar notas, etiquetas o elementos aquí. Cierra la ventana para continuar editando tu página.", "Cerrar");
						return false;
					} else {
						Overlay.show(null,'Guardando');
						return true;
					}
				}
			</script>
			<?php endif; ?>
	<?php endif; ?>
<?php elseif(Site::$PageId === 'community'): ?>
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/lightweightmepage.css" type="text/css" />
	<script src="<?php echo RES; ?>static/js/moredata.js" type="text/javascript"></script>

	<?php elseif(Site::$PageId === 'community2'): ?>
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/community.css" type="text/css" />

	<?php elseif(Site::$PageId === 'profile'): ?>
	<script src="<?php echo RES; ?>static/js/settings.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/settings.css" type="text/css" />

	<?php elseif(Site::$PageId === 'home'): ?>
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/personal.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/lightweightmepage.css" type="text/css" />
	<?php elseif(Site::$PageId === 'xluck'): ?>
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/personal.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo RES; ?>static/styles/lightweightmepage.css" type="text/css" />
<?php endif; ?>

<meta name="description" content="<?php echo LongName; ?>: haz amig@s, únete a la diversión y date a conocer." />
<meta name="keywords" content="<?php echo strtolower(LongName); ?>, mundo, virtual, red social, gratis, comunidad, personaje, chat, online, adolescente, roleplaying, unirse, social, grupos, forums, seguro, jugar, juegos, amigos, adolescentes, raros, furni raros, coleccionable, crear, coleccionar, conectar, furni, muebles, mascotas, dise�o de salas, compartir, expresi�n, placas, pasar el rato, m�sica, celebridad, visitas de famosos, celebridades, juegos en l�nea, juegos multijugador, multijugador masivo" />


<!--[if IE 8]>
<link rel="stylesheet" href="<?php echo RES; ?>static/styles/ie8.css" type="text/css" />
<![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo RES; ?>static/styles/ie.css" type="text/css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo RES; ?>static/styles/ie6.css" type="text/css" />
<script src="<?php echo RES; ?>static/js/pngfix.js" type="text/javascript"></script>
<script type="text/javascript">
try { document.execCommand('BackgroundImageCache', false, true); } catch(e) {}
</script>

<style type="text/css">
body { behavior: url(/js/csshover.htc); }
</style>
<![endif]-->
<meta name="build" content="<?php echo Site::XDRBuild; ?>">
</head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-6278183873740780",
    enable_page_level_ads: true
  });
</script>
<body class="<?php if(User::$Logged) echo 'anonymous'; ?> ">
<div id="overlay"></div>

<?php if(!User::$Logged): ?>
<div id="eu_cookie_policy" class="orange-notifier"><a class="close" id="eu_cookie_policy_close" href="#">cerrar</a><span><?php echo HotelName; ?> utiliza cookies propias y de terceros para ofrecer un mejor servicio y mostrar publicidad acorde con tus preferencias . Si utilizas nuestra web consideramos que aceptas su uso. <a href="<?php echo URL; ?>/papers/cookies" target = "_blank">Leer m�s</a>.</span></div>
<?php endif; ?>

<div id="header-container">
	<div id="header" class="clearfix">
		<h1><a href="<?php echo URL; ?>/"></a></h1>
<div id="subnavi"<?php echo (User::$Logged) ? " class=wide" : ""; ?>>

<?php if(User::$Logged): ?>
     <div id="subnavi-search">
         <div id="subnavi-search-upper">
         <ul id="subnavi-search-links">
                 <li><a href="https://help.habbo.com/forums" target="habbohelp" >Ayuda</a></li>
<?php if(User::hasPermission('ase.access')): ?>
                 <li><a href="<?php echo HURL; ?>" target="_xdrsettings" >ACP</a></li>
<?php endif; ?>
             <li>
                 <form action="<?php echo URL; ?>/account/logout?token=<?php echo User::$Row['token']; ?>" method="post">
                     <button type="submit" id="signout" class="link"><span>Salir</span></button>
                 </form>
             </li>
         </ul>
         </div>
     </div>
     <div id="to-hotel">
<?php if(Site::$Settings['ClientEnabled'] == 1 || (Site::$Settings['ClientEnabled'] == '2' && User::hasPermission('ase.access'))):
	if(User::$Row['online'] == 0): ?>
            <a href="<?php echo URL; ?>/client" class="new-button green-button" target="<?php echo User::$Row['client_token']; ?>" onClick="HabboClient.openOrFocus(this); return false;"><b>Entra a <?php echo LongName; ?></b><i></i></a>
	<?php else: ?>			
            <a href="<?php echo URL; ?>/client" id="enter-hotel-open-medium-link" target="<?php echo User::$Row['client_token']; ?>" onclick="HabboClient.openOrFocus(this); return false;">Volver al Hotel</a>
	<?php endif; ?>
<?php else: ?>
			<div id="hotel-closed-medium">Hotel Cerrado</div>
<?php endif; ?>
     </div> 
 </div>

 <script type="text/javascript">
 L10N.put("purchase.group.title", "Create a Group");
 document.observe("dom:loaded", function() {
     $("signout").observe("click", function() {
         HabboClient.close();
     });
 });
 </script>
	
<?php else: ?>
	<div id="subnavi-login">
		<form action="<?php echo URL; ?>/account/submit" method="post" id="login-form">
			<input type="hidden" name="page" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />
			<ul>
				<li>
					<label for="login-username" class="login-text"><b>Email</b></label>
					<input tabindex="1" type="text" class="login-field" name="credentials.username" id="login-username" />
					<a href="#" id="login-submit-new-button" class="new-button" style="float: left; display:none"><b>Conectar</b><i></i></a>
					<input type="submit" id="login-submit-button" value="Login" class="submit"/>
				</li>
				<li>
					<label for="login-password" class="login-text"><b>Contraseña</b></label>
					<input tabindex="2" type="password" class="login-field" name="credentials.password" id="login-password" />
					<input tabindex="3" type="checkbox" name="_login_remember_me" value="true" id="login-remember-me" />
					<label for="login-remember-me" class="left">Mantener conectado</label>
				</li>
			</ul>
		</form>
		<div id="subnavi-login-help" class="clearfix">
			<ul>
				<li class="register"><a href="<?php echo URL; ?>/account/password/forgot" id="forgot-password"><span>¿Contraseña olvidada?</span></a></li>
				<li><a href="<?php echo URL; ?>/register"><span>Regístrate gratis</span></a></li>
			</ul>
		</div>
		<div id="remember-me-notification" class="bottom-bubble" style="display:none;">
			<div class="bottom-bubble-t"><div></div></div>
			<div class="bottom-bubble-c">
				Seleccionando esta opción permanecerás conectado a <?php echo HotelName; ?> hasta que des a la opción &quot;.Desconectar&quot;.
			</div>
			<div class="bottom-bubble-b"><div></div></div>
		</div>
	</div>
        </div>
      <script type="text/javascript">
         LoginFormUI.init();
         RememberMeUI.init("right");
      </script>
<?php endif; ?>
<ul id="navi">
<?php if(!User::$Logged): ?>
	<li id="tab-register-now"><a href="/quickregister/start">¡Regístrate ahora!</a><span></span></li>
<?php endif; ?>

<?php //Navi System 2.1
$NaviPages = ['userName' => '/me',
	'Comunidad' => '/community',
	//'Xukys Clubs' => '#'
];

$NaviUrls = [
	'userName' => ['/me'],
	'Comunidad' => ['/community', '/articles', '/top'],
	'Tienda' => ['/shop'],
	//'Xukys Clubs' => ['/memberships', '/memberships/benefits']
];

if(User::$Logged):
	$NaviUrls['userName'] = ['/me', '/home/' . User::$Data['name'] . '', '/profile', '/profile/profileupdate', '/ranktest'];
	$NaviUrls['Tienda'] = ['/shop', '/shop/badges'];
endif;

if(Site::$Settings['staff.page.visibility'] == 0 || User::$Data['rank'] < MinRank):
	$NaviPages['Equipo'] = '/team';
	$NaviUrls['Equipo'] = ['/team', '/alpha'];
endif;

$NaviPages['Tienda'] = '/shop';


foreach ($NaviPages as $PageName => $PageUrl):
	if($PageUrl === '/me' && !User::$Logged)
		continue;

	$s = (in_array(URI, $NaviUrls[$PageName]) || ($PageName === 'Noticias' && strstr(URI, '/articles')));
	if($s)	$PageNow = $PageName;	
?>
	<li class="<?php echo (($PageName === 'userName') ? 'metab ' : '') . (($s) ? 'selected' : '');  echo ($PageName === 'Xukys Clubs') ? 'xukys' : '' ; ?>">
		<?php if(!$s): ?>
			<a href="<?php echo URL . $PageUrl; ?>"><?php if($PageName === 'userName'): ?><?php echo User::$Data['name']; ?> (&nbsp;<i style="background-image: url(<?php echo RES; ?>v2/images/rpx/<?php echo User::$Data['icon']; ?>.png)">&nbsp;</i>)<?php else: echo $PageName; endif; ?></a>
		<?php else: ?>
			<strong><?php if($PageName === 'userName'): ?><?php echo User::$Data['name']; ?> (&nbsp;<i style="background-image: url(<?php echo RES; ?>v2/images/rpx/<?php echo User::$Data['icon']; ?>.png)">&nbsp;&nbsp;&nbsp;</i>)<?php else: echo $PageName; endif; ?></strong>
		<?php endif; ?>
		<span></span>
	</li>
<?php
endforeach; // End Foreach
?>
</ul>
        <div id="habbos-online"><div class="rounded"><span><span style="display: -webkit-inline-box; padding: 0;" ><?php echo Site::GetOnlineCount(); ?></span><?php echo ' ' . HotelName; ?>s conectados</span></div></div>
	</div>
</div>


<div id="content-container">
<?php
if(User::$Logged || !isset($_InErrorPage)):
	$Navi2Pages = [
		'userName' => [
		],
		'Comunidad' => [
			'Comunidad' => '/community',
			'Noticias' => '/articles',
			'Tops' => '/top'
		],
		'Tienda' => [
			'Tienda' => '/shop'
		],
		'xLuck' => [
			'Membresías' => '/memberships',
			'Beneficios' => '/benefits',
		],
	];
	
    if(Site::$Settings['staff.page.visibility'] == 0 || User::$Data['rank'] < MinRank):
		$Navi2Pages['Equipo']['Primario'] = '/team';
		$Navi2Pages['Equipo']['Secundario'] = '/alpha';
	endif;

	if(!isset($PageNow))
		$PageNow = 'userName';

	if(User::$Logged):
		$Navi2Pages['userName'] = [
			'Home' => '/me',
			'Mi ' . HotelName . ' Home' => '/home/' . User::$Data['name'],
			'Ajustes' => '/profile', 
			//'AJUSTES ' . strtoupper(HotelName) . ' CUENTA' => '/identity/settings', 
			//'<b>Referidos</b>' => '/refers'
		];
		$Navi2Pages['Tienda'] = [
			'Tienda' => '/shop',
			'Placas' => '/shop/badges'
		];
	endif;
?>
<div id="navi2-container" class="pngbg">
    <div id="navi2" class="pngbg clearfix">
	<ul>
<?php
	foreach ($Navi2Pages[$PageNow] as $SubPageName => $SubPageUrl):
		$Class = '';
		if(strcasecmp(URI, $SubPageUrl) === 0)
			$Class = 'selected';
		if(strcasecmp(end($Navi2Pages[$PageNow]), $SubPageUrl) === 0)
			$Class .= ' last';
?>
		<li<?php echo !empty($Class) ? ' class="' . $Class . '"' : ''; ?>>
			<?php if(strcasecmp(URL, $SubPageUrl) !== 0): ?><a href="<?php echo URL; ?><?php echo $SubPageUrl; ?>"><?php echo $SubPageName; ?></a><?php else: ?><?php echo $SubPageName; ?><?php endif; ?>
		</li>
<?php
	endforeach;
?>
	</ul>
    </div>
</div>
<?php endif; ?>



<?php if(Config::$Restrictions['maintenance']['active'] && !isset($_SESSION['already_know'])) { ?>
 <script type="text/javascript">
    Dialog.showConfirmDialog("Ahora mismo el Hotel se encuentra en mantenimiento es probable que algunas funciones hayan sido desactivadas.<br /><br />Por favor te pedimos que no hagas demasiadas cosas ya que podrias da�ar el sistema.<br /><br />Para continuar haz clic en 'OK'.", {
        headerText: "�Atenci�n!",
        buttonText: "",
        cancelButtonText: "OK"
    });
  </script>

<?php $_SESSION['already_know'] = true; } ?>