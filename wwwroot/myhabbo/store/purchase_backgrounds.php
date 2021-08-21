<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

require '../../../KERNEL-XDRCMS/Init.php';

if(!isset($_POST['task'], $_POST['selectedId']) || $_POST['task'] !== 'purchase' || !is_numeric($_POST['selectedId']))
	exit;

$task = $_POST['task'];
$selectedId = $_POST['selectedId'];

$getItem = SQL::query("SELECT id, price, skin, type FROM xdrcms_store_items WHERE id = '" . $selectedId . "' LIMIT 1"); 

if(!$getItem || $getItem->num_rows === 0):
	echo 'REFRESH';
	exit;
endif;

$row = $getItem->fetch_assoc();
	
if(User::$Data['credits'] < $row['price']):
	echo 'REFRESH';
	exit;
endif;

SQL::query("INSERT INTO xdrcms_site_inventory_items (userId, var, skin, type) VALUES ('" . User::$Data['id'] . "', '', '".$row['skin']."', '".$row['type']."')");
SQL::query('UPDATE users SET credits = \'' . (User::$Data['credits'] - $row['price']) . '\' WHERE id = ' . User::$Data['id']);

header('X-JSON: ' . $row['id']);
echo 'OK';
?>
