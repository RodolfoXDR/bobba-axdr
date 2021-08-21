<?php

class Login
{
	public static function OldHash($p)
	{
		//$p = html_entity_decode($p);
		$p = stripslashes(htmlspecialchars($p));
		$p = trim($p);
		$p = str_replace('habblum', 'hartico', $p);

		return sha1($p . "xCg532%@%gdvf^5DGaa6&*rFTfg^FD4\$OIFThrR_gh(ugf*/");
	}
	public static function Check($m, $p, $r2, $r, $re) // mail, passWord, captcha (array), remember (bool)
	{
		Tool::SessionStart();
		unset($_SESSION['login']['error']);

		$eId = [0];
		$f = 'login-username';

		$m = strtolower($m);
		$pH = Tool::Hash($p);
		
		if(isset($_SESSION['login']['tries']) && $_SESSION['login']['tries'] >= 4 && !Tool::CheckCaptcha($r2))
			$eId = [Text::LOGIN_CAPTCHA];

		if ($eId[0] != 0)
		{
			self::SumTry($eId);
			return URL . '/?username=' . $m . '&rememberme=' . ($r ? 'true' : 'false') . '&focus=' . $f . '';
		}

		if (empty($m) && empty($p))
			$eId = [Text::LOGIN_EMPTY_BOTH];
		else if (empty($m))
			$eId = [Text::LOGIN_EMPTY_NAME];
		else if (empty($p))
		{
			$eId = [Text::LOGIN_EMPTY_PASSWORD];
			$f = 'login-password';
		}
		
		if (!Tool::IsMail($m))
		{
			if (!User::Get(Server::Get(Server::USER_TABLE) . ', xdr_users', Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN), $row, Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_NAME_COLUMN) . ' = \'' . $m . '\'', 'xdr_users.password = \'' . $pH . '\'', 'xdr_users.rpx_type = \'' . LoginType::Normal . '\'', 'xdr_users.id = ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN)))
			{
				$eId = [Text::LOGIN_ERROR];
				$f = 'login-password';
			}
		}
		else if (!Tool::IsMail($m) || !User::Get(Server::Get(Server::USER_TABLE) . ', xdr_users', Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN) . ', ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_NAME_COLUMN), $row, 'xdr_users.mail = \'' . $m . '\'', 'xdr_users.password = \'' . $pH . '\'', 'xdr_users.rpx_type = \'' . LoginType::Normal . '\'', 'xdr_users.id = ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_ID_COLUMN)))
		{	
			$eId = [Text::LOGIN_ERROR];
			$f = 'login-password';
		}
		
		if ($eId[0] != 0)
		{
			self::SumTry($eId);
			return URL . '/?username=' . $m . '&rememberme=' . ($r ? 'true' : 'false') . '&focus=' . $f . '';
		}
		
		unset ($_SESSION['login']['tries']);

		self::CreateSession($row, $r);
		return $re;
	}
	
	public static function CreateSession($r, $re, $t = LoginType::Normal, ...$o)
	{
		$c = '';
		if($re)
		{
			$c = strtolower(Tool::Random(128));
			setcookie('rememberme', 'true', time() + (3600*24*14), '/');
			setcookie('rememberme_token', $c, time() + (3600*24*14), '/');
		}

		$_SESSION['user'] = [
			'id' => $r['id'],
			'sessionId' => Tool::Random(10),
			'connected' => time(),
			'lastUsed' => time(),
			'loginType' => $t,
			'clientToken' => Tool::Random(40)
		];
		
		require_once KERNEL . 'APIs' . DS . 'Identifier.php';
		
		SQL::query('UPDATE xdr_users SET token = \'' . $_SESSION['user']['sessionId'] . '\', country_cf = \'' . getCountryFromIP(IP) . '\', web_online = ' . time() . ', ip_current = \'' . IP . '\', RememberMeToken = \'' . $c . '\' ' . (!empty($o) ? ', ' . implode(', ', $o) : '') . ' WHERE id = ' . $r['id']);
	}
	
	static function SumTry($e)
	{
		if(isset($_SESSION['login']['tries']))
			$_SESSION['login']['tries']++;
		else
			$_SESSION['login']['tries'] = 1;
		$_SESSION['login']['error'] = $e;
	}
}
?>