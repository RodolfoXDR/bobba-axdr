<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(isset($_POST["accountId"]) && is_numeric($_POST["accountId"])):
	require "../../../KERNEL-XDRCMS/Init.php";
endif;
?>
	Dialog.showInfoDialog("add-friend-messages",  
		"La petici�n de Amigo se envi� correctamente.",
		"OK");