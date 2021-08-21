<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

$require_login = true;
require "../../KERNEL-XDRCMS/Init.php";
checkloggedin(1);

$groupId = 0;
$homeId = 0;

if(isset($_SESSION['group_edit_id']))
	$groupId = $_SESSION['group_edit_id'];
else
	$homeId = $my_id;


$stickers = "";
$Widgets = "";
$Stickies = "";
$background = "";

if(isset($_POST['stickers'])):
	$stickers = $_POST['stickers'];
endif;

if(isset($_POST['widgets'])):
	$Widgets = $_POST['widgets'];
endif;

if(isset($_POST['stickienotes'])):
	$Stickies = $_POST['stickienotes'];
endif;

if(isset($_POST['background'])):
	$background = $_POST['background'];
endif;

if(!empty($stickers)):
	$theStickers = explode("/", $stickers);
	
	foreach($theStickers as $Sticker)
	{
		if($Sticker != "" && strpos($Sticker, ":") !== false && strpos($Sticker, ",") !== false):
			$sticker = explode(":", $Sticker);
			$Positions = explode(",", $sticker[1]);

			if(count($Positions) != 3):
				exit;
			else:
				foreach($Positions as $scoord)
				{
					if(!is_numeric($scoord))
						exit;
				}
			endif;


			if(is_numeric($sticker[0]))
				$stickerId = $sticker[0];
			else
				exit;

			$position_left = $Positions[0];
			$position_top = $Positions[1];
			$position_z = $Positions[2];

			$checkSticker = $MySQLi->query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . $my_id . "' AND id = '" . $stickerId ."' AND isWaiting = '1' LIMIT 1");

			if($groupId == "0"):
				$checkAlreadySticker = $MySQLi->query("SELECT null FROM xdrcms_site_items WHERE userId = '$homeId' AND id = '" . $stickerId ."' AND type = 'sticker' LIMIT 1");
			else:
				$checkAlreadySticker = $MySQLi->query("SELECT null FROM xdrcms_site_items WHERE groupId = '$groupId' AND id = '" . $stickerId ."' AND type = 'sticker' LIMIT 1");
			endif;
		
			if($checkSticker->num_rows > 0):
				$row = $checkSticker->fetch_assoc();
			
				$Users->newItem($homeId, $groupId, $position_left, $position_top, $position_z, "", $row['skin'], "", "sticker");
				$Users->removeWaitingItem($my_id, $stickerId);
			elseif($checkAlreadySticker->num_rows > 0):
				$Users->updateItem($stickerId, $homeId, $groupId, $position_left, $position_top, $position_z);
			endif;
		endif;
	}
endif;

if(!empty($Widgets)):
	$theWidgets = explode("/", $Widgets);

	foreach($theWidgets as $raw)
	{
		if($raw != "" && strpos($raw, ":") !== false && strpos($raw, ",") !== false):
			$bits = explode(":", $raw);

			if(is_numeric($bits[0])):
				$id = $bits[0];
			else:
				exit;
			endif;

			$data = $bits[1];

			if(!empty($data) && !empty($id) && is_numeric($id)):
				$coordinates = explode(",", $data);

				if(count($coordinates) != 3):
					exit;
				else:
					foreach($coordinates as $scoord)
					{
						if(!is_numeric($scoord))
							exit;
					}
				endif;

				$x = $coordinates[0];
				$y = $coordinates[1];
				$z = $coordinates[2];

				$checkWidget = $MySQLi->query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . $my_id . "' AND id = '" . $id ."' AND isWaiting = '1' LIMIT 1");

				if($groupId == "0"):
					$checkAlreadyWidget = $MySQLi->query("SELECT null FROM xdrcms_site_items WHERE userId = '$homeId' AND id = '$id' AND type = 'widget' LIMIT 1");
				else:
					$checkAlreadyWidget = $MySQLi->query("SELECT null FROM xdrcms_site_items WHERE groupId = '$groupId' AND id = '$id' AND type = 'widget' LIMIT 1");
				endif;

				if($checkWidget->num_rows > 0):
					$row = $checkWidget->fetch_assoc();

					$Users->newItem($homeId, $groupId, $x, $y, $z, "", $row['skin'], "", "widget");
					$Users->removeWaitingItem($my_id, $id);
				elseif($checkAlreadyWidget->num_rows > 0):
					$Users->updateItem($id, $homeId, $groupId, $x, $y, $z);
				endif;
			endif;
		endif;
	}
endif;

// Guardando Stikies

