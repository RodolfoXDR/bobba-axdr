		</div>

		<!-- Vendor -->
		<script src="xdr-web/web-080220172043/vendor/jquery/jquery.js"></script>
		<script src="xdr-web/web-080220172043/vendor/jquery.appear/jquery.appear.js"></script>
		<script src="xdr-web/web-080220172043/vendor/jquery.easing/jquery.easing.js"></script>
		<script src="xdr-web/web-080220172043/vendor/jquery-cookie/jquery-cookie.js"></script>
		<script src="xdr-web/web-080220172043/vendor/bootstrap/bootstrap.js"></script>
		<script src="xdr-web/web-080220172043/vendor/common/common.js"></script>
		<script src="xdr-web/web-080220172043/vendor/jquery.validation/jquery.validation.js"></script>
		<script src="xdr-web/web-080220172043/vendor/jquery.stellar/jquery.stellar.js"></script>
		<script src="xdr-web/web-080220172043/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
		<script src="xdr-web/web-080220172043/vendor/jquery.gmap/jquery.gmap.js"></script>
		<script src="xdr-web/web-080220172043/vendor/isotope/jquery.isotope.js"></script>
		<script src="xdr-web/web-080220172043/vendor/owlcarousel/owl.carousel.js"></script>
		<script src="xdr-web/web-080220172043/vendor/jflickrfeed/jflickrfeed.js"></script>
		<script src="xdr-web/web-080220172043/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="xdr-web/web-080220172043/vendor/vide/vide.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="xdr-web/web-080220172043/js/theme.js"></script>
		
		<!-- Specific Page Vendor and Views -->
		<script src="xdr-web/web-080220172043/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="xdr-web/web-080220172043/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
		<script src="xdr-web/web-080220172043/vendor/circle-flip-slideshow/js/jquery.flipshow.js"></script>
		<script src="xdr-web/web-080220172043/js/views/view.home.js"></script>
		
		<!-- Theme Custom -->
		<script src="xdr-web/web-080220172043/js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="xdr-web/web-080220172043/js/theme.init.js"></script>
		
		<script type="text/javascript">
			function getUsers() {
				$.get('online.php', function(data) {
					$('.reload_users').html(data); 
				}); setTimeout(getUsers, 200);
			}

			$(document).ready(function(){
				getUsers(); 
			});
		</script>

	</body>
</html>