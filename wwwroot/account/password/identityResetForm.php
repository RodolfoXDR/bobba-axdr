<?php
if(!isset($_POST['emailAddress']))	exit;

const APIsLoad = 'Timer';
require '../../../KERNEL-XDRCMS/Init.php';

if(!Tool::IsMail($_POST['emailAddress']))	exit;

$timer = new Timer('ResetPassoword');
$email = $_POST['emailAddress'];

//if(!$Timer->NowCreated && !$Timer->IsExpired(2))	goto a;

$Check = SQL::query('SELECT null FROM xdr_users WHERE mail = \'' . $email . '\' AND rpx_type = \'habboid\' LIMIT 1');
if(!$Check && $Check->num_rows === 0)	exit(header('Location: ' . URL . '/error'));

$code = Tool::Random(165);
SQL::query("INSERT INTO xdrcms_users_keys (Type, Code, Time, UserEmail) VALUES ('Recuper', '" . md5($code) . "' , '" . time() . "', '" . $email . "')");

$body = str_replace(['%PATH%', '%shortname%', '%mail%', '%code%'], [URL, HotelName, $email, $code], file_get_contents('https://xukys-hotel.net/Mail_PasswordReset.html'));
$headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From: Your name <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
Tool::SendEmail($email, 'Cambia tu contraseña', $body);

a:
header('Location: ' . URL . '/');
?>