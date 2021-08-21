<?php
const FastLoad = true;
require '../../../KERNEL-XDRCMS/Init.php';

$cSettings = Cache::GetAIOConfig('Client');

if($cSettings['managed.override.token'] != $_GET['token'])
	exit(header('Location: ' . URL . '/managed-gamedata/override/external_override_variables/' . $cSettings['managed.override.token']));

header('Content-type: text/plain');
echo file_exists(KERNEL . '/Cache/Override.Variables.txt') ? file_get_contents(KERNEL . '/Cache/Override.Variables.txt') : '';
?>