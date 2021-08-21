<?php
$PageName = 'Catalogo <sub> Sub Sub Main Sections </sub>';

require ASE . 'Header.html';

if($do == 'edit' && is_numeric($key) && isset($_POST['catalog_caption'], $_POST['catalog_parentid'], $_POST['catalog_ordernum'], $_POST['catalog_minrank'], $_POST['catalog_visible'], $_POST['catalog_enabled'])):
	$catalogData = [
		'caption' => $_POST['catalog_caption'],
		'parentid' => $_POST['catalog_parentid'],
		'ordernum' => $_POST['catalog_ordernum'],
		'minrank' => $_POST['catalog_minrank'],
		'visible' => $_POST['catalog_visible'],
		'enabled' => $_POST['catalog_enabled']
	];
		
	if(!checkAntiCsrf()):
		$msg_error = 'Invalid Secret Key. Please, log in with your secret key.';
	elseif(strlen($_POST['catalog_caption']) < 3):
		$msg_error = 'Caption es muy corto.';
	elseif(!(Tool::isNumeric($_POST['catalog_parentid']))):
		$msg_error = 'Parent ID no es numerico';
	elseif(!(Tool::isNumeric($_POST['catalog_ordernum']))):
		$msg_error = 'Order Number no es numerico.';
	elseif(!(Tool::isNumeric($_POST['catalog_minrank']))):
		$msg_error = 'Error en Catalog Min Rank.';
	elseif(!(Tool::isNumeric($_POST['catalog_visible']))):
		$msg_error = 'Error en Catalog Visible.';
	elseif(!(Tool::isNumeric($_POST['catalog_enabled']))):
		$msg_error = 'Error en Catalog Enabled.';
	else: 
		if($do == 'edit'):
			SQL::query('UPDATE catalog_pages SET caption = \'' . $catalogData['caption'] . '\', parent_id = ' . $catalogData['parentid'] . ', order_num = ' . $catalogData['ordernum'] . ', min_rank = ' . $catalogData['minrank'] . ', visible = \'' . $catalogData['visible'] . '\', enabled = \'' . $catalogData['enabled'] . '\' WHERE id = ' . $key);
			SLOG('Update', 'Cambiado los valores de una página de catalogo', 'manage.php[catalog]', $key);
			$msg_correct = 'Los cambios han sido guardados con éxito.';
			$catalogData['id'] = $key; 
			Socket::send('updateCatalogue');
		endif;
		
		unset($catalogData);
	endif;
	
	if(isset($msg_error) && $do == 'edit'):
		$catalogQuery = SQL::query('SELECT * FROM catalog_pages WHERE id = ' . $key);
		$catalogRow = $catalogQuery->fetch_assoc();

		unset($catalogData);
	endif;
elseif($do == 'edit' && is_numeric($key) && !isset($_POST['catalog_caption'], $_POST['catalog_parentid'], $_POST['catalog_ordernum'], $_POST['catalog_minrank'], $_POST['catalog_visible'], $_POST['catalog_enabled'])):
		$newQuery = SQL::query('SELECT * FROM catalog_pages WHERE id = ' . $key);
		$newRow = $newQuery->fetch_assoc();
		if(!User::hasPermission('ase.edit_delete')):
			unset($newRow);
		endif;
endif;

if(isset($_GET['filter'])):
	$parentid= $_GET['filter'];
	
	$filterQuery = SQL::query('SELECT * FROM catalog_pages WHERE parent_id = ' . $parentid . ' ORDER BY order_num ASC');
	
	$DataHTML = '';
	
	if($filterQuery && $filterQuery->num_rows > 0):
		while ($Row = $filterQuery->fetch_assoc()):
			$DataHTML .= '<tr class="hover">
								<td>' . $Row['id'] . '</td>
								<td class="right">' . $Row['caption'] . '</td>
								<td class="right">' . $Row['parent_id'] . '</td>
								<td class="right">' . ($Row['enabled'] == '1' ? 'true' : 'false') . '</td>
								<td class="right">' . $Row['min_rank'] . '</td>
								<td class="right"><a href="' . HHURL . '/manage?p=catalog_ssm&filter=' . $parentid . '&do=edit&key=' . $Row['id']. '">Editar</a></td>
							</tr>';
		endwhile;
	else:
		$DataHTML = 'No se encontraron resultados con este parent id';
	endif;
	
