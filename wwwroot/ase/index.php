<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2016 Xdr & Mr.Mustache.
|| # Metro UI Designs
|+=========================================================+
|| # aXDR 2013. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
|| # ASE by Xdr & Mr.Mustache
|| # Copyright (C) 2016. Todos los derechos reservados.
|+=========================================================+
*/

const NoMaintenance = true;

require '../../KERNEL-XDRCMS/Init.php';

if(isset($_SESSION['Manage']['Login']))
	exit(header('Location: ' . HHURL . '/manage'));

require ASE . 'scripts/updates.php';
require ASE . 'login.php';
?>