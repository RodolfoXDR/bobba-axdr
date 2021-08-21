<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['productId']) || !is_numeric($_POST['productId']))
	exit;

require '../../../KERNEL-XDRCMS/Init.php';
$productId = $_POST['productId'];

$getItem = SQL::query('SELECT skin, type, amount FROM xdrcms_store_items WHERE id = ' . $productId); 

if(!$getItem && $getItem->num_rows === 0)
	exit;

$Row = $getItem->fetch_assoc();
require HTML . 'Store_purchase_confirm.html';
?>