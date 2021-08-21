<?php 
$PageName = 'Logs WEB';

if($do === 'deleteAll' && User::hasPermission('ase.delete_logs'))
{
	if(checkAntiCsrf())
	{
		SQL::query('TRUNCATE xdrcms_staff_log');
		SLOG('Remove', 'Borrado de todos los logs', 'manage.php[logs]', 0);
		echo 'Se han borrado todos los logs';
	}
	else
		echo 'Invalid Secret Key. Please log in with a valid Secret Key.';

	exit;
}

if(isset($_POST['UBuserId']) && is_numeric($_POST['UBuserId']) && User::hasPermission('ase.delete_logs'))
{
	if(checkAntiCsrf())
	{
		SQL::query('DELETE FROM xdrcms_staff_log WHERE id = ' . $_POST['UBuserId']);
		SLOG('Remove', 'Borrado de un log.', 'manage.php[logs]', 0);
		echo 'Se ha borrado el log.';
	}
	else
		echo 'Invalid Secret Key. Please log in with a valid Secret Key.';

	exit;
}
else if(isset($_GET['filter']))
{
	$_GET['filter'] = hex2bin($_GET['filter']);
	$Search = $_GET['filter'];
	Tool::ApplyEntities(Tool::HTMLEntities, $Search);

	$queryOptions = '';
	$orderOption = 'DESC';
	$limitOption = 15;
	$pageOption = 1;
	
	$tableName = 'xdrcms_staff_log';
	$getColumns = '*';
 
	// SEARCH FILTER 0.4 preBeta
	// CODED BY XDR
	
	if(strpos($Search, '&lt;!-- ') !== false && strpos($Search, ' --&gt;') !== false):
		$_s = explode(';', explode(' --&gt;', explode('&lt;!-- ', $Search)[1])[0] . ';');

		foreach($_s as $o):
			if(empty($o) || strpos($o, ':') === false)
				continue;

			$o = explode(':', $o);

			if($o[0] === 'page' && (is_numeric($o[1]) && $o[1] > 0)):
				$pageOption = $o[1];
			endif;
		endforeach;
		$Search = preg_replace('/\&lt;!--(.*?)\--\&gt;/', '', $Search);
	endif;

	$_Page = (($pageOption * $limitOption) - $limitOption);	
	
	$usersQueryCount = SQL::query('SELECT COUNT(*) FROM xdrcms_staff_log')->fetch_assoc()['COUNT(*)'];
	$usersQuery = SQL::query('SELECT ' . $getColumns . ' FROM xdrcms_staff_log WHERE id > \'0\' ' . $queryOptions . ' ORDER BY id ' . $orderOption . ' LIMIT ' . $_Page . ',' . $limitOption . '');
	$DataHTML = '<input type="hidden" id="usersTotal" value="' . $usersQueryCount . '" /><input type="hidden" id="nowPage" value="' . $pageOption . '" /><input type="hidden" id="resultCount" value="' . $limitOption . '" />';

	if($usersQuery && $usersQuery->num_rows > 0):
		while ($Row = $usersQuery->fetch_assoc()):
			$time = (is_numeric($Row['timestamp'])) ? date('d-M-o G:i:s', $Row['timestamp']) : '--';
			$DataHTML .= '<tr><td>' . $Row['id'] . '</td><td>' . $Row['note'] . '</td><td>' . $Row['message'] . '</td><td>' . (($Row['userid'] == User::$Data['id']) ? User::$Data['name'] : User::GetNameById($Row['userid'])) . ' -> ' . (($Row['targetid'] === '0') ? '<i>Sistema</i>' : (($Row['targetid'] == User::$Data['id']) ? User::$Data['name'] : User::GetNameById($Row['targetid']))) . '</td><td title="' . $time . '">' . (Tool::ParseUnixTime($Row['timestamp'])) . '</td><td>' . (!User::hasPermission('ase.delete_logs') ? '' : '<a href="javascript:void(0)" onclick="DeleteLog(' . $Row['id'] . ')">Borrar</a>') . '</td></tr>';
		endwhile;
	else:
		$DataHTML .= 'No se han encontrado logs.';
	endif;

	if(isset($_POST['onlyTable']))
	{
		echo $DataHTML;
		exit;
	}
}