if(!empty($Stickies)):
	$theStickies = explode("/", $Stickies);

	foreach($theStickies as $raw)
	{
		if($raw != "" && strpos($raw, ":") !== false && strpos($raw, ",") !== false):
			$bits = explode(":", $raw);

			if(is_numeric($bits[0])):
				$id = $bits[0];
			else:
				exit;
			endif;

			$data = $bits[1];

			if(!empty($data) && !empty($id) && is_numeric($id)):
				$coordinates = explode(",", $data);

				if(count($coordinates) != 3):
					exit;
				else:
					foreach($coordinates as $scoord)
					{
						if(!is_numeric($scoord))
							exit;
					}
				endif;

				$x = $coordinates[0];
				$y = $coordinates[1];
				$z = $coordinates[2];

				$checkStickie = $MySQLi->query("SELECT skin FROM xdrcms_site_inventory_items WHERE userId = '" . $my_id . "' AND id = '" . $id ."' AND isWaiting = '1' LIMIT 1");

				if($groupId == "0"):
					$checkAlreadyStickie = $MySQLi->query("SELECT null FROM xdrcms_site_items WHERE userId = '$homeId' AND id = '$id' AND type = 'stickie' LIMIT 1");
				else:
					$checkAlreadyStickie = $MySQLi->query("SELECT null FROM xdrcms_site_items WHERE groupId = '$groupId' AND id = '$id' AND type = 'stickie' LIMIT 1");
				endif;

				if($checkStickie->num_rows > 0):
					$row = $checkStickie->fetch_assoc();

					$Users->newItem($homeId, $groupId, $x, $y, $z, "", $row['skin'], "", "stickie");
					$Users->updateTemporalItem($id);
				elseif($checkAlreadyStickie->num_rows > 0):
					$Users->updateItem($id, $homeId, $groupId, $x, $y, $z);
					$Users->updateTemporalItem($id);
				endif;
			endif;
		endif;
	}
endif;
	
// Guardando Fondo
if(!empty($background)):
	$theBackground = explode(":", $background);

	if($groupId == 0)
		$MySQLi->query("UPDATE users SET homeBg = '" . $theBackground[1] . "' WHERE id = '" . $my_id . "' LIMIT 1");
	else
		$MySQLi->query("UPDATE groups_details SET bg = '" . $theBackground[1] . "' WHERE id = '" . $groupId . "' LIMIT 1");
endif;

if(isset($_SESSION["Ajax"]["Update"])):
	$Update = explode("[", $_SESSION["Ajax"]["Update"]);

	foreach($Update as $Data)
	{
		if($Data != ""):
			$Data = explode(",", $Data);

			$Type = $Data[0];
			$Id = $Data[1];
			$Skin = str_replace("]", "", $Data[2]);

			if(!empty($Type) && !empty($Id) && !empty($Skin))
				$Users->updateSkinItem($Id, $homeId, $groupId, $Skin);
		endif;
}

endif;

if(isset($_SESSION["Ajax"]["Delete"])):
	$Delete = explode("[", $_SESSION["Ajax"]["Delete"]);

	foreach($Delete as $Data)
	{
		if($Data != ""):
			$Data = explode(",", $Data);

			$Type = $Data[0];
			$Id = $Data[1];
			$Skin = str_replace("]", "", $Data[2]);

			if(!empty($Type) && !empty($Id))
			{
				if($groupId == "0")
					$MySQLi->query("DELETE FROM xdrcms_site_items WHERE userId = '$homeId' AND id = '" . $Id . "' AND type = '$Type' LIMIT 1");
				else
					$MySQLi->query("DELETE FROM xdrcms_site_items WHERE groupId = '$groupId' AND id = '" . $Id . "' AND type = '$Type' LIMIT 1");

				if($Type == "sticker")
					$Users->newInventoryItem($homeId, $groupId, $Skin, "sticker");
			}
		endif;
	}
endif;

if(isset($_SESSION["Ajax"]["UpdateTemporal"])):
	$UpdateTemporal = explode("[", $_SESSION["Ajax"]["UpdateTemporal"]);

	foreach($UpdateTemporal as $Data)
	{
		if($Data != ""):
			$Data = explode(",", $Data);
			
			$Id = $Data[0];
			$SkinId = str_replace("]", "", $Data[1]);

			if(!empty($Id)):
				$MySQLi->query("DELETE FROM xdrcms_site_inventory_items WHERE skin = '" . $SkinId . "' AND userId = '" . $my_id . "' LIMIT 1");
				$Users->updateTemporalItem($Id);
			endif;
		endif;
	}
endif;

unset($_SESSION["Ajax"]["Update"]);
unset($_SESSION["Ajax"]["Delete"]);
unset($_SESSION["Ajax"]["UpdateTemporal"]);

unset($_SESSION['home_edit']);
unset($_SESSION['group_edit']);
unset($_SESSION['group_edit_id']);

$MySQLi->query("DELETE FROM xdrcms_site_items WHERE Temporal = 'True'");

if($groupId == "0")
	echo '<script language="JavaScript" type="text/javascript">waitAndGo(\'' . PATH . '/home/' . $myrow["username"] . '\');</script>';
else
	echo '<script language="JavaScript" type="text/javascript">waitAndGo(\'' . PATH . '/groups/' . $groupId . '/id\');</script>';
exit;
?>