<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

//const STYLE_OTHER = 'uXPV';

require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED | Redirect::NOLOGGED);
Site::$PageName = Title::Messaging[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Messaging[1];
Site::$PageId = 'messaging';

require HEADER . 'Community.php';
require HTML . 'Community_messaging.html';
require FOOTER . 'Login.php';
?>