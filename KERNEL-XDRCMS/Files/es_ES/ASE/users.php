<?php
$tableName = 'users';

$act = isset($_GET['act']) ? $_GET['act'] : '';
if(isset($_POST['UBuserId']) && is_numeric($_POST['UBuserId'])):
	if(checkAntiCsrf() && User::hasPermission('ase.ban_unban')):
		SQL::query('DELETE FROM bans WHERE id = ' . $_POST['UBuserId']);
		SLOG('Unban', 'Desbaneado', 'manage.php[users]', $_POST['UBuserId']);
		echo 'Usuario desbaneado.';
	else:
		echo 'Invalid Secret Key. Please log in with a valid Secret Key';
	endif;
	exit;
endif;

//FILTRO DE BUSQUEDA

if(isset($_GET['filter'])):
	$_GET['filter'] = hex2bin($_GET['filter']);
	Tool::ApplyEntities(Tool::HTMLEntities, $_GET['filter']);

	$s = str_replace('\\', '&#92;', $_GET['filter']);

	$queryOptions = '';
	$orderOption = 'ASC';
	$limitOption = 15;
	$pageOption = 1;
	$orderBy = 'id';

	$getColumns = '' . Server::Get(Server::USER_TABLE) . ' .id, ' . Server::Get(Server::USER_TABLE) . ' .' . Server::Get(Server::USER_NAME_COLUMN) . ', ' . Server::Get(Server::USER_TABLE) . ' .' . Server::Get(Server::USER_IP_LAST_COLUMN) . ', xdr_users.mail, xdr_users.web_online, xdr_users.rpx_type';
 
	// SEARCH FILTER 0.4 Beta
	// CODED BY XDR
	// Example: <!-- rank:1;order:DESC;limit:20 -->
	if(strpos($s, '&lt;!-- ') !== false && strpos($s, ' --&gt;') !== false):
		$_s = explode(';', explode(' --&gt;', explode('&lt;!-- ', $s)[1])[0] . ';');

		foreach($_s as $o):
			if($o === 'minrank')
			{
				if ($tableName === 'users')
					$queryOptions .= 'AND ' . Server::Get(Server::USER_TABLE) . ' .rank > \'' . MinRank . '\' ';
				continue;
			}

			if(empty($o) || strpos($o, ':') === false)
				continue;

			$o = explode(':', $o);

			if($o[0] === 'rank' && is_numeric($o[1])):
				$queryOptions .= 'AND rank = \'' . $o[1] . '\' ';
			elseif($o[0] === 'order' && $o[1] == 'DESC'):
				$orderOption = 'DESC';
			elseif($o[0] === 'limit' && (is_numeric($o[1]) && $o[1] > 0 && $o[1] < 36)):
				$limitOption = $o[1];
			elseif($o[0] === 'page' && (is_numeric($o[1]) && $o[1] > 0)):
				$pageOption = $o[1];
			elseif($o[0] === 'type' && ($o[1] === 'bans' OR $o[1] === 'logs' OR $o[1] === 'refers')):
				$tableName = $o[1];
			elseif($o[0] === 'orderby'):
				$orderBy = $o[1];
			endif;
		endforeach;
		$s = preg_replace('/\&lt;!--(.*?)\--\&gt;/', '', $s);
	endif;
	
	$_Page = (($pageOption * $limitOption) - $limitOption);	
	
	if($tableName === 'users'):
		$usersQueryCount = SQL::query('SELECT COUNT(*) FROM xdr_users')->fetch_assoc()['COUNT(*)'];
		if ($orderBy == 'time')
			$orderBy = 'xdr_users.web_online';
		else
			$orderBy = '' . Server::Get(Server::USER_TABLE) . ' .id';

		if(empty($s))
			$usersQuery = SQL::query('SELECT ' . $getColumns . ' FROM ' . Server::Get(Server::USER_TABLE) . ' , xdr_users FORCE INDEX (PRIMARY) WHERE ' . Server::Get(Server::USER_TABLE) . '.id = xdr_users.id ' . $queryOptions . ' ORDER BY ' . $orderBy . ' ' . $orderOption . ' LIMIT ' . $_Page . ',' . $limitOption . '');
		else if(is_numeric($s))
			$usersQuery = SQL::query("SELECT " . $getColumns . " FROM " . Server::Get(Server::USER_TABLE) . " , xdr_users FORCE INDEX (PRIMARY) WHERE (" . Server::Get(Server::USER_TABLE) . ".id = '" . $s . "' OR " . Server::Get(Server::USER_TABLE) . "." . Server::Get(Server::USER_NAME_COLUMN) . " LIKE'%" . $s . "%') AND " . Server::Get(Server::USER_TABLE) . ".id = xdr_users.id " . $queryOptions . " ORDER BY " . $orderBy . " " . $orderOption . " LIMIT " . $_Page . "," . $limitOption);
		else if (filter_var($s, FILTER_VALIDATE_EMAIL))
		{
			$sNoMail = substr($s, 0, strrpos($s, '@'));
			$usersQuery = SQL::query("SELECT " . $getColumns . " FROM " . Server::Get(Server::USER_TABLE) . " , xdr_users FORCE INDEX (PRIMARY) WHERE (xdr_users.mail = '" . $s . "' OR xdr_users.mail LIKE '%" . $sNoMail . "%') " . $queryOptions . " AND " . Server::Get(Server::USER_TABLE) . ".id = xdr_users.id ORDER BY " . $orderBy . " " . $orderOption . " LIMIT " . $_Page . "," . $limitOption . "");
		}
		else
			$usersQuery = SQL::query("SELECT " . $getColumns . " FROM " . Server::Get(Server::USER_TABLE) . " , xdr_users FORCE INDEX (PRIMARY) WHERE (" . Server::Get(Server::USER_TABLE) . "." . Server::Get(Server::USER_NAME_COLUMN) . " LIKE'%" . $s . "%' OR " . Server::Get(Server::USER_TABLE) . "." . Server::Get(Server::USER_IP_LAST_COLUMN) . " = '" . $s . "') " . $queryOptions . " AND " . Server::Get(Server::USER_TABLE) . ".id = xdr_users.id ORDER BY " . $orderBy . " " . $orderOption . " LIMIT " . $_Page . "," . $limitOption . "");
	elseif($tableName === 'bans'):
		$usersQueryCount = SQL::query('SELECT COUNT(*) FROM bans')->fetch_assoc()['COUNT(*)'];
		if ($orderBy == 'type')
			$orderBy = 'type';
		else if ($orderBy == 'time')
			$orderBy = 'expire';
		else
			$orderBy = 'id';
		
		if(empty($s)):
			$usersQuery = SQL::query('SELECT ' . Server::Get(Server::BANS_ID_COLUMN) . ', ' . Server::Get(Server::BANS_TYPE_COLUMN) . ', ' . Server::Get(Server::BANS_VALUE_COLUMN) . ', ' . Server::Get(Server::BANS_EXPIRE_DATE_COLUMN) . ', ' . Server::Get(Server::BANS_ADDED_BY_COLUMN) . ', ' . Server::Get(Server::BANS_REASON_COLUMN) . ' FROM' . Server::Get(Server::BANS_TABLE) . 'WHERE id > \'0\' ' . $queryOptions . ' ORDER BY ' . $orderBy . ' ' . $orderOption . ' LIMIT ' . $_Page . ',' . $limitOption . '');
		elseif(is_numeric($s)):
			$usersQuery = SQL::query("SELECT " . Server::Get(Server::BANS_ID_COLUMN) . ", " . Server::Get(Server::BANS_TYPE_COLUMN) . ", " . Server::Get(Server::BANS_VALUE_COLUMN) . ", " . Server::Get(Server::BANS_EXPIRE_DATE_COLUMN) . ", " . Server::Get(Server::BANS_ADDED_BY_COLUMN) . ", " . Server::Get(Server::BANS_REASON_COLUMN) . " FROM " . Server::Get(Server::BANS_TABLE) . "WHERE id = '" . $s . "'");
		else:
			$usersQuery = SQL::query("SELECT " . Server::Get(Server::BANS_ID_COLUMN) . ", " . Server::Get(Server::BANS_TYPE_COLUMN) . ", " . Server::Get(Server::BANS_VALUE_COLUMN) . ", " . Server::Get(Server::BANS_EXPIRE_DATE_COLUMN) . ", " . Server::Get(Server::BANS_ADDED_BY_COLUMN) . ", " . Server::Get(Server::BANS_REASON_COLUMN) . " FROM " . Server::Get(Server::BANS_TABLE) . "WHERE data LIKE'%" . $s . "%' " . $queryOptions . " ORDER BY " . $orderBy . " " . $orderOption . " LIMIT " . $_Page . "," . $limitOption . "");
		endif;
	elseif($tableName === 'logs'):
		$usersQueryCount = SQL::query('SELECT COUNT(*) FROM xdrcms_staff_log')->fetch_assoc()['COUNT(*)'];
		if($s === ''):
			$usersQuery = SQL::query('SELECT id, action, message, note, userid, targetid, timestamp FROM xdrcms_staff_log WHERE id > \'0\' ' . $queryOptions . ' ORDER BY id DESC LIMIT ' . $_Page . ',' . $limitOption);
		elseif(is_numeric($s)):
			$usersQuery = SQL::query('SELECT id, action, message, note, userid, targetid, timestamp FROM xdrcms_staff_log WHERE userid = ' . $s . ' ORDER BY id DESC LIMIT ' . $_Page . ',' . $limitOption);
		else:
			$usersQuery = SQL::query("SELECT id, action, message, note, userid, targetid, timestamp FROM xdrcms_staff_log WHERE note LIKE'%" . $s . "%' " . $queryOptions . " ORDER BY Id DESC LIMIT " . $_Page . "," . $limitOption . "");
		endif;
	elseif($tableName === 'refers'):
		if(!is_numeric($s)):
			$usersQueryCount = 0;
			$usersQuery = false;

			goto refError;
		endif;
		$q = SQL::query('SELECT Count, ReferIds FROM xdrcms_users_refers WHERE UserId = ' . $s);
		if(!$q || $q->num_rows === 0):
			$usersQueryCount = 0;
			$usersQuery = false;

			goto refError;
		endif;

		$q = $q->fetch_assoc();
		$usersQueryCount = $q['Count'];

		$usersQuery = SQL::query('SELECT ' . $getColumns . ' FROM ' . Server::Get(Server::USER_TABLE) . ', xdr_users WHERE ' . Server::Get(Server::USER_TABLE) . '.id IN (' . str_replace(['[', ']', '"'], ['', '', ''], $q['ReferIds']) . ') AND ' . Server::Get(Server::USER_TABLE) . '.id = xdr_users.id AND xdr_users.id = ' . Server::Get(Server::USER_TABLE) . '.id');
	endif;
