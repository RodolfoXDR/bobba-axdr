<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
|| # Housekeeping by Xdr
|| # Copyright (C) 2015. Todos los derechos reservados.
|+=========================================================+
*/

const NoMaintenance = true;
$no_rea = true;
//const APIsLoad = 'Sockets';

require '../../KERNEL-XDRCMS/Init.php';
if (isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != WWW)
	exit();

$p = isset($_GET['p']) ? $_GET['p'] : '';
$do = isset($_GET['do']) ? $_GET['do'] : '';
$key = isset($_GET['key']) ? $_GET['key'] : '';

$LoadFooter = true;

if (!isset($_SESSION['Manage']['Login']))
{
	header('Location:' . HHURL);
	exit;
}

function SLOG($a, $m, $p, $t)
{
	SQL::query('INSERT INTO xdrcms_staff_log (action, message, note, userid, targetid, timestamp) VALUES (\'' . $a . '\', \'' . $m . '\', \'' . $p . '\', ' . User::$Data['id'] . ', ' . $t . ', ' . time() . ')');
}

function checkSecurityKey($userId, $key, $c = false)
{
	if (!Config::$Restrictions['security']['secretKeys']['enabled'])
		return isset($_SESSION['Manage']['SecretKey']) && md5($_SESSION['Manage']['SecretKey']) == $key;
	
	if (isset(Config::$Restrictions['security']['secretKeys']['keys'][$userId])):
		$oKey = $c === true ? md5(Config::$Restrictions['security']['secretKeys']['keys'][$userId]) : Config::$Restrictions['security']['secretKeys']['keys'][$userId];
		if ($oKey === $key)	return true;
	endif;

	return false;
}

function getSecurityKey()
{
	return isset($_SESSION['Manage']['SecretKey']) ? md5($_SESSION['Manage']['SecretKey']) : '';
}

function getAntiCsrf()
{
	return '<input type="hidden" id="GUID" name="GUID" value="' . getSecurityKey() . '"/><input type="hidden" id="uid" name="uid" value="' . User::$Data['id'] . '"/>';
}

function checkAntiCsrf()
{
	if (!Config::$Restrictions['security']['secretKeys']['enabled'])
		return true;

	if (!isset($_POST['GUID'], $_POST['uid']) && is_numeric($_POST['uid']))
		return false;

	return $_POST['uid'] == User::$Data['id'] && checkSecurityKey($_POST['uid'], $_POST['GUID'], true);
}


if (!User::$Logged || !isset($_SESSION['Manage']['Login']) || !User::hasPermission('ase.access'))
{
	unset($_SESSION['Manage']['Login']);
	exit(header('Location: ' . HHURL));
}

$pages = [
	 'dashboard' => 'ase.access', 
	 
	 'server' => 'ase.server', 
	 'loader' => 'ase.swfs', 
	 'override_varstexts' => 'ase.server',
	 
	 'site' => 'ase.site', 
	 'badges' => 'ase.uploads', 
	 'promos' => 'ase.articles', 
	 'articles' => 'ase.articles', 
	 'mpus' => 'ase.uploads',
	 'plugins' => 'ase.site',
	 'updates' => 'ase.site',

	 'users' => 'ase.users_page', 
	 'bans' => 'ase.ban_unban', 
	 'alerts' => 'ase.alerts',
  
	 'logs' => 'ase.logs',
	 'server_logs' => 'ase.logs', 
	 'debug' => 'ase.server', 
	 'emulator' => 'ase.server', 

	 'catalog' => 'ase.catalog', 
	 'catalog_m' => 'ase.catalog', 
	 'catalog_sm' => 'ase.catalog', 
	 'catalog_ssm' => 'ase.catalog',

	 'shop' => 'ase.shop_page',

	 '' => 'ase.access'
	];
$menuId = 1;


if (!isset($pages[$p])):
	require ASE . 'error404.php';
elseif ($p !== '' && !User::hasPermission($pages[$p])):
	require ASE . 'error403.php';
else:
	$menuId = $pages[$p];
	require ASE . (($p === '') ? 'dashboard' : $p) . '.php';
endif;

if ($LoadFooter)
	require ASE . 'Footer.html';
?>