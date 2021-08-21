<?php 
class Server {
    
    /* tables */
    const USER_TABLE = [1, 'users'];
    const BANS_TABLE = [2, 'bans'];
    const USER_BADGES_TABLE = [3, 'user_badges'];
    const USER_SETTINGS_TABLE = [4, 'user_settings'];
    const USER_STATS_TABLE = [5, 'user_stats'];
    const ROOMS_TABLE = [6, 'rooms'];
    const GROUPS_TABLE = [7, 'groups'];
    const ITEMS_TABLE = [8, 'items'];
    const CATALOG_FURNIS_TABLE = [9, 'catalog_items'];
    const CATALOG_PAGES_TABLE = [10, 'catalog_pages'];

    const USER_ID_COLUMN = [11, 'id'];
    const USER_NAME_COLUMN = [12, 'username'];
    const USER_LOOK_COLUMN = [13, 'look'];
    const USER_MOTTO_COLUMN = [14, 'motto'];
    const USER_RANK_COLUMN = [15, 'rank'];
    const USER_AUTH_TICKET_COLUMN = [16, 'auth_ticket'];
    const USER_GENDER_COLUMN = [17, 'gender'];
    const USER_LAST_ONLINE_COLUMN = [18, 'last_online'];
    const USER_IP_LAST_COLUMN = [19, 'ip_last'];
    
    const BANS_ID_COLUMN = [20, 'id'];
    const BANS_TYPE_COLUMN = [21, 'type'];
    const BANS_REASON_COLUMN = [22, 'reason'];
    const BANS_EXPIRE_DATE_COLUMN = [23, 'expire_date'];
    const BANS_VALUE_COLUMN = [24, 'value'];
    const BANS_ADDED_BY_COLUMN = [25, 'added_by'];

    const USER_BADGES_USER_ID_COLUMN = [26, 'user_id'];
    const USER_BADGES_BADGE_ID_COLUMN = [27, 'badge_id'];
    const USER_BADGES_BADGE_SLOT_COLUMN = [28, 'badge_slot'];

    const USER_STATS_RESPECTS_COLUMN = [29, 'respect'];
    const USER_CREDITS_COLUMN = [30, 'credits'];
    const USER_PIXELS_COLUMN = [31, 'activity_points'];
    const USER_DIAMONDS_COLUMN = [32, 'seasonal_currency'];

	public static function Get($r, ...$p)
	{
		if(!class_exists('Emulator'))
			require KERNEL . 'APIs' . DS . 'Server' . DS . Config::$Server['server']['name'] . '.php';

		return array_key_exists($r[0], Emulator::$Map) ? ((Emulator::$Map[$r[0]] !== '' || Emulator::$Map[$r[0]] == '')  ? sprintf(Emulator::$Map[$r[0]], ...$p) : sprintf($r[1], ...$p)) : '';
	}
	
	public static function Get2($r, $r2, ...$p)
	{
		if(!class_exists('Texts'))
            require KERNEL . 'APIs' . DS . 'Server' . DS . Config::$Server['server']['name'] . '.php';

		return sprintf(((array_key_exists($r, Emulator::$Map) ? Emulator::$Map[$r] : '') . (array_key_exists($r2, Emulator::$Map) ? Emulator::$Map[$r2] : '')), ...$p);		
    }
}
?>