<?php /* MY BADGES PLUGIN */ ?>
<div class="plugin badges">
	<div class="title-darkred">Mis Placas <b>Actuales</b><div id="detail"></div></div>
	<div class="content badges">
		<?php					
			$badges = SQL::query('SELECT ' . Server::Get(Server::USER_BADGES_BADGE_ID_COLUMN) . ' FROM ' . Server::Get(Server::USER_BADGES_TABLE) . ' WHERE ' . Server::Get(Server::USER_BADGES_BADGE_SLOT_COLUMN) . ' > 0 AND ' . Server::Get(Server::USER_BADGES_USER_ID_COLUMN) . ' = ' . User::$Data['id'] . ' ORDER BY ' . Server::Get(Server::USER_BADGES_BADGE_SLOT_COLUMN) . ' DESC LIMIT 5');
			if ($badges && $badges->num_rows > 0): 
				while ($badgeRow = $badges->fetch_assoc()):
		?>
		<div id="badge">
			<div id="image"><img src="<?php echo Site::$Settings['badgesPath'] . '/' . $badgeRow['badge_code']; ?>.gif" /></div>
		</div>
		<?php endwhile; else: echo 'No hay placas actualmente'; endif; ?>
	</div>
</div>