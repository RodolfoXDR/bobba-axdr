<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2016 Xdr.
|+=========================================================+
|| # Xdr 2016. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/
require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED);
Site::$PageName = Title::Top[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Top[1];
Site::$PageId = 'community';

require HEADER . 'Community.php';
require HTML . 'Community_top.html';
require FOOTER . 'Community.php';
?>