<?php
$PageName = 'Override Texts & Vars';
$cSettings = Cache::GetAIOConfig('Client');

if (!$cSettings['managed.override'])
{
	require_once ASE . 'header.html';
	echo 'No está activada esta sección, para activarla ve a la sección Servidor/SWF';
	goto jumpOV;
}

if (isset($_POST['oVars']))
{
	$f = fopen(KERNEL . '/Cache/Override.Variables.txt', 'w');
	fwrite($f, str_ireplace(['php','<?'], ['&#112;hp','&lt;?'], html_entity_decode(html_entity_decode($_POST['oVars'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8')));
	fclose($f);
	
	$cSettings['managed.override.token'] = Tool::Random(40, true, false, 'qwertyuiopasdfghjklzxcvbnm');
}

if (isset($_POST['oTxts']))
{
	$f = fopen(KERNEL . '/Cache/Override.Texts.txt', 'w');
	fwrite($f, str_ireplace(['php','<?'], ['&#112;hp','&lt;?'], html_entity_decode(html_entity_decode($_POST['oTxts'], ENT_QUOTES | ENT_HTML401, 'UTF-8'), ENT_QUOTES, 'UTF-8')));
	fclose($f);
}

if (isset($_POST['oVars']) || isset($_POST['oTxts']))
{
	$cSettings['managed.override.token'] = Tool::Random(40, true, false, 'qwertyuiopasdfghjklzxcvbnm');
	Cache::SetAIOConfig('Client', $cSettings);
	SLOG('Change', 'Editado las variables de override', 'manage.php[override]', 0);
}

$oVars = file_exists(KERNEL . '/Cache/Override.Variables.txt') ? file_get_contents(KERNEL . '/Cache/Override.Variables.txt') : '';
$oTxts = file_exists(KERNEL . '/Cache/Override.Texts.txt') ? file_get_contents(KERNEL . '/Cache/Override.Texts.txt') : '';
require ASE . 'Header.html';
?>
<form action='<?php echo HHURL; ?>/manage?p=override_varstexts' method='post' name='theAdminForm' id='form1' class="block-content form">
	<h1 style="color:black;font-size: 2em;">Override Variables</h1>
	<textarea name="oVars" cols="100" rows="18" class="multitext"><?php echo $oVars; ?></textarea>
	<h1 style="color:black;font-size: 2em;">Override flash texts</h1>
	<textarea name="oTxts" cols="100" rows="18" class="multitext"><?php echo $oTxts; ?></textarea>
	<input type="submit" value="Guardar" />
</form>
<br />
<p> Current Token: <?php echo $cSettings['managed.override.token']; ?> </p>

<?php jumpOV: ?>