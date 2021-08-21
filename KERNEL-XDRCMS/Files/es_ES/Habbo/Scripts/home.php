<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright © 2015 Xdr.
|+=========================================================+
|| # Xdr 2015. The power of Proyects.
|| # Este es un Software de código libre, libre edición.
|+=========================================================+
*/

if(isset($_GET['id']) && $_GET['id'] > 0 && is_numeric($_GET['id'])):
    $searchid = $_GET['id'];
elseif(isset($_GET['name']) && strlen($_GET['name']) > 2):
    $searchname = $_GET['name'];
    $searchid = User::GetIdByName($searchname);
endif;

if($searchid != User::$Data['id']):
    $user_sql = User::GetUserData($searchid);

    $user_row = $user_sql;
    Site::$PageName = $user_row['name'];
else:
    $user_row = array_merge (User::$Data, User::$Row);
    Site::$PageName = User::$Data['name'];
endif;

$edit_mode = false;
$canEdit = false;

if(!isset($user_row)):
    require HEADER . 'Community.php';
	require HTML . 'error404.html';
	require FOOTER . 'Community.php';
	exit;
else:
    if($user_row['id'] == User::$Data['id']):
		if(isset($_SESSION['home_edit'])):
			$edit_mode = true;
			$body_id = 'editmode';
		endif;

		$canEdit = true;
	endif;
endif;

$textNotes = [
	'note.remember.security' => '¡Atención!<br />Publicar información personal sobre ti mismo o tus amigos, como direcciones, teléfonos o e-mail, o utilizar cualquier contenido que vaya en contra de la Manera ' . HotelName . ', tendrá una consecuencia inmediata:<br />Tu nota será borrada para siempre.',
	'note.welcome' => '¡Bienvenido a tu nueva y flamante ' . HotelName . ' Home! Aquí podrás dejar tu huella con un sinfín de curiosas etiquetas y de notas llenas de color. Para comenzar a crear tu ' . HotelName . ' Home, puls aen el botón \'Editar\'',
	'note.myfriends' => '¿Y mis amigos?<br />Para añadir tu lista de conocidas a tu página haz click en Editar y mira en tus elementos del inventario. Despues de colocarlo puedes movr y mirar como queda. <br />¡Vamos!'
];
?>