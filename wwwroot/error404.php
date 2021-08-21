<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2016 Xdr.
|+=========================================================+
|| # Xdr 2016. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/


header('HTTP/1.1 404 Not Found');

//const STYLE_OTHER = 'Jollyness';

require_once '../KERNEL-XDRCMS/Init.php';
Site::$PageName = Title::Error404[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Error404[1];

require HEADER . 'Community.php';
require HTML . 'Error404.html';
require FOOTER . 'Community.php';
?>