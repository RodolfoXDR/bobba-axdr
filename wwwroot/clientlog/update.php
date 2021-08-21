<?php
if(!isset($_POST['flashStep']) && strlen($_POST['flashStep']) > 350)	exit;
const FastLoad = true;
require '../../KERNEL-XDRCMS/Init.php';

$_SESSION['user']['lastUsed'] = time();

if(!isset($_SESSION['aDEBUG'][0]) || $_SESSION['aDEBUG'][0] === false)
	exit;

$_SESSION['aDEBUG'][1][] = ['LOG', $_POST['flashStep']];
?>