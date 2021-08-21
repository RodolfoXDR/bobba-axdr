<?php
/*=========================================================+
|| # Azure Files of XDRCMS. All rights reserved.
|| # Copyright � 2014 Xdr.
|+=========================================================+
|| # Xdr 2014. The power of Proyects.
|| # Este es un Software de c�digo libre, libre edici�n.
|+=========================================================+
*/

$n = (isset($pageid) && $pageid === 'credits') ? 2 : 3;

if(!isset($noads)): ?>
<script type="text/javascript">

if(typeof HabboView == "object") {
	HabboView.run();
}
</script>
<div id="column<?php echo $n; ?>" class="column">
<?php CACHE::AppendPlugin(5); ?>
				<div class="habblet-container ">
						<div class="ad-container">

<div class="ad_skyscpr">
			
			
		</div>

						</div>
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>
</div>
<?php endif; ?>
<!--[if lt IE 7]>
<script type="text/javascript">
Pngfix.doPngImageFix();
</script>
<![endif]-->
    </div>
<div id="footer">
        <p class="footer-links"><a href="<?php echo URL; ?>/papers/termsAndConditions" target="_new">Términos y Condiciones</a>  |  <a href="<?php echo URL; ?>/papers/privacy" target="_new">Política de Privacidad</a>  |  <a href="<?php echo URL; ?>/papers/cookies" target="_new">Política de Cookies</a></p>
        <p class="copyright">2018 aXDR 4.0. <?php echo HotelName; ?> is not affiliated with, endorsed, sponsored, or specifically approved by Sulake Corporation Oy or its Affiliates. <br/>
		All the content belongs to Sulake Corporation Oy. All rights reserved.</p>
</div></div>

</div>

<?php if(!User::$Logged): ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        EuCookiePolicy.init();
    });
</script>
<?php endif; ?>
</body>
</html>