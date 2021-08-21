<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

require "../../../KERNEL-XDRCMS/Init.php";

if(isset($_POST["ownerId"], $_POST["groupId"]) && is_numeric($_POST["ownerId"]) && is_numeric($_POST["groupId"]) && strstr($_SERVER["HTTP_REFERER"], PATH . "/home/")):
	$groupData = $MySQLi->query("SELECT name, badge, created, description FROM groups_details WHERE id = '" . $_POST["groupId"] . "'");
	$groupRow = $groupData->fetch_assoc();
	
	if(LOGGED != "null"):
		$Member = $MySQLi->query("SELECT member_rank, is_current FROM groups_memberships WHERE userid = '" . $myrow["id"] . "' AND groupid = '" . $_POST["groupId"] . "' AND is_pending = '0'");
		if($Member->num_rows == 1):
			$isMember = true;
			$memberRow = $Member->fetch_assoc();
		else:
			$isMember = false;
		endif;
	else:
		$isMember = false;
	endif;
?>
<div class="groups-info-basic">
	<div class="groups-info-close-container"><a href="#" class="groups-info-close"></a></div>
	
	<div class="groups-info-icon"><a href="/groups/<?php echo $groupRow["groupid"]; ?>/id"><img src="<?php echo PATH; ?>/habbo-imaging/badge/<?php echo $groupRow["badge"]; ?>.gif" /></a></div>
	<h4><a href="/groups/<?php echo $groupRow["groupid"]; ?>/id"><?php echo $groupRow["name"]; ?></a></h4>
	    <img id="groupname-<?php echo $groupRow["groupid"]; ?>-report" class="report-button report-gn"
			alt="report"
			src="<?php echo webgallery; ?>/images/myhabbo/buttons/report_button.gif"
			style="display: none;" />
	
	<p>
<?php if($isMember && $memberRow["is_current"] == 1): ?>
<img src="<?php echo webgallery; ?>/images/groups/favourite_group_icon.gif" width="15" height="15" class="groups-info-favorite" alt="Favorito" title="Favorito" />
<?php endif; ?>
Grupo creado:<br />
<b><?php echo date("d-M-o", $groupRow["created"]); ?></b>
	</p>
	
	<div class="groups-info-description"><?php echo $groupRow["description"]; ?></div>
	    <img id="groupdesc-<?php echo $groupRow["groupid"]; ?>-report" class="report-button report-gd"
	        alt="report"
	        src="<?php echo webgallery; ?>/images/myhabbo/buttons/report_button.gif"
            style="display: none;" />
</div>

<div class="groups-info-actions">
<p>
Privilegios: <b>
Dueñ@  <img src="<?php echo webgallery; ?>/images/groups/owner_icon.gif" width="15" height="15" alt="Dueñ@" />
</b>
</p>

        <p><a href="#" class="groups-info-deselect-favorite new-button"><b>Quitar como Favorito</b><i></i></a></p>
<div class="clear"></div>
</div>
<?php
endif;
?>