<?php 
$_users = SQL::query("SELECT COUNT(*) FROM " . Server::Get(Server::USER_TABLE));
$users  = $_users->fetch_array()($_users)["count(*)"];
$_groups = SQL::query("SELECT COUNT(*) FROM groups");
$groups  = $_groups->fetch_array()($_groups)["count(*)"];
$_bans = SQL::query("SELECT COUNT(*) FROM bans");
$bans  = $_bans->fetch_array()($_bans)["count(*)"];
$_items = SQL::query("SELECT COUNT(*) FROM items");
$items  = $_items->fetch_array()($_items)["count(*)"];
$_catalogit = SQL::query("SELECT COUNT(*) FROM catalog_items");
$catalogit  = $_catalogit->fetch_array()($_catalogit)["count(*)"];
/* HOTEL STATS */?>
<div class="plugin">
	<div class="title-darkgreen">Estadisticas del Hotel</div>
	<div class="content">
	Hay <b><?php echo Site::$Onlines; ?></b> usuario(s) online.<br />
	Hay <b><?php echo $users; ?></b> usuarios(s) registrados.<br />
	Hay <b><?php echo $bans; ?></b> usuario(s) baneados.<br />
	Hay <b><?php echo $items; ?></b> furnis en <b><?php echo SQL::query("SELECT null FROM rooms")->num_rows; ?></b> Salas.<br />
	Hay <b><?php echo $groups; ?></b> Grupos creados.<br />
	Hay <b><?php echo $catalogit; ?></b> furnis en el catálogo.<br />			
	</div>
</div>