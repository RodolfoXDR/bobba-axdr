<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['widgetId'], $_POST['privileged'], $_POST['zindex'], $_SERVER['HTTP_REFERER']) || !is_numeric($_POST['widgetId']) || !is_numeric($_POST['zindex']))
	exit;
$widgets = [2 => 'RoomsWidget', 3 => 'FriendsWidget', 5 => 'GuestbookWidget', 21 => 'BadgesWidget'];
if(!isset($widgets[$_POST['widgetId']]))
	exit;

	const APIsLoad = 'Homes.Items';
require '../../../KERNEL-XDRCMS/Init.php';

$groupId = 0;
$homeId = User::$Data['id'];

$Id = $homeId;
/*
if(strpos($_SERVER["HTTP_REFERER"], PATH . "/groups/") !== false && isset($_SESSION['group_edit_id'])):
	$groupId = $_SESSION['group_edit_id'];
	$Id = $_SESSION['group_edit_id'];
elseif(strpos($_SERVER["HTTP_REFERER"], PATH . "/home/") !== false):
	$homeId = User::$Data['id'];
	$Id = User::$Data['id'];
else:
	exit;
endif;
*/

$widgetId = $_POST['widgetId'];
$privileged = $_POST['privileged'];
$zindex = $_POST['zindex'];

if(User::HaveWidget($Id, $widgets[$widgetId]))
	exit;
Item::Place($homeId, $groupId, '15', '25', $zindex, $widgets[$widgetId], 'w_skin_goldenskin', '', 'widget');
$Id = SQL::$insert_id;

require HTML . 'Widget_preview_' . $widgets[$widgetId] . '.html';
?>