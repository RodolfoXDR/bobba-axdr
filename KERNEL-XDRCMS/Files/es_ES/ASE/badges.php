 <?php
$PageName = 'Placas';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($do == 'new' && isset($_POST['name'], $_POST['desc'], $_FILES['archivo']) && !empty($_FILES['archivo']['tmp_name'])):
    $info = getimagesize($_FILES['archivo']['tmp_name']);
    if ($_FILES['archivo']["error"] > 0):
        $msg_error = "Error: " . $_FILES['archivo']['error'];
    elseif ($info === FALSE):
        $msg_error = "Error: No se puede definir el tipo de imagen.";
    elseif (($info[2] !== IMAGETYPE_GIF)):
        $msg_error = "Error: El archivo subido no es tipo GIF";   
    elseif(file_exists(UPLOAD . '/' . $_POST['name'] . '.gif')):
        $msg_error = "Error: Este archivo ya existe";
    elseif(strlen($_POST['name']) < 3 || strlen($_POST['desc']) < 3 ):
        $msg_error = "Error: Nombre o Descripción muy cortos.";
    else:
        move_uploaded_file($_FILES['archivo']['tmp_name'], UPLOAD . '/c_images/album1584/' . $_POST['name'] . '.gif');
        $msg_correct = "Haz subido tu placa con éxito";
        $badgeData = [
            'badgename' => $_POST['name'],
            'badgedesc' => $_POST['desc']
        ];
    endif;
else:
    $msg_error = "Error: No puedes dejar los espacios vacios";
endif;
require ASE . 'Header.html';
?>

<?php 
if(isset($badgeData)):
?>
<div class="widget">
	<div class="widget__heading">Subir Placa</div>
	<div class="widget__body">
        <h3>Código de Placa</h3>
        <p style="font-size: 10pt">COPIA & PEGA el código de abajo en <b>Override Flash Texts</b> dando click <a href="<?php echo HHURL; ?>/manage?p=override_varstexts">aquí</a></p>
        <code>
            badge_name_<?php echo $badgeData['badgename']; ?> = <?php echo $badgeData['badgename']; ?>
            <br />
            badge_desc_<?php echo $badgeData['badgename']; ?> = <?php echo $badgeData['badgedesc']; ?>
        </code>
    </div>
</div>
<?php endif; ?>
<form action='<?php echo HHURL; ?>/manage?p=badges&do=new' enctype="multipart/form-data" method='post' name='theAdminForm' id='theAdminForm'>
<div class="widget">
	<div class="widget__heading">Subir Placa</div>
	<div class="widget__body">
		<div class="form__group">
			<label>Insertar Archivo</label>
			<div class="graytext">El archivo solamente puede ser <b>GIF</b></div>
			<input type="file" name="archivo" id="archivo" style="margin: 15px 10px;"></input>
			<br/>
			<label>Nombre de la placa</label>
			<div class="graytext">badge_name</div>
            <input type="text" name="name" id="name"></input>
			<label>Descripción de la placa</label>
			<div class="graytext">badge_desc</div>
            <input type="text" name="desc" id="desc"></input>
		</div>
	</div>
</div>

<div class="buttons__section">
	<button type="submit" class="green">Subir</button>
</div>
</form>