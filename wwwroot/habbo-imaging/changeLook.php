<?php
require '../../KERNEL-XDRCMS/Init.php';

header('Content-Type: application/json');

$username = isset($_GET['username']) ? $_GET['username'] : 'Unknown';

$Row = array();

$figure = (User::Get(Server::Get(Server::USER_TABLE), Server::Get(Server::USER_LOOK_COLUMN), $Row, Server::Get(Server::USER_NAME_COLUMN) . ' = \'' . $username . '\'')) ? $Row[Server::Get(Server::USER_LOOK_COLUMN)] : 'hd-208-1.hr-110-61.ch-809-66.lg-3202-110.sh-290-62';

$name = LOOK . $figure . '&action=wlk,wav&direction=4&head_direction=3&gesture=sml&size=m';

$arr = array('look' => $name, 'username' => $username);
echo json_encode($arr);

?>