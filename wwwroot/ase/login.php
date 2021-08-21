<?php
const NoMaintenance = true;
const APIsLoad = 'Login';
require '../../KERNEL-XDRCMS/Init.php';

if(isset($_POST['login'], $_POST['password']) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != WWW)
	exit(header('Location: ' . HHURL . '/'));
	
if(isset($_SESSION['acp']['user']))
	exit(header('Location: ' . HHURL . '/manage'));
	
if(!isset($_POST['login'], $_POST['password']))
	exit(header('Location: ' . HHURL . '/?e=' . Text::ACP_LOGIN_EMPTY_BOTH));

$userName = $_POST['login'];
$passWord = $_POST['password'];
$secretKey = Config::$Restrictions['security']['secretKeys']['enabled'] && isset($_POST['secretKey']) ? $_POST['secretKey'] : '';


if (strlen($userName) < 3 || strlen($passWord) < 6)
	exit(header('Location: ' . HHURL . '/?e=' . Text::ACP_LOGIN_EMPTY_BOTH));

$passWord = Tool::Hash($passWord);
$q = SQL::prepare('SELECT xdr_users.mail, ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . ', ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_RANK_COLUMN) . ' FROM ' . Server::Get(Server::USER_TABLE) . ', xdr_users WHERE ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_NAME_COLUMN) . ' = ? AND xdr_users.password = ? AND ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_RANK_COLUMN) . ' > ? AND ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . ' = xdr_users.id LIMIT 1');
$r = $q->execute('ssi', $userName, $passWord, MinRank);

if($q === null || $r->num_rows === 0)
	exit(header('Location: ' . HHURL . '/?e=' . Text::ACP_LOGIN_ERROR));

$row = $r->fetch_assoc();

if(!User::hasPermission('ase.access', $row['rank']))
	exit(header('Location: ' . HHURL . '/?e=' . Text::ACP_LOGIN_RANK));

Tool::SessionStart();
		
$_SESSION['Manage']['SecretKey'] = Config::$Restrictions['security']['secretKeys']['enabled'] ? $secretKey : rand(10000, 99999);
$_SESSION['Manage']['Login'] = true;
Login::CreateSession($row, false);

header('Location: ' . HHURL . '/manage?p=dashboard');
?>