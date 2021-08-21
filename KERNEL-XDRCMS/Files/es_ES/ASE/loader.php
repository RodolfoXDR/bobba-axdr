<?php 

$PageName = "SWFs";
$cSettings = Cache::GetAIOConfig('Client');

if($do == 'save' && isset($_POST['external_variables_txt'], $_POST['external_texts_txt'], $_POST['safechat_list_txt'], $_POST['productdata_load_url'], $_POST['furnidata_load_url'], $_POST['flash_client_url'], $_POST['params__base'], $_POST['clientUrl'], $_POST['client_starting'], $_POST['hotelview_banner_url'], $_POST['managed_override'])):
	if(!checkAntiCsrf()):
		$msg_error = 'Invalid Secret Key. Please log in with a valid Secret Key';
	elseif(empty($_POST['external_variables_txt']) || empty($_POST['flash_client_url']) || empty($_POST['params__base']) || empty($_POST['clientUrl']) || !is_numeric($_POST['managed_override'])):
		$msg_error = 'No dejes campos obligatorios en blanco.';
	else:
		$cSettings['managed.override'] = $_POST['managed_override'] == '1';
		$cSettings['Txts'] = ['external.variables.txt' => $_POST['external_variables_txt'],
				'external.texts.txt' => $_POST['external_texts_txt'],
				'safechat.list.txt' => $_POST['safechat_list_txt'],
				'external.override.texts.txt' => isset($_POST['external_override_texts_txt']) ? $_POST['external_override_texts_txt'] : $cSettings['Txts']['external.override.texts.txt'],
				'external.override.variables.txt' => isset($_POST['external_override_variables_txt']) ? $_POST['external_override_variables_txt'] : $cSettings['Txts']['external.override.variables.txt'],
				'productdata.load.url' => $_POST['productdata_load_url'],
				'furnidata.load.url' => $_POST['furnidata_load_url'],
				'external.figurepartlist.txt' => $_POST['external_figurepartlist_txt'],
				'hotelview.banner.url' => $_POST['hotelview_banner_url']];

		$cSettings['Folders'] = ['flash.client.url' => $_POST['flash_client_url'],
				'params..base' => $_POST['params__base']];
		$cSettings['clientUrl'] = $_POST['clientUrl'];
		$cSettings['client.starting'] = $_POST['client_starting'];
		$cSettings['client.new.user.reception'] = ($_POST['client_new_user_reception'] >= 0 || $_POST['client_new_user_reception'] <= 3) ? (int)$_POST['client_new_user_reception'] : 0;
		
		Cache::SetAIOConfig('Client', $cSettings);
		Cache::SetAIOConfig('Site', Site::$Settings);
		SLOG('Change', 'Cambiado la configuración del client', 'manage.php[loader]', 0);

		$msg_correct = 'Los cambios han sido guardados con éxito.';		
	endif;
endif;


require ASE . 'Header.html';

?>
Ahora puedes
<a onclick="Export()" href="javascript:void(0)"> Exportar</a>
&oacute;
<a onclick="Import()" href="javascript:void(0)"> Importar</a>.
<b>Nota: Para cargar las cosas opcionales, dejar en blanco.</b>
<form action="<?php echo HHURL; ?>/manage?p=loader&do=save" method="post" name="theAdminForm" id="form1" class="block-content form">
<?php echo getAntiCsrf(); ?>
<div class="widget">
	<div class="widget__heading">Opciones</div>
	<div class="widget__body">
		<div class="form__group">
			<label>Reception (new Crypto)</label>
			<div class="graytext">new.user.reception. Necesitas unas SWF compatibles.</div>
			<select name="client.new.user.reception" class="styled">
				<option value="0" <?php echo $cSettings['client.new.user.reception'] == '0' ? 'selected=true' : ''; ?>>Desactivado</option>						 	
				<option value="1" <?php echo $cSettings['client.new.user.reception'] == '1' ? 'selected=true' : ''; ?>>Registros nuevos</option>
				<option value="2" <?php echo $cSettings['client.new.user.reception'] == '2' ? 'selected=true' : ''; ?>>Registros nuevos desde FB</option>
			</select>
			
			<label>Managed override variables and texts</label>
			<div class="graytext">Cargan las override variables & texts manejadas por aXDR, esto permite añadir texts & variables desde la ACP</div>
			<select name="managed.override" class="styled">
				<option value="0" <?php echo $cSettings['managed.override'] == false ? 'selected=true' : ''; ?>>Desactivado</option>						 	
				<option value="1" <?php echo $cSettings['managed.override'] == true ? 'selected=true' : ''; ?>>Activado</option>
			</select>
		</div>
	</div>
