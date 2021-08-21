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

Site::Redirect(Redirect::BLOCKED | Redirect::NOLOGGED);
Site::$PageName = Title::Shop[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Shop[1];
Site::$PageId = 'shop';

$tabId = isset($_GET['tab']) ? $_GET['tab'] : 'home';

require HEADER . 'Community.php';

switch ($tabId)
{	
	case 'badges':
	case 'currencies':
	case 'rares':
		require HTML . 'Shop_page_' . $tabId . '.html';
		break;
	case 'home':
	default:
		require HTML . 'Shop_page_home.html';
		break;
};


require FOOTER . 'Community.php';

?>