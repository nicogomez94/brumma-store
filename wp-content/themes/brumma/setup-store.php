<?php

if ( ! defined( 'ABSPATH' ) || ! defined( 'WP_CLI' ) ) {
	exit;
}

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

function brumma_setup_page( $title, $slug, $content = '' ) {
	$page = get_page_by_path( $slug );
	$data = array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'page',
	);
	if ( $page ) {
		$data['ID'] = $page->ID;
		wp_update_post( $data );
		return $page->ID;
	}
	return wp_insert_post( $data );
}

function brumma_setup_attachment( $filename, $title ) {
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'meta_key'       => '_brumma_source_image',
			'meta_value'     => $filename,
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}
	$source = get_template_directory() . '/assets/images/' . $filename;
	$upload = wp_upload_bits( $filename, null, file_get_contents( $source ) );
	if ( $upload['error'] ) {
		WP_CLI::warning( $upload['error'] );
		return 0;
	}
	$filetype      = wp_check_filetype( $upload['file'] );
	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => $title,
			'post_status'    => 'inherit',
		),
		$upload['file']
	);
	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );
	update_post_meta( $attachment_id, '_brumma_source_image', $filename );
	update_post_meta( $attachment_id, '_wp_attachment_image_alt', $title );
	return $attachment_id;
}

$shop_id     = (int) get_option( 'woocommerce_shop_page_id' );
$cart_id     = (int) get_option( 'woocommerce_cart_page_id' );
$checkout_id = (int) get_option( 'woocommerce_checkout_page_id' );
$account_id  = (int) get_option( 'woocommerce_myaccount_page_id' );

if ( $shop_id ) {
	wp_update_post( array( 'ID' => $shop_id, 'post_title' => 'Sabores', 'post_name' => 'sabores', 'post_content' => '' ) );
} else {
	$shop_id = brumma_setup_page( 'Sabores', 'sabores' );
}
if ( $cart_id ) {
	wp_update_post( array( 'ID' => $cart_id, 'post_title' => 'Carrito', 'post_name' => 'carrito', 'post_content' => '[woocommerce_cart]' ) );
} else {
	$cart_id = brumma_setup_page( 'Carrito', 'carrito', '[woocommerce_cart]' );
}
if ( $checkout_id ) {
	wp_update_post( array( 'ID' => $checkout_id, 'post_title' => 'Finalizar compra', 'post_name' => 'finalizar-compra', 'post_content' => '[woocommerce_checkout]' ) );
} else {
	$checkout_id = brumma_setup_page( 'Finalizar compra', 'finalizar-compra', '[woocommerce_checkout]' );
}
if ( $account_id ) {
	wp_update_post( array( 'ID' => $account_id, 'post_title' => 'Mi cuenta', 'post_name' => 'mi-cuenta', 'post_content' => '[woocommerce_my_account]' ) );
} else {
	$account_id = brumma_setup_page( 'Mi cuenta', 'mi-cuenta', '[woocommerce_my_account]' );
}

$home_id = brumma_setup_page( 'Inicio', 'inicio' );
brumma_setup_page( 'Contacto', 'contacto' );
brumma_setup_page( 'La experiencia', 'nosotros' );

update_option( 'woocommerce_shop_page_id', $shop_id );
update_option( 'woocommerce_cart_page_id', $cart_id );
update_option( 'woocommerce_checkout_page_id', $checkout_id );
update_option( 'woocommerce_myaccount_page_id', $account_id );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home_id );
update_option( 'page_for_posts', 0 );
update_option( 'blogname', 'Brumma' );
update_option( 'blogdescription', 'Espumas saborizadas para tragos y mucho más' );
update_option( 'woocommerce_currency', 'ARS' );
update_option( 'woocommerce_currency_pos', 'left' );
update_option( 'woocommerce_price_thousand_sep', '.' );
update_option( 'woocommerce_price_decimal_sep', ',' );
update_option( 'woocommerce_price_num_decimals', 0 );
update_option( 'woocommerce_coming_soon', 'no' );
update_option( 'woocommerce_store_pages_only', 'no' );
update_option(
	'woocommerce_permalinks',
	array(
		'category_base'   => 'categoria-producto',
		'tag_base'        => 'etiqueta-producto',
		'attribute_base'  => '',
		'product_base'    => '/producto',
		'use_verbose_page_rules' => false,
	)
);

$privacy_page = get_page_by_path( 'privacy-policy' );
if ( $privacy_page ) {
	wp_update_post( array( 'ID' => $privacy_page->ID, 'post_title' => 'Política de privacidad', 'post_name' => 'politica-de-privacidad' ) );
}
$refund_page = get_page_by_path( 'refund_returns' );
if ( $refund_page ) {
	wp_update_post( array( 'ID' => $refund_page->ID, 'post_title' => 'Política de cambios y devoluciones', 'post_name' => 'cambios-y-devoluciones' ) );
}
$sample_page = get_page_by_path( 'sample-page' );
if ( $sample_page ) {
	wp_trash_post( $sample_page->ID );
}

