<?php get_header(); ?>
<main class="section page-content">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><article <?php post_class( 'content-card' ); ?>><h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1><?php the_excerpt(); ?></article><?php endwhile; else : ?><p>No hay contenido disponible.</p><?php endif; ?>
</main>
<?php get_footer(); ?>