endif;
?>
<a href="<?php echo HHURL; ?>/manage?p=catalog">Regresar</a>
<table>
		<thead>
			<tr>
				<th id="th1" class="text-left">Id</th>
				<th id="th2" class="text-left">Caption</th>
				<th id="th2" class="text-left">Parent ID</th>
				<th id="th3" class="text-left">Enable</th>
				<th id="th4" class="text-left">Minimum Rank</th>
				<th id="th4" class="text-left">Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if(!isset($DataHTML)):
			$GrandParentQuery = SQL::query("SELECT * FROM catalog_pages WHERE parent_id = -1");

			if($GrandParentQuery->num_rows > 0):
				while ($GrandParentRows = $GrandParentQuery->fetch_assoc()):
					$ParentQuery = SQL::query('SELECT * FROM catalog_pages WHERE parent_id = \'' . $GrandParentRows['id'] . '\'');
					if($ParentQuery->num_rows > 0):
						while($ParentRows = $ParentQuery->fetch_assoc()):
							$ChildQuery = SQL::query('SELECT * FROM catalog_pages WHERE parent_id = \'' . $ParentRows['id'] . '\'');
							if($ChildQuery->num_rows > 0):
								while($row = $ChildQuery->fetch_assoc()):
			?>
							<tr class="hover">
								<td><?php echo $row['id']; ?></td>
								<td class="right"><?php echo $row['caption']; ?></td>
								<td class="right"><?php echo $row['parent_id']; ?></td>
								<td class="right"><?php echo ($row['enabled'] == '1' ? 'true' : 'false'); ?></td>
								<td class="right"><?php echo $row['min_rank']; ?></td>
								<td class="right"><?php if(User::hasPermission('ase.edit_delete')): ?><a href="<?php echo HHURL; ?>/manage?p=catalog_ssm&do=edit&key=<?php echo $row['id']; ?>">Editar</a><?php endif; ?></td>
							</tr>
			<?php endwhile; endif; endwhile; endif; endwhile; endif; else: echo $DataHTML; endif;?>
		</tbody>
</table>

<?php if(isset($newRow)):?>
<ul class="concertina" id="accordionid" data-role="accordion">
	<li class="concertinali">
		<div class="concertinattl"> Editar página #<?php echo $key; ?></div>
		<div class="concertinaccn">
			<form action='<?php echo HHURL; ?>/manage?p=catalog_ssm&filter=<?php echo $newRow['parent_id']; ?>&do=edit&key=<?php echo $key; ?>' method='post' name='theAdminForm' id='theAdminForm'>
				<?php echo getAntiCsrf(); ?>
				<table>
					<tbody>
						<tr>
							<td>
								<b>Caption</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='text' name='catalog.caption' id='catalog.caption' value="<?php echo $newRow['caption']; ?>" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Parent ID</b>
								<div class='graytext'>Elige bajo que ID estará esta página. (-1 es una página Principal)</div>
							</td>
							<td>
								<input type='text' name='catalog.parentid' id='catalog.parentid' value="<?php echo $newRow['parent_id']; ?>" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Order Number</b>
								<div class='graytext'>Elige el numero de orden que quieras colocar la página.</div>
							</td>
							<td>
								<input type='text' name='catalog.ordernum' id='catalog.ordernum' value="<?php echo $newRow['order_num']; ?>" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Rango Minimo</b>
								<div class='graytext'>Elige el Rango Minimo para ver esta sección.</div>
							</td>
							<td>
									<select name='catalog.minrank' id="catalog.minrank">
									<?php $n = 1; while($n <= User::$Data['rank']):  ?>
										<option value='<?php echo $n; ?>' <?php echo (($n == $newRow['min_rank']) ? 'selected' : ''); ?>><?php echo ($n === 1)? HotelName : (isset(Config::$Ranks['rights'][$n]) ? Config::$Ranks['rights'][$n][0] : $n); ?></option>
									<?php $n++; endwhile; ?>
									</select>
							</td>
						</tr>
						<tr>
							<td>
								<b>Visible</b>
								<div class='graytext'>¿Visualizar esta categoria?</div>
							</td>
							<td>
								<select id="catalog.visible" name='catalog.visible'>
									<option value='0' <?php echo (($newRow['visible'] == '0') ? 'selected' : ''); ?>>Invisible</option>
									<option value='1' <?php echo (($newRow['visible'] == '1') ? 'selected' : ''); ?>>Visible</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<b>Enabled</b>
								<div class='graytext'>¿Habilitar esta página?</div>
							</td>
							<td>
								<select id="catalog.enabled" name='catalog.enabled'>
									<option value='0' <?php echo (($newRow['enabled'] == '0') ? 'selected' : ''); ?>>Deshabilitado</option>
									<option value='1' <?php echo (($newRow['enabled'] == '1') ? 'selected' : ''); ?>>Habilitado</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align='right' class='tablesubheader' colspan='2' >
								<input class='realbutton' type="submit" value="Guardar" accesskey='s'/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</li>
</ul>
<?php endif; ?>