<?php
define('Start', microtime(true)); 
ini_set('session.name', 'aXDR-RTM:1');

require '../../KERNEL-XDRCMS/Init.php';

if(Site::$Settings['RegisterEnabled'] != 1 && !User::$Logged)
	Site::Redirect(Redirect::NOLOGGED);
?>