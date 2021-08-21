<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

//const STYLE_OTHER = 'iJollyness';

require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED | Redirect::NOLOGGED);
Site::$PageName = Title::Me[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Me[1];
Site::$PageId = 'home';

require HEADER . 'Community.php';
require HTML . 'Community_me.html';
require FOOTER . 'Community.php';
?>