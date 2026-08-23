<?php
$product = isset( $args['product'] ) ? $args['product'] : wc_get_product( get_the_ID() );
if ( ! $product ) {
	return;
}
$product_id = $product->get_id();
$category   = brumma_product_card_class( $product_id );
?>
<article <?php wc_product_class( 'product-card fade-in', $product ); ?> data-category="<?php echo esc_attr( $category ); ?>">
	<a class="product-card-link" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<div class="product-art <?php echo esc_attr( $category ); ?>">
			<span class="flavor-index"><?php echo esc_html( brumma_product_index( $product_id ) ); ?></span>
			<img class="product-photo" src="<?php echo esc_url( brumma_product_image_url( $product_id ) ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" loading="lazy">
		</div>
		<div class="product-info"><div><p><?php echo esc_html( brumma_product_profile( $product_id ) ); ?></p><h3><?php echo esc_html( $product->get_name() ); ?></h3></div><span><?php echo wp_kses_post( $product->get_price_html() ); ?></span></div>
	</a>
	<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
		<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="quick-add add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" aria-label="Sumar <?php echo esc_attr( $product->get_name() ); ?> a la bolsa">Sumar a la bolsa <i class="fa-solid fa-plus"></i></a>
	<?php endif; ?>
</article>
