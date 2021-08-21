<?php /* FACEBOOK PAGE PLUGIN */ ?>
<div class="plugin">
	<div class="title-facebook">Facebook: <b><?php echo (Config::$FaceBook['app']['name']);?></b></div>
	<div class="content">
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=468911076474471";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<center>
			<div class="fb-page" data-href="<?php echo Config::$FaceBook['page']['url'];?>" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo Config::$FaceBook['page']['url'];?>" class="fb-xfbml-parse-ignore"><a href="<?php echo Config::$FaceBook['page']['url'];?>"><?php echo (Config::$FaceBook['app']['name']);?></a></blockquote></div>
		</center>
	</div>
</div>