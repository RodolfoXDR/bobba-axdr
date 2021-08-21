<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/
const APIsLoad = 'Homes.StoreCategories';
const STYLE_OTHER = 'Habbo';

require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED | Redirect::NOLOGGED);
Site::$PageName = Title::Me[0];
Site::$PageColor = (Title::FixedColor) ? Title::Color : Title::Me[1];
Site::$PageId = 'myprofile';

require SCRIPT . 'home.php';
require HEADER . 'Community.php';
require HTML . 'Community_homes.html';
?>