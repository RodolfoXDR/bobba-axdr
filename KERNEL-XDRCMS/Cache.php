<?php
class Cache
{
	private static $Colors = ['white','black','blue','pixellightblue','red','green','yellow','orange','brown','settings'];
	
	public static function GetAIOConfig($l)
	{
		if (Config::CacheEnabled && file_exists(KERNEL . '/Cache/' . $l . '.json'))
		{
			$j = self::Read(KERNEL . 'Cache' . DS . $l . '.json', true);
			
			if($j !== NULL)
				return $j;
		}

		if(FastLoad)
			return null;

		$j = SQL::query('SELECT Data FROM xdrcms_aio_config WHERE Name = \'' . $l . '\'')->fetch_assoc()['Data'];
		self::Write(KERNEL . 'Cache' . DS . $l . '.json', $j);
		
		return json_decode($j, true);
	}

	public static function SetAIOConfig($l, $j)
	{
		$j = json_encode($j);
		SQL::query('UPDATE xdrcms_aio_config SET Data = \'' . $j . '\' WHERE Name = \'' . $l . '\'');

		self::Write(KERNEL . 'Cache' . DS . $l . '.json', $j);
	}
	
	public static function GetPromos($r = true, $n = null, $o = 0)
	{
		if ($r && Config::CacheEnabled && file_exists(KERNEL . 'Cache' . DS . 'Promos.json')):
			$j = self::Read(KERNEL . 'Cache' . DS . 'Promos.json', true);
			
			if ($j !== null):
				if($n != null):
					$k = array_slice($j, $o, $n, true);
					return $k;
				else:
					return $j;
				endif;
			endif;
		endif;

		$q = SQL::query('SELECT Id, BackGroundImage, Title, Content, TimeCreated, GoToHTML, Button FROM xdrcms_promos WHERE Visible = \'1\' ORDER BY Id DESC');
		$a = $q->fetch_all();

		if (Config::CacheEnabled)
			self::Write(KERNEL . 'Cache' . DS . 'Promos.json', $a, true);

		return $a;
	}

	public static function GetArticles($r = true, $n = null, $o = 0)
	{
		if ($r && Config::CacheEnabled && file_exists(KERNEL . 'Cache' . DS . 'Articles.json')):
			$j = self::Read(KERNEL . 'Cache' . DS . 'Articles.json', true);
			
			if ($j !== null):
				if($n != null):
					$k = array_slice($j, $o, $n, true);
					return $k;
				else:
					return $j;
				endif;
			endif;
		endif;

		$q = SQL::query('SELECT Id, BackGroundImage, Title, Category, Summary, TimeCreated FROM xdrcms_news WHERE Visible = \'1\' ORDER BY Id DESC');
		$a = $q->fetch_all();

		if (Config::CacheEnabled)
			self::Write(KERNEL . 'Cache' . DS . 'Articles.json', $a, true);

		return $a;
	}

	public static function GetShopItems($r = true, $type = 'all')
	{
		if($r && Config::CacheEnabled && file_exists(KERNEL . 'Cache' . DS . 'Shop.json')):
			$j = self::Read(KERNEL . 'Cache' . DS . 'Shop.json', true);
			
			if ($j !== null):

				if($type == 'all'):
					return $j;
				else:
					foreach($j as $item):
						if($item['type'] == $type):
							$k[] = $item;
						endif;
					endforeach;				
					return $k;
				endif;
			endif;
		endif;

		$q = SQL::query('SELECT id, type, title, code, category, active, price_credits, price_diamonds, limited, limited_sells, limited_stack FROM xdrcms_shop ORDER BY id DESC');
		$a = $q->fetch_all();

		if(Config::CacheEnabled)
			self::Write(KERNEL . 'Cache' . DS . 'Shop.json', $a, true);

		return $a;
	}
	
