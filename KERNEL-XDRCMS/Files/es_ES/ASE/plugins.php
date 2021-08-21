<?php
$PageName = 'Plugins';

$pluginsQueryCount = SQL::query('SELECT COUNT(*) FROM xdrcms_plugins')->fetch_assoc()['COUNT(*)'];

if(isset($_GET['filter'])):
	$_GET['filter'] = hex2bin($_GET['filter']);
	$Search = str_replace('\\', '&#92;', htmlentities($_GET['filter'], ENT_HTML401 | ENT_QUOTES, METHOD::GetCharset($_GET['filter'])));

	$queryOptions = '';
	$orderOption = 'DESC';
	$limitOption = 15;
	$pageOption = 1;

	// SEARCH FILTER 0.4 Beta
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

	//PLUGINS QUERY
	$pluginsQuery = SQL::query('SELECT Id, Title, OwnerID, TimeCreated FROM xdrcms_plugins LIMIT ' . $_Page . ',' . $limitOption . '');
	$DataHTML = '<input type="hidden" id="pluginsTotal" value="' . $pluginsQueryCount . '" /><input type="hidden" id="nowPage" value="' . $pageOption . '" /><input type="hidden" id="resultCount" value="' . $limitOption . '" />';

	if($pluginsQuery && $pluginsQuery->num_rows > 0):
		while($Row = $pluginsQuery->fetch_assoc()):
			$DataHTML .= '
			<tr>
			<td>' . $Row['Id'] . '</td>
			<td class="right">' . $Row['Title'] . '</td>
			<td class="right">' . User::GetNameById($Row['OwnerID']) . '</td>
			<td class="right">' . (($Row['OwnerID'] == User::$Data['id'] || User::hasPermission('ase.edit_delete')) ? '<a href="' .  HHURL . '/manage?p=articles&do=edit&key=' . $Row['ID'] . '">Editar</a> || <a href="' . HHURL . '/manage?p=articles&do=remove&key=' . $Row['ID'] . '">Borrar</a>' : '') . '</td>
			</tr>
			';			
		endwhile;
	else:
		$DataHTML .= 'No se han encontrado plugins.';
	endif;

	if(isset($_POST['onlyTable'])):
		echo $DataHTML;
		exit;
	endif;

endif;

if(($do === 'new' || ($do === 'edit' && is_numeric($key))) && isset($_POST['plugin_title'], $_POST['plugin_position'], $_POST['plugin_color'], $_POST['plugin_minrank'], $_POST['plugin_template'], $_POST['plugin_cDisable'])):
	$PluginData = [
		'Title' => $_POST['plugin_title'],
		'Position' => $_POST['plugin_position'],
		'Color' => $_POST['plugin_color'],
		'minRank' => $_POST['plugin_minrank'],
		'Template' => $_POST['plugin_template'] == '1' ? '1' : '0',
		'canDisable' => $_POST['plugin_cDisable'] == '1' ? '1' : '0',
		'canDelete' => '1',
		'body' => ((isset($_POST['plugin_html'])) ? str_ireplace(['php','<?'], ['&#112;hp','&lt;?'], html_entity_decode(html_entity_decode($_POST['plugin_html'], ENT_QUOTES | ENT_HTML401, 'ISO-8859-1'), ENT_QUOTES, 'ISO-8859-1')) : '')
	];

	if(!checkAntiCsrf()):
		$msg_error = 'An error occurred. Security token failed.';
	elseif(strlen($PluginData['Title']) < 4):
		$msg_error = 'An error occurred. Title is too short.';
	elseif(!is_numeric($PluginData['Position']) || !is_numeric($PluginData['Color']) || !is_numeric($PluginData['minRank']) || !is_numeric($_POST['plugin_template']) || $PluginData['Position'] < 0 || $PluginData['Position'] > 9 || $PluginData['Color'] < 0 || $PluginData['Color'] > 9 || $PluginData['minRank'] < 0 || $PluginData['minRank'] > MaxRank):
		$msg_error = 'An error occurred.';
	else:
		if($do === 'new'):
			if(SQL::query('INSERT INTO xdrcms_plugins (Title, Position, Color, minRank, Template, OwnerID, canDelete, canDisable) VALUES (\'' . $PluginData['Title'] . '\', \'' . $PluginData['Position'] . '\', \'' . $PluginData['Color'] . '\', \'' . $PluginData['minRank'] . '\', \'' . $PluginData['Template'] . '\', ' . User::$Data['id'] . ', \'' . $PluginData['canDelete'] . '\', \'' . $PluginData['canDisable'] . '\')')):
				
				$PluginId = SQL::$insert_id;
				Cache::Write(KERNEL . '/Cache/Plugin.' . $PluginId . '.html', $PluginData['body']);
				Cache::LoadPositionPlugins($PluginData['Position']);
				SLOG('Create', 'Creación del plugin "' . $PluginData['Title'] . '". Id asignada: ' . $PluginId, 'manage.php[plugins]', 0);
				$msg_correct = 'Se ha creado un plugin con éxito.';
				unset($PluginData);
			endif;
		elseif($do === 'edit'):
			if(SQL::query('UPDATE xdrcms_plugins SET Title = \'' . $PluginData['Title'] . '\', Position = ' . $PluginData['Position'] . ', Color = ' . $PluginData['Color'] . ', minRank = ' . $PluginData['minRank'] . ', Template = \'' . $PluginData['Template'] . '\', canDisable = ' . $PluginData['canDisable'] . ' WHERE Id = ' . $key)):
				Cache::Write(KERNEL . '/Cache/Plugin.' . $key . '.html', $PluginData['body']);
				Cache::LoadPositionPlugins($PluginData['Position']);

				if($PluginData['Position'] !== $_SESSION['pluginLastEdit'][1])
					Cache::LoadPositionPlugins($_SESSION['pluginLastEdit'][1]);

				SLOG('Change', 'Editado el plugin "' . $PluginData['Title'] . '". Id del plugin: ' . $key, 'manage.php[plugins]', 0);
				$msg_correct = 'El plugin se ha editado correctamente.';
				unset($PluginData);
				unset($pluginRow);
			endif;
		endif;
	endif;
