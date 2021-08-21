<?php
$PageName = 'Catalogo';

require ASE . 'Header.html';

$GrandParentQuery = SQL::query('SELECT * FROM catalog_pages WHERE parent_id = -1');

	if($GrandParentQuery->num_rows > 0):
		$ParentsTotal = 0;
		$ChildTotal= 0;
		$GrandParentTotal = $GrandParentQuery->num_rows;
		while($GrandParentRows = $GrandParentQuery->fetch_assoc()):
				$ParentQuery = SQL::query('SELECT * FROM catalog_pages WHERE parent_id = \'' . $GrandParentRows['id'] . '\'');
				$ParentsTotal += $ParentQuery->num_rows;
				if($ParentQuery->num_rows > 0):
					while($ParentRows = $ParentQuery->fetch_assoc()):
						$ChildQuery = SQL::query('SELECT * FROM catalog_pages WHERE parent_id = \'' . $ParentRows['id'] . '\'');
						$ChildTotal += $ChildQuery->num_rows;
					endwhile;
				endif;
		endwhile;
	endif;

$ChildQuery = SQL::query('SELECT * FROM catalog_pages WHERE parent_id = -1');

?>

<div class="row2">
	<div class="cell">
		<div class="panel green">
			<div id="header">¿Qué puedo hacer aquí?</div>
			<div id="content">
				En esta sección del Panel de Control de <?php echo HotelName; ?> podrás editar/crear/borrar distintos elementos del catalogo del cliente. 
				Esta herramienta se encuentra en versión <b>BETA</b> y puede que algunas cosas no funcionen adecuadamente. <br/><br/>
				¡Favor de utilizar esta herramienta con cuidado!
			</div>
		</div>
	</div>
	<div class="cell">
		<div class="panel blue">
			<div id="header">Acciones</div>
			<div id="content">
				<ul>
					<li><a href="<?php echo HHURL; ?>/manage?p=catalog_m">Editar Secciones Principales</a></li>
					<li><a href="<?php echo HHURL; ?>/manage?p=catalog_sm">Editar SubSecciones Principales</a></li>
					<li><a href="<?php echo HHURL; ?>/manage?p=catalog_ssm">Editar Secciones Regulares</a></li>
					<li><a href="#">Furnis por <i>Catalog Page ID</i></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row4">
	<div class="cell">
		<div class="tile bird blue">
			<div id="information" class="small"><b>12123</b> Furnis</div>
		</div>
	</div>
	<div class="cell">
		<div class="tile bird red">
			<div id="information" class="small"><b><?php echo $GrandParentTotal; ?></b> Secciones Principales</div>
		</div>
	</div>
	<div class="cell">
		<div class="tile bird green">
			<div id="information" class="small"><b><?php echo $ParentsTotal; ?></b> SubSecciones Principales</div>
		</div>
	</div>
	<div class="cell">
		<div class="tile bird orange">
			<div id="information" class="small"><b><?php echo $ChildTotal; ?></b> Secciones Regulares</div>
		</div>
	</div>
</div>