	<div id="footer">
		<div id="inf">
			<h2><?php echo HotelName; ?></h2>
			<p style="margin-bottom: 10px;">Designed by <b>Mr.Mustache</b></p>
			<p style="font-size: 14px;">Developed by <b>Xdr</b></p>
			<p id="rights">All rights reserved <b><?php echo HotelName; ?></b></p>
		</div>
		<div id="habboimg"></div>
		<div id="icons">
			<div class="axdr"></div>
			<div class="synapse"></div>
		</div>
	</div>
	
    <script src="<?php echo RES; ?>JS/jquery-2.1.4.min.js"></script>
	<script src="<?php echo RES; ?>JS/materialize.js"></script>
	<script src="<?php echo RES; ?>JS/skrollr.min.js"></script>

	<script>
		$(document).ready(function () {
			skrollr.init({ smoothScrolling: true });
		});
		//# sourceURL=pen.js
	</script>

	<script>
		$(document).ready(function(){
		  $('.slider').slider({full_width: true});
		});
	</script>
    
    <script>	
	  if (document.location.search.match(/type=embed/gi)) {
		window.parent.postMessage("resize", "*");
	  }
	</script>
</body></html>