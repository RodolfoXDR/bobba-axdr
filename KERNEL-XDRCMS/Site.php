<?php
class Site
{
	const XDRBuild = '63-BUILD2769 - 1.28.2016 14:55 - rc - aXDR 3.0';
	const Charset = 'utf-8';

	static $NoMaintenance = false;

	public static $Blocked = false;
	public static $Settings = [];
	
	public static $Ranks = [];

	public static $PageName, $PageColor, $PageImg, $PageId, $BodyId = '';

	public static $Onlines = 0;
	// GLOBAL USAGES
	public static function Redirect($t)
	{
		if($t & Redirect::BLOCKED && self::$Blocked)
			exit(header('Location:' . URL . '/error/blocked'));
		if($t & Redirect::NOLOGGED && !User::$Logged)
			exit(header('Location: ' . URL));
		if($t & Redirect::LOGGED && User::$Logged)
			exit(header('Location: ' . URL . '/me'));
		if($t & Redirect::NOCLIENT && !User::$Logged)
			exit(header('Location: ' . URL . '/login_popup'));
	}
	
	public static function SetOnline()
	{
		if(file_exists(KERNEL . '/Cache/' . 'onlineCount.uint') && (time() - filemtime(KERNEL . 'Cache' . DS . 'onlineCount.uint')) < 120 || FastLoad == true)
			return self::$Onlines = Cache::Read(KERNEL . '/Cache/' . 'onlineCount.uint');

		if(FastLoad)
		{
			self::$Onlines = '?';
			return;
		}

		self::$Onlines = self::GetOnlineCount();
		$l = strlen(self::$Onlines);
		if($l > 3)
			self::$Onlines = substr(self::$Onlines, 0, $l - 3) . '.' . substr(self::$Onlines, $l - 3);
		Cache::Write(KERNEL . 'Cache' . DS . 'onlineCount.uint', self::$Onlines);
	}
	
