 <?php
$PageName = 'Emulador';

require ASE . 'Header.html';

$q = SQL::query('SELECT status FROM server_status');
if(!$q || $q->num_rows == 0):
	echo 'Ha ocurrido un error con la tabla server_status.';
	exit;
endif;

$q = $q->fetch_assoc()['status'] == '1';

if($do === 'end'):
	Socket::CLOSE();
endif;

if($do == 'sendha' && isset($_POST['alert_hotel'])):
	$alertData = [
		'hotel' => $_POST['alert_hotel']
	];
	Socket::send('ha', $alertData['hotel']);
endif;

?>

<?php if($q): ?>
	El emulador está encendido. Inicia una conexión con el emulador para poder controlar el hotel desde aquí. 
	<br /><br />
	<form action='<?php echo HHURL; ?>/manage?p=alerts&do=sendha' method="post">
		<textarea name='alert.hotel' id='hotel' maxlenght="100"></textarea>
		<button type="submit" class="button alert save">Enviar</button>
	</form>
	<br /><br />
<?php else: ?>
	El emulador está apagado.
<?php endif; ?>

<!--END HEADER-->
	</div>
</div>