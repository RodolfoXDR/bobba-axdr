<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2016 Xdr.
|+=========================================================+
|| # Xdr 2016. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

const STYLE_OTHER = 'Jollyness';
require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED | Redirect::NOLOGGED);

if(Site::$Settings['ClientEnabled'] == 0 || (Site::$Settings['ClientEnabled'] == '2' && User::$Data['rank'] < 4))
	exit ('Client desactivado');

if(User::hasPermission('ase.access') && (!isset($_SESSION['Client']['PIN'])) && Config::$Restrictions['security']['secretKeys']['enabled'])
	exit(header('Location: ' . URL . '/blocked'));

if(isset($_POST['error_desc'], $_POST['error_cat']))
{
	if(isset($_SESSION['aDEBUG'][0]) && $_SESSION['aDEBUG'][0] === true)
		$_SESSION['aDEBUG'][1][] = ['DEBUG FINAL ERROR', $_POST['debug']];
	
	//if (strstr($_POST['error_desc'], 'Failed to parse') !== false)
		file_put_contents ('logs/error.txt', $_POST['error_desc'] . "\r\n", FILE_APPEND);
}
require HTML . 'Client_client.html';

/*// Fazendo randomiza��o dos sites...
$random = ($i = rand(0,1)) ? 'localhost/client': 'localhost/client';

function encrypt($string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";

    $key = '2aa3150e48d89f994031a884b4a5630c0f42900cbf5d6d2a70efc1c003f55ecbfa12f918c3e65e2dcbcf536c5f739bdaceb0a9689be2fbede574da7d6b761400';
    $iv = substr('a90e19bec27cde1c620af67a18da245ef66b4a1a781cd5d613f2f4ae6a4951f27c1159d222e0b28103225029a0805b2815924eea41938f79e08338098d39d2b4', 0, 16);

    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);

    return $output;
}

header ('Location: ' . $random . '/receiver.php?sso=' . encrypt(User::GenerateAuthToken(User::$Data['id'])));}*/
?>