<?php
if(!isset($_POST['skin'], $_POST["noteText"]) || !is_numeric($_POST['skin']))	
	exit;

const APIsLoad = 'Homes.StoreCategories';
require '../../../KERNEL-XDRCMS/Init.php';

$skin = (isset(Categories::$Skins[$_POST['skin']])) ? $_POST['skin'] : 1;
$noteText = substr($_POST["noteText"], 0, 500);

$_SESSION["myhabbo"]["noteeditor"]["text"] = $noteText;
?>
<div id="webstore-notes-container">
<div class="movable stickie <?php echo Categories::$Skins[$skin]['Skin']; ?>-c" style=" left: 0px; top: 0px; z-index: 1;" id="stickie--1">
	<div class="<?php echo Categories::$Skins[$skin]['Skin']; ?>" >
		<div class="stickie-header">
			<h3>
				<img src="<?php echo RES; ?>images/myhabbo/icon_edit.gif" width="19" height="18" class="edit-button" id="stickie--1-edit" />
				<script type="text/javascript">
				var editButtonCallback = function(e) { openEditMenu(e, -1, "stickie", "stickie--1-edit"); };
				Event.observe("stickie--1-edit", "click", editButtonCallback);
				Event.observe("stickie--1-edit", "editButton:click", editButtonCallback); 
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
</div>

<p class="warning">¡Aviso! Este texto no se puede editar después de que hayas colocado la nota en tu página.</p>

<p>
<a href="#" class="new-button" id="webstore-notes-edit"><b>Editar</b><i></i></a>
<a href="#" class="new-button" id="webstore-notes-add"><b>Añadir nota en la página</b><i></i></a>
</p>

<div class="clear"></div>