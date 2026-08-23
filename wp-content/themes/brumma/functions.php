<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function brumma_setup() {
	load_theme_textdomain( 'brumma', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'brumma_setup' );

function brumma_assets() {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'brumma-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Manrope:wght@400;500;600&display=swap', array(), null );
	wp_enqueue_style( 'brumma-icons', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', array(), '6.6.0' );
	wp_enqueue_style( 'brumma-main', get_template_directory_uri() . '/assets/css/main.css', array(), $version );
	wp_enqueue_script( 'brumma-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), $version, true );
	wp_localize_script(
		'brumma-main',
		'brummaData',
		array(
			'cartUrl'     => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/carrito/' ),
			'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/finalizar-compra/' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'brumma_assets' );

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function brumma_image_url( $filename ) {
	return get_template_directory_uri() . '/assets/images/' . $filename;
}

function brumma_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/sabores/' );
}

function brumma_cart_count() {
	return function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
}

function brumma_cart_count_fragment( $fragments ) {
	ob_start();
	?>
	<span class="cart-count"><?php echo esc_html( brumma_cart_count() ); ?></span>
	<?php
	$fragments['span.cart-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'brumma_cart_count_fragment' );

function brumma_product_card_class( $product_id ) {
	$terms = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'slugs' ) );
	return $terms && ! is_wp_error( $terms ) ? sanitize_html_class( $terms[0] ) : 'frescos';
}

function brumma_product_profile( $product_id ) {
	$profile = get_post_meta( $product_id, '_brumma_profile', true );
	return $profile ? $profile : 'Espuma saborizada';
}

function brumma_product_index( $product_id ) {
	$index = get_post_meta( $product_id, '_brumma_index', true );
	return $index ? $index : '✦';
}

function brumma_product_image_url( $product_id ) {
	$filename = get_post_meta( $product_id, '_brumma_image_file', true );
	if ( $filename && file_exists( get_template_directory() . '/assets/images/' . $filename ) ) {
		return brumma_image_url( $filename );
	}
	return wp_get_attachment_image_url( get_post_thumbnail_id( $product_id ), 'woocommerce_single' );
}

function brumma_cart_item_thumbnail( $thumbnail, $cart_item, $cart_item_key ) {
	$product = isset( $cart_item['data'] ) ? $cart_item['data'] : false;
	if ( ! $product ) {
		return $thumbnail;
	}
	$image_url = brumma_product_image_url( $product->get_id() );
	if ( ! $image_url ) {
		return $thumbnail;
	}
	return sprintf(
		'<img src="%s" alt="%s" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" loading="lazy">',
		esc_url( $image_url ),
		esc_attr( $product->get_name() )
	);
}
add_filter( 'woocommerce_cart_item_thumbnail', 'brumma_cart_item_thumbnail', 10, 3 );

function brumma_body_classes( $classes ) {
	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
		$classes[] = 'brumma-woocommerce-page';
	}
	return $classes;
}
add_filter( 'body_class', 'brumma_body_classes' );

function brumma_woocommerce_breadcrumb_defaults( $defaults ) {
	$defaults['delimiter']   = ' &nbsp;/&nbsp; ';
	$defaults['wrap_before'] = '<nav class="breadcrumb woocommerce-breadcrumb" aria-label="Navegación secundaria">';
	$defaults['wrap_after']  = '</nav>';
	$defaults['home']        = 'Inicio';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'brumma_woocommerce_breadcrumb_defaults' );

function brumma_quantity_minus() {
	echo '<button type="button" class="qty-minus" aria-label="Restar una unidad">−</button>';
}
add_action( 'woocommerce_before_quantity_input_field', 'brumma_quantity_minus' );

function brumma_quantity_plus() {
	echo '<button type="button" class="qty-plus" aria-label="Sumar una unidad">+</button>';
}
add_action( 'woocommerce_after_quantity_input_field', 'brumma_quantity_plus' );

add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
	return 'Sumar a la bolsa';
} );
