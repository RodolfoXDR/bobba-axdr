<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/


require '../KERNEL-XDRCMS/Init.php';

/*if(!Config::$Restrictions['maintenance']['active'])
	Site::Redirect(Redirect::BLOCKED | Redirect::NOLOGGED | Redirect::LOGGED);*/

Site::$PageName = Title::Maintenance[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Maintenance[1];
Site::$PageId = 'maintenance';

require HEADER . 'Maintenance.php';
require HTML . 'Maintenance.html';
?>

