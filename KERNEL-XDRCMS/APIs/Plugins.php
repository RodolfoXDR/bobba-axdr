<?php
class Plugins
{
	static $_colors = ['white','black','blue','pixellightblue','red','green','yellow','orange','brown','settings'];
	
	public static function Append($posId)
	{
		if(!Config::CacheEnabled || !file_exists(KERNEL . 'Cache' . DS . 'pPlugins.' . $posId . '.json'))
			return;

		$j = Cache::Read(KERNEL . 'Cache' . DS . 'pPlugins.' . $PosId . '.json', true);
		if($j === null || $j === FALSE)
			return;

		foreach($j as $v)
		{
			if($v['Rank'] == 0)
				continue;
			else if((USER::$Data['rank'] == 0 && $v['rank'] != 1) || (USER::$Data['rank'] > 0 && $v['rank'] > USER::$Data['rank']))
				continue;

			$v['canDisable'] = isset($v['canDisable']) ? $v['canDisable'] : true; // For updated versions
			if($v['canDisable'] == true && !empty(USER::$Row['pluginData']))
			{
				$uPlugins = json_decode(USER::$Row['pluginData'], true);
				if(isset($uPlugins[$v['id']]) && !$uPlugins[$v['id']])
					continue;
			}

			if(!file_exists(KERNEL . 'Cache' . DS . 'Plugin.' . $v['ID'] . '.html'))
				continue;

			if($v['internal'] === true)
				require LANG . 'Plugins' . DS . 'PLUGIN.' . $v['ID'] . '.php';
			else if($v['template'] === true)
			{
				require LANG . 'Plugins' . DS . 'HEAD.html';
				require KERNEL . 'Cache' . DS . 'Plugin.' . $v['ID'] . '.html';
				require LANG . 'Plugins' . DS . 'FOOTER.html';
			}
			else
				require KERNEL . 'Cache' . DS . 'Plugin.' . $v['ID'] . '.html';
		}
	}
}
?>