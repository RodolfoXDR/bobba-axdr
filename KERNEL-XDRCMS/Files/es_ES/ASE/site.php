 <?php
$PageName = 'Sitio';

$aSettings = Cache::GetAIOConfig('ADS');
$rSettings = Cache::GetAIOConfig('Register');
if($do === 'save' && isset($_POST['register_enabled'], $_POST['limitips'], $_POST['initial_credits_int'], $_POST['hotel_status_bool'], $_POST['redirection'], $_POST['badgesPath'], $_POST['mpusPath'], $_POST['staffpage_visibility'], $_POST['hotel_status'])):
		Site::$Settings['RegisterEnabled'] = $_POST['register_enabled'];
		$Register = $_POST['register_enabled'];
		$hotelStatusBool = $_POST['hotel_status_bool'];
		$IpLimit = (is_numeric($_POST['limitips'])) ? $_POST['limitips'] : 0;

		$Credits = (is_numeric($_POST['initial_credits_int'])) ? $_POST['initial_credits_int'] : 0;
		
		Site::$Settings['initial.credits.int'] = $Credits;
		Site::$Settings['hotel.status.bool'] = $hotelStatusBool;

		$rSettings['register_enabled'] = $Register;
		$rSettings['limitips'] = $IpLimit;
		$rSettings['redirection'] = $_POST['redirection'];
		Site::$Settings['ClientEnabled'] = $_POST['hotel_status'] == '0' ? '0' : (($_POST['hotel_status'] == '1') ? '1' : '2');
		Site::$Settings['staff.page.visibility'] = ($_POST['staffpage_visibility'] === '1') ? 1 : 0;
		Site::$Settings['badgesPath'] = $_POST['badgesPath'];
		Site::$Settings['mpusPath'] = $_POST['mpusPath'];

		Cache::SetAIOConfig('Site', Site::$Settings);
		Cache::SetAIOConfig('Register', $rSettings);
		Cache::SetAIOConfig('ADS', $aSettings);

		SLOG('Change', 'Editado la configuración del sitio', 'manage.php[site]', 0);
		$msg_correct = 'Los cambios han sido guardados con éxito.';
endif;
require ASE . 'Header.html';
?>
<form action="<?php echo HHURL; ?>/manage?p=site&do=save" method="post" id="form1">

	<div class="widget">
		<div class="widget__heading">Registro</div>
		<div class="widget__body">
			<div class="form__group">
				<label>Habilitar Registro</label>
				<div class="graytext">Permitir nuevas cuentas</div>
				<select name="register_enabled">
					<option value="0" <?php echo ((Site::$Settings['RegisterEnabled'] == 1) ? '' : 'selected=true'); ?>>Desactivado</option>						 	
					<option value="1" <?php echo ((Site::$Settings['RegisterEnabled'] == 1) ? 'selected=true' : ''); ?>>Activado</option>
				</select>
				
				<label>Registro por IP</label>
				<div class="graytext">Máximo de cuentas por usuario (IP) || <b>0 = desactivado</b></div>
				<input type="text" name="limitips" value="<?php echo $rSettings['limitips']; ?>" />
				
				<label>Créditos iniciales</label>
				<div class="graytext">Cantidad de monedas con la que inicia el usuario.</div>
				<input type="text" name="initial.credits.int" value="<?php echo Site::$Settings['initial.credits.int']; ?>" />
				
				<label>Estado de Hotel</label>
				<div class="graytext">Mostrar la cantidad de usuarios conectados en el hotel.</div>
				<select name="hotel.status.bool">
					<option value="0" <?php echo ((Site::$Settings['hotel.status.bool'] == 1) ? '' : 'selected=true'); ?>>Desactivado</option>						 	
					<option value="1" <?php echo ((Site::$Settings['hotel.status.bool'] == 1) ? 'selected=true' : ''); ?>>Activado</option>
				</select>
				
				<label>Redirección</label>
				<div class="graytext">Página a visitar después del registro</div>
				<input type="text" name="redirection" value="<?php echo $rSettings['redirection']; ?>" size="30" />	
			</div>
		</div>
	</div>
	
	<div class="widget">
		<div class="widget__heading">General</div>
		<div class="widget__body">
			<div class="form__group">
				<label>Directorio de placas</label>
				<div class="graytext"><img src="<?php echo Site::$Settings['badgesPath']; ?>/ADM.gif" id="admBadge" height="31" width="31"></div>
				<input type="text" name="badgesPath" id="badgesPath" value="<?php echo Site::$Settings['badgesPath']; ?>" size="100" onchange="ChangeImage('admBadge', 'badgesPath', '/ADM.gif')">

				<label>Directorio de m&uacute;sica</label>
				<div class="graytext"></div>
				<input type="text" name="songsPath" id="songsPath" value="<?php echo Site::$Settings['songsPath']; ?>" size="100">

				<label>Directorio de MPUs</label>
				<div class="graytext"></div>
				<input type="text" name="mpusPath" id="mpusPath" value="<?php echo Site::$Settings['mpusPath']; ?>" size="100">
				
				<label>Visibilidad de la Página Staff</label>
				<select name="staffpage_visibility" class="styled">
					<option value="0" <?php echo ((Site::$Settings['staff.page.visibility']) ? '' : 'selected=true'); ?>>Todo el mundo</option>						 	
					<option value="1" <?php echo ((Site::$Settings['staff.page.visibility']) ? 'selected=true' : ''); ?>>Solo staffs.</option>
				</select>
				<label>Disponibilidad de Cliente</label>
				<select name="hotel_status" class="styled">
					<option value="0" <?php echo Site::$Settings['ClientEnabled'] == '0' ? 'selected=true' : ''; ?>>Cerrado</option>						 	
					<option value="1" <?php echo Site::$Settings['ClientEnabled'] == '1' ? 'selected=true' : ''; ?>>Abierto</option>
					<option value="2" <?php echo Site::$Settings['ClientEnabled'] == '2' ? 'selected=true' : ''; ?>>Solo Staffs</option>
				</select>
			</div>
		</div>
	</div>

	<div class="buttons__section">
		<button class="green" type="submit">Guardar</button>
	</div>
</form>