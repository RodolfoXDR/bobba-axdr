<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

const NoReload = true;
require '../../KERNEL-XDRCMS/Init.php';

Site::Redirect(Redirect::BLOCKED);
User::Logout(isset($_GET['token']) ? $_GET['token'] : '', isset($_GET['reason']) ? $_GET['reason'] : '');
?>