</div>

<div class="widget">
	<div class="widget__heading">SWFs Principales</div>
	<div class="widget__body">
		<div class="form__group">
			<label>External Variables</label>
			<div class="graytext">external.variables.txt</div>
			<textarea name="external.variables.txt" cols="100" rows="3" wrap="soft" id="external.variables.txt" class="multitext"><?php echo $cSettings['Txts']['external.variables.txt']; ?></textarea>
			
			<label>Supersecret token</label>
			<div class="graytext">hotelview.banner.url</div>
			<textarea name="hotelview.banner.url" cols="100" rows="3" wrap="soft" id="hotelview.banner.url" class="multitext"><?php echo $cSettings['Txts']['hotelview.banner.url']; ?></textarea>
			
			<label>Flash Client URL</label>
			<div class="graytext">flash.client.url</div>
			<textarea name="flash.client.url" cols="100" rows="3" wrap="soft" id="flash.client.url" class="multitext"><?php echo $cSettings['Folders']['flash.client.url']; ?></textarea>
			
			<label>Flash Base</label>
			<div class="graytext">params::base</div>
			<textarea name="params..base" cols="100" rows="3" wrap="soft" id="params..base" class="multitext"><?php echo $cSettings['Folders']['params..base']; ?></textarea>
			
			<label>Archivo Habbo SWF</label>
			<div class="graytext">clientUrl</div>
			<textarea name="clientUrl" cols="100" rows="3" wrap="soft" id="clientUrl" class="multitext"><?php echo $cSettings['clientUrl']; ?></textarea>
				
			<label>Loader Text (Optional)</label>
			<div class="graytext">client.starting</div>
			<input type="text" name="client.starting" id="client.starting" value="<?php echo $cSettings['client.starting']; ?>" size="30" class="textinput">
				
		</div>
	</div>
</div>

