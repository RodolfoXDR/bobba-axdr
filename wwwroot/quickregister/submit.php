<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2016 Xdr.
|+=========================================================+
|| # Xdr 2016. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/
if (!isset($_POST['reg_username'], $_POST['reg_mail'], $_POST['reg_password'], $_POST['g-recaptcha-response']))
	exit;

const APIsLoad = 'Register,Login';
require_once '../../KERNEL-XDRCMS/Init.php';
Site::Redirect(Redirect::BLOCKED | Redirect::LOGGED);

$rSettings = Cache::GetAIOConfig('Register');

if (!Register::Check($_POST['reg_username'], $_POST['reg_mail'], $_POST['reg_password'], $_POST['g-recaptcha-response'], true, true))
	exit(header ('Location: ' . URL . '/quickregister/start'));
	
header ('Location: ' . URL . '/' . $rSettings['redirection']);
?>