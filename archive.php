<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<section id="archive" class="py-8">
	<div class="container mx-auto">
		<h1 class="text-2xl font-semibold mb-8">
			<?php echo get_the_archive_title(); ?>
		</h1>

		<div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr(get_theme_mod('related_posts_page_number', 3)%4 === 0 ? 4 : 3 ); ?>  gap-8">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('partials/post-card'); ?>
			<?php endwhile; ?>
		</div>

		<?php get_template_part('template-parts/navigation'); ?>
	</div>
</section>

<?php get_footer(); ?>