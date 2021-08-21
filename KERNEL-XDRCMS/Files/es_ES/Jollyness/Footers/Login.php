<div id="footer" class="main">
	<div id="inf">
		<h2><?php echo HotelName; ?></h2>
		<!--<p style="margin-bottom: 10px; color: #7d7d7d;">Developed by <b>Xdr</b></p>-->
		<p>Designed by <b>Mr.Mustache</b></p>
		<p id="rights">All rights reserved <b><?php echo HotelName; ?></b> | <a href="<?php echo URL; ?>/papers/privacy">Politicas de Privacidad</a> | <a href="<?php echo URL; ?>/papers/termsAndConditions">Terminos y Condiciones</a> | <a href="<?php echo URL; ?>/papers/cookies">Politicas de Cookies</a> </p>
	</div>
	<div id="habboimg"></div>
	<div id="icons">
		<div class="ifoster"></div>
		<div class="axdr"></div>
	</div>
</div>
	
</div>

    <script src="<?php echo RES ?>JS/jquery-2.1.4.min.js"></script>
	<script src="<?php echo RES ?>JS/skrollr.min.js"></script>

        <script>
      $(document).ready(function () {
    skrollr.init({ smoothScrolling: true });
});
    </script>

    
    <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>

    
  

 
</body></html>