<?php
class Register
{
	public static function Check($name, $mail, $password, $recaptcha, $terms, $policies) //userName, email, pWd, reCaptcha2, terms, policy
	{
		Tool::SessionStart();

		$_SESSION['register']['errors'] = [];

		$responseJson = ['registrationErrors' => ['empty_field_error_message' => 'Hey, you forgot to fill me!']];
		
		if (empty($name)):
			$responseJson['registrationErrors']['registration_username'] = Text::Get(Text::REGISTER_NAME_EMPTY);
		elseif (strlen($name) < 3):
			$responseJson['registrationErrors']['registration_username'] = Text::Get(Text::REGISTER_NAME_TOO_SHORT);
		elseif (strlen($name) > 15):
			$responseJson['registrationErrors']['registration_username'] = Text::Get(Text::REGISTER_NAME_TOO_LONG);
		elseif (strpos($name, ' ') || strpos($name, 'MOD-') !== false || !self::ValidName($name)):
			$responseJson['registrationErrors']['registration_username'] = Text::Get(Text::REGISTER_NAME_NOTVALID);
		endif;
		
		if (empty($password)):
			$responseJson['registrationErrors']['registration_password'] = Text::Get(Text::REGISTER_PWD_EMPTY);
		elseif (strlen($password) < 6):
			$responseJson['registrationErrors']['registration_password'] = Text::Get(Text::REGISTER_PWD_TOO_SHORT);
		elseif (strlen($password) > 32):
			$responseJson['registrationErrors']['registration_password'] = Text::Get(Text::REGISTER_PWD_TOO_LONG);
		elseif (!preg_match('`[0-9]`', $password)):
			$responseJson['registrationErrors']['registration_password'] = Text::Get(Text::REGISTER_PWD_NOT_NUM);
		endif;

		if(!isset($_POST['reg_termsOfService']) || $_POST['reg_termsOfService'] !== 'true'):
			$responseJson['registrationErrors']['registration_termsofservice'] = Text::Get(Text::REGISTER_TOS);
		endif;

		if(!isset($_POST['reg_cookiePolicy']) || $_POST['reg_cookiePolicy'] !== 'true'):
			$responseJson['registrationErrors']['registration_cookiepolicy'] = Text::Get(Text::REGISTER_COOKIES);
		endif;

		$mail = str_replace('%40', '@', strtolower($mail));
		
		if(empty($mail) || strlen($mail) > 50 || !filter_var($mail, FILTER_VALIDATE_EMAIL)):
			$responseJson['registrationErrors']['registration_email'] = Text::Get(Text::REGISTER_EMAIL_NOTVALID);
		endif;

		if($responseJson['registrationErrors'] != ['empty_field_error_message' => 'Hey, you forgot to fill me!']):
			echo json_encode($responseJson);
			exit;
		endif;

		if (!Tool::CheckCaptcha($recaptcha))
			$responseJson['registrationErrors']['registration_captcha'] = Text::Get(Text::CAPTCHA_ERROR);
		
		if (User::MailExists($mail))
			$responseJson['registrationErrors']['registration_email'] = Text::Get(Text::REGISTER_EMAIL_REGISTERED);

		if (self::NameExists($name))
			$responseJson['registrationErrors']['registration_username'] = Text::Get(Text::REGISTER_NAME_REGISTERED);

		if($responseJson['registrationErrors'] != ['empty_field_error_message' => 'Hey, you forgot to fill me!']):
			echo json_encode($responseJson);
			exit;
		endif;
		
		return self::NewUser($name, $mail, $password, LoginType::Normal);
	}
	
	public static function CanRegister()
	{
		$rSettings = Cache::GetAIOConfig('Register');

		$responseJson = ['registrationErrors' => ['empty_field_error_message' => 'Hey, you forgot to fill me!']];

		if (!$rSettings['register_enabled'])
		{
			return false;
		}

		$IpC = SQL::query('SELECT COUNT(*) FROM ' . Server::Get(Server::USER_TABLE) . ' WHERE ' . SERVER::Get(Server::USER_IP_LAST_COLUMN) . ' = \'' . IP . '\'')->fetch_assoc()['COUNT(*)'];
		if ($rSettings['limitips'] != 0 && $IpC >= $rSettings['limitips'])
		{
			return false;
		}

		return true;
	}
	
