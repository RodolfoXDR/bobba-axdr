<footer class="footer">
            <div class="footer__container">
                <div class="footer__row">
                    <section class="footer__column footer__column--logo">
                        <a href="#" class="footer__logo__link">
                            <h1 class="footer__logo">Hekos</h1>
                        </a>
                    </section>
                  
                </div>
                <section class="footer__bottom">
                    <ul>
                        <li class="footer__bottom__item">
                            © 2018 aXDR CMS 4.0 ~ Hekos Hotel
                        </li>
                        <li class="footer__bottom__item">
                            <a href="<?php echo URL; ?>/papers/privacy">Políticas de Privacidad</a>
                        </li>
                        <li class="footer__bottom__item">
                            <a href="<?php echo URL; ?>/papers/termsAndConditions">Términos & Condiciones</a>
                        </li>
                        <li class="footer__bottom__item">
                                <a href="<?php echo URL; ?>/papers/cookies">Políticas de Cookies</a>
                        </li>
                    </ul>
                </section>
                <section class="footer__bottom last">
                        <ul>
                            <li class="footer__bottom__item">
                                Diseñada por <b>Gab</b> | Programada por <b>Xdr</b> & <b>Mr.Mustache</b>
                            </li>
                        </ul>
                    </section>
            </div>
        </footer>
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