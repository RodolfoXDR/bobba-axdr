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

require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED | Redirect::NOLOGGED);
Site::$PageName = Title::Profile[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Profile[1];
Site::$PageId = 'home';

$tabId = (int) isset($_GET['tab']) && is_numeric($_GET['tab']) ? $_GET['tab'] : 1;

require HEADER . 'Community.php';

switch($tabId):
    case 1:
    case 2:
    case 3:
        require HTML . 'Settings_page_' . $tabId . '.html';
        break;
    default:
        require HTML . 'Settings_page_1.html';
        break;
endswitch;
		
require FOOTER . 'Community.php';
?>