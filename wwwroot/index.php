<?php
//header('Location: XDRTEST.php'); exit;
define('Start', microtime(true)); 

if(isset($_GET['username']))
	exit(header ('Location: /'));

const FastLoad = true;

//const STYLE_OTHER = 'Hekos';

require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED | Redirect::LOGGED);
Site::SetOnline();

Site::$PageName = Title::Login[0];
Site::$PageColor = Title::Login[1];

if(isset($_GET['refId']) && is_numeric($_GET['refId']))
	$_SESSION['register']['refId'] = $_GET['refId'];

require HEADER . 'Login.php';
require HTML . 'Login_index.html';
require FOOTER . 'Login.php';


echo '<!-- Loaded in '.(microtime(true) - Start).' seconds -->'; 
?>