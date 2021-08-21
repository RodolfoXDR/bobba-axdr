<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

const APIsLoad = 'Identifier';

require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED);
Site::$PageName = Title::Community[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Community[1];
Site::$PageId = 'home';

require HEADER . 'Community.php';
//require SCRIPT . 'home.php';
require HTML . 'Community_community.html';
require FOOTER . 'Community.php';

?>