<?php
get_header();
while ( have_posts() ) :
	the_post();
	$product = wc_get_product( get_the_ID() );
	woocommerce_breadcrumb();
?>
<main>
	<section class="detail-section">
		<div class="detail-art fade-in"><img class="detail-product-photo" src="<?php echo esc_url( brumma_product_image_url( $product->get_id() ) ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" loading="eager"><span class="detail-tag">200 ML · ESPUMA SABORIZADA</span></div>
		<div class="detail-copy fade-in"><p class="eyebrow"><?php echo esc_html( brumma_product_profile( $product->get_id() ) ); ?></p><h1><?php the_title(); ?></h1><div class="detail-subtitle"><?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?></div><div class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div><hr class="detail-rule"><?php woocommerce_template_single_add_to_cart(); ?><div class="detail-benefits"><p><i class="fa-solid fa-truck"></i> Envíos a todo el país</p><p><i class="fa-solid fa-wand-magic-sparkles"></i> Aplicación directa y simple</p><p><i class="fa-solid fa-martini-glass"></i> Para bebidas, helados y postres</p></div></div>
	</section>
	<section class="section pairing-section"><div class="section-heading fade-in"><p class="eyebrow">Ideas para usarla</p><h2>No se queda sólo en la barra.</h2><p>Una misma espuma puede cambiar por completo distintas preparaciones.</p></div><div class="pairing-grid"><article class="pair-card fade-in"><span>01 · TRAGOS</span><h3>Gin & tónica</h3><p>Una capa aromática que suma textura y un final fresco.</p></article><article class="pair-card fade-in"><span>02 · SIN ALCOHOL</span><h3>Limonadas</h3><p>Color, volumen y sabor para bebidas simples y refrescantes.</p></article><article class="pair-card fade-in"><span>03 · DULCE</span><h3>Helados y postres</h3><p>Un acabado cremoso y listo para servir en segundos.</p></article></div></section>
	<section class="section faq-section"><div class="section-heading fade-in"><p class="eyebrow">El producto</p><h2>Todo lo que suma.</h2></div><div class="faq-list fade-in"><div class="faq-item"><button class="faq-question" type="button">¿Dónde se puede usar?<i class="fa-solid fa-plus"></i></button><div class="faq-answer"><p>En tragos con o sin alcohol, cafés, milkshakes, jugos, helados y distintos tipos de postres.</p></div></div><div class="faq-item"><button class="faq-question" type="button">Uso y conservación<i class="fa-solid fa-plus"></i></button><div class="faq-answer"><p>Agitá antes de usar, sostené el envase en posición vertical y aplicá sobre la preparación terminada.</p></div></div><div class="faq-item"><button class="faq-question" type="button">Contenido del envase<i class="fa-solid fa-plus"></i></button><div class="faq-answer"><p>Cada presentación contiene 200 ml / 190 g de espuma saborizada.</p></div></div></div></section>
</main>
<?php endwhile; get_footer(); ?>
