<?php
$PageName = 'Logs CLIENT';

if($do == 'delete' && is_numeric($key)):
	if(!checkAntiCsrf()):
		$msg_error = 'Invalid Secret Key. Please, log in with your secret key.';
	elseif(isset($_SESSION['Manage']['Login'])):
		SQL::query('DELETE FROM logs_client_staff WHERE id = ' . $key);
		SLOG('Remove', 'Borrado de un log de cliente.', 'manage.php[server_logs]', 0);
		$msg_correct = 'Se ha borrado el log.';
	endif;
elseif($do == 'deleteAll' && User::hasPermission('ase.delete_logs')):
	if(!checkAntiCsrf()):
		$msg_error = 'Invalid Secret Key. Please, log in with your secret key.';
	else:
		SQL::query('TRUNCATE logs_client_staff');
		SLOG('Remove', 'Borrado de todos los logs de client.', 'manage.php[server_logs]', 0);
		$msg_correct = 'Se han borrado todos los logs de cliente.';
	endif;
endif;

require ASE . 'Header.html';
?>

<table>
		<thead>
			<tr>
				<th id="th1" class="text-left">Id</th>
				<th id="th2" class="text-left">Acción</th>
				<th id="th3" class="text-left">Editor</th>
				<th id="th4" class="text-left">Tiempo</th>
				<th id="th5" class="text-left">Acciones: </th>
			</tr>
		</thead>
		<tbody id="resultTable">
		<?php
		$usersQuery = SQL::query('SELECT id, user_id, data_string, timestamp FROM logs_client_staff ORDER BY id DESC LIMIT 15');
		if($usersQuery && $usersQuery->num_rows > 0):
			while ($Row = $usersQuery->fetch_assoc()):
				$time = (is_numeric($Row['timestamp'])) ? date('d-M-o G:i:s', $Row['timestamp']) : '--';
		?>
					<tr>
						<td><?php echo $Row['id']; ?></td>
						<td><?php echo $Row['data_string']; ?></td>
						<td><?php echo ($Row['user_id'] == User::$Data['id']) ? User::$Data['name'] : User::GetNameById($Row['user_id']); ?></td>
						<td title="<?php echo $time; ?>"><?php echo Tool::ParseUnixTime($Row['timestamp']); ?></td>
						<td><?php if(User::hasPermission('ase.delete_logs')): ?><a href="<?php echo HHURL; ?>/manage?p=server_logs&do=delete&key=<?php echo $Row['id']; ?>">Borrar</a><?php endif; ?></td>
					</tr>
		<?php endwhile; endif; ?>
		</tbody>
</table>
<br />
<?php if(User::hasPermission('ase.delete_logs')): ?>
		<button class="button alert" onclick="NewDialog('Aviso', '¿Estás seguro de borrar todos los logs? ¡No puedes deshacer los cambios!', '', '<a href=\'<?php echo HHURL ?>/manage?p=server_logs&do=deleteAll\' class=\'button alert save\'>Borrar TODO</a><button class=\'button alert\'	onclick=\'CloseDialog()\'>Cerrar</button>');">Borrar TODO</button>
<?php endif; ?>