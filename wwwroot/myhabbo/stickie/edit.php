<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['skinId'], $_POST['stickieId']) || !is_numeric($_POST['skinId']) || !is_numeric($_POST['stickieId']))
	exit;

require '../../../KERNEL-XDRCMS/Init.php';

$skinId = $_POST['skinId'];
$stickieId = $_POST['stickieId'];

if(User::$Data['rank'] < 5 && $skinId == '9')
	$skinId = '1';

switch ($skinId)
{
	case '1':
		$skin = 'n_skin_defaultskin';
	break;
	case '2':
		$skin = 'n_skin_speechbubbleskin';
	break;
	case '3':
		$skin = 'n_skin_metalskin';
	break;
	case '4':
		$skin = 'n_skin_noteitskin';
	break;
	case '5':
		$skin = 'n_skin_notepadskin';
	break;
	case '6':
		$skin = 'n_skin_goldenskin';
	break;
	case '7':
		$skin = 'n_skin_hc_machineskin';
	break;
	case '8':
		$skin = 'n_skin_hc_pillowskin';
	break;
	case '9':
		$skin = 'n_skin_nakedskin';
	break;
	default:
		$skin = 'n_skin_defaultskin';
	break;
}

$getAlreadyItem = SQL::query("SELECT id, position_left, position_top, position_z, content FROM xdrcms_site_items WHERE (userId = '" . User::$Data['id'] . "') AND id = '" . $stickieId . "' AND type = 'stickie' LIMIT 1");

if($getAlreadyItem == null || $getAlreadyItem->num_rows == 0):
	echo 'ERROR';
	exit;
endif;

if(isset($_SESSION['Ajax']['Update']))
	$_SESSION['Ajax']['Update'] = $_SESSION['Ajax']['Update'] . "[stickie,$stickieId,$skin]";
else
	$_SESSION['Ajax']['Update'] = "[stickie,$stickieId,$skin]";

$row = $getAlreadyItem->fetch_assoc();

header('X-JSON: {"id":"' . $stickieId . '","cssClass":"' . $skin . '","type":"stickie"}');
?>
<div class="movable stickie <?php echo $skin; ?>-c" style=" left: <?php echo $row['position_left']; ?>px; top: <?php echo $row['position_top']; ?>px; z-index: <?php echo $row['position_z']; ?>;" id="stickie-<?php echo $row['id']; ?>">
	<div class="<?php echo $skin; ?>" >
		<div class="stickie-header">
			<h3>
			<?php if($edit_mode) { ?>
				<img src="<?php echo webgallery; ?>/images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="stickie-<?php echo $row['id']; ?>-edit" />
				<script type="text/javascript">
				var editButtonCallback = function(e) { openEditMenu(e, <?php echo $row['id']; ?>, "stickie", "stickie-<?php echo $row['id']; ?>-edit"); };
				Event.observe("stickie-<?php echo $row['id']; ?>-edit", "click", editButtonCallback);
				Event.observe("stickie-<?php echo $row['id']; ?>-edit", "editButton:click", editButtonCallback); 
				</script>
			<?php } else { ?>
			<img id="stickie-<?php echo $row['id']; ?>-report" class="report-button report-s" alt="report" src="<?php echo RES; ?>images/myhabbo/buttons/report_button.gif" style="display: none" />
			<?php } ?>
			</h3>
			<div class="clear"></div>
		</div>

		<div class="stickie-body">
			<div class="stickie-content">
				<div class="stickie-markup"><?php echo $row['content']; ?></div>
				<div class="stickie-footer">
				</div>
			</div>
		</div>
	</div>

</div>