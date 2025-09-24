<?php
if (! defined('ABSPATH')) {
	exit;
}

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
</section>

<?php get_footer(); ?>