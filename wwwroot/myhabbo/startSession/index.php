<?php
require '../../../KERNEL-XDRCMS/Init.php';

if(isset($_GET['Id']) && is_numeric($_GET['Id'])):
	if(User::$Data['id'] == $_GET['Id']):
		unset($_SESSION['Ajax']['Update']);
		unset($_SESSION['group_edit']);
		unset($_SESSION['group_edit_id']);

		$_SESSION['home_edit'] = true;
		header('Location: ' . URL . '/home/' . User::$Data['name']);
		exit;
	endif;
endif;

header('Location: ' . URL);
exit;
?>