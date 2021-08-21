 <?php
$PageName = 'MPUs';

$mpusFiles2 = scandir(UPLOAD . 'c_images/MPUs/');
$mpusFiles = array_diff(scandir(UPLOAD . 'c_images/MPUs/'), array('.', '..'));
$mpusFiles = array_values($mpusFiles);

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($do == 'delete'):
    if(unlink(UPLOAD . 'c_images/MPUs/' . $key))
        $msg_correct = "Has removido " . $key . " correctamente.";
    else
        $msg_error = "El archivo que quieres borrar no existe.";
endif;

if($do == 'new' && isset($_FILES['archivo']) && !empty($_FILES['archivo']['tmp_name'])):
    $info = getimagesize($_FILES['archivo']['tmp_name']);
    if ($_FILES['archivo']["error"] > 0):
        $msg_error = "Error: " . $_FILES['archivo']['error'];
    elseif ($info === FALSE):
        $msg_error = "Error: No se puede definir el tipo de imagen.";
    elseif (($info[2] != IMAGETYPE_JPEG) || ($info[2] != IMAGETYPE_PNG)):
        $msg_error = "Error: El archivo subido no es tipo valido. (PNG o JPG)";
    elseif(file_exists(UPLOAD . 'c_images/MPUs/' . $_FILES['archivo']['name'] . '.png') || file_exists(UPLOAD . 'c_images/MPUs/' . $_FILES['archivo']['name'] . '.jpg')):
        $msg_error = "Error: Este archivo ya existe";
    else:
        if ($info[2] == IMAGETYPE_PNG)
        move_uploaded_file($_FILES['archivo']['tmp_name'], UPLOAD . 'c_images/MPUs/' . $_FILES['archivo']['name']);

        if ($info[2] == IMAGETYPE_JPEG)
        move_uploaded_file($_FILES['archivo']['tmp_name'], UPLOAD . 'c_images/MPUs/' . $_FILES['archivo']['name']);
        
        $msg_correct = "Haz subido tu imagen con éxito";
    endif;
elseif($do == 'new' && !isset($_FILES['archivo']) && empty($_FILES['archivo']['tmp_name'])):
    $msg_error = "Error: No puedes dejar los espacios vacios";
endif;
require ASE . 'Header.html';
?>


<table>
    <thead>
        <tr>
            <th id="th1" class="text-left">Nombre de Archivo</th>
            <th id="th2" class="text-left">URL</th>
            <th id="th4" class="text-left">Acciones</th>
        </tr>
    </thead>
    
    <tbody>
        <?php
            foreach($mpusFiles as $file):
        ?>
        <tr>
            <td class="right"><?php echo $file ?></td>
            <td class="right"><a href="<?php echo Site::$Settings['mpusPath'] . $file ?>" target="_blank"><?php echo Site::$Settings['mpusPath'] . $file ?></a></td>
            <td class="right"><a href="<?php echo HHURL; ?>/manage?p=mpus&do=delete&key=<?php echo $file; ?>">Eliminar</a></td>
        </tr>
        <?php 
            endforeach;
        ?>
    </tbody>
</table>

<form action='<?php echo HHURL; ?>/manage?p=mpus&do=new' enctype="multipart/form-data" method='post' name='theAdminForm' id='theAdminForm'>
<div class="widget">
	<div class="widget__heading">Subir MPU</div>
	<div class="widget__body">
		<div class="form__group">
			<label>Insertar Archivo</label>
			<div class="graytext">El archivo solamente puede ser <b>PNG/JPG</b></div>
			<input type="file" name="archivo" id="archivo" style="margin: 15px 10px;"></input>
			<br/>
		</div>
	</div>
</div>

<div class="buttons__section">
	<button type="submit" class="green">Subir</button>
</div>
</form>