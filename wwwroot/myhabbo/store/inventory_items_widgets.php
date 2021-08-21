<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

require_once '../../../KERNEL-XDRCMS/Init.php';
$i = ['RoomsWidget' => [false, 2, 'Mis salas', '', 'rooms'],
	'FriendsWidget' => [false, 3, 'Mis amigos', '', 'friends'],
	'GuestbookWidget' => [false, 5, 'Libro de Invitados', '', 'guestbook'],
	'BadgesWidget' => [false, 21, 'Mis Placas', 'Muestra tus Placas en tu Página.', 'badges']
];

$id = User::$Data['id'];
$q = SQL::query('SELECT var FROM xdrcms_site_items WHERE type = \'widget\' AND userId = ' . $id);
if($q && $q->num_rows > 0)
	while($r = $q->fetch_assoc())
		if(isset($i[$r['var']]))
			$i[$r['var']][0] = true;
?>
<ul id="inventory-item-list">
<?php foreach($i as $Key => $Value): if($Value[0])	continue; ?>
	<li id="inventory-item-p-<?php echo $Value[1]; ?>" 
		title="<?php echo $Value[2]; ?>" class="webstore-widget-item">
		<div class="webstore-item-preview w_<?php echo $Value[4]; ?>widget_pre Widget">
			<div class="webstore-item-mask"></div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $Value[2]; ?></h3>
			<p><?php echo $Value[3]; ?></p>
		</div>
	</li>
<?php
endforeach;
foreach($i as $Key => $Value): if(!$Value[0])	continue; ?>
	<li id="inventory-item-p-<?php echo $Value[1]; ?>" 
		title="<?php echo $Value[2]; ?>" class="webstore-widget-item webstore-widget-disabled">
		<div class="webstore-item-preview w_<?php echo $Value[4]; ?>widget_pre Widget">
			<div class="webstore-item-mask"></div>
		</div>
		<div class="webstore-widget-description">
			<h3><?php echo $Value[2]; ?></h3>
			<p><?php echo $Value[3]; ?></p>
		</div>
	</li>
<?php endforeach; ?>
</ul>