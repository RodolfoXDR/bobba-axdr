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

if(Site::$Settings['staff.page.visibility'] == 1  && User::$Data['rank'] < 3):
    Site::Redirect(Redirect::NOLOGGED | Redirect::LOGGED);
endif;

Site::Redirect(Redirect::BLOCKED);
Site::$PageName = Title::Alpha[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Alpha[1];
Site::$PageId = 'community';

require HEADER . 'Community.php';
require HTML . 'Community_alpha.html';
require FOOTER . 'Community.php';
?>