<?php
if(!isset($_POST['skin'], $_POST["noteText"]) || !is_numeric($_POST['skin']))	exit;

const APIsLoad = 'Homes.StoreCategories';
require '../../../KERNEL-XDRCMS/Init.php';

$skin = (isset(Categories::$Skins[$_POST['skin']])) ? $_POST['skin'] : 1;
$noteText = substr($_POST['noteText'], 0, 500);

unset($_SESSION['myhabbo']['noteeditor']['text']);

$q = SQL::query("INSERT INTO xdrcms_site_items (userId, groupId, position_left, position_top, position_z, skin, content, type, Temporal) VALUES ('" . User::$Data['id'] . "', '0', 10, 10, 8, '$skin', '$noteText', 'stickie', 'True')");

if(!$q || SQL::$affected_rows !== 1)	
	exit; 

$InsertId = SQL::$insert_id;

if(isset($_SESSION['NewNotes'])):
	array_push($_SESSION['NewNotes'], [$InsertId]);
else:
	$_SESSION['NewNotes'] = [$InsertId];
endif;

if(isset($_SESSION["Ajax"]["UpdateTemporal"]))
	$_SESSION["Ajax"]["UpdateTemporal"] = $_SESSION["Ajax"]["UpdateTemporal"] . "[" . $InsertId . ",commodity_stickienote_pre]";
else
	$_SESSION["Ajax"]["UpdateTemporal"] = "[" . $InsertId . ",commodity_stickienote_pre]";

header('X-JSON: ' . $InsertId);
?>
<div class="movable stickie <?php echo Categories::$Skins[$skin]['Skin']; ?>-c" style=" left: 10px; top: 10px; z-index: 8;" id="stickie-<?php echo $InsertId; ?>">
	<div class="<?php echo Categories::$Skins[$skin]['Skin']; ?>" >
		<div class="stickie-header">
			<h3>
<img src="<?php echo RES; ?>images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="stickie-<?php echo $InsertId; ?>-edit" />
<script type="text/javascript">
var editButtonCallback = function(e) { openEditMenu(e, <?php echo $InsertId; ?>, "stickie", "stickie-<?php echo $InsertId; ?>-edit"); };
Event.observe("stickie-<?php echo $InsertId; ?>-edit", "click", editButtonCallback);
Event.observe("stickie-<?php echo $InsertId; ?>-edit", "editButton:click", editButtonCallback); 
</script>
			</h3>
			<div class="clear"></div>
		</div>
		<div class="stickie-body">
			<div class="stickie-content">
                <div class="stickie-markup"><?php echo Tool::DecodeBBText($noteText); ?></div>
				<div class="stickie-footer">
				</div>
			</div>
		</div>
	</div>
</div>
