<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['stickerId']) || !is_numeric($_POST['stickerId']))	exit;

const APIsLoad = 'Homes.Items';
require '../../../KERNEL-XDRCMS/Init.php';

$stickerId = $_POST['stickerId'];

$q = SQL::query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $stickerId ."' AND isWaiting = '1' LIMIT 1");

if($q->num_rows > 0):
	SQL::query("UPDATE xdrcms_site_inventory_items SET isWaiting = '0' WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $stickerId . "' AND isWaiting = '1' LIMIT 1");
else:
	$row = $q->fetch_assoc();

	$q = SQL::query("SELECT null FROM xdrcms_site_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $stickerId ."' AND type = 'sticker' LIMIT 1");
	if($q && $q->num_rows > 0):
		Item::Create(User::$Data['id'], '', $row['skin'], 'Sticker');
		if(isset($_SESSION['Ajax']['Delete']))
			$_SESSION['Ajax']['Delete'] .= "[sticker,$stickerId," . $row['skin'] . "]";
		else
			$_SESSION['Ajax']['Delete'] = "[sticker," . $stickerId . "," . $row['skin'] . "]";
	endif;
endif;
?>