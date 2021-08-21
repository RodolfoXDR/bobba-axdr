<?php
require "../../../KERNEL-XDRCMS/Init.php";
checkloggedin(1);
?>
<div class="avatar-widget-list-container">
<?php
if(isset($_POST["pageNumber"], $_POST["searchString"], $_POST["widgetId"], $_POST["_groupspage_requested_group"])):
	if(!is_numeric($_POST["pageNumber"]) || !is_numeric($_POST["widgetId"]) || !is_numeric($_POST["_groupspage_requested_group"])):
		exit;
	endif;
	
	$_Check = $MySQLi->query("SELECT null FROM xdrcms_site_items WHERE Type = 'widget' AND id = '" . $_POST["widgetId"] . "' AND groupId = '" . $_POST["_groupspage_requested_group"] . "' LIMIT 1");
	
	if($_Check->num_rows == 1):
		$Page = $_POST["pageNumber"];
		$_Page = (($Page * 20) - 20);
		
		$getMemberssCount = $MySQLi->query("SELECT null FROM groups_memberships WHERE groupID = '" . $_POST["_groupspage_requested_group"] . "' AND is_pending = '0'");
		$getMemberss = $MySQLi->query("SELECT userID FROM groups_memberships WHERE groupID = '" . $_POST["_groupspage_requested_group"] . "' AND is_pending = '0' LIMIT " . $_Page . ",20");

		$NextPage = (($_Page + 20) < $getMemberssCount->num_rows) ? true : false;
		$BackPage = (($_Page - 20) >= 0) ? true : false;

		while($rowMember = $getMemberss->fetch_assoc())
		{
				$rowUser = $Users->getData($rowMember['userID'])->fetch_assoc();
				?>
<ul id="avatar-list-list" class="avatar-widget-list">
	<li id="avatar-list-<?php echo $_POST["widgetId"]; ?>-<?php echo $rowUser['id']; ?>" title="<?php echo $rowUser['username']; ?>"><div class="avatar-list-open"><a href="#" id="avatar-list-open-link-<?php echo $_POST["widgetId"]; ?>-<?php echo $rowUser['id']; ?>" class="avatar-list-open-link"></a></div>
<div class="avatar-list-avatar"><img src="<?php echo LOOK . $rowUser['look']; ?>&direction=4&head_direction=4&gesture=sml&action=&size=s" alt="" /></div>
<h4><a href="<?php echo PATH; ?>/home/<?php echo $rowUser['username']; ?>"><?php echo $rowUser['username']; ?></a></h4>
<p class="avatar-list-birthday"><?php echo $rowUser['account_created']; ?></p>
<p>
<img 
	src="<?php echo webgallery; ?>/images/groups/owner_icon.gif" alt="" class="avatar-list-groupstatus" />
</p></li>

</ul>
<?php } ?>

<div id="avatar-list-info" class="avatar-list-info">
<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close"></a></div>
<div class="avatar-list-info-container"></div>
</div>

</div>

<div id="avatar-list-paging">
    <?php echo $Page + 20; ?> - <?php if($getMemberss->num_rows > 20): echo $Page + 20; else: echo $Page + $getMemberss->num_rows; endif;  ?> / <?php echo $getMemberssCount->num_rows; ?>
    <br/>
<?php if($BackPage): ?>
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-first" >Primero</a> |
    <a  href="#" class="avatar-list-paging-link" id="avatarlist-search-previous" >&lt;&lt;</a> |
<?php else: ?>
    Primero |
    &lt;&lt; |
<?php endif; ?>
<?php if($NextPage): ?>
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-next">&gt;&gt;</a> |
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-last">Último</a>
<?php else: ?>
    &gt;&gt; |
    Último
<?php endif; ?>

<input type="hidden" id="pageNumber" value="<?php echo $_POST["pageNumber"]; ?>"/>
<input type="hidden" id="totalPages" value="<?php echo round($getMemberssCount->num_rows / 2); ?>"/>
</div>
<?php
	endif;
endif;
?>