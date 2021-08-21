<?php
if(!isset($_GET['scope'], $_GET['query']))	exit;
require '../../../KERNEL-XDRCMS/Init.php';
USER::REDIRECT(1);

$Type = $_GET['scope'];
$Data = $_GET['query'];
$Query = [];

if(strlen($Data) < 3): ?>
<ul>
	<li>Porfavor, inserte un texto con más de dos letras.</li>
</ul>
<?php
	exit;
endif;

if($Type == '1'):
	$resultType = 'habbo';
	$Name = 'username';
	$Query = $MySQLi->query("SELECT id, username FROM users WHERE username LIKE '%" . $Data . "%' LIMIT 5");
elseif($Type == '2'):
	$resultType = 'room';
	$Name = 'caption';
	$Query = $MySQLi->query("SELECT id, caption FROM rooms WHERE caption LIKE '%" . $Data . "%' LIMIT 5");
elseif($Type == '3'):
	$resultType = 'group';
	$Name = 'name';
	$Query = $MySQLi->query("SELECT id, name FROM groups_details WHERE name LIKE '%" . $Data . "%' LIMIT 5");
endif;
?>
<ul>
	<li>Haz clic para añadirlo al documento</li>
<?php
if($Query && $Query->num_rows > 0):
	while ($Row = $Query->fetch_assoc()):
?>
    <li><a href="#" class="linktool-result" type="<?php echo $resultType; ?>" 
    	value="<?php echo $Row["id"]; ?>" title="<?php echo $Row[$Name]; ?>"><?php echo $Row[$Name]; ?></a></li>
<?php
endwhile;
else:
?>
<ul>
	<li>No se ha encontrado resultados.</li>
</ul>
<?php
endif;
?>