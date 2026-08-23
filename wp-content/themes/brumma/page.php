<?php get_header(); ?>
<main class="section page-content">
	<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class( 'content-card' ); ?>><p class="eyebrow">Brumma</p><h1><?php the_title(); ?></h1><div class="entry-content"><?php the_content(); ?></div></article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>

