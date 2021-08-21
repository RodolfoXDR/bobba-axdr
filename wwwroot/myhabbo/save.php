<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

const APIsLoad = 'Homes.StoreCategories,Homes.Items';
require '../../KERNEL-XDRCMS/Init.php';

$stickers = (isset($_POST['stickers'])) ? $_POST['stickers'] : '';
$Widgets = (isset($_POST['widgets'])) ? $_POST['widgets'] : '';
$Stickies = (isset($_POST['stickienotes'])) ? $_POST['stickienotes'] : '';
$background = (isset($_POST['background'])) ? $_POST['background'] : '';

$InsertsStickers = (isset($_SESSION['Ajax']['Insert'])) ? $_SESSION['Ajax']['Insert'] : [];

unset($_SESSION['Ajax']['Insert']);

// Guardando Stickers
if(!empty($stickers) && strstr($stickers, '/')):
	$theStickers = explode('/', $stickers);
	
	foreach($theStickers as $Sticker):
		if(empty($Sticker) || strpos($Sticker, ':') === false || strpos($Sticker, ',') === false)
			continue;

		$sticker = explode(':', $Sticker);
		if(!is_numeric($sticker[0]))
			continue;
			
		$stickerId = $sticker[0];
		$Positions = explode(',', $sticker[1]);

		if(count($Positions) != 3):
			exit;
		else:
			foreach($Positions as $scoord)
				if(!is_numeric($scoord))
					exit;
		endif;

		if(isset($InsertsStickers[$stickerId]))
			unset($InsertsStickers[$stickerId]);

		$q = SQL::query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $stickerId ."' AND isWaiting = '1' LIMIT 1");
	
		if($q->num_rows > 0):
			Item::Place(User::$Data['id'], 0, $Positions[0], $Positions[1], $Positions[2], '', $q->fetch_assoc()['skin'], '', "sticker");
			Item::removeWaiting(User::$Data['id'], $stickerId);
		else:
			$q = SQL::query("SELECT null FROM xdrcms_site_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $stickerId ."' AND type = 'sticker' LIMIT 1");
			if($q && $q->num_rows > 0)
				Item::Update('d', [$stickerId, User::$Data['id'], 0, $Positions[0], $Positions[1], $Positions[2]]);
		endif;
	endforeach;
endif;

foreach($InsertsStickers as $StickerId => $PosZ):
	$position_left = '20';
	$position_top = '30';
	$position_z = $PosZ;
			
	$checkSticker = SQL::query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $StickerId ."' AND isWaiting = '1' LIMIT 1");
	$checkAlreadySticker = SQL::query("SELECT null FROM xdrcms_site_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $StickerId ."' AND type = 'sticker' LIMIT 1");
			
	if($checkSticker->num_rows > 0):
		$row = $checkSticker->fetch_assoc();
			
		Item::Place(User::$Data['id'], 0, $position_left, $position_top, $position_z, "", $row['skin'], '', 'sticker');
		Item::removeWaiting(User::$Data['id'], $StickerId);
	elseif($checkAlreadySticker->num_rows > 0):
		Item::Update('d', [$StickerId, User::$Data['id'], 0, $position_left, $position_top, $position_z]);
	endif;
endforeach;

// Guardando Widgets

if(!empty($Widgets)):
	$theWidgets = explode('/', $Widgets);

	foreach($theWidgets as $raw):
		if(empty($raw) || strpos($raw, ':') === false || strpos($raw, ',') === false)
			continue;

		$bits = explode(':', $raw);

		if(!is_numeric($bits[0]) || empty($bits[0]))
			continue;

		$id = $bits[0];
		$data = $bits[1];
		$coords = explode(',', $data);

		if(count($coords) != 3):
			exit;
		else:
			foreach($coords as $scoord)
				if(!is_numeric($scoord))
					exit;
		endif;

		$x = $coords[0];
		$y = $coords[1];
		$z = $coords[2];

		$checkWidget = SQL::query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $id ."' AND isWaiting = '1' LIMIT 1");
		$checkAlreadyWidget = SQL::query("SELECT null FROM xdrcms_site_items WHERE userId = '" . User::$Data['id'] . "' AND id = '$id' AND type = 'widget' LIMIT 1");

		if($checkWidget->num_rows > 0):
			$row = $checkWidget->fetch_assoc();

			Item::Place(User::$Data['id'], 0, $x, $y, $z, '', $row['skin'], '', 'widget');
			Item::removeWaiting(User::$Data['id'], $id);
		elseif($checkAlreadyWidget->num_rows > 0):
			Item::Update('d', [$id, User::$Data['id'], 0, $x, $y, $z]);
		endif;
	endforeach;
endif;

// Guardando Stikies

