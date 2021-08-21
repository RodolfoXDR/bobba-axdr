<?php
if(!isset($_POST['entryId'], $_POST['widgetId']))	exit;
require '../../../KERNEL-XDRCMS/Init.php';

SQL::query("DELETE FROM xdrcms_guestbook WHERE id = '" . $_POST["entryId"] . "' AND widget_id = '" . $_POST["widgetId"] . "' AND userid = '" . User::$Data['id'] . "' LIMIT 1");
?>