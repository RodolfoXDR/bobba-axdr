<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(empty($_POST['type']) || !in_array($_POST['type'], ['widgets', 'notes', 'backgrounds', 'stickers']))
	exit;

$_POST['type'] = substr($_POST['type'], 0, -1);
	
const APIsLoad = 'Homes.StoreCategories';
require '../../../KERNEL-XDRCMS/Init.php';

if($_POST['type'] === 'widget'):
	require 'inventory_items_widgets.php';
	exit;
elseif($_POST['type'] === 'note'):
	$_POST['type'] = 'WebCommodity';
endif;

$MyItems = '';
$getMyStickers = SQL::query('SELECT id, skin, type FROM xdrcms_site_inventory_items WHERE userId = ' . User::$Data['id'] . ' AND type = \'' . $_POST['type'] . '\' AND isWaiting = \'0\'');
require HTML . 'Store_inventory_items.html';
?>