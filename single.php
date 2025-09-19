<?php
if (! defined('ABSPATH')) {
	exit;
}

$displayed_posts = [get_the_ID()];
set_query_var('displayed_posts', $displayed_posts);

get_header(); ?>

<section id="artigos" class="py-2 md:py-8 w-full max-w-4xl mx-auto">
	<h1 class="!text-[1.375rem] md:!text-3xl font-semibold mb-4"><?php the_title(); ?></h1>
	<article id="artigo" class="w-full container mx-auto space-y-4 mb-16">
		<?php the_content(); ?>
	</article>
	<?php
	wp_link_pages([
		'before' => '<div class="page-links">Páginas: ',
		'link_before' => '<span class="page-link">',
		'link_after' => '</span>',
		'after'  => '</div>',
	]);
	?>

	<?php get_template_part('template-parts/divider'); ?>
	<?php
	if (have_posts()) :
		while (have_posts()) : the_post();
			get_template_part('template-parts/authors-card');
		endwhile;
	endif;
	?>

	<?php
	$enable_comments = get_theme_mod('enable_comments_posts', false);

	if ($enable_comments && (comments_open() || get_comments_number())) :
		comments_template();
	endif;
	?>
</section>
<?php get_template_part('template-parts/divider'); ?>

<?php get_template_part('template-parts/related-posts-section'); ?>

<?php get_footer(); ?>