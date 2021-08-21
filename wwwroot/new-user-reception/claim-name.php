<?php
// Coded by Xdr
const APIsLoad = 'Register';
require '../../KERNEL-XDRCMS/Init.php';

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Content-Type: application/json;charset=UTF-8');
header('Pragma: no-cache');
header('P3P: CP="NON DSP COR CURa ADMa OUR STP STA"');
header('Connection: keep-alive');

if (isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != WWW)
	exit();

if (!isset($_SESSION['newReceptionUserName']))
	exit('{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_NAME_TOO_SHORT","additionalInfo":"2"},"suggestions":[""]}');

$name = $_SESSION['newReceptionUserName'];

if (!User::$Logged || User::$Row['receptionPased'] == '1')
	goto responseOk;

$gender = isset($_SESSION['newReceptionGender']) ? $_SESSION['newReceptionGender'] : ((isset($_POST['isFemale']) || $_POST['isFemale'] == 'true') ? 'F' : 'M');
$look = isset($_SESSION['newReceptionLook']) ? $_SESSION['newReceptionLook'] : SQL::query('SELECT Look FROM xdrcms_looks WHERE Gender = \'' . $gender . '\' ORDER BY RAND() LIMIT 1')->fetch_assoc()['Look'];

if (strcasecmp($name, User::$Data['name']) === 0)
{
	SQL::query('UPDATE users, xdr_users SET users.gender = \'' . $gender . '\', users.look = \'' . $look . '\', xdr_users.ReceptionPased = \'1\' WHERE users.id = ' . User::$Data['id'] . ' AND xdr_users.id = users.id');
	goto responseOk;
}

if (Register::NameExists($name))
	exit('{"code":"NAME_IN_USE","suggestions":["' . $name . 'ito","Monster' . $name . '","Guapo' . $name . '"]}');

SQL::query('UPDATE users, xdr_users SET users.username = \'' . $name . '\', users.gender = \'' . $gender . '\', users.look = \'' . $look . '\', xdr_users.ReceptionPased = \'1\' WHERE users.id = ' . User::$Data['id'] . ' AND xdr_users.id = users.id');
SQL::query('UPDATE rooms SET owner = \'' . $name . '\' WHERE owner = \'' . $name . '\'');

$_SESSION['receptionCanRegisterRoom'] = true;

responseOk:
echo '{"code":"OK","suggestions":[]}';
?>