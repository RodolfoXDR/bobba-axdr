<?php

define('Start', microtime(true)); 
ini_set('session.name', 'aXDR-RTM:1');

const STYLE_OTHER = 'Jollyness';

require '../../KERNEL-XDRCMS/Init.php';

if(Site::$Settings['RegisterEnabled'] != 1 && !User::$Logged):
	Site::Redirect(Redirect::NOLOGGED);
else:
	Site::Redirect(Redirect::BLOCKED | Redirect::LOGGED);
	Site::SetOnline();

	$_SESSION['Registration']['Started'] = true;

	Site::$PageName = Title::Register[0];
	Site::$PageColor = Title::Register[1];

	Site::$PageId = '';

	require HEADER . 'Login.php';
	require HTML . 'Register_index.html';
	require FOOTER . 'Login.php';

	echo '<!-- Loaded in '.(microtime(true) - Start).' seconds -->';
endif;
?>