<?php
$h = false;
if(isset($_POST['ownerAccountId'], $_POST['anAccountId']) && is_numeric($_POST['ownerAccountId']) && is_numeric($_POST['anAccountId']))
	$h = true;
elseif(!isset($_POST['groupId'], $_POST['anAccountId']) && is_numeric($_POST['groupId']) && is_numeric($_POST['anAccountId']))
	exit;

require '../../../KERNEL-XDRCMS/Init.php';
$Ranks = [
	2 => ['owner_icon', 'Dueñ@'],
	1 => ['administrator_icon', 'Administrador'],
	0 => ['', 'Socio']
];

if($h)
	$cQ = $MySQLi->query('SELECT username, look, online, account_created, motto FROM users WHERE id = ' . $_POST['anAccountId']);
else
	$cQ = $MySQLi->query("SELECT users.username, users.look, users.online, users.motto, users.account_created, member_rank, is_current FROM users, groups_memberships WHERE userid = '" . $_POST['anAccountId'] . "' AND groupid = '" . $_POST['groupId'] . "' AND is_pending = '0' LIMIT 1");

if($cQ == null || $cQ->num_rows === 0)
	exit;

$UserRow = $cQ->fetch_assoc();
?>
<div class="avatar-list-info-container">
	<div class="avatar-info-basic clearfix">
		<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close" id="avatar-list-info-close-<?php echo $_POST['anAccountId']; ?>"></a></div>
		<div class="avatar-info-image">
			
			<img src="<?php echo LOOK . $UserRow['look']; ?>&size=b&direction=4&head_direction=4&gesture=sml" alt="<?php echo $UserRow['username']; ?>"/>
		</div>
<h4><a href="/home/<?php echo $UserRow['username']; ?>"><?php echo $UserRow['username']; ?></a></h4>
<p>
<a href="<?php echo PATH; ?>/client" target="<?php echo USER::$Row['client_token']; ?>" onclick="HabboClient.openOrFocus(this); return false;">
<img src="<?php echo webgallery; ?>/images/myhabbo/profile/habbo_<?php echo ($UserRow['online'] == '0') ? 'off' : 'on'; ?>line.gif"/>
</a>
</p>
<p><?php echo $hotelName; ?> creado el: <b><?php echo strtolower(date('d-M-Y', $UserRow['account_created'])); ?></b></p>
<p><a href="/home/<?php echo $UserRow['username']; ?>" class="arrow">Ver Página</a></p>
<p class="avatar-info-motto"><?php echo $UserRow['motto']; ?></p>
	</div>
<?php if(isset($_POST['groupId'])): ?>
	<div class="avatar-info-rights clearfix">
		<div>
Derechos del Grupo: 
<b><?php echo $Ranks[$Rank["member_rank"]][1]; ?> <?php if(!$Rank["member_rank"] == 0) { ?><img src="<?php echo webgallery; ?>/images/groups/<?php echo $Ranks[$Rank["member_rank"]][0]; ?>.gif" width="15" height="15" alt="<?php echo $Ranks[$Rank["member_rank"]][1]; ?>"><?php } ?><?php if($Rank["is_current"] == 1) { ?><img src="<?php echo webgallery; ?>/images/groups/favourite_group_icon.gif" width="15" height="15" alt="Favorito"><?php } ?>
</b>
		</div>
</div>
<?php endif; ?>
</div>