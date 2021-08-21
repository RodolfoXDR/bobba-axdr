<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2016 Xdr.
|+=========================================================+
|| # Xdr 2016. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

header('Content-Type: application/json; charset: UTF-8');

if (!isset($_POST['reg_username'], $_POST['reg_mail'], $_POST['reg_password'], $_POST['g-recaptcha-response'])):
	echo utf8_encode('{"registrationErrors":{
		"registration_username":"Introduce un usuario",
		"registration_password":"Escribe una contraseña",
		"registration_birthday_format":"Por favor, debes proporcionar una fecha válida",
		"registration_termsofservice":"Por favor, debes aceptar los términos.",
		"registration_captcha":"El código de seguridad no era válido. Por favor, inténtalo de nuevo."
	}}');
	exit;
endif;

if(empty($_POST['reg_termsOfService'])):
	$_POST['reg_termsOfService'] = false;
endif;

if(empty($_POST['reg_cookiePolicy'])):
	$_POST['reg_cookiePolicy'] = false;
endif;

const APIsLoad = 'Register,Login,Homes.Items';
require_once '../../KERNEL-XDRCMS/Init.php';
Site::Redirect(Redirect::BLOCKED | Redirect::LOGGED);

$rSettings = Cache::GetAIOConfig('Register');

if (!Register::Check($_POST['reg_username'], $_POST['reg_mail'], $_POST['reg_password'], $_POST['g-recaptcha-response'], $_POST['reg_termsOfService'], $_POST['reg_cookiePolicy']))
	exit(header ('Location: ' . URL . '/#registration'));
	
	echo '{"registrationCompletionRedirectUrl":"' . str_replace('/', '\\/', URL . '/' . $rSettings['redirection']) . '"}';
?>
?>