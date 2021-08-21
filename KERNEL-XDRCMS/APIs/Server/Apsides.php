<?php
class Emulator 
{
    public static $Map = [
        Server::USER_TABLE[0] => 'players',
        Server::BANS_TABLE[0] => 'bans',
        Server::USER_BADGES_TABLE[0] => 'player_badges',
        Server::USER_SETTINGS_TABLE[0] => '',
        Server::USER_STATS_TABLE[0] => '',
        Server::ROOMS_TABLE[0] => '',
        Server::GROUPS_TABLE[0] => '',
        Server::ITEMS_TABLE[0] => '',
        Server::CATALOG_FURNIS_TABLE[0] => '',
        Server::CATALOG_PAGES_TABLE[0] => '',
    
        Server::USER_ID_COLUMN[0] => 'id',
        Server::USER_NAME_COLUMN[0] => 'username',
        Server::USER_LOOK_COLUMN[0] => 'figure',
        Server::USER_MOTTO_COLUMN[0] => 'motto',
        Server::USER_RANK_COLUMN[0] => 'rank',
        Server::USER_AUTH_TICKET_COLUMN[0] => 'auth_ticket',
        Server::USER_GENDER_COLUMN[0] => 'gender',
        Server::USER_LAST_ONLINE_COLUMN[0] => 'last_online',
        Server::USER_IP_LAST_COLUMN[0] => 'last_ip',
        
        Server::BANS_ID_COLUMN[0] => 'id',
        Server::BANS_TYPE_COLUMN[0] => 'type',
        Server::BANS_REASON_COLUMN[0] => 'reason',
        Server::BANS_EXPIRE_DATE_COLUMN[0] => 'expire',
        Server::BANS_VALUE_COLUMN[0] => 'data',
        Server::BANS_ADDED_BY_COLUMN[0] => 'added_by',

        Server::USER_BADGES_USER_ID_COLUMN[0] => 'player_id',
        Server::USER_BADGES_BADGE_ID_COLUMN[0] => 'badge_code',
        Server::USER_BADGES_BADGE_SLOT_COLUMN[0] => 'slot',

        Server::USER_STATS_RESPECTS_COLUMN[0] => 'total_respect_points',
        Server::USER_CREDITS_COLUMN[0] => 'credits',
        Server::USER_PIXELS_COLUMN[0] => 'activity_points',
        Server::USER_DIAMONDS_COLUMN[0] => 'vip_points',
    ];
}

?>