	// CORE USAGES
	public static function DefineUri(&$c)
	{
		$c['URL']['default']['server'] = strtolower($c['URL']['default']['server']);
		$c['URL']['devPrivateServer'] = strtolower($c['URL']['devPrivateServer']);
		$server = str_replace('www.', '', $_SERVER['SERVER_NAME']);

		if(!empty($c['URL']['devPrivateServer']) && $c['URL']['devPrivateServer'] === $_SERVER['SERVER_NAME'])
		{
			$c['URL']['lang'] = $c['URL']['default']['lang'];
			
			//self::$NoMaintenance = true;
			define('URL', ($c['URL']['default']['requireSSL'] ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME']);
			define('WWW', $_SERVER['SERVER_NAME']);
		}
		else
		{
			$sUrl = isset($c['URL'][$server]) ? $server : (!empty($c['URL']['default']['server']) ? 'default' : exit('No tienes acceso a esta web.'));

			define('URL', ($c['URL'][$sUrl]['requireSSL'] ? 'https' : 'http') . '://' . ($c['URL'][$sUrl]['requireWWW'] ? 'www.' : '') . $c['URL'][$sUrl]['server']);
			define('WWW', $c['URL'][$sUrl]['requireWWW'] ? 'www.' . $server : $server);
			
			if($c['URL'][$sUrl]['requireSSL'] && (!isset($_SERVER['HTTPS']) || !($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == '1')))
				exit(header('Location: ' . URL . $_SERVER['REQUEST_URI']));
			if($c['URL'][$sUrl]['requireWWW'] && strpos($_SERVER['SERVER_NAME'], 'www.') === FALSE)
				exit(header('Location: ' . URL . $_SERVER['REQUEST_URI']));

			$c['URL']['lang'] = $c['URL'][isset($c['URL'][$sUrl]['lang']) ? $sUrl : 'default']['lang'];
			if(isset($c['URL'][$sUrl]['SQL']))
				$c['SQL'] = $c['URL'][$sUrl]['SQL'];
		}
		
		DEFINE ('LANG', Files . $c['URL']['lang'] . DS);
		
		if (defined('STYLE_OTHER'))
			$c['URL']['style'] = STYLE_OTHER;

		if(!is_dir(LANG . $c['URL']['style']))
			die ('Invalid Style Path. In Site.php ref User.Config.php');
		
		define('HURL', URL . $c['URL']['dirASE']);
		define('HHURL', URL . $c['URL']['dirASE']);
		define('UPLOAD', $c['URL']['dirUploads']);

		DEFINE ('STYLENAME', $c['URL']['style']);
		DEFINE ('STYLEPATH', LANG . $c['URL']['style'] . DS);
		DEFINE ('SCRIPT', STYLEPATH . 'Scripts' . DS);
		DEFINE ('HEADER', STYLEPATH . 'Headers' . DS);
		DEFINE ('FOOTER', STYLEPATH .  'Footers' . DS);
		DEFINE ('HTML', STYLEPATH .  'HTMLs' . DS);
		DEFINE ('ACP', LANG . 'ACP' . DS);
		DEFINE ('ASE', LANG . 'ASE' . DS);
		
		require STYLEPATH . 'Style.php';
	}

	public static function LoadPermissions($r)
	{
		$query = SQL::query('SELECT * FROM xdrcms_permissions ORDER BY id');

		$temp_perm = [];

		if($query != null && $query->num_rows > 0):
			while($row = $query->fetch_assoc()):
				$temp_perm[$row['permission']] = $r['ase.' . $row['id']];
			endwhile;
		endif;

		return $temp_perm;
	}
	
	public static function LoadRanks()
	{
		$query = SQL::query('SELECT * FROM xdrcms_ranks ORDER BY level ASC');

		if($query != null && $query->num_rows > 0):
			while($row = $query->fetch_assoc()):
				self::$Ranks[$row['level']] = [
					'Name' => $row['name'],
					'Category' => $row['category_id'],
					'Permissions' => self::LoadPermissions($row)
				];
			endwhile;
		endif;

		DEFINE ('MinRank', SQL::query('SELECT level FROM xdrcms_ranks ORDER BY level ASC LIMIT 1')->fetch_assoc()['level']);
		DEFINE ('MaxRank', SQL::query('SELECT level FROM xdrcms_ranks ORDER BY level DESC LIMIT 1')->fetch_assoc()['level']);
	}

	public static function GetRanks($c = null, $n = null, $o = 0)
	{
		$_ranks = [];

		if($n == 0 && $n != null)
			return $_ranks;

		if($c != null)
			foreach (self::$Ranks as $rankId => $value):
				if($value['Category'] == $c):
					$_ranks[$rankId] = [
						'Name' => $value['Name'],
						'Category' => $value['Category'],
						'Permissions' => $value['Permissions']
				];
				endif;
			endforeach;
		else
			$_ranks = self::$Ranks;

		$_ranks = array_reverse($_ranks, true);
		$_ranks = array_slice($_ranks, $o, $n, true);

		return $_ranks;
	}
	
	public static function LoadSettings()
	{
		self::$Settings = Cache::GetAIOConfig('Site');
	}
	
	public static function CheckCountryRestrictions()
	{
		if(Config::$Restrictions['country']['action'] === 0 || IP == '127.0.0.1')
			return;

		if(isset($_SESSION['country']))
			$code = $_SESSION['country'];
		else
			$code = $_SESSION['country'] = file_get_contents('http://api.hostip.info/country.php?ip=' . $_SERVER['REMOTE_ADDR']);

		if(Config::$Restrictions['country']['strict'] && $Code == 'XX')
			self::$Blocked = true;
		else if(Config::$Restrictions['country']['action'] == '1' && isset(Config::$Restrictions['country']['list'][$code]))
			self::$Blocked = true;
		else if(Config::$Restrictions['country']['action'] == '2' && !isset(Config::$Restrictions['country']['list'][$code]))
			self::$Blocked = true;
	}
	
	public static function ShowMaintenance()
	{
		if((!Config::$Restrictions['maintenance']['active'] || self::$NoMaintenance || defined('NoMaintenance') || User::$Data['rank'] >= Config::$Restrictions['maintenance']['except']) && !Maintenance)
		return;

		exit(header('Location:' . URL . '/maintenance'));
	}
	
	public static function SetResourcesDirectory()
	{
		$default = !isset(self::$Settings['defaultStyle'], self::$Settings['styles'][self::$Settings['defaultStyle']]) || self::$Settings['defaultStyle'] == -1 ? STYLE_SERVER . '/xdr-web/63_1d5d8853040f30be0cc82355679bba7f/3389/web-gallery' : self::$Settings['Styles'][self::$Settings['defaultStyle']]['PATH']; //V2
		define ('LOOK', 'https://habbo.com.tr/habbo-imaging/avatarimage?figure=');
		define ('LOOKHEAD', URL . '/habbo-imaging/head?figure=');
		define ('RES', STYLE_SERVER . '/xdr-web/' . STYLE_RESOURCES . '/'); // V3
		define ('ShortRES', STYLE_SERVER . '/xdr-web/');

		if(isset($_COOKIE['customStyle']) && is_numeric($_COOKIE['customStyle']))
			if(!isset(self::$Settings['styles'][$_COOKIE['customStyle']]) || !self::$Settings['styles'][$_COOKIE['customStyle']]['actived'])
				unset($_COOKIE['customStyle']);
			else
				$default = self::$Settings['Styles'][$_COOKIE['customStyle']]['PATH'];

		define ('RES2', $default); // V2
	}
	
	static function GetOnlineCount()
	{
		if(Config::OnlineType === 0)
			return SQL::query('SELECT COUNT(*) FROM ' . Server::Get(Server::USER_TABLE) . ' WHERE online = \'1\'')->fetch_assoc()['COUNT(*)'];
		else if(Config::OnlineType === 1)
		{
			$q = SQL::query('SELECT users_online FROM server_status');
			return $q && $q->num_rows === 1 ? $q->fetch_assoc()['users_online'] : 0;
		}
		else if(Config::OnlineType === 2)
			return SQL::query('SELECT COUNT(*) FROM user_online')->fetch_assoc()['COUNT(*)'];
	}

	static function GetTop($n = 10, $t = 'credits', $s = false, &$r = '') //Top #, Top In What, Staffs, Array
	{
		$p = Server::Get(Server::USER_RANK_COLUMN) . ' = 1';

		switch($t):
			case 'credits':
				$t = Server::Get(Server::USER_CREDITS_COLUMN);
			break;
			case 'diamonds':
				$t = Server::Get(Server::USER_DIAMONDS_COLUMN);
			break;
			case 'pixels':
				$t = Server::Get(Server::USER_PIXELS_COLUMN);
			break;
			case 'respects':
				$t = Server::Get(Server::USER_STATS_RESPECTS_COLUMN);
			break;
		endswitch;

		switch($t):
			case 'credits':
			case 'diamonds':
			case 'pixels':
				$q = SQL::query('SELECT ' . $t . ', ' . Server::Get(Server::USER_NAME_COLUMN) . ', ' . Server::Get(Server::USER_LOOK_COLUMN) . ' FROM ' . Server::Get(Server::USER_TABLE) . ((!$s) ? (' WHERE ' . $p) : '') . ' LIMIT ' . $n);
			break;
			case 'respects':
			break;
			default:
			break;
		endswitch;

		if (!$q || $q->num_rows === 0)
			return false;

		echo 'SELECT ' . $t . ', ' . Server::Get(Server::USER_NAME_COLUMN) . ', ' . Server::Get(Server::USER_LOOK_COLUMN) . ' FROM ' . Server::Get(Server::USER_TABLE) . ((!$s) ? (' WHERE ' . $p) : '') . ' LIMIT ' . $n . "<br />";

		$r = $q->fetch_all();
		return true;
	}

	static function GetPhotoData($type, $data)
	{
		return SQL::query('SELECT image FROM server_camera WHERE ' . ($type == 'thumbnail' ? 'type=\'thumb\' AND room_id' : 'id') . ' = \'' . $data . '\' ORDER BY id DESC LIMIT 1')->fetch_assoc()['image'];
	}
}

class Redirect
{
	const BLOCKED = 0x1;
	const NOLOGGED = 0x2;
	const LOGGED = 0x4;
	const NOCLIENT = 0x8;
}
?>