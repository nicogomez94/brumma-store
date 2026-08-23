<footer class="site-footer">
	<div class="footer-brand"><a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">BRUMMA</a><p>Espumas aromáticas para<br>coctelería de autor.</p></div>
	<div class="footer-links">
		<div><h4>Explorar</h4><a href="<?php echo esc_url( brumma_shop_url() ); ?>">Sabores</a><a href="<?php echo esc_url( home_url( '/nosotros/' ) ); ?>">La experiencia</a><a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">Contacto</a></div>
		<div><h4>Conectar</h4><a href="https://www.instagram.com/brumma.arg/" target="_blank" rel="noopener">Instagram</a><a href="https://wa.me/5491100000000" target="_blank" rel="noopener">WhatsApp</a><a href="mailto:hola@brumma.com.ar">Email</a></div>
	</div>
	<div class="footer-bottom"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Brumma</span><span>Beber con moderación. +18</span><span>Tienda oficial</span></div>
</footer>
<a class="whatsapp-float" href="https://wa.me/5491100000000?text=Hola%20Brumma%2C%20quiero%20conocer%20más" target="_blank" rel="noopener" aria-label="Escribir por WhatsApp"><i class="fa-brands fa-whatsapp"></i><span>Hablemos</span></a>
<aside class="cart-drawer" aria-hidden="true" aria-label="Tu bolsa">
	<button class="cart-close" type="button" aria-label="Cerrar bolsa"><i class="fa-solid fa-xmark"></i></button>
	<p class="eyebrow">Tu selección</p><h2>La bolsa</h2>
	<div class="widget_shopping_cart_content"><?php function_exists( 'woocommerce_mini_cart' ) && woocommerce_mini_cart(); ?></div>
</aside>
<div class="drawer-backdrop"></div>
<?php wp_footer(); ?>
</body>
</html>

