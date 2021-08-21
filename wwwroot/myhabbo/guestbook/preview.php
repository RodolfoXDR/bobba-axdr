<?php
if(!isset($_POST['ownerId'], $_POST['message'], $_POST['widgetId']) || !is_numeric($_POST['ownerId']) || !is_numeric($_POST['widgetId']))	exit;
require '../../../KERNEL-XDRCMS/Init.php';

if(User::$Data['id'] !== $_POST['ownerId'])	exit;
?>
<ul class="guestbook-entries">
	<li id="guestbook-entry--1" class="guestbook-entry">
		<div class="guestbook-author">
                <img src="<?php echo LOOK . User::$Data['figure']; ?>&direction=4&head_direction=4&gesture=sml&action=&size=s" alt="<?php echo User::$Data['name']; ?>" title="<?php echo User::$Data['name']; ?>"/>
		</div>
		<div class="guestbook-message">
			<div class="offline">
				<a href="<?php echo URL; ?>/home/<?php echo User::$Data['name']; ?>"><?php echo User::$Data['name']; ?></a>
			</div>
			<p><?php echo Tool::DecodeBBText($_POST['message']); ?></p>
		</div>
		<div class="guestbook-cleaner">&nbsp;</div>
		<div class="guestbook-entry-footer metadata"><?php echo date('d-M-o G:i:s');?></div>
	</li>
</ul>

<div class="guestbook-toolbar clearfix">
<a href="#" class="new-button" id="guestbook-form-continue"><b>Continuar editando</b><i></i></a>
<a href="#" class="new-button" id="guestbook-form-post"><b>Añadir mensaje</b><i></i></a>	
</div>