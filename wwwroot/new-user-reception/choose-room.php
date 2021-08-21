<?php
if (!isset($_POST['roomChoice']) || !is_numeric($_POST['roomChoice']))
	exit;

const APIsLoad = 'Register';
require '../../KERNEL-XDRCMS/Init.php';

if (isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != WWW)
	exit();

if (!User::$Logged || User::$Row['receptionPased'] == '1' || !isset($_SESSION['receptionCanRegisterRoom'], $_SESSION['newReceptionUserName']))
	exit;

unset($_SESSION['receptionCanRegisterRoom']);

$floor = '610';
$wallpaper = '2403';
$landscape = '0.0';

if ($_POST['roomChoice'] == '2')
{
	$floor = '307';
	$wallpaper = '3104';
	$landscape = '1.10';
}
else if ($_POST['roomChoice'] == '3')
{
	$floor = '409';
	$wallpaper = '1902';
}

SQL::query('INSERT INTO rooms (roomtype, caption, owner, description, category, state, users_max, model_name, wallpaper, floor, landscape) VALUES (\'private\', \'Territorio ' . $_SESSION['newReceptionUserName'] . '\', \'' . $_SESSION['newReceptionUserName'] . '\', \'¡Una sala pre-decorada!\', 2, \'open\', 25, \'model_h\', ' . $wallpaper . ', ' . $floor . ', \'' . $landscape . '\')');
$roomId = SQL::$insert_id;

SQL::query('UPDATE users SET home_room = ' . $roomId . ' WHERE id = ' . User::$Data['id']);

if ($_POST['roomChoice'] == '3')
{
	SQL::query("INSERT INTO `items_rooms` VALUES (null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2511', '', '7', '2', '1.000', '4', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2545', '', '9', '3', '1.000', '6', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2545', '', '6', '3', '1.000', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1650', '', '10', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1364', '', '5', '10', '0.000', '6', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1364', '', '5', '9', '0.000', '6', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1363', '1', '4', '11', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1375', '1', '4', '9', '0.000', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1375', '1', '4', '10', '0.000', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4449', '', '0', '0', '0.000', '0', ':w=2,10 l=3,42 l', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4443', '2', '0', '0', '0.000', '0', ':w=3,8 l=15,34 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1370', '1', '7', '9', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1370', '1', '8', '9', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1370', '1', '7', '10', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1370', '1', '8', '10', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1370', '1', '6', '10', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1370', '1', '6', '9', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2044', '3', '9', '7', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2044', '3', '8', '7', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2044', '3', '6', '7', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2044', '3', '7', '7', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1367', '3', '9', '7', '1.300', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1372', '3', '6', '7', '1.300', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4450', '1', '0', '0', '0.000', '0', ':w=8,1 l=13,25 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4669', '1', '0', '0', '0.000', '0', ':w=6,1 l=6,32 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4672', '', '0', '0', '0.000', '0', ':w=4,7 l=3,27 l', '0', '', '0', '0');");
}
else if($_POST['roomChoice'] == '2')
{
	SQL::query("INSERT INTO items_rooms VALUES (null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '8', '10', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '9', '10', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '9', '8', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '8', '8', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '9', '11', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '8', '11', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2524', '2', '8', '8', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2524', '1', '8', '9', '0.000', '6', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2524', '1', '10', '8', '0.000', '4', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2542', '1', '9', '8', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4508', '1', '0', '0', '0.000', '0', ':w=8,1 l=12,32 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4508', '3', '0', '0', '0.000', '0', ':w=7,1 l=3,28 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4508', '3', '0', '0', '0.000', '0', ':w=10,1 l=0,26 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4508', '1', '0', '0', '0.000', '0', ':w=5,1 l=15,34 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '5', '3', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '5', '4', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2514', '', '5', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '10', '5', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '9', '5', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '8', '5', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '7', '5', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '10', '4', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '10', '3', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '9', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '10', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1949', '', '7', '3', '1.000', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2450', '', '5', '11', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '8', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '7', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1170', '', '5', '11', '1.300', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1962', '', '7', '4', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1959', '', '8', '3', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2533', '1', '8', '2', '2.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4662', '1', '0', '0', '0.000', '0', ':w=4,5 l=11,45 l', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4662', '1', '0', '0', '0.000', '0', ':w=4,3 l=5,50 l', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4496', '', '0', '0', '0.000', '0', ':w=2,11 l=7,56 l', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4496', '', '0', '0', '0.000', '0', ':w=2,10 l=10,56 l', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2827', '3', '3', '9', '0.800', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1472', '', '3', '11', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1472', '', '3', '9', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1643', '', '4', '9', '0.000', '4', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1643', '', '3', '11', '0.000', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1472', '2', '4', '9', '0.000', '4', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1642', '', '3', '9', '0.400', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1642', '', '3', '9', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1654', '', '3', '10', '0.400', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1642', '', '3', '10', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1654', '', '3', '12', '0.000', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1180', '', '3', '10', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '1561', '', '3', '9', '0.000', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4429', '', '0', '0', '0.000', '0', ':w=4,8 l=7,44 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4429', '', '0', '0', '0.000', '0', ':w=4,8 l=8,44 l', '0', '', '0', '0');");
}
else
{
	SQL::query("INSERT INTO items_rooms VALUES (null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4421', '', '0', '0', '0.000', '0', ':w=4,3 l=14,27 l', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2287', '1', '7', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2277', '4', '6', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2277', '4', '9', '2', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2537', '1', '8', '4', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '924', '', '8', '5', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '933', '', '7', '5', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '942', '', '9', '5', '1.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '3298', '', '3', '11', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '3298', '', '5', '9', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '3298', '', '5', '11', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '3298', '', '3', '9', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '3280', '', '4', '11', '1.000', '2', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4764', '', '0', '0', '0.000', '0', ':w=2,10 l=1,28 l', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4694', '', '0', '0', '0.000', '0', ':w=2,11 l=16,27 l', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '4600', '1', '0', '0', '0.000', '0', ':w=4,8 l=0,44 r', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '5', '', '9', '9', '0.000', '4', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '5', '', '10', '9', '0.000', '4', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '5', '', '9', '12', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '5', '', '10', '12', '0.000', '0', '', '0', '', '0', '0'),
(null, " . User::$Data['id'] . ", " . User::$Data['id'] . ", " . $roomId . ", '2357', '', '9', '10', '0.000', '0', '', '0', '', '0', '0');");
}
?>