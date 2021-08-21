<?php
if(isset($_SESSION['login']['tries']) && $_SESSION['login']['tries'] >= 4):
	$errorJ = ['captcha-enabled', 'login-captcha'];
elseif(isset($_SESSION['login']['error'])):
	$errorJ = ['login-error', 'login-error'];
endif;
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo HotelName; ?>: Reserva suite gratis en el mayor Hotel virtual. Queda con tus viej@s amig@s, haz nuev@s, juega, chatea, crea tu avatar, tus habitaciones y m�s a�n... </title>
    <meta name="viewport" content="width=device-width">

    <script>
        var andSoItBegins = (new Date()).getTime();
        var habboPageInitQueue = [];
        var habboStaticFilePath = "<?php echo RES ?>";
        var registerEnabled = <?php echo Site::$Settings['RegisterEnabled'] == '1' ? 'true' : 'false'; ?>;
    </script>
    <link rel="shortcut icon" href="<?php echo RES ?>v2/favicon.ico" type="image/vnd.microsoft.icon" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic|Ubuntu+Condensed">

    <link rel="stylesheet" href="<?php echo RES ?>static/styles/v3_landing.css" type="text/css" />
    <script async src="<?php echo RES ?>static/js/v3_landing_top.js" type="text/javascript"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <meta name="description" content="<?php echo LongName; ?>: haz amig@s, Únete a la diversión y date a conocer." />
    <meta name="keywords" content="<?php echo strtolower(HotelName); ?>, mundo, virtual, red social, gratis, comunidad, personaje, chat, online, adolescente, roleplaying, unirse, social, grupos, forums, seguro, jugar, juegos, amigos, adolescentes, raros, furni raros, coleccionable, crear, coleccionar, conectar, furni, muebles, mascotas, dise�o de salas, compartir, expresi�n, placas, pasar el rato, m�sica, celebridad, visitas de famosos, celebridades, juegos en l�nea, juegos multijugador, multijugador masivo" />

    <meta name="build" content="<?php echo Site::XDRBuild; ?>" />   
    <meta name="csrf-token" content="bb00a4146f"/>
</head>
<body>

<div id="overlay"></div>


<div id="change-password-form" class="overlay-dialog" style="display: none;">
    <div id="change-password-form-container" class="clearfix form-container">
        <h2 id="change-password-form-title" class="bottom-border">¿Contraseña olvidada?</h2>
        <div id="change-password-form-content" style="display: none;">
            <form method="post" action="<?php echo URL; ?>/account/password/identityResetForm" id="forgotten-pw-form">
                <input type="hidden" name="page" value="/?changePwd=true" />
                <span>Por favor, introduce el email de tu <?php echo HotelName; ?> cuenta:</span>
                <div id="email" class="center bottom-border">
                    <input type="text" id="change-password-email-address" name="emailAddress" value="" class="email-address" maxlength="48"/>
                    <div id="change-password-error-container" class="error" style="display: none;">Please enter a correct email address</div>
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
    <div id="change-password-form-container-bottom" class="form-container-bottom"></div>
</div>

<script type="text/javascript">
    function initChangePasswordForm() {
<?php if(isset($_SESSION["PassWordEmail"])) { ?>
        ChangePassword.showChangeEmailPasswordSentNotice("<?php echo $_SESSION['PassWordEmail']; ?>");
<?php unset($_SESSION["PassWordEmail"]); } ?>
        ChangePassword.init();
    }
    if (window.HabboView) {
        HabboView.add(initChangePasswordForm);
    } else if (window.habboPageInitQueue) {
        habboPageInitQueue.push(initChangePasswordForm);
    }
</script>

<header<?php if(isset($errorJ)): ?> class="<?php echo $errorJ[0]; ?>"<?php endif; ?>>
<div id="eu_cookie_policy" class="orange-notifier eu_cookie_policy_v3"><div><a class="close" id="eu_cookie_policy_close" href="#">cerrar</a><span><?php echo HotelName; ?> utiliza cookies propias y de terceros para ofrecer un mejor servicio y mostrar publicidad acorde con tus preferencias . Si utilizas nuestra web consideramos que aceptas su uso. <a href="<?php echo URL; ?>/papers/cookies" target = "_blank">Leer más</a>.</span></div></div>
    <div id="border-left"></div>
    <div id="border-right"></div>

<?php if(isset($errorJ)): ?>
    <div id="<?php echo ($errorJ[0] === 'captcha-enabled') ? 'captcha-enabled' : 'login-errors'; ?>">
        <?php echo Text::Get(...$_SESSION['login']['error']); ?>
    </div>
<?php endif; ?>

