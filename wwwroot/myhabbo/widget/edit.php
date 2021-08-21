<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['skinId'], $_POST['widgetId']) || !is_numeric($_POST['skinId']) || !is_numeric($_POST['widgetId']))
	exit;

require "../../../KERNEL-XDRCMS/Init.php";

$skinId = $_POST['skinId'];
$widgetId = $_POST['widgetId'];

if(User::$Data['rank'] < 5 && $skinId == '9')
	$skinId = '1';

switch ($skinId)
{
	case '1':
		$skin = 'w_skin_defaultskin';
	break;
	case '2':
		$skin = 'w_skin_speechbubbleskin';
	break;
	case '3':
		$skin = 'w_skin_metalskin';
	break;
	case '4':
		$skin = 'w_skin_noteitskin';
	break;
	case '5':
		$skin = 'w_skin_notepadskin';
	break;
	case '6':
		$skin = 'w_skin_goldenskin';
	break;
	case '7':
		$skin = 'w_skin_hc_machineskin';
	break;
	case '8':
		$skin = 'w_skin_hc_pillowskin';
	break;
	case '9':
		$skin = 'w_skin_nakedskin';
	break;
	default:
		$skin = 'w_skin_defaultskin';
	break;
}

$getAlreadyItem = SQL::query("SELECT null FROM xdrcms_site_items WHERE (groupId = 0 OR userId = '" . User::$Data['id'] . "') AND id = '$widgetId' AND type = 'widget' LIMIT 1");

if($getAlreadyItem == null || $getAlreadyItem->num_rows == 0):
	echo 'ERROR';
	exit;
endif;

if(isset($_SESSION['Ajax']['Update']))
	$_SESSION['Ajax']['Update'] .= '[widget,' . $widgetId . ',' . $skin . ']';
else
	$_SESSION['Ajax']['Update'] = '[widget,' . $widgetId . ',' . $skin . ']';

header('X-JSON: {"id":"' . $widgetId . '","cssClass":"' . $skin . '","type":"widget"}');
echo "SUCCESS";
?>