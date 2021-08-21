<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['task'], $_POST['selectedId']) || !is_numeric($_POST['selectedId']))
	exit;

require '../../../KERNEL-XDRCMS/Init.php';

$getItem = SQL::query("SELECT price, amount, skin FROM xdrcms_store_items WHERE id = '" . $_POST['selectedId'] . "' AND type = 'WebCommodity' LIMIT 1"); 

if(!$getItem || $getItem->num_rows === 0)
	exit;

$row = $getItem->fetch_assoc();

if(User::$Data['credits'] < $row['price'])
	exit;

$newCredits = User::$Data['credits'] - $row['price'];
$count = 1;

while($count <= $row['amount']):
	SQL::query("INSERT INTO xdrcms_site_inventory_items (userId, var, skin, type) VALUES ('" . User::$Data['id'] . "', '', '".$row['skin']."', 'WebCommodity')");
	$count++;
endwhile;

SQL::query('UPDATE users SET credits = \'' . $newCredits . '\' WHERE id = ' . User::$Data['id']);
		
header('X-JSON: ' . $_POST['selectedId']);
echo 'OK';
?>