<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2016 Xdr.
|+=========================================================+
|| # Xdr 2016. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/
require '../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED | Redirect::NOLOGGED);
Site::$PageName = Title::Refers;
Site::$PageId = 'home';

require HEADER . 'Global.php';
require HEADER . 'Global.Column3.php';
require HTML . 'Global.refers.html';
require FOOTER . 'Global.html';
?>