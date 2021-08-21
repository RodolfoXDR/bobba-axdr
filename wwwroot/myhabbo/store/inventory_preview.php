<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['itemId'], $_POST['type']) || !in_array($_POST['type'], ['stickers', 'widgets', 'notes', 'backgrounds']))	exit;

require '../../../KERNEL-XDRCMS/Init.php';

$type = ucwords($_POST['type']);
$type = substr($type, 0, -1);

if($_POST['type'] === 'notes'):
	$getPreview = SQL::query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND type = 'WebCommodity' AND isWaiting = '0' LIMIT 1");
	if(!$getPreview || $getPreview->num_rows === 0)	exit;

	$row = $getPreview->fetch_assoc();
	
	header('X-JSON: ' . json_encode([$row['skin'], $row['skin'], '', $type, null, 1]));
elseif($_POST['type'] === 'backgrounds'):
	$getPreview = SQL::query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $_POST['itemId'] . "' AND type = 'background' AND isWaiting = '0' LIMIT 1");
	if(!$getPreview || $getPreview->num_rows === 0)	exit;

	$row = $getPreview->fetch_assoc();
	
	header('X-JSON: ' . json_encode([$row['skin'], $row['skin'], '', $type, null, 1]));
elseif($_POST['type'] === 'widgets'):
	if($_POST['itemId'] == '2'):
		$Skin = 'w_roomswidget_pre';
		$Name = 'Mis salas';
	elseif($_POST['itemId'] == '3'):
		$Skin = 'w_friendswidget_pre';
		$Name = 'Mis amigos';
	elseif($_POST['itemId'] == '5'):
		$Skin = 'w_guestbookwidget_pre';
		$Name = 'Libro de Invitados';
	elseif($_POST['itemId'] == '17'):
		$Skin = 'w_traxplayerwidget_pre';
		$Name = 'Reproductor';
	elseif($_POST['itemId'] == '21'):
		$Skin = 'w_badgeswidget_pre';
		$Name = 'Mis placas';
	else:
		exit();
	endif;

	header('X-JSON: ' . json_encode([$Skin, null, $Name, 'Widget', true, 0]));
else:
	$getPreview = SQL::query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $_POST['itemId'] . "' AND type = '" . $type . "' AND isWaiting = '0'");
	if(!$getPreview || $getPreview->num_rows === 0)	exit;

	$row = $getPreview->fetch_assoc();
	$getSame = SQL::query("SELECT null FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND skin = '" . $row['skin'] . "' AND type = '" . $type . "' AND isWaiting = '0'")->num_rows;

	header('X-JSON: ' . json_encode([$row['skin'], $row['skin'], '', $type, null, 1]));
endif;
?>
<h4>&nbsp;</h4>
<div id="inventory-preview-box"></div> 
<div id="inventory-preview-place" class="clearfix">
	<div class="clearfix"> 
		<a href="#" class="new-button" id="inventory-place">
			<b>Colocar</b>
			<i></i>
		</a>
	</div>
	<?php if(isset($getSame) && $getSame > 1): ?>
	<div class="clearfix">
		<a href="#" class="new-button" id="inventory-place-all">
			<b>Colocar todos</b>
			<i></i>
		</a>
	</div>
	<?php endif; ?>
</div> 