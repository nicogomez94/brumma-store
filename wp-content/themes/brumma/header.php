<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="announcement"><span>Envíos a todo el país</span><span class="announcement-dot"></span><span>Producción artesanal</span></div>
<header class="site-header">
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Brumma, inicio">BRUMMA</a>
	<button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false"><span></span><span></span></button>
	<nav class="main-nav" aria-label="Navegación principal">
		<a class="<?php echo is_front_page() ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a>
		<a class="<?php echo ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() ) ) ? 'active' : ''; ?>" href="<?php echo esc_url( brumma_shop_url() ); ?>">Sabores</a>
		<a class="<?php echo is_page( 'nosotros' ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/nosotros/' ) ); ?>">La experiencia</a>
		<a class="<?php echo is_page( 'contacto' ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">Contacto</a>
	</nav>
	<button class="cart-trigger" type="button" aria-label="Abrir bolsa"><i class="fa-solid fa-bag-shopping"></i><span class="cart-count"><?php echo esc_html( brumma_cart_count() ); ?></span></button>
</header>

