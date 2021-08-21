<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['widgetId'], $_SERVER['HTTP_REFERER']) && !is_numeric($_POST['widgetId']))
	exit;

require '../../../KERNEL-XDRCMS/Init.php';
USER::REDIRECT(1);

$groupId = 0;
$homeId = 0;
$itemId = $_POST['widgetId'];

if(strpos($_SERVER['HTTP_REFERER'], URL . '/groups/') !== false && isset($_SESSION['group_edit_id'])):
	$groupId = $_SESSION['group_edit_id'];
	$Id = $_SESSION['group_edit_id'];
elseif(strpos($_SERVER['HTTP_REFERER'], URL . '/home/') !== false):
	$homeId = User::$Data['id'];
	$Id = User::$Data['id'];
else:
	exit;
endif;

$getAlreadyItem = SQL::query("SELECT null FROM xdrcms_site_items WHERE groupId = '" . $groupId . "' AND userId = '" . $homeId . "' AND id = '" . $itemId . "' AND type = 'widget' LIMIT 1");

if($getAlreadyItem == null && $getAlreadyItem->num_rows == 0):
	echo 'ERROR';
	exit;
endif;

if(isset($_SESSION['Ajax']['Delete']))
	$_SESSION['Ajax']['Delete'] .= "[widget,$itemId,]";
else
	$_SESSION['Ajax']['Delete'] = "[widget,$itemId,]";

echo 'SUCCESS';
?>