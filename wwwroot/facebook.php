<?php
const APIsLoad = 'Facebook/autoload,Login,Register';
require '../KERNEL-XDRCMS/Init.php';
	
if (empty(Config::$FaceBook['app']['id']))
	exit;

$Url = '/';

Tool::SessionStart();
try
{
	$fb = new Facebook\Facebook(['app_id' => Config::$FaceBook['app']['id'], 'app_secret' => Config::$FaceBook['app']['privateID'], 'default_graph_version' => 'v2.8']);
	$response = $fb->get('/me?fields=id,name,email,gender,birthday', $_COOKIE['fbhb_val_' . Config::$FaceBook['app']['id']]);

	if ($response === null)
	{
		$_SESSION['login']['error'] = [Text::ERROR_DEFAULT];
		goto a;
	}

	$user_profile = $response->getGraphObject()->asArray();
}
catch (Exception $e)
{
	$_SESSION['login']['error'] = [Text::ERROR_DEFAULT];
	goto a;
}

if (!isset($user_profile['id']) || !is_numeric($user_profile['id']))
	goto a;

$email = isset($user_profile['email']) ? $user_profile['email'] : $user_profile['id'] . '@facebook.com';
$name = isset($user_profile['name']) ? $user_profile['name'] : '';
$BirthDay = isset($user_profile['birthday']) ? $user_profile['birthday'] : '';
Tool::ApplyEntities(Tool::HTMLEntities, $name);

$userRow = array();

if (User::Get(Server::Get(Server::USER_TABLE), Server::Get(Server::USER_ID_COLUMN), $userRow, 'facebook_id = \'' . $user_profile['id'] . '\''))
{
	SQL::query('REPLACE INTO xdr_users
		(id, mail, password, birth, rpx_id, rpx_type, web_online, AddonData, RememberMeToken, AccountID, AccountName, securityTokens, receptionPased)
	VALUES
		(' . $userRow['id'] . ', \'' . $email . '\', \'\', \'\', ' . Tool::Random(12, true, false) . ', \'' . LoginType::Facebook . '\', \'--\', \'\', \'\', ' . $user_profile['id'] . ', \'' . $name . '\', \'\', \'1\')');
		
	SQL::query('UPDATE xdr_users SET password = \'\', mail = \'\', facebook_id = 1 WHERE id = ' . $userRow['id']);
				
	Login::CreateSession($userRow, false, LoginType::Facebook);
	$Url = '/me';
}
else if (User::Get(Server::Get(Server::USER_TABLE) . ', xdr_users', 'xdr_users.id', $userRow, 'xdr_users.AccountID = \'' . $user_profile['id'] . '\'', 'xdr_users.rpx_type = \'' . LoginType::Facebook . '\'', 'xdr_users.id = ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN)))
{
	Login::CreateSession($userRow, false, LoginType::Facebook);
	/*
	if (isset($_GET["__app_key"]) && LOGGED != "null"):
		if ($Users->GetSecurity("__app_key") == $_GET["__app_key"]):
			SQL::multi_query("UPDATE xdr_users SET vinculId = '" . $_UserId . "' WHERE mail = '" . $myrow["mail"] . "' AND rpx_type = '" . $myrow["rpx_type"] . "';UPDATE xdr_users SET vinculId = '" . $myrow["id"] . "' WHERE mail = '" . $user_profile["email"] . "' AND rpx_type = 'facebookid'");
			$_SESSION["Identity"]["NewVinculArray"] = [$_UserId, $user_profile["email"]];
			header("Location: " . URL . "/identity/merge_identities");
			exit;
		endif;
	*/
	$Url = '/me';
}
else
{

	if(Site::$Settings['RegisterEnabled'] != 1 && !User::$Logged)
		Site::Redirect(Redirect::NOLOGGED);

	if (isset($user_profile['gender']) && $user_profile['gender'] === 'male')
	{
		$gender = 'M';
		$look = 'ch-210-1211.sh-300-63.lg-285-64.ha-1002-63.hr-828-1061.hd-180-1';
	}
	else
	{
		$gender = 'F';
		$look = 'hd-600-1.ch-813-1211.ha-1005-63.lg-720-64.hr-890-1061.sh-735-63';
	}
	
	Register::NewUser(Register::GenerateName($email), $email, '', LoginType::Facebook, $look, $gender, $user_profile['id'], $name);

	//if ($SiteSettings["initial.credits.int"] > 0)
	//	newTransaction($userId, $date_full, $SiteSettings["initial.credits.int"], $System->CorrectStr("�Bienvenido a " . $hotelName . "!"));

		/*
		if (isset($_GET["__app_key"]) && LOGGED != "null"):
			if ($Users->GetSecurity("__app_key") == $_GET["__app_key"]):
				SQL::multi_query("UPDATE xdr_users SET vinculId = '" . $userId . "' WHERE mail = '" . $myrow["mail"] . "' AND rpx_type = '" . $myrow["rpx_type"] . "';UPDATE xdr_users SET vinculId = '" . $myrow["id"] . "' WHERE mail = '" . $user_profile["email"] . "' AND rpx_type = 'facebookid'");
				$_SESSION["Identity"]["NewVinculArray"] = [$userId, $user_profile["email"]];
				header("Location: " . URL . "/identity/merge_identities");
				exit;
			endif;
		else:
		*/

	$Url = '/me';
}

a:

?>
<html>
<head>
  <title>Redirecting...</title>
  <meta http-equiv="content-type" content="text/html; charset=<?php echo strtolower(ini_get('default_charset')); ?>">
  <style type="text/css">body { background-color: #e3e3db; text-align: center; font: 11px Verdana, Arial, Helvetica, sans-serif; } a { color: #fc6204; }</style>
</head>
<body>

<script type="text/javascript">window.location.replace('<?php echo str_replace('/', '\/', URL . $Url); ?>');</script><noscript><meta http-equiv="Refresh" content="0;URL=<?php echo URL . $Url; ?>"></noscript>

<p class="btn">If you are not automatically redirected, please <a href="<?php echo URL . $Url; ?>" id="manual_redirect_link">click here</a></p>

</body>
</html>