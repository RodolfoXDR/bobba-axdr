<?php
class User
{
	public static $Logged = false;

	public static $Data = [
		'id' => 0, 
		'name' => '', 
		'mail' => '', 
		'rank' => 0, 
		'motto' => '', 
		'figure' => '', 
		'gender' => 'F', 
		'credits' => 0,
		'diamonds' => 0, 
		'icon' => 
		'icon_habbo_small'
	];
	public static $Row = [];
	public static $IsFB = false;

	
	public static function Get($t = 'users', $d = 'null', &$e = '', ...$p)
	{
		$q = SQL::query('SELECT ' . $d . ' FROM ' . $t . ' WHERE ' . implode(' AND ', $p) . ' LIMIT 1');
		if (!$q || $q->num_rows === 0)
			return false;

		if ($d != 'null')
			$e = $q->fetch_assoc();
		return true;
	}
	
	public static function GetNameById($i)
	{
		if (!self::Get(Server::Get(Server::USER_TABLE), Server::Get(Server::USER_NAME_COLUMN), $r, Server::Get(Server::USER_ID_COLUMN) . ' = ' . $i))
			return null;
		
		return $r[Server::Get(Server::USER_NAME_COLUMN)];
	}
	
	public static function GetIdByName($u)
	{
		if (!self::Get(Server::Get(Server::USER_TABLE), Server::Get(Server::USER_ID_COLUMN), $r, 'username = \'' . $u . '\''))
			return null;
		
		return $r[Server::Get(Server::USER_ID_COLUMN)];
	}
	
	public static function MailExists($e)
	{
		return self::Get('xdr_users', 'null', $r, 'mail = \'' . $e . '\'');
	}
	
	public static function hasPermission($p, $R = 0)
	{
		$R = $R === 0 ? self::$Data['rank'] : $R;
		return ($R < MinRank || !isset(Site::$Ranks[$R]['Permissions'][$p])) ? false : (Site::$Ranks[$R]['Permissions'][$p] == 1);
	}
	
	public static function IsOnline($u = 0)
	{
		$i = $u === 0 ? self::$Data['id'] : $u;
		self::Get(Server::Get(Server::USER_TABLE), 'online', $r, Server::Get(Server::USER_ID_COLUMN) . ' = ' . $i);
		
		return ($r['online'] == 1) ? true : false ;
	}
	
	public static function GetFriendsOnline($u = 0){
		$i = $u === 0 ? self::$Data['id'] : $u;
		
		$friends = array();
		$onlines = array();
		$fonlines = false;
		
		$friends1 = SQL::query('SELECT `user_two_id` FROM `messenger_friendships` WHERE `user_one_id` = ' . $i);
		$friends2 = SQL::query('SELECT `user_one_id` FROM `messenger_friendships` WHERE `user_two_id` = ' . $i);
		
		if($friends1 != null && $friends1->num_rows != 0):
			while($uRow1 = $friends1->fetch_assoc())
				array_push($friends, $uRow1['user_two_id']);
		endif;
		
		if($friends2 != null && $friends2->num_rows != 0):
			while($uRow2 = $friends2->fetch_assoc())
				array_push($friends, $uRow2['user_one_id']);
		endif;
		
		foreach($friends as $key => $id):
			if(self::IsOnline($id))
				array_push($onlines, $id);
		endforeach;
		
		return $onlines;
	}
	
	public static function GenerateAuthToken($i = 0)
	{
		$t = Tool::Random(8) . '-' . Tool::Random(4) . '-' . Tool::Random(4) . '-' . Tool::Random(4) . '-' . Tool::Random(12) . '-AX3';
		
		/*if ($i !== 0){
			SQL::query('DELETE FROM user_auth_ticket WHERE user_id = ' . $i);
			SQL::query("INSERT INTO user_auth_ticket (user_id, auth_ticket) VALUES('" . $i . "','" . $t . "') ");
		}*/

		//AZURE EMULATOR
		/*SQL::query('UPDATE users SET auth_ticket = \'' . $t . '\' WHERE id = ' . $i);*/

		//PLUS EMULATOR
		//SQL::query('UPDATE user_auth_ticket SET auth_ticket = \'' . $t . '\' WHERE user_id = ' . $i);
		
		//RAVEN EMULATOR
		SQL::query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET auth_ticket = \'' . $t . '\' WHERE id = ' . $i);

