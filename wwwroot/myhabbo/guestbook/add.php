<?php
if(!isset($_POST['ownerId'], $_POST['message'], $_POST['widgetId']) || !is_numeric($_POST['ownerId']) || !is_numeric($_POST['widgetId']))	exit;
require '../../../KERNEL-XDRCMS/Init.php';

if(User::$Data['id'] !== $_POST['ownerId'])	exit;

if(isset($_SESSION['guestBook']['lastEntry']) && ((time() - $_SESSION['guestBook']['lastEntry']) < 60)):
	echo 'You have to wait for a while before you can comment again.';
	exit;
endif;

SQL::query('INSERT INTO xdrcms_guestbook (message, time, widget_id, userid) VALUES (\'' . $_POST['message'] . '\', \'' . time() . '\', \'' . $_POST['widgetId'] . '\', \'' . User::$Data['id'] . '\')');
$InsertId = SQL::$insert_id;

$_SESSION['guestBook']['lastEntry'] = time();
?>
	<li id="guestbook-entry-<?php echo $InsertId; ?>" class="guestbook-entry">
		<div class="guestbook-author">
                <img src="<?php echo LOOK . User::$Data['figure']; ?>&direction=4&head_direction=4&gesture=sml&action=&size=s" alt="<?php echo User::$Data['name']; ?>" title="<?php echo User::$Data['name']; ?>"/>
		</div>
			<div class="guestbook-actions">
					<img src="<?php echo RES; ?>images/myhabbo/buttons/delete_entry_button.gif" id="gbentry-delete-<?php echo $InsertId; ?>" class="gbentry-delete" style="cursor:pointer" alt=""/>
					<br/>
			</div>
		<div class="guestbook-message">
			<div class="<?php echo (User::IsOnline(User::$Data['id'])) ? 'on' : 'off'; ?>line">
				<a href="<?php echo URL; ?>/home/<?php echo User::$Data['name']; ?>"><?php echo User::$Data['name']; ?></a>
			</div>
			<p><?php echo Tool::DecodeBBText($_POST['message']); ?></p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>
		<div class="guestbook-entry-footer metadata"><?php echo date('d-M-o G:i:s');?></div>
	</li>