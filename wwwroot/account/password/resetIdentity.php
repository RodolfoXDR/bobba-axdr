<?php
$no_id = true;

const STYLE_OTHER = 'Habbo';
require '../../../KERNEL-XDRCMS/Init.php';
Site::$BodyId = 'process-template black secure-page';

require HEADER . 'password.php';

if(isset($_POST['token']) || isset($_GET['Code'])):
	$_POST['token'] = (isset($_GET['Code'])) ? $_GET['Code'] : $_POST['token'];
	$token = md5($_POST['token']);
	
	$q = SQL::query('SELECT * FROM xdrcms_users_keys WHERE Code = \'' . $token . '\' AND Type = \'Recuper\' LIMIT 1');

	if(!$q || $q->num_rows === 0):
		require HTML . 'Error_Password.html';
		goto a;
	endif;
	
	$r = $q->fetch_assoc();
	
	if((time() - $r['Time']) > 86400):
		SQL::query('DELETE FROM xdrcms_users_keys WHERE Code = \'' . $token . '\' LIMIT 1');

		require HTML . 'Error_PasswordExpired.html';
		goto a;
	endif;

	if(isset($_POST['password'], $_POST['retypedPassword'])):
		if(empty($_POST['password'])):
			$e = 'Please enter a password';
		elseif(strlen($_POST['password']) < 6):
			$e = 'Your password needs be at least 6 characters long';
		elseif(strlen($_POST['password']) > 32):
			$e = 'Your password is too long';
		elseif(!preg_match('`[0-9]`', $_POST['password'])):
			$e = 'Your password must also include numbers';
		elseif($_POST['password'] !== $_POST['retypedPassword']):
			$e = 'The passwords do not match';
		else:
			SQL::query('UPDATE xdr_users SET password = \'' . Tool::Hash($_POST['password']) . '\' WHERE mail = \'' . $r["UserEmail"] . '\'');
			SQL::query('DELETE FROM xdrcms_users_keys WHERE Code = \'' . $token . '\' LIMIT 1');
			//echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=' . URL . '/account/password/resetConfirmation">';
			echo 'UPDATE xdr_users SET password = \'' . Tool::Hash($_POST['password']) . '\' WHERE mail = \'' . $r['UserEmail'] . '\'';
			exit();
		endif;
	endif;

	require HTML . 'Community_ResetPassword.html';
else:
	require HTML . 'Error_Password.html';
endif;

a:
require FOOTER . 'community.php';
?>