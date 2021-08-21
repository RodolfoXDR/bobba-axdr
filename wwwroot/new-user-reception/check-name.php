<?php
// Coded by Xdr
ini_set('default_charset', 'UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Content-Type: application/json;charset=UTF-8');
header('Pragma: no-cache');
header('P3P: CP="NON DSP COR CURa ADMa OUR STP STA"');
header('Connection: keep-alive');

const APIsLoad = 'Register';
if(!isset($_POST['name']))
	exit('{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_NAME_TOO_SHORT","additionalInfo":"2"},"suggestions":[]}');

if (strlen($_POST['name']) < 3)
	echo '{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_NAME_TOO_SHORT","additionalInfo":"2"},"suggestions":[]}';
else if (strlen($_POST['name']) > 15)
	echo '{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_NAME_TOO_LONG","additionalInfo":"15"},"suggestions":[]}';
else if (strpos($_POST['name'], ' '))
	echo '{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_ILLEGAL_CHARS","additionalInfo":" "},"suggestions":[]}';
else if (is_numeric($_POST['name']))
	echo '{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_ILLEGAL_CHARS","additionalInfo":" "},"suggestions":[]}';
else if (strpos($_POST['name'], 'MOD-') !== false)
	echo '{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_ILLEGAL_WORDS","additionalInfo":"' . $_POST['name'] . '"},"suggestions":[]}';
else
{
	require '../../KERNEL-XDRCMS/Init.php';

	if (!Register::ValidName($_POST['name']))
		echo '{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_ILLEGAL_CHARS","additionalInfo":""},"suggestions":[]}';
	else if (!User::$Logged || User::$Row['receptionPased'] == '1')
		exit('{"code":"INVALID_NAME","validationResult":{"resultType":"VALIDATION_ERROR_NAME_TOO_SHORT","additionalInfo":"2"},"suggestions":[]}');
	else if (strcasecmp($_POST['name'], User::$Data['name']) === 0)
		echo '{"code":"OK","suggestions":[]}';
	else if (Register::NameExists($_POST['name']))
		exit('{"code":"NAME_IN_USE","suggestions":["' . $_POST["name"] . 'ito","Monster' . $_POST["name"] . '","Guapo' . $_POST["name"] . '"]}');
	else
		echo '{"code":"OK","suggestions":[]}';
	
	$_SESSION['newReceptionUserName'] = $_POST['name'];
}
?>