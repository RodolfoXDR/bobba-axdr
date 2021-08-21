<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['task'], $_POST['selectedId']) || !is_numeric($_POST['selectedId']))
	exit;

require '../../../KERNEL-XDRCMS/Init.php';

$task = $_POST['task'];
$selectedId = $_POST['selectedId'];

$getItem = SQL::query("SELECT price, amount, skin, type, ItemsContent FROM xdrcms_store_items WHERE id = '" . $selectedId . "' LIMIT 1"); 
if(!$getItem || $getItem->num_rows === 0)
	exit;

$row = $getItem->fetch_assoc();

if(User::$Data['credits'] < $row['price'])
	exit;

$newCredits = User::$Data['credits'] - $row['price'];
if($row['skin'] === 'package_product_pre'):
	$Items = explode(',', $row['ItemsContent']);

	foreach($Items as $ItemSkin) {
		SQL::query("INSERT INTO xdrcms_site_inventory_items (userId, var, skin, type) VALUES ('" . User::$Data['id'] . "', '', '".$ItemSkin."', 'Sticker')");
	}
elseif($row['amount'] > 0):
	$count = 1;

	while($count <= $row['amount']) {
		SQL::query("INSERT INTO xdrcms_site_inventory_items (userId, var, skin, type) VALUES (" . User::$Data['id'] . ", '', '".$row['skin']."', '".$row['type']."')");
		$count++;
	}
else:
	SQL::query("INSERT INTO xdrcms_site_inventory_items (userId, var, skin, type) VALUES (" . User::$Data['id'] . ", '', '".$row['skin']."', '".$row['type']."')");
endif;

SQL::query('UPDATE users SET credits = \'' . $newCredits . '\' WHERE id = ' . User::$Data['id']);
header('X-JSON: ' . $selectedId);
echo 'OK';
?>
