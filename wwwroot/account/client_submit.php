<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2016 Xdr.
|+=========================================================+
|| # Xdr 2016. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

if (!isset($_POST['pin']))
	exit(header('Location: ' . URL . '/blocked/?e='. Text::CLIENT_BLOCKED_NO_PIN));

const APIsLoad = 'Register,Login';
require_once '../../KERNEL-XDRCMS/Init.php';

function checkSecurityKey($userId, $key, $c = false){
	if (isset(Config::$Restrictions['security']['secretKeys']['keys'][$userId])):
		$oKey = $c === true ? md5(Config::$Restrictions['security']['secretKeys']['keys'][$userId]) : Config::$Restrictions['security']['secretKeys']['keys'][$userId];
		if ($oKey === $key)	return true;
	endif;

	return false;
}

$pin = $_POST['pin'];

if(strlen($pin) != 5)
	exit(header('Location: ' . URL . '/blocked?e=' . Text::CLIENT_BLOCKED_INVALID_PIN));
else if(!checkSecurityKey(User::$Data['id'], $pin))
	exit(header('Location: ' . URL . '/blocked?e=' . Text::CLIENT_BLOCKED_WRONG_PIN));
else{
	$_SESSION['Client']['PIN'] = true;
	exit(header('Location: ' . URL . '/client'));
}


?>
<html>
	<head>
		<title>Redirecting...</title>
	</head>
</html>