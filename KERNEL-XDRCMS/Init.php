<?php
/*=========================================================+
|| # Azure Kernel of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|| # Azure Kernel 4.0 BETA
|+=========================================================+
|| # XDR 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/
if (count($_POST) > 50 || count($_GET) > 50)
	exit;

if (!defined('DEBUG'))
	define ('DEBUG', false);
if (!defined('FastLoad'))
	define ('FastLoad', false);
if(!defined('Maintenance'))
	define('Maintenance', false);

define ('URI', strstr($_SERVER['REQUEST_URI'], '?') !== FALSE ? explode('?', $_SERVER['REQUEST_URI'])[0] : $_SERVER['REQUEST_URI']);
const DS = DIRECTORY_SEPARATOR;
define ('KERNEL', dirname(__FILE__) . DS);
define ('LANGUAGES', KERNEL . 'Lang' . DS);
define ('Files', KERNEL . 'Files' . DS);

require 'PHPEvents.php';
require 'User.Config.php';
require 'Cache.php';
require 'Server.php';
require 'Site.php';
require 'Tools.php';
require 'Texts.php';
require 'APIs/Plugins.php';
date_default_timezone_set('America/Monterrey');
Tool::SetPHPInfo();
Tool::SetIp();
Tool::ApplyEntities(Tool::HTMLEntities, $_POST, $_GET, $_SERVER['HTTP_USER_AGENT']);

$_SERVER['REQUEST_URI'] = str_replace('.php', '', strtolower($_SERVER['REQUEST_URI']));

Site::DefineUri($config);

if (!FastLoad)
{
	require 'SQL.' . $config['SQL']['api'] . '.php';
	SQL::Connect($config['SQL']);
	
	Site::LoadRanks();
}

Site::LoadSettings();

unset($config);
if (isset($_COOKIE['aXDR']))
	@session_start();

//Site::CheckCountryRestrictions();
Site::SetResourcesDirectory();

require STYLEPATH . 'Titles.php';
require 'User.php';
User::Check();

Site::ShowMaintenance();

if (defined('APIsLoad'))
	foreach (explode(',', APIsLoad) as $f)
		require_once KERNEL . 'APIs' . DS . $f . '.php';
?>