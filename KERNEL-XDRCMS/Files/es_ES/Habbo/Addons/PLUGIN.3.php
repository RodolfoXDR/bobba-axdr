<?php /* TWITTER PAGE PLUGIN */ ?>

<div class="habblet-container ">        
	<div class="cbb clearfix <?php echo self::$Colors[$jRow['Color']]; ?> ">
		<h2 class="title"><?php echo $jRow['Title']; ?> @<?php echo (Config::$Restrictions['maintenance']['twitter']);?></h2>
		<p align="center">
			<a class="twitter-timeline" data-tweet-limit="3" data-chrome="nofooter" href="https://twitter.com/<?php echo (Config::$Restrictions['maintenance']['twitter']);?>">Tweets by <?php echo (Config::$Restrictions['maintenance']['twitter']);?></a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</p>
	</div>
</div>
<script type='text/javascript'>if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>