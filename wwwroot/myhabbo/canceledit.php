<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2012 Xdr.
|+=========================================================+
|| # Xdr 2012. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

$require_login = true;
require "../../KERNEL-INIT/Init.php";
checkloggedin(1);

$groupId = 0;
$homeId = 0;

if(isset($_SESSION['group_edit_id']))
	$groupId = $_SESSION['group_edit_id'];
else
	$homeId = $my_id;

unset($_SESSION["Ajax"]["Update"]);
unset($_SESSION["Ajax"]["Delete"]);
unset($_SESSION["Ajax"]["UpdateTemporal"]);

unset($_SESSION['home_edit']);
unset($_SESSION['group_edit']);
unset($_SESSION['group_edit_id']);

$MySQLi->query("DELETE FROM xdrcms_site_items WHERE Temporal = 'True'");
	
if($groupId == "0")
	header("Location: " . PATH . "/home/" . $myrow["username"]);
else
	header("Location: " . PATH . "/groups/" . $groupId . "/id");
exit;
?>