$categories = array(
	'frescos'     => 'Frescos',
	'intensos'    => 'Intensos',
	'tropicales'  => 'Tropicales',
	'especiados'  => 'Especiados',
);
$category_ids = array();
foreach ( $categories as $slug => $name ) {
	$term = term_exists( $slug, 'product_cat' );
	if ( ! $term ) {
		$term = wp_insert_term( $name, 'product_cat', array( 'slug' => $slug ) );
	}
	$category_ids[ $slug ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
}

$products = array(
	array( 'sku' => 'BRU-LIM', 'name' => 'Espuma Limón', 'slug' => 'espuma-limon', 'category' => 'frescos', 'profile' => 'Cítrica · fresca', 'description' => 'Un sabor cítrico y refrescante para coronar tragos, limonadas, cafés fríos y postres.', 'image' => 'espuma-limon.png' ),
	array( 'sku' => 'BRU-CER', 'name' => 'Espuma Cereza', 'slug' => 'espuma-cereza', 'category' => 'intensos', 'profile' => 'Dulce · frutal', 'description' => 'Dulce, intensa y de color vibrante. Ideal para cócteles rojos, postres y bebidas cremosas.', 'image' => 'espuma-cereza.png' ),
	array( 'sku' => 'BRU-MAN', 'name' => 'Espuma Mandarina', 'slug' => 'espuma-mandarina', 'category' => 'tropicales', 'profile' => 'Jugosa · brillante', 'description' => 'Jugosa y luminosa, con el dulzor justo para tragos frescos, gaseosas y cafés fríos.', 'image' => 'espuma-mandarina.png' ),
	array( 'sku' => 'BRU-MAZ', 'name' => 'Espuma Manzana Verde', 'slug' => 'espuma-manzana-verde', 'category' => 'frescos', 'profile' => 'Ácida · crocante', 'description' => 'Ácida, crocante y muy refrescante. Funciona en cócteles, limonadas y preparaciones sin alcohol.', 'image' => 'espuma-manzana-verde.png' ),
	array( 'sku' => 'BRU-FRU', 'name' => 'Espuma Frutilla', 'slug' => 'espuma-frutilla', 'category' => 'intensos', 'profile' => 'Golosa · cremosa', 'description' => 'Frutal y cremosa, pensada para milkshakes, postres, tragos dulces y helados.', 'image' => 'espuma-frutilla.png' ),
	array( 'sku' => 'BRU-SAN', 'name' => 'Espuma Sandía', 'slug' => 'espuma-sandia', 'category' => 'tropicales', 'profile' => 'Liviana · refrescante', 'description' => 'Liviana, fresca y divertida. Una aliada para bebidas de verano y preparaciones frutales.', 'image' => 'espuma-sandia.png' ),
	array( 'sku' => 'BRU-FRR', 'name' => 'Espuma Frutos Rojos', 'slug' => 'espuma-frutos-rojos', 'category' => 'intensos', 'profile' => 'Intensa · envolvente', 'description' => 'Una mezcla frutal profunda para cócteles, espumantes, postres y bebidas con mucho color.', 'image' => 'espuma-frutos-rojos.png' ),
	array( 'sku' => 'BRU-JEN', 'name' => 'Espuma Jengibre', 'slug' => 'espuma-jengibre', 'category' => 'especiados', 'profile' => 'Cálida · especiada', 'description' => 'Cálida y especiada. Ideal para sumar carácter a tragos cítricos, cafés y recetas de autor.', 'image' => 'espuma-jengibre.png' ),
);

foreach ( $products as $position => $data ) {
	$product_id = wc_get_product_id_by_sku( $data['sku'] );
	$product    = $product_id ? wc_get_product( $product_id ) : new WC_Product_Simple();
	$product->set_name( $data['name'] );
	$product->set_slug( $data['slug'] );
	$product->set_sku( $data['sku'] );
	$product->set_status( 'publish' );
	$product->set_catalog_visibility( 'visible' );
	$product->set_regular_price( '18900' );
	$product->set_price( '18900' );
	$product->set_short_description( $data['description'] );
	$product->set_description( $data['description'] . "\n\nContenido: 200 ml / 190 g. Agitá antes de usar y aplicá sobre la preparación terminada." );
	$product->set_category_ids( array( $category_ids[ $data['category'] ] ) );
	$product->set_stock_status( 'instock' );
	$product->set_manage_stock( false );
	$product->set_menu_order( $position + 1 );
	$product->set_image_id( brumma_setup_attachment( $data['image'], $data['name'] ) );
	$product_id = $product->save();
	update_post_meta( $product_id, '_brumma_profile', $data['profile'] );
	update_post_meta( $product_id, '_brumma_index', str_pad( (string) ( $position + 1 ), 2, '0', STR_PAD_LEFT ) );
	update_post_meta( $product_id, '_brumma_image_file', preg_replace( '/\.png$/', '-crop.png', $data['image'] ) );
}

flush_rewrite_rules();
WP_CLI::success( 'Tienda Brumma configurada con páginas clásicas y ocho productos.' );