		return $t;
	}
	
	//AZURE EMULATOR
	/*public static function IsBanned($u, $i, &$o = null)
	{
		$q = SQL::query('SELECT id, reason, expire, bantype FROM users_bans WHERE ((value = \'' . $u . '\' AND bantype = \'user\') OR (value = \'' . $i . '\' AND bantype = \'ip\')) LIMIT 1');

		if (!$q || $q->num_rows !== 1)
			return false;

		$o = $q->fetch_assoc();
		
		if ($o['expire'] - time() > 0)
			return true;
		
		SQL::query('DELETE FROM users_bans WHERE id = ' . $o['id']);
		
		return false;
	}*/
	

	//PLUS EMULATOR
	public static function IsBanned($u, $i, &$o = null)
	{
		$q = SQL::query('SELECT ' . Server::Get(Server::BANS_ID_COLUMN) . ', ' . Server::Get(Server::BANS_TYPE_COLUMN) . ', ' . Server::Get(Server::BANS_REASON_COLUMN) . ', ' . Server::Get(Server::BANS_EXPIRE_DATE_COLUMN) . ' FROM ' . Server::Get(Server::BANS_TABLE) . ' WHERE ((' . Server::Get(Server::BANS_VALUE_COLUMN) . ' = ' . self::GetIdByName($u) . ') OR (' . Server::Get(Server::BANS_VALUE_COLUMN) . ' = \'' . $u . '\') OR (' . Server::Get(Server::BANS_VALUE_COLUMN) . ' = \'' . $i . '\')) LIMIT 1');

		if (!$q || $q->num_rows !== 1)
			return false;

		$o = $q->fetch_assoc();
		
		if ($o[Server::Get(Server::BANS_EXPIRE_DATE_COLUMN)] - time() > 0)
			return true;
		
		SQL::query('DELETE FROM ' . Server::Get(Server::BANS_TABLE) . ' WHERE ' . Server::Get(Server::BANS_ID_COLUMN) . ' = ' . $o[Server::Get(Server::BANS_ID_COLUMN)]);
		return false;
	}

	public static function Logout($t, $r) // token, reason
	{
		if (self::$Logged && $t == self::$Row['token'])
		{
			setcookie('rememberme_token', '', time() - 3600, '/'); setcookie('rememberme', '', time() - 3600, '/');

			SQL::multi_query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET online = \'0\' WHERE ' . Server::Get(Server::USER_ID_COLUMN) . ' = ' . self::$Data['id'] . ' LIMIT 1;
						UPDATE xdr_users SET RememberMeToken = \'\', web_online = ' . time() . ' WHERE id = \'' . self::$Data['id'] . '\' LIMIT 1');
			session_destroy();
		}
		else if (empty($r))
			$r = 'error';

		//exit(header('Location: ' . URL . '/account/logout_ok?' . (!empty($r) ? 'reason=' . $r . '&' : '' ) . 'token=' . $t));
		exit(header('Location: ' . URL . '/?' . (!empty($r) ? 'reason=' . $r . '&' : '' ) . 'token=' . $t));
	}

	public static function Check()
	{
		if (FastLoad)
			self::CheckFast();
		else self::CheckNormal();
	}

	static function GetUserData($i)
	{
		$q = SQL::query('SELECT 
						' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_NAME_COLUMN) . ', 
						' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_RANK_COLUMN) . ', 
						' . Server::Get(Server::USER_TABLE) . '.online, 
						' . Server::Get(Server::USER_TABLE) . '.account_created, 
						' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_LOOK_COLUMN) . ', 
						' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_GENDER_COLUMN) . ', 
						' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_MOTTO_COLUMN) . ', 
						' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_CREDITS_COLUMN) . ',
						' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_DIAMONDS_COLUMN) . ',
						xdr_users.* 
					FROM ' . Server::Get(Server::USER_TABLE) . ', xdr_users
					WHERE ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . ' = ' . $i . ' AND xdr_users.id = ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . '
					LIMIT 1');
		if (!$q || $q->num_rows !== 1)
			return null;

		$row = $q->fetch_assoc();

		$Data = [
			'id' => $row[Server::Get(Server::USER_ID_COLUMN)],
			'name' => $row[Server::Get(Server::USER_NAME_COLUMN)], 
			'mail' => $row['mail'], 
			'rank' => $row[Server::Get(Server::USER_RANK_COLUMN)], 
			'motto' => $row[Server::Get(Server::USER_MOTTO_COLUMN)], 
			'figure' => $row[Server::Get(Server::USER_LOOK_COLUMN)], 
			'ip' => $row['ip_current'], 
			'gender' => $row[Server::Get(Server::USER_GENDER_COLUMN)], 
			'credits' => $row[Server::Get(Server::USER_CREDITS_COLUMN)], 
			'diamonds' => $row[Server::Get(Server::USER_DIAMONDS_COLUMN)], 
			'icon' => (self::$IsFB ? 'icon_facebook_connect_small' : 'icon_habbo_small')
		];

		unset($row[Server::Get(Server::USER_ID_COLUMN)], $row[Server::Get(Server::USER_NAME_COLUMN)], $row['mail'], $row[Server::Get(Server::USER_RANK_COLUMN)], $row[Server::Get(Server::USER_MOTTO_COLUMN)], $row[Server::Get(Server::USER_LOOK_COLUMN)], $row[Server::Get(Server::USER_GENDER_COLUMN)], $row[Server::Get(Server::USER_CREDITS_COLUMN)], $row[Server::Get(Server::USER_DIAMONDS_COLUMN)]);
	
		return array_merge($Data, $row);
	}
	
	static function CheckNormal()
	{
		if (!isset($_SESSION['user']['id'], $_SESSION['user']['sessionId']))
		{
			if (isset($_COOKIE['rememberme'], $_COOKIE['rememberme_token']))
				self::CheckCookies();

			return;
		}

		$q = SQL::query('SELECT 
							' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_NAME_COLUMN) . ', 
							' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_RANK_COLUMN) . ', 
							' . Server::Get(Server::USER_TABLE) . '.online, 
							' . Server::Get(Server::USER_TABLE) . '.account_created, 
							' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_LOOK_COLUMN) . ', 
							' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_GENDER_COLUMN) . ', 
							' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_MOTTO_COLUMN) . ', 
							' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_CREDITS_COLUMN) . ',
							' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_DIAMONDS_COLUMN) . ',
							' . Server::Get(Server::USER_TABLE) . '.block_newfriends,
							' . Server::Get(Server::USER_TABLE) . '.hide_online,
							xdr_users.* 
						FROM ' . Server::Get(Server::USER_TABLE) . ', xdr_users
						WHERE ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . ' = ' . $_SESSION['user']['id'] . ' AND xdr_users.token = \'' . $_SESSION['user']['sessionId'] . '\' AND xdr_users.predermited = \'1\' AND xdr_users.rpx_type = \'' . $_SESSION['user']['loginType'] . '\' AND xdr_users.id = ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . '
						LIMIT 1');

		if (!$q || $q->num_rows !== 1)
		{
			unset($_SESSION['user']);
			setcookie('rememberme_token', '', time() - 3600, '/'); setcookie('rememberme', '', time() - 3600, '/');
			
			$_SESSION['login']['error'] = [Text::ERROR_DEFAULT];


			header('Location: ' . URL); exit;
		}

		$row = $q->fetch_assoc();

		self::CheckInactivity($row['token']);
		$_SESSION['user']['lastUsed'] = time();

		if (self::IsBanned($row[Server::Get(Server::USER_NAME_COLUMN)], IP, $banData))
		{
			unset($_SESSION['user']);
			setcookie('rememberme_token', '', time() - 3600, '/'); setcookie('rememberme', '', time() - 3600, '/');

			$_SESSION['login']['error'] = [Text::BANNED, $banData['reason'], date('d/m/Y H:i:s', $banData['expire'])];
			header('Location: ' . URL); exit;
		}
		
		self::$Logged = true;
		self::$IsFB = $_SESSION['user']['loginType'] === LoginType::Facebook;
		self::$Data = [
			'id' => $row[Server::Get(Server::USER_ID_COLUMN)], 
			'name' => $row[Server::Get(Server::USER_NAME_COLUMN)], 
			'mail' => $row['mail'], 
			'rank' => $row[Server::Get(Server::USER_RANK_COLUMN)], 
			'motto' => $row[Server::Get(Server::USER_MOTTO_COLUMN)], 
			'figure' => $row[Server::Get(Server::USER_LOOK_COLUMN)], 
			'ip' => $row['ip_current'], 
			'gender' => $row[Server::Get(Server::USER_GENDER_COLUMN)], 
			'credits' => $row[Server::Get(Server::USER_CREDITS_COLUMN)], 
			'diamonds' => $row[Server::Get(Server::USER_DIAMONDS_COLUMN)],
			'block_newfriends' => $row['block_newfriends'],
			'hide_online' => $row['hide_online'],
			'icon' => (self::$IsFB ? 'icon_facebook_connect_small' : 'icon_habbo_small')];
		
		unset(
			$row[Server::Get(Server::USER_ID_COLUMN)], 
			$row[Server::Get(Server::USER_NAME_COLUMN)], 
			$row['mail'], $row[Server::Get(Server::USER_RANK_COLUMN)], 
			$row[Server::Get(Server::USER_MOTTO_COLUMN)], 
			$row[Server::Get(Server::USER_LOOK_COLUMN)], 
			$row[Server::Get(Server::USER_GENDER_COLUMN)], 
			$row['credits']
		);

		self::$Row = $row;
	}
	
	static function CheckFast()
	{
		if (!isset($_SESSION['user']['id'], $_SESSION['user']['sessionId']))
		{
			if (isset($_COOKIE['rememberme'], $_COOKIE['rememberme_token']))
				self::CheckCookies();

			return;
		}
		
		self::$Logged = true;
	}
	
	static function CheckCookies()
	{
		if (!strlen($_COOKIE['rememberme_token']) === 128 || $_COOKIE['rememberme'] != 'true')
		{
			setcookie('rememberme_token', '', time() - 3600, '/'); setcookie('rememberme', '', time() - 3600, '/');
			return;
		}
		
		if (FastLoad)
			exit(header('Location: ' . URL . '/security_check_token?returnTo=/'));

		Tool::ApplyEntities(Tool::HTMLEntities, $_COOKIE['rememberme_token']);
		$q = SQL::query('SELECT ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . ', xdr_users.mail, xdr_users.password FROM ' . Server::Get(Server::USER_TABLE) . ', xdr_users WHERE xdr_users.RememberMeToken = \'' . $_COOKIE['rememberme_token'] . '\' AND xdr_users.ip_current = \'' . IP . '\' AND xdr_users.id = ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . '');
		if (!$q || $q->num_rows === 0)
		{
			setcookie('rememberme_token', '', time() - 3600, '/'); setcookie('rememberme', '', time() - 3600, '/');
			return;
		}
		
		$row = $q->fetch_assoc();
		
		require_once KERNEL . 'APIs' . DS . 'Login.php';
		
		Tool::SessionStart();
		Login::CreateSession($row, true, LoginType::Normal);
	}
	
	static function CheckInactivity($t)
	{
		if (defined('NoReload'))
			return;
		if (Site::$Settings['reload.time'] < 1500)
			return;
		if ((time() - $_SESSION['user']['lastUsed']) < Site::$Settings['reload.time'])
			return;
		
		if (isset($_COOKIE['rememberme'], $_COOKIE['rememberme_token']))
			self::_CHECKCOOKIE();

		exit(header('Location: ' . URL . '/account/logout?token=' . $t . '&reason=expired'));
	}

	static function HaveWidget($i, $v) {
		$q = SQL::query('SELECT null FROM xdrcms_site_items WHERE var = \'' . $v . '\' AND (userId = \'' . $i . '\') LIMIT 1'); //  OR groupId = '" . $Id . "'
		return ($q && $q->num_rows === 1);
	}

	static function GiveReward($i, $r) {

		$Rewards = Cache::GetAIOConfig("WEB.DailyRewards");

		$v = 0;
		$t = 'credits';

		foreach($Rewards as $reward): 
			if($reward['order'] == $r):
				$v = $reward['value'];
				$t = $reward['type'];
			endif;
		endforeach;

		switch($t)
		{
			case 'credits':
				SQL::query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET credits = credits + ' . $v . ' WHERE id = ' . $i);
			break;
			case 'diamonds':
				SQL::query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET vip_points = vip_points + ' . $v . ' WHERE id = ' . $i);
			break;
			case 'furni':
				SQL::query('INSERT INTO `items_rooms` (`user_id`, `base_item`) VALUES (\'' . $i . '\', \'' . $v . '\')');
			break;
		}
	}

	static function hasBadge($i, $b) {
		$q = SQL::query('SELECT user_id FROM users_badges WHERE badge_id = \'' . $b . '\' AND user_id = ' . $i);

		return ($q && $q->num_rows >= 1);
	}
}

class LoginType
{
	const Normal = 0;
	const Facebook = 1;
	const RPX = 2;
}
?>