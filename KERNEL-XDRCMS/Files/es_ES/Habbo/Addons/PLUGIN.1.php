<?php /* HOTEL STATS */?>
<div class="habblet-container ">        
	<div class="cbb clearfix <?php echo self::$Colors[$jRow['Color']]; ?> ">
		<h2 class="title"><?php echo $jRow['Title']; ?></h2>
		<p align="center">
			Hay <b><?php echo Site::$Onlines; ?></b> usuario(s) online.<br />
			Hay <b><?php echo SQL::query("SELECT null FROM " . Server::Get(Server::USER_TABLE))->num_rows; ?></b> usuarios(s) registrados.<br />
			Hay <b><?php echo SQL::query("SELECT null FROM " . Server::Get(Server::ROOMS_TABLE))->num_rows; ?></b> usuario(s) baneados.<br />
			Hay <b><?php echo SQL::query("SELECT null FROM " . Server::Get(Server::ITEMS_TABLE))->num_rows; ?></b> furnis en las Salas.<br />
			Hay <b><?php echo SQL::query("SELECT null FROM " . Server::Get(Server::GROUPS_TABLE))->num_rows; ?></b> Grupos creados.<br />
			Hay <b><?php echo SQL::query("SELECT null FROM catalog_items")->num_rows; ?></b> furnis en el catálogo.<br />			
		</p>
	</div>
</div>
<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>