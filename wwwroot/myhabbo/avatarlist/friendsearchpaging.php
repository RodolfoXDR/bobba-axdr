<?php
if(!isset($_POST['searchString'], $_POST['widgetId'], $_POST['_mypage_requested_account']) || !is_numeric($_POST['widgetId']) || !is_numeric($_POST['_mypage_requested_account']))
	exit;
require '../../../KERNEL-XDRCMS/Init.php';

$s = (isset($_POST['pageNumber']) && is_numeric($_POST['pageNumber']) && $_POST['pageNumber'] > -1 && $_POST['pageNumber'] < 10000) ? $_POST['pageNumber'] : 0;
$S = $_POST['searchString'];

$uQ = SQL::query('SELECT users.id, users.username, users.look FROM users, messenger_friendships WHERE (messenger_friendships.user_one_id = ' . $_POST['_mypage_requested_account'] . ' AND users.id = messenger_friendships.user_two_id  AND users.username LIKE \'' . $_POST['searchString'] . '%\') OR (messenger_friendships.user_two_id = ' . $_POST['_mypage_requested_account'] . ' AND users.id = messenger_friendships.user_one_id AND users.username LIKE \'' . $_POST['searchString'] . '%\') ORDER BY users.id DESC LIMIT ' . ($s-1)*20 . ',20');
$uC = SQL::query('SELECT Count(*) FROM users, messenger_friendships WHERE (messenger_friendships.user_one_id = ' . $_POST['_mypage_requested_account'] . ' AND users.id = messenger_friendships.user_two_id  AND users.username LIKE \'' . $_POST['searchString'] . '%\') OR (messenger_friendships.user_two_id = ' . $_POST['_mypage_requested_account'] . ' AND users.id = messenger_friendships.user_one_id  AND users.username LIKE \'' . $_POST['searchString'] . '%\')');

if(!$uC || !$uQ || $uQ->num_rows === 0)
	exit;
	
$uC = $uC->fetch_assoc()['Count(*)'];
$uT = $uQ->num_rows;
?>
<div class="avatar-widget-list-container">
<?php if($uC == 0): ?>
						No tienes amigos :(
<?php else: echo '<ul id="avatar-list-list" class="avatar-widget-list">';
	while($uR = $uQ->fetch_assoc()): ?>
						<li id="avatar-list-<?php echo $_POST['widgetId']; ?>-<?php echo $uR['id']; ?>" title="<?php echo $uR['username']; ?>"><div class="avatar-list-open"><a href="#" id="avatar-list-open-link-<?php echo $_POST['widgetId']; ?>-<?php echo $uR['id']; ?>" class="avatar-list-open-link"></a></div>
							<div class="avatar-list-avatar"><img src="<?php echo LOOK . $uR['look']; ?>&size=s&direction=4&head_direction=4&gesture=sml" alt="" /></div>
							<h4><a href="<?php echo URL; ?>/home/<?php echo $uR['id']; ?>/id"><?php echo $uR['username']; ?></a></h4>
							<!--<p class="avatar-list-birthday"><?php //echo User::GetData($uR['id'], 'birth', 'id', '', 'xdr_users')['birth']; ?></p>-->
							<p>

							</p>
						</li>
<?php endwhile; echo '</ul>'; endif; ?>

<div id="avatar-list-info" class="avatar-list-info">
<div class="avatar-list-info-close-container"><a href="#" class="avatar-list-info-close"></a></div>
<div class="avatar-list-info-container"></div>
</div>

</div>
<div id="avatar-list-paging">
    <?php echo ($s - 1) * 20; ?> - <?php echo 20*($s) - (20 - $uT); ?> / <?php echo $uC; ?>
    <br/>
<?php if($s != 1): ?>
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-first" >Primero</a> |
    <a  href="#" class="avatar-list-paging-link" id="avatarlist-search-previous" >&lt;&lt;</a> |
<?php else: ?>
    Primero |
    &lt;&lt; |
<?php endif; ?>
<?php if($uC > 20*($s)): ?>
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-next" >&gt;&gt;</a> |
    <a href="#" class="avatar-list-paging-link" id="avatarlist-search-last" >Último</a>
<?php else: ?>
	&gt;&gt; |
	Último
<?php endif; ?>
<input type="hidden" id="pageNumber" value="<?php echo $s; ?>"/>
<input type="hidden" id="totalPages" value="<?php echo ceil($uC / $uQ->num_rows); ?>"/>
</div>

<script type="text/javascript">
</script>