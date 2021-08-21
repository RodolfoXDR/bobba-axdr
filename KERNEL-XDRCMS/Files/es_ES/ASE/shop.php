<?php 

$PageName = 'Tienda';

$itemsQueryCount = SQL::query('SELECT COUNT(*) FROM xdrcms_shop')->fetch_assoc()['COUNT(*)'];
if($do == 'new' || $do == 'edit' && is_numeric($key) && isset($_POST['item_title'], $_POST['item_code'], $_POST['item_type'], $_POST['item_price_credits'], $_POST['item_price_diamonds'])):
    $itemData = [
        'title' => $_POST['item_title'],
        'code' => $_POST['item_code'],
        'type' => $_POST['item_type'],
        'active' => (isset($_POST['item_active'])) ? $_POST['item_active'] : '0',
        'credits' => $_POST['item_price_credits'],
        'diamonds' => $_POST['item_price_diamonds'],
        'limited' => (isset($_POST['item_limited'])) ? $_POST['item_limited'] : '0',
        'stack' => (isset($_POST['item_limited_stack'])) ? $_POST['item_limited_stack'] : '0',
    ];

    if(!checkAntiCsrf()):
        $msg_error = 'Invalid Secret Key. Please, log in with your secret key.';
    elseif(empty($itemData['title'])):
        $msg_error = 'Por favor, escribe un titulo.';
    elseif(empty($itemData['code'])):
        $msg_error = 'Por favor, escribe un valor en tu objeto.';
    elseif(!is_numeric((int) $itemData['item_limited_stack'])):
        $msg_error = 'El limite de venta debe ser en número.';
    elseif($itemData['type'] == 'furni' && !is_numeric($itemData['code'])):
        $msg_error = 'Has seleccionado \'furni\' entonces tu codigo de baseItem debe ser un número. ';
	else:
		if($do == 'new'):
			if(SQL::query('INSERT INTO xdrcms_shop (title, code, type, active, price_credits, price_diamonds, limited, limited_stack) VALUES (\'' . $itemData['title'] . '\', \'' . $itemData['code'] . '\', \'' . $itemData['type'] . '\', \'' . $itemData['active'] . '\', ' . $itemData['credits'] . ', ' . $itemData['diamonds'] . ', \'' . $itemData['limited'] . '\', ' . $itemData['stack'] . ')')):
				$itemData['id'] = SQL::$insert_id;
				SLOG('Create', 'Creación de objeto "' . $itemData['title'] . '". Id asignada: ' . $itemData['id'], 'manage.php[shop]', 0);
				$msg_correct = 'Objeto agregado a la base de datos de la tienda.';
			endif;
		elseif($do == 'edit'):
			SQL::query('UPDATE xdrcms_shop SET `title`=\'' . $itemData['title'] . '\', `code`=\'' . $itemData['code'] . '\', `type` = \'' . $itemData['type'] . '\', `active` = \'' . $itemData['active'] . '\', `price_credits`=' . $itemData['credits'] . ', `price_diamonds`= ' . $itemData['diamonds'] . ', `limited`= \'' . $itemData['limited'] . '\', `limited_stack`=' . $itemData['stack'] . ' WHERE (`id`= \'' . $key . '\')');
			SLOG('Change', 'Editado el objeto de tienda "' . $itemData['title'] . '". Id del objeto: ' . $key, 'manage.php[shop]', 0);
			$msg_correct = 'Objeto agregado a la base de datos de la tienda.';
		endif;

        Cache::GetShopItems(false);
        unset($itemData);
	endif;
elseif($do == 'remove' && is_numeric($key)):
	SQL::query('DELETE FROM xdrcms_shop WHERE id = ' . $key);
	SLOG('Remove', 'Borrado de un objeto de la tienda. Id del objeto: ' . $key, 'manage.php[shop]', 0);
	Cache::GetShopItems(false);
