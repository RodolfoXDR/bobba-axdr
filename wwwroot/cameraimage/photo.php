<?php
if(!isset($_GET['type']) || !isset($_GET['data'])):
	return;
else:
	$type = $_GET['type'];
	$data = $_GET['data'];
endif;

$roomData = str_replace(['_small', '.png'], '', $data);

require '../../KERNEL-XDRCMS/Init.php';
require 'Hashids.php';

if($type != "thumbnail"):
	$roomData = substr($roomData, 2);
	$roomData = substr($roomData, 0, -2);

	$hashids = new Hashids('Ym61RYJRpU1olhUrxnRFOplpwzva0kEM0gJSZzMT');
	$roomData = $hashids->decode($roomData);
	$roomData = $roomData[0];
endif;

$photoData = Site::GetPhotoData($type, $roomData);


if($photoData != null):
	$PNG = imagecreatefromstring($photoData);
	ob_start();
	header('Content-type: image/png');
	imagepng($PNG);
	
else:
	$PNG = imagecreatefrompng('default.png');
	header('Content-type: image/png');
	imagepng($PNG);
endif;
?>