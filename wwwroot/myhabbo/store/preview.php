<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['productId'], $_POST['subCategoryId'])):
	exit;
endif;

if(!is_numeric($_POST['productId']) && !is_numeric($_POST['subCategoryId'])):
	exit;
endif;

const APIsLoad = 'Homes.StoreCategories';
require '../../../KERNEL-XDRCMS/Init.php';

$getPreview = Categories::GetItem($_POST['subCategoryId'], $_POST['productId']); 

if(!$getPreview || $getPreview->num_rows === 0)
	exit;

$Row = $getPreview->fetch_assoc();

if($Row['type'] === 'Background'):
	header('X-JSON: ' . json_encode([['bgCssClass' => $Row['skin'], 'type' => 'Background', 'itemCount' => 1, 'previewCssClass' => $Row['skin'], 'titleKey' => $Row['ItemName']]]));
elseif($Row['skin'] === 'package_product_pre'):
	$Items = explode(',', $Row['ItemsContent']);

	$Header = [];
	foreach($Items as $ItemSkin) {
		array_push($Header, ['type' => 'Sticker', 'itemCount' => 1, 'previewCssClass' => $ItemSkin, 'titleKey' => '']);
	}
	
	header('X-JSON: ' . json_encode($Header));
else:
	header('X-JSON: ' . json_encode([['type' => $Row['type'], 'itemCount' => $Row['amount'], 'previewCssClass' => $Row['skin'], 'titleKey' => $Row['ItemName']]]));
endif;

require HTML . 'Store_preview.html';
?>