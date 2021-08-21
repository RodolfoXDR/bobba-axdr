<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

const STYLE_OTHER = 'Habbo';
const APIsLoad = 'Identifier';

require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED);
Site::$PageName = Title::xLuck[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::xLuck[1];
Site::$PageId = 'xluck';
$PageNow = 'xLuck';

require HEADER . 'Community.php';
//require SCRIPT . 'home.php';
require HTML . 'xLuck.html';
require FOOTER . 'Community.php';

?>