refError:
	$DataHTML = '
		<input type="hidden" id="tableName" value="' . $tableName . '" />
		<input type="hidden" id="usersTotal" value="' . $usersQueryCount . '" />
		<input type="hidden" id="nowPage" value="' . $pageOption . '" />
		<input type="hidden" id="resultCount" value="' . $limitOption . '" />
	';

	if($usersQuery && $usersQuery->num_rows > 0):
		if($tableName === 'users' || $tableName === 'refers'):
			while ($Row = $usersQuery->fetch_assoc()):
				$time = (is_numeric($Row['web_online'])) ? date('d-M-o G:i:s', $Row['web_online']) : '--';
				$connectType = $Row['rpx_type'] == '0' ? 'habbo' : 'facebook';
				$DataHTML .= '<tr><td>' . $Row['id'] . '</td><td>' . $Row[Server::Get(Server::USER_NAME_COLUMN)] . '</td><td>' . $Row['mail'] . ' ( <img class="' . $connectType . '-icon"> )</td><td><a title="Buscar los usuarios con dicha Ip" href="' . HHURL . '/manage?p=users&filter=' . bin2hex($Row[Server::Get(Server::USER_IP_LAST_COLUMN)]) . '" target="_blank">' . $Row[Server::Get(Server::USER_IP_LAST_COLUMN)] . '</a></td><td title="' . $time . '">' . Tool::ParseUnixTime($Row['web_online']) . '</td><td><a href="' . HHURL . '/manage?p=users&filter=' . bin2hex($_GET['filter']) . '&do=edit&key=' . $Row['id'] . '">Editar</a></td></tr>';
			endwhile;
		elseif($tableName === 'bans'):
			while ($Row = $usersQuery->fetch_assoc()):
				$time = (is_numeric($Row["expire"])) ? date('d-M-o G:i:s', $Row["expire"]) : "--";
				$DataHTML .= '<tr><td>' . $Row['data'] . '</td><td>' . $Row['reason'] . '</td><td>' . $Row['added_by'] . '</td><td>' . $Row['type'] . '</td><td title="' . $time . '">' . Tool::ParseUnixTime($Row['expire']) . '</td><td><a href="#" onclick="unBan(' . $Row['id'] . ')">Desbanear</a></td></tr>';
			endwhile;
		elseif($tableName === 'logs'):
			while ($Row = $usersQuery->fetch_assoc()):
				$time = (is_numeric($Row['timestamp'])) ? date('d-M-o G:i:s', $Row['timestamp']) : '--';
				$DataHTML .= '<tr><td>' . $Row['id'] . '</td><td>' . $Row['note'] . '</td><td>' . $Row['message'] . '</td><td>' . $Row['userid'] . ' -> ' . (($Row['targetid'] === '0') ? 'Sistema' : $Row['targetid']) . '</td><td title="' . $time . '">' . Tool::ParseUnixTime($Row['timestamp']) . '</td><td></td></tr>';
			endwhile;
		endif;
	else:
		$DataHTML .= 'No se han encontrado usuarios con el id/nombre: \'' . $s . '\'';
	endif;

	if(isset($_POST['onlyTable'])):
		echo $DataHTML;
		exit;
	endif;
