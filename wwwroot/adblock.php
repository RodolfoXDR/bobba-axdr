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

Site::Redirect(Redirect::BLOCKED);
Site::$PageName = Title::AdBlock[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::AdBlock[1];
Site::$PageId = 'home';

require HEADER . 'Community.php';
require HTML . 'Community_adblock.html';
require FOOTER . 'Community.php';

?>