elseif(($do === 'edit' && is_numeric($key)) && !isset($_POST['plugin_title'], $_POST['plugin_position'], $_POST['plugin_color'], $_POST['plugin_minrank'], $_POST['plugin_template'], $_POST['plugin_cDisable'])):
	$pluginQuery = SQL::query('SELECT * FROM xdrcms_plugins WHERE Id = ' . $key);
	$pluginRow = $pluginQuery->fetch_assoc();
	$pluginRow['HTML'] = Cache::Read(KERNEL . '/Cache/Plugin.' . $key . '.html');
	$_SESSION['pluginLastEdit'] = [$key, $pluginRow['Position']];
	if($pluginRow['OwnerID'] != User::$Data['id'] && !User::hasPermission('ase.edit_delete')):
		unset($pluginRow);
	endif;
elseif($do == 'remove' && is_numeric($key)):
	$query = SQL::query('SELECT Position, canDelete FROM xdrcms_plugins WHERE Id = ' . $key);
	if($query && $query->num_rows == 1):
		$row = $query->fetch_assoc();
		if($row['canDelete'] == 1):
			SQL::query('DELETE FROM xdrcms_plugins WHERE canDelete = \'1\' AND Id = ' . $key);
			SLOG('Remove', 'Borrado de un plugin. Id del plugin: ' . $key, 'manage.php[plugins]', 0);
			Cache::Delete(KERNEL . '/Cache/Plugin.' . $key . '.html');
			Cache::LoadPositionPlugins($row['Position']);
			$msg_correct = 'Se ha eliminado el plugin correctamente.';
		else:
			$msg_error = 'Este plugin no puede ser eliminado.';
		endif;
	endif;
endif;

