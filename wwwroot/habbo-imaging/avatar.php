<?php
error_reporting(0);

header("Content-type: image/png");
$figure = isset($_GET['figure']) ? $_GET['figure'] : '';
$direction = isset($_GET['direction']) ? $_GET['direction'] : '';
$head = isset($_GET['head_direction']) ? $_GET['head_direction'] : '';
$gesture = isset($_GET['gesture']) ? $_GET['gesture'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';
$size = isset($_GET['size']) ? $_GET['size'] : '';
$look = imagecreatefrompng("https://habbo.es/habbo-imaging/avatarimage?figure=".$figure."&direction=".$direction."&head_direction=".$head."&gesture=".$gesture."&action=".$action."&size=".$size);
imagealphablending($look, false);
$white = imagecolorallocatealpha($look, 255, 255, 255, 127);
imagefilltoborder($look, 0, 0, $white, $white);
imagealphablending($look, true);
imagesavealpha($look, true);
imagepng($look);
imagedestroy($look);
?>