endif;


// USER EDITOR 

if($do === 'edit' && is_numeric($key)):
	$query = SQL::query('SELECT ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_NAME_COLUMN) . ', ' . Server::Get(Server::USER_TABLE) . '.credits, ' . Server::Get(Server::USER_TABLE) . '.activity_points, ' . Server::Get(Server::USER_TABLE) . '.vip_points, xdr_users.task, ' . Server::Get(Server::USER_TABLE) . '.rank, ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_IP_LAST_COLUMN) . ', ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_LOOK_COLUMN) . ' FROM ' . Server::Get(Server::USER_TABLE) . ', xdr_users WHERE ' . Server::Get(Server::USER_TABLE) . '.id = ' . $key . ' AND xdr_users.id = ' . $key);
	if(!$query):
		echo 'An error has ocurred.';
		exit;
	endif;

	$userRow = $query->fetch_assoc();
	$editingUser = $key;

	if(isset($_POST['credits']) && Tool::IsNumeric($_POST['credits']) && $_POST['credits'] > -1 && $_POST['credits'] < 2147483647 && User::hasPermission('ase.edit_users')):
		if(checkAntiCsrf()):
			SQL::query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET credits = ' . $_POST['credits'] . ' WHERE id = ' . $key);
			SLOG('Give', 'Cambiado los créditos a un valor de: ' . $_POST['credits'] . ' créditos', 'manage.php[users]', $key);
			echo 'Se han actualizado los créditos.';
			Socket::send('give', ''. $key .':credits:'. $_POST['credits'] .'');
		else:
			echo "Invalid Secret Key. Please log in with a valid Secret Key.";
		endif;
		exit;
	elseif(isset($_POST['duckets']) && Tool::IsNumeric($_POST['duckets']) && $_POST['duckets'] > -1 && $_POST['duckets'] < 2147483647 && User::hasPermission('ase.edit_users')):
		if(checkAntiCsrf()):
			SQL::query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET activity_points = ' . $_POST['duckets'] . ' WHERE id = ' . $key);
			SLOG('Give', 'Cambiado los duckets a un valor de: ' . $_POST['duckets'] . ' duckets', 'manage.php[users]', $key);
			echo 'Se han actualizado los duckets.';
			Socket::send('give', ''. $key .':duckets:'. $_POST['duckets'] .'');
		else:
			echo "Invalid Secret Key. Please log in with a valid Secret Key.";
		endif;
		exit;
	elseif(isset($_POST['diamonds']) && Tool::IsNumeric($_POST['diamonds']) && $_POST['diamonds'] > -1 && $_POST['diamonds'] < 2147483647 && User::hasPermission('ase.edit_users')):
		if(checkAntiCsrf()):
			SQL::query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET vip_points = ' . $_POST['diamonds'] . ' WHERE id = ' . $key);
			SLOG('Give', 'Cambiado los diamantes a un valor de: ' . $_POST['diamonds'] . ' diamantes', 'manage.php[users]', $key);
			echo 'Se han actualizado los diamantes.';
			Socket::send('give', ''. $key .':diamonds:'. $_POST['diamonds'] .'');
		else:
			echo "Invalid Secret Key. Please log in with a valid Secret Key.";
		endif;
		exit;
	elseif(isset($_POST['rank']) && is_numeric($_POST['rank']) && $_POST['rank'] > 0 && $_POST['rank'] <= MaxRank && User::hasPermission('ase.give_rank') && User::$Data['id'] != $key):
		if(!checkAntiCsrf()):
			echo 'Invalid Secret Key. Please log in with a valid Secret Key';
		elseif($_POST['rank'] >= User::$Data['rank']):
			echo 'Rango insuficiente.';
		elseif($userRow[Server::Get(Server::USER_RANK_COLUMN)] >= User::$Data['rank']):
			echo 'Rango insuficiente.';
		else:
			if(SQL::query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET rank = ' . $_POST['rank'] . ' WHERE id = ' . $key)):
				SLOG('Give', 'Cambiado el rango de ' . $userRow[Server::Get(Server::USER_RANK_COLUMN)] . ' a ' . $_POST['rank'], 'manage.php[users]', $key);
				echo 'Rango cambiado con éxito.';
			else:
				echo 'An error has ocurred.';
			endif;
		endif;
		exit;
	elseif(isset($_POST['name']) && User::hasPermission('ase.give_rank') && User::$Data['id'] != $key):
		require KERNEL . 'APIs' . DS . 'Register.php';

		if(!checkAntiCsrf())
			echo 'Invalid Secret Key. Please log in with a valid Secret Key';
		else if (strlen($_POST['name']) < 3 || strlen($_POST['name']) > 15)
			echo 'Nombre muy corto o muy largo';
		else if (!Register::ValidName($_POST['name']))
			echo 'Nombre no válido';
		elseif(Register::NameExists($_POST['name']))
			echo 'El nombre de usuario ya está en uso.';
		else
		{
			if (SQL::query('UPDATE ' . Server::Get(Server::USER_TABLE) . ' SET ' . Server::Get(Server::USER_NAME_COLUMN) . ' = \'' . $_POST['name'] . '\' WHERE id = ' . $key))
			{
				SQL::query('UPDATE rooms SET owner = \'' . $_POST['name'] . '\' WHERE owner = \'' . $userRow[Server::Get(Server::USER_NAME_COLUMN)] . '\'');
				SLOG('Give', 'Cambiado el nombre de ' . $userRow[Server::Get(Server::USER_NAME_COLUMN)] . ' a ' . $_POST['name'], 'manage.php[users]', $key);
				echo 'Nombre cambiado con éxito.';
			}
			else
				echo 'Ha ocurrido un error';
		}

		exit;
	elseif(isset($_POST['task']) && User::hasPermission('ase.give_rank') && User::$Data['id'] != $key):
		if(!checkAntiCsrf())
			echo 'Invalid Secret Key. Please log in wih a valid Secret Key';
		elseif(strlen($_POST['task']) < 3 || strlen($_POST['task']) > 20)
			echo 'Tarea muy corta o muy larga.';
		else
		{
			if (SQL::query('UPDATE xdr_users SET task = \'' . $_POST['task'] . '\' WHERE id = ' . $key))
			{
				SLOG('Give', 'Cambiado la tarea de ' . $userRow[Server::Get(Server::USER_NAME_COLUMN)] . ' a ' . $_POST['task'], 'manage.php[users]', $key);
				echo 'Tarea cambiada con éxito.';
			}
			else
				echo 'Ha ocurrido un error';
		}
		exit;
	elseif(isset($_POST['badge']) && User::hasPermission('ase.edit_users')):
		if(!checkAntiCsrf()):
			echo 'Invalid Secret Key. Please log in with a valid Secret Key';
		endif;
		$q = SQL::query('SELECT null FROM users_badges WHERE badge_id = \'' . $_POST['badge'] . '\' AND user_id = ' . $key);
		if($q && $q->num_rows > 0):
			SQL::query('DELETE FROM users_badges WHERE badge_id = \'' . $_POST['badge'] . '\' AND user_id = ' . $key);
			SLOG('Remove', 'Quitado la placa ' . $_POST['badge'], 'manage.php[users]', $key);
		else:
			SQL::query('INSERT INTO users_badges (user_id, badge_id)VALUES (' . $key . ', \'' . $_POST['badge'] . '\')');
			SLOG('Give', 'Dado la placa ' . $_POST['badge'], 'manage.php[users]', $key);
		endif;

		exit;
	elseif(isset($_POST['ban'], $_POST['type'], $_POST['lenght'], $_POST['count']) && User::hasPermission('ase.ban_unban')):
		if(!checkAntiCsrf())
			echo 'Invalid Secret Key. Please log in with a valid Secret Key';

		if($userRow[Server::Get(Server::USER_RANK_COLUMN)] >= User::$Data['rank'])
		{
			echo 'No puedes banear a un superior o igual.';
			exit;
		}
		else if(User::IsBanned($userRow[Server::Get(Server::USER_NAME_COLUMN)], $userRow[Server::Get(Server::USER_IP_LAST_COLUMN)], $banData))
		{
			echo 'Este usuario ya está baneado.';
			exit;
		}

		$type = ($_POST['type'] == '0') ? 'user' : 'ip';
		$len = 60 * 60 * (($_POST['count'] > 0) ? 24 : 1) * (($_POST['count'] > 1) ? 31 : 1) * (($_POST['count'] > 2) ? 12 : 1);
		$len = time() + $len;
		
		SQL::query('INSERT INTO ' . Server::Get(Server::BANS_TABLE) . ' (' . Server::Get(Server::BANS_TYPE_COLUMN) . ', ' . Server::Get(Server::BANS_VALUE_COLUMN) . ', ' . Server::Get(Server::BANS_REASON_COLUMN) . ', ' . Server::Get(Server::BANS_EXPIRE_DATE_COLUMN) . ', ' . Server::Get(Server::BANS_ADDED_BY_COLUMN) . ') VALUES (\'' . $type . '\', \'' . (($type === 'user') ? $userRow[Server::Get(Server::USER_NAME_COLUMN)] : $userRow[Server::Get(Server::USER_IP_LAST_COLUMN)]) . '\', \'' . $_POST['ban'] . '\', ' . $len . ', \'' . User::$Data['name'] . '\')');
		SLOG('Ban', 'Baneado', 'manage.php[users]', $key);
		echo 'Usuario baneado.';
		exit;
	endif;
endif;

if(!isset($usersQueryCount))
	$usersQueryCount = SQL::query('SELECT COUNT(*) FROM xdr_users')->fetch_assoc()['COUNT(*)'];

$PageName = 'Lista de usuarios';

require ASE . 'Header.html';
?>
	<table>
		<thead>
			<tr>
				<th id="th1" class="text-left" style="width:90px">ID</th>
				<th id="th2" class="text-left">Nombre</th>
				<th id="th3" class="text-left">Email</th>
				<th id="th6" class="text-left">IP</th>
				<th id="th4" class="text-left">Última vez conectado</th>
				<th id="th5" class="text-left">Acciones</th>
			</tr>
		</thead>

		<tbody id="resultTable">
			<?php
			if(!isset($DataHTML)): ?>
				<input type="hidden" id="usersTotal" value="<?php echo $usersQueryCount; ?>" />
				<input type="hidden" id="resultCount" value="15" />
				<input type="hidden" id="nowPage" value="1" />
				<input type="hidden" id="tableName" value="<?php echo $tableName; ?>" />
			<?php
			$usersQuery = SQL::query('SELECT ' . Server::Get(Server::USER_TABLE) . '.id, ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_NAME_COLUMN) . ', ' . Server::Get(Server::USER_TABLE) . '.' . Server::Get(Server::USER_IP_LAST_COLUMN) . ', xdr_users.mail, xdr_users.web_online, xdr_users.rpx_type FROM ' . Server::Get(Server::USER_TABLE) . ', xdr_users WHERE ' . Server::Get(Server::USER_TABLE) . '.id = xdr_users.id LIMIT 15');
			while ($Row = $usersQuery->fetch_assoc()):
			?>
				<tr class="hover">
					<td><?php echo $Row['id']; ?></td>
					<td><?php echo $Row[Server::Get(Server::USER_NAME_COLUMN)]; ?></td>
					<td><?php echo $Row['mail']; ?> ( <img class="<?php echo $Row['rpx_type'] == '0' ? 'habbo' : 'facebook'; ?>-icon"> )</td>
					<td><a title="Buscar los usuarios con dicha Ip" href="<?php echo HHURL; ?>/manage?p=users&filter=<?php echo bin2hex($Row[Server::Get(Server::USER_IP_LAST_COLUMN)]); ?>" target="_blank"><?php echo $Row[Server::Get(Server::USER_IP_LAST_COLUMN)]; ?></td>
					<td title="<?php echo (is_numeric($Row['web_online'])) ? date('d-M-o G:i:s', $Row['web_online']) : '--'; ?>"><?php echo Tool::ParseUNIXTIME($Row['web_online']); ?></td>
					<td><a href="<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $Row['id']; ?>">Opciones</a></td>
				</tr>
			<?php endwhile; else: echo $DataHTML; endif; ?>
		</tbody>

		<tfoot></tfoot>
	</table>
	
	<!-- NAVI BUTTONS -->
	
	<div style="text-align: center;">
		<button class="control" onclick="ChangePage('first')">&lt;&lt;</button>
		<button class="control" onclick="ChangePage('back')">&lt;</button>
		<button class="control" onclick="ChangePage('next')">&gt;</button>
		<button class="control" onclick="ChangePage('last')">&gt;&gt;</button>
	</div>

	<!-- SEARCH TOOL -->
	
	<h1>Buscar</h1>
	<div class="input-control text" data-role="input" style="display: -webkit-inline-box; width: 400px; margin-bottom: 30px;">
		<input type="text" style="display: -webkit-box" name="SCH" id="i0120" value="<?php echo (isset($_GET['filter'])) ? $_GET['filter'] : ''; ?>" maxlength="128" placeholder="ID o Nombre o IP" onkeydown="if (event.keyCode == 13) { SCHclick(); return false; }">
		<button class="button" style="position: relative; padding: 7.5px 20px;" onclick="SCHclick()"><span class="mif-search"></span></button>
	</div>

<?php if(isset($editingUser)): ?>
	<script type="text/javascript">
		<?php if(User::hasPermission('ase.ban_unban')): ?>
				function banUser() {
					get("<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>", "POST", showAsyncAlert, "ban=" + element("#bReason").value + "&type=" + element("#bType").value + "&lenght=" + element("#bLenght").value + "&count=" + element("#bCount").value);
				}
		<?php endif;
			if(User::hasPermission('ase.edit_users')): ?>
				function changeCredits(){
					get("<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>", "POST", showAsyncAlert, "credits=" + element("#uc").value);
				}
				function changeDuckets(){
					get("<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>", "POST", showAsyncAlert, "duckets=" + element("#up").value);
				}
				function changeDiamonds(){
					get("<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>", "POST", showAsyncAlert, "diamonds=" + element("#ud").value);
				}
				function giveBadge(){
					get("<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>", "POST", null, "badge=" + element("#ub").value);
					var el = element('#b-' + element("#ub").value);
					if(el == null){
						element("#badgesList").innerHTML = element("#badgesList").innerHTML + '<img id="b-' + element("#ub").value + '" style="cursor:pointer" onclick="element(\'#ub\').value = \'' + element("#ub").value + '\';" src="<?php echo Site::$Settings['badgesPath']; ?>/' + element("#ub").value + '.gif" title="' + element("#ub").value + '"/>';
					} else {
						el.remove();
					}
				}
		<?php endif;
			if(User::hasPermission('ase.give_rank') && User::$Data['id'] != $key): ?>
				function changeName(){
					get("<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>", "POST", showAsyncAlert, "name=" + element("#uN").value);
				}
				function changeTask(){
					get("<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>", "POST", showAsyncAlert, "task=" + element("#uT").value);
				}
				function changeRank(){
					get("<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>", "POST", showAsyncAlert, "rank=" + element("#ur").value);
				}
		<?php endif; ?>
	</script>
	
	<div id="user-edit" class="accordion" data-role="accordion" data-one-frame="false" data-show-active="<?php echo (isset($userRow)) ? 'true' : 'false'; ?>">
		<div class="frame">
			<div class="heading">Editar a <?php echo $userRow[Server::Get(Server::USER_NAME_COLUMN)]; ?></div>
			<div class="content">
				<div class="editor">
					<ul class="menu">
						<li>
							<div class="menu-tag">Cuenta</div>
							<ul>
								<li><a href="<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>">Información</a></li>
								<?php if($userRow[Server::Get(Server::USER_RANK_COLUMN)] >= MinRank) { ?><li><a href="<?php echo HHURL; ?>/manage?p=users&filter=<?php echo bin2hex('<!-- type:logs -->' . $key); ?>&do=edit&key=<?php echo $key; ?>">Logs</a></li><?php } ?>
								<?php if(User::hasPermission('ase.ban_unban') && User::$Data['rank'] > $userRow[Server::Get(Server::USER_RANK_COLUMN)]): ?><li><a href="<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>&act=ban">Banear</a></li><?php endif; ?>
							</ul>
						</li>
						<?php if(User::hasPermission('ase.edit_users')): ?>
						<li>
							<div class="menu-tag">Bienes</div>
							<ul>
								<li><a href="<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>&act=coins">Monedas</a></li>
								<li><a href="<?php echo HHURL; ?>/manage?p=users&do=edit&key=<?php echo $key; ?>&act=badges">Placas</a></li>
							</ul>
						</li>
						<?php endif; ?>
					</ul>

					<div class="sContent">
						<?php echo getAntiCsrf(); ?>
						<!-- BAN USER PAGE -->
						<?php if ($act === 'ban' && User::hasPermission('ase.ban_unban')): ?>
							<?php if (User::IsBanned($userRow[Server::Get(Server::USER_NAME_COLUMN)], $userRow[Server::Get(Server::USER_IP_LAST_COLUMN)], $banData)): ?>	
								¡Este usuario está baneado! La Razón es: "<?php echo $banData['reason']; ?>", y acabará en <?php echo date('d/m/Y H:i:s', $banData['expire']); ?>. 
								<br /> 
								Tipo de baneo: <?php echo $banData['type']; ?> 
								<br />
									<button onclick="unBan(<?php echo $banData['id']; ?>)">Desbanear</button>
							<?php else: ?>
							
								<h3>Banear</h3>
								<input type="text" id="bReason" placeholder="Razón" value=""></input>
								
								<br />
								
								<select name='user.rank' id="bType" class='styled'>
									<option value="0">Nombre</option>
									<option value="1">IP</option>
								</select>
								
								<br />
								
								<input type="number" min="0" max="12" id="bLenght" value="1"></input>
								
								<select name='user.rank' id="bCount" class='styled'>
									<option value="0">Hora/s</option>
									<option value="1">Día/s</option>
									<option value="2">Mes/s</option>
									<option value="3">Año/s</option>
								</select>
								
								<br />
								
								<button onclick="banUser()">Banear</button>
							<?php endif; ?>

						<!-- CURRENCY USER PAGE -->
						<?php elseif($act === 'coins'): ?>
							<div class="uActions">
								<div class="field">
									<div class="title">Créditos ~ <i>credits</i></div>
									<input type="number" name="credits" min="1" max="500000000" id="uc" value="<?php echo $userRow['credits']; ?>"></input>
									<button onclick="changeCredits()">Cambiar</button>
								</div>

								<div class="field">
									<div class="title">Duckets ~ <i>activity_points</i></div>
									<input type="number" name="duckets" min="1" max="500000000" id="up" value="<?php echo $userRow['activity_points']; ?>"></input>
									<button onclick="changeDuckets()">Cambiar</button>
								</div>

								<div class="field">
									<div class="title">Diamantes ~ <i>vip_points</i></div>
									<input type="number" name="diamonds" min="1" max="500000000" id="ud" value="<?php echo $userRow['vip_points']; ?>"></input>
									<button onclick="changeDiamonds()">Cambiar</button>
								</div>		
							</div>
						
						<!-- BADGE USER PAGE -->
						<?php elseif($act === 'badges'): ?>
							Placas(haz click para seleccionar placa) 
							<br />
							<div id="badgesList">
								<?php 
									$q = SQL::query('SELECT badge_id FROM users_badges WHERE user_id = ' . $key); 
								
									if($q && $q->num_rows > 0): 
										while($bR = $q->fetch_assoc()): 
								?>
											<img id="b-<?php echo $bR['badge_id']; ?>" style="cursor:pointer" onclick="element('#ub').value = '<?php echo $bR['badge_id']; ?>';" src="<?php echo Site::$Settings['badgesPath'] . $bR['badge_id']; ?>.gif" title="<?php echo $bR['badge_id']; ?>"/>
								<?php 
										endwhile;
									endif; 
								?>
							</div>
							<br />
							<input type="text" name="bCode" id="ub" value=""></input> <button onclick="giveBadge()">Dar/Quitar placa</button>

						<!-- BASIC USER PAGE -->
						<?php else: ?>
							<div class="avBase">
								<div class="avImg" style="background-image: url(<?php echo LOOK . $userRow[Server::Get(Server::USER_LOOK_COLUMN)]; ?>&direction=4&head_direction=3&action=wlk&gesture=sml&size=l)"></div>
							</div>

							<div class="uInfo">
								<h3><b>Información:</b></h3>
									Nombre: <?php echo $userRow[Server::Get(Server::USER_NAME_COLUMN)]; ?><br />
									Rango: <?php echo $userRow[Server::Get(Server::USER_RANK_COLUMN)]; ?> - <?php echo (isset(Site::$Ranks[$userRow[Server::Get(Server::USER_RANK_COLUMN)]])) ? Site::$Ranks[$userRow[Server::Get(Server::USER_RANK_COLUMN)]]['Name'] : 'Sin Privilegios'; ?><br />
									IP: <a onclick="element('#i0120').value = '<?php echo $userRow[Server::Get(Server::USER_IP_LAST_COLUMN)]; ?>';SCHclick();" href="javascript:void(0)"><?php echo $userRow[Server::Get(Server::USER_IP_LAST_COLUMN)]; ?></a><br />
							</div>

							<div class="uActions">
								<?php if(User::hasPermission('ase.give_rank') && User::$Data['rank'] > $userRow[Server::Get(Server::USER_RANK_COLUMN)]): ?>
									<div class="field">
										<div class="title">Cambiar Tarea</div>
										<input type="text" name="task" id="uT" value="<?php echo $userRow['task']; ?>" />
										<button onclick="changeTask()">Cambiar</button>
									</div>

									<div class="field">
										<div class="title">Cambiar nombre</div>
										<input type="text" name="userName" id="uN" value="<?php echo $userRow[Server::Get(Server::USER_NAME_COLUMN)]; ?>" />
										<button onclick="changeName()">Cambiar</button>
									</div>
				
									<div class="field">
										<div class="title">Cambiar rango</div>
										<select name='user.rank' id="ur" class='styled'>
										<?php 
											$n = 1;
											
											while($n != User::$Data['rank']):
										
												if($n === MaxRank)
													continue;
										?>
											<option id="ur.<?php echo $n; ?>" value='<?php echo $n; ?>'>
												<?php echo ($n === 1) ? HotelName : (isset(Site::$Ranks[$n]) ? Site::$Ranks[$n]['Name'] : $n); ?>
											</option>
										<?php 
											$n++; 
											endwhile; 
										?>
										</select>
										<button onclick="changeRank()">Cambiar</button>
									</div>

								<?php endif;?>
							</div>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<br />
	<br />
	<br />
	<br />
	<br />
	<script type="text/javascript">
		var uRank = <?php echo User::$Data['rank']; ?>;

		function unBan(userId){
			if(uRank > <?php echo MinRank; ?>){
				get("<?php echo HHURL; ?>/manage?p=users", "POST", showAsyncAlert, "UBuserId=" + userId);
			} else {
				alert("Rango insuficiente");
			}
		}

		function _ChangeText(){
			element('#th1').style = '';
			element('#th1').onclick = '';
			element('#th2').style = '';
			element('#th2').onclick = '';
			element('#th4').style = '';
			element('#th4').onclick = '';
			element('#th6').style = '';
			element('#th6').onclick = '';
				
			if(element("#tableName").value == "logs"){
				element('#titleT').innerHTML = 'Lista de logs';
				element('#th1').innerHTML = 'Id';
				element('#th2').innerHTML = 'Página';
				element('#th3').innerHTML = 'Acción';
				element('#th4').innerHTML = 'Creado';
				element('#th5').innerHTML = '';
				element('#th6').innerHTML = 'EditorID - AfectadoID';
			}else if(element("#tableName").value == "bans"){
				element('#titleT').innerHTML = 'Lista de baneos';
				element('#th1').innerHTML = 'Usuario';
				element('#th2').innerHTML = 'Razón';
				element('#th3').innerHTML = 'Baneado por';
				element('#th4').innerHTML = 'Expiración';
				element('#th5').innerHTML = 'Acciones';
				element('#th6').innerHTML = 'Tipo de baneo';
				
				element('#th2').style = 'min-width:400px';
				element('#th4').style = 'color: #56b9ff;cursor: pointer;';
				element('#th4').onclick =  function() { OrderBy('time') };
				element('#th6').style = 'color: #56b9ff;cursor: pointer;';
				element('#th6').onclick =  function() { OrderBy('type') };
			}else {
				element('#titleT').innerHTML = (element("#tableName").value == "refers") ? 'Lista de referidos' : 'Lista de usuarios';
				element('#th1').innerHTML = 'Id';
				element('#th2').innerHTML = 'Nombre';
				element('#th3').innerHTML = 'Email';
				element('#th4').innerHTML = 'Última vez conectado';
				element('#th5').innerHTML = 'Acciones';
				element('#th6').innerHTML = 'IP';
				
				element('#th1').style = 'color: #56b9ff;cursor: pointer;';
				element('#th1').onclick =  function() { OrderBy('id') };
				element('#th4').style = 'color: #56b9ff;cursor: pointer;';
				element('#th4').onclick =  function() { OrderBy('time') };
			}
		}
		function SCHclick(){
			var sValue = element('#i0120').value;
			window.history.pushState("", "", 'manage?p=users&filter=' + b2h(sValue));

			get("<?php echo HHURL; ?>/manage?p=users&filter=" + b2h(sValue), "POST", SCHclickAsync, "onlyTable=true");
		}
		function SCHclickAsync(m){
			element("#resultTable").innerHTML = this.responseText;
			_ChangeText();
		}
		
		_ChangeText();
		<?php if(isset($editingUser)): ?>
		window.location.hash = '#user-edit';
		<?php endif; ?>
	</script>
<!--END HEADER-->
	</div>
</div>