<?php
class Text
{
	const LOGIN_CAPTCHA = 1;
	const LOGIN_EMPTY_BOTH = 2;
	const LOGIN_EMPTY_NAME = 3;
	const LOGIN_EMPTY_PASSWORD = 4;
	const LOGIN_ERROR = 5;
	const BANNED = 6;
	const LOGOUT = 7;
	const LOGOUT_ERROR = 8;
	const SESSION_EXPIRED = 9;
	const SESSION_CONCURRENT = 10;
	const ACP_LOGIN_EMPTY_BOTH = 11;
	const ACP_LOGIN_ERROR = 12;
	const ACP_LOGIN_RANK = 50;
	const ACP_SECRET_KEY = 49;
	//TIME
	const TIME_PAST = 13;
	const TIME_FUTURE = 14;
	const TIME_NOW = 15;
	const TIME_YESTERDAY = 16;
	const TIME_TOMORROW = 17;
	const TIME_SOME = 18;
	const TIME_SECONDS = 19;
	const TIME_MINUTE = 20;
	const TIME_HOUR = 21;
	const TIME_DAY = 22;
	const TIME_WEEK = 23;
	const TIME_MONTH = 24;
	const TIME_YEAR = 25;
	//REGISTER
	const REGISTER_PWD_EMPTY = 26;
	const REGISTER_PWD_TOO_SHORT = 27;
	const REGISTER_PWD_TOO_LONG = 28;
	const REGISTER_PWD_NOT_NUM = 29;
	const REGISTER_PWD_NOT_MATCH = 30;
	const REGISTER_TOS = 31;
	const REGISTER_COOKIES = 32;
	const REGISTER_EMAIL_NOTVALID = 33;
	const REGISTER_EMAIL_REGISTERED = 34;
	const CAPTCHA_ERROR = 35;
	const REGISTER_NAME_EMPTY = 36;
	const REGISTER_NAME_TOO_SHORT = 37;
	const REGISTER_NAME_TOO_LONG = 38;
	const REGISTER_NAME_NOTVALID = 39;
	const REGISTER_NAME_REGISTERED = 40;
	const REGISTER_MYSQL_ERROR = 41;
	const REGISTER_EMPTY = 42;
	//GLOBAL ERRORS
	const ERROR_DEFAULT = 43;
	const ERROR_DIFF_PWD = 44;
	const CLIENT_BLOCKED_WRONG_PIN = 45;
	const CLIENT_BLOCKED_EMPTY_PIN = 46;
	const CLIENT_BLOCKED_NO_PIN = 47;
	const CLIENT_BLOCKED_INVALID_PIN = 48;
	
	public static function Get($r, ...$p)
	{
		if(!class_exists('Texts'))
			require LANG . 'Texts.php';

		return array_key_exists($r, Texts::$Map) ? sprintf(Texts::$Map[$r], ...$p) : '';
	}
	
	public static function Get2($r, $r2, ...$p)
	{
		if(!class_exists('Texts'))
			require LANG . 'Texts.php';

		return sprintf(((array_key_exists($r, Texts::$Map) ? Texts::$Map[$r] : '') . (array_key_exists($r2, Texts::$Map) ? Texts::$Map[$r2] : '')), ...$p);		
	}
}
?>