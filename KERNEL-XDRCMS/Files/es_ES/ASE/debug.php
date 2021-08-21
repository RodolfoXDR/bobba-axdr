<?php

$PageName = 'Client Debug';

require ASE . 'Header.html';

if($do === 'start' && (!isset($_SESSION['aDEBUG'][0]) || !$_SESSION['aDEBUG'][0]))
{
	$_SESSION['aDEBUG'][0] = true;
	unset($_SESSION['aDEBUG'][1]);
}
else if($do === 'stop')
	$_SESSION['aDEBUG'][0] = false;
?>
<hr />
Client DEBUG es una herramienta que se encarga de registrar todos los logs, eventos y errores que va emitiendo el client a lo largo que está abierto. Esta herramienta es útil para diagnosticar errores para luego poder repararlos.
<br />
<br />
<button onclick="window.location.href='<?php echo HHURL; ?>/manage?p=debug&do=<?php echo isset($_SESSION['aDEBUG'][0]) && $_SESSION['aDEBUG'][0] === true ? 'stop\'">Parar' : 'start\'">Iniciar'; ?> captura</button>
<?php
if(isset($_SESSION['aDEBUG'][1]))
{
?>
<hr />
<table class="striped">
	<thead>
		<tr>
			<th />
			<th>Información</th>
		</tr>
	</thead>
	<tbody id="resultTable">
<?php
	if(count($_SESSION['aDEBUG'][1]) > 0)
		foreach($_SESSION['aDEBUG'][1] as $Row)
		{
?>
		<tr>
			<td class="<?php echo str_replace(['LOG', 'EVENT', 'ERROR'], ['IconInfoEncoded', 'IconWarningEncoded', 'IconErrorEncoded'], $Row[0]); ?>"></td>
			<td><?php echo $Row[1]; ?></td>
		</tr>
<?php 
		}
?>
	</tbody>
</table>
<?php
}
?>