	public static function GetStats()
	{
		if(Config::CacheEnabled && file_exists(KERNEL . 'Cache' . DS . 'ACP.Stats.json') && (time() - filemtime(KERNEL . 'Cache' . DS . 'ACP.Stats.json')) < 3600)
		{
			$j = self::Read(KERNEL . 'Cache' . DS . 'ACP.Stats.json', true);
			if ($j !== null)
				return $j;
		}

		$users = SQL::query('SELECT COUNT(*) FROM ' . Server::Get(Server::USER_TABLE))->fetch_assoc()['COUNT(*)'];
		$usersR = SQL::query('SELECT COUNT(*) FROM ' . Server::Get(Server::USER_TABLE) . ' WHERE ' . Server::Get(Server::USER_RANK_COLUMN) . ' > 1')->fetch_assoc()['COUNT(*)'];
		$bans = SQL::query('SELECT COUNT(*) FROM ' . Server::Get(Server::BANS_TABLE));
		$bans = $bans != null && $bans->num_rows === 1 ? $bans->fetch_assoc()['COUNT(*)'] : 0;
		$logs = SQL::query('SELECT COUNT(*) FROM xdrcms_staff_log')->fetch_assoc()['COUNT(*)'];
		/*$vouchers = SQL::query('SELECT COUNT(*) FROM ' . Config::$Vouchers['tableName']);
		$vouchers = $vouchers != null && $vouchers->num_rows === 1 ? $vouchers->fetch_assoc()['COUNT(*)'] : 0;*/
		$plugins = SQL::query('SELECT COUNT(*) FROM xdrcms_addons')->fetch_assoc()['COUNT(*)'];
		$articles = SQL::query('SELECT COUNT(*) FROM xdrcms_news')->fetch_assoc()['COUNT(*)'];
		$promos = SQL::query('SELECT COUNT(*) FROM xdrcms_promos')->fetch_assoc()['COUNT(*)'];

		$rooms = SQL::query('SELECT COUNT(*) FROM ' . Server::Get(Server::ROOMS_TABLE));
		$rooms = $rooms != null && $rooms->num_rows > 0 ? $rooms->fetch_assoc()['COUNT(*)'] : 0;
		/*$roomsItems = SQL::query('SELECT COUNT(*) FROM catalog_offers');
		$roomsItems = $roomsItems != null && $roomsItems->num_rows > 0 ? $roomsItems->fetch_assoc()['COUNT(*)'] : 0;
		$catalogItems = SQL::query('SELECT COUNT(*) FROM catalog_offers');
		$catalogItems = $catalogItems != null && $catalogItems->num_rows > 0 ? $catalogItems->fetch_assoc()['COUNT(*)'] : 0;*/

		$s = [$users, $usersR, $bans, $logs/*, $vouchers*/, $plugins, $articles, $promos, $rooms/*, $roomsItems, $catalogItems*/];
		Cache::Write(KERNEL . 'Cache' . DS . 'ACP.Stats', $s, true);
		
		return $s;
	}

	public static function AppendPlugin($p)
	{
		if(Config::CacheEnabled && file_exists(KERNEL . 'Cache' . DS . 'pPlugins.'. $p .'.json')):
			$j = self::Read(KERNEL . 'Cache' . DS . 'pPlugins.'. $p .'.json', true);
			if ($j !== null):
				foreach($j as $jRow):
					if($jRow['minRank'] == 0)
						continue;


					$jRow['canDisable'] = isset($jRow['canDisable']) ? $jRow['canDisable'] : true; // For updated versions

					/*if(class_exists('USER') && $jsonRow['canDisable'] == true && !empty(USER::$Row['AddonData'])):
						$uPlugins = json_decode(USER::$Row['AddonData'], true);
						if(isset($uPlugins[$jsonRow['ID']]) && !$uPlugins[$jsonRow['ID']])
							continue;
					endif;*/
					
					if(!file_exists(KERNEL . 'Cache' . DS . 'Plugin.' . $jRow['ID'] . '.html')):
						echo 'No existe archivo Plugin.' . $jRow['ID'] . '.html';
						continue;
					endif;

					if($jRow['canDelete'] === false):
						
						require STYLEPATH . 'Addons' . DS . 'PLUGIN.' . $jRow['ID'] . '.php';
					elseif($jRow['Template'] === true):
						require STYLEPATH . 'Addons' . DS . 'Header.html';
						require KERNEL . 'Cache' . DS . 'Plugin.' . $jRow['ID'] . '.html';
						require STYLEPATH . 'Addons' . DS . 'Footer.html';
					else:
						require KERNEL . 'Cache' . DS . 'Plugin.' . $jRow['ID'] . '.html';
					endif;

				endforeach;
			endif;
		endif;
	}

	public static function LoadPositionPlugins($p){
		global $MySQLi;
		$pluginData = [];
		$query = SQL::query('SELECT * FROM xdrcms_plugins WHERE Position = ' . $p);
		while($row = $query->fetch_assoc()):
			array_push($pluginData, [
			'ID' => $row['Id'],
			'Title' => $row['Title'],
			'Template' => $row['Template'] === '1',
			'minRank' => $row['minRank'],
			'Color' => $row['Color'],
			'canDisable' => $row['canDisable'] === '1',
			'canDelete' => $row['canDelete'] === '1']);
		endwhile;
	
		Cache::Write(KERNEL . '/Cache/pPlugins.' . $p . '.json', $pluginData, true);
	}

	public static function LoadPluginContent($i, $c){

	}

	public static function Read($f, $j = false) //fileUbication, (bool)json
	{
		if (!Config::CacheEnabled)
			return null;

		if(!file_exists($f))
			return null;

		$s = file_get_contents($f);
		if ($j)
			$s = json_decode($s, true);
			
		return $s;
	}
	
	public static function Write($f, $s, $j = false) //fileUbication, data, (bool)json
	{
		if (!Config::CacheEnabled)
			return;

		if ($j)
			$s = json_encode($s);

		$f = fopen($f, (file_exists($f)) ? 'w' : 'a');
		fwrite($f, $s);
		fclose($f);
	}

	public static function Delete($f)
	{
		if(file_exists($f))
			unlink($f);
	}
}
?>