	public static function NewUser($u, $e, $p, $t, $l = 'ch-210-1322.hd-180-1.hr-100-40.sh-300-1408.lg-285-76', $g = 'M', $fId = 0, $fName = '', $m = '¡Nuev@ en '. HotelName .'!') //user, email, pWd, type, look, gender, facebookId, facebookName
	{
		$rSettings = Cache::GetAIOConfig('Register');

		if(!self::CanRegister())
			return false;

		$q = SQL::query('INSERT INTO ' . Server::Get(Server::USER_TABLE) . ' (username, rank, credits, account_created, '. SERVER::Get(Server::USER_IP_LAST_COLUMN) .', '. SERVER::Get(Server::USER_LOOK_COLUMN) .', gender, motto, home_room) 
					 VALUES (\'' . $u . '\', 1, ' . Site::$Settings['initial.credits.int'] . ', ' . time() . ', \'' . IP . '\', \'' . $l . '\', \'' . $g . '\', \'' . $m . '\', ' . HomeRoomId . ')');

		if ($q == null || SQL::$affected_rows !== 1)
		{
			array_push($_SESSION['register']['errors'], Text::REGISTER_MYSQL_ERROR);
			return false;
		}
		
		$userId = SQL::$insert_id;
		SQL::query('REPLACE INTO xdr_users
		(id, mail, password, birth, rpx_id, rpx_type, web_online, AddonData, RememberMeToken, AccountID, AccountName, securityTokens)
			VALUES
		(' . $userId . ', \'' . $e . '\', \'' . (empty($p) ? '' : Tool::Hash($p)) . '\', \'\', ' . Tool::Random(12, true, false) . ', \'' . $t . '\', \'--\', \'\', \'\', ' . $fId . ', \'' . $fName . '\', \'\')');
		
		//SQL::query('REPLACE INTO users_subscriptions VALUES (' . $userId . ', 2, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(now() + INTERVAL 2 MONTH), UNIX_TIMESTAMP())');
		//if (isset($_SESSION['Register']['RefId']) && is_numeric($_SESSION['Register']['RefId']) && $IpC == 0)
		//	User::NewRefer($userId, $_SESSION['Register']['RefId']);
		
		Item::Place($userId, 0, '180', '366', '11', '', 's_paper_clip_1', '', 'sticker');
		Item::Place($userId, 0, '130', '22', '10', '', 's_needle_3', '', 'sticker');
		Item::Place($userId, 0, '280', '343', '3', '', 's_sticker_spaceduck', '', 'sticker');
		Item::Place($userId, 0, '593', '11', '9', '', 's_sticker_arrow_down', '', 'sticker');
		
		Item::Place($userId, 0, '107', '402', '8', '', 'n_skin_notepadskin', 'note.myfriends', 'stickie');
		Item::Place($userId, 0, '57', '229', '6', '', 'n_skin_speechbubbleskin', 'note.welcome', 'stickie');
		Item::Place($userId, 0, '148', '41', '7', '', 'n_skin_noteitskin', 'note.remember.security', 'stickie');
		
		Item::Place($userId, 0, '457', '26', '4', 'ProfileWidget', 'w_skin_defaultskin', '', 'widget');
		Item::Place($userId, 0, '450', '319', '1', 'RoomsWidget', 'w_skin_notepadskin', '', 'widget');


		echo '{"registrationCompletionRedirectUrl":"' . str_replace('/', '\\/', URL . '/' . $rSettings['redirection']) . '"}';

		unset ($_SESSION['register']);
		Login::CreateSession(['id' => $userId], false, $t);
		
		$lasts = Cache::GetAIOConfig('LastRegisters');
		if (empty($lasts))
			$lasts[0] = [$u, $g, $l, $m, time()];
		else
			array_unshift($lasts, [$u, $g, $l, $m, time()]);
		if (count($lasts) == 6)
			array_pop($lasts);
		Cache::SetAIOConfig('LastRegisters', $lasts);
		
		exit;
		return true;
	}
	
	public static function UpdateInfoFromReception($n, $g, $l) // name, gender, look
	{
		SQL::multi_query ("UPDATE " . Server::Get(Server::USER_TABLE) . ", xdr_users SET
		" . Server::Get(Server::USER_TABLE) . "." . Server::Get(Server::USER_NAME_COLUMN) . " = '" . $n . "', " . Server::Get(Server::USER_TABLE) . "." . Server::Get(Server::USER_GENDER_COLUMN) . " = '" . $g . "', " . Server::Get(Server::USER_TABLE) . "." . Server::Get(Server::USER_LOOK_COLUMN) . " = '" . $l . "', xdr_users.ReceptionPased = '1'
						WHERE " . Server::Get(Server::USER_TABLE) . "." . Server::Get(Server::USER_ID_COLUMN) . " = '" . User::$Data['id'] . "' AND xdr_users.id = " . Server::Get(Server::USER_TABLE) . "." . Server::Get(Server::USER_ID_COLUMN) . ";
						UPDATE rooms SET owner = '" . $n . "' WHERE owner = '" . User::$Data['name'] . "'");
	}

	public static function ValidName($n)
	{
		return preg_match('/^[-_=?!@:.,[:alnum:]]+$/', $n);
	}

	public static function NameExists($n)
	{
		return User::Get(Server::Get(Server::USER_TABLE), 'null', $r, 'username = \'' . $n . '\'');
	}

	public static function GenerateName($e, $t = 0)
	{
		$e = $E = substr(strstr($e, '@') ? explode('@', $e)[0] : $e, 0, 18);
		$c = ['.', '-', '_'];

		if (strlen($e) > 6)
			foreach ($c as $C)
			{
				if (strstr($e, $C) === FALSE) continue;
				$n = rand(0, 1);
				$e = explode($C, $e);
				$e = strlen($e[$n]) < 3 ? ($e[($n === 1) ? 0 : 1]) : $e[$n];
				break;
			}
		
		$r = self::NameExists($e);

		if ($r === null)	return null;
		if ($r === false)	return $e;
		
		$c = strlen($e);
		$r = ($c > 10) ? (rand(rand(1, 2 + $t), rand(2, 3 + $t))) : (($c > 8) ? (rand(rand(2, 2 + $t), rand(3, 3 + $t))) : (rand(rand(3, 4 + $t), rand(3, 4 + $t))));

		$e .= Tool::Random($r, true, false, '-_=?!@:.,');
		$r = self::NameExists($e);
		
		if ($r === null)	return null;
		if ($r === false)	return $e;

		self::GenerateName($E, $t++);
	}	
}
?>