<?php
if(isset($_GET['URI'])):
	if($_GET['URI'] === 'archive'):
		$showAllArticles = true;
	elseif(strstr($_GET['URI'], '-') !== FALSE):
		$URI = explode('-', $_GET['URI'])[0];
		if(is_numeric($URI)):
			$articleId = $URI;
		endif;
	endif;
endif;

if(isset($articleId))
	$query = SQL::query('SELECT * FROM xdrcms_news WHERE Id = ' . $articleId);
else
	$query = SQL::query('SELECT * FROM xdrcms_news ORDER BY Id DESC LIMIT 1');

if($query && $query->num_rows):
	$queryRow = $query->fetch_assoc();
	Tool::DecodeEntities(Tool::HTMLEntities, $queryRow['Body']);
	
	$articleId = $queryRow['Id'];
	Site::$PageName = 'Noticias - ' . $queryRow['Title'];
	
	$Owner = User::GetNameById($queryRow['OwnerID']);

	switch($queryRow['Category']):
		case 0:
			$Category = "Otros";
			break;
		case 1:
			$Category = "Actualizaciones";
			break;
		case 2:
			$Category = "Competencias & Encuestas";
			break;
		case 3:
			$Category = "Eventos";
			break;
		default:
			$Category = '';
	endswitch;
	
else:
	$articleId = 0;
	$Category = '';
	$queryRow = [
		'Id' => '',
		'Title' => 'Articulo no encontrado.',
		'Body' => 'No podemos encontrar lo que estas buscando. Porfavor revisa la URL o intenta empezando de nuevo desde la <a href="' . URL . '">página principal de ' . HotelName . '</a>.',
		'BackGroundImage' => '',
		'Images' => '',
		'TimeCreated' => '',
		'Summary' => '',
		'Category' => ''
	];
	Site::$PageName = 'Noticias - Artículo no encontrado';
endif;
?>