if(!isset($usersQueryCount))
	$usersQueryCount = SQL::query('SELECT COUNT(*) FROM xdrcms_staff_log')->fetch_assoc()['COUNT(*)'];


require ASE . 'Header.html';
?>

<table>
		<thead>
			<tr>
				<th id="th1" class="text-left">Id</th>
				<th id="th2" class="text-left">Página</th>
				<th id="th3" class="text-left">Acción</th>
				<th id="th4" class="text-left">Editor - Afectado</th>
				<th id="th4" class="text-left">Tiempo</th>
				<th id="th5" class="text-left">Acciones: </th>
			</tr>
		</thead>
		
		<tbody id="resultTable">
		<?php
		if(!isset($DataHTML)): ?>
				<input type="hidden" id="usersTotal" value="<?php echo $usersQueryCount; ?>" />
				<input type="hidden" id="resultCount" value="15" />
				<input type="hidden" id="nowPage" value="1" />
		<?php
		$usersQuery = SQL::query('SELECT id, note, message, userid, targetid, timestamp FROM xdrcms_staff_log ORDER BY id DESC LIMIT 15');
		if($usersQuery && $usersQuery->num_rows > 0):
			while ($Row = $usersQuery->fetch_assoc()):
				$time = (is_numeric($Row['timestamp'])) ? date('d-M-o G:i:s', $Row['timestamp']) : '--';
		?>
					<tr>
						<td><?php echo $Row['id']; ?></td>
						<td><?php echo $Row['note']; ?></td>
						<td><?php echo $Row['message']; ?></td>
						<td><?php echo ($Row['userid'] == User::$Data['id']) ? User::$Data['name'] : User::GetNameById($Row['userid']); ?> -> <?php echo ($Row['targetid'] === '0') ? '<i>Sistema</i>' : (($Row['targetid'] == User::$Data['id']) ? User::$Data['name'] : User::GetNameById($Row['targetid'])); ?></td>
						<td title="<?php echo $time; ?>"><?php echo Tool::ParseUnixTime($Row['timestamp']); ?></td>
						<td><?php if(User::hasPermission('ase.delete_logs')): ?><a href="javascript:void(0)" onclick="DeleteLog(<?php echo $Row['id']; ?>)">Borrar</a><?php endif; ?></td>
					</tr>
		<?php endwhile; else: echo ''; endif; else: echo $DataHTML; endif; ?>
		</tbody>
</table>
<br />
	<?php if(User::hasPermission('ase.delete_logs')): ?>
		<button class="button alert" onclick="NewDialog('Aviso', '¿Estás seguro de borrar todos los logs? ¡No puedes deshacer los cambios!', '', '<button class=\'button alert save\'onclick=\'DeleteALL()\'>Borrar TODO</button><button class=\'button alert\'	onclick=\'CloseDialog()\'>Cerrar</button>');">Borrar TODO</button>
	<?php endif; ?>
	<script type="text/javascript">
		var uRank = <?php echo User::$Data['rank']; ?>;
		<?php if(User::hasPermission('ase.delete_logs')): ?>
			function DeleteALL(){
				get("<?php echo HHURL; ?>/manage?p=logs&do=deleteAll", "POST", null, "");
				window.location.reload();
			}
			
			function DeleteLog(userId){
				get("<?php echo HHURL; ?>/manage?p=logs", "POST", showAsyncAlert, "UBuserId=" + userId);
			}
		<?php endif; ?>

		function SCHclick(){
			var sValue = element('#i0120').value;
			window.history.pushState("", "", 'manage?p=logs&filter=' + b2h(sValue));
			get("<?php echo HHURL; ?>/manage?p=logs&filter=" + b2h(sValue), "POST", SCHclickAsync, "onlyTable=true");
		}
		function SCHclickAsync(m){
			element("#resultTable").innerHTML = this.responseText;
		}
	</script>