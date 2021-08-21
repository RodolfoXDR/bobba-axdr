<?php

$_test = true;
ini_set('display_errors', '1');
error_reporting(-1);
ini_set('default_charset', 'ISO-8859-1');
header('Content-Type: text/plain');
echo 'aXDR Compatibility Test
Starting...
__________________________________________________
';

if(version_compare(PHP_VERSION, '5.6.0') <= 0):
	echo 'You must upgrade your PHP version to 5.6 or higher.
';
	exit;
endif;

if (!extension_loaded('mysqli')):
	echo 'You must enable the mysqli extension.
';
	exit;
endif;

if (!extension_loaded('sockets')):
	echo 'You must add the sockets extension.
';
	exit;
endif;

if (!extension_loaded('curl')):
	echo 'You must enable the curl extension.
';
	exit;
endif;


clearstatcache();
if (!is_dir('../KERNEL-XDRCMS/')):
	echo 'Missing or not well located "KERNEL-XDRCMS" folder.
	It must be in inetpub or xampp folder and not in wwwroot or htdocs folder.
';
	exit;
endif;

if(!is_writable('../KERNEL-XDRCMS/Cache/')):
	echo 'You must give permissions to the "Cache" folder in "KERNEL-XDRCMS" folder.
';
	exit;
endif;

echo 'Finished test 1. Starting test 2...
__________________________________________________
';

require '../KERNEL-XDRCMS/Init.php';

echo 'Finished test 2. Starting test 3...
__________________________________________________
';

$query = SQL::query('SELECT @@sql_mode;');
if($query && $query->num_rows === 1):
	$result = $query->fetch_assoc();
	$result = $result['@@sql_mode'];
	if(stristr($result, 'STRICT')):
		echo 'For more compatibility with emulators, please, Turns off the mode STRICT MYSQL.
';
	endif;
endif;

$query = SQL::query('SELECT null FROM ' . Server::Get(Server::USER_TABLE));
if(!$query):
	echo 'The table "' . Server::Get(Server::USER_TABLE) . '" does not exist
';
endif;

$query = SQL::query('SELECT null FROM '. Server::Get(Server::BANS_TABLE));
if(!$query):
	echo 'The table "' . Server::Get(Server::BANS_TABLE) . '" does not exist
';
endif;

SQL::query('ALTER TABLE xdrcms_promos DROP Owner');
SQL::query('ALTER TABLE xdrcms_promos ADD OwnerID INT(255) NOT NULL DEFAULT \'0\' AFTER Id');
SQL::query('ALTER TABLE xdrcms_addons CHANGE title title VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');
SQL::query('ALTER TABLE xdrcms_promos DROP Color');
SQL::query('ALTER TABLE xdrcms_addons ADD creatorId INT(255) NOT NULL DEFAULT \'0\' , ADD created INT(255) NOT NULL DEFAULT \'0\' , ADD canDisable BOOLEAN NOT NULL DEFAULT TRUE');


echo 'FINISHED!. 
Now, to remove this, go to index.php, and remove line: header(\'Location: ../XDRTEST.php\'); exit;
and save, in the end, delete file "' . $_SERVER['DOCUMENT_ROOT'] . '\\XDRTEST.php"';
?>
