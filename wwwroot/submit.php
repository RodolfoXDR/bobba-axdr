<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2016 Xdr.
|+=========================================================+
|| # Xdr 2016. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

const APIsLoad = 'Login';
require_once '../KERNEL-XDRCMS/Init.php';
Site::Redirect(Redirect::BLOCKED | Redirect::LOGGED);

$url = URL . '/?rememberme=' . (isset($_POST['_login_remember_me']) ? 'true' : 'false') . '&focus=login-username';
if(isset($_POST['credentials_username'], $_POST['credentials_password']))
	$url = Login::Check($_POST['credentials_username'], $_POST['credentials_password'], [isset($_POST['recaptcha_response_field']) ? $_POST['recaptcha_response_field'] : '', isset($_POST['recaptcha_challenge_field']) ? $_POST['recaptcha_challenge_field'] : ''], isset($_POST['_login_remember_me']), URL . '/me?connect=true&disableFriendLinking=false&next=');
?>
<html>
<head>
  <title>Redirecting...</title>
  <meta http-equiv="content-type" content="text/html; charset=<?php echo Site::Charset; ?>">
  <style type="text/css">body { background-color: #e3e3db; text-align: center; font: 11px Verdana, Arial, Helvetica, sans-serif; } a { color: #fc6204; }</style>
</head>
<body>

<script type="text/javascript">window.location.replace('<?php echo str_replace('/', '\/', $url); ?>');</script><noscript><meta http-equiv="Refresh" content="0;URL=<?php echo $url; ?>"></noscript>

<p class="btn">If you are not automatically redirected, please <a href="<?php echo $url; ?>" id="manual_redirect_link">click here</a></p>

</body>
</html>