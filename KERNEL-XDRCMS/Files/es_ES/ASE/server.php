<?php 

$PageName = 'Configuración';

if($do === 'save' && isset($_POST['game_host'], $_POST['game_port'], $_POST['mus_enabled'],  $_POST['mus_host'], $_POST['mus_port'])):
	if(!checkAntiCsrf()):
		$msg_error = 'Invalid Secret Key. Please log in with a valid Secret Key';
		goto S;
	elseif(!is_numeric($_POST['game_port']) || !is_numeric($_POST['mus_port'])):
		$msg_error = 'Los puertos tienen que ser números.';
		goto S;
	elseif($_POST['game_port'] == $_POST['mus_port'] && $_POST['game_host'] == $_POST['mus_host']):
		$msg_error = 'Los puertos del servidor MUS deben ser diferentes al del servidor normal.';
		goto S;
	endif;

	$DataToSave = ['TCP' => ['Server' => $_POST['game_host'],'Port' => $_POST['game_port']],'MUS' => ['Enabled' => ($_POST['mus_enabled'] === '1'),'Server' => $_POST['mus_host'],'Port' => $_POST['mus_port']]];
	Cache::SetAIOConfig('Server', $DataToSave);
	SLOG('Change', 'Editado la configuración del servidor', 'manage.php[server]', 0);

	$msg_correct = 'Se han guardado los cambios con éxito.';
endif;

S:$sSettings = isset($DataToSave) ? $DataToSave : Cache::GetAIOConfig('Server');

require ASE . 'Header.html';

?>

<?php if(!extension_loaded('sockets')): ?>
<div class="announcement">
	Aviso: No tienes la extensión de sockets activada.
</div>
<?php endif; ?>

<form action='<?php echo HHURL; ?>/manage?p=server&do=save' method='post' name='theAdminForm'>
	<?php echo getAntiCsrf(); ?>
	<div class="widget">
		<div class="widget__heading">TCP</div>
		<div class="widget__body">
			<div class="form__group">
				<label>Host &oacute; IP</label>
				<input type="text" name='game_host' id='game_host' value="<?php echo $sSettings['TCP']['Server']; ?>" size='30' />
				
				<label>Puerto TCP</label>
				<div class="graytext">Puerto del servidor</div>
				<input type='text' name='game_port' id='game_port' value="<?php echo $sSettings['TCP']['Port']; ?>" size='30' />
			</div>
		</div>
	</div>
	
	<div class="widget">
		<div class="widget__heading">MUS</div>
		<div class="widget__body">
			<div class="form__group">
				<label>Iniciar MUS</label>
				<select name='mus_enabled' class="styled">
					<option value="1" <?php echo (($sSettings['MUS']['Enabled']) ? 'selected=true' : ''); ?>>Activado</option>
					<option value="0" <?php echo (($sSettings['MUS']['Enabled']) ? '' : 'selected=true'); ?>>Desactivado</option>
				</select>
				
				<label>Host o IP</label>
				<div class="graytext">Se recomienda poner la Ip privada (127.0.0.1 o 192.168.1.1) si el servidor está alojado en el mismo servidor de la CMS.</div>
				<input type='text' name='mus_host' id='mus_host' value="<?php echo $sSettings['MUS']['Server']; ?>" size='30' />
				
				<label>Puerto MUS</label>
				<input type='text' name='mus_port' id='mus_port' value="<?php echo $sSettings['MUS']['Port']; ?>" size='30' />
			</div>
		</div>
	</div>
	<div class="buttons__section">
		<button type="submit" class="green">Guardar</button>
		<button onclick="resetConfiguration()" class="gray">Predeterminado</button>
	</div>
</form>

<script>
function resetConfiguration()
{
	element('#game_host').value = '127.0.0.1';
	element('#game_port').value = '30001';
	element('#mus_host').value = '127.0.0.1';
	element('#mus_port').value = '30002';
}
</script>