<div id="login-form-container">
    <a href="#home" id="habbo-logo"></a>

    <form action="<?php echo URL; ?>/account/submit" method="post"<?php if(isset($errorJ) && $errorJ[0] === 'captcha-enabled'): ?> class="captcha"<?php endif; ?>>
    <?php if(isset($errorJ) && $errorJ[0] === 'captcha-enabled'): ?>
    
    <div class="g-recaptcha" data-theme="dark" name="g-recaptcha-response" data-sitekey="<?php echo Config::$ReCaptcha['data']['siteKey']; ?>"></div>
    
    <?php endif; ?>

    <div id="login-columns">
        <div id="login-column-1">
            <label for="credentials-email">Email ó usuario</label>
            <input tabindex="2" type="text" name="credentials.username" id="credentials-email" value="<?php echo (isset($_GET['username'])) ? $_GET['username'] : ''; ?>">
            <input tabindex="5" type="checkbox" name="_login_remember_me" id="credentials-remember-me"<?php echo (isset($_GET['rememberme']) && $_GET['rememberme'] === 'true') ? ' checked="checked"' : ''; ?>>
            <label for="credentials-remember-me" class="sub-label">Mantener conectado</label>
        </div>

        <div id="login-column-2">
            <label for="credentials-password">Contraseña</label>
            <input tabindex="3" type="password" name="credentials.password" id="credentials-password">
            <a href="#" id="forgot-password" class="sub-label">¿Contraseña olvidada?</a>
        </div>

        <div id="login-column-3">
            <input type="submit" value="Login" style="margin: -10000px; position: absolute;">
            <a href="#" tabindex="4" class="button" id="credentials-submit"><b></b><span>Conectar</span></a>
        </div>

        <div id="login-column-4">
<div id="fb-root"></div>
<script type="text/javascript">
    window.fbAsyncInit = function() {
        Cookie.erase("fbsr_<?php echo Config::$FaceBook['app']['id']; ?>");
        FB.init({appId: '<?php echo Config::$FaceBook['app']['id']; ?>', status: true, cookie: true, xfbml: true});
        if (window.habboPageInitQueue) {
            // jquery might not be loaded yet
            habboPageInitQueue.push(function() {
                $(document).trigger("fbevents:scriptLoaded");
            });
        } else {
            $(document).fire("fbevents:scriptLoaded");
        }

    };
    window.assistedLogin = function(FBobject, optresponse) {
        
        Cookie.erase("fbsr_<?php echo Config::$FaceBook['app']['id']; ?>");
        FBobject.init({appId: '<?php echo Config::$FaceBook['app']['id']; ?>', status: true, cookie: true, xfbml: true});

        permissions = 'user_birthday,email';
        defaultAction = function(response) {

            if (response.authResponse) {
                fbConnectUrl = "/facebook?connect=true";
                Cookie.erase("fbhb_val_<?php echo Config::$FaceBook['app']['id']; ?>");
                Cookie.set("fbhb_val_<?php echo Config::$FaceBook['app']['id']; ?>", response.authResponse.accessToken);
                Cookie.erase("fbhb_expr_<?php echo Config::$FaceBook['app']['id']; ?>");
                Cookie.set("fbhb_expr_<?php echo Config::$FaceBook['app']['id']; ?>", response.authResponse.expiresIn);
                window.location.replace(fbConnectUrl);
            }
        };

        if (typeof optresponse == 'undefined')
            FBobject.login(defaultAction, {scope:permissions});
        else
            FBobject.login(optresponse, {scope:permissions});

    };

    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol + '//connect.facebook.net/es_ES/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
</script>

<a class="fb_button fb_button_large" onclick="assistedLogin(FB); return false;">
    <span class="fb_button_border">
        <span class="fb_button_text">Conectar vía Facebook</span>
    </span>
</a>


<div id="rpx-signin">
</div>        </div>
    </div>
</form>
</div>

<?php
$focus = 'credentials-email';

if(isset($errorJ))
	$focus = ($errorJ[0] === 'captcha-enabled') ? 'recaptcha_response_field' : 'login-password';
?>
<script>
    habboPageInitQueue.push(function() {
        if (!LandingPage.focusForced) {
            LandingPage.fieldFocus('<?php echo $focus; ?>');
        }
    });
</script>
    <div id="alerts">
<noscript>
<div id="alert-javascript-container">
    <div id="alert-javascript-title">
        Sin soporte JavaScript
    </div>
    <div id="alert-javascript-text">
        Javascript está deshabilitado en tu navegador. Por favor, permite que haya JavaScript o actualiza tu navegador a una versión con Javascript para poder usar <?php echo HotelName; ?> :)
    </div>
</div>
</noscript>

<div id="alert-cookies-container" style="display:none">
    <div id="alert-cookies-title">
        &quot;Cookies&quot; deshabilitadas
    </div>
    <div id="alert-cookies-text">
        Tu navegador está configurado para no aceptar "cookies". Por favor, habilita el uso de "cookies" para utilizar <?php echo HotelName; ?>.
    </div>
</div>

<script type="text/javascript">
    document.cookie = "habbotestcookie=supported";
    var cookiesEnabled = document.cookie.indexOf("habbotestcookie") != -1;
    if (cookiesEnabled) {
        var date = new Date();
        date.setTime(date.getTime()-24*60*60*1000);
        document.cookie="habbotestcookie=supported; expires="+date.toGMTString();
    } else {
        if (window.habboPageInitQueue) {
            // jquery might not be loaded yet
            habboPageInitQueue.push(function() {
                $('#alert-cookies-container').show();
            });
        } else {
            $('alert-cookies-container').show();
        }
    }
</script>
    </div>
    <div id="top-bar-triangle"></div>
    <div id="top-bar-triangle-border"></div>
</header>