elseif($do == 'edit' && is_numeric($key) && !isset($_POST['item_title'], $_POST['item_code'], $_POST['item_type'], $_POST['item_price_credits'], $_POST['item_price_diamonds'])):
	$newQuery = SQL::query('SELECT * FROM xdrcms_shop WHERE id = ' . $key);
	$newRow = $newQuery->fetch_assoc();
	if(!User::hasPermission('ase.edit_delete')):
		unset($newRow);
	endif;
endif;

require ASE . 'Header.html';
?>

<table>
    <thead>
        <tr>
            <th id="th1" class="text-left">Id</th>
            <th id="th2" class="text-left">Tipo</th>
            <th id="th3" class="text-left">Titulo</th>
            <th id="th4" class="text-left">Activo</th>
            <th id="th4" class="text-left">Acciones</th>
        </tr>
    </thead>
		
    <tbody>
        <?php
        $itemsQuery = SQL::query('SELECT id, type, title, active FROM xdrcms_shop ORDER BY id ASC LIMIT 15');

        if($itemsQuery !== false && $itemsQuery->num_rows > 0):
            while ($row = $itemsQuery->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td class="right"><?php echo $row['type']; ?></td>
                    <td class="right"><?php echo $row['title']; ?></td>
                    <td class="right"><?php echo ($row['active'] == '1' ? 'activo' : 'desactivado'); ?></td>
                    <td class="right"><?php if(User::hasPermission('ase.edit_delete')): ?><a href="<?php echo HHURL; ?>/manage?p=shop&do=edit&key=<?php echo $row['id']; ?>">Editar</a> || <a href="<?php echo HHURL; ?>/manage?p=shop&do=remove&key=<?php echo $row['id']; ?>">Borrar</a><?php endif; ?></td>
                </tr>
        <?php endwhile; endif; ?>
    </tbody>
</table>

<div style="text-align: center;">
	<button class="control" onclick="ChangePage('first')">&lt;&lt;</button>
	<button class="control" onclick="ChangePage('back')">&lt;</button>
	<button class="control" onclick="ChangePage('next')">&gt;</button>
	<button class="control" onclick="ChangePage('last')">&gt;&gt;</button>
</div>

<div class="accordion" data-role="accordion" data-one-frame="false" data-show-active="false">
    <div class="frame">
        <div class="heading">Crear Objeto en Venta</div>
		<div class="content">
			<form action='<?php echo HHURL; ?>/manage?p=shop&do=new' method='post' name='theAdminForm' id='theAdminForm'>
				<?php echo getAntiCsrf(); ?>
				<table>
					<tbody>
						<tr>
							<td>
								<b>Título</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='text' name='item.title' id='title' value="" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Codigo/BaseItem</b>
								<div class='graytext'>(Ex: ADM, ES018, 78521)</div>
							</td>
							<td>
								<input type='text' name='item.code' id='code' value="" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Tipo</b>
								<div class='graytext'></div>
							</td>
							<td>
								<select id="item.type" name='item.type'>
									<option value='badge'>Placa</option>
									<option value='furni'>Furni</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class='tablerow1' width='20%' valign='middle'><b>Activo</b>
								<div class='graytext'></div>
							</td>
							<td class='tablerow2' valign='middle'>
								<input  id="item.active" name='item.active' type="checkbox" value="1" checked>
							</td>
						</tr>
						<tr>
							<td>
								<b>Precio en Créditos</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='number' name='item.price.credits' id='item.price.credits' value="0" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Precio en Diamantes</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='number' name='item.price.diamonds' id='item.price.diamonds' value="0" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td class='tablerow1' width='20%' valign='middle'><b>Limitado</b>
								<div class='graytext'></div>
							</td>
							<td class='tablerow2' valign='middle'>
								<input  id="item.limited" name='item.limited' type="checkbox" onclick="Checkradiobutton()" value="1">
							</td>
						</tr>
						<tr>
							<td>
								<b>Limite de Venta</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='number' name='item.limited.stack' id='limited.stack' value="0" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td align='right' class='tablesubheader' colspan='2' >
								<input class='realbutton' type="submit" value="Crear" accesskey='s'/>
							</td>
						</tr>
					</tbody>
				</table>
				<?php if(isset($articleData)): ?>
					<script type="text/javascript">
						element("#article.ncategory").selectedIndex = <?php echo $articleData['category']; ?>;
					</script>
				<?php endif; ?>
			</form>
		</div>
	</div>
</div>

<?php if(isset($newRow)): ?>
<div class="accordion" data-role="accordion" data-one-frame="false" data-show-active="false">
    <div class="frame">
        <div class="heading">Editar Objeto #<?php echo $newRow['id']; ?></div>
		<div class="content">
			<form action='<?php echo HHURL; ?>/manage?p=shop&do=edit&key=<?php echo $newRow['id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
				<?php echo getAntiCsrf(); ?>
				<table>
					<tbody>
						<tr>
							<td>
								<b>Título</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='text' name='item.title' id='title' value="<?php echo $newRow['title']; ?>" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Codigo/BaseItem</b>
								<div class='graytext'>(Ex: ADM, ES018, 78521)</div>
							</td>
							<td>
								<input type='text' name='item.code' id='code' value="<?php echo $newRow['code']; ?>" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Tipo</b>
								<div class='graytext'></div>
							</td>
							<td>
								<select id="item.type" name='item.type'>
									<option <?php echo ($newRow['type'] == 'badge') ? 'selected' : ''; ?> value='badge'>Placa</option>
									<option <?php echo ($newRow['type'] == 'furni') ? 'selected' : ''; ?> value='furni'>Furni</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class='tablerow1' width='20%' valign='middle'><b>Activo</b>
								<div class='graytext'></div>
							</td>
							<td class='tablerow2' valign='middle'>
								<input  id="item.active" name='item.active' type="checkbox" value="1" <?php echo ($newRow['active'] == '1') ? 'checked' : ''; ?>>
							</td>
						</tr>
						<tr>
							<td>
								<b>Precio en Créditos</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='number' name='item.price.credits' id='item.price.credits' value="<?php echo $newRow['price_credits']; ?>" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td>
								<b>Precio en Diamantes</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='number' name='item.price.diamonds' id='item.price.diamonds' value="<?php echo $newRow['price_diamonds']; ?>" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td class='tablerow1' width='20%' valign='middle'><b>Limitado</b>
								<div class='graytext'></div>
							</td>
							<td class='tablerow2' valign='middle'>
								<input  id="item.nlimited" name='item.limited' type="checkbox" onclick="Checkradiobutton2()" value="1" <?php echo ($newRow['limited'] == '1') ? 'checked' : ''; ?>>
							</td>
						</tr>
						<tr>
							<td>
								<b>Limite de Venta</b>
								<div class='graytext'></div>
							</td>
							<td>
								<input type='number' name='item.limited.stack' id='nlimited.stack' value="<?php echo $newRow['limited_stack']; ?>" size='30' class='textinput'>
							</td>
						</tr>
						<tr>
							<td align='right' class='tablesubheader' colspan='2' >
								<input class='realbutton' type="submit" value="Crear" accesskey='s'/>
							</td>
						</tr>
					</tbody>
				</table>
				<?php if(isset($articleData)): ?>
					<script type="text/javascript">
						element("#article.ncategory").selectedIndex = <?php echo $articleData['category']; ?>;
					</script>
				<?php endif; ?>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>
    
    <script type="text/javascript">
        window.onload = Checkradiobutton();
		
		if(element("#nlimited.stack") != null)
       		window.onload = Checkradiobutton2();
            
        function Checkradiobutton() {
            element("#limited.stack").disabled=(element("#item.limited").checked) ? false : true;
        }

		function Checkradiobutton2() {
            element("#nlimited.stack").disabled=(element("#item.nlimited").checked) ? false : true;
        }
    </script>