require ASE . 'Header.html';
?>

		<table>
				<thead>
					<tr>
						<th id="th1" class="text-left">Id</th>
						<th id="th2" class="text-left">Título</th>
						<th id="th3" class="text-left">Creador</th>
						<th id="th4" class="text-left">Acciones</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					$pluginsQuery = SQL::query('SELECT Id, Title, OwnerID, canDelete FROM xdrcms_plugins ORDER BY Id ASC LIMIT 15');

					if($pluginsQuery !== false && $pluginsQuery->num_rows > 0):
						while ($row = $pluginsQuery->fetch_assoc()): ?>
							<tr>
								<td><?php echo $row['Id']; ?></td>
								<td class="right"><?php echo $row['Title']; ?></td>
								<td class="right"><?php echo User::GetNameById($row['OwnerID']); ?></td>
								<td class="right"><?php if($row['OwnerID'] == User::$Data['id'] || User::hasPermission('ase.edit_delete')): ?><a href="<?php echo HHURL; ?>/manage?p=plugins&do=edit&key=<?php echo $row['Id']; ?>">Editar</a> <?php if($row['canDelete'] == '1'): ?>|| <a href="<?php echo HHURL; ?>/manage?p=plugins&do=remove&key=<?php echo $row['Id']; ?>">Borrar</a><?php endif; endif;?></td>
							</tr>
					<?php endwhile; else: ?>
						<tr>
							<td>No hay plugins creados.</td>
						</tr>
					<?php endif; ?>
				</tbody>
		</table>

		<div style="text-align: center;">
			<button class="control" onclick="ChangePage('first')">&lt;&lt;</button>
			<button class="control" onclick="ChangePage('back')">&lt;</button>
			<button class="control" onclick="ChangePage('next')">&gt;</button>
			<button class="control" onclick="ChangePage('last')">&gt;&gt;</button>
		</div>

		<div class="accordion" data-role="accordion" data-one-frame="false"  data-show-active="false">
			<div class="frame">
				<div class="heading">Crear Plugin</div>
				<div class="content">
					<form action='<?php echo HHURL; ?>/manage?p=plugins&do=new' method='post' name='theAdminForm' id='theAdminForm'>
						<?php echo getAntiCsrf(); ?>
						<table width='100%' cellpadding='5' align='left' border='0'>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Título</b>
									<div class='graytext'>
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<input type='text' name='plugin.title' id='title' value="" size='30' class='textinput'>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Lugar</b>
									<div class='graytext'>
										Posición del Plugin
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<select id='plugin.nposition' name='plugin.position'>
										<option value='0'>Index</option>
										<option value='1'>Home - Arriba del Perfil</option>
										<option value='2'>Home - Abajo del Perfil</option>
										<option value='3'>Home - Abajo de las Promos | Izquierda</option>
										<option value='4'>Home - Abajo de las Promos | Derecha</option>
										<option value='5'>Todo - Column 3</option>
										<option value='6'>Todo - Footer</option>
										<option value='7'>Community - Izquierda</option>
										<option value='8'>Community - Derecha</option>
										<option value='9'>Staffs - Derecha</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Rango</b>
									<div class='graytext'>
										Mínimo
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<select id="plugin.nminrank" name='plugin.minrank'>
										<option value='0'>Plugin Desactivado</option>
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
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Cuadro</b>
									<div class='graytext'>
										Usar cuadro de Habbo.
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<label class="container">Usar&nbsp;&nbsp;
										<input id="plugin.ntemplate" name='plugin.template' type="checkbox" value="1" />
									</label>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Color (Cuadro requerido)</b>
									<div class='graytext'>
										Elige el color del plugin:
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<select id="plugin.ncolor" name='plugin.color'>
										<option value='0'>Blanco</option>
										<option value='1'>Negro</option>
										<option value='2'>Azul</option>
										<option value='3'>Azul claro</option>
										<option value='4'>Rojo</option>
										<option value='5'>Verde</option>
										<option value='6'>Amárillo</option>
										<option value='7'>Naranja</option>
										<option value='8'>Marrón</option>
										<option value='9'>Gris</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Desactivable</b>
									<div class='graytext'>
										Sí los usuarios pueden desactivar el plugin desde Ajustes.
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<label class="container">Desactivable&nbsp;&nbsp;
										<input  id="plugin.ncDisable" name='plugin.cDisable' type="checkbox" value="1">
									</label>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>HTML/JS/CSS</b>
									<div class='graytext'>
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<textarea name='plugin.html' cols='100' rows='5' wrap='soft' id='sub_desc' class='multitext'>
									</textarea>
								</td>
							</tr>
							<tr>
								<td align='right' class='tablesubheader' colspan='2' >
									<input class='realbutton' type="submit" value="Crear" accesskey='s'/>
								</td>
							</tr>
						</table>
						<?php if(isset($PluginData)): ?>
							<script type="text/javascript">
								element('#plugin.nposition').selectedIndex = <?php echo $PluginData['Position']; ?>;
								element('#plugin.ncolor').selectedIndex = <?php echo $PluginData['Color']; ?>;
								element('#plugin.nrank').selectedIndex = <?php echo $PluginData['minRank']; ?>;
								element('#plugin.ntemplate').selectedIndex = <?php echo $PluginData['Template']; ?>;
								element('#plugin.ncDisable').selectedIndex = <?php echo $PluginData['canDisable']; ?>;
							</script>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>

		<?php if(isset($pluginRow)): ?>
		<div class="accordion" data-role="accordion" data-one-frame="false" data-show-active="true">
			<div class="frame">
				<div class="heading">Editar Plugin ID: <?php echo $key; ?></div>
				<div class="content">
					<form action='<?php echo HHURL; ?>/manage?p=plugins&do=edit&key=<?php echo $pluginRow['Id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
						<?php echo getAntiCsrf(); ?>
						<table width='100%' cellpadding='5' align='left' border='0'>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Título</b>
									<div class='graytext'>
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<input type='text' name='plugin.title' id='title' value="<?php echo $pluginRow['Title']; ?>" size='30' class='textinput'>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Lugar</b>
									<div class='graytext'>
										Posición del Plugin
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<select id='plugin.position' name='plugin.position'>
										<option value='0'>Index</option>
										<option value='1'>Home - Arriba del Perfil</option>
										<option value='2'>Home - Abajo del Perfil</option>
										<option value='3'>Home - Abajo de las Promos | Izquierda</option>
										<option value='4'>Home - Abajo de las Promos | Derecha</option>
										<option value='5'>Todo - Column 3</option>
										<option value='6'>Todo - Footer</option>
										<option value='7'>Community - Izquierda</option>
										<option value='8'>Community - Derecha</option>
										<option value='9'>Staffs - Derecha</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Rango</b>
									<div class='graytext'>
										Mínimo
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<select id="plugin.minrank" name='plugin.minrank'>
										<option value='0'>Plugin Desactivado</option>
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
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Cuadro</b>
									<div class='graytext'>
										Usar cuadro de Habbo.
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<label class="container">Usar&nbsp;&nbsp;
										<input id="plugin.template" name='plugin.template' type="checkbox" value="1" />
									</label>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Color (Cuadro requerido)</b>
									<div class='graytext'>
										Elige el color del plugin:
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<select id="plugin.color" name='plugin.color'>
										<option value='0'>Blanco</option>
										<option value='1'>Negro</option>
										<option value='2'>Azul</option>
										<option value='3'>Azul claro</option>
										<option value='4'>Rojo</option>
										<option value='5'>Verde</option>
										<option value='6'>Amárillo</option>
										<option value='7'>Naranja</option>
										<option value='8'>Marrón</option>
										<option value='9'>Gris</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>Desactivable</b>
									<div class='graytext'>
										Sí los usuarios pueden desactivar el plugin desde Ajustes.
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<label class="container">Desactivable&nbsp;&nbsp;
										<input  id="plugin.cDisable" name='plugin.cDisable' type="checkbox" value="1">
									</label>
								</td>
							</tr>
							<?php if($pluginRow['canDelete'] == '1'): ?>
							<tr>
								<td class='tablerow1' width='20%' valign='middle'><b>HTML/JS/CSS</b>
									<div class='graytext'>
									</div>
								</td>
								<td class='tablerow2' valign='middle'>
									<textarea name='plugin.html' cols='100' rows='5' wrap='soft' id='sub_desc' class='multitext'>
										<?php echo $pluginRow['HTML']; ?>
									</textarea>
								</td>
							</tr>
							<?php endif; ?>
							<tr>
								<td align='right' class='tablesubheader' colspan='2' >
									<input class='realbutton' type="submit" value="Crear" accesskey='s'/>
								</td>
							</tr>
						</table>
						<script type="text/javascript">
							element('#plugin.position').selectedIndex = <?php echo $pluginRow['Position']; ?>;
							element('#plugin.color').selectedIndex = <?php echo $pluginRow['Color']; ?>;
							element('#plugin.minrank').selectedIndex = <?php echo $pluginRow['minRank']; ?>;
							element('#plugin.template').selectedIndex = <?php echo $pluginRow['Template']; ?>;
							element('#plugin.cDisable').selectedIndex = <?php echo $pluginRow['canDisable']; ?>;
						</script>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>

<!--END HEADER-->
	</div>
</div>