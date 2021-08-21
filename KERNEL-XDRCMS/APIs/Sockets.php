<?php
/*=========================================================+
|| # Azure Kernel of XDRCMS. All rights reserved.
|| # Copyright © 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/
class Socket
{
	static $_c;
	static $_e = false;
	static $_p = ['credits' => ['updateCredits', false], 
		'bans' => ['reloadbans', false], 
		'logout' => ['signout', false], 
		'alert' => ['alert', false], 
		'alertlink' => ['hal', false], 
		'massitem' => ['massitem', false],
		'shutdown' => ['shutdown', false],
		'getonline' => ['getonline', true],
		'givebadge' => ['givebadge', false],
		'alert' => ['alert', false],
		'ha' => ['ha', false],
		'give' => ['give', false],
		'updateCatalogue' => ['update_catalog', false]
	];

	static function CONN(){
		if(self::$_c == null)
			self::$_c = @socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));

		if(!@socket_connect(self::$_c, $GLOBALS['sSettings']['MUS']['Server'], $GLOBALS['sSettings']['MUS']['Port'])):
			self::$_e = true;
			return false;
		endif;
		
		return true;
	}
	
	static function CLOSE() {
		if(self::$_c == null)	return;
		@socket_close(self::$_c);
	}
	
	static function sendP($h, $d, $r = false) {
		$d = $h . chr(1) . $d . chr(0);
		@socket_write(self::$_c, $d);
		if(!$r)
			return;

		@socket_recv(self::$_c, $R, 2048, MSG_WAITALL);
		return $R;
	}

	public static function send($h, $d = '')
	{
		if(!isset($GLOBALS['sSettings']))
			$GLOBALS['sSettings'] = CACHE::GetAIOConfig('Server');
		if(!extension_loaded('sockets') || self::$_e || !isset(self::$_p[$h]))
			return 'error';
		elseif(!$GLOBALS['sSettings']['MUS']['Enabled'])
			return 'error';
		elseif(self::$_c == null && !self::CONN())
			return 'error';
		
		self::sendP(self::$_p[$h][0], $d, self::$_p[$h][1]);
	}
}
?>