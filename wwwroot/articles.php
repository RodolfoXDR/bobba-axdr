<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

//const STYLE_OTHER = 'Jollyness';	
	
require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED);
Site::$PageName = Title::Articles[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Articles[1];

require HEADER . 'Community.php';
require SCRIPT . 'Articles.php';
require HTML . 'Community_articles.html';
require FOOTER . 'Community.php';
?>