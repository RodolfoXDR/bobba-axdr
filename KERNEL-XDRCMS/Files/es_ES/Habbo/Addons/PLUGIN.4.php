<?php /* MY BADGES PLUGIN */ ?>


<div class="habblet-container ">        
	<div class="cbb clearfix <?php echo self::$Colors[$jRow['Color']]; ?> ">
		<h2 class="title"><?php echo $jRow['Title']; ?></h2>
		<p align="center">
		<?php					
			$badges = SQL::query('SELECT ' . Server::Get(Server::USER_BADGES_BADGE_ID_COLUMN) . ' FROM ' . Server::Get(Server::USER_BADGES_TABLE) . ' WHERE ' . Server::Get(Server::USER_BADGES_BADGE_SLOT_COLUMN) . ' > 0 AND ' . Server::Get(Server::USER_BADGES_USER_ID_COLUMN) . ' = ' . User::$Data['id'] . ' ORDER BY ' . Server::Get(Server::USER_BADGES_BADGE_SLOT_COLUMN) . ' DESC LIMIT 5');
			if ($badges && $badges->num_rows > 0): 
				while ($badgeRow = $badges->fetch_assoc()):
		?>
		<div id="badge">
			<div id="image"><img src="<?php echo Site::$Settings['badgesPath'] . '/' . $badgeRow['badge_code']; ?>.gif" /></div>
		</div>
		<?php endwhile; else: echo 'No hay placas actualmente'; endif; ?>
		</p>
	</div>
</div>
<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>