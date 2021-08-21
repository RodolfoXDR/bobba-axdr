<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<?php
	$PageName = 'Artículos';

	$articlesQueryCount = SQL::query('SELECT COUNT(*) FROM xdrcms_news')->fetch_assoc()['COUNT(*)'];

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

		//ARTICLES QUERY
		$articlesQuery = SQL::query('SELECT Id, Title, OwnerID, TimeCreated FROM xdrcms_news LIMIT ' . $_Page . ',' . $limitOption . '');
		$DataHTML = '<input type="hidden" id="usersTotal" value="' . $articlesQueryCount . '" /><input type="hidden" id="nowPage" value="' . $pageOption . '" /><input type="hidden" id="resultCount" value="' . $limitOption . '" />';

		if($articlesQuery && $articlesQuery->num_rows > 0):
			while ($Row = $articlesQuery->fetch_assoc()):
				$DataHTML .= '
					<tr>
					<td>' . $Row['Id'] . '</td>
					<td class="right">' . $Row['Title'] . '</td>
					<td class="right">' . User::GetNameById($Row['OwnerID']) . '</td>
					<td class="right" title="' . (is_numeric($Row['TimeCreated'])) ? date('d-M-o G:i:s', $Row['TimeCreated']) : '--' . '">' . Tool::ParseUnixTime($Row['TimeCreated']) . '</td>
					<td class="right">' . (($Row['OwnerID'] == User::$Data['id'] || User::hasPermission('ase.edit_delete')) ? '<a href="' .  HHURL . '/manage?p=articles&do=edit&key=' . $Row['ID'] . '">Editar</a> || <a href="' . HHURL . '/manage?p=articles&do=remove&key=' . $Row['ID'] . '">Borrar</a>' : '') . '</td>
					</tr>
					';
			endwhile;
		else:
			$DataHTML .= 'No se han encontrado artículos.';
		endif;

		if(isset($_POST['onlyTable'])):
			echo $DataHTML;
			exit;
		endif;
	endif;

	if(($do == 'new' || ($do == 'edit' && is_numeric($key))) && isset($_POST['article_title'], $_POST['article_category'], $_POST['article_summary'], $_POST['article_backgroundimage'], $_POST['article_body'])):
		$articleData = [
			'title' => $_POST['article_title'],
			'category' => $_POST['article_category'],
			'summary' => $_POST['article_summary'],
			'img' => $_POST['article_backgroundimage'],
			'body' => $_POST['article_body']
		];
		if(!checkAntiCsrf()):
			$msg_error = 'Invalid Secret Key. Please, log in with your secret key.';
		elseif(strlen($_POST['article_title']) < 5 || !is_numeric($_POST['article_category'])):
			$msg_error = 'El título es muy corto.';
		else:
			if($do == 'new'):
				if(SQL::query('INSERT INTO xdrcms_news (Title, Summary, Body, BackGroundImage, TimeCreated, Category, OwnerID) VALUES (\'' . $_POST['article_title'] . '\', \'' . $_POST['article_summary'] . '\', \'' . $_POST['article_body'] . '\', \'' . $_POST['article_backgroundimage'] . '\', ' . time() . ', ' . $_POST['article_category'] . ', ' . User::$Data['id'] . ')')):
					$articleData['id'] = SQL::$insert_id; 
					SLOG('Create', 'Creación del artículo "' . $_POST['article_title'] . '". Id asignada: ' . $articleData['id'], 'manage.php[articles]', 0);
					$msg_correct = 'Se ha creado un artículo con éxito.';
				endif;
			elseif($do == 'edit'):
				SQL::query('UPDATE xdrcms_news SET Title = \'' . $_POST['article_title'] . '\', Summary = \'' . $_POST['article_summary'] . '\', Body = \'' . $_POST['article_body'] . '\', Category = ' . $_POST['article_category'] . ', BackGroundImage = \'' . $_POST['article_backgroundimage'] . '\' WHERE ID = ' . $key . (!User::hasPermission('ase.edit_delete') ? ' AND OwnerID = ' . User::$Data['id'] : ''));
				SLOG('Change', 'Editado del artículo "' . $_POST['article_title'] . '". Id del artículo: ' . $key, 'manage.php[articles]', 0);
				$msg_correct = 'Los cambios han sido guardados con éxito.';
				$articleData['id'] = $key; 
			endif;
			
			Cache::SetAIOConfig('LastArticle', $articleData);
			Cache::GetArticles(false);
			unset($articleData);
		endif;
		
		if(isset($msg_error) && $do == 'edit'):
			$promoQuery = SQL::query('SELECT * FROM xdrcms_promos WHERE ID = ' . $key);
			$promoRow = $promoQuery->fetch_assoc();

			unset($articleData);
		endif;
	elseif($do == 'remove' && is_numeric($key)):
		SQL::query('DELETE FROM xdrcms_news WHERE ID = ' . $key . (!User::hasPermission('ase.edit_delete') ? ' AND OwnerID = ' . User::$Data['id'] : ''));
		SLOG('Remove', 'Borrado de un artículo. Id del artículo: ' . $key, 'manage.php[articles]', 0);
		Cache::GetArticles(false);
	elseif($do == 'edit' && is_numeric($key) && !isset($_POST['promo_title'], $_POST['promo_color'], $_POST['promo_desc'], $_POST['promo_img'], $_POST['promo_exp'])):
		$newQuery = SQL::query('SELECT * FROM xdrcms_news WHERE Id = ' . $key);
		$newRow = $newQuery->fetch_assoc();
		if($newRow['OwnerID'] != User::$Data['id'] && !User::hasPermission('ase.edit_delete')):
			unset($newRow);
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
				<th id="th4" class="text-left">Creado</th>
				<th id="th4" class="text-left">Acciones</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
			$promosQuery = SQL::query('SELECT ID, Title, OwnerID, TimeCreated FROM xdrcms_news ORDER BY id ASC LIMIT 15');

			if($promosQuery !== false && $promosQuery->num_rows > 0):
				while ($row = $promosQuery->fetch_assoc()): ?>
					<tr>
						<td><?php echo $row['ID']; ?></td>
						<td class="right"><?php echo $row['Title']; ?></td>
						<td class="right"><?php echo User::GetNameById($row['OwnerID']); ?></td>
						<td class="right" title="<?php echo (is_numeric($row['TimeCreated'])) ? date('d-M-o G:i:s', $row['TimeCreated']) : '--'; ?>"><?php echo Tool::ParseUnixTime($row['TimeCreated']); ?></td>
						<td class="right"><?php if($row['OwnerID'] == User::$Data['id'] || User::hasPermission('ase.edit_delete')): ?><a href="<?php echo HHURL; ?>/manage?p=articles&do=edit&key=<?php echo $row['ID']; ?>">Editar</a> || <a href="<?php echo HHURL; ?>/manage?p=articles&do=remove&key=<?php echo $row['ID']; ?>">Borrar</a><?php endif; ?></td>
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

	<div class="accordion" data-role="accordion" data-one-frame="false" data-show-active="<?php echo (isset($articleData)) ? 'true' : 'false'; ?>">
		<div class="frame">
			<div class="heading">Crear artículo</div>
			<div class="content">
				<form action='<?php echo HHURL; ?>/manage?p=articles&do=new' method='post' name='theAdminForm' id='theAdminForm'>
					<?php echo getAntiCsrf(); ?>
					<table>
						<tbody>
							<tr>
								<td>
									<b>Título</b>
									<div class='graytext'></div>
								</td>
								<td>
									<input type='text' name='article.title' id='title' value="<?php echo (isset($articleData)) ? $articleData["title"] : ""; ?>" size='30' class='textinput'>
								</td>
							</tr>
							<tr>
								<td>
									<b>Categoría</b>
									<div class='graytext'></div>
								</td>
								<td>
									<select id="article.ncategory" id="colorv" name='article.category'>
										<option value='0'>Otros</option>
										<option value='1'>Actualizaciones</option>
										<option value='2'>Competiciones & encuestas</option>
										<option value='3'>Eventos</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<b>Descripción</b>
									<div class='graytext'></div>
								</td>
								<td class='tablerow2' width='40%'  valign='middle'>
									<textarea name='article.summary' cols='100' rows='3' wrap='soft' id='sub_desc' class='multitext'><?php echo (isset($articleData)) ? $articleData['summary'] : ''; ?></textarea>
								</td>
							</tr>
							<tr>
								<td>
									<b>Imágen</b>
									<div class='graytext'>
										<img src="<?php echo (isset($articleData)) ? $articleData['img'] : ''; ?>" id="imageid" height="128" width="128"> 
									</div>
								</td>
								<td>
									<input type='text' name='article.backgroundimage' id='imageurl' value="<?php echo (isset($articleData)) ? $articleData['img'] : ''; ?>" size='100' class='textinput' onchange="ChangeImage('imageid', 'imageurl', '')">
								</td>
							</tr>
							<tr>
								<td>
									<b>Desarrollo</b>
									<div class='graytext'></div>
								</td>
								<td>
									<script type="text/javascript">
										tinymce.init({
										selector: "textarea#bodyId",
										plugins: [
										"link fullscreen hr paste code"
										],
										toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
										autosave_ask_before_unload: false,
										max_height: 200,
										min_height: 160,
										height : 180,
										link_assume_external_targets: false
										});
									</script>
									<textarea id='bodyId' name="article.body" style="width:900px; height:300px"><?php echo (isset($articleData)) ? $articleData['body'] : ''; ?></textarea>
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
	<div class="accordion" data-role="accordion" data-one-frame="false" data-show-active="true">
		<div class="frame">
			<div class="heading"> Editar artículo <?php echo $newRow['Title']; ?></div>
			<div class="content">
				<form action='<?php echo HHURL; ?>/manage?p=articles&do=edit&key=<?php echo $newRow['Id']; ?>' method='post' name='theAdminForm' id='theAdminForm'>
					<?php echo getAntiCsrf(); ?>
					<table>
						<tbody>
							<tr>
								<td>
									<b>Título</b>
									<div class='graytext'></div>
								</td>
								<td>
									<input type='text' name='article.title' id='title' value="<?php echo $newRow['Title']; ?>" size='30' class='textinput'>
								</td>
							</tr>
							<tr>
								<td>
									<b>Color</b>
									<div class='graytext'>Category</div>
								</td>
								<td>
									<select id="article.category" name='article.category'>
										<option value='0'>Otros</option>
										<option value='1'>Actualizaciones</option>
										<option value='2'>Competiciones & encuestas</option>
										<option value='3'>Eventos</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<b>Descripción</b>
									<div class='graytext'></div>
								</td>
								<td>
									<textarea name='article.summary' cols='130' rows='3' wrap='soft' id='sub_desc' class='multitext'><?php echo $newRow['Summary']; ?></textarea>
								</td>
							</tr>
							<tr>
								<td><b>Imágen</b>
									<div class='graytext'>
										<img src="<?php echo $newRow['BackGroundImage']; ?>" id="imageide" height="128" width="128"> 
									</div>
								</td>
								<td>
									<input type='text' name='article.backgroundimage' id='imageurle' value="<?php echo $newRow['BackGroundImage']; ?>" size='100' class='textinput' onchange="ChangeImage('imageide', 'imageurle', '')">
								</td>
							</tr>
							<tr>
								<td>
									<b>Desarrollo</b>
									<div class='graytext'></div>
								</td>
								<td>
									<script type="text/javascript">
										tinymce.init({
										selector: "textarea#bodyId2",
										plugins: [
										"link fullscreen hr paste code"
										],
										toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
										autosave_ask_before_unload: false,
										max_height: 200,
										min_height: 160,
										height : 180,
										link_assume_external_targets: false
										});
									</script>
									<textarea id='bodyId2' name="article.body" style="width:900px; height:300px"><?php echo $newRow['Body']; ?></textarea>
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
		</div>
	</div>
	<?php endif; ?>

	<script type="text/javascript">
		function SCHclick(){
			var sValue = element('#i0120').value;
			window.history.pushState("", "", 'manage?p=articles&filter=' + b2h(sValue));

			element("#resultTable").innerHTML = get("<?php echo HHURL; ?>/manage?p=articles&filter=" + b2h(sValue), "POST", "onlyTable=true");
		}
	</script>