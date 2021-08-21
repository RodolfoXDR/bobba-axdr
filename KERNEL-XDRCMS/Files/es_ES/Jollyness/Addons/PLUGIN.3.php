<?php /* TWITTER PAGE PLUGIN */ ?>
<div class="plugin">
	<div class="title-twitter">Twitter: <b>@<?php echo (Config::$Restrictions['maintenance']['twitter']);?></b></div>
	<div id="content">
		<center style="margin-top: 10px;">
		<a class="twitter-timeline" data-tweet-limit="3" data-chrome="nofooter" href="https://twitter.com/<?php echo (Config::$Restrictions['maintenance']['twitter']);?>">Tweets by <?php echo (Config::$Restrictions['maintenance']['twitter']);?></a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</center>
	</div>
</div>