<div class="widget">
	<div class="widget__heading">SWFs Secundarios</div>
	<div class="widget__body">
		<div class="form__group">
			<label>External Texts</label>
			<div class="graytext">external.texts.txt</div>
			<textarea name="external.texts.txt" cols="100" rows="3" wrap="soft" id="external.texts.txt" class="multitext"><?php echo $cSettings['Txts']['external.texts.txt']; ?></textarea>
			
			<label>Productdata</label>
			<div class="graytext">productdata.load.url</div>
			<textarea name="productdata.load.url" cols="100" rows="3" wrap="soft" id="productdata.load.url" class="multitext"><?php echo $cSettings['Txts']['productdata.load.url']; ?></textarea>
			
			<label>Furnidata</label>
			<div class="graytext">furnidata.load.url</div>
			<textarea name="furnidata.load.url" cols="100" rows="3" wrap="soft" id="furnidata.load.url" class="multitext"><?php echo $cSettings['Txts']['furnidata.load.url']; ?></textarea>
			
			<label>Figuredata</label>
			<div class="graytext">external.figurepartlist.txt</div>
			<textarea name="external.figurepartlist.txt" cols="100" rows="3" wrap="soft" id="external.figurepartlist.txt" class="multitext"><?php echo $cSettings['Txts']['external.figurepartlist.txt']; ?></textarea>
			
			<label>Safe Chat List</label>
			<div class="graytext">safechat.list.txt</div>
			<textarea name="safechat.list.txt" cols="100" rows="3" wrap="soft" id="safechat.list.txt" class="multitext"><?php echo $cSettings['Txts']['safechat.list.txt']; ?></textarea>
			
			<label>External Override Texts</label>
			<div class="graytext">external.override.texts.txt</div>
			<?php if($cSettings['managed.override'] == true): ?>
				MANAGED: <?php echo URL; ?>/managed-gamedata/override/external_flash_override_texts/<?php echo $cSettings['managed.override.token']; ?>
			<?php else: ?>
				<textarea name="external.override.texts.txt" cols="100" rows="3" wrap="soft" id="external.override.texts.txt" class="multitext"><?php echo $cSettings['Txts']['external.override.texts.txt']; ?></textarea>
			<?php endif; ?>
			<label>External Override Variables</label>
			<div class="graytext">external.override.variables.txt</div>
			<?php if($cSettings['managed.override'] == true): ?>
				MANAGED: <?php echo URL; ?>/managed-gamedata/override/external_override_variables/<?php echo $cSettings['managed.override.token']; ?>
			<?php else: ?>
				<textarea name="external.override.variables.txt" cols="100" rows="3" wrap="soft" id="external.override.variables.txt" class="multitext"><?php echo $cSettings['Txts']['external.override.variables.txt']; ?></textarea>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="buttons__section">
	<button type="submit" class="green">Guardar</button>
	<button onclick="resetConfiguration()" class="gray">Predeterminado</button>
</div>
</form>

<script type="text/javascript">
	function Export(){
		var Txts = {"external.variables.txt": element("#external.variables.txt").value,
			"external.texts.txt": element('#external.texts.txt').value,
			"safechat.list.txt": element('#safechat.list.txt').value,
			<?php if($cSettings['managed.override'] == false): ?>
				"external.override.texts.txt": element('#external.override.texts.txt').value,
				"external.override.variables.txt": element('#external.override.variables.txt').value,
			<?php endif; ?>
			"productdata.load.url": element('#productdata.load.url').value,
			"furnidata.load.url": element('#furnidata.load.url').value,
			"flash.client.url": element('#flash.client.url').value,
			"params..base": element('#params..base').value,
			"clientUrl": element('#clientUrl').value,
		};
		
		NewDialog("Exportar", "Guarda o comparte el código:", "<textarea style='width: 620px; height: 90px;'>" + JSON.stringify(Txts) + "</textarea>", "<button class='button alert' onclick='CloseDialog()'>Listo</button>");
	}

	function Insert(){
		var code = JSON.parse(document.getElementById("codeJSON").value);
		element("#external.variables.txt").value = code['external.variables.txt'];
		element('#external.texts.txt').value = code['external.texts.txt'];
		element('#safechat.list.txt').value = code['safechat.list.txt'];
	<?php if($cSettings['managed.override'] == false): ?>
		element('#external.override.texts.txt').value = code['external.override.texts.txt'];
		element('#external.override.variables.txt').value = code['external.override.variables.txt'];
	<?php endif; ?>
		element('#productdata.load.url').value = code['productdata.load.url'];
		element('#furnidata.load.url').value = code['furnidata.load.url'];
		element('#flash.client.url').value = code['flash.client.url'];
		element('#params..base').value = code['params..base'];
		element('#clientUrl').value = code['clientUrl'];
		CloseDialog();
		NewDialog("Aviso", "Se ha importado el código correctamente.", "", "<button onclick='CloseDialog()'>Listo</button>");
	}
	
	function Import(){
		NewDialog("Importar código", "Inserta el código que recibiste:", "<textarea id='codeJSON' style='width: 698px; height: 90px;'></textarea>", "<button class='button alert save' onclick='Insert()'>Listo</button><button class='button alert' onclick='CloseDialog()'>Cerrar</button>");
	}
</script>