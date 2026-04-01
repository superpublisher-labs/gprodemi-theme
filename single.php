<?php
if (! defined('ABSPATH')) {
	exit;
}

$displayed_posts = [get_the_ID()];
set_query_var('displayed_posts', $displayed_posts);

get_header();
?>

<section id="artigos" class="py-2 md:py-8 w-full max-w-4xl mx-auto">

	<?php
	if (have_posts()) :
		while (have_posts()) : the_post();
	?>
			<h1 class="!text-[1.375rem] md:!text-3xl font-semibold mb-4"><?php the_title(); ?></h1>
			<article id="artigo" class="w-full container mx-auto space-y-4 mb-10">
				<?php the_content(); ?>
			</article>

			<?php
			wp_link_pages([
				'before' => '<div class="page-links">' . __('Pages:', 'gprodemi') . ' ',
				'link_before' => '<span class="page-link">',
				'link_after' => '</span>',
				'after'  => '</div>',
			]);
			?>

			<div class="flex flex-col items-start gap-2 mb-10">
				<span class="text-gray-600 !text-sm">
					<?php printf(__('Published on %s', 'gprodemi'), get_the_date('F j, Y')); ?>
				</span>
				<div class="flex flex-row items-center gap-2">
					<?php foreach (get_the_category() as $category): ?>
						<span class="bg-[var(--color-botao)] px-2 flex items-center rounded-full">
							<a href="<?php echo get_category_link($category->term_id); ?>" class="!text-white !text-sm !font-medium !no-underline">
								<?php echo esc_html($category->name); ?>
							</a>
						</span>
					<?php endforeach; ?>
				</div>
			</div>

			<?php get_template_part('template-parts/divider'); ?>

			<?php
			get_template_part('template-parts/authors-card');
			?>

	<?php
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