if(!empty($Stickies)):
	$theStickies = explode('/', $Stickies);
	$nCount = 0;
	foreach($theStickies as $raw):
		if(empty($raw) || strpos($raw, ':') === false || strpos($raw, ',') === false)
			continue;

		$bits = explode(':', $raw);

		if(!is_numeric($bits[0]) || empty($bits[0]))
			continue;

		$id = $bits[0];
		$data = $bits[1];
		$coords = explode(',', $data);

		if(count($coords) != 3):
			exit;
		else:
			foreach($coords as $scoord)
				if(!is_numeric($scoord))
					exit;
		endif;

		$x = $coords[0];
		$y = $coords[1];
		$z = $coords[2];

		if($id == 0):
			if(isset($_SESSION['NewNotes'][$nCount])):
				$nCount++;
				$id = $_SESSION['NewNotes'][$nCount];
			endif;
		endif;

		$q = SQL::query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $id ."' AND isWaiting = '1' LIMIT 1");

		if($q && $q->num_rows === 1):
			Item::Palce($homeId, 0, $x, $y, $z, '', $q->fetch_assoc()['skin'], '', 'stickie');
			Item::Update('t', [$id]);
		else:
			$q = SQL::query("SELECT null FROM xdrcms_site_items WHERE userId = '" . User::$Data['id'] . "' AND id = '$id' AND type = 'stickie' LIMIT 1");
			if($q && $q->num_rows === 1):
				Item::Update('d', [$id, User::$Data['id'], 0, $x, $y, $z]);
				Item::Update('t', [$id]);
			endif;
		endif;
	endforeach;
endif;
	
// Guardando Fondo
if(!empty($background)):
	$theBackground = explode(':', $background);
	$array = json_decode('["b_bg_fondo_foqb","b_es_el_internardo_bg_v1","b_bg_bobbaheart","b_bg_rain","b_bg_serpentine_1","b_bg_serpentine_2","b_bg_serpentine_darkblue","b_bg_serpntine_darkred","b_bg_denim","b_bg_lace","b_bg_stitched","b_bg_wood","b_bg_cork","b_bg_stone","b_bg_pattern_bricks","b_bg_ruled_paper","b_bg_grass","b_bg_hotel","b_bg_bubble","b_bg_pattern_bobbaskulls1","b_bg_pattern_space","b_bg_image_submarine","b_bg_metal2","b_bg_broken_glass","b_bg_pattern_clouds","b_bg_comic2","b_bg_pattern_floral_01","b_bg_pattern_floral_02","b_bg_pattern_floral_03","b_bg_pattern_bulb","b_bg_pattern_cars","b_bg_pattern_plasto","b_bg_pattern_tinyroom","b_bg_pattern_hearts","b_bg_pattern_abstract1","b_bg_bathroom_tile","b_bg_pattern_fish","b_bg_pattern_deepred","b_bg_colour_02","b_bg_colour_03","b_bg_colour_04","b_bg_colour_05","b_bg_colour_06","b_bg_colour_07","b_bg_colour_09","b_bg_colour_10","b_bg_colour_11","b_bg_colour_13","b_bg_colour_14","b_bg_colour_15","b_bg_colour_17"]', true);
	if(in_array($theBackground[1], $array))
		SQL::query("UPDATE xdr_users SET homeBg = '" . $theBackground[1] . "' WHERE id = '" . User::$Data['id'] . "' LIMIT 1");
endif;

if(isset($_SESSION['Ajax']['Update'])):
	$Update = explode('[', $_SESSION['Ajax']['Update']);

	foreach($Update as $Data):
		if(empty($Data))
			continue;
		$d = explode(',', $Data);

		$Type = $d[0];
		$Id = $d[1];
		$Skin = str_replace(']', '', $d[2]);

		if(!empty($Type) && !empty($Id) && !empty($Skin))
			Item::Update('s', [$Id, User::$Data['id'], 0, $Skin]);
	endforeach;
endif;

if(isset($_SESSION['Ajax']['Delete'])):
	$Delete = explode('[', $_SESSION['Ajax']['Delete']);

	foreach($Delete as $Data):
		if(empty($Data))
			continue;
		$d = explode(',', $Data);

		$Type = $d[0];
		$Id = $d[1];
		$Skin = str_replace(']', '', $d[2]);

		if(!empty($Type) && !empty($Id)):
			SQL::query("DELETE FROM xdrcms_site_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $Id . "' AND type = '$Type' LIMIT 1");

			if($Type === 'sticker')
				Item::Create(User::$Data['id'], 0, $Skin, 'sticker');
		endif;
	endforeach;
endif;

if(isset($_SESSION['Ajax']['UpdateTemporal'])):
	$UpdateTemporal = explode('[', $_SESSION['Ajax']['UpdateTemporal']);

	foreach($UpdateTemporal as $Data):
		if(empty($Data))
			continue;
		$d = explode(',', $Data);

		$Id = $d[0];
		$SkinId = str_replace(']', '', $d[1]);

		if(!empty($Id)):
			SQL::query("DELETE FROM xdrcms_site_inventory_items WHERE skin = '" . $SkinId . "' AND userId = '" . User::$Data['id'] . "' LIMIT 1");
			Item::Update('t', [$Id]);
		endif;
	endforeach;
endif;

unset($_SESSION['Ajax']['Update']);
unset($_SESSION['Ajax']['Delete']);
unset($_SESSION['Ajax']['UpdateTemporal']);

unset($_SESSION['home_edit']);

SQL::query("DELETE FROM xdrcms_site_items WHERE Temporal = 'True'");

echo '<script language="JavaScript" type="text/javascript">waitAndGo(\'' . URL . '/home/' . User::$Data['name'] . '\');</script>';
exit;
?>