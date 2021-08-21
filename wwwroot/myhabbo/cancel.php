<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2012 Xdr.
|+=========================================================+
|| # Xdr 2012. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

$require_login = true;
require '../../KERNEL-XDRCMS/Init.php';

if(isset($_GET['Id']) && is_numeric($_GET['Id'])):
	if(User::$Data['id'] == $_GET['Id']):
		unset($_SESSION['Ajax']['Update']);
		unset($_SESSION['Ajax']['Delete']);
		unset($_SESSION['Ajax']['UpdateTemporal']);

		unset($_SESSION['home_edit']);

		SQL::query('UPDATE xdrcms_site_inventory_items SET isWaiting = \'0\' WHERE userId = ' . User::$Data['id'] . ' AND isWaiting = \'1\'');
		SQL::query('DELETE FROM xdrcms_site_items WHERE Temporal = \'True\' AND userId = ' . User::$Data['id']);
		header('Location: ' . URL . '/home/' . User::$Data['name']); exit;
	endif;
endif;

header('Location: ' . URL);
exit;
?>