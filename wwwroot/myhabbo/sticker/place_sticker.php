<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['selectedStickerId'], $_POST['zindex']) || !is_numeric($_POST['selectedStickerId']) || !is_numeric($_POST['zindex']))	exit;
require '../../../KERNEL-XDRCMS/Init.php';

$selectedStickerId = $_POST['selectedStickerId'];
$zindex = $_POST['zindex'];
$placeAll = (isset($_POST['placeAll'])) ? true : false;

$getItem = SQL::query("SELECT id, skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $selectedStickerId . "' AND isWaiting = '0' LIMIT 1");

if(!$getItem || $getItem->num_rows != 1)	exit;

$row = $getItem->fetch_assoc();

if($placeAll):
	$i = 0;
	$x_json = '';
	$getSame = SQL::query("SELECT id, skin FROM xdrcms_site_inventory_items WHERE userId = '" . User::$Data['id'] . "' AND skin = '" . $row['skin'] . "' AND isWaiting = '0'");
	
	if(!$getSame || $getSame->num_rows < 1)	exit;
	SQL::query("UPDATE xdrcms_site_inventory_items SET isWaiting = '1' WHERE userId = '" . User::$Data['id'] . "' AND skin = '" . $row['skin'] . "' AND isWaiting = '0'");
	while($row = $getSame->fetch_assoc()):
		++$i;
		++$zindex;

		$x_json .= $row['id'];

		$_SESSION['Ajax']['Insert'][$row['id']] = $zindex;
		
		if($i !== $getSame->num_rows):
			$x_json .= ", ";
		endif;
?>
<div class="movable sticker <?php echo $row['skin']; ?>" style="left: 20px; top: 30px; z-index: <?php echo $zindex; ?>" id="sticker-<?php echo $row['id']; ?>">
<img src="<?php echo RES; ?>images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="sticker-<?php echo $row['id']; ?>-edit" />
<script language="JavaScript" type="text/javascript">
Event.observe("sticker-<?php echo $row['id']; ?>-edit", "click", function(e) { openEditMenu(e, <?php echo $row['id']; ?>, "sticker", "sticker-<?php echo $row['id']; ?>-edit"); }, false);
</script>
</div>
<?php
	endwhile;

	header("X-JSON: [" . $x_json . "]");
	exit;
else:
	header("X-JSON: [\"" . $row['id'] . "\"]");
	$_SESSION["Ajax"]["Insert"][$row["id"]] = $zindex + 1;

	SQL::query("UPDATE xdrcms_site_inventory_items SET isWaiting = '1' WHERE userId = '" . User::$Data['id'] . "' AND id = '" . $selectedStickerId . "' AND isWaiting = '0' LIMIT 1");
endif;
?>
<div class="movable sticker <?php echo $row['skin']; ?>" style="left: 20px; top: 30px; z-index: <?php echo $zindex + 1; ?>" id="sticker-<?php echo $row['id']; ?>">
<img src="<?php echo RES; ?>images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="sticker-<?php echo $row['id']; ?>-edit" />
<script type="text/javascript">
var editButtonCallback = function(e) { openEditMenu(e, <?php echo $row['id']; ?>, "sticker", "sticker-<?php echo $row['id']; ?>-edit"); };
Event.observe("sticker-<?php echo $row['id']; ?>-edit", "click", editButtonCallback);
Event.observe("sticker-<?php echo $row['id']; ?>-edit", "editButton:click", editButtonCallback); 
</script>
</div>