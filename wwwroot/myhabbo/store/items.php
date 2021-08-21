<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2013 Xdr.
|+=========================================================+
|| # Xdr 2013. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

if(!isset($_POST['categoryId'], $_POST['subCategoryId'])):
	exit;
endif;

if(!is_numeric($_POST['categoryId']) && !is_numeric($_POST['subCategoryId'])):
	exit;
endif;

const APIsLoad = 'Homes.StoreCategories';

require "../../../KERNEL-XDRCMS/Init.php";

$categoryId = $_POST['categoryId'];
$subCategoryId = $_POST['subCategoryId'];

$Items = Categories::GetItems($_POST['subCategoryId']);
?>
<ul id="webstore-item-list">
<?php
$c = 0;
if($Items):
	while($Row = $Items->fetch_assoc()):
		if($c === 0):
		endif;
		if($c !== 20)	$c++;
	?>
			<li id="webstore-item-<?php echo $Row['id']; ?>" title="">
				<div class="webstore-item-preview <?php echo $Row['skin']; ?> <?php echo $Row['type']; ?>">
					<div class="webstore-item-mask">
						<?php if($Row['amount'] > 1): ?><div class="webstore-item-count"><div>x<?php echo $Row['amount']; ?></div></div><?php endif; ?>
					</div>
				</div>
			</li>
<?php
	endwhile;
endif;
?>
</ul>