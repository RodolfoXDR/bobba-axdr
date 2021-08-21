<?php
const FastLoad = true;
if(isset($_POST['error_desc'], $_POST['error_cat'])):
	require '../KERNEL-XDRCMS/Init.php';

	$_SESSION['clientError'] = [
		'Info' => $_POST['error_desc'],
		'ID' => $_POST['error_cat'],
		'Token' => rand(10000000, 99999999)
	];
	
	if(isset($_SESSION['aDEBUG'][0]) && $_SESSION['aDEBUG'][0] === true)
		$_SESSION['aDEBUG'][1][] = ['DEBUG FINAL ERROR', $_POST['debug']];
endif